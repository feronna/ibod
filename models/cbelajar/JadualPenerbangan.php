<?php

namespace app\models\cbelajar;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "cbelajar.jadual_penerbangan".
 *
 * @property int $id
 * @property string $icno
 * @property string $tarikh_berlepas
 * @property string $dest_berlepas
 * @property string $tarikh_tiba
 * @property string $dest_tiba
 * @property string $idTempahan
 * @property string $idKelas
 * @property string $tarikh_mohon
 * @property int $tahun
 */
class JadualPenerbangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_jadualterbang';
    }

    /**
     * {@inheritdoc}
     */
     public function rules()
    {
        return [
//            [['tarikh_berlepas', 'masa_berlepas', 'tarikh_tiba', 'masa_tiba', 'dest_tiba', 'cw_cgpa', 'dest_berlepas', 'ms_semester', 'ms_achieved', 'reason_achieved', 'discussed_problem', 'research_problem', 'no_ofdiscuss', 'activity_sem', 'publications', 'completion_date', 'achievement_report', 'dokumen_sokongan2', 'sv_name', 'thesis_title', 'studentno'], 'required', 'message'=>"This space is mandatory"],
            [['tarikh_berlepas', 'masa_berlepas', 'tarikh_tiba', 'masa_tiba'], 'safe'],
            [['dest_berlepas','tarikh_berlepas', 'masa_berlepas','dest_tiba', 'tarikh_tiba', 'masa_tiba', 'idTempahan'], 'required', 'message' => 'Ruang ini adalah mandatori'],
//            [['idKelas'], 'required'],
            [['icno'], 'string', 'max' => 12],
            [['dest_berlepas', 'dest_tiba'], 'string', 'max' => 255],
            [['idTempahan'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'dest_berlepas'=> 'Destinasi Berlepas',
            'dest_tiba' => 'Destinasi Tiba',
            'tarikh_berlepas' => 'Tarikh Berlepas',
            'dest_berlepas' => 'Dest Berlepas',
            'masa_berlepas' => 'Masa Berlepas',
            'tarikh_tiba' => 'Tarikh Tiba',
            'dest_tiba' => 'Dest Tiba',
            'masa_tiba' => 'Masa Tiba',
            'idTempahan' => 'Id Tempahan',
            
        ];
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
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
    
    public function getTarikhmohon() {
        return $this->getTarikh($this->tarikhmohon);
    }
    
//    public function getTarikhberlepas() {
//        return $this->getTarikh($this->tarikh_berlepas);
//    }
//    
//    public function getTarikhtiba() {
//        return $this->getTarikh($this->tarikh_tiba);
//    }
    public function getJadualTempahan() {
        return $this->hasOne(JadualPenerbangan::className(), ['icno' => 'icno']);
    }
    
//    public function getJeniskelas() {
//        return $this->hasOne(RefPenerbangan::className(), ['id'=>'idKelas']);
//    }
    
    public function getJenistempahan() {
        return $this->hasOne(RefTempahan::className(), ['id'=>'idTempahan']);
    }

   public function getTarikhberlepas() {
        return $this->getTarikh($this->tarikh_berlepas);
    }
    
    public function getTarikhtiba() {
        return $this->getTarikh($this->tarikh_tiba);
    }
}
