<?php

namespace app\models\kemudahan;
use app\models\Kemudahan\RefTempahan;
use app\models\kemudahan\Refairport;

use Yii;

/**
 * This is the model class for table "facility.ref_jadual_penerbangan".
 *
 * @property int $id
 * @property string $jeniskemudahan
 * @property string $icno
 * @property string $tarikh_berlepas
 * @property string $dest_berlepas
 * @property string $masa_berlepas
 * @property string $tarikh_tiba
 * @property string $dest_tiba
 * @property string $masa_tiba
 * @property string $idTempahan
 * @property string $idKelas
 * @property string $entry_date
 * @property int $parent_id
 */
class Refjadualpenerbangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_ref_jadual_penerbangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ 
            [['tarikh_berlepas', 'tarikh_tiba','masa_berlepas', 'masa_tiba','dest_berlepas', 'dest_tiba'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['tarikh_berlepas', 'tarikh_tiba','entry_date',  'masa_berlepas', 'masa_tiba'], 'safe'],
            [['parent_id'], 'integer'],
            [[ 'masa_berlepas', 'masa_tiba'], 'string', 'max' => 100],
            [['jeniskemudahan'], 'string', 'max' => 5],
            [['icno', 'ref_icno'], 'string', 'max' => 12],
            [['dest_berlepas', 'dest_tiba'], 'string', 'max' => 255],
            [['idTempahan', 'idKelas'], 'string', 'max' => 2],  
            ['tarikh_berlepas', 'date',  'format' => 'php:Y-m-d'],
            ['tarikh_tiba', 'date',  'format' => 'php:Y-m-d'],
//            ['tarikh_tiba', 'compare', 'compareAttribute' => 'tarikh_berlepas', 'operator' => '>=', 'enableClientValidation' => false, 'message' => 'Invalid Date. Tarikh Ketibaan must be after Tarikh Perlepasan' ],
//            ['masa_tiba', 'compare', 'compareAttribute' => 'masa_berlepas', 'operator' => '>', 'enableClientValidation' => false, 'message' => 'Invalid Time!' ],
            
           
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jeniskemudahan' => 'Jeniskemudahan',
            'icno' => 'Icno',
            'ref_icno' => 'Ref ICNO',
            'tarikh_berlepas' => 'Tarikh Berlepas',
            'dest_berlepas' => 'Dest Berlepas',
            'masa_berlepas' => 'Masa Berlepas',
            'tarikh_tiba' => 'Tarikh Tiba',
            'dest_tiba' => 'Dest Tiba',
            'masa_tiba' => 'Masa Tiba',
            'idTempahan' => 'Id Tempahan',
//            'idKelas' => 'Id Kelas',
            'entry_date' => 'Entry Date',
            'parent_id' => 'Parent ID',
            'dest_berlepas_a' => 'Destinasi Berlepas kedua',
            'dest_tiba_a' => 'Destinasi Ketibaan kedua',
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
    
     public function getDepart() { 
            return $this->getTarikh($this->tarikh_berlepas); 
    }
    public function getArrival() { 
            return $this->getTarikh($this->tarikh_tiba); 
    }
    public function getTempahan() {
        return $this->hasOne(Reftempahan::className(), ['id' => 'idTempahan']);
    }
    
     public function getPenerbangan() {
        return $this->hasOne(Refpenerbangan::className(), ['id' => 'idKelas']);
    }   
     public function getFlight() {
        return $this->hasOne(Refairport::className(), ['kod' => 'dest_berlepas', ]);
    } 
    public function getFlight2() {
        return $this->hasOne(Refairport::className(), ['kod' => 'dest_berlepas_a', ]);
    } 
     public function getFlightTiba() {
        return $this->hasOne(Refairport::className(), ['kod' => 'dest_tiba', ]);
    } 
    public function getFlightTiba2() {
        return $this->hasOne(Refairport::className(), ['kod' => 'dest_tiba_a', ]);
    } 
}
