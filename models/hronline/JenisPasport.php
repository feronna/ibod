<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.passport".
 *
 * @property string $PassportTypeCd
 * @property string $PassportType
 */
class JenisPasport extends \yii\db\ActiveRecord
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
        return 'hronline.passport';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PassportTypeCd'], 'required'],
            [['PassportTypeCd'], 'string', 'max' => 2],
            [['PassportType'], 'string', 'max' => 255],
            [['PassportTypeCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PassportTypeCd' => 'Passport Type Cd',
            'PassportType' => 'Passport Type',
        ];
    }
}
