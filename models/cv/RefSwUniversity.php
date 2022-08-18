<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cvonline.sw_output".
 *
 * @property int $id
 * @property string $output
 * @property int $sort
 */
class RefSwUniversity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_sw_output';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active','safe']],
            [['sort'], 'integer'],
            [['output'], 'string', 'max' => 255],
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
            'sort' => 'Sort',
        ];
    }
}
