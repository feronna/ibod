<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Institut;

/**
 * InstitutSearch represents the model behind the search form of `app\models\hronline\Institut`.
 */
class InstitutSearch extends Institut
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['InstCd', 'InstNm', 'InstAddr1', 'InstAddr2', 'InstAddr3', 'InstPostcode', 'InstLocation', 'InstBranch', 'CityCd', 'StateCd', 'CountryCd', 'InstTypeCd'], 'safe'],
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
        $query = Institut::find();

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

        $query->andFilterWhere(['like', 'InstCd', $this->InstCd])
            ->andFilterWhere(['like', 'InstNm', $this->InstNm])
            ->andFilterWhere(['like', 'InstAddr1', $this->InstAddr1])
            ->andFilterWhere(['like', 'InstAddr2', $this->InstAddr2])
            ->andFilterWhere(['like', 'InstAddr3', $this->InstAddr3])
            ->andFilterWhere(['like', 'InstPostcode', $this->InstPostcode])
            ->andFilterWhere(['like', 'InstLocation', $this->InstLocation])
            ->andFilterWhere(['like', 'InstBranch', $this->InstBranch])
            ->andFilterWhere(['like', 'CityCd', $this->CityCd])
            ->andFilterWhere(['like', 'StateCd', $this->StateCd])
            ->andFilterWhere(['like', 'CountryCd', $this->CountryCd])
            ->andFilterWhere(['like', 'InstTypeCd', $this->InstTypeCd]);

        return $dataProvider;
    }
}
