<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\kehadiran\TblRekod;

/**
 * TblrekodSearch represents the model behind the search form of `app\models\kehadiran\TblRekod`.
 */
class TblrekodSearch extends TblRekod
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'reason_id', 'wp_id'], 'integer'],
            [['icno', 'day', 'tarikh', 'time_in', 'time_out', 'status_in', 'status_out', 'incomplete', 'absent', 'external', 'app_by', 'app_dt', 'remark_status', 'in_lat_lng', 'out_lat_lng', 'in_ip', 'out_ip', 'remark', 'app_remark'], 'safe'],
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
        $query = TblRekod::find();

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
            'tarikh' => $this->tarikh,
            'time_in' => $this->time_in,
            'time_out' => $this->time_out,
            'reason_id' => $this->reason_id,
            'app_dt' => $this->app_dt,
            'wp_id' => $this->wp_id,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'day', $this->day])
            ->andFilterWhere(['like', 'status_in', $this->status_in])
            ->andFilterWhere(['like', 'status_out', $this->status_out])
            ->andFilterWhere(['like', 'incomplete', $this->incomplete])
            ->andFilterWhere(['like', 'absent', $this->absent])
            ->andFilterWhere(['like', 'external', $this->external])
            ->andFilterWhere(['like', 'app_by', $this->app_by])
            ->andFilterWhere(['like', 'remark_status', $this->remark_status])
            ->andFilterWhere(['like', 'in_lat_lng', $this->in_lat_lng])
            ->andFilterWhere(['like', 'out_lat_lng', $this->out_lat_lng])
            ->andFilterWhere(['like', 'in_ip', $this->in_ip])
            ->andFilterWhere(['like', 'out_ip', $this->out_ip])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'app_remark', $this->app_remark]);

        return $dataProvider;
    }
}
