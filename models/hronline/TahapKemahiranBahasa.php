<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.langproficiency".
 *
 * @property string $LangProficiencyCd
 * @property string $LangProficiency
 */
class TahapKemahiranBahasa extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.langproficiency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LangProficiencyCd','LangProficiency'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['LangProficiencyCd'], 'string', 'max' => 2],
            [['LangProficiency'], 'string', 'max' => 255],
            [['LangProficiencyCd'], 'unique'],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LangProficiencyCd' => 'Lang Proficiency Cd',
            'LangProficiency' => 'Lang Proficiency',
        ];
    }
    
    public function getStatus() {
        return $this->isActive ? "Aktif":"Tidak aktif";
    }
}
