<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "myidp.permohonanMataLatihan".
 *
 * @property string $pemohonID
 * @property int $kursusLatihanID
 * @property int $siriLatihanID
 * @property string $tarikhPermohonan
 * @property string $statusPermohonan
 * @property string $tarikhDisemak
 * @property string $disemakOleh
 * @property string $tarikhKelulusan
 * @property string $diluluskanOleh
 * @property string $ulasanBSM
 */
class PermohonanMataLatihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'myidp.permohonanMataLatihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pemohonID', 'kursusLatihanID'], 'required'],
            [['kursusLatihanID', 'siriLatihanID', 'mataDipohon', 'mataDiluluskan'], 'integer'],
            [['tarikhPermohonan', 'tarikhDisemak', 'tarikhKelulusan'], 'safe'],
            [['ulasanBSM'], 'string'],
            [['pemohonID', 'disemakOleh', 'diluluskanOleh'], 'string', 'max' => 12],
            [['statusPermohonan'], 'string', 'max' => 25],
            [['pemohonID', 'kursusLatihanID'], 'unique', 'targetAttribute' => ['pemohonID', 'kursusLatihanID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pemohonID' => 'Pemohon ID',
            'kursusLatihanID' => 'Kursus Latihan ID',
            'siriLatihanID' => 'Siri Latihan ID',
            'tarikhPermohonan' => 'Tarikh Permohonan',
            'statusPermohonan' => 'Status Permohonan',
            'tarikhDisemak' => 'Tarikh Disemak',
            'disemakOleh' => 'Disemak Oleh',
            'tarikhKelulusan' => 'Tarikh Kelulusan',
            'diluluskanOleh' => 'Diluluskan Oleh',
            'mataDipohon' => 'Mata Dipohon',
            'mataDiluluskan' => 'Mata Diluluskan',
            'ulasanBSM' => 'Ulasan Bsm',
        ];
    }
    
    /** Relation **/
    public function getSasaran3(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(KursusLatihanJfpiu::className(), ['kursusLatihanID' => 'kursusLatihanID']);
    }
    
    public function getSasaran6(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(SiriLatihanJfpiu::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
    public function getSasaran8(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(SiriLatihanBahan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
    /** Relation **/
    public function getSasaran5(){
        return $this->hasOne(SlotLatihanJfpiu::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
    public function getStatusPermohona(){
        
//        if ($this->statusPermohonan == 'BARU'){
//            $statusPohon = '<span class = "label label-warning">BARU</span>';
//        } else if ($this->statusPermohonan == 'DIPERAKUI') {
//            $statusPohon = '<span class="label label-success">DIPERAKUI</span>';
//            if ($this->d_mk_hod_status_setuju == '1'){
//                $statusPohon = '<span class="label label-primary">DIPERSETUJUI</span>';
//            }
//            if ($this->d_mk_hod_status_setuju == '0'){
//                $statusPohon = '<span class="label label-danger">TIDAK DILULUSKAN 1</span>';
//            }
//        } else {
//            $statusPohon = '<span class="label label-danger">TIDAK DILULUSKAN</span>';
//        }
        
        if ($this->statusPermohonan == 'BARU') {
            $statusPohon = '<span class="label label-default">BARU</span>';     
        } elseif ($this->statusPermohonan == 'DIPERAKUI') {
            $statusPohon = '<span class="label label-info">DIPERAKUI</span>';
        } elseif ($this->statusPermohonan == 'DILULUSKAN') {
            $statusPohon = '<span class="label label-success">DILULUSKAN</span>';
        } elseif ($this->statusPermohonan == 'TIDAK DIPERAKUI') {
            $statusPohon = '<span class="label label-danger">TIDAK DIPERAKUI</span>';
        } elseif ($this->statusPermohonan == 'TIDAK DILULUSKAN') {
            $statusPohon = '<span class="label label-danger">TIDAK DILULUSKAN</span>';
        } 

        return $statusPohon;
    }
    
    /** Relation **/
    public function getPenyemak()
    {
        //return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'disemakOleh']);
        
        $nama_penyemak = "";
        
        $penyemak_icno = $this->disemakOleh;
        $model = Tblprcobiodata::findOne(['ICNO' => $penyemak_icno]);
        
        if ($model) {
            $nama_penyemak = $model->gelaran->Title.' '.$model->CONm;
        }
        
        return ucwords(strtolower($nama_penyemak));
   
    }
    
    public function getPelulus()
    {
        //return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'diluluskanOleh']);
        
        $nama_pelulus = "TIADA DATA";
        
        $pelulus_icno = $this->diluluskanOleh;
        $model = Tblprcobiodata::findOne(['ICNO' => $pelulus_icno]);
        
        if ($model) {
            $nama_pelulus = $model->gelaran->Title.' '.$model->CONm;
        }
        
        return ucwords(strtolower($nama_pelulus));
    }
}
