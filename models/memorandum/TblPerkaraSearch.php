<?php

namespace app\models\memorandum;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\memorandum\TblPerkara;

/**
 * TblPerkaraSearch represents the model behind the search form of `app\models\memorandum\TblPerkara`.
 */
class TblPerkaraSearch extends TblPerkara
{
    
     public $carian_tahun;
     public $carian_bil;
     public $carian_perkara;
     public $carian_status;
       public $carian_tarikh_rekod;
       public $carian_jafpib;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_rekod'], 'integer'],
            [['perkara', 'updated', 'updated_by'], 'safe'],
            [['carian_tahun', 'carian_bil', 'carian_perkara', 'carian_status' , 'carian_tarikh_rekod','carian_jafpib'], 'safe'],
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
        $query = TblPerkara::find()->joinWith('tblRekod');
   
       
            $query->andFilterWhere([
            'memo_tbl_rekod.status' => $this->carian_status,
            'memo_tbl_rekod.perkara' => $this->carian_perkara,
            'memo_tbl_rekod.bil_jpu' => $this->carian_bil,
            'memo_tbl_rekod.tahun' => $this->carian_tahun,
            'memo_tbl_rekod.tarikh_rekod' => $this->carian_tarikh_rekod,
            'memo_tbl_perkara.dept_id' => $this->carian_jafpib,
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
            'memo_tbl_rekod.status' => $this->carian_status,
            'memo_tbl_rekod.perkara' => $this->carian_perkara,
            'memo_tbl_rekod.bil_jpu' => $this->carian_bil,
            'memo_tbl_rekod.tahun' => $this->carian_tahun,
            'memo_tbl_rekod.tarikh_rekod' => $this->carian_tarikh_rekod,
            'memo_tbl_perkara.dept_id' => $this->carian_jafpib,
        ]);

  
        return $dataProvider;
    }
//    public function search($params)
//    {
//        $query = TblPerkara::find();
//
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
//            'dept_id' => $this->dept_id,
//            'updated' => $this->updated,
//        ]);
//
//        $query->andFilterWhere(['like', 'perkara', $this->perkara])
//            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);
//
//        return $dataProvider;
//    }
}
