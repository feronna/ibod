<?php

namespace app\models\ln;

use Yii;

/**
 * This is the model class for table "hrm.ln_ref_aktiviti".
 *
 * @property int $id
 * @property string $aktiviti
 * @property int $isActive
 */
class Refaktiviti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.ln_ref_aktiviti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isActive'], 'integer'],
            [['aktiviti'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aktiviti' => 'Aktiviti',
            'isActive' => 'Is Active',
        ];
    }
}
