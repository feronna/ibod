<?php

namespace app\models\kemudahan;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\HubunganKeluarga;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Kampus;
use app\models\kemudahan\Refkadartanggungan;

use Yii;

/**
 * This is the model class for table "facility.tbl_wilayah".
 *
 * @property int $id
 * @property string $icno
 * @property int $jeniskemudahan
 * @property string $wilayah_asal
 * @property string $dest_berlepas dari bandar
 * @property string $tarikh_terakhir
 * @property string $tarikh_digunankan
 * @property string $dest_tiba ke bandar
 * @property string $entry_date tarikh permohonan dibuat
 * @property string $status_pt
 * @property string $catatan_pt
 * @property string $semakan_pt tarikh semakan dibuat oleh pt
 * @property string $status_pp
 * @property string $catatan_pp
 * @property string $ver_date tarikh perakuan pegawai dibuat
 * @property string $tarikh_hantar tarikh permohonan disahkan lulus
 * @property string $status_kj
 * @property string $catatan_kj
 * @property string $app_date tarikh permohonan diluluskan olh KJ
 * @property string $stat_bendahari
 * @property string $catatan_bendahari
 * @property string $bendahari_date tarikh tindakan diambil olh bendahari
 * @property string $pengakuan
 * @property int $mohon
 * @property int $isActive status permohonan
 * @property string $dokumen_sokongan
 * @property string $dokumen_sokongan2
 * @property int $status_semasa 0 = inprogress 1 = complete
 */
class Borangwilayah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public $file2;
    public static function tableName()
    {
        return 'utilities.fac_tbl_wilayah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh_digunakan'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['tujuan'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['jeniskemudahan', 'mohon', 'isActive', 'status_semasa','entry_type', 'letter_type'], 'integer'],
            [['tarikh_terakhir', 'tarikh_digunakan', 'entry_date', 'semakan_pt', 'ver_date', 'tarikh_hantar', 'app_date', 'bendahari_date', 'dt_confrm', 'email_send'], 'safe'],
            [['dokumen_sokongan', 'dokumen_sokongan2'], 'string'],
            [['icno', 'semakan_by', 'peraku_by', 'pelulus_by', 'book_by'], 'string', 'max' => 12],
            [['jumlah'], 'number'],
            [['wilayah_asal'], 'string', 'max' => 255], 
            [['status_pt', 'status_pp', 'status_kj', 'stat_bendahari', 'status_tempahan'], 'string', 'max' => 20],
            [['catatan_pt', 'catatan_pp', 'catatan_kj', 'catatan_bendahari', 'nama', 'tanggungan', 'tujuan'], 'string', 'max' => 500],
            [['pengakuan'], 'string', 'max' => 30],
            [['file', 'file2'], 'file','extensions'=>'pdf','maxSize' => 5000000], 
            [['file', 'file2'],'safe'], 
//            [['dokumen_sokongan'], 'required', 'message' => 'Muat Naik Dokumen!'],
            [['dokumen_sokongan2'], 'required', 'message' => 'Muat Naik Dokumen!'],
            
             
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'icno' => 'Icno',
            'jeniskemudahan' => 'Jeniskemudahan',
            'wilayah_asal' => 'Wilayah Asal', 
            'tarikh_terakhir' => 'Tarikh Terakhir',
            'tarikh_digunakan' => 'Tarikh Digunankan', 
            'entry_date' => 'Entry Date',
            'status_pt' => 'Status Pt',
            'catatan_pt' => 'Catatan Pt',
            'semakan_pt' => 'Semakan Pt',
            'status_pp' => 'Status Pp',
            'catatan_pp' => 'Catatan Pp',
            'ver_date' => 'Ver Date',
            'tarikh_hantar' => 'Tarikh Hantar',
            'status_kj' => 'Status Kj',
            'catatan_kj' => 'Catatan Kj',
            'app_date' => 'App Date',
            'stat_bendahari' => 'Stat Bendahari',
            'catatan_bendahari' => 'Catatan Bendahari',
            'bendahari_date' => 'Bendahari Date',
            'pengakuan' => 'Pengakuan',
            'mohon' => 'Mohon',
            'isActive' => 'Is Active',
            'file' => 'Dokumen Sokongan',
            'file' => 'Dokumen Sokongan',
            'status_semasa' => 'Status Semasa',
            'semakan_by' => 'Semakan Oleh',
            'peraku_by' => 'Peraku Oleh',
            'pelulus_by' => 'Pelulus Oleh',
            'entry_type' => 'Jenis permohonan',
            'jumlah' => 'Jumlah',
            'tanggungan' => 'Tanggungan',
            'tujuan' => 'Tujuan',
            'email_send' => 'Email Send',
            'dt_confrm' => 'Tarikh kemaskini',
            'book_by' => 'Book By',
            'status_tempahan' => 'Status Tempahan', 
            'letter_type' => 'letter_type',

        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
     public function getStaffName() {
        return $this->hasOne(Tblprcobiodata::className(), ['CONm' => 'nama']);
    }
    
    public function getKeluarga() {
        return $this->hasOne(Tblkeluarga::className(), ['ICNO' => 'icno']);
    }
    
     public function getDisplayjenis() {
        return $this->hasOne(Refjeniskemudahan::className(), ['kemudahancd' => 'jeniskemudahan']);
    } 
    
     public function getDisplayakaun() {
        return $this->hasOne(Refakaun::className(), ['akauncd' => 'kodAkaun']);
    }
    
      public function getDisplay() {
        return $this->hasOne(Kemudahan::className(), ['jeniskemudahan' => 'jeniskemudahan']);
    }
//     public function getAge() {
//         
//        return $this->hasMany(Tblprcobiodata::className(), ['ICNO' => 'icno']);
//    }
      public function getPegTadbir() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'semakan_by']);
    }
     public function getPegBsm() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'peraku_by']);
    }
     public function getKjBsm() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pelulus_by']);
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
    
     public function getEntrydate() { 
            return $this->getTarikh($this->entry_date); 
    }
    public function getDate_pt() { 
            return $this->getTarikh($this->semakan_pt); 
    }
    public function getUsed() { 
            return $this->getTarikh($this->used_dt); 
    }
     public function getVerdate() { 
            return $this->getTarikh($this->ver_date); 
    }
    public function getAppdate() { 
            return $this->getTarikh($this->app_date); 
    }
    public function getLastdt() { 
          if ($this->tarikh_terakhir != '') {
            return $this->getTarikh($this->tarikh_terakhir);
        }
           
    }
      public function getEmaildt() { 
          if ($this->email_send != '') {
            return $this->getTarikh($this->email_send);
        }
           
    }
    public function getUseddt() { 
         if ($this->tarikh_digunakan != '') {
            return $this->getTarikh($this->tarikh_digunakan);
        }
//            return $this->getTarikh($this->tarikh_digunakan); 
    }
    
     public function getStatusLabel() {
        if ($this->status_pt == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->status_pt == 'DIPERAKUKAN' && $this->status_pp == 'DIPERAKUI') {
            return '<span class="label label-primary">DISEMAK</span>';
        }
        if ($this->status_pt == 'SEMAKAN LAYAK' || $this->status_pt == 'LAYAK') {
            return '<span class="label label-success">BERJAYA </span>';
        }
        if ($this->status_pt == 'SEMAKAN TIDAK LAYAK' || $this->status_pt == 'TIDAK LAYAK') {
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
        if ($this->status_pp == 'DIPERAKUKAN' || $this->status_pp == 'DIPERAKUI') {
            return '<span class="label label-success">BERJAYA</span>';
        }
       
        if ($this->status_pp == 'TIDAK DIPERAKUKAN' || $this->status_pp == 'TIDAK DIPERAKUI') {
            return '<span class="label label-danger">DITOLAK</span>';
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
//        if ($this->stat_bendahari == 'MENUNGGU TINDAKAN') {
//            return '<span class="label label-default">ARAHAN BAYARAN KEPADA BENDAHARI </span>';
//        }
         if ($this->stat_bendahari == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-default">ARAHAN PEMBELIAN TIKET </span>';
        }
        if ($this->stat_bendahari == 'DALAM PROSES BAYARAN' || $this->stat_bendahari == 'MENUNGGU KELULUSAN') {
            return '<span class="label label-success">PEMBELIAN TIKET SELESAI</span>';
        }
        
        if ($this->stat_bendahari == 'EFT') {
            return '<span class="label label-success">BERJAYA / EFT</span>';
        }
    }
    
     public function perMonth($year,$mth) {
        
        return Borangwilayah::find()->where(['YEAR(tarikh_digunakan)' => $year])->andWhere(['MONTH(tarikh_digunakan)' => $mth])->andWhere(['isActive' => 1, 'status_tempahan' => 'TELAH DITEMPAH'])->count();
    }
     public function getTotalCount($year,$mth) {
        
        return Borangwilayah::find()->where(['YEAR(tarikh_digunakan)' => $year])->andWhere(['isActive' => 1, 'status_tempahan' => 'TELAH DITEMPAH'])->count();
    }
    public function getTotal($year,$mth) {
        
        return Borangwilayah::find()->where(['YEAR(tarikh_digunakan)' => $year])->andWhere(['MONTH(tarikh_digunakan)' => $mth])->andWhere(['isActive' => 1, 'status_tempahan' => 'TELAH DITEMPAH'])->sum('jumlah');
    }
     public function getTotalYear($year) {
        
        return Borangwilayah::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->sum('jumlah');
    }
    public function getHubunganKeluarga() {
         
        return $this->hasMany(HubunganKeluarga::className(), ['RelCd' => 'RelCd']);
    }
     public function getHubkeluarga() {
        if ($this->hubunganKeluarga) {
            return $this->hubunganKeluarga->RelNm;
        }
        return '-';
    } 
    public function getTempahan() {
        if ($this->status_tempahan == 'TELAH DITEMPAH') {
            return '<span class="label label-success">TELAH DITEMPAH</span>';
        }
         if ($this->status_tempahan == '') {
//           return '<span class="label label-warning">BARU</span>'; 
        }
         if ($this->status_tempahan == 'NEW') {
           return '<span class="label label-default">PROSES PEMBELIAN TIKET</span>'; 
        }
        
    }
     public function getStat_KJ() {
        if ($this->status_kj == 'NEW' ) {
            return '<span class="label label-warning">BARU</span>';
        }
         if ($this->status_kj == 'ENTRY') { //1
            return '<span class="label label-info">DALAM TINDAKAN KJ</span>';
        }
        if ($this->status_pp == 'MENUNGGU TINDAKAN') {//2
            return '<span class="label label-primary">Menunggu Tindakan</span>';
        }
        if ($this->status_pp == 'DILULUSKAN' && $this->isActive != '1' ) { //3
           return '<span class="label label-primary">Menunggu Tindakan</span>'; //senarai.php
        }
         if ($this->status_pp == 'DILULUSKAN' || $this->isActive == '1') {//4
            return '<span class="label label-default">PEMBELIAN TIKET DALAM PROSES</span>'; //senarai.php
        }
        if ($this->status_kj == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-info">DALAM TINDAKAN KJ</span>';
        }
        if ($this->status_kj == 'DILULUSKAN' && $this->isActive != '1') {
            return '<span class="label label-info">DALAM TINDAKAN KJ</span>';
        }
          
        if ($this->status_kj == 'DILULUSKAN' || $this->isActive == '1') {
            return '<span class="label label-default">ARAHAN BAYARAN KEPADA BENDAHARI</span>'; //senarai.php
        }
        if ($this->status_kj == 'EFT') {
            return '<span class="label label-success">EFT</span>';
        }
        if ($this->status_kj == 'TIDAK DILULUSKAN') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
         if ($this->status_pp == 'TIDAK DILULUSKAN') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
         if ($this->status_pp == 'TIDAK LENGKAP') {
            return '<span class="label label-danger">DITOLAK</span>';
        } 
    }
 
     public function getKadar() {
        return $this->hasOne(Refkadartanggungan::className(), ['icno' => 'icno']);
    } 
      public function getPenerbangan() {
        return $this->hasOne(Refjadualpenerbangan::className(), ['parent_id' => 'id']);
    } 
    
     public static function totalPendingTask($icno) {
         

        $total = 0;
 
            $total = count($model = Borangwilayah::find()->where(['semakan_by' => $icno, 'status_pt' => 'MENUNGGU TINDAKAN'])->all());
 
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
     }
    public static function totalPendingVerified($icno) {
         

        $total = 0;
 
            $total = count($model = Borangwilayah::find()->where(['peraku_by' => $icno, 'status_pp' => 'MENUNGGU KELULUSAN'])->all());
 
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
    }
    public static function totalPendingApproval($icno) {
         

        $total = 0;
 
            $total = count($model = Borangwilayah::find()->where(['pelulus_by' => $icno, 'status_kj' => 'MENUNGGU TINDAKAN'])->all());
 
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
    }
    public static function totalPendingConfirmation($icno) {
         

        $total = 0;
 
            $total = count($model = Borangwilayah::find()->where(['peraku_by' => $icno, 'status_pp' => 'DIPERAKUKAN'])->andwhere(['isActive' => 2])->all());
 
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
    }
     public static function totalPendingFlight($icno) {
         

        $total = 0;
 
            $total = count($model = Borangwilayah::find()->where(['book_by' => $icno, 'status_tempahan' => 'NEW'])->andwhere(['isActive' => 1])->all());
 
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
    }
    
}
