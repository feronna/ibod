<?php

namespace app\models\penamatanperkhidmatan;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\penamatanperkhidmatan\TblJenispenamatan;
use app\models\penamatanperkhidmatan\TblPengesahan;
use app\models\vhrms\DboMonthlyPayroll;
use app\models\vhrms\VwStaffProfile;
use app\models\hronline\Department;
/**
 * This is the model class for table "penamatanperkhidmatan.tbl_permohonan".
 *
 * @property int $id
 * @property string $icno
 * @property string $kj
 * @property string $pp
 * @property int $jenis_penamatan
 * @property string $tarikh_terakhirbekerja
 * @property string $jawatan_baru
 * @property string $jabatan_baru
 * @property string $tarikh_mohon
 * @property string $sebab
 * @property int $baki_kontrak
 * @property int $status_kj
 * @property int $status_bn
 * @property int $status_perpustakaan
 * @property int $status_jtmk
 * @property int $status_pppi
 * @property int $status_jfpiu
 * @property int $status_ppuu
 * @property int $status_bsm
 * @property int $status_keselamatan
 * @property string $tarikh_kj
 * @property string $tarikh_bn
 * @property string $tarikh_perpustakaan
 * @property string $tarikh_jtmk
 * @property string $tarikh_pppi
 * @property string $tarikh_jfpiu
 * @property string $tarikh_ppuu
 * @property string $tarikh_bsm
 * @property string $tarikh_keselamatan
 * @property int $pendeknotis
 * @property string $dokumenpendeknotis
 * @property int $sebabpendeknotis_id
 * @property int $status_pendeknotis
 * @property int $job_category
 * @property string $tarikh_hentigaji
 * @property string $tarikh_berhenti
 * @property string $tarikh_tutupfail
 */
class TblPermohonan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file ;
    public static function tableName()
    {
        return 'hrm.tamat_tbl_permohonan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'jenis_penamatan', 'tarikh_terakhirbekerja', 'sebab'], 'required'],
            [['jenis_penamatan', 'baki_kontrak', 'status_kj', 'status_bn', 'status_perpustakaan', 'status_jtmk', 'status_pppi', 'status_jfpiu', 'status_ppuu', 'status_bsm', 'status_keselamatan', 'pendeknotis', 'sebabpendeknotis_id', 'status_pendeknotis', 'job_category'], 'integer'],
            [['tarikh_terakhirbekerja', 'tarikh_mohon', 'tarikh_kj', 'tarikh_bn', 'tarikh_perpustakaan', 'tarikh_jtmk', 'tarikh_pppi', 'tarikh_jfpiu', 'tarikh_ppuu', 'tarikh_bsm', 'tarikh_keselamatan', 'tarikh_hentigaji', 'tarikh_berhenti', 'tarikh_tutupfail'], 'safe'],
            [['sebab'], 'string'],
            [['icno', 'kj', 'pp'], 'string', 'max' => 15],
            [['jawatan_baru', 'jabatan_baru'], 'string', 'max' => 255],
            [['dokumenpendeknotis'], 'string', 'max' => 100],
            [['file'],'safe'],
            [['file'], 'file','extensions'=>'pdf', 'maxSize' => 5000000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'kj' => 'Kj',
            'pp' => 'Pp',
            'jenis_penamatan' => 'Jenis Penamatan',
            'tarikh_terakhirbekerja' => 'Tarikh Terakhirbekerja',
            'jawatan_baru' => 'Jawatan Baru',
            'jabatan_baru' => 'Jabatan Baru',
            'tarikh_mohon' => 'Tarikh Mohon',
            'sebab' => 'Sebab',
            'baki_kontrak' => 'Baki Kontrak',
            'status_kj' => 'Status Kj',
            'status_bn' => 'Status Bn',
            'status_perpustakaan' => 'Status Perpustakaan',
            'status_jtmk' => 'Status Jtmk',
            'status_pppi' => 'Status Pppi',
            'status_jfpiu' => 'Status Jfpiu',
            'status_ppuu' => 'Status Ppuu',
            'status_bsm' => 'Status Bsm',
            'status_keselamatan' => 'Status Keselamatan',
            'tarikh_kj' => 'Tarikh Kj',
            'tarikh_bn' => 'Tarikh Bn',
            'tarikh_perpustakaan' => 'Tarikh Perpustakaan',
            'tarikh_jtmk' => 'Tarikh Jtmk',
            'tarikh_pppi' => 'Tarikh Pppi',
            'tarikh_jfpiu' => 'Tarikh Jfpiu',
            'tarikh_ppuu' => 'Tarikh Ppuu',
            'tarikh_bsm' => 'Tarikh Bsm',
            'tarikh_keselamatan' => 'Tarikh Keselamatan',
            'pendeknotis' => 'Pendeknotis',
            'dokumenpendeknotis' => 'Dokumenpendeknotis',
            'sebabpendeknotis_id' => 'Sebabpendeknotis ID',
            'status_pendeknotis' => 'Status Pendeknotis',
            'job_category' => 'Job Category',
            'tarikh_hentigaji' => 'Tarikh Hentigaji',
            'tarikh_berhenti' => 'Tarikh Berhenti',
            'tarikh_tutupfail' => 'Tarikh Tutupfail',
        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getJenisPenamatan(){
        return $this->hasOne(TblJenispenamatan::className(), ['id' => 'jenis_penamatan']);
    }
    
    public function getStatusbn() {
        if ($this->status_bn == '0' || $this->status_bn == '1') {
            return '<span style="color: white" class="label label-success">Selesai</span>';
        }
        if ($this->status_bn == NULL) {
            return '<span style="color: white" class="label label-warning">Menunggu</span>';
        }
    }
    
    public function getStatusperpustakaan() {
        if ($this->status_perpustakaan == '0' || $this->status_perpustakaan == '1') {
            return '<span style="color: white" class="label label-success">Selesai</span>';
        }
        if ($this->status_perpustakaan == NULL) {
            return '<span style="color: white" class="label label-warning">Menunggu</span>';
        }
    }
    
    public function getStatusjtmk() {
        
        if ($this->status_jtmk == '0' || $this->status_jtmk == '1') {
            return '<span style="color: white" class="label label-success">Selesai</span>';
        }
        if ($this->status_jtmk == NULL) {
            return '<span style="color: white" class="label label-warning">Menunggu</span>';
        }
    }
    
    public function getStatusppuu() {
        
        if ($this->status_ppuu == '0' || $this->status_ppuu == '1') {
            return '<span style="color: white" class="label label-success">Selesai</span>';
        }
        if ($this->status_ppuu == NULL) {
            return '<span style="color: white" class="label label-warning">Menunggu</span>';
        }
    }
    
    public function getStatuspppi() {
        if ($this->status_pppi == '0' || $this->status_pppi == '1') {
            return '<span style="color: white" class="label label-success">Selesai</span>';
        }
        if ($this->status_pppi == NULL) {
            return '<span style="color: white" class="label label-warning">Menunggu</span>';
        }
    }
    
    public function getStatusjfpiu() {
        if ($this->status_jfpiu == '0' || $this->status_jfpiu == '1') {
            return '<span style="color: white" class="label label-success">Selesai</span>';
        }
        if ($this->status_jfpiu == NULL) {
            return '<span style="color: white" class="label label-warning">Menunggu</span>';
        }
    }
    
    public function getStatusbsm() {
        if ($this->status_bsm == '0' || $this->status_bsm == '1') {
            return '<span style="color: white" class="label label-success">Selesai</span>';
        }
        if ($this->status_bsm == NULL) {
            return '<span style="color: white" class="label label-warning">Menunggu</span>';
        }
    }
    
    public function getStatuskj() {
        if ($this->status_kj == '0' || $this->status_kj == '1') {
            return '<span style="color: white" class="label label-success">Selesai</span>';
        }
        if ($this->status_kj == NULL) {
            return '<span style="color: white" class="label label-warning">Menunggu</span>';
        }
    }
    
    public function getStatuspengesahankj() {
        if ($this->status_kj == '1') {
            return '<span class="label label-success">Diluluskan</span>';
        }
        elseif ($this->status_kj == 0) {
            return '<span class="label label-warning">Ditolak</span>';
        }
    }
    
    public function getPinjamanbuku(){
        return $this->hasMany(TblPengesahan::className(), ['permohonan_id' => 'id'], function ($query) {
            $query->andWhere(['pengesahan_id' => 6]);
        });
    }
    
    public function getPinjamanjtmk(){
        return $this->hasMany(TblPengesahan::className(), ['permohonan_id' => 'id'], function ($query) {
            $query->andWhere(['pengesahan_id' => 7]);
        });
    }
    
    public function getTarikh($bulan){
        
        $m = date_format(date_create($bulan), "m");
        if($m == 01){
            $m = "Januari";}
        elseif ($m == 02){
          $m = "Februari";}
        elseif ($m == 03){
          $m = "Mac";}
        elseif ($m == 04){
          $m = "April";}
        elseif ($m == 05){
          $m = "Mei";}
        elseif ($m == 06){
          $m = "Jun";}
        elseif ($m == 07){
          $m = "Julai";}
        elseif ($m == '08'){
          $m = "Ogos";}
        elseif ($m == '09'){
          $m = "September";}
        elseif ($m == '10'){
          $m = "Oktober";}
        elseif ($m == '11'){
          $m = "November";}
        elseif ($m == '12'){
          $m = "Disember";}
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y");
    }
    
    public function getTarikhbn() {
        return $this->tarikh_bn? date_format(date_create($this->tarikh_bn), 'd/m/Y-h:i:sa'):'';
    }
    
    public function getTarikhperpustakaan() {
        return $this->tarikh_perpustakaan? date_format(date_create($this->tarikh_perpustakaan), 'd/m/Y-h:i:sa'):'';
    }
    
    public function getTarikhjtmk() {
        return $this->tarikh_jtmk? date_format(date_create($this->tarikh_jtmk), 'd/m/Y-h:i:sa'):'';
    }
    
    public function getTarikhppuu() {
        return $this->tarikh_ppuu? date_format(date_create($this->tarikh_ppuu), 'd/m/Y-h:i:sa'):'';
    }
    
    public function getTarikhpppi() {
        return $this->tarikh_pppi? date_format(date_create($this->tarikh_pppi), 'd/m/Y-h:i:sa'):'';
    }
    
    public function getTarikhjfpiu() {
        return $this->tarikh_jfpiu? date_format(date_create($this->tarikh_jfpiu), 'd/m/Y-h:i:sa'):'';
    }
    
    public function getTarikhbsm() {
        return $this->tarikh_bsm? date_format(date_create($this->tarikh_bsm), 'd/m/Y-h:i:sa'):'';
    }
    
    
    //pengiraan total pending
    
    public static function totalPendingkj($icno) {
        $model = TblPermohonan::find()->where(['kj' => $icno, 'status_kj' => NULL])->all();
        if ($model) {
                return '&nbsp;<span class="badge bg-red">'.count($model).'</span>';
            }
        else {
                return '';
        }
    }
    
    public static function totalPendingpp($icno) {
        $model = TblPermohonan::find()->where(['pp' => $icno, 'status_jfpiu' => NULL])->andWhere(['!=','status_kj','NULL'])->all();
        if ($model) {
                return '&nbsp;<span class="badge bg-red">'.count($model).'</span>';
            }
        else {
                return '';
        }
    }
    
    public static function totalPendingbn() {
        $model = TblPermohonan::find()->where(['status_kj' => 1, 'status_bn' => NULL])->andWhere(['!=','status_kj','NULL'])->all();
        if ($model) {
                return '&nbsp;<span class="badge bg-red">'.count($model).'</span>';
            }
        else {
                return '';
        }
    }
    
    public static function totalPendingperpustakaan() {
        $model = TblPermohonan::find()->where(['status_kj' => 1, 'status_perpustakaan' => NULL])->andWhere(['!=','status_kj','NULL'])->all();
        if ($model) {
                return '&nbsp;<span class="badge bg-red">'.count($model).'</span>';
            }
        else {
                return '';
        }
    }
    
    public static function totalPendingjtmk() {
        $model = TblPermohonan::find()->where(['status_kj' => 1, 'status_jtmk' => NULL])->andWhere(['!=','status_kj','NULL'])->all();
        if ($model) {
                return '&nbsp;<span class="badge bg-red">'.count($model).'</span>';
            }
        else {
                return '';
        }
    }
    
    public static function totalPendingppuu() {
        $model = TblPermohonan::find()->where(['status_kj' => 1, 'status_ppuu' => NULL])->andWhere(['!=','status_kj','NULL'])->all();
        if ($model) {
                return '&nbsp;<span class="badge bg-red">'.count($model).'</span>';
            }
        else {
                return '';
        }
    }
    
    public static function totalPendingpppi() {
        $model = TblPermohonan::find()->where(['status_kj' => 1, 'status_pppi' => NULL, 'job_category' => 1])->andWhere(['!=','status_kj','NULL'])->all();
        if ($model) {
                return '&nbsp;<span class="badge bg-red">'.count($model).'</span>';
            }
        else {
                return '';
        }
    }
    
    public static function totalPendingbsm() {
        $model = TblPermohonan::find()->where(['status_kj' => 1, 'status_bsm' => NULL])->andWhere(['!=','status_kj','NULL'])->all();
        if ($model) {
                return '&nbsp;<span class="badge bg-red">'.count($model).'</span>';
            }
        else {
                return '';
        }
    }
    
    public function getGajipokok(){
        $id = VwStaffProfile::find()->where(['sm_ic_no' => $this->icno])->one()->sm_staff_id;
        return DboMonthlyPayroll::find()->where(['MP_PROCESS' => '1', 'MP_STAFF_ID' => $id])->one()->MP_BASIC_PAY;
    }
    
    public static function ickj($icno){
        $bio = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $pegawai = Department::findOne(['id' => $bio->DeptId]);
        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
            return $pegawai->chief; //kj
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
            return  $pegawaisub->chief; //kj
        }
    }
    
    public static function icpp($icno){
        $bio = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $pegawai = Department::findOne(['id' => $bio->DeptId]);
        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
            return $pegawai->pp; //pp
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
            return $pegawaisub->pp; //pp
        }
    }
}
