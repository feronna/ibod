<?php

namespace app\models\cuti;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cuti\Layak;

/**
 * LayakSearch represents the model behind the search form of `app\models\cuti\Layak`.
 */
class LayakSearch extends Layak
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layak_id', 'layak_cuti', 'layak_bawa_lepas', 'layak_bawa_depan', 'layak_ambil', 'layak_gcr', 'layak_hapus'], 'integer'],
            [['layak_icno', 'layak_mula', 'layak_tamat'], 'safe'],
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
        $query = Layak::find();

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
            'layak_id' => $this->layak_id,
            'layak_mula' => $this->layak_mula,
            'layak_tamat' => $this->layak_tamat,
            'layak_cuti' => $this->layak_cuti,
            'layak_bawa_lepas' => $this->layak_bawa_lepas,
            'layak_bawa_depan' => $this->layak_bawa_depan,
            'layak_ambil' => $this->layak_ambil,
            'layak_gcr' => $this->layak_gcr,
            'layak_hapus' => $this->layak_hapus,
        ]);

        $query->andFilterWhere(['like', 'layak_icno', $this->layak_icno]);

        return $dataProvider;
    }
}
