<?php

namespace app\models\keselamatan;
use app\models\kehadiran\TblWp;
use app\models\kehadiran\TblRekod;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\hronline\Tblprcobiodata;
use app\models\cuti\CutiRekod;
use app\models\cuti\CutiUmum;
use app\models\cuti\TblRecords;
use app\models\KeluarPejabat;
use Yii;

/**
 * This is the model class for table "keselamatan.tbl_rekod_ot".
 *
 * @property int $id
 * @property string $icno
 * @property string $day
 * @property string $tarikh
 * @property string $time_in
 * @property string $time_out
 * @property string $ot_in
 * @property string $ot_out
 * @property int $reason_id refer table ref_reason
 * @property string $status_in LATE_IN, NO_PUNCH
 * @property string $status_out EARLY_OUT, INCOMPLETE
 * @property string $incomplete
 * @property string $absent 1 = kira absent | system generated
 * @property string $external 1 = external ip | 0 = internal ip
 * @property string $app_by
 * @property string $app_dt
 * @property string $remark_status ENTRY | APPROVED
 * @property int $wp_id refer table ref_wp
 * @property string $in_lat_lng
 * @property string $out_lat_lng
 * @property string $ot_in_lat_lng
 * @property string $ot_out_lat_lng
 * @property string $in_ip
 * @property string $out_ip
 * @property string $remark
 * @property string $app_remark
 * @property string $ot_in_ip
 * @property string $ot_out_ip
 */
class TblRekodLmt extends \yii\db\ActiveRecord
{
      public $latlng;
      public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_rekod_lmt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['tarikh', 'time_in', 'time_out', 'ot_in', 'ot_out', 'app_dt'], 'safe'],
            [['reason_id', 'wp_id'], 'integer'],
            [['icno'], 'string', 'max' => 15],
            [['latlng'], 'required', 'on' => 'location', 'message' => 'Please allow your Location !'],
//            [['remark_status'], 'required', 'on' => 'reason', 'message' => 'Sila Pilih Status Pengesahan !'],
            [['day', 'status_in', 'status_out', 'remark_status'], 'string', 'max' => 10],
            [['incomplete', 'absent', 'external'], 'string', 'max' => 1],
            [['app_by'], 'string', 'max' => 16],
            [['in_lat_lng', 'out_lat_lng', 'ot_in_lat_lng', 'ot_out_lat_lng'], 'string', 'max' => 50],
            [['in_ip', 'out_ip', 'ot_in_ip', 'ot_out_ip'], 'string', 'max' => 30],
            [['remark', 'app_remark'], 'string', 'max' => 255],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'day' => 'Day',
            'tarikh' => 'Tarikh',
            'time_in' => 'Time In',
            'time_out' => 'Time Out',
            'ot_in' => 'Ot In',
            'ot_out' => 'Ot Out',
            'reason_id' => 'Reason ID',
            'status_in' => 'Status In',
            'status_out' => 'Status Out',
            'incomplete' => 'Incomplete',
            'absent' => 'Absent',
            'external' => 'External',
            'app_by' => 'App By',
            'app_dt' => 'App Dt',
            'remark_status' => 'Remark Status',
            'wp_id' => 'Wp ID',
            'in_lat_lng' => 'In Lat Lng',
            'out_lat_lng' => 'Out Lat Lng',
            'ot_in_lat_lng' => 'Ot In Lat Lng',
            'ot_out_lat_lng' => 'Ot Out Lat Lng',
            'in_ip' => 'In Ip',
            'out_ip' => 'Out Ip',
            'remark' => 'Remark',
            'app_remark' => 'App Remark',
            'ot_in_ip' => 'Ot In Ip',
            'ot_out_ip' => 'Ot Out Ip',
        ];
    }
      
    public function getWbb() {
        return $this->hasOne(RefWp::className(), ['id' => 'wp_id']);
    }
    public function getShift() {
        return $this->hasOne(RefShifts::className(), ['id' => 'wp_id']);
    }

    /**
      /**
     * @return \yii\db\ActiveQuery
     */
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getApp() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'app_by']);
    }

    public function getPeraku() {
        if ($this->app_by !== NULL) {
            return $this->app->CONm;
        } else {
            return '-';
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReason() {
        return $this->hasOne(RefReason::className(), ['id' => 'reason_id']);
    }

    public static function PendingReason() {

        $icno = Yii::$app->user->getId();

        $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND remark IS NULL AND (status_in IS NOT NULL OR status_out IS NOT NULL OR absent = 1)';
        $model = self::findBySql($sql, [':icno' => $icno])->all();

        return $model;
    }

    public static function BtnTime() {

        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');

        $btn = Html::a('<i id="time_in" class="fa fa-clock-o"></i>&nbsp;Timein', ['/kehadiran/timein'], ['class' => 'btn btn-primary btn-block']);

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $today]);

        //check dlu klu sda check in atau ada data dlm table
        if ($model) {
            $btn = Html::a('<i class="fa fa-clock-o"></i>&nbsp;TimeOut', ['/kehadiran/timeout', 'id' => $model->id], ['class' => 'btn btn-success btn-block']);
        }

        return $btn;
    }

    public function getFormatTimeIn() {

        $val = '-';

        if ($this->time_in) {

            $val = $this->changeDatetimeToTime24($this->time_in);
        } else {
            $val = $this->changeDatetimeToTime24($this->ot_in);
        }

        return $val;
    }

    public function getFormatTimeOut() {

        $val = '-';

        if ($this->time_out) {

            $val = $this->changeDatetimeToTime24($this->time_out);
        }

        return $val;
    }

    public function getFormatTimeInOt() {

        $val = '-';

        if ($this->ot_in) {

            $val = $this->changeDatetimeToTime($this->ot_in);
        } else {
            $val = $this->changeDatetimeToTime($this->ot_in);
        }

        return $val;
    }

    public function getFormatTimeOutOt() {

        $val = '-';

        if ($this->ot_out) {

            $val = $this->changeDatetimeToTime($this->ot_out);
        }

        return $val;
    }

    public function changeDatetimeToTime($datetime) {

        $dt = date_create($datetime);

        $time = date_format($dt, "h:i A");

        return $time;
    }
    public function changeDatetimeToTime24($datetime) {

        $dt = date_create($datetime);

        $time = date_format($dt, "H:i");

        return $time;
    }

    public function changeDateFormat($date) {

        $dt = date_create($date);

        $v = date_format($dt, "d/m/Y");

        return $v;
    }

    public function getFormatOtIn() {

        $val = '';

        if ($this->ot_in) {

            $val = $this->changeDatetimeToTime($this->ot_in);
        }

        return $val;
    }

    public function getFormatOtOut() {

        $val = '';

        if ($this->ot_out) {

            $val = $this->changeDatetimeToTime($this->ot_out);
        }

        return $val;
    }

    public function getCatatan() {
        return $this->remark ? $this->remark : '-';
    }

    /**
     * untuk dapatkan semua status in,out,absent, external
     * 
     * @return string
     */
    public function getStatusAll() {

        $absent = '';
        $incomplete = '';
        $external = '';

        if ($this->absent == '1') {
            $absent = 'ABSENT';
        }

        if ($this->incomplete == '1') {
            $incomplete = 'INCOMPLETE';
        }

        if ($this->external == '1') {
            $external = 'EXTERNAL';
        }

        return '<span class="label label-danger">' . $this->status_in . '</span> <span class="label label-danger">' . $this->status_out . '</span> <span class="label label-danger">' . $absent . '</span>' . '</span> <span class="label label-danger">' . $incomplete . '</span> <span class="label label-danger">' . $external . '</span>';
    }

    public static function totalHour($from1, $to1)
    {

        $from =  DATE("H:i", STRTOTIME($from1));
        $to =  DATE("H:i", STRTOTIME($to1));

        $differenceFormat = '%H:%i';
        if($to == 0){
            $to =  DATE("24:i", STRTOTIME($to1));
            // var_dump($to);die;

        }

        $datetime1 = date_create($from);
        $datetime2 = date_create($to);

      
        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);
    }


    public function getMapBtnIn() {

        if ($this->in_lat_lng) {
//            var_dump($this->in_lat_lng);die;
            return Html::button('Masuk', ['value' => Url::to("index.php?r=kehadiran/show_map&latlng=$this->in_lat_lng"), 'class' => 'mapBtn btn btn-sm btn-success', 'id' => 'modalButton']);
        }

        return '-';
    }

    public function getMapBtnOut() {
        if ($this->out_lat_lng) {
            return Html::button('Keluar', ['value' => Url::to("index.php?r=kehadiran/show_map&latlng=$this->out_lat_lng"), 'class' => 'mapBtn btn btn-sm btn-primary', 'id' => 'modalButton']);
        }
        return '-';
    }

    public function getFormatTarikh() {

        return $this->changeDateFormat($this->tarikh);
    }

    public function ipType($ip, $latlng) {
        $check = '';
        
//        $pre = substr($ip, 0, 2);
//        if ($pre == '10' && $ip != NULL) {
//            $check = '<i style="background-color:green; color:white;">Internal</i>';
//        } else if ($pre != '10.' && $ip != NULL) {
//            $check = '<i style="background-color:red; color:white;">External</i>';
//        } else {
//            $check = '';
//        }
        if ($ip) {
            if (self::checkIp($ip) === '1') {
                if (!TblLocation::CheckZone($latlng)) {
                    $check = '<i style="background-color:red; color:white;">External</i>';
                } else {
                    $check = '<i style="background-color:green; color:white;">Internal</i>';
                }
            } else {
                $check = '<i style="background-color:green; color:white;">Internal</i>';
            }
        }


        return $check;
    }

    public static function totalPendingReason($icno, $numberOnly = false, $isRaw = false) {

        $total = 0;

        $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno=:icno AND (status_in IS NOT NULL OR status_out IS NOT NULL OR incomplete = 1 OR absent = 1 OR external = 1) AND remark_status IS NULL ';
        $model = TblRekod::findBySql($sql, [':icno' => $icno])->all();

        if ($model) {
            $total = count($model);
        }

        if ($total > 0) {
            if ($numberOnly) {
                return $total;
            } else {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        } else {
            if ($numberOnly) {
                return 0;
            } else {
                return '';
            }
        }
    }

    //if number only is true, return number only
    public static function totalPendingKetidakpatuhan($icno, $numberOnly = false, $isRaw = false) {
        $total = 0;
        $model = TblRekod::findAll(['app_by' => $icno, 'remark_status' => 'ENTRY']);

        if ($isRaw) {
            return $model;
        }

        if ($model) {
            $total = count($model);
        }

        if ($total > 0) {
            if ($numberOnly) {
                return $total;
            } else {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        } else {
            if ($numberOnly) {
                return 0;
            } else {
                return '';
            }
        }
    }

    public static function totalPendingWbb($icno, $numberOnly = false, $isRaw = false) {
        $total = 0;
        $total_ver = 0;
        $total_app = 0;

        $ver = TblWp::findAll(['ver_by' => $icno, 'status' => 'ENTRY']);
        $app = TblWp::findAll(['app_by' => $icno, 'status' => 'VERIFIED']);

        if ($ver) {
            $total_ver = count($ver);
        }

        if ($app) {
            $total_app = count($app);
        }

        $total = $total_ver + $total_app;

        if ($total > 0) {
            if ($numberOnly) {
                return $total;
            } else {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        } else {
            if ($numberOnly) {
                return 0;
            } else {
                return '';
            }
        }
    }

    public static function totalPendingAll($icno) {
        $wbb = self::totalPendingWbb($icno, true);
        $ketidakpatuhan = self::totalPendingKetidakpatuhan($icno, true);
        $reason = self::totalPendingReason($icno, true);

        $total = $wbb + $ketidakpatuhan + $reason;

        return $total;
    }

    //utk return jenis ip 1 = external | 0 = internal
    public static function checkIp($ip) {

        $v = '0';

        $pre = substr($ip, 0, 2);

        if ($pre != '10') {
            $v = '1';
        }

        return $v;
    }

    /**
     * 
     * @param type $icno icno 
     * @param type $date
     * @param type $type 1 = in , 2 out, 3 ot in, 4, ot out
     */
    public static function DisplayTime($icno, $tarikh, $type) {

        $val = '-';

        if ($icno && $tarikh) {
            $model = TblRekodLmt::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        }

        if ($model) {

            if ($type == 1) {
//                $val = $model->formatTimeIn . '<br>' . $model->ipType($model->in_ip, $model->in_lat_lng);
                $val = $model->formatTimeIn;
            }

            if ($type == 2) {
//                $val = $model->formatTimeOut . '<br>' . $model->ipType($model->out_ip, $model->out_lat_lng);
                $val = $model->formatTimeOut;
            }

            if ($type == 5) {
                $val = $model->statusAll;
            }
        }

        return $val;
    }

    //utk dapatkan raw incomplicae sts
    public static function IncStatus($icno, $tarikh) {

        $val = '-';
        $in = '';
        $out = '';
        $incomplete = '';
        $absent = '';
        $external = '';

        if ($icno && $tarikh) {
            $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        }

        if ($model) {

            if ($model->status_in) {
                $in = 'LATE_IN';
            }

            if ($model->status_out) {
                $out = 'EARLY_OUT';
            }

            if ($model->incomplete == 1) {
                $incomplete = 'INCOMPLETE';
            }

            if ($model->absent == 1) {
                $absent = 'ABSENT';
            }

            if ($model->external == 1) {
                $external = 'EXTERNAL';
            }

            $val = $in . ' ' . $out . ' ' . $incomplete . ' ' . $absent . ' ' . $external;
        }

        return $val;
    }

    public static function TotalWorkingPerMonth($month, $year) {

        $val = 0;

//        $year = date('Y');

        $sql_cuti_umum = 'SELECT * FROM hrm.cuti_public_holiday WHERE MONTH(tarikh_cuti) =:month AND YEAR(tarikh_cuti) =:year';
        $cuti_umum = CutiUmum::findBySql($sql_cuti_umum, [':year' => $year, 'month' => $month])->All();

        foreach ($cuti_umum as $umum) {
            if (TblRekod::DisplayDay($umum->tarikh_cuti) == 'Sat' || TblRekod::DisplayDay($umum->tarikh_cuti) == 'Sun') {
                $val++;
            }
        }

        $working_day = 0;
        foreach (TblRekod::dayInMonth($month, $year) as $k => $v) {
            if ($v != 'Sat' && $v != 'Sun') {
                $working_day++;
            }
        }

        $jum_cuti_umum = count($cuti_umum) - $val;

        $total = $working_day - $jum_cuti_umum;


        return $total;
    }

    public function dayInMonth($month, $year) {

        $start_date = "01-" . $month . "-" . $year;
        $start_time = strtotime($start_date);

        $end_time = strtotime("+1 month", $start_time);

        for ($i = $start_time; $i < $end_time; $i += 86400) {
            $list[] = date('D', $i);
        }

        return $list;
    }

    public function number_of_working_days($from, $to) {
        $workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, ...)
        $holidayDays = ['*-12-25', '*-01-01', '2013-12-23']; # variable and fixed holidays

        $from = new DateTime($from);
        $to = new DateTime($to);
        $to->modify('+1 day');
        $interval = new DateInterval('P1D');
        $periods = new DatePeriod($from, $interval, $to);

        $days = 0;
        foreach ($periods as $period) {
            if (!in_array($period->format('N'), $workingDays))
                continue;
            if (in_array($period->format('Y-m-d'), $holidayDays))
                continue;
            if (in_array($period->format('*-m-d'), $holidayDays))
                continue;
            $days++;
        }
        return $days;
    }

    //yg ni function utk return html format ... klu ubah function displaycutiRaw mesti ubah yg ni juga ok
    public static function DisplayCuti($icno, $tarikh) {

        $val = '-';

        // Ni untuk check cuti umum

        $cuti_umum = CutiUmum::find()->where(['tarikh_cuti' => $tarikh])->asArray()->one();
        //ni utk keselamatan pnya cuti
    $cuti_rehat = TblShiftKeselamatan::find()->where(['icno'=>$icno])->andWhere(['shift_id'=> 7])->asArray()
            ->andWhere(['tarikh'=> $tarikh])->all();
//        var_dump($cuti_rehat);die;
        // returns all inactive customers
        $sql_outstation = 'SELECT * FROM vEAttendance WHERE ICNo=:icno AND :tarikh BETWEEN cast(convert(char(11), OutstationDateTimeStart, 113) as date) AND cast(convert(char(11), OutstationDateTimeEnd, 113) as date)';
//        $sql_outstation = 'SELECT * FROM vEAttendance WHERE ICNo=:icno AND :tarikh BETWEEN OutstationDateTimeStart AND OutstationDateTimeEnd';
//        $outstation = KeluarPejabat::findBySql($sql_outstation, [':icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();
        // returns all inactive customers
        $sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND :tarikh BETWEEN start_date AND end_date';
        $model = TblRecords::findBySql($sql, [':icno' => $icno, 'tarikh' => $tarikh])->one();
        // $model = TblRecords::find()
        // ->where(['between', $tarikh,'start_date', 'end_date'])->andWhere(['icno' => $icno])->one();

//        var_dump($model);die;
//        if ($outstation) {
//            $val = '<p style="font-size:8pt; padding:0; background-color: yellow" class="text-center">' . $outstation['Name'] . '</p>';
//        }

        if ($model) {
            $val = '<span class="label label-primary">' . $model->jenisCuti->jenis_cuti_nama . '</span>';
        }

        if ($cuti_umum) {
            $val = '<span class="label label-warning">' . $cuti_umum['nama_cuti'] . '</span>';
        }

        if (TblRekod::DisplayDay($tarikh) == 'Sat') {
            $val = '<span class="label label-success">' . 'Weekend' . '</span>';
        }

        if (TblRekod::DisplayDay($tarikh) == 'Sun') {
            $val = '<span class="label label-success">' . 'Weekend' . '</span>';
        }
        if($cuti_rehat){
            $val = '<span class="label label-success">' . 'Cuti Rehat' . '</span>';
        }

        return $val;
//        var_dump($val);die;
    }

    //yg ni function utk return text sahaja... klu ubah function displaycuti mesti ubah yg ni juga ok
    public static function DisplayCutiRaw($icno, $tarikh) {

        $val = '-';

        // Ni untuk check cuti umum

        $cuti_umum = CutiUmum::find()->where(['tarikh_cuti' => $tarikh])->asArray()->one();

        // returns all inactive customers
        $sql_outstation = 'SELECT * FROM vEAttendance WHERE ICNo=:icno AND :tarikh BETWEEN cast(convert(char(11), OutstationDateTimeStart, 113) as date) AND cast(convert(char(11), OutstationDateTimeEnd, 113) as date)';
//        $sql_outstation = 'SELECT * FROM vEAttendance WHERE ICNo=:icno AND :tarikh BETWEEN OutstationDateTimeStart AND OutstationDateTimeEnd';
        $outstation = KeluarPejabat::findBySql($sql_outstation, [':icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        // returns all inactive customers
      
        $sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND :tarikh BETWEEN start_date AND end_date';
        $model = TblRecords::findBySql($sql, [':icno' => $icno, 'tarikh' => $tarikh])->one();
        // $model = TblRecords::find()
        // ->where(['between', $tarikh,'start_date', 'end_date'])->andWhere(['icno' => $icno])->one();


        if ($outstation) {
            $val = $outstation['Name'];
        }

        if ($model) {
            $val = $model->jenis->jenis_cuti_nama;
        }

        if ($cuti_umum) {
            $val = $cuti_umum['nama_cuti'];
        }

        if (TblRekod::DisplayDay($tarikh) == 'Sat') {
            $val = 'Weekend';
        }

        if (TblRekod::DisplayDay($tarikh) == 'Sun') {
            $val = 'Weekend';
        }

        return $val;
    }

    public function checkAbsent($icno, $tarikh) {

        $v = FALSE;
   $cuti_rehat = TblShiftKeselamatan::find()->where(['icno'=>$icno])->andWhere(['shift_id'=> 7])->asArray()
            ->andWhere(['tarikh'=> $tarikh])->all();
        //-------------------Check Cuti Umum---------------------//
        $cuti_umum = CutiUmum::findOne(['tarikh_cuti' => $tarikh]);

        if($cuti_rehat){
            $v = TRUE;
        }
        if ($cuti_umum) {
            $v = TRUE;
        }
        //-------------------Check Cuti Umum---------------------//
        //-------------------Check Outstation---------------------//
        $sql_outstation = 'SELECT * FROM vEAttendance WHERE ICNo=:icno AND :tarikh BETWEEN cast(convert(char(11), OutstationDateTimeStart, 113) as date) AND cast(convert(char(11), OutstationDateTimeEnd, 113) as date)';
//        $outstation = KeluarPejabat::findBySql($sql_outstation, [':icno' => $icno, 'tarikh' => $tarikh])->one();
//
//        if ($outstation) {
//            $v = TRUE;
//        }
        //-------------------Check Outstation---------------------//
        //-------------------Check Cuti---------------------//
        $sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND :tarikh BETWEEN start_date AND end_date';
        $model = TblRecords::findBySql($sql, [':icno' => $icno, 'tarikh' => $tarikh])->one();
        // $model = TblRecords::find()
        // ->where(['between', $tarikh,'start_date', 'end_date'])->andWhere(['icno' => $icno])->one();

        if ($model) {
            $v = TRUE;
        }

        //-------------------Check Cuti---------------------//
        //-------------------Check RESTDAY------------------//
        $staff = TblStaffKeselamatan::find()->where(['staff_icno' => $icno])->one();
        if ($staff) {
            $shift = TblShiftKeselamatan::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->one();
            //klu wp id = REST day ID = 34
            if ($shift->shift_id == 7) {
                $v = TRUE;
            }
        }
        //-------------------Check RESTDAY------------------//


        return $v;
    }

    /**
     * 
     * @param date $tarikh date
     * @param char $format default null, 'l' for full day format
     * @return char return Day of the date
     */
    public static function DisplayDay($tarikh, $format = null) {

        $timestamp = strtotime($tarikh);

        $day = date('D', $timestamp);

        if ($format) {
            $day = date($format, $timestamp);
        }

        return $day;
    }

    public static function DisplayLoc($icno, $tarikh) {
        $val = '';

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);



        if ($model) {

            $val = $model->in_lat_lng ? '<a href="https://www.google.com/maps/@' . $model->in_lat_lng . ',16z" target="_blank" class="btn-primary btn-sm">IN</a>' : '';
            $val .= '&nbsp;';
            $val .= $model->out_lat_lng ? '<a href="https://www.google.com/maps/@' . $model->out_lat_lng . ',16z" target="_blank" class="btn-primary btn-sm">OUT</a>' : '';
        }

        return $val;
    }

    public static function DisplayLocIn($icno, $tarikh) {
        $val = '';

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {

            $val = $model->in_lat_lng ? $model->in_lat_lng : '-';
        } else {
            $val = '-';
        }

        return $val;
    }

    public static function DisplayLocOut($icno, $tarikh) {
        $val = '';

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {

            $val = $model->out_lat_lng ? $model->out_lat_lng : '-';
        } else {
            $val = '-';
        }

        return $val;
    }

    public static function IdByDate($icno, $tarikh) {
        $val = NULL;

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {

            $val = $model->id;
        }

        return $val;
    }

    public static function DisplayHours($icno, $tarikh) {

        $val = '-';

        // returns all inactive customers
        $sql = 'SELECT * FROM keselamatan.tbl_rekod_lmt WHERE icno=:icno AND tarikh=:tarikh AND time_in IS NOT NULL AND time_out IS NOT NULL';
        $model = TblRekodLmt::findBySql($sql, [':icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        if ($model) {

            $in = $model['time_in'];
            $out = $model['time_out'];
            $val = self::totalHour($in, $out);
        }

        return $val;
    }

    public static function DisplayWbb($icno, $tarikh) {
        $val = '-';

        $model = TblRekodLmt::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {

            if ($model->wp_id === null) {
                $val = '-';
            } else {
                $val = $model->wbb->jenis_wp;
            }
        }

        return $val;
    }
    public static function DisplayShift($icno, $tarikh) {
        $val = '-';

        $model = TblRekodLmt::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {

            if ($model->wp_id === null) {
                $val = '-';
            } else {
                $val = $model->shift->jenis_shifts;
            }
        }

        return $val;
    }

    /**
     * 
     * @param type $icno
     * @param type $month
     * @param type $type 1 = late_in, 2 = early_out, 3 = Incomplete, 4 = absent, 5 = external
     * @return type
     */
    public static function countKetidakpatuhan($icno, $month,$year, $type) {

        $val = 0;

        if ($type == 1) {
            $sql = 'SELECT * FROM keselamatan.tbl_rekod_lmt WHERE icno=:icno AND MONTH(tarikh)=:month AND status_in = "LATE_IN"';
        }

        if ($type == 2) {
            $sql = 'SELECT * FROM keselamatan.tbl_rekod_lmt WHERE icno=:icno AND MONTH(tarikh)=:month AND status_out = "EARLY_OUT"';
        }

        if ($type == 3) {
            $sql = 'SELECT * FROM keselamatan.tbl_rekod_lmt WHERE icno=:icno AND MONTH(tarikh)=:month AND incomplete = 1';
        }

        if ($type == 4) {
            $sql = 'SELECT * FROM keselamatan.tbl_rekod_lmt WHERE icno=:icno AND MONTH(tarikh)=:month AND absent = 1';
        }

        if ($type == 5) {
            $sql = 'SELECT * FROM keselamatan.tbl_rekod_lmt WHERE icno=:icno AND MONTH(tarikh)=:month AND external = 1';
        }

        $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month])->all();

        if ($model) {
            $val = count($model);
        }

        return $val;
    }

    public static function viewBulan($mth) {

        $nama_bulan = '';

        if ($mth == 1) {
            $nama_bulan = 'January';
        }
        if ($mth == 2) {
            $nama_bulan = 'February';
        }
        if ($mth == 3) {
            $nama_bulan = 'Mac';
        }
        if ($mth == 4) {
            $nama_bulan = 'April';
        }
        if ($mth == 5) {
            $nama_bulan = 'May';
        }
        if ($mth == 6) {
            $nama_bulan = 'June';
        }
        if ($mth == 7) {
            $nama_bulan = 'July';
        }
        if ($mth == 8) {
            $nama_bulan = 'August';
        }
        if ($mth == 9) {
            $nama_bulan = 'September';
        }
        if ($mth == 10) {
            $nama_bulan = 'October';
        }
        if ($mth == 11) {
            $nama_bulan = 'November';
        }
        if ($mth == 12) {
            $nama_bulan = 'December';
        }


        return $nama_bulan;
    }

    public static function TotalWorkingHours($icno, $month, $type = 1) {

        $times = array();
        $value = '';

        $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND MONTH(tarikh)=:month AND time_in IS NOT NULL AND time_out IS NOT NULL';
        $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month])->all();

        if ($type == 1) {


            if ($model) {

                foreach ($model as $rekod) {
                    $times[] = $rekod->hoursMinutes;
                }
            }

            $value = TblRekod::instance()->SumTotalHours($times);
        }

        if ($type == 2) {
            $value = count($model);
        }

        return $value;
    }

    public function getHoursMinutes() {

        $differenceFormat = '%h:%i';

        $datetime1 = date_create($this->time_in);
        $datetime2 = date_create($this->time_out);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);
    }

    /**
     * 
     * @param array $times
     * @return string
     */
    function SumTotalHours($times) {
        $minutes = 0;
        // loop throught all the times
        foreach ($times as $time) {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }

        $hours = floor($minutes / 60);
        $minutes -= $hours * 60;

        // returns the time already formatted
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    public static function RemarkStatus($icno, $tarikh) {

        $val = '-';

        $model = TblRekod::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        if ($model) {


            if ($model['remark_status'] == 'REMARKED') {
                $val = '<font>[ &#10004; ]</font>';
            } else if ($model['remark_status'] == 'APPROVED') {
                $val = '<font color="white" style="background-color:green;">[ &#10004; ]</font>';
            } else if ($model['absent'] === '1' || $model['incomplete'] === '1' || $model['external'] === '1' || $model['status_in'] !== null || $model['status_out'] !== null) {
                $val = '<font style="color:red">[ &#x2716; ]</font>';
            } else {
                $val = '-';
            }
        }


        return $val;
    }

    public static function RemarkStatusRaw($icno, $tarikh) {

        $val = '-';

        $model = TblRekod::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        if ($model) {


            if ($model['remark_status'] == 'ENTRY') {
                $val = 1;
            } else if ($model['remark_status'] == 'APPROVED') {
                $val = 2;
            } else if ($model['absent'] === '1' || $model['incomplete'] === '1' || $model['external'] === '1' || $model['status_in'] !== null || $model['status_out'] !== null) {
                $val = 3;
            } else {
                $val = '-';
            }
        }


        return $val;
    }

    public static function viewRemark($icno, $tarikh) {
        $val = '-';

        $model = TblRekod::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        if ($model) {
            $val = $model['remark'];
        }

        return $val;
    }

    public function getStatusRemark() {

        if ($this->remark_status !== NULL) {

            if ($this->remark_status == 'ENTRY') {
                return 'MENUNGGU TINDAKAN';
            }

            if ($this->remark_status == 'APPROVED') {
                return 'DITERIMA';
            }

            if ($this->remark_status == 'REJECTED') {
                return 'ALASAN/CATATAN DITOLAK';
            }
        } else {
            return 'TIADA';
        }
    }

    /**
     * if return 1 ada kesalahan pada rekod/hari tersebut
     * klu 0 bersih x da kesalahan
     */
    public function getKetidakpatuhan() {
        if ($this->absent === '1' || $this->incomplete === '1' || $this->external === '1' || $this->status_in !== null || $this->status_out !== null) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * 
     * @return 1 status remark tidak diterima atau status tiada tindakan daripada pegawai
     * klu 0 kesalah telah disucikan.
     */
    public function getXAmpun() {
        if ($this->getKetidakpatuhan() == 1 && ($this->remark_status == 'REJECTED' || $this->remark_status == 'ENTRY' || $this->remark_status === NULL)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function totalRejected($icno, $month) {

        $total = 0;

        if ($icno && $month) {

            $sql = 'SELECT * FROM tbl_rekod WHERE MONTH(tarikh)=:month AND icno=:icno AND day NOT IN ("SATURDAY", "SUNDAY") AND (incomplete = 1 OR absent = 1 OR external = 1 OR status_in IS NOT NULL OR status_out IS NOT NULL) AND (remark_status = "ENTRY" OR remark_status IS NULL OR remark_status = "REJECTED")';
            $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month])->all();

            if ($model) {
                $total = count($model);
            }
        }

        return $total;
    }

    public static function totalSalah($icno, $month) {

        $total = 0;

        if ($icno && $month) {

            $sql = 'SELECT * FROM tbl_rekod WHERE MONTH(tarikh)=:month AND icno=:icno AND day NOT IN ("SATURDAY", "SUNDAY") AND (incomplete = 1 OR absent = 1 OR external = 1 OR status_in IS NOT NULL OR status_out IS NOT NULL)';
            $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month])->all();

            if ($model) {
                $total = count($model);
            }
        }

        return $total;
    }

    public static function totalApproved($icno, $month) {

        $total = 0;

        if ($icno && $month) {

            $sql = 'SELECT * FROM tbl_rekod WHERE MONTH(tarikh)=:month AND icno=:icno AND day NOT IN ("SATURDAY", "SUNDAY") AND (incomplete = 1 OR absent = 1 OR external = 1 OR status_in IS NOT NULL OR status_out IS NOT NULL) AND remark_status = "APPROVED"';
            $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month])->all();

            if ($model) {
                $total = count($model);
            }
        }

        return $total;
    }

    public static function kadWarna($total, $color) {

        if ($color == 'YELLOW') {

            if ($total >= 3) {
                return 'GREEN';
            } else {
                return 'YELLOW';
            }
        }

        if ($color == 'GREEN') {

            if ($total >= 2 && $total < 3) {
                return 'GREEN';
            } elseif ($total >= 3) {
                return 'RED';
            } else {
                return 'YELLOW';
            }
        }

        IF ($color == 'RED') {
            if ($total >= 1) {
                return 'RED';
            } else {
                return 'GREEN';
            }
        }
    }

    public static function checkToday($icno, $tarikh) {

        $model = TblRekod::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->one();

        if ($model) {
            return true;
        }

        return false;
    }

}
