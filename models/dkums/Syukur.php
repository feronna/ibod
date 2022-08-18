<?php

namespace app\models\dkums;

use Yii;

/**
 * This is the model class for table "utilities.dkums_syukur".
 *
 * @property int $id
 * @property int $main_id
 * @property int $e1
 */
class Syukur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.dkums_syukur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_id', 'e1'], 'integer'],
            [['e1'], 'required', 'message'=>'Sila pilih skala ini!'],
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
            'e1' => 'E1',
        ];
    }
}
