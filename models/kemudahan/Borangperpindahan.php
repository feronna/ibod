<?php

namespace app\models\kemudahan;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblalamat;
/**
 * This is the model class for table "facility.borang_perpindahan".
 *
 * @property int $id
 * @property string $icno
 * @property string $jeniskemudahan
 * @property string $tarikh_pindah
 * @property string $old_add
 * @property string $new_add
 * @property string $jumlah_tuntutan
 * @property string $resit
 * @property string $entry_date
 * @property string $status_pt
 * @property string $catatan_pt
 * @property string $semakan_pt
 * @property string $status_pp
 * @property string $catatan_pp
 * @property string $ver_date
 * @property string $tarikh_hantar
 * @property string $status_kj
 * @property string $catatan_kj
 * @property string $app_date
 * @property string $pengakuan
 * @property string $jumlah
 * @property string $dokumen_sokongan
 * @property string $dokumen_sokongan2
 * @property int $mohon
 * @property int $isActive2 0 = inactive, 1 = active
 */
class Borangperpindahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public $file2;
    public static function tableName()
    {
        return 'utilities.fac_tbl_perpindahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh_pindah', 'jumlah_tuntutan', 'old_add',  'new_add'], 'required', 'message' => 'Ruang ini adalah mandatori !'],
            [['file', 'file2'], 'required', 'message' => 'Muat Naik Dokumen!'],
            [['tarikh_pindah', 'entry_date', 'semakan_pt', 'ver_date', 'tarikh_hantar', 'app_date', 'bendahari_date'], 'safe'],
            [['jumlah_tuntutan', 'jumlah'], 'number'],
            [['dokumen_sokongan', 'dokumen_sokongan2'], 'string'],
            [['mohon', 'isActive2', 'status_semasa', 'entry_type'], 'integer'],
            [['icno', 'semakan_by', 'peraku_by', 'pelulus_by'], 'string', 'max' => 12],
            [['jeniskemudahan'], 'string', 'max' => 10],
            [['old_add', 'new_add'], 'string', 'max' => 200],
            [['resit', 'status_pt', 'status_pp', 'status_kj', 'stat_bendahari'], 'string', 'max' => 20],
            [['catatan_pt', 'catatan_pp', 'catatan_kj', 'catatan_bendahari'], 'string', 'max' => 500],
            [['pengakuan'], 'string', 'max' => 30],
            [['file', 'file2'], 'file','extensions'=>'pdf','maxSize' => 5000000], 
            [['file', 'file2'],'safe'], 
             
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
            'jeniskemudahan' => 'Jeniskemudahan',
            'tarikh_pindah' => 'Tarikh Pindah',
            'old_add' => 'Old Add',
            'new_add' => 'New Add',
            'jumlah_tuntutan' => 'Jumlah Tuntutan',
            'resit' => 'Resit',
            'entry_date' => 'Entry Date',
            'status_pt' => 'Status Pt',
            'catatan_pt' => 'Catatan Pt',
            'semakan_pt' => 'Semakan Pt',
            'status_pp' => 'Status Pp',
            'catatan_pp' => 'Catatan Pp',
            'stat_bendahari' => 'Status Bendahari',
            'catatan_bendahari' => 'Catatan Bendahari',
            'ver_date' => 'Ver Date',
            'tarikh_hantar' => 'Tarikh Hantar',
            'bendahari_date' => 'Tarikh Bendahari',
            'status_kj' => 'Status Kj',
            'catatan_kj' => 'Catatan Kj',
            'app_date' => 'App Date',
            'pengakuan' => '',
            'jumlah' => 'Jumlah',
            'dokumen_sokongan' => 'Dokumen Sokongan',
            'dokumen_sokongan2' => 'Dokumen Sokongan2',
            'mohon' => 'Mohon',
            'isActive2' => 'Is Active2',
            'file' => 'Dokumen Sokongan',
            'file2' => 'Dokumen Sokongan',
            'status_semasa' => 'status semasa',
            'semakan_by' => 'Semakan Oleh',
            'peraku_by' => 'Peraku Oleh',
            'pelulus_by' => 'Pelulus Oleh',
            'entry_type' => 'Jenis permohonan',

        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
     public function getAlamat(){
        return $this->hasOne(Tblalamat::className(), ['ICNO' => 'icno'])->where(['AddrTypeCd'=>'01']);
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
      public function getPegTadbir() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'semakan_by']);
    }
     public function getPegBsm() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'peraku_by']);
    }
     public function getKjBsm() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pelulus_by']);
    }
    
    public function getEntrydate() {
        if ($this->entry_date != '') {
            return $this->getTarikh($this->entry_date);
        }
    }
     public function getMoveDate() {
        if ($this->entry_date != '') {
            return $this->getTarikh($this->tarikh_pindah);
        }
    }
    public function getDisplayjenis() {
        return $this->hasOne(Refjeniskemudahan::className(), ['kemudahancd' => 'jeniskemudahan']);
    } 
     public function getStatusLabel() {
        if ($this->status_pt == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->status_pt == 'DIPERAKUI') {
            return '<span class="label label-primary">DISEMAK</span>';
        }
        if ($this->status_pt == 'SEMAKAN LAYAK') {
            return '<span class="label label-success">BERJAYA </span>';
        }
        if ($this->status_pt == 'SEMAKAN TIDAK LAYAK') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }
    public function getStatuspp() {
        if ($this->status_pp == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->status_pp == 'MENUNGGU KELULUSAN') {
            return '<span class="label label-primary">Menunggu Tindakan Pegawai BSM </span>';
        }
        if ($this->status_pp == 'DIPERAKUI') {
            return '<span class="label label-success">BERJAYA</span>';
        }
        if ($this->status_pp == 'TIDAK DIPERAKUI') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
        if ($this->status_pp === NULL) {
            return '-';
        }

    }
    public function getStatuskj() {
        if ($this->status_kj == 'NEW') {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->status_kj == 'ENTRY') {
            return '<span class="label label-primary">Menunggu Tindakan Pegawai BSM</span>';
        }
        if ($this->status_kj == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-info">DALAM TINDAKAN KJ</span>';
        }
        if ($this->status_kj == 'DILULUSKAN') {
            return '<span class="label label-success">BERJAYA</span>';
        }
        if ($this->status_kj == 'TIDAK DILULUSKAN') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }
    public function getStatuss() {
        if ($this->status_pp == 'MENUNGGU KELULUSAN') {
            return '<span class="label label-primary">Menunggu Tindakan Pegawai BSM</span>';
        }
        
        if ($this->stat_bendahari == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-default">ARAHAN BAYARAN KEPADA BENDAHARI </span>';
        }
        if ($this->stat_bendahari == 'DALAM PROSES BAYARAN' || $this->stat_bendahari == 'MENUNGGU KELULUSAN') {
            return '<span class="label label-default">ARAHAN BAYARAN KEPADA BENDAHARI</span>';
        }
        if ($this->stat_bendahari == 'EFT') {
            return '<span class="label label-success">BERJAYA / EFT</span>';
        }
    }
    public function getStat_KJ() {
        if ($this->status_kj == 'NEW') {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->status_kj == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-info">DALAM TINDAKAN KJ</span>';
        }
          
        if ($this->status_kj == 'DILULUSKAN') {
            return '<span class="label label-default">ARAHAN BAYARAN KEPADA BENDAHARI</span>'; //senarai.php
        }
        if ($this->status_kj == 'EFT') {
            return '<span class="label label-success">EFT</span>';
        }
        if ($this->status_kj == 'TIDAK DILULUSKAN') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }
    public function getReviewdate() {
        if ($this->review_date != '') {
            return $this->getTarikh($this->review_date);
        }
    }
    public function getDate_pt() { 
            return $this->getTarikh($this->semakan_pt); 
    }
    public function getDate_pindah() { 
            return $this->getTarikh($this->tarikh_pindah); 
    }
    public function getVerdate() { 
            return $this->getTarikh($this->ver_date); 
    }
    public function getAppdate() { 
            return $this->getTarikh($this->app_date); 
    }
    public function getBendahariD() { 
            return $this->getTarikh($this->bendahari_date); 
    }
    public function perMonth($year,$mth) {
        
        return Borangperpindahan::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->count();
    }
    public function getTotalCount($year,$mth) {
        
        return Borangperpindahan::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->count();
    }
     public function getTotal($year,$mth) {
        
        return Borangperpindahan::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->sum('jumlah_tuntutan');
    }
}
