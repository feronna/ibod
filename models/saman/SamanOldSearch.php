<?php

namespace app\models\saman;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\saman\SamanOld;

/**
 * SamanOldSearch represents the model behind the search form of `app\models\saman\SamanOld`.
 */
class SamanOldSearch extends SamanOld
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NOSAMAN', 'TRKHSAMAN', 'KATEGORI', 'IDNO', 'NAMA', 'ICNO', 'NO_KENDERAAN', 'SIRI_PELEKAT', 'KODJENIS', 'KODMODEL', 'LOKASI', 'KODKAMPUS', 'KODKOLEJ', 'KODJFPIU', 'KODPROGRAM', 'KODSALAH1', 'NOTA1', 'KODSALAH2', 'NOTA2', 'KODSALAH3', 'NOTA3', 'KODSALAH4', 'NOTA4', 'NOKUNCI', 'KODBADAN', 'KODPGUATKUASA', 'DATELOG', 'LATITUD', 'LONGITUD', 'ACTION', 'ISTRANSFER', 'STATUS', 'CATATAN'], 'safe'],
            [['TOTALAMN1', 'TOTALAMN2', 'TOTALAMN3', 'TOTALAMN4', 'KODSALAH1_AMN1', 'KODSALAH1_AMN2', 'KODSALAH1_AMN3', 'KODSALAH1_AMN4', 'KODSALAH2_AMN1', 'KODSALAH2_AMN2', 'KODSALAH2_AMN3', 'KODSALAH2_AMN4', 'KODSALAH3_AMN1', 'KODSALAH3_AMN2', 'KODSALAH3_AMN3', 'KODSALAH3_AMN4', 'KODSALAH4_AMN1', 'KODSALAH4_AMN2', 'KODSALAH4_AMN3', 'KODSALAH4_AMN4', 'AMNKUNCI'], 'number'],
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
        $query = SamanOld::find();

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
            'TRKHSAMAN' => $this->TRKHSAMAN,
            'TOTALAMN1' => $this->TOTALAMN1,
            'TOTALAMN2' => $this->TOTALAMN2,
            'TOTALAMN3' => $this->TOTALAMN3,
            'TOTALAMN4' => $this->TOTALAMN4,
            'KODSALAH1_AMN1' => $this->KODSALAH1_AMN1,
            'KODSALAH1_AMN2' => $this->KODSALAH1_AMN2,
            'KODSALAH1_AMN3' => $this->KODSALAH1_AMN3,
            'KODSALAH1_AMN4' => $this->KODSALAH1_AMN4,
            'KODSALAH2_AMN1' => $this->KODSALAH2_AMN1,
            'KODSALAH2_AMN2' => $this->KODSALAH2_AMN2,
            'KODSALAH2_AMN3' => $this->KODSALAH2_AMN3,
            'KODSALAH2_AMN4' => $this->KODSALAH2_AMN4,
            'KODSALAH3_AMN1' => $this->KODSALAH3_AMN1,
            'KODSALAH3_AMN2' => $this->KODSALAH3_AMN2,
            'KODSALAH3_AMN3' => $this->KODSALAH3_AMN3,
            'KODSALAH3_AMN4' => $this->KODSALAH3_AMN4,
            'KODSALAH4_AMN1' => $this->KODSALAH4_AMN1,
            'KODSALAH4_AMN2' => $this->KODSALAH4_AMN2,
            'KODSALAH4_AMN3' => $this->KODSALAH4_AMN3,
            'KODSALAH4_AMN4' => $this->KODSALAH4_AMN4,
            'DATELOG' => $this->DATELOG,
            'AMNKUNCI' => $this->AMNKUNCI,
        ]);

        $query->andFilterWhere(['like', 'NOSAMAN', $this->NOSAMAN])
            ->andFilterWhere(['like', 'KATEGORI', $this->KATEGORI])
            ->andFilterWhere(['like', 'IDNO', $this->IDNO])
            ->andFilterWhere(['like', 'NAMA', $this->NAMA])
            ->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'NO_KENDERAAN', $this->NO_KENDERAAN])
            ->andFilterWhere(['like', 'SIRI_PELEKAT', $this->SIRI_PELEKAT])
            ->andFilterWhere(['like', 'KODJENIS', $this->KODJENIS])
            ->andFilterWhere(['like', 'KODMODEL', $this->KODMODEL])
            ->andFilterWhere(['like', 'LOKASI', $this->LOKASI])
            ->andFilterWhere(['like', 'KODKAMPUS', $this->KODKAMPUS])
            ->andFilterWhere(['like', 'KODKOLEJ', $this->KODKOLEJ])
            ->andFilterWhere(['like', 'KODJFPIU', $this->KODJFPIU])
            ->andFilterWhere(['like', 'KODPROGRAM', $this->KODPROGRAM])
            ->andFilterWhere(['like', 'KODSALAH1', $this->KODSALAH1])
            ->andFilterWhere(['like', 'NOTA1', $this->NOTA1])
            ->andFilterWhere(['like', 'KODSALAH2', $this->KODSALAH2])
            ->andFilterWhere(['like', 'NOTA2', $this->NOTA2])
            ->andFilterWhere(['like', 'KODSALAH3', $this->KODSALAH3])
            ->andFilterWhere(['like', 'NOTA3', $this->NOTA3])
            ->andFilterWhere(['like', 'KODSALAH4', $this->KODSALAH4])
            ->andFilterWhere(['like', 'NOTA4', $this->NOTA4])
            ->andFilterWhere(['like', 'NOKUNCI', $this->NOKUNCI])
            ->andFilterWhere(['like', 'KODBADAN', $this->KODBADAN])
            ->andFilterWhere(['like', 'KODPGUATKUASA', $this->KODPGUATKUASA])
            ->andFilterWhere(['like', 'LATITUD', $this->LATITUD])
            ->andFilterWhere(['like', 'LONGITUD', $this->LONGITUD])
            ->andFilterWhere(['like', 'ACTION', $this->ACTION])
            ->andFilterWhere(['like', 'ISTRANSFER', $this->ISTRANSFER])
            ->andFilterWhere(['like', 'STATUS', $this->STATUS])
            ->andFilterWhere(['like', 'CATATAN', $this->CATATAN]);

        return $dataProvider;
    }
}
