<?php

namespace app\models\kehadiran;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\hronline\Tblprcobiodata;
use app\models\cuti\CutiRekod;
use app\models\cuti\CutiUmum;
use app\models\cuti\TblRecords;
use app\models\KeluarPejabat;
use app\models\kehadiran\TblWfh;

/**
 * This is the model class for table "tbl_rekod".
 *
 * @property int $id
 * @property string $icno
 * @property string $day
 * @property string $tarikh
 * @property string $time_in
 * @property string $time_out
 * @property double $total_hours
 * @property int $reason_id refer table ref_reason
 * @property string $remark
 * @property string $app_remark
 * @property int $late_in
 * @property int $early_out
 * @property int $incomplete
 * @property int $absent 1 = kira absent | system generated
 * @property int $external 1 = external ip | 0 = internal ip
 * @property string $app_by
 * @property string $app_dt
 * @property string $remark_status ENTRY | APPROVED
 * @property int $wp_id refer table ref_wp
 * @property string $in_lat_lng
 * @property string $out_lat_lng
 * @property string $in_ip
 * @property string $out_ip
 */
class TblRekod extends \yii\db\ActiveRecord
{

    public $latlng;
    public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance.tbl_rekod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh', 'time_in', 'time_out', 'app_dt'], 'safe'],
            [['reason_id', 'incomplete', 'absent', 'external', 'wp_id', 'late_in', 'early_out'], 'integer'],
            [['icno', 'day', 'tarikh'], 'required'],
            [['total_hours'], 'number'],
            [['latlng'], 'required', 'on' => 'location', 'message' => 'Please allow your Location !'],
            [['remark_status'], 'required', 'on' => 'reason', 'message' => 'Sila Pilih Status Pengesahan !'],
            [['remark'], 'required', 'on' => 'remark', 'message' => 'Sila letak alasan/alasan !'],
            [['reason_id'], 'required', 'on' => 'remark', 'message' => 'Sila Pilih Jenis Kesalahan!'],
            [['remark_status'], 'default', 'value' => null],
            [['icno'], 'string', 'max' => 15],
            [['day', 'remark_status', 'in_ip', 'out_ip'], 'string', 'max' => 30],
            [['remark', 'app_remark'], 'string'],
            [['incomplete', 'absent', 'external'], 'integer', 'max' => 1],
            [['app_by'], 'string', 'max' => 16],
            [['in_lat_lng', 'out_lat_lng'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Name',
            'day' => 'Day',
            'tarikh' => 'Tarikh',
            'time_in' => 'Time In',
            'time_out' => 'Time Out',
            'total_hours' => 'Total Hours',
            'reason_id' => 'Reason ID',
            'remark' => 'Remark',
            'app_remark' => 'Catatan Pengesahan',
            'late_in' => 'Late In',
            'early_out' => 'Early Out',
            'incomplete' => 'Incomplete',
            'external' => 'External',
            'absent' => 'Absent',
            'app_by' => 'App By',
            'app_dt' => 'Approver Date/Time',
            'remark_status' => 'Remark Status',
            'wp_id' => 'Wp ID',
            'in_lat_lng' => 'Latitude, Langitude [In]',
            'out_lat_lng' => 'Latitude, Langitude [Out]',
            'in_ip' => 'IP Address [In]',
            'out_ip' => 'IP Address [Out]',
            'latlng' => 'Current Latitude, Longitude',
            'formatTimeIn' => 'Time In',
            'formatTimeOut' => 'Time Out',
            'catatan' => 'Remark',
            'statusAll' => 'Incompliance Status',
            'formatTarikh' => 'Date',
            'hoursMinutes' => 'Working hours [Hour:Minutes]',
            'statusRemark' => 'Remark Status',
            'peraku' => 'Approver',
            'remark_dt' => 'Remark Date/Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWbb()
    {
        return $this->hasOne(RefWp::className(), ['id' => 'wp_id']);
    }

    /**
     * /**
     * @return \yii\db\ActiveQuery
     */
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getApp()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'app_by']);
    }

    public function getPeraku()
    {
        if ($this->app_by !== NULL) {
            return $this->app->CONm;
        } else {
            return '-';
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReason()
    {
        return $this->hasOne(RefReason::className(), ['id' => 'reason_id']);
    }

    public function getWorkingHours()
    {

        if ($this->time_in && $this->time_out) {
            return self::totalHour($this->time_in, $this->time_out);
        }

        return 0;
    }

    public static function PendingReason()
    {

        $icno = Yii::$app->user->getId();

        $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno=:icno AND remark IS NULL AND (late_in = 1 OR early_out = 1 OR absent = 1)';
        $model = self::findBySql($sql, [':icno' => $icno])->all();

        return $model;
    }


    public static function BtnTime()
    {

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

    public static function changeDatetimeToTime($datetime)
    {

        $dt = date_create($datetime);

        $time = date_format($dt, "h:i A");

        return $time;
    }

    public function getTimeOnlyIn()
    {

        $date1 = new \DateTime($this->time_in);
        //        $date1->sub(new \DateInterval('PT30M'));
        return $date1->format('H:i:s');
    }

    public static function changeDateFormat($date)
    {

        $dt = date_create($date);

        $v = date_format($dt, "d/m/Y");

        return $v;
    }

    public function getFormatOtIn()
    {

        $val = '';

        if ($this->ot_in) {

            $val = $this->changeDatetimeToTime($this->ot_in);
        }

        return $val;
    }

    public function getFormatOtOut()
    {

        $val = '';

        if ($this->ot_out) {

            $val = $this->changeDatetimeToTime($this->ot_out);
        }

        return $val;
    }

    public function getCatatan()
    {
        return $this->remark ? $this->remark : '-';
    }

    /**
     * untuk dapatkan semua status in,out,absent, external
     *
     * @return string
     */
    public function getStatusAll()
    {

        $late_in = '';
        $early_out = '';
        $absent = '';
        $incomplete = '';
        $external = '';

        if ($this->late_in == 1) {
            $late_in = 'LATE IN';
        }

        if ($this->early_out == 1) {
            $early_out = 'EARLY OUT';
        }

        if ($this->absent == 1) {
            $absent = 'ABSENT';
        }

        if ($this->incomplete == 1) {
            $incomplete = 'INCOMPLETE';
        }

        if ($this->external == 1) {
            $external = 'EXTERNAL';
        }

        return '<span class="label label-danger">' . $late_in . '</span> <span class="label label-danger">' . $early_out . '</span> <span class="label label-danger">' . $absent . '</span>' . '</span> <span class="label label-danger">' . $incomplete . '</span> <span class="label label-danger">' . $external . '</span>';
    }

    public function getShiftHrIn()
    {


        $wp = RefWp::findOne(['id' => $this->wp_id]);

        if ($wp->is_flexi == 1) {
            //check time in bila
            if ($wp->in_start_time < $this->timeOnlyIn) {
                $val = $this->time_in;
            } else {
                $val = $this->tarikh . ' ' . $wp->in_start_time;
            }
        } else {
            $val = $this->tarikh . ' ' . $wp->start_time;
        }

        if ($this->day == 'Saturday' || $this->day == 'Sunday') {
            $val = NULL;
        }

        return $val;
    }

    public function getShiftHrOut()
    {


        $wp = RefWp::findOne(['id' => $this->wp_id]);

        if ($wp->is_flexi == 1) {
            //check time in bila
            if ($wp->in_start_time < $this->timeOnlyIn) {
                $time_in = $this->timeOnlyIn;

                $val = $this->tarikh . ' ' . date('H:i:s', strtotime($time_in . " +$wp->total_hours hours"));
            } else {
                $val = $this->tarikh . ' ' . $wp->out_start_time;
            }
        } else {
            $val = $this->tarikh . ' ' . $wp->end_time;
        }

        if ($this->day == 'Saturday' || $this->day == 'Sunday') {
            $val = NULL;
        }

        return $val;
    }

    public static function totalHour($from, $to)
    {

        $differenceFormat = '%h:%i';

        $datetime1 = date_create($from);
        $datetime2 = date_create($to);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);
    }

    public function getMapBtnIn()
    {

        if ($this->in_lat_lng) {
            return Html::button('Masuk', ['value' => Url::to("index.php?r=kehadiran/show_map&latlng=$this->in_lat_lng"), 'class' => 'mapBtn btn btn-sm btn-success', 'id' => 'modalButton']);
        }

        return '-';
    }

    public function getMapBtnOut()
    {
        if ($this->out_lat_lng) {
            return Html::button('Keluar', ['value' => Url::to("index.php?r=kehadiran/show_map&latlng=$this->out_lat_lng"), 'class' => 'mapBtn btn btn-sm btn-primary', 'id' => 'modalButton']);
        }
        return '-';
    }

    public function getFormatTarikh()
    {

        return $this->changeDateFormat($this->tarikh);
    }

    public function getCatatanPada()
    {
        return $this->changeDateFormat($this->remark_dt);
    }

    public function ipType($ip, $latlng)
    {

        $check = '';

        if ($ip) {
            if (self::checkIp($ip) === 1) {
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

    public static function totalPendingRemark($icno)
    {
        // $count = Yii::$app->cache->get('total-pending-remark-'.$icno);

        // if(!$count){

        $count = self::find()
            ->where(['icno' => $icno, 'remark_status' => NULL])
            ->andFilterWhere([
                'and',
                [
                    'or',
                    ['=', 'late_in', 1],
                    ['=', 'early_out', 1],
                    ['=', 'incomplete', 1],
                    ['=', 'absent', 1],
                    ['=', 'external', 1]
                ],
            ])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-remark-'.$icno, $count);
        // }

        return $count;
    }

    public static function totalPendingApproval($icno)
    {
        // $count = Yii::$app->cache->get('total-pending-approval-'.$icno);
        // if(!$count){
        $count = self::find()
            ->where(['app_by' => $icno, 'remark_status' => 'ENTRY'])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-approval-'.$icno, $count);
        // }

        return $count;
    }


    public static function totalPendingReason($icno, $numberOnly = false, $isRaw = false)
    {

        $total = 0;

        $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno=:icno AND (late_in = 1 OR early_out = 1 OR incomplete = 1 OR absent = 1 OR external = 1) AND remark_status IS NULL ';
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
    public static function totalPendingKetidakpatuhan($icno, $numberOnly = false, $isRaw = false)
    {
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

    public static function totalPendingWbb($icno, $numberOnly = false, $isRaw = false)
    {
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

    public static function totalPendingAll($icno)
    {
        $wbb = self::totalPendingWbb($icno, true);
        $ketidakpatuhan = self::totalPendingKetidakpatuhan($icno, true);
        $reason = self::totalPendingReason($icno, true);

        $total = $wbb + $ketidakpatuhan + $reason;

        return $total;
    }

    //utk return jenis ip 1 = external | 0 = internal
    public static function checkIp($ip)
    {

        $v = 0;

        $pre = substr($ip, 0, 2);

        if ($pre != '10') {
            $v = 1;
        }

        return $v;
    }

    /**
     *
     * @param type $icno icno
     * @param type $date
     * @param type $type 1 = in , 2 out, 3 ot in, 4, ot out
     */
    public static function DisplayTime($icno, $tarikh, $type)
    {

        $val = '-';

        if ($icno && $tarikh) {
            $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
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
    public static function IncStatus($icno, $tarikh)
    {

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

            if ($model->late_in) {
                $in = 'LATE_IN';
            }

            if ($model->early_out) {
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

    public static function TotalWorkingPerMonth($month, $year)
    {

        $val = 0;

        //        $year = date('Y');

        $sql_cuti_umum = 'SELECT * FROM e_cuti.cuti_umum WHERE MONTH(tarikh_cuti) =:month AND YEAR(tarikh_cuti) =:year';
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

    public function dayInMonth($month, $year)
    {

        $start_date = "01-" . $month . "-" . $year;
        $start_time = strtotime($start_date);

        $end_time = strtotime("+1 month", $start_time);

        for ($i = $start_time; $i < $end_time; $i += 86400) {
            $list[] = date('D', $i);
        }

        return $list;
    }

    public function number_of_working_days($from, $to)
    {
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
    public static function DisplayCuti($icno, $tarikh)
    {

        $val = '';

        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);


        // public holiday
        $cuti_umum = CutiUmum::find()->where(['tarikh_cuti' => $tarikh])->asArray()->one();
        $outstation = self::isOutstation($icno, $tarikh);
        $cuti = self::isCuti($icno, $tarikh);
        $wfh = self::isWfh($icno, $tarikh);

        if ($outstation) {
            $val .= '<p style="font-size:8pt; padding:0; background-color: yellow" class="text-center">' . $outstation['Name'] . '</p>';
        }

        if ($cuti) {
            $val .= '<span class="label label-primary">' . $cuti->jenisCuti->jenis_cuti_nama . '</span>';
        }

        if ($cuti_umum) {

            if ($cuti_umum['wilayah_sahaja'] == 1) {
                if ($bio->campus_id == 2) {
                    $val .= '<span class="label label-warning">' . $cuti_umum['nama_cuti'] . '</span>';
                }
            } elseif ($cuti_umum['sabah_sahaja'] == 1) {
                if ($bio->campus_id != 2) {
                    $val .= '<span class="label label-warning">' . $cuti_umum['nama_cuti'] . '</span>';
                }
            } else {
                $val .= '<span class="label label-warning">' . $cuti_umum['nama_cuti'] . '</span>';
            }
        }

        if ($wfh) {
            if (TblRekod::DisplayDay($tarikh) == 'Sat' || TblRekod::DisplayDay($tarikh) == 'Sun') {
                $val .= '';
            } else {
                $val .= '<span class="label label-warning">WFH</span>';
            }
        }

        if (TblRekod::DisplayDay($tarikh) == 'Sat') {
            $val .= '<span class="label label-success">' . 'Weekend' . '</span>';
        }

        if (TblRekod::DisplayDay($tarikh) == 'Sun') {
            $val .= '<span class="label label-success">' . 'Weekend' . '</span>';
        }

        return $val;
    }

    //yg ni function utk return text sahaja... klu ubah function displaycuti mesti ubah yg ni juga ok
    public static function DisplayCutiRaw($icno, $tarikh)
    {

        $val = '-';
        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);

        // Ni untuk check cuti umum
        $cuti_umum = CutiUmum::find()->where(['tarikh_cuti' => $tarikh])->asArray()->one();
        $outstation = self::isOutstation($icno, $tarikh);
        $cuti = self::isCuti($icno, $tarikh);
        $wfh = self::isWfh($icno, $tarikh);

        if ($outstation) {
            $val = $outstation['Name'];
        }

        if ($cuti) {
            $val = $cuti->jenisCuti->jenis_cuti_nama;
        }

        if ($cuti_umum) {

            if ($cuti_umum) {

                if ($cuti_umum['wilayah_sahaja'] == 1) {
                    if ($bio->campus_id == 2) {
                        $val = $cuti_umum['nama_cuti'];
                    }
                } elseif ($cuti_umum['sabah_sahaja'] == 1) {
                    if ($bio->campus_id != 2) {
                        $val = $cuti_umum['nama_cuti'];
                    }
                } else {
                    $val = $cuti_umum['nama_cuti'];
                }
            }



            $val = $cuti_umum['nama_cuti'];
        }

        if ($wfh) {
            $val = 'WFH';
        }


        if (TblRekod::DisplayDay($tarikh) == 'Sat') {
            $val = 'Weekend';
        }

        if (TblRekod::DisplayDay($tarikh) == 'Sun') {
            $val = 'Weekend';
        }

        return $val;
    }


    /**
     * function ni pakai sekiranya ada cuti yang lmbt kena key in 
     * khas utk remove absent
     */
    public function getNotAbsent()
    {
        return $this->checkAbsent($this->icno, $this->tarikh);
    }

    public function checkAbsent($icno, $tarikh)
    {

        $v = FALSE;

        //-------------------Check Cuti Umum---------------------//
        $cuti_umum = CutiUmum::findOne(['tarikh_cuti' => $tarikh]);
        $outstation = self::isOutstation($icno, $tarikh);
        $cuti = self::isCuti($icno, $tarikh);

        if ($cuti_umum) {
            $v = TRUE;
        }

        if ($outstation) {
            $v = TRUE;
        }

        if ($cuti) {
            $v = TRUE;
        }

        //-------------------Check Cuti---------------------//
        //-------------------Check RESTDAY------------------//
        $staff = Tblstaff::find()->where(['staff_icno' => $icno])->one();
        if ($staff) {
            $shift = Tblshift::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->one();
            //klu wp id = REST day ID = 34
            if ($shift) {
                if ($shift->wp_id == 34) {
                    $v = TRUE;
                }
            }
        }
        return $v;
    }

    /**
     *
     * @param date $tarikh date
     * @param char $format default null, 'l' for full day format
     * @return char return Day of the date
     */
    public static function DisplayDay($tarikh, $format = null)
    {

        $timestamp = strtotime($tarikh);

        $day = date('D', $timestamp);

        if ($format) {
            $day = date($format, $timestamp);
        }

        return $day;
    }

    public static function DisplayLoc($icno, $tarikh)
    {
        $val = '';

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);


        if ($model) {

            $val = $model->in_lat_lng ? '<a href="https://www.google.com/maps/dir/' . $model->in_lat_lng . '/' . $model->in_lat_lng . '/@' . $model->in_lat_lng . ',18z" target="_blank" class="btn-primary btn-sm">IN</a>' : '';
            $val .= '&nbsp;';
            $val .= $model->out_lat_lng ? '<a href="https://www.google.com/maps/dir/' . $model->out_lat_lng . '/' . $model->out_lat_lng . '/@' . $model->out_lat_lng . ',18z" target="_blank" class="btn-primary btn-sm">OUT</a>' : '';
        }

        return $val;
    }

    public static function DisplayLocIn($icno, $tarikh)
    {
        $val = '';

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {

            $val = $model->in_lat_lng ? $model->in_lat_lng : '-';
        } else {
            $val = '-';
        }

        return $val;
    }

    public static function DisplayLocOut($icno, $tarikh)
    {
        $val = '';

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {

            $val = $model->out_lat_lng ? $model->out_lat_lng : '-';
        } else {
            $val = '-';
        }

        return $val;
    }

    public static function IdByDate($icno, $tarikh)
    {
        $val = NULL;

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {

            $val = $model->id;
        }

        return $val;
    }

    public static function DisplayHours($icno, $tarikh)
    {

        $val = '-';

        // returns all inactive customers
        $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno=:icno AND tarikh=:tarikh AND time_in IS NOT NULL AND time_out IS NOT NULL';
        $model = TblRekod::findBySql($sql, [':icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        if ($model) {

            $in = $model['time_in'];
            $out = $model['time_out'];
            $val = self::totalHour($in, $out);
        }

        return $val;
    }

    public static function DisplayWbb($icno, $tarikh)
    {
        $val = '-';

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {

            if ($model->wp_id === null) {
                $val = '-';
            } else {
                $val = $model->wbb->jenis_wp;
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
    public static function countKetidakpatuhan($icno, $month, $year, $type)
    {

        $val = 0;

        if ($type == 1) {
            $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno=:icno AND MONTH(tarikh)=:month AND YEAR(tarikh)=:year AND late_in = 1 AND remark_status !="APPROVED"';
        }

        if ($type == 2) {
            $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno=:icno AND MONTH(tarikh)=:month AND YEAR(tarikh)=:year AND early_out = 1 AND remark_status !="APPROVED"';
        }

        if ($type == 3) {
            $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno=:icno AND MONTH(tarikh)=:month AND YEAR(tarikh)=:year AND incomplete = 1 AND remark_status !="APPROVED"';
        }

        if ($type == 4) {
            $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno=:icno AND MONTH(tarikh)=:month AND YEAR(tarikh)=:year AND absent = 1 AND remark_status !="APPROVED"';
        }

        if ($type == 5) {
            $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno=:icno AND MONTH(tarikh)=:month AND YEAR(tarikh)=:year AND external = 1 AND remark_status !="APPROVED"';
        }

        $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month, ':year' => $year])->all();

        if ($model) {
            $val = count($model);
        }

        return $val;
    }

    public static function viewBulan($mth)
    {

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

    public static function viewBulanBm($mth)
    {

        $nama_bulan = '';

        if ($mth == 1) {
            $nama_bulan = 'Januari';
        }
        if ($mth == 2) {
            $nama_bulan = 'Februari';
        }
        if ($mth == 3) {
            $nama_bulan = 'Mac';
        }
        if ($mth == 4) {
            $nama_bulan = 'April';
        }
        if ($mth == 5) {
            $nama_bulan = 'Mei';
        }
        if ($mth == 6) {
            $nama_bulan = 'Jun';
        }
        if ($mth == 7) {
            $nama_bulan = 'Julai';
        }
        if ($mth == 8) {
            $nama_bulan = 'Ogos';
        }
        if ($mth == 9) {
            $nama_bulan = 'September';
        }
        if ($mth == 10) {
            $nama_bulan = 'Oktober';
        }
        if ($mth == 11) {
            $nama_bulan = 'November';
        }
        if ($mth == 12) {
            $nama_bulan = 'Disember';
        }


        return $nama_bulan;
    }

    public static function TotalWorkingHours($icno, $month, $year, $type = 1)
    {

        $times = array();
        $value = '';

        $sql = 'SELECT * FROM attendance.tbl_rekod WHERE icno=:icno AND MONTH(tarikh)=:month AND YEAR(tarikh)=:year AND time_in IS NOT NULL AND time_out IS NOT NULL';
        $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month, ':year' => $year])->all();

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

    public function getHoursMinutes()
    {

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
    function SumTotalHours($times)
    {
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

    public static function RemarkStatus($icno, $tarikh)
    {

        $val = '-';

        $model = TblRekod::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        if ($model) {


            if ($model['remark_status'] == 'ENTRY') {
                $val = '<font>[ &#10004; ]</font>';
            } else if ($model['remark_status'] == 'APPROVED') {
                $val = '<font color="white" style="background-color:green;">[ &#10004; ]</font>';
            } else if ($model['absent'] === '1' || $model['incomplete'] === '1' || $model['external'] === '1' || $model['late_in'] === '1' || $model['early_out'] === '1') {
                $val = '<font style="color:red">[ &#x2716; ]</font>';
            } else {
                $val = '-';
            }
        }


        return $val;
    }

    public static function RemarkStatusRaw($icno, $tarikh)
    {

        $val = '-';

        $model = TblRekod::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        if ($model) {


            if ($model['remark_status'] == 'ENTRY') {
                $val = 1;
            } else if ($model['remark_status'] == 'APPROVED') {
                $val = 2;
            } else if ($model['absent'] === '1' || $model['incomplete'] === '1' || $model['external'] === '1' || $model['late_in'] === '1' || $model['early_out'] === '1') {
                $val = 3;
            } else {
                $val = '-';
            }
        }


        return $val;
    }

    public static function viewRemark($icno, $tarikh)
    {
        $val = '-';

        $model = TblRekod::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        if ($model) {
            $val = $model['remark'];
        }

        return $val;
    }

    public function getStatusRemark()
    {

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
    public function getKetidakpatuhan()
    {
        if ($this->absent === 1 || $this->incomplete === 1 || $this->external === 1 || $this->late_in === 1 || $this->early_out === 1) {
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
    public function getXAmpun()
    {
        if ($this->getKetidakpatuhan() == 1 && ($this->remark_status == 'REJECTED' || $this->remark_status == 'ENTRY' || $this->remark_status === NULL)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function totalRejected($icno, $month, $year)
    {

        $total = 0;

        if ($icno && $month) {

            $sql = 'SELECT * FROM attendance.tbl_rekod WHERE MONTH(tarikh)=:month AND YEAR(tarikh)=:year AND icno=:icno AND day NOT IN ("SATURDAY", "SUNDAY") AND (incomplete = 1 OR absent = 1 OR external = 1 OR late_in = 1 OR early_out = 1) AND (remark_status = "ENTRY" OR remark_status IS NULL OR remark_status = "REJECTED")';
            $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month, ':year' => $year])->all();

            if ($model) {
                $total = count($model);
            }
        }

        return $total;
    }

    public static function totalSalah($icno, $month, $year)
    {

        $total = 0;

        if ($icno && $month) {

            $sql = 'SELECT * FROM attendance.tbl_rekod WHERE MONTH(tarikh)=:month AND YEAR(tarikh)=:year AND icno=:icno AND day NOT IN ("SATURDAY", "SUNDAY") AND (incomplete = 1 OR absent = 1 OR external = 1 OR late_in = 1 OR early_out = 1)';
            $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month, 'year' => $year])->all();

            if ($model) {
                $total = count($model);
            }
        }

        return $total;
    }

    public static function totalApproved($icno, $month, $year)
    {

        $total = 0;

        if ($icno && $month) {

            $sql = 'SELECT * FROM attendance.tbl_rekod WHERE MONTH(tarikh)=:month AND YEAR(tarikh)=:year AND icno=:icno AND day NOT IN ("SATURDAY", "SUNDAY") AND (incomplete = 1 OR absent = 1 OR external = 1 OR late_in = 1 OR early_out = 1) AND remark_status = "APPROVED"';
            $model = TblRekod::findBySql($sql, [':icno' => $icno, ':month' => $month, 'year' => $year])->all();

            if ($model) {
                $total = count($model);
            }
        }

        return $total;
    }

    public static function kadWarna($total, $color)
    {

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

        if ($color == 'RED') {
            if ($total >= 1) {
                return 'RED';
            } else {
                return 'GREEN';
            }
        }
    }

    public static function checkToday($icno, $tarikh)
    {

        $model = TblRekod::find()->where(['icno' => $icno, 'tarikh' => $tarikh])->one();

        if ($model) {
            return true;
        }

        return false;
    }

    public static function checkExternal($icno, $tarikh, $ip, $latlng)
    {

        $val = 0;

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

    /**
     * function untuk check current record... function ni akan checking klu wp ada next day.
     *
     * @param varchar $icno
     * @param date $today
     * @param int $wp_id
     * @return array object
     */
    public static function current($icno, $today, $wp_id, $next_day)
    {

        if (!$wp_id) {
            return null;
        }

        //utk yang nextday == 0 ; tiada melangkau hari la maksud nya.
        $model_rekod = TblRekod::findOne(['icno' => $icno, 'tarikh' => $today]);

        //if detect sebagai next day == 1.... 
        if ($next_day == 1) {

            $date_before = date('Y-m-d', strtotime($today . ' -1 day'));
            //select yg kemarin punya rekod..
            $model_rekod = TblRekod::findOne(['icno' => $icno, 'tarikh' => $date_before, 'time_out' => null]);

            //klu tiada rekod kemarin pakai rekod hari ni.
            if (!$model_rekod) {
                $model_rekod = TblRekod::findOne(['icno' => $icno, 'tarikh' => $today]);
            }
        }


        return $model_rekod;
    }

    public static function dayInMonthFormat(int $year, int $month, string $format)
    {
        $date = DateTime::createFromFormat("Y-n", "$year-$month");

        $datesArray = array();
        for ($i = 1; $i <= $date->format("t"); $i++) {
            $datesArray[] = DateTime::createFromFormat("Y-n-d", "$year-$month-$i")->format($format);
        }

        return $datesArray;
    }

    public static function TodayAtt($icno)
    {

        $model = self::findOne(['icno' => $icno, 'tarikh' => date('Y-m-d')]);

        if ($model) {
            return $model;
        }

        return null;
    }


    /**
     * utk check kluar staf ada outstation atau x
     *
     * @param $icno
     * @param $tarikh
     * @return array
     */
    public static function isOutstation($icno, $tarikh)
    {
        // Outstation
        $sql_outstation = 'SELECT * FROM vEAttendance WHERE ICNo=:icno AND :tarikh BETWEEN cast(convert(char(11), OutstationDateTimeStart, 113) as date) AND cast(convert(char(11), OutstationDateTimeEnd, 113) as date)';
        $outstation = KeluarPejabat::findBySql($sql_outstation, [':icno' => $icno, 'tarikh' => $tarikh])->asArray()->one();

        return $outstation;
    }

    /**
     * utk check kluar staf ada cuti atau x
     *
     * @param $icno
     * @param $tarikh
     * @return array
     */
    public static function isCuti($icno, $tarikh)
    {
        $sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:tarikh BETWEEN start_date AND end_date ) AND status != "REJECTED"';
        $model = TblRecords::findBySql($sql, [':icno' => $icno, 'tarikh' => $tarikh])->one();

        return $model;
    }

    /**
     * utk check kluar staf ada wfh atau x
     *
     * @param $icno
     * @param $tarikh
     * @return array
     */
    public static function isWfh($icno, $tarikh)
    {
        // work from home
        $sql = 'SELECT * FROM attendance.tbl_wfh WHERE icno=:icno AND :tarikh BETWEEN start_date AND end_date AND status =:status ';
        $wfh = TblWfh::findBySql($sql, [':icno' => $icno, ':tarikh' => $tarikh, ':status' => 'APPROVED'])->one();

        return $wfh;
    }

    public static function totalComplianceStatus($icno, $status, $year)
    {
        $model = self::find()->select($status)->where(['icno' => $icno, 'remark_status' => 'REJECTED', 'YEAR(tarikh)' => $year, $status => 1])->count();
        return $model;
    }

    public static function totalWorkingDays($icno, $year)
    {
        $model = self::find()->where(['icno' => $icno, 'absent' => 0, 'YEAR(tarikh)' => $year])->count();
        return $model;
    }
}
