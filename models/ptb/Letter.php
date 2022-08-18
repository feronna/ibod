<?php
namespace app\models\ptb;

use yii\db\ActiveRecord;

class Letter extends ActiveRecord
{
    #Table name
    public static function tableName(){
        return 'hrm.ptb_tbl_letters';
    }
    
      public function getPelulus(){
        return $this->hasOne(Recommendation::className(), ['application_id' => 'id'])->where(['type' => 3]);
           
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
       public function getHari($hari){
        
        $D = date_format(date_create($hari), "D");
        if($D == 'Mon'){
            $D = "Isnin";}
        elseif ($D == 'Tue'){
          $D = "Selasa";}
        elseif ($D == 'Wed'){
          $D = "Rabu";}
        elseif ($D == 'Thu'){
          $D = "Khamis";}
        elseif ($D == 'Fri'){
          $D = "Jumaat";}   
          
        return  $D ;
    }
    public function getCreated() {
        return  $this->getTarikh($this->created_at);
    }
    public function getDateIssue() {
        return  $this->getTarikh($this->date_issue);
    }
      public function getHariIssue() {
        return  $this->getHari($this->date_issue);
    }
      public function getTarikhMesyuarat() {
        return  $this->getTarikh($this->tarikh_mesyuarat);
    }
    
     public function getTarikhMohon() {
        return  $this->getTarikh($this->tarikh_mohon);
    }

}