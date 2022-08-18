<?php

namespace app\models\ejobs;

use Yii; 

class TblpKelayakanProfesional extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    public $file ; 
    
    public static function tableName()
    {
        return 'ejobs.tbl_kelayakanprof';
    }
 
    public function rules()
    {
        return [
            [['ICNO', 'sijil_nama', 'sijil_bdnOrganisasi', 'sijil_tarikh'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['sijil_tarikh','FileProf'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['sijil_nama', 'sijil_bdnOrganisasi'], 'string', 'max' => 250],
            [['file'], 'file','extensions'=>'pdf'],
        ];
    }
 
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'sijil_nama' => 'Nama Sijil',
            'sijil_bdnOrganisasi' => 'Nama Badan/Organisasi',
            'sijil_tarikh' => 'Tarikh Sijil',
        ];
    }
    
    public function Tarikh($bulan){
        
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
}
