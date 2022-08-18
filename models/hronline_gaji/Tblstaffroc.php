<?php

namespace app\models\hronline_gaji;

use Yii;
use app\models\hronline\Tblprcobiodata;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "hronline_gaji.staff_roc".
 *
 * @property string $SR_REF_ID
 * @property string $SR_CMPY_CODE
 * @property string $SR_STAFF_ID
 * @property string $SR_CHANGE_TYPE
 * @property string $SR_ROC_TYPE
 * @property string $SR_DATE_FROM
 * @property string $SR_DATE_TO
 * @property string $SR_NEW_VALUE
 * @property string $SR_CALC_TYPE
 * @property string $SR_ACCOUNT_NO
 * @property string $SR_ACCHOLDER_NAME
 * @property string $SR_CCTR_CHARGE
 * @property string $SR_PROJECT_CODE
 * @property string $SR_ALLOWANCE_CODE
 * @property string $SR_ENTRY_BATCH
 * @property string $SR_CHANGE_REASON
 * @property string $SR_OLD_VALUE
 * @property string $SR_OLD_CCTR_CHARGE
 * @property string $SR_OLD_PROJECT_CODE
 * @property string $SR_OLD_ACCOUNT_NO
 * @property string $SR_OLD_ACCHOLDER_NAME
 * @property string $SR_ACTUAL_MONTH
 * @property string $SR_REMARK
 * @property string $SR_STATUS
 * @property string $SR_ENTER_BY
 * @property string $SR_ENTER_DATE
 * @property string $SR_VERIFY_BY
 * @property string $SR_VERIFY_DATE
 * @property string $SR_APPROVE_BY
 * @property string $SR_APPROVE_DATE
 * @property string $SR_CANCEL_BY
 * @property string $SR_CANCEL_DATE
 * @property string $SR_CANCEL_REASON
 * @property string $SR_UPDATE_BY
 * @property string $SR_UPDATE_DATE
 * @property string $SR_SUBSYSTEM
 * @property string $SR_SUBSYSTEM_REFID
 * @property string $SR_PA_SEQ_NO
 * @property string $sr_update_seq_no
 * @property string $sr_process_remark
 * @property string $sr_glprogram_code
 * @property string $sr_print
 * @property string $sr_process_dept
 */
class Tblstaffroc extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'hrm.gaji_staff_roc';
    }

    public function rules()
    {
        return [
            [['SR_REF_ID', 'SR_CMPY_CODE', 'SR_CHANGE_TYPE', 'SR_ROC_TYPE', 'SR_CHANGE_REASON'], 'required'],
            [['SR_DATE_FROM', 'SR_DATE_TO', 'SR_ACTUAL_MONTH', 'SR_ENTER_DATE', 'SR_VERIFY_DATE', 'SR_APPROVE_DATE', 'SR_CANCEL_DATE', 'SR_UPDATE_DATE'], 'safe'],
            [['SR_NEW_VALUE', 'SR_OLD_VALUE'], 'number'],
            [['SR_REMARK', 'SR_CANCEL_REASON', 'sr_process_remark'], 'string'],
            [['SR_REF_ID', 'SR_CHANGE_TYPE', 'SR_ACCOUNT_NO', 'SR_ENTRY_BATCH', 'SR_OLD_ACCOUNT_NO', 'SR_SUBSYSTEM', 'SR_SUBSYSTEM_REFID', 'SR_PA_SEQ_NO', 'sr_update_seq_no'], 'string', 'max' => 50],
            [['SR_CMPY_CODE', 'SR_CALC_TYPE', 'SR_CCTR_CHARGE', 'SR_OLD_CCTR_CHARGE', 'SR_STATUS', 'sr_glprogram_code', 'sr_print', 'sr_process_dept'], 'string', 'max' => 10],
            [['SR_STAFF_ID', 'SR_ROC_TYPE', 'SR_PROJECT_CODE', 'SR_ALLOWANCE_CODE', 'SR_CHANGE_REASON', 'SR_OLD_PROJECT_CODE', 'SR_ENTER_BY', 'SR_VERIFY_BY', 'SR_APPROVE_BY', 'SR_CANCEL_BY', 'SR_UPDATE_BY'], 'string', 'max' => 30],
            [['SR_ACCHOLDER_NAME', 'SR_OLD_ACCHOLDER_NAME'], 'string', 'max' => 100],
            [['SR_REF_ID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SR_REF_ID' => 'Sr Ref ID',
            'SR_CMPY_CODE' => 'Sr Cmpy Code',
            'SR_STAFF_ID' => 'Sr Staff ID',
            'SR_CHANGE_TYPE' => 'Sr Change Type',
            'SR_ROC_TYPE' => 'Sr Roc Type',
            'SR_DATE_FROM' => 'Sr Date From',
            'SR_DATE_TO' => 'Sr Date To',
            'SR_NEW_VALUE' => 'Sr New Value',
            'SR_CALC_TYPE' => 'Sr Calc Type',
            'SR_ACCOUNT_NO' => 'Sr Account No',
            'SR_ACCHOLDER_NAME' => 'Sr Accholder Name',
            'SR_CCTR_CHARGE' => 'Sr Cctr Charge',
            'SR_PROJECT_CODE' => 'Sr Project Code',
            'SR_ALLOWANCE_CODE' => 'Sr Allowance Code',
            'SR_ENTRY_BATCH' => 'Sr Entry Batch',
            'SR_CHANGE_REASON' => 'Sr Change Reason',
            'SR_OLD_VALUE' => 'Sr Old Value',
            'SR_OLD_CCTR_CHARGE' => 'Sr Old Cctr Charge',
            'SR_OLD_PROJECT_CODE' => 'Sr Old Project Code',
            'SR_OLD_ACCOUNT_NO' => 'Sr Old Account No',
            'SR_OLD_ACCHOLDER_NAME' => 'Sr Old Accholder Name',
            'SR_ACTUAL_MONTH' => 'Sr Actual Month',
            'SR_REMARK' => 'Sr Remark',
            'SR_STATUS' => 'Sr Status',
            'SR_ENTER_BY' => 'Sr Enter By',
            'SR_ENTER_DATE' => 'Sr Enter Date',
            'SR_VERIFY_BY' => 'Sr Verify By',
            'SR_VERIFY_DATE' => 'Sr Verify Date',
            'SR_APPROVE_BY' => 'Sr Approve By',
            'SR_APPROVE_DATE' => 'Sr Approve Date',
            'SR_CANCEL_BY' => 'Sr Cancel By',
            'SR_CANCEL_DATE' => 'Sr Cancel Date',
            'SR_CANCEL_REASON' => 'Sr Cancel Reason',
            'SR_UPDATE_BY' => 'Sr Update By',
            'SR_UPDATE_DATE' => 'Sr Update Date',
            'SR_SUBSYSTEM' => 'Sr Subsystem',
            'SR_SUBSYSTEM_REFID' => 'Sr Subsystem Refid',
            'SR_PA_SEQ_NO' => 'Sr Pa Seq No',
            'sr_update_seq_no' => 'Sr Update Seq No',
            'sr_process_remark' => 'Sr Process Remark',
            'sr_glprogram_code' => 'Sr Glprogram Code',
            'sr_print' => 'Sr Print',
            'sr_process_dept' => 'Sr Process Dept',
        ];
    }

    public function search($params) {
        
        $query = Tblstaffroc::find()->orderBy(['SR_CHANGE_TYPE' => 'ASC']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        var_dump($this->SR_ENTRY_BATCH);
        die;

        // grid filtering conditions
        $query->andFilterWhere([
            'SR_ENTRY_BATCH' => $this->SR_ENTRY_BATCH,
        ]);

        return $dataProvider;
    }

    public function getReason() {
        return $this->hasOne(roc_reason::className(), ['RR_REASON_CODE' => 'SR_CHANGE_REASON']);
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['COOldID' => 'SR_VERIFY_BY']);
    }
    
    public function getElaun() {
        return $this->hasOne(IncomeType::className(), ['it_income_code' => 'SR_ROC_TYPE']);
    }
    
    public function getElaunn() {
        return $this->hasOne(income_code_mapping::className(), ['income_code' => 'SR_ROC_TYPE']);
    }

    public function getElaunnn() {
        return $this->hasOne(IncomeType::className(), ['it_income_code' => 'SR_ROC_TYPE']);
    }

   
}
