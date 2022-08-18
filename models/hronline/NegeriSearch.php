<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Negeri;

/**
 * NegeriSearch represents the model behind the search form of `app\models\hronline\Negeri`.
 */
class NegeriSearch extends Negeri
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['StateCd', 'State', 'StateWeekend', 'CountryCd', 'StateCdMM'], 'safe'],
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
        $query = Negeri::find();

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
        $query->andFilterWhere(['like', 'StateCd', $this->StateCd])
            ->andFilterWhere(['like', 'State', $this->State])
            ->andFilterWhere(['like', 'StateWeekend', $this->StateWeekend])
            ->andFilterWhere(['like', 'CountryCd', $this->CountryCd])
            ->andFilterWhere(['like', 'StateCdMM', $this->StateCdMM]);

        return $dataProvider;
    }
}
