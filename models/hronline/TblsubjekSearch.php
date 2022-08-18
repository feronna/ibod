<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblsubjek;

/**
 * TblsubjekSearch represents the model behind the search form of `app\models\hronline\Tblsubjek`.
 */
class TblsubjekSearch extends Tblsubjek
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'EduAch_id', 'Subject_id', 'grade_id'], 'integer'],
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
        $query = Tblsubjek::find();

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
            'EduAch_id' => $this->EduAch_id,
            'Subject_id' => $this->Subject_id,
            'grade_id' => $this->grade_id,
        ]);

        return $dataProvider;
    }
}
