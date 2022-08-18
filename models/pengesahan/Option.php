<?php
namespace app\models\pengesahan;

use yii\db\ActiveRecord;

class Option extends ActiveRecord
{
    #Table name
    public static function tableName(){
        return 'hrm.sah_tbl_options';
    }
  
}