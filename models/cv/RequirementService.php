<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_requirement_service".
 *
 * @property int $id
 * @property string $gred
 * @property int $cluster
 * @property string $requirement
 * @property string $ans_char
 * @property int $ans_no
 * @property string $ans_decimal
 */
class RequirementService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_requirement_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cluster', 'ans_no'], 'integer'],
            [['requirement'], 'string'],
            [['ans_decimal'], 'number'],
            [['gred'], 'string', 'max' => 10],
            [['ans_char'], 'string', 'max' => 50],
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
            'cluster' => 'Cluster',
            'requirement' => 'Requirement',
            'ans_char' => 'Ans Char',
            'ans_no' => 'Ans No',
            'ans_decimal' => 'Ans Decimal',
        ];
    }
}
