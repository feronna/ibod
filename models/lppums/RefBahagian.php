<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hrm.lppums_ref_bahagian".
 *
 * @property int $bahagian_id
 * @property string $bahagian
 */
class RefBahagian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_bahagian';
    }
    
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bahagian'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bahagian_id' => Yii::t('app', 'Bahagian ID'),
            'bahagian' => Yii::t('app', 'Aspek Penilaian'),
        ];
    }
}
