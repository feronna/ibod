<?php

namespace app\models\kehadiran;

use Yii;
use DateTime;

/**
 * This is the model class for table "ref_wp".
 *
 * @property int $id
 * @property string $jenis_wp
 * @property string $detail
 * @property string $start_time
 * @property string $end_time
 * @property int $next_day
 * @property int $is_flexi
 * @property string $in_start_time flexi time only
 * @property string $in_end_time flexi time only
 * @property string $out_start_time flexi time only
 * @property string $out_end_time flexi time only
 * @property double $total_hours
 * @property string $entry_by hronline.tblprcobiodata.icno
 * @property string $entry_dt
 * @property string $update_by hronline.tblprcobiodata.icno
 * @property string $update_dt
 * @property int $mohon 1 = papar d mohon, 0 = sembunyi
 *
 * @property TblWp[] $tblWps
 */
class RefWp extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'attendance.ref_wp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['start_time', 'end_time', 'in_start_time', 'in_end_time', 'out_start_time', 'out_end_time', 'entry_dt', 'update_dt'], 'safe'],
            [['next_day', 'is_flexi', 'no_early_out', 'no_incomplete', 'mohon'], 'integer'],
            [['total_hours'], 'number'],
            [['jenis_wp'], 'string', 'max' => 100],
            [['detail'], 'string', 'max' => 255],
            [['entry_by', 'update_by'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'jenis_wp' => 'Jenis Wp',
            'detail' => 'Detail',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'next_day' => 'Next Day',
            'is_flexi' => 'Is Flexi',
            'no_early_out' => 'No Early Out',
            'no_incomplete' => 'No Incomplete',
            'in_start_time' => 'In Start Time',
            'in_end_time' => 'In End Time',
            'out_start_time' => 'Out Start Time',
            'out_end_time' => 'Out End Time',
            'total_hours' => 'Total Hours',
            'entry_by' => 'Entry By',
            'entry_dt' => 'Entry Dt',
            'update_by' => 'Update By',
            'update_dt' => 'Update Dt',
            'mohon' => 'Mohon',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblWps() {
        return $this->hasMany(TblWp::className(), ['wp_id' => 'id']);
    }

    public function getMasaMasuk() {

        $oDate = new DateTime($this->start_time);
        $sDate = $oDate->format("h:i A");

        return $sDate;
    }

    public function getMasaKeluar() {

        $oDate = new DateTime($this->end_time);
        $sDate = $oDate->format("h:i A");

        return $sDate;
    }

    public function getInStartTime() {

        $oDate = new DateTime($this->in_start_time);
        $sDate = $oDate->format("h:i A");

        return $sDate;
    }

    public function getInEndTime() {

        $oDate = new DateTime($this->in_end_time);
        $sDate = $oDate->format("h:i A");

        return $sDate;
    }

    public function getOutStartTime() {

        $oDate = new DateTime($this->out_start_time);
        $sDate = $oDate->format("h:i A");

        return $sDate;
    }

    public function getOutEndTime() {

        $oDate = new DateTime($this->out_end_time);
        $sDate = $oDate->format("h:i A");

        return $sDate;
    }

    public static function checkStatusIn($icno, $tarikh, $time_now, $wp_id) {

        $val = 0;

        $wp = self::findOne(['id' => $wp_id]);

        //if flexi
        if ($wp->is_flexi == 1) {

            if ($time_now > $wp->in_end_time) {
                $val = 1;
            }

            //else normal    
        } else {
            if ($time_now > $wp->start_time) {
                $val = 1;
            }
        }


        //if late_in try check dlu cuti.. klu != '-' tukar pegi null semula
        if ($val == 1) {

            if (TblRekod::DisplayCutiRaw($icno, $tarikh) != '-') {
                $val = 0;
            }

            //nanti kasi up slps permission pn rozaidah
            // if (TblRekod::DisplayCutiRaw($icno, $tarikh) == 'WFH') {
            //     $val = 1;
            // }


            if ($wp->is_rest == 1) {
                $val = 0;
            }
        }


        return $val;
    }

    public static function checkStatusOut($icno, $tarikh, $time_now, $wp_id) {

        $val = 0;

        $wp = self::findOne(['id' => $wp_id]);

        //if flexi
        if ($wp->is_flexi == 1) {

            $rekod = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
            //kira brapa jam
            $total_hours = self::totalHours($rekod->timeOnlyIn, $time_now, $wp->in_start_time);

            //total hour mesti lebih 9 jam
            if ($total_hours < $wp->total_hours) {
                $val = 1;
            }

            //mesti x boleh kurang dr start_time
            if ($time_now < $wp->out_start_time) {
                $val = 1;
            }

            //else normal    
        } else {
            if ($time_now < $wp->end_time) {
                $val = 1;
            }
        }


        //if late_in try check dlu cuti.. klu != '-' tukar pegi null semula
        if ($val == 1) {

            if (TblRekod::DisplayCutiRaw($icno, $tarikh) != '-') {
                $val = 0;
            }

            //nanti kasi up slps permission pn rozaidah
            // if (TblRekod::DisplayCutiRaw($icno, $tarikh) == 'WFH') {
            //     $val = 1;
            // }

            if ($wp->is_rest == 1) {
                $val = 0;
            }

            if($wp->no_early_out == 1) {
                $val = 0;
            }
        }

        return $val;
    }

    
    /**
     * 
     * @param time $start clock_in (mesti pakai masa sja.. x bleh ada haribulan)
     * @param time $end clock_out (mesti pakai masa sja.. x bleh ada haribulan)
     * @param time $start_in wp punya start_in_time
     * @return float jumlah jam bekerja
     */
    public static function totalHours($start, $end, $start_in) {

        if ($start < $start_in) {

            $start = $start_in;
        }

        $time1 = strtotime($start);
        $time2 = strtotime($end);
        $difference = round(abs($time2 - $time1) / 3600, 2);
        return $difference;
    }

    public function getDisplayWp() {

        $view = '<h5>Start : <strong>' . $this->masaMasuk . '</strong> <i class="fa fa-arrow-right"></i> End : <strong>' . $this->masaKeluar . '</strong></h5>';

        if ($this->is_flexi) {

            $view = "<h5>Start : <strong>" . $this->inStartTime . " - " . $this->inEndTime . "</strong> <i class='fa fa-arrow-right'></i> End : <strong>" . $this->outStartTime . " - " . $this->outEndTime . "</strong></h5><h5>(Working Hours : <strong>" . $this->total_hours . " Hours </strong>)</h5>";
        }

        if($this->is_flexi && $this->no_incomplete){
            $view = "<h5>Start Before : <strong>" . $this->inEndTime . "</strong> </h5><h5 style='color:red'>(Not required to Clock Out)</h5>";
        }


        return $view;
    }
    
   

}
