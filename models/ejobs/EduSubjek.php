<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.edu_subjek".
 *
 * @property int $id
 * @property string $EduSubjek
 * @property int $EduLevel_id
 */
class EduSubjek extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7');  // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.edu_subjek';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EduLevel_id'], 'integer'],
            [['EduSubjek'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'EduSubjek' => 'Subjek',
            'EduLevel_id' => 'Edu Level ID',
        ];
    }
}
