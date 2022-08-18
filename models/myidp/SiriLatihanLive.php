<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\SiriLatihan;
use yii\helpers\Html;

/**
 * SiriLatihanSearch represents the model behind the search form of `app\models\myidp\SiriLatihan`.
 */
class SiriLatihanLive extends SiriLatihan
{
    /**
     * {@inheritdoc}
     */
    
    public $tajukLatihan;
    public $bulan;
    public $tahun;
    public $jenis;
    public $unitBertanggungjawab;
    
    public function rules()
    {
        return [
            [['siriLatihanID', 'kursusLatihanID', 'jumlahJamLatihan', 'jumlahMataIDP', 'kuota'], 'integer'],
            [['siri', 'lokasi', 'tarikhMula', 'tarikhAkhir', 'masaMula', 'statusSiriLatihan', 'filename'], 'safe'],
            [['tajukLatihan', 'bulan', 'tahun', 'jenis', 'unitBertanggungjawab'], 'safe'],
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
        $query = SiriLatihan::find()
                ->joinWith('sasaran3')
                ->where(['statusSiriLatihan' => 'SEDANG BERJALAN'])
                ->orderBy(['tarikhMula' => SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>false,
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
            'kursusLatihanID' => $this->kursusLatihanID,
            'tarikhMula' => $this->tarikhMula,
            'tarikhAkhir' => $this->tarikhAkhir,
            'masaMula' => $this->masaMula,
            'jumlahJamLatihan' => $this->jumlahJamLatihan,
            'jumlahMataIDP' => $this->jumlahMataIDP,
            'kuota' => $this->kuota,
            'MONTH(tarikhMula)' => $this->bulan,
            'YEAR(tarikhMula)' => $this->tahun,
            'idp_kursusLatihan.jenisLatihanID' => $this->jenis,
            'idp_kursusLatihan.unitBertanggungjawab' => $this->unitBertanggungjawab,
        ]);

        $query->andFilterWhere(['like', 'siri', $this->siri])
            ->andFilterWhere(['like', 'lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'statusSiriLatihan', $this->statusSiriLatihan])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'tajukLatihan', $this->tajukLatihan]);

        return $dataProvider;
    }
}
