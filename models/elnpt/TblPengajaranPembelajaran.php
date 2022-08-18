<?php

namespace app\models\elnpt;

use app\models\elnpt\TblJamWaktu;

/**
 * This is the model class for table "hrm.elnpt_tbl_pengajaran_pembelajaran".
 *
 * @property int $id
 * @property string $lpp_id
 * @property string $kod_kursus
 * @property string $nama_kursus
 * @property int $bil_pelajar
 * @property string $sesi
 * @property int $jam_kredit
 */
class TblPengajaranPembelajaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_pengajaran_pembelajaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kod_kursus', 'nama_kursus', 'bil_pelajar', 'jam_kredit', 'seksyen', 'sesi'], 'required'],
            [['lpp_id', 'bil_pelajar', 'jam_kredit',], 'integer'],
            [['seksyen'], 'integer', 'min' => 0],
            [['kod_kursus'], 'string', 'max' => 20],
            [['nama_kursus'], 'string', 'max' => 200],
            [['sesi'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'kod_kursus' => 'Kod Kursus',
            'nama_kursus' => 'Nama Kursus',
            'bil_pelajar' => 'Bil Pelajar',
            'sesi' => 'Sesi',
            'jam_kredit' => 'Jam Kredit',
        ];
    }
    
    public function getJamWaktu() {
        return $this->hasMany(TblJamWaktu::className(), ['ref_id' => 'id'])->andOnCondition(['lpp_id' => $this->lpp_id]);
    }
    
    public function getPppsah() {
        return $this->hasOne(TblJamWaktu::className(), ['ref_id' => 'id']);
    }
    
    public function getKategori() {
        return $this->hasOne(\app\models\elnpt\RefPnpKursus::className(), ['KodSubjek' => 'kod_kursus']);
    }
}
