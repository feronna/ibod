<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Anugerah;

/**
 * AnugerahSearch represents the model behind the search form of `app\models\hronline\Anugerah`.
 */
class AnugerahSearch extends Anugerah
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AwdCd', 'Awd', 'AwdCatCd', 'AwdAbrv', 'AwdTitleP', 'AwdTitleL', 'AwdTitleW'], 'safe'],
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
        $query = Anugerah::find();

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
        $query->andFilterWhere(['like', 'AwdCd', $this->AwdCd])
            ->andFilterWhere(['like', 'Awd', $this->Awd])
            ->andFilterWhere(['like', 'AwdCatCd', $this->AwdCatCd])
            ->andFilterWhere(['like', 'AwdAbrv', $this->AwdAbrv])
            ->andFilterWhere(['like', 'AwdTitleP', $this->AwdTitleP])
            ->andFilterWhere(['like', 'AwdTitleL', $this->AwdTitleL])
            ->andFilterWhere(['like', 'AwdTitleW', $this->AwdTitleW]);

        return $dataProvider;
    }
}
