<?php

namespace app\models\ln;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ln\Ln;

/**
 * LnSearch represents the model behind the search form of `app\models\ln\Ln`.
 */
class LnSearch extends Ln
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'days', 'bil_peserta'], 'integer'],
            [['icno', 'tujuan', 'nama_tempat', 'date_from', 'date_to', 'perbelanjaan', 'entry_date', 'status', 'status_mohon', 'app_by', 'app_date', 'status_jfpiu', 'ulasan_jfpiu', 'ver_by', 'ver_date', 'status_semakan', 'ulasan_semakan', 'tambang', 'elaun_makan', 'elaun_hotel', 'yuran', 'transport', 'dll', 'jumlah'], 'safe'],
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
        $query = Ln::find();

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
            'days' => $this->days,
            'bil_peserta' => $this->bil_peserta,
            'entry_date' => $this->entry_date,
            'app_date' => $this->app_date,
            'ver_date' => $this->ver_date,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'tujuan', $this->tujuan])
            ->andFilterWhere(['like', 'nama_tempat', $this->nama_tempat])
//            ->andFilterWhere(['like', 'negara', $this->negara])
            ->andFilterWhere(['like', 'date_from', $this->date_from])
            ->andFilterWhere(['like', 'date_to', $this->date_to])
            ->andFilterWhere(['like', 'perbelanjaan', $this->perbelanjaan])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'app_by', $this->app_by])
            ->andFilterWhere(['like', 'status_jfpiu', $this->status_jfpiu])
            ->andFilterWhere(['like', 'ulasan_jfpiu', $this->ulasan_jfpiu])
            ->andFilterWhere(['like', 'ver_by', $this->ver_by])
            ->andFilterWhere(['like', 'status_semakan', $this->status_semakan])
            ->andFilterWhere(['like', 'ulasan_semakan', $this->ulasan_semakan]);

        return $dataProvider;
    }
}
