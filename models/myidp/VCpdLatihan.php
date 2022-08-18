<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\myidp\VCpdSenaraiLatihan;

/**
 * This is the model class for table "hronline.v_cpd_latihan".
 *
 * @property string $id
 * @property string $vcl_id_staf
 * @property string $vcl_kod_latihan
 * @property string $vcl_tkh_mula
 * @property string $vcl_tkh_tamat
 * @property string $vcl_peranan
 * @property double $vcl_jum_jam
 * @property double $vcl_jum_mata
 * @property string $vcl_komen
 * @property string $vcl_laporan
 * @property string $vcl_tkh_htr_laporan
 * @property string $vcl_tkh_penilaian
 * @property string $vcl_id_kemaskini
 * @property string $vcl_tkh_kemaskini
 * @property string $vcl_direkod_oleh
 * @property string $vcl_tkh_direkod
 * @property int $vcl_kod_kompetensi
 * @property int $vcl_siri_latihan
 * @property int $vcl_status_update
 * @property int $vcl_status_aktif
 * @property string $vcl_kod_jabatan
 * @property int $vcl_kehadiran
 * @property string $vcl_catatan_kehadiran
 * @property int $walkin
 * @property int $hantar_penilaian 0=Belum Hantar, 1=Telah Hantar
 * @property int $status_mycpd
 * @property string $dihantar_oleh
 * @property string $dihantar_pada
 * @property string $id_cpd
 */
class VCpdLatihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        // return 'hronline.v_cpd_latihan';
        return 'hrd.v_cpd_latihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vcl_tkh_mula', 'vcl_tkh_tamat', 'vcl_tkh_htr_laporan', 'vcl_tkh_penilaian', 'vcl_tkh_kemaskini', 'vcl_tkh_direkod', 'dihantar_pada'], 'safe'],
            [['vcl_jum_jam', 'vcl_jum_mata'], 'number'],
            [['vcl_kod_kompetensi', 'vcl_siri_latihan', 'vcl_status_update', 'vcl_status_aktif', 'vcl_kehadiran', 'walkin', 'hantar_penilaian', 'status_mycpd', 'id_cpd'], 'integer'],
            [['vcl_id_staf', 'vcl_id_kemaskini', 'vcl_direkod_oleh', 'dihantar_oleh'], 'string', 'max' => 12],
            [['vcl_kod_latihan'], 'string', 'max' => 10],
            [['vcl_peranan'], 'string', 'max' => 30],
            [['vcl_komen', 'vcl_catatan_kehadiran'], 'string', 'max' => 255],
            [['vcl_laporan'], 'string', 'max' => 1],
            [['vcl_kod_jabatan'], 'string', 'max' => 50],
            [['vcl_id_staf', 'vcl_kod_latihan'], 'unique', 'targetAttribute' => ['vcl_id_staf', 'vcl_kod_latihan']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vcl_id_staf' => 'Vcl Id Staf',
            'vcl_kod_latihan' => 'Vcl Kod Latihan',
            'vcl_tkh_mula' => 'Vcl Tkh Mula',
            'vcl_tkh_tamat' => 'Vcl Tkh Tamat',
            'vcl_peranan' => 'Vcl Peranan',
            'vcl_jum_jam' => 'Vcl Jum Jam',
            'vcl_jum_mata' => 'Vcl Jum Mata',
            'vcl_komen' => 'Vcl Komen',
            'vcl_laporan' => 'Vcl Laporan',
            'vcl_tkh_htr_laporan' => 'Vcl Tkh Htr Laporan',
            'vcl_tkh_penilaian' => 'Vcl Tkh Penilaian',
            'vcl_id_kemaskini' => 'Vcl Id Kemaskini',
            'vcl_tkh_kemaskini' => 'Vcl Tkh Kemaskini',
            'vcl_direkod_oleh' => 'Vcl Direkod Oleh',
            'vcl_tkh_direkod' => 'Vcl Tkh Direkod',
            'vcl_kod_kompetensi' => 'Vcl Kod Kompetensi',
            'vcl_siri_latihan' => 'Vcl Siri Latihan',
            'vcl_status_update' => 'Vcl Status Update',
            'vcl_status_aktif' => 'Vcl Status Aktif',
            'vcl_kod_jabatan' => 'Vcl Kod Jabatan',
            'vcl_kehadiran' => 'Vcl Kehadiran',
            'vcl_catatan_kehadiran' => 'Vcl Catatan Kehadiran',
            'walkin' => 'Walkin',
            'hantar_penilaian' => 'Hantar Penilaian',
            'status_mycpd' => 'Status Mycpd',
            'dihantar_oleh' => 'Dihantar Oleh',
            'dihantar_pada' => 'Dihantar Pada',
            'id_cpd' => 'Id Cpd',
        ];
    }

    /** Relation **/
    public function getLatihan()
    {
        return $this->hasOne(VCpdSenaraiLatihan::className(), ['vcsl_kod_latihan' => 'vcl_kod_latihan']);
    }

    public function getMataElektif()
    {

        $id = Yii::$app->user->getId();

        //get current year
        $currentYear = date('Y');
        $jumlahMataElektif = 0;

        $model2 = VCpdLatihan::find()
            ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 4 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
            ->all();

        foreach ($model2 as $model) {

            $jumlahMataElektif = $jumlahMataElektif + $model->vcl_jum_mata;
        }

        return $jumlahMataElektif;
    }

    public function getMataTerasUniversiti()
    {

        $id = Yii::$app->user->getId();

        //get current year
        $currentYear = date('Y');
        $jumlahMataTerasUniversiti = 0;

        $model2 = VCpdLatihan::find()
            ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 5 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
            ->all();

        foreach ($model2 as $model) {

            $jumlahMataTerasUniversiti = $jumlahMataTerasUniversiti + $model->vcl_jum_mata;
        }

        return $jumlahMataTerasUniversiti;
    }

    public function getMataTerasSkim()
    {

        $id = Yii::$app->user->getId();

        //get current year
        $currentYear = date('Y');
        $jumlahMataTerasSkim = 0;

        $model2 = VCpdLatihan::find()
            ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 6 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
            ->all();

        foreach ($model2 as $model) {

            $jumlahMataTerasSkim = $jumlahMataTerasSkim + $model->vcl_jum_mata;
        }

        return $jumlahMataTerasSkim;
    }

    public function getMataUmum()
    {

        $id = Yii::$app->user->getId();

        //get current year
        $currentYear = date('Y');
        $jumlahMataUmum = 0;

        $model2 = VCpdLatihan::find()
            ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 1 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear")
            ->all();

        foreach ($model2 as $model) {

            $jumlahMataUmum = $jumlahMataUmum + $model->vcl_jum_mata;
        }

        return $jumlahMataUmum;
    }

    public function getMataTerasAcademic()
    {

        $id = Yii::$app->user->getId();

        //get current year
        $currentYear = date('Y');
        $jumlahMataTerasAcademic = 0;

        $model2 = VCpdLatihan::find()
            ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 3 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
            ->all();

        foreach ($model2 as $model) {

            $jumlahMataTerasAcademic = $jumlahMataTerasAcademic + $model->vcl_jum_mata;
        }

        return $jumlahMataTerasAcademic;
    }

    public function getMataUmumAcademic()
    {

        $id = Yii::$app->user->getId();

        //get current year
        $currentYear = date('Y');
        $jumlahMataUmum = 0;

        $model2 = VCpdLatihan::find()
            ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 1 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear")
            ->all();

        foreach ($model2 as $model) {

            $jumlahMataUmum = $jumlahMataUmum + $model->vcl_jum_mata;
        }

        return $jumlahMataUmum;
    }

    public function getKategori()
    {
        return $this->hasOne(\app\models\myidp\Kategori::className(), ['kategori_id' => 'vcl_kod_kompetensi']);
    }

    // public function getSenaraiLatihan()
    // {
    //     return $this->hasOne(app\models\hronline\Vcpdsenarailatihan::className(), ['vcsl_kod_latihan' => 'vcl_kod_latihan']);
    // }

    public function calculatePeserta($id)
    {
        $totalPeserta = 0;

        $totalpeserta = VCpdLatihan::find()
            ->where(['vcl_kod_latihan' => $id])
            ->count();

        return $totalpeserta;
    }

    public function getPeserta()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'vcl_id_staf']);
    }

    public function getJenisKursus()
    {

        $a = "BUKAN SASARAN";

        if ($this->vcl_kod_kompetensi != 0) {

            if ($this->vcl_kod_kompetensi == 1) {
                $a = '<span class="label label-default">UMUM</span>';
            } elseif ($this->vcl_kod_kompetensi == 3) {
                $a = '<span class="label label-danger">TERAS</span>';
            } elseif ($this->vcl_kod_kompetensi == 4) {
                $a = '<span class="label label-primary">ELEKTIF</span>';
            } elseif ($this->vcl_kod_kompetensi == 5) {
                $a = '<span class="label label-success">TERAS UNIVERSITI</span>';
            } elseif ($this->vcl_kod_kompetensi == 6) {
                $a = '<span class="label label-info">TERAS SKIM</span>';
            } elseif ($this->vcl_kod_kompetensi == 7) {
                $a = '<span class="label label-success">IMPAK TINGGI</span>';
            }

            return $a;
        } 

        return $a;
    }

    public function calculatePesertaByMonth($month, $year)
    {

        $totalpeserta = VCpdLatihan::find()
            ->joinWith('latihan')
            ->where(['MONTH(vcsl_tkh_mula)' => $month, 'YEAR(vcsl_tkh_mula)' => $year, 'vcsl_kod_anjuran' => '12', 'status_latihan' => '2'])
            ->count();

        return $totalpeserta;
    }

    public function calculatePesertaWalkIn($month, $year)
    {
        $totalpeserta = VCpdLatihan::find()
            ->joinWith('latihan')
            ->where(['MONTH(vcsl_tkh_mula)' => $month, 'YEAR(vcsl_tkh_mula)' => $year, 'vcsl_kod_anjuran' => '12', 'status_latihan' => '2'])
            ->all();

        $counter = 0;    
        foreach ($totalpeserta as $p){

            $checkMohon = MohonKursusLama::find()
                ->where(['d_mk_pemohon_icno' => $p->vcl_id_staf])
                ->andWhere(['d_mk_kod_kursus' => $p->vcl_kod_latihan])
                ->one();

            if (!$checkMohon){
                $counter++;
            }

        }

        return $counter;
    }
}
