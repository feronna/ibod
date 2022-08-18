<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.tbl_odometer".
 *
 * @property int $id
 * @property string $plate_num
 * @property int $start_odo
 * @property int $end_odo
 * @property int $distance
 * @property string $entered_by
 * @property string $date
 * @property string $syif
 */
class TblOdometer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_odometer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_odo', 'end_odo', 'distance','campus_id'], 'integer'],
            [['date'], 'safe'],
            [['plate_num'], 'string', 'max' => 10],
            [['entered_by'], 'string', 'max' => 20],
            [['syif'], 'string', 'max' => 3],
            [['syif'], 'required', 'message' => 'Sila Pilih Syif !'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plate_num' => 'Plate Num',
            'start_odo' => 'Start Odo',
            'end_odo' => 'End Odo',
            'distance' => 'Distance',
            'entered_by' => 'Entered By',
            'date' => 'Date',
            'syif' => 'Syif',
        ];
    }
}
