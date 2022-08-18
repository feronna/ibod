<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\TahapKemahiranBahasa;

/**
 * NamaBahasaSearchTahapKemahiranBahasa represents the model behind the search form of `app\models\hronline\TahapKemahiranBahasa`.
 */
class TahapKemahiranBahasaSearch extends TahapKemahiranBahasa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LangProficiencyCd', 'LangProficiency'], 'safe'],
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
        $query = TahapKemahiranBahasa::find();

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
        $query->andFilterWhere(['like', 'LangProficiencyCd', $this->LangProficiencyCd])
            ->andFilterWhere(['like', 'LangProficiency', $this->LangProficiency]);

        return $dataProvider;
    }
}
