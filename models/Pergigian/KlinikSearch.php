<?php

namespace app\models\Pergigian;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pergigian\Klinik;

/**
 * KlinikSearch represents the model behind the search form of `app\models\Pergigian\Klinik`.
 */
class KlinikSearch extends Klinik
{
    /**
     * {@inheritdoc}
     */
    
    
    
    public function rules()
    {
        return [
            [['klinik_gigi_id'], 'integer'],
            [['klinik_nama', 'klinik_alamat', 'klinik_no_tel'], 'safe'],
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
        $query = Klinik::find();

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
            'klinik_gigi_id' => $this->klinik_gigi_id,
        ]);

        $query->andFilterWhere(['like', 'klinik_nama', $this->klinik_nama])
            ->andFilterWhere(['like', 'klinik_alamat', $this->klinik_alamat])
            ->andFilterWhere(['like', 'klinik_no_tel', $this->klinik_no_tel]);

        return $dataProvider;
    }
}
