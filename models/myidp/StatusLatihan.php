<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "myidp.statusLatihan".
 *
 * @property string $statusLatihanID
 */
class StatusLatihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'myidp.statusLatihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['statusLatihanID'], 'required'],
            [['statusLatihanID'], 'string', 'max' => 25],
            [['statusLatihanID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'statusLatihanID' => 'Status Latihan ID',
        ];
    }
}
