<?php

namespace app\models\pinjaman;
use app\models\hronline\Tblprcobiodata;
use app\models\pinjaman\Refbank;
use app\models\keterhutangan\TblRekod;
use app\models\hronline\Tblrscoretireage;
use app\models\hronline\Tblrscopsnstatus;
use app\models\hronline\Tblrscoconfirmstatus;
use app\models\vhrms\ViewPayroll;
 

/**
 * This is the model class for table "pinjaman.tbl_permohonan".
 *
 * @property int $id
 * @property string $icno
 * @property string $tarikh_mohon
 * @property int $status_semasa 1 = aktif 0 = tidak aktif
 * @property string $no_kakitangan
 * @property string $agensi_bank
 * @property string $jumlah_pinjaman
 * @property string $bayaran_bulanan
 * @property string $jumlah_bulan_bayaran
 * @property string $status_pt
 * @property string $catatan_pt
 * @property string $datetime_pt
 * @property string $status_pp
 * @property string $catatan_pp
 * @property string $datetime_pp
 * @property string $dokumen_sokongan
 * @property int $isActive
 * @property string $tarikh_diambil tarikh surat diambil
 * @property string $diterima_oleh surat diterima kakitangan
 */
class Pinjaman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.fac_tbl_permohonan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['butiran','tujuan', 'nama_tempat', 'negara', 'date_from', 'date_to', 'days', 'file', 'file2'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['agensi_bank', 'jumlah_pinjaman', 'bayaran_bulanan', 'jumlah_bulan_bayaran'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['tarikh_mohon', 'datetime_pt', 'datetime_pp', 'tarikh_diambil'], 'safe'],
            [['status_semasa', 'isActive', 'stat_surat'], 'integer'],
            [['jumlah_pinjaman', 'bayaran_bulanan', 'jumlah_bulan_bayaran'], 'number'],
            [['dokumen_sokongan'], 'string'],
            [['icno', 'no_kakitangan', 'semakan_by', 'peraku_by', 'diterima_icno'], 'string', 'max' => 12],
            [['agensi_bank', 'diterima_oleh'], 'string', 'max' => 250],
            [['status_pt', 'status_pp'], 'string', 'max' => 20],
            [['catatan_pt', 'catatan_pp'], 'string', 'max' => 500],
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
            'tarikh_mohon' => 'Tarikh Mohon',
            'status_semasa' => 'Status Semasa',
            'no_kakitangan' => 'No Kakitangan',
            'agensi_bank' => 'Agensi Bank',
            'jumlah_pinjaman' => 'Jumlah Pinjaman',
            'bayaran_bulanan' => 'Bayaran Bulanan',
            'jumlah_bulan_bayaran' => 'Jumlah Bulan Bayaran',
            'status_pt' => 'Status Pt',
            'catatan_pt' => 'Catatan Pt',
            'datetime_pt' => 'Datetime Pt',
            'status_pp' => 'Status Pp',
            'catatan_pp' => 'Catatan Pp',
            'datetime_pp' => 'Datetime Pp',
            'dokumen_sokongan' => 'Dokumen Sokongan',
            'isActive' => 'Is Active',
            'stat_surat' => 'Status Surat',
            'tarikh_diambil' => 'Tarikh Diambil',
            'diterima_oleh' => 'Diterima Oleh',
            'semakan_by' => 'Semakan Oleh',
            'peraku_by' => 'Peraku Oleh',
            'diterima_icno' => 'Icno Penerima',
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
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    } 

    public function getTarikhM() {
        if ($this->tarikh_mohon != '') {
            return $this->getTarikh($this->tarikh_mohon);
        }
    }
     public function getDatetimept() { 
         if ($this->datetime_pt != '') {
            return $this->getTarikh($this->datetime_pt); 
         }    
    }
     public function getDatetimepp() {  
        if ($this->datetime_pp != '') {
            return $this->getTarikh($this->datetime_pp);    
        }    
    }
    public function getBank() {
        return $this->hasOne(Refbank::className(), ['id' => 'agensi_bank']);
    } 
    
     public function getStatusLantikan() {
        return $this->hasOne(StatusLantikan::className(), ['ApmtStatusCd' => 'statLantikan']);
    }
    
    public function getRekodDt() {
        if ($this->tarikh_diambil != '') {
            return $this->getTarikh($this->tarikh_mohon);
        }
    }
    
    public function getRekod() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'diterima_oleh']);
    } 
    
    public function getStatsurat() {
        if ($this->stat_surat == '1') {
           return '<span class="label label-success">SURAT SEDIA DIAMBIL</span>';
        }
        
        if ($this->stat_surat == '0') {
           return '<span class="label label-warning">DALAM PROSES</span>';
        } 
    }
    
    public function getStatuss() {
        if ($this->status_pp == 'BARU') {
           return '<span class="label label-warning">BARU</span>';
        }
        
        if ($this->status_pp == 'SEMAKAN LAYAK') {
           return '<span class="label label-info">Dalam Tindakan BSM</span>';
        }
        if ($this->status_pp == 'SEMAKAN TIDAK LAYAK') {
           return '<span class="label label-info">Dalam Tindakan BSM</span>';
        }
        if ($this->status_pp == 'DIPERAKUI') {
            return '<span class="label label-success">BERJAYA </span>';
        }
        if ($this->status_pp == 'TIDAK DIPERAKUI') {
            return '<span class="label label-danger">DITOLAK  </span>';
        }
    }
    public function getStatuspt() {
        if ($this->status_pt == 'BARU') {
            return '<span class="label label-warning">BARU</span>';
        }
         if ($this->status_pt == 'SEMAKAN LAYAK') {
            return '<span class="label label-success">BERJAYA</span>';
        }
        if ($this->status_pt == 'SEMAKAN TIDAK LAYAK') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
//        if ($this->status_pp == 'DIPERAKUI') {
//            return '<span class="label label-success">BERJAYA</span>';
//        }
//        if ($this->status_pp == 'TIDAK DIPERAKUI') {
//            return '<span class="label label-danger">DITOLAK</span>';
//        }
//        if ($this->status_pp === NULL) {
//            return '-';
//        }

    }
    public function getStatuspp() {
        if ($this->status_pp == 'BARU') {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->status_pp == 'SEMAKAN LAYAK') {
            return '<span class="label label-info">Dalam Tindakan BSM</span>';
        }
        if ($this->status_pp == 'SEMAKAN TIDAK LAYAK') {
            return '<span class="label label-info">Dalam Tindakan BSM</span>';
        }
        if ($this->status_pp == 'DIPERAKUI') {
            return '<span class="label label-success">BERJAYA</span>';
        }
        if ($this->status_pp == 'TIDAK DIPERAKUI') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
//        if ($this->status_pp === NULL) {
//            return '-';
//        }

    }  
     public function getUmurBersara() {
         return $this->hasOne(Tblrscoretireage::className(), ['ICNO' => 'icno']);
    }

    public function getStatPencen() {
         return $this->hasOne(Tblrscopsnstatus::className(), ['ICNO' => 'icno']);
    }
    
    public function getConfirmation() { 
        return $this->hasOne(Tblrscoconfirmstatus::className(), ['ICNO' => 'icno']);
    }
    
    public function getConfirmstatusstdt() {
        return  $this->getTarikh($this->confirmstatusdt); 
    }

     public function getPayroll() {
        return $this->hasOne(ViewPayroll::className(), ['sm_ic_no' => 'icno']);
    } 
   
    
}
