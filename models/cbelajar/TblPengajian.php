<?php

namespace app\models\cbelajar;

use Yii;
use app\models\hronline\Institut;
use app\models\cbelajar\PendidikanTertinggi;
use app\models\cbelajar\Modpengajian;
use app\models\hronline\Negara;
use app\models\hronline\MajorMinor;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\GredJawatan;
use app\models\smp_ppi\CutiPenyelidikan;
use app\models\hronline\Department;

class TblPengajian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    //   public static function getDb() {
    //     return Yii::$app->get('db'); //  database
    // }
    public static function tableName()
    {
        return 'hrd.cb_tbl_pengajian';
    }
    public $file1;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh_mula', 'tarikh_tamat', 'tarikh_mohon'], 'safe'],
            [['icno', 'negara', 'InstCd', 'CountryCd', 'InstNm', 'modeID', 'HighestEduLevelCd', 'MajorCd'], 'required', 'message'=>"Ruang ini adalah mandatori"],
            [['iklan_id','modeID', 'HighestEduLevelCd','laporID','tempoh'], 'integer'],
            [['icno'], 'string', 'max' => 12],
            [['negara','lokasi', 'modeStudy','nama_sjil','nama_badan','cat_latihan'],'string', 'max' => 100],
            [['emel_penyelia', 'full_dt', 'tarikh_mula', 'tarikh_tamat'], 'string', 'max' => 50],
            [['Country', 'CountryCd', 'InstCd', 'InstNm','NewInst', 'tajuk_tesis', 'MajorMinor', 'dokumen'], 'string', 'max' => 255],
            [['created_dt'], 'safe'],
            [['nama_penyelia','nama_kj','emel_kj','summary'], 'string'],
            [['MajorCd'], 'string', 'max' => 6],
            [['studentno'], 'string', 'max' => 30],
            [['terima','statusp'], 'string', 'max' => 20],
            [['HighestEduLevel', 'status','catatan','status_proses','research_id','nama_sijil','nama_badan'], 'string', 'max' => 255],
            [['file1'], 'file','extensions'=>'pdf'], 


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
            'negara' => 'Negara',
            'Country' => 'Country',
            'CountryCd' => 'Country Cd',
            'InstCd' => 'Inst Cd',
            'InstNm' => 'Inst Nm',
            'tarikh_mula' => 'Tarikh Mula',
            'tarikh_tamat' => 'Tarikh Tamat',
            'modeID' => 'Mode ID',
            'nama_penyelia' => 'Nama Penyelia',
            'emel_penyelia' => 'Emel Penyelia',
            'tarikh_mohon' => 'Tarikh Mohon',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
            'MajorCd' => 'Major Cd',
            'tajuk_tesis' => 'Tajuk Tesis',
            'MajorMinor' => 'Major Minor',
            'created_dt' => 'Created Dt',
            'iklan_id' => 'Iklan ID',
            'dokumen' => 'Dokumen',
            'status' => 'Status',
            'full_dt' => 'Full dt'
        ];
    }
       public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
     
    
     public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'icno']);
    }
    public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'DeptId']);
    }
     public function getAkses() {
        return $this->hasOne(\app\models\myidp\AdminJfpiu::className(), ['staffID' => 'tblprcobiodata.ICNO']);
    }

     
   public function getNegara() {
        return $this->hasOne(Negara::className(), ['CountryCd'=>'Country']);
    }    //  public function getStudylevel() {
    //     return $this->hasOne(PendidikanTertinggi::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
    // }

   public function getPendidikanTertinggi() {
        return $this->hasOne(Edulevel::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
   }
     public function getKategori(){
        return $this->hasOne(\app\models\cbelajar\KategoriMesyuarat::className(), ['id' => 'kategori_id']);  
    }
   public function getMesyuarat() {
         return $this->hasOne(TblUrusMesyuarat::className(), ['id'=>'iklan_id']);
    }
  public function getPenyelia()
    {
        return $this->hasOne(\app\models\system_core\ExternalUser::className(), ['username' => 'emel_penyelia']);
    }
   public function getTahapPendidikan() {
      
       return $this->pendidikanTertinggi->HighestEduLevel;
   }
   public function getBadanprof()
   {
       return $this->hasOne(\app\models\hronline\BadanProfesional::className(),['ProfBodyCd'=>'nama_badan']);
   }
   public function getBodyCert()
   {
       return $this->hasOne(\app\models\hronline\profesionalcert::className(),['ProfCertCd'=>'nama_sijil']);
   }
//     public function getNamaBadan() {
//      
//       return $this->badanprof->ProfBody;
//   }
   
// public function getStudy() {
//        return $this->hasOne(Edulevel::className(), ['HighestEduLevelCd' => 'HighestEduLevelCd']);
//    }
// 
    public function getInstitut() {
        return $this->hasOne(Institut::className(), ['InstCd'=>'InstCd']);
    }


    public function getMajor() {
        return $this->hasOne(MajorMinor::className(), ['MajorMinorCd'=>'MajorCd']);
    }
    
    public function getTajaan() {
        return $this->hasOne(TblBiasiswa::className(), ['icno'=>'icno', 'HighestEduLevelCd'=> 'HighestEduLevelCd']);
    }
    public function getTotalDaysInc()
    {


        $date1 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->tarikh_mula))));
        $date2 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->tarikh_tamat))));
        $diff = \date_diff($date1, $date2);
        // $the_first_day_of_week = date("N", $date1);


        $workingDays = $diff->format("%a") + 1;

        $arr = explode(" ", $this->full_dt);

        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));

        $startDate = strtotime($start_date);
        $endDate = strtotime($end_date);
        $holidays = \app\models\cuti\CutiUmum::find()->all(); #untuk convert pegi array

        // foreach ($holidays as $value) {
        //     $time_stamp = strtotime($value->tarikh_cuti);
        //     //If the holiday doesn't fall in weekend
        //     if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7)
        //         $workingDays--;
        // }
        // var_dump($workingDays);die;
        return $workingDays;
    }
     public function getTest() {
        return $this->hasOne(TblLain::className(), ['icno'=>'icno', 'idStudy'=> 'HighestEduLevelCd']);
    }
    
    public function getBiasiswa() {
        return $this->hasOne(TblTajaan::className(), ['jenisCd'=>'jenisCd']);
    }
     public function getLkk() {
        return $this->hasOne(TblLkk::className(), ['icno'=>'icno','status_form'=>'status']);
    }
     public function getLkp() {
        return $this->hasOne(TblLkk::className(), ['icno'=>'icno']);
    }
    public function getGot() {
        $ot = LkkDean::find()->where(['icno'=>'icno'
])->andWhere(['cb_tbl_dean.dokumen'=>["16","58"]])->one();
        return $ot;
//        return $this->hasOne(LkkDean::className(), ['icno'=>'icno','cb_lkk_dean.dokumen'=>[16,58]]);
    }
     public function getPengajiansemasa() {
       
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno'])->where(['cb_tbl_pengajian.status'=>1])->orderBy(['cb_tbl_pengajian.tarikh_mula'=>SORT_DESC]);
       
   }
     public function getPenajaan() {
        return $this->hasOne(RefPenajaan::className(), ['id'=>'jenisCd']);
    }
//     public function getServiceStatus() {
//        return $this->hasOne(ServiceStatus::className(), ['ServStatusCd' => 'Status']);
//    }
    public function get() {
       
        return $this->hasOne(TblBiasiswa::className(), ['icno' => 'icno', 'HighestEduLevelCd'=>'HighestEduLevelCd']);
       
   }
    public function getTempoh(){
       
        $date1 = TblPengajian::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd])->max('tarikh_mula');
        $date2 = TblPengajian::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd'=>$this->HighestEduLevelCd])->max('tarikh_tamat');

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $months = 0;

        while (strtotime('+1 MONTH', $ts1) < $ts2) {
            $months++;
            $ts1 = strtotime('+1 MONTH', $ts1);
        }

        return $months. ' Bulan '. ($ts2 - $ts1) / (60*60*24). ' Hari'; // 120 month, 26 days
    } 
    public function getTempohlanjutan(){
       
        $date1 = TblLanjutan::find()->where(['ICNO' => $this->idLanjutan, 'HighestEduLevelCd'=>$this->HighestEduLevelCd])->min('lanjutansdt');
        $date2 = TblLanjutan::find()->where(['ICNO' => $this->idLanjutan, 'HighestEduLevelCd'=>$this->HighestEduLevelCd])->min('lanjutanedt');

         
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return $diff = (($year2 - $year1) * 12) + ($month2 - $month1). ' BULAN';
        
    } 
      public function getLapor() {
        return $this->hasOne(TblLapordiri::className(), 
         ['icno'=>'icno', 'HighestEduLevelCd'=> 'HighestEduLevelCd'])->orderBy(['dt_lapordiri'=>SORT_DESC]);
    }
//     public function getLain() {
//       
//        return $this->hasOne(TblLain::className(), ['icno' => 'icno',]);
//       
//   }
     public function getLanjutan() {
        return $this->hasMany(TblLanjutan::className(), ['icno'=>'icno', 'HighestEduLevelCd'=> 'HighestEduLevelCd','status_b'=>'status'])
;    }
     public function getLa() {
        return $this->hasOne(TblLanjutan::className(), ['icno'=>'icno', 'HighestEduLevelCd'=> 'HighestEduLevelCd','status_b'=>'status'])->orderBy(['lanjutanedt'=>SORT_DESC]);
    }
     public function getLapordiri() {
        return $this->hasOne(TblLapordiri::className(), ['icno'=>'icno', 'HighestEduLevelCd'=> 'HighestEduLevelCd'])->orderBy(['tarikh_mohon'=>SORT_DESC]);
    }
//      public function getLanjutan1() {
//        return $this->hasMany(TblLanjutan::className(), ['icno'=>'icno', 'HighestEduLevelCd'=> 'HighestEduLevelCd']);
//    }
//     public function getServicestatus() {
//        return $this->hasOne(ServiceStatus::className(), ['ServStatusCd' => 'Status']);
//    }
    public function getNamamajor() {
        if($this->major){
            return $this->major->MajorMinor;
        }
        
         return "Tidak Berkaitan";
    }
    
//     public function getNamatajaan() {
//        if($this->biasiswa){
//            return $this->biasiswa->jenisTajaan;
//        }
//        
//         return "Tidak Berkaitan";
//    }
    

     public function getMod() {
        return $this->hasOne(Modpengajian::className(), ['modeID'=>'modeID']);
    }
      public function getJawatancb() {
        return $this->hasOne(GredJawatan::className(), ['gred' => 'gred']);
    }
    public function countBelumCapai() {

        $count = 0;
        
        $current_date = date('Y-m-d');
        $pd = TblLkk::find()->select('icno')->distinct('icno')->where(['agree'=>[2]])->asArray()->all();
        $icno_array = [];
        foreach($pd as $pd){
            
            array_push($icno_array,$pd['icno']);
        }
        $count = TblPengajian::find()
               ->joinWith('kakitangan')
               ->joinWith('lkp')
//               ->where(['=', 'tblprcobiodata.Status', '1'])
               ->andWhere(['cb_tbl_pengajian.status' => 1])
               ->andWhere(['cb_tbl_lkk.agree'=>2])
               ->andWhere(['cb_tbl_lkk.semester'=>1])
                ->andWhere(['cb_tbl_lkk.status_form'=>1])
               ->andWhere(['<=','tarikh_mula', date_format(date_create($current_date), 'Y-m-d')]) 
                                   ->orWhere(['>=','tarikh_mula', date_format(date_create($current_date), 'Y-m-d')]) 
               ->andWhere(['>=','cb_tbl_lkk.effectivedt', date_format(date_create($current_date), 'Y-m-d') ])
              ->groupBy('icno')
                ->count();
        
        return $count;
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

    public function getTarikhmula() {
        return  $this->getTarikh($this->tarikh_mula);

    }
    
   

    public function getTarikhtamat() {
        return  $this->getTarikh($this->tarikh_tamat);
    }

     public function getTarikhmohon() {
        if($this->tarikh_mohon!=''){
        return $this->getTarikh($this->tarikh_mohon);}
    }

//    public function checkPermohonan($id){
//        $model = TblPengajian::findOne(['id' => Yii::$app->user->getId(),'id' => $id]); 
//        
//        return $model;
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

        $date1 = TblPengajian::find()->where(['ICNO' => $this->icno,'HighestEduLevelCd' => $this->HighestEduLevelCd])->max('tarikh_mula');
        $date2 = TblPengajian::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd' => $this->HighestEduLevelCd])->max('tarikh_tamat');

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
    
    public function getTempohtajaan(){
     
 
        $date1 = TblPengajian::find()->where(['ICNO' => $this->icno,'HighestEduLevelCd' => $this->HighestEduLevelCd])->min('tarikh_mula');
        $date2 = TblPengajian::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd' => $this->HighestEduLevelCd])->min('tarikh_tamat');

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
    
    public function getTempohtajaann(){
     
        $date1 = TblPengajian::find()->where(['ICNO' => $this->icno,'HighestEduLevelCd' => $this->HighestEduLevelCd])->min('tarikh_mula');
        $date2 = TblPengajian::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd' => $this->HighestEduLevelCd])->min('tarikh_tamat');
        
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

        return (($months. ' Bulan '. $disday)/12 ). ' Tahun'; // 12
        
    }

//    public function getTempoh() {
//
//
//        $date1 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->tarikh_mula))));
//        $date2 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->tarikh_tamat))));
//        $diff = \date_diff($date1, $date2);
//        return $diff->format("%a") + 2;
//    }
    
    public function getLanjut() {
       
        return $this->hasMany(TblLanjutan::className(), 
       ['icno' => 'icno','HighestEduLevelCd'=>'HighestEduLevelCd'])->where(['cb_tbl_lanjutan.status_b'=>1]);
       
   }
   
   
   
    public function getLain() {
        return $this->hasMany(TblLain::className(), ['icno'=>'icno', 'EduCd'=> 'HighestEduLevelCd']);
    }
     public function getLains() {
        return $this->hasOne(TblLain::className(), ['icno'=>'icno', 'EduCd'=> 'HighestEduLevelCd']);
    }
    
    
     public function getL() {
        return $this->hasOne(TblLain::className(), ['icno'=>'icno', 'EduCd'=> 'HighestEduLevelCd'])->where(['idBorang'=>24]);;
    }
    public function getT() {
        return $this->hasOne(TblLain::className(), ['icno'=>'icno', 'EduCd'=> 'HighestEduLevelCd'])->where(['idBorang'=>22]);
    }
     public function getN() {
        return $this->hasOne(TblLain::className(), ['icno'=>'icno', 'EduCd'=> 'HighestEduLevelCd'])->where(['idBorang'=>99,'order'=>1]);
    }
     public function getO() {
        return $this->hasOne(TblLain::className(), ['icno'=>'icno', 'EduCd'=> 'HighestEduLevelCd'])->where(['idBorang'=>99,'order'=>2]);
    }
    public function getM() {
        return $this->hasOne(TblLain::className(), ['icno'=>'icno', 'EduCd'=> 'HighestEduLevelCd'])->where(['idBorang'=>23]);
    }
    public function getR() {
        return $this->hasOne(TblLain::className(), ['icno'=>'icno', 'EduCd'=> 'HighestEduLevelCd'])->where(['idBorang'=>31]);
    }
   
    public static function TotalbyEduLevel($id)
    {
        return count(TblPengajian::findAll(['status'=>$id,'HighestEduLevelCd'=>1]));
    }
    public static function TotalbySarjana($id)
    {
        return count(TblPengajian::findAll(['status'=>$id,'HighestEduLevelCd'=>20]));
    }
    
     public static function TotalbySarjanakepakaran($id)
    {
        return count(TblPengajian::findAll(['status'=>$id,'HighestEduLevelCd'=>202]));
    }
    public static function TotalbySarjanakepakaranfakulti($id)
    {
                 $userID = Yii::$app->user->getId();
                $test = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();

        return count(TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
                ->orWhere(['tblprcobiodata.DeptId' => $test->DeptId])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => $id])->
                  andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>202])->all());

    }
    public static function TotalbyPhdfakulti($id)
    {
                 $userID = Yii::$app->user->getId();
                $test = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();

        return count(TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
                ->orWhere(['tblprcobiodata.DeptId' => $test->DeptId])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1,2]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => $id])->
                  andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>1])->all());

    }
    public static function TotalbySarjanafakulti($id)
    {
                 $userID = Yii::$app->user->getId();
                $test = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();
        return count(TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
                ->orWhere(['tblprcobiodata.DeptId' => $test->DeptId])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1,2]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => $id])->
                  andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>20])->all());

    }
     public static function TotalbyPos($id)
    {
        return count(TblPengajian::findAll(['status'=>$id,'HighestEduLevelCd'=>200]));
    }
    public static function TotalbyPosfakulti($id)
    {
                 $userID = Yii::$app->user->getId();
                $test = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();

        return count(TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
                ->orWhere(['tblprcobiodata.DeptId' => $test->DeptId])
//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => $id])->
                  andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>200])->all());

    }
    public static function TotalbyDokfakulti($id)
    {
                 $userID = Yii::$app->user->getId();
      $test = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();
        return count(TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
                ->orWhere(['tblprcobiodata.DeptId' => $test->DeptId])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => $id])->
                  andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>201])->all());

    }
      public static function TotalStaffbyFakulti($id)
    {

           $model = Department::find()
                ->where(['id' => [5, 6, 7, 15, 104, 135, 136, 137, 138, 139, 140, 141, 142, 143, 188,209,210,193], 'isActive' => '1']);
          foreach($model as $m)
         {
        return count(TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['department.id'=>$m])
//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1]])
//                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['=','tblprcobiodata.Status','2'])
                ->andWhere(['cb_tbl_pengajian.status' => $id])->all());
          }
    }
     public static function TotalbySabatikal($id)
    {
        return count(TblPengajian::findAll(['status'=>$id,'HighestEduLevelCd'=>99]));
    }
    
     public static function TotalbySabatikalfakulti($id)
    {
                 $userID = Yii::$app->user->getId();

                return count(TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1,2]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => $id])->
                  andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>99])->all());

    }
    public static function TotalbyLatihanfakulti($id)
    {
                 $userID = Yii::$app->user->getId();

                return count(TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1,2]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => $id])->
                  andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>210])->all());

    }
    public static function TotalbyLatihan($id)
    {
        return count(TblPengajian::findAll(['status'=>$id,'HighestEduLevelCd'=>210]));
    }
    public static function TotalbyPosbasik($id)
    {
        return count(TblPengajian::findAll(['status'=>$id,'HighestEduLevelCd'=>201]));
    }
     public static function TotalbySarjanamuda($id)
    {
        return count(TblPengajian::findAll(['status'=>$id,'HighestEduLevelCd'=>8]));
    }
     public static function TotalbyDiploma($id)
    {
        return count(TblPengajian::findAll(['status'=>$id,'HighestEduLevelCd'=>11]));
    }

}