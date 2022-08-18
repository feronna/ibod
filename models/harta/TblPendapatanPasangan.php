<?php

namespace app\models\harta;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Tblprcobiodata;
use app\models\vhrms\ViewPayroll;
use app\models\harta\TblPendapatanPasangan;
use Yii;

class TblPendapatanPasangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_tbl_pendapatan_pasangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gaji_pokok', 'itk', 'biw', 'itp', 'epw', 'icno'], 'string', 'max' => 50],
            [['gaji_pokok', 'itk', 'biw', 'itp', 'epw'], 'required', 'message' => Yii::t('app', 'Wajib Diisi')]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gaji_pokok' => 'Gaji Pokok',
            'itk' => 'Itk',
            'biw' => 'Biw',
            'itp' => 'Itp',
            'epw' => 'Epw',
            'icno' => 'Icno',
        ];
    }
        public function getEl() {
        return $this->hasOne(TblElaun::className(), ['icno' => 'icno']);
    }
    
       public function getEl2() {
        return $this->hasOne(TblElaunPasangan::className(), ['icno' => 'icno']);
    }
    
        public function getJumPendapatanSemuaKedua(){
        $elaun = $this->jumPendapatan;
        $pendapatan = $this->jumPendapatanPasanganKedua;
        $jumPendapatanSemua = $pendapatan+$elaun;
        return $jumPendapatanSemua;
    }
    
       public function getJumPendapatan(){
        $elaun = $this->totalElaun;
        $pendapatan = $this->totalPendapatan;
        $jumPendapatan = $pendapatan+$elaun;
        return $jumPendapatan;
    }
    
        public function getTotalElaun() {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $modell= TblHarta::find()->where(['id'=> $id])->one(); 
        $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
        $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
        $modelelaun = TblElaun::find()->where(['icno'=>$self->ICNO])->all();
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

        public function getJumPendapatanPasanganKedua(){
        $elaun = $this->totalElaunPasangan;
        $elaunKedua = $this->totalElaunPasanganKedua;
        $pendapatan = $this->totalPendapatanPasangan;
        $pendapatanKedua = $this->totalPendapatanPasanganKedua;
        $jumPendapatanPasangan = $pendapatan+$elaun + $elaunKedua + $pendapatanKedua;
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
               public function getTotalElaunPasanganKedua() {
               $request = Yii::$app->request;
               $id = $request->get('id');
               $modell= TblHarta::find()->where(['id'=> $id])->one(); 
               $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
               $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
               $pasangan =  Tblkeluarga::find()->where(['ICNO' => $self->ICNO, 'RelCd' => [01]])->orderBy(['id' => SORT_DESC])->one();
               $pasangans =  Tblkeluarga::find()->where(['ICNO' => $selfs->ICNO, 'RelCd' => [01]])->orderBy(['id' => SORT_DESC])->one();
               $modelelaun = TblElaunPasangan::find()->where(['icno'=> $pasangan->FamilyId])->all();
               $modelelauns = TblElaunPasangan::find()->where(['icno'=> $pasangans->FamilyId])->all();
               $totalelaunPasangan = 0;
             
              if($modell->icno != null){
               foreach ($modelelaun as $modelelauns) {
              $totalelaunPasanganKedua = $totalelaunPasangan + $modelelauns->jumlah;
                }
                    return $totalelaunPasanganKedua;
            }else{
               foreach ($modelelauns as $modelelauns) {
                $totalelaunPasanganKedua = $totalelaunPasangan + $modelelauns->jumlah;
                }
                   return $totalelaunPasanganKedua;
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
   
       public function getTotalPendapatanPasanganKedua() {
       $request = Yii::$app->request;
       $id = $request->get('id');
       $modell= TblHarta::find()->where(['id'=> $id])->one(); 
       $selfs = Tblprcobiodata::find()->where(['ICNO'=> Yii::$app->user->getId()])->one();
       $self = Tblprcobiodata::findOne(['ICNO'=> $modell->kakitangan->ICNO]);
       $pasangankedua =  Tblkeluarga::find()->where(['ICNO' => $self->ICNO, 'RelCd' => [01]])->orderBy(['id' => SORT_DESC])->one();
       $pasangankeduas =  Tblkeluarga::find()->where(['ICNO' => $selfs->ICNO, 'RelCd' => [01]])->orderBy(['id' => SORT_DESC])->one();
       $pendapatanPasangan = TblPendapatanPasangan::find()->where(['icno' => $pasangankedua->FamilyId])->orderBy(['id' => SORT_DESC])->limit(1)->all();
       $pendapatanPasangans = TblPendapatanPasangan::find()->where(['icno' => $pasangankeduas->FamilyId])->orderBy(['id' => SORT_DESC])->limit(1)->all();
      
       if($modell->icno != null){
       foreach ($pendapatanPasangan as $models) {
            $totalPendapatanPasanganKedua = $models->jumlah;
        }
       return $totalPendapatanPasanganKedua;
         
    }else{
        foreach ($pendapatanPasangans as $models) {
            $totalPendapatanPasanganKedua = $models->jumlah;
        }
       return $totalPendapatanPasanganKedua;
    }
   }
   
        public function getJumPendapatanSemua(){
        $elaun = $this->jumPendapatan;
        $pendapatan = $this->jumPendapatanPasangan;
        $jumPendapatanSemua = $pendapatan+$elaun;
        return $jumPendapatanSemua;
    } 
    
       public function getJumPendapatanPasangan(){
        $elaun = $this->totalElaunPasangan;
        $pendapatan = $this->totalPendapatanPasangan;
        $jumPendapatanPasangan = $pendapatan+$elaun;
        return $jumPendapatanPasangan;
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
    
     
    
    
 
}
