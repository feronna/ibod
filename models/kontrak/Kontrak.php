<?php

namespace app\models\kontrak;

use app\models\hronline\Tblprcobiodata;
use app\models\kehadiran\TblRekod;
use app\models\lnpt\Lpp;
use app\models\lnpt\Markahkeseluruhan;
use app\models\hronline\Tblrscoapmtstatus;
use app\models\vhrms\ViewPayroll;
use app\models\hronline\JadualGaji;
use app\models\kontrak\TempKehadiran;
use app\models\hronline\GredJawatan;
use app\models\hronline\Tblanugerah;
use app\models\hronline\Vcpdlatihan;
use app\models\smp\Pengajaran;
use app\models\vhrms\VwStaffProfile;
use app\models\smp_ppi\Penyelidikan;
use app\models\smp_ppi\Perundingan;
use app\models\lnpt\User;
use app\models\smppasca\PenyeliaanPelajarPasca;
use app\models\smp_ppi\JournalNational;
use app\models\smp_ppi\JournalInternational;
use app\models\smp_ppi\Book;
use app\models\smp_ppi\BookChapter;
use yii\helpers\ArrayHelper;
use app\models\kontrak\TblKpi;
use app\models\kontrak\TblSurat;
use app\models\vhrms\DboMonthlyPayroll;
use app\models\smp\Penyeliaan;
use app\models\kontrak\TblHindex;
use app\models\myidp\RefCpdGroupGredJawatan;
use app\models\myidp\RefCpdGroup;
use app\models\myidp\IdpMata;
use \app\models\elnpt\penerbitan\TblLnptPublicationV2;
use app\models\kontrak\RefCadanganjawatan;
use app\models\kontrak\TblAkses;
use app\models\elnpt\TblMain;
use app\models\cuti\SetPegawai;
use app\models\hronline\Tblrscoadminpost;
use app\models\kontrak\TblKetuafpsk;
use app\models\Kontrak\RefTempoh;
use app\models\hronline\Department;
use app\models\kehadiran\TblWarnaKad;

/**
 * This is the model class for table "Kontrak.tbl_kontrak".
 *
 * @property int $id
 * @property string $icno
 * @property string $reason
 * @property string $tarikh_m
 * @property string $ver_by
 * @property string $app_by
 * @property string $status_pp
 * @property string $status_jfpiu
 * @property string $status_bsm
 * @property string $ulasan_pp
 * @property string $ulasan_jfpiu
 * @property string $ver_date
 * @property string $app_date
 * @property string $lulus_date
 * @property string $tempoh_l_pp
 * @property string $status
 * @property string $tempoh_l_bsm
 * @property string $tempoh_l_jfpiu
 * @property string $terima
 */
class Kontrak extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file ;
    public $DeptId, $end_filter, $start_filter, $sesi, $url;
    public static function tableName()
    {
        return 'hrm.kontrak_tbl_kontrak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'required'],
            [['reason'], 'required', 'on' => 'bi', 'message' => 'Reason For Extension cannot be blank'],
            [['reason'], 'required', 'on' => 'bm', 'message' => 'Justifikasi Permohonan wajib diisi'],
            [['reason', 'ulasan_pp', 'ulasan_jfpiu', 'dokumen_sokongan'], 'string', 'max' => 1000],
            [['tarikh_m', 'ver_date','status_date', 'app_date', 'bsma_date', 'lulus_date', 'cadangan_jawatan', 'cadangan_jawatan_ver','startDateLantik', 'endDateLantik', 'sesi_id', 'tahun_sesi'], 'safe'],
            [['icno', 'ver_by', 'app_by'], 'string', 'max' => 15],
            [['status_pp'], 'string', 'max' => 30],
            [['status_jfpiu', 'status_bsm', 'tempoh_l_pp', 'tempoh_l_bsm', 'tempoh_l_jfpiu'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 50],
            [['terima', 'job_category'], 'string', 'max' => 10],
            [['url'], 'string', 'max' => 500],
            [['file', 'url'],'safe'],
            [['file'], 'file','extensions'=>'pdf', 'maxSize' => 5000000],
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
            'reason' => 'Justifikasi Permohonan',
            'tarikh_m' => 'Tarikh M',
            'ver_by' => 'Ver By',
            'app_by' => 'App By',
            'status_pp' => 'Status Pp',
            'status_jfpiu' => 'Status Jfpiu',
            'status_bsm' => 'Status Bsm',
            'ulasan_pp' => 'Ulasan Pp',
            'ulasan_jfpiu' => 'Ulasan Jfpiu',
            'ver_date' => 'Ver Date',
            'app_date' => 'App Date',
            'lulus_date' => 'Lulus Date',
            'tempoh_l_pp' => 'Tempoh L Pp',
            'status' => 'Status',
            'tempoh_l_bsm' => 'Tempoh L Bsm',
            'tempoh_l_jfpiu' => 'Tempoh L Jfpiu',
            'terima' => 'Terima',
            'job_category' => 'Kategori kerja',
            'dokumen_sokongan' => 'Dokumen Sokongan',
        ];
    }
    
    //relation hronline
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
    public function getLantikan() {
        return $this->hasMany(Tblrscoapmtstatus::className(), ['ICNO' => 'icno']);
    }
    
    public function getAnugerah() {
        return $this->hasMany(Tblanugerah::className(), ['ICNO' => 'icno']);
    }
    
    //relation db hrd
    public function getKpi() {
        return $this->hasMany(TblKpi::className(), ['kontrak_id' => 'id']);
    }
    
    public function getHindex() {
        return $this->hasOne(TblHindex::className(), ['icno' => 'icno']);
    }
    
    public function getAksespemohon() {
        return $this->hasOne(TblAkses::className(), ['icno' => 'icno'])->where(['role' => 'pemohon']);
    }
    
    public function getSesimulakontrak(){
        $m = date_format(date_create($this->startDateLantik), "m");
        $y = date_format(date_create($this->startDateLantik), "Y");
        if($m>=1 && $m<=8){
            return ($y-1).'/'.$y;
        }
        else{
            return $y.'/'.($y+1);
        }
    }
    
    public function getSemmulakontrak(){
        $m = date_format(date_create($this->startDateLantik), "m");
        if($m>=2 && $m<=8){
            return '2';
        }
        else{
            return '1';
        }
    }
    
    public static function checkkpi($model) {
        
        foreach (RefKriteriaKpi::find()->where(['status' => 1])->all() as $ref){
        if(TblKpi::find()->where(['kontrak_id' => $model->id, 'kriteriakpi_id' => $ref->id])->exists()){
            $kpi = TblKpi::find()->where(['kontrak_id' => $model->id, 'kriteriakpi_id' => $ref->id])
                    ->andWhere(['!=', 'perkara', 'comment'])->all();
            foreach($kpi as $kpi)
            {
                if($kpi->catatan === ''){
                    return 'incomplete';
                }
            } 
        }
        else{
            return 'incomplete';
        }
        }
    }
    
    public static function checkteaching($model){
        foreach ($model->pengajaran as $l) {
            if((substr($l->SESI, -9) > $model->sesimulakontrak || (substr($l->SESI, -9) == $model->sesimulakontrak && substr($l->SESI,0,1) >= $model->semmulakontrak))&& !$l->jamwaktu){
                if(!$l->coteaching){ return 'incomplete';}
        }}
    }
    
    public function getPengajaran() {
        if($this->icno == 'TZ1077576'){
            return Pengajaran::find()->where(['NOKP' => 'TZ0411954'])->all();
        }
        return $this->hasMany(Pengajaran::className(), ['NOKP' => 'icno']);
    }
    
    public function getElnpt() {
        return $this->hasMany(TblMain::className(), ['PYD' => 'icno']);
        
    }
    
    public function getPenyeliaanpasca() {
        if($this->icno == 'TZ1077576'){
            return PenyeliaanPelajarPasca::find()->where(['supervisorIC' => 'TZ0411954'])->andWhere(['>=','endDate',$this->startDateLantik])->all();
        }
        return $this->hasMany(PenyeliaanPelajarPasca::className(), ['supervisorIC' => 'icno'])->where(['>=','endDate',$this->startDateLantik]);
    }
    
    public function getPenyeliaan() {
        if($this->icno == 'TZ1077576'){
            return Penyeliaan::find()->where(['NoKpPenyelia' => 'TZ0411954'])->all();
        }
        return $this->hasMany(Penyeliaan::className(), ['NoKpPenyelia' => 'icno'])->orderBy('Nomatrik , AutoId');
    }
    
    public function getPenyelidikan() {
        if($this->icno == 'TZ1077576'){
            return Penyelidikan::find()->where(['IC' => 'TZ0411954'])->andWhere(['>=','EndDate',$this->startDateLantik])->all();
        }
        return $this->hasMany(Penyelidikan::className(), ['IC' => 'icno'])->where(['>=','EndDate',$this->startDateLantik]);
    }
    
    public function getPenerbitan() {
        $icno = $this->icno=='TZ1077576'? 'TZ0411954': $this->icno;
        $status = ['Published', 'Paper Accepted'];
        return TblLnptPublicationV2::find()->where(['User_Ic' => $icno, 'Keterangan_PublicationStatus' => $status])
                ->andWhere(['>=', 'PublicationYear', $this->tahunmulakontrak])
                ->orderBy([
            new \yii\db\Expression("CASE WHEN Keterangan_PublicationTypeID = 'Article' THEN '1'
               END DESC"),
            'PublicationYear' => SORT_DESC,
            new \yii\db\Expression("CASE WHEN KeteranganBI_WriterStatus = 'First Author' THEN 1
                WHEN KeteranganBI_WriterStatus = 'Corresponding Author' THEN 2
                WHEN KeteranganBI_WriterStatus = 'Collaborative Author' THEN 3
                ELSE 4
               END ASC"),
            'KeteranganBI_WriterStatus' =>  SORT_DESC,
            new \yii\db\Expression("CASE WHEN Keterangan_PublicationStatus = 'Published' THEN 1 
                WHEN Keterangan_PublicationStatus = 'Manuscript preparation' THEN 3 ELSE 2 END ASC")])->all();
    }
    
    public function getPerundingan() {
       if($this->icno == 'TZ1077576'){
            return Perundingan::find()->where(['ICNo' => 'TZ0411954'])->andWhere(['>=','EndDate',$this->startDateLantik])->all();
        }
       return $this->hasMany(Perundingan::className(), ['ICNo' => 'icno'])->where(['>=','EndDate',$this->startDateLantik])->andwhere(['Type' => 'C']);
    }
    
    public function getPerundingannot() {
       if($this->icno == 'TZ1077576'){
            return Perundingan::find()->where(['ICNo' => 'TZ0411954'])->andWhere(['<','EndDate',$this->startDateLantik])->all();
        }
       return $this->hasMany(Perundingan::className(), ['ICNo' => 'icno'])->where(['<','EndDate',$this->startDateLantik]);
    }
    public function getTahunmulakontrak(){
        return date_format(date_create($this->startDateLantik), "Y");
    }
    
    public function getJournalInternational() {
        return $this->hasMany(JournalInternational::className(), ['User_Ic' => 'icno'])->where(['>=', 'PublicationYear', $this->tahunmulakontrak]);
    }
    
    public function getJournalNational() {
        return $this->hasMany(JournalNational::className(), ['User_Ic' => 'icno'])->where(['>=', 'PublicationYear', $this->tahunmulakontrak]);
    }
    
    public function getBook() {
        return $this->hasMany(Book::className(), ['User_Ic' => 'icno'])->where(['>=', 'PublicationYear', $this->tahunmulakontrak]);
    }
    
    public function getBookChapter() {
        return $this->hasMany(BookChapter::className(), ['User_Ic' => 'icno'])->where(['>=', 'PublicationYear', $this->tahunmulakontrak]);
    }
    
    public function getLatihan() {
        return $this->hasMany(Vcpdlatihan::className(), ['vcl_id_staf' => 'icno']);
    }
    
    public function getLatihanbaru() {
        $model = \app\models\myidp\SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $this->icno])
                    ->all();
        return $model;
    }
    
    public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => $this->kakitangan->gredJawatan]);
    }
    
    public function getKehadiran() {
        return $this->hasOne(TempKehadiran::className(), ['icno' => 'icno']);
    }
    
    public function getLpp($year) {
        return $this->hasOne(Lpp::className(), ['PYD' => 'icno', 'tahun' => $year]);
    }
    
    public function getElnptid() {
        return $this->hasOne(User::className(), ['user_id' => 'icno']);
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
//        'markahkeseluruhan1' => SORT_DESC  
        return $this->hasOne(Markahkeseluruhan::className(), ['lpp_id' => 'lpp_id'])
                ->viaTable('lppums.lpp', ['PYD' => 'icno'], function ($query) {
            $query->andWhere(['or',['tahun' =>(date('Y')-1)], ['tahun' => NULL]]);
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
    
    public function markahlnpt($tahun) {
        
        if($this->job_category == '2'){
            return \app\models\lppums\TblAvgMark::find()->where(['ICNO' => $this->icno, 'YEAR' => $tahun])->one()->average_mark;
        }
        elseif($this->job_category == '1'){
            return \app\models\elnpt\VMarkahKeseluruhan::find()->where(['ICNO' => $this->icno, 'TAHUN' => $tahun])->one()->MARKAH;
        }
    }
    
    public static function latesttahuntempoh($icno){
        return Tblrscoapmtstatus::find()->where(['ICNO' => $icno, 'ApmtStatusCd' => [3,5]])->min('YEAR(ApmtStatusStDt)'); 
    }
    
    public function getStatuspp() {
        if ($this->status_pp == '6') {
            return '<span class="label label-warning">Menunggu</span>';
        }
        if ($this->status_pp == '4') {
            return '<span class="label label-success">Dipersetujui</span>';
        }
        if ($this->status_pp == '5') {
            return '<span class="label label-danger">Ditolak</span>';
        }
        if ($this->status_pp == '') {
            return '-';
        }
    }
    
    public function getViewstatuspp() {
        if ($this->status_pp == '4') {
            return 'Dipersetujui';
        }
        if ($this->status_pp == '5') {
            return 'Ditolak';
        }
    }
    
    public function getStatusjfpiu() {
        if ($this->status_jfpiu == '6') {
            return '<span class="label label-warning">Menunggu</span>';
        }
        if ($this->status_jfpiu == '4') {
            return '<span class="label label-success">Diperakui</span>';
        }
        if ($this->status_jfpiu == '5') {
            return '<span class="label label-danger">Ditolak</span>';
        }
    }
    
    public function getViewstatusjfpiu() {
        if ($this->status_jfpiu == '4') {
            return 'Diperakui';
        }
        if ($this->status_jfpiu == '5') {
            return 'Ditolak';
        }
    }
    
    public function getStatusbsm() {
        if ($this->status_bsm == '6') {
            return '<span class="label label-warning">Menunggu</span>';
        }
        if ($this->status_bsm == '4') {
            return '<span class="label label-success">Diluluskan</span>';
        }
        if ($this->status_bsm == '5') {
            return '<span class="label label-danger">Ditolak</span>';
        }
    }
    
    public function getViewstatusbsm() {
        if ($this->status_bsm == '4') {
            return 'Diluluskan';
        }
        if ($this->status_bsm == '5') {
            return 'Ditolak';
        }
    }
    
    public function getStatusdekan() {
        if($this->tarikh_m == ''){
            return "<span class='label' style='background-color:black'>Haven't applied</span>";
        }
        elseif ($this->status_jfpiu == '6' || $this->status_jfpiu == '12' || $this->status_jfpiu == '' || $this->status_jfpiu == '13') {
            return '<span class="label label-warning">Pending</span>';
        }
        elseif ($this->status_jfpiu == '4') {
            return '<span class="label label-success">Approved</span>';
        }
        elseif ($this->status_jfpiu == '5') {
            return '<span class="label label-danger">Rejected</span>';
        }
        elseif ($this->status_jfpiu == '14') {
            return '<span class="label label-info">Returned</span>';
        }
    }
    
    public function getViewstatusdekan() {
        if ($this->status_jfpiu == '4') {
            return 'Approved';
        }
        if ($this->status_jfpiu == '5') {
            return 'Rejected';
        }
    }
    
    public function getStatuskp() {
        if($this->tarikh_m == ''){
            return "<span class='label' style='background-color:black'>Haven't applied</span>";
        }
        elseif ($this->status_pp == '6' || $this->status_pp == '12' || $this->status_pp == '13') {
            return '<span class="label label-warning">Pending</span>';
        }
        elseif ($this->status_pp == '4') {
            return '<span class="label label-success">Approved</span>';
        }
        elseif ($this->status_pp == '5') {
            return '<span class="label label-danger">Rejected</span>';
        }
        elseif ($this->status_pp == '14') {
            return '<span class="label label-info">Returned</span>';
        }
    }
    
    public function getViewstatusketuaprogram() {
        if ($this->status_pp == '4') {
            return 'Approved';
        }
        if ($this->status_pp == '5') {
            return 'Rejected';
        }
    }
    
    public function getStatusbsmakademik() {
        
        if ($this->status_bsm == '7') {
            return '<span class="label label-danger">Resignation</span>';
        }
        elseif ($this->status_bsm == '15') {
            return '<span class="label label-danger">Completion of service</span>';
        }
        elseif($this->tarikh_m == ''){
            return "<span class='label' style='background-color:black'>Haven't applied</span>";
        }
        elseif ($this->status_bsm == '6' || $this->status_bsm == '12') {
            return '<span class="label label-warning">Pending</span>';
        }
        elseif ($this->status_bsm == '4') {
            return '<span class="label label-success">Approved</span>';
        }
        elseif ($this->status_bsm == '5') {
            return '<span class="label label-danger">Rejected</span>';
        }
        elseif ($this->status_bsm === NULL) {
            return '-';
        }
    }
    
    public function getViewstatusbsmakademik() {
        if ($this->status_bsm == '4') {
            return 'Approved';
        }
        if ($this->status_bsm == '5') {
            return 'Rejected';
        }
    }
    
    public function getStatuspentadbiran() {
        if ($this->status == '1') {
            return '<span class="label label-warning">Dalam Tindakan KP</span>';
        }
        if ($this->status == '2') {
            return '<span class="label label-info">Dalam Tindakan KJ</span>';
        }
        if ($this->status == '3') {
            return '<span class="label label-primary">Dalam Tindakan BSM</span>';
        }
        if ($this->status == '4') {
            return '<span class="label label-success">Berjaya</span>';
        }
        if ($this->status == '5') {
            return '<span class="label label-danger">Ditolak</span>';
        }
        if ($this->status == '') {
            return '-';
        }
    }
    
    public function getStatusakademik() {
        if ($this->status == '4') {
            return '<span class="label label-success">APPROVED</span>';
        }
        elseif ($this->status == '5') {
            return '<span class="label label-danger">REJECTED</span>';
        }
        elseif ($this->status == '1') {
            return '<span class="label label-warning">'.$this->firstapp.'</span>';
        }
        elseif ($this->status == '2') {
            return '<span class="label label-default">'.$this->secondapp.'</span>';
        }
        elseif ($this->status == '3') {
            return '<span class="label label-primary">HUMAN RESOURCES DIVISION</span>';
        }
        elseif ($this->status == '14' && $this->status_jfpiu == '14') {
            return '<span class="label label-info">RETURNED</span>';
        }
        if ($this->status == '') {
            return '-';
        }
    }
    
    public function kehadiran($year, $type, $status = null) {
        $val = 0;
        $icno = $this->icno;
        $staff_keselamatan = \app\models\keselamatan\TblStaffKeselamatan::find()->where(['staff_icno' => $this->icno])->andWhere(['=', 'isExcluded', '0'])->exists();

        if ($staff_keselamatan) {
            $sql = \app\models\keselamatan\TblRekod::find()->where('icno="'.$icno.'" AND YEAR(tarikh)='.$year);
         
        $status=='approve'? $sql->andWhere(['remark_status' => 'APPROVED']):$sql->andWhere(['<>','remark_status' ,'APPROVED']);
        
        if ($type == 1) {
            $sql->andWhere('status_in IS NOT NULL');}

         elseif ($type == 2) {
             $sql->andWhere('status_out IS NOT NULL'); }

         elseif ($type == 3) {
             $sql->andWhere('incomplete = 1'); }

         elseif ($type == 4) {
             $sql->andWhere('absent = 1');}

         elseif ($type == 5) {
             $sql->andWhere('external = 1'); }

        } 
        
        else {
            
        $sql = TblRekod::find()->where('icno="'.$icno.'" AND YEAR(tarikh)='.$year);
        
      
        $status=='approve'? $sql->andWhere(['remark_status' => 'APPROVED']):$sql->andWhere(['<>','remark_status' ,'APPROVED']);
        
        if ($type == 1) {
            $sql->andWhere(['late_in' => 1]);}

        elseif ($type == 2) {
            $sql->andWhere(['early_out' => 1]);}

        elseif ($type == 3) {
            $sql->andWhere(['incomplete' => 1]);}

        elseif ($type == 4) {
            $sql->andWhere(['absent' => 1]);}

        elseif ($type == 5) {
            $sql->andWhere(['external' => 1]);}
        }
        
        if ($sql) {
            $val = count($sql->all());
        }
        return $val;
    }
    
    public function getTempoh(){
        $model = Tblrscoapmtstatus::find()->where(['ICNO' => $this->icno, 'ApmtStatusCd' => [3,5]])->min('ApmtStatusStDt');
        $date1= date_create($model);
        $date2= $this->job_category == 2? date_create($this->kakitangan->endDateLantik):date_create($this->endDateLantik);
        $tempoh = date_diff($date1, $date2)->format('%y Tahun %m Bulan');
        //$tempoh = round($tempo/365, 1);
        return $tempoh;
    }
    
    public function getTempohkontraksemasa(){
        $date1= $this->job_category == 2? date_create($this->kakitangan->startDateLantik): date_create($this->startDateLantik);
        $date2= $this->job_category == 2? date_create($this->kakitangan->endDateLantik): date_create($this->endDateLantik);
        $date2->modify('+1 day');
        $tempoh = date_diff($date1, $date2)->format('%y Tahun %m Bulan');
        //$tempoh = round($tempo/365, 1);
        return $tempoh;
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
    public function getStartdatelantik() {
        return  $this->job_category == 2 ? $this->getTarikh($this->kakitangan->startDateLantik) : date_format(date_create($this->startDateLantik), "d M Y");
    }
    public function getEnddatelantik() {
        return $this->job_category == 2 ? $this->getTarikh($this->kakitangan->endDateLantik) : date_format(date_create($this->endDateLantik), "d M Y");
    }
    public function getTarikhmohon() {
        if($this->tarikh_m!=''){
            return $this->job_category == 2 ? $this->getTarikh($this->tarikh_m) : date_format(date_create($this->tarikh_m), "d M Y");
            }
    }
    public function getTarikhkj() {
        if($this->app_date!=''){
        return $this->job_category == 2 ? $this->getTarikh($this->app_date) : date_format(date_create($this->app_date), "d M Y");
            }
    }
    public function getTarikhpp() {
        if($this->ver_date!=''){
        return $this->job_category == 2 ? $this->getTarikh($this->ver_date) : date_format(date_create($this->ver_date), "d M Y");
            }
    }
    public function getTarikhbsma() {
        if($this->bsma_date!=''){
        return date_format(date_create($this->bsma_date), "d M Y");
         }
    }
    public function getTarikhlulus() {
        if($this->lulus_date!=''){
        return $this->getTarikh($this->lulus_date);}
    }
    public function getStaffidreportsmbu(){
        if(VwStaffProfile::find()->where(['sm_ic_no' => $this->icno])->exists()){
            return VwStaffProfile::find()->where(['sm_ic_no' => $this->icno, 'sm_staff_status' => '01'])->one()->sm_staff_id;
        }
        else{
        return $this->kakitangan->COOldID;
        }
    }
    public function getGajipokok(){
        $gaji = DboMonthlyPayroll::find()->where(['MP_PROCESS' => '1', 'MP_STAFF_ID' => $this->staffidreportsmbu])->one();
        return $gaji->MP_BASIC_PAY;
    }
    public function getJumlahelaun(){
        $gaji = DboMonthlyPayroll::find()->where(['MP_PROCESS' => '1', 'MP_STAFF_ID' => $this->staffidreportsmbu])->one();
//        $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->staffidreportsmbu])->max('MPH_PAY_MONTH');
//        return ViewPayroll::find()->where(['it_income_desc' => 'GAJI POKOK', 'MPH_PAY_MONTH' => $model, 'MPH_STAFF_ID' => $this->staffidreportsmbu])->one()->MPH_TOTAL_ALLOWANCE;
        return $gaji->MP_TOTAL_ALLOWANCE - $gaji->MP_BASIC_PAY;
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
        $model = Kontrak::find()->where(['ver_by' => $icno, 'status' => '1'])->orWhere(['app_by' => $icno, 'status' => '2','job_category'=>$category])->all();
        if ($model) {
            $total = count($model);
        }
        }
        else{
            $total = count($model = Kontrak::find()->where(['ver_by' => $icno, 'status' => '1'])->orWhere(['app_by' => $icno, 'status' => '2'])->all());
        }
        
        if ($total > 0) {
                return '&nbsp;<span class="badge bg-red">'.$total.'</span>';
            }
        else {
                return '';
        }
    }
    
    public static function totalPendingtask($icno, $category) {

        $total = 0;
        $model = Kontrak::find()->where(['ver_by' => $icno, 'status' => '1','job_category'=>$category])->orWhere(['app_by' => $icno, 'status' => '2','job_category'=>$category])->all();
        if ($model) {
            $total = count($model);
        }
        return $total;
    } 
    public function getLayaktempohakademik(){
            return ArrayHelper::map(RefTempoh::find()->where(['job_category' => '1'])->all(), 'tempoh', 'tempoh');
        
    }
    
    public function getLayaktempohpentadbiran(){
        
        if($this->sesi_id == 4){
            return ArrayHelper::map(RefTempoh::find()->where(['job_category' => '2'])->all(), 'tempoh', 'tempoh');
        }
        elseif($this->markahlnpt(date('Y')-1) >=85){
            return ArrayHelper::map(RefTempoh::find()->where(['job_category' => '2'])->all(), 'tempoh', 'tempoh');
        }
        else{
            return ArrayHelper::map(RefTempoh::find()->where(['id' => 1])->orWhere(['id' =>3])->all(), 'tempoh', 'tempoh');
        }
    }
    
    public function getKelayakantempohakademik(){
        if(substr($this->kakitangan->jawatan->gred, 5) != 'UMSDF' && $this->kakitangan->umur >= '65'){
            return '1 Tahun';
        }
        else{
            return '3 Tahun';
        }
    }
    
    public function getKelayakantempohpentadbiran(){
        if($this->markahlnpt(date('Y')-1) >=85){
                        return '2 Tahun';
                    }
                    else{
                        return '1 Tahun';
                    }
    }
    
    public function getDokumen(){
        return $this->hasMany(TblSurat::className(), ['kontrak_id' => 'id']);
    }
    
    public function getIcnoketuajfpiu1(){
        if($this->kakitangan->adminPositionactive){
            if($this->kakitangan->departmentHakiki->sub_of == '' || $this->kakitangan->departmentHakiki->sub_of == '12'){
                $icno = $this->kakitangan->departmentHakiki->chief;
            }
            else{
                $pegawaisub = Department::findOne(['id' => $this->kakitangan->departmentHakiki->sub_of]);
                $icno = $pegawaisub->chief; 
            }
        }
        else{
            if($this->kakitangan->department->sub_of == '' || $this->kakitangan->department->sub_of == '12'){
                $icno = $this->kakitangan->department->chief;
            }
            else{
                $pegawaisub = Department::findOne(['id' => $this->kakitangan->department->sub_of]);
                $icno = $pegawaisub->chief;}
        }
        
        return $icno;
    }
    
    
    
    public function getFirstapp(){
        if($this->icno == $this->icnoketuajfpiu1){
            return '';
        }
        else{
            return 'Head of Program';
        }
    }
    
    public function getSecondapp(){
        if($this->icno == $this->icnoketuajfpiu1){
            return 'Approver';
        }
        else{
            return 'Head of Department';
        }
    }
    
    public function getIcnoketuajfpiu(){
        
        if($this->icno == $this->icnoketuajfpiu1){
            $icno = '680114125023';
        }
        else{
            $icno = $this->icnoketuajfpiu1;
        }
        return $this->app_by? :$icno;
    }
    
    public function getKetuajfpiu(){
        return $this->icnoketuajfpiu? Tblprcobiodata::find()->where(['ICNO' => $this->icnoketuajfpiu])->one()->CONm:'-';
    }
    
    public function getIcnoketuaprogram(){
        $id = $this->kakitangan->adminPositionactive? $this->kakitangan->DeptId_hakiki: $this->kakitangan->DeptId;
        
        if($this->icno == $this->icnoketuajfpiu1){
            $icno = '';
        }
        elseif($id == 138){
            $model = TblKetuafpsk::find()->where(['jabatan' => $this->kakitangan->programPengajaran->jabatan_fpsk])->one();
            $icno = $model? $model->icno : '';
        }
        else{
            $model = Tblrscoadminpost::find()->where(['program_id' => $this->kakitangan->KodProgram, 'flag' => 1])->orderBy(['end_date' => SORT_DESC])->one();
            $icno = $model? $model->ICNO : '';
        }
        
        return $this->ver_by? :$icno;
    }
    
    
    
    public function getKetuaprogram(){
        return $this->icnoketuaprogram? Tblprcobiodata::find()->where(['ICNO' => $this->icnoketuaprogram])->one()->CONm : '-';
    }
    
    public function getAppbiodata(){
        return Tblprcobiodata::find()->where(['ICNO' => $this->app_by])->one();
    }
    
    public function getVerbiodata(){
        return Tblprcobiodata::find()->where(['ICNO' => $this->ver_by])->one();
    }
    
    public function getElnptkreditmengajar(){
        $jumlah = 0;
        if ($this->elnpt) { 
        foreach ($this->elnpt as $lppid){
            $model = \app\models\elnpt\TblPengajaranPembelajaran::find()->where(['lpp_id' => $lppid->lpp_id])->all();
            foreach ($model as $l){
                if((substr($l->sesi, -9) > $this->sesimulakontrak || (substr($l->sesi, -9) == $this->sesimulakontrak && substr($l->sesi,0,1) >= $this->semmulakontrak))&& $l->pppsah->sah_ppp == '1'){
                    $jumlah = $jumlah+$l->jam_kredit;
                }
            }
        }
                }
                
        return $jumlah;
    }
    
    public function getElnptpelajar(){
        $jumlah = 0;
        if ($this->elnpt) { 
        foreach ($this->elnpt as $lppid){
            $model = \app\models\elnpt\TblPengajaranPembelajaran::find()->where(['lpp_id' => $lppid->lpp_id])->all();
            foreach ($model as $l){
                if((substr($l->sesi, -9) > $this->sesimulakontrak || (substr($l->sesi, -9) == $this->sesimulakontrak && substr($l->sesi,0,1) >= $this->semmulakontrak))&& $l->pppsah->sah_ppp == '1'){
                    $jumlah = $jumlah+$l->bil_pelajar;
                }
            }
        }
                }
                
        return $jumlah;
    }
    
    public function getJumlahKreditMengajar() {
        $jumlah=0;
        foreach ($this->pengajaran as $l) {
            if(substr($l->SESI, -9) > $this->sesimulakontrak || (substr($l->SESI, -9) == $this->sesimulakontrak && substr($l->SESI,0,1) >= $this->semmulakontrak)){
            $jumlah = $jumlah+$l->JAMKREDIT; }
            }
        return $jumlah+$this->elnptkreditmengajar;
    }
    
    public function getJumlahPelajar() {
        $jumlah = 0;
        
        foreach($this->pengajaran as $l){
            if((substr($l->SESI, -9) > $this->sesimulakontrak || (substr($l->SESI, -9) == $this->sesimulakontrak && substr($l->SESI, 0,1) >= $this->semmulakontrak))){
            $jumlah = $jumlah + $l->BILPELAJAR;}
        }
            
        if ($this->elnpt) { 
        foreach ($this->elnpt as $lppid){
            $pengajaranelnpt1 = \app\models\elnpt\TblPengajaranPembelajaran::find()->where(['lpp_id' => $lppid->lpp_id])->all();
           
            if($pengajaranelnpt1){
            foreach ($pengajaranelnpt1 as $l){
                if($l->pppsah->sah_ppp == '1' && (substr($l->sesi, -9) > $this->sesimulakontrak || (substr($l->sesi, -9) == $this->sesimulakontrak && substr($l->sesi, 0,1) >= $this->semmulakontrak))){
                    if($pnp){$cekp = array_filter($pnp, function ($var) use ($l){
                    return $var['SMP07_KodMP'] == $l->kod_kursus && $var['SESI'] == $l->semester && $var['BILPELAJAR'] == $l->bil_pelajar;
                    }); }

                    if(!$cekp){
                        $jumlah = $jumlah + $l->bil_pelajar;
                    }
            }}}
            else{
            
            $pengajaranelnpt2 = \app\models\elnpt\elnpt2\TblPengajaranPembelajaran::find()->where(['lpp_id' => $lppid->lpp_id])->all();
                                            
                foreach ($pengajaranelnpt2 as $p) {
                        $l = \app\models\elnpt\elnpt2\TblPnP::find()->where(['id_pnp' => $p->id])->one();
                        $do = \app\models\elnpt\elnpt2\TblDocuments::find()->where(['id_table' => $p->id, 'bhg_no' => 1])->one();
                if((substr($l->semester, -9) > $this->sesimulakontrak || (substr($l->semester, -9) == $this->sesimulakontrak && substr($l->semester, 0,1) >= $this->semmulakontrak))&& $do->verified_by){
                    if($pnp){$cekp = array_filter($pnp, function ($var) use ($p, $l){
                    return $var['SMP07_KodMP'] == $p->kod_kursus && $var['SESI'] == $l->semester && $var['BILPELAJAR'] == $l->bil_pelajar;
                    }); }
                if(!$cekp){
                        $jumlah = $jumlah + $l->bil_pelajar;
                    }
                
        }}}}
                }
                
        return $jumlah;
    
    }
    
    public function getJumlahGeranPenyelidikUtama() {
        return Penyelidikan::find()->where(['IC' => $this->icno, 'Membership' => 'Leader'])->andWhere(['>=','EndDate',$this->startDateLantik])->count();
    }
    
    public function getJumlahGeranPenyelidikBersama() {
        return Penyelidikan::find()->where(['IC' => $this->icno, 'Membership' => 'Member'])->andWhere(['>=','EndDate',$this->startDateLantik])->count();
    }
    
    public function getJumlahRmPenyelidikUtama() {
        return Penyelidikan::find()->where(['IC' => $this->icno, 'Membership' => 'Leader'])->andWhere(['>=','EndDate',$this->startDateLantik])->sum('Amount');
    }
    
    public function getJumlahRmPenyelidikBersama() {
        return Penyelidikan::find()->where(['IC' => $this->icno, 'Membership' => 'Member'])->andWhere(['>=','EndDate',$this->startDateLantik])->sum('Amount');
    }
    
    public function getJumlahJurnal() {
        return TblLnptPublicationV2::find()->where(['User_Ic' => $this->icno, 'Keterangan_PublicationTypeID' => ['Article in Mass Media/Magazine', 'Article']])->andWhere(['>=', 'PublicationYear', $this->tahunmulakontrak])->count();
       
    }
    
    public function jumlahJurnalbyyear($year) {
        return TblLnptPublicationV2::find()->where(['User_Ic' => $this->icno, 'Keterangan_PublicationTypeID' => ['Article in Mass Media/Magazine', 'Article']])->andWhere(['>=', 'PublicationYear', $year])->count();
       
    }
    
    public function jumlahBukubyyear($year) {
        return TblLnptPublicationV2::find()->where(['User_Ic' => $this->icno, 'Keterangan_PublicationTypeID' => ['Book (Collection of Personal Essays)', 'Book (Short stories)',
            'General Book', 'Scientific Book']])->andWhere(['>=', 'PublicationYear', $year])->count();
    }
    
    public function jumlahBabDalamBukubyyear($year) {
        return TblLnptPublicationV2::find()->where(['User_Ic' => $this->icno, 'Keterangan_PublicationTypeID' => 'Chapter(s) in Book'])->andWhere(['>=', 'PublicationYear', $year])->count();
    }
    
    public function jumlahPenerbitanfirstcorrespondingbyyear($year) {
         return TblLnptPublicationV2::find()->where(['User_Ic' => $this->icno, 'KeteranganBI_WriterStatus' => ['First Author', 'Corresponding Author'],
             'Keterangan_PublicationTypeID' => ['Article in Mass Media/Magazine', 'Article']])->andWhere(['>=', 'PublicationYear', $year])->count();
    }
    
    public function getJumlahPenerbitanfirstcorresponding() {
         return TblLnptPublicationV2::find()->where(['User_Ic' => $this->icno, 'KeteranganBI_WriterStatus' => ['First Author','Corresponding Author'],
             'Keterangan_PublicationTypeID' => ['Article in Mass Media/Magazine', 'Article']])->andWhere(['>=', 'PublicationYear', $this->tahunmulakontrak])->count();
    }
    
    public function getJumlahBuku() {
        return TblLnptPublicationV2::find()->where(['User_Ic' => $this->icno, 'Keterangan_PublicationTypeID' => ['Book (Collection of Personal Essays)', 'Book (Short stories)',
            'General Book', 'Scientific Book']])->andWhere(['>=', 'PublicationYear', $this->tahunmulakontrak])->count();
    }
    
    public function getJumlahBabDalamBuku() {
        return TblLnptPublicationV2::find()->where(['User_Ic' => $this->icno, 'Keterangan_PublicationTypeID' => 'Chapter(s) in Book'])->andWhere(['>=', 'PublicationYear', $this->tahunmulakontrak])->count();
    }
    
    public function getJumlahPenerbitanPenulisUtama() {
         return TblLnptPublicationV2::find()->where(['User_Ic' => $this->icno, 'KeteranganBI_WriterStatus' => 'First Author',
             'Keterangan_PublicationTypeID' => ['Book (Collection of Personal Essays)', 'Book (Short stories)',
            'General Book', 'Scientific Book', 'Chapter(s) in Book', 'Article in Mass Media/Magazine', 'Article']])->andWhere(['>=', 'PublicationYear', $this->tahunmulakontrak])->count();
    }
    
    public function getJumlahPenyeliaanPhd() {
        $jumlah=0;
        foreach ($this->penyeliaan as $l) {
            if((substr($l->KodSesi_Sem, -9) > $this->sesimulakontrak || (substr($l->KodSesi_Sem, -9) == $this->sesimulakontrak && substr($l->KodSesi_Sem, 1) >= $this->semmulakontrak))&& $l->LevelPengajian==='PHD'){
               $jumlah++; 
            }
            }
        return $jumlah;
    }
    
    public function getJumlahPenyeliaanMaster() {
        $jumlah=0;
        foreach ($this->penyeliaan as $l) {
            if((substr($l->KodSesi_Sem, -9) > $this->sesimulakontrak || (substr($l->KodSesi_Sem, -9) == $this->sesimulakontrak && substr($l->KodSesi_Sem, 1) >= $this->semmulakontrak))&& $l->LevelPengajian==='MASTER'){
               $jumlah++; 
            }
            }
        return $jumlah;
    }
    
    public function getJumlahPerundingan() {
        return Perundingan::find()->where(['ICNo' => $this->icno])->andWhere(['>=','EndDate',$this->startDateLantik])->count();
        
    }
    
    //idp
    
    public function mataidp($year, $kod){
        $jumlahMata = 0;
        $model = IdpMata::find()
                ->where(['staffID' => $this->icno])
                ->andWhere(['tahun' => $year])
                ->one();
        
        if($year!='2020'){
            $model2 = VCpdLatihan::find()
        ->where("vcl_id_staf = '$this->icno' and vcl_kod_kompetensi = $kod and SUBSTRING(vcl_tkh_mula,1,4) = $year and hantar_penilaian = 1")
        ->all();
        foreach ($model2 as $model) {
        $jumlahMata = $jumlahMata + $model->vcl_jum_mata;
        }
            return $jumlahMata;
        }
        else{if($kod===3){
            return $model->mataTeras;
        }
        elseif($kod===4){
            return $model->mataElektif;
        }
        elseif($kod===1){
            return $model->mataUmum;
        }}
    }
    
    public function mataminidp($year, $round) {
        $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $this->kakitangan->jawatan->gred])->one();
        $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $modelcpdgroupgj->cpdgroup])->one();
        if($this->job_category===2){
        return Idp::findOne(['v_co_icno' => $this->icno, 'tahun' => $year])->v_matamin_teras_uni;}
        else{
            return 
                round($round*($modelcpdgroup->mataMin));
        }
    }
    
    public function peratusidp($kod, $round, $year){
        if ($this->mataidp($year, $kod) >= $this->mataminidp($year, $round)) {
                $peratus = 100;
            } else {
                $peratus = round(($this->mataidp($year, $kod) >= $this->mataminidp($year, $round)) * 100);
            }
        return $peratus;
    }
    
    public function progressbarcolor($val){
                if($val===100){
                    $eprogressBarColour = 'progress-bar progress-bar-success';
                }
                elseif ($val >= 50){
                    $eprogressBarColour = 'progress-bar progress-bar-striped';
                } else {
                    $eprogressBarColour = 'progress-bar progress-bar-danger';
                }
        return $eprogressBarColour;
    }
    
    public function getCadanganjawatan($role = null){
        
        if($role == 'bsm'){
            if($this->id == 747){
                return array('PROFESOR GRED KHAS C VK7' => 'PROFESOR GRED KHAS C VK7');
            }
           return array(strtoupper($this->kakitangan->jawatan->namaenglish." ".$this->kakitangan->jawatan->gred) => strtoupper($this->kakitangan->jawatan->namaenglish." ".$this->kakitangan->jawatan->gred))+
            ArrayHelper::map(RefCadanganjawatan::find()->all(), 'nama', 'nama');
         
        }
        elseif (strpos($this->kakitangan->jawatan->nama, 'Profesor Madya') !== false){
            return array(strtoupper($this->kakitangan->jawatan->namaenglish." ".$this->kakitangan->jawatan->gred) => strtoupper($this->kakitangan->jawatan->namaenglish." ".$this->kakitangan->jawatan->gred))+
            ArrayHelper::map(RefCadanganjawatan::find()->where(['setara' => 'Profesor Madya'])->all(), 'nama', 'nama');
        }
        elseif (strpos($this->kakitangan->jawatan->nama, 'Profesor') !== false){
            return array(strtoupper($this->kakitangan->jawatan->namaenglish." ".$this->kakitangan->jawatan->gred) => strtoupper($this->kakitangan->jawatan->namaenglish." ".$this->kakitangan->jawatan->gred))+
            ArrayHelper::map(RefCadanganjawatan::find()->where(['setara' => 'Profesor'])->all(), 'nama', 'nama');
        }
        elseif (strpos($this->kakitangan->jawatan->nama, 'Pensyarah') !== false){
            return array(strtoupper($this->kakitangan->jawatan->namaenglish." ".$this->kakitangan->jawatan->gred) => strtoupper($this->kakitangan->jawatan->namaenglish." ".$this->kakitangan->jawatan->gred))+
            ArrayHelper::map(RefCadanganjawatan::find()->where(['setara' => 'Pensyarah'])->all(), 'nama', 'nama');
        }
        else{
            return array(strtoupper($this->kakitangan->jawatan->namaenglish." ".$this->kakitangan->jawatan->gred) => strtoupper($this->kakitangan->jawatan->namaenglish." ".$this->kakitangan->jawatan->gred));
        }
    }
    
     public static function formatdate($tarikh){
        
        $m = date_format(date_create($tarikh), "m");
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
          
        return date_format(date_create($tarikh), "d").' '.$m.' '.date_format(date_create($tarikh), "Y");
    }
    
    public function getOfferletter(){
        $m = TblSurat::find()->where(['kontrak_id' => $this->id])->andWhere('tajuk LIKE "SURAT TAWARAN%" OR tajuk LIKE "OFFER LETTER%"')->one();
    
        return $m? $m->dokumen:'';
    }

    public function getKategoriStars()
    {
        return TblWarnaKad::prestasiWarnaKad(date('Y') - 1,$this->icno);

    }

    public function getKategoriLnpt()
    {
        $kat = '-';

        if ($this->markahlnpt(date('Y') - 1)) {
            $tahun = $this->markahlnpt(date('Y') - 1);

            $kat = self::getKatLnpt($tahun);
        }

        return $kat;
    }

    public static function getKatLnpt($tahun)
    {
        if($tahun >= 85) {
            $kat = '85% & ke atas';
        } else if ($tahun >= 80 && $tahun <= 84.99) {
            $kat = '80% hingga 84.99%';
        } else if ($tahun <= 79.99 && $tahun >= 75) {
            $kat = '75% hingga 79.99%';
        } else if ($tahun <= 74.99 && $tahun >= 70) {
            $kat = '70% hingga 74.99%';
        } else {
            $kat = '69% & ke bawah';
        }

        return $kat;
    } 

    public function getUmur()
    {
        $interval = date_diff(date_create(), date_create($this->kakitangan->COBirthDt));
        return $interval->format("%Y Tahun, %M Bulan, %d Hari");
    }

    public function getUmurTamatKontrak()
    {
        $interval = date_diff(date_create($this->endDateLantik), date_create($this->kakitangan->COBirthDt));
        return $interval->format("%Y Tahun, %M Bulan, %d Hari");
    }
}
