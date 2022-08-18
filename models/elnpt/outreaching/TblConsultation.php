<?php

namespace app\models\elnpt\outreaching;

use Yii;

/**
 * This is the model class for table "dbo.Ext_PPI04_Perundingan".
 *
 * @property string $ConsultationType
 * @property string $NoStaf
 * @property string $Tajuk
 * @property string $Peranan
 * @property string $Keahlian
 * @property string $TarikhMula
 * @property string $TarikhAkhit
 * @property string $Status
 * @property string $Organisasi
 * @property string $Jumlah
 * @property string $TarikhSah
 * @property int $PerundingBersama
 * @property string $NamaStaf
 * @property string $Type
 * @property string $StatusPengesahan
 */
class TblConsultation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.Ext_PPI04_Perundingan';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db10');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Tajuk', 'Peranan', 'Organisasi', 'Jumlah'], 'required'],
            [['TarikhMula', 'TarikhAkhit', 'TarikhSah'], 'safe'],
            [['Jumlah'], 'number'],
            [['PerundingBersama'], 'integer'],
            [['ConsultationType'], 'string', 'max' => 20],
            [['NoStaf', 'Status'], 'string', 'max' => 50],
            [['Tajuk', 'Peranan', 'Organisasi'], 'string', 'max' => 500],
            [['Keahlian'], 'string', 'max' => 40],
            [['NamaStaf'], 'string', 'max' => 1000],
            [['Type', 'StatusPengesahan'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ConsultationType' => 'Consultation Type',
            'NoStaf' => 'No Staf',
            'Tajuk' => 'Tajuk',
            'Peranan' => 'Peranan',
            'Keahlian' => 'Keahlian',
            'TarikhMula' => 'Tarikh Mula',
            'TarikhAkhit' => 'Tarikh Akhit',
            'Status' => 'Status',
            'Organisasi' => 'Organisasi',
            'Jumlah' => 'Jumlah',
            'TarikhSah' => 'Tarikh Sah',
            'PerundingBersama' => 'Perunding Bersama',
            'NamaStaf' => 'Nama Staf',
            'Type' => 'Type',
            'StatusPengesahan' => 'Status Pengesahan',
        ];
    }
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['COOldID' => 'NoStaf']);
    }
}
