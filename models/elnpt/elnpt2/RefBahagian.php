<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_ref_bahagian".
 *
 * @property int $id
 * @property string $bahagian
 * @property string $bhg_kod
 * @property string $bhg_color
 */
class RefBahagian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_ref_bahagian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bahagian'], 'string', 'max' => 300],
            [['bhg_kod'], 'string', 'max' => 150],
            [['bhg_color'], 'string', 'max' => 30],
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
            'bhg_color' => 'Bhg Color',
        ];
    }
}
