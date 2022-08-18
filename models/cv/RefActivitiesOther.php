<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cv.ref_activities_other_output".
 *
 * @property int $id
 * @property string $output
 */
class RefActivitiesOther extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_ref_activities_other_output';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['output'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'output' => 'Output',
        ];
    }
}
