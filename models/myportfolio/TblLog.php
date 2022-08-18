<?php

namespace app\models\myportfolio;
use app\models\myportfolio\Tblportfolio;
use Yii;

/**
 * This is the model class for table "myportfolio.tbl_log".
 *
 * @property int $id
 * @property string $icno
 * @property string $portfolio_id
 * @property string $table_name
 * @property string $activity
 * @property string $update_icno
 * @property string $update_date
 * @property string $detail_activity
 */
class TblLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_tbl_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'portfolio_id', 'table_name', 'activity', 'update_icno', 'update_date', 'detail_activity'], 'string', 'max' => 50],
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
            'portfolio_id' => 'Portfolio ID',
            'table_name' => 'Table Name',
            'activity' => 'Activity',
            'update_icno' => 'Update Icno',
            'update_date' => 'Update Date',
            'detail_activity' => 'Detail Activity',
        ];
    }
    
     public function getApplicant(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
      public function getTujuan() {
        return $this->hasOne(Tblportfolio::className(), ['id' => 'portfolio_id']);
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
      public function getTarikhKemaskini() {
        return  $this->getTarikhs($this->update_date);
    }
      
}
