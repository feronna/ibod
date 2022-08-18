<?php

namespace app\models\pengesahan;

use Yii;
use app\models\hronline\Tblprcobiodata;
/**
 * This is the model class for table "pengesahan.tbl_ptm".
 *
 * @property string $ICNO
 * @property string $tarikhPtm
 * @property string $tempatPtm
 * @property string $status
 * @property string $tarikhMesyuarat
 * @property int $bilMesyuarat
 */
class TblPtm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'pengesahan.tbl_ptm';
        return 'hrm.sah_tbl_ptm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['ICNO', 'tarikhPtm', 'tarikhMesyuarat', 'bilMesyuarat', 'tempatPtm', 'status'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['ICNO', 'status'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['tarikhPtm', 'tarikhPtm1', 'tarikhPtm2', 'tarikhMesyuarat'], 'safe'],
            //[['bilMesyuarat', 'siri'], 'integer'],
            [['ICNO'], 'string', 'max' => 15],
            [['bilMesyuarat', 'siri', 'tempatPtm', 'status', 'pengecualianPtm'], 'string', 'max' => 122],
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
            'bilMesyuarat' => 'Bil Mesyuarat',
            'tarikhMesyuarat' => 'Tarikh Mesyuarat',
            'tarikhPtm' => 'Tarikh Kelulusan',
            'tarikhPtm1' => 'Tarikh Mula Kursus',
            'tarikhPtm2' => 'Tarikh Tamat Kursus',
            'tempatPtm' => 'Tempat Ptm',
            'siri' => 'Kursus Siri',
            'status' => 'Status',
            'pengecualianPtm' => 'Pengecualian PTM',
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
    
    public function getTarikhptm() {
        return  $this->getTarikh($this->tarikhPtm);
    }
    
    public function getTarikhptm1() {
        return  $this->getTarikh($this->tarikhPtm1);
    }
    
    public function getTarikhptm2() {
        return  $this->getTarikh($this->tarikhPtm2);
    }
    
    public function getTarikhmesyuarat() {
        return  $this->getTarikh($this->tarikhMesyuarat);
    }
    
    public function getDept()
    {
        return $this->hasOne(Department::className(), ['id' => 'DeptId']);
    }
    
    public function getTarikhlulusptm() {
        return  $this->getTarikh($this->tarikhPtm);
    }
}
