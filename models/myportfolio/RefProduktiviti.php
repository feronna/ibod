<?php

namespace app\models\myportfolio;

use Yii;

/**
 * This is the model class for table "myportfolio.ref_produktiviti".
 *
 * @property int $id
 * @property string $tahap_produktiviti
 */
class RefProduktiviti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_ref_produktiviti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahap_produktiviti'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahap_produktiviti' => 'Tahap Produktiviti',
        ];
    }
}
