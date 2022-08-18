<?php

namespace app\models\cbelajar;

use Yii;
use app\models\hronline\Tblprcobiodata;


/**
 * This is the model class for table "hrd.cb_tbl_tuntut".
 *
 * @property int $id
 * @property int $tahun
 * @property string $icno
 * @property string $j_tuntutan
 * @property string $app_by
 * @property string $app_date
 * @property string $ver_by
 * @property string $ver_date
 * @property string $tarikh_m
 * @property string $status
 */
class TblTuntut extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
               public $file,$file2,$file3,$file4;

    public static function tableName()
    {
        return 'hrd.cb_tbl_tuntut';
    }

    /**
     * {@inheritdoc}
     */
     public function rules()
    {
        return [
            [['file2','file3','file'], 'required', 'message'=>"Ruang ini wajib dimuatnaik"],
            [['tahun', 'bil', 'year','nilai_kgt','tahuna','tahunb'], 'integer'],
            [['app_date', 'ver_date', 'tarikh_m','SalMoveMthStDt'], 'safe'],
            [['dokumen', 'justifikasi', 'catatan', 'dokumen2', 'dokumen3', 'dokumen4','ulasan_bsm', 'ulasan_j'], 'string'],
            [['gaji_b', 'itp', 'epw', 'biw'], 'number'],
            [['icno', 'app_by', 'ver_by'], 'string', 'max' => 12],
            [['j_tuntutan', 'status_jfpiu', 'status_bsm', 'status_borang', 'status_semakan', 'dt_mesy', 'dt_kuat', 'app_dt', 'status_kgt', 'bulan_asalkgt', 'bulan_barukgt'], 'string', 'max' => 50],
            [['status','movtype'], 'string', 'max' => 25],
            [['agree'], 'string', 'max' => 10],
            [['idBorang'], 'string', 'max' => 5],
            [['terima'], 'string', 'max' => 20],
            [['status_j','statuss','SalMoveMthStDt'], 'string', 'max' => 255],
            [['file', 'file2', 'file3'], 'file','extensions'=>'pdf','maxSize' => 5000000], 
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahun' => 'Tahun',
            'icno' => 'Icno',
            'j_tuntutan' => 'J Tuntutan',
            'app_by' => 'App By',
            'app_date' => 'App Date',
            'ver_by' => 'Ver By',
            'ver_date' => 'Ver Date',
            'tarikh_m' => 'Tarikh M',
            'status' => 'Status',
            'status_jfpiu' => 'Status Jfpiu',
            'status_bsm' => 'Status Bsm',
            'agree' => 'Agree',
            'status_borang' => 'Status Borang',
            'idBorang' => 'Id Borang',
            'dokumen' => 'Dokumen',
            'justifikasi' => 'Justifikasi',
            'terima' => 'Terima',
            'catatan' => 'Catatan',
            'dokumen2' => 'Dokumen2',
            'dokumen3' => 'Dokumen3',
            'status_semakan' => 'Status Semakan',
            'ulasan_bsm' => 'Ulasan Bsm',
            'status_j' => 'Status J',
            'ulasan_j' => 'Ulasan J',
            'bil' => 'Bil',
            'year' => 'Year',
            'dt_mesy' => 'Dt Mesy',
            'dt_kuat' => 'Dt Kuat',
            'app_dt' => 'App Dt',
            'gaji_b' => 'Gaji B',
            'itp' => 'Itp',
            'epw' => 'Epw',
            'biw' => 'Biw',
            'status_kgt' => 'Status Kgt',
            'bulan_asalkgt' => 'Bulan Asalkgt',
            'bulan_barukgt' => 'Bulan Barukgt',
            'SalMoveMthStDt'=> 'Tarikh Mula',
        ];
    }

    
     public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getBorang() {
        return $this->hasOne(RefBorang::className(), ['id'=>'idBorang']);
    }
    
    function getStatusjfpiu() {
        if ($this->status_jfpiu == 'Tunggu Perakuan') {
            return '<span class="label label-warning">Menunggu</span>';
        }
        if ($this->status_jfpiu == 'Diperakukan') {
            return '<span class="label label-success">Diperakukan</span>';
        }
        if ($this->status_jfpiu == 'Tidak Diperakukan') {
            return '<span class="label label-danger">Ditolak</span>';
        }
}
 
 public function getBiasiswa() {
        return $this->hasOne(TblBiasiswa::className(), ['icno' => 'icno']);
    }

public function getStatusbsm() {
        if ($this->status_bsm == 'Tunggu Kelulusan') {
            return '<span class="label label-warning">Menunggu</span>';
        }
        if ($this->status_bsm == 'Diluluskan') {
            return '<span class="label label-success">Diluluskan</span>';
        }
        if ($this->status_bsm == 'Tidak Diluluskan') {
            return '<span class="label label-danger">Ditolak</span>';
        }
         if ($this->status_bsm === NULL) {
            return '-';
        }
    }
    public function getStudy2() {
       
       return TblPengajian::find()->where(['icno'=>$this->icno])->orderBy(['tarikh_mula'=>SORT_DESC])->one();
       
   }
    public function getStudysemasa()
   {       return TblPengajian::find()->where(['icno'=>$this->icno])->orderBy(['tarikh_mula'=>SORT_DESC])->one();


   }
     public function getClaim()
   {
               return $this->hasOne(TblPengajian::className(), ['icno'=>'icno'])->andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>[1,20,202]])
                       ->orderBy(['tarikh_mula' => SORT_DESC]);

   }
    public function getLapor() {
       
       return TblLapordiri::find()->where(['icno'=>$this->icno])->orderBy(['dt_lapordiri'=>SORT_DESC])->one();
       
   }
   public function getGajiBasic2() {
        $basic_pay = '';

        if ($model->kakitangan->NatStatusCd == 1) {
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
                    $basic_pay =  $gaji->MPH_BASIC_PAY;
                }
            }
        } else {
            $basic_pay = '<span class="required" style="color:red;"><b>Tiada Maklumat - Sila hubungi pegawai yang bertugas.</b></span>';
        }
        return $basic_pay;
    }
    
    public static function totalPendingTaskJawatan($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
        if($icno == "850711125215")
        {
            $total = count($model = TblTuntut::find()->where(['status' => 'MENUNGGU SEMAKAN PERJAWATAN', 'j_tuntutan'=>"HPG"])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
        }
    }
     public static function totalPendingTaskHpg($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
        if($icno == "840929125614")
        {
            $total = count($model = TblTuntut::find()->where(['status' =>"TELAH DISEMAK", 'j_tuntutan'=>['HPG']])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
        }
    }
     public static function totalPendingTaskAkhir($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
        if($icno == "840929125614")
        {
            $total = count($model = TblTuntut::find()->where(['status_bsm' =>"Tunggu Kelulusan", 'j_tuntutan'=>['AKHIR']])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
        }
    }
    public static function totalPendingTaskTesis($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
        if($icno == "840929125614")
        {
            $total = count($model = TblTuntut::find()->where(['status_bsm' =>"Tunggu Kelulusan", 'j_tuntutan'=>['TESIS']])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
        }
    }
    
     public static function totalPendingTaskYuran($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
        if($icno == "840929125614")
        {
            $total = count($model = TblTuntut::find()->where(['status_bsm' =>"Tunggu Kelulusan", 'j_tuntutan'=>['YURAN']])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
        }
    }
    public static function totalPendingTaskIelts($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
        if($icno == "840929125614")
        {
            $total = count($model = TblTuntut::find()->where(['status_bsm' =>"Tunggu Kelulusan", 'j_tuntutan'=>['IELTS']])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
        }
    }
    
     public static function totalPendingTaskVisa($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
        if($icno == "840929125614")
        {
            $total = count($model = TblTuntut::find()->where(['status_bsm' =>"Tunggu Kelulusan", 'j_tuntutan'=>['VISA','INSURANS']])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
        }
    }
    
    
}