<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.disabilitycause".
 *
 * @property string $DisabilityCauseCd
 * @property string $DisabilityCause
 */
class PuncaKecacatan extends \yii\db\ActiveRecord
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
        return 'hronline.disabilitycause';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DisabilityCauseCd'], 'required'],
            [['DisabilityCauseCd'], 'string', 'max' => 2],
            [['DisabilityCause'], 'string', 'max' => 255],
            [['DisabilityCauseCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'DisabilityCauseCd' => 'Disability Cause Cd',
            'DisabilityCause' => 'Disability Cause',
        ];
    }
}
