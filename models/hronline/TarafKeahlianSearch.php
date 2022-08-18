<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\TarafKeahlian;

/**
 * TarafKeahlianSearch represents the model behind the search form of `app\models\hronline\TarafKeahlian`.
 */
class TarafKeahlianSearch extends TarafKeahlian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MembershipTypeCd', 'MembershipType'], 'safe'],
            [['isActive'], 'integer'],
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
        $query = TarafKeahlian::find();

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
            'isActive' => $this->isActive,
        ]);

        $query->andFilterWhere(['like', 'MembershipTypeCd', $this->MembershipTypeCd])
            ->andFilterWhere(['like', 'MembershipType', $this->MembershipType]);

        return $dataProvider;
    }
}
