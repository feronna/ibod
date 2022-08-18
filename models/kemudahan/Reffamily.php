<?php

namespace app\models\kemudahan;

use Yii;

/**
 * This is the model class for table "facility.ref_family".
 *
 * @property int $id
 * @property string $icno
 * @property string $nama
 * @property string $umur
 * @property string $hubungan
 * @property string $ref_icno icno bagi pemohon
 * @property string $entry_date date data created
 */
class Reffamily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_ref_family';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno' ], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['entry_date', 'tarikh_lahir'], 'safe'],
            [['icno', 'ref_icno', 'parent_id'], 'string', 'max' => 12],
            [['idkemudahan'], 'string', 'max' => 5],
            [['nama', 'hubungan'], 'string', 'max' => 200],
//            [['umur'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idkemudahan' => 'jeniskemudahan',
            'icno' => 'ICNO :',
            'nama' => 'Nama :',
            'parent_id' => 'parent_id',
            'hubungan' => 'Hubungan :',
            'ref_icno' => 'Ref Icno',
            'entry_date' => 'Entry Date',
            'tarikh_lahir' => 'Tarikh Lahir',
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
    
      public function getTarikhLahir() { 
          if ($this->tarikh_lahir != '') {
            return $this->getTarikh($this->tarikh_lahir);
        }
           
    }
    
}
