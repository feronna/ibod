<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%hrd.d_mohon_kursus}}".
 *
 * @property string $d_mk_id
 * @property int $d_mk_kod_kursus Refer vcsl_kod_latihan v_idp_senarai_latihan
 * @property string $d_mk_pemohon_icno
 * @property int $d_mk_pemohon_jwtn_id
 * @property int $d_mk_pemohon_jspiu
 * @property string $d_mk_pemohon_aspek_tugas
 * @property string $d_mk_pemohon_tarikh_sah
 * @property string $d_mk_pp_icno
 * @property int $d_mk_pp_status_setuju
 * @property string $d_mk_pp_tarikh_sah
 * @property string $d_mk_hod_icno
 * @property string $d_mk_hod_keperluan_kursus
 * @property int $d_mk_hod_status_setuju 0 = TDK SETUJU, 1 = SETUJU
 * @property string $d_mk_hod_tarikh_sah
 * @property string $d_mk_upp_icno
 * @property int $d_mk_upp_status_lulus 0 = TDK LULUS, 1 = LULUS, 2 = KURSUS LAIN
 * @property string $d_mk_upp_tarikh_aku
 * @property string $d_mk_upp_no_mesy
 * @property string $d_mk_upp_catatan
 * @property string $d_mk_tiket_kapal
 * @property string $d_mk_hotel
 * @property int $iid Refer kursus_id v_idp_senarai_kursus
 * @property int $hadir 0 = TDK HADIR, 1 = HADIR
 * @property string $sbb_xhadir
 */
class MohonKursusLama extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.d_mohon_kursus}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['d_mk_kod_kursus', 'd_mk_pemohon_jwtn_id', 'd_mk_pemohon_jspiu', 'd_mk_pp_status_setuju', 'd_mk_hod_status_setuju', 'd_mk_upp_status_lulus', 'iid', 'hadir'], 'integer'],
            [['d_mk_pemohon_aspek_tugas', 'd_mk_hod_keperluan_kursus', 'd_mk_upp_catatan', 'sbb_xhadir'], 'string'],
            [['d_mk_pemohon_tarikh_sah', 'd_mk_pp_tarikh_sah', 'd_mk_hod_tarikh_sah', 'd_mk_upp_tarikh_aku'], 'safe'],
            [['d_mk_pemohon_icno', 'd_mk_pp_icno', 'd_mk_hod_icno', 'd_mk_upp_icno'], 'string', 'max' => 12],
            [['d_mk_upp_no_mesy', 'd_mk_tiket_kapal', 'd_mk_hotel'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'd_mk_id' => 'D Mk ID',
            'd_mk_kod_kursus' => 'D Mk Kod Kursus',
            'd_mk_pemohon_icno' => 'D Mk Pemohon Icno',
            'd_mk_pemohon_jwtn_id' => 'D Mk Pemohon Jwtn ID',
            'd_mk_pemohon_jspiu' => 'D Mk Pemohon Jspiu',
            'd_mk_pemohon_aspek_tugas' => 'D Mk Pemohon Aspek Tugas',
            'd_mk_pemohon_tarikh_sah' => 'D Mk Pemohon Tarikh Sah',
            'd_mk_pp_icno' => 'D Mk Pp Icno',
            'd_mk_pp_status_setuju' => 'D Mk Pp Status Setuju',
            'd_mk_pp_tarikh_sah' => 'D Mk Pp Tarikh Sah',
            'd_mk_hod_icno' => 'D Mk Hod Icno',
            'd_mk_hod_keperluan_kursus' => 'D Mk Hod Keperluan Kursus',
            'd_mk_hod_status_setuju' => 'D Mk Hod Status Setuju',
            'd_mk_hod_tarikh_sah' => 'D Mk Hod Tarikh Sah',
            'd_mk_upp_icno' => 'D Mk Upp Icno',
            'd_mk_upp_status_lulus' => 'D Mk Upp Status Lulus',
            'd_mk_upp_tarikh_aku' => 'D Mk Upp Tarikh Aku',
            'd_mk_upp_no_mesy' => 'D Mk Upp No Mesy',
            'd_mk_upp_catatan' => 'D Mk Upp Catatan',
            'd_mk_tiket_kapal' => 'D Mk Tiket Kapal',
            'd_mk_hotel' => 'D Mk Hotel',
            'iid' => 'Iid',
            'hadir' => 'Hadir',
            'sbb_xhadir' => 'Sbb Xhadir',
        ];
    }

    /** Relation **/
    public function getKursus()
    {
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(VCpdSenaraiLatihan::className(), ['vcsl_kod_latihan' => 'd_mk_kod_kursus']);
    }

    public function calculatePemohonByMonth($kumpulan, $year)
    {
        $totalpeserta = MohonKursusLama::find()
            ->joinWith('kursus')
            ->where(['MONTH(vcsl_tkh_mula)' => $kumpulan, 'YEAR(vcsl_tkh_mula)' => $year, 'vcsl_kod_anjuran' => '12', 'status_latihan' => '1'])
            ->orWhere(['MONTH(vcsl_tkh_mula)' => $kumpulan, 'YEAR(vcsl_tkh_mula)' => $year, 'vcsl_kod_anjuran' => '12', 'status_latihan' => '2'])
            ->orWhere(['MONTH(vcsl_tkh_mula)' => $kumpulan, 'YEAR(vcsl_tkh_mula)' => $year, 'vcsl_kod_anjuran' => '12', 'status_latihan' => '3'])
            ->count();

        return $totalpeserta;
    }
}
