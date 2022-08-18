<?php

namespace app\models\cbelajar;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "cbelajar.tbl_lanjutan".
 *
 * @property int $id
 * @property string $icno
 * @property int $iklan_id
 * @property int $jenis_user_id
 * @property string $tarikh_mohon
 * @property string $app_by
 * @property string $app_date
 * @property string $ver_by
 * @property string $ver_date
 * @property string $status_jfpiu
 * @property string $status_bsm
 * @property string $alamat
 * @property string $tempoh_masa
 * @property string $fulldt
 * @property string $lanjutansdt
 * @property string $lanjutanedt
 * @property string $justifikasi
 * @property string $dokumen_sokongan
 * @property string $tarikh_lulus
 * @property string $status_borang Disimpan, Selesai Permohonan
 */
class TblLanjutan extends \yii\db\ActiveRecord
{
    public $file, $file2, $file3, $file4, $file5;
    public static function tableName()
    {
        return 'hrd.cb_tbl_lanjutan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iklan_id', 'jenis_user_id','idLanjutan'], 'integer'],
            [['tarikh_mohon', 'app_date', 'ver_date', 'lanjutansdt', 'lanjutanedt', 'tarikh_lulus','c_date'], 'safe'],
            [['file','file2','file3','file4','alamat', 'tempoh_masa', 'fulldt', 'lanjutansdt','status_jfpiu', 'lanjutanedt','dt_slanjutb','dt_nlanjutb', 'justifikasi', 'dokumen_sokongan','dokumen','dokumen2', 'ulasan_jfpiu'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['alamat', 'justifikasi','dokumen_sokongan', 'dokumen_sokongan2', 'dokumen','dokumen2','dokumen3', 'ulasan_jfpiu', 'tarikh_mesyuarat'], 'string'],
            [['icno', 'app_by', 'ver_by'], 'string', 'max' => 12],
            [['status_jfpiu', 'status_bsm','agree'], 'string', 'max' => 30],
            [['tempoh_masa', 'fulldt', 'status_borang', 'status', 'tempoh'], 'string', 'max' => 50],
            [['file', 'file2', 'file3','file4','file5'], 'file','extensions'=>'pdf','maxSize' => 5000000], 
            [['c_lanjut','c1','c2','c3','c4','c5'], 'string', 'max' => 255],
            [['status_semakan','ulasan_bsm'], 'string', 'max' => 100],



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
            'iklan_id' => 'Iklan ID',
            'jenis_user_id' => 'Jenis User ID',
            'tarikh_mohon' => 'Tarikh Mohon',
            'app_by' => 'App By',
            'app_date' => 'App Date',
            'ver_by' => 'Ver By',
            'ver_date' => 'Ver Date',
            'status_jfpiu' => 'Status Jfpiu',
            'status_bsm' => 'Status Bsm',
             'status' => 'Status Bsm',
            'alamat' => 'Alamat',
            'tempoh_masa' => 'Tempoh Masa',
            'fulldt' => 'Fulldt',
            'lanjutansdt' => 'Lanjutansdt',
            'lanjutanedt' => 'Lanjutanedt',
            'justifikasi' => 'Justifikasi',
            'dokumen_sokongan' => 'Dokumen Sokongan',
            'dokumen_sokongan2' => 'Dokume Sokongan',
            'tarikh_lulus' => 'Tarikh Lulus',
            'status_borang' => 'Status Borang',
            'tarikh_mesyuarat' => 'Status Borang',
            'idLanjutan' => 'id lanjutan',
            'tempoh'=>'tempoh',
            'status_semakan'=>'Status Semakan',
                        'agree' => 'Agree',
                        'c1'=> 'D1',
                        

        ];
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
     public function getMaklumat() {
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno', 'HighestEduLevelCd' => 'HighestEduLevelCd']);
    }
    
     public function getLkk() {
        return $this->hasOne(TblLkk::className(), ['icno' => 'icno']);
    }
     public function getPrestasi() {
        return $this->hasOne(TblPrestasi::className(), ['icno' => 'icno']);
    }
    public function getTajaan() {
        return $this->hasOne(TblBiasiswa::className(), ['icno'=>'icno', 'HighestEduLevelCd'=> 'HighestEduLevelCd']);
    }
//     public function getPendidikanTertinggi() {
//        return $this->hasOne(Edulevel::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
//   }

//   public function getTahapPendidikan() {
//      
//       return $this->pendidikanTertinggi->HighestEduLevel;
//   }
     public function getUpload(){
        return $this->hasOne(TblLanjutan::className(), ['id' => 'id']);
    }
       public function getMesyuarat() {
         return $this->hasOne(TblUrusMesyuarat::className(), ['id'=>'iklan_id']);
    }
      public function checkUpload($id){
        $model = TblSurat::findOne(['icno' => Yii::$app->user->getId(),'icno' => $id]); 
        
        return $model;
    } 
    
//    public function getTempohlanjutan(){
//       
//        $date1 = TblLanjutan::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd, 'idLanjutan'=>$this->idLanjutan])->min('lanjutansdt');
//        $date2 = TblLanjutan::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd, 'idLanjutan' =>$this->idLanjutan])->min('lanjutanedt');
//
//      
//        $ts1 = strtotime($date1);
//        $ts2 = strtotime($date2);
//
//        $year1 = date('Y', $ts1);
//        $year2 = date('Y', $ts2);
//
//        $month1 = date('m', $ts1);
//        $month2 = date('m', $ts2);
//
//        return $diff = (($year2 - $year1) * 12) + ($month2 - $month1) + 1 . ' BULAN';
//    } 
     public function getTempohlanjutan(){
     
 
             $date1 = TblLanjutan::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd, 'idLanjutan'=>$this->idLanjutan])->min('lanjutansdt');
        $date2 = TblLanjutan::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd, 'idLanjutan' =>$this->idLanjutan])->min('lanjutanedt');

//        $ts1 =strtotime($date1); 
//$ts2 = strtotime($date2); 
//$year1 = date('Y', $ts1); 
//$year2 = date('Y', $ts2); 
//$month1 = date('m', $ts1); $month2 = date('m', $ts2); 
////$days = date('d', $ts1);
////$days2 = date('d', $ts2);
//return $diff = round((($year2 - $year1) * 12) + ($month2 - $month1)). ' BULAN' ;
             $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $months = 0;

        while (strtotime('+1 MONTH', $ts1) < $ts2) {
            $months++;
            $ts1 = strtotime('+1 MONTH', $ts1);
        }
        if((($ts2 - $ts1) / (60*60*24)+1) >= 31){
            $months++;
            $day = (($ts2 - $ts1) / (60*60*24)+1) - 31;
            if($day != 0){
               $disday = $day . ' Hari'; 
            }else{
                $disday = ''; 
            }
        }else{
            $disday = (($ts2 - $ts1) / (60*60*24)+1) . ' Hari';
        }

        return $months. ' Bulan '. $disday; // 120 month, 26 days
        
        
    }
//     public function getTempohlanjutan(){
//       
//
//        $date1 = TblLanjutan::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd, 'idLanjutan'=>$this->idLanjutan])->max('lanjutansdt');
//        $date2 = TblLanjutan::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd, 'idLanjutan' =>$this->idLanjutan])->max('lanjutanedt');
//
////        $ts1 = strtotime($date1);
////        $ts2 = strtotime($date2);
////
////        $months = 0;
////
////        while (strtotime('+1 MONTH', $ts1) < $ts2) {
////            $months++;
////            $ts1 = strtotime('+1 MONTH', $ts1);
////        }
////
////        return $months. ' BULAN '. ($ts2 - $ts1) / (60*60*24) + 1 . ' BULAN'; // 120 month, 26 days
//        
////         
////        $ts1 = strtotime($date1);
////        $ts2 = strtotime($date2);
////
////        $year1 = date('Y', $ts1);
////        $year2 = date('Y', $ts2);
////
////        $month1 = date('m', $ts1);
////        $month2 = date('m', $ts2);
////
////        return $diff = (($year2 - $year1) * 12) + ($month2 - $month1). ' BULAN';
//        $ts1 =strtotime($date1); 
//$ts2 = strtotime($date2); 
//$year1 = date('Y', $ts1); 
//$year2 = date('Y', $ts2); 
//$month1 = date('m', $ts1); $month2 = date('m', $ts2); 
//$days = date('d', $ts1);
//$days2 = date('d', $ts2);
//return $diff = round((($year2 - $year1) * 12) + ($month2 - $month1) / ($days2-($days+1))). ' BULAN' ;
//    }
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
            return '<span class="label label-info">TIDAK LAYAK DIPERTIMBANGKAN</span>';
        }
    }
     public function getTempohtajaan(){
     
 
        $date1 = TblLanjutan::find()->where(['ICNO' => $this->icno,'HighestEduLevelCd' => $this->HighestEduLevelCd,  'idLanjutan'=>$this->idLanjutan])->max('dt_slanjutb');
        $date2 = TblLanjutan::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd' => $this->HighestEduLevelCd,  'idLanjutan'=>$this->idLanjutan])->max('dt_nlanjutb');

//        $ts1 =strtotime($date1); 
//$ts2 = strtotime($date2); 
//$year1 = date('Y', $ts1); 
//$year2 = date('Y', $ts2); 
//$month1 = date('m', $ts1); $month2 = date('m', $ts2); 
////$days = date('d', $ts1);
////$days2 = date('d', $ts2);
//return $diff = round((($year2 - $year1) * 12) + ($month2 - $month1)). ' BULAN' ;
             $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $months = 0;

        while (strtotime('+1 MONTH', $ts1) < $ts2) {
            $months++;
            $ts1 = strtotime('+1 MONTH', $ts1);
        }
        if((($ts2 - $ts1) / (60*60*24)+1) >= 31){
            $months++;
            $day = (($ts2 - $ts1) / (60*60*24)+1) - 31;
            if($day != 0){
               $disday = $day . ' Hari'; 
            }else{
                $disday = ''; 
            }
        }else{
            $disday = (($ts2 - $ts1) / (60*60*24)+1) . ' Hari';
        }

        return $months. ' Bulan '. $disday; // 120 month, 26 days
        
        
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
        return $this->getTarikh($this->tarikh_mohon);
    }
    public function getBorang() {
        return $this->hasOne(RefBorang::className(), ['id'=>'idBorang']);
    }
    public function getStatuss() {
       
        if ($this->status == 'DALAM TINDAKAN KETUA JABATAN') {
            return '<span class="label label-info">DALAM TINDAKAN KJ</span>';
        }
        if ($this->status == 'DALAM TINDAKAN BSM') {
            return '<span class="label label-primary">Dalam Tindakan BSM</span>';
        }
        if ($this->status == 'LULUS') {
            return '<span class="label label-success">Berjaya</span>';
        }
         if ($this->status == 'KIV') {
            return '<span class="label label-warning">KIV</span>';
        }
        if ($this->status == 'TIDAK LULUS') {
            return '<span class="label label-danger"> Tidak Diluluskan</span>';
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
 public function getStudy() {
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno']);
    }
     public function getPendidikanTertinggi() {
        return $this->hasOne(Edulevel::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
   }

   public function getTahapPendidikan() {
      
       return $this->pendidikanTertinggi->HighestEduLevel;
   }
   public function getBiasiswa() {
        return $this->hasOne(TblBiasiswa::className(), ['icno' => 'icno']);
    }
   
     public function getStatusjfpiu() {
        if ($this->status_jfpiu == 'Tunggu Perakuan') {
            return '<span class="label label-warning">DALAM TINDAKAN KJ</span>';
        }
        if ($this->status_jfpiu == 'Diperakukan') {
            return '<span class="label label-success">DIPERAKUKAN</span>';
        }
        if ($this->status_jfpiu == 'Tidak Diperakukan') {
            return '<span class="label label-danger">TIDAK DIPERAKUKAN</span>';
        }
    }
    
      public function perMonth($year,$month) {
        return TblLanjutan::find()->where(['YEAR(tarikh_mohon)' => $year])->andWhere(['MONTH(tarikh_mohon)' => $month])->count();
    }
    
   
    
     public function getTotal($year,$mth) {
        
        return TblLanjutan::find()->where(['YEAR(tarikh_mohon)' => $year])->andWhere(['MONTH(tarikh_mohon)' => $mth])->sum('jumlah');
    }
     public function getTotalYear($year) {
        
        return TblLanjutan::find()->where(['YEAR(tarikh_mohon)' => $year])->sum('jumlah');
    }
    public function getTotalCount($year,$mth) {
        
        return TblLanjutan::find()->where(['YEAR(tarikh_mohon)' => $year])->count();
    }
//    public function getStatuskj() {
//        if ($this->status_kj == 'Tunggu Kelulusan') {
//            return '<span class="label label-warning">Menunggu</span>';
//        }
//        if ($this->status_kj == 'Menyokong') {
//            return '<span class="label label-success">Diperakukan</span>';
//        }
//        if ($this->status_kj == 'Tidak Menyokong') {
//            return '<span class="label label-danger">Ditolak</span>';
//        }
//    }
     public function getTarikhkj() {
        return $this->getTarikh($this->app_date);
    }
    
     public function checkUploadlanjut($id){
        $model = TblSurat::findOne(['icno' => Yii::$app->user->getId(),'icno' => $id]); 
        
        return $model;
    } 
     public function getDokumen(){
        return $this->hasMany(TblSurat::className(), ['icno' => 'id']);
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
    public function getStatusbsm() {
        if ($this->status_bsm == 'Tunggu Kelulusan') {
            return '<span class="label label-warning">DALAM TINDAKAN BSM</span>';
        }
         if ($this->status_bsm == 'Tunggu Kelulusan BSM') {
            return '<span class="label label-danger">DALAM TINDAKAN BSM</span>';
        }
        if ($this->status_bsm == 'Diluluskan') {
            return '<span class="label label-success">DILULUSKAN</span>';
        }
         if ($this->status_bsm == 'KIV') {
            return '<span class="label label-warning">KIV</span>';
        }
        
        if ($this->status_bsm == 'Tidak Diluluskan') {
            return '<span class="label label-danger">TIDAK DILULUSKAN</span>';
        }
         if ($this->status_bsm === NULL) {
            return '-';
        }
    }
    
    public function getIdlanjutan() {
        if ($this->idLanjutan == '1') {
            return '<span class="label label-primary">PERTAMA</span>';
        }
        if ($this->idLanjutan == '2') {
            return '<span class="label label-primary">KEDUA</span>';
        }
        if ($this->idLanjutan == '3') {
            return '<span class="label label-primary">KETIGA</span>';
        }
    }
     public function getStlanjutan() {
        return  $this->getTarikh($this->lanjutansdt);

    }
    public function getNdlanjutan() {
        return  $this->getTarikh($this->lanjutanedt);

    }
     public function getDtslanjut() {
        return  $this->getTarikh($this->dt_slanjutb);

    }
     public function getDtnlanjut() {
        return  $this->getTarikh($this->dt_nlanjutb);

    }
    public function getTempohl(){
 
        $days = TblLanjutan::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd])->max('tempoh');

//        $days = $mode;
        $days = $days % 365;

        $months = intval($days / 30); 
        $days = $days % 30;

        return " $months BULAN $days HARI";

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
            $total = count($model = TblLanjutan::find()->where(['app_by' => $icno, 'status' => 'DALAM TINDAKAN KETUA JABATAN'])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
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
            $total = count($model = TblLanjutan::find()->where(['status_jfpiu' => 'Diperakukan', 'status'=>"DALAM TINDAKAN BSM"])->all());
        
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
        }
    }
     public function getNamaapp() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'app_by']);
    }
    
}
