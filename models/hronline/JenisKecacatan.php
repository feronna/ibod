<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.disabilitytype".
 *
 * @property string $DisabilityTypeCd
 * @property string $DisabilityType
 * @property string $idmm
 */
class JenisKecacatan extends \yii\db\ActiveRecord
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
        return 'hronline.disabilitytype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DisabilityTypeCd'], 'required'],
            [['DisabilityTypeCd'], 'string', 'max' => 2],
            [['DisabilityType'], 'string', 'max' => 255],
            [['idmm'], 'string', 'max' => 10],
            [['DisabilityTypeCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'DisabilityTypeCd' => 'Disability Type Cd',
            'DisabilityType' => 'Disability Type',
            'idmm' => 'Idmm',
        ];
    }
}
