<?php

namespace app\models\cbelajar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\TblLaporDiri;

/**
 * TblLaporDiriSearch represents the model behind the search form of `app\models\cbelajar\TblLaporDiri`.
 */
class TblLaporDiriSearch extends TblLaporDiri
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['laporID', 'iklan_id', 'idBorang'], 'integer'],
            [['icno', 'status_pengajian', 'dt_tesis', 'dt_viva', 'dt_endstudy', 'dt_result', 'dt_iv', 'dokumen', 'correction', 'ulasan', 'app_by', 'app_date', 'ver_by', 'ver_date', 'dt_lapordiri', 'catatan', 'terima', 'kali_ke', 'tarikh_mesyuarat', 'status_mesyuarat', 'status_borang', 'tarikh_mohon', 'status', 'status_jfpiu', 'status_bsm', 'agree', 'writing', 'lain', 'dokumen2', 'dokumen3', 'dokumen4', 'dokumen5', 'ulasan_jfpiu', 'dokumen_6', 'status_study', 'jenismohon'], 'safe'],
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
        $query = TblLaporDiri::find();

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
            'laporID' => $this->laporID,
            'dt_tesis' => $this->dt_tesis,
            'dt_viva' => $this->dt_viva,
            'dt_endstudy' => $this->dt_endstudy,
            'dt_result' => $this->dt_result,
            'dt_iv' => $this->dt_iv,
            'app_date' => $this->app_date,
            'ver_date' => $this->ver_date,
            'dt_lapordiri' => $this->dt_lapordiri,
            'tarikh_mohon' => $this->tarikh_mohon,
            'iklan_id' => $this->iklan_id,
            'idBorang' => $this->idBorang,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'status_pengajian', $this->status_pengajian])
            ->andFilterWhere(['like', 'dokumen', $this->dokumen])
            ->andFilterWhere(['like', 'correction', $this->correction])
            ->andFilterWhere(['like', 'ulasan', $this->ulasan])
            ->andFilterWhere(['like', 'app_by', $this->app_by])
            ->andFilterWhere(['like', 'ver_by', $this->ver_by])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'terima', $this->terima])
            ->andFilterWhere(['like', 'kali_ke', $this->kali_ke])
            ->andFilterWhere(['like', 'tarikh_mesyuarat', $this->tarikh_mesyuarat])
            ->andFilterWhere(['like', 'status_mesyuarat', $this->status_mesyuarat])
            ->andFilterWhere(['like', 'status_borang', $this->status_borang])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'status_jfpiu', $this->status_jfpiu])
            ->andFilterWhere(['like', 'status_bsm', $this->status_bsm])
            ->andFilterWhere(['like', 'agree', $this->agree])
            ->andFilterWhere(['like', 'writing', $this->writing])
            ->andFilterWhere(['like', 'lain', $this->lain])
            ->andFilterWhere(['like', 'dokumen2', $this->dokumen2])
            ->andFilterWhere(['like', 'dokumen3', $this->dokumen3])
            ->andFilterWhere(['like', 'dokumen4', $this->dokumen4])
            ->andFilterWhere(['like', 'dokumen5', $this->dokumen5])
            ->andFilterWhere(['like', 'ulasan_jfpiu', $this->ulasan_jfpiu])
            ->andFilterWhere(['like', 'dokumen_6', $this->dokumen_6])
            ->andFilterWhere(['like', 'status_study', $this->status_study])
            ->andFilterWhere(['like', 'jenismohon', $this->jenismohon]);

        return $dataProvider;
    }
}
