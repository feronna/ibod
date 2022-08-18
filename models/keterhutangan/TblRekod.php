<?php

namespace app\models\keterhutangan;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use Yii;

/**
 * This is the model class for table "keterhutangan.tbl_rekod".
 *
 * @property int $id
 * @property string $icno
 * @property string $reason
 */
class TblRekod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.hutang_tbl_rekod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 12],
            [['reason'], 'string', 'max' => 50],
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
            'reason' => 'Reason',
        ];
    }
    
       public function getKakitangan(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
     public function getBiodata(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
      public function getTarikhs($bulan){
        
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
      public function getTarikhNoti() {
        return  $this->getTarikhs($this->tarikh_noti);
    }
    
      
}
