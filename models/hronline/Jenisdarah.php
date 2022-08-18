<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.bloodtype".
 *
 * @property string $BloodTypeCd
 * @property string $BloodType
 */
class Jenisdarah extends \yii\db\ActiveRecord
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
        return 'hronline.bloodtype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BloodTypeCd'], 'required'],
            [['isActive'], 'integer'],
            [['BloodTypeCd'], 'string', 'max' => 2],
            [['BloodType'], 'string', 'max' => 255],
            [['BloodTypeCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'BloodTypeCd' => 'Blood Type Cd',
            'BloodType' => 'Blood Type',
        ];
    }
}
