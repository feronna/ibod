<?php

namespace app\controllers;

use Yii;
use kartik\mpdf\Pdf;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use app\models\Notification;
use yii\helpers\ArrayHelper;
use app\models\myidp\Ceramah;
use app\models\myidp\IdpMata;
use app\models\myidp\Peserta;
use app\models\myidp\RefSlot;
use yii\filters\AccessControl;
use app\models\cuti\SetPegawai;
use app\models\myidp\Kehadiran;
use app\models\myidp\TblMonths;
use yii\data\ArrayDataProvider;
use app\models\myidp\AdminJfpiu;
use app\models\myidp\Penceramah;
use app\models\myidp\UserAccess;
use yii\data\ActiveDataProvider;
use app\models\myidp\PendingTask;
use app\models\myidp\SiriLatihan;
use app\models\myidp\SlotLatihan;
use yii\web\NotFoundHttpException;
use app\models\hronline\Department;
use app\models\myidp\KursusLatihan;
use app\models\myidp\KursusSasaran;
use app\models\myidp\PesertaImport;
use app\models\myidp\PesertaSearch;
use app\models\hronline\GredJawatan;
use app\models\myidp\KehadiranJfpiu;
use app\models\myidp\KursusJemputan;
use app\models\myidp\Idp; //old model
use app\models\myidp\KehadiranImport;
use app\models\myidp\KehadiranSearch;
use app\models\myidp\RptStatistikIdp;
use app\models\myidp\SiriLatihanLive;
use app\models\myidp\SuratKursusLuar;
use app\models\myidp\UrusetiaLatihan;
use kartik\grid\EditableColumnAction;
use app\models\hronline\TblPenempatan;
use app\models\myidp\AdminJfpiuSearch;
use app\models\myidp\SiriLatihanBahan;
use app\models\myidp\SiriLatihanJfpiu;
use app\models\myidp\SlotLatihanJfpiu;
use app\models\hronline\Tblprcobiodata;
use app\models\myidp\PendingTaskSearch;
use app\models\myidp\PermohonanLatihan;
use app\models\myidp\RefSenaraiLaporan;
use app\models\myidp\RptStatistikIdpV2;
use app\models\myidp\SiriLatihanSearch;
use app\models\hronline\Kumpulankhidmat;
use app\models\myidp\KehadiranByJabatan;
use app\models\myidp\KursusLatihanBahan;
use app\models\myidp\KursusLatihanJfpiu;
use app\models\myidp\VCpdSenaraiLatihan;
use tebazil\runner\ConsoleCommandRunner;
use app\models\hronline\Tblrscosandangan;
use app\models\myidp\KursusLatihanImport;
use app\models\myidp\KursusLatihanSearch;
use app\models\myidp\Kategori; //ref table
use app\models\myidp\KursusJemputanSearch;
use app\models\myidp\PenetapanAksesSearch;
use app\models\myidp\PermohonanKursusLuar;
use app\models\myidp\KehadiranKeberkesanan;
use app\models\myidp\BorangPenilaianLatihan;
use app\models\hronline\TblprcobiodataSearch;
use app\models\myidp\PermohonanLatihanSearch;
use app\models\myidp\PermohonanMataIdpSearch;
use app\models\myidp\RefCpdGroup; //ref table
use app\models\myidp\VCpdLatihan; //old model
use app\models\myidp\StatistikSkimPentadbiran;
use app\models\myidp\VCpdSenaraiLatihanSearch;
use app\models\myidp\PermohonanMataIdpIndividu;
use app\models\myidp\BorangPenilaianLatihanLama;
use app\models\myidp\PermohonanKursusLuarSearch;
use app\models\myidp\VIdpKumpulan; //dari db idp
use app\models\myidp\BorangPenilaianKeberkesanan;
use app\models\myidp\PermohonanKursusLuarSearch_1;
use app\models\myidp\VIdpKursusSasaran; //old model
use app\models\myidp\VIdpSenaraiKursus; //old model
use app\models\myidp\BorangPenilaianKeberkesananLama;
use app\models\myidp\RptStatistikIdpLama; //Santi punya
use app\models\myidp\RefCpdGroupGredJawatan; //ref table
use app\models\myidp\SoalanPenilaianLatihan; //ref table
use app\models\myidp\KursusLatihanSearch_1; //delete later
use app\models\myidp\KursusLatihanSearch_2; //delete later
use app\models\myidp\IdpGredJawatan; //hronline gredjawatan (kiv)
use app\models\myidp\IdpGredJawatanSearch; //hronline gredjawatan (kiv)


/**
 * IdpController implements the CRUD actions for Idp model.
 */
class IdpController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                'rules' => [
                    [
                        'actions' => [
                            'index', 'view-kursus-sasaran', 'view-senarai-permohonan',
                            'mohonkursusluar', 'mohon-mata-idp', 'view-senarai-permohonan-individu',
                            'transkrip', 'takwim', 'mohon-latihan', 'mohon-siri-latihan',
                            'sahhadir', 'slip-jemputan', 'profil', 'borangpenilaianlatihan',
                            'view-latihan-luar-pohon', 'update-latihan-luaran-pohon',
                            'delete-latihan-luaran-pohon', 'latihan-dipohon',
                            'delete-permohonan-siri', 'latihan-dihadiri', 'tindakan-pemohon',
                            'batal-permohonan-by-pemohon', 'peraku', 'pelulus', 'pengesahan',
                            'laporan-idp-jabatan', 'idp-jfpiuu', 'pending-task',
                            'tindakan-pengesahan', 'laporan-kehadiran-keberkesanan',
                            'laporan-kehadiran-jabatan', 'laporan-kehadiran-siri',
                            'borangpenilaiankeberkesanan', 'keberkesanan-kursus', 'senarai',
                            'ubah-mata-slot', 'statistik-senarai', 'sasaran-skim',
                            'senarai-jabatan', 'senarai-baki', 'calc-mata',
                            'laporan-kehadiran-siri-jfpiu', 'statistik-pencapaian-pelaksanaan-kursus-dalaman',
                            'statistik-kehadiran-kursus-dalaman', 'statistik-permohonan-mata', 'statistik-permohonan-mata-bulanan',
                            'statistik-kakitangan-mengikuti-kursus-anjuran-luar', 'daftar-kursus-impak-tinggi'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [
                            'create-latihan', 'import', 'import-impak', 'view-senarai-latihan', 'view-senarai-latihan-jfpiu',
                            'view-senarai-latihan-live', 'semakan-kursus-luar-pentadbiran',
                            'semakan-kursus-luar-akademik', 'semakan-surat-kursus-luar-pentadbiran',
                            'semakan-surat-kursus-luar-akademik', 'semakan-bsm', 'semakan-bsmm',
                            'daftar-kursus-jfpiu', 'tetapan-akses', 'carian-staf', 'profil',
                            'laporan-idp-jabatan', 'index-laporan2', 'statistik', 'index-laporan-sasaran',
                            'statistik-akademik', 'statistik-pentadbiran', 'statistik-jabatan',
                            'statistik-skim', 'statistik-skim-akademik', 'statistik-baki',
                            'purata-penilaian', 'kelulusan-bsm', 'kelulusan-bsm-akademik', 'tindakan-kelulusan-bsm',
                            'ubah-kompetensi-profil', 'pengesahan-bsm', 'tindakan-pengesahan-bsm',
                            'pengesahan-bsm-akademik', 'surat-kursus-luar', 'jana-surat-kursus-luar',
                            'view-latihan-live', 'tindakan-semakan-ul', 'delete-peserta', 'delete-peserta-slot',
                            'laporan-kehadiran-siri', 'form-tambah-siri', 'view-senarai-penceramah',
                            'view-latihan', 'update-latihan', 'jemput-peserta',
                            'update-siri', 'view-senarai-jawatan', 'view-jemputan',
                            'semak-permohonan-siri', 'delete-latihan', 'delete-siri',
                            'semaksurat', 'batal-permohonan', 'delete-akses',
                            'ubah-status-kehadiran', 'ubah-jenis-kursusss', 'ubah-jenis-kursuss',
                            'laporan-kehadiran-jabatan', 'tambahsiri', 'view-senarai-latihan-lama',
                            'view-kehadiran-kursus-lama', 'purata-keberkesanan', 'statistik-pencapaian-skim',
                            'purata-penilaian-lama',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $tmp = UserAccess::find()
                                ->where(['userID' => Yii::$app->user->identity->ICNO, 'usertype' => 'admin'])
                                ->orWhere(['userID' => Yii::$app->user->identity->ICNO, 'usertype' => 'ketuaSektor'])
                                ->orWhere(['userID' => Yii::$app->user->identity->ICNO, 'usertype' => 'ul'])
                                ->orWhere(['userID' => Yii::$app->user->identity->ICNO, 'usertype' => 'ul-s'])
                                ->orWhere(['userID' => Yii::$app->user->identity->ICNO, 'usertype' => 'pegawaiLatihan'])->one();
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [
                        'actions' => [
                            'laporan-idp-jabatan', 'mohon-mata-idp-jfpiu',
                            'view-senarai-permohonan-individu', 'laporan-kehadiran-jabatan',
                            'laporan-kehadiran-siri'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $tmp = AdminJfpiu::find()->where(['staffID' => Yii::$app->user->identity->ICNO])->one();
                            return (is_null($tmp)) ? $this->redirect(Yii::$app->request->referrer) : true;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Idp models.
     * @return mixed
     */
    //    public function actions()
    //    {
    //        return ArrayHelper::merge(parent::actions(), [
    //            'editsiri' => [                                       // identifier for your editable action
    //                'class' => EditableColumnAction::className(),     // action class name
    //                'modelClass' => SiriLatihan::className(),         // the update model class
    //                'outputValue' => function ($model, $attribute, $key, $index) {
    //                     return (int) $model->$attribute / 100;      // return any custom output value if desired
    //               },
    //               'outputMessage' => function($model, $attribute, $key, $index) {
    //                     return '';                                  // any custom error to return after model save
    //               },
    //                'showModelErrors' => true,                     // show model errors after save
    //                'errorOptions' => ['header' => '']             // error summary HTML options
    //            ]
    //        ]);
    //    }

    public function actionCalcMata($staffChosen, $year)
    {

        IdpMata::updateMata($staffChosen, $year);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionProfil($staffChosen, $year)
    {
        //get current user ID
        $id = $staffChosen;

        $modelAdmin = UserAccess::find()
            ->where(['userID' => Yii::$app->user->getId()])
            ->one();

        if ($modelAdmin) {
            $userStat = 1;

            if ($modelAdmin->usertype == 'admin') {
                $userStat2 = 1;
            } else {
                $userStat2 = 2;
            }
        } else {
            $userStat = 2;
            $userStat2 = 3;
        }

        //$time = strtotime($year);
        //$newformat = date('Y', $time);

        $currentYear = $year; //from parameter

        /** major changes 15/09/2020 **/
        /** TEST **/

        if ($currentYear >= 2020) {

            $modelRpt = RptStatistikIdp::find()
                ->where(['icno' => $id, 'tahun' => $currentYear])
                ->one();
            /*********************************/

            $model = new Idp(); //table from V3 idp.v_idp_profil
            //$model2 = new VCpdLatihan(); //table from V3 hronline.v_cpd_latihan
            $model2 = IdpMata::find()
                ->where(['staffID' => $id])
                ->andWhere(['tahun' => $currentYear])
                ->one();
        } else {

            $modelRpt = RptStatistikIdpLama::find()
                ->where(['icno' => $id, 'tahun' => $currentYear])
                ->one();
        }

        $model4 = new SetPegawai();
        $model5 = SetPegawai::find()->where(['pemohon_icno' => $id])->one();

        $model3 = Tblrscosandangan::find()
            ->where(['ICNO' => $id])
            ->andWhere(['YEAR(start_date)' => $currentYear])
            ->one();

        if ($model3) {

            $gredj = $model3->gredJawatan->gred;
        } else {

            $model3 = Tblrscosandangan::find()
                ->where(['ICNO' => $id])
                ->orderBy(['start_date' => SORT_DESC])
                ->one();

            if ($model3) {

                $gredj = $model3->gredJawatan->gred;
            }
        }

        if ($currentYear >= 2020) {
            $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj, 'tahun' => $currentYear])->one();

            if ($modelcpdgroupgj) {

                $cpdgroup = $modelcpdgroupgj->cpdgroup;
                $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup, 'tahun' => $currentYear])->one();
            } else {
                return $this->redirect(Yii::$app->request->referrer);
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat', 'type' => 'success', 'msg' => 'Ralat! Gred jawatan terkini anda tiada IDP']);
            }
        }

        //$modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup])->one();
        //$model4 = SetPegawai::findOne(['pemohon_icno' => $id]);
        //academicStaff
        //if ($model3->kategori == 1){
        if ($model3->gredJawatan->job_category == 1) {

            $staffCategory = 'ACADEMIC';

            //            $minMata = $modelcpdgroup->mataMin;
            //
            //            $minTerasAcademic = round(0.5 * $minMata);
            //            $minElektifAcademic = round(0.3 * $minMata);
            //            $minUmumAcademic = round(0.2 * $minMata);

            $minMata = $modelRpt->idp_mata_min;

            $minTerasAcademic = $modelRpt->idp_kom_teras;
            $minElektifAcademic = $modelRpt->idp_kom_elektif;

            if ($currentYear >= 2020) {
                $minUmumAcademic = $modelRpt->idp_kom_umum;
            } else {
                $minUmumAcademic = $modelRpt->idp_kom_sumbangan;
            }

            if ($currentYear >= 2020) {
                //latestStaffIDPPoint for each sub
                if ($model2) {
                    //                $individualTerasAcademic = $model2->mataTeras;
                    //                $individualElektifAcademic = $model2->mataElektif; //function in model
                    //                $individualUmumAcademic = $model2->mataUmum;

                    $individualTerasAcademic = Kehadiran::calculateMataTotalStaff('3', $id, $currentYear);
                    $individualElektifAcademic = Kehadiran::calculateMataTotalStaff('4', $id, $currentYear);
                    $individualUmumAcademic = Kehadiran::calculateMataTotalStaff('1', $id, $currentYear);
                    //$individualUmumAcademic = Kehadiran::getMata('umum');
                } else {
                    $individualTerasAcademic = 0;
                    $individualElektifAcademic = 0;
                    $individualUmumAcademic = 0;
                }
            } else {

                $individualTerasAcademic = $modelRpt->idp_mata_teras;
                $individualElektifAcademic = $modelRpt->idp_mata_elektif;
                $individualUmumAcademic = $modelRpt->idp_mata_sumbangan;
            }
            /*             * ******************************************************************* */
            //determine IDP percentage and progress-bar colour
            if ($individualElektifAcademic >= $minElektifAcademic) {
                $percentageElektif = 100;
                $eprogressBarColour = 'progress-bar progress-bar-success';

                //electiveIDPPoint that are counted
                $elektifTrue = $minElektifAcademic;
            } else {
                $percentageElektif = round(($individualElektifAcademic / $minElektifAcademic) * 100);

                //electiveIDPPoint that are counted
                $elektifTrue = $individualElektifAcademic;

                if ($percentageElektif >= 50) {
                    $eprogressBarColour = 'progress-bar progress-bar-striped';
                } else {
                    $eprogressBarColour = 'progress-bar progress-bar-danger';
                }
            }

            /*             * ************************************************************************ */
            if ($individualTerasAcademic >= $minTerasAcademic) {
                $percentageTerasAcademic = 100;
                $taprogressBarColour = 'progress-bar progress-bar-success';

                $terasTrue = $minTerasAcademic;
            } else {
                $percentageTerasAcademic = round(($individualTerasAcademic / $minTerasAcademic) * 100);

                $terasTrue = $individualTerasAcademic;

                if ($percentageTerasAcademic >= 50) {
                    $taprogressBarColour = 'progress-bar progress-bar-striped';
                } else {
                    $taprogressBarColour = 'progress-bar progress-bar-danger';
                }
            }

            /*             * ************************************************************************** */
            if ($individualUmumAcademic >= $minUmumAcademic) {
                $percentageUmumAcademic = 100;
                $uaprogressBarColour = 'progress-bar progress-bar-success';

                $umumTrue = $minUmumAcademic;
            } else {
                $percentageUmumAcademic = round(($individualUmumAcademic / $minUmumAcademic) * 100);

                $umumTrue = $individualUmumAcademic;

                if ($percentageUmumAcademic >= 50) {
                    $uaprogressBarColour = 'progress-bar progress-bar-striped';
                } else {
                    $uaprogressBarColour = 'progress-bar progress-bar-danger';
                }
            }

            /*             * ************************************************************************** */
            //amountOfPoint that are actually counted
            $jumlahMataAmbilKira = $elektifTrue + $terasTrue + $umumTrue;

            /*             * ******************************** get list of attended latihan (old) ************************************** */
            if ($currentYear <= 2019) {
                $teras = VCpdLatihan::find()
                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 3 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
                    ->orderBy("vcl_tkh_mula")
                    ->all();

                $elektif = VCpdLatihan::find()
                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 4 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
                    ->orderBy("vcl_tkh_mula")
                    ->all();

                $umum = VCpdLatihan::find()
                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 1 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear")
                    ->orderBy("vcl_tkh_mula")
                    ->all();
            } else {

                //            $teras = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 3])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $teras = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 3])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                //            $elektif = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 4])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $elektif = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 4])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                //            $umum = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 1])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $umum = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 1])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();
            }

            $attended = SiriLatihan::find()
                ->joinWith('sasaran5.sasaran55')
                ->joinWith('sasaranb')
                ->where(['idp_kehadiran.staffID' => $id])
                ->andWhere(['<>', 'idp_kehadiran.kategoriKursusID',  1])
                ->andWhere(['idp_tbl_bpl.pesertaID' => $id, 'idp_tbl_bpl.statusBorang' => 1])
                ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                ->all();



            /*             * ********************************************************************************************************************** */

            if ($currentYear >= 2020) {
                return $this->render('profil', [
                    'model' => $model,
                    'model2' => $model2,
                    'model3' => $model3,
                    'modelcpdgroup' => $modelcpdgroup,
                    'model4' => $model4,
                    'model5' => $model5,
                    'minTerasAcademic' => $minTerasAcademic,
                    'minElektifAcademic' => $minElektifAcademic,
                    'minUmumAcademic' => $minUmumAcademic,
                    'percentageElektif' => $percentageElektif,
                    'percentageTerasAcademic' => $percentageTerasAcademic,
                    'percentageUmumAcademic' => $percentageUmumAcademic,
                    'teras' => $teras,
                    'elektif' => $elektif,
                    'umum' => $umum,
                    'eprogressBarColour' => $eprogressBarColour,
                    'taprogressBarColour' => $taprogressBarColour,
                    'uaprogressBarColour' => $uaprogressBarColour,
                    'jumlahMataAmbilKira' => $jumlahMataAmbilKira,
                    'staffCategory' => $staffCategory,
                    'individualTerasAcademic' => $individualTerasAcademic,
                    'individualElektifAcademic' => $individualElektifAcademic,
                    'individualUmumAcademic' => $individualUmumAcademic,
                    'attended' => $attended,
                    'modelRpt' => $modelRpt,
                    'staffChosen' => $staffChosen,
                    'userStat' => $userStat,
                    'userStat2' => $userStat2,
                    'tahun' => $currentYear
                ]);
            } else {
                return $this->render('profile', [
                    'model3' => $model3,
                    'model4' => $model4,
                    'model5' => $model5,
                    'minTerasAcademic' => $minTerasAcademic,
                    'minElektifAcademic' => $minElektifAcademic,
                    'minUmumAcademic' => $minUmumAcademic,
                    'percentageElektif' => $percentageElektif,
                    'percentageTerasAcademic' => $percentageTerasAcademic,
                    'percentageUmumAcademic' => $percentageUmumAcademic,
                    'teras' => $teras,
                    'elektif' => $elektif,
                    'umum' => $umum,
                    'eprogressBarColour' => $eprogressBarColour,
                    'taprogressBarColour' => $taprogressBarColour,
                    'uaprogressBarColour' => $uaprogressBarColour,
                    'jumlahMataAmbilKira' => $jumlahMataAmbilKira,
                    'staffCategory' => $staffCategory,
                    'individualTerasAcademic' => $individualTerasAcademic,
                    'individualElektifAcademic' => $individualElektifAcademic,
                    'individualUmumAcademic' => $individualUmumAcademic,
                    'attended' => $attended,
                    'modelRpt' => $modelRpt,
                    'staffChosen' => $staffChosen,
                    'userStat' => $userStat,
                    'userStat2' => $userStat2,
                    'tahun' => $currentYear
                ]);
            }
        }

        //administrationStaff
        else {

            $staffCategory = 'ADMINISTRATION';

            //            $minElektif = $modelcpdgroup->minElektif; //fixed data in db
            //            $minTerasUniversiti = $modelcpdgroup->minTerasUni;
            //            $minTerasSkim = $modelcpdgroup->minTerasSkim;

            $minElektif = $modelRpt->idp_kom_elektif; //fixed data in db

            if ($currentYear >= 2020) {
                $minTerasUniversiti = $modelRpt->idp_kom_teras_uni;
                $minTerasSkim = $modelRpt->idp_kom_teras_skim;
            } else {
                $minTerasUniversiti = $modelRpt->matamin_teras_uni;
                $minTerasSkim = $modelRpt->matamin_teras_skim;
            }


            //latestStaffIDPPoint for each sub
            if ($currentYear >= 2020) {
                if ($model2) {

                    //                $individualElektif = $model2->mataElektif; //function in model
                    //                $individualTerasUniversiti = $model2->mataTerasUni;
                    //                $individualTerasSkim = $model2->mataTerasSkim;
                    //                $individualUmum = $model2->mataUmum;
                    //                $individualElektif = Kehadiran::getMata('elektif');
                    //                $individualTerasUniversiti = Kehadiran::getMata('terasUni');
                    //                $individualTerasSkim = Kehadiran::getMata('terasSkim');
                    //$individualUmum = Kehadiran::getMata('umum');
                    $individualElektif = Kehadiran::calculateMataTotalStaff('4', $id, $currentYear);
                    $individualTerasUniversiti = Kehadiran::calculateMataTotalStaff('5', $id, $currentYear);
                    $individualTerasSkim = Kehadiran::calculateMataTotalStaff('6', $id, $currentYear);
                    $individualUmum = Kehadiran::calculateMataTotalStaff('1', $id, $currentYear);
                } else {
                    $individualElektif = 0;
                    $individualTerasUniversiti = 0;
                    $individualTerasSkim = 0;
                    $individualUmum = 0;
                }
            } else {

                $individualElektif = $modelRpt->idp_mata_elektif;
                $individualTerasUniversiti = $modelRpt->idp_teras_uni;
                $individualTerasSkim = $modelRpt->idp_teras_skim;
                $individualUmum = $modelRpt->idp_mata_sumbangan;
            }

            /*             * ******************************************************************* */
            //determine IDP percentage and progress-bar colour
            if ($individualElektif >= $minElektif) {
                $percentageElektif = 100;
                $eprogressBarColour = 'progress-bar progress-bar-success';

                //electiveIDPPoint that are counted
                $elektifTrue = $minElektif;
            } else {
                $percentageElektif = round(($individualElektif / $minElektif) * 100);

                //electiveIDPPoint that are counted
                $elektifTrue = $individualElektif;

                if ($percentageElektif >= 50) {
                    $eprogressBarColour = 'progress-bar progress-bar-striped';
                } else {
                    $eprogressBarColour = 'progress-bar progress-bar-danger';
                }
            }

            /*             * ************************************************************************ */
            if ($individualTerasUniversiti >= $minTerasUniversiti) {
                $percentageTerasUniversiti = 100;
                $uprogressBarColour = 'progress-bar progress-bar-success';

                $terasUniTrue = $minTerasUniversiti;
            } else {
                $percentageTerasUniversiti = round(($individualTerasUniversiti / $minTerasUniversiti) * 100);

                $terasUniTrue = $individualTerasUniversiti;

                if ($percentageTerasUniversiti >= 50) {
                    $uprogressBarColour = 'progress-bar progress-bar-striped';
                } else {
                    $uprogressBarColour = 'progress-bar progress-bar-danger';
                }
            }

            /*             * ************************************************************************** */
            if ($individualTerasSkim >= $minTerasSkim) {
                $percentageTerasSkim = 100;
                $sprogressBarColour = 'progress-bar progress-bar-success';

                $terasSkimTrue = $minTerasSkim;
            } else {
                $percentageTerasSkim = round(($individualTerasSkim / $minTerasSkim) * 100);

                $terasSkimTrue = $individualTerasSkim;

                if ($percentageTerasSkim >= 50) {
                    $sprogressBarColour = 'progress-bar progress-bar-striped';
                } else {
                    $sprogressBarColour = 'progress-bar progress-bar-danger';
                }
            }

            /*             * ************************************************************************** */
            //amountOfPoint that are actually counted
            $jumlahMataAmbilKira = $elektifTrue + $terasUniTrue + $terasSkimTrue;

            if ($jumlahMataAmbilKira >= $modelRpt->idp_mata_min) {
                $sumbanganlnpt = 8;
            } else {
                $percentagelnpt = round(($jumlahMataAmbilKira / $modelRpt->idp_mata_min) * 100);

                if ($percentagelnpt >= 75) {
                    $sumbanganlnpt = 3;
                } else {
                    $sumbanganlnpt = 0;
                }
            }

            /* * ****************************** get attended latihan list (old) **************************** */
            if ($currentYear <= 2019) {
                $teras = VCpdLatihan::find()
                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 5 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
                    ->orderBy("vcl_tkh_mula")
                    ->all();

                $skim = VCpdLatihan::find()
                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 6 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
                    ->orderBy("vcl_tkh_mula")
                    ->all();

                $elektif = VCpdLatihan::find()
                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 4 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
                    ->orderBy("vcl_tkh_mula")
                    ->all();

                $umum = VCpdLatihan::find()
                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 1 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear")
                    ->orderBy("vcl_tkh_mula")
                    ->all();
            } else {

                //            $teras = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 5])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $teras = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 5])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                //            $skim = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 6])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $skim = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 6])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                //            $elektif = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 4])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $elektif = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 4])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                //            $umum = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 1])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $umum = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 1])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();
            }

            $attended = SiriLatihan::find()
                ->joinWith('sasaran5.sasaran55')
                ->joinWith('sasaranb')
                ->where(['idp_kehadiran.staffID' => $id])
                ->andWhere(['<>', 'idp_kehadiran.kategoriKursusID',  1])
                ->andWhere(['idp_tbl_bpl.pesertaID' => $id, 'idp_tbl_bpl.statusBorang' => 1])
                ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                ->all();

            /*             * ********************************************************************************************* */

            //progressBarColour for UMUM (administration)
            //no limit and no minimum
            $mprogressBarColour = 'progress-bar progress-bar-success';

            if ($currentYear >= 2020) {

                return $this->render('profil', [
                    //'model' => $model,
                    //'model2' => $model2,
                    'model3' => $model3,
                    //'modelcpdgroup' => $modelcpdgroup,
                    'model4' => $model4,
                    'model5' => $model5,
                    'percentageElektif' => $percentageElektif,
                    'percentageTerasUniversiti' => $percentageTerasUniversiti,
                    'percentageTerasSkim' => $percentageTerasSkim,
                    'teras' => $teras,
                    'skim' => $skim,
                    'elektif' => $elektif,
                    'umum' => $umum,
                    'eprogressBarColour' => $eprogressBarColour,
                    'uprogressBarColour' => $uprogressBarColour,
                    'sprogressBarColour' => $sprogressBarColour,
                    'mprogressBarColour' => $mprogressBarColour,
                    'jumlahMataAmbilKira' => $jumlahMataAmbilKira,
                    'sumbanganlnpt' => $sumbanganlnpt,
                    'staffCategory' => $staffCategory,
                    'individualTerasUniversiti' => $individualTerasUniversiti,
                    'individualTerasSkim' => $individualTerasSkim,
                    'individualElektif' => $individualElektif,
                    'individualUmum' => $individualUmum,
                    'attended' => $attended,
                    'modelRpt' => $modelRpt,
                    'staffChosen' => $staffChosen,
                    'userStat' => $userStat,
                    'userStat2' => $userStat2,
                    'minElektif' => $minElektif,
                    'minTerasUniversiti' => $minTerasUniversiti,
                    'minTerasSkim' => $minTerasSkim,
                    'tahun' => $currentYear
                ]);
            } else {

                return $this->render('profile', [
                    //'model' => $model,
                    //'model2' => $model2,
                    'model3' => $model3,
                    //'modelcpdgroup' => $modelcpdgroup,
                    'model4' => $model4,
                    'model5' => $model5,
                    'percentageElektif' => $percentageElektif,
                    'percentageTerasUniversiti' => $percentageTerasUniversiti,
                    'percentageTerasSkim' => $percentageTerasSkim,
                    'teras' => $teras,
                    'skim' => $skim,
                    'elektif' => $elektif,
                    'umum' => $umum,
                    'eprogressBarColour' => $eprogressBarColour,
                    'uprogressBarColour' => $uprogressBarColour,
                    'sprogressBarColour' => $sprogressBarColour,
                    'mprogressBarColour' => $mprogressBarColour,
                    'jumlahMataAmbilKira' => $jumlahMataAmbilKira,
                    'sumbanganlnpt' => $sumbanganlnpt,
                    'staffCategory' => $staffCategory,
                    'individualTerasUniversiti' => $individualTerasUniversiti,
                    'individualTerasSkim' => $individualTerasSkim,
                    'individualElektif' => $individualElektif,
                    'individualUmum' => $individualUmum,
                    'attended' => $attended,
                    'modelRpt' => $modelRpt,
                    'staffChosen' => $staffChosen,
                    'userStat' => $userStat,
                    'userStat2' => $userStat2,
                    'minElektif' => $minElektif,
                    'minTerasUniversiti' => $minTerasUniversiti,
                    'minTerasSkim' => $minTerasSkim,
                    'tahun' => $currentYear
                ]);
            }
        }
    }

    public function actionIndex()
    {
        //get current user ID
        $id = Yii::$app->user->getId();
        //get current year
        $currentYear = date('Y');

        /** major changes 15/09/2020 **/
        /** TEST **/

        $modelRpt = RptStatistikIdp::find()
            ->where(['icno' => $id, 'tahun' => $currentYear])
            ->one();

        if ($modelRpt) {

            /*********************************/

            $model = new Idp(); //table from V3 idp.v_idp_profil
            //$model2 = new VCpdLatihan(); //table from V3 hronline.v_cpd_latihan
            $model2 = IdpMata::find()
                ->where(['staffID' => $id])
                ->andWhere(['tahun' => $currentYear])
                ->one();

            $model4 = new SetPegawai();
            $model5 = SetPegawai::find()->where(['pemohon_icno' => $id])->one();

            $model3 = Tblprcobiodata::findOne(['ICNO' => $id]);
            $gredj = $model3->jawatan->gred;

            $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj, 'tahun' => $currentYear])->one();

            if ($modelcpdgroupgj) {

                $cpdgroup = $modelcpdgroupgj->cpdgroup;
                $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup, 'tahun' => $currentYear])->one();
            } else {
                return $this->redirect(Yii::$app->request->referrer);
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat', 'type' => 'success', 'msg' => 'Ralat! Gred jawatan terkini anda tiada IDP']);
            }

            //$modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup])->one();
            //$model4 = SetPegawai::findOne(['pemohon_icno' => $id]);
            //academicStaff
            //if ($model3->kategori == 1){
            if ($model3->jawatan->job_category == 1) {

                $staffCategory = 'ACADEMIC';

                //            $minMata = $modelcpdgroup->mataMin;
                //
                //            $minTerasAcademic = round(0.5 * $minMata);
                //            $minElektifAcademic = round(0.3 * $minMata);
                //            $minUmumAcademic = round(0.2 * $minMata);

                $minMata = $modelRpt->idp_mata_min;

                $minTerasAcademic = $modelRpt->idp_kom_teras;
                $minElektifAcademic = $modelRpt->idp_kom_elektif;
                $minUmumAcademic = $modelRpt->idp_kom_umum;

                //latestStaffIDPPoint for each sub
                if ($model2) {
                    //                $individualTerasAcademic = $model2->mataTeras;
                    //                $individualElektifAcademic = $model2->mataElektif; //function in model
                    //                $individualUmumAcademic = $model2->mataUmum;

                    $individualTerasAcademic = Kehadiran::calculateMataTotal('3');
                    $individualElektifAcademic = Kehadiran::calculateMataTotal('4');
                    $individualUmumAcademic = Kehadiran::calculateMataTotal('1');
                    //$individualUmumAcademic = Kehadiran::getMata('umum');
                } else {
                    $individualTerasAcademic = 0;
                    $individualElektifAcademic = 0;
                    $individualUmumAcademic = 0;
                }
                /*             * ******************************************************************* */
                //determine IDP percentage and progress-bar colour
                if ($individualElektifAcademic >= $minElektifAcademic) {
                    $percentageElektif = 100;
                    $eprogressBarColour = 'progress-bar progress-bar-success';

                    //electiveIDPPoint that are counted
                    $elektifTrue = $minElektifAcademic;
                } else {
                    $percentageElektif = round(($individualElektifAcademic / $minElektifAcademic) * 100);

                    //electiveIDPPoint that are counted
                    $elektifTrue = $individualElektifAcademic;

                    if ($percentageElektif >= 50) {
                        $eprogressBarColour = 'progress-bar progress-bar-striped';
                    } else {
                        $eprogressBarColour = 'progress-bar progress-bar-danger';
                    }
                }

                /*             * ************************************************************************ */
                if ($individualTerasAcademic >= $minTerasAcademic) {
                    $percentageTerasAcademic = 100;
                    $taprogressBarColour = 'progress-bar progress-bar-success';

                    $terasTrue = $minTerasAcademic;
                } else {
                    $percentageTerasAcademic = round(($individualTerasAcademic / $minTerasAcademic) * 100);

                    $terasTrue = $individualTerasAcademic;

                    if ($percentageTerasAcademic >= 50) {
                        $taprogressBarColour = 'progress-bar progress-bar-striped';
                    } else {
                        $taprogressBarColour = 'progress-bar progress-bar-danger';
                    }
                }

                /*             * ************************************************************************** */
                if ($individualUmumAcademic >= $minUmumAcademic) {
                    $percentageUmumAcademic = 100;
                    $uaprogressBarColour = 'progress-bar progress-bar-success';

                    $umumTrue = $minUmumAcademic;
                } else {
                    $percentageUmumAcademic = round(($individualUmumAcademic / $minUmumAcademic) * 100);

                    $umumTrue = $individualUmumAcademic;

                    if ($percentageUmumAcademic >= 50) {
                        $uaprogressBarColour = 'progress-bar progress-bar-striped';
                    } else {
                        $uaprogressBarColour = 'progress-bar progress-bar-danger';
                    }
                }

                /*             * ************************************************************************** */
                //amountOfPoint that are actually counted
                $jumlahMataAmbilKira = $elektifTrue + $terasTrue + $umumTrue;

                /*             * ******************************** get list of attended latihan (old) ************************************** */
                //            $teras = VCpdLatihan::find()
                //                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 3 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
                //                    ->orderBy("vcl_tkh_mula")
                //                    ->all();
                //
                //            $elektif = VCpdLatihan::find()
                //                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 4 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
                //                    ->orderBy("vcl_tkh_mula")
                //                    ->all();
                //
                //            $umum = VCpdLatihan::find()
                //                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 1 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear")
                //                    ->orderBy("vcl_tkh_mula")
                //                    ->all();
                //            $teras = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 3])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $teras = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 3])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                //            $elektif = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 4])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $elektif = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 4])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                //            $umum = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 1])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $umum = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 1])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                $attended = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->joinWith('sasaranb')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['<>', 'idp_kehadiran.kategoriKursusID',  1])
                    ->andWhere(['idp_tbl_bpl.pesertaID' => $id, 'idp_tbl_bpl.statusBorang' => 1])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                $attendedprevious = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->joinWith('sasaranb')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['<>', 'idp_kehadiran.kategoriKursusID',  1])
                    ->andWhere(['idp_tbl_bpl.pesertaID' => $id, 'idp_tbl_bpl.statusBorang' => 1])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => date("Y", strtotime("-1 year"))])
                    ->all();

                $akanDatang = PermohonanLatihan::find()
                    ->joinWith('sasaran6')
                    ->where(['staffID' => $id, 'statusPermohonan' => 'DILULUSKAN', 'statusSiriLatihan' => 'ACTIVE'])
                    ->orWhere(['staffID' => $id, 'statusPermohonan' => 'DILULUSKAN', 'statusSiriLatihan' => 'SEDANG BERJALAN'])
                    ->all();

                $b = [];
                foreach ($akanDatang as $a) {

                    //                $checkHadir = Kehadiran::find()
                    //                        ->joinWith('sasaran9')
                    //                        ->where(['siriLatihanID' => $a->siriLatihanID, 'staffID' => $a->staffID])
                    //                        ->one();
                    //                
                    //                if (!$checkHadir){
                    //                    array_push($b, $a->siriLatihanID);
                    //                }

                    if (($a->sasaran6->tarikhMula >= date('Y-m-d') && $a->sasaran6->tarikhAkhir >= date('Y-m-d')) ||
                        ($a->sasaran6->tarikhMula <= date('Y-m-d') && $a->sasaran6->tarikhAkhir >= date('Y-m-d'))
                    ) {
                        array_push($b, $a->siriLatihanID);
                    }
                }

                $bb = PermohonanLatihan::find()
                    ->joinWith('sasaran6')
                    ->where(['staffID' => $id, 'idp_permohonanlatihan.siriLatihanID' => $b])
                    ->orderBy(['tarikhMula' => SORT_ASC])
                    ->limit(3)
                    ->all();

                /*             * ********************************************************************************************************************** */

                return $this->render('index_academic', [
                    'model' => $model,
                    'model2' => $model2,
                    'model3' => $model3,
                    'modelcpdgroup' => $modelcpdgroup,
                    'model4' => $model4,
                    'model5' => $model5,
                    'minTerasAcademic' => $minTerasAcademic,
                    'minElektifAcademic' => $minElektifAcademic,
                    'minUmumAcademic' => $minUmumAcademic,
                    'percentageElektif' => $percentageElektif,
                    'percentageTerasAcademic' => $percentageTerasAcademic,
                    'percentageUmumAcademic' => $percentageUmumAcademic,
                    'teras' => $teras,
                    'elektif' => $elektif,
                    'umum' => $umum,
                    'eprogressBarColour' => $eprogressBarColour,
                    'taprogressBarColour' => $taprogressBarColour,
                    'uaprogressBarColour' => $uaprogressBarColour,
                    'jumlahMataAmbilKira' => $jumlahMataAmbilKira,
                    'staffCategory' => $staffCategory,
                    'individualTerasAcademic' => $individualTerasAcademic,
                    'individualElektifAcademic' => $individualElektifAcademic,
                    'individualUmumAcademic' => $individualUmumAcademic,
                    'attended' => $attended,
                    'akanDatang' => $bb,
                    'modelRpt' => $modelRpt,
                    'attendedprevious' => $attendedprevious,
                ]);
            }

            //administrationStaff
            else {

                $staffCategory = 'ADMINISTRATION';

                //            $minElektif = $modelcpdgroup->minElektif; //fixed data in db
                //            $minTerasUniversiti = $modelcpdgroup->minTerasUni;
                //            $minTerasSkim = $modelcpdgroup->minTerasSkim;

                $minElektif = $modelRpt->idp_kom_elektif; //fixed data in db
                $minTerasUniversiti = $modelRpt->idp_kom_teras_uni;
                $minTerasSkim = $modelRpt->idp_kom_teras_skim;

                //latestStaffIDPPoint for each sub
                if ($model2) {

                    //                $individualElektif = $model2->mataElektif; //function in model
                    //                $individualTerasUniversiti = $model2->mataTerasUni;
                    //                $individualTerasSkim = $model2->mataTerasSkim;
                    //                $individualUmum = $model2->mataUmum;
                    //                $individualElektif = Kehadiran::getMata('elektif');
                    //                $individualTerasUniversiti = Kehadiran::getMata('terasUni');
                    //                $individualTerasSkim = Kehadiran::getMata('terasSkim');
                    //$individualUmum = Kehadiran::getMata('umum');
                    $individualElektif = Kehadiran::calculateMataTotal('4');
                    $individualTerasUniversiti = Kehadiran::calculateMataTotal('5');
                    $individualTerasSkim = Kehadiran::calculateMataTotal('6');
                    $individualUmum = Kehadiran::calculateMataTotal('1');
                    //                $individualElektif = $modelRpt->idp_mata_elektif;
                    //                $individualTerasUniversiti = $modelRpt->idp_mata_teras_uni;
                    //                $individualTerasSkim = $modelRpt->idp_mata_teras_skim;
                    //                $individualUmum = $modelRpt->idp_mata_umum;
                } else {
                    $individualElektif = 0;
                    $individualTerasUniversiti = 0;
                    $individualTerasSkim = 0;
                    $individualUmum = 0;
                }

                /*             * ******************************************************************* */
                //determine IDP percentage and progress-bar colour
                if ($individualElektif >= $minElektif) {
                    $percentageElektif = 100;
                    $eprogressBarColour = 'progress-bar progress-bar-success';

                    //electiveIDPPoint that are counted
                    $elektifTrue = $minElektif;
                } else {
                    $percentageElektif = round(($individualElektif / $minElektif) * 100);

                    //electiveIDPPoint that are counted
                    $elektifTrue = $individualElektif;

                    if ($percentageElektif >= 50) {
                        $eprogressBarColour = 'progress-bar progress-bar-striped';
                    } else {
                        $eprogressBarColour = 'progress-bar progress-bar-danger';
                    }
                }

                /*             * ************************************************************************ */
                if ($individualTerasUniversiti >= $minTerasUniversiti) {
                    $percentageTerasUniversiti = 100;
                    $uprogressBarColour = 'progress-bar progress-bar-success';

                    $terasUniTrue = $minTerasUniversiti;
                } else {
                    $percentageTerasUniversiti = round(($individualTerasUniversiti / $minTerasUniversiti) * 100);

                    $terasUniTrue = $individualTerasUniversiti;

                    if ($percentageTerasUniversiti >= 50) {
                        $uprogressBarColour = 'progress-bar progress-bar-striped';
                    } else {
                        $uprogressBarColour = 'progress-bar progress-bar-danger';
                    }
                }

                /*             * ************************************************************************** */
                if ($individualTerasSkim >= $minTerasSkim) {
                    $percentageTerasSkim = 100;
                    $sprogressBarColour = 'progress-bar progress-bar-success';

                    $terasSkimTrue = $minTerasSkim;
                } else {
                    $percentageTerasSkim = round(($individualTerasSkim / $minTerasSkim) * 100);

                    $terasSkimTrue = $individualTerasSkim;

                    if ($percentageTerasSkim >= 50) {
                        $sprogressBarColour = 'progress-bar progress-bar-striped';
                    } else {
                        $sprogressBarColour = 'progress-bar progress-bar-danger';
                    }
                }

                /*             * ************************************************************************** */
                //amountOfPoint that are actually counted
                $jumlahMataAmbilKira = $elektifTrue + $terasUniTrue + $terasSkimTrue;

                //if ($jumlahMataAmbilKira >= $modelcpdgroup->mataMin) {
                if ($jumlahMataAmbilKira >= $modelRpt->idp_mata_min) {
                    $sumbanganlnpt = 8;
                } else {
                    $percentagelnpt = round(($jumlahMataAmbilKira / $modelRpt->idp_mata_min) * 100);

                    if ($percentagelnpt >= 75) {
                        $sumbanganlnpt = 3;
                    } else {
                        $sumbanganlnpt = 0;
                    }
                }

                /*             * ****************************** get attended latihan list (old) **************************** */
                //            $teras = VCpdLatihan::find()
                //                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 5 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
                //                    ->orderBy("vcl_tkh_mula")
                //                    ->all();
                //
                //            $skim = VCpdLatihan::find()
                //                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 6 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
                //                    ->orderBy("vcl_tkh_mula")
                //                    ->all();
                //
                //            $elektif = VCpdLatihan::find()
                //                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 4 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear and hantar_penilaian = 1")
                //                    ->orderBy("vcl_tkh_mula")
                //                    ->all();
                //
                //            $umum = VCpdLatihan::find()
                //                    ->where("vcl_id_staf = $id and vcl_kod_kompetensi = 1 and SUBSTRING(vcl_tkh_mula,1,4) = $currentYear")
                //                    ->orderBy("vcl_tkh_mula")
                //                    ->all();
                //            $teras = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 5])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $teras = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 5])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                //            $skim = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 6])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $skim = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 6])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                //            $elektif = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 4])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $elektif = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 4])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                //            $umum = Kehadiran::find()
                //                    ->where(['staffID' => $id])
                //                    ->andWhere(['kategoriKursusID' => 1])
                //                    ->orderBy(['tarikhMasa' => SORT_DESC])
                //                    ->all();

                $umum = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => 1])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                $attended = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->joinWith('sasaranb')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['<>', 'idp_kehadiran.kategoriKursusID',  1])
                    ->andWhere(['idp_tbl_bpl.pesertaID' => $id, 'idp_tbl_bpl.statusBorang' => 1])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();

                $attendedprevious = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->joinWith('sasaranb')
                    ->where(['idp_kehadiran.staffID' => $id])
                    ->andWhere(['<>', 'idp_kehadiran.kategoriKursusID',  1])
                    ->andWhere(['idp_tbl_bpl.pesertaID' => $id, 'idp_tbl_bpl.statusBorang' => 1])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => date("Y", strtotime("-1 year"))])
                    ->all();

                $akanDatang = PermohonanLatihan::find()
                    ->joinWith('sasaran6')
                    ->where(['staffID' => $id, 'statusPermohonan' => 'DILULUSKAN', 'statusSiriLatihan' => 'ACTIVE'])
                    ->orWhere(['staffID' => $id, 'statusPermohonan' => 'DILULUSKAN', 'statusSiriLatihan' => 'SEDANG BERJALAN'])
                    ->all();

                $b = [];
                foreach ($akanDatang as $a) {

                    //                $checkHadir = Kehadiran::find()
                    //                        ->joinWith('sasaran9')
                    //                        ->where(['siriLatihanID' => $a->siriLatihanID, 'staffID' => $a->staffID])
                    //                        ->one();
                    //                
                    //                if (!$checkHadir){
                    //                    array_push($b, $a->siriLatihanID);
                    //                }

                    if (($a->sasaran6->tarikhMula >= date('Y-m-d') && $a->sasaran6->tarikhAkhir >= date('Y-m-d')) ||
                        ($a->sasaran6->tarikhMula <= date('Y-m-d') && $a->sasaran6->tarikhAkhir >= date('Y-m-d'))
                    ) {
                        array_push($b, $a->siriLatihanID);
                    }
                }

                $b = PermohonanLatihan::find()
                    ->joinWith('sasaran6')
                    ->where(['staffID' => $id, 'idp_permohonanlatihan.siriLatihanID' => $b])
                    ->orderBy(['tarikhMula' => SORT_ASC])
                    ->limit(3)
                    ->all();

                /*             * ********************************************************************************************* */

                //progressBarColour for UMUM (administration)
                //no limit and no minimum
                $mprogressBarColour = 'progress-bar progress-bar-success';

                return $this->render('index', [
                    'model' => $model,
                    'model2' => $model2,
                    'model3' => $model3,
                    'modelcpdgroup' => $modelcpdgroup,
                    'model4' => $model4,
                    'model5' => $model5,
                    'percentageElektif' => $percentageElektif,
                    'percentageTerasUniversiti' => $percentageTerasUniversiti,
                    'percentageTerasSkim' => $percentageTerasSkim,
                    'teras' => $teras,
                    'skim' => $skim,
                    'elektif' => $elektif,
                    'umum' => $umum,
                    'eprogressBarColour' => $eprogressBarColour,
                    'uprogressBarColour' => $uprogressBarColour,
                    'sprogressBarColour' => $sprogressBarColour,
                    'mprogressBarColour' => $mprogressBarColour,
                    'jumlahMataAmbilKira' => $jumlahMataAmbilKira,
                    'sumbanganlnpt' => $sumbanganlnpt,
                    'staffCategory' => $staffCategory,
                    'individualTerasUniversiti' => $individualTerasUniversiti,
                    'individualTerasSkim' => $individualTerasSkim,
                    'individualElektif' => $individualElektif,
                    'individualUmum' => $individualUmum,
                    'attended' => $attended,
                    'akanDatang' => $b,
                    'modelRpt' => $modelRpt,
                    'minElektif' => $minElektif,
                    'minTerasUniversiti' => $minTerasUniversiti,
                    'minTerasSkim' => $minTerasSkim,
                    'attendedprevious' => $attendedprevious,
                ]);
            }
        } //closed RPT checking

        else {
            Yii::$app->session->setFlash('alert', ['title' => 'Ralat', 'type' => 'warning', 'msg' => 'Ralat, tiada rekod IDP. Sila berhubung dengan unit latihan Bahagian Sumber Manusia (BSM).']);
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionViewSenaraiPermohonanIndividu($tahun = null, $dept_id = null)
    {
        $id = Yii::$app->user->getId();

        $currentYear = date('Y');

        if (!$tahun) {
            $tahun = $currentYear;
        }

        //        $mohonLatihan = PermohonanMataIdpIndividu::find()
        //                ->where("pemohonID = $id and statusPermohonan = '1'")
        //                ->orWhere("pemohonID = $id and statusPermohonan = '9'")
        //                ->orderBy('tarikhPohon');

        $mohonLatihan = PermohonanMataIdpIndividu::find()
            ->where("pemohonID = '$id'")
            ->andWhere(['YEAR(tarikhPohon)' => $tahun])
            ->orderBy(['tarikhPohon' => SORT_DESC]);

        $dataProviderA = new ActiveDataProvider([
            'query' => $mohonLatihan,
        ]);

        $pesertaLatihan = PermohonanMataIdpIndividu::find()
            ->joinWith('peserta')
            ->where("staffID = '$id'")
            ->andWhere(['YEAR(tarikhPohon)' => $tahun])
            ->andWhere(['<>', 'pemohonID', $id]);

        $dataProviderB = new ActiveDataProvider([
            'query' => $pesertaLatihan,
        ]);

        //        $mohonLatihanSah = PermohonanMataIdpIndividu::find()
        //                ->where("pemohonID = $id and statusPermohonan = '2'")
        //                ->orWhere("pemohonID = $id and statusPermohonan = '3'")
        //                ->orWhere("pemohonID = $id and statusPermohonan = '4'");
        //
        //        $dataProviderLatihanSah = new ActiveDataProvider([
        //            'query' => $mohonLatihanSah,
        //        ]);
        //
        //        $mohonLatihanLulus = PermohonanMataIdpIndividu::find()
        //                ->where("pemohonID = $id and statusSektor = '4'");
        //
        //        $dataProvider = new ActiveDataProvider([
        //            'query' => $mohonLatihanLulus,
        //        ]);

        return $this->render('view_senarai_permohonan_individu', [
            //                    'dataProvider' => $dataProvider,
            'dataProviderA' => $dataProviderA,
            'dataProviderB' => $dataProviderB,
            //                    'dataProviderLatihanSah' => $dataProviderLatihanSah,
            'tahun' => $tahun,
        ]);
    }

    public function actionTindakanPemohon($permohonanID)
    {

        $model = $this->findModelPermohonanMataIdpIndividu($permohonanID);

        $id = Yii::$app->user->getId();
        $check = Peserta::find()->where(['permohonanID' => $permohonanID, 'staffID' => $id]);

        if ($check && ($model->pemohonID != $id)) {
            $dataProvider = new ActiveDataProvider([
                'query' => $check,
            ]);
        } else {

            $model2 = Peserta::find()->where(['permohonanID' => $permohonanID]);
            $dataProvider = new ActiveDataProvider([
                'query' => $model2,
            ]);
        }

        $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', function ($model) {
            $a = $model['CONm'];
            return $a;
        }, 'department.fullname'); //groupby

        if (Yii::$app->request->post('submit') == 1) {
            if (Yii::$app->request->post('selection') != NULL) {

                $s = Yii::$app->request->post('selection');

                foreach ($s as $idp) {

                    $checkPeserta = Peserta::find()
                        ->where(['staffID' => $idp])
                        ->andWhere(['permohonanID' => $model->permohonanID])
                        ->one();

                    if (!$checkPeserta) {
                        $modelPeserta = new Peserta();
                        $modelPeserta->permohonanID = $model->permohonanID;
                        $modelPeserta->staffID = $idp;
                        //$modelPeserta->kategoriKursusID = $model->kompetensiPohon;

                        $modelBiod = Tblprcobiodata::find()->where(['ICNO' => $idp])->one();

                        if ($modelBiod) {
                            $jobC = $modelBiod->jawatan->job_category;

                            if ($jobC == '1') {
                                $modelPeserta->kategoriKursusID = $model->kompetensiPohon2;
                            } else {
                                $modelPeserta->kategoriKursusID = $model->kompetensiPohon;
                            }
                        }

                        if ($modelPeserta->save(false)) {
                            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Peserta berjaya ditambah']);
                        }
                    }
                }
            }
        } elseif (Yii::$app->request->post('submit') == 2) {
            if (Yii::$app->request->post('selection') != NULL) {

                $s = Yii::$app->request->post('selection');

                foreach ($s as $idp) {

                    $checkPeserta = Peserta::find()
                        ->where(['staffID' => $idp])
                        ->andWhere(['permohonanID' => $model->permohonanID])
                        ->one();

                    if (!$checkPeserta) {
                        $modelPeserta = new Peserta();
                        $modelPeserta->permohonanID = $model->permohonanID;
                        $modelPeserta->staffID = $idp;
                        //$modelPeserta->kategoriKursusID = $model->kompetensiPohon;

                        $modelBiod = Tblprcobiodata::find()->where(['ICNO' => $idp])->one();

                        if ($modelBiod) {
                            $jobC = $modelBiod->jawatan->job_category;

                            if ($jobC == '1') {
                                $modelPeserta->kategoriKursusID = $model->kompetensiPohon2;
                            } else {
                                $modelPeserta->kategoriKursusID = $model->kompetensiPohon;
                            }
                        }

                        if ($modelPeserta->save(false)) {
                            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Peserta berjaya ditambah dan permohonan telah dihantar']);
                        }
                    }
                }
            }

            $model->tarikhPohon = date('Y-m-d');

            /** check if the applier is a chief **/
            $checkChief = Department::find()
                ->where(['chief' => $id, 'isActive' => '1'])
                ->all();

            if ($checkChief) {
                $model->statusKJ = '2';
                $model->statusPermohonan = '2';
                $model->tarikhSemakanKJ = $model->tarikhPohon;
                $model->kjPenyemak = $id;
            } else {
                $model->statusPermohonan = '1';
            }

            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Peserta berjaya ditambah']);
            }
        }

        return $this->render('tindakan_pemohon', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'allStaf' => $allStaf,
            'id' => $id

        ]);
    }

    public function actionViewSenaraiPermohonan()
    {
        //get current user ID
        $id = Yii::$app->user->getId();

        //get current year
        $currentYear = date('Y');
        //        $currentYear = 2019;
        //boleh guna bila kita buat table biasa bukan gridview. Kalau gridview buang ->all()
        //        $mohonLatihan = PermohonanLatihan::find()
        //                ->where("staffID = $id and SUBSTRING(tarikhPermohonan,1,4) = $currentYear")
        //                ->all();

        $mohonLatihan = PermohonanLatihan::find()
            ->where("staffID = '$id' and SUBSTRING(tarikhPermohonan,1,4) = $currentYear and statusPermohonan <> 'DILULUSKAN'")
            ->orderBy('tarikhPermohonan');

        $dataProviderA = new ActiveDataProvider([
            'query' => $mohonLatihan,
        ]);

        /** test * */
        $checkDiperakukan = PermohonanLatihan::find()
            ->where("SUBSTRING(tarikhPermohonan,1,4) = $currentYear and statusPermohonan = 'DIPERAKUI'")
            ->all();

        foreach ($checkDiperakukan as $checkDiperakukan) {

            $dateAfter = date_create($checkDiperakukan->tarikhDiperakukan);
            $dateAfter2 = date_add($dateAfter, date_interval_create_from_date_string("7 days"));
            $dateAfter3 = date_format($dateAfter2, "Y-m-d");

            $currentDate = date('Y-m-d');

            if ($currentDate > $dateAfter3) {

                $checkDiperakukan->statusPermohonan = "DILULUSKAN";
                $checkDiperakukan->tarikhKelulusan = date('Y-m-d');
                $checkDiperakukan->tarikhSistemLulus = date('Y-m-d');
                $checkDiperakukan->sistemLulus = 1;
                $checkDiperakukan->save(false);
            }
        }
        /** /test * */
        $mohonLatihanLulus = PermohonanLatihan::find()
            ->where("staffID = '$id' and SUBSTRING(tarikhPermohonan,1,4) = $currentYear and statusPermohonan = 'DILULUSKAN' or staffID = '$id' and statusPermohonan = 'JEMPUTAN' and SUBSTRING(tarikhPermohonan,1,4) = $currentYear");

        $dataProvider = new ActiveDataProvider([
            'query' => $mohonLatihanLulus,
        ]);

        $mohonLatihanLuar = PermohonanKursusLuar::find()
            ->where("pemohonID = '$id'")
            ->andWhere(['YEAR(tarikhPohon)' => $currentYear]);

        $dataProviderLatihanLuar = new ActiveDataProvider([
            'query' => $mohonLatihanLuar,
        ]);

        return $this->render('view_senarai_permohonan', [
            'mohonLatihan' => $mohonLatihan,
            'mohonLatihanLulus' => $mohonLatihanLulus,
            'mohonLatihanLuar' => $mohonLatihanLuar,
            'dataProvider' => $dataProvider,
            'dataProviderA' => $dataProviderA,
            'dataProviderLatihanLuar' => $dataProviderLatihanLuar,
        ]);
    }

    public function actionViewSenaraiPermohonanJfpiu()
    {
        $userLevel = 'urusetiaJfpiu';

        //get current user ID
        $id = Yii::$app->user->getId();

        //get current year
        $currentYear = date('Y');
        //$currentYear = 2019;
        //boleh guna bila kita buat table biasa bukan gridview. Kalau gridview buang ->all()
        //        $mohonLatihan = PermohonanLatihan::find()
        //                ->where("staffID = $id and SUBSTRING(tarikhPermohonan,1,4) = $currentYear")
        //                ->all();

        $mohonLatihan = PermohonanMataLatihan::find()
            ->where("pemohonID = $id and SUBSTRING(tarikhPermohonan,1,4) = $currentYear");

        $dataProviderA = new ActiveDataProvider([
            'query' => $mohonLatihan,
        ]);

        $mohonLatihanLulus = PermohonanMataLatihan::find()
            ->where("pemohonID = $id and SUBSTRING(tarikhPermohonan,1,4) = $currentYear and statusPermohonan = 'DILULUSKAN'");

        $dataProvider = new ActiveDataProvider([
            'query' => $mohonLatihanLulus,
        ]);

        return $this->render('view_senarai_permohonan_jfpiu', [
            'mohonLatihan' => $mohonLatihan,
            'mohonLatihanLulus' => $mohonLatihanLulus,
            'dataProvider' => $dataProvider,
            'dataProviderA' => $dataProviderA,
            'userLevel' => $userLevel,
        ]);
    }

    public function actionViewSenaraiPermohonanJfpiuAdmin()
    {
        $userLevel = 'urusetiaLatihan';

        //get current user ID
        $id = Yii::$app->user->getId();

        //get current year
        //        $currentYear = date('Y');
        $currentYear = 2019;

        //boleh guna bila kita buat table biasa bukan gridview. Kalau gridview buang ->all()
        //        $mohonLatihan = PermohonanLatihan::find()
        //                ->where("staffID = $id and SUBSTRING(tarikhPermohonan,1,4) = $currentYear")
        //                ->all();

        $mohonLatihan = PermohonanMataLatihan::find();
        //->where("pemohonID = $id and SUBSTRING(tarikhPermohonan,1,4) = $currentYear");

        $dataProviderA = new ActiveDataProvider([
            'query' => $mohonLatihan,
        ]);

        $mohonLatihanLulus = PermohonanMataLatihan::find()
            ->where("statusPermohonan = 'DILULUSKAN'");

        $dataProvider = new ActiveDataProvider([
            'query' => $mohonLatihanLulus,
        ]);

        return $this->render('view_senarai_permohonan_jfpiu_admin', [
            'mohonLatihan' => $mohonLatihan,
            'mohonLatihanLulus' => $mohonLatihanLulus,
            'dataProvider' => $dataProvider,
            'dataProviderA' => $dataProviderA,
            'userLevel' => $userLevel,
        ]);
    }

    public function actionViewKursusSasaran()
    {
        //get current user ID
        $id = Yii::$app->user->getId();

        $currentYear = date('Y');

        $model = Tblprcobiodata::find()->where(['ICNO' => $id])->one();

        $campusUser = $model->campus_id;

        //get 'gredjawatan' from database
        $gredJawatan = $model->gredJawatan;
        $tahap = $model->tahapKhidmat;

        $jabatan = $model->DeptId;
        $kategori = $model->jawatan->job_category;

        /*         * ***************************** IDPv3 DATABASE *********************************
          //        $terasSasaran = VIdpKursusSasaran::find()
          //        ->where("kategori_id = 5 and gredjawatan = $gredJawatan and tahap = $tahap")
          //        ->all();
          //
          //        $skimSasaran = VIdpKursusSasaran::find()
          //        ->where("kategori_id = 6 and gredjawatan = $gredJawatan and tahap = $tahap")
          //        ->all();
          //
          //        $elektifSasaran = VIdpKursusSasaran::find()
          //        ->where("kategori_id = 4 and gredjawatan = $gredJawatan and tahap = $tahap" )
          //        ->all();
         *
         *
         */

        $kursusJemputan = KursusJemputan::find()
            ->joinWith('siriKursus.sasaran3')
            ->where(['deptID' => $jabatan, 'jobCategory' => NULL])
            ->orWhere(['deptID' => NULL, 'jobCategory' => $kategori])
            ->orWhere("jobCategory = $kategori and deptID = $jabatan");

        //        $kursusJemputan = KursusJemputan::find()
        //                        ->joinWith('siriKursus.sasaran3')
        //                        ->where("jobCategory = $kategori and deptID = $jabatan")
        //                        ->orWhere("jobCategory = $kategori and deptID = 0")
        //                        ->orWhere("jobCategory = 0 and deptID = $jabatan");
        //        var_dump($kursusJemputan);
        //        die();

        $dataProvider = new ActiveDataProvider([
            'query' => $kursusJemputan,
        ]);

        if ($model->jawatan->job_category == 2) {

            if ($campusUser != 1) {

                $terasSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 5 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();

                //            $terasSasaran = KursusSasaran::find()
                //                    ->where("kategoriKursusID = 5 and gredJawatanID = $gredJawatan and tahap = $tahap")
                //                    ->all();

                $skimSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 6 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();

                //        $skimSasaran = KursusSasaran::find()
                //                ->where("kategoriKursusID = 6 and gredJawatanID = $gredJawatan and tahap = $tahap")
                //                ->all();

                $elektifSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 4 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();

                //            $elektifSasaran = KursusSasaran::find()
                //                    ->where("kategoriKursusID = 4 and gredJawatanID = $gredJawatan and tahap = $tahap")
                //                    ->all();

                $impakTinggiSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 7 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();
            } else {

                $terasSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 5 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['=', 'idp_siriLatihan.kampusID', '1',])
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();

                $skimSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 6 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['=', 'idp_siriLatihan.kampusID', '1',])
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();

                $elektifSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 4 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['=', 'idp_siriLatihan.kampusID', '1',])
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();

                $impakTinggiSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 7 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['=', 'idp_siriLatihan.kampusID', '1',])
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();
            }

            return $this->render('view_kursus_sasaran', [
                'model' => $model,
                'terasSasaran' => $terasSasaran,
                'skimSasaran' => $skimSasaran,
                'elektifSasaran' => $elektifSasaran,
                'impakTinggiSasaran' => $impakTinggiSasaran,
                'kursusJemputan' => $kursusJemputan,
                'dataProvider' => $dataProvider,
            ]);
        } else {

            if ($campusUser != 1) {

                $terasSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 3 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();

                $elektifSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 4 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();

                $umumSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 1 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();

                $impakTinggiSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 7 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();
            } else {

                $terasSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 3 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['=', 'idp_siriLatihan.kampusID', '1',])
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();

                $elektifSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 4 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['=', 'idp_siriLatihan.kampusID', '1',])
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();

                $umumSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 1 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['=', 'idp_siriLatihan.kampusID', '1',])
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();

                $impakTinggiSasaran = KursusLatihan::find()
                    ->joinWith('sasarann.sasaran8')
                    ->where("kategoriKursusID = 7 and gredJawatanID = $gredJawatan and tahap = $tahap and tahun = $currentYear")
                    ->andWhere(['=', 'idp_siriLatihan.kampusID', '1',])
                    ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                    ->all();
            }

            return $this->render('view_kursus_sasaran_akademik', [
                'model' => $model,
                'terasSasaran' => $terasSasaran,
                'umumSasaran' => $umumSasaran,
                'elektifSasaran' => $elektifSasaran,
                'impakTinggiSasaran' => $impakTinggiSasaran,
                'kursusJemputan' => $kursusJemputan,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionJemputLatihan($id, $gredJawatanID, $tahap, $kursusID, $kategori)
    {
        //get current year
        $currentYear = date('Y');

        /** old * */
        //        $mohonList = PermohonanLatihan::find()
        //                        //->rightJoin('hronline.tblprcobiodata', 'hronline.tblprcobiodata.ICNO = myidp.permohonanlatihan.staffID')
        //                        ->where(['siriLatihanID' => $id])
        //                        ->joinWith('idp')
        //                        ->andWhere(['gredjawatan' => $gredJawatanID])
        //                        ->andWhere(['tahap' => $tahap])
        //                        ->andWhere(['tahun' => $currentYear])
        //                        ->all();

        /** new * */
        $mohonList = PermohonanLatihan::find()
            //->rightJoin('hronline.tblprcobiodata', 'hronline.tblprcobiodata.ICNO = myidp.permohonanlatihan.staffID')
            ->where(['kursusLatihanID' => $kursusID])
            ->joinWith('biodata')
            ->andWhere(['gredJawatan' => $gredJawatanID])
            ->all();

        //        if ($mohonList){
        //            Yii::$app->session->setFlash('alert', ['title' => 'X', 'type' => 'warning', 'msg' => 'Anda telah memohon kursus ini!']);
        //            return $this->redirect(['view-kursus-sasaran']);
        //        }

        $mohonn = [];
        foreach ($mohonList as $mohonLists) {
            if ($layaks->tahapKhidmat == $tahap) {
                array_push($mohonn, $mohonLists->staffID);
            }
        }

        /** old * */
        //        $layak = Idp::find()
        //                ->where(['gredjawatan'=>$gredJawatanID])
        //                ->andWhere(['tahap' => $tahap])
        //                ->andWhere(['tahun' => $currentYear])
        //                ->all();

        $layak = Tblprcobiodata::find()
            ->where(['gredJawatan' => $gredJawatanID])
            ->andWhere(['<>', 'Status', '6',])
            ->all();

        /** old * */
        //        $layakk = [];
        //        foreach($layak as $layaks){
        //            array_push($layakk, $layaks->v_co_icno);
        //        }

        /** new * */
        $layakk = [];
        foreach ($layak as $layaks) {
            if ($layaks->tahapKhidmat == $tahap) {
                array_push($layakk, $layaks->ICNO);
            }
        }

        $belummohon = array_diff($layakk, $mohonn);

        $model = new PermohonanLatihan();
        foreach ($belummohon as $belummohonn) {

            //$userID = Yii::$app->user->getId();
            //get current date
            $currentDate = date('Y-m-d');

            $model = new PermohonanLatihan();
            $model->staffID = $belummohonn;
            $model->kursusLatihanID = $kursusID;
            $model->siriLatihanID = $id;
            $model->statusPermohonan = 'JEMPUTAN';
            $model->tarikhPermohonan = $currentDate;
            $model->caraPermohonan = 'jemputan';
            $model->kategoriKursusID = $kategori;
            $model->save(false);
        }

        //        if ($model->save()) {
        //            Yii::$app->session->setFlash('alert', ['title' => ':)', 'type' => 'success', 'msg' => 'Berjaya jemputan!']);
        return $this->redirect(['view-senarai-jawatan', 'id' => $id]);
        //        } else {
        //            Yii::$app->session->setFlash('alert', ['title' => 'X', 'type' => 'danger', 'msg' => 'Tidak berjaya jemputan!']);
        //        }
    }

    public function actionUbahStatusKehadiran($permohonanID, $peserta)
    {

        $model = Peserta::find()
            ->where(['permohonanID' => $permohonanID])
            ->andWhere(['staffID' => $peserta])
            ->one();

        if ($model->load(Yii::$app->request->post())) {

            $model->save(false);
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('ubah_status_kehadiran', [
            'model' => $model,
        ]);
    }

    public function actionUbahJenisKursusss($permohonanID, $peserta, $status)
    {

        $model = Peserta::find()
            ->where(['permohonanID' => $permohonanID])
            ->andWhere(['staffID' => $peserta])
            ->one();

        if ($model->load(Yii::$app->request->post())) {

            $model2 = Peserta::find()
                ->where(['permohonanID' => $permohonanID])
                ->andWhere(['staffID' => $peserta])
                ->one();

            $model2->status = $status;
            $model2->kompetensiLulus = $model->kategoriKursusID;

            $model2->save(false);
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('ubah_jenis_kursus', [
            'model' => $model,
        ]);
    }

    public function actionUbahJenisKursuss($permohonanID, $peserta, $status)
    {

        $model = Peserta::find()
            ->where(['permohonanID' => $permohonanID])
            ->andWhere(['staffID' => $peserta])
            ->one();

        if ($model->load(Yii::$app->request->post())) {

            $model->status = $status;

            $model->save(false);
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('ubah_jenis_kursus', [
            'model' => $model,
        ]);
    }

    public function actionUbahJenisKursus($slotID, $peserta)
    {
        $model = Kehadiran::find()
            ->where(['slotID' => $slotID])
            ->andWhere(['staffID' => $peserta])
            ->one();

        $checkMata = IdpMata::find()
            ->where(['staffID' => $peserta])
            ->andWhere(['tahun' => date('Y')])
            ->one();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->kategoriKursusID == 1) {

                if ($checkMata) {
                    $checkMata->mataUmum = $checkMata->mataUmum + 1;
                    $checkMata->save(false);
                } else {
                    $newMata = new IdpMata();
                    $newMata->staffID = $selection;
                    $newMata->tahun = date('Y');
                    $newMata->mataUmum = 1;
                    $newMata->save(false);
                }
            } elseif ($model->kategoriKursusID == 3) {
                if ($checkMata) {
                    $checkMata->mataTeras = $checkMata->mataTeras + 3;
                    $checkMata->save(false);
                } else {
                    $newMata = new IdpMata();
                    $newMata->staffID = $selection;
                    $newMata->tahun = date('Y');
                    $newMata->mataTeras = 3;
                    $newMata->save(false);
                }
            } elseif ($model->kategoriKursusID == 4) {
                if ($checkMata) {
                    $checkMata->mataElektif = $checkMata->mataElektif + 3;
                    $checkMata->save(false);
                } else {
                    $newMata = new IdpMata();
                    $newMata->staffID = $selection;
                    $newMata->tahun = date('Y');
                    $newMata->mataElektif = 3;
                    $newMata->save(false);
                }
            } elseif ($model->kategoriKursusID == 5) {
                if ($checkMata) {
                    $checkMata->mataTerasUni = $checkMata->mataTerasUni + 3;
                    $checkMata->save(false);
                } else {
                    $newMata = new IdpMata();
                    $newMata->staffID = $selection;
                    $newMata->tahun = date('Y');
                    $newMata->mataTerasUni = 3;
                    $newMata->save(false);
                }
            } elseif ($model->kategoriKursusID == 6) {
                if ($checkMata) {
                    $checkMata->mataTerasSkim = $checkMata->mataTerasSkim + 3;
                    $checkMata->save(false);
                } else {
                    $newMata = new IdpMata();
                    $newMata->staffID = $selection;
                    $newMata->tahun = date('Y');
                    $newMata->mataTerasSkim = 3;
                    $newMata->save(false);
                }
            }

            $model->save(false);
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('ubah_jenis_kursus', [
            'model' => $model,
        ]);
    }

    public function actionUbahKompetensiProfil($siriID, $peserta)
    {

        $model3 = Tblprcobiodata::findOne(['ICNO' => $peserta]);

        //Yii::$app->request->post('momok');
        if (Yii::$app->request->post()) {

            if (Yii::$app->request->post('komp') != NULL) {

                $model = Kehadiran::find()
                    ->joinWith('sasaran9')
                    ->where(['siriLatihanID' => $siriID])
                    ->andWhere(['staffID' => $peserta])
                    ->all();

                //                foreach($array as $key => $element) {
                //                    reset($array);
                //                    if ($key === key($array))
                //                        echo 'FIRST ELEMENT!';
                //
                //                    end($array);
                //                    if ($key === key($array))
                //                        echo 'LAST ELEMENT!';
                //                }

                foreach ($model as $modelK => $element) {
                    reset($model);
                    $element->kategoriKursusID = Yii::$app->request->post('komp');

                    if ($element->save()) {

                        if ($element->kategoriKursusID != 1 && $element->sasaran9->sasaran4->sasaran3->jenisLatihanID != 'jfpiu') {

                            $checkBorang2 = BorangPenilaianLatihan::find()
                                ->where(['pesertaID' => $peserta])
                                ->andWhere(['siriLatihanID' => $siriID])
                                ->one();

                            $checkBorangK2 = BorangPenilaianKeberkesanan::find()
                                ->where(['pesertaID' => $peserta])
                                ->andWhere(['siriLatihanID' => $siriID])
                                ->one();

                            if (!$checkBorang2) {
                                $borangpl2 = new BorangPenilaianLatihan();
                                $borangpl2->pesertaID = $peserta;
                                $borangpl2->siriLatihanID = $siriID;
                                $borangpl2->statusBorang = '1';
                                $borangpl2->save(false);
                            }

                            if (!$checkBorangK2) {
                                $borangpk2 = new BorangPenilaianKeberkesanan();
                                $borangpk2->pesertaID = $peserta;
                                $borangpk2->siriLatihanID = $siriID;
                                $borangpk2->statusBorang = '1';
                                $borangpk2->save(false);
                            }
                        }
                    }

                    if (($modelK === key($model)) && $element->save())
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                }
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('ubah_kompetensi_profil', [
            'model3' => $model3,
        ]);
    }

    public function actionIdpJfpiuuu()
    {
        $userID = Yii::$app->user->getId();

        $test = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();

        $currentYear = date('Y');

        //        $staffCurrentIDP = IdpMata::find()
        //                ->joinWith('biodata.department')
        //                ->joinWith('biodata.jawatan')
        //                ->where(['DeptId' => $test->DeptId])
        //                ->andWhere(['tahun' => $currentYear])
        //                ->andWhere(['job_category' => 2])
        //                ->andWhere(['<>', 'Status', '6'])
        //                ->orderBy('CONm');

        //        $staffCurrentIDP2 = IdpMata::find()
        //                ->joinWith('biodata.department')
        //                ->joinWith('biodata.jawatan')
        //                ->where(['DeptId' => $test->DeptId])
        //                ->andWhere(['tahun' => $currentYear])
        //                ->andWhere(['job_category' => 1])
        //                ->andWhere(['<>', 'Status', '6'])
        //                ->orderBy('CONm');

        /** error cross-server **/
        $a = Tblprcobiodata::find()
            ->where(['DeptId' => $test->DeptId])
            ->andWhere(['<>', 'Status', '6'])
            ->all();

        $b = IdpMata::find()
            ->where(['tahun' => $currentYear])
            ->all();

        $c = [];
        $d = [];
        foreach ($b as $bbb) {
            foreach ($a as $aaa) {
                if ($bbb->staffID == $aaa->ICNO) {
                    if ($aaa->jawatan->job_category == 2) {
                        array_push($c, $bbb->staffID);
                    } elseif ($aaa->jawatan->job_category == 1) {
                        array_push($d, $bbb->staffID);
                    }
                }
            }
        }

        $bb = IdpMata::find()
            ->joinWith('biodata')
            ->where(['tahun' => $currentYear])
            ->andWhere(['staffID' => $c])
            ->orderBy('CONm');

        $bbbb = IdpMata::find()
            ->joinWith('biodata')
            ->where(['tahun' => $currentYear])
            ->andWhere(['staffID' => $d])
            ->orderBy('CONm');

        //        $dataProvider = new ActiveDataProvider([
        //            'query' => $staffCurrentIDP,
        //            'pagination' => false,
        //        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $bb,
            'pagination' => false,
            //            'sort'=> ['defaultOrder' => ['staffID' => SORT_ASC]],
        ]);

        //        $dataProvider2 = new ActiveDataProvider([
        //            'query' => $staffCurrentIDP2,
        //            'pagination' => false,
        //        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $bbbb,
            'pagination' => false,
        ]);

        /************************************/

        return $this->render('idp_jfpiu', [
            //'model' => $staf2,
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2
        ]);
    }

    public function actionIdpJfpiuu($tahun = null)
    {

        if (!$tahun) {
            $currentYear = date('Y');
        } else {
            $currentYear = $tahun;
        }

        $userID = Yii::$app->user->getId();

        $staf = Tblprcobiodata::find()
            ->where(['<>', 'Status', '6'])
            ->all();

        $test = SetPegawai::find()->where(['peraku_icno' => $userID])->all();

        $senaraiPemohon = [];
        foreach ($staf as $staff) {
            foreach ($test as $test2) {
                if ($test2->pemohon_icno == $staff->ICNO) {
                    array_push($senaraiPemohon, $staff->ICNO);
                }
            }
        }

        $staffCurrentIDP = IdpMata::find()
            ->joinWith('biodata.jawatan')
            ->where(['staffID' => $senaraiPemohon])
            ->andWhere(['job_category' => 2])
            ->andWhere(['tahun' => $currentYear])
            ->orderBy('CONm');

        $dataProvider = new ActiveDataProvider([
            'query' => $staffCurrentIDP,
        ]);

        $staffCurrentIDP2 = IdpMata::find()
            ->joinWith('biodata.jawatan')
            ->where(['staffID' => $senaraiPemohon])
            ->andWhere(['job_category' => 1])
            ->andWhere(['tahun' => $currentYear])
            ->orderBy('CONm');

        $dataProvider2 = new ActiveDataProvider([
            'query' => $staffCurrentIDP2,
        ]);

        //        return $this->render('idp_jfpiu', [
        //                    //'model' => $staf2,
        //                    'dataProvider' => $dataProvider,
        //                    'dataProvider2' => $dataProvider2
        //        ]);

        return $this->render('laporan_idp_jabatan_peg', [
            'tahun' => $tahun,
            'bil' => 1,
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionIdpJfpiu()
    {
        $userID = Yii::$app->user->getId();
        $currentYear = date('Y');

        $staffCurrentIDP = IdpMata::find()
            ->joinWith('biodata.department')
            ->joinWith('biodata.jawatan')
            ->where(['chief' => $userID])
            ->orWhere(['department.pp' => $userID])
            ->andWhere(['tahun' => $currentYear])
            ->andWhere(['job_category' => 2])
            ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
            ->orderBy('CONm');

        $staffCurrentIDP2 = IdpMata::find()
            ->joinWith('biodata.department')
            ->joinWith('biodata.jawatan')
            ->where(['chief' => $userID])
            ->orWhere(['department.pp' => $userID])
            ->andWhere(['tahun' => $currentYear])
            ->andWhere(['job_category' => 1])
            ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
            ->orderBy('CONm');

        $dataProvider = new ActiveDataProvider([
            'query' => $staffCurrentIDP,
            'pagination' => false,
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $staffCurrentIDP2,
            'pagination' => false,
        ]);

        return $this->render('idp_jfpiu', [
            'model' => $staffCurrentIDP,
            'dataProvider' => $dataProvider,
            'model2' => $staffCurrentIDP2,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionMohonLatihan($id, $kategori)
    {
        $userID = Yii::$app->user->getId();

        $model3 = Tblprcobiodata::findOne(['ICNO' => $userID]);
        $gredj = $model3->gredJawatan;
        $tahap = $model3->tahapKhidmat;
        $jabatan = $model3->DeptId;

        /** find user current campus * */
        $campusUser = $model3->kampus->campus_id;

        /** different requirement between non-KK campus resident and KK campus resident * */
        if ($campusUser != 1) {

            $query = SiriLatihan::find()
                ->joinWith('sasaran8')
                ->joinWith('sasaran3')
                ->where(['gredJawatanID' => $gredj])
                ->andWhere(['tahap' => $tahap])
                ->andWhere(['kategoriKursusID' => $kategori])
                ->andWhere(['tahun' => date('Y')])
                ->andWhere(['idp_kursusLatihan.kursusLatihanID' => $id])
                ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE']);

            //        $query = KursusSasaran::find()
            //                ->where("kategoriKursusID = $kategori and gredJawatanID = $gredj and tahap = $tahap");
        } else {

            $query = SiriLatihan::find()
                ->joinWith('sasaran8')
                ->joinWith('sasaran3')
                ->where(['gredJawatanID' => $gredj])
                ->andWhere(['tahap' => $tahap])
                ->andWhere(['kategoriKursusID' => $kategori])
                ->andWhere(['tahun' => date('Y')])
                ->andWhere(['idp_kursusLatihan.kursusLatihanID' => $id])
                ->andWhere(['=', 'idp_siriLatihan.kampusID', '1'])
                ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        return $this->renderAjax('mohon_latihan', [
            'modelLatihan' => $this->findModelLatihan($id),
            'dataProvider' => $dataProvider,
            'kategori' => $kategori,
        ]);
    }

    public function actionLatihanDipohon($id)
    {
        $userID = Yii::$app->user->getId();

        $query = PermohonanLatihan::find()
            ->joinWith('sasaran6')
            ->where(['idp_permohonanlatihan.staffID' => $userID])
            ->andWhere(['idp_sirilatihan.kursusLatihanID' => $id]);

        //        $query = KursusSasaran::find()
        //                ->where("kategoriKursusID = $kategori and gredJawatanID = $gredj and tahap = $tahap");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->renderAjax('latihan_dipohon', [
            'modelLatihan' => $this->findModelLatihan($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLatihanDihadiri($id)
    {
        $userID = Yii::$app->user->getId();

        $query = Kehadiran::find()
            ->joinWith('sasaran9.sasaran4.sasaran3')
            ->where(['staffID' => $userID])
            ->andWhere(['idp_kursusLatihan.kursusLatihanID' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->renderAjax('latihan_dihadiri', [
            'modelLatihan' => $this->findModelLatihan($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMohonSiriLatihan($id, $siriID, $kategor)
    {
        $userID = Yii::$app->user->getId();

        //get current year
        $currentDate = date('Y-m-d H:i:s');
        $currentYear = date('Y');

        /*         * ************* create ********************************** */
        //        $model = new DMohonKursus();
        //        $model->iid = $id;
        //        $model->d_mk_pemohon_icno = $userID;
        //        $model->d_mk_pemohon_tarikh_sah = $currentDate;
        //
        //        if ($model->save()){
        //            return $this->redirect(['view-senarai-permohonan']);
        //        }

        $mohonList = PermohonanLatihan::find()
            //->rightJoin('hronline.tblprcobiodata', 'hronline.tblprcobiodata.ICNO = myidp.permohonanlatihan.staffID')
            ->where(['kursusLatihanID' => $id, 'staffID' => $userID, 'tahun' => $currentYear])
            ->one();

        if ($mohonList) {
            Yii::$app->session->setFlash('alert', ['title' => 'X', 'type' => 'warning', 'msg' => 'Anda telah memohon kursus ini!']);
            return $this->redirect(['view-kursus-sasaran']);
        }

        /*         * ************** BARU ********************************** */
        $model = new PermohonanLatihan();
        $model->staffID = $userID;
        $model->kursusLatihanID = $id;
        $model->siriLatihanID = $siriID;
        //$model->statusPermohonan = 'BARU';
        $model->tarikhPermohonan = $currentDate;
        $model->caraPermohonan = 'sendiriMohon';
        $model->kategoriKursusID = $kategor;
        $model->tahun = $currentYear;

        /** for MCO only until 28 April **/
        $model->statusPermohonan = "DILULUSKAN";
        $model->tarikhKelulusan = date('Y-m-d');
        $model->tarikhSistemLulus = date('Y-m-d');
        $model->sistemLulus = 1;
        /****/

        if ($model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan kursus anda telah diluluskan BSM']);

            /** for MCO only until 28 April **/

            //            $model4 = SetPegawai::findOne(['pemohon_icno' => $model->staffID]);
            //            if ($model4->peraku_icno != '') {
            //                $this->notifikasi($model4->peraku_icno, "Permohonan kursus staff menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/peraku'], ['class' => 'btn btn-danger btn-sm']));
            //                $this->notifikasi($model->staffID, "Permohonan kursus anda telah dihantar untuk tindakan Pegawai Peraku. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));
            //            } else {
            //                $this->notifikasi($model4->pelulus_icno, "Permohonan kursus staff menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/pelulus'], ['class' => 'btn btn-danger btn-sm']));
            //                $this->notifikasi($model->staffID, "Permohonan kursus anda telah dihantar untuk tindakan Pegawai Pelulus. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));
            //            }
            /****/

            //            $model3 = Tblprcobiodata::findOne(['ICNO' => $model->staffID]);

            //            $emailMohonSiri = new TblSysEmailQueue();
            //            $emailMohonSiri->from_name = '[HR-Online] - MyIDP';
            //            $emailMohonSiri->from_email = 'hronline-noreply@ums.edu.my';
            //            $emailMohonSiri->to_name = $model3->CONm;
            //            $emailMohonSiri->to_email = 'aisyah.zainal@ums.edu.my';
            //            $emailMohonSiri->subject = 'PERMOHONAN KURSUS LATIHAN OLEH ' . $model3->CONm;
            //            $emailMohonSiri->message = 'TEST';
            //
            //            $emailMohonSiri->save(false);

            //$this->notifikasi($model4->peraku_icno, "Permohonan.".Html::a('<i class="fa fa-arrow-right"> MAKLUMAT LANJUT</i>', ['idp/peraku'], ['class'=>'btn btn-danger btn-sm']));
            //$this->notifikasi($model4->peraku_icno, "Permohonan kursus staff menunggu tindakan anda. ".Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/peraku'], ['class'=>'btn btn-danger btn-sm']));
            //$this->notifikasi($model->staffID, "Permohonan kursus anda telah dihantar untuk tindakan Pegawai Peraku. ".Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class'=>'btn btn-success btn-sm']));
            return $this->redirect(['view-senarai-permohonan']);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'X', 'type' => 'success', 'msg' => 'Permohonan kursus anda telah diluluskan BSM']);
        }
    }

    public function actionJanaSuratKursusLuar($id)
    {

        $userID = Yii::$app->user->getId();
        $modelUser = UserAccess::find()->where(['userID' => $userID])->one();

        //get current year
        $currentDate = date('Y-m-d H:i:s');

        $modelSurat = SuratKursusLuar::find()->where(['permohonanID' => $id])->one();

        if (!$modelSurat) {

            $modelSurat = new SuratKursusLuar();
            $modelSurat->permohonanID = $id;

            if ($modelUser->usertype == 'pegawaiLatihan') {
                $modelSurat->status_pl = 1;
                $modelSurat->date_pl = $currentDate;
                $modelSurat->user_pl = $userID;
            } else {
                $modelSurat->status_ul = 1;
                $modelSurat->date_ul = $currentDate;
                $modelSurat->user_ul = $userID;
            }
        } else {

            if ($modelUser->usertype == 'pegawaiLatihan') {
                $modelSurat->status_pl = 1;
                $modelSurat->date_pl = $currentDate;
                $modelSurat->user_pl = $userID;
            } else {
                $modelSurat->date_ul = $currentDate;
                $modelSurat->user_ul = $userID;
            }
        }

        if ($modelSurat->save(false)) {
            if ($modelUser->usertype == 'pegawaiLatihan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Surat Kursus Luar Telah Dijana Kepada Pemohon']);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Surat Kursus Luar Telah Disemak']);
            }

            //return $this->redirect(['semakan-surat-kursus-luar']);
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionBatalPermohonanByPemohon($id)
    {
        $userID = Yii::$app->user->getId();

        $mohonList = PermohonanMataIdpIndividu::find()
            ->where(['permohonanID' => $id])
            ->one();

        $mohonList->tarikhBatalPermohonan = date('Y-m-d');
        $mohonList->dibatalkanOleh = $userID;
        $mohonList->statusPermohonan = 11;

        if ($mohonList->save(false)) {
            Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya batalkan permohonan!']);
            //return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->redirect(['view-senarai-permohonan-individu']);
    }

    public function actionBatalPermohonan($id, $idB)
    {
        $userID = Yii::$app->user->getId();

        $mohonList = PermohonanMataIdpIndividu::find()
            ->where(['permohonanID' => $id])
            ->one();

        if ($mohonList->load(Yii::$app->request->post())) {

            $mohonList->tarikhBatalPermohonan = date('Y-m-d');
            $mohonList->dibatalkanOleh = $userID;
            $mohonList->statusPermohonan = 11;

            if ($mohonList->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya batalkan permohonan!']);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->renderAjax('batal_permohonan', [
            'model' => $mohonList,
            'idB' => $idB,
        ]);
    }

    public function actionUbahMataSlot($slotID)
    {
        $userID = Yii::$app->user->getId();

        $model = SlotLatihan::find()
            ->where(['slotID' => $slotID])
            ->one();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya ubah mata slot dikehendaki.']);
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            }
        }

        return $this->renderAjax('ubah_mata_slot', [
            'model' => $model
        ]);
    }

    public function actionSemaksurat($id, $idB)
    {

        $userID = Yii::$app->user->getId();
        $modelUser = UserAccess::find()->where(['userID' => $userID])->one();

        $modelSurat = SuratKursusLuar::find()->where(['permohonanID' => $id])->one();

        if (!$modelSurat) {

            $modelSurat = new SuratKursusLuar();
            $modelSurat->permohonanID = $id;
        }

        if ($modelSurat->load(Yii::$app->request->post())) {

            $currentDate = date('Y-m-d H:i:s');
            if ($modelUser->usertype == 'pegawaiLatihan') {
                $modelSurat->date_pl = $currentDate;
                $modelSurat->user_pl = $userID;
            } else {
                $modelSurat->date_ul = $currentDate;
                $modelSurat->user_ul = $userID;
            }

            if ($modelSurat->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Surat telah disemak.']);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->renderAjax('semaksurat', [
            'model' => $modelSurat,
            'idB' => $idB,
        ]);
    }

    public function actionSahhadir($id, $idB)
    {
        $userID = Yii::$app->user->getId();

        $mohonList = PermohonanLatihan::find()
            ->where(['kursusLatihanID' => $id])
            ->andWhere(['staffID' => $userID])
            ->one();

        //echo '<pre>', var_dump($idB), '</pre>';
        //die();

        if ($mohonList->load(Yii::$app->request->post())) {

            //get current year
            $currentDate = date('Y-m-d H:i:s');
            $mohonList->tarikhSahHadir = $currentDate;
            //$mohonList->sahHadirbyStaf = $idB;

            if ($mohonList->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Terima kasih, anda telah mengesahkan kehadiran/ketidakhadiran kursus yang telah dimohon.']);
                return $this->redirect(['view-senarai-permohonan']);
            }
        }

        return $this->renderAjax('sahhadir', [
            'model' => $mohonList,
            'idB' => $idB,
        ]);
    }

    public function actionUbahx()
    {

        $modelKompetensi = Kategori::find();


        return $this->renderAjax('ubahx', [
            'model' => $modelKompetensi,
        ]);
    }

    public function actionTakwim($tahun = null)
    {
        /** takwim */
        $bulan = 0;

        if (Yii::$app->request->post('momo') != NULL) {

            $bulan = Yii::$app->request->post('momo');

            return $this->render('takwim', [
                'bulan' => $bulan,
            ]);
        }

        $year = date('Y');
        if (!$tahun) {
            $tahun = $year;
        }
        /** */

        /** code for export function */
        $searchModel = new SiriLatihanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere([
            'idp_kursusLatihan.jenisLatihanID' => 'latihanDalaman',
            'YEAR(tarikhMula)' => $tahun
        ]);
        $dataProvider->query->andFilterWhere(['<>', 'statusSiriLatihan', 'INACTIVE']);
        /**  */

        return $this->render('takwim', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'searchModel' => $searchModel, //export function
            'dataProvider' => $dataProvider, //export function
        ]);
    }

    public function actionIndexLaporanSasaran($tahun = null)
    {
        $bulan = 0;

        //        if (Yii::$app->request->post('momo') != NULL) {
        //
        //            $bulan = Yii::$app->request->post('momo');
        //
        //            return $this->render('takwim', [
        //                        'bulan' => $bulan,
        //            ]);
        //        }

        $year = date('Y');
        if (!$tahun) {
            $tahun = $year;
        }

        $searchModel = new SiriLatihanLive();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere([
            'idp_kursusLatihan.jenisLatihanID' => 'latihanDalaman',
            'YEAR(tarikhMula)' => $tahun
        ]);

        //return $this->render('rpt_stat_kursus_hadir', [
        //return $this->render('analisis_senarai_latihan_live', [
        return $this->render('laporan_kursus_tahunan_sasaran', [
            'bulan' => $bulan,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tahun' => $tahun,
        ]);
    }

    public function actionIndexLaporan2($tahun = null)
    {
        $bulan = 0;

        //        if (Yii::$app->request->post('momo') != NULL) {
        //
        //            $bulan = Yii::$app->request->post('momo');
        //
        //            return $this->render('takwim', [
        //                        'bulan' => $bulan,
        //            ]);
        //        }

        $year = date('Y');
        if (!$tahun) {
            $tahun = $year;
        }

        $searchModel = new SiriLatihanLive();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere([
            'idp_kursusLatihan.jenisLatihanID' => 'latihanDalaman',
            'YEAR(tarikhMula)' => $tahun
        ]);

        //return $this->render('rpt_stat_kursus_hadir', [
        //return $this->render('analisis_senarai_latihan_live', [
        return $this->render('laporan_kursus_tahunan', [
            'bulan' => $bulan,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tahun' => $tahun,
        ]);
    }

    public function actionPurataPenilaianLama()
    {
        $bulan = 0;

        /** 2019 and below */
        $searchModel = new VCpdSenaraiLatihanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['vcsl_kod_anjuran' => '12', 'status_latihan' => '2']);

        // $count = VCpdSenaraiLatihan::find()
        //         ->where(['MONTH(vcsl_tkh_mula)' => $kumpulan, 'YEAR(vcsl_tkh_mula)' => $year, 'vcsl_kod_anjuran' => '12', 'status_latihan' => '2'])
        //         ->count();

        return $this->render('purata_penilaian_kursus_lama', [
            'bulan' => $bulan,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPurataPenilaian()
    {
        $bulan = 0;

        /** 2020 and above */
        $searchModel = new SiriLatihanLive();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['idp_kursusLatihan.jenisLatihanID' => 'latihanDalaman']);

        //return $this->render('rpt_stat_kursus_hadir', [
        return $this->render('purata_penilaian_kursus', [
            'bulan' => $bulan,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPurataKeberkesanan()
    {
        $bulan = 0;

        $searchModel = new SiriLatihanLive();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['idp_kursusLatihan.jenisLatihanID' => 'latihanDalaman']);

        return $this->render('purata_keberkesanan_kursus', [
            'bulan' => $bulan,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAnalisisPenilaian()
    {
        $bulan = 0;

        $searchModel = new SiriLatihanLive();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['idp_kursusLatihan.jenisLatihanID' => 'latihanDalaman']);

        //return $this->render('rpt_stat_kursus_hadir', [
        return $this->render('analisis_penilaian_latihan', [
            'bulan' => $bulan,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraiKursusJfpiu()
    {

        $query = SlotLatihanJfpiu::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('view_senarai_kursus_jfpiu', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewSenaraiLatihanJfpiu()
    {
        $searchModel = new KursusLatihanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['unitBertanggungjawab' => 'JFPIU']);

        return $this->render('view_senarai_latihan_2', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewSenaraiLatihan()
    {
        $searchModel = new KursusLatihanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['<>', 'unitBertanggungjawab', 'JFPIU']);

        return $this->render('view_senarai_latihan_2', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewSenaraiLatihanLama()
    {
        $searchModel = new VCpdSenaraiLatihanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view_senarai_latihan_3', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionKeberkesananKursus()
    {

        $searchModel = new KehadiranKeberkesanan();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('view_senarai_kursus_keberkesanan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'getJabatan' => Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->one(),
            'deptChief' => Department::find()
                ->where(['chief' => Yii::$app->user->getId(), 'isActive' => '1'])
                ->orWhere(['pp' => Yii::$app->user->getId(), 'id' => '164', 'isActive' => '1'])
                ->all(),
        ]);
    }

    public function actionLaporanKehadiranJabatan($tahun = null)
    {
        $currentYear = date('Y');

        if (!$tahun) {
            $tahun = $currentYear;
        }

        $searchModel = new KehadiranByJabatan();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere([
            'YEAR(tarikhMula)' => $tahun
        ]);

        return $this->render('view_senarai_kursus_dihadiri_jabatan', [
            'tahun' => $tahun,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'getJabatan' => Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->one(),
        ]);
    }

    public function actionLaporanKehadiranKeberkesanan($id, $dept = null)
    {

        if ($dept != null) {
            $dept2 = $dept;

            $hadir = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9')
                ->where(['siriLatihanID' => $id, 'DeptId' => $dept2])
                ->select('staffID');

            $dataProvider = new ActiveDataProvider([
                'query' => PermohonanLatihan::find()
                    ->joinWith('biodata')
                    ->where(['DeptId' => $dept2])
                    ->andWhere(['NOT IN', 'staffID', $hadir])
                    ->andWhere(['siriLatihanID' => $id])->orderBy(['tarikhSahHadir' => SORT_DESC]),
                'pagination' => ['pageSize' => 25,],
            ]);

            $hadir2 = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9')
                ->where(['siriLatihanID' => $id, 'DeptId' => $dept2])
                ->orderBy(['CONm' => SORT_ASC]);

            $dataProvider2 = new ActiveDataProvider([
                'query' => $hadir2,
                'pagination' => ['pageSize' => 25,],
            ]);
        } else {

            $hadir = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9')
                ->where(['siriLatihanID' => $id])
                ->select('staffID');

            $dataProvider = new ActiveDataProvider([
                'query' => PermohonanLatihan::find()->where(['NOT IN', 'staffID', $hadir])
                    ->andWhere(['siriLatihanID' => $id])->orderBy(['tarikhSahHadir' => SORT_DESC]),
                'pagination' => ['pageSize' => 25,],
            ]);

            $hadir2 = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9')
                ->where(['siriLatihanID' => $id])
                ->orderBy(['CONm' => SORT_ASC]);

            $dataProvider2 = new ActiveDataProvider([
                'query' => $hadir2,
                'pagination' => ['pageSize' => 25,],
            ]);
        }

        return $this->render('laporan_kehadiran_keberkesanan', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'model' => $this->findModelSiriLatihan($id),
        ]);
    }

    public function actionLaporanKehadiranSiriJfpiu($id, $dept = null)
    {

        if ($dept != null) {
            $dept2 = $dept;

            $hadir = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9')
                ->where(['siriLatihanID' => $id, 'DeptId' => $dept2])
                ->select('staffID');

            $dataProvider = new ActiveDataProvider([
                'query' => PermohonanLatihan::find()
                    ->joinWith('biodata')
                    ->where(['DeptId' => $dept2])
                    ->andWhere(['NOT IN', 'staffID', $hadir])
                    ->andWhere(['siriLatihanID' => $id])->orderBy(['tarikhSahHadir' => SORT_DESC]),
                'pagination' => ['pageSize' => 25,],
            ]);

            $hadir2 = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9')
                ->where(['siriLatihanID' => $id, 'DeptId' => $dept2])
                ->orderBy(['statusPeserta' => SORT_ASC]);

            $dataProvider2 = new ActiveDataProvider([
                'query' => $hadir2,
                'pagination' => ['pageSize' => 25,],
            ]);
        } else {

            $hadir = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9')
                ->where(['siriLatihanID' => $id])
                ->select('staffID');

            $dataProvider = new ActiveDataProvider([
                'query' => PermohonanLatihan::find()->where(['NOT IN', 'staffID', $hadir])
                    ->andWhere(['siriLatihanID' => $id])->orderBy(['tarikhSahHadir' => SORT_DESC]),
                'pagination' => ['pageSize' => 25,],
            ]);

            $hadir2 = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9')
                ->where(['siriLatihanID' => $id])
                ->orderBy(['statusPeserta' => SORT_ASC]);

            $dataProvider2 = new ActiveDataProvider([
                'query' => $hadir2,
                'pagination' => ['pageSize' => 25,],
            ]);
        }

        return $this->render('laporan_kehadiran_siri_jfpiu', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'model' => $this->findModelSiriLatihan($id),
        ]);
    }

    public function actionLaporanKehadiranSiri($id, $dept = null)
    {

        if ($dept != null) {
            $dept2 = $dept;

            $hadir = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9')
                ->where(['siriLatihanID' => $id, 'DeptId' => $dept2])
                ->select('staffID');

            $dataProvider = new ActiveDataProvider([
                'query' => PermohonanLatihan::find()
                    ->joinWith('biodata')
                    ->where(['DeptId' => $dept2])
                    ->andWhere(['NOT IN', 'staffID', $hadir])
                    ->andWhere(['siriLatihanID' => $id])->orderBy(['tarikhSahHadir' => SORT_DESC]),
                'pagination' => ['pageSize' => 25,],
            ]);

            $hadir2 = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9')
                ->where(['siriLatihanID' => $id, 'DeptId' => $dept2])
                ->orderBy(['statusPeserta' => SORT_ASC]);

            $dataProvider2 = new ActiveDataProvider([
                'query' => $hadir2,
                'pagination' => ['pageSize' => 25,],
            ]);
        } else {

            $hadir = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9')
                ->where(['siriLatihanID' => $id])
                ->select('staffID');

            $dataProvider = new ActiveDataProvider([
                'query' => PermohonanLatihan::find()->where(['NOT IN', 'staffID', $hadir])
                    ->andWhere(['siriLatihanID' => $id])->orderBy(['tarikhSahHadir' => SORT_DESC]),
                'pagination' => ['pageSize' => 25,],
            ]);

            $hadir2 = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9')
                ->where(['siriLatihanID' => $id])
                ->orderBy(['statusPeserta' => SORT_ASC]);

            $dataProvider2 = new ActiveDataProvider([
                'query' => $hadir2,
                'pagination' => ['pageSize' => 25,],
            ]);
        }

        return $this->render('laporan_kehadiran_siri', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'model' => $this->findModelSiriLatihan($id),
        ]);
    }

    public function actionViewSenaraiPenceramah($id)
    {

        $query = Ceramah::find()
            ->where(['siriLatihanID' => $id, 'jenis' => '1']);

        $query2 = Ceramah::find()
            ->where(['siriLatihanID' => $id, 'jenis' => '2']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $query2,
        ]);

        //        if (isset($_POST['expandRowKey'])) {
        //            $model = Ceramah::findOne($_POST['expandRowKey']);
        //            return $this->renderPartial('view_penceramah', ['model'=>$model, 'id' => '1']);
        //        } else {
        //            return '<div class="alert alert-danger">No data found</div>';
        //        }


        $aksesbaru = new Ceramah(); //untuk admin baru
        if (Yii::$app->request->post('submit') == 0) {


            if ($aksesbaru->load(Yii::$app->request->post())) {
                if (Ceramah::find()->where([
                    'penceramahID' => $aksesbaru->penceramahID,
                    'siriLatihanID' => $id
                ])->exists()) { //jika admin sudah wujud
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
                } else {

                    $aksesbaru->siriLatihanID = $id;
                    $aksesbaru->jenis = '1';
                    if ($aksesbaru->save(false)) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                    } else {
                        Yii::$app->session->setFlash('alert', ['title' => 'TIDAK Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                    }
                }
                //return $this->redirect(['tetapan-akses']);
            }
        }

        $aksesbaru2 = new Ceramah(); //untuk admin baru
        if (Yii::$app->request->post('submit') == 1) {

            //if ($aksesbaru2->load(Yii::$app->request->post())) {

            if (Yii::$app->request->post('addPenceramahLuar') != NULL) {

                $selection = Yii::$app->request->post('addPenceramahLuar');

                if (Ceramah::find()->where([
                    'penceramahID' => $selection,
                    'siriLatihanID' => $id
                ])->exists()) { //jika admin sudah wujud
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Sudah ditambah sebelum ini!']);
                } else {

                    $aksesbaru2->siriLatihanID = $id;
                    $aksesbaru2->penceramahID = $selection;
                    $aksesbaru2->jenis = '2';
                    if ($aksesbaru2->save(false)) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya ditambah!']);
                    } else {
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Tidak berjaya ditambah!']);
                    }
                }
                //return $this->redirect(['tetapan-akses']);
            }
        }

        $model2 = new Penceramah();
        if (Yii::$app->request->post('submit') == 2) {
            if ($model2->load(Yii::$app->request->post()) && $model2->save(false)) {
                $a = new Ceramah();
                $a->siriLatihanID = $id;
                $a->penceramahID = $model2->penceramah_id;
                $a->jenis = '2';
                if ($a->save(false)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya ditambah!']);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Tidak berjaya ditambah!']);
                }
            }
        }

        return $this->render('view_senarai_penceramah', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'model' => $this->findModelSiriLatihan($id),
            'aksesbaru' => $aksesbaru,
            'aksesbaru2' => $aksesbaru2,
            'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm'),
            'allPenceramahLuar' => ArrayHelper::map(Penceramah::find()->all(), 'penceramah_id', 'penceramah_name'),
            'model2' => $model2,
        ]);
    }

    public function actionViewSenaraiLatihanLive()
    {
        $today = date('Y-m-d');
        //$today2 = date('Y-m-d', strtotime($today));

        $siriLatihan = SiriLatihan::find()->where(['statusSiriLatihan' => 'ACTIVE'])->all();
        //->where("tarikhMula = $today")
        foreach ($siriLatihan as $siriLatihan) {
            if ($siriLatihan->tarikhMula <= $today) {
                $siriLatihan->statusSiriLatihan = "SEDANG BERJALAN";
                $siriLatihan->save(false);
            }
        }

        //        $dateBegin = date('Y-m-d', strtotime($this->tarikhMula));
        //        $dateEnd = date('Y-m-d', strtotime($this->tarikhAkhir));
        //
        //        if (($today >= $dateBegin) && ($today >= $dateEnd)){
        //            $this->statusLatihan = "LIVE";
        //        } else {
        //            $this->statusLatihan = "NOT LIVE";
        //        }

        $searchModel = new SiriLatihanLive();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view_senarai_latihan_live', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewSenaraiKehadiran()
    {
        $userID = Yii::$app->user->getId();

        //        $queryKehadiran = Kehadiran::find()->where(['staffID' => $userID]);
        //        $dataProviderKehadiran = new ActiveDataProvider([
        //            'query' => $queryKehadiran,
        //        ]);

        //        return $this->render('view_senarai_kehadiran', [
        //                    //'model' => $this->findModelSiriLatihan($id),
        //                    //'dataProvider' => $dataProvider,
        //                    'dataProviderKehadiran' => $dataProviderKehadiran,
        //                        //'searchModel' => $searchModel,
        //                        //'id' => $id,
        //                        //'slotID' => $slotID,
        //        ]);

        return $this->redirect(['profil', 'staffChosen' => $userID]);
    }

    public function actionViewKehadiran($kursusID)
    {
        //$model = $this->findModelLatihan($id);
        //this two lines of codes are for gridview
        //        $searchModel = new \app\models\myidp\KehadiranSearch();
        //        $dataProviderKehadiran = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view_kehadiran', [
            'model' => $this->findModelLatihan($kursusID),
        ]);

        //return $this->render('index', ['time' => date('H:i:s')]);
    }

    public function actionCreateLatihan()
    {
        $kursus = new KursusLatihan();
        $kursus->scenario = 'kursus-baru';

        $siriLatihan = new SiriLatihan();

        $userID = Yii::$app->user->getId();

        $kursus->jenisLatihanID = 'latihanDalaman';
        $kursus->statusKursusLatihan = 'AKTIF';
        $kursus->kursusImpakTinggi = '0';

        if ($kursus->load(Yii::$app->request->post()) && $kursus->save()) {

            $kursus->unitBertanggungjawab = $kursus->kategoriJawatanID;
            $kursus->updated = date('Y-m-d H:i:s');
            $kursus->updated_by = $userID;
            $kursus->dept_ID = Tblprcobiodata::find()->where(['ICNO' => $userID])->select('DeptId');
            $kursus->save(false);

            //                $siriLatihan->kursusLatihanID = $kursus->kursusLatihanID;
            //                $siriLatihan->siri = '1';
            //if ($siriLatihan->save(false)) {

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya daftar kursus baru!']);
            return $this->redirect(['view-senarai-latihan']); //redirect 'view-senarai-latihan' => URL not name of page i.e.
            //not 'view_senarai_latihan' like in render
            //}




        }

        //        if ($kursus->load(Yii::$app->request->post()) && $siriLatihan->load(Yii::$app->request->post())) {
        //
        //            $siriLatihan->file = UploadedFile::getInstances($siriLatihan, 'file');
        //            //$siriLatihanBahan->file = UploadedFile::getInstances($siriLatihanBahan, 'file');
        //
        //            if ($siriLatihan->file) {
        //
        //                if ($kursus->save(false)) {
        //
        //                    $siriLatihan->kursusLatihanID = $kursus->kursusLatihanID;
        //                    $siriLatihan->siri = '1';
        //
        //                    if ($siriLatihan->save(false)) {
        //
        ////                        echo "<br>1<br>";
        //
        //                        /******************************** TESTER CODES ************************************/
        //                        foreach ($siriLatihan->file as $file) {
        //                            $siriLatihanBahan = new SiriLatihanBahan();
        //                            $kursusLatihanBahan = new KursusLatihanBahan();
        ////                            echo "Count ".count($siriLatihan->file);
        ////                            echo "<br>";
        ////                            echo "<br>2<br>";
        //
        //                            /*****************************************/
        //                            //$datas = Yii::$app->FileManager->UploadFile($siriLatihan->file->name, $siriLatihan->file->tempName, '04', 'Maklumat Rekod Latihan/senaraiKehadiran');
        //                            $datas = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'Maklumat Rekod Latihan/senaraiKehadiran');
        //
        //                            if ($datas->status == true) {
        ////                                echo "<br>3<br>";
        //                                $siriLatihanBahan->filename = $datas->file_name_hashcode;
        //                                $siriLatihanBahan->siriLatihanID = $siriLatihan->siriLatihanID;
        //                                //$siriLatihanBahan->save(false);
        //                                $kursusLatihanBahan->filename = $datas->file_name_hashcode;
        //                                $kursusLatihanBahan->kursusLatihanID = $kursus->kursusLatihanID;
        //
        ////                                echo $siriLatihanBahan->filename;
        ////                                echo "<br>";
        ////                                echo $siriLatihanBahan->siriLatihanID;
        ////                                echo "<br>";
        //                                //$siriLatihan->save();
        ////                                if ($siriLatihanBahan->save(false) && $kursusLatihanBahan->save(false)) {
        ////                                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya!']);
        ////                                    return $this->redirect(['view-senarai-latihan']); //redirect 'view-senarai-latihan' => URL not name of page i.e.
        ////                                    //not 'view_senarai_latihan' like in render
        ////                                }
        //                            }
        ////                            echo "<br>4<br>";
        //                            $siriLatihanBahan->save(false);
        //                            $kursusLatihanBahan->save(false);
        //                        }
        //                        //$siriLatihanBahan->save(false);
        //                    }
        //                }
        //            }
        ////            var_dump($siriLatihan->file);
        ////            die();
        //        return $this->redirect(['view-senarai-latihan']); //redirect 'view-senarai-latihan' => URL not name of page i.e.
        ////                                    //not 'view_senarai_latihan' like in render
        //        }

        return $this->render('create_latihan', [
            'model' => $kursus,
            'model2' => $siriLatihan,
            //'model3' => $siriLatihanBahan,
            'status' => '1' //create latihan
        ]);
    }

    public function actionDaftarKursusJfpiu()
    {
        //        $kursus = new KursusLatihanJfpiu();
        //        $siriLatihan = new SiriLatihanJfpiu();

        $kursus = new KursusLatihan();
        $siriLatihan = new SiriLatihan();

        $kursus->jenisLatihanID = 'jfpiu';

        //$allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname');

        $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])
            ->all(), 'ICNO', function ($model) {
            //                    $a = $model['CONm'] . ' - ' . $model->department->shortname;
            $a = $model['CONm'];
            return $a;
        }); //groupby

        if ($kursus->load(Yii::$app->request->post()) && $siriLatihan->load(Yii::$app->request->post())) {

            if ($kursus->save(false)) {

                $siriLatihan->kursusLatihanID = $kursus->kursusLatihanID;
                $siriLatihan->siri = '1';
                $siriLatihan->masaMula = date("H:i", strtotime($siriLatihan->masaMula));
                $siriLatihan->masaTamat = date("H:i", strtotime($siriLatihan->masaTamat));

                if ($siriLatihan->save(false)) {

                    //$slotLatihan = new SlotLatihanJfpiu();
                    $slotLatihan = new SlotLatihan();
                    $slotLatihan->siriLatihanID = $siriLatihan->siriLatihanID;
                    $slotLatihan->slot = 1;
                    $slotLatihan->mataSlot = Yii::$app->request->post('jumlahMataIDP');
                    if ($slotLatihan->save(false)) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);

                        if (Yii::$app->request->post('momo') != NULL) {

                            $selection = Yii::$app->request->post('momo');

                            foreach ($selection as $idp) {

                                //$modelK = new KehadiranJfpiu();
                                $modelK = new Kehadiran();
                                $modelK->slotID = $slotLatihan->slotID;
                                $modelK->staffID = $idp;
                                $modelK->tarikhMasa = date('Y-m-d H:i:s');
                                $modelK->kategoriKursusID = $kursus->kompetensi;
                                $modelK->save(false);
                                if ($modelK->save(false)) {
                                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                                }
                            }
                            //                                     return $this->redirect(['senarai-kursus-jfpiu']);
                            return $this->redirect(['view-senarai-latihan']);
                        }
                    } else {
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                    }

                    //$i++;
                    //}



                    /*                         * ****************************** TESTER CODES *********************************** */
                    //                        $id = $siriLatihan->siriLatihanID;
                    //                        $datas = Yii::$app->FileManager->UploadFile($siriLatihan->file->name, $siriLatihan->file->tempName, '04', 'Maklumat Rekod Latihan/senaraiKehadiran');
                    //
                    //                        if ($datas->status == true) {
                    //                            $siriLatihan->filename = $datas->file_name_hashcode;
                    //                            $siriLatihan->save();
                    //
                    //                            $userID = Yii::$app->user->getId();
                    //
                    //                            //get current year
                    //                            $currentDate = date('Y-m-d H:i:s');
                    //
                    //                            /*                             * ************** create ********************************** */
                    ////                            $model = new PermohonanLatihan();
                    ////                            $model->staffID = $userID;
                    ////                            $model->kursusLatihanID = $kursus->kursusLatihanID;
                    ////                            $model->siriLatihanID = $id;
                    ////                            $model->statusPermohonan = 'BARU';
                    ////                            $model->tarikhPermohonan = $currentDate;
                    ////                            $model->caraPermohonan = 'JFPIU';
                    //
                    //                            $model = new PermohonanMataLatihan();
                    //                            $model->pemohonID = $userID;
                    //                            $model->kursusLatihanID = $kursus->kursusLatihanID;
                    //                            $model->siriLatihanID = $id;
                    //                            $model->statusPermohonan = 'BARU';
                    //                            $model->tarikhPermohonan = $currentDate;
                    //                            $model->mataDipohon = $siriLatihan->jumlahMataIDP;
                    //
                    //                            if ($model->save()) {
                    //                                Yii::$app->session->setFlash('alert', ['title' => ':)', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    //                                return $this->redirect(['view-senarai-permohonan-jfpiu']);
                    //                            }
                    //                        }
                }
            }
        }

        return $this->render('create_latihan_jfpiu_admin', [
            'model' => $kursus,
            'model2' => $siriLatihan,
            'allStaf' => $allStaf,
        ]);
    }

    public function actionSuratKursusLuar($permohonanID)
    {

        $permohonan = $this->findModelLatihanLuarPohon($permohonanID);
        $css = file_get_contents('./css/esurat.css');
        $mod = PermohonanKursusLuar::find()->where(['permohonanID' => $permohonanID])->exists();

        if ($mod && ($permohonan->jumlahLuluss == 0.00)) {
            $displaymohon = 'none';
        } elseif ($mod && !($permohonan->jumlahLuluss == 0.00)) {
            $displaymohon = '';
        }

        $content = $this->renderPartial('p_w_letter', ['permohonan' => $permohonan, 'displaymohon' => $displaymohon]);


        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            //'cssInline' => '.kv-heading-1{font-size:18px}',            
            //'cssInline' => '.modal-footer{text-align:left;}div.modal-body{padding:0px;}',
            'cssInline' => 'table.table2 {
                                    border: 1mm solid black;
                                    border-collapse: collapse;
                            }
                            tr.table2, th.table2 {
                                    padding: 3mm;
                                    border: 1mm solid black;
                                    vertical-align: middle;
                            }
                            td.table2 {
                                    padding: 3mm;
                                    border: 1mm solid black;
                                    vertical-align: middle;
                            }',
            // set mPDF properties on the fly
            'options' => ['title' => 'Surat Kelulusan Kursus Anjuran Agensi Luar'],
            // call mPDF methods on the fly
            'marginTop' => 35,
            'marginLeft' => 24,
            'marginRight' => 24,
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => [''],
                'WriteHTML' => [$css, 1]
            ]
        ]);

        return $pdf->render();
    }

    public function actionUpdateLatihanJfpiuAdmin($id)
    {
        $model = $this->findModelKursusJfpiu($id);
        $findSiri = SiriLatihanJfpiu::find()->where(['kursusLatihanID' => $id])->one();
        $findSlot = SlotLatihanJfpiu::find()->where(['siriLatihanID' => $findSiri->siriLatihanID])->one();

        if ($model->load(Yii::$app->request->post()) && $findSiri->load(Yii::$app->request->post())) {

            if ($model->save(false)) {

                $findSiri->masaMula = date("H:i", strtotime($findSiri->masaMula));
                $findSiri->masaTamat = date("H:i", strtotime($findSiri->masaTamat));

                if ($findSiri->save(false)) {

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);

                    if (Yii::$app->request->post('momo') != NULL) {

                        KehadiranJfpiu::deleteAll(['slotID' => $findSlot->slotID]);

                        $selection = Yii::$app->request->post('momo');

                        foreach ($selection as $idp) {

                            $checkPeserta = KehadiranJfpiu::find()
                                ->where(['staffID' => $idp])
                                ->andWhere(['slotID' => $findSlot->slotID])
                                ->one();

                            if (!$checkPeserta) {
                                $modelK = new KehadiranJfpiu();
                                $modelK->slotID = $findSlot->slotID;
                                $modelK->staffID = $idp;
                                $modelK->tarikhMasa = date('Y-m-d H:i:s');
                                $modelK->kategoriKursusID = $model->kompetensi;
                                $modelK->save(false);
                                if ($modelK->save(false)) {
                                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                                }
                            }
                        }
                        return $this->redirect(['senarai-kursus-jfpiu']);
                    }
                }
            }
        }

        return $this->render('update_latihan_jfpiu_admin', [
            'model' => $model,
            'model2' => $findSiri,
            'allStaf' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname'),
            'peserta' => ArrayHelper::map(KehadiranJfpiu::find()->where(['slotID' => $findSlot->slotID])->all(), 'staffID', 'staffID'),
        ]);

        //return $this->render('index', ['time' => date('H:i:s')]);
    }

    public function actionCreateLatihanJfpiu()
    {
        $kursus = new KursusLatihanJfpiu();
        $siriLatihan = new SiriLatihanJfpiu();

        $kursus->jenisLatihanID = 'jfpiu';

        if ($kursus->load(Yii::$app->request->post()) && $siriLatihan->load(Yii::$app->request->post())) {

            $siriLatihan->file = UploadedFile::getInstance($siriLatihan, 'file');

            if ($siriLatihan->file) {

                if ($kursus->save(false)) {

                    $siriLatihan->kursusLatihanID = $kursus->kursusLatihanID;
                    $siriLatihan->siri = '1';
                    $siriLatihan->masaMula = date("H:i", strtotime($siriLatihan->masaMula));
                    $siriLatihan->masaTamat = date("H:i", strtotime($siriLatihan->masaTamat));

                    if ($siriLatihan->save(false)) {

                        //get 'tarikh sandangan bagi gred terkini' from database
                        //function date_create() return a new DateTime object - if omitted, the date will be read as a string - DKW
                        $datetime1 = date_create($siriLatihan->tarikhMula);
                        $datetime2 = date_create($siriLatihan->tarikhAkhir);

                        //date_diff() function calculate the difference two dates
                        $dateDuration = date_diff($datetime1, $datetime2);

                        //format the date difference
                        $dateDuration2 = $dateDuration->format('%a');

                        //echo $dateDuration;
                        echo $dateDuration2;

                        $i = 1;

                        while ($i <= ($dateDuration2 + 1) * 2) {

                            //                var_dump('a');
                            //                die;

                            $slotLatihan = new SlotLatihanJfpiu();
                            $slotLatihan->siriLatihanID = $siriLatihan->siriLatihanID;
                            $slotLatihan->slot = $i;
                            if ($slotLatihan->save()) {
                                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                            } else {
                                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                            }

                            $i++;
                        }



                        /*                         * ****************************** TESTER CODES *********************************** */
                        $id = $siriLatihan->siriLatihanID;
                        $datas = Yii::$app->FileManager->UploadFile($siriLatihan->file->name, $siriLatihan->file->tempName, '04', 'Maklumat Rekod Latihan/senaraiKehadiran');

                        if ($datas->status == true) {
                            $siriLatihan->filename = $datas->file_name_hashcode;
                            $siriLatihan->save();

                            $userID = Yii::$app->user->getId();

                            //get current year
                            $currentDate = date('Y-m-d H:i:s');

                            /*                             * ************** create ********************************** */
                            //                            $model = new PermohonanLatihan();
                            //                            $model->staffID = $userID;
                            //                            $model->kursusLatihanID = $kursus->kursusLatihanID;
                            //                            $model->siriLatihanID = $id;
                            //                            $model->statusPermohonan = 'BARU';
                            //                            $model->tarikhPermohonan = $currentDate;
                            //                            $model->caraPermohonan = 'JFPIU';

                            $model = new PermohonanMataLatihan();
                            $model->pemohonID = $userID;
                            $model->kursusLatihanID = $kursus->kursusLatihanID;
                            $model->siriLatihanID = $id;
                            $model->statusPermohonan = 'BARU';
                            $model->tarikhPermohonan = $currentDate;
                            $model->mataDipohon = $siriLatihan->jumlahMataIDP;

                            if ($model->save()) {
                                Yii::$app->session->setFlash('alert', ['title' => ':)', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                                return $this->redirect(['view-senarai-permohonan-jfpiu']);
                            }
                        }
                    }
                }
            }
        }

        return $this->render('create_latihan_jfpiu', [
            'model' => $kursus,
            'model2' => $siriLatihan,
        ]);
    }

    public function actionTambahsiri($id)
    {
        $modelSiriLatihan = new SiriLatihan();
        //        $modelSiriLatihan->kursusLatihanID = $id;

        $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname');

        if (Yii::$app->request->post('submit') == 1) {
            if ($modelSiriLatihan->load(Yii::$app->request->post()) && $modelSiriLatihan->save()) {

                if (Yii::$app->request->post('momo') != NULL) {

                    $selection = Yii::$app->request->post('momo');

                    foreach ($selection as $idp) {

                        $modelCeramah = new Ceramah();
                        $modelCeramah->siriLatihanID = $modelSiriLatihan->siriLatihanID;
                        $modelCeramah->penceramahID = $idp;
                        $modelCeramah->jenis = '1';
                        $modelCeramah->save(false);
                    }
                }

                if (Yii::$app->request->post('addPenceramahLuar') != NULL) {

                    $selection2 = Yii::$app->request->post('addPenceramahLuar');

                    foreach ($selection2 as $idp) {

                        $modelCeramah = new Ceramah();
                        $modelCeramah->siriLatihanID = $modelSiriLatihan->siriLatihanID;
                        $modelCeramah->penceramahID = $idp;
                        $modelCeramah->jenis = '2';
                        $modelCeramah->save(false);
                    }
                }
                /*** Skip this step during MCO ***/
                //            //get 'tarikh sandangan bagi gred terkini' from database
                //            //function date_create() return a new DateTime object - if omitted, the date will be read as a string - DKW
                //            $datetime1 = date_create($modelSiriLatihan->tarikhMula);
                //            $datetime2 = date_create($modelSiriLatihan->tarikhAkhir);
                //
                //            //date_diff() function calculate the difference two dates
                //            $dateDuration = date_diff($datetime1, $datetime2);
                //
                //            //format the date difference
                //            $dateDuration2 = $dateDuration->format('%a');
                //
                //            //echo $dateDuration;
                //            //echo $dateDuration2;
                //
                //            $i = 1;
                //            $jumlahJamLatihan = 0;
                //
                //            while ($i <= ($dateDuration2 + 1) * 2) {
                //
                ////                var_dump('a');
                ////                die;
                //
                //                $slotLatihan = new SlotLatihan();
                //                $slotLatihan->siriLatihanID = $modelSiriLatihan->siriLatihanID;
                //                $slotLatihan->slot = $i;
                //                $slotLatihan->mataSlot = 3;
                ////                if ($slotLatihan->save()){
                ////                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                ////                } else {
                ////                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                ////                }
                //
                //                if ($slotLatihan->save()) {
                //
                //                    $jumlahJamLatihan = $jumlahJamLatihan + 3;
                //                    $modelSiriLatihan->jumlahJamLatihan = $jumlahJamLatihan;
                //                    $modelSiriLatihan->jumlahMataIDP = $jumlahJamLatihan;
                //                    $modelSiriLatihan->save(false);
                //
                //                    if ($i == ($dateDuration2 + 1) * 2) {
                //                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                //                        return $this->redirect(['form-tambah-siri?id=' . $id]);
                //                    }
                //                } else {
                //                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                //                    return $this->redirect(['tambahsiri?id=' . $id]);
                //                }
                //
                //                $i++;
                //            }

                /********************************************************************/
                /**** new calculation for MCO only ****/

                $slotLatihan = new SlotLatihan();
                $slotLatihan->siriLatihanID = $modelSiriLatihan->siriLatihanID;
                $slotLatihan->slot = 1;
                $slotLatihan->mataSlot = 6;

                if ($slotLatihan->save(false)) {

                    $jumlahJamLatihan = 2;
                    $modelSiriLatihan->jumlahJamLatihan = $jumlahJamLatihan;
                    $modelSiriLatihan->jumlahMataIDP = 6;
                    $modelSiriLatihan->save(false);

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                    return $this->redirect(['form-tambah-siri?id=' . $id]);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                    return $this->redirect(['tambahsiri?id=' . $id]);
                }
            }
        }

        $model2 = new Penceramah();
        if (Yii::$app->request->post('submit') == 2) {
            if ($model2->load(Yii::$app->request->post())) {
                if ($model2->save(false)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya ditambah!']);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Tidak berjaya ditambah!']);
                }
            }
        }

        // non-ajax - render the grid by default
        return $this->render('tambahsiri', [
            'model2' => $model2,
            'modelSiriLatihan' => $modelSiriLatihan,
            'allStaf' => $allStaf,
            'id' => $id,
            'allPenceramahLuar' => ArrayHelper::map(Penceramah::find()->all(), 'penceramah_id', 'penceramah_name'),
        ]);
    }

    public function actionFormTambahSiri($id)
    {
        //find kursus from VIdpSenaraiKursus that have value '$id'
        //$model = $this->findModelLatihan($id);
        /** baru * */
        $model = KursusLatihan::find()->where(['kursusLatihanID' => $id])->one();

        $query = SiriLatihan::find()->where(['kursusLatihanID' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //        $modelSiriLatihan = new SiriLatihan();
        ////        $modelSiriLatihan->kursusLatihanID = $id;
        //
        //        $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname');
        //
        //        if ($modelSiriLatihan->load(Yii::$app->request->post()) && $modelSiriLatihan->save()) {
        //
        //            if (Yii::$app->request->post('momo') != NULL){
        //
        //                $selection = Yii::$app->request->post('momo');
        //
        //                foreach ($selection as $idp){
        //
        //                    $modelCeramah = new Ceramah();
        //                    $modelCeramah->siriLatihanID = $modelSiriLatihan->siriLatihanID;
        //                    $modelCeramah->penceramahID = $idp;
        //                    $modelCeramah->save(false);
        //                }
        //            }
        //            //get 'tarikh sandangan bagi gred terkini' from database
        //            //function date_create() return a new DateTime object - if omitted, the date will be read as a string - DKW
        //            $datetime1 = date_create($modelSiriLatihan->tarikhMula);
        //            $datetime2 = date_create($modelSiriLatihan->tarikhAkhir);
        //
        //            //date_diff() function calculate the difference two dates
        //            $dateDuration = date_diff($datetime1, $datetime2);
        //
        //            //format the date difference
        //            $dateDuration2 =  $dateDuration->format('%a');
        //
        //            //echo $dateDuration;
        //            //echo $dateDuration2;
        //
        //            $i = 1;
        //            $jumlahJamLatihan = 0;
        //
        //            while ($i<=($dateDuration2+1)*2){
        //
        ////                var_dump('a');
        ////                die;
        //
        //                $slotLatihan = new SlotLatihan();
        //                $slotLatihan->siriLatihanID = $modelSiriLatihan->siriLatihanID;
        //                $slotLatihan->slot = $i;
        //                $slotLatihan->mataSlot = 3;
        ////                if ($slotLatihan->save()){
        ////                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
        ////                } else {
        ////                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
        ////                }
        //
        //                if ($slotLatihan->save()){
        //
        //                    $jumlahJamLatihan = $jumlahJamLatihan + 3;
        //                    $modelSiriLatihan->jumlahJamLatihan = $jumlahJamLatihan;
        //                    $modelSiriLatihan->jumlahMataIDP = $jumlahJamLatihan;
        //                    $modelSiriLatihan->save(false);
        //
        //                    if ($i == ($dateDuration2+1)*2){
        //                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
        //                        return $this->redirect(['form-tambah-siri?id='.$id]);
        //                    }
        //                } else {
        //                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
        //                }
        //
        //                $i++;
        //            }
        //        }
        // non-ajax - render the grid by default
        return $this->render('form_tambah_siri', [
            'modelLatihan' => $model,
            'dataProvider' => $dataProvider,
            //            'modelSiriLatihan' => $modelSiriLatihan,
            //            'allStaf' => $allStaf,
        ]);
    }

    public function actionViewJemputan($id)
    {
        $model = new KursusJemputan();

        if ($model->load(Yii::$app->request->post())) {

            $model->siriLatihanID = $id;

            $model->save(false);
            return $this->redirect(['view-jemputan', 'id' => $id]);
        }

        $searchModel = KursusJemputan::find()->where(['siriLatihanID' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel,
        ]);

        return $this->render('view_jemputan', [
            'model' => $model,
            'modelLatihan' => $this->findModelSiriLatihan($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewSenaraiJawatan($id)
    {
        //find kursus from VIdpSenaraiKursus that have value '$id'
        $modelLatihan = $this->findModelSiriLatihan($id);

        $query = KursusSasaran::find()->where(['siriLatihanID' => $id])->orderBy(['sasaranID' => SORT_DESC]);
        $dataProviderK = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProviderK->pagination->pageSize = 5;

        //this two lines of codes are for gridview
        $searchModel = new IdpGredJawatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //the codes below are for when the form is submitted
        //$kursusSasaran = new VIdpKursusSasaran();
        $kursusSasaran = new KursusSasaran();

        if ((array) Yii::$app->request->get('momo')) {

            $selection = (array) Yii::$app->request->get('momo');

            //        var_dump($selection);
            //        die();
            //foreach ($selection as $id) {
            //the codes below are for when the form is submitted
            //$kursusSasaran = new KursusSasaran();

            if ($kursusSasaran->load(Yii::$app->request->get())) {

                foreach ($selection as $selectionn) {

                    //var_dump($selectionn);
                    //die();
                    //\yii\helpers\VarDumper::dump($kursusSasaran,10,true);
                    //$kursusSasaran->gredJawatanID = $id;
                    //\yii\helpers\VarDumper::dump($kursusSasaran,10,true);
                    //                return $this->render('view_senarai_jawatan', [
                    //                'searchModel' => $searchModel,
                    //                'dataProvider' => $dataProvider,
                    //                'kursusSasaran' => $kursusSasaran,
                    //                'modelLatihan' => $modelLatihan,
                    //                ]);

                    if ($kursusSasaran->tahap == '4') {

                        for ($i = 1; $i <= 3; $i++) {

                            $checkSasaran = KursusSasaran::find()
                                ->where(['siriLatihanID' => $modelLatihan->siriLatihanID])
                                ->andWhere(['gredJawatanID' => $selectionn])
                                ->andWhere(['tahap' => $i])
                                ->one();

                            if (!$checkSasaran) {

                                $kursusSasaran2 = new KursusSasaran();
                                $kursusSasaran2->gredJawatanID = $selectionn;
                                $kursusSasaran2->tahap = $i;
                                $kursusSasaran2->siriLatihanID = $modelLatihan->siriLatihanID;
                                $kursusSasaran2->kategoriKursusID = $kursusSasaran->kategoriKursusID;
                                $kursusSasaran2->save(false);
                            }

                            //                        $kursusSasaran2 = new KursusSasaran();
                            //                        $kursusSasaran2->gredJawatanID = $id;
                            //                        $kursusSasaran2->tahap = $i;
                            //                        $kursusSasaran2->siriLatihanID = $kursusSasaran->siriLatihanID;
                            //                        $kursusSasaran2->kategoriKursusID = $kursusSasaran->kategoriKursusID;
                            //                        $kursusSasaran2->save(false);
                        }

                        //return $this->redirect(['view-senarai-jawatan?id='.$kursusSasaran2->siriLatihanID]);
                    } else {

                        //var_dump($selectionn);
                        //die();

                        $checkSasaran = KursusSasaran::find()
                            ->where(['siriLatihanID' => $modelLatihan->siriLatihanID])
                            ->andWhere(['gredJawatanID' => $selectionn])
                            ->andWhere(['tahap' => $kursusSasaran->tahap])
                            ->count();

                        //var_dump($checkSasaran);

                        if (!$checkSasaran) {

                            //var_dump($selectionn);
                            //die();
                            //                        $kursusSasaran = new KursusSasaran();
                            //                        $kursusSasaran->gredJawatanID = $selectionn;
                            //                        $kursusSasaran->save(false);

                            $kursusSasaran3 = new KursusSasaran();
                            $kursusSasaran3->gredJawatanID = $selectionn;
                            $kursusSasaran3->tahap = $kursusSasaran->tahap;
                            $kursusSasaran3->siriLatihanID = $modelLatihan->siriLatihanID;
                            $kursusSasaran3->kategoriKursusID = $kursusSasaran->kategoriKursusID;
                            $kursusSasaran3->save(false);
                        }

                        //                    if ($kursusSasaran->save(false)) {
                        //
                        //                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                        //                        return $this->redirect(['view-senarai-jawatan?id='.$kursusSasaran->siriLatihanID]);
                        //                        //$kursusSasaran->sasaran_id = $kursusSasaran->sasaran_id + 1;
                        //                        //\yii\helpers\VarDumper::dump($kursusSasaran,10,true);
                        //                    } else {
                        //                        Yii::$app->session->setFlash('alert', ['title' => 'TAK Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                        //                        return $this->redirect(['view-senarai-jawatan?id='.$kursusSasaran->siriLatihanID]);
                        //                    }
                    }
                } //tutup kursusSasaran load
                //            if ($kursusSasaran->save(false) || $kursusSasaran2->save(false)) {
                //
                //                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                //                        return $this->redirect(['view-senarai-jawatan?id='.$modelLatihan->siriLatihanID]);
                //                        //$kursusSasaran->sasaran_id = $kursusSasaran->sasaran_id + 1;
                //                        //\yii\helpers\VarDumper::dump($kursusSasaran,10,true);
                //            }
            } //tutup foreach
            return $this->redirect(['view-senarai-jawatan?id=' . $id]);
        }

        /*         * ********************************* Code below is enough for filter model **************************** */

        //        $searchModel = new IdpGredJawatanSearch();
        //        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view_senarai_jawatan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'kursusSasaran' => $kursusSasaran,
            'modelLatihan' => $modelLatihan,
            'dataProviderK' => $dataProviderK,
        ]);
    }

    public function actionCheckbox()
    {
        $kursus = new VIdpKursusSasaran();

        if ($kursus->load(Yii::$app->request->post()) && $kursus->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'warning', 'msg' => 'Berjaya!']);
            return $this->redirect(['index']); //redirect 'view-senarai-latihan' => URL not name of page i.e.
            //not 'view_senarai_latihan' like in render
        }

        return $this->render('checkbox', [
            'model' => $kursus,
            //'tarafJawatan' => $tarafJawatan,
        ]);
    }

    public function actionViewLatihan($id)
    {
        //Yii::$app->session->setFlash('confirm', 'This is the message');

        return $this->render('view_latihan', [
            'model' => $this->findModelLatihan($id),
        ]);
    }

    public function actionViewLatihanLuarPohon($permohonanID, $userLevel, $update)
    {
        $userID = Yii::$app->user->getId();

        if ($userLevel != "chief") {

            $userType = UserAccess::find()->where(['userID' => $userID])->one();

            if (!$userType || $userType->usertype == "admin") {
                $userLevel = "user";
            } else {

                $checkUrusetia = UrusetiaLatihan::find()
                    ->where(['userID' => $userID, 'ul_type' => 'ketuaUrusetia'])
                    ->one();

                if ($checkUrusetia) {

                    $userLevel = 'pegawaiLatihan';
                } else {

                    $userLevel = $userType->usertype;
                }
            }
        }

        //var_dump($userLevel);

        $model = $this->findModelLatihanLuarPohon($permohonanID);

        if ($model->load(Yii::$app->request->post())) {

            //            $model->tarikhDisemak = $today;
            //            $program->disemakOleh = $userID;

            if ($userLevel === 'chief') {
                $model->tarikhSemakanKJ = date("Y-m-d");
                $model->statusPermohonan = $model->statusKJ;
                $model->kjPenyemak = $userID;
            } elseif ($userLevel === 'ul') {
                $model->disemakOleh = $userID;
                $model->tarikhSemakanUL = date("Y-m-d");
                /** default statusUL = '6' i.e. layak / disemak * */
                //$model->statusPermohonan = $model->statusUL;
                $model->statusUL = 6;
                $model->statusPermohonan = $model->statusUL;
            } elseif ($userLevel === 'pegawaiLatihan') {
                $model->tarikhSemakanBSM = date("Y-m-d");
                $model->statusPermohonan = $model->statusBSM;
                $model->diperakuOleh = $userID;
            } elseif ($userLevel === 'ketuaSektor') {
                $model->tarikhKelulusan = date("Y-m-d");
                $model->statusPermohonan = $model->statusSektor;
                $model->diluluskanOleh = $userID;
            }

            //$model->save(false);
            /** For notification * */
            $model3 = Tblprcobiodata::findOne(['ICNO' => $model->pemohonID]);

            if ($model3->jawatan->job_category == 1) {

                $modelUrusetia = UrusetiaLatihan::find()->where(['ul_type' => 'akademik'])->one();
                $urusetia = $modelUrusetia->userID;
                $a = 1;
            } elseif ($model3->jawatan->job_category == 2) {

                $modelUrusetia = UrusetiaLatihan::find()->where(['ul_type' => 'pentadbiran'])->one();
                $urusetia = $modelUrusetia->userID;
                $a = 2;
            }

            $modelPeg = UserAccess::find()->where(['userType' => 'pegawaiLatihan'])->one();
            $modelSek = UserAccess::find()->where(['userType' => 'ketuaSektor'])->one();

            if ($modelPeg) {
                $pegawai = $modelPeg->userID;
            } else {
                $modelPeg = UrusetiaLatihan::find()->where(['ul_type' => 'ketuaUrusetia'])->one();
                if ($modelPeg) {
                    $pegawai = $modelPeg->userID;
                }
            }
            $ketuaSektor = $modelSek->userID;
            /** /For notification * */
            if ($model->save(false) && $userLevel === 'chief') {

                if ($a == 1) {
                    $this->notifikasi($urusetia, "Permohonan kursus luar " . strtoupper($model3->CONm) . " menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/semakan-kursus-luar-akademik'], ['class' => 'btn btn-danger btn-sm']));
                } else {
                    $this->notifikasi($urusetia, "Permohonan kursus luar " . strtoupper($model3->CONm) . " menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/semakan-kursus-luar-pentadbiran'], ['class' => 'btn btn-danger btn-sm']));
                }
                $this->notifikasi($model->pemohonID, "Permohonan kursus luar anda telah disemak oleh Ketua Jabatan. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));

                $update = 'NO';
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya!']);
                return $this->redirect(['view-latihan-luar-pohon?permohonanID=' . $model->permohonanID . '&userLevel=chief&update=' . $update]);
            } elseif ($model->save(false) && $userLevel === 'ul') {

                if ($a == 1) {
                    $this->notifikasi($pegawai, "Permohonan kursus luar " . strtoupper($model3->CONm) . " menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/semakan-kursus-luar-akademik'], ['class' => 'btn btn-danger btn-sm']));
                } else {
                    $this->notifikasi($pegawai, "Permohonan kursus luar " . strtoupper($model3->CONm) . " menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/semakan-kursus-luar-pentadbiran'], ['class' => 'btn btn-danger btn-sm']));
                }
                //$this->notifikasi($model->pemohonID, "Permohonan kursus luar anda telah disemak oleh Urusetia Latihan. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));

                $update = 'NO';
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya!']);
                return $this->redirect(['view-latihan-luar-pohon?permohonanID=' . $model->permohonanID . '&userLevel=ul&update=' . $update]);
            } elseif ($model->save(false) && $userLevel === 'pegawaiLatihan') {

                if ($a == 1) {
                    $this->notifikasi($ketuaSektor, "Permohonan kursus luar " . strtoupper($model3->CONm) . " menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/semakan-kursus-luar-akademik'], ['class' => 'btn btn-danger btn-sm']));
                } else {
                    $this->notifikasi($ketuaSektor, "Permohonan kursus luar " . strtoupper($model3->CONm) . " menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/semakan-kursus-luar-pentadbiran'], ['class' => 'btn btn-danger btn-sm']));
                }
                //$this->notifikasi($model->pemohonID, "Permohonan kursus luar anda telah disemak oleh BSM. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));

                $update = 'NO';
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya!']);
                return $this->redirect(['view-latihan-luar-pohon?permohonanID=' . $model->permohonanID . '&userLevel=pegawaiLatihan&update=' . $update]);
            } elseif ($model->save(false) && $userLevel === 'ketuaSektor') {

                if ($a == 1) {
                    if ($model->statusPermohonan == '10') {

                        $modelSurat = new SuratKursusLuar();
                        $modelSurat->permohonanID = $model->permohonanID;
                        $modelSurat->save(false);

                        $this->notifikasi($urusetia, "Permohonan kursus anjuran agensi luar " . strtoupper($model3->CONm) . " telah DILULUSKAN. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/semakan-kursus-luar-akademik'], ['class' => 'btn btn-danger btn-sm']));
                    } elseif ($model->statusPermohonan == '9') {
                        $this->notifikasi($urusetia, "Permohonan kursus anjuran agensi luar " . strtoupper($model3->CONm) . " TIDAK DILULUSKAN. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/semakan-kursus-luar-akademik'], ['class' => 'btn btn-danger btn-sm']));
                    }
                } else {
                    if ($model->statusPermohonan == '10') {
                        $this->notifikasi($urusetia, "Permohonan kursus anjuran agensi luar " . strtoupper($model3->CONm) . " telah DILULUSKAN. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/semakan-kursus-luar-pentadbiran'], ['class' => 'btn btn-danger btn-sm']));
                    } elseif ($model->statusPermohonan == '9') {
                        $this->notifikasi($urusetia, "Permohonan kursus anjuran agensi luar " . strtoupper($model3->CONm) . " TIDAK DILULUSKAN. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/semakan-kursus-luar-pentadbiran'], ['class' => 'btn btn-danger btn-sm']));
                    }
                }
                if ($model->statusPermohonan == '10') {
                    $this->notifikasi($pegawai, "Permohonan kursus anjuran agensi luar " . strtoupper($model3->CONm) . " telah DILULUSKAN. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/semakan-surat-kursus-luar'], ['class' => 'btn btn-danger btn-sm']));
                } elseif ($model->statusPermohonan == '9') {
                    $this->notifikasi($pegawai, "Permohonan kursus anjuran agensi luar " . strtoupper($model3->CONm) . " TIDAK DILULUSKAN. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/semakan-surat-kursus-luar'], ['class' => 'btn btn-danger btn-sm']));
                }
                $this->notifikasi($model->pemohonID, "Permohonan kursus luar anda telah disemak oleh BSM. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));

                $update = 'NO';
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya!']);
                return $this->redirect(['view-latihan-luar-pohon?permohonanID=' . $model->permohonanID . '&userLevel=pegawaiLatihan&update=' . $update]);
            }

            //return $this->redirect(['view-latihan-luar-pohon?permohonanID='.$model->permohonanID.'&userLevel=chief&update='.$update]);
            //return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('view_latihan_luar_pohon', [
            'model' => $this->findModelLatihanLuarPohon($permohonanID),
            'userLevel' => $userLevel,
            'update' => $update,
        ]);
    }

    public function actionViewKehadiranKursusLama($id)
    {
        $query = VCpdSenaraiLatihan::find()->where(['vcsl_kod_latihan' => $id])->orderBy('vcsl_kod_latihan');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $queryKehadiran = VCpdLatihan::find()->where(['vcl_kod_latihan' => $id])->orderBy(['vcl_tkh_mula' => SORT_DESC]);
        $dataProviderKehadiran = new ActiveDataProvider([
            'query' => $queryKehadiran,
        ]);

        // $searchModel = new KehadiranSearch();
        // if (Yii::$app->request->queryParams) {
        //     $dataProviderKehadiran = $searchModel->search(Yii::$app->request->queryParams);
        // }

        return $this->render('view_kehadiran_kursus_lama', [
            'model' => $this->findModelLatihanLama($id),
            'dataProvider' => $dataProvider,
            'dataProviderKehadiran' => $dataProviderKehadiran,
            // 'allStaf' => $allStaf,
            // 'allPeserta' => $allPeserta,
            // 'modelSlot' => $modelSlot,
            'id' => $id,
            // 'slotID' => $slotID,
            // //'dataProviderBiodata' => $dataProviderBiodata,
            // 'modelImport' => $modelImport,
            'modelKehadiran' => $queryKehadiran,
            //'searchModel' => $searchModel,
        ]);
    }

    public function actionViewLatihanLive($id, $slotID)
    {

        $query = SlotLatihan::find()->where(['siriLatihanID' => $id])->orderBy('slotID');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $modelSlot = SlotLatihan::find()->where(['slotID' => $slotID])->one();

        /** new 24/04/2020 **/
        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);

        $modelImport->addRule(['fileImport'], 'required');
        $modelImport->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx'], ['maxSize' => 1024 * 1024]);

        if (Yii::$app->request->post()) {

            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');

            if ($modelImport->fileImport && $modelImport->validate()) {

                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($modelImport->fileImport->tempName);
                $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $baseRow = 4;

                $countD = count($sheetData);

                //$email_not_exist = [];

                while ($baseRow <= $countD) {

                    $check = KehadiranImport::find()
                        ->where(['staffEmail' => (string) $sheetData[$baseRow]['B'], 'slotID' => $slotID])
                        ->one();

                    if (!$check) {
                        $model = new KehadiranImport;
                        $model->staffEmail = (string) $sheetData[$baseRow]['B'];
                        $model->slotID = $slotID;
                        $model->pemuatNaik = Yii::$app->user->getId();
                        $model->tarikhMuatNaik = date("Y-m-d");
                        //$model->save(false);

                        if ($model->save(false)) {

                            $modelBiodata = Tblprcobiodata::find()
                                ->where(['COEmail' => $model->staffEmail])
                                ->one();

                            if ($modelBiodata) {

                                $checkPeserta = Kehadiran::find()
                                    ->where(['staffID' => $modelBiodata->ICNO])
                                    ->andWhere(['slotID' => $slotID])
                                    ->one();

                                if (!$checkPeserta) {

                                    $model2 = new Kehadiran;
                                    $model2->slotID = $slotID;
                                    $model2->staffID = $modelBiodata->ICNO;
                                    $model2->tarikhMasa = date("Y-m-d H:i:s");

                                    $mohonList2 = PermohonanLatihan::find()
                                        ->where(['staffID' => $modelBiodata->ICNO])
                                        ->andWhere(['siriLatihanID' => $id])
                                        ->one();

                                    if (empty($mohonList2)) {
                                        $model2->statusPeserta = 'walk-in';
                                    } else {
                                        $model2->statusPeserta = $mohonList2->caraPermohonan;
                                    }

                                    /*** check kursus sasaran ***/
                                    $gredJawatan = $modelBiodata->gredJawatan;
                                    $tahap = $modelBiodata->tahapKhidmatStaf($modelBiodata->ICNO);

                                    $checkCategory = KursusSasaran::find()
                                        ->where("gredJawatanID = $gredJawatan and tahap = $tahap and siriLatihanID = $id")
                                        ->one();

                                    if ($checkCategory) {

                                        $kategoriKursusID = $checkCategory->kategoriKursusID;
                                    } else {
                                        //$kategoriKursusID = 0;

                                        $checkKompetensi = KursusLatihan::find()
                                            ->where(['kursusLatihanID' => $modelSlot->sasaran4->kursusLatihanID])
                                            ->one();

                                        if ($checkKompetensi->kompetensi == NULL) {
                                            $kategoriKursusID = 0;
                                        } else {
                                            $kategoriKursusID = $modelSlot->sasaran4->sasaran3->kompetensi;
                                        }

                                        //                    var_dump($kategoriKursusID);
                                        //                    die();
                                    }

                                    $model2->kategoriKursusID = $kategoriKursusID;

                                    if ($model2->save(false)) {

                                        $kursusID = SiriLatihan::find()->where(['siriLatihanID' => $id])->one();

                                        if ($model2->kategoriKursusID != 1) {

                                            $checkBorang2 = BorangPenilaianLatihan::find()
                                                ->where(['pesertaID' => $model2->staffID])
                                                ->andWhere(['siriLatihanID' => $id])
                                                ->one();

                                            $checkBorangK2 = BorangPenilaianKeberkesanan::find()
                                                ->where(['pesertaID' => $model2->staffID])
                                                ->andWhere(['siriLatihanID' => $id])
                                                ->one();

                                            if (!$checkBorang2 && !$checkBorangK2) {
                                                $borangpl2 = new BorangPenilaianLatihan();
                                                $borangpl2->pesertaID = $model2->staffID;
                                                $borangpl2->siriLatihanID = $id;
                                                $borangpl2->statusBorang = '1';
                                                $borangpl2->save(false);

                                                $borangpk2 = new BorangPenilaianKeberkesanan();
                                                $borangpk2->pesertaID = $model2->staffID;
                                                $borangpk2->siriLatihanID = $id;
                                                $borangpk2->statusBorang = '1';
                                                $borangpk2->save(false);
                                            }
                                        }
                                        Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya sahkan kehadiran kursus']);
                                    } //$model2->save(false)
                                }
                            }
                            //                            else {                    //$modelBiodata
                            //                                  array_push($email_not_exist, $model->staffEmail);
                            //
                            //                            }
                            //Yii::$app->session->setFlash('alert', ['title' => 'AMARAN', 'type' => 'warning', 'msg' => 'Senarai emel tidak berjaya dimuatnaik'.$email_not_exist]);
                        }

                        //$model->save();
                    }
                    $baseRow++;
                }
                return $this->redirect(['view-latihan-live?id=' . $id . '&slotID=' . $slotID]);
                Yii::$app->getSession()->setFlash('success', 'Success');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }
        /****/

        $queryKehadiran = Kehadiran::find()->where(['slotID' => $slotID])->orderBy(['tarikhMasa' => SORT_DESC]);
        $dataProviderKehadiran = new ActiveDataProvider([
            'query' => $queryKehadiran,
        ]);

        $searchModel = new KehadiranSearch();
        if (Yii::$app->request->queryParams) {
            $dataProviderKehadiran = $searchModel->search(Yii::$app->request->queryParams);
        }

        $hadir = Kehadiran::find()->where(['slotID' => $slotID])->all();

        $peserta = array();
        foreach ($hadir as $hadirr) {
            $peserta[] = $hadirr->staffID;
        }

        // // echo '<pre>' , var_dump(count($query)) , '</pre>';
        // // die();

        // $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])
        //                         ->where(['NOT IN', 'ICNO', $peserta])->all(), 'ICNO', function($model) {
        //             $a = $model['CONm'];
        //             return $a;
        //         }, 'department.fullname'); //groupby

        $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', function ($model) {
            $a = $model['CONm'];
            return $a;
        }, 'department.fullname'); //groupby

        $allPeserta = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])
            ->where(['IN', 'ICNO', $peserta])->all(), 'ICNO', function ($model) {
            $a = $model['CONm'];
            return $a;
        }, 'department.fullname'); //groupby

        if ((array) Yii::$app->request->post('selection') != NULL) {

            //echo "A";

            $selectionn = (array) Yii::$app->request->post('selection');
            var_dump($selectionn);
            //die();

            // foreach ($array as $key => $element) {
            //     if ($key === array_key_first($array)) {
            //         echo 'FIRST ELEMENT!';
            //     }

            //     if ($key === array_key_last($array)) {
            //         echo 'LAST ELEMENT!';
            //     }
            // }

            foreach ($selectionn as $selection) {

                $checkPeserta = Kehadiran::find()
                    ->where(['staffID' => $selection])
                    ->andWhere(['slotID' => $slotID])
                    ->one();

                if (!$checkPeserta) {

                    $today = date("Y-m-d H:i:s");

                    $modelH = new Kehadiran();
                    $modelH->slotID = $slotID;
                    $modelH->staffID = $selection;
                    $modelH->tarikhMasa = $today;
                    //$modelH->statusPeserta = 'walk-in';

                    $mohonList = PermohonanLatihan::find()
                        ->where(['staffID' => $selection])
                        ->andWhere(['siriLatihanID' => $id])
                        ->one();

                    if (empty($mohonList)) {
                        $modelH->statusPeserta = 'walk-in';
                    } else {
                        $modelH->statusPeserta = $mohonList->caraPermohonan;
                    }

                    /*                 * ***************** Check kursusSasaran ******************************** */
                    //$model = Idp::find()->where(['v_co_icno' => $userID, 'tahun' => $currentYear])->one();
                    //get 'gredjawatan' from database
                    //                $gredJawatan = $model->gredjawatan;
                    //                $tahap = $model->tahap;

                    //$model = Tblprcobiodata::findOne(['ICNO' => $selection]);
                    $model = Tblprcobiodata::find()->where(['ICNO' => $selection])->one();
                    $gredJawatan = $model->gredJawatan;
                    $tahap = $model->tahapKhidmatStaf($selection);

                    $checkCategory = KursusSasaran::find()
                        ->where("gredJawatanID = $gredJawatan and tahap = $tahap and siriLatihanID = $id")
                        ->one();

                    if ($checkCategory) {

                        $kategoriKursusID = $checkCategory->kategoriKursusID;
                    } else {
                        //$kategoriKursusID = 0;

                        $checkKompetensi = KursusLatihan::find()
                            ->where(['kursusLatihanID' => $modelSlot->sasaran4->kursusLatihanID])
                            ->one();

                        if ($checkKompetensi->kompetensi == NULL) {
                            $kategoriKursusID = 0;
                        } else {
                            $kategoriKursusID = $modelSlot->sasaran4->sasaran3->kompetensi;
                        }

                        //                    var_dump($kategoriKursusID);
                        //                    die();
                    }

                    $modelH->kategoriKursusID = $kategoriKursusID;

                    /*                 * *********************************************************************** */

                    //$modelH->save(false);

                    if ($modelH->save(false)) {

                        $kursusID = SiriLatihan::find()->where(['siriLatihanID' => $id])->one();

                        //var_dump($kursusID->kursusLatihanID);
                        //die();
                        //                    $checkBorang = BorangPenilaianLatihan::find()
                        //                    ->where(['pesertaID' => $selection])
                        //                    ->andWhere(['kursusLatihanID' => $kursusID])
                        //                    ->one();
                        //
                        //                    $checkBorangK = BorangPenilaianKeberkesanan::find()
                        //                    ->where(['pesertaID' => $selection])
                        //                    ->andWhere(['kursusLatihanID' => $kursusID])
                        //                    ->one();

                        if ($modelH->kategoriKursusID != 1) {

                            $checkBorang = BorangPenilaianLatihan::find()
                                ->where(['pesertaID' => $selection])
                                ->andWhere(['siriLatihanID' => $id])
                                ->one();

                            $checkBorangK = BorangPenilaianKeberkesanan::find()
                                ->where(['pesertaID' => $selection])
                                ->andWhere(['siriLatihanID' => $id])
                                ->one();

                            if (!$checkBorang && !$checkBorangK) {
                                $borangpl = new BorangPenilaianLatihan();
                                $borangpl->pesertaID = $selection;
                                //$borangpl->kursusLatihanID = $kursusID->kursusLatihanID;
                                $borangpl->siriLatihanID = $id;
                                $borangpl->statusBorang = '1';
                                $borangpl->save(false);

                                $borangpk = new BorangPenilaianKeberkesanan();
                                $borangpk->pesertaID = $selection;
                                //$borangpk->kursusLatihanID = $kursusID->kursusLatihanID;
                                $borangpk->siriLatihanID = $id;
                                $borangpk->statusBorang = '1';
                                $borangpk->save(false);

                                //                    if ($borangpl->save() && $borangpk->save()){
                                //                        Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya sahkan kehadiran kursus. Sila isi borang penilaian latihan selepas tamat latihan.']);
                                //                    }
                            }
                        }

                        //$model = Idp::find()->where(['v_co_icno' => $userID, 'tahun' => $currentYear])->one();
                        //get 'gredjawatan' from database
                        //                $gredJawatan = $model->gredjawatan;
                        //                $tahap = $model->tahap;
                        //                    $checkCategory = KursusSasaran::find()
                        //                            ->where(['siriLatihanID' => $id])
                        //                            ->andWhere(['gredJawatanID' => $gredJawatan])
                        //                            ->andWhere(['tahap' => $tahap])
                        //                            ->one();
                        //                $checkMata = IdpMata::find()
                        //                            ->where(['staffID' => $userID])
                        //                            ->andWhere(['tahun' => date('Y')])
                        //                            ->one();

                        $checkMata = IdpMata::find()
                            ->where(['staffID' => $selection])
                            ->andWhere(['tahun' => date('Y')])
                            ->one();

                        //if ($checkCategory){
                        if ($modelH->kategoriKursusID) {

                            if ($modelH->kategoriKursusID == 1) {

                                if ($checkMata) {
                                    $checkMata->mataUmum = $checkMata->mataUmum + 1;
                                    $checkMata->save(false);
                                } else {
                                    $newMata = new IdpMata();
                                    $newMata->staffID = $selection;
                                    $newMata->tahun = date('Y');
                                    $newMata->mataUmum = 1;
                                    $newMata->save(false);
                                }
                            } elseif ($modelH->kategoriKursusID == 3) {
                                if ($checkMata) {
                                    $checkMata->mataTeras = $checkMata->mataTeras + 3;
                                    $checkMata->save(false);
                                } else {
                                    $newMata = new IdpMata();
                                    $newMata->staffID = $selection;
                                    $newMata->tahun = date('Y');
                                    $newMata->mataTeras = 3;
                                    $newMata->save(false);
                                }
                            } elseif ($modelH->kategoriKursusID == 4) {
                                if ($checkMata) {
                                    $checkMata->mataElektif = $checkMata->mataElektif + 3;
                                    $checkMata->save(false);
                                } else {
                                    $newMata = new IdpMata();
                                    $newMata->staffID = $selection;
                                    $newMata->tahun = date('Y');
                                    $newMata->mataElektif = 3;
                                    $newMata->save(false);
                                }
                            } elseif ($modelH->kategoriKursusID == 5) {
                                if ($checkMata) {
                                    $checkMata->mataTerasUni = $checkMata->mataTerasUni + 3;
                                    $checkMata->save(false);
                                } else {
                                    $newMata = new IdpMata();
                                    $newMata->staffID = $selection;
                                    $newMata->tahun = date('Y');
                                    $newMata->mataTerasUni = 3;
                                    $newMata->save(false);
                                }
                            } elseif ($modelH->kategoriKursusID == 6) {
                                if ($checkMata) {
                                    $checkMata->mataTerasSkim = $checkMata->mataTerasSkim + 3;
                                    $checkMata->save(false);
                                } else {
                                    $newMata = new IdpMata();
                                    $newMata->staffID = $selection;
                                    $newMata->tahun = date('Y');
                                    $newMata->mataTerasSkim = 3;
                                    $newMata->save(false);
                                }
                            }
                        } else {
                            $kategoriKursusID = 0;
                        }



                        /* else {
                     *
                     *  if his is not in kursusSasaran, what will happen?
                     *
                     *
                     *
                     * }
                     */

                        //Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya sahkan kehadiran kursus']);
                        //return $this->redirect(['view-kehadiran', 'kursusID' => $kursusID]);
                        //return $this->redirect(Yii::$app->request->referrer);
                    }
                } //closed checkPeserta


            }

            if ($modelH) {
                if ($modelH->save(false)) {
                    //return $this->redirect(['view-latihan-live?id='.$id.'&slotID='.$slotID]);
                    Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya sahkan kehadiran kursus']);
                    return $this->redirect(['view-latihan-live?id=' . $id . '&slotID=' . $slotID]);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'warning', 'msg' => 'Tidak berjaya sahkan kehadiran kursus']);
                    return $this->redirect(['view-latihan-live?id=' . $id . '&slotID=' . $slotID]);
                }
            }
        }


        if ((array) Yii::$app->request->post('selectionn') != NULL) {

            $selectionn = (array) Yii::$app->request->post('selectionn');

            foreach ($selectionn as $selection) {

                return $this->redirect(['delete-peserta?slotID=' . $slotID . '&staffID=' . $selection]);
            }
        }

        if (Yii::$app->request->post('submit') == 1) {

            //var_dump(Yii::$app->request->post('submit'));
            //die();

            if ((array) Yii::$app->request->post('momo')) {

                $selection = (array) Yii::$app->request->post('momo');

                //                var_dump($selection);
                //                die();

                foreach ($selection as $selectionn) {

                    $model3 = Kehadiran::find()
                        ->joinWith('sasaran9')
                        ->where(['staffID' => $selectionn, 'siriLatihanID' => $id])
                        ->all();

                    foreach ($model3 as $model3) {

                        if ($model3->peserta->jawatan->job_category == '1') {

                            $model3->kategoriKursusID = Yii::$app->request->post('momok');
                            $model3->save(false);
                        } elseif ($model3->peserta->jawatan->job_category == '2') {
                            $model3->kategoriKursusID = Yii::$app->request->post('momokk');
                            $model3->save(false);
                        }

                        if ($model3->save(false)) {

                            if ($model3->kategoriKursusID != 1) {

                                $checkBorang2 = BorangPenilaianLatihan::find()
                                    ->where(['pesertaID' => $model3->staffID])
                                    ->andWhere(['siriLatihanID' => $id])
                                    ->one();

                                $checkBorangK2 = BorangPenilaianKeberkesanan::find()
                                    ->where(['pesertaID' => $model3->staffID])
                                    ->andWhere(['siriLatihanID' => $id])
                                    ->one();

                                if (!$checkBorang2 && !$checkBorangK2) {

                                    $borangpl2 = new BorangPenilaianLatihan();
                                    $borangpl2->pesertaID = $model3->staffID;
                                    $borangpl2->siriLatihanID = $id;
                                    $borangpl2->statusBorang = '1';
                                    $borangpl2->save(false);

                                    $borangpk2 = new BorangPenilaianKeberkesanan();
                                    $borangpk2->pesertaID = $model3->staffID;
                                    $borangpk2->siriLatihanID = $id;
                                    $borangpk2->statusBorang = '1';
                                    $borangpk2->save(false);
                                }
                            }

                            Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya ubah']);
                        }
                    }
                }
                return $this->redirect(['view-latihan-live?id=' . $id . '&slotID=' . $slotID]);
            }
        }


        //this two lines of codes are for gridview
        //        $searchModel = new \app\models\myidp\KehadiranSearch();
        //        $dataProviderKehadiran = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view_latihan_live', [
            'model' => $this->findModelSiriLatihan($id),
            'dataProvider' => $dataProvider,
            'dataProviderKehadiran' => $dataProviderKehadiran,
            'allStaf' => $allStaf,
            'allPeserta' => $allPeserta,
            'modelSlot' => $modelSlot,
            'id' => $id,
            'slotID' => $slotID,
            //'dataProviderBiodata' => $dataProviderBiodata,
            'modelImport' => $modelImport,
            'modelKehadiran' => $queryKehadiran,
            'searchModel' => $searchModel,
        ]);

        //return $this->render('index', ['time' => date('H:i:s')]);
    }

    public function actionDaftarkehadiran($id, $slotID)
    {
        $query = SlotLatihan::find()->where(['siriLatihanID' => $id])->indexBy('slotID');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $queryKehadiran = Kehadiran::find()->where(['slotID' => $slotID])->andWhere(['staffID' => Yii::$app->user->getId()]);
        $dataProviderKehadiran = new ActiveDataProvider([
            'query' => $queryKehadiran,
        ]);

        /*         * ********* test *************** */
        //        $mpdf = new \Mpdf\Mpdf();
        //        $mpdf->WriteHTML($this->renderPartial('daftarkehadiran', [
        //                    'model' => $this->findModelSiriLatihan($id),
        //                    'dataProvider' => $dataProvider,
        //                    'dataProviderKehadiran' => $dataProviderKehadiran,
        //                    //'searchModel' => $searchModel,
        //                    'id' => $id,
        //                    'slotID' => $slotID,
        //                    'pesertaID' => Yii::$app->user->getId(),
        //        ]));
        //        $mpdf->Output();



        /*         * ****************************** */

        return $this->renderAjax('daftarkehadiran', [
            'model' => $this->findModelSiriLatihan($id),
            'dataProvider' => $dataProvider,
            'dataProviderKehadiran' => $dataProviderKehadiran,
            //'searchModel' => $searchModel,
            'id' => $id,
            'slotID' => $slotID,
            'pesertaID' => Yii::$app->user->getId(),
        ]);

        //return $this->render('index', ['time' => date('H:i:s')]);
    }

    public function actionDaftarkehadiranslot($id, $slotID)
    {
        $query = SlotLatihan::find()->where(['siriLatihanID' => $id])->indexBy('slotID');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $queryKehadiran = Kehadiran::find()->where(['slotID' => $slotID])->andWhere(['staffID' => Yii::$app->user->getId()]);
        $dataProviderKehadiran = new ActiveDataProvider([
            'query' => $queryKehadiran,
        ]);

        return $this->renderAjax('daftarkehadiranslot', [
            'model' => $this->findModelSiriLatihan($id),
            'dataProvider' => $dataProvider,
            'dataProviderKehadiran' => $dataProviderKehadiran,
            //'searchModel' => $searchModel,
            'id' => $id,
            'slotID' => $slotID,
            'pesertaID' => Yii::$app->user->getId(),
        ]);

        //return $this->render('index', ['time' => date('H:i:s')]);
    }
    /** Kartik Gridview ExpandRow Example **/
    //    public function actionBookDetail() {
    //        if (isset($_POST['expandRowKey'])) {
    //            $model = \app\models\Book::findOne($_POST['expandRowKey']);
    //            return $this->renderPartial('_book-details', ['model'=>$model]);
    //        } else {
    //            return '<div class="alert alert-danger">No data found</div>';
    //        }
    //    }

    public function actionViewPeserta($siriID, $dept)
    {

        //        if (isset($_POST['expandRowKey'])) {
        //            $model = Ceramah::findOne($_POST['expandRowKey']);
        //            return $this->renderPartial('view_penceramah', ['model'=>$model, 'id' => '1']);
        //        } else {
        //            return '<div class="alert alert-danger">No data found</div>';
        //        }

        $model = $this->findModelPesertaByDept($siriID, $dept);

        //        if ($model->load(Yii::$app->request->get()) && $model->save(false)) {
        //
        //            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat bayaran telah dikemaskini.']);
        //            return $this->redirect(['view-senarai-penceramah?id='.$siriID]);
        //        }

        return $this->render('view_peserta', [
            'model' => $model
        ]);
    }

    //    public function actionViewPenceramah($siriID, $penceramahID) {
    //        
    ////        if (isset($_POST['expandRowKey'])) {
    ////            $model = Ceramah::findOne($_POST['expandRowKey']);
    ////            return $this->renderPartial('view_penceramah', ['model'=>$model, 'id' => '1']);
    ////        } else {
    ////            return '<div class="alert alert-danger">No data found</div>';
    ////        }
    //        
    //        $model = $this->findModelPenceramahSiri($siriID, $penceramahID);
    //        
    //        if ($model->load(Yii::$app->request->get()) && $model->save(false)) {
    //
    //            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat bayaran telah dikemaskini.']);
    //            return $this->redirect(['view-senarai-penceramah?id='.$siriID]);
    //        }
    //
    //        return $this->render('view_penceramah', [
    //                    'model' => $model
    //        ]);
    //    }

    public function actionUpdateSiri($id)
    {
        $modelSiriLatihan = $this->findModelSiriLatihan($id);

        //        if ($modelSiriLatihan->load(Yii::$app->request->post()) && $modelSiriLatihan->save()) {
        //            //return $this->redirect(['view', 'id' => $model->id]); //selepas 'UPDATE' dan SUBMIT dia akan pergi page 'view'
        //            return $this->redirect(['form-tambah-siri', 'id' => $modelSiriLatihan->kursusLatihanID]);
        //            //return $this->redirect(Yii::$app->request->referrer);
        //
        //        }

        /** for status changes **/
        $previousStatus = 0;
        $newStatus = 0;

        if ($modelSiriLatihan->statusSiriLatihan == 'ACTIVE') {

            $previousStatus = 1;
            $newStatus = 1;
        }

        /** for date changes **/

        $previousDate = date_create($modelSiriLatihan->tarikhMula);

        if ($modelSiriLatihan->load(Yii::$app->request->post())) {

            //            if($modelSiriLatihan->tarikhMula == date('Y-m-d')){
            //                $modelSiriLatihan->statusSiriLatihan = "SEDANG BERJALAN";
            //            } else {
            //                $modelSiriLatihan->statusSiriLatihan = "AKTIF";
            //            }

            if ($modelSiriLatihan->save(false)) {

                /** notifications if kursus ditunda **/

                if (
                    $modelSiriLatihan->statusSiriLatihan == 'DITANGGUHKAN'
                    && $previousStatus == 1
                ) {

                    $previousStatus = 1;
                    $newStatus = 2;
                }

                if ($previousStatus == 1 && $newStatus == 2) {

                    $modelSiri = PermohonanLatihan::find()
                        ->where(['siriLatihanID' => $modelSiriLatihan->siriLatihanID])
                        ->all();

                    foreach ($modelSiri as $modelSirix) {

                        $this->notifikasi($modelSirix->staffID, "Harap maaf, kursus " . strtoupper($modelSirix->sasaran3->tajukLatihan) . " telah ditangguhkan ke tarikh baru yang akan diberitahu kemudian." . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));
                    }
                }

                $newDate = date_create($modelSiriLatihan->tarikhMula);

                if ($previousDate != $newDate) {

                    $modelSiri = PermohonanLatihan::find()
                        ->where(['siriLatihanID' => $modelSiriLatihan->siriLatihanID])
                        ->all();

                    foreach ($modelSiri as $modelSirix) {

                        $this->notifikasi($modelSirix->staffID, "Harap maaf, kursus " . strtoupper($modelSirix->sasaran3->tajukLatihan) . " telah ditukar ke tarikh baru iaitu " . \Yii::$app->formatter->asDate($modelSirix->sasaran6->tarikhMula, 'php:d-m-Y') . '.' . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));
                    }
                }




                /***************************************/

                if (Yii::$app->request->post('momo') != NULL) {

                    $selection = Yii::$app->request->post('momo');

                    var_dump($selection);
                    //die();

                    Ceramah::deleteAll(['siriLatihanID' => $id]);

                    foreach ($selection as $idp) {

                        $checkPenceramah = Ceramah::find()
                            ->where(['penceramahID' => $idp])
                            ->andWhere(['siriLatihanID' => $modelSiriLatihan->siriLatihanID])
                            ->one();

                        if (!$checkPenceramah) {
                            $modelCeramah = new Ceramah();
                            $modelCeramah->siriLatihanID = $modelSiriLatihan->siriLatihanID;
                            $modelCeramah->penceramahID = $idp;
                            $modelCeramah->save(false);
                        }
                    }
                }
            }
            /** skip this step during MCO **/
            //            //get 'tarikh sandangan bagi gred terkini' from database
            //            //function date_create() return a new DateTime object - if omitted, the date will be read as a string - DKW
            //            $datetime1 = date_create($modelSiriLatihan->tarikhMula);
            //            $datetime2 = date_create($modelSiriLatihan->tarikhAkhir);
            //
            //            //date_diff() function calculate the difference two dates
            //            $dateDuration = date_diff($datetime1, $datetime2);
            //
            //            //format the date difference
            //            $dateDuration2 = $dateDuration->format('%a');
            //
            //            //echo $dateDuration;
            //            //echo $dateDuration2;
            //
            //            $i = 1;
            //            $jumlahJamLatihan = 0;
            //
            //            while ($i <= ($dateDuration2 + 1) * 2) {
            //
            ////                var_dump('a');
            ////                die;
            //
            //                $slotLatihan = new SlotLatihan();
            //                $slotLatihan->siriLatihanID = $modelSiriLatihan->siriLatihanID;
            //                $slotLatihan->slot = $i;
            //                $slotLatihan->mataSlot = 3;
            ////                if ($slotLatihan->save()){
            ////                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
            ////                } else {
            ////                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
            ////                }
            //
            //                if ($slotLatihan->save()) {
            //
            //                    $jumlahJamLatihan = $jumlahJamLatihan + 3;
            //                    $modelSiriLatihan->jumlahJamLatihan = $jumlahJamLatihan;
            //                    $modelSiriLatihan->jumlahMataIDP = $jumlahJamLatihan;
            //                    $modelSiriLatihan->save(false);
            //                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
            //                } else {
            //                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
            //                }
            //
            //                $i++;
            //            }

            /**** new calculation for MCO only ****/

            $slotLatihan = new SlotLatihan();
            $slotLatihan->siriLatihanID = $modelSiriLatihan->siriLatihanID;
            $slotLatihan->slot = 1;
            $slotLatihan->mataSlot = 6;

            if ($slotLatihan->save(false)) {

                $jumlahJamLatihan = 2;
                $modelSiriLatihan->jumlahJamLatihan = $jumlahJamLatihan;
                $modelSiriLatihan->jumlahMataIDP = 6;
                $modelSiriLatihan->save(false);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                return $this->redirect(['form-tambah-siri?id=' . $modelSiriLatihan->kursusLatihanID]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                return $this->redirect(['form-tambah-siri?id=' . $modelSiriLatihan->kursusLatihanID]);
            }

            //return $this->redirect(['form-tambah-siri', 'id' => $modelSiriLatihan->kursusLatihanID]);
        }

        return $this->render('update_siri', [
            'modelSiriLatihan' => $modelSiriLatihan,
            'allStaf' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname'),
            'penceramah' => ArrayHelper::map(Ceramah::find()->where(['siriLatihanID' => $modelSiriLatihan->siriLatihanID, 'jenis' => '1'])->all(), 'penceramahID', 'penceramahID'),
            //'penceramahluar' => ArrayHelper::map(Ceramah::find()->where(['siriLatihanID' => $modelSiriLatihan->siriLatihanID, 'jenis' => '2'])->all(), 'penceramahID', 'penceramahID'),
        ]);

        //return $this->render('index', ['time' => date('H:i:s')]);
    }

    public function actionSemakPermohonanSiri($id, $pagee)
    {
        $modelSiriLatihan = $this->findModelSiriLatihan($id);

        if ($pagee == 'viewPemohon') {
            $queryPemohon = PermohonanLatihan::find()
                ->where(['siriLatihanID' => $id])
                ->orderBy(['tarikhPermohonan' => SORT_DESC]);
        } elseif ($pagee == 'viewSahHadir') {
            $queryPemohon = PermohonanLatihan::find()
                ->where(['siriLatihanID' => $id])
                ->andWhere(['sahHadirbyStaf' => 'YA'])
                ->orderBy(['tarikhPermohonan' => SORT_DESC]);
        } elseif ($pagee == 'viewSahTidakHadir') {
            $queryPemohon = PermohonanLatihan::find()
                ->where(['siriLatihanID' => $id])
                ->andWhere(['sahHadirbyStaf' => 'TIDAK'])
                ->orderBy(['tarikhPermohonan' => SORT_DESC]);
        }

        $dataProviderPemohon = new ActiveDataProvider([
            'query' => $queryPemohon,
        ]);

        //$searchModel = new PermohonanLatihanSearch();
        //$dataProviderPemohon = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('semak_permohonan_siri', [
            'modelSiriLatihan' => $modelSiriLatihan,
            'siriID' => $id,
            'dataProviderPemohon' => $dataProviderPemohon,
            //'searchModel' => $searchModel,
        ]);
    }

    public function actionJemputPeserta($id)
    {
        $modelSiriLatihan = $this->findModelSiriLatihan($id);

        $queryJemputan = PermohonanLatihan::find()
            ->where(['siriLatihanID' => $id])
            ->andWhere(['caraPermohonan' => 'jemputan'])
            ->orderBy(['tarikhPermohonan' => SORT_DESC]);

        $dataProviderJemputan = new ActiveDataProvider([
            'query' => $queryJemputan,
        ]);

        //        ArrayHelper::map(
        //            \app\models\Medicine::find()->asArray()->all(),
        //            'id',
        //            function($model) {
        //                return $model['medicine_name'].'-'.$model['medicine_id'];
        //            }
        //        )

        $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])
            ->all(), 'ICNO', function ($model) {
            $a = $model['CONm'] . ' - ' . $model->department->shortname;
            return $a;
        }, 'department.fullname'); //groupby
        //        $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])
        //                ->all(), 'ICNO', 'CONm', 'department.fullname');
        //        $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])
        //                ->select(new Expression('`hronline`.`tblprcobiodata`.`ICNO` as ICNO, CONCAT(`hronline`.`tblprcobiodata`.`CONm` , \' - \' , `a`.`shortname`) as CONm'))
        //                ->leftJoin(['a' => '`hronline`.`department`'], '`a`.`id` = `hronline`.`tblprcobiodata`.`DeptId`')
        //                ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm', 'department.fullname');

        if (Yii::$app->request->post('momo') != NULL) {

            $selection = Yii::$app->request->post('momo');

            foreach ($selection as $idp) {

                //                    $modelCeramah = new Ceramah();
                //                    $modelCeramah->siriLatihanID = $modelSiriLatihan->siriLatihanID;
                //                    $modelCeramah->penceramahID = $idp;
                //                    $modelCeramah->save(false);

                $model = new PermohonanLatihan();
                $model->staffID = $idp;
                $model->kursusLatihanID = $modelSiriLatihan->kursusLatihanID;
                $model->siriLatihanID = $id;
                $model->statusPermohonan = 'DILULUSKAN';
                $model->tarikhPermohonan = date('Y-m-d H:i:s');
                $model->caraPermohonan = 'JEMPUTAN';
                $model->kategoriKursusID = 0;
                $model->save(false);

                /** Notification * */
                //if ($model->save(false)
            }
        }

        return $this->render('jemput_peserta', [
            'modelSiriLatihan' => $modelSiriLatihan,
            'siriID' => $id,
            'dataProviderJemputan' => $dataProviderJemputan,
            'allStaf' => $allStaf,
            'modelJemputan' => $queryJemputan,
        ]);
    }

    public function actionViewSahkehadiran()
    {
        //Yii::$app->session->setFlash('confirm', 'This is the message');
        //        return $this->render('view_sahkehadiran', [
        //                    'model' => $this->findModelSiriLatihan($id),
        //        ]);

        return $this->render('view_sahkehadiran');
    }

    public function actionImportImpak()
    {
        $today = date("Y-m-d");
        $userID = Yii::$app->user->getId();

        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);

        $modelImport->addRule(['fileImport'], 'required');
        $modelImport->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx'], ['maxSize' => 1024 * 1024]);

        if (Yii::$app->request->post()) {

            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');

            if ($modelImport->fileImport && $modelImport->validate()) {

                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($modelImport->fileImport->tempName);
                $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $baseRow = 4;

                $countD = count($sheetData);

                while ($baseRow <= $countD) {

                    $checkLatihan = KursusLatihanImport::find()
                        ->where(['tajukLatihan' => (string) $sheetData[$baseRow]['B']])
                        ->one();

                    if (!$checkLatihan) {
                        $model = new KursusLatihanImport;
                        $model->tajukLatihan = (string) $sheetData[$baseRow]['B'];
                        $model->unitBertanggungjawab = 'CBTM';
                        $model->pemuatNaik = $userID;
                        $model->tarikhMuatNaik = $today;
                        $model->jenisPenganjur = (string) $sheetData[$baseRow]['G'];
                        $model->namaPenganjur = (string) $sheetData[$baseRow]['H'];
                        $model->peringkat = (string) $sheetData[$baseRow]['J'];

                        if ($model->save(false)) {
                            $model2 = new KursusLatihan;
                            $model2->tajukLatihan = $model->tajukLatihan;
                            $model2->statusKursusLatihan = "AKTIF";
                            $model2->unitBertanggungjawab = $model->unitBertanggungjawab;
                            $model2->jenisLatihanID = "latihanDalaman";
                            $model2->penggubalModul = "158";
                            $model2->kursusImpakTinggi = "1";
                            $model2->kompetensi = "7";
                            $model2->updated_by = $userID;
                            $model2->updated = date('Y-m-d H:i:s');

                            $date1 = date_create($sheetData[$baseRow]['D']);

                            // var_dump($d);
                            // die();

                            $date3 = date_format($date1, "Y");
                            $model2->tahunTawaran = $date3;

                            $model2->jenisPenganjur = $model->jenisPenganjur;
                            $model2->namaPenganjur = $model->namaPenganjur;
                            $model2->kategori_latihan = $model->peringkat;
                            $model2->kategoriJawatanID = (string) $sheetData[$baseRow]['C'];
                            $model2->sinopsisKursus = (string) $sheetData[$baseRow]['F'];

                            if ($model2->save(false)) {

                                if ($sheetData[$baseRow]['D'] && $sheetData[$baseRow]['E']) {

                                    $date1 = date_create($sheetData[$baseRow]['D']);
                                    $date2 = date_create($sheetData[$baseRow]['E']);
                                    $date3 = date_format($date1, "Y-m-d");
                                    $date4 = date_format($date2, "Y-m-d");

                                    $siriLatihan = new SiriLatihan();

                                    $siriLatihan->kursusLatihanID = $model2->kursusLatihanID;
                                    $siriLatihan->siri = '1';
                                    $siriLatihan->tarikhMula = $date3;
                                    $siriLatihan->tarikhAkhir = $date4;

                                    if ($siriLatihan->save(false)) {

                                        /*** Skip this step during MCO ***/

                                        //                                        //function date_create() return a new DateTime object - if omitted, the date will be read as a string - DKW
                                        //                                        $datetime1 = date_create($siriLatihan->tarikhMula);
                                        //                                        $datetime2 = date_create($siriLatihan->tarikhAkhir);
                                        //
                                        //                                        //date_diff() function calculate the difference two dates
                                        //                                        $dateDuration = date_diff($date1, $date2);
                                        //
                                        //                                        //format the date difference
                                        //                                        $dateDuration2 = $dateDuration->format('%a');
                                        //
                                        //                                        $i = 1;
                                        //                                        $jumlahJamLatihan = 0;
                                        //
                                        //                                        while ($i <= ($dateDuration2 + 1) * 2) {
                                        //
                                        //                                            $slotLatihan = new SlotLatihan();
                                        //                                            $slotLatihan->siriLatihanID = $siriLatihan->siriLatihanID;
                                        //                                            $slotLatihan->slot = $i;
                                        //                                            $slotLatihan->mataSlot = 3;
                                        //
                                        //                                            if ($slotLatihan->save()) {
                                        //
                                        //                                                //var_dump($slotLatihan->slot);
                                        //
                                        //                                                $jumlahJamLatihan = $jumlahJamLatihan + 3;
                                        //                                                $siriLatihan->jumlahJamLatihan = $jumlahJamLatihan;
                                        //                                                $siriLatihan->jumlahMataIDP = $jumlahJamLatihan;
                                        //
                                        //                                                $siriLatihan->save(false);
                                        //
                                        //                                                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                                        //                                            } else {
                                        //                                                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                                        //                                            }
                                        //
                                        //                                            $i++;
                                        //                                        }
                                        /*** MCO ***/

                                        /********************************************************************/
                                        /**** new calculation for MCO only ****/

                                        $slotLatihan = new SlotLatihan();
                                        $slotLatihan->siriLatihanID = $siriLatihan->siriLatihanID;
                                        $slotLatihan->slot = 1;
                                        $slotLatihan->mataSlot = 6;

                                        if ($slotLatihan->save(false)) {

                                            $jumlahJamLatihan = 2;
                                            $siriLatihan->jumlahJamLatihan = $jumlahJamLatihan;
                                            $siriLatihan->jumlahMataIDP = 6;
                                            $siriLatihan->save(false);

                                            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                                        } else {
                                            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                                        }
                                    }
                                }
                            }
                        }

                        //$model->save();
                    }
                    $baseRow++;
                }
                Yii::$app->getSession()->setFlash('success', 'Success');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }

        return $this->render('import', [
            'modelImport' => $modelImport,
        ]);
    }

    public function actionImport()
    {
        $today = date("Y-m-d");
        $userID = Yii::$app->user->getId();

        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);

        $modelImport->addRule(['fileImport'], 'required');
        $modelImport->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx'], ['maxSize' => 1024 * 1024]);

        if (Yii::$app->request->post()) {

            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');

            if ($modelImport->fileImport && $modelImport->validate()) {

                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($modelImport->fileImport->tempName);
                $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $baseRow = 4;

                $countD = count($sheetData);

                while ($baseRow <= $countD) {

                    $checkLatihan = KursusLatihanImport::find()
                        ->where(['tajukLatihan' => (string) $sheetData[$baseRow]['B']])
                        ->one();

                    if (!$checkLatihan) {
                        $model = new KursusLatihanImport;
                        $model->tajukLatihan = (string) $sheetData[$baseRow]['B'];
                        $model->unitBertanggungjawab = (string) $sheetData[$baseRow]['C'];
                        $model->statusKursus = 'AKTIF';
                        $model->pemuatNaik = $userID;
                        $model->tarikhMuatNaik = $today;
                        //$model->save(false);

                        if ($model->save(false)) {
                            $model2 = new KursusLatihan;
                            $model2->tajukLatihan = $model->tajukLatihan;
                            $model2->statusKursusLatihan = $model->statusKursus;
                            $model2->unitBertanggungjawab = $model->unitBertanggungjawab;
                            $model2->jenisLatihanID = "latihanDalaman";

                            //if ($sheetData[$baseRow]['F']){
                            $model2->sinopsisKursus = (string) $sheetData[$baseRow]['F'];
                            //}
                            //var_dump($model2->sinopsisKursus);
                            //die();
                            //$model2->save(false);

                            if ($model2->save(false)) {

                                if ($sheetData[$baseRow]['D'] && $sheetData[$baseRow]['E']) {

                                    $date1 = date_create($sheetData[$baseRow]['D']);
                                    $date2 = date_create($sheetData[$baseRow]['E']);
                                    $date3 = date_format($date1, "Y:m:d");
                                    $date4 = date_format($date2, "Y:m:d");

                                    $siriLatihan = new SiriLatihan();

                                    $siriLatihan->kursusLatihanID = $model2->kursusLatihanID;
                                    $siriLatihan->siri = '1';
                                    $siriLatihan->tarikhMula = $date3;
                                    $siriLatihan->tarikhAkhir = $date4;

                                    if ($siriLatihan->save(false)) {

                                        /*** Skip this step during MCO ***/

                                        //                                        //function date_create() return a new DateTime object - if omitted, the date will be read as a string - DKW
                                        //                                        $datetime1 = date_create($siriLatihan->tarikhMula);
                                        //                                        $datetime2 = date_create($siriLatihan->tarikhAkhir);
                                        //
                                        //                                        //date_diff() function calculate the difference two dates
                                        //                                        $dateDuration = date_diff($date1, $date2);
                                        //
                                        //                                        //format the date difference
                                        //                                        $dateDuration2 = $dateDuration->format('%a');
                                        //
                                        //                                        $i = 1;
                                        //                                        $jumlahJamLatihan = 0;
                                        //
                                        //                                        while ($i <= ($dateDuration2 + 1) * 2) {
                                        //
                                        //                                            $slotLatihan = new SlotLatihan();
                                        //                                            $slotLatihan->siriLatihanID = $siriLatihan->siriLatihanID;
                                        //                                            $slotLatihan->slot = $i;
                                        //                                            $slotLatihan->mataSlot = 3;
                                        //
                                        //                                            if ($slotLatihan->save()) {
                                        //
                                        //                                                //var_dump($slotLatihan->slot);
                                        //
                                        //                                                $jumlahJamLatihan = $jumlahJamLatihan + 3;
                                        //                                                $siriLatihan->jumlahJamLatihan = $jumlahJamLatihan;
                                        //                                                $siriLatihan->jumlahMataIDP = $jumlahJamLatihan;
                                        //
                                        //                                                $siriLatihan->save(false);
                                        //
                                        //                                                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                                        //                                            } else {
                                        //                                                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                                        //                                            }
                                        //
                                        //                                            $i++;
                                        //                                        }
                                        /*** MCO ***/

                                        /********************************************************************/
                                        /**** new calculation for MCO only ****/

                                        $slotLatihan = new SlotLatihan();
                                        $slotLatihan->siriLatihanID = $siriLatihan->siriLatihanID;
                                        $slotLatihan->slot = 1;
                                        $slotLatihan->mataSlot = 6;

                                        if ($slotLatihan->save(false)) {

                                            $jumlahJamLatihan = 2;
                                            $siriLatihan->jumlahJamLatihan = $jumlahJamLatihan;
                                            $siriLatihan->jumlahMataIDP = 6;
                                            $siriLatihan->save(false);

                                            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                                        } else {
                                            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                                        }
                                    }
                                }
                            }
                        }

                        //$model->save();
                    }
                    $baseRow++;
                }
                Yii::$app->getSession()->setFlash('success', 'Success');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }

        return $this->render('import', [
            'modelImport' => $modelImport,
        ]);
    }

    public function actionTestqr()
    {
        //$qr = Yii::$app->get('qr');
        //        Yii::$app->response->format = Response::FORMAT_RAW;
        //        Yii::$app->response->headers->add('Content-Type', $qr->getContentType());
        //
        //        $qr
        //                ->setText('https://2amigos.us')
        //                ->setLabel('2amigos consulting group llc')
        //                ->writeString();

        return $this->render('testqr');
    }

    public function actionBorangsemakanpeserta($id, $slotID, $userLevel)
    {
        $program = PermohonanMataLatihan::find()
            ->where("siriLatihanID = $id")->one();

        $today = date("Y-m-d");
        $userID = Yii::$app->user->getId();



        if ($program->load(Yii::$app->request->post())) {

            $program->tarikhDisemak = $today;
            $program->disemakOleh = $userID;
            $program->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'warning', 'msg' => 'Berjaya!']);
            return $this->redirect(['index']); //redirect 'view-senarai-latihan' => URL not name of page i.e.
        }

        $query = SlotLatihanJfpiu::find()->where(['siriLatihanID' => $id])->indexBy('slotID');
        $dataProviderSlot = new ActiveDataProvider([
            'query' => $query,
        ]);

        $queryKehadiran = KehadiranJfpiu::find()->where(['slotID' => $slotID]);
        $dataProviderKehadiran = new ActiveDataProvider([
            'query' => $queryKehadiran,
        ]);

        // $hadir = KehadiranJfpiu::find()->where(['slotID' => $slotID])->all();

        // $peserta = array();
        // foreach ($hadir as $hadirr) {
        //     $peserta[] = $hadirr->staffID;
        // }

        // $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])
        //                         ->where(['NOT IN', 'ICNO', $peserta])->all(), 'ICNO', function($model) {
        //             $a = $model['CONm'] . ' - ' . $model->department->shortname;
        //             return $a;
        //         }, 'department.fullname'); //groupby

        $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', function ($model) {
            $a = $model['CONm'] . ' - ' . $model->department->shortname;
            return $a;
        }, 'department.fullname'); //groupby

        //        $dataProvider = new ActiveDataProvider([
        //            'query' => Tblprcobiodata::find()->where(['NOT IN','ICNO',$peserta])
        //                ->andWhere(['=','Status', 1]),
        //            'pagination' => ['pageSize' => 10,],
        //        ]);

        if (isset(Yii::$app->request->queryParams['namaStaf'])) {
            $dataProvider->query->andFilterWhere([
                'like', 'tblprcobiodata.CONm',
                Yii::$app->request->queryParams['namaStaf']
            ]);
        }

        if (isset(Yii::$app->request->queryParams['jabatan'])) {
            $dataProvider->query->andFilterWhere([
                '=', 'tblprcobiodata.DeptId',
                Yii::$app->request->queryParams['jabatan']
            ]);
        }

        if ((array) Yii::$app->request->post('selection') != NULL) {

            //echo "A";

            $selection = (array) Yii::$app->request->post('selection');
            //var_dump($selection);

            foreach ($selection as $selection) {

                //echo $selection;

                $today = date("Y-m-d H:i:s");

                $modelH = new KehadiranJfpiu();
                $modelH->slotID = $slotID;
                $modelH->staffID = $selection;
                $modelH->tarikhMasa = $today;
                $modelH->save(false);
            }

            if ($modelH->save(false)) {
                return $this->redirect(['borangsemakanpeserta?id=' . $id . '&slotID=' . $slotID . '&userLevel=urusetiaJfpiu']);
            }
        }



        //        $dataProviderProgram = new ActiveDataProvider([
        //            'query' => $program,
        //        ]);


        return $this->render('borangsemakanpeserta', [
            //'modelLatihan' => $modelLatihan,
            'dataProviderKehadiran' => $dataProviderKehadiran,
            'dataProviderSlot' => $dataProviderSlot,
            'allStaf' => $allStaf,
            'modelLatihan' => $this->findModelSiriLatihanJfpiu($id),
            'modelSlot' => SlotLatihanJfpiu::find()->where(['slotID' => $slotID])->one(),
            'id' => $id,
            'slotID' => $slotID,
            'program' => $program,
            'userLevel' => $userLevel,
        ]);
    }

    public function actionBorangpenilaiankeberkesanan($id, $pesertaID = null, $type)
    {

        if (!$pesertaID) {
            $userID = Yii::$app->user->getId();
        } else {
            $userID = $pesertaID;
        }
        $today = date('Y-m-d H:i:s');

        if ($type == '2') {

            $modelN = BorangPenilaianKeberkesanan::find()
                ->where(['pesertaID' => $userID])
                ->andWhere(['siriLatihanID' => $id])
                ->one();

            $kursusID = SiriLatihan::find()->where(['siriLatihanID' => $id])->one();

            $modelLatihan = $this->findModelLatihan($kursusID->kursusLatihanID);
        } else {

            $modelN = BorangPenilaianKeberkesananLama::find()
                ->where(['pesertaId' => $userID])
                ->andWhere(['kursusId' => $id])
                ->one();

            $modelLatihan = $this->findModelLatihanLama($id);
        }

        $modelSoalanN = SoalanPenilaianLatihan::find()
            ->where(['jenisSoalan' => 'N']);

        $modelSoalanM = SoalanPenilaianLatihan::find()
            ->where(['jenisSoalan' => 'M']);

        $dataProviderN = new ActiveDataProvider([
            'query' => $modelSoalanN,
            'pagination' => false,
        ]);

        $dataProviderM = new ActiveDataProvider([
            'query' => $modelSoalanM,
            'pagination' => false,
        ]);

        if ($modelN->load(Yii::$app->request->post())) {

            $modelN->statusBorang = 3;
            $modelN->tarikhKetuaIsi = $today;
            $modelN->ketuaID = Yii::$app->user->getId();
            $modelN->save();

            if ($modelN->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang Penilaian Kursus Enam Bulan berjaya dihantar.']);
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            }
        }

        if ($type == '2') {
            return $this->render('borangpenilaiankeberkesanan', [
                'modelN' => $modelN,
                'modelLatihan' => $modelLatihan,
                'modelSiri' => SiriLatihan::find()->where(['siriLatihanID' => $id])->one(),
                'dataProviderN' => $dataProviderN,
                'dataProviderM' => $dataProviderM,
                'model3' => Tblprcobiodata::find()->where(['ICNO' => $pesertaID])->one(),
                'model4' => new SetPegawai(),
                'model5' => SetPegawai::find()->where(['pemohon_icno' => $pesertaID])->one(),
            ]);
        } else {
            return $this->render('borangpenilaiankeberkesananlama', [
                'modelN' => $modelN,
                'modelLatihan' => $modelLatihan,
                'dataProviderN' => $dataProviderN,
                'dataProviderM' => $dataProviderM,
            ]);
        }
    }

    public function actionBorangpenilaianlatihan($id, $pesertaID = null, $type)
    {

        if (!$pesertaID) {
            $userID = Yii::$app->user->getId();
        } else {
            $userID = $pesertaID;
        }
        $today = date('Y-m-d H:i:s');

        if ($type == '2') {
            //$model = new BorangPenilaianLatihan();
            $modelL = BorangPenilaianLatihan::find()
                ->where(['pesertaID' => $userID])
                ->andWhere(['siriLatihanID' => $id])
                ->one();

            $modelN = BorangPenilaianKeberkesanan::find()
                ->where(['pesertaID' => $userID])
                ->andWhere(['siriLatihanID' => $id])
                ->one();

            $kursusID = SiriLatihan::find()->where(['siriLatihanID' => $id])->one();

            $modelLatihan = $this->findModelLatihan($kursusID->kursusLatihanID);
        } else {
            $modelL = BorangPenilaianLatihanLama::find()
                ->where(['pesertaId' => $userID])
                ->andWhere(['kursusId' => $id])
                ->one();

            $modelN = BorangPenilaianKeberkesananLama::find()
                ->where(['pesertaId' => $userID])
                ->andWhere(['kursusId' => $id])
                ->one();

            $modelLatihan = $this->findModelLatihanLama($id);
        }

        $modelSoalanA = SoalanPenilaianLatihan::find()
            ->where(['jenisSoalan' => 'A']);

        $modelSoalanB = SoalanPenilaianLatihan::find()
            ->where(['jenisSoalan' => 'B']);

        $modelSoalanC = SoalanPenilaianLatihan::find()
            ->where(['jenisSoalan' => 'C']);

        $modelSoalanD = SoalanPenilaianLatihan::find()
            ->where(['jenisSoalan' => 'D']);

        $modelSoalanK = SoalanPenilaianLatihan::find()
            ->where(['jenisSoalan' => 'K']);

        $modelSoalanN = SoalanPenilaianLatihan::find()
            ->where(['jenisSoalan' => 'N']);

        //$query = RefPenilaianDass21::find()->orderBy(['id' => SORT_ASC]);

        $dataProviderA = new ActiveDataProvider([
            'query' => $modelSoalanA,
            'pagination' => false,
        ]);

        $dataProviderB = new ActiveDataProvider([
            'query' => $modelSoalanB,
            'pagination' => false,
        ]);

        $dataProviderC = new ActiveDataProvider([
            'query' => $modelSoalanC,
            'pagination' => false,
        ]);

        $dataProviderD = new ActiveDataProvider([
            'query' => $modelSoalanD,
            'pagination' => false,
        ]);

        $dataProviderK = new ActiveDataProvider([
            'query' => $modelSoalanK,
            'pagination' => false,
        ]);

        $dataProviderN = new ActiveDataProvider([
            'query' => $modelSoalanN,
            'pagination' => false,
        ]);

        if ($modelL->load(Yii::$app->request->post()) && $modelN->load(Yii::$app->request->post())) {

            //            echo "<br>";
            //            var_dump($modelL);
            //            echo "<br>";

            $modelL->statusBorang = 2;
            $modelN->statusBorang = 2;
            $modelL->tarikhMasa = $today;
            $modelN->tarikhStafIsi = $today;

            $modelL->save();
            $modelN->save();

            if ($modelL->save() && $modelN->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang Penilaian Kursus berjaya dihantar.']);
                //return $this->redirect(['view-senarai-permohonan']);

                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$userID]);

                $mataaa = 0;

                $mata = SlotLatihan::find()
                    ->joinWith('sasaran55')
                    ->where(['siriLatihanID' => $id])
                    ->andWhere(['idp_kehadiran.staffID' => $userID])
                    ->all();

                foreach ($mata as $mataa) {
                    $mataaa = $mataaa + $mataa->mataSlot;
                }

                $checkTahunBorang = SiriLatihan::find()->where(['siriLatihanID' => $id])->one();
                $tahunBorang = date("Y", strtotime($checkTahunBorang->tarikhMula));

                $check = IdpMata::find()
                    ->where(['tahun' => $tahunBorang, 'staffID' => $userID])
                    ->one();

                $check2 = RptStatistikIdp::find()
                    ->where(['tahun' => $tahunBorang, 'icno' => $userID])
                    ->one();

                $matah = Kehadiran::find()
                    ->joinWith('sasaran9')
                    ->where(['siriLatihanID' => $id])
                    ->andWhere(['idp_kehadiran.staffID' => $userID])
                    ->one();

                if ($matah->kategoriKursusID == 1) {
                    $check->mataUmum = $check->mataUmum + $mataaa;
                    $check2->idp_mata_umum = $check2->idp_mata_umum + $mataaa;
                } elseif ($matah->kategoriKursusID == 3) {
                    $check->mataTeras = $check->mataTeras + $mataaa;
                    $check2->idp_mata_teras = $check2->idp_mata_teras + $mataaa;
                } elseif ($matah->kategoriKursusID == 4) {
                    $check->mataElektif = $check->mataElektif + $mataaa;
                    $check2->idp_mata_elektif = $check2->idp_mata_elektif + $mataaa;
                } elseif ($matah->kategoriKursusID == 5) {
                    $check->mataTerasUni = $check->mataTerasUni + $mataaa;
                    $check2->idp_mata_teras_uni = $check2->idp_mata_teras_uni + $mataaa;
                } elseif ($matah->kategoriKursusID == 6) {
                    $check->mataTerasSkim = $check->mataTerasSkim + $mataaa;
                    $check2->idp_mata_teras_skim = $check2->idp_mata_teras_skim + $mataaa;
                }

                $check->tarikhKemaskini = date('Y-m-d H:i:s');
                $check2->tarikh_kemaskini = date('Y-m-d H:i:s');

                $check->save(false);
                $check2->save(false);

                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            }
        }

        //        return $this->renderAjax('borangpenilaianlatihan', [
        //                    'modelL' => $modelL,
        //                    'modelN' => $modelN,
        //                    'modelLatihan' => $modelLatihan,
        //                    'dataProviderA' => $dataProviderA,
        //                    'dataProviderB' => $dataProviderB,
        //                    'dataProviderC' => $dataProviderC,
        //                    'dataProviderD' => $dataProviderD,
        //                    'dataProviderK' => $dataProviderK,
        //                    'dataProviderN' => $dataProviderN,
        //        ]);

        if ($type == '2') {
            return $this->render('borangpenilaianlatihan', [
                'modelL' => $modelL,
                'modelN' => $modelN,
                'modelLatihan' => $modelLatihan,
                'dataProviderA' => $dataProviderA,
                'dataProviderB' => $dataProviderB,
                'dataProviderC' => $dataProviderC,
                'dataProviderD' => $dataProviderD,
                'dataProviderK' => $dataProviderK,
                'dataProviderN' => $dataProviderN,
            ]);
        } else {
            return $this->render('borangpenilaianlatihanlama', [
                'modelL' => $modelL,
                'modelN' => $modelN,
                'modelLatihan' => $modelLatihan,
                'dataProviderA' => $dataProviderA,
                'dataProviderB' => $dataProviderB,
                'dataProviderC' => $dataProviderC,
                'dataProviderD' => $dataProviderD,
                'dataProviderK' => $dataProviderK,
                'dataProviderN' => $dataProviderN,
            ]);
        }
    }

    public function actionSemakanSuratKursusLuarAkademik()
    {

        $pentadbiran = PermohonanKursusLuar::find()
            ->joinWith('suratLulus')
            ->joinWith('biodata.jawatan')
            ->where(['job_category' => 1])
            ->andWhere(['statusPermohonan' => '10'])
            ->andWhere(['YEAR(tarikhPohon)' => date('Y')])
            ->orderBy([
                new \yii\db\Expression("statusPermohonan = '10' desc"),
                'tarikhMula' => SORT_DESC
            ]);

        $dataProviderKursusLuar2 = new ActiveDataProvider([
            'query' => $pentadbiran,
        ]);

        $searchModel = new PermohonanKursusLuarSearch_1();
        if (Yii::$app->request->queryParams) {
            $dataProviderKursusLuar2 = $searchModel->search(Yii::$app->request->queryParams);
            $dataProviderKursusLuar2->query->andFilterWhere(['job_category' => 1]);
        }

        return $this->render('semakan_surat_kursus_luar', [
            'dataProviderKursusLuar' => $dataProviderKursusLuar2,
            'type' => 'aka',
            'searchModel' => $searchModel,
        ]);
    }

    public function actionSemakanSuratKursusLuarPentadbiran()
    {

        $pentadbiran = PermohonanKursusLuar::find()
            ->joinWith('suratLulus')
            ->joinWith('biodata.jawatan')
            ->where(['job_category' => 2])
            ->andWhere(['statusPermohonan' => '10'])
            ->andWhere(['YEAR(tarikhPohon)' => date('Y')])
            ->orderBy([
                new \yii\db\Expression("statusPermohonan = '10' desc"),
                'tarikhMula' => SORT_DESC
            ]);

        $dataProviderKursusLuar2 = new ActiveDataProvider([
            'query' => $pentadbiran,
        ]);

        $searchModel = new PermohonanKursusLuarSearch_1();
        if (Yii::$app->request->queryParams) {
            $dataProviderKursusLuar2 = $searchModel->search(Yii::$app->request->queryParams);
            $dataProviderKursusLuar2->query->andFilterWhere(['job_category' => 2]);
        }

        return $this->render('semakan_surat_kursus_luar', [
            'dataProviderKursusLuar' => $dataProviderKursusLuar2,
            'type' => 'pen',
            'searchModel' => $searchModel,
        ]);
    }

    public function actionSemakanKursusLuarPentadbiran()
    {

        $userID = Yii::$app->user->getId();

        $findUser = UserAccess::find()->where(['userID' => $userID])->one();

        if ($findUser->usertype == 'ul') {

            $pentadbiran = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 2])
                ->orderBy([
                    new \yii\db\Expression("statusPermohonan = '4' desc"),
                    'tarikhMula' => SORT_DESC
                ]);
        } elseif ($findUser->usertype == 'pegawaiLatihan') {

            $pentadbiran = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 2, 'statusUL' => '6'])
                ->orderBy([
                    new \yii\db\Expression("statusPermohonan = '6' desc"),
                    'tarikhMula' => SORT_DESC
                ]);
        } elseif ($findUser->usertype == 'ketuaSektor') {

            $pentadbiran = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 2, 'statusBSM' => '8'])
                ->orWhere(['job_category' => 2, 'statusBSM' => '7'])
                ->orderBy([
                    new \yii\db\Expression("statusPermohonan = '8' desc"),
                    new \yii\db\Expression("statusPermohonan = '7' desc"),
                    'tarikhMula' => SORT_DESC
                ]);
        } else {

            Yii::$app->session->setFlash('alert', ['title' => 'Ralat', 'type' => 'info', 'msg' => 'Harap maaf. Anda tiada akses ke halaman ini.', 'theme' => 'twitter']);
            return $this->redirect(Yii::$app->request->referrer);
        }

        $dataProviderKursusLuar2 = new ActiveDataProvider([
            'query' => $pentadbiran,
        ]);

        $searchModel = new PermohonanKursusLuarSearch();
        if (Yii::$app->request->queryParams) {
            $dataProviderKursusLuar2 = $searchModel->search(Yii::$app->request->queryParams);
            $dataProviderKursusLuar2->query->andFilterWhere(['job_category' => 2]);
        }

        return $this->render('view_senarai_kursus_luar', [
            'dataProviderKursusLuar' => $dataProviderKursusLuar2,
            'type' => 'pen',
            'searchModel' => $searchModel,
        ]);
    }

    public function actionSemakanKursusLuarAkademik()
    {

        $userID = Yii::$app->user->getId();

        $findUser = UserAccess::find()->where(['userID' => $userID])->one();

        if ($findUser->usertype == 'ul') {

            $akademik = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 1])
                ->orderBy([
                    new \yii\db\Expression("statusPermohonan = '4' desc"),
                    'tarikhMula' => SORT_DESC
                ]);
        } elseif ($findUser->usertype == 'pegawaiLatihan') {

            $akademik = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 1, 'statusUL' => '6'])
                ->orderBy([
                    new \yii\db\Expression("statusPermohonan = '6' desc"),
                    'tarikhMula' => SORT_DESC
                ]);
        } elseif ($findUser->usertype == 'ketuaSektor') {

            $akademik = PermohonanKursusLuar::find()
                ->joinWith('biodata.jawatan')
                ->where(['job_category' => 1, 'statusBSM' => '8'])
                ->orWhere(['job_category' => 1, 'statusBSM' => '7'])
                ->orderBy([
                    new \yii\db\Expression("statusPermohonan = '8' desc"),
                    new \yii\db\Expression("statusPermohonan = '7' desc"),
                    'tarikhMula' => SORT_DESC
                ]);
        } else {

            Yii::$app->session->setFlash('alert', ['title' => 'Ralat', 'type' => 'info', 'msg' => 'Harap maaf. Anda tiada akses ke halaman ini.', 'theme' => 'twitter']);
            return $this->redirect(Yii::$app->request->referrer);
        }

        $dataProviderKursusLuar = new ActiveDataProvider([
            'query' => $akademik,
        ]);

        $searchModel = new PermohonanKursusLuarSearch();
        if (Yii::$app->request->queryParams) {
            $dataProviderKursusLuar = $searchModel->search(Yii::$app->request->queryParams);
            $dataProviderKursusLuar->query->andFilterWhere(['job_category' => 1]);
        }

        return $this->render('view_senarai_kursus_luar', [
            'dataProviderKursusLuar' => $dataProviderKursusLuar,
            'type' => 'aka',
            'searchModel' => $searchModel,
            'akademik' => $akademik
        ]);
    }

    public function actionSemakPermohonanIdp()
    {
        $userID = Yii::$app->user->getId();

        /*         * ***************** test ******************************************* */

        $baruList = PermohonanMataIdpIndividu::find()
            ->where(['statusPermohonan' => 'BARU'])->all();

        $test = SetPegawai::find()->where(['peraku_icno' => $userID])->all();

        $senaraiPemohon = [];
        foreach ($baruList as $baruListt) {
            foreach ($test as $test2) {
                if ($test2->pemohon_icno == $baruListt->staffID) {
                    array_push($senaraiPemohon, $baruListt->staffID);
                }
            }
        }

        $senaraiPemohon2 = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'BARU'])
            ->andWhere(['staffID' => $senaraiPemohon]);


        $dataProvider = new ActiveDataProvider([
            'query' => $senaraiPemohon2,
        ]);

        //        $dataProvider = new ActiveDataProvider([
        //            'query' => $baruList,
        //        ]);

        /*         * ***************** /test ******************************************* */

        $baruListKursusLuar = PermohonanKursusLuar::find()
            ->joinWith('biodata.department')
            ->where(['chief' => $userID])
            ->andWhere(['<>', 'statusPermohonan', '2']);

        $dataProviderKursusLuar = new ActiveDataProvider([
            'query' => $baruListKursusLuar,
        ]);

        //        $diperakuList = PermohonanLatihan::find()
        //                ->joinWith('sasaran2')
        //                ->where(['statusPermohonan' => 'DIPERAKUI'])
        //                ->andWhere(['set_pegawai.peraku_icno' => $userID]);
        //
        //        $dataProviderA = new ActiveDataProvider([
        //            'query' => $diperakuList,
        //        ]);

        /*         * ***************** test ******************************************* */

        $diperakuListTest = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'DIPERAKUI'])->all();

        $test3 = SetPegawai::find()->where(['peraku_icno' => $userID])->all();

        $senaraiPemohon3 = [];
        foreach ($diperakuListTest as $diperakuListTestt) {
            foreach ($test3 as $test33) {
                if ($test33->pemohon_icno == $diperakuListTestt->staffID) {
                    array_push($senaraiPemohon3, $diperakuListTestt->staffID);
                }
            }
        }

        $senaraiPemohon4 = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'DIPERAKUI'])
            ->andWhere(['staffID' => $senaraiPemohon3]);

        //        var_dump($senaraiPemohon);
        //        die();

        $dataProviderA = new ActiveDataProvider([
            'query' => $senaraiPemohon4,
        ]);

        /*         * ***************** /test ******************************************* */

        //        $dilulusList = PermohonanLatihan::find()
        //                ->joinWith('sasaran2')
        //                ->where(['statusPermohonan' => 'DILULUSKAN'])
        //                ->andWhere(['set_pegawai.peraku_icno' => $userID]);
        //
        //        $dataProviderB = new ActiveDataProvider([
        //            'query' => $dilulusList,
        //        ]);

        /*         * ***************** test ******************************************* */

        $dilulusList = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'DILULUSKAN'])->all();

        $test4 = SetPegawai::find()->where(['peraku_icno' => $userID])->all();

        $senaraiPemohon5 = [];
        foreach ($dilulusList as $dilulusListt) {
            foreach ($test4 as $test44) {
                if ($test44->pemohon_icno == $dilulusListt->staffID) {
                    array_push($senaraiPemohon5, $dilulusListt->staffID);
                }
            }
        }

        $senaraiPemohon6 = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'DILULUSKAN'])
            ->andWhere(['staffID' => $senaraiPemohon5]);

        $dataProviderB = new ActiveDataProvider([
            'query' => $senaraiPemohon6,
        ]);

        /*         * ***************** /test ******************************************* */

        return $this->render('view_senarai_diperaku', [
            'baruListKursusLuar' => $baruListKursusLuar,
            'dataProvider' => $dataProvider,
            'dataProviderA' => $dataProviderA,
            'dataProviderB' => $dataProviderB,
            'dataProviderKursusLuar' => $dataProviderKursusLuar,
        ]);
    }

    public function actionPengesahan()
    {
        $userID = Yii::$app->user->getId();

        //        $baruList = PermohonanMataIdpIndividu::find()
        //                ->joinWith('biodata.department')
        //                ->where(['chief' => $userID, 'statusPermohonan' => '1'])
        //                ->orWhere(['chief' => $userID, 'statusPermohonan' => '9'])
        //                ->orWhere(['department.pp' => $userID, 'statusPermohonan' => '9']);

        $baruList = PermohonanMataIdpIndividu::find()
            ->where(['YEAR(tarikhPohon)' => date('Y')])
            ->all();

        $test = Department::find()
            ->where(['chief' => $userID])
            ->orWhere(['pp' => $userID, 'id' => '164']) //HUMS
            ->all();

        //        $testx = Department::find()
        //                ->where(['pp' => $userID])
        //                ->all();

        $nc = Tblprcobiodata::find()
            ->joinWith('jawatan')
            ->where(['id' => '2', 'Status' => '1', 'ICNO' => $userID])
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

            //            if ($testx){
            //                foreach ($testx as $test2) {
            //                    if ($modelB->DeptId == $test2->id) {
            //                        array_push($senaraiPemohonx, $baruListt->pemohonID);
            //                    }
            //                }
            //            }

            //            if ($nc){
            //                foreach ($nc as $ncc) {
            //                    if ($modelB->statusPermohonan == '170') {
            //                        array_push($senaraiPemohonz, $baruListt->pemohonID);
            //                    }
            //                }
            //            }


        }

        if ($test) {

            $senaraiPemohon2 = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '1', 'pemohonID' => $senaraiPemohon, 'YEAR(tarikhPohon)' => date('Y')])
                ->orWhere(['statusPermohonan' => '9', 'pemohonID' => $senaraiPemohon, 'YEAR(tarikhPohon)' => date('Y')]);
        }

        //        if ($testx){
        //            $senaraiPemohon2 = PermohonanMataIdpIndividu::find()
        //                    ->where(['statusPermohonan' => '9', 'pemohonID' => $senaraiPemohonx]);
        //        }

        if ($nc) {
            $senaraiPemohon2 = PermohonanMataIdpIndividu::find()
                ->where(['statusPermohonan' => '17', 'YEAR(tarikhPohon)' => date('Y')]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $senaraiPemohon2,
        ]);

        $dataProvider->pagination->pageSize = 5;

        //        $sahList = PermohonanMataIdpIndividu::find()
        //                ->joinWith('biodata.department')
        //                ->where(['chief' => $userID, 'statusKJ' => '2'])
        //                ->orWhere(['department.pp' => $userID, 'statusKJ' => '2']);
        //
        //        $dataProviderSah = new ActiveDataProvider([
        //            'query' => $sahList,
        //        ]);

        //        if ($testx){
        //        
        //        $sahList = PermohonanMataIdpIndividu::find()
        //                ->where(['kjPenyemak' => $userID, 'pemohonID' => $senaraiPemohonx]);
        //        
        //        }

        if ($test) {

            $sahList = PermohonanMataIdpIndividu::find()
                ->where(['kjPenyemak' => $userID, 'pemohonID' => $senaraiPemohon, 'YEAR(tarikhPohon)' => date('Y')]);
        }

        if ($nc) {

            $sahList = PermohonanMataIdpIndividu::find()
                ->where(['kjPenyemak' => $userID, 'YEAR(tarikhPohon)' => date('Y')]);
        }

        $dataProviderSah = new ActiveDataProvider([
            'query' => $sahList,
        ]);

        $dataProviderSah->pagination->pageSize = 5;

        if ((array) Yii::$app->request->get('momo')) {

            $selection = (array) Yii::$app->request->get('momo');

            foreach ($selection as $permohonanID) {

                $model = $this->findModelPermohonanMataIdpIndividu($permohonanID);
                $today = date('Y-m-d');

                $model->statusKJ = '2';
                $model->statusPermohonan = '2';
                $model->tarikhSemakanKJ = $today;
                $model->kjPenyemak = $userID;

                if ($model->save(false)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Permohonan telah disahkan!']);
                    $this->notifikasi($model->pemohonID, "Permohonan mata IDP anda telah disahkan. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan-individu'], ['class' => 'btn btn-success btn-sm']));
                }
            }
        }

        return $this->render('semakan_senarai_permohonan_individu', [
            'dataProvider' => $dataProvider,
            'dataProviderSah' => $dataProviderSah,
            'senaraiPemohon2' => $senaraiPemohon2
        ]);
    }

    public function actionTindakanPengesahan($permohonanID)
    {

        $model = $this->findModelPermohonanMataIdpIndividu($permohonanID);
        $today = date('Y-m-d');

        $model2 = Peserta::find()->where(['permohonanID' => $permohonanID]);
        $dataProvider = new ActiveDataProvider([
            'query' => $model2,
        ]);

        if ($model->load(Yii::$app->request->post())) {
            $model->statusKJ = '2';
            $model->statusPermohonan = '2';
            $model->tarikhSemakanKJ = $today;
            $model->kjPenyemak = Yii::$app->user->getId();

            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Permohonan telah disahkan!']);
                $this->notifikasi($model->pemohonID, "Permohonan mata IDP anda telah disahkan. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan-individu'], ['class' => 'btn btn-success btn-sm']));

                $modelS = UrusetiaLatihan::find()->where(['ul_type' => 'ketuaUrusetia'])->one();

                if ($modelS) {
                    $this->notifikasi($modelS->userID, "Permohonan mata IDP " . strtoupper($model->biodata->CONm) . " menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/tindakan-semakan-ul?permohonanID=' . $permohonanID], ['class' => 'btn btn-danger btn-sm']));
                }
            }

            return $this->redirect(['idp/tindakan-pengesahan?permohonanID=' . $permohonanID]);
        }

        return $this->render('tindakan_pengesahan', [
            'model' => $model,
            'model2' => $model2,
            'dataProvider' => $dataProvider,

        ]);
    }

    public function actionSemakanBsm()
    {

        $sahList = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata.jawatan')
            ->where(['statusPermohonan' => '2', 'job_category' => 2])
            ->andWhere(['YEAR(tarikhPohon)' => date('Y')])
            ->orderBy(['tarikhPohon' => SORT_ASC]);

        $dataProviderSah = new ActiveDataProvider([
            'query' => $sahList,
        ]);

        $searchModel = new PermohonanMataIdpSearch();
        if (Yii::$app->request->queryParams) {
            $dataProviderSah = $searchModel->search(Yii::$app->request->queryParams);
            $dataProviderSah->query->andFilterWhere(['statusPermohonan' => '2', 'job_category' => 2, 'YEAR(tarikhPohon)' => date('Y')]);
        }

        $dataProviderSah->pagination->pageSize = 5;

        $semakList = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata.jawatan')
            ->where(['statusUL' => '1', 'job_category' => 2])
            ->andWhere(['YEAR(tarikhPohon)' => date('Y')])
            ->orderBy(['tarikhPohon' => SORT_ASC]);

        $dataProviderSemak = new ActiveDataProvider([
            'query' => $semakList,
        ]);

        $searchModelSemak = new PermohonanMataIdpSearch();
        if (Yii::$app->request->queryParams) {
            $dataProviderSemak = $searchModelSemak->search(Yii::$app->request->queryParams);
            $dataProviderSemak->query->andFilterWhere(['statusUL' => '1', 'job_category' => 2, 'YEAR(tarikhPohon)' => date('Y')]);
        }

        $dataProviderSemak->pagination->pageSize = 5;

        $batalList = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata.jawatan')
            ->where(['statusPermohonan' => '11', 'job_category' => 2])
            ->andWhere(['YEAR(tarikhPohon)' => date('Y')])
            ->orderBy(['tarikhPohon' => SORT_ASC]);

        $dataProviderBatal = new ActiveDataProvider([
            'query' => $batalList,
        ]);

        $searchModelBatal = new PermohonanMataIdpSearch();
        if (Yii::$app->request->queryParams) {
            $dataProviderBatal = $searchModelBatal->search(Yii::$app->request->queryParams);
            $dataProviderBatal->query->andFilterWhere(['statusPermohonan' => '11', 'job_category' => 2, 'YEAR(tarikhPohon)' => date('Y')]);
        }

        $dataProviderBatal->pagination->pageSize = 5;

        return $this->render('semakan_senarai_permohonan_individu_ul', [
            'dataProviderSah' => $dataProviderSah,
            'dataProviderSemak' => $dataProviderSemak,
            'dataProviderBatal' => $dataProviderBatal,
            'searchModel' => $searchModel,
            'searchModelSemak' => $searchModelSemak,
            'searchModelBatal' => $searchModelBatal,
            'type' => '2',
        ]);
    }

    public function actionSemakanBsmm()
    {
        // $sahList = PermohonanMataIdpIndividu::find()
        //         ->joinWith('biodata.jawatan')
        //         ->where(['=', 'statusPermohonan', '2'])
        //         ->andWhere(['job_category' => 1])
        //         ->andWhere(['YEAR(tarikhPohon)' => date('Y')]);

        $sahList = PermohonanMataIdpIndividu::find()
            ->where(['=', 'statusPermohonan', '2'])
            ->andWhere(['YEAR(tarikhPohon)' => date('Y')])
            ->all();

        $senarai = [];
        foreach ($sahList as $sahList) {

            if ($sahList->biodata) {
                if ($sahList->biodata->jawatan->job_category == 1) {
                    array_push($senarai, $sahList->pemohonID);
                }
            }
        }

        $sahList2 = PermohonanMataIdpIndividu::find()
            ->where(['=', 'statusPermohonan', '2'])
            ->andWhere(['YEAR(tarikhPohon)' => date('Y')])
            ->andWhere(['pemohonID' => $senarai]);

        $dataProviderSah = new ActiveDataProvider([
            'query' => $sahList2,
        ]);

        $searchModel = new PermohonanMataIdpSearch();
        if (Yii::$app->request->queryParams) {
            $dataProviderSah = $searchModel->search(Yii::$app->request->queryParams);
            $dataProviderSah->query->andFilterWhere(['statusPermohonan' => '2', 'job_category' => 1, 'YEAR(tarikhPohon)' => date('Y')]);
        }

        $dataProviderSah->pagination->pageSize = 5;

        $semakList = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata.jawatan')
            ->where(['=', 'statusUL', '1'])
            ->andWhere(['job_category' => 1])
            ->andWhere(['YEAR(tarikhPohon)' => date('Y')]);;

        $dataProviderSemak = new ActiveDataProvider([
            'query' => $semakList,
        ]);

        $searchModelSemak = new PermohonanMataIdpSearch();
        if (Yii::$app->request->queryParams) {
            $dataProviderSemak = $searchModelSemak->search(Yii::$app->request->queryParams);
            $dataProviderSemak->query->andFilterWhere(['statusUL' => '1', 'job_category' => 1, 'YEAR(tarikhPohon)' => date('Y')]);
        }

        $dataProviderSemak->pagination->pageSize = 5;

        $batalList = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata.jawatan')
            ->where(['statusPermohonan' => '11'])
            ->andWhere(['job_category' => 1])
            ->andWhere(['YEAR(tarikhPohon)' => date('Y')]);

        $dataProviderBatal = new ActiveDataProvider([
            'query' => $batalList,
        ]);

        $searchModelBatal = new PermohonanMataIdpSearch();
        if (Yii::$app->request->queryParams) {
            $dataProviderBatal = $searchModelBatal->search(Yii::$app->request->queryParams);
            $dataProviderBatal->query->andFilterWhere(['statusPermohonan' => '11', 'job_category' => 1, 'YEAR(tarikhPohon)' => date('Y')]);
        }

        $dataProviderBatal->pagination->pageSize = 5;

        return $this->render('semakan_senarai_permohonan_individu_ul', [
            'dataProviderSah' => $dataProviderSah,
            'dataProviderSemak' => $dataProviderSemak,
            'dataProviderBatal' => $dataProviderBatal,
            'searchModel' => $searchModel,
            'searchModelSemak' => $searchModelSemak,
            'searchModelBatal' => $searchModelBatal,
            'type' => '1',
        ]);
    }

    public function actionTindakanSemakanUl($permohonanID)
    {

        $model = $this->findModelPermohonanMataIdpIndividu($permohonanID);
        $today = date('Y-m-d');

        $model2 = Peserta::find()->where(['permohonanID' => $permohonanID]);
        $dataProvider = new ActiveDataProvider([
            'query' => $model2,
            'pagination' => false,
        ]);

        if (Yii::$app->request->post()) {

            foreach ($model2->all() as $m) {

                $model3 = Peserta::find()
                    ->where(['permohonanID' => $permohonanID, 'staffID' => $m->staffID])
                    ->one();

                $model3->jumlahJamHadir = Yii::$app->request->post($m->staffID);
                $model3->statusUL = '1';
                if ($model3->save(false)) {

                    $model->statusUL = '1';
                    $model->statusPermohonan = '3';
                    $model->tarikhSemakanUL = date('Y-m-d');
                    $model->adminUL = Yii::$app->user->getId();
                    $model->save(false);
                }

                /** error */
                // if ($model->save(false) && ($m === end($model2->all())) ) {
                //     // Last item
                //     Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya ubah!']);
                //     $modelS = UrusetiaLatihan::find()->where(['ul_type' => 'ketuaUrusetia'])->one();

                //     if ($modelS){
                //         $this->notifikasi($modelS->userID, "Permohonan mata IDP ".strtoupper($model->biodata->CONm)." menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/tindakan-semakan-ul?permohonanID='.$permohonanID], ['class' => 'btn btn-danger btn-sm']));
                //     }
                // }


            }
        }

        return $this->render('tindakan_semakan_ul', [
            'model' => $model,
            'model2' => $model2,
            'dataProvider' => $dataProvider,
            'pID' => $permohonanID,
        ]);
    }

    public function actionPengesahanBsmJfpiu()
    {

        $sahList = PermohonanMataIdpIndividu::find()
            ->where(['statusPermohonan' => '3', 'jenisPermohonan' => '2'])
            ->orWhere(['statusPermohonan' => '33', 'jenisPermohonan' => '2'])
            ->orderBy(['tarikhPohon' => SORT_ASC]);

        $dataProviderSah = new ActiveDataProvider([
            'query' => $sahList,
        ]);

        $semakList = PermohonanMataIdpIndividu::find()
            ->where(['statusBSM' => '4', 'jenisPermohonan' => '2'])
            ->orderBy(['tarikhPohon' => SORT_ASC]);

        $dataProviderSemak = new ActiveDataProvider([
            'query' => $semakList,
        ]);

        return $this->render('semakan_senarai_permohonan_individu_bsm', [
            'dataProviderSah' => $dataProviderSah,
            'dataProviderSemak' => $dataProviderSemak,
        ]);
    }

    public function actionPengesahanBsmAkademik()
    {

        //        $sahList = PermohonanMataIdpIndividu::find()
        //                    ->where(['=', 'statusPermohonan', '3'])
        //                    ->orWhere(['=', 'statusPermohonan', '33'])
        //                    ->all();
        //                            
        //        $senarai = [];
        //        foreach ($sahList as $sahListt) {
        //            if ($sahListt->biodata->jawatan->job_category == 1) {
        //                    array_push($senarai, $sahListt->pemohonID);
        //            }
        //        }
        //        
        //        $sahList2 = PermohonanMataIdpIndividu::find()
        //                ->where(['statusPermohonan' => '3', 'pemohonID' => $senarai])
        //                ->orWhere(['statusPermohonan' => '33', 'pemohonID' => $senarai])
        //                ->orderBy(['tarikhPohon' => SORT_ASC]);
        //
        //        $dataProviderSah = new ActiveDataProvider([
        //            'query' => $sahList2,
        //        ]);

        $sahList = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata.jawatan')
            ->where(['statusPermohonan' => '3', 'job_category' => 1, 'YEAR(tarikhPohon)' => date('Y')])
            ->orWhere(['statusPermohonan' => '33', 'job_category' => 1, 'YEAR(tarikhPohon)' => date('Y')])
            ->orWhere(['statusPermohonan' => '2', 'job_category' => 1, 'YEAR(tarikhPohon)' => date('Y')])
            ->orderBy(['tarikhPohon' => SORT_ASC]);

        $dataProviderSah = new ActiveDataProvider([
            'query' => $sahList,
        ]);

        $searchModel = new PermohonanMataIdpSearch();
        if (Yii::$app->request->queryParams) {
            $dataProviderSah = $searchModel->search(Yii::$app->request->queryParams);
            $dataProviderSah->query->andFilterWhere(['statusPermohonan' => '3', 'job_category' => 1]);
            $dataProviderSah->query->orFilterWhere(['statusPermohonan' => '33', 'job_category' => 1]);
            $dataProviderSah->query->orFilterWhere(['statusPermohonan' => '2', 'job_category' => 1]);
        }

        $dataProviderSah->pagination->pageSize = 5;

        //        $semakList = PermohonanMataIdpIndividu::find()
        //                ->where(['=', 'statusBSM', '4'])
        //                ->all();
        //        
        //        $senarai2 = [];
        //        foreach ($semakList as $semakList) {
        //            if ($semakList->biodata->jawatan->job_category == 1) {
        //                    array_push($senarai2, $semakList->pemohonID);
        //            }
        //        }
        //        
        //        $semakList2 = PermohonanMataIdpIndividu::find()
        //                ->where(['statusBSM' => '4', 'pemohonID' => $senarai2])
        //                ->orderBy(['tarikhPohon' => SORT_ASC]);
        //
        //        $dataProviderSemak = new ActiveDataProvider([
        //            'query' => $semakList2,
        //        ]);

        $semakList = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata.jawatan')
            ->where(['statusBSM' => '4', 'job_category' => 1])
            ->andWhere(['YEAR(tarikhPohon)' => date('Y')])
            ->orderBy(['tarikhPohon' => SORT_ASC]);

        $dataProviderSemak = new ActiveDataProvider([
            'query' => $semakList,
        ]);

        $searchModelSemak = new PermohonanMataIdpSearch();
        if (Yii::$app->request->queryParams) {
            $dataProviderSemak = $searchModelSemak->search(Yii::$app->request->queryParams);
            $dataProviderSemak->query->andFilterWhere(['statusBSM' => '4', 'job_category' => 1]);
        }

        $dataProviderSemak->pagination->pageSize = 5;

        return $this->render('semakan_senarai_permohonan_individu_bsm', [
            'dataProviderSah' => $dataProviderSah,
            'dataProviderSemak' => $dataProviderSemak,
            'searchModel' => $searchModel,
            'searchModelSemak' => $searchModelSemak,
            'type' => '1',
        ]);
    }

    public function actionPengesahanBsm()
    {

        //        $sahList = PermohonanMataIdpIndividu::find()
        //                    ->where(['=', 'statusPermohonan', '3'])
        //                    ->orWhere(['=', 'statusPermohonan', '33'])
        //                    ->orderBy(['tarikhPohon' => SORT_ASC]);
        //
        //        $dataProviderSah = new ActiveDataProvider([
        //            'query' => $sahList,
        //        ]);
        //
        //        $semakList = PermohonanMataIdpIndividu::find()
        //                ->where(['=', 'statusBSM', '4']);
        //
        //        $dataProviderSemak = new ActiveDataProvider([
        //            'query' => $semakList,
        //        ]);
        //
        //        return $this->render('semakan_senarai_permohonan_individu_bsm', [
        //                    'dataProviderSah' => $dataProviderSah,
        //                    'dataProviderSemak' => $dataProviderSemak,
        //        ]);

        //        $sahList = PermohonanMataIdpIndividu::find()
        //                    ->where(['=', 'statusPermohonan', '3'])
        //                    ->orWhere(['=', 'statusPermohonan', '33'])
        //                    ->all();
        //                            
        //        $senarai = [];
        //        foreach ($sahList as $sahListt) {
        //            if ($sahListt->biodata->jawatan->job_category == 2) {
        //                    array_push($senarai, $sahListt->pemohonID);
        //            }
        //        }
        //        
        //        $sahList2 = PermohonanMataIdpIndividu::find()
        //                ->where(['statusPermohonan' => '3', 'pemohonID' => $senarai])
        //                ->orWhere(['statusPermohonan' => '33', 'pemohonID' => $senarai])
        //                ->orderBy(['tarikhPohon' => SORT_ASC]);
        //
        //        $dataProviderSah = new ActiveDataProvider([
        //            'query' => $sahList2,
        //        ]);

        //        $searchModel = new PermohonanMataIdpSearch();
        //        
        //        $dataProviderSah = $searchModel->search(Yii::$app->request->queryParams);
        //        $dataProviderSah->query->andFilterWhere(['statusPermohonan' => '3', 'job_category' => 2]);
        //               
        //        $sahList = PermohonanMataIdpIndividu::find()
        //                ->joinWith('biodata.jawatan')
        //                ->where(['statusPermohonan' => '3', 'job_category' => 2])
        //                ->orWhere(['statusPermohonan' => '33', 'job_category' => 2])
        //                ->all();
        //        
        //        $senarai = [];
        //        foreach ($sahList as $a){
        //            $data = [$a->pemohonID => $a->biodata->CONm];
        //            array_push($senarai, $data);
        //        }

        //        $dataProviderSah->pagination->pageSize = 20;

        // $sahList = PermohonanMataIdpIndividu::find()
        //     ->joinWith('biodata.jawatan')
        //     ->where(['statusPermohonan' => '3', 'job_category' => 2])
        //     ->orWhere(['statusPermohonan' => '33', 'job_category' => 2]);

        $sahList = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata.jawatan')
            ->where(['statusPermohonan' => '3', 'job_category' => 2, 'YEAR(tarikhPohon)' => date('Y')])
            ->orWhere(['statusPermohonan' => '33', 'job_category' => 2, 'YEAR(tarikhPohon)' => date('Y')])
            ->orWhere(['statusPermohonan' => '2', 'job_category' => 2, 'YEAR(tarikhPohon)' => date('Y')])
            ->orderBy(['tarikhPohon' => SORT_ASC]);

        $dataProviderSah = new ActiveDataProvider([
            'query' => $sahList,
        ]);

        // $searchModel = new PermohonanMataIdpSearch();
        // if (Yii::$app->request->queryParams) {
        //     $dataProviderSah = $searchModel->search(Yii::$app->request->queryParams);
        //     $dataProviderSah->query->andFilterWhere(['statusPermohonan' => '3', 'job_category' => 2]);
        //     $dataProviderSah->query->orFilterWhere(['statusPermohonan' => '33', 'job_category' => 2]);
        // }

        $searchModel = new PermohonanMataIdpSearch();
        if (Yii::$app->request->queryParams) {
            $dataProviderSah = $searchModel->search(Yii::$app->request->queryParams);
            $dataProviderSah->query->andFilterWhere(['statusPermohonan' => '3', 'job_category' => 2]);
            $dataProviderSah->query->orFilterWhere(['statusPermohonan' => '33', 'job_category' => 2]);
            $dataProviderSah->query->orFilterWhere(['statusPermohonan' => '2', 'job_category' => 2]);
        }

        $dataProviderSah->pagination->pageSize = 5;

        //        $semakList = PermohonanMataIdpIndividu::find()
        //                ->where(['=', 'statusBSM', '4'])
        //                ->all();
        //        
        //        $senarai2 = [];
        //        foreach ($semakList as $semakList) {
        //            if ($semakList->biodata->jawatan->job_category == 2) {
        //                    array_push($senarai2, $semakList->pemohonID);
        //            }
        //        }
        //        
        //        $semakList2 = PermohonanMataIdpIndividu::find()
        //                ->where(['statusBSM' => '4', 'pemohonID' => $senarai2])
        //                ->orderBy(['tarikhPohon' => SORT_ASC]);
        //
        //        $dataProviderSemak = new ActiveDataProvider([
        //            'query' => $semakList2,
        //        ]);

        $semakList = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata.jawatan')
            ->where(['statusBSM' => '4', 'job_category' => 2])
            ->andWhere(['YEAR(tarikhPohon)' => date('Y')])
            ->orderBy(['tarikhPohon' => SORT_ASC]);

        $dataProviderSemak = new ActiveDataProvider([
            'query' => $semakList,
        ]);

        $searchModelSemak = new PermohonanMataIdpSearch();
        if (Yii::$app->request->queryParams) {
            $dataProviderSemak = $searchModelSemak->search(Yii::$app->request->queryParams);
            $dataProviderSemak->query->andFilterWhere(['statusBSM' => '4', 'job_category' => 2]);
        }

        $dataProviderSemak->pagination->pageSize = 5;

        return $this->render('semakan_senarai_permohonan_individu_bsm', [
            'dataProviderSah' => $dataProviderSah,
            'dataProviderSemak' => $dataProviderSemak,
            'searchModel' => $searchModel,
            'searchModelSemak' => $searchModelSemak,
            'type' => '2',
        ]);
    }

    public function actionTindakanPengesahanBsm($permohonanID)
    {

        $model = $this->findModelPermohonanMataIdpIndividu($permohonanID);
        $today = date('Y-m-d');

        $model2 = Peserta::find()->where(['permohonanID' => $permohonanID]);
        $dataProvider = new ActiveDataProvider([
            'query' => $model2,
            'pagination' => false,
        ]);

        $searchModel = new PesertaSearch();
        if (Yii::$app->request->queryParams) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        $dataProvider->pagination->pageSize = 0;

        if (Yii::$app->request->post()) {

            //            switch (\Yii::$app->request->post('submit')) {
            //                case 'submit_1':
            //                    echo "3";
            //                    die();
            //                      }

            if (Yii::$app->request->post('submit') == 1) {

                if ((array) Yii::$app->request->post('momo')) {

                    $selection = (array) Yii::$app->request->post('momo');

                    foreach ($selection as $selectionn) {

                        //                    var_dump($selectionn);
                        //                    die();

                        $model3 = Peserta::find()
                            ->where(['permohonanID' => $permohonanID, 'staffID' => $selectionn])
                            ->one();

                        $model3->mataIDPcadangan = Yii::$app->request->post('cadanganMata');
                        $model3->statusPL = '2';
                        $model3->status = 2;

                        if ($model3->biodata->jawatan->job_category == '1') {
                            $model3->kategoriKursusID = Yii::$app->request->post('momok');
                        } elseif ($model3->biodata->jawatan->job_category == '2') {
                            $model3->kategoriKursusID = Yii::$app->request->post('momokk');
                        }

                        if ($model3->save(false)) {
                            Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya ubah']);
                        }
                    }
                    return $this->redirect(['idp/tindakan-pengesahan-bsm?permohonanID=' . $permohonanID]);
                }
            }

            if (Yii::$app->request->post('submit') == 0) {
                //if ($model->load(Yii::$app->request->post())) {

                $model->statusBSM = '4';
                $model->statusPermohonan = '4';
                $model->tarikhSemakanBSM = $today;
                $model->disemakOleh = Yii::$app->user->getId();

                if ($model->save(false)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Permohonan telah disemak!']);

                    //                $modelS = UserAccess::find()->where(['userType' => 'ketuaSektor'])->one();
                    //
                    //                $this->notifikasi($modelS->userID, "Permohonan mata IDP staf menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/kelulusan-bsm'], ['class' => 'btn btn-success btn-sm']));

                    /** old
                $model3 = Peserta::find()
                        ->where(['permohonanID' => $permohonanID])
                        ->andWhere(['status' => 1])
                        ->all();
                
                foreach ($model3 as $model3){
                    $model3->kategoriKursusID = $model->kompetensiCadangan;
                    $model3->save(false);
                }
                     * 
                     */

                    /** new **/

                    if (Yii::$app->request->post()) {

                        foreach ($model2->all() as $m) {

                            //                var_dump(Yii::$app->request->post($m->staffID));
                            //                die();

                            $model3 = Peserta::find()
                                ->where(['permohonanID' => $permohonanID, 'staffID' => $m->staffID])
                                ->one();

                            $model3->mataIDPcadangan = Yii::$app->request->post($m->staffID);
                            $model3->statusPL = '1';
                            if ($model3->save(false)) {

                                //                    $model->statusUL = '1';
                                //                    $model->statusPermohonan = '3';
                                //                    $model->tarikhSemakanUL = date('Y-m-d');
                                //                    $model->adminUL = Yii::$app->user->getId();
                                //                    $model->save(false);

                                Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya ubah!']);
                            }
                        }
                    }
                    /** /new **/
                }

                return $this->redirect(['idp/tindakan-pengesahan-bsm?permohonanID=' . $permohonanID]);
            }
        }

        return $this->render('tindakan_pengesahan_bsm', [
            'model' => $model,
            'model2' => $model2,
            'dataProvider' => $dataProvider,
            'pID' => $permohonanID,
            'searchModel' => $searchModel
        ]);
    }

    public function actionKelulusanBsmAkademik()
    {

        $semakList = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata.jawatan')
            ->where(['statusPermohonan' => '4', 'job_category' => 1])
            ->orderBy(['tarikhPohon' => SORT_ASC]);

        $dataProviderSemak = new ActiveDataProvider([
            'query' => $semakList,
        ]);

        $dataProviderSemak->pagination->pageSize = 5;

        $lulusList = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata.jawatan')
            ->where(['statusPermohonan' => '5', 'job_category' => 1])
            ->orderBy(['tarikhPohon' => SORT_DESC]);

        $dataProviderLulus = new ActiveDataProvider([
            'query' => $lulusList,
        ]);

        $dataProviderLulus->pagination->pageSize = 5;

        if ((array) Yii::$app->request->get('momo')) {

            $selection = (array) Yii::$app->request->get('momo');

            //            var_dump($selection);
            //            die();
            foreach ($selection as $permohonanID) {

                $model = $this->findModelPermohonanMataIdpIndividu($permohonanID);
                $today = date('Y-m-d');

                $model2 = Peserta::find()->where(['permohonanID' => $permohonanID]);
                $dataProvider = new ActiveDataProvider([
                    'query' => $model2,
                ]);

                //if ($model->load(Yii::$app->request->post())) {
                $model->statusPermohonan = '5';
                $model->tarikhKelulusan = $today;
                $model->diluluskanOleh = Yii::$app->user->getId();
                $model->statusSektor = 4; //autoLulus by BS

                if ($model->save(false)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Permohonan telah disemak!']);
                    $this->notifikasi($model->pemohonID, "Permohonan mata IDP anda telah diproses BSM. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan-individu'], ['class' => 'btn btn-success btn-sm']));

                    //var_dump($model->permohonanID);
                    //die();

                    if ($model->statusSektor == 4) {

                        $kursus = new KursusLatihan();
                        $kursus->unitBertanggungjawab = 'JFPIU';
                        $kursus->jenisLatihanID = 'jfpiu';
                        $kursus->statusKursusLatihan = 'AKTIF';
                        $kursus->tajukLatihan = $model->namaProgram;
                        $kursus->permohonanID = $model->permohonanID;

                        if ($kursus->save(false)) {

                            $siriLatihan = new SiriLatihan();
                            $siriLatihan->kursusLatihanID = $kursus->kursusLatihanID;
                            $siriLatihan->siri = '1';
                            $siriLatihan->lokasi = $model->lokasi;
                            $siriLatihan->tarikhMula = $model->tarikhMula;
                            $siriLatihan->tarikhAkhir = $model->tarikhTamat;
                            $siriLatihan->statusSiriLatihan = 'SEDANG BERJALAN';

                            if ($siriLatihan->save(false)) {

                                /** new **/

                                //                                    if (Yii::$app->request->post()) {
                                //
                                //                                    foreach ($model2->all() as $m){

                                //                var_dump(Yii::$app->request->post($m->staffID));
                                //                die();

                                $model3 = Peserta::find()
                                    ->where(['permohonanID' => $permohonanID])
                                    ->all();

                                foreach ($model3 as $model3) {

                                    $model3->mataIDPlulus = $model3->mataIDPcadangan;
                                    $model3->statusKS = '1';
                                    $model3->kompetensiLulus = $model3->kategoriKursusID;

                                    if ($model3->save(false)) {

                                        $slotLatihan = new SlotLatihan();
                                        $slotLatihan->siriLatihanID = $siriLatihan->siriLatihanID;
                                        $slotLatihan->slot = 1;
                                        $slotLatihan->mataSlot = $model3->mataIDPlulus;

                                        if ($slotLatihan->save(false)) {

                                            $modelK = new Kehadiran();
                                            $modelK->slotID = $slotLatihan->slotID;
                                            $modelK->staffID = $model3->staffID;
                                            $modelK->tarikhMasa = date('Y-m-d H:i:s');
                                            $modelK->kategoriKursusID = $model3->kompetensiLulus;
                                            $modelK->save(false);
                                            if ($modelK->save(false)) {
                                                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                                            }
                                        }

                                        //Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya ubah!']);
                                    }
                                }

                                //                                 }
                                //                                }/** /new **/
                            }
                        }
                    }
                }

                //                    return $this->redirect(['idp/tindakan-kelulusan-bsm?permohonanID=' . $permohonanID]);
                //                }
            }
        }

        return $this->render('semakan_senarai_permohonan_individu_sektor', [
            'dataProviderSemak' => $dataProviderSemak,
            'dataProviderLulus' => $dataProviderLulus,
            'type' => '1',
        ]);
    }

    public function actionKelulusanBsm()
    {

        $semakList = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata.jawatan')
            ->where(['statusPermohonan' => '4', 'job_category' => 2])
            ->orderBy(['tarikhPohon' => SORT_ASC]);

        $dataProviderSemak = new ActiveDataProvider([
            'query' => $semakList,
        ]);

        $dataProviderSemak->pagination->pageSize = 5;

        $lulusList = PermohonanMataIdpIndividu::find()
            ->joinWith('biodata.jawatan')
            ->where(['statusPermohonan' => '5', 'job_category' => 2])
            ->orderBy(['tarikhPohon' => SORT_DESC]);

        $dataProviderLulus = new ActiveDataProvider([
            'query' => $lulusList,
        ]);

        $dataProviderLulus->pagination->pageSize = 5;

        if ((array) Yii::$app->request->get('momo')) {

            $selection = (array) Yii::$app->request->get('momo');

            //            var_dump($selection);
            //            die();
            foreach ($selection as $permohonanID) {

                $model = $this->findModelPermohonanMataIdpIndividu($permohonanID);
                $today = date('Y-m-d');

                $model2 = Peserta::find()->where(['permohonanID' => $permohonanID]);
                $dataProvider = new ActiveDataProvider([
                    'query' => $model2,
                ]);

                //if ($model->load(Yii::$app->request->post())) {
                $model->statusPermohonan = '5';
                $model->tarikhKelulusan = $today;
                $model->diluluskanOleh = Yii::$app->user->getId();
                $model->statusSektor = 4; //autoLulus by BS

                if ($model->save(false)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Permohonan telah disemak!']);
                    $this->notifikasi($model->pemohonID, "Permohonan mata IDP anda telah diproses BSM. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan-individu'], ['class' => 'btn btn-success btn-sm']));

                    //var_dump($model->permohonanID);
                    //die();

                    if ($model->statusSektor == 4) {

                        $kursus = new KursusLatihan();
                        $kursus->unitBertanggungjawab = 'JFPIU';
                        $kursus->jenisLatihanID = 'jfpiu';
                        $kursus->statusKursusLatihan = 'AKTIF';
                        $kursus->tajukLatihan = $model->namaProgram;
                        $kursus->permohonanID = $model->permohonanID;

                        if ($kursus->save(false)) {

                            $siriLatihan = new SiriLatihan();
                            $siriLatihan->kursusLatihanID = $kursus->kursusLatihanID;
                            $siriLatihan->siri = '1';
                            $siriLatihan->lokasi = $model->lokasi;
                            $siriLatihan->tarikhMula = $model->tarikhMula;
                            $siriLatihan->tarikhAkhir = $model->tarikhTamat;
                            $siriLatihan->statusSiriLatihan = 'SEDANG BERJALAN';

                            if ($siriLatihan->save(false)) {

                                /** new **/

                                //                                    if (Yii::$app->request->post()) {
                                //
                                //                                    foreach ($model2->all() as $m){

                                //                var_dump(Yii::$app->request->post($m->staffID));
                                //                die();

                                $model3 = Peserta::find()
                                    ->where(['permohonanID' => $permohonanID])
                                    ->all();

                                foreach ($model3 as $model3) {

                                    $model3->mataIDPlulus = $model3->mataIDPcadangan;
                                    $model3->statusKS = '1';
                                    $model3->kompetensiLulus = $model3->kategoriKursusID;

                                    if ($model3->save(false)) {

                                        $slotLatihan = new SlotLatihan();
                                        $slotLatihan->siriLatihanID = $siriLatihan->siriLatihanID;
                                        $slotLatihan->slot = 1;
                                        $slotLatihan->mataSlot = $model3->mataIDPlulus;

                                        if ($slotLatihan->save(false)) {

                                            $modelK = new Kehadiran();
                                            $modelK->slotID = $slotLatihan->slotID;
                                            $modelK->staffID = $model3->staffID;
                                            $modelK->tarikhMasa = date('Y-m-d H:i:s');
                                            $modelK->kategoriKursusID = $model3->kompetensiLulus;
                                            $modelK->save(false);
                                            if ($modelK->save(false)) {
                                                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                                            }
                                        }

                                        //Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya ubah!']);
                                    }
                                }

                                //                                 }
                                //                                }/** /new **/
                            }
                        }
                    }
                }

                //                    return $this->redirect(['idp/tindakan-kelulusan-bsm?permohonanID=' . $permohonanID]);
                //                }
            }
        }

        return $this->render('semakan_senarai_permohonan_individu_sektor', [
            'dataProviderSemak' => $dataProviderSemak,
            'dataProviderLulus' => $dataProviderLulus,
            'type' => '2',
        ]);
    }

    public function actionTindakanKelulusanBsm($permohonanID)
    {

        $model = $this->findModelPermohonanMataIdpIndividu($permohonanID);
        $today = date('Y-m-d');

        $model2 = Peserta::find()->where(['permohonanID' => $permohonanID]);
        $dataProvider = new ActiveDataProvider([
            'query' => $model2,
        ]);

        if ($model->load(Yii::$app->request->post())) {
            $model->statusPermohonan = '5';
            $model->tarikhKelulusan = $today;
            $model->diluluskanOleh = Yii::$app->user->getId();

            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Permohonan telah disemak!']);

                //$modelS = UserAccess::find()->where(['userType' => 'ketuaSektor'])->one();

                //$this->notifikasi($modelS->userID, "Permohonan mata IDP staf menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan-individu-sektor'], ['class' => 'btn btn-danger btn-sm']));
                $this->notifikasi($model->pemohonID, "Permohonan mata IDP anda telah diproses BSM. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan-individu'], ['class' => 'btn btn-success btn-sm']));

                if ($model->statusSektor == 4) {

                    $kursus = new KursusLatihan();
                    $kursus->unitBertanggungjawab = 'JFPIU';
                    $kursus->jenisLatihanID = 'jfpiu';
                    $kursus->statusKursusLatihan = 'AKTIF';
                    $kursus->tajukLatihan = $model->namaProgram;
                    $kursus->permohonanID = $model->permohonanID;

                    if ($kursus->save(false)) {

                        $siriLatihan = new SiriLatihan();
                        $siriLatihan->kursusLatihanID = $kursus->kursusLatihanID;
                        $siriLatihan->siri = '1';
                        $siriLatihan->lokasi = $model->lokasi;
                        $siriLatihan->tarikhMula = $model->tarikhMula;
                        $siriLatihan->tarikhAkhir = $model->tarikhTamat;
                        $siriLatihan->statusSiriLatihan = 'SEDANG BERJALAN';

                        if ($siriLatihan->save(false)) {

                            /** new **/

                            if (Yii::$app->request->post()) {

                                foreach ($model2->all() as $m) {

                                    //                var_dump(Yii::$app->request->post($m->staffID));
                                    //                die();

                                    $model3 = Peserta::find()
                                        ->where(['permohonanID' => $permohonanID, 'staffID' => $m->staffID])
                                        ->one();

                                    $model3->mataIDPlulus = Yii::$app->request->post($m->staffID);
                                    $model3->statusKS = '1';

                                    if ($model3->kompetensiLulus == NULL) {
                                        $model3->kompetensiLulus = $model3->kategoriKursusID;
                                    }
                                    if ($model3->save(false)) {

                                        $slotLatihan = new SlotLatihan();
                                        $slotLatihan->siriLatihanID = $siriLatihan->siriLatihanID;
                                        $slotLatihan->slot = 1;
                                        $slotLatihan->mataSlot = $model3->mataIDPlulus;

                                        if ($slotLatihan->save(false)) {

                                            $modelK = new Kehadiran();
                                            $modelK->slotID = $slotLatihan->slotID;
                                            $modelK->staffID = $model3->staffID;
                                            $modelK->tarikhMasa = date('Y-m-d H:i:s');
                                            $modelK->kategoriKursusID = $model3->kompetensiLulus;
                                            $modelK->save(false);
                                            if ($modelK->save(false)) {
                                                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                                            }
                                        }

                                        //Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya ubah!']);
                                    }
                                }
                            }
                            /** /new **/
                        }
                    }
                }
            }

            return $this->redirect(['idp/tindakan-kelulusan-bsm?permohonanID=' . $permohonanID]);
        }

        return $this->render('tindakan_ketua_sektor', [
            'model' => $model,
            'model2' => $model2,
            'dataProvider' => $dataProvider,
            'pID' => $permohonanID,
        ]);
    }

    public function actionPeraku()
    {

        $currentYear = date('Y');

        $userID = Yii::$app->user->getId();

        $noti = Notification::find()->where(['icno' => $userID, 'title' => 'MyIDP', 'status' => '0'])->all();
        foreach ($noti as $n) {
            if (substr($n->content, 0, 23) == 'Permohonan kursus staff') {
                $n->status = '1';
                $n->save(false);
            }
        }

        //        $baruList = PermohonanLatihan::find()
        //                ->joinWith('sasaran2')
        //                ->where(['statusPermohonan' => 'BARU'])
        //                ->andWhere(['peraku_icno' => $userID]);

        /** ***************** cross-server error ******************************************* */

        $baruList = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'BARU'])
            ->andWhere(['YEAR(tarikhPermohonan)' => $currentYear])
            ->all();

        $test = SetPegawai::find()->where(['peraku_icno' => $userID])->all();

        $senaraiPemohon = [];
        foreach ($baruList as $baruListt) {
            foreach ($test as $test2) {
                if ($test2->pemohon_icno == $baruListt->staffID) {
                    array_push($senaraiPemohon, $baruListt->staffID);
                }
            }
        }

        $senaraiPemohon2 = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'BARU'])
            ->andWhere(['YEAR(tarikhPermohonan)' => $currentYear])
            ->andWhere(['staffID' => $senaraiPemohon]);


        $dataProvider = new ActiveDataProvider([
            'query' => $senaraiPemohon2,
        ]);

        //        $dataProvider = new ActiveDataProvider([
        //            'query' => $baruList,
        //        ]);

        /* * ***************** ******************************************* */

        // $baruListKursusLuar = PermohonanKursusLuar::find()
        //         ->joinWith('biodata.department')
        //         ->where(['chief' => $userID])
        //         ->andWhere(['<>', 'statusPermohonan', '2'])
        //         ->andWhere(['YEAR(tarikhPohon)' => $currentYear]);    

        // $dataProviderKursusLuar = new ActiveDataProvider([
        //     'query' => $baruListKursusLuar,
        // ]); //cross-server error

        $baruListKursusLuar = PermohonanKursusLuar::find()
            ->where(['<>', 'statusPermohonan', '2'])
            ->andWhere(['YEAR(tarikhPohon)' => $currentYear])
            ->all();

        $senaraiPemohon3 = [];
        foreach ($baruListKursusLuar as $baruListt) {

            if ($baruListt->biodata->department->chief == $userID) {

                array_push($senaraiPemohon3, $baruListt->pemohonID);
            }
        }

        $senaraiPemohon4 = PermohonanKursusLuar::find()
            ->where(['<>', 'statusPermohonan', '2'])
            ->andWhere(['YEAR(tarikhPohon)' => $currentYear])
            ->andWhere(['pemohonID' => $senaraiPemohon3]);


        $dataProviderKursusLuar = new ActiveDataProvider([
            'query' => $senaraiPemohon4,
        ]);

        /*         * ***************** test ******************************************* */

        $diperakuListTest = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'DIPERAKUI'])
            ->andWhere(['YEAR(tarikhPermohonan)' => $currentYear])
            ->all();

        $test3 = SetPegawai::find()->where(['peraku_icno' => $userID])->all();

        $senaraiPemohon3 = [];
        foreach ($diperakuListTest as $diperakuListTestt) {
            foreach ($test3 as $test33) {
                if ($test33->pemohon_icno == $diperakuListTestt->staffID) {
                    array_push($senaraiPemohon3, $diperakuListTestt->staffID);
                }
            }
        }

        $senaraiPemohon4 = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'DIPERAKUI'])
            ->andWhere(['YEAR(tarikhPermohonan)' => $currentYear])
            ->andWhere(['staffID' => $senaraiPemohon3]);

        //        var_dump($senaraiPemohon);
        //        die();

        $dataProviderA = new ActiveDataProvider([
            'query' => $senaraiPemohon4,
        ]);

        /*         * ***************** /test ******************************************* */

        //        $dilulusList = PermohonanLatihan::find()
        //                ->joinWith('sasaran2')
        //                ->where(['statusPermohonan' => 'DILULUSKAN'])
        //                ->andWhere(['set_pegawai.peraku_icno' => $userID]);
        //
        //        $dataProviderB = new ActiveDataProvider([
        //            'query' => $dilulusList,
        //        ]);

        /*         * ***************** test ******************************************* */

        $dilulusList = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'DILULUSKAN'])
            ->andWhere(['YEAR(tarikhPermohonan)' => $currentYear])
            ->all();

        $test4 = SetPegawai::find()->where(['peraku_icno' => $userID])->all();

        $senaraiPemohon5 = [];
        foreach ($dilulusList as $dilulusListt) {
            foreach ($test4 as $test44) {
                if ($test44->pemohon_icno == $dilulusListt->staffID) {
                    array_push($senaraiPemohon5, $dilulusListt->staffID);
                }
            }
        }

        $senaraiPemohon6 = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'DILULUSKAN'])
            ->andWhere(['YEAR(tarikhPermohonan)' => $currentYear])
            ->andWhere(['staffID' => $senaraiPemohon5]);

        $dataProviderB = new ActiveDataProvider([
            'query' => $senaraiPemohon6,
        ]);

        /*         * ***************** /test ******************************************* */

        return $this->render('view_senarai_diperaku', [
            'baruListKursusLuar' => $baruListKursusLuar,
            'dataProvider' => $dataProvider,
            'dataProviderA' => $dataProviderA,
            'dataProviderB' => $dataProviderB,
            'dataProviderKursusLuar' => $dataProviderKursusLuar,
            'senaraiPemohon2' => $senaraiPemohon2
        ]);
    }

    public function actionTindakanPeraku($staffID, $kursusLatihanID)
    {

        $model = $this->findModelPermohonanLatihan($staffID, $kursusLatihanID);
        $today = date('Y-m-d');

        if ($model->load(Yii::$app->request->post())) {
            $model->tarikhDiperakukan = $today;
            $model->diperakuOleh = Yii::$app->user->getId();
            //$model->save();

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya peraku!']);

                $model4 = SetPegawai::findOne(['pemohon_icno' => $model->staffID]);

                //$this->notifikasi($model4->peraku_icno, "Permohonan.".Html::a('<i class="fa fa-arrow-right"> MAKLUMAT LANJUT</i>', ['idp/peraku'], ['class'=>'btn btn-danger btn-sm']));
                $this->notifikasi($model4->pelulus_icno, "Permohonan kursus staff menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/pelulus'], ['class' => 'btn btn-danger btn-sm']));
                $this->notifikasi($model->staffID, "Permohonan kursus anda telah dihantar untuk tindakan Pegawai Pelulus. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));
                //return $this->redirect(['view-senarai-permohonan']);
            }

            return $this->redirect(['idp/peraku']);
        }

        return $this->renderAjax('tindakan_peraku', [
            'model' => $model,
        ]);
    }

    public function actionPelulus()
    {

        $currentYear = date('Y');

        $userID = Yii::$app->user->getId();

        $noti = Notification::find()->where(['icno' => $userID, 'title' => 'MyIDP', 'status' => '0'])->all();
        foreach ($noti as $n) {
            if (substr($n->content, 0, 23) == 'Permohonan kursus staff') {
                $n->status = '1';
                $n->save(false);
            }
        }

        //        $baruList = PermohonanLatihan::find()
        //                ->joinWith('sasaran2')
        //                ->where(['statusPermohonan' => 'BARU'])
        //                ->andWhere(['pelulus_icno' => $userID])
        //                ->andWhere(['peraku_icno' => '']);
        //                //->andWhere(['<>', 'peraku_icno', NULL]);
        //
        //        $dataProviderC = new ActiveDataProvider([
        //            'query' => $baruList,
        //        ]);

        /*         * ***************** test ******************************************* */

        $baruList = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'BARU'])
            ->andWhere(['YEAR(tarikhPermohonan)' => $currentYear])
            ->all();

        $pegList = SetPegawai::find()
            ->where(['pelulus_icno' => $userID])
            ->andWhere(['peraku_icno' => ''])
            ->all();

        $senaraiPemohon = [];
        foreach ($baruList as $a) {
            foreach ($pegList as $b) {
                if ($b->pemohon_icno == $a->staffID) {
                    array_push($senaraiPemohon, $a->staffID);
                }
            }
        }

        $senaraiPemohon2 = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'BARU'])
            ->andWhere(['YEAR(tarikhPermohonan)' => $currentYear])
            ->andWhere(['staffID' => $senaraiPemohon]);

        $dataProviderC = new ActiveDataProvider([
            'query' => $senaraiPemohon2,
        ]);

        /*         * ***************** /test ******************************************* */

        //        $diperakuList = PermohonanLatihan::find()
        //                ->joinWith('sasaran2')
        //                ->where(['statusPermohonan' => 'DIPERAKUI'])
        //                ->andWhere(['pelulus_icno' => $userID]);
        //
        //        $dataProviderA = new ActiveDataProvider([
        //            'query' => $diperakuList,
        //        ]);

        /*         * ***************** test ******************************************* */

        $diperakuList = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'DIPERAKUI'])
            ->andWhere(['YEAR(tarikhPermohonan)' => $currentYear])
            ->all();

        $pegListA = SetPegawai::find()
            ->where(['pelulus_icno' => $userID])
            ->all();

        $senaraiPemohonA = [];
        foreach ($diperakuList as $a) {
            foreach ($pegListA as $b) {
                if ($b->pemohon_icno == $a->staffID) {
                    array_push($senaraiPemohonA, $a->staffID);
                }
            }
        }

        $senaraiPemohonAB = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'DIPERAKUI'])
            ->andWhere(['YEAR(tarikhPermohonan)' => $currentYear])
            ->andWhere(['staffID' => $senaraiPemohonA]);

        $dataProviderA = new ActiveDataProvider([
            'query' => $senaraiPemohonAB,
        ]);

        /*         * ***************** /test ******************************************* */

        //        $dilulusList = PermohonanLatihan::find()
        //                ->joinWith('sasaran2')
        //                ->where(['statusPermohonan' => 'DILULUSKAN'])
        //                ->andWhere(['set_pegawai.pelulus_icno' => $userID]);
        //
        //        $dataProviderB = new ActiveDataProvider([
        //            'query' => $dilulusList,
        //        ]);

        /*         * ***************** test ******************************************* */

        $dilulusList = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'DILULUSKAN'])
            ->andWhere(['YEAR(tarikhPermohonan)' => $currentYear])
            ->all();

        $pegListB = SetPegawai::find()
            ->where(['pelulus_icno' => $userID])
            ->all();

        $senaraiPemohonB = [];
        foreach ($dilulusList as $a) {
            foreach ($pegListB as $b) {
                if ($b->pemohon_icno == $a->staffID) {
                    array_push($senaraiPemohonB, $a->staffID);
                }
            }
        }

        $senaraiPemohonBA = PermohonanLatihan::find()
            ->where(['statusPermohonan' => 'DILULUSKAN'])
            ->andWhere(['YEAR(tarikhPermohonan)' => $currentYear])
            ->andWhere(['staffID' => $senaraiPemohonB]);

        $dataProviderB = new ActiveDataProvider([
            'query' => $senaraiPemohonBA,
        ]);

        /*         * ***************** /test ******************************************* */

        return $this->render('view_senarai_diluluskan', [
            //                    'diperakuList' => $diperakuList,
            //                    'dilulusList' => $dilulusList,
            //                    'baruList' => $baruList,
            'dataProvider' => $dataProviderA,
            'dataProviderA' => $dataProviderB,
            'dataProviderC' => $dataProviderC,
        ]);
    }

    public function actionTindakanPelulus($staffID, $kursusLatihanID)
    {

        $model = $this->findModelPermohonanLatihan($staffID, $kursusLatihanID);
        $today = date('Y-m-d');

        if ($model->load(Yii::$app->request->post())) {
            $model->tarikhKelulusan = $today;
            $model->diluluskanOleh = Yii::$app->user->getId();

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya hantar!']);

                $model4 = SetPegawai::findOne(['pemohon_icno' => $model->staffID]);

                //$this->notifikasi($model4->peraku_icno, "Permohonan.".Html::a('<i class="fa fa-arrow-right"> MAKLUMAT LANJUT</i>', ['idp/peraku'], ['class'=>'btn btn-danger btn-sm']));
                //$this->notifikasi($model4->pelulus_icno, "Permohonan kursus staff menunggu tindakan anda ".Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/pelulus'], ['class'=>'btn btn-danger btn-sm']));
                $this->notifikasi($model->staffID, "Permohonan kursus anda telah diproses oleh Pegawai Pelulus. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));
                //return $this->redirect(['view-senarai-permohonan']);
            }

            return $this->redirect(['idp/pelulus']);
        }

        return $this->renderAjax('tindakan_pelulus', [
            'model' => $model,
        ]);
    }

    public function actionSlipKodKursus($id)
    {

        $siriL = SiriLatihan::find()
            ->where(['siriLatihanID' => $id])
            ->one();

        /********** test *************** */
        $mpdf = new \Mpdf\Mpdf();

        $mpdf->WriteHTML($this->renderPartial('slip_kod_kursus', [
            'model' => $siriL,
            'id' => $id,
        ]));
        $mpdf->Output();
    }

    public function actionSlipJemputan($id)
    {

        $userID = Yii::$app->user->getId();

        $rekodmohon = PermohonanLatihan::find()
            ->where(['staffID' => $userID])
            ->andWhere(['siriLatihanID' => $id])
            ->one();

        //        $query = SlotLatihan::find()->where(['siriLatihanID' => $id])->indexBy('slotID');
        //        $dataProvider = new ActiveDataProvider([
        //            'query' => $query,
        //        ]);
        //
        //        $queryKehadiran = Kehadiran::find()->where(['slotID' => $slotID])->andWhere(['staffID' => Yii::$app->user->getId()]);
        //        $dataProviderKehadiran = new ActiveDataProvider([
        //            'query' => $queryKehadiran,
        //        ]);

        /*         * ********* test *************** */
        $mpdf = new \Mpdf\Mpdf();

        $mpdf->WriteHTML($this->renderPartial('slipjemputan', [
            'model' => $rekodmohon,
            'id' => $id,
            'pesertaID' => Yii::$app->user->getId(),
        ]));
        $mpdf->Output();
    }

    /*     * ******************************************************* TEST CODES ****************************** */

    public function actionTest2()
    {
        $kursus = new VIdpSenaraiKursus();

        return $this->render('test2', [
            'model' => $kursus,
            //'tarafJawatan' => $tarafJawatan,
        ]);
    }

    public function actionTests()
    {
        $model = \app\models\myidp\VIdpKursusSasaran::findOne(['kursus_id' => '1399']);
        //var_dump($model);
        $model1 = \app\models\myidp\VIdpSenaraiKursus::findOne(['kursus_id' => '1399']);
        var_dump($model1);
    }

    public function actionIndex3()
    {
        //get current user ID
        $id = Yii::$app->user->getId();

        /*         * ************************************************************************** */
        /*         * get 'tempoh perkhidmatan di gred semasa' * */
        //get current year
        //        $currentYear = date('Y');
        $currentYear = 2019;

        //find [v_co_icno] from database that match with [$id]-currentUser AND
        //find [tahun] from database that match with [$currentYear]
        $model = Idp::findOne(['v_co_icno' => $id, 'tahun' => $currentYear]);

        return $this->render('index3', [
            'model' => $model,
        ]);
    }

    public function actionIndex4()
    {
        $model = new Idp();

        return $this->render('index4', [
            'model' => $model,
        ]);
    }

    public function actionTestPage()
    {
        $userID = Yii::$app->user->getId();

        $model3 = Tblprcobiodata::findOne(['ICNO' => $userID]);

        $emailMohonSiri = new TblSysEmailQueue();
        $emailMohonSiri->from_name = '[HR-Online] - MyIDP';
        $emailMohonSiri->from_email = 'hronline-noreply@ums.edu.my';
        $emailMohonSiri->to_name = $model3->CONm;
        $emailMohonSiri->to_email = $model3->COEmail;
        $emailMohonSiri->subject = 'PERMOHONAN KURSUS LATIHAN OLEH ' . $model3->CONm;
        $emailMohonSiri->message = 'TEST';


        if ($emailMohonSiri->save(false)) {

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya test!']);
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'warning', 'msg' => 'Tidak berjaya test!']);
            return $this->redirect(['index']);
        }

        return $this->render('testpage');
    }

    public function actionIndex6()
    {
        return $this->render('index6');
    }

    public function actionIndex7()
    {
        return $this->render('index7');
    }

    public function actionIndex8()
    {
        $model = new Status();

        return $this->render('index8', [
            'model' => $model,
        ]);
    }

    public function actionIndex17()
    {
        //$searchModel = new CalendarSearch();
        //        $searchModel = new SiriLatihanSearch();
        //        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModel = SiriLatihan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel,
        ]);

        return $this->render('index17', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex11()
    {
        return $this->render('index11');
    }

    public function actionDaftarKursusImpakTinggi()
    {
        $userID = Yii::$app->user->getId();
        $modelBiodata = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();

        $today = date('Y-m-d H:i:s');

        $model = new KursusLatihan();
        $model->scenario = 'impak';

        if ($model->load(Yii::$app->request->post())) {

            $model->updated_by = $userID;
            $model->updated = $today;
            $model->jenisLatihanID = 'latihanDalaman';
            $model->statusKursusLatihan = 'AKTIF';
            $model->unitBertanggungjawab = 'CBTM';
            $model->penggubalModul = '158';
            $model->kompetensi = '7';
            $model->kursusImpakTinggi = '1';

            $model->save(false); //$model->save(false) will save the model without any validation
            if ($model->save(false)) {
                //$this->notifikasi($userID, "Permohonan kursus luar anda telah dihantar untuk tindakan Ketua Jabatan. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya menambah kursus!']);
                return $this->redirect(['view-senarai-latihan']);
            }
        }

        return $this->render('daftar_kursus_impak_tinggi', [
            'model' => $model,
            'modelBiodata' => $modelBiodata,
        ]);
    }

    public function actionMohonlatihanluaran()
    {
        return $this->render('form_mohon_latihan_luaran');
    }

    public function actionMohonkursusluar()
    {
        $userID = Yii::$app->user->getId();
        $modelBiodata = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();

        $today = date('Y-m-d');

        $model = new PermohonanKursusLuar();

        if ($model->load(Yii::$app->request->post())) {

            //var_dump($model);
            //die();

            $model->pemohonID = $userID;
            $model->tarikhPohon = $today;
            $model->statusPermohonan = '1';

            $model->file1 = UploadedFile::getInstance($model, 'file1');

            if ($model->file1) {

                if ($model->save(false)) {

                    /*                     * ****************************************************************************************** */
                    $datas = Yii::$app->FileManager->UploadFile($model->file1->name, $model->file1->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');
                    //$datas = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');

                    if ($datas) {
                        if ($datas->status == true) {
                            $model->failProgram1 = $datas->file_name_hashcode;
                            $model->save(false);
                        }
                    }
                }
            }


            if (UploadedFile::getInstance($model, 'file2')) {

                $model->file2 = UploadedFile::getInstance($model, 'file2');

                if ($model->file2) {

                    if ($model->save(false)) {

                        /*                         * ****************************************************************************************** */
                        $datas = Yii::$app->FileManager->UploadFile($model->file2->name, $model->file2->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');
                        //$datas = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');

                        if ($datas->status == true) {
                            $model->failProgram2 = $datas->file_name_hashcode;
                            $model->save(false);
                        }
                    }
                }
            }

            if (UploadedFile::getInstance($model, 'file3')) {

                $model->file3 = UploadedFile::getInstance($model, 'file3');

                if ($model->file3) {

                    if ($model->save(false)) {

                        /*                         * ****************************************************************************************** */
                        $datas = Yii::$app->FileManager->UploadFile($model->file3->name, $model->file3->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');
                        //$datas = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');

                        if ($datas->status == true) {
                            $model->failProgram3 = $datas->file_name_hashcode;
                            $model->save(false);
                        }
                    }
                }
            }

            //            $model->pemohonID = $userID;
            //            $model->tarikhPohon = $today;
            //            $model->statusPermohonan = '1';
            //$model->save(false);



            $model->save(false); //$model->save(false) will save the model without any validation
            if ($modelBiodata->load(Yii::$app->request->post())) {
                $modelBiodata->save(false);
            }
            if ($model->save(false)) {
                $this->notifikasi($modelBiodata->department->chief, strtoupper($modelBiodata->displayGelaran . ' ' . $modelBiodata->CONm) . " telah memohon untuk mengikuti kursus anjuran agensi luar. Klik di sini untuk tindakan selanjutnya. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/peraku'], ['class' => 'btn btn-danger btn-sm']));
                $this->notifikasi($userID, "Permohonan kursus luar anda telah dihantar untuk tindakan Ketua Jabatan. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya memohon kursus luar!']);
                return $this->redirect(['view-senarai-permohonan']);
            }


            //            if ($model->validate()) {
            //                // form inputs are valid, do something here
            //                $model->pemohonID = $userID;
            //                $model->tarikhPohon = $today;
            //                $model->save();
            //
            //                return;
            //            }
        }

        return $this->render('mohonkursusluar', [
            'model' => $model,
            'modelBiodata' => $modelBiodata,
        ]);
    }

    public function actionZoom($id)
    {
        return $this->redirect($id);
    }

    public function actionTestqr2()
    {
        return $this->render('testqr2');
    }

    public function actionHellowidget()
    {
        return $this->render('hellowidget');
    }

    public function actionFormTesting()
    {
        $model = new User;

        return $this->render('form_testing', [
            'model' => $model,
        ]);
    }

    public function actionHello()
    {
        return $this->render('hello');
    }

    public function actionBorangpl()
    {
        return $this->renderAjax('borangpl');
    }

    public function actionBoranglama()
    {
        return $this->renderAjax('boranglama');
    }

    /*     * ********************************************************************************************************************* */

    /**
     * Displays a single Idp model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewIdp($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Idp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    //    public function actionCreate() {
    //        $model = new Idp();
    //
    //        if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //            return $this->redirect(['view', 'id' => $model->id]);
    //        }
    //
    //        return $this->render('create', [
    //                    'model' => $model,
    //        ]);
    //    }

    /**
     * Updates an existing Idp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateLatihan($id)
    {
        $model = $this->findModelLatihan($id);

        $model->scenario = 'kursus-baru';

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {

            $model->updated = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->getId();
            $model->save(false);
            // return $this->redirect(['view-latihan', 'id' => $model->kursusLatihanID]);
            return $this->redirect(['update-latihan', 'id' => $model->kursusLatihanID]);
        }

        // return $this->render('update_latihan', [
        //     'model' => $model,
        // ]);

        /** new starting 01/08/2022 */
        return $this->render('create_latihan', [
            'model' => $model,
            'status' => '2' //update latihan
        ]);
    }

    public function actionUpdateKursusJfpiu($id)
    {
        $model = $this->findModelKursusJfpiu($id);
        $model2 = SiriLatihanJfpiu::find()->where(['kursusLatihanID' => $id])->all();
        //$model3 = SlotLatihanJfpiu::find()->where(['siriLatihanID' => $model2->siriLatihanID])->all();

        //        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //            //return $this->redirect(['view', 'id' => $model->id]); //selepas 'UPDATE' dan SUBMIT dia akan pergi page 'view'
        //            return $this->redirect(['view-latihan', 'id' => $model->kursusLatihanID]);
        //        }

        return $this->render('update_kursus_jfpiu', [
            'model' => $model,
            'model2' => $model2,
            //'model3' => $model3,
        ]);
    }

    public function actionUpdateLatihanLuaranPohon($permohonanID)
    {
        $model = $this->findModelLatihanLuarPohon($permohonanID);

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            //return $this->redirect(['view', 'id' => $model->id]); //selepas 'UPDATE' dan SUBMIT dia akan pergi page 'view'
            return $this->redirect(['view-latihan-luar-pohon', 'permohonanID' => $model->permohonanID, 'userLevel' => 'user', 'update' => 'NO']);
        }

        return $this->render('update_latihan_luaran_pohon', [
            'model' => $model,
        ]);
    }

    public function actionMohonMataIdp()
    {

        $userID = Yii::$app->user->getId();
        $modelBio = Tblprcobiodata::findOne(['ICNO' => $userID]);
        $jobCat = $modelBio->jawatan->job_category;

        $today = date('Y-m-d');

        $model = new PermohonanMataIdpIndividu();

        if ($model->load(Yii::$app->request->post())) {

            $model->pemohonID = $userID;
            $model->tarikhPohon = $today;
            $model->jenisPermohonan = '1';

            $namaProgram = PermohonanMataIdpIndividu::removeEmoji($model->namaProgram);
            $model->namaProgram = $namaProgram;

            /** check if the applier is a chief **/
            $checkChief = Department::find()
                ->where(['chief' => $userID, 'isActive' => '1'])
                ->all();

            if ($checkChief) {
                $model->statusKJ = '2';
                $model->statusPermohonan = '2';
                $model->tarikhSemakanKJ = $today;
                $model->kjPenyemak = $userID;
            } else {
                $model->statusPermohonan = '1';
            }

            if ($model->save(false)) {

                $modelPeserta = new Peserta();
                $modelPeserta->permohonanID = $model->permohonanID;
                $modelPeserta->staffID = $model->pemohonID;
                $modelPeserta->kategoriKursusID = $model->kompetensiPohon;
                $modelPeserta->save(false);
            }

            $model->file1 = UploadedFile::getInstance($model, 'file1');

            if (UploadedFile::getInstance($model, 'file1')) {
                if ($model->file1) {

                    if ($model->save(false)) {

                        /*                         * ****************************************************************************************** */
                        $datas = Yii::$app->FileManager->UploadFile($model->file1->name, $model->file1->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');
                        //$datas = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');

                        if ($datas->status == true) {
                            $model->failProgram1 = $datas->file_name_hashcode;
                            $model->save(false);
                        }
                    }
                }
            }

            if (UploadedFile::getInstance($model, 'file2')) {

                $model->file2 = UploadedFile::getInstance($model, 'file2');

                if ($model->file2) {

                    if ($model->save(false)) {

                        /*                         * ****************************************************************************************** */
                        $datas = Yii::$app->FileManager->UploadFile($model->file2->name, $model->file2->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');
                        //$datas = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');

                        if ($datas->status == true) {
                            $model->failProgram2 = $datas->file_name_hashcode;
                            $model->save(false);
                        }
                    }
                }
            }

            if (UploadedFile::getInstance($model, 'file3')) {

                $model->file3 = UploadedFile::getInstance($model, 'file3');

                if ($model->file3) {

                    if ($model->save(false)) {

                        /*                         * ****************************************************************************************** */
                        $datas = Yii::$app->FileManager->UploadFile($model->file3->name, $model->file3->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');
                        //$datas = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');

                        if ($datas->status == true) {
                            $model->failProgram3 = $datas->file_name_hashcode;
                            $model->save(false);
                        }
                    }
                }
            }

            if ($model->save(false)) {

                //                $modelPeserta = new Peserta();
                //                $modelPeserta->permohonanID = $model->permohonanID;
                //                $modelPeserta->staffID = $model->pemohonID;
                //                $modelPeserta->kategoriKursusID = $model->kompetensiPohon;
                //                $modelPeserta->save(false);

                //               if (Yii::$app->request->post('momo') != NULL) {
                //
                //                $selection = Yii::$app->request->post('momo');
                //
                //                foreach ($selection as $idp) {
                //                    
                //                    $checkPeserta = Peserta::find()
                //                                ->where(['staffID' => $idp])
                //                                ->andWhere(['permohonanID' => $model->permohonanID])
                //                                ->one();
                //                    
                //                    if (!$checkPeserta) {
                //                        $modelPeserta = new Peserta();
                //                        $modelPeserta->permohonanID = $model->permohonanID;
                //                        $modelPeserta->staffID = $idp;
                //                        $modelPeserta->kategoriKursusID = $model->kompetensiPohon;
                //                        $modelPeserta->save(false);
                //                    }
                //                }
                //               }

                if ($checkChief) {
                    $this->notifikasi($userID, "Permohonan mata IDP anda telah dihantar untuk tindakan urusetia. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan-individu'], ['class' => 'btn btn-success btn-sm']));
                } else {
                    $this->notifikasi($modelBio->department->chief, "Permohonan mata IDP oleh " . strtoupper($modelBio->CONm) . " menunggu pengesahan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/tindakan-pengesahan?permohonanID=' . $model->permohonanID], ['class' => 'btn btn-danger btn-sm']));
                    $this->notifikasi($userID, "Permohonan mata IDP anda telah dihantar untuk tindakan Ketua Jabatan. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan-individu'], ['class' => 'btn btn-success btn-sm']));
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya memohon mata IDP bagi kursus dihadiri!']);
                return $this->redirect(['view-senarai-permohonan-individu']);
            }
        }

        //        $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO',
        //                function($model) {
        //                    $a = $model['CONm'] . ' - ' . $model->department->shortname;
        //                    return $a;
        //                }, 'department.fullname'); //groupby

        return $this->render('mohon_mata_idp', [
            'model' => $model,
            //'allStaf' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname'),
            //'allStaf' => $allStaf,
            'pemohon' => $userID,
            'jobCat' => $jobCat,
        ]);
    }

    public function actionMohonMataIdpJfpiu()
    {

        $userID = Yii::$app->user->getId();
        $today = date('Y-m-d');

        $model = new PermohonanMataIdpIndividu();

        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'Fail',
        ]);

        //$modelImport->addRule(['fileImport'], 'required');
        $modelImport->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx']);
        $modelImport->addRule(['fileImport'], 'file', ['maxSize' => 2 * 1024 * 1024]);

        if ($model->load(Yii::$app->request->post())) {

            $model->pemohonID = $userID;
            $model->tarikhPohon = $today;
            $model->jenisPermohonan = '2';

            /** check if the applier is a chief **/
            $checkChief = Department::find()->where(['chief' => $userID, 'isActive' => '1'])->all();

            if (Yii::$app->request->post('submit') == 2) {

                if ($checkChief) {
                    $model->statusKJ = '2';
                    $model->statusPermohonan = '2';
                    $model->tarikhSemakanKJ = $today;
                    $model->kjPenyemak = $userID;
                } else {
                    $model->statusPermohonan = '1';
                }
            } else {

                $model->statusPermohonan = '99'; //status 'Simpan'

            }

            if (UploadedFile::getInstance($model, 'file1')) {

                $model->file1 = UploadedFile::getInstance($model, 'file1');

                if ($model->file1) {

                    if ($model->save(false)) {

                        /*                         * ****************************************************************************************** */
                        $datas = Yii::$app->FileManager->UploadFile($model->file1->name, $model->file1->tempName, '04', 'Permohonan Mata IDP JAFPIB/bahan');
                        //$datas = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');

                        if ($datas) {
                            if ($datas->status == true) {
                                $model->failProgram1 = $datas->file_name_hashcode;
                                $model->save(false);
                            }
                        }
                    }
                }
            }

            if (UploadedFile::getInstance($model, 'file2')) {

                $model->file2 = UploadedFile::getInstance($model, 'file2');

                if ($model->file2) {

                    if ($model->save(false)) {

                        /*                         * ****************************************************************************************** */
                        $datas = Yii::$app->FileManager->UploadFile($model->file2->name, $model->file2->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');
                        //$datas = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');

                        if ($datas->status == true) {
                            $model->failProgram2 = $datas->file_name_hashcode;
                            $model->save(false);
                        }
                    }
                }
            }

            if (UploadedFile::getInstance($model, 'file3')) {

                $model->file3 = UploadedFile::getInstance($model, 'file3');

                if ($model->file3) {

                    if ($model->save(false)) {

                        /*                         * ****************************************************************************************** */
                        $datas = Yii::$app->FileManager->UploadFile($model->file3->name, $model->file3->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');
                        //$datas = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'Permohonan Kursus Luar/bahanKursusLuar');

                        if ($datas->status == true) {
                            $model->failProgram3 = $datas->file_name_hashcode;
                            $model->save(false);
                        }
                    }
                }
            }

            $modelBiodata = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();

            if ($model->save(false)) {

                if (Yii::$app->request->post('momo') != NULL) {

                    $selection = Yii::$app->request->post('momo');

                    foreach ($selection as $idp) {

                        $checkPeserta = Peserta::find()
                            ->where(['staffID' => $idp])
                            ->andWhere(['permohonanID' => $model->permohonanID])
                            ->one();

                        if (!$checkPeserta) {
                            $modelPeserta = new Peserta();
                            $modelPeserta->permohonanID = $model->permohonanID;
                            $modelPeserta->staffID = $idp;

                            $modelBiod = Tblprcobiodata::find()->where(['ICNO' => $idp])->one();

                            if ($modelBiod) {
                                $jobC = $modelBiod->jawatan->job_category;

                                if ($jobC == '1') {
                                    $modelPeserta->kategoriKursusID = $model->kompetensiPohon2;
                                } else {
                                    $modelPeserta->kategoriKursusID = $model->kompetensiPohon;
                                }
                            }
                            //$modelPeserta->kategoriKursusID = $model->kompetensiPohon;
                            $modelPeserta->save(false);
                        }
                    }
                }

                /** new 03/06/2020 **/
                //                $modelImport = new \yii\base\DynamicModel([
                //                    'fileImport' => 'File Import',
                //                ]);
                //
                //                $modelImport->addRule(['fileImport'], 'required');
                //                $modelImport->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx'], ['maxSize' => 1024 * 1024]);

                //if (Yii::$app->request->post()) {

                $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');

                if ($modelImport->fileImport && $modelImport->validate()) {

                    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($modelImport->fileImport->tempName);
                    $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $baseRow = 3;

                    $countD = count($sheetData);

                    //$email_not_exist = [];

                    while ($baseRow <= $countD) {

                        if (!empty($sheetData[$baseRow]['C'])) {

                            $check = PesertaImport::find()
                                ->where(['staffEmail' => (string) $sheetData[$baseRow]['C'], 'permohonanID' => $model->permohonanID])
                                ->one();

                            if (!$check) {
                                $modell = new PesertaImport;
                                $modell->staffEmail = (string) $sheetData[$baseRow]['C'];
                                $modell->permohonanID = $model->permohonanID;
                                $modell->pemuatNaik = Yii::$app->user->getId();
                                $modell->tarikhMuatNaik = date("Y-m-d");
                                $modell->save(false);

                                // if ($modell->save(false)) {

                                $modelBiodata2 = Tblprcobiodata::find()
                                    ->where(['LIKE', 'COEmail', $modell->staffEmail])
                                    ->one();

                                if ($modelBiodata2) {

                                    $checkPeserta2 = Peserta::find()
                                        ->where(['staffID' => $modelBiodata2->ICNO])
                                        ->andWhere(['permohonanID' => $modell->permohonanID])
                                        ->one();

                                    if (!$checkPeserta2) {
                                        $modelPeserta2 = new Peserta();
                                        $modelPeserta2->permohonanID = $modell->permohonanID;
                                        $modelPeserta2->staffID = $modelBiodata2->ICNO;
                                        //$modelPeserta2->kategoriKursusID = $model->kompetensiPohon;
                                        $modelBiod = Tblprcobiodata::find()->where(['ICNO' => $modelBiodata2->ICNO])->one();

                                        if ($modelBiod) {
                                            $jobC = $modelBiod->jawatan->job_category;

                                            if ($jobC == '1') {
                                                $modelPeserta2->kategoriKursusID = $model->kompetensiPohon2;
                                            } else {
                                                $modelPeserta2->kategoriKursusID = $model->kompetensiPohon;
                                            }
                                        }
                                        $modelPeserta2->save(false);
                                    }
                                }
                                //  }
                            }
                        } elseif (!empty($sheetData[$baseRow]['B'])) {

                            $count = Tblprcobiodata::find()
                                ->where(['CONm' => (string) $sheetData[$baseRow]['B']])
                                ->count();

                            if ($count == 1) {

                                $modelBiodata2 = Tblprcobiodata::find()
                                    ->where(['CONm' => (string) $sheetData[$baseRow]['B']])
                                    ->one();

                                if ($modelBiodata2) {

                                    $checkPeserta2 = Peserta::find()
                                        ->where(['staffID' => $modelBiodata2->ICNO])
                                        ->andWhere(['permohonanID' => $model->permohonanID])
                                        ->one();

                                    if (!$checkPeserta2) {
                                        $modelPeserta2 = new Peserta();
                                        $modelPeserta2->permohonanID = $model->permohonanID;
                                        $modelPeserta2->staffID = $modelBiodata2->ICNO;
                                        //$modelPeserta2->kategoriKursusID = $model->kompetensiPohon;
                                        $modelBiod = Tblprcobiodata::find()->where(['ICNO' => $modelBiodata2->ICNO])->one();

                                        if ($modelBiod) {
                                            $jobC = $modelBiod->jawatan->job_category;

                                            if ($jobC == '1') {
                                                $modelPeserta2->kategoriKursusID = $model->kompetensiPohon2;
                                            } else {
                                                $modelPeserta2->kategoriKursusID = $model->kompetensiPohon;
                                            }
                                        }
                                        $modelPeserta2->save(false);
                                    }
                                }
                            }
                        }
                        $baseRow++;
                    }
                    //return $this->redirect(['view-latihan-live?id=' . $id . '&slotID=' . $slotID]);
                    Yii::$app->getSession()->setFlash('success', 'Success');
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Error');
                }
                //}
                /****/

                if ($checkChief) {
                    $this->notifikasi($userID, "Permohonan mata IDP anda telah dihantar untuk tindakan urusetia. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan-individu'], ['class' => 'btn btn-success btn-sm']));
                } else {
                    $this->notifikasi($modelBiodata->department->chief, "Permohonan mata IDP staff menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/pengesahan'], ['class' => 'btn btn-danger btn-sm']));
                    $this->notifikasi($userID, "Permohonan mata IDP anda telah dihantar untuk tindakan Ketua Jabatan. " . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan-individu'], ['class' => 'btn btn-success btn-sm']));
                }

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya memohon mata IDP bagi kursus dihadiri!']);
                return $this->redirect(['view-senarai-permohonan-individu']);
                //var_dump($userID);
                //die();
            }
        }

        //        $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO',
        //                function($model) {
        //                    if ($model->department){
        //                        $a = $model['CONm'] . ' - ' . $model->department->shortname;
        //                    }
        //                    return $a;
        //                }, 'department.fullname'); //groupby

        $allStaf = ArrayHelper::map(
            Tblprcobiodata::find(['Status' => '1'])->all(),
            'ICNO',
            function ($model) {
                if ($model->department) {
                    $a = $model['CONm'] . ' - ' . $model->department->shortname;
                }
                return $a;
            }
        ); //groupby

        return $this->render('mohon_mata_idp_jfpiu', [
            'model' => $model,
            //'allStaf' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname'),
            'allStaf' => $allStaf,
            'pemohon' => $userID,
            'modelImport' => $modelImport,
        ]);
    }

    /**
     * Deletes an existing Idp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteCeramah($siriLatihanID, $penceramahID)
    {
        $this->findModel($id)->delete();

        //return $this->redirect(['index']);

        //tengok balik nanti
    }

    public function actionDeleteLatihan($id)
    {

        //        if ($this->findModelLatihan($id)->delete()){
        //            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapus data']);
        //        }
        //
        //        return $this->redirect(['view-senarai-latihan']);

        /*         * ********************************* Update kursusLatihan status ONLY **************************************************** */

        $model = $this->findModelLatihan($id);

        $model->statusKursusLatihan = 'TIDAK AKTIF';

        if ($model->save()) {

            $modelSiri = SiriLatihan::find()->where(['kursusLatihanID' => $id])->all();

            if ($modelSiri) {
                foreach ($modelSiri as $siri) {
                    $siri->statusSiriLatihan = 'INACTIVE';
                    $siri->save(false);
                }
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapus data']);
        }

        return $this->redirect(['view-senarai-latihan']);
    }

    public function actionDeletePermohonanSiri($siriID, $staffID)
    {

        if ($this->findModelPermohonanLatihan2($siriID, $staffID)->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya batalkan permohononan siri ini']);
        }

        return $this->redirect(['view-kursus-sasaran']);
    }

    public function actionDeletePermohonan($siriID, $staffID)
    {

        if ($this->findModelPermohonanLatihan2($siriID, $staffID)->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya batalkan jemputan']);
        }

        return $this->redirect(['jemput-peserta?id=' . $siriID]);
    }

    public function actionDeletePesertaSlot($slotID)
    {

        //Kehadiran::deleteAll(['slotID' => $slotID]);

        if (Kehadiran::deleteAll(['slotID' => $slotID])) {

            $modelSlot = SlotLatihan::find()->where(['slotID' => $slotID])->one();

            BorangPenilaianLatihan::deleteAll(['siriLatihanID' => $modelSlot->siriLatihanID]);

            BorangPenilaianKeberkesanan::deleteAll(['siriLatihanID' => $modelSlot->siriLatihanID]);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapuskan kehadiran']);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeletePeserta($slotID, $staffID)
    {

        //        var_dump($slotID);
        //        die();

        if ($this->findModelKehadiran($slotID, $staffID)->delete()) {
            //Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapuskan kehadiran']);

            $modelSlot = SlotLatihan::find()->where(['slotID' => $slotID])->one();

            $checkKehadiran = Kehadiran::find()
                ->joinWith('sasaran9')
                ->where(['siriLatihanID' => $modelSlot->siriLatihanID])
                ->andWhere(['staffID' => $staffID])
                ->count();

            //            var_dump($checkKehadiran);
            //            die();

            if ($checkKehadiran <= 0) {

                $checkBorang = BorangPenilaianLatihan::find()
                    ->where(['pesertaID' => $staffID])
                    ->andWhere(['siriLatihanID' => $modelSlot->siriLatihanID])
                    ->one();

                if ($checkBorang) {
                    $this->findModelBorangpl($modelSlot->siriLatihanID, $staffID)->delete();
                }

                $checkBorangK = BorangPenilaianKeberkesanan::find()
                    ->where(['pesertaID' => $staffID])
                    ->andWhere(['siriLatihanID' => $modelSlot->siriLatihanID])
                    ->one();

                if ($checkBorangK) {
                    $this->findModelBorangpk($modelSlot->siriLatihanID, $staffID)->delete();
                }
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapuskan kehadiran']);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapuskan kehadiran']);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeletePesertaJfpiu($slotID, $staffID)
    {
        if ($this->findModelKehadiranJfpiu($slotID, $staffID)->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapuskan kehadiran']);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeleteKursusJfpiu($id)
    {
        if ($this->findModelKursusJfpiu($id)->delete()) {

            $findSiri = SiriLatihanJfpiu::find()->where(['kursusLatihanID' => $id])->one();

            if ($this->findModelSiriLatihanJfpiu($findSiri->siriLatihanID)->delete()) {

                $findSlot = SlotLatihanJfpiu::find()->where(['siriLatihanID' => $findSiri->siriLatihanID])->one();

                if ($this->findModelSlotJfpiu($findSlot->slotID)->delete()) {

                    $findPeserta = KehadiranJfpiu::find()->where(['slotID' => $findSlot->slotID])->all();

                    foreach ($findPeserta as $findPeserta) {

                        $this->findModelKehadiranJfpiu($findPeserta->slotID, $findPeserta->staffID)->delete();
                    }
                }
            }
        }

        return $this->redirect(Yii::$app->request->referrer);

        //return $this->redirect(['view-senarai-latihan']);
    }

    public function actionDeleteSiri($id)
    {
        $findSlot = SlotLatihan::find()->where(['siriLatihanID' => $id])->all();
        $findPermohonan = PermohonanLatihan::find()->where(['siriLatihanID' => $id])->all();

        //var_dump($findSlot);
        //die();

        if ($this->findModelSiriLatihan($id)->delete()) {

            foreach ($findSlot as $id) {

                $this->findModelSlotLatihan($id->slotID)->delete();
            }

            foreach ($findPermohonan as $id) {

                $this->findModelPermohonanLatihan3($id->siriLatihanID)->delete();
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapus data']);
        }

        return $this->redirect(Yii::$app->request->referrer);

        //return $this->redirect(['view-senarai-latihan']);
    }

    public function actionDeleteSasaran($id)
    {

        if ($this->findModelSasaranLatihan($id)->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapus data']);
        }

        return $this->redirect(Yii::$app->request->referrer);

        //return $this->redirect(['view-senarai-latihan']);
    }

    public function actionDeleteJemputan($id)
    {

        if ($this->findModelJemputanLatihan($id)->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapus data']);
        }

        return $this->redirect(Yii::$app->request->referrer);

        //return $this->redirect(['view-senarai-latihan']);
    }

    public function actionDeleteLatihanLuaranPohon($id)
    {

        //        if ($this->findModelLatihan($id)->delete()){
        //            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapus data']);
        //        }
        //
        //        return $this->redirect(['view-senarai-latihan']);

        /*         * ********************************* Update kursusLatihan status ONLY **************************************************** */

        $model = $this->findModelLatihanLuarPohon($id);

        $model->statusPermohonan = '2';

        if ($model->save(false)) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya batalkan permohonan']);
        }

        return $this->redirect(['view-senarai-permohonan']);
    }

    public function actionHadirLatihanOnline($siriID)
    {

        $modelSiri = SiriLatihan::find()
            ->where(['siriLatihanID' => $siriID])
            ->one();

        if ($modelSiri) {
            $modelKursus = KursusLatihan::find()
                ->where(['kursusLatihanID' => $modelSiri->kursusLatihanID])
                ->one();
        }

        $modelSlotL = SlotLatihan::find()
            ->where(['siriLatihanID' => $siriID])
            ->andWhere(['slot' => 1])
            ->one();

        $pesertaID = Yii::$app->user->getId();

        $checkPeserta = Kehadiran::find()
            ->where(['staffID' => $pesertaID])
            ->andWhere(['slotID' => $modelSlotL->slotID])
            ->one();

        if ($checkPeserta) {
            Yii::$app->session->setFlash('alert', ['title' => 'TELAH DISAHKAN KEHADIRAN', 'type' => 'warning', 'msg' => 'Anda telah mengesahkan kehadiran pada ' . $checkPeserta->tarikhMasa]);
            //return $this->redirect(['view-kehadiran', 'kursusID' => $kursusID]);
            return $this->redirect('index');
        }

        //date_default_timezone_set('UTC+8');

        $today = date("Y-m-d H:i:s");

        $modelH = new Kehadiran();
        $modelH->slotID = $modelSlotL->slotID;
        $modelH->staffID = $pesertaID;
        $modelH->tarikhMasa = $today;

        $mohonList = PermohonanLatihan::find()
            ->where(['staffID' => $pesertaID])
            ->andWhere(['siriLatihanID' => $siriID])
            ->one();

        if (empty($mohonList)) {
            $modelH->statusPeserta = 'walk-in';
        } else {
            $modelH->statusPeserta = $mohonList->caraPermohonan;
        }

        /****************** Check kursusSasaran ******************************** */
        $model = Tblprcobiodata::findOne(['ICNO' => $pesertaID]);
        $gredJawatan = $model->gredJawatan;
        $tahap = $model->tahapKhidmat;

        $checkCategory = KursusSasaran::find()
            ->where("gredJawatanID = $gredJawatan and tahap = $tahap and siriLatihanID = $siriID")
            ->one();

        if ($checkCategory) {

            $kategoriKursusID = $checkCategory->kategoriKursusID;
        } else {
            $kategoriKursusID = $modelKursus->kompetensi;
        }

        $modelH->kategoriKursusID = $kategoriKursusID;

        /*         * *********************************************************************** */
        $modelH->save(false);

        if ($modelH->save()) {

            //$kursusID = SiriLatihan::find()->where(['siriLatihanID' => $siriID])->one();

            if ($modelH->kategoriKursusID != 1) {

                $checkBorang = BorangPenilaianLatihan::find()
                    ->where(['pesertaID' => $pesertaID])
                    ->andWhere(['siriLatihanID' => $siriID])
                    ->one();

                $checkBorangK = BorangPenilaianKeberkesanan::find()
                    ->where(['pesertaID' => $pesertaID])
                    ->andWhere(['siriLatihanID' => $siriID])
                    ->one();

                if (!$checkBorang && !$checkBorangK) {
                    $borangpl = new BorangPenilaianLatihan();
                    $borangpl->pesertaID = $pesertaID;
                    $borangpl->siriLatihanID = $siriID;
                    $borangpl->statusBorang = '1';
                    $borangpl->save();

                    $borangpk = new BorangPenilaianKeberkesanan();
                    $borangpk->pesertaID = $pesertaID;
                    $borangpk->siriLatihanID = $siriID;
                    $borangpk->statusBorang = '1';
                    $borangpk->save();

                    if ($borangpl->save() && $borangpk->save()) {
                        Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya sahkan kehadiran kursus. Sila isi borang penilaian latihan selepas tamat latihan.']);
                        return $this->redirect('index');
                    }
                }
            }

            Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya sahkan kehadiran kursus.']);
            return $this->redirect('index');
        }
        //return $this->redirect(['view-kehadiran', 'kursusID' => $kursusID]);
        else {
            Yii::$app->session->setFlash('alert', ['title' => 'TIDAK BERJAYA', 'type' => 'warning', 'msg' => 'Tidak berjaya sahkan kehadiran kursus. Sila cuba lagi.']);
        }
    }

    //public function actionHadirLatihan($id, $siriID, $kursusID, $userID)
    public function actionHadirLatihan($siriID, $pesertaID)
    {
        $userID = Yii::$app->user->getId();

        $checkUser = UserAccess::find()->where(['userID' => $userID])->one();

        if (!$checkUser) {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'warning', 'msg' => 'Harap maaf. Anda tiada akses untuk mengesahkan kehadiran. '
                . 'Sila berhubung dengan urusetia.']);
            return $this->redirect(['index']);
        }

        $checkDay = date("Y-m-d");
        $checkTime = date("H:i:s");

        //var_dump($checkTime);
        //die();

        $modelSiriL = SiriLatihan::find()->where(['siriLatihanID' => $siriID])->one();

        if ($checkDay == $modelSiriL->tarikhMula) {

            $modelRefSlot = RefSlot::find()->where(['slot' => 1])->one();

            //var_dump($modelRefSlot->starttime);
            //var_dump($modelRefSlot->endtime);
            //var_dump($modelRefSlot->starttime);die();

            if ($checkTime >= $modelRefSlot->starttime && $checkTime <= $modelRefSlot->endtime) {
                $slot = 1;

                $modelSlotL = SlotLatihan::find()
                    ->where(['siriLatihanID' => $siriID])
                    ->andWhere(['slot' => $slot])
                    ->one();

                $slotID = $modelSlotL->slotID;

                //                var_dump($slotID);
                //                var_dump($slotID);
                //                echo "1";
                //                die();
            } else {
                $slot = 2;

                $modelSlotL = SlotLatihan::find()
                    ->where(['siriLatihanID' => $siriID])
                    ->andWhere(['slot' => $slot])
                    ->one();

                $slotID = $modelSlotL->slotID;

                //                var_dump($slotID);
                //                var_dump($slotID);
                //                echo "2";
                //                die();
            }
        } elseif ($checkDay == $modelSiriL->tarikhAkhir) {
            $modelRefSlot = RefSlot::find()->where(['slot' => 3])->one();

            if ($checkTime >= $modelRefSlot->starttime && $checkTime <= $modelRefSlot->endtime) {
                $slot = 3;

                $modelSlotL = SlotLatihan::find()
                    ->where(['siriLatihanID' => $siriID])
                    ->andWhere(['slot' => $slot])
                    ->one();

                $slotID = $modelSlotL->slotID;

                //                var_dump($slotID);
                //                echo "3";
                //                die();
            } else {
                $slot = 4;

                $modelSlotL = SlotLatihan::find()
                    ->where(['siriLatihanID' => $siriID])
                    ->andWhere(['slot' => $slot])
                    ->one();

                $slotID = $modelSlotL->slotID;

                //                var_dump($slotID);
                //                echo "4";
                //                die();
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'RALAT', 'type' => 'warning', 'msg' => 'Ralat']);
            return $this->redirect('index');
        }

        //        $userID = Yii::$app->user->getId(); //old

        $checkPeserta = Kehadiran::find()
            ->where(['staffID' => $pesertaID])
            ->andWhere(['slotID' => $slotID])
            ->one();

        if ($checkPeserta) {
            Yii::$app->session->setFlash('alert', ['title' => 'TELAH DISAHKAN KEHADIRAN', 'type' => 'warning', 'msg' => 'Peserta telah mengesahkan kehadiran pada ' . $checkPeserta->tarikhMasa]);
            //return $this->redirect(['view-kehadiran', 'kursusID' => $kursusID]);
            return $this->redirect('index');
        }

        //date_default_timezone_set('UTC+8');

        $today = date("Y-m-d H:i:s");

        $modelH = new Kehadiran();
        $modelH->slotID = $slotID;
        $modelH->staffID = $pesertaID;
        $modelH->tarikhMasa = $today;

        $mohonList = PermohonanLatihan::find()
            ->where(['staffID' => $pesertaID])
            ->andWhere(['siriLatihanID' => $siriID])
            ->one();

        if (empty($mohonList)) {
            $modelH->statusPeserta = 'walk-in';
        } else {
            $modelH->statusPeserta = $mohonList->caraPermohonan;
        }

        /*         * ***************** Check kursusSasaran ******************************** */
        /** old * */
        //find [v_co_icno] from database that match with [$id]-currentUser AND
        //find [tahun] from database that match with [$currentYear]
        //        $model = Idp::find()->where(['v_co_icno' => $userID, 'tahun' => $currentYear])->one();
        //
        //        //get 'gredjawatan' from database
        //        $gredJawatan = $model->gredjawatan;
        //        $tahap = $model->tahap;

        /** /old * */
        $model = Tblprcobiodata::findOne(['ICNO' => $pesertaID]);
        $gredJawatan = $model->gredJawatan;
        $tahap = $model->tahapKhidmat;

        $checkCategory = KursusSasaran::find()
            ->where("gredJawatanID = $gredJawatan and tahap = $tahap and siriLatihanID = $siriID")
            ->one();

        if ($checkCategory) {

            $kategoriKursusID = $checkCategory->kategoriKursusID;
        } else {
            $kategoriKursusID = 0;
        }

        $modelH->kategoriKursusID = $kategoriKursusID;

        /*         * *********************************************************************** */
        $modelH->save(false);

        if ($modelH->save()) {

            //$kursusID = SiriLatihan::find()->where(['siriLatihanID' => $siriID])->one();

            $checkBorang = BorangPenilaianLatihan::find()
                ->where(['pesertaID' => $pesertaID])
                ->andWhere(['siriLatihanID' => $siriID])
                ->one();

            $checkBorangK = BorangPenilaianKeberkesanan::find()
                ->where(['pesertaID' => $pesertaID])
                ->andWhere(['siriLatihanID' => $siriID])
                ->one();

            if (!$checkBorang && !$checkBorangK) {
                $borangpl = new BorangPenilaianLatihan();
                $borangpl->pesertaID = $pesertaID;
                $borangpl->siriLatihanID = $siriID;
                $borangpl->statusBorang = '1';
                $borangpl->save();

                $borangpk = new BorangPenilaianKeberkesanan();
                $borangpk->pesertaID = $pesertaID;
                $borangpk->siriLatihanID = $siriID;
                $borangpk->statusBorang = '1';
                $borangpk->save();

                if ($borangpl->save() && $borangpk->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => 'BERJAYA', 'type' => 'success', 'msg' => 'Berjaya sahkan kehadiran kursus. Sila isi borang penilaian latihan selepas tamat latihan.']);
                }
            }

            //                $model = Idp::find()->where(['v_co_icno' => $userID, 'tahun' => $currentYear])->one();
            //
            //                //get 'gredjawatan' from database
            //                $gredJawatan = $model->gredjawatan;
            //                $tahap = $model->tahap;
            //
            //                $checkCategory = KursusSasaran::find()
            //                        ->where(['siriLatihanID' => $siriID])
            //                        ->andWhere(['gredJawatanID' => $gredJawatan])
            //                        ->andWhere(['tahap' => $tahap])
            //                        ->one();

            $checkMata = IdpMata::find()
                ->where(['staffID' => $pesertaID])
                ->andWhere(['tahun' => date('Y')])
                ->one();

            if ($checkCategory) {

                if ($checkCategory->kategoriKursusID == 1) {

                    if ($checkMata) {
                        $checkMata->mataUmum = $checkMata->mataUmum + 1;
                        //$checkMata->save(false);

                        if ($checkMata->save(false)) {
                            Yii::$app->session->setFlash('success', "Berjaya daftar kehadiran.");
                        } else {
                            Yii::$app->session->setFlash('error', "Tidak berjaya daftar kehadiran.");
                        }
                    } else {
                        $newMata = new IdpMata();
                        $newMata->staffID = $pesertaID;
                        $newMata->tahun = date('Y');
                        $newMata->mataUmum = 1;
                        $newMata->save(false);
                    }
                } elseif ($checkCategory->kategoriKursusID == 3) {
                    if ($checkMata) {
                        $checkMata->mataTeras = $checkMata->mataTeras + 3;
                        //$checkMata->save(false);

                        if ($checkMata->save(false)) {
                            Yii::$app->session->setFlash('success', "Berjaya daftar kehadiran.");
                        } else {
                            Yii::$app->session->setFlash('error', "Tidak berjaya daftar kehadiran.");
                        }
                    } else {
                        $newMata = new IdpMata();
                        $newMata->staffID = $pesertaID;
                        $newMata->tahun = date('Y');
                        $newMata->mataTeras = 3;
                        //$checkMata->save(false);

                        if ($newMata->save(false)) {
                            Yii::$app->session->setFlash('success', "Berjaya daftar kehadiran.");
                        } else {
                            Yii::$app->session->setFlash('error', "Tidak berjaya daftar kehadiran.");
                        }
                    }
                } elseif ($checkCategory->kategoriKursusID == 4) {
                    if ($checkMata) {
                        $checkMata->mataElektif = $checkMata->mataElektif + 3;
                        //$checkMata->save(false);

                        if ($checkMata->save(false)) {
                            Yii::$app->session->setFlash('success', "Berjaya daftar kehadiran.");
                        } else {
                            Yii::$app->session->setFlash('error', "Tidak berjaya daftar kehadiran.");
                        }
                    } else {
                        $newMata = new IdpMata();
                        $newMata->staffID = $pesertaID;
                        $newMata->tahun = date('Y');
                        $newMata->mataElektif = 3;
                        //$newMata->save(false);

                        if ($newMata->save(false)) {
                            Yii::$app->session->setFlash('success', "Berjaya daftar kehadiran.");
                        } else {
                            Yii::$app->session->setFlash('error', "Tidak berjaya daftar kehadiran.");
                        }
                    }
                } elseif ($checkCategory->kategoriKursusID == 5) {
                    if ($checkMata) {
                        $checkMata->mataTerasUni = $checkMata->mataTerasUni + 3;
                        //$checkMata->save(false);

                        if ($checkMata->save(false)) {
                            Yii::$app->session->setFlash('success', "Berjaya daftar kehadiran.");
                        } else {
                            Yii::$app->session->setFlash('error', "Tidak berjaya daftar kehadiran.");
                        }
                    } else {
                        $newMata = new IdpMata();
                        $newMata->staffID = $pesertaID;
                        $newMata->tahun = date('Y');
                        $newMata->mataTerasUni = 3;
                        //$newMata->save(false);

                        if ($newMata->save(false)) {
                            Yii::$app->session->setFlash('success', "Berjaya daftar kehadiran.");
                        } else {
                            Yii::$app->session->setFlash('error', "Tidak berjaya daftar kehadiran.");
                        }
                    }
                } elseif ($checkCategory->kategoriKursusID == 6) {
                    if ($checkMata) {
                        $checkMata->mataTerasSkim = $checkMata->mataTerasSkim + 3;
                        //$checkMata->save(false);

                        if ($checkMata->save(false)) {
                            Yii::$app->session->setFlash('success', "Berjaya daftar kehadiran.");
                        } else {
                            Yii::$app->session->setFlash('error', "Tidak berjaya daftar kehadiran.");
                        }
                    } else {
                        $newMata = new IdpMata();
                        $newMata->staffID = $pesertaID;
                        $newMata->tahun = date('Y');
                        $newMata->mataTerasSkim = 3;
                        //$newMata->save(false);

                        if ($newMata->save(false)) {
                            Yii::$app->session->setFlash('success', "Berjaya daftar kehadiran.");
                        } else {
                            Yii::$app->session->setFlash('error', "Tidak berjaya daftar kehadiran.");
                        }
                    }
                }
            } else {
                $kategoriKursusID = 0;
            }

            /* else {
             *
             *  if his is not in kursusSasaran, what will happen?
             *
             *
             *
             * }
             */
            //return $this->redirect(['view-kehadiran', 'kursusID' => $kursusID]);
            return $this->redirect('view-senarai-latihan-live');
        }
        //return $this->redirect(['view-kehadiran', 'kursusID' => $kursusID]);
        else {
            Yii::$app->session->setFlash('alert', ['title' => 'TIDAK BERJAYA', 'type' => 'warning', 'msg' => 'Tidak berjaya sahkan kehadiran kursus. Sila cuba lagi.']);
        }
    }
    public function actionStatistikV2()
    {
        $model = Kumpulankhidmat::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        $model2 = VIdpKumpulan::find()
            ->where(['kategori' => 1])
            ->orWhere(['vckl_kod_kumpulan' => '2'])
            ->orderBy('susunan');

        $dataProvider2 = new ActiveDataProvider([
            'query' => $model2,
            'pagination' => false,
        ]);

        $model3 = VIdpKumpulan::find()
            ->where(['kategori' => 2])
            ->orWhere(['vckl_kod_kumpulan' => '2'])
            ->orderBy('susunan');

        $dataProvider3 = new ActiveDataProvider([
            'query' => $model3,
            'pagination' => false,
        ]);

        return $this->render('statistik_mata_idp_v2', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'dataProvider3' => $dataProvider3,
        ]);
    }

    public function actionStatistikPencapaianSkim($tahun = null)
    {
        $year = date('Y');
        if (!$tahun) {
            $tahun = $year;
        }

        $model3 = StatistikSkimPentadbiran::find()
            ->where(['tahun' => $tahun])
            ->orderBy('gred_skim');

        $dataProvider = new ActiveDataProvider([
            'query' => $model3,
            'pagination' => false,
        ]);

        return $this->render('statistik_pencapaian_idp_by_skim', [
            'dataProvider' => $dataProvider,
            'modelSent' => $model3,
            'tahun' => $tahun
        ]);
    }

    public function actionStatistikSkim()
    {
        $array = RefCpdGroupGredJawatan::find()
            ->groupBy('gred_skim')
            ->orderBy('gred_skim')
            ->all();

        $model = GredJawatan::find()
            ->where(['in', 'gred_skim', $array])
            ->andWhere(['job_category' => '2'])
            ->groupBy('gred_skim')
            ->orderBy('gred_skim');

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('statistik_mata_idp_by_skim', [
            'dataProvider' => $dataProvider,
            'modelSent' => $model,
        ]);
    }

    public function actionStatistikSkimAkademik()
    {
        $array = RefCpdGroupGredJawatan::find()
            ->groupBy('gred_skim')
            ->orderBy('gred_skim')
            ->all();

        $model = GredJawatan::find()
            ->where(['in', 'gred_skim', $array])
            ->andWhere(['job_category' => '1'])
            ->groupBy('gred_skim')
            ->orderBy('gred_skim');

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('statistik_mata_idp_by_skim_akademik', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStatistikBaki()
    {
        $model = Kumpulankhidmat::find()
            ->where(['<>', 'name', 'Khas']);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        $model2 = VIdpKumpulan::find()
            ->where(['kategori' => 1])
            ->orWhere(['vckl_kod_kumpulan' => '2'])
            ->andWhere(['<>', 'vckl_kod_kumpulan', '13'])
            ->orderBy('susunan');

        $dataProvider2 = new ActiveDataProvider([
            'query' => $model2,
            'pagination' => false,
        ]);

        $model3 = VIdpKumpulan::find()
            ->where(['kategori' => 2])
            ->orWhere(['vckl_kod_kumpulan' => '2'])
            ->orderBy('susunan');

        $dataProvider3 = new ActiveDataProvider([
            'query' => $model3,
            'pagination' => false,
        ]);

        return $this->render('statistik_mata_idp_by_baki', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'dataProvider3' => $dataProvider3,
        ]);
    }

    public function actionStatistikPermohonanMataBulanan($tahun = null)
    {
        $year = date('Y');
        if (!$tahun) {
            $tahun = $year;
        }

        $model = TblMonths::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('statistik_permohonan_mata_bulanan', [
            'dataProvider' => $dataProvider,
            'year' => $tahun,
            'tahun' => $tahun
        ]);
    }

    public function actionStatistikKakitanganMengikutiKursusAnjuranLuar($tahun = null)
    {
        $year = date('Y');
        if (!$tahun) {
            $tahun = $year;
        }

        $model = TblMonths::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('statistik_staf_mengikuti_kursus_luar', [
            'dataProvider' => $dataProvider,
            'year' => $tahun,
            'tahun' => $tahun
        ]);
    }

    public function actionStatistikPencapaianPelaksanaanKursusDalaman($tahun = null)
    {
        $year = date('Y');
        if (!$tahun) {
            $tahun = $year;
        }

        $model = TblMonths::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('statistik_pencapaian_pelaksanaan_kursus_dalaman_by_bulan', [
            'dataProvider' => $dataProvider,
            'year' => $tahun,
            'tahun' => $tahun
        ]);
    }

    public function actionStatistikKehadiranKursusDalaman($tahun = null)
    {
        $year = date('Y');
        if (!$tahun) {
            $tahun = $year;
        }

        $model = TblMonths::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('statistik_pencapaian_pelaksanaan_kursus_dalaman_by_kehadiran', [
            'dataProvider' => $dataProvider,
            'year' => $tahun,
            'tahun' => $tahun
        ]);
    }

    public function actionStatistikPermohonanMata($tahun = null)
    {
        $year = date('Y');
        if (!$tahun) {
            $tahun = $year;
        }

        $model = Department::find()
            ->where(['isActive' => '1'])
            ->orderBy('fullname');

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('statistik_permohonan_mata_idp_jabatan', [
            'dataProvider' => $dataProvider,
            'year' => $tahun,
            'tahun' => $tahun
        ]);
    }

    public function actionStatistikJabatan()
    {
        // $model = Department::find()
        //     ->where(['isActive' => '1'])
        //     ->andWhere(['<>', 'sub_of', '138']); //list of dept under FPSK are excluded

        $model = Department::find()->andWhere([
            'and',
            ['isActive' => '1'],
            ['NOT', ['sub_of' => '138']]
        ])->orWhere([
            'and',
            ['isActive' => '1'],
            ['sub_of' => NULL]
        ])->orderBy('fullname');

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('statistik_mata_idp_jabatan', [
            'dataProvider' => $dataProvider,
            'year' => date('Y'),
        ]);
    }

    public function actionStatistik($tahun = null)
    {
        $year = date('Y');
        if (!$tahun) {
            $tahun = $year;
        }

        $model = Kumpulankhidmat::find()
            ->where(['<>', 'name', 'Khas']);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        //        if (isset(Yii::$app->request->queryParams['department'])){
        //            $dataProvider->query->andFilterWhere(['DeptId' => Yii::$app->request->queryParams['department']]);
        //            $dataProvider2->query->andFilterWhere(['DeptId' => Yii::$app->request->queryParams['department']]);
        //        }
        //        
        //        if (isset(Yii::$app->request->queryParams['kampus'])){
        //            $dataProvider->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['kampus']]);
        //            $dataProvider2->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['kampus']]);
        //        }
        //        
        //        if (isset(Yii::$app->request->queryParams['job_category'])){
        //            $dataProvider->query->andFilterWhere(['job_category' => Yii::$app->request->queryParams['job_category']]);
        //            $dataProvider2->query->andFilterWhere(['job_category' => Yii::$app->request->queryParams['job_category']]);
        //        }

        return $this->render('statistik_mata_idp', [
            'dataProvider' => $dataProvider,
            'tahun' => $tahun,
        ]);
    }

    public function actionStatistikPentadbiran($tahun = null)
    {
        $year = date('Y');
        if (!$tahun) {
            $tahun = $year;
        }

        $model3 = VIdpKumpulan::find()
            ->where(['kategori' => 2])
            ->orWhere(['vckl_kod_kumpulan' => '2'])
            ->orderBy('susunan');

        $dataProvider = new ActiveDataProvider([
            'query' => $model3,
            'pagination' => false,
        ]);

        return $this->render('statistik_mata_idp_pentadbiran', [
            'dataProvider' => $dataProvider,
            'tahun' => $tahun
        ]);
    }

    public function actionStatistikAkademik($tahun = null)
    {
        $year = date('Y');
        if (!$tahun) {
            $tahun = $year;
        }

        $model2 = VIdpKumpulan::find()
            ->where(['kategori' => 1])
            ->orWhere(['vckl_kod_kumpulan' => '2'])
            ->andWhere(['<>', 'vckl_kod_kumpulan', '13'])
            ->orderBy('susunan');

        $dataProvider = new ActiveDataProvider([
            'query' => $model2,
            'pagination' => false,
        ]);

        return $this->render('statistik_mata_idp_akademik', [
            'dataProvider' => $dataProvider,
            'tahun' => $tahun
        ]);
    }

    public function actionStatistikSenarai($id, $scheme)
    {
        if ($id == '1') {
            return $this->render('senarai_pentadbiran', [
                'dataProvider' => RptStatistikIdp::getStatisticsByComponent($scheme, 1, 1, 5),
            ]);
        } elseif ($id == '2') {
            return $this->render('senarai_pentadbiran', [
                'dataProvider' => RptStatistikIdp::getStatisticsByComponent($scheme, 2, 1, 5),
            ]);
        } elseif ($id == '3') {
            return $this->render('senarai_pentadbiran', [
                'dataProvider' => RptStatistikIdp::getStatisticsByComponent($scheme, 1, 1, 6),
            ]);
        } elseif ($id == '4') {
            return $this->render('senarai_pentadbiran', [
                'dataProvider' => RptStatistikIdp::getStatisticsByComponent($scheme, 2, 1, 6),
            ]);
        } elseif ($id == '5') {
            return $this->render('senarai_pentadbiran', [
                'dataProvider' => RptStatistikIdp::getStatisticsByComponent($scheme, 1, 1, 4),
            ]);
        } elseif ($id == '6') {
            return $this->render('senarai_pentadbiran', [
                'dataProvider' => RptStatistikIdp::getStatisticsByComponent($scheme, 2, 1, 4),
            ]);
        } elseif ($id == '7') {
            return $this->render('senarai_akademik', [
                'dataProvider' => RptStatistikIdp::getStatisticsByComponent($scheme, 3, 3, 3),
            ]);
        } elseif ($id == '8') {
            return $this->render('senarai_akademik', [
                'dataProvider' => RptStatistikIdp::getStatisticsByComponent($scheme, 3, 3, 4),
            ]);
        } elseif ($id == '9') {
            return $this->render('senarai_akademik', [
                'dataProvider' => RptStatistikIdp::getStatisticsByComponent($scheme, 3, 3, 1),
            ]);
        } elseif ($id == '10') {
            return $this->render('senarai_pentadbiran', [
                'dataProvider' => GredJawatan::getStaffByScheme($scheme, 1),
            ]);
        } elseif ($id == '11') {
            return $this->render('senarai_pentadbiran', [
                'dataProvider' => GredJawatan::getStaffByScheme($scheme, 2),
            ]);
        } elseif ($id == '12') {
            return $this->render('senarai_akademik', [
                'dataProvider' => GredJawatan::getStaffByScheme($scheme, 3),
            ]);
        }
    }

    public function actionSenaraiBaki($kumpulan, $category, $calctype)
    {
        if ($category == 0) { //keseluruhan

            $a = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['=', 'Status', '1'])
                ->andWhere(['job_group' => $kumpulan])
                ->all();
        } elseif ($category == 1) { //akademik

            $a = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['=', 'Status', '1'])
                ->andWhere(['cpd_group' => $kumpulan])
                ->andWhere(['job_category' => 1])
                ->all();
        } elseif ($category == 2) { //pentadbiran

            $a = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['=', 'Status', '1'])
                ->andWhere(['cpd_group' => $kumpulan])
                ->andWhere(['job_category' => 2])
                ->all();
        }

        /** countStaff **/
        $currentYear = date('Y');

        $b = RptStatistikIdpV2::find()
            ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $currentYear])
            ->all();

        $c = [];
        $d = [];
        $e = [];
        $f = [];
        foreach ($b as $bbb) {
            foreach ($a as $aaa) {
                if ($bbb->icno == $aaa->ICNO) {
                    if ($aaa->jawatan->job_category == 2) {
                        array_push($c, $bbb->icno);

                        if ($calctype == 0) { //countCapaiMin

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 3 && $bbb->baki != 0) {
                                    array_push($e, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 4) { //countBelumCapaiMin

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 6 && $bbb->baki > 3) {
                                    array_push($e, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 7) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 12 && $bbb->baki > 6) {
                                    array_push($e, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 13) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 18 && $bbb->baki > 12) {
                                    array_push($e, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 19) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 24 && $bbb->baki > 18) {
                                    array_push($e, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 25) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 30 && $bbb->baki > 24) {
                                    array_push($e, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 31) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 36 && $bbb->baki > 30) {
                                    array_push($e, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 37) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 42 && $bbb->baki > 36) {
                                    array_push($e, $bbb->icno);
                                }
                            }
                        }
                    } elseif ($aaa->jawatan->job_category == 1) {
                        array_push($d, $bbb->icno);

                        if ($calctype == 0) { //countCapaiMin

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 3 && $bbb->baki != 0) {
                                    array_push($f, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 4) { //countBelumCapaiMin

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 6 && $bbb->baki > 3) {
                                    array_push($f, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 7) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 12 && $bbb->baki > 6) {
                                    array_push($f, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 13) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 18 && $bbb->baki > 12) {
                                    array_push($f, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 19) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 24 && $bbb->baki > 18) {
                                    array_push($f, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 25) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 30 && $bbb->baki > 24) {
                                    array_push($f, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 31) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 36 && $bbb->baki > 30) {
                                    array_push($f, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 37) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->baki <= 42 && $bbb->baki > 36) {
                                    array_push($f, $bbb->icno);
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($calctype == 44) {
            $bb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $currentYear])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $c])
                ->orderBy('CONm');

            $bbbb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $currentYear])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $d])
                ->orderBy('CONm');
        } else {

            $bb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $currentYear])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $e])
                ->orderBy('CONm');

            $bbbb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $currentYear])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $f])
                ->orderBy('CONm');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $bb,
            'pagination' => false,
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $bbbb,
            'pagination' => false,
        ]);
        /*** /countStaff ***/

        return $this->render('senarai', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionSenaraiJabatan($kumpulan, $category, $calctype)
    {
        if ($category == 0) { //keseluruhan

            $a = Tblprcobiodata::find()
                ->joinWith('department')
                ->where(['=', 'Status', '1'])
                ->andWhere(['id' => $kumpulan])
                ->all();
        } elseif ($category == 1) { //akademik

            $a = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['=', 'Status', '1'])
                ->andWhere(['cpd_group' => $kumpulan])
                ->andWhere(['job_category' => 1])
                ->all();
        } elseif ($category == 2) { //pentadbiran

            $a = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['=', 'Status', '1'])
                ->andWhere(['cpd_group' => $kumpulan])
                ->andWhere(['job_category' => 2])
                ->all();
        }

        /** countStaff **/
        $currentYear = date('Y');

        //        $b = RptStatistikIdp::find()
        //                ->where(['tahun' => $currentYear])
        //                ->all();

        $b = RptStatistikIdpV2::find()
            ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $currentYear])
            ->all();

        $c = [];
        $d = [];
        $e = [];
        $f = [];
        foreach ($b as $bbb) {
            foreach ($a as $aaa) {
                if ($bbb->icno == $aaa->ICNO) {
                    if ($aaa->jawatan->job_category == 2) {
                        array_push($c, $bbb->icno);

                        if ($calctype == 0) { //countCapaiMin

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->jum_mata_dikira >= $bbb->idp_mata_min) {
                                    array_push($e, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 1) { //countBelumCapaiMin

                            if ($bbb->idp_mata_min != 0) {

                                if (($bbb->jum_mata_dikira < $bbb->idp_mata_min)
                                    && ($bbb->jum_mata_dikira != 0)
                                ) {
                                    array_push($e, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 2) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->jum_mata_dikira == 0) {
                                    array_push($e, $bbb->icno);
                                }
                            }
                        }
                    } elseif ($aaa->jawatan->job_category == 1) {
                        array_push($d, $bbb->icno);

                        if ($calctype == 0) { //countCapaiMin

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->jum_mata_dikira >= $bbb->idp_mata_min) {
                                    array_push($f, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 1) { //countBelumCapaiMin

                            if ($bbb->idp_mata_min != 0) {

                                if (($bbb->jum_mata_dikira < $bbb->idp_mata_min)
                                    && ($bbb->jum_mata_dikira != 0)
                                ) {
                                    array_push($f, $bbb->icno);
                                }
                            }
                        } elseif ($calctype == 2) { //countBelumAdaMata

                            if ($bbb->idp_mata_min != 0) {

                                if ($bbb->jum_mata_dikira == 0) {
                                    array_push($f, $bbb->icno);
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($calctype == 4) {
            $bb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $currentYear])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $c])
                ->orderBy('CONm');

            $bbbb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $currentYear])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $d])
                ->orderBy('CONm');
        } else {

            $bb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $currentYear])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $e])
                ->orderBy('CONm');

            $bbbb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $currentYear])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $f])
                ->orderBy('CONm');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $bb,
            'pagination' => false,
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $bbbb,
            'pagination' => false,
        ]);
        /*** /countStaff ***/

        return $this->render('senarai', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionSenarai($kumpulan, $category, $calctype, $tahun)
    {
        //            if ($category == 0){ //keseluruhan
        //
        //                $a = Tblprcobiodata::find()
        //                        ->joinWith('jawatan')
        //                        ->where(['=', 'Status', '1'])
        //                        ->andWhere(['job_group' => $kumpulan])
        //                        ->all();
        //
        //            } elseif ($category == 1) { //akademik
        //
        //                $a = Tblprcobiodata::find()
        //                        ->joinWith('jawatan')
        //                        ->where(['=', 'Status', '1'])
        //                        ->andWhere(['cpd_group' => $kumpulan])
        //                        ->andWhere(['job_category' => 1])
        //                        ->all();
        //
        //            } elseif ($category == 2){ //pentadbiran
        //
        //                $a = Tblprcobiodata::find()
        //                        ->joinWith('jawatan')
        //                        ->where(['=', 'Status', '1'])
        //                        ->andWhere(['cpd_group' => $kumpulan])
        //                        ->andWhere(['job_category' => 2])
        //                        ->all();
        //
        //            }      

        /** countStaff **/
        $currentYear = $tahun;

        $bx = RptStatistikIdpV2::find()
            ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $currentYear])
            ->all();

        $b = [];
        $c = [];
        foreach ($bx as $bxx) {

            $modelSa = Tblrscosandangan::find()
                ->where(['tblrscosandangan.id' => $bxx->sandangan_id])
                ->one();

            if ($category == 0) {
                if (
                    $modelSa
                    && ($modelSa->jawatan->job_group == $kumpulan)
                    && ($modelSa->jawatan->job_category == 2)
                ) {
                    array_push($b, $modelSa->ICNO);
                }

                if (
                    $modelSa
                    && ($modelSa->jawatan->job_group == $kumpulan)
                    && ($modelSa->jawatan->job_category == 1)
                ) {
                    array_push($c, $modelSa->ICNO);
                }
            } elseif ($category == 1) {
                if (
                    $modelSa
                    && ($modelSa->jawatan->cpd_group == $kumpulan)
                    && ($modelSa->jawatan->job_category == 1)
                ) {
                    array_push($c, $modelSa->ICNO);
                }
            } elseif ($category == 2) {
                if (
                    $modelSa
                    && ($modelSa->jawatan->cpd_group == $kumpulan)
                    && ($modelSa->jawatan->job_category == 2)
                ) {
                    array_push($b, $modelSa->ICNO);
                }
            }
        }

        //        $c = [];
        //        $d = [];
        //        $e = [];
        //        $f = [];
        //        foreach ($b as $bbb) {
        //            foreach ($a as $aaa) {
        //                if ($bbb == $aaa->ICNO) { 
        //                    if ($aaa->jawatan->job_category == 2){
        //                        array_push($c, $bbb);
        //                        
        ////                        if ($calctype == 0) { //countCapaiMin
        ////                            
        ////                                if ($bbb->idp_mata_min != 0){
        ////
        ////                                    if ($bbb->jum_mata_dikira >= $bbb->idp_mata_min){
        ////                                        array_push($e, $bbb->icno);
        ////                                        
        ////                                    } 
        ////                                }
        ////                        } elseif ($calctype == 1){ //countBelumCapaiMin
        ////                            
        ////                                if ($bbb->idp_mata_min != 0){
        ////
        ////                                    if (($bbb->jum_mata_dikira < $bbb->idp_mata_min) 
        ////                                            && ($bbb->jum_mata_dikira != 0) ){
        ////                                        array_push($e, $bbb->icno);
        ////                                    } 
        ////                                }
        ////                        } elseif ($calctype == 2){ //countBelumAdaMata
        ////                            
        ////                                if ($bbb->idp_mata_min != 0){
        ////
        ////                                    if ($bbb->jum_mata_dikira == 0){
        ////                                        array_push($e, $bbb->icno);
        ////                                    } 
        ////                                }
        ////                        }
        //                        
        //                    } 
        //                    
        //                    elseif($aaa->jawatan->job_category == 1){
        //                        array_push($d, $bbb->icno);
        //                        
        ////                        if ($calctype == 0) { //countCapaiMin
        ////                            
        ////                                if ($bbb->idp_mata_min != 0){
        ////
        ////                                    if ($bbb->jum_mata_dikira >= $bbb->idp_mata_min){
        ////                                        array_push($f, $bbb->icno);
        ////                                        
        ////                                    } 
        ////                                }
        ////                        } elseif ($calctype == 1){ //countBelumCapaiMin
        ////                            
        ////                                if ($bbb->idp_mata_min != 0){
        ////
        ////                                    if (($bbb->jum_mata_dikira < $bbb->idp_mata_min) 
        ////                                            && ($bbb->jum_mata_dikira != 0) ){
        ////                                        array_push($f, $bbb->icno);
        ////                                        //array_push($h, $aaa->gredjawatan);
        ////                                        //$h[$bbb->icno] = $aaa->id;
        ////                                    } 
        ////                                }
        ////                        } elseif ($calctype == 2){ //countBelumAdaMata
        ////                            
        ////                                if ($bbb->idp_mata_min != 0){
        ////
        ////                                    if ($bbb->jum_mata_dikira == 0){
        ////                                        array_push($f, $bbb->icno);
        ////                                    } 
        ////                                }
        ////                        }    
        //                    }    
        //                }    
        //            }
        //        }

        //                echo '<pre>' , var_dump(($c)) , '</pre>';
        //                die();

        if ($calctype == 0) { //countCapaiMin

            $bb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $b])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.status' => '2'])
                ->orderBy('CONm');

            $bbbb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $c])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.status' => '2'])
                ->orderBy('CONm');
        } elseif ($calctype == 1) {

            $bb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $b])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.status' => '1'])
                ->orderBy('CONm');

            $bbbb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $c])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.status' => '1'])
                ->orderBy('CONm');
        } elseif ($calctype == 2) {

            $bb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $b])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.status' => '0'])
                ->orderBy('CONm');

            $bbbb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $c])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.status' => '0'])
                ->orderBy('CONm');
        } elseif ($calctype == 4) {
            $bb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $currentYear])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $b])
                ->orderBy('CONm');

            $bbbb = RptStatistikIdpV2::find()
                ->joinWith('biodata')
                ->where(['tahun' => $currentYear])
                ->andWhere(['idp_rpt_statistik_idp_xpenilaian.icno' => $c])
                ->orderBy('CONm');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $bb,
            'pagination' => false,
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $bbbb,
            'pagination' => false,
        ]);
        /*** /countStaff ***/

        return $this->render('senarai', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'tahun' => $tahun
        ]);
    }

    public function actionIndexLaporanV2()
    {
        $currentYear = date('Y');

        $staffCurrentIDP = RptStatistikIdpV2::find()
            ->joinWith('biodata.jawatan')
            ->where(['tahun' => $currentYear])
            ->andWhere(['job_category' => 2])
            ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
            ->orderBy('CONm');

        $staffCurrentIDP2 = RptStatistikIdpV2::find()
            ->joinWith('biodata.jawatan')
            ->where(['tahun' => $currentYear])
            ->andWhere(['job_category' => 1])
            ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
            ->orderBy('CONm');

        $dataProvider = new ActiveDataProvider([
            'query' => $staffCurrentIDP,
            'pagination' => false,
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $staffCurrentIDP2,
            'pagination' => false,
        ]);

        if (isset(Yii::$app->request->queryParams['department'])) {
            $dataProvider->query->andFilterWhere(['DeptId' => Yii::$app->request->queryParams['department']]);
            $dataProvider2->query->andFilterWhere(['DeptId' => Yii::$app->request->queryParams['department']]);
        }

        if (isset(Yii::$app->request->queryParams['kampus'])) {
            $dataProvider->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['kampus']]);
            $dataProvider2->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['kampus']]);
        }

        if (isset(Yii::$app->request->queryParams['job_category'])) {
            $dataProvider->query->andFilterWhere(['job_category' => Yii::$app->request->queryParams['job_category']]);
            $dataProvider2->query->andFilterWhere(['job_category' => Yii::$app->request->queryParams['job_category']]);
        }

        return $this->render('index_laporan_v2', [
            'model' => $staffCurrentIDP,
            'dataProvider' => $dataProvider,
            'model2' => $staffCurrentIDP2,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionIndexLaporan()
    {
        $currentYear = date('Y');

        $staffCurrentIDP = RptStatistikIdp::find()
            ->joinWith('biodata.jawatan')
            ->where(['tahun' => $currentYear])
            ->andWhere(['job_category' => 2])
            ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
            ->orderBy('CONm');

        $dataProvider = new ActiveDataProvider([
            'query' => $staffCurrentIDP,
            'pagination' => false,
        ]);

        $staffCurrentIDP2 = RptStatistikIdp::find()
            ->joinWith('biodata.jawatan')
            ->where(['tahun' => $currentYear])
            ->andWhere(['job_category' => 1])
            ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
            ->orderBy('CONm');

        $dataProvider2 = new ActiveDataProvider([
            'query' => $staffCurrentIDP2,
            'pagination' => false,
        ]);


        if (isset(Yii::$app->request->queryParams['department'])) {
            $dataProvider->query->andFilterWhere(['DeptId' => Yii::$app->request->queryParams['department']]);
            $dataProvider2->query->andFilterWhere(['DeptId' => Yii::$app->request->queryParams['department']]);
        }

        if (isset(Yii::$app->request->queryParams['kampus'])) {
            $dataProvider->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['kampus']]);
            $dataProvider2->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['kampus']]);
        }

        if (isset(Yii::$app->request->queryParams['job_category'])) {
            $dataProvider->query->andFilterWhere(['job_category' => Yii::$app->request->queryParams['job_category']]);
            $dataProvider2->query->andFilterWhere(['job_category' => Yii::$app->request->queryParams['job_category']]);
        }

        return $this->render('index_laporan', [
            //'model' => $staffCurrentIDP,
            'dataProvider' => $dataProvider,
            //'model2' => $staffCurrentIDP2,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    /**
     * Finds the Idp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Idp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Idp::findOne(['v_co_icno' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelPesertaByDept($siriLatihanID, $dept)
    {
        if (($model = Kehadiran::find()
            ->joinWith('peserta')
            ->joinWith('sasaran9')
            ->where(['siriLatihanID' => $id, 'DeptId' => $dept])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelPenceramahSiri($siriLatihanID, $penceramahID)
    {
        if (($model = Ceramah::findOne(['siriLatihanID' => $siriLatihanID, 'penceramahID' => $penceramahID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelKursusJfpiu($id)
    {
        if (($model = KursusLatihanJfpiu::findOne(['kursusLatihanID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelLatihan($id)
    {
        if (($model = KursusLatihan::findOne(['kursusLatihanID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelLatihanLama($id)
    {
        if (($model = VCpdSenaraiLatihan::findOne(['vcsl_kod_latihan' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelLatihanLuarPohon($id)
    {
        if (($model = PermohonanKursusLuar::findOne(['permohonanID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelPermohonanMataIdpIndividu($id)
    {
        if (($model = PermohonanMataIdpIndividu::findOne(['permohonanID' => $id])) !== null) {
            return $model;
        }

        //throw new NotFoundHttpException(Yii::$app->session->setFlash('alert', ['title' => 'Ralat', 'type' => 'warning', 'msg' => 'Harap maaf. Permohonan tersebut tidak wujud.']));
        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelPeserta($id)
    {
        if (($model = Peserta::findOne(['permohonanID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelSiriLatihan($id)
    {
        if (($model = SiriLatihan::findOne(['siriLatihanID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelSiriLatihanJfpiu($id)
    {
        if (($model = SiriLatihanJfpiu::findOne(['siriLatihanID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelSlotLatihan($id)
    {
        if (($model = SlotLatihan::findOne(['slotID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelSlotJfpiu($id)
    {
        if (($model = SlotLatihanJfpiu::findOne(['slotID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelSasaranLatihan($id)
    {
        if (($model = KursusSasaran::findOne(['sasaranID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelJemputanLatihan($id)
    {
        if (($model = KursusJemputan::findOne(['jemputanID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelGredJawatan($id)
    {
        if (($model = IdpGredJawatan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelBook($id)
    {
        if (($model = Book::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelPermohonanLatihan($staffID, $kursusLatihanID)
    {

        $model = PermohonanLatihan::find()
            ->where(['staffID' => $staffID])
            ->andWhere(['kursusLatihanID' => $kursusLatihanID])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelPermohonanLatihan2($siriLatihanID, $staffID)
    {

        $model = PermohonanLatihan::find()
            ->where(['staffID' => $staffID])
            ->andWhere(['siriLatihanID' => $siriLatihanID])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelPermohonanLatihan3($siriLatihanID)
    {

        $model = PermohonanLatihan::find()
            ->where(['siriLatihanID' => $siriLatihanID])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelKehadiran($slotID, $staffID)
    {

        $model = Kehadiran::find()
            ->where(['staffID' => $staffID])
            ->andWhere(['slotID' => $slotID])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelKehadiranJfpiu($slotID, $staffID)
    {

        $model = KehadiranJfpiu::find()
            ->where(['staffID' => $staffID])
            ->andWhere(['slotID' => $slotID])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelBorangpl($siriLatihanID, $staffID)
    {

        $model = BorangPenilaianLatihan::find()
            ->where(['pesertaID' => $staffID])
            ->andWhere(['siriLatihanID' => $siriLatihanID])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelBorangpk($siriLatihanID, $staffID)
    {

        $model = BorangPenilaianKeberkesanan::find()
            ->where(['pesertaID' => $staffID])
            ->andWhere(['siriLatihanID' => $siriLatihanID])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    //    public function actionViewBook($id) {
    //        $model=$this->findModelBook($id);
    //
    //        if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //            Yii::$app->session->setFlash('kv-detail-success', 'Saved record successfully');
    //            // Multiple alerts can be set like below
    //            Yii::$app->session->setFlash('kv-detail-warning', 'A last warning for completing all data.');
    //            Yii::$app->session->setFlash('kv-detail-info', '<b>Note:</b> You can proceed by clicking <a href="#">this link</a>.');
    //            return $this->redirect(['view-book', 'id'=>$model->id]);
    //        } else {
    //            return $this->render('view_book', [
    //                'model' => $model,
    //                //'bordered' => false,
    //            ]);
    //        }
    //    }
    // Controller action
    public function actionViewBook($id)
    {
        //$model = new Book;
        $model = $this->findModelBook($id);
        $post = Yii::$app->request->post();
        // process ajax delete
        if (Yii::$app->request->isAjax && isset($post['kvdelete'])) {
            //            echo Json::encode([
            //                'success' => true,
            //                'messages' => [
            //                    'kv-detail-info' => 'The book # 1000 was successfully deleted. ' .
            //                        Html::a('<i class="fas fa-hand-right"></i>  Click here',
            //                            ['/idp/view-book'], ['class' => 'btn btn-sm btn-info']) . ' to proceed.'
            //                ]
            //            ]);
            //            return;
            //$id = $post['id'];
            if ($this->findModelBook($id)->delete()) {
                echo Json::encode([
                    'success' => true,
                    'messages' => [
                        'kv-detail-info' => 'The book # ' . $id . ' was successfully deleted. <a href="' .
                            Url::to(['/idp/view-book']) . '" class="btn btn-sm btn-info">' .
                            '<i class="glyphicon glyphicon-hand-right"></i>  Click here</a> to proceed.'
                    ]
                ]);
            } else {
                echo Json::encode([
                    'success' => false,
                    'messages' => [
                        'kv-detail-error' => 'Cannot delete the book # ' . $id . '.'
                    ]
                ]);
            }
            return;
        }
        // return messages on update of record
        if ($model->load($post) && $model->save()) {
            Yii::$app->session->setFlash('kv-detail-success', 'Success Message');
            Yii::$app->session->setFlash('kv-detail-warning', 'Warning Message');
        }
        return $this->render('view_book', ['model' => $model]);
    }

    //    public function actionDeleteBook() {
    //        $post = Yii::$app->request->post();
    //        if (Yii::$app->request->isAjax && isset($post['custom_param'])) {
    //            $id = $post['id'];
    //            if ($this->findModelBook($id)->delete()) {
    //                echo Json::encode([
    //                    'success' => true,
    //                    'messages' => [
    //                        'kv-detail-info' => 'The book # ' . $id . ' was successfully deleted. <a href="' .
    //                            Url::to(['/idp/view-book']) . '" class="btn btn-sm btn-info">' .
    //                            '<i class="glyphicon glyphicon-hand-right"></i>  Click here</a> to proceed.'
    //                    ]
    //                ]);
    //            } else {
    //                echo Json::encode([
    //                    'success' => false,
    //                    'messages' => [
    //                        'kv-detail-error' => 'Cannot delete the book # ' . $id . '.'
    //                    ]
    //                ]);
    //            }
    //            return;
    //        }
    //        throw new InvalidCallException("You are not allowed to do this operation. Contact the administrator.");
    //    }

    protected function notifikasi($icno, $content)
    {
        //--------Model Notification-----------//
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $icno;
        $ntf->title = 'MyIDP';
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save(false);
        //--------Model Notification-----------//
    }

    public function actionCarianLaporan()
    {

        $allReport = RefSenaraiLaporan::find()
            ->where(['rpt_status' => '1']);

        $dataProvider = new ActiveDataProvider([
            'query' => $allReport,
        ]);

        //        $searchModel = new TblprcobiodataSearch();
        //        if (Yii::$app->request->queryParams){  
        //            $dataProvider = $searchModel->searchstaff(Yii::$app->request->queryParams);
        //        }
        //        
        $currentYear = date('Y');
        $previousYear = date("Y", strtotime("-1 year"));

        return $this->render('carian_laporan', [
            'dataProvider' => $dataProvider,
            //'searchModel' => $searchModel,
            'currentYear' => $currentYear,
            'previousYear' => $previousYear,
        ]);
    }

    public function actionCarianStaf()
    {

        $allStaff = Tblprcobiodata::find()
            ->where(['<>', 'Status', '6']);
        //->limit(10);

        $dataProvider = new ActiveDataProvider([
            'query' => $allStaff,
            //            'pagination' => [
            //                'pageSize' => 5,
            //            ],
        ]);

        //        $dataProvider->pagination->pageSize=15;


        $searchModel = new TblprcobiodataSearch();
        if (Yii::$app->request->queryParams) {
            $dataProvider = $searchModel->searchstaff(Yii::$app->request->queryParams);
        }

        $currentYear = date('Y');
        $previousYear = date("Y", strtotime("-1 year"));

        return $this->render('carian_staf', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'currentYear' => $currentYear,
            'previousYear' => $previousYear,
            'id' => 1,
        ]);
    }

    //Cleeve's codes
    public function actionPenetapanAksesSistem()
    {
        $searchModel = new PenetapanAksesSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('akses_tetap', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTambahPenceramahDalaman($siriID)
    {

        $aksesbaru = new Ceramah(); //untuk admin baru
        if ($aksesbaru->load(Yii::$app->request->post())) {
            if (Ceramah::find()->where([
                'penceramahID' => $aksesbaru->penceramahID,
                'siriLatihanID' => $siriID
            ])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                $aksesbaru->save(false);
            }
            //return $this->redirect(['tetapan-akses']);
        }

        return $this->render('tambah_penceramah_dalaman', [
            'aksesbaru' => $aksesbaru,
            'siriID' => $siriID,
            'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname'),
        ]);
    }

    //Ida's codes
    public function actionTetapanAkses()
    {

        //        $akses = AdminJfpiu::find()
        //                ->joinWith('biodata')
        //                ->orderBy('DeptId')
        //                ->all();

        $aksesbaru = new AdminJfpiu; //untuk admin baru
        if ($aksesbaru->load(Yii::$app->request->post())) {
            if (AdminJfpiu::find()->where(['staffID' => $aksesbaru->staffID])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                $aksesbaru->date_added = date('Y-m-d');
                $aksesbaru->added_by = Yii::$app->user->getId();

                $checkStaff = Tblprcobiodata::find()
                    ->where(['ICNO' => $aksesbaru->staffID])
                    ->one();

                $aksesbaru->staff_dept_on_added = $checkStaff->DeptId;
                $aksesbaru->save(false);
            }
            return $this->redirect(['tetapan-akses']);
        }

        /*** testing codes ***/
        $searchModel = new AdminJfpiuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        /****/

        return $this->render('tetapanakses', [
            //'akses' => $akses,
            'aksesbaru' => $aksesbaru,
            'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname'),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDeleteAkses($id)
    {
        $akses = AdminJfpiu::findOne(['staffID' => $id]);
        $akses->delete();
        if ($akses->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapus data']);
        }
        //return $this->redirect(['tetapan-akses']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionTranskrip($staffChosen = null)
    {

        $user = Yii::$app->user->getId();

        if (!$staffChosen) {
            $staffChosen = $user;
        }

        $allStaff = RptStatistikIdpV2::find()
            ->where(['icno' => $staffChosen]);

        $dataProvider = new ActiveDataProvider([
            'query' => $allStaff,
        ]);

        $currentYear = date('Y');
        $previousYear = date("Y", strtotime("-1 year"));

        $modelIdp = Idp::find()
            ->where(['v_co_icno' => $staffChosen])
            ->andWhere(['<>', 'v_idp_profil.tahun', 2020]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $modelIdp,
        ]);

        $data = array_merge($dataProvider->getModels(), $dataProvider2->getModels());

        $dataProvider3 = new ArrayDataProvider([
            'allModels' => $data,
        ]);

        // get the rows in the currently requested page
        $rows = $dataProvider3->getModels();

        //               echo '<pre>' , var_dump(($rows)) , '</pre>';
        //               die();

        return $this->render('carian_staf_1', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'dataProvider3' => $dataProvider3,
            'currentYear' => $currentYear,
            'previousYear' => $previousYear,
            'id' => 2,
            //'tahun' => $tahun
        ]);

        //        return $this->render('transkrip', [
        //            'isAdmin' => $isAdmin,
        //            'tahun' => $tahun,
        //            'bil' => 1,
        //            'dept_id' => $dept_id,
        //            'model_dept' => $model_dept,
        //        ]);
    }

    // public function actionSasaranSkim($tahun = null, $dept_id = null, $id = null)
    public function actionSasaranSkim($tahun = null, $id = null, $gred_no = null)
    {

        $year = date('Y');
        if (!$tahun) {
            $tahun = $year;
        }

        $user = Yii::$app->user->getId();
        $model = Tblprcobiodata::findOne(['ICNO' => $user]);
        $greds = $model->jawatan->gred_skim;
        $gredn = $model->jawatan->gred_no;

        if (!$id && !$gred_no) {
            $id = $greds;
            $gred_no = $gredn;
        }
        $a = $id . '' . $gred_no;

        $array2 = RefCpdGroupGredJawatan::find()
            ->groupBy('gred_no')
            ->orderBy('gred_no')
            ->all();

        $model2 = GredJawatan::find()
            ->where(['in', 'gred_no', $array2])
            ->groupBy('gred_no')
            ->orderBy('gred_no')
            ->all();

        $array = RefCpdGroupGredJawatan::find()
            ->groupBy('gred_skim')
            ->orderBy('gred_skim')
            ->all();

        $model = GredJawatan::find()
            ->where(['in', 'gred_skim', $array])
            ->groupBy('gred_skim')
            ->orderBy('gred_skim')
            ->all();

        if ($tahun >= '2020') {
            $day = SiriLatihan::find()
                ->joinWith('sasaran8.jawatan.groupidp')
                ->joinWith('sasaran3')
                ->where(['idp_kursussasaran.tahun' => $tahun])
                ->andWhere(['statusKursusLatihan' => 'AKTIF', 'jenisLatihanID' => 'latihanDalaman'])
                ->andWhere(['YEAR(tarikhMula)' => $tahun])
                ->andWhere(['<>', 'idp_siriLatihan.statusSiriLatihan', 'INACTIVE'])
                ->orderBy('tarikhMula');
        } else {
            // $day = VIdpSenaraiKursus::find()
            //     ->joinWith('sasaran8.jawatan.groupidp')
            //     ->where(['v_idp_senarai_kursus.tahun_ditawarkan' => $tahun])
            //     ->orderBy('tarikhMula');

            $day = VCpdSenaraiLatihan::find()
                ->joinWith('sasaran8.jawatan.groupidp')
                ->where(['YEAR(vcsl_tkh_mula)' => $tahun])
                ->orderBy('vcsl_tkh_mula');
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $day,
            'pagination' => false,
        ]);

        if ($id) {
            $dataProvider->query->andFilterWhere(['idp_ref_cpdgroup_gredjawatan.gred_skim' => $id]);
        }

        if ($gred_no) {
            $dataProvider->query->andFilterWhere(['idp_ref_cpdgroup_gredjawatan.gred_no' => $gred_no]);
        }

        if ($tahun >= '2020') {
            return $this->render('sasaran_by_scheme', [
                'dataProvider' => $dataProvider,
                'modelSent' => $model,
                'modelSent2' => $model2,
                'tahun' => $tahun,
                'id' => $id,
                'gred_no' => $gred_no,
                'a' => $a
            ]);
        } else {
            return $this->render('sasaran_by_scheme_v2', [
                'dataProvider' => $dataProvider,
                'modelSent' => $model,
                'modelSent2' => $model2,
                'tahun' => $tahun,
                'id' => $id,
                'gred_no' => $gred_no,
                'a' => $a
            ]);
        }
    }

    public function actionLaporanIdpJabatan($tahun = null, $dept_id = null)
    {

        $icno = Yii::$app->user->getId();

        $year = date('Y');

        $isAdmin = UserAccess::find()->where(['userID' => $icno])->all();

        $model_dept = Department::find()->where(['isActive' => 1])->all();

        if (!$tahun) {
            $tahun = $year;
        }

        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

        //        $currentYear = date('Y');

        //        $staffCurrentIDP = IdpMata::find()
        //                ->joinWith('biodata.department')
        //                ->joinWith('biodata.jawatan')
        //                ->where(['DeptId' => $test->DeptId])
        //                ->andWhere(['tahun' => $currentYear])
        //                ->andWhere(['job_category' => 2])
        //                ->andWhere(['<>', 'Status', '6'])
        //                ->orderBy('CONm');

        //        $staffCurrentIDP2 = IdpMata::find()
        //                ->joinWith('biodata.department')
        //                ->joinWith('biodata.jawatan')
        //                ->where(['DeptId' => $test->DeptId])
        //                ->andWhere(['tahun' => $currentYear])
        //                ->andWhere(['job_category' => 1])
        //                ->andWhere(['<>', 'Status', '6'])
        //                ->orderBy('CONm');

        if ($tahun >= '2020') {

            /** error cross-server **/
            if (!$dept_id) {

                // $a = Tblprcobiodata::find()
                //         ->where(['DeptId' => $test->DeptId])
                //         ->andWhere(['<>', 'Status', '6'])
                //         ->all();

                /** error cross-server */
                // $aa = RptStatistikIdpV2::find()
                //     ->joinWith('penempatan')
                //     ->where(['tahun' => $tahun])
                //     ->andWhere(['dept_id' => $test->DeptId])
                //     ->all();

                $aa = RptStatistikIdpV2::find()
                    ->where(['tahun' => $tahun])
                    ->all();

                $c = [];
                $d = [];
                foreach ($aa as $aaa) {
                    if ($aaa->penempatan) {
                        if ($aaa->penempatan->dept_id == $test->DeptId) {

                            if ($aaa->sandangan) {
                                if ($aaa->sandangan->jawatan->job_category == 2) {
                                    array_push($c, $aaa->icno);
                                } elseif ($aaa->sandangan->jawatan->job_category == 1) {
                                    array_push($d, $aaa->icno);
                                }
                            }
                        }
                    }
                }
            } else {

                // $a = Tblprcobiodata::find()
                //         ->where(['DeptId' => $dept_id])
                //         ->andWhere(['<>', 'Status', '6'])
                //         ->all();

                /* error cross-server **/
                // $a = RptStatistikIdpV2::find()
                //     ->joinWith('penempatan')
                //     ->where(['tahun' => $tahun])
                //     ->andWhere(['dept_id' => $dept_id])
                //     ->all();

                $aa = RptStatistikIdpV2::find()
                    ->where(['tahun' => $tahun])
                    ->all();

                $c = [];
                $d = [];
                foreach ($aa as $aaa) {
                    if ($aaa->penempatan) {
                        if ($aaa->penempatan->dept_id == $dept_id) {
                            if ($aaa->sandangan->jawatan->job_category == 2) {
                                array_push($c, $aaa->icno);
                            } elseif ($aaa->sandangan->jawatan->job_category == 1) {
                                array_push($d, $aaa->icno);
                            }
                        }
                    }
                }
            }

            /** errro cross-server */
            // $c = [];
            // $d = [];
            //     foreach ($a as $aaa) {
            //             if ($aaa->biodata->jawatan->job_category == 2){
            //                 array_push($c, $aaa->icno);
            //             } elseif($aaa->biodata->jawatan->job_category == 1){
            //                 array_push($d, $aaa->icno);
            //             }
            //     }

            // echo '<pre>' , var_dump(count($c)) , '</pre>';
            // echo '<pre>' , var_dump(count($d)) , '</pre>';
            // die();

            //        $bb = IdpMata::find()
            //                ->joinWith('biodata')
            //                ->where(['tahun' => $tahun])
            //                ->andWhere(['staffID' => $c])
            //                ->orderBy('CONm');
            //        
            //        $bbbb = IdpMata::find()
            //                ->joinWith('biodata')
            //                ->where(['tahun' => $tahun])
            //                ->andWhere(['staffID' => $d])
            //                ->orderBy('CONm');


            $bb = RptStatistikIdp::find()
                ->joinWith('biodata')
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp.icno' => $c])
                ->andWhere(['<>', 'staf_status', '6'])
                ->orderBy('CONm');

            $bbbb = RptStatistikIdp::find()
                ->joinWith('biodata')
                ->where(['tahun' => $tahun])
                ->andWhere(['idp_rpt_statistik_idp.icno' => $d])
                ->andWhere(['<>', 'staf_status', '6'])
                ->orderBy('CONm');

            $dataProvider = new ActiveDataProvider([
                'query' => $bb,
                'pagination' => false,
                //            'sort'=> ['defaultOrder' => ['staffID' => SORT_ASC]],
            ]);

            // echo '<pre>' , var_dump(($bb)) , '</pre>';
            // die();

            $dataProvider2 = new ActiveDataProvider([
                'query' => $bbbb,
                'pagination' => false,
            ]);

            // echo '<pre>' , var_dump(($bbbb)) , '</pre>';
            // die();

            return $this->render('laporan_idp_jabatan', [
                'isAdmin' => $isAdmin,
                'tahun' => $tahun,
                'bil' => 1,
                'dataProvider' => $dataProvider,
                'dataProvider2' => $dataProvider2,
                'dept_id' => $dept_id,
                'model_dept' => $model_dept,
            ]);
        } else {

            if (!$dept_id) {

                // $aa = RptStatistikIdpLama::find()
                //     ->where(['tahun' => $tahun])
                //     ->all();

                // $c = [];
                // $d = [];
                // foreach ($aa as $aaa) {
                //     if ($aaa->sameIcno_){
                //         if ($aaa->sameIcno_->DeptId == $test->DeptId){

                //             if ($aaa->sameIcno_->kategori == 2){
                //                 array_push($c, $aaa->icno);
                //             } elseif($aaa->sameIcno_->kategori == 1){
                //                 array_push($d, $aaa->icno);
                //             }
                //         }
                //     }
                // }

                $bb = RptStatistikIdpLama::find()
                    ->joinWith('sameIcno_')
                    ->joinWith('biodata')
                    ->where(['rpt_statistik_idp.tahun' => $tahun])
                    ->andWhere(['v_idp_profil.DeptId' => $test->DeptId])
                    ->andWhere(['v_idp_profil.kategori' => 2])
                    ->orderBy('CONm');

                $bbbb = RptStatistikIdpLama::find()
                    ->joinWith('sameIcno_')
                    ->joinWith('biodata')
                    ->where(['rpt_statistik_idp.tahun' => $tahun])
                    ->andWhere(['v_idp_profil.DeptId' => $test->DeptId])
                    ->andWhere(['v_idp_profil.kategori' => 1])
                    ->orderBy('CONm');
            } else {

                // $aa = RptStatistikIdpLama::find()
                //     ->where(['tahun' => $tahun])
                //     ->all();

                // $c = [];
                // $d = [];
                // foreach ($aa as $aaa) {
                //     if ($aaa->sameIcno_){
                //         if ($aaa->sameIcno_->DeptId == $dept_id){
                //             if ($aaa->sameIcno_->kategori == 2){
                //                 array_push($c, $aaa->icno);
                //             } elseif($aaa->sameIcno_->kategori == 1){
                //                 array_push($d, $aaa->icno);
                //             }
                //         }
                //     }
                // }

                $bb = RptStatistikIdpLama::find()
                    ->joinWith('sameIcno_')
                    ->joinWith('biodata')
                    ->where(['rpt_statistik_idp.tahun' => $tahun])
                    ->andWhere(['v_idp_profil.DeptId' => $dept_id])
                    ->andWhere(['v_idp_profil.kategori' => 2])
                    ->orderBy('CONm');

                $bbbb = RptStatistikIdpLama::find()
                    ->joinWith('sameIcno_')
                    ->joinWith('biodata')
                    ->where(['rpt_statistik_idp.tahun' => $tahun])
                    ->andWhere(['v_idp_profil.DeptId' => $dept_id])
                    ->andWhere(['v_idp_profil.kategori' => 1])
                    ->orderBy('CONm');
            }

            // $bb = RptStatistikIdpLama::find()
            //         ->joinWith('biodata')
            //         ->where(['tahun' => $tahun])
            //         ->andWhere(['rpt_statistik_idp.icno' => $c])
            //         ->orderBy('CONm');

            // $bbbb = RptStatistikIdpLama::find()
            //         ->joinWith('biodata')
            //         ->where(['tahun' => $tahun])
            //         ->andWhere(['rpt_statistik_idp.icno' => $d])
            //         ->orderBy('CONm');

            $dataProvider = new ActiveDataProvider([
                'query' => $bb,
                'pagination' => false
            ]);

            // echo '<pre>' , var_dump(($bb)) , '</pre>';
            // die();

            $dataProvider2 = new ActiveDataProvider([
                'query' => $bbbb,
                'pagination' => false
            ]);

            // echo '<pre>' , var_dump(($bbbb)) , '</pre>';
            // die();

            return $this->render('laporan_idp_jabatan_v2', [
                'isAdmin' => $isAdmin,
                'tahun' => $tahun,
                'bil' => 1,
                'dataProvider' => $dataProvider,
                'dataProvider2' => $dataProvider2,
                'dept_id' => $dept_id,
                'model_dept' => $model_dept,
            ]);
        }
    }

    //testing codes
    public function actionCreate()
    {
        $model = new AdminJfpiu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->staffID]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionPendingTask()
    {
        // $searchModel = new PendingTaskSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->query->andFilterWhere(['task_menu' => 'Tindakan Urusetia']);

        // $searchModel2 = new PendingTaskSearch();
        // $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
        // $dataProvider2->query->andFilterWhere(['task_menu' => 'Tindakan Pegawai']);

        // $searchModel3 = new PendingTaskSearch();
        // $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams);
        // $dataProvider3->query->andFilterWhere(['task_menu' => 'Tindakan Sektor']);

        $modelAdmin = UserAccess::find()->where(['userID' => Yii::$app->user->getId()])->one();

        if (!$modelAdmin || $modelAdmin->usertype == "admin") {
            $userLevel = "user";
        } else {
            $userLevel = $modelAdmin->usertype;
        }

        if ($userLevel == 'ul') {

            $checkUrusetia = UrusetiaLatihan::find()->where(['userID' => Yii::$app->user->getId(), 'ul_type' => 'ketuaUrusetia'])->one();

            if ($checkUrusetia) {

                $model = PendingTask::find()
                    ->where(['task_menu' => 'Tindakan Pegawai'])
                    ->orWhere(['task_menu' => 'Tindakan Urusetia'])
                    ->andWhere(['<>', 'task_id', '1']);

                $title = "Tindakan Ketua Urusetia";
            } else {

                $model = PendingTask::find()
                    ->where(['<>', 'task_id', '1'])
                    ->andWhere(['task_menu' => 'Tindakan Urusetia']);

                $title = "Tindakan Urusetia";
            }
        } elseif ($userLevel == 'pegawaiLatihan') {

            $model = PendingTask::find()
                ->where(['<>', 'task_id', '1'])
                ->andWhere(['task_menu' => 'Tindakan Pegawai']);

            $title = "Tindakan Pegawai";
        } elseif ($userLevel == 'ketuaSektor') {

            $model = PendingTask::find()
                ->where(['<>', 'task_id', '1'])
                ->andWhere(['task_menu' => 'Tindakan Sektor']);

            $title = "Tindakan Sektor";
        } else {

            Yii::$app->session->setFlash('alert', ['title' => 'Ralat', 'type' => 'info', 'msg' => 'Harap maaf. Anda tiada akses ke halaman ini.', 'theme' => 'twitter']);
            return $this->redirect(Yii::$app->request->referrer);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('pending_task', [
            'dataProvider' => $dataProvider,
            'title' => $title, 'model' => $model
        ]);
    }
}
