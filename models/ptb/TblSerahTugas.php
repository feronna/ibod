<?php

namespace app\models\ptb;

use Yii;

/**
 * This is the model class for table "ptb.tbl_serah_tugas".
 *
 * @property int $id
 * @property int $tugas_id
 * @property string $icno
 * @property string $senarai_tugas
 * @property string $tugas_belum_selesai
 * @property string $kedudukan_sekarang
 * @property string $tindakan_susulan
 * @property string $rujukan_fail
 * @property string $senarai_harta_benda
 * @property string $kedudukan_kewangan
 * @property string $catatan
 */
class TblSerahTugas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.ptb_tbl_serah_tugas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tugas_id'], 'integer'],
            [['icno'], 'string', 'max' => 15],
            [['senarai_tugas', 'tugas_belum_selesai', 'kedudukan_sekarang', 'tindakan_susulan', 'rujukan_fail', 'senarai_harta_benda', 'kedudukan_kewangan', 'catatan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tugas_id' => 'Tugas ID',
            'icno' => 'Icno',
            'senarai_tugas' => 'Senarai Tugas',
            'tugas_belum_selesai' => 'Tugas Belum Selesai',
            'kedudukan_sekarang' => 'Kedudukan Sekarang',
            'tindakan_susulan' => 'Tindakan Susulan',
            'rujukan_fail' => 'Rujukan Fail',
            'senarai_harta_benda' => 'Senarai Harta Benda',
            'kedudukan_kewangan' => 'Kedudukan Kewangan',
            'catatan' => 'Catatan',
        ];
    }
    
   
}
