<?php

namespace app\models\myidp;

use Yii;
use app\models\myidp\RefKategori;

/**
 * This is the model class for table "hrd.idp_kehadiran_siri".
 *
 * @property int $siriLatihanID
 * @property string $staffID
 * @property int $kompetensi
 * @property string $tarikhMasa
 */
class KehadiranSiri extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_kehadiran_siri';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siriLatihanID', 'staffID'], 'required'],
            [['siriLatihanID', 'kompetensi'], 'integer'],
            [['tarikhMasa'], 'safe'],
            [['staffID'], 'string', 'max' => 12],
            [['siriLatihanID', 'staffID'], 'unique', 'targetAttribute' => ['siriLatihanID', 'staffID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'siriLatihanID' => 'Siri Latihan ID',
            'staffID' => 'Staff ID',
            'kompetensi' => 'Kompetensi',
            'tarikhMasa' => 'Tarikh Masa',
        ];
    }

    public function getSiriLatihan()
    {
        return $this->hasOne(SiriLatihan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }

    public function getPermohonan()
    {
        return $this->hasOne(PermohonanLatihan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }

    public function calculatePeserta($siriID)
    {
        $totalpeserta = KehadiranSiri::find()
            ->where(['siriLatihanID' => $siriID])
            ->count();

        return $totalpeserta;
    }

    public function calculatePesertaByMonth($month, $year)
    {

        $totalpeserta = KehadiranSiri::find()
            ->joinWith('siriLatihan.sasaran3')
            ->where(['MONTH(tarikhMula)' => $month, 'YEAR(tarikhMula)' => $year, 'jenisLatihanID' => 'latihanDalaman'])
            ->count();

        return $totalpeserta;
    }

    public function calculatePesertaWalkIn($month, $year)
    {
        $totalpeserta = KehadiranSiri::find()
            ->joinWith('siriLatihan.sasaran3')
            ->where(['MONTH(tarikhMula)' => $month, 'YEAR(tarikhMula)' => $year, 'jenisLatihanID' => 'latihanDalaman'])
            ->all();

        $counter = 0;    
        foreach ($totalpeserta as $p){

            $checkMohon = PermohonanLatihan::find()
                ->where(['staffID' => $p->staffID])
                ->andWhere(['siriLatihanID' => $p->siriLatihanID])
                ->one();

            if (!$checkMohon){
                $counter++;
            }

        }

        return $counter;
    }
}
