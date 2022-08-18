<?php

namespace app\models\tatatertib_staf;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\GredJawatan;
use app\models\hronline\Kumpulankhidmat;
use app\models\hronline\Department;
use app\models\tatatertib_staf\RefJenisKesalahan;
use app\models\tatatertib_staf\RefJenisHukuman;
use app\models\harta\RefKategori;




/**
 * This is the model class for table "tatatertib_staf.tbl_rekod".
 *
 * @property int $id
 * @property string $icno
 * @property string $nama
 * @property int $jabatan
 */
class TblRekod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tertib_tbl_rekod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['jabatan', 'kategori_jawatan'], 'integer'],
//            [['skim_perkhidmatan'], 'integer'],
//            [['icno', 'jenis_kesalahan'], 'safe'],
             [['jenis_kesalahan', 'file', 'catatan_rayuan', 'hukuman'], 'safe'],
//            [['nama', 'kes', 'icno_kp'], 'string', 'max' => 100],
            [['icno', 'jenis_kesalahan', 'kes','reason', 'tarikh_mula_kesalahan', 'tarikh_akhir_kesalahan','meeting_id'], 'required','message' => Yii::t('app', 'Wajib Diisi')],
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
            'nama' => 'Nama',
            'jabatan' => 'Jabatan',
        ];
    }
    
     public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
     public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
     public static function ExistApplication($icno) {
        if (TblRekod::find()->where(['icno' => $icno])->one()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
     public function getDept()
    {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }

       public function getKumpulanJawatan(){
        return $this->hasOne(Kumpulankhidmat::className(), ['id' => 'kumpulan_jawatan']);
    }
    
      public function getCampus()
    {
        return $this->hasOne(\app\models\hronline\Campus::className(), ['campus_id' => 'campus_id']);
    }
    
        public function getDisplayflag() {
        return $this->hasOne(\app\models\hronline\Flag::className(), ['flag_id' => 'status']);
    }
    
         public function getStatuspelulus() {
      
        if ($this->pelulus_agree == '1') {
            return '<span class="label label-success">BERSALAH</span>';
        }
        if ($this->pelulus_agree == '2') {
            return '<span class="label label-danger">TIDAK BERSALAH</span>';
        }
         if ($this->pelulus_agree == '0') {
            return '<span class="label label-danger">BELUM DIBINCANGKAN</span>';
        }
    }
    public function getStatusRayuan() {
      
        if ($this->pelulus_agree == '1') {
            return 'YA';
        }
        if ($this->pelulus_agree == '2') {
            return 'TIDAK';
        }
         else{
            return 'TIADA REKOD';
        }
    }
     public function getStatuspelulus2() {
      
        if ($this->pelulus_agree == '1') {
            return '<span class="label label-success">BERSALAH</span>';
        }
        if ($this->pelulus_agree == '2') {
            return '<span class="label label-danger">TIDAK BERSALAH</span>';
        }
         if ($this->pelulus_agree == '0') {
            return '<span class="label label-danger">BELUM DIBINCANGKAN</span>';
        }
    }
    
          public function getTarikhs($bulan){
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
      public function getTarikhNoti() {
        return  $this->getTarikhs($this->tarikh_noti);
    }
    
    
      public function getNamaPengerusi() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'pengerusi_icno']);
    }
    
        public function getMaklumatMeeting()
    {
        return $this->hasOne(TblUrusMesyuarat::className(), ['meeting_id' => 'meeting_id']);
    }
    
     public function getJenisKesalahan() {
        return $this->hasOne(RefJenisKesalahan::className(), ['id' => 'jenis_kesalahan']);
    }
       public function getJenisHukuman() {
        return $this->hasOne(RefJenisHukuman::className(), ['id' => 'hukuman']);
    }
    
      public function getKetuaJabatan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno_kj']);
    }
       
         public function getStatusNc() {
      
        if ($this->status_nc == '1') {
            return '<span class="label label-success">BERSALAH</span>';
        }
        if ($this->status_nc == '2') {
            return '<span class="label label-danger">TIDAK BERSALAH</span>';
        }
        
    }
    

}
