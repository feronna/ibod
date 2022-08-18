<?php
namespace app\models\vhrms;

use Yii;
use yii\db\ActiveRecord;


class StaffAccount extends ActiveRecord
{
    
     // add the function below:
    public static function getDb() {
        return Yii::$app->get('db4'); // MSSQL database
    }
    
    
    #Table name
    public static function tableName(){
        return 'dbo.staff_account';
    }
 
}
