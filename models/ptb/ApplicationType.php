<?php
namespace app\models\ptb;

use yii\db\ActiveRecord;
use Yii;
class ApplicationType extends ActiveRecord
{

   
    #Table name
    public static function tableName(){
        return 'hrm.ptb_tbl_application_types';
    }
}