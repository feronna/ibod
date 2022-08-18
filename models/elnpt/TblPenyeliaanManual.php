<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_penyeliaan".
 *
 * @property int $id
 * @property string $lpp_id
 * @property int $tahap_penyeliaan 1 = Sarjana (Kerja Kursus); 2 = Sarjana Muda (Projek Tahun Akhir/ Latihan Industri/ Latihan Amali/ Praktikum)
 * @property int $utama_telah SEBAGAI PENYELIA UTAMA/ PENGERUSI
 * @property int $utama_belum SEBAGAI PENYELIA UTAMA/ PENGERUSI
 * @property int $sama_telah SEBAGAI PENYELIA BERSAMA/ AHLI
 * @property int $sama_belum SEBAGAI PENYELIA BERSAMA/ AHLI
 */
class TblPenyeliaanManual extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_penyeliaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'tahap_penyeliaan'], 'integer'],
            [['utama_telah', 'utama_belum', 'sama_telah', 'sama_belum'], 'integer'],
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
            'tahap_penyeliaan' => 'Tahap Penyeliaan',
            'utama_telah' => 'Input',
            'utama_belum' => 'Input',
            'sama_telah' => 'Input',
            'sama_belum' => 'Input',
        ];
    }
}
