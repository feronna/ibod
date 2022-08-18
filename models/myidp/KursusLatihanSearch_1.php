<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\KursusLatihan;

/**
 * KursusLatihanSearch represents the model behind the search form of `app\models\myidp\KursusLatihan`.
 */
class KursusLatihanSearch_1 extends KursusLatihan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kursusLatihanID', 'klusterID'], 'integer'],
            [['tajukLatihan', 'penggubalModul', 'tahunTawaran', 'kategoriJawatanID', 'statusKursusLatihan', 'kursusImpakTinggi'], 'safe'],
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
//        $query = KursusLatihan::find()->where(['statusKursusLatihan' => 'AKTIF']);
//        //$query = KursusLatihan::find();
//        // add conditions that should always apply here
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
        
        $query = KursusLatihan::find()
                ->where(['statusKursusLatihan' => 'AKTIF'])
                ->andWhere(['unitBertanggungjawab' => 'AKADEMIK']);
        //$query = KursusLatihan::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'pagination' => [
//                'pageSize' => 5,
//            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'kursusLatihanID' => $this->kursusLatihanID,
            'klusterID' => $this->klusterID,
        ]);

        $query->andFilterWhere(['like', 'tajukLatihan', $this->tajukLatihan])
            ->andFilterWhere(['like', 'penggubalModul', $this->penggubalModul])
            ->andFilterWhere(['like', 'tahunTawaran', $this->tahunTawaran])
            ->andFilterWhere(['like', 'kategoriJawatanID', $this->kategoriJawatanID])
            ->andFilterWhere(['like', 'statusKursusLatihan', $this->statusKursusLatihan])
            ->andFilterWhere(['like', 'kursusImpakTinggi', $this->kursusImpakTinggi]);

        return $dataProvider;
    }
}
