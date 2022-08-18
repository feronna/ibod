<?php

namespace app\models\myintegriti;

use Yii;

/**
 * This is the model class for table "utilities.itg_tbl_bahagian_B".
 *
 * @property int $id_penilaian id tbl_penilaian
 * @property string $last_updated_dt
 * @property int $q1
 * @property int $q2
 * @property int $q3
 * @property int $q4
 * @property int $q5
 * @property int $q6
 * @property int $q7
 * @property int $q8
 * @property int $q9
 * @property int $q10
 * @property int $q11
 * @property int $q12
 * @property int $q13
 * @property int $q14
 * @property int $q15
 * @property int $q16
 * @property int $q17
 * @property int $q18
 * @property int $q19
 * @property int $q20
 * @property int $q21
 * @property int $q22
 * @property int $q23
 * @property int $q24
 * @property int $q25
 * @property int $q26
 * @property int $q27
 * @property int $q28
 * @property int $q29
 * @property int $q30
 * @property int $q31
 * @property int $q32
 * @property int $q33
 * @property int $q34
 * @property int $q35
 * @property int $q36
 * @property int $q37
 * @property int $q38
 * @property int $q39
 * @property int $q40
 * @property int $q41
 */
class TblBhgnB extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.itg_tbl_bahagian_B';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penilaian', 'q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 'q11', 'q12', 'q13', 'q14', 'q15', 'q16', 'q17', 'q18', 'q19', 'q20', 'q21', 'q22', 'q23', 'q24', 'q25', 'q26', 'q27', 'q28', 'q29', 'q30', 'q31', 'q32', 'q33', 'q34', 'q35', 'q36', 'q37', 'q38', 'q39', 'q40', 'q41'], 'required'],
            [['id_penilaian', 'q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 'q11', 'q12', 'q13', 'q14', 'q15', 'q16', 'q17', 'q18', 'q19', 'q20', 'q21', 'q22', 'q23', 'q24', 'q25', 'q26', 'q27', 'q28', 'q29', 'q30', 'q31', 'q32', 'q33', 'q34', 'q35', 'q36', 'q37', 'q38', 'q39', 'q40', 'q41'], 'integer'],
            [['last_updated_dt'], 'safe'],
            [['id_penilaian'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penilaian' => 'Id Penilaian',
            'last_updated_dt' => 'Last Updated Dt',
            'q1' => 'Q1',
            'q2' => 'Q2',
            'q3' => 'Q3',
            'q4' => 'Q4',
            'q5' => 'Q5',
            'q6' => 'Q6',
            'q7' => 'Q7',
            'q8' => 'Q8',
            'q9' => 'Q9',
            'q10' => 'Q10',
            'q11' => 'Q11',
            'q12' => 'Q12',
            'q13' => 'Q13',
            'q14' => 'Q14',
            'q15' => 'Q15',
            'q16' => 'Q16',
            'q17' => 'Q17',
            'q18' => 'Q18',
            'q19' => 'Q19',
            'q20' => 'Q20',
            'q21' => 'Q21',
            'q22' => 'Q22',
            'q23' => 'Q23',
            'q24' => 'Q24',
            'q25' => 'Q25',
            'q26' => 'Q26',
            'q27' => 'Q27',
            'q28' => 'Q28',
            'q29' => 'Q29',
            'q30' => 'Q30',
            'q31' => 'Q31',
            'q32' => 'Q32',
            'q33' => 'Q33',
            'q34' => 'Q34',
            'q35' => 'Q35',
            'q36' => 'Q36',
            'q37' => 'Q37',
            'q38' => 'Q38',
            'q39' => 'Q39',
            'q40' => 'Q40',
            'q41' => 'Q41',
        ];
    }
}
