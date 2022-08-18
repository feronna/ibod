<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblanugerah;

/**
 * TblanugerahSearch represents the model behind the search form of `app\models\hronline\Tblanugerah`.
 */
class TblanugerahSearch extends Tblanugerah
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['awdId'], 'integer'],
            [['ICNO', 'AwdCd', 'TitleCd', 'CfdByCd', 'AwdCatCd', 'StateCd', 'AwdCfdDt', 'AwdAbbr', 'AwdReason', 'AwdStatus', 'CountryCd'], 'safe'],
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
        $query = Tblanugerah::find();

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
            'awdId' => $this->awdId,
            'AwdCfdDt' => $this->AwdCfdDt,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'AwdCd', $this->AwdCd])
            ->andFilterWhere(['like', 'TitleCd', $this->TitleCd])
            ->andFilterWhere(['like', 'CfdByCd', $this->CfdByCd])
            ->andFilterWhere(['like', 'AwdCatCd', $this->AwdCatCd])
            ->andFilterWhere(['like', 'StateCd', $this->StateCd])
            ->andFilterWhere(['like', 'AwdAbbr', $this->AwdAbbr])
            ->andFilterWhere(['like', 'AwdReason', $this->AwdReason])
            ->andFilterWhere(['like', 'AwdStatus', $this->AwdStatus])
            ->andFilterWhere(['like', 'CountryCd', $this->CountryCd]);

        return $dataProvider;
    }
}
