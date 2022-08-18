<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblkecacatan;

/**
 * TblkecacatanSearch represents the model behind the search form of `app\models\hronline\Tblkecacatan`.
 */
class TblkecacatanSearch extends Tblkecacatan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'DisabilityTypeCd', 'DisabilityCauseCd', 'DisabilityDt', 'AccidentDt', 'SocialWelfareNo', 'HealDt', 'DrRptNo'], 'safe'],
            [['id'], 'integer'],
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
        $query = Tblkecacatan::find();

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
            'DisabilityDt' => $this->DisabilityDt,
            'AccidentDt' => $this->AccidentDt,
            'HealDt' => $this->HealDt,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'DisabilityTypeCd', $this->DisabilityTypeCd])
            ->andFilterWhere(['like', 'DisabilityCauseCd', $this->DisabilityCauseCd])
            ->andFilterWhere(['like', 'SocialWelfareNo', $this->SocialWelfareNo])
            ->andFilterWhere(['like', 'DrRptNo', $this->DrRptNo]);

        return $dataProvider;
    }
}
