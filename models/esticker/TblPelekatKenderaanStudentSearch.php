<?php

namespace app\models\esticker;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\esticker\TblPelekatKenderaanStudent;


/**
 * TblPelekatKenderaanSearch represents the model behind the search form of `app\models\esticker\TblPelekatKenderaan`.
 */
class TblPelekatKenderaanStudentSearch extends TblPelekatKenderaanStudent {

    public $nama;
    public $icno;
    public $no_pendaftaran;
    public $jenis_kenderaan;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'id_kenderaan'], 'integer'],
            [['nama','icno','no_pendaftaran','jenis_kenderaan', 'status_mohon', 'mohon_date', 'app_date', 'no_siri', 'apply_type', 'updater', 'expired_date','deleted'], 'safe'],
            [['total'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params, $status) { 
            $query = TblPelekatKenderaanStudent::find()
                    ->where(['IN','stc_pelekat_kenderaan_student.status_mohon', $status])
                    ->andWhere(['stc_pelekat_kenderaan_student.deleted' => 0])
                    ->joinWith('kenderaan.biodata');
//                    ->joinWith('biodata'); 

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([ 
//            'app_date' => $this->app_date,
//            'expired_date' => $this->expired_date,
//            'id_kenderaan' => $this->id_kenderaan,
//            'total' => $this->total,
//            'sticker_staf.v_co_icno', $this->icno,
        ]);

        $query->andFilterWhere(['like', 'stc_pelekat_kenderaan_student.status_mohon', $this->status_mohon])
                ->andFilterWhere(['like', 'stc_pelekat_kenderaan_student.no_siri', $this->no_siri])
                ->andFilterWhere(['like', 'stc_pelekat_kenderaan_student.apply_type', '%'.$this->apply_type.'%',false]) 
                ->andFilterWhere(['like', 'stc_sticker_student.reg_number', $this->no_pendaftaran])
                ->andFilterWhere(['like', 'stc_sticker_student.v_co_icno', $this->icno])
//                ->andFilterWhere(['like', 'stc_user.name', '%'.$this->nama.'%',false]) 
                ->andFilterWhere(['like', 'stc_pelekat_kenderaan_student.mohon_date', '%'.$this->mohon_date.'%',false]); 
//                ->andFilterWhere(['like', 'pelekat_kenderaan_student.updater', $this->updater]);

        return $dataProvider;
    }

}
