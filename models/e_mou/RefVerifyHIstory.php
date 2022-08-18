<?php

namespace app\models\e_mou;

use Yii;

/**
 * This is the model class for table "emou.r_emou07_verify".
 *
 * @property int $verify_id
 * @property string $verify_desc
 */
class RefVerifyHIstory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.r_emou07_verify';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['verify_desc'], 'required'],
            [['verify_desc'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verify_id' => 'Verify ID',
            'verify_desc' => 'Verify Desc',
        ];
    }
}
