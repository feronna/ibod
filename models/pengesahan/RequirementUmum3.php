<?php

namespace app\models\pengesahan;

use Yii;

/**
 * This is the model class for table "hrm.sah_requirement_umum_akademik_ppp".
 *
 * @property int $id
 * @property string $requirement
 * @property string $ans_char
 * @property int $ans_no
 * @property string $ans_decimal
 * @property string $info
 */
class RequirementUmum3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.sah_requirement_umum_akademik_ppp';
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
            [['ans_char2'], 'string', 'max' => 50],
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
            'info' => 'Info',
        ];
    }
    
        public static function umum() {
        return RequirementUmum3::find()->all();
    }
}
