<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%myidp.kehadiranimport}}".
 *
 * @property string $pemuatNaik
 * @property string $tarikhMuatNaik
 * @property int $slotID
 * @property string $staffEmail
 */
class KehadiranImport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_kehadiranimport}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikhMuatNaik'], 'safe'],
            [['slotID', 'staffEmail'], 'required'],
            [['slotID'], 'integer'],
            [['pemuatNaik'], 'string', 'max' => 12],
            [['staffEmail'], 'string', 'max' => 100],
            [['slotID', 'staffEmail'], 'unique', 'targetAttribute' => ['slotID', 'staffEmail']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pemuatNaik' => 'Pemuat Naik',
            'tarikhMuatNaik' => 'Tarikh Muat Naik',
            'slotID' => 'Slot ID',
            'staffEmail' => 'Staff Email',
        ];
    }
}
