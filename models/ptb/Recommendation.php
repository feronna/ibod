<?php
namespace app\models\ptb;

use yii\db\ActiveRecord;
use Yii;

class  Recommendation extends ActiveRecord
{
   
    public static function tableName(){
        return 'hrm.ptb_tbl_recommendations';
    }

    public function getApplication(){
        return $this->hasOne(Application::className(), ['id' => 'application_id']);
    }
    
     public function getUrusMesyuarat(){
        return $this->hasOne(TblUrusMesyuarat::className(), ['id' => 'application_id']);
    }
    public function getStaff(){
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
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
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y H:i:s A");
    }
    public function getUpdates() {
        return  $this->getTarikh($this->update);
    }
     public function getCreated() {
        return  $this->getTarikh($this->created_at);
    }
      public function getPensetuju(){
        return $this->hasOne(Recommendation::className(), ['application_id' => 'id'])->where(['type' => 1]);
           
    }
    
     public function getPeraku(){
             return $this->hasOne(Recommendation::className(), ['application_id' => 'id'])->where(['type' => 2]);
    }
    
       public function getStatusIndividu(){
             return $this->hasOne(Application::className(), ['id' => 'application_id'])->where(['status' => [1,2]]);
    }
      public static function totalPendingPp() {
        $icno = Yii::$app->user->getId();
        $total = 0;
        $model = Recommendation::find()->where(['icno' => $icno,'agree' => null, 'type' => 1])->all();
        
        if ($model) {
            $total = count($model);
        }
        if ($total > 0) {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        else {
                return '';
        }
    }
    
      public static function totalPendingKj() {
        $icno = Yii::$app->user->getId();
        $total = 0;
        $model = Recommendation::find()->where(['icno' => $icno,'agree' => null, 'type' => 2])->all();
        
        if ($model) {
            $total = count($model);
        }
        if ($total > 0) {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        else {
                return '';
        }
    }
    
     public static function totalPendingPelulus() {
        $icno = Yii::$app->user->getId();
        $total = 0;
        $model = Recommendation::find()->where(['icno' => $icno,'agree' => null, 'type' => 3])->all();
        
        if ($model) {
            $total = count($model);
        }
        if ($total > 0) {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        else {
                return '';
        }
    }
     public function getppp(){
        return $this->hasOne(Application::className(), ['id' => 'application_id']);
    }
}