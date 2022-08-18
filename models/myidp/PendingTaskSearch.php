<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\PendingTask;

/**
 * PendingTaskSearch represents the model behind the search form of `app\models\myidp\PendingTask`.
 */
class PendingTaskSearch extends PendingTask
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id'], 'integer'],
            [['task_submenu', 'task_menu', 'assign_for'], 'safe'],
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
        $query = PendingTask::find()->where(['<>', 'task_id', '1']);

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
            'task_id' => $this->task_id,
        ]);

        $query->andFilterWhere(['like', 'task_submenu', $this->task_submenu])
            ->andFilterWhere(['like', 'task_menu', $this->task_menu])
            ->andFilterWhere(['like', 'assign_for', $this->assign_for]);

        return $dataProvider;
    }
}
