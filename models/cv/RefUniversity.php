<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_ref_university".
 *
 * @property int $id
 * @property string $output
 * @property string $institution
 */
class RefUniversity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_ref_university';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['institution'], 'string'],
            [['output'], 'string', 'max' => 300],
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
            'institution' => 'Institution',
        ];
    }
}
