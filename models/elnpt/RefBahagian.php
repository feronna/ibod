<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_ref_bahagian".
 *
 * @property int $id
 * @property string $bahagian
 * @property string $bhg_kod Nama action
 */
class RefBahagian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_ref_bahagian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bahagian'], 'string', 'max' => 100],
            [['bhg_kod'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bahagian' => 'Bahagian',
            'bhg_kod' => 'Bhg Kod',
        ];
    }
}
