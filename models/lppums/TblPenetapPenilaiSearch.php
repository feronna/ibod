<?php

namespace app\models\lppums;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\lppums\TblPenetapPenilai;

/**
 * TblPenetapPenilaiSearch represents the model behind the search form of `app\models\lppums\TblPenetapPenilai`.
 */
class TblPenetapPenilaiSearch extends TblPenetapPenilai
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dept_id', 'penetap_jfpiu', 'penetap_gred'], 'integer'],
            [['tahun', 'penetap_icno'], 'safe'],
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
        $query = TblPenetapPenilai::find();

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
            'tahun' => $this->tahun,
            'dept_id' => $this->dept_id,
            'penetap_jfpiu' => $this->penetap_jfpiu,
            'penetap_gred' => $this->penetap_gred,
        ]);

        $query->andFilterWhere(['like', 'penetap_icno', $this->penetap_icno]);

        return $dataProvider;
    }
}
