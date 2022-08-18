<?php

namespace app\models\tatatertib_staf;

use Yii;

/**
 * This is the model class for table "hrm.tertib_tbl_rekod_tatatertib".
 *
 * @property int $id
 * @property string $icno
 * @property string $nama
 * @property string $jenis_kesalahan
 * @property string $kes
 * @property string $tarikh_mesyuarat
 * @property string $tarikh_mula_hukuman
 * @property string $tarikh_akhir_hukuman
 * @property string $jenis_hukuman
 * @property string $catatan_hukuman
 * @property string $tarikh_rayuan
 * @property string $tarikh_rayuan_semula
 * @property string $rayuan
 * @property string $catatan_rayuan
 * @property string $status_kes
 * @property int $kumpulan_jawatan
 * @property int $skim_perkhidmatan
 * @property string $created_at
 * @property int $dept_id
 * @property int $campus_id
 */
class TblRekodTatatertib extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tertib_tbl_rekod_tatatertib';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_kesalahan', 'kes', 'jenis_hukuman', 'catatan_hukuman', 'catatan_rayuan'], 'string'],
            [['kumpulan_jawatan', 'skim_perkhidmatan', 'dept_id', 'campus_id'], 'integer'],
            [['created_at'], 'safe'],
            [['icno'], 'string', 'max' => 15],
            [['nama'], 'string', 'max' => 255],
            [['tarikh_mesyuarat', 'tarikh_mula_hukuman', 'tarikh_akhir_hukuman', 'tarikh_rayuan', 'tarikh_rayuan_semula', 'rayuan', 'status_kes'], 'string', 'max' => 55],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'nama' => 'Nama',
            'jenis_kesalahan' => 'Jenis Kesalahan',
            'kes' => 'Kes',
            'tarikh_mesyuarat' => 'Tarikh Mesyuarat',
            'tarikh_mula_hukuman' => 'Tarikh Mula Hukuman',
            'tarikh_akhir_hukuman' => 'Tarikh Akhir Hukuman',
            'jenis_hukuman' => 'Jenis Hukuman',
            'catatan_hukuman' => 'Catatan Hukuman',
            'tarikh_rayuan' => 'Tarikh Rayuan',
            'tarikh_rayuan_semula' => 'Tarikh Rayuan Semula',
            'rayuan' => 'Rayuan',
            'catatan_rayuan' => 'Catatan Rayuan',
            'status_kes' => 'Status Kes',
            'kumpulan_jawatan' => 'Kumpulan Jawatan',
            'skim_perkhidmatan' => 'Skim Perkhidmatan',
            'created_at' => 'Created At',
            'dept_id' => 'Dept ID',
            'campus_id' => 'Campus ID',
        ];
    }
     public function statusTatatertib() {
        if ($this->icno) {
            return "Ya";
        } else {
            return "Tidak";
        }
    }
}
