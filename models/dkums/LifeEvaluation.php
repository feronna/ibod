<?php

namespace app\models\dkums;

use Yii;

/**
 * This is the model class for table "utilities.dkums_life_evaluation".
 *
 * @property int $id
 * @property int $main_id
 * @property int $a1 0 to 10 scale
 */
class LifeEvaluation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.dkums_life_evaluation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_id', 'a1'], 'integer'],
            [['a1'], 'required', 'message'=>'Sila pilih skala ini!'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main_id' => 'Main ID',
            'a1' => '0 to 10 scale',
        ];
    }
}
