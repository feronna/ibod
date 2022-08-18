<?php

namespace app\models\e_mou;

use Yii;

/**
 * This is the model class for table "emou.r_emou09_approval".
 *
 * @property int $approval_id
 * @property string $approval_desc
 */
class RefApproval extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.r_emou09_approval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['approval_desc'], 'required'],
            [['approval_desc'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'approval_id' => 'Approval ID',
            'approval_desc' => 'Approval Desc',
        ];
    }
}
