<?php
namespace app\models\vhrms;

use Yii;
use yii\db\ActiveRecord;
use app\models\hronline\Tblrscopsnstatus;
class Kwsp extends ActiveRecord
{
    
     // add the function below:
    public static function getDb() {
        return Yii::$app->get('db4'); // MSSQL database
    }
    
    
    #Table name
    public static function tableName(){
        return 'dbo.kwsp';
    }
    public function getNoKwsp(){
        return $this->hasOne(Tblrscopsnstatus::className(), ['ICNO' => 'staff_id']);
           
    }
}
