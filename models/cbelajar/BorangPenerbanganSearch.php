<?php

namespace app\models\cbelajar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\BorangPenerbangan;

/**
 * BorangPenerbanganSearch represents the model behind the search form of `app\models\cbelajar\BorangPenerbangan`.
 */
class BorangPenerbanganSearch extends BorangPenerbangan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'surat', 'jenisBorang'], 'integer'],
            [['icno', 'idBorang', 'tarikh_mohon', 'status_borang', 'terima', 'status_bsm', 'ver_by', 'ver_date', 'catatan', 'app_by', 'app_date'], 'safe'],
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
        $query = BorangPenerbangan::find();

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
            'tarikh_mohon' => $this->tarikh_mohon,
            'ver_date' => $this->ver_date,
            'surat' => $this->surat,
            'app_date' => $this->app_date,
            'jenisBorang' => $this->jenisBorang,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'idBorang', $this->idBorang])
            ->andFilterWhere(['like', 'status_borang', $this->status_borang])
            ->andFilterWhere(['like', 'terima', $this->terima])
            ->andFilterWhere(['like', 'status_bsm', $this->status_bsm])
            ->andFilterWhere(['like', 'ver_by', $this->ver_by])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'app_by', $this->app_by]);

        return $dataProvider;
    }
}
