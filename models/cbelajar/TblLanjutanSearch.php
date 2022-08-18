<?php

namespace app\models\cbelajar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\TblLanjutan;

/**
 * TblLanjutanSearch represents the model behind the search form of `app\models\cbelajar\TblLanjutan`.
 */
class TblLanjutanSearch extends TblLanjutan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'iklan_id', 'jenis_user_id', 'idBorang'], 'integer'],
            [['icno', 'tarikh_mohon', 'app_by', 'app_date', 'ver_by', 'ver_date', 'status_jfpiu', 'ulasan_jfpiu', 'status_kj', 'ulasan_kj', 'status_bsm', 'alamat', 'tempoh_masa', 'fulldt', 'lanjutansdt', 'lanjutanedt', 'justifikasi', 'dokumen_sokongan', 'dokumen_sokongan2', 'tarikh_lulus', 'status_borang', 'status', 'terima', 'kali_ke', 'tarikh_mesyuarat', 'status_mesyuarat', 'catatan_bsm', 'surat'], 'safe'],
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
        $query = TblLanjutan::find();

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
            'iklan_id' => $this->iklan_id,
            'jenis_user_id' => $this->jenis_user_id,
            'tarikh_mohon' => $this->tarikh_mohon,
            'app_date' => $this->app_date,
            'ver_date' => $this->ver_date,
            'lanjutansdt' => $this->lanjutansdt,
            'lanjutanedt' => $this->lanjutanedt,
            'tarikh_lulus' => $this->tarikh_lulus,
            'idBorang' => $this->idBorang,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'app_by', $this->app_by])
            ->andFilterWhere(['like', 'ver_by', $this->ver_by])
            ->andFilterWhere(['like', 'status_jfpiu', $this->status_jfpiu])
            ->andFilterWhere(['like', 'ulasan_jfpiu', $this->ulasan_jfpiu])
            ->andFilterWhere(['like', 'status_kj', $this->status_kj])
            ->andFilterWhere(['like', 'ulasan_kj', $this->ulasan_kj])
            ->andFilterWhere(['like', 'status_bsm', $this->status_bsm])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'tempoh_masa', $this->tempoh_masa])
            ->andFilterWhere(['like', 'fulldt', $this->fulldt])
            ->andFilterWhere(['like', 'justifikasi', $this->justifikasi])
            ->andFilterWhere(['like', 'dokumen_sokongan', $this->dokumen_sokongan])
            ->andFilterWhere(['like', 'dokumen_sokongan2', $this->dokumen_sokongan2])
            ->andFilterWhere(['like', 'status_borang', $this->status_borang])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'terima', $this->terima])
            ->andFilterWhere(['like', 'kali_ke', $this->kali_ke])
            ->andFilterWhere(['like', 'tarikh_mesyuarat', $this->tarikh_mesyuarat])
            ->andFilterWhere(['like', 'status_mesyuarat', $this->status_mesyuarat])
            ->andFilterWhere(['like', 'catatan_bsm', $this->catatan_bsm])
            ->andFilterWhere(['like', 'surat', $this->surat]);

        return $dataProvider;
    }
}
