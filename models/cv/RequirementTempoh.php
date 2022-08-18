<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_requirement_tempoh".
 *
 * @property int $id
 * @property string $gred
 * @property string $requirement
 * @property string $ans_char
 * @property int $ans_no
 * @property string $ans_decimal
 */
class RequirementTempoh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_requirement_tempoh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['requirement'], 'string'],
            [['ans_no'], 'integer'],
            [['ans_decimal'], 'number'],
            [['gred'], 'string', 'max' => 10],
            [['ans_char'], 'string', 'max' => 59],
            [['gred_id'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gred' => 'Gred',
            'requirement' => 'Requirement',
            'ans_char' => 'Ans Char',
            'ans_no' => 'Ans No',
            'ans_decimal' => 'Ans Decimal',
        ];
    }
}
