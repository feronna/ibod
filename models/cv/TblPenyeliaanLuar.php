<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "{{%dbo.Pasca_vwSenaraiPenyeliaanLuar}}".
 *
 * @property int $AutoID
 * @property string $SMP28_KP
 * @property string $Nomatrik
 * @property string $NamaPelajar
 * @property string $Peringkat
 * @property string $NamaInstitut
 * @property int $TahunKonvokesyen
 * @property string $TahapPenyeliaan
 * @property string $SuratURL
 * @property string $AdminNokp
 * @property string $AdminRemark
 * @property int $IsAccepted
 * @property string $DateSubmitted
 * @property string $DateReviewed
 * @property string $LastUpdate
 * @property int $IsGraduated
 */
class TblPenyeliaanLuar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%dbo.Pasca_vwSenaraiPenyeliaanLuar}}';
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
            [['AutoID'], 'required'],
            [['AutoID', 'TahunKonvokesyen', 'IsAccepted', 'IsGraduated'], 'integer'],
            [['NamaInstitut', 'SuratURL', 'AdminRemark'], 'string'],
            [['DateSubmitted', 'DateReviewed', 'LastUpdate'], 'safe'],
            [['SMP28_KP', 'AdminNokp'], 'string', 'max' => 20],
            [['Nomatrik'], 'string', 'max' => 15],
            [['NamaPelajar'], 'string', 'max' => 200],
            [['Peringkat'], 'string', 'max' => 10],
            [['TahapPenyeliaan'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'AutoID' => 'Auto ID',
            'SMP28_KP' => 'Smp28 Kp',
            'Nomatrik' => 'Nomatrik',
            'NamaPelajar' => 'Nama Pelajar',
            'Peringkat' => 'Peringkat',
            'NamaInstitut' => 'Nama Institut',
            'TahunKonvokesyen' => 'Tahun Konvokesyen',
            'TahapPenyeliaan' => 'Tahap Penyeliaan',
            'SuratURL' => 'Surat Url',
            'AdminNokp' => 'Admin Nokp',
            'AdminRemark' => 'Admin Remark',
            'IsAccepted' => 'Is Accepted',
            'DateSubmitted' => 'Date Submitted',
            'DateReviewed' => 'Date Reviewed',
            'LastUpdate' => 'Last Update',
            'IsGraduated' => 'Is Graduated',
        ];
    }
}
