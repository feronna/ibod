<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\IdpGredJawatan;

/**
 * IdpGredJawatanSearch represents the model behind the search form of `app\models\myidp\IdpGredJawatan`.
 */
class IdpGredJawatanSearch extends IdpGredJawatan
{
    /**
     * {@inheritdoc}
     */
    
    public $min_gredjawatan;
    public $max_gredjawatan;
    public $countmin;
    
    public function rules()
    {
        return [
            [['id', 'sbpa_id', 'job_category', 'job_group', 'cpd_group', 'gred_status', 'isActive', 'isKhas'], 'integer'],
            [['nama', 'gred', 'fname', 'mymohesCd', 'short_desc', 'SchmOfServCd', 'SalGrdId', 'gred_skim', 'gred_no', 'idMM', 'titleMM'], 'safe'],
            [['min_gredjawatan', 'max_gredjawatan', ], 'safe'],
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
        $query = IdpGredJawatan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sbpa_id' => $this->sbpa_id,
            'job_category' => $this->job_category,
            'job_group' => $this->job_group,
            'cpd_group' => $this->cpd_group,
            'gred_status' => $this->gred_status,
            'isActive' => $this->isActive,
            'isKhas' => $this->isKhas,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'gred', $this->gred])
            ->andFilterWhere(['like', 'fname', $this->fname])
            ->andFilterWhere(['like', 'mymohesCd', $this->mymohesCd])  
            ->andFilterWhere(['like', 'short_desc', $this->short_desc])
            ->andFilterWhere(['like', 'SchmOfServCd', $this->SchmOfServCd])
            ->andFilterWhere(['like', 'SalGrdId', $this->SalGrdId])
            ->andFilterWhere(['like', 'gred_skim', $this->gred_skim])
            ->andFilterWhere(['=', 'gred_no', $this->gred_no])
            ->andFilterWhere(['>=', 'gred_no', $this->min_gredjawatan])
            ->andFilterWhere(['<=', 'gred_no', $this->max_gredjawatan])
            ->andFilterWhere(['like', 'idMM', $this->idMM])
            ->andFilterWhere(['like', 'titleMM', $this->titleMM])
            ->orderBy('gred_no');
        
        //$query->andFilterWhere(['between', 'gred_no', $this->min_gredjawatan, $this->max_gredjawatan]);
        //->andFilterWhere(['=', 'gred_no', $this->gred_no])
        //->andFilterWhere(['>', 'gred_no', $this->min_gredjawatan])
        //->andFilterWhere(['<', 'gred_no', $this->max_gredjawatan])
        
        //var_dump($dataProvider);

        return $dataProvider;
    }
}
