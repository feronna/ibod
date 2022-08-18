<?php

namespace app\models\ln;

use app\models\hronline\Tblprcobiodata;
use app\models\ln\TblSurat;
use app\models\ln\RefTravel;
/**
 * This is the model class for table "ln.tbl_ln".
 *
 * @property int $id
 * @property string $icno
 * @property string $tujuan
 * @property string $nama_tempat
 * @property string $negara
 * @property string $date_from
 * @property string $date_to
 * @property int $days
 * @property int $bil_peserta
 * @property string $perbelanjaan
 * @property string $entry_date
 * @property string $status
 * @property string $app_by
 * @property string $app_date
 * @property string $status_jfpiu
 * @property string $ulasan_jfpiu
 * @property string $ver_by
 * @property string $ver_date
 * @property string $status_semakan
 * @property string $ulasan_semakan
 */
class Ln extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public $file2;
    public $file3;
    public $file4;
    public static function tableName()
    {
//        return 'ln.tbl_ln';
        return 'hrm.ln_tbl_ln';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'nama_lawatan', 'faedah_lawatan', 'tujuan', 'nama_tempat', 'date_from', 'date_to', 'justifikasi', 'bil_peserta', 'kod_peruntukan', 'tambang' , 'elaun_makan', 'elaun_hotel', 'yuran', 'transport', 'dll'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['days', 'bil_peserta'], 'integer'],
            [['entry_date', 'app_date', 'ver_date', 'lulus_date', 'letter_date', 'start_aktiviti', 'end_aktiviti'], 'safe'],
            [['nama_lawatan', 'faedah_lawatan', 'tujuan_aktiviti','tujuan', 'nama_tempat', 'justifikasi', 'perbelanjaan', 'status', 'ulasan_jfpiu', 'ulasan_semakan', 'ulasan_nc', 'ulasan_admin', 'kod_peruntukan_cn'], 'string'],
            [['icno', 'app_by', 'ver_by', 'lulus_by'], 'string', 'max' => 15],
            [['date_from', 'date_to', 'status_jfpiu', 'status_semakan', 'status_nc'], 'string', 'max' => 20],
            [['tambang' , 'tambang2', 'elaun_makan', 'elaun_makan2', 'elaun_hotel', 'elaun_hotel2','yuran', 'yuran2','transport', 'transport2', 'dll', 'dll2', 'jumlah', 'jumlah2','jumlah3'], 'string', 'message' => 'Ruang ini mesti diisi dalam nombor sahaja'],
            [['terima'], 'string', 'max' => 10], 
            [['file'],'safe'],
            [['file'], 'file','extensions'=>'pdf', 'maxSize' => 5000000],
            [['file2'],'safe'],
            [['file2'], 'file','extensions'=>'pdf', 'maxSize' => 5000000],
            [['file3'],'safe'],
            [['file3'], 'file','extensions'=>'pdf', 'maxSize' => 5000000],
            [['file4'],'safe'],
            [['file4'], 'file','extensions'=>'pdf', 'maxSize' => 5000000], 
            [['dokumen_sokongan'], 'required', 'message' => 'Sila Lampirkan Dokumen Kertas Kerja'],
            [['dokumen_sokongan2'], 'required', 'message' => 'Sila Lampirkan Dokumen Surat Jemputan'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'ICNO',
            'tujuan' => 'Tujuan',
            'nama_tempat' => 'Nama Tempat',
            'negara' => 'Negara',
            'date_from' => 'Tarikh Dari',
            'date_to' => 'Tarikh Hingga',
            'days' => 'Hari',
            'bil_peserta' => 'Bil Peserta',
            'perbelanjaan' => 'Perbelanjaan',
            'entry_date' => 'Tarikh Mohon',
            'status' => 'Status Permohonan',
            'app_by' => 'Diperakui Oleh',
            'app_date' => 'Tarikh Diperakui',
            'status_jfpiu' => 'Status KJ',
            'ulasan_jfpiu' => 'Ulasan KJ',
            'ver_by' => 'Disemak Oleh',
            'ver_date' => 'Tarikh Disemak',
            'status_semakan' => 'Status Canselori',
            'ulasan_semakan' => 'Ulasan Canselori',
            'status_nc' => 'Status NC',
            'ulasan_nc' => 'Ulasan NC',
            'ulasan_admin' => 'Ulasan Admin',
            'lulus_by' => 'Diluluskan Oleh',
            'lulus_date' => 'Tarikh Diluluskan',
            'letter_date' => 'Tarikh Surat',
            'tambang' => 'Tambang',
            'elaun_makan' => 'Elaun Makan',
            'elaun_hotel' => 'Elaun Hotel',
            'yuran' => 'Yuran',
            'transport' => 'Transport',
            'dll' => 'Lain Lain',
            'jumlah' => 'Jumlah',
            'dokumen_sokongan1' => 'Dokumen Kertas Kerja',
            'dokumen_sokongan2' => 'Dokumen Surat Jemputan',
            'dokumen_sokongan3' => 'Dokumen Sokongan',
            'lampiran_a' => 'Lampiran A',
            'kod_peruntukan' => 'Kod Peruntukan',
            'kod_peruntukan_cn' => 'Kod Peruntukan Canselori',
            'terima' => 'Terima',
            'tujuan_aktiviti' => 'Tujuan Aktiviti',
            'start_aktiviti' => 'Tarikh Mula Aktiviti',
            'end_aktiviti' => 'Tarikh Tamat Aktiviti',
        ];
    }
            
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
        public function getKakitangan2() {
        return $this->hasOne(Ln2::className(), ['parent_id' => 'id']);
    }
    
//        public function getKakitangan2() {
//        return $this->hasOne(\app\models\hronline\Tblrscoadminpost::className(), ['ICNO' => 'icno']);
//    }
    
    public function getStatusjfpiu() {
        if ($this->status_jfpiu == 'Tunggu Perakuan') {
            return '<span class="label label-warning">Menunggu</span>';
        }
        if ($this->status_jfpiu == 'Diperakui') {
            return '<span class="label label-success">Diperakui</span>';
        }
        if ($this->status_jfpiu == 'Tidak Diperakui') {
            return '<span class="label label-danger">Tidak Diperakui</span>';
        }
         if ($this->status_jfpiu == '-') {
            return '-';
        }
    }   
    
     public function getStatussemakan() {
        if ($this->status_semakan == 'Tunggu Semakan'){
            return '<span class="label label-warning">Menunggu</span>';
        }
        if ($this->status_semakan == 'Diperakui') {
            return '<span class="label label-success">Diperakui</span>';
        }
        if ($this->status_semakan == 'Tidak Diperakui') {
            return '<span class="label label-danger">Tidak Diperakui</span>';
        }
         if ($this->status_semakan === '-') {
            return '-';
        }
    }
    
     public function getStatusnc() {
        if ($this->status_nc == 'Tunggu Kelulusan'){
            return '<span class="label label-warning">Menunggu</span>';
        }
        if ($this->status_nc == 'Diluluskan') {
            return '<span class="label label-success">Diluluskan</span>';
        }
        if ($this->status_nc == 'Tidak Diluluskan') {
            return '<span class="label label-danger">Tidak Diluluskan</span>';
        }
         if ($this->status_nc == '-') {
            return '-';
        }
    }
    
         public function getStatussurat() {
        if ($this->status_surat == 0 || $this->status_surat == 3 || $this->status_surat == 4 || $this->status_surat == ''){
            return '<span class="label label-warning">Menunggu</span>';
        }
        if ($this->status_surat == 1) {
            return '<span class="label label-success">Surat Dihantar</span>';
        }
        if (($this->status_surat = 2) && ($this->status_jfpiu = 'Tidak Diperakui') || ($this->status_semakan = '-') || ($this->status_nc = '-')) {
            return '<span class="label label-success">Surat Tidak Dihantar</span>';
        }
        if ($this->status_surat == 2) {
            return '<span class="label label-success">Surat Dihantar</span>';
        }
        if ($this->status_surat === NULL) {
            return '-';
        }
    }
    
    public function getStatussuratt() {
        if ($this->status_surat == 0 || $this->status_surat == 3 || $this->status_surat == 4 || $this->status_surat == ''){
            return 'Menunggu';
        }
        if ($this->status_surat == 1) {
            return 'Surat Dihantar';
        }
         if ($this->status_surat == 2) {
            return 'Surat Dihantar';
        }
         if ($this->status_surat === NULL) {
            return '-';
        }
    }
      
    public function getStatuss() {
       
        if ($this->status == 'DALAM TINDAKAN KETUA JABATAN') {
            return '<span class="label label-info">Dalam Tindakan KJ</span>';
        }
        if ($this->status == 'DALAM TINDAKAN CANSELORI') {
            return '<span class="label label-primary">Dalam Tindakan CANSELORI</span>';
        }
        if ($this->status == 'DALAM TINDAKAN NC') {
            return '<span class="label label-warning">Dalam Tindakan NC</span>';
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
    
     public function getStatusss() {
       
        if ($this->status == 'DALAM TINDAKAN KETUA JABATAN') {
            return '<span class="label label-info">Dalam Tindakan KJ</span>';
        }
        if ($this->status == 'DALAM TINDAKAN CANSELORI') {
            return '<span class="label label-primary">Dalam Tindakan CANSELORI</span>';
        }
        if ($this->status == 'DALAM TINDAKAN NC') {
            return '<span class="label label-warning">Dalam Tindakan NC</span>';
        }
        if ($this->status == 'MENUNGGU') {
            return '<span class="label label-warning">Menunggu</span>';
        }
        if ($this->status == 'LULUS') {
            return '<span class="label label-success">Diluluskan</span>';
        }
        
        if (($this->status = 'TIDAK LULUS') && ($this->status_jfpiu = 'Tidak Diperakui')) {
            return '<span class="label label-danger">Tidak Diluluskan</span>';
        }
        
        if ($this->status == 'TIDAK LULUS') {
            return '<span class="label label-danger">Tidak Diluluskan</span>';
        }
        
        if ($this->status == '') {
            return '-';
        }
    }
    
    public function getStatuslampirana() {
       
        if ($this->lampiran == '0') {
            return '<span class="label label-warning">Lampiran A Belum Dihantar</span>';
        }
        if ($this->lampiran == '1') {
            return '<span class="label label-success">Selesai</span>';
        }
        
        if ($this->lampiran == '') {
            return '-';
        }
    }
    
    public function getStatusln2() {
       
        if ($this->hantar == '0') {
            return '<span class="label label-warning">Laporan Belum Dihantar</span>';
        }
        if ($this->hantar == '1') {
            return '<span class="label label-success">Selesai</span>';
        }
        
        if ($this->hantar == '') {
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
        return $this->getTarikh($this->entry_date);}
    }
    
    public function getDatefrom() {
         if($this->date_from!=''){
         return  $this->getTarikh($this->date_from);}
         else { return '-';}
    }
    public function getStartA() {
        if($this->start_aktiviti!=''){
        return  $this->getTarikh($this->start_aktiviti);}
        else { return '-';}
   }
    
   public function getEndA() {
    if($this->end_aktiviti!=''){
    return  $this->getTarikh($this->end_aktiviti);}
    else { return '-';}
}
    public function getDateto() {
        return  $this->getTarikh($this->date_to);
    }
    
    public function getLulusdate() {
        return  $this->getTarikh($this->lulus_date);
    }
    
    public function getAppdate() {
        return  $this->getTarikhh($this->app_date);
    }
    
        public function getAppdatee() {
        return  $this->getTarikh($this->app_date);
    }
    
        public function getVerdate() {
        return  $this->getTarikhh($this->ver_date);
    }
    
    public function getVerdatee() {
        return  $this->getTarikh($this->ver_date);
    }
    
     public function getLulussdate() {
        return  $this->getTarikhh($this->lulus_date);
    }
    
    public function getLetterdate() {
        return  $this->getTarikhh($this->letter_date);
    }
    
    public static function totalPending($icno) {

        $total = 0;      
        $model = Ln::find()->where(['app_by' => $icno, 'status' => 'DALAM TINDAKAN KETUA JABATAN'])->all();
        if ($model) {
            $total = count($model);
        }
         else{
            $total = count($model = Ln::find()->where(['app_by' => $icno, 'status' => 'DALAM TINDAKAN KETUA JABATAN'])->all());
        }
        if ($total > 0) {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        else {
                return '';
        }
    }

    public static function totalPending2($icno) {

        $total = 0;      
        //$model = Ln::find()->where(['ver_by' => $icno, 'status_bsm' => 'Tunggu Kelulusan'])->all();
        $model = Ln::find()->where(['ver_by' => $icno, 'status' => 'DALAM TINDAKAN CANSELORI'])->all();
        if ($model) {
            $total = count($model);
        }
         else{
            //$total = count($model = Ln::find()->where(['ver_by' => $icno, 'status_bsm' => 'Tunggu Kelulusan'])->all());
             $total = count($model = Ln::find()->where(['ver_by' => $icno, 'status' => 'DALAM TINDAKAN CANSELORI'])->all());
        }
        if ($total > 0) {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        else {
                return '';
        }
    }
   
    public static function totalPending3($icno) {

        $total = 0;      
        $model = Ln::find()->where(['lulus_by' => $icno, 'status' => 'DALAM TINDAKAN NC'])->all();
        if ($model) {
            $total = count($model);
        }
         else{
            $total = count($model = Ln::find()->where(['lulus_by' => $icno, 'status' => 'DALAM TINDAKAN NC'])->all());
        }
        if ($total > 0) {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        else {
                return '';
        }
    }
    
    public static function totalPendingtask($icno) {

        $total = 0;
        $model = Ln::find()->where(['app_by' => $icno, 'status' => 'DALAM TINDAKAN KETUA JABATAN'])->all();
        if ($model) {
            $total = count($model);
        }
        return $total;
    } 
    
    public static function totalPendingtask2($icno) {

        $total = 0;
        $model = Ln::find()->where(['ver_by' => $icno, 'status' => 'DALAM TINDAKAN CANSELORI'])->all();
        if ($model) {
            $total = count($model);
        }
        return $total;
    } 

    public static function totalPendingtask3($icno) {

        $total = 0;
        $model = Ln::find()->where(['lulus_by' => $icno, 'status' => 'DALAM TINDAKAN NC'])->all();
        if ($model) {
            $total = count($model);
        }
        return $total;
    }
    
    public static function totalPendingtask4($icno) {

        $total = 0;
        if(($icno == "840707125192") || ($icno == "901123125742") || ($icno == "841222125252"))
        {
            $total = count($model = Ln::find()->where(['status' => 'MENUNGGU'])->all());
        }
        return $total;

    } 
    
    public function getLetter(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
    public function getTarikhMesyuarat() {
        return  $this->getTarikh($this->tarikh_mesyuarat);
    }  
    
    public function getBaki() {
        $query = Ln::find()->where(['icno'=>$this->icno])->sum('jumlah');
        $query2 = Ln::find()->where(['icno'=>$this->icno])->sum('jumlah2');
        
        return $query - $query2;
    }
    
    public function getDokumen(){
        return $this->hasOne(TblSurat::className(), ['ln_id' => 'id']);
    }
    
    public function perMonth($year,$month) {
        return Ln::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $month])->andWhere(['mohon' => 0, 'status_surat' => [1,2,3]])->count();
    }
    
    public function perMonth2($year,$month) {
        return Ln::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $month])->andWhere(['hantar' => [1]])->count();
    }
    
    public function perMonthLampiran($year,$month) {
        return Ln::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $month])->andWhere(['lampiran' => [0,1]])->count();
    }

    public function getTravel() {
        return $this->hasOne(RefTravel::className(), ['icno' => 'icno']);
    }
    public function getTotalCount($year) {
        
        return ln::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 0, 'status_surat' => [1,2,3]])->count();
    }
    public function getTotalCount2($year) {
        
        return Ln::find()->where(['YEAR(entry_date)' => $year])->andWhere(['hantar' => [1]])->count();
    }
    public function getTotalCountLampiran($year) {
        
        return ln::find()->where(['YEAR(entry_date)' => $year])->andWhere(['lampiran' => [0,1]])->count();
    }
}
