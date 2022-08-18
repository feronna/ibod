<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tblprcobiodata".
 *
 * @property string $ICNO
 * @property string $ReligionCd
 * @property string $RaceCd
 * @property string $EthnicCd
 * @property string $ArmyPoliceCd
 * @property string $BloodTypeCd
 * @property string $MrtlStatusCd
 * @property string $TitleCd
 * @property int $HighestEduLevelCd
 * @property string $ConfermentDt
 * @property string $GenderCd
 * @property string $COBirthPlaceCd
 * @property string $COBirthCountryCd
 * @property string $NegaraAsalCd
 * @property string $NegeriAsalCd
 * @property string $NegeriAsalIbu
 * @property string $NegeriAsalBapa
 * @property string $NatCd
 * @property string $NatStatusCd
 * @property string $CONm
 * @property string $COEmail
 * @property string $COEmail2
 * @property int $COBumiStatus
 * @property string $COOldID
 * @property string $COBirthCertNo
 * @property string $COBirthDt
 * @property string $COHPhoneNo
 * @property string $COHPhoneNo2
 * @property string $COOffTelNo
 * @property string $COOffTelNoExtn
 * @property string $COOffTelNoExtn2
 * @property string $COOUCTelNo unified communication number (10 + 4 last digits staff id)
 * @property string $COOPass
 * @property string $COHPhoneStatus
 * @property int $COOIsNew
 * @property int $accessLevel
 * @property int $accessSecondLevel
 * @property int $DeptId
 * @property int $campus_id
 * @property int $statLantikan
 * @property string $startDateLantik
 * @property string $endDateLantik
 * @property int $Status
 * @property string $startDateStatus
 * @property int $noWaran
 * @property int $gredJawatan
 * @property int $statSandangan
 * @property string $startDateSandangan
 * @property string $endDateSandangan
 * @property string $gredJawatan_2 Jawatan Hakiki
 * @property int $statSandangan_2
 * @property string $startDateSandangan_2
 * @property string $endDateSandangan_2
 * @property int $ApmtTypeCd
 * @property string $jawatanTadbir
 * @property string $last_update
 * @property string $last_updater
 * @property string $last_login
 * @property string $pp
 * @property string $bos
 * @property int $DeptId_hakiki JFPIU Hakiki
 * @property int $campus_id_hakiki Kampus Hakiki
 * @property string $program_ums
 * @property int $KodProgram Refer programpengajaran
 * @property string $kemaskini_terakhir Tarikh Terakhir Kemaskini Data
 * @property int $sah_keluarga
 * @property int $sah_alamat
 * @property int $sah_notel
 * @property int $sah_statuskahwin
 * @property int $sah_emel
 * @property int $sah_akademik
 * @property int $sah_agama
 * @property int $sah_passport
 * @property string $tarikh_sah
 * @property int $showposition 1=Show Jawatan Direktori,0=Hide Jawatan
 */
class TblprcobiodataTemp extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tblprcobiodata';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO'], 'required'],
            [['HighestEduLevelCd', 'COBumiStatus', 'COOIsNew', 'accessLevel', 'accessSecondLevel', 'DeptId', 'campus_id', 'statLantikan', 'Status', 'noWaran', 'gredJawatan', 'statSandangan', 'statSandangan_2', 'ApmtTypeCd', 'DeptId_hakiki', 'campus_id_hakiki', 'KodProgram', 'sah_keluarga', 'sah_alamat', 'sah_notel', 'sah_statuskahwin', 'sah_emel', 'sah_akademik', 'sah_agama', 'sah_passport', 'showposition'], 'integer'],
            [['ConfermentDt', 'COBirthDt', 'startDateLantik', 'endDateLantik', 'startDateStatus', 'startDateSandangan', 'endDateSandangan', 'startDateSandangan_2', 'endDateSandangan_2', 'last_update', 'last_login', 'kemaskini_terakhir', 'tarikh_sah'], 'safe'],
            [['ICNO', 'last_updater', 'pp', 'bos'], 'string', 'max' => 12],
            [['ReligionCd', 'RaceCd', 'COBirthPlaceCd', 'NegaraAsalCd', 'COHPhoneStatus'], 'string', 'max' => 2],
            [['EthnicCd', 'TitleCd'], 'string', 'max' => 4],
            [['ArmyPoliceCd', 'BloodTypeCd', 'COBirthCountryCd', 'NegeriAsalCd', 'NegeriAsalIbu', 'NegeriAsalBapa', 'NatCd'], 'string', 'max' => 3],
            [['MrtlStatusCd', 'GenderCd', 'NatStatusCd'], 'string', 'max' => 1],
            [['CONm', 'program_ums'], 'string', 'max' => 255],
            [['COEmail', 'COEmail2'], 'string', 'max' => 100],
            [['COOldID', 'COBirthCertNo'], 'string', 'max' => 15],
            [['COHPhoneNo', 'COHPhoneNo2', 'COOffTelNo'], 'string', 'max' => 14],
            [['COOffTelNoExtn', 'COOffTelNoExtn2', 'COOUCTelNo'], 'string', 'max' => 6],
            [['COOPass'], 'string', 'max' => 40],
            [['gredJawatan_2', 'jawatanTadbir'], 'string', 'max' => 10],
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
            'ReligionCd' => 'Religion Cd',
            'RaceCd' => 'Race Cd',
            'EthnicCd' => 'Ethnic Cd',
            'ArmyPoliceCd' => 'Army Police Cd',
            'BloodTypeCd' => 'Blood Type Cd',
            'MrtlStatusCd' => 'Mrtl Status Cd',
            'TitleCd' => 'Title Cd',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
            'ConfermentDt' => 'Conferment Dt',
            'GenderCd' => 'Gender Cd',
            'COBirthPlaceCd' => 'Co Birth Place Cd',
            'COBirthCountryCd' => 'Co Birth Country Cd',
            'NegaraAsalCd' => 'Negara Asal Cd',
            'NegeriAsalCd' => 'Negeri Asal Cd',
            'NegeriAsalIbu' => 'Negeri Asal Ibu',
            'NegeriAsalBapa' => 'Negeri Asal Bapa',
            'NatCd' => 'Nat Cd',
            'NatStatusCd' => 'Nat Status Cd',
            'CONm' => 'Co Nm',
            'COEmail' => 'Co Email',
            'COEmail2' => 'Co Email2',
            'COBumiStatus' => 'Co Bumi Status',
            'COOldID' => 'Co Old ID',
            'COBirthCertNo' => 'Co Birth Cert No',
            'COBirthDt' => 'Co Birth Dt',
            'COHPhoneNo' => 'Coh Phone No',
            'COHPhoneNo2' => 'Coh Phone No2',
            'COOffTelNo' => 'Co Off Tel No',
            'COOffTelNoExtn' => 'Co Off Tel No Extn',
            'COOffTelNoExtn2' => 'Co Off Tel No Extn2',
            'COOUCTelNo' => 'Coouc Tel No',
            'COOPass' => 'Coo Pass',
            'COHPhoneStatus' => 'Coh Phone Status',
            'COOIsNew' => 'Coo Is New',
            'accessLevel' => 'Access Level',
            'accessSecondLevel' => 'Access Second Level',
            'DeptId' => 'Dept ID',
            'campus_id' => 'Campus ID',
            'statLantikan' => 'Stat Lantikan',
            'startDateLantik' => 'Start Date Lantik',
            'endDateLantik' => 'End Date Lantik',
            'Status' => 'Status',
            'startDateStatus' => 'Start Date Status',
            'noWaran' => 'No Waran',
            'gredJawatan' => 'Gred Jawatan',
            'statSandangan' => 'Stat Sandangan',
            'startDateSandangan' => 'Start Date Sandangan',
            'endDateSandangan' => 'End Date Sandangan',
            'gredJawatan_2' => 'Gred Jawatan 2',
            'statSandangan_2' => 'Stat Sandangan 2',
            'startDateSandangan_2' => 'Start Date Sandangan 2',
            'endDateSandangan_2' => 'End Date Sandangan 2',
            'ApmtTypeCd' => 'Apmt Type Cd',
            'jawatanTadbir' => 'Jawatan Tadbir',
            'last_update' => 'Last Update',
            'last_updater' => 'Last Updater',
            'last_login' => 'Last Login',
            'pp' => 'Pp',
            'bos' => 'Bos',
            'DeptId_hakiki' => 'Dept Id Hakiki',
            'campus_id_hakiki' => 'Campus Id Hakiki',
            'program_ums' => 'Program Ums',
            'KodProgram' => 'Kod Program',
            'kemaskini_terakhir' => 'Kemaskini Terakhir',
            'sah_keluarga' => 'Sah Keluarga',
            'sah_alamat' => 'Sah Alamat',
            'sah_notel' => 'Sah Notel',
            'sah_statuskahwin' => 'Sah Statuskahwin',
            'sah_emel' => 'Sah Emel',
            'sah_akademik' => 'Sah Akademik',
            'sah_agama' => 'Sah Agama',
            'sah_passport' => 'Sah Passport',
            'tarikh_sah' => 'Tarikh Sah',
            'showposition' => 'Showposition',
        ];
    }
    
    public function getDepartment() {
        return $this->hasOne(\app\models\ejobs\Department::className(), ['id' => 'DeptId']);
    }
}
