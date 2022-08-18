<?php

namespace app\models\cbelajar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\TblElaun;

/**
 * TblAllowanceSearch represents the model behind the search form of `app\models\cbelajar\TblElaun`.
 */
class TblAllowanceSearch extends TblElaun
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bID'], 'integer'],
            [['icno', 'jenis_elaun', 'bayaran', 'amaun'], 'safe'],
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
        $query = TblElaun::find();

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
            'bID' => $this->bID,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'jenis_elaun', $this->jenis_elaun])
            ->andFilterWhere(['like', 'bayaran', $this->bayaran])
            ->andFilterWhere(['like', 'amaun', $this->amaun]);

        return $dataProvider;
    }
}
