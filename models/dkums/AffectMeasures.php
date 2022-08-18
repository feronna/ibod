<?php

namespace app\models\dkums;

use Yii;

/**
 * This is the model class for table "utilities.dkums_affect_measures".
 *
 * @property int $id
 * @property int $main_id
 * @property int $b1 1 to 5 scale
 * @property int $b2 1 to 5 scale
 * @property int $b3 1 to 5 scale
 * @property int $b4 1 to 5 scale
 * @property int $b5 1 to 5 scale
 * @property int $b6 1 to 5 scale
 * @property int $b7 1 to 5 scale
 * @property int $b8 1 to 5 scale
 * @property int $b9 1 to 5 scale
 * @property int $b10 1 to 5 scale
 */
class AffectMeasures extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.dkums_affect_measures';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_id', 'b1', 'b2', 'b3', 'b4', 'b5', 'b6', 'b7', 'b8', 'b9', 'b10'], 'integer'],
            [['b1', 'b2', 'b3', 'b4', 'b5', 'b6', 'b7', 'b8', 'b9', 'b10'], 'required', 'message'=>'Sila pilih skala ini!'],
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
            'b1' => 'B1',
            'b2' => 'B2',
            'b3' => 'B3',
            'b4' => 'B4',
            'b5' => 'B5',
            'b6' => 'B6',
            'b7' => 'B7',
            'b8' => 'B8',
            'b9' => 'B9',
            'b10' => 'B10',
        ];
    }
}
