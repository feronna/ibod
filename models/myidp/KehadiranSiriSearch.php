<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\KehadiranSiri;

/**
 * KehadiranSiriSearch represents the model behind the search form of `app\models\myidp\KehadiranSiri`.
 */
class KehadiranSiriSearch extends KehadiranSiri
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siriLatihanID', 'kompetensi'], 'integer'],
            [['staffID', 'tarikhMasa'], 'safe'],
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
        $query = KehadiranSiri::find();

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
            'siriLatihanID' => $this->siriLatihanID,
            'kompetensi' => $this->kompetensi,
            'tarikhMasa' => $this->tarikhMasa,
        ]);

        $query->andFilterWhere(['like', 'staffID', $this->staffID]);

        return $dataProvider;
    }
}
