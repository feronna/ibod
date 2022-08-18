<?php

namespace app\models\patrol;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\patrol\PatrolMainTable;

/**
 * PatrolMainTableSearch represents the model behind the search form of `app\models\patrol\PatrolMainTable`.
 */
class PatrolMainTableSearch extends PatrolMainTable
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'route_id'], 'integer'],
            [['icno', 'assign_by', 'assign_dt', 'update_by', 'update_dt'], 'safe'],
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
        $query = PatrolMainTable::find();

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
            'route_id' => $this->route_id,
            'assign_dt' => $this->assign_dt,
            'update_dt' => $this->update_dt,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'assign_by', $this->assign_by])
            ->andFilterWhere(['like', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
