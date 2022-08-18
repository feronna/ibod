<?php
namespace app\models\ptb;

use yii\db\ActiveRecord;

class Option extends ActiveRecord
{
    #Table name
    public static function tableName(){
        return 'hrm.ptb_tbl_options';
    }
  
}