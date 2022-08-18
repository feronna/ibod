<?php

namespace app\models\dkums;

use Yii;

/**
 * This is the model class for table "utilities.dkums_job_satisfaction".
 *
 * @property int $id
 * @property int $main_id
 * @property int $c1
 * @property int $c2 1 to 6 scale
 * @property int $c3 1 to 6 scale
 * @property int $c4 1 to 6 scale
 * @property int $c5 1 to 6 scale
 * @property int $c6 1 to 6 scale
 * @property int $c7 1 to 6 scale
 * @property int $c8 1 to 6 scale
 * @property int $c9 1 to 6 scale
 * @property int $c10 1 to 6 scale
 * @property int $c11 1 to 6 scale
 * @property int $c12 1 to 6 scale
 * @property int $c13 1 to 6 scale
 * @property int $c14 1 to 6 scale
 * @property int $c15 1 to 6 scale
 * @property int $c16 1 to 6 scale
 * @property int $c17 1 to 6 scale
 * @property int $c18 1 to 6 scale
 * @property int $c19 1 to 6 scale
 * @property int $c20 1 to 6 scale
 * @property int $c21 1 to 6 scale
 * @property int $c22 1 to 6 scale
 * @property int $c23 1 to 6 scale
 * @property int $c24 1 to 6 scale
 * @property int $c25 1 to 6 scale
 * @property int $c26 1 to 6 scale
 * @property int $c27 1 to 6 scale
 */
class JobSatisfaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.dkums_job_satisfaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_id', 'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9', 'c10', 'c11', 'c12', 'c13', 'c14', 'c15', 'c16', 'c17', 'c18', 'c19', 'c20', 'c21', 'c22', 'c23', 'c24', 'c25', 'c26', 'c27'], 'integer'],
            [['c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9', 'c10', 'c11', 'c12', 'c13', 'c14', 'c15', 'c16', 'c17', 'c18', 'c19', 'c20', 'c21', 'c22', 'c23', 'c24', 'c25', 'c26', 'c27'], 'required',  'message' => 'Sila pilih skala ini!'],
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
            'c1' => 'C1',
            'c2' => 'C2',
            'c3' => 'C3',
            'c4' => 'C4',
            'c5' => 'C5',
            'c6' => 'C6',
            'c7' => 'C7',
            'c8' => 'C8',
            'c9' => 'C9',
            'c10' => 'C10',
            'c11' => 'C11',
            'c12' => 'C12',
            'c13' => 'C13',
            'c14' => 'C14',
            'c15' => 'C15',
            'c16' => 'C16',
            'c17' => 'C17',
            'c18' => 'C18',
            'c19' => 'C19',
            'c20' => 'C20',
            'c21' => 'C21',
            'c22' => 'C22',
            'c23' => 'C23',
            'c24' => 'C24',
            'c25' => 'C25',
            'c26' => 'C26',
            'c27' => 'C27',
        ];
    }
}
