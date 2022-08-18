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

use app\models\hronline\Tblprcobiodata as BaseBiodata;
use app\models\hronline\Tblrscosandangan;
use app\models\hronline\Tblanugerah;

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
class Tblprcobiodata extends BaseBiodata
{

    // add the function below:
    public static function getDb()
    {
        return Yii::$app->get('db'); // second database
    }

    public function getTestingAkses()
    {
        return $this->hasOne(TblTestingAccess::className(), ['icno' => 'ICNO']);
    }

    public function getSandanganApc()
    {
        return $this->hasMany(Tblrscosandangan::className(), ['ICNO' => 'ICNO'])
            ->orderBy(['start_date' => SORT_DESC])->limit(1);
        // ->where('ABS(:tahun - YEAR(start_date)) > 1', [':tahun' => $tahun]);
        // ->where(['sandangan_id' => 1]);
    }

    public function getAnugerahApc($tahun)
    {
        return $this->hasMany(Tblanugerah::className(), ['ICNO' => 'ICNO'])->orderBy(['AwdCfdDt' => SORT_DESC]);
    }

    public function formName()
    {
        return '';
    }
}
