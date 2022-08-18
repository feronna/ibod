<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\Peringkatbadanprofesional;
use app\models\hronline\Kategoribadanprofesional;

class BadanProfesional extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    

    public static function tableName()
    {
        return 'hronline.professionalassociation';
    }

    public function rules()
    {
        return [
            [['ProfBodyCd','ProfBody'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['ProfBodyCd'], 'string', 'max' => 4],
            [['ProfBody'], 'string', 'max' => 255],
            [['ProfBodyCd'], 'unique'],
            [['isActive','isMedicalBody'],'integer'],
            [['kategori', 'peringkat','isBsm'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ProfBodyCd' => 'Prof Body Cd',
            'ProfBody' => 'Prof Body',
        ];
    }

    public function getPeringkatBP() {
        return $this->hasOne(Peringkatbadanprofesional::className(), ['id' => 'peringkat']);
    }

    public function getKategoriBP() {
        return $this->hasOne(Kategoribadanprofesional::className(), ['id' => 'kategori']);
    }

    public function getStatus() {
        return $this->isActive ? "Aktif":"Tidak aktif";
    }

    public function getRelSkim() {
        return $this->hasMany(badanprofesional_skim::className(), ['ProfBodyCd' => 'ProfBodyCd']);
    }
    public function getNamaBadan() {
      
       return $this->ProfBody;
   }
}
