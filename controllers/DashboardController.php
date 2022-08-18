<?php

namespace app\controllers;

use app\models\cuti\SetPegawai;
use app\models\cuti\TblRecords;
use app\models\hronline\Department;
use app\models\system_core\TblDahsboard;
use Yii;
use app\models\system_core\TblPendingTask;
use app\models\system_core\TblShortcut;
use app\models\kehadiran\TblSelfhealth;
use app\models\kehadiran\TblRekod;
use app\models\kehadiran\TblWfh;
use app\models\kehadiran\TblWp;
use app\models\kehadiran\RefWp;
use app\models\kehadiran\TblWarnaKad;
use app\models\system_core\TblPendingTaskcommand;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\hronline\Tblvaksinasi;
use app\models\keselamatan\RefShifts;
use app\models\keselamatan\TblShiftKeselamatan;
use app\models\keselamatan\TblStaffKeselamatan;
use tebazil\runner\ConsoleCommandRunner;
use app\models\hronline\Tblstatusvaksinasi;
use app\models\system_core\TblDashboardInfo;

class DashboardController extends \yii\web\Controller
{
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

    public function actionIndex()
    {
        $icno = Yii::$app->user->getId();
        $runner = new ConsoleCommandRunner();
        try {
            $runner->run('dashboard/pending-task-individu', [$icno]);
        } catch (\Exception $e) {
        }
        $today = date('Y-m-d');
        $statuswfh = TblWfh::getStatusWfh($icno, $today);

        if (!Yii::$app->MP->isAllowedClockin($icno)['status']) {
            if (Yii::$app->MP->isAllowedClockin($icno)['category'] == 1) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Anda diminta untuk melengkapkan maklumat vaksinasi sebelum clock-in. ']);
                return $this->redirect(['vaksinasi/view-st-vaksinasi']);
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Anda diminta untuk mengambil sample covid-19 di pusat rawatan warga UMS atau melengkapkan maklumat vaksinasi and sebelum clock-in. ']);
            return $this->redirect(['vaksinasi/view-st-vaksinasi']);
        }

        if (Tblstatusvaksinasi::isRegistered($icno) == 0 && !$this->VaksinasiReminderExist()) {
            $this->pendingtask($icno, 'Maklumat Peribadi: Program Vaksinasi', 'vaksinasi/view-st-vaksinasi', 'eyedropper');
        } else if (Tblstatusvaksinasi::isRegistered($icno) == 1 && $this->VaksinasiReminderExist()) {
            $this->pendingtask($icno, 'Maklumat Peribadi: Program Vaksinasi', 'vaksinasi/view-st-vaksinasi', 'eyedropper', '1');
        }

        if (!Tblvaksinasi::isRegistered($icno)) {
            return $this->redirect(['vaksinasi/update', 'from' => 3]);
        }

        if (!$statuswfh) {
            $checkHealth = TblSelfhealth::checktoday();
            if (!$checkHealth) {
                return $this->redirect(['selfhealth/index']);
            }
        }

        $info = TblDahsboard::findOne(['icno' => $icno]);
        $pendingtask = TblPendingTask::find()->where(['status' => 1, 'icno' => [$icno, 'all']])->andWhere(['>', 'count', 0])->all();
        //        $shortcut = TblShortcut::find()->where(['access' => $icno])->orWhere(['role' => 'all'])->all();
        $staff_keselamatan = TblStaffKeselamatan::find()->where(['staff_icno' => $icno])->andWhere(['=', 'isExcluded', '0'])->andWhere(['isActive' => 1])->exists();
        $onleave = TblRecords::count($icno);
        $dept = Department::findOne(['id' => 2]); //special utk keselamatan
        $peg = SetPegawai::find()->where(
            [
                'or',
                ['pelulus_icno' => $icno],
                ['peraku_icno' => $icno]
            ]
        )->one();
        // if ($icno == $dept->chief) {
        //     $onleave = TblRecords::countskb($icno);
        // }

        if ($staff_keselamatan) {
            $data = $this->keselamatan($icno);
            $placeholder = 'keselamatan';
            $type = "SKB";
        } else {
            $data = $this->kehadiran($icno);
            $placeholder = 'kehadiran';
            $type = "STARS";
        }

        return $this->render('index', [
            'type' => $type,
            'placeholder' => $placeholder,
            'pendingtask' => $pendingtask,
            'info' => $info,
            'onleave' => $onleave,
            'peg' => $peg,
            'upevent' => array(),
            'data' => $data,
        ]);
    }

    //kehadiran
    protected function kehadiran($icno)
    {
        $today = date('Y-m-d');

        // Work from Home
        $statuswfh = TblWfh::getStatusWfh($icno, $today);
        $wfh = $statuswfh ? '<span class="label label-warning" style="font-size:14px">Work From Home</span>' : '<span class="label label-warning" style="font-size:14px">Work At Office</span>';


        $month = date('m');
        $year = date('Y');
        $hour_complete = 0;
        $curr_total_hours = '';
        $time_now = date('H:i:s');
        $link = 'clock-in';
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
            $link = 'clock-out';
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

        return [
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
        ];
    }
    protected function keselamatan($icno)
    {

        // $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');
        // $w = ['720406125643', '780315125669'];

        // if ($icno == $w[0] || $icno == $w[1]) {
        //     return $this->redirect(['keselamatan/main']);
        // }
        $time = date('h:i A');
        $hour_complete = 0;
        $curr_total_hours = '';

        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));


        $check = \app\models\keselamatan\TblRekod::find()->where(['icno' => $icno])
            ->andWhere(['tarikh' => $date_before])
            ->andWhere(['time_out' => NULL])
            ->exists();
        $check2 = \app\models\keselamatan\TblRekod::find()->where(['icno' => $icno])
            ->andWhere(['tarikh' => $date_before])
            ->andWhere(['time_in' => NULL])
            ->exists();


        $statuswfh = TblWfh::getStatusWfh($icno, $today);
        $wfh = $statuswfh ? '<span class="label label-warning" style="font-size:14px">Work From Home</span>' : '<span class="label label-warning" style="font-size:14px">Work At Office</span>';
       
        $link = 'keselamatan/clock-in';

        $model = new \app\models\keselamatan\TblRekod();
        $model->scenario = 'location';

        $hours = date('H:i:s');
        $hour = (int) date('G');
        // var_dump($hour);die;

        if ($check && !$check2 && ($hour >= 0 && $hour < 1)) {

            $wp_id = TblShiftKeselamatan::last_wp($icno);
            // var_dump($wp_id);die;
            $model_rekod = \app\models\keselamatan\TblRekod::find()->where(['icno' => $icno])->andWhere(['tarikh' => $date_before])->andWhere(['time_out' => NULL])->one();
        } else {
            $wp_id = TblShiftKeselamatan::curr_wp($icno);
            $model_rekod = \app\models\keselamatan\TblRekod::findOne(['icno' => $icno, 'tarikh' => $today]);
        }

        $model_wp = RefShifts::findOne(['id' => $wp_id]);

        $var = \app\models\keselamatan\TblRekod::find()->where(['icno' => $icno])->andWhere(['tarikh' => date('Y-m-d')])->one();
        if ($model_wp != NULL && $var == NULL && $model_wp == '3' && $model_wp == '4' && $model_wp == '5') {

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
        $time = \app\models\keselamatan\TblRekod::masaMasuk($wp_id, $time_in);
        $total_hours = isset($model_rekod->time_out) ? \app\models\keselamatan\TblRekod::totalHour($time, $time_out) : '-';
        $statusAll = $model_rekod ? $model->getStatusAll() : '-';
        if ($model_rekod) {
            // echo 'dd';die;
            $model = $model_rekod;
            $statusAll = $model->getStatusAll();
            $link = 'keselamatan/clock-out';
            $time_now = date('h:i A');
            $time_nows = date('h:i:s');
            $curr_total_hours = RefShifts::totalHours($time, $time_now, $model_wp->start_time);

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

        return [
            'model' => $model,
            'model_wp' => $model_wp,
            'wp_id' => $wp_id,
            'time_in' => $time_in,
            'time_out' => $time_out,
            'total_hours' => $total_hours,
            'current_ip' => $current_ip,
            'ip_type' => $ip_type,
            'statusAll' => $statusAll,
            'color' => \app\models\keselamatan\TblWarnaKad::WarnaKadSemasa($icno, $month_warna, NULL, $year),
            'pendingNoti' => \app\models\keselamatan\TblRekod::totalPendingAll($icno),
            'url_zone' => Yii::$app->urlManager->createUrl("keselamatan/zone"),
            'url_zone2' => Yii::$app->urlManager->createUrl("keselamatan/zone"),
            'url_tidakpatuh' => Yii::$app->urlManager->createUrl("kehadiran/graf-tidakpatuh"),
            'url_approve' => Yii::$app->urlManager->createUrl("kehadiran/graf-approve"),
            'link' => $link,
            'timediff' => $timediff,
            'curr_total_hours' => $curr_total_hours,
            'hour_complete' => $hour_complete,
            'wfh' => $wfh,
        ];
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
                return $this->redirect(['index']);
            }

            $time = date('H:i:s');

            $checkStatusIn = RefWp::checkStatusIn($icno, $today, $time, $wp_id);

            $checkExternal = KehadiranController::checkExternal($current_ip, Yii::$app->request->post()['TblRekod']['latlng']);


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
                return $this->redirect(['index']);
            }
        }
    }

    public function actionClockOut()
    {

        $icno = Yii::$app->user->getId();
        $current_ip = KehadiranController::getRealUserIp();
        $wp_id = TblWp::curr_wp($icno);
        $model_wp = RefWp::findOne(['id' => $wp_id]);
        $today = date('Y-m-d');
        $time = date('H:i:s');

        $model = TblRekod::current($icno, $today, $wp_id, $model_wp->next_day);

        //utk kes time in, time out, ot in, ot out yang 'required' latlng(location)
        $model->scenario = 'location';
        if ($model->load(Yii::$app->request->post())) {

            $checkStatusOut = RefWp::checkStatusOut($icno, $today, date('H:i:s'), $wp_id);
            $checkExternal = KehadiranController::checkExternal($current_ip, Yii::$app->request->post()['TblRekod']['latlng']);

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
                return $this->redirect(['index']);
            }
        }
    }

    //pendingtaskcommand
    public function pendingtask($icno, $name, $url, $icon = null, $count = null)
    {
        $model = TblPendingtask::find()->where(['icno' => $icno, 'name' => $name, 'url' => $url])->exists() ?
            TblPendingtask::find()->where(['icno' => $icno, 'name' => $name, 'url' => $url])->one() :
            new TblPendingtask(['icno' => $icno, 'name' => $name, 'url' => $url]);
        $icon ? $model->icon = $icon : '';
        $model->count = $count == 1 ?  ($model->count - 1) : ($model->count + 1);
        $model->status = 1;
        $model->save(false);
    }

    public function actionUpdatetaskcommand($id = null)
    {
        $icno = Yii::$app->user->getId();
        $model = $id ? TblPendingTaskcommand::find()->where(['id' => $id])->one() : new TblPendingTaskcommand(['added_by' => $icno]);

        if ($model->load(Yii::$app->request->post())) {
            eval('return ' . $model->command);
            if (strpos($model->command, '$icno') == false) {
                Yii::$app->session->setFlash('alert', ['title' => 'Cannot be submitted', 'type' => 'error', 'msg' => ""]);
                return $this->redirect('updatetaskcommand');
            }
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => ""]);
            return $this->redirect('listtaskcommand');
        }
        $list_controllers = Yii::$app->metadata->getControllersActions();
        $temp = [];

        foreach ($list_controllers as $n) {
            $temp[$n] = $n;
        }
        return $this->render('updatetaskcommand', ['model' => $model, 'list_controllers' => $temp]);
    }

    public function actionListtaskcommand()
    {
        $dataProvider = new ActiveDataProvider([

            'query' => TblPendingTaskcommand::find(),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);

        return $this->render('listtaskcommand', ['dataProvider' => $dataProvider]);
    }

    public function actionDeletetaskcommand($id)
    {
        TblPendingTaskcommand::find()->where(['id' => $id])->one()->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => ""]);
        return $this->redirect('listtaskcommand');
    }


    //shortcut
    public function actionListshortcut()
    {
        $dataProvider = new ActiveDataProvider([

            'query' => TblShortcut::find(),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);

        return $this->render('listshortcut', ['dataProvider' => $dataProvider]);
    }
    public function actionUpdateshortcut($id = null)
    {
        $model = $id ? TblShortcut::find()->where(['id' => $id])->one() : new TblShortcut();

        if ($model->load(Yii::$app->request->post())) {
            //            if($model->role == 'dept'){
            //                $dept = Yii::$app->request->post('dept');
            //                foreach ($dept as $d){
            //                    $data = new TblShortcut();
            //                    $data->role = $model->role;
            //                    $data->url = $model->url;
            //                    $data->name = $model->name;
            //                    $data->access = $d;
            //                    $data->save(false);
            //                }
            //            }
            if ($model->role == 'staff') {
                $staff = Yii::$app->request->post('staff');
                foreach ($staff as $d) {
                    $data = new TblShortcut();
                    $data->role = $model->role;
                    $data->url = $model->url;
                    $data->name = $model->name;
                    $data->access = $d;
                    $data->save(false);
                }
            } else {
                $data = new TblShortcut();
                $data->role = $model->role;
                $data->url = $model->url;
                $data->name = $model->name;
                $data->save(false);
            }
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => ""]);
            return $this->redirect('listshortcut');
        }
        return $this->render('updateshortcut', ['model' => $model]);
    }
    public function actionDeleteshortcut($id)
    {
        TblShortcut::find()->where(['id' => $id])->one()->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => ""]);
        return $this->redirect('listshortcut');
    }

    public function notifyMeVaccination($icno)
    {
        $show = false;
        $hasAppt = \app\models\notifications\TblVaccinationAppointment::find()
            ->where(
                ['icno' => $icno]
            );

        if ($hasAppt->exists()) {
            $hasAppt1 = clone  $hasAppt;
            $hasAppt1->andFilterWhere(
                ['between', 'DATEDIFF(DAY, GETDATE(), vacDate1)', 0, 3]
            );

            $hasAppt2 = clone  $hasAppt;
            $hasAppt2->andFilterWhere(
                ['between', 'DATEDIFF(DAY, GETDATE(), vacDate2)', 0, 3]
            );

            if ($hasAppt1->exists()) {
                $apptArry = $hasAppt1->asArray()->one();
                $vacDate = $apptArry['vacDate1'];
                $vacLoc = $apptArry['vacLocation1'];
                $vacTime = $apptArry['vacTime1'];
                $show = true;
            } else if ($hasAppt2->exists()) {
                $apptArry = $hasAppt2->asArray()->one();
                $vacDate = $apptArry['vacDate2'];
                $vacLoc = $apptArry['vacLocation2'];
                $vacTime = $apptArry['vacTime2'];
                $show = true;
            }
        }

        $vaccArray = [
            'show' => $show,
            'date' => $show ? \Yii::$app->formatter->asDate($vacDate, 'dd/MM/yyyy') : 'Error: not found',
            'location' => $show ? $vacLoc : 'Error: not found',
            'time' => $show ? $vacTime : 'Error: not found',
        ];

        return $vaccArray;
    }

    private static function VaksinasiReminderExist()
    {
        if (TblPendingtask::find()->where(['icno' => Yii::$app->user->getId(), 'name' => 'Maklumat Peribadi: Program Vaksinasi', 'url' => 'vaksinasi/view-st-vaksinasi'])->exists()) {
            return true;
        }
        return false;
    }
}
