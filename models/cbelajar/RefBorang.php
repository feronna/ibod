<?php

namespace app\models\cbelajar;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "cbelajar.ref_borang".
 *
 * @property int $idBorang
 * @property string $jenisBorang
 */
class RefBorang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_borang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenisBorang'], 'string', 'max' => 255],
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id Borang',
            'jenisBorang' => 'Jenis Borang',
            'status' => 'Status',
        ];
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
//    public function getBorang(){
//        return $this->hasMany(RefBorang::className(), ['id' => 'idBorang']);
//    }
 public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => $this->kakitangan->gredJawatan]);
    }
     public function checkPermohonan($id, $idBorang){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'idBorang' => $idBorang, 'iklan_id' => $id, 'status_proses' => "Selesai Permohonan"]); 
        
        return $model;
    } 
     public function checkPermohonan9($id){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'idBorang' => 32, 'iklan_id' => $id, 'status_proses' => "Selesai Permohonan"]); 
        
        return $model;
    }
       public function checkPermohonan2($id){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'idBorang' => 1, 'iklan_id' => $id, 'status_proses' => "Selesai Permohonan"]); 
        
        return $model;
    } 
      public function checkPermohonan1($id){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'idBorang' => [2,40,51], 'iklan_id' => $id, 'status_proses' => "Selesai Permohonan"]); 
        
        return $model;
    } 
     public function checkPermohonan3($id){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'idBorang' => 39, 'iklan_id' => $id, 'status_proses' => "Selesai Permohonan"]); 
        
        return $model;
    } 
     public function checkPermohonan4($id){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'idBorang' => 40, 'iklan_id' => $id, 'status_proses' => "Selesai Permohonan"]); 
        
        return $model;
    } 
     public function checkPermohonan5($id){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'idBorang' => 41, 'iklan_id' => $id, 'status_proses' => "Selesai Permohonan"]); 
        
        return $model;
    } 
     public function checkPermohonan6($id){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'idBorang' => 42, 'iklan_id' => $id, 'status_proses' => "Selesai Permohonan"]); 
        
        return $model;
    } 
     public function checkPermohonan7($id){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'idBorang' => 43, 'iklan_id' => $id, 'status_proses' => "Selesai Permohonan"]); 
        
        return $model;
    } 
      public function checkPermohonan8($id){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'idBorang' => 47, 'iklan_id' => $id, 'status_proses' => "Selesai Permohonan"]); 
        
        return $model;
    } 
     public function checkPermohonan10($id){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'idBorang' => 51, 'iklan_id' => $id, 'status_proses' => "Selesai Permohonan"]); 
        
        return $model;
    } 
     public function checkPermohonanLanjutan( $iklan){
        $model = TblLanjutan::findOne(['icno' => Yii::$app->user->getId(), 'iklan_id' => $iklan, 'status_borang'=>"Selesai Permohonan"]); 
        
        return $model;
    } 
     public function checkPermohonanLain($id, $idBorang){
        $model = TblLain::findOne(['icno' => Yii::$app->user->getId(),'idBorang' => $idBorang, 'iklan_id' => $id, 'status_borang' => "Selesai Permohonan"]); 
        
        return $model;
    } 
      public function checkSimpan($id, $idBorang){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'iklan_id' => $id,'idBorang' => $idBorang, 'status_proses' => "Data Disimpan"]); 
        
        return $model;
    } 
     public function checkBuka($id, $idBorang){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'iklan_id' => $id,'idBorang' => $idBorang, 'status_proses' => "Buka Borang"]); 
        
        return $model;
    } 
        public function checkSimpan1($id, $idBorang){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'iklan_id' => $id,'idBorang' => 32, 'status_proses' => "Data Disimpan"]); 
        
        return $model;
    }
       public function checkSimpan2($id, $idBorang){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'iklan_id' => $id,'idBorang' => 2, 'status_proses' => "Data Disimpan"]); 
        
        return $model;
    } 
     public function checkSimpan3($id, $idBorang){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'iklan_id' => $id,'idBorang' => 40, 'status_proses' => "Data Disimpan"]); 
        
        return $model;
    } 
     public function checkSimpan4($id, $idBorang){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'iklan_id' => $id,'idBorang' => [41,51], 'status_proses' => "Data Disimpan"]); 
        
        return $model;
    } 
     public function checkSimpanBorang($iklan){
        $model = TblLanjutan::findOne(['icno' => Yii::$app->user->getId(),'iklan_id' => $iklan]); 
        
        return $model;
    } 
      public function getMesyuarat() {
         return $this->hasOne(TblUrusMesyuarat::className(), ['id'=>'id']);
    }
     public function getBorang(){
        return $this->hasMany(TblPermohonan::className(), ['idBorang' => 'id']);
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
     public function checkUpload($id, $iklan){
        $model = TblFilePemohon::find()->where(['uploaded_by' => Yii::$app->user->getId(),'dokumenCd' => $id, 'iklan_id'=>$iklan, 'idBorang'=>4])->all(); 
        
        return $model;
    } 
}
