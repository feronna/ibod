<?php

namespace app\models\myidp;

use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "idp.v_idp_senarai_kursus".
 *
 * @property int $kursus_id iid
 * @property string $tajuk_kursus
 * @property string $pemilik_modul Penggubal Modul
 * @property int $tahun_ditawarkan
 * @property string $skim Kumpulan Sasaran
 * @property int $kategori_latihan
 * @property int $tahap
 * @property int $kumpulan
 * @property int $kluster_id Refer r_kluster
 * @property int $job_category 1=Akademik,2=Bukan Akademik
 * @property string $gugusan
 * @property int $campus_id Refer campus
 * @property int $mata_idp
 * @property int $jenis_penceramah Refer r_jenis_penceramah
 * @property string $nama_penceramah
 * @property string $sinopsis_kursus
 * @property string $hasil_pembelajaran
 * @property string $kandungan_kursus
 * @property string $kaedah_pelaksannan
 * @property string $rujukan
 * @property int $jumlah_hari
 * @property string $kod
 */
class VIdpSenaraiKursus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        // return 'idp.v_idp_senarai_kursus';
        return 'hrd.v_idp_senarai_kursus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun_ditawarkan', 'kategori_latihan', 'tahap', 'kumpulan', 'kluster_id', 'job_category', 'campus_id', 'mata_idp', 'jenis_penceramah', 'jumlah_hari'], 'integer'],
            [['sinopsis_kursus', 'hasil_pembelajaran', 'kandungan_kursus', 'kaedah_pelaksannan', 'rujukan'], 'string'],
            [['pemilik_modul'],'required', 'message' => 'Ruangan ini adalah mandatori'],
            [['tajuk_kursus', 'nama_penceramah'], 'string', 'max' => 255],
            [['pemilik_modul', 'skim', 'gugusan'], 'string', 'max' => 50],
            [['kod'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kursus_id' => 'Kursus ID',
            'tajuk_kursus' => 'Tajuk Kursus',
            'pemilik_modul' => 'Pemilik Modul',
            'tahun_ditawarkan' => 'Tahun Ditawarkan',
            'skim' => 'Skim',
            'kategori_latihan' => 'Kategori Latihan',
            'tahap' => 'Tahap',
            'kumpulan' => 'Kumpulan',
            'kluster_id' => 'Kluster ID',
            'job_category' => 'Job Category',
            'gugusan' => 'Gugusan',
            'campus_id' => 'Campus ID',
            'mata_idp' => 'Mata Idp',
            'jenis_penceramah' => 'Jenis Penceramah',
            'nama_penceramah' => 'Nama Penceramah',
            'sinopsis_kursus' => 'Sinopsis Kursus',
            'hasil_pembelajaran' => 'Hasil Pembelajaran',
            'kandungan_kursus' => 'Kandungan Kursus',
            'kaedah_pelaksannan' => 'Kaedah Pelaksannan',
            'rujukan' => 'Rujukan',
            'jumlah_hari' => 'Jumlah Hari',
            'kod' => 'Kod',
        ];
    }
    
        
    /** Relation **/
    // VIdpSenaraiKursus[job_category] == IdpKategoriJawatan[kategoriJawatanID] 
    public function getKategoriJawatan()
    {
        return $this->hasOne(IdpKategoriJawatan::className(), ['kategoriJawatanID'=>'job_category']);
    }
    
    /** Relation **/
    // VIdpSenaraiKursus[campus_id] == IdpCampus[campus_id] 
    public function getCampusName()
    {
        return $this->hasOne(IdpCampus::className(), ['campus_id'=>'campus_id']);
    }
    
    /** Function to list out 'senarai kursus/latihan for 'urusetiaLatihan' based on current year **/
    public function getSenaraiKursus()
    { //uncalled function
        
        //get current year
        $currentYear = date('Y');
        
        $senaraiKursusDP = new ActiveDataProvider([
                    'query' => VIdpSenaraiKursus::find()->where(['tahun_ditawarkan' => $currentYear]),
                    'pagination' => ['pageSize' => 30,],
                    ]);
        
        return $senaraiKursusDP;
    }
    
    public function getYearsList()
    {
        $currentYear = date('Y');
        $yearFrom = 2013;
        $yearsRange = range($yearFrom, $currentYear);
        return array_combine($yearsRange, $yearsRange);
    }

    /** Relation **/
    public function getSasaran8(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(VIdpKursusSasaran::className(), ['kursus_id' => 'kursus_id']);
    }
}
