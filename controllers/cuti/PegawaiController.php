<?php

namespace app\controllers\cuti;

use app\models\cuti\AksesPengguna;
use app\models\cuti\CutiLog;
use app\models\cuti\CutiTblBod;
use app\models\cuti\GcrApplication;
use app\models\cuti\JenisCuti;
use app\models\cuti\Layak;
use app\models\cuti\SetPegawai;
use app\models\cuti\TblManagement;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\cuti\TblRecordsSearch;
use app\models\cuti\TblRecords;
use app\models\cuti\TblResearch;
use app\models\cuti\Tindakan;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use app\models\Notification;
use app\models\smp_ppi\CutiPenyelidikan;
use app\models\system_core\TblDashboardInfo;
use tebazil\runner\ConsoleCommandRunner;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;

class PegawaiController extends Controller
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
                            $check1 = SetPegawai::find()->where(['pelulus_icno' => $logicno])->exists();
                            $check2 = Tindakan::find()->where(['icno_tindakan' => $logicno])->exists();
                            $check3 = SetPegawai::find()->where(['peraku_icno' => $logicno])->exists();
                            $check = AksesPengguna::find()->where(['akses_cuti_icno' => $logicno])->exists();

                            $boleh = false;
                            if (!$check1 || !$check2 || !$check3 || !$check) {
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


    public function actionSenaraiPerakuLulus()
    {
        $icno = Yii::$app->user->getId();
        $tindakan = Tindakan::find()->where(['icno_tindakan' => $icno])->andWhere(['status' => 1])->one();
        // var_dump($tindakan);die;

        if ($tindakan) {
            $icno = $tindakan->icno_pemberi_kuasa;
        }
        // var_dump($icno);die;

        // $lulus = TblRekod::findAll(['app_by' => $icno, 'remark_status' => 'ENTRY']);
        $model = TblRecords::find()->where(['peraku_by' => $icno])->andWhere(['IN', 'status', ['AGREED', 'CHECK']])->andWhere(['!=', 'jenis_cuti_id', '17'])->all();
        $app = TblRecords::find()->where(['lulus_by' => $icno])->andWhere(['IN', 'status', ['CHECKED', 'VERIFIED']])->andWhere(['!=', 'jenis_cuti_id', '17'])->all();
        // $bal = Layak::getBakiLatest($model->icno);
        if ($pilih = Yii::$app->request->post()) {

            // VarDumper::dump( $pilih, $depth = 10, $highlight = true);die;
            foreach ($pilih['TblRecords']['id'] as $k => $v) {
                if ($v != 0) {
                    $model = TblRecords::findOne($v);
                    $model->status = 'APPROVED';
                    $model->lulus_dt = date('Y-m-d H:i:s');
                    // var_dump($model->id);die;
                    if ($model->save()) {
                        $this->Perakulog($model->id, $model->status);
                        // }
                        $runner = new ConsoleCommandRunner();
                        $runner->run('dashboard/pending-task-individu', [$model->lulus_by]);
                        $runner->run('dashboard/pending-task-individu', [$model->icno]);
                    }
                }
            }
            //--------Model Notification-----------//
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan telah dihantar!']);
            return $this->redirect(['cuti/pegawai/senarai-peraku-lulus']);
        }
        return $this->render('senarai-peraku-lulus', [
            'model' => $model,
            'app' => $app,
            // 'bal' => $bal,
        ]);
    }

    //cuti penyelidikan
    public function actionCpList()
    {
        $icno = Yii::$app->user->getId();
        $tindakan = Tindakan::find()->where(['icno_tindakan' => $icno])->andWhere(['status' => 1])->one();
        // var_dump($tindakan);die;

        if ($tindakan) {
            $icno = $tindakan->icno_pemberi_kuasa;
        }

        $model = TblRecords::find()->where(['semakan_by' => $icno])->andWhere(['IN', 'status', ['ENTRY']])->andWhere(['jenis_cuti_id' => 17])->all();
        $app = TblRecords::find()->where(['peraku_by' => $icno])->andWhere(['IN', 'status', ['CHECKED']])->andWhere(['jenis_cuti_id' => 17])->all();
        // $bal = Layak::getBakiLatest($model->icno);

        return $this->render('cp-list', [
            'model' => $model,
            'app' => $app,
            // 'bal' => $bal,
        ]);
    }

    public function actionCpDetailsKj($id)
    {

        $model = TblRecords::findOne($id);
        $model->scenario = "agree";
        $bal = Layak::getBakiLatest($model->icno);
        $res = TblResearch::findOne(['cuti_record_id' => $id]);
        $mod = CutiPenyelidikan::findOne(['NoKadPengenalan' => $model->icno, 'ProjectID' => $model->research_id]);
        $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);

        if ($res->load(Yii::$app->request->post())) {

            $res->verify_dt = date('Y-m-d H:i:s');
            $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
            if ($res->verify_status == "APPROVED") {
                if ($model->type == 1) {

                    $res->nc_status = "CHECKED";
                    $model->status = "CHECKED";
                    $model->semakan_dt = date('Y-m-d H:i:s');
                    $model->semakan_remark = $res->verify_remark;
                } else {

                    $res->bsm_status = "VERIFIED";
                    $model->status = "CHECKED";
                    $model->semakan_dt = date('Y-m-d H:i:s');
                    $model->semakan_remark = $res->verify_remark;
                }
            } else {
                $model->status = "REJECTED";
                $model->semakan_dt = date('Y-m-d H:i:s');
                $model->semakan_remark = $res->verify_remark;
            }


            if ($res->save()) {
                $model->save(false);
                // if ($model->status == "VERIFIED") {
                //     $this->Notification($model->lulus_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Pada ' . $model->full_date . ' Menunggu Perakuan/Kelulusan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/senarai-peraku-lulus">disini</a> untuk membuat tindakan');
                // }
                // if ($model->status == "REJECTED") {
                //     $this->Notification($model->icno, 'Cuti', 'Permohonan Cuti Anda Pada ' . $model->full_date . ' Tidak Diluluskan oleh Pegawai Peraku');
                // }
                $this->Perakulog($model->id, $model->status);
                // $runner = new ConsoleCommandRunner();
                // $runner->run('dashboard/pending-task-individu', [$model->lulus_by]);
                // $runner->run('dashboard/pending-task-individu', [$model->peraku_by]);
                // $this->Notification($model->peraku_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Pada ' . $model->full_date. ' Menunggu Persetujuan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/cp-list">disini</a> untuk membuat tindakan');

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['cuti/pegawai/cp-list']);
            }
        }
        return $this->renderAjax('cp-details-kj', [
            'model' => $model,
            'bal' => $bal,
            'res' => $res,
            'mod' => $mod,
        ]);
    }
    public function actionCpDetailsNc($id)
    {

        $model = TblRecords::findOne($id);
        $model->scenario = "agree";
        $bal = Layak::getBakiLatest($model->icno);
        $res = TblResearch::findOne(['cuti_record_id' => $id]);
        $mod = CutiPenyelidikan::findOne(['NoKadPengenalan' => $model->icno, 'ProjectID' => $model->research_id]);
        $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);

        if ($res->load(Yii::$app->request->post())) {

            $res->nc_dt = date('Y-m-d H:i:s');
            $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
            if ($res->nc_status == "APPROVED") {

                $res->bsm_status = "VERIFIED";
                $model->status = "VERIFIED";
                $model->peraku_dt = date('Y-m-d H:i:s');
                $model->peraku_remark = $res->nc_remark;
            } else {
                $model->status = "REJECTED";
                $model->peraku_dt = date('Y-m-d H:i:s');
                $model->peraku_remark = $res->nc_remark;
            }


            if ($res->save()) {
                $model->save(false);
                // if ($model->status == "VERIFIED") {
                //     $this->Notification($model->lulus_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Pada ' . $model->full_date . ' Menunggu Perakuan/Kelulusan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/senarai-peraku-lulus">disini</a> untuk membuat tindakan');
                // }
                // if ($model->status == "REJECTED") {
                //     $this->Notification($model->icno, 'Cuti', 'Permohonan Cuti Anda Pada ' . $model->full_date . ' Tidak Diluluskan oleh Pegawai Peraku');
                // }
                $this->Perakulog($model->id, $model->status);
                // $runner = new ConsoleCommandRunner();
                // $runner->run('dashboard/pending-task-individu', [$model->lulus_by]);
                // $runner->run('dashboard/pending-task-individu', [$model->peraku_by]);
                //link dari wana
                // $this->Notification($model->lulus_by, 'Cuti', 'Permohonan Cuti Penyelidikan Oleh ' . "$bio->CONm" . ' Pada ' . $model->full_date. ' Menunggu Persetujuan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/cp-list">disini</a> untuk membuat tindakan');

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['cuti/pegawai/cp-list']);
            }
        }
        return $this->renderAjax('cp-details-nc', [
            'model' => $model,
            'bal' => $bal,
            'res' => $res,
            'mod' => $mod,

        ]);
    }

    public function actionLeaveDetailPeraku($id)
    {

        $model = TblRecords::findOne($id);
        $model->scenario = "agree";
        $bal = Layak::getBakiLatest($model->icno);

        if ($model->load(Yii::$app->request->post())) {

            $model->peraku_dt = date('Y-m-d H:i:s');
            $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
            $find = TblManagement::findOne(['level' => 1, 'isActive' => 1, 'user' => 'cuti']);
            $ketua_bsm = Department::findOne(['id' => 158]);

            $model->p_verify = '';
            if ($model->jenis_cuti_id == 28) {
                $model->status = 'VERIFIED_KJ';
                $model->p_verify = $find->icno;
                $model->lulus_by = $ketua_bsm->chief;
            } else
            if ($model->jenis_cuti_id == 2) {
                $model->status = 'BSMCHECK';
            } else {
                $model->status = 'VERIFIED';

                // if ($rekod->jenis_cuti_id != 2  && $rekod->tempoh < 14) {

                //     $rekod->peraku_by = isset($model_pegawai->peraku_icno) ? $model_pegawai->peraku_icno : null;
                //     $rekod->lulus_by = $model_pegawai->pelulus_icno;
                // }

            }

            if ($model->save()) {
                if ($model->status == "VERIFIED") {
                    $this->Notification($model->lulus_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Pada ' . $model->full_date . ' Menunggu Perakuan/Kelulusan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/senarai-peraku-lulus">disini</a> untuk membuat tindakan');
                }
                if ($model->status == "VERIFIED_KJ") {
                    $this->Notification($model->p_verify, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Pada ' . $model->full_date  . ' Menunggu Perakuan/Kelulusan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/admin/cb-list-approval">disini</a> untuk membuat tindakan');
                    $runner = new ConsoleCommandRunner();
                    $runner->run('dashboard/pending-task-individu', [$model->p_verify]);
                }
                if ($model->status == "REJECTED") {
                    $this->Notification($model->icno, 'Cuti', 'Permohonan Cuti Anda Pada ' . $model->full_date . ' Tidak Diluluskan oleh Pegawai Peraku');
                    $this->Recalibrate($model->id);
                }
                $this->Perakulog($model->id, $model->status);
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$model->lulus_by]);
                $runner->run('dashboard/pending-task-individu', [$model->peraku_by]);

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['cuti/pegawai/senarai-peraku-lulus']);
            }
        }
        return $this->renderAjax('leave-detail-peraku', [
            'model' => $model,
            'bal' => $bal
        ]);
    }


    public function actionList()
    {
        $searchModel = new TblRecordsSearch();
        $dataProvider = $searchModel->searchss(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStaffLeave()
    {

        $icno = Yii::$app->user->getId();
        $bp = Tindakan::findOne(['icno_tindakan' => $icno]);
        if ($bp) {
            $icno = $bp->icno_pemberi_kuasa;
        }
        $model = SetPegawai::find()
            ->andFilterWhere(['or', ['=', 'peraku_icno', $icno], ['=', 'pelulus_icno', $icno]])
            ->all();

        $year = date('Y');
        $month = date('m');


        return $this->render('staff-leave', ['model' => $model, 'bil' => 1, 'year' => $year, 'month' => $month]);
    }


    public function actionGcrListChecked()
    {

        $id = Yii::$app->user->getId();
        $bp = Tindakan::findOne(['icno_tindakan' => $id]);
        if ($bp) {
            $id = $bp->icno_pemberi_kuasa;
        }
        $data = date('m');

        if ($data == '01') {
            $curr_yr = date('Y', strtotime('-1 year'));
        } else {
            $curr_yr = date('Y');
        }
        $end = $curr_yr . '-12-31';
        $start = $curr_yr . '-01-01';

        $gcr = GcrApplication::find()->where(['peraku_by' => $id])->andWhere(['status' => 'CHECKED'])->orderBy(['mohon_dt' => SORT_ASC])->all();
        // $layak =  
        // Layak::find()->where(['layak_icno' => 950426125329])->andWhere(['layak_tamat' => $tmt])->one();
        // var_dump($end,$start);die;


        if ($pilih = Yii::$app->request->post()) {

            foreach ($pilih['GcrApplication']['id'] as $k => $v) {
                if ($v != 0) {
                    $model = GcrApplication::findOne($v);
                    $model->status = 'VERIFIED';
                    $model->peraku_dt = date('Y-m-d H:i:s');

                    if ($model->save()) {

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
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
            return $this->redirect(['cuti/pegawai/gcr-list-checked']);
        }

        return $this->render('gcr-list-checked', [
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

    public function actionGcrListBsm($dept)
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

        $gcr = GcrApplication::find()->where(['lulus_by' => $id])->andWhere(['status' => 'VERIFIED'])->andWhere(['dept_id' => $dept])->orderBy(['mohon_dt' => SORT_ASC])->all();
        if ($pilih = Yii::$app->request->post()) {

            foreach ($pilih['GcrApplication']['id'] as $k => $v) {
                if ($v != 0) {
                    $model = GcrApplication::findOne($v);
                    $model->status = 'APPROVED';
                    $model->peraku_dt = date('Y-m-d H:i:s');
                    // var_dump($model->id);die;
                    if ($model->save()) {
                        $this->actionAuto($model->pemohon_icno, $model->id);
                    }
                }
            }
            //--------Model Notification-----------//
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan telah dihantar!']);
            return $this->redirect(['cuti/pegawai/sort']);
        }
        return $this->render('gcr-list-bsm', [
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
    public function actionSort()
    {
        $icno = Yii::$app->user->getId();
        // $searchModel = new TblPermohonanSearch();
        // $status = ['ENTRY', 'PINDAAN', 'APPROVED', 'REJECTED', 'PENDING'];
        $query = GcrApplication::find()->select('dept_id')->distinct()->where(['lulus_by' => $icno])->andWhere(['status' => 'VERIFIED'])->all();

        // if (Yii::$app->request->isAjax) {
        //     return $this->renderAjax('s_permohonan', [
        //                 'data' => $data,
        //     ]);
        // }
        return $this->render('sort', [
            'query' => $query,
            'bil' => 1,
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $DataProvider,
        ]);
    }


    public function actionGcrVerifyBsm($id)
    {

        $model = GcrApplication::findOne($id);
        // $model->scenario = "agree";

        if ($model->load(Yii::$app->request->post())) {
            $model->lulus_dt = date('Y-m-d H:i:s');
            // var_dump($model->lulus_dt);die;

            // $model->semakan_dt = "CHECKED";
            // $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);

            if ($model->save(false)) {
                $this->actionAuto($model->pemohon_icno, $id);

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['cuti/pegawai/sort']);
            }
        }
        return $this->renderAjax('gcr-verify-bsm', ['model' => $model]);
    }
    //func ni utk detect kalau cuti kena cancel semasa permohonan gcr staff aktif,
    // kalau return true func akan move tempoh cuti yg dibatalkan atau ditolak ke
    // jumlah cbth tahun hadapan atau pada tahun semasa sekiranya kelayakan sdah ditambah utk cr1 and cr2 sahaja
    public function Recalibrate($id)
    {
        $record = TblRecords::findOne(['id' => $id]);
        $cbth = GcrApplication::find()->where(['pemohon_icno' => $record->icno])->andWhere(['YEAR(mohon_dt)' => date('Y')])->one();
        $nye =  Layak::find()->where(['layak_icno' => $record->icno])->orderBy(['layak_mula' => SORT_DESC])->one();
        $yr = date('Y', strtotime('+1 year'));

        if ($cbth) {
            if ($record->jenis_cuti_id == 1 || $record->jenis_cuti_id == 2) {

                if ($nye->layak_tamat == $yr . "-12-31") {
                    $yrs = date('Y') . "-12-31";
                    $lye =  Layak::find()->where(['layak_icno' => $record->icno])
                        ->andWhere(['YEAR(layak_tamat)' => $yrs])->one();
                    // var_dump($lye->layak_tamat);die;
                    $ch = GcrApplication::getCbth($lye->layak_id);
                    if ($ch < ($cbth->cbth_applied + $record->tempoh)) {
                        $nye->layak_bawa_lepas = $ch;
                        $lye->layak_bawa_depan = $ch;
                        $cbth->cbth_applied = $ch;
                        $nye->save(false);
                        $lye->save(false);
                        $cbth->save(false);
                    } else {
                        $nye->layak_bawa_lepas = $cbth->cbth_applied + $record->tempoh;
                        $lye->layak_bawa_depan = $cbth->cbth_applied + $record->tempoh;
                        $cbth->cbth_applied = $cbth->cbth_applied + $record->tempoh;
                        $nye->save(false);
                        $lye->save(false);
                        $cbth->save(false);
                    }
                } else {
                    $lye =  Layak::find()->where(['layak_icno' => $record->icno])
                        ->andWhere(['YEAR(layak_mula)' => date('Y')])->one();
                    $ch = GcrApplication::getCbth($lye->layak_id);
                    if ($ch < ($cbth->cbth_applied + $record->tempoh)) {

                        $cbth->cbth_applied = $ch;
                        $cbth->save(false);
                    } else {

                        $cbth->cbth_applied = $cbth->cbth_applied + $record->tempoh;
                        $cbth->save(false);
                    }
                }
            }
            // var_dump($cbth->cbth_applied);die;
        }
        // echo 'ds';die;
    }
    //auto tmbh kelayakan cuti klaau tidak wujud utk tujuan update cbth dan gcr
    public static function actionAuto($icno, $gcrid)
    {
        $data = date('m');

        // if ($data == '01') {
        //     $curr_yr = date('Y', strtotime('-1 year'));
        // } else {
        // $curr_yr = '2021';
        // $curr_yr = date('Y', strtotime('+1 year'));
        $curr_yr = date('Y');
        // }
        $start = $curr_yr . '-01-01';
        $end = $curr_yr . '-12-31';
        $date = strtotime("-1 year", strtotime($start));
        $date1 = strtotime("-1 year", strtotime($end));

        // $gcr = GcrApplication::find()->where(['peraku_by' => $id])->andWhere(['status' => 'VERIFIED'])->orderBy(['mohon_dt' => SORT_ASC])->all();
        $up =  date("Y-m-d", $date);
        $lowerdt =  date("Y-m-d", $date1);
        $exist = Layak::find()->where(['layak_icno' => $icno])->andWhere(['layak_tamat' => $end])->exists();

        $gcr = GcrApplication::findOne(['id' => $gcrid]);
        // var_dump( $gcr->gcr_applied);die;

        if (!$exist) {
            $model = new Layak();
            $update = Layak::find()->where(['layak_icno' => $icno])->andWhere(['layak_tamat' => $lowerdt])->one();
            $model->layak_icno = $icno;
            $model->layak_mula = $start;
            $model->layak_tamat = $end;
            $model->layak_cuti = Layak::getRate($icno, $start, $end);
            $model->layak_bawa_lepas = $gcr->cbth_applied;
            $model->layak_bawa_depan = 0;
            // var_dump($start);die;
            $update->layak_bawa_depan = $gcr->cbth_applied;
            $model->layak_ambil = 0;
            $model->layak_hapus = 0;
            $model->layak_gcr = 0;
            $update->layak_gcr = $gcr->gcr_applied;
            // var_dump($gcr->gcr_applied +  $gcr->cbth_applied);die;
            $update->layak_hapus = (Layak::getBakiOld($gcr->pemohon_icno, $update->layak_mula, $update->layak_tamat)) - ($gcr->gcr_applied +  $gcr->cbth_applied);
            $model->save();
            $update->save();
        } else {
            //update new kelayakan
            $update = Layak::find()->where(['layak_icno' => $icno])->andWhere(['layak_tamat' => $end])->one();
            $update->layak_bawa_lepas = $gcr->cbth_applied;
            //updaate kelayakan lama
            $model = Layak::find()->where(['layak_icno' => $icno])->andWhere(['layak_mula' => $up])->one();
            $model->layak_hapus = (Layak::getBakiOld($gcr->pemohon_icno, $update->layak_mula, $lowerdt)) - ($gcr->gcr_applied +  $gcr->cbth_applied);
            $model->layak_gcr = $gcr->gcr_applied;
            $model->layak_bawa_depan = $gcr->cbth_applied;
            $model->save();
            $update->save();
        }
    }

    public function actionGcrVerify($id)
    {

        $model = GcrApplication::findOne($id);
        // $model->scenario = "agree";

        if ($model->load(Yii::$app->request->post())) {

            $model->peraku_dt = date('Y-m-d H:i:s');
            // $model->semakan_dt = "CHECKED";
            // $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['cuti/pegawai/gcr-list-checked']);
            }
        }
        return $this->renderAjax('gcr-verify', ['model' => $model]);
    }

    public function syif($icno)
    {

        $bol = false;
        $gred = ['119', '118', '117', '116', '302', '303', '360', '368', '295', '389'];
        $identify = Tblprcobiodata::find()->where(['ICNO' => $icno])->andWhere(['IN', 'gredJawatan', $gred])->one();
        if ($identify) {
            $bol = true;
        }
        return $bol;
    }
    public function actionLeaveDetailLulus($id)
    {

        $model = TblRecords::findOne($id);
        $nc = Tblprcobiodata::find()->where(['gredJawatan' => 2])->andWhere(['!=', 'Status', 6])->one();

        $session_id = Yii::$app->user->getId();
        $model->scenario = "agree";

        $ori_fd = $model->full_date;
        $ori_sd = $model->start_date;
        $ori_ed = $model->end_date;
        $bal = Layak::getBakiLatest($model->icno);

        if ($model->load(Yii::$app->request->post())) {

            $arr = explode(" ", $model->full_date);

            $newsDate = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
            $neweDate = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));

            $var = false;
            if ($model->jenis_cuti_id == 28) {
                $var = false;
            } else {
                if ($neweDate != $ori_ed || $newsDate != $ori_sd) {
                    // echo 'here';die;

                    $model->start_date = $newsDate;
                    $model->end_date = $neweDate;
                    // $model->full_date = $model->full_date;
                    $model->tempoh = ($this->syif($model->icno)) ? $model->totalDays : $model->tempoh = $model->totalDaysEx;
                    $var = true;
                } else {

                    $model->start_date = $newsDate;
                    $model->end_date = $neweDate;
                    $model->tempoh = ($this->syif($model->icno)) ? $model->totalDays : $model->tempoh = $model->totalDaysEx;
                    // $model->tempoh = $model->totalDays;
                }
            }

            $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);

            $date1 = date_create($model->start_date);
            $date2 = date_create($model->end_date);
            $dt1 = date_format($date1, "d/m/Y");
            $dt2 = date_format($date2, "d/m/Y");
            $model->lulus_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                if ($var) {
                    $this->Log($model->icno, $id, $ori_fd, $ori_sd, $ori_ed);
                    $this->Notification($model->icno, 'Cuti', 'Permohonan Cuti Anda Pada ' . $dt1 . ' Hingga ' . $dt2 . ' Telah Diluluskan, Tapi Tarikh Cuti Anda Telah Di ubah Oleh Ketua Jabatan Anda. Sila Rujuk Senarai Cuti Anda');
                } else {
                    if ($model->jenis_cuti_id == 28) {
                        $ntf = new Notification();
                        $ntf->icno = $model->icno;
                        $ntf->title = "Surat Kelulusan Cuti Bersalin";
                        $ntf->content = 'Permohonan Cuti Bersalin anda telah diluluskan. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/individu/list">disini</a> untuk memuat turun surat kelulusan cuti bersalin anda';
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                    } else {


                        if ($model->status == 'APPROVED') {

                            $this->Notification($model->icno, 'Cuti', 'Permohonan Cuti Anda Pada ' . $dt1 . ' Hingga ' . $dt2 . ' Telah Diluluskan');
                        } elseif ($model->status == 'REJECTED') {
                            $this->Notification($model->icno, 'Cuti', 'Permohonan Cuti Anda Pada ' . $dt1 . ' Hingga ' . $dt2 . ' Tidak Diluluskan');
                            $this->Recalibrate($model->id);
                        }
                    }
                }
                $this->Perakulog($model->id, $model->status);

                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$model->lulus_by]);

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['cuti/pegawai/senarai-peraku-lulus']);
            }
        }
        return $this->renderAjax('leave-detail-lulus', [
            'model' => $model,
            'bal' => $bal,
            'nc' => $nc->ICNO
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
    public function Perakulog($id, $status)
    {
        $log = new CutiLog();
        $icno = Yii::$app->user->getId();
        $log->ntf_session_id = $icno;
        $log->ntf_tindakan = "Peraku / Lulus";
        $log->ntf_status = $status;
        $log->ntf_cr_id = $id; //id dari tblrecords
        $log->ntf_datetime = date('Y-m-d h:i:s');
        $log->save();
    }
    public function actionPeraku()
    {
        if ($post = Yii::$app->request->post()) {

            $rekod = TblRecords::findOne(['id' => $post['id']]);
            $model_pegawai = SetPegawai::findOne(['pemohon_icno' => $rekod->icno]);
            $find = TblManagement::findOne(['level' => 1, 'isActive' => 1, 'user' => 'cuti']);
            $rekod->p_verify = '';
            $ketua_bsm = Department::findOne(['id' => 158]);

            if ($rekod->jenis_cuti_id == 28) {
                $rekod->status = 'VERIFIED_KJ';
                $rekod->p_verify = $find->icno;
                $rekod->lulus_by = $ketua_bsm->chief;
            } else
            if ($rekod->jenis_cuti_id == 2) {
                $rekod->status = 'BSMCHECK';
            } else {
                $rekod->status = 'VERIFIED';

                // if ($rekod->jenis_cuti_id != 2  && $rekod->tempoh < 14) {

                //     $rekod->peraku_by = isset($model_pegawai->peraku_icno) ? $model_pegawai->peraku_icno : null;
                //     $rekod->lulus_by = $model_pegawai->pelulus_icno;
                // }

            }
            $bio = Tblprcobiodata::findOne(['ICNO' => $rekod->icno]);

            $date1 = date_create($rekod->start_date);
            $date2 = date_create($rekod->end_date);
            $dt1 = date_format($date1, "d/m/Y");
            $dt2 = date_format($date2, "d/m/Y");
            $rekod->peraku_dt = date('Y-m-d H:i:s');
            $manage = TblManagement::find()->where(['user' => 'cuti', 'level' => '0', 'isActive' => 1])->one();
            if ($rekod->save()) {
                if ($rekod->status == "VERIFIED") {
                    $this->Notification($rekod->lulus_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Pada ' . $dt1 . ' Hingga ' . $dt2 . ' Menunggu Perakuan/Kelulusan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/senarai-peraku-lulus">disini</a> untuk membuat tindakan');
                }
                if ($rekod->status == "VERIFIED_KJ") {
                    $this->Notification($rekod->p_verify, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Pada ' . $dt1 . ' Hingga ' . $dt2 . ' Menunggu Perakuan/Kelulusan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/admin/cb-list-approval">disini</a> untuk membuat tindakan');
                    $runner = new ConsoleCommandRunner();
                    $runner->run('dashboard/pending-task-individu', [$rekod->p_verify]);
                }
                if ($rekod->status == "BSMCHECK") {
                    // $this->Notification('801004125610', 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Pada ' . $dt1 . ' Hingga ' . $dt2 . ' Menunggu Semakan Anda');
                    $this->Notification($manage->icno, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Pada ' . $dt1 . ' Hingga ' . $dt2 . ' Menunggu Semakan Anda');
                }
                $this->Perakulog($rekod->id, $rekod->status);
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$rekod->lulus_by]);
                $runner->run('dashboard/pending-task-individu', [$rekod->peraku_by]);


                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Record Updated!']);
                return $this->redirect(['cuti/pegawai/senarai-peraku-lulus']);
            }
        }
    }

    public function actionLulus()
    {
        if ($post = Yii::$app->request->post()) {

            $rekod = TblRecords::findOne(['id' => $post['id']]);
            $rekod->status = 'APPROVED';
            $bio = Tblprcobiodata::findOne(['ICNO' => $rekod->icno]);

            $date1 = date_create($rekod->start_date);
            $date2 = date_create($rekod->end_date);
            $dt1 = date_format($date1, "d/m/Y");
            $dt2 = date_format($date2, "d/m/Y");
            $rekod->lulus_dt = date('Y-m-d H:i:s');
            if ($rekod->save()) {
                if ($rekod->jenis_cuti_id == 28) {
                    $ntf = new Notification();
                    $ntf->icno = $rekod->icno;
                    $ntf->title = "Surat Kelulusan Cuti Bersalin";
                    $ntf->content = 'Permohonan Cuti Bersalin anda telah diluluskan. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/individu/list">disini</a> untuk memuat turun surat kelulusan cuti bersalin anda';
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                } else {
                    $this->Notification($rekod->icno, 'Cuti', 'Permohonan Cuti Anda Pada ' . $dt1 . ' Hingga ' . $dt2 . ' Telah Diluluskan');
                }
                // if ($rekod->status == 'APPROVED') {
                $this->Perakulog($rekod->id, $rekod->status);
                // }
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$rekod->lulus_by]);
                $runner->run('dashboard/pending-task-individu', [$rekod->icno]);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Record Updated!']);
                return $this->redirect(['cuti/pegawai/senarai-peraku-lulus']);
            }
        }
    }

    //api to show list staff under supervision
    public function actionStaffonleave()
    {
        $icno = Yii::$app->user->getId();
        $model = TblRecords::TeamList($icno);
        $today = date('Y-m-d');
        // VarDumper::dump( $model, $depth = 10, $highlight = true);die;

        return $this->render('staffonleave', [
            'model' => $model,
            'today' => $today,
            'bil' => 1,
        ]);
    }
    public function actionStaffonleaveskb()
    {
        $icno = Yii::$app->user->getId();
        $model = TblRecords::TeamList($icno);
        $today = date('Y-m-d');
        // VarDumper::dump( $model, $depth = 10, $highlight = true);die;

        return $this->render('staffonleaveskb', [
            'model' => $model,
            'today' => $today,
            'bil' => 1,
        ]);
    }


    public function actionBodList()
    {

        $icno = Yii::$app->user->getId();
        $model = CutiTblBod::find()->where(['pelulus_id' => $icno, 'status' => '1'])->all();
        if ($post = Yii::$app->request->post()) {
            $rekod = CutiTblBod::findOne(['id' => $post['id']]);
            $bio = Tblprcobiodata::findOne(['ICNO' => $rekod->icno]);
            $rekod->lulus_date = date('Y-m-d');

            $rekod->status = '2';
            if ($rekod->save()) {
                $this->Perakulog($rekod->id, $rekod->status);

                $this->Notification($rekod->bsm_id, 'Cuti', 'Di Maklumkan bahawa ' . $bio->CONm . ' Telah Kembali Bertugas Pada ' . $rekod->date_bod . 'Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/admin/cb-list">disini</a> untuk membuat tindakan selanjutnya');
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Record Updated!']);
                return $this->redirect(['cuti/pegawai/bod-list']);
            }
        }



        return $this->render('bod-list', [
            'model' => $model,
        ]);
    }

    // public function actionPerakuUpdate($id)
    // {

    //     $model = TblRecords::findOne(['id' => $id]);
    //     $model->scenario = 'peraku';

    //     $icno = Yii::$app->user->getId();

    //     $biodata = Tblprcobiodata::findAll(['Status' => 1]);

    //     if ($model->load(Yii::$app->request->post())) {

    //         $model->peraku_dt = date('Y-m-d H:i:s');

    //         if ($model->save()) {
    //             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Semakan telah dikemaskini!']);
    //             return $this->redirect(['cuti/semakan-list']);
    //         }
    //     }

    //     return $this->renderAjax('peraku-update', [
    //         'model' => $model,
    //         'biodata' => $biodata,
    //     ]);
    // }

    // public function actionPelulusList()
    // {

    //     $icno = Yii::$app->user->getId();

    //     $searchModel = new TblRecordsSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'VERIFIED', null, $icno);

    //     return $this->render('pelulus-list', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    // public function actionPelulusUpdate($id)
    // {

    //     $model = TblRecords::findOne(['id' => $id]);
    //     $model->scenario = 'pelulus';

    //     $icno = Yii::$app->user->getId();

    //     $biodata = Tblprcobiodata::findAll(['Status' => 1]);

    //     if ($model->load(Yii::$app->request->post())) {

    //         $model->peraku_dt = date('Y-m-d H:i:s');

    //         if ($model->save()) {
    //             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Semakan telah dikemaskini!']);
    //             return $this->redirect(['cuti/semakan-list']);
    //         }
    //     }

    //     return $this->renderAjax('pelulus-update', [
    //         'model' => $model,
    //         'biodata' => $biodata,
    //     ]);
    // }
    public function actionReport($id = null, $year = null, $date = null)
    {
        if (!$date) {
            $s = date('Y') . '-01-01';
            $e = date('Y-m-d');
            $date = $s . ' - ' . $e;
        }
        $arr = explode(" ", $date);
        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $start = date('Y-m-d', strtotime(date($arr[0])));
        $end = date('Y-m-d', strtotime(date($arr[2])));
        // echo $start_date;die;
        $jenis_cuti = JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->andWhere(['jenis_cuti_id' => 58])->all();
        if ($id == null && $year == null) {
            $year = date("Y");
            $id = 58;
        }

        // $model = TblRecords::find()->where(['jenis_cuti_id' => $id])->andWhere(['YEAR(start_date)' => $year]);
        $model = TblRecords::find()->joinWith(['kakitangan'])->where(['cuti_tbl_records.jenis_cuti_id' => $id])->andWhere(['between', 'cuti_tbl_records.start_date', $start, $end])->andWhere(['hronline.tblprcobiodata.DeptId' => $biodata->DeptId]);
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
}
