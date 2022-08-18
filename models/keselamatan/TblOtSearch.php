<?php

namespace app\models\keselamatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\keselamatan\TblOt;

/**
 * TblOtSearch represents the model behind the search form of `app\models\keselamatan\TblOt`.
 */
class TblOtSearch extends TblOt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'shift_id'], 'integer'],
            [['icno', 'tarikh', 'year', 'month'], 'safe'],
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
        $query = TblOt::find();

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
            'year' => $this->year,
            'shift_id' => $this->shift_id,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'month', $this->month]);

        return $dataProvider;
    }
}
