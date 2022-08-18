<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.accountpurpose".
 *
 * @property string $AccPurposeCd
 * @property string $AccPurpose
 */
class TujuanAkaun extends \yii\db\ActiveRecord
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
        return 'hronline.accountpurpose';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AccPurposeCd'], 'required'],
            [['AccPurposeCd'], 'string', 'max' => 2],
            [['AccPurpose'], 'string', 'max' => 255],
            [['AccPurposeCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'AccPurposeCd' => 'Acc Purpose Cd',
            'AccPurpose' => 'Acc Purpose',
        ];
    }
}
