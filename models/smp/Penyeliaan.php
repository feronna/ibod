<?php

namespace app\models\smp;

use Yii;

/**
 * This is the model class for table "dbo.Ext_HR02_Penyeliaan".
 *
 * @property string $Nomatrik
 * @property string $NamaPelajar
 * @property int $IsPLUMS
 * @property string $KodFakulti
 * @property string $KodProgram
 * @property string $KodSesi_Sem
 * @property string $KodStatusPengajian
 * @property string $StatusPengajianBM
 * @property string $StatusPengajianBI
 * @property string $NoKpPenyelia
 * @property string $SMP28_NoStaf
 * @property int $KodTahapPenyeliaan
 * @property string $TahapPenyeliaanBI
 * @property string $TahapPenyeliaanBM
 * @property string $SMP20_Gelaran
 * @property string $SMP20_Nama
 * @property string $SMP20_KodJabatan
 * @property int $SMP28_Active
 */
class Penyeliaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.Ext_HR02_Penyeliaan';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db5');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IsPLUMS', 'KodTahapPenyeliaan', 'SMP28_Active'], 'integer'],
            [['Nomatrik', 'NoKpPenyelia', 'SMP28_NoStaf'], 'string', 'max' => 20],
            [['NamaPelajar', 'SMP20_Nama'], 'string', 'max' => 250],
            [['KodFakulti'], 'string', 'max' => 4],
            [['KodProgram'], 'string', 'max' => 5],
            [['KodSesi_Sem'], 'string', 'max' => 11],
            [['KodStatusPengajian'], 'string', 'max' => 2],
            [['StatusPengajianBM', 'StatusPengajianBI', 'TahapPenyeliaanBI', 'TahapPenyeliaanBM', 'SMP20_Gelaran', 'SMP20_KodJabatan'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Nomatrik' => 'Nomatrik',
            'NamaPelajar' => 'Nama Pelajar',
            'IsPLUMS' => 'Is Plums',
            'KodFakulti' => 'Kod Fakulti',
            'KodProgram' => 'Kod Program',
            'KodSesi_Sem' => 'Kod Sesi Sem',
            'KodStatusPengajian' => 'Kod Status Pengajian',
            'StatusPengajianBM' => 'Status Pengajian Bm',
            'StatusPengajianBI' => 'Status Pengajian Bi',
            'NoKpPenyelia' => 'No Kp Penyelia',
            'SMP28_NoStaf' => 'Smp28 No Staf',
            'KodTahapPenyeliaan' => 'Kod Tahap Penyeliaan',
            'TahapPenyeliaanBI' => 'Tahap Penyeliaan Bi',
            'TahapPenyeliaanBM' => 'Tahap Penyeliaan Bm',
            'SMP20_Gelaran' => 'Smp20 Gelaran',
            'SMP20_Nama' => 'Smp20 Nama',
            'SMP20_KodJabatan' => 'Smp20 Kod Jabatan',
            'SMP28_Active' => 'Smp28 Active',
        ];
    }
}
