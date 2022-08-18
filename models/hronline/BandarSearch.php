<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Bandar;

/**
 * BandarSearch represents the model behind the search form of `app\models\hronline\Bandar`.
 */
class BandarSearch extends Bandar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CityCd', 'City', 'StateCd', 'DistrictCd'], 'safe'],
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
        $query = Bandar::find();

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

        $query->andFilterWhere(['like', 'CityCd', $this->CityCd])
            ->andFilterWhere(['like', 'City', $this->City])
            ->andFilterWhere(['like', 'StateCd', $this->StateCd])
            ->andFilterWhere(['like', 'DistrictCd', $this->DistrictCd]);

        return $dataProvider;
    }
}
