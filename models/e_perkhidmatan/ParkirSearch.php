<?php

namespace app\models\e_perkhidmatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\e_perkhidmatan\Parkir;

/**
 * ParkirSearch represents the model behind the search form of `app\models\e_perkhidmatan\Parkir`.
 */
class ParkirSearch extends Parkir
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'days', 'isActive', 'letter_sent'], 'integer'],
            [['icno', 'jenis_kenderaan', 'no_pendaftaran_kenderaan', 'jenama_kenderaan', 'model_kenderaan', 'warna_kenderaan', 'tarikh_meletakkan_kenderaan', 'tarikh_pengambilan_kenderaan', 'status', 'entry_date', 'ver_by', 'ver_date', 'status_semakan', 'ulasan_semakan', 'app_by', 'app_date', 'status_kj', 'ulasan_kj'], 'safe'],
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
        $query = Parkir::find();

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
            'entry_date' => $this->entry_date,
            'ver_date' => $this->ver_date,
            'app_date' => $this->app_date,
            'isActive' => $this->isActive,
            'letter_sent' => $this->letter_sent,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'jenis_kenderaan', $this->jenis_kenderaan])
            ->andFilterWhere(['like', 'no_pendaftaran_kenderaan', $this->no_pendaftaran_kenderaan])
            ->andFilterWhere(['like', 'jenama_kenderaan', $this->jenama_kenderaan])
            ->andFilterWhere(['like', 'model_kenderaan', $this->model_kenderaan])
            ->andFilterWhere(['like', 'warna_kenderaan', $this->warna_kenderaan])
            ->andFilterWhere(['like', 'tarikh_meletakkan_kenderaan', $this->tarikh_meletakkan_kenderaan])
            ->andFilterWhere(['like', 'tarikh_pengambilan_kenderaan', $this->tarikh_pengambilan_kenderaan])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'ver_by', $this->ver_by])
            ->andFilterWhere(['like', 'status_semakan', $this->status_semakan])
            ->andFilterWhere(['like', 'ulasan_semakan', $this->ulasan_semakan])
            ->andFilterWhere(['like', 'app_by', $this->app_by])
            ->andFilterWhere(['like', 'status_kj', $this->status_kj])
            ->andFilterWhere(['like', 'ulasan_kj', $this->ulasan_kj]);

        return $dataProvider;
    }
}
