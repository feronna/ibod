<?php

namespace app\models\cuti;

use Yii;

/**
 * This is the model class for table "hrm.cuti_open_application".
 *
 * @property int $id
 * @property string $full_date
 * @property string $start_date
 * @property string $end_date
 * @property string $remark
 * @property int $status
 * @property string $open_by
 * @property string $update_by
 */
class CutiOpenApplication extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_open_application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date'], 'safe'],
            [['status'], 'integer'],
            [['full_date'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 255],
            [['open_by', 'update_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_date' => 'Full Date',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'remark' => 'Remark',
            'status' => 'Status',
            'open_by' => 'Open By',
            'update_by' => 'Update By',
        ];
    }
}
