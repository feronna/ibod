<?php

namespace app\controllers;

use app\models\cuti\AksesPengguna;
use Yii;
use kartik\mpdf\Pdf;
use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblRekodPatrol;
use app\models\keselamatan\TblLaporanKejadian;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\keselamatan\RefShifts;
use app\models\keselamatan\RefShiftsSearch;
use app\models\keselamatan\TblTindakanLisanSearch;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\TblStaffKeselamatan;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefPosKawalanSearch;
use app\models\keselamatan\RefUnit;
use app\models\keselamatan\RefUnitSearch;
use DateTime;
use app\models\keselamatan\TblShiftKeselamatan;
use yii\base\Model;
use app\models\keselamatan\TblLocation;
use app\models\keselamatan\TblOt;
use app\models\keselamatan\TblLmt;
use app\models\keselamatan\RefLmt;
use app\models\keselamatan\RefLmtSearch;
use app\models\keselamatan\TblLmtKeselamatan;
use app\models\keselamatan\RefPatrolPos;
use app\models\keselamatan\RefPatrolPosSearch;
use app\models\keselamatan\TblRekodOt;
use app\models\keselamatan\TblRekodPegMedan;
use yii\helpers\VarDumper;
use app\models\keselamatan\TblRekodLmt;
use app\models\Notification;
use app\models\keselamatan\TblReports;
use app\models\keselamatan\TblKesalahan;
use app\models\keselamatan\TblAkses;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\keselamatan\TblRollcall;
use app\models\cuti\Layak;
use app\models\cuti\CutiRekod;
use app\models\keselamatan\TblTukarSyif;
use yii\web\ForbiddenHttpException;
use app\models\kehadiran\RefWp;
use app\models\KeluarPejabat;
use yii\web\UploadedFile;
use app\models\cuti\SetPegawai;
use app\models\cuti\TblRecords;
use app\models\hronline\Department;
use app\models\hronline\Tblvaksinasi;
use app\models\keselamatan\RefKenderaanBkums;
use app\models\keselamatan\TblWarnakad;
use app\models\keselamatan\TblJadualDoPm;
use app\models\keselamatan\TblPatrolStaff;
use app\models\keselamatan\TblTindakanBertulisLisan;
use app\models\kehadiran\TblWfh;
use app\models\kehadiran\TblYears;
use app\models\keselamatan\Logs;
use app\models\keselamatan\TempTable;
use app\models\keselamatan\TblSetPegawai;
use app\models\system_core\TblUserAccess;
use tebazil\runner\ConsoleCommandRunner;

//use app\models\cutil
//use PHPExcel_IOFactory;

/**
 * KeselamatanController implements the CRUD actions for TblRekod model.
 */
class KeselamatanController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['pos-kawalan', 'change-verified', 'verifying-report', 'report-to-verify', 'do-setup', 'laporan-bulanan', 'laporan-tahunan', 'senarai-kakitangan', 'import', 'import-ot', 'import-hakiki', 'akses-pengguna', 'peg-medan', 'senarai-tindakan', 'kemaskini-kesalahan-anggota', 'laporan'],
                'rules' => [
                    //superadmin
                    [
                        'actions' => ['laporan', 'akses-pengguna', 'change-verified', 'verifying-report', 'report-to-verify'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            if (TblAkses::find()->where(['icno' => $logicno])->andWhere(['akses_level' => 1])->exists()) {
                                $check = TblAkses::find()->where(['icno' => $logicno])->andWhere(['akses_level' => 1]);
                            }

                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],

                    //pegawai punya access control
                    [
                        'actions' => ['laporan', 'peg-medan', 'senarai-tindakan', 'verifying-report', 'report-to-verify'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $akses = ['1', '3', '2'];
                            if (TblAkses::find()->where(['icno' => $logicno])->andWhere(['akses_level' => 3])->exists() || TblAkses::find()->where(['icno' => $logicno])->andWhere(['akses_level' => 1])->exists() || Yii::$app->user->getId() == 830714126071) {
                                $check = TblAkses::find()->where(['icno' => $logicno])->andWhere(['in', 'akses_level', $akses]);
                            }

                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    //DO
                    [
                        'actions' => ['kemaskini-kesalahan-anggota', 'senarai-tindakan', 'laporan-tahunan', 'laporan-bulanan', 'senarai-kakitangan'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $akses = ['1', '2', '3', '4', '5', '6'];
                            if (TblAkses::find()->where(['icno' => $logicno])->andWhere(['akses_level' => 2])->exists() || TblAkses::find()->where(['icno' => $logicno])->andWhere(['akses_level' => 1])->exists() || TblAkses::find()->where(['icno' => $logicno])->andWhere(['akses_level' => 3])->exists()) {
                                $check = TblAkses::find()->where(['icno' => $logicno])->andWhere(['in', 'akses_level', $akses]);
                            }

                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    //                            1-admin ,2-penyelia,3-pegawai ,4-penyelia cuti ,5-jadual
                    //penyelia-jadual
                    [
                        'actions' => ['import', 'import-ot', 'import-hakiki', 'do-setup', 'pos-kawalan'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $akses = ['1', '2', '5'];
                            if (TblAkses::find()->where(['icno' => $logicno])->andWhere(['IN', 'akses_level', [5, 2, 1]])->exists()) {
                                $check = TblAkses::find()->where(['icno' => $logicno])->andWhere(['in', 'akses_level', $akses]);
                            }

                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],

                ],
            ],
        ];
    }

    /**
     * Lists all TblRekod models.
     * @return mixed
     */
    public function actionPegMedan()
    {

        //echo date('d-m-Y', $date1);die;
        $ddate = date('Y-m-d');
        $date = new DateTime($ddate);
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');

        //for determining date 1 week before and after 
        $d = strtotime("+7 day");
        $dd = strtotime("-7 day");
        $ddd = strtotime("-6 day");
        $dddd = strtotime("+13 day");
        $lastW = date('d-M-Y', $dd);
        $nextW = date('d-M-Y', $d);
        $lastW1 = date('d-M-Y', $ddd);
        $nextW1 = date('d-M-Y', $dddd);

        $week = $date->format("W");
        $week2 = $date->format("W") - 1;
        $week3 = $date->format("W") + 1;

        $peg1 = $this->pegMedan($week);
        $peg2 = $this->pegMedan($week2);
        $peg3 = $this->pegMedan($week3);
        $peg = Tblprcobiodata::findOne(['ICNO' => $peg1]);
        $lweek = Tblprcobiodata::findOne(['ICNO' => $peg2]);
        $nweek = Tblprcobiodata::findOne(['ICNO' => $peg3]);
        //        var_dump($peg->CONm);die;
        $link = 'keselamatan/clock-in-pm';
        $link2 = 'keselamatan/clock-in-ot';

        $model = new \app\models\keselamatan\TblRekodPegMedan();
        $model->scenario = 'location';
        //        var_dump($model->scenario);die;
        //        var_dump($model);die;

        $wp_id = TblShiftKeselamatan::curr_wp($icno);
        $ot_id = TblOt::curr_ot($icno);
        //var_dump($ot_id);die;
        $model_wp = RefShifts::findOne(['id' => $wp_id]);
        $model_ot = RefShifts::findOne(['id' => $ot_id]);
        //        var_dump($model_ot->jenis_shifts);die;
        $model_rekod = \app\models\keselamatan\TblRekodPegMedan::findOne(['icno' => $icno, 'tarikh' => $today]);
        //        var_dump($model_rekod_ot);die;


        if ($model_rekod) {
            $model_rekod->scenario = 'location';
            //            var_dump($model_rekod->scenario);die;
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
            $link = 'keselamatan/clock-out-pm';
        }


        //ni utk warna kad sblm 4hb
        $month_warna = $month;
        if ($today == "$year-$month-01" || $today == "$year-$month-02" || $today == "$year-$month-03") {
            $month_warna = $month - 1;
        }

        return $this->render('peg-medan', [
            'peg' => $peg,
            'nextW' => $nextW,
            'nextW1' => $nextW1,
            'lastW' => $lastW,
            'lastW1' => $lastW1,
            'lweek' => $lweek,
            'nweek' => $nweek,
            'model' => $model,
            'model_wp' => $model_wp,
            'model_ot' => $model_ot,
            'wp_id' => $wp_id,
            'ot_id' => $ot_id,
            'time_in' => $time_in,
            'time_out' => $time_out,
            'total_hours' => $total_hours,
            'current_ip' => $current_ip,
            'ip_type' => $ip_type,
            'statusAll' => $statusAll,
            //                    'color' => TblWarnaKad::WarnaKadSemasa($icno, $month_warna),
            'pendingNoti' => TblRekod::totalPendingAll($icno),
            'url_zone' => Yii::$app->urlManager->createUrl("keselamatan/zone"),
            'url_tidakpatuh' => Yii::$app->urlManager->createUrl("kehadiran/graf-tidakpatuh"),
            'url_approve' => Yii::$app->urlManager->createUrl("kehadiran/graf-approve"),
            'link' => $link,
            //                    'link2' => $link2,
        ]);
    }

    /**
     * Displays a single TblRekod model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TblRekod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TblRekod();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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

    public function getFormatTimeIn()
    {

        $val = '-';

        if ($this->time_in) {

            $val = $this->changeDatetimeToTime($this->time_in);
        }

        return $val;
    }

    public function getFormatTimeOut()
    {

        $val = '-';

        if ($this->time_out) {

            $val = $this->changeDatetimeToTime($this->time_out);
        }

        return $val;
    }

    public function checkStatusIn($time_now, $wp_time)
    {

        // var_dump($time_now, $wp_time);die;
        $val = null;

        $icno = Yii::$app->user->getId();
        $tarikh = date('Y-m-d');
        $cuti = TblRekod::DisplayCuti($icno, $tarikh);
        // var_dump($cuti);die;
        //check klu waktu cuti/outstation/publicholiday/sabtu ahad x pyh late in
        if ($cuti != '') {
            // echo 'd';die;
            $val = null;
        } else {
            // echo 'de';die;
            //if REST x pyh kesalahan
            if ($wp_time == '00:00:00') {
                $val = null;
                //if biasa
            } elseif ($time_now > $wp_time) {
                $val = 'LATE_IN';
            }
        }

        return $val;
    }

    public function checkStatusInOt($time_now, $wp_time)
    {

        //        var_dump($time_now, $wp_time);die;
        $val = null;

        $icno = Yii::$app->user->getId();
        $tarikh = date('Y-m-d');
        $cuti = TblRekodOt::DisplayCuti($icno, $tarikh);

        //check klu waktu cuti/outstation/publicholiday/sabtu ahad x pyh late in
        if ($cuti != '-') {

            $val = null;
        } else {
            //if REST x pyh kesalahan
            if ($wp_time == '00:00:00') {
                $val = null;
                //if biasa
            } elseif ($time_now > $wp_time) {
                //                echo 'x';die;
                $val = 'LATE_IN';
            }
        }

        return $val;
    }

    public static function checkStatusOut($wp_id ,$time_now, $wp_time)
    {

        $val = null;

        $icno = Yii::$app->user->getId();
        $tarikh = date('Y-m-d');
        $cuti = TblRekod::DisplayCuti($icno, $tarikh);
        //check klu waktu cuti/outstation/publicholiday/sabtu ahad x pyh early out
        if ($cuti != '') {
            $val = null;
        } else {

            //if REST x pyh kesalahan
            if ($wp_time == '00:00:00') {
                $val = null;
                //if biasa
            }
            elseif (($time_now < $wp_time) && $wp_id != 5 ) {
                $val = 'EARLY_OUT';
            }
            elseif ($wp_id == 5 && ($time_now < '01:00:00' )) {
                $val = null;
            }
          
        }

        return $val;
    }

    public function checkStatusOutOt($time_now, $wp_time)
    {

        $val = null;

        $icno = Yii::$app->user->getId();
        $tarikh = date('Y-m-d');
        $cuti = TblRekod::DisplayCuti($icno, $tarikh);

        //check klu waktu cuti/outstation/publicholiday/sabtu ahad x pyh early out
        if ($cuti != '-') {

            $val = null;
        } else {

            //if REST x pyh kesalahan
            if ($wp_time == '00:00:00') {
                $val = null;
                //if biasa
            } elseif ($time_now < $wp_time) {
                $val = 'EARLY_OUT';
            }
        }

        return $val;
    }

    public function checkStatusOutLmt($time_now, $wp_time)
    {

        $val = null;

        $icno = Yii::$app->user->getId();
        $tarikh = date('Y-m-d');
        $cuti = TblRekodLmt::DisplayCuti($icno, $tarikh);

        //check klu waktu cuti/outstation/publicholiday/sabtu ahad x pyh early out
        if ($cuti != '-') {

            $val = null;
        } else {

            //if REST x pyh kesalahan
            if ($wp_time == '00:00:00') {
                $val = null;
                //if biasa
            } elseif ($time_now < $wp_time) {
                $val = 'EARLY_OUT';
            }
        }

        return $val;
    }

    public function checkExternal($ip, $latlng)
    {

        $val = '0';

        $icno = Yii::$app->user->getId();
        $tarikh = date('Y-m-d');
        $cuti = TblRekod::DisplayCuti($icno, $tarikh);

        if ($cuti != '') {
            return '0';
        }

        $checkip = TblRekod::checkIp($ip);
        $checkZone = TblLocation::CheckZone($latlng);
        //        var_dump($checkZone);die;

        if ($checkip === '1') {
            if ($checkZone === false) {
                $val = '1';
            }
        }

        return $val;
    }

    public function checkExternalOt($ip, $latlng)
    {

        //        var_dump($ip,$latlng);die;
        $val = '0';

        $icno = Yii::$app->user->getId();
        $tarikh = date('Y-m-d');
        $cuti = TblRekodOt::DisplayCuti($icno, $tarikh);
        //        var_dump($cuti);die;
        if ($cuti != '-') {
            //            var_dump('o');die;
            return '0';
        }

        $checkip = TblRekodOt::checkIp($ip);
        //        var_dump($checkip);die;
        $checkZone = TblLocation::CheckZone($latlng);
        //        var_dump($checkZone);die;
        if ($checkip === '1') {
            if ($checkZone === false) {
                $val = '1';
            }
        }

        return $val;
    }

    public function actionClockIn()
    {

        $icno = Yii::$app->user->getId();
        $current_ip = $this->getRealUserIp();
        $wp_id = TblShiftKeselamatan::curr_wp($icno);
        $model_wp = RefShifts::findOne(['id' => $wp_id]);

        $model = new TblRekod();
        //utk kes time in, time out, ot in, ot out yang 'required' latlng(location)
        //        $model->scenario = 'location';
        if ($model->load(Yii::$app->request->post())) {

            $today = date('Y-m-d');

            if (TblRekod::checkToday($icno, $today)) {
                return $this->redirect(['keselamatan/index']);
            }

            $time = date('H:i:s');

            $model->icno = $icno;
            $model->tarikh = $today;
            $model->time_in = date('Y-m-d H:i:s');
            $model->day = date('l'); // output: current day.

            $model->status_in = $this->checkStatusIn($time, $model_wp->start_time);

            //            var_dump($model->status_in);die;
            $model->in_lat_lng = Yii::$app->request->post()['TblRekod']['latlng'];
            //            var_dump($model->in_lat_lng);die;
            $model->in_ip = $current_ip;
            $model->external = $this->checkExternal($current_ip, Yii::$app->request->post()['TblRekod']['latlng']);
            $model->wp_id = $wp_id;

            if ($model->save(false)) {

                //if late in
                if ($this->checkStatusIn($time, $model_wp->start_time)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Warning, Late', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['keselamatan/remark', 'id' => $model->id]);
                }

                //if external
                if ($model->external === '1') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Warning, you are out of zone', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['keselamatan/remark', 'id' => $model->id]);
                }
                //
                Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Your time is recorded successfully']);
                return $this->redirect(['keselamatan/index']);
            }
        }
    }

    public function actionClockInLmt()
    {

        $icno = Yii::$app->user->getId();
        $current_ip = $this->getRealUserIp();
        $wp_id = TblLmt::curr_lmt($icno);
        $model_wp = RefLmt::findOne(['id' => $wp_id]);

        $model = new TblRekodLmt();
        //utk kes time in, time out, ot in, ot out yang 'required' latlng(location)
        //        $model->scenario = 'location';
        if ($model->load(Yii::$app->request->post())) {

            $today = date('Y-m-d');

            if (TblRekodLmt::checkToday($icno, $today)) {
                return $this->redirect(['keselamatan/index']);
            }

            $time = date('H:i:s');

            $model->icno = $icno;
            $model->tarikh = $today;
            $model->time_in = date('Y-m-d H:i:s');
            $model->day = date('l'); // output: current day.
            $model->status_in = $this->checkStatusIn($time, $model_wp->start_time);
            //            var_dump($model->status_in);die;
            $model->in_lat_lng = Yii::$app->request->post()['TblRekodLmt']['latlng'];
            //            var_dump($model->in_lat_lng);die;
            $model->in_ip = $current_ip;
            $model->external = $this->checkExternal($current_ip, Yii::$app->request->post()['TblRekodLmt']['latlng']);
            $model->wp_id = $wp_id;

            if ($model->save()) {


                Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Your time is recorded successfully']);
                return $this->redirect(['keselamatan/index2']);
            }
        }
    }

    public function actionClockInOt()
    {

        $icno = Yii::$app->user->getId();
        $current_ip = $this->getRealUserIp();
        $wp_ot_id = TblOt::curr_ot($icno);
        $model_ot = RefShifts::findOne(['id' => $wp_ot_id]);
        $model2 = new TblRekodOt();
        //        var_dump($model);die;
        //utk kes time in, time out, ot in, ot out yang 'required' latlng(location)
        $model2->scenario = 'location';
        if ($model2->load(Yii::$app->request->post())) {
            //var_dump('r');die;
            $today = date('Y-m-d');
            //            var_dump($today);die;

            if (TblRekodOt::checkToday($icno, $today)) {

                return $this->redirect(['keselamatan/index']);
            }

            $time = date('H:i:s');

            $model2->icno = $icno;
            $model2->tarikh = $today;
            //            $model->time_in = date('Y-m-d H:i:s');
            $model2->time_in = date('Y-m-d H:i:s');
            $model2->day = date('l'); // output: current day.
            $model2->status_in = $this->checkStatusInOt($time, $model_ot->start_time);


            $model2->in_lat_lng = Yii::$app->request->post()['TblRekodOt']['latlng'];
            //            var_dump($model2->ot_in_lat_lng);die;
            $model2->in_ip = $current_ip;

            $model2->external = $this->checkExternalOt($current_ip, $model2->in_lat_lng);

            $model2->wp_id = $wp_ot_id;

            if ($model2->save()) {
                //                var_dump($model2);die;
                //                //if late in
                if ($this->checkStatusInOt($time, $model_ot->start_time)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Warning, Late', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['keselamatan/remark-ot', 'id' => $model2->id]);
                }

                //if external
                if ($model2->external === '1') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Warning, you are out of zone', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['keselamatan/remark-ot', 'id' => $model2->id]);
                }

                Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Your time is recorded successfully']);
                return $this->redirect(['keselamatan/index1']);
            }
        }
    }

    public function actionClockInPm()
    {

        $icno = Yii::$app->user->getId();
        $current_ip = $this->getRealUserIp();
        $model2 = new TblRekodPegMedan();

        //utk kes time in, time out, ot in, ot out yang 'required' latlng(location)
        $model2->scenario = 'location';
        if ($model2->load(Yii::$app->request->post())) {
            //var_dump('r');die;
            $today = date('Y-m-d');
            //            var_dump($today);die;

            if (TblRekodPegMedan::checkToday($icno, $today)) {

                return $this->redirect(['keselamatan/peg-medan']);
            }

            $time = date('H:i:s');

            $model2->icno = $icno;
            $model2->tarikh = $today;
            $model2->time_in = date('Y-m-d H:i:s');
            $model2->day = date('l'); // output: current day.

            $model2->in_lat_lng = Yii::$app->request->post()['TblRekodPegMedan']['latlng'];
            //                 
            $model2->in_ip = $current_ip;
            //          
            $model2->external = $this->checkExternal($current_ip, $model2->in_lat_lng);
            $ddate = date('Y-m-d');
            $date = new DateTime($ddate);
            $week = $date->format("W");
            $model2->wp_id = $week;
            //           
            if ($model2->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Your time is recorded successfully']);
                return $this->redirect(['keselamatan/peg-medan']);
            }
        }
    }

    public function actionClockOut()
    {

        $icno = Yii::$app->user->getId();
        $current_ip = $this->getRealUserIp();
        $wp_id = TblShiftKeselamatan::curr_wp($icno);
        $today = date('Y-m-d');
        $time = date('H:i:s');

        $model1 = TblRekod::findOne(['icno' => $icno, 'tarikh' => $today]);
        if ($model1 == NULL) {
            $model = TblRekod::find()->where(['icno' => $icno])->andWhere(['tarikh' => date('Y-m-d', strtotime($today . ' -1 day'))])->andWhere(['time_out' => NULL])->one();
        } else {
            $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $today]);
        }
        // var_dump($wp_id);die;

        $model->scenario = 'location';

        //utk kes time in, time out, ot in, ot out yang 'required' latlng(location)
        //        var_dump($model->scenario);die;
        if ($model->load(Yii::$app->request->post())) {

            if ($wp_id == 40) {
                $model->status_out = RefWp::checkStatusOut($icno, $today, date('H:i:s'), $wp_id);
            } else {
                $model_wp = RefShifts::findOne(['id' => $wp_id]);
                if ($model1 == NULL) {
                    $model->status_out = NULL;
                } else {
                    $model->status_out = $this->checkStatusOut($wp_id,$time, $model_wp->end_time);
                }
            }

            $model->time_out = date('Y-m-d H:i:s');
            $model->external = $model->external === '1' ? '1' : $this->checkExternal($current_ip, Yii::$app->request->post()['TblRekod']['latlng']);

            $model->out_lat_lng = $model->latlng;
            $model->out_ip = $current_ip;


            if ($model->save(false)) {
                //if early out
                if ($this->checkStatusOut($wp_id,$time, $model_wp->end_time)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Attention, Early out', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['keselamatan/remark', 'id' => $model->id]);
                }
                //
                //                //if external
                if ($this->checkExternal($current_ip, Yii::$app->request->post()['TblRekod']['latlng']) === '1') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Warning, you are out of zone', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['keselamatan/remark', 'id' => $model->id]);
                }
                //

                Yii::$app->session->setFlash('alert', ['title' => 'Clock Out', 'type' => 'success', 'msg' => 'Your time is recorded successfully']);
                return $this->redirect(['keselamatan/index']);
            }
        }
    }

    public function actionClockOutLmt()
    {

        $icno = Yii::$app->user->getId();
        $current_ip = $this->getRealUserIp();
        $wp_id = TblLmt::curr_lmt($icno);
        $model_wp = RefLmt::findOne(['id' => $wp_id]);
        //        var_dump($model_wp);die;
        $today = date('Y-m-d');
        $time = date('H:i:s');

        $model1 = TblRekodLmt::findOne(['icno' => $icno, 'tarikh' => $today]);
        if ($model1 == NULL) {
            $model = TblRekodLmt::find()->where(['icno' => $icno])->andWhere(['tarikh' => date('Y-m-d', strtotime($today . ' -1 day'))])->andWhere(['time_out' => NULL])->one();
        } else {
            $model = TblRekodLmt::findOne(['icno' => $icno, 'tarikh' => $today]);
        }
        //        var_dump($model);die;
        $model->scenario = 'location';

        //utk kes time in, time out, ot in, ot out yang 'required' latlng(location)
        //        var_dump($model->scenario);die;
        if ($model->load(Yii::$app->request->post())) {

            //            VarDumper::dump($model,10,true);
            //            exit();

            $model->time_out = date('Y-m-d H:i:s');
            $model->external = $model->external === '1' ? '1' : $this->checkExternal($current_ip, Yii::$app->request->post()['TblRekodLmt']['latlng']);
            $model->status_out = $this->checkStatusOutLmt($time, $model_wp->end_time);

            $model->out_lat_lng = $model->latlng;
            $model->out_ip = $current_ip;


            if ($model->save()) {
                //var_dump('r');die;
                //if early out
                if ($this->checkStatusOut($time, $model_wp->end_time)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Attention, Early out', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['keselamatan/remark', 'id' => $model->id]);
                }

                //if external
                if ($this->checkExternal($current_ip, Yii::$app->request->post()['TblRekodLmt']['latlng']) === '1') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Warning, you are out of zone', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['keselamatan/remark', 'id' => $model->id]);
                }


                Yii::$app->session->setFlash('alert', ['title' => 'Clock Out', 'type' => 'success', 'msg' => 'Your time is recorded successfully']);
                return $this->redirect(['keselamatan/index2']);
            }
        }
    }

    public function actionClockOutPm()
    {

        $icno = Yii::$app->user->getId();
        $current_ip = $this->getRealUserIp();
        $wp_id = TblShiftKeselamatan::curr_wp($icno);
        $model_wp = RefShifts::findOne(['id' => $wp_id]);
        $today = date('Y-m-d');
        $time = date('H:i:s');

        $model = TblRekodPegMedan::findOne(['icno' => $icno, 'tarikh' => $today]);
        $model->scenario = 'location';

        //utk kes time in, time out, ot in, ot out yang 'required' latlng(location)
        if ($model->load(Yii::$app->request->post())) {

            $model->time_out = date('Y-m-d H:i:s');
            $model->external = $model->external === '1' ? '1' : $this->checkExternal($current_ip, Yii::$app->request->post()['TblRekodPegMedan']['latlng']);
            //            $model->status_out = $this->checkStatusOut($time, $model_wp->end_time);

            $model->out_lat_lng = $model->latlng;
            $model->out_ip = $current_ip;


            if ($model->save()) {


                Yii::$app->session->setFlash('alert', ['title' => 'Clock Out', 'type' => 'success', 'msg' => 'Your time is recorded successfully']);
                return $this->redirect(['keselamatan/peg-medan']);
            }
        }
    }

    public function actionClockOutOt()
    {

        $icno = Yii::$app->user->getId();
        $current_ip = $this->getRealUserIp();
        $wp_id = TblOt::curr_ot($icno);
        $model_wp = RefShifts::findOne(['id' => $wp_id]);
        $today = date('Y-m-d');
        $time = date('H:i:s');
        $model1 = TblRekodOt::findOne(['icno' => $icno, 'tarikh' => $today]);

        if ($model1 == NULL) {
            $model2 = TblRekodOt::find()->where(['icno' => $icno])->andWhere(['tarikh' => date('Y-m-d', strtotime($today . ' -1 day'))])->andWhere(['time_out' => NULL])->one();
        } else {
            $model2 = TblRekodOt::findOne(['icno' => $icno, 'tarikh' => $today]);
        }

        $model2->scenario = 'location';

        //utk kes time in, time out, ot in, ot out yang 'required' latlng(location)
        //        var_dump($model->scenario);die;
        if ($model2->load(Yii::$app->request->post())) {

            $model2->status_out = $this->checkStatusOutOt($time, $model_wp->end_time);

            $model2->time_out = date('Y-m-d H:i:s');
            $model2->external = $model2->external === '1' ? '1' : $this->checkExternal($current_ip, Yii::$app->request->post()['TblRekodOt']['latlng']);

            $model2->out_lat_lng = $model2->latlng;
            $model2->out_ip = $current_ip;


            if ($model2->save()) {
                //var_dump('r');die;
                //if early out
                // if ($this->checkStatusOut($time, $model_wp->end_time)) {
                //     Yii::$app->session->setFlash('alert', ['title' => 'Attention, Early out', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                //     return $this->redirect(['keselamatan/remark-ot', 'id' => $model2->id]);
                // }

                //if external
                //                if ($this->checkExternal($current_ip, Yii::$app->request->post()['TblRekod']['latlng']) === '1') {
                //                    Yii::$app->session->setFlash('alert', ['title' => 'Warning, you are out of zone', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                //                    return $this->redirect(['keselamatan/remark-ot', 'id' => $model2->id]);
                //                }


                Yii::$app->session->setFlash('alert', ['title' => 'Clock Out', 'type' => 'success', 'msg' => 'Your time is recorded successfully']);
                return $this->redirect(['keselamatan/index1']);
            }
        }
    }

    public function masaMasuk($id, $time_in)
    {
        //syif b

        if ($id == 5 && $time_in <= "04:00 PM") {
            $time = "04:00 PM";
            //syif a
        } elseif ($id == 3 && $time_in <= "12:00 AM") {

            $time = "12:00 AM";
            //syif c
        } elseif ($id == 4 && $time_in <= "08:00 AM") {
            $time = "08:00 AM";
        } else {
            $time = $time_in;
        }

        return $time;
        //        die;
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

    public function actionClockInMain()
    {

        $icno = Yii::$app->user->getId();
        $current_ip = $this->getRealUserIp();
        $wp_id = 40;
        // $model_wp = RefWp::findOne(['id' => $wp_id]);

        $model = new TblRekod();
        //utk kes time in, time out, ot in, ot out yang 'required' latlng(location)
        $model->scenario = 'location';

        if ($model->load(Yii::$app->request->post())) {

            $today = date('Y-m-d');

            if (TblRekod::checkToday($icno, $today)) {
                return $this->redirect(['keselamatan/main']);
            }

            $time = date('H:i:s');

            $checkStatusIn = RefShifts::checkStatusIn($icno, $today, $time, $wp_id);
            // var_dump($checkStatusIn);die;
            if ($checkStatusIn == 1) {
                $checkStatusIn = 'LATE_IN';
            } else {
                $checkStatusIn = NULL;
            }
            // var_dump($checkStatusIn);die;

            $model->icno = $icno;
            $model->tarikh = $today;
            $model->time_in = date('Y-m-d H:i:s');
            $model->day = date('l'); // output: current day.
            $model->status_in = $checkStatusIn;
            $model->in_lat_lng = Yii::$app->request->post()['TblRekod']['latlng'];
            $model->in_ip = $current_ip;
            $model->external = $this->checkExternal($current_ip, Yii::$app->request->post()['TblRekod']['latlng']);
            $model->wp_id = $wp_id;

            if ($model->save()) {

                //if late in
                // if ($checkStatusIn) {
                //     Yii::$app->session->setFlash('alert', ['title' => 'Warning, Late', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                //     return $this->redirect(['keselamatan/remark', 'id' => $model->id]);
                // }

                // //if external
                // if ($model->external === '1') {
                //     Yii::$app->session->setFlash('alert', ['title' => 'Warning, you are out of zone', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                //     return $this->redirect(['kehadiran/remark', 'id' => $model->id]);
                // }

                Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Your time is recorded successfully']);
                return $this->redirect(['keselamatan/main']);
            }
        }
    }

    public function actionClockOutMain()
    {

        $icno = Yii::$app->user->getId();
        $current_ip = $this->getRealUserIp();
        $wp_id = 40;
        $model_wp = RefWp::findOne(['id' => $wp_id]);
        $today = date('Y-m-d');
        $time = date('H:i:s');

        $model = TblRekod::current($icno, $today, $wp_id);

        //utk kes time in, time out, ot in, ot out yang 'required' latlng(location)
        $model->scenario = 'location';
        if ($model->load(Yii::$app->request->post())) {

            $checkStatusOut = RefShifts::checkStatusOut($icno, $today, date('H:i:s'), $wp_id);
            if ($checkStatusOut == 1) {
                $checkStatusOut = 'EARLY_OUT';
            } else {
                $checkStatusOut = NULL;
            }
            $model->time_out = date('Y-m-d H:i:s');
            $model->total_hours = RefWp::totalHours($model->time_in, $model->time_out, $model_wp->in_start_time);
            $model->external = $model->external === 1 ? 1 : $this->checkExternal($current_ip, Yii::$app->request->post()['TblRekod']['latlng']);
            $model->status_out = $checkStatusOut;

            $model->out_lat_lng = $model->latlng;
            $model->out_ip = $current_ip;

            if ($model->save()) {

                //if early out
                if ($checkStatusOut) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Attention, Early out', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['keselamatan/remark', 'id' => $model->id]);
                }

                //if external
                if ($this->checkExternal($current_ip, Yii::$app->request->post()['TblRekod']['latlng']) === 1) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Warning, you are out of zone', 'type' => 'warning', 'msg' => 'Non-compliance is detected, Please ensure reason is filled. Thank you']);
                    return $this->redirect(['keselamatan/remark', 'id' => $model->id]);
                }

                Yii::$app->session->setFlash('alert', ['title' => 'Clock Out', 'type' => 'success', 'msg' => 'Your time is recorded successfully']);
                return $this->redirect(['keselamatan/index']);
            }
        }
    }
    public function actionIndex()
    {

        $icno = Yii::$app->user->getId();
        $vaksin = Tblvaksinasi::isRegistered($icno);
        // var_dump($vaksin);die;
        if (empty($vaksin)) {
            return $this->redirect(['vaksinasi/update', 'from' => '2']);
        }
        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');

        $time = date('h:i A');
        $hour_complete = 0;
        $curr_total_hours = '';

        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));


        $check = TblRekod::find()->where(['icno' => $icno])
            ->andWhere(['tarikh' => $date_before])
            ->andWhere(['time_out' => NULL])
            ->exists();
        $check2 = TblRekod::find()->where(['icno' => $icno])
            ->andWhere(['tarikh' => $date_before])
            ->andWhere(['time_in' => NULL])
            ->exists();


        $statuswfh = TblWfh::getStatusWfh($icno, $today);
        $wfh = $statuswfh ? '<span class="label label-warning" style="font-size:14px">WFH</span>' : null;
        if (!$statuswfh) {
            $checkHealth = \app\models\kehadiran\TblSelfhealth::checktoday();
            if (!$checkHealth) {
                return $this->redirect(['selfhealth/index?user=skb']);
            }
        }

        $link = 'keselamatan/clock-in';

        $model = new TblRekod();
        $model->scenario = 'location';

        $hours = date('H:i:s');
        $hour = (int) date('G');
        // var_dump($hour);die;

        if ($check && !$check2 && ($hour >= 0 && $hour < 1)) {

            $wp_id = TblShiftKeselamatan::last_wp($icno);
            // var_dump($wp_id);die;
            $model_rekod = TblRekod::find()->where(['icno' => $icno])->andWhere(['tarikh' => $date_before])->andWhere(['time_out' => NULL])->one();
        } else {
            $wp_id = TblShiftKeselamatan::curr_wp($icno);
            $model_rekod = TblRekod::findOne(['icno' => $icno, 'tarikh' => $today]);
        }

        $model_wp = RefShifts::findOne(['id' => $wp_id]);

        $var = TblRekod::find()->where(['icno' => $icno])->andWhere(['tarikh' => date('Y-m-d')])->one();
        if ($model_wp != NULL && $var == NULL && $model_wp == '3' && $model_wp == '4' && $model_wp == '5') {
            //lebih 4 jam tapi ada bug

            $timediff = 0;
        } else {
            $timediff = 0;
        }

        if ($model_rekod) {
            $model_rekod->scenario = 'location';
        }

        $current_ip = $this->getRealUserIp();
        $ip_type = TblRekod::checkIp($current_ip);

        $time_in = $model_rekod ? $model_rekod->getFormatTimeIn() : '-';
        $time_out = isset($model_rekod->time_out) ? $model_rekod->getFormatTimeOut() : '-';
        $time = $this->masaMasuk($wp_id, $time_in);
        $total_hours = isset($model_rekod->time_out) ? TblRekod::totalHour($time, $time_out) : '-';
        $statusAll = $model_rekod ? $model->getStatusAll() : '-';
        if ($model_rekod) {
            // echo 'dd';die;
            $model = $model_rekod;
            $statusAll = $model->getStatusAll();
            $link = 'keselamatan/clock-out';
            $time_now = date('h:i A');
            $time_nows = date('h:i:s');
            $curr_total_hours = RefShifts::totalHours($time, $time_now, $model_wp->start_time);

            //  var_dump($time, $time_now, $model_wp->start_time);die;    
            if ($time_nows < $model_wp->start_time) {
                $curr_total_hours = 0;
                $total_hours = "0:0";
            }
            //    
            $hour_complete = round(($curr_total_hours / 8) * 100, 2);
            // var_dump($hour_complete);die;

            if ($hour_complete > 100) {
                $hour_complete = 100;
            }
        }
        //ni utk warna kad sblm 4hb
        $month_warna = $month;
        if ($today == "$year-$month-01" || $today == "$year-$month-02" || $today == "$year-$month-03") {
            $month_warna = $month - 1;
        }

        return $this->render('index', [
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
            'url_zone' => Yii::$app->urlManager->createUrl("keselamatan/zone"),
            'url_zone2' => Yii::$app->urlManager->createUrl("keselamatan/zone"),
            'url_tidakpatuh' => Yii::$app->urlManager->createUrl("kehadiran/graf-tidakpatuh"),
            'url_approve' => Yii::$app->urlManager->createUrl("kehadiran/graf-approve"),
            'link' => $link,
            'timediff' => $timediff,
            'curr_total_hours' => $curr_total_hours,
            'hour_complete' => $hour_complete,
            'wfh' => $wfh,
        ]);
    }

    public function actionIndex2()
    {

        $icno = Yii::$app->user->getId();
        $time = date('h:i A');
        $hour_complete = 0;
        $curr_total_hours = '';
        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));


        $check = TblRekodLmt::find()->where(['icno' => $icno])
            ->andWhere(['tarikh' => $date_before])
            // ->andWhere([
            //     'or',
            //     ['!=', 'absent', 1],
            //     ['!=', 'incomplete', 1]
            //     ])
            ->andWhere(['time_out' => NULL])
            ->exists();
        $check2 = TblRekodLmt::find()->where(['icno' => $icno])
            ->andWhere(['tarikh' => $date_before])
            // ->andWhere([
            //     'or',
            //     ['!=', 'absent', 1],
            //     ['!=', 'incomplete', 1]
            //     ])
            ->andWhere(['time_in' => NULL])
            ->exists();

        // ->andWhere(['!=', 'time_in', NULL])->exists();
        //   var_dump($check);die;
        $link = 'keselamatan/clock-in-lmt';

        $model = new TblRekodLmt();
        $model->scenario = 'location';

        $hours = date('H:i:s');
        $hour = (int) date('G');

        if ($check && !$check && ($hour >= 0 && $hour < 1)) {
            $lmt_id = TblLmt::last_lmt($icno);
            $model_rekod = TblRekodLmt::find()->where(['icno' => $icno])->andWhere(['tarikh' => $date_before])->andWhere(['time_out' => NULL])->one();
        } else {
            $lmt_id = TblLmt::curr_lmt($icno);
            $model_rekod = TblRekodLmt::findOne(['icno' => $icno, 'tarikh' => $today]);
        }

        $model_lmt = RefLmt::findOne(['id' => $lmt_id]);

        if ($model_rekod) {
            $model_rekod->scenario = 'location';
            //            var_dump($model_rekod->scenario);die;
        }
        $current_ip = $this->getRealUserIp();
        $ip_type = TblRekod::checkIp($current_ip);

        $time_in = $model_rekod ? $model_rekod->getFormatTimeIn() : '-';
        $time_out = isset($model_rekod->time_out) ? $model_rekod->getFormatTimeOut() : '-';
        $total_hours = isset($model_rekod->time_out) ? TblRekodLmt::totalHour($time_in, $time_out) : '-';
        $statusAll = $model_rekod ? $model->getStatusAll() : '-';

        if ($model_rekod) {
            $model = $model_rekod;
            $statusAll = $model->getStatusAll();
            $link = 'keselamatan/clock-out-lmt';
        }

        //ni utk warna kad sblm 4hb
        $month_warna = $month;
        if ($today == "$year-$month-01" || $today == "$year-$month-02" || $today == "$year-$month-03") {
            $month_warna = $month - 1;
        }

        return $this->render('index2', [
            'model' => $model,
            //                    'model2' => $model2,
            //                    'model_wp' => $model_wp,
            'model_lmt' => $model_lmt,
            //                    'wp_id' => $wp_id,
            //                    'ot_id' => $ot_id,
            'lmt_id' => $lmt_id,
            'time_in' => $time_in,
            'time_out' => $time_out,
            'total_hours' => $total_hours,
            'current_ip' => $current_ip,
            'ip_type' => $ip_type,
            'statusAll' => $statusAll,
            'color' => TblWarnaKad::WarnaKadSemasa($icno, $month_warna, NULL, $year),
            'pendingNoti' => TblRekod::totalPendingAll($icno),
            'url_zone' => Yii::$app->urlManager->createUrl("keselamatan/zone"),
            'url_tidakpatuh' => Yii::$app->urlManager->createUrl("kehadiran/graf-tidakpatuh"),
            'url_approve' => Yii::$app->urlManager->createUrl("kehadiran/graf-approve"),
            'link' => $link,
        ]);
    }

    public function actionIndex1()
    {

        $icno = Yii::$app->user->getId();
        $time = date('h:i A');
        $hour_complete = 0;
        $curr_total_hours = '';
        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));


        $check = TblRekodOt::find()->where(['icno' => $icno])
            ->andWhere(['tarikh' => $date_before])
            ->andWhere(['time_out' => NULL])
            ->exists();

        $check2 = TblRekodOt::find()->where(['icno' => $icno])
            ->andWhere(['tarikh' => $date_before])
            // ->andWhere([
            //     'or',
            //     ['!=', 'absent', 1],
            //     ['!=', 'incomplete', 1]
            //     ])
            ->andWhere(['time_in' => NULL])
            ->exists();
        $link = 'keselamatan/clock-in';
        $link2 = 'keselamatan/clock-in-ot';

        $model = new TblRekod();
        $model2 = new TblRekodOt();
        $model->scenario = 'location';
        $model2->scenario = 'location';

        //    var_dump($time);die;


        $hours = date('H:i:s');
        $hour = (int) date('G');

        if ($check && !$check && ($hour >= 0 && $hour < 1)) {
            $ot_id = TblOt::lastot($icno);
            // var_dump($ot_id);die;
            $model_rekod_ot = TblRekodOt::find()->where(['icno' => $icno])->andWhere(['tarikh' => $date_before])->andWhere(['time_out' => NULL])->one();
        } else {
            $ot_id = TblOt::curr_ot($icno);
            $model_rekod_ot = TblRekodOt::findOne(['icno' => $icno, 'tarikh' => $today]);
        }

        // var
        $model_ot = RefShifts::findOne(['id' => $ot_id]);
        // var_dump($ot_id);die;

        if ($model_rekod_ot) {
            $model_rekod_ot->scenario = 'location';
        }


        $current_ip = $this->getRealUserIp();
        $ip_type = TblRekod::checkIp($current_ip);

        $time_in_ot = $model_rekod_ot ? $model_rekod_ot->getFormatOtIn() : '-';
        $time_out_ot = isset($model_rekod_ot->time_out) ? $model_rekod_ot->getFormatOtOut() : '-';
        $time = $this->masaMasuk($ot_id, $time_in_ot);
        // var_dump($time);die;
        //        $total_hours = isset($model_rekod->time_out) ? TblRekod::totalHour($time, $time_out) : '-';
        $total_hours_ot = isset($model_rekod_ot->time_out) ? TblRekodOt::totalHour($time_in_ot, $time_out_ot) : '-';
        $statusAllOt = $model_rekod_ot ? $model2->getStatusAllOt() : '-';

        if ($model_rekod_ot) {
            $model2 = $model_rekod_ot;
            $statusAllOt = $model2->getStatusAllOt();
            $link2 = 'keselamatan/clock-out-ot';

            $time_now = date('h:i A');
            $curr_total_hours = RefShifts::totalHours($time, $time_now, $model_ot->start_time);

            if ($time_now < $model_ot->start_time) {
                $curr_total_hours = 0;
                $total_hours_ot = "0:0";
            }
            //                                  var_dump($curr_total_hours);die;
            //    
            $hour_complete = round(($curr_total_hours / 8) * 100, 2);

            if ($hour_complete > 100) {
                $hour_complete = 100;
            }
        }

        //ni utk warna kad sblm 4hb
        $month_warna = $month;
        if ($today == "$year-$month-01" || $today == "$year-$month-02" || $today == "$year-$month-03") {
            $month_warna = $month - 1;
        }

        return $this->render('index1', [
            'model' => $model,
            'model2' => $model2,
            // 'model_wp' => $model_wp,
            'model_ot' => $model_ot,
            // 'wp_id' => $wp_id,
            'ot_id' => $ot_id,
            //                    'time_in' => $time_in,
            //                    'time_out' => $time_out,
            'time_in_ot' => $time_in_ot,
            'time_out_ot' => $time_out_ot,
            //    'total_hours' => $total_hours,
            'total_hours_ot' => $total_hours_ot,
            'current_ip' => $current_ip,
            'ip_type' => $ip_type,
            //                    'statusAll' => $statusAll,
            'statusAllOt' => $statusAllOt,
            'color' => TblWarnaKad::WarnaKadSemasa($icno, $month_warna, NULL, $year),
            'pendingNoti' => TblRekod::totalPendingAll($icno),
            'url_zone' => Yii::$app->urlManager->createUrl("keselamatan/zone"),
            'url_zone2' => Yii::$app->urlManager->createUrl("keselamatan/zone"),
            'url_tidakpatuh' => Yii::$app->urlManager->createUrl("kehadiran/graf-tidakpatuh"),
            'url_approve' => Yii::$app->urlManager->createUrl("kehadiran/graf-approve"),
            'link' => $link,
            'link2' => $link2,
            'curr_total_hours' => $curr_total_hours,
            'hour_complete' => $hour_complete,
        ]);
    }

    public function actionZone()
    {

        $latlng = Yii::$app->request->post()['latlng'];
        //        $ip = $_SERVER['REMOTE_ADDR'];
        $ip = $this->getRealUserIp();

        if (Yii::$app->request->post()) {
            //if ip = external
            if (TblRekod::checkIp($ip) === '1') {
                if (!$latlng) {
                    echo '<p style="color:red;">Unable to detect user location, Please reload web browser!</p>';
                    //                    exit();
                }
                //check location pula
                if (TblLocation::CheckZone($latlng)) {
                    $v = '<span class="label label-success" style="font-size:14px">Internal</span><a class="btn-sm btn-default" onclick="window.location.href = window.location.href"><i class="fa fa-refresh"></i></a>';
                } else {
                    $v = '<span class="label label-danger" style="font-size:14px">Externals</span><a class="btn-sm btn-default" onclick="window.location.href = window.location.href"><i class="fa fa-refresh"></i></a>';
                }
            } else {
                $v = '<span class="label label-success" style="font-size:14px">Internal</span><a class="btn-sm btn-default" onclick="window.location.href = window.location.href"><i class="fa fa-refresh"></i></a>';
            }
        }

        echo $v;
    }

    //adding staff into specific unit,pos, assigning kp and pkp
    public function actionStaffShiftList($month = null, $year = null, $pos = null, $units = null)
    {
        $id = Yii::$app->user->getId(); //getting user id

        if (!$month) {
            $month = date('m');
        }

        if (!$year) {
            $year = date('Y');
        }
        if (!$units) {
            //            var_dump('d');die;
            $units = 1;
        }
        if (!$pos) {
            $pos = 1;
        }

        $staff = TblStaffKeselamatan::find()->all();
        $array_staff = [];
        foreach ($staff as $r) {
            $array_staff[] = $r->staff_icno;
        }
        $id = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::find()
            ->where(['status' => 1])
            ->andWhere(['not in', 'ICNO', $array_staff])
            ->andWhere(['DeptId' => 2])
            ->all();
        $ketuapos = Tblprcobiodata::find()
            ->where(['status' => 1])
            ->andWhere(['DeptId' => 2])
            ->all();

        $model = new TblStaffKeselamatan();
        //            var_dump($year);die;
        if ($model->load(Yii::$app->request->post())) {

            //            $model->month =
            $model->year = date('y');
            $model->added_by = $id;
            $model->isActive = 1;
            $model->created_at = date('Y-m-d H:i:s');
            //            $model->sup_icno = $id;
            //            $model->created_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Added', 'type' => 'success', 'msg' => 'New staff Added!']);
                return $this->redirect(['keselamatan/staff-shift-list']);
            }
        }
        //$tblname = TblStaffKeselamatan
        $curr_m = date('m');
        //        $staf = TblStaffKeselamatan::find()->where(['month' => $curr_m]);
        //                $staff = Tblstaff::find()->joinWith(['staff'])->where(['sup_icno' => $id]);
        //        var_dump($staff1);die;
        //        $dataProvider = new ActiveDataProvider([
        //            'query' => $staf,
        //            'pagination' => [
        //                'pageSize' => 100,
        //            ],
        //        ]);
        $searchModel = new \app\models\keselamatan\TblStaffKeselamatanSearch();
        //        $query = TblStaffKeselamatan::find()->where(['isActive'=>1]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider = new ActiveDataProvider([
        //     'query' => $query ,
        //     'sort'=> ['defaultOrder' => ['unit_id'=>SORT_ASC]]
        // ]);
        return $this->render('staff-shift-list', [
            'model' => $model,
            'biodata' => $biodata,
            'ketuapos' => $ketuapos,
            'dataProvider' => $dataProvider,
            'month' => $month,
            'year' => $year,
            'searchModel' => $searchModel,
            'units' => $units,
            'pos' => $pos
        ]);
    }

    public function actionStaffList($anggota = null, $month = null, $year = null, $pos = null, $units = null)
    {
        $id = Yii::$app->user->getId(); //getting user id
        $next = date('m', strtotime('next month'));
        //        var_dump($next);die;
        $validate = TblStaffKeselamatan::find()->where(['month' => $next])->all();
        //        var_dump($validate);
        //        die;
        if (!$month) {
            $month = date('m');
        }

        if (!$year) {
            $year = date('Y');
        }
        if (!$units) {
            //            var_dump('d');die;
            $units = 1;
        }
        if (!$pos) {
            $pos = 1;
        }

        //$tblname = TblStaffKeselamatan
        $curr_m = date('m');

        $searchModel = new \app\models\keselamatan\TblStaffKeselamatanSearch();
        //        var_dump($searchModel);die;
        if ($searchModel !== NULL) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else {
            $staf = TblStaffKeselamatan::find()->where(['month' => $curr_m]);
            //                $staff = Tblstaff::find()->joinWith(['staff'])->where(['sup_icno' => $id]);
            $dataProvider = new ActiveDataProvider([
                'query' => $staf,
                'pagination' => [
                    'pageSize' => 100,
                ],
            ]);
        }

        return $this->render('staff-list', [
            'dataProvider' => $dataProvider,
            'month' => $month,
            'year' => $year,
            'searchModel' => $searchModel,
            'units' => $units,
            'pos' => $pos,
            'anggota' => $anggota,
            'month' => $month,
            'validate' => $validate
        ]);
    }

    public function actionDutyOfficer()
    {

        $roll = \app\models\keselamatan\RefRollcall::find()->where(['kategori' => 1])->all();

        $searchModel = new \app\models\keselamatan\RefPosKawalanSearch();
        $query = RefPosKawalan::find()->where(['active' => 1]);

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        return $this->render('duty-officer', [
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'roll' => $roll
        ]);
    }

    public function actionRollcall()
    {
        $icno = Yii::$app->user->getId();

        $date = date('m');
        $roll = \app\models\keselamatan\RefRollcall::find()->where(['kategori' => 1])->all();

        $searchModel = new \app\models\keselamatan\RefPosKawalanSearch();
        $query = RefShifts::find()->where(['in', 'id', ['3', '4', '5']]);
        //        var_dump($query);die;

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        return $this->render('rollcall', [
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'roll' => $roll
        ]);
    }

    public function actionAnggotaSeliaan($id)
    {
        //        var_dump($id);die;
        $condition = TblOt::find()->where(['pos_kawalan_id' => $id])->andWhere(['tarikh' => date('Y-m-d')])->andWhere(['!=', 'shift_id', 1])->exists();
        //        var_dump($condition);die;
        $pos = RefPosKawalan::find()->where(['id' => $id])->one();
        $icno = Yii::$app->user->getId();
        $date = date('Y-m-d');
        $cuti = CutiRekod::find()->where(['cuti_mula' => $date])->andWhere(['cuti_icno' => $icno])->one();
        //        var_dump($cuti);die;
        $searchModel = new \app\models\keselamatan\TblStaffKeselamatanSearch();
        $shift = TblShiftKeselamatan::find()->where(['tarikh' => date('Y-m-d')])->all();
        $ot = TblOt::find()->where(['tarikh' => date('Y-m-d')])->andWhere(['!=', 'shift_id', '1'])->all();
        $join = array_merge($shift, $ot);
        //        var_dump($join);die;
        $models = TblStaffKeselamatan::find()->All();

        if (Yii::$app->request->post('simpan')) {
            foreach ($models as $data) {
                $m = date('m');
                $syif = TblShiftKeselamatan::find()->where(['icno' => $data->staff_icno])->andWhere(['tarikh' => date('Y-m-d')])->one();
                $syif1 = RefShifts::find()->where(['id' => $syif->shift_id])->one();
                var_dump(Yii::$app->request->post('do'));
                die;

                if ('yy' . $data->staff_icno == Yii::$app->request->post($data->staff_icno)) {

                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->staff_icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'H'])->exists();
                    if (!$exist) {

                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->staff_icno;
                        $model->month = "$m";
                        $model->type = "H";
                        $model->catatan = Yii::$app->request->post('g');
                        $model->catatan_do = Yii::$app->request->post('do');
                        $model->THBH = '0';
                        $model->date = date('Y-m-d');
                        $model->year = date('Y');
                        $model->time = date('h:i:s A');
                        $model->pos_kawalan_id = "$syif->pos_kawalan_id";
                        $model->do_icno = $icno;
                        $model->status = 'SIMPAN';
                        $model->syif = "$syif1->jenis_shifts";
                        $model->save();
                    }
                }
                if ('y' . $data->staff_icno == Yii::$app->request->post($data->staff_icno)) {

                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->staff_icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'H'])->exists();
                    if (!$exist) {
                        // THB = 1 -> Hadir Baris 
                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->staff_icno;
                        $model->month = "$m";
                        $model->type = "H";
                        $model->catatan = Yii::$app->request->post('g');
                        $model->catatan_do = Yii::$app->request->post('do');
                        $model->THBH = '1';
                        $model->date = date('Y-m-d');
                        $model->year = date('Y');
                        $model->time = date('h:i:s A');
                        $model->pos_kawalan_id = "$syif->pos_kawalan_id";
                        $model->do_icno = $icno;
                        $model->status = 'SIMPAN';
                        $model->syif = "$syif1->jenis_shifts";
                        $model->save();
                    }
                }
                if ('lmj' . $data->staff_icno == Yii::$app->request->post($data->staff_icno)) {


                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->staff_icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMJ'])->exists();
                    if (!$exist) {
                        // THB = 1 -> Hadir Baris 
                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->staff_icno;
                        $model->month = "$m";
                        $model->type = "LMJ";
                        $model->catatan = Yii::$app->request->post('g');
                        $model->catatan_do = Yii::$app->request->post('do');
                        $model->THBLMJ = '0';
                        $model->date = date('Y-m-d');
                        $model->year = date('Y');
                        $model->time = date('h:i:s A');
                        $model->pos_kawalan_id = "$syif->pos_kawalan_id";
                        $model->do_icno = $icno;
                        $model->status = 'SIMPAN';
                        $model->syif = "$syif1->jenis_shifts";
                        $model->save();
                    }
                }
            }
        }
        $query = TblStaffKeselamatan::find()->where(['pos_kawalan_id' => $id])->andWhere(['month' => date('m')]);
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('anggota-seliaan', [
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'pos' => $pos,
            'cuti' => $cuti, 'condition' => $condition
        ]);
    }

    public function actionAnggota($id)
    {
        $pos = RefPosKawalan::find()->where(['id' => $id])->one();
        $icno = Yii::$app->user->getId();
        $date = date('m');
        $searchModel = new \app\models\keselamatan\TblStaffKeselamatanSearch();
        //        $pen = ['10', '11', '12', '13', '14'];$models = TblPermohonan::find()->All();
        $models = TblStaffKeselamatan::find()->All();

        $selection = (array) Yii::$app->request->post('selection'); //typecasting
        //        var_dump($selection);die;

        if (Yii::$app->request->post('simpan')) {
            //                                var_dump(Yii::$app->request->post('h'));die;
            //            var_dump('$models');die;
            foreach ($models as $data) {
                //                var_dump($data->staff_icno);die;
                $m = date('m');
                $syif = TblShiftKeselamatan::find()->where(['icno' => $data->staff_icno])->andWhere(['tarikh' => date('Y-m-d')])->one();
                $syif1 = RefShifts::find()->where(['id' => $syif->shift_id])->one();

                if ('yy' . $data->staff_icno == Yii::$app->request->post($data->staff_icno)) {
                    //                                        var_dump('dd');die;
                    // THB = 1 -> Hadir Baris
                    $icno = Yii::$app->user->getId();
                    $model = new TblRollcall();
                    $model->anggota_icno = $data->staff_icno;
                    $model->month = "$m";
                    $model->catatan = Yii::$app->request->post('g');
                    $model->THB = '1';
                    $model->date = date('Y-m-d');
                    $model->year = date('Y');
                    $model->time = date('h:i:s A');
                    $model->pos_kawalan_id = "$syif->pos_kawalan_id";
                    $model->do_icno = $icno;
                    $model->status = 'SIMPAN';
                    $model->syif = "$syif1->jenis_shifts";
                    $model->save();
                } else {
                    $icno = Yii::$app->user->getId();
                    $model = new TblRollcall();
                    $model->anggota_icno = $data->staff_icno;
                    $model->month = "$m";
                    $model->catatan = Yii::$app->request->post('g');
                    //                    $model->HH = '0';
                    $model->THB = '0';
                    $model->date = date('Y-m-d');
                    $model->year = date('Y');
                    $model->time = date('h:i:s A');
                    $model->pos_kawalan_id = "$syif->pos_kawalan_id";
                    $model->do_icno = $icno;
                    $model->status = 'SIMPAN';
                    $model->syif = "$syif1->jenis_shifts";
                    $model->save();
                }
            }
        } elseif (Yii::$app->request->post('hantar')) {

            foreach ($selection as $id) {
                $hantar = TblPermohonan::findOne(['id' => $id]);
                if ('n' . $hantar->id == Yii::$app->request->post($hantar->id)) {
                    //                    $hantar->status_kj = 'REJECTED';
                    $hantar->status = 'REJECTED';
                } elseif (('y' . $hantar->id == Yii::$app->request->post($hantar->id))) {
                    //                    $hantar->status_kj = 'APPROVED';
                    $hantar->status = 'VERIFIED';
                    $value = 1;
                    while ($value != 2) {

                        if ($value == 1) {
                            $icno = $hantar->app_by;
                            $title = 'Permohonan Jawatan';
                            $content = "Permohonan Jawatan telah disahkan dan Akan Dibawa Ke Mesyuarat Untuk Tindakan Selanjutnya.";
                            $this->Notification($icno, $title, $content);
                            $value++;
                        }
                        if ($value == 2) {
                            $icno = $hantar->icno;
                            $title = 'Permohonan Jawatan';
                            $content = "Permohonan Jawatan anda telah disahkan Akan Dibawa Ke Mesyuarat Untuk Tindakan Selanjutnya.";
                            $this->Notification($icno, $title, $content);
                        }
                    }
                }
                $hantar->save();
            }
        }
        $query = TblStaffKeselamatan::find()->where(['pos_kawalan_id' => $id]);

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('anggota-seliaan', [
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'pos' => $pos
        ]);
    }

    public function actionSts($id)
    {

        //        var_dump($id);die;

        $date = date('Y-m-d');
        $pos = RefPosKawalan::find()->where(['id' => $id])->one();

        $searchModel = new \app\models\keselamatan\TblStaffKeselamatanSearch();
        $pen = ['10', '11', '12', '13', '14'];

        $do_icno = Yii::$app->user->getId();
        $query = TblRollcall::find()->where(['status' => 'SIMPAN'])->andWhere(['do_icno' => $do_icno]);
        $selection = (array) Yii::$app->request->post('selection'); //typecasting
        //        var_dump($selection);die;

        if (Yii::$app->request->post('hantar')) {

            foreach ($selection as $id) {
                $hantar = TblRollcall::findOne(['id' => $id]);
                //                var_dump(Yii::$app->request->post($hantar->id));die;
                //                var_dump($hantar->id);die;

                if (('hh' . $hantar->id == Yii::$app->request->post($hantar->id))) {
                    $hantar->HH = '1';
                } else
                if (('thh' . $hantar->id == Yii::$app->request->post($hantar->id)) == NULL) {
                    $hantar->HH = '0';
                } elseif (('hkwln' . $hantar->id == Yii::$app->request->post($hantar->id))) {
                    $hantar->HKWLN = '1';
                    $hantar->THKWLN = '0';
                } elseif (('thkwln' . $hantar->id == Yii::$app->request->post($hantar->id))) {
                    $hantar->THKWLN = '1';
                    $hantar->HKWLN = '0';
                } elseif (('thbkwln' . $hantar->id == Yii::$app->request->post($hantar->id))) {
                    $hantar->THBKWLN = '1';
                }
                //                if (('thbkwln' . $hantar->id == Yii::$app->request->post($hantar->id)) == NULL) {
                //                    $hantar->THBKWLN = '0';
                //                }
                //              
                $hantar->save();
            }
        }
        //        VarDumper::dump($query, $depth = 10, $highlight = TRUE);
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('sts', [
                'data' => $data,
            ]);
        }
        return $this->render('sts', [
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'pos' => $pos,
        ]);
    }

    public function actionTindakanBertulis($id)
    {
        $sender = Yii::$app->user->getId();

        $model = new TblTindakanBertulisLisan();

        $receiver = Tblprcobiodata::findOne(['ICNO' => $id]);
        //pos_kawalan_id disini adalah shidt id
        // $model->scenario = 'comment';
        if ($model->load(Yii::$app->request->post())) {
            // var_dump($id,$sender);die;
            $model->receiver_icno = "$id";
            $model->sender_icno = "$sender";
            $model->date = Yii::$app->request->post('date');
            $model->date_entered = date('Y-m-d H:i:s');
            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tindakan Berjaya DiRekod']);
                //     if ($type == "1") {
                return $this->redirect(['keselamatan/kakitangan']);
                //     } else {
                //         return $this->redirect(['keselamatan/manual-rollcall', 'id' => $model->pos_kawalan_id, 'date' => $date]);
                //     }
            }
        }
        return $this->renderAjax('tindakan-bertulis', [
            'model' => $model,
            'receiver' => $receiver,
        ]);
    }
    public function actionPembetulanRollcall($id, $date, $type)
    {
        $model = TblRollcall::findOne($id);
        // var_dump($model);die;

        //pos_kawalan_id disini adalah shidt id
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Diubah']);
                if ($type == "1") {
                    return $this->redirect(['keselamatan/periksa-anggota', 'id' => $model->pos_kawalan_id]);
                } else {
                    return $this->redirect(['keselamatan/manual-rollcall', 'id' => $model->pos_kawalan_id, 'date' => $date]);
                }
            }
        }
        return $this->renderAjax('pembetulan-rollcall', [
            'model' => $model
        ]);
    }

    public function actionPembetulanRollcallLmt($id, $date, $type)
    {

        $model = TblRollcall::findOne($id);

        //pos_kawalan_id disini adalah shidt id
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Diubah']);
                if ($type == "1") {
                    return $this->redirect(['keselamatan/periksa-anggota', 'id' => $model->pos_kawalan_id]);
                } else {
                    return $this->redirect(['keselamatan/manual-rollcall', 'id' => $model->pos_kawalan_id, 'date' => $date]);
                }
            }
        }
        return $this->renderAjax('pembetulan-rollcall-lmt', [
            'model' => $model
        ]);
    }

    public function actionPembetulanRollcallLmj($id, $date, $type)
    {
        $model = TblRollcall::findOne($id);

        //pos_kawalan_id disini adalah shidt id
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Diubah']);
                if ($type == "1") {
                    return $this->redirect(['keselamatan/periksa-anggota', 'id' => $model->pos_kawalan_id]);
                } else {
                    return $this->redirect(['keselamatan/manual-rollcall', 'id' => $model->pos_kawalan_id, 'date' => $date]);
                }
            }
        }
        return $this->renderAjax('pembetulan-rollcall-lmj', [
            'model' => $model
        ]);
    }

    public function actionUpdateKesalahan($id, $type)
    {
        $model = TblRollcall::findOne($id);
        $thbh = $model->THBH;
        $thblmj = $model->THBLMJ;
        $thblmt = $model->THBLMT;
        $var = Yii::$app->getRequest()->getQueryParam('id');
        $peg = SetPegawai::find()->where(['pemohon_icno' => $model->anggota_icno])->one();

        if ($model->load(Yii::$app->request->post())) {
            //            var_dump($model->sts_sent);die;
            if ($model->sts_sent === "STS") {

                //                   $status = $model->sts_sent['1'];
                //                   $model->sts_sent = $model->sts_sent;
                $model->status = $model->sts_sent;

                $model->peg_pelulus = $peg->pelulus_icno;
                if ($model->save(false)) {

                    $ntf = new Notification();
                    $ntf->icno = $model->anggota_icno;
                    $ntf->title = 'Surat Tunjuk Sebab';
                    $ntf->content = "Anda Mempunyai Kesalahan yang Belum diambil tindakan.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
                    return $this->redirect(['keselamatan/periksa-anggota', 'id' => $model->pos_kawalan_id]);
                }
            } else {
                $model->status = $model->sts_sent;
                //                var_dump( $model->status);die;
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
                    return $this->redirect(['keselamatan/periksa-anggota', 'id' => $model->pos_kawalan_id]);
                }
            }
        }
        return $this->renderAjax('update-kesalahan', [
            'model' => $model,
            'thbh' => $thbh,
            'thblmj' => $thblmj,
            'thblmt' => $thblmt,
            'type' => $type,

        ]);
    }
    public function actionUpdatePp($id)
    {
        $model = TblSetPegawai::findOne(['pemohon_icno' => $id]);

        if ($model->load(Yii::$app->request->post())) {


            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Approver / Verifier Changed!']);
                return $this->redirect(['keselamatan/senarai-kakitangan']);
            }
        }

        // $layak = Layak::find()->where(['layak_icno' => $id])->orderBy(['layak_mula' => SORT_DESC])->all();
        return $this->render('update-pp', [
            // 'searchModel' => $searchModel,
            'model' => $model,
            'id' => $id,
        ]);
    }

    public function actionUpdateKesalahanManual($id, $date, $type)
    {
        // var_dump($type);die;
        $model = TblRollcall::findOne($id);
        $thbh = $model->THBH;
        $thblmj = $model->THBLMJ;
        $thblmt = $model->THBLMT;
        $var = Yii::$app->getRequest()->getQueryParam('id');
        $peg = SetPegawai::find()->where(['pemohon_icno' => $model->anggota_icno])->one();

        if ($model->load(Yii::$app->request->post())) {
            //            var_dump($model->sts_sent);die;
            if ($model->sts_sent === "STS") {

                //                   $status = $model->sts_sent['1'];
                //                   $model->sts_sent = $model->sts_sent;
                $model->status = $model->sts_sent;

                $model->peg_pelulus = $peg->pelulus_icno;
                if ($model->save(false)) {

                    $ntf = new Notification();
                    $ntf->icno = $model->anggota_icno;
                    $ntf->title = 'Surat Tunjuk Sebab';
                    $ntf->content = "Anda Mempunyai Kesalahan yang Belum diambil tindakan.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
                    return $this->redirect(['keselamatan/manual-rollcall', 'date' => $date, 'id' => $model->pos_kawalan_id]);
                }
            } else {
                $model->status = $model->sts_sent;
                //                var_dump( $model->status);die;
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
                    return $this->redirect(['keselamatan/manual-rollcall', 'date' => $date, 'id' => $model->pos_kawalan_id]);
                }
            }
        }
        return $this->renderAjax('update-kesalahan-manual', [
            'model' => $model,
            'thbh' => $thbh,
            'thblmj' => $thblmj,
            'thblmt' => $thblmt,
            'type' => $type,
        ]);
    }

    public function actionSenaraiKesalahan()
    {
        $icno = Yii::$app->user->getId();
        $model = TblRollcall::find()->where(['THH' => '1'])->orWhere(['THKWLN' => '1'])->orWhere(['THBKWLN' => '1'])->orWhere(['THTC' => '1'])->orWhere(['THBH' => '1'])->orWhere(['THBLMJ' => '1'])->orWhere(['THBLMT' => '1'])->orWhere(['THLMJ' => '1'])->orWhere(['THLMT' => '1'])->andWhere(['anggota_icno' => $icno])->andWhere(['NOT IN', 'status', ['NO_STS','APPROVED','REJECTED','SIMPAN']])->orderBy(['date' => SORT_DESC])->all();
        $searchModel = new \app\models\keselamatan\TblKesalahanSearch();
        $query = \app\models\keselamatan\TblKesalahanSearch::find()->where(['icno' => $icno]);

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('senarai-kesalahan', [
                'data' => $data,
            ]);
        }
        return $this->render('senarai-kesalahan', [
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'model' => $model,
            'bil' => 1,
            //                    'thtc' => $thtc,
        ]);
    }

    //remark biasa mcm kehadiran
    public function actionTindakanKetidakpatuhan()
    {

        $icno = Yii::$app->user->getId();

        $sql = 'SELECT * FROM keselamatan.tbl_rekod WHERE icno=:icno AND (status_in IS NOT NULL OR status_out IS NOT NULL OR incomplete = 1 OR absent = 1 OR external = 1) AND remark_status IS NULL ';
        $model = TblRekod::findBySql($sql, [':icno' => $icno])->all();
        $sql1 = 'SELECT * FROM keselamatan.tbl_rekod_ot WHERE icno=:icno AND (status_in IS NOT NULL OR status_out IS NOT NULL OR incomplete = 1 OR absent = 1 OR external = 1) AND remark_status IS NULL ';
        $model1 = TblRekodOt::findBySql($sql1, [':icno' => $icno])->all();
        //        VarDumper::dump($model, $depth = 10,$highlight = true);die;
        return $this->render('tindakan-ketidakpatuhan', ['model' => $model, 'model1' => $model1, 'bil' => 1]);
    }

    //remark

    public function actionRemark($id)
    {

        $icno = Yii::$app->user->getId();

        // $cid = TblStaffKeselamatan::findOne(['staff_icno' => $icno]);
        $set_peg = TblSetPegawai::findOne(['pemohon_icno' => $icno]);
        $peg = SetPegawai::findOne(['pemohon_icno' => $icno]);
        if ($peg->peraku_icno != null) {
            $conm = $peg->peraku_icno;
        } else {
            $conm = $peg->pelulus_icno;
        }
        // $conm = ($peg->peraku_icno != null) ? $peg->peraku_icno : $peg->pelulus_icno;
        $pegs = Tblprcobiodata::findOne(['ICNO' => $conm]);
        $mod = TblRekod::find()->where(['id' => $id])->one();
        // $peg = TblJadualDoPm::findOne(['tarikh' => $mod->tarikh,'campus_id'=>$cid->campus_id,'shift_id'=>16]);
        // $peg = TblSetPegawai::findOne(['anggota_icno' => $icno]);

        if (!$peg) {
            Yii::$app->session->setFlash('alert', ['title' => 'Makluman', 'type' => 'warning', 'msg' => 'Tiada Pegawai Peraku bagi kehadiran anda. Sila berhubung dengan penyelia Kehadiran/Cuti bagi menetapkan pegawai peraku/lulus.']);
            return $this->redirect(['keselamatan/tindakan-ketidakpatuhan']);
        }

        $model = TblRekod::find()->where("id=:id AND icno=:icno AND remark_status IS NULL", ['icno' => $icno, 'id' => $id])->one();
        // var_dump($icno);die;

        if ($model != null) {
            $model->scenario = 'remark';
        }


        //ni kalau ada yg mau pok silap gatal itu tangan mo test2 kasi masuk $id
        if (!$model) {
            Yii::$app->session->setFlash('alert', ['title' => 'Amaran', 'type' => 'warning', 'msg' => 'Maaf ada tidak dibenarkan melakukan perkara ini.!']);

            return $this->redirect(['keselamatan/tindakan-ketidakpatuhan']);
        }
        //Belum ada kena set pegawai melulus
        if (!$model) {
            Yii::$app->session->setFlash('alert', ['title' => 'Amaran', 'type' => 'warning', 'msg' => 'Maaf Anda belum mempunyai pegawai melulus, Sila hubungi Penyelia Kehadiran anda!']);

            return $this->redirect(['keselamatan/tindakan-ketidakpatuhan']);
        }
        //submiting
        if ($model->load(Yii::$app->request->post())) {

            if (!$set_peg) {
                // $model->app_by = $peg->peraku_icno;
                $model->app_by = ($peg->peraku_icno != null) ? $peg->peraku_icno : $peg->pelulus_icno;
            } else {
                $model->app_by = $set_peg->peraku_icno;
            }
            // $model->app_by = $peg->icno;

            $model->remark_status = 'REMARKED';


            if ($model->save()) {

                $btn = \yii\helpers\Html::a('disini', ['/keselamatan/pengesahan', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);

                //----------Model Notification ---------//
                $ntf = new Notification();
                $ntf->icno = $model->app_by;
                $ntf->title = 'Kehadiran';
                $ntf->content = "Pengesahan ketidakpatuhan menunggu tindakan anda. Sila buat pengesahan $btn";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                //--------Model Notification-----------//
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$model->app_by]);
                $runner->run('dashboard/pending-task-individu', [$icno]);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Sebab Kesalahan Telah Dihantar']);
                return $this->redirect(['keselamatan/tindakan-ketidakpatuhan']);
            }
        }

        return $this->render('remark', ['model' => $model, 'pegs' => $pegs->CONm]);
    }

    public function actionRemarkOt($id)
    {

        $icno = Yii::$app->user->getId();

        $cid = TblStaffKeselamatan::findOne(['staff_icno' => $icno]);
        $peg = SetPegawai::findOne(['pemohon_icno' => $icno]);
        $mod = TblRekodOt::find()->where(['id' => $id])->one();
        $set_peg = TblSetPegawai::findOne(['pemohon_icno' => $icno]);
        $conm = ($peg->peraku_icno != null) ? $peg->peraku_icno : $peg->pelulus_icno;
        $pegs = Tblprcobiodata::findOne(['ICNO' => $conm]);
        // $peg = TblJadualDoPm::findOne(['tarikh' => $mod->tarikh,'campus_id'=>$cid->campus_id,'shift_id'=>16]);

        if (!$peg) {
            Yii::$app->session->setFlash('alert', ['title' => 'Makluman', 'type' => 'warning', 'msg' => 'Tiada Pegawai Peraku bagi kehadiran anda. Sila berhubung dengan penyelia Kehadiran/Cuti bagi menetapkan pegawai peraku/lulus.']);
            return $this->redirect(['keselamatan/tindakan-ketidakpatuhan']);
        }


        //$model = TblRekod::findOne(['id' => $id, 'remark_status' => NULL, 'icno' => $icno]);
        //        $model = TblRekod::findOne(['id' => $id, 'icno' => $icno]);
        $model = TblRekodOt::find()->where("id=:id AND icno=:icno AND remark_status IS NULL", ['icno' => $icno, 'id' => $id])->one();
        if ($model != null) {
            $model->scenario = 'remark';
        }


        //ni kalau ada yg mau pok silap gatal itu tangan mo test2 kasi masuk $id
        if (!$model) {
            Yii::$app->session->setFlash('alert', ['title' => 'Amaran', 'type' => 'warning', 'msg' => 'Maaf ada tidak dibenarkan melakukan perkara ini.!']);

            return $this->redirect(['keselamatan/tindakan-ketidakpatuhan']);
        }
        //Belum ada kena set pegawai melulus
        if (!$model) {
            Yii::$app->session->setFlash('alert', ['title' => 'Amaran', 'type' => 'warning', 'msg' => 'Maaf Anda belum mempunyai pegawai melulus, Sila hubungi Penyelia Kehadiran anda!']);

            return $this->redirect(['keselamatan/tindakan-ketidakpatuhan']);
        }
        //submiting
        if ($model->load(Yii::$app->request->post())) {

            if (!$set_peg->pemohon_icno) {
                $model->app_by = ($peg->peraku_icno != null) ? $peg->peraku_icno : $peg->pelulus_icno;
            } else {
                $model->app_by = $set_peg->peraku_icno;
            }            // $model->app_by = $peg->icno;


            $model->remark_status = 'REMARKED';


            if ($model->save()) {

                $btn = \yii\helpers\Html::a('disini', ['/keselamatan/pengesahan', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);

                //----------Model Notification ---------//
                $ntf = new Notification();
                $ntf->icno = $model->app_by;
                $ntf->title = 'Kehadiran';
                $ntf->content = "Pengesahan ketidakpatuhan menunggu tindakan anda. Sila buat pengesahan $btn";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                //--------Model Notification-----------//


                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Sebab Kesalahan Telah Dihantar']);
                return $this->redirect(['keselamatan/tindakan-ketidakpatuhan']);
            }
        }

        return $this->render('remark-ot', ['model' => $model, 'pegs' => $pegs->CONm]);
    }

    //tindakan pengesahan tunjuk sebab
    //

    public function actionSenaraiTindakan()
    {

        $icno = Yii::$app->user->getId();

        //        $tindakan = Tindakan::find()->where(['icno_tindakan' => $icno])->one();
        //
        //        if ($tindakan) {
        //            $icno = $tindakan->icno_pemberi_kuasa;
        //        }

        // $lulus = TblKesalahan::findAll(['peg_peraku' => $icno, 'remark_status' => 'REMARKED']);
        $lulus = TblRekod::find()->where(['app_by' => $icno, 'remark_status' => 'REMARKED'])->orderBy(['icno' => 'SORT_DESC'])->all();
        //        VarDumper::dump($lulus, $depth = 10, $highlight = TRUE);die;

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
                        //                        $ntf->title = 'Kehadiran Keselamatan';
                        $ntf->content = "Status pengesahan Ketidakpatuhan pada $model->tarikh telah disahkan";
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                    }
                }
            }
            //--------Model Notification-----------//
            //Yii::$app->session->setFlash('info', 'Sebab Kesalahan Telah Dihantar');
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan Ketidakpatuhan telah dihantar!']);
            return $this->redirect(['keselamatan/senarai-tindakan']);
        }


        return $this->render('senarai-tindakan', [
            'lulus' => $lulus,
            'bil' => 1,
        ]);
    }
    public function actionSenaraiTindakanOt()
    {

        $icno = Yii::$app->user->getId();
        $lulus_ot = TblRekodOt::find()->where(['app_by' => $icno, 'remark_status' => 'REMARKED'])->orderBy(['icno' => 'SORT_DESC'])->all();
        if ($pilih = Yii::$app->request->post()) {

            foreach ($pilih['TblRekodOt']['id'] as $k => $v) {
                if ($v != 0) {
                    $model = TblRekodOt::findOne($v);
                    $model->remark_status = 'APPROVED';
                    $model->app_dt = date('Y-m-d H:i:s');

                    if ($model->save()) {

                        //----------Model Notification ---------//
                        $ntf = new Notification();
                        $ntf->icno = $model->icno;
                        //                        $ntf->title = 'Kehadiran Keselamatan';
                        $ntf->content = "Status pengesahan Ketidakpatuhan pada $model->tarikh telah disahkan";
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                    }
                }
            }
            //--------Model Notification-----------//
            //Yii::$app->session->setFlash('info', 'Sebab Kesalahan Telah Dihantar');
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan Ketidakpatuhan telah dihantar!']);
            return $this->redirect(['keselamatan/senarai-tindakan-ot']);
        }


        return $this->render('senarai-tindakan-ot', [
            'lulus_ot' => $lulus_ot,
            'bil' => 1,
        ]);
    }

    public function actionSenaraiTindakanRollcall()
    {

        $icno = Yii::$app->user->getId();

        //        $tindakan = Tindakan::find()->where(['icno_tindakan' => $icno])->one();
        //
        //        if ($tindakan) {
        //            $icno = $tindfalakan->icno_pemberi_kuasa;
        //        }

        $lulus = TblRollcall::find()->where(['peg_pelulus' => $icno, 'status' => 'REMARKED'])->orderBy(['anggota_icno' => 'SORT_DESC'])->all();
        //        VarDumper::dump($lulus, $depth = 10, $highlight = TRUE);die;

        if ($pilih = Yii::$app->request->post()) {

            foreach ($pilih['TblRollcall']['id'] as $k => $v) {
                //                var_dump($pilih['TblRollcall']['id']);die;
                if ($v != 0) {
                    //    var_dump($v);die;
                    $model = TblRollcall::findOne($v);
                    $model->status = 'APPROVED';
                    $model->app_dt = date('Y-m-d H:i:s');

                    if ($model->save(false)) {

                        // ----------Model Notification ---------
                        $ntf = new Notification();
                        $ntf->icno = $model->anggota_icno;
                        $ntf->title = 'Kehadiran Keselamatan';
                        $ntf->content = "Status pengesahan Ketidakpatuhan pada $model->date telah disahkan";
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                    }
                }
            }
            //--------Model Notification-----------//
            //Yii::$app->session->setFlash('info', 'Sebab Kesalahan Telah Dihantar');
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan Ketidakpatuhan telah dihantar!']);
            return $this->redirect(['keselamatan/senarai-tindakan-rollcall']);
        }


        return $this->render('senarai-tindakan-rollcall', [
            'lulus' => $lulus,
            'bil' => 1,
        ]);
    }

    //pengesahan
    public function actionPengesahan($id)
    {

        $icno = Yii::$app->user->getId();

        $model = TblRekod::findOne(['id' => $id, 'remark_status' => 'REMARKED', 'app_by' => $icno]);
        //        VarDumper::dump($model, $depth = 10, $highlight = TRUE);die;

        if ($model) {
            $model->scenario = 'remark';
            //submiting
            if ($model->load(Yii::$app->request->post())) {

                $model->app_dt = date('Y-m-d H:i:s');

                if ($model->save()) {

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->icno;
                    $ntf->title = 'Kehadiran';
                    $ntf->content = "Status pengesahan Ketidakpatuhan pada $model->tarikh telah disahkan";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//
                    //Yii::$app->session->setFlash('info', 'Sebab Kesalahan Telah Dihantar');
                    $runner = new ConsoleCommandRunner();
                    $runner->run('dashboard/pending-task-individu', [$model->app_by]);

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan Ketidakpatuhan telah dihantar!']);
                    return $this->redirect(['keselamatan/senarai-tindakan']);
                }
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Amaran', 'type' => 'warning', 'msg' => 'Pengesahan telah dibuat!']);
            return $this->redirect(['keselamatan/index']);
        }

        return $this->render('pengesahan', ['model' => $model]);
    }
    public function actionPengesahanOt($id)
    {

        $icno = Yii::$app->user->getId();

        $model = TblRekodOt::findOne(['id' => $id, 'remark_status' => 'REMARKED', 'app_by' => $icno]);
        //        VarDumper::dump($model, $depth = 10, $highlight = TRUE);die;

        if ($model) {
            $model->scenario = 'remark';
            //submiting
            if ($model->load(Yii::$app->request->post())) {

                $model->app_dt = date('Y-m-d H:i:s');

                if ($model->save()) {

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->icno;
                    $ntf->title = 'Kehadiran';
                    $ntf->content = "Status pengesahan Ketidakpatuhan pada $model->tarikh telah disahkan";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//
                    //Yii::$app->session->setFlash('info', 'Sebab Kesalahan Telah Dihantar');
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan Ketidakpatuhan telah dihantar!']);
                    return $this->redirect(['keselamatan/senarai-tindakan-ot']);
                }
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Amaran', 'type' => 'warning', 'msg' => 'Pengesahan telah dibuat!']);
            return $this->redirect(['keselamatan/index']);
        }

        return $this->render('pengesahan-ot', ['model' => $model]);
    }

    public function actionPengesahanRollcall($id)
    {

        $icno = Yii::$app->user->getId();

        $model = TblRollcall::findOne(['id' => $id, 'status' => 'REMARKED', 'peg_pelulus' => $icno]);
        //        VarDumper::dump($model, $depth = 10, $highlight = TRUE);die;

        if ($model) {
            $model->scenario = 'reason';
            //submiting
            if ($model->load(Yii::$app->request->post())) {

                $model->app_dt = date('Y-m-d H:i:s');

                if ($model->save(false)) {

                    // var_dump()
                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->anggota_icno;
                    $ntf->title = 'Kehadiran';
                    $ntf->content = "Status pengesahan Ketidakpatuhan pada $model->date telah disahkan";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//
                    //Yii::$app->session->setFlash('info', 'Sebab Kesalahan Telah Dihantar');
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan Ketidakpatuhan telah dihantar!']);
                    return $this->redirect(['keselamatan/senarai-tindakan-rollcall']);
                }
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Amaran', 'type' => 'warning', 'msg' => 'Pengesahan telah dibuat!']);
            return $this->redirect(['keselamatan/senarai-tindakan-rollcall']);
        }

        return $this->render('pengesahan-rollcall', ['model' => $model]);
    }

    //yang ni utk remark borang tunjuk sebab
    public function actionRemarkKesalahan($id)
    {
        $icno = Yii::$app->user->getId();

        $cid = TblStaffKeselamatan::findOne(['staff_icno' => $icno]);
        // var_dump($cid);die;
        // $pegawai = TblSetPegawai::findOne(['anggota_icno' => $icno]);
        $mod = TblRollcall::find()->where(['id' => $id, 'anggota_icno' => $icno])->one();
        // $pegawai = TblJadualDoPm::findOne(['tarikh' => $mod->date,'campus_id'=>$cid->campus_id,'shift_id'=>16]);
        $set_peg = TblSetPegawai::findOne(['pemohon_icno' => $icno]);

        $pegawai = SetPegawai::find()->where(['pemohon_icno' => $icno])->one();
        $conm = ($pegawai->peraku_icno != null) ? $pegawai->peraku_icno : $pegawai->pelulus_icno;
        $peg = Tblprcobiodata::findOne(['ICNO' => $conm]);
        //        $peg = Tblprcobiodata::findOne(['ICNO' => $pegawai->pelulus_icno]);
        //        if (!$peg) {
        //            Yii::$app->session->setFlash('alert', ['title' => 'Makluman', 'type' => 'warning', 'msg' => 'Tiada Pegawai Peraku bagi kehadiran anda. Sila berhubung dengan penyelia Kehadiran/Cuti bagi menetapkan pegawai peraku/lulus.']);
        //            return $this->redirect(['kehadiran/tindakan_ketidakpatuhan']);
        //        }
        //        //$model = TblRekod::findOne(['id' => $id, 'remark_status' => NULL, 'icno' => $icno]);
        if (!$mod) {
            Yii::$app->session->setFlash('alert', ['title' => 'Amaran', 'type' => 'warning', 'msg' => 'Maaf ada tidak dibenarkan melakukan perkara ini.!']);

            return $this->redirect(['keselamatan/tindakan-ketidakpatuhan']);
        }
        $model = TblRollcall::findOne(['id' => $id, 'anggota_icno' => $icno]);

        if ($model->load(Yii::$app->request->post())) {
            if (!$set_peg->pemohon_icno) {
                // $model->peg_pelulus = $pegawai->peraku_icno;
                $model->peg_pelulus = ($pegawai->peraku_icno != null) ? $pegawai->peraku_icno : $pegawai->pelulus_icno;
            } else {
                $model->peg_pelulus = $set_peg->peraku_icno;
            }
            $model->status = 'REMARKED';
            $model->namafile = UploadedFile::getInstance($model, 'namafile');
            if ($model->namafile) {
                if ($model->save(false)) {
                    $id = $model->id;
                    $res = Yii::$app->FileManager->UploadFile($model->namafile->name, $model->namafile->tempName, '04', 'Alasan Anggota');
                    if ($res->status == true) {
                        $model->namafile = $res->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        return $this->redirect(['senarai-kesalahan', 'id' => $id, 'icno' => $icno]);
                    } else {
                        //                        Tbllesen::deleteAll(['licId'=>$id]);
                        Yii::$app->session->setFlash('alert', ['title' => ':(', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                        return $this->redirect(['senarai-kesalahan']);
                    }
                }
            } elseif (!empty($model->filename) && $model->filename != 'deleted') {
                if ($model->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    return $this->redirect(['senarai-kesalahan']);
                }
            } else {
                Yii::$app->session->setFlash('Gagal', "Sila Upload file");
            }
            if ($model->save(false)) {

                //                $btn = Html::a('disini', ['/kehadiran/pengesahan', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
                //----------Model Notification ---------//
                //                $ntf = new Notification();
                //                $ntf->icno = $pegawai->peg_peraku;
                //                $ntf->title = 'Kehadiran';
                //                $ntf->content = "Pengesahan Tunjuk sebab menunggu tindakan anda. Sila buat pengesahan";
                //                $ntf->ntf_dt = date('Y-m-d H:i:s');
                //                $ntf->save();
                //--------Model Notification-----------//


                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Sebab Kesalahan Telah Dihantar']);
                return $this->redirect(['keselamatan/senarai-kesalahan']);
            }
        }

        return $this->render('remark-kesalahan', ['model' => $model, 'peg' => $peg->CONm]);
    }

    public function actionKemaskiniKesalahanAnggota($id)
    {
        //        VarDumper::dump($id, $depth = 10, $highlight = true);die;
        //      $icno = Yii::$app->user->getId();
        $model = TblKesalahan::findAll(['icno' => $id]);
        $thtc = TblKesalahan::findAll(['icno' => $id], ['thtc' => 1]);
        $searchModel = new \app\models\keselamatan\TblKesalahanSearch();
        $query = \app\models\keselamatan\TblKesalahanSearch::find()->where(['icno' => $id]);

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('kemaskini-kesalahan-anggota', [
                'data' => $data,
            ]);
        }
        return $this->render('kemaskini-kesalahan-anggota', [
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'model' => $model,
            'bil' => 1,
            'thtc' => $thtc,
        ]);
    }

    //into senarai kesalahan anggota

    public function actionLaporanKehadiranIndividu($id = null, $tahun = null, $bulan = null)
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

        $sql = 'SELECT * FROM keselamatan.tbl_reports WHERE icno=:icno AND MONTH(tarikh)=:mth';
        $reports = TblReports::findBySql($sql, [':icno' => $id, ':mth' => $mth])->asArray()->all();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        //        $warna_kad = \app\models\keselamatan\TblWarnakad::WarnaKadSemasa($id, $mth);
        $warna_kad = \app\models\keselamatan\TblWarnakad::WarnaKadSemasa($id, $mth, NULL, $year);


        return $this->render('laporan-kehadiran-individu', ['reports' => $reports, 'var' => $var, 'icno' => $id, 'tahun' => $year, 'bulan' => $mth, 'biodata' => $biodata, 'warna_kad' => $warna_kad]);
    }

    public function actionLaporanKehadiranOt($id = null, $tahun = null, $bulan = null)
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
        $warna_kad = \app\models\keselamatan\TblWarnakad::WarnaKadSemasa($id, $mth, NULL, $year);

        return $this->render('laporan-kehadiran-ot', ['var' => $var, 'icno' => $id, 'tahun' => $year, 'bulan' => $mth, 'biodata' => $biodata, 'warna_kad' => $warna_kad]);
    }

    public function actionLaporanPegawai($id = null, $tahun = null, $bulan = null)
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
        $warna_kad = \app\models\keselamatan\TblWarnakad::WarnaKadSemasa($id, $mth, NULL, $year);

        return $this->render('laporan-pegawai', ['var' => $var, 'icno' => $id, 'tahun' => $year, 'bulan' => $mth, 'biodata' => $biodata, 'warna_kad' => $warna_kad]);
    }

    public function actionLaporanKehadiranLmt($id = null, $tahun = null, $bulan = null)
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
        $warna_kad = \app\models\keselamatan\TblWarnakad::WarnaKadSemasa($id, $mth, NULL, $year);

        return $this->render('laporan-kehadiran-lmt', ['var' => $var, 'icno' => $id, 'tahun' => $year, 'bulan' => $mth, 'biodata' => $biodata, 'warna_kad' => $warna_kad]);
    }

    public function actionDetailrekod($icno, $tarikh, $type)
    {
        // var_dump($type);die;
        if ($type == 1) {
            $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        } elseif ($type == 2) {
            $model = TblRekodOt::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        } else {
            $model = TblRekodLmt::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        }
        return $this->renderAjax('detailrekod', ['model' => $model]);
    }

    public function actionClone()
    {
        $added_by = Yii::$app->user->getId();
        $m = date('m');
        //        var_dump($next);die;

        $ids = (new \yii\db\Query())
            ->select(['staff_icno', 'pos_kawalan_id', 'unit_id', 'ketua_pos', 'penolong_ketua_pos'])
            ->from('keselamatan.tbl_staff_keselamatan')
            ->where(['month' => $m])
            ->all();

        foreach ($ids as $as) {
            $ii = $as['staff_icno'];
            $pos = $as['pos_kawalan_id'];
            $unit = $as['unit_id'];
            $kp = $as['ketua_pos'];
            $pkp = $as['penolong_ketua_pos'];
            $clone = new TblStaffKeselamatan;
            $clone->month = date('m', strtotime('next month'));
            $clone->staff_icno = $ii;
            $clone->pos_kawalan_id = $pos;
            $clone->unit_id = $unit;
            $clone->ketua_pos = $kp;
            $clone->penolong_ketua_pos = $pkp;
            $clone->added_by = $added_by;
            $clone->created_at = date('Y-m-d H:i:s');
            $clone->year = date('Y');
            $clone->isActive = 1;
            $clone->save();
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Telah DiReplika,Sila Ubah Mana-Mana Yang berkaitan']);
        return $this->redirect(['keselamatan/staff-list']);
    }

    public function actionUnit()
    {
        $id = Yii::$app->user->getId(); //getting user id
        $model = new RefUnit();
        if ($model->load(Yii::$app->request->post())) {
            $model->added_by = $id;
            $model->added_dt = date('Y-m-d H:i:s');
            $model->active = 1;
            if ($model->save()) {
                //klau ada notification
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pos Kawalan Telah Ditambah']);
            return $this->redirect(['unit']);
        }
        $searchModel = new RefUnitSearch();
        $query = RefUnit::find()->where(['active' => 1]);
        //        var_dump($query);die;
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('unit', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
        ]);
    }

    //to add new pos kawalan
    public function Notification($icno, $title, $content)
    {
        $ntf = new Notification();
        $ntf->icno = $icno;
        $ntf->title = $title;
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
    }

    public function actionPosKawalan()
    {
        $id = Yii::$app->user->getId(); //getting user id
        $cid = TblStaffKeselamatan::findOne(['staff_icno' => $id]);
        $admin = TblUserAccess::findOne(['icno' => $id]);
        $pos = new RefPosKawalan();
        if ($pos->load(Yii::$app->request->post())) {
            $pos->added_by = $id;
            $pos->active = 1;
            if ($pos->save()) {
                //klau ada notification
            }
            $this->log($id, 'Add Pos - Penyelia');

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pos Kawalan Telah Ditambah']);
            return $this->redirect(['pos-kawalan']);
        }
        $searchModel = new RefPosKawalanSearch();
        if ($admin) {
            $query = RefPosKawalan::find()->where(['active' => 1]);
        } else {
            $query = RefPosKawalan::find()->where(['active' => 1])->andWhere(['kampus_id' => $cid]);
        }
        //    var_dump($query);die;
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('pos-kawalan', [
            'pos' => $pos,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
        ]);
    }

    public function actionPosLmt()
    {
        $id = Yii::$app->user->getId(); //getting user id
        $pos = new \app\models\keselamatan\RefPosLmt();
        if ($pos->load(Yii::$app->request->post())) {
            $pos->added_by = $id;
            $pos->active = 1;
            if ($pos->save()) {
                //klau ada notification
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pos Kawalan Telah Ditambah']);
            return $this->redirect(['pos-lmt']);
        }
        $searchModel = new \app\models\keselamatan\RefPosLmtSearch();
        $query = \app\models\keselamatan\RefPosLmt::find()->where(['active' => 1]);
        //        var_dump($query);die;
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('pos-lmt', [
            'pos' => $pos,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
        ]);
    }

    public function actionWpKeselamatan()
    {
        $id = Yii::$app->user->getId();

        $refshift = new RefShifts();


        if ($refshift->load(Yii::$app->request->post())) {
            $refshift->entry_by = $id;
            $refshift->active = 1;
            if ($refshift->save()) {
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Syif Telah Ditambah']);
            return $this->redirect(['wp-keselamatan']);
        }
        $searchModel = new RefShiftsSearch();
        $query = RefShifts::find()->where(['active' => 1]);
        //        var_dump($query);die;
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('wpKeselamatan', [
            'refshift' => $refshift,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
        ]);
    }

    public function actionLmtKeselamatan()
    {
        $id = Yii::$app->user->getId();

        $refshift = new RefLmt();


        if ($refshift->load(Yii::$app->request->post())) {
            $refshift->entry_by = $id;
            $refshift->active = 1;
            if ($refshift->save()) {
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Syif Telah Ditambah']);
            return $this->redirect(['lmt-keselamatan']);
        }
        $searchModel = new RefLmtSearch();
        $query = RefLmt::find()->where(['active' => 1])->andWhere(['!=', 'id', 1]);
        //        var_dump($query);die;
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('lmtKeselamatan', [
            'refshift' => $refshift,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
        ]);
    }

    function getDaysInYearMonth(int $year, int $month, string $format)
    {
        $date = DateTime::createFromFormat("Y-n", "$year-$month");

        $datesArray = array();
        for ($i = 1; $i <= $date->format("t"); $i++) {
            $datesArray[] = DateTime::createFromFormat("Y-n-d", "$year-$month-$i")->format($format);
        }
        return $datesArray;
    }

    public function actionOtSetup($tahun = null, $bulan = null, $units = null, $pos = null)
    {
        //        $icno = Yii::$app->user->getId();
        $icno = Yii::$app->user->getId();
        $admin = TblAkses::findOne(['icno' => $icno, 'akses_level' => 1]);
        $staf = TblAkses::find()->where(['icno' => $icno])->one();

        if ($admin) {
            $query = RefPosKawalan::find()->where(['active' => 1])->all();
        } else {
            $query = RefPosKawalan::find()->where(['kampus_id' => $staf->campus_id])->all();
        }
        if (!$bulan) {
            $bulan = date('m');
        }

        if (!$bulan) {
            $bulan = date('m');
        }

        if (!$tahun) {
            $tahun = date('Y');
        }
        if (!$units) {
            //            var_dump('d');die;
            $units = 1;
        }
        if (!$pos) {
            $pos = 1;
        }
        $unit = RefUnit::findAll(['active' => 1]);

        $var = $this->getDaysInYearMonth($tahun, $bulan, 'd');
        $day = $this->getDaysInYearMonth($tahun, $bulan, 'D');

        //        $staffs = TblStaffKeselamatan::findAll(['month' => $bulan, 'unit_id' => $units, 'pos_kawalan_id' => $pos]);
        // $staffs = TblStaffKeselamatan::find()
        //         ->where(['month' => $bulan, 'unit_id' => $units, 'pos_kawalan_id' => $pos])
        //         ->andWhere(['isActive' => 1])
        //         ->orWhere(['or',
        //             ['tukar_pos' => 1]])
        //         ->all();
        // $staffs = TblOt::find()->select('icno')->distinct()->where(['month' => $bulan, 'unit_id' => $units, 'pos_kawalan_id' => $pos])->all();
        $staffs = TblOt::find()->select('icno')->distinct()->where(['month' => $bulan, 'pos_kawalan_id' => $pos])->all();
        if (!$staffs) {
            $staffs = TblAkses::find()->where(['NOT IN', 'akses_level', ['1', '4']])->andWhere(['NOT IN', 'icno', ['731011135058', '840926125686']])->andWhere(['campus_id' => $staf->campus_id])->orderBy(['akses_level' => SORT_DESC])->all();
        }
        return $this->render('ot-setup', [
            'staffs' => $staffs,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'var' => $var,
            'day' => $day,
            'bil' => 1,
            'unit' => $unit,
            'units' => $units,
            'pos' => $pos,
            'query' => $query
        ]);
    }

    public function actionShiftSetup($tahun = null, $bulan = null, $units = null, $pos = null)
    {

        // var_dump($tahun,$bulan,$units,$pos);die;
        $icno = Yii::$app->user->getId();
        $admin = TblAkses::findOne(['icno' => $icno, 'akses_level' => 1]);
        $staf = TblAkses::find()->where(['icno' => $icno])->one();

        if ($admin) {
            $query = RefPosKawalan::find()->where(['active' => 1])->all();
        } else {
            $query = RefPosKawalan::find()->where(['kampus_id' => $staf->campus_id])->all();
        }
        if (!$bulan) {
            $bulan = date('m');
        }

        if (!$tahun) {
            $tahun = date('Y');
        }
        if (!$units) {
            //            var_dump('d');die;
            $units = 1;
        }
        if (!$pos) {
            $pos = 1;
        }


        $unit = RefUnit::findAll(['active' => 1]);

        $var = $this->getDaysInYearMonth($tahun, $bulan, 'd');
        $day = $this->getDaysInYearMonth($tahun, $bulan, 'D');

        // $staffs = TblShiftKeselamatan::findAll(['month' => $bulan, 'unit_id' => $units, 'pos_kawalan_id' => $pos]);
        // $staffs = TblShiftKeselamatan::find()->select('icno')->distinct()->where(['month' => $bulan, 'unit_id' => $units, 'pos_kawalan_id' => $pos])->all();
        $staffs = TblShiftKeselamatan::find()->select('icno')->distinct()->where(['month' => $bulan, 'year' => $tahun, 'pos_kawalan_id' => $pos])->all();
        //   var_dump($staffs);die;
        if (!$staffs) {
            $staffs = TblAkses::find()->where(['NOT IN', 'akses_level', ['1', '3']])->andWhere(['NOT IN', 'icno', ['731011135058', '840926125686']])->andWhere(['campus_id' => $staf->campus_id])->orderBy(['akses_level' => SORT_DESC])->all();
        }
        // var_dump($staffs);die;
        return $this->render('shift-setup', [
            'staffs' => $staffs,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'var' => $var,
            'day' => $day,
            'bil' => 1,
            'unit' => $unit,
            'units' => $units,
            'pos' => $pos,
            'query' => $query,
            //                    'mode' => $mode
        ]);
    }

    public function pegMedan($week)
    {
        $array = array();
        $array2 = array();
        $array3 = array();
        for ($i = 1; $i < 53; $i = $i + 3) {
            $array[] = $i;
        }
        for ($i = 2; $i < 53; $i = $i + 3) {
            $array2[] = $i;
        }
        for ($i = 3; $i < 53; $i = $i + 3) {
            $array3[] = $i;
        }
        $i = ['911110125435', '860830495955', '881214495321'];
        if (in_array($week, $array)) {
            $peg = $i[0];
        } elseif (in_array($week, $array2)) {
            $peg = $i[1];
        } else {
            $peg = $i[2];
        }
        return $peg;
    }

    //Overtime berjadual  

    public function actionLmtSetup($tahun = null, $bulan = null, $units = null, $pos = null)
    {

        $icno = Yii::$app->user->getId();
        if (!$bulan) {
            $bulan = date('m');
        }

        if (!$tahun) {
            $tahun = date('Y');
        }
        if (!$units) {
            //            var_dump('d');die;
            $units = 1;
        }
        if (!$pos) {
            $pos = 1;
        }

        $var = $this->getDaysInYearMonth($tahun, $bulan, 'd');
        $day = $this->getDaysInYearMonth($tahun, $bulan, 'D');
        //        var_dump($var);die;

        $staffs = TblLmtKeselamatan::findAll(['month' => $bulan, 'pos_kawalan_id' => $pos, 'year' => $tahun]);
        //        varDumper::dump($staffs);die;
        return $this->render('lmt-setup', [
            'staffs' => $staffs,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'var' => $var,
            'day' => $day,
            'bil' => 1,
            'units' => $units,
            'pos' => $pos,
        ]);
    }

    public function actionCreateShift($id, $tahun, $bulan)
    {

        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');

        $wp = RefShifts::find()->all();
        $staf = TblStaffKeselamatan::find()->where(['staff_icno' => $id])->one();

        $count = count($this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d'));
        $staffname = Tblprcobiodata::DisplayNameGred($id);
        $models = [new TblShiftKeselamatan()];

        for ($i = 1; $i < $count; $i++) {
            $models[] = new TblShiftKeselamatan();
            //                        var_dump($models);die;
        }
        //        var_dump($i);die;

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {

            //          var_dump($i);die;
            foreach ($models as $m) {
                $m->icno = $id;
                $m->year = date('Y');
                $m->month = date('m');
                $m->pos_kawalan_id = $staf->pos_kawalan_id;
                $m->unit_id = $staf->unit_id;
                $m->campus_id = $staf->kampus;

                $m->save(false);
            }
            return $this->redirect(['keselamatan/shift-setup', 'tahun' => $tahun, 'bulan' => $bulan, 'units' => $staf->unit_id, 'pos' => $staf->pos_kawalan_id]);
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

    public function actionCreateLmt($id, $tahun, $bulan)
    {
        //        var_dump($id);die;
        $icno = Yii::$app->user->getId(); //getting user id

        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');

        $wp = RefLmt::find()->all();
        $staf = TblLmtKeselamatan::find()->where(['staff_icno' => $id])->one();

        $count = count($this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d'));
        $staffname = Tblprcobiodata::DisplayNameGred($id);

        $models = [new TblLmt()];

        for ($i = 1; $i < $count; $i++) {
            $models[] = new TblLmt();
            //                        var_dump($models);die;
        }
        //        var_dump($i);die;

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {

            foreach ($models as $m) {
                if (($m->lmt_id) == null) {
                    $m->lmt_id = 1;
                }
                $m->icno = $id;
                $m->year = date('Y');
                $m->month = $bulan;
                $m->pos_kawalan_id = $staf->pos_kawalan_id;
                $m->unit_id = $staf->unit_id;
                $m->do_add_icno = $icno;
                $m->campus_id = $staf->kampus;
                $m->do_add_dt = date('Y-m-d H:i:s');
                $m->save(false);
            }
            return $this->redirect(['keselamatan/lmt-setup', 'tahun' => $tahun, 'bulan' => $bulan, 'units' => $staf->unit_id, 'pos' => $staf->pos_kawalan_id]);
        }

        return $this->renderAjax('create-lmt', [
            'models' => $models,
            'icno' => $id,
            'var' => $var,
            'wp' => $wp,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'staffname' => $staffname,
        ]);
    }

    public function actionCreateOt($id, $tahun, $bulan)
    {
        //var_dump($bulan);die;
        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');

        $wp = RefShifts::find()->all();
        //        var_dump($wp);die;

        $count = count($this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d'));
        $staffname = Tblprcobiodata::DisplayNameGred($id);
        $models = [new TblOt()];
        $staf = TblStaffKeselamatan::find()->where(['staff_icno' => $id])->one();


        for ($i = 1; $i < $count; $i++) {
            $models[] = new TblOt();
            //                        var_dump($models);die;
        }
        //        var_dump($i);die;

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {

            //          var_dump($i);die;
            foreach ($models as $m) {
                if (($m->shift_id) == null) {
                    $m->shift_id = 1;
                }
                $m->icno = $id;
                $m->year = date('Y');
                $m->month = $bulan;
                $m->pos_kawalan_id = $staf->pos_kawalan_id;
                $m->unit_id = $staf->unit_id;
                $m->campus_id = $staf->kampus;

                $m->save(false);
            }
            return $this->redirect(['keselamatan/ot-setup', 'tahun' => $tahun, 'bulan' => $bulan, 'units' => $staf->unit_id, 'pos' => $staf->pos_kawalan_id]);
        }

        return $this->renderAjax('create-ot', [
            'models' => $models,
            'icno' => $id,
            'var' => $var,
            'wp' => $wp,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'staffname' => $staffname,
        ]);
    }

    public function actionUpdateShift($id, $tahun, $bulan, $pos)
    {

        $models = TblShiftKeselamatan::find()->where(['icno' => $id, 'YEAR(tarikh)' => $tahun, 'MONTH(tarikh)' => $bulan])->indexBy('id')->all();
        $wp = RefShifts::find()->all();

        $staffname = Tblprcobiodata::DisplayNameGred($id);
        $staf = TblStaffKeselamatan::find()->where(['staff_icno' => $id])->one();

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {

            foreach ($models as $model) {

                if ($model->shift_id == "") {
                    $model->shift_id = 1;
                }
                if ($model->shift_id == 21) {

                    // $m = TblShiftKeselamatan::find()->where(['icno' => $id, 'tarikh' => $model->tarikh])->andWhere(['shift_id' => 21])->one();
                    $check  = TblWfh::find()->where(['icno' => $id, 'start_date' => $model->tarikh])->exists();
                    if (!$check) {
                        $wfh = new TblWfh();

                        $start = date('d/m/Y', strtotime($model->tarikh));
                        $wfh->icno = $model->icno;
                        $wfh->full_date = "$start" . " to " . "$start";
                        $wfh->start_date = $model->tarikh;
                        $wfh->end_date = $model->tarikh;
                        $wfh->tempoh = 1;
                        $wfh->remark = "ADDED BY PENYELIA JADUAL KESELAMATAN";
                        $wfh->entry_dt = date('Y-m-d h:i:s');
                        $wfh->set_by = Yii::$app->user->getId();
                        $wfh->status = "APPROVED";
                        $wfh->save(false);
                    }
                }
                $model->save(false);
            }


            return $this->redirect(['keselamatan/shift-setup', 'tahun' => $tahun, 'bulan' => $bulan, 'pos' => $pos]);
        }

        return $this->renderAjax('update-shift', [
            'models' => $models,
            'wp' => $wp,
            'staffname' => $staffname,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pos' => $pos
        ]);
    }

    public function actionUpdateShiftOt($id, $tahun, $bulan)
    {

        $models = TblOt::find()->where(['icno' => $id, 'YEAR(tarikh)' => $tahun, 'MONTH(tarikh)' => $bulan])->indexBy('id')->all();
        //        var_dump($models);die;
        $wp = RefShifts::find()->all();
        //        var_dump($wp);die;
        $staffname = Tblprcobiodata::DisplayNameGred($id);
        $staf = TblStaffKeselamatan::find()->where(['staff_icno' => $id])->one();

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            //            var_dump('d');die;
            foreach ($models as $model) {
                if ($model->shift_id == "") {
                    $model->shift_id = 1;
                }
                $model->save(false);
            }
            return $this->redirect(['keselamatan/ot-setup', 'tahun' => $tahun, 'bulan' => $bulan, 'units' => $staf->unit_id, 'pos' => $staf->pos_kawalan_id]);
        }

        return $this->renderAjax('update-shift-ot', ['models' => $models, 'wp' => $wp, 'staffname' => $staffname, 'bulan' => $bulan, 'tahun' => $tahun]);
    }

    //
    //lmt
    public function actionUpdateLmt($id, $tahun, $bulan)
    {

        $models = TblLmt::find()->where(['icno' => $id, 'YEAR(tarikh)' => $tahun, 'MONTH(tarikh)' => $bulan])->indexBy('id')->all();
        //        var_dump($id);die;
        //        VarDumper::dump($models, $depth = 10);die;
        $wp = RefLmt::find()->all();
        //        var_dump($wp);die;
        $staf = TblLmtKeselamatan::find()->where(['staff_icno' => $id])->one();

        $staffname = Tblprcobiodata::DisplayNameGred($id);

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            foreach ($models as $model) {
                if ($model->lmt_id == "") {
                    $model->lmt_id = 1;
                }
                $model->save(false);
            }
            return $this->redirect(['keselamatan/lmt-setup', 'tahun' => $tahun, 'bulan' => $bulan, 'units' => $staf->unit_id, 'pos' => $staf->pos_kawalan_id]);
        }

        return $this->renderAjax('update-lmt', ['models' => $models, 'wp' => $wp, 'staffname' => $staffname, 'bulan' => $bulan, 'tahun' => $tahun]);
    }

    public function actionLmtShiftList($month = null, $year = null)
    {
        $id = Yii::$app->user->getId(); //getting user id

        if (!$month) {
            $month = date('m');
        }

        if (!$year) {
            $year = date('Y');
        }

        $staff = TblLmtKeselamatan::find()->andWhere(['month' => $month, 'year' => $year])->all();
        $array_staff = [];
        foreach ($staff as $r) {
            $array_staff[] = $r->staff_icno;
        }
        $biodata = Tblprcobiodata::find()
            ->where(['status' => 1])
            ->andWhere(['not in', 'ICNO', $array_staff])
            ->andWhere(['IN', 'DeptId', ['2', '139', '33']])
            ->all();
        $ketuapos = Tblprcobiodata::find()
            ->where(['status' => 1])
            ->andWhere(['in', 'DeptId', ['2', '139', '33']])
            ->all();

        $model = new TblLmtKeselamatan();
        //            var_dump($year);die;
        if ($model->load(Yii::$app->request->post())) {

            //            $model->month =
            $model->year = date('y');
            $model->added_by = $id;
            $model->created_at = date('Y-m-d H:i:s');
            //            $model->sup_icno = $id;
            //            $model->created_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Added', 'type' => 'success', 'msg' => 'New staff Added!']);
                return $this->redirect(['keselamatan/lmt-shift-list']);
            }
        }

        if ($this->aksesAdmin($id) == TRUE) {
            $staf = TblLmtKeselamatan::find()->orderBy(['kampus' => SORT_ASC]);
        } else {
            $campus = TblAkses::find()->where(['icno' => $id, 'isActive' => 1])->one();
            $staf = TblLmtKeselamatan::find()->where(['kampus' => $campus->campus_id])->groupBy(['kampus']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $staf,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('lmt-shift-list', [
            'model' => $model,
            'biodata' => $biodata,
            'ketuapos' => $ketuapos,
            'dataProvider' => $dataProvider,
            'month' => $month,
            'year' => $year,
        ]);
    }

    /**
     * Updates an existing TblRekod model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = TblStaffKeselamatan::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                $this->Log(Yii::$app->user->getId(),'Update TblStaffKeselamatan');
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Penempatan telah Berjaya dikemaskini!']);
                return $this->redirect(['staff-list']);
            }
        }
        return $this->renderAjax('update', [
            'model' => $model
        ]);
    }
    public function Log($icno, $action = null)
    {
        $log = new Logs();

        // $id = Yii::$app->db->getLastInsertID();

        $log->icno = $icno;
        $log->action = $action;
        // $log->ref_id = $id;
        $log->datetime = date('Y-m-d h:i:s');

        $log->save();
    }
    public function actionUpdatePos($id)
    {
        $model = RefPosKawalan::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pos Kawalan Berjaya Di Kemaskini!']);
                return $this->redirect(['pos-kawalan']);
            }
        }
        return $this->renderAjax('update-pos', [
            'model' => $model
        ]);
    }
    public function actionUpdateUlasan($id, $syif, $date)
    {
        $model = TblLaporanKejadian::find()->where(['entered_by' => $id])->andWhere(['syif' => $syif])->andWhere(['date' => $date])->one();
        // var_dump($model->id);die;

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ulasan telah Berjaya dikemaskini!']);
                return $this->redirect(['ringkasan-laporan', 'syif' => $syif, 'tarikh' => $date]);
            }
        }
        return $this->renderAjax('update-ulasan', [
            'model' => $model
        ]);
    }

    public function actionUpdateSyifLmt($id)
    {
        $model = RefLmt::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tarikh Permohonan Jawatan telah Berjaya dikemaskini!']);
                return $this->redirect(['lmt-keselamatan']);
            }
        }
        return $this->renderAjax('update-syif-lmt', [
            'model' => $model
        ]);
    }

    public function actionExchange($id)
    {
        $model = TblStaffKeselamatan::findOne($id);
        //        varDumper::dump($model->staff_icno);die;
        $icno = Yii::$app->user->getId(); //getting user id
        $model2 = new TblLmtKeselamatan();

        if ($model2->load(Yii::$app->request->post())) {
            $model2->tukar_pos = 1;
            $model2->isActive = 1;
            $model2->created_at = date('Y-m-d H:i:s');
            $model2->year = date('Y');
            $model2->added_by = $icno;
            if ($model2->save()) {

                //                $model2->staff_icno = $model->staff_icno;

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => '!']);
                return $this->redirect(['staff-list']);
            }
        }
        return $this->renderAjax('exchange', [
            'model' => $model,
            'model2' => $model2
        ]);
    }

    //reporting part ye sini tu


    public function actionMonthlyReport($tahun = null, $bulan = null, $units = null, $pos = null)
    {

        $icno = Yii::$app->user->getId();
        //        var_dump($bulan);die;

        if (!$bulan) {
            $bulan = date('m');
        }

        if (!$tahun) {
            $tahun = date('Y');
        }
        if (!$units) {
            //            var_dump('d');die;
            $units = 1;
        }
        if (!$pos) {
            $pos = 1;
        }

        $unit = RefUnit::findAll(['active' => 1]);

        $var = $this->getDaysInYearMonth($tahun, $bulan, 'd');
        $day = $this->getDaysInYearMonth($tahun, $bulan, 'D');

        $ids = ['3', '4', '5'];
        $staffs = TblStaffKeselamatan::findAll(['month' => $bulan, 'unit_id' => $units, 'pos_kawalan_id' => $pos, 'year' => $tahun]);
        $s = TblStaffKeselamatan::find()->where(['month' => $bulan, 'unit_id' => $units, 'pos_kawalan_id' => $pos, 'year' => $tahun])->all();
        //        $exist = TblLmtKeselamatan::find(['staff_icno']);
        $lmt = TblLmtKeselamatan::find()->where(['month' => $bulan, 'unit_id' => $units, 'pos_kawalan_id' => $pos, 'year' => $tahun])->all();
        //        var_dump($lmt);die;
        $syifs = RefShifts::find()->where(['active' => 1])->andWhere(['in', 'id', $ids])->all();
        //        var_dump($syifs);die;

        return $this->render('monthly-report', [
            'staffs' => $staffs,
            'tahun' => $tahun,
            'lmt' => $lmt,
            'bulan' => $bulan,
            'var' => $var,
            'day' => $day,
            'bil' => 1,
            'bil1' => 1,
            'syifs' => $syifs,
            's' => $s,
            'unit' => $unit,
            'units' => $units,
            'pos' => $pos,
            //                    'mode' => $mode
        ]);
    }
 
    //update tambah akses 
    public function actionSetAccess()
    {
        $icno = Yii::$app->user->getId();
        $id = TblStaffKeselamatan::findOne(['staff_icno' => $icno]);
        // var_dump();die;
        $admin = TblAkses::find()->where(['campus_id' => $id->campus_id])->all(); //cari senarai admin
        $adminbaru = new TblAkses(); //untuk admin baru

        if ($adminbaru->load(Yii::$app->request->post())) {
            if (TblAkses::find()->where(['icno' => $adminbaru->icno])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Sudah Wujud!']);
            } elseif ($adminbaru->kakitangan->CONm != NULL) { //jika icno tidak wujud dalam sistem
                $adminbaru->isActive = 1;
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                $this->log($icno, 'Set Access - Penyelia ' . $adminbaru->icno);
                $adminbaru->save();
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
            }

            return $this->redirect(['set-access']);
        }
        if (TblAkses::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('set-access', [
                'admin' => $admin,
                'adminbaru' => $adminbaru,
                'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }
    public function actionAksesPengguna()
    {
        $admin = TblAkses::find()->all(); //cari senarai admin
        $adminbaru = new TblAkses(); //untuk admin baru
        if ($adminbaru->load(Yii::$app->request->post())) {
            if (TblAkses::find()->where(['icno' => $adminbaru->icno])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Sudah Wujud!']);
            } elseif ($adminbaru->kakitangan->CONm != NULL) { //jika icno tidak wujud dalam sistem
                $adminbaru->isActive = 1;
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                $adminbaru->save();
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
            }

            return $this->redirect(['akses-pengguna']);
        }
        if (TblAkses::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('akses-pengguna', [
                'admin' => $admin,
                'adminbaru' => $adminbaru,
                'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    //testing import excel to database
    public function actionImportOt()
    {
        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);
        $modelImport->addRule(['fileImport'], 'required');
        $modelImport->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx'], ['maxSize' => 1024 * 1024]);

        if (Yii::$app->request->post()) {
            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');
            if ($modelImport->fileImport && $modelImport->validate()) {
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($modelImport->fileImport->tempName);
                //                var_dump($inputFileType);die;
                $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                //                VarDumper::dump($objReader);die;/
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $baseRow = 2;
                $year = date('Y');
                $month = date('m', strtotime('+10 day'));
                // $month = "01";
                //                var_dump($month);
                $dayscount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $column = ['', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI'];
                //                var_dump($dayscount);die;
                while (!empty($sheetData[$baseRow]['A'])) {

                    $i = 1;
                    while ($dayscount >= 1) {
                        $model = new TblOt();
                        $umsper = $this->umsper($sheetData[$baseRow]['B']);
                        $model->icno = $umsper;
                        $syif = $this->syifOvertime($sheetData[$baseRow][$column[$i]]);
                        $model->shift_id = $syif;
                        $model->tarikh = $year . '-' . $month . '-' . $i;
                        $model->year = "$year";
                        $model->month = "$month";
                        $staff = TblStaffKeselamatan::find()->where(['staff_icno' => $model->icno])->one();
                        $model->unit_id = $staff->unit_id;
                        $model->campus_id = $staff->campus_id;
                        $model->pos_kawalan_id = (string) $sheetData[1]['B'];;
                        $model->save();
                        $dayscount--;
                        $i++;
                    }
                    $dayscount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    $baseRow++;
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jadual Lebih Masa Berjadual Berjaya Di Muat Naik']);
                return $this->redirect('import-ot');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }

        return $this->render('import-ot', [
            'modelImport' => $modelImport,
        ]);
    }

    public function actionImportHakiki()
    {
        $modelImportHakiki = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);
        $modelImportHakiki->addRule(['fileImport'], 'required');
        $modelImportHakiki->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx'], ['maxSize' => 1024 * 1024]);

        if (Yii::$app->request->post()) {
            $modelImportHakiki->fileImport = \yii\web\UploadedFile::getInstance($modelImportHakiki, 'fileImport');
            if ($modelImportHakiki->fileImport && $modelImportHakiki->validate()) {
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($modelImportHakiki->fileImport->tempName);
                $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImportHakiki->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $baseRow = 2;
                $year = date('Y');
                // $month = date('m', strtotime('+10 day'));
                $month = "05";

                //                $month = date('m'); //testing purpose
                //                var_dump($month);
                $dayscount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                //                var_dump($dayscount);die;
                $column = ['', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI'];

                while (!empty($sheetData[$baseRow]['A'])) {
                    //var_dump($sheetData[$baseRow]['B']);die;

                    $i = 1;
                    while ($dayscount >= 1) {
                        $model = new TblShiftKeselamatan();
                        $umsper = $this->umsper($sheetData[$baseRow]['B']);
                        $model->icno = $umsper;
                        $syif = $this->syif($sheetData[$baseRow][$column[$i]]);
                        $model->shift_id = $syif;
                        $model->tarikh = $year . '-' . $month . '-' . $i;
                        // var_dump($model->tarikh);die;
                        $model->year = "$year";
                        $model->month = "$month";
                        $staff = TblStaffKeselamatan::find()->where(['staff_icno' => $model->icno])->one();
                        $model->unit_id = $staff->unit_id;
                        $model->campus_id = $staff->campus_id;
                        $model->pos_kawalan_id = (string) $sheetData[1]['B'];;
                        $model->save();
                        $dayscount--;
                        $i++;
                    }
                    $dayscount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    $baseRow++;
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jadual Hakiki Berjaya Di Muat Naik']);
                return $this->redirect('import-hakiki');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }

        return $this->render('import-hakiki', [
            'modelImportHakiki' => $modelImportHakiki,
        ]);
    }

    public function actionImport()
    {
        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);
        $modelImport->addRule(['fileImport'], 'required');
        $modelImport->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx'], ['maxSize' => 1024 * 1024]);

        if (Yii::$app->request->post()) {
            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');
            if ($modelImport->fileImport && $modelImport->validate()) {
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($modelImport->fileImport->tempName);
                $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $baseRow = 2;
                while (!empty($sheetData[$baseRow]['A'])) {
                    $model = new \app\models\keselamatan\TblStaffKeselamatan;
                    $validate = (new \yii\db\Query())
                        ->select(['staff_icno'])
                        ->from('keselamatan.tbl_staff_keselamatan')
                        ->where(['staff_icno' => (string) $sheetData[$baseRow]['A']])
                        ->andWhere(['month' => date('m')])
                        ->all();
                    //                  
                    if ($validate) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'success', 'msg' => 'Data di Baris ' . $baseRow . ' sudah wujud']);
                        return $this->redirect('import');
                    } else {
                        //                        VarDumper::dump($sheetData[$baseRow]['A']);die;
                        //                        $syif = $this->syif($sheetData[$baseRow]['A']);
                        $pos = $this->pos($sheetData[$baseRow]['B']);
                        //                        var_dump($pos);die;
                        $unit = $this->unit($sheetData[$baseRow]['C']);
                        $umsper = $this->umsper($sheetData[$baseRow]['A']);
                        $kp = $this->kp($sheetData[$baseRow]['D']);
                        $pkp = $this->pkp($sheetData[$baseRow]['E']);
                        //                        var_dump("$kp");die;
                        $model->staff_icno = $umsper;
                        //                                (string) $sheetData[$baseRow]['A'];
                        //                        var_dump($model->staff_icno);
                        $model->pos_kawalan_id = $pos;
                        $model->campus_id = (string) $sheetData[$baseRow]['H'];
                        $model->unit_id = $unit;
                        $model->isActive = '1';
                        $model->added_by = Yii::$app->user->getId();
                        $model->created_at = date('Y-m-d H:i:s');
                        $model->ketua_pos = "$kp";
                        $model->penolong_ketua_pos = "$pkp";
                        $model->month = (string) $sheetData[$baseRow]['F'];
                        $model->year = (string) $sheetData[$baseRow]['G'];
                        $model->save();
                        $baseRow++;
                    }
                }
                Yii::$app->getSession()->setFlash('success', 'Success');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }

        return $this->render('import', [
            'modelImport' => $modelImport,
        ]);
    }

    public function kp($kp)
    {
        if ($kp !== NULL) {
            $val1 = 1;
        } else {
            $val1 = 0;
        }
        //  var_dump($val1);die;
        return $val1;
    }

    public function pkp($pkp)
    {
        if ($pkp !== NULL) {
            $val1 = 1;
        } else {
            $val1 = 0;
        }
        //  var_dump($val1);die;
        return $val1;
    }

    public function umsper($umsper)
    {
        $val = (new \yii\db\Query())
            ->select(['ICNO'])
            ->from('hronline.tblprcobiodata')
            ->where(['COOldID' => $umsper])
            ->one();
        //        var_dump($val);die;
        if ($val) {
            $val1 = $val['ICNO'];
        }
        return $val1;
    }

    public function syif($syif)
    {
        // var_dump($syif);die;
        $val = (new \yii\db\Query())
            ->select(['id'])
            ->from('keselamatan.ref_shifts')
            ->where(['jenis_shifts' => $syif])
            ->one();
        // if ($val) {
        if (!$val) {
            $val1 = "10";
        } else {
            $val1 = $val['id'];
        }
        // }
        //  var_dump($val1);die;
        return $val1;
    }
    public function syifOvertime($syif)
    {
        // var_dump($syif);die;
        $val = (new \yii\db\Query())
            ->select(['id'])
            ->from('keselamatan.ref_shifts')
            ->where(['jenis_shifts' => $syif])
            ->one();
        // if ($val) {
        if (!$val) {
            $val1 = "1";
        } else {
            $val1 = $val['id'];
        }
        // }
        //  var_dump($val1);die;
        return $val1;
    }

    public function unit($unit)
    {
        $val = (new \yii\db\Query())
            ->select(['id'])
            ->from('keselamatan.ref_unit')
            ->where(['unit_name' => $unit])
            ->one();
        if ($val) {
            $val1 = $val['id'];
        }
        //  var_dump($val1);die;
        return $val1;
    }

    public function pos($pos)
    {
        //        $val = '';
        //  var_dump($pos);die;
        $val = (new \yii\db\Query())
            ->select(['id'])
            ->from('keselamatan.ref_pos_kawalan')
            ->where(['pos_kawalan' => $pos])
            ->one();
        if ($val) {
            $val1 = $val['id'];
        }
        //  var_dump($val1);die;d
        return $val1;
    }

    /**
     * Deletes an existing TblRekod model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['staff-list']);
    }

    public function actionDeleted($id)
    {
        $admin = TblAkses::findOne(['id' => $id]);
        $admin->delete();
        if (TblAkses::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->redirect(['akses-pengguna']);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionUpdateAkses($id)
    {
        $model = TblAkses::findOne(['id' => $id]);
        //        = TblStaffKeselamatan::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tarikh Permohonan Jawatan telah Berjaya dikemaskini!']);
                return $this->redirect(['akses-pengguna']);
            }
        }
        return $this->render('update-akses', [
            'model' => $model,
            'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
        ]);
    }

    public function actionReport($id, $tahun, $bulan)
    {
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);


        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');
        //        var_dump($var);die;
        $month = TblRekod::viewBulan($bulan);
        // var_dump($month);
        // die;
        $this->view->title = "Laporan Kehadiran Hakiki Bulan ($month)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_monthlyReport', ['biodata' => $biodata, 'tahun' => $tahun, 'bulan' => $bulan, 'var' => $var, 'icno' => $id]);

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
    public function actionReportOt($id, $tahun, $bulan)
    {
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');
        //    var_dump($var);die;
        $month = TblRekodOt::viewBulan($bulan);
        // var_dump($month);die;
        $this->view->title = "Laporan Kehadiran Lebih Masa Jadual Bulan ($month)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_monthlyReportOt', ['biodata' => $biodata, 'tahun' => $tahun, 'bulan' => $bulan, 'var' => $var, 'icno' => $id]);

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
    public function actionReportLmt($id, $tahun, $bulan)
    {
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');
        //    var_dump($var);die;
        $month = TblRekodOt::viewBulan($bulan);
        // var_dump($month);die;
        $this->view->title = "Laporan Kehadiran Lebih Masa Tambahan Bulan ($month)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_monthlyReportLmt', ['biodata' => $biodata, 'tahun' => $tahun, 'bulan' => $bulan, 'var' => $var, 'icno' => $id]);

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
    //monthly report pr
    public function actionReportBulanan($id, $tahun, $bulan)
    {
        // var_dump($id,$tahun,$bulan);die;

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');
        $month = TblRekod::viewBulan($bulan);
        // var_dump($month);
        // die;
        $this->view->title = "Laporan Kehadiran Hakiki Bulan ($month)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_printReportMonthly', ['biodata' => $biodata, 'tahun' => $tahun, 'bulan' => $bulan, 'var' => $var, 'icno' => $id]);

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
                'SetHeader' => ["Laporan Bulanan Rollcall ($month)"],
                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                //                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    /**
     * Finds the TblRekod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblRekod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCutiIndex()
    {
    }

    public function actionCutiRehatDalamNegara()
    {
        $icno = Yii::$app->user->getId();
        $cutiRekod = \app\models\keselamatan\cuti::getBakiLatests($icno);
        $thtc = TblRollcall::find()->where(['anggota_icno' => $icno])->where(['THTC' => '1'])->count();
        //        var_dump($thtc);die;
        $layak = Layak::getBakiLatest($icno) - $cutiRekod;
        //        - $thtc;
        //        var_dump($layak);die;
        $model = TblSetPegawai::find()->where(['pemohon_icno' => $icno])->one();

        $model2 = new \app\models\keselamatan\cuti();
        //        $model->scenario = "cutimula";

        $ddate = date('Y-m-d');
        $date = new DateTime($ddate);
        $week = $date->format("W");
        if ($model2->load(Yii::$app->request->post())) {
            $date2 = date_create("$model2->cuti_tamat");
            $date1 = date_create("$model2->cuti_mula");
            $diff = date_diff($date1, $date2);
            $day = new DateTime($model2->cuti_mula);
            $day1 = $day->format("d");
            $model2->cuti_tempoh = $diff->format("%a") + 1;
            $model2->cuti_icno = $icno;
            //for a while
            $id = 1;
            $query = \app\models\cuti\JenisCuti::find()->where(['jenis_cuti_id' => $id])->one();
            //            if ($day1 > 17) {
            //                $peg1 = $this->pegMedan($week);
            //                $model2->cuti_peraku_oleh = $peg1;
            //                $model2->cuti_lulus_oleh = $peg1;
            //            } else {
            $model2->cuti_peraku_oleh = $model->peraku_icno;
            $model2->cuti_lulus_oleh = $model->pelulus_icno;
            //            }
            $model2->cuti_jenis_id = $query->jenis_cuti_id;
            $model2->cuti_mohon_pada = date('Y-m-d h:i:s');
            $model2->cuti_status_peraku = 'TT';
            $model2->cuti_status_lulus = 'TT';
            $model2->cuti_session_ip = $this->getRealUserIp();

            if ($model2->save(false)) {

                //                $model2->staff_icno = $model->staff_icno;

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => '!']);
                return $this->redirect(['senarai-permohonan-cuti']);
            }
        }
        return $this->render('cuti-rehat-dalam-negara', [
            'model' => $model,
            'model2' => $model2,
            'layak' => $layak
        ]);
    }

    public function actionCutiKecemasan()
    {
        $icno = Yii::$app->user->getId();
        $cutiRekod = \app\models\keselamatan\cuti::getBakiLatests($icno);
        $layak = Layak::getBakiLatest($icno) - $cutiRekod;
        $model = TblSetPegawai::find()->where(['pemohon_icno' => $icno])->one();
        $model2 = new \app\models\keselamatan\cuti();
        //        $model->scenario = "cutimula";

        $ddate = date('Y-m-d');
        $date = new DateTime($ddate);
        $week = $date->format("W");
        if ($model2->load(Yii::$app->request->post())) {
            $date2 = date_create("$model2->cuti_tamat");
            $date1 = date_create("$model2->cuti_mula");
            $diff = date_diff($date1, $date2);
            $day = new DateTime($model2->cuti_mula);
            $day1 = $day->format("d");
            $model2->cuti_tempoh = $diff->format("%a") + 1;
            $model2->cuti_icno = $icno;
            //for a while
            $id = 1;
            $query = \app\models\cuti\JenisCuti::find()->where(['jenis_cuti_id' => $id])->one();
            //            if ($day1 > 17) {
            //                $peg1 = $this->pegMedan($week);
            //                $model2->cuti_peraku_oleh = $peg1;
            //                $model2->cuti_lulus_oleh = $peg1;
            //            } else {
            $model2->cuti_peraku_oleh = $model2->cuti_lulus_oleh;
            //            $model2->cuti_lulus_oleh = $model->pelulus_icno;
            //            }
            $model2->cuti_jenis_id = $query->jenis_cuti_id;
            $model2->cuti_mohon_pada = date('Y-m-d h:i:s');
            $model2->cuti_status_peraku = 'TT';
            $model2->cuti_status_lulus = 'TT';
            $model2->cuti_session_ip = $this->getRealUserIp();

            if ($model2->save(false)) {

                //                $model2->staff_icno = $model->staff_icno;

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => '!']);
                return $this->redirect(['senarai-permohonan-cuti']);
            }
        }
        return $this->render('cuti-kecemasan', [
            'model' => $model,
            'model2' => $model2,
            'layak' => $layak
        ]);
    }

    public function actionApproveCuti()
    {
        $icno = Yii::$app->user->getId();
        $model = \app\models\keselamatan\cuti::find()->where(['cuti_peraku_oleh' => $icno])
            ->andWhere(['cuti_jenis_id' => ['1', '2']])->andWhere(['cuti_status_peraku' => "TT"])->all();
        return $this->render('approve-cuti', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionApprovedCuti($id)
    {
        $model = \app\models\keselamatan\cuti::find()->where(['cuti_rekod_id' => $id])->one();
        if ($model->load(Yii::$app->request->post())) {
            //              var_dump($model->cuti_status_peraku);die;
            if (($model->cuti_status_peraku) == "TL") {
                $model->cuti_status_lulus = $model->cuti_status_peraku;
            } else {
                $model->cuti_status_lulus = "TT";
            }
            $model->cuti_peraku_pada = date('Y-m-d h:i:s');
            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tarikh Permohonan Jawatan telah Berjaya dikemaskini!']);
                return $this->redirect(['approve-cuti']);
            }
        }
        return $this->renderAjax('approved-cuti', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionLulusCuti()
    {
        $icno = Yii::$app->user->getId();
        $model = \app\models\keselamatan\cuti::find()->where(['cuti_lulus_oleh' => $icno])
            ->andWhere(['cuti_jenis_id' => ['1', '2']])->andWhere(['cuti_status_lulus' => "TT"])->all();
        return $this->render('lulus-cuti', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    //bru la lulus cuti dan masuk ke rekod cuti

    public function actionLuluskanCuti($id)
    {

        $model = \app\models\keselamatan\cuti::find()->where(['cuti_rekod_id' => $id])->one();
        $noti = TblStaffKeselamatan::find()->where(['staff_icno' => $model->cuti_icno])->one();
        //        $hntrnotiicno = TblAkses::find()->select('icno')->where(['campus_id' => '1'])->all();
        //        $query = TblPermohonan::find()->select('icno,dept_id')->distinct()->where(['app_by' => $icno])->andWhere(['in', 'status_kj', $status]);
        //        var_dump($noti->campus_id);die;
        $cuti = new CutiRekod();
        if ($model->load(Yii::$app->request->post())) {
            //            VarDumper::dump($model);die;
            $cuti->cuti_icno = $model->cuti_icno;
            $cuti->cuti_mula = $model->cuti_mula;
            $cuti->cuti_tamat = $model->cuti_tamat;
            $cuti->cuti_catatan = $model->cuti_catatan;
            $cuti->cuti_tempoh = $model->cuti_tempoh;
            $cuti->cuti_jenis_id = $model->cuti_jenis_id;
            $cuti->cuti_session_id = $model->cuti_session_id;
            $cuti->cuti_session_ip = $model->cuti_session_ip;
            $cuti->cuti_peraku_oleh = $model->cuti_peraku_oleh;
            $cuti->cuti_lulus_oleh = $model->cuti_lulus_oleh;
            $cuti->cuti_status_peraku = $model->cuti_status_lulus;
            $cuti->cuti_status_lulus = $model->cuti_status_lulus;
            $cuti->cuti_mohon_pada = $model->cuti_mohon_pada;
            $cuti->cuti_peraku_pada = $model->cuti_peraku_pada;
            $cuti->cuti_lulus_pada = $model->cuti_lulus_pada;
            $cuti->cuti_peraku_pada = $model->cuti_catatan_peraku;
            $cuti->cuti_catatan_lulus = $model->cuti_catatan_lulus;
            //            $model->cuti_status_lulus = "L";
            $model->cuti_lulus_pada = date('Y-m-d h:i:s');

            $model->cuti_peraku_pada = date('Y-m-d h:i:s');
            if ($model->save() && $cuti->save()) {
                //bagi notification kepada semua do, pegawai, penyelia jadual,dan anggota bercuti
                $this->Notification($model->cuti_icno, 'Cuti', 'Permohonan Cuti Anda Telah Diambil Tindakan .Sila Rujuk Senarai Permohonan Cuti Anda.');
                $hntr_noti = TblAkses::find()->select('icno')->where(['campus_id' => $noti->campus_id])->andWhere(['isActive' => 1])->all();
                $bio = Tblprcobiodata::find()->where(['ICNO' => $model->cuti_icno])->one();
                foreach ($hntr_noti as $a) {
                    $this->Notification($a->icno, 'Cuti', 'Adalah Dimaklumkan Bahawa ' . $bio->CONm . ' Akan Bercuti Pada ' . $model->cuti_mula . ' Hingga ' . $model->cuti_tamat . '. Terima Kasih.');
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Perakuan Cuti Telah Dibuat!']);
                return $this->redirect(['lulus-cuti']);
            }
        }
        return $this->renderAjax('luluskan-cuti', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionListCuti($id)
    {

        $model = CutiRekod::find()->where(['cuti_icno' => $id])->andWhere(['cuti_jenis_id' => ['1', '2']])->all();

        //        var_dump($model);die;
        return $this->renderAjax('list-cuti', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionListSts($id, $month, $year)
    {
        $date = DateTime::createFromFormat("Y-n", "$year-$month");
        $day = $date->format("t");
        $mula = "$year-$month-01";
        $end = "$year-$month-$day";

        $model = TblRollcall::find()->where(['between', 'date', $mula, $end])->andWhere(['year' => $year])->andWhere(['anggota_icno' => $id])->andWHere(['NOT IN', 'status', ['SIMPAN', 'NO_STS', '']])->all();
        $totalSts = TblRollcall::find()->where(['between', 'date', $mula, $end])->andWhere(['year' => $year])->andWhere(['anggota_icno' => $id])->andWhere(['IN', 'status', ['APPROVED', 'REMARKED', 'REJECTED', 'STS']])->count();
        $stsApproved = TblRollcall::find()->where(['between', 'date', $mula, $end])->andWhere(['year' => $year])->andWhere(['anggota_icno' => $id])->andWhere(['=', 'status', 'APPROVED'])->count();
        $stsRejected = TblRollcall::find()->where(['between', 'date', $mula, $end])->andWhere(['year' => $year])->andWhere(['anggota_icno' => $id])->andWhere(['IN', 'status', ['REJECTED', 'AUTOREJECT']])->count();

        return $this->renderAjax('list-sts', [
            'model' => $model,
            'bil' => 1,
            'stsApproved' => $stsApproved,
            'stsRejected' => $stsRejected,
            'totalSts' => $totalSts,
            'month' => $month,
        ]);
    }

    public function actionSenaraiCutiDiluluskan()
    {
        $icno = Yii::$app->user->getId();

        $dept = TblShiftKeselamatan::findOne(['icno' => $icno]);
        if (!$dept) {
            $dept = TblAkses::findOne(['icno' => $icno]);
        }
        // var_dump($dept);die;
        $end_sql = 'SELECT * FROM keselamatan.`tbl_tukar_syif` a 
        LEFT JOIN keselamatan.`tbl_shift_keselamatan` b ON b.`icno` = a.`pemohon_icno`
        WHERE a.`status_pelulus` = "L" AND b.`campus_id` =:camp GROUP BY a.`pemohon_icno`
        ORDER BY a.`tarikh_tukar` DESC';
        $syif = TblTukarSyif::findBySql($end_sql, [':camp' => $dept->campus_id])->all();

        // $cuti_rekod = \app\models\keselamatan\cuti::find()->where(['cuti_status_lulus' => 'L'])->orderBy(['cuti_mula' => SORT_DESC])->all();
        // $cuti_rekod = TblRecords::find()->where(['status'=>'APPROVED'])->orderBy(['start_date'=>SORT_DESC])->all();
        $sts = TblRollcall::find()->where(['do_icno' => $icno])->andWhere(['!=', 'status', 'NO_STS'])->orderBy(['status' => SORT_ASC])->all();
        // $syif = TblTukarSyif::find()->where(['status_pelulus' => 'L'])->orderBy(['tarikh_tukar' => SORT_ASC])->all();
        //    var_dump($cuti_rekod);die;
        return $this->render('senarai-cuti-diluluskan', [
            'syif' => $syif,
            'bil' => 1,
            // 'cuti_rekod' => $cuti_rekod,
            'sts' => $sts,
        ]);
    }

    public function actionSenaraiPermohonanCuti()
    {
        $id = Yii::$app->user->getId();

        $model = CutiRekod::find()->where(['cuti_icno' => $id])->andWhere(['cuti_jenis_id' => ['1', '2']])->orderBy(['cuti_mula' => SORT_DESC])->all();
        $model2 = \app\models\keselamatan\cuti::find()->where(['cuti_icno' => $id])->andWhere(['cuti_jenis_id' => ['1', '2']])->all();
        //        var_dump($model2);die;
        return $this->render('senarai-permohonan-cuti', [
            'model' => $model,
            'model2' => $model2,
            'bil' => 1,
        ]);
    }

    public function actionMohonTukarSyif()
    {

        //        $icno = Yii::$app->user->getId();
        //        $model2 = new \app\models\keselamatan\TblTukarSyif();
        return $this->render('mohon-tukar-syif', []);
    }

    public function actionTukarSyif($date = null)
    {
        $icno = Yii::$app->user->getId();
        $self = TblShiftKeselamatan::find()->where(['icno' => $icno])->andWhere(['tarikh' => $date])->one();
        if($self){
            $self = $self->wp->details;
        }else{
            $self = 'Tiada Syif Ditemui';
        }
        if ($date != null) {
            $penganti = TblShiftKeselamatan::find()->where(['tarikh' => $date])->andWhere(['!=', 'icno', $icno])->all();
        } else {
            $penganti = TblShiftKeselamatan::find()->all();
        }
        $model = SetPegawai::find()->where(['pemohon_icno' => $icno])->one();
        $model2 = new TblTukarSyif();
        $model2->scenario = 'reason';


        if ($model2->load(Yii::$app->request->post())) {
            $self = TblShiftKeselamatan::find()->where(['icno' => $icno])->andWhere(['tarikh' => $date])->one();

            $set = TblShiftKeselamatan::find()->where(['id' => $model2->shift_id])->one();
            $model2->pemohon_icno = $icno;
            $model2->tarikh_permohonan = date('Y-m-d H:i:s');
            $model2->penganti_icno = $set->icno;
            $model2->pelulus_icno = $model->pelulus_icno;
            $model2->tarikh_tukar = $date;
            $model2->status_p = 'TT';
            // var_dump($self->shift_id);die;

            $model2->tukar_shift_id = $set->shift_id;
            $model2->curr_shift_id = $self->shift_id;
            $model2->tukar_shift_keselamatan_id = $self->id;

            if ($model2->save(false)) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => '!']);
                return $this->redirect(['permohonan-tukar-syif']);
            }
        }
        return $this->render('tukar-syif', [
            'model' => $model,
            'model2' => $model2,
            'penganti' => $penganti,
            'date' => $date,
            'bil' => 1,
            'self' => $self
        ]);
    }

    public function actionPermohonanTukarSyif()
    {
        $icno = Yii::$app->user->getId();
        $model = TblTukarSyif::find()->where(['pemohon_icno' => $icno])->all();
        //        var_dump($model);die;
        return $this->render('permohonan-tukar-syif', [
            'model' => $model,
            'bil' => 1
        ]);
    }

    public function actionSetujuTukarSyif()
    {
        $icno = Yii::$app->user->getId();
        $model = TblTukarSyif::find()->where(['penganti_icno' => $icno])->andWhere(['status_p' => 'TT'])->all();

        //        var_dump($model);die;
        return $this->render('setuju-tukar-syif', [
            'model' => $model,
            'bil' => 1
        ]);
    }

    public function actionSetujuPenukaranSyif($id)
    {
        $model = TblTukarSyif::find()->where(['id' => $id])->one();
        if ($model->load(Yii::$app->request->post())) {
            //              var_dump($model->cuti_status_peraku);die;
            if (($model->status_p) == "L") {
                $model->status_pelulus = "TT";
            }
            $model->penganti_peraku_dt = date('Y-m-d h:i:s');
            if ($model->save(false)) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Anda Telah Membuat Perakuan Bagi Permohonan Tukar Syif!']);
                return $this->redirect(['setuju-tukar-syif']);
            }
        }
        return $this->renderAjax('setuju-penukaran-syif', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionSenaraiTukarSyifDipersetuju()
    {
        $icno = Yii::$app->user->getId();
        $model = TblTukarSyif::find()->where(['pelulus_icno' => $icno])->andWhere(['status_pelulus' => 'TT'])->all();

        //        var_dump($model);die;
        return $this->render('senarai-tukar-syif-dipersetuju', [
            'model' => $model,
            'bil' => 1
        ]);
    }

    public function actionPegawaiLuluskanPenukaran($id)
    {
        $model = TblTukarSyif::find()->where(['id' => $id])->one();
        $model1 = TblTukarSyif::find()->where(['id' => $id])->one();
        //syif yg dipohon
        //syif pemohon
        if ($model->load(Yii::$app->request->post())) {
            $syif = TblShiftKeselamatan::find()->where(['id' => $model1->shift_id])->one();
            $syif1 = TblShiftKeselamatan::find()->where(['id' => $model->tukar_shift_keselamatan_id])->one();
            Yii::$app->db->createCommand()->update('keselamatan.tbl_shift_keselamatan', ['shift_id' => $syif1->shift_id], ['id' => $model1->shift_id])->execute();
            Yii::$app->db->createCommand()->update('keselamatan.tbl_shift_keselamatan', ['shift_id' => $syif->shift_id], ['id' => $model1->tukar_shift_keselamatan_id])->execute();


            if ($model->status_pelulus == "TL") {
                $stat = "Tidak Diluluskan";
            } else {
                $stat = "Diluluskan";
            }
            $model->perakuan_pelulus_dt = date('Y-m-d h:i:s');
            if ($model->save()) {

                $ntf = new Notification();
                $ntf->icno = $model->pemohon_icno;
                $ntf->title = 'Permohonan Penukaran Syif';
                $ntf->content = "Permohonan Penukaran Syif anda Pada Tarikh Berikut : " . $model->tarikh_tukar . " adalah " . $stat . ".";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya!']);
                return $this->redirect(['senarai-tukar-syif-dipersetuju']);
            }
        }
        return $this->renderAjax('pegawai-luluskan-penukaran', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionVerifying($id, $syif, $date)
    {
        // var_dump($id, $syif, $date);die;
        $model = TblRollCall::find()->where(['verified_by' => $id])->andWhere(['syif' => $syif])->andWhere(['date' => $date])->andWhere(['verified_stat' => 'PENDING'])->all();
        $model1 = TblRollCall::find()->where(['verified_by' => $id])->andWhere(['syif' => $syif])->andWhere(['date' => $date])->andWhere(['verified_stat' => 'PENDING'])->one();
        // $model1->scenario = 'ulasan';
        if ($model1->load(Yii::$app->request->post())) {

            foreach ($model as $var) {
                $verify = TblRollCall::findOne($var->id);
                // $verify->scenario = 'ulasan';
                // var_dump($verify->verified_by );
                $verify->verified_dt = date('Y-m-d H:i:s');
                $verify->verified_stat = 'VERIFIED';
                $verify->verifier_comment = $model1->verifier_comment;
                $verify->update();
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Telah Di Sahkan']);
            return $this->redirect(['keselamatan/report-to-verify']);
        }
        return $this->renderAjax('verifying', [
            'model' => $model,
            'model1' => $model1,
            'bil' => 1,
        ]);
    }
    // public function actionDebugClockout($){

    // }
    public function actionSendToVerify($id, $syif, $date)
    {
        $model = TblRollCall::find()->where(['do_icno' => $id])->andWhere(['syif' => $syif])->andWhere(['date' => $date])->all();
        if (!$model) {
            $model = TblRollCall::find()->where(['penganti_do_icno' => $id])->andWhere(['syif' => $syif])->andWhere(['date' => $date])->all();
        }
        $campus = TblAkses::findOne(['icno' => $id]);

        $pm = TblJadualDoPm::find()->where(['tarikh' => $date])->andWhere(['campus_id' => $campus->campus_id])->andWhere(['shift_id' => 16])->one();
        if (!$pm) {
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Pegawai Medan Belum ditetapkan. Sila Berhubung dengan penyelia jadual anda']);
            return $this->redirect(['keselamatan/ringkasan-laporan', 'syif' => $syif, 'tarikh' => $date]);
        }
        foreach ($model as $var) {
            $verify = TblRollCall::findOne($var->id);
            // var_dump($verify->verified_by );
            $verify->verified_by = $pm->icno;
            $verify->sent_by = $id;
            $verify->report_dt = date('Y-m-d H:i:s');
            $verify->verified_stat = 'PENDING';
            // $model->name = 'YII';
            // $model->email = 'yii2@framework.com';
            $verify->update(false);
        }
        $ntf = new Notification();
        $ntf->icno = $pm->icno;
        $ntf->title = 'Pengesahan Laporan Harian BKUMS';
        $ntf->content = "Laporan Harian Menunggu untuk disahkan oleh anda ";
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Telah Dihantar Kepada Pegawai Medan']);
        return $this->redirect(['keselamatan/ringkasan-laporan', 'syif' => $syif, 'tarikh' => $date]);
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
        $sql = 'SELECT b.`CONm`,c.`shortname`,
        SUM(IF(a.`remark_status` != "APPROVED",a.`absent`,0)) ,SUM(IF(a.`remark_status` != "APPROVED",a.`external`,0)) ,
        SUM(IF(a.`remark_status` != "APPROVED",a.`incomplete`,0)),SUM(IF(a.`remark_status` != "APPROVED",a.`status_in`,0)),
        SUM(IF(a.`remark_status` != "APPROVED",a.`status_out`,0)) 
          FROM keselamatan.`tbl_rekod` a 
        LEFT JOIN hronline.`tblprcobiodata` b ON b.`ICNO` = a.`icno`
        LEFT JOIN hronline.`department` c ON c.`id` = b.`DeptId`
        WHERE YEAR(a.`tarikh`) =: yr AND MONTH(a.`tarikh`) =: mth AND c.`id` =: dept
        GROUP BY YEAR(`a`.`tarikh`),MONTH(`a`.`tarikh`),`a`.`icno`
        ORDER BY MONTH(`a`.`tarikh`)';
        // 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        // $start_date_exist = TblRecords::findBySql($start_sql, [':icno' => $icno, ':date' => $start_date])->exists();
        // $query = TblRekod::find()->where(['yr' => $tahun, 'mth' => $bulan, 'dept' => $arr_dept]);
        $query = TblRecords::findBySql($sql, [':yr' => $tahun, ':mth' => $bulan, ':dept' => $arr_dept]);
        // var_dump($query);die;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //  MonthData::find()->where(['dept_id' => $arr_dept, 'bulan' => $bulan, 'tahun' => $tahun]),
            'pagination' => true,
        ]);


        return $this->render('sup-mth-rpt', ['isAdmin' => $isAdmin, 'model' => $model, 'today' => $bulan, 'tahun' => $tahun, 'bil' => 1, 'dataProvider' => $dataProvider, 'dept_id' => $dept_id, 'model_dept' => $model_dept]);
    }

    //list report to verify
    public function actionReportToVerify()
    {
        $id = Yii::$app->user->getId();

        // echo $id;die;
        $admin = TblAkses::findOne(['akses_level' => 1, 'icno' => $id]);
        $kbk = 690312065577;
        // $v = false;
        if ($kbk == $id || $admin) {
            // echo 'd';die;
            $verified = TblRollcall::find()->select('date,syif,verified_stat,verified_by')->distinct()->where(['verified_by' => $id])->andWhere(['verified_stat' => 'VERIFIED'])->all();
            $report = TblRollcall::find()->select('date,syif,verified_stat,verified_by')->distinct()->where(['IN', 'verified_stat', ['PENDING']])->orderBy(['verified_stat' => 'ASC'])->all();
        } else {
            $report = TblRollcall::find()->select('date,syif,verified_stat,verified_by')->distinct()->where(['verified_by' => $id])->andWhere(['verified_stat' => 'PENDING'])->all();
            $verified = TblRollcall::find()->select('date,syif,verified_stat,verified_by')->distinct()->where(['verified_by' => $id])->andWhere(['verified_stat' => 'VERIFIED'])->all();
        }
        // var_dump($report);die;
        return $this->render('report-to-verify', [
            'report' => $report,
            'verified' => $verified,
            'bil' => 1,
            // 'v'=>$v,

        ]);
    }

    //verifying report
    public function actionVerifyingReport($syif, $date, $id)
    {
        // var_dump($id);die;
        $v_name = "";
        $v_date = "";
        $model = TblRollCall::find()->where(['verified_by' => $id])->andWhere(['syif' => $syif])->andWhere(['date' => $date])->all();
        $campus = TblAkses::findOne(['icno' => $id]);
        $syifId = RefShifts::find()->where(['jenis_shifts' => $syif])->one();
        $v_sender = TblRollcall::find()->where(['date' => $date])->andWhere(['syif' => $syif])->andWhere(['campus_id' => $campus->campus_id])->andWhere(['IN', 'verified_stat', ['VERIFIED', 'PENDING']])->andWhere(['verified_by' => $id])->one();
        $verifier = TblRollcall::find()->where(['date' => $date])->andWhere(['syif' => $syif])->andWhere(['campus_id' => $campus->campus_id])->andWhere(['IN', 'verified_stat', ['VERIFIED']])->one();
        $s_name = Tblprcobiodata::findOne(['ICNO' => $v_sender->sent_by]);
        if ($verifier) {
            $vname = Tblprcobiodata::findOne(['ICNO' => $verifier->verified_by]);
            $v_name = $vname->CONm;
            $v_date = $verifier->verified_dt;
        }
        $thh = TblRollcall::find()->where(['date' => $date])->andWhere(['syif' => $syif])->andWhere(['=', 'THH', '1'])->andWhere(['campus_id' => $campus->campus_id])->andWhere(['verified_by' => $id])->all();
        $thlmj = TblRollcall::find()->where(['date' => $date])->andWhere(['syif' => $syif])->andWhere(['=', 'THLMJ', '1'])->andWhere(['campus_id' => $campus->campus_id])->andWhere(['verified_by' => $id])->all();
        $thlmt = TblRollcall::find()->where(['date' => $date])->andWhere(['syif' => $syif])->andWhere(['THLMT' => 1])->andWhere(['campus_id' => $campus->campus_id])->andWhere(['verified_by' => $id])->all();
        $thb = TblRollcall::find()->where(['date' => $date])->andWhere(['campus_id' => $campus->campus_id])->andWhere(['syif' => $syif])->andWhere([

            'or',

            ['=', 'THBH', '1'],
            ['=', 'THBLMJ', '1'],
            ['=', 'THBLMT', '1'],
            ['=', 'THBKWLN', '1'],

        ])->andWhere(['verified_by' => $id])->all();

        $jumlah1 = TblShiftKeselamatan::find()->where(['tarikh' => $date])->andWhere(['shift_id' => $syifId->id])->andWhere(['campus_id' => $campus->campus_id])->count();
        $jumlah2 = TblOt::find()->where(['tarikh' => $date])->andWhere(['shift_id' => $syifId->id])->andWhere(['campus_id' => $campus->campus_id])->count();
        $jumlah3 = TblLmt::find()->where(['tarikh' => $date])->andWhere(['lmt_id' => $syifId->id])->andWhere(['campus_id' => $campus->campus_id])->count();

        $hadirH = TblRollcall::find()->where(['date' => $date])->andWhere(['syif' => $syif])->andWhere(['HH' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
        $hadirLMJ = TblRollcall::find()->where(['date' => $date])->andWhere(['syif' => $syif])->andWhere(['HLMJ' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
        $hadirLMT = TblRollcall::find()->where(['date' => $date])->andWhere(['syif' => $syif])->andWhere(['HLMT' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();

        // var_dump($hadirH);die;
        $jumlah = $jumlah1 + $jumlah2 + $jumlah3;
        $hadir = $hadirH + $hadirLMJ + $hadirLMT;

        $Thadir = $jumlah - $hadir;
        $ulasan = TblLaporanKejadian::find()->where(['date' => $date])->andWhere(['syif' => $syif])->andWhere(['campus_id' => $campus->campus_id])->all();
        $odometer = \app\models\keselamatan\TblOdometer::find()->where(['date' => $date])->andWhere(['syif' => $syif])->andWhere(['campus_id' => $campus->campus_id])->all();
        $report = TblRollcall::find()->where(['date' => $date])->andWhere(['syif' => $syif])->andWhere(['verified_by' => $id])->andWhere(['verified_stat' => 'VERIFIED'])->andWhere(['campus_id' => $campus->campus_id])->one();
        if ($report) {
            $pm = $report->verifier_comment;
        } else {
            $pm = "";
        }
        return $this->render('verifying-report', [
            'syif' => $syif,
            'pm' => $pm,
            //   'var' => $var,
            //   'todaydt' => $todaydt,
            //   'laporan' => $laporan,
            //   'biodata' => $biodata,
            'thh' => $thh,
            'thb' => $thb,
            'jumlah' => $jumlah,
            'hadir' => $hadir,
            'Thadir' => $Thadir,
            'odometer' => $odometer,
            'thlmj' => $thlmj,
            'thlmt' => $thlmt,
            'bil' => 1,
            'bil1' => 1,
            'model' => $model,
            //   'model2' => $model2,
            'ulasan' => $ulasan,
            //   'do_bertugas'=>$do_bertugas,
            //   'do_name'=>$do_name,
            'v_name' => $v_name,
            'v_date' => $v_date,
            's_name' => $s_name,
            'v_sender' => $v_sender,
            'verifier' => $verifier,
        ]);
    }
    //changes verified or pending report admin/specific person
    public function actionChangeVerified($syif = null, $date = null)
    {
        // if ($syif && $date) {
        //  var_dump(Yii::$app->request->post('date'));die;
        if (Yii::$app->request->post()) {

            $model = TblRollCall::find()->where(['syif' => Yii::$app->request->post('syif')])->andWhere(['date' => Yii::$app->request->post('date')])->andWhere(['IN', 'verified_stat', ['PENDING', 'VERIFIED']])->all();
            foreach ($model as $var) {
                $verify = TblRollCall::findOne($var->id);
                // var_dump($verify->verified_by );
                $verify->verified_by = NULL;
                $verify->sent_by = NULL;
                $verify->report_dt = NULL;
                $verify->verified_stat = "Revoked";
                $verify->verified_dt = NULL;
                // $model->name = 'YII';
                // $model->email = 'yii2@framework.com';
                $verify->update(false);
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Boleh Diubah semula']);
            return $this->redirect(['keselamatan/change-verified']);
        }

        // }    
        return $this->render('change-verified', [
            'syif' => $syif,
            'tarikh' => $date,
            'todaydt' => date('Y-m-d'),

        ]);
    }
    public function actionRingkasanLaporan($syif = null, $tarikh = null, $cmp = null)
    {
        $id = Yii::$app->user->getId();

        $campus = TblAkses::findOne(['icno' => $id]);
        $ref = RefShifts::findOne(['jenis_shifts' => $syif]);
        $model = new TblLaporanKejadian();
        $model2 = new \app\models\keselamatan\TblOdometer();
        $s_name = "";
        $s_date = "";
        $v_date = "";
        $v_name = "";
        $p = "";
        $v_sender = null;
        $verifier = null;
        if ($model->load(Yii::$app->request->post()) && $model2->load(Yii::$app->request->post())) {

            $model->entered_by = $id;
            $model->date = $tarikh;
            $model->syif = $syif;
            $model->campus_id = $campus->campus_id;
            // }
            if (($model2->end_odo == "") && ($model2->start_odo == "")) {
            } else {
                $model2->entered_by = $id;
                $model2->distance = $model2->end_odo - $model2->start_odo;
                $model2->date = $tarikh;
                $model2->syif = $syif;
                $model2->campus_id = $campus->campus_id;
            }


            if ($model->save() && $model2->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
                return $this->redirect(['keselamatan/ringkasan-laporan', 'syif' => $syif, 'tarikh' => $tarikh]);
            }
        }
        $syifId = RefShifts::find()->where(['jenis_shifts' => $syif])->one();
        // var_dump($syifId);die;
        $laporan = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->all();
        $todaydt = date('Y-m-d');
        $var1 = null;
        $var = null;

        if ($syif == null && $tarikh == null) {
            $thh = null;
            $thlmj = null;
            $thlmt = null;
            $thb = null;
            $thblmj = null;
            $thblmt = null;
            $odometer = null;
            $jadual = null;
            $jumlah = null;
            $hadir = null;
            $Thadir = null;
            $ulasan = null;
            $odometer = null;
            $do_bertugas = null;
            $do_name = null;
            $pm = null;
        }
        if ($syif && $tarikh) {
            $pdo = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['campus_id' => $campus->campus_id])->andWhere(['!=', 'penganti_do', ''])->one();
            $do_bertugas = TblJadualDoPm::find()->where(['shift_id' => $ref->id])->andWhere(['tarikh' => $tarikh])->andWhere(['campus_id' => $campus->campus_id])->one();
            $v_sender = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['campus_id' => $campus->campus_id])->andWhere(['IN', 'verified_stat', ['VERIFIED', 'PENDING']])->one();
            $verifier = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['campus_id' => $campus->campus_id])->andWhere(['IN', 'verified_stat', ['VERIFIED']])->one();
            if ($v_sender) {
                $name = Tblprcobiodata::findOne(['ICNO' => $v_sender->sent_by]);
                $s_name = $name->CONm;
                $s_date = $v_sender->report_dt;
            }
            if ($verifier) {
                $vname = Tblprcobiodata::findOne(['ICNO' => $verifier->verified_by]);
                $v_name = $vname->CONm;
                $v_date = $verifier->verified_dt;
            }
            if ($do_bertugas) {
                $do_name = Tblprcobiodata::findOne(['ICNO' => $do_bertugas->icno]);
            }
            if ($pdo) {
                $p = $pdo->penganti_do;
            }
            $status = ['THLMT', 'THLMT', 'THTC', 'THH', 'THLMJ'];
            $var1 = null;
            $var = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->orWhere(['THTC' => 1])->orWhere(['THH' => 1])->orWhere(['THLMJ' => 1])->orWhere(['THLMT' => 1])->all();
            $thh = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['=', 'THH', '1'])->andWhere(['campus_id' => $campus->campus_id])->all();
            $thlmj = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['=', 'THLMJ', '1'])->andWhere(['campus_id' => $campus->campus_id])->all();
            $thlmt = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['THLMT' => 1])->andWhere(['campus_id' => $campus->campus_id])->all();
            $thb = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['campus_id' => $campus->campus_id])->andWhere(['syif' => $syif])->andWhere([

                'or',

                ['=', 'THBH', '1'],
                ['=', 'THBLMJ', '1'],
                ['=', 'THBLMT', '1'],
                ['=', 'THBKWLN', '1'],

            ])->all();
            // var_dump($do_bertugas);die;

            if (!$do_bertugas) {
                $do_name = Tblprcobiodata::findOne(['ICNO' => $id]);
            }
            if ($syif == "A") {
                $var = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['IN', 'syif', ['A', 'A6']])->orWhere(['THTC' => 1])->orWhere(['THH' => 1])->orWhere(['THLMJ' => 1])->orWhere(['THLMT' => 1])->all();
                $thh = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['IN', 'syif', ['A', 'A6']])->andWhere(['=', 'THH', '1'])->andWhere(['campus_id' => $campus->campus_id])->all();
                $thlmj = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['IN', 'syif', ['A', 'A6']])->andWhere(['=', 'THLMJ', '1'])->andWhere(['campus_id' => $campus->campus_id])->all();
                $thlmt = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['IN', 'syif', ['A', 'A6']])->andWhere(['THLMT' => 1])->andWhere(['campus_id' => $campus->campus_id])->all();
                $thb = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['campus_id' => $campus->campus_id])->andWhere(['IN', 'syif', ['A', 'A6']])->andWhere([

                    'or',

                    ['=', 'THBH', '1'],
                    ['=', 'THBLMJ', '1'],
                    ['=', 'THBLMT', '1'],
                    ['=', 'THBKWLN', '1'],

                ])->all();
                $hadirH = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['IN', 'pos_kawalan_id', ['3', '18']])->andWhere(['HH' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
                $hadirLMJ = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['IN', 'pos_kawalan_id', ['3', '18']])->andWhere(['HLMJ' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
                $hadirLMT = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['IN', 'pos_kawalan_id', ['3', '18']])->andWhere(['HLMT' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
            }
            if ($syif == "C") {
                $hadirH = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['IN', 'pos_kawalan_id', ['4', '19']])->andWhere(['HH' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
                $hadirLMJ = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['IN', 'pos_kawalan_id', ['4', '19']])->andWhere(['HLMJ' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
                $hadirLMT = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['IN', 'pos_kawalan_id', ['4', '19']])->andWhere(['HLMT' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
            }
            if ($syif == "B") {
                $hadirH = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['IN', 'pos_kawalan_id', ['5', '20']])->andWhere(['HH' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
                $hadirLMJ = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['IN', 'pos_kawalan_id', ['5', '20']])->andWhere(['HLMJ' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
                $hadirLMT = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['IN', 'pos_kawalan_id', ['5', '20']])->andWhere(['HLMT' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
            }
            // } else {
            //     $hadirH = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['HH' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
            //     $hadirLMJ = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['HLMJ' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
            //     $hadirLMT = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['HLMT' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
            // }
            //$ThadirH = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif'=>$syif])->andWhere(['HH'=>'0'])->count();
            //$ThadirLMJ = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif'=>$syif])->andWhere(['HLMJ'=>'0'])->count();
            // $jumlah1 = TblShiftKeselamatan::find()->where(['tarikh' => $tarikh])->andWhere(['shift_id' => $syifId->id])->andWhere(['campus_id' => $campus->campus_id])->count();
            // $jumlah2 = TblOt::find()->where(['tarikh' => $tarikh])->andWhere(['shift_id' => $syifId->id])->andWhere(['campus_id' => $campus->campus_id])->count();
            // $jumlah3 = TblLmt::find()->where(['tarikh' => $tarikh])->andWhere(['lmt_id' => $syifId->id])->andWhere(['campus_id' => $campus->campus_id])->count();
            if ($syif == "A") {
                $jumlah1 = TblShiftKeselamatan::find()->where(['tarikh' => $tarikh])->andWhere(['IN', 'shift_id', ['3', '18']])->andWhere(['campus_id' => $campus->campus_id])->count();
                $jumlah2 = TblOt::find()->where(['tarikh' => $tarikh])->andWhere(['IN', 'shift_id', ['3', '18']])->andWhere(['campus_id' => $campus->campus_id])->count();
                $jumlah3 = TblLmt::find()->where(['tarikh' => $tarikh])->andWhere(['IN', 'lmt_id', ['3', '18']])->andWhere(['campus_id' => $campus->campus_id])->count();
            }
            if ($syif == "C") {
                $jumlah1 = TblShiftKeselamatan::find()->where(['tarikh' => $tarikh])->andWhere(['IN', 'shift_id', ['4', '19']])->andWhere(['campus_id' => $campus->campus_id])->count();
                $jumlah2 = TblOt::find()->where(['tarikh' => $tarikh])->andWhere(['IN', 'shift_id', ['4', '19']])->andWhere(['campus_id' => $campus->campus_id])->count();
                $jumlah3 = TblLmt::find()->where(['tarikh' => $tarikh])->andWhere(['IN', 'lmt_id', ['4', '19']])->andWhere(['campus_id' => $campus->campus_id])->count();
            }
            if ($syif == "B") {
                $jumlah1 = TblShiftKeselamatan::find()->where(['tarikh' => $tarikh])->andWhere(['IN', 'shift_id', ['5', '20']])->andWhere(['campus_id' => $campus->campus_id])->count();
                $jumlah2 = TblOt::find()->where(['tarikh' => $tarikh])->andWhere(['IN', 'shift_id', ['5', '20']])->andWhere(['campus_id' => $campus->campus_id])->count();
                $jumlah3 = TblLmt::find()->where(['tarikh' => $tarikh])->andWhere(['IN', 'lmt_id', ['5', '20']])->andWhere(['campus_id' => $campus->campus_id])->count();
            }
            // var_dump($hadirH);die;
            $jumlah = $jumlah1 + $jumlah2 + $jumlah3;
            $hadir = $hadirH + $hadirLMJ + $hadirLMT;

            $Thadir = $jumlah - $hadir;
            $ulasan = TblLaporanKejadian::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['campus_id' => $campus->campus_id])->all();
            $odometer = \app\models\keselamatan\TblOdometer::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['campus_id' => $campus->campus_id])->all();
            $report = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['verified_stat' => 'VERIFIED'])->andWhere(['campus_id' => $campus->campus_id])->one();
            if ($report) {
                $pm = $report->verifier_comment;
            } else {
                $pm = "";
            }
        }
        // var_dump($thb);die;  

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);


        return $this->render('ringkasan-laporan', [
            'syif' => $syif,
            'tarikh' => $tarikh,
            'var' => $var,
            'todaydt' => $todaydt,
            'laporan' => $laporan,
            'biodata' => $biodata,
            'thh' => $thh,
            'thb' => $thb,
            'jumlah' => $jumlah,
            'hadir' => $hadir,
            'Thadir' => $Thadir,
            'odometer' => $odometer,
            'thlmj' => $thlmj,
            'thlmt' => $thlmt,
            'bil' => 1,
            'bil1' => 1,
            'model' => $model,
            'model2' => $model2,
            'ulasan' => $ulasan,
            'do_bertugas' => $do_bertugas,
            'do_name' => $do_name,
            'v_name' => $v_name,
            's_name' => $s_name,
            's_date' => $s_date,
            'v_sender' => $v_sender,
            'verifier' => $verifier,
            'pm' => $pm,
            'v_date' => $v_date,
            'p' => $p
        ]);
    }

    public function actionOdometer()
    {
        $id = Yii::$app->user->getId();
        $c_id = TblAkses::findOne(['icno' => $id]);
        $model = new \app\models\keselamatan\TblOdometer();

        if ($model->load(Yii::$app->request->post())) {

            $model->entered_by = $id;
            $model->distance = $model->end_odo - $model->start_odo;
            $model->campus_id = $c_id->campus_id;
            //                $model->date = date('Y-m-d H:i:s');
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
                return $this->redirect(['keselamatan/sts', 'id' => 3]);
            }
        }
        return $this->renderAjax('odometer', [
            'model' => $model
        ]);
    }

    public function actionLaporanKejadian()
    {

        $id = Yii::$app->user->getId();
        $model = new TblLaporanKejadian();
        $c_id = TblAkses::findOne(['icno' => $id]);

        if ($model->load(Yii::$app->request->post())) {
            $model->campus_id = $c_id->campus_id;

            $model->entered_by = $id;
            //                $model->date = date('Y-m-d H:i:s');
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
                return $this->redirect(['keselamatan/sts', 'id' => 3]);
            }
        }
        return $this->renderAjax('laporan-kejadian', [
            'model' => $model
        ]);
    }

    public function actionDoAddLmt()
    {
        $id = Yii::$app->user->getId(); //getting user id
        $biodata = Tblprcobiodata::find()
            ->where(['!=', 'status', 6])
            ->andWhere(['DeptId' => 2])
            ->all();

        $model = new TblLmt();
        if ($model->load(Yii::$app->request->post())) {

            $model->year = date('y');
            $model->do_add_icno = $id;
            $model->do_add_dt = date('Y-m-d H:i:s');
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Added', 'type' => 'success', 'msg' => 'New staff Added!']);
                return $this->redirect(['keselamatan/do-add-lmt']);
            }
        }

        return $this->render('do-add-lmt', [
            'model' => $model,
            'biodata' => $biodata,
        ]);
    }

    public function actionLaporanIndex($id)
    {

        $icno = Yii::$app->user->getId();
        $tahun = date('Y');

        $sql = 'SELECT * FROM e_cuti.cuti_rekod WHERE cuti_icno=:icno AND YEAR(cuti_mula) = :tahun';
        $cuti_rekod = CutiRekod::findBySql($sql, [':icno' => $icno, ':tahun' => $tahun])->all();

        $total = Layak::getBakiLatest($icno);

        $model_layak = Layak::getLatestLayak($icno);

        $csakit1 = 15 - CutiRekod::totalCSakit1($icno, $tahun);
        $csakit2 = 90 - CutiRekod::totalCSakit2($icno, $tahun);

        $layak = Layak::find()->where(['layak_icno' => $icno])->orderBy(['layak_mula' => SORT_DESC])->all();

        return $this->render('laporan-index', [
            'cuti_rekod' => $cuti_rekod,
            'total' => $total,
            'model_layak' => $model_layak,
            'csakit1' => $csakit1,
            'csakit2' => $csakit2,
            'layak' => $layak,
        ]);
    }

    public function actionSenaraiKakitangan()
    {
        $carian = new Tblprcobiodata();
        $sender = Yii::$app->user->getId();
        $admin = TblAkses::findOne(['icno' => $sender, 'isAccess' => 1]);
        // var_dump($admin);die;
        $access = false;
        if ($admin == true) {
            $access = true;
        }

        $id = Yii::$app->request->queryParams;
        //        var_dump($id['Tblprcobiodata']['carian_department']);die;
        if (!$id) {
            $query = Tblprcobiodata::find()
                ->where(['!=', 'status', 6])
                ->andWhere(['IN', 'DeptId', ['2', '139', '33']])
                ->andWhere(['IN', 'gredJawatan', ['118', '119', '295', '302', '303', '360', '388', '389', '43', '44', '116', '117', '211', '413']]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 50,
                ],
            ]);
        } else {
            //        var_dump($id);die;
            $dataProvider = $carian->carianKeselamatan(Yii::$app->request->queryParams);
        }
        return $this->render('senarai-kakitangan', [
            'carian' => $carian,
            'model' => $dataProvider,
            'bil' => 1,
            'access' => $access,
        ]);
    }

    public function actionLaporanBulanan($id = null, $tahun = null, $bulan = null)
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

        $sql = 'SELECT * FROM keselamatan.tbl_reports WHERE icno=:icno AND MONTH(tarikh)=:mth';
        $reports = TblReports::findBySql($sql, [':icno' => $id, ':mth' => $mth])->asArray()->all();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        //        $warna_kad = \app\models\keselamatan\TblWarnakad::WarnaKadSemasa($id, $mth);
        $warna_kad = TblWarnakad::WarnaKadSemasa($id, $mth, NULL, $year);


        return $this->render('laporan-bulanan', ['reports' => $reports, 'var' => $var, 'icno' => $id, 'tahun' => $year, 'bulan' => $mth, 'biodata' => $biodata, 'warna_kad' => $warna_kad]);
    }

    //date range

    public function actionLaporanTahunan($id = null)
    {
        $datestart = Yii::$app->request->get('date_start');
        $dateend = Yii::$app->request->get('date_end');

        $yearstart = date("Y", strtotime($datestart));
        $monthstart = date("m", strtotime($datestart));
        $yearend = date("Y", strtotime($dateend));
        // echo $yearend;die;
        $monthend = date("m", strtotime($dateend));

        if (!$id) {
            $id = Yii::$app->user->getId();
        }

        $var = null;
        $var1 = null;
        if ($datestart && $dateend) {
            $var = $this->getMonthsInYearStart($yearstart, $monthstart, 'm');
            $var1 = $this->getMonthsInYearEnd($yearstart, $monthend, 'm');
        }
        //        var_dump($var);die;
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

        return $this->render('laporan-tahunan', [
            'datestart' => $datestart, 'dateend' => $dateend, 'biodata' => $biodata,
            'yearstart' => $yearstart, 'monthstart' => $monthstart, 'var' => $var, 'var1' => $var1, 'icno' => $id,
            'yearend' => $yearend, 'monthend' => $monthend
        ]);
    }
    public function actionYearlyReport($id = null)
    {
        $datestart = Yii::$app->request->get('date_start');
        $dateend = Yii::$app->request->get('date_end');

        $yearstart = date("Y", strtotime($datestart));
        $monthstart = date("m", strtotime($datestart));
        $yearend = date("Y", strtotime($dateend));
        // echo $yearend;die;
        $monthend = date("m", strtotime($dateend));

        if (!$id) {
            $id = Yii::$app->user->getId();
        }

        $var = null;
        $var1 = null;
        if ($datestart && $dateend) {
            $var = $this->getMonthsInYearStart($yearstart, $monthstart, 'm');
            $var1 = $this->getMonthsInYearEnd($yearstart, $monthend, 'm');
        }
        //        var_dump($var);die;
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

        return $this->render('yearly-report', [
            'datestart' => $datestart, 'dateend' => $dateend, 'biodata' => $biodata,
            'yearstart' => $yearstart, 'monthstart' => $monthstart, 'var' => $var, 'var1' => $var1, 'icno' => $id,
            'yearend' => $yearend, 'monthend' => $monthend
        ]);
    }

    function getMonthsInYearStart(int $year, int $month, string $format)
    {
        //        var_dump($format);die;
        $date = DateTime::createFromFormat("Y-n", "$year-$month");

        $datesArray = array();
        for ($i = $month; $i <= 12; $i++) {
            $datesArray[] = TblRekod::viewBulan($i);
        }
        return $datesArray;
    }

    function getMonthsInYearEnd(int $year, int $month, string $format)
    {
        //        var_dump($format);die;
        $date = DateTime::createFromFormat("Y-n", "$year-$month");

        $datesArray = array();
        for ($i = 1; $i <= $month; $i++) {
            $datesArray[] = TblRekod::viewBulan($i);
        }
        return $datesArray;
    }

    //delete doc sokongan
    public function actionDeletegambar($id)
    {
        $icno = Yii::$app->user->getId();
        $model = TblRollcall::findOne($id);
        if (!empty($model->namafile && $model->namafile != 'deleted')) {
            $res = Yii::$app->FileManager->DeleteFile($model->namafile);
            if ($res->status == true) {
                $model->namafile = 'deleted';
                $model->update();
            }
        }
        return $this->redirect(['remark-kesalahan', 'id' => $id, 'icno' => $icno]);
    }
    public function actionManualRollcall($id = null, $date = null)
    {
        $var = null;
        $name = null;
        $v = null;
        $i = null;
        $p_do = null;
        $p = null;
        // $do_bertugas = null;  
        if (!$id) {
            $id = 3;
        }
        $shift = RefShifts::find()->where(['id' => $id])->one();
        $icno = Yii::$app->user->getId();
        $do_campus_id = TblAkses::find()->where(['icno' => $icno])->one();

        if ($id && $date) {


            $do_bertugas = TblJadualDoPm::find()->where(['shift_id' => $id])->andWhere(['tarikh' => $date])->andWhere(['campus_id' => $do_campus_id->campus_id])->one();
            $var = 1; //untuk munculkan form, masukkan data dalam form

            // var_dump($p);die;
            $bio = TblPrcobiodata::findOne(['ICNO' => $icno]);

            if ($do_bertugas) {

                if ($do_bertugas->icno == $bio->ICNO) {
                    $do_bertugas = $do_bertugas->icno;
                    $do =  TblPrcobiodata::findOne(['ICNO' => $do_bertugas]);
                    $name = "";
                    $pengganti = null;
                    $v = $do->CONm;
                    $i = true;
                } else {
                    $name = $bio->CONm;
                    $pengganti = $bio->ICNO;
                    $do_bertugas = $do_bertugas->icno;
                    $do =  TblPrcobiodata::findOne(['ICNO' => $do_bertugas]);
                    $i = true;
                    $v = $do->CONm;
                }
            } else {
                $do_bertugas = $icno;
                $pengganti = null;
                $do =  TblPrcobiodata::findOne(['ICNO' => $do_bertugas]);
                $v = $do->CONm;
                $i = false;
            }
        }

        $condition = TblOt::find()->where(['pos_kawalan_id' => $id])->andWhere(['tarikh' => date('Y-m-d')])->andWhere(['!=', 'shift_id', 1])->exists();
        $cuti = CutiRekod::find()->where(['cuti_mula' => $date])->andWhere(['cuti_icno' => $icno])->one();
        $searchModel = new \app\models\keselamatan\TblStaffKeselamatanSearch();

        if ($id == 3) {
            $shifts = ['3', '18'];
        } else
        if ($id == 4) {
            // echo 'd';die;
            $shifts = ['4', '19','23','24'];
        }
        // if ($id == 5) 
        else {
            $shifts = ['5', '20'];
        }
        $query = TblShiftKeselamatan::find()->where(['tarikh' => $date])->andWhere(['IN', 'shift_id', $shifts])->andWhere(['campus_id' => $do_campus_id->campus_id]);
        $querys = TblOt::find()->where(['tarikh' => $date])->andWhere(['IN', 'shift_id', $shifts])->andWhere(['!=', 'shift_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id]);
        $querylmt = TblLmt::find()->where(['tarikh' => $date])->andWhere(['IN', 'lmt_id', $shifts])->andWhere(['!=', 'lmt_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id]);

        $models = TblShiftKeselamatan::find()->where(['tarikh' => $date])->andWhere(['campus_id' => $do_campus_id->campus_id])->all();
        $modelot = TblOt::find()->where(['tarikh' => $date])->andWhere(['!=', 'shift_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id])->all();
        $modellmt = TblLmt::find()->where(['tarikh' => $date])->andWhere(['!=', 'lmt_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id])->all();


        // var_dump($query);die;
        if (Yii::$app->request->post('simpan')) {
            // var_dump(Yii::$app->request->post('namado'));die;

            foreach ($models as $data) {
                $m = date('m');
                // var_dump($syif1);die;

                $syif1 = RefShifts::find()->where(['id' => $data->shift_id])->one();
                if ('yy' . $data->icno == Yii::$app->request->post($data->icno)) {

                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => $date])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif1->jenis_shifts])->exists();
                    //var_dump($exist);die
                    if (!$exist) {


                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->icno;
                        $model->month = "$m";
                        $model->type = "H";
                        //                        $model->catatan = Yii::$app->request->post('g');
                        $model->catatan_do = Yii::$app->request->post('catatan');
                        $model->THBH = '0';
                        $model->HH = '1';
                        $model->sts_sent = 'NO_STS';
                        $model->status = 'NO_STS';
                        // var_dump($model->status);die;
                        $model->date = $date;
                        $model->year = date("Y", strtotime($date));
                        $model->time = date('h:i:s');
                        $model->pos_kawalan_id = "$data->shift_id";
                        // $model->do_icno = $icno;
                        $model->do_icno = $do_bertugas;
                        $model->penganti_do = Yii::$app->request->post('namado');
                        $model->penganti_do_icno = $pengganti;
                        // $model->status = 'SIMPAN';
                        $model->syif = "$syif1->jenis_shifts";
                        $model->campus_id = $do_campus_id->campus_id;

                        $model->save(false);
                    }
                }
                if ('y' . $data->icno == Yii::$app->request->post($data->icno)) {
                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => $date])->andWhere(['type' => 'H'])->exists();
                    if (!$exist) {
                        // THB = 1 -> Hadir Baris 
                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->icno;
                        $model->month = "$m";
                        $model->type = "H";
                        //                        $model->catatan = Yii::$app->request->post('g');
                        //                        $model->catatan_do = Yii::$app->request->post('do');
                        $model->THBH = '1';
                        $model->date = $date;
                        $model->year = date("Y", strtotime($date));
                        $model->time = date('h:i:s');
                        $model->pos_kawalan_id = "$data->shift_id";
                        $model->do_icno = $do_bertugas;
                        $model->penganti_do = Yii::$app->request->post('namado');
                        $model->penganti_do_icno = $pengganti;
                        $model->status = 'SIMPAN';
                        $model->sts_sent = 'SIMPAN';
                        $model->syif = "$syif1->jenis_shifts";
                        $model->campus_id = $do_campus_id->campus_id;
                        $model->save(false);
                    }
                }
            }
            foreach ($modelot as $data) {
                //                var_dump('d');die;
                $m = date('m');
                $syif1 = RefShifts::find()->where(['id' => $data->shift_id])->one();

                if ('zz' . $data->icno == Yii::$app->request->post($data->icno)) {

                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => $date])->andWhere(['type' => 'LMJ'])->exists();
                    if (!$exist) {

                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->icno;
                        $model->month = "$m";
                        $model->type = "LMJ";
                        //                        $model->catatan = Yii::$app->request->post('g');
                        $model->catatan_do = Yii::$app->request->post('do');
                        $model->THBLMJ = '0';
                        $model->HLMJ = '1';
                        $model->status = 'NO_STS';
                        $model->sts_sent = 'NO_STS';
                        $model->date = $date;
                        $model->year = date("Y", strtotime($date));
                        $model->time = date('h:i:s');
                        $model->pos_kawalan_id = "$data->shift_id";
                        $model->do_icno = $do_bertugas;
                        $model->penganti_do_icno = $pengganti;
                        $model->penganti_do = Yii::$app->request->post('namado');
                        $model->campus_id = $do_campus_id->campus_id;
                        $model->syif = "$syif1->jenis_shifts";
                        $model->save(false);
                    }
                }
                if ('z' . $data->icno == Yii::$app->request->post($data->icno)) {

                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => $date])->andWhere(['type' => 'LMJ'])->exists();
                    if (!$exist) {
                        // THB = 1 -> Hadir Baris 
                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->icno;
                        $model->month = "$m";
                        $model->type = "LMJ";
                        //                        $model->catatan = Yii::$app->request->post('g');
                        $model->catatan_do = Yii::$app->request->post('do');
                        $model->THBLMJ = '1';
                        $model->date = $date;
                        $model->year = date("Y", strtotime($date));
                        $model->time = date('h:i:s');
                        $model->pos_kawalan_id = "$data->shift_id";
                        $model->do_icno = $do_bertugas;
                        $model->penganti_do = Yii::$app->request->post('namado');
                        $model->penganti_do_icno = $pengganti;
                        $model->sts_sent = 'SIMPAN';

                        $model->status = 'SIMPAN';
                        $model->syif = "$syif1->jenis_shifts";
                        $model->campus_id = $do_campus_id->campus_id;

                        $model->save(false);
                    }
                }
            }
            foreach ($modellmt as $data) {
                //                var_dump('d');die;
                $m = date('m');
                $syif1 = RefLmt::find()->where(['id' => $data->lmt_id])->one();

                if ('lmt' . $data->icno == Yii::$app->request->post($data->icno)) {

                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => $date])->andWhere(['type' => 'LMT'])->exists();
                    if (!$exist) {

                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->icno;
                        $model->month = "$m";
                        $model->type = "LMT";
                        //                        $model->catatan = Yii::$app->request->post('g');
                        $model->catatan_do = Yii::$app->request->post('do');
                        $model->THBLMT = '0';
                        $model->HLMT = '1';
                        $model->status = 'NO_STS';
                        $model->sts_sent = 'NO_STS';
                        $model->date = $date;
                        $model->year = date("Y", strtotime($date));
                        $model->time = date('h:i:s');
                        $model->pos_kawalan_id = "$data->lmt_id";
                        $model->do_icno = $do_bertugas;
                        $model->penganti_do = Yii::$app->request->post('namado');
                        $model->penganti_do_icno = $pengganti;

                        // $model->status = 'SIMPAN';
                        $model->syif = "$syif1->jenis_shifts";
                        $model->campus_id = $do_campus_id->campus_id;
                        $model->save(false);
                    }
                }
                if ('lmts' . $data->icno == Yii::$app->request->post($data->icno)) {

                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => $date])->andWhere(['type' => 'LMT'])->exists();
                    if (!$exist) {
                        // THB = 1 -> Hadir Baris 
                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->icno;
                        $model->month = "$m";
                        $model->type = "LMT";
                        //                        $model->catatan = Yii::$app->request->post('g');
                        $model->catatan_do = Yii::$app->request->post('do');
                        $model->THBLMT = '1';
                        $model->date = $date;
                        $model->year = date("Y", strtotime($date));
                        $model->time = date('h:i:s');
                        $model->pos_kawalan_id = "$data->lmt_id";
                        $model->do_icno = $do_bertugas;
                        $model->penganti_do_icno = $pengganti;
                        $model->sts_sent = 'SIMPAN';

                        $model->penganti_do = Yii::$app->request->post('namado');
                        $model->status = 'SIMPAN';
                        $model->syif = "$syif1->jenis_shifts";
                        $model->campus_id = $do_campus_id->campus_id;

                        $model->save(false);
                    }
                }
            }
            $p = TblRollcall::find()->where(['IN', 'pos_kawalan_id', $shifts])->andWhere(['date' => $date])->andWhere(['campus_id' => $do_campus_id->campus_id])->andWhere(['!=', 'penganti_do', ''])->one();
            if ($p) {
                // echo 'd';die;
                $p_do = $p->penganti_do;
            } else {
                $p_do = "";
            }
            if ($p_do == "") {
                $update = TblRollcall::find()->where(['pos_kawalan_id' => $id, 'date' => $date])->andWhere(['campus_id' => $do_campus_id->campus_id])->all();
                foreach ($update as $var) {
                    $verify = TblRollCall::findOne($var->id);
                    $verify->penganti_do = Yii::$app->request->post('namado');

                    $verify->save(false);
                }
            }
        }

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        $DataProviders = new ActiveDataProvider([
            'query' => $querys,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        $DataProviderslmt = new ActiveDataProvider([
            'query' => $querylmt,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        $inA = false;
        if ($DataProviders->totalCount > 0 || $DataProviderslmt->totalCount > 0) {
            $inA = true;
        }

        return $this->render('manual-rollcall', [
            'id' => $id, 'date' => $date, 'var' => $var, 'shift' => $shift,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'dataProviders' => $DataProviders,
            'dataProviderslmt' => $DataProviderslmt,
            'cuti' => $cuti,
            'condition' => $condition,
            'date' => $date,
            'inA' => $inA,
            'name' => $name,
            'v' => $v,
            'i' => $i,
            'p' => $p,
            'p_do' => $p_do,
            // 'color' => $color,

        ]);
    }

    public function actionPeriksaAnggota($id)
    {
        $condition = TblOt::find()->where(['pos_kawalan_id' => $id])->andWhere(['tarikh' => date('Y-m-d')])->andWhere(['!=', 'shift_id', 1])->exists();
        $syif = RefShifts::find()->where(['id' => $id])->one();
        $icno = Yii::$app->user->getId();
        $do_campus_id = TblAkses::find()->where(['icno' => $icno])->one();

        // $v_status = TblRollcall::find()->where(['date' => date('Y-m-d')])->andWhere(['pos_kawalan_id' => $id])->andWhere(['campus_id' => $do_campus_id->campus_id])->andWhere(['IN','verified_stat',['VERIFIED','PENDING']])->one();
        // // var_dump($v_status->verified_stat);die;
        // if($v_status ){
        //     Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Laporan Untuk Syif ini Pada Tarikh Ini telah dihantar untuk pengesahan atau telah pun disahkan oleh Pegawai Medan']);
        //     return $this->redirect(['keselamatan/manual-rollcall']);
        // }        
        //    var_dump($do_campus_id->campus_id);die;
        $date = date('Y-m-d');
        $cuti = CutiRekod::find()->where(['cuti_mula' => $date])->andWhere(['cuti_icno' => $icno])->one();
        $searchModel = new \app\models\keselamatan\TblStaffKeselamatanSearch();
        $timenow = date('H:i');
        //        $shift = TblShiftKeselamatan::find()->where(['tarikh' => date('Y-m-d')])->all();
        //        $ot = TblOt::find()->where(['tarikh' => date('Y-m-d')])->andWhere(['!=', 'shift_id', '1'])->all();
        //        $join = array_merge($shift, $ot);
        //        var_dump($join);die;
        if ($id == 3) {
            if (($timenow > "23:25" && $timenow > "23:59")) {
                $dt = date('Y-m-d', strtotime('+1 day', strtotime(date('r'))));
                $query = TblShiftKeselamatan::find()->where(['tarikh' => date('Y-m-d', strtotime('+1 day', strtotime(date('r'))))])->andWhere(['shift_id' => $id])->andWhere(['campus_id' => $do_campus_id->campus_id]);
                $querys = TblOt::find()->where(['tarikh' => date('Y-m-d', strtotime('+1 day', strtotime(date('r'))))])->andWhere(['shift_id' => $id])->andWhere(['!=', 'shift_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id]);
                $models = TblShiftKeselamatan::find()->where(['tarikh' => date('Y-m-d', strtotime('+1 day', strtotime(date('r'))))])->andWhere(['campus_id' => $do_campus_id->campus_id])->all();
                $modelot = TblOt::find()->where(['tarikh' => date('Y-m-d', strtotime('+1 day', strtotime(date('r'))))])->andWhere(['shift_id' => $id])->andWhere(['!=', 'shift_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id])->all();
                $modellmt = TblLmt::find()->where(['tarikh' => date('Y-m-d', strtotime('+1 day', strtotime(date('r'))))])->andWhere(['lmt_id' => $id])->andWhere(['!=', 'lmt_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id])->all();
                $querylmt = TblLmt::find()->where(['tarikh' => date('Y-m-d', strtotime('+1 day', strtotime(date('r'))))])->andWhere(['lmt_id' => $id])->andWhere(['!=', 'lmt_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id]);
                $do_bertugas = TblJadualDoPm::find()->where(['shift_id' => $id])->andWhere(['tarikh' => date('Y-m-d', strtotime('+1 day', strtotime(date('r'))))])->andWhere(['campus_id' => $do_campus_id->campus_id])->one();

                // if(!$do_bertugas){

                //     $do_bertugas = TblOt::find()->where(['tarikh' => date('Y-m-d', strtotime('+1 day', strtotime(date('r'))))])->andWhere(['shift_id' => $id])->andWhere(['!=', 'shift_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id])->one();
                // }
            } else {
                $dt = date('Y-m-d');
                $query = TblShiftKeselamatan::find()->where(['tarikh' => date('Y-m-d')])->andWhere(['shift_id' => $id])->andWhere(['campus_id' => $do_campus_id->campus_id]);
                $querys = TblOt::find()->where(['tarikh' => date('Y-m-d')])->andWhere(['shift_id' => $id])->andWhere(['!=', 'shift_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id]);
                $models = TblShiftKeselamatan::find()->where(['tarikh' => date('Y-m-d')])->andWhere(['campus_id' => $do_campus_id->campus_id])->all();
                $modelot = TblOt::find()->where(['tarikh' => date('Y-m-d')])->andWhere(['shift_id' => $id])->andWhere(['!=', 'shift_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id])->all();
                $modellmt = TblLmt::find()->where(['tarikh' => $date])->andWhere(['lmt_id' => $id])->andWhere(['!=', 'lmt_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id])->all();
                $querylmt = TblLmt::find()->where(['tarikh' => $date])->andWhere(['lmt_id' => $id])->andWhere(['!=', 'lmt_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id]);
                $do_bertugas = TblJadualDoPm::find()->where(['shift_id' => $id])->andWhere(['tarikh' => $date])->andWhere(['campus_id' => $do_campus_id->campus_id])->one();

                // if(!$do_bertugas){

                //     $do_bertugas = TblOt::find()->where(['tarikh' => $date])->andWhere(['shift_id' => $id])->andWhere(['!=', 'shift_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id])->one();
                // }
            }
        } else {
            $dt = date('Y-m-d');
            $query = TblShiftKeselamatan::find()->where(['tarikh' => date('Y-m-d')])->andWhere(['shift_id' => $id])->andWhere(['campus_id' => $do_campus_id->campus_id]);
            $querys = TblOt::find()->where(['tarikh' => date('Y-m-d')])->andWhere(['shift_id' => $id])->andWhere(['!=', 'shift_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id]);
            $models = TblShiftKeselamatan::find()->where(['tarikh' => date('Y-m-d')])->andWhere(['campus_id' => $do_campus_id->campus_id])->all();
            $modelot = TblOt::find()->where(['tarikh' => date('Y-m-d')])->andWhere(['shift_id' => $id])->andWhere(['!=', 'shift_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id])->all();
            $modellmt = TblLmt::find()->where(['tarikh' => $date])->andWhere(['lmt_id' => $id])->andWhere(['!=', 'lmt_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id])->all();
            $querylmt = TblLmt::find()->where(['tarikh' => $date])->andWhere(['lmt_id' => $id])->andWhere(['!=', 'lmt_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id]);
            $do_bertugas = TblJadualDoPm::find()->where(['shift_id' => $id])->andWhere(['tarikh' => $date])->andWhere(['campus_id' => $do_campus_id->campus_id])->one();

            // if(!$do_bertugas){

            //     $do_bertugas = TblOt::find()->where(['tarikh' => $date])->andWhere(['shift_id' => $id])->andWhere(['!=', 'shift_id', '1'])->andWhere(['campus_id' => $do_campus_id->campus_id])->one();
            // }
        }

        if (Yii::$app->request->post('simpan')) {
            foreach ($models as $data) {
                $m = date('m');
                $syif1 = RefShifts::find()->where(['id' => $data->shift_id])->one();

                if ('yy' . $data->icno == Yii::$app->request->post($data->icno)) {

                    //                    if($id == 3){
                    //                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d', strtotime('+1 day', strtotime(date('r'))))])->andWhere(['type' => 'H'])->exists();
                    //                    }else{
                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                    //                    }
                    if (!$exist) {

                        // var_dump($syif1->jenis_shifts);die;
                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->icno;
                        $model->month = "$m";
                        $model->type = "H";
                        //                        $model->catatan = Yii::$app->request->post('g');
                        $model->catatan_do = Yii::$app->request->post('catatan');
                        $model->THBH = '0';
                        $model->HH = '1';
                        $model->sts_sent = 'NO_STS';
                        $model->date = date('Y-m-d');
                        $model->year = date('Y');
                        $model->time = date('h:i:s');
                        $model->campus_id = $do_campus_id->campus_id;
                        $model->pos_kawalan_id = "$data->shift_id";
                        $model->do_icno = $icno;
                        $model->status = 'NO_STS';
                        $model->syif = "$syif1->jenis_shifts";
                        $model->save(false);
                    }
                }
                if ('y' . $data->icno == Yii::$app->request->post($data->icno)) {
                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'H'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                    if (!$exist) {
                        // THB = 1 -> Hadir Baris 
                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->icno;
                        $model->month = "$m";
                        $model->type = "H";
                        //                        $model->catatan = Yii::$app->request->post('g');
                        //                        $model->catatan_do = Yii::$app->request->post('do');
                        $model->THBH = '1';
                        $model->date = date('Y-m-d');
                        $model->year = date('Y');
                        $model->time = date('h:i:s');
                        $model->pos_kawalan_id = "$data->shift_id";
                        $model->do_icno = $icno;
                        $model->status = 'SIMPAN';
                        $model->campus_id = $do_campus_id->campus_id;
                        $model->syif = "$syif1->jenis_shifts";
                        $model->save(false);
                    }
                }
            }
            foreach ($modelot as $data) {
                //                var_dump('d');die;
                $m = date('m');
                $syif1 = RefShifts::find()->where(['id' => $data->shift_id])->one();
                //                var_dump($syif1);die;

                if ('zz' . $data->icno == Yii::$app->request->post($data->icno)) {

                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                    if (!$exist) {

                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->icno;
                        $model->month = "$m";
                        $model->type = "LMJ";
                        //                        $model->catatan = Yii::$app->request->post('g');
                        $model->catatan_do = Yii::$app->request->post('do');
                        $model->THBLMJ = '0';
                        $model->HLMJ = '1';
                        $model->sts_sent = 'NO_STS';
                        $model->date = date('Y-m-d');
                        $model->year = date('Y');
                        $model->time = date('h:i:s');
                        $model->pos_kawalan_id = "$data->shift_id";
                        $model->do_icno = $icno;
                        $model->status = 'NO_STS';
                        $model->campus_id = $do_campus_id->campus_id;

                        $model->syif = "$syif1->jenis_shifts";
                        $model->save(false);
                    }
                }
                if ('z' . $data->icno == Yii::$app->request->post($data->icno)) {

                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => date('Y-m-d')])->andWhere(['type' => 'LMJ'])->andWhere(['syif' => $syif->jenis_shifts])->exists();
                    if (!$exist) {
                        // THB = 1 -> Hadir Baris 
                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->icno;
                        $model->month = "$m";
                        $model->type = "LMJ";
                        //                        $model->catatan = Yii::$app->request->post('g');
                        $model->catatan_do = Yii::$app->request->post('do');
                        $model->THBLMJ = '1';
                        $model->date = date('Y-m-d');
                        $model->year = date('Y');
                        $model->time = date('h:i:s');
                        $model->pos_kawalan_id = "$data->shift_id";
                        $model->do_icno = $icno;
                        $model->status = 'SIMPAN';
                        $model->campus_id = $do_campus_id->campus_id;

                        $model->syif = "$syif1->jenis_shifts";
                        $model->save(false);
                    }
                }
            }
            foreach ($modellmt as $data) {
                //                var_dump('d');die;
                $m = date('m');
                $syif1 = RefLmt::find()->where(['id' => $data->lmt_id])->one();

                if ('lmt' . $data->icno == Yii::$app->request->post($data->icno)) {

                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => $date])->andWhere(['type' => 'LMT'])->exists();
                    if (!$exist) {

                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->icno;
                        $model->month = "$m";
                        $model->type = "LMT";
                        //                        $model->catatan = Yii::$app->request->post('g');
                        $model->catatan_do = Yii::$app->request->post('do');
                        $model->THBLMT = '0';
                        $model->HLMT = '1';
                        $model->sts_sent = 'NO_STS';
                        $model->date = $date;
                        $model->campus_id = $do_campus_id->campus_id;

                        $model->year = date("Y", strtotime($date));
                        $model->time = date('h:i:s');
                        $model->pos_kawalan_id = "$data->lmt_id";
                        $model->do_icno = $icno;
                        $model->status = 'NO_STS';
                        $model->syif = "$syif1->jenis_shifts";
                        $model->save(false);
                    }
                }
                if ('lmts' . $data->icno == Yii::$app->request->post($data->icno)) {

                    $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => $date])->andWhere(['type' => 'LMT'])->exists();
                    if (!$exist) {
                        // THB = 1 -> Hadir Baris 
                        $icno = Yii::$app->user->getId();
                        $model = new TblRollcall();
                        $model->anggota_icno = $data->icno;
                        $model->month = "$m";
                        $model->campus_id = $do_campus_id->campus_id;

                        $model->type = "LMT";
                        //                        $model->catatan = Yii::$app->request->post('g');
                        $model->catatan_do = Yii::$app->request->post('do');
                        $model->THBLMT = '1';
                        $model->date = $date;
                        $model->year = date("Y", strtotime($date));
                        $model->time = date('h:i:s');
                        $model->pos_kawalan_id = "$data->lmt_id";
                        $model->do_icno = $icno;
                        $model->status = 'SIMPAN';
                        $model->syif = "$syif1->jenis_shifts";
                        $model->save(false);
                    }
                }
            }
        }
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        $DataProviders = new ActiveDataProvider([
            'query' => $querys,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $DataProviderslmt = new ActiveDataProvider([
            'query' => $querylmt,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('periksa-anggota', [
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'dataProviders' => $DataProviders,
            'dataProviderslmt' => $DataProviderslmt,
            'syif' => $syif,
            'cuti' => $cuti,
            'dt' => $dt,
            'condition' => $condition,
            'do_bertugas' => $do_bertugas,
        ]);
    }

    //new import
    public function actionNewImport()
    {
        $modelImportHakiki = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);
        $modelImportHakiki->addRule(['fileImport'], 'required');
        $modelImportHakiki->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx'], ['maxSize' => 1024 * 1024]);

        if (Yii::$app->request->post()) {
            $modelImportHakiki->fileImport = \yii\web\UploadedFile::getInstance($modelImportHakiki, 'fileImport');
            if ($modelImportHakiki->fileImport && $modelImportHakiki->validate()) {
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($modelImportHakiki->fileImport->tempName);
                $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImportHakiki->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

                $baseRow = 3;
                $year = date('Y');
                if(date('m') == 12){
                    $year = date("Y", strtotime(date("Y-m-d") . " + 1 year"));
                }
                $month = date('m', strtotime('+10 day'));
                // $month = "09";
                $dayscount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                //    var_dump($dayscount);die;
                $column = ['', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI'];

                while (!empty($sheetData[$baseRow]['A'])) {
                    $validate = (new \yii\db\Query())
                        ->select(['icno'])
                        ->from('keselamatan.tbl_shift_keselamatan')
                        ->where(['icno' => $this->umsper($sheetData[$baseRow]['B'])])
                        ->andWhere(['month' => $month])
                        ->andWhere(['year' => $year])
                        ->exists();
                    // var_dump($validate);die;
                    if ($validate) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Data di Baris ' . $baseRow . ' sudah wujud. Sila Periksa Senarai Anggota di Tetapan Syif Sebelum Mencuba Kembali. ']);
                        return $this->redirect('import-method');
                    } else {
                        $i = 1;
                        while ($dayscount >= 1) {
                            $model = new TblShiftKeselamatan();
                            $model2 = new TblOt();

                            $umsper = $this->umsper($sheetData[$baseRow]['B']);
                            $model->icno = $umsper;
                            $model2->icno = $umsper;
                            $syifH = $this->syifHakiki($sheetData[$baseRow][$column[$i]]);
                            $syifot = $this->syifOt($sheetData[$baseRow][$column[$i]]);

                            $model->shift_id = $syifH;
                            $model2->shift_id = $syifot;
                            $model->tarikh = $year . '-' . $month . '-' . $i;
                            $model2->tarikh = $year . '-' . $month . '-' . $i;
                            $model->year = "$year";
                            $model2->year = "$year";
                            $model->month = "$month";
                            $model2->month = "$month";
                            $staff = TblStaffKeselamatan::find()->where(['staff_icno' => $model->icno])->one();
                            $model->unit_id = $staff->unit_id;
                            $model2->unit_id = $staff->unit_id;
                            $model->campus_id = $staff->campus_id;
                            $model2->campus_id = $staff->campus_id;
                            $model->pos_kawalan_id = $this->pos((string) $sheetData[1]['B']);
                            $model2->pos_kawalan_id = $this->pos((string) $sheetData[1]['B']);
                            $model->save();
                            $model2->save();
                            $dayscount--;
                            $i++;
                        }
                        $dayscount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $baseRow++;
                    }
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jadual Bulanan Berjaya Di Muat Naik']);
                return $this->redirect('import-method');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }

        return $this->render('new-import', [
            'modelImportHakiki' => $modelImportHakiki,
        ]);
    }

    public function syifHakiki($syif1)
    {
        $val1 = '';
        $check = RefShifts::findOne(['jenis_shifts' => $syif1]);

        if ($syif1 == "A/B.") {
            $syif = "A";
        } elseif ($syif1 == "A./B") {
            $syif = "B";
        } elseif ($syif1 == "A/C.") {
            $syif = "A";
        } elseif ($syif1 == "A./C") {
            $syif = "C";
        } elseif ($syif1 == "B/C.") {
            $syif = "B";
        } elseif ($syif1 == "B/A.") {
            $syif = "B";
        } elseif ($syif1 == "B./C") {
            $syif = "C";
        } elseif ($syif1 == "C./B") {
            $syif = "B";
        } elseif ($syif1 == "C/B.") {
            $syif = "C";
        } elseif ($syif1 == "A.") {
            $syif = " ";
        } elseif ($syif1 == "B.") {
            $syif = " ";
        } elseif ($syif1 == "C.") {
            $syif = " ";
        } elseif ($syif1 == "") {
            $syif = "RM";
        } elseif ($syif1 == "A/B" || $syif1 == "C/B" || $syif1 == "A/B" || $syif1 == "A/C") {
            $syif = " ";
        } elseif (!$check) {
            $syif = "C";
        } else {
            $syif = $syif1;
            //    var_dump($syif);die;
        }
        $val = (new \yii\db\Query())
            ->select(['id'])
            ->from('keselamatan.ref_shifts')
            ->where(['jenis_shifts' => $syif])
            ->one();
        //        var_dump($val);die;
        if ($val) {
            $val1 = $val['id'];
        }
        return $val1;
    }

    public function syifOt($syif1)
    {
        $val1 = '';
        //    var_dump($syif1);die;
        if ($syif1 == "A/B.") {
            $syif = "B";
        } elseif ($syif1 == "A./B") {
            $syif = "A";
        } elseif ($syif1 == "B/A.") {
            $syif = "A";
        } elseif ($syif1 == "A/C.") {
            $syif = "C";
        } elseif ($syif1 == "A./C") {
            $syif = "A";
        } elseif ($syif1 == "C./B") {
            $syif = "C";
        } elseif ($syif1 == "C/B.") {
            $syif = "B";
        } elseif ($syif1 == "B/C.") {
            $syif = "C";
        } elseif ($syif1 == "B./C") {
            $syif = "B";
        } elseif ($syif1 == "A.") {
            $syif = "A";
        } elseif ($syif1 == "B.") {
            $syif = "B";
        } elseif ($syif1 == "C.") {
            $syif = "C";
        } elseif ($syif1 == "") {
            $syif = "RM";
        } else {
            $syif = " ";
        }
        $val = (new \yii\db\Query())
            ->select(['id'])
            ->from('keselamatan.ref_shifts')
            ->where(['jenis_shifts' => $syif])
            ->one();
        if ($val) {
            $val1 = $val['id'];
        }
        //  var_dump($val1);die;
        return $val1;
    }

    public function aksesAdmin($id)
    {
        $admin = TblAkses::find()->where(['icno' => $id])->andWhere(['akses_level' => 1])->andWhere(['isActive' => 1])->one();
        if ($admin) {
            return true;
        } else {
            return false;
        }
    }
    public function actionImportDo()
    {
        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);
        $modelImport->addRule(['fileImport'], 'required');
        $modelImport->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx'], ['maxSize' => 1024 * 1024]);

        if (Yii::$app->request->post()) {
            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');
            if ($modelImport->fileImport && $modelImport->validate()) {
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($modelImport->fileImport->tempName);
                //                var_dump($inputFileType);die;
                $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                //                VarDumper::dump($objReader);die;/
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $baseRow = 2;
                $year = date('Y');
                // $month = date('m', strtotime('+5 day'));
                $month = date('m', strtotime('+10 day'));
                // var_dump($month);
                // die;
                $dayscount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $column = ['', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI'];
                //                var_dump($dayscount);die;
                while (!empty($sheetData[$baseRow]['A'])) {

                    $i = 1;
                    while ($dayscount >= 1) {
                        $model = new TblJadualDoPm();
                        $umsper = $this->umsper($sheetData[$baseRow]['B']);
                        $model->icno = $umsper;
                        $syif = $this->syifOverTime($sheetData[$baseRow][$column[$i]]);
                        $model->shift_id = $syif;
                        $model->tarikh = $year . '-' . $month . '-' . $i;
                        $model->year = "$year";
                        $model->month = "$month";
                        $staff = TblStaffKeselamatan::find()->where(['staff_icno' => $model->icno])->one();
                        $model->unit_id = $staff->unit_id;
                        $model->campus_id = $staff->campus_id;
                        // $model->pos_kawalan_id = (string) $sheetData[$baseRow]['AJ'];
                        $model->save();
                        $dayscount--;
                        $i++;
                    }
                    $dayscount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    $baseRow++;
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jadual Lebih Masa Berjadual Berjaya Di Muat Naik']);
                return $this->redirect('import-do');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }

        return $this->render('import-do', [
            'modelImport' => $modelImport,
        ]);
    }
    public function actionAddVehicle()
    {
        $id = Yii::$app->user->getId();
        $vehicle = RefKenderaanBkums::find()->all();
        $model = new RefKenderaanBkums();

        if ($model->load(Yii::$app->request->post())) {
            if (RefKenderaanBkums::find()->where(['num_plate' => $model->num_plate])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Sudah Wujud!']);
            } elseif ($model->CONm != NULL) { //jika icno tidak wujud dalam sistem
                $model->isActive = 1;
                $model->num_plate = strtoupper($model->num_plate);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                $model->save();
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
            }

            return $this->redirect(['add-vehicle']);
        }

        return $this->renderAjax('odometer', [
            'model' => $model,
            'vehicle' => $vehicle,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = TblRekod::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    //kawalan

    public function actionAddPatrolPos()
    {
        $id = Yii::$app->user->getId();
        $patrol = new RefPatrolPos();
        $campus = TblAkses::findOne(['icno' => $id]);
        if ($patrol->load(Yii::$app->request->post())) {
            $patrol->entry_by = $id;
            $patrol->active = 1;
            $patrol->campus_id = $campus->campus_id;
            if ($patrol->save()) {
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Kawalan Telah Ditambah']);
            return $this->redirect(['add-patrol-staff']);
        }
        $searchModel = new RefPatrolPosSearch();
        $query = RefPatrolPos::find()->where(['active' => 1]);
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('add-patrol-pos', [
            'patrol' => $patrol,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
        ]);
    }

    public function actionUpdatePatrol($id)
    {
        $model = RefPatrolPos::findOne($id);
        $icno = Yii::$app->user->getId();

        $campus = TblAkses::findOne(['icno' => $icno]);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tarikh Permohonan Jawatan telah Berjaya dikemaskini!']);
                return $this->redirect(['add-patrol-pos']);
            }
        }
        return $this->renderAjax('update-patrol', [
            'model' => $model,
            'campus' => $campus,
        ]);
    }
    public function actionAddPatrolStaff($id = null)
    {

        $var = 1;
        if (!$id) {
            $id = 1;
            $var = null;
        }
        $icno = Yii::$app->user->getId();
        $campus = TblAkses::findOne(['icno' => $icno]);
        $models = TblStaffKeselamatan::find()->where(['campus_id' => $campus->campus_id])->all();
        // var_dump($models);die;
        if (Yii::$app->request->post('simpan')) {
            foreach ($models as $data) {
                $m = date('m');


                if ('patrol' . $data->staff_icno == Yii::$app->request->post($data->staff_icno)) {

                    $patrol = TblPatrolStaff::find()->where(['icno' => $data->staff_icno])->andWhere(['id' => $id])->exists();
                    // $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => $date])->andWhere(['type' => 'H'])->exists();
                    //var_dump($exist);die
                    if (!$patrol) {
                        $model = new TblPatrolStaff();
                        $model->icno = $data->staff_icno;
                        $model->patrol_pos_id = $id;
                        $model->month = "$m";
                        $model->year = date('Y');
                        $model->added_by = Yii::$app->user->getId();
                        $model->created_at = date('Y-m-d H:i:s');
                        $model->isActive = 1;
                        $model->campus_id = $data->campus_id;

                        $model->save(false);
                    }
                }
            }
        }
        $searchModel = new RefPatrolPosSearch();
        $query = TblStaffKeselamatan::find()->where(['campus_id' => $campus->campus_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 250,
            ],
        ]);

        return $this->render('add-patrol-staff', [
            'id' => $id,
            'var' => $var,
            'dataProvider' => $dataProvider,
            'campus' => $campus,

        ]);
    }
    public function actionClockPatrol($id = null)
    {

        $var = 1;
        if (!$id) {
            $id = 1;
            $var = null;
        }
        // $day = date('l');var_dump($day);die;
        $icno = Yii::$app->user->getId();
        $campus = TblAkses::findOne(['icno' => $icno]);
        $models = TblPatrolStaff::find()->where(['campus_id' => $campus->campus_id, 'patrol_pos_id' => $id])->all();
        $current_ip = $this->getRealUserIp();

        if (Yii::$app->request->post('simpan')) {
            foreach ($models as $data) {

                if ('patrol' . $data->icno == Yii::$app->request->post($data->icno)) {

                    $patrol = TblRekodPatrol::find()->where(['icno' => $data->icno])->andWhere(['patrol_id' => $id])->exists();
                    // $exist = TblRollcall::find()->where(['anggota_icno' => $data->icno])->andWhere(['date' => $date])->andWhere(['type' => 'H'])->exists();
                    //var_dump($exist);die
                    if (!$patrol) {
                        $model = new TblRekodPatrol();
                        $roll = new TblRollcall();
                        $model->icno = $data->icno;
                        // $model->month = date('m');
                        $model->day = date('l');
                        $model->time_in = date('Y-m-d H:i:s');
                        // $model->in_lat_lng = Yii::$app->request->post()['TblRekodOt']['latlng'];
                        $model->in_ip = $current_ip;
                        $model->tarikh = date('Y-m-d');
                        // $model->year = date('Y');
                        $model->patrol_id = $id;
                        // $model->kk_icno = $icno;
                        // $model->created_at = date('Y-m-d H:i:s');
                        // $model->isActive = 1;
                        $model->campus_id = $data->campus_id;
                        $roll->anggota_icno = $data->icno;
                        $roll->month = date('m');
                        $roll->time = date('Y-m-d H:i:s');
                        $roll->date = date('Y-m-d');
                        $roll->year = date('Y');
                        $roll->pos_kawalan_id = $id;
                        // $roll->syif = $id;
                        $roll->HKWLN = '1';
                        $roll->THBKWLN = '0';
                        $roll->campus_id = $data->campus_id;
                        $roll->type = "KWLN";
                        $roll->type = "NO_STS";
                        $roll->sts_sent = "NO_STS";
                        $roll->save(false);
                        $model->save(false);
                    }
                }
            }
        }

        $query = TblPatrolStaff::find()->where(['campus_id' => $campus->campus_id])->andWhere(['patrol_pos_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 250,
            ],
        ]);

        return $this->render('clock-patrol', [
            'id' => $id,
            'var' => $var,
            'dataProvider' => $dataProvider,
            'campus' => $campus,

        ]);
    }

    //do setup
    public function actionDoSetup($tahun = null, $bulan = null, $syif = null, $camp = null)
    {

        // var_dump($tahun,$bulan,$camp);die;
        $icno = Yii::$app->user->getId();
        $cmp = TblAkses::findOne(['icno' => $icno]);

        if (!$bulan) {
            $bulan = date('m');
        }

        if (!$tahun) {
            $tahun = date('Y');
        }
        if (!$syif) {
            $syif = 3;
        }

        $admin = false;
        $var = $this->getDaysInYearMonth($tahun, $bulan, 'd');
        $day = $this->getDaysInYearMonth($tahun, $bulan, 'D');
        // var_dump($var);die;

        if ($cmp->akses_level == 1) {
            $admin = true;
            $staffs = TblAkses::find()->where(['NOT IN', 'akses_level', ['1', '4']])->andWhere(['NOT IN', 'icno', '731011135058'])->andWhere(['campus_id' => $camp])->orderBy(['akses_level' => SORT_DESC])->all();
        } else {
            $staffs = TblAkses::find()->where(['NOT IN', 'akses_level', ['1', '4']])->andWhere(['NOT IN', 'icno', '731011135058'])->andWhere(['campus_id' => $cmp->campus_id])->orderBy(['akses_level' => SORT_DESC])->all();
        }

        return $this->render('do-setup', [
            'staffs' => $staffs,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'var' => $var,
            'day' => $day,
            'bil' => 1,
            'syif' => $syif,
            'camp' => $camp,
            'admin' => $admin
        ]);
    }
    //create shift do
    public function actionCreateDo($id, $tahun, $bulan)
    {

        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');

        $wp = RefShifts::find()->all();
        $staf = TblAkses::find()->where(['icno' => $id])->one();

        $count = count($this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d'));
        $staffname = Tblprcobiodata::DisplayNameGred($id);
        $models = [new TblJadualDoPm()];

        for ($i = 1; $i < $count; $i++) {
            $models[] = new TblJadualDoPm();
            //                        var_dump($models);die;
        }
        //        var_dump($i);die;

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {

            //          var_dump($i);die;
            foreach ($models as $m) {
                if (($m->shift_id) == null) {
                    $m->shift_id = 1;
                }
                $m->icno = $id;
                $m->year = '2021';
                // $m->year = date('Y');
                $m->month = date('m', strtotime('+3 day'));;
                // $m->pos_kawalan_id = $staf->pos_kawalan_id;
                // $m->unit_id = $staf->unit_id;
                $m->campus_id = $staf->campus_id;

                $m->save(false);
            }
            return $this->redirect(['keselamatan/do-setup', 'tahun' => $tahun, 'bulan' => $bulan]);
        }

        return $this->renderAjax('create-do', [
            'models' => $models,
            'icno' => $id,
            'var' => $var,
            'wp' => $wp,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'staffname' => $staffname,
        ]);
    }
    //update do
    public function actionUpdateDo($id, $tahun, $bulan)
    {

        $models = TblJadualDoPm::find()->where(['icno' => $id, 'month' => $bulan])->andWhere(['YEAR(tarikh)' => $tahun])->indexBy('id')->all();

        $wp = RefShifts::find()->all();
        //    var_dump($id, $tahun, $bulan);die;
        //    var_dump($);die;
        $staffname = Tblprcobiodata::DisplayNameGred($id);
        $staf = TblAkses::find()->where(['icno' => $id])->one();

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            //            var_dump('d');die;
            foreach ($models as $model) {
                if ($model->shift_id == "") {
                    $model->shift_id = 1;
                }
                $model->save(false);
            }
            return $this->redirect(['keselamatan/do-setup', 'tahun' => $tahun, 'bulan' => $bulan]);
        }

        return $this->renderAjax('update-do', ['models' => $models, 'wp' => $wp, 'staffname' => $staffname, 'bulan' => $bulan, 'tahun' => $tahun]);
    }

    //tindakan bertulis or lisan
    public function actionKakitangan()
    {
        $carian = new Tblprcobiodata();
        $id = Yii::$app->request->queryParams;
        //        var_dump($id['Tblprcobiodata']['carian_department']);die;
        if (!$id) {
            $query = Tblprcobiodata::find()
                ->where(['!=', 'status', 6])
                ->andWhere(['IN', 'DeptId', ['2', '139', '33']])
                ->andWhere(['IN', 'gredJawatan', ['118', '119', '295', '302', '303', '360', '388', '389', '43', '44', '116', '117', '211', '413']]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 250,
                ],
            ]);
        } else {
            //        var_dump($id);die;
            $dataProvider = $carian->carianKeselamatan(Yii::$app->request->queryParams);
        }
        return $this->render('kakitangan', [
            'carian' => $carian,
            'model' => $dataProvider,
            'bil' => 1
        ]);
    }


    public function actionReportSummary()
    {
        $id = Yii::$app->user->getId();

        $tarikh = "2020-04-22";
        $syif = "A";
        $campus = TblAkses::findOne(['icno' => $id]);
        // $unit = RefUnit::find()->where(['>','id','20'])->anall();
        $var = NULL;
        $var1 = NULL;
        if ($tarikh && $syif) {
            $var1 = RefUnit::find()->where(['<', 'id', '39'])->andWhere(['c_report_id' => $campus->campus_id])->all();
            $var = RefUnit::find()->where(['>', 'id', '38'])->andWhere(['c_report_id' => $campus->campus_id])->all();
        }
        $bil = 1;
        $jumlah1 = TblShiftKeselamatan::find()->where(['tarikh' => $tarikh])->andWhere(['IN', 'shift_id', ['3', '4', '5']])->andWhere(['campus_id' => $campus->campus_id])->count();
        $jumlah2 = TblOt::find()->where(['tarikh' => $tarikh])->andWhere(['IN', 'shift_id', ['3', '4', '5']])->andWhere(['campus_id' => $campus->campus_id])->count();
        $jumlah3 = TblLmt::find()->where(['tarikh' => $tarikh])->andWhere(['IN', 'lmt_id', ['3', '4', '5']])->andWhere(['campus_id' => $campus->campus_id])->count();

        $jumlah = $jumlah1 + $jumlah2 + $jumlah3;
        // var_dump($var);die;      

        return $this->render('report-summary', [
            // 'model' => $model
            'var' => $var,
            'var1' => $var1,
            'bil' => $bil,
            // 'unit'=>$unit,
        ]);
    }

    //percubaan masukkn smua kehadiran dlam stu page ot dn hakiki
    public function actionAttendanceReport($id = null, $tahun = null, $bulan = null)
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

        $sql = 'SELECT * FROM keselamatan.tbl_reports WHERE icno=:icno AND MONTH(tarikh)=:mth';
        $reports = TblReports::findBySql($sql, [':icno' => $id, ':mth' => $mth])->asArray()->all();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        //        $warna_kad = \app\models\keselamatan\TblWarnakad::WarnaKadSemasa($id, $mth);
        $warna_kad = \app\models\keselamatan\TblWarnakad::WarnaKadSemasa($id, $mth, NULL, $year);


        return $this->render('attendance-report', ['reports' => $reports, 'var' => $var, 'icno' => $id, 'tahun' => $year, 'bulan' => $mth, 'biodata' => $biodata, 'warna_kad' => $warna_kad]);
    }

    //monitor
    public function actionAttendanceMonitoring($date = null)
    {

        $today = date('Y-m-d');


        if ($date) {
            $today = $date;
        }

        $icno = Yii::$app->user->getId();


        $sql = 'SELECT * FROM e_cuti.set_pegawai WHERE peraku_icno=:icno OR pelulus_icno=:icno';
        $model = SetPegawai::findBySql($sql, [':icno' => $icno])->all();

        return $this->render('attendance-monitoring', ['model' => $model, 'bil' => 1, 'today' => $today]);
    }

    //warnna kad

    public function actionCardColorList($year = NULL, $month = NULL, $camp = null, $color = null)
    {

        $icno = Yii::$app->user->getId();

        if (!$year) {
            $year = date('Y');
        }
        if (!$month) {
            $month = date('m');
        }
        if ($color == "NULL") {
            $color = null;
        }

        $arr_dept = array();
        $arr_campus = array();


        $isAdmin = TblAkses::findOne(['icno' => $icno])->akses_level == 1 ? true : false;
        // var_dump($isAdmin);die;
        // $model = Department::find()->where(['isActive' => 1])->all();

        // foreach ($model as $r) {
        //     $arr_dept[] = $r->akses_jspiu_id;
        // }

        if ($color) {

            $sql = 'SELECT * FROM keselamatan.tbl_staff_keselamatan a 
                JOIN keselamatan.tbl_warnakad b ON a.staff_icno = b.icno
                WHERE MONTH(b.month_date) = :month AND YEAR(b.month_date) = :year AND b.color = :color';

            $model = TblStaffKeselamatan::findBySql($sql, [':month' => $month, ':color' => $color, ':year' => $year])->all();
        } elseif ($camp) {
            $model = TblStaffKeselamatan::find()->where(['isActive' => 1, 'campus_id' => $camp])->all();
        } else {
            $model = TblStaffKeselamatan::find()->where(['isActive' => 1])->all();
        }


        // $model = Tblprcobiodata::find()->where(['Status' => 1, 'ICNO' => $arr_icno, 'campus_id' => $arr_campus])->all();

        return $this->render(
            'card-color-list',
            [
                'isAdmin' => $isAdmin, 'camp' => $camp,
                'model' => $model, 'bil' => 1, 'month' => $month, 'year' => $year, 'color' => $color
                // 'model_dept' => $model_dept
            ]
        );
    }

    //color rpt
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

        $sql = 'SELECT * FROM keselamatan.tbl_warnakad a JOIN hronline.tblprcobiodata b ON a.icno = b.ICNO
                JOIN hronline.gredjawatan c ON b.gredjawatan = c.id
                WHERE MONTH(a.month_date) = :month AND YEAR(a.month_date) = :year AND a.color = :color ORDER BY b.deptId, b.CONm';

        $model = TblWarnaKad::findBySql($sql, [':month' => $month, ':color' => $color, ':year' => $tahun])->all();

        $total = count($model);


        return $this->render('color-rpt', ['model' => $model, 'bil' => 1, 'month' => $month, 'tahun' => $tahun, 'monthBefore' => ($month - 1), 'color' => $color, 'total' => $total]);
    }
    public function actionLetter($id, $tahun, $bulan, $color)
    {
        //    $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
        if ($color == 'RED') {
            $letter = '_red_letter';
        }
        if ($color == 'GREEN') {
            $letter = '_green_letter';
        }

        $sql_bio = 'SELECT * FROM hronline.tblprcobiodata WHERE MD5(ICNO) =:icno';
        // var_dump($sql_bio);die;
        $biodata = Tblprcobiodata::findBySql($sql_bio, [':icno' => $id])->one();
        // var_dump($biodata->ICNO);die;
        $css = file_get_contents('./css/surat.css');
        //        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');

        $sblm = $bulan - 1;

        //    $month = TblRekod::viewBulan($bulan);
        $sql = 'SELECT * FROM keselamatan.tbl_rekod WHERE MD5(icno) =:icno AND MONTH(tarikh)=:month AND remark_status = "REJECTED"';
        $sql1 = 'SELECT * FROM keselamatan.tbl_rekod_ot WHERE MD5(icno) =:icno AND MONTH(tarikh)=:month AND remark_status = "REJECTED"';
        $rekod = TblRekod::findBySql($sql, [':month' => $sblm, ':icno' => $id])->all();
        $rekodot = TblRekodOt::findBySql($sql1, [':month' => $sblm, ':icno' => $id])->all();

        // var_dump($rekodot);die;
        $this->view->title = "Surat Pemakluman";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial($letter, ['biodata' => $biodata, 'rekod' => $rekod, 'rekodot' => $rekodot, 'bulan' => $bulan, 'bil' => 1]);

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
    public function actionKjMonitor($date = null, $camp = null)
    {
        $icno = Yii::$app->user->getId();
        $chief = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $today = date('Y-m-d');

        if ($date) {
            $today = $date;
        }
        if (!$camp) {
            $camp = 1;
            $list_staff = TblStaffKeselamatan::find()->where(['isActive' => 1])->all();
        }




        // $list_staff = Tblprcobiodata::find()->where(['Status' => 1, 'DeptId' => $chief->DeptId])->all();

        return $this->render('kj-monitor', ['list_staff' => $list_staff, 'bil' => 1, 'today' => $today, 'camp' => $camp]);
    }

    //developing new import method
    public function actionImportMethod()
    {
        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);
        $modelImport->addRule(['fileImport'], 'required');
        $modelImport->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx'], ['maxSize' => 1024 * 1024]);

        if (Yii::$app->request->post()) {
            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');
            if ($modelImport->fileImport && $modelImport->validate()) {
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($modelImport->fileImport->tempName);
                $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $baseRow = 3;
                while (!empty($sheetData[$baseRow]['A'])) {

                    $model = new TempTable();
                    // var_dump($model);die;
                    $model->no_pekerja = (string) $sheetData[$baseRow]['B'];
                    $model->name = $this->name((string) $sheetData[$baseRow]['B']);
                    $model->pos = $this->checkpos((string) $sheetData[1]['B']);
                    $model->uploader = Yii::$app->user->getId();
                    $model->month =  date('m', strtotime('+10 day'));
                    $model->save();

                    $baseRow++;
                }
                // die;
                // Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jadual Lebih Masa Berjadual Berjaya Di Muat Naik']);
                return $this->redirect('view-import');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }

        return $this->render('import-method', [
            'modelImport' => $modelImport,
        ]);
    }

    public function actionViewImport()
    {
        $id = Yii::$app->user->getId();
        // $v = false;

        $model = TempTable::find()->where(['uploader' => $id])->all();
        $verifier = TempTable::find()->where(['uploader' => $id])->andWhere(['name' => 'UMSPER ERROR'])->exists();

        // var_dump($verifier);die;
        return $this->render('view-import', [
            'model' => $model,
            'bil' => 1,
            'verifier' => $verifier,
            // 'v'=>$v,

        ]);
    }
    public function actionReupload($c)
    {
        $id = Yii::$app->user->getId();

        if ($c == 1) {
            $temp = TempTable::find()->where(['uploader' => $id])->all();
            if ($temp) {
                foreach ($temp as $del) {
                    $del->delete();
                }
                return $this->redirect('import-method');
            }
        } else {
            $temp = TempTable::find()->where(['uploader' => $id])->all();
            if ($temp) {
                foreach ($temp as $del) {
                    $del->delete();
                }
                return $this->redirect('new-import');
            }
        }

        //    return $this->render('import-method', [
        //         // 'modelImport' => $modelImport,
        //     ]);
    }
    public function name($umsper)
    {
        $val = (new \yii\db\Query())
            ->select(['CONm'])
            ->from('hronline.tblprcobiodata')
            ->where(['COOldID' => $umsper])
            ->one();
        //        var_dump($val);die;
        if ($val) {
            $val1 = $val['CONm'];
        } else {
            $val1 = "UMSPER ERROR";
        }
        // var_dump($val1);die;
        return $val1;
    }

    public function checkpos($pos)
    {
        //        $val = '';
        //  var_dump($pos);die;
        $val = (new \yii\db\Query())
            ->select(['id'])
            ->from('keselamatan.ref_pos_kawalan')
            ->where(['pos_kawalan' => $pos])
            ->one();
        if ($val) {
            $v = $val['id'];
            $vid = RefPoskawalan::findOne(['id' => $v]);
            $val1 = $vid->pos_kawalan;
        } else {
            $val1 = "Pos Tidak Wujud";
        }
        //  var_dump($val1);die;
        return $val1;
    }

    public function actionDashboardIndex()
    {
        $id = Yii::$app->user->getId();

        $access = TblAkses::find()->where(['icno' => $id])->andWhere(['IN', 'akses_level', ['1', '3']])->one();
        // var_dump($access->icno);die;
        $date = date('Y-m-d');
        $a = TblShiftKeselamatan::find()->where(['tarikh' => $date])->andWhere(['shift_id' => 3])->andWhere(['campus_id' => $access->campus_id])->count();
        $b = TblShiftKeselamatan::find()->where(['tarikh' => $date])->andWhere(['shift_id' => 5])->andWhere(['campus_id' => $access->campus_id])->count();
        $c = TblShiftKeselamatan::find()->where(['tarikh' => $date])->andWhere(['shift_id' => 4])->andWhere(['campus_id' => $access->campus_id])->count();
        $aot = TblOt::find()->where(['tarikh' => $date])->andWhere(['shift_id' => 3])->andWhere(['campus_id' => $access->campus_id])->count();
        $bot = TblOt::find()->where(['tarikh' => $date])->andWhere(['shift_id' => 5])->andWhere(['campus_id' => $access->campus_id])->count();
        $cot = TblOt::find()->where(['tarikh' => $date])->andWhere(['shift_id' => 5])->andWhere(['campus_id' => $access->campus_id])->count();
        $almt = TblLmt::find()->where(['tarikh' => $date])->andWhere(['lmt_id' => 3])->andWhere(['campus_id' => $access->campus_id])->count();
        $blmt = TblLmt::find()->where(['tarikh' => $date])->andWhere(['lmt_id' => 5])->andWhere(['campus_id' => $access->campus_id])->count();
        $clmt = TblLmt::find()->where(['tarikh' => $date])->andWhere(['lmt_id' => 4])->andWhere(['campus_id' => $access->campus_id])->count();
        // $hadirA = TblRekod::find()->where(['tarikh' => $date])->andWhere(['wp_id' => 3])->andWhere(['HH' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
        // $hadirLMJ = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['HLMJ' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();
        // $hadirLMT = TblRollcall::find()->where(['date' => $tarikh])->andWhere(['syif' => $syif])->andWhere(['HLMT' => '1'])->andWhere(['campus_id' => $campus->campus_id])->count();

        $syifA = $a + $aot + $almt;
        $syifB = $b + $bot + $blmt;
        $syifC = $c + $cot + $clmt;

        return $this->render('dashboard-index', [
            'syifA' => $syifA,
            'syifB' => $syifB,
            'syifC' => $syifC,
            // 'v'=>$v,

        ]);
    }
    public function actionViewRollcall($id = null, $date = null)
    {
        $model = TblRollcall::find()->where(['anggota_icno' => $id])->andWhere(['date' => $date])->all();


        return $this->render('view-rollcall', [
            'model' => $model,
            'bil' => 1,
            'id' => $id,
            'date' => $date,

        ]);
    }



    //developing new clockin index

    public function actionNewIndex()
    {
        $id = Yii::$app->user->getId();
        $tdate = date('Y-m-d');
        $h = TblShiftKeselamatan::find()->where(['icno' => $id])->andWhere(['tarikh' => $tdate])->one();
        $lmj = TblOt::find()->where(['icno' => $id])->andWhere(['tarikh' => $tdate])->one();
        $rekod_h = TblRekod::find()->where(['icno' => $id])->andWhere(['tarikh' => $tdate])->andWhere(['time_out' => NULL])->one();
        $rekod_l = TblRekodOt::find()->where(['icno' => $id])->andWhere(['tarikh' => $tdate])->andWhere(['time_out' => NULL])->one();
        // var_dump($rekod_l);die;
        // var_dump($h->shift_id);die;

        if ($h->shift_id == 1 && $lmj->shift_id == 1) {
            return $this->redirect(['index']);
        }
        if ($rekod_l != NULL && $rekod_h == NULL) {
            echo "Match found lmj";
            die;
            return $this->redirect(['index1']);
        }
        if ($rekod_h != NULL && $rekod_l == NULL) {
            echo "Match found h";
            die;
            return $this->redirect(['index']);
        }
        if (($h->shift_id < $lmj->shift_id) && $rekod_h != NULL) {
            echo "Match found";
            die;

            return $this->redirect(['index']);
        }
        if ($h->shift_id < $lmj->shift_id && $rekod_h == NULL) {
            echo "Match founds";
            die;

            return $this->redirect(['index1']);
        }
        if ($h->shift_id > $lmj->shift_id && $rekod_l != NULL) {
            echo "Match s found";
            die;

            return $this->redirect(['index1']);
        }
        if ($h->shift_id > $lmj->shift_id && $rekod_l == NULL) {
            echo "Match s s found";
            die;

            return $this->redirect(['index']);
        }
        // else{
        //     echo "Match Not found";die;

        //     return $this->redirect(['index']);

        // }

    }

    public function actionLaporan($tahun = null, $camp = null)
    {

        $year = date('Y');
        $var = null;
        if ($tahun != null && $camp != null) {
            $tahun = $year;
            $var = 1;
        }
        //   echo $var;die;
        $arr = [' ', 'THB', 'THTC-H', 'THTC-LMJ', 'CR', 'CS', 'CK', 'CTR', 'CGKA', 'CKA', 'CG', 'CSG', 'CTG', 'LATE-IN', 'EARLY-OUT', 'STS DIKELUARKAN'];

        return $this->render('laporan', [
            'var' => $var,
            'bil' => 1,
            'tahun' => $tahun,
            'arr' => $arr,
            'camp' => $camp,
            // 'y'=>$y,

        ]);
    }
    public function actionShortReport($tahun, $camp)
    {
        $arr = [' ', 'THB', 'THTC-H', 'THTC-LMJ', 'CR', 'CS', 'CK', 'CTR', 'CGKA', 'CKA', 'CG', 'CSG', 'CTG', 'LATE-IN', 'EARLY-OUT', 'STS DIKELUARKAN'];
        $var = 1;

        $this->view->title = "Laporan Ringkasan Kehadiran Anggota Tahun ($tahun)";
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_laporan', ['tahun' => $tahun, 'camp' => $camp, 'arr' => $arr, 'var' => $var, 'bil' => 1]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Laporan Ringkasan Kehadiran Anggota Tahun $tahun.pdf",
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
            'options' => ['title' => "Laporan Ringkasan Kehadiran Anggota Tahun $tahun"],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ["Laporan Ringkasan Kehadiran Anggota Tahun $tahun"],
                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                //                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionReprimandList($month = null, $year = null)
    {
        $id = Yii::$app->user->getId(); //getting user id

        if (!$month) {
            // $month = date('m');
            $month = "5";
        }

        // if (!$year) {
        $year = date('Y');
        // $year = "2020";
        // }

        $staff = TblAkses::findOne(['icno' => $id]);

        $staf = TblTindakanBertulisLisan::find()->all();

        $searchModel = new TblTindakanLisanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('reprimand-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'staf' => $staf,
            'tahun' => $year,
            'bil' => 1,
        ]);
    }

    public function actionManualClock($syif = null, $date = null)
    {

        $var = null;

        if (!$syif) {
            $syif = 3;
        }
        if (!$date) {
            $syif = date("Y-m-d");
        }
        if ($syif && $date) {
            $var = 1;
            $modelot = TblOt::find()->where(['tarikh' => $date])->andWhere(['shift_id' => $syif])->all();
            // var_dump($modelot);die;
        }
        return $this->render('manual-clock', [
            'id' => $syif,
            'date' => $date,
            'var' => $var,


        ]);
    }
    public function actionRecord($icno, $id)
    {
        // var_dump($icno);die;
        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        if ($id == 1) {
            // echo 'd';die;
            $month = date('m');
            $status = ['REMARKED', 'APPROVED', 'REJECTED'];
            $model = TblRekod::find()->where(['icno' => $icno]);
            //    var_dump($model);die;

        }
        if ($id == 2) {
            // echo 'd';die;
            $month = date('m');
            $status = ['REMARKED', 'APPROVED', 'REJECTED'];
            $model = TblRekodOt::find()->where(['icno' => $icno]);
            //    var_dump($model);die;

        }


        $provider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    //                    'icno' => SORT_DESC,
                    'tarikh' => SORT_DESC,
                ]
            ],
        ]);

        return $this->renderAjax('record', ['model' => $provider, 'biodata' => $biodata]);
    }
    public function actionRecordWarning($icno)
    {
        // var_dump($icno);die;
        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);


        // echo 'd';die;
        $month = date('m');
        $status = ['REMARKED', 'APPROVED', 'REJECTED'];
        $model = TblTindakanBertulisLisan::find()->where(['receiver_icno' => $icno]);
        //    var_dump($model);die;




        $provider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ]
            ],
        ]);

        return $this->renderAjax('record-warning', ['model' => $provider, 'biodata' => $biodata]);
    }
    public function actionRecordRollcall($icno)
    {
        // var_dump($icno);die;
        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        // echo 'd';die;
        $month = date('m');
        $status = ['REMARKED', 'APPROVED', 'REJECTED'];
        $model = TblRollcall::find()->where(['anggota_icno' => $icno])->andWhere([

            'or',

            ['=', 'THBH', '1'],
            ['=', 'THBLMJ', '1'],
            ['=', 'THBLMT', '1'],
            ['=', 'THBKWLN', '1'],
            ['=', 'THTC', '1'],
            ['=', 'THH', '1'],
            ['=', 'THTC', '1'],
            ['=', 'THLMJ', '1'],
            ['=', 'THLMT', '1'],
            ['=', 'THKWLN', '1'],
        ]);
        //    var_dump($model);die;




        $provider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    //                    'icno' => SORT_DESC,
                    'date' => SORT_DESC,
                ]
            ],
        ]);

        return $this->renderAjax('record-rollcall', ['model' => $provider, 'biodata' => $biodata]);
    }


    public function actionTblSetPegawaiIndex()
    {
        $icno = Yii::$app->user->getId();
        $model = TblSetPegawai::find()->where(['active' => 1])->all();

        //    var_dump($model);die;
        return $this->render('set-pegawai-index', [
            'model' => $model,
            'bil' => 1
        ]);
    }
}
