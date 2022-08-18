<?php

namespace app\models\hronline;

use Yii;

class IdType extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    public static function tableName()
    {
        return 'hronline.ref_idtype';
    }

    public function rules()
    {
        return [
            [['IdTypeCd'], 'required'],
            [['IdTypeCd', 'isActive'], 'integer'],
            [['IdType'], 'string', 'max' => 50],
            [['IdTypeCd'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'IdTypeCd' => 'Id Type Cd',
            'IdType' => 'Id Type',
            'isActive' => 'Is Active',
        ];
    }
}
