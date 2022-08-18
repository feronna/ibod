<?php

namespace app\models\esticker;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\esticker\TblPelekatKenderaan;
 
class TblPelekatKenderaanSearch extends TblPelekatKenderaan {

    public $nama;
    public $icno;
    public $no_pendaftaran;
    public $jenis_kenderaan;
 
    public function rules() {
        return [
            [['id', 'id_kenderaan'], 'integer'],
            [['nama','icno','no_pendaftaran','jenis_kenderaan', 'status_mohon', 'mohon_date', 'app_date', 'no_siri', 'apply_type', 'updater', 'expired_date','deleted'], 'safe'],
            [['total'], 'number'],
        ];
    }
 
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
 
    public function search($params, $status) { 
            $query = TblPelekatKenderaan::find()
                    ->where(['IN','stc_pelekat_kenderaan.status_mohon', $status])
                    ->andWhere(['stc_pelekat_kenderaan.deleted' => 0])
                    ->joinWith('kenderaan.biodata'); 
 

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) { 
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([  
        ]);

        $query->andFilterWhere(['like', 'stc_pelekat_kenderaan.status_mohon', $this->status_mohon])
                ->andFilterWhere(['like', 'stc_pelekat_kenderaan.no_siri', $this->no_siri])
                ->andFilterWhere(['like', 'stc_pelekat_kenderaan.apply_type', '%'.$this->apply_type.'%',false]) 
                ->andFilterWhere(['like', 'stc_sticker_staf.reg_number', $this->no_pendaftaran])
                ->andFilterWhere(['like', 'stc_sticker_staf.v_co_icno', $this->icno])
                ->andFilterWhere(['like', 'tblprcobiodata.CONm', '%'.$this->nama.'%',false]) 
                ->andFilterWhere(['like', 'stc_pelekat_kenderaan.mohon_date', '%'.$this->mohon_date.'%',false]); 
//                ->andFilterWhere(['like', 'stc_pelekat_kenderaan.updater', $this->updater]);

        return $dataProvider;
    }

}
