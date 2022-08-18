<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\warrant\TblJawatan;

/**
 * WarrantSearch represents the model behind the search form of `app\models\warrant\TblJawatan`.
 */
class WarrantSearch extends TblJawatan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jumlah_waran', 'kategori', 'kumpkhidmat_id'], 'integer'],
            [['jawatan', 'gred'], 'safe'],
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
        $query = TblJawatan::find();

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
            'jumlah_waran' => $this->jumlah_waran,
            'kategori' => $this->kategori,
            'kumpkhidmat_id' => $this->kumpkhidmat_id,
        ]);

        $query->andFilterWhere(['like', 'jawatan', $this->jawatan])
            ->andFilterWhere(['like', 'gred', $this->gred]);

        return $dataProvider;
    }
}
