<?php

namespace app\models\hronline_gaji;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline_gaji\TblStaffSalary;

class TblstaffsalarySearch extends TblStaffSalary
{  
    
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

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TblStaffSalary::find();
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if(empty($this->sm_ic_no)){
            $query->where('0=1');
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // $pay_month = date("Y") . date("m");
        $pay_month = "202012";
        $trans_type = "ALLOWANCE";
        
        // grid filtering conditions
        $query->andFilterWhere([
            'sm_ic_no' => $this->sm_ic_no,
            'sm_staff_id' => $this->sm_staff_id,
            // 'MPDH_PAY_MONTH' => $this->MPDH_PAY_MONTH,
            'MPDH_PAY_MONTH' => $pay_month,
            'it_trans_type' => $trans_type,
        ]);

        return $dataProvider;
    }
}
