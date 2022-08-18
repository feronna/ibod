<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\tblethnic;

class Etnik extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    public static function tableName()
    {
        return 'hronline.ethnic';
    }

    public function rules()
    {
        return [
            [['EthnicCd'], 'required'],
            [['EthnicCd'], 'string', 'max' => 4],
            [['Ethnic'], 'string', 'max' => 255],
            [['EthnicCd'], 'unique'],
            [['isActive'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'EthnicCd' => 'Ethnic Cd',
            'Ethnic' => 'Ethnic',
        ];
    }

    public function getStatus() {
        return $this->isActive ? "Aktif" : "Tidak Aktif";
    }
}
