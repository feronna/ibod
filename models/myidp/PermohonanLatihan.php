<?php

namespace app\models\myidp;

use Yii;
use app\models\cuti\SetPegawai;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use yii\helpers\Html;
use app\models\myidp\UserAccess;
use app\models\myidp\SuratKursusLuar;

/**
 * This is the model class for table "hrd.idp_permohonanlatihan".
 *
 * @property string $staffID
 * @property int $kursusLatihanID
 * @property string $tahun
 * @property int $siriLatihanID
 * @property string $caraPermohonan
 * @property string $tarikhPermohonan
 * @property string $statusPermohonan
 * @property string $tarikhDiperakukan
 * @property string $diperakuOleh
 * @property string $tarikhKelulusan
 * @property string $diluluskanOleh
 * @property string $tarikhSahHadir
 * @property string $sahHadirbyStaf
 * @property int $kategoriKursusID
 * @property string $alasanTidakHadir
 * @property int $sistemLulus
 * @property string $tarikhSistemLulus
 */
class PermohonanLatihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_permohonanlatihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staffID', 'kursusLatihanID', 'tahun'], 'required'],
            [['kursusLatihanID', 'siriLatihanID', 'kategoriKursusID', 'sistemLulus'], 'integer'],
            [['tarikhPermohonan', 'tarikhDiperakukan', 'tarikhKelulusan', 'tarikhSahHadir', 'tarikhSistemLulus'], 'safe'],
            [['alasanTidakHadir'], 'string'],
            [['staffID', 'diperakuOleh', 'diluluskanOleh'], 'string', 'max' => 12],
            [['tahun'], 'string', 'max' => 4],
            [['caraPermohonan', 'statusPermohonan'], 'string', 'max' => 25],
            [['sahHadirbyStaf'], 'string', 'max' => 5],
            [['staffID', 'kursusLatihanID', 'tahun'], 'unique', 'targetAttribute' => ['staffID', 'kursusLatihanID', 'tahun']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'staffID' => 'Staff ID',
            'kursusLatihanID' => 'Kursus Latihan ID',
            'tahun' => 'Tahun',
            'siriLatihanID' => 'Siri Latihan ID',
            'caraPermohonan' => 'Cara Permohonan',
            'tarikhPermohonan' => 'Tarikh Permohonan',
            'statusPermohonan' => 'Status Permohonan',
            'tarikhDiperakukan' => 'Tarikh Diperakukan',
            'diperakuOleh' => 'Diperaku Oleh',
            'tarikhKelulusan' => 'Tarikh Kelulusan',
            'diluluskanOleh' => 'Diluluskan Oleh',
            'tarikhSahHadir' => 'Tarikh Sah Hadir',
            'sahHadirbyStaf' => 'Sah Hadirby Staf',
            'kategoriKursusID' => 'Kategori Kursus ID',
            'alasanTidakHadir' => 'Alasan Tidak Hadir',
            'sistemLulus' => 'Sistem Lulus',
            'tarikhSistemLulus' => 'Tarikh Sistem Lulus',
        ];
    }
    
    /** Relation **/
//    public function getSasaran2(){
//        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
//        return $this->hasOne(SiriLatihan::className(), ['siriLatihanID'=>'siriLatihanID']);
//    }
    
    /** Relation **/
    public function getSasaran3(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(KursusLatihan::className(), ['kursusLatihanID' => 'kursusLatihanID']);
    }
    
    public function getSasaran6(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(SiriLatihan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
    public function getSasaran8(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(SiriLatihanBahan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
    public function getSasaran2(){
        return $this->hasOne(SetPegawai::className(), ['pemohon_icno' => 'staffID']);
    }
    
    /** Relation **/
    public function getKursus(){
        return $this->hasOne(KursusSasaran::className(), ['kursusLatihanID' => 'kursusLatihanID']);
    }
    
    //public function statusPermohonan($d_mk_pp_status_setuju){
    public function getStatusPermohona(){
        
        if ($this->statusPermohonan == 'BARU') {
            $statusPohon = '<span class="label label-default">BARU</span>';     
        } elseif ($this->statusPermohonan == 'DIPERAKUI') {
            $statusPohon = '<span class="label label-info">DIPERAKUI</span>';
        } elseif ($this->statusPermohonan == 'DILULUSKAN' && $this->sistemLulus == 1 ) {
            $statusPohon = '<span class="label label-success">DILULUSKAN BSM</span>';
        } elseif (($this->statusPermohonan == 'DILULUSKAN' && $this->sistemLulus == 0) 
                || ($this->statusPermohonan == 'DILULUSKAN' && $this->sistemLulus == NULL) ) {
            $statusPohon = '<span class="label label-success">DILULUSKAN</span>';
        } elseif ($this->statusPermohonan == 'TIDAK DIPERAKUI') {
            $statusPohon = '<span class="label label-danger">TIDAK DIPERAKUI</span>';
        } elseif ($this->statusPermohonan == 'TIDAK DILULUSKAN') {
            $statusPohon = '<span class="label label-danger">TIDAK DILULUSKAN</span>';
        } 

        return $statusPohon;
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staffID'] );
    }
    
    public function getIdp() {
        return $this->hasOne(\app\models\myidp\Idp::className(), ['v_co_icno' => 'staffID'] );
    }
    
    public function getCheckHadir(){
        
        $checkHadir = BorangPenilaianLatihan::find()
                ->where(['pesertaID' => $this->staffID])
                ->andWhere(['siriLatihanID' => $this->siriLatihanID])
                ->one();   
        
        return $checkHadir;
        
    }
    
    public function getCheckHadir2(){
        
        $checkHadir = Kehadiran::find()
                ->joinWith('sasaran9')
                ->where(['staffID' => $this->staffID])
                ->andWhere(['siriLatihanID' => $this->siriLatihanID])
                ->count();
        
        if ($checkHadir > 0){
            return 2; //hadir
        } else {
            return 1; //belum hadir
        }
        
    }
    
    public function getCheckBorangpl(){
        
        $checkBorangpl = BorangPenilaianLatihan::find()
                ->joinWith('sasaranSiriK')
                ->where(['pesertaID' => $this->staffID])
                ->andWhere(['statusBorang' => '1'])
                ->andWhere(['YEAR(tarikhMula)' => date('Y')])
                ->one();
        
        return $checkBorangpl;
        
    }
    
    public function CheckBorangStatus($siriID){
        
        $checkBorang = BorangPenilaianLatihan::find()
                ->where(['pesertaID' => $this->staffID])
                ->andWhere(['siriLatihanID' => $siriID])
                ->one();
        
        return $checkBorang->statusBorang;
        
    }
    
    public function Kategori($gredID){
        
       $data = KursusSasaran::find()
               ->where(['gredJawatanID' => $gredID])
               ->andWhere(['siriLatihanID' => $this->siriLatihanID])->one();
       
       return $data->kategori->kategori_nama;
    }
    
    public function getTarikhSahKehadiran(){
        
        $myDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $this->tarikhSahHadir);
        $formatteddate = $myDateTime->format('d-m-Y');
        
        return $formatteddate;
    }

    public static function totalPendingd($icno, $category) {

        $total = 0;
        
//        if($category !=0){
//        $model = Kontrak::find()->where(['ver_by' => $icno, 'status' => '1'])->orWhere(['app_by' => $icno, 'status' => '2','job_category'=>$category])->all();
//        if ($model) {
//            $total = count($model);
//        }
//        }
//        else{
//            $total = count($model = Kontrak::find()->where(['ver_by' => $icno, 'status' => '1'])->orWhere(['app_by' => $icno, 'status' => '2'])->all());
//        }
//        
//        if ($total > 0) {
//                return '&nbsp;<span class="badge bg-red">'.$total.'</span>';
//            }
//        else {
//                return '';
//        }
        
        if ($category == 2){
        
            $baruList = PermohonanLatihan::find()
                    ->joinWith('sasaran2')
                    ->where(['statusPermohonan' => 'BARU'])
                    ->andWhere(['peraku_icno' => $icno])
                    ->andWhere(['YEAR(tarikhPermohonan)' => date('Y')])
                    ->count();

            $baruListKursusLuar = PermohonanKursusLuar::find()
                    ->joinWith('biodata.department')
                    ->where(['chief' => $icno])
                    ->andWhere(['statusPermohonan' => '1', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();

            $total2 = $baruList + $baruListKursusLuar;

            if ($total2 > 0) {
                    
                    //$total = $total + $total2;
                    return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
                    //return $total;
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 1){
            
            $baruList = PermohonanLatihan::find()
                ->joinWith('sasaran2')
                ->where(['statusPermohonan' => 'DIPERAKUI'])
                ->andWhere(['pelulus_icno' => $icno])
                ->andWhere(['YEAR(tarikhPermohonan)' => date('Y')])
                ->count();
        
            if ($baruList > 0) {
                
                    //$total = $total + $baruList;
                    return '&nbsp;<span class="badge bg-red">'.$baruList.'</span>';
                    //return $total;
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 0){
            
            $baruList3 = PermohonanLatihan::find()
                    ->joinWith('sasaran2')
                    ->where(['statusPermohonan' => 'BARU'])
                    ->andWhere(['peraku_icno' => $icno])
                    ->andWhere(['YEAR(tarikhPermohonan)' => date('Y')])
                    ->count();

            $baruListKursusLuar = PermohonanKursusLuar::find()
                    ->joinWith('biodata.department')
                    ->where(['chief' => $icno])
                    ->andWhere(['=', 'statusPermohonan', '1'])
                    ->andWhere(['YEAR(tarikhPohon)' => date('Y')])
                    ->count();
            
            $baruListKursusLuarp = PermohonanKursusLuar::find()
                    ->where(['=', 'statusPermohonan', '6'])
                    ->andWhere(['YEAR(tarikhPohon)' => date('Y')])
                    ->count();
            
            $baruListKursusLuars = PermohonanKursusLuar::find()
                    ->where(['statusPermohonan' => '7', 'YEAR(tarikhPohon)' => date('Y')])
                    ->orWhere(['statusPermohonan' => '8', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();

            $baruList = PermohonanLatihan::find()
                ->joinWith('sasaran2')
                ->where(['statusPermohonan' => 'DIPERAKUI'])
                ->andWhere(['pelulus_icno' => $icno])
                ->andWhere(['YEAR(tarikhPermohonan)' => date('Y')])
                ->count();
            
            /** total pending surat kursus luar **/
            $pentadbiranp = SuratKursusLuar::find()
                        ->joinWith('permohonanLulus.biodata.jawatan')
                        ->where(['job_category' => 2])
                        ->andWhere(['status_ul' => '1', 'status_pl' => '0', 'YEAR(tarikhPohon)' => date('Y')])
                        ->count();

            $akademikp = SuratKursusLuar::find()
                        ->joinWith('permohonanLulus.biodata.jawatan')
                        ->where(['job_category' => 1])
                        ->andWhere(['status_ul' => '1', 'status_pl' => '0', 'YEAR(tarikhPohon)' => date('Y')])
                        ->count();

            /*****/
            
            /**
            $baruList4 = PermohonanMataIdpIndividu::find()
                ->joinWith('biodata.department')
                ->where(['chief' => $icno, 'statusPermohonan' => '1'])
                ->orWhere(['department.pp' => $icno, 'statusPermohonan' => '9'])
                ->count();
             * 
             */
            
            /** cross-server **/
            $baruList4 = PermohonanMataIdpIndividu::find()
                    ->where(['YEAR(tarikhPohon)' => date('Y')])
                    ->all();
        
            $test = Department::find()
                ->where(['chief' => $icno])
                ->orWhere(['pp' => $icno, 'id' => '164']) //HUMS
                ->all();
            
            $nc = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['id' => '2', 'Status' => '1', 'ICNO' => $icno])
                ->one();
            
//            if (!$test){
//        
//                $testx = Department::find()
//                    ->where(['pp' => $icno])
//                    ->all();
//            
//            }

            $senaraiPemohon = [];
            $senaraiPemohonx = [];
            foreach ($baruList4 as $baruListt) {

                $modelB = Tblprcobiodata::find()
                        ->where(['ICNO' => $baruListt->pemohonID])
                        ->one();

                if ($test){
                    foreach ($test as $test2) {
                        if ($modelB->DeptId == $test2->id) {
                            array_push($senaraiPemohon, $baruListt->pemohonID);
                        }
                    }
                }
            
//                else { 
//                    if ($testx){
//                        foreach ($testx as $test2) {
//                            if ($modelB->DeptId == $test2->id) {
//                                array_push($senaraiPemohonx, $baruListt->pemohonID);
//                            }
//                        }
//                    }
//                }
            }

            if ($test){
        
                $baruList44 = PermohonanMataIdpIndividu::find()
                        ->where(['statusPermohonan' => '1', 'pemohonID' => $senaraiPemohon, 'YEAR(tarikhPohon)' => date('Y')])
                        ->orWhere(['statusPermohonan' => '9', 'pemohonID' => $senaraiPemohon, 'YEAR(tarikhPohon)' => date('Y')])
                        ->count();
            }

//            else {
//                if ($testx){
//                    $baruList44 = PermohonanMataIdpIndividu::find()
//                            ->where(['statusPermohonan' => '9', 'pemohonID' => $senaraiPemohonx])
//                            ->count();
//                }
//            }
            
            if ($nc){
                $baruList44 = PermohonanMataIdpIndividu::find()
                        ->where(['statusPermohonan' => '17', 'YEAR(tarikhPohon)' => date('Y')])
                        ->count();
            }
 
            /****/
            
            $senaraiPemohon2 = PermohonanMataIdpIndividu::find()
                    ->where(['statusPermohonan' => '3', 'YEAR(tarikhPohon)' => date('Y')])
                    ->orWhere(['statusPermohonan' => '33', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();
            
            $senaraiPemohon3 = PermohonanMataIdpIndividu::find()
                    ->where(['statusPermohonan' => '4', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();
            
            $user = Yii::$app->user->getId();

            $findUser = UserAccess::find()->where(['userID' => $user])->one();
            
            if ($icno == '861109496113'){
            
                $total2 = $baruList3 + $baruListKursusLuar + $baruList + $senaraiPemohon2 + $baruListKursusLuarp + $pentadbiranp + $akademikp;
            } elseif ($icno == '731119125636') {
                $total2 = $baruList3 + $baruListKursusLuar + $baruList + $senaraiPemohon3 + $baruListKursusLuars;
            } else {
                
                //if ($test || $testx){
                if ($test || $nc){
                    $total2 = $baruList3 + $baruListKursusLuar + $baruList + $baruList44;
                } else {
                    $total2 = $baruList3 + $baruListKursusLuar + $baruList;
                }
            }
        
            if ($total2 > 0) {
                
                    //$total = $total + $baruList;
                    return $total2;
                    //return $total;
                }
            else {
                    return ' ';
            }
            
        } 
        
        if ($total != 0){
            return $total;
        }
                
    }
    
    public static function totalPending($icno, $category) {

        $total = 0;
        
        if ($category == 2){
        
            $baruList = PermohonanLatihan::find()
                    ->joinWith('sasaran2')
                    ->where(['statusPermohonan' => 'BARU'])
                    ->andWhere(['peraku_icno' => $icno])
                    ->andWhere(['YEAR(tarikhPermohonan)' => date('Y')])
                    ->count();

            $baruListKursusLuar = PermohonanKursusLuar::find()
                    ->joinWith('biodata.department')
                    ->where(['chief' => $icno])
                    ->andWhere(['statusPermohonan' => '1', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();

            $total2 = $baruList + $baruListKursusLuar;

            if ($total2 > 0) {
                    
                    //$total = $total + $total2;
                    return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
                    //return $total;
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 1){
            
            $baruList = PermohonanLatihan::find()
                ->joinWith('sasaran2')
                ->where(['statusPermohonan' => 'DIPERAKUI'])
                ->andWhere(['pelulus_icno' => $icno])
                ->andWhere(['YEAR(tarikhPermohonan)' => date('Y')])
                ->count();
        
            if ($baruList > 0) {
                
                    //$total = $total + $baruList;
                    return '&nbsp;<span class="badge bg-red">'.$baruList.'</span>';
                    //return $total;
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 0){
            
            $baruList3 = PermohonanLatihan::find()
                    ->joinWith('sasaran2')
                    ->where(['statusPermohonan' => 'BARU'])
                    ->andWhere(['peraku_icno' => $icno])
                    ->andWhere(['YEAR(tarikhPermohonan)' => date('Y')])
                    ->count();

            $baruListKursusLuar = PermohonanKursusLuar::find()
                    ->joinWith('biodata.department')
                    ->where(['chief' => $icno])
                    ->andWhere(['=', 'statusPermohonan', '1'])
                    ->andWhere(['YEAR(tarikhPohon)' => date('Y')])
                    ->count();
            
            $baruListKursusLuarp = PermohonanKursusLuar::find()
                    ->where(['=', 'statusPermohonan', '6'])
                    ->andWhere(['YEAR(tarikhPohon)' => date('Y')])
                    ->count();
            
            $baruListKursusLuars = PermohonanKursusLuar::find()
                    ->where(['statusPermohonan' => '7', 'YEAR(tarikhPohon)' => date('Y')])
                    ->orWhere(['statusPermohonan' => '8', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();

            $baruList = PermohonanLatihan::find()
                ->joinWith('sasaran2')
                ->where(['statusPermohonan' => 'DIPERAKUI'])
                ->andWhere(['pelulus_icno' => $icno])
                ->andWhere(['YEAR(tarikhPermohonan)' => date('Y')])
                ->count();
            
            /** total pending surat kursus luar **/
            $pentadbiranp = SuratKursusLuar::find()
                        ->joinWith('permohonanLulus.biodata.jawatan')
                        ->where(['job_category' => 2])
                        ->andWhere(['status_ul' => '1', 'status_pl' => '0', 'YEAR(tarikhPohon)' => date('Y')])
                        ->count();

            $akademikp = SuratKursusLuar::find()
                        ->joinWith('permohonanLulus.biodata.jawatan')
                        ->where(['job_category' => 1])
                        ->andWhere(['status_ul' => '1', 'status_pl' => '0', 'YEAR(tarikhPohon)' => date('Y')])
                        ->count();

            /*****/
            
            /**
            $baruList4 = PermohonanMataIdpIndividu::find()
                ->joinWith('biodata.department')
                ->where(['chief' => $icno, 'statusPermohonan' => '1'])
                ->orWhere(['department.pp' => $icno, 'statusPermohonan' => '9'])
                ->count();
             * 
             */
            
            /** cross-server **/
            $baruList4 = PermohonanMataIdpIndividu::find()
                    ->where(['YEAR(tarikhPohon)' => date('Y')])
                    ->all();
        
            $test = Department::find()
                ->where(['chief' => $icno])
                ->orWhere(['pp' => $icno, 'id' => '164']) //HUMS
                ->all();
            
            $nc = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['id' => '2', 'Status' => '1', 'ICNO' => $icno])
                ->one();
            
//            if (!$test){
//        
//                $testx = Department::find()
//                    ->where(['pp' => $icno])
//                    ->all();
//            
//            }

            $senaraiPemohon = [];
            $senaraiPemohonx = [];
            foreach ($baruList4 as $baruListt) {

                $modelB = Tblprcobiodata::find()
                        ->where(['ICNO' => $baruListt->pemohonID])
                        ->one();

                if ($test){
                    foreach ($test as $test2) {
                        if ($modelB->DeptId == $test2->id) {
                            array_push($senaraiPemohon, $baruListt->pemohonID);
                        }
                    }
                }
            
//                else { 
//                    if ($testx){
//                        foreach ($testx as $test2) {
//                            if ($modelB->DeptId == $test2->id) {
//                                array_push($senaraiPemohonx, $baruListt->pemohonID);
//                            }
//                        }
//                    }
//                }
            }

            if ($test){
        
                $baruList44 = PermohonanMataIdpIndividu::find()
                        ->where(['statusPermohonan' => '1', 'pemohonID' => $senaraiPemohon, 'YEAR(tarikhPohon)' => date('Y')])
                        ->orWhere(['statusPermohonan' => '9', 'pemohonID' => $senaraiPemohon, 'YEAR(tarikhPohon)' => date('Y')])
                        ->count();
            }

//            else {
//                if ($testx){
//                    $baruList44 = PermohonanMataIdpIndividu::find()
//                            ->where(['statusPermohonan' => '9', 'pemohonID' => $senaraiPemohonx])
//                            ->count();
//                }
//            }
            
            if ($nc){
                $baruList44 = PermohonanMataIdpIndividu::find()
                        ->where(['statusPermohonan' => '17', 'YEAR(tarikhPohon)' => date('Y')])
                        ->count();
            }
 
            /****/
            
            $senaraiPemohon2 = PermohonanMataIdpIndividu::find()
                    ->where(['statusPermohonan' => '3', 'YEAR(tarikhPohon)' => date('Y')])
                    ->orWhere(['statusPermohonan' => '33', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();
            
            $senaraiPemohon3 = PermohonanMataIdpIndividu::find()
                    ->where(['statusPermohonan' => '4', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();
            
            $user = Yii::$app->user->getId();

            $findUser = UserAccess::find()->where(['userID' => $user])->one();
            
            if ($icno == '861109496113'){
            
                $total2 = $baruList3 + $baruListKursusLuar + $baruList + $senaraiPemohon2 + $baruListKursusLuarp + $pentadbiranp + $akademikp;
            } elseif ($icno == '731119125636') {
                $total2 = $baruList3 + $baruListKursusLuar + $baruList + $senaraiPemohon3 + $baruListKursusLuars;
            } else {
                
                //if ($test || $testx){
                if ($test || $nc){
                    $total2 = $baruList3 + $baruListKursusLuar + $baruList + $baruList44;
                } else {
                    $total2 = $baruList3 + $baruListKursusLuar + $baruList;
                }
            }
        
            if ($total2 > 0) {
                
                    //$total = $total + $baruList;
                    return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
                    //return $total;
                }
            else {
                    return ' ';
            }
            
        } 
        
        if ($total != 0){
            return $total;
        }
                
    }
    
    public function calculatePemohon($siriID)
    {
        $totalpemohon = PermohonanLatihan::find()
                    ->where(['siriLatihanID' => $siriID])
                    ->count();
        
        return $totalpemohon;
        
    }

    public function calculatePemohonByMonth($month, $year)
    {
        $totalpeserta = PermohonanLatihan::find()
                    ->joinWith('sasaran6.sasaran3')
                    ->where(['MONTH(tarikhMula)' => $month, 'YEAR(tarikhMula)' => $year, 'jenisLatihanID' => 'latihanDalaman'])
                    ->count();
        
        return $totalpeserta;
        
    }
    
    public function calculateSahHadir($siriID)
    {
        $totalpemohon = PermohonanLatihan::find()
                    ->where(['siriLatihanID' => $siriID])
                    ->andWhere(['sahHadirbyStaf' => 'YA'])
                    ->count();
        
        return $totalpemohon;
        
    }
    
    public function calculateSahTidakHadir($siriID)
    {
        $totalpemohon = PermohonanLatihan::find()
                    ->where(['siriLatihanID' => $siriID])
                    ->andWhere(['sahHadirbyStaf' => 'TIDAK'])
                    ->count();
        
        return $totalpemohon;
        
    }
    
    public function getJenisKursus(){

        $a = "TIADA DATA";
        
        if ($this->kategoriKursusID != 0){
            
            
            if ($this->kategoriKursusID == 1){
                $a = '<span class="label label-default">UMUM</span>';    
            } elseif ($this->kategoriKursusID == 3) {
                $a = '<span class="label label-danger">TERAS</span>';
            } elseif ($this->kategoriKursusID == 4) {
                $a = '<span class="label label-danger">ELEKTIF</span>';
            } elseif ($this->kategoriKursusID == 5) {
                $a = '<span class="label label-success">TERAS UNIVERSITI</span>';
            } elseif ($this->kategoriKursusID == 6) {
                $a = '<span class="label label-danger">TERAS SKIM</span>';
            } elseif ($this->kategoriKursusID == 7) {
                $a = '<span class="label label-success">IMPAK TINGGI</span>';
            }
            
            return $a;
            
        } else {
            
            //$a = '<span class="label label-success">BUKAN SASARAN</span>';
            $a = Html::button('UBAH', ['value' => 'ubah-jenis-kursus?slotID='.$this->slotID.'&peserta='.$this->staffID, 'class' => 'mapBtn btn-sm btn-danger btn-block']);
            
            return $a;
            
        }    
    }
}
