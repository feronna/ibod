<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.tbl_reports".
 *
 * @property int $id
 * @property string $icno
 * @property string $tarikh
 * @property string $day
 * @property string $wbb
 * @property string $in_time
 * @property string $out_time
 * @property string $non_compliance_sts
 * @property string $leave_outstation
 * @property string $working_hours
 * @property int $remark
 * @property string $in_lng_lat
 * @property string $out_lng_lat
 * @property int $rekod_id refer id tbl_rekod
 * @property string $create_at
 */
class TblReports extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_reports';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh', 'create_at'], 'safe'],
            [['remark', 'rekod_id'], 'integer'],
            [['icno'], 'string', 'max' => 16],
            [['day'], 'string', 'max' => 10],
            [['wbb', 'in_time', 'out_time', 'working_hours'], 'string', 'max' => 50],
            [['non_compliance_sts'], 'string', 'max' => 100],
            [['leave_outstation'], 'string', 'max' => 255],
            [['in_lng_lat', 'out_lng_lat'], 'string', 'max' => 200],
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
            'tarikh' => 'Tarikh',
            'day' => 'Day',
            'wbb' => 'Wbb',
            'in_time' => 'In Time',
            'out_time' => 'Out Time',
            'non_compliance_sts' => 'Non Compliance Sts',
            'leave_outstation' => 'Leave Outstation',
            'working_hours' => 'Working Hours',
            'remark' => 'Remark',
            'in_lng_lat' => 'In Lng Lat',
            'out_lng_lat' => 'Out Lng Lat',
            'rekod_id' => 'Rekod ID',
            'create_at' => 'Create At',
        ];
    }
}
