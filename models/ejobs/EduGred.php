<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.edu_gred".
 *
 * @property int $id
 * @property string $grade
 */
class EduGred extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.edu_gred';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grade'], 'required'],
            [['grade'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grade' => 'Gred',
        ];
    }
}
