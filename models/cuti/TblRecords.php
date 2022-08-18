<?php

namespace app\models\cuti;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use DateTime;
use app\models\hronline\Tblprcobiodata;
use app\models\cuti\JenisCuti;
use app\models\cuti\Tindakan;
use app\models\hronline\Campus;
use app\models\hronline\Department;
use app\models\hronline\Gelaran;
use app\models\hronline\GredJawatan;
use app\models\hronline\ServiceStatus;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Tblrscoapmtstatus;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/**
 * This is the model class for table "e_cuti.tbl_ctr".
 *
 * @property int $id
 * @property int $jenis_cuti_id id drpd tbl jenis_cuti
 * @property string $icno
 * @property string $full_date full date
 * @property string $start_date
 * @property string $end_date
 * @property int $tempoh
 * @property string $remark catatan cuti tersebut
 * @property string $destination Destinasi luar negara
 * @property string $type 1 : Dalam Negara || 2 : Luar Negara
 * @property string $ganti_by ICNO
 * @property string $ganti_dt DATETIME
 * @property string $semakan_by ICNO
 * @property string $semakan_remark ulasan penyemak
 * @property string $semakan_dt DATETIME
 * @property string $peraku_by ICNO
 * @property string $peraku_remark ulasan peraku
 * @property string $peraku_dt DATETIME
 * @property string $lulus_by ICNO
 * @property string $lulus_remark ulasan pelulus
 * @property string $lulus_dt DATETIME
 * @property string $status ENTRY,CHECKED,VERIFIED,APPROVED,REJECTED,RETURNED
 * @property string $mohon_dt mohon pada
 * @property string $file_hashcode ini utk kegunaan file
 */
class TblRecords extends \yii\db\ActiveRecord
{
    //    public $nama;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_tbl_records';
        // return 'hrm.cuti_tbl_records';
    }

    public $file;
    public $arr;
    public $others;
    public $tempv1;
    public $tempv2;
    public $tempv3;
    public $arr1;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_cuti_id', 'tempoh'], 'integer'],
            [['arr', 'arr1', 'tempv1', 'tempv2', 'tempv3', 'start_date', 'end_date', 'start_date_applied', 'end_date_applied', 'semakan_dt', 'peraku_dt', 'lulus_dt', 'mohon_dt', 'ganti_dt','p_verify_dt'], 'safe'],
            [['jenis_cuti_id'], 'required', 'on' => ['pilih'], 'message' => 'Sila pilih jenis Cuti'],

            //wajib utk semua jenis cuti
            [['full_date'], 'required', 'message' => 'Sila Pilih Tarikh Bercuti Dari - Hingga'],
            [['full_date'], 'checkDate', 'on' => ['ctr', 'cr1', 'cr2','cr1_aca']], //cuti supaya cuti tidak bertindih dengan cuti2 yang lain
            [['remark'], 'required', 'on' => ['ctr', 'cr1', 'cr2','cr1_aca', 'cb'], 'message' => 'Sila nyatakan catatan/tujuan/remark'],
            //wajib utk semua jenis cuti
            [['full_date'], 'checkDates', 'on' => ['manual']], //cuti supaya cuti tidak bertindih dengan cuti2 yang lain
            [['jenis_cuti_id'], 'required', 'on' => ['manual'], 'message' => 'Sila pilih jenis Cuti'],
            // [['full_date'], 'checkDt', 'on' => ['update']], //cuti supaya cuti tidak bertindih dengan cuti2 yang lain
            [['full_date'], 'checkCp', 'on' => ['cp']], //cuti supaya cuti tidak bertindih dengan cuti2 yang lain
            [['jenis_cuti_id'], 'required', 'on' => ['update'], 'message' => 'Sila pilih jenis Cuti'],
            [['remark'], 'required', 'on' => ['manual', 'cb'], 'message' => 'Sila nyatakan catatan/tujuan/remark'],
            [['status'], 'required', 'on' => ['manual'], 'message' => 'Sila Pilih Status'],

            //CP
            [['destination', 'remark', 'type', 'research_id'], 'required',  'on' => 'cp', 'message' => 'Sila Isi Ruangan Ini!'],
            //CR2
            [['destination'], 'required', 'on' => 'cr2', 'message' => 'Sila nyatakan destinasi luar negara!'],
            [['status'], 'required', 'on' => 'agree', 'message' => 'Sila Pilih Perakuan!'],

            //CTR
            [['file'], 'required', 'on' => 'ctr', 'message' => 'Sila Lampirkan Dokumen Sokongan'],
            [['file1'], 'required', 'on' => 'ctr', 'message' => 'Sila Lampirkan Salinan Akuan Bersalin'],
            [['file2'], 'required', 'on' => 'ctr', 'message' => 'Sila Lampirkan Salinan Sijil Kelahiran Anak'],
            [['arr'], 'required', 'on' => 'ctr', 'message' => 'Sila Tanda Salah Satu'],
            [['arr1'], 'required', 'on' => ['cb'], 'message' => 'Sila Tanda Salah Satu'],
            [['arr1'], 'checkBs', 'on' => ['cb']], 

            //CS
            [['file'], 'required', 'on' => ['cs1', 'cs2'], 'message' => 'Sila Sertakan Sijil Sakit'],
            [['file1','file2'], 'required', 'on' => ['cb'], 'message' => 'Sila Muatnaik dokumen ini'],
            [['file', 'file1', 'file2'], 'safe'],
            [['file', 'file1', 'file2'], 'file',  'maxSize' => 6000 * 1024, 'tooBig' => 'File Limit is 6MB only','extensions' => 'jpeg,jpg,png,pdf'],
            //cs1
            [['full_date'], 'checkCss', 'on' => ['cs1']], //cuti supaya cuti tidak bertindih dengan cuti2 yang lain

            //cs2
            [['full_date'], 'checkCsk', 'on' => ['cs2']], //cuti supaya cuti tidak bertindih dengan cuti2 yang lain
            [['full_date'], 'checkCsk', 'on' => ['hso']], //cuti supaya cuti tidak bertindih dengan cuti2 yang lain

            //cb
            [['start_date'], 'required', 'on' => ['cb'], 'message' => 'Sila Pilih Tarikh'],
            [['start_date'] , 'checkCb','on' => ['cb'], 'message' => 'Sila Pilih Tarikh'],
            [['file'], 'required', 'on' => ['cb'], 'message' => 'Sila Sertakan Dokumen Yang Berkaitan'],


            [['status', 'peraku_by', 'lulus_by', 'semakan_remark'], 'required', 'on' => 'semakan', 'message' => 'Please Select!'],
            [['status', 'peraku_remark'], 'required', 'on' => 'peraku', 'message' => 'Please Select!'],
            [['status', 'lulus_remark'], 'required', 'on' => 'pelulus', 'message' => 'Please dont leave it blank!'],
            //Cuti rehat 1
            [['ganti_by'], 'required', 'on' => 'cr1', 'message' => '{attribute} ini adalah wajib!'],
            [['semakan_by'], 'required', 'on' => ['cs1','cs2','hso'], 'message' => '{attribute} adalah wajib'],
            //Cuti Rehat 1
            [['icno'], 'required'],
            [['icno', 'semakan_by', 'peraku_by', 'lulus_by', 'ganti_by','p_verify'], 'string', 'max' => 12],
            [['full_date'], 'string', 'max' => 50],
            [[ 'peraku_remark', 'lulus_remark', 'destination','p_remark'], 'string', 'max' => 150],
            [['remark', 'others', 'semakan_remark','research_id'], 'string'],
            [['type'], 'integer', 'max' => 1],
            [['status'], 'string', 'max' => 12],
            [['file_hashcode'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {

        return [
            'id' => 'ID',
            'jenis_cuti_id' => 'Leave Type',
            'icno' => 'Staff Name',
            'full_date' => 'Leave Date (From - to)',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'tempoh' => 'Tempoh',
            'remark' => 'Remark',
            'destination' => 'Destination',
            'type' => 'L* Luar / D* Dalam Negara',
            'ganti_by' => 'Substitute',
            'ganti_dt' => 'Date/time',
            'semakan_by' => 'Semakan Penyelia',
            'semakan_remark' => 'Catatan(Semakan)',
            'semakan_dt' => 'Semakan Dt',
            'peraku_by' => 'Verifier',
            'peraku_remark' => 'Catatan(Perakuan)',
            'peraku_dt' => 'Diperakukan Pada',
            'lulus_by' => 'Approver',
            'lulus_remark' => 'Catatan(Kelulusan)',
            'lulus_dt' => 'Lulus Dt',
            'status' => 'Status',
            'mohon_dt' => 'Apply Date/time',
            'file_hashcode' => 'File Hashcode',
            'file' => 'Dokumen Sokongan',
            'jenis' => 'Jenis Permohonan',
            'viewDoc' => 'Dokumen Sokongan',
            'semakanLog' => 'Log Semakan',
            'perakuLog' => 'Log Perakuan',
            'pelulusLog' => 'Log Kelulusan',
            'tempv1' => 'tempvalue1',
        ];
    }
    public static function Italic($i)
    {

        return '<span class="italic">' . $i . '</span>';
    }
    //to get download link from API
    public function getDisplayLink()
    {
        if (!empty($this->file_hashcode && $this->file_hashcode != 'deleted')) {
            return html::a(Yii::$app->FileManager->NameFile($this->file_hashcode), Yii::$app->FileManager->DisplayFile($this->file_hashcode));
        }
        return 'File not exist!';
    }
    public function getDisplayLinks()
    {
        if (!empty($this->file_hashcode && $this->file_hashcode != 'deleted')) {
            return html::a(Yii::$app->FileManager->NameFile($this->file_hashcode), Yii::$app->FileManager->DisplayFile($this->file_hashcode));
        }
        return '';
    }
    public function getDisplayLinkFile1()
    {
        if (!empty($this->file1 && $this->file1 != 'deleted')) {
            return html::a(Yii::$app->FileManager->NameFile($this->file1), Yii::$app->FileManager->DisplayFile($this->file1));
        }
        return '';
    }
    public function getDisplayLinkFile2()
    {
        if (!empty($this->file2 && $this->file2 != 'deleted')) {
            return html::a(Yii::$app->FileManager->NameFile($this->file2), Yii::$app->FileManager->DisplayFile($this->file2));
        }
        return '';
    }

    public function getGelaran()
    {
        return $this->hasOne(Gelaran::className(), ['TitleCd' => 'TitleCd']);
    }
    public function getBod()
    {
        return $this->hasOne(CutiTblBod::className(), ['record_id' => 'id']);
    }
    public function getJawatan()
    {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gredJawatan']);
    }

    //cuti bersalin
    public function checkBs($attribute, $params)
    {
        $today = date('Y-m-d');

        $icno = Yii::$app->user->getId();

        $sumtotal = 0;

        $model = self::find()->where(['icno' => $icno])->andWhere(['jenis_cuti_id' => 28])->all();

        foreach ($model as $sum) {
            $sumtotal += $sum['tempoh'];
        }
        $total = $sumtotal + $this->arr1;
        if ($total > 360) {

            $this->addError($attribute, 'Kelayakan Anda Tidak Mencukupi, Sila Pilih Pilihan Lain!');
        }
    }
    //cuti sakit 1
    public function checkCss($attribute, $params)
    {
        $today = date('Y-m-d');
        $arr = explode(" ", $this->full_date);

        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));

        $icno = Yii::$app->user->getId();
        $start_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $start_date_exist = TblRecords::findBySql($start_sql, [':icno' => $icno, ':date' => $start_date])->exists();

        $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $end_date_exist = TblRecords::findBySql($end_sql, [':icno' => $icno, ':date' => $end_date])->exists();

        $sumtotal = 0;

        $model = self::find()->where(['icno' => $icno])->andWhere(['jenis_cuti_id' => 20])->andWhere(['YEAR(start_date)'=>date('Y')])->all();

        foreach ($model as $sum) {
            $sumtotal += $sum['tempoh'];
        }
        $tempoh = self::getTotalDays();

        $total = $sumtotal + $tempoh;
        $bal = 15-$sumtotal;

        if ($total > 15) {

            $this->addError($attribute, 'Kelayakan Anda Tidak Mencukupi, Baki Cuti Sakit Klinik Panel Swasta Anda '.$bal);
        }
        if ($start_date_exist) {
            $this->addError($attribute, 'Tarikh mula adalah bertindih dengan cuti lain!');
        }

        if ($end_date_exist) {
            $this->addError($attribute, 'Tarikh tamat adalah bertindih dengan cuti lain!');
        }
    }
    public function checkCsk($attribute, $params)
    {
        $today = date('Y-m-d');
        $arr = explode(" ", $this->full_date);

        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));

        $icno = Yii::$app->user->getId();
        $mod = Tblprcobiodata::find()->where(['ICNO' => $icno])->andWhere(['IN','statLantikan' , ['3','6','7']])->one();
        $val = 90;
        if($mod){
            $val = 75;
        }
        $sumtotal = 0;
        $start_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $start_date_exist = TblRecords::findBySql($start_sql, [':icno' => $icno, ':date' => $start_date])->exists();

        $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $end_date_exist = TblRecords::findBySql($end_sql, [':icno' => $icno, ':date' => $end_date])->exists();

        $model = self::find()->where(['icno' => $icno])->andWhere(['jenis_cuti_id' => 21])->andWhere(['YEAR(start_date)'=>date('Y')])->all();
        foreach ($model as $sum) {
            $sumtotal += $sum['tempoh'];
        }
        $tempoh = self::getTotalDays();

        $total = $sumtotal + $tempoh;
        $bal = $val-$sumtotal;

        if ($total > $val) {

            $this->addError($attribute, 'Kelayakan Anda Tidak Mencukupi, Baki Cuti Sakit Klinik/Hospital Kerajaan Anda '.$bal);
        }
        if ($start_date_exist) {
            $this->addError($attribute, 'Tarikh mula adalah bertindih dengan cuti lain!');
        }

        if ($end_date_exist) {
            $this->addError($attribute, 'Tarikh tamat adalah bertindih dengan cuti lain!');
        }

    }
    public function checkHso($attribute, $params)
    {
        $today = date('Y-m-d');
        $arr = explode(" ", $this->full_date);

        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));

        $icno = Yii::$app->user->getId();
       
        $start_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $start_date_exist = TblRecords::findBySql($start_sql, [':icno' => $icno, ':date' => $start_date])->exists();

        $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $end_date_exist = TblRecords::findBySql($end_sql, [':icno' => $icno, ':date' => $end_date])->exists();
   
        if ($start_date_exist) {
            $this->addError($attribute, 'Tarikh mula adalah bertindih dengan cuti lain , Sila Berhubung dengan Penyelia Anda');
        }

        if ($end_date_exist) {
            $this->addError($attribute, 'Tarikh tamat adalah bertindih dengan cuti lain, Sila Berhubung dengan Penyelia Anda ');
        }

    }
    public static function totalCutiBersalin($icno)
    {

        $sumtotal = 0;
        // echo 'd';die;


        $model = self::find()->where(['icno' => $icno])->andWhere(['jenis_cuti_id' => 28])->all();

        foreach ($model as $sum) {
            $sumtotal += $sum['tempoh'];
        }
        return $sumtotal;
    }
    public function checkCp($attribute, $params)
    {
        $today = date('Y-m-d');

        $icno = Yii::$app->user->getId();

        $arr = explode(" ", $this->full_date);

        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));
        $sumtotal = 0;

        $start_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $start_date_exist = TblRecords::findBySql($start_sql, [':icno' => $icno, ':date' => $start_date])->exists();

        $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $end_date_exist = TblRecords::findBySql($end_sql, [':icno' => $icno, ':date' => $end_date])->exists();
        $cp_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND jenis_cuti_id = 17';
        $cp = TblRecords::findBySql($cp_sql, [':icno' => $icno])->all();

        // $cp = TblRecords::find()->where(['icno' => $icno])->andWhere(['jenis_cuti_id' => 17])->all();
        foreach ($cp as $c) {
            $sumtotal += $c['tempoh'];
        }
        $date1 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->start_date))));
        $date2 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->end_date))));
        $diff = \date_diff($date1, $date2);
        // $the_first_day_of_week = date("N", $date1);


        $workingDays = $diff->format("%a") + 1;
        if (($sumtotal + $workingDays) > 90) {
            $this->addError($attribute, 'Kelayakan Anda Tidak Mencukupi!');
        }
        if ($start_date_exist) {
            $this->addError($attribute, 'Tarikh mula adalah bertindih dengan cuti lain!');
        }

        if ($end_date_exist) {
            $this->addError($attribute, 'Tarikh tamat adalah bertindih dengan cuti lain!');
        }
    }
    public function checkCb($attribute, $params)
    {
        $today = date('Y-m-d');

        $icno = Yii::$app->user->getId();

        $start_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $start_date_exist = TblRecords::findBySql($start_sql, [':icno' => $icno, ':date' => $this->start_date])->exists();

        // $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        // $end_date_exist = TblRecords::findBySql($end_sql, [':icno' => $icno, ':date' => $end_date])->exists();

        if ($start_date_exist) {
            $this->addError($attribute, 'Tarikh mula adalah bertindih dengan cuti lain!');
        }

        // if ($end_date_exist) {
        //     $this->addError($attribute, 'Tarikh tamat adalah bertindih dengan cuti lain!');
        // }
    }
    public function checkDt($attribute, $params)
    {
        $today = date('Y-m-d');

        $icno = Yii::$app->user->getId();

        $arr = explode(" ", $this->full_date);

        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));


        $start_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $start_date_exist = TblRecords::findBySql($start_sql, [':icno' => $icno, ':date' => $start_date])->exists();

        $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $end_date_exist = TblRecords::findBySql($end_sql, [':icno' => $icno, ':date' => $end_date])->exists();

        if ($start_date_exist) {
            $this->addError($attribute, 'Tarikh mula adalah bertindih dengan cuti lain!');
        }

        if ($end_date_exist) {
            $this->addError($attribute, 'Tarikh tamat adalah bertindih dengan cuti lain!');
        }
    }
    public function checkDate($attribute, $params)
    {
        $today = date('Y-m-d');

        $icno = Yii::$app->user->getId();

        $arr = explode(" ", $this->full_date);

        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));
        $year1 = date('Y', strtotime(str_replace("/", "-", date($arr[0]))));
        $year2 = date('Y', strtotime(str_replace("/", "-", date($arr[2]))));

        $start_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $start_date_exist = TblRecords::findBySql($start_sql, [':icno' => $icno, ':date' => $start_date])->exists();

        $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $end_date_exist = TblRecords::findBySql($end_sql, [':icno' => $icno, ':date' => $end_date])->exists();
      
        $start = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (start_date BETWEEN :sdate AND :edate)';
        $start_exist = TblRecords::findBySql($start, [':icno' => $icno, ':sdate' => $start_date,':edate' => $end_date])->exists();

        // $end = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (start_date BETWEEN :sdate AND :edate)';
        // $start_exist = TblRecords::findBySql($start_sql, [':icno' => $icno, ':sdate' => $start_date,':edate' => $end_date])->exists();

        $nx_yr = date('Y', strtotime('-1 year'));
        $baki = 0;
        $gcr = GcrApplication::find()->where(['pemohon_icno' => $icno])->andWhere(['YEAR(mohon_dt)' => date('Y')])->one();
     
        $layak = Layak::getLatestLayak($icno, $year1,$year1);
        $lyk_yr = date('Y', strtotime($start_date));

        $totaldays = $this->getTotalDays();
    

        // $sql = 'SELECT * FROM hrm.cuti_entitlement WHERE layak_icno=:icno AND YEAR(layak_tamat) = YEAR(NOW()) AND YEAR(layak_tamat) >= YEAR(:date)';
        $sql = 'SELECT * FROM hrm.cuti_entitlement WHERE layak_icno=:icno  AND YEAR(layak_tamat) >= YEAR(:date)';
        $layak_start = Layak::findBySql($sql, [':icno' => $icno, ':date' => $start_date])->exists();
        $sql1 = 'SELECT * FROM hrm.cuti_entitlement WHERE layak_icno=:icno AND YEAR(layak_tamat) >= YEAR(:date)';
        // $sql1 = 'SELECT * FROM hrm.cuti_entitlement WHERE layak_icno=:icno AND YEAR(layak_tamat) = YEAR(NOW()) AND YEAR(layak_tamat) >= YEAR(:date)';
        $layak_end = Layak::findBySql($sql1, [':icno' => $icno, ':date' => $end_date])->exists();
        $ny = date('Y', strtotime('+1 year'));
        if ($start_date_exist) {
            $this->addError($attribute, 'Tarikh mula adalah bertindih dengan cuti lain!');
        }
        if ($start_exist) {
            $this->addError($attribute, 'Tarikh adalah bertindih dengan cuti lain!');
        }

        if ($end_date_exist) {
            $this->addError($attribute, 'Tarikh tamat adalah bertindih dengan cuti lain!');
        }
        if ($totaldays >= 14) {
            $this->addError($attribute, 'Harap Maaf , sila isi borang untuk cuti 14 hari dan keatas./ Sorry , You need to fill a form for leave that exceed or equal to 14 days.');
        }
        if(($year1 == date('Y') && $year2 > date('Y'))){
            $this->addError($attribute, 'Harap Maaf , Tarikh Cuti Tidak Boleh Melebihi tahun semasa / Sorry, Leave date cannot exceed current year');

        }
        if ($layak) {
            $total_layak = $layak->layak_cuti + $layak->layak_bawa_lepas + $layak->layak_selaras;
            // $total_layak = $layak->layak_cuti + $layak->layak_bawa_lepas;

            $jum_cuti = TblRecords::totalCuti($icno, $layak->layak_mula, $layak->layak_tamat);

            $baki = $total_layak - $jum_cuti - $layak->layak_gcr;
        }

        // if($yr == $lyk_yr){
        if ($gcr && ($start_date < date('Y') . '-12-31')) {
            $this->addError($attribute, 'Harap Maaf, Anda Telah Membuat Permohonan GCR & CBTH. Sila Hubungi Penyelia Cuti JFPIB Untuk Sebarang Pertanyaan / Sorry, you have applied for GCR & CBTH. Please Contact Your Leave Supervisor for any Enquiries');
        }
        //     if($gcr1){
        //         $this->addError($attribute, 'Harap Maaf, kelayakan cuti anda adalah pada tahun '.$yr.' telah LUPUS / Sorry, Your Leave Entitlement for '.$yr.' has Expired');

        //     }
        // }
        if ($baki <= 0) {
            $this->addError($attribute, 'Harap Maaf,kelayakan cuti anda adalah pada tahun ini sudah habis digunakan. / Sorry , You do not have any leave balance left. ');
        }
        // if($this->jenis_cuti_id == 1 || $this->jenis_cuti_id == 2){

        // }
        $tempoh = self::getTotalDays();
        if ($tempoh > $baki) {
            $this->addError($attribute, 'Harap Maaf,baki cuti anda tidak mencukupi. / Sorry , you do not have enough leave balance. Baki Cuti / Leave Balance = ' . "$baki");
        }

        if (!$layak_start) {
            $this->addError($attribute, "Harap Maaf Anda masih tidak Mempunyai Kelayakan Cuti. Sila Hubungi Penyelia Cuti Jabatan Anda ! / Sorry, you do not have leave entitlement. Please contact your department's Leave Supervisor");
        }

        if (!$layak_end) {
            $this->addError($attribute, 'Tarikh Bercuti Anda Melebihi Tarikh Kelayakan!/ Your Leave exceeded your leave entitlement');
        }


    
    }
    //to check user have upload doc or not
    public static function checkupload($id)
    {
        $mod = self::find()->where(['icno' => $id, 'jenis_cuti_id' => 28])->andWhere(['YEAR(start_date)' => date('Y')])->andWhere(['status' => 'APPROVED'])->one();
        $val = false;
        if ($mod) {
            if (!$mod->file1 && !$mod->file2 ) {
                // echo 'd';
                $val = true;
            }
            // die;
        }
        return $val; 

    }
    public function checkDates($attribute, $params)
    {
        $today = date('Y-m-d');
        $request = Yii::$app->request;

        $icno =  $request->get('id');

        $arr = explode(" ", $this->full_date);
        $baki = 0;

        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));

        $start_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $start_date_exist = TblRecords::findBySql($start_sql, [':icno' => $icno, ':date' => $start_date])->exists();

        $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $end_date_exist = TblRecords::findBySql($end_sql, [':icno' => $icno, ':date' => $end_date])->exists();
        $year1 = date('Y', strtotime(str_replace("/", "-", date($arr[0])))); //year applied 

        $layak = Layak::getLatestLayak($icno,$year1,$year1);



        if ($layak) {
            // $total_layak = $layak->layak_cuti + $layak->layak_bawa_lepas;
            $total_layak = $layak->layak_cuti + $layak->layak_bawa_lepas + $layak->layak_selaras;

            $jum_cuti = TblRecords::totalCuti($icno, $layak->layak_mula, $layak->layak_tamat);

            $baki = $total_layak - $jum_cuti;
        }
        if ($this->jenis_cuti_id == 1 || $this->jenis_cuti_id == 2) {
            if ($baki == 0) {
                $this->addError($attribute, 'Harap Maaf,kelayakan cuti anda adalah pada tahun ini sudah habis digunakan. / Sorry , You do not have any leave balance left. ');
            }

            $tempoh = self::getTotalDays();
            if ($tempoh > $baki) {
                $this->addError($attribute, 'Harap Maaf,baki cuti anda tidak mencukupi. / Sorry , you do have enough leave balance. Baki Cuti / Leave Balance = ' . "$baki");
            }
        }

        if ($start_date_exist) {
            $this->addError($attribute, 'Tarikh mula adalah bertindih dengan cuti lain!');
        }

        if ($end_date_exist) {
            $this->addError($attribute, 'Tarikh tamat adalah bertindih dengan cuti lain!');
        }
    }

    public static function leavecolor($icno, $start, $end)
    {

        $val = '-';
        $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (start_date BETWEEN :start_date AND :end_date)';
        $baki = TblRecords::findBySql($end_sql, [':icno' => $icno, ':start_date' => $start, ':end_date' => $end])->one();
        // var_dump($baki->jenis_cuti_id);die;
        $val = $baki->jenis_cuti_id;
        //     if ($baki == 1) {
        //         $val = '"background-color:#00FF00"';
        // }

        //     if ($baki == 2) {
        //         $val = '"background-color:#00FF00"';
        // }
        //  else if ($model['remark_status'] == 'APPROVED') {
        //     $val = '<font color="white" style="background-color:green;">[ &#10004; ]</font>';
        // } else if ($model['absent'] === '1' || $model['incomplete'] === '1' || $model['external'] === '1' || $model['status_in'] !== null || $model['status_out'] !== null) {
        //     $val = '<font style="color:red">[ &#x2716; ]</font>';
        // } else {
        //     $val = '-';
        // }



        return $val;
    }
    public static function getRecord($icno, $year, $month = null)
    {
        // $baki = 0;
        if (!$month) {
            $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND YEAR(end_date) =:yr';
            $baki = TblRecords::findBySql($end_sql, [':icno' => $icno, ':yr' => $year])->all();
        } else {

            $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (MONTH(start_date) =:mth OR MONTH(end_date) =:mth) AND YEAR(end_date) =:yr';
            $baki = TblRecords::findBySql($end_sql, [':icno' => $icno, ':mth' => $month, ':yr' => $year])->all();
        }
        // $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (start_date BETWEEN :start_date AND :end_date)';
        // $baki = TblRecords::findBySql($end_sql, [':icno' => $icno, ':start_date' => $start, ':end_date' => $end])->all();
        // var_dump($icno, $year, $month);die;
        return $baki;
    }
    public static function getRecords($icno, $start, $end)
    {

        // $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (MONTH(start_date) =:mth OR MONTH(end_date) =:mth) AND YEAR(end_date) =:yr';
        // $baki = TblRecords::findBySql($end_sql, [':icno' => $icno, ':mth' => $month,':yr' => $year])->all();
        $end_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND status != "REJECTED" AND (start_date BETWEEN :start_date AND :end_date OR end_date BETWEEN :start_date AND :end_date) ORDER BY start_date ASC';
        $baki = TblRecords::findBySql($end_sql, [':icno' => $icno, ':start_date' => $start, ':end_date' => $end])->all();
        // var_dump($icno, $start, $end);die;

        return $baki;
    }
    public static function getIncrement($icno, $start, $end)
    {

        $sumtotal = 0;

        $end_sql = 'SELECT * FROM hrm.cuti_tbl_records a
        
        LEFT JOIN hrm.cuti_leave_type b ON b.jenis_cuti_id = a.jenis_cuti_id
        WHERE icno=:icno AND (start_date BETWEEN :start_date AND :end_date) AND b.jenis_cuti_kira = 1 AND a.status != "REJECTED"';
        $total = TblRecords::findBySql($end_sql, [':icno' => $icno, ':start_date' => $start, ':end_date' => $end])->all();
        // var_dump($baki->tempoh);die;
        foreach ($total as $sum) {
            $sumtotal += $sum['tempoh'];
        }

        return $sumtotal;
    }
    public static function getSum($icno, $year = null, $jenis)
    {
        // var_dump($icno,$year, $jenis);die;
        $sumtotal = 0;
        if ($year != NULL) {

            $end_sql = 'SELECT * FROM hrm.cuti_tbl_records a
        
    WHERE icno=:icno AND a.jenis_cuti_id =:jenis AND YEAR(a.start_date)=:year';
            $total = TblRecords::findBySql($end_sql, [':icno' => $icno, ':jenis' => $jenis, 'year' => $year])->all();
        } else {
            $end_sql = 'SELECT * FROM hrm.cuti_tbl_records a
        
    WHERE icno=:icno AND a.jenis_cuti_id =:jenis';
            $total = TblRecords::findBySql($end_sql, [':icno' => $icno, ':jenis' => $jenis])->all();
        }
        // var_dump($baki->tempoh);die;
        foreach ($total as $sum) {
            $sumtotal += $sum['tempoh'];
        }

        return $sumtotal;
    }

    public function getStatuss()
    {
        $val = "";
        if ($this->status == "ENTRY") {
            $val = "Permohonan Baru / New Leave Application";
        }
        if ($this->status == "AGREED") {
            $val = "Pengganti Bersetuju / Substitute Has Agreed";
        }
        if ($this->status == "VERIFIED") {
            $val = "Permohonan Cuti Diperaku / Leave Application Has Been Verified";
        }
        if ($this->status == "APPROVED") {
            $val = "Permohonan Cuti Diluluskan / Leave Application Has Been Approved";
        }
        return $val;
    }
    //untuk convert date
    public function behaviors()
    {
        return [
            'start_dt' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['start_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['start_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {
                    return date('Y-m-d', strtotime(str_replace("/", "-", $this->start_date)));
                },
            ],
            'end_dt' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['end_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['end_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {
                    return date('Y-m-d', strtotime(str_replace("/", "-", $this->end_date)));
                },
            ],
        ];
    }

    public function getSemakanLog()
    {
        return date('d/m/y H:i A', strtotime(str_replace("-", "/", $this->semakan_dt)));
    }

    public function getPerakuLog()
    {
        return date('d/m/y H:i A', strtotime(str_replace("-", "/", $this->peraku_dt)));
    }

    public function getPelulusLog()
    {
        return date('d/m/y H:i A', strtotime(str_replace("-", "/", $this->lulus_dt)));
    }



    public function getJenis()
    {

        if ($this->type == 0) {
            return 'DN - Dalam Negara';
        }

        if ($this->type == 1) {
            return 'LN - Luar Negara';
        }
    }

    public function getDayMohon()
    {

        $formatter = \Yii::$app->formatter;

        return $formatter->asDate($this->mohon_dt, 'd');
    }

    public function getMonthMohon()
    {
        return date('F', strtotime($this->mohon_dt));
    }

    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getDepartment()
    {
        // var_dump($this->kakitangan->DeptId);die;
        $dept = Department::findOne(['id' => $this->kakitangan->DeptId]);
        // var_dump($dept);die;
        return $dept;
    }
    public function getPengganti()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ganti_by']);
    }

    public function getPenyemak()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'semakan_by']);
    }

    public function getPeraku()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'peraku_by']);
    }

    public function getPelulus()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pelulus_by']);
    }
    public function getVerifier()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'lulus_by']);
    }

    public function getJenisCuti()
    {
        return $this->hasOne(JenisCuti::className(), ['jenis_cuti_id' => 'jenis_cuti_id']);
    }
    public function getDestination()
    {
        $val = "-";
        if (($this->destination == NULL || $this->destination == "") && ($this->jenis_cuti_id != 2)) {

            $val = 'Not Applicable';
        } else {
            $val = $this->destination;
        }
        return $val;
    }

    public function getViewDoc()
    {

        return Html::a('<i class="fa fa-search"></i>&nbsp;Open File', Yii::$app->FileManager->DisplayFile($this->file_hashcode), ['target' => '_blank', 'data-pjax' => "0", 'class' => 'btn btn-primary btn-sm']);
    }
    public function getStatusApprover()
    {

        $val = "-";
        if ($this->lulus_dt != NULL) {

            $val = $this->status;
        }
        return $val;
    }
    public function getStatusRemark()
    {
        // $val = "-";

        if ($this->peraku_remark == NULL) {
            $val = "-";
        } else {
            $model = self::findOne(['id' => $this->id]);
            $val = $model->peraku_remark;
        }
        return $val;
    }
    public function getStatusSupervisor()
    {
        // $val = "-";

        if ($this->semakan_remark == NULL) {
            $val = "-";
        } else {
            $model = self::findOne(['id' => $this->id]);
            $val = $model->semakan_remark;
        }
        return $val;
    }
    public function getStatusVerifier()
    {

        // $val = "-";
        // if ($this->status == "APPROVED") {

        //     $val = 'TT';
        // } elseif ($this->status == "VERIFIED") {
        //     $val = 'L';
        // }
        $val = "-";
        if ($this->peraku_dt != NULL && $this->status != "REJECTED") {

            $val = "VERIFIED";
        }
 
        return $val;
    }
    public function getStatusBsm()
    {

        $val = "-";
        if ($this->status != "REJECTED" && $this->semakan_dt != NULL) {

            $val = 'LULUS';
        } elseif ($this->status == "VERIFIED") {
            $val = 'L';
        }

        return $val;
    }
    public function getStatusPengganti()
    {

        $val = "-";
        if ($this->ganti_dt != NULL) {

            $val = 'AGREED';
        }
        // elseif($this->status == "VERIFIED")
        //     {
        //     $val = 'L';

        // }

        return $val;
    }
    public function getStatus()
    {

        $val = $this->status;
        if ($this->status == "ENTRY") {

            $val = 'Permohonan Baru / ENTRY';
        }
        if ($this->status == "AGREED") {

            $val = 'PENGGANTI BERSETUJU / AGREED';
        }
        if ($this->status == "VERIFIED") {

            $val = 'DIPERAKU / VERIFED';
        }
        if ($this->status == "APPROVED") {

            $val = 'DILULUSKAN / APPROVED';
        }
        // elseif($this->status == "VERIFIED")
        //     {
        //     $val = 'L';

        // }

        return $val;
    }
    /**
     * string icno : staff NoIC/Passport NO
     * int year : tahun
     * int month : bulan
     * int : null(Annual Leave) | 1(Medical Leave)  
     */
    public static function TotalDayPerMonth($icno, $year, $month, $type = null)
    {

        $val = 0;
        $data = [1, 2]; //cr1 dan cr2

        if ($type) {
            $data = [20, 21]; //csakit1 dan csakit2
        }

        $model = TblRecords::find()->select(['tempoh'])->where(['icno' => $icno, 'YEAR(start_date)' => $year, 'MONTH(start_date)' => $month, 'jenis_cuti_id' => $data])->asArray()->all();

        foreach ($model as $m) {
            $val += $m['tempoh'];
        }

        return $val;
    }


    public static function totalCuti($icno, $mula, $tamat)
    {

        $val = 0;

        // $query = (new \yii\db\Query())->from('hrm.cuti_tbl_records')->where(['!=','status','REJECTED'])
        // ->andWhere(['BETWEEN','start_date',$mula,$tamat])
        // ->andWhere(['IN','jenis_cuti_id',[1,2]])
        // ->andWhere(['icno'=>$icno]);
        // $sum = $query->sum('tempoh');
        // var_dump($sum);die;

        // $val = (new \yii\db\Query())
        //         ->from('keselamatan.tbl_rollcall')
        //         ->where(['month' => $mth])
        //         ->andWhere(['year' => $year])
        //         ->andWhere(['anggota_icno' => $icno])
        //         ->andWhere([$key => $value])
        //         ->count();

        $command = Yii::$app->db->createCommand("SELECT SUM(tempoh) FROM hrm.cuti_tbl_records a
                                                WHERE a.status != 'REJECTED'
                                                AND a.start_date BETWEEN :mula AND :tamat
                                                AND a.jenis_cuti_id IN (1,2,42)
                                                AND a.icno = :icno")
            ->bindValue(':icno', $icno)
            ->bindValue(':mula', $mula)
            ->bindValue(':tamat', $tamat);
        if ($command) {
            $val = $command->queryScalar();
        }
        // var_dump($val);die;
        return $val;
    }
    public static function totalCutiCurr($icno)
    {
        $sumtotal = 0;
        // var_dump($icno);die;
        $model = TblRecords::find()->where(['icno' => $icno])->andWhere(['MONTH(start_date)' => date('m'), 'YEAR(start_date)' => date('Y')])->andWhere(['IN', 'jenis_cuti_id', ['1', '2']])->orderBy(['start_date' => 'DESC'])->all();
        foreach ($model as $sum) {
            $sumtotal += $sum['tempoh'];
        }
        return $sumtotal;
    }
    public static function leavestat($icno)
    {
        $sumtotal = 'NO';
        $start_sql = 'SELECT * FROM hrm.cuti_tbl_records WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
        $model = TblRecords::findBySql($start_sql, [':icno' => $icno, ':date' => date('Y-m-d')])->one();
        // $model = TblRecords::find()->where(['icno' => $icno])->andWhere(['MONTH(start_date)'=>date('m'),'YEAR(start_date)'=>date('Y')])->andWhere(['IN','jenis_cuti_id',['1','2']])->orderBy(['start_date' => 'DESC'])->all();
        if ($model) {
            $sumtotal = $model->kakitangan->CONm . '(' . $model->full_date . ' - [' . $model->jenisCuti->jenis_cuti_nama . '])';
        }
        return $sumtotal;
    }


    public static function PenyataCuti($icno, $start_date, $end_date)
    {

        $model = TblRecords::find()->where(['icno' => $icno])->andWhere(['between', 'start_date', $start_date, $end_date])->orderBy(['start_date' => 'DESC'])->all();

        return $model;
    }
    public function getTotalDaysInc()
    {


        $date1 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->start_date))));
        $date2 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->end_date))));
        $diff = \date_diff($date1, $date2);
        // $the_first_day_of_week = date("N", $date1);


        $workingDays = $diff->format("%a") + 1;

        $arr = explode(" ", $this->full_date);

        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));

        $startDate = strtotime($start_date);
        $endDate = strtotime($end_date);
        $holidays = CutiUmum::find()->all(); #untuk convert pegi array

        // foreach ($holidays as $value) {
        //     $time_stamp = strtotime($value->tarikh_cuti);
        //     //If the holiday doesn't fall in weekend
        //     if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7)
        //         $workingDays--;
        // }
        // var_dump($workingDays);die;
        return $workingDays;
    }
    public function getTotalDays()
    {

        $date1 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->start_date))));
        $date2 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->end_date))));
        $diff = \date_diff($date1, $date2);
        // $the_first_day_of_week = date("N", $date1);


        $workingDays = $diff->format("%a") + 1;

        $arr = explode(" ", $this->full_date);

        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));

        $startDate = strtotime($start_date);
        $endDate = strtotime($end_date);
        // $bio = Tblprcobiodata::findOne(['ICNO' => $this->icno]);
        // if($bio->campus_id == 2 ){
        // $holidays = CutiUmum::find()->where(['!=', 'sabah_sahaja', '1'])->all(); #untuk convert pegi array
        // }else{
        $holidays = CutiUmum::find()->all(); #untuk convert pegi array
        // }
        foreach ($holidays as $value) {
            $time_stamp = strtotime($value->tarikh_cuti);
            //If the holiday doesn't fall in weekend
            if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7 && $value->sabah_sahaja != 1) {
                $workingDays--;
            }
        }
        return $workingDays;
    }

    public function getTotalDaysEx()
    {
        $arr = explode(" ", $this->full_date);

        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));

        $startDate = strtotime($start_date);
        $endDate = strtotime($end_date);

        $days = ($endDate - $startDate) / 86400 + 1;
        $no_full_weeks = floor($days / 7);
        $no_remaining_days = fmod($days, 7);

        //It will return 1 if it's Monday,.. ,7 for Sunday
        $the_first_day_of_week = date("N", $startDate);
        $the_last_day_of_week = date("N", $endDate);

        if ($the_first_day_of_week <= $the_last_day_of_week) {
            if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week)
                $no_remaining_days--;
            if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week)
                $no_remaining_days--;
        } else {
            // (edit by Tokes to fix an edge case where the start day was a Sunday
            // and the end day was NOT a Saturday)
            // the day of the week for start is later than the day of the week for end
            if ($the_first_day_of_week == 7) {
                // if the start date is a Sunday, then we definitely subtract 1 day
                $no_remaining_days--;

                if ($the_last_day_of_week == 6) {
                    // if the end date is a Saturday, then we subtract another day
                    $no_remaining_days--;
                }
            } else {
                // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
                // so we skip an entire weekend and subtract 2 days
                $no_remaining_days -= 2;
            }
        }

        $workingDays = $no_full_weeks * 5;
        if ($no_remaining_days > 0) {
            $workingDays += $no_remaining_days;
        }

        $holidays = CutiUmum::find()->all(); #untuk convert pegi array

        foreach ($holidays as $value) {
            $time_stamp = strtotime($value->tarikh_cuti);
            //If the holiday doesn't fall in weekend
            if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7 && $value->wilayah_sahaja != 1 && $value->sabah_sahaja != 1)
                $workingDays--;
        }
        return $workingDays;
    }
    //kira tempoh cuti - 
    public function getTahun()
    {

        //     $model = Layak::find()
        // ->where(['layak_icno'=>$icno])
        // ->groupBy (['tahun_cuti'=>SORT_DESC]);  

        return date('Y', strtotime($this->start_date));
        // return $model;
    }
    public function getNama()
    {
        $id = Yii::$app->request->queryParams;
        if ($id != null) {
            $model1 = Tblprcobiodata::find()->where(['like', 'CONm', $id['TblRecordsSearch']['nama']])->all();
        } else {
            $model = '';
        }

        // var_dump($model);die;
        return $model;
    }
    public static function getTarikh($bulan)
    {
        $val = '';

        $m = date_format(date_create($bulan), "m");
        if (!$bulan) {
            return $val;
        } else {
            return date_format(date_create($bulan), "d") . '/' . $m . '/' . date_format(date_create($bulan), "Y");
        }
    }
    public function getDept()
    {

        $model = Tblprcobiodata::find()->where(['ICNO' => $this->icno])->one();

        return $model;
    }
    public function getPersons()
    {
        return $this->hasMany(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public static function getLeaveRecord($icno, $year = null, $month, $day)
    {
        if (!$year) {
            $year = date('Y');
        }
        // var_dump($icno, $year, $month, $day);die;
        $sql = 'SELECT * FROM hrm.cuti_tbl_records a
                        JOIN hronline.tblprcobiodata b ON a.icno = b.ICNO 
                        JOIN hronline.department c ON b.deptId = c.id
                        WHERE a.status = "APPROVED"
                        -- AND (a.`cuti_batal` = "0" OR a.`cuti_batal` IS NULL)
			AND year(a.`start_date`) = :year
                        AND (month(a.`start_date`) = :month OR month(a.`end_date`) = :month)
                        AND a.`jenis_cuti_id` = 1
                        AND a.icno = :icno
                         ';

        $model = TblRecords::findBySql($sql, [':icno' => $icno, ':year' => $year, ':month' => $month])->all();

        // var_dump($model->start_month);
        // die;
        foreach ($model as $row) {


            // if ($row->cuti_mula_month != $row->cuti_tamat_month) {
            if (date("m", strtotime($row->start_date)) != date("m", strtotime($row->end_date))) {

                $last_day_on_month = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31


                if (($day >= date("d", strtotime($row->start_date)) && $day <= $last_day_on_month && date("d", strtotime($row->start_date)) == $month)) { #detect cuti mula smpi hujung bulan mesti bulan yang sama

                    return true;
                } else if ($day >= 1 && $day <= date("d", strtotime($row->end_date))) { #detect cuti tamat mula dari 1hb bulan tersebut

                    return true;
                }
            } else {

                if ($day >= date("d", strtotime($row->start_date)) && $day <= date("d", strtotime($row->end_date))) {
                    return true;
                }
            }
        }
    }
    public static function totalPendingSub($icno)
    {
        // $count = Yii::$app->cache->get('total-pending-approval-'.$icno);
        // if(!$count){
        $count = self::find()
            ->where(['ganti_by' => $icno, 'status' => 'ENTRY'])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-approval-'.$icno, $count);
        // }

        return $count;
    }
    public static function totalPendingSickLeave($icno)
    {
        // $count = Yii::$app->cache->get('total-pending-approval-'.$icno);
        // if(!$count){
            $count = self::find()
            ->where(['semakan_by' => $icno])
            ->andWhere(['IN', 'status', ['ENTRY']])
            ->andWhere(['IN', 'jenis_cuti_id', ['20','21','58']])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-approval-'.$icno, $count);
        // }

        return $count;
    }
    public static function totalPendingVerify($icno)
    {
        // $count = Yii::$app->cache->get('total-pending-approval-'.$icno);
        // if(!$count){
        $count = self::find()
            ->where(['peraku_by' => $icno])
            ->andWhere(['IN', 'status' ,['AGREED','CHECK']])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-approval-'.$icno, $count);
        // }

        return $count;
    }
    //upload
    public static function totalPendingUpload($icno)
    {
        // $count = Yii::$app->cache->get('total-pending-approval-'.$icno);
        // if(!$count){
        $count = self::find()
            ->where(['icno' => $icno, 'status' => 'APPROVED', 'jenis_cuti_id' => 28])
            ->andWhere(['YEAR(start_date)' => date('Y')])
            ->andWhere(['=','file1','NULL'])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-approval-'.$icno, $count);
        // }

        return $count;
    }
    public static function totalPendingApproval($icno)
    {
        // $count = Yii::$app->cache->get('total-pending-approval-'.$icno);
        // if(!$count){
        $count = self::find()
            ->where(['lulus_by' => $icno, 'status' => 'VERIFIED'])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-approval-'.$icno, $count);
        // }

        return $count;
    }
    public static function totalPendingCbApproval($icno)
    {
        // $count = Yii::$app->cache->get('total-pending-approval-'.$icno);
        // if(!$count){
        $count = self::find()
            ->where(['p_verify' => $icno, 'status' => 'VERIFIED_KJ'])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-approval-'.$icno, $count);
        // }

        return $count;
    }
    public static function totalPendingChecking($icno)
    {
        // $count = Yii::$app->cache->get('total-pending-approval-'.$icno);
        // if(!$count){
        $count = self::find()
            ->where(['semakan_by' => $icno])
            ->andWhere(['IN', 'status', ['BSMCHECK']])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-approval-'.$icno, $count);
        // }

        return $count;
    }
    public static function totalAppcb($icno)
    {
        $counts = self::find()->where(['icno' => $icno, 'jenis_cuti_id' => 28])->andWhere(['>=  ','tempoh', '30'])->asArray()->count('id');
        $count = self::viewNom($counts);
        return $count;
    }
    public static function totalChild($icno)
    {
        $counts = Tblkeluarga::find()->where(['ICNO' => $icno])->andWhere(['RelCd' => '05'])->asArray()->count('ICNO');
        $count = self::viewNom($counts + 1);
        return $count;
    }
    public static function viewNom($nom)
    {
        // var_dump($nom);die;
        $v = '';
        if ($nom == 1) {
            $v = 'Pertama';
        }
        if ($nom == 2) {
            $v = 'Kedua';
        }
        if ($nom == 3) {
            $v = 'Ketiga';
        }
        if ($nom == 4) {
            $v = 'Keempat';
        }
        if ($nom == 5) {
            $v = 'Kelima';
        }
        if ($nom == 6) {
            $v = 'Keenam';
        }
        if ($nom == 7) {
            $v = 'Ketujuh';
        }
        if ($nom == 8) {
            $v = 'Kelapan';
        }
        if ($nom == 9) {
            $v = 'Kesembilan';
        }
        if ($nom == 10) {
            $v = 'Kesepuluh';
        }
        if ($nom == 11) {
            $v = 'Kesebelas';
        }
        if ($nom == 12) {
            $v = 'Keduabelas';
        }
        return $v;
    }
    public static function totalPending($icno, $cat)
    {
        //pengganti
        if ($cat == 1) {
            $model = TblRecords::find()->where(['ganti_by' => $icno])->andWhere(['status' => 'ENTRY'])->asArray()->count('icno');

            // $total = count($model);
            $total = $model;
        }

        if ($cat == 2) {
            $ic = Tindakan::behalf($icno);
            if (!$ic) {
                $ic = $icno;
            }
            $model = TblRecords::find()->where(['peraku_by' => $ic])->andWhere(['IN', 'status', ['AGREED', 'CHECK']])->asArray()->count('icno');
            $model1 = TblRecords::find()->where(['lulus_by' => $ic])->andWhere(['IN', 'status', ['CHECKED', 'VERIFIED']])->asArray()->count('icno');
            $model2 = GcrApplication::find()->where(['peraku_by' => $ic])->andWhere(['status' => 'CHECKED'])->asArray()->count('pemohon_icno');
            $model3 = GcrApplication::find()->where(['lulus_by' => $ic])->andWhere(['status' => 'VERIFIED'])->asArray()->count('pemohon_icno');

            // $total = $model + $model1;
            if ($model) {
                $total = $model + $model3 + $model2;
            } else {
                $total = $model1 + $model2 + $model3;
            }
            // $total = count($model) + count($model1);
        }
        if ($cat == 7) {
            $ic = Tindakan::behalf($icno);
            if (!$ic) {
                $ic = $icno;
            }
            $model = TblRecords::find()->where(['peraku_by' => $ic])->andWhere(['IN', 'status', ['AGREED', 'CHECK']])->asArray()->count('icno');
            $model1 = TblRecords::find()->where(['lulus_by' => $ic])->andWhere(['IN', 'status', ['CHECKED', 'VERIFIED']])->asArray()->count('icno');

            // $total = $model + $model1;
            if ($model) {
                $total = $model;
            } else {
                $total = $model1;
            }
            // $total = count($model) + count($model1);
        }

        if ($cat == 3) {
            // $model = TblRecords::find()->where(['semakan_by' => $icno])->andWhere(['status' => 'ENTRY'])->asArray()->count('icno');
            $model = TblRecords::find()->where(['semakan_by' => $icno])->andWhere(['status' => 'ENTRY'])->andWhere(['IN', 'jenis_cuti_id', ['20', '21','58']])->asArray()->count('icno');
            $model1 = GcrApplication::find()->where(['semakan_by' => $icno])->andWhere(['status' => 'ENTRY'])->asArray()->count('semakan_by');

            // $total = count($model);
            $total = $model;
        }

        if ($cat == 4) {
            $manage = TblManagement::findOne(['icno' => $icno]);
            if($manage){
            $model = TblRecords::find()->where(['IN', 'status', ['BSMCHECK']])->asArray()->count('icno');
            }else{
                $model = 0;
            }
            $total = $model;
            // $total = count($model);
        }
        // if ($cat == 4) {
        //     $model = GcrApplication::find()->where(['semakan_by' => $icno])->andWhere(['status' => 'ENTRY'])->asArray()->count('icno');

        //     $total = $model;
        //     // $total = count($model);
        // }
        if ($cat == 5) {
            $model = GcrApplication::find()->where(['peraku_by' => $icno])->andWhere(['status' => 'CHECKED'])->asArray()->count('pemohon_icno');
            // $model = GcrApplication::find()->where(['lulus_by' => $icno])->andWhere(['status' => 'VERIFIED'])->asArray()->count('icno');

            $total = $model;
            // $total = count($model);
        }
        // if ($cat == 6) {
        //     $model = GcrApplication::find()->where(['lulus_by' => $icno])->andWhere(['status' => 'VERIFIED'])->asArray()->count('icno');

        //     $total = $model;
        //     // $total = count($model);
        // }

        if ($total > 0) {
            return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
        } else {
            return '';
        }
    }

    public static function viewBulan($mth)
    {

        $nama_bulan = '';

        if ($mth == 1) {
            $nama_bulan = 'January';
        }
        if ($mth == 2) {
            $nama_bulan = 'February';
        }
        if ($mth == 3) {
            $nama_bulan = 'Mac';
        }
        if ($mth == 4) {
            $nama_bulan = 'April';
        }
        if ($mth == 5) {
            $nama_bulan = 'May';
        }
        if ($mth == 6) {
            $nama_bulan = 'June';
        }
        if ($mth == 7) {
            $nama_bulan = 'July';
        }
        if ($mth == 8) {
            $nama_bulan = 'August';
        }
        if ($mth == 9) {
            $nama_bulan = 'September';
        }
        if ($mth == 10) {
            $nama_bulan = 'October';
        }
        if ($mth == 11) {
            $nama_bulan = 'November';
        }
        if ($mth == 12) {
            $nama_bulan = 'December';
        }


        return $nama_bulan;
    }

    public static function usedcutibyyear($icno, $type, $year)
    {
        $model = self::find()->where(['icno' => $icno, 'jenis_cuti_id' => $type, 'status' => 'APPROVED'])->andWhere('YEAR(start_date) =' . $year)->sum('tempoh');

        return $model ? $model : 0;
    }



    public static function getSums($jenis, $dept, $year)
    {
        // $year = ''
        // $jenis = '20';
        $sum = 0;
        $total = TblRecords::find()->joinWith('kakitangan')
            ->where(['jenis_cuti_id' => $jenis])->andWhere(['YEAR(start_date)' => $year])
            ->andWhere(['hronline.tblprcobiodata.DeptId' => $dept])->all();

        foreach ($total as $sums) {
            $sum += $sums['tempoh'];
        }
        return $sum;
        // return $model;
    }
    public static function getTotalApp($jenis, $dept, $year)
    {
        // $year = ''
        // $jenis = '20';
        $sum = 0;
        $model = TblRecords::find()->joinWith('kakitangan')
            ->where(['jenis_cuti_id' => $jenis])->andWhere(['YEAR(start_date)' => $year])
            ->andWhere(['hronline.tblprcobiodata.DeptId' => $dept])->count();

        return $model;
        // return $model;
    }
    public static function getTotal($provider, $columnName)
    {
        // var_dump($provider);die;
        $total = 0;
        foreach ($provider as $item) {
            $total += $item[$columnName];
        }
        return $total;
    }

    //checking for cuti penyelidikan
    public static function criteria($icno)
    {
        $sumtotal = 0;
        $value = false;
        $years = 0;
        $model = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $aca = GredJawatan::find()->where(['id' => $model->gredJawatan])->one(); //if job_group = 1
        $first = Tblrscoapmtstatus::find()->where(['ICNO' => $icno])->orderBy(['ApmtStatusStDt' => SORT_ASC])->andWhere(['=', 'ApmtStatusCd', '1'])->one(); //if apmtstatuscd = 1
        if ($first) {
            $years = date('Y', strtotime(date('Y-m-d'))) - date('Y', strtotime($first->ApmtStatusStDt));
        }
        $cp = TblRecords::find()->where(['icno' => $icno])->andWhere(['jenis_cuti_id' => 17])->all();
        if ($cp) {
            foreach ($cp as $c) {
                $sumtotal += $c['tempoh'];
            }
        }
        // var_dump($sumtotal,$model->Status,$aca->job_category);die;
        if (($model->Status == 1) && ($aca->job_category == 1) && ($first) && ($years > 3) && ($sumtotal < 90)) {
            $value = true;
        }
        ///$cb = 

        return $value;
    }

    public static function viewStatus($icno)
    {

        $v = false;
        $model = TblRecords::find()->where(['icno' => $icno])->andWhere(['jenis_cuti_id' => 17])->andWhere(['status' => 'INCOMPLETE'])->all();

        if ($model) {
            $v = true;
        }
        return $v;
    }
    public function getAdmin()
    {
        return $this->hasOne(\app\models\cbelajar\TblAccess::className(), ['icno' => 'tblprcobiodata.ICNO']);
    }
    // cuti penyelidikan
    public function getTempohpenyelidikan()
    {


        $date1 = TblRecords::find()->where(['ICNO' => $this->icno])->min('start_date');
        $date2 = TblRecords::find()->where(['ICNO' => $this->icno])->min('end_date');


        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $months = 0;

        while (strtotime('+1 MONTH', $ts1) < $ts2) {
            $months++;
            $ts1 = strtotime('+1 MONTH', $ts1);
        }
        if ((($ts2 - $ts1) / (60 * 60 * 24) + 1) >= 31) {
            $months++;
            $day = (($ts2 - $ts1) / (60 * 60 * 24) + 1) - 31;
            if ($day != 0) {
                $disday = $day . ' Hari';
            } else {
                $disday = '';
            }
        } else {
            $disday = (($ts2 - $ts1) / (60 * 60 * 24) + 1) . ' Hari';
        }

        return $months . ' Bulan ' . $disday; // 120 month, 26 days


    }
    public function getKetuajfpiu()
    {
        $pegawai = \app\models\hronline\Department::findOne(['id' => $this->kakitangan->DeptId]);
        if ($this->kakitangan->department->sub_of == '' || $this->kakitangan->department->sub_of == '12') {
            return $this->kakitangan->department->chiefBiodata->CONm; //kj 
        } else {
            $pegawaisub = \app\models\hronline\Department::findOne(['id' => $pegawai->sub_of]);
            return $pegawaisub->chiefBiodata->CONm; //kj
        }
    }
    // public static function button($id)
    // {
    //     $model = self::find()->where(['id' => $id])->andWhere(['file1' ]);
    //     $val = false;
    //     if ($model) {

    //         if ($model->status == 2) {
    //             $val = true;
    //         }
    //     }

    //     return $val;
    // }
    public static function statuslantik($id){

        $val = "";
        $model = ServiceStatus::findOne(['ServStatusCd'=>$id]);
        if($model){
            $val = $model->ServStatusNm;
        }
        return $val;
    }
    public static function campus($id){

        $val = "";
        $model = Tblprcobiodata::findOne(['ICNO'=>$id]);
        $campus = Campus::findOne(['campus_id' => $model->campus_id]);
        if($model){
            $val = $campus->campus_name;
        }
        return $val;
    }
    // //api involved ini staffonleave pnya
    public static function TeamList($icno)
    {
        // $icno = "740717125489";

        $api_url = 'https://registrar.ums.edu.my/staff/web/api/dashboard/team?icno='.''.$icno;
        // $api_url = 'http://localhost/staff/web/api/dashboard/team?icno='.''.$icno;

        // Read JSON file
        $json_data = file_get_contents($api_url);

        // Decode JSON data into PHP array
        $response_data = json_decode($json_data);

        return $response_data;
    }
    public static function Count($icno)
    {
        // $icno = "740717125489";
        $api_url = 'https://registrar.ums.edu.my/staff/web/api/dashboard/count?icno='.''.$icno;
        // $api_url = 'http://localhost/staff/web/api/dashboard/count?icno='.''.$icno;

        // Read JSON file
        $json_data = file_get_contents($api_url);

        // Decode JSON data into PHP array
        $response_data = json_decode($json_data);

        return $response_data;
    }
    public static function CountSkb($icno)
    {
        // $icno = "740717125489";
        $api_url = 'https://registrar.ums.edu.my/staff/web/api/dashboard/countskb?icno='.''.$icno;
        // $api_url = 'http://localhost/staff/web/api/dashboard/count?icno='.''.$icno;

        // Read JSON file
        $json_data = file_get_contents($api_url);

        // Decode JSON data into PHP array
        $response_data = json_decode($json_data);

        return $response_data;
    }
    public static function CountWfh($icno)
    {
     
        $api_url = 'https://registrar.ums.edu.my/staff/web/api/dashboard/count-wfh?icno='.''.$icno;
        // $api_url = 'http://localhost/staff/web/api/dashboard/count-wfh?icno='.''.$icno;

        // Read JSON file
        $json_data = file_get_contents($api_url);

        // Decode JSON data into PHP array
        $response_data = json_decode($json_data);

        return $response_data;
    }
    //clock in
    public static function Counts($icno)
    {
     
        $api_url = 'https://registrar.ums.edu.my/staff/web/api/dashboard/count-wfh?icno='.''.$icno;
        // $api_url = 'http://localhost/staff/web/api/dashboard/counts?icno='.''.$icno;

        // Read JSON file
        $json_data = file_get_contents($api_url);

        // Decode JSON data into PHP array
        $response_data = json_decode($json_data);

        return $response_data;
    }
}
