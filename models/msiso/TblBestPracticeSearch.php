<?php

namespace app\models\msiso;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\msiso\TblBestPractice;

/**
 * TblBestPracticeSearch represents the model behind the search form of `app\models\msiso\TblBestPractice`.
 */
class TblBestPracticeSearch extends TblBestPractice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'parent_id'], 'integer'],
            [['dept', 'year', 'best_practice', 'created_by', 'created_dt', 'attachment'], 'safe'],
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
        $query = TblBestPractice::find();

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
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'dept', $this->dept])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'best_practice', $this->best_practice])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'attachment', $this->attachment]);

        return $dataProvider;
    }
}
