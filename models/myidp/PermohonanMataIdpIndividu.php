<?php

namespace app\models\myidp;

use Yii;
use yii\helpers\Html;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "{{%myidp.permohonanmataidpindividu}}".
 *
 * @property int $permohonanID
 * @property string $pemohonID
 * @property string $namaProgram
 * @property string $jenisPenganjur
 * @property string $namaPenganjur
 * @property string $tarikhTamat
 * @property string $tarikhMula
 * @property string $lokasi
 * @property int $jenisAktivitiPohon
 * @property string $statusPermohonan
 * @property string $diluluskanOleh
 * @property string $tarikhBatalPermohonan
 * @property int $mataIDPlulus
 * @property string $failProgram1
 * @property string $failProgram2
 * @property string $failProgram3
 * @property string $tarikhKelulusan
 * @property string $statusKJ
 * @property string $tarikhSemakanKJ
 * @property string $ulasanKJ
 * @property string $kjPenyemak
 * @property string $statusBSM
 * @property string $tarikhSemakanBSM
 * @property string $ulasanBSM
 * @property string $disemakOleh
 * @property int $kompetensiCadangan
 * @property string $lainlain
 * @property string $tarikhPohon
 * @property int $kompetensiLulus
 * @property int $jenisAktivitiLulus
 * @property int $jenisAktivitiCadangan
 * @property string $laporan
 * @property int $mataIDPcadangan
 */
class PermohonanMataIdpIndividu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file1;
    public $file2;
    public $file3;

    public static function tableName()
    {
        return '{{%hrd.idp_permohonanmataidpindividu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //            [['pemohonID', 'jenisAktivitiPohon'], 'required'],
            //            [['namaProgram', 'ulasanKJ', 'ulasanBSM', 'lainlain', 'laporan'], 'string'],
            //            [['tarikhTamat', 'tarikhMula', 'tarikhBatalPermohonan', 'tarikhKelulusan', 'tarikhSemakanKJ', 'tarikhSemakanBSM', 'tarikhPohon'], 'safe'],
            //            [['jenisAktivitiPohon', 'mataIDPlulus', 'kompetensiCadangan', 'kompetensiLulus', 'kompetensiPohon', 'jenisAktivitiLulus', 'jenisAktivitiCadangan', 'mataIDPcadangan'], 'integer'],
            //            [['pemohonID', 'diluluskanOleh', 'kjPenyemak', 'disemakOleh'], 'string', 'max' => 12],
            //            [['jenisPenganjur'], 'string', 'max' => 25],
            //            [['namaPenganjur', 'lokasi', 'failProgram1', 'failProgram2', 'failProgram3'], 'string', 'max' => 100],
            //            [['statusPermohonan', 'statusKJ', 'statusBSM', 'statusSektor'], 'string', 'max' => 2],
            //            [['file1, file2, file3'], 'file','extensions'=>'pdf, png, jpg, jpeg', 'maxFiles' => 2],

            [['pemohonID', 'namaProgram', 'jenisPenganjur', 'namaPenganjur', 'tarikhTamat', 'tarikhMula', 'lokasi', 'laporan', 'kompetensiPohon', 'kompetensiPohon2'], 'required', 'message' => 'Ruangan ini adalah mandatori'],
            [['namaProgram', 'ulasanKJ', 'ulasanBSM', 'laporan', 'justifikasiBatal', 'ulasanSektor'], 'string'],
            [['tarikhTamat', 'tarikhMula', 'tarikhBatalPermohonan', 'tarikhKelulusan', 'tarikhSemakanKJ', 'tarikhSemakanBSM', 'tarikhPohon'], 'safe'],
            [['mataIDPlulus', 'kompetensiCadangan', 'kompetensiLulus', 'kompetensiPohon', 'kompetensiPohon2', 'mataIDPcadangan'], 'integer'],
            [['pemohonID', 'diluluskanOleh', 'kjPenyemak', 'disemakOleh', 'dibatalkanOleh'], 'string', 'max' => 12],
            [['jenisPenganjur'], 'string', 'max' => 25],
            [['namaPenganjur', 'lokasi', 'failProgram1', 'failProgram2', 'failProgram3'], 'string', 'max' => 100],
            [['statusPermohonan', 'statusKJ', 'statusBSM', 'statusSektor', 'jenisPermohonan'], 'string', 'max' => 2],
            //[['file1, file2, file3'], 'file','extensions'=>'pdf, png, jpg, jpeg', 'maxSize' => 5000000],
            [['file1', 'file2', 'file3'], 'file', 'extensions' => ['pdf', 'png', 'jpg', 'jpeg'], 'maxSize' => 2 * 1024 * 1024],
            [['file1', 'file2', 'file3'], 'safe'],
            [['file3'], 'required', 'message' => 'Ruangan ini adalah mandatori'],


            //conditional validation
            /***['state', 'required', 'when' => function($model) {
                    return $model->country == 'USA';
            }]***/

            //client-side conditional validation
            /***['state', 'required', 'when' => function ($model) {
                    return $model->country == 'USA';
                }, 'whenClient' => "function (attribute, value) {
                    return $('#country').val() == 'USA';
                }"]***/

            //            [['jenisPenganjur', 'tarikhMula', 'tarikhTamat', 'kompetensiPohon', 'namaProgram', 'lokasi', 'namaPenganjur'], 
            //                'required',
            //                'message' => 'Sila isi ruangan ini.',
            //                'when' => function ($model){
            //                            return $model->jenisAktivitiPohon == '1';
            //            
            //                }, 'whenClient' => "function (attribute, value) {
            //                                        return $('#jenis_carian').val() == '1';
            //                                        }"
            //                ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'permohonanID' => 'Permohonan ID',
            'pemohonID' => 'Pemohon ID',
            'namaProgram' => 'Nama Program',
            'jenisPenganjur' => 'Jenis Penganjur',
            'namaPenganjur' => 'Nama Penganjur',
            'tarikhTamat' => 'Tarikh Tamat',
            'tarikhMula' => 'Tarikh Mula',
            'lokasi' => 'Lokasi',
            'statusPermohonan' => 'Status Permohonan',
            'diluluskanOleh' => 'Diluluskan Oleh',
            'tarikhBatalPermohonan' => 'Tarikh Batal Permohonan',
            'mataIDPlulus' => 'Mata Id Plulus',
            'failProgram1' => 'Fail Program1',
            'failProgram2' => 'Fail Program2',
            'failProgram3' => 'Fail Program3',
            'tarikhKelulusan' => 'Tarikh Kelulusan',
            'statusKJ' => 'Status Kj',
            'tarikhSemakanKJ' => 'Tarikh Semakan Kj',
            'ulasanKJ' => 'Ulasan Kj',
            'kjPenyemak' => 'Kj Penyemak',
            'statusBSM' => 'Status Bsm',
            'tarikhSemakanBSM' => 'Tarikh Semakan Bsm',
            'ulasanBSM' => 'Ulasan Bsm',
            'disemakOleh' => 'Disemak Oleh',
            'kompetensiCadangan' => 'Kompetensi Cadangan',
            'tarikhPohon' => 'Tarikh Pohon',
            'kompetensiLulus' => 'Kompetensi Lulus',
            'kompetensiPohon' => 'Kompetensi Pohon',
            'kompetensiPohon2' => 'Kompetensi Pohon 2',
            'laporan' => 'Laporan',
            'mataIDPcadangan' => 'Mata Id Pcadangan',
            'statusSektor' => 'Status Ketua Sektor',
            'ulasanSektor' => 'Ulasan Ketua Sektor',
            'jenisPermohonan' => 'Jenis Permohonan',
        ];
    }

    public function getStatusPermohonann()
    {

        $a = "TIADA DATA";

        if ($this->statusPermohonan == '1') {
            $a = '<span class="label label-default">MENUNGGU PENGESAHAN KJ</span>';
        } elseif ($this->statusPermohonan == '9') {
            $a = '<span class="label label-default">MENUNGGU PENGESAHAN KJ/PP</span>';
        } elseif ($this->statusPermohonan == '2') {
            $a = '<span class="label label-warning">MENUNGGU SEMAKAN</span>';
        } elseif ($this->statusPermohonan == '3' || $this->statusPermohonan == '33') {
            $a = '<span class="label label-info">MENUNGGU PERAKUAN</span>';
        } elseif ($this->statusPermohonan == '4') {
            $a = '<span class="label label-primary">MENUNGGU KELULUSAN</span>';
        } elseif ($this->statusPermohonan == '5' && $this->statusSektor == '5') {
            $a = '<span class="label label-danger">PERMOHONAN DITOLAK</span>';
        } elseif ($this->statusPermohonan == '5' && $this->statusSektor == '4') {
            $a = '<span class="label label-success">PERMOHONAN BERJAYA</span>';
        } elseif ($this->statusPermohonan == '11') {
            $a = '<span class="label label-danger">DIBATALKAN</span>';
        } elseif ($this->statusPermohonan == '99') {
            $a = '<span class="label label-danger">BELUM DIHANTAR</span>';
        }

        return $a;
    }

    public function getPenganjur()
    {

        $a = "TIADA DATA";

        if ($this->jenisPenganjur == '1') {
            $a = 'Anjuran Agensi Luar';
        } elseif ($this->jenisPenganjur == '2') {
            $a = 'Anjuran Dalaman UMS';
        }

        return $a;
    }

    public function getKompetensii()
    {

        $a = "TIADA DATA";

        if ($this->kompetensiPohon == '1' || $this->kompetensiPohon2 == '1') {
            $a = '<span class="label label-default">UMUM</span>';
        } elseif ($this->kompetensiPohon == '3' || $this->kompetensiPohon2 == '3') {
            $a = '<span class="label label-info">TERAS</span>';
        } elseif ($this->kompetensiPohon == '4' || $this->kompetensiPohon2 == '4') {
            $a = '<span class="label label-primary">ELEKTIF</span>';
        } elseif ($this->kompetensiPohon == '5' || $this->kompetensiPohon2 == '5') {
            $a = '<span class="label label-success">WAJIB-TERAS-UNIVERSITI</span>';
        } elseif ($this->kompetensiPohon == '6' || $this->kompetensiPohon2 == '6') {
            $a = '<span class="label label-danger">WAJIB-TERAS-SKIM</span>';
        } elseif ($this->kompetensiPohon == '7' || $this->kompetensiPohon2 == '7') {
            $a = '<span class="label label-warning">KURSUS BERIMPAK TINGGI</span>';
        }

        return $a;
    }

    public function getKompetensiiCadangan()
    {

        $a = "TIADA DATA";

        if ($this->kompetensiCadangan == '1') {
            $a = '<span class="label label-default">UMUM</span>';
        } elseif ($this->kompetensiCadangan == '3') {
            $a = '<span class="label label-info">TERAS</span>';
        } elseif ($this->kompetensiCadangan == '4') {
            $a = '<span class="label label-primary">ELEKTIF</span>';
        } elseif ($this->kompetensiCadangan == '5') {
            $a = '<span class="label label-success">WAJIB-TERAS-UNIVERSITI</span>';
        } elseif ($this->kompetensiCadangan == '6') {
            $a = '<span class="label label-danger">WAJIB-TERAS-SKIM</span>';
        } elseif ($this->kompetensiCadangan == '7') {
            $a = '<span class="label label-warning">KURSUS BERIMPAK TINGGI</span>';
        }

        return $a;
    }

    public function getKompetensiiLulus()
    {

        $a = "TIADA DATA";

        if ($this->kompetensiLulus == '1') {
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

    public function getPeserta()
    {
        return $this->hasMany(Peserta::className(), ['permohonanID' => 'permohonanID']);
    }

    public function getBiodata()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pemohonID']);
    }

    //    public function getJobCategoryy(){
    //        
    //        if ($this->job_category == 2){
    //            return "PENTADBIRAN";
    //        } elseif ($this->job_category == 1){
    //            return "AKADEMIK";
    //        } else {
    //            return " ";
    //        }
    //    }

    public function getPembatal()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'dibatalkanOleh']);
    }

    public function getPembatall()
    {
        //return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'dibatalkanOleh']);

        if ($this->dibatalkanOleh == $this->pemohonID) {
            return '<span class="label label-primary">PEMOHON</span>';
        } else {
            return '<span class="label label-success">' . $this->pembatal->CONm . '</span>';
        }
    }

    public function getDaysKursus()
    {

        $datetime1 = date_create($this->tarikhMula);
        $datetime2 = date_create($this->tarikhTamat);

        //date_diff() function calculate the difference two dates
        $dateDuration = date_diff($datetime1, $datetime2);

        //format the date difference
        $dateDuration2 =  $dateDuration->format('%a');

        return $dateDuration2 + 1;
    }

    public function getPengesah()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'kjPenyemak']);
    }

    public function getPengesahbsm()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'disemakOleh']);
    }

    public function getPelulus()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'diluluskanOleh']);
    }

    public function getDisplayLink()
    {
        if (!empty($this->failProgram1) && $this->failProgram1 != 'deleted') {
            return Html::a(Yii::$app->FileManager->NameFile($this->failProgram1), Yii::$app->FileManager->DisplayFile($this->failProgram1));
        }
        return 'File not exist!';
    }

    public function getDisplayLink2()
    {
        if (!empty($this->failProgram2) && $this->failProgram2 != 'deleted') {
            return Html::a(Yii::$app->FileManager->NameFile($this->failProgram2), Yii::$app->FileManager->DisplayFile($this->failProgram2));
        }
        return 'File not exist!';
    }

    public function getDisplayLink3()
    {
        if (!empty($this->failProgram3) && $this->failProgram3 != 'deleted') {
            return Html::a(Yii::$app->FileManager->NameFile($this->failProgram3), Yii::$app->FileManager->DisplayFile($this->failProgram3));
        }
        return 'File not exist!';
    }

    public function getDisplayLink4()
    {

        $thislist = [];

        if (!empty($this->failProgram1) && $this->failProgram1 != 'deleted') {
            $a = Html::a(Yii::$app->FileManager->NameFile($this->failProgram1), Yii::$app->FileManager->DisplayFile($this->failProgram1));
            array_push($thislist, $a);
        }

        if (!empty($this->failProgram2) && $this->failProgram2 != 'deleted') {
            $a = Html::a(Yii::$app->FileManager->NameFile($this->failProgram2), Yii::$app->FileManager->DisplayFile($this->failProgram2));
            array_push($thislist, $a);
        }

        if (!empty($this->failProgram3) && $this->failProgram3 != 'deleted') {
            $a = Html::a(Yii::$app->FileManager->NameFile($this->failProgram3), Yii::$app->FileManager->DisplayFile($this->failProgram3));
            array_push($thislist, $a);
        }

        if (!empty($thislist)) {
            $all = " ";
            $b = count($thislist);
            for ($i = 0; $i < count($thislist); $i++) {
                $all = '</br>' . $b . ') ' . $thislist[$i] . $all;
                $b--;
            }
            return $all;
        } else {
            return "";
        }
    }

    public function getDisplayPeserta()
    {

        $arrayPeserta = [];

        $modelPeserta = Peserta::find()->where(['permohonanID' => $this->permohonanID])->all();

        foreach ($modelPeserta as $modelPeserta) {
            array_push($arrayPeserta, $modelPeserta->biodata->CONm . ' - ' . $modelPeserta->biodata->jawatan->gred);
        }

        if (!empty($arrayPeserta)) {
            $all = " ";
            $b = count($arrayPeserta);
            for ($i = 0; $i < count($arrayPeserta); $i++) {
                $all = '</br>' . $b . ') ' . $arrayPeserta[$i] . $all;
                $b--;
            }
            return $all;
        } else {
            return "";
        }
    }

    public static function totalPendingSpecial($icno) //category => 1
    {
        $total2 = 0;

        $baruList = PermohonanMataIdpIndividu::find()
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

        $senaraiPemohon = [];
        foreach ($baruList as $baruListt) {

            $modelB = Tblprcobiodata::find()
                ->where(['ICNO' => $baruListt->pemohonID])
                ->one();

            if ($test) {
                foreach ($test as $test2) {
                    if ($modelB->DeptId == $test2->id) {
                        array_push($senaraiPemohon, $baruListt->pemohonID);
                    }
                }
            }
        }

        if ($test) {

            $senaraiPemohon2 = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '1', 'pemohonID' => $senaraiPemohon, 'YEAR(tarikhPohon)' => date('Y')])
                ->orWhere(['statusPermohonan' => '9', 'pemohonID' => $senaraiPemohon, 'YEAR(tarikhPohon)' => date('Y')])
                ->count();
            $total2 = $senaraiPemohon2;
        }

        if ($nc) {
            $senaraiPemohon2 = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '17', 'YEAR(tarikhPohon)' => date('Y')])
                ->count();
            $total2 = $senaraiPemohon2;
        }

        /*****/
        if ($total2 > 0) {
            return $total2;
        } else {
            return ' ';
        }
    }

    public static function totalPending($icno, $category)
    {

        $total = 0;
        $total2 = 0;

        if ($category == 1) {

            //            $baruList = PermohonanMataIdpIndividu::find()
            //                ->joinWith('biodata.department')
            //                ->where(['chief' => $icno, 'statusPermohonan' => '1'])
            //                ->orWhere(['department.pp' => $icno, 'statusPermohonan' => '9'])
            //                ->count();

            /** cross-server **/

            $baruList = PermohonanMataIdpIndividu::find()
                ->where(['YEAR(tarikhPohon)' => date('Y')])
                ->all();

            $test = Department::find()
                ->where(['chief' => $icno])
                ->orWhere(['pp' => $icno, 'id' => '164']) //HUMS
                ->all();

            //            $testx = Department::find()
            //                ->where(['pp' => $icno])
            //                ->all();

            $nc = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['id' => '2', 'Status' => '1', 'ICNO' => $icno])
                ->one();

            $senaraiPemohon = [];
            $senaraiPemohonx = [];
            foreach ($baruList as $baruListt) {

                $modelB = Tblprcobiodata::find()
                    ->where(['ICNO' => $baruListt->pemohonID])
                    ->one();

                if ($test) {
                    foreach ($test as $test2) {
                        if ($modelB->DeptId == $test2->id) {
                            array_push($senaraiPemohon, $baruListt->pemohonID);
                        }
                    }
                }

                //                if ($testx){
                //                    foreach ($testx as $test2) {
                //                        if ($modelB->DeptId == $test2->id) {
                //                            array_push($senaraiPemohonx, $baruListt->pemohonID);
                //                        }
                //                    }
                //                }
            }

            if ($test) {

                $senaraiPemohon2 = PermohonanMataIdpIndividu::find()
                    ->where(['statusPermohonan' => '1', 'pemohonID' => $senaraiPemohon, 'YEAR(tarikhPohon)' => date('Y')])
                    ->orWhere(['statusPermohonan' => '9', 'pemohonID' => $senaraiPemohon, 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();
                $total2 = $senaraiPemohon2;
            }

            //            if ($testx){
            //                $senaraiPemohon2 = PermohonanMataIdpIndividu::find()
            //                        ->where(['statusPermohonan' => '9', 'pemohonID' => $senaraiPemohonx, 'YEAR(tarikhPohon)' => date('Y')])
            //                        ->count();
            //                $total2 = $senaraiPemohon2;
            //            }

            if ($nc) {
                $senaraiPemohon2 = PermohonanMataIdpIndividu::find()
                    ->where(['statusPermohonan' => '17', 'YEAR(tarikhPohon)' => date('Y')])
                    ->count();
                $total2 = $senaraiPemohon2;
            }

            /*****/



            if ($total2 > 0) {

                //$total = $total + $total2;
                return '&nbsp;<span class="badge bg-red">' . $total2 . '</span>';
                //return $total;
            } else {
                return ' ';
            }
        } elseif ($category == 2 && $icno == '861109496113') {

            //            $senaraiPemohon2 = PermohonanMataIdpIndividu::find()
            //                    ->where(['statusPermohonan' => '3'])
            //                    ->orWhere(['statusPermohonan' => '33'])
            //                    ->count();

            $sahList = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '3', 'YEAR(tarikhPohon)' => date('Y')])
                ->orWhere(['statusPermohonan' => '33', 'YEAR(tarikhPohon)' => date('Y')])
                ->all();

            $senarai = [];
            foreach ($sahList as $sahListt) {
                if ($sahListt->biodata->jawatan->job_category == 2) {
                    array_push($senarai, $sahListt->pemohonID);
                }
            }

            $sahList2 = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '3', 'pemohonID' => $senarai, 'YEAR(tarikhPohon)' => date('Y')])
                ->orWhere(['statusPermohonan' => '33', 'pemohonID' => $senarai, 'YEAR(tarikhPohon)' => date('Y')])
                ->count();

            /*****/

            $total2 = $sahList2;

            if ($total2 > 0) {

                //$total = $total + $total2;
                return '&nbsp;<span class="badge bg-red">' . $total2 . '</span>';
                //return $total;
            } else {
                return ' ';
            }
        } elseif ($category == 3 && $icno == '731119125636') {

            $senaraiPemohon2 = PermohonanMataIdpIndividu::find()
                ->joinWith('biodata.jawatan')
                ->where(['statusPermohonan' => '4', 'YEAR(tarikhPohon)' => date('Y'), 'job_category' => 1])
                ->count();

            /*****/

            $total2 = $senaraiPemohon2;

            if ($total2 > 0) {

                //$total = $total + $total2;
                return '&nbsp;<span class="badge bg-red">' . $total2 . '</span>';
                //return $total;
            } else {
                return ' ';
            }
        } elseif ($category == 4 && $icno == '731119125636') {

            $senaraiPemohon2 = PermohonanMataIdpIndividu::find()
                ->joinWith('biodata.jawatan')
                ->where(['statusPermohonan' => '4', 'YEAR(tarikhPohon)' => date('Y'), 'job_category' => 2])
                ->count();

            /*****/

            $total2 = $senaraiPemohon2;

            if ($total2 > 0) {

                //$total = $total + $total2;
                return '&nbsp;<span class="badge bg-red">' . $total2 . '</span>';
                //return $total;
            } else {
                return ' ';
            }
        } elseif ($category == 22 && $icno == '861109496113') {

            $sahList = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '3', 'YEAR(tarikhPohon)' => date('Y')])
                ->orWhere(['statusPermohonan' => '33', 'YEAR(tarikhPohon)' => date('Y')])
                ->all();

            $senarai = [];
            foreach ($sahList as $sahListt) {
                if ($sahListt->biodata->jawatan->job_category == 1) {
                    array_push($senarai, $sahListt->pemohonID);
                }
            }

            $sahList2 = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '3', 'pemohonID' => $senarai, 'YEAR(tarikhPohon)' => date('Y')])
                ->orWhere(['statusPermohonan' => '33', 'pemohonID' => $senarai, 'YEAR(tarikhPohon)' => date('Y')])
                ->count();

            /*****/

            $total2 = $sahList2;

            if ($total2 > 0) {

                //$total = $total + $total2;
                return '&nbsp;<span class="badge bg-red">' . $total2 . '</span>';
                //return $total;
            } else {
                return ' ';
            }
        }

        if ($total != 0) {
            return $total;
        }
    }

    public function getStatusULL()
    {

        $a = "TIADA DATA";

        if ($this->statusUL == '1') {
            $a = '<span class="label label-success">DISEMAK</span>';
        }

        return $a;
    }

    public function getStatusBSMM()
    {

        $a = "TIADA DATA";

        if ($this->statusBSM == '4') {
            $a = '<span class="label label-success">DISEMAK</span>';
        }
        return $a;
    }

    public function getStatusSektorr()
    {

        $a = "TIADA DATA";

        if ($this->statusSektor == '5') {
            $a = '<span class="label label-danger">PERMOHONAN DITOLAK</span>';
        } elseif ($this->statusSektor == '4') {
            $a = '<span class="label label-success">PERMOHONAN BERJAYA</span>';
        }

        return $a;
    }

    public function calcPermohonan($dept, $year)
    {
        $total = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata')
            ->where(['YEAR(tarikhPohon)' => $year, 'deptId' => $dept])
            ->count();

        return $total;
    }

    public function calcPermohonanByGroup($dept, $year)
    {
        $total = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata')
            ->where(['jenisPermohonan' => '2', 'YEAR(tarikhPohon)' => $year, 'deptId' => $dept])
            ->count();

        return $total;
    }

    public function removeEmoji($text)
    {

        $clean_text = "";

        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $text);

        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);

        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);

        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);

        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);

        return $clean_text;
    }
}
