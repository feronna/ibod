<?php
namespace app\models\vhrms;

use Yii;
use yii\db\ActiveRecord;

class IncomeType extends ActiveRecord
{
    
     // add the function below:
    public static function getDb() {
        return Yii::$app->get('db4'); // MSSQL database
    }
    
    #Table name
    public static function tableName(){
        return 'dbo.income_type';
    }
    public function getViewPayroll(){
        return $this->hasOne(ViewPayroll::className(), ['MPDH_INCOME_CODE' => 'it_income_code']);
           
    }
}
