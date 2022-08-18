<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.tbl_logs".
 *
 * @property int $id
 * @property string $icno
 * @property string $action
 * @property string $datetime
 * @property int $ref_id
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['action'], 'string'],
            [['datetime'], 'safe'],
            [['ref_id'], 'integer'],
            [['icno'], 'string', 'max' => 12],
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
            'action' => 'Action',
            'datetime' => 'Datetime',
            'ref_id' => 'Ref ID',
        ];
    }
}
