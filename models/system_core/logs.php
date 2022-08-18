<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "system_core.tbl_logs".
 *
 * @property int $id
 * @property string $icno
 * @property string $log_time
 * @property string $ip_address
 * @property string $action
 * @property string $detail
 * @property string $data
 */
class logs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.tbl_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['log_time','data'], 'safe'],
            [['icno'], 'string', 'max' => 15],
            [['data'], 'string'],
            [['ip_address', 'action'], 'string', 'max' => 100],
            [['detail'], 'string', 'max' => 255],
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
            'data' => 'Unserialize array',
        ];
    }
}
