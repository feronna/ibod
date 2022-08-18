<?php

namespace app\models\pengesahan;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "pengesahan.tbl_pnp".
 *
 * @property string $ICNO
 * @property string $tarikhPnp
 * @property string $tempatPnp
 * @property string $keputusan
 * @property string $status
 * @property string $tarikhKelulusan
 */
class TblPnp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'pengesahan.tbl_pnp';
        return 'hrm.sah_tbl_pnp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['ICNO', 'tarikhPnp', 'tarikhKelulusan', 'tempatPnp', 'keputusan', 'status'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['ICNO', 'status'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['tarikhPnp', 'tarikhKelulusan'], 'safe'],
            [['ICNO'], 'string', 'max' => 15],
            [['tempatPnp', 'keputusan', 'status'], 'string', 'max' => 122],
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
            'tarikhPnp' => 'Tarikh Lulus Pnp',
            'tempatPnp' => 'Tempat Pnp',
            'keputusan' => 'Keputusan',
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
    
    public function getTarikhpnp() {
        return  $this->getTarikh($this->tarikhPnp);
    }
    
    public function getTarikhkelulusan() {
        return  $this->getTarikh($this->tarikhKelulusan);
    }
}
