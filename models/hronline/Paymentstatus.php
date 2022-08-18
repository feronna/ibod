<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.paymentstatus".
 *
 * @property int $paymentstatus_id
 * @property string $paymentstatus_desc
 */
class Paymentstatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.paymentstatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paymentstatus_desc'], 'required'],
            [['paymentstatus_desc'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'paymentstatus_id' => 'Paymentstatus ID',
            'paymentstatus_desc' => 'Paymentstatus Desc',
        ];
    }
}
