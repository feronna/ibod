<?php

namespace app\models\ejobs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ejobs\Kelayakan;

/**
 * KelayakanSearch represents the model behind the search form of `app\models\ejobs\Kelayakan`.
 */
class KelayakanSearch extends Kelayakan
{
     
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jawatan_id'], 'integer'],
            [['akademik_desc', 'syarat_tamb_desc'], 'safe'],
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
        $query = Kelayakan::find();

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
            'jawatan_id' => $this->iklan_id,
        ]);

        $query->andFilterWhere(['like', 'akademik_desc', $this->akademik_desc])
            ->andFilterWhere(['like', 'syarat_tamb_desc', $this->syarat_tamb_desc]);

        return $dataProvider;
    }
}
