<?php

namespace app\models\harta;
use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\vhrms\ViewPayroll;
use app\models\harta\TblPendapatanPasangan;
use app\models\hronline\Tblkeluarga;

class TblElaunPasangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_tbl_elaun_pasangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 20],
            [['pendapatan', 'jumlah'], 'string', 'max' => 50],
            [['pendapatan', 'jumlah'], 'required', 'message' => Yii::t('app', 'Wajib Diisi')]
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
            'pendapatan' => 'Pendapatan',
            'jumlah' => 'Jumlah',
        ];
    }
    
    
     public function getPend() {
        return $this->hasOne(TblPendapatanPasangan::className(), ['icno' => 'icno']);
    }
    
    public function getJumElaunPasangan() {
        return $this->getTotalelaunPasangan($this->icno);
    }
    
        public function getTotalElaunPasangan($icno) {
        $modelelaun = TblElaunPasangan::find()->where(['icno'=> $icno])->all();
        $totalelaun = 0;
        foreach ($modelelaun as $modelelauns) {
            $totalelaun = $totalelaun + $modelelauns->jumlah;
        }
        return $totalelaun;
    }
    

      public function getJumPendapatanPasangan2(){
        $elaun = $this->jumElaunPasangan;
        $pendapatan = $this->totalPendapatanPasangan2;
        $jumPendapatanPasangan2 = $pendapatan+$elaun;
        return $jumPendapatanPasangan2;
    }
    
     public function getTotalPendapatanPasangan2() {
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
    
     public function getJumElaunPasanganKedua() {
        return $this->getTotalelaunPasangan($this->icno);
    }
    
    
      public function getJumPendapatanPasangan2Kedua(){
        $elaun = $this->jumElaunPasangan;
        $pendapatan = $this->totalPendapatanPasangan2Kedua;
        $jumPendapatanPasangan2Kedua = $pendapatan+$elaun;
        return $jumPendapatanPasangan2Kedua;
    }
    
      public function getTotalPendapatanPasangan2Kedua() {
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
            $totalPendapatanPasangan2Kedua = $models->jumlah;
        }
       return $totalPendapatanPasangan2Kedua;
        }else{
            foreach ($pendapatanPasangans as $models) {
            $totalPendapatanPasangan2Kedua = $models->jumlah;
        }
       return $totalPendapatanPasangan2Kedua;
        } 
    }
        
        public function getJumPendapatanPasangan(){
        $elaun = $this->jumElaunPasangan;
        $pendapatan = $this->totalPendapatanPasangan;
        $jumPendapatanPasangan = $pendapatan+$elaun;
        return $jumPendapatanPasangan;
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
   
        public function getJumPendapatanPasanganKedua(){
        $elaun = $this->jumElaunPasangan;
        $pendapatan = $this->totalPendapatanPasanganKedua;
        $jumPendapatanPasanganKedua = $pendapatan+$elaun;
        return $jumPendapatanPasanganKedua;
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
            $totalPendapatanPasangan = $models->jumlah;
        }
       return $totalPendapatanPasangan;
         
    }else{
        foreach ($pendapatanPasangans as $models) {
            $totalPendapatanPasangan = $models->jumlah;
        }
       return $totalPendapatanPasangan;
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
