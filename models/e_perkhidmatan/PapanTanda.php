<?php

namespace app\models\e_perkhidmatan;

use Yii;
use app\models\hronline\Tblprcobiodata;


/**
 * This is the model class for table "keselamatan.utils_papan_tanda".
 *
 * @property int $id
 * @property string $icno
 * @property string $tajuk
 * @property string $tarikh_mula
 * @property string $tarikh_hingga
 * @property string $tempat
 * @property string $masa
 * @property string $status
 * @property string $entry_date
 * @property string $ver_by
 * @property string $ver_date
 * @property string $status_semakan
 * @property string $ulasan_semakan
 * @property string $app_by
 * @property string $app_date
 * @property string $status_kj
 * @property string $ulasan_kj
 */
class PapanTanda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.utils_papan_tanda';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tajuk', 'tarikh_mula', 'tarikh_hingga'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['tajuk', 'tempat', 'ulasan_semakan', 'ulasan_kj'], 'string'],
            [['days'], 'integer'],
            [['entry_date', 'ver_date', 'app_date'], 'safe'],
            [['icno', 'ver_by', 'app_by'], 'string', 'max' => 15],
            [['tarikh_mula', 'tarikh_hingga', 'masa', 'status', 'status_semakan', 'status_kj'], 'string', 'max' => 20],
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
            'tajuk' => 'Tajuk',
            'tarikh_mula' => 'Tarikh Mula',
            'tarikh_hingga' => 'Tarikh Hingga',
            'tempat' => 'Tempat',
            'masa' => 'Masa',
            'status' => 'Status',
            'entry_date' => 'Entry Date',
            'ver_by' => 'Ver By',
            'ver_date' => 'Ver Date',
            'status_semakan' => 'Status Semakan',
            'ulasan_semakan' => 'Ulasan Semakan',
            'app_by' => 'App By',
            'app_date' => 'App Date',
            'status_kj' => 'Status Kj',
            'ulasan_kj' => 'Ulasan Kj',
        ];
    }
    
        public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
        public function getStatuss() {
       
        if ($this->status == 'DALAM TINDAKAN KETUA JABATAN') {
            return '<span class="label label-info">Dalam Tindakan KJ</span>';
        }
        if ($this->status == 'MENUNGGU') {
            return '<span class="label label-warning">Menunggu</span>';
        }
        if ($this->status == 'LULUS') {
            return '<span class="label label-success">Selesai</span>';
        }
        if ($this->status == 'TIDAK LULUS') {
            return '<span class="label label-danger">Selesai</span>';
        }
        if ($this->status == '') {
            return '-';
        }
    }
    
        public function getStatuskj() {
        if ($this->status_kj == 'Tunggu Perakuan') {
            return '<span class="label label-warning">Menunggu</span>';
        }
        if ($this->status_kj == 'Diperakui') {
            return '<span class="label label-success">Diperakui</span>';
        }
        if ($this->status_kj == 'Tidak Diperakui') {
            return '<span class="label label-danger">Tidak Diperakui</span>';
        }
         if ($this->status_jfpiu == '-') {
            return '-';
        }
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
    
        public function getTarikhh($bulan){
        
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
          
       return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y H:i:s A");
    }
    
         public function getEntrydate() {
        if($this->entry_date!=''){
        return $this->getTarikhh($this->entry_date);}
    }
    
        public function getAppdate() {
        return  $this->getTarikhh($this->app_date);
    }
    
}
