<?php

namespace app\models\Kemudahan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kemudahan\Borang;

/**
 * MohonkemudahanSearch represents the model behind the search form of `app\models\Tblbuka\Mohonkemudahan`.
 */
class BorangSearch extends Borang
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'days', 'mohon'], 'integer'],
            [['icno', 'butiran', 'tujuan', 'nama_tempat', 'negara', 'date_from', 'date_to', 'entry_date', 'status', 'catatan', 'status_pp', 'catatan_pp', 'status_kj', 'stat_bendahari', 'status_semasa', 'catatan_bendahari', 'catatan_kj', 'implikasi', 'jumlah'], 'safe'],
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
        $query = Borang::find();

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
            'days' => $this->days,
            'entry_date' => $this->entry_date,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'butiran', $this->butiran])
            ->andFilterWhere(['like', 'tujuan', $this->tujuan])
            ->andFilterWhere(['like', 'nama_tempat', $this->nama_tempat])
            ->andFilterWhere(['like', 'negara', $this->negara])
            ->andFilterWhere(['like', 'date_from', $this->date_from])
            ->andFilterWhere(['like', 'date_to', $this->date_to])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'status_pp', $this->status_pp])
            ->andFilterWhere(['like', 'status_semasa', $this->status_semasa])    
            ->andFilterWhere(['like', 'catatan_pp', $this->catatan_pp])
            ->andFilterWhere(['like', 'catatan_pp', $this->catatan_bendahari])
            ->andFilterWhere(['like', 'status_kj', $this->status_kj])
            ->andFilterWhere(['like', 'stat_bendahari', $this->stat_bendahari])                
            ->andFilterWhere(['like', 'catatan_kj', $this->catatan_kj])
            ->andFilterWhere(['like', 'implikasi', $this->implikasi])
            ->andFilterWhere(['like', 'jumlah', $this->jumlah])
            ->andFilterWhere(['like', 'mohon', $this->mohon]);

        return $dataProvider;
    }
}
