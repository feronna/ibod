<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "tbl_location".
 *
 * @property int $id
 * @property string $kod
 * @property string $location
 * @property string $lat_start
 * @property string $lat_end
 * @property string $lng_start
 * @property string $lng_end
 * @property int $status
 */
class TblLocation extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tbl_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['lat_start', 'lat_end', 'lng_start', 'lng_end'], 'number'],
            [['status'], 'integer'],
            [['kod'], 'string', 'max' => 10],
            [['location'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'kod' => 'Kod',
            'location' => 'Location',
            'lat_start' => 'Lat Start',
            'lat_end' => 'Lat End',
            'lng_start' => 'Lng Start',
            'lng_end' => 'Lng End',
            'status' => 'Status',
        ];
    }

    public static function CheckZone($latlng, $isRaw = false) {

        $myArray = explode(',', $latlng);

        $lat = $myArray[0];
        $lng = $myArray[1];
        $sql = 'SELECT * FROM attendance.tbl_location WHERE :lat BETWEEN lat_start AND lat_end AND :lng BETWEEN lng_start AND lng_end';
        $location = self::findBySql($sql, [':lat' => $lat, ':lng' => $lng])->one();

        if ($isRaw) {
            if ($location) {
                return $location->kod;
            }else{
                return 'Out Zone';
            }
        }

        if ($location) {
            return true;
        }

        return false;
    }

}
