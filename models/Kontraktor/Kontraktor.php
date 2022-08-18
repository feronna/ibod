<?php

namespace app\models\Kontraktor;
use app\models\hronline\Agama;
use app\models\hronline\Bangsa;
use app\models\hronline\Etnik;
use app\models\hronline\Jenisdarah;
use app\models\hronline\Jantina;
use app\models\hronline\TarafPerkahwinan;
use app\models\hronline\Negara;
use app\models\hronline\StatusWarganegara;
use app\models\hronline\Negeri;
use app\models\hronline\Bandar;

use Yii;

/**
 * This is the model class for table "keselamatan.utils_pekerja_kontraktor".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $CONm
 * @property string $id_kontraktor
 * @property string $ReligionCd
 * @property string $RaceCd
 * @property string $Addr1
 * @property string $Addr2
 * @property string $Addr3
 * @property string $Postcode
 * @property string $CityCd
 * @property string $StateCd
 * @property string $EthnicCd
 * @property string $BloodTypeCd
 * @property string $MrtlStatusCd
 * @property string $TitleCd
 * @property string $GenderCd
 * @property string $COBirthPlaceCd
 * @property string $COBirthCountryCd
 * @property string $NegaraAsalCd
 * @property string $NegeriAsalCd
 * @property string $NegeriAsalIbu
 * @property string $NegeriAsalBapa
 * @property string $NatCd
 * @property string $NatStatusCd
 * @property string $COEmail
 * @property string $COBirthCertNo
 * @property string $COBirthDt
 * @property string $COHPhoneNo
 * @property string $COOffTelNo
 * @property string $last_update
 * @property string $last_updater
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 * @property string $kemaskini_terakhir Tarikh Terakhir Kemaskini Data
 * @property string $ref_apsu_suppid
 * @property string $no_permit
 * @property string $mySejahteraId id dalam applikasi MySejahtera
 * @property int $Status
 * @property string $filename_vaksin_pm
 * @property string $filename_sijil_pm
 * @property string $filename_kad_cidb
 */
class Kontraktor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $kt_vaksin_pm;
    public $kt_sijil_pm;
    public $kt_kad_cidb;
    
    public static function tableName()
    {
        return 'keselamatan.utils_pekerja_kontraktor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO'], 'required', 'message' => 'Ruang ini adalah mandatori.'],
            [['COBirthDt', 'last_update', 'created_at', 'updated_at', 'kemaskini_terakhir'], 'safe'],
            [['Status'], 'integer'],
            [['ICNO', 'last_updater', 'created_by', 'updated_by', 'no_permit'], 'string', 'max' => 12],
            [['CONm'], 'string', 'max' => 255],
            [['id_kontraktor'], 'string', 'max' => 11],
            [['ReligionCd', 'RaceCd', 'COBirthPlaceCd', 'NegeriAsalCd'], 'string', 'max' => 2],
            [['Addr1', 'Addr2', 'Addr3'], 'string', 'max' => 80],
            [['Postcode', 'COHPhoneNo', 'COOffTelNo'], 'string', 'max' => 14],
            [['CityCd', 'StateCd', 'CountryCd'], 'string', 'max' => 6],
            [['EthnicCd', 'TitleCd'], 'string', 'max' => 4],
            [['BloodTypeCd', 'COBirthCountryCd', 'NegaraAsalCd', 'NegeriAsalIbu', 'NegeriAsalBapa', 'NatCd'], 'string', 'max' => 3],
            [['MrtlStatusCd', 'GenderCd', 'NatStatusCd'], 'string', 'max' => 1],
            [['COEmail', 'filename_vaksin_pm', 'filename_sijil_pm', 'filename_kad_cidb'], 'string', 'max' => 100],
            [['COBirthCertNo', 'KOOlID'], 'string', 'max' => 15],
            [['mySejahteraId'], 'string', 'max' => 50],
            [['ICNO'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'CONm' => 'Co Nm',
            'id_kontraktor' => 'Id Kontraktor',
            'ReligionCd' => 'Religion Cd',
            'RaceCd' => 'Race Cd',
            'Addr1' => 'Addr 1',
            'Addr2' => 'Addr 2',
            'Addr3' => 'Addr 3',
            'Postcode' => 'Postcode',
            'CityCd' => 'City Cd',
            'StateCd' => 'State Cd',
            'CountryCd' => 'Country Cd',
            'EthnicCd' => 'Ethnic Cd',
            'BloodTypeCd' => 'Blood Type Cd',
            'MrtlStatusCd' => 'Mrtl Status Cd',
            'TitleCd' => 'Title Cd',
            'GenderCd' => 'Gender Cd',
            'COBirthPlaceCd' => 'Co Birth Place Cd',
            'COBirthCountryCd' => 'Co Birth Country Cd',
            'NegaraAsalCd' => 'Negara Asal Cd',
            'NegeriAsalCd' => 'Negeri Asal Cd',
            'NegeriAsalIbu' => 'Negeri Asal Ibu',
            'NegeriAsalBapa' => 'Negeri Asal Bapa',
            'NatCd' => 'Nat Cd',
            'NatStatusCd' => 'Nat Status Cd',
            'COEmail' => 'Co Email',
            'COBirthCertNo' => 'Co Birth Cert No',
            'COBirthDt' => 'Co Birth Dt',
            'COHPhoneNo' => 'Coh Phone No',
            'COOffTelNo' => 'Co Off Tel No',
            'last_update' => 'Last Update',
            'last_updater' => 'Last Updater',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'kemaskini_terakhir' => 'Kemaskini Terakhir',
            'KOOlID' => 'KOOlID',
            'no_permit' => 'No Permit',
            'mySejahteraId' => 'My Sejahtera ID',
            'Status' => 'Status',
            'filename_vaksin_pm' => 'Filename Vaksin Pm',
            'filename_sijil_pm' => 'Filename Sijil Pm',
            'filename_kad_cidb' => 'Filename Kad Cidb',
        ];
    }
    
    public function getDisplayAgama() {
        return $this->hasOne(Agama::className(), ['ReligionCd' => 'ReligionCd']);
    } 
    
     public function getBangsa() {
        return $this->hasOne(Bangsa::className(), ['RaceCd' => 'RaceCd']);
    }

    public function getEtnik() {
        return $this->hasOne(Etnik::className(), ['EthnicCd' => 'EthnicCd']);
    }
     
     public function getJenisDarah() {
        return $this->hasOne(Jenisdarah::className(), ['BloodTypeCd' => 'BloodTypeCd']);
    }
     public function getDisplayJenisDarah() {
        $model = Jenisdarah::find()->where(['BloodTypeCd' => $this->BloodTypeCd])->one();

        return $model->BloodType;
    }

     public function getJantina() {
        return $this->hasOne(Jantina::className(), ['GenderCd' => 'GenderCd']);
    }
    
    public function getDisplayTarafPerkahwinan() {
        return $this->hasOne(TarafPerkahwinan::className(), ['MrtlStatusCd' => 'MrtlStatusCd']);
    }

    public function getDisplayNegaraLahir() { 
        return $this->hasOne(Negara::className(), ['CountryCd' => 'COBirthCountryCd']);
    }
    
    public function getWarganegara() { 
        return $this->hasOne(Negara::className(), ['CountryCd' => 'CountryCd']);
    }

     public function getStatusWarganegara() { 
        return $this->hasOne(StatusWarganegara::className(), ['NatStatusCd' => 'NatStatusCd']);
    }

     public function getNegeriAsal() {
        return $this->hasOne(Negeri::className(), ['StateCd' => 'StateCd']);
    }
    
     public function getDisplayBandar() {
        return $this->hasOne(Bandar::className(), ['CityCd' => 'CityCd']);
    }
    
    public function getAktifSenaraiHitam() {
        return $this->hasOne(\app\models\esticker\TblRekodKontraktor::className(), ['ICNO' => 'ICNO'])->where(['flag' => 2]);
    }
    
    public function getAktifDaftarMasuk() {
        return $this->hasOne(\app\models\esticker\TblRekodKontraktor::className(), ['ICNO' => 'ICNO'])->where(['flag' => 1]);
    }  
    
    public function getAktifDaftarKeluar() {
        return $this->hasOne(\app\models\esticker\TblRekodKontraktor::className(), ['ICNO' => 'ICNO'])->where(['flag' => 0]);
    }  
    
    public function getLogMasukTerakhir() {
        return $this->hasOne(\app\models\esticker\TblRekodKontraktor::className(), ['ICNO' => 'ICNO'])->orderBy(['check_in' => SORT_DESC]);
    }
 
}
