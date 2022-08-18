<?php

namespace app\models\guarantee_letter;

use Yii;
use app\models\guarantee_letter\TblStatusgl;
use app\models\guarantee_letter\TblKelasWad;
use app\models\guarantee_letter\TblHospital;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "guarantee_letter.tbl_permohonan".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $tarikh_mohon
 * @property int $status_semasa 
 * @property string $tarikh_notifikasi
 * @property string $gl_ICNO
 * @property int $gl_hubungan_id
 * @property string $gl_nama
 */
class TblPermohonan extends \yii\db\ActiveRecord {

    public $y_m; 
    public $family;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.gl_tbl_permohonan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [

            [['gl_hospital_id','gl_ICNO'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['tarikh_mohon', 'tarikh_notifikasi', 'gl_kelasWad_id', 'isActive', 'y_m','family','sah_bukti_by'], 'safe'],
            [['status_semasa', 'gl_hospital_id', 'gl_kelasWad_id', 'status_notifikasi'], 'integer'],
            [['ICNO', 'gl_ICNO'], 'string', 'max' => 12],
            [['gl_nama'], 'string', 'max' => 250],
            [['gl_hubungan'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'tarikh_mohon' => 'Tarikh Mohon',
            'status_semasa' => 'Status Semasa', 
            'tarikh_notifikasi' => 'Tarikh Notifikasi',
            'gl_ICNO' => 'Gl Icno',
            'gl_hubungan_id' => 'Gl Hubungan ID',
            'gl_nama' => 'Gl Nama',
            'gl_kelasWad_id' => 'Kelas Wad',
        ];
    }
    
    public function Pegawai() {
        return \app\models\cuti\TblManagement::find()->where(['user' => 'eGL'])->andWhere(['level'=>1])->one();
    } 

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    } 

    public function getKelasWad() {
        return $this->hasOne(TblKelasWad::className(), ['id' => 'gl_kelasWad_id']);
    }

    public function getHospital() {
        return $this->hasOne(TblHospital::className(), ['id' => 'gl_hospital_id']);
    } 

    public static function totalPending() {
        
        $model = TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->exists();

        if ($model) { 
                $count = TblPermohonan::find()->where(['status_notifikasi' => 1])->andWhere(['DATE(tarikh_mohon)' => date('Y-m-d')])->count();
           if ($count) {
                return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
            } else {
                return '';
            } 
        }
    }

}
