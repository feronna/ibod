<?php

namespace app\models\cbelajar;

use Yii;
use app\models\ejobs\JenisUser; 
use app\models\cbelajar\TblUrusMesyuarat;  
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\TblConfirm;
use app\models\hronline\Tblrscoconfirmstatus;
use app\models\cbelajar\TblPengajian;
use app\models\cbelajar\TblBiasiswa;
use app\models\cbelajar\TblSurat;
use app\models\cbelajar\RefPenajaan;
class TblPermohonan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
//   public $agree;
    public static function tableName()
    {
        return 'hrd.cb_tbl_permohonan';
    }

 public function rules()
    {
        return [
//            [['iklan_id', 'icno', 'jenis_user_id'], 'required'],
            [['iklan_id', 'jenis_user_id', 'dustBstatus', 'kategori_id', 'status_id', 'letter_sent', 'surat', 'tahun', 'HighestEduLevelCd', 'modeID', 'BantuanCd', 'BantuanCd_ums', 'idBorang'], 'integer'],
            [['tarikh_m', 'app_date', 'ver_date', 'lulus_date', 'date_issue', 'created_at', 'tarikh_mula', 'tarikh_tamat','c_date'], 'safe'],
            [['ulasan_jfpiu', 'ulasan_bsm', 'dokumen_sokongan', 'catatan_terima','catatan_tawaran'], 'string'],
            [['icno', 'app_by', 'ver_by'], 'string', 'max' => 12],
            [['status_jfpiu', 'status_bsm', 'agree'], 'string', 'max' => 30],
            [['terima', 'job_category', 'gelaran'], 'string', 'max' => 10],
            [['status'], 'string', 'max' => 50],
            [['letter_reference', 'no_rujukan', 'kali_ke', 'ulasan', 'baki_bon', 'CountryCd', 'InstNm'], 'string', 'max' => 255],
            [['tarikh_mesyuarat'], 'string', 'max' => 122],
            [['penajaanCd', 'status_mesyuarat','tawaran'], 'string', 'max' => 20],
            [['status_proses','jenis'], 'string', 'max' => 50],
            [['status_semakan'], 'string', 'max' => 100],
        ];
    }
   public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iklan_id' => 'Iklan ID',
            'icno' => 'Icno',
            'jenis_user_id' => 'Jenis User ID',
            'tarikh_m' => 'Tarikh M',
            'dustBstatus' => 'Dust Bstatus',
            'app_by' => 'App By',
            'ver_by' => 'Ver By',
            'app_date' => 'App Date',
            'ver_date' => 'Ver Date',
            'lulus_date' => 'Lulus Date',
            'status_jfpiu' => 'Status Jfpiu',
            'terima' => 'Terima',
            'status_bsm' => 'Status Bsm',
            'status' => 'Status',
            'kategori_id' => 'Kategori ID',
            'job_category' => 'Job Category',
            'status_id' => 'Status ID',
            'ulasan_jfpiu' => 'Ulasan Jfpiu',
            'letter_reference' => 'Letter Reference',
            'no_rujukan' => 'No Rujukan',
            'kali_ke' => 'Kali Ke',
            'date_issue' => 'Date Issue',
            'tarikh_mesyuarat' => 'Tarikh Mesyuarat',
            'letter_sent' => 'Letter Sent',
            'gelaran' => 'Gelaran',
            'ulasan' => 'Ulasan',
            'ulasan_bsm' => 'Ulasan Bsm',
            'penajaanCd' => 'Penajaan Cd',
            'dokumen_sokongan' => 'Dokumen Sokongan',
            'surat' => 'Surat',
            'status_semakan' => 'Status Semakan',
            'created_at' => 'Created At',
            'tahun' => 'Tahun',
            'baki_bon' => 'Baki Bon',
            'agree' => 'Agree',
            'status_mesyuarat' => 'Status Mesyuarat',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
            'CountryCd' => 'Country Cd',
            'InstNm' => 'Inst Nm',
            'modeID' => 'Mode ID',
            'tarikh_mula' => 'Tarikh Mula',
            'tarikh_tamat' => 'Tarikh Tamat',
            'BantuanCd' => 'Bantuan Cd',
            'BantuanCd_ums' => 'Bantuan Cd Ums',
            'idBorang' => 'Id Borang',
            
        ];
    }
public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'DeptId']);
    }
    public function getAkademik(){
        return $this->hasMany(TblPermohonan::className(), ['icno' => 'icno', 'status'=> "status"]);
    }
    public function getPendidikanTertinggi() {
        return $this->hasOne(Edulevel::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
   }
 public function markahlnpt($tahun) {
        
        if($this->jenis_user_id == '2'){
        $userid = \app\models\lppums\Lpp::find()->where(['PYD' => $this->icno, 'tahun' => $tahun])->one()->lpp_id;
        return $userid? \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $userid])->one()->markah_PP:'';}
        
        elseif($this->jenis_user_id == '1'){
            if($tahun < 2019){
            $id = \app\models\elnpt\elnpt_lama\TblUser::find()->where(['user_id' => $this->icno])->one()->staff_id;
            return \app\models\elnpt\elnpt_lama\TblMarkahLama::find()->where(['staff_id' => $id, 'tahun' => $tahun])->one()->purata;
            }
            
           $markah = \app\models\elnpt\TblMain::find()->where(['PYD' => $this->icno, 'tahun'=>$tahun])->one()->markahAll->markah;
           return $markah=='0'? '':$markah;
        }
        else
        {
            return '-';
        }
    }
   public function getTahapPendidikan() {
      
       return $this->pendidikanTertinggi->HighestEduLevel;
   }
   
    public function getPengajian(){
//        $model2 = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('id'); 
        return $this->hasMany(TblLanjutan::className(), ['icno' => 'icno']);
              

    }
    public function getKetuajfpiu(){
        $pegawai = \app\models\hronline\Department::findOne(['id' => $this->kakitangan->DeptId]);
        if($this->kakitangan->department->sub_of == '' || $this->kakitangan->department->sub_of == '12'){
        return $this->kakitangan->department->chiefBiodata->CONm; //kj 
        }
        else{
        $pegawaisub = \app\models\hronline\Department::findOne(['id' => $pegawai->sub_of]);
        return $pegawaisub->chiefBiodata->CONm; //kj
        }
    }
    public function getS() {
       
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno'])->where(['status'=>[9,1,10,6,8]])->orderBy(['tarikh_mohon'=>SORT_DESC]);
       
   }
//    public function getS(){
//        return $this->hasMany(TblPengajian::className(), ['icno' => 'icno']);
//    }
    
      public function getBelajar() {
       
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno','idPermohonan'=>'id'])->where(['status'=>9]);
       
   }
    public function getTajaan() {
        return $this->hasOne(TblBiasiswa::className(), ['icno'=>'icno', 'idPermohonan'=>'id']);
    }
   public function getStudi() {
       
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno'])->where(['status'=>9]);
       
   }
    public function getPenerbangan(){
        return $this->hasMany(BorangPenerbangan::className(), ['icno' => 'icno']);
    }
    
     public function getLain(){
        return $this->hasMany(TblLain::className(), ['icno' => 'icno']);
    }
    
     public function getLapor(){
        return $this->hasMany(TblLapordiri::className(), ['icno' => 'icno']);
        
    }
     public function getLkk(){
        return $this->hasMany(TblLkk::className(), ['icno' => 'icno']);
    }
     public function getKategori(){
        return $this->hasOne(\app\models\cbelajar\KategoriMesyuarat::className(), ['id' => 'kategori_id']);  
    }


      public function getJenisUser(){
        return $this->hasOne(JenisUser::className(), ['id' => 'jenis_user_id']);
    }
     
//    public function getCheckPermohonan(){
//        return $this->hasOne(Iklan::className(), ['id' => 'iklan_id','ICNO' => 'ICNO']);
//    }
     public function getImg() {
        return $this->hasOne(TblpImage::className(), ['ICNO' => 'icno', 'iklan_id'=>'iklan_id']);
    }
    
    public function getConfirmstatus() {
        return $this->hasOne(TblConfirm::className(), ['ICNO' => 'icno']);
    }
     public function getBorang() {
        return $this->hasOne(RefBorang::className(), ['id'=>'idBorang']);
    }

    public function getDokumen(){
        return $this->hasOne(TblSurat::className(), ['icno' => 'id']);
    }
    public function getFilekpm() {
       
       return TblFileKpm::find()->where(['idPermohonan'=>$this->id])->one();
       
   }

     public function getCreated() {
        return  $this->getTarikh($this->created_at);
    }

    public function getStatusjfpiu() {
        if ($this->status_jfpiu == 'Tunggu Perakuan') {
            return '<span class="label label-warning">DALAM TINDAKAN KJ</span>';
        }
        if ($this->status_jfpiu == 'Diperakukan') {
            return '<span class="label label-success">DIPERAKUKAN</span>';
        }
        if ($this->status_jfpiu == 'Tidak Diperakukan') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }
    public function getStatuspengakuan() {
        if ($this->agree == '0') {
            return '<span class="label label-warning">Belum disimpan</span>';
        }
        if ($this->agree == '1') {
            return '<span class="label label-success">Telah disimpan</span>';
        }
       
    }
     public function getStatusbsm() {
        if ($this->status_bsm == 'Tunggu Kelulusan') {
            return '<span class="label label-warning">DALAM TINDAKAN KJ</span>';
        }
        if ($this->status_bsm == 'Tunggu Kelulusan BSM') {
            return '<span class="label label-success">DALAM TINDAKAN BSM</span>';
        }
        if ($this->status_bsm == 'Diluluskan') {
            return '<span class="label label-success">DILULUSKAN</span>';
        }
        if ($this->status_mesyuarat == 'Lulus Tanpa Pantauan') {
            return '<span class="label label-success">DILULUSKAN TANPA PEMANTAUAN BSM</span>';
        }
        if ($this->status_bsm == 'Tidak Diluluskan') {
            return '<span class="label label-danger">TIDAK DILULUSKAN</span>';
        }
         if ($this->status_bsm === NULL) {
            return '-';
        }
    }
    public function getStatusmesyuarat() {
        if ($this->status_mesyuarat == 'Diluluskan') {
            return '<span class="label label-success">DILULUSKAN</span>';
        }
        if ($this->status_mesyuarat == 'Lulus Tanpa Pantauan') {
            return '<span class="label label-warning">DILULUSKAN TANPA PEMANTAUAN BSM</span>';
        }
       
        if ($this->status_mesyuarat == 'Bersyarat') {
            return '<span class="label label-info">BERSYARAT</span>';
        }
        if ($this->status_mesyuarat == 'KIV') {
            return '<span class="label label-danger">KIV</span>';
        }
       
         if ($this->status_mesyuarat === NULL) {
            return '-';
        }
    }
    public function checkUpload($id){
        $model = TblSurat::findOne(['icno' => Yii::$app->user->getId(),'icno' => $id]); 
        
        return $model;
    } 
    public function getStatuss() {
       
        if ($this->status == 'DALAM TINDAKAN KETUA JABATAN') {
            return '<span class="label label-info">Dalam Tindakan KJ</span>';
        }
        if ($this->status == 'DALAM TINDAKAN BSM') {
            return '<span class="label label-primary">Dalam Tindakan BSM</span>';
        }
        if ($this->status == 'LULUS') {
            return '<span class="label label-success">BERJAYA</span>';
        }
        if ($this->status == 'TIDAK LULUS') {
            return '<span class="label label-danger">TIDAK BERJAYA</span>';
        }
         if ($this->status == 'TOLAK TAWARAN') {
            return '<span class="label label-default">TOLAK TAWARAN</span>';
        }
         if ($this->status == 'TERIMA TAWARAN') {
            return '<span class="label label-success">TERIMA TAWARAN</span>';
        }
         if ($this->status == 'Lulus Tanpa Pantauan') {
            return '<span class="label label-success">LULUS BERSYARAT</span>';
        }
        if ($this->status == '') {
            return '-';
        }
        if ($this->status == 'DALAM TINDAKAN KETUA JFPIU') {
            return '<span class="label label-default">Dalam Tindakan KJ</span>';
        }
       
        if ($this->status == '') {
            return '-';
        }
    }

     
    public function getStatussemakan() {
        if ($this->status_semakan == 'Tunggu Semakan') {
            return '<span class="label label-warning">MENUNGGU SEMAKAN</span>';
        }
        if ($this->status_semakan == 'Layak Dipertimbangkan') {
            return '<span class="label label-success">LAYAK DIPERTIMBANGKAN</span>';
        }
        if ($this->status_semakan == 'Dokumen Tidak Lengkap') {
            return '<span class="label label-danger">DOKUMEN TIDAK LENGKAP</span>';
        }
          if ($this->status_semakan == 'Tidak Layak Dipertimbangkan') {
            return '<span class="label label-danger">TIDAK LAYAK DIPERTIMBANGKAN</span>';
        }
    }
    
//     public function getStatusmesyuarat() {
//        if ($this->status_mesyuarat == 'Tunggu Keputusan') {
//            return '<span class="label label-warning">Menunggu</span>';
//        }
//        if ($this->status_mesyuarat == 'LULUS') {
//            return '<span class="label label-success">Diluluskan</span>';
//        }
//        if ($this->status_mesyuarat == 'BERSYARAT') {
//            return '<span class="label label-danger">Diluluskan dengan Bersyarat</span>';
//        }
//        
//         if ($this->status_mesyuarat == 'TIDAK DILULUSKAN') {
//            return '<span class="label label-danger">Tidak Diluluskan</span>';
//        }
//    }
    
    public function getTarikhMesyuarat() {
        return  $this->getTarikh($this->tarikh_mesyuarat);
    }
    
     

    public function getIklan(){
        return $this->hasOne(TblUrusMesyuarat::className(), ['id' => 'iklan_id']);
    }

  
//public function getImg(){
//        return $this->hasOne(TblpImage::className(), ['ICNO' => 'ICNO', 'id' => 'iklan_id']);
//    }
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
    

   public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
     public function getAccess() {
        return $this->hasOne(TblAccess::className(), ['icno' => ['891103125554']]);
    }
//    public function getBorang(){
//        return $this->hasMany(RefBorang::className(), ['id' => 'idBorang']);
//    }
 public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => $this->kakitangan->gredJawatan]);
    }
    
    public function getStudy() {
        return $this->hasOne(TblPengajian::className(), ['idPermohonan' => 'id']);
    }
    
   public function getStudy2() {
       
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno']);
       
   }
   public function getSponsor() {
       
        return $this->hasOne(TblBiasiswa::className(), ['icno' => 'icno']);
       
   }
//
//  public function getSabatikal() {
//       
//       return TblPengajian::find()->where(['idPermohonan'=>$this->id])->one();
//       
//   }
     public function getDisplaystudy() {
        return $this->hasOne(Edulevel::className(), ['HighestEduLevelCd' => 'HighestEduLevelCd']);
    }
    public function getBiasiswa() {
        return $this->hasOne(TblBiasiswa::className(), ['idPermohonan' => 'id']);
    }
//
//  public function getDokumen() {
//        return $this->hasOne(TblBiasiswa::className(), ['idPermohonan' => 'id']);
//    }


    public function getDisplayjenis()
    {
        return $this->hasOne(KategoriMesyuarat::className(), ['id' => 'kategori_id']);
    }

    public function getBiodataStaff(){
        return $this->hasOne(Tblprcobiodata::className(), ['icno' => 'icno']);
    }

    public function getTarikhmohon() {
        return $this->getTarikh($this->tarikh_m);
    }
  public function getTarikhmula() {
        return  $this->getTarikh($this->tarikh_mula);

    }
     public function getTarikhtamat() {
        return  $this->getTarikh($this->tarikh_tamat);

    }
    public function getTarikhkj() {
        return $this->getTarikh($this->app_date);
    }

    
    public function getTarikhBSM() {
        return $this->getTarikh($this->ver_date);
    }

    
//     public static function totalPending($icno, $category) {
//
//        $total = 0;
////        if($category !=0){
////        $model = TblPermohonan::find()->where(['ver_by' => $icno, 'status_proses' => 'Selesai Permohonan'])->all();
////        if ($model) {
////            $total = count($model);
////        }
////        }
////        else{
//            $total = count($model = TblPermohonan::find()->where(['ver_by' => $icno, 'status_proses' => 'Selesai Permohonan'])->all());
////        }
//        
//        if ($total > 0) {
//                return '&nbsp;<span class="badge bg-red">'.$total.'</span>';
//            }
//        else {
//                return '';
//        }
//    }

       public static function totalPending($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
     $model = TblPermohonan::find()->where([ 'status_bsm' => 'Menunggu Kelulusan' ])->all();
// }
        if ($model) {
            $total = count($model);
        }
        
         else{
            $total = count($model = TblPermohonan::find()->where(['app_by' => $icno, 'status' => 'DALAM TINDAKAN KETUA JABATAN'])->all());
        }
        if ($total > 0) {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        else {
                return '';
        }
    }
    public static function totalPendingTask($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
            $total = count($model = TblPermohonan::find()->where(['app_by' => $icno, 'status' => 
            'DALAM TINDAKAN KETUA JABATAN','status_proses'=>"Selesai Permohonan"])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
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
        if($icno == "870818495847")
        {
            $total = count($model = TblPermohonan::find()->where(['ver_by'=>$icno,'status_bsm' => 'Tunggu Kelulusan BSM', 'status_jfpiu'=>"Diperakukan"])->all());
        
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
        }
    }

   
    public function getLetter(){
         return $this->hasOne(Tblprcobiodata::className(), ['icno' => 'icno']);
    }
    

    public function getGelaran() {
        return $this->hasOne(Gelaran::className(), ['TitleCd' => 'TitleCd']);
    }

     public function getMesyuarat() {
         return $this->hasOne(TblUrusMesyuarat::className(), ['id'=>'iklan_id']);
    }
     public function beforeSave($insert)
    {
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke', 'tarikh_mesyuarat'])->orderBy(['kali_ke'=>SORT_DESC])->limit(1)->one();
        
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        $this->kali_ke = $tmp['kali_ke'];
        $this->tarikh_mesyuarat = date('d M Y', strtotime ($tmp['tarikh_mesyuarat']));
        
        return true;
    }
    
     public static function totalBerjaya() {


        $count = self::find()->where([ 'status' == "LULUS"])->count();

        return (int) $count;
    }
    
    public function getConfirmation() {
        $bio = Tblrscoconfirmstatus::find()->where(['ICNO' => $this->icno])->max('ConfirmStatusStDt');     
        return $this->hasOne(Tblrscoconfirmstatus::className(), ['ICNO' => 'icno'])->orderBy(['ConfirmStatusStDt'=>SORT_DESC]);
    }

  
//   public function getPendidikanTertinggi() {
//        return $this->hasOne(PendidikanTertinggi::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
//    }
//
//    public function getTahapPendidikan() {
//        
//        return $this->pendidikanTertinggi->HighestEduLevel;
//    }
     public function getPendidikan() {
        return $this->hasOne(TblPengajian::className(), ['ICNO' => 'icno']);
    }
// public function perMonth($year,$mth) {
//        
//        return Borang::find()->where(['YEAR(created_dt)' => $year])->andWhere(['MONTH(created_dt)' => $mth]);
//    }
     public function perMonth($year,$mth) {
        return TblPermohonan::find()->where(['YEAR(tarikh_m)' => $year, 'status_proses'=>"Selesai Permohonan"])->andWhere(['MONTH(tarikh_m)' => $mth])->count();
    }
    public function perMonthp($year,$mth) {
        return TblPengajian::find()->where(['YEAR(tarikh_mula)' => $year, 'status'=>"1",'userID'=>1])->andWhere(['MONTH(tarikh_mula)' => $mth])->count();
    }
     public function getTotal($year,$mth) {
        
        return TblPermohonan::find()->where(['YEAR(tarikh_m)' => $year])->andWhere(['MONTH(tarikh_m)' => $mth])->andWhere(['status_proses'=>"Selesai Permohonan"])->sum('jumlah');
    }
    
     public function getTotalYear($year) {
        
        return TblPermohonan::find()->where(['YEAR(tarikh_m)' => $year])->andWhere(['status_proses'=>"Selesai Permohonan"])->sum('jumlah');
    }
    public function getTotalCount($year,$mth) {
        
        return TblPermohonan::find()->where(['YEAR(tarikh_m)' => $year])->andWhere(['status_proses'=>"Selesai Permohonan"])->count();
    }
    public function getTotalCountp($year,$mth) {
        
        return TblPengajian::find()->where(['YEAR(tarikh_mula)' => $year])->andWhere(['status'=>"1",'userID'=>1])->count();
    }

     public function getPenajaan() {
        return $this->hasOne(RefPenajaan::className(), ['penajaanCd'=>'penajaanCd']);
    }
    public function getMajor() {
        return $this->hasOne(MajorMinor::className(), ['MajorMinorCd'=>'MajorCd']);
    }
    
    public function getNamamajor() {
        if($this->major){
            return $this->major->MajorMinor;
        }
        
         return "Tidak Berkaitan";
    }
 public function getTempohpengajian(){
       
        $date1 = TblPengajian::find()->where(['ICNO' => $this->icno, 'idPermohonan'=>$this->id])->min('tarikh_mula');
        $date2 = TblPengajian::find()->where(['ICNO' => $this->icno, 'idPermohonan'=>$this->id])->min('tarikh_tamat');

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $months = 0;

        while (strtotime('+1 MONTH', $ts1) < $ts2) {
            $months++;
            $ts1 = strtotime('+1 MONTH', $ts1);
        }

        return $months. ' Bulan '. ($ts2 - $ts1) / (60*60*24). ' Hari'; // 120 month, 26 days
    } 
    
//    public function getTempoh() {
//
//
//        $date1 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->tarikh_mula))));
//        $date2 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->tarikh_tamat))));
//        $diff = \date_diff($date1, $date2);
//        return $diff->format("%a") + 1;
//    }
    public function getTempoh(){
        $model = \app\models\hronline\Tblrscoapmtstatus::find()->where(['ICNO' => $this->icno])->min('ApmtStatusStDt');
        $date1= date_create($model);
        $date2= $this->job_category == 2? date_create($this->kakitangan->endDateLantik):date_create($this->endDateLantik);
        $tempoh = date_diff($date1, $date2)->format('%y Tahun %m Bulan');
        //$tempoh = round($tempo/365, 1);
        return $tempoh;
    }
}
