<?php

namespace app\models\cuti;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cuti\AksesPengguna;

/**
 * AksesPenggunaSearch represents the model behind the search form of `app\models\cuti\AksesPengguna`.
 */
class AksesPenggunaSearch extends AksesPengguna
{
    public $carian_nama;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akses_cuti_id', 'akses_cuti_int', 'akses_jspiu_id', 'akses_kampus_id'], 'integer'],
            [['carian_nama'], 'safe'],
            [['akses_cuti_icno'], 'safe'],
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
        $query = AksesPengguna::find();
        $query->joinWith(['slverifier']);

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
        // var_dump($this->akses_cuti_int,$this->akses_cuti_icno);die;
        $query->andFilterWhere([
            // 'akses_cuti_id' => $this->akses_cuti_id,
            'akses_cuti_int' => $this->akses_cuti_int,
            'akses_jspiu_id' => $this->akses_jspiu_id,
            'akses_kampus_id' => $this->akses_kampus_id,
        ]);
        
        
        if (!empty($this->akses_cuti_icno)) {
            $query->andFilterWhere([
                'LIKE','akses_cuti_icno',$this->akses_cuti_icno,
            ]);
        }
        if (!empty($this->carian_nama)) {
            $query->andFilterWhere([
                'LIKE','tblprcobiodata.CONm',$this->carian_nama,
            ]);
        }
        return $dataProvider;
    }
}
