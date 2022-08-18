<?php

namespace app\models\ptb;

use Yii;

/**
 * This is the model class for table "ptb.tbl_pbpu".
 *
 * @property int $id
 * @property string $kali_ke
 * @property string $tarikh_mesyuarat
 * @property string $nama_mesyuarat
 * @property string $masa_mesyuarat
 * @property string $tempat_mesyuarat
 */
class TblPbpu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.ptb_tbl_pbpu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['masa_mesyuarat'], 'safe'],
            [['kali_ke'], 'string', 'max' => 50],
            [['tarikh_mesyuarat', 'nama_mesyuarat', 'tempat_mesyuarat'], 'string', 'max' => 155],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kali_ke' => 'Kali Ke',
            'tarikh_mesyuarat' => 'Tarikh Mesyuarat',
            'nama_mesyuarat' => 'Nama Mesyuarat',
            'masa_mesyuarat' => 'Masa Mesyuarat',
            'tempat_mesyuarat' => 'Tempat Mesyuarat',
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
  
      public function getTarikhMesyuarat() {
        return  $this->getTarikh($this->tarikh_mesyuarat);
    }
    
    


}
