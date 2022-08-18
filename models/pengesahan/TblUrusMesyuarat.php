<?php

namespace app\models\pengesahan;

use Yii;

/**
 * This is the model class for table "pengesahan.tbl_urus_mesyuarat".
 *
 * @property int $id
 * @property string $tahun_mesyuarat
 * @property string $tarikh_mesyuarat
 * @property string $nama_mesyuarat
 * @property string $masa_mesyuarat
 * @property string $tempat_mesyuarat
 */
class TblUrusMesyuarat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'pengesahan.tbl_urus_mesyuarat';
        return 'hrm.sah_tbl_urus_mesyuarat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh_pengesahan', 'kali_ke', 'tahun_mesyuarat' , 'tarikh_mesyuarat', 'masa_mesyuarat', 'nama_mesyuarat', 'tempat_mesyuarat'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            
            [['masa_mesyuarat'], 'safe'],
          
            [['kali_ke', 'tahun_mesyuarat', 'tarikh_mesyuarat', 'nama_mesyuarat', 'masa_mesyuarat', 'tempat_mesyuarat'], 'string', 'max' => 122],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kali_ke' => 'Mesyuarat Kali Ke',
            'tahun_mesyuarat' => 'Tahun Mesyuarat',
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
    
    
}
