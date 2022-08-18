<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\kehadiran\TblWp;

/**
 * TblWpSearch represents the model behind the search form of `app\models\kehadiran\TblWp`.
 */
class TblWpSearch extends TblWp
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'wp_id'], 'integer'],
            [['icno', 'remark', 'entry_dt', 'ver_by', 'ver_dt', 'ver_remark', 'app_by', 'app_dt', 'app_remark', 'start_date', 'end_date', 'status'], 'safe'],
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
        $query = TblWp::find();

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
            'wp_id' => $this->wp_id,
            'entry_dt' => $this->entry_dt,
            'ver_dt' => $this->ver_dt,
            'app_dt' => $this->app_dt,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'ver_by', $this->ver_by])
            ->andFilterWhere(['like', 'ver_remark', $this->ver_remark])
            ->andFilterWhere(['like', 'app_by', $this->app_by])
            ->andFilterWhere(['like', 'app_remark', $this->app_remark])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
