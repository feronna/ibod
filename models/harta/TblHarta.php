<?php

namespace app\models\harta;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Kumpulankhidmat;

class TblHarta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_tbl_harta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ADEdrsdBy', 'letter_sent', 'status_kj', 'status_pelulus', 'kategori', 'jawatan_id', 'DeptId', 'updated_at'], 'integer'],
            [['icno'], 'required'],
            [['FinclSrcTotalAmt', 'FinclSrcMthlyInstalmt'], 'number'],
            [['icno'], 'string', 'max' => 15],
            [['AssetOwnerNm'], 'string', 'max' => 80],
            [['jawatan', 'gred', 'jfpiu', 'jenis_permohonan', 'status', 'ADDeclDt', 'ADEdrsdRefNo', 'status_lantikan', 'tarikh_sandangan', 'tarikh_lantikan', 'ketua_jabatan', 'ADEdrsdDt', 'ulasan_kj', 'FinclSrcInstlmtStDt', 'FinclSrcInstlmtEndDt', 'tarikh_perakuan'], 'string', 'max' => 50],
            [['tarikh_mesyuarat'], 'string', 'max' => 12],
            [['ulasan_pelulus'], 'string', 'max' => 122],
            [['FinclSrcTypeCd'], 'string', 'max' => 2],
            [['FinclSrcRepaymtPeriod'], 'string', 'max' => 3],
        ];
    }
    
       public function beforeSave($insert)
    {
        $tmp = TblMesyuarat::find()->select(['tarikh_mesyuarat'])->orderBy(['id'=>SORT_DESC])->limit(1)->one();
        
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        $this->tarikh_mesyuarat = date('d M Y', strtotime ($tmp['tarikh_mesyuarat']));
        
        // ...custom code here...
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ADEdrsdBy' => 'Ad Edrsd By',
            'icno' => 'Icno',
            'AssetOwnerNm' => 'Asset Owner Nm',
            'jawatan' => 'Jawatan',
            'gred' => 'Gred',
            'jfpiu' => 'Jfpiu',
            'jenis_permohonan' => 'Jenis Permohonan',
            'status' => 'Status',
            'ADDeclDt' => 'Tarikh Dihantar',
            'ADEdrsdRefNo' => 'Ad Edrsd Ref No',
            'status_lantikan' => 'Status Lantikan',
            'tarikh_sandangan' => 'Tarikh Sandangan',
            'tarikh_lantikan' => 'Tarikh Lantikan',
            'ketua_jabatan' => 'Ketua Jabatan',
            'letter_sent' => 'Letter Sent',
            'ADEdrsdDt' => 'Tarikh Perakuan',
            'ulasan_kj' => 'Ulasan Kj',
            'status_kj' => 'Status Kj',
            'status_pelulus' => 'Status Pelulus',
            'tarikh_mesyuarat' => 'Tarikh Mesyuarat',
            'ulasan_pelulus' => 'Ulasan Pelulus',
            'kategori' => 'Kategori',
            'FinclSrcTypeCd' => 'Fincl Src Type Cd',
            'FinclSrcTotalAmt' => 'Fincl Src Total Amt',
            'FinclSrcRepaymtPeriod' => 'Fincl Src Repaymt Period',
            'FinclSrcMthlyInstalmt' => 'Fincl Src Mthly Instalmt',
            'FinclSrcInstlmtStDt' => 'Fincl Src Instlmt St Dt',
            'FinclSrcInstlmtEndDt' => 'Fincl Src Instlmt End Dt',
            'ADEdrsdDt' => 'ADEdrsdDt'
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
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y H:i:s A");
    }
    public function getTarikhPerakuan() {
        return  $this->getTarikh($this->tarikh_perakuan);
    }
    public function getTarikhDihantar() {
        return  $this->getTarikh($this->ADDeclDt);
    }
      public function getTarikhDisahkan() {
        return  $this->getTarikh($this->ADEdrsdDt);
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
     public function getTarikhMesyuarat() {
        return  $this->getTarikhs($this->tarikh_mesyuarat);
    }
    
     public function getKakitangan(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
      public function getKetua(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ketua_jabatan']);
    }
    
      public function getKategoriPemohon(){
        return $this->hasOne(Kumpulankhidmat::className(), ['id' => 'kategori']);
    }
    
       public function getStatusjfpiu() {
      
        if ($this->status_kj == '1') {
            return '<span class="label label-success">DIPERAKUI</span>';
        }
        if ($this->status_kj == '0') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
         else {
            return '<span class="label label-primary">MENUNGGU TINDAKAN</span>';
        }
    }
     public function getStatusKj() {
       
        if ($this->status_kj== '1') {
            return 'DIPERAKUI';
        }
        if ($this->status_kj == '0') {
            return 'DITOLAK';
        }
         else{
            return 'MENUNGGU TINDAKAN';
        }
    }
    
           public function getStatusPelulus() {
     
        if ($this->status_pelulus == '1') {
            return '<span class="label label-success">DILULUSKAN</span>';
        }
        if ($this->status_pelulus == '0') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
           if ($this->status_pelulus == NULL) {
            return '<span class="label label-primary">MENUNGGU TINDAKAN</span>';
        }
    }
     public function getJenisPermohonan() {
        if ($this->jenis_permohonan == '1') {
            return 'Permohonan Baharu';
        }
        if ($this->jenis_permohonan ==  '2') {
            return 'Pertambahan Harta';
        }
        if ($this->jenis_permohonan ==  '3') {
            return 'Pelupusan Harta';
        }
         if ($this->jenis_permohonan ==  '4') {
            return 'Tiada Perubahan';
        }
    }    
    public function statusHarta() {
        if ($this->icno) {
            return "Ya";
        } else {
            return "Tidak";
        }
    }
       public function getStatusLabel() {
     
        if ($this->status == '1') {
            return '<span class="label label-primary">Menunggu Perakuan Ketua Jabatan</span>';
        }
         if ($this->status == '2') {
            return '<span class="label label-warning">Selesai Perakuan dan Menunggu Kelulusan JKTT</span>';
        }
        if ($this->status == '4') {
            return '<span class="label label-success">Diluluskan</span>';
        }
         if ($this->status == '5') {
            return '<span class="label label-danger">Ditotak</span>';
        }
        
           if ($this->status == NULL) {
            return '<span class="label label-primary">Harta belum diisytihar</span>';
        }
    }
    
     public static function totalPendingKj() {
        $icno = Yii::$app->user->getId();
        $total = 0;
        $model = TblHarta::find()->where(['ketua_jabatan' => $icno,'status_kj' => null])->all();
        
        if ($model) {
            $total = count($model);
        }
        if ($total > 0) {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        else {
                return '';
        }
        
    }
    

    
         public function getDepartment(){
        return $this->hasOne(\app\models\hronline\Department::className(), ['fullname' => 'jfpiu']);
    }
    
    
          public function getStatusBorang() {
     
        if ($this->status == '1') {
            return '<span class="label label-success">Menunggu Perakuan</span>';
        }
        if ($this->status == '2') {
            return '<span class="label label-warning">Menunggu Kelulusan</span>';
        }
           if ($this->status == '4') {
            return '<span class="label label-primary">Diluluskan</span>';
        }
          if ($this->status == '5') {
            return '<span class="label label-danger">Ditolak</span>';
        } if ($this->status == NULL) {
            return '<span class="label label-info">Belum Dihantar</span>';
        }
    }
 
     
        public function getKetuaJabatan(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ketua_jabatan']);
           
    }
    
    
    
       public static function listofyear() {
           
       return self::find()->select('tahun')->where(['!=','status', 'null'])->orderBy(['tahun' => SORT_ASC])->distinct()->all();
    }
    
     public static function totalselesai($year){
        return self::find()->where(['!=','status', 'null'])->andWhere(['tahun' => $year])->count();
    }
    
//    public static function totalbelumselesai($year){
//       return self::find()->joinWith('kakitangan')->where(['not in', "harta_tbl_harta.icno", "tblprcobiodata.ICNO"])->andWhere(['tahun' => $year])->count();
//    }
    
    public static function averageindex($year) {
        return self::find()->where(['tahun' => $year])->andWhere(['!=','status', 'null'])->count();
    }
    
    

    
    
    
     public function countSelesai($kumpulan, $category) {

        if ($category == 0) { //keseluruhan
             $count = TblHarta::find()
                    ->joinWith('kakitangan')
                    ->where(['tblprcobiodata.DeptId' => $kumpulan])
                 //   ->andWhere(['=','tblprcobiodata.ICNO', 'harta_tbl_harta.icno'])
                    ->andWhere(['tblprcobiodata.Status' =>  1])
                    ->andWhere(['!=','harta_tbl_harta.status', 'null'])
                    ->count();
        }
        
        return $count;
    }
    
    
         public function countBelumSelesai($kumpulan, $category){

        $count = 0;
        $pengajian = TblHarta::find()->where(['!=','status', 'null'])->all();
        
        foreach ($pengajian as $p) {
            $ICNO[] = $p->icno;
        }
        if ($category == 0) { //keseluruhan
            $count = Tblprcobiodata::find()
               
                    ->where(['not in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['DeptId' => $kumpulan])
                    ->andWhere(['tblprcobiodata.Status' =>  1])
//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
                    ->count();
        } 

        return $count;
    }
    
      public function countKeseluruhan($kumpulan, $category) {
   
           if ($category == 0) { //keseluruhan
             $count= Tblprcobiodata::find()
                    ->joinWith('department')
                    ->where(['tblprcobiodata.DeptId' => $kumpulan])
                    ->andWhere(['tblprcobiodata.Status' =>  1])
                    ->count();
        }
        
        return $count;
        
        
      }  
      
    
}
