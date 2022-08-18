<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hrm.lppums_markah_bahagian".
 *
 * @property int $markah_bahagian
 * @property int $kump_khidmat
 * @property string $bahagian_id
 */
class RefMarkahBahagian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_markah_bahagian';
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
            [['markah_bahagian', 'kump_khidmat', 'bahagian_id'], 'integer'],
            [['bahagian_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'markah_bahagian' => 'Markah Bahagian',
            'kump_khidmat' => 'Kump Khidmat',
            'bahagian_id' => 'Bahagian ID',
        ];
    }
}
