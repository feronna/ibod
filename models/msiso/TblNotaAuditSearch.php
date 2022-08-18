<?php

namespace app\models\msiso;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\msiso\TblNotaAudit;

/**
 * TblNotaAuditSearch represents the model behind the search form of `app\models\msiso\TblNotaAudit`.
 */
class TblNotaAuditSearch extends TblNotaAudit
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['iso_no', 'dept', 'auditee_by', 'auditee_name', 'auditee_dt', 'auditor_by', 'auditor_name', 'auditor_dt', 'standard', 'rujukan_fail', 'list_check', 'catatan', 'attachment'], 'safe'],
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
        $query = TblNotaAudit::find();

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
            'auditee_dt' => $this->auditee_dt,
            'auditor_dt' => $this->auditor_dt,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'iso_no', $this->iso_no])
            ->andFilterWhere(['like', 'dept', $this->dept])
            ->andFilterWhere(['like', 'auditee_by', $this->auditee_by])
            ->andFilterWhere(['like', 'auditee_name', $this->auditee_name])
            ->andFilterWhere(['like', 'auditor_by', $this->auditor_by])
            ->andFilterWhere(['like', 'auditor_name', $this->auditor_name])
            ->andFilterWhere(['like', 'standard', $this->standard])
            ->andFilterWhere(['like', 'rujukan_fail', $this->rujukan_fail])
            ->andFilterWhere(['like', 'list_check', $this->list_check])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'attachment', $this->attachment]);

        return $dataProvider;
    }
}
