<?php

namespace app\models\ejobs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ejobs\Iklan;

/**
 * IklanSearch represents the model behind the search form of `app\models\ejobs\Iklan`.
 */
class IklanSearch extends Iklan
{
     
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jawatan_id', 'kumpulan_id', 'klasifikasi_id', 'penempatan_id', 'kategori_iklan_id', 'jumlah_kekosongan', 'status'], 'integer'],
            [['tarikh_buka', 'tarikh_tutup'], 'safe'],
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
        $query = Iklan::find()->where(['status'=>1]);

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
            'jawatan_id' => $this->jawatan_id,
            'kumpulan_id' => $this->kumpulan_id,
            'klasifikasi_id' => $this->klasifikasi_id,
            'penempatan_id' => $this->penempatan_id,
            'kategori_iklan_id' => $this->kategori_iklan_id,
            'jumlah_kekosongan' => $this->jumlah_kekosongan,
            'tarikh_buka' => $this->tarikh_buka,
            'tarikh_tutup' => $this->tarikh_tutup,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
