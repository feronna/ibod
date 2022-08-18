<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "dbo.Smp_vwSenaraiPenyeliaanPascaTermasukGraduat".
 *
 * @property string $SMP01_Nomatrik
 * @property string $SMP01_Nama
 * @property string $SMP01_Fakulti
 * @property string $SMP01_Kursus
 * @property string $SMP01_SesiDaftar
 * @property string $SMP01_Status
 * @property string $StatusBM
 * @property string $StatusBI
 * @property string $KodSetupSemester
 * @property string $SMP01_KategoriPelajar
 * @property string $SMP28_KP
 * @property string $SMP28_NoStaf
 * @property int $SMP_LevelID
 * @property string $NamaBI
 * @property string $NamaBM
 * @property string $SMP20_Gelaran
 * @property string $SMP20_Nama
 * @property string $SMP20_KodJabatan
 * @property int $SMP28_Active
 * @property string $ModLevelName
 * @property int $TahunKonvokesyen
 * @property string $MethodStudyName
 * @property string $PASCA/PLUMS
 */
class TblPenyeliaanMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.Smp_vwSenaraiPenyeliaanPascaTermasukGraduat';
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
            [['SMP01_Nomatrik'], 'required'],
            [['SMP_LevelID', 'SMP28_Active', 'TahunKonvokesyen'], 'integer'],
            [['SMP01_Nomatrik', 'SMP01_Status', 'SMP28_KP', 'SMP28_NoStaf'], 'string', 'max' => 20],
            [['SMP01_Nama', 'SMP20_Nama'], 'string', 'max' => 250],
            [['SMP01_Fakulti', 'PASCA_PLUMS'], 'string', 'max' => 5],
            [['SMP01_Kursus'], 'string', 'max' => 12],
            [['SMP01_SesiDaftar'], 'string', 'max' => 11],
            [['StatusBM', 'StatusBI', 'NamaBI', 'NamaBM', 'SMP20_Gelaran', 'SMP20_KodJabatan', 'MethodStudyName'], 'string', 'max' => 50],
            [['KodSetupSemester', 'SMP01_KategoriPelajar'], 'string', 'max' => 3],
            [['ModLevelName'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SMP01_Nomatrik' => 'Smp 01 Nomatrik',
            'SMP01_Nama' => 'Smp 01 Nama',
            'SMP01_Fakulti' => 'Smp 01 Fakulti',
            'SMP01_Kursus' => 'Smp 01 Kursus',
            'SMP01_SesiDaftar' => 'Smp 01 Sesi Daftar',
            'SMP01_Status' => 'Smp 01 Status',
            'StatusBM' => 'Status Bm',
            'StatusBI' => 'Status Bi',
            'KodSetupSemester' => 'Kod Setup Semester',
            'SMP01_KategoriPelajar' => 'Smp 01 Kategori Pelajar',
            'SMP28_KP' => 'Smp 28 Kp',
            'SMP28_NoStaf' => 'Smp 28 No Staf',
            'SMP_LevelID' => 'Smp Level ID',
            'NamaBI' => 'Nama Bi',
            'NamaBM' => 'Nama Bm',
            'SMP20_Gelaran' => 'Smp 20 Gelaran',
            'SMP20_Nama' => 'Smp 20 Nama',
            'SMP20_KodJabatan' => 'Smp 20 Kod Jabatan',
            'SMP28_Active' => 'Smp 28 Active',
            'ModLevelName' => 'Mod Level Name',
            'TahunKonvokesyen' => 'Tahun Konvokesyen',
            'MethodStudyName' => 'Method Study Name', 
        ];
    }
}
