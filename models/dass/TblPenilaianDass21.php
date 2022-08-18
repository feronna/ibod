<?php

namespace app\models\dass;

use Yii;
use app\models\dass\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\hronline\GredJawatan;

/**
 * This is the model class for table "tbl_penilaian_dass21".
 *
 * @property int $id
 * @property string $icno
 * @property int $gred_id
 * @property int $dept_id
 * @property int $statlantikan
 * @property string $created_dt
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
 * @property int $skor_d Skor Depression
 * @property int $skor_a Skor Anxiety
 * @property int $skor_s Skor Stress
 */
class TblPenilaianDass21 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.dass_tbl_penilaian_dass21';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('db2');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'gred_id', 'q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 'q11', 'q12', 'q13', 'q14', 'q15', 'q16', 'q17', 'q18', 'q19', 'q20', 'q21'], 'required'],
            [['gred_id', 'dept_id', 'statlantikan', 'q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 'q11', 'q12', 'q13', 'q14', 'q15', 'q16', 'q17', 'q18', 'q19', 'q20', 'q21', 'skor_d', 'skor_a', 'skor_s'], 'integer'],
            [['created_dt'], 'safe'],
            [['icno'], 'string', 'max' => 14],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'gred_id' => 'Gred ID',
            'dept_id' => 'Dept ID',
            'statlantikan' => 'Statlantikan',
            'created_dt' => 'Created Dt',
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
            'skor_d' => 'Skor D',
            'skor_a' => 'Skor A',
            'skor_s' => 'Skor S',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
    public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_id']);
    }

    public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }
    
    public function formName() {
        return '';
    }
    
    public static function isOwner($id, $icno)
    {
          if (static::findOne(['id' => $id, 'icno' => $icno])){
                return true;
          } else {
                return false;
          }
    }
    
}
