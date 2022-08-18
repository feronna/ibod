<?php

namespace app\models\cbelajar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\TblPengajian;

/**
 * TblPengajianSearch represents the model behind the search form of `app\models\cbelajar\TblPengajian`.
 */
class TblPengajianSearch extends TblPengajian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tahun', 'iklan_id', 'HighestEduLevelCd', 'modeID', 'parent_id', 'idBorang', 'idPermohonan', 'status', 'days'], 'integer'],
            [['icno', 'HighestEduLevel', 'InstNm', 'CountryCd', 'MajorMinor', 'MajorCd', 'tarikh_mula', 'tarikh_tamat', 'nama_penyelia', 'emel_penyelia', 'tarikh_mohon', 'tajuk_tesis', 'created_dt', 'full_dt', 'dokumen', 'Country', 'terima'], 'safe'],
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
        $query = TblPengajian::find();
        

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
            'icno' => $this->icno,
            'tahun' => $this->tahun,
            'iklan_id' => $this->iklan_id,
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
            'modeID' => $this->modeID,
            'tarikh_mohon' => $this->tarikh_mohon,
            'created_dt' => $this->created_dt,
            'parent_id' => $this->parent_id,
            'idBorang' => $this->idBorang,
            'idPermohonan' => $this->idPermohonan,
            'status' => $this->status,
            'days' => $this->days,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'HighestEduLevel', $this->HighestEduLevel])
            ->andFilterWhere(['like', 'InstNm', $this->InstNm])
            ->andFilterWhere(['like', 'CountryCd', $this->CountryCd])
            ->andFilterWhere(['like', 'MajorMinor', $this->MajorMinor])
            ->andFilterWhere(['like', 'MajorCd', $this->MajorCd])
            ->andFilterWhere(['like', 'tarikh_mula', $this->tarikh_mula])
            ->andFilterWhere(['like', 'tarikh_tamat', $this->tarikh_tamat])
            ->andFilterWhere(['like', 'nama_penyelia', $this->nama_penyelia])
            ->andFilterWhere(['like', 'emel_penyelia', $this->emel_penyelia])
            ->andFilterWhere(['like', 'tajuk_tesis', $this->tajuk_tesis])
            ->andFilterWhere(['like', 'full_dt', $this->full_dt])
            ->andFilterWhere(['like', 'dokumen', $this->dokumen])
            ->andFilterWhere(['like', 'Country', $this->Country])
            ->andFilterWhere(['like', 'terima', $this->terima])
            ->andFilterWhere(['like', 'status', $this->status]);
        return $dataProvider;
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
