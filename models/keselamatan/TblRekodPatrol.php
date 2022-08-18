<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.tbl_rekod_patrol".
 *
 * @property int $id
 * @property string $icno
 * @property string $day
 * @property string $tarikh
 * @property string $time_in
 * @property string $time_out
 * @property int $reason_id refer table ref_reason
 * @property string $status_in LATE_IN, NO_PUNCH
 * @property string $status_out EARLY_OUT, INCOMPLETE
 * @property string $incomplete
 * @property string $absent 1 = kira absent | system generated
 * @property string $external 1 = external ip | 0 = internal ip
 * @property string $app_by
 * @property string $app_dt
 * @property string $remark_status ENTRY | APPROVED
 * @property int $patrol_id refer table ref_wp
 * @property string $in_lat_lng
 * @property string $out_lat_lng
 * @property string $in_ip
 * @property string $out_ip
 * @property string $remark
 * @property string $app_remark
 */
class TblRekodPatrol extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_rekod_patrol';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'reason_id', 'patrol_id','campus_id'], 'integer'],
            [['tarikh', 'time_in', 'time_out', 'app_dt'], 'safe'],
            [['icno'], 'string', 'max' => 15],
            [['day', 'status_in', 'status_out', 'remark_status'], 'string', 'max' => 10],
            [['incomplete', 'absent', 'external'], 'string', 'max' => 1],
            [['app_by'], 'string', 'max' => 16],
            [['in_lat_lng', 'out_lat_lng'], 'string', 'max' => 50],
            [['in_ip', 'out_ip'], 'string', 'max' => 30],
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
            'reason_id' => 'Reason ID',
            'status_in' => 'Status In',
            'status_out' => 'Status Out',
            'incomplete' => 'Incomplete',
            'absent' => 'Absent',
            'external' => 'External',
            'app_by' => 'App By',
            'app_dt' => 'App Dt',
            'remark_status' => 'Remark Status',
            'patrol_id' => 'Patrol ID',
            'in_lat_lng' => 'In Lat Lng',
            'out_lat_lng' => 'Out Lat Lng',
            'in_ip' => 'In Ip',
            'out_ip' => 'Out Ip',
            'remark' => 'Remark',
            'app_remark' => 'App Remark',
        ];
    }
    
    public function getStaff() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
