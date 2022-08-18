<?php

namespace app\models\cbelajar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\TblUrusMesyuarat;

/**
 * UrusMesyuaratSearch represents the model behind the search form of `app\models\cbelajar\TblUrusMesyuarat`.
 */
class UrusMesyuaratSearch extends TblUrusMesyuarat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['kali_ke', 'tarikh_mesyuarat', 'nama_mesyuarat', 'masa_mesyuarat', 'tempat_mesyuarat'], 'safe'],
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
        $query = TblUrusMesyuarat::find();

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
            'masa_mesyuarat' => $this->masa_mesyuarat,
        ]);

        $query->andFilterWhere(['like', 'kali_ke', $this->kali_ke])
            ->andFilterWhere(['like', 'tarikh_mesyuarat', $this->tarikh_mesyuarat])
            ->andFilterWhere(['like', 'nama_mesyuarat', $this->nama_mesyuarat])
            ->andFilterWhere(['like', 'tempat_mesyuarat', $this->tempat_mesyuarat]);

        return $dataProvider;
    }
}
