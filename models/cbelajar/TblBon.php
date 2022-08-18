<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_bon".
 *
 * @property int $id
 * @property string $icno
 * @property string $dt_mkhidmat
 * @property string $dt_tkhidmat
 * @property string $j_bon
 * @property string $catatan
 */
class TblBon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_bon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catatan', 'c_bon'], 'string'],
            [['HighestEduLevelCd'], 'integer'],

            [['icno'], 'string', 'max' => 12],
            [['tempoh'], 'string', 'max' => 20],
            [['dt_mkhidmat', 'dt_tkhidmat', 'j_bon', 't_phd', 't_sabatikal', 'j_bon1', 'baki_bon', 'j_lapor'], 'string', 'max' => 255],
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
            'dt_mkhidmat' => 'Dt Mkhidmat',
            'dt_tkhidmat' => 'Dt Tkhidmat',
            'j_bon' => 'J Bon',
            'catatan' => 'Catatan',
            't_phd' => 'T Phd',
            't_sabatikal' => 'T Sabatikal',
            'j_bon1' => 'J Bon1',
            'baki_bon' => 'Baki Bon',
            'j_lapor' => 'J Lapor',
            'c_bon' => 'C Bon',
        ];
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
     public function getDtM() {
        return  $this->getTarikh($this->dt_mkhidmat);

    }
    
     public function getDtT() {
        return  $this->getTarikh($this->dt_tkhidmat);

    }
     public function getPendidikanTertinggi() {
        return $this->hasOne(Edulevel::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
   }

   public function getTahapPendidikan() {
      
       return $this->pendidikanTertinggi->HighestEduLevel;
   }
     public function getLapor() {
       
        return $this->hasMany(TblLapordiri::className(), ['laporID' => 'icno', 'HighestEduLevelCd'=>'HighestEduLevelCd']);
       
   }
   public function getLd() {
       
        return $this->hasOne(TblLapordiri::className(), ['laporID' => 'laporID']);
       
   }
   public function getTempohbon() {
//        $model = $tlBon::className(), ['icno' => 'icno','HighestEduLevelCd'=>'HighestEduLevelCd'])->orderBy(['dt_mkhidmat' => SORT_ASC])->one();
   
            $date1 = date_create($this->dt_mkhidmat);
            $date2 = date_create(date('Y-m-d'));
            $tempoh = date_diff($date1, $date2)->format('%y Tahun, %m Bulan, %d Hari');
       
        return $tempoh;
    }
      public function getTarikhmula() {
        return  $this->getTarikh($this->dt_mkhidmat);

    }
    
//    public function getTempoh(){
//     
// 
//        $model = $this->hasOne(TblLapordiri::className(), ['icno' => 'icno'])->orderBy(['dt_lapordiri' => SORT_ASC])->one();
//        $date2 = TblElaunLulus::find()->where(['ICNO' => $this->icno, 'HighestEduLevelCd' => $this->HighestEduLevelCd])->max('dt_ntajaan');
//
////        $ts1 =strtotime($date1); 
////$ts2 = strtotime($date2); 
////$year1 = date('Y', $ts1); 
////$year2 = date('Y', $ts2); 
////$month1 = date('m', $ts1); $month2 = date('m', $ts2); 
//////$days = date('d', $ts1);
//////$days2 = date('d', $ts2);
////return $diff = round((($year2 - $year1) * 12) + ($month2 - $month1)). ' BULAN' ;
//             $ts1 = strtotime($date1);
//        $ts2 = strtotime($date2);
//
//        $months = 0;
//
//        while (strtotime('+1 MONTH', $ts1) < $ts2) {
//            $months++;
//            $ts1 = strtotime('+1 MONTH', $ts1);
//        }
//        if((($ts2 - $ts1) / (60*60*24)+1) >= 31){
//            $months++;
//            $day = (($ts2 - $ts1) / (60*60*24)+1) - 31;
//            if($day != 0){
//               $disday = $day . ' Hari'; 
//            }else{
//                $disday = ''; 
//            }
//        }else{
//            $disday = (($ts2 - $ts1) / (60*60*24)+1) . ' Hari';
//        }
//
//        return $months. ' Bulan '. $disday; // 120 month, 26 days
//        
//        
//    } 
}
