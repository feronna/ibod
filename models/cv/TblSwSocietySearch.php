<?php

namespace app\models\cv;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cv\TblSwSociety;

/**
 * TblSwSocietySearch represents the model behind the search form of `app\models\cv\TblSwSociety`.
 */
class TblSwSocietySearch extends TblSwSociety
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fid', 'uid', 'year', 'service', 'role', 'ICNO', 'role_key'], 'safe'],
            [['level','kategori_servis'], 'integer'],
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
        $query = TblSwSociety::find()
        ->where(['<>','ICNO', 'NULL']);

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
            'level' => $this->level,
        ]);

        $query->andFilterWhere(['like', 'fid', $this->fid])
            ->andFilterWhere(['like', 'uid', $this->uid])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'service', $this->service])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'role_key', $this->role_key])
            ->andFilterWhere(['like', 'kategori_servis', $this->kategori_servis]);

        return $dataProvider;
    }
}
