<?php

namespace app\models\esticker;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\esticker\TblPelekatKenderaanJabatan;

/**
 * LaporanPelekatJabatanSearch represents the model behind the search form of `app\models\esticker\TblPelekatKenderaanJabatan`.
 */
class LaporanPelekatJabatanSearch extends TblPelekatKenderaanJabatan
{
    public $dept_id,$bulanan,$tahun;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_kenderaan', 'deleted', 'batal'], 'integer'],
            [['dept_id','bulanan','tahun','status_mohon', 'mohon_date', 'apply_type', 'no_siri', 'kod_siri', 'siri', 'updater', 'app_datetime', 'catatan', 'expired_date_1', 'expired_date_2', 'wakil_ICNO', 'wakil_nama', 'wakil_masa_ambil', 'no_resit'], 'safe'],
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
        $query = TblPelekatKenderaanJabatan::find()->joinWith('kenderaan')->where(['status_mohon'=>'AKTIF']);
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
            'stc_sticker_jabatan.dept_id' => $this->dept_id,
            'id_kenderaan' => $this->id_kenderaan,
            'DATE(mohon_date)' => $this->mohon_date,
            'DATE_FORMAT(mohon_date, "%m-%Y")' => $this->bulanan,
            'DATE_FORMAT(mohon_date, "%Y")' => $this->tahun,
            'app_datetime' => $this->app_datetime,
            'deleted' => $this->deleted,
            'expired_date_1' => $this->expired_date_1,
            'expired_date_2' => $this->expired_date_2,
            'wakil_masa_ambil' => $this->wakil_masa_ambil,
            'batal' => $this->batal,
        ]);

        $query->andFilterWhere(['like', 'status_mohon', $this->status_mohon])
            ->andFilterWhere(['like', 'apply_type', $this->apply_type])
            ->andFilterWhere(['like', 'no_siri', $this->no_siri])
            ->andFilterWhere(['like', 'kod_siri', $this->kod_siri])
            ->andFilterWhere(['like', 'siri', $this->siri])
            ->andFilterWhere(['like', 'updater', $this->updater])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'wakil_ICNO', $this->wakil_ICNO])
            ->andFilterWhere(['like', 'wakil_nama', $this->wakil_nama])
            ->andFilterWhere(['like', 'no_resit', $this->no_resit]);

        return $dataProvider;
    }
}
