<?php

namespace app\models\hronline_gaji;

use app\models\hronline\Umsper;

use Yii;

/**
 * This is the model class for table "hronline_gaji.monthly_payment_detl".
 *
 * @property string $MPD_PAY_MONTH
 * @property string $MPD_CMPY_CODE
 * @property string $MPD_STAFF_ID
 * @property int $MPD_PROCESS
 * @property string $MPD_INCOME_CODE
 * @property double $MPD_PAID_AMT
 * @property string $MPD_COSTCTR_CHARGE
 * @property double $MPD_TAXABLE_AMT
 * @property string $MPD_PROJECT_CODE
 * @property string $MPD_SOURCE_REF
 * @property string $MPD_SOURCE_TYPE
 * @property string $MPD_ACCHOLDER_NAME
 * @property string $MPD_ACCOUNT_NO
 * @property string $MPD_SALARY_MONTH
 * @property string $MPD_REF_CODE
 * @property string $MPD_CMPYCODE_CHRGE
 * @property string $MPD_BRANCH_CHRGE
 * @property string $MPD_FUNDCODE_CHRGE
 * @property string $MPD_DEPTCODE_CHRGE
 * @property int $MPD_VOT_CHRGE
 * @property string $MPD_PROGRAM_CHRGE
 * @property string $MPD_ACTIVITY_CHRGE
 * @property string $MPD_ACCT_CODE
 * @property string $MPD_CREDIT_CODE
 */
class Tblmonthly_payment_detl extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'hrm.gaji_monthly_payment_detl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MPD_PROCESS', 'MPD_VOT_CHRGE'], 'integer'],
            [['MPD_PAID_AMT', 'MPD_TAXABLE_AMT'], 'number'],
            [['MPD_PAY_MONTH', 'MPD_CMPY_CODE', 'MPD_COSTCTR_CHARGE', 'MPD_SALARY_MONTH', 'MPD_CMPYCODE_CHRGE', 'MPD_BRANCH_CHRGE'], 'string', 'max' => 20],
            [['MPD_STAFF_ID', 'MPD_INCOME_CODE', 'MPD_SOURCE_REF', 'MPD_SOURCE_TYPE', 'MPD_ACCOUNT_NO', 'MPD_DEPTCODE_CHRGE', 'MPD_PROGRAM_CHRGE', 'MPD_ACTIVITY_CHRGE', 'MPD_ACCT_CODE', 'MPD_CREDIT_CODE'], 'string', 'max' => 25],
            [['MPD_PROJECT_CODE'], 'string', 'max' => 15],
            [['MPD_ACCHOLDER_NAME'], 'string', 'max' => 50],
            [['MPD_REF_CODE'], 'string', 'max' => 100],
            [['MPD_FUNDCODE_CHRGE'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'MPD_PAY_MONTH' => 'Mpd Pay Month',
            'MPD_CMPY_CODE' => 'Mpd Cmpy Code',
            'MPD_STAFF_ID' => 'Mpd Staff ID',
            'MPD_PROCESS' => 'Mpd Process',
            'MPD_INCOME_CODE' => 'Income Code',
            'MPD_PAID_AMT' => 'Paid Amount',
            'MPD_COSTCTR_CHARGE' => 'Mpd Costctr Charge',
            'MPD_TAXABLE_AMT' => 'Mpd Taxable Amt',
            'MPD_PROJECT_CODE' => 'Mpd Project Code',
            'MPD_SOURCE_REF' => 'Mpd Source Ref',
            'MPD_SOURCE_TYPE' => 'Mpd Source Type',
            'MPD_ACCHOLDER_NAME' => 'Mpd Accholder Name',
            'MPD_ACCOUNT_NO' => 'Mpd Account No',
            'MPD_SALARY_MONTH' => 'Mpd Salary Month',
            'MPD_REF_CODE' => 'Mpd Ref Code',
            'MPD_CMPYCODE_CHRGE' => 'Mpd Cmpycode Chrge',
            'MPD_BRANCH_CHRGE' => 'Mpd Branch Chrge',
            'MPD_FUNDCODE_CHRGE' => 'Mpd Fundcode Chrge',
            'MPD_DEPTCODE_CHRGE' => 'Mpd Deptcode Chrge',
            'MPD_VOT_CHRGE' => 'Mpd Vot Chrge',
            'MPD_PROGRAM_CHRGE' => 'Mpd Program Chrge',
            'MPD_ACTIVITY_CHRGE' => 'Mpd Activity Chrge',
            'MPD_ACCT_CODE' => 'Mpd Acct Code',
            'MPD_CREDIT_CODE' => 'Mpd Credit Code',
        ];
    }

    public function getUmsper() {
        return $this->hasOne(Umsper::className(), ['COOldID' => 'MPD_STAFF_ID']);
    }

    public function getElaun() {
        return $this->hasOne(IncomeType::className(), ['it_income_code' => 'MPD_INCOME_CODE']);
    }
}
