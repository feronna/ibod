<?php

namespace app\models\hronline_gaji;

use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "hronline_gaji.tbl_staff_salary".
 *
 * @property string $MPDH_PAY_MONTH
 * @property string $sm_staff_id
 * @property string $sm_staff_name
 * @property string $sm_ic_no
 * @property string $ss_service_desc
 * @property string $ss_salary_grade
 * @property string $ss_academic
 * @property int $sm_dept_code
 * @property int $sm_citizen_status
 * @property string $mpdh_income_Code
 * @property string $it_income_desc
 * @property double $mpdh_paid_amt
 * @property string $mpdh_account_no
 * @property string $it_trans_type
 * @property string $it_income_code
 * @property string $mpdh_acct_code
 */
class Tblstaffsalary extends \yii\db\ActiveRecord
{   
    public static function tableName()
    {
        return 'hrm.gaji_tbl_staff_salary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sm_dept_code', 'sm_citizen_status'], 'integer'],
            [['mpdh_paid_amt'], 'number'],
            [['MPDH_PAY_MONTH'], 'string', 'max' => 6],
            [['sm_staff_id', 'sm_ic_no'], 'string', 'max' => 12],
            [['sm_staff_name', 'ss_service_desc', 'it_income_desc'], 'string', 'max' => 255],
            [['ss_salary_grade', 'mpdh_account_no'], 'string', 'max' => 50],
            [['ss_academic'], 'string', 'max' => 1],
            [['mpdh_income_Code', 'it_trans_type', 'it_income_code', 'mpdh_acct_code'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'MPDH_PAY_MONTH' => 'Mpdh Pay Month',
            'sm_staff_id' => 'Sm Staff ID',
            'sm_staff_name' => 'Sm Staff Name',
            'sm_ic_no' => 'Sm Ic No',
            'ss_service_desc' => 'Ss Service Desc',
            'ss_salary_grade' => 'Ss Salary Grade',
            'ss_academic' => 'Ss Academic',
            'sm_dept_code' => 'Sm Dept Code',
            'sm_citizen_status' => 'Sm Citizen Status',
            'mpdh_income_Code' => 'Mpdh Income Code',
            'it_income_desc' => 'It Income Desc',
            'mpdh_paid_amt' => 'Mpdh Paid Amt',
            'mpdh_account_no' => 'Mpdh Account No',
            'it_trans_type' => 'It Trans Type',
            'it_income_code' => 'It Income Code',
            'mpdh_acct_code' => 'Mpdh Acct Code',
        ];
    }

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'sm_ic_no']);
    }
}
