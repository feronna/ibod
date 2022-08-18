<?php

namespace app\models\kehadiran;

use Yii;
use app\models\kehadiran\TblRekod;

/**
 * This is the model class for table "tbl_locums".
 *
 * @property int $id
 * @property string $icno
 * @property string $day
 * @property string $tarikh
 * @property string $time_in
 * @property string $time_out
 * @property string $in_lat_lng
 * @property string $out_lat_lng
 * @property string $in_ip
 * @property string $out_ip
 * @property string $remark
 */
class TblLocums extends \yii\db\ActiveRecord {

    public $latlng;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'attendance.tbl_locums';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['tarikh', 'time_in', 'time_out'], 'safe'],
            [['icno'], 'string', 'max' => 15],
            [['day'], 'string', 'max' => 10],
            [['in_lat_lng', 'out_lat_lng', 'latlng'], 'string', 'max' => 100],
            [['in_ip', 'out_ip'], 'string', 'max' => 30],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'day' => 'Day',
            'tarikh' => 'Tarikh',
            'time_in' => 'Time In',
            'time_out' => 'Time Out',
            'in_lat_lng' => 'In Lat Lng',
            'out_lat_lng' => 'Out Lat Lng',
            'in_ip' => 'In Ip',
            'out_ip' => 'Out Ip',
            'remark' => 'Purpose / Remark',
            'formatDate' => 'Date',
            'formatTimeIn' => 'Time In',
            'formatTimeOut' => 'Time Out',
        ];
    }

    public function getFormatTimeIn() {

        return $this->time_in ? TblRekod::changeDatetimeToTime($this->time_in) : '-';
    }

    public function getFormatTimeOut() {

        return $this->time_out ? TblRekod::changeDatetimeToTime($this->time_out) : '-';
    }

    public function getFormatDate() {

        return $this->tarikh ? TblRekod::changeDateFormat($this->tarikh) : '-';
    }

    public static function CurrentRecords($icno) {

        $start = '00:00:00';
        $end = '07:00:00';
        
        $yesterday = date("Y-m-d", strtotime( '-1 days' ) );
        
        $today = date("Y-m-d");

        $time = date('H:i:s');

        //klu masa dalam range jam 12 pagi smpi jam 7 pagi.. check dlu klu ada record kemarin
        if ($time >= $start && $time <= $end) {
            
            $model = self::findOne(['icno' => $icno, 'tarikh' => $yesterday]);
            
            if(!$model){
                $model = self::findOne(['icno' => $icno, 'tarikh' => $today]);
            }
            
        } else {
            $model = self::findOne(['icno' => $icno, 'tarikh' => $today]);
        }
        
        return $model;
    }

}
