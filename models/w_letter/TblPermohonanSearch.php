<?php

namespace app\models\w_letter;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\w_letter\TblPermohonan;

/**
 * TblPermohonanSearch represents the model behind the search form of `app\models\w_letter\TblPermohonan`.
 */
class TblPermohonanSearch extends TblPermohonan
{
    public $deptId;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_semasa', 'status_notifikasi', 'isActive', 'approved_kj_status', 'approved_bsm_status', 'auto'], 'integer'],
            [['deptId','ICNO', 'tugas', 'tarikh_mohon', 'tarikh_notifikasi', 'approved_kj_at', 'approved_kj_by', 'approved_kj_ulasan', 'approved_bsm_at', 'approved_bsm_by', 'approved_bsm_ulasan', 'StartDate', 'EndDate'], 'safe'],
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
        $query = TblPermohonan::find();
        $query->joinWith(['biodata']);  

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
            'status_notifikasi' => $this->status_notifikasi,
            'tarikh_notifikasi' => $this->tarikh_notifikasi,
            'isActive' => $this->isActive,
            'approved_kj_at' => $this->approved_kj_at,
            'approved_kj_status' => $this->approved_kj_status,
            'approved_bsm_at' => $this->approved_bsm_at,
            'approved_bsm_status' => $this->approved_bsm_status,
            'StartDate' => $this->StartDate,
            'EndDate' => $this->EndDate,
            'auto' => $this->auto,
            'deptId' => $this->deptId,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'tugas', $this->tugas])
            ->andFilterWhere(['like', 'approved_kj_by', $this->approved_kj_by])
            ->andFilterWhere(['like', 'approved_kj_ulasan', $this->approved_kj_ulasan])
            ->andFilterWhere(['like', 'approved_bsm_by', $this->approved_bsm_by])
            ->andFilterWhere(['like', 'approved_bsm_ulasan', $this->approved_bsm_ulasan]);

        return $dataProvider;
    }
}
