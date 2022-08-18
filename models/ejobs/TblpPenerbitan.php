<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_penerbitan".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $tajuk
 * @property string $penerbit
 * @property string $tahun_penerbitan
 * @property string $tempat_penerbitan
 * @property string $jumlah_halaman
 */
class TblpPenerbitan extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_penerbitan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ 
            [['ICNO', 'tajuk', 'penerbit', 'tahun_penerbitan', 'tempat_penerbitan','role','penLevel'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['tahun_penerbitan'], 'integer'],
            [['ICNO'], 'string', 'max' => 12],
            [['tajuk', 'tempat_penerbitan'], 'string', 'max' => 300],
            [['penerbit'], 'string', 'max' => 200], 
            [['role', 'penLevel'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'tajuk' => 'Tajuk',
            'penerbit' => 'Penerbit',
            'tahun_penerbitan' => 'Tarikh Penerbitan',
            'tempat_penerbitan' => 'Tempat Penerbitan',
            'jumlah_halaman' => 'Jumlah Halaman',
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
