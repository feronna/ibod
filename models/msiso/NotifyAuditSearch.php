<?php

namespace app\models\msiso;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\msiso\NotifyAudit;

/**
 * NotifyAuditSearch represents the model behind the search form of `app\models\msiso\NotifyAudit`.
 */
class NotifyAuditSearch extends NotifyAudit
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['iso_audit', 'dept', 'plan_audit_dt', 'from_audit_time', 'created_by', 'created_dt', 'confirm_audit_dt', 'confirm_audit_time', 'year', 'catatan', 'attachment'], 'safe'],
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
        $query = NotifyAudit::find();

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
            'plan_audit_dt' => $this->plan_audit_dt,
            'created_dt' => $this->created_dt,
            'confirm_audit_dt' => $this->confirm_audit_dt,
        ]);

        $query->andFilterWhere(['like', 'iso_audit', $this->iso_audit])
            ->andFilterWhere(['like', 'dept', $this->dept])
            ->andFilterWhere(['like', 'from_audit_time', $this->from_audit_time])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'confirm_audit_time', $this->confirm_audit_time])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'attachment', $this->attachment]);

        return $dataProvider;
    }
}
