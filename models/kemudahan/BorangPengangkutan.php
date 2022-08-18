<?php

namespace app\models\kemudahan;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "facility.tbl_pengangkutan".
 *
 * @property int $id
 * @property string $icno
 * @property int $jeniskemudahan
 * @property string $dest_berlepas dari bandar
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
class BorangPengangkutan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public static function tableName()
    {
        return 'utilities.fac_tbl_pengangkutan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dest_berlepas', 'dest_tiba'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['jeniskemudahan', 'mohon', 'isActive', 'status_semasa', 'entry_type'], 'integer'],
            [['entry_date', 'semakan_pt', 'ver_date', 'tarikh_hantar', 'app_date', 'bendahari_date'], 'safe'],
            [['dokumen_sokongan', 'dokumen_sokongan2'], 'string'],
            [['icno', 'semakan_by', 'peraku_by', 'pelulus_by'], 'string', 'max' => 12],
            [['dest_berlepas', 'dest_tiba'], 'string', 'max' => 100],
            [['status_pt', 'status_pp', 'status_kj', 'stat_bendahari'], 'string', 'max' => 20],
            [['catatan_pt', 'catatan_pp', 'catatan_kj', 'catatan_bendahari'], 'string', 'max' => 500],
            [['pengakuan'], 'string', 'max' => 30],
            [['file'], 'file','extensions'=>'pdf','maxSize' => 5000000], 
            [['file'],'safe'],
            [['dokumen_sokongan'], 'required', 'message' => 'Muat Naik Dokumen Sokongan!'],
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
            'dest_berlepas' => 'Dest Berlepas',
            'dest_tiba' => 'Dest Tiba',
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
            'pengakuan' => '',
            'mohon' => 'Mohon',
            'isActive' => 'Is Active',
            'dokumen_sokongan' => 'Dokumen Sokongan',
            'dokumen_sokongan2' => 'Dokumen Sokongan2',
            'status_semasa' => 'Status Semasa',
            'semakan_by' => 'Semakan Oleh',
            'peraku_by' => 'Peraku Oleh',
            'pelulus_by' => 'Pelulus Oleh',
            'entry_type' => 'Jenis permohonan',

        ];
    }
    
     public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
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
     public function perMonth($year,$mth) {
        
        return BorangPengangkutan::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->count();
    }
     public function getTotalCount($year,$mth) {
        
        return BorangPengangkutan::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->count();
    }
    public function getTotal($year,$mth) {
        
        return BorangPengangkutan::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1]);
    }
    public function getPenumpang() {
        return $this->hasOne(Refpenumpang::className(), ['parent_id' => 'id']);
    }
}
