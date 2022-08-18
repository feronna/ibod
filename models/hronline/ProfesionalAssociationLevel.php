<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.professional_association_level".
 */
class ProfesionalAssociationLevel extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName()
    {
        return 'hronline.professional_association_level';
    }

    public function rules()
    {
        return [
            [['isActive'], 'integer'],
            [['LvlNm', 'LvlNmEn'], 'string', 'max' => 50],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'LvlNm' => 'Lvl Nm',
            'LvlNmEn' => 'Lvl Nm En',
            'isActive' => 'Is Active',
        ];
    }
}
