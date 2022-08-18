<?php

namespace app\models\pengesahan;

use Yii;

/**
 * This is the model class for table "hrm.sah_requirement_umum_akademik".
 *
 * @property int $id
 * @property string $requirement
 * @property string $ans_char
 * @property int $ans_no
 * @property string $ans_decimal
 */
class RequirementUmum2 extends \yii\db\ActiveRecord
{
    
     public static function getDb() {
        return Yii::$app->get('db');
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.sah_requirement_umum_akademik';
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
            [['ans_char', 'ans_char2'], 'string', 'max' => 50],
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
            'ans_char2' => 'Ans Char2',
            'ans_no' => 'Ans No',
            'ans_decimal' => 'Ans Decimal',
        ];
    }
    
    public static function penerbitan() {
        return RequirementPenerbitan::find()->all();
    }
    
     public static function persidangan() {
        return RequirementPersidangan::find()->all();
    }

    public static function umum() {
        return RequirementUmum2::find()->all();
    }

}
