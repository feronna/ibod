<?php

namespace app\models\harta;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\harta\TblTambahHarta;

/**
 * TblTambahHartaSearch represents the model behind the search form of `app\models\harta\TblTambahHarta`.
 */
class TblTambahHartaSearch extends TblTambahHarta
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'harta_id', 'senarai_id', 'hartas_id'], 'integer'],
            [['icno', 'hartaCd', 'pemilikan', 'maklumat', 'tarikh_pemilikan', 'nilai_diperolehi', 'cara', 'punca', 'status'], 'safe'],
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
        $query = TblTambahHarta::find();

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
            'harta_id' => $this->harta_id,
            'senarai_id' => $this->senarai_id,
            'hartas_id' => $this->hartas_id,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'hartaCd', $this->hartaCd])
            ->andFilterWhere(['like', 'pemilikan', $this->pemilikan])
            ->andFilterWhere(['like', 'maklumat', $this->maklumat])
            ->andFilterWhere(['like', 'tarikh_pemilikan', $this->tarikh_pemilikan])
            ->andFilterWhere(['like', 'nilai_diperolehi', $this->nilai_diperolehi])
            ->andFilterWhere(['like', 'cara', $this->cara])
            ->andFilterWhere(['like', 'punca', $this->punca])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
