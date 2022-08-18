<?php

namespace app\models\patrol;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\patrol\RefRoute;

/**
 * RefRouteSearch represents the model behind the search form of `app\models\patrol\RefRoute`.
 */
class RefRouteSearch extends RefRoute
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['route_name', 'pic'], 'safe'],
            [['isActive','campus'], 'integer'],

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
        $query = RefRoute::find();

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
        ]);

        $query->andFilterWhere(['like', 'route_name', $this->route_name])
            ->andFilterWhere(['like', 'pic', $this->pic]);

        return $dataProvider;
    }
}
