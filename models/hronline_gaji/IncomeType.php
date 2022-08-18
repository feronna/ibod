<?php

namespace app\models\hronline_gaji;

use Yii;

/**
 * This is the model class for table "hronline_gaji.migbkp_incometype_180226".
 *
 * @property string $it_income_code
 * @property string $it_account_name
 * @property string $it_acct_code
 * @property string $it_acct_samb
 * @property string $it_activity_chrge
 * @property string $it_allow_type_flag
 * @property string $it_apply_online
 * @property string $it_arrear_code
 * @property string $it_arrears
 * @property string $it_awol_deduct
 * @property string $it_branch_chrge
 * @property string $it_cctr_charge
 * @property string $it_cmpy_code
 * @property string $it_cmpycode_chrge
 * @property string $it_credit_code
 * @property string $it_decentralized
 * @property string $it_deduction_code
 * @property string $it_deptcode_chrge
 * @property string $it_eaform_code
 * @property string $it_eaform_itemcode
 * @property string $it_enter_by
 * @property string $it_enter_date
 * @property string $it_epf_deductable
 * @property string $it_fundcode_chrge
 * @property string $it_group_type
 * @property string $it_income_desc
 * @property string $it_income_desc_alt
 * @property string $it_income_shdesc
 * @property string $it_income_shdesc_alt
 * @property string $it_jl_tag
 * @property string $it_max_tax_exemption
 * @property string $it_old_code
 * @property string $it_ot_deductable
 * @property string $it_payment_cctr
 * @property string $it_payto_id
 * @property string $it_process_type
 * @property string $it_program_chrge
 * @property string $it_project_code
 * @property string $it_rank
 * @property string $it_remarks
 * @property string $it_roc
 * @property string $it_socso_deductable
 * @property string $it_status
 * @property string $it_system_code
 * @property string $it_tax_deductable
 * @property string $it_tax_flag
 * @property string $it_tax_type
 * @property string $it_taxable_pct
 * @property string $it_trans_type
 * @property string $it_update_by
 * @property string $it_update_date
 * @property string $it_user_code
 * @property string $it_vot_chrge
 * @property string $it_serious_debt
 */
class IncomeType extends \yii\db\ActiveRecord
{
    
    // public static function getDb() {
    //     return Yii::$app->get('db2'); 
    // }

    public static function tableName()
    {
        return 'hrm.gaji_migbkp_incometype_180226';
    }

    public function rules()
    {
        return [
            [['it_income_code', 'it_cmpy_code'], 'required'],
            [['it_enter_date', 'it_update_date'], 'safe'],
            [['it_max_tax_exemption', 'it_rank', 'it_taxable_pct'], 'number'],
            [['it_income_code', 'it_acct_code', 'it_activity_chrge', 'it_arrear_code', 'it_branch_chrge', 'it_cctr_charge', 'it_cmpy_code', 'it_cmpycode_chrge', 'it_credit_code', 'it_deduction_code', 'it_deptcode_chrge', 'it_fundcode_chrge', 'it_jl_tag', 'it_payment_cctr', 'it_status', 'it_tax_flag', 'it_tax_type', 'it_trans_type', 'it_vot_chrge'], 'string', 'max' => 10],
            [['it_account_name', 'it_acct_samb', 'it_allow_type_flag', 'it_eaform_code', 'it_eaform_itemcode', 'it_income_desc', 'it_income_desc_alt', 'it_old_code', 'it_remarks', 'it_user_code'], 'string', 'max' => 255],
            [['it_apply_online', 'it_arrears', 'it_awol_deduct', 'it_decentralized', 'it_epf_deductable', 'it_ot_deductable', 'it_roc', 'it_socso_deductable', 'it_tax_deductable'], 'string', 'max' => 1],
            [['it_enter_by', 'it_update_by'], 'string', 'max' => 30],
            [['it_group_type', 'it_process_type'], 'string', 'max' => 60],
            [['it_income_shdesc', 'it_income_shdesc_alt', 'it_program_chrge', 'it_project_code', 'it_system_code', 'it_serious_debt'], 'string', 'max' => 50],
            [['it_payto_id'], 'string', 'max' => 15],
            [['it_income_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'it_income_code' => 'It Income Code',
            'it_account_name' => 'It Account Name',
            'it_acct_code' => 'It Acct Code',
            'it_acct_samb' => 'It Acct Samb',
            'it_activity_chrge' => 'It Activity Chrge',
            'it_allow_type_flag' => 'It Allow Type Flag',
            'it_apply_online' => 'It Apply Online',
            'it_arrear_code' => 'It Arrear Code',
            'it_arrears' => 'It Arrears',
            'it_awol_deduct' => 'It Awol Deduct',
            'it_branch_chrge' => 'It Branch Chrge',
            'it_cctr_charge' => 'It Cctr Charge',
            'it_cmpy_code' => 'It Cmpy Code',
            'it_cmpycode_chrge' => 'It Cmpycode Chrge',
            'it_credit_code' => 'It Credit Code',
            'it_decentralized' => 'It Decentralized',
            'it_deduction_code' => 'It Deduction Code',
            'it_deptcode_chrge' => 'It Deptcode Chrge',
            'it_eaform_code' => 'It Eaform Code',
            'it_eaform_itemcode' => 'It Eaform Itemcode',
            'it_enter_by' => 'It Enter By',
            'it_enter_date' => 'It Enter Date',
            'it_epf_deductable' => 'It Epf Deductable',
            'it_fundcode_chrge' => 'It Fundcode Chrge',
            'it_group_type' => 'It Group Type',
            'it_income_desc' => 'It Income Desc',
            'it_income_desc_alt' => 'It Income Desc Alt',
            'it_income_shdesc' => 'It Income Shdesc',
            'it_income_shdesc_alt' => 'It Income Shdesc Alt',
            'it_jl_tag' => 'It Jl Tag',
            'it_max_tax_exemption' => 'It Max Tax Exemption',
            'it_old_code' => 'It Old Code',
            'it_ot_deductable' => 'It Ot Deductable',
            'it_payment_cctr' => 'It Payment Cctr',
            'it_payto_id' => 'It Payto ID',
            'it_process_type' => 'It Process Type',
            'it_program_chrge' => 'It Program Chrge',
            'it_project_code' => 'It Project Code',
            'it_rank' => 'It Rank',
            'it_remarks' => 'It Remarks',
            'it_roc' => 'It Roc',
            'it_socso_deductable' => 'It Socso Deductable',
            'it_status' => 'It Status',
            'it_system_code' => 'It System Code',
            'it_tax_deductable' => 'It Tax Deductable',
            'it_tax_flag' => 'It Tax Flag',
            'it_tax_type' => 'It Tax Type',
            'it_taxable_pct' => 'It Taxable Pct',
            'it_trans_type' => 'It Trans Type',
            'it_update_by' => 'It Update By',
            'it_update_date' => 'It Update Date',
            'it_user_code' => 'It User Code',
            'it_vot_chrge' => 'It Vot Chrge',
            'it_serious_debt' => 'It Serious Debt',
        ];
    }
}
