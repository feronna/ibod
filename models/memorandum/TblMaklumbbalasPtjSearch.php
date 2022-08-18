<?php

namespace app\models\memorandum;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\memorandum\TblMaklumbalasPtj;
use app\models\memorandum\TblRekod;

/**
 * TblMaklumbbalasPtjSearch represents the model behind the search form of `app\models\memorandum\TblMaklumbalasPtj`.
 */
class TblMaklumbbalasPtjSearch extends TblMaklumbalasPtj
{
    /**
     * {@inheritdoc}
     */
    
     public $carian_tahun;
     public $carian_bil;
     public $carian_perkara;
     public $carian_status;
      
    public function rules()
    {
        return [
            [['id', 'id_rekod', 'status_kj'], 'integer'],
            [['maklumbalas_ptj', 'icno', 'dept_id', 'tarikh_maklumbalas_ptj', 'kj', 'perakuan_kj', 'tarikh_perakuan'], 'safe'],
            [['carian_tahun', 'carian_bil', 'carian_perkara', 'carian_status' ], 'safe'],
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
    
    
    public function search($params) //biodata
    {
        $this->load($params);
        $query = TblMaklumbalasPtj::find()->joinWith('tblRekod');
   
       
            $query->andFilterWhere([
            'status' => $this->carian_status,
            'perkara' => $this->carian_perkara,
            'bil_jpu' => $this->carian_bil,
            'tahun' => $this->carian_tahun,
            ]);
        
      

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere([
            'status' => $this->carian_status,
            'perkara' => $this->carian_perkara,
            'bil_jpu' => $this->carian_bil,
            'tahun' => $this->carian_tahun,
      
        ]);

  
        return $dataProvider;
    }
    
    
//    public function search($params)
//    {
//        $query = TblMaklumbalasPtj::find()->joinWith('tblRekod');
//   //     $tblRekod = TblRekod::find()->where(['id' => $this->id_rekod]);
//        // add conditions that should always apply here
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
//
//        $this->load($params);
//
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }
//
//        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'id_rekod' => $this->id_rekod,
//            'tarikh_maklumbalas_ptj' => $this->tarikh_maklumbalas_ptj,
//            'status_kj' => $this->status_kj,
//            'tarikh_perakuan' => $this->tarikh_perakuan,
//        ]);
//
//        $query->andFilterWhere(['like', 'maklumbalas_ptj', $this->maklumbalas_ptj])
//            ->andFilterWhere(['like', 'icno', $this->icno])
//            ->andFilterWhere(['like', 'dept_id', $this->dept_id])
//            ->andFilterWhere(['like', 'kj', $this->kj])
//            ->andFilterWhere(['like', 'perakuan_kj', $this->perakuan_kj])
//            ->andFilterWhere(['like',  'id_rekod', $this->carian_rekod]);
//
//        return $dataProvider;
//    }
    
       public function getTblRekod() {
        return $this->hasOne(TblRekod::className(), ['id' => 'id_rekod']);
    }
}
