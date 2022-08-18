<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.v_cpd_senarai_latihan".
 *
 * @property string $vcsl_kod_latihan
 * @property string $vcsl_nama_latihan
 * @property string $vcsl_kod_jenis
 * @property string $vcsl_status_laporan
 * @property int $vcsl_siri_latihan
 * @property string $vcsl_kod_siri_latihan
 * @property string $vcsl_tempat
 * @property string $vcsl_kod_peringkat
 * @property string $vcsl_nama_peringkat
 * @property string $vcsl_tkh_mula
 * @property string $vcsl_tkh_tamat
 * @property string $vcsl_tkh_tangguh_mula
 * @property string $vcsl_tkh_tangguh_tamat
 * @property string $vcsl_kod_anjuran
 * @property string $vcsl_nama_anjuran
 * @property int $vcsl_kod_kompetensi
 * @property string $vcsl_nama_kompetensi
 * @property double $vcsl_mata
 * @property double $vcsl_jum_jam
 * @property int $vcsl_kod_kategori
 * @property string $vcsl_deskripsi_latihan
 * @property string $vcsl_kod_sasaran
 * @property int $status_mycpd
 * @property int $status_latihan
 * @property string $dihantar_oleh
 * @property string $dihantar_pada
 * @property int $akademik 1=Akademik,0=Pentadbiran
 * @property string $show_takwim
 * @property string $komen
 * @property int $penjawatan
 * @property int $jumlah_peserta
 * @property int $logType
 * @property int $unit
 * @property int $kategori
 * @property int $kluster Refer Table 01_kluster_kursus
 * @property int $kursus_id
 * @property int $siri_kursus
 * @property int $campus_id Refer Table campus
 
 * @property string $vcsl_tkh_baru
 * @property int $isAktif
 * @property int $jum_hadir
 * @property string $kod_latihan_asal
 * @property int $susun
 * @property string $id_cpd
 * @property string $rekod_cpd
 * @property string $id_siri_idp
 * @property int $id_kursus_idp
 * @property int $isActive 0=Tidak Aktif, 1=Aktif
 * @property string $tkh_terima_permohonan Permohonan Lewat
 * @property int $penilaian_latihan 0=Tidak,1=Ya
 * @property int $tahun
 * @property string $insert_date Transfer From IDP
 */
class Vcpdsenarailatihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.v_cpd_senarai_latihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vcsl_kod_latihan','kategori_latihan','vcsl_siri_latihan', 'vcsl_kod_kompetensi', 'vcsl_kod_kategori', 'status_mycpd', 'status_latihan', 'akademik', 'penjawatan', 'jumlah_peserta', 'logType', 'unit', 'kategori', 'kluster', 'kursus_id', 'siri_kursus', 'campus_id', 'isAktif', 'jum_hadir', 'kod_latihan_asal', 'susun', 'id_cpd', 'id_siri_idp', 'id_kursus_idp', 'isActive', 'penilaian_latihan', 'tahun'], 'integer'],
            [['vcsl_tkh_mula', 'vcsl_tkh_tamat', 'vcsl_tkh_tangguh_mula', 'vcsl_tkh_tangguh_tamat', 'dihantar_pada', 'vcsl_tkh_baru', 'tkh_terima_permohonan', 'insert_date'], 'safe'],
            [['vcsl_mata', 'vcsl_jum_jam'], 'number'],
            [['vcsl_deskripsi_latihan', 'komen', 'rekod_cpd'], 'string'],
            [['vcsl_nama_latihan', 'vcsl_kod_sasaran'], 'string', 'max' => 255],
            [['vcsl_kod_jenis', 'vcsl_status_laporan', 'vcsl_kod_peringkat', 'show_takwim'], 'string', 'max' => 1],
            [['vcsl_kod_siri_latihan', 'dihantar_oleh'], 'string', 'max' => 12],
            [['vcsl_tempat'], 'string', 'max' => 100],
            [['vcsl_nama_peringkat', 'vcsl_nama_anjuran'], 'string', 'max' => 30],
            [['vcsl_kod_anjuran'], 'string', 'max' => 10],
            [['vcsl_nama_kompetensi'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vcsl_kod_latihan' => 'Vcsl Kod Latihan',
            'vcsl_nama_latihan' => 'Vcsl Nama Latihan',
            'vcsl_kod_jenis' => 'Vcsl Kod Jenis',
            'vcsl_status_laporan' => 'Vcsl Status Laporan',
            'vcsl_siri_latihan' => 'Vcsl Siri Latihan',
            'vcsl_kod_siri_latihan' => 'Vcsl Kod Siri Latihan',
            'vcsl_tempat' => 'Vcsl Tempat',
            'vcsl_kod_peringkat' => 'Vcsl Kod Peringkat',
            'vcsl_nama_peringkat' => 'Vcsl Nama Peringkat',
            'vcsl_tkh_mula' => 'Vcsl Tkh Mula',
            'vcsl_tkh_tamat' => 'Vcsl Tkh Tamat',
            'vcsl_tkh_tangguh_mula' => 'Vcsl Tkh Tangguh Mula',
            'vcsl_tkh_tangguh_tamat' => 'Vcsl Tkh Tangguh Tamat',
            'vcsl_kod_anjuran' => 'Vcsl Kod Anjuran',
            'vcsl_nama_anjuran' => 'Vcsl Nama Anjuran',
            'vcsl_kod_kompetensi' => 'Vcsl Kod Kompetensi',
            'vcsl_nama_kompetensi' => 'Vcsl Nama Kompetensi',
            'vcsl_mata' => 'Vcsl Mata',
            'vcsl_jum_jam' => 'Vcsl Jum Jam',
            'vcsl_kod_kategori' => 'Vcsl Kod Kategori',
            'vcsl_deskripsi_latihan' => 'Vcsl Deskripsi Latihan',
            'vcsl_kod_sasaran' => 'Vcsl Kod Sasaran',
            'status_mycpd' => 'Status Mycpd',
            'status_latihan' => 'Status Latihan',
            'dihantar_oleh' => 'Dihantar Oleh',
            'dihantar_pada' => 'Dihantar Pada',
            'akademik' => 'Akademik',
            'show_takwim' => 'Show Takwim',
            'komen' => 'Komen',
            'penjawatan' => 'Penjawatan',
            'jumlah_peserta' => 'Jumlah Peserta',
            'logType' => 'Log Type',
            'unit' => 'Unit',
            'kategori' => 'Kategori',
            'kluster' => 'Kluster',
            'kursus_id' => 'Kursus ID',
            'siri_kursus' => 'Siri Kursus',
            'campus_id' => 'Campus ID',
            'vcsl_tkh_baru' => 'Vcsl Tkh Baru',
            'isAktif' => 'Is Aktif',
            'jum_hadir' => 'Jum Hadir',
            'kod_latihan_asal' => 'Kod Latihan Asal',
            'susun' => 'Susun',
            'id_cpd' => 'Id Cpd',
            'rekod_cpd' => 'Rekod Cpd',
            'id_siri_idp' => 'Id Siri Idp',
            'id_kursus_idp' => 'Id Kursus Idp',
            'isActive' => 'Is Active',
            'tkh_terima_permohonan' => 'Tkh Terima Permohonan',
            'penilaian_latihan' => 'Penilaian Latihan',
            'tahun' => 'Tahun',
            'insert_date' => 'Insert Date',
        ];
    }
    
    public function getTarikh($bulan){
        
        $m = date_format(date_create($bulan), "m");
        if($m == 01){
            $m = "Januari";}
        elseif ($m == 02){
          $m = "Februari";}
        elseif ($m == 03){
          $m = "Mac";}
        elseif ($m == 04){
          $m = "April";}
        elseif ($m == 05){
          $m = "Mei";}
        elseif ($m == 06){
          $m = "Jun";}
        elseif ($m == 07){
          $m = "Julai";}
        elseif ($m == '08'){
          $m = "Ogos";}
        elseif ($m == '09'){
          $m = "September";}
        elseif ($m == '10'){
          $m = "Oktober";}
        elseif ($m == '11'){
          $m = "November";}
        elseif ($m == '12'){
          $m = "Disember";}
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y");
    }
    
    public function getTarikhmulalatihan() {
        return  $this->getTarikh($this->vcsl_tkh_mula);
    }
    
    public function getTarikhtamatlatihan() {
        return  $this->getTarikh($this->vcsl_tkh_tamat);
    }
    
    public function getKategori() {
        return $this->hasOne(\app\models\myidp\Kategori::className(), ['kategori_id' => 'vcsl_kod_kategori']);
    }
}
