<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\VCpdSenaraiLatihan;

/**
 * VCpdSenaraiLatihanSearch represents the model behind the search form of `app\models\myidp\VCpdSenaraiLatihan`.
 */
class VCpdSenaraiLatihanSearch extends VCpdSenaraiLatihan
{
    /**
     * {@inheritdoc}
     */

    public $tajukLatihan;
    public $bulan;
    public $tahun2;
   
    public function rules()
    {
        return [
            [['vcsl_kod_latihan', 'vcsl_siri_latihan', 'vcsl_kod_kompetensi', 'vcsl_kod_kategori', 'status_mycpd', 'status_latihan', 'akademik', 'penjawatan', 'jumlah_peserta', 'logType', 'unit', 'kategori', 'kluster', 'kursus_id', 'siri_kursus', 'campus_id', 'isAktif', 'jum_hadir', 'kod_latihan_asal', 'susun', 'id_cpd', 'id_siri_idp', 'id_kursus_idp', 'isActive', 'penilaian_latihan', 'tahun'], 'integer'],
            [['vcsl_nama_latihan', 'vcsl_kod_jenis', 'vcsl_status_laporan', 'vcsl_kod_siri_latihan', 'vcsl_tempat', 'vcsl_kod_peringkat', 'vcsl_nama_peringkat', 'vcsl_tkh_mula', 'vcsl_tkh_tamat', 'vcsl_tkh_tangguh_mula', 'vcsl_tkh_tangguh_tamat', 'vcsl_kod_anjuran', 'vcsl_nama_anjuran', 'vcsl_nama_kompetensi', 'vcsl_deskripsi_latihan', 'vcsl_kod_sasaran', 'dihantar_oleh', 'dihantar_pada', 'show_takwim', 'komen', 'vcsl_tkh_baru', 'rekod_cpd', 'tkh_terima_permohonan', 'insert_date'], 'safe'],
            [['vcsl_mata', 'vcsl_jum_jam'], 'number'],
            [['tajukLatihan', 'bulan', 'tahun2'], 'safe'],
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
        $query = VCpdSenaraiLatihan::find();

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
            'vcsl_kod_latihan' => $this->vcsl_kod_latihan,
            'vcsl_siri_latihan' => $this->vcsl_siri_latihan,
            'vcsl_tkh_mula' => $this->vcsl_tkh_mula,
            'vcsl_tkh_tamat' => $this->vcsl_tkh_tamat,
            'vcsl_tkh_tangguh_mula' => $this->vcsl_tkh_tangguh_mula,
            'vcsl_tkh_tangguh_tamat' => $this->vcsl_tkh_tangguh_tamat,
            'vcsl_kod_kompetensi' => $this->vcsl_kod_kompetensi,
            'vcsl_mata' => $this->vcsl_mata,
            'vcsl_jum_jam' => $this->vcsl_jum_jam,
            'vcsl_kod_kategori' => $this->vcsl_kod_kategori,
            'status_mycpd' => $this->status_mycpd,
            'status_latihan' => $this->status_latihan,
            'dihantar_pada' => $this->dihantar_pada,
            'akademik' => $this->akademik,
            'penjawatan' => $this->penjawatan,
            'jumlah_peserta' => $this->jumlah_peserta,
            'logType' => $this->logType,
            'unit' => $this->unit,
            'kategori' => $this->kategori,
            'kluster' => $this->kluster,
            'kursus_id' => $this->kursus_id,
            'siri_kursus' => $this->siri_kursus,
            'campus_id' => $this->campus_id,
            'vcsl_tkh_baru' => $this->vcsl_tkh_baru,
            'isAktif' => $this->isAktif,
            'jum_hadir' => $this->jum_hadir,
            'kod_latihan_asal' => $this->kod_latihan_asal,
            'susun' => $this->susun,
            'id_cpd' => $this->id_cpd,
            'id_siri_idp' => $this->id_siri_idp,
            'id_kursus_idp' => $this->id_kursus_idp,
            'isActive' => $this->isActive,
            'tkh_terima_permohonan' => $this->tkh_terima_permohonan,
            'penilaian_latihan' => $this->penilaian_latihan,
            'tahun' => $this->tahun,
            'insert_date' => $this->insert_date,
            'MONTH(vcsl_tkh_mula)' => $this->bulan,
            'YEAR(vcsl_tkh_mula)' => $this->tahun2,
        ]);

        $query->andFilterWhere(['like', 'vcsl_nama_latihan', $this->vcsl_nama_latihan])
            ->andFilterWhere(['like', 'vcsl_kod_jenis', $this->vcsl_kod_jenis])
            ->andFilterWhere(['like', 'vcsl_status_laporan', $this->vcsl_status_laporan])
            ->andFilterWhere(['like', 'vcsl_kod_siri_latihan', $this->vcsl_kod_siri_latihan])
            ->andFilterWhere(['like', 'vcsl_tempat', $this->vcsl_tempat])
            ->andFilterWhere(['like', 'vcsl_kod_peringkat', $this->vcsl_kod_peringkat])
            ->andFilterWhere(['like', 'vcsl_nama_peringkat', $this->vcsl_nama_peringkat])
            ->andFilterWhere(['like', 'vcsl_kod_anjuran', $this->vcsl_kod_anjuran])
            ->andFilterWhere(['like', 'vcsl_nama_anjuran', $this->vcsl_nama_anjuran])
            ->andFilterWhere(['like', 'vcsl_nama_kompetensi', $this->vcsl_nama_kompetensi])
            ->andFilterWhere(['like', 'vcsl_deskripsi_latihan', $this->vcsl_deskripsi_latihan])
            ->andFilterWhere(['like', 'vcsl_kod_sasaran', $this->vcsl_kod_sasaran])
            ->andFilterWhere(['like', 'dihantar_oleh', $this->dihantar_oleh])
            ->andFilterWhere(['like', 'show_takwim', $this->show_takwim])
            ->andFilterWhere(['like', 'komen', $this->komen])
            ->andFilterWhere(['like', 'rekod_cpd', $this->rekod_cpd])
            ->andFilterWhere(['like', 'vcsl_nama_latihan', $this->tajukLatihan]);

        return $dataProvider;
    }
}
