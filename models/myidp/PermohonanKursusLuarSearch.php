<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\PermohonanKursusLuar;

/**
 * PermohonanKursusLuarSearch represents the model behind the search form of `app\models\myidp\PermohonanKursusLuar`.
 */
class PermohonanKursusLuarSearch extends PermohonanKursusLuar
{
    /**
     * {@inheritdoc}
     */
    
    public $DeptId;
    public $CONm;
    public $bulan;
    public $tahun;
    
    public function rules()
    {
        return [
            [['permohonanID'], 'integer'],
            [['pemohonID', 'jenisPenganjur', 'namaPenganjur', 'disemakOleh', 'tarikhKelulusan', 'diluluskanOleh', 'namaProgram', 'tarikhMula', 'tarikhTamat', 'lokasi', 'aspekTugasUtama', 'failProgram1', 'failProgram2', 'failProgram3', 'statusPermohonan', 'tarikhPohon', 'tarikhDisemak', 'tarikhBatalPermohonan', 'tarikhSemakanKJ', 'tarikhSemakanUL', 'tarikhSemakanBSM', 'kjPenyemak', 'ulasanKJ', 'ulasanUL', 'ulasanBSM', 'statusKJ', 'statusUL', 'statusBSM'], 'safe'],
            [['layakYuran', 'layakTiketPenerbangan', 'jumlahYuran', 'jumlahTiketPenerbangan', 'jumlahPenginapan', 'layakPenginapan', 'syorYuran', 'syorTiketPenerbangan', 'syorPenginapan'], 'number'],
            [['DeptId', 'CONm', 'bulan', 'tahun', 'kategori_latihan', 'peringkat'], 'safe'],
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
        $query = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'permohonanID' => $this->permohonanID,
            'tarikhKelulusan' => $this->tarikhKelulusan,
            'layakYuran' => $this->layakYuran,
            'layakTiketPenerbangan' => $this->layakTiketPenerbangan,
            'tarikhMula' => $this->tarikhMula,
            'tarikhTamat' => $this->tarikhTamat,
            'jumlahYuran' => $this->jumlahYuran,
            'jumlahTiketPenerbangan' => $this->jumlahTiketPenerbangan,
            'jumlahPenginapan' => $this->jumlahPenginapan,
            'tarikhPohon' => $this->tarikhPohon,
            'tarikhDisemak' => $this->tarikhDisemak,
            'layakPenginapan' => $this->layakPenginapan,
            'syorYuran' => $this->syorYuran,
            'syorTiketPenerbangan' => $this->syorTiketPenerbangan,
            'syorPenginapan' => $this->syorPenginapan,
            'tarikhBatalPermohonan' => $this->tarikhBatalPermohonan,
            'tarikhSemakanKJ' => $this->tarikhSemakanKJ,
            'tarikhSemakanUL' => $this->tarikhSemakanUL,
            'tarikhSemakanBSM' => $this->tarikhSemakanBSM,
            'DeptId' => $this->DeptId,
            'MONTH(tarikhMula)' => $this->bulan,
            'YEAR(tarikhMula)' => $this->tahun,
            'kategori_latihan' => $this->kategori_latihan,
            'peringkat' => $this->peringkat,
        ]);

        $query->andFilterWhere(['like', 'pemohonID', $this->pemohonID])
            ->andFilterWhere(['like', 'jenisPenganjur', $this->jenisPenganjur])
                 ->andFilterWhere(['like', 'kategori_latihan', $this->kategori_latihan])
                 ->andFilterWhere(['like', 'peringkat', $this->peringkat])
            ->andFilterWhere(['like', 'namaPenganjur', $this->namaPenganjur])
            ->andFilterWhere(['like', 'disemakOleh', $this->disemakOleh])
            ->andFilterWhere(['like', 'diluluskanOleh', $this->diluluskanOleh])
            ->andFilterWhere(['like', 'namaProgram', $this->namaProgram])
            ->andFilterWhere(['like', 'lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'aspekTugasUtama', $this->aspekTugasUtama])
            ->andFilterWhere(['like', 'failProgram1', $this->failProgram1])
            ->andFilterWhere(['like', 'failProgram2', $this->failProgram2])
            ->andFilterWhere(['like', 'failProgram3', $this->failProgram3])
            ->andFilterWhere(['=', 'statusPermohonan', $this->statusPermohonan])
            ->andFilterWhere(['like', 'kjPenyemak', $this->kjPenyemak])
            ->andFilterWhere(['like', 'ulasanKJ', $this->ulasanKJ])
            ->andFilterWhere(['like', 'ulasanUL', $this->ulasanUL])
            ->andFilterWhere(['like', 'ulasanBSM', $this->ulasanBSM])
            ->andFilterWhere(['like', 'statusKJ', $this->statusKJ])
            ->andFilterWhere(['like', 'statusUL', $this->statusUL])
            ->andFilterWhere(['like', 'statusBSM', $this->statusBSM])
            ->andFilterWhere(['like', 'CONm', $this->CONm]);

        return $dataProvider;
    }
}
