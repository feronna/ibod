<?php

namespace app\models\myintegriti;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myintegriti\TblBhgnA;
use app\models\myintegriti\MyintegritiViewSkorBahagianA;
use yii\db\Expression;

/**
 * TblBhgnASearch represents the model behind the search form of `app\models\myintegriti\TblBhgnA`.
 */
class TblBhgnASearch extends TblBhgnA
{
    public $CONm;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
			'q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 
			'q11', 'q12', 'q13', 'q14', 'q15', 'q16', 'q17', 'q18', 'q19', 'q20', 
			'q21', 'q22', 'q23', 'q24', 'q25', 'q26', 'q27', 'q28', 'q29', 'q30', 
			'q31', 'q32', 'q33', 'q34', 'q35', 'q36', 'q37', 'q38', 'q39', 'q40', 
			'q41', 'q42', 'q43', 'q44', 'q45', 'q46', 'q47', 'q48', 'q49', 'q50', 
			'q51', 'q52', 'q53', 'q54', 'q55', 'q56', 'q57', 'q58', 'q59', 'q60', 
			'q61', 'q62', 'q63', 'q64', 'q65', 'q66', 'q67', 'q68', 'q69'
			], 'integer'],
            [['CONm', 'icno', 'created_dt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TblPenilaian::find()->orderBy(['icno' => SORT_DESC, 'created_dt' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 10,
                ],
            'sort' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if(!empty($this->CONm)) {
            $query = $query->innerJoinWith('biodata', false)->andFilterWhere(['like', 'CONm', $this->CONm]);
        }
        
        if (is_null($params) || empty($params)){
            $query->where('0 = 1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'statlantikan' => $this->statlantikan,
            'tahun' => $this->tahun,
            'q1' => $this->q1,
            'q2' => $this->q2,
            'q3' => $this->q3,
            'q4' => $this->q4,
            'q5' => $this->q5,
            'q6' => $this->q6,
            'q7' => $this->q7,
            'q8' => $this->q8,
            'q9' => $this->q9,
            'q10' => $this->q10,
            'q11' => $this->q11,
            'q12' => $this->q12,
            'q13' => $this->q13,
            'q14' => $this->q14,
            'q15' => $this->q15,
            'q16' => $this->q16,
            'q17' => $this->q17,
            'q18' => $this->q18,
            'q19' => $this->q19,
            'q20' => $this->q20,
            'q21' => $this->q21,
            'q22' => $this->q22,
            'q23' => $this->q23,
            'q24' => $this->q24,
            'q25' => $this->q25,
            'q26' => $this->q26,
            'q27' => $this->q27,
            'q28' => $this->q28,
            'q29' => $this->q29,
			'q30' => $this->q30,
			'q31' => $this->q31,
            'q32' => $this->q32,
            'q33' => $this->q33,
            'q34' => $this->q34,
            'q35' => $this->q35,
            'q36' => $this->q36,
            'q37' => $this->q37,
            'q38' => $this->q38,
            'q39' => $this->q39,
            'q40' => $this->q40,
			'q41' => $this->q41,
            'q42' => $this->q42,
            'q43' => $this->q43,
            'q44' => $this->q44,
            'q45' => $this->q45,
            'q46' => $this->q46,
            'q47' => $this->q47,
            'q48' => $this->q48,
            'q49' => $this->q49,
            'q50' => $this->q50,
			'q51' => $this->q51,
            'q52' => $this->q52,
            'q53' => $this->q53,
            'q54' => $this->q54,
            'q55' => $this->q55,
            'q56' => $this->q56,
            'q57' => $this->q57,
            'q58' => $this->q58,
            'q59' => $this->q59,
            'q60' => $this->q60,
			'q61' => $this->q61,
            'q62' => $this->q62,
            'q63' => $this->q63,
            'q64' => $this->q64,
            'q65' => $this->q65,
            'q66' => $this->q66,
            'q67' => $this->q67,
            'q68' => $this->q68,
            'q69' => $this->q69,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno]);
        
        $query->andFilterWhere(['=', new Expression('CAST(`created_dt` as DATE)'), $this->created_dt]);

        return $dataProvider;
    }
}
