<?php

namespace app\models\kontrak;

use Yii;

/**
 * This is the model class for table "kontrak.tbl_bukapermohonan".
 *
 * @property int $id
 * @property string $start_tamatkontrak
 * @property string $end_tamatkontrak
 * @property string $start_bolehmohon
 * @property string $end_bolehmohon
 */
class TblBukapermohonan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_tbl_bukapermohonan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_tamatkontrak', 'end_tamatkontrak', 'start_bolehmohon', 'end_bolehmohon'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_tamatkontrak' => 'Start Tamatkontrak',
            'end_tamatkontrak' => 'End Tamatkontrak',
            'start_bolehmohon' => 'Start Bolehmohon',
            'end_bolehmohon' => 'End Bolehmohon',
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
    
    public function getStartmohon() {
        return $this->getTarikh($this->start_bolehmohon);
    }
    public function getEndmohon() {
        return $this->getTarikh($this->end_bolehmohon);
    }
}
