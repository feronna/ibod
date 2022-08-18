<?php

namespace app\models\aduan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\aduan\RptTblSiasatan;

/**
 * RptTblSiasatanSearch represents the model behind the search form of `app\models\aduan\RptTblSiasatan`.
 */
class RptTblSiasatanSearch extends RptTblSiasatan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aduan_id'], 'integer'],
            [['penyiasat_icno', 'penetap_icno', 'date'], 'safe'],
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
        $query = RptTblSiasatan::find();

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
            'aduan_id' => $this->aduan_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'penyiasat_icno', $this->penyiasat_icno])
            ->andFilterWhere(['like', 'penetap_icno', $this->penetap_icno]);

        return $dataProvider;
    }
}
