<?php

namespace app\models\msiso;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\msiso\TblNcr;

/**
 * TblNcrSearch represents the model behind the search form of `app\models\msiso\TblNcr`.
 */
class TblNcrSearch extends TblNcr
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jenis_audit', 'closing_ncr'], 'integer'],
            [['status_tindakan','bengkel_by','updated_dt','updated_by','rujukan_fail', 'tarikh_audit', 'dept', 'conformity_req', 'conformity_find', 'invest_result', 'auditor', 'action_plan','verifikasi', 'closing_ncr_dt', 'attachment', 'clause'], 'safe'],
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
        $query = TblNcr::find();

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
            'jenis_audit' => $this->jenis_audit,
            'tarikh_audit' => $this->tarikh_audit, 
            'closing_ncr' => $this->closing_ncr,
            'closing_ncr_dt' => $this->closing_ncr_dt,
            'clause' => $this->clause,
            'auditor' => $this->auditor,
            'status_tindakan' => $this->status_tindakan
        ]);

        $query->andFilterWhere(['like', 'rujukan_fail', $this->rujukan_fail])
            ->andFilterWhere(['like', 'dept', $this->dept])
            ->andFilterWhere(['like', 'clause', $this->clause])
            ->andFilterWhere(['like', 'conformity_req', $this->conformity_req])
            ->andFilterWhere(['like', 'conformity_find', $this->conformity_find])   
            ->andFilterWhere(['like', 'invest_result', $this->invest_result]) 
            ->andFilterWhere(['like', 'action_plan', $this->action_plan]) 
            ->andFilterWhere(['like', 'verifikasi', $this->verifikasi]) 
            ->andFilterWhere(['like', 'auditor', $this->auditor]) 
            ->andFilterWhere(['like', 'status_tindakan', $this->status_tindakan]) 
            ->andFilterWhere(['like', 'attachment', $this->attachment]);


        return $dataProvider;
    }
}
