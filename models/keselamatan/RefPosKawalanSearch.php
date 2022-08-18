<?php

namespace app\models\keselamatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\keselamatan\RefPosKawalan;

/**
 * RefPosKawalanSearch represents the model behind the search form of `app\models\keselamatan\RefPosKawalan`.
 */
class RefPosKawalanSearch extends RefPosKawalan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active'], 'integer'],
            [['pos_kawalan', 'pecahan_pos', 'added_by', 'updated_by', 'kampus'], 'safe'],
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
        $query = RefPosKawalan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC, 
                    // 'pos_kawalan' => SORT_ASC,
                ],
            ]
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
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'pos_kawalan', $this->pos_kawalan])
            ->andFilterWhere(['like', 'pecahan_pos', $this->pecahan_pos]);
            // ->andFilterWhere(['like', 'added_by', $this->added_by])
            // ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            // ->andFilterWhere(['like', 'kampus', $this->kampus]);

        return $dataProvider;
    }
}
