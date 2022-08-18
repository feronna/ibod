<?php

namespace app\models\keselamatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\keselamatan\TblRollcall;

/**
 * TblRollcallSearch represents the model behind the search form of `app\models\keselamatan\TblRollcall`.
 */
class TblRollcallSearch extends TblRollcall
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'syif', 'HH', 'THH', 'HLMJ', 'HLMT', 'HKWLN', 'THB', 'THBH', 'THBLMJ', 'THBLMT', 'THBKWLN', 'THTC', 'THLMJ', 'THLMT', 'THKWLN'], 'integer'],
            [['anggota_icno', 'month', 'date', 'year', 'do_icno', 'catatan'], 'safe'],
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
        $query = TblRollcall::find();

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
            'date' => $this->date,
            'year' => $this->year,
            'syif' => $this->syif,
            'HH' => $this->HH,
            'THH' => $this->THH,
            'HLMJ' => $this->HLMJ,
            'HLMT' => $this->HLMT,
            'HKWLN' => $this->HKWLN,
            'THB' => $this->THB,
            'THBH' => $this->THBH,
            'THBLMJ' => $this->THBLMJ,
            'THBLMT' => $this->THBLMT,
            'THBKWLN' => $this->THBKWLN,
            'THTC' => $this->THTC,
            'THLMJ' => $this->THLMJ,
            'THLMT' => $this->THLMT,
            'THKWLN' => $this->THKWLN,
        ]);

        $query->andFilterWhere(['like', 'anggota_icno', $this->anggota_icno])
            ->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'do_icno', $this->do_icno])
            ->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}
