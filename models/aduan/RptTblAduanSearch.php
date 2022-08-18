<?php

namespace app\models\aduan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\aduan\RptTblAduan;

/**
 * RptTblAduanSearch represents the model behind the search form of `app\models\aduan\RptTblAduan`.
 */
class RptTblAduanSearch extends RptTblAduan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aduan_id', 'aduan_status', 'report_status'], 'integer'],
            [['staff_icno', 'aduan_details', 'date_created', 'penerima_icno', 'penerima_notes', 'penerima_date', 'reporter_icno', 'report', 'report_date', 'approver_icno', 'approval_date'], 'safe'],
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
        $query = RptTblAduan::find();

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
            'aduan_id' => $this->aduan_id,
            'date_created' => $this->date_created,
            'aduan_status' => $this->aduan_status,
            'penerima_date' => $this->penerima_date,
            'report_status' => $this->report_status,
            'report_date' => $this->report_date,
            'approval_date' => $this->approval_date,
        ]);

        $query->andFilterWhere(['like', 'staff_icno', $this->staff_icno])
            ->andFilterWhere(['like', 'aduan_details', $this->aduan_details])
            ->andFilterWhere(['like', 'penerima_icno', $this->penerima_icno])
            ->andFilterWhere(['like', 'penerima_notes', $this->penerima_notes])
            ->andFilterWhere(['like', 'reporter_icno', $this->reporter_icno])
            ->andFilterWhere(['like', 'report', $this->report])
            ->andFilterWhere(['like', 'approver_icno', $this->approver_icno]);

        return $dataProvider;
    }
}
