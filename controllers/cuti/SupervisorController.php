<?php

namespace app\controllers\cuti;

use app\models\cuti\AksesPengguna;
use app\models\cuti\CutiAdjustment;
use app\models\cuti\CutiBatal;
use app\models\cuti\CutiLog;
use app\models\cuti\CutiOpenApplication;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\cuti\CutiRekod;
use app\models\cuti\CutiTblBod;
use app\models\cuti\CutiUmum;
use app\models\cuti\GcrApplication;
use app\models\cuti\Layak;
use app\models\cuti\JenisCuti;
use app\models\cuti\TblRecords;
use yii\web\UploadedFile;
use app\models\cuti\TblRecordsSearch;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\cuti\SetPegawai;
use app\models\hronline\TblprcobiodataSearch;
use app\models\hronline\Tblrscoapmtstatus;
use app\models\Notification;
use app\models\cuti\Model;
use app\models\cuti\TblManagement;
use app\models\keselamatan\TblShiftKeselamatan;
use Exception;
use kartik\mpdf\Pdf;
use phpDocumentor\Reflection\Types\Null_;
use tebazil\runner\ConsoleCommandRunner;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class SupervisorController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                // 'roles' => ['@'],
                'rules' => [
                    [
                        // 'actions' => ['*'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $check = AksesPengguna::find()->where(['akses_cuti_icno' => $logicno])->exists();


                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    //temporary saja dlu... tukar kepada main.php nnt
    //    public $layout = 'main_attandance.php';

    public function actionSickLeaveList()
    {
        $icno = Yii::$app->user->getId();

        $model = TblRecords::find()->where(['semakan_by' => $icno, 'status' => 'ENTRY'])->andWhere(['IN', 'jenis_cuti_id', ['20', '21', '58']])->all();

        $app = TblRecords::find()->where(['lulus_by' => $icno, 'status' => 'VERIFIED'])->all();

        return $this->render('sick-leave-list', [
            'model' => $model,
            'app' => $app,
        ]);
    }

    public function actionLeaveDetailSl($id)
    {

        $model = TblRecords::findOne($id);
        $id = $model->jenis_cuti_id;
        // echo($model->icno);die;

        $model_jenis = JenisCuti::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->semakan_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                $this->Notification($model->icno, 'Cuti', 'Permohonan Cuti Sakit Anda Telah Di Periksa Oleh Penyelia Cuti dan Sedang Menunggu Kelulusan Pegawai Pelulus Anda');
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$model->lulus_by]);
                $runner->run('dashboard/pending-task-individu', [$model->semakan_by]);
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['cuti/supervisor/sick-leave-list']);
            }
        }
        return $this->renderAjax('leave-detail-sl', ['model' => $model]);
    }

    //Pelulus Approve cs1
    public function actionPeraku()
    {
        if ($post = Yii::$app->request->post()) {

            $rekod = TblRecords::findOne(['id' => $post['id']]);
            $rekod->status = 'CHECKED';
            $rekod->semakan_dt = date('Y-m-d H:i:s');
            if ($rekod->save()) {

                $this->Notification($rekod->icno, 'Cuti', 'Permohonan Cuti Sakit Anda Telah Di Periksa Oleh Penyelia Cuti dan Sedang Menunggu Kelulusan Pegawai Pelulus Anda');
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$rekod->lulus_by]);
                $runner->run('dashboard/pending-task-individu', [$rekod->semakan_by]);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Record Updated!']);
                return $this->redirect(['cuti/supervisor/sick-leave-list']);
            }
        }
    }
    /**
     * ni utk pilih cuti dan utk redirect action tu ikut jenis cuti, sila rujuk table jenis cuti
     */

    public function Notification($icno, $title, $content)
    {
        $ntf = new Notification();
        $ntf->icno = $icno;
        $ntf->title = $title;
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
    }

    public function actionCs1($id, $form)
    {

        $model = new TblRecords();
        $model->scenario = "cs1";

        $staff_list = Tblprcobiodata::find()->where(['Status' => 1])->asArray()->all();

        $model_jenis = JenisCuti::findOne($id);

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $model_department = Department::findOne(['id' => $biodata->DeptId]);

        $sick_leave_verifier = AksesPengguna::find()->where(['akses_cuti_int' => 2])->andWhere(['akses_jspiu_id' => $biodata->DeptId])->all();
        // var_dump($sick_leave_verifier );die;
        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $icno;
            $model->jenis_cuti_id = $id;
            $model->tempoh = $model->totalDays;
            $model->mohon_dt = date('Y-m-d H:i:s');
            $model->peraku_by = $model_department->chief;
            //file
            $model->file = UploadedFile::getInstance($model, 'file');
            $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '05', 'Medical Certificate');

            if ($datas->status == true) {
                $model->file_hashcode = $datas->file_name_hashcode;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
                return $this->redirect(['cuti/individu/index']);
            }
        }

        return $this->render("form/" . $form, [
            'model' => $model,
            'staff_list' => $staff_list,
            'model_jenis' => $model_jenis,
            'icno' => $icno,
            'model_department' => $model_department,
            'sick_leave_verifier' => $sick_leave_verifier,
        ]);
    }

    /**
     * ni utk semakan oleh bahagian sumber manusia, Kak rosnah setakat ni.
     */
    public function actionSemakanList()
    {

        //        $icno = Yii::$app->user->getId();

        $searchModel = new TblRecordsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('semakan-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSemakanUpdate($id)
    {

        $model = TblRecords::findOne(['id' => $id]);
        $model->scenario = "semakan";

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::findAll(['Status' => 1]);

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }


        if ($model->load(Yii::$app->request->post())) {

            $model->semakan_by = $icno;
            $model->semakan_dt = date('Y-m-d H:i:s');


            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Semakan telah dikemaskini!']);
                return $this->redirect(['cuti/semakan-list']);
            }
        }

        return $this->renderAjax('semakan-update', [
            'model' => $model,
            'biodata' => $biodata,
        ]);
    }



    public function actionLeaveDetail($id)
    {

        $model = TblRecords::findOne($id);

        return $this->renderAjax('leave-detail', ['model' => $model]);
    }
    public function actionIndex()
    {
        $carian = new Tblprcobiodata();
        $dataProvider = $carian->carian(Yii::$app->request->queryParams);

        return $this->render('index', [
            'carian' => $carian,
            'model' => $dataProvider,
        ]);
    }
    public function actionSupervisedStaff()
    {
        $carian = new Tblprcobiodata();
        $id = Yii::$app->request->queryParams;
        $icno = Yii::$app->user->getId();
        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $dataProvider = $carian->carianCuti(Yii::$app->request->queryParams);
        // }
        return $this->render('supervised-staff', [
            'carian' => $carian,
            'model' => $dataProvider,
            'bil' => 1
        ]);
    }

    public function actionSetLeave($id)
    {
        $icno = Yii::$app->user->getId();

        // Yii::$app->session->setFlash('alert', ['title' => 'Alert', 'type' => 'info', 'msg' => 'Harap Maaf, Penyelenggaraan Sedang Dijalankan']);
        // return $this->redirect(['cuti/supervisor/supervised-staff']);
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $layak = Layak::find()->where(['layak_icno' => $id])->orderBy(['layak_mula' => SORT_DESC])->all();
        $yr = date('Y');
        $bsm = AksesPengguna::find()->where(['akses_cuti_icno' => $icno])->andWhere(['akses_cuti_int' => 3])->exists();

        return $this->render('set-leave', [
            // 'searchModel' => $searchModel,
            'biodata' => $biodata,
            'layak' => $layak,
            'id' => $id,
            'curr' => $yr,
            'bsm' => $bsm,
        ]);
    }
    public function actionGcrList()
    {
        $id = Yii::$app->user->getId();

        $gcr = GcrApplication::find()->where(['semakan_by' => $id])->andWhere(['status' => 'ENTRY'])->orderBy(['mohon_dt' => SORT_ASC])->all();
        // $layak = Layak::find()->where(['layak_icno' => $id])->orderBy(['layak_mula' => SORT_DESC])->all();
        return $this->render('gcr-list', [
            // 'searchModel' => $searchModel,
            // 'biodata' => $biodata,
            // 'layak' => $layak,
            'gcr' => $gcr,
            'id' => $id,
            'bil' => 1,

        ]);
    }

    //kalau mau ada pukal2
    // public function actionSenarai_tindakan()
    // {

    //     $icno = Yii::$app->user->getId();

    //     $tindakan = Tindakan::find()->where(['icno_tindakan' => $icno])->one();

    //     if ($tindakan) {
    //         $icno = $tindakan->icno_pemberi_kuasa;
    //     }

    //     $lulus = TblRekod::findAll(['app_by' => $icno, 'remark_status' => 'ENTRY']);


    //     if ($pilih = Yii::$app->request->post()) {

    //         foreach ($pilih['TblRekod']['id'] as $k => $v) {
    //             if ($v != 0) {
    //                 $model = TblRekod::findOne($v);
    //                 $model->remark_status = 'APPROVED';
    //                 $model->app_dt = date('Y-m-d H:i:s');

    //                 if ($model->save()) {

    //                     //----------Model Notification ---------//
    //                     $ntf = new Notification();
    //                     $ntf->icno = $model->icno;
    //                     $ntf->title = 'Kehadiran';
    //                     $ntf->content = "Status pengesahan Ketidakpatuhan pada $model->formatTarikh ($model->day) telah disahkan";
    //                     $ntf->ntf_dt = date('Y-m-d H:i:s');
    //                     $ntf->save();
    //                 }
    //             }
    //         }
    //         //--------Model Notification-----------//
    //         Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan Ketidakpatuhan telah dihantar!']);
    //         return $this->redirect(['kehadiran/senarai_tindakan']);
    //     }


    //     return $this->render('senarai_tindakan', [
    //         'lulus' => $lulus,
    //         'bil' => 1,
    //     ]);
    // }


    public function actionPrintEntitlementStatement($id)
    {
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $layak = Layak::find()->where(['layak_icno' => $id])->orderBy(['layak_mula' => SORT_DESC])->all();
        $date =  Yii::$app->MP->Tarikh(date("Y-m-d"));
        $time = date("H:i:s");
        $this->view->title = "MAKLUMAT KELAYAKAN CUTI ()";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_printEntitlementStatement', [
            'id' => $id,
            'layak' => $layak,
            'biodata' => $biodata,
        ]);
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Penyata Kelayakan Cuti $biodata->CONm.pdf",
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => "Maklumat Kelayakan Cuti $biodata->CONm"],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["UNIVERSITI MALAYSIA SABAH||Penyata Kelayakan Cuti $biodata->CONm"],
                'SetFooter' => ["INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN DICETAK PADA $date,$time ||{PAGENO}"],
                //    'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    public function actionUpdatePp($id)
    {
        $icno = Yii::$app->user->getId();

        $model = SetPegawai::findOne(['pemohon_icno' => $id]);
        if (!$model) {
            $model = new SetPegawai();
        }
        if ($model->load(Yii::$app->request->post())) {
            // if (!$model) {
                // echo 'd';die;
                $model->pemohon_icno = $id;
            // }
            $model->penyelia_set_icno = $icno;

            // $model->set_datestamp = date('h:i:s Y-m-d');


            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Approver / Verifier Changed!']);
                return $this->redirect(['cuti/supervisor/update-pp', 'id' => $id]);
            }
        }
        $bio = Tblprcobiodata::findOne(['ICNO' => $id]);
        // $layak = Layak::find()->where(['layak_icno' => $id])->orderBy(['layak_mula' => SORT_DESC])->all();
        return $this->render('update-pp', [
            // 'searchModel' => $searchModel,
            'model' => $model,
            'id' => $id,
            'bio' => $bio,
        ]);
    }


    public function actionLeaveDetails($id)
    {

        $model = TblRecords::findOne($id);
        $biodata = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
        $pengganti = Tblprcobiodata::findOne(['ICNO' => $model->ganti_by]);
        $peraku = Tblprcobiodata::findOne(['ICNO' => $model->peraku_by]);
        $pelulus = Tblprcobiodata::findOne(['ICNO' => $model->lulus_by]);
        $semak = Tblprcobiodata::findOne(['ICNO' => $model->semakan_by]);
        $dataProvider = TblRecords::find()->where(['icno' => $model->icno])->andWhere(['YEAR(start_date)' => date('Y')])->all();

        return $this->renderAjax('leave-details', [
            'model' => $model,
            'biodata' => $biodata,
            'pengganti' => $pengganti,
            'peraku' => $peraku,
            'pelulus' => $pelulus,
            'semak' => $semak,
            'bil' => 1,
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionSvGcrVerify($id)
    {

        $model = GcrApplication::findOne($id);
        // $model->scenario = "agree";

        if ($model->load(Yii::$app->request->post())) {

            $model->semakan_dt = date('Y-m-d H:i:s');
            if ($model->peraku_by == $model->lulus_by) {
                $model->status = 'VERIFIED';
            }
            // $model->semakan_dt = "CHECKED";
            // $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['cuti/supervisor/gcr-list']);
            }
        }
        return $this->renderAjax('sv-gcr-verify', ['model' => $model]);
    }
    public function actionPrintCapture($id, $year = null, $type)
    {
        if ($year != NULL) {

            $end_sql = 'SELECT * FROM hrm.cuti_tbl_records a
        
    WHERE icno=:icno AND a.jenis_cuti_id =:jenis AND YEAR(a.start_date)=:year';
            $model = TblRecords::findBySql($end_sql, [':icno' => $id, ':jenis' => $type, 'year' => $year])->all();
        } else {
            $end_sql = 'SELECT * FROM hrm.cuti_tbl_records a
        
    WHERE icno=:icno AND a.jenis_cuti_id =:jenis';
            $model = TblRecords::findBySql($end_sql, [':icno' => $id, ':jenis' => $type])->all();
        }
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_id' => $type])->one();

        $this->view->title = "MAKLUMAT PERMOHONAN ($jenis_cuti->jenis_cuti_nama .''. $jenis_cuti->jenis_cuti_catatan)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_printCapture', [
            'model' => $model,
            'biodata' => $biodata,
            'id' => $id,
            'year' => $year,
            'type' => $type,
            'bil' => 1,
            // 'dataProvider' => $dataProvider
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Maklumat Cuti $biodata->CONm.pdf",
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => "Maklumat Cuti $biodata->CONm"],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["UNIVERSITI MALAYSIA SABAH||Maklumat Cuti $biodata->CONm"],
                'SetFooter' => ['INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN||{PAGENO}'],
                //                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    public function actionBackOnDuty($id)
    {

        $exist = CutiTblBod::find()->where(['IN', 'status', ['1', '2', '3']])->all();
        $data = [];
        foreach ($exist as $a) {
            $data[] = $a->record_id;
        }
        $query = TblRecords::find()
            ->where(['IN', 'status', ['APPROVED']])->andWhere(['jenis_cuti_id' => 28])
            ->andWhere(['icno' => $id])->andWhere(['>=', 'YEAR(start_date)', '2021'])
            ->andWhere(['NOT IN', 'id', $data]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('back-on-duty', [
            'dataProvider' => $dataProvider,

        ]);
    }
    public function actionBod($id)
    {
        $icno = Yii::$app->user->getId();
        $model = new CutiTblBod();
        $cuti = TblRecords::findOne(['id' => $id]);
        $bio = Tblprcobiodata::find()->where(['ICNO' => $cuti->icno])->one();
        $dept = Department::find()->where(['id' => $bio->DeptId])->one();
        $manage = TblManagement::findOne(['user' => 'cuti']);
        if ($model->load(Yii::$app->request->post())) {

            // var_dump($model->date_bod);die;
            $model->record_id = $id;
            $model->date_semakan = date('Y-m-d');
            $model->semakan_id = $icno;
            $model->pelulus_id = $dept->chief;
            $model->bsm_id = $manage->icno;
            $model->icno = $cuti->icno;
            if ($model->save()) {
                $this->logs(Yii::$app->user->getId(), $id, "Kembali Bertugas");
                $this->Notification($dept->chief, 'Cuti', "$bio->CONm" . ' Telah Kembali Bertugas Pada ' . $model->date_bod . '. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/bod-list">disini</a> untuk membuat tindakan');
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$dept->chief]);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notikasi dihantar kepada Ketua Jabatan / Dekan!']);
                return $this->redirect(['cuti/supervisor/supervised-staff']);
            }
        }
        return $this->renderAjax('bod', [
            // 'dataProvider' => $dataProvider,
            'model' => $model,

        ]);
    }
    public function actionLeaveListSv($id)
    {

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $layak = Layak::find()->where(['layak_icno' => $id])->orderBy(['layak_mula' => SORT_DESC])->all();

        $carian = new TblRecords();
        $model = Layak::find()->where(['layak_icno' => $id])->groupBy(['YEAR(layak_mula)'])->orderBy(['YEAR(layak_mula)' => SORT_DESC])->all();

        $admin = AksesPengguna::find()->where(['akses_cuti_icno' => Yii::$app->user->getId()])->andWhere(['akses_cuti_int' => 3])->andWhere(['akses_jspiu_id' => 158])->exists();
        $data = [];

        $first = Tblrscoapmtstatus::find()->where(['ICNO' => $id])->one();
        $yr = date("Y", strtotime(date("Y-m-d") . " + 1 year"));

        $data[0] = "Show All";
        $data[$yr] = $yr;
        foreach ($model as $v) {
            $data[$v->tahun] = $v->tahun;
        }

        // var_dump($yr);die;
        $params = Yii::$app->request->queryParams;

        $searchModel = new TblRecordsSearch();
        $indi = 0;

        if (empty($params["TblRecordsSearch"]['carian_tahun'])) {

            // $indi = 1;
            if (!empty($params["TblRecordsSearch"]['jenis_cuti_id'])) {
                $indi = 1;

                $query = TblRecords::find()
                    ->where(['icno' => $id])
                    ->andWhere([
                        'jenis_cuti_id' => $params["TblRecordsSearch"]['jenis_cuti_id'],
                    ]);
            } else {

                $query = TblRecords::find()
                    ->where(['icno' => $id])
                    ->andWhere([
                        'or', ['YEAR(start_date)' => date('Y')], ['YEAR(end_date)' => date('Y')]
                    ]);
            }


            // ->andWhere(['IN', 'gredJawatan', ['118', '119', '295', '302', '303', '360', '388', '389', '43', '44', '116', '117', '211', '413']]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 250,
                ],
            ]);
        } else {
            $indi = 1;

            $dataProvider = $searchModel->searchleave(Yii::$app->request->queryParams);
        }

        return $this->render('leave-list-sv', [
            // 'searchModel' => $searchModel,
            'biodata' => $biodata,
            'layak' => $layak,
            'id' => $id,
            'model' => $dataProvider,
            'searchModel' => $searchModel,
            'bil' => 1,
            'data' => $data,
            'first' => $first,
            'admin' => $admin,
            'indi' => $indi
        ]);
    }
    public function Log($icno, $id, $ori_fd, $ori_sd, $ori_ed)
    {
        $log = new CutiLog();

        $log->ntf_session_id = $icno;
        $log->ntf_tindakan = "Approve&Change";
        $log->ntf_status = "APPROVED";
        $log->ntf_cr_id = $id;
        $log->ntf_datetime = date('Y-m-d h:i:s');
        $log->full_date = $ori_fd;
        $log->start_date = $ori_sd;
        $log->end_date = $ori_ed;
        $log->save();
    }
    // public function Layaklog($icno, $status = null,$type=null)
    public function Layaklog($icno, $status = null)
    {
        $log = new CutiLog();

        $id = Yii::$app->db->getLastInsertID();

        $log->ntf_session_id = $icno;
        // $log->log_type = $type;
        // var_dump($status);die;
        if (!$status) {
            $log->ntf_tindakan = "Tambah Kelayakan";
            $log->ntf_cr_id = $id;
        } else {
            $log->ntf_tindakan = "Kemaskini Kelayakan";
            $log->ntf_cr_id = $status;
        }

        $log->ntf_datetime = date('Y-m-d h:i:s');

        $log->save();
    }
    public function logs($icno, $id, $tindakan, $status = null)
    {
        $log = new CutiLog();

        // $id = Yii::$app->db->getLastInsertID();

        $log->ntf_session_id = $icno;
        $log->ntf_tindakan = $tindakan;
        $log->ntf_cr_id = $id; // id to refer
        $log->ntf_status = $status; // status

        $log->ntf_datetime = date('Y-m-d h:i:s');

        $log->save();
    }

    public function actionAdjustGcr($id, $icno)
    {
        // $layak = Layak::getLatestLayak($icno);
        $bsm = Yii::$app->user->getId();

        $model = Layak::findOne(['layak_id' => $id]);
        $date = date('Y', strtotime($model->layak_mula));
        $gcr = GcrApplication::find()->where(['YEAR(mohon_dt)' => $date])->andWhere(['pemohon_icno' => $icno])->one();
        $adjust = new CutiAdjustment();
        $model->scenario = 'adjust';

        // var_dump($model->layak_mula);die;
        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);
        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            if ($gcr) {
                $gcr->gcr_applied = $model->tempv3;
                $gcr->cbth_applied = $model->layak_bawa_depan;
                $gcr->save(false);
            }
            $adjust->layak_mula = $model->layak_mula;
            $adjust->layak_tamat = $model->layak_tamat;
            $adjust->icno = $model->layak_icno;
            $adjust->cbth_selaras = $model->layak_bawa_depan;
            $adjust->gcr_selaras = $model->tempv3;
            $adjust->hapus_selaras = $model->layak_hapus;
            $adjust->adjust_by = $bsm;
            $adjust->date_created = date('Y-m-d h:i:s');
            $adjust->save(false);



            // var_dump($gcr->gcr_applied);die;

            $model->layak_gcr = $model->tempv3;
            // if ($model->save()) {
            $model->save(false);
            $this->logs(Yii::$app->user->getId(), $id, "Adjustment GCR");

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Penyelarasan telah dihantar!']);
            return $this->redirect(['cuti/supervisor/set-leave', 'id' => $icno]);
            // }
        }
        return $this->render('adjust-gcr', [
            'model' => $model,
            'icno' => $icno,
            'biodata' => $biodata,

        ]);
    }
    public function actionRemark($id, $icno)
    {
        // $layak = Layak::getLatestLayak($icno);
        $model = Layak::findOne(['layak_id' => $id]);
        // $model->scenario = "adjust";

        // var_dump($model->layak_mula);die;
        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        if ($model->load(Yii::$app->request->post())) {
            //file
            // $model->gcrfile = UploadedFile::getInstance($model, 'gcrfile');
            // $datas = Yii::$app->FileManager->UploadFile($model->gcrfile->name, $model->gcrfile->tempName, '04', 'Dokumen Sokongan');

            // if ($datas->status == true) {
            //     $model->gcrfile = $datas->file_name_hashcode;
            // }
            if ($model->save()) {
                $this->logs(Yii::$app->user->getId(), $id, "Remark ");

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Penyelarasan telah dihantar!']);
                return $this->redirect(['cuti/supervisor/set-leave', 'id' => $icno]);
            }
        }
        return $this->render('remark', [
            'model' => $model,
            'icno' => $icno,
            'biodata' => $biodata,

        ]);
    }
    public function actionPenyelarasan($icno)
    {
        $layak = Layak::getLatestLayak($icno);
        $model = Layak::findOne(['layak_id' => $layak->layak_id]);
        $model->scenario = "adjust";
        $adj = new CutiAdjustment();

        // var_dump($model->layak_mula);die;
        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);
        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //file
            $model->adjfile = UploadedFile::getInstance($model, 'adjfile');
            $datas = Yii::$app->FileManager->UploadFile($model->adjfile->name, $model->adjfile->tempName, '04', 'Dokumen Sokongan');

            if ($datas->status == true) {
                $model->adjfile = $datas->file_name_hashcode;
            }

            $adj->icno = $icno;
            $adj->layak_mula = $model->layak_mula;
            $adj->layak_tamat = $model->layak_tamat;
            $adj->layak_selaras = $model->layak_selaras;
            $adj->catatan = $model->catatan;
            $adj->adjfile = $model->adjfile;
            $adj->save(false);



            if ($model->save()) {
                $this->logs(Yii::$app->user->getId(), $adj->id, "Adjustment");

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Penyelarasan telah dihantar!']);
                return $this->redirect(['cuti/supervisor/set-leave', 'id' => $icno]);
            }
        }

        return $this->render('penyelarasan', [
            'model' => $model,
            'icno' => $icno,
            'biodata' => $biodata,

        ]);
    }

    public function Deduction($icno, $start, $end)
    {
        $campus = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", $start)));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", $end)));
        // var_dump($icno,$start_date,$end_date);die;

        $ph = false;
        if ($campus->campus_id == '2') {
            // $ph = CutiUmum::findBySql($start_sql, [':starts' => $start_date, ':ends' => $end_date])->exists();
            $ph = CutiUmum::find()->where(['between', 'tarikh_cuti', $start_date, $end_date])->andWhere(['wilayah_sahaja' => 1])->exists();
        } else {
            $ph = CutiUmum::find()->where(['between', 'tarikh_cuti', $start_date, $end_date])->andWhere(['sabah_sahaja' => 1])->exists();
        }

        // var_dump($ph);die;
        return $ph;
    }
    public function syif($icno)
    {

        $bol = false;

        // $gred = ['119', '118', '117', '116', '302', '303', '360', '368', '295', '389'];
        // $identify = TblShiftKeselamatan::find()->where(['icno'=>Yii::$app->user->getId()])->andWhere(['YEAR(tarikh)'=>date('Y')])->one();
        // // $identify = Tblprcobiodata::find()->where(['ICNO' => $icno])->andWhere(['IN', 'gredJawatan', $gred])->one();
        // if ($identify) {
        //     $bol = true;
        // }
        // var_dump($bol);die;
        return $bol;
    }
    public function actionManualLeaveApplication($id)
    {
        $icno = Yii::$app->user->getId();
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $layak = Layak::find()->where(['layak_icno' => $id])->orderBy(['layak_mula' => SORT_DESC])->all();
        $admin = AksesPengguna::find()->where(['akses_cuti_icno' => Yii::$app->user->getId()])->andWhere(['akses_cuti_int' => 3])->exists();
        // if ($admin) {
        $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->all();
        // } else {
        //     $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->andWhere(['jenis_cuti_id' => [1, 2, 20, 21, 42]])->all();
        // }


        $model = new TblRecords();

        $model->scenario = "manual";

        // $staff_list = Tblprcobiodata::find()->where(['Status' => 1])->andWhere(['<>', 'ICNO', $icno])->asArray()->all();
        $sick_leave_verifier = AksesPengguna::find()->where(['akses_cuti_int' => 2])->andWhere(['akses_jspiu_id' => $biodata->DeptId])->all();

        $model_jenis = JenisCuti::findOne($id);

        // $model_pegawai = SetPegawai::findOne(['pemohon_icno' => $icno]);


        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }



        if ($model->load(Yii::$app->request->post())) {
            // var_dump($model->tempv2);die;
            if ($model->jenis_cuti_id == 3 || $model->jenis_cuti_id == 19 ||  $model->jenis_cuti_id == 28 || ($this->syif($id) == true)) {
                $model->tempoh = $model->totalDaysInc;
            } else {
                if ($model->tempv2 == 1) {
                    $model->tempoh = $model->totalDays;
                } elseif ($model->tempv3 == 1) {
                    $model->tempoh = $model->totalDaysInc;
                } else {
                    if (($this->Deduction($id, $model->start_date, $model->end_date)) == true) {
                        // echo 'd';die;
                        $model->tempoh =  $model->totalDaysEx - 1;
                    } else {

                        $model->tempoh =  $model->totalDaysEx;
                    }
                }
            }
            // var_dump($model->tempoh);die;
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '05', 'Medical Certificate');
                if ($datas->status == true) {
                    $model->file_hashcode = $datas->file_name_hashcode;
                }
            }
            $model->icno = $id;
            // $model->jenis_cuti_id = $id;
            $model->mohon_dt = date('Y-m-d H:i:s');
            // $model->peraku_by = isset($model_pegawai->peraku_icno) ? $model_pegawai->peraku_icno : null;
            // $model->lulus_by = $model_pegawai->pelulus_icno;

            if ($model->save()) {
                $this->logs($icno, $model->id, "Manual Leave Application");
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
                return $this->redirect(['cuti/supervisor/manual-leave-application', 'id' => $id]);
            }
        }

        return $this->render('manual-leave-application', [
            // 'searchModel' => $searchModel,
            'biodata' => $biodata,
            'layak' => $layak,
            'id' => $id,
            'model' => $model,
            'jenis_cuti' => $jenis_cuti,
            'sick_leave_verifier' => $sick_leave_verifier,
        ]);
    }

    public function actionSetEntitlement($id)
    {
        $icno = Yii::$app->user->getId();

        $lyk = Layak::find()->where(['layak_icno' => $id])->orderBy([
            'layak_mula' => SORT_DESC //specify sort order ASC for ascending DESC for descending      
        ])->one();
        // var_dump($lyk->layak_bawa_depan);die;
        $model = new Layak();
        $model->scenario = "layak";
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

        $staff_list = Tblprcobiodata::find()->where(['ICNO' => $id])->one();
        $model_jenis = JenisCuti::findOne($id);

        $admin = AksesPengguna::find()->where(['akses_cuti_icno' => Yii::$app->user->getId()])->andWhere(['akses_cuti_int' => 3])->andWhere(['akses_jspiu_id' => 158])->exists();

        $model_pegawai = SetPegawai::findOne(['pemohon_icno' => $icno]);


        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }



        if ($model->load(Yii::$app->request->post())) {

            $model->layak_icno = $id;
            // var_dump($biodata->statLantikan == 6);die;
            if ($model->tempv2 == 1) {
                if ($model->layak_cuti != 0) {
                    $model->layak_cuti = $model->layak_cuti;
                } else {
                    $model->layak_cuti = 0;
                }
            } elseif ($biodata->statLantikan == 7 || $biodata->statLantikan == 6) {
                $model->layak_cuti = $model->layak_cuti;
            } else {
                $model->layak_cuti = Layak::getRate($id, $model->layak_mula, $model->layak_tamat);
            }
            // var_dump($model->layak_cuti);die;
            // $model->layak_bawa_lepas = Layak::findOne(['layak_icno'=>$id]);
            if (!$lyk) {
                $model->layak_bawa_lepas = 0;
            } else {
                $model->layak_bawa_lepas = $lyk->layak_bawa_depan;
            }
            $gcr = GcrApplication::find()->where(['pemohon_icno' => $id])->andWhere(['YEAR(mohon_dt)' => $model->layak_mula])->one();
            $adj = CutiAdjustment::find()->where(['icno' => $id])->andWhere(['layak_mula' => $model->layak_mula])->one();
            if ($adj) {
                $ad = $adj->layak_selaras;
                $file = $adj->adjfile;
                $cd = $adj->catatan;
            } else {
                $ad = NULL;
                $file = NULL;
                $cd = NULL;
            }
            if ($gcr) {

                $model->layak_bawa_depan = $gcr->cbth_applied;
                $model->layak_ambil = 0;
                $model->layak_gcr = $gcr->gcr_applied;
                $model->layak_selaras = $ad;
                $model->adjfile = $file;
                $model->catatan = $cd;
                $model->layak_hapus = ($model->layak_cuti + $model->layak_bawa_lepas) - (TblRecords::totalCuti($gcr->pemohon_icno, $model->layak_mula, $model->layak_tamat)) - ($gcr->gcr_applied +  $gcr->cbth_applied);
                // var_dump($model->layak_hapus);die;
            } else {

                $model->layak_bawa_depan = 0;
                $model->layak_ambil = 0;
                $model->layak_gcr = 0;
                $model->layak_hapus = 0;
                $model->layak_selaras = $ad;
                $model->catatan = $cd;
                $model->adjfile = $file;
            }

            if ($model->save()) {
                $this->Layaklog($icno);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Kelayakan Berjaya Di tambah!']);
                return $this->redirect(['cuti/supervisor/set-leave', 'id' => $id]);
            }
        }

        return $this->render('set-entitlement', [
            'model' => $model,
            'staff_list' => $staff_list,
            'model_jenis' => $model_jenis,
            'icno' => $icno,
            'admin' => $admin,
            'biodata' => $biodata,

        ]);
    }
    public function actionDeleteLayak($id, $icno)
    {

        $exist = Layak::find()->where(['layak_id' => $id])->one();
        $exist->delete();
        $id = Yii::$app->user->getId();

        // if(!$exist){
        //     Yii::$app->session->setFlash('alert', ['title' => 'Tidak boleh padam', 'type' => 'error', 'msg' => 'Permission ini digunakan.']);
        // }else{
        //     // $perm = $this->findModel($id);
        // }
        $this->Layaklog($id);

        return $this->redirect(['cuti/supervisor/set-leave', 'id' => $icno]);
    }


    public function actionUpdateEntitlement($id)
    {
        $icno = Yii::$app->user->getId();

        $model = Layak::find()->where(['layak_id' => $id])->one();
        $bio = Tblprcobiodata::findOne(['ICNO' => $model->layak_icno]);

        $bsm = AksesPengguna::find()->where(['akses_cuti_icno' => $icno])->andWhere(['akses_cuti_int' => 3])->exists();
        $yr = date("Y", strtotime(date("Y-m-d", strtotime($model->layak_mula)) . " + 1 year"));
        $next = Layak::find()->where(['layak_icno' => $model->layak_icno])->andWhere(['YEAR(layak_mula)' => $yr])->one();
        if (!$next) {
            $next = Layak::find()->where(['layak_icno' => $model->layak_icno])
                ->andWhere(['YEAR(layak_mula)' => date('Y')])
                ->andWhere(['>', 'layak_mula', $model->layak_tamat])
                ->orderBy([
                    'layak_mula' => SORT_DESC //specify sort order ASC for ascending DESC for descending      
                ])->one();
        }
        // var_dump($next);die;

        // if ($next) {
        $model->scenario = "carry";
        // }
        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->indicator == 1) {

                if ($model->layak_cuti != 0) {
                    $model->layak_cuti = $model->layak_cuti;
                    // $next ? $next->layak_bawa_lepas =  $model->layak_bawa_depan : " " ;
                    // $next->layak_bawa_lepas = $model->layak_bawa_depan;
                } else {
                    $model->layak_cuti = 0;
                }
            } elseif ($bio->statLantikan == 7 || $bio->statLantikan == 6) {

                $model->layak_cuti = $model->layak_cuti;
            } else {
                $next ? $next->layak_bawa_lepas =  $model->layak_bawa_depan : " ";
                $model->layak_cuti = Layak::getRate($model->layak_icno, $model->layak_mula, $model->layak_tamat);
            }

            if ($model->save()) {
                $next ? $next->save() : "";
                $this->Layaklog($icno, $id);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Record Updated!']);
                return $this->redirect(['cuti/supervisor/set-leave', 'id' => $model->layak_icno]);
            }
        }
        return $this->render('update-entitlement', [
            'model' => $model,
            'bio' => $bio->CONm,
            'exist' => $bsm,
            'stat' => $bio->statLantikan,
        ]);
    }

    public function actionUpdateStaffLeave($id)
    {

        $model = TblRecords::find()->where(['id' => $id])->one();
        $semakan = $model->semakan_by;
        $biodata = Tblprcobiodata::findOne(['ICNO' => $model->icno]);

        $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->all();
        $sick_leave_verifier = AksesPengguna::find()->where(['akses_cuti_int' => 2])->andWhere(['akses_jspiu_id' => $biodata->DeptId])->all();

        $model->scenario = "update";

        // $model_pegawai = SetPegawai::findOne(['pemohon_icno' => $icno]);


        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }



        if ($model->load(Yii::$app->request->post())) {
            // var_dump($model->semakan_remark);die;
            if ($model->jenis_cuti_id == 3 || $model->jenis_cuti_id == 19 ||  $model->jenis_cuti_id == 28 || ($this->syif($model->icno) == true)) {
                $model->tempoh = $model->totalDaysInc;
            } else {
                if ($model->tempv2 == 1) {
                    $model->tempoh = $model->totalDays;
                } elseif ($model->tempv3 == 1) {
                    $model->tempoh = $model->totalDaysInc;
                } else {
                    $model->tempoh = $model->totalDaysEx;
                }
            }
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '05', 'Medical Certificate');
                if ($datas->status == true) {
                    $model->file_hashcode = $datas->file_name_hashcode;
                }
            }
            if ($model->semakan_by == "") {
                $model->semakan_by = $semakan;
            }

            if ($model->save()) {
                $this->logs(Yii::$app->user->getId(), $id, 'Update Staff Leave');
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
                return $this->redirect(['cuti/supervisor/leave-list-sv', 'id' => $model->icno]);
            }
        }

        return $this->render('update-staff-leave', [

            'id' => $id,
            'model' => $model,
            'jenis_cuti' => $jenis_cuti,
            'sick_leave_verifier' => $sick_leave_verifier,
        ]);
    }
    public function actionPrintLeave($id)
    {
        $model = TblRecords::find()->where(['id' => $id])->one();
        $biodata = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
        $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_id' => $model->jenis_cuti_id])->one();

        $pengganti = Tblprcobiodata::findOne(['ICNO' => $model->ganti_by]);
        $peraku = Tblprcobiodata::findOne(['ICNO' => $model->peraku_by]);
        $pelulus = Tblprcobiodata::findOne(['ICNO' => $model->lulus_by]);
        $semak = Tblprcobiodata::findOne(['ICNO' => $model->semakan_by]);
        $dataProvider = TblRecords::find()->where(['icno' => $model->icno])->andWhere(['YEAR(start_date)' => date('Y')])->all();

        // $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');
        // $month = TblRekod::viewBulan($bulan);
        // var_dump($month);
        // die;
        $this->view->title = "MAKLUMAT PERMOHONAN ($jenis_cuti->jenis_cuti_nama .''. $jenis_cuti->jenis_cuti_catatan)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_printLeave', [
            'model' => $model,
            'biodata' => $biodata,
            'pengganti' => $pengganti,
            'peraku' => $peraku,
            'semak' => $semak,
            'pelulus' => $pelulus,
            'bil' => 1,
            'dataProvider' => $dataProvider
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Maklumat Cuti $biodata->CONm.pdf",
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => "Maklumat Cuti $biodata->CONm"],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["UNIVERSITI MALAYSIA SABAH||Maklumat Cuti $biodata->CONm"],
                'SetFooter' => ['INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN||{PAGENO}'],
                //                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionPrintStatement($id, $year)
    {
        // $model = TblRecords::find()->where(['id' => $id])->one();
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $jenis = JenisCuti::find()->all();

        $var = null;
        // var_dump($year);die;

        if ($year == null) {
            $year = date('Y');
        }
        $model = Layak::find()->where(['layak_icno' => $id])->groupBy(['YEAR(layak_mula)'])->orderBy(['YEAR(layak_mula)' => SORT_DESC])->all();

        if ($year == 0) {
            $query = Layak::find()->where(['layak_icno' => $id])->orderBy(['YEAR(layak_mula)' => SORT_DESC])->all();
            $record = TblRecords::find()->where(['icno' => $id])->all();

            $var = 1;
        } else {
            $query = Layak::find()->where(['layak_icno' => $id])->andWhere(['YEAR(layak_mula)' => $year])->all();
            $record = TblRecords::find()->where(['icno' => $id])->andWhere(['YEAR(start_date)' => $year])->all();
        }

        $data = [];

        foreach ($model as $v) {
            $data[$v->tahun] = $v->tahun;
        }

        $data[0] = "Show All";

        // $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');
        // $month = TblRekod::viewBulan($bulan);
        // var_dump($month);
        // die;
        $this->view->title = "MAKLUMAT PERMOHONAN ()";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_printStatement', [
            'id' => $id,
            'model' => $model,
            'data' => $data,
            'year' => $year,
            'var' => $var,
            'query' => $query,
            'record' => $record,
            'biodata' => $biodata,
            'jenis' => $jenis,
            'bil' => 1,
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Penyata Cuti Tahunan $biodata->CONm.pdf",
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}
            .page-break{display: block;page-break-before: left;}
           ',
            // set mPDF properties on the fly
            'options' => ['title' => "Maklumat Cuti $biodata->CONm"],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["UNIVERSITI MALAYSIA SABAH||Penyata Cuti Tahunan $biodata->CONm"],
                'SetFooter' => ['INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN||{PAGENO}'],
                //                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    //pembatalan cuti

    public function actionCancelLeave($id)
    {

        $model = TblRecords::findOne(['id' => $id]);

        $cancelled = new CutiBatal();
        $icno = Yii::$app->user->getId();

        $cancelled->cuti_rekod_id = $id;
        $cancelled->cuti_icno = $model->icno;
        $cancelled->full_date = $model->full_date;
        $cancelled->cuti_mula = $model->start_date;
        $cancelled->cuti_tamat = $model->end_date;
        $cancelled->cuti_catatan = $model->remark;
        $cancelled->cuti_tempoh = $model->tempoh;
        $cancelled->cuti_jenis_id = $model->jenis_cuti_id;
        $cancelled->file_hashcode = $model->file_hashcode;
        $cancelled->cuti_ganti_oleh = $model->ganti_by;
        $cancelled->cuti_dok_peraku_oleh = $model->semakan_by;
        $cancelled->cuti_peraku_oleh = $model->peraku_by;
        $cancelled->cuti_lulus_oleh = $model->lulus_by;
        // $cancelled->cuti_status_dok_peraku = $model->
        // $cancelled->cuti_ganti_status = $model->
        // $cancelled->cuti_status_peraku = $model->
        $cancelled->cuti_mohon_pada = $model->mohon_dt;
        $cancelled->cuti_dok_peraku_pada = $model->semakan_dt;
        // $cancelled->cuti_ganti_status_pada = $model->
        $cancelled->cuti_peraku_pada = $model->peraku_dt;
        $cancelled->cuti_lulus_pada = $model->lulus_dt;
        $cancelled->cuti_batal_oleh = $icno;
        // $cancelled->cuti_status_admin = $model->
        // $cancelled->cuti_catatanx = $model->
        $cancelled->cuti_catatan_peraku = $model->peraku_remark;
        $cancelled->cuti_catatan_lulus = $model->lulus_remark;
        $cancelled->status = $model->status;

        $cancelled->save();
        $model->delete();

        return $this->redirect(['cuti/supervisor/leave-list-sv', 'id' => $model->icno]);
    }

    public function actionLeaveStatement($id, $year = null)
    {
        $var = null;
        // var_dump($year);die;

        if ($year == null) {
            $year = date('Y');
        }
        $model = Layak::find()->where(['layak_icno' => $id])->groupBy(['YEAR(layak_mula)'])->orderBy(['YEAR(layak_mula)' => SORT_DESC])->all();

        if ($year == 0) {
            $query = Layak::find()->where(['layak_icno' => $id])->orderBy(['YEAR(layak_mula)' => SORT_DESC, 'MONTH(layak_mula)' => SORT_DESC])->all();
            $record = TblRecords::find()->where(['icno' => $id])->all();

            $var = 1;
        } else {
            $query = Layak::find()->where(['layak_icno' => $id])->andWhere(['YEAR(layak_mula)' => $year])->all();
            $record = TblRecords::find()->where(['icno' => $id])->andWhere(['YEAR(start_date)' => $year])->all();
        }

        $data = [];
        $yr = date("Y", strtotime(date("Y-m-d") . " + 1 year"));

        $data[0] = "Show All";
        $data[$yr] = $yr;
        foreach ($model as $v) {
            $data[$v->tahun] = $v->tahun;
        }


        // VarDumper::dump( $model, $depth = 10, $highlight = true)($query);die;
        return $this->render('leave-statement', [

            'id' => $id,
            'model' => $model,
            'data' => $data,
            'year' => $year,
            'var' => $var,
            'query' => $query,
            'record' => $record,
            // 'total' => $total,
            // 'jenis_cuti' => $jenis_cuti,
            // 'sick_leave_verifier' => $sick_leave_verifier,
        ]);
    }

    public function actionPrintStatementReport($dept = null, $year = null, $month = null)
    {
        $id = Yii::$app->user->getId();

        if ($year == null) {
            $year = date('Y');
        }
        $mth = $month;
        $record = TblRecords::find()->select('icno')->where(['YEAR(start_date)' => $year])->andWhere(['MONTH(start_date)' => $month])->all();

        if ($month == 0) {
            $record = TblRecords::find()->select('icno')->where(['YEAR(start_date)' => $year])->all();
        } else {
            $record = TblRecords::find()->select('icno')->where(['YEAR(start_date)' => $year])->andWhere(['MONTH(start_date)' => $month])->all();
        }
        if ($dept == null) {
            $deptId = Tblprcobiodata::findOne(['ICNO' => $id]);
            $dept = $deptId->DeptId;
        }
        $dept_name = Department::findOne(['id' => $dept]);
        // var_dump($dept_name);die;
        $department = Department::find()->where(['isActive' => 1])->all();
        $staff_list = Tblprcobiodata::find()->where(['DeptId' => $dept])->andWhere(['!=', 'Status', '6'])->andWhere(['icno' => $record])->orderBy(['CONm' => SORT_ASC])->all();
        $count1 = count($staff_list) - 1;
        $count = count($staff_list) - $count1;
        $total = count($staff_list);
        // $bil = count($record);
        $model = TblRecords::find()->where(['!=', 'YEAR(start_date)', '0'])->groupBy(['YEAR(start_date)'])->orderBy(['YEAR(start_date)' => SORT_DESC])->all();

        $data = [];


        // $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');
        // $month = TblRekod::viewBulan($bulan);
        // var_dump($month);
        // die;
        $this->view->title = "MAKLUMAT PERMOHONAN ()";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_printStatementReport', [
            'id' => $id,
            'staff_list' => $staff_list,
            'data' => $data,
            'year' => $year,
            // 'query' => $query,
            'record' => $record,
            'dept_name' => $dept_name,
            'dept' => $dept,
            'department' => $department,
            'month' => $month,
            'mth' => $mth,
            'count' => $count,
            'total' => $total,
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Penyata Cuti Bulanan $dept_name->fullname.pdf",
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}
            .page-break{display: block;page-break-before: left;}
           ',            // set mPDF properties on the fly
            'options' => ['title' => "Maklumat Cuti "],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["UNIVERSITI MALAYSIA SABAH||Penyata Cuti Bulanan $dept_name->fullname"],
                'SetFooter' => ['INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN||{PAGENO}'],
                //                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    public function actionPrintStatements($dept = null, $year = null, $month = null)
    {
        $id = Yii::$app->user->getId();

        if ($year == null) {
            $year = date('Y');
        }
        $mth = $month;
        $month = date('m');

        if ($dept == null) {
            $deptId = Tblprcobiodata::findOne(['ICNO' => $id]);
            $dept = $deptId->DeptId;
        }
        $dept_name = Department::findOne(['id' => $dept]);
        // var_dump($dept_name);die;
        $department = Department::find()->where(['isActive' => 1])->all();
        $record = TblRecords::find()->select('icno')->where(['YEAR(start_date)' => $year])->all();
        $staff_list = Tblprcobiodata::find()->where(['DeptId' => $dept])->andWhere(['!=', 'Status', '6'])->andWhere(['icno' => $record])->orderBy(['CONm' => SORT_ASC])->all();
        $count1 = count($staff_list) - 1;
        $count = count($staff_list) - $count1;
        $total = count($staff_list);
        // $bil = count($record);
        $model = TblRecords::find()->where(['!=', 'YEAR(start_date)', '0'])->groupBy(['YEAR(start_date)'])->orderBy(['YEAR(start_date)' => SORT_DESC])->all();

        $data = [];

        $this->view->title = "MAKLUMAT PERMOHONAN ()";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_printStatements', [
            'id' => $id,
            'staff_list' => $staff_list,
            'data' => $data,
            'year' => $year,
            // 'query' => $query,
            'record' => $record,
            'dept_name' => $dept_name,
            'dept' => $dept,
            'department' => $department,
            'month' => $month,
            'mth' => $mth,
            'count' => $count,
            'total' => $total,
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Penyata Cuti Bulanan $dept_name->fullname.pdf",
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}
            .page-break{display: block;page-break-before: left;}
           ',            // set mPDF properties on the fly
            'options' => ['title' => "Maklumat Cuti "],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["UNIVERSITI MALAYSIA SABAH||Penyata Cuti Bulanan $dept_name->fullname"],
                'SetFooter' => ['INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN||{PAGENO}'],
                //                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionLeaveStatementReport($dept = null, $jenis_cuti = null, $year = null, $month = null)
    {
        $id = Yii::$app->user->getId();

        if ($year == null) {
            $year = date('Y');
        }
        $mth = $month;
        if ($month == null) {
            $month = '0';
        }
        $access = AksesPengguna::find()->where(['akses_cuti_icno' => $id])->all();
        foreach ($access as $a) {
            $arr[] = $a->akses_cuti_int;
            $arr3[] = $a->akses_jspiu_id;
        }
        $department = Department::find()->where(['isActive' => 1])->all();

        if (in_array("3", $arr)) {
            $query = ArrayHelper::map($department, 'id', 'fullname');
        } else {
            $query = ArrayHelper::map(Department::find()->where(['isActive' => 1])->andWhere(['IN', 'id', $arr3])->all(), 'id', 'fullname');
        }

        if ($dept == 0) {
            $deptId = Tblprcobiodata::findOne(['ICNO' => $id]);
            $dept = $deptId->DeptId;
        }
        $record = TblRecords::find()->select('icno')->where(['YEAR(start_date)' => $year])->andWhere(['MONTH(start_date)' => $month])->andWhere(['jenis_cuti_id' => $jenis_cuti])->all();

        if ($jenis_cuti == null && $month == null) {
            // echo 'd';die;
            $record = TblRecords::find()->select('icno')->where(['YEAR(start_date)' => $year])->andWhere(['MONTH(start_date)' => date('m')])->all();
        }
        if ($jenis_cuti == 0 && $month == 0) {
            // echo 'sd';die;

            $record = TblRecords::find()->select('icno')->where(['YEAR(start_date)' => $year])->all();
        }
        if ($jenis_cuti == 0 && $month != 0) {
            // echo 'ds';die;

            $record = TblRecords::find()->select('icno')->where(['YEAR(start_date)' => $year])->andWhere(['MONTH(start_date)' => $month])->all();
        }


        $dept_name = Department::findOne(['id' => $dept]);

        // $jenis = JenisCuti::find()->all();
        $jenis = $this->setarray();

        $staff_list = Tblprcobiodata::find()->where(['DeptId' => $dept])->andWhere(['!=', 'Status', '6'])->andWhere(['icno' => $record])->orderBy(['CONm' => SORT_ASC])->all();
        $count1 = count($staff_list) - 1;
        $count = count($staff_list) - $count1;
        $total = count($staff_list);
        // $bil = count($record);
        $model = TblRecords::find()->where(['!=', 'YEAR(start_date)', '0'])->groupBy(['YEAR(start_date)'])->orderBy(['YEAR(start_date)' => SORT_DESC])->all();

        $data = [];


        foreach ($model as $v) {
            $data[$v->tahun] = $v->tahun;
        }

        // VarDumper::dump( $model, $depth = 10, $highlight = true)($query);die;
        return $this->render('leave-statement-report', [

            'id' => $id,
            'staff_list' => $staff_list,
            'data' => $data,
            'year' => $year,
            'jenis' => $jenis,
            'jenis_cuti' => $jenis_cuti,
            'record' => $record,
            'dept_name' => $dept_name,
            'dept' => $dept,
            'department' => $department,
            'month' => $month,
            'mth' => $mth,
            'count' => $count,
            'total' => $total,
            'query' => $query,
        ]);
    }
    public function setarray()
    {
        $model = JenisCuti::find()->all();

        if ($model) {
            foreach ($model as $m) {

                $arr[] = [
                    'jenis_cuti_id' => $m->jenis_cuti_id,
                    'jenis_cuti_catatan' => $m->jenis_cuti_catatan,
                ];
            }

            array_unshift($arr, [
                'jenis_cuti_id' => '0',
                'jenis_cuti_catatan' => 'Show All'
            ]);

            return $arr;
        }
    }

    public function actionCalender($dept = null, $year = null, $month = null)
    {
        $id = Yii::$app->user->getId();
        // var_dump($year,$month);die;

        if ($year == null) {
            $year = date('Y');
        }
        if ($month == null) {
            $month = date('m');
        }
        if ($dept == null) {
            $deptId = Tblprcobiodata::findOne(['ICNO' => $id]);
            $dept = $deptId->DeptId;
        }
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $dept_name = Department::findOne(['id' => $dept]);
        $department = Department::find()->where(['isActive' => 1])->all();
        $end_sql = 'SELECT * FROM hrm.cuti_tbl_records a JOIN hronline.tblprcobiodata b on b.ICNO = a.icno
        LEFT JOIN hronline.department c ON b.deptId = c.id
        WHERE b.DeptId=:dept AND MONTH(a.start_date) =:mth AND YEAR(a.start_date) =:yr AND a.`jenis_cuti_id` = 1 
        AND a.status = "APPROVED" GROUP BY a.icno';
        $baki = TblRecords::findBySql($end_sql, [':dept' => $dept, ':mth' => $month, ':yr' => $year])->all();

        $total = count($baki);

        $data = [];

        // foreach ($model as $v) {
        //     $data[$v->tahun] = $v->tahun;
        // }

        return $this->render('calender', [

            'id' => $id,
            // 'staff_list' => $staff_list,
            // 'data' => $data,
            'year' => $year,
            // 'query' => $query,
            // 'record' => $record,
            'dept_name' => $dept_name,
            'dept' => $dept,
            'department' => $department,
            'month' => $month,
            // 'count' => $count,
            'total' => $total,
            'days' => $days,
            'bil' => 1,
            'baki' => $baki
        ]);
    }

    public function actionLeaveMonitoring()
    {

        $id = Yii::$app->user->getId();
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $jenis_cuti_id = '';

        $akses = AksesPengguna::findOne(['akses_cuti_icno' => $id]);
        $params = Yii::$app->request->queryParams;
        // var_dump($params);die;
        $searchModel = new TblRecordsSearch();
        if (!$params) {
            $bio = Tblprcobiodata::find()->where(['DeptId' => $akses->akses_jspiu_id])->andWhere(['campus_id' => $akses->akses_kampus_id])->andWhere(['!=', 'Status', 6])->all();
            $data = [];

            foreach ($bio as $v) {
                $data[$v->ICNO] = $v->ICNO;
            }
            $query = TblRecords::find()->where(['NOT IN', 'status', ['APPROVED', 'REJECTED']])->andWhere(['in', 'icno', $data]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        } else {

            $dataProvider = $searchModel->searchs(Yii::$app->request->queryParams);
        }


        // var_dump($dataProvider);
        // die;

        return $this->render('leave-monitoring', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'jenis_cuti_id' => $jenis_cuti_id,
            'carian_department' => $biodata->DeptId,
            // 'params' =>$params,
        ]);
    }

    public function actionResetGcr($id)
    {
        $model = GcrApplication::findOne(['id' => $id]);
        if ($model) {
            $model->delete();
        }
        return $this->redirect(['cuti/supervisor/gcr-list-checked']);
    }
    public function actionGcrListChecked()
    {
        $id = Yii::$app->user->getId();
        $model = GcrApplication::find()->where(['semakan_by' => $id])->andWhere(['YEAR(mohon_dt)' => date('Y')])->all();

        return $this->render('gcr-list-checked', [
            'model' => $model,
            'bil' => 1,
            // 'params' =>$params,
        ]);
    }
    public function actionPrintLeaves($params)
    {
        echo $params;
        die;
        // $id = Yii::$app->user->getId();
        // // var_dump($year,$month);die;

        // if ($year == null) {
        //     $year = date('Y');
        // }
        // if ($month == null) {
        //     $month = date('m');
        // }
        // if ($dept == null) {
        //     $deptId = Tblprcobiodata::findOne(['ICNO' => $id]);
        //     $dept = $deptId->DeptId;
        // }
        // $dept_name = Department::findOne(['id' => $dept]);
        // // var_dump($dept_name);die;
        // $department = Department::find()->where(['isActive' => 1])->all();
        // $record = TblRecords::find()->select('icno')->where(['YEAR(start_date)' => $year])->andWhere(['MONTH(start_date)' => $month])->all();
        // $staff_list = Tblprcobiodata::find()->where(['DeptId' => $dept])->andWhere(['!=', 'Status', '6'])->andWhere(['icno' => $record])->orderBy(['CONm' => SORT_ASC])->all();
        // $count1 = count($staff_list) - 1;
        // $count = count($staff_list) - $count1;
        // $total = count($staff_list);
        // // $bil = count($record);
        // $model = TblRecords::find()->where(['!=', 'YEAR(start_date)', '0'])->groupBy(['YEAR(start_date)'])->orderBy(['YEAR(start_date)' => SORT_DESC])->all();

        // $data = [];


        // // $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');
        // // $month = TblRekod::viewBulan($bulan);
        // // var_dump($month);
        // // die;
        // $this->view->title = "MAKLUMAT PERMOHONAN ()";
        // // get your HTML raw content without any layouts or scripts
        // $content = $this->renderPartial('_printStatementReport', [
        //     'id' => $id,
        //     'staff_list' => $staff_list,
        //     'data' => $data,
        //     'year' => $year,
        //     // 'query' => $query,
        //     'record' => $record,
        //     'dept_name' => $dept_name,
        //     'dept' => $dept,
        //     'department' => $department,
        //     'month' => $month,
        //     'count' => $count,
        //     'total' => $total,
        // ]);

        // // setup kartik\mpdf\Pdf component
        // $pdf = new Pdf([
        //     // set to use core fonts only
        //     'mode' => Pdf::MODE_CORE,
        //     'filename' => "Penyata Cuti Bulanan $dept_name->fullname.pdf",
        //     // A4 paper format
        //     'format' => Pdf::FORMAT_A4,
        //     // portrait orientation
        //     'orientation' => Pdf::ORIENT_PORTRAIT,
        //     // stream to browser inline
        //     'destination' => Pdf::DEST_BROWSER,
        //     // your html content input
        //     'content' => $content,
        //     // format content from your own css file if needed or use the
        //     // enhanced bootstrap css built by Krajee for mPDF formatting 
        //     'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
        //     // any css to be embedded if required
        //     'cssInline' => '.kv-heading-1{font-size:18px}',
        //     // set mPDF properties on the fly
        //     'options' => ['title' => "Maklumat Cuti "],
        //     // call mPDF methods on the fly
        //     'methods' => [
        //         'SetHeader' => ["Penyata Cuti Bulanan $dept_name->fullname"],
        //         'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
        //         //                'SetFooter' => [' {PAGENO}'],
        //     ]
        // ]);

        // // return the pdf output as per the destination setting
        // return $pdf->render();
    }
    public function actionPrintCalender($dept, $month, $year)
    {
        $id = Yii::$app->user->getId();
        // var_dump($year,$month);die;

        if ($year == null) {
            $year = date('Y');
        }
        if ($month == null) {
            $month = date('m');
        }
        if ($dept == null) {
            $deptId = Tblprcobiodata::findOne(['ICNO' => $id]);
            $dept = $deptId->DeptId;
        }
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $dept_name = Department::findOne(['id' => $dept]);
        $department = Department::find()->where(['isActive' => 1])->all();
        $end_sql = 'SELECT * FROM hrm.cuti_tbl_records a JOIN hronline.tblprcobiodata b on b.ICNO = a.icno
        LEFT JOIN hronline.department c ON b.deptId = c.id
        WHERE b.DeptId=:dept AND MONTH(a.start_date) =:mth AND YEAR(a.start_date) =:yr AND a.`jenis_cuti_id` = 1 
        AND a.status = "APPROVED" GROUP BY a.icno';
        $baki = TblRecords::findBySql($end_sql, [':dept' => $dept, ':mth' => $month, ':yr' => $year])->all();

        $total = count($baki);

        $data = [];


        // $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');
        // $month = TblRekod::viewBulan($bulan);
        // var_dump($month);
        // die;
        $this->view->title = "Calender";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_printCalender', [
            // 'id' => $id,
            // 'staff_list' => $staff_list,
            // 'data' => $data,
            'year' => $year,
            // 'query' => $query,
            // 'record' => $record,
            'dept_name' => $dept_name,
            'dept' => $dept,
            'department' => $department,
            'month' => $month,
            // 'count' => $count,
            'total' => $total,
            'days' => $days,
            'bil' => 1,
            'baki' => $baki
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Calender $dept_name->fullname.pdf",
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => "Maklumat Cuti "],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["UNIVERSITI MALAYSIA SABAH||Calender $dept_name->fullname"],
                'SetFooter' => ['INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN'],
                //                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    public function actionLoadMthLeave()
    {

        $icno = Yii::$app->user->getId();
        $tahun = '2020';

        $title = "Jumlah ketidakpatuhan mengikut JFPIU";

        $data = [
            [
                'name' => 'Annual Leave',
                'data' => [
                    TblRecords::TotalDayPerMonth($icno, $tahun, 1),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 2),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 3),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 4),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 5),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 6),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 7),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 8),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 9),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 10),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 11),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 12),
                ]
            ],
            [
                'name' => 'Medical Leave',
                'data' => [
                    TblRecords::TotalDayPerMonth($icno, $tahun, 1, 1),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 2, 1),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 3, 1),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 4, 1),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 5, 1),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 6, 1),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 7, 1),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 8, 1),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 9, 1),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 10, 1),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 11, 1),
                    TblRecords::TotalDayPerMonth($icno, $tahun, 12, 1),
                ]
            ],
        ];

        return $this->renderAjax('\load-mth-leave', [
            'data' => $data,
            'title' => $title,
            'tahun' => $tahun,
        ]);
    }


    public function actionCreates($id)
    {
        $icno = Yii::$app->user->getId();


        $modelCustomer = new TblRecords(['scenario' => 'create']);
        $modelsAddress = [new TblRecords];

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $layak = Layak::find()->where(['layak_icno' => $id])->orderBy(['layak_mula' => SORT_DESC])->all();

        $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->all();
        // $model = new TblRecords();

        $modelCustomer->scenario = "manual";

        // $staff_list = Tblprcobiodata::find()->where(['Status' => 1])->andWhere(['<>', 'ICNO', $icno])->asArray()->all();
        $sick_leave_verifier = AksesPengguna::find()->where(['akses_cuti_int' => 2])->andWhere(['akses_jspiu_id' => $biodata->DeptId])->all();

        $model_jenis = JenisCuti::findOne($id);

        // $model_pegawai = SetPegawai::findOne(['pemohon_icno' => $icno]);


        if (Yii::$app->request->isAjax && $modelCustomer->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($modelCustomer);
        }



        if ($modelCustomer->load(Yii::$app->request->post())) {
            $modelsAddress = Model::createMultiple(TblRecords::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());


            // $valid = $modelCustomer->validate();

            // $valid = Model::validateMultiple($modelsAddress) && $valid;

            if ($modelCustomer->jenis_cuti_id == 3 || $modelCustomer->jenis_cuti_id == 19 ||  $modelCustomer->jenis_cuti_id == 28 || ($this->syif($id) == true)) {
                $modelCustomer->tempoh = $modelCustomer->totalDaysInc;
            } else {
                if ($modelCustomer->tempv2 == 1) {
                    $modelCustomer->tempoh = $modelCustomer->totalDays;
                } elseif ($modelCustomer->tempv3 == 1) {
                    $modelCustomer->tempoh = $modelCustomer->totalDaysInc;
                } else {
                    $modelCustomer->tempoh = $modelCustomer->totalDaysEx;
                }
            }
            $modelCustomer->icno = $id;
            // $model->jenis_cuti_id = $id;
            $modelCustomer->mohon_dt = date('Y-m-d H:i:s');
            $this->logs($icno, $modelCustomer->id, "Manual Leave Application");

            // $model->peraku_by = isset($model_pegawai->peraku_icno) ? $model_pegawai->peraku_icno : null;
            // $model->lulus_by = $model_pegawai->pelulus_icno;
            $modelCustomer->save(false);
            // if ($valid) {
            foreach ($modelsAddress as $modelAddress) {
                //         $modelAddress = new TblRecords();
                if ($modelAddress->start_date) {


                    $modelAddress->icno =   $id;
                    $modelAddress->jenis_cuti_id =   $modelCustomer->jenis_cuti_id;
                    $modelAddress->remark =   $modelCustomer->remark;
                    $modelAddress->destination =   $modelCustomer->destination;
                    $modelAddress->ganti_by =   $modelCustomer->ganti_by;
                    $modelAddress->ganti_dt =   $modelCustomer->ganti_dt;
                    $modelAddress->semakan_by =   $modelCustomer->semakan_by;
                    $modelAddress->semakan_remark =   $modelCustomer->semakan_remark;
                    $modelAddress->semakan_dt =   $modelCustomer->semakan_dt;
                    $modelAddress->peraku_by =   $modelCustomer->peraku_by;
                    $modelAddress->peraku_remark =   $modelCustomer->peraku_remark;
                    $modelAddress->peraku_dt =   $modelCustomer->peraku_dt;
                    $modelAddress->lulus_by =   $modelCustomer->lulus_by;
                    $modelAddress->lulus_dt =   $modelCustomer->lulus_dt;
                    $modelAddress->lulus_remark =   $modelCustomer->lulus_remark;
                    $modelAddress->status =   $modelCustomer->status;
                    $modelAddress->mohon_dt =   $modelCustomer->mohon_dt;
                    $modelAddress->file_hashcode =   $modelCustomer->file_hashcode;
                    // var_dump($modelAddress->tempv2);die;
                    $modelAddress->full_date = $modelAddress->start_date . ' to ' . $modelAddress->end_date;
                    if ($modelAddress->jenis_cuti_id == 3 || $modelAddress->jenis_cuti_id == 19 ||  $modelAddress->jenis_cuti_id == 28) {
                        $modelAddress->tempoh = $modelAddress->totalDaysInc;
                    } else {
                        if ($modelAddress->tempv2 == 1) {
                            $modelAddress->tempoh = $modelAddress->totalDays;
                        } else {
                            $modelAddress->tempoh = $modelAddress->totalDaysEx;
                        }
                    }
                    $this->logs($icno, $modelAddress->id, "Manual Leave Application");

                    $modelAddress->save(false);
                }
            };
            return $this->redirect(['cuti/supervisor/leave-list-sv', 'id' => $id]);

            // $transaction = \Yii::$app->db->beginTransaction();
            // try {
            //     if ($flag = $modelCustomer->save(false)) {
            //         foreach ($modelsAddress as $modelAddress) {
            //             // $modelAddress->parent_id = $modelCustomer->id;
            //             // $modelAddress->order = $i;
            //             if (!($flag = $modelAddress->save(false))) {
            //                 $transaction->rollBack();
            //                 break;
            //             }
            //         }
            //     }
            //     if ($flag) {
            //         $transaction->commit();
            //         return $this->redirect(['cuti/supervisor/manual-leave-application', 'id' => $id]);
            //     }
            // } catch (Exception $e) {
            //     $transaction->rollBack();
            // }
            // }


            // if ($modelCustomer->save()) {
            //     Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
            //     return $this->redirect(['cuti/supervisor/leave-list-sv', 'id' => $id]);
            // }
        }

        return $this->render('creates', [
            // 'searchModel' => $searchModel,
            'biodata' => $biodata,
            'layak' => $layak,
            'id' => $id,
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblRecords] : $modelsAddress,
            'jenis_cuti' => $jenis_cuti,
            'sick_leave_verifier' => $sick_leave_verifier,
        ]);
    }
}
