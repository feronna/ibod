<?php

namespace app\models\w_letter;

use Yii;

/**
 * This is the model class for table "hrm.wl_temp_jadual".
 *
 * @property int $bil
 * @property string $umsper
 * @property string $icno
 * @property string $nama
 * @property string $jawatan
 * @property string $kategori
 * @property string $tarikh
 * @property string $jfpib
 * @property string $justifikasi
 * @property string $kj_icno
 * @property int $status_proses
 */
class TblKategori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.wl_temp_jadual';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh'], 'safe'],
            [['justifikasi'], 'string'],
            [['status_proses'], 'integer'],
            [['umsper'], 'string', 'max' => 20],
            [['icno', 'kj_icno'], 'string', 'max' => 12],
            [['nama'], 'string', 'max' => 200],
            [['jawatan', 'kategori'], 'string', 'max' => 100],
            [['jfpib'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bil' => 'Bil',
            'umsper' => 'Umsper',
            'icno' => 'Icno',
            'nama' => 'Nama',
            'jawatan' => 'Jawatan',
            'kategori' => 'Kategori',
            'tarikh' => 'Tarikh',
            'jfpib' => 'Jfpib',
            'justifikasi' => 'Justifikasi',
            'kj_icno' => 'Kj Icno',
            'status_proses' => 'Status Proses',
        ];
    }
}
