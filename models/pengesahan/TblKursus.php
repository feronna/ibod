<?php

namespace app\models\pengesahan;

use Yii;

/**
 * This is the model class for table "pengesahan.tbl_kursus".
 *
 * @property string $ICNO
 * @property string $tarikhLulusPtm
 * @property string $tempatPtm
 * @property string $statusPtm
 * @property string $tarikhMesyuarat
 * @property string $bilMesyuarat
 * @property string $tarikhLulusPnp
 * @property string $tempatPnp
 * @property string $keputusan
 * @property string $statusPnp
 * @property string $tarikhKelulusanPnp
 * @property string $tarikhLulusPembentangan
 * @property string $tajukPembentangan
 * @property string $tempatPembentangan
 * @property string $statusPenyelidikan
 * @property string $tarikhKelulusanPenyelidikan
 */
class TblKursus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'pengesahan.tbl_kursus';
        return 'hrm.sah_tbl_kursus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO'], 'required'],
            [['tarikhLulusPtm', 'tarikhMesyuarat', 'tarikhLulusPnp', 'tarikhKelulusanPnp', 'tarikhLulusPembentangan', 'tarikhKelulusanPenyelidikan'], 'safe'],
            [['ICNO'], 'string', 'max' => 15],
            [['tempatPtm', 'statusPtm', 'bilMesyuarat', 'tempatPnp', 'keputusan', 'statusPnp', 'tajukPembentangan', 'tempatPembentangan', 'statusPenyelidikan'], 'string', 'max' => 122],
            [['ICNO'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'tarikhLulusPtm' => 'Tarikh Lulus Ptm',
            'tempatPtm' => 'Tempat Ptm',
            'statusPtm' => 'Status Ptm',
            'tarikhMesyuarat' => 'Tarikh Mesyuarat',
            'bilMesyuarat' => 'Bil Mesyuarat',
            'tarikhLulusPnp' => 'Tarikh Lulus Pnp',
            'tempatPnp' => 'Tempat Pnp',
            'keputusan' => 'Keputusan',
            'statusPnp' => 'Status Pnp',
            'tarikhKelulusanPnp' => 'Tarikh Kelulusan Pnp',
            'tarikhLulusPembentangan' => 'Tarikh Lulus Pembentangan',
            'tajukPembentangan' => 'Tajuk Pembentangan',
            'tempatPembentangan' => 'Tempat Pembentangan',
            'statusPenyelidikan' => 'Status Penyelidikan',
            'tarikhKelulusanPenyelidikan' => 'Tarikh Kelulusan Penyelidikan',
        ];
    }
}
