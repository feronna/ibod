<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cvonline.requirement_khidmat".
 *
 * @property int $int
 * @property int $main_id
 * @property string $requirement
 * @property string $ans_char
 * @property int $ans_no
 * @property string $ans_decimal
 */
class RequirementKhidmat extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('db');
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_requirement_khidmat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_id', 'ans_no'], 'integer'],
            [['requirement'], 'string'],
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
            'int' => 'Int',
            'main_id' => 'Main ID',
            'requirement' => 'Requirement',
            'ans_char' => 'Ans Char',
            'ans_no' => 'Ans No',
            'ans_decimal' => 'Ans Decimal',
        ];
    }
}
