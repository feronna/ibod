<?php

namespace app\models\memorandum;
use app\models\memorandum\TblRekod;
use Yii;

/**
 * This is the model class for table "utilities.memo_tbl_tetapan".
 *
 * @property int $id
 * @property int $id_rekod
 * @property string $tarikh_buka
 * @property string $tarikh_tutup
 * @property string $icno
 * @property string $updated
 */
class TblTetapan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.memo_tbl_tetapan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_rekod'], 'integer'],
            [['tarikh_buka', 'tarikh_tutup', 'updated'], 'safe'],
            [['icno'], 'string', 'max' => 15],
            [['id_rekod','tarikh_tutup'], 'required','message' => Yii::t('app', 'Wajib Diisi')]
        
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
            'tarikh_buka' => 'Tarikh Buka',
            'tarikh_tutup' => 'Tarikh Tutup',
            'icno' => 'Icno',
            'updated' => 'Updated',
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
    
    
       public function getTarikhBuka() {
        return  $this->getTarikh($this->tarikh_buka);
    }
    
      public function getTarikhTutup() {
        return  $this->getTarikh($this->tarikh_tutup);
    }
    
      public function getTblRekod() {
        return $this->hasOne(TblRekod::className(), ['id' => 'id_rekod']);
    }
    
    
//       public function getTempohExpired(){
//       $date1 =   date('Y-m-d', strtotime(date('Y-m-d')));
//       $date2 = date_format(date_create(date($this->tarikh_tutup)), 'Y-m-d');
//       $diff = date_diff($date1,$date2);
//       $tempohExpired = "$diff->d  hari, $diff->m  bulan, $diff->Y tahun";
//       return $tempohExpired;
//        
//       
//    }
    
 
    
}
