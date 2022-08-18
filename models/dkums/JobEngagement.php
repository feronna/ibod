<?php

namespace app\models\dkums;

use Yii;

/**
 * This is the model class for table "utilities.dkums_job_engagement".
 *
 * @property int $id
 * @property int $main_id
 * @property int $d1
 * @property int $d2
 * @property int $d3
 * @property int $d4
 * @property int $d5
 * @property int $d6
 * @property int $d7
 * @property int $d8
 * @property int $d9
 */
class JobEngagement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.dkums_job_engagement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_id', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'd9'], 'integer'],
            [['d1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'd9'], 'required','message'=>'Sila pilih skala ini!'],
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
            'd1' => 'D1',
            'd2' => 'D2',
            'd3' => 'D3',
            'd4' => 'D4',
            'd5' => 'D5',
            'd6' => 'D6',
            'd7' => 'D7',
            'd8' => 'D8',
            'd9' => 'D9',
        ];
    }
}
