<?php

namespace app\models\w_letter;

use Yii;

/**
 * This is the model class for table "hrm.wl_ref_time_ppv".
 *
 * @property int $id
 * @property string $time
 */
class RefTimePpv extends \yii\db\ActiveRecord
{
     public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.wl_ref_time_ppv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
        ];
    }
}
