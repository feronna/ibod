<?php

namespace app\models\harta;

use Yii;

/**
 * This is the model class for table "harta.tbl_mesyuarat".
 *
 * @property int $id
 * @property string $tarikh_mesyuarat
 * @property string $nama_mesyuarat
 * @property string $masa mesyuarat
 * @property string $tempat_mesyuarat
 */
class TblMesyuarat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_tbl_mesyuarat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['masa mesyuarat'], 'safe'],
            [['tarikh_mesyuarat', 'nama_mesyuarat', 'tempat_mesyuarat'], 'string', 'max' => 122],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tarikh_mesyuarat' => 'Tarikh Mesyuarat',
            'nama_mesyuarat' => 'Nama Mesyuarat',
            'masa mesyuarat' => 'Masa Mesyuarat',
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
    public function getTarikhMesyuarat() {
        return  $this->getTarikh($this->tarikh_mesyuarat);
    }
}
