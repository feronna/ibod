<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "{{%dbo.Smp_vwSenaraiPenyeliaanModCampuran}}".
 *
 * @property string $SMP01_Nomatrik
 * @property string $SMP01_Nama
 * @property string $SMP01_Fakulti
 * @property string $SMP01_Kursus
 * @property string $KodSesi_Sem
 * @property string $KodStatus
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
 * @property string $DataSource
 * @property string $DateAdded
 */
class TblPenyeliaanModCampuran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%dbo.Smp_vwSenaraiPenyeliaanModCampuran}}';
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
            [['KodSesi_Sem', 'DataSource'], 'required'],
            [['SMP_LevelID', 'SMP28_Active'], 'integer'],
            [['DateAdded'], 'safe'],
            [['SMP01_Nomatrik', 'KodStatus', 'SMP28_KP', 'SMP28_NoStaf'], 'string', 'max' => 20],
            [['SMP01_Nama', 'SMP20_Nama'], 'string', 'max' => 250],
            [['SMP01_Fakulti'], 'string', 'max' => 5],
            [['SMP01_Kursus'], 'string', 'max' => 12],
            [['KodSesi_Sem'], 'string', 'max' => 1],
            [['StatusBM', 'StatusBI', 'NamaBI', 'NamaBM', 'SMP20_Gelaran', 'SMP20_KodJabatan'], 'string', 'max' => 50],
            [['KodSetupSemester', 'SMP01_KategoriPelajar'], 'string', 'max' => 3],
            [['ModLevelName'], 'string', 'max' => 10],
            [['DataSource'], 'string', 'max' => 7],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SMP01_Nomatrik' => 'Smp01 Nomatrik',
            'SMP01_Nama' => 'Smp01 Nama',
            'SMP01_Fakulti' => 'Smp01 Fakulti',
            'SMP01_Kursus' => 'Smp01 Kursus',
            'KodSesi_Sem' => 'Kod Sesi Sem',
            'KodStatus' => 'Kod Status',
            'StatusBM' => 'Status Bm',
            'StatusBI' => 'Status Bi',
            'KodSetupSemester' => 'Kod Setup Semester',
            'SMP01_KategoriPelajar' => 'Smp01 Kategori Pelajar',
            'SMP28_KP' => 'Smp28 Kp',
            'SMP28_NoStaf' => 'Smp28 No Staf',
            'SMP_LevelID' => 'Smp Level ID',
            'NamaBI' => 'Nama Bi',
            'NamaBM' => 'Nama Bm',
            'SMP20_Gelaran' => 'Smp20 Gelaran',
            'SMP20_Nama' => 'Smp20 Nama',
            'SMP20_KodJabatan' => 'Smp20 Kod Jabatan',
            'SMP28_Active' => 'Smp28 Active',
            'ModLevelName' => 'Mod Level Name',
            'DataSource' => 'Data Source',
            'DateAdded' => 'Date Added',
        ];
    }
}
