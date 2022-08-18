<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\SiriLatihan;

/**
 * SiriLatihanSearch represents the model behind the search form of `app\models\myidp\SiriLatihan`.
 */
class SiriLatihanSearch extends SiriLatihan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siriLatihanID', 'kursusLatihanID', 'jumlahJamLatihan', 'jumlahMataIDP', 'kuota', 'kampusID'], 'integer'],
            [['siri', 'lokasi', 'tarikhMula', 'tarikhAkhir', 'masaMula', 'statusSiriLatihan', 'filename'], 'safe'],
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
        $query = SiriLatihan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('sasaran3');
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'siriLatihanID' => $this->siriLatihanID,
            'kursusLatihanID' => $this->kursusLatihanID,
            'tarikhMula' => $this->tarikhMula,
            'tarikhAkhir' => $this->tarikhAkhir,
            'masaMula' => $this->masaMula,
            'jumlahJamLatihan' => $this->jumlahJamLatihan,
            'jumlahMataIDP' => $this->jumlahMataIDP,
            'kuota' => $this->kuota,
            'kampusID' => $this->kampusID,
        ]);

        $query->andFilterWhere(['like', 'siri', $this->siri])
            ->andFilterWhere(['like', 'lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'statusSiriLatihan', $this->statusSiriLatihan])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'kursusLatihan.tajukLatihan', $this->kursusLatihanID]);

        return $dataProvider;
    }
}
