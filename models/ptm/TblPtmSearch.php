<?php

namespace app\models\ptm;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ptm\TblPtm;

/**
 * TblPtmSearch represents the model behind the search form of `app\models\ptm\TblPtm`.
 */
class TblPtmSearch extends TblPtm
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siri_id', 'tempoh', 'bil_mesy'], 'integer'],
            [['siri', 'full_dt', 'start_dt', 'end_dt', 'tempat', 'mesy_dt', 'entry_dt', 'entry_by'], 'safe'],
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
        $query = TblPtm::find();

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
            'siri_id' => $this->siri_id,
            'tempoh' => $this->tempoh,
            'bil_mesy' => $this->bil_mesy,
            'mesy_dt' => $this->mesy_dt,
            'entry_dt' => $this->entry_dt,
        ]);

        $query->andFilterWhere(['like', 'siri', $this->siri])
            ->andFilterWhere(['like', 'full_dt', $this->full_dt])
            ->andFilterWhere(['like', 'start_dt', $this->start_dt])
            ->andFilterWhere(['like', 'end_dt', $this->end_dt])
            ->andFilterWhere(['like', 'tempat', $this->tempat])
            ->andFilterWhere(['like', 'entry_by', $this->entry_by]);

        return $dataProvider;
    }
}
