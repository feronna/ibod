<?php

namespace app\models\patrol;

use Yii;

/**
 * This is the model class for table "keselamatan.patrol_tbl_logs".
 *
 * @property int $id
 * @property string $icno
 * @property string $log_time
 * @property string $ip_address
 * @property string $action
 * @property string $detail
 */
class logs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.patrol_tbl_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['log_time'], 'safe'],
            [['ip_address', 'action', 'detail'], 'string'],
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
            'log_time' => 'Log Time',
            'ip_address' => 'Ip Address',
            'action' => 'Action',
            'detail' => 'Detail',
        ];
    }
}
