<?php

namespace app\models\harta;

use Yii;
use app\models\harta\RefJenisBayaran;
use app\models\hronline\Tblkeluarga;
use app\models\harta\TblBayaran;
use app\models\hronline\Tblprcobiodata;
use app\models\vhrms\ViewPayroll;
use app\models\harta\TblElaun;
use app\models\harta\TblElaunPasangan;

class TblPemotonganPasangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_tbl_pemotongan_pasangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_bayaran'], 'integer'],
            [['icno'], 'string', 'max' => 15],
            [['jenis_bayaran', 'jumlah'], 'required', 'message' => Yii::t('app', 'Wajib Diisi')]
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
            'jenis_bayaran' => 'Jenis Bayaran',
            'jumlah' => 'Jumlah',
        ];
    }
    
      public function getJenisBayaran() {
        return $this->hasOne(RefJenisBayaran::className(), ['id' => 'jenis_bayaran']);
    }
    
     public function getEl() {
        return $this->hasOne(TblElaun::className(), ['icno' => 'icno']);
    }
    
       public function getEl2() {
        return $this->hasOne(TblElaunPasangan::className(), ['icno' => 'icno']);
    }
     public function getEl3() {
        return $this->hasOne(TblBayaran::className(), ['icno' => 'icno']);
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
     
        public function getJumPemotonganSemua(){
        $pegawai = $this->jumPemotongan;
        $pasangan = $this->jumPemotonganPasangan;
        $jumPemotonganSemua = $pegawai + $pasangan ;
        return $jumPemotonganSemua;
    } 
    
        public function getJumPemotongan(){
        $elaun = $this->totalElaun;
        $pendapatan = $this->totalPemotongan;
        $jumPendapatan = $pendapatan+$elaun;
        return $jumPendapatan;
    }
    
        public function getTotalElaun() {
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
      }else{
            foreach ($models as $models) {
            $totalPemotongan = $models->MPH_TOTAL_DEDUCTION;
        }
       return $totalPemotongan;
      }
    }
    
         public function getJumPemotonganPasangan(){
         $pinjaman = $this->totalPemotonganPasangan;
         $pinjaman2 = $this->totalPemotonganPasangan2;
         $jumPemotonganPasangan= $pinjaman + $pinjaman2;
         return $jumPemotonganPasangan;
    }
    
      public function getTotalPemotonganPasangan2() {
      $gaji = $this->gaji();
      $request = Yii::$app->request;
      $id = $request->get('id');
      $modell= TblHarta::find()->where(['id'=> $id])->one(); 
      $MPH_STAFF_ID_PASANGAN  = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->pasanganPenggunaA()])->one();
      $MPH_STAFF_ID_PASANGANs  = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->pasanganPenggunaB()])->one();
      $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $models = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGANs,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $totalPemotonganPasangan2 = 0;
      
      if($modell->icno != null){
      foreach ($model as $models) {
            $totalPemotonganPasangan2 = $models->MPH_TOTAL_DEDUCTION;
        }
       return $totalPemotonganPasangan2;
    }else{
          foreach ($models as $models) {
            $totalPemotonganPasangan2 = $models->MPH_TOTAL_DEDUCTION;
        }
       return $totalPemotonganPasangan2;
    }
  }
  
    
      public function getJumPendapatanBersih(){
        $elaun = $this->jumPemotonganSemua;
        $pendapatan = $this->jumPendapatanSemua;
        $jumPendapatanBersih = $pendapatan - $elaun;
        return $jumPendapatanBersih;
    }
    
    public function getJumPendapatanSemua(){
        $elaun = $this->jumPendapatan;
        $pendapatan = $this->jumPendapatanPasangan;
        $jumPendapatanSemua = $pendapatan+$elaun;
        return $jumPendapatanSemua;
    } 
    
      public function getJumPendapatan(){
        $elaun = $this->totalElaun2;
        $pendapatan = $this->totalPendapatan;
        $jumPendapatan = $pendapatan+$elaun;
        return $jumPendapatan;
    }
    
        public function getTotalElaun2() {
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
    
      public function getTotalPendapatan() {
      $gaji = $this->gaji();
      $request = Yii::$app->request;
      $id = $request->get('id');
      $modell= TblHarta::find()->where(['id'=> $id])->one(); 
      $MPH_STAFF_ID = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->PenggunaA()])->one();
      $MPH_STAFF_IDs = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->PenggunaB()])->one();
      $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $models = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_IDs,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $totalPendapatan = 0;
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
        public function getJumPendapatanPasangan(){
        $elaun = $this->totalElaunPasangan;
        $pendapatan = $this->totalPendapatanPasangan;
        $jumPendapatanPasangan = $pendapatan+$elaun;
        return $jumPendapatanPasangan;
    }
    
       public function getTotalElaunPasangan() {
       $request = Yii::$app->request;
       $id = $request->get('id');
       $modell= TblHarta::find()->where(['id'=> $id])->one(); 
       $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
       $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
       $pasangan =  Tblkeluarga::find()->where(['ICNO' => $self->ICNO, 'RelCd' => [02,01]])->one();
       $pasangans =  Tblkeluarga::find()->where(['ICNO' => $selfs->ICNO, 'RelCd' => [02,01]])->one();
       $modelelaun = TblElaunPasangan::find()->where(['icno'=> $pasangan->FamilyId])->all();
       $modelelauns = TblElaunPasangan::find()->where(['icno'=> $pasangans->FamilyId])->all();

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
       
       public function getTotalPendapatanPasangan() {
       $request = Yii::$app->request;
       $id = $request->get('id');
       $modell= TblHarta::find()->where(['id'=> $id])->one(); 
       $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
       $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
       $pasangan =  Tblkeluarga::find()->where(['ICNO' => $self->ICNO, 'RelCd' => [02,01]])->one();
       $pasangans =  Tblkeluarga::find()->where(['ICNO' => $selfs->ICNO, 'RelCd' => [02,01]])->one();
       $pendapatanPasangan = TblPendapatanPasangan::find()->where(['icno' => $pasangan->FamilyId])->orderBy(['id' => SORT_DESC])->limit(1)->all();
       $pendapatanPasangans = TblPendapatanPasangan::find()->where(['icno' => $pasangans->FamilyId])->orderBy(['id' => SORT_DESC])->limit(1)->all();
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
        public function getTotalPemotonganPasanganKedua() {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $modell= TblHarta::find()->where(['id'=> $id])->one(); 
        $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
        $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
        $pasangan =  Tblkeluarga::find()->where(['ICNO' => $self->ICNO, 'RelCd' => [02,01]])->orderBy(['id' => SORT_DESC])->one();
        $pasangans =  Tblkeluarga::find()->where(['ICNO' => $selfs->ICNO, 'RelCd' => [02,01]])->orderBy(['id' => SORT_DESC])->one();
        $model = TblPemotonganPasangan::find()->where(['icno'=> $pasangan->FamilyId])->all();
        $models = TblPemotonganPasangan::find()->where(['icno'=> $pasangans->FamilyId])->all();
        $totalPemotonganPasanganKedua = 0;
        if($modell->icno != null){
        foreach ($model as $models) {
            $totalPemotonganPasanganKedua = $totalPemotonganPasanganKedua + $models->jumlah;
        }
        return $totalPemotonganPasanganKedua;
    }else{
         foreach ($models as $models) {
            $totalPemotonganPasanganKedua = $totalPemotonganPasanganKedua + $models->jumlah;
        }
        return $totalPemotonganPasanganKedua;
    }
        }
        
      public function getJumPemotonganPasangan2(){
        $pinjaman3 = $this->totalPemotonganPasanganKedua;      
        return $pinjaman3;
    }
    
      public function getJumPemotonganSemuaKedua(){
        $pegawai = $this->jumPemotongan;
        $pasangan = $this->jumPemotonganPasanganKedua;
        $jumPemotonganSemuaKedua = $pegawai +$pasangan ;
        return $jumPemotonganSemuaKedua;
    }
    
      public function getJumPemotonganPasanganKedua(){
        $pinjaman = $this->totalPemotonganPasangan;
        $pinjaman2 = $this->totalPemotonganPasangan2;
        $pinjaman3 = $this->totalPemotonganPasanganKedua;
        $jumPemotonganPasanganKedua = $pinjaman + $pinjaman2 + $pinjaman3;
        return $jumPemotonganPasanganKedua;
    } 
    
        public function getJumPendapatanBersihKedua(){
        $elaun = $this->jumPemotonganSemuaKedua;
        $pendapatan = $this->jumPendapatanSemuaKedua;
        $jumPendapatanBersihKedua = $pendapatan - $elaun;
        return $jumPendapatanBersihKedua;
    }
    
        public function getJumPendapatanSemuaKedua(){
        $elaun = $this->jumPendapatan;
        $pendapatan = $this->jumPendapatanPasanganKedua;
        $jumPendapatanSemuaKedua = $pendapatan+$elaun;
        return $jumPendapatanSemuaKedua;
    }
    
        public function getJumPendapatanPasanganKedua(){
        $elaun = $this->totalElaunPasangan;
        $elaunKedua = $this->totalElaunPasanganKedua;
        $pendapatan = $this->totalPendapatanPasangan;
        $pendapatanKedua = $this->totalPendapatanPasanganKedua;
        $jumPendapatanPasangan = $pendapatan+$elaun + $elaunKedua + $pendapatanKedua;
        return $jumPendapatanPasangan;
    }
    
       public function getTotalElaunPasanganKedua() {
       $request = Yii::$app->request;
       $id = $request->get('id');
       $modell= TblHarta::find()->where(['id'=> $id])->one(); 
       $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
       $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
       $pasangan =  Tblkeluarga::find()->where(['ICNO' => $self->ICNO, 'RelCd' => [02,01]])->orderBy(['id' => SORT_DESC])->one();
       $pasangans =  Tblkeluarga::find()->where(['ICNO' => $selfs->ICNO, 'RelCd' => [02,01]])->orderBy(['id' => SORT_DESC])->one();
       $modelelaun = TblElaunPasangan::find()->where(['icno'=> $pasangan->FamilyId])->all();
       $modelelauns = TblElaunPasangan::find()->where(['icno'=> $pasangans->FamilyId])->all();
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
       
       public function getTotalPendapatanPasanganKedua() {
       $request = Yii::$app->request;
       $id = $request->get('id');
       $modell= TblHarta::find()->where(['id'=> $id])->one(); 
       $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
       $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
       $pasangan =  Tblkeluarga::find()->where(['ICNO' => $self->ICNO, 'RelCd' => [02,01]])->orderBy(['id' => SORT_DESC])->one();
       $pasangans =  Tblkeluarga::find()->where(['ICNO' => $selfs->ICNO, 'RelCd' => [02,01]])->orderBy(['id' => SORT_DESC])->one();
       $pendapatanPasangan = TblPendapatanPasangan::find()->where(['icno' => $pasangan->FamilyId])->orderBy(['id' => SORT_DESC])->limit(1)->all();
       $pendapatanPasangans = TblPendapatanPasangan::find()->where(['icno' => $pasangans->FamilyId])->orderBy(['id' => SORT_DESC])->limit(1)->all();
        if($modell->icno != null){
       foreach ($pendapatanPasangan as $models) {
            $totalPendapatanPasanganKedua = $models->jumlah;
        }
       return $totalPendapatanPasanganKedua;
         
    } else {
        foreach ($pendapatanPasangans as $models) {
            $totalPendapatanPasanganKedua = $models->jumlah;
        }
       return $totalPendapatanPasanganKedua;
         
    }
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
    
    
 }
   

