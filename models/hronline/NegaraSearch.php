<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Negara;

/**
 * NegaraSearch represents the model behind the search form of `app\models\hronline\Negara`.
 */
class NegaraSearch extends Negara
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CountryCd', 'Country', 'CountryCdMM'], 'safe'],
            [['StudyExtPeriod', 'isActive'], 'integer'],
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
        $query = Negara::find();

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
            'StudyExtPeriod' => $this->StudyExtPeriod,
            'isActive' => $this->isActive,
        ]);

        $query->andFilterWhere(['like', 'CountryCd', $this->CountryCd])
            ->andFilterWhere(['like', 'Country', $this->Country])
            ->andFilterWhere(['like', 'CountryCdMM', $this->CountryCdMM]);

        return $dataProvider;
    }
}
