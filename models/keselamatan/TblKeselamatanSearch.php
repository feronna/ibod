<?php

namespace app\models\keselamatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\keselamatan\TblStaffKeselamatan;

/**
 * TblKeselamatanSearch represents the model behind the search form of `app\models\keselamatan\TblStaffKeselamatan`.
 */
class TblKeselamatanSearch extends TblStaffKeselamatan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['staff_icno', 'pos_kawalan', 'unit', 'ketua_pos', 'penolong_ketua_pos'], 'safe'],
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
        $query = TblStaffKeselamatan::find();

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
        ]);

        $query->andFilterWhere(['like', 'staff_icno', $this->staff_icno])
            ->andFilterWhere(['like', 'pos_kawalan', $this->pos_kawalan])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'ketua_pos', $this->ketua_pos])
            ->andFilterWhere(['like', 'penolong_ketua_pos', $this->penolong_ketua_pos]);

        return $dataProvider;
    }
}
