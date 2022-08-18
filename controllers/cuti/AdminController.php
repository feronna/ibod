<?php

namespace app\controllers\cuti;

use kartik\mpdf\Pdf;

use app\models\cuti\AksesPengguna;
use app\models\cuti\AksesPenggunaSearch;
use app\models\cuti\CutiLog;
use app\models\cuti\CutiOpenApplication;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\cuti\CutiRekod;
use app\models\cuti\CutiTblBod;
use app\models\cuti\CutiTempTable;
use app\models\cuti\CutiUmum;
use app\models\cuti\GcrApplication;
use app\models\cuti\GcrApplicationSearch;
use app\models\cuti\Layak;
use app\models\cuti\JenisCuti;
use app\models\cuti\TblRecords;
use yii\web\UploadedFile;
use app\models\cuti\TblRecordsSearch;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\cuti\SetPegawai;
use app\models\cuti\Tindakan;
use app\models\Notification;
use phpDocumentor\Reflection\Types\Null_;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use app\models\cuti\Model;
use app\models\cuti\TblManagement;
use app\models\cuti\TblResearch;
use app\models\Cuti\TempTableSearch;
use app\models\kehadiran\TblYears;
use app\models\smp_ppi\CutiPenyelidikan;
use tebazil\runner\ConsoleCommandRunner;
use yii\db\ActiveQuery;

class AdminController extends Controller
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
                        // 'actions' => ['*'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();

                            $check = AksesPengguna::find()->where(['akses_cuti_icno' => $logicno])->andWhere(['akses_cuti_int' => 3])->exists();
                            $boleh = false;
                            if ($check) {
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

    public function actionGcrListAdmin()
    {
        $id = Yii::$app->user->getId();
        $data = date('m');
        if ($data == '01') {
            $curr_yr = date('Y-m-d', strtotime('-1 year'));
        } else {
            $curr_yr = date('Y');
        }
        $end = $curr_yr . '-12-31';
        $start = $curr_yr . '-01-01';

        $gcr = GcrApplication::find()->where(['IN', 'status', ['APPROVED']])->andWhere(['isActive' => 1, 'flag' => 1])->orderBy(['mohon_dt' => SORT_ASC])->limit(300)->all();
        if ($pilih = Yii::$app->request->post()) {

            foreach ($pilih['GcrApplication']['id'] as $v) {
                // var_dump($pilih['GcrApplication']['id'] );die;
                if ($v != 0) {
                    $model = GcrApplication::findOne($v);
                    $model->status = 'APPROVED';
                    $model->lulus_dt = date('Y-m-d H:i:s');
                    $model->flag = 0;
                    // var_dump($model->pemohon_icno);die;
                    if ($model->save()) {
                        $this->actionAuto($model->pemohon_icno, $model->id);

                        //----------Model Notification ---------//
                        // $ntf = new Notification();
                        // $ntf->icno = $model->icno;
                        // $ntf->title = 'Kehadiran';
                        // $ntf->content = "Status pengesahan Ketidakpatuhan pada $model->formatTarikh ($model->day) telah disahkan";
                        // $ntf->ntf_dt = date('Y-m-d H:i:s');
                        // $ntf->save();
                    }
                }
            }
            //--------Model Notification-----------//
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan telah dihantar!']);
            return $this->redirect(['cuti/admin/gcr-list-admin']);
        }
        return $this->render('gcr-list-admin', [
            // 'searchModel' => $searchModel,
            // 'biodata' => $biodata,
            // 'layak' => $layak,
            'start' => $start,
            'end' => $end,
            'gcr' => $gcr,
            'id' => $id,
            'bil' => 1,

        ]);
    }
    public static function actionAuto($icno, $gcrid)
    {
        $data = date('m');

        // if ($data == '01') {
        //     $curr_yr = date('Y-m-d', strtotime('-1 year'));
        // } else {
        $curr_yr = '2022';
        //  $curr_yr = date('Y');
        // }
        $end = $curr_yr . '-12-31';
        $start = $curr_yr . '-01-01';
        $date = strtotime("-1 year", strtotime($start));
        $date1 = strtotime("-1 year", strtotime($end));

        // $gcr = GcrApplication::find()->where(['peraku_by' => $id])->andWhere(['status' => 'VERIFIED'])->orderBy(['mohon_dt' => SORT_ASC])->all();
        $exist = Layak::find()->where(['layak_icno' => $icno])->andWhere(['layak_tamat' => $end])->exists();
        $up =  date("Y-m-d", $date);
        //layak tamat
        $lowerdt =  date("Y-m-d", $date1);
        //  var_dump($exist);die;
        $gcr = GcrApplication::findOne(['id' => $gcrid]);
        //   var_dump($gcr->cbth_applied);die;

        if (!$exist) {
            $model = new Layak();
            $update = Layak::find()->where(['layak_icno' => $icno])->andWhere(['layak_tamat' => $lowerdt])->one();
            //  var_dump($update);die;
            $model->layak_icno = $icno;
            $model->layak_mula = $start;
            $model->layak_tamat = $end;
            $model->layak_cuti = Layak::getRate($icno, $start, $end);
            $model->layak_bawa_lepas = $gcr->cbth_applied;
            $model->layak_bawa_depan = 0;
            $update->layak_bawa_depan = $gcr->cbth_applied;
            $model->layak_ambil = 0;
            $model->layak_hapus = 0;
            $model->layak_gcr = 0;
            $update->layak_gcr = $gcr->gcr_applied;
            // var_dump($gcr->gcr_applied +  $gcr->cbth_applied);die;
            $update->layak_hapus = (Layak::getBakiOld($gcr->pemohon_icno, NULL, $lowerdt)) - ($gcr->gcr_applied +  $gcr->cbth_applied);
            $model->save();
            $update->save();
        } else {
            //update new kelayakan
            $update = Layak::find()->where(['layak_icno' => $icno])->andWhere(['layak_tamat' => $end])->one();
            $update->layak_bawa_lepas = $gcr->cbth_applied;
            //updaate kelayakan lama
            $model = Layak::find()->where(['layak_icno' => $icno])->andWhere(['layak_tamat' => $lowerdt])->one();
            $model->layak_hapus = (Layak::getBakiOld($gcr->pemohon_icno, NULL, $lowerdt)) - ($gcr->gcr_applied +  $gcr->cbth_applied);
            $model->layak_gcr = $gcr->gcr_applied;
            $model->layak_bawa_depan = $gcr->cbth_applied;
            $model->save();
            $update->save();
        }
    }

    //download
    public function actionGcrApplicationList()
    {
        $icno = Yii::$app->user->getId();

        $check = AksesPengguna::find()->where(['akses_cuti_icno' => $icno])->andWhere(['akses_cuti_int' => 3])->andWhere(['IN', 'akses_jspiu_id', ['158', '35']])->exists();

        if (!$check) {
            Yii::$app->session->setFlash('alert', ['title' => 'Alert', 'type' => 'warning', 'msg' => 'You Do Not Have Access To Perform This Action']);
            return $this->redirect(['cuti/individu/index']);
        }
        // $query = GcrApplication::find()->where(['isActive' => 1]);
        // $dataProviders = new ActiveDataProvider([
        //     'query' => $query,
        //     'pagination' => [
        //         'pageSize' => 2500,
        //     ],
        // ]);
        $searchModel = new GcrApplicationSearch();
        $dataProviders = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('gcr-application-list', [
            'searchModel' => $searchModel,
            'dataProviders' => $dataProviders,
            // 'dataProviders' => $dataProviders,
        ]);
    }

    public function actionCtrList()
    {
        $icno = Yii::$app->user->getId();

        $model = TblRecords::find()->where(['status' => 'BSMCHECK'])->all();
        // $dataProvider = new ActiveDataProvider([
        //     'query' => $model,
        // ]);
        return $this->render('ctr-list', [
            'model' => $model,
            // 'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCr2List()
    {
        $icno = Yii::$app->user->getId();
        $manage = TblManagement::findOne(['icno' => $icno]);
        $jtmk = AksesPengguna::findOne(['akses_cuti_icno'=> $icno,'akses_cuti_int' => 3,'akses_jspiu_id'=>35]);
        if($manage || $jtmk){
            $model = TblRecords::find()->where(['status' => 'BSMCHECK'])->all();

        }else{
            $model = '';
        }
        // $dataProvider = new ActiveDataProvider([
        //     'query' => $model,
        // ]);
        return $this->render('cr2-list', [
            'model' => $model,
            // 'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCbListApproval()
    {

        $icno = Yii::$app->user->getId();
        $find = TblManagement::findOne(['icno' => $icno, 'level' => 1, 'isActive' => 1]);
        // if($find){}
        $model = TblRecords::find()->where(['jenis_cuti_id' => 28])->andWhere(['status' => 'VERIFIED_KJ'])->all();
        return $this->render('cb-list-approval', [
            'model' => $model,
            'access' => $find,
            // 'dataProvider' => $dataProvider,
        ]);
    }
    public function actionOpenApplication()
    {

        //ini akan sma macam wbb miji  //kena cari cara utk bt semua pengawai dapat notification
        $icno = Yii::$app->user->getId();
        $model = new CutiOpenApplication();
        $check = AksesPengguna::find()->where(['akses_cuti_icno' => $icno])->andWhere(['akses_cuti_int' => 3])->andWhere(['IN', 'akses_jspiu_id', ['158', '35']])->exists();

        if (!$check) {
            Yii::$app->session->setFlash('alert', ['title' => 'Alert', 'type' => 'warning', 'msg' => 'You Do Not Have Access To Perform This Action']);
            return $this->redirect(['cuti/individu/index']);
        }
        if ($model->load(Yii::$app->request->post())) {
            $arr = explode(" ", $model->full_date);

            $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
            $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));

            $model->open_by = $icno;
            $model->start_date = $start_date;
            $model->end_date = $end_date;
            $model->status = 1;
            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan GCR dan CBTH telah Di Buka!']);
                return $this->redirect(['cuti/admin/open-application']);
            }
        }
        return $this->render('open', [
            'model' => $model,
            // 'models' => $models,
            // 'bil' => 1,
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $DataProvider,
        ]);
        //        var_dump($akses);die;

    }
    public function Log($icno, $id, $ori_fd, $ori_sd, $ori_ed)
    {
        $log = new CutiLog();

        $log->ntf_session_id = $icno;
        $log->ntf_tindakan = "Admin Check";
        $log->ntf_status = "CHECK";
        $log->ntf_cr_id = $id;
        $log->ntf_datetime = date('Y-m-d h:i:s');
        $log->full_date = $ori_fd;
        $log->start_date = $ori_sd;
        $log->end_date = $ori_ed;
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

    public function actionCr2Detail($id)
    {

        $model = TblRecords::findOne($id);
        $id = $model->jenis_cuti_id;
        $icno = Yii::$app->user->getId();

        $ori_fd = $model->full_date;
        $ori_sd = $model->start_date;
        $ori_ed = $model->end_date;
        $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
        $model_jenis = JenisCuti::findOne($id);
        $total = TblRecords::totalCutiBersalin($model->icno);
        $bal = 360 - $total;
        if ($model->load(Yii::$app->request->post())) {
            $model->semakan_by = $icno;
            if ($id != 2) {
                $model->status = 'CHECK';
            }
            // if ($id == 28) {
            //     $model->tempoh = $model->totalDays;
            // }
            $model->semakan_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                $this->Notification($model->icno, 'Cuti', 'Permohonan Cuti Anda Telah Di Periksa Oleh Penyelia Cuti dan Sedang Menunggu Kelulusan Pegawai Pelulus/Peraku Anda');
                $this->Notification($model->peraku_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Menunggu Perakuan/Kelulusan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/senarai-peraku-lulus">disini</a> untuk membuat tindakan');

                $this->Log($icno, $model->id, $ori_fd, $ori_sd, $ori_ed);

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['cuti/admin/cr2-list']);
            }
        }
        return $this->renderAjax('cr2-detail', ['model' => $model, 'bal' => $bal]);
    }
    public function actionReport($id = null, $year = null, $date = null)
    {
        if (!$date) {
            $s = date('Y') . '-01-01';
            $e = date('Y-m-d');
            $date = $s . ' - ' . $e;
        }
        $arr = explode(" ", $date);

        $start = date('Y-m-d', strtotime(date($arr[0])));
        $end = date('Y-m-d', strtotime(date($arr[2])));
        // echo $start_date;die;
        $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->all();
        if ($id == null && $year == null) {
            $year = date("Y");
            $id = 20;
        }

        // $model = TblRecords::find()->where(['jenis_cuti_id' => $id])->andWhere(['YEAR(start_date)' => $year]);
        $model = TblRecords::find()->where(['jenis_cuti_id' => $id])->andWhere(['between', 'start_date', $start, $end]);
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 250,
            ],
            'sort' => [
                'defaultOrder' => [
                    'start_date' => SORT_ASC,
                    // 'title' => SORT_ASC, 
                ]
            ],
        ]);

        return $this->render(
            'report',
            [
                'year' => $year,
                'id' => $id,
                'jenis_cuti' => $jenis_cuti,
                'model' => $model,
                'dataProvider' => $dataProvider

            ]
        );
    }
    public function actionReportLeaveList($id = null, $year = null)
    {
        $var = 1;
        $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->all();
        if ($id == null && $year == null) {

            $year = date('Y-m-d');
            $var = null;
        }

        // $model = TblRecords::find()->where(['jenis_cuti_id' => $id])->andWhere(['BETWEEN', 'start_date', $start, $end]);
        $model = TblRecords::find()->joinWith('kakitangan')
            ->where(['jenis_cuti_id' => $id])->andWhere(['YEAR(start_date)' => $year])
            ->groupBy(['hronline.tblprcobiodata.DeptId']);

        $data = [];
        $years = TblYears::find()->where(['status' => 1])->orderBy(['year' => SORT_DESC])->all();
        foreach ($years as $v) {
            $data[$v->year] = $v->year;
        }
        $tahun = 1999;
        for ($i = 19; $i > 1; $i--) {
            $data[$i] = $tahun + $i;
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 250,
            ],
        ]);
        // var_dump($data);die;
        return $this->render(
            'report-leave-list',
            [
                'id' => $id,
                'data' => $data,
                'year' => $year,
                'jenis_cuti' => $jenis_cuti,
                'model' => $model,
                'dataProvider' => $dataProvider,
                'var' => $var,

            ]
        );
    }

    //to copy ph from last year
    public function actionCopyPh($id)
    {
        $cy = date('Y');
        $cm = date('m');
        if (($cy != $id && $cm == 1) || ($cy != $id)) {
            $id = date("Y", strtotime(date("Y-m-d", strtotime(date("$id-m-d"))) . " - 1 year"));
        }
        $yr = CutiUmum::find()->where(['YEAR(tarikh_cuti)' => $id])->all();
        foreach ($yr as $ph) {
            $date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($ph->tarikh_cuti)) . " + 1 year"));
            // echo '<br>';
            $model = new CutiUmum();
            $model->nama_cuti = $ph->nama_cuti;
            $model->tarikh_cuti = $date;
            $model->sabah_sahaja = $ph->sabah_sahaja;
            $model->wilayah_sahaja = $ph->wilayah_sahaja;
            $model->catatan = $ph->catatan;
            $model->save(false);
        }

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Record Updated!']);
        return $this->redirect(['cuti/admin/ph-list']);
    }
    public function actionPhList($year = null)
    {
        $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->all();
        if ($year == null) {
            $year = date("Y");
        }
        $tahun = date("Y", strtotime(date("Y-m-d", strtotime(date('Y-m-d'))) . " + 1 year"));

        $data = [];
        $yr = TblYears::find()->where(['status' => 1])->all();
        foreach ($yr as $v) {
            $data[$v->year] = $v->year;
        }
        $data[$tahun] = $tahun;
        // var_dump($data);
        $model = CutiUmum::find()->where(['YEAR(tarikh_cuti)' => $year])->orderBy([
            'tarikh_cuti' => SORT_ASC //specify sort order ASC for ascending DESC for descending      
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        return $this->render(
            'ph-list',
            [
                'year' => $year,
                'data' => $data,
                'jenis_cuti' => $jenis_cuti,
                'model' => $model,
                'dataProvider' => $dataProvider

            ]
        );
    }
    public function actionBehalfList()
    {

        $model = Tindakan::find(['status' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
        ]);
        return $this->render(
            'behalf-list',
            [
                'model' => $model,
                'dataProvider' => $dataProvider

            ]
        );
    }

    //Pelulus Approve cs1
    public function actionCbList()
    {
        $searchModel = new TblRecordsSearch();
        $dataProvider = $searchModel->cbsearch(Yii::$app->request->queryParams);

        return $this->render('cb-list', [
            'searchModel' => $searchModel,
            'model' => $dataProvider,
            'bil' => 1

        ]);
    }

    public function actionBod()
    {
        if ($post = Yii::$app->request->post()) {
            $rekod = CutiTblBod::findOne(['record_id' => $post['id']]);
            // var_dump($rekod);die;
            $bio = Tblprcobiodata::findOne(['ICNO' => $rekod->icno]);
            $rekod->bsm_date = date('Y-m-d');

            $rekod->status = '3';
            if ($rekod->save()) {
                $this->logs(Yii::$app->user->getId(), $rekod->id, "Terima Kembali Bertugas", $rekod->status);

                // $this->Notification($rekod->bsm_id, 'Cuti', 'Di Maklumkan bahawa ' . $bio->CONm . ' Telah Kembali Bertugas Pada ' .$rekod->date_bod .'Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/admin/cb-list">disini</a> untuk membuat tindakan selanjutnya' );
                return $this->redirect(['cuti/admin/cb-list']);
            }
        }

        // return $this->render('bod', [
        //     // 'model' => $model,
        //    ]);
    }
    public function actionSurat($id)
    {

        $model = TblRecords::findOne(['id' => $id]);
        $bal = 360 - TblRecords::totalCutiBersalin($model->icno);
        $total = TblRecords::totalAppcb($model->icno);
        $child = TblRecords::totalChild($model->icno);
        $bio = Tblprcobiodata::findOne(['ICNO'=>$model->icno]);
        $kj = Department::find()->where(['id'=>$bio->DeptId])->one();
        // var_dump($kj->chief);die;
        $manage = TblManagement::findOne(['isActive' => 1, 'level' => 1, 'user' => 'cuti']);

        $this->view->title = "Surats";
        $css = file_get_contents('./css/suratcb.css');

        $biodata = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('cb-letter', [
            'id' => $id,
            'kj' => $kj,
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

    public function actionPeraku()
    {
        if ($post = Yii::$app->request->post()) {

            $id = Yii::$app->user->getId();
            $rekod = TblRecords::findOne(['id' => $post['id']]);
            $ketua_bsm = Department::findOne(['id' => 158]);

            if ($rekod->jenis_cuti_id == 28) {
                $rekod->lulus_by = $ketua_bsm->chief;
            }
            if ($rekod->jenis_cuti_id != 2) {
                $rekod->status = 'CHECK';
            } else {
                $rekod->status = 'CHECKED';
            }
            $rekod->semakan_dt = date('Y-m-d H:i:s');
            $rekod->semakan_by = $id;
            if ($rekod->save()) {
                if ($rekod->jenis_cuti_id != 2) {
                    $this->Notification($rekod->icno, 'Cuti', 'Permohonan Cuti Anda Telah Disemak Oleh Penyelia');
                } else {
                    $this->Notification($rekod->icno, 'Cuti', 'Permohonan Cuti Rehat Luar Negara Menunggu Kelulusan Ketua Canselori/TNC');
                }
                $this->logs(Yii::$app->user->getId(), $rekod->id, "Cuti Rehat 2", $rekod->status);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Record Updated!']);
                return $this->redirect(['cuti/admin/cr2-list']);
            }
        }
    }
    public function actionCbPeraku()
    {
        if ($post = Yii::$app->request->post()) {

            $id = Yii::$app->user->getId();
            $rekod = TblRecords::findOne(['id' => $post['id']]);
            if ($rekod->jenis_cuti_id == 28) {
                $rekod->status = 'VERIFIED';
            }
            $rekod->p_verify_dt = date('Y-m-d H:i:s');
            // $rekod->semakan_by = $id;
            if ($rekod->save()) {

                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$rekod->lulus_by]);
                $this->logs(Yii::$app->user->getId(), $rekod->id, "Peraku Cuti Bersalin", $rekod->status);
                $ntf = new Notification();
                $ntf->icno = $rekod->icno;
                $ntf->title = "Surat Kelulusan Cuti Bersalin";
                $ntf->content = 'Permohonan Cuti Bersalin anda telah diluluskan. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/individu/list">disini</a> untuk memuat turun surat kelulusan cuti bersalin anda';
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Berjaya Dikemaskini!']);
                return $this->redirect(['cuti/admin/cb-list-approval']);
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'ENTRY');

        return $this->render('semakan-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionAccess()
    {
        $query = AksesPengguna::find();
        $searchModel = new AksesPenggunaSearch();
        $params = Yii::$app->request->queryParams;
        if ($params) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else {

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        }


        return $this->render('access', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDeleteAccess($id)
    {
        $model = AksesPengguna::findOne(['akses_cuti_id' => $id])->delete();
        // $this->findModel($model)->delete();

        return $this->redirect(['access']);
    }
    public function actionDeleteAction($id)
    {
        $model = Tindakan::findOne(['id' => $id])->delete();
        // $this->findModel($model)->delete();

        return $this->redirect(['behalf-list']);
    }
    public function actionUpdateAccess($id)
    {
        $model = AksesPengguna::findOne(['akses_cuti_id' => $id]);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                return $this->redirect(['access']);
            }
        }
        return $this->render('update-access', [
            'model' => $model,
        ]);
    }
    public function actionUpdatePh($id)
    {
        $model = CutiUmum::findOne(['id' => $id]);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->sabah_sahaja == null) {
                $model->sabah_sahaja = 0;
            }
            if ($model->wilayah_sahaja == null) {
                $model->wilayah_sahaja = 0;
            }
            if ($model->save()) {
                return $this->redirect(['cuti/admin/ph-list']);
            }
        }
        return $this->render('update-ph', [
            'model' => $model,
        ]);
    }
    public function actionDeletePh($id)
    {

        $exist = CutiUmum::find()->where(['id' => $id])->one();
        $exist->delete();

        return $this->redirect(['cuti/admin/ph-list', 'id' => $id]);
    }
    public function actionAddAccess($id)
    {
        $model1 = AksesPengguna::findOne(['akses_cuti_icno' => $id]);
        $model = new AksesPengguna();

        if ($model->load(Yii::$app->request->post())) {
            $model->akses_cuti_icno = $id;
            if ($model->save()) {
                return $this->redirect(['access']);
            }
        }
        return $this->render('add-access', [
            'model' => $model,
            'model1' => $model1,
        ]);
    }
    public function actionAddSupervisor($id)
    {
        $model1 = Tblprcobiodata::findOne(['ICNO' => $id]);

        $model = new AksesPengguna();

        if ($model->load(Yii::$app->request->post())) {
            $model->akses_cuti_icno = $id;
            if ($model->save()) {
                return $this->redirect(['cuti/supervisor/supervised-staff']);
            }
        }
        return $this->render('add-supervisor', [
            'model' => $model,
            'model1' => $model1,

        ]);
    }
    public function actionAddBehalfAction()
    {
        // $model1 = AksesPengguna::findOne(['akses_cuti_icno' => $id]);
        $model = new Tindakan();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_datetime = date('Y-m-d h:i:s');
            if ($model->temp == 0) {
                $model->status = 0;
            }
            if ($model->save()) {
                return $this->redirect(['behalf-list']);
            }
        }
        return $this->render('add-action', [
            'model' => $model,
            // 'model1' => $model1,
        ]);
    }
    public function actionUpdateAction($id)
    {
        $model = Tindakan::findOne(['id' => $id]);
        // $officer = SetPegawai::find()->where()

        if ($model->load(Yii::$app->request->post())) {
            if ($model->temp == 0) {
                $model->status = 0;
            }
            if ($model->save()) {
                return $this->redirect(['behalf-list']);
            }
        }
        return $this->render('update-action', [
            'model' => $model,
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

    public function actionCreates()
    {

        $modelCustomer = new CutiUmum(['scenario' => 'create']);
        $modelsAddress = [new CutiUmum()];

        // $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        // $layak = Layak::find()->where(['layak_icno' => $id])->orderBy(['layak_mula' => SORT_DESC])->all();

        $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->all();
        // $model = new TblRecords();

        // $modelCustomer->scenario = "manual";

        // $staff_list = Tblprcobiodata::find()->where(['Status' => 1])->andWhere(['<>', 'ICNO', $icno])->asArray()->all();
        // $sick_leave_verifier = AksesPengguna::find()->where(['akses_cuti_int' => 2])->andWhere(['akses_jspiu_id' => $biodata->DeptId])->all();

        // $model_jenis = JenisCuti::findOne($id);

        // $model_pegawai = SetPegawai::findOne(['pemohon_icno' => $icno]);


        if (Yii::$app->request->isAjax && $modelCustomer->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($modelCustomer);
        }



        if ($modelCustomer->load(Yii::$app->request->post())) {
            // echo 'd';die;
            $modelsAddress = Model::createMultiple(CutiUmum::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());

            // $valid = $modelCustomer->validate();
            // $valid = Model::validateMultiple($modelsAddress) && $valid;
            // $modelCustomer->tarikh_cuti =$modelCustomer->tarikh_cuti;
            // var_dump( $modelsAddress);die;

            // $modelCustomer->mohon_dt = date('Y-m-d H:i:s');

            // $modelCustomer->save(false);
            // if ($valid) {
            foreach ($modelsAddress as $modelAddress) {
                //         $modelAddress = new TblRecords();
                if ($modelAddress->tarikh_cuti) {


                    if ($modelAddress->sabah_sahaja == null) {
                        $modelAddress->sabah_sahaja = 0;
                    }
                    if ($modelAddress->wilayah_sahaja == null) {
                        $modelAddress->wilayah_sahaja = 0;
                    }
                    $date = date('Y-m-d', strtotime(str_replace("/", "-", $modelAddress->tarikh_cuti)));

                    $modelAddress->nama_cuti =   $modelAddress->nama_cuti;
                    $modelAddress->tarikh_cuti =   $date;
                    // var_dump( $date);die;

                    $modelAddress->catatan =   $modelAddress->catatan;
                    $modelAddress->sabah_sahaja =   $modelAddress->sabah_sahaja;
                    $modelAddress->wilayah_sahaja =   $modelAddress->wilayah_sahaja;

                    // var_dump($modelAddress->tempv2);die;

                    $modelAddress->save(false);
                }
            };
            return $this->redirect(['cuti/admin/ph-list']);
        }

        return $this->render('creates', [
            // 'searchModel' => $searchModel,
            // 'biodata' => $biodata,
            // 'layak' => $layak,
            // 'id' => $id,
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new CutiUmum] : $modelsAddress,
            'jenis_cuti' => $jenis_cuti,
            // 'sick_leave_verifier' => $sick_leave_verifier,
        ]);
    }

    //cp

    public function actionCpList()
    {
        $icno = Yii::$app->user->getId();

        $model = TblRecords::find()->where(['status' => 'VERIFIED'])->andWhere(['lulus_by' => $icno, 'jenis_cuti_id' => 17])->all();
        // $dataProvider = new ActiveDataProvider([
        //     'query' => $model,
        // ]);
        return $this->render('cp-list', [
            'model' => $model,
            // 'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCpDetail($id)
    {

        $model = TblRecords::findOne($id);
        $icno = Yii::$app->user->getId();
        $res = TblResearch::findOne(['cuti_record_id' => $id]);
        $mod = CutiPenyelidikan::findOne(['NoKadPengenalan' => $model->icno, 'ProjectID' => $model->research_id]);


        if ($res->load(Yii::$app->request->post())) {

            $res->bsm_dt = date('Y-m-d H:i:s');
            if ($res->bsm_status == "APPROVED") {

                $model->status = "APPROVED";
                $model->lulus_dt = date('Y-m-d H:i:s');
                $model->lulus_remark = $res->bsm_remark;
            } else {
                $model->status = "REJECTED";
                $model->lulus_dt = date('Y-m-d H:i:s');
                $model->lulus_remark = $res->bsm_remark;
            }

            if ($res->save()) {
                $model->save(false);
                // $this->Notification($model->icno, 'Cuti', 'Permohonan Cuti Anda Telah Di Periksa Oleh Penyelia Cuti dan Sedang Menunggu Kelulusan Pegawai Pelulus/Peraku Anda');
                // $this->Log($icno, $model->id, $ori_fd, $ori_sd, $ori_ed);

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['cuti/admin/cp-list']);
            }
        }
        return $this->renderAjax('cp-detail', [
            'model' => $model,
            'res' => $res,
            'mod' => $mod,

        ]);
    }
    public function actionIndex()
    {
        $searchModel = new GcrApplicationSearch();
        $query = GcrApplication::find()->where(['YEAR(mohon_dt)' => date('Y'), 'isActive' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 2500,
            ],
        ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDelete($id)
    {
        $admin = GcrApplication::findOne($id);
        $this->logs(Yii::$app->user->getId(), $id, "Admin Delete GCR", $admin->status);

        $admin->delete();
        return $this->redirect(['cuti/admin/gcr-application-list']);
    }
    //admin add to be excluded from gcr closed daaete
    public function actionAdminIndex()
    {
        $searchModel = new TempTableSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('admin-index', [

            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
        ]);
    }

    public function actionAdd()
    {
        $icno = Yii::$app->user->getId();

        $model = new CutiTempTable();
        if ($model->load(Yii::$app->request->post())) {

            $model->added_by = $icno;
            $model->added_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                $this->logs(Yii::$app->user->getId(), $model->id, "Admin Add Staff to be excluded", 'Added');

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['cuti/admin/admin-index']);
            }
        }
        return $this->renderAjax('add', ['model' => $model]);
    }

    public function actionUpdates($id)
    {

        $model = CutiTempTable::findOne(['id' => $id]);
        if ($model->load(Yii::$app->request->post())) {

            // $model->added_by = date('Y-m-d H:i:s');

            if ($model->save()) {
                $this->logs(Yii::$app->user->getId(), $id, "Admin Update Staff to be excluded", 'UPDATED');

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['cuti/admin/admin-index']);
            }
        }
        return $this->renderAjax('updates', ['model' => $model]);
    }
}
