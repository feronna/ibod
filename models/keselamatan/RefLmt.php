<?php

namespace app\models\keselamatan;

use DateTime;
use Yii;

/**
 * This is the model class for table "keselamatan.ref_lmt".
 *
 * @property int $id
 * @property string $jenis_shifts
 * @property string $details
 * @property string $start_time
 * @property string $end_time
 * @property string $entry_by
 * @property string $update_by
 * @property string $update_dt
 * @property int $active
 */
class RefLmt extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.ref_lmt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['start_time', 'end_time', 'update_dt', 'start_date', 'end_date'], 'safe'],
            [['active'], 'integer'],
            [['jenis_shifts'], 'string', 'max' => 50],
            [['details'], 'string', 'max' => 255],
            [['entry_by', 'update_by'], 'string', 'max' => 20],
            [['details'], 'required', 'message' => 'Sila Masukkan Tujuan Syif'],
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
            'active' => 'Active',
        ];
    }

    public function getMasaMasuk() {

        $oDate = new DateTime($this->start_time);
        $sDate = $oDate->format("h:i A");
//                var_dump($sDate);die;

        return $sDate;
    }

    public function getMasaKeluar() {

        $oDate = new DateTime($this->end_time);
        $sDate = $oDate->format("h:i A");

        return $sDate;
    }

    public function getStatus() {
        if ($this->active == '1') {
            return '<span class="label label-success">Aktif</span>';
        } else {
            return '<span class="label label-warning">Tidak Aktif</span>';
        }
    }

}
