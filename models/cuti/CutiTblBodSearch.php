<?php

namespace app\Models\Cuti;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\Models\Cuti\CutiTblBod;

/**
 * CutiTblBodSearch represents the model behind the search form of `app\Models\Cuti\CutiTblBod`.
 */
class CutiTblBodSearch extends CutiTblBod
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'record_id', 'status'], 'integer'],
            [['date_bod', 'remark', 'semakan_id', 'pelulus_id', 'bsm_id'], 'safe'],
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
        $query = CutiTblBod::find();

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
            'record_id' => $this->record_id,
            'date_bod' => $this->date_bod,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'semakan_id', $this->semakan_id])
            ->andFilterWhere(['like', 'pelulus_id', $this->pelulus_id])
            ->andFilterWhere(['like', 'bsm_id', $this->bsm_id]);

        return $dataProvider;
    }
}
