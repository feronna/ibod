<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.campus".
 *
 * @property int $campus_id
 * @property string $campus_name
 * @property int $campus_category_idmm
 */
class Kampus extends \yii\db\ActiveRecord
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
        return 'hronline.campus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['campus_category_idmm'], 'integer'],
            [['campus_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'campus_id' => 'Campus ID',
            'campus_name' => 'Campus Name',
            'campus_category_idmm' => 'Campus Category Idmm',
        ];
    }
}
