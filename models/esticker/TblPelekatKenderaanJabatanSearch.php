<?php

namespace app\models\esticker;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\esticker\TblPelekatKenderaanJabatan;

/**
 * TblPelekatKenderaanJabatanSearch represents the model behind the search form of `app\models\esticker\TblPelekatKenderaanJabatan`.
 */
class TblPelekatKenderaanJabatanSearch extends TblPelekatKenderaanJabatan {

    public $nama;
    public $icno;
    public $no_pendaftaran;
    public $jenis_kenderaan;
    public $Jabatan;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'id_kenderaan', 'deleted', 'batal'], 'integer'],
            [['Jabatan', 'nama', 'icno', 'no_pendaftaran', 'jenis_kenderaan', 'status_mohon', 'mohon_date', 'apply_type', 'no_siri', 'kod_siri', 'siri', 'updater', 'app_datetime', 'catatan', 'expired_date_1', 'expired_date_2', 'wakil_ICNO', 'wakil_nama', 'wakil_masa_ambil', 'no_resit'], 'safe'],
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
        $query = TblPelekatKenderaanJabatan::find()
                ->where(['IN', 'stc_pelekat_kenderaan_jabatan.status_mohon', $status])
                ->andWhere(['stc_pelekat_kenderaan_jabatan.deleted' => 0])
                ->joinWith('kenderaan.department')
                ->joinWith('kenderaan.biodata');

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
        ]);

        $query->andFilterWhere(['like', 'stc_pelekat_kenderaan_jabatan.status_mohon', $this->status_mohon])
                ->andFilterWhere(['like', 'stc_pelekat_kenderaan_jabatan.no_siri', $this->no_siri])
                ->andFilterWhere(['like', 'stc_pelekat_kenderaan_jabatan.apply_type', '%' . $this->apply_type . '%', false])
                ->andFilterWhere(['like', 'stc_sticker_jabatan.reg_number', $this->no_pendaftaran])
                ->andFilterWhere(['like', 'stc_sticker_jabatan.v_co_icno', $this->icno])
                ->andFilterWhere(['like', 'tblprcobiodata.CONm', '%' . $this->nama . '%', false])
                ->andFilterWhere(['like', 'department.shortname', '%' . $this->Jabatan . '%', false])
                ->andFilterWhere(['like', 'stc_pelekat_kenderaan_jabatan.mohon_date', '%' . $this->mohon_date . '%', false]);

        return $dataProvider;
    }

}
