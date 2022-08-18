<?php

namespace app\models\e_perkhidmatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\e_perkhidmatan\PapanTanda;

/**
 * PapanTandaSearch represents the model behind the search form of `app\models\e_perkhidmatan\PapanTanda`.
 */
class PapanTandaSearch extends PapanTanda
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['icno', 'tajuk', 'tarikh_mula', 'tarikh_hingga', 'tempat', 'masa', 'status', 'ver_by', 'ver_date', 'status_semakan', 'ulasan_semakan', 'app_by', 'app_date', 'status_kj', 'ulasan_kj'], 'safe'],
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
        $query = PapanTanda::find();

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
            'ver_date' => $this->ver_date,
            'app_date' => $this->app_date,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'tajuk', $this->tajuk])
            ->andFilterWhere(['like', 'tarikh_mula', $this->tarikh_mula])
            ->andFilterWhere(['like', 'tarikh_hingga', $this->tarikh_hingga])
            ->andFilterWhere(['like', 'tempat', $this->tempat])
            ->andFilterWhere(['like', 'masa', $this->masa])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'ver_by', $this->ver_by])
            ->andFilterWhere(['like', 'status_semakan', $this->status_semakan])
            ->andFilterWhere(['like', 'ulasan_semakan', $this->ulasan_semakan])
            ->andFilterWhere(['like', 'app_by', $this->app_by])
            ->andFilterWhere(['like', 'status_kj', $this->status_kj])
            ->andFilterWhere(['like', 'ulasan_kj', $this->ulasan_kj]);

        return $dataProvider;
    }
}
