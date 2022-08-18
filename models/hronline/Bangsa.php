<?php

namespace app\models\hronline;

use Yii;

class Bangsa extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName()
    {
        return 'hronline.race';
    }

    public function rules()
    {
        return [
            [['RaceCd','Race'], 'required'],
            [['RaceCd'], 'string', 'max' => 2],
            [['Race'], 'string', 'max' => 255],
            [['RaceCdMM'], 'string', 'max' => 20],
            [['RaceCd'], 'unique'],
            [['isActive'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'RaceCd' => 'Race Cd',
            'Race' => 'Race',
            'RaceCdMM' => 'Race Cd Mm',
            'isActive' => 'Status',
        ];
    }
}
