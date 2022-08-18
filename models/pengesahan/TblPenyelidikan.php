<?php

namespace app\models\pengesahan;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "pengesahan.tbl_penyelidikan".
 *
 * @property string $ICNO
 * @property string $tarikhPembentangan
 * @property string $tajukPembentangan
 * @property string $tempatPembentangan
 * @property string $status
 * @property string $tarikhKelulusan
 */
class TblPenyelidikan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'pengesahan.tbl_penyelidikan';
        return 'hrm.sah_tbl_penyelidikan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'tarikhPembentangan', 'tarikhKelulusan', 'tajukPembentangan', 'tempatPembentangan', 'status'], 'required'],
            [['tarikhPembentangan', 'tarikhKelulusan'], 'safe'],
            [['ICNO'], 'string', 'max' => 15],
            [['tajukPembentangan', 'tempatPembentangan', 'status'], 'string', 'max' => 122],
            [['ICNO'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'tarikhPembentangan' => 'Tarikh Pembentangan',
            'tajukPembentangan' => 'Tajuk Pembentangan',
            'tempatPembentangan' => 'Tempat Pembentangan',
            'status' => 'Status',
            'tarikhKelulusan' => 'Tarikh Kelulusan',
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
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
    
    public function getTarikhpembentangan() {
        return  $this->getTarikh($this->tarikhPembentangan);
    }
    
    public function getTarikhkelulusan() {
        return  $this->getTarikh($this->tarikhKelulusan);
    }
}
