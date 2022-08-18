<?php

namespace app\models\msiso;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\msiso\TblClause;

/**
 * ClauseSearch represents the model behind the search form of `app\models\msiso\TblClause`.
 */
class ClauseSearch extends TblClause
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'parent_clause'], 'integer'],
            [['clause', 'clause_order', 'clause_title', 'clause_details', 'created_by', 'created_dt'], 'safe'],
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
        $query = TblClause::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'created_dt' => $this->created_dt,
            'status' => $this->status,
            'parent_clause' => $this->parent_clause,
        ]);

        $query->andFilterWhere(['like', 'clause', $this->clause])
            ->andFilterWhere(['like', 'clause_order', $this->clause_order])
            ->andFilterWhere(['like', 'clause_title', $this->clause_name])
            ->andFilterWhere(['like', 'clause_details', $this->clause_details])
            ->andFilterWhere(['like', 'created_by', $this->created_by]);

        return $dataProvider;
    }
}
