<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblakaun;

/**
 * TblakaunSearch represents the model behind the search form of `app\models\hronline\Tblakaun`.
 */
class TblakaunSearch extends Tblakaun
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'AccNo', 'AccTypeCd', 'AccPurposeCd', 'AccNmCd', 'CityCd', 'AccBranch', 'AccBranchCd'], 'safe'],
            [['AccStatus', 'id'], 'integer'],
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
        $query = Tblakaun::find();

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
            'AccStatus' => $this->AccStatus,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'AccNo', $this->AccNo])
            ->andFilterWhere(['like', 'AccTypeCd', $this->AccTypeCd])
            ->andFilterWhere(['like', 'AccPurposeCd', $this->AccPurposeCd])
            ->andFilterWhere(['like', 'AccNmCd', $this->AccNmCd])
            ->andFilterWhere(['like', 'CityCd', $this->CityCd])
            ->andFilterWhere(['like', 'AccBranch', $this->AccBranch])
            ->andFilterWhere(['like', 'AccBranchCd', $this->AccBranchCd]);

        return $dataProvider;
    }
}
