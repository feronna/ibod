<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%myidp.ref_statussirilatihan}}".
 *
 * @property string $statusDesc
 */
class RefStatusSiriLatihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_ref_statussirilatihan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['statusDesc'], 'required'],
            [['statusDesc'], 'string', 'max' => 25],
            [['statusDesc'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'statusDesc' => 'Status Desc',
        ];
    }
}
