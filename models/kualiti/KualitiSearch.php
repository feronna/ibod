<?php

namespace app\models\kualiti;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\kualiti\Kualiti;

/**
 * KualitiSearch represents the model behind the search form of `app\models\kualiti\Kualiti`.
 */
class KualitiSearch extends Kualiti
{
    public $nama;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['msiso_id', 'kategori_id', 'jfpib'], 'integer'],
            [['no_prosedur', 'tajuk_prosedur', 'nama_fail', 'insert_date', 'update_date', 'update_id'], 'safe'],
            [['susunan'], 'number'],
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
        $query = Kualiti::find()
                ->orderBy(['kategori_id' => SORT_ASC, 'susunan'=> SORT_ASC,'no_prosedur' => SORT_ASC, 'tajuk_prosedur' => SORT_ASC]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'msiso_id' => $this->msiso_id,
            'kategori_id' => $this->kategori_id,
            'susunan' => $this->susunan,
            'jfpib' => $this->jfpib,
            'insert_date' => $this->insert_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['like', 'no_prosedur', $this->no_prosedur])
            ->andFilterWhere(['like', 'tajuk_prosedur', $this->tajuk_prosedur])
            ->andFilterWhere(['like', 'nama_fail', $this->nama_fail])
            ->andFilterWhere(['like', 'update_id', $this->update_id])
            ->andFilterWhere(['like', 'nama',$this->nama]);

        return $dataProvider;
    }
}
