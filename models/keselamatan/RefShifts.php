<?php

namespace app\models\keselamatan;

use app\models\kehadiran\RefWp;
use app\models\kehadiran\TblRekod;
use DateTime;
use Yii;

/**
 * This is the model class for table "keselamatan.ref_shifts".
 *
 * @property int $id
 * @property string $jenis_shifts
 * @property string $details
 * @property string $start_time
 * @property string $end_time
 * @property string $entry_by
 * @property string $update_by
 * @property string $update_dt
 */
class RefShifts extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.ref_shifts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['start_time', 'end_time'], 'safe'],
            [['jenis_shifts'], 'string', 'max' => 100],
            [['details'], 'string', 'max' => 255],
            [['entry_by', 'update_by', 'update_dt'], 'string', 'max' => 20],
            [['active','isCounted'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'jenis_shifts' => 'Jenis Shifts',
            'details' => 'Details',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'entry_by' => 'Entry By',
            'update_by' => 'Update By',
            'update_dt' => 'Update Dt',
        ];
    }

    public static function checkStatusIn($icno, $tarikh, $time_now, $wp_id) {

        $val = 0;
        $wp = RefWp::findOne(['id' => $wp_id]);

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
                // echo 'dd';die;


        //if late_in try check dlu cuti.. klu != '-' tukar pegi null semula
        if ($val == 1) {

            if (\app\models\keselamatan\TblRekod::DisplayCuti($icno, $tarikh) != '') {
                // echo 'd';die;
                $val = 0;
            }

            if ($wp->is_rest == 1) {
                $val = 0;
            }
        }
// echo $val;die;

        return $val;
    }
    public static function checkStatusOut($icno, $tarikh, $time_now, $wp_id) {

        $val = 0;

        $wp = RefWp::findOne(['id' => $wp_id]);

        //if flexi
        if ($wp->is_flexi == 1) {

            $rekod = \app\models\keselamatan\TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
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

            if ( \app\models\keselamatan\TblRekod::DisplayCuti($icno, $tarikh) != '') {
                $val = 0;
            }

            if ($wp->is_rest == 1) {
                $val = 0;
            }

            if($wp->no_early_out == 1) {
                $val = 0;
            }
        }
// echo $val;die;

        return $val;
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

    public function getSyif() {
        
    }

     public function changeDatetimeToTime($datetime)
    {

        $dt = date_create($datetime);

        $time = date_format($dt, "h:i A");

        echo $time;die;
        return $time;
    }

    public static function totalHours($start1, $end1, $start_in) {

        // var_dump($start1, $end1, $start_in);die;
        $start =  DATE("H:i", STRTOTIME($start1));
        $end2 =  DATE("H:i", STRTOTIME($end1));

        if ($start < $start_in) {

            $start = $start_in;
        }
        $dt = date_create($end2);
        $end = date_format($dt, "h:i A");
// var_dump($dt);die;
        $time1 = strtotime($start);
        $time2 = strtotime($end);
        $difference = round(abs($time2 - $time1) / 3600, 2);
    // var_dump($difference);die;
        return $difference;
    }
    public static function syif($id){
        if ($id == 3) {
            $syif = ['A', 'A6'];
        } else
        if ($id == 4) {
            $syif = ['C', 'C6', 'C1', 'C2'];
        }
        // if ($id == 5) 
        else {
            $syif = ['B', 'B6'];
        }
        return $syif;
    }
}
