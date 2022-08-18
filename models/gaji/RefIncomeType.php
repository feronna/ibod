<?php

namespace app\models\gaji;

use Yii;

class RefIncomeType extends \yii\db\ActiveRecord
{
    // public static function getDb() {
    //     return Yii::$app->get('db4'); // MSSQL database
    // }
    
    public static function tableName()
    {
        return 'hrm.gaji_migbkp_incometype_180226';
    }
}