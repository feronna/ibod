<?php

namespace app\models\keselamatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\keselamatan\TblLmtKeselamatan;

/**
 * TblLmtKeselamatanSearch represents the model behind the search form of `app\models\keselamatan\TblLmtKeselamatan`.
 */
class TblLmtKeselamatanSearch extends TblLmtKeselamatan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'unit_id', 'ketua_pos', 'penolong_ketua_pos'], 'integer'],
            [['staff_icno', 'pos_kawalan', 'month', 'year', 'added_by', 'created_at', 'kampus'], 'safe'],
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
        $query = TblLmtKeselamatan::find();

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
            'unit_id' => $this->unit_id,
            'ketua_pos' => $this->ketua_pos,
            'penolong_ketua_pos' => $this->penolong_ketua_pos,
            'year' => $this->year,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'staff_icno', $this->staff_icno])
            ->andFilterWhere(['like', 'pos_kawalan', $this->pos_kawalan])
            ->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'added_by', $this->added_by])
            ->andFilterWhere(['like', 'kampus', $this->kampus]);

        return $dataProvider;
    }
}
