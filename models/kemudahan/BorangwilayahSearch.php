<?php

namespace app\models\kemudahan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\kemudahan\Borangwilayah;

/**
 * BorangwilayahSearch represents the model behind the search form of `app\models\kemudahan\Borangwilayah`.
 */
class BorangwilayahSearch extends Borangwilayah
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jeniskemudahan', 'mohon', 'isActive', 'status_semasa', 'entry_type', 'letter_type'], 'integer'],
            [['icno', 'nama', 'wilayah_asal', 'tujuan', 'dest_berlepas', 'tarikh_terakhir', 'tarikh_digunakan', 'dest_tiba', 'entry_date', 'tanggungan', 'status_pt', 'catatan_pt', 'semakan_pt', 'semakan_by', 'status_pp', 'catatan_pp', 'peraku_by', 'ver_date', 'tarikh_hantar', 'status_kj', 'catatan_kj', 'pelulus_by', 'app_date', 'stat_bendahari', 'catatan_bendahari', 'bendahari_date', 'pengakuan', 'book_by', 'status_tempahan', 'dt_confrm', 'email_send', 'dokumen_sokongan', 'dokumen_sokongan2'], 'safe'],
            [['jumlah'], 'number'],
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
        $query = Borangwilayah::find();

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
            'jeniskemudahan' => $this->jeniskemudahan,
            'tarikh_terakhir' => $this->tarikh_terakhir,
            'tarikh_digunakan' => $this->tarikh_digunakan,
            'entry_date' => $this->entry_date,
            'semakan_pt' => $this->semakan_pt,
            'ver_date' => $this->ver_date,
            'tarikh_hantar' => $this->tarikh_hantar,
            'app_date' => $this->app_date,
            'bendahari_date' => $this->bendahari_date,
            'dt_confrm' => $this->dt_confrm,
            'email_send' => $this->email_send,
            'jumlah' => $this->jumlah,
            'mohon' => $this->mohon,
            'isActive' => $this->isActive,
            'status_semasa' => $this->status_semasa,
            'entry_type' => $this->entry_type,
            'letter_type' => $this->letter_type,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'wilayah_asal', $this->wilayah_asal])
            ->andFilterWhere(['like', 'tujuan', $this->tujuan])
            ->andFilterWhere(['like', 'dest_berlepas', $this->dest_berlepas])
            ->andFilterWhere(['like', 'dest_tiba', $this->dest_tiba])
            ->andFilterWhere(['like', 'tanggungan', $this->tanggungan])
            ->andFilterWhere(['like', 'status_pt', $this->status_pt])
            ->andFilterWhere(['like', 'catatan_pt', $this->catatan_pt])
            ->andFilterWhere(['like', 'semakan_by', $this->semakan_by])
            ->andFilterWhere(['like', 'status_pp', $this->status_pp])
            ->andFilterWhere(['like', 'catatan_pp', $this->catatan_pp])
            ->andFilterWhere(['like', 'peraku_by', $this->peraku_by])
            ->andFilterWhere(['like', 'status_kj', $this->status_kj])
            ->andFilterWhere(['like', 'catatan_kj', $this->catatan_kj])
            ->andFilterWhere(['like', 'pelulus_by', $this->pelulus_by])
            ->andFilterWhere(['like', 'stat_bendahari', $this->stat_bendahari])
            ->andFilterWhere(['like', 'catatan_bendahari', $this->catatan_bendahari])
            ->andFilterWhere(['like', 'pengakuan', $this->pengakuan])
            ->andFilterWhere(['like', 'book_by', $this->book_by])
            ->andFilterWhere(['like', 'status_tempahan', $this->status_tempahan])
            ->andFilterWhere(['like', 'dokumen_sokongan', $this->dokumen_sokongan])
            ->andFilterWhere(['like', 'dokumen_sokongan2', $this->dokumen_sokongan2]);

        return $dataProvider;
    }
}
