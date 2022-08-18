<?php

namespace app\models\tatatertib_staf;

use Yii;
use app\models\tatatertib_staf\TblAhliMesyuarat;
use app\models\hronline\Flag;
use app\models\tatatertib_staf\RefBidangKuasa;


/**
 * This is the model class for table "tatatertib_staf.tbl_urus_mesyuarat".
 *
 * @property int $id
 * @property string $kali_ke
 * @property string $tarikh_mesyuarat
 * @property string $nama_mesyuarat
 * @property string $masa_mesyuarat
 * @property string $tempat_mesyuarat
 */
class TblUrusMesyuarat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tertib_tbl_urus_mesyuarat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['masa_mesyuarat'], 'safe'],
//            [['tarikh_mesyuarat'], 'safe'],
//            [['nama_mesyuarat', 'tempat_mesyuarat'], 'string', 'max' => 122],
            [['nama_mesyuarat', 'tempat_mesyuarat', 'tarikh_mesyuarat', 'pengerusi_icno', 'bidang_kuasa','kategori'], 'required','message' => Yii::t('app', 'Wajib Diisi')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'meeting_id' => 'ID',
            'kali_ke' => 'Kali Ke',
            'tarikh_mesyuarat' => 'Tarikh Mesyuarat',
            'nama_mesyuarat' => 'Nama Mesyuarat',
            'masa_mesyuarat' => 'Masa Mesyuarat',
            'tempat_mesyuarat' => 'Tempat Mesyuarat',
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
       public function getHari($hari){
        
        $D = date_format(date_create($hari), "D");
        if($D == 'Mon'){
            $D = "Isnin";}
        elseif ($D == 'Tue'){
          $D = "Selasa";}
        elseif ($D == 'Wed'){
          $D = "Rabu";}
        elseif ($D == 'Thu'){
          $D = "Khamis";}
        elseif ($D == 'Fri'){
          $D = "Jumaat";}   
          
        return  $D ;
    }
    public function getCreated() {
        return  $this->getTarikh($this->created_at);
    }
    public function getDateIssue() {
        return  $this->getTarikh($this->date_issue);
    }
      public function getHariIssue() {
        return  $this->getHari($this->date_issue);
    }
      public function getTarikhMesyuarat() {
        return  $this->getTarikh($this->tarikh_mesyuarat);
    }
    
     public function getDisplayflag() {
        return $this->hasOne(Flag::className(), ['flag_id' => 'status']);
    }
    
     public function getKategoriPegawai() {
        return $this->hasOne(RefKategori::className(), ['id' => 'kategori']);
    }
    
       public function getBidang() {
        return $this->hasOne(RefBidangKuasa::className(), ['id' => 'bidang_kuasa']);
    }
    
       public function getNamaPengerusi() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'pengerusi_icno']);
    }
//    
//       public function getBidangKuasa() {
//        if($this->bidang_kuasa == '1'){
//            return 'Tindakan tatatertib dengan tujuan buang kerja atau turun pangkat';
//        }
//        else{
//            return 'Tindakan tatatertib bukan dengan tujuan buang kerja atau turun pangkat';
//        }
//  
//    }
    
      
//      public function getAhliMeeting() {
//        return $this->hasMany(TblAhliMesyuarat::className(), ['meeting_id' => 'id']);
//    }
    
//        public function AhliMeeting($id){
//        $model = TblAhliMesyuarat::find()->where(['meeting_id'=>$id])->all();
//        $a = '';
//        foreach ($model as $model){
//           $a .= '<li>'.ucwords(strtolower($model->icno));
//     
//        }
//        
//        return $a;
//    }
    
        public function AhliMeeting(){
        $model = TblAhliMesyuarat::find()->where(['meeting_id'=>$this->id])->all();
      
//        foreach ($model as $models){ 
//       
//        echo'<li>' .$models->icno; 
////        echo "&nbsp"; echo "&nbsp"; echo "&nbsp"; echo "&nbsp"; echo "&nbsp"; echo "&nbsp";
//   
//           
//           echo'<br>';
//    
//        }
        
        return $model;
    }
    
        public function getBidangKuasa() {
        return $this->hasOne(RefBidangKuasa::className(), ['id' => 'bidang_kuasa']);
    }
    
}
