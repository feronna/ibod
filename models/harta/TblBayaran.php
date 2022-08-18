<?php

namespace app\models\harta;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\vhrms\ViewPayroll;
use app\models\harta\TblPemotonganPasangan;
/**
 * This is the model class for table "harta.tbl_bayaran".
 *
 * @property int $id
 * @property string $icno
 * @property string $bayaran
 * @property string $jumlah
 */
class TblBayaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_tbl_bayaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 15],
            [['bayaran', 'jumlah'], 'string', 'max' => 50],
           [['bayaran', 'jumlah'], 'required', 'message' => Yii::t('app', 'Wajib Diisi')]
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
            'bayaran' => 'Bayaran',
            'jumlah' => 'Jumlah',
        ];
    }
    
     public function getJenis() {
        return $this->hasOne(RefJenisBayaran::className(), ['id' => 'bayaran']);
    }
    
    
     public function getJumBayaran() {
        return $this->getTotalbayaran($this->icno);
    }
    
        public function getTotalBayaran($icno) {
        $modelbayaran = TblBayaran::find()->where(['icno'=> $icno])->all();
        $totalbayaran = 0;
        foreach ($modelbayaran as $models) {
            $totalbayaran = $totalbayaran + $models->jumlah;
        }
        return $totalbayaran;
    }
    
        public function getJumPemotongan(){
        $byr = $this->jumBayaran;
        $potong = $this->totalPemotongan;
        $jumPemotongan = $byr+$potong;
        return $jumPemotongan;
    }
    
   public function getTotalPemotongan() {
      $gaji = $this->gaji();  
      $request = Yii::$app->request;
      $id = $request->get('id');
      $modell= TblHarta::find()->where(['id'=> $id])->one(); 
      $MPH_STAFF_ID = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->PenggunaA()])->one();
      $MPH_STAFF_IDs = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->PenggunaB()])->one();
      $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['like', 'MPDH_INCOME_CODE','D'])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $models = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_IDs,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
     
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
