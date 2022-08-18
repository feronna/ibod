<?php

namespace app\models\pengesahan;

use Yii;

/**
 * This is the model class for table "hrm.sah_requirement_persidangan".
 *
 * @property int $id
 * @property string $requirement
 * @property string $ans_char
 * @property int $ans_no
 * @property string $ans_decimal
 * @property string $info
 */
class RequirementPersidangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.sah_requirement_persidangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['requirement', 'info'], 'string'],
            [['ans_no'], 'integer'],
            [['ans_decimal'], 'number'],
            [['ans_char'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'requirement' => 'Requirement',
            'ans_char' => 'Ans Char',
            'ans_no' => 'Ans No',
            'ans_decimal' => 'Ans Decimal',
            'info' => 'Info',
        ];
    }
}
