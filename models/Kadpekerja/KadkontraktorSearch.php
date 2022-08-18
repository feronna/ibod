<?php

namespace app\models\Kadpekerja;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kadpekerja\Kadkontraktor;

/**
 * KadkontraktorSearch represents the model behind the search form of `app\models\Kadpekerja\Kadkontraktor`.
 */
class KadkontraktorSearch extends Kadkontraktor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_kontraktor'], 'integer'],
            [['ICNO', 'CONm', 'GenderCd', 'COOffTelNo', 'Postcode', 'ReligionCd', 'CountryCd', 'CityCd', 'StateCd', 'Addr1', 'Addr2', 'Addr3', 'COBirthDt', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
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
        $query = Kadkontraktor::find();

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
            'id_kontraktor' => $this->id_kontraktor,
            'COBirthDt' => $this->COBirthDt,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'CONm', $this->CONm])
            ->andFilterWhere(['like', 'GenderCd', $this->GenderCd])
            ->andFilterWhere(['like', 'COOffTelNo', $this->COOffTelNo])
            ->andFilterWhere(['like', 'Postcode', $this->Postcode])
            ->andFilterWhere(['like', 'ReligionCd', $this->ReligionCd])
            ->andFilterWhere(['like', 'CountryCd', $this->CountryCd])
            ->andFilterWhere(['like', 'CityCd', $this->CityCd])
            ->andFilterWhere(['like', 'StateCd', $this->StateCd])
            ->andFilterWhere(['like', 'Addr1', $this->Addr1])
            ->andFilterWhere(['like', 'Addr2', $this->Addr2])
            ->andFilterWhere(['like', 'Addr3', $this->Addr3])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}
