<?php

namespace app\models\myportfolio;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myportfolio\TblPortfolio;

/**
 * TblPortfolioSearch represents the model behind the search form of `app\models\myportfolio\TblPortfolio`.
 */
class TblPortfolioSearch extends TblPortfolio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gred', 'jabatan_semasa'], 'integer'],
            [['icno', 'jawatan', 'status_jawatan', 'name'], 'safe'],
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
        $query = TblPortfolio::find();

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
            'gred' => $this->gred,
            'jabatan_semasa' => $this->jabatan_semasa,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'jawatan', $this->jawatan])
            ->andFilterWhere(['like', 'status_jawatan', $this->status_jawatan])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
