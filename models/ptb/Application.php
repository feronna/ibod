<?php
namespace app\models\ptb;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Campus;
use app\models\hronline\StatusLantikan;
use app\models\hronline\Tblrscoapmtstatus;
use app\models\hronline\GredJawatan;
use app\models\hronline\State;
use app\models\hronline\Gelaran;
use app\models\hronline\TblPenempatan;
use app\models\hronline\Country;
use app\models\ptb\TblUrusMesyuarat;
use app\models\ptb\TblPbpu;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use app\models\ptb\TblPenyelia;
use app\models\hronline\Kumpulankhidmat;
use Yii;
use app\models\ptb\RefJustifikasi;

class Application extends ActiveRecord
{
    #defining const for scenarios
    const SCENARIO_MOHON = 'mohon';
    const SCENARIO_DEFAULT = 'default';
    
    public function beforeSave($insert)
    {
        $tmp = TblPbpu::find()->select(['kali_ke', 'tarikh_mesyuarat'])->orderBy(['kali_ke'=>SORT_DESC])->limit(1)->one();
        
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        $this->kali_ke = $tmp['kali_ke'];
        $this->tarikh_mesyuarat = date('d M Y', strtotime ($tmp['tarikh_mesyuarat']));
        
 
        // ...custom code here...
        return true;
    }
    
    #Table name
    public static function tableName(){
        return 'hrm.ptb_tbl_applications';
    }
    
    

    #change attribute label for form helper (AUTO GENERATE FORM)
    public function attributeLabels(){

        return [
            'noic' => 'No. Kad Pengenalan',
            'type' => 'Jenis Permohonan',
            'service_period_yr' => 'Tahun',
            'service_period_month' => 'Bulan',
            'old_dept' => 'Jabatan Lama',
            'new_dept' => 'Jabatan Baru',
             'stat_lantikan' => 'Status Lantikan',
            'status' => 'Status Permohonan',
            'effective_date' => 'Tarikh Berkuat Kuasa',
            'created_at' => 'Permohonan Dibuat',
            'state_at' => 'Permohonan Dibuat',
            'kali_ke' => 'kali ke',
            'tarikh_mesyuarat' => 'tarikh mesyuarat',
            'status_bsm' => 'status_bsm',
            'new_campus' => 'kampus yang dimohon',
            'country_at' => 'negara asal',
            'fle' => 'dokumen sokongan'
            
            
            
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_MOHON => ['new_dept', 'reason', 'type', 'new_campus', 'file' ],
            self::SCENARIO_DEFAULT => ['icno', 'new_dept', 'new_campus', 'justifikasi']
        ];
    }
    

    public function rules(){
        return [
            [['new_dept', 'reason', 'type', 'new_campus' , 'icno'],'required','message' => Yii::t('app', 'Wajib Diisi'), 'on' => self::SCENARIO_MOHON],
            [['kp_agree', 'kp_notes', 'kp_created', 'kj_agree', 'kj_notes', 'kj_created'], 'string', 'max' => 50],

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
    public function getCreated() {
        return  $this->getTarikh($this->created_at);
    }
    public function getEffective() {
        return  $this->getTarikh($this->effective_date);
    }
    public function getTarikhMesyuarat() {
        return  $this->getTarikh($this->tarikh_mesyuarat);
    }
    #Model Relations
    public function getApplicant(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
    public function getLaporDiri(){
        return $this->hasOne(Application::className(), ['ICNO' => 'icno']);
    }
    
     public function getPenempatan(){
        return $this->hasOne(TblPenempatan::className(), ['ICNO' => 'icno']);
    }
 
    public function getType(){
        return $this->hasOne(ApplicationType::className(), ['id' => 'type_id']);
    }
    
    public function getCampus(){
        return $this->hasOne(Campus::className(), ['campus_id' => 'campus_id']);
    }
    
    public function getNewCampus(){
        return $this->hasOne(Campus::className(), ['campus_id' => 'new_campus']);
    }
  
  
    public function getNewDepartment(){
        return $this->hasOne(Department::className(), ['id' => 'new_dept']);
    }
       public function getStates(){
         return $this->hasOne(State::className(), ['StateCd' => 'state_at']); 
     } 
     public function getCountrys(){
         return $this->hasOne(Country::className(), ['CountryCd' => 'country_at']); 
     }
      public function getJawatan(){
         return $this->hasOne(GredJawatan::className(), ['id' => 'new_gred']); 
     }
     
     public function getLantikan(){
        return $this->hasOne(StatusLantikan::className(), ['ApmtStatusCd' => 'stat_lantikan']);
    }

    public function getNewLantikan(){
        return $this->hasOne(StatusLantikan::className(), ['ApmtStatusCd' => 'stat_lantikan']);
    }

    public function getOldDepartment(){
        return $this->hasOne(Department::className(), ['id' => 'old_dept']);
    }
    
     public function getApprovedDepartment(){
        return $this->hasOne(Department::className(), ['id' => 'approved_dept']);
    }
 
    public function getAllRecommendations(){
        return $this->hasMany(Recommendation::className(), ['application_id' => 'id']);
    }

    public function getPelulus(){
        return $this->hasOne(Recommendation::className(), ['application_id' => 'id'])->where(['type' => 3]);
           
    }
    public function getUrusMesyuarat(){
        return $this->hasOne(TblUrusMesyuarat::className(), ['id' => 'id']);
    }
        
    public function getPensetuju(){
        return $this->hasOne(Recommendation::className(), ['application_id' => 'id'])->where(['type' => 1]);
           
    }
    
     public function getPeraku(){
             return $this->hasOne(Recommendation::className(), ['application_id' => 'id'])->where(['type' => 2]);
    }
     
    public function getGelarans(){
        return $this->hasOne(Gelaran::className(), ['TitleCd' => 'gelaran']);
    }
    
      public function getLetter(){
        return $this->hasOne(Letter::className(), ['application_id' => 'id']);
    }
    
      public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
   
    public function getTempooh() {
        return $this->hasOne(Tblrscoapmtstatus::className(), ['ICNO' => 'icno']);
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
       public function getTempoh(){
        $model = Tblrscoapmtstatus::find()->where(['ICNO' => $this->icno])->min('ApmtStatusStDt');
        $date1=date_create($model);
        $date2=date_create($this->kakitangan->endDateLantik);
        $tempoh = date_diff($date1, $date2)->format('%y Tahun %m Bulan');
        //$tempoh = round($tempo/365, 1);
        return $tempoh;
    }
   
    public function getStringBalance(){
        $now =  date_create(date('d-m-Y'));
        $endDateLantik = date_create($this->kakitangan->endDateLantik);
        $diff = date_diff($now, $endDateLantik);
        $stringBalance = "$diff->d  hari, $diff->m  bulan, $diff->y tahun";
        return $stringBalance;
    }
     public function getStatuses(){
        return  $this->hasOne(ApplicationStatus::className(), ['id' => 'status']);
     }
   
       public function getStatusjfpiu() {
        
        if ($this->peraku->agree == '1') {
            return '<span class="label label-success">DIPERAKUI</span>';
        }
        if ($this->peraku->agree == '0') {
            return '<span class="label label-danger">DITOLAK</span>';
        }
         else {
             
            return '<span class="label label-warning">MENUNGGU TINDAKAN</span>';
        
        }
    }
           public function getStatuspp() {
               
      if(!is_null($this->pensetuju)){
       
        if ($this->pensetuju->agree == '1') {
            return '<span class="label label-success">DIPERSETUJUI</span>';
        }
        if ($this->pensetuju->agree == '0') {
            return '<span class="label label-danger">DITOLAK</span>';
        } else {
             
            return '<span class="label label-warning">MENUNGGU TINDAKAN</span>';
        
        }
      }else{
          return 'Terus Ke Pegawai Peraku';
      }
    }
      public function getStatuspelulus() {
      
        if ($this->pelulus->agree == '1') {
            return '<span class="label label-success">DILULUSKAN</span>';
        }
        if ($this->pensetuju->agree == '0') {
            return '<span class="label label-danger">TIDAK DILULUSKAN</span>';
        }
    } public static function totalPendings($id) {
        $app = Application::findOne($id);
        $jabatan = Department::findOne(['chief' => Yii::$app->user->getId()]);
        $total = 0;
        $model = Application::find()->where(['approved_dept' => $jabatan->id, 'status' => 4, 'lapor' => null])->all();
        
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
      public function getEffectives() {
        return  $this->getTarikhs($this->effective_date);
    }
     public function getPenyeliaCuti() {
        return $this->hasOne(TblPenyelia::className(), ['penyelia_cuti' => 'penyelia_cuti']);
    }
        public function getDisplayLink() {
        if(!empty($this->file)){
        return Html::a(Yii::$app->FileManager->NameFile($this->file), Yii::$app->FileManager->DisplayFile($this->file));
        }
        return 'Fail Tidak Wujud';
    }
      public function getSetujuList(){
         $icno = Yii::$app->user->getId();
        return  $this->hasOne(Recommendation::className(), ['application_id' => 'id'])->where(['icno' => $icno,'type' => 1]);
                //$setujuList = Recommendation::find()->with('application.applicant')->where([ 'icno' => $icno, 'type'=>1])->all();
     }
     
       public function getKategoriPemohon(){
        return $this->hasOne(Kumpulankhidmat::className(), ['id' => 'kategori']);
    }
        public function getNamaPp(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ppp_icno']);
    }
       
      public function getRekomen() {
        return $this->hasOne(\app\models\hronline\Tblrscoretireage::className(), ['ICNO' => 'icno'])->orderBy(['CORetireAgeEftvDt' => SORT_DESC]);
    }
    
        public function getJustification() {
        return $this->hasOne(RefJustifikasi::className(), ['id' => 'justifikasi']);
    }
    
    
    }
 
