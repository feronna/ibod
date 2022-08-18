<?php

namespace app\models\e_mou;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\e_mou\TblMemorandum;

/**
 * TblMemorandumSearch represents the model behind the search form of `app\models\e_mou\TblMemorandum`.
 */
class TblMemorandumSearch extends TblMemorandum
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['memorandum_id', 'id_dept', 'id_memorandum_type', 'id_approver_committee', 'id_status', 'id_verify', 'id_review', 'id_approval', 'id_second_approval', 'id_seal', 'id_verify_update'], 'integer'],
            [['external_parties', 'code_country', 'code_country2', 'signature_date', 'expiration_date', 'status_date', 'status_comment', 'submit_date', 'verify_date', 'verify_comment', 'review_date', 'review_comment', 'approval_date', 'approval_comment', 'second_approval_date', 'second_approval_comment', 'seal_date', 'seal_comment', 'verify_update_date', 'verify_update_comment', 'jfpiu_files', 'jfpiu_files2', 'bpt_files', 'bpt_files2', 'last_update', 'user_update'], 'safe'],
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
        $query = TblMemorandum::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['id_status']],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'memorandum_id' => $this->memorandum_id,
            'id_dept' => $this->id_dept,
            'signature_date' => $this->signature_date,
            'expiration_date' => $this->expiration_date,
            'id_memorandum_type' => $this->id_memorandum_type,
            'id_approver_committee' => $this->id_approver_committee,
            'id_status' => $this->id_status,
            'status_date' => $this->status_date,
            'submit_date' => $this->submit_date,
            'id_verify' => $this->id_verify,
            'verify_date' => $this->verify_date,
            'id_review' => $this->id_review,
            'review_date' => $this->review_date,
            'id_approval' => $this->id_approval,
            'approval_date' => $this->approval_date,
            'id_second_approval' => $this->id_second_approval,
            'second_approval_date' => $this->second_approval_date,
            'id_seal' => $this->id_seal,
            'seal_date' => $this->seal_date,
            'id_verify_update' => $this->id_verify_update,
            'verify_update_date' => $this->verify_update_date,
            'last_update' => $this->last_update,
        ]);

        $query->andFilterWhere(['like', 'external_parties', $this->external_parties])
            ->andFilterWhere(['like', 'code_country', $this->code_country])
            ->andFilterWhere(['like', 'code_country2', $this->code_country2])
            ->andFilterWhere(['like', 'status_comment', $this->status_comment])
            ->andFilterWhere(['like', 'verify_comment', $this->verify_comment])
            ->andFilterWhere(['like', 'review_comment', $this->review_comment])
            ->andFilterWhere(['like', 'approval_comment', $this->approval_comment])
            ->andFilterWhere(['like', 'second_approval_comment', $this->second_approval_comment])
            ->andFilterWhere(['like', 'seal_comment', $this->seal_comment])
            ->andFilterWhere(['like', 'verify_update_comment', $this->verify_update_comment])
            ->andFilterWhere(['like', 'jfpiu_files', $this->jfpiu_files])
            ->andFilterWhere(['like', 'jfpiu_files2', $this->jfpiu_files2])
            ->andFilterWhere(['like', 'bpt_files', $this->bpt_files])
            ->andFilterWhere(['like', 'bpt_files2', $this->bpt_files2])
            ->andFilterWhere(['like', 'user_update', $this->user_update]);

        return $dataProvider;
    }
}
