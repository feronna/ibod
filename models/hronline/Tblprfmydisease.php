<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\Tblkeluarga;

/**
 * This is the model class for table "hronline.tblprfmy_disease".
 *
 * @property int $id
 * @property string $FamilyId
 * @property int $type 1=disease;2=allergic
 * @property string $description disease name/description
 */
class Tblprfmydisease extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName()
    {
        return 'hronline.tblprfmy_disease';
    }

    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['FamilyId'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'FamilyId' => 'Family ID',
            'type' => 'Type',
            'description' => 'Description',
        ];
    }

    public function getKeluarga() {
        return $this->hasOne(Tblkeluarga::className(), ['FamilyId' => 'FamilyId']);
    }
}
