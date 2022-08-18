<?php

namespace app\models\ptb;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ptb\TblSerahTugas;

/**
 * TblTugasBelumSelesaiSearch represents the model behind the search form of `app\models\ptb\TblSerahTugas`.
 */
class TblSerahTugasSearch extends TblSerahTugas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['tugas_id'], 'integer'],
            [['icno', 'senarai_tugas', 'tugas_belum_selesai', 'kedudukan_sekarang', 'tindakan_susulan', 'rujukan_fail', 'senarai_harta_benda', 'kedudukan_kewangan', 'catatan'], 'safe'],
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
        $query = TblSerahTugas::find();

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
        ]);

        $query->andFilterWhere(['like', 'senarai_tugas', $this->senarai_tugas])
            ->andFilterWhere(['like', 'tugas_belum_selesai', $this->tugas_belum_selesai])
            ->andFilterWhere(['like', 'kedudukan_sekarang', $this->kedudukan_sekarang])
            ->andFilterWhere(['like', 'tindakan_susulan', $this->tindakan_susulan])
            ->andFilterWhere(['like', 'rujukan_fail', $this->rujukan_fail])
            ->andFilterWhere(['like', 'senarai_harta_benda', $this->senarai_harta_benda])
            ->andFilterWhere(['like', 'kedudukan_kewangan', $this->kedudukan_kewangan])
            ->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}
