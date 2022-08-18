<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cvonline.sw_output2".
 *
 * @property int $id
 * @property string $output
 */
class RefSwSociety extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_sw_output2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
        ];
    }
}
