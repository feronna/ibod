<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_ref_status_aduan".
 *
 * @property int $id
 * @property string $output
 */
class RefStatusAduan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_ref_status_aduan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['output'], 'string', 'max' => 50],
            [['color'], 'string', 'max' => 15],
            [['desc'], 'safe'],
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
