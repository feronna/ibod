<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "idp.v_idp_penilaian_keberkesanan".
 *
 * @property string $pid
 * @property string $kursusId
 * @property string $pesertaId
 * @property string $ringkasanLatihan
 * @property int $s1
 * @property int $s2
 * @property int $s3
 * @property int $s4
 * @property int $s5
 * @property string $tarikhStafIsi
 * @property string $ketuaId
 * @property int $k1
 * @property int $k2
 * @property int $k3
 * @property string $tarikhKetuaIsi
 * @property int $bsm_kursus_jangka_pendek 1=UMUM,2=KHUSUS
 * @property int $bsm_kursus_jangka_panjang 1=UMUM,2=KHUSUS
 * @property string $bsm_staf_id
 * @property string $bsm_staf_tarikh_isi
 * @property int $bsm_kelulusan_mata_idp
 * @property string $bsm_ulasan
 * @property int $bsm_pegawai_semak
 * @property string $bsm_pegawai_id
 * @property string $bsm_pegawai_tarikh_semak
 * @property int $bsm_ketuabsm_sahkan
 * @property string $bsm_ketuabsm_id
 * @property string $bsm_ketuabsm_tarikh_sah
 * @property string $insert_id
 * @property int $bsm_keyin 0=Staf Keyin,1=BSM Keyin
 */
class BorangPenilaianKeberkesananLama extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'idp.v_idp_penilaian_keberkesanan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kursusId', 's1', 's2', 's3', 's4', 's5', 'k1', 'k2', 'k3', 'bsm_kursus_jangka_pendek', 'bsm_kursus_jangka_panjang', 'bsm_kelulusan_mata_idp', 'bsm_pegawai_semak', 'bsm_ketuabsm_sahkan', 'bsm_keyin'], 'integer'],
            [['ringkasanLatihan', 'bsm_ulasan'], 'string'],
            [['tarikhStafIsi', 'tarikhKetuaIsi', 'bsm_staf_tarikh_isi', 'bsm_pegawai_tarikh_semak', 'bsm_ketuabsm_tarikh_sah'], 'safe'],
            [['pesertaId', 'ketuaId', 'bsm_staf_id', 'bsm_pegawai_id', 'bsm_ketuabsm_id', 'insert_id'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pid' => 'Pid',
            'kursusId' => 'Kursus ID',
            'pesertaId' => 'Peserta ID',
            'ringkasanLatihan' => 'Ringkasan Latihan',
            's1' => 'S1',
            's2' => 'S2',
            's3' => 'S3',
            's4' => 'S4',
            's5' => 'S5',
            'tarikhStafIsi' => 'Tarikh Staf Isi',
            'ketuaId' => 'Ketua ID',
            'k1' => 'K1',
            'k2' => 'K2',
            'k3' => 'K3',
            'tarikhKetuaIsi' => 'Tarikh Ketua Isi',
            'bsm_kursus_jangka_pendek' => 'Bsm Kursus Jangka Pendek',
            'bsm_kursus_jangka_panjang' => 'Bsm Kursus Jangka Panjang',
            'bsm_staf_id' => 'Bsm Staf ID',
            'bsm_staf_tarikh_isi' => 'Bsm Staf Tarikh Isi',
            'bsm_kelulusan_mata_idp' => 'Bsm Kelulusan Mata Idp',
            'bsm_ulasan' => 'Bsm Ulasan',
            'bsm_pegawai_semak' => 'Bsm Pegawai Semak',
            'bsm_pegawai_id' => 'Bsm Pegawai ID',
            'bsm_pegawai_tarikh_semak' => 'Bsm Pegawai Tarikh Semak',
            'bsm_ketuabsm_sahkan' => 'Bsm Ketuabsm Sahkan',
            'bsm_ketuabsm_id' => 'Bsm Ketuabsm ID',
            'bsm_ketuabsm_tarikh_sah' => 'Bsm Ketuabsm Tarikh Sah',
            'insert_id' => 'Insert ID',
            'bsm_keyin' => 'Bsm Keyin',
        ];
    }
}
