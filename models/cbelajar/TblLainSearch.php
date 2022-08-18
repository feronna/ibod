<?php

namespace app\models\cbelajar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\TblLain;

/**
 * TblLainSearch represents the model behind the search form of `app\models\cbelajar\TblLain`.
 */
class TblLainSearch extends TblLain
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'iklan_id', 'jenis_user_id', 'modeID', 'idBorang'], 'integer'],
            [['icno', 'ver_by', 'ver_date', 'tarikh_mohon', 'renewMod', 'renewTarikhm', 'renewTarikht', 'catatan', 'status_bsm', 'status_borang', 'status', 'dokumen_sokongan', 'terima', 'kali_ke', 'tarikh_mesyuarat', 'status_mesyuarat', 'surat', 'renewTempat', 'app_date', 'app_by', 'full_dt', 'jenismohon', 'status_jfpiu'], 'safe'],
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
        $query = TblLain::find();

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
            'ver_date' => $this->ver_date,
            'tarikh_mohon' => $this->tarikh_mohon,
            'modeID' => $this->modeID,
            'idBorang' => $this->idBorang,
            'app_date' => $this->app_date,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'ver_by', $this->ver_by])
            ->andFilterWhere(['like', 'renewMod', $this->renewMod])
            ->andFilterWhere(['like', 'renewTarikhm', $this->renewTarikhm])
            ->andFilterWhere(['like', 'renewTarikht', $this->renewTarikht])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'status_bsm', $this->status_bsm])
            ->andFilterWhere(['like', 'status_borang', $this->status_borang])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'dokumen_sokongan', $this->dokumen_sokongan])
            ->andFilterWhere(['like', 'terima', $this->terima])
            ->andFilterWhere(['like', 'kali_ke', $this->kali_ke])
            ->andFilterWhere(['like', 'tarikh_mesyuarat', $this->tarikh_mesyuarat])
            ->andFilterWhere(['like', 'status_mesyuarat', $this->status_mesyuarat])
            ->andFilterWhere(['like', 'surat', $this->surat])
            ->andFilterWhere(['like', 'renewTempat', $this->renewTempat])
            ->andFilterWhere(['like', 'app_by', $this->app_by])
            ->andFilterWhere(['like', 'full_dt', $this->full_dt])
            ->andFilterWhere(['like', 'jenismohon', $this->jenismohon])
            ->andFilterWhere(['like', 'status_jfpiu', $this->status_jfpiu]);

        return $dataProvider;
    }
}
