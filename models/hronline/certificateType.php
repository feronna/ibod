<?php

namespace app\models\hronline;

use Yii;

class certificateType extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'hronline.clinicalcert';
    }

    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    public function rules()
    {
        return [
            [['isActive'], 'integer'],
            [['certType'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'certType' => 'Cert Type',
            'isActive' => 'Is Active',
        ];
    }
}
