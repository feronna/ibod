<?php

namespace app\models\cbelajar;

use Yii;
use app\models\hronline\Tblprcobiodata;


class TblLkk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function getDb() {
        return Yii::$app->get('db');  // second database
    }
    public $file, $file2, $file3;
    public static function tableName()
    {
        return 'hrd.cb_tbl_lkk';
    }

    public function rules()
    {
        return [

            [['semester', 'session', 'report_fr', 'report_to', 'cw_gpa', 'cw_cgpa', 'ms_semester', 'reason_achieved', 'discussed_problem', 'research_problem', 'no_ofdiscuss', 'activity_sem', 'publications', 'completion_date', 'achievement_report', 'dokumen_sokongan2', 'sv_name', 'thesis_title',
                'studentno','semesterp','result_cw','dt_sv','ms_achieved'], 'required', 'message'=>"This space is mandatory"],
            [['semester','semesterp', 'modeID', 'no_ofdiscuss'.'studyID'], 'integer'],

            [['tarikh_mohon', 'status_jfpiu','file', 'file2', 'file3'], 'safe'],
            [['dokumen_sokongan', 'reason_achieved', 'discussed_problem', 'research_problem', 'publications', 'achievement_report', 'dokumen_sokongan2', 'thesis_title', 'doc'], 'string'],
            [['icno','comment_by'], 'string', 'max' => 12],
            [['cw_gpa', 'cw_cgpa','agree','agree_p','open'], 'string', 'max' => 20],
            [['ms_semester', 'studentno','ms_achieved','activity_sem'], 'string'],
             [['session','effectivedt'], 'string', 'max' => 50],
            [[ 'sv_name', 'completion_date','dt_sv','result_cw','catatan'], 'string', 'max' => 255],
            [['status_borang', 'researchID', 'status_bsm'], 'string', 'max' => 50],
            [['file', 'file2', 'file3'], 'file','extensions'=>'pdf','maxSize'=>6666240, 'tooBig' => 'Limit is 6MB'], 
             [['d_comment','p_comment','ulasan_jfpiu','a1','a2','a3','a4','a5','a6','a7','a8','a9',
               'k2','k3','k4','k5','k6','k7','k8','ulasan_dekan','p_komen','result_cw'], 'string'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reportID' => 'Report ID',
            'icno' => 'Icno',
            'semester' => 'Semester',
            'session' => 'Session',
            'report_fr' => 'Report Fr',
            'report_to' => 'Report To',
            'modeID' => 'Mode ID',
            'cw_gpa' => 'Cw Gpa',
            'cw_cgpa' => 'Cw Cgpa',
            'dokumen_sokongan' => 'Dokumen Sokongan',
            'ms_semester' => 'Ms Semester',
            'ms_achieved' => 'Ms Achieved',
            'reason_achieved' => 'Reason Achieved',
            'discussed_problem' => 'Discussed Problem',
            'research_problem' => 'Research Problem',
            'no_ofdiscuss' => 'No Ofdiscuss',
            'activity_sem' => 'Activity Sem',
            'publications' => 'Publications',
            'completion_date' => 'Completion Date',
            'achievement_report' => 'Achievement Report',
            'status_borang' => 'Status Borang',
            'tarikh_mohon' => 'Tarikh Mohon',
            'researchID' => 'Research ID',
            'dokumen_sokongan2' => 'Dokumen Sokongan2',
            'sv_name' => 'Sv Name',
            'thesis_title' => 'Thesis Title',
            'studentno' => 'Studentno',
            'doc' => 'LKK Scan',
            'status_bsm' => 'Status BSM',
        ];
    }
     public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getP() {
       
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno', 'HighestEduLevelCd'=>'HighestEduLevelCd']);
       
   }
//   public function getResearch() {
//       
//        return $this->hasOne(TblResearch::className(), ['idLKK' => 'reportID']);
//       
//   }
  
    public function getResearch() {
       // $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID'=>$i]);
        $models = TblResearch::find()->where(['idLKK' => $this->reportID])->all();
      
        foreach ($models as $models) {
            echo'<li>' .ucwords(strtolower($models->r->stage)); 
        }
        
        return $models;
    }
    
    public function getMaklumat() {
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno']);
    }
     public function getRating() {
        return $this->hasOne(Rating::className(), ['idLkk' => 'reportID']);
    }
    
    public function getTarikh($bulan,$v = null){
        
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
          
        if($v != null){
            if($v == 'b')
            {
            return $m;
            }
            elseif($v == 't')
            {
                return   date_format(date_create($bulan), "Y");

            }
            elseif($v == 'h')
            {
               return   date_format(date_create($bulan), "d"); 
            }
            
        }
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y");
    }
    
    
     public function getTarikhmula() {
        return  $this->getTarikh($this->tarikh_mula);

    }
    public function getTarikhtamat() {
        return  $this->getTarikh($this->tarikh_tamat);
    }
     public function getDtsv() {
        return  $this->getTarikh($this->dt_sv);
    }
    
    
        public function getReportfr() {
        return  $this->getTarikh($this->report_fr);
    }
     public function getReportto() {
        return  $this->getTarikh($this->report_to);
    }
      public function getExtime() {
        return  $this->getTarikh($this->completion_date);
    }
    
//    public function getDt() {
//        return  $this->getTarikh($this->effectivedt);
//    }
    public function getStatuspenyelia() {
        if ($this->status_r == 'DONE') {
            return '<span class="label label-warning">CHECKED</span>';
        }
         elseif ($this->status_r == 'BYPASS') {
            return '<span class="label label-warning">BY PASS</span>';
        }
//        elseif ($this->agree== 1) {
//            return '<span class="label label-danger">WAITING FOR APPROVAL</span>';
//        }
        elseif($this->status_r == "NOT YET")
        {
                        return '<span class="label label-danger">NOT YET</span>';

        }
        else{
              return '- ';

        }
//        if ($this->status_r == "NULL") {
//            return '<span class="label label-danger">NOT CHECKED YET</span>';
//        }
    }
     public function getStatusjfpiu() {
        if ($this->status_jfpiu == 'Tunggu Perakuan') {
            return '<span class="label label-warning">MENUNGGU SEMAKAN</span>';
        }
        if ($this->status_jfpiu == 'Diperakukan') {
            return '<span class="label label-success">DISAHKAN</span>';
        }
        if ($this->status_jfpiu == 'Tidak Diperakukan') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
//        if ($this->status_jfpiu == "NULL") {
//            return '<span class="label label-danger">-</span>';
//        }
    }
    public function getStatuss() {
       
        if ($this->status == 'DALAM TINDAKAN KETUA JABATAN') {
            return '<span class="label label-warning">Laporan Telah Dihantar</span>';
        }
        elseif ($this->status == 'DALAM TINDAKAN BSM') {
            return '<span class="label label-success">TELAH DISEMAK</span>';
        }
          elseif ($this->status == 'LULUS') {
            return '<span class="label label-info">Laporan Berjaya diterima BSM </span>';
        }
        
          elseif ($this->status == '') {
            return '-';
        }
         elseif ($this->status == 'MANUAL UPLOAD') {
            return '<span class="label label-success">TELAH DISEMAK</span>';
        }
        else
        {
            return '-';
        }
    }
    public function checkUpload($id){
        $model = TblSurat::findOne(['icno' => Yii::$app->user->getId(),'icno' => $id]); 
        
        return $model;
    } 
    public function getStatusbsm() {
        if ($this->status_bsm == 'Tunggu Kelulusan') {
//            return '<i class="fa fa-times fa-xs"></i>';
            return '<span class="label label-primary">MENUNGGU SEMAKAN';
        }
        if ($this->status_bsm == 'Diluluskan') {
            return '<span class="label label-success">TELAH DISEMAK</span>';
        }
        if ($this->status_bsm == 'Tidak Diluluskan') {
            return '<span class="label label-danger">Ditolak</span>';
        }
        if ($this->status_bsm === 'Admin Manually Upload') {
           return '<i class="fa fa-check fa-xs"></i>';
        }
         if ($this->status_bsm === 'Diperakukan') {
           return '<i class="fa fa-check fa-xs"></i>';
        }
         if ($this->status_bsm === NULL) {
            return '<i class="fa fa-times fa-xs"></i>';
        }
    }
     public function getDt() {
        return '<i class="fa fa-calendar fa-xs"></i><strong><small> '.strtoupper($this->getTarikh($this->effectivedt)).'</small></strong>';

    }
   public static function Semlkk($icno)
   {
       $model = TblPengajian::find()->where(['icno'=> $icno, 'idBorang'=>1, 'status'=> 1])->one();
      
   
        $date1=date_create($model->tarikh_mula);
        $date2= date_create($model->tarikh_tamat);
        $tempoh = date_diff($date1, $date2)->format('%a') ;
        //$tempoh = round($tempo/365, 1);
        return $tempoh / 365 * 2;
        
      
      
   }
   public static function Semlanjutanlkk($icno)
   {
       $model = TblLanjutan::find()->where(['icno'=> $icno])->one();
      
   
        $date1=date_create($model->lanjutansdt);
        $date2= date_create($model->lanjutanedt);
        $tempoh = date_diff($date1, $date2)->format('%a') ;
        //$tempoh = round($tempo/365, 1);
        return $tempoh / 365 * 2;
        
      
      
   }
    public static function TotalHantar()
    {
//        return count(TblLkk::findAll(['status'=>"MANUAL UPLOAD"]));
        
          return count(TblLkk::
                find()->joinWith('pengajiansemasa')
                ->andWhere(['cb_tbl_pengajian.status' => 1])
                ->andWhere(['cb_tbl_lkk.status' => "MANUAL UPLOAD"])->
               all());
    }
    
   public static function Semlkk1($icno)
   {
       $model = TblLanjutan::find()->where(['icno'=> $icno, 'idLanjutan'=>1])->one();
      
   
//        $date1=  strtotime($model->lanjutansdt);
//        $date2= strtotime($model->lanjutanedt);
        //$tempoh = round($tempo/365, 1);
        $date1 = TblLanjutan::find()->where(['icno' => $icno,'idLanjutan'=>1])->max('lanjutansdt');
        $date2 = TblLanjutan::find()->where(['icno' => $icno, 'idLanjutan'=>1])->max('lanjutanedt');

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);
      
              $tempoh = $ts2 - $ts1 ;
        return $tempoh / 365 * 2;

   }
     public function getPendidikanTertinggi() {
        return $this->hasOne(Edulevel::className(), ['HighestEduLevelCd'=>'HighestEduLevelCd']);
   }
 

    public function getDatehantar() {
        return  $this->getTarikh($this->effectivedt);

    }
   public function getTahapPendidikan() {
      
       return $this->pendidikanTertinggi->HighestEduLevel;
   }
    public function getPengajian() {
       
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno'])->where(['cb_tbl_pengajian.status'=>[1,4,2]])->orderBy(['cb_tbl_pengajian.tarikh_mula'=>SORT_DESC]);
       
   }
    public function getEduLevel() {
       
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno'])->where(['cb_tbl_pengajian.status'=>[1,2,4]])->orderBy(['cb_tbl_pengajian.tarikh_mula'=>SORT_ASC]);
       
   }
   public function getPengajiansemasa() {
       
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno'])->where(['cb_tbl_pengajian.status'=>1])->orderBy(['cb_tbl_pengajian.tarikh_mula'=>SORT_DESC]);
       
   }
   
//    public function getPengajian2() {
//       
//        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno'])->where(['cb_tbl_pengajian.status'=>[1]]);
//       
//   }
    public function getPenyelia() {
       
        return $this->hasOne(TblPenyelia::className(), ['staff_icno' => 'icno']);
       
   }
      public function getPengajian2() {
        return $this->hasOne(TblPengajian::className(), ['icno'=>'icno']);
    }
    public function getGot() {
       
        return $this->hasOne(LkkDean::className(), ['icno' => 'icno'])->where(['cb_tbl_dean.dokumen'=>[16,58]])->orderBy(['cb_tbl_dean.created_dt'=>SORT_DESC]);
       
   }
//    public function getGotno() {
//       
//        return $this->hasOne(LkkDean::className(), ['icno' => 'icno'])->where(['cb_tbl_dean.result'=>2,'cb_tbl_dean.dokumen'=>[16,58]])->orderBy(['cb_tbl_dean.created_dt'=>SORT_DESC]);
//       
//   }
   
    public function getLkp() {
       
        return $this->hasOne(LkkDean::className(), ['icno' => 'icno','parent_id'=>'reportID']);
       
   }
      public static function totalPendingReview($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
            $total = count($model = TblLkk::find()->where(['app_by' => $icno, 'status' => 'DALAM TINDAKAN KETUA JABATAN','status_r'=>["DONE","BYPASS"]])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
    }
     public static function totalPendingTaskLkp($icno) {

        $total = 0;
//    if(TblAccess::find()->where( ['icno'=> $icno, 'level'=>[1,2]] )->exists()){
//     $model = TblPermohonan::find()->where([ 'status' => 'DALAM TINDAKAN KETUA JABATAN' ])->all();
// }
//        if ($model) {
//            $total = count($model);
//        }
        
//         else{
        if($icno == "840929125614")
        {
            $total = count($model = TblLkk::find()->where(['status_jfpiu'=>"Diperakukan",'status_bsm' =>"Tunggu Kelulusan"])->all());
//        }
        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
        }
    }
    
     
    public function countNoProposalDefense($kumpulan, $category) {

        $count = 0;
        $lkk = \app\models\cbelajar\TblLkk::find()->joinWith('got')
                        ->where(['cb_tbl_dean.result' => 2, 'cb_tbl_lkk.semester' => 4])->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])->all();

        foreach ($lkk as $l) {
            $i[] = $l->got->icno;
        }
         $pd = LkkDean::find()->select('icno')->where(['result'=>1,'dokumen'=>[58,16]])->asArray()->all();
        $icno_array = [];
        foreach($pd as $pd){
            array_push($icno_array,$pd['icno']);
        }
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'HighestEduLevelCd' => [1, 200, 201, 20, 202]])->all();
        foreach ($pengajian as $p) {
            $ICNO[] = $p->icno;
        }
        if ($category == 0) { //keseluruhan
             $count = TblPengajian::find()
//                    ->joinWith('pengajianLulus')
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
                      ->joinWith('lkp')
//                    ->joinWith('pengajian')

                    ->joinWith('lkp.got')
                    ->andWhere(['in', "tblprcobiodata.ICNO", $i])
                                        ->andWhere(['DeptId' => $kumpulan, 'job_category' => 1])
                     ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.modeID' => [1,2,4]])
                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
                    ->andWhere([ 'cb_tbl_lkk.semester' => [2, 3, 4]])
                    ->andWhere(['NOT IN','cb_tbl_dean.icno',$icno_array])

//                    ->andWhere(['cb_tbl_dean.result' => 1])
//                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
//                    ->andWhere(['<>','cb_tbl_pengajian.HighestEduLevelCd','202',])
                    ->groupBy('cb_tbl_dean.icno')
                    ->count();
        }
        
        return $count;
    }
     public function countNoRecord() {
        $count = 0;

       $pd = LkkDean::find()->select('icno')->distinct('icno')->where(['dokumen'=>[16,58]])->asArray()->all();
        $icno_array = [];
        foreach($pd as $pd){
            
            array_push($icno_array,$pd['icno']);
        }
//        var_dump($icno_array);die;
            $count = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->joinWith('lkp')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->where(['job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['not in','cb_tbl_pengajian.icno',$icno_array])
//                     ->andWhere(['cb_tbl_pengajian.modeID' => [1,2,4]])
//                    ->andWhere(['cb_tbl_dean.result' => 1])

//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
                    ->andWhere(['<>', 'cb_tbl_pengajian.HighestEduLevelCd', '202',])
                    ->count();
        
       
        return $count;
}
    public function countNoDefense($category) {

        $count = 0;
        $lkk = \app\models\cbelajar\TblLkk::find()->joinWith('got')
                        ->where(['cb_tbl_dean.result' => 2, 'cb_tbl_lkk.semester' => 4])->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])->all();

        foreach ($lkk as $l) {
            $i[] = $l->got->icno;
        }
  $pd = LkkDean::find()->select('icno')->where(['result'=>1,'dokumen'=>[58,16]])->asArray()->all();
        $icno_array = [];
        foreach($pd as $pd){
            array_push($icno_array,$pd['icno']);
        }
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'modeID' => [1, 2,4]])->all();
        foreach ($pengajian as $p) {
            $ICNO[] = $p->icno;
        }
        if ($category == 0) { //keseluruhan
            $count = TblPengajian::find()
//                    ->joinWith('pengajianLulus')
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
                      ->joinWith('lkp')
//                    ->joinWith('pengajian')

                    ->joinWith('lkp.got')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['in', "tblprcobiodata.ICNO", $i])
                    
                    ->andWhere([ 'job_category' => 1])
//                     ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.modeID' => [1,2,4]])
                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
                    ->andWhere([ 'cb_tbl_lkk.semester' => [2, 3, 4]])
                    ->andWhere(['NOT IN','cb_tbl_dean.icno',$icno_array])

//                    ->andWhere(['cb_tbl_dean.result' => 1])
//                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
//                    ->andWhere(['<>','cb_tbl_pengajian.HighestEduLevelCd','202',])
                    ->groupBy('cb_tbl_dean.icno')
                    ->count();
        }
        return $count;
    }
    
     public function countAllPd($category) {

        $count = 0;
        $lkk = \app\models\cbelajar\TblLkk::find()->joinWith('got')
                        ->where(['cb_tbl_dean.result' => 1])->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])->all();

        foreach ($lkk as $l) {
            $i[] = $l->got->icno;
        }

        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'modeID' => [1,2,4]])->all();
        foreach ($pengajian as $p) {
            $ICNO[] = $p->icno;
        }
        if ($category == 0) { //keseluruhan
            $count = TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->joinWith('lkp')
                    ->joinWith('lkp.got')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->Where(['job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
//                     ->andWhere(['cb_tbl_pengajian.modeID' => [1,4]])
                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
                    ->andWhere(['cb_tbl_dean.result' => 1])

//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
                    ->andWhere(['NOT IN', 'cb_tbl_pengajian.HighestEduLevelCd', ['202','211']])
                    ->groupBy('cb_tbl_dean.icno')
                    ->count();
        }
        return $count;
    }
    
    public function countProposalDefense($kumpulan, $category) {

        $count = 0;
        $lkk = \app\models\cbelajar\TblLkk::find()->joinWith('got')
                        ->where(['cb_tbl_dean.result' => 1])->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])->all();

        foreach ($lkk as $l) {
            $i[] = $l->got->icno;
        }

        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'HighestEduLevelCd' => [1, 200, 201, 20]])->all();
        foreach ($pengajian as $p) {
            $ICNO[] = $p->icno;
        }
       $mod = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'modeID' => [1,2,4]])->all();
 foreach ($mod as $p) {
            $ICNO[] = $mod->icno;
        }
        
        if ($category == 0) { //keseluruhan
            $count = TblPengajian::find()
                     ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
                     ->joinWith('lkp.got')
                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['in', "tblprcobiodata.ICNO", $i])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 1])

                    ->andWhere(['cb_tbl_dean.result' => 1])
                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
                    ->andWhere(['NOT IN','cb_tbl_pengajian.HighestEduLevelCd',['202','211']])
                    ->groupBy('icno')
                    ->count();
        }
        return $count;
    }

 public function getMod() {
        return $this->hasOne(Modpengajian::className(), ['modeID'=>'modeID']);
    }
       public function getSv() {
        return $this->hasOne(LkkTblPenyelia::className(), ['reportId'=>'reportID']);
    }
}
