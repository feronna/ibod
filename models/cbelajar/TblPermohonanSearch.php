<?php

namespace app\models\cbelajar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\TblPermohonan;

/**
 * TblPermohonanSearch represents the model behind the search form of `app\models\cbelajar\TblPermohonan`.
 */
class TblPermohonanSearch extends TblPermohonan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'iklan_id', 'jenis_user_id', 'dustBstatus', 'kategori_id'], 'integer'],
            [['icno', 'tarikh_m', 'app_by', 'ver_by', 'app_date', 'ver_date', 'lulus_date', 'status_jfpiu', 'status_bsm', 'status', 'job_category', 'status_proses'], 'safe'],
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
        $query = TblPermohonan::find();

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
            'iklan_id' => $this->iklan_id,
            'jenis_user_id' => $this->jenis_user_id,
            'tarikh_m' => $this->tarikh_m,
            'dustBstatus' => $this->dustBstatus,
            'app_date' => $this->app_date,
            'ver_date' => $this->ver_date,
            'lulus_date' => $this->lulus_date,
            'kategori_id' => $this->kategori_id,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'app_by', $this->app_by])
            ->andFilterWhere(['like', 'ver_by', $this->ver_by])
            ->andFilterWhere(['like', 'status_jfpiu', $this->status_jfpiu])
            ->andFilterWhere(['like', 'status_bsm', $this->status_bsm])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'job_category', $this->job_category]);

        return $dataProvider;
    }
}
