<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cvonline.requirement_sanjungan".
 *
 * @property int $id
 * @property int $main_id
 * @property string $requirement
 * @property string $ans_char
 * @property int $ans_no
 * @property string $ans_decimal
 */
class RequirementPersidangan extends \yii\db\ActiveRecord
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
        return 'hrm.cv_requirement_persidangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ans_no','cluster'], 'integer'],
            [['requirement'], 'string'],
            [['ans_decimal'], 'number'],
            [['ans_char'], 'string', 'max' => 50],
            [['gred','info','gred_id'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gred' => 'Main ID',
            'requirement' => 'Requirement',
            'ans_char' => 'Ans Char',
            'ans_no' => 'Ans No',
            'ans_decimal' => 'Ans Decimal',
        ];
    }
}
