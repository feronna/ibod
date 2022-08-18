<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%myidp.tbl_peserta_import}}".
 *
 * @property string $pemuatNaik
 * @property string $tarikhMuatNaik
 * @property int $permohonanID
 * @property string $staffEmail
 */
class PesertaImport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_tbl_peserta_import}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikhMuatNaik'], 'safe'],
            [['permohonanID', 'staffEmail'], 'required'],
            [['permohonanID'], 'integer'],
            [['pemuatNaik'], 'string', 'max' => 12],
            [['staffEmail'], 'string', 'max' => 100],
            [['permohonanID', 'staffEmail'], 'unique', 'targetAttribute' => ['permohonanID', 'staffEmail']],
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
            'permohonanID' => 'Permohonan ID',
            'staffEmail' => 'Staff Email',
        ];
    }
}
