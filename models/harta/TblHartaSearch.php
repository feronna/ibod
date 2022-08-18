<?php

namespace app\models\harta;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\harta\TblHarta;

/**
 * TblHartaSearch represents the model behind the search form of `app\models\harta\TblHarta`.
 */
class TblHartaSearch extends TblHarta
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ADEdrsdRefNo', 'letter_sent', 'status_kj'], 'integer'],
            [['icno', 'AssetOwnerNm', 'jawatan', 'gred', 'jfpiu', 'jenis_permohonan', 'status', 'tarikh_dihantar', 'status_lantikan', 'tarikh_sandangan', 'tarikh_lantikan', 'ketua_jabatan', 'tarikh_perakuan', 'ulasan_kj', 'kategori'], 'safe'],
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
        $query = TblHarta::find()->where(['letter_sent' => 0, 'status' => [1,2,3,4,5]]);
 
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
            'ADEdrsdRefNo' => $this->ADEdrsdRefNo,
            'letter_sent' => $this->letter_sent,
            'status_kj' => $this->status_kj,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'AssetOwnerNm', $this->AssetOwnerNm])
            ->andFilterWhere(['like', 'jawatan', $this->jawatan])
            ->andFilterWhere(['like', 'gred', $this->gred])
            ->andFilterWhere(['like', 'jfpiu', $this->jfpiu])
            ->andFilterWhere(['like', 'jenis_permohonan', $this->jenis_permohonan])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'ADDeclDt', $this->ADDeclDt])
            ->andFilterWhere(['like', 'status_lantikan', $this->status_lantikan])
            ->andFilterWhere(['like', 'tarikh_sandangan', $this->tarikh_sandangan])
            ->andFilterWhere(['like', 'tarikh_lantikan', $this->tarikh_lantikan])
            ->andFilterWhere(['like', 'ketua_jabatan', $this->ketua_jabatan])
            ->andFilterWhere(['like', 'ADEdrsdDt', $this->ADEdrsdDt])
           ->andFilterWhere(['like', 'kategori', $this->kategori])
            ->andFilterWhere(['like', 'ulasan_kj', $this->ulasan_kj]);

        return $dataProvider;
    }
}
