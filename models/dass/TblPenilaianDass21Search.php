<?php

namespace app\models\dass;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\dass\TblPenilaianDass21;
use yii\db\Expression;

/**
 * TblPenilaianDass21Search represents the model behind the search form of `app\models\dass\TblPenilaianDass21`.
 */
class TblPenilaianDass21Search extends TblPenilaianDass21
{
    public $CONm;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gred_id', 'dept_id', 'statlantikan', 'tahun', 'q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 'q11', 'q12', 'q13', 'q14', 'q15', 'q16', 'q17', 'q18', 'q19', 'q20', 'q21', 'skor_d', 'skor_a', 'skor_s'], 'integer'],
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
        $query = TblPenilaianDass21::find()->orderBy(['icno' => SORT_DESC, 'created_dt' => SORT_DESC]);

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
            'gred_id' => $this->gred_id,
            'dept_id' => $this->dept_id,
            'statlantikan' => $this->statlantikan,
            'tahun' => $this->tahun,
            //'created_dt' => $this->created_dt,
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
            'skor_d' => $this->skor_d,
            'skor_a' => $this->skor_a,
            'skor_s' => $this->skor_s,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno]);
        
        $query->andFilterWhere(['=', new Expression('CAST(`created_dt` as DATE)'), $this->created_dt]);

        return $dataProvider;
    }
}
