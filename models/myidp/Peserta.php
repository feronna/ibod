<?php

namespace app\models\myidp;

use Yii;
use yii\helpers\Html;
use app\models\myidp\UserAccess;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "{{%myidp.tbl_peserta}}".
 *
 * @property int $permohonanID
 * @property string $staffID
 * @property int $statusKehadiran 1 => APPROVED, 2 => REJECTED
 * @property int $kategoriKursusID
 * @property int $status 1 => BARU, 2 => PL, 3 => KS
 * @property int $jumlahJamHadir
 * @property string $statusUL
 * @property int $mataIDPcadangan
 * @property int $mataIDPlulus
 * @property string $statusPL
 * @property string $statusKS
 */
class Peserta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_tbl_peserta}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permohonanID', 'staffID'], 'required'],
            [['permohonanID', 'statusKehadiran', 'kategoriKursusID', 'status', 'jumlahJamHadir', 'mataIDPcadangan', 'mataIDPlulus', 'kompetensiLulus'], 'integer'],
            [['staffID'], 'string', 'max' => 12],
            [['statusUL', 'statusPL', 'statusKS'], 'string', 'max' => 2],
            [['permohonanID', 'staffID'], 'unique', 'targetAttribute' => ['permohonanID', 'staffID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'permohonanID' => 'Permohonan ID',
            'staffID' => 'Staff ID',
            'statusKehadiran' => 'Status Kehadiran',
            'kategoriKursusID' => 'Kategori Kursus ID',
            'status' => 'Status',
            'jumlahJamHadir' => 'Jumlah Jam Hadir',
            'statusUL' => 'Status Ul',
            'mataIDPcadangan' => 'Mata Id Pcadangan',
            'mataIDPlulus' => 'Mata Id Plulus',
            'statusPL' => 'Status Pl',
            'statusKS' => 'Status Ks',
            'kompetensiLulus' => 'Kompetensi Lulus',
        ];
    }
    
    /** Relation **/
    public function getSasaran9(){
        return $this->hasOne(PermohonanMataIdpIndividu::className(), ['permohonanID' => 'permohonanID']);
    }

    public function getBiodata()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staffID']);
    }
    
    public function getLuluss(){
        
        $a = "TIADA DATA";
        
        if ($this->kompetensiLulus == '1'){
            $a = '<span class="label label-default">UMUM</span>';    
        } elseif ($this->kompetensiLulus == '3') {
            $a = '<span class="label label-info">TERAS</span>';
        } elseif ($this->kompetensiLulus == '4') {
            $a = '<span class="label label-primary">ELEKTIF</span>';
        } elseif ($this->kompetensiLulus == '5') {
            $a = '<span class="label label-success">WAJIB-TERAS-UNIVERSITI</span>';
        } elseif ($this->kompetensiLulus == '6') {
            $a = '<span class="label label-danger">WAJIB-TERAS-SKIM</span>';
        } elseif ($this->kompetensiLulus == '7') {
            $a = '<span class="label label-warning">KURSUS BERIMPAK TINGGI</span>';
        }  
        
        return $a;
        
    }
    
    public function getKompetensii(){
        
        $a = "TIADA DATA";
        
        if ($this->kategoriKursusID == '1'){
            $a = '<span class="label label-default">UMUM</span>';    
        } elseif ($this->kategoriKursusID == '3') {
            $a = '<span class="label label-info">TERAS</span>';
        } elseif ($this->kategoriKursusID == '4') {
            $a = '<span class="label label-primary">ELEKTIF</span>';
        } elseif ($this->kategoriKursusID == '5') {
            $a = '<span class="label label-success">WAJIB-TERAS-UNIVERSITI</span>';
        } elseif ($this->kategoriKursusID == '6') {
            $a = '<span class="label label-danger">WAJIB-TERAS-SKIM</span>';
        } elseif ($this->kategoriKursusID == '7') {
            $a = '<span class="label label-warning">KURSUS BERIMPAK TINGGI</span>';
        }  
        
        return $a;
        
    }
    
    public function getKompetensiLuluss(){

        $a = "";
        
        if ($this->kompetensiLulus == NULL){
            $a = $this->kompetensii;
        } else {
            $a = $this->luluss;
        }
        
        if ($this->statusKS == 0){
            return $a.'&nbsp;'.Html::button('<i class="fa fa-cog"></i>', ['value' => 'ubah-jenis-kursusss?permohonanID='.$this->permohonanID.'&peserta='.$this->staffID.'&status=3', 'class' => 'mapBtn btn-sm btn-default']);
        } else {
            return $a;
        }
        
    }
    
    public function getKompetensiCadangan(){

        $a = "";
        
        if (empty($this->sasaran9->kompetensiCadangan)){
            
            if ($this->status == 2 || $this->status == 3 ){
            
                $a = $this->kompetensii;
                
            } else {
                $a = $this->sasaran9->kompetensii;
            }
            
        } else {
            
            if ($this->status == 1){
            
                $a = $this->sasaran9->kompetensiiCadangan;
                
            } else {
                $a = $this->kompetensii;
            }
            
        }
        
        if ($this->statusPL != 1){
            return $a.'&nbsp;'.Html::button('<i class="fa fa-cog"></i>', ['value' => 'ubah-jenis-kursuss?permohonanID='.$this->permohonanID.'&peserta='.$this->staffID.'&status=2', 'class' => 'mapBtn btn-sm btn-default']);
        } else {
            return $a;
        }
        
    }
    
    public function getJenisKursus(){

        $a = "";
        
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
            
        } else {
            
            $checkKompetensi = PermohonanMataIdpIndividu::find()
                    ->where(['permohonanID' => $this->permohonanID])
                    ->one();
            
            if ($checkKompetensi->kompetensiPohon == NULL){
                $a = Html::button('<i class="fa fa-cog"></i>', ['value' => 'ubah-jenis-kursuss?permohonanID='.$this->permohonanID.'&peserta='.$this->staffID, 'class' => 'mapBtn btn-sm btn-default']);
            } else {
                $a = $this->sasaran9->kompetensii;
                $this->kategoriKursusID = $checkKompetensi->kompetensiPohon;
                $this->save(false);
            }
            
        }
        
        return $a.'&nbsp;'.Html::button('<i class="fa fa-cog"></i>', ['value' => 'ubah-jenis-kursuss?permohonanID='.$this->permohonanID.'&peserta='.$this->staffID, 'class' => 'mapBtn btn-sm btn-default']);
    }
    
    public function getStatusKehadirann(){
        
        $userID = Yii::$app->user->getId();
        
        $checkUserLevel = Department::find()->where(['chief' => $userID])->one();

        $a = "HADIR";
        
        if ($this->statusKehadiran != 0){
            
            if ($this->statusKehadiran == 1){
                $a = '<span class="label label-success">HADIR</span>';    
            } elseif ($this->statusKehadiran == 2) {
                $a = '<span class="label label-danger">TIDAK HADIR</span>';
            } 
            
        }
        
        if ($checkUserLevel){
            if (!$this->sasaran9->tarikhSemakanKJ){
                return $a.'&nbsp;'.Html::button('<i class="fa fa-cog"></i>', ['value' => 'ubah-status-kehadiran?permohonanID='.$this->permohonanID.'&peserta='.$this->staffID, 'class' => 'mapBtn btn-sm btn-default']);
            } else {
                return $a;
            }
        } else {
            
            $checkUser = UserAccess::find()
                    ->where(['userID' => $userID, 'userType' => 'ul'])
                    ->one();
            
            if (!$this->sasaran9->tarikhSemakanBSM && !$checkUser){
                return $a.'&nbsp;'.Html::button('<i class="fa fa-cog"></i>', ['value' => 'ubah-status-kehadiran?permohonanID='.$this->permohonanID.'&peserta='.$this->staffID, 'class' => 'mapBtn btn-sm btn-default']);
            } else {
                return $a;
            }
        }
        

    }

    public static function countKursusByStaffCategory($kumpulan, $category, $year, $stafftype)
    {
        $count = 0;
        $query = Peserta::find()->joinWith('sasaran9'); 

        if ($category == 0) { //jumlah pemohon (pengurusan)

            $query->joinWith('biodata.jawatan.skimPerkhidmatan')
                ->where(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '1', 'job_category' => $stafftype])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '2', 'job_category' => $stafftype])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '3', 'job_category' => $stafftype])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '4', 'job_category' => $stafftype]);

            $count = $query->count();

        } elseif ($category == 1) { //jumlah pemohon (pelaksana/sokongan)

            $query->joinWith('biodata.jawatan.skimPerkhidmatan')
                ->where(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '5', 'job_category' => $stafftype])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '6', 'job_category' => $stafftype]);

            $count = $query->count();

        } elseif ($category == 2) { //jumlah lulus (pengurusan)

            $query->joinWith('biodata.jawatan.skimPerkhidmatan')
                ->where(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '1', 'job_category' => $stafftype, 'statusSektor' => '4'])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '2', 'job_category' => $stafftype, 'statusSektor' => '4'])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '3', 'job_category' => $stafftype, 'statusSektor' => '4'])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '4', 'job_category' => $stafftype, 'statusSektor' => '4']);

            $count = $query->count();

        } elseif ($category == 3) { //jumlah lulus (pelaksana/sokongan)

            $query->joinWith('biodata.jawatan.skimPerkhidmatan')
                ->where(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '5', 'job_category' => $stafftype, 'statusSektor' => '4'])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '6', 'job_category' => $stafftype, 'statusSektor' => '4']);

            $count = $query->count();

        }

        return $count;
    }

}
