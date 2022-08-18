<?php

namespace app\models\e_perkhidmatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\e_perkhidmatan\TblEvent;

/**
 * TblEventSearch represents the model behind the search form of `app\models\e_perkhidmatan\TblEvent`.
 */
class TblEventSearch extends TblEvent
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'active_status', 'staff_id', 'dept_id'], 'integer'],
            [['event_name', 'location', 'date_start', 'date_end', 'time_start', 'time_end', 'entry_date', 'user_id'], 'safe'],
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
        $query = TblEvent::find();

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
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'active_status' => $this->active_status,
            'entry_date' => $this->entry_date,
            'staff_id' => $this->staff_id,
            'dept_id' => $this->dept_id,
        ]);

        $query->andFilterWhere(['like', 'event_name', $this->event_name])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'user_id', $this->user_id]);

        return $dataProvider;
    }
}
