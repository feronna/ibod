<?php

namespace app\models\pengesahan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pengesahan\pengesahan;

/**
 * PengesahanSearch represents the model behind the search form of `app\models\pengesahan\pengesahan`.
 */
class PengesahanSearch extends pengesahan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['icno', 'ConfirmStatusCd','tarikh_mohon_balik', 'tarikh_mohon_balik2', 'tarikh_m', 'ver_by', 'app_by', 'status_jfpiu', 'status_bsm', 'ulasan_jfpiu', 'ulasan_pp', 'ver_date', 'app_date', 'status', 'tempoh_l_bsm', 'tempoh_l_pp', 'tempoh_l_jfpiu','pelanjutan', 'implikasi'], 'safe'],
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
        //$query = pengesahan::find()->where(['letter_sent' =>  '0']);  //untuk kasi hilang permohonan yg sudah diluluskan/ditolak dalam senarai
         $query = pengesahan::find();

        // add conditions that should always apply here

//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'pagination' => [ 'pageSize' => 30 ],
//        ]);

         $dataProvider = new ActiveDataProvider([

            'query' => Pengesahan::find()->where(['job_category' => '1', '2'])->joinWith('kakitangan'),
              'sort'=> ['defaultOrder' => ['kakitangan.CONm' => SORT_ASC]],

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
         
     $query->joinWith('confirmation');
     $dataProvider->sort->attributes['kakitangan.CONm'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['tblprcobiodata.CONm' => SORT_ASC],
        'desc' => ['tblprcobiodata.CONm' => SORT_DESC],
    ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
//            'tarikh_m' => $this->tarikh_m,
//            'ver_date' => $this->ver_date,
//            'app_date' => $this->app_date,
        
        ]);

        $query
           ->andFilterWhere(['like', 'tarikh_mohon_balik', $this->tarikh_mohon_balik])
            ->andFilterWhere(['like', 'tarikh_mohon_balik2', $this->tarikh_mohon_balik2])
            ->andFilterWhere(['like', 'ver_by', $this->ver_by])
            ->andFilterWhere(['like', 'app_by', $this->app_by])
            ->andFilterWhere(['like', 'status_pp', $this->status_pp])
            ->andFilterWhere(['like', 'status_jfpiu', $this->status_jfpiu])
            ->andFilterWhere(['like', 'status_bsm', $this->status_bsm])
            ->andFilterWhere(['like', 'Tblrscoconfirmstatus.ConfirmStatusCd', $this->icno]) 
            ->andFilterWhere(['like', 'ulasan_pp', $this->ulasan_pp])
            ->andFilterWhere(['like', 'ulasan_jfpiu', $this->ulasan_jfpiu])           
            ->andFilterWhere(['like', 'tempoh_l_pp', $this->tempoh_l_pp])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'tempoh_l_bsm', $this->tempoh_l_bsm])
            ->andFilterWhere(['like', 'tempoh_l_jfpiu', $this->tempoh_l_jfpiu])
            ->andFilterWhere(['like', 'pelanjutan', $this->pelanjutan])
            ->andFilterWhere(['like', 'implikasi', $this->implikasi]);
           if($this->status_bsm != null)
        {   
            // $query->andFilterWhere( "status IN (".implode(',',$this->status).")" );
            $query->andFilterWhere(['in', 'status_bsm', $this->status_bsm]);
        }
        return $dataProvider;
    }
}
