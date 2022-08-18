<?php

namespace app\models\hronline;
use app\models\hronline\Tblprcobiodata;

use Yii;

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
class Vcpdlatihan extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hronline.v_cpd_latihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
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
    public function attributeLabels() {
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

    public function getSenarailatihan() { //untuk dapatkan nama latihan
        return $this->hasOne(Vcpdsenarailatihan::className(), ['vcsl_kod_latihan' => 'vcl_kod_latihan']);
    }

    public function getJeniskompetensi() {
        return $this->hasOne(Vcpdkompetensi::className(), ['vcks_kod_kompetensi' => 'vcl_kod_kompetensi']);
    }

    public function getKategori() {
        return $this->hasOne(Rcpdkategori::className(), ['rck_kod_kategori' => 'vcsl_kod_kategori'])
                        ->viaTable('hronline.V_cpd_senarai_latihan', ['vcsl_kod_latihan' => 'vcl_kod_latihan']);
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'vcl_id_staf']);
    }

    public function kodKompetensi() {

        if ($this->biodata->jawatan->job_category == 1) {
            return $kod = [1, 3, 4]; // akademik
        } else {
            return $kod = [4, 5, 6]; // pentadbiran
        }
    }

}
