<?php

namespace app\models\msiso;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\msiso\AuditPlan;

/**
 * AuditPlanSearch represents the model behind the search form of `app\models\msiso\AuditPlan`.
 */
class AuditPlanSearch extends AuditPlan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['audit_plan', 'created_by', 'created_dt', 'year', 'catatan', 'confirm_audit_plan', 'status'], 'safe'],
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
        $query = AuditPlan::find();

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
            'created_dt' => $this->created_dt,
        ]);

        $query->andFilterWhere(['like', 'audit_plan', $this->audit_plan])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'confirm_audit_plan', $this->confirm_audit_plan]);

        return $dataProvider;
    }
}
