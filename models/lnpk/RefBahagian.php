<?php

namespace app\models\lnpk;

use Yii;

/**
 * This is the model class for table "hrm.lnpk_ref_bahagian".
 *
 * @property int $id
 * @property string $bahagian
 */
class RefBahagian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lnpk_ref_bahagian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bahagian'], 'string', 'max' => 50],
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
        ];
    }
}
