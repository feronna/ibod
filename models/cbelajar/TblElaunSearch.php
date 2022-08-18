<?php

namespace app\models\cbelajar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\TblElaunLulus;

/**
 * TblElaunSearch represents the model behind the search form of `app\models\cbelajar\TblElaunLulus`.
 */
class TblElaunSearch extends TblElaunLulus
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bID', 'HighestEduLevelCd'], 'integer'],
            [['icno', 'dt_stajaan', 'dt_ntajaan', 't_tajaan', 'dt_slanjutb', 'dt_nlanjutb', 't_ltajaan', 'kadar', 'family', 'pasangan', 'anak', 't_bk', 't_bkt', 'tempoh_bk', 't_lbkm', 't_lbkt', 'tempoh_bkl', 'esh', 'ep', 'eb', 'eaps', 'eap', 'ebsr', 'ebk', 'epk', 'eapk', 'catatan'], 'safe'],
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
        $query = TblElaunLulus::find();

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
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'dt_stajaan', $this->dt_stajaan])
            ->andFilterWhere(['like', 'dt_ntajaan', $this->dt_ntajaan])
            ->andFilterWhere(['like', 't_tajaan', $this->t_tajaan])
            ->andFilterWhere(['like', 'dt_slanjutb', $this->dt_slanjutb])
            ->andFilterWhere(['like', 'dt_nlanjutb', $this->dt_nlanjutb])
            ->andFilterWhere(['like', 't_ltajaan', $this->t_ltajaan])
            ->andFilterWhere(['like', 'kadar', $this->kadar])
            ->andFilterWhere(['like', 'family', $this->family])
            ->andFilterWhere(['like', 'pasangan', $this->pasangan])
            ->andFilterWhere(['like', 'anak', $this->anak])
            ->andFilterWhere(['like', 't_bk', $this->t_bk])
            ->andFilterWhere(['like', 't_bkt', $this->t_bkt])
            ->andFilterWhere(['like', 'tempoh_bk', $this->tempoh_bk])
            ->andFilterWhere(['like', 't_lbkm', $this->t_lbkm])
            ->andFilterWhere(['like', 't_lbkt', $this->t_lbkt])
            ->andFilterWhere(['like', 'tempoh_bkl', $this->tempoh_bkl])
            ->andFilterWhere(['like', 'esh', $this->esh])
            ->andFilterWhere(['like', 'ep', $this->ep])
            ->andFilterWhere(['like', 'eb', $this->eb])
            ->andFilterWhere(['like', 'eaps', $this->eaps])
            ->andFilterWhere(['like', 'eap', $this->eap])
            ->andFilterWhere(['like', 'ebsr', $this->ebsr])
            ->andFilterWhere(['like', 'ebk', $this->ebk])
            ->andFilterWhere(['like', 'epk', $this->epk])
            ->andFilterWhere(['like', 'eapk', $this->eapk])
            ->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}
