<?php

namespace app\models\memorandum;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;

/**
 * This is the model class for table "utilities.memo_tbl_makluman".
 *
 * @property int $id
 * @property int $id_rekod
 * @property string $icno
 * @property int $dept_id
 * @property string $tarikh_makluman
 */
class TblMakluman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.memo_tbl_makluman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_rekod', 'dept_id'], 'integer'],
            [['tarikh_makluman'], 'safe'],
            [['icno'], 'string', 'max' => 15],
            [['dept_id','icno'], 'required','message' => Yii::t('app', 'Wajib Diisi')]
        
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_rekod' => 'Id Rekod',
            'icno' => 'Icno',
            'dept_id' => 'Dept ID',
            'tarikh_makluman' => 'Tarikh Makluman',
        ];
    }
    
       public function getnamaPemakluman() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
       public function getJabatanPemakluman() {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
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
    
    
       public function getTarikhPemakluman() {
        return  $this->getTarikh($this->tarikh_makluman);
    }
    
     public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
         public function getTblRekod() {
        return $this->hasOne(TblRekod::className(), ['id' => 'id_rekod']);
    }
    
}
