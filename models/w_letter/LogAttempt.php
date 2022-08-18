<?php

namespace app\models\w_letter;

use Yii;

/**
 * This is the model class for table "hrm.wl_log_failed".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $desc
 * @property string $datetime
 */
class LogAttempt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.wl_log_failed';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datetime'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['desc'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'desc' => 'Desc',
            'datetime' => 'Datetime',
        ];
    }
}
