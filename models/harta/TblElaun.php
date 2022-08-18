<?php

namespace app\models\harta;
use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\vhrms\ViewPayroll;
use app\models\harta\TblElaunPasangan;
use app\models\hronline\Tblkeluarga;
use app\models\harta\TblPendapatanPasangan;

class TblElaun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_tbl_elaun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'pendapatan'], 'string', 'max' => 50],
            [['jumlah'], 'string', 'max' => 100],
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
    
      public function getJumElaun() {
      return  $this->getTotalelaun($this->icno);            
    }
    
    
        public function getTotalElaun($icno) {
        $modelelaun = TblElaun::find()->where(['icno'=> $icno])->all();
        $totalelaun = 0;
        foreach ($modelelaun as $modelelauns) {
            $totalelaun = $totalelaun + $modelelauns->jumlah;
        }
        return $totalelaun;
    }
        
    
        public function getJumPendapatan(){
        $elaun = $this->jumElaun;
        $pendapatan = $this->totalPendapatan;
        $jumPendapatan = $pendapatan+$elaun;
        return $jumPendapatan;
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
