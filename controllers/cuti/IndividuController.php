<?php

namespace app\controllers\cuti;

use Yii;
use app\models\cuti\AksesPengguna;
use app\models\cuti\CutiBatal;
use app\models\cuti\CutiLog;
use app\models\cuti\CutiOpenApplication;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\cuti\CutiRekod;
use app\models\cuti\CutiTempTable;
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
use app\models\cuti\TblManagement;
use app\models\cuti\TblResearch;
use app\models\cuti\Tindakan;
use app\models\hronline\GredJawatan;
use app\models\keselamatan\TblShiftKeselamatan;
use app\models\Notification;
use app\models\smp_ppi\CutiPenyelidikan;
use app\models\system_core\TblUserAccess;
use kartik\mpdf\Pdf;
use phpDocumentor\Reflection\Types\Null_;
use tebazil\runner\ConsoleCommandRunner;
use yii\helpers\Json;
use yii\helpers\VarDumper;

class IndividuController extends Controller
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
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
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

    /**
     * 
     * laman utama utk clock in/out
     */
    public function actionIndex()
    {

        $icno = Yii::$app->user->getId();

        $tahun = date('Y');

        $cuti_rekod = TblRecords::find()->where(['>=', 'YEAR(start_date)', $tahun])->andWhere(['icno' => $icno])->all();

        $total = Layak::getBakiLatest($icno);

        $model_layak = Layak::getLatestLayak($icno, date('Y'));
        $model = TblRecords::find()->where(['ganti_by' => $icno])->andWhere(['YEAR(start_date)' => date('Y')])->orderBy(['start_date' => SORT_DESC])->all();

        $layak = Layak::find()->where(['layak_icno' => $icno])->orderBy(['layak_mula' => SORT_DESC])->all();

        return $this->render('index', [
            'cuti_rekod' => $cuti_rekod,
            'total' => $total,
            'model_layak' => $model_layak,
            'layak' => $layak,
            'model' => $model,
            'icno' => $icno,
        ]);
    }
    public function actionUploadFile()
    {
        $icno = Yii::$app->user->getId();

        $tahun = date('Y');

        $cuti_rekod = TblRecords::find()->where(['icno' => $icno, 'jenis_cuti_id' => 28, 'YEAR(start_date)' => date('Y'), 'status' => "APPROVED"])->all();
        return $this->render('upload-file', [
            'cuti_rekod' => $cuti_rekod,
            // 'total' => $total,
            // 'model_layak' => $model_layak,
            // 'layak' => $layak,
            // 'model' => $model,
        ]);
    }
    public function actionUpload($id)
    {
        $icno = Yii::$app->user->getId();
        $model = TblRecords::findOne(['icno' => $icno, 'id' => $id]);
        $model->scenario = "cb";

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $dept = Department::findOne(['id' => $biodata->DeptId]);

        //ketua bsm
        $ketua_bsm = Department::findOne(['id' => 158]);

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }


        if ($model->load(Yii::$app->request->post())) {

            //file
            $model->file1 = UploadedFile::getInstance($model, 'file1');
            $datas = Yii::$app->FileManager->UploadFile($model->file1->name, $model->file1->tempName, '04', 'Cuti Bersalin');
            $model->file2 = UploadedFile::getInstance($model, 'file2');
            $data = Yii::$app->FileManager->UploadFile($model->file2->name, $model->file2->tempName, '04', 'Cuti Bersalin');

            if ($datas->status == true) {
                $model->file1 = $datas->file_name_hashcode;
            }
            if ($data->status == true) {
                $model->file2 = $data->file_name_hashcode;
            }


            if ($model->save(false)) {
                $this->log($icno);
                // $this->Notification($model->semakan_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$biodata->CONm" . ', ' . $model->full_date . ' Menunggu Semakan Anda');
                // $runner = new ConsoleCommandRunner();
                // $runner->run('dashboard/pending-task-individu', [$icno]);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
                return $this->redirect(['cuti/individu/index']);
            }
        }

        return $this->render('upload', [
            'model' => $model,
            // 'model_jenis' => $model_jenis,
        ]);
    }

    public function actionTitlelist()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = CutiPenyelidikan::find()->select(['id' => 'ProjectID', 'name' => 'TajukPenyelidikan'])->where(['ProjectID' => $cat_id])->asArray()->all();

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }
    public function actionPatient($id)
    {

        // you may need to check whether the entered ID is valid or not
        $model = CutiPenyelidikan::findOne(['ProjectID' => $id]);
        return \yii\helpers\Json::encode([
            'city' => $model->disrict_city,
            'pin' => $model->pin_code
        ]);
    }

    /**
     * ni utk pilih cuti dan utk redirect action tu ikut jenis cuti, sila rujuk table jenis cuti
     */
    public function actionPilih()
    {

        $model = new TblRecords;
        $model->scenario = "pilih";
        $admin = TblUserAccess::findOne(['icno' => Yii::$app->user->getId()]);
        $admin = AksesPengguna::find()->where(['akses_cuti_icno' => Yii::$app->user->getId()])->andWhere(['akses_cuti_int' => 3])->exists();
        // if ($admin) {
        //     $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->all();

        //     // $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->andWhere(['jenis_cuti_id' => [1, 2, 20, 21, 18]])->all();
        // } else {
        //     $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->andWhere(['jenis_cuti_id' => [1, 2, 20, 21]])->all();
        // }
        $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->andWhere(['jenis_cuti_id' => [1, 2, 20, 21, 28, 58]])->all();

        if ($model->load(Yii::$app->request->post())) {

            $id = $model->jenis_cuti_id;

            $model_jenis = JenisCuti::findOne($id);
            //uncomment nti
            if ($id == 17) {
                $v = TblRecords::criteria(Yii::$app->user->getId());
                if (!$v) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Haraf Maaf, Anda tidak memenuhi kriteria untuk memohon cuti penyelidikan']);

                    return $this->redirect(['cuti/individu/pilih']);
                }
            }
            if ($id == 28) {
                $v = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);
                if ($v->GenderCd == "L") {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Haraf Maaf']);

                    return $this->redirect(['cuti/individu/pilih']);
                }
                if ($v->MrtlStatusCd == "1") {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Haraf Maaf, Sila Kemaskini Status Perkhawinan Anda']);

                    return $this->redirect(['cuti/individu/pilih']);
                }
            }
            $check1 = Tblprcobiodata::find()->joinWith('jawatan')->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['job_category' => 1])->one();
            $check2 = Tblprcobiodata::find()->joinWith('jawatan')->joinWith('adminpos')->where(['hronline.tblprcobiodata.ICNO' => Yii::$app->user->getId()])->andWhere(['job_category' => 1])->one();

            if (($check1 && $check2 == NULL) && $id == 1) {
                return $this->redirect(['cr1_aca', 'id' => $id, 'form' => '_form_cr1_aca']);
            } else {
                return $this->redirect([$model_jenis->action, 'id' => $id, 'form' => $model_jenis->form_type]);
            }
        }

        return $this->render('pilih', [
            'jenis_cuti' => $jenis_cuti,
            'model' => $model,
        ]);
    }
    public function actionCk($id, $form)
    {
        // var_dump($id, $form);die;
        $model = new TblRecords();
        $model->scenario = "ctr";

        $model_jenis = JenisCuti::findOne($id);

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $dept = Department::findOne(['id' => $biodata->DeptId]);

        //ketua bsm
        $ketua_bsm = Department::findOne(['id' => 158]);

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }


        if ($model->load(Yii::$app->request->post())) {

            // var_dump($model->arr);
            if ($model->others != "") {
                $model->remark = implode(",", $model->arr) . '(' . $model->others . ')';
            } else {
                $model->remark =  implode(",", $model->arr);
            }

            $model->icno = $icno;
            $model->jenis_cuti_id = $id;
            $model->status = "BSMCHECK";
            $model->tempoh = $model->totalDaysEx;
            $model->mohon_dt = date('Y-m-d H:i:s');
            $model->semakan_by = "950426125329";
            // $model->semakan_by = "761117126026";
            $model->peraku_by = $dept->chief;
            $model->lulus_by = $ketua_bsm->chief;

            //file
            $model->file = UploadedFile::getInstance($model, 'file');
            $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Cuti Kecemasan');

            if ($datas->status == true) {
                $model->file_hashcode = $datas->file_name_hashcode;
            }


            if ($model->save()) {
                $this->log($icno);
                $this->Notification($model->semakan_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$biodata->CONm" . ', ' . $model->full_date . ' Menunggu Semakan Anda');

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
                return $this->redirect(['cuti/individu/index']);
            }
        }

        return $this->render("form/" . $form, [
            'model' => $model,
            'model_jenis' => $model_jenis,
        ]);
    }
    public function actionCb($id, $form)
    {
        $model = new TblRecords();
        $model->scenario = "cb";
        $model_jenis = JenisCuti::findOne($id);

        $icno = Yii::$app->user->getId();
        $total = TblRecords::totalCutiBersalin($icno);
        $bal = 360 - $total;

        // var_dump($mod);die;
        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $dept = Department::findOne(['id' => $biodata->DeptId]);

        //ketua bsm
        $ketua_bsm = Department::findOne(['id' => 158]);
        $manage = TblManagement::findOne(['isActive' => 1, 'level' => 0, 'user' => 'cuti']);
        $manage1 = TblManagement::findOne(['isActive' => 1, 'level' => 1, 'user' => 'cuti']);

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }


        if ($model->load(Yii::$app->request->post())) {
            $dur = $model->arr1 - 1;
            // $start_date = date('Y-m-d', strtotime(str_replace("/", "-", $model->start_date)));
            $start_date = $model->start_date;
            $end_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($start_date)) . " + $dur days"));
            $end = date('d/m/Y', strtotime(str_replace("-", "/", $end_date)));
            $start = date('d/m/Y', strtotime(str_replace("-", "/", $start_date)));

            $model->icno = $icno;
            $model->full_date = $start . ' to ' . $end;
            $model->jenis_cuti_id = $id;
            $model->start_date = $start_date;
            $model->end_date = $end_date;
            $model->status = "BSMCHECK";
            $model->tempoh = $model->totalDaysInc;
            $model->mohon_dt = date('Y-m-d H:i:s');
            $model->semakan_by = $manage->icno;
            $model->peraku_by = $dept->chief;
            $model->lulus_by = $ketua_bsm->chief;

            //file
            $model->file = UploadedFile::getInstance($model, 'file');
            $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Cuti Bersalin');

            //Uncomment utk save file
            if ($datas->status == true) {
                $model->file_hashcode = $datas->file_name_hashcode;
            }

            // var_dump($model->file_hashcode);die;
            if ($model->save(false)) {
                $this->log($icno);
                $this->Notification($model->semakan_by, 'Cuti', 'Permohonan Cuti Bersalin Oleh ' . "$biodata->CONm" . ', ' . $model->full_date . ' Menunggu Semakan Anda');
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$icno]);
                $runner->run('dashboard/pending-task-individu', [$model->semakan_by]);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
                return $this->redirect(['cuti/individu/index']);
            }
        }

        return $this->render("form/" . $form, [
            'model' => $model,
            'model_jenis' => $model_jenis,
            'bal' => $bal,
        ]);
    }
    public function Log($icno, $status = null, $rekod = null)
    {
        $log = new CutiLog();

        $id = Yii::$app->db->getLastInsertID();

        $log->ntf_session_id = $icno;
        if (!$status) {
            $log->ntf_tindakan = "Mohon";
            $log->ntf_status = "ENTRY";
        } else {
            $log->ntf_tindakan = "PENGGANTI/BERSETUJU";
            $log->ntf_status = $status;
        }
        if (!$rekod) {
            $log->ntf_cr_id = $rekod;
        } else {
            $log->ntf_cr_id = 0;
        }
        $log->ntf_cr_id = $id;
        $log->ntf_datetime = date('Y-m-d h:i:s');

        $log->save();
    }
    //sabtu dn ahad di kira bekerja
    public function syif($icno)
    {

        $bol = false;

        // $gred = ['119', '118', '117', '116', '302', '303', '360', '368', '295', '389'];
        $identify = TblShiftKeselamatan::find()->where(['icno' => Yii::$app->user->getId()])->andWhere(['YEAR(tarikh)' => date('Y')])->one();
        // $identify = Tblprcobiodata::find()->where(['ICNO' => $icno])->andWhere(['IN', 'gredJawatan', $gred])->one();
        if ($identify) {
            $bol = true;
        }
        return $bol;
    }
    public function Deduction($icno, $start, $end)
    {
        $campus = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", $start)));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", $end)));

        $ph = false;
        if ($campus->campus_id == '2') {
            $ph = CutiUmum::find()->where(['between', 'tarikh_cuti', $start_date, $end_date])
                ->andWhere(['wilayah_sahaja' => 1])->exists();
        } else {
            // echo 'b';die;

            $ph = CutiUmum::find()->where(['between', 'tarikh_cuti', $start_date, $end_date])
                ->andWhere(['sabah_sahaja' => 1])->exists();
        }
        return $ph;
    }

    public function actionCr1_aca($id, $form)
    {
        $icno = Yii::$app->user->getId();
        $yr = date('Y');

        $model = new TblRecords();
        $model->scenario = "cr1_aca";


        $staff_list = Tblprcobiodata::find()->where(['Status' => 1])->andWhere(['<>', 'ICNO', $icno])->asArray()->all();

        $model_jenis = JenisCuti::findOne($id);
        $cuti_rekod = TblRecords::find()->where(['YEAR(start_date)' => date('Y'), 'icno' => $icno])->all();


        $model_pegawai = SetPegawai::findOne(['pemohon_icno' => $icno]);
        // if(){

        // }

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }



        if ($model->load(Yii::$app->request->post())) {


            $model->icno = $icno;
            $model->jenis_cuti_id = $id;

            if (($this->syif($icno)) == true) {
                $model->tempoh =  $model->totalDaysInc;
            } else {

                if (($this->Deduction($icno, $model->start_date, $model->end_date)) == true) {
                    $model->tempoh =  $model->totalDaysEx - 1;
                } else {
                    $model->tempoh =  $model->totalDaysEx;
                }
            }
            $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
            $model->mohon_dt = date('Y-m-d H:i:s');
            $model->peraku_by = isset($model_pegawai->peraku_icno) ? $model_pegawai->peraku_icno : null;
            $model->status = ($model->peraku_by != NULL) ? 'AGREED' : 'VERIFIED';

            $vc = Tindakan::find()->where(['id' => 8])->one();
            if ($model->tempoh >= 14) {

                $model->lulus_by = $vc->icno_pemberi_kuasa;
                $model->status = "BSMCHECK";
            } else {
                $model->lulus_by = $model_pegawai->pelulus_icno;
            }
            if ($model->save()) {

                $this->log($icno);
                if ($model->peraku_by != "NULL") {
                    $this->Notification($model->peraku_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ', ' . $model->full_date . '  Menunggu Perakuan/Kelulusan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/senarai-peraku-lulus">disini</a> untuk membuat tindakan');
                } else {
                    $this->Notification($model->lulus_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ', ' . $model->full_date . '  Menunggu Perakuan/Kelulusan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/senarai-peraku-lulus">disini</a> untuk membuat tindakan');
                }
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$model->ganti_by]);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
                return $this->redirect(['cuti/individu/index']);
            }
        }

        return $this->render("form/" . $form, [
            'model' => $model,
            'staff_list' => $staff_list,
            'model_jenis' => $model_jenis,
            'icno' => $icno,
            'cuti_rekod' => $cuti_rekod,

        ]);
    }
    public function actionCr1($id, $form)
    {
        $icno = Yii::$app->user->getId();
        $yr = date('Y');

        $model = new TblRecords();
        $model->scenario = "cr1";

        // if(!$aca){
        //     $aca = null;
        // }

        $staff_list = Tblprcobiodata::find()->where(['Status' => 1])->andWhere(['<>', 'ICNO', $icno])->asArray()->all();

        $model_jenis = JenisCuti::findOne($id);
        $cuti_rekod = TblRecords::find()->where(['YEAR(start_date)' => date('Y'), 'icno' => $icno])->all();


        $model_pegawai = SetPegawai::findOne(['pemohon_icno' => $icno]);
        // if(){

        // }

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }



        if ($model->load(Yii::$app->request->post())) {


            $model->icno = $icno;
            $model->jenis_cuti_id = $id;

            if (($this->syif($icno)) == true) {
                $model->tempoh =  $model->totalDaysInc;
            } else {

                if (($this->Deduction($icno, $model->start_date, $model->end_date)) == true) {
                    $model->tempoh =  $model->totalDaysEx - 1;
                } else {
                    $model->tempoh =  $model->totalDaysEx;
                }
            }
            $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
            $model->mohon_dt = date('Y-m-d H:i:s');
            $model->peraku_by = isset($model_pegawai->peraku_icno) ? $model_pegawai->peraku_icno : null;
            $vc = Tindakan::find()->where(['id' => 8])->one();
            if ($model->tempoh >= 14) {

                $model->lulus_by = $vc->icno_pemberi_kuasa;
                $model->status = "BSMCHECK";
            } else {
                $model->lulus_by = $model_pegawai->pelulus_icno;
            }
            if ($model->save()) {

                $this->log($icno);
                // $this->Notification($model->ganti_by, 'Cuti', 'Permohonan Cuti Rehat Dalam Negara Oleh '."$bio->CONm".' Pada '.$dt1.' Hingga '.$dt2.' Menunggu Persetujuan Anda');
                $this->Notification($model->ganti_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ', ' . $model->full_date . ' Menunggu Persetujuan Anda . Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/individu/ganti">disini</a> untuk membuat tindakan');
                // $this->send($icno, $model->start_date, $model->end_date);
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$model->ganti_by]);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
                return $this->redirect(['cuti/individu/index']);
            }
        }

        return $this->render("form/" . $form, [
            'model' => $model,
            'staff_list' => $staff_list,
            'model_jenis' => $model_jenis,
            'icno' => $icno,
            'cuti_rekod' => $cuti_rekod,

        ]);
    }

    public function send($id, $start, $end)
    {

        $mod = TblPrcobiodata::findOne(['ICNO' => $id]);
        $access = AksesPengguna::find()->where(['akses_jspiu_id' => $mod->DeptId, 'akses_cuti_int' => 2])->all();

        foreach ($access as $a) {
            $check = TblPrcobiodata::findOne(['ICNO' => $a->akses_cuti_icno]);
            $gred = GredJawatan::findOne(['id' => $check->gredJawatan]);
            if ($gred->gred_no > 10 && $gred->gred_no < 40) {
                $this->Notification($a->akses_cuti_icno, 'Cuti', 'Permohonan Cuti Oleh ' . "$mod->CONm" . ', ' . $start . ' hingga ' . $end . 'Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/individu/ganti">disini</a> untuk melihat senarai kakitangan bercuti hari ini');
            }

            // VarDumper::dump( $a, $depth = 10, $highlight = true);
        }
    }

    public function actionCp($id, $form)
    {
        $icno = Yii::$app->user->getId();
        $yr = date('Y');

        $model = new TblRecords();
        //scenario needed for checking if the 
        $model->scenario = "cp";

        $staff_list = Tblprcobiodata::find()->where(['Status' => 1])->andWhere(['<>', 'ICNO', $icno])->asArray()->all();

        $model_jenis = JenisCuti::findOne($id);
        $cuti_rekod = TblRecords::find()->where(['YEAR(start_date)' => date('Y'), 'icno' => $icno])->all();


        $model_pegawai = SetPegawai::findOne(['pemohon_icno' => $icno]);


        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }



        if ($model->load(Yii::$app->request->post())) {


            $model->icno = $icno;
            $model->jenis_cuti_id = $id;
            $model->status = "INCOMPLETE";
            // if (($this->syif($icno)) == true) {

            //     $model->tempoh =  $model->totalDaysInc;
            // } else {

            //     if (($this->Deduction($icno, $model->start_date, $model->end_date)) == true) {
            //         $model->tempoh =  $model->totalDaysEx - 1;
            //     } else {
            //         $model->tempoh =  $model->totalDaysEx;
            //     }
            // }
            $model->tempoh =  $model->totalDaysInc;
            $vc = Tindakan::find()->where(['id' => 8])->one();

            $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
            $model->mohon_dt = date('Y-m-d H:i:s');
            $dept = Department::findOne(['id' => $bio->DeptId]);
            // if ($dept->chief == $model->icno) {
            //     $model->peraku_by = $vc->icno_pemberi_kuasa;
            // } else {

            //     $model->semakan_by = $dept->chief;
            // }
            $model->semakan_by = $dept->chief;
            if ($model->type == 1) {

                $model->peraku_by = $vc->icno_pemberi_kuasa;
                $model->lulus_by = "860130125080";
            } else {
                $model->lulus_by = "860130125080";
            }
            if ($model->save()) {

                $this->log($icno);
                // $this->Notification($model->ganti_by, 'Cuti', 'Permohonan Cuti Rehat Dalam Negara Oleh '."$bio->CONm".' Pada '.$dt1.' Hingga '.$dt2.' Menunggu Persetujuan Anda');
                $this->Notification($model->ganti_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ', ' . $model->full_date . ' Menunggu Persetujuan Anda . Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/individu/ganti">disini</a> untuk membuat tindakan');
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$model->ganti_by]);
                // Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
                return $this->redirect(['cuti/individu/add-research', 'cid' => $model->id, 'type' => $model->type]);
            }
        }

        return $this->render("form/" . $form, [
            'model' => $model,
            'staff_list' => $staff_list,
            'model_jenis' => $model_jenis,
            'icno' => $icno,
            'cuti_rekod' => $cuti_rekod,
        ]);
    }
    public function actionEditCp($id)
    {
        $icno = Yii::$app->user->getId();
        $yr = date('Y');

        $model = TblRecords::findOne(['id' => $id]);
        //scenario needed for checking if the 
        // $model->scenario = "cp";

        $staff_list = Tblprcobiodata::find()->where(['Status' => 1])->andWhere(['<>', 'ICNO', $icno])->asArray()->all();

        $model_jenis = JenisCuti::findOne($model->jenis_cuti_id);
        $cuti_rekod = TblRecords::find()->where(['YEAR(start_date)' => date('Y'), 'icno' => $icno])->all();


        $model_pegawai = SetPegawai::findOne(['pemohon_icno' => $icno]);


        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }



        if ($model->load(Yii::$app->request->post())) {


            $model->icno = $icno;
            // $model->jenis_cuti_id = $model->jenis_cuti_id;
            $model->status = "INCOMPLETE";

            $model->tempoh =  $model->totalDaysInc;

            $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
            $model->mohon_dt = date('Y-m-d H:i:s');
            $dept = Department::findOne(['id' => $bio->DeptId]);
            $model->semakan_by = $dept->chief;
            $vc = Tindakan::find()->where(['id' => 8])->one();
            if ($model->type = 1) {

                $model->peraku_by = $vc->icno_pemberi_kuasa;
                $model->lulus_by = "860130125080";
            } else {
                $model->lulus_by = "860130125080";
            }
            if ($model->save()) {

                $this->log($icno);
                // $this->Notification($model->ganti_by, 'Cuti', 'Permohonan Cuti Rehat Dalam Negara Oleh '."$bio->CONm".' Pada '.$dt1.' Hingga '.$dt2.' Menunggu Persetujuan Anda');
                $this->Notification($model->ganti_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ', ' . $model->full_date . ' Menunggu Persetujuan Anda . Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/individu/ganti">disini</a> untuk membuat tindakan');
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$model->ganti_by]);
                // Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
                return $this->redirect(['cuti/individu/add-research', 'cid' => $model->id, 'type' => $model->type]);
            }
        }

        return $this->render("edit-cp", [
            'model' => $model,
            'staff_list' => $staff_list,
            'model_jenis' => $model_jenis,
            'icno' => $icno,
            'cuti_rekod' => $cuti_rekod,
        ]);
    }
    public function actionAddResearch($cid, $type)
    {
        $icno = Yii::$app->user->getId();

        $model = new TblResearch();
        $model1  = TblRecords::findOne(['id' => $cid]);
        $rs_d = CutiPenyelidikan::find()->where(['NoKadPengenalan' => $icno, 'ProjectID' => $model1->research_id])->one();
        // $model->scenario = "cp";
        $research_list = TblRecords::find()->where(['icno' => $icno])->andWhere(['jenis_cuti_id' => 17])->all();
        $bio = Tblprcobiodata::findOne(['ICNO' => $model1->icno]);


        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }


        if ($model->load(Yii::$app->request->post())) {

            $model->cuti_record_id = $cid;
            $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);
            $dept = Department::findOne(['id' => $bio->DeptId]);
            $model->verify_by = $dept->chief;
            $vc = Tindakan::find()->where(['id' => 8])->one();
            if ($type = 1) {

                $model->nc_by = $vc->icno_pemberi_kuasa;
                $model->bsm_by = "860130125080";
            } else {
                $model->bsm_by = "860130125080";
            }

            //file
            // $model->file = UploadedFile::getInstance($model, 'file');
            // $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Cuti Kakitangan/Cuti Tanpa Rekod');

            // if ($datas->status == true) {
            //     $model->file_hashcode = $datas->file_name_hashcode;
            // }
            $model->title = $rs_d->TajukPenyelidikan;
            $model->summary = $rs_d->RingkasanPenyelidikan;
            $model->research_id = $model1->research_id;
            if ($model->save()) {
                $model1->status = "ENTRY";
                $model1->save(false);
                $this->log($icno);
                // $this->Notification($model->semakan_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Pada ' . $model1->full_date. ' Menunggu Persetujuan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/cp-list">disini</a> untuk membuat tindakan');

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
                return $this->redirect(['cuti/individu/index']);
            }
        }

        return $this->render("add-research", [
            'model' => $model,
            'research_list' => $research_list,
            'icno' => $icno,
            'rs_d' => $rs_d,
            'cid' => $cid,
            // 'model_jenis' => $model_jenis,
        ]);
    }
    public function Notification($icno, $title, $content)
    {
        $ntf = new Notification();
        $ntf->icno = $icno;
        $ntf->title = $title;
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
    }
    public function actionCr2($id, $form)
    {

        $model = new TblRecords();
        $model->scenario = "cr2";

        $staff_list = Tblprcobiodata::find()->where(['Status' => 1])->asArray()->all();

        $model_jenis = JenisCuti::findOne($id);

        $icno = Yii::$app->user->getId();
        $yr = date('Y');
        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $model_department = Department::findOne(['id' => $biodata->DeptId]);
        $akademik = GredJawatan::findOne(['id' => $biodata->gredJawatan]);
        if ($model_department->chief == $biodata->ICNO) {
            $set = SetPegawai::findOne(['pemohon_icno' => $model_department->chief]);
            $nc = Tindakan::findOne(['status' => "0"]);
            // var_dump($nc->icno_pemberi_kuasa);die;
            $peraku = $set->pelulus_icno;
            $pelulus = $nc->icno_pemberi_kuasa;
            $bio = Tblprcobiodata::findOne(['ICNO' => $peraku]);
        }
        // elseif($akademik->job_category == 1){
        //     $set = SetPegawai::findOne(['pemohon_icno' => $model_department->chief]);
        //     $nc = Tblprcobiodata::find()->where(['gredJawatan' => 2])->andWhere(['!=', 'Status', 6])->one();
        //     $peraku = $set->pelulus_icno;
        //     $pelulus = $nc->ICNO;
        //     $bio = Tblprcobiodata::findOne(['ICNO' => $peraku]);
        // }
        else {
            $tnc_aa = Tblprcobiodata::find()->where(['gredJawatan' => 3])->andWhere(['!=', 'Status', 6])->one();
            $peraku = $model_department->chief;
            $pelulus = $tnc_aa->ICNO;
            $bio = Tblprcobiodata::findOne(['ICNO' => $peraku]);
        }

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $icno;
            $model->jenis_cuti_id = $id;
            $model->tempoh = ($this->syif($icno)) ? $model->totalDays : $model->tempoh = $model->totalDaysEx;
            $model->mohon_dt = date('Y-m-d H:i:s');
            $model->peraku_by = $peraku;
            $model->lulus_by = $pelulus;
            $bio1 = Tblprcobiodata::findOne(['ICNO' => $model->icno]);


            if ($model->save()) {
                $this->log($icno);
                $this->Notification($model->ganti_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio1->CONm" . ' Pada ' . $model->full_date . ' Menunggu Persetujuan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/individu/ganti">disini</a> untuk membuat tindakan');
                // $this->Notification($model->ganti_by, 'Cuti', 'Permohonan Cuti Rehat Luar Negara Oleh '."$bio1->CONm".' Pada '.$dt1.' Hingga '.$dt2.' Menunggu Persetujuan Anda');
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$model->peraku_by]);
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
            'bio' => $bio->CONm,
        ]);
    }


    public function actionCtr($id, $form)
    {

        $model = new TblRecords();
        $model->scenario = "ctr";

        $model_jenis = JenisCuti::findOne($id);

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $dept = Department::findOne(['id' => $biodata->DeptId]);

        //ketua bsm
        $ketua_bsm = Department::findOne(['id' => 158]);

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }


        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $icno;
            $model->jenis_cuti_id = $id;
            $model->tempoh = $model->totalDays;
            $model->mohon_dt = date('Y-m-d H:i:s');
            $model->peraku_by = $dept->pp;
            $model->lulus_by = $ketua_bsm->chief;

            //file
            $model->file = UploadedFile::getInstance($model, 'file');
            $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Cuti Kakitangan/Cuti Tanpa Rekod');

            if ($datas->status == true) {
                $model->file_hashcode = $datas->file_name_hashcode;
            }


            if ($model->save()) {
                $this->log($icno);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
                return $this->redirect(['cuti/individu/index']);
            }
        }

        return $this->render("form/" . $form, [
            'model' => $model,
            'model_jenis' => $model_jenis,
        ]);
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

        // $set = Department::findOne(['id' => $dept->DeptId]);

        $end_sql = 'SELECT * FROM hrm.`cuti_access` a 
            LEFT JOIN hronline.`tblprcobiodata` b ON b.`ICNO` = a.`akses_cuti_icno`
            LEFT JOIN hronline.`gredjawatan` c ON c.`id` = b.`gredJawatan`
            WHERE c.`gred_no` < 41 AND c.`id` > 10  AND a.`akses_cuti_int` = 2 AND a.`akses_jspiu_id`=:dept';
        $sick_leave_verifier = AksesPengguna::findBySql($end_sql, [':dept' => $biodata->DeptId])->all();
        if (empty($sick_leave_verifier)) {
            $end_sql = 'SELECT * FROM hrm.`cuti_access` a 
            LEFT JOIN hronline.`tblprcobiodata` b ON b.`ICNO` = a.`akses_cuti_icno`
            LEFT JOIN hronline.`gredjawatan` c ON c.`id` = b.`gredJawatan`
            WHERE c.`id` > 10  AND a.`akses_cuti_int` = 2 AND a.`akses_jspiu_id`=:dept';
            $sick_leave_verifier = AksesPengguna::findBySql($end_sql, [':dept' => $biodata->DeptId])->all();
        }
        // var_dump($sick_leave_verifier );die;
        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $icno;
            $model->jenis_cuti_id = $id;
            $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);

            $model->tempoh = ($this->syif($icno)) ? $model->totalDaysInc : $model->tempoh = $model->totalDaysEx;
            $model->mohon_dt = date('Y-m-d H:i:s');
            if ($model_department->chief == $biodata->ICNO) {
                $set = SetPegawai::findOne(['pemohon_icno' => $model_department->chief]);

                $model->lulus_by = $set->pelulus_icno;
            } else {
                $set = SetPegawai::findOne(['pemohon_icno' => $icno]);

                $model->lulus_by = $set->pelulus_icno;
                // $model->lulus_by = $model_department->chief;
            }

            // $model->peraku_by = $model_department->chief;
            //file
            $model->file = UploadedFile::getInstance($model, 'file');

            $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '05', 'Medical Certificate');

            if ($datas->status == true) {
                $model->file_hashcode = $datas->file_name_hashcode;
            }

            if ($model->save()) {
                $this->log($icno);
                $this->Notification($model->semakan_by, 'Cuti', 'Permohonan Cuti ' . "$bio->CONm" . ' Pada ' . $model->full_date . ' Menunggu Semakan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/supervisor/sick-leave-list">disini</a> untuk membuat tindakan');
                // $this->Notification($model->semakan_by, 'Cuti', 'Permohonan Cuti Sakit Oleh '."$bio->CONm".' Pada '.$dt1.' Hingga '.$dt2.' Menunggu Semakan Anda');
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$model->semakan_by]);
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
    public function actionCs2($id, $form)
    {

        $model = new TblRecords();
        $model->scenario = "cs2";

        $staff_list = Tblprcobiodata::find()->where(['Status' => 1])->asArray()->all();

        $model_jenis = JenisCuti::findOne($id);

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $model_department = Department::findOne(['id' => $biodata->DeptId]);

        // $set = Department::findOne(['id' => $dept->DeptId]);

        $end_sql = 'SELECT * FROM hrm.`cuti_access` a 
        LEFT JOIN hronline.`tblprcobiodata` b ON b.`ICNO` = a.`akses_cuti_icno`
        LEFT JOIN hronline.`gredjawatan` c ON c.`id` = b.`gredJawatan`
        WHERE c.`gred_no` < 41 AND c.`id` > 10 AND a.`akses_cuti_int` = 2 AND a.`akses_jspiu_id`=:dept';

        $sick_leave_verifier = AksesPengguna::findBySql($end_sql, [':dept' => $biodata->DeptId])->all();
        if (empty($sick_leave_verifier)) {
            $end_sql = 'SELECT * FROM hrm.`cuti_access` a 
            LEFT JOIN hronline.`tblprcobiodata` b ON b.`ICNO` = a.`akses_cuti_icno`
            LEFT JOIN hronline.`gredjawatan` c ON c.`id` = b.`gredJawatan`
            WHERE c.`id` > 10  AND a.`akses_cuti_int` = 2 AND a.`akses_jspiu_id`=:dept';
            $sick_leave_verifier = AksesPengguna::findBySql($end_sql, [':dept' => $biodata->DeptId])->all();
        }
        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $icno;
            $model->jenis_cuti_id = $id;
            $model->tempoh = ($this->syif($icno)) ? $model->totalDaysInc : $model->tempoh = $model->totalDaysEx;
            $model->mohon_dt = date('Y-m-d H:i:s');
            $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
            // $date1 = date_create($model->start_date);
            // $date2 = date_create($model->end_date);
            // $dt1 = date_format($date1, "d/m/Y");
            // $dt2 = date_format($date2, "d/m/Y");
            if ($model_department->chief == $biodata->ICNO) {
                $set = SetPegawai::findOne(['pemohon_icno' => $model_department->chief]);

                $model->lulus_by = $set->pelulus_icno;
            } else {
                // echo 'g';die;
                $set = SetPegawai::findOne(['pemohon_icno' => $icno]);

                $model->lulus_by = $set->pelulus_icno;
            }
            // var_dump($model->lulus_by);die;
            // $model->peraku_by = $model_department->chief;
            //file
            $model->file = UploadedFile::getInstance($model, 'file');
            $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '05', 'Medical Certificate');

            if ($datas->status == true) {
                $model->file_hashcode = $datas->file_name_hashcode;
            }

            if ($model->save()) {
                $this->log($icno);
                $this->Notification($model->semakan_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Pada ' . $model->full_date . ' Menunggu Semakan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/supervisor/sick-leave-list">disini</a> untuk membuat tindakan');
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$model->semakan_by]);
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
    public function actionHso($id, $form)
    {

        $model = new TblRecords();
        $model->scenario = "hso";

        $staff_list = Tblprcobiodata::find()->where(['Status' => 1])->asArray()->all();

        $model_jenis = JenisCuti::findOne($id);

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $model_department = Department::findOne(['id' => $biodata->DeptId]);

        // $set = Department::findOne(['id' => $dept->DeptId]);

        $end_sql = 'SELECT * FROM hrm.`cuti_access` a 
            LEFT JOIN hronline.`tblprcobiodata` b ON b.`ICNO` = a.`akses_cuti_icno`
            LEFT JOIN hronline.`gredjawatan` c ON c.`id` = b.`gredJawatan`
            WHERE c.`gred_no` < 41 AND c.`id` > 10 AND a.`akses_cuti_int` = 2 AND a.`akses_jspiu_id`=:dept';
        $sick_leave_verifier = AksesPengguna::findBySql($end_sql, [':dept' => $biodata->DeptId])->all();
        if (empty($sick_leave_verifier)) {
            $end_sql = 'SELECT * FROM hrm.`cuti_access` a 
            LEFT JOIN hronline.`tblprcobiodata` b ON b.`ICNO` = a.`akses_cuti_icno`
            LEFT JOIN hronline.`gredjawatan` c ON c.`id` = b.`gredJawatan`
            WHERE c.`id` > 10  AND a.`akses_cuti_int` = 2 AND a.`akses_jspiu_id`=:dept';
            $sick_leave_verifier = AksesPengguna::findBySql($end_sql, [':dept' => $biodata->DeptId])->all();
        }

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $icno;
            $model->jenis_cuti_id = $id;
            $model->tempoh = ($this->syif($icno)) ? $model->totalDaysInc : $model->tempoh = $model->totalDaysEx;
            $model->mohon_dt = date('Y-m-d H:i:s');
            $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);


            $set = SetPegawai::findOne(['pemohon_icno' => $icno]);

            $model->lulus_by = $set->pelulus_icno;


            // var_dump($model->lulus_by);die;
            // $model->peraku_by = $model_department->chief;
            //file
            $model->file = UploadedFile::getInstance($model, 'file');
            $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '05', 'Medical Certificate');

            if ($datas->status == true) {
                $model->file_hashcode = $datas->file_name_hashcode;
            }

            if ($model->save()) {
                $this->log($icno);
                $this->Notification($model->semakan_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Pada ' . $model->full_date . ' Menunggu Semakan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/supervisor/sick-leave-list">disini</a> untuk membuat tindakan');
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$model->semakan_by]);
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'ENTRY');

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



    public function actionGanti()
    {
        $icno = Yii::$app->user->getId();

        $model = TblRecords::find()->where(['ganti_by' => $icno, 'status' => 'ENTRY'])->all();

        if ($post = Yii::$app->request->post()) {
            $rekod = TblRecords::findOne(['id' => $post['id']]);
            $model_pegawai = SetPegawai::findOne(['pemohon_icno' => $rekod->icno]);
            if ($rekod->jenis_cuti_id != 2 && $rekod->tempoh < 14) {
                $rekod->peraku_by = isset($model_pegawai->peraku_icno) ? $model_pegawai->peraku_icno : null;
                $rekod->lulus_by = $model_pegawai->pelulus_icno;
            }
            $rekod->ganti_dt = date('Y-m-d H:i:s');
            $rekod->status = ($rekod->peraku_by != NULL) ? 'AGREED' : 'VERIFIED';
            if ($rekod->peraku_by != NULL) {
                $ide = $rekod->peraku_by;
            } else {
                $ide = $rekod->lulus_by;
            }
            // var_dump($rekod->status);die;
            $bio = Tblprcobiodata::findOne(['ICNO' => $rekod->icno]);
            if ($rekod->save()) {

                $this->log($icno, $rekod->status, $rekod->id);
                if ($rekod->status == "AGREED") {
                    $this->Notification($rekod->peraku_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' , ' . $rekod->full_date . ' Menunggu Perakuan/Kelulusan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/senarai-peraku-lulus">disini</a> untuk membuat tindakan');
                } else {
                    $this->Notification($rekod->lulus_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' , ' . $rekod->full_date . ' Menunggu Perakuan/Kelulusan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/senarai-peraku-lulus">disini</a> untuk membuat tindakan');
                }
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$ide]);
                $runner->run('dashboard/pending-task-individu', [$icno]);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Record Updated!']);
                return $this->redirect(['cuti/individu/ganti']);
            }
        }

        return $this->render('ganti', [
            'model' => $model,
        ]);
    }


    public function actionLoadMthLeave()
    {
        $icno = Yii::$app->user->getId();
        $tahun = date('Y');

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


    public function actionJsoncalendar($start = NULL, $end = NULL, $_ = NULL)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $icno = Yii::$app->user->getId();

        $times = TblRecords::find()->where(['icno' => $icno])->all();
        // var_dump($times);die;
        $pub = CutiUmum::find()->all();

        $events = array();
        $event = array();
        // $yr = date("Y", strtotime(date("Y-m-d", strtotime($model->layak_mula)) . " + 1 year"));

        foreach ($times as $time) {
            //Testing
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $time->id;
            $Event->title = $time->jenisCuti->jenis_cuti_nama . '-' . $time->remark;
            $Event->start = date('Y-m-d', strtotime($time->start_date));
            $Event->end = date("Y-m-d", strtotime(date("Y-m-d", strtotime($time->end_date)) . " + 1 day"));
            $events[] = $Event;
        }
        foreach ($pub as $pubs) {
            $Events = new \yii2fullcalendar\models\Event();
            $Events->id = $pubs->id;
            $Events->title = $pubs->nama_cuti;
            $Events->start = date('Y-m-d', strtotime($pubs->tarikh_cuti));
            // $Events->end = date('Y-m-d', strtotime($pubs->tarikh_cuti));
            $events[] = $Events;
        }
        // echo($events);die;
        return $events;
    }

    public function actionStatement($year = null)
    {

        $icno = Yii::$app->user->getId();

        $year = ($year == null) ? date('Y') : $year;

        $layak = Layak::find()->where(['layak_icno' => $icno, 'YEAR(layak_mula)' => $year])->orderBy(['layak_mula' => 'DESC'])->all();
        $cuti = TblRecords::find()->where(['icno' => $icno, 'YEAR(start_date)' => $year])->all();

        return $this->render('statement', [
            'layak' => $layak,
            'cuti' => $cuti,
            'icno' => $icno,
            'year' => $year,
        ]);
    }

    public function actionEntitlement()
    {
        $icno = Yii::$app->user->getId();
        // $year = ($year == null) ? date('Y') : $year;

        $layak = Layak::find()->where(['layak_icno' => $icno])->orderBy(['layak_mula' => SORT_DESC])->all();


        return $this->render('entitlement', [
            'layak' => $layak,
            'id' => $icno,
        ]);
    }
    public function actionLeaveList()
    {
        $icno = Yii::$app->user->getId();

        $cuti_rekod = TblRecords::find()->where(['YEAR(start_date)' => date('Y'), 'icno' => $icno])->all();

        return $this->renderAjax('_list_cuti', [
            'cuti_rekod' => $cuti_rekod,
            'bil' => 1,

        ]);
    }
    public function actionList($year = null, $jenis_cuti_id = null)
    {

        $icno = Yii::$app->user->getId();

        if ($year == null) {
            $year = date('Y');
        }



        $group_jenis_cuti = TblRecords::find()->select(['jenis_cuti_id'])->where(['icno' => $icno])->orderBy(['jenis_cuti_id' => 'ASC'])->groupBy(['jenis_cuti_id'])->asArray(true)->all();

        $group_tahun = TblRecords::find()->select(['YEAR(start_date) AS year'])->where(['icno' => $icno])->orderBy(['start_date' => 'DESC'])->groupBy(['YEAR(start_date)'])->asArray(true)->all();


        $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_id' => $group_jenis_cuti])->all();

        $model = new TblRecords;

        $model1 = TblRecords::find()->where(['icno' => $icno, 'YEAR(start_date)' => $year])->all();


        return $this->render('list', [
            'model' => $model,
            'model1' => $model1,
            'group_jenis_cuti' => $group_jenis_cuti,
            'group_tahun' => $group_tahun,
            'year' => $year,
            'jenis_cuti' => $jenis_cuti,
            'bil' => 1,
        ]);
    }
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

        return $this->redirect(['cuti/individu/list', 'id' => $model->icno]);
    }
    public function actionLeaveDetail($id)
    {

        $model = TblRecords::findOne($id);

        return $this->renderAjax('leave-detail', ['model' => $model]);
    }
    public function actionSubstituteList()
    {
        $icno = Yii::$app->user->getId();

        $model = TblRecords::find()->where(['ganti_by' => $icno])->andWhere(['YEAR(start_date)' => date('Y')])->orderBy(['start_date' => SORT_DESC])->all();
        return $this->render('substitute-list', [
            'model' => $model,
            'bil' => 1,
        ]);
    }
    public function actionGcrList()
    {
        $icno = Yii::$app->user->getId();

        $model = GcrApplication::find()->where(['pemohon_icno' => $icno])->orderBy(['mohon_dt' => SORT_DESC])->all();
        return $this->render('gcr-list', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionApplyGcr()
    {

        $id = Yii::$app->user->getId();
        $check = TblRecords::find()->where(['NOT IN', 'status', ['APPROVED', 'REJECTED']])->andWhere(['jenis_cuti_id' => 1])->andWhere(['icno' => $id])->andWhere(['YEAR(start_date)' => '2020'])->one();
        // var_dump($check->id);die;
        //checking tetap or kontrak
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $check2 = GcrApplication::find()->where(['pemohon_icno' => $id])->orderBy(['mohon_dt' => SORT_DESC])->andWhere(['isActive' => 1])->one();
        $open = CutiOpenApplication::findOne(['status' => 1]);
        $exclude = CutiTempTable::findOne(['icno' => $id, 'allowed' => 1]);
        if (!$exclude) {
            // var_dump('d');die;
            if (!$open) {
                Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'warning', 'msg' => 'Harap Maaf. Permohonan GCR dan CBTH telah di tutup']);
                return $this->redirect(['cuti/individu/index']);
            }
        }
        if ($biodata->statLantikan != 1) {
            Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'warning', 'msg' => 'Harap Maaf. Permohonan GCR dan CBTH hanya dibuka untuk kakitangan Tetap sahaja']);
            return $this->redirect(['cuti/individu/index']);
        }
        if ($biodata->Status == 2) {
            Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'warning', 'msg' => 'Harap Maaf. Permohonan GCR dan CBTH hanya dibuka untuk kakitangan Tetap dan Aktif  sahaja']);
            return $this->redirect(['cuti/individu/index']);
        }
        if ($check) {
            Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'warning', 'msg' => 'Anda Mempunyai Permohonan Cuti Yang Masih Belum Diluluskan. Sila Berhubung Dengan Penyelia Cuti Anda']);
            return $this->redirect(['cuti/individu/index']);
        }
        if ($check2) {
            Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'warning', 'msg' => 'Anda Telah Pun Menghantar Permohonan']);
            return $this->redirect(['cuti/individu/gcr-list']);
        }

        $model = new GcrApplication();
        $data = date('m');

        if ($data == '01') {
            $curr_yr = date('Y', strtotime('-1 year'));
        } else {
            $curr_yr = date('Y');
        }
        $tmt = $curr_yr . '-12-31';
        $start = $curr_yr . '-01-01';
        $model->scenario = "carry";

        // var_dump($tmt );die;
        $dept = Department::findOne(['id' => $biodata->DeptId]);
        $pp = SetPegawai::findOne(['pemohon_icno' => $id]);
        $bsm = Department::findOne(['id' => '158']);
        $stat = GredJawatan::findOne(['id' => $biodata->gredJawatan]);
        $end_sql = 'SELECT * FROM hrm.`cuti_access` a 
            LEFT JOIN hronline.`tblprcobiodata` b ON b.`ICNO` = a.`akses_cuti_icno`
            LEFT JOIN hronline.`gredjawatan` c ON c.`id` = b.`gredJawatan`
            WHERE c.`gred_no` < 41 AND a.`akses_cuti_int` = 2 AND a.`akses_jspiu_id`=:dept';
        $sick_leave_verifier = AksesPengguna::findBySql($end_sql, [':dept' => $biodata->DeptId])->all();

        if ($biodata->DeptId == 156) {
            $sick_leave_verifier = AksesPengguna::find()->where(['akses_cuti_int' => 2])->andWhere(['akses_jspiu_id' => $biodata->DeptId])->all();
        }


        $layak = Layak::find()->where(['layak_icno' => $id])->andWhere(['layak_tamat' => $tmt])->one();
        if (!$layak) {
            $layak = Layak::find()->where(['layak_icno' => $id])->andWhere(['layak_mula' => $start])->one();
            if (!$layak) {
                Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'warning', 'msg' => 'Harap Maaf. Anda Tidak Mempunyai Kelayakan cuti yang terkini, Sila Berhubung dengan penyelia cuti JFPIB anda']);
                return $this->redirect(['cuti/individu/index']);
            }
        }
        // else{
        //     Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'warning', 'msg' => 'Harap Maaf. Anda Tidak Mempunyai Kelayakan cuti yang terkini, Sila Berhubung dengan penyelia cuti JFPIB anda']);
        //     return $this->redirect(['cuti/individu/index']);
        // }
        // var_dump($layak->layak_bawa_lepas);die;

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {


            $model->pemohon_icno = $id;
            $model->mohon_dt = date('Y-m-d h:i:s');
            $model->dept_id = $biodata->DeptId;
            // var_dump($model->tempoh);die;
            if ($dept->chief == $id) {
                $model->peraku_by = $pp->pelulus_icno;
            } else {

                $model->peraku_by = $dept->chief;
            }
            $model->lulus_by = $bsm->chief;

            if ($model->save()) {
                // $this->log($id);
                // $this->Notification($model->ganti_by, 'Cuti', 'Permohonan Cuti Rehat Dalam Negara Oleh '."$bio->CONm".' Pada '.$dt1.' Hingga '.$dt2.' Menunggu Persetujuan Anda');
                $this->Notification($model->semakan_by, 'Cuti', 'Permohonan GCR dan CBTH Oleh ' . "$biodata->CONm" . ' Menunggu Semakan Anda');

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan GCR Anda Berjaya dihantar!']);
                return $this->redirect(['cuti/individu/gcr-list']);
            }
        }
        return $this->render('apply-gcr', [
            // 'searchModel' => $searchModel,
            'sick_leave_verifier' => $sick_leave_verifier,
            'model' => $model,
            'biodata' => $biodata,
            'layak' => $layak,
            'id' => $id
        ]);
    }

    public function actionSurat($id)
    {

        $model = TblRecords::findOne(['id' => $id]);
        $bal = 360 - TblRecords::totalCutiBersalin($model->icno);
        $total = TblRecords::totalAppcb($model->icno);
        $child = TblRecords::totalChild($model->icno);
        $manage = TblManagement::findOne(['isActive' => 1, 'level' => 1, 'user' => 'cuti']);

        $this->view->title = "Surats";
        $css = file_get_contents('./css/esurat.css');

        $biodata = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('cb-letter', [
            'id' => $id,
            'model' => $model,
            'total' => $total,
            'bal' => $bal,
            'child' => $child,
            'manage' => $manage,
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Surat_kelulusan_cuti_bersalin $biodata->CONm.pdf",
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
            // 'options' => ['title' => "surat"],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => [''],
                'WriteHTML' => [$css, 1]

                //    'SetFooter' => [' {PAGENO}'],
            ]
        ]);
        return $pdf->render();

        // return the pdf output as per the destination setting

    }
}
