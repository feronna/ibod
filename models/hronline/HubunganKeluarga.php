<?php

namespace app\models\hronline;

use Yii;

class HubunganKeluarga extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName()
    {
        return 'hronline.relationship';
    }


    public function rules()
    {
        return [
            [['RelCd'], 'required'],
            [['RelCd'], 'string', 'max' => 2],
            [['RelNm','RelNmBi'], 'string', 'max' => 255],
            [['RelCd'], 'unique'],
            [['isActive'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'RelCd' => 'Rel Cd',
            'RelNm' => 'Rel Nm',
            'RelNmBi' => 'Rel Nm Bi',
            'isActive' => 'Status',
        ];
    }

    public function getStatus() {
        if($this->isActive){
            return 'Aktif';
        }
        return 'Tidak aktif';
    }
}
