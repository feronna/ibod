<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%hrd.idp_kursuslatihanimport}}".
 *
 * @property int $kursusLatihanID
 * @property string $tajukLatihan
 * @property string $statusKursus
 * @property string $pemuatNaik
 * @property string $tarikhMuatNaik
 * @property string $unitBertanggungjawab
 * @property int $peringkat
 * @property string $jenisPenganjur
 * @property string $namaPenganjur
 * @property string $sinopsisKursus
 */
class KursusLatihanImport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_kursuslatihanimport}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tajukLatihan', 'sinopsisKursus'], 'string'],
            [['tarikhMuatNaik'], 'safe'],
            [['peringkat'], 'integer'],
            [['statusKursus', 'unitBertanggungjawab', 'jenisPenganjur'], 'string', 'max' => 25],
            [['pemuatNaik'], 'string', 'max' => 12],
            [['namaPenganjur'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kursusLatihanID' => 'Kursus Latihan ID',
            'tajukLatihan' => 'Tajuk Latihan',
            'statusKursus' => 'Status Kursus',
            'pemuatNaik' => 'Pemuat Naik',
            'tarikhMuatNaik' => 'Tarikh Muat Naik',
            'unitBertanggungjawab' => 'Unit Bertanggungjawab',
            'peringkat' => 'Peringkat',
            'jenisPenganjur' => 'Jenis Penganjur',
            'namaPenganjur' => 'Nama Penganjur',
            'sinopsisKursus' => 'Sinopsis Kursus',
        ];
    }
}
