<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.illness".
 *
 * @property string $IllnessCd
 * @property string $Illness
 */
class JenisPenyakit extends \yii\db\ActiveRecord
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
        return 'hronline.illness';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IllnessCd'], 'required'],
            [['IllnessCd'], 'string', 'max' => 4],
            [['Illness'], 'string', 'max' => 255],
            [['IllnessCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IllnessCd' => 'Illness Cd',
            'Illness' => 'Illness',
        ];
    }
}
