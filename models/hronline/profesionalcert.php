<?php

namespace app\models\hronline;

use Yii;

class profesionalcert extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'hronline.profesionalcert';
    }

    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    public function rules()
    {
        return [
            [['ProfCertCd'], 'required'],
            [['ProfCertCd'], 'integer'],
            [['ProfCertNm'], 'string', 'max' => 255],
            [['ProfCertCd'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ProfCertCd' => 'Prof Cert Cd',
            'ProfCertNm' => 'Prof Cert Nm',
        ];
    }
   public function getNamasijil() {
      
       return $this->ProfCertNm;
   }

    
}
