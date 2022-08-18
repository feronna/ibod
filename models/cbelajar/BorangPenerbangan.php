<?php

namespace app\models\cbelajar;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "cbelajar.borang_kapal".
 *
 * @property int $id
 * @property string $icno
 * @property string $idBorang
 * @property string $idTempahan
 * @property string $idKelas
 * @property string $tarikh_mohon
 * @property string $jp_icno
 * @property int $tahun
 */
class BorangPenerbangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
           public $file,$file2;

    public static function tableName()
    {
        return 'hrd.cb_tblform_kapal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//             [['file','file2','cadangan_airlines','idBorang'], 'required', 'message'=>"Wajib diisi"],

            [['tarikh_mohon','app_date', 'ver_date','ad_dt'], 'safe'],
//            [['idBorang'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['icno'], 'string', 'max' => 12],
            [['agree','status_bsm','status_a','status_kj'], 'string', 'max' => 30],
            [['ulasan_kj','ulasan_a','justifikasi','no_peruntukan','catatan','cadangan_airlines'], 'string'],

            [['idBorang','borangID'], 'string', 'max' => 4],
//            [['agree','idBorang','justifikasi','dokumen','dokumen2', 'file', 'file2'], 'required', 'message' => 'Ruang ini adalah mandatori'],
//            [['file', 'file2'], 'file','extensions'=>'pdf'], 
            [['file', 'file2'], 'file','extensions'=>'pdf','maxSize' => 5000000], 


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
            'idBorang' => 'Id Borang',
            'tarikh_mohon' => 'Tarikh Mohon',
            'dokumen'=> 'Dokumen',
            'dokumen2'=> 'dOKUMEN2',
            'justifikasi' =>'JUSTIFIKASI',
            'agree'=> 'Setuju',
           
        ];
    }
    
     public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
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
    
    public function getTarikhmohon() {
        return $this->getTarikh($this->tarikhmohon);
    }
    
    public function getTarikhberlepas() {
        return $this->getTarikh($this->tarikh_berlepas);
    }
     public function getBorang() {
        return $this->hasOne(RefBorang::className(), ['id'=>'borangID']);
    }
    public function getStudy2() {
       
       return TblPengajian::find()->where(['icno'=>$this->icno, 'status'=>[1,2,4]])->orderBy(['tarikh_mula'=>SORT_DESC])->one();
       
   }
     public function getUpload(){
        return $this->hasOne(BorangPenerbangan::className(), ['id' => 'id']);
    }
    public function getTarikhtiba() {
        return $this->getTarikh($this->tarikh_tiba);
    }
    public function getJadualTempahan() {
        return $this->hasOne(JadualPenerbangan::className(), ['icno' => 'icno']);
    }
    
   public function checkUpload($id){
        $model = TblSurat::findOne(['icno' => Yii::$app->user->getId(),'icno' => $id]); 
        
        return $model;
    } 
    public function getStatusbsm() {
        if ($this->status_bsm == 'Tunggu Kelulusan') {
            return '<span class="label label-warning">MENUNGGU KELULUSAN BSM</span>';
        }
        if ($this->status_bsm == 'Diluluskan') {
            return '<span class="label label-success">DILULUSKAN</span>';
        }
         if ($this->status_bsm == 'Telah Diluluskan') {
            return '<span class="label label-success">DILULUSKAN</span>';
        }
        if ($this->status_bsm == 'Tidak Diluluskan') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
         if ($this->status_bsm === NULL) {
            return '-';
        }
    }
    public function getStatusadmin() {
        if ($this->status == 'DALAM TINDAKAN PP') {
            return '<span class="label label-warning">MENUNGGU TINDAKAN PENTADBIRAN</span>';
        }
        if ($this->status== 'TELAH DITEMPAH') {
            return '<span class="label label-info">TELAH DITEMPAH</span>';
        }
        if ($this->status== 'LULUS') {
            return '<span class="label label-info">TELAH DITEMPAH</span>';
        }
        
    }
     public function getDokumen(){
        return $this->hasOne(TblSurat::className(), ['icno' => 'id']);
    }
    
     public function getStudy() {
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno']);
    }
     public static function totalPendingReview($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
        if($icno == "701203106182")
        {
            $total = count($model = BorangPenerbangan::find()->where(['app_by' => $icno, 'status' => 'DALAM TINDAKAN KETUA JABATAN','idBorang'=>['CBDN','CBLN']])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
        }
    }
    
    public static function totalPendingTaskKj($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
        if($icno == "701203106182")
        {
            $total = count($model = BorangPenerbangan::find()->where(['status' => 'DALAM TINDAKAN BSM', 'idBorang'=>['CBDN','CBLN']])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
        }
    }
    
     public static function totalPendingTaskAdmin($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
        if($icno == "850403125133")
        {
            $total = count($model = BorangPenerbangan::find()->where(['status' =>"DALAM TINDAKAN PP", 'idBorang'=>['CBDN','CBLN']])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
        }
    }
    
    public static function totalPendingTaskKapal($icno) {

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
            $total = count($model = BorangPenerbangan::find()->where(['status_bsm' =>"Tunggu Kelulusan", 'idBorang'=>['CBDN','CBDL','TUNT']])->all());
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
