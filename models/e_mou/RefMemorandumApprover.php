<?php

namespace app\models\e_mou;

use Yii;

/**
 * This is the model class for table "emou.r_emou15_approver_committee".
 *
 * @property int $approver_committee_id ID
 * @property string $approver_committee_desc JK Pelulus
 */
class RefMemorandumApprover extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.r_emou15_approver_committee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['approver_committee_desc'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'approver_committee_id' => 'Approver Committee ID',
            'approver_committee_desc' => 'Approver Committee Desc',
        ];
    }
}
