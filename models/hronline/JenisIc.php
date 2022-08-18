<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.ictype".
 *
 * @property int $ICTypeCd
 * @property string $ICType
 */
class JenisIc extends \yii\db\ActiveRecord
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
        return 'hronline.ictype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICTypeCd'], 'required'],
            [['ICTypeCd'], 'integer'],
            [['ICType'], 'string', 'max' => 255],
            [['ICTypeCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICTypeCd' => 'Ictype Cd',
            'ICType' => 'Ictype',
        ];
    }
}
