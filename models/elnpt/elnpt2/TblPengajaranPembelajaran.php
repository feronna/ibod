<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_tbl_pengajaran_pembelajaran".
 *
 * @property int $id
 * @property string $lpp_id
 * @property string $kod_kursus
 * @property string $nama_kursus
 * @property string $skop_tugas
 * @property string $status_pengendalian
 * @property string $penglibatan
 * @property int $semester
 */
class TblPengajaranPembelajaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_tbl_pengajaran_pembelajaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_pengendalian', 'nama_kursus', 'kod_kursus', 'skop_tugas', 'penglibatan'], 'required'],
            [['lpp_id'], 'integer'],
            [['kod_kursus', 'skop_tugas', 'penglibatan'], 'string', 'max' => 20],
            [['nama_kursus'], 'string', 'max' => 200],
            [['status_pengendalian'], 'string', 'max' => 50],
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
            'skop_tugas' => 'Skop Tugas',
            'status_pengendalian' => 'Status Pengendalian',
            'penglibatan' => 'Penglibatan',
            // 'semester' => 'Semester',
        ];
    }
    
    public function getKategori() {
        return $this->hasOne(\app\models\elnpt\RefPnpKursus::className(), ['KodSubjek' => 'kod_kursus']);
    }
}
