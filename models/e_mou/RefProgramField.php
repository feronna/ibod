<?php

namespace app\models\e_mou;

use Yii;

/**
 * This is the model class for table "emou.r_emou14_program".
 *
 * @property int $program_id ID
 * @property string $program_desc Program
 */
class RefProgramField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.r_emou14_program';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['program_desc'], 'required'],
            [['program_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'program_id' => 'Program ID',
            'program_desc' => 'Program Desc',
        ];
    }
}
