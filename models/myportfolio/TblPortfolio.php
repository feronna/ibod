<?php

namespace app\models\myportfolio;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\hronline\GredJawatan;
use app\models\myportfolio\TblAkauntabiliti;
use app\models\hronline\Kumpkhidmat;
use Yii;
use app\models\cuti\SetPegawai;
use app\models\kontrak\Kontrak;
use app\models\elnpt\TblMain;
use app\models\kehadiran\TblRekod;
use app\models\myportfolio\TblNaziran;
use app\models\myportfolio\AksesPenyelia;
use app\models\hronline\TblPenempatan;
/**
 * This is the model class for table "myportfolio.tbl_portfolio".
 *
 * @property int $id
 * @property string $icno
 * @property int $gred
 * @property string $jawatan
 * @property string $status_jawatan
 * @property int $jabatan_semasa
 * @property string $name
 * @property string $gelaran_jawatan
 * @property string $ringkasan_gelaran
 * @property string $hirarki_2
 * @property string $skim_perkhidmatan
 * @property string $bidang_utama
 * @property string $sub_bidang
 * @property string $kp
 * @property string $kp_agree
 * @property string $perakuan_kp
 * @property string $tarikh_perakuan_kp
 * @property string $kj
 * @property string $kj_agree
 * @property string $perakuan_kj
 * @property string $tarikh_perakuan_kj
 * @property string $kata_kerja
 * @property string $penerangan
 * @property string $kepada_sesuatu
 * @property string $object
 * @property string $tujuan
 * @property string $created_at
 * @property string $waran
 * @property string $gred_jawatan
 * @property string $status
 * @property string $status_ptb
 * @property string $status_hantar
 * @property string $tarikh_hantar
 */
class TblPortfolio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_tbl_portfolio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gred', 'jabatan_semasa'], 'integer'],
            [['tarikh_perakuan_kp', 'tarikh_hantar'], 'safe'],
            [['icno', 'kp', 'kj'], 'string', 'max' => 12],
            [['jawatan', 'name', 'gelaran_jawatan', 'ringkasan_gelaran', 'hirarki_2', 'skim_perkhidmatan', 'perakuan_kp', 'gred_jawatan', 'status'], 'safe'],
            [['status_jawatan', 'created_at', 'waran', 'status_ptb'], 'string', 'max' => 20],
            [['bidang_utama', 'sub_bidang', 'perakuan_kj'], 'safe'],
            [['kp_agree', 'kj_agree', 'status_hantar'], 'string', 'max' => 5],
            [['tarikh_perakuan_kj'], 'string', 'max' => 10],
           // [['penerangan', 'object', 'tujuan'], 'string', 'max' => 500],
            [['ringkasan_gelaran','gred_jawatan', 'bidang_utama', 'sub_bidang', 'hirarki_2'],'required','message' => Yii::t('app', 'Wajib Diisi')],
           // [['penerangan', 'kata_kerja', 'object'],'required','message' => Yii::t('app', 'Wajib Diisi')],
           // [['tujuan'],'required','message' => Yii::t('app', 'Wajib Diisi')],
             [['kata_kerja'],'required','message' => Yii::t('app', 'Wajib Diisi')],
             [['object'],'required','message' => Yii::t('app', 'Wajib Diisi')],
             [['tujuan'],'required','message' => Yii::t('app', 'Wajib Diisi')],
           //  [['kategori_jawatan', 'kumpulan_jawatan'], 'integer'],

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
            'gred' => 'Gred',
            'jawatan' => 'Jawatan',
            'status_jawatan' => 'Status Jawatan',
            'jabatan_semasa' => 'Jabatan Semasa',
            'name' => 'Name',
            'gelaran_jawatan' => 'Gelaran Jawatan',
            'ringkasan_gelaran' => 'Ringkasan Gelaran',
            'hirarki_2' => 'Hirarki 2',
            'skim_perkhidmatan' => 'Skim Perkhidmatan',
            'bidang_utama' => 'Bidang Utama',
            'sub_bidang' => 'Sub Bidang',
            'kp' => 'Kp',
            'kp_agree' => 'Kp Agree',
            'perakuan_kp' => 'Perakuan Kp',
            'tarikh_perakuan_kp' => 'Tarikh Perakuan Kp',
            'kj' => 'Kj',
            'kj_agree' => 'Kj Agree',
            'perakuan_kj' => 'Perakuan Kj',
            'tarikh_perakuan_kj' => 'Tarikh Perakuan Kj',
            'kata_kerja' => 'Kata Kerja',
            'penerangan' => 'Penerangan',
            'object' => 'Object',
            'tujuan' => 'Tujuan',
            'created_at' => 'Created At',
            'waran' => 'Waran',
            'gred_jawatan' => 'Gred Jawatan',
            'status' => 'Status',
            'status_ptb' => 'Status Ptb',
            'status_hantar' => 'Status Hantar',
            'tarikh_hantar' => 'Tarikh Hantar',
        ];
    }
    
      public function getApplicant(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
      public function getKakitangan(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getPenempatan(){
        return $this->hasOne(Tblpenempatan::className(), ['ICNO' => 'icno'])->orderBy(['tblpenempatan.date_start' => SORT_DESC]);
    }
    
     public function getLantikan() {
        return $this->hasMany(Tblrscoapmtstatus::className(), ['ICNO' => 'icno']);
    }
    
     public function getDepartment(){
        return $this->hasOne(Department::className(), ['id' => 'jabatan_semasa']);
    }
    
       public function getKehadiran() {
        return $this->hasOne(\app\models\kontrak\TempKehadiran::className(), ['icno' => 'icno']);
    }
    
    
      public function getKontrak(){
        return $this->hasOne(Kontrak::className(), ['icno' => 'icno']);
    }
 
      public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['gred' => 'gred']);
    }
    
     public function getGredJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred']);
    }
    public function getJawatanss() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_jawatan']);
    }
       public function getHouses() {
        return $this->hasOne(TblAkauntabiliti::className(), ['portfolio_id' => 'id']);
    }
    
     public function getKumpKhidmat() {
        return $this->hasOne(Kumpkhidmat::className(), ['id' => 'skim_perkhidmatan']);
    }
    

     public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
       public function getTarikhs($bulan){
        
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
      public function getTarikhDokumen() {
        return  $this->getTarikhs($this->created_at);
    }
       public function getKetuaPerkhidmatan(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'kp']);
           
    }
        public function getKetuaJabatan(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'kj']);
           
    }
       public function getRujukan(){
       return $this->hasOne(SetPegawai::className(), ['pemohon_icno' => 'icno']);
    }
    
       public function getRefAkauntabiliti() {
        return $this->hasOne(RefAkauntabiliti::className(), ['id' => 'kata_kerja']);
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
        
        if($this->kategori_jawatan == '2'){
        $userid = \app\models\lppums\Lpp::find()->where(['PYD' => $this->icno, 'tahun' => $tahun])->one()->lpp_id;
        return \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $userid])->one()->markah_PP;}
        
        elseif($this->kategori_jawatan == '1'){
            if($tahun < 2019){
            $id = \app\models\elnpt\elnpt_lama\TblUser::find()->where(['user_id' => $this->icno])->one()->staff_id;
            return \app\models\elnpt\elnpt_lama\TblMarkahLama::find()->where(['staff_id' => $id, 'tahun' => $tahun])->one()->purata;
            }
            
           $markah = TblMain::find()->where(['PYD' => $this->icno, 'tahun'=>$tahun])->one()->sumMarkah;
           return $markah=='0'? '':$markah;
        }
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
     public function kehadiranRejected($year, $type) {
        $val = 0;
        $icno = $this->icno;
        if ($type == 1) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND late_in = 1 AND remark_status !="REJECTED"';
        }

        if ($type == 2) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND early_out = 1 AND remark_status !="REJECTED"';
        }

        if ($type == 3) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND incomplete = 1 AND remark_status !="REJECTED"';
        }

        if ($type == 4) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND absent = 1 AND remark_status !="REJECTED"';
        }

        if ($type == 5) {
            $sql = 'SELECT * FROM tbl_rekod WHERE icno=:icno AND YEAR(tarikh)=:year AND external = 1 AND remark_status !="REJECTED"';
        }

        $model = TblRekod::findBySql($sql, [':icno' => $icno, ':year'=>$year])->all();

        if ($model) {
            $val = count($model);
        }

        return $val;
    }
    
       public function getNaziran(){
       return $this->hasOne(TblNaziran::className(), ['icno' => 'icno']);
    }
    
       public function getGreds() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred']);
    }
     public function countBelumSelesai($kumpulan, $category) {

        $count = 0;
        $memo = TblPortfolio::find()->where(['status_hantar_portfolio' => 'null'])->all();

        foreach ($memo as $l) {
            $i[] = $l->penyelia;
        }
        
      
        if ($category == 0) { //keseluruhan
             $count = TblPortfolio::find()
//                    ->joinWith('pengajianLulus')
                   ->andWhere(['jabatan_semasa' => $kumpulan])
                    ->andWhere(['status_hantar_portfolio' => NULL])
                    ->count();
        }
        
        return $count;
    }
     public function countBelumCapai($kumpulan,$category) {

        $count = 0;
        
        $pd = TblPortfolio::find()->select('icno')->distinct('icno')->where(['status_hantar_portfolio'=> NULL])->asArray()->all();
        $icno_array = [];
        foreach($pd as $pd){
            
            array_push($icno_array,$pd['icno']);
        }
                if ($category == 0) { //keseluruhan

        $count = TblPortfolio::find()
               ->joinWith('applicant')
                                    ->where(['in', "tblprcobiodata.ICNO", $icno_array])

                   ->andWhere(['jabatan_semasa' => $kumpulan])
               ->andWhere(['<>','myjd_tbl_portfolio.status_hantar',1])
              
              ->groupBy('icno')
                ->count();
                }
        return $count;
    }
     public function countSelesai($kumpulan, $category) {

        $count = 0;
        $memo = TblPortfolio::find()->where(['status_hantar_portfolio' => 0])->all();

        foreach ($memo as $l) {
            $i[] = $l->penyelia;
        }
        
      
        if ($category == 0) { //keseluruhan
             $count = TblPortfolio::find()
//                    ->joinWith('pengajianLulus')

                    ->andWhere(['jabatan_semasa' => $kumpulan])
                    ->andWhere(['status_hantar_portfolio'=>1])
                    ->groupBy('icno')
                    ->count();
        }
        
        return $count;
    }
    
        public function getCartaJabatan() {
        return $this->hasOne(\app\models\portfolio\TblCartaJabatan::className(), ['icno' => 'icno']);
    }
   
    
}
