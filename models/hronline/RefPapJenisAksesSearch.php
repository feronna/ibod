<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\RefPapJenisAkses;


class RefPapJenisAksesSearch extends RefPapJenisAkses
{
    public function rules()
    {
        return [
            [['id', 'nama_akses','pentadbir'], 'safe'],
        ];
    }

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
        $query = RefPapJenisAkses::find();

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
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        // grid filtering conditions
        $query->andFilterWhere(['like', 'pentadbir', $this->pentadbir])
            ->andFilterWhere(['like', 'nama_akses', $this->nama_akses]);

        return $dataProvider;
    }
}
