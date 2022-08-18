<?php

namespace app\models\elnpt\perkhidmatan_klinikal;

use Yii;

/**
 * This is the model class for table "dbo.vw_ConsultationClinical".
 *
 * @property string $ICKakitangan
 * @property string $NomborKakitangan
 * @property string $NamaKakitangan
 * @property string $Rawatan
 * @property string $TarikhMula
 * @property string $TarikhAkhir
 * @property string $Status
 * @property string $Type
 * @property string $JenisRawatan
 * @property string $ApproveStatus
 * @property string $Keterangan_StatusPenyelidikan
 * @property string $JamMula
 * @property string $JamTamat
 */
class TblConsultationClinical extends \yii\db\ActiveRecord
{
    public $kategori;
    public $cnt;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_ConsultationClinical';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db6');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICKakitangan', 'Rawatan'], 'required'],
            [['TarikhMula', 'TarikhAkhir', 'kategori', 'cnt'], 'safe'],
            [['ICKakitangan', 'NomborKakitangan', 'Keterangan_StatusPenyelidikan'], 'string', 'max' => 50],
            [['NamaKakitangan'], 'string', 'max' => 1000],
            [['Rawatan', 'Status'], 'string', 'max' => 500],
            [['Type', 'ApproveStatus'], 'string', 'max' => 1],
            [['JenisRawatan'], 'string', 'max' => 100],
            [['JamMula', 'JamTamat'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICKakitangan' => 'Ic Kakitangan',
            'NomborKakitangan' => 'Nombor Kakitangan',
            'NamaKakitangan' => 'Nama Kakitangan',
            'Rawatan' => 'Rawatan',
            'TarikhMula' => 'Tarikh Mula',
            'TarikhAkhir' => 'Tarikh Akhir',
            'Status' => 'Status',
            'Type' => 'Type',
            'JenisRawatan' => 'Jenis Rawatan',
            'ApproveStatus' => 'Approve Status',
            'Keterangan_StatusPenyelidikan' => 'Keterangan Status Penyelidikan',
            'JamMula' => 'Jam Mula',
            'JamTamat' => 'Jam Tamat',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->kategori = "Clinical Consultation (Clinic / Ward Round / Procedure)";

        //$this->cnt = ''

    }

    public function getBiodata()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['COOldID' => 'NomborKakitangan']);
    }
}
