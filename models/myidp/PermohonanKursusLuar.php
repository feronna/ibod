<?php

namespace app\models\myidp;

use Yii;
use DateTime;
use yii\helpers\Html;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\myidp\UserAccess;
use app\models\myidp\SuratKursusLuar;

/**
 * This is the model class for table "myidp.permohonanKursusLuar".
 *
 * @property int $permohonanID
 * @property string $pemohonID
 * @property string $jenisPenganjur
 * @property string $namaPenganjur
 * @property string $disemakOleh
 * @property string $tarikhKelulusan
 * @property string $diluluskanOleh
 * @property string $layakYuran
 * @property string $layakTiketPenerbangan
 * @property string $namaProgram
 * @property string $tarikhMula
 * @property string $tarikhTamat
 * @property string $lokasi
 * @property string $jumlahYuran
 * @property string $jumlahTiketPenerbangan
 * @property string $jumlahPenginapan
 * @property string $aspekTugasUtama
 * @property string $failProgram1
 * @property string $failProgram2
 * @property string $failProgram3
 * @property string $statusPermohonan
 * @property string $tarikhPohon
 * @property string $tarikhDisemak
 * @property string $layakPenginapan
 * @property string $syorYuran
 * @property string $syorTiketPenerbangan
 * @property string $syorPenginapan
 * @property string $tarikhBatalPermohonan
 * @property string $tarikhSemakanKJ
 * @property string $tarikhSemakanUL
 * @property string $tarikhSemakanBSM
 * @property string $kjPenyemak
 * @property string $ulasanKJ
 * @property string $ulasanUL
 * @property string $ulasanBSM
 * @property string $statusKJ
 * @property string $statusUL
 * @property string $statusBSM
 */
class PermohonanKursusLuar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    public $file1;
    public $file2;
    public $file3;
    
    public static function tableName()
    {
        return 'hrd.idp_permohonanKursusLuar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pemohonID', 'jenisPenganjur', 'namaPenganjur', 'namaProgram', 'tarikhMula', 'tarikhTamat', 'lokasi', 'aspekTugasUtama'], 'required'],
            [['tarikhKelulusan', 'tarikhMula', 'tarikhTamat', 'tarikhPohon', 'tarikhDisemak', 'tarikhBatalPermohonan', 'tarikhSemakanKJ', 'tarikhSemakanUL', 'tarikhSemakanBSM'], 'safe'],
            [['layakYuran', 'layakTiketPenerbangan', 'jumlahYuran', 'jumlahTiketPenerbangan', 'jumlahPenginapan', 'layakPenginapan', 'syorYuran', 'syorTiketPenerbangan', 'syorPenginapan', 'lulusYuran', 'lulusTiket', 'lulusPenginapan'], 'number'],
            [['aspekTugasUtama', 'ulasanKJ', 'ulasanUL', 'ulasanBSM', 'ulasanSektor'], 'string'],
            [['pemohonID', 'disemakOleh', 'diluluskanOleh', 'kjPenyemak', 'diperakuOleh'], 'string', 'max' => 12],
            [['jenisPenganjur'], 'string', 'max' => 25],
            [['namaPenganjur', 'namaProgram', 'lokasi', 'failProgram1', 'failProgram2', 'failProgram3'], 'string', 'max' => 100],
            [['statusPermohonan', 'statusKJ', 'statusUL', 'statusBSM', 'statusSektor'], 'string', 'max' => 2],
            [['file1, file2, file3'], 'file','extensions'=>'pdf, png, jpg, jpeg', 'maxFiles' => 2],
            [['kategori_latihan', 'peringkat'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'permohonanID' => Yii::t('app', 'Permohonan ID'),
            'pemohonID' => Yii::t('app', 'Pemohon ID'),
            'jenisPenganjur' => Yii::t('app', 'Jenis Penganjur'),
            'namaPenganjur' => Yii::t('app', 'Nama Penganjur'),
            'disemakOleh' => Yii::t('app', 'Disemak Oleh'),
            'tarikhKelulusan' => Yii::t('app', 'Tarikh Kelulusan'),
            'diluluskanOleh' => Yii::t('app', 'Diluluskan Oleh'),
            'layakYuran' => Yii::t('app', 'Layak Yuran'),
            'layakTiketPenerbangan' => Yii::t('app', 'Layak Tiket Penerbangan'),
            'namaProgram' => Yii::t('app', 'Nama Program'),
            'tarikhMula' => Yii::t('app', 'Tarikh Mula'),
            'tarikhTamat' => Yii::t('app', 'Tarikh Tamat'),
            'lokasi' => Yii::t('app', 'Lokasi'),
            'jumlahYuran' => Yii::t('app', 'Jumlah Yuran'),
            'jumlahTiketPenerbangan' => Yii::t('app', 'Jumlah Tiket Penerbangan'),
            'jumlahPenginapan' => Yii::t('app', 'Jumlah Penginapan'),
            'aspekTugasUtama' => Yii::t('app', 'Aspek Tugas Utama'),
            'failProgram1' => Yii::t('app', 'Fail Program1'),
            'failProgram2' => Yii::t('app', 'Fail Program2'),
            'failProgram3' => Yii::t('app', 'Fail Program3'),
            'statusPermohonan' => Yii::t('app', 'Status Permohonan'),
            'tarikhPohon' => Yii::t('app', 'Tarikh Pohon'),
            'tarikhDisemak' => Yii::t('app', 'Tarikh Disemak'),
            'layakPenginapan' => Yii::t('app', 'Layak Penginapan'),
            'syorYuran' => Yii::t('app', 'Syor Yuran'),
            'syorTiketPenerbangan' => Yii::t('app', 'Syor Tiket Penerbangan'),
            'syorPenginapan' => Yii::t('app', 'Syor Penginapan'),
            'tarikhBatalPermohonan' => Yii::t('app', 'Tarikh Batal Permohonan'),
            'tarikhSemakanKJ' => Yii::t('app', 'Tarikh Semakan Kj'),
            'tarikhSemakanUL' => Yii::t('app', 'Tarikh Semakan Ul'),
            'tarikhSemakanBSM' => Yii::t('app', 'Tarikh Semakan Bsm'),
            'kjPenyemak' => Yii::t('app', 'Kj Penyemak'),
            'ulasanKJ' => Yii::t('app', 'Ulasan Kj'),
            'ulasanUL' => Yii::t('app', 'Ulasan Ul'),
            'ulasanBSM' => Yii::t('app', 'Ulasan Bsm'),
            'statusKJ' => Yii::t('app', 'Status Kj'),
            'statusUL' => Yii::t('app', 'Status Ul'),
            'statusBSM' => Yii::t('app', 'Status Bsm'),
            'statusSektor' => Yii::t('app', 'Status Sektor'),
            'lulusYuran' => Yii::t('app', 'Lulus Yuran'),
            'lulusTiket' => Yii::t('app', 'Lulus Tiket'),
            'lulusPenginapan' => Yii::t('app', 'Lulus Penginapan'),
            'ulasanSektor' => Yii::t('app', 'Ulasan Sektor'),
            'diperakuOleh' => Yii::t('app', 'Diperakukan Oleh'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PermohonanKursusLuarQuery the active query used by this AR class.
     */
//    public static function find()
//    {
//        return new PermohonanKursusLuarQuery(get_called_class());
//    }
    
    public function getDisplayLink() {
        if(!empty($this->failProgram1) && $this->failProgram1 != 'deleted'){
        return Html::a(Yii::$app->FileManager->NameFile($this->failProgram1), Yii::$app->FileManager->DisplayFile($this->failProgram1));
        }
        return 'File not exist!';
    }
    
    public function getDisplayLink2() {
        if(!empty($this->failProgram2) && $this->failProgram2 != 'deleted'){
        return Html::a(Yii::$app->FileManager->NameFile($this->failProgram2), Yii::$app->FileManager->DisplayFile($this->failProgram2));
        }
        return 'File not exist!';
    }
    
    public function getDisplayLink3() {
        if(!empty($this->failProgram3) && $this->failProgram3 != 'deleted'){
        return Html::a(Yii::$app->FileManager->NameFile($this->failProgram3), Yii::$app->FileManager->DisplayFile($this->failProgram3));
        }
        return 'File not exist!';
    }
    
    public function getSasaran2(){
        return $this->hasOne(Department::className(), ['pemohon_icno' => 'staffID']);
    }
    
    public function getBiodata(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pemohonID']);
    }
    
    public function getStatusPermohonann(){
        
        $a = "TIADA DATA";
        
        if ($this->statusPermohonan == '1'){
            $a = '<span class="label label-default">MENUNGGU PENGESAHAN KJ</span>';    
        } elseif ($this->statusPermohonan == '2') {
            $a = '<span class="label label-danger">DIBATALKAN</span>';
        } elseif ($this->statusPermohonan == '3') {
            $a = '<span class="label label-danger">TIDAK DISAHKAN KJ</span>';
        } elseif ($this->statusPermohonan == '4') {
            $a = '<span class="label label-warning">MENUNGGU SEMAKAN</span>';
        } elseif ($this->statusPermohonan == '5') {
            //$a = '<span class="label label-primary">DISEMAK UNIT LATIHAN</span>';
            $a = '<span class="label label-info">MENUNGGU PERAKUAN</span>';
        } elseif ($this->statusPermohonan == '6') {
            //$a = '<span class="label label-primary">DISEMAK UNIT LATIHAN</span>';
            $a = '<span class="label label-info">MENUNGGU PERAKUAN</span>';
        } elseif ($this->statusPermohonan == '7') {
            $a = '<span class="label label-primary">MENUNGGU KELULUSAN</span>';
        } elseif ($this->statusPermohonan == '8') {
            $a = '<span class="label label-primary">MENUNGGU KELULUSAN</span>';
        } elseif ($this->statusPermohonan == '9') {
            $a = '<span class="label label-danger">PERMOHONAN DITOLAK</span>';
        } elseif ($this->statusPermohonan == '10') {
            $a = '<span class="label label-success">PERMOHONAN BERJAYA</span>';
        }
        
        return $a;
        
    }
    
    public function getStatusKJJ(){
        
        $a = "TIADA DATA";
        
        if ($this->statusKJ == '3') {
            $a = '<span class="label label-danger">TIDAK DIPERAKUI KJ</span>';
        } elseif ($this->statusKJ == '4') {
            $a = '<span class="label label-success">DIPERAKUI KJ</span>';
        } 
        
        return $a;
        
    }
    
    public function getStatusULL(){
        
        $a = "TIADA DATA";
        
        if ($this->statusUL == '5') {
            $a = '<span class="label label-danger">DISEMAK</span>';
        } elseif ($this->statusUL == '6') {
            $a = '<span class="label label-success">DISEMAK</span>';
        } 
        
        return $a;
        
    }
    
    public function getStatusBSMM(){
        
        $a = "TIADA DATA";
        
        if ($this->statusBSM == '7') {
            $a = '<span class="label label-danger">TIDAK LAYAK</span>';
        } elseif ($this->statusBSM == '8') {
            $a = '<span class="label label-success">LAYAK</span>';
        }
        
        return $a;
        
    }
    
    public function getStatusSektorr(){
        
        $a = "TIADA DATA";
        
        if ($this->statusSektor == '9') {
            $a = '<span class="label label-danger">TIDAK LULUS</span>';
        } elseif ($this->statusSektor == '10') {
            $a = '<span class="label label-success">LULUS</span>';
        }
        
        return $a;
        
    }
    
    public function getPenganjur(){
        
        $a = "TIADA DATA";
        
        if ($this->jenisPenganjur == '1') {
            $a = 'Agensi Luar (External Agencies)';
        } elseif ($this->jenisPenganjur == '2') {
            $a = 'UMS (JFPIU/Persatuan/Kesatuan/Kelab)';
        }
        
        return $a;
        
    }
    
    public function getJumlahLayakk(){
        
        //number_format($number, 2, '.', '');
        $j = number_format(($this->layakPenginapan + $this->layakTiketPenerbangan + $this->layakYuran), 2, '.', '');
        
        return $j;
        
    }
    
    public function getJumlahSyorr(){
        
        //number_format($number, 2, '.', '');
        $j = number_format(($this->syorPenginapan + $this->syorTiketPenerbangan + $this->syorYuran), 2, '.', '');
        
        return $j;
        
    }
    
    public function getJumlahLuluss(){
        
        //number_format($number, 2, '.', '');
        $j = number_format(($this->lulusPenginapan + $this->lulusTiket + $this->lulusYuran), 2, '.', '');
        
        return $j;
        
    }
    
    public static function totalPendingd($category) {

        $total = 0;
        
        //total pending surat 
        $akademikc = SuratKursusLuar::find()
                    ->joinWith('permohonanLulus.biodata.jawatan')
                    ->where(['job_category' => 1])
                    ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
                    ->select('idp_tbl_suratkursusluar.permohonanID');
        
        $akademikSurat = PermohonanKursusLuar::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['job_category' => 1])
                    ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
                    ->andWhere(['NOT IN','idp_permohonanKursusLuar.permohonanID', $akademikc])
                    ->count();
        
        $pentadbiranc = SuratKursusLuar::find()
                    ->joinWith('permohonanLulus.biodata.jawatan')
                    ->where(['job_category' => 2])
                    ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
                    ->select('idp_tbl_suratkursusluar.permohonanID');
        
        $pentadbiranSurat = PermohonanKursusLuar::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['job_category' => 2])
                    ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
                    ->andWhere(['NOT IN','idp_permohonanKursusLuar.permohonanID', $pentadbiranc])
                    ->count();
        /*********************************************************************/
        
        $akademik = PermohonanKursusLuar::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['job_category' => 1])
                    ->andWhere(['statusPermohonan' => '4', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();

        $pentadbiran = PermohonanKursusLuar::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['job_category' => 2])
                    ->andWhere(['statusPermohonan' => '4', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();
        
        $sahList = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '2', 'YEAR(tarikhPohon)' => date('Y')])
                ->count();
        
        $sahListP = PermohonanMataIdpIndividu::find()
                ->joinWith('biodata.jawatan')
                ->where(['statusPermohonan' => '2', 'YEAR(tarikhPohon)' => date('Y')])
                ->andWhere(['job_category' => 2])
                ->count();
        
//        $sahListA = PermohonanMataIdpIndividu::find()
//                ->joinWith('biodata.jawatan')
//                ->where(['=', 'statusPermohonan', '2'])
//                ->andWhere(['job_category' => 1])
//                ->count();
        
        /*** error cross-server **/
        $sahListAA = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '2', 'YEAR(tarikhPohon)' => date('Y')])
                ->all();
        
        $senarai = [];
        foreach ($sahListAA as $sahListAA) {
            if ($sahListAA->biodata->jawatan->job_category == 1) {
                    array_push($senarai, $sahListAA->pemohonID);
            }
        }
        
        $sahListA = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '2', 'YEAR(tarikhPohon)' => date('Y')])
                ->andWhere(['pemohonID' => $senarai])
                ->count();
        /***/
        
        /** pegawai latihan **/
        $pentadbiranp = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 2, 'statusPermohonan' => '6', 'YEAR(tarikhPohon)' => date('Y')])
                ->count();
        
        $akademikp = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 1, 'statusPermohonan' => '6', 'YEAR(tarikhPohon)' => date('Y')])
                ->count();

        /*****/
        /** ketua sektor **/
        $pentadbirans = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 2, 'statusPermohonan' => '7', 'YEAR(tarikhPohon)' => date('Y')])
                ->orWhere(['job_category' => 2, 'statusPermohonan' => '8', 'YEAR(tarikhPohon)' => date('Y')])
                ->count();
        
        $akademiks = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 1, 'statusPermohonan' => '7', 'YEAR(tarikhPohon)' => date('Y')])
                ->orWhere(['job_category' => 1, 'statusPermohonan' => '8', 'YEAR(tarikhPohon)' => date('Y')])
                ->count();

        /*****/

        if ($category == 2){ //pentadbiran

            $total2 = $pentadbiran;

            if ($total2 > 0) {
                
                    return $total2;
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 22){ //akademik

            $total2 = $akademik;

            if ($total2 > 0) {
                
                    return $total2;
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 1){
 
            if ($sahListP > 0) {
                
                    return $sahListP;
                }
            else {
                    return ' ';
            }     
        } elseif ($category == 0){
            
            $total3 = $akademik + $pentadbiran + $sahList + $akademikSurat + $pentadbiranSurat;
            
            if ($total3 > 0) {
                
                    return $total3;
                }
            else {
                    return ' ';
            }
        } elseif ($category == 4){ //totalakademik_ul

            $total3 = $akademik + $sahListA + $akademikSurat;
            
            if ($total3 > 0) {
                
                    return $total3;
                }
            else {
                    return ' ';
            }

        } elseif ($category == 44){ //totalpentadbiran_ul

            $total3 = $pentadbiran + $sahListP + $pentadbiranSurat;
            
            if ($total3 > 0) {
                
                    return $total3;
                }
            else {
                    return ' ';
            }

        } elseif ($category == 3){
 
            if ($sahListA > 0) {
                
                    return $sahListA;
                }
            else {
                    return ' ';
            }     
        } elseif ($category == 20){ //pentadbiran

            $total2 = $pentadbiranp;

            if ($total2 > 0) {
                
                    return $total2;
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 220){ //akademik

            $total2 = $akademikp;

            if ($total2 > 0) {
                
                    return $total2;
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 21){ //pentadbiran

            $total2 = $pentadbirans;

            if ($total2 > 0) {
                
                    return $total2;
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 221){ //akademik

            $total2 = $akademiks;

            if ($total2 > 0) {
                
                    return $total2;
                }
            else {
                    return ' ';
            }
            
        }
        
        if ($total != 0){
            return $total;
        }
                
    }

    public static function totalPendingPentadbiran() {

        $pentadbiran = PermohonanKursusLuar::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['job_category' => 2])
                    ->andWhere(['statusPermohonan' => '4', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();

        $total2 = $pentadbiran;

        if ($total2 > 0) {
            
            return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
        } else {
            return ' ';
        }

    }

    public static function totalPendingAkademik() {

        $akademik = PermohonanKursusLuar::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['job_category' => 1])
                    ->andWhere(['statusPermohonan' => '4', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();

        $total2 = $akademik;

        if ($total2 > 0) {
            
            return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
        } else {
            return ' ';
        }

    }
    
    public static function totalPending($category) {

        $total = 0;
        
        //total pending surat 
        $akademikc = SuratKursusLuar::find()
                    ->joinWith('permohonanLulus.biodata.jawatan')
                    ->where(['job_category' => 1])
                    ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
                    ->select('idp_tbl_suratkursusluar.permohonanID');
        
        $akademikSurat = PermohonanKursusLuar::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['job_category' => 1])
                    ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
                    ->andWhere(['NOT IN','idp_permohonanKursusLuar.permohonanID', $akademikc])
                    ->count();
        
        $pentadbiranc = SuratKursusLuar::find()
                    ->joinWith('permohonanLulus.biodata.jawatan')
                    ->where(['job_category' => 2])
                    ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
                    ->select('idp_tbl_suratkursusluar.permohonanID');
        
        $pentadbiranSurat = PermohonanKursusLuar::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['job_category' => 2])
                    ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
                    ->andWhere(['NOT IN','idp_permohonanKursusLuar.permohonanID', $pentadbiranc])
                    ->count();
        /*********************************************************************/
        
        $akademik = PermohonanKursusLuar::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['job_category' => 1])
                    ->andWhere(['statusPermohonan' => '4', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();

        $pentadbiran = PermohonanKursusLuar::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['job_category' => 2])
                    ->andWhere(['statusPermohonan' => '4', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();
        
        $sahList = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '2', 'YEAR(tarikhPohon)' => date('Y')])
                ->count();
        
        $sahListP = PermohonanMataIdpIndividu::find()
                ->joinWith('biodata.jawatan')
                ->where(['statusPermohonan' => '2', 'YEAR(tarikhPohon)' => date('Y')])
                ->andWhere(['job_category' => 2])
                ->count();
        
//        $sahListA = PermohonanMataIdpIndividu::find()
//                ->joinWith('biodata.jawatan')
//                ->where(['=', 'statusPermohonan', '2'])
//                ->andWhere(['job_category' => 1])
//                ->count();
        
        /*** error cross-server **/
        $sahListAA = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '2', 'YEAR(tarikhPohon)' => date('Y')])
                ->all();
        
        $senarai = [];
        foreach ($sahListAA as $sahListAA) {
            if ($sahListAA->biodata->jawatan->job_category == 1) {
                    array_push($senarai, $sahListAA->pemohonID);
            }
        }
        
        $sahListA = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '2', 'YEAR(tarikhPohon)' => date('Y')])
                ->andWhere(['pemohonID' => $senarai])
                ->count();
        /***/
        
        /** pegawai latihan **/
        $pentadbiranp = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 2, 'statusPermohonan' => '6', 'YEAR(tarikhPohon)' => date('Y')])
                ->count();
        
        $akademikp = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 1, 'statusPermohonan' => '6', 'YEAR(tarikhPohon)' => date('Y')])
                ->count();

        /*****/
        /** ketua sektor **/
        $pentadbirans = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 2, 'statusPermohonan' => '7', 'YEAR(tarikhPohon)' => date('Y')])
                ->orWhere(['job_category' => 2, 'statusPermohonan' => '8', 'YEAR(tarikhPohon)' => date('Y')])
                ->count();
        
        $akademiks = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 1, 'statusPermohonan' => '7', 'YEAR(tarikhPohon)' => date('Y')])
                ->orWhere(['job_category' => 1, 'statusPermohonan' => '8', 'YEAR(tarikhPohon)' => date('Y')])
                ->count();

        /*****/

        if ($category == 2){ //pentadbiran

            $total2 = $pentadbiran;

            if ($total2 > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 22){ //akademik

            $total2 = $akademik;

            if ($total2 > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 1){
 
            if ($sahListP > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$sahListP.'</span>';
                }
            else {
                    return ' ';
            }     
        } elseif ($category == 0){
            
            $total3 = $akademik + $pentadbiran + $sahList + $akademikSurat + $pentadbiranSurat;
            
            if ($total3 > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$total3.'</span>';
                }
            else {
                    return ' ';
            }
        } elseif ($category == 4){ //totalakademik_ul

            $total3 = $akademik + $sahListA + $akademikSurat;
            
            if ($total3 > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$total3.'</span>';
                }
            else {
                    return ' ';
            }

        } elseif ($category == 44){ //totalpentadbiran_ul

            $total3 = $pentadbiran + $sahListP + $pentadbiranSurat;
            
            if ($total3 > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$total3.'</span>';
                }
            else {
                    return ' ';
            }

        } elseif ($category == 3){
 
            if ($sahListA > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$sahListA.'</span>';
                }
            else {
                    return ' ';
            }     
        } elseif ($category == 20){ //pentadbiran

            $total2 = $pentadbiranp;

            if ($total2 > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 220){ //akademik

            $total2 = $akademikp;

            if ($total2 > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 21){ //pentadbiran

            $total2 = $pentadbirans;

            if ($total2 > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 221){ //akademik

            $total2 = $akademiks;

            if ($total2 > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
                }
            else {
                    return ' ';
            }
            
        }
        
        if ($total != 0){
            return $total;
        }
                
    }
    
    public static function totalPendingSurat($category) {

        $total = 0;
     
        // $akademikc = SuratKursusLuar::find()
        //             ->joinWith('permohonanLulus.biodata.jawatan')
        //             ->where(['job_category' => 1])
        //             ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
        //             ->select('idp_tbl_suratkursusluar.permohonanID');
        
        // $akademik = PermohonanKursusLuar::find()
        //             ->joinWith('biodata.jawatan')
        //             ->where(['job_category' => 1])
        //             ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
        //             ->andWhere(['NOT IN','idp_permohonanKursusLuar.permohonanID', $akademikc])
        //             ->count();
        
        // $pentadbiranc = SuratKursusLuar::find()
        //             ->joinWith('permohonanLulus.biodata.jawatan')
        //             ->where(['job_category' => 2])
        //             ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
        //             ->select('idp_tbl_suratkursusluar.permohonanID');
        
        // $pentadbiran = PermohonanKursusLuar::find()
        //             ->joinWith('biodata.jawatan')
        //             ->where(['job_category' => 2])
        //             ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
        //             ->andWhere(['NOT IN','idp_permohonanKursusLuar.permohonanID', $pentadbiranc])
        //             ->count();
        
        // /** pegawai latihan **/
        // $pentadbiranp = SuratKursusLuar::find()
        //             ->joinWith('permohonanLulus.biodata.jawatan')
        //             ->where(['job_category' => 2])
        //             ->andWhere(['status_ul' => '1', 'status_pl' => '0', 'YEAR(tarikhPohon)' => date('Y')])
        //             ->count();
        
        // $akademikp = SuratKursusLuar::find()
        //             ->joinWith('permohonanLulus.biodata.jawatan')
        //             ->where(['job_category' => 1])
        //             ->andWhere(['status_ul' => '1', 'status_pl' => '0', 'YEAR(tarikhPohon)' => date('Y')])
        //             ->count();

        /*****/

        if ($category == 2){ //pentadbiran

            $pentadbiranc = SuratKursusLuar::find()
                    ->joinWith('permohonanLulus.biodata.jawatan')
                    ->where(['job_category' => 2])
                    ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
                    ->select('idp_tbl_suratkursusluar.permohonanID');
        
            $pentadbiran = PermohonanKursusLuar::find()
                        ->joinWith('biodata.jawatan')
                        ->where(['job_category' => 2])
                        ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
                        ->andWhere(['NOT IN','idp_permohonanKursusLuar.permohonanID', $pentadbiranc])
                        ->count();

            $total2 = $pentadbiran;

            if ($total2 > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 1){ //akademik

            $akademikc = SuratKursusLuar::find()
                    ->joinWith('permohonanLulus.biodata.jawatan')
                    ->where(['job_category' => 1])
                    ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
                    ->select('idp_tbl_suratkursusluar.permohonanID');
        
            $akademik = PermohonanKursusLuar::find()
                        ->joinWith('biodata.jawatan')
                        ->where(['job_category' => 1])
                        ->andWhere(['statusPermohonan' => '10', 'YEAR(tarikhPohon)' => date('Y')])
                        ->andWhere(['NOT IN','idp_permohonanKursusLuar.permohonanID', $akademikc])
                        ->count();

            $total2 = $akademik;

            if ($total2 > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
                }
            else {
                    return ' ';
            }
            
        } elseif ($category == 22){ //pegawai (pentadbiran)

            $pentadbiranp = SuratKursusLuar::find()
                    ->joinWith('permohonanLulus.biodata.jawatan')
                    ->where(['job_category' => 2])
                    ->andWhere(['status_ul' => '1', 'status_pl' => '0', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();
            
            $total3 = $pentadbiranp;
            
            if ($total3 > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$total3.'</span>';
                }
            else {
                    return ' ';
            }
        } elseif ($category == 11){ //pentadbiran (akademik)

            $akademikp = SuratKursusLuar::find()
                    ->joinWith('permohonanLulus.biodata.jawatan')
                    ->where(['job_category' => 1])
                    ->andWhere(['status_ul' => '1', 'status_pl' => '0', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();

            $total2 = $akademikp;

            if ($total2 > 0) {
                
                    return '&nbsp;<span class="badge bg-red">'.$total2.'</span>';
                }
            else {
                    return ' ';
            }
            
        } 
        
        if ($total != 0){
            return $total;
        }
                
    }
    
    /** Relation **/
    public function getSuratLulus(){
        return $this->hasOne(SuratKursusLuar::className(), ['permohonanID'=>'permohonanID']);
    }
    
    public function malayMonth($date){
        
        // var_dump($date);
        // die();
        
        $m = date_format(date_create($date), "m");
        if($m == 01){
            $m = "Jan";}
        elseif ($m == 02){
          $m = "Feb";}
        elseif ($m == 03){
          $m = "Mac";}
        elseif ($m == 04){
          $m = "Apr";}
        elseif ($m == 05){
          $m = "Mei";}
        elseif ($m == 06){
          $m = "Jun";}
        elseif ($m == 07){
          $m = "Jul";}
        elseif ($m == '08'){
          $m = "Ogos";}
        elseif ($m == '09'){
          $m = "Sept";}
        elseif ($m == '10'){
          $m = "Okt";}
        elseif ($m == '11'){
          $m = "Nov";}
        elseif ($m == '12'){
          $m = "Dis";}
          
        return $m;
    }
    
    public function getDisplayDateLetter(){
 
        if ($this->tarikhMula == $this->tarikhTamat){
            //return Yii::$app->formatter->asDate($this->tarikhMula, 'php:d M Y');
            return date_format(date_create($this->tarikhMula), "d").' '.$this->malayMonth($this->tarikhMula).' '.date_format(date_create($this->tarikhMula), "Y");
        } else {
            //return Yii::$app->formatter->asDate($this->tarikhMula, 'php:d M').' - '.Yii::$app->formatter->asDate($this->tarikhTamat, 'php:d M Y');
            return date_format(date_create($this->tarikhMula), "d").' '.$this->malayMonth($this->tarikhMula).' - '.
                    date_format(date_create($this->tarikhTamat), "d").' '.$this->malayMonth($this->tarikhTamat).' '.date_format(date_create($this->tarikhTamat), "Y");
            
        }   
    }
    
    public function getDisplayUrusetia(){
        
        $modelBio = Tblprcobiodata::find()->where(['ICNO' => $this->pemohonID])->one();
        
        if ($modelBio->jawatan->job_category == 1){
            $urusetia = '861109496113';
        } else {
            $urusetia = '861109496113';
        }
        
        $modelBioUrusetia = Tblprcobiodata::find()->where(['ICNO' => $urusetia])->one();
        
        if ($modelBioUrusetia){
            return $modelBioUrusetia->displayGelaran.' '.ucwords(strtolower($modelBioUrusetia->CONm)).' di alamat emel spplbsm@ums.edu.my';
        } else {
            return "";
        }
    }
    
    public function displayPegawaiLatihan($type){
        
        $modelAccess = UserAccess::find()->where(['usertype' => 'ketuaSektor'])->one();
        
        if ($modelAccess){
        
            $modelBioPeg = Tblprcobiodata::find()->where(['ICNO' => $modelAccess->userID])->one();
            
            if ($modelBioPeg){
                
                if ($type == 1){
                    return strtoupper($modelBioPeg->CONm);
                } elseif ($type == 2){
                    return strtolower($modelBioPeg->COOffTelNoExtn);
                } elseif ($type == 3){
                    return strtolower($modelBioPeg->COEmail);
                } elseif ($type == 4){
                    return ucwords($modelBioPeg->jawatan->nama);
                }
            } else {
                return "";
            }
        
        } else {
            return "";
        }    
    }
    
    public function displayCommentary($type){
        
        if ($type == 1){
            return ucwords(strtolower($this->biodata->department->chiefBiodata->displayGelaran.' '.$this->biodata->department->chiefBiodata->CONm)).', Ketua, '.ucwords(strtolower($this->biodata->department->fullname));
        } elseif ($type == 2){
            
            //get Ketua BSM
            $model = Department::find()->where(['id' => '158'])->one();
            if ($model){
                return ucwords(strtolower($model->chiefBiodata->displayGelaran.' '.$model->chiefBiodata->CONm)).', Ketua, '.ucwords(strtolower($model->fullname));
            } else {
                return "";
            }
        } elseif ($type == 3){
            
            //get Ketua Sektor
            $modelAccess = UserAccess::find()->where(['usertype' => 'ketuaSektor'])->one();
            if ($modelAccess){
                return ucwords(strtolower($modelAccess->biodata->displayGelaran.' '.$modelAccess->biodata->CONm)).', '.ucwords(strtolower($modelAccess->biodata->jawatan->nama)).', '.ucwords(strtolower($modelAccess->biodata->department->fullname));
            } else {
                return "";
            }
        }    
    }
    
    public function getCheckDateLetter(){
        
        if ($this->tarikhKelulusan > $this->tarikhMula){
            
//            $date=date_create("2013-03-15");
//            date_sub($date,date_interval_create_from_date_string("40 days"));
//            echo date_format($date,"Y-m-d");
            
            // $date = date_create($this->tarikhMula);
            // $m = date_sub($date,date_interval_create_from_date_string("1 days"));

            $t = strtotime($this->tarikhMula);
            $m = date('Y-m-d',strtotime("-1 day", $t));

            // $date = new DateTime($date);
            // $date = $date->format('Y-m-d');

            $tarikhSurat = date_format(date_create($m),"d").' '.$this->malayMonth($m).' '.date_format(date_create($m),"Y");
            // $tarikhSurat = $m;
        } else {
            
            $tarikhSurat = date_format(date_create($this->tarikhKelulusan),"d").' '.$this->malayMonth($this->tarikhKelulusan).' '.date_format(date_create($this->tarikhKelulusan),"Y");
        }
        
        return $tarikhSurat;
        
    }
          
    public function getPengemaskini() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'updated_by']);
    }

    public static function countKursusByStaffCategory($kumpulan, $category, $year)
    {

        $count = 0;

        if ($category == 0) { //jumlah pemohon (pengurusan)
            $count = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan.skimPerkhidmatan')
                ->where(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '1'])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '2'])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '3'])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '4'])
                ->count();
        } elseif ($category == 1) { //jumlah pemohon (pelaksana/sokongan)
            $count = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan.skimPerkhidmatan')
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '5'])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '6'])
                ->count();
        } elseif ($category == 2) { //jumlah lulus (pengurusan)
            $count = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan.skimPerkhidmatan')
                ->where(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '1', 'statusPermohonan' => '10'])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '2', 'statusPermohonan' => '10'])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '3', 'statusPermohonan' => '10'])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '4', 'statusPermohonan' => '10'])
                ->count();
        } elseif ($category == 3) { //jumlah lulus (pelaksana/sokongan)
            $count = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan.skimPerkhidmatan')
                ->where(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '5', 'statusPermohonan' => '10'])
                ->orWhere(['MONTH(tarikhPohon)' => $kumpulan, 'YEAR(tarikhPohon)' => $year, 'kumpkhidmat.id' => '6', 'statusPermohonan' => '10'])
                ->count();
        }

        return $count;
    }
    
}
