<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_tbl_penyeliaan".
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
    public $file;
    public $filehash;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_tbl_penyeliaan';
    }

    public static function primaryKey()
    {
        return ["lpp_id", 'tahap_penyeliaan'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['utama_telah', 'utama_belum', 'sama_telah', 'sama_belum', 'utama_telah_sem', 'sama_telah_sem'], 'required'],
            [['utama_telah', 'utama_belum', 'sama_telah', 'sama_belum', 'utama_telah_sem', 'sama_telah_sem', 'tahap_penyeliaan', 'bil_pelajar'], 'integer', 'min' => 0],
            [['utama_telah', 'utama_belum', 'sama_telah', 'sama_belum', 'utama_telah_sem', 'sama_telah_sem', 'bil_pelajar'], 'default', 'value' => 0],
            [['verified_by'], 'string', 'max' => 12],
            [['verified_dt'], 'safe'],
            // ['tahap_penyeliaan', 'exist', 'targetClass' => TblPenyeliaanManual::class, 'targetAttribute' => ['lpp_id' => 'lpp_id', 'tahap_penyeliaan' => 'tahap_penyeliaan']], 
            [['tahap_penyeliaan', 'lpp_id'], 'unique', 'targetClass' => TblPenyeliaanManual::class, 'targetAttribute' => ['lpp_id' => 'lpp_id', 'tahap_penyeliaan' => 'tahap_penyeliaan'], 'message' => 'Data already exists!'],
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
            'utama_telah' => 'Utama Telah',
            'utama_belum' => 'Utama Belum',
            'sama_telah' => 'Sama Telah',
            'sama_belum' => 'Sama Belum',
            'bil_pelajar' => 'Bil Pelajar',
        ];
    }

    public static function fileHash($lpp_id, $bhg_no, $id)
    {
        $doc = TblDocuments::find()->where(['lpp_id' => $lpp_id, 'bhg_no' => $bhg_no, 'id_table' => $id])->one();
        return $doc->filehash;
    }
}
