<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "system_core.access_token".
 *
 * @property int $id
 * @property string $icno
 * @property string $token
 * @property string $start_dt
 * @property string $end_dt
 */
class AccessToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.access_token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_dt', 'end_dt'], 'safe'],
            [['icno'], 'string', 'max' => 12],
            [['token'], 'string', 'max' => 40],
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
            'token' => 'Token',
            'start_dt' => 'Start Dt',
            'end_dt' => 'End Dt',
        ];
    }
}
