<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "dbo.Ext_HR_vwPeribadiPelajar".
 *
 * @property string $SMP01_Nomatrik
 * @property string $SMP01_KP
 * @property string $SMP01_Nama
 * @property string $SMP01_Alamat1
 * @property string $SMP01_Alamat2
 * @property string $SMP01_Alamat3
 * @property string $SMP01_Poskod
 * @property string $SMP01_Bandar
 * @property string $SMP01_Negeri
 * @property string $NegeriBM
 * @property string $NegaraBM
 * @property string $SMP01_AlamatS1
 * @property string $SMP01_AlamatS2
 * @property string $SMP01_AlamatS3
 * @property string $SMP01_PoskodS
 * @property string $SMP01_BandarS
 * @property string $NegeriSuratMenyurat
 * @property string $NegaraSuratMenyurat
 * @property string $SMP01_NoTelBimBit
 * @property string $SMP01_EmelRasmi
 * @property string $SMP01_Emel
 * @property string $SMP01_Fakulti
 * @property string $StatusPengajian
 */
class RefPeribadiPelajar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.Ext_HR_vwPeribadiPelajar';
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
            [['SMP01_Nomatrik', 'SMP01_KP'], 'required'],
            [['SMP01_Nomatrik', 'SMP01_KP'], 'string', 'max' => 15],
            [['SMP01_Nama', 'SMP01_Alamat1', 'SMP01_Alamat2', 'SMP01_Alamat3', 'SMP01_AlamatS1', 'SMP01_AlamatS2', 'SMP01_AlamatS3'], 'string', 'max' => 250],
            [['SMP01_Poskod', 'SMP01_PoskodS'], 'string', 'max' => 10],
            [['SMP01_Bandar', 'NegaraBM', 'SMP01_BandarS', 'NegaraSuratMenyurat', 'SMP01_NoTelBimBit', 'SMP01_EmelRasmi', 'StatusPengajian'], 'string', 'max' => 50],
            [['SMP01_Negeri'], 'string', 'max' => 2],
            [['NegeriBM', 'NegeriSuratMenyurat'], 'string', 'max' => 30],
            [['SMP01_Emel'], 'string', 'max' => 100],
            [['SMP01_Fakulti'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SMP01_Nomatrik' => 'Smp 01 Nomatrik',
            'SMP01_KP' => 'Smp 01 Kp',
            'SMP01_Nama' => 'Smp 01 Nama',
            'SMP01_Alamat1' => 'Smp 01 Alamat 1',
            'SMP01_Alamat2' => 'Smp 01 Alamat 2',
            'SMP01_Alamat3' => 'Smp 01 Alamat 3',
            'SMP01_Poskod' => 'Smp 01 Poskod',
            'SMP01_Bandar' => 'Smp 01 Bandar',
            'SMP01_Negeri' => 'Smp 01 Negeri',
            'NegeriBM' => 'Negeri Bm',
            'NegaraBM' => 'Negara Bm',
            'SMP01_AlamatS1' => 'Smp 01 Alamat S 1',
            'SMP01_AlamatS2' => 'Smp 01 Alamat S 2',
            'SMP01_AlamatS3' => 'Smp 01 Alamat S 3',
            'SMP01_PoskodS' => 'Smp 01 Poskod S',
            'SMP01_BandarS' => 'Smp 01 Bandar S',
            'NegeriSuratMenyurat' => 'Negeri Surat Menyurat',
            'NegaraSuratMenyurat' => 'Negara Surat Menyurat',
            'SMP01_NoTelBimBit' => 'Smp 01 No Tel Bim Bit',
            'SMP01_EmelRasmi' => 'Smp 01 Emel Rasmi',
            'SMP01_Emel' => 'Smp 01 Emel',
            'SMP01_Fakulti' => 'Smp 01 Fakulti',
            'StatusPengajian' => 'Status Pengajian',
        ];
    }
}
