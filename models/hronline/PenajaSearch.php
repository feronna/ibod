<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Penaja;

/**
 * PenajaSearch represents the model behind the search form of `app\models\hronline\Penaja`.
 */
class PenajaSearch extends Penaja
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SponsorshipCd', 'status'], 'integer'],
            [['SponsorshipNm'], 'safe'],
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
        $query = Penaja::find();

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
            'SponsorshipCd' => $this->SponsorshipCd,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'SponsorshipNm', $this->SponsorshipNm]);

        return $dataProvider;
    }
}
