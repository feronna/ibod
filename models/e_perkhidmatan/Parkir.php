<?php

namespace app\models\e_perkhidmatan;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "keselamatan.utils_parkir".
 *
 * @property int $id
 * @property string $icno
 * @property string $jenis_kenderaan
 * @property string $no_pendaftaran_kenderaan
 * @property string $jenama_kenderaan
 * @property string $model_kenderaan
 * @property string $warna_kenderaan
 * @property string $tarikh_meletakkan_kenderaan
 * @property string $tarikh_pengambilan_kenderaan
 * @property int $days
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
 * @property int $isActive
 * @property int $letter_sent
 */
class Parkir extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.utils_parkir';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_kenderaan', 'no_pendaftaran_kenderaan', 'jenama_kenderaan', 'model_kenderaan', 'warna_kenderaan', 'tarikh_meletakkan_kenderaan', 'tarikh_pengambilan_kenderaan'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['jenis_kenderaan', 'no_pendaftaran_kenderaan', 'jenama_kenderaan', 'model_kenderaan', 'warna_kenderaan', 'ulasan_semakan', 'ulasan_kj'], 'string'],
            [['days', 'isActive', 'letter_sent'], 'integer'],
            [['entry_date', 'ver_date', 'app_date'], 'safe'],
            [['icno', 'ver_by', 'app_by'], 'string', 'max' => 15],
            [['tarikh_meletakkan_kenderaan', 'tarikh_pengambilan_kenderaan', 'status_semakan', 'status_kj'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 50],
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
            'jenis_kenderaan' => 'Jenis Kenderaan',
            'no_pendaftaran_kenderaan' => 'No Pendaftaran Kenderaan',
            'jenama_kenderaan' => 'Jenama Kenderaan',
            'model_kenderaan' => 'Model Kenderaan',
            'warna_kenderaan' => 'Warna Kenderaan',
            'tarikh_meletakkan_kenderaan' => 'Tarikh Meletakkan Kenderaan',
            'tarikh_pengambilan_kenderaan' => 'Tarikh Pengambilan Kenderaan',
            'days' => 'Days',
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
            'isActive' => 'Is Active',
            'letter_sent' => 'Letter Sent',
        ];
    }
    
      public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
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
    
        public function getStatuss() {
       
        if ($this->status == 'DALAM TINDAKAN KETUA JABATAN') {
            return '<span class="label label-info">Dalam Tindakan KJ</span>';
        }
        if ($this->status == 'DALAM TINDAKAN BSM') {
            return '<span class="label label-primary">Dalam Tindakan BSM</span>';
        }
        if ($this->status == 'LULUS') {
            return '<span class="label label-success">Berjaya</span>';
        }
        if ($this->status == 'TIDAK LULUS') {
            return '<span class="label label-danger">Ditolak</span>';
        }
                if ($this->status == 'LANJUTAN TANPA DENDA') {
            return '<span class="label label-danger">Ditolak</span>';
        }
                if ($this->status == 'LANJUTAN DENGAN DENDA') {
            return '<span class="label label-danger">Ditolak</span>';
        }
        if ($this->status == '') {
            return '-';
        }
        if ($this->status == 'DALAM TINDAKAN KETUA JFPIU') {
            return '<span class="label label-default">Dalam Tindakan KJ</span>';
        }
        if ($this->status == '') {
            return '-';
        }
    }
}
