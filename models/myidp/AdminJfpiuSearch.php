<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\AdminJfpiu;

/**
 * AdminJfpiuSearch represents the model behind the search form of `app\models\myidp\AdminJfpiu`.
 */
class AdminJfpiuSearch extends AdminJfpiu
{
    /**
     * {@inheritdoc}
     */
    
    public $DeptId;
    
    public function rules()
    {
        return [
            [['staffID', 'date_added', 'added_by'], 'safe'],
            [['staff_dept_on_added'], 'integer'],
            [['DeptId'], 'safe'],
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
        $query = AdminJfpiu::find()
                ->joinWith('biodata')
                ->orderBy('DeptId');
                
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
            'date_added' => $this->date_added,
            'staff_dept_on_added' => $this->staff_dept_on_added,
            'DeptId' => $this->DeptId,
        ]);

        $query->andFilterWhere(['like', 'staffID', $this->staffID])
            ->andFilterWhere(['like', 'added_by', $this->added_by]);

        return $dataProvider;
    }
}
