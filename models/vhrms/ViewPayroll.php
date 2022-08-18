<?php

namespace app\models\vhrms;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\vhrms\IncomeType;
use app\models\harta\TblElaunPasangan;
use app\models\hronline\Tblkeluarga;
use app\models\harta\TblPendapatanPasangan;
use app\models\harta\TblElaun;
use app\models\harta\TblBayaran;
use app\models\harta\TblPemotonganPasangan;
use app\models\harta\TblHarta;
/**
 * This is the model class for table "vEAttendance".
 *
 * @property int $StaffID
 * @property int $ActivityID
 * @property string $ICNo
 * @property string $NoPer
 * @property string $StaffName
 * @property string $ApprovedDate
 * @property string $Name
 * @property string $OutstationDateTimeStart
 * @property string $OutstationDateTimeEnd
 * @property int $Status
 * @property string $StatusShtName
 * @property string $StatusLgName
 */
class ViewPayroll extends \yii\db\ActiveRecord
{
    
      public $search;
      public $cnt;
      public $emolumen;
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db4'); // MSSQL database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.view_payroll';
    }
    
    public static function primaryKey()
{
    return ['MPH_STAFF_ID'];
}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MPH_STAFF_ID'], 'required'],
            //[['StaffID', 'ActivityID', 'Status'], 'integer'],
            [['it_income_desc','MPH_BANK_ACC_NO', 'MPH_PAY_MONTH'], 'string'],
            [['MPDH_PAID_AMT, MPH_BASIC_PAY'], 'decimal'],
            [['sm_ic_no'], 'safe'],
            //[['ApprovedDate', 'OutstationDateTimeStart', 'OutstationDateTimeEnd'], 'safe'],
        ];
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'MPH_STAFF_ID'=> 'MPH_STAFF_ID',
        ];
    }
    
    public function getIncomeType(){
        return $this->hasOne(IncomeType::className(), ['it_income_code' => 'MPDH_INCOME_CODE']);
           
    }
      public function getGajiBersih(){
        $pendapatan = ($this->MPH_TOTAL_ALLOWANCE);
        $penolakan =  ($this->MPH_TOTAL_DEDUCTION);
        $gajiBersih = ($pendapatan-$penolakan);
        return $gajiBersih;
    }
    
     public function getApplicant(){
        return $this->hasOne(Tblprcobiodata::className(), ['COOldID' => 'MPH_STAFF_ID']);
    }
    
     public function getJumElaun() {
      return  $this->getTotalelaun($this->icno);            
    }
    
     public function getPend() {
        return $this->hasOne(TblPendapatanPasangan::className(), ['icno' => 'icno']);
    }

    
    public function getTotalElaun() {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $modell= TblHarta::find()->where(['id'=> $id])->one(); 
        $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
        $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
        $modelelaun = TblElaun::find()->where(['icno'=> $self->ICNO])->all();
        $modelelauns = TblElaun::find()->where(['icno'=> $selfs->ICNO])->all();
        $totalelaun = 0;
        
        if($modell->icno != null){
        foreach ($modelelaun as $modelelauns) {
            $totalelaun = $totalelaun + $modelelauns->jumlah;
        }
        return $totalelaun;
    }else{
              foreach ($modelelauns as $modelelauns) {
            $totalelaun = $totalelaun + $modelelauns->jumlah;
        }
        return $totalelaun;
    }
    
    }
    
    
    
     public function getTotalElaunPasangan() {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $modell= TblHarta::find()->where(['id'=> $id])->one(); 
        $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
        $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
        $a  = Tblprcobiodata::find()->where(['ICNO' => $self->kakitangans->ICNO])->one();
        $as  = Tblprcobiodata::find()->where(['ICNO' => $selfs->kakitangans->ICNO])->one();
        $modelelaun = TblElaunPasangan::find()->where(['icno'=> $a->ICNO])->all();
        $modelelauns = TblElaunPasangan::find()->where(['icno'=> $as->ICNO])->all();
        $totalelaunPasangan = 0;
        if($modell->icno != null){
        foreach ($modelelaun as $modelelauns) {
            $totalelaunPasangan = $totalelaunPasangan + $modelelauns->jumlah;
        }
        return $totalelaunPasangan;
    }else{
         foreach ($modelelauns as $modelelauns) {
            $totalelaunPasangan = $totalelaunPasangan + $modelelauns->jumlah;
        }
        return $totalelaunPasangan;
    }
   }
   
     public function getTotalPendapatan() {
      $gaji = $this->gaji(); 
      $request = Yii::$app->request;
      $id = $request->get('id');
      $modell= TblHarta::find()->where(['id'=> $id])->one(); 
      $MPH_STAFF_ID = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->PenggunaA()])->one();
      $MPH_STAFF_IDs = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->PenggunaB()])->one();
      $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $models = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_IDs,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
     
      if($modell->icno != null){
      foreach ($model as $models) {
            $totalPendapatan = $models->MPH_TOTAL_ALLOWANCE;
        }
       return $totalPendapatan;
        
    }else{
          foreach ($models as $models) {
            $totalPendapatan = $models->MPH_TOTAL_ALLOWANCE;
        }
       return $totalPendapatan;
    }
}
     
     
      public function getTotalPendapatanPasangan() {
      $gaji = $this->gaji(); 
      $request = Yii::$app->request;
      $id = $request->get('id');
      $modell= TblHarta::find()->where(['id'=> $id])->one(); 
      $MPH_STAFF_ID_PASANGAN  = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->pasanganPenggunaA()])->one();
      $MPH_STAFF_ID_PASANGANs  = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->pasanganPenggunaB()])->one();
      $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $models = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGANs,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      if($modell->icno != null){
      foreach ($model as $models) {
            $totalPendapatanPasangan = $models->MPH_TOTAL_ALLOWANCE;
        }
       return $totalPendapatanPasangan;
        
    }else{
         foreach ($models as $models) {
            $totalPendapatanPasangan = $models->MPH_TOTAL_ALLOWANCE;
        }
       return $totalPendapatanPasangan;
    }
      }
    
        public function getJumPendapatan(){
        $elaun = $this->totalElaun;
        $pendapatan = $this->totalPendapatan;
        $jumPendapatan = $pendapatan + $elaun;
        return $jumPendapatan;
    }
    
      public function getTotalPemotongan() {
      $gaji = $this->gaji();
      $request = Yii::$app->request;
      $id = $request->get('id');
      $modell= TblHarta::find()->where(['id'=> $id])->one(); 
      $MPH_STAFF_ID = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->PenggunaA()])->one();
      $MPH_STAFF_IDs = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->PenggunaB()])->one();
      $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $models = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_IDs,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $totalPemotongan = 0;
      
      if($modell->icno != null){
      foreach ($model as $models) {
            $totalPemotongan = $models->MPH_TOTAL_DEDUCTION;
        }
       return $totalPemotongan;
        
    } else {
        foreach ($models as $models) {
            $totalPemotongan = $models->MPH_TOTAL_DEDUCTION;
        }
       return $totalPemotongan;
    }
      }
    
       public function getJumPemotongan(){
        $elaun = $this->totalPemotonganTambahan;
        $pendapatan = $this->totalPemotongan;
        $jumPemotongan = $pendapatan+$elaun;
        return $jumPemotongan;
    }
    
      public function getTotalPemotonganTambahan() {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $modell= TblHarta::find()->where(['id'=> $id])->one(); 
        $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
        $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
        $modelelaun = TblBayaran::find()->where(['icno'=> $self->ICNO])->all();
        $modelelauns = TblBayaran::find()->where(['icno'=> $selfs->ICNO])->all();
        $totalelaun = 0;
            if($modell->icno != null){
        foreach ($modelelaun as $modelelauns) {
            $totalelaun = $totalelaun + $modelelauns->jumlah;
        }
        return $totalelaun;
    }else{
         foreach ($modelelauns as $modelelauns) {
            $totalelaun = $totalelaun + $modelelauns->jumlah;
        }
        return $totalelaun;
    }
    
      }
    
       public function getTotalPendapatanPasangan2() {
       $request = Yii::$app->request;
       $id = $request->get('id');
       $modell= TblHarta::find()->where(['id'=> $id])->one(); 
       $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
       $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
       $pasangan =  Tblkeluarga::find()->where(['ICNO' => $self->ICNO, 'RelCd' => [02,01]])->one();
       $pasangans =  Tblkeluarga::find()->where(['ICNO' => $selfs->ICNO, 'RelCd' => [02,01]])->one();
       $pendapatanPasangan = TblPendapatanPasangan::find()->where(['icno' => $pasangan->FamilyId])->orderBy(['icno' => SORT_DESC])->limit(1)->all();
       $pendapatanPasangans = TblPendapatanPasangan::find()->where(['icno' => $pasangans->FamilyId])->orderBy(['icno' => SORT_DESC])->limit(1)->all();
       if($modell->icno != null){
       foreach ($pendapatanPasangan as $models) {
            $totalPendapatanPasangan2 = $models->jumlah;
        }
       return $totalPendapatanPasangan2;
       }else{
           foreach ($pendapatanPasangans as $models) {
            $totalPendapatanPasangan2 = $models->jumlah;
        }
       return $totalPendapatanPasangan2;
       }
    }
    
     public function getTotalPemotonganStaf() {
      $gaji = $this->gaji();
      $request = Yii::$app->request;
      $id = $request->get('id');
      $modell= TblHarta::find()->where(['id'=> $id])->one(); 
      $MPH_STAFF_ID_PASANGAN  = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->pasanganPenggunaA()])->one();
      $MPH_STAFF_ID_PASANGANs  = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->pasanganPenggunaB()])->one();
      $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $models = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGANs,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      if($modell->icno != null){
      foreach ($model as $models) {
            $totalPemotonganStaf = $models->MPH_TOTAL_DEDUCTION;
        }
       return $totalPemotonganStaf;
     }else{
           foreach ($models as $models) {
            $totalPemotonganStaf = $models->MPH_TOTAL_DEDUCTION;
        }
       return $totalPemotonganStaf;
     }
     }
     
     
       public function getJumPemotonganPasangan(){
        $elaun = $this->totalPemotonganStaf;
        $pendapatan = $this->totalPemotonganPasangan;
        $jumPemotonganPasangan = $pendapatan+$elaun;
        return $jumPemotonganPasangan;
    }
         public function getTotalPemotonganPasangan() {
         $request = Yii::$app->request;
         $id = $request->get('id');
         $modell= TblHarta::find()->where(['id'=> $id])->one(); 
         $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
         $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
         $pasangan =  Tblkeluarga::find()->where(['ICNO' => $self->ICNO, 'RelCd' => [02,01]])->one();
         $pasangans =  Tblkeluarga::find()->where(['ICNO' => $selfs->ICNO, 'RelCd' => [02,01]])->one();
         $model = TblPemotonganPasangan::find()->where(['icno'=> $pasangan->FamilyId])->all();
         $models = TblPemotonganPasangan::find()->where(['icno'=> $pasangans->FamilyId])->all();
         $totalPemotonganPasangan = 0;
       if($modell->icno != null){
         foreach ($model as $models) {
            $totalPemotonganPasangan = $totalPemotonganPasangan + $models->jumlah;
        }
        return $totalPemotonganPasangan;
    }else{
         foreach ($models as $models) {
            $totalPemotonganPasangan = $totalPemotonganPasangan + $models->jumlah;
        }
        return $totalPemotonganPasangan;
    }
         }
 
       public function getJumPendapatanPasangan(){
        $elaun = $this->totalElaunPasangan;
        $pendapatan = $this->totalPendapatanPasangan;
        $jumPendapatanPasangan = $pendapatan+$elaun;
        return $jumPendapatanPasangan;
    }

 
 
        public function getJumPendapatanSemua(){
        $elaun = $this->jumPendapatan;
        $pendapatan = $this->jumPendapatanPasangan;
        $jumPendapatanSemua = $pendapatan+$elaun;
        return $jumPendapatanSemua;
    } 
    
     public function getJumPemotonganSemua(){
        $elaun = $this->jumPemotongan;
        $pendapatan = $this->jumPemotonganPasangan;
        $jumPendapatanSemua = $pendapatan+$elaun;
        return $jumPendapatanSemua;
    }
    
       public function getJumPendapatanSemua2(){
        $pegawai =  $this->jumPendapatan;
        $pasangan = $this->jumPendapatanPasangan2;
        $jumPendapatanSemua2 = $pegawai+$pasangan;
        return $jumPendapatanSemua2;
    } 
    
       public function getJumPendapatanBersih(){
        $elaun = $this->jumPemotonganSemua;
        $pendapatan = $this->jumPendapatanSemua;
        $jumPendapatanBersih = $pendapatan - $elaun;
        return $jumPendapatanBersih;
    }
    
        public function getJumPendapatanBersihIndividu(){
        $elaun = $this->jumPemotongan;
        $pendapatan = $this->jumPendapatan;
        $jumPendapatanBersih = $pendapatan - $elaun;
        return $jumPendapatanBersih;
    }
    
    protected function PenggunaA() {
      $request = Yii::$app->request;
      $id = $request->get('id');
      $modell= TblHarta::find()->where(['id'=> $id])->one(); 
      $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
      $modelA = \app\models\hronline\Umsper::find()->where(['ICNO' => $self->ICNO])->one();
      
      $models =  ViewPayroll::find()->where(['MPH_STAFF_ID' => $self->COOldID])->one();
      if($self->COOldID == $models->MPH_STAFF_ID){
          $penggunaA =  explode(",",$self->COOldID);
      }else{
          $penggunaA =  explode(",",$modelA->COOldID);
      }
      return $penggunaA;
    }
    
      protected function PenggunaB() {
      $self = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
      $modelB = \app\models\hronline\Umsper::find()->where(['ICNO' => $self->ICNO])->one();
      $models =  ViewPayroll::find()->where(['MPH_STAFF_ID' => $self->COOldID])->one();
      if($self->COOldID == $models->MPH_STAFF_ID){
          $penggunaB =  explode(",",$self->COOldID);
      }else{
          $penggunaB =  explode(",",$modelB ->COOldID);
      }
      return $penggunaB;
    }
    
     protected function pasanganPenggunaA() {
      $request = Yii::$app->request;
      $id = $request->get('id');
      $modell= TblHarta::find()->where(['id'=> $id])->one(); 
      $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
      $a  = Tblprcobiodata::find()->where(['ICNO' => $self->kakitangans->ICNO])->one();
      $model = \app\models\hronline\Umsper::find()->where(['ICNO'=>$a->ICNO])->one();
    
      $models =  ViewPayroll::find()->where(['MPH_STAFF_ID' => $a->COOldID])->one();
      if($a->COOldID == $models->MPH_STAFF_ID){
          $pasanganPenggunaA=  explode(",",$a->COOldID);
      }else{
          $pasanganPenggunaA =  explode(",",$model->COOldID);
      }
      return $pasanganPenggunaA;
    }
    
       protected function pasanganPenggunaB() {
      $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
      $as = Tblprcobiodata::find()->where(['ICNO' => $selfs->kakitangans->ICNO])->one();
      $model = \app\models\hronline\Umsper::find()->where(['ICNO' => $as->ICNO])->one();

      $models =  ViewPayroll::find()->where(['MPH_STAFF_ID' => $as->COOldID])->one();
      if($as->COOldID == $models->MPH_STAFF_ID){
          $pasanganPenggunaB =  explode(",",$as->COOldID);
      }else{
          $pasanganPenggunaB =  explode(",",$model->COOldID);
      }
      return $pasanganPenggunaB;
    }
    
    
         protected function gaji() {
        $ma  = date('m');
        $ya = date('Y');
       if (($ma == "1") && $ya){
              $y = date('Y',strtotime("-1 year"));
              $m =  date('m',strtotime("-1 months"));
              $pm = $y.$m;   
       }else{
           $y = date('Y');    
           $m =  date('m',strtotime("-1 month"));
           $pm = $y.$m;   
      }

        return $pm;
    }
    
     public function getKakitangan(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'sm_ic_no']);
    }
    
     public function getStaff(){
        return $this->hasOne(\app\models\cuti\SetPegawai::className(), ['pemohon_icno' => 'sm_ic_no']);
    }
}