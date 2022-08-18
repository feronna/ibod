<?php

namespace app\models\pinjaman;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pinjaman\Pinjaman;

/**
 * PinjamanSearch represents the model behind the search form of `app\models\pinjaman\Pinjaman`.
 */
class PinjamanSearch extends Pinjaman
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_semasa', 'isActive'], 'integer'],
            [['icno', 'tarikh_mohon', 'no_kakitangan', 'agensi_bank', 'status_pt', 'catatan_pt', 'datetime_pt', 'status_pp', 'catatan_pp', 'datetime_pp', 'dokumen_sokongan', 'tarikh_diambil', 'diterima_oleh'], 'safe'],
            [['jumlah_pinjaman', 'bayaran_bulanan', 'jumlah_bulan_bayaran'], 'number'],
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
        $query = Pinjaman::find();

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
            'tarikh_mohon' => $this->tarikh_mohon,
            'status_semasa' => $this->status_semasa,
            'jumlah_pinjaman' => $this->jumlah_pinjaman,
            'bayaran_bulanan' => $this->bayaran_bulanan,
            'jumlah_bulan_bayaran' => $this->jumlah_bulan_bayaran,
            'datetime_pt' => $this->datetime_pt,
            'datetime_pp' => $this->datetime_pp,
            'isActive' => $this->isActive,
            'tarikh_diambil' => $this->tarikh_diambil,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'no_kakitangan', $this->no_kakitangan])
            ->andFilterWhere(['like', 'agensi_bank', $this->agensi_bank])
            ->andFilterWhere(['like', 'status_pt', $this->status_pt])
            ->andFilterWhere(['like', 'catatan_pt', $this->catatan_pt])
            ->andFilterWhere(['like', 'status_pp', $this->status_pp])
            ->andFilterWhere(['like', 'catatan_pp', $this->catatan_pp])
            ->andFilterWhere(['like', 'dokumen_sokongan', $this->dokumen_sokongan])
            ->andFilterWhere(['like', 'diterima_oleh', $this->diterima_oleh]);

        return $dataProvider;
    }
}
