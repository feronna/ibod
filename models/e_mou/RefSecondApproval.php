<?php

namespace app\models\e_mou;

use Yii;

/**
 * This is the model class for table "emou.r_emou13_second_approval".
 *
 * @property int $second_approval_id
 * @property string $second_approval_desc
 */
class RefSecondApproval extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.r_emou13_second_approval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['second_approval_desc'], 'required'],
            [['second_approval_desc'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'second_approval_id' => 'Second Approval ID',
            'second_approval_desc' => 'Second Approval Desc',
        ];
    }
}
