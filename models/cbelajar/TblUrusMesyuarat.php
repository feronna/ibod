<?php

namespace app\models\cbelajar;

use Yii;
use app\models\cbelajar\TblPermohonan;
use app\models\cbelajar\TblPengajian;

/**
 * This is the model class for table "cbelajar.tbl_urus_mesyuarat".
 *
 * @property int $id
 * @property string $kali_ke
 * @property string $nama_mesyuarat
 * @property string $tarikh_mesyuarat
 * @property string $tarikh_buka
 * @property string $tarikh_tutup
 * @property int $status
 * @property int $kategori_id
 * @property int $jumlah_mohon
 */
class TblUrusMesyuarat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_urus_mesyuarat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kali_ke', 'nama_mesyuarat', 'tarikh_mesyuarat', 'tarikh_buka', 'tarikh_tutup', 'status', 'kategori_id'], 'required'],
            [['tarikh_buka', 'tarikh_tutup'], 'safe'],
            [['status', 'kategori_id', 'jumlah_mohon'], 'integer'],
            [['kali_ke', 'tarikh_mesyuarat'], 'string', 'max' => 122],
            [['nama_mesyuarat'], 'string', 'max' => 255],
            [['created_dt'], 'safe'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kali_ke' => 'Kali Ke',
            'nama_mesyuarat' => 'Nama Mesyuarat',
            'tarikh_mesyuarat' => 'Tarikh Mesyuarat',
            'tarikh_buka' => 'Tarikh Buka',
            'tarikh_tutup' => 'Tarikh Tutup',
            'status' => 'Status',
            'kategori_id' => 'Kategori ID',
            'jumlah_mohon' => 'Jumlah Mohon',
            'created_dt' => 'Created Dt',
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
    public function jumlahPermohonanbySemasa($iklan_id) {
        return TblPermohonan::find()->where(['iklan_id' => $iklan_id, 'status_proses' => "Selesai Permohonan"])->count();
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
    public function getTarikhbuka() {
        return  $this->getTarikh($this->tarikh_buka);

    }

    public function getTarikhtutup() {
        return  $this->getTarikh($this->tarikh_tutup);
    }
   
    public function getPengajian() {
        return $this->hasOne(TblPengajian::className(), [ 'iklan_id' => 'id']);
    }
    public function getTarikhMesyuarat() {
        return strtoupper($this->getTarikh($this->tarikh_mesyuarat));
    }

    public function getMesyuarat() {
         return $this->hasOne(TblUrusMesyuarat::className(), ['nama_mesyuarat'=>'nama_mesyuarat']);
    }

    public function getKategori(){
        return $this->hasOne(\app\models\cbelajar\KategoriMesyuarat::className(), ['id' => 'kategori_id']);  
    }

    public function checkPermohonan($id){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'iklan_id' => $id, 'status_proses' => "Selesai Permohonan", 'id'=> $id]); 
        
        return $model;
    } 

    public function checkSimpan($id){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'iklan_id' => $id, 'status_proses' => "Data Disimpan"]); 
        
        return $model;
    } 
     public function checkSimpan1($id){
        $model = TblPermohonan::findOne(['icno' => Yii::$app->user->getId(),'iklan_id' => $id, 'status_proses' => "Data Disimpan"]); 
        
        return $model;
    }
     public function getPermohonan(){
        return $this->hasMany(\app\models\cbelajar\TblPermohonan::className(), ['id' => 'id']);
    }
    
    

     public function checkUploadFile($id){
        
        $model = TblFilePemohon::findAll(['iklan_id' => $id]); 
        
        return $model;
    }
    
    
     
}
