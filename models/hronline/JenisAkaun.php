<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.accounttype".
 *
 * @property string $AccTypeCd
 * @property string $AccType
 */
class JenisAkaun extends \yii\db\ActiveRecord
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
        return 'hronline.accounttype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AccTypeCd'], 'required'],
            [['AccTypeCd'], 'string', 'max' => 2],
            [['AccType'], 'string', 'max' => 255],
            [['AccTypeCd'], 'unique'],
            [['isActive'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'AccTypeCd' => 'Acc Type Cd',
            'AccType' => 'Acc Type',
        ];
    }
}
