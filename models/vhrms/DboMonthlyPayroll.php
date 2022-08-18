<?php

namespace app\models\vhrms;

use Yii;

/**
 * This is the model class for table "dbo.monthly_payroll".
 *
 * @property string $MP_PAY_MONTH
 * @property string $MP_STAFF_ID
 * @property string $MP_PROCESS
 * @property string $MP_DEPT_CODE
 * @property string $MP_EXECUTIVE_STS
 * @property string $MP_PAY_DATE
 * @property string $MP_BANK_CODE
 * @property string $MP_BANK_ACC_NO
 * @property string $MP_CHARGE_TAX
 * @property string $MP_CHARGE_EPF
 * @property string $MP_CHARGE_SOCSO
 * @property string $MP_BASIC_PAY
 * @property string $MP_TOTAL_ALLOWANCE
 * @property string $MP_TOTAL_DEDUCTION
 * @property string $MP_EPFABLE_AMT
 * @property string $MP_TAXABLE_AMT
 * @property string $MP_SOCSOABLE_AMT
 * @property string $MP_NETT_SALARY
 * @property string $MP_NO_OF_CHILD
 * @property string $MP_PAYMENT_TYPE
 * @property string $MP_STATUS
 * @property string $MP_TAX_CATEGORY
 * @property string $MP_CHARGE_ZAKAT
 * @property string $MP_PROCESS_BY
 * @property string $MP_PROJECT_CODE
 * @property string $MP_PROCESS_TYPE
 * @property string $MP_PAYMENT_MODE
 * @property string $MP_CMPY_CODE
 * @property string $MP_BRANCH_CODE
 * @property string $MP_UPDATE_BY
 * @property string $MP_UPDATE_DATE
 * @property string $MP_SUSPEND_REASON
 * @property string $MP_JOB_CODE
 * @property string $mp_process_date
 * @property string $mp_taxfamily_ref
 * @property string $mp_tax_formula
 * @property string $mp_bik_amt
 * @property string $mp_vola_amt
 * @property string $mp_epf_type
 * @property string $mp_socso_type
 * @property string $mp_unit_code
 * @property string $mp_charge_pension
 */
class DboMonthlyPayroll extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.monthly_payroll';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MP_PAY_MONTH', 'MP_STAFF_ID', 'MP_PROCESS', 'MP_CMPY_CODE'], 'required'],
            [['MP_PROCESS', 'MP_BASIC_PAY', 'MP_TOTAL_ALLOWANCE', 'MP_TOTAL_DEDUCTION', 'MP_EPFABLE_AMT', 'MP_TAXABLE_AMT', 'MP_SOCSOABLE_AMT', 'MP_NETT_SALARY', 'MP_NO_OF_CHILD', 'mp_bik_amt', 'mp_vola_amt'], 'number'],
            [['MP_PAY_DATE', 'MP_UPDATE_DATE', 'mp_process_date'], 'safe'],
            [['MP_PAY_MONTH'], 'string', 'max' => 7],
            [['MP_STAFF_ID', 'MP_PROCESS_BY', 'MP_PROJECT_CODE', 'MP_PROCESS_TYPE', 'MP_UPDATE_BY', 'MP_JOB_CODE'], 'string', 'max' => 30],
            [['MP_DEPT_CODE', 'MP_BANK_CODE', 'MP_PAYMENT_TYPE', 'MP_STATUS', 'MP_TAX_CATEGORY', 'MP_CMPY_CODE', 'MP_BRANCH_CODE', 'mp_tax_formula', 'mp_epf_type', 'mp_socso_type', 'mp_unit_code'], 'string', 'max' => 10],
            [['MP_EXECUTIVE_STS', 'MP_CHARGE_TAX', 'MP_CHARGE_EPF', 'MP_CHARGE_SOCSO', 'MP_CHARGE_ZAKAT', 'mp_charge_pension'], 'string', 'max' => 1],
            [['MP_BANK_ACC_NO', 'MP_PAYMENT_MODE'], 'string', 'max' => 20],
            [['MP_SUSPEND_REASON'], 'string', 'max' => 500],
            [['mp_taxfamily_ref'], 'string', 'max' => 50],
            [['MP_CMPY_CODE', 'MP_PAY_MONTH', 'MP_PROCESS', 'MP_STAFF_ID'], 'unique', 'targetAttribute' => ['MP_CMPY_CODE', 'MP_PAY_MONTH', 'MP_PROCESS', 'MP_STAFF_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'MP_PAY_MONTH' => 'Mp Pay Month',
            'MP_STAFF_ID' => 'Mp Staff ID',
            'MP_PROCESS' => 'Mp Process',
            'MP_DEPT_CODE' => 'Mp Dept Code',
            'MP_EXECUTIVE_STS' => 'Mp Executive Sts',
            'MP_PAY_DATE' => 'Mp Pay Date',
            'MP_BANK_CODE' => 'Mp Bank Code',
            'MP_BANK_ACC_NO' => 'Mp Bank Acc No',
            'MP_CHARGE_TAX' => 'Mp Charge Tax',
            'MP_CHARGE_EPF' => 'Mp Charge Epf',
            'MP_CHARGE_SOCSO' => 'Mp Charge Socso',
            'MP_BASIC_PAY' => 'Mp Basic Pay',
            'MP_TOTAL_ALLOWANCE' => 'Mp Total Allowance',
            'MP_TOTAL_DEDUCTION' => 'Mp Total Deduction',
            'MP_EPFABLE_AMT' => 'Mp Epfable Amt',
            'MP_TAXABLE_AMT' => 'Mp Taxable Amt',
            'MP_SOCSOABLE_AMT' => 'Mp Socsoable Amt',
            'MP_NETT_SALARY' => 'Mp Nett Salary',
            'MP_NO_OF_CHILD' => 'Mp No Of Child',
            'MP_PAYMENT_TYPE' => 'Mp Payment Type',
            'MP_STATUS' => 'Mp Status',
            'MP_TAX_CATEGORY' => 'Mp Tax Category',
            'MP_CHARGE_ZAKAT' => 'Mp Charge Zakat',
            'MP_PROCESS_BY' => 'Mp Process By',
            'MP_PROJECT_CODE' => 'Mp Project Code',
            'MP_PROCESS_TYPE' => 'Mp Process Type',
            'MP_PAYMENT_MODE' => 'Mp Payment Mode',
            'MP_CMPY_CODE' => 'Mp Cmpy Code',
            'MP_BRANCH_CODE' => 'Mp Branch Code',
            'MP_UPDATE_BY' => 'Mp Update By',
            'MP_UPDATE_DATE' => 'Mp Update Date',
            'MP_SUSPEND_REASON' => 'Mp Suspend Reason',
            'MP_JOB_CODE' => 'Mp Job Code',
            'mp_process_date' => 'Mp Process Date',
            'mp_taxfamily_ref' => 'Mp Taxfamily Ref',
            'mp_tax_formula' => 'Mp Tax Formula',
            'mp_bik_amt' => 'Mp Bik Amt',
            'mp_vola_amt' => 'Mp Vola Amt',
            'mp_epf_type' => 'Mp Epf Type',
            'mp_socso_type' => 'Mp Socso Type',
            'mp_unit_code' => 'Mp Unit Code',
            'mp_charge_pension' => 'Mp Charge Pension',
        ];
    }
}
