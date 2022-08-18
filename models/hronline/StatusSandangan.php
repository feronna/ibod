<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.sandangan".
 *
 * @property int $sandangan_id
 * @property string $sandangan_name
 */
class StatusSandangan extends \yii\db\ActiveRecord
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
        return 'hronline.sandangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sandangan_id'], 'required'],
            [['sandangan_id'], 'integer'],
            [['sandangan_name'], 'string', 'max' => 255],
            [['sandangan_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sandangan_id' => 'Sandangan ID',
            'sandangan_name' => 'Sandangan Name',
        ];
    }
}
