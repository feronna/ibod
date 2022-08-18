<?php

namespace app\models\Kadpekerja;
use app\models\hronline\Tblprcobiodata;
use app\models\Kadpekerja\RefTempPayment;
use Yii;

/**
 * This is the model class for table "facility_keselamatan.utils_tbl_kad_pekerja".
 *
 * @property int $id
 * @property string $icno
 * @property string $entry_date
 * @property string $card_type jenis permohonan kad
 * @property string $ver_by pegawai peraku
 * @property string $ver_date
 * @property string $ver_catatan
 * @property string $app_by pegawai pelulus
 * @property string $app_date
 * @property string $app_catatan
 * @property string $dokumen dokumen sokongan/uploaded file
 * @property int $isActive aktif/tidak aktif
 * @property int $status_semasa
 */
class Kadpekerja extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public $file2;
    public $file3;
    public static function tableName()
    {
        return 'keselamatan.utils_tbl_kad_pekerja';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entry_date', 'ver_date', 'app_date', 'masa_ambil'], 'safe'],
            [['ver_catatan', 'app_catatan', 'dokumen', 'dokumen2', 'dokumen3'], 'string'],
            [['isActive', 'status_semasa', 'status_kad'], 'integer'],
            [['icno', 'ver_by', 'app_by', 'wakil_ICNO'], 'string', 'max' => 12],
            [['ver_stat', 'app_stat', 'cur_stat', 'card_id', 'payment'], 'string', 'max' => 50],
            [['card_type', 'card_owner', 'wakil_nama'], 'string', 'max' => 300],
            [['file', 'file2',  'file3'], 'file',  'extensions'=>'pdf','maxSize' => 5000000], 
            [['file', 'file2', 'file3' ],'safe'],  
            // [['surat_tawaran' ], 'required', 'message' => 'Muat Naik Dokumen!'],
            // [['surat_lantikan' ], 'required', 'message' => 'Muat Naik Dokumen!'],
            // [['dokumen3' ], 'required', 'message' => 'Muat Naik Dokumen!'],


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
            'entry_date' => 'Entry Date',
            'card_type' => 'Card Type',
            'cur_stat' => 'Status Terkini',
            'ver_stat' => 'Status Perakui',
            'ver_by' => 'Ver By',
            'ver_date' => 'Ver Date',
            'ver_catatan' => 'Ver Catatan',
            'app_stat' => 'Status Pelulus',
            'app_by' => 'App By',
            'app_date' => 'App Date',
            'app_catatan' => 'App Catatan',
            'dokumen' => 'Dokumen',
            'isActive' => 'Is Active',
            'status_semasa' => 'Status Semasa',
            'status_kad' => 'Status Kad',
            'card_owner' => 'Nama',
            'card_id' => 'Card ID',
            'payment' => 'Payment',
            'masa_ambil' => 'Tarikh/ Masa Pengambilan',
            'wakil_ICNO' => 'Wakil I/C',
            'wakil_nama' => 'Nama Wakil',
            'file' => 'Surat Tawaran',
            'file2' => 'Surat Lantikan',
            'file3' => 'Gambar',
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
     public function getEntryDt() {
        if ($this->entry_date != '') {
            return $this->getTarikh($this->entry_date);
        }
    } 
     public function getPickUpDt() {
        if ($this->masa_ambil != '') {
            return $this->getTarikh($this->masa_ambil);
        }
    } 
     public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    } 
    public function getKadPekerja() {
        return $this->hasOne(Refjeniskad::className(), ['id' => 'card_type']);
    }  
    public function getStatus() {
//        if ($this->status_kad == 1) {
//           return '<span class="label label-warning">BARU</span>';
//        } 
        if ($this->cur_stat == 'BARU' ) {
            return '<span class="label label-warning">BARU </span>';
        }
//        if ($this->cur_stat == 'DIPERAKUI' ) {
//            return '<span class="label label-info">DALAM TINDAKAN </span>';
//        }
//         if ($this->cur_stat == 'DILULUSKAN' && $this->status_kad != 1) {
//            return '<span class="label label-info">DALAM TINDAKAN </span>';
//        }
//        if ($this->cur_stat == 'DILULUSKAN' && $this->status_kad == 1) {
//            return '<span class="label label-success">MENUNGGU KUTIPAN </span>';
//        }
//        if ($this->cur_stat == 'TIDAK DIPERAKUI' || $this->cur_stat == 'TIDAK DILULUSKAN') {
//            return '<span class="label label-danger">DITOLAK  </span>';
//        }
//         if ($this->status_kad == 2) {
//            return '<span class="label label-success">MENUNGGU BAYARAN KAUNTER </span>';
//        }
         if ($this->status_kad == 3) {
            return '<span class="label label-success">MENUNGGU KUTIPAN </span>';
        }
        if ($this->cur_stat == 'SELESAI') {
            return '<span class="label label-success">PERMOHONAN SELESAI </span>';
        }
    }
     public function getVerStatus() {
        if ($this->ver_stat == 'BARU') {
           return '<span class="label label-warning">BARU</span>';
        } 
        if ($this->ver_stat == 'SEMAKAN LAYAK') {
           return '<span class="label label-info">Dalam Tindakan BSM</span>';
        }
        if ($this->ver_stat == 'SEMAKAN TIDAK LAYAK') {
           return '<span class="label label-info">Dalam Tindakan BSM</span>';
        }
        if ($this->ver_stat == 'DIPERAKUI') {
            return '<span class="label label-success">BERJAYA </span>';
        }
        if ($this->ver_stat == 'TIDAK DIPERAKUI') {
            return '<span class="label label-danger">DITOLAK  </span>';
        }
    }
    public function getAppStatus() {
        if ($this->app_stat == 'BARU') {
           return '<span class="label label-warning">BARU</span>';
        } 
        if ($this->app_stat == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-info">MENUNGGU TINDAKAN </span>';
        }         
        if ($this->app_stat == 'DILULUSKAN') {
            return '<span class="label label-success">BERJAYA </span>';
        }
        if ($this->app_stat == 'TIDAK DILULUSKAN') {
            return '<span class="label label-danger">DITOLAK  </span>';
        }
    }
      
    public function getStatuskad() {
        if ($this->status_kad == '1') {
           return '<span class="label label-success">KAD SEDIA DIAMBIL</span>';
        }
        
        if ($this->status_kad == '0') {
           return '<span class="label label-warning">DALAM PROSES</span>';
        } 
    }    
      public static function findKenderaan($id) {
        return RefTempPayment::find()->where(['utils_ref_temp_payment.id' => $id])->one();
    }


}
