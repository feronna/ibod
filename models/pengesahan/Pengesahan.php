<?php

namespace app\models\pengesahan;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblrscoconfirmstatus;
use app\models\lnpt\Lpp;
use app\models\lnpt\Markahkeseluruhan;
use app\models\kehadiran\TblRekod;
use app\models\hronline\Tblrscoapmtstatus;
use app\models\hronline\Tblsubjek;
use yii\db\ActiveRecord;
use app\models\smp_ppi\Penyelidikan;
use app\models\smp_ppi\Abstrak;
use app\models\smp_ppi\Anthology;
use app\models\smp_ppi\Creative;
use app\models\smp_ppi\Magazine;
use app\models\smp_ppi\Manual;
use app\models\smp_ppi\Module;
use app\models\smp_ppi\PreUni;
use app\models\smp_ppi\Technical;
use app\models\smp_ppi\Textbook;
use app\models\smp_ppi\Translation;
use app\models\smp_ppi\JournalNational;
use app\models\smp_ppi\JournalInternational;
use app\models\smp_ppi\ProceedingNational;
use app\models\smp_ppi\ProceedingInternational;
use app\models\smp_ppi\Book;
use app\models\smp_ppi\BookChapter;
use app\models\smp_ppi\Perundingan;
use app\models\smppasca\PenyeliaanPelajarPasca;
use app\models\smp\Pengajaran;
use app\models\pengesahan\TblSurat;
use app\models\vhrms\DboMonthlyPayroll;
use app\models\vhrms\VwStaffProfile;
use app\models\pengesahan\TblMaklumatlain;
use app\models\hronline\Tblrscosandangan;

/**
 * This is the model class for table "Pengesahan.tbl_pengesahan".
 *
 * @property int $id
 * @property string $icno
 * @property string $tarikh_m
 * @property string $app_by
 * @property string $status_pp
 * @property string $status_jfpiu
 * @property string $status_bsm
 * @property string $ulasan_jfpiu
 * @property string $ulasan_bsm
 * @property string $ver_date
 * @property string $app_date
 * @property string $lulus_date

 * @property string $status
 * @property string $implikasi
 * @property string $terima
 */
class Pengesahan extends \yii\db\ActiveRecord
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
//        return 'pengesahan.tbl_pengesahan';
        return 'hrm.sah_tbl_pengesahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno','skim'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['ulasan_jfpiu', 'ulasan_bsm'], 'string'],
            [['tarikh_pengesahan','tarikh_lulus_ptm','tarikh_lulus_pnp','tarikh_mohon_balik', 'tarikh_mohon_balik2', 'tarikh_m', 'ver_date', 'app_date', 'lulus_date'], 'safe'],
            [['icno', 'app_by'], 'string', 'max' => 15],
            [['status_jfpiu', 'status_pp', 'status_bsm'], 'string', 'max' => 20],
            [['status_jfpiu', 'status_pp', 'status_bsm', 'tempoh_l_bsm', 'tempoh_l_pp', 'tempoh_l_jfpiu', 'pelanjutan','implikasi'], 'string', 'max' => 20],
            [['ConfirmStatusNm', 'skim', 'status'], 'string', 'max' => 122],
            [['terima', 'job_category'], 'string', 'max' => 10],   
            [['file'],'safe'],
            [['file'], 'file','extensions'=>'pdf', 'maxSize' => 5000000],
            [['file2'],'safe'],
            [['file2'], 'file','extensions'=>'pdf', 'maxSize' => 5000000],
            [['file3'],'safe'],
            [['file3'], 'file','extensions'=>'pdf', 'maxSize' => 5000000],
            [['file4'],'safe'],
            [['file4'], 'file','extensions'=>'pdf', 'maxSize' => 5000000],
//            [['file5'],'safe'],
//            [['file5'], 'file','extensions'=>'pdf', 'maxSize' => 5000000],
            [['dokumen_sokongan'], 'required', 'message' => 'Sila Lampirkan Dokumen Anda'],
            [['dokumen_sokongan2'], 'required', 'message' => 'Sila Lampirkan Dokumen Anda'],
            [['dokumen_sokongan3'], 'required', 'message' => 'Sila Lampirkan Dokumen Anda'],
            [['dokumen_sokongan4'], 'required', 'message' => 'Sila Lampirkan Dokumen Anda'],
//            [['dokumen_sokongan5'], 'required', 'message' => 'Sila Lampirkan Dokumen Anda'],

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
            'tarikh_lulus_ptm' => '',
            'tarikh_lulus_pnp' => '',
            'skim' => '',
            'tarikh_mohon_balik' => '',
            'tarikh_mohon_balik2' => '',
            'file4' => 'Sijil Senat',
            'file3' => 'Sijil PNP',
            'file2' => 'Dokumen Sokongan',
            'file' => 'Sijil PTM',
            'tarikh_m' => 'Tarikh M',
            'app_by' => 'App By',
            'status_jfpiu' => 'Status Jfpiu',
            'status_pp' => 'Status Pp',
            'status_bsm' => 'Status Bsm',
            'ulasan_jfpiu' => 'Ulasan Jfpiu',
             'ulasan_bsm' => 'Ulasan Bsm',
            'ulasan_tnca' => 'Ulasan Tnca',
            'ulasan_pendaftar' => 'Ulasan Pendaftar',
            'ulasan_nc' => 'Ulasan Nc',
            'ver_date' => 'Ver Date',
            'app_date' => 'App Date',
            'tnca_date' => 'Tnca Date',
            'pendaftar_date' => 'Pendaftar Date',
            'nc_date' => 'Nc Date',
            'lulus_date' => 'Lulus Date',
            'tempoh_l_pp' => 'Tempoh L Pp',
            'status' => 'Status',
            'tempoh_l_bsm' => 'Tempoh L Bsm',
            'tempoh_l_jfpiu' => 'Tempoh L Jfpiu',
            'status' => 'Status',  
            'terima' => 'Terima',
            'job_category' => 'Kategori kerja',
            'pelanjutan' => 'Pelanjutan',
            'implikasi' => 'Implikasi',
            'ConfirmStatusNm' => 'ConfirmStatusNm',  
            'dokumen_sokongan' => 'Dokumen Sokongan 1',
            'dokumen_sokongan2' => 'Dokumen Sokongan 2',
            'dokumen_sokongan3' => 'Dokumen Sokongan 3',
            'dokumen_sokongan4' => 'Dokumen Sokongan 4',
            'dokumen_sokongan5' => 'Dokumen Sokongan 5',
        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getKj() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'app_by']);
    }
    public function getKakitangan2() {
        return $this->hasOne(TblPtm::className(), ['ICNO' => 'icno']);
    }
    
    public function getKakitangan3() {
        return $this->hasOne(TblPnp::className(), ['ICNO' => 'icno']);
    } 
    
    public function getKakitangan4() {
        return $this->hasOne(\app\models\cbelajar\TblPengajian::className(), ['icno' => 'icno'])->orderBy(['tarikh_mula' => SORT_DESC]);
    }  

    public function getConfirmation() {
        $model = Tblrscoconfirmstatus::find()->where(['ICNO' => $this->icno])->max('ConfirmStatusStDt');     
        return $this->hasOne(Tblrscoconfirmstatus::className(), ['ICNO' => 'icno'])->orderBy(['ConfirmStatusStDt'=>SORT_DESC]);
    }
    
    public function getGredbm() {
        return $this->hasOne(Tblsubjek::className(), ['ICNO'=> 'icno']);
    }
    
    public function getGredspmbm() {
        $subjekspm = Tblsubjek::findOne(['ICNO' => $this->icno, 'EduLevel_id' => '14', 'Subject_id' => '12']);
        return $subjekspm;
    }
    
    public function getGredpmrbm() {
        $subjekpmr = Tblsubjek::findOne(['ICNO' => $this->icno, 'EduLevel_id' => '15', 'Subject_id' => '260']);
        return $subjekpmr;
    }
    
    public function getSijilspm() {
        return $this->hasOne(\app\models\hronline\Tblpendidikan::className(), ['ICNO'=> 'icno'])->where(['HighestEduLevelCd' => [14,23]]);
    }
    
      public function getSijilpmr() {
        return $this->hasOne(\app\models\hronline\Tblpendidikan::className(), ['ICNO'=> 'icno'])->where(['HighestEduLevelCd' => '15']);
    }
    
    public function getMaklumatlain() {
        return $this->hasOne(TblMaklumatlain::className(), ['pengesahan_id' => 'id']);
    }
    
    public function getLpp($year) {
        return $this->hasOne(Lpp::className(), ['PYD' => 'icno', 'tahun' => $year]);
    }
    
    public function getMarkah1(){
       return $this->hasOne(\app\models\lnpt\markah::className(), ['staff_id' => 'staff_id'])
                ->where(['tahun' => date('Y')-1])
                ->viaTable('elnpt.user', ['user_id' => 'icno']);
    }
    
    public function getMarkah2(){
       return $this->hasOne(\app\models\lnpt\markah::className(), ['staff_id' => 'staff_id'])
                ->where(['tahun' => date('Y')-2])
                ->viaTable('elnpt.user', ['user_id' => 'icno']);
    }
    
    public function getMarkah3(){
       return $this->hasOne(\app\models\lnpt\markah::className(), ['staff_id' => 'staff_id'])
                ->where(['tahun' => date('Y')-3])
                ->viaTable('elnpt.user', ['user_id' => 'icno']);
    }
    
    public function getMarkahkeseluruhan1() {
        return $this->hasOne(Markahkeseluruhan::className(), ['lpp_id' => 'lpp_id'])
                ->viaTable('lppums.lpp', ['PYD' => 'icno'], function ($query) {
            $query->andWhere(['tahun' => date('Y')-1]);
        });
    }
    
    public function getMarkahkeseluruhan2() {
        return $this->hasOne(Markahkeseluruhan::className(), ['lpp_id' => 'lpp_id'])
                ->viaTable('lppums.lpp', ['PYD' => 'icno'], function ($query) {
            $query->andWhere(['tahun' => date('Y')-2]);
        });
    }
    
    public function getMarkahkeseluruhan3() {
        return $this->hasOne(Markahkeseluruhan::className(), ['lpp_id' => 'lpp_id'])
                ->viaTable('lppums.lpp', ['PYD' => 'icno'], function ($query) {
            $query->andWhere(['tahun' => date('Y')-3]);
        });
    }
    
    public function getStatusjfpiu() {
        if ($this->status_jfpiu == 'Tunggu Perakuan') {
            return '<span class="label label-warning">Menunggu</span>';
        }
        if ($this->status_jfpiu == 'Diperakui') {
            return '<span class="label label-success">Diperakui</span>';
        }
        if ($this->status_jfpiu == 'Tidak Diperakui') {
            return '<span class="label label-danger">Ditolak</span>';
        }
         if ($this->status_jfpiu === NULL) {
            return '-';
        }
    }   
    
    public function getStatusbsm() {
        if ($this->status_bsm == 'Tunggu Kelulusan' || $this->status_bsm == 'Draft Diluluskan' || $this->status_bsm == '' || $this->status_jfpiu == 'Draft Ditolak'){
            return '<span class="label label-warning">Menunggu</span>';
        }
//          if ($this->status_bsm == 'Draft Diluluskan') {
//            return '<span class="label label-warning">Menunggu</span>';
//        }
//          if ($this->status_bsm == 'Draft Ditolak') {
//            return '<span class="label label-warning">Menunggu</span>';
//        }
        if ($this->status_bsm == 'Diluluskan') {
            return '<span class="label label-success">Diluluskan</span>';
        }
        if ($this->status_bsm == 'Tidak Diluluskan') {
            return '<span class="label label-danger">Ditolak</span>';
        }
         if ($this->status == 'Lanjutan Tanpa Denda') {
            return '<span class="label label-danger">Ditolak</span>';
        }
                if ($this->status == 'Lanjutan Dengan Denda') {
            return '<span class="label label-danger">Ditolak</span>';
        }
         if ($this->status_bsm === NULL) {
            return '-';
        }
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
    
    
    public static function countKetidakpatuhan($icno, $year, $type) {

        $val = 0;

        if ($type == 1) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND status_in = "LATE_IN"';
        }

        if ($type == 2) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND status_out = "EARLY_OUT"';
        }

        if ($type == 3) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND incomplete = 1';
        }

        if ($type == 4) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND absent = 1';
        }
        
        if ($type == 5) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND external = 1';
        }

        $model = TblRekod::findBySql($sql, [':icno' => $icno, ':year' => $year])->all();

        if ($model) {
            $val = count($model);
        }

        return $val;
    }
    
    public static function Tetapan() {
        $date_open = Option::find()->where(["=", "name", "date_open"])->one();
        $now = time(); // or your date as well
        $open = strtotime($date_open->value);
        $datediff = $open - $now;
        $dayLeft =  round($datediff / (60 * 60 * 24));
        $options = [
            "date_open" => $date_open->value,
            "day_left" => $dayLeft
        ];
        return $options;

       }
    
    public static function latesttahuntempoh($icno){
        return Tblprcobiodata::find()->where(['ICNO' => $icno])->min('YEAR(startdatelantik)'); 
    }
    
    public function getTempoh(){
        $model = Tblrscoapmtstatus::find()->where(['ICNO' => $this->icno])->min('ApmtStatusStDt');     
        $date1=date_create($model);
        $date2=date_create(date('Y-m-d'));
        $tempoh = date_diff($date1, $date2)->format('%y Tahun %m Bulan %d Hari');
        //$tempoh = round($tempo/365, 1);
        return $tempoh;
    }
    
    public function isExist($icno){
        return self::find()->where(['icno'=>$icno])->exists();
    }

//    public function getTempohlantikantetap(){
//        $model = Tblprcobiodata::find()->where(['ICNO' => $this->icno])->min('startDateSandangan');     
//        $date1=date_create($model);
//        $date2=date_create(date('Y-m-d'));
//        $tempohlantikantetap = date_diff($date1, $date2)->format('%y Tahun %m Bulan %d Hari');
//        //$tempohlantikantetap = round($tempo/365, 1);
//        return $tempohlantikantetap;
//    }

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
    
    public function getCreated() {
        return  $this->getTarikh($this->created_at);
    }

    public function getStatlantik() {
        return  $this->getInt($this->kakitangan->statLantik);
    }
    
    public function getStartdatelantik() {
        return  $this->getTarikh($this->kakitangan->startDateLantik);
    }
    
    public function getEnddatelantik() {
        return $this->getTarikh($this->kakitangan->endDateLantik);
    }
    
    public function getConfirmstatuscd() {
        return  $this->getInt($this->confirmstatus->ConfirmStatusCd);
    }
    
    public function getConfirmstatusstdt() {
        return  $this->getTarikh($this->confirmstatus->ConfirmStatusStDt);
    }

    public function getTarikhmohon() {
        if($this->tarikh_m!=''){
        return $this->getTarikhh($this->tarikh_m);}
    }

    public function getTarikhkj() {
        return $this->getTarikhh($this->app_date);
    }
    
    public function getTarikhbsm() {
        return $this->getTarikh($this->ver_date);
    }
    
    public function getTarikhlulus() {
        return $this->getTarikhh($this->lulus_date);
    }
    
    public function getTarikhPengesahan() {
        return  $this->getTarikh($this->tarikh_pengesahan);
    } 
    
    public function getTarikhlulusptm() {
        return  $this->getTarikh($this->kakitangan2->tarikhLulusPtm);
    }
    
    public function getTarikhlulusptm2() {
        return $this->getTarikh($this->tarikh_lulus_ptm);
    }
    
    public function getTarikhluluspnp() {
        return $this->getTarikh($this->tarikh_lulus_pnp);
    }
    
    public function getStaffidreportsmbu(){
        return VwStaffProfile::find()->where(['sm_ic_no' => $this->icno])->one()->sm_staff_id;
    }
    
    public function getGajipokok(){
        $gaji = DboMonthlyPayroll::find()->where(['MP_PROCESS' => '1', 'MP_STAFF_ID' => $this->staffidreportsmbu])->one();
        return $gaji->MP_BASIC_PAY;
    }
    
    public function getJumlahelaun(){
        $gaji = DboMonthlyPayroll::find()->where(['MP_PROCESS' => '1', 'MP_STAFF_ID' => $this->staffidreportsmbu])->one();
//        $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->staffidreportsmbu])->max('MPH_PAY_MONTH');
//        return ViewPayroll::find()->where(['it_income_desc' => 'GAJI POKOK', 'MPH_PAY_MONTH' => $model, 'MPH_STAFF_ID' => $this->staffidreportsmbu])->one()->MPH_TOTAL_ALLOWANCE;
        return $gaji->MP_NETT_SALARY - $gaji->MP_BASIC_PAY;
    }
    
    public function getItka(){
        $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->staffidreportsmbu])->max('MPH_PAY_MONTH');
        return ViewPayroll::find()->where(['it_income_desc' => 'ITKA', 'MPH_PAY_MONTH' => $model, 'MPH_STAFF_ID' => $this->staffidreportsmbu])->one()->MPDH_PAID_AMT;
    }
    
    public function getItp(){
        $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->staffidreportsmbu])->max('MPH_PAY_MONTH');
        return ViewPayroll::find()->where(['it_income_desc' => 'ITP', 'MPH_PAY_MONTH' => $model, 'MPH_STAFF_ID' => $this->staffidreportsmbu])->one()->MPDH_PAID_AMT;
    }
    
    public function getBipk(){
        $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->staffidreportsmbu])->max('MPH_PAY_MONTH');
        return ViewPayroll::find()->where(['it_income_desc' => 'BIP KRITIKAL', 'MPH_PAY_MONTH' => $model, 'MPH_STAFF_ID' => $this->staffidreportsmbu])->one()->MPDH_PAID_AMT;
    }
    
    public function getBiw(){
        $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->staffidreportsmbu])->max('MPH_PAY_MONTH');
        return ViewPayroll::find()->where(['it_income_desc' => 'BAY. INS.WILAYAH', 'MPH_PAY_MONTH' => $model, 'MPH_STAFF_ID' => $this->staffidreportsmbu])->one()->MPDH_PAID_AMT;
    }
    
    public function getKgt(){
        $gred = \app\models\hronline\GredJawatan::find()->where(['id' => $this->kakitangan->gredJawatan])->one()->gred;
        return JadualGaji::find()->where(['r_jg_gred' => $gred])->one()->r_jg_kgt;
    }

    public static function totalPending($icno, $category) {

        $total = 0;
        if($category !=0){
        $model = Pengesahan::find()->where(['app_by' => $icno, 'status' => 'DALAM TINDAKAN KETUA JABATAN' ,'job_category'=>$category])->all();
        if ($model) {
            $total = count($model);
        }
        }
         else{
            $total = count($model = Pengesahan::find()->where(['app_by' => $icno, 'status' => 'DALAM TINDAKAN KETUA JABATAN'])->all());
        }
        if ($total > 0) {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        else {
                return '';
        }
    }
    
    public static function totalPendingtask($icno, $category) {

        $total = 0;
        $model = Pengesahan::find()->where(['app_by' => $icno, 'status' => 'DALAM TINDAKAN KETUA JABATAN','job_category'=>$category])->all();
        if ($model) {
            $total = count($model);
        }
        return $total;
    }
    
    public function beforeSave($insert) {
    
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke', 'tahun_mesyuarat', 'tarikh_mesyuarat'])->orderBy(['id'=>SORT_DESC])->limit(1)->one();
        
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        $this->kali_ke = $tmp['kali_ke'];
        $this->tahun_mesyuarat = $tmp['tahun_mesyuarat'];
        $this->tarikh_mesyuarat = date('d M Y', strtotime ($tmp['tarikh_mesyuarat']));
        
 
        // ...custom code here...
        return true;
    }
    
    public function getHari($hari){
        
        $D = date_format(date_create($hari), "D");
        if($D == 'Mon'){
            $D = "Isnin";}
        elseif ($D == 'Tue'){
          $D = "Selasa";}
        elseif ($D == 'Wed'){
          $D = "Rabu";}
        elseif ($D == 'Thu'){
          $D = "Khamis";}
        elseif ($D == 'Fri'){
          $D = "Jumaat";}   
          
        return  $D ;
    }
    
    public function getDateIssue() {
        return  $this->getTarikh($this->date_issue);
    }
    
    public function getHariIssue() {
        return  $this->getHari($this->date_issue);
    }
    
    public function getTarikhMesyuarat() {
        return  $this->getTarikh($this->tarikh_mesyuarat);
    } 
    
    public function getTarikhMohonBalik() {
        return  $this->getTarikh($this->tarikh_mohon_balik);
    } 
    
    public function getTarikhMohonBalik2() {
        return  $this->getTarikh($this->tarikh_mohon_balik2);
    } 
    
    public function getGelaran() {
        return $this->hasOne(Tblprcobiodata::className(), ['TitleCd' => 'gelaran']);
    }
   
    public function getLetter(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
    public function getPenyelidikan() {
        return $this->hasMany(Penyelidikan::className(), ['IC' => 'icno']); //penyelidikan sepanjang tempoh berkhidmat
    }
    
    public function getJournalInternational() {
        return $this->hasMany(JournalInternational::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getJournalNational() {
        return $this->hasMany(JournalNational::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getProceedingInternational() {
        return $this->hasMany(ProceedingInternational::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getProceedingNational() {
        return $this->hasMany(ProceedingNational::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getBook() {
        return $this->hasMany(Book::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getBookChapter() {
        return $this->hasMany(BookChapter::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getAbstrak() {
        return $this->hasMany(Abstrak::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getAnthology() {
        return $this->hasMany(Anthology::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getCreative() {
        return $this->hasMany(Creative::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getMagazine() {
        return $this->hasMany(Magazine::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getManual() {
        return $this->hasMany(Manual::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getModule() {
        return $this->hasMany(Module::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getPreUni() {
        return $this->hasMany(PreUni::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getTechnical() {
        return $this->hasMany(Technical::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getTextBook() {
        return $this->hasMany(Textbook::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getTranslation() {
        return $this->hasMany(Translation::className(), ['User_Ic' => 'icno'])->where(['AuthorType' => 'First Author']);
    }
    
    public function getPerundingan() {
       //return Perundingan::find()->where(['ICNo' => '781027125394'])->all();
       return $this->hasMany(Perundingan::className(), ['ICNo' => 'icno']);
    }
    
    public function getPenyeliaanpasca() {
        return $this->hasMany(PenyeliaanPelajarPasca::className(), ['supervisorIC' => 'icno']);
    }
    
    public function getPengajaran() {
        return $this->hasMany(Pengajaran::className(), ['NOKP' => 'icno']);
    }
    
    public function getKetuajfpiu(){
        //$pegawai = Department::findOne(['id' => $this->kakitangan->DeptId]);
        if($this->kakitangan->department->sub_of == '' || $this->kakitangan->department->sub_of == '12'){
        return $this->kakitangan->department->chiefBiodata->CONm; //kj 
        }
        else{
        $pegawaisub = \app\models\hronline\Department::findOne(['id' => $pegawai->sub_of]);
        return $pegawaisub->chiefBiodata->CONm; //kj
        }
    }
    
    public function getDisplayJumlahJurnalInternational() {
        return TblMaklumatlain::find()->where(['pengesahan_id' => $this->id])->one()->jurnal_international;
    }
    
    public function getDisplayJumlahJurnalNational() {
        return TblMaklumatlain::find()->where(['pengesahan_id' => $this->id])->one()->jurnal_national;
    }
    
    public function getDisplayJumlahProsidingInternational() {
        return TblMaklumatlain::find()->where(['pengesahan_id' => $this->id])->one()->prosiding_international;
    }
    
    public function getDisplayJumlahProsidingNational() {
        return TblMaklumatlain::find()->where(['pengesahan_id' => $this->id])->one()->prosiding_national;
    }
    
    public function getDisplayJumlahPenerbitanPenulisUtamaJurnalInternational() {
        return TblMaklumatlain::find()->where(['pengesahan_id' => $this->id])->one()->penulis_utama_jurnal_international;
    }
    
    public function getDisplayJumlahPenerbitanPenulisUtamaJurnalNational() {
        return TblMaklumatlain::find()->where(['pengesahan_id' => $this->id])->one()->penulis_utama_jurnal_national;
    }
    
    public function getDisplayJumlahPenerbitanPenulisUtamaProsidingInternational() {
        return TblMaklumatlain::find()->where(['pengesahan_id' => $this->id])->one()->penulis_utama_prosiding_international;
    }
    
    public function getDisplayJumlahPenerbitanPenulisUtamaProsidingNational() {
        return TblMaklumatlain::find()->where(['pengesahan_id' => $this->id])->one()->penulis_utama_prosiding_national;
    } 
    
    public function getJumlahJurnalInternational() {
        $jumlah=0;
        foreach ($this->journalInternational as $l) {
            $jumlah++; 
            }
        return $jumlah;
    }
    
    public function getJumlahJurnalNational() {
        $jumlah=0;
        foreach ($this->journalNational as $l) {
            $jumlah++; 
            }
        return $jumlah;
    }
    
    public function getJumlahProsidingInternational() {
        $jumlah=0;
        foreach ($this->proceedingInternational as $l) {
            $jumlah++; 
            }
        return $jumlah;
    }
    
    public function getJumlahProsidingNational() {
        $jumlah=0;
        foreach ($this->proceedingNational as $l) {
            $jumlah++; 
            }
        return $jumlah;
    }

    public function getJumlahPenerbitanPenulisUtamaJurnalInternational() {
        $jumlah=0;
        foreach ($this->journalInternational as $l) {
            if($l->AuthorType==='First Author'){
               $jumlah++; 
            }
            }
        return $jumlah;
    }
    
    public function getJumlahPenerbitanPenulisUtamaJurnalNational() {
        $jumlah=0;
        foreach ($this->journalNational as $l) {
            if($l->AuthorType==='First Author'){
               $jumlah++; 
            }
            }
        return $jumlah;
    }
    
    public function getJumlahPenerbitanPenulisUtamaProsidingInternational() {
        $jumlah=0;
        foreach ($this->proceedingInternational as $l) {
            if($l->AuthorType==='First Author'){
               $jumlah++; 
            }
            }
        return $jumlah;
    }
    
    public function getJumlahPenerbitanPenulisUtamaProsidingNational() {
        $jumlah=0;
        foreach ($this->proceedingNational as $l) {
            if($l->AuthorType==='First Author'){
               $jumlah++; 
            }
            }
        return $jumlah;
    }
    
    public function getDokumen(){
        return $this->hasOne(TblSurat::className(), ['pengesahan_id' => 'id']);
    }
    
    public function perMonth($year,$month) {
        return Pengesahan::find()->where(['YEAR(tarikh_m)' => $year])->andWhere(['MONTH(tarikh_m)' => $month])->count();
    }
    
    public function getTotalCount($year,$mth) {
        
        return Pengesahan::find()->where(['YEAR(tarikh_m)' => $year])->count();
    }
    
    public function kehadiran($year, $type) {
        $val = 0;
        $icno = $this->icno;
        if ($type == 1) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND late_in = 1 AND remark_status !="APPROVED"';
        }

        if ($type == 2) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND early_out = 1 AND remark_status !="APPROVED"';
        }

        if ($type == 3) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND incomplete = 1 AND remark_status !="APPROVED"';
        }

        if ($type == 4) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND absent = 1 AND remark_status !="APPROVED"';
        }

        if ($type == 5) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND external = 1 AND remark_status !="APPROVED"';
        }

        $model = TblRekod::findBySql($sql, [':icno' => $icno, ':year'=>$year])->all();

        if ($model) {
            $val = count($model);
        }

        return $val;
    }
    
    //untuk pendingtask pengesahan //status permohonan
    public static function isRegistered($icno){
        if(Pengesahan::find()->where(['icno'=>$icno])->exists()){
            return 1;
        }
        return 0;
    }
    
    public function getPuratalnptpentadbiran() {
        $tahunstarttetap = Tblprcobiodata::find()->where(['ICNO' => $this->icno])->min('YEAR(startdatelantik)');

        $markah = \app\models\lppums\Lpp::find()->where(['PYD' => $this->icno, 'tahun' => $tahunstarttetap])->one(); // yang telah disahkan sahaja

        $record = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();                                    
        if ($record) {
            $allrecord0 = $allrecord0 + $record->markah_PP;
                if ($record->markah_PP != '0' || $record->markah_PP != '') {
                }
        }

        $yearOld = $tahunstarttetap;
        $yearNow = date('Y');
        $year = $yearNow - $yearOld;
        $allrecord = number_format($allrecord0 / $year, 2, '.', '');
        
        return $allrecord;
    }
    
    public function getPuratalnptakademik() {
        $tahunstarttetap = Tblprcobiodata::find()->where(['ICNO' => $this->icno])->min('YEAR(startdatelantik)');

        //markah tahun 2019 dan ke bawah (beza tbl c cleeve x guna tbl lama tu yg markah 2020 berbeza tempat)
       $i =0; $jumlahKeseluruhan1 = 0;
        $markahOld = \app\models\elnpt\elnpt_lama\TblUser::find()->where(['user_id' => $this->icno])->one();

        $recordOld = \app\models\elnpt\elnpt_lama\TblMarkahLama::find()->where(['staff_id' => $markahOld->staff_id, 'tahun' => $tahunstarttetap])->orderBy(['id' => SORT_DESC])->one();
        if ($recordOld) {
            if ($recordOld->purata != '0' || $recordOld->purata != '') {

                $jumlahKeseluruhan1 = $jumlahKeseluruhan1 + $recordOld->purata;
                $i++;
            }
        }

        //markah tahun 2020 dan ke atas
        $j =0; $jumlahKeseluruhan2 = 0;
        $markah = \app\models\elnpt\TblMain::find()->where(['PYD' => $this->icno, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PEER_sah' => 1, 'tahun' => $tahunstarttetap])->orderBy(['tahun' => SORT_DESC])->one(); // yang telah disahkan sahaja

        $record = \app\models\elnpt\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();
        if ($record) {
            if ($record->markah != '0' || $record->markah != '') {

                $jumlahKeseluruhan2 = $jumlahKeseluruhan2 + $record->markah;
                $j++;
            }
        }
        
        //akademik yg isi borang pentadbiran
        $k =0; $jumlahKeseluruhan3 = 0;
        $markahPen = \app\models\lppums\Lpp::find()->where(['PYD' => $this->icno, 'tahun' => $tahunstarttetap])->orderBy(['tahun' => SORT_DESC])->one();

        $recordPen = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markahPen->lpp_id])->one();
        if ($recordPen) {
            if ($recordPen->markah_PP != '0' || $recordPen->markah_PP != '') {

                $jumlahKeseluruhan3 = $jumlahKeseluruhan3 + $recordPen->markah_PP;
                $k++;
            }
        }
        
        $jumlahTahun = $i + $j + $k;
        $purata = number_format(($jumlahKeseluruhan1 +$jumlahKeseluruhan2 + $jumlahKeseluruhan3) / $jumlahTahun , 2, '.', '');

        return $purata;
    }
}