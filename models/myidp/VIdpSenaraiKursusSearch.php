<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\VIdpSenaraiKursus;

/**
 * VIdpSenaraiKursusSearch represents the model behind the search form of `app\models\myidp\VIdpSenaraiKursus`.
 */
class VIdpSenaraiKursusSearch extends VIdpSenaraiKursus
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kursus_id', 'tahun_ditawarkan', 'kategori_latihan', 'tahap', 'kumpulan', 'kluster_id', 'job_category', 'campus_id', 'mata_idp', 'jenis_penceramah', 'jumlah_hari'], 'integer'],
            [['tajuk_kursus', 'pemilik_modul', 'skim', 'gugusan', 'nama_penceramah', 'sinopsis_kursus', 'hasil_pembelajaran', 'kandungan_kursus', 'kaedah_pelaksannan', 'rujukan', 'kod'], 'safe'],
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
        //get current year
        $currentYear = date('Y');
        
        //$query = VIdpSenaraiKursus::find();
        $query = VIdpSenaraiKursus::find()->where(["tahun_ditawarkan" => $currentYear]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pageSize' => 30,],
        ]);
        
//        // load the seach form data and validate
//        if (!($this->load($params) && $this->validate())) {
//            return $dataProvider;
//        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'kursus_id' => $this->kursus_id,
            'tahun_ditawarkan' => $this->tahun_ditawarkan,
            'kategori_latihan' => $this->kategori_latihan,
            'tahap' => $this->tahap,
            'kumpulan' => $this->kumpulan,
            'kluster_id' => $this->kluster_id,
            'job_category' => $this->job_category,
            'campus_id' => $this->campus_id,
            'mata_idp' => $this->mata_idp,
            'jenis_penceramah' => $this->jenis_penceramah,
            'jumlah_hari' => $this->jumlah_hari,
        ]);

        $query->andFilterWhere(['like', 'tajuk_kursus', $this->tajuk_kursus])
            ->andFilterWhere(['like', 'pemilik_modul', $this->pemilik_modul])
            ->andFilterWhere(['like', 'skim', $this->skim])
            ->andFilterWhere(['like', 'gugusan', $this->gugusan])
            ->andFilterWhere(['like', 'nama_penceramah', $this->nama_penceramah])
            ->andFilterWhere(['like', 'sinopsis_kursus', $this->sinopsis_kursus])
            ->andFilterWhere(['like', 'hasil_pembelajaran', $this->hasil_pembelajaran])
            ->andFilterWhere(['like', 'kandungan_kursus', $this->kandungan_kursus])
            ->andFilterWhere(['like', 'kaedah_pelaksannan', $this->kaedah_pelaksannan])
            ->andFilterWhere(['like', 'rujukan', $this->rujukan])
            ->andFilterWhere(['like', 'kod', $this->kod]);

        return $dataProvider;
    }
}
