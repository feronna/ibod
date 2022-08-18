<?php

namespace app\models\mohonjawatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mohonjawatan\TblMohontest;

/**
 * TblMohontestSearch represents the model behind the search form of `app\models\mohonjawatan\TblMohontest`.
 */
class TblMohontestSearch extends TblMohontest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bilangan'], 'integer'],
            [['tujuan', 'jwtdipohon', 'justifikasi'], 'safe'],
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
        $query = TblMohontest::find();

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
            'bilangan' => $this->bilangan,
        ]);

        $query->andFilterWhere(['like', 'tujuan', $this->tujuan])
            ->andFilterWhere(['like', 'jwtdipohon', $this->jwtdipohon])
            ->andFilterWhere(['like', 'justifikasi', $this->justifikasi]);

        return $dataProvider;
    }
}
