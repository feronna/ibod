<?php

namespace app\models\hronline;

use Yii;

class Tblkod extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb()
    {
        return Yii::$app->get('db2'); // second database
    }
    public static function tableName()
    {
        return 'hronline.tblkod';
    }

    public function rules()
    {
        return [
            [['kodname', 'urlsk'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kodname' => 'Kodname',
            'urlsk' => 'Urlsk',
        ];
    }
}
