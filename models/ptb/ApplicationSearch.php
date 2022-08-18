<?php

namespace app\models\ptb;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ptb\Application;

/**
 * ApplicationSearch represents the model behind the search form of `app\models\ptb\Application`.
 */
class ApplicationSearch extends Application
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type_id','old_dept', 'new_dept', 'status', 'stat_lantikan', 'recommendation_id_action'], 'integer'],
            [['icno', 'reason', 'justifikasi', 'effective_date', 'created_at', 'kategori'], 'safe'],
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
        $query = Application::find()->with('pelulus')->where(['!=', 'letter_sent', 1]);
            
           

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
            'type_id' => $this->type_id,
           // 'service_period_yr' => $this->service_period_yr,
          //  'service_period_month' => $this->service_period_month,
            'old_dept' => $this->old_dept,
            'new_dept' => $this->new_dept,
            'status' => $this->status,
            'stat_lantikan' => $this->stat_lantikan,
            'effective_date' => $this->effective_date,
            'recommendation_id_action' => $this->recommendation_id_action,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
           // ->andFilterWhere(['like', 'bsm_notes', $this->bsm_notes])
           // ->andFilterWhere(['like', 'icno_sandangan', $this->icno_sandangan])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'justifikasi', $this->justifikasi])
            ->andFilterWhere(['like', 'kategori', $this->kategori]);
        return $dataProvider;

    }
}
