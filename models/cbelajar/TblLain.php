<?php

namespace app\models\cbelajar;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\MajorMinor; 

/**
 * This is the model class for table "cbelajar.tbl_lain".
 *
 * @property int $id
 * @property string $icno
 * @property int $iklan_id
 * @property int $jenis_user_id
 * @property string $ver_by
 * @property string $ver_date
 * @property string $tarikh_mohon
 * @property string $renewMod
 * @property int $modeID
 * @property string $renewTarikhm
 * @property string $renewTarikht
 * @property string $catatan
 * @property string $status_bsm
 * @property string $status_borang
 */
class TblLain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
       public $file,$file2;
    public static function tableName()
    {
        return 'hrd.cb_tbl_lain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iklan_id', 'jenis_user_id', 'modeID','idBorang'], 'integer'],
            [['renewMod','dokumen_sokongan','dokumen', 'file', 'file2', 'renewTempat'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['ver_date', 'tarikh_mohon', 'renewTarikhm', 'renewTarikht', 'dt_stangguh', 'dt_ntangguh','app_date'], 'safe'],
            [['catatan'], 'string'],
            [['MajorCd','order'], 'string', 'max' => 11],
            [['icno', 'ver_by','app_by'], 'string', 'max' => 12],
            [['renewMod', 'renewTempat','MajorMinor','ulasan_jfpiu', 'result'], 'string', 'max' => 255],
            [['status_bsm', 'status_jfpiu','status_borang'], 'string', 'max' => 30],
            [['file', 'file2'], 'file','extensions'=>'pdf'], 
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
            'ver_by' => 'Ver By',
            'ver_date' => 'Ver Date',
            'tarikh_mohon' => 'Tarikh Mohon',
            'renewMod' => 'Renew Mod',
            'modeID' => 'Mode ID',
            'dokumen_sokongan' => 'Dokumen Sokongan',
            'dokumen' =>'Dokumen 1',
            'renewTarikhm' => 'Renew Tarikhm',
            'renewTarikht' => 'Renew Tarikht',
            'catatan' => 'Catatan',
            'status_bsm' => 'Status Bsm',
            'status_borang' => 'Status Borang',
            'MajorCd' => 'Major',
            'MajorMinor' =>'majorminor',
            'dt_stangguh' => 'MULA TANGGUH',
            'dt_ntangguh' => 'TAMAT TANGGUH',
            'result' => 'KEPUTUSAN',
        ];
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getTarikhmohon() {
        return $this->getTarikh($this->tarikh_mohon);
    }
     public function getMesyuarat() {
         return $this->hasOne(TblUrusMesyuarat::className(), ['id'=>'iklan_id']);
    }
     public function getStatusmesyuarat() {
        if ($this->status_mesyuarat == 'Diluluskan') {
            return '<span class="label label-success">DILULUSKAN</span>';
        }
        if ($this->status_mesyuarat == 'Bersyarat') {
            return '<span class="label label-info">BERSYARAT</span>';
        }
       
         if ($this->status_mesyuarat === NULL) {
            return '-';
        }
    }
     public function getMaklumat() {
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno']);
    }
//    public function getPengajian() {
//       
//        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno', 'idStudy'=>'HighestEduLevelCd', 'status'=>1]);
//       
//   }
     public function getBorang() {
        return $this->hasOne(RefBorang::className(), ['id'=>'idBorang']);
    }
     public function getMajor() {
        return $this->hasOne(MajorMinor::className(), ['MajorMinorCd'=>'MajorCd']);
    }
     public function getMode() {
        return $this->hasOne(Modpengajian::className(), ['id'=>'modeID']);
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
        if ($this->status_bsm == 'Tidak Diluluskan') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
         if ($this->status_bsm === NULL) {
            return '-';
        }
    }
    
//     public function getStatusjfpiu() {
//        if ($this->status_jfpiu == 'Tunggu Perakuan') {
//            return '<span class="label label-warning">Menunggu</span>';
//        }
//        if ($this->status_jfpiu == 'Diperakukan') {
//            return '<span class="label label-success">Diperakukan</span>';
//        }
//        if ($this->status_jfpiu == 'Tidak Diperakukan') {
//            return '<span class="label label-danger">Ditolak</span>';
//        }
//    }
 public function getStudy() {
       
       return TblPengajian::find()->where(['icno'=>$this->icno,'status'=>1])->one();
       
   }
    public function getTajaan() {
       
       return TblBiasiswa::find()->where(['icno'=>$this->icno,'status'=>1])->one();
       
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
     public function checkUpload($id){
        $model = TblLain::findOne(['icno' => Yii::$app->user->getId(),'icno' => $id]); 
        
        return $model;
    } 
   public function getDokumen(){
        return $this->hasOne(TblSurat::className(), ['icno' => 'id']);
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
    public function getStatusjfpiu() {
        if ($this->status_jfpiu == 'Tunggu Perakuan') {
            return '<span class="label label-warning">MENUNGGU PERAKUAN</span>';
        }
        if ($this->status_jfpiu == 'Diperakukan') {
            return '<span class="label label-success">DIPERAKUKAN</span>';
        }
        if ($this->status_jfpiu == 'Tidak Diperakukan') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }
//      public function getR() {
//        return $this->hasOne(TblLain::className(), ['icno'=>'icno', 'EduCd'=> 'eduCd'])->where(['idBorang'=>23]);
//    }
    public function getTempohpengajian(){
        //$model = TblPengajian::find()->where(['ICNO' => $this->icno])->min('tarikh_mula');   
        // $model1 = TblPengajian::find()->where(['ICNO' => $this->icno])->min('tarikh_tamat');
        // $date1=date_create($model);
        // $date2=date_create($model1);
        // $tempohpengajian = date_diff($date1, $date2)->format('%y Tahun %m Bulan %d Hari');
        // //$tempohlantikantetap = round($tempo/365, 1);
        // return $tempohpengajian;

        // $date1 = TblPengajian::find()->where(['ICNO' => $this->icno])->min('tarikh_mula');
        // $date2 = TblPengajian::find()->where(['ICNO' => $this->icno])->min('tarikh_tamat');

        // $ts1 = strtotime($date1);
        // $ts2 = strtotime($date2);

        // $year1 = date('Y', $ts1);
        // $year2 = date('Y', $ts2);

        // $month1 = date('m', $ts1);
        // $month2 = date('m', $ts2);

        // $tempohpengajian = (($year2 - $year1) * 12) + ($month2 - $month1);
        // return $tempohpengajian .' '. 'Bulan';

        $date1 = TblLain::find()->where(['ICNO' => $this->icno,'HighestEduLevelCd' => $this->eduCd])->max('renewTarikhm');
        $date2 = TblLain::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd' => $this->eduCd])->max('renewTarikht');

//        $ts1 = strtotime($date1);
//        $ts2 = strtotime($date2);
//
//        $months = 0;
//
//        while (strtotime('+1 MONTH', $ts1) < $ts2) {
//            $months++;
//            $ts1 = strtotime('+1 MONTH', $ts1);
//        }
//
//        return $months. ' BULAN '. ($ts2 - $ts1) / (60*60*24) + 1 . ' BULAN'; // 120 month, 26 days
        
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
//        return $diff = (($year2 - $year1) * 12) + ($month2 - $month1). ' BULAN';
        $ts1 =strtotime($date1); 
$ts2 = strtotime($date2); 
$year1 = date('Y', $ts1); 
$year2 = date('Y', $ts2); 
$month1 = date('m', $ts1); $month2 = date('m', $ts2); 
$days = date('d', $ts1);
$days2 = date('d', $ts2);
return $diff = round((($year2 - $year1) * 12) + ($month2 - $month1) / ($days2-($days+1))). ' BULAN' ;
    } 
    public function getTempohlanjutan(){
     
 
        $date1 = TblLain::find()->where(['ICNO' => $this->icno,'eduCd' => $this->eduCd,'idBorang'=>31])->min('renewTarikhm');
        $date2 = TblLain::find()->where(['ICNO' => $this->icno, 'eduCd' => $this->eduCd,'idBorang'=>31])->min('renewTarikht');


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
    public function getTempohlanjutant(){
     
 
        $date1 = TblLain::find()->where(['ICNO' => $this->icno,'eduCd' => $this->eduCd,'idBorang'=>23])->min('renewTarikhm');
        $date2 = TblLain::find()->where(['ICNO' => $this->icno, 'eduCd' => $this->eduCd,'idBorang'=>23])->min('renewTarikht');


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
       public function getTarikhm() {
        return  $this->getTarikh($this->renewTarikhm);

    }
    
       public function getTarikht() {
        return  $this->getTarikh($this->renewTarikht);

    }
        public function getDtstangguh() {
        return  $this->getTarikh($this->dt_stangguh);

    }
        public function getDtntangguh() {
        return  $this->getTarikh($this->dt_ntangguh);

    }
       public function getTempohtangguh(){
     
 
        $date1 = TblLain::find()->where(['ICNO' => $this->icno,'eduCd' => $this->eduCd])->min('dt_stangguh');
        $date2 = TblLain::find()->where(['ICNO' => $this->icno, 'eduCd' => $this->eduCd])->min('dt_ntangguh');

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
    public function getT() {
        return $this->hasOne(TblLain::className(), ['icno'=>'icno', 'EduCd'=> 'EduCd'])->where(['idBorang'=>22]);
    }
     public function getTempohtajaan(){
     
 
        $date1 = TblLain::find()->where(['ICNO' => $this->icno,'eduCd' => $this->eduCd,'idBorang'=>99])->min('renewTarikhm');
        $date2 = TblLain::find()->where(['ICNO' => $this->icno, 'eduCd' => $this->eduCd,'idBorang'=>99])->min('renewTarikht');

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
    public function getTempohtajaan2(){
     
 
        $date1 = TblLain::find()->where(['ICNO' => $this->icno,'eduCd' => $this->eduCd,'idBorang'=>99,'order'=>2])->min('renewTarikhm');
        $date2 = TblLain::find()->where(['ICNO' => $this->icno, 'eduCd' => $this->eduCd,'idBorang'=>99,'order'=>2])->min('renewTarikht');

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
    
}
