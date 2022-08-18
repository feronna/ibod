<?php

namespace app\models\ln;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ln\Ln2;

/**
 * Ln2Search represents the model behind the search form of `app\models\ln\Ln2`.
 */
class Ln2Search extends Ln2
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['lulus_date', 'date_from', 'jfpib', 'ICNO', 'nama', 'tujuan_lawatan', 'tempat', 'pembiayaan', 'kod_peruntukan'], 'safe'],
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
        $query = Ln2::find();

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
            'lulus_date' => $this->lulus_date,
            'date_from' => $this->date_from,
        ]);

        $query->andFilterWhere(['like', 'jfpib', $this->jfpib])
            ->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'tujuan_lawatan', $this->tujuan_lawatan])
            ->andFilterWhere(['like', 'tempat', $this->tempat])
            ->andFilterWhere(['like', 'pembiayaan', $this->pembiayaan])
            ->andFilterWhere(['like', 'kod_peruntukan', $this->kod_peruntukan]);

        return $dataProvider;
    }
}
