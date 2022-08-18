<?php

namespace app\models\utilities\epos;

use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "utilities.pos_tbl_permohonan".
 *
 * @property int $id
 * @property string $icno_pemohon
 * @property string $tujuan_mel
 * @property string $tarikh_mohon
 * @property string $alamat_penghantar
 * @property string $alamat_penerima
 * @property string $icno_pelulus
 * @property int $status_jafpib 1=dihantar;2=lulus;3=gagal
 * @property string $tarikh_status_jafpib
 * @property string $icno_pom icno pejabat operasi mel
 * @property int $status_pom 1=belum disemak;2=sah;3=batal
 * @property string $tarikh_status_pom
 * @property string $tracking_no
 * @property string $tarikh_dihantar
 * @property int $jenis_khidmat_mel ref_jenis_khidmat_mel
 * @property string $bayaran_mel
 */
class PosTblPermohonan extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'utilities.pos_tbl_permohonan';
    }

    public function rules()
    {
        return [
            [['alamat_penerima', 'jenis_khidmat_mel','no_tel'], 'required','on'=>'mohon', 'message'=>'Ruang ini adalah mandatori'],
            [['tracking_no','bayaran_mel'], 'required','on'=>'TambahMaklumatMel', 'message'=>'Ruang ini adalah mandatori'],
            [['tujuan_mel', 'alamat_penghantar', 'alamat_penerima'], 'string'],
            [['tarikh_mohon', 'tarikh_status_jafpib', 'tarikh_status_pom', 'tarikh_dihantar'], 'safe'],
            [['status_jafpib', 'status_pom', 'jenis_khidmat_mel'], 'integer'],
            [['bayaran_mel'], 'number'],
            [['icno_pemohon', 'icno_pelulus', 'icno_pom'], 'string', 'max' => 15],
            [['tracking_no'], 'string', 'max' => 50],
            [['no_tel'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno_pemohon' => 'Icno Pemohon',
            'tujuan_mel' => 'Tujuan Mel',
            'tarikh_mohon' => 'Tarikh Mohon',
            'alamat_penghantar' => 'Alamat Penghantar',
            'alamat_penerima' => 'Alamat Penerima',
            'icno_pelulus' => 'Icno Pelulus',
            'status_jafpib' => 'Status Jafpib',
            'tarikh_status_jafpib' => 'Tarikh Status Jafpib',
            'icno_pom' => 'Icno Pom',
            'status_pom' => 'Status Pom',
            'tarikh_status_pom' => 'Tarikh Status Pom',
            'tracking_no' => 'Tracking No',
            'tarikh_dihantar' => 'Tarikh Dihantar',
            'jenis_khidmat_mel' => 'Jenis Khidmat Mel',
            'bayaran_mel' => 'Bayaran Mel',
        ];
    }

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno_pemohon']);
    }
    public function getJabatan() {
        return $this->hasOne(Department::className(), ['id' => 'DeptId']);
    }
    public function getBarang() {
        return $this->hasMany(PosBarangMel::className(), ['permohonan_id' => 'id']);
    }
    public function getJenisKhidmatMel() {
        return $this->hasOne(JenisKhidmatMel::className(), ['id' => 'jenis_khidmat_mel']);
    }
public static function TotalbyStatus($id) {
        return count(PosTblPermohonan::findAll(['status_pom'=>$id]));
    }
    public static function TotalPermohonan() {
        return count(PosTblPermohonan::find()->all());
    }

}
