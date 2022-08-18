<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\kehadiran\TblRekod;
use app\models\kehadiran\TblWp;
use app\models\kehadiran\RefWp;
use app\models\cuti\SetPegawai;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\TblprcobiodataSearch;
use DateTime;
use kartik\mpdf\Pdf;
use app\models\Notification;
use app\models\kehadiran\TblWarnaKad;
use app\models\KeluarPejabat;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\models\hronline\Department;
use app\models\cuti\AksesPengguna;
use yii\helpers\VarDumper;
use app\models\kehadiran\TblLocation;
use app\models\kehadiran\DataKehadiran;
use app\models\kehadiran\MonthData;
use app\models\kehadiran\TblStaff;
use app\models\cuti\Tindakan;
use app\models\kehadiran\Tblshift;
use yii\base\Model;
use yii\widgets\ActiveForm;
use app\models\kehadiran\TblReports;
use app\models\kehadiran\TblLocums;
use app\models\hronline\Tblrscoadminpost;
use app\models\hronline\Adminposition;
use app\models\hronline\Tblvaksinasi;
use app\models\hronline\TempPpv;
use app\models\kehadiran\TblPpv;
use app\models\kehadiran\TblSelfhealth;
use app\models\kehadiran\TblWfh;
use tebazil\runner\ConsoleCommandRunner;
use app\models\w_letter\TblPermohonan;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class KehadiranController extends Controller
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
                'actions' => [
                    'logout' => ['post'],
                    'remove-staff' => ['post'],
                ],
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

    /**
     *
     * laman utama utk clock in/out
     */
    public function actionIndex()
    {
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        // Work from Home
        $statuswfh = TblWfh::getStatusWfh($icno, $today);

        if (!Yii::$app->MP->isAllowedClockin($icno)['status']) {
            if (Yii::$app->MP->isAllowedClockin($icno)['category'] == 1) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Anda diminta untuk melengkapkan maklumat vaksinasi sebelum clock-in. ']);
                return $this->redirect(['vaksinasi/view-st-vaksinasi']);
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Anda diminta untuk mengambil sample covid-19 di pusat rawatan warga UMS atau melengkapkan maklumat vaksinasi and sebelum clock-in. ']);
            return $this->redirect(['vaksinasi/view-st-vaksinasi']);
        }

        $vaksin = Tblvaksinasi::isRegistered($icno);

        if (!$vaksin) {
            return $this->redirect(['vaksinasi/update', 'from' => 1]);
        }

        //dailyselfhealth
        // if (!$statuswfh) {
        //     $checkHealth = TblSelfhealth::checktoday();
        //     if (!$checkHealth) {
        //         return $this->redirect(['selfhealth/index']);
        //     }
        // }

        $wfh = $statuswfh ? '<span class="label label-warning" style="font-size:14px">Work From Home</span>' : '<span class="label label-warning" style="font-size:14px">Work At Office</span>';

        $month = date('m');
        $year = date('Y');
        $hour_complete = 0;
        $curr_total_hours = '';
        $time_now = date('H:i:s');
        $link = 'kehadiran/clock-in';
        $current_ip = $this->getRealUserIp();
        $ip_type = TblRekod::checkIp($current_ip);

        $model = new TblRekod();
        $model->scenario = 'location';

        $wp_id = TblWp::curr_wp($icno);

        $model_wp = $wp_id ? RefWp::findOne(['id' => $wp_id]) : null;

        $model_rekod = $model_wp ? TblRekod::current($icno, $today, $wp_id, $model_wp->next_day) : TblRekod::current($icno, $today, $wp_id, 0);

        $time_in = $model_rekod ? $model_rekod->getFormatTimeIn() : '-';
        $time_out = isset($model_rekod->time_out) ? $model_rekod->getFormatTimeOut() : '-';
        $total_hours = isset($model_rekod->time_out) ? $model_rekod->total_hours : '-';
        $statusAll = $model_rekod ? $model->getStatusAll() : '-';

        if ($model_rekod) {

            $model = $model_rekod;
            $statusAll = $model->getStatusAll();
            $link = 'kehadiran/clock-out';
            $wp_start_time = ($model_wp->is_flexi == 1) ? $model_wp->in_start_time : $model_wp->start_time;
            $curr_total_hours = RefWp::totalHours($model_rekod->timeOnlyIn, $time_now, $wp_start_time);

            if ($time_now < $wp_start_time) {
                $curr_total_hours = 0;
            }

            $hour_complete = round(($curr_total_hours / $model_wp->total_hours) * 100, 2);

            if ($hour_complete > 100) {
                $hour_complete = 100;
            }
        }

        //ni utk warna kad sblm 4hb <-- tukar ke 10hb
        $month_warna = TblWarnakad::warnaMonth($today, $year, $month);

        // echo $month_warna;
        // exit();

        return $this->render('index', [
            'hour_complete' => $hour_complete,
            'curr_total_hours' => $curr_total_hours,
            'model' => $model,
            'model_wp' => $model_wp,
            'wp_id' => $wp_id,
            'time_in' => $time_in,
            'time_out' => $time_out,
            'total_hours' => $total_hours,
            'current_ip' => $current_ip,
            'ip_type' => $ip_type,
            'statusAll' => $statusAll,
            'color' => TblWarnaKad::WarnaKadSemasa($icno, $month_warna, NULL, $year),
            'pendingNoti' => TblRekod::totalPendingAll($icno),
            'url_zone' => Yii::$app->urlManager->createUrl("kehadiran/zone"),
            'url_tidakpatuh' => Yii::$app->urlManager->createUrl("kehadiran/graf-tidakpatuh"),
            'url_approve' => Yii::$app->urlManager->createUrl("kehadiran/graf-approve"),
            'link' => $link,
            'month_warna' => $month_warna,
            'wfh' => $wfh,
            //            'arrayshield' => SelfRisk::viewstatus($icno)
        ]);
    }

    public function actionClockIn()
    {

        $icno = Yii::$app->user->getId();
        $current_ip = $this->getRealUserIp();
        $wp_id = TblWp::curr_wp($icno);
        // $model_wp = RefWp::findOne(['id' => $wp_id]);

        $model = new TblRekod();
        //utk kes time in, time out, ot in, ot out yang 'required' latlng(location)
        $model->scenario = 'location';
        if ($model->load(Yii::$app->request->post())) {

            $today = date('Y-m-d');

            if (TblRekod::checkToday($icno, $today)) {
                return $this->redirect(['kehadiran/index']);
            }

            $time = date('H:i:s');

            $checkStatusIn = RefWp::checkStatusIn($icno, $today, $time, $wp_id);

            $checkExternal = $this->checkExternal($current_ip, Yii::$app->request->post()['TblRekod']['latlng']);


            $model->icno = $icno;
            $model->tarikh = $today;
            $model->time_in = date('Y-m-d H:i:s');
            $model->day = date('l'); // output: current day.
            $model->late_in = $checkStatusIn;
            $model->in_lat_lng = Yii::$app->request->post()['TblRekod']['latlng'];
            $model->in_ip = $current_ip;
            $model->external = $checkExternal;
            $model->wp_id = $wp_id;

            if ($model->save()) {

                //if late in
                if ($checkStatusIn) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Warning, Late', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['kehadiran/remark', 'id' => $model->id]);
                }

                //if external
                if ($checkExternal == 1) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Warning, you are out of zone', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['kehadiran/remark', 'id' => $model->id]);
                }

                Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Your time is recorded and please activate your Linphone App']);
                return $this->redirect(['kehadiran/index']);
            }
        }
    }

    public function actionClockOut()
    {

        $icno = Yii::$app->user->getId();
        $current_ip = $this->getRealUserIp();
        $wp_id = TblWp::curr_wp($icno);
        $model_wp = RefWp::findOne(['id' => $wp_id]);
        $today = date('Y-m-d');
        $time = date('H:i:s');

        $model = TblRekod::current($icno, $today, $wp_id, $model_wp->next_day);

        //utk kes time in, time out, ot in, ot out yang 'required' latlng(location)
        $model->scenario = 'location';
        if ($model->load(Yii::$app->request->post())) {

            $checkStatusOut = RefWp::checkStatusOut($icno, $today, date('H:i:s'), $wp_id);
            $checkExternal = $this->checkExternal($current_ip, Yii::$app->request->post()['TblRekod']['latlng']);

            $model->time_out = date('Y-m-d H:i:s');
            $model->total_hours = RefWp::totalHours($model->time_in, $model->time_out, $model_wp->in_start_time);
            $model->external === 1 ? 1 : $checkExternal;
            $model->early_out = $checkStatusOut;

            $model->out_lat_lng = $model->latlng;
            $model->out_ip = $current_ip;

            if ($model->save()) {

                //if early out
                if ($checkStatusOut) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Attention, Early out', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['kehadiran/remark', 'id' => $model->id]);
                }

                //if external
                if ($checkExternal == 1) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Warning, you are out of zone', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['kehadiran/remark', 'id' => $model->id]);
                }

                Yii::$app->session->setFlash('alert', ['title' => 'Clock Out', 'type' => 'success', 'msg' => 'Your time is recorded successfully']);
                return $this->redirect(['kehadiran/index']);
            }
        }
    }

    public static function checkExternal($ip, $latlng)
    {

        $val = 0;

        $icno = Yii::$app->user->getId();
        $tarikh = date('Y-m-d');
        $cuti = TblRekod::DisplayCutiRaw($icno, $tarikh);

        if ($cuti != '-') {
            return 0;
        }

        $checkip = TblRekod::checkIp($ip);
        $checkZone = TblLocation::CheckZone($latlng);

        if ($checkip === 1) {
            if ($checkZone === false) {
                $val = 1;
            }
        }

        return $val;
    }

    function getRealUserIp()
    {
        switch (true) {
            case (!empty($_SERVER['HTTP_X_REAL_IP'])):
                return $_SERVER['HTTP_X_REAL_IP'];
            case (!empty($_SERVER['HTTP_CLIENT_IP'])):
                return $_SERVER['HTTP_CLIENT_IP'];
            case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            default:
                return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * function ni akan return ketidakpatuhan
     *
     * $type 1 = in , 2 = out
     *
     * return LATE_IN, EARLY_OUT, EXTERNAL
     */
    public function checkKetidakpatuhan($time, $wp_id, $type)
    {

        $status = NULL;
        $model_wp = RefWp::findOne(['id' => $wp_id]);

        //mula2 check dlu sabtu atau ahad.. return null sbb sabtu ahad kira ot sja
        if (date('l') == 'Saturday' || date('l') == 'Sunday') {
            $status = NULL;
            //klu working day trus check late in dan early out
        } else {
            if ($type == 1) {
                $status = ($time > $model_wp->start_time) ? 'LATE_IN' : NULL;
            } elseif ($type == 2) {
                $status = ($time < $model_wp->end_time) ? 'EARLY_OUT' : null;
            }
        }

        return $status;
    }

    public function checkKetidakpatuhanNew($time, $wp_id, $type)
    {

        $status = NULL;
        $model_wp = RefWp::findOne(['id' => $wp_id]);
        $icno = Yii::$app->user->getId();
        $tarikh = date('Y-m-d');

        $cuti = TblRekod::DisplayCuti($icno, $tarikh);

        //mula2 check dlu sabtu atau ahad.. return null sbb sabtu ahad kira ot sja
        if ($cuti) {
            $status = NULL;
            //klu working day trus check late in dan early out
        } else {
            if ($type == 1) {
                $status = ($time > $model_wp->start_time) ? 'LATE_IN' : NULL;
            } elseif ($type == 2) {
                $status = ($time < $model_wp->end_time) ? 'EARLY_OUT' : null;
            }
        }

        return $status;
    }

    public function actionSet_pegawai($id)
    {

        $model = SetPegawai::findOne(['pemohon_icno' => $id]);

        return $this->render('set_pegawai', ['model' => $model]);
    }

    public function actionS_tindakan_wbb()
    {

        $icno = Yii::$app->user->getId();

        $tindakan = Tindakan::find()->where(['icno_tindakan' => $icno])->one();

        if ($tindakan) {
            $icno = $tindakan->icno_pemberi_kuasa;
        }

        $ver = TblWp::findAll(['ver_by' => $icno, 'status' => 'ENTRY']);
        $app = TblWp::findAll(['app_by' => $icno, 'status' => 'VERIFIED']);


        return $this->render('s_tindakan_wbb', ['bil' => 1, 'ver' => $ver, 'app' => $app]);
    }

    public function actionStaffWbb()
    {
        $icno = Yii::$app->user->getId();

        $arr_dept = array();
        $arr_campus = array();
        $model = AksesPengguna::find()->where(['akses_cuti_icno' => $icno])->all();

        foreach ($model as $r) {
            $arr_dept[] = $r->akses_jspiu_id;
        }
        foreach ($model as $r) {
            $arr_campus[] = $r->akses_kampus_id;
        }

        $biodata = tblprcobiodata::find()->where(['DeptId' => $arr_dept, 'campus_id' => $arr_campus, 'status' => 1])->all();

        // VarDumper::dump( $biodata, $depth = 10, $highlight = true);

        return $this->render('staffWbb', [
            'biodata' => $biodata,
            'bil' => 1,
        ]);
    }

    public function actionSetPeg($id)
    {

        if (!$id) {
            Yii::$app->session->setFlash('alert', ['title' => 'Amaran', 'type' => 'warning', 'msg' => 'Anda tidak dibenarkan melakukan perkara ini.']);
            return $this->redirect(['kehadiran/index']);
        }

        $model = SetPegawai::findOne(['pemohon_icno' => $id]);

        if (!$model) {
            $model = new SetPegawai();
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->pemohon_icno = $id;
            $model->jenis_cuti_id = 1;
            $model->set_status = 1;

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat telah dikemaskini']);
                return $this->redirect(['kehadiran/staff-wbb']);
            }
        }

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

        return $this->render('setPeg', [
            'model' => $model,
            'biodata' => $biodata,
        ]);
    }

    public function actionWbb()
    {

        $icno = Yii::$app->user->getId();

        $model = TblWp::findAll(['icno' => $icno]);

        $peg = SetPegawai::findOne(['pemohon_icno' => $icno]);
        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');

        $next_month = date('m', strtotime($today . ' +1 month'));


        $wp = new TblWp();


        if ($wp->load(Yii::$app->request->post())) {

            $wp->icno = $icno;
            $ntf = new Notification();

            //klu ada peg peraku...     
            if ($peg->peraku_icno) {
                $wp->ver_by = $peg->peraku_icno;
                $ntf->icno = $peg->peraku_icno;
            } else {
                $ntf->icno = $peg->pelulus_icno;
            }

            $wp->app_by = $peg->pelulus_icno;
            $wp->start_date = "$year-$next_month-01";
            $wp->entry_dt = date('Y-m-d H:i:s');

            //klu teda pegawai peraku terus kasi verified.. htr ke pelulus trus
            if (!$peg->peraku_icno) {
                $wp->status = 'VERIFIED';
            }


            if (date($wp->entry_dt) > "2019-$month-21") {
                Yii::$app->session->setFlash('alert', ['title' => 'Amaran', 'type' => 'warning', 'msg' => 'Permohonan hanya boleh dibuat sebelum atau pada 20hb pada setiap bulan.']);
                return $this->redirect(['kehadiran/wbb']);
            }


            if ($wp->save()) {

                $ntf->title = 'Kehadiran';
                $ntf->content = "Permohonan Waktu Bekerja Berperingkat menunggu tindakan anda.";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Dihantar Kepada Pegawai Peraku/Lulus']);
                return $this->redirect(['kehadiran/wbb']);
            }
        }

        return $this->render('wbb', [
            'model' => $model,
            'bil' => 1,
            'wp' => $wp,
            'peg' => $peg,
        ]);
    }

    public function actionRemark($id)
    {

        $icno = Yii::$app->user->getId();

        $peg = SetPegawai::findOne(['pemohon_icno' => $icno]);


        if (!$peg) {
            Yii::$app->session->setFlash('alert', ['title' => 'Makluman', 'type' => 'warning', 'msg' => 'Tiada Pegawai Peraku bagi kehadiran anda. Sila berhubung dengan penyelia Kehadiran/Cuti bagi menetapkan pegawai peraku/lulus.']);
            return $this->redirect(['kehadiran/tindakan_ketidakpatuhan']);
        }


        //$model = TblRekod::findOne(['id' => $id, 'remark_status' => NULL, 'icno' => $icno]);
        //        $model = TblRekod::findOne(['id' => $id, 'icno' => $icno]);
        $model = TblRekod::find()->where("id=:id AND icno=:icno AND remark_status IS NULL", ['icno' => $icno, 'id' => $id])->one();
        if ($model != null) {
            $model->scenario = 'remark';
        }


        //ni kalau ada yg mau pok silap gatal itu tangan mo test2 kasi masuk $id
        if (!$model) {
            Yii::$app->session->setFlash('alert', ['title' => 'Amaran', 'type' => 'warning', 'msg' => 'Remark hanya dibenarkan sekali sahaja sehari!']);

            return $this->redirect(['kehadiran/tindakan_ketidakpatuhan']);
        }
        //Belum ada kena set pegawai melulus
        if (!$model) {
            Yii::$app->session->setFlash('alert', ['title' => 'Amaran', 'type' => 'warning', 'msg' => 'Maaf Anda belum mempunyai pegawai melulus, Sila hubungi Penyelia Kehadiran anda!']);

            return $this->redirect(['kehadiran/tindakan_ketidakpatuhan']);
        }
        //submiting
        if ($model->load(Yii::$app->request->post())) {

            $model->app_by = ($peg->peraku_icno != null) ? $peg->peraku_icno : $peg->pelulus_icno;

            $model->remark_status = 'ENTRY';
            $model->remark_dt = date('Y-m-d H:i:s');


            if ($model->save()) {

                $btn = Html::a('disini', ['/kehadiran/pengesahan', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);

                //----------Model Notification ---------//
                $ntf = new Notification();
                $ntf->icno = $model->app_by;
                $ntf->title = 'Kehadiran';
                $ntf->content = "Pengesahan ketidakpatuhan menunggu tindakan anda. Sila buat pengesahan $btn";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                //--------Model Notification-----------//

                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$icno]);


                Yii::$app->session->setFlash('alert', ['title' => 'Submitted', 'type' => 'success', 'msg' => 'The Incompliace Status Remark was successfully submitted']);
                return $this->redirect(['kehadiran/tindakan_ketidakpatuhan']);
            }
        }

        return $this->render('remark', ['model' => $model, 'peg' => $peg]);
    }

    public function actionSenarai_tindakan()
    {

        $icno = Yii::$app->user->getId();

        $tindakan = Tindakan::find()->where(['icno_tindakan' => $icno])->one();

        if ($tindakan) {
            $icno = $tindakan->icno_pemberi_kuasa;
        }

        $lulus = TblRekod::findAll(['app_by' => $icno, 'remark_status' => 'ENTRY']);


        if ($pilih = Yii::$app->request->post()) {

            foreach ($pilih['TblRekod']['id'] as $k => $v) {
                if ($v != 0) {
                    $model = TblRekod::findOne($v);
                    $model->remark_status = 'APPROVED';
                    $model->app_dt = date('Y-m-d H:i:s');

                    if ($model->save()) {

                        //----------Model Notification ---------//
                        $ntf = new Notification();
                        $ntf->icno = $model->icno;
                        $ntf->title = 'Kehadiran';
                        $ntf->content = "Status pengesahan Ketidakpatuhan pada $model->formatTarikh ($model->day) telah disahkan";
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                    }
                }
            }
            //--------Model Notification-----------//
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan Ketidakpatuhan telah dihantar!']);
            return $this->redirect(['kehadiran/senarai_tindakan']);
        }


        return $this->render('senarai_tindakan', [
            'lulus' => $lulus,
            'bil' => 1,
        ]);
    }

    public function actionSenarai_kakitangan()
    {

        $searchModel = new TblprcobiodataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('senarai_kakitangan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTindakan_wbb_peraku($id)
    {

        $model = TblWp::findOne($id);


        if ($model->load(Yii::$app->request->post())) {

            $model->ver_dt = date('Y-m-d H:i:s');


            if ($model->status == 'VERIFIED') {

                if ($model->save()) {

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->app_by;
                    $ntf->title = 'Kehadiran';
                    $ntf->content = "Permohonan Waktu Bekerja Berperingkat menunggu tindakan anda.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);
                    return $this->redirect(['kehadiran/s_tindakan_wbb']);
                }
            } else if ($model->status == 'REJECTED') {

                if ($model->save()) {

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->icno;
                    $ntf->title = 'Kehadiran';
                    $ntf->content = "Permohonan Waktu Bekerja Berperingkat Anda telah DITOLAK.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
                    return $this->redirect(['kehadiran/s_tindakan_wbb']);
                }
            }
        }

        return $this->render('tindakan_wbb_peraku', [
            'model' => $model
        ]);
    }

    public function actionTindakan_wbb_lulus($id)
    {

        $model = TblWp::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->app_dt = date('Y-m-d H:i:s');

            if ($model->status == 'APPROVED') {

                $wp = $model->wp->jenis_wp;
                $start_date = $model->getTarikhMula();

                $date_before = date('Y-m-d', strtotime($model->start_date . ' -1 day'));

                //------------- kasi end date dlu wp sebelum ------------------//
                //                $before = TblWp::find(['icno' => $model->icno, 'status' => 'APPROVED'])->orderBy(['id'=> SORT_DESC])->one();
                $sql = 'SELECT * FROM attendance.tbl_wp WHERE icno=:icno AND status=:status AND (DATE(NOW()) BETWEEN start_date AND end_date OR end_date IS NULL)';
                $before = TblWp::findBySql($sql, [':icno' => $model->icno, ':status' => 'APPROVED'])->one();


                if ($before) {
                    $before->end_date = $date_before;
                    $before->update();
                }

                //------------- kasi end date dlu wp sebelum ------------------//
                //----------Model Notification ---------//
                $ntf = new Notification();
                $ntf->icno = $model->icno;
                $ntf->title = 'Kehadiran';
                $ntf->content = "Permohonan Waktu Bekerja anda telah diluluskan, Waktu Bekerja anda akan bertukar kepada $wp pada $start_date.";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                //--------Model Notification-----------//

                if ($model->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Anda telah meluluskan permohonan ini!']);
                    return $this->redirect(['kehadiran/s_tindakan_wbb']);
                }
            } else if ($model->status == 'REJECTED') {
                //----------Model Notification ---------//
                $ntf = new Notification();
                $ntf->icno = $model->icno;
                $ntf->title = 'Kehadiran';
                $ntf->content = "Permohonan Waktu Bekerja Berperingkat Anda telah DITOLAK.";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                //--------Model Notification-----------//
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
                return $this->redirect(['kehadiran/s_tindakan_wbb']);
            }
        }

        return $this->render('tindakan_wbb_lulus', [
            'model' => $model
        ]);
    }

    public function actionStaffColorCard()
    {

        $icno = Yii::$app->user->getId();

        $model = SetPegawai::find()
            ->andFilterWhere(['or', ['=', 'peraku_icno', $icno], ['=', 'pelulus_icno', $icno]])
            ->all();

        $year = date('Y');
        $month = date('m');


        return $this->render('staff-color-card', ['model' => $model, 'bil' => 1, 'year' => $year, 'month' => $month]);
    }

    public function actionPantau_staff($date = null)
    {

        $today = date('Y-m-d');


        if ($date) {
            $today = $date;
        }

        $icno = Yii::$app->user->getId();

        $kj = Department::findOne(['chief' => $icno]);

        $model = Tblprcobiodata::find()->joinWith('department')->where(['chief' => $icno, 'status' => 1])->all();

        return $this->render('pantau_staff', ['model' => $model, 'bil' => 1, 'today' => $today]);
    }

    public function actionPantauKehadiran($date = null)
    {

        $today = date('Y-m-d');


        if ($date) {
            $today = $date;
        }

        $icno = Yii::$app->user->getId();

        $model = SetPegawai::find()
            ->andFilterWhere(['or', ['=', 'peraku_icno', $icno], ['=', 'pelulus_icno', $icno]])
            ->all();

        return $this->render('pantau-kehadiran', ['model' => $model, 'bil' => 1, 'today' => $today]);
    }

    public function actionKjPantauKehadiran($date = null)
    {

        $today = date('Y-m-d');

        if ($date) {
            $today = $date;
        }


        $icno = Yii::$app->user->getId();

        $chief = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $list_staff = Tblprcobiodata::find()->where(['Status' => 1, 'DeptId' => $chief->DeptId])->all();

        return $this->render('kj-pantau-kehadiran', ['list_staff' => $list_staff, 'bil' => 1, 'today' => $today]);
    }

    public function actionMonthlySummary($bulan = null)
    {

        $icno = Yii::$app->user->getId();
        $today = date('m');

        if ($bulan) {
            $today = $bulan;
        }

        if (!isset($tahun)) {
            $tahun = date('Y');
        }

        // $sql = 'SELECT * FROM e_cuti.set_pegawai WHERE peraku_icno=:icno OR pelulus_icno=:icno';
        // $model = SetPegawai::findBySql($sql, [':icno' => $icno])->all();

        $model = SetPegawai::find()
            ->andFilterWhere(['or', ['=', 'peraku_icno', $icno], ['=', 'pelulus_icno', $icno]])
            ->all();

        return $this->render('monthly-summary', ['model' => $model, 'bil' => 1, 'today' => $today, 'tahun' => $tahun]);
    }

    public function actionTindakan_ketidakpatuhan()
    {

        $icno = Yii::$app->user->getId();

        $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno=:icno AND (late_in = 1 OR early_out = 1 OR incomplete = 1 OR absent = 1 OR external = 1) AND remark_status IS NULL ';
        $model = TblRekod::findBySql($sql, [':icno' => $icno])->all();

        return $this->render('tindakan_ketidakpatuhan', ['model' => $model, 'bil' => 1]);
    }

    public function actionTest()
    {

        $biodata = Tblprcobiodata::findAll(['Status' => 1]);

        //        echo count($biodata) . '<br>';

        foreach ($biodata as $bio) {
            echo $bio->ICNO . '<br>';
        }
    }

    public function actionLaporan_kehadiran($id = null, $tahun = null, $bulan = null)
    {

        $year = date('Y');
        $mth = date('m');

        if (!$id) {
            $id = Yii::$app->user->getId();
        }

        $var = null;
        if ($tahun != null) {
            $year = $tahun;
        }

        if ($bulan != null) {
            $mth = $bulan;
        }
        if ($tahun && $bulan) {
            $var = $this->getDaysInYearMonth($year, $mth, 'Y-m-d');
        }

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $warna_kad = TblWarnaKad::WarnaKadSemasa($id, $mth, NULL, $year);

        return $this->render('laporan_kehadiran', ['var' => $var, 'icno' => $id, 'tahun' => $year, 'bulan' => $mth, 'biodata' => $biodata, 'warna_kad' => $warna_kad]);
    }

    public function actionLaporanKehadiran($id = null, $tahun = null, $bulan = null)
    {

        $year = date('Y');
        $mth = date('m');

        if (!$id) {
            $id = Yii::$app->user->getId();
        }


        if ($tahun != null) {
            $year = $tahun;
        }

        if ($bulan != null) {
            $mth = $bulan;
        }

        $sql = 'SELECT * FROM tbl_reports WHERE icno=:icno AND MONTH(tarikh)=:mth';
        $reports = TblReports::findBySql($sql, [':icno' => $id, ':mth' => $mth])->asArray()->all();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $warna_kad = TblWarnaKad::WarnaKadSemasa($id, $mth, NULL, $year);

        return $this->render('laporan-kehadiran', ['reports' => $reports, 'icno' => $id, 'tahun' => $year, 'bulan' => $mth, 'biodata' => $biodata, 'warna_kad' => $warna_kad, 'url' => Yii::$app->urlManager->createUrl("kehadiran/load-laporan"),]);
    }

    // public function actionLoadLaporan()
    // {

    //     if (Yii::$app->request->post()) {

    //         $year = date('Y');
    //         $mth = date('m');

    //         $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

    //         $var = $this->getDaysInYearMonth($year, $mth, 'Y-m-d');

    //         $warna_kad = TblWarnaKad::WarnaKadSemasa($id, $mth, NULL, $year);

    //         return $this->renderAjax('loadLaporan', ['var' => $var, 'icno' => $id, 'tahun' => $year, 'bulan' => $mth, 'biodata' => $biodata, 'warna_kad' => $warna_kad]);
    //     }
    // }

    //**simpan dlu ni function
    function getDaysInYearMonth(int $year, int $month, string $format)
    {
        $date = DateTime::createFromFormat("Y-n", "$year-$month");

        $datesArray = array();
        for ($i = 1; $i <= $date->format("t"); $i++) {
            $datesArray[] = DateTime::createFromFormat("Y-n-d", "$year-$month-$i")->format($format);
        }

        return $datesArray;
    }

    public function actionKad_warna()
    {

        return $this->renderAjax('kad_warna');
    }

    public function actionDetailrekod($icno, $tarikh)
    {

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        return $this->renderAjax('detailrekod', ['model' => $model]);
    }

    public function actionMap()
    {

        return $this->renderAjax('map');
    }

    /**
     * Untuk Semakan WBB kakitangan seliaan
     *
     * @param type $id = icno
     */
    public function actionSenarai_wbb($id)
    {

        $model = TblWp::findAll(['icno' => $id]);
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

        return $this->render('senarai_wbb', ['model' => $model, 'bil' => 1, 'id' => $id, 'biodata' => $biodata]);
    }

    public function actionWbbList($id, $wp_id = null)
    {

        $icno = Yii::$app->user->getId();

        $model_wp = TblWp::findAll(['icno' => $id]);
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

        $model = new TblWp();

        if ($wp_id) {
            $model = TblWp::findOne($wp_id);
            $model->start_date = date('d/m/Y', strtotime(str_replace("-", "/", $model->start_date)));
            $model->end_date = $model->end_date ? date('d/m/Y', strtotime(str_replace("-", "/", $model->end_date))) : NULL;
        }

        if ($model->load(Yii::$app->request->post())) {
            //-----------------------------------------TAMBAH WBB--------------//
            $model->icno = $id;
            $model->entry_dt = date('Y-m-d H:i:s');
            $model->remark = 'Ditambah Oleh Penyelia J/F/P/I/U';
            $model->status = 'APPROVED';
            $model->ver_by = $icno;
            $model->ver_dt = date('Y-m-d H:i:s');
            $model->ver_remark = 'Ditambah Oleh Penyelia J/F/P/I/U';
            $model->app_by = $icno;
            $model->app_dt = date('Y-m-d H:i:s');
            $model->app_remark = 'Ditambah Oleh Penyelia J/F/P/I/U';
            //-----------------------------------------TAMBAH WBB--------------//

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'WBB telah berjaya ditambah.']);
                return $this->redirect(['kehadiran/wbb-list', 'id' => $id]);
            }
        }

        return $this->render('wbbList', ['model_wp' => $model_wp, 'model' => $model, 'bil' => 1, 'id' => $id, 'biodata' => $biodata]);
    }

    public function actionDelWbb($id)
    {

        $model = TblWp::findOne($id);

        if ($model) {
            $icno = $model->icno;
            if ($model->delete()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'WBB telah berjaya dibuang.']);
                return $this->redirect(['kehadiran/wbb-list', 'id' => $icno]);
            }
        }
    }

    /**
     * Untuk Semakan WBB kakitangan selian
     *
     * @param type $id = icno
     */
    public function actionAdd_wbb($id)
    {

        $icno = Yii::$app->user->getId();

        $model = new TblWp();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

        if ($model->load(Yii::$app->request->post())) {

            //cari dlu wbb yang lama.. utk update tarikh tamat, tarikh tamat tolak 1 hari dari hari ini.
            $old_wbb = TblWp::findOne(['icno' => $id, 'end_date' => null, 'status' => 'APPROVED']);

            //sekiranya ada.. update;
            if ($old_wbb) {

                $today = date('Y-m-d');
                $date_before = date('Y-m-d', strtotime($today . ' -1 day'));
                $old_wbb->end_date = $date_before;
                $old_wbb->update();
            }

            //-----------------------------------------TAMBAH WBB--------------//
            $model->icno = $id;
            $model->start_date = date('Y-m-d');
            $model->entry_dt = date('Y-m-d H:i:s');
            $model->remark = 'Ditambah Oleh Penyelia J/F/P/I/U';
            $model->status = 'APPROVED';
            $model->ver_by = $icno;
            $model->ver_dt = date('Y-m-d H:i:s');
            $model->ver_remark = 'Ditambah Oleh Penyelia J/F/P/I/U';
            $model->app_by = $icno;
            $model->app_dt = date('Y-m-d H:i:s');
            $model->app_remark = 'Ditambah Oleh Penyelia J/F/P/I/U';
            //-----------------------------------------TAMBAH WBB--------------//

            if ($model->save()) {

                $wp = $model->wp->jenis_wp . ' ' . $model->wp->detail;
                $date_now = date('d/m/Y');
                //----------Model Notification ---------//
                $ntf = new Notification();
                $ntf->icno = $id;
                $ntf->title = 'Kehadiran';
                $ntf->content = "Waktu Berkerja Berperingkat anda telah ditukar kepada $wp, berkuatkuasa bermula $date_now. Sekian Terima Kasih.";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                //--------Model Notification-----------//

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Perubahan WBB telah berjaya ditambah.']);
                return $this->redirect(['kehadiran/senarai_wbb', 'id' => $id]);
            }
        }

        return $this->render('add_wbb', ['model' => $model, 'bil' => 1, 'id' => $id, 'biodata' => $biodata]);
    }

    public function actionPengesahan($id)
    {

        $icno = Yii::$app->user->getId();

        $model = TblRekod::findOne(['id' => $id, 'remark_status' => 'ENTRY', 'app_by' => $icno]);


        if ($model) {
            $model->scenario = 'reason';
            //submiting
            if ($model->load(Yii::$app->request->post())) {

                $model->app_dt = date('Y-m-d H:i:s');

                if ($model->save()) {

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->icno;
                    $ntf->title = 'Kehadiran';
                    $ntf->content = "Status pengesahan Ketidakpatuhan pada $model->formatTarikh ($model->day) telah disahkan";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();

                    $runner = new ConsoleCommandRunner();
                    $runner->run('dashboard/pending-task-individu', [$icno]);
                    //--------Model Notification-----------//
                    //Yii::$app->session->setFlash('info', 'Sebab Kesalahan Telah Dihantar');
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan Ketidakpatuhan telah dihantar!']);
                    return $this->redirect(['kehadiran/senarai_tindakan']);
                }
            }
        } else {
            // Yii::$app->session->setFlash('alert', ['title' => 'Amaran', 'type' => 'warning', 'msg' => 'Pengesahan telah dibuat!']);
            return $this->redirect(['kehadiran/index']);
        }

        return $this->render('pengesahan', ['model' => $model]);
    }

    public function actionSenarai_keluar_pejabat($icno = null)
    {

        $tahun = date('Y');

        $sql = 'SELECT * FROM vEAttendance WHERE YEAR(OutStationDateTimeStart) =:tahun';
        $model = KeluarPejabat::findBySql($sql, [':tahun' => $tahun])->all();

        return $this->render('senarai_keluar_pejabat', ['model' => $model, 'bil' => 1]);
    }

    public function actionReport($id, $tahun, $bulan)
    {

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);


        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');

        $month = TblRekod::viewBulan($bulan);

        $this->view->title = "Attendance Report ($month)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_reportView', ['biodata' => $biodata, 'tahun' => $tahun, 'bulan' => $bulan, 'var' => $var, 'icno' => $id]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Attendance Report $biodata->CONm $month.pdf",
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
            'options' => ['title' => "Attendance Report($month)"],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["Attendance Report ($month)"],
                //                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                //                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionCheck_attendance()
    {

        $biodata = Tblprcobiodata::findAll(['DeptId' => [1, 174, 159, 4, 158, 137, 139, 8], 'Status' => 1]);

        $tarikh = '2019-02-08';


        return $this->render('checkAttendance', ['biodata' => $biodata, 'bil' => 1, 'tarikh' => $tarikh]);
    }

    public function actionStaff_history($icno)
    {

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $month = date('m');
        $model = TblRekod::find()->where("(icno = :icno AND (late_in = 1 OR early_out = 1 OR incomplete = 1 OR absent = 1 OR external = 1) AND MONTH(tarikh) =:month)", [":icno" => $icno, ':month' => $month]);


        $provider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    //                    'icno' => SORT_DESC,
                    'tarikh' => SORT_ASC,
                ]
            ],
        ]);

        return $this->renderAjax('staff_history', ['model' => $provider, 'biodata' => $biodata]);
    }

    public function actionKesalahan()
    {

        $biodata = Tblprcobiodata::findAll(['DeptId' => 137]);

        //        $biodata = Yii::$app->db2->createCommand("SELECT * FROM tblprcobiodata WHERE DeptId=137");
        //        var_dump($biodata);
        //        die();

        foreach ($biodata as $bio) {
            echo $bio->CONm . '-' . TblRekod::totalSalah($bio->ICNO, 02, date('Y')) . '<br>';
        }
    }

    public function actionSummaryByYear($icno, $year = null)
    {

        if ($year == null) {
            $year = date('Y');
        }

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        return $this->render('summaryByYear', ['icno' => $icno, 'year' => $year, 'biodata' => $biodata]);
    }

    public function actionStaffAll()
    {

        $searchModel = new TblprcobiodataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('staffAll', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrintStaffWbb()
    {

        $icno = Yii::$app->user->getId();

        $arr_dept = array();
        $arr_campus = array();
        $model = AksesPengguna::find()->where(['akses_cuti_icno' => $icno])->all();

        foreach ($model as $r) {
            $arr_dept[] = $r->akses_jspiu_id;
        }

        foreach ($model as $r) {
            $arr_campus[] = $r->akses_kampus_id;
        }

        $biodata = tblprcobiodata::find()->where(['DeptId' => $arr_dept, 'campus_id' => $arr_campus, 'status' => 1])->all();

        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_printstaffwbb', ['bil' => 1, 'biodata' => $biodata]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
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
            'options' => ['title' => 'Senarai WBB Staf Seliaan'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['Senarai WBB Staf Seliaan'],
                //                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionZone()
    {

        $latlng = Yii::$app->request->post()['latlng'];

        //        $ip = $_SERVER['REMOTE_ADDR'];
        $ip = $this->getRealUserIp();

        if (Yii::$app->request->post()) {
            //if ip = external
            if (TblRekod::checkIp($ip) === 1) {
                if (!$latlng) {
                    echo '<p style="color:red;">Unable to detect user location, Please reload web browser!</p><a class="btn-sm btn-default" onclick="window.location.href = window.location.href"><i class="fa fa-refresh"></i></a>';
                    //                    exit();
                }
                //check location pula
                if (TblLocation::CheckZone($latlng)) {
                    $v = '<span class="label label-success" style="font-size:14px">Internal</span><a class="btn-sm btn-default" onclick="window.location.href = window.location.href"><i class="fa fa-refresh"></i></a>';
                } else {
                    $v = '<span class="label label-danger" style="font-size:14px">External</span><a class="btn-sm btn-default" onclick="window.location.href = window.location.href"><i class="fa fa-refresh"></i></a>';
                }
            } else {
                $v = '<span class="label label-success" style="font-size:14px">Internal</span><a class="btn-sm btn-default" onclick="window.location.href = window.location.href"><i class="fa fa-refresh"></i></a>';
            }
        }

        echo $v;
    }

    public function actionSendEmail()
    {


        $searchModel = new TblprcobiodataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $biodata = Tblprcobiodata::find()->where(['Status' => 1, 'ICNO' => 830409125689])->asArray()->limit(100)->all();
        $set_to = ['hamizi@ums.edu.my' => 'azihar'];
        $set_from = ['hronline-noreply@ums.edu.my' => 'HRONLINE v4.0'];
        $subject = 'Senarai ketidakpatuhan staf menunggu tindakan anda';

        foreach ($biodata as $bio) {
            if (TblRekod::totalPendingKetidakpatuhan($bio['ICNO'], TRUE) != 0) {
                $total = TblRekod::totalPendingKetidakpatuhan($bio['ICNO'], TRUE);
                $model = TblRekod::totalPendingKetidakpatuhan($bio['ICNO'], FALSE, TRUE);

                Yii::$app->mailer->compose('pending_task_ketidakpatuhan', ['model' => $model, 'total' => $total, 'bil' => 1])
                    ->setFrom($set_from)
                    ->setTo($set_to)
                    ->setSubject($subject)
                    ->send();
            }
        }


        return $this->render('staffAll', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdminMthRpt()
    {

        $icno = Yii::$app->user->getId();
        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $tahun = date('Y');
        $bulan = date('m');
        $dept_id = [$biodata->DeptId];

        return $this->render('rpt', [
            'month' => $bulan,
            'dept_id' => $dept_id,
            'model' => new Department(),
        ]);
    }

    public function actionSupMthRpt($tahun = null, $bulan = null, $dept_id = null)
    {

        $icno = Yii::$app->user->getId();

        $today = date('m');
        $year = date('Y');

        $arr_dept = array();
        $arr_campus = array();
        $model = AksesPengguna::find()->where(['akses_cuti_icno' => $icno])->all();

        $isAdmin = AksesPengguna::findOne(['akses_cuti_icno' => $icno])->akses_cuti_int == 3 ? true : false;

        $model_dept = Department::find()->where(['isActive' => 1])->all();


        if ($dept_id) {
            $arr_dept[] = $dept_id;
        } else {
            foreach ($model as $r) {
                // $arr_dept[] = 12;
                $arr_dept[] = $r->akses_jspiu_id;
            }
        }

        foreach ($model as $r) {
            $arr_campus[] = $r->akses_kampus_id;
        }

        if (!$bulan) {
            $bulan = $today;
        }

        if (!$tahun) {
            $tahun = $year;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => MonthData::find()->where(['dept_id' => $arr_dept, 'bulan' => $bulan, 'tahun' => $tahun]),
            'pagination' => false
        ]);


        return $this->render('sup-mth-rpt', ['isAdmin' => $isAdmin, 'model' => $model, 'today' => $bulan, 'tahun' => $tahun, 'bil' => 1, 'dataProvider' => $dataProvider, 'dept_id' => $dept_id, 'model_dept' => $model_dept]);
    }

    public function actionSupYearRpt($tahun = null, $dept_id = null)
    {

        $icno = Yii::$app->user->getId();

        $year = date('Y');
        $arr_dept = [];
        $arr_campus = [];
        $model = AksesPengguna::find()->where(['akses_cuti_icno' => $icno])->all();

        $isAdmin = AksesPengguna::findOne(['akses_cuti_icno' => $icno])->akses_cuti_int == 3 ? true : false;

        $model_dept = Department::find()->where(['isActive' => 1])->all();


        if ($dept_id) {
            $arr_dept[] = $dept_id;
        } else {
            foreach ($model as $r) {
                $arr_dept[] = $r->akses_jspiu_id;
            }
        }

        foreach ($model as $r) {
            $arr_campus[] = $r->akses_kampus_id;
        }

        if (!$tahun) {
            $tahun = $year;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()->where(['DeptId' => $arr_dept, 'campus_id' => $arr_campus, 'status' => 1]),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);


        return $this->render('sup-year-rpt', [
            'isAdmin' => $isAdmin,
            'tahun' => $tahun,
            'bil' => 1,
            'dataProvider' => $dataProvider,
            'dept_id' => $dept_id,
            'model_dept' => $model_dept,
        ]);
    }

    public function actionLoadRptAdmin()
    {

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);


        $tahun = date('Y');
        $bulan = date('m');
        $dept_id = [$biodata->DeptId];
        $nama_bulan = TblRekod::viewBulan($bulan);


        if ($post = Yii::$app->request->post()) {
            $bulan = $post['bulan'];
            $dept_id = $post['dept_id'];
            $nama_bulan = TblRekod::viewBulan($bulan);
        }

        $title = "Jumlah ketidakpatuhan mengikut JFPIU ($nama_bulan) ";


        foreach ($dept_id as $dept) {
            $data[] = [
                'name' => Department::findOne(['id' => $dept])->shortname,
                'data' => [
                    DataKehadiran::totalLatein($dept, $tahun, $bulan),
                    DataKehadiran::totalEarlyout($dept, $tahun, $bulan),
                    DataKehadiran::totalIncomplete($dept, $tahun, $bulan),
                    DataKehadiran::totalAbsent($dept, $tahun, $bulan),
                    DataKehadiran::totalExternal($dept, $tahun, $bulan),
                ]
            ];
        }

        return $this->renderAjax('load-rpt-admin', [
            'data' => $data,
            'title' => $title,
            'month' => $bulan,
        ]);
    }

    public function actionLoadDailyAtt()
    {

        $year = 2019;
        $month = 04;
        $icno = 890426495037;


        return $this->renderAjax('load-daily-att', [
            //                    'day' => $day,
            //                    'data' => $data,
        ]);
    }

    public function actionLoadWarnaKad()
    {
        $tahun = date('Y');
        $bulan = date('m');
        //        $color = 'YELLOW';
        //        $yellow = TblWarnaKad::JumlahWarnaKad($tahun, $bulan, 'YELLOW');
        //        $green = TblWarnaKad::JumlahWarnaKad($tahun, $bulan, 'GREEN');
        //        $red = TblWarnaKad::JumlahWarnaKad($tahun, $bulan, 'RED');
        //        echo $yellow . ' ' . $green . ' ' . $red;

        $month = ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'];

        foreach ($month as $key => $value) {
            $yellow[] = TblWarnaKad::JumlahWarnaKad($tahun, $key, 'YELLOW');
        }
        foreach ($month as $key => $value) {
            $green[] = TblWarnaKad::JumlahWarnaKad($tahun, $key, 'GREEN');
        }
        foreach ($month as $key => $value) {
            $red[] = TblWarnaKad::JumlahWarnaKad($tahun, $key, 'RED');
        }

        VarDumper::dump($yellow, 10, true);

        return $this->renderAjax('load-warna-kad', [
            //                    'day' => $day,
            'yellow' => $yellow,
            'green' => $green,
            'red' => $red,
        ]);
    }

    public function actionAttRpt()
    {

        $tahun = date('Y');
        $bulan = date('m');


        return $this->render('att-rpt', [
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);
    }

    public function actionLoadAttRpt()
    {

        $tahun = date('Y');
        $bulan = date('m');
        $icno = Yii::$app->user->getId();


        if ($post = Yii::$app->request->post()) {
            $bulan = $post['bulan'];
            $tahun = $post['tahun'];
            //            $nama_bulan = TblRekod::viewBulan($bulan);
        }

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $warna_kad = TblWarnaKad::WarnaKadSemasa($icno, $bulan, NULL, $tahun);

        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');

        return $this->renderAjax('load-att-rpt', [
            'tahun' => $tahun,
            'bulan' => $bulan,
            'icno' => $icno,
            'var' => $var,
            'biodata' => $biodata,
            'warna_kad' => $warna_kad
        ]);
    }

    public function actionPrintAttRpt($tahun, $bulan)
    {


        $id = Yii::$app->user->getId();
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        //        $tahun = date('Y');
        //        $bulan = date('m');
        //        if ($post = Yii::$app->request->post()) {
        //            $bulan = $post['bulan'];
        //            $tahun = $post['tahun'];
        ////            $nama_bulan = TblRekod::viewBulan($bulan);
        //        }

        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');

        $month = TblRekod::viewBulan($bulan);

        $this->view->title = "Attendance Report ($month)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_reportView', ['biodata' => $biodata, 'tahun' => $tahun, 'bulan' => $bulan, 'var' => $var, 'icno' => $id]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Attendance Report $biodata->CONm $month.pdf",
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
            'options' => ['title' => "Attendance Report($month)"],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["Attendance Report ($month)"],
                //                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                //                'SetFooter' => [' {PAGENO}'],
            ]
        ]);


        // return the pdf output as per the destination setting
        return $pdf->render();
        //        return $pdf->Output('yourfilename.pdf', 'D'); 
    }

    /**
     * kegunaan utk penyelia kehadiran utk memilih staf yang shift
     */
    public function actionStaffShiftList()
    {

        $staff = Tblstaff::find()->all();

        $array_staff = [];

        foreach ($staff as $r) {
            $array_staff[] = $r->staff_icno;
        }

        $id = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::find()
            ->where(['status' => 1])
            ->andWhere(['not in', 'ICNO', $array_staff])
            ->all();

        $model = new TblStaff();


        if ($model->load(Yii::$app->request->post())) {

            $model->sup_icno = $id;
            $model->created_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Added', 'type' => 'success', 'msg' => 'New staff Added!']);
                return $this->redirect(['kehadiran/staff-shift-list']);
            }
        }

        $staff = Tblstaff::find()->joinWith(['staff'])->where(['sup_icno' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $staff,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('staff-shift-list', [
            'model' => $model,
            'biodata' => $biodata,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionRemoveStaff($id)
    {
        $model = Tblstaff::findOne($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Removed', 'type' => 'success', 'msg' => 'Staff removed!']);
            return $this->redirect(['kehadiran/staff-shift-list']);
        }

        return $this->redirect(['index']);
    }

    /**
     * utk set shift by bulan
     */
    public function actionShiftSetup($tahun = null, $bulan = null)
    {

        $icno = Yii::$app->user->getId();

        if (!$bulan) {
            $bulan = date('m');
        }

        if (!$tahun) {
            $tahun = date('Y');
        }

        $var = $this->getDaysInYearMonth($tahun, $bulan, 'd');
        $day = $this->getDaysInYearMonth($tahun, $bulan, 'D');


        $staffs = Tblstaff::findAll(['sup_icno' => $icno]);

        return $this->render('shift-setup', [
            'staffs' => $staffs,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'var' => $var,
            'day' => $day,
            'bil' => 1,
        ]);
    }

    public function actionPrintShiftSetup($tahun, $bulan)
    {

        $icno = Yii::$app->user->getId();

        $var = $this->getDaysInYearMonth($tahun, $bulan, 'd');
        $day = $this->getDaysInYearMonth($tahun, $bulan, 'D');

        $staffs = Tblstaff::findAll(['sup_icno' => $icno]);

        $sup = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

        $month = TblRekod::viewBulan($bulan);

        $this->view->title = "Shift Listing ($month)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('print-shift-setup', [
            'staffs' => $staffs,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'var' => $var,
            'day' => $day,
            'sup' => $sup,
            'bil' => 1,
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Attendance Report $month.pdf",
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
            'options' => ['title' => "Monthly Shift Setup($month)"],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["Monthly Shift Setup($month)"],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionCreateShift($id, $tahun, $bulan)
    {

        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');

        $wp = RefWp::find()->all();

        $count = count($this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d'));
        $staffname = Tblprcobiodata::DisplayNameGred($id);
        $models = [new Tblshift()];

        for ($i = 1; $i < $count; $i++) {
            $models[] = new Tblshift();
        }


        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {

            foreach ($models as $m) {
                $m->icno = $id;
                $m->save(false);
            }
            return $this->redirect(['kehadiran/shift-setup', 'tahun' => $tahun, 'bulan' => $bulan]);
        }

        return $this->renderAjax('create-shift', [
            'models' => $models,
            'icno' => $id,
            'var' => $var,
            'wp' => $wp,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'staffname' => $staffname,
        ]);
    }

    public function actionUpdateShift($id, $tahun, $bulan)
    {

        $models = Tblshift::find()->where(['icno' => $id, 'YEAR(tarikh)' => $tahun, 'MONTH(tarikh)' => $bulan])->indexBy('id')->all();

        $wp = RefWp::find()->all();
        $staffname = Tblprcobiodata::DisplayNameGred($id);

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            foreach ($models as $model) {
                $model->save(false);
            }
            return $this->redirect(['kehadiran/shift-setup', 'tahun' => $tahun, 'bulan' => $bulan]);
        }

        return $this->renderAjax('update-shift', ['models' => $models, 'wp' => $wp, 'staffname' => $staffname, 'bulan' => $bulan, 'tahun' => $tahun]);
    }

    public function actionValidation()
    {

        $model = new TblRekod();
        $model->scenario = 'location';

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = 'json';

            return ActiveForm::validate($model);
        }
    }

    public function actionIndex3()
    {

        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');

        $link = 'kehadiran/clock-in';

        $model = new TblRekod();
        $model->scenario = 'location';

        $wp_id = TblWp::curr_wp($icno);

        $model_wp = RefWp::findOne(['id' => $wp_id]);

        $model_rekod = TblRekod::findOne(['icno' => $icno, 'tarikh' => $today]);

        if ($model_rekod) {
            $model_rekod->scenario = 'location';
        }

        $current_ip = $this->getRealUserIp();
        $ip_type = TblRekod::checkIp($current_ip);

        $time_in = $model_rekod ? $model_rekod->getFormatTimeIn() : '-';
        $time_out = isset($model_rekod->time_out) ? $model_rekod->getFormatTimeOut() : '-';
        $total_hours = isset($model_rekod->time_out) ? TblRekod::totalHour($time_in, $time_out) : '-';
        $statusAll = $model_rekod ? $model->getStatusAll() : '-';

        if ($model_rekod) {
            $model = $model_rekod;
            $statusAll = $model->getStatusAll();
            $link = 'kehadiran/clock-out';
        }

        //ni utk warna kad sblm 4hb
        $month_warna = $month;
        if ($today == "$year-$month-01" || $today == "$year-$month-02" || $today == "$year-$month-03") {
            $month_warna = $month - 1;
        }

        return $this->render('index3', [
            'model' => $model,
            'model_wp' => $model_wp,
            'wp_id' => $wp_id,
            'time_in' => $time_in,
            'time_out' => $time_out,
            'total_hours' => $total_hours,
            'current_ip' => $current_ip,
            'ip_type' => $ip_type,
            'statusAll' => $statusAll,
            'color' => TblWarnaKad::WarnaKadSemasa($icno, $month_warna, NULL, $year),
            'pendingNoti' => TblRekod::totalPendingAll($icno),
            'url_zone' => Yii::$app->urlManager->createUrl("kehadiran/zone"),
            'link' => $link,
        ]);
    }

    public function actionGrafTidakpatuh()
    {


        $icno = Yii::$app->user->getId();
        $bulan = date('m');
        $tahun = date('Y');

        $month = TblRekod::viewBulan($bulan);

        $data[] = [
            'name' => 'Total',
            'data' => [
                DataKehadiran::totalIndividuLatein($icno, $tahun, $bulan),
                DataKehadiran::totalIndividuEarlyout($icno, $tahun, $bulan),
                DataKehadiran::totalIndividuIncomplete($icno, $tahun, $bulan),
                DataKehadiran::totalIndividuAbsent($icno, $tahun, $bulan),
                DataKehadiran::totalIndividuExternal($icno, $tahun, $bulan),
            ]
        ];


        return $this->renderAjax('graf-tidakpatuh', ['data' => $data, 'month' => $month]);
    }

    public function actionGrafApprove()
    {


        $icno = Yii::$app->user->getId();
        $bulan = date('m');
        $tahun = date('Y');

        $warna = TblWarnaKad::find()->where(['icno' => $icno])->all();

        foreach ($warna as $w) {
            $categories[] = TblRekod::viewBulan($w->month);
        }

        foreach ($warna as $app) {
            $approved[] = $app->approved;
        }
        foreach ($warna as $dis) {
            $disapproved[] = $dis->disapproved;
        }

        foreach ($warna as $tidak) {
            $ketidakpatuhan[] = $tidak->ketidakpatuhan;
        }

        //        foreach ($warna as $warnas) {
        //        $data[] = 
        //            [['name' => 'Approved', 'data' => $approved],
        //            ['name' => 'Non-Compliances', 'data' => $ketidakpatuhan]];
        //        }
        //        $month = TblRekod::viewBulan($bulan);
        $data = [
            ['name' => 'Non-Compliances', 'data' => $ketidakpatuhan],
            ['name' => 'Approved', 'data' => $approved],
            ['name' => 'Disapproved', 'data' => $disapproved]
        ];


        //        ['name' => 'Approved', 'data' => [1, 0, 4,5,5]],
        //            ['name' => 'NotApproved', 'data' => [5, 7, 3,2,1]]


        return $this->renderAjax('graf-approve', ['data' => $data, 'categories' => $categories]);
    }

    public function actionColorRpt($color = null, $month = null, $tahun = null)
    {


        if ($color == null) {
            $color = 'RED';
        }

        if ($month == null) {
            $month = date('m');
        }

        if ($tahun == null) {
            $tahun = date('Y');
        }

        //        echo $color . $month;

        $sql = 'SELECT * FROM attendance.tbl_warnakad a JOIN hronline.tblprcobiodata b ON a.icno = b.ICNO
                JOIN hronline.gredjawatan c ON b.gredjawatan = c.id
                WHERE MONTH(a.month_date) = :month AND YEAR(a.month_date) = :year AND a.color = :color AND c.gred_skim NOT IN("KP") ORDER BY b.deptId, b.CONm';

        $model = TblWarnaKad::findBySql($sql, [':month' => $month, ':color' => $color, ':year' => $tahun])->all();

        $total = count($model);


        return $this->render('color-rpt', ['model' => $model, 'bil' => 1, 'month' => $month, 'tahun' => $tahun, 'monthBefore' => ($month - 1), 'color' => $color, 'total' => $total]);
    }

    public function actionColorRptPrint($color = null, $month = null, $tahun = null)
    {

        $sql = 'SELECT * FROM attendance.tbl_warnakad a JOIN hronline.tblprcobiodata b ON a.icno = b.ICNO
        JOIN hronline.gredjawatan c ON b.gredjawatan = c.id
        WHERE MONTH(a.month_date) = :month AND YEAR(a.month_date) = :year AND a.color = :color AND c.gred_skim NOT IN("KP") ORDER BY b.deptId, b.CONm';

        $model = TblWarnaKad::findBySql($sql, [':month' => $month, ':color' => $color, ':year' => $tahun])->all();

        $total = count($model);

        $bulan = TblRekod::viewBulan($month);

        $this->view->title = "Senarai Warna Kad ($bulan)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_color_rpt_print', ['model' => $model, 'bil' => 1, 'month' => $month, 'tahun' => $tahun, 'monthBefore' => ($month - 1), 'color' => $color, 'total' => $total]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Attendance Report.pdf",
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
            'options' => ['title' => "Attendance Report($month)"],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["Attendance Report ($month)"],
                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionLetter($id, $tahun, $bulan, $color)
    {

        //        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

        if ($color == 'RED') {
            $letter = '_red_letter';
        }
        if ($color == 'GREEN') {
            $letter = '_green_letter';
        }

        $sql_bio = 'SELECT * FROM hronline.tblprcobiodata WHERE MD5(ICNO) =:icno';
        $biodata = Tblprcobiodata::findBySql($sql_bio, [':icno' => $id])->one();

        $css = file_get_contents('./css/surat.css');

        $sblm = $bulan - 1;

        //        $month = TblRekod::viewBulan($bulan);
        $sql = 'SELECT * FROM attendance.tbl_rekod WHERE MD5(icno) =:icno AND MONTH(tarikh)=:month AND remark_status = "REJECTED"';
        $rekod = TblRekod::findBySql($sql, [':month' => $sblm, ':icno' => $id])->all();

        $this->view->title = "Surat Pemakluman";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial($letter, ['biodata' => $biodata, 'rekod' => $rekod, 'bulan' => $bulan, 'bil' => 1]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Surat $biodata->CONm.pdf",
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
            'options' => ['title' => "Surat Amaran"],
            // call mPDF methods on the fly
            'marginTop' => 35,
            'marginLeft' => 24,
            'marginRight' => 24,
            'methods' => [
                'WriteHTML' => [$css, 1]
                //                'SetHeader' => ["Attendance Report ($month)"],
                //                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                //                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        //        $pdf->AddPage();
        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionPrintLampiran($id, $tahun, $bulan)
    {


        $sql_bio = 'SELECT * FROM hronline.tblprcobiodata WHERE MD5(ICNO) =:icno';
        $biodata = Tblprcobiodata::findBySql($sql_bio, [':icno' => $id])->one();

        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');

        //        $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno =:icno AND MONTH(tarikh)=:month AND remark_status = "REJECTED"';
        //        $rekod = TblRekod::findBySql($sql, [':month' => $bulan, ':icno' => $biodata->ICNO])->all();
        $rekod = TblRekod::find()->where(['MONTH(tarikh)' => $bulan, 'icno' => $biodata->ICNO, 'remark_status' => ['APPROVED', 'REJECTED']])->all();

        $month = TblRekod::viewBulan($bulan);

        $this->view->title = "Lampiran ($month)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_lampiran', ['biodata' => $biodata, 'tahun' => $tahun, 'bulan' => $bulan, 'var' => $var, 'icno' => $biodata->ICNO, 'rekod' => $rekod, 'bil' => 1, 'month' => $month]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "$biodata->CONm $month.pdf",
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
            //            'options' => ['title' => "Attendance Report($month)"],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["Lampiran $biodata->COOldID"],
                'SetFooter' => ['[Surat ini adalah cetakan komputer dan tidak memerlukan tandatangan] {PAGENO}'],
                //                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionLocum()
    {

        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');

        $time = date('Y-m-d H:i:s');


        $dataProvider = new ActiveDataProvider([
            'query' => TblLocums::find()->where(['MONTH(tarikh)' => $month]),
            'pagination' => [
                'pageSize' => 32,
            ],
            'sort' => ['defaultOrder' => ['tarikh' => SORT_DESC]],
        ]);


        $model = TblLocums::CurrentRecords($icno);

        if (!$model) {
            $model = new TblLocums();
        }

        if ($model->load(Yii::$app->request->post())) {

            if ($model->isNewRecord) {
                $model->icno = $icno;
                $model->day = date('l'); // output: current day.
                $model->tarikh = $today;
                $model->time_in = $time;
                $model->in_lat_lng = $model->latlng;
                $model->in_ip = $this->getRealUserIp();
            } else {
                $model->time_out = $time;
                $model->out_lat_lng = $model->latlng;
                $model->out_ip = $this->getRealUserIp();
            }


            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Your time is recorded successfully!']);
            }
        }

        return $this->render('locum', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'url_zone' => Yii::$app->urlManager->createUrl("kehadiran/zone"),
        ]);
    }

    public function actionSenaraiWarnaKad($year = NULL, $month = NULL, $dept_id = null)
    {

        $icno = Yii::$app->user->getId();

        if (!$year) {
            $year = date('Y');
        }
        if (!$month) {
            $month = date('m');
        }

        $arr_dept = array();
        $arr_campus = array();
        $arr_icno = [];

        $model = AksesPengguna::find()->where(['akses_cuti_icno' => $icno])->all();

        $isAdmin = AksesPengguna::findOne(['akses_cuti_icno' => $icno])->akses_cuti_int == 3 ? true : false;

        $model_dept = Department::find()->where(['isActive' => 1])->all();


        if ($dept_id) {
            $arr_dept[] = $dept_id;
        } else {
            foreach ($model as $r) {
                $arr_dept[] = $r->akses_jspiu_id;
            }
        }


        foreach ($model as $r) {
            $arr_campus[] = $r->akses_kampus_id;
        }


        $biodata = Tblprcobiodata::find()->where(['Status' => 1, 'DeptId' => $arr_dept, 'campus_id' => $arr_campus])->all();

        foreach ($biodata as $bio) {
            $arr_icno[] = $bio->ICNO;
        }

        $warnakad_model = TblWarnaKad::find()->where(['icno' => $arr_icno, 'YEAR(month_date)' => $year, 'MONTH(month_date)' => $month])->all();
        //        VarDumper::dump($warnakad_model,10,true);

        return $this->render('senarai-warna-kad', ['isAdmin' => $isAdmin, 'dept_id' => $dept_id, 'warnakad_model' => $warnakad_model, 'bil' => 1, 'month' => $month, 'year' => $year, 'model_dept' => $model_dept]);
    }

    public function actionSenaraiWarnaKadPrint($year = NULL, $month = NULL)
    {

        $icno = Yii::$app->user->getId();

        if (!$year) {
            $year = date('Y');
        }
        if (!$month) {
            $month = date('m');
        }

        $arr_dept = array();
        $arr_campus = array();

        $model = AksesPengguna::find()->where(['akses_cuti_icno' => $icno])->all();

        foreach ($model as $r) {
            $arr_dept[] = $r->akses_jspiu_id;
        }
        foreach ($model as $r) {
            $arr_campus[] = $r->akses_kampus_id;
        }

        $biodata = Tblprcobiodata::find()->where(['Status' => 1, 'DeptId' => $arr_dept, 'campus_id' => $arr_campus])->all();

        foreach ($biodata as $bio) {
            $arr_icno[] = $bio->ICNO;
        }

        $warnakad_model = TblWarnaKad::find()->where(['icno' => $arr_icno, 'YEAR(month_date)' => $year, 'MONTH(month_date)' => $month])->all();

        $title = "Senarai Warna Kad ($month/$year)";

        $this->view->title = $title;
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('senarai-warna-kad-print', ['warnakad_model' => $warnakad_model, 'bil' => 1, 'month' => $month, 'year' => $year]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Senarai Warna Kad",
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
            'options' => ['title' => $title],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => [$title],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionStafColorList($month = null, $year = null)
    {

        $icno = Yii::$app->user->getId();

        if (!$year) {
            $year = date('Y');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => TblWarnaKad::find()->where(['icno' => $icno, 'YEAR(month_date)' => $year])->orderBy(['month_date' => 'DESC']),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('staf-color-list', ['icno' => $icno, 'year' => $year, 'dataProvider' => $dataProvider]);
    }

    public function actionAdminPostList()
    {

        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1])->all();

        $array_post_id = [];

        foreach ($akadpost as $r) {
            $array_post_id[] = $r->id;
        }

        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['tblrscoadminpost.flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'tblrscoadminpost.adminpos_id', $array_post_id]);
        // VarDumper::dump($model, $depth = 10, $highlight = true);

        $provider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 300,
            ],
        ]);

        return $this->render('admin-post-list', ['model' => $model, 'provider' => $provider]);
    }

    public function actionRangeMonth()
    {

        $tahun = date('Y');
        $start_mth = 1;
        $end_mth = 12;

        if ($post = Yii::$app->request->post()) {
            $id = $post['id'];
            $tahun = $post['tahun'];
            $start_mth = $post['start_mth'];
            $end_mth = $post['end_mth'];

            $this->redirect(['gen-yearly-pdf-rpt', 'id' => $id, 'tahun' => $tahun, 'start_mth' => $start_mth, 'end_mth' => $end_mth]);
        }

        return $this->render('range-month', ['tahun' => $tahun, 'start_mth' => $start_mth, 'end_mth' => $end_mth]);
    }


    /**
     * kehadiran/gen-yearly-pdf-rpt
     */
    public function actionGenYearlyPdfRpt($id, $tahun, $start_mth, $end_mth)
    {


        $label_start = strtoupper(TblRekod::viewBulan($start_mth));
        $label_end = strtoupper(TblRekod::viewBulan($end_mth));

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

        $name = $biodata->CONm;
        $jawatan = $biodata->jawatan->gred;
        $jfpiu = $biodata->department->shortname;


        $content = $this->renderPartial(
            'gen-yearly-pdf-rpt',
            [
                'biodata' => $biodata,
                'tahun' => $tahun,
                'icno' => $id,
                'start_mth' => $start_mth,
                'end_mth' => $end_mth,
            ]
        );

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'filename' => "$biodata->CONm.pdf",
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '
                @media all{
                    .font_next{font-family:DoodlePen}table{border-collapse:collapse;width:100%}td{border:1px solid #000}.page-break {display: none;}
                }
                @media print{
                    .page-break{display: block;page-break-before: always;}
                }
            ',
            'methods' => [
                'SetHeader' => ["$name / $jawatan / $jfpiu - (ATTENDANCE REPORT $label_start - $label_end $tahun)"],
                'SetFooter' => [' {PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }

    public function actionWfhMohon()
    {

        $icno = Yii::$app->user->getId();

        $model_biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $model = new TblWfh();
        $model->scenario = 'mohon';
        $model_department = Department::findOne(['id' => $model_biodata->DeptId]);
        $model_set_pegawai = SetPegawai::findOne(['pemohon_icno' => $icno]);

        $kj_icno = $model_department->chief;

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        //ni jika dia juga ketua jabatan
        if ($model_department->chief == $icno) {
            $kj_icno = $model_set_pegawai->pelulus_icno;
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file) {
                $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '01', 'Work From Home');

                if ($datas->status == true) {
                    $model->hashcode = $datas->file_name_hashcode;
                    $model->doc_name = $model->file->name;
                }
            }

            $model->icno = $icno;
            $model->entry_dt = date('Y-m-d H:i:s');
            $model->tempoh = $model->totalDays;

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar kepada ketua jabatan']);

                $btn = Html::a('disini', ['/kehadiran/wfh-lulus'], ['class' => 'btn btn-primary btn-sm']);

                $ntf = new Notification();
                $ntf->icno = $model_department->chief;
                $ntf->title = 'WFH';
                $ntf->content = "<p>Permohonan <strong>bekerja dari rumah/Work from Home(WFH)</strong> menunggu tindakan anda. klik disini $btn</p>";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();

                return $this->redirect(['kehadiran/wfh-list']);
            }
        }

        return $this->render('wfh-mohon', [
            'model' => $model,
            'model_department' => $model_department,
            'icno' => $icno,
            'kj_icno' => $kj_icno,
            'model_set_pegawai' => $model_set_pegawai,
        ]);
    }

    public function actionWfhList()
    {

        $icno = Yii::$app->user->getId();

        $model = TblWfh::find()->where(['icno' => $icno])->andWhere(['>=', 'YEAR(start_date)', '2022'])->orderby(['start_date' => 'DESC'])->all();

        return $this->render('wfh-list', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionWfhPeraku()
    {

        $icno = Yii::$app->user->getId();

        $peraku = TblWfh::findAll(['ver_by' => $icno, 'status' => 'ENTRY']);

        $approver = '731011135058'; // Pn Yat


        if ($pilih = Yii::$app->request->post()) {

            foreach ($pilih['TblWfh']['id'] as $k => $v) {
                if ($v != 0) {
                    $model = TblWfh::findOne($v);
                    $model->status = 'VERIFIED';
                    $model->ver_dt = date('Y-m-d H:i:s');
                    $model->app_by = $approver;

                    if ($model->save()) {

                        $btn = Html::a('disini', ['/kehadiran/wfh-lulus'], ['class' => 'btn btn-primary btn-sm']);

                        //----------Model Notification ---------//
                        $ntf = new Notification();
                        $ntf->icno = $approver;
                        $ntf->title = 'WFH';
                        $ntf->content = "<p>Permohonan <strong>bekerja dari rumah/Work from Home(WFH)</strong> menunggu tindakan anda. klik disini $btn</p>";
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                    }
                }
            }
            //--------Model Notification-----------//
            //Yii::$app->session->setFlash('info', 'Sebab Kesalahan Telah Dihantar');
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Perakuan permohonan WFH telah dihantar!']);
            return $this->redirect(['kehadiran/wfh-peraku']);
        }


        return $this->render('wfh-peraku', [
            'peraku' => $peraku,
            'bil' => 1,
        ]);
    }

    public function actionWfhPerakuTindakan($id)
    {

        $icno = Yii::$app->user->getId();
        $approver = '731011135058'; // Pn Yat

        $model = TblWfh::findOne(['id' => $id, 'ver_by' => $icno, 'status' => 'ENTRY']);

        //submiting
        if ($model->load(Yii::$app->request->post())) {

            $model->ver_dt = date('Y-m-d H:i:s');
            $model->app_by = $approver; // Pn Yat;

            if ($model->save()) {

                if ($model->status == 'VERIFIED') {

                    $btn = Html::a('disini', ['/kehadiran/wfh-lulus'], ['class' => 'btn btn-primary btn-sm']);

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $approver;
                    $ntf->title = 'WFH';
                    $ntf->content = "<p>Permohonan <strong>bekerja dari rumah/Work from Home(WFH)</strong> menunggu tindakan anda. klik disini $btn</p>";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                } elseif ($model->status == 'REJECTED') {

                    $ntf = new Notification();
                    $ntf->icno = $model->icno;
                    $ntf->title = 'WFH';
                    $ntf->content = "<p>Permohonan <strong>bekerja dari rumah/Work from Home(WFH)</strong> anda pada <strong>$model->full_date</strong> <strong>DITOLAK</strong> </p>";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Perakuan permohonan WFH telah dihantar!']);
                return $this->redirect(['kehadiran/wfh-peraku']);
            }
        }


        return $this->render('wfh-peraku-tindakan', ['model' => $model]);
    }


    public function actionWfhLulus()
    {

        $icno = Yii::$app->user->getId();

        $lulus = TblWfh::findAll(['app_by' => $icno, 'status' => 'ENTRY']);

        if ($pilih = Yii::$app->request->post()) {

            foreach ($pilih['TblWfh']['id'] as $k => $v) {
                if ($v != 0) {
                    $model = TblWfh::findOne($v);
                    $model->scenario = 'kelulusan';

                    $model->status = 'APPROVED';
                    $model->app_dt = date('Y-m-d H:i:s');

                    if ($model->save()) {

                        //----------Model Notification ---------//
                        $ntf = new Notification();
                        $ntf->icno = $model->icno;
                        $ntf->title = 'WFH';
                        $ntf->content = "<p>Permohonan bekerja dari rumah/ Work from Home(WFH) pada <strong>$model->full_date</strong> bertempoh selama <strong>$model->tempoh</strong> hari telah diluluskan !</p>";
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                    }
                }
            }
            //--------Model Notification-----------//
            //Yii::$app->session->setFlash('info', 'Sebab Kesalahan Telah Dihantar');
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan WFH telah diluluskan!']);
            return $this->redirect(['kehadiran/wfh-lulus']);
        }


        return $this->render('wfh-lulus', [
            'lulus' => $lulus,
            'bil' => 1,
        ]);
    }

    public function actionWfhLulusTindakan($id)
    {

        $icno = Yii::$app->user->getId();

        $model = TblWfh::findOne(['id' => $id, 'app_by' => $icno, 'status' => 'ENTRY']);
        $model->scenario = 'kelulusan';

        //submiting
        if ($model->load(Yii::$app->request->post())) {

            $model->app_dt = date('Y-m-d H:i:s');

            if ($model->save()) {

                if ($model->status == 'APPROVED') {

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->icno;
                    $ntf->title = 'WFH';
                    $ntf->content = "<p>Permohonan bekerja dari rumah/ Work from Home(WFH) pada <strong>$model->full_date</strong> bertempoh selama <strong>$model->tempoh</strong> hari telah diluluskan !</p>";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                } elseif ($model->status == 'REJECTED') {
                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->icno;
                    $ntf->title = 'WFH';
                    $ntf->content = "<p>Permohonan <strong>bekerja dari rumah/Work from Home(WFH)</strong> anda pada <strong>$model->full_date</strong> <strong>DITOLAK</strong> </p>";;
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                }
                //--------Model Notification-----------//
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Kelulusan permohonan WFH telah dihantar!']);
                return $this->redirect(['kehadiran/wfh-lulus']);
            }
        }


        return $this->render('wfh-lulus-tindakan', ['model' => $model]);
    }


    public function actionWfhSet($id)
    {

        $icno = Yii::$app->user->getId();

        $model = new TblWfh();

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $id;
            $model->entry_dt = date('Y-m-d H:i:s');
            $model->tempoh = $model->totalDays;
            $model->set_by = $icno;
            $model->status = 'APPROVED';
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'WFH telah berjaya ditambah']);

                $btn = Html::a('disini', ['/kehadiran/wfh-peraku'], ['class' => 'btn btn-primary btn-sm']);

                return $this->redirect(['kehadiran/wfh-list']);
            }
        }

        return $this->render('wfh-set', [
            'model' => $model,
            'icno' => $id,
        ]);
    }

    public function actionWfhByMth($tahun = null, $bulan = null)
    {

        $icno = Yii::$app->user->getId();

        $year = date('Y');
        $mth = date('m');

        $var = null;
        if ($tahun != null) {
            $year = $tahun;
        }

        if ($bulan != null) {
            $mth = $bulan;
        }

        if ($tahun && $bulan) {
            $var = $this->getDaysInYearMonth($year, $mth, 'Y-m-d');
        }


        $staff = AksesPengguna::kakitanganSeliaan($icno);

        $totalStaff = count($staff);

        return $this->render('wfh-by-mth', [
            'totalStaff' => $totalStaff,
            'tahun' => $year,
            'bulan' => $mth,
            'var' => $var,
            'icno' => $icno,
        ]);
    }

    public function actionWfhEditDay($date)
    {

        $icno = Yii::$app->user->getId();

        $staff = AksesPengguna::kakitanganSeliaan($icno);

        $array_own_staff = [];

        foreach ($staff as $r) {
            $array_own_staff[] = $r->ICNO;
        }


        $today_wfh_list = TblWfh::find()->joinWith('kakitangan')->where(['tbl_wfh.start_date' => $date, 'tbl_wfh.status' => 'APPROVED'])->andWhere(['in', 'tbl_wfh.icno', $array_own_staff])->orderBy(['tblprcobiodata.CONm' => SORT_ASC])->all();


        $array_staff = [];

        foreach ($today_wfh_list as $r) {
            $array_staff[] = $r->icno;
        }

        $dropdown_list_name = AksesPengguna::kakitanganSeliaan($icno, ['not in', 'ICNO', $array_staff]);


        $totalWfh = count($today_wfh_list);
        $totalStaff = count($staff);

        $percentWfh = ($totalWfh != 0 ? round($totalWfh / $totalStaff * 100, 2) : 0);
        $percentWfo = ($totalWfh != 0 ? round(($totalStaff - $totalWfh) / $totalStaff * 100, 2) : 0);


        $model = new TblWfh();

        if ($post = Yii::$app->request->post()) {


            if (isset($post['TblWfh']['id'])) {

                $bulk_id = $post['TblWfh']['id'];

                foreach ($bulk_id as $k => $v) {
                    if ($v != 0) {
                        $mdl = TblWfh::findOne(['id' => $v]);

                        // if (TblPermohonan::ExistApplicationWfo($mdl->icno, $mdl->start_date) == FALSE) {
                        //     TblPermohonan::ApplyWfo($mdl->icno, $mdl->start_date);
                        // }

                        $mdl->delete();
                    }
                }
            }


            if (isset($post['TblWfh']['icno'])) {

                $bulk_icno = $post['TblWfh']['icno'];

                $full_date = Yii::$app->formatter->asDate($date, 'php:d/m/Y') . ' to ' . Yii::$app->formatter->asDate($date, 'php:d/m/Y');

                foreach ($bulk_icno as $k => $v) {
                    if ($v != '') {
                        $model = new TblWfh();
                        $model->icno = $v;
                        $model->entry_dt = date('Y-m-d H:i:s');
                        $model->start_date = $date;
                        $model->end_date = $date;
                        $model->full_date = $full_date;
                        $model->tempoh = $model->totalDays;
                        $model->set_by = $icno;
                        $model->status = 'APPROVED';
                        $model->remark = 'ADDED BY PENYELIA';

                        $model->save(false);
                    }
                }
            }


            return $this->redirect(['kehadiran/wfh-edit-day', 'date' => $date]);
        }

        return $this->render('wfh-edit-day', [
            'bil' => 1,
            'model' => $model,
            'date' => $date,
            'totalWfh' => $totalWfh,
            'percentWfh' => $percentWfh,
            'totalStaff' => $totalStaff,
            'percentWfo' => $percentWfo,
            'dropdown_list_name' => $dropdown_list_name,
            'today_wfh_list' => $today_wfh_list,
        ]);
    }

    public function actionPpvEditDay($date)
    {

        $icno = Yii::$app->user->getId();

        $staff = AksesPengguna::kakitanganSeliaan($icno);

        $array_own_staff = [];
        $ppv_tetap = '';
        $array_staff = [];
        $arr_ppv_tetap = [];
        $time_id = 3; // sementara pakai 12 - 2 sja

        foreach ($staff as $r) {
            $array_own_staff[] = $r->ICNO;
        }


        $today_wfh_list = TblPpv::find()->joinWith('kakitangan')->where(['tbl_ppv.tarikh' => $date])->andWhere(['in', 'tbl_ppv.icno', $array_own_staff])->orderBy(['tblprcobiodata.CONm' => SORT_ASC])->all();


        foreach ($today_wfh_list as $r) {
            $array_staff[] = $r->icno;
        }

        $ppv_tetap_check = TempPpv::find()->where(['in', 'icno', $array_own_staff])->all();

        if ($ppv_tetap_check) {
            $ppv_tetap = $ppv_tetap_check;

            $arr_ppv_tetap = ArrayHelper::getColumn($ppv_tetap, 'icno', $keepKeys = true);
        }

        $dropdown_list_name = AksesPengguna::kakitanganSeliaan($icno, ['not in', 'ICNO', $array_staff], null, ['not in', 'ICNO', $arr_ppv_tetap]);


        $model = new TblPpv();

        if ($post = Yii::$app->request->post()) {


            if (isset($post['TblPpv']['id'])) {

                $bulk_id = $post['TblPpv']['id'];

                foreach ($bulk_id as $k => $v) {
                    if ($v != 0) {
                        $mdl = TblPpv::findOne(['id' => $v]);

                        if ($mdl->delete()) {
                            TblPermohonan::DeleteLetterPpv($mdl->icno, $date, $time_id);
                        }
                    }
                }
            }


            if (isset($post['TblPpv']['icno'])) {

                $bulk_icno = $post['TblPpv']['icno'];


                foreach ($bulk_icno as $k => $v) {
                    if ($v != '') {
                        $model = new TblPpv();
                        $model->icno = $v;
                        $model->tarikh = $date;

                        if ($model->save()) {
                            if (TblPermohonan::ExistApplicationWfoPppv($v, $date, $time_id) == FALSE) {
                                TblPermohonan::ApplyWfoPpv($v, $date, $time_id);
                            }
                        }
                    }
                }
            }


            return $this->redirect(['kehadiran/ppv-edit-day', 'date' => $date]);
        }

        return $this->render('ppv-edit-day', [
            'bil' => 1,
            'bil2' => 1,
            'model' => $model,
            'date' => $date,
            'dropdown_list_name' => $dropdown_list_name,
            'today_wfh_list' => $today_wfh_list,
            'ppv_tetap' => $ppv_tetap,
        ]);
    }


    public function actionWfoList($date)
    {

        $icno = Yii::$app->user->getId();
        $staff = AksesPengguna::kakitanganSeliaan($icno);

        $array_own_staff = [];

        foreach ($staff as $r) {
            $array_own_staff[] = $r->ICNO;
        }

        $today_wfh_list = TblWfh::find()->where(['start_date' => $date, 'status' => 'APPROVED'])->andWhere(['in', 'icno', $array_own_staff])->all();

        $array_staff = [];

        foreach ($today_wfh_list as $r) {
            $array_staff[] = $r->icno;
        }

        $dropdown_list_name = AksesPengguna::kakitanganSeliaan($icno, ['not in', 'ICNO', $array_staff]);

        return $this->renderAjax('wfo-list', [
            'bil' => 1,
            'model' => $dropdown_list_name,
            'date' => $date,
        ]);
    }

    public function actionWfhRemoveStaff($id, $date)
    {
        $model = TblWfh::findOne($id);

        // if (TblPermohonan::ExistApplicationWfo($model->icno, $model->start_date) == FALSE) {
        //     TblPermohonan::ApplyWfo($model->icno, $model->start_date);
        // }

        if ($model->delete()) {

            Yii::$app->session->setFlash('alert', ['title' => 'Removed', 'type' => 'success', 'msg' => 'Staff removed!']);
        }

        return $this->redirect(['kehadiran/wfh-edit-day', 'date' => $date]);
    }

    public function actionPpvRemoveStaff($id, $date)
    {
        $model = TblPpv::findOne($id);
        $time_id = 3;

        if ($model->delete()) {
            TblPermohonan::DeleteLetterPpv($model->icno, $date, $time_id);
            Yii::$app->session->setFlash('alert', ['title' => 'Removed', 'type' => 'success', 'msg' => 'Staff removed!']);
            // return $this->redirect(['kehadiran/wfh-edit-day', 'date'=>$date]);
        }

        return $this->redirect(['kehadiran/ppv-edit-day', 'date' => $date]);
    }

    /**
     * utk jana surat by individu
     */
    public function actionJanaSuratWfo($icno, $date)
    {

        // if (TblPermohonan::ExistApplicationWfo($icno, $date) == FALSE) {
        //     TblPermohonan::ApplyWfo($icno, $date);
        // }

        $year = date("Y", strtotime($date));
        $mth = date("m", strtotime($date));

        return $this->redirect(['kehadiran/wfh-by-mth', 'tahun' => $year, 'bulan' => $mth]);
    }

    public function actionWfhJadual($tahun = null, $bulan = null)
    {

        $icno = Yii::$app->user->getId();

        $year = date('Y');
        $mth = date('m');

        $var = null;
        if ($tahun != null) {
            $year = $tahun;
        }

        if ($bulan != null) {
            $mth = $bulan;
        }

        if ($tahun && $bulan) {
            $var = $this->getDaysInYearMonth($year, $mth, 'Y-m-d');
        }

        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $staff = AksesPengguna::kakitanganSeliaan($icno);

        $totalStaff = count($staff);

        return $this->render('wfh-jadual', [
            'tahun' => $year,
            'bulan' => $mth,
            'var' => $var,
            'icno' => $icno,
            'staff' => $staff,
            'totalStaff' => $totalStaff,
            'bio' => $bio,
            'bil' => 1,
        ]);
    }

    public function actionPrintWfhJadual($tahun = null, $bulan = null)
    {

        $icno = Yii::$app->user->getId();

        $year = date('Y');
        $mth = date('m');

        $var = null;
        if ($tahun != null) {
            $year = $tahun;
        }

        if ($bulan != null) {
            $mth = $bulan;
        }

        if ($tahun && $bulan) {
            $var = $this->getDaysInYearMonth($year, $mth, 'Y-m-d');
        }

        $bln = TblRekod::viewBulanBm($mth);

        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $jfpiu = $bio->department->fullname;

        $staff = AksesPengguna::kakitanganSeliaan($icno);

        $this->view->title = "Jadual WFH ($mth)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('print-wfh-jadual', [
            'tahun' => $year,
            'bulan' => $mth,
            'var' => $var,
            'icno' => $icno,
            'staff' => $staff,
            'bln' => $bln,
            'bil' => 1,
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Jadual.pdf",
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
            'options' => ['title' => "Jadual WFH ($bln) - $jfpiu"],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["Jadual WFH ($bln) - $jfpiu"],
                //                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionWfhJadualKj($tahun = null, $bulan = null)
    {

        $icno = Yii::$app->user->getId();

        $year = date('Y');
        $mth = date('m');

        $var = null;
        if ($tahun != null) {
            $year = $tahun;
        }

        if ($bulan != null) {
            $mth = $bulan;
        }

        if ($tahun && $bulan) {
            $var = $this->getDaysInYearMonth($year, $mth, 'Y-m-d');
        }

        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $chief = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $staff = Tblprcobiodata::find()->where(['Status' => 1, 'DeptId' => $chief->DeptId])->all();

        $totalStaff = count($staff);

        return $this->render('wfh-jadual-kj', [
            'tahun' => $year,
            'bulan' => $mth,
            'var' => $var,
            'icno' => $icno,
            'staff' => $staff,
            'totalStaff' => $totalStaff,
            'bio' => $bio,
            'bil' => 1,
        ]);
    }

    public function actionPantauStaf()
    {

        $icno = Yii::$app->user->getId();

        $staff = AksesPengguna::kakitanganSeliaan($icno);

        $arr_staff = [];

        foreach ($staff as $s) {
            $arr_staff[] = $s->ICNO;
        }

        $model = TblRekod::find()
            ->where(['remark_status' => 'ENTRY'])
            ->andWhere(['IN', 'icno', $arr_staff]);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'tarikh' => SORT_ASC,
                ]
            ],
        ]);

        $columnData = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Tarikh Kehadiran',
                'value' => 'formatTarikh',
            ],
            'kakitangan.CONm',
            [
                'label' => 'Jenis Ketidakpatuhan',
                'value' => 'statusAll',
                'format' => 'raw',
            ],
            [
                'label' => 'Catatan Ketidakpatuhan',
                'value' => 'remark',
            ],
            [
                'label' => 'Catatan pada',
                'value' => 'catatanPada',
            ],
            [
                'label' => 'Pegawai Peraku',
                'value' => 'app.CONm',
            ],
        ];

        return $this->render('pantau-staf', [
            'dataProvider' => $dataProvider,
            'columnData' => $columnData,
        ]);
    }

    public function actionWfhJadualAdmin($tahun = null, $bulan = null, $deptId = null)
    {

        $icno = Yii::$app->user->getId();
        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $year = date('Y');
        $mth = date('m');
        $jfpib = $bio->DeptId;

        $var = null;
        if ($tahun != null) {
            $year = $tahun;
        }

        if ($bulan != null) {
            $mth = $bulan;
        }

        if ($deptId != null) {
            $jfpib = $deptId;
        }

        //        echo $jfpib;
        //        exit();

        if ($tahun && $bulan) {
            $var = $this->getDaysInYearMonth($year, $mth, 'Y-m-d');
        }


        $staff = AksesPengguna::kakitanganSeliaan($icno, null, $jfpib);

        $totalStaff = count($staff);

        return $this->render('wfh-jadual-admin', [
            'tahun' => $year,
            'bulan' => $mth,
            'var' => $var,
            'icno' => $icno,
            'deptId' => $jfpib,
            'staff' => $staff,
            'totalStaff' => $totalStaff,
            'bio' => $bio,
            'bil' => 1,
        ]);
    }

    public function actionPrintWfhJadualAdmin($tahun = null, $bulan = null, $deptId = null)
    {

        $icno = Yii::$app->user->getId();
        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $year = date('Y');
        $mth = date('m');
        $jfpib = $bio->DeptId;

        $var = null;
        if ($tahun != null) {
            $year = $tahun;
        }

        if ($bulan != null) {
            $mth = $bulan;
        }

        if ($deptId != null) {
            $jfpib = $deptId;
        }

        if ($tahun && $bulan) {
            $var = $this->getDaysInYearMonth($year, $mth, 'Y-m-d');
        }


        $bln = TblRekod::viewBulanBm($mth);

        // $jfpiu = $bio->department->fullname;

        $staff = AksesPengguna::kakitanganSeliaan($icno, null, $jfpib);

        $this->view->title = "Jadual WFH ($mth)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('print-wfh-jadual', [
            'tahun' => $year,
            'bulan' => $mth,
            'var' => $var,
            'icno' => $icno,
            'staff' => $staff,
            'deptId' => $jfpib,
            'bln' => $bln,
            'bil' => 1,
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Jadual.pdf",
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
            'options' => ['title' => "Jadual WFH ($bln) - $jfpib"],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["Jadual WFH ($bln) - $jfpib"],
                //                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionShieldStatusList()
    {
        $icno = Yii::$app->user->getId();

        $staff = AksesPengguna::kakitanganSeliaan($icno);

        return $this->render('shield-status-list', [
            'staff' => $staff,
            'bil' => 1,
        ]);
    }

    public function actionWfoListAll($date)
    {

        $today_wfh_list = TblWfh::find()->where(['start_date' => $date, 'status' => 'APPROVED'])->all();

        $array_staff = [];

        foreach ($today_wfh_list as $r) {
            $array_staff[] = $r->icno;
        }

        $staff = Tblprcobiodata::find()->where(['Status' => 1, 'campus_id' => 1])
            ->andFilterWhere(['not in', 'ICNO', $array_staff])
            ->orderBy(['CONm' => SORT_ASC])->all();

        return $this->render('wfo-list-all', [
            'bil' => 1,
            'model' => $staff,
            'date' => $date,
        ]);
    }

    public function actionPantauPermohonanWfh()
    {

        $this->view->title = 'Senarai Permohonan WFH kakitangan seliaan';

        $icno = Yii::$app->user->getId();

        $staff = AksesPengguna::kakitanganSeliaan($icno);

        $arr_staff = [];

        foreach ($staff as $s) {
            $arr_staff[] = $s->ICNO;
        }

        $searchModel = new TblWfh();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $arr_staff);



        return $this->render('pantau-permohonan-wfh', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionPantauPermohonanWfhAdmin()
    {

        $this->view->title = 'Senarai Permohonan WFH';

        $searchModel = new TblWfh();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);



        return $this->render('pantau-permohonan-wfh', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionPrestasiWarnaKadStaff($id)
    {

        $this->view->title = 'Prestasi Warna kad Staf';

        $year = TblRekod::find()->select('YEAR(tarikh) as year')->where(['icno' => $id])->groupBy(['YEAR(tarikh)'])->asArray()->all();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

        return $this->render('prestasi-warna-kad-staff', [
            'biodata' => $biodata,
            'year' => $year,
            'icno' => $id,
        ]);
    }

    public function actionPantauPermohonanWfhPegawai()
    {

        $this->view->title = 'Senarai Permohonan WFH';

        $icno = Yii::$app->user->getId();

        $searchModel = new TblWfh();
        $dataProvider = $searchModel->searchAsPegawai(Yii::$app->request->queryParams, $icno);

        return $this->render('pantau-permohonan-wfh', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionDeleteWfh($id)
    {
        $model = TblWfh::findOne($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Removed', 'type' => 'success', 'msg' => 'Permohonan telah dibuang!']);
            return $this->redirect(['kehadiran/pantau-permohonan-wfh']);
        }

        return $this->redirect(['index']);
    }

    public function actionSenaraiPrestasiStaf($year = null)
    {
        if (!$year) {
            $year = date('Y');
        }

        $biodata = Tblprcobiodata::find()->where(['Status' => 1])->all();

        return $this->render('senarai-prestasi-staf', [
            'biodata' => $biodata,
            'year' => $year,
            'bil' => 1,
        ]);
    }
}
