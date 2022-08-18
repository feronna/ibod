<?php

namespace app\models\gaji;

use Yii;

use yii\data\ActiveDataProvider;

use app\models\gaji\TblStaffRoc;
use app\models\gaji\RefRocReason;
use app\models\hronline\Tblprcobiodata;
use app\models\gaji\TblDepartment;
use app\models\gaji\TblStaffRocSmbu;
use app\models\hronline\Umsper;

class TblStaffRocBatchSmbu extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db4'); // MSSQL database
    }
    
    public static function tableName()
    {
        return 'dbo.staff_roc_batch';
    }

//    public function rules()
//    {
//        return [
//            [['MPH_STAFF_ID'], 'required'],
//            //[['StaffID', 'ActivityID', 'Status'], 'integer'],
//            [['it_income_desc','MPH_BANK_ACC_NO', 'MPH_PAY_MONTH'], 'string'],
//            [['MPDH_PAID_AMT, MPH_BASIC_PAY'], 'decimal'],
//            //[['ApprovedDate', 'OutstationDateTimeStart', 'OutstationDateTimeEnd'], 'safe'],
//        ];
//    }
    
//    public function attributeLabels()
//    {
//        return [
//            'MPH_STAFF_ID'=> 'MPH_STAFF_ID',
//        ];
//    }
    
//    public function search($params) {
//        
//        $query = TblStaffRoc::find();
//        
//        //$query->with('department');
//        // add conditions that should always apply here
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'pagination' => [
//                //'pageSize' => 20,
//                'pageSize' => 5,
//                ],
//            'sort' => false,
//        ]);
//
//        $this->load($params);
//
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }
//
//        // grid filtering conditions
//        $query->andFilterWhere([
//            'SR_ENTRY_BATCH' => $this->SR_ENTRY_BATCH,
//        ]);
//
////        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
////                ->andFilterWhere(['like', 'ReligionCd', $this->ReligionCd])
////                ->andFilterWhere(['like', 'RaceCd', $this->RaceCd])
////                ->andFilterWhere(['like', 'EthnicCd', $this->EthnicCd])
////                ->andFilterWhere(['like', 'ArmyPoliceCd', $this->ArmyPoliceCd])
////                ->andFilterWhere(['like', 'BloodTypeCd', $this->BloodTypeCd])
////                ->andFilterWhere(['like', 'MrtlStatusCd', $this->MrtlStatusCd])
////                ->andFilterWhere(['like', 'TitleCd', $this->TitleCd])
////                ->andFilterWhere(['like', 'GenderCd', $this->GenderCd])
////                ->andFilterWhere(['like', 'COBirthPlaceCd', $this->COBirthPlaceCd])
////                ->andFilterWhere(['like', 'COBirthCountryCd', $this->COBirthCountryCd])
////                ->andFilterWhere(['like', 'NegaraAsalCd', $this->NegaraAsalCd])
////                ->andFilterWhere(['like', 'NegeriAsalCd', $this->NegeriAsalCd])
////                ->andFilterWhere(['like', 'NatCd', $this->NatCd])
////                ->andFilterWhere(['like', 'NatStatusCd', $this->NatStatusCd])
////                ->andFilterWhere(['like', 'CONm', $this->CONm])
////                ->andFilterWhere(['like', 'COEmail', $this->COEmail])
////                ->andFilterWhere(['like', 'COEmail2', $this->COEmail2])
////                ->andFilterWhere(['like', 'COOldID', $this->COOldID])
////                ->andFilterWhere(['like', 'COBirthCertNo', $this->COBirthCertNo])
////                ->andFilterWhere(['like', 'COHPhoneNo', $this->COHPhoneNo])
////                ->andFilterWhere(['like', 'COOffTelNo', $this->COOffTelNo])
////                ->andFilterWhere(['like', 'COOffTelNoExtn', $this->COOffTelNoExtn])
////                ->andFilterWhere(['like', 'COOffTelNoExtn2', $this->COOffTelNoExtn2])
////                ->andFilterWhere(['like', 'COOPass', $this->COOPass])
////                ->andFilterWhere(['like', 'COHPhoneStatus', $this->COHPhoneStatus])
////                ->andFilterWhere(['like', 'gredJawatan_2', $this->gredJawatan_2])
////                ->andFilterWhere(['like', 'jawatanTadbir', $this->jawatanTadbir])
////                ->andFilterWhere(['like', 'last_updater', $this->last_updater])
////                ->andFilterWhere(['like', 'pp', $this->pp])
////                ->andFilterWhere(['like', 'bos', $this->bos])
////                ->andFilterWhere(['like', 'program_ums', $this->program_ums])
////                ->andFilterWhere(['=', 'DeptId', $this->DeptId]);
//
//        return $dataProvider;
//    }
    
    public function getStaffRoc() {
        return $this->hasMany(TblStaffRoc::className(), ['SR_ENTRY_BATCH' => 'srb_batch_code']);
    }
    
    public function getSumOld() {
        return $this->hasMany(TblStaffRoc::className(), ['SR_ENTRY_BATCH' => 'srb_batch_code'])->sum('SR_OLD_VALUE');
    }
    
    public function getSumNew() {
        return $this->hasMany(TblStaffRoc::className(), ['SR_ENTRY_BATCH' => 'srb_batch_code'])->sum('SR_NEW_VALUE');
    }
    
    public function getReason() {
        return $this->hasOne(RefRocReason::className(), ['RR_REASON_CODE' => 'srb_change_reason']);
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['COOldID' => 'srb_approve_by']);
    }
    
    public function getDepartment() {
        return $this->hasOne(TblDepartment::className(), ['dm_dept_code' => 'srb_dept_code']);
    }
    
    public function getBiodataSendiri() {
        return $this->hasOne(Tblprcobiodata::className(), ['COOldID' => 'srb_staff_id']);
    }
    
    public function getBrpData() {
        return $this->hasOne(\app\models\brp\Tblrscobrp::className(), ['t_lpg_id' => 'srb_batch_code']);
    }
    
        public function getStaffRoc3() {
        return $this->hasOne(TblStaffRoc::className(), ['SR_STAFF_ID' => 'srb_staff_id'])->where(['SR_ROC_TYPE' => 'B1000'])->orderBy(['SR_APPROVE_DATE' => SORT_DESC])->one();
    }
    
    public function getStaffRoc2()
    {
        return $this->hasMany(TblStaffRocSmbu::className(), ['SR_ENTRY_BATCH' => 'srb_batch_code'])->orderBy(['SR_ROC_TYPE' => SORT_ASC]);
    }
    
    public function getBiodataTerbaru() {
        return $this->hasOne(Umsper::className(), ['COOldID' => 'srb_staff_id'])->orderBy(['StartDate'=>SORT_ASC]);
    }
    
      public function getStaffRocOne()
    {
        return $this->hasOne(TblStaffRocSmbu::className(), ['SR_ENTRY_BATCH' => 'srb_batch_code']);
    }
    
    
}