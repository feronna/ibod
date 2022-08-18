<?php

namespace app\models\cbelajar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\TblBiasiswa;
use app\models\hronline\Tblprcobiodata;

/**
 * TblBiasiswaSearch represents the model behind the search form of `app\models\cbelajar\TblBiasiswa`.
 */
class TblBiasiswaSearch extends TblBiasiswa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tahun', 'iklan_id', 'jenisCd', 'BantuanCd', 'idBorang', 'idPermohonan', 'HighestEduLevelCd', 'status_form'], 'integer'],
            [['icno', 'bentukBantuan', 'CountryCd', 'nama_tajaan', 'amaunBantuan', 'statusUMS', 'created_dt'], 'safe'],
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
        $query = TblBiasiswa::find();

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
            'tahun' => $this->tahun,
            'iklan_id' => $this->iklan_id,
            'jenisCd' => $this->jenisCd,
            'BantuanCd' => $this->BantuanCd,
            'created_dt' => $this->created_dt,
            'idBorang' => $this->idBorang,
            'idPermohonan' => $this->idPermohonan,
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
            'status_form' => $this->status_form,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'bentukBantuan', $this->bentukBantuan])
            ->andFilterWhere(['like', 'CountryCd', $this->CountryCd])
            ->andFilterWhere(['like', 'nama_tajaan', $this->nama_tajaan])
            ->andFilterWhere(['like', 'amaunBantuan', $this->amaunBantuan])
            ->andFilterWhere(['like', 'statusUMS', $this->statusUMS]);

        return $dataProvider;
    }
     public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
