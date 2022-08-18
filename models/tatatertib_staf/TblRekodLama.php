<?php

namespace app\models\tatatertib_staf;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\GredJawatan;
use app\models\hronline\Kumpulankhidmat;
use app\models\hronline\Department;
use app\models\tatatertib_staf\RefJenisHukuman;
use app\models\tatatertib_staf\RefJenisKesalahan;
use Yii;

/**
 * This is the model class for table "tatatertib_staf.tbl_rekod_lama".
 *
 * @property int $id
 * @property string $icno
 * @property string $tarikh_mula_kesalahan
 * @property string $tarikh_akhir_kesalahan
 * @property int $meeting_id
 * @property string $umsper
 * @property string $nama
 * @property int $kategori_jawatan
 * @property int $kumpulan_jawatan
 * @property int $jabatan
 * @property int $skim_perkhidmatan
 * @property int $jenis_kesalahan
 * @property string $kes
 * @property string $icno_kp
 * @property int $kp_agree
 * @property string $icno_kj
 * @property int $kj_agree
 * @property string $pelulus_icno
 * @property int $pelulus_agree
 * @property string $pelulus_agree2
 * @property string $created_at
 * @property int $letter_sent
 * @property string $tarikh_noti
 * @property int $status
 * @property int $flag
 * @property int $dept_id
 * @property int $campus_id
 * @property string $status_maklumbalas
 * @property string $file
 * @property string $reason
 * @property string $tarikh_hantar_maklumbalas
 * @property string $letter_sent2
 * @property string $rayuan
 * @property string $catatan_rayuan
 * @property string $bsm_icno
 * @property string $hukuman
 */
class TblRekodLama extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tertib_tbl_rekod_lama';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh_mula_kesalahan', 'tarikh_akhir_kesalahan', 'created_at', 'tarikh_noti', 'tarikh_hantar_maklumbalas'], 'safe'],
            [['meeting_id', 'kategori_jawatan', 'kumpulan_jawatan', 'jabatan', 'skim_perkhidmatan', 'jenis_kesalahan', 'kp_agree', 'kj_agree', 'pelulus_agree', 'letter_sent', 'status', 'flag', 'dept_id', 'campus_id'], 'integer'],
            [['icno', 'umsper', 'icno_kp', 'icno_kj', 'pelulus_icno', 'rayuan', 'bsm_icno'], 'string', 'max' => 15],
            [['nama', 'kes'], 'string', 'max' => 100],
            [['pelulus_agree2', 'reason', 'catatan_rayuan'], 'string', 'max' => 500],
            [['status_maklumbalas', 'file'], 'string', 'max' => 5],
            [['letter_sent2', 'hukuman'], 'string', 'max' => 1],
            [['icno', 'jenis_kesalahan', 'kes','tarikh_mula_kesalahan', 'tarikh_akhir_kesalahan','hukuman', 'catatan_rayuan', 'catatan_hukuman','rayuan'], 'required','message' => Yii::t('app', 'Wajib Diisi')],
            [['tarikh_mula_kesalahan', 'tarikh_akhir_kesalahan'], 'required','message' => Yii::t('app', 'Wajib Diisi')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'tarikh_mula_kesalahan' => 'Tarikh Mula Kesalahan',
            'tarikh_akhir_kesalahan' => 'Tarikh Akhir Kesalahan',
            'meeting_id' => 'Meeting ID',
            'umsper' => 'Umsper',
            'nama' => 'Nama',
            'kategori_jawatan' => 'Kategori Jawatan',
            'kumpulan_jawatan' => 'Kumpulan Jawatan',
            'jabatan' => 'Jabatan',
            'skim_perkhidmatan' => 'Skim Perkhidmatan',
            'jenis_kesalahan' => 'Jenis Kesalahan',
            'kes' => 'Kes',
            'icno_kp' => 'Icno Kp',
            'kp_agree' => 'Kp Agree',
            'icno_kj' => 'Icno Kj',
            'kj_agree' => 'Kj Agree',
            'pelulus_icno' => 'Pelulus Icno',
            'pelulus_agree' => 'Pelulus Agree',
            'pelulus_agree2' => 'Pelulus Agree2',
            'created_at' => 'Created At',
            'letter_sent' => 'Letter Sent',
            'tarikh_noti' => 'Tarikh Noti',
            'status' => 'Status',
            'flag' => 'Flag',
            'dept_id' => 'Dept ID',
            'campus_id' => 'Campus ID',
            'status_maklumbalas' => 'Status Maklumbalas',
            'file' => 'File',
            'reason' => 'Reason',
            'tarikh_hantar_maklumbalas' => 'Tarikh Hantar Maklumbalas',
            'letter_sent2' => 'Letter Sent2',
            'rayuan' => 'Rayuan',
            'catatan_rayuan' => 'Catatan Rayuan',
            'bsm_icno' => 'Bsm Icno',
            'hukuman' => 'Hukuman',
        ];
    }
    
       public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
       public function getJenisKesalahan() {
        return $this->hasOne(RefJenisKesalahan::className(), ['id' => 'jenis_kesalahan']);
    }
       public function getJenisHukuman() {
        return $this->hasOne(RefJenisHukuman::className(), ['id' => 'hukuman']);
    }
    
         public function getBidangKuasa() {
        return $this->hasOne(RefBidangKuasa::className(), ['id' => 'bidang_kuasa']);
    }
    
}
