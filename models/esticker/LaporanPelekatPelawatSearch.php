<?php

namespace app\models\esticker;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\esticker\TblPelekatKenderaanPelawat;

/**
 * LaporanPelekatPelawatSearch represents the model behind the search form of `app\models\esticker\TblPelekatKenderaanPelawat`.
 */
class LaporanPelekatPelawatSearch extends TblPelekatKenderaanPelawat
{
     public $CatCd,$bulanan,$tahun;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_kenderaan', 'deleted', 'id_pelawat'], 'integer'],
            [['CatCd','bulanan','tahun','status_mohon', 'mohon_date', 'apply_type', 'no_siri', 'expired_date', 'expired_date_2', 'updater'], 'safe'],
            [['total'], 'number'],
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
        $query = TblPelekatKenderaanPelawat::find()->joinWith('kenderaan.biodata')->where(['status_mohon'=>'AKTIF']);

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
            'kenderaan.biodata.CatCd'=> $this->CatCd,
            'id' => $this->id,
            'id_kenderaan' => $this->id_kenderaan,
            'DATE(mohon_date)' => $this->mohon_date,
            'DATE_FORMAT(mohon_date, "%m-%Y")' => $this->bulanan,
            'DATE_FORMAT(mohon_date, "%Y")' => $this->tahun,
            'expired_date' => $this->expired_date,
            'expired_date_2' => $this->expired_date_2,
            'total' => $this->total,
            'deleted' => $this->deleted,
            'id_pelawat' => $this->id_pelawat,
        ]);

        $query->andFilterWhere(['like', 'status_mohon', $this->status_mohon])
            ->andFilterWhere(['like', 'apply_type', $this->apply_type])
            ->andFilterWhere(['like', 'no_siri', $this->no_siri])
            ->andFilterWhere(['like', 'updater', $this->updater]);

        return $dataProvider;
    }
}
