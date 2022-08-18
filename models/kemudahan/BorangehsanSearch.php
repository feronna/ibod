<?php

namespace app\models\kemudahan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\kemudahan\Borangehsan;

/**
 * BorangehsanSearch represents the model behind the search form of `app\models\kemudahan\Borangehsan`.
 */
class BorangehsanSearch extends Borangehsan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'isActive2', 'status_semasa'], 'integer'],
            [['icno', 'pohon', 'tujuan', 'resit','used_dt','entry_date', 'status_pt', 'catatan_pt', 'semakan_pt', 'status_pp', 'catatan_pp', 'ver_date', 'tarikh_hantar','status_kj', 'catatan_kj', 'app_date', 'stat_bendahari', 'catatan_bendahari','bendahari_date', 'pengakuan', 'jumlah'], 'safe'],
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
        $query = Borangehsan::find();

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
            'jeniskemudahan' => $this->jeniskemudahan,
            'used_dt' => $this->used_dt,
            'entry_date' => $this->entry_date,
            'semakan_pt' => $this->semakan_pt,
            'ver_date' => $this->ver_date,
            'app_date' => $this->app_date,
            'bendahari_date' => $this->bendahari_date,
            'tarikh_hantar' => $this->tarikh_hantar,
            'isActive2' => $this->isActive2,
            'status_semasa' => $this->status_semasa,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'pohon', $this->pohon])
            ->andFilterWhere(['like', 'tujuan', $this->tujuan])
            ->andFilterWhere(['like', 'resit', $this->resit])      
            ->andFilterWhere(['like', 'status_pt', $this->status_pt])
            ->andFilterWhere(['like', 'catatan_pt', $this->catatan_pt])
            ->andFilterWhere(['like', 'status_pp', $this->status_pp])
            ->andFilterWhere(['like', 'catatan_pp', $this->catatan_pp])
            ->andFilterWhere(['like', 'status_kj', $this->status_kj])
            ->andFilterWhere(['like', 'catatan_kj', $this->catatan_kj])
            ->andFilterWhere(['like', 'jumlah', $this->jumlah])
            ->andFilterWhere(['like', 'pengakuan', $this->pengakuan]);

        return $dataProvider;
    }
}
