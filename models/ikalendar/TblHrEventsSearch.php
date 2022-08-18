<?php

namespace app\models\ikalendar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ikalendar\TblHrEvents;

/**
 * TblHrEventsSearch represents the model behind the search form of `app\models\ikalender\TblHrEvents`.
 */
class TblHrEventsSearch extends TblHrEvents
{
    public $bulan;
    public $tahun;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bulan', 'tahun'], 'string'],
            [['event_id', 'venue_id', 'contact_id', 'category_id', 'user_id', 'group_id', 'status_id', 'status', 'status_awal', 'Rancang', 'kpi_id', 'rasmi', 'semua_staf_terlibat', 'tmp_id'], 'integer'],
            [['title', 'venue', 'contact', 'description', 'stamp', 'quick_approve', 'tarikh_tunda', 'date_rancang'], 'safe'],
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
        $query = TblHrEvents::find();

        $query->joinWith('eventDate d', true, 'LEFT JOIN');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'sort' => ['attributes' => ['`d`.`date`']],
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
            'venue_id' => $this->venue_id,
            'contact_id' => $this->contact_id,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'group_id' => $this->group_id,
            'status_id' => $this->status_id,
            'stamp' => $this->stamp,
            'status' => $this->status,
            'status_awal' => $this->status_awal,
            'Rancang' => $this->Rancang,
            'kpi_id' => $this->kpi_id,
            'tarikh_tunda' => $this->tarikh_tunda,
            'rasmi' => $this->rasmi,
            'semua_staf_terlibat' => $this->semua_staf_terlibat,
            'tmp_id' => $this->tmp_id,
            'date_rancang' => $this->date_rancang,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'venue', $this->venue])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'quick_approve', $this->quick_approve])
            ->andFilterWhere(['MONTH(d.date)' => $this->bulan])
            ->andFilterWhere(['YEAR(d.date)' => $this->tahun]);

        return $dataProvider;
    }
}
