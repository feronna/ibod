<?php

namespace app\models\hronline_gaji;

use Yii;

class income_code_mapping extends \yii\db\ActiveRecord
{    
    public static function tableName()
    {
        return 'hrm.gaji_mig_Income_code_mapping';
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
    
}