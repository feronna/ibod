<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\NamaBahasa;

/**
 * NamaBahasaSearch represents the model behind the search form of `app\models\hronline\NamaBahasa`.
 */
class NamaBahasaSearch extends NamaBahasa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LangCd', 'Lang'], 'safe'],
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
        $query = NamaBahasa::find();

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
        $query->andFilterWhere(['like', 'LangCd', $this->LangCd])
            ->andFilterWhere(['like', 'Lang', $this->Lang]);

        return $dataProvider;
    }
}
