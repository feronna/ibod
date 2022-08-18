<?php

namespace app\models\e_perkhidmatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\e_perkhidmatan\Event;

/**
 * EventSearch represents the model behind the search form of `app\models\e_perkhidmatan\Event`.
 */
class EventSearch extends Event
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'event_anggaran_peserta', 'event_application_status', 'dept_id', 'papan_tanda_status', 'banner_status', 'banner_payment_status', 'kawalan_status', 'parkir_status'], 'integer'],
            [['event_name', 'event_location', 'event_date_start', 'event_date_end', 'event_time_start', 'event_time_end', 'user_id', 'banner_location', 'banner_date_start', 'banner_date_end', 'banner_time_start', 'banner_time_end', 'banner_company_name', 'banner_company_no', 'banner_title', 'banner_permit_no', 'banner_payment_verifier', 'event_date_applied', 'event_date_verified', 'event_verifier_id', 'event_verifier_notes', 'event_date_approved', 'event_approver_id', 'event_approver_notes', 'event_pemohon_id', 'papan_tanda_date_start', 'papan_tanda_date_end',], 'safe'],
            [['banner_payment_total'], 'number'],
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
        $query = Event::find();

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
            'event_id' => $this->event_id,
            'event_date_start' => $this->event_date_start,
            'event_date_end' => $this->event_date_end,
            'event_time_start' => $this->event_time_start,
            'event_time_end' => $this->event_time_end,
            'event_anggaran_peserta' => $this->event_anggaran_peserta,
            'event_application_status' => $this->event_application_status,
            'dept_id' => $this->dept_id,
            'papan_tanda_status' => $this->papan_tanda_status,
            'banner_status' => $this->banner_status,
            'banner_date_start' => $this->banner_date_start,
            'banner_date_end' => $this->banner_date_end,
            'banner_time_start' => $this->banner_time_start,
            'banner_time_end' => $this->banner_time_end,
            'banner_payment_status' => $this->banner_payment_status,
            'banner_payment_total' => $this->banner_payment_total,
            'event_date_applied' => $this->event_date_applied,
            'event_date_verified' => $this->event_date_verified,
            'event_date_approved' => $this->event_date_approved,
            'kawalan_status' => $this->kawalan_status,
            'parkir_status' => $this->parkir_status,
            'papan_tanda_date_start' => $this->papan_tanda_date_start,
            'papan_tanda_date_end' => $this->papan_tanda_date_end,
        ]);

        $query->andFilterWhere(['like', 'event_name', $this->event_name])
            ->andFilterWhere(['like', 'event_location', $this->event_location])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'banner_location', $this->banner_location])
            ->andFilterWhere(['like', 'banner_company_name', $this->banner_company_name])
            ->andFilterWhere(['like', 'banner_company_no', $this->banner_company_no])
            ->andFilterWhere(['like', 'banner_title', $this->banner_title])
            ->andFilterWhere(['like', 'banner_permit_no', $this->banner_permit_no])
            ->andFilterWhere(['like', 'banner_payment_verifier', $this->banner_payment_verifier])
            ->andFilterWhere(['like', 'event_verifier_id', $this->event_verifier_id])
            ->andFilterWhere(['like', 'event_verifier_notes', $this->event_verifier_notes])
            ->andFilterWhere(['like', 'event_approver_id', $this->event_approver_id])
            ->andFilterWhere(['like', 'event_approver_notes', $this->event_approver_notes])
            ->andFilterWhere(['like', 'event_pemohon_id', $this->event_pemohon_id])
            ->andFilterWhere(['like', 'papan_tanda_title', $this->papan_tanda_title]);

        return $dataProvider;
    }
}
