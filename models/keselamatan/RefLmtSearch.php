<?php

namespace app\models\keselamatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\keselamatan\RefLmt;

/**
 * RefLmtSearch represents the model behind the search form of `app\models\keselamatan\RefLmt`.
 */
class RefLmtSearch extends RefLmt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active'], 'integer'],
            [['jenis_shifts', 'details', 'start_time', 'end_time', 'entry_by', 'update_by', 'update_dt'], 'safe'],
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
        $query = RefLmt::find();

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
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'update_dt' => $this->update_dt,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'jenis_shifts', $this->jenis_shifts])
            ->andFilterWhere(['like', 'details', $this->details])
            ->andFilterWhere(['like', 'entry_by', $this->entry_by])
            ->andFilterWhere(['like', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
