<?php

namespace app\models\e_perkhidmatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\e_perkhidmatan\PermitApplication;

/**
 * PermitApplicationSearch represents the model behind the search form of `app\models\e_perkhidmatan\PermitApplication`.
 */
class PermitApplicationSearch extends PermitApplication
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_id', 'staff_id', 'dept_id', 'user_contact_no', 'company_contact_no', 'application_status', 'verifier_id', 'approver_id', 'payment_status', 'payment_verifier', 'rasmi_status'], 'integer'],
            [['user_id', 'student_id', 'location', 'date_start', 'date_end', 'time_start', 'time_end', 'company_name', 'date_applied', 'date_verified', 'verifier_notes', 'date_approved', 'permit_no'], 'safe'],
            [['payment_total'], 'number'],
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
        $query = PermitApplication::find();

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
            'app_id' => $this->app_id,
            'staff_id' => $this->staff_id,
            'dept_id' => $this->dept_id,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'user_contact_no' => $this->user_contact_no,
            'company_contact_no' => $this->company_contact_no,
            'application_status' => $this->application_status,
            'date_applied' => $this->date_applied,
            'date_verified' => $this->date_verified,
            'verifier_id' => $this->verifier_id,
            'date_approved' => $this->date_approved,
            'approver_id' => $this->approver_id,
            'payment_status' => $this->payment_status,
            'payment_total' => $this->payment_total,
            'payment_verifier' => $this->payment_verifier,
            'rasmi_status' => $this->rasmi_status,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'student_id', $this->student_id])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'verifier_notes', $this->verifier_notes])
            ->andFilterWhere(['like', 'permit_no', $this->permit_no]);

        return $dataProvider;
    }
}
