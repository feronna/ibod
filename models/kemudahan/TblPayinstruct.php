<?php

namespace app\models\kemudahan;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "utilities.fac_tbl_pay_instruct".
 *
 * @property int $PAY_ID
 * @property int $PAY_REF_ID
 * @property int $PAY_ELAUN_ID
 * @property string $PAY_STAFF_ICNO
 * @property string $PAY_CMPY_CODE
 * @property string $PAY_STAFF_ID
 * @property string $PAY_CHANGE_TYPE
 * @property string $PAY_ROC_TYPE
 * @property string $PAY_DATE_FROM
 * @property string $PAY_DATE_TO
 * @property string $PAY_NEW_VALUE
 * @property string $PAY_CALC_TYPE
 * @property string $PAY_ACCOUNT_NO
 * @property string $PAY_ACCHOLDER_NAME
 * @property string $PAY_CCTR_CHARGE
 * @property string $PAY_PROJECT_CODE
 * @property string $PAY_ALLOWANCE_CODE
 * @property string $PAY_ENTRY_BATCH
 * @property string $PAY_CHANGE_REASON
 * @property string $PAY_REMARK
 * @property string $PAY_STATUS
 * @property string $PAY_ENTER_BY
 * @property string $PAY_ENTER_DATE
 * @property string $PAY_VERIFY_BY
 * @property string $PAY_VERIFY_DATE
 * @property string $PAY_APPROVE_BY
 * @property string $PAY_APPROVE_DATE
 * @property string $PAY_CANCEL_BY
 * @property string $PAY_CANCEL_DATE
 * @property string $PAY_CANCEL_REASON
 * @property string $PAY_UPDATE_BY
 * @property string $PAY_UPDATE_DATE
 * @property string $PAY_UPDATE_SEQ_NO
 * @property string $PAY_PROCESS_REMARK
 * @property string $PAY_GLPROGRAM_CODE
 * @property string $PAY_PRINT
 * @property string $PAY_PROCESS_DEPT
 * @property int $PAY_PARENT_ID
 * @property int $PAY_ENTRY_TYPE 1 - mohon dalam talian, 2 - dimohon oleh pegawai
 */
class TblPayinstruct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_tbl_pay_instruct';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PAY_REF_ID', 'PAY_ELAUN_ID', 'PAY_PARENT_ID', 'PAY_ENTRY_TYPE'], 'integer'],
            [['PAY_DATE_FROM', 'PAY_DATE_TO', 'PAY_ENTER_DATE', 'PAY_VERIFY_DATE', 'PAY_APPROVE_DATE', 'PAY_CANCEL_DATE', 'PAY_UPDATE_DATE'], 'safe'],
            [['PAY_NEW_VALUE'], 'number'],
            [['PAY_REMARK', 'PAY_CANCEL_REASON', 'PAY_PROCESS_REMARK'], 'string'],
            [['PAY_STAFF_ICNO'], 'string', 'max' => 12],
            [['PAY_CMPY_CODE', 'PAY_CALC_TYPE', 'PAY_CCTR_CHARGE', 'PAY_STATUS', 'PAY_GLPROGRAM_CODE', 'PAY_PRINT', 'PAY_PROCESS_DEPT'], 'string', 'max' => 10],
            [['PAY_STAFF_ID', 'PAY_ROC_TYPE', 'PAY_PROJECT_CODE', 'PAY_ALLOWANCE_CODE', 'PAY_CHANGE_REASON', 'PAY_ENTER_BY', 'PAY_VERIFY_BY', 'PAY_APPROVE_BY', 'PAY_CANCEL_BY', 'PAY_UPDATE_BY'], 'string', 'max' => 30],
            [['PAY_CHANGE_TYPE', 'PAY_ACCOUNT_NO', 'PAY_ENTRY_BATCH', 'PAY_UPDATE_SEQ_NO'], 'string', 'max' => 50],
            [['PAY_ACCHOLDER_NAME'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PAY_ID' => 'Pay  ID',
            'PAY_REF_ID' => 'Pay  Ref  ID',
            'PAY_ELAUN_ID' => 'Pay  Elaun  ID',
            'PAY_STAFF_ICNO' => 'Pay  Staff  Icno',
            'PAY_CMPY_CODE' => 'Pay  Cmpy  Code',
            'PAY_STAFF_ID' => 'Pay  Staff  ID',
            'PAY_CHANGE_TYPE' => 'Pay  Change  Type',
            'PAY_ROC_TYPE' => 'Pay  Roc  Type',
            'PAY_DATE_FROM' => 'Pay  Date  From',
            'PAY_DATE_TO' => 'Pay  Date  To',
            'PAY_NEW_VALUE' => 'Pay  New  Value',
            'PAY_CALC_TYPE' => 'Pay  Calc  Type',
            'PAY_ACCOUNT_NO' => 'Pay  Account  No',
            'PAY_ACCHOLDER_NAME' => 'Pay  Accholder  Name',
            'PAY_CCTR_CHARGE' => 'Pay  Cctr  Charge',
            'PAY_PROJECT_CODE' => 'Pay  Project  Code',
            'PAY_ALLOWANCE_CODE' => 'Pay  Allowance  Code',
            'PAY_ENTRY_BATCH' => 'Pay  Entry  Batch',
            'PAY_CHANGE_REASON' => 'Pay  Change  Reason',
            'PAY_REMARK' => 'Pay  Remark',
            'PAY_STATUS' => 'Pay  Status',
            'PAY_ENTER_BY' => 'Pay  Enter  By',
            'PAY_ENTER_DATE' => 'Pay  Enter  Date',
            'PAY_VERIFY_BY' => 'Pay  Verify  By',
            'PAY_VERIFY_DATE' => 'Pay  Verify  Date',
            'PAY_APPROVE_BY' => 'Pay  Approve  By',
            'PAY_APPROVE_DATE' => 'Pay  Approve  Date',
            'PAY_CANCEL_BY' => 'Pay  Cancel  By',
            'PAY_CANCEL_DATE' => 'Pay  Cancel  Date',
            'PAY_CANCEL_REASON' => 'Pay  Cancel  Reason',
            'PAY_UPDATE_BY' => 'Pay  Update  By',
            'PAY_UPDATE_DATE' => 'Pay  Update  Date',
            'PAY_UPDATE_SEQ_NO' => 'Pay  Update  Seq  No',
            'PAY_PROCESS_REMARK' => 'Pay  Process  Remark',
            'PAY_GLPROGRAM_CODE' => 'Pay  Glprogram  Code',
            'PAY_PRINT' => 'Pay  Print',
            'PAY_PROCESS_DEPT' => 'Pay  Process  Dept',
            'PAY_PARENT_ID' => 'Pay  Parent  ID',
            'PAY_ENTRY_TYPE' => 'Pay  Entry  Type',
        ];
    }
    public function getTarikh($bulan){
        
        $m = date_format(date_create($bulan), "m");
        if($m == 01){
            $m = "01";}
        elseif ($m == 02){
          $m = "02";}
        elseif ($m == 03){
          $m = "03";}
        elseif ($m == 04){
          $m = "04";}
        elseif ($m == 05){
          $m = "05";}
        elseif ($m == 06){
          $m = "06";}
        elseif ($m == 07){
          $m = "07";}
        elseif ($m == '08'){
          $m = "08";}
        elseif ($m == '09'){
          $m = "09";}
        elseif ($m == '10'){
          $m = "10";}
        elseif ($m == '11'){
          $m = "11";}
        elseif ($m == '12'){
          $m = "12";}
          
        return date_format(date_create($bulan), "d-").' '.$m.' '.date_format(date_create($bulan), "-Y");
    }
    public function getDatefrom() {
        if ($this->PAY_DATE_FROM != '') {
            return $this->getTarikh($this->PAY_DATE_FROM);
        }
    }
    public function getDateuntil() {
        if ($this->PAY_DATE_TO != '') {
            return $this->getTarikh($this->PAY_DATE_TO);
        }
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'PAY_STAFF_ICNO']);
    }
     public function getViewelaun() {
        return $this->hasOne(Refjeniskemudahan::className(), ['kemudahancd' => 'elaun_kemudahan']);
    }
    public function getPayDetails() {
        return $this->hasOne(TblPayInstructDetails::className(), ['id' => 'PAY_ID']);
    }
     public function getElaunPakaian() {
        return $this->hasOne(Refjeniskemudahan::className(), ['kemudahancd' => 'PAY_ELAUN_ID']);
    }
     public function getAppDt() {
        if ($this->approver_date != '') {
            return $this->getTarikh($this->approver_date);
        }
    } 
}
