<?php
namespace app\models\Kemudahan;
use app\models\hronline\Tblprcobiodata;
use app\models\Kemudahan\Kemudahan;
use app\models\hronline\GredJawatan;
use app\models\Kemudahan\Borangehsan;
use app\models\Kemudahan\Borang;
use app\models\Kemudahan\Reftujuanelaun;

use Yii;
/**
 * This is the model class for table "onapp.tbl_mohonkemudahan".
 *
 * @property int $id
 * @property string $icno
 * @property string $dept
 * @property string $unit
 * @property string $gred_jawatan
 * @property string $butiran
 * @property string $nama_tempat
 * @property string $negara
 * @property string $date_from
 * @property string $date_to
 * @property int $days
 * @property string $entry_date
 * @property string $status
 * @property string $catatan
 * @property string $status_pp
 * @property string $catatan_pp
 * @property string $status_kj
 * @property string $catatan_kj
 * @property string $implikasi
 * @property string $upload
 */
class Borang extends \yii\db\ActiveRecord {
    // add the function below:
//    public static function getDb() {
//        return Yii::$app->get('db7'); // second database
//    }
    /**
     * {@inheritdoc}
     */
    public $file;
    public $file2;
    public static function tableName() {
        return 'utilities.fac_tbl_elaun';
    }
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['butiran','tujuan', 'nama_tempat', 'negara', 'date_from', 'date_to', 'days'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['mohon', 'entry_type', 'pengakuan'], 'integer'],
            [['entry_date', 'ver_date', 'app_date', 'review_date', 'bendahari_date', 'send_date'], 'safe'],
            [['icno', 'app_by', 'ver_by', 'semakan_by', 'peraku_by', 'pelulus_by'], 'string', 'max' => 12],
            [['butiran', 'negara', 'catatan', 'catatan_pp', 'catatan_kj', 'catatan_bendahari'], 'string', 'max' => 50],
            [['date_from', 'date_to', 'status', 'status_pp', 'status_kj', 'stat_bendahari', 'status_semasa', 'days'], 'string', 'max' => 20],
            [['implikasi'], 'string', 'max' => 30],
            [['tujuan', 'nama_tempat'], 'string', 'max' => 300],
            [['jeniskemudahan'], 'string', 'max' => 50],
            [['jumlah'], 'string', 'max' => 100], 
            [['file', 'file2'], 'file','extensions'=>'pdf','maxSize' => 5000000], 
            [['file', 'file2'],'safe'], 
           
          
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'jeniskemudahan' => 'Jeniskemudahan',
            'butiran' => 'Butiran',
            'tujuan' => 'Tujuan',
            'nama_tempat' => 'Nama Tempat',
            'negara' => 'Negara',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'days' => 'Days',
            'entry_date' => 'Entry Date',
            'ver_date' => 'Verified Date',
            'app_date' => 'Approved Date',
            'review_date' => 'Review Date',
            'bendahari_date' => 'Bendahari Date',
            'send_date' => 'Tarikh Dihantar',
            'status' => 'Status Penyelia',
            'catatan' => 'Catatan',
            'status_pp' => 'Status Pp',
            'catatan_pp' => 'Catatan Pp',
            'status_kj' => 'Status Kj',
            'catatan_kj' => 'Catatan Kj',
            'app_by' => 'Diluluskan oleh',
            'ver_by' => 'Disahkan oleh',
            'implikasi' => 'Implikasi',
            'jumlah' => 'jumlah',
            'mohon' => 'mohon',
            'file' => 'Dokumen LN1',
            'file' => 'Dokumen Kelulusan',
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
     public function getPegTadbir() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'semakan_by']);
    }
     public function getPegBsm() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'peraku_by']);
    }
     public function getKjBsm() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pelulus_by']);
    }
     public function getIhsan() {
        return $this->hasOne(Borangehsan::className(), ['icno' => 'icno']);
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
    public function getStatusLabel() {
        if ($this->status == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->status == 'DIPERAKUI' || $this->status == 'DIPERAKUKAN') {
            return '<span class="label label-primary">DISEMAK</span>';
        }
        if ($this->status == 'SEMAKAN LAYAK' || $this->status == 'LAYAK') {
            return '<span class="label label-success">BERJAYA </span>';
        }
        if ($this->status == 'SEMAKAN TIDAK LAYAK' || $this->status == 'TIDAK LAYAK') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }
    public function getStatuspp() {
        if ($this->status_pp == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->status_pp == 'MENUNGGU KELULUSAN') {
            return '<span class="label label-primary">Menunggu Tindakan Pegawai BSM</span>';
        }
        if ($this->status_pp == 'DIPERAKUI' || $this->status_pp == 'DIPERAKUKAN') {
            return '<span class="label label-success">BERJAYA</span>';
        }
        if ($this->status_pp == 'TIDAK DIPERAKUI' || $this->status_pp == 'TIDAK DIPERAKUKAN') {
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
            return '<span class="label label-primary">Menunggu Tindakan</span>';
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
            return '<span class="label label-primary">Menunggu Tindakan Pegawai BSM  </span>';
        } 
        // if ($this->stat_bendahari == 'MENUNGGU TINDAKAN') {
        //     return '<span class="label label-default">ARAHAN BAYARAN KEPADA BENDAHARI </span>';
        // }
        // if ($this->stat_bendahari == 'MENUNGGU KELULUSAN') {
        //     return '<span class="label label-default">ARAHAN BAYARAN KEPADA BENDAHARI</span>';
        // }
        if ($this->stat_bendahari == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-default">NOTIFIKASI KEPADA PEMOHON </span>';
        }
        if ($this->stat_bendahari == 'MENUNGGU KELULUSAN') {
            return '<span class="label label-default">NOTIFIKASI KEPADA PEMOHON</span>';
        }
        if ($this->stat_bendahari == 'EFT') {
            return '<span class="label label-success">BERJAYA / EFT</span>';
        }
        if ($this->status_pp == 'TIDAK LENGKAP') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
         
         
    }
    public function getStat_Uniform() {
        if ($this->status_pp == 'DILULUSKAN') {
            return '<span class="label label-success">BERJAYA </span>';
        } 
       
        if ($this->status_pp == 'TIDAK LENGKAP') {
            return '<span class="label label-danger">DITOLAK</span>';
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
        if ($this->status_pp == 'DILULUSKAN' && $this->isActive2 != '1' ) { //3
           return '<span class="label label-primary">Menunggu Tindakan</span>'; //senarai.php
        }
         if ($this->status_pp == 'DILULUSKAN' || $this->isActive2 == '1') {//4
            return '<span class="label label-success">BERJAYA</span>'; //senarai.php
        }
        if ($this->status_kj == 'MENUNGGU TINDAKAN') {
            return '<span class="label label-info">DALAM TINDAKAN KJ</span>';
        }
        if ($this->status_kj == 'DILULUSKAN' && $this->isActive2 != '1') {
            return '<span class="label label-info">DALAM TINDAKAN KJ</span>';
        }
          
        if ($this->status_kj == 'DILULUSKAN' || $this->isActive2 == '1') {
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
        if ($this->entry_date != '') {
            return $this->getTarikh($this->entry_date);
        }
    }
    public function getDatefrom() {
        if ($this->date_from != '') {
            return $this->getTarikh($this->date_from);
        }
    }
    public function getDateTo() {
        if ($this->date_to != '') {
            return $this->getTarikh($this->date_to);
        }
    }
    public function getAppdate() {
        if ($this->app_date != '') {
            return $this->getTarikh($this->app_date);
        }
    }
     public function getReviewdate() {
        if ($this->review_date != '') {
            return $this->getTarikh($this->review_date);
        }
    }
    public function getVerdate() {
        if ($this->ver_date != '') {
            return $this->getTarikh($this->ver_date);
        }
    }
    public function getBendahariD() {
        if ($this->bendahari_date != '') {
            return $this->getTarikh($this->bendahari_date);
        }
    }
    public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => $this->kakitangan->gredJawatan]);
    }
    public function perMonth($year,$mth) {
        
        return Borang::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->count();
    }
    public function getTotal($year,$mth) {
        
        return Borang::find()->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->sum('jumlah');
    }
     public function getTotalYear($year) {
        
        return Borang::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->sum('jumlah');
    }
    public function getTotalCount($year,$mth) {
        
        return Borang::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->count();
    }
   
    public static function totalPendingTask($icno) {
         

        $total = 0;
 
            $total = count($model = Borang::find()->where(['semakan_by' => $icno, 'status' => 'MENUNGGU TINDAKAN'])->all());
 
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
    }
    public static function totalPendingVerified($icno) {
         

        $total = 0;
 
            $total = count($model = Borang::find()->where(['peraku_by' => $icno, 'status_pp' => 'MENUNGGU KELULUSAN'])->all());
 
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
    }
    public static function totalPendingApproval($icno) {
         

        $total = 0;
 
            $total = count($model = Borang::find()->where(['pelulus_by' => $icno, 'status_kj' => 'MENUNGGU TINDAKAN'])->all());
 
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
    }
    public static function totalPendingAction($icno) {
         

        $total = 0;
 
            $total = count($model = Borang::find()->where(['peraku_by' => $icno, 'status_pp' => 'DIPERAKUI'])->andwhere(['isActive2' => 2])->all());
 
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
    }
    public function getReftujuan() {
        return $this->hasOne( Reftujuanelaun::className(), ['id' => 'butiran']);
      }

    
    
}
