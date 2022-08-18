<?php

namespace app\models\myhealth;

use Yii;

/**
 * This is the model class for table "hrm.myhealth_admin".
 *
 * @property int $id
 * @property string $icno
 * @property int $access_level 1= Penyemak
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myhealth_admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access_level'], 'integer'],
            [['icno'], 'string', 'max' => 15],
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
            'access_level' => 'Access Level',
        ];
    }
}
