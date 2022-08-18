<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.klusterkepakaran".
 *
 * @property int $id
 * @property string $kluster
 */
class BidangKepakaran extends \yii\db\ActiveRecord
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
        return 'hronline.klusterkepakaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kluster'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kluster' => 'Kluster',
        ];
    }
}
