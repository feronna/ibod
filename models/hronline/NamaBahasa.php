<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.languagenm".
 *
 * @property string $LangCd
 * @property string $Lang
 */
class NamaBahasa extends \yii\db\ActiveRecord
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
        return 'hronline.languagenm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LangCd'], 'required'],
            [['LangCd'], 'string', 'max' => 3],
            [['Lang'], 'string', 'max' => 255],
            [['LangCd'], 'unique'],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LangCd' => 'Lang Cd',
            'Lang' => 'Lang',
        ];
    }
    
    public function getStatus() {
        return $this->isActive ? "Aktif":"Tidak aktif";
    }
}
