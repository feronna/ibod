<?php

namespace app\models\hronline;

use app\models\allocation\TblProfiles;
use Yii;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\esticker\TblAccess;
use app\models\hronline\GredJawatan;
use app\models\ptb\Application;
use app\models\ptb\Recommendation;
use app\models\hronline\Department;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\ServiceStatus;
use app\models\hronline\Kampus;
use app\models\hronline\StatusSandangan;
use app\models\hronline\Tblrscosandangan;
use app\models\hronline\TblPenempatan;
use app\models\hronline\Tblrscoconfirmstatus;
use app\models\hronline\StatusLantikan;
use app\models\hronline\Agama;
use app\models\hronline\Bangsa;
use app\models\hronline\Etnik;
use app\models\hronline\StatusUniform;
use app\models\hronline\Jenisdarah;
use app\models\hronline\TarafPerkahwinan;
use app\models\hronline\Gelaran;
use app\models\hronline\Jantina;
use app\models\hronline\Negeri;
use app\models\hronline\Negara;
use app\models\hronline\StatusWarganegara;
use app\models\hronline\AksesLevel;
use app\models\hronline\AksesLevelKedua;
use app\models\hronline\JawatanPentadbiran;
use app\models\hronline\JenisLantikan;
use app\models\hronline\ProgramPengajaran;
use app\models\hronline\Tblretireage;
use app\models\hronline\Tblvaksinasi;
use app\models\cuti\SetPegawai;
use app\models\ejobs\TblConference;
use app\models\cbelajar\TblPengajian;
use app\models\cbelajar\TblBiasiswa;
use app\models\cbelajar\TblFilePemohon;
use app\models\cbelajar\TblpImage;
use app\models\cuti\AksesPengguna;
use app\models\elnpt\penerbitan\DboVwCVAbstract;
use app\models\elnpt\penerbitan\DboVwCVAnthology;
use app\models\elnpt\penerbitan\DboVwCVBook;
use app\models\elnpt\penerbitan\DboVwCVBookChapter;
use app\models\elnpt\penerbitan\DboVwCVCreative;
use app\models\elnpt\penerbitan\DboVwCVJournalInternational;
use app\models\elnpt\penerbitan\DboVwCVJournalNational;
use app\models\elnpt\penerbitan\DboVwCVMagazine;
use app\models\elnpt\penerbitan\DboVwCVManual;
use app\models\elnpt\penerbitan\DboVwCVModule;
use app\models\elnpt\penerbitan\DboVwCVPreUni;
use app\models\elnpt\penerbitan\DboVwCVProceedingInternational;
use app\models\elnpt\penerbitan\DboVwCVProceedingNational;
use app\models\elnpt\penerbitan\DboVwCVTechnical;
use app\models\elnpt\penerbitan\DboVwCVTextbook;
use app\models\elnpt\penerbitan\DboVwCVTranslation;
use app\models\vhrms\ViewPayroll;
use app\models\lnpt\Markahkeseluruhan;
use yii\helpers\Html;
use app\models\lppums\TblStafAkses;
//audit trail
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;
use app\models\smp_ppi\Penyelidikan;
use app\models\smp_ppi\Perundingan;
use app\models\smp\Penyeliaan;
use app\models\hronline\Vcpdlatihan;
use app\models\hronline\Tblanugerah;
use app\models\elnpt\TblPenyelidikan;
use app\models\elnpt\TblPenyelidikan2;
use app\models\elnpt\TblConsultancy;
use app\models\elnpt\outreaching\TblConsultation;
use app\models\elnpt\perkhidmatan_klinikal\TblConsultationClinical;
use app\models\elnpt\TblMain;
use app\models\smp_ppi\Persidangan;
use app\models\smp\Pengajaran;
use app\models\elnpt\penerbitan\TblLnptPublicationV2;
use app\models\hronline\Tblrscoadminpost;
use app\models\cv\RefHindex;
use app\models\ejobs\TblpPermohonan;
use app\models\User;
use app\models\myidp\Kehadiran;
use app\models\myidp\RptStatistikIdpV2;
use app\models\cv\TblBlendedLearning;
use app\models\umsshield\SelfRisk;
use app\models\vhrms\StaffAccount;
use DateTime;
use DateInterval;
use app\models\keselamatan\TblAkses;
use app\models\keselamatan\TblStaffKeselamatan;
use Exception;
use app\models\hronline\TblPapSenaraiStaf;
use app\models\hronline\TblPapAkses;
use app\models\hronline\Tblstatusvaksinasi;
use app\models\hronline\Tblbsmwatchlist;
use app\models\harta\TblHarta;
use app\models\myportfolio\TblPortfolio;
use app\models\cbelajar\LkkDean;
use app\models\hronline\Tblprclinicalcert;

/**
 * This is the model class for table "hronline.tblprcobiodata".
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
 * @property string $COOffTelNo
 * @property string $COOffTelNoExtn
 * @property string $COOffTelNoExtn2
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
// class Tblprcobiodata extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {
class Tblprcobiodata extends \yii\db\ActiveRecord
{

    // add the function below:
    public static function getDb()
    {
        return Yii::$app->get('db2'); // second database
    }

    public $jenis_carian = '0';
    public $carian_data;
    public $carian_department;
    public $carian_pendidikantertinggi;
    public $carian_statuslantikan;
    public $carian_status;
    public $carian_jawatan;
    public $jenislantikan;
    public $carian_kategorijawatan;
    public $carian_programpengajaran;
    public $carian_kampus;
    public $carian_kodprogram;
    public $carian_gred;
    public $_action = null;
    public $_temp = null;
    public $status_pakar;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tblprcobiodata';
    }

    /**
     * @inheritdoc$primaryKey
     */
    public static function primaryKey()
    {
        return ["ICNO"];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'COOldID'], 'required', 'on' => 'test', 'message' => 'Ruang ini adalah mandatori'],
            [['ICNO', 'TitleCd', 'ConfermentDt', 'COBirthDt', 'startDateLantik', 'endDateLantik', 'CONm', 'ReligionCd', 'RaceCd', 'EthnicCd', 'BloodTypeCd', 'COBirthPlaceCd', 'GenderCd', 'MrtlStatusCd', 'COBirthCertNo', 'COBirthDt', 'COBirthCountryCd', 'NatCd', 'NatStatusCd', 'COBumiStatus', 'COEmail', 'COEmail2', 'COHPhoneNo', 'HighestEduLevelCd', 'ConfermentDt', 'ArmyPoliceCd', 'statLantikan', 'startDateLantik', 'endDateLantik', 'gredJawatan', 'statSandangan', 'ApmtTypeCd', 'DeptId', 'campus_id', 'NegeriAsalIbu', 'NegeriAsalBapa', 'NegaraAsalCd', 'NegeriAsalCd'], 'required', 'on' => 'baru', 'message' => 'Ruang ini adalah mandatori'],
            [['ICNO', 'TitleCd', 'CONm', 'ReligionCd', 'RaceCd', 'EthnicCd', 'BloodTypeCd', 'COBirthPlaceCd', 'GenderCd', 'MrtlStatusCd', 'COBirthCertNo', 'COBirthDt', 'COBirthCountryCd', 'NatCd', 'NatStatusCd', 'COBumiStatus', 'COEmail', 'COEmail2', 'COHPhoneNo', 'HighestEduLevelCd', 'ConfermentDt', 'ArmyPoliceCd', 'statLantikan', 'startDateLantik', 'endDateLantik', 'gredJawatan', 'statSandangan', 'ApmtTypeCd', 'DeptId', 'campus_id', 'NegeriAsalIbu', 'NegeriAsalBapa', 'NegaraAsalCd', 'NegeriAsalCd'], 'required', 'on' => 'phs', 'message' => 'Ruang ini adalah mandatori'],
            [['ICNO', 'TitleCd', 'CONm', 'ReligionCd', 'RaceCd', 'EthnicCd', 'BloodTypeCd', 'COBirthPlaceCd', 'GenderCd', 'MrtlStatusCd', 'COBirthCertNo', 'COBirthDt', 'COBirthCountryCd', 'NatCd', 'NatStatusCd', 'COBumiStatus', 'COEmail', 'COEmail2', 'COHPhoneNo', 'HighestEduLevelCd', 'ConfermentDt', 'ArmyPoliceCd', 'statLantikan', 'startDateLantik', 'endDateLantik', 'gredJawatan', 'statSandangan', 'ApmtTypeCd', 'DeptId', 'campus_id', 'NegeriAsalIbu', 'NegeriAsalBapa', 'NegaraAsalCd', 'NegeriAsalCd'], 'required', 'on' => 'khas', 'message' => 'Ruang ini adalah mandatori'],
            [['ICNO', 'TitleCd', 'CONm', 'ReligionCd', 'RaceCd', 'EthnicCd', 'BloodTypeCd', 'COBirthPlaceCd', 'GenderCd', 'MrtlStatusCd', 'COBirthCertNo', 'COBirthDt', 'COBirthCountryCd', 'NatCd', 'NatStatusCd', 'COBumiStatus', 'COEmail', 'COEmail2', 'COHPhoneNo', 'HighestEduLevelCd', 'ConfermentDt', 'ArmyPoliceCd', 'statLantikan', 'startDateLantik', 'endDateLantik', 'gredJawatan', 'statSandangan', 'ApmtTypeCd', 'DeptId', 'campus_id', 'NegeriAsalIbu', 'NegeriAsalBapa', 'NegaraAsalCd', 'NegeriAsalCd'], 'required', 'on' => 'pli', 'message' => 'Ruang ini adalah mandatori'],
            [['ICNO', 'TitleCd', 'CONm', 'ReligionCd', 'RaceCd', 'GenderCd', 'MrtlStatusCd', 'COBirthDt', 'COBirthCountryCd', 'COEmail', 'COHPhoneNo', 'HighestEduLevelCd', 'ConfermentDt', 'statLantikan', 'startDateLantik', 'endDateLantik', 'gredJawatan', 'statSandangan', 'ApmtTypeCd', 'DeptId', 'campus_id',], 'required', 'on' => 'sambilanakademik', 'message' => 'Ruang ini adalah mandatori'],
            [['ICNO', 'TitleCd', 'CONm', 'ReligionCd', 'RaceCd', 'EthnicCd', 'BloodTypeCd', 'GenderCd', 'MrtlStatusCd', 'COBirthCertNo', 'COBirthDt', 'COBirthCountryCd', 'NatCd', 'NatStatusCd', 'COBumiStatus', 'COEmail', 'COHPhoneNo', 'HighestEduLevelCd', 'ConfermentDt', 'ArmyPoliceCd', 'statLantikan', 'startDateLantik', 'gredJawatan', 'statSandangan', 'ApmtTypeCd', 'DeptId', 'campus_id', 'NegeriAsalIbu', 'NegeriAsalBapa', 'NegaraAsalCd', 'NegeriAsalCd'], 'required', 'on' => 'penerbitums', 'message' => 'Ruang ini adalah mandatori'],
            [['ICNO', 'TitleCd', 'CONm', 'ReligionCd', 'RaceCd', 'EthnicCd', 'BloodTypeCd', 'GenderCd', 'MrtlStatusCd', 'COBirthCertNo', 'COBirthDt', 'COBirthCountryCd', 'NatCd', 'NatStatusCd', 'COBumiStatus', 'COEmail', 'COHPhoneNo', 'ArmyPoliceCd', 'statLantikan', 'startDateLantik', 'endDateLantik', 'gredJawatan', 'statSandangan', 'DeptId', 'campus_id', 'NegeriAsalIbu', 'NegeriAsalBapa', 'NegaraAsalCd', 'NegeriAsalCd', 'isSabahan'], 'required', 'on' => 'kemaskini', 'message' => 'Ruang ini adalah mandatori'],
            [['KodProgram'], 'required', 'on' => 'kemaskini_by_kprogram', 'message' => 'Ruang ini adalah mandatori'],
            [['HighestEduLevelCd', 'COBumiStatus', 'COOIsNew', 'accessLevel', 'accessSecondLevel', 'DeptId', 'campus_id', 'statLantikan', 'Status', 'noWaran', 'gredJawatan', 'statSandangan', 'statSandangan_2', 'ApmtTypeCd', 'DeptId_hakiki', 'campus_id_hakiki', 'KodProgram', 'sah_keluarga', 'sah_alamat', 'sah_notel', 'sah_statuskahwin', 'sah_emel', 'sah_akademik', 'sah_agama', 'sah_passport', 'showposition', 'gredJawatan_hakiki'], 'integer'],
            [['ConfermentDt', 'COBirthDt', 'startDateLantik', 'endDateLantik', 'startDateStatus', 'startDateSandangan', 'endDateSandangan', 'startDateSandangan_2', 'endDateSandangan_2', 'last_update', 'last_login', 'kemaskini_terakhir', 'tarikh_sah', 'status_pakar'], 'safe'],
            [['ICNO', 'last_updater', 'pp', 'bos'], 'string', 'max' => 12],
            [['ReligionCd', 'RaceCd', 'COBirthPlaceCd', 'NegeriAsalCd', 'COHPhoneStatus'], 'string', 'max' => 2],
            [['EthnicCd', 'TitleCd'], 'string', 'max' => 4],
            [['ArmyPoliceCd', 'BloodTypeCd', 'COBirthCountryCd', 'NegaraAsalCd', 'NegeriAsalIbu', 'NegeriAsalBapa', 'NatCd'], 'string', 'max' => 3],
            [['MrtlStatusCd', 'GenderCd', 'NatStatusCd'], 'string', 'max' => 1],
            [['CONm', 'program_ums'], 'string', 'max' => 255],
            ['COEmail', 'email', 'message' => 'Sila pastikan format emel anda betul.'],
            ['COEmail', 'string', 'max' => 41, 'message' => 'Email too long.'],
            ['COEmail', 'unique', 'message' => 'Emel rasmi sudah wujud. Sila masukan Emel yang lain.'],
            [['COEmail2'], 'string', 'max' => 100],
            [['COOldID', 'COBirthCertNo'], 'string', 'max' => 15],
            [['COHPhoneNo', 'COHPhoneNo2', 'COOffTelNo'], 'string', 'max' => 14],
            [['COOffTelNoExtn', 'COOffTelNoExtn2'], 'string', 'max' => 6],
            [['COOPass'], 'string', 'max' => 40],
            [['gredJawatan_2', 'jawatanTadbir'], 'string', 'max' => 10],
            [['ICNO'], 'unique'],
            [['carian_data', 'jenis_carian'], 'safe'],
            [['carian_department', 'carian_pendidikantertinggi', 'carian_status', 'carian_statuslantikan', 'carian_jawatan', 'carian_kategorijawatan', 'carian_programpengajaran', 'carian_kampus', 'carian_kodprogram', 'carian_gred'], 'safe'],
            [['jenislantikan'], 'safe'],
            [['isSabahan'], 'integer', 'max' => 1],
            [['COOUCTelNo'], 'string',],
            [['mySejahteraId'], 'string',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'No. KP / Paspot',
            'ReligionCd' => 'Agama',
            'RaceCd' => 'Bangsa',
            'EthnicCd' => 'Etnik',
            'ArmyPoliceCd' => 'Status Uniform',
            'BloodTypeCd' => 'Jenis Darah',
            'MrtlStatusCd' => 'Taraf Perkahwinan',
            'TitleCd' => 'Gelaran',
            'HighestEduLevelCd' => 'Pendidikan Tertinggi',
            'ConfermentDt' => 'Tarikh Dianugerahkan Pendidikan Tertinggi',
            'GenderCd' => 'Jantina',
            'COBirthPlaceCd' => 'Tempat Kelahiran',
            'COBirthCountryCd' => 'Negara Kelahiran',
            'NegaraAsalCd' => 'Negara Asal Cd',
            'NegeriAsalCd' => 'Negeri Asal Cd',
            'NatCd' => 'Warganegara',
            'NatStatusCd' => 'Status Warganegara',
            'CONm' => 'Nama Kakitangan',
            'COEmail' => 'Email',
            'COEmail2' => 'Email2',
            'COBumiStatus' => 'Status Bumiputera',
            'COOldID' => 'UMSPER',
            'COBirthCertNo' => 'No. Sijil Lahir',
            'COBirthDt' => 'Tarikh Lahir',
            'COHPhoneNo' => 'No. Telefon Bimbit',
            'COHPhoneNo2' => 'No. Telefon Bimbit 2',
            'COOffTelNo' => 'No. Telefon Pejabat',
            'COOUCTelNo' => 'No. Telefon Pejabat',
            'COOffTelNoExtn' => 'No. Telefon Pejabat (Extension)',
            'COOffTelNoExtn2' => 'No. Telefon Pejabat (Extension 2)',
            'COOPass' => 'Coopass',
            'COHPhoneStatus' => 'Status Telefon Bimbit',
            'COOIsNew' => 'Coois New',
            'accessLevel' => 'Access Level',
            'accessSecondLevel' => 'Access Second Level',
            'DeptId' => 'Jabatan',
            'campus_id' => 'Kampus',
            'statLantikan' => 'Status Lantikan',
            'startDateLantik' => 'Tarikh Mula Lantikan',
            'endDateLantik' => 'Tarikh Akhir Lantikan',
            'Status' => 'Status',
            'startDateStatus' => 'Start Date Status',
            'noWaran' => 'No. Waran',
            'gredJawatan' => 'Jawatan',
            'statSandangan' => 'Status Sandangan',
            'startDateSandangan' => 'Tarikh Mula Sandangan',
            'endDateSandangan' => 'Tarikh Akhir Sandangan',
            'gredJawatan_2' => 'Gred Jawatan 2',
            'statSandangan_2' => 'Stat Sandangan 2',
            'startDateSandangan_2' => 'Start Date Sandangan 2',
            'endDateSandangan_2' => 'End Date Sandangan 2',
            'ApmtTypeCd' => 'Jenis Lantikan',
            'jawatanTadbir' => 'Jawatan Tadbir',
            'last_update' => 'Last Update',
            'last_updater' => 'Last Updater',
            'last_login' => 'Last Login',
            'pp' => 'Pp',
            'bos' => 'Bos',
            'DeptId_hakiki' => 'Dept Id Hakiki',
            'campus_id_hakiki' => 'Campus Id Hakiki',
            'program_ums' => 'Program Ums',
            'KodProgram' => 'Program Pengajaran',
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
            'wbb_btn' => 'WBB'
        ];
    }

    public function getJawatan()
    {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gredJawatan']);
    }

    public function getJawatanHakiki()
    {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gredJawatan_hakiki']);
    }

    public function getJawatancv()
    {
        return $this->hasOne(\app\models\cv\GredJawatan::className(), ['id' => 'gredJawatan']);
    }

    public function getChiefDepartment()
    {
        return $this->hasOne(Department::className(), ['chief' => 'ICNO'])->where(['isActive' => 1]);
    }

    public function getPpDepartment()
    {
        return $this->hasOne(Department::className(), ['pp' => 'ICNO'])->where(['isActive' => 1]);
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'DeptId']);
    }

    public function getPendidikan()
    {
        return $this->hasOne(PendidikanTertinggi::className(), ['HighestEduLevelCd' => 'HighestEduLevelCd']);
    }

    public function getPasport()
    {
        return $this->hasMany(Tblpasport::className(), ['ICNO' => 'ICNO']);
    }

    public function getServiceStatus()
    {
        return $this->hasOne(ServiceStatus::className(), ['ServStatusCd' => 'Status']);
    }

    public function getKampus()
    {
        return $this->hasOne(Kampus::className(), ['campus_id' => 'campus_id']);
    }

    public function getStatusSandangan()
    {
        return $this->hasOne(StatusSandangan::className(), ['sandangan_id' => 'statSandangan']);
    }

    public function getStatusLantikan()
    {
        return $this->hasOne(StatusLantikan::className(), ['ApmtStatusCd' => 'statLantikan']);
    }

    public function getAgama()
    {
        return $this->hasOne(Agama::className(), ['ReligionCd' => 'ReligionCd']);
    }

    public function getBangsa()
    {
        return $this->hasOne(Bangsa::className(), ['RaceCd' => 'RaceCd']);
    }

    public function getEtnik()
    {
        return $this->hasOne(Etnik::className(), ['EthnicCd' => 'EthnicCd']);
    }

    public function getStatusUniform()
    {
        return $this->hasOne(StatusUniform::className(), ['ArmyPoliceCd' => 'ArmyPoliceCd']);
    }

    public function getJenisDarah()
    {
        return $this->hasOne(Jenisdarah::className(), ['BloodTypeCd' => 'BloodTypeCd']);
    }

    public function getTarafPerkahwinan()
    {
        return $this->hasOne(TarafPerkahwinan::className(), ['MrtlStatusCd' => 'MrtlStatusCd']);
    }

    public function getGelaran()
    {
        return $this->hasOne(Gelaran::className(), ['TitleCd' => 'TitleCd']);
    }

    public function getJantina()
    {
        return $this->hasOne(Jantina::className(), ['GenderCd' => 'GenderCd']);
    }

    public function getTempatLahir()
    {

        return $this->hasOne(Negeri::className(), ['StateCd' => 'COBirthPlaceCd']);
        //sometimes the COBirthPlaceCd can be empty. 
        //need to check if the value of COBirthPlaceCd is empty in view page.
    }

    public function getNegaraLahir()
    {

        return $this->hasOne(Negara::className(), ['CountryCd' => 'COBirthCountryCd']);
    }

    public function getWarganegara()
    {

        return $this->hasOne(Negara::className(), ['CountryCd' => 'NatCd']);
    }

    public function getStatusWarganegara()
    {

        return $this->hasOne(StatusWarganegara::className(), ['NatStatusCd' => 'NatStatusCd']);
    }

    public function getStatusBumiputera()
    {

        return $this->COBumiStatus ? 'Yes' : 'No';
        //this function only return Yes or No;
        //care your view;
    }

    public function getAksesLevel()
    {

        return $this->hasOne(AksesLevel::className(), ['id' => 'accessLevel']);
    }

    public function getAksesLevelKedua()
    {

        return $this->hasOne(AksesLevelKedua::className(), ['id' => 'accessSecondLevel']);
    }

    public function getJenisLantikan()
    {

        return $this->hasOne(JenisLantikan::className(), ['ApmtTypeCd' => 'ApmtTypeCd']);
    }

    public function getShields()
    {

        return $this->hasOne(SelfRisk::class, ['icno' => 'ICNO']);
    }

    public function getJawatanPentadbiran()
    {

        return $this->hasOne(JawatanPentadbiran::className(), ['id' => 'jawatanTadbir']);
    }

    public function getDepartmentHakiki()
    {

        return $this->hasOne(Department::className(), ['id' => 'DeptId_hakiki']);
    }

    public function getKampusHakiki()
    {

        return $this->hasOne(Kampus::className(), ['campus_id' => 'campus_id_hakiki']);
    }

    public function getProgramPengajaran()
    {

        return $this->hasOne(ProgramPengajaran::className(), ['id' => 'KodProgram']);
    }

    public function getVaksinasi()
    {
        return $this->hasOne(Tblvaksinasi::className(), ['icno' => 'ICNO']);
    }

    public function getStatusVaksinasi()
    {
        return $this->hasOne(Tblstatusvaksinasi::className(), ['icno' => 'ICNO']);
    }

    public function getWatchList()
    {
        return $this->hasOne(Tblbsmwatchlist::className(), ['icno' => 'ICNO']);
    }

    public function getTblrscoapmtstatus()
    {
        return $this->hasOne(Tblrscoapmtstatus::className(), ['ICNO' => 'ICNO'])->orderBy(['ApmtStatusStDt' => SORT_DESC]);
    }

    public function getTblrscoapmtstatusAsc()
    {
        return $this->hasOne(Tblrscoapmtstatus::className(), ['ICNO' => 'ICNO'])->orderBy(['ApmtStatusStDt' => SORT_ASC]);
    }

    public function getTblsandangan()
    {
        return $this->hasOne(TblSandangan::className(), ['ICNO' => 'ICNO'])->andOnCondition(['sandangan_id' => $this->statSandangan]);
    }

    public function getTblrscoservstatus()
    {
        return $this->hasMany(Tblrscoservstatus::className(), ['ICNO' => 'ICNO'])->orderBy(['ServStatusStDt' => SORT_ASC]);
    }

    public function getRecognition()
    {
        return $this->hasMany(Tblrecognition::className(), ['staff_id' => 'COOldID']);
    }

    ///////////////////////////////////////////////////////////////////////////////////
    //below section is function for get data inside reff_table for view before save data.
    //below function is not relation. find relation at above.

    public function getDisplayJawatan()
    {
        if ($this->jawatan) {
            return $this->jawatan->fname;
        }
        return '-';
    }

    public function getDisplayDepartment()
    {
        $model = Department::find()->where(['id' => $this->DeptId])->one();

        return $model->fullname;
    }

    public function getDisplayPendidikan()
    {
        $model = PendidikanTertinggi::find()->where(['HighestEduLevelCd' => $this->HighestEduLevelCd])->one();
        if ($model) {
            return $model->HighestEduLevel;
        }
        return '-';
    }

    public function getDisplayServiceStatus()
    {
        $model = ServiceStatus::find()->where(['ServStatusCd' => $this->Status])->one();

        return $model->ServStatusNm;
    }

    public function getDisplayKampus()
    {
        $model = Kampus::find()->where(['campus_id' => $this->campus_id])->one();

        return $model->campus_name;
    }

    public function getDisplayStatusSandangan()
    {
        if ($this->statusSandangan) {
            return $this->statusSandangan->sandangan_name;
        }
        return null;
    }

    public function getDisplayStatusLantikan()
    {
        if ($this->statusLantikan) {
            return $this->statusLantikan->ApmtStatusNm;
        }

        return 'null';
    }

    public function getDisplayStartSandangan()
    {
        if ($this->tblsandangan) {
            return Yii::$app->MP->Tarikh($this->tblsandangan->start_date);
        }
        return Yii::$app->MP->Tarikh($this->startDateSandangan);
    }

    public function getDisplayStartDateStatus()
    {
        return $this->getTarikh($this->startDateStatus);
    }

    public function getDisplayStartDateSandangan()
    {

        if ($this->tblsandangan) {
            return Yii::$app->MP->Tarikh($this->tblsandangan->start_date);
        }
        return Yii::$app->MP->Tarikh($this->startDateSandangan);
    }

    public function getDisplayFirstStatusLantikan()
    {
        $first = Tblrscoapmtstatus::find()->where(['ICNO' => $this->ICNO])->orderBy(['ApmtStatusStDt' => SORT_ASC])->one();
        $sp = Tblrscosandangan::find()->where(['ICNO' => $this->ICNO])->orderBy(['start_date' => SORT_ASC])->one();

        // var_dump($first->statusLantikan->ApmtStatusNm);die;

        if ($first) {
            // return $first->statusLantikan->ApmtStatusNm;
            return $sp->gredJawatan->nama . ' ' . ('(' . $sp->gredJawatan->gred . ')') . ' , ' . $first->statusLantikan->ApmtStatusNm .
                ' ( mulai / start ' . $this->getTarikh($sp->start_date) . ')';
        }

        return 'no rekod';
    }

    public function getDisplayLatestStatusLantikan()
    {
        $first = Tblrscoapmtstatus::find()->where(['ICNO' => $this->ICNO])->orderBy(['ApmtStatusStDt' => SORT_DESC])->one();
        $sp = Tblrscosandangan::find()->where(['ICNO' => $this->ICNO])->orderBy(['start_date' => SORT_DESC])->one();

        // var_dump($first->statusLantikan->ApmtStatusNm);die;

        if ($first) {
            // return $first->statusLantikan->ApmtStatusNm;
            return $sp->gredJawatan->nama . ' ' . ('(' . $sp->gredJawatan->gred . ')') . ' , ' . $first->statusLantikan->ApmtStatusNm .
                ' ( mulai / start ' . $this->getTarikh($sp->start_date) . ')';
        }

        return 'no rekod';
    }

    public function getDisplayLatestServiceStatus()
    {

        $sp = Tblrscosandangan::find()->where(['ICNO' => $this->ICNO])->orderBy(['start_date' => SORT_ASC])->one();

        $model = ServiceStatus::find()->where(['ServStatusCd' => $this->Status])->one();

        $model1 = Tblrscoservstatus::find()->where(['ICNO' => $this->ICNO])->orderBy(['ServStatusStDt' => SORT_DESC])->one();

        if ($model1) {
            $mod = Servicestatusdetail::findOne(['id' => $model1->ServStatusDtl]);
            $var = $model->ServStatusNm . ' , ' . $mod->name . ' ( mulai / start ' . $this->getTarikh($sp->start_date) . ' ) ';
        } else {
            $var = $model->ServStatusNm . ' , ( mulai / start ' . $this->getTarikh($sp->start_date) . ' ) ';
        }



        return $var;
    }

    public function getAllocation()
    {
        return $this->hasOne(TblProfiles::className(), ['icno' => 'ICNO'])->orderBy(['start_date' => SORT_DESC]);
    }

    public function getDisplayGambar()
    {
        return Html::img("https://hronline.ums.edu.my/picprofile/picstf/" . strtoupper(hash('sha1', $this->ICNO)) . ".jpeg", ['width' => '100px']);
    }

    public function getDisplayAgama()
    {
        if ($this->agama) {
            return $this->agama->Religion;
        }

        return null;
    }

    public function getDisplayBangsa()
    {

        if ($this->bangsa) {
            return $this->bangsa->Race;
        }

        return null;
    }

    public function getDisplayEtnik()
    {
        $model = Etnik::find()->where(['EthnicCd' => $this->EthnicCd])->one();

        return $model->Ethnic;
    }

    public function getDisplayStatusUniform()
    {
        $model = StatusUniform::find()->where(['ArmyPoliceCd' => $this->ArmyPoliceCd])->one();

        return $model->ArmyPolice;
    }

    public function getDisplayJenisDarah()
    {
        $model = Jenisdarah::find()->where(['BloodTypeCd' => $this->BloodTypeCd])->one();

        return $model->BloodType;
    }

    public function getDisplayTarafPerkahwinan()
    {
        $model = TarafPerkahwinan::find()->where(['MrtlStatusCd' => $this->MrtlStatusCd])->one();

        return $model->MrtlStatus;
    }

    public function getDisplayGelaran()
    {
        if ($this->gelaran) {
            return $this->gelaran->Title;
        }
        return '-';
    }

    public function getDisplayJantina()
    {
        $model = Jantina::find()->where(['GenderCd' => $this->GenderCd])->one();

        return $model->Gender;
    }

    public function getDisplayTempatLahir()
    {
        $model = Negeri::find()->where(['StateCd' => $this->COBirthPlaceCd])->one();
        if (empty($model->State)) {
            return 'Not Set';
        }
        return $model->State;
    }

    public function getDisplayNegaraLahir()
    {
        $model = Negara::find()->where(['CountryCd' => $this->COBirthCountryCd])->one();

        return $model->Country;
    }

    public function getNegaraAsalStaf()
    {
        return $this->hasOne(Negara::className(), ['CountryCd' => 'NegaraAsalCd']);
    }

    public function getNegeriAsalStaf()
    {
        return $this->hasOne(Negeri::className(), ['StateCd' => 'NegeriAsalCd']);
    }

    public function getDisplayNegaraAsalStaf()
    {
        if ($this->negaraAsalStaf) {
            return $this->negaraAsalStaf->Country;
        }
        return '-';
    }

    public function getDisplayNegeriAsalStaf()
    {
        if ($this->negeriAsalStaf) {
            return $this->negeriAsalStaf->State;
        }
        return '-';
    }

    public function getDisplayWarganegara()
    {
        $model = Negara::find()->where(['CountryCd' => $this->NatCd])->one();

        return $model->Country;
    }

    public function getNegeriAsalIbu()
    {
        if ($this->NegeriAsalIbu) {
            $model = Negeri::find()->where(['StateCd' => $this->NegeriAsalIbu])->one();
            return $model->State;
        }
        return '-';
    }

    public function getNegeriAsalBapa()
    {
        if ($this->NegeriAsalBapa) {
            $model = Negeri::find()->where(['StateCd' => $this->NegeriAsalBapa])->one();
            return $model->State;
        }
        return '-';
    }

    public function getDisplayStatusWarganegara()
    {
        $model = StatusWarganegara::find()->where(['NatStatusCd' => $this->NatStatusCd])->one();

        return $model->NatStatus;
    }

    public function getDisplayStatusBumiputera()
    {
        return $this->COBumiStatus ? 'Bumiputera' : 'Bukan Bumiputera';
    }

    public function getDisplayBirthDt()
    {
        return $this->getTarikh($this->COBirthDt);
    }

    public function getDisplayPhone2()
    {
        if ($this->COHPhoneNo2) {
            return $this->COHPhoneNo2;
        }
        return '-';
    }

    public function getDisplayStatusPhone()
    {
        return $this->COHPhoneStatus ? 'Aktif' : 'Tidak Aktif';
    }

    public function getDisplayJenisLantikan()
    {

        $model = JenisLantikan::find()->where(['ApmtTypeCd' => $this->ApmtTypeCd])->one();

        return $model->ApmtTypeNm;
    }

    public function getDisplayProgramPengajaran()
    {

        if ($this->KodProgram) {

            $model = ProgramPengajaran::find()->where(['id' => $this->KodProgram])->one();
            return $model->NamaProgram;
        }

        return 'Tidak Berkaitan'; //return 'tidak berkaitan' jika kakitangan yg ditambah adalah bukan akademik
    }

    public function getDisplayJawatanPentadbiran()
    {
        if ($this->jawatanPentadbiran) {
            return $this->jawatanPentadbiran->name;
        }
        return 'Tidak Berkaitan';
    }

    public function getDisplayJawatanHakiki()
    {
        if ($this->gredJawatan_hakiki) {
            $model = GredJawatan::find()->where(['id' => $this->gredJawatan_hakiki])->one();
            return $model->fname;
        }
        return 'Not set';
    }

    public function getDisplayDepartmentHakiki()
    {
        if ($this->departmentHakiki) {
            return $this->departmentHakiki->fullname;
        }
        return 'Not set';
    }

    public function getDisplayKampusHakiki()
    {
        if ($this->kampusHakiki) {
            return $this->kampusHakiki->campus_name;
        }
        return 'Not set';
    }

    public function getDisplayaccesslevel()
    {

        $model = AksesLevel::find()->where(['id' => $this->accessLevel])->one();

        return $model->nama;
    }

    public function getDisplayaccesslevelkedua()
    {

        $model = AksesLevelKedua::find()->where(['id' => $this->accessSecondLevel])->one();

        return $model->nama;
    }

    public function getResetpassword()
    {

        $value = Html::a('<button style="color:red;">Reset Password</button>', ['resetpassword', 'id' => $this->ICNO], [
            'data' => [
                'confirm' => 'Anda ingin set semula katalaluan ini?',
                'method' => 'post',
            ],
        ]);

        return $value;
    }

    public function getSyncad()
    {

        $value = Html::a('<button style="color:red;">Sync AD</button>', ['sync-to-ad', 'id' => $this->ICNO], [
            'data' => [
                'confirm' => 'Data hronline akan dihantar ke AD?',
                'method' => 'post',
            ],
        ]);

        return $value;
    }

    /**
     * Display fullname with title
     */
    public function getDisplayTitleName()
    {

        try {
            $nama = ucwords(strtolower($this->CONm));
            $title = $this->gelaran->Title;
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }

        return $title . ' ' . $nama;
    }

    //////////////////////////////////////////////////////////////////////////////////
    //Button utk modul kehadiran
    public function getWbb_btn()
    {

        return Html::a('<i class="fa fa-clock-o"></i>', ['kehadiran/senarai_wbb', 'id' => $this->ICNO], ['class' => 'btn btn-primary btn-sm']);
    }

    //Button utk modul kehadiran
    public function getAttdn_btn()
    {

        return Html::a('<i class="fa fa-list"></i>', ['kehadiran/laporan_kehadiran', 'id' => $this->ICNO], ['class' => 'btn btn-primary btn-sm']);
    }

    public function getAccess()
    {
        return $this->accessLevel;
    }

    public function getBersara()
    {
        return $this->hasOne(Tblretireage::className(), ['ICNO' => 'ICNO'])->orderBy(['CORetireAgeEftvDt' => SORT_DESC]);
    }

    public function getRetire()
    {
        // var_dump($this->bersara );
        //     die;
        if ($this->bersara) {
            return $this->bersara->CORetireAgeEftvDt;
        }
        return false;
    }

    public function getTarikhbersara()
    {

        if ($this->statLantikan == 1) {

            if ($this->getRetire() == false) {

                $date = new DateTime($this->COBirthDt);
                $date->add(new DateInterval('P60Y'));
                return $this->getTarikh($date->format('Y-m-d'));
            } else {
                return $this->getTarikh($this->getRetire());
            }
        }
        return $this->getTarikh($this->endDateLantik);
    }

    public function getDisplayStartLantik()
    {
        if ($this->tblrscoapmtstatus) {
            return Yii::$app->MP->Tarikh($this->startDateLantik);
            // return Yii::$app->MP->Tarikh($this->tblrscoapmtstatus->ApmtStatusStDt);
        }

        return null;
    }

    public function getDisplayEndLantik()
    {
        if ($this->tblrscoapmtstatus) {
            return Yii::$app->MP->Tarikh($this->tblrscoapmtstatus->ApmtStatusEndDt);
        }

        return null;
    }

    public function getDisplayStartToEndLantik()
    {
        $v = null;
        if ($this->tblrscoapmtstatus) {
            $v = Yii::$app->MP->Tarikh($this->tblrscoapmtstatus->ApmtStatusStDt) . ' to ' . $this->getTarikh($this->endDateLantik);
        }
        // $v = $this->getTarikh($this->startDateLantik) . ' to ' . $this->getTarikh($this->endDateLantik);
        return $v;
    }

    public function getDisplayStartToEndLantikBiodata()
    {
        $latest_bekas_pekerja = null;

        switch ($this->statLantikan) {
            case "1":
                foreach ($this->tblrscoservstatus as $tblrscoservstatus) {
                    if ($tblrscoservstatus->ServStatusCd == 6) {
                        $latest_bekas_pekerja = $tblrscoservstatus->ServStatusStDt;
                    }
                }
                if ($latest_bekas_pekerja == null) {
                    $endDate = (date_format(date_create($this->tblrscoapmtstatus->ApmtStatusEndDt), "Y") == 2999) ? $this->tarikhbersara : Yii::$app->MP->Tarikh($this->tblrscoapmtstatus->ApmtStatusEndDt);
                    return Yii::$app->MP->Tarikh($this->tblrscoapmtstatusAsc->ApmtStatusStDt) . ' hingga ' . $endDate;
                }
                foreach ($this->tblrscoservstatus as $tblrscoservstatus) {
                    if ($tblrscoservstatus->ServStatusCd == 1 && $tblrscoservstatus->ServStatusStDt > $latest_bekas_pekerja) {
                        $apmtStatus = Tblrscoapmtstatus::find()->where(['ApmtStatusStDt' => $tblrscoservstatus->ServStatusStDt])->one();
                        $endDate = (date_format(date_create($apmtStatus->ApmtStatusEndDt), "Y") == 2999) ? $this->tarikhbersara : Yii::$app->MP->Tarikh($apmtStatus->ApmtStatusEndDt);
                        return Yii::$app->MP->Tarikh($apmtStatus->ApmtStatusStDt) . ' hingga ' . $endDate;
                    }
                }

                break;
            default:
                if ($this->tblrscoapmtstatus) {
                    return Yii::$app->MP->Tarikh($this->tblrscoapmtstatus->ApmtStatusStDt) . ' hingga ' . Yii::$app->MP->Tarikh($this->tblrscoapmtstatus->ApmtStatusEndDt);
                }
                return Yii::$app->MP->Tarikh($this->startDateLantik) . ' hingga ' . $this->tarikhbersara;
                break;
        }
    }

    public function getTarikh($bulan)
    {

        $m = date_format(date_create($bulan), "m");
        if ($m == 01) {
            $m = "Januari";
        } elseif ($m == 02) {
            $m = "Februari";
        } elseif ($m == 03) {
            $m = "Mac";
        } elseif ($m == 04) {
            $m = "April";
        } elseif ($m == 05) {
            $m = "Mei";
        } elseif ($m == 06) {
            $m = "Jun";
        } elseif ($m == 07) {
            $m = "Julai";
        } elseif ($m == '08') {
            $m = "Ogos";
        } elseif ($m == '09') {
            $m = "September";
        } elseif ($m == '10') {
            $m = "Oktober";
        } elseif ($m == '11') {
            $m = "November";
        } elseif ($m == '12') {
            $m = "Disember";
        }

        return date_format(date_create($bulan), "d") . ' ' . $m . ' ' . date_format(date_create($bulan), "Y");
    }

    public function getTarikhBI($bulan)
    {

        $m = date_format(date_create($bulan), "m");
        if ($m == 01) {
            $m = "January";
        } elseif ($m == 02) {
            $m = "February";
        } elseif ($m == 03) {
            $m = "March";
        } elseif ($m == 04) {
            $m = "April";
        } elseif ($m == 05) {
            $m = "May";
        } elseif ($m == 06) {
            $m = "June";
        } elseif ($m == 07) {
            $m = "July";
        } elseif ($m == '08') {
            $m = "August";
        } elseif ($m == '09') {
            $m = "September";
        } elseif ($m == '10') {
            $m = "October";
        } elseif ($m == '11') {
            $m = "November";
        } elseif ($m == '12') {
            $m = "December";
        }

        return date_format(date_create($bulan), "d") . ' ' . $m . ' ' . date_format(date_create($bulan), "Y");
    }

    public function getTarikhtamatlantik()
    {
        return $this->getTarikh($this->endDateLantik);
    }

    public function getTarikhmulalantik()
    {
        return $this->getTarikh($this->startDateLantik);
    }

    public function getApplication()
    {
        return $this->hasOne(Application::className(), ['icno' => 'ICNO']);
    }

    public function getStaff()
    {
        return $this->hasOne(Recommendation::className(), ['icno' => 'ICNO']);
    }

    public static function DisplayNameGred($icno)
    {
        $model = self::findOne(['ICNO' => $icno]);

        if ($model) {
            return $model->CONm . " (" . $model->jawatan->gred . ')';
        }

        return false;
    }

    /////////////////////////////E-jobs//////////////////////////////////////////////////////

    public function getLnpt()
    {
        return $this->hasOne(Markahkeseluruhan::className(), ['lpp_id' => 'lpp_id'])
            ->viaTable('lppums.lpp', ['PYD' => 'ICNO'], function ($query) {
                $query->andWhere(['or', ['tahun' => (date('Y') - 1)], ['tahun' => NULL]]);
            });
    }

    public function getLnpt2()
    {
        return $this->hasOne(Markahkeseluruhan::className(), ['lpp_id' => 'lpp_id'])
            ->viaTable('lppums.lpp', ['PYD' => 'ICNO'], function ($query) {
                $query->andWhere(['tahun' => date('Y') - 2]);
            });
    }

    public function getLnpt3()
    {
        return $this->hasOne(Markahkeseluruhan::className(), ['lpp_id' => 'lpp_id'])
            ->viaTable('lppums.lpp', ['PYD' => 'ICNO'], function ($query) {
                $query->andWhere(['tahun' => date('Y') - 3]);
            });
    }

    public function getAlamatTetap()
    {
        return $this->hasOne(Tblalamat::className(), ['ICNO' => 'ICNO'])->where(['AddrTypeCd' => '01']);
    }

    public function getAlamatSuratmenyurat()
    {
        return $this->hasOne(Tblalamat::className(), ['ICNO' => 'ICNO'])->where(['AddrTypeCd' => '02']);
    }

    public function getAlamatSemasa()
    {
        return $this->hasOne(Tblalamat::className(), ['ICNO' => 'ICNO'])->where(['AddrTypeCd' => '03']);
    }

    public function getAlamatLain2()
    {
        return $this->hasOne(Tblalamat::className(), ['ICNO' => 'ICNO'])->where(['AddrTypeCd' => '99']);
    }

    public function getRekodAlamat()
    {
        return $this->hasOne(Tblalamat::className(), ['ICNO' => 'ICNO']);
    }

    public function getAlamat()
    {
        return $this->hasMany(Tblalamat::className(), ['ICNO' => 'ICNO'])->One();
    }

    public function getKeluarga()
    {
        return $this->hasMany(Tblkeluarga::className(), ['ICNO' => 'ICNO']);
    }

    public function getPendidikanByRank()
    {
        return $this->hasMany(Tblpendidikan::className(), ['ICNO' => 'ICNO'])
            ->joinWith('pendidikanTertinggi')
            ->where(['<=', 'educationallevel.HighestEduLevelRank', 4])
            ->orderBy(['educationallevel.HighestEduLevelRank' => SORT_ASC]);
    }

    public function getAkademik()
    {
        return $this->hasMany(Tblpendidikan::className(), ['ICNO' => 'ICNO'])->orderBy(['ConfermentDt' => SORT_DESC]);
    }

    public function getAkademikWarta()
    {
        return $this->hasMany(Tblpendidikan::className(), ['ICNO' => 'ICNO'])->where(['HighestEduLevelCd' =>
        [1, 2, 3, 4, 5, 6, 7, 8, 20, 45]])->orderBy(['ConfermentDt' => SORT_DESC]);
    }

    public function getNamaKos()
    {
        $ICNO = $this->ICNO;
        return $this->hasOne(Tblpendidikan::className(), ['HighestEduLevelCd' => 'HighestEduLevelCd'])->where(['ICNO' => $ICNO]);
    }

    public function getBahasa()
    {
        return $this->hasMany(Tblbahasa::className(), ['ICNO' => 'ICNO']);
    }

    public function getPengalaman()
    {
        return $this->hasMany(Tblpengalamankerja::className(), ['ICNO' => 'ICNO'])->orderBy(['PrevEmpEndDt' => SORT_DESC]);
    }

    public function getKecacatan()
    {
        return $this->hasMany(Tblkecacatan::className(), ['ICNO' => 'ICNO']);
    }

    public function getBidangKepakaran()
    {
        return $this->hasMany(\app\models\hronline\Tblbidangkepakaran::className(), ['ICNO' => 'ICNO']);
    }

    public function getAnugerah()
    {
        return $this->hasMany(Tblanugerah::className(), ['ICNO' => 'ICNO'])->orderBy(['AwdCfdDt' => SORT_DESC]);
    }

    public function getLesen()
    {
        return $this->hasMany(Tbllesen::className(), ['ICNO' => 'ICNO'])->orderBy(['FirstLicIssuedDt' => SORT_DESC])
            ->one();
    }

    public function getBadanprof()
    {
        return $this->hasMany(TblBadanProfesional::className(), ['ICNO' => 'ICNO'])->where(['ProfAssocStatus' => '1'])->orderBy(['JoinDt' => SORT_DESC]);
    }

    public function getNsr()
    {
        return $this->hasOne(TblBadanProfesional::className(), ['ICNO' => 'ICNO'])->where(['ProfBodyCd' => 5308]);
    }

    public function getBadanprofesional()
    {
        return $this->hasMany(TblBadanProfesional::className(), ['ICNO' => 'ICNO'])->orderBy(['JoinDt' => SORT_DESC]);
    }

    public function getBadanprofesionalVerified()
    {
        return $this->hasMany(TblBadanProfesional::className(), ['ICNO' => 'ICNO'])->where(['isVerified' => 1])->orderBy(['JoinDt' => SORT_DESC]);
    }

    public function getMedicalCertificate()
    {
        return $this->hasMany(Tblprclinicalcert::className(), ['ICNO' => 'ICNO'])->orderBy(['startDt' => SORT_DESC]);
    }

    public function getMedicalCertificateVerified()
    {
        return $this->hasMany(Tblprclinicalcert::className(), ['ICNO' => 'ICNO'])->where(['isVerified' => 1])->orderBy(['startDt' => SORT_DESC]);
    }

    public function getRujukan()
    {
        return $this->hasOne(SetPegawai::className(), ['pemohon_icno' => 'ICNO']);
    }

    public function getResearchInterest()
    {
        return $this->hasMany(\app\models\cv\TblResearchInterest::className(), ['UserID' => 'ICNO'])->orderBy(['LastUpdate' => SORT_DESC])->one();
    }

    public function getPersidangan()
    { //db 6
        return $this->hasMany(TblConference::className(), ['IC' => 'ICNO'])->orderBy(['StartDate' => SORT_DESC]);
    }

    public function getPersidangan2()
    { //db10
        return $this->hasMany(\app\models\elnpt\TblConference::className(), ['IC' => 'ICNO'])->where(['StatusConference' => 'Verified'])->orderBy(['StartYear' => SORT_DESC]);
    }

    public function getPersidangan3()
    {
        return $this->hasMany(\app\models\elnpt\TblConference::className(), ['IC' => 'ICNO']);
    }

    public function getPersidanganRole()
    {
        return \app\models\elnpt\TblConference::find()->orderBy(['Peranan' => SORT_ASC])->select(['Peranan'])->distinct()->all();
    }

    public function getRolepersidangan()
    {
        return \app\models\elnpt\TblConference::find()->where(['!=', 'Peranan', 'Tiada Data'])->select(['Peranan'])->distinct()->all();
    }

    public function getPersidanganAhliPanel()
    {
        return $this->hasMany(\app\models\elnpt\TblConference::className(), ['IC' => 'ICNO'])->where(['Peranan' => 'Ahli Panel'])->orderBy(['StartYear' => SORT_DESC]);
    }

    public function getPersidanganKeynoteSpeaker()
    {
        return $this->hasMany(\app\models\elnpt\TblConference::className(), ['IC' => 'ICNO'])->where(['Peranan' => 'Ketua Sesi'])->orderBy(['StartYear' => SORT_DESC]);
    }

    public function getPersidanganKetuaSesi()
    {
        return $this->hasMany(\app\models\elnpt\TblConference::className(), ['IC' => 'ICNO'])->where(['Peranan' => 'Keynote Speaker'])->orderBy(['StartYear' => SORT_DESC]);
    }

    public function getPersidanganPembentang()
    {
        return $this->hasMany(\app\models\elnpt\TblConference::className(), ['IC' => 'ICNO'])->where(['Peranan' => 'Pembentang'])->orderBy(['StartYear' => SORT_DESC]);
    }

    public function getPersidanganPembentangJemputan()
    {
        return $this->hasMany(\app\models\elnpt\TblConference::className(), ['IC' => 'ICNO'])->where(['Peranan' => 'Pembentang Jemputan'])->orderBy(['StartYear' => SORT_DESC]);
    }

    public function getPersidanganPembentangPoster()
    {
        return $this->hasMany(\app\models\elnpt\TblConference::className(), ['IC' => 'ICNO'])->where(['Peranan' => 'Pembentang Poster'])->orderBy(['StartYear' => SORT_DESC]);
    }

    public function getPersidanganPengerusi()
    {
        return $this->hasMany(\app\models\elnpt\TblConference::className(), ['IC' => 'ICNO'])->where(['Peranan' => 'Pengerusi'])->orderBy(['StartYear' => SORT_DESC]);
    }

    public function getPersidanganPeserta()
    {
        return $this->hasMany(\app\models\elnpt\TblConference::className(), ['IC' => 'ICNO'])->where(['Peranan' => 'Peserta'])->orderBy(['StartYear' => SORT_DESC]);
    }

    public function getPersidanganTiadaData()
    {
        return $this->hasMany(\app\models\elnpt\TblConference::className(), ['IC' => 'ICNO'])->where(['Peranan' => 'Tiada Data'])->orderBy(['StartYear' => SORT_DESC]);
    }

    public function getPertandinganPereka()
    {
        return $this->hasMany(\app\models\elnpt\inovasi\TblPertandinganPereka::className(), ['NoIC' => 'ICNO']);
    }

    public function getPertandinganPerekaKetua()
    {
        return $this->hasMany(\app\models\elnpt\inovasi\TblPertandinganPereka::className(), ['NoIC' => 'ICNO'])->where(['Peranan' => 'KETUA'])->orderBy(['Tahun' => SORT_ASC]);
    }

    public function getPertandinganPerekaAhli()
    {
        return $this->hasMany(\app\models\elnpt\inovasi\TblPertandinganPereka::className(), ['NoIC' => 'ICNO'])->where(['Peranan' => 'AHLI'])->orderBy(['Tahun' => SORT_ASC]);
    }

    public function getInovasi()
    {
        return $this->hasMany(\app\models\elnpt\inovasi\TblInovasi::className(), ['NoStaf' => 'COOldID']);
    }

    public function getInovasiSelesai()
    {
        return $this->hasMany(\app\models\elnpt\inovasi\TblInovasi::className(), ['NoStaf' => 'COOldID'])->where(['Status' => 'Selesai']);
    }

    public function getInovasiLeader()
    {
        return $this->hasMany(\app\models\elnpt\inovasi\TblInovasi::className(), ['NoStaf' => 'COOldID'])->where(['Keahlian' => 'Leader'])->orderBy(['TarikhMula' => SORT_ASC]);
    }

    public function getInovasiMember()
    {
        return $this->hasMany(\app\models\elnpt\inovasi\TblInovasi::className(), ['NoStaf' => 'COOldID'])->where(['Keahlian' => 'Member'])->orderBy(['TarikhMula' => SORT_ASC]);
    }

    public function getInovasiPresenter()
    {
        return $this->hasMany(\app\models\elnpt\inovasi\TblInovasi::className(), ['NoStaf' => 'COOldID'])->where(['Keahlian' => 'Presenter'])->orderBy(['TarikhMula' => SORT_ASC]);
    }

    public function getInovasiProfessionalService()
    {
        return $this->hasMany(\app\models\elnpt\inovasi\TblInovasi::className(), ['NoStaf' => 'COOldID'])->where(['Keahlian' => 'Professional Service'])->orderBy(['TarikhMula' => SORT_ASC]);
    }

    public function getAbstract()
    {
        return $this->hasMany(DboVwCVAbstract::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['StartDate' => SORT_DESC]);
    }

    public function getAnthology()
    {
        return $this->hasMany(DboVwCVAnthology::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getBook()
    {
        return $this->hasMany(DboVwCVBook::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getBookChapter()
    {
        return $this->hasMany(DboVwCVBookChapter::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getCreative()
    {
        return $this->hasMany(DboVwCVCreative::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getJournalInternational()
    {
        return $this->hasMany(DboVwCVJournalInternational::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getJournalNational()
    {
        return $this->hasMany(DboVwCVJournalNational::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getMagazine()
    {
        return $this->hasMany(DboVwCVMagazine::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getManual()
    {
        return $this->hasMany(DboVwCVManual::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getModule()
    {
        return $this->hasMany(DboVwCVModule::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getPreUni()
    {
        return $this->hasMany(DboVwCVPreUni::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getProceedingInternational()
    {
        return $this->hasMany(DboVwCVProceedingInternational::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['StartDate' => SORT_DESC]);
    }

    public function getProceedingNational()
    {
        return $this->hasMany(DboVwCVProceedingNational::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['StartDate' => SORT_DESC]);
    }

    public function getTechnical()
    {
        return $this->hasMany(DboVwCVTechnical::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getTextbook()
    {
        return $this->hasMany(DboVwCVTextbook::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getTranslation()
    {
        return $this->hasMany(DboVwCVTranslation::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->orderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getResearch()
    { // db 6
        return $this->hasMany(TblPenyelidikan::className(), ['IC' => 'ICNO']);
    }

    public function getResearchGrantLevel()
    {
        return TblPenyelidikan2::find()->OrderBy(['GrantLevel' => SORT_ASC])->select('GrantLevel')->distinct()->all();
    }

    public function getResearchAgencyType()
    {
        return TblPenyelidikan2::find()->select('AgencyType')->distinct()->all();
    }

    public function s($GrantLevel, $AgencyType, $ICNO)
    {
        return TblPenyelidikan2::find()->where(['IC' => $ICNO])->andWhere(['GrantLevel' => $GrantLevel])->andWhere(['AgencyType' => $AgencyType])->count();
    }

    public function getResearch2()
    { // db 10
        return $this->hasMany(TblPenyelidikan2::className(), ['IC' => 'ICNO'])->OrderBy(['Membership' => SORT_ASC]);
    }

    public function getResearchMembership()
    {
        return TblPenyelidikan2::find()->OrderBy(['Membership' => SORT_ASC])->select(['Membership'])->distinct()->all();
    }

    public function getResearchStatus()
    {
        return TblPenyelidikan2::find()->OrderBy(['ResearchStatus' => SORT_ASC])->select(['ResearchStatus'])->distinct()->all();
    }

    public function getResearchCompleted()
    { // db 10
        return $this->hasMany(TblPenyelidikan2::className(), ['IC' => 'ICNO'])->where(['ResearchStatus' => 'Selesai'])->OrderBy(['Membership' => SORT_ASC]);
    }

    public function dateGradePhd()
    {
        $phd = Tblpendidikan::find()
            ->where(['ICNO' => $this->ICNO])
            ->andWhere(['HighestEduLevelCd' => 1])
            ->orderBy(['ConfermentDt' => SORT_ASC])->one();

        return $phd ? $phd->ConfermentDt : '';
    }

    public function dateStartPhd()
    {
        $phd = Tblpendidikan::find()
            ->where(['ICNO' => $this->ICNO])
            ->andWhere(['HighestEduLevelCd' => 1])
            ->andWhere(['is not', 'StartEduDt', NULL])
            ->orderBy(['ConfermentDt' => SORT_ASC])->one();

        return $phd ? $phd->StartEduDt : '';
    }

    public function dateStartLantikanPertama()
    {
        $lantikan = Tblrscoapmtstatus::find()
            ->where(['ICNO' => $this->ICNO])
            ->orderBy(['ApmtStatusStDt' => SORT_ASC])->one();

        return $lantikan ? $lantikan->ApmtStatusStDt : '';
    }

    public function getResearchLeader()
    {
        return $this->hasMany(TblPenyelidikan2::className(), ['IC' => 'ICNO'])->where(['Membership' => 'Leader'])->OrderBy(['StartYear' => SORT_ASC]);
    }

    public function getResearchMember()
    {
        return $this->hasMany(TblPenyelidikan2::className(), ['IC' => 'ICNO'])->where(['Membership' => 'Member'])->OrderBy(['StartYear' => SORT_ASC]);
    }

    public function getResearchNoData()
    {
        return $this->hasMany(TblPenyelidikan2::className(), ['IC' => 'ICNO'])->where(['Membership' => 'No Data'])->OrderBy(['StartYear' => SORT_ASC]);
    }

    public function getResearchNA()
    {
        return $this->hasMany(TblPenyelidikan2::className(), ['IC' => 'ICNO'])->where(['Membership' => 'N/A'])->OrderBy(['StartYear' => SORT_ASC]);
    }

    public function getPublicationCompletedAfterPhd()
    {
        if (!empty($this->dateGradePhd())) {
            return $this->hasMany(TblLnptPublicationV2::className(), ['User_Ic' => 'ICNO'])
                ->where(['ApproveStatus' => 'V'])
                ->andWhere(['>=', 'PublicationYear', date('Y', strtotime($this->dateGradePhd()))]);
        } else {
            return null;
        }
    }

    public function getPublicationStartPhd()
    {
        if (!empty($this->dateStartPhd())) {
            return $this->hasMany(TblLnptPublicationV2::className(), ['User_Ic' => 'ICNO'])
                ->where(['ApproveStatus' => 'V'])
                ->andWhere(['>=', 'PublicationYear', date('Y', strtotime($this->dateStartPhd()))]);
        } else {
            $arr = array();
            return $arr;
        }
    }

    public function getResearchMulaLantikan()
    {

        if (!empty($this->dateStartLantikanPertama())) {
            return $this->hasMany(TblPenyelidikan2::className(), ['IC' => 'ICNO'])
                ->where(['>=', 'StartYear', date('Y', strtotime($this->dateStartLantikanPertama()))]);
        } else {
            return null;
        }
    }

    public function getResearchCompletedAfterPhd()
    {

        if (!empty($this->dateGradePhd())) {
            return $this->hasMany(TblPenyelidikan2::className(), ['IC' => 'ICNO'])
                ->where(['>=', 'StartYear', date('Y', strtotime($this->dateGradePhd()))]);
        } else {
            return null;
        }
    }

    public function getPublicationAll()
    {
        return $this->hasMany(TblLnptPublicationV2::className(), ['User_Ic' => 'ICNO'])->OrderBy(['KeteranganBI_WriterStatus' => SORT_DESC, 'PublicationYear' => SORT_DESC]);
    }

    public function PublicationSortAll()
    {
        $model = TblLnptPublicationV2::find()->where(['User_Ic' => $this->ICNO])->select('Keterangan_PublicationTypeID')->distinct()->all();
        $type = array();
        foreach ($model as $model) {
            $type[] = $model->Keterangan_PublicationTypeID;
        }

        return \app\models\cv\RefPublicationSort::find()->where(['IN', 'name', $type])->all();
    }

    public function getPublication()
    {
        return $this->hasMany(TblLnptPublicationV2::className(), ['User_Ic' => 'ICNO'])->where(['ApproveStatus' => 'V'])->OrderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getPublication2()
    {
        return $this->hasMany(TblLnptPublicationV2::className(), ['User_Ic' => 'ICNO'])->OrderBy(['PublicationYear' => SORT_DESC]);
    }

    public function getPublicationType()
    {
        return TblLnptPublicationV2::find()->select('Keterangan_PublicationTypeID')->distinct()->all();
    }

    public function PublicationSort()
    {
        $model = TblLnptPublicationV2::find()->where(['User_Ic' => $this->ICNO])->andWhere(['ApproveStatus' => 'V'])->select('Keterangan_PublicationTypeID')->distinct()->all();
        $type = array();
        foreach ($model as $model) {
            $type[] = $model->Keterangan_PublicationTypeID;
        }

        return \app\models\cv\RefPublicationSort::find()->where(['IN', 'name', $type])->all();
    }

    public function getScopus()
    {
        return $this->hasOne(RefHindex::className(), ['ic_no' => 'ICNO']);
    }

    public function getGoogleScholar()
    {
        return $this->hasOne(\app\models\cv\GoogleScholar::className(), ['ic_no' => 'ICNO']);
    }

    public function getBlendedLearning()
    {
        return $this->hasMany(\app\models\elnpt\TblBlendedLearningFarm::className(), ['username_ic_pasportNo' => 'ICNO']);
    }

    public function getBlendedLearningSmartv3()
    {
        $email = substr($this->COEmail, -11);

        if ($email == '@ums.edu.my') {
            $split = explode('@', $this->COEmail);
            $ad = $split[0];

            $model = TblBlendedLearning::find()->where(['username_AD' => $ad])->all();
        } else {
            $model = 'no_ad_ums';
        }

        return $model;
    }

    public function getBlendedLearningSmartv3byStatus($status)
    {
        $email = substr($this->COEmail, -11);

        if ($email == '@ums.edu.my') {
            $split = explode('@', $this->COEmail);
            $ad = $split[0];

            $model = TblBlendedLearning::find()->where(['username_AD' => $ad])->andWhere(['status' => $status])->all();
        } else {
            $model = 'no_ad_ums';
        }

        return $model;
    }

    public function getConsultancy()
    {
        return $this->hasMany(TblConsultancy::className(), ['ICNo' => 'ICNO']);
    }

    public function getKepakaran()
    {
        return $this->hasMany(\app\models\cv\TblExpertise::className(), ['UserID' => 'ICNO']);
    }

    public function getConsultancyClinical()
    {
        return $this->hasMany(TblConsultationClinical::className(), ['ICNo' => 'ICNO']);
    }

    public function getOutreaching()
    {
        return $this->hasMany(TblConsultation::className(), ['NoStaf' => 'COOldID']);
    }

    public function getOutreaching2()
    {
        return $this->hasMany(TblConsultation::className(), ['NoStaf' => 'COOldID'])->where(['StatusPengesahan' => 'V']);
    }

    public function getOutreachingKeahlian()
    {
        return TblConsultation::find()->OrderBy(['Keahlian' => SORT_ASC])->select('Keahlian')->distinct()->all();
    }

    public function getOutreachingLevel()
    {
        return TblConsultation::find()->OrderBy(['Peringkat' => SORT_ASC])->select('Peringkat')->distinct()->all();
    }

    public function getOutreachingStatus()
    {
        return TblConsultation::find()->OrderBy(['Status' => SORT_ASC])->select('Status')->distinct()->all();
    }

    public function getOutreachingJenisRawatan()
    {
        return TblConsultationClinical::find()->select('JenisRawatan')->distinct()->all();
    }

    public function getOutreachingClinical()
    {
        return $this->hasMany(TblConsultationClinical::className(), ['ICKakitangan' => 'ICNO'])->OrderBy(['JenisRawatan' => SORT_ASC, 'TarikhMula' => SORT_DESC]);
    }

    public function getOutreachingClinical2()
    {
        return $this->hasMany(TblConsultationClinical::className(), ['ICKakitangan' => 'ICNO'])->where(['ApproveStatus' => 'V'])->OrderBy(['JenisRawatan' => SORT_ASC, 'TarikhMula' => SORT_DESC]);
    }

    public function getOutreachingInternational()
    {
        return $this->hasMany(TblConsultation::className(), ['NoStaf' => 'COOldID'])->where(['Peringkat' => 'International'])->OrderBy(['TarikhMula' => SORT_ASC]);
    }

    public function getOutreachingInternationalSelesai()
    {
        return $this->hasMany(TblConsultation::className(), ['NoStaf' => 'COOldID'])->where(['Peringkat' => 'International'])->andWhere(['StatusPengesahan' => 'V'])->OrderBy(['TarikhMula' => SORT_ASC]);
    }

    public function getOutreachingNational()
    {
        return $this->hasMany(TblConsultation::className(), ['NoStaf' => 'COOldID'])->where(['Peringkat' => 'National'])->OrderBy(['TarikhMula' => SORT_ASC]);
    }

    public function getOutreachingNationalSelesai()
    {
        return $this->hasMany(TblConsultation::className(), ['NoStaf' => 'COOldID'])->where(['Peringkat' => 'National'])->andWhere(['StatusPengesahan' => 'V'])->OrderBy(['TarikhMula' => SORT_ASC]);
    }

    public function getOutreachingUniversity()
    {
        return $this->hasMany(TblConsultation::className(), ['NoStaf' => 'COOldID'])->where(['Peringkat' => 'University'])->OrderBy(['TarikhMula' => SORT_ASC]);
    }

    public function getOutreachingUniversitySelesai()
    {
        return $this->hasMany(TblConsultation::className(), ['NoStaf' => 'COOldID'])->where(['Peringkat' => 'University'])->andWhere(['StatusPengesahan' => 'V'])->OrderBy(['TarikhMula' => SORT_ASC]);
    }

    public function getOutreachingNoData()
    {
        return $this->hasMany(TblConsultation::className(), ['NoStaf' => 'COOldID'])->where(['Peringkat' => 'No Data'])->OrderBy(['TarikhMula' => SORT_ASC]);
    }

    public function getOutreachingNoDataSelesai()
    {
        return $this->hasMany(TblConsultation::className(), ['NoStaf' => 'COOldID'])->where(['Peringkat' => 'No Data'])->andWhere(['StatusPengesahan' => 'V'])->OrderBy(['TarikhMula' => SORT_ASC]);
    }

    public function getUserlnpt()
    {
        return $this->hasOne(TblMain::className(), ['PYD' => 'ICNO']);
    }

    public function getTeknologiInvasiLevel()
    {
        return \app\models\elnpt\elnpt2\TblTeknologiInovasi::find()->joinWith('user')->where(['elnpt_tbl_main.PYD' => $this->ICNO])->select('tahap_penyertaan')->distinct()->all();
    }

    public function getTeknologiInvasi()
    {
        return \app\models\elnpt\elnpt2\TblTeknologiInovasi::find()->joinWith('user')->where(['elnpt_tbl_main.PYD' => $this->ICNO])->all();
    }

    public function getUsercv()
    {
        return $this->hasOne(\app\models\cv\TblAppinfo::className(), ['ICNO' => 'ICNO']);
    }

    public function getUmur()
    {
        return date_create(date('Y-m-d'))->diff(date_create($this->COBirthDt))->y;
    }

    public function getUmurpanjang()
    {

        //get today's date
        $currentDate = date('Y-m-d');

        $bday = date_create($this->COBirthDt);
        $cdate = date_create($currentDate);

        $age = date_diff($bday, $cdate);

        $age2 = $age->format('%y TAHUN %m BULAN %d HARI');

        return $age2;
    }

    public function getGajiBasic()
    {
        $basic_pay = '';

        if ($this->NatStatusCd == 1) {
            $gaji = ViewPayroll::find()->where(['sm_ic_no' => $this->ICNO])->orderBy(['MPH_PAY_MONTH' => SORT_ASC])->all();
        } else {
            $gaji = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->COOldID])->orderBy(['MPH_PAY_MONTH' => SORT_ASC])->all();
        }

        if ($gaji) {
            foreach ($gaji as $gaji) {
                $basic_pay = 'RM ' . $gaji->MPH_BASIC_PAY;
            }
        } else {
            $basic_pay = '<span class="required" style="color:red;"><b>Tiada Maklumat - Sila hubungi pegawai yang bertugas.</b></span>';
        }
        return $basic_pay;
    }

    public function getGajiBasic2()
    {
        $basic_pay = '';

        if ($this->NatStatusCd == 1) {
            $gaji = ViewPayroll::find()->where(['sm_ic_no' => $this->ICNO])->all();
        } else {
            $gaji = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->COOldID])->all();
        }

        if ($gaji) {
            foreach ($gaji as $gaji) {
                $year = substr($gaji->MPH_PAY_MONTH, 0, -2);
                $month = substr($gaji->MPH_PAY_MONTH, 4);

                if ((date('Y') == $year) && (date('m') == '01') && ($month == '01')) {
                    $basic_pay = $gaji->MPH_BASIC_PAY;
                } elseif ((date('Y') == $year) && (date('m', strtotime("-1 months")) == $month)) {
                    $basic_pay = $gaji->MPH_BASIC_PAY;
                }
            }
        } else {
            $basic_pay = '<span class="required" style="color:red;"><b>Tiada Maklumat - Sila hubungi pegawai yang bertugas.</b></span>';
        }
        return $basic_pay;
    }

    //////// CUTI BELAJAR ///////

    public function getPengajian()
    {
        return $this->hasMany(TblPengajian::className(), ['icno' => 'ICNO']);
    }

    public function getGot()
    {
        $ot = LkkDean::find()->where([
            'icno' => 'icno'
        ])->andWhere(['cb_tbl_dean.dokumen' => ["16", "58"]])->one();
        return $ot;
        //        return $this->hasOne(LkkDean::className(), ['icno'=>'icno','cb_lkk_dean.dokumen'=>[16,58]]);
    }

    public function getCutipenyelidikan()
    {
        return $this->hasMany(\app\models\smp_ppi\CutiPenyelidikan::className(), ['NoKadPengenalan' => 'ICNO']);
    }

    public function getTatatertib()
    {
        return $this->hasMany(\app\models\tatatertib_staf\TblRekodTatatertib::className(), ['icno' => 'ICNO']);
    }

    public function statusTatatertib()
    {
        $model = \app\models\tatatertib_staf\TblRekodTatatertib::findOne(['icno' => $this->ICNO]);

        if (empty($model)) {
            return "Ya";
        } else {
            return "Tidak";
        }
    }

    public function getHarta()
    {
        return $this->hasOne(TblHarta::className(), ['icno' => 'ICNO'])->where(['IN', 'status', [1, 2, 4]]);
    }

    public function getPenyelia()
    {
        return $this->hasOne(\app\models\cbelajar\LkkTblPenyelia::className(), ['emel' => 'COEmail']);
    }

    public function getBiasiswa()
    {
        return $this->hasMany(TblBiasiswa::className(), ['icno' => 'ICNO']);
    }

    public function getDokumen()
    {
        return $this->hasMany(TblFilePemohon::className(), ['uploaded_by' => 'ICNO']);
    }

    public function getImg()
    {
        return $this->hasOne(TblpImage::className(), ['ICNO' => 'ICNO']);
    }

    public function getConfirmpengesahan()
    {
        return $this->hasOne(Tblrscoconfirmstatus::className(), ['ICNO' => 'ICNO'])->orderBy(['ConfirmStatusStDt' => SORT_DESC]);
    }

    public function getTarikhpengesahan()
    {

        return $this->getTarikh($this->confirmpengesahan->ConfirmStatusStDt);
    }

    //      public function getUmurbersara() {
    //        return $this->hasOne(\app\models\hronline\Retireage::className(), ['RetireAgeCd' => 'RetireAgeCd']);
    //    }
    public function getStatusperkhidmatan()
    {

        return $this->confirmpengesahan->ConfirmStatusNm;
    }

    public function getMulaLantikan()
    {
        return $this->hasOne(Tblrscoapmtstatus::className(), ['ICNO' => 'ICNO']);
    }

    public function getTarikhDilantik()
    {
        return $this->hasOne(Tblrscoconfirmstatus::className(), ['ICNO' => 'ICNO'])->where(['ConfirmStatusCd' => [2]]);
    }

    public function getSahJawatan()
    {
        return $this->hasOne(Tblrscoconfirmstatus::className(), ['ICNO' => 'ICNO'])->where(['ConfirmStatusCd' => [1]]);
    }

    public function getTarikhDilantikPerkhidmatan()
    {
        return $this->hasOne(Tblrscoapmtstatus::className(), ['ICNO' => 'ICNO'])->where(['ApmtStatusCd' => [1, 51]]);
    }

    public function getKakitangans()
    {
        return $this->hasOne(Tblkeluarga::className(), ['FamilyId' => 'ICNO'])->where(['RelCd' => [02, 01]]);
    }

    public function getContoh()
    {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gredJawatan'])->where(['job_category' => 2]);
    }

    //    public function getTempoh(){
    //        $model = Tblrscoapmtstatus::find()->where(['ICNO' => $this->ICNO])->min('ApmtStatusStDt');
    //        $date1= date_create($model);
    //        $date2= $this->job_category == 1? date_create($this->kakitangan->endDateLantik):date_create($this->endDateLantik);
    //        $tempoh = date_diff($date1, $date2)->format('%y Tahun %m Bulan');
    //        //$tempoh = round($tempo/365, 1);
    //        return $tempoh;
    //    }
    public function getTempohkhidmat()
    {
        $model = Tblrscoapmtstatus::find()->where(['ICNO' => $this->ICNO])->min('ApmtStatusStDt');
        $date1 = date_create($model);
        $date2 = date_create(date('Y-m-d'));
        $tempoh = date_diff($date1, $date2)->format('%y Tahun %m Bulan');
        //$tempoh = round($tempo/365, 1);
        return $tempoh;
    }

    public function getTempohperkhidmatan()
    {
        $model = Tblrscoapmtstatus::find()->where(['ICNO' => $this->ICNO])->min('ApmtStatusStDt');
        $date1 = date_create($model);
        $date2 = date_create($this->endDateLantik);
        $tempoh = date_diff($date1, $date2)->format('%y Tahun %m Bulan');
        //$tempoh = round($tempo/365, 1);
        return $tempoh;
    }

    public function getIdp()
    {
        return $this->hasOne(\app\models\myidp\Idp::className(), ['v_co_icno' => 'ICNO']);
    }

    public function getTarikhLahir()
    {
        return $this->getTarikh($this->COBirthDt);
    }

    public function getJabatanSemasa2()
    {
        return $this->hasOne(TblPenempatan::className(), ['ICNO' => 'ICNO']);
    }

    public function carianCuti($params)
    {
        $query = Tblprcobiodata::find();
        $icno = Yii::$app->user->getId();
        $access = AksesPengguna::find()->where(['akses_cuti_icno' => Yii::$app->user->getId()])->all();
        foreach ($access as $a) {
            // $arr = [];
            $arr[] = $a->akses_jspiu_id;
            $arr2[] = $a->akses_kampus_id;
            $arr3[] = $a->akses_cuti_int;
        }
        if (in_array("3", $arr3)) {
            $query = Tblprcobiodata::find();
        } else {
            $query->andFilterWhere(['IN', 'DeptId', $arr])->andFilterWhere(['IN', 'campus_id', $arr2]);
        }

        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }
        switch ($this->jenis_carian) {
            case '1':
                $query->andFilterWhere(['like', 'ICNO', $this->carian_data]);

                break;
            case '2':
                $query->andFilterWhere(['like', 'COOldID', $this->carian_data]);
                break;
            default:
                $query->andFilterWhere(['like', 'CONm', $this->carian_data]);

                break;
        }
        // var_dump($this->carian_gred);die;
        if (!empty($this->carian_department)) {
            $query->andFilterWhere([
                'DeptId' => $this->carian_department,
            ]);
        }
        if (!empty($this->carian_pendidikantertinggi)) {
            $query->andFilterWhere([
                'HighestEduLevelCd' => $this->carian_pendidikantertinggi,
            ]);
        }
        if (!empty($this->carian_status)) {
            $query->andFilterWhere([
                'Status' => $this->carian_status,
            ]);
        } else {
            $query->andFilterWhere([
                '!=', 'Status', 6
            ]);
        }

        if (!empty($this->carian_statuslantikan)) {
            $query->andFilterWhere([
                'statLantikan' => $this->carian_statuslantikan,
            ]);
        }
        if (!empty($this->carian_programpengajaran)) {
            $query->andFilterWhere([
                'KodProgram' => $this->carian_programpengajaran,
            ]);
        }
        if (!empty($this->carian_kampus)) {
            $query->andFilterWhere([
                'campus_id' => $this->carian_kampus,
            ]);
        }
        if (!empty($this->carian_gred)) {
            $query->andFilterWhere([
                'gredJawatan' => $this->carian_gred,
            ]);
        }

        return $dataProvider;
    }

    public function carianARP($params)
    {
        $query = Tblprcobiodata::find();

        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query->andFilterWhere(['!=', 'Status', 06]),
        ]);

        if (is_null($params) || empty($params)) {
            $query->where('0 = 1');
            return $dataProvider;
        }

        if (!$this->validate()) {
            $query->where('0=1');

            return $dataProvider;
        }

        switch ($this->jenis_carian) {
            case '1':
                $query->andFilterWhere(['like', 'CONm', $this->carian_data]);
                break;
            default:
                $query->andFilterWhere(['like', 'ICNO', $this->carian_data]);
                break;
        }

        return $dataProvider;
    }

    public function carian2($params)
    {
        $query = Tblprcobiodata::find()
            ->where(['tblprcobiodata.Status' => 1])
            ->joinWith('jabatanSemasa2 as p')
            ->joinWith('jawatan as j')
            ->joinWith('department as d')
            ->andWhere("p.dept_id = tblprcobiodata.DeptId")
            ->andWhere("j.job_category != 1") //$biodata->jawatan->job_group
            ->andWhere("d.pp != tblprcobiodata.ICNO")
            ->andWhere("d.chief != tblprcobiodata.ICNO");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 2000,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        switch ($this->jenis_carian) {
            case '1':
                $query->andFilterWhere(['like', 'CONm', $this->carian_data]);
                break;
            case '2':
                $query->andFilterWhere(['like', 'COOldID', $this->carian_data]);
                break;
            default:
                $query->andFilterWhere(['like', 'ICNO', $this->carian_data]);
                break;
        }

        if (!empty($this->carian_department)) {
            $query->andFilterWhere([
                'DeptId' => $this->carian_department,
            ]);
        }

        if (!empty($this->carian_jawatan)) {
            $query->andFilterWhere([
                'gredJawatan' => $this->carian_jawatan,
            ]);
        }
        return $dataProvider;
    }

    //Staff Akses utk lnpt pentadbiran
    public function getStaffAkses()
    {
        return $this->hasOne(TblStafAkses::className(), ['ICNO' => 'ICNO'])->from(['StafAkses' => TblStafAkses::tableName()]);
    }

    //log for Create, update or delete data.
    // public function beforeSave1($insert)
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['ICNO' => $this->ICNO]);
        $attrib = $this->activeAttributes();

        switch ($insert) {
            case (false):
                $activity = 1;
                for ($i = 0; $i < count($attrib); $i++) {

                    if ($tempObj->{$attrib[$i]} != $this->{$attrib[$i]}) {
                        array_push($changes, [$attrib[$i], $tempObj->{$attrib[$i]}, $this->{$attrib[$i]}]);
                    }
                }
                break;

            default:
                //aftersave will handle it
                break;
        }
        if (count($changes) > 0) {
            //log activity to updatestatus table
            $log = new Updatestatus();
            $log->usern = $tempObj->ICNO; //Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            if (Yii::$app->user->getId()) {
                $log->COUpdateIP = Yii::$app->request->getRemoteIP();
                $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            } else {
                $log->COUpdateIP = yii::$app->controller->id;
                $log->COUpdateComp = yii::$app->controller->id;
            }
            $log->COUpdateCompUser = Yii::$app->user->getId() ? Yii::$app->user->getId() : yii::$app->controller->id;
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->ICNO;
            $log->save(false);

            //save to tbl_stat
            $stat = Tblstat::find()->where(['ICNO' => $this->ICNO, 'table' => $this->tableName(), 'idval' => $this->ICNO])->one();
            if ($stat == null) {
                $stat = new Tblstat();
                $stat->ICNO = $this->ICNO;
                $stat->table = $this->tableName();
                $stat->idval = $this->ICNO;
            }
            $stat->status = 1;
            $stat->date_submit = date('Y-m-d H:i:s');
            $stat->save(false);

            //-- biodata last update --//
            $this->last_update = date('Y-m-d h:i:s');
            $this->kemaskini_terakhir = date('Y-m-d h:i:s');
            $this->last_updater = Yii::$app->user->getId() ? Yii::$app->user->getId() : yii::$app->controller->id;
        }

        return true;
    }

    // public function afterSave1($insert, $changedAttributes)
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            //save to tbl_stat
            $stat = new Tblstat();
            $stat->ICNO = $this->ICNO;
            $stat->table = $this->tableName();
            $stat->idval = $this->ICNO;
            $stat->status = 0;
            $stat->date_submit = date('Y-m-d H:i:s');
            $stat->save(false);

            $changes = [];
            //$tempObj = self::findOne(['id' => $this->id]);
            $attrib = $this->activeAttributes();
            $activity = 0;

            for ($i = 0; $i < count($attrib); $i++) {
                array_push($changes, [$attrib[$i], $this->{$attrib[$i]}]);
            }

            $log = new Updatestatus();
            $log->usern = $this->ICNO; //Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId();
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->ICNO;
            $log->save(false);

            //-- biodata last update --//
            $this->last_update = date('Y-m-d h:i:s');
            $this->kemaskini_terakhir = date('Y-m-d h:i:s');
            $this->last_updater = Yii::$app->user->getId() ? Yii::$app->user->getId() : yii::$app->controller->id;
        }

        $_actionLantikan = ['lantikstafbaru', 'lantikphs', 'lantikkhas', 'lantikpli'];
        if (in_array($this->_action, $_actionLantikan)) {
            $res = Yii::$app->ActiveDirectory->Add($this->ICNO);
            if ($res->status == false) {
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Emel rasmi gagal dijana. Sila hubungi pentadbir sistem untuk penjanaan emel secara manual. ']);
                //$this->COEmail = null;
                $this->save(false);
            }

            //insert to pengurusan akses//
            $pa = new TblPapSenaraiStaf();
            $pa->icno = $this->ICNO;
            $pa->nama = $this->CONm;
            $pa->jfpib = $this->department->fullname;
            $pa->sebab_perubahan = 'Lantikan Baru';
            $pa->tarikh_ubah = date('Y-m-d H:i:s');
            $pa->tarikh_kuatkuasa = date('Y-m-d H:i:s');
            if ($pa->save(false)) {
                $staf_incharge = TblPapAkses::find()->where(['pap_ja_id' => 4])->all();
                foreach ($staf_incharge as $si) {
                    $res = Yii::$app->MP->SendNotification([
                        'icno' => $si->icno,
                        'title' => 'Permohonan Emel Ums untuk staf baru.',
                        'content' => "Sila semak senarai permohonan emel seperti berikut:
                            <p>                                      </p>
                            <p>1. Pada menu sisi, tekan <b>'Pengurusan Akses'</b>.</p>
                            <p>2. Tekan <b>'Permohonan Emel'</b>.</p>",
                        'date' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        return true;
    }

    // public function beforeDelete1()
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $changes = [];

        //get list of attributes
        $attrib = $this->activeAttributes();

        for ($i = 0; $i < count($attrib); $i++) {
            array_push($changes, array($attrib[$i], $this->{$attrib[$i]}));
        }
        //log activity to updatestatus table
        $log = new Updatestatus();
        $log->usern = $this->ICNO;
        $log->COTableName = $this->tableName();
        $log->COActivity = 2;
        $log->COUpadteDate = date('Y-m-d H:i:s');
        $log->COUpdateIP = Yii::$app->request->getRemoteIP();
        $log->COUpdateComp = Yii::$app->request->getRemoteIP();
        $log->COUpdateCompUser = Yii::$app->user->getId();
        $log->COUpdateSQL = serialize($changes);
        $log->save(false);
        $stat = Tblstat::find()->where(['ICNO' => $this->ICNO, 'table' => $this->tableName(), 'idval' => $this->ICNO])->one();
        if ($stat == null)
            return true;

        $stat->delete();

        return true;
    }

    protected function findModel($icno)
    {
        if (($model = Tblprcobiodata::findOne($icno)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function getLatestPaspot()
    {
        $model = Tblpasport::find()->where(['ICNO' => $this->ICNO])->orderBy(['id' => SORT_DESC])->one();

        return $model ? $model->PassportNo : '';
    }

    /*     * Tblprcobiodata and RptStatistikIdpV2 relation' * */

    public function getStatistik()
    {
        return $this->hasMany(RptStatistikIdpV2::className(), ['icno' => 'ICNO']);
    }

    /*     * get 'tempoh perkhidmatan di gred semasa' * */

    public function getTempohKhidmatGredSemasa()
    {
        $currentDate = date('Y-m-d');

        $modelSandangan = Tblrscosandangan::find()
            ->where(['ICNO' => $this->ICNO, 'gredjawatan' => $this->gredJawatan])
            ->orderBy(['start_date' => SORT_ASC])
            ->one();

        if ($modelSandangan) {

            /** updated 17/08/2022 */
            /*
             *  for case where the staff have been 'Tukar Lantik'
             *  because previous jawatan has been Jumud
             *  check whether his ApmtTypeCd = '09'
             *  if yes, take the previous row in table
             *  if no, take the current row
             * 
             */

            if ($modelSandangan->ApmtTypeCd == '09') {

                $modelSandangan = Tblrscosandangan::find()
                    ->where(['ICNO' => $this->ICNO])
                    ->andWhere(['<', 'start_date', $modelSandangan->start_date])
                    ->orderBy(['start_date' => SORT_ASC])
                    ->one();
            }

            $datetime1 = date_create($modelSandangan->start_date);
            $datetime2 = date_create($currentDate);

            $tempohKhidmat = date_diff($datetime1, $datetime2);

            $tempohKhidmat2 = $tempohKhidmat->format('%y TAHUN %m BULAN %d HARI');
        } else {
            $tempohKhidmat2 = 'SILA BERHUBUNG DENGAN BAHAGIAN SUMBER MANUSIA BAGI MENGEMASKINI REKOD SANDANGAN ANDA';
        }

        return $tempohKhidmat2;
    }

    /*     * get 'tahap' * */

    public function getTahapKhidmat()
    {

        $userID = Yii::$app->user->getId();

        // $model = Tblprcobiodata::findByUsername($userID);
        $model = User::findByUsername($userID);

        //get today's date
        $currentDate = date('Y-m-d');

        //get 'tarikh sandangan bagi gred terkini' from database
        //function date_create() return a new DateTime object - if omitted, the date will be read as a string - DKW
        $modelSandangan = Tblrscosandangan::find()
            ->where(['ICNO' => $this->ICNO, 'gredjawatan' => $this->gredJawatan])
            ->orderBy(['start_date' => SORT_ASC])
            ->one();

        if ($modelSandangan) {

            if ($modelSandangan->ApmtTypeCd == '09') {

                $modelSandangan = Tblrscosandangan::find()
                    ->where(['ICNO' => $this->ICNO])
                    ->andWhere(['<', 'start_date', $modelSandangan->start_date])
                    ->orderBy(['start_date' => SORT_ASC])
                    ->one();
            }

            $datetime1 = date_create($modelSandangan->start_date);
            $datetime2 = date_create($currentDate);

            //date_diff() function calculate the difference two dates
            $tempohKhidmat = date_diff($datetime1, $datetime2);

            //format the date difference
            $tempohKhidmat2 = $tempohKhidmat->format('%y');

            if ($tempohKhidmat2 >= 7) {
                //$tahap='LANJUTAN';
                return '3';
            } else if (($tempohKhidmat2 < 7) && ($tempohKhidmat2 >= 3)) {
                //$tahap='PERTENGAHAN';
                return '2';
            } else {
                //$tahap='ASAS';
                return '1';
            }
        } else {
            //$tempohKhidmat2 = 'SILA BERHUBUNG DENGAN BAHAGIAN SUMBER MANUSIA BAGI MENGEMASKINI REKOD SANDANGAN ANDA';
            return '0';
        }
    }

    /*     * get 'tahap' * */

    public function tahapKhidmatStaf($userID)
    {

        //$userID = Yii::$app->user->getId();
        // $model = Tblprcobiodata::findByUsername($userID);
        $model = User::findByUsername($userID);

        //get today's date
        $currentDate = date('Y-m-d');

        $modelSandangan = Tblrscosandangan::find()
            ->where(['ICNO' => $this->ICNO, 'gredjawatan' => $this->gredJawatan])
            ->orderBy(['start_date' => SORT_ASC])
            ->one();

        $datetime1 = date_create($modelSandangan->start_date);
        $datetime2 = date_create($currentDate);

        $tempohKhidmat = date_diff($datetime1, $datetime2);

        $tempohKhidmat2 = $tempohKhidmat->format('%y');

        if ($tempohKhidmat2 >= 7) {
            //$tahap='LANJUTAN';
            return '3';
        } else if (($tempohKhidmat2 < 7) && ($tempohKhidmat2 >= 3)) {
            //$tahap='PERTENGAHAN';
            return '2';
        } else {
            //$tahap='ASAS';
            return '1';
        }
    }

    //cv

    public function getCvPublication()
    {
        return $this->hasMany(\app\models\cv\TblPublication::className(), ['ICNO' => 'ICNO'])->where(['deleted' => 0])->orderBy(['year' => SORT_DESC]);
    }

    public function getCvResearch()
    {
        return $this->hasMany(\app\models\cv\TblResearch::className(), ['ICNO' => 'ICNO'])->where(['deleted' => 0])->orderBy(['start_date' => SORT_DESC]);
    }

    public function getCvConferences()
    {
        return $this->hasMany(\app\models\cv\TblConferences::className(), ['ICNO' => 'ICNO'])->where(['deleted' => 0])->orderBy(['start_date' => SORT_DESC]);
    }

    public function getSahHarta()
    {
        return $this->hasOne(\app\models\harta\TblHarta::className(), ['ICNO' => 'ICNO'])->where(['IN', 'status', [1, 2, 4]]); // asal sdh mohon
    }

    public function findAnugerah($id)
    {
        return Tblanugerah::find()->where(['ICNO' => $this->ICNO])->andWhere(['AwdCd' => $id])->one();
    }

    public function findPenilaianPengajaran($ic)
    {

        $model = \app\models\elnpt\elnpt2\PenilaianKursusPK07::find()
            ->where(['NoIC' => $ic])
            ->andWhere(['>', 'FinalMean', 3.5])
            ->one();

        $FinalMean = 0;
        if ($model) {
            $FinalMean = $model->FinalMean;
        }
        return $FinalMean;
    }

    public function getSandangan()
    {
        return $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->where(['sandangan_id' => 1])->orderBy(['start_date' => SORT_DESC])->one();
    }

    public function getSandanganCTetap()
    { //cv
        return $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->where(['sandangan_id' => 1])->andWhere(['gredjawatan' => $this->gredJawatan])->orderBy(['start_date' => SORT_ASC])->one();
    }

    public function getSandanganCKontrak()
    { //cv
        return $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->andWhere(['gredjawatan' => $this->gredJawatan])->orderBy(['start_date' => SORT_ASC])->one();
    }

    public function getAllSandangan()
    {
        return $this->hasMany(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->orderBy(['start_date' => SORT_DESC]);
    }

    public function getPenempatan()
    {
        return $this->hasOne(TblPenempatan::className(), ['ICNO' => 'ICNO'])->orderBy(['date_start' => SORT_DESC])->one();
    }

    public function getAllPenempatan()
    {
        return $this->hasMany(TblPenempatan::className(), ['ICNO' => 'ICNO'])->orderBy(['date_start' => SORT_DESC]);
    }

    public function getConfirmDt()
    {
        return $this->hasOne(Tblrscoconfirmstatus::className(), ['ICNO' => 'ICNO'])->where(['ConfirmStatusCd' => 1])->one(); //Disahkan Dalam Perkhidmatan
    }

    public function getServPeriod($gred, $type)
    { //kenaikan pangkat
        if (in_array($gred, [10, 11, 220, 257, 415, 22])) { // cari tempoh sandangan shja
            if ($gred == 11) { //'DS54'
                $gredKriteria = array(13, 14); //DS 51 & DS 52
            } elseif ($gred == 10) { //'VK7' gred C
                $gredKriteria = array(11, 12); //DS 53,54
            } elseif ($gred == 220) { //'DG48'
                $gredKriteria = array(205); //DG 44
            } elseif ($gred == 257) { //'DG52'
                $gredKriteria = array(220); //DG 48
            } elseif ($gred == 415) { //'DU56'
                $gredKriteria = array(19, 265); //DU 54 (gelaran &tidak)
            } elseif ($gred == 22) { // 'DU51'
                $gredKriteria = array(223); //DU51P
            }
            $model = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])
                ->where(['sandangan_id' => 1])
                ->andWhere(['IN', 'gredjawatan', $gredKriteria])
                ->orderBy(['start_date' => SORT_DESC])->one();

            return $this->findTempoh($model, $type);
        }
        if ($gred == 13) { //'DS52'
            //tarikh grade phd
            $phd = Tblpendidikan::find()
                ->where(['ICNO' => $this->ICNO])
                ->andWhere(['HighestEduLevelCd' => 1])
                ->orderBy(['ConfermentDt' => SORT_ASC])->one();

            $lantikan = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])
                ->where(['sandangan_id' => 1])
                ->orderBy(['start_date' => SORT_ASC])->one(); //sandangan pertama

            if (!empty($phd) && !empty($lantikan)) {

                if (strtotime($phd->ConfermentDt) <= strtotime($lantikan->start_date)) {
                    if ($type == 'Tempoh') {
                        return date_diff(date_create($lantikan->start_date), date_create(date('Y-m-d')))->format('%y Tahun, %m Bulan, %d Hari');
                    } elseif ($type == 'Kriteria') {
                        return date_diff(date_create($lantikan->start_date), date_create(date('Y-m-d')))->format('%y');
                    }
                } elseif (strtotime($phd->ConfermentDt) > strtotime($lantikan->start_date)) {
                    if ($type == 'Tempoh') {
                        return date_diff(date_create($phd->ConfermentDt), date_create(date('Y-m-d')))->format('%y Tahun, %m Bulan, %d Hari');
                    } elseif ($type == 'Kriteria') {
                        return date_diff(date_create($phd->ConfermentDt), date_create(date('Y-m-d')))->format('%y');
                    }
                }
            } else {
                if ($type == 'Tempoh') {
                    return '-';
                } elseif ($type == 'Kriteria') {
                    return 0;
                }
            }
        }
        if ($gred == 205) { //'DG44'
            $sarjana = Tblpendidikan::find()
                ->where(['ICNO' => $this->ICNO])
                ->andWhere(['IN', 'HighestEduLevelCd', [3, 4, 5, 6, 20]])
                ->orderBy(['ConfermentDt' => SORT_ASC])->one();

            $lantikan = Tblrscosandangan::find()
                ->where(['ICNO' => $this->ICNO])
                ->andWhere(['sandangan_id' => 1])
                ->andWhere(['gredjawatan' => 25]) //DG41
                ->orderBy(['start_date' => SORT_ASC])->one();

            if ($sarjana) { //master
                $tempoh = 'SARJANA: ' . $sarjana->ConfermentDt;
                $status = 'YA';
            } elseif ($lantikan) {
                $tempoh = date_diff(date_create($lantikan->start_date), date_create(date('Y-m-d')))->format('%y Tahun, %m Bulan, %d Hari');
                if (date_diff(date_create($lantikan->start_date), date_create(date('Y-m-d')))->format('%y') >= 5) {
                    $status = 'YA';
                } else {
                    $status = 'TIDAK';
                }
            } else {
                $tempoh = '-';
                $status = 'TIDAK';
            }

            if ($type == 'Tempoh') {
                return $tempoh;
            } elseif ($type == 'Kriteria') {
                return $status;
            }
        }
        if ($gred == 99) { //semua jawatan pentadbiran
            $model = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->where(['sandangan_id' => 1])->andWhere(['gredjawatan' => $this->gredJawatan])->orderBy(['start_date' => SORT_ASC])->one();
            $tempoh = 0;
            if ($model) {
                $date1 = date_create($model->start_date);
                $date2 = date_create(date('Y-m-d'));
                $tempoh = date_diff($date1, $date2)->format('%y Tahun %m Bulan %d Hari');
                $kriteria = date_diff($date1, $date2)->format('%y');
            }

            if (in_array($this->jawatan->gred, ['VK5', 'VK6', 'VK7', 'VU5', 'VU6', 'VU7'])) {
                $model = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->where(['sandangan_id' => 1])->andWhere(['!=', 'gredjawatan', $this->gredJawatan])->orderBy(['start_date' => SORT_DESC])->one();
                $dateEnd = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->orderBy(['start_date' => SORT_DESC])->one();
                $date1 = date_create($model->start_date);
                $date2 = date_create($dateEnd->start_date);
                $tempoh = date_diff($date1, $date2)->format('%y Tahun %m Bulan %d Hari');
                $kriteria = date_diff($date1, $date2)->format('%y');
            }

            if ($type == 'Tempoh') {
                return $tempoh;
            } elseif ($type == 'Kriteria') {
                return $kriteria;
            }
        }
    }

    public function findTempoh($model, $type)
    {
        if ($model) {
            $date1 = date_create($model->start_date);
            $date2 = date_create(date('Y-m-d'));
            if ($type == 'Tempoh') {
                $tempoh = date_diff($date1, $date2)->format('%y Tahun, %m Bulan, %d Hari');
            } elseif ($type == 'Kriteria') {
                $tempoh = date_diff($date1, $date2)->format('%y');
            }
        } else {
            if ($type == 'Tempoh') {
                $tempoh = '-';
            } elseif ($type == 'Kriteria') {
                $tempoh = 0;
            }
        }
        return $tempoh;
    }

    public function getServPeriodPermanent()
    {
        if ($this->statLantikan == 1) {
            $model = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->where(['sandangan_id' => 1])->orderBy(['start_date' => SORT_ASC])->one();
        } else {
            $model = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->orderBy(['start_date' => SORT_ASC])->one();
        }

        if ($model) {
            $date1 = date_create($model->start_date);
            $date2 = date_create(date('Y-m-d'));
            $tempoh = date_diff($date1, $date2)->format('%y Tahun, %m Bulan, %d Hari');
        } else {
            $tempoh = '-';
        }
        return $tempoh;
    }

    public function getServPeriodKontrak($type)
    { //cv
        $model = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])
            ->orderBy(['start_date' => SORT_ASC])->one();
        return $this->findTempoh($model, $type);
    }

    public function getServPeriodCPosition()
    {
        $model = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->where(['sandangan_id' => 1])->andWhere(['gredjawatan' => $this->gredJawatan])->orderBy(['start_date' => SORT_ASC])->one();
        if ($model) {
            $date1 = date_create($model->start_date);
            $date2 = date_create(date('Y-m-d'));
            $tempoh = date_diff($date1, $date2)->format('%y Tahun, %m Bulan, %d Hari');
        } else {
            $tempoh = '-';
        }
        return $tempoh;
    }

    public function getServPeriodPermanentBI()
    {
        if ($this->statLantikan == 1) {
            $model = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->where(['sandangan_id' => 1])->orderBy(['start_date' => SORT_ASC])->one();
        } else {
            $model = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->orderBy(['start_date' => SORT_ASC])->one();
        }

        if ($model) {
            $date1 = date_create($model->start_date);
            $date2 = date_create(date('Y-m-d'));
            $tempoh = date_diff($date1, $date2)->format('%y Year, %m Month, %d Day');
        } else {
            $tempoh = '-';
        }
        return $tempoh;
    }

    public function getServPeriodCPositionBI()
    {

        if ($this->statLantikan == 1) {
            $model = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->where(['sandangan_id' => 1])->andWhere(['gredjawatan' => $this->gredJawatan])->orderBy(['start_date' => SORT_ASC])->one();
        } else {
            $model = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->andWhere(['gredjawatan' => $this->gredJawatan])->orderBy(['start_date' => SORT_ASC])->one();
        }


        if ($model) {
            $date1 = date_create($model->start_date);
            $date2 = date_create(date('Y-m-d'));
            $tempoh = date_diff($date1, $date2)->format('%y Year, %m Month, %d Day');
        } else {
            $tempoh = '-';
        }
        return $tempoh;
    }

    public function getServPeriodCPositionYear()
    {
        $model = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->where(['sandangan_id' => 1])->orderBy(['start_date' => SORT_DESC])->one();
        if ($model) {
            $date1 = date_create($model->start_date);
            $date2 = date_create(date('Y-m-d'));
            $tempoh = date_diff($date1, $date2)->format('%y');
        } else {
            $tempoh = '-';
        }
        return $tempoh;
    }

    public function getCountServPeriod()
    {
        $model = $this->hasOne(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])->orderBy(['start_date' => SORT_ASC])->one();
        if ($model) {
            $date1 = date("Y", strtotime($model->start_date));
            $date2 = date('Y', strtotime('now'));
            $tempoh = $date2 - $date1;
        } else {
            $tempoh = '-';
        }
        return $tempoh;
    }

    public function getIdpMinimum($icno, $year)
    {
        if ($year < 2020) {
            return \app\models\myidp\RptStatistikIdpLama::find()->where(['icno' => $icno, 'tahun' => $year])->one();
        } else {
            return \app\models\myidp\RptStatistikIdp::find()->where(['icno' => $icno, 'tahun' => $year])->one();
        }
    }

    public function getIdpStatus($model)
    {
        if ($model) {
            if ($model->idp_mata_min == $model->jum_mata_dikira) {
                return 'Meet the minimum points';
            } else {
                return 'Does not meet the minimum points';
            }
        } else {
            return '-';
        }
    }

    public function getIdpMinPoint()
    {
        return $this->hasMany(\app\models\myidp\Idp::className(), ['v_co_icno' => 'ICNO']);
    }

    public function getIdpPoint()
    { //2019
        return $this->hasMany(\app\models\hronline\Vcpdlatihan::className(), ['vcl_id_staf' => 'ICNO']);
    }

    public function getIdpKehadiran()
    { //2020
        return $this->hasMany(\app\models\myidp\Kehadiran::className(), ['staffID' => 'ICNO']);
    }

    //kontrak
    public function kehadiran($year, $type, $status = null)
    { //$status=approve klu mau data sdh d approved
        $val = 0;
        $icno = $this->ICNO;
        $staff_keselamatan = TblStaffKeselamatan::find()->where(['staff_icno' => $this->ICNO])->andWhere(['=', 'isExcluded', '0'])->exists();

        $sql = $staff_keselamatan ? \app\models\keselamatan\TblRekod::find()->where('icno="' . $icno . '" AND YEAR(tarikh)=' . $year) : \app\models\kehadiran\TblRekod::find()->where('icno="' . $icno . '" AND YEAR(tarikh)=' . $year);

        $status == 'approve' ? $sql->andWhere(['remark_status' => 'APPROVED']) : $sql->andWhere(['<>', 'remark_status', 'APPROVED']);

        if ($type == 1) {
            $staff_keselamatan ? $sql->andWhere('status_in IS NOT NULL') : $sql->andWhere(['late_in' => 1]);
        } elseif ($type == 2) {
            $staff_keselamatan ? $sql->andWhere('status_out IS NOT NULL') : $sql->andWhere(['early_out' => 1]);
        } elseif ($type == 3) {
            $sql->andWhere('incomplete = 1');
        } elseif ($type == 4) {
            $sql->andWhere('absent = 1');
        } elseif ($type == 5) {
            $sql->andWhere('external = 1');
        }

        if ($sql) {
            $val = count($sql->all());
        }
        return $val;
    }

    public function getKategoriLatihan()
    {
        return \app\models\hronline\Rcpdkategori::find()->all();
    }

    public function getKompetensiAcademic()
    {
        return \app\models\myidp\Kategori::findAll(['academic' => 1]);
    }

    public function getKompetensiAdmin()
    {
        return \app\models\myidp\Kategori::findAll(['admin' => 1]);
    }

    public function getKategoriTeaching()
    {
        return \app\models\cv\RefPengajaran::find()->all();
    }

    public function getResearchRole()
    {
        return \app\models\cv\RefResearchRole::find()->all();
    }

    public function getConferenceRole()
    {
        return \app\models\cv\RefConferenceRole::find()->all();
    }

    public function getInovasiRole()
    {
        return \app\models\cv\RefInovasiRole::find()->all();
    }

    public function getOutreachingPeringkat()
    {
        return \app\models\cv\RefOureachingPeringkat::find()->all();
    }

    public function getAsPanel()
    {
        return $this->hasMany(\app\models\cv\TblPanel::className(), ['ICNO' => 'ICNO']);
    }

    public function getEsteem()
    {
        return $this->hasMany(\app\models\cv\TblPanel::className(), ['ICNO' => 'ICNO'])->where(['!=', 'type', 13]);
    }

    public function getExaminer()
    {
        return $this->hasMany(\app\models\cv\TblPanel::className(), ['ICNO' => 'ICNO'])->where(['type' => 13]);
    }

    public function getServiceCommunity()
    {
        return $this->hasMany(\app\models\cv\TblSwSociety::className(), ['ICNO' => 'ICNO']);
    }

    public function getServiceUniversity()
    {
        return $this->hasMany(\app\models\cv\TblSwUniversity::className(), ['ICNO' => 'ICNO']);
    }

    public function getServiceUniversityLevel()
    {
        return \app\models\cv\RefSwUniversity::find()->select('output,id')->distinct()->all();
    }

    public function getPenyeliaan()
    {
        return $this->hasMany(\app\models\elnpt\TblPenyeliaan::className(), ['NoKpPenyelia' => 'ICNO']);
    }

    public function getPenyeliaan2()
    {
        return $this->hasMany(\app\models\cv\TblPenyeliaan::className(), ['SMP28_KP' => 'ICNO']);
    }

    public function getPenyeliaanStatusBM()
    {
        return \app\models\cv\TblPenyeliaan::find()->OrderBy('StatusBM')->select('StatusBM')->distinct()->all();
    }

    public function getPenyeliaanModLevelName()
    {
        return \app\models\cv\TblPenyeliaan::find()->select('ModLevelName')->distinct()->all();
    }

    public function getPenyeliaan2PHDModCampuran()
    {
        return $this->hasMany(\app\models\cv\TblPenyeliaanModCampuran::className(), ['SMP28_KP' => 'ICNO'])->where(['ModLevelName' => 'PHD'])->OrderBy(['DateAdded' => SORT_DESC]);
    }

    public function getPenyeliaan2MASTERModCampuran()
    {
        return $this->hasMany(\app\models\cv\TblPenyeliaanModCampuran::className(), ['SMP28_KP' => 'ICNO'])->where(['ModLevelName' => 'MASTER'])->OrderBy(['DateAdded' => SORT_DESC]);
    }

    public function getPenyeliaan2PHDLuar()
    {
        return $this->hasMany(\app\models\cv\TblPenyeliaanLuar::className(), ['SMP28_KP' => 'ICNO'])->where(['Peringkat' => 'PHD'])->andWhere(['IsAccepted' => 1])->andWhere(['IsGraduated' => 1])->OrderBy(['DateReviewed' => SORT_DESC]);
    }

    public function getPenyeliaan2MASTERLuar()
    {
        return $this->hasMany(\app\models\cv\TblPenyeliaanLuar::className(), ['SMP28_KP' => 'ICNO'])->where(['Peringkat' => 'MASTER'])->andWhere(['IsAccepted' => 1])->andWhere(['IsGraduated' => 1])->OrderBy(['DateReviewed' => SORT_DESC]);
    }

    public function getPenyeliaanPHD()
    {
        return $this->hasMany(\app\models\cv\TblPenyeliaanMain::className(), ['SMP28_KP' => 'ICNO'])->where(['ModLevelName' => 'PHD'])->OrderBy(['TahunKonvokesyen' => SORT_DESC]);
    }

    public function getPenyeliaanMASTER()
    {
        return $this->hasMany(\app\models\cv\TblPenyeliaanMain::className(), ['SMP28_KP' => 'ICNO'])->where(['ModLevelName' => 'MASTER'])->OrderBy(['TahunKonvokesyen' => SORT_DESC]);
    }

    public function getPenyeliaan2PHD()
    {
        return $this->hasMany(\app\models\cv\TblPenyeliaan::className(), ['SMP28_KP' => 'ICNO'])->where(['ModLevelName' => 'PHD'])->OrderBy(['DateAdded' => SORT_DESC]);
    }

    public function getPenyeliaan2MASTER()
    {
        return $this->hasMany(\app\models\cv\TblPenyeliaan::className(), ['SMP28_KP' => 'ICNO'])->where(['ModLevelName' => 'MASTER'])->OrderBy(['DateAdded' => SORT_DESC]);
    }

    public function getPenyeliaan2PHIL()
    {
        return $this->hasMany(\app\models\cv\TblPenyeliaan::className(), ['SMP28_KP' => 'ICNO'])->where(['ModLevelName' => 'M.Phil.'])->OrderBy(['DateAdded' => SORT_DESC]);
    }

    public function getPengajaran()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO']);
    }

    public function getPengajaranKategoriPelajar()
    {
        return \app\models\elnpt\TblPengajaran::find()->select('KATEGORIPELAJAR')->distinct()->all();
    }

    public function getPengajaranKategoriSelf()
    {
        return \app\models\elnpt\TblPengajaran::find()->where(['NOKP' => $this->ICNO])->andWhere(['is not', 'KATEGORIPELAJAR', NULL])->select('KATEGORIPELAJAR')->distinct()->all();
    }

    public function getPengajaranbyKategori()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->OrderBy(['KATEGORIPELAJAR' => SORT_ASC]);
    }

    public function getPengajaranAsasi()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->where(['KATEGORIPELAJAR' => 'ASASI']);
    }

    public function getPengajaranAsasiSains()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->where(['KATEGORIPELAJAR' => 'ASASI SAINS']);
    }

    public function getPengajaranCertificatePep()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->where(['KATEGORIPELAJAR' => 'CERTIFICATE PEP']);
    }

    public function getPengajaranDipKejururawatan()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->where(['KATEGORIPELAJAR' => 'DIPLOMA KEJURURAWATAN']);
    }

    public function getPengajaranDipMChina()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->where(['KATEGORIPELAJAR' => 'DIPLOMA MOBILITI CHINA(SHORT TERM)']);
    }

    public function getPengajaranDipUmum()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->where(['KATEGORIPELAJAR' => 'DIPLOMA UMUM']);
    }

    public function getPengajaranPascasiswazah()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->where(['KATEGORIPELAJAR' => 'PASCASISWAZAH']);
    }

    public function getPengajaranPraMChina()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->where(['KATEGORIPELAJAR' => 'PRA MOBILITI CHINA(SHORT TERM)']);
    }

    public function getPengajaranPrasiswazahPlums()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->where(['KATEGORIPELAJAR' => 'PRASISWAZAH (PLUMS)']);
    }

    public function getPengajaranPrasiswazahPerubatan()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->where(['KATEGORIPELAJAR' => 'PRASISWAZAH PERUBATAN']);
    }

    public function getPengajaranPrasiswazahPpg()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->where(['KATEGORIPELAJAR' => 'PRASISWAZAH PPG']);
    }

    public function getPengajaranPrasiswazahUmum()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->where(['KATEGORIPELAJAR' => 'PRASISWAZAH UMUM']);
    }

    public function getPengajaranNull()
    {
        return $this->hasMany(\app\models\elnpt\TblPengajaran::className(), ['NOKP' => 'ICNO'])->where(['is', 'KATEGORIPELAJAR', null]);
    }

    public function getAdminPosition()
    {
        return $this->hasMany(Tblrscoadminpost::className(), ['ICNO' => 'ICNO'])->orderBy(['start_date' => SORT_DESC]);
    }

    //-------- untuk dapatkan jawatan pentadbiran -------------------//

    public function getAp()
    {
        if ($this->adminPosition) {
            foreach ($this->adminPosition as $ap) {
                if ($ap->flag == 1) {
                    //return $ap->postnm->position_name; 
                    return $ap->description;
                }
            }
        }

        return null;
    }

    public function getApStartDate()
    {
        if ($this->adminPosition) {
            foreach ($this->adminPosition as $ap) {
                if ($ap->flag == 1) {
                    return $ap->start_date;
                }
            }
        }

        return null;
    }

    public function getApEndDate()
    {
        if ($this->adminPosition) {
            foreach ($this->adminPosition as $ap) {
                if ($ap->flag == 1) {
                    return $ap->end_date;
                }
            }
        }

        return null;
    }

    //-------- untuk dapatkan jawatan pentadbiran -------------------//

    public function getAdminPositionactive()
    {
        return $this->hasMany(Tblrscoadminpost::className(), ['ICNO' => 'ICNO'])->where(['flag' => 1])->orderBy(['start_date' => SORT_DESC]);
    }

    public function getAdminpos()
    {
        return $this->hasOne(Tblrscoadminpost::className(), ['ICNO' => 'ICNO'])->where(['flag' => 1])->orderBy(['start_date' => SORT_DESC]);
    }

    //    cv online

    public function isAdmin()
    {
        return \app\models\cv\TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['IN', 'access', [1, 2, 3, 5, 6]])->one();
    }

    public function getJumlahPenerbitanPenulisUtama()
    {
        return TblLnptPublicationV2::find()->where(['User_Ic' => $this->ICNO, 'ApproveStatus' => 'V', 'KeteranganBI_WriterStatus' => 'First Author'])->count();
    }

    public function jumlahKreditMengajar($kategori)
    {
        return Pengajaran::find()->where(['NOKP' => $this->ICNO])->andWhere(['like', 'KATEGORIPELAJAR', $kategori])->sum('JAMKREDIT');
    }

    public function jumlahPengajaranbyKategori($kategori)
    {
        return Pengajaran::find()->where(['NOKP' => $this->ICNO])->andWhere(['KATEGORIPELAJAR' => $kategori])->count();
    }

    public function markahlnpt($tahun)
    {

        if ($this->jawatan->job_category == '2') {
            $userid = \app\models\lppums\Lpp::find()->where(['PYD' => $this->ICNO, 'tahun' => $tahun])->one();
            return $userid ? \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $userid->lpp_id])->one()->markah_PP : '';
        } elseif ($this->jawatan->job_category == '1') {
            if ($tahun < 2019) {
                $id = \app\models\elnpt\elnpt_lama\TblUser::find()->where(['user_id' => $this->ICNO])->one()->staff_id;
                $model = \app\models\elnpt\elnpt_lama\TblMarkahLama::find()->where(['staff_id' => $id, 'tahun' => $tahun])->one();
                return $model ? $model->purata : '';
            }

            $markah = TblMain::find()->where(['PYD' => $this->ICNO, 'tahun' => $tahun, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PEER_sah' => 1])->one(); // yang telah disahakan sahaja
            if ($markah) {
                if ($markah->markahAll) { //check cuti belajar
                    return $markah->markahAll->markah == '0' ? '' : $markah->markahAll->markah;
                } else {
                    return '';
                }
            } else {
                return '';
            }
        }
    }

    public function getRekodLNPTAkademik2020()
    { //dan keatas
        return \app\models\elnpt\elnpt2\TblPnP::find()->joinWith('lpp')
            ->where(['elnpt_tbl_main.PYD' => $this->ICNO, 'elnpt_tbl_main.PPP_sah' => 1, 'elnpt_tbl_main.PPK_sah' => 1, 'elnpt_tbl_main.PEER_sah' => 1])
            ->orderBy(['elnpt_v2_tbl_pnp.id_pnp' => SORT_DESC])->all();
    }

    public function getRekodLNPTAkademik2019()
    {
        return \app\models\elnpt\TblJamWaktu::find()->joinWith('lpp')
            ->where(['elnpt_tbl_main.PYD' => $this->ICNO, 'elnpt_tbl_main.PPP_sah' => 1, 'elnpt_tbl_main.PPK_sah' => 1, 'elnpt_tbl_main.PEER_sah' => 1])
            ->andWhere(['elnpt_tbl_main.tahun' => 2019])
            ->orderBy(['elnpt_tbl_jam_waktu.ref_id' => SORT_DESC])->all();
    }

    public function getJamPengajaran()
    {
        $pengajaran2020 = \app\models\elnpt\elnpt2\TblPnP::find()->joinWith('lpp')
            ->where(['elnpt_tbl_main.PYD' => $this->ICNO, 'elnpt_tbl_main.PPP_sah' => 1, 'elnpt_tbl_main.PPK_sah' => 1, 'elnpt_tbl_main.PEER_sah' => 1])
            ->orderBy(['elnpt_tbl_main.tahun' => SORT_DESC])->all();
        $jumlahK2020 = $jumlahK2019 = 0;
        if ($pengajaran2020) {

            foreach ($pengajaran2020 as $pengajaran) {
                $jumlahK2020 = $jumlahK2020 + ($pengajaran->jam_syarahan + $pengajaran->jam_tutorial + $pengajaran->jam_amali);
            }
        }


        $pengajaran2019 = \app\models\elnpt\TblJamWaktu::find()->joinWith('lpp')
            ->where(['elnpt_tbl_main.PYD' => $this->ICNO, 'elnpt_tbl_main.PPP_sah' => 1, 'elnpt_tbl_main.PPK_sah' => 1, 'elnpt_tbl_main.PEER_sah' => 1])
            ->andWhere(['elnpt_tbl_main.tahun' => 2019])
            ->orderBy(['elnpt_tbl_main.tahun' => SORT_DESC])->all();

        if ($pengajaran2019) {

            foreach ($pengajaran2019 as $pengajaran) {
                $jumlahK2019 = $jumlahK2019 + ($pengajaran->waktu_perdana_s + $pengajaran->waktu_perdana_t + $pengajaran->waktu_perdana_m);
            }
        }

        return $jumlahK2020 + $jumlahK2019;
    }

    public function markahlnptCV($tahun, $type)
    { // ambil 10 tahun
        // 2020 ke atas
        $markah = TblMain::find()->where(['PYD' => $this->ICNO, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PEER_sah' => 1])->orderBy(['tahun' => SORT_DESC])->all(); // yang telah disahakan sahaja
        $i = 0;
        $lnptY = array();
        $lnpt = array();
        if ($markah) {
            foreach ($markah as $markah) {
                $record = \app\models\elnpt\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();
                if ($record) {
                    if ($record->markah != '0' || $record->markah != '') {
                        $lnpt[$i] = number_format($record->markah, 2, '.', '');
                        $lnptY[$i] = $markah->tahun;

                        $i++;
                    }
                }
            }
        }
        //kes akademik isi borang pentadbiran 
        $markahPen = \app\models\lppums\Lpp::find()->where(['PYD' => $this->ICNO, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PYD_sah' => 1])->orderBy(['tahun' => SORT_DESC])->all();
        $p = count($lnptY);
        if ($markahPen) {
            foreach ($markahPen as $markahPen) {
                $record = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markahPen->lpp_id])->one();
                if ($record) {
                    if ($record->markah_PP != '0' || $record->markah_PP != '') {
                        $lnpt[$p] = number_format($record->markah_PP, 2, '.', '');
                        $lnptY[$p] = $markahPen->tahun;

                        $p++;
                    }
                }
            }
        }

        // 2019 ke bawah
        $markahOld = \app\models\elnpt\elnpt_lama\TblUser::find()->where(['user_id' => $this->ICNO])->one();
        $n = count($lnptY);
        if ($markahOld) {
            $recordOld = \app\models\elnpt\elnpt_lama\TblMarkahLama::find()->where(['staff_id' => $markahOld->staff_id])->orderBy(['id' => SORT_DESC])->all();
            if ($recordOld) {
                foreach ($recordOld as $recordOld) {
                    if ($recordOld->purata != '0' || $recordOld->purata != '') {
                        $lnpt[$n] = number_format($recordOld->purata, 2, '.', '');
                        $lnptY[$n] = $recordOld->tahun;

                        $n++;
                    }
                }
            }
        }
        $lenght = 0;
        if (!empty($lnpt)) {
            $lenght = $tahun - 1;
            if ($lenght <= count($lnpt)) {

                if ($type == 'Tahun') {
                    return isset($lnptY[$lenght]) ? $lnptY[$lenght] : '';
                } elseif ($type == 'Markah') {
                    return isset($lnpt[$lenght]) ? $lnpt[$lenght] : '';
                }
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    public function markahlnptCVpen($tahun, $type)
    { // ambil 10 tahun pentadbiran  
        $markah = \app\models\lppums\Lpp::find()->where(['PYD' => $this->ICNO, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PYD_sah' => 1])->orderBy(['tahun' => SORT_DESC])->all();
        $i = 0;
        $lnptY = array();
        $lnpt = array();
        if ($markah) {
            foreach ($markah as $markah) {
                if ($markah->tahun != date('Y')) {
                    $record = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();
                    if ($record) {
                        if ($record->markah_PP != '0' || $record->markah_PP != '') {
                            $lnpt[$i] = number_format($record->markah_PP, 2, '.', '');
                            $lnptY[$i] = $markah->tahun;

                            $i++;
                        }
                    }
                }
            }
        }


        $lenght = 0;
        if (!empty($lnpt)) {
            $lenght = $tahun - 1;
            if ($lenght <= count($lnpt)) {

                if ($type == 'Tahun') {
                    return isset($lnptY[$lenght]) ? $lnptY[$lenght] : '';
                } elseif ($type == 'Markah') {
                    return isset($lnpt[$lenght]) ? $lnpt[$lenght] : '';
                }
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    public function getCompletePenyeliaan()
    {
        return $this->hasMany(\app\models\elnpt\TblPenyeliaan::className(), ['NoKpPenyelia' => 'ICNO'])->where(['KodStatusPengajian' => '06']);
    }

    public function carianKeselamatan($params)
    {
        $query = Tblprcobiodata::find()
            ->where(['!=', 'status', 6])
            ->andWhere(['IN', 'DeptId', ['2', '139', '33']])
            ->andWhere(['IN', 'gredJawatan', ['118', '119', '295', '302', '303', '360', '388', '389', '43', '44', '116', '117', '211', '413']]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        switch ($this->jenis_carian) {
            case '1':
                $query->andFilterWhere(['like', 'CONm', $this->carian_data]);
                break;
            case '2':
                $query->andFilterWhere(['like', 'COOldID', $this->carian_data]);
                break;
            default:
                $query->andFilterWhere(['like', 'ICNO', $this->carian_data]);
                break;
        }

        if (!empty($this->carian_department)) {
            $query->andFilterWhere([
                'DeptId' => $this->carian_department,
            ]);
        }
        if (!empty($this->carian_pendidikantertinggi)) {
            $query->andFilterWhere([
                'HighestEduLevelCd' => $this->carian_pendidikantertinggi,
            ]);
        }
        if (!empty($this->carian_status)) {
            $query->andFilterWhere([
                'Status' => $this->carian_status,
            ]);
        }
        if (!empty($this->carian_statuslantikan)) {
            $query->andFilterWhere([
                'statLantikan' => $this->carian_statuslantikan,
            ]);
        }

        return $dataProvider;
    }

    public function getTblmaxtuntutanklinik()
    {
        return $this->hasOne(\app\models\klinikpanel\Tblmaxtuntutan::className(), ['max_icno' => 'ICNO']);
    }

    public function mataidp($year, $kod)
    {
        $jumlahMata = 0;
        $model = IdpMata::find()
            ->where(['staffID' => $this->icno])
            ->andWhere(['tahun' => $year])
            ->one();

        if ($year != '2020') {
            $model2 = VCpdLatihan::find()
                ->where("vcl_id_staf = '$this->icno' and vcl_kod_kompetensi = $kod and SUBSTRING(vcl_tkh_mula,1,4) = $year and hantar_penilaian = 1")
                ->all();
            foreach ($model2 as $model) {
                $jumlahMata = $jumlahMata + $model->vcl_jum_mata;
            }
            return $jumlahMata;
        } else {
            if ($kod === 3) {
                return $model->mataTeras;
            } elseif ($kod === 4) {
                return $model->mataElektif;
            } elseif ($kod === 1) {
                return $model->mataUmum;
            }
        }
    }

    public function getKewangan()
    {
        return $this->hasOne(\app\models\keterhutangan\TblRekod::className(), ['icno' => 'ICNO'])->one();
    }

    public function getStaffRocBatch()
    {
        return $this->hasOne(\app\models\gaji\TblStaffRocBatchSmbu::className(), ['srb_staff_id' => 'COOldID'])->one();
    }

    public function getActivePermohonan()
    {
        return $this->hasOne(TblpPermohonan::className(), ['ICNO' => 'ICNO'])->where(['status_id' => 1])->one();
    }

    public function AppliedGred()
    {
        return \app\models\ejobs\TblpPermohonan::find()
            ->where(['tbl_permohonan.ICNO' => Yii::$app->user->getId()])
            ->joinWith('iklan')
            ->andWhere(['iklan.status' => 1])
            ->select('tbl_permohonan.iklan_id')->distinct();
    }

    public function getMataidpdiambilkira()
    {
        $jumlahidp = 0;
        if ($this->jawatan->job_category === 1) {
            $teras = Kehadiran::calculateMataTotalStaff('3', $this->ICNO, date('Y'));
            $elektif = Kehadiran::calculateMataTotalStaff('4', $this->ICNO, date('Y'));
            $umum = Kehadiran::calculateMataTotalStaff('1', $this->ICNO, date('Y'));

            $minMata = $this->jawatan->groupidp ? $this->jawatan->groupidp->cpdGroup->mataMin : 0;
            $minTeras = round(0.5 * $minMata);
            $minElektif = round(0.3 * $minMata);
            $minUmum = round(0.2 * $minMata);

            $teras > $minTeras ? $teras = $minTeras : '';
            $elektif > $minElektif ? $elektif = $minElektif : '';
            $umum > $minUmum ? $umum = $minUmum : '';
            $jumlahidp = $teras + $elektif + $umum;
        } else {
            $elektif = Kehadiran::calculateMataTotalStaff('4', $this->ICNO, date('Y'));
            $universiti = Kehadiran::calculateMataTotalStaff('5', $this->ICNO, date('Y'));
            $skim = Kehadiran::calculateMataTotalStaff('6', $this->ICNO, date('Y'));

            if ($this->jawatan->groupidp) {
                $minElektif = $this->jawatan->groupidp->cpdGroup->minElektif; //fixed data in db
                $minUniversiti = $this->jawatan->groupidp->cpdGroup->minTerasUni;
                $minSkim = $this->jawatan->groupidp->cpdGroup->minTerasSkim;
            } else {
                $minElektif = 0;
                $minUniversiti = 0;
                $minSkim = 0;
            }


            $elektif > $minElektif ? $elektif = $minElektif : '';
            $universiti > $minUniversiti ? $universiti = $minUniversiti : '';
            $skim > $minSkim ? $skim = $minSkim : '';
            $jumlahidp = $universiti + $elektif + $skim;
        }

        return $jumlahidp;
    }

    public function getLantikan()
    {
        return $this->hasMany(Tblrscoapmtstatus::className(), ['ICNO' => 'ICNO'])->orderBy(['ApmtStatusStDt' => SORT_DESC]);
    }

    public function getKwsp()
    {
        return $this->hasOne(StaffAccount::className(), ['SA_STAFF_ID' => 'COOldID'])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME', 'KWSP']]);
    }

    public function getKwap()
    {
        return $this->hasOne(StaffAccount::className(), ['SA_STAFF_ID' => 'COOldID'])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME', 'KWAP']]);
    }

    public function getCukai()
    {
        return $this->hasOne(StaffAccount::className(), ['SA_STAFF_ID' => 'COOldID'])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME', 'LHDN']]);
    }

    /// start tbl penyeliaan, refer 1 table only, plus tbl penyeliaan luar

    public function PenyeliaanTamatPengajian($level, $mode)
    {
        $ums = \app\models\cv\TblPenyeliaanMain::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
            ])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere(['MethodStudyName' => $mode])
            ->count();

        $luar = \app\models\cv\TblPenyeliaanLuar::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['Peringkat' => $level])->andWhere(['IsAccepted' => 1])
            ->andWhere(['IsGraduated' => 1])
            ->OrderBy(['DateReviewed' => SORT_DESC])
            ->count();

        return ($ums + $luar);
    }

    public function PenyeliaanTamatPengajianUtama($level, $mode)
    {
        $ums = \app\models\cv\TblPenyeliaanMain::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
            ])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA UTAMA '],
                ['NamaBM' => 'PENYELIA'],
                ['NamaBM' => 'PENGERUSI J/K PENYELIAAN']
            ])
            ->andWhere(['MethodStudyName' => $mode])
            ->count();

        $luar = \app\models\cv\TblPenyeliaanLuar::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['Peringkat' => $level])->andWhere(['IsAccepted' => 1])
            ->andWhere(['IsGraduated' => 1])
            ->andWhere([
                'or',
                ['TahapPenyeliaan' => 'MAIN SUPERVISOR'],
                ['TahapPenyeliaan' => 'SUPERVISOR'],
                ['TahapPenyeliaan' => 'CHAIRPERSON']
            ])
            ->OrderBy(['DateReviewed' => SORT_DESC])
            ->count();

        return ($ums + $luar);
    }

    public function PenyeliaanAktifUtama($level, $mode)
    {
        return \app\models\cv\TblPenyeliaanMain::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['IN', 'StatusBI', ['ACTIVE', 'ACTIVE (THESIS CORRECTION)', 'ACTIVE (WAITING FOR VIVA)', 'ACTIVE(EXTEND (I))', 'ACTIVE(EXTEND (II))', 'ACTIVE(EXTEND (III))', 'ACTIVE(EXTEND (IV))', 'ACTIVE(EXTEND (V))', 'ACTIVE(EXTEND (VI))']])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA UTAMA '],
                ['NamaBM' => 'PENYELIA'],
                ['NamaBM' => 'PENGERUSI J/K PENYELIAAN']
            ])
            ->andWhere(['MethodStudyName' => $mode])
            ->count();
    }

    public function PenyeliaanTamatPengajianBersama($level, $mode)
    {
        $ums = \app\models\cv\TblPenyeliaanMain::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
            ])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA BERSAMA'],
                ['NamaBM' => 'AJK PENYELIAAN']
            ])
            ->andWhere(['MethodStudyName' => $mode])
            ->count();

        $luar = \app\models\cv\TblPenyeliaanLuar::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['Peringkat' => $level])->andWhere(['IsAccepted' => 1])
            ->andWhere(['IsGraduated' => 1])
            ->andWhere([
                'or',
                ['TahapPenyeliaan' => 'CO-SUPERVISOR'],
                ['TahapPenyeliaan' => 'COMMITTEE MEMBER']
            ])
            ->OrderBy(['DateReviewed' => SORT_DESC])
            ->count();

        return ($ums + $luar);
    }

    public function PenyeliaanAktifBersama($level, $mode)
    {
        return \app\models\cv\TblPenyeliaanMain::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['IN', 'StatusBI', ['ACTIVE', 'ACTIVE (THESIS CORRECTION)', 'ACTIVE (WAITING FOR VIVA)', 'ACTIVE(EXTEND (I))', 'ACTIVE(EXTEND (II))', 'ACTIVE(EXTEND (III))', 'ACTIVE(EXTEND (IV))', 'ACTIVE(EXTEND (V))', 'ACTIVE(EXTEND (VI))']])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA BERSAMA'],
                ['NamaBM' => 'AJK PENYELIAAN']
            ])
            ->andWhere(['MethodStudyName' => $mode])
            ->count();
    }

    /// end tbl penyeliaan

    public function totalPenyeliaan($level, $role)
    {
        $ums = \app\models\cv\TblPenyeliaan::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
                ['StatusBI' => 'ANUMERTA POSTHUMOUS']
            ])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere(['NamaBI' => $role])
            ->count();

        $luar = \app\models\cv\TblPenyeliaanLuar::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['Peringkat' => $level])->andWhere(['IsAccepted' => 1])
            ->andWhere(['IsGraduated' => 1])
            ->andWhere(['TahapPenyeliaan' => $role])
            ->OrderBy(['DateReviewed' => SORT_DESC])
            ->count();

        return ($ums + $luar);
    }

    public function totalPenyeliaanPenyelidikan($level, $role)
    {
        $ums = \app\models\cv\TblPenyeliaan::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
                ['StatusBI' => 'ANUMERTA POSTHUMOUS']
            ])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere(['NamaBI' => $role])
            ->count();

        return $ums;
    }

    public function totalPenyeliaanLuar($level, $role)
    {

        $luar = \app\models\cv\TblPenyeliaanLuar::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['Peringkat' => $level])->andWhere(['IsAccepted' => 1])
            ->andWhere(['IsGraduated' => 1])
            ->andWhere(['TahapPenyeliaan' => $role])
            ->OrderBy(['DateReviewed' => SORT_DESC])
            ->count();

        return $luar;
    }

    public function totalPenyeliaanModCampuran($level, $role)
    {
        $total = \app\models\cv\TblPenyeliaanModCampuran::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
                ['StatusBI' => 'ANUMERTA POSTHUMOUS']
            ])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere(['NamaBI' => $role])
            ->count();

        return $total;
    }

    public function totalPenyeliaanLevelModCampuran($level)
    {
        $total = \app\models\cv\TblPenyeliaanModCampuran::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
                ['StatusBI' => 'ANUMERTA POSTHUMOUS']
            ])
            ->andWhere(['ModLevelName' => $level])
            ->count();

        return $total;
    }

    public function totalPenyeliaanLevel($level)
    {
        $ums = \app\models\cv\TblPenyeliaan::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
                ['StatusBI' => 'ANUMERTA POSTHUMOUS']
            ])
            ->andWhere(['ModLevelName' => $level])
            ->count();

        $luar = \app\models\cv\TblPenyeliaanLuar::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['Peringkat' => $level])->andWhere(['IsAccepted' => 1])
            ->andWhere(['IsGraduated' => 1])
            ->count();

        return ($ums + $luar);
    }

    public function totalTamatPengajianUtamaModCampuran($level)
    {
        $total = \app\models\cv\TblPenyeliaanModCampuran::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
                ['StatusBI' => 'ANUMERTA POSTHUMOUS']
            ])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA UTAMA '],
                ['NamaBM' => 'PENYELIA'],
                ['NamaBM' => 'PENGERUSI J/K PENYELIAAN']
            ])
            ->count();

        return $total;
    }

    public function totalTamatPengajianUtama($level)
    {
        $ums = \app\models\cv\TblPenyeliaan::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
                ['StatusBI' => 'ANUMERTA POSTHUMOUS']
            ])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA UTAMA '],
                ['NamaBM' => 'PENYELIA'],
                ['NamaBM' => 'PENGERUSI J/K PENYELIAAN']
            ])
            ->count();

        $luar = \app\models\cv\TblPenyeliaanLuar::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['Peringkat' => $level])->andWhere(['IsAccepted' => 1])
            ->andWhere(['IsGraduated' => 1])
            ->andWhere([
                'or',
                ['TahapPenyeliaan' => 'MAIN SUPERVISOR'],
                ['TahapPenyeliaan' => 'SUPERVISOR'],
                ['TahapPenyeliaan' => 'CHAIRPERSON']
            ])
            ->OrderBy(['DateReviewed' => SORT_DESC])
            ->count();

        return ($ums + $luar);
    }

    public function totalTamatPengajianBersamaModCampuran($level)
    {
        $total = \app\models\cv\TblPenyeliaanModCampuran::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
                ['StatusBI' => 'ANUMERTA POSTHUMOUS']
            ])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA BERSAMA'],
                ['NamaBM' => 'AJK PENYELIAAN']
            ])
            ->count();

        return $total;
    }

    public function totalTamatPengajianBersama($level)
    {
        $ums = \app\models\cv\TblPenyeliaan::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
                ['StatusBI' => 'ANUMERTA POSTHUMOUS']
            ])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA BERSAMA'],
                ['NamaBM' => 'AJK PENYELIAAN']
            ])
            ->count();

        $luar = \app\models\cv\TblPenyeliaanLuar::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['Peringkat' => $level])->andWhere(['IsAccepted' => 1])
            ->andWhere(['IsGraduated' => 1])
            ->andWhere([
                'or',
                ['TahapPenyeliaan' => 'CO-SUPERVISOR'],
                ['TahapPenyeliaan' => 'COMMITTEE MEMBER']
            ])
            ->OrderBy(['DateReviewed' => SORT_DESC])
            ->count();

        return ($ums + $luar);
    }

    public function totalTamatPengajianBersamaPHD($i)
    {
        return \app\models\cv\TblPenyeliaan::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
                ['StatusBI' => 'ANUMERTA POSTHUMOUS']
            ])
            ->andWhere([$i, 'SMP01_Kursus', 'DM01C'])
            ->andWhere(['ModLevelName' => 'PHD'])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA BERSAMA'],
                ['NamaBM' => 'AJK PENYELIAAN']
            ])
            ->count();
    }

    public function totalTamatPengajianBersamaPHDModCampuran()
    {
        return \app\models\cv\TblPenyeliaanModCampuran::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere([
                'or',
                ['StatusBI' => 'STUDY COMPLETED'],
                ['StatusBI' => 'EXPECTED TO GRADUATE'],
                ['StatusBI' => 'ANUMERTA POSTHUMOUS']
            ])
            ->andWhere(['ModLevelName' => 'PHD'])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA BERSAMA'],
                ['NamaBM' => 'AJK PENYELIAAN']
            ])
            ->count();
    }

    public function totalAktifUtama($level)
    {
        return \app\models\cv\TblPenyeliaan::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['IN', 'StatusBI', ['ACTIVE', 'ACTIVE (THESIS CORRECTION)', 'ACTIVE (WAITING FOR VIVA)', 'ACTIVE(EXTEND (I))', 'ACTIVE(EXTEND (II))', 'ACTIVE(EXTEND (III))', 'ACTIVE(EXTEND (IV))', 'ACTIVE(EXTEND (V))', 'ACTIVE(EXTEND (VI))']])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA UTAMA '],
                ['NamaBM' => 'PENYELIA'],
                ['NamaBM' => 'PENGERUSI J/K PENYELIAAN']
            ])
            ->count();
    }

    public function totalAktifBersama($level)
    {
        return \app\models\cv\TblPenyeliaan::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['IN', 'StatusBI', ['ACTIVE', 'ACTIVE (THESIS CORRECTION)', 'ACTIVE (WAITING FOR VIVA)', 'ACTIVE(EXTEND (I))', 'ACTIVE(EXTEND (II))', 'ACTIVE(EXTEND (III))', 'ACTIVE(EXTEND (IV))', 'ACTIVE(EXTEND (V))', 'ACTIVE(EXTEND (VI))']])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA BERSAMA'],
                ['NamaBM' => 'AJK PENYELIAAN']
            ])
            ->count();
    }

    public function totalAktifUtamaModCampuran($level)
    {
        return \app\models\cv\TblPenyeliaanModCampuran::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['IN', 'StatusBI', ['ACTIVE', 'ACTIVE (THESIS CORRECTION)', 'ACTIVE (WAITING FOR VIVA)', 'ACTIVE(EXTEND (I))', 'ACTIVE(EXTEND (II))', 'ACTIVE(EXTEND (III))', 'ACTIVE(EXTEND (IV))', 'ACTIVE(EXTEND (V))', 'ACTIVE(EXTEND (VI))']])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA UTAMA '],
                ['NamaBM' => 'PENYELIA'],
                ['NamaBM' => 'PENGERUSI J/K PENYELIAAN']
            ])
            ->count();
    }

    public function totalAktifBersamaModCampuran($level)
    {
        return \app\models\cv\TblPenyeliaanModCampuran::find()->where(['SMP28_KP' => $this->ICNO])
            ->andWhere(['IN', 'StatusBI', ['ACTIVE', 'ACTIVE (THESIS CORRECTION)', 'ACTIVE (WAITING FOR VIVA)', 'ACTIVE(EXTEND (I))', 'ACTIVE(EXTEND (II))', 'ACTIVE(EXTEND (III))', 'ACTIVE(EXTEND (IV))', 'ACTIVE(EXTEND (V))', 'ACTIVE(EXTEND (VI))']])
            ->andWhere(['ModLevelName' => $level])
            ->andWhere([
                'or',
                ['NamaBM' => 'PENYELIA BERSAMA'],
                ['NamaBM' => 'AJK PENYELIAAN']
            ])
            ->count();
    }

    public function findCutiBelajar($icno)
    {
        $years3 = array($this->markahlnptCV(1, 'Tahun'), $this->markahlnptCV(2, 'Tahun'), $this->markahlnptCV(3, 'Tahun'));
        $status = 0;
        $pengajian = TblPengajian::find()->where(['icno' => $icno])->andWhere(['IN', 'YEAR(tarikh_tamat)', $years3])->OrderBy(['tahun' => SORT_DESC])->one();
        $pengajian2 = TblPengajian::find()->where(['icno' => $icno])->andWhere(['IN', 'YEAR(tarikh_mula)', $years3])->OrderBy(['tahun' => SORT_DESC])->one();
        $lanjutanSt = \app\models\cbelajar\TblLanjutan::find()->where(['icno' => $icno])->andWhere(['IN', 'YEAR(lanjutansdt)', $years3])->one();
        $lanjutanEnd = \app\models\cbelajar\TblLanjutan::find()->where(['icno' => $icno])->andWhere(['IN', 'YEAR(lanjutanedt)', $years3])->one();

        if (!empty($pengajian) || !empty($pengajian2) || !empty($lanjutanSt) || !empty($lanjutanEnd)) {
            $status = 1;
        }

        return $status;
    }

    public function getPengalamanKKMTahun()
    {
        $model = \app\models\hronline\Tblpengalamankerja::find()->where(['ICNO' => $this->ICNO])
            ->andWhere(['like', 'OrgNm', 'Kementerian Kesihatan Malaysia'])
            ->andWhere(['CorpBodyTypeCd' => '01'])
            ->one();

        $year = 0;
        if ($model) {
            if ($model->PrevEmpEndDt) {
                if ($model->PrevEmpStartDt) {

                    $ts1 = strtotime($model->PrevEmpStartDt);
                    $ts2 = strtotime($model->PrevEmpEndDt);

                    $year1 = date('Y', $ts1);
                    $year2 = date('Y', $ts2);

                    $month1 = date('m', $ts1);
                    $month2 = date('m', $ts2);

                    $year = round(((($year2 - $year1) * 12) + ($month2 - $month1)) / 12, 0);
                }
            }
        }
        return $year;
    }

    public function getPendidikanbyTahap($id)
    {
        return Tblpendidikan::find()->where(['ICNO' => $this->ICNO])->andWhere(['HighestEduLevelCd' => $id])->one();
    }

    public function getPengalamanUMSTahun()
    {
        $model = Tblrscosandangan::find()->where(['ICNO' => $this->ICNO])->orderBy(['start_date' => SORT_ASC])->one();
        //belum check rekod penamatan perkhidmatan
        $year = 0;
        if ($model) {
            if ($model->start_date) {

                $year1 = date('Y', strtotime($model->start_date));
                $year2 = date('Y', strtotime(date('Y-m-d')));

                $month1 = date('m', strtotime($model->start_date));
                $month2 = date('m', strtotime(date('Y-m-d')));

                $year = round(((($year2 - $year1) * 12) + ($month2 - $month1)) / 12, 0);
            }
        }
        return $year;
    }

    public function getReturn_url()
    {

        //buat semua url redirection selepas login disini
        // $akses = TblAkses::find()->where(['icno' => $this->ICNO])->andWhere(['NOT IN', 'akses_level', ['6', '3']])->exists();
        // $staff_keselamatan = TblStaffKeselamatan::find()->where(['staff_icno' => $this->ICNO])->andWhere(['=', 'isExcluded', '0'])->exists();
        // if ($staff_keselamatan) {
        //     return 'keselamatan/index';
        // }
        //psh
        if ($this->statLantikan == '6') {
            return 'kehadiran/index';
        }
        //semua redirect ke dashbaord 5/4/2021
        return 'dashboard/index';
    }

    public function getPengajianLulus()
    {
        return $this->hasOne(TblPengajian::className(), ['icno' => 'ICNO']);
    }

    public function getLkp()
    {
        return $this->hasOne(\app\models\cbelajar\TblLkk::className(), ['icno' => 'ICNO']);
    }

    public function getDisplayStartSandanganPerkhidmatan()
    {

        return Yii::$app->MP->Tarikh($this->startDateSandangan);
    }

    public function getDisplayStartLantikPerkhidmatan()
    {
        return Yii::$app->MP->Tarikh($this->startDateLantik);
    }

    public function getLantikanPerkhidmatan()
    {
        return $this->hasOne(Tblrscoapmtstatus::className(), ['ICNO' => 'ICNO'])->where(['ApmtStatusCd' => 1])->orderBy(['ApmtStatusStDt' => SORT_ASC]);
    }

    //tempoh lantikan utk latest status pengesahan
    public function getTempohstatuspengesahan()
    {
        $m = Tblrscoconfirmstatus::find()->where(['ICNO' => $this->ICNO])->max('ConfirmStatusStDt');
        $date1 = date_create($m);
        $date2 = date_create(date('Y-m-d'));
        $tempohstatuspengesahan = date_diff($date1, $date2)->format('%y Tahun, %m Bulan, %d Hari');
        return $tempohstatuspengesahan;
    }

    //untuk pendingtask pengesahan //tempoh tahun utk latest status pengesahan
    public function Tempohtahunpengesahan($icno)
    {
        $m = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt');
        $date1 = date_create($m);
        $date2 = date_create(date('Y-m-d'));
        $tempohtahunpengesahan = date_diff($date1, $date2)->format('%y');
        return $tempohtahunpengesahan;
    }

    //untuk pendingtask pengesahan //latest status pengesahan
    public function Confirmstatuspengesahan($icno)
    {
        $m = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt');
        $confirmstatuspengesahan = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno, 'ConfirmStatusStDt' => $m])->one()->ConfirmStatusCd;
        return $confirmstatuspengesahan;
    }

    public function Jawatan_category()
    {
        return '2'; //$this->jawatan->job_category;
    }

    public function getPengesahan()
    {
        return $this->hasOne(\app\models\pengesahan\Pengesahan::className(), ['icno' => 'ICNO']);
    }

    public function getPtm()
    {
        return $this->hasOne(\app\models\pengesahan\TblPtm::className(), ['ICNO' => 'ICNO']);
    }

    public function getPnp()
    {
        return $this->hasOne(\app\models\pengesahan\TblPnp::className(), ['ICNO' => 'ICNO']);
    }

    public function getSijilspm()
    {
        return $this->hasOne(\app\models\hronline\Tblpendidikan::className(), ['ICNO' => 'ICNO'])->where(['HighestEduLevelCd' => [14, 23]]);
    }

    public function getSijilpmr()
    {
        return $this->hasOne(\app\models\hronline\Tblpendidikan::className(), ['ICNO' => 'ICNO'])->where(['HighestEduLevelCd' => '15']);
    }
    public function getEduHighest()
    {
        return $this->hasOne(\app\models\hronline\Tblpendidikan::className(), ['ICNO' => 'ICNO'])->where(['HighestEduLevelCd' => $this->HighestEduLevelCd]);
    }

    public function getCpengajian()
    {
        return $this->hasOne(\app\models\cbelajar\TblPengajian::className(), ['icno' => 'ICNO'])->orderBy(['tarikh_mula' => SORT_DESC]);
    }

    public function findAksesLevel()
    {
        $model = TblAccess::find()->where(['ICNO' => $this->ICNO])->all();
        $arr = '';
        if ($model) {
            $i = 1;
            foreach ($model as $model) {
                $arr .= $i . '. ' . $model->level->desc . '<br/>';

                $i++;
            }
        }
        return $arr;
    }

    public function getMyjd()
    {
        return $this->hasOne(TblPortfolio::className(), ['icno' => 'ICNO'])->orderBy(['id' => SORT_DESC]);
    }

    public function getMyjdPenyelia()
    {
        return $this->hasOne(TblPortfolio::className(), ['icno' => 'ICNO'])->where(['jabatan_semasa' => $this->DeptId]);
    }

    public function getTuntutanPelekat()
    {
        return $this->hasOne(\app\models\esticker\TblTuntutan::className(), ['ICNO' => 'ICNO']);
    }

    public function getBiodataHarta()
    {
        return $this->hasOne(TblHarta::className(), ['icno' => 'ICNO']);
    }

    public function getHartaPenyelia()
    {
        return $this->hasOne(TblHarta::className(), ['icno' => 'ICNO'])->where(['DeptId' => $this->DeptId]);
    }

    public function getPekerjaNm()
    {
        $kon = Department::findOne(['id' => $this->DeptId]);

        return $this->CONm . '' . '( ' . $kon->shortname . ' )';
    }
}
