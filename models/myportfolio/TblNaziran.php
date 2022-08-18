<?php

namespace app\models\myportfolio;

use Yii;
use app\models\hronline\Tblprcobiodata;
/**
 * This is the model class for table "myportfolio.tbl_naziran".
 *
 * @property int $id
 * @property int $portfolio_id
 * @property string $icno
 * @property string $icno_naziran
 * @property string $lnpt_staf
 * @property string $lnpt_kawan
 * @property string $lnpt_pegawai
 * @property string $lnpt_kj
 * @property string $kehadiran_peraku_staf
 * @property string $kehadiran_peraku_kawan
 * @property string $kehadiran_peraku_pegawai
 * @property string $kehadiran_peraku_kj
 * @property string $kehadiran_reject_staf
 * @property string $kehadiran_reject_kawan
 * @property string $kehadiran_reject_pegawai
 * @property string $kehadiran_reject_kj
 * @property int $tahap_tugas
 * @property string $tugas_staf
 * @property string $tugas_kawan
 * @property string $tugas_pegawai
 * @property string $tugas_kj
 * @property int $tahap_produktiviti
 * @property string $pro_staf
 * @property string $pro_kawan
 * @property string $pro_pegawai
 * @property string $pro_kj
 * @property string $lain_lain
 * @property string $lain_staf
 * @property string $lain_kawan
 * @property string $lain_pegawai
 * @property string $lain_kj
 * @property string $ulasan_keseluruhan
 */
class TblNaziran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_tbl_naziran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['portfolio_id', 'tahap_tugas', 'tahap_produktiviti'], 'integer'],
            [['lnpt_staf', 'lnpt_kawan', 'lnpt_pegawai', 'lnpt_kj', 'kehadiran_peraku_staf', 'kehadiran_peraku_kawan', 'kehadiran_peraku_pegawai', 'kehadiran_peraku_kj', 'kehadiran_reject_staf', 'kehadiran_reject_kawan', 'kehadiran_reject_pegawai', 'kehadiran_reject_kj', 'tugas_staf', 'tugas_kawan', 'tugas_pegawai', 'tugas_kj', 'pro_staf', 'pro_kawan', 'pro_pegawai', 'pro_kj', 'lain_lain', 'lain_staf', 'lain_kawan', 'lain_pegawai', 'lain_kj', 'ulasan_keseluruhan'], 'string'],
            [['icno', 'icno_naziran'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'portfolio_id' => 'Portfolio ID',
            'icno' => 'Icno',
            'icno_naziran' => 'Icno Naziran',
            'lnpt_staf' => 'Lnpt Staf',
            'lnpt_kawan' => 'Lnpt Kawan',
            'lnpt_pegawai' => 'Lnpt Pegawai',
            'lnpt_kj' => 'Lnpt Kj',
            'kehadiran_peraku_staf' => 'Kehadiran Peraku Staf',
            'kehadiran_peraku_kawan' => 'Kehadiran Peraku Kawan',
            'kehadiran_peraku_pegawai' => 'Kehadiran Peraku Pegawai',
            'kehadiran_peraku_kj' => 'Kehadiran Peraku Kj',
            'kehadiran_reject_staf' => 'Kehadiran Reject Staf',
            'kehadiran_reject_kawan' => 'Kehadiran Reject Kawan',
            'kehadiran_reject_pegawai' => 'Kehadiran Reject Pegawai',
            'kehadiran_reject_kj' => 'Kehadiran Reject Kj',
            'tahap_tugas' => 'Tahap Tugas',
            'tugas_staf' => 'Tugas Staf',
            'tugas_kawan' => 'Tugas Kawan',
            'tugas_pegawai' => 'Tugas Pegawai',
            'tugas_kj' => 'Tugas Kj',
            'tahap_produktiviti' => 'Tahap Produktiviti',
            'pro_staf' => 'Pro Staf',
            'pro_kawan' => 'Pro Kawan',
            'pro_pegawai' => 'Pro Pegawai',
            'pro_kj' => 'Pro Kj',
            'lain_lain' => 'Lain Lain',
            'lain_staf' => 'Lain Staf',
            'lain_kawan' => 'Lain Kawan',
            'lain_pegawai' => 'Lain Pegawai',
            'lain_kj' => 'Lain Kj',
            'ulasan_keseluruhan' => 'Ulasan Keseluruhan',
        ];
    }
    
      public function getNaziranIcno() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno_naziran']);
    }
}
