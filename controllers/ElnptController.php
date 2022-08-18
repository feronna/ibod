<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use tebazil\runner\ConsoleCommandRunner;
use yii2tech\spreadsheet\Spreadsheet;
use kartik\mpdf\Pdf;
use app\models\Notification;
use app\models\elnpt\TblKumpRubrik;
use app\models\elnpt\TblKumpRubrikSearch;
use app\models\elnpt\TblKumpDept;
use app\models\elnpt\TblKumpDeptSearch;
use app\models\elnpt\elnpt2\TblKumpDept as TblKumpDeptV2;
use app\models\elnpt\elnpt2\TblKumpDeptSearchV2;
use app\models\elnpt\TblKumpGred;
use app\models\elnpt\TblKumpGredSearch;
use app\models\elnpt\RefAspekRubrik;
use app\models\elnpt\TblBhgRubrik;
use app\models\elnpt\RefAspekPenilaian;
use app\models\elnpt\TblMrkhBhg;
use app\models\elnpt\RefBahagian;
use app\models\elnpt\TblBhgKump;
use app\models\elnpt\TblLppTahun;
use app\models\elnpt\TblPenetapPenilai;
use app\models\elnpt\TblMain;
use app\models\elnpt\TblMainSearch;
use app\models\elnpt\Tblprcobiodata;
use app\models\elnpt\RefSkorAspek;
use app\models\elnpt\TblMrkhAspek;
use app\models\elnpt\TblPemberatAspek;
use app\models\elnpt\TblPemberatBhg;
use app\models\elnpt\RefPeratusKategori;
use app\models\elnpt\TblBlendedLearning;
use app\models\elnpt\TblBlendedLearningFarm;
use app\models\elnpt\TblRequest;
use app\models\elnpt\TblRequestSearch;
use app\models\elnpt\TblMarkahKeseluruhan;
use app\models\elnpt\TblAlasanSemakan;
use app\models\elnpt\TblPeratusRubrik;
use app\models\elnpt\TblSahPnp;
use app\models\elnpt\testing\TblTestingBiodataSearch;
use app\models\elnpt\testing\TblTestingAccess;
use app\models\elnpt\TblPengajaran;
use app\models\elnpt\TblPenyeliaan;
use app\models\elnpt\TblPenyeliaanManual;
use app\models\elnpt\TblPenyeliaanManualAddOn;
use app\models\elnpt\TblPenyelidikan;
use app\models\elnpt\TblPenyelidikan2;
use app\models\elnpt\TblGrantApplication;
use app\models\elnpt\TblPenyelidikanManual;
use app\models\elnpt\TblPengajaranPembelajaran;
use app\models\elnpt\RefPnpKursus;
use app\models\elnpt\TblPengesahanPnp;
use app\models\elnpt\penerbitan\TblLnptPublicationV2;
use app\models\elnpt\penerbitan\TblLnptPublication;
use app\models\elnpt\penerbitan\DboVwCVAbstract;
use app\models\elnpt\penerbitan\DboVwCVAnthology;
use app\models\elnpt\penerbitan\DboVwCVBook;
use app\models\elnpt\penerbitan\DboVwCVBookChapter;
use app\models\elnpt\penerbitan\DboVwCVCreative;
use app\models\elnpt\penerbitan\DboVwCVJournalInternational;
use app\models\elnpt\penerbitan\DboVwCVJournalNational;
use app\models\elnpt\penerbitan\DboVwCVMagazine;
use app\models\elnpt\penerbitan\DboVwCVManual;
use app\models\elnpt\penerbitan\DboVwCVModule;
use app\models\elnpt\penerbitan\DboVwCVPreUni;
use app\models\elnpt\penerbitan\DboVwCVProceedingInternational;
use app\models\elnpt\penerbitan\DboVwCVProceedingNational;
use app\models\elnpt\penerbitan\DboVwCVTechnical;
use app\models\elnpt\penerbitan\DboVwCVTextbook;
use app\models\elnpt\penerbitan\DboVwCVTranslation;
use app\models\elnpt\RefPnpWaktu;
use app\models\elnpt\TblJamWaktu;
use app\models\elnpt\RefProfAssoc;
use app\models\elnpt\inovasi\TblConference;
use app\models\elnpt\inovasi\TblPertandinganPereka;
use app\models\elnpt\inovasi\TblInovasi;
use app\models\elnpt\outreaching\TblConsultation;
use app\models\elnpt\outreaching\TblOutreachingManual;
use app\models\elnpt\TblBadanProfesional;
use app\models\elnpt\bahagian_7\TblPengurusanPentadbiran;
use app\models\elnpt\perkhidmatan_klinikal\TblConsultationClinical;
use app\models\elnpt\perkhidmatan_klinikal\TblKlinikal;
use app\models\elnpt\bahagian_9\RefKualiti;
use app\models\elnpt\bahagian_9\TblMarkahKualiti;
use app\models\elnpt\elnpt_lama\TblMarkahLama;
use app\models\elnpt\elnpt_lama\TblSupervisor;
use app\models\elnpt\elnpt_lama\TblUser;
use app\models\elnpt\Model;
use app\models\elnpt\TblCadanganApc;
use app\models\elnpt\TblException;

class ElnptController extends \yii\web\Controller
{
   public function behaviors()
   {
      return [
         'access' => [
            'class' => AccessControl::className(),
            'rules' => [
               [
                  'actions' => ['index', 'pnp-kursus-list',],
                  'allow' => true,
                  'roles' => ['@'],
               ],
               [
                  'actions' => [
                     'borang', 'arkib-borang',
                     'generate-borang'
                  ],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {

                     $dept = TblKumpDept::findOne(['dept_id' => Yii::$app->user->identity->DeptId]);
                     $gred = TblKumpGred::findOne(['gred_id' => Yii::$app->user->identity->gredJawatan]);
                     // $rubric = TblKumpRubrik::find()
                     //    ->where([ 
                     //       'kump_dept_id' => $dept->ref_kump_dept_id,
                     //       'kump_gred_id' => $gred->ref_kump_gred_id
                     //    ])
                     //    ->exists(); 
                     $rubric = TblMain::find()
                        ->where(['PYD' => Yii::$app->user->identity->ICNO])
                        ->exists();

                     if ($rubric) {
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ],
               [
                  'actions' => ['maklumat-guru'],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {
                     if (!is_null($admin = TblTestingAccess::findOne(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1]))) {




                        $penilai = Yii::$app->request->get('icno');
                        $penilaii = Yii::$app->session->get('user.penilai');
                        if ($penilai) {
                           Yii::$app->session->remove('user.penilai');
                           $tmp = $penilai;
                        } else {
                           if ($penilaii) {
                              $tmpp = \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $penilaii['ICNO']]);
                              $tmp = $tmpp->ICNO;
                           }
                        }
                        if (isset($tmp)) {
                           $this->LoginAsUser($tmp, Yii::$app->request->get('lppid'));
                        }
                     }

                     $query = TblMain::find()
                        ->where(['lpp_id' => Yii::$app->request->get('lppid')])
                        ->andWhere([
                           'or', ['PYD' => Yii::$app->user->identity->ICNO], ['PPP' => Yii::$app->user->identity->ICNO],
                           ['PPK' => Yii::$app->user->identity->ICNO], ['PEER' => Yii::$app->user->identity->ICNO]
                        ])
                        ->andWhere(['tahun' => 2019])
                        ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                        ->exists();
                     $query1 = TblTestingAccess::find()
                        ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => [1, 2]])
                        ->exists();
                     // $req = $this->checkRequest(Yii::$app->request->get('lppid')); 


                     if ($query or ($query1)) {
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ],
               [
                  'actions' => ['pengesahan-borang', 'pengesahan-pyd', 'pengesahan-ppp', 'pengesahan-ppk', 'pengesahan-peer',],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {
                     if (!is_null($admin = TblTestingAccess::findOne(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1]))) {




                        $penilai = Yii::$app->request->get('icno');
                        $penilaii = Yii::$app->session->get('user.penilai');
                        if ($penilai) {
                           Yii::$app->session->remove('user.penilai');
                           $tmp = $penilai;
                        } else {
                           if ($penilaii) {
                              $tmpp = \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $penilaii['ICNO']]);
                              $tmp = $tmpp->ICNO;
                           }
                        }
                        if (isset($tmp)) {
                           $this->LoginAsUser($tmp, Yii::$app->request->get('lppid'));
                        }
                     }

                     $query = TblMain::find()
                        ->where(['lpp_id' => Yii::$app->request->get('lppid')])
                        ->andWhere([
                           'or', ['PYD' => Yii::$app->user->identity->ICNO], ['PPP' => Yii::$app->user->identity->ICNO],
                           ['PPK' => Yii::$app->user->identity->ICNO], ['PEER' => Yii::$app->user->identity->ICNO]
                        ])
                        ->andWhere(['tahun' => 2019])
                        ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                        ->exists();
                     $query1 = TblTestingAccess::find()
                        ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])
                        ->exists();
                     $req = $this->checkRequest(Yii::$app->request->get('lppid'));


                     if ($query1 or ($query or $req)) {
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ],
               [
                  'actions' => [
                     'create-pnp', 'update-pnp', 'delete-pnp',
                     'create-penyeliaan', 'update-penyeliaan', 'delete-penyeliaan', 'create-penyelidikan', 'update-penyelidikan', 'delete-penyelidikan',
                     'create-outreaching', 'update-outreaching', 'delete-outreaching', 'create-urus-tadbir', 'update-urus-tadbir', 'delete-urus-tadbir',
                  ],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {
                     $query = TblMain::find()
                        ->where(['lpp_id' => Yii::$app->request->get('lppid')])
                        ->andWhere(['PYD' => Yii::$app->user->identity->ICNO])
                        ->andWhere(['PYD_sah' => 0])
                        ->andWhere(['tahun' => 2019])
                        ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']]);
                     $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $query->one()->tahun ?? null]);
                     $req = $this->checkRequest(Yii::$app->request->get('lppid'));


                     if (
                        $query->exists() and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)
                        or $req
                     ) {
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ],
               [
                  'actions' => [
                     'bahagian1', 'bahagian2', 'bahagian3', 'bahagian4', 'bahagian5', 'bahagian6', 'bahagian7',
                     'bahagian8', 'bahagian9', 'bahagian10', 'ringkasan',
                  ],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {
                     if (!is_null($admin = TblTestingAccess::findOne(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1]))) {
                        $u = TblMain::findOne(['lpp_id' => Yii::$app->request->get('lppid')]);
                        $this->LoginAsUser($u->PYD, Yii::$app->request->get('lppid'));
                     }
                     $query = TblMain::find()
                        ->where(['lpp_id' => Yii::$app->request->get('lppid')])
                        ->andWhere(['PYD' => Yii::$app->user->identity->ICNO])
                        ->andWhere(['tahun' => 2019])
                        ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                        ->exists();


                     if ($query) {
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ],
               [
                  'actions' => ['senarai-pyd-ppp', 'senarai-pyd-ppk', 'senarai-pyd-peer', 'rujukan-panduan'],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {
                     $penilai = TblMain::find()->where([
                        'OR', ['PPP' => Yii::$app->user->identity->ICNO],
                        ['PPK' => Yii::$app->user->identity->ICNO],
                        ['PEER' => Yii::$app->user->identity->ICNO]
                     ])->exists();


                     $query1 = TblTestingAccess::find()
                        ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])
                        ->exists();
                     if (($penilai) or $query1) {
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ],
               [
                  'actions' => ['semak-lpp'],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {

                     if (!is_null($admin = TblTestingAccess::findOne(['icno' => Yii::$app->user->identity->ICNO, 'access' => [1, 2]]))) {




                        $penilai = Yii::$app->request->get('icno');
                        $penilaii = Yii::$app->session->get('user.penilai');
                        if ($penilai) {
                           Yii::$app->session->remove('user.penilai');
                           $tmp = $penilai;
                        } else {
                           if ($penilaii) {
                              $tmpp = \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $penilaii['ICNO']]);
                              $tmp = $tmpp->ICNO;
                           }
                        }
                        if (isset($tmp)) {
                           $this->LoginAsUser($tmp, Yii::$app->request->get('lppid'));
                        }
                     }

                     $query = TblMain::find()
                        ->where(['lpp_id' => Yii::$app->request->get('lppid')])
                        ->andWhere([
                           'or', ['PPP' => Yii::$app->user->identity->ICNO],
                           ['PPK' => Yii::$app->user->identity->ICNO], ['PEER' => Yii::$app->user->identity->ICNO]
                        ])
                        ->andWhere(['tahun' => 2019])
                        ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                        ->exists();


                     $query1 = TblTestingAccess::find()
                        ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => [1, 2]])
                        ->exists();
                     $req = $this->checkRequest(Yii::$app->request->get('lppid'));
                     if ($query1 or ($query or $req)) {
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ],
               [
                  'actions' => ['tendang-pyd', 'tendang-ppp'],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {

                     if (!is_null($admin = TblTestingAccess::findOne(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1]))) {




                        $penilai = Yii::$app->request->get('icno');
                        $penilaii = Yii::$app->session->get('user.penilai');
                        if ($penilai) {
                           Yii::$app->session->remove('user.penilai');
                           $tmp = $penilai;
                        } else {
                           if ($penilaii) {
                              $tmpp = \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $penilaii['ICNO']]);
                              $tmp = $tmpp->ICNO;
                           }
                        }
                        if (isset($tmp)) {
                           $this->LoginAsUser($tmp, Yii::$app->request->get('lppid'));
                        }
                     }

                     $query = TblMain::find()
                        ->where(['lpp_id' => Yii::$app->request->get('lppid')])
                        ->andWhere([
                           'or', ['PPP' => Yii::$app->user->identity->ICNO],
                           ['PPK' => Yii::$app->user->identity->ICNO], ['PEER' => Yii::$app->user->identity->ICNO]
                        ])
                        ->andWhere(['tahun' => 2019])
                        ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                        ->exists();


                     $query1 = TblTestingAccess::find()
                        ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])
                        ->exists();
                     $req = $this->checkRequest(Yii::$app->request->get('lppid'));
                     if ($query1 or ($query or $req)) {
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ],
               [
                  'actions' => ['semak-ringkasan'],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {
                     if (!is_null($admin = TblTestingAccess::findOne(['icno' => Yii::$app->user->identity->ICNO, 'access' => [1, 2]]))) {
                        $penilai = Yii::$app->request->get('icno');
                        $penilaii = Yii::$app->session->get('user.penilai');
                        if ($penilai) {
                           Yii::$app->session->remove('user.penilai');
                           $tmp = $penilai;
                        } else {
                           if ($penilaii) {
                              $tmpp = \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $penilaii['ICNO']]);
                              $tmp = $tmpp->ICNO;
                           }
                        }
                        if (isset($tmp)) {
                           $this->LoginAsUser($tmp, Yii::$app->request->get('lppid'));
                        }
                     }
                     $query = TblMain::find()
                        ->where(['lpp_id' => Yii::$app->request->get('lppid')])
                        ->andWhere([
                           'or', ['PPP' => Yii::$app->user->identity->ICNO],
                           ['PPK' => Yii::$app->user->identity->ICNO]
                        ])
                        ->andWhere(['tahun' => 2019])
                        ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                        ->exists();


                     $query1 = TblTestingAccess::find()
                        ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])
                        ->exists();
                     $req = $this->checkRequest(Yii::$app->request->get('lppid'));
                     if ($query1 or ($query or $req)) {
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ],
               [
                  'actions' => ['penetap-penilai', 'penetap-pantau-pergerakan-borang'],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {
                     $penetap = TblPenetapPenilai::find()
                        ->leftJoin(['a' => 'hrm.elnpt_tbl_lpp_tahun'], 'a.lpp_tahun = hrm.elnpt_tbl_penetap_penilai.tahun and a.lpp_aktif = \'Y\'')
                        ->where(['penetap_icno' => Yii::$app->user->identity->ICNO])
                        ->exists();
                     if ($penetap) {
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ],
               [
                  'actions' => ['kemaskini-pegawai-penilai', 'list-penetap', 'remove-penetap-penilai', 'icno-list', 'penetap-notify-all'],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {
                     $penetap = TblPenetapPenilai::find()
                        ->leftJoin(['a' => 'hrm.elnpt_tbl_lpp_tahun'], 'a.lpp_tahun = hrm.elnpt_tbl_penetap_penilai.tahun and a.lpp_aktif = \'Y\'')
                        ->where(['penetap_icno' => Yii::$app->user->identity->ICNO])
                        ->exists();
                     $query1 = TblTestingAccess::find()
                        ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])
                        ->exists();
                     if ($penetap or $query1) {
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ],
               [
                  'actions' => [
                     'dashboard', 'carian-borang', 'run-queue'
                  ],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {
                     $query1 = TblTestingAccess::find()
                        ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => [1, 2]])
                        ->exists();
                     if ($query1) {
                        $penilai = Yii::$app->session->get('user.penilai');
                        if ($penilai) {
                           Yii::$app->session->remove('user.penilai');
                        }
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ],
               [
                  'actions' => [
                     'penetapan-tahun-penilaian', 'pendaftaran-penetap-penilai', 'senarai-cuti-belajar',
                     'buka-borang-lpp', 'buka-borang', 'kemaskini-buka-borang', 'padam-buka-borang',
                     'check-request', 'carian-borang-v2', 'carian-borang-penilai', 'generate-report', 'generate-report-v2',
                     'carian-arkib-borang', 'arkib-borang-pyd',
                     'reset-borang', 'penetapan-ppp-ppk-peer', 'pantau-pergerakan',
                     'penetapan-akses-testing', 'tambah-tahun-penilaian', 'kemaskini-tahun-penilaian',
                     'reset', 'kemaskini-penetap-penilai', 'pantau-pergerakan-borang', 'notify-all', 'akses', 'urus-status-borang', 'delete-lpp',
                     'open-lpp', 'markah-borang', 'pengesahan-markah-borang', 'generate-lpp', 'generate-markah', 'penetapan-rubrik-dept',
                     'kemaskini-rubrik-dept', 'padam-rubrik-dept', 'tambah-rubrik-dept', 'penetapan-rubrik-gred', 'kemaskini-rubrik-gred', 'padam-rubrik-gred', 'tambah-rubrik-gred',
                     'pengesahan-markah',
                     'reset-semakan',
                     'pengurusan-cadangan-apc', 'cadangan-apc', 'generate-laporan-apc', 'buang-cadangan-apc',
                     'generate-borang-admin',
                     'tambah-kump-dept', 'view', 'create', 'update', 'delete',
                     'fix-markah',
                     'delete-file'
                  ],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {
                     $query1 = TblTestingAccess::find()
                        ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])
                        ->exists();
                     if ($query1) {
                        $penilai = Yii::$app->session->get('user.penilai');
                        if ($penilai) {
                           Yii::$app->session->remove('user.penilai');
                        }
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ],
               [
                  'actions' => ['bengkel-data', 'markah-bahagian'],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback' => function ($rule, $action) {
                     $query1 = TblTestingAccess::find()
                        ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => [1, 2, 3]])
                        ->exists();
                     if ($query1) {
                        return true;
                     } else {
                        throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                     }
                  }
               ]
            ],
         ],
         'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [],
         ],
      ];
   }

   public function actionIndex()
   {
      return $this->render('index');
   }

   public function actionGenerateLpp($tahun)
   {
      $output = '';
      $runner = new ConsoleCommandRunner();
      $runner->run('elnpt/mohon-lpp', [$tahun]);
      $output = $runner->getOutput();
      \Yii::$app->session->setFlash('alert', ['title' => 'Message', 'type' => 'info', 'msg' => $output]);
      return $this->redirect('penetapan-tahun-penilaian');
   }

   public function actionGenerateMarkah($tahun)
   {
      $output = '';
      $runner = new ConsoleCommandRunner();
      $runner->run('elnpt/generate-markah', [$tahun]);
      $output = $runner->getOutput();
      \Yii::$app->session->setFlash('alert', ['title' => 'Message', 'type' => 'info', 'msg' => $output]);
      return $this->redirect('penetapan-tahun-penilaian');
   }

   public function actionBorang()
   {
      $query = TblMain::find()
         ->innerJoin('hrm.elnpt_tbl_lpp_tahun th', 'th.lpp_tahun = elnpt_tbl_main.tahun')
         ->where(['is_deleted' => 0])
         ->andWhere(['PYD' => Yii::$app->user->identity->ICNO])
         ->andWhere(['LIKE', 'th.lpp_aktif', 'y'])
         ->orderBy(['hrm.elnpt_tbl_main.tahun' => SORT_DESC]);
      $dataProvider = new ActiveDataProvider([
         'query' => $query,
         'sort' => false,
      ]);
      return $this->render('borang_guru', [
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionArkibBorang()
   {
      $markah_baru = TblMain::find()
         ->select([
            'hrm.elnpt_tbl_main.tahun', new Expression('a.`CONm` AS PPP'), new Expression('b.`CONm` AS PPK'),
            new Expression('c.`CONm` AS PEER'), 'd.`markah` as purata',
            new Expression('COALESCE (hrm.elnpt_tbl_main.catatan, \'\')'), 'hrm.elnpt_tbl_main.PPP_sah', 'hrm.elnpt_tbl_main.PPK_sah', 'PEER_sah'
         ])
         ->leftJoin(['d' => '`hrm`.`elnpt_tbl_mrkh_keseluruhan`'], 'd.`lpp_id` = `hrm`.`elnpt_tbl_main`.`lpp_id`')
         ->leftJoin(['a' => '`hronline`.`tblprcobiodata`'], 'a.`ICNO` = `hrm`.`elnpt_tbl_main`.`PPP`')
         ->leftJoin(['b' => '`hronline`.`tblprcobiodata`'], 'b.`ICNO` = `hrm`.`elnpt_tbl_main`.`PPK`')
         ->leftJoin(['c' => '`hronline`.`tblprcobiodata`'], 'c.`ICNO` = `hrm`.`elnpt_tbl_main`.`PEER`')
         ->andWhere(['`hrm`.`elnpt_tbl_main`.PYD' => Yii::$app->user->identity->ICNO, '`hrm`.`elnpt_tbl_main`.is_deleted' => 0])
         // ->having(['>', 'COUNT(*)', 0])
         ->orderBy(['`hrm`.`elnpt_tbl_main`.tahun' => SORT_DESC])
         ->asArray()
         ->all();
      $markah_lama = TblMarkahLama::find()
         ->select([
            '`hrm`.`elnpt_markah`.`tahun` as tahun', 's2.`nama_staf` as PPP', 's3.`nama_staf` as PPK', new Expression('null as PEER'),
            '`hrm`.`elnpt_markah`.`purata` AS purata', '`s1`.`catatan` as catatan', new Expression('1 as PPP_sah'), new Expression('1 as PPK_sah'), new Expression('1 as PEER_sah')
         ])
         ->leftJoin(['s4' => '`hrm`.`elnpt_user`'], 's4.`staff_id` = `hrm`.`elnpt_markah`.`staff_id`')
         ->leftJoin(['s1' => '`hrm`.`elnpt_supervisor`'], 's1.`staff_id` = `hrm`.`elnpt_markah`.`staff_id` AND s1.`tahun` = `hrm`.`elnpt_markah`.`tahun`')
         ->leftJoin(['s2' => '`hrm`.`elnpt_user`'], 's2.`staff_id` = s1.`ppp_id`')
         ->leftJoin(['s3' => '`hrm`.`elnpt_user`'], 's3.`staff_id` = s1.`ppk_id`')
         ->orderBy(['tahun' => SORT_DESC])
         ->where(['s4.`user_id`' => Yii::$app->user->identity->ICNO])
         ->asArray()
         ->all();
      $list = array_merge($markah_baru, $markah_lama);
      return $this->render('arkib_borang', [
         'data' => $list,
      ]);
   }

   public function actionCarianArkibBorang()
   {
      // \yii\helpers\Url::remember();
      $searchModel = new \app\models\elnpt\TblprcobiodataSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      return $this->render('carian_arkib', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionArkibBorangPyd($icno)
   {
      $markah_baru = TblMain::find()
         ->select([
            'hrm.elnpt_tbl_main.tahun', new Expression('a.`CONm` AS PPP'), new Expression('b.`CONm` AS PPK'),
            new Expression('c.`CONm` AS PEER'), 'd.`markah` as purata',
            new Expression('COALESCE (hrm.elnpt_tbl_main.catatan, \'\')'), 'hrm.elnpt_tbl_main.PPP_sah', 'hrm.elnpt_tbl_main.PPK_sah', 'PEER_sah'
         ])
         ->leftJoin(['d' => '`hrm`.`elnpt_tbl_mrkh_keseluruhan`'], 'd.`lpp_id` = `hrm`.`elnpt_tbl_main`.`lpp_id`')
         ->leftJoin(['a' => '`hronline`.`tblprcobiodata`'], 'a.`ICNO` = `hrm`.`elnpt_tbl_main`.`PPP`')
         ->leftJoin(['b' => '`hronline`.`tblprcobiodata`'], 'b.`ICNO` = `hrm`.`elnpt_tbl_main`.`PPK`')
         ->leftJoin(['c' => '`hronline`.`tblprcobiodata`'], 'c.`ICNO` = `hrm`.`elnpt_tbl_main`.`PEER`')
         ->andWhere(['`hrm`.`elnpt_tbl_main`.PYD' => $icno, '`hrm`.`elnpt_tbl_main`.is_deleted' => 0])
         // ->having(['>', 'COUNT(*)', 0])
         ->orderBy(['`hrm`.`elnpt_tbl_main`.tahun' => SORT_DESC])
         ->asArray()
         ->all();
      $markah_lama = TblMarkahLama::find()
         ->select([
            '`hrm`.`elnpt_markah`.`tahun` as tahun', 's2.`nama_staf` as PPP', 's3.`nama_staf` as PPK', new Expression('null as PEER'),
            '`hrm`.`elnpt_markah`.`purata` AS purata', '`s1`.`catatan` as catatan', new Expression('1 as PPP_sah'), new Expression('1 as PPK_sah'), new Expression('1 as PEER_sah')
         ])
         ->leftJoin(['s4' => '`hrm`.`elnpt_user`'], 's4.`staff_id` = `hrm`.`elnpt_markah`.`staff_id`')
         ->leftJoin(['s1' => '`hrm`.`elnpt_supervisor`'], 's1.`staff_id` = `hrm`.`elnpt_markah`.`staff_id` AND s1.`tahun` = `hrm`.`elnpt_markah`.`tahun`')
         ->leftJoin(['s2' => '`hrm`.`elnpt_user`'], 's2.`staff_id` = s1.`ppp_id`')
         ->leftJoin(['s3' => '`hrm`.`elnpt_user`'], 's3.`staff_id` = s1.`ppk_id`')
         ->orderBy(['tahun' => SORT_DESC])
         ->where(['s4.`user_id`' => $icno])
         ->asArray()
         ->all();
      $list = array_merge($markah_baru, $markah_lama);
      return $this->renderAjax('_arkibBorang', [
         'data' => $list,
      ]);
   }

   public function actionMaklumatGuru($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $query = TblMain::find()
         ->leftJoin('hrm.elnpt_tbl_lpp_tahun th', 'th.lpp_tahun = elnpt_tbl_main.tahun')



         ->andWhere(['lpp_id' => $lppid])
         ->one();
      if ($query === null) {
         throw new \yii\base\UserException('Sila buat permohonan borang terlebih dahulu.');
      }
      return $this->render('mklmt_guru', [
         'lpp' => $lpp,
         'lppid' => $lppid,
         'query' => $query,
         'menu' => $this->menuBahagian2($lppid),
      ]);
   }

   public function actionBahagian1($lppid)
   {
      $nama = RefBahagian::findOne(1);
      $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();
      $this->dataBahagian1(
         $lppid,
         Yii::$app->user->identity->ICNO,
         $tahun->lpp_tahun,
         $pengajaran,
         $pengajaran2,
         $pengajaran3,
         $blended
      );

      $list = $pengajaran2 + $pengajaran3;

      $url_create = Url::to(['elnpt/create-pnp', 'lppid' => $lppid]);

      if (($waktu = TblJamWaktu::find()->where(['lpp_id' => $lppid])->indexBy('ref_id')->all()) != null) {
         $waktu = TblJamWaktu::find()->where(['lpp_id' => $lppid])->indexBy('ref_id')->all();
      } else {
         $waktu = [new TblJamWaktu()];
         for ($i = 0; $i < sizeof($pengajaran); $i++) {
            $waktu[$i] = new TblJamWaktu();
            $waktu[$i]->lpp_id = $lppid;
            $waktu[$i]->ref_id = $pengajaran[$i]['AutoId'];
            $waktu[$i]->save(false);
         }
      }
      if (Model::loadMultiple($waktu, Yii::$app->request->post())) {
         $valid =  Model::validateMultiple($waktu);
         if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
               foreach ($waktu as $wk) {
                  if (!($flag = $wk->save(false))) {
                     $transaction->rollBack();
                     break;
                  }
               }
               if ($flag) {
                  $transaction->commit();
                  \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                  return $this->redirect(['bahagian1', 'lppid' => $lppid]);
               }
            } catch (Exception $e) {
               $transaction->rollBack();
            }
         }
      }
      $sk = array();
      $new_pemberat = array();
      $pemberat = TblJamWaktu::find()->where(['lpp_id' => $lppid, 'jenis_syarahan' => 0,])->indexBy('ref_id')->asArray()->all();
      $berat_s = RefPnpWaktu::find()->where(['ref_jenis_pnp' => 1])->asArray()->all();
      $berat_t = RefPnpWaktu::find()->where(['ref_jenis_pnp' => 2])->asArray()->all();
      $berat_m = RefPnpWaktu::find()->where(['ref_jenis_pnp' => 3])->asArray()->all();
      foreach ($pemberat as $pb => $bp) {
         foreach ($bp as $bb => $bbb) {
            switch (substr($bb, -1)) {
               case 's':
                  foreach (array_reverse($berat_s) as $bs => $sb) {
                     if ($bbb >= $sb['bil_pelajar']) {
                        $new_pemberat[$pb][$bb] = $sb[substr($bb, 0, -2)];
                        break;
                     }
                  }
               case 't':
                  foreach (array_reverse($berat_t) as $bs => $sb) {
                     if ($bbb >= $sb['bil_pelajar']) {
                        $new_pemberat[$pb][$bb] = $sb[substr($bb, 0, -2)];
                        break;
                     }
                  }
               case 'm':
                  foreach (array_reverse($berat_m) as $bs => $sb) {
                     if ($bbb >= $sb['bil_pelajar']) {
                        $new_pemberat[$pb][$bb] = $sb[substr($bb, 0, -2)];
                        break;
                     }
                  }
            }
         }
      }
      $pmberat =  TblJamWaktu::find()
         ->select(['ref_id', 'waktu_perdana_s', 'waktu_malam_s', 'hujung_minggu_s', 'waktu_perdana_t', 'waktu_malam_t', 'hujung_minggu_t', 'waktu_perdana_m', 'waktu_malam_m', 'hujung_minggu_m'])
         ->where(['lpp_id' => $lppid, 'jenis_syarahan' => 0,])->indexBy('ref_id')->asArray()->all();
      $tchFile = TblJamWaktu::find()->where(['lpp_id' => $lppid, 'jenis_syarahan' => 0,])->sum('teaching_file');

      $ps = array();
      $sum_ks = 0;
      $sum_ps = 0;
      foreach ($pmberat as $key => $price) {
         foreach ($price as $keyy => $pr) {
            if ($keyy == 'ref_id') {
               continue;
            }
            $ps[$key][$keyy] = $pr * $new_pemberat[$key][$keyy];
            $sum_ks = $sum_ks + $pr;
            $sum_ps = $sum_ps + $ps[$key][$keyy];
         }
      }

      $bks = ($sum_ks / 28) + ($sum_ps / 28);
      $sk['Beban_Kerja_Syarahan']['skor'] = $bks;
      $sk['Teaching_File']['skor'] = $tchFile;
      $sk['Blended_Learning']['skor'] = array_sum(ArrayHelper::getColumn($list, 'status'));
      $rubric_arry = \yii\helpers\ArrayHelper::toArray($this->findRubric(1, $lppid), [], false);
      $subpro = array();
      foreach ($rubric_arry as $arry) {
         $subpro[$arry['aspek']][] = $arry;
      }
      $subpro1 = array();
      foreach ($rubric_arry as $arry) {
         $subpro1[$arry['desc']][] = $arry;
      }
      if (empty($subpro1)) {
         throw new NotFoundHttpException('The requested page does not exist.');
      }

      $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid), [], false);

      $mrkh = array();
      $cntt = 0;
      foreach ($sk as $ind11 => $skk) {
         $sss = str_replace('_', ' ', $ind11);
         foreach ($subpro as $ind => $sub) {
            if ($ind == $sss) {
               $rev = array_reverse($sub);
               foreach ($rev as $bs) {
                  if ($skk['skor'] >= $bs['threshold']) {
                     $mrkh[$cntt]['aspek_id'] = $bs['aspek_id'];
                     $mrkh[$cntt]['skor'] = $bs['skor'];
                     $berat = \yii\helpers\ArrayHelper::toArray($this->findMarkahPemberat($bs['aspek_id'], $lppid), [], false);
                     $mrkh[$cntt]['markah_pyd'] = $bs['peratus'] * ($berat['pemberat'] / 100);
                     break;
                  }
               }
            }
         }
         $cntt++;
      }

      if (
         TblMrkhAspek::find()

         ->where(['bhg_no' => 1, 'lpp_id' => $lppid])
         ->all() != null
      ) {
         $models = TblMrkhAspek::find()
            ->rightJoin('`hrm`.`elnpt_ref_aspek_penilaian`', '`hrm`.`elnpt_ref_aspek_penilaian`.`id` =  `hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id`'
               . ' and `lpp_id` = ' . $lppid)
            ->where(['`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`' => 1])
            ->indexBy('aspek_id')
            ->orderBy('aspek_id')
            ->all();
      } else {
         $models = [new TblMrkhAspek()];
         for ($i = 1; $i < sizeof($pengajaran); $i++) {
            $models[] = new TblMrkhAspek();
         }
      }


      $check = array_values(array_unique(ArrayHelper::getColumn($rubric_arry, 'aspek_id')));
      foreach ($check as $ind => $ch) {
         if (in_array($ch, ArrayHelper::getColumn($mrkh, 'aspek_id'))) {
            continue;
         } else {
            array_push($mrkh, [
               'aspek_id' => $ch,
               'skor' => 0,
               'markah_pyd' => 0,
            ]);
         }
      }
      usort($mrkh, function ($a, $b) {
         return $a['aspek_id'] <=> $b['aspek_id'];
      });
      $cnt = 0;
      foreach ($models as $ii => $model) {



         if (is_null($model->id)) {
            $model = new TblMrkhAspek();
         }
         $model->lpp_id = $lppid;
         $model->bhg_no = 1;
         $model->aspek_id = $mrkh[$cnt]['aspek_id'];
         $model->skor = $mrkh[$cnt]['skor'];
         $model->markah_pyd = $mrkh[$cnt]['markah_pyd'];
         $model->save(false);
         $cnt++;
      }

      $mrkh_bhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(1, $lppid), [], false);
      $this->calcOverallMark($lppid);

      return $this->render('bahagian', [
         'lppid' => $lppid,
         'data' => $list,
         'data2' => null,
         'input' => $waktu,
         'rubric' => $subpro1,
         'mrkh_all' => $mrkh_all,
         'pemberat' => $this->findPemberatBahagian($lppid),
         'mrkh_bhg' => $mrkh_bhg,
         'bhgian' => $nama,
         'menu' => $this->menuBahagian($lppid),
         'url_create' => $url_create,
         'lpp' => \app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]),
         'req' => $this->checkRequest($lppid)
      ]);
   }

   public function actionCreatePnp($lppid)
   {
      $pnp = new TblPengajaranPembelajaran();
      $waktu = new TblJamWaktu();
      if ($pnp->load(Yii::$app->request->post())) {
         $pnp->lpp_id = $lppid;
         if ($pnp->validate() && $pnp->save(false)) {
            $waktu->ref_id = $pnp->id;
            $waktu->lpp_id = $lppid;
            if ($waktu->validate() && $waktu->save(false)) {
               \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
               return $this->redirect(['elnpt/bahagian1', 'lppid' => $lppid]);
            }
         }
      }
      return $this->renderAjax('create_bhg1', [
         'pnp' => $pnp,
      ]);
   }

   public function actionUpdatePnp($id, $lppid)
   {
      $pnp = TblPengajaranPembelajaran::findOne($id);
      if (!$pnp) {
         throw new NotFoundHttpException("The requested page does not exist.");
      }
      if ($pnp->load(Yii::$app->request->post())) {
         if ($pnp->validate() && $pnp->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
            return $this->redirect(['elnpt/bahagian1', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('create_bhg1', [
         'pnp' => $pnp,
      ]);
   }

   public function actionDeletePnp($id, $lppid)
   {
      $pnp = TblPengajaranPembelajaran::findOne($id);
      $waktu = TblJamWaktu::find()->where(['ref_id' => $id])->one();
      if (!$pnp) {
         throw new NotFoundHttpException("The requested page does not exist.");
      }
      $pnp->delete();
      $waktu->delete();
      \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
      return $this->redirect(['elnpt/bahagian1', 'lppid' => $lppid]);
   }

   public function actionPnpKursusList()
   {
      $out = [];
      if (isset($_POST['depdrop_parents'])) {
         $parents = $_POST['depdrop_parents'];
         if ($parents != null) {
            $cat_id = $parents[0];
            $out = RefPnpKursus::find()
               ->select('distinct(NamaSubjekBI) as id, NamaSubjekBI as name, KodSubjek')

               ->where(['KodSubjek' => $cat_id])
               ->asArray()
               ->all();
            return Json::encode(['output' => $out, 'selected' => '']);
         }
      }
      return Json::encode(['output' => $out, 'selected' => '']);
   }

   public function actionBahagian2($lppid)
   {
      $nama = RefBahagian::findOne(2);
      $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();
      $url_create = Url::to(['elnpt/create-penyeliaan', 'lppid' => $lppid]);
      $this->dataBahagian2(
         $lppid,
         Yii::$app->user->identity->ICNO,
         $tahun->lpp_tahun,
         $data,
         $init,
         $addon,
         $utama_telah,
         $utama_belum,
         $sama_telah,
         $sama_belum
      );
      if (($selia = TblPenyeliaanManual::findOne(['lpp_id' => $lppid])) != null) {
         $selias = TblPenyeliaanManual::findAll(['lpp_id' => $lppid]);
         $selia2 = TblPenyeliaanManual::find()
            ->select(new Expression('tahap_penyeliaan as LevelPengajian, utama_telah, utama_belum, sama_telah, sama_belum'))
            ->where(['lpp_id' => $lppid])
            ->asArray()
            ->all();
      } else {
         $selias = [new TblPenyeliaanManual()];
         for ($i = 0; $i < 1; $i++) {
            $selias[] = new TblPenyeliaanManual();
         }
         $selia2 = array();
      }
      if (Model::loadMultiple($selias, Yii::$app->request->post())) {
         $valid =  Model::validateMultiple($selias);
         if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
               foreach ($selias as $wk) {
                  $wk->lpp_id = $lppid;
                  if (!($flag = $wk->save(false))) {
                     $transaction->rollBack();
                     break;
                  }
               }
               if ($flag) {
                  $transaction->commit();
                  \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                  return $this->redirect(['bahagian2', 'lppid' => $lppid]);
               }
            } catch (Exception $e) {
               $transaction->rollBack();
            }
         }
      }
      $list = array_merge($addon, $utama_telah, $utama_belum, $sama_telah, $sama_belum, $selia2);
      $dataProvider = new ActiveDataProvider([
         'query' => $data,
         'pagination' => [
            'pageSize' => 10,
         ],
      ]);

      $finalArray = array();
      foreach ($list as $m) {
         if (!isset($finalArray[$m['LevelPengajian']]))
            $finalArray[$m['LevelPengajian']] = $m;
         else {
            $finalArray[$m['LevelPengajian']]['utama_telah'] += (int)$m['utama_telah'];
            $finalArray[$m['LevelPengajian']]['utama_belum'] += (int)$m['utama_belum'];
            $finalArray[$m['LevelPengajian']]['sama_telah'] += (int)$m['sama_telah'];
            $finalArray[$m['LevelPengajian']]['sama_belum'] += (int)$m['sama_belum'];
            $finalArray[$m['LevelPengajian']]['utama_telah'] = (string)$finalArray[$m['LevelPengajian']]['utama_telah'];
            $finalArray[$m['LevelPengajian']]['utama_belum'] = (string)$finalArray[$m['LevelPengajian']]['utama_belum'];
            $finalArray[$m['LevelPengajian']]['sama_telah'] = (string)$finalArray[$m['LevelPengajian']]['sama_telah'];
            $finalArray[$m['LevelPengajian']]['sama_belum'] = (string)$finalArray[$m['LevelPengajian']]['sama_belum'];
         }
      }
      $finalArray = array_values($finalArray);
      foreach ($init as $in) {
         if (array_search($in['LevelPengajian'], array_column($finalArray, 'LevelPengajian')) === false) {
            $finalArray[$in['LevelPengajian']] = $in;
         }
      }
      $list2 = array_values($finalArray);

      $mrkh_bhg1 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(2, $lppid), [], false);
      if (
         TblMrkhAspek::find()

         ->where(['bhg_no' => 2, 'lpp_id' => $lppid])
         ->all() != null
      ) {
         $models = TblMrkhAspek::find()
            ->rightJoin('`hrm`.`elnpt_ref_aspek_penilaian`', '`hrm`.`elnpt_ref_aspek_penilaian`.`id` =  `hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id`'
               . ' and `lpp_id` = ' . $lppid)
            ->where(['`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`' => 2])
            ->indexBy('aspek_id')
            ->orderBy('aspek_id')
            ->all();
      } else {
         $models = [new TblMrkhAspek()];
         for ($i = 1; $i < sizeof($mrkh_bhg1); $i++) {
            $models[] = new TblMrkhAspek();
         }
      }
      $skor = RefAspekPenilaian::find()
         ->select('aspek, sub_aspek, pemberat')
         ->leftJoin('hrm.elnpt_ref_skor_aspek b', '`b`.`aspek_id` = `hrm`.`elnpt_ref_aspek_penilaian`.`id`')
         ->where(['bhg_no' => 2])
         ->asArray()
         ->all();
      $skor2 = array();
      foreach ($skor as $ind => $ss) {
         $skor2[$ss['aspek']][$ind]['aspek'] = $ss['sub_aspek'];
         $skor2[$ss['aspek']][$ind]['pemberat'] = $ss['pemberat'];
      }

      $sk = array();
      foreach ($list2 as $ind => $arry) {


         switch ($arry['LevelPengajian']) {
            case 'PHD':
               $arry['LevelPengajian'] = 'Penyeliaan PhD';
               break;
            case 'M.Phil.':
               $arry['LevelPengajian'] = 'Penyeliaan PhD';
               break;
            case 'MASTER':
               $arry['LevelPengajian'] = 'Penyeliaan sarjana';
               break;
            case 1:
               $arry['LevelPengajian'] = 'Penyeliaan sarjana';
               break;
            case 2:
               $arry['LevelPengajian'] = 'Sarjana Muda';
               break;
            case 'PhD (Penyelidikan)':
               $arry['LevelPengajian'] = 'Penyeliaan PhD';
               break;
            case 'Sarjana (Penyelidikan)':
               $arry['LevelPengajian'] = 'Penyeliaan sarjana';
               break;
            case 'DrPH':
               $arry['LevelPengajian'] = 'Penyeliaan PhD';
               break;
         }

         $skorrr = 0;
         foreach ($skor2[$arry['LevelPengajian']] as $s22) {

            $skorrr += $s22['pemberat'] * $arry[$s22['aspek']];
         }

         if (!isset($sk[$arry['LevelPengajian']])) {
            $sk[$arry['LevelPengajian']]['skor'] = $skorrr;
         } else {
            $sk[$arry['LevelPengajian']]['skor'] += $skorrr;
         }
      }

      $rubric_arry = \yii\helpers\ArrayHelper::toArray($this->findRubric(2, $lppid), [], false);
      $subpro = array();
      foreach ($rubric_arry as $arry) {
         $subpro[$arry['aspek']][] = $arry;
      }
      $subpro1 = array();
      foreach ($rubric_arry as $arry) {
         $subpro1[$arry['desc']][] = $arry;
      }
      if (empty($subpro1)) {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid), [], false);
      $mrkh = array();
      $cntt = 0;

      foreach ($sk as $ind11 => $skk) {
         $ind11 = str_replace('_', ' ', $ind11);
         foreach ($subpro as $ind => $sub) {
            if ($ind == $ind11) {
               $rev = array_reverse($sub);
               foreach ($rev as $bs) {
                  if ($skk['skor'] >= $bs['threshold']) {
                     $mrkh[$cntt]['aspek_id'] = $bs['aspek_id'];
                     $mrkh[$cntt]['skor'] = $bs['skor'];
                     $berat = \yii\helpers\ArrayHelper::toArray($this->findMarkahPemberat2($bs['aspek_id'], $lppid), [], false);
                     $mrkh[$cntt]['markah_pyd'] = $bs['peratus'] * ($berat['pemberat'] / 100);
                     break;
                  }
               }
            }
         }
         $cntt++;
      }

      $check = array_values(array_unique(ArrayHelper::getColumn($rubric_arry, 'aspek_id')));
      foreach ($check as $ind => $ch) {
         if (in_array($ch, ArrayHelper::getColumn($mrkh, 'aspek_id'))) {
            continue;
         } else {
            array_push($mrkh, [
               'aspek_id' => $ch,
               'skor' => 0,
               'markah_pyd' => 0,
            ]);
         }
      }
      usort($mrkh, function ($a, $b) {
         return $a['aspek_id'] <=> $b['aspek_id'];
      });
      $cnt = 0;
      foreach ($models as $ii => $model) {



         if (is_null($model->id)) {
            $model = new TblMrkhAspek();
         }
         $model->lpp_id = $lppid;
         $model->bhg_no = 2;
         $model->aspek_id = $mrkh[$cnt]['aspek_id'];
         $model->skor = $mrkh[$cnt]['skor'];
         $model->markah_pyd = $mrkh[$cnt]['markah_pyd'];
         $model->save(false);
         $cnt++;
      }
      $mrkh_bhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian2(2, $lppid), [], false);
      $this->calcOverallMark($lppid);

      return $this->render('bahagian', [
         'lppid' => $lppid,
         'data' => $list2,
         'data2' => $dataProvider,
         'input' => $selias,
         'rubric' => $subpro1,
         'mrkh_all' => $mrkh_all,
         'pemberat' => $this->findPemberatBahagian($lppid),
         'mrkh_bhg' => $mrkh_bhg,
         'bhgian' => $nama,
         'menu' => $this->menuBahagian($lppid),
         'url_create' => $url_create,
         'lpp' => \app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]),
         'req' => $this->checkRequest($lppid)
      ]);
   }

   public function actionCreatePenyeliaan($lppid)
   {
      $addon = new TblPenyeliaanManualAddOn();
      if ($addon->load(Yii::$app->request->post())) {
         $addon->lpp_id = $lppid;
         if ($addon->save()) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
            return $this->redirect(['elnpt/bahagian2', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('create_bhg2', [
         'pnp' => $addon,
      ]);
   }

   public function actionUpdatePenyeliaan($id, $lppid)
   {
      $addon = TblPenyeliaanManualAddOn::findOne($id);
      if (!$addon) {
         throw new NotFoundHttpException("The requested page does not exist.");
      }
      if ($addon->load(Yii::$app->request->post())) {
         if ($addon->validate() && $addon->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
            return $this->redirect(['elnpt/bahagian2', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('create_bhg2', [
         'pnp' => $addon,
      ]);
   }

   public function actionDeletePenyeliaan($id, $lppid)
   {
      $addon = TblPenyeliaanManualAddOn::find()
         ->where(['id' => $id, 'lpp_id' => $lppid])
         ->one();
      if (!$addon) {
         throw new NotFoundHttpException("The requested page does not exist.");
      }
      if ($addon->delete()) {
         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
         return $this->redirect(['elnpt/bahagian2', 'lppid' => $lppid]);
      }
   }

   public function actionBahagian3($lppid)
   {
      $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      $nama = RefBahagian::findOne(3);
      $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();
      $url_create = Url::to(['elnpt/create-penyelidikan', 'lppid' => $lppid]);
      $this->dataBahagian3($lppid, Yii::$app->user->identity->ICNO, $tahun->lpp_tahun, $list, $penyelidikan2, $grant);
      $penyelidikan = array_merge($list, $penyelidikan2);

      $mrkh_bhg1 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(3, $lppid), [], false);
      if (
         TblMrkhAspek::find()

         ->where(['bhg_no' => 3, 'lpp_id' => $lppid])
         ->all() != null
      ) {
         $models = TblMrkhAspek::find()
            ->rightJoin('`hrm`.`elnpt_ref_aspek_penilaian`', '`hrm`.`elnpt_ref_aspek_penilaian`.`id` =  `hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id`'
               . ' and `lpp_id` = ' . $lppid)
            ->where(['`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`' => 3])
            ->indexBy('aspek_id')
            ->orderBy('aspek_id')
            ->all();
      } else {
         $models = [new TblMrkhAspek()];
         for ($i = 1; $i < sizeof($mrkh_bhg1); $i++) {
            $models[] = new TblMrkhAspek();
         }
      }
      $skor = RefAspekPenilaian::find()
         ->select('aspek, sub_aspek, pemberat')
         ->leftJoin('hrm.elnpt_ref_skor_aspek b', '`b`.`aspek_id` = `hrm`.`elnpt_ref_aspek_penilaian`.`id`')
         ->where(['bhg_no' => 3])
         ->asArray()
         ->all();
      $skor2 = array();
      foreach ($skor as $ind => $ss) {
         $skor2[$ss['aspek']][$ind]['aspek'] = $ss['sub_aspek'];
         $skor2[$ss['aspek']][$ind]['pemberat'] = $ss['pemberat'];
      }

      $sk = array();
      foreach ($penyelidikan as $ind => $arry) {
         foreach ($arry as $key => $t) {
            foreach ($skor2 as $ind1 => $s) {
               $s1 = str_replace(' ', '_', $ind1);
               if ($key == $s1) {
                  foreach ($s as $s22) {
                     if ($s22['aspek'] == 'Ketua') {
                        $s22['aspek'] = 'Leader';
                     }
                     if ($s22['aspek'] == 'Ahli') {
                        $s22['aspek'] = 'Member';
                     }
                     if ($s1 == 'Status_geran') {
                        switch ($arry[$s1]) {
                           case 'Sedang Berjalan':
                              if ($arry['ExtraDuration'] == 0) {
                                 $arry[$s1] = 'Sedang Berjalan dan Belum Perlanjutan';
                              } else if ($arry['ExtraDuration'] > 0) {
                                 $arry[$s1] = 'Sedang Berjalan dan Telah Perlanjutan';
                              }
                              break;
                           case 'Selesai':
                              if ($arry['ExtraDuration'] == 0) {
                                 $arry[$s1] = 'Tamat Tanpa Perlanjutan';
                              } else if ($arry['ExtraDuration'] > 0) {
                                 $arry[$s1] = 'Tamat Setelah Perlanjutan';
                              }
                              break;
                        }
                     }
                     if ($s22['aspek'] == $arry[$s1]) {
                        if (empty($sk[$s1]['skor'])) {
                           $sk[$s1]['skor'] = 0;
                        }
                        $sk[$s1]['skor'] = $sk[$s1]['skor'] + $s22['pemberat'];
                     }
                  }
               }
            }
         }
      }
      $rubric_arry = \yii\helpers\ArrayHelper::toArray($this->findRubric(3, $lppid), [], false);
      $subpro = array();
      foreach ($rubric_arry as $arry) {
         $subpro[$arry['aspek']][] = $arry;
      }
      $subpro1 = array();
      foreach ($rubric_arry as $arry) {
         $subpro1[$arry['desc']][] = $arry;
      }
      if (empty($subpro1)) {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid), [], false);
      $mrkh = array();
      $cntt = 0;
      $sk['Bilangan permohonan'] = ['skor' => $grant];
      $sk['Bilangan geran'] = ['skor' => sizeof($penyelidikan)];
      $sum_geran = array_sum(ArrayHelper::getColumn($penyelidikan, 'Amount'));
      $sk['Jumlah geran'] = ['skor' => $sum_geran];
      foreach ($sk as $ind11 => $skk) {
         $ind11 = str_replace('_', ' ', $ind11);
         foreach ($subpro as $ind => $sub) {
            if ($ind == $ind11) {
               $rev = array_reverse($sub);
               foreach ($rev as $bs) {
                  if ($skk['skor'] >= $bs['threshold']) {
                     $mrkh[$cntt]['aspek_id'] = $bs['aspek_id'];
                     $mrkh[$cntt]['skor'] = $bs['skor'];
                     $berat = \yii\helpers\ArrayHelper::toArray($this->findMarkahPemberat($bs['aspek_id'], $lppid), [], false);
                     $mrkh[$cntt]['markah_pyd'] = $bs['peratus'] * ($berat['pemberat'] / 100);
                     break;
                  }
               }
            }
         }
         $cntt++;
      }

      $check = array_values(array_unique(ArrayHelper::getColumn($rubric_arry, 'aspek_id')));
      foreach ($check as $ind => $ch) {
         if (in_array($ch, ArrayHelper::getColumn($mrkh, 'aspek_id'))) {
            continue;
         } else {
            array_push($mrkh, [
               'aspek_id' => $ch,
               'skor' => 0,
               'markah_pyd' => 0,
            ]);
         }
      }
      usort($mrkh, function ($a, $b) {
         return $a['aspek_id'] <=> $b['aspek_id'];
      });
      $cnt = 0;
      foreach ($models as $ii => $model) {



         if (is_null($model->id)) {
            $model = new TblMrkhAspek();
         }
         $model->lpp_id = $lppid;
         $model->bhg_no = 3;
         $model->aspek_id = $mrkh[$cnt]['aspek_id'];
         $model->skor = $mrkh[$cnt]['skor'];
         $model->markah_pyd = $mrkh[$cnt]['markah_pyd'];
         $model->save(false);
         $cnt++;
      }
      $mrkh_bhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(3, $lppid), [], false);
      $this->calcOverallMark($lppid);

      return $this->render('bahagian', [
         'lppid' => $lppid,
         'data' => $penyelidikan,
         'data2' => null,
         'input' => null,
         'rubric' => $subpro1,
         'mrkh_all' => $mrkh_all,
         'pemberat' => $this->findPemberatBahagian($lppid),
         'mrkh_bhg' => $mrkh_bhg,
         'bhgian' => $nama,
         'menu' => $this->menuBahagian($lppid),
         'url_create' => $url_create,
         'lpp' => \app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]),
         'req' => $this->checkRequest($lppid)
      ]);
   }

   public function actionCreatePenyelidikan($lppid)
   {
      $addon = new TblPenyelidikanManual();
      if ($addon->load(Yii::$app->request->post())) {
         $addon->lpp_id = $lppid;
         if ($addon->validate() && $addon->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
            return $this->redirect(['elnpt/bahagian3', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('create_bhg3', [
         'pnp' => $addon,
      ]);
   }

   public function actionUpdatePenyelidikan($id, $lppid)
   {
      $addon = TblPenyelidikanManual::findOne($id);
      if (!$addon) {
         throw new NotFoundHttpException("The requested page does not exist.");
      }
      if ($addon->load(Yii::$app->request->post())) {
         if ($addon->validate() && $addon->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
            return $this->redirect(['elnpt/bahagian3', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('create_bhg3', [
         'pnp' => $addon,
      ]);
   }

   public function actionDeletePenyelidikan($id, $lppid)
   {
      $addon = TblPenyelidikanManual::findOne($id);
      if (!$addon) {
         throw new NotFoundHttpException("The requested page does not exist.");
      }
      $addon->delete();
      \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
      return $this->redirect(['elnpt/bahagian3', 'lppid' => $lppid]);
   }

   public function actionBahagian4($lppid)
   {
      $nama = RefBahagian::findOne(4);
      $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();

      $this->dataBahagian4(Yii::$app->user->identity->ICNO, $tahun->lpp_tahun, $publication, $lppid);
      $list = $publication;
      $mrkh_bhg1 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(4, $lppid), [], false);
      if (
         TblMrkhAspek::find()

         ->where(['bhg_no' => 4, 'lpp_id' => $lppid])
         ->all() != null
      ) {
         $models = TblMrkhAspek::find()
            ->rightJoin('`hrm`.`elnpt_ref_aspek_penilaian`', '`hrm`.`elnpt_ref_aspek_penilaian`.`id` =  `hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id`'
               . ' and `lpp_id` = ' . $lppid)
            ->where(['`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`' => 4])
            ->indexBy('aspek_id')
            ->orderBy('aspek_id')
            ->all();
      } else {
         $models = [new TblMrkhAspek()];
         for ($i = 1; $i < sizeof($mrkh_bhg1); $i++) {
            $models[] = new TblMrkhAspek();
         }
      };
      $skor = RefAspekPenilaian::find()
         ->select('aspek, sub_aspek, pemberat')
         ->leftJoin('hrm.elnpt_ref_skor_aspek b', '`b`.`aspek_id` = `hrm`.`elnpt_ref_aspek_penilaian`.`id`')
         ->where(['bhg_no' => 4])
         ->asArray()
         ->all();
      $skor2 = array();
      foreach ($skor as $ind => $ss) {
         $skor2[$ss['aspek']][$ind]['aspek'] = $ss['sub_aspek'];
         $skor2[$ss['aspek']][$ind]['pemberat'] = $ss['pemberat'];
      }

      $sk = array();
      foreach ($list as $ind => $arry) {
         foreach ($arry as $key => $t) {
            foreach ($skor2 as $ind1 => $s) {
               $s1 = str_replace(' ', '_', $ind1);
               if ($key == $s1) {
                  foreach ($s as $s22) {



                     if ($s1 == 'Bilangan_penerbitan') {
                        if ($arry[$s1] == 'Article') {
                           if ($arry['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)' or $arry['Status_indeks'] == 'Indexed') {
                              $arry[$s1] = 'Article Indexed';
                           } else if ($arry['Status_indeks'] == 'Non-indexed') {
                              $arry[$s1] = 'Article Non-indexed';
                           } else {
                              $arry[$s1] = 'Article Non-indexed';
                           }
                        }
                        if ($arry[$s1] == 'Proceeding: Abstract' or $arry[$s1] == 'Proceeding: Full Paper') {
                           if ($arry['Status_indeks'] == 'High-Indexed (SCOPUS, WOS, ERA)' or $arry['Status_indeks'] == 'Indexed') {
                              $arry[$s1] = 'Proceeding Indexed';
                           }
                        }
                     }

                     if ($s22['aspek'] == $arry[$s1]) {
                        if (empty($sk[$s1]['skor'])) {
                           $sk[$s1]['skor'] = 0;
                        }
                        $sk[$s1]['skor'] = $sk[$s1]['skor'] + $s22['pemberat'];
                     }
                  }
               }
            }
         }
      }

      $rubric_arry = \yii\helpers\ArrayHelper::toArray($this->findRubric(4, $lppid), [], false);
      $subpro = array();
      foreach ($rubric_arry as $arry) {
         $subpro[$arry['aspek']][] = $arry;
      }
      $subpro1 = array();
      foreach ($rubric_arry as $arry) {
         $subpro1[$arry['desc']][] = $arry;
      }
      if (empty($subpro1)) {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid), [], false);
      $mrkh = array();
      $cntt = 0;



      foreach ($sk as $ind11 => $skk) {
         $ind11 = str_replace('_', ' ', $ind11);
         foreach ($subpro as $ind => $sub) {
            if ($ind == $ind11) {
               $rev = array_reverse($sub);
               foreach ($rev as $bs) {
                  if ($skk['skor'] >= $bs['threshold']) {
                     $mrkh[$cntt]['aspek_id'] = $bs['aspek_id'];
                     $mrkh[$cntt]['skor'] = $bs['skor'];
                     $berat = \yii\helpers\ArrayHelper::toArray($this->findMarkahPemberat($bs['aspek_id'], $lppid), [], false);
                     $mrkh[$cntt]['markah_pyd'] = $bs['peratus'] * ($berat['pemberat'] / 100);
                     break;
                  }
               }
            }
         }
         $cntt++;
      }

      $check = array_values(array_unique(ArrayHelper::getColumn($rubric_arry, 'aspek_id')));
      foreach ($check as $ind => $ch) {
         if (in_array($ch, ArrayHelper::getColumn($mrkh, 'aspek_id'))) {
            continue;
         } else {
            array_push($mrkh, [
               'aspek_id' => $ch,
               'skor' => 0,
               'markah_pyd' => 0,
            ]);
         }
      }
      usort($mrkh, function ($a, $b) {
         return $a['aspek_id'] <=> $b['aspek_id'];
      });
      $cnt = 0;
      foreach ($models as $ii => $model) {



         if (is_null($model->id)) {
            $model = new TblMrkhAspek();
         }
         $model->lpp_id = $lppid;
         $model->bhg_no = 4;
         $model->aspek_id = $mrkh[$cnt]['aspek_id'];
         $model->skor = $mrkh[$cnt]['skor'];
         $model->markah_pyd = $mrkh[$cnt]['markah_pyd'];
         $model->markah_ppp = $mrkh[$cnt]['markah_pyd'];
         $model->markah_ppk = $mrkh[$cnt]['markah_pyd'];
         $model->save(false);
         $cnt++;
      }
      $mrkh_bhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(4, $lppid), [], false);
      $this->calcOverallMark($lppid);
      return $this->render('bahagian', [
         'lppid' => $lppid,
         'data' => $list,
         'data2' => null,
         'input' => null,
         'rubric' => $subpro1,
         'mrkh_all' => $mrkh_all,
         'pemberat' => $this->findPemberatBahagian($lppid),
         'mrkh_bhg' => $mrkh_bhg,
         'bhgian' => $nama,
         'menu' => $this->menuBahagian($lppid),
         'url_create' => null,
         'lpp' => \app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]),
         'req' => $this->checkRequest($lppid)
      ]);
   }

   public function actionBahagian5($lppid)
   {
      $nama = RefBahagian::findOne(5);
      $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();
      $this->dataBahagian5(Yii::$app->user->identity->ICNO, $tahun->lpp_tahun, $conference, $pereka, $inovasi);

      $conference = array_merge($conference, $pereka, $inovasi);

      $mrkh_bhg1 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(5, $lppid), [], false);
      if (
         TblMrkhAspek::find()

         ->where(['bhg_no' => 5, 'lpp_id' => $lppid])
         ->all() != null
      ) {
         $models = TblMrkhAspek::find()
            ->rightJoin('`hrm`.`elnpt_ref_aspek_penilaian`', '`hrm`.`elnpt_ref_aspek_penilaian`.`id` =  `hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id`'
               . ' and `lpp_id` = ' . $lppid)
            ->where(['`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`' => 5])
            ->indexBy('aspek_id')
            ->orderBy('aspek_id')
            ->all();
      } else {
         $models = [new TblMrkhAspek()];
         for ($i = 1; $i < sizeof($mrkh_bhg1); $i++) {
            $models[] = new TblMrkhAspek();
         }
      }
      $skor = RefAspekPenilaian::find()
         ->select('aspek, sub_aspek, pemberat')
         ->leftJoin('hrm.elnpt_ref_skor_aspek b', '`b`.`aspek_id` = `hrm`.`elnpt_ref_aspek_penilaian`.`id`')
         ->where(['bhg_no' => 5])
         ->asArray()
         ->all();
      $skor2 = array();
      foreach ($skor as $ind => $ss) {
         $skor2[$ss['aspek']][$ind]['aspek'] = $ss['sub_aspek'];
         $skor2[$ss['aspek']][$ind]['pemberat'] = $ss['pemberat'];
      }
      $sk = array();
      foreach ($conference as $ind => $arry) {
         foreach ($arry as $key => $t) {
            foreach ($skor2 as $ind1 => $s) {
               $s1 = str_replace(' ', '_', $ind1);
               if ($key == $s1) {
                  foreach ($s as $s22) {

                     if (strcasecmp($s22['aspek'], $arry[$s1]) == 0) {
                        if (empty($sk[$s1]['skor'])) {
                           $sk[$s1]['skor'] = 0;
                        }
                        $sk[$s1]['skor'] = $sk[$s1]['skor'] + $s22['pemberat'];
                     }
                  }
               }
            }
         }
      }
      $rubric_arry = \yii\helpers\ArrayHelper::toArray($this->findRubric(5, $lppid), [], false);
      $subpro = array();
      foreach ($rubric_arry as $arry) {
         $subpro[$arry['aspek']][] = $arry;
      }
      $subpro1 = array();
      foreach ($rubric_arry as $arry) {
         $subpro1[$arry['desc']][] = $arry;
      }
      if (empty($subpro1)) {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid), [], false);
      $mrkh = array();
      $cntt = 0;

      $sum_komersial = array_sum(ArrayHelper::getColumn($conference, 'Amaun_pengkomersialan'));
      $sk['Amaun_pengkomersilan_Inovasi'] = ['skor' => $sum_komersial];

      foreach ($sk as $ind11 => $skk) {

         foreach ($subpro as $ind => $sub) {
            $sss = str_replace('_', ' ', $ind11);
            if ($ind == $sss) {
               $rev = array_reverse($sub);
               foreach ($rev as $bs) {
                  if ($skk['skor'] >= $bs['skor']) {
                     $mrkh[$cntt]['aspek_id'] = $bs['aspek_id'];
                     $mrkh[$cntt]['skor'] = $bs['skor'];
                     $berat = \yii\helpers\ArrayHelper::toArray($this->findMarkahPemberat($bs['aspek_id'], $lppid), [], false);
                     $mrkh[$cntt]['markah_pyd'] = $bs['peratus'] * ($berat['pemberat'] / 100);
                     break;
                  }
               }
            }
         }
         $cntt++;
      }
      $check = array_values(array_unique(ArrayHelper::getColumn($rubric_arry, 'aspek_id')));
      foreach ($check as $ind => $ch) {
         if (in_array($ch, ArrayHelper::getColumn($mrkh, 'aspek_id'))) {
            continue;
         } else {
            array_push($mrkh, [
               'aspek_id' => $ch,
               'skor' => 0,
               'markah_pyd' => 0,
            ]);
         }
      }
      usort($mrkh, function ($a, $b) {
         return $a['aspek_id'] <=> $b['aspek_id'];
      });
      $cnt = 0;
      foreach ($models as $ii => $model) {



         if (is_null($model->id)) {
            $model = new TblMrkhAspek();
         }


         $model->lpp_id = $lppid;
         $model->bhg_no = 5;
         $model->aspek_id = $mrkh[$cnt]['aspek_id'];
         $model->skor = $mrkh[$cnt]['skor'];
         $model->markah_pyd = $mrkh[$cnt]['markah_pyd'];
         $model->markah_ppp = $mrkh[$cnt]['markah_pyd'];
         $model->markah_ppk = $mrkh[$cnt]['markah_pyd'];
         $model->save(false);
         $cnt++;
      }
      $mrkh_bhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(5, $lppid), [], false);
      $this->calcOverallMark($lppid);

      return $this->render('bahagian', [
         'lppid' => $lppid,
         'data' => $conference,
         'data2' => null,
         'input' => null,
         'rubric' => $subpro1,
         'mrkh_all' => $mrkh_all,
         'pemberat' => $this->findPemberatBahagian($lppid),
         'mrkh_bhg' => $mrkh_bhg,
         'bhgian' => $nama,
         'menu' => $this->menuBahagian($lppid),
         'url_create' => null,
         'lpp' => \app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]),
         'req' => $this->checkRequest($lppid)
      ]);
   }

   public function actionBahagian6($lppid)
   {
      $nama = RefBahagian::findOne(6);
      $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();
      $url_create = Url::to(['elnpt/create-outreaching', 'lppid' => $lppid]);




      $this->dataBahagian6($lppid, Yii::$app->user->identity->ICNO, $tahun->lpp_tahun, $conference, $manual, $manual2);
      $list = array_merge($conference, $manual2);

      $mrkh_bhg1 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(6, $lppid), [], false);
      if (
         TblMrkhAspek::find()

         ->where(['bhg_no' => 6, 'lpp_id' => $lppid])
         ->all() != null
      ) {
         $models = TblMrkhAspek::find()
            ->rightJoin('`hrm`.`elnpt_ref_aspek_penilaian`', '`hrm`.`elnpt_ref_aspek_penilaian`.`id` =  `hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id`'
               . ' and `lpp_id` = ' . $lppid)
            ->where(['`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`' => 6])
            ->indexBy('aspek_id')
            ->orderBy('aspek_id')
            ->all();
      } else {
         $models = [new TblMrkhAspek()];
         for ($i = 1; $i < sizeof($mrkh_bhg1); $i++) {
            $models[] = new TblMrkhAspek();
         }
      }
      $skor = RefAspekPenilaian::find()
         ->select('aspek, sub_aspek, pemberat')
         ->leftJoin('hrm.elnpt_ref_skor_aspek b', '`b`.`aspek_id` = `hrm`.`elnpt_ref_aspek_penilaian`.`id`')
         ->where(['bhg_no' => 6])
         ->asArray()
         ->all();
      $skor2 = array();
      foreach ($skor as $ind => $ss) {
         $skor2[$ss['aspek']][$ind]['aspek'] = $ss['sub_aspek'];
         $skor2[$ss['aspek']][$ind]['pemberat'] = $ss['pemberat'];
      }

      $sk = array();
      foreach ($list as $ind => $arry) {
         foreach ($arry as $key => $t) {
            foreach ($skor2 as $ind1 => $s) {
               $s1 = str_replace(' ', '_', $ind1);
               if ($key == $s1) {
                  foreach ($s as $s22) {

                     if (strcasecmp($s22['aspek'], $arry[$s1]) == 0) {
                        if (empty($sk[$s1]['skor'])) {
                           $sk[$s1]['skor'] = 0;
                        }
                        $sk[$s1]['skor'] = $sk[$s1]['skor'] + $s22['pemberat'];
                     }
                  }
               }
            }
         }
      }

      $rubric_arry = \yii\helpers\ArrayHelper::toArray($this->findRubric(6, $lppid), [], false);
      $subpro = array();
      foreach ($rubric_arry as $arry) {
         $subpro[$arry['aspek']][] = $arry;
      }
      $subpro1 = array();
      foreach ($rubric_arry as $arry) {
         $subpro1[$arry['desc']][] = $arry;
      }
      if (empty($subpro1)) {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid), [], false);
      $mrkh = array();
      $cntt = 0;

      $sum_komersial = array_sum(ArrayHelper::getColumn($list, 'Amaun_outreaching'));
      $sk['Amaun outreaching'] = ['skor' => $sum_komersial];
      foreach ($sk as $ind11 => $skk) {

         foreach ($subpro as $ind => $sub) {
            $sss = str_replace('_', ' ', $ind11);
            if ($ind == $sss) {
               $rev = array_reverse($sub);
               foreach ($rev as $bs) {
                  if ($skk['skor'] >= $bs['skor']) {
                     $mrkh[$cntt]['aspek_id'] = $bs['aspek_id'];
                     $mrkh[$cntt]['skor'] = $bs['skor'];
                     $berat = \yii\helpers\ArrayHelper::toArray($this->findMarkahPemberat($bs['aspek_id'], $lppid), [], false);
                     $mrkh[$cntt]['markah_pyd'] = $bs['peratus'] * ($berat['pemberat'] / 100);
                     break;
                  }
               }
            }
         }
         $cntt++;
      }

      $check = array_values(array_unique(ArrayHelper::getColumn($rubric_arry, 'aspek_id')));
      foreach ($check as $ind => $ch) {
         if (in_array($ch, ArrayHelper::getColumn($mrkh, 'aspek_id'))) {
            continue;
         } else {
            array_push($mrkh, [
               'aspek_id' => $ch,
               'skor' => 0,
               'markah_pyd' => 0,
            ]);
         }
      }
      usort($mrkh, function ($a, $b) {
         return $a['aspek_id'] <=> $b['aspek_id'];
      });
      $cnt = 0;
      foreach ($models as $ii => $model) {



         if (is_null($model->id)) {
            $model = new TblMrkhAspek();
         }
         $model->lpp_id = $lppid;
         $model->bhg_no = 6;
         $model->aspek_id = $mrkh[$cnt]['aspek_id'];
         $model->skor = $mrkh[$cnt]['skor'];
         $model->markah_pyd = $mrkh[$cnt]['markah_pyd'];
         $model->save(false);
         $cnt++;
      }
      $mrkh_bhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(6, $lppid), [], false);
      $this->calcOverallMark($lppid);

      return $this->render('bahagian', [
         'lppid' => $lppid,
         'data' => array_merge($conference, $manual),
         'data2' => null,
         'input' => null,
         'rubric' => $subpro1,
         'mrkh_all' => $mrkh_all,
         'pemberat' => $this->findPemberatBahagian($lppid),
         'mrkh_bhg' => $mrkh_bhg,
         'bhgian' => $nama,
         'menu' => $this->menuBahagian($lppid),
         'url_create' => $url_create,
         'lpp' => \app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]),
         'req' => $this->checkRequest($lppid)
      ]);
   }

   public function actionCreateOutreaching($lppid)
   {
      $addon = new TblOutreachingManual();
      if ($addon->load(Yii::$app->request->post())) {
         $addon->lpp_id = $lppid;

         if ($addon->validate() && $addon->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
            return $this->redirect(['elnpt/bahagian6', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('create_bhg6', [
         'pnp' => $addon,
      ]);
   }

   public function actionUpdateOutreaching($id, $lppid)
   {
      $addon = TblOutreachingManual::findOne($id);
      if (!$addon) {
         throw new NotFoundHttpException("The requested page does not exist.");
      }
      if ($addon->load(Yii::$app->request->post())) {
         if ($addon->validate() && $addon->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
            return $this->redirect(['elnpt/bahagian6', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('create_bhg6', [
         'pnp' => $addon,
      ]);
   }

   public function actionDeleteOutreaching($id, $lppid)
   {
      $addon = TblOutreachingManual::findOne($id);
      if (!$addon) {
         throw new NotFoundHttpException("The requested page does not exist.");
      }
      $addon->delete();
      \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
      return $this->redirect(['elnpt/bahagian6', 'lppid' => $lppid]);
   }

   public function actionBahagian7($lppid)
   {
      $nama = RefBahagian::findOne(7);
      $url_create = Url::to(['elnpt/create-urus-tadbir', 'lppid' => $lppid]);
      $this->dataBahagian7($lppid, $urus_tadbir, $result, Yii::$app->user->identity->ICNO);
      $list = array_merge($urus_tadbir, $result);


      $mrkh_bhg1 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(7, $lppid), [], false);
      if (
         TblMrkhAspek::find()

         ->where(['bhg_no' => 7, 'lpp_id' => $lppid])
         ->all() != null
      ) {
         $models = TblMrkhAspek::find()
            ->rightJoin('`hrm`.`elnpt_ref_aspek_penilaian`', '`hrm`.`elnpt_ref_aspek_penilaian`.`id` =  `hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id`'
               . ' and `lpp_id` = ' . $lppid)
            ->where(['`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`' => 7])
            ->indexBy('aspek_id')
            ->orderBy('aspek_id')
            ->all();
      } else {
         $models = [new TblMrkhAspek()];
         for ($i = 1; $i < sizeof($mrkh_bhg1); $i++) {
            $models[] = new TblMrkhAspek();
         }
      }
      $skor = RefAspekPenilaian::find()
         ->select('aspek, sub_aspek, pemberat')
         ->leftJoin('hrm.elnpt_ref_skor_aspek b', '`b`.`aspek_id` = `hrm`.`elnpt_ref_aspek_penilaian`.`id`')
         ->where(['bhg_no' => 7])
         ->asArray()
         ->all();
      $skor2 = array();
      foreach ($skor as $ind => $ss) {
         $skor2[$ss['aspek']][$ind]['aspek'] = $ss['sub_aspek'];
         $skor2[$ss['aspek']][$ind]['pemberat'] = $ss['pemberat'];
      }

      $sk = array();
      foreach ($list as $ind => $arry) {
         foreach ($arry as $key => $t) {
            foreach ($skor2 as $ind1 => $s) {
               $s1 = str_replace(' ', '_', $ind1);
               if ($key == $s1) {
                  foreach ($s as $s22) {

                     if (strcasecmp($s22['aspek'], $arry[$s1]) == 0) {
                        if (empty($sk[$s1]['skor'])) {
                           $sk[$s1]['skor'] = 0;
                        }
                        $sk[$s1]['skor'] = $sk[$s1]['skor'] + $s22['pemberat'];
                     }
                  }
               }
            }
         }
      }

      $rubric_arry = \yii\helpers\ArrayHelper::toArray($this->findRubric(7, $lppid), [], false);
      $subpro = array();
      foreach ($rubric_arry as $arry) {
         $subpro[$arry['aspek']][] = $arry;
      }
      $subpro1 = array();
      foreach ($rubric_arry as $arry) {
         $subpro1[$arry['desc']][] = $arry;
      }
      if (empty($subpro1)) {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid), [], false);
      $mrkh = array();
      $cntt = 0;



      foreach ($sk as $ind11 => $skk) {

         foreach ($subpro as $ind => $sub) {
            $sss = str_replace('_', ' ', $ind11);
            if ($ind == $sss) {
               $rev = array_reverse($sub);
               foreach ($rev as $bs) {
                  if ($skk['skor'] >= $bs['skor']) {
                     $mrkh[$cntt]['aspek_id'] = $bs['aspek_id'];
                     $mrkh[$cntt]['skor'] = $bs['skor'];
                     $berat = \yii\helpers\ArrayHelper::toArray($this->findMarkahPemberat($bs['aspek_id'], $lppid), [], false);
                     $mrkh[$cntt]['markah_pyd'] = $bs['peratus'] * ($berat['pemberat'] / 100);
                     break;
                  }
               }
            }
         }
         $cntt++;
      }

      $check = array_values(array_unique(ArrayHelper::getColumn($rubric_arry, 'aspek_id')));
      foreach ($check as $ind => $ch) {
         if (in_array($ch, ArrayHelper::getColumn($mrkh, 'aspek_id'))) {
            continue;
         } else {
            array_push($mrkh, [
               'aspek_id' => $ch,
               'skor' => 0,
               'markah_pyd' => 0,
            ]);
         }
      }
      usort($mrkh, function ($a, $b) {
         return $a['aspek_id'] <=> $b['aspek_id'];
      });
      $cnt = 0;
      foreach ($models as $ii => $model) {



         if (is_null($model->id)) {
            $model = new TblMrkhAspek();
         }
         $model->lpp_id = $lppid;
         $model->bhg_no = 7;
         $model->aspek_id = $mrkh[$cnt]['aspek_id'];
         $model->skor = $mrkh[$cnt]['skor'];
         $model->markah_pyd = $mrkh[$cnt]['markah_pyd'];
         $model->save(false);
         $cnt++;
      }

      $mrkh_bhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(7, $lppid), [], false);
      $this->calcOverallMark($lppid);
      return $this->render('bahagian', [
         'lppid' => $lppid,
         'data' => $list,
         'data2' => null,
         'input' => null,
         'rubric' => $subpro1,
         'mrkh_all' => $mrkh_all,
         'pemberat' => $this->findPemberatBahagian($lppid),
         'mrkh_bhg' => $mrkh_bhg,
         'bhgian' => $nama,
         'menu' => $this->menuBahagian($lppid),
         'url_create' => $url_create,
         'lpp' => \app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]),
         'req' => $this->checkRequest($lppid)
      ]);
   }

   public function actionCreateUrusTadbir($lppid)
   {
      $addon = new TblPengurusanPentadbiran();
      if ($addon->load(Yii::$app->request->post())) {
         $addon->lpp_id = $lppid;
         if ($addon->validate() && $addon->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
            return $this->redirect(['elnpt/bahagian7', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('create_bhg7', [
         'pnp' => $addon,
      ]);
   }

   public function actionUpdateUrusTadbir($id, $lppid)
   {
      $addon = TblPengurusanPentadbiran::findOne($id);
      if (!$addon) {
         throw new NotFoundHttpException("The requested page does not exist.");
      }
      if ($addon->load(Yii::$app->request->post())) {
         if ($addon->validate() && $addon->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
            return $this->redirect(['elnpt/bahagian7', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('create_bhg7', [
         'pnp' => $addon,
      ]);
   }

   public function actionDeleteUrusTadbir($id, $lppid)
   {
      $addon = TblPengurusanPentadbiran::findOne($id);
      if (!$addon) {
         throw new NotFoundHttpException("The requested page does not exist.");
      }
      $addon->delete();
      \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
      return $this->redirect(['elnpt/bahagian7', 'lppid' => $lppid]);
   }

   public function actionBahagian8($lppid)
   {
      $nama = RefBahagian::findOne(8);
      $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();
      $this->dataBahagian8(
         $lppid,
         Yii::$app->user->identity->ICNO,
         $tahun->lpp_tahun,
         $penyelia_ketua,
         $pen_ketua_telah,
         $pen_ketua_belum,
         $selidik,
         $selidik_add,
         $conf,
         $perundingan,
         $perundingan_manual,
         $publication,
         $sk
      );


      $rubric_arry = \yii\helpers\ArrayHelper::toArray($this->findRubric(8, $lppid), [], false);
      $subpro = array();
      foreach ($rubric_arry as $arry) {
         $subpro[$arry['aspek']][] = $arry;
      }
      $subpro1 = array();
      foreach ($rubric_arry as $arry) {
         $subpro1[$arry['desc']][] = $arry;
      }
      if (empty($subpro1)) {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $mrkh_bhg1 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(8, $lppid), [], false);
      if (
         TblMrkhAspek::find()

         ->where(['bhg_no' => 8, 'lpp_id' => $lppid])
         ->all() != null
      ) {
         $models = TblMrkhAspek::find()
            ->rightJoin('`hrm`.`elnpt_ref_aspek_penilaian`', '`hrm`.`elnpt_ref_aspek_penilaian`.`id` =  `hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id`'
               . ' and `lpp_id` = ' . $lppid)
            ->where(['`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`' => 8])
            ->indexBy('aspek_id')
            ->orderBy('aspek_id')
            ->all();
      } else {
         $models = [new TblMrkhAspek()];
         for ($i = 1; $i < sizeof($mrkh_bhg1); $i++) {
            $models[] = new TblMrkhAspek();
         }
      };
      $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid), [], false);

      $mrkh = array();
      $cntt = 0;



      foreach ($sk as $ind11 => $skk) {
         $ind11 = str_replace('_', ' ', $ind11);
         foreach ($subpro as $ind => $sub) {
            if ($ind == $ind11) {
               $rev = array_reverse($sub);
               foreach ($rev as $bs) {
                  if ($skk['skor'] >= $bs['threshold']) {
                     $mrkh[$cntt]['aspek_id'] = $bs['aspek_id'];
                     $mrkh[$cntt]['skor'] = $bs['skor'];
                     $berat = \yii\helpers\ArrayHelper::toArray($this->findMarkahPemberat($bs['aspek_id'], $lppid), [], false);
                     $mrkh[$cntt]['markah_pyd'] = $bs['peratus'] * ($berat['pemberat'] / 100);
                     break;
                  }
               }
            }
         }
         $cntt++;
      }

      $check = array_values(array_unique(ArrayHelper::getColumn($rubric_arry, 'aspek_id')));
      foreach ($check as $ind => $ch) {
         if (in_array($ch, ArrayHelper::getColumn($mrkh, 'aspek_id'))) {
            continue;
         } else {
            array_push($mrkh, [
               'aspek_id' => $ch,
               'skor' => 0,
               'markah_pyd' => 0,
            ]);
         }
      }
      usort($mrkh, function ($a, $b) {
         return $a['aspek_id'] <=> $b['aspek_id'];
      });
      $cnt = 0;
      foreach ($models as $ii => $model) {



         if (is_null($model->id)) {
            $model = new TblMrkhAspek();
         }
         $model->lpp_id = $lppid;
         $model->bhg_no = 8;
         $model->aspek_id = $mrkh[$cnt]['aspek_id'];
         $model->skor = $mrkh[$cnt]['skor'];
         $model->markah_pyd = $mrkh[$cnt]['markah_pyd'];
         $model->save(false);
         $cnt++;
      }
      $mrkh_bhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(8, $lppid), [], false);
      $this->calcOverallMark($lppid);
      return $this->render('bahagian', [
         'lppid' => $lppid,
         'data' => $sk,
         'data2' => null,
         'input' => null,
         'rubric' => $subpro1,
         'mrkh_all' => $mrkh_all,
         'pemberat' => $this->findPemberatBahagian($lppid),
         'mrkh_bhg' => $mrkh_bhg,
         'bhgian' => $nama,
         'menu' => $this->menuBahagian($lppid),
         'url_create' => null,
         'lpp' => \app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]),
         'req' => $this->checkRequest($lppid)
      ]);
   }

   public function actionBahagian9($lppid)
   {
      $nama = RefBahagian::findOne(9);
      $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $pengajaran = RefAspekPenilaian::find()
         ->where(['bhg_no' => 9])
         ->orderBy('id')
         ->asArray()
         ->all();

      $pengajaran2 = RefAspekPenilaian::find()
         ->where(['bhg_no' => 9])
         ->orderBy('id')
         ->indexBy('id')
         ->asArray()
         ->all();
      if ($waktu = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->all() != null) {
         $waktu = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->all();
      } else {
         $waktu = [new TblMarkahKualiti()];
         for ($i = 0; $i < sizeof($pengajaran2); $i++) {
            $waktu[$i] = new TblMarkahKualiti();
            $waktu[$i]->ref_kualiti_id = $pengajaran[$i]['id'];
         }
      }
      $rubric_arry = \yii\helpers\ArrayHelper::toArray($this->findRubric(9, $lppid), [], false);
      $subpro = array();
      foreach ($rubric_arry as $arry) {
         $subpro[$arry['aspek']][] = $arry;
      }
      $subpro1 = array();
      foreach ($rubric_arry as $arry) {
         $subpro1[$arry['desc']][] = $arry;
      }
      if (empty($subpro1)) {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid), [], false);
      $mrkh_bhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(9, $lppid), [], false);
      $this->calcOverallMark($lppid);
      return $this->render('bahagian', [
         'lppid' => $lppid,
         'data' => $pengajaran2,
         'data2' => null,
         'input' => $waktu,
         'rubric' => $subpro1,
         'mrkh_all' => $mrkh_all,
         'pemberat' => $this->findPemberatBahagian($lppid),
         'mrkh_bhg' => $mrkh_bhg,
         'bhgian' => $nama,
         'lpp' => $lpp,
         'menu' => $this->menuBahagian($lppid),
         'url_create' => null,
         'lpp' => \app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]),
         'req' => $this->checkRequest($lppid)
      ]);
   }

   public function actionBahagian10($lppid)
   {
      $nama = RefBahagian::findOne(10);
      $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();

      if (($klinikal = TblKlinikal::findOne(['lpp_id' => $lppid])) != null) {
         $klinikal = TblKlinikal::findOne(['lpp_id' => $lppid]);
      } else {
         $klinikal = new TblKlinikal();
      }
      if ($klinikal->load(Yii::$app->request->post())) {
         $klinikal->lpp_id = $lppid;
         if ($klinikal->save()) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya ditambah!']);
            return $this->redirect(['elnpt/bahagian10', 'lppid' => $lppid]);
         }
      }
      $mrkh_bhg1 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(10, $lppid), [], false);

      if (
         TblMrkhAspek::find()

         ->where(['bhg_no' => 10, 'lpp_id' => $lppid])
         ->all() != null
      ) {
         $models = TblMrkhAspek::find()
            ->rightJoin('`hrm`.`elnpt_ref_aspek_penilaian`', '`hrm`.`elnpt_ref_aspek_penilaian`.`id` =  `hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id`'
               . ' and `lpp_id` = ' . $lppid)
            ->where(['`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`' => 10])
            ->indexBy('aspek_id')
            ->orderBy('aspek_id')
            ->all();
      } else {
         $models = [new TblMrkhAspek()];
         for ($i = 1; $i < sizeof($mrkh_bhg1); $i++) {
            $models[] = new TblMrkhAspek();
         }
      }
      $skor = RefAspekPenilaian::find()
         ->select('aspek, sub_aspek, pemberat')
         ->leftJoin('hrm.elnpt_ref_skor_aspek b', '`b`.`aspek_id` = `hrm`.`elnpt_ref_aspek_penilaian`.`id`')
         ->where(['bhg_no' => 10])
         ->asArray()
         ->all();
      $skor2 = array();
      foreach ($skor as $ind => $ss) {
         $skor2[$ss['aspek']][$ind]['aspek'] = $ss['sub_aspek'];
         $skor2[$ss['aspek']][$ind]['pemberat'] = $ss['pemberat'];
      }

      $rubric_arry = \yii\helpers\ArrayHelper::toArray($this->findRubric(10, $lppid), [], false);
      $subpro = array();
      foreach ($rubric_arry as $arry) {
         $subpro[$arry['aspek']][] = $arry;
      }
      $subpro1 = array();
      foreach ($rubric_arry as $arry) {
         $subpro1[$arry['desc']][] = $arry;
      }
      if (empty($subpro1)) {
         throw new NotFoundHttpException('The requested page does not exist.');
      }

      $mrkh = array();
      $cntt = 0;
      $sk = array();
      $sk['Ruberik Clinical Consultation (Clinic/Ward Round/Procedure)'] = ['skor' => empty($klinikal->clinic_consult) ?  0 : $klinikal->clinic_consult];
      $sk['Ruberik Clinical Bedside Teaching'] = ['skor' => empty($klinikal->cbt) ? 0 : $klinikal->cbt];


      $sk['Ruberik Annual Practicing Certificate Renewal (APC - MMC)'] = ['skor' => empty($klinikal->apc) ? 0 : $klinikal->apc];

      foreach ($sk as $ind11 => $skk) {
         foreach ($subpro as $ind => $sub) {
            $sss = str_replace('_', ' ', $ind11);
            if ($ind == $sss) {
               $rev = array_reverse($sub);
               foreach ($rev as $bs) {
                  if ($skk['skor'] >= $bs['skor']) {
                     $mrkh[$cntt]['aspek_id'] = $bs['aspek_id'];
                     $mrkh[$cntt]['skor'] = $bs['skor'];
                     $berat = \yii\helpers\ArrayHelper::toArray($this->findMarkahPemberat($bs['aspek_id'], $lppid), [], false);
                     $mrkh[$cntt]['markah_pyd'] = $bs['peratus'] * ($berat['pemberat'] / 100);
                     break;
                  }
               }
            }
         }
         $cntt++;
      }

      $check = array_values(array_unique(ArrayHelper::getColumn($rubric_arry, 'aspek_id')));
      foreach ($check as $ind => $ch) {
         if (in_array($ch, ArrayHelper::getColumn($mrkh, 'aspek_id'))) {
            continue;
         } else {
            array_push($mrkh, [
               'aspek_id' => $ch,
               'skor' => 0,
               'markah_pyd' => 0,
            ]);
         }
      }
      usort($mrkh, function ($a, $b) {
         return $a['aspek_id'] <=> $b['aspek_id'];
      });
      $cnt = 0;
      foreach ($models as $ii => $model) {



         if (is_null($model->id)) {
            $model = new TblMrkhAspek();
         }
         $model->lpp_id = $lppid;
         $model->bhg_no = 10;
         $model->aspek_id = $mrkh[$cnt]['aspek_id'];
         $model->skor = $mrkh[$cnt]['skor'];
         $model->markah_pyd = $mrkh[$cnt]['markah_pyd'];
         $model->save(false);
         $cnt++;
      }
      $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid), [], false);
      $mrkh_bhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(10, $lppid), [], false);
      $this->calcOverallMark($lppid);

      return $this->render('bahagian', [
         'lppid' => $lppid,
         'data' => 1,
         'data2' => null,
         'input' => $klinikal,
         'rubric' => $subpro1,
         'mrkh_all' => $mrkh_all,
         'pemberat' => $this->findPemberatBahagian($lppid),
         'mrkh_bhg' => $mrkh_bhg,
         'bhgian' => $nama,
         'menu' => $this->menuBahagian($lppid),
         'url_create' => null,
         'lpp' => \app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]),
         'req' => $this->checkRequest($lppid)
      ]);
   }

   public function actionRingkasan($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one();
      $dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->one();
      $rubric = TblKumpRubrik::find()->where([
         'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id),
         'kump_gred_id' => $gred->ref_kump_gred_id
      ])->one();
      $query11 = TblPemberatBhg::find()
         ->select(['pemberat', '`hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`'])
         ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.`bhg_id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->where([
            'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id), 'kump_gred_id' => $gred->ref_kump_gred_id,
            '`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id
         ])
         ->orderBy(['`hrm`.`elnpt_tbl_bhg_kump`.bhg_id' => SORT_ASC])
         ->indexBy('bhg_id')
         ->asArray()
         ->all();

      $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid), [], false);
      $markah = (new \yii\db\Query())
         ->select(['`hrm`.`elnpt_ref_bahagian`.`id` AS id', '`hrm`.`elnpt_ref_bahagian`.`bahagian` AS aspek', 'COALESCE(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0.0) as markah', '`hrm`.`elnpt_ref_bahagian`.`bhg_color` AS warna'])
         ->from('`hrm`.`elnpt_ref_bahagian`')
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->rightJoin('(SELECT DISTINCT bhg_id FROM `hrm`.`elnpt_tbl_pemberat_bhg`) a', 'a.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_bhg_kump`.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->where(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $this->findKumpRubric($lppid)])
         ->indexBy('id')
         ->orderBy('id');

      $peratusKat = RefPeratusKategori::find()->asArray()->all();
      $sumMrkhBhg = $markah->sum('markah');
      foreach (array_reverse($peratusKat) as $pk) {
         if ($sumMrkhBhg >= $pk['peratus_min']) {
            $katMrkhBhg = $pk['kategori'];
            break;
         }
         $sumMrkhBhg = 0;
         $katMrkhBhg = '';
      }
      $query = RefAspekPenilaian::find()
         ->select([
            '`hrm`.`elnpt_ref_aspek_penilaian`.`desc`', '`hrm`.`elnpt_ref_aspek_penilaian`.`aspek`', '`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no` as bhg_no', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor',
            'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) as markah_pyd', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 0) as markah_ppp', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, 0) as markah_ppk',
            'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, 0) as markah_peer', '`hrm`.`elnpt_ref_bahagian`.`id` as idd'
         ])
         ->leftJoin('`hrm`.`elnpt_ref_bahagian`', '`hrm`.`elnpt_ref_bahagian`.id = `hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_bhg_kump`.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id` = `hrm`.`elnpt_ref_aspek_penilaian`.`id` AND `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid)
         ->where(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $this->findKumpRubric($lppid)])
         ->orderBy('`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`')
         ->asArray()
         ->all();
      $subpro = array();
      foreach ($query as $ind => $arry) {
         $subpro[$arry['idd']][$ind] = $arry;
      }
      $tmp = array();
      $tmp2 = array();
      foreach ($subpro as $ind => $sub) {
         $tmp2['desc'] = 'JUMLAH';
         $tmp2['skor'] = '';
         $tmp2['markah_pyd'] = array_sum(array_column($sub, 'markah_pyd'));
         $tmp2['markah_ppp'] = array_sum(array_column($sub, 'markah_ppp'));
         $tmp2['markah_ppk'] = array_sum(array_column($sub, 'markah_ppk'));
         $tmp2['markah_peer'] = array_sum(array_column($sub, 'markah_peer'));
         $tmp2['bhg_no'] = array_sum(array_column($sub, 'bhg_no'));
         $tmp[$ind] = $tmp2;
      }
      foreach ($subpro as $ind => $sb) {
         $subpro[$ind][] = $tmp[$ind];
      }




      $arry = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`id` as bhg_no', new Expression('\'0\' as mrkh_bhg')])
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->andWhere(['!=', '`hrm`.`elnpt_ref_bahagian`.`id`', 11])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();


      $pyd = TblMrkhAspek::find()
         ->select('bhg_no, (sum(markah_pyd) * (pemberat/100)) as mrkh_bhg')
         ->rightJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
         ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = `hrm`.`elnpt_tbl_bhg_kump`.bhg_id')
         ->where(['lpp_id' => $lppid])
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->andWhere(['!=', 'bhg_no', 9])
         ->groupBy('bhg_no')
         ->orderBy('bhg_no')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $pyd = array_replace_recursive($arry, $pyd);
      $ppp = TblMrkhAspek::find()
         ->select('bhg_no, (sum(markah_ppp) * (pemberat/100)) as mrkh_bhg')
         ->rightJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
         ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = `hrm`.`elnpt_tbl_bhg_kump`.bhg_id')
         ->where(['lpp_id' => $lppid])
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->groupBy('bhg_no')
         ->orderBy('bhg_no')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $ppp = array_replace_recursive($arry, $ppp);
      $ppk = TblMrkhAspek::find()
         ->select('bhg_no, (sum(markah_ppk) * (pemberat/100)) as mrkh_bhg')
         ->rightJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
         ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = `hrm`.`elnpt_tbl_bhg_kump`.bhg_id')
         ->where(['lpp_id' => $lppid])
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->groupBy('bhg_no')
         ->orderBy('bhg_no')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $ppk = array_replace_recursive($arry, $ppk);
      $this->calcOverallMark($lppid);
      $total = TblMarkahKeseluruhan::findOne(['lpp_id' => $lppid]);
      $this->getMarkahKualiti($lppid, $mrkh_ppp, $mrkh_ppk, $mrkh_peer, $lpp, $gred);
      ArrayHelper::setValue($ppp, [9], ['bhg_no' => '9', 'mrkh_bhg' => strval($mrkh_ppp)]);
      ArrayHelper::setValue($ppk, [9], ['bhg_no' => '9', 'mrkh_bhg' => strval($mrkh_ppk)]);
      $markahAll = $markah->all();
      ArrayHelper::setValue($markahAll, [9], ['id' => '9', 'aspek' => 'Kualiti Peribadi', 'markah' => strval($mrkh_ppp + $mrkh_ppk), 'warna' => '#cd29bd']);
      ArrayHelper::setValue($query11, [9], ['bhg_id' => '9', 'pemberat' => strval(Yii::$app->formatter->asDecimal(3.75 + 8.25, 2))]);
      // return VarDumper::dump($query11, $depth = 10, $highlight = true); 
      return $this->render('ringkasan', [
         'lppid' => $lppid,
         'summary' => $subpro,
         'mrkh_all' => $mrkh_all,
         'markah' => $markahAll,
         'pemberat' => $query11,
         'menu' => $this->menuBahagian($lppid),
         'total' => is_null($total) ? 0 : $total->markah,
         'kategori' => is_null($total) ? '' : $total->kategori,
         'rankDept' => is_null($total) ? 0 : $total->rankByDept($lppid, $lpp->jfpiu, $lpp->tahun),
         'rankGred' => is_null($total) ? 0 : $total->rankByGred($lppid, $lpp->jfpiu, $lpp->gred_jawatan_id, $lpp->tahun),
         'rankWhole' => is_null($total) ? 0 : $total->rankAsWhole($lppid, $lpp->tahun),
         'pyd' => $pyd,
         'lpp' => $lpp,
         'ppp' => $ppp,
         'ppk' => $ppk,
      ]);
   }

   public function actionSemakRingkasan($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one();
      $dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->one();
      $dept1 = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->max('ref_kump_dept_id');
      $rubric = TblKumpRubrik::find()->where([
         'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id),
         'kump_gred_id' => $gred->ref_kump_gred_id
      ])->one();
      $peratusKat = RefPeratusKategori::find()->asArray()->all();

      $mrkh_seluruh = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_ref_bahagian`.`id`', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->rightJoin('(SELECT DISTINCT bhg_id FROM `hrm`.`elnpt_tbl_pemberat_bhg`) a', 'a.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->andWhere(['!=', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'Ringkasan'])
         ->asArray()
         ->all();
      $mrkh_bhg_pemberat = TblPemberatBhg::find()
         ->select(['pemberat', 'bhg_id'])
         ->where(['kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept1), 'kump_gred_id' => $gred->ref_kump_gred_id])
         ->indexBy(['bhg_id'])
         ->orderBy(['bhg_id' => SORT_ASC])
         ->asArray()
         ->all();
      $mrkh_all = \yii\helpers\ArrayHelper::toArray($mrkh_seluruh, [], false);
      $markah = (new \yii\db\Query())
         ->select(['`hrm`.`elnpt_ref_bahagian`.`id`, `hrm`.`elnpt_ref_bahagian`.`bahagian` AS aspek', 'COALESCE(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0.00) as markah', '`hrm`.`elnpt_ref_bahagian`.`bhg_color` AS warna'])
         ->from('`hrm`.`elnpt_ref_bahagian`')
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->rightJoin('(SELECT DISTINCT bhg_id FROM `hrm`.`elnpt_tbl_pemberat_bhg`) a', 'a.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_bhg_kump`.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->where(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->andWhere(['!=', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'Ringkasan'])
         ->indexBy('id');


      $query = RefAspekPenilaian::find()
         ->select([
            '`hrm`.`elnpt_ref_aspek_penilaian`.`desc`', '`hrm`.`elnpt_ref_aspek_penilaian`.`aspek`', '`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no` as bhg_no', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor',
            'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) as markah_pyd', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 0) as markah_ppp', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, 0) as markah_ppk',
            'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, 0) as markah_peer', '`hrm`.`elnpt_ref_bahagian`.`id` as idd'
         ])
         ->leftJoin('`hrm`.`elnpt_ref_bahagian`', '`hrm`.`elnpt_ref_bahagian`.id = `hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_bhg_kump`.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id` = `hrm`.`elnpt_ref_aspek_penilaian`.`id` AND `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid)
         ->where(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`')
         ->asArray()
         ->all();
      $subpro = array();
      foreach ($query as $ind => $arry) {
         $subpro[$arry['idd']][$ind] = $arry;
      }

      $tmp = array();
      $tmp2 = array();
      foreach ($subpro as $ind => $sub) {
         $tmp2['desc'] = 'JUMLAH';
         $tmp2['skor'] = '';
         $tmp2['markah_pyd'] = array_sum(array_column($sub, 'markah_pyd'));
         $tmp2['markah_ppp'] = array_sum(array_column($sub, 'markah_ppp'));
         $tmp2['markah_ppk'] = array_sum(array_column($sub, 'markah_ppk'));
         $tmp2['markah_peer'] = array_sum(array_column($sub, 'markah_peer'));
         $tmp2['bhg_no'] = array_sum(array_column($sub, 'bhg_no'));
         $tmp[$ind] = $tmp2;
      }
      foreach ($subpro as $ind => $sb) {
         $subpro[$ind][] = $tmp[$ind];
      }




      $this->calcOverallMark($lppid);
      $menu = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_ref_bahagian`.`id`', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->asArray()
         ->all();
      $arry = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`id` as bhg_no', new Expression('\'0\' as mrkh_bhg')])
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->andWhere(['!=', '`hrm`.`elnpt_ref_bahagian`.`id`', 11])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $pyd = TblMrkhAspek::find()
         ->select('bhg_no, (sum(markah_pyd) * (pemberat/100)) as mrkh_bhg')
         ->rightJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
         ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = `hrm`.`elnpt_tbl_bhg_kump`.bhg_id')
         ->where(['lpp_id' => $lppid])
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->andWhere(['!=', 'bhg_no', 9])
         ->groupBy('bhg_no')
         ->orderBy('bhg_no')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $pyd = array_replace_recursive($arry, $pyd);

      $ppp = TblMrkhAspek::find()
         ->select('bhg_no, (sum(markah_ppp) * (pemberat/100)) as mrkh_bhg')
         ->rightJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
         ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = `hrm`.`elnpt_tbl_bhg_kump`.bhg_id')
         ->where(['lpp_id' => $lppid])
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->groupBy('bhg_no')
         ->orderBy('bhg_no')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $ppp = array_replace_recursive($arry, $ppp);
      $ppk = TblMrkhAspek::find()
         ->select('bhg_no, (sum(markah_ppk) * (pemberat/100)) as mrkh_bhg')
         ->rightJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
         ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = `hrm`.`elnpt_tbl_bhg_kump`.bhg_id')
         ->where(['lpp_id' => $lppid])
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->groupBy('bhg_no')
         ->orderBy('bhg_no')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $ppk = array_replace_recursive($arry, $ppk);
      $total = TblMarkahKeseluruhan::findOne(['lpp_id' => $lppid]);
      $this->getMarkahKualiti($lppid, $mrkh_ppp, $mrkh_ppk, $mrkh_peer, $lpp, $gred);
      ArrayHelper::setValue($ppp, [9], ['bhg_no' => '9', 'mrkh_bhg' => strval($mrkh_ppp)]);
      ArrayHelper::setValue($ppk, [9], ['bhg_no' => '9', 'mrkh_bhg' => strval($mrkh_ppk)]);
      $peer = array_fill(1, sizeof($ppp), [
         'bhg_no' => '-1',
         'mrkh_bhg' => '0'
      ]);
      ArrayHelper::setValue($peer, [9], ['bhg_no' => '9', 'mrkh_bhg' => strval($mrkh_peer)]);
      $markahAll = $markah->all();
      ArrayHelper::setValue($markahAll, [9], ['id' => '9', 'aspek' => 'Kualiti Peribadi', 'markah' => strval($mrkh_ppp + $mrkh_ppk), 'warna' => '#cd29bd']);
      ArrayHelper::setValue($mrkh_bhg_pemberat, [9], ['bhg_id' => '9', 'pemberat' => strval(Yii::$app->formatter->asDecimal(3.75 + 8.25, 2))]);
      // return VarDumper::dump($peer, $depth = 10, $highlight = true); 
      return $this->render('semak_ringkasan', [
         'lppid' => $lppid,
         'summary' => $subpro,
         'mrkh_all' => $mrkh_all,
         'pemberat' => $mrkh_bhg_pemberat,
         'markah' => $markahAll,
         'menu' => $menu,
         'total' => is_null($total) ? 0 : $total->markah,
         'kategori' => is_null($total) ? '' : $total->kategori,
         'pyd' => $pyd,
         'ppp' => $ppp,
         'ppk' => $ppk,
         'peer' => $peer
      ]);
   }

   public function actionPengesahanPnp($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      if ($pnpSah = TblPengesahanPnp::findOne(['lpp_id' => $lppid]) != null) {
         $pnpSah = TblPengesahanPnp::findOne(['lpp_id' => $lppid]);
      } else {
         $pnpSah = new TblPengesahanPnp();
      }
      if ($pnpSah->load(Yii::$app->request->post())) {
         $pnpSah->lpp_id = $lppid;
         $pnpSah->PPP_sah_datetime = new \yii\db\Expression('NOW()');
         if ($pnpSah->save() && $pnpSah->validate()) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
            return $this->redirect(['elnpt/semak-lpp', 'lppid' => $lppid, 'bhg_no' => 1]);
         }
      }
      return $this->renderAjax('sah_pnp', [
         'model' => $pnpSah,
         'lpp' => $lpp
      ]);
   }

   public function actionSemakLpp($lppid, $bhg_no)
   {
      $nama = RefBahagian::findOne($bhg_no);
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();
      $gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one();
      $dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->one();
      $dept1 = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->max('ref_kump_dept_id');
      $rubric = TblKumpRubrik::find()->where([
         'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id),
         'kump_gred_id' => $gred->ref_kump_gred_id
      ])->one();
      $mrkh_seluruh = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_ref_bahagian`.`id`', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->rightJoin('(SELECT DISTINCT bhg_id FROM `hrm`.`elnpt_tbl_pemberat_bhg`) a', 'a.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->indexBy('id')
         ->asArray()
         ->all();
      $mrkh_bhg_pemberat = TblPemberatBhg::find()
         ->select(['pemberat', 'bhg_id'])
         ->where(['kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept1), 'kump_gred_id' => $gred->ref_kump_gred_id])
         ->indexBy(['bhg_id'])
         ->orderBy(['bhg_id' => SORT_ASC])
         ->asArray()
         ->all();
      $mrkh_all = \yii\helpers\ArrayHelper::toArray($mrkh_seluruh, [], false);


      $menu = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_ref_bahagian`.`id`', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id`  AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->asArray()
         ->all();
      $findRubric = RefAspekRubrik::find()
         ->select([
            '`hrm`.`elnpt_ref_aspek_penilaian`.id aspek_id', '`hrm`.`elnpt_ref_aspek_penilaian`.aspek', '`hrm`.`elnpt_ref_aspek_penilaian`.desc', '`hrm`.`elnpt_ref_aspek_rubrik`.penilaian',
            '`hrm`.`elnpt_ref_aspek_rubrik`.skor', '`hrm`.`elnpt_tbl_peratus_rubrik`.peratus', '`hrm`.`elnpt_ref_aspek_penilaian`.aspek', '`hrm`.`elnpt_ref_aspek_rubrik`.threshold'
         ])
         ->leftJoin('`hrm`.`elnpt_tbl_peratus_rubrik`', '`hrm`.`elnpt_ref_aspek_rubrik`.id = `hrm`.`elnpt_tbl_peratus_rubrik`.aspek_rubrik_id')
         ->leftJoin('`hrm`.`elnpt_ref_aspek_penilaian`', '`hrm`.`elnpt_ref_aspek_rubrik`.aspek_id = `hrm`.`elnpt_ref_aspek_penilaian`.id')
         ->where(['`hrm`.`elnpt_tbl_peratus_rubrik`.kump_rubrik_id' => $rubric->kump_rubrik_id, '`hrm`.`elnpt_ref_aspek_penilaian`.bhg_no' => $bhg_no])
         ->asArray()
         ->all();
      $rubric_arry = \yii\helpers\ArrayHelper::toArray($findRubric, [], false);
      $subpro = array();
      foreach ($rubric_arry as $arry) {
         $subpro[$arry['aspek']][] = $arry;
      }
      $subpro1 = array();
      foreach ($rubric_arry as $arry) {
         $subpro1[$arry['desc']][] = $arry;
      }

      $dataProvider = null;
      switch ($bhg_no) {
         case 1:




            if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
               throw new ForbiddenHttpException('You don\'t have permission to view this page.');
            }
            $this->dataBahagian1($lppid, $lpp->PYD, $tahun->lpp_tahun, $pengajaran, $pengajaran22, $pengajaran3, $blended);
            $pengajaran2 = $pengajaran22 + $pengajaran3;

            if (($waktu = TblJamWaktu::find()->where(['lpp_id' => $lppid])->indexBy('ref_id')->all()) != null) {
               $waktu = TblJamWaktu::find()->where(['lpp_id' => $lppid])->indexBy('ref_id')->all();
            } else {
               $waktu = [new TblJamWaktu()];
               for ($i = 0; $i < sizeof($pengajaran); $i++) {
                  $waktu[$i] = new TblJamWaktu();
                  $waktu[$i]->ref_id = $pengajaran[$i]['AutoId'];
               }
            }
            if (Model::loadMultiple($waktu, Yii::$app->request->post())) {
               $valid =  Model::validateMultiple($waktu);
               if ($valid) {
                  $transaction = \Yii::$app->db->beginTransaction();
                  try {
                     foreach ($waktu as $wk) {
                        $wk->lpp_id = $lppid;
                        if (!($flag = $wk->save(false))) {
                           $transaction->rollBack();
                           break;
                        }
                     }
                     if ($flag) {
                        $transaction->commit();
                        $ntf = new Notification();
                        $ntf->icno = $lpp->PYD;
                        $ntf->title = 'Pengesahan Ketua Program/PPP untuk ruangan P&P';
                        $ntf->content = "Sila semak bahagian 1 di e-LNPT anda.";
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                        return $this->refresh();
                     }
                  } catch (Exception $e) {
                     $transaction->rollBack();
                  }
               }
            }

            break;
         case 2:

            if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
               throw new ForbiddenHttpException('You don\'t have permission to view this page.');
            }
            $this->dataBahagian2(
               $lppid,
               $lpp->PYD,
               $tahun->lpp_tahun,
               $data,
               $init,
               $addon,
               $utama_telah,
               $utama_belum,
               $sama_telah,
               $sama_belum
            );
            $list = array_merge($addon, $utama_telah, $utama_belum, $sama_telah, $sama_belum);

            $finalArray = array();
            foreach ($list as $m) {
               if (!isset($finalArray[$m['LevelPengajian']]))
                  $finalArray[$m['LevelPengajian']] = $m;
               else {
                  $finalArray[$m['LevelPengajian']]['utama_telah'] += (int)$m['utama_telah'];
                  $finalArray[$m['LevelPengajian']]['utama_belum'] += (int)$m['utama_belum'];
                  $finalArray[$m['LevelPengajian']]['sama_telah'] += (int)$m['sama_telah'];
                  $finalArray[$m['LevelPengajian']]['sama_belum'] += (int)$m['sama_belum'];
                  $finalArray[$m['LevelPengajian']]['utama_telah'] = (string)$finalArray[$m['LevelPengajian']]['utama_telah'];
                  $finalArray[$m['LevelPengajian']]['utama_belum'] = (string)$finalArray[$m['LevelPengajian']]['utama_belum'];
                  $finalArray[$m['LevelPengajian']]['sama_telah'] = (string)$finalArray[$m['LevelPengajian']]['sama_telah'];
                  $finalArray[$m['LevelPengajian']]['sama_belum'] = (string)$finalArray[$m['LevelPengajian']]['sama_belum'];
               }
            }
            $finalArray = array_values($finalArray);
            foreach ($init as $in) {
               if (array_search($in['LevelPengajian'], array_column($finalArray, 'LevelPengajian')) === false) {
                  $finalArray[$in['LevelPengajian']] = $in;
               }
            }
            $pengajaran2 = array_values($finalArray);


            if (($waktu = TblPenyeliaanManual::findOne(['lpp_id' => $lppid])) != null) {
               $waktu = TblPenyeliaanManual::findAll(['lpp_id' => $lppid]);
               $selia2 = TblPenyeliaanManual::find()
                  ->select(new Expression('tahap_penyeliaan as LevelPengajian, utama_telah, utama_belum, sama_telah, sama_belum'))
                  ->where(['lpp_id' => $lppid])
                  ->asArray()
                  ->all();
            } else {
               $waktu = [new TblPenyeliaanManual()];
               for ($i = 0; $i < 1; $i++) {
                  $waktu[] = new TblPenyeliaanManual();
               }
               $selia2 = array();
            }
            $dataProvider = new ActiveDataProvider([
               'query' => $data,
               'pagination' => [
                  'pageSize' => 10,
               ],
            ]);
            break;
         case 3:

            if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
               throw new ForbiddenHttpException('You don\'t have permission to view this page.');
            }
            $this->dataBahagian3($lppid, $lpp->PYD, $tahun->lpp_tahun, $list, $penyelidikan2, $grant);
            $pengajaran2 = array_merge($list, $penyelidikan2);
            $waktu = null;
            break;
         case 4:

            if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
               throw new ForbiddenHttpException('You don\'t have permission to view this page.');
            }
            $this->dataBahagian4($lpp->PYD, $tahun->lpp_tahun, $pengajaran2, $lpp->lpp_id);
            $waktu = null;
            break;
         case 5:

            if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
               throw new ForbiddenHttpException('You don\'t have permission to view this page.');
            }
            $this->dataBahagian5($lpp->PYD, $tahun->lpp_tahun, $conference, $pereka, $inovasi);
            $pengajaran2 = array_merge($conference, $pereka, $inovasi);
            $waktu = null;
            break;
         case 6:

            if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
               throw new ForbiddenHttpException('You don\'t have permission to view this page.');
            }
            $this->dataBahagian6($lppid, $lpp->PYD, $tahun->lpp_tahun, $conference, $manual, $manual2);
            $pengajaran2 = array_merge($conference, $manual);
            $waktu = null;
            break;
         case 7:

            if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
               throw new ForbiddenHttpException('You don\'t have permission to view this page.');
            }
            $this->dataBahagian7($lppid, $urus_tadbir, $result, $lpp->PYD);
            $pengajaran2 = array_merge($urus_tadbir, $result);

            $waktu = null;
            break;
         case 8:

            if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
               throw new ForbiddenHttpException('You don\'t have permission to view this page.');
            }
            $this->dataBahagian8(
               $lppid,
               $lpp->PYD,
               $tahun->lpp_tahun,
               $penyelia_ketua,
               $pen_ketua_telah,
               $pen_ketua_belum,
               $selidik,
               $selidik_add,
               $conf,
               $perundingan,
               $perundingan_manual,
               $publication,
               $pengajaran2
            );
            $waktu = null;
            break;
         case 9:
            $pengajaran = RefAspekPenilaian::find()
               ->where(['bhg_no' => 9])
               ->orderBy('id')
               ->asArray()
               ->all();

            $pengajaran2 = RefAspekPenilaian::find()
               ->where(['bhg_no' => 9])
               ->orderBy('id')
               ->indexBy('id')
               ->asArray()
               ->all();
            if (TblMrkhBhg::find()->where(['lpp_id' => $lppid, 'bhg_id' => 9])->one() != null) {
               $mrkhbhg9 = TblMrkhBhg::find()->where(['lpp_id' => $lppid, 'bhg_id' => 9])->one();
            } else {
               $mrkhbhg9 = new TblMrkhBhg();
            }
            if (TblMrkhAspek::find()->where(['lpp_id' => $lppid, 'bhg_no' => 9])->all() != null) {
               $models = TblMrkhAspek::find()->where(['lpp_id' => $lppid, 'bhg_no' => 9])
                  ->indexBy('aspek_id')
                  ->all();
            } else {
               $models = [new TblMrkhAspek()];
               for ($i = 0; $i < sizeof($pengajaran2); $i++) {
                  $models[] = new TblMrkhAspek();
                  $models[$i]->aspek_id = $pengajaran[$i]['id'];
               }
            }
            if ($waktu = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->all() != null) {
               $waktu = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->all();
               $waktu2 = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->asArray()->all();




               $sum_ppp = 0;
               $sum_ppk = 0;
               $sum_peer = 0;
               foreach ($models as $ii => $model) {
                  if (is_null($model->aspek_id)) {
                     continue;
                  }
                  $model->lpp_id = $lppid;
                  $model->bhg_no = 9;
                  $model->markah_ppp = ($waktu2[$model->aspek_id]['markah_ppp'] / 100) * 20;
                  $model->markah_ppk = ($waktu2[$model->aspek_id]['markah_ppk'] / 100) * 20;
                  $model->markah_peer = ($waktu2[$model->aspek_id]['markah_peer']) * (20 / 100);
                  $sum_ppp += ($waktu2[$model->aspek_id]['markah_ppp'] / 100) * 20;
                  $sum_ppk += ($waktu2[$model->aspek_id]['markah_ppk'] / 100) * 20;
                  $sum_peer += ($waktu2[$model->aspek_id]['markah_peer']) * (20 / 100);
                  $model->save(false);
               }
               $ppp = $sum_ppp * (25 / 100);
               $ppk = $sum_ppk * (55 / 100);
               $peer = $sum_peer * (20 / 100);
               $mrkhbhg9->lpp_id = $lppid;
               $mrkhbhg9->bhg_id = 9;
               $pmberat_bhg9 = TblPemberatBhg::find()
                  ->where([
                     'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept1),
                     'kump_gred_id' => $gred->ref_kump_gred_id, 'bhg_id' => 9
                  ])
                  ->one();
               $mrkhbhg9->markah = ($ppp + $ppk + $peer) * ($pmberat_bhg9->pemberat / 100);
               $mrkhbhg9->save(false);
            } else {
               $waktu = [new TblMarkahKualiti()];
               for ($i = 0; $i < sizeof($pengajaran2); $i++) {
                  $waktu[$i] = new TblMarkahKualiti();
                  $waktu[$i]->ref_kualiti_id = $pengajaran[$i]['id'];
               }
            }
            if (Model::loadMultiple($waktu, Yii::$app->request->post()) && $valid =  Model::validateMultiple($waktu)) {
               if ($valid) {
                  $transaction = \Yii::$app->db->beginTransaction();
                  try {
                     foreach ($waktu as $wk) {
                        $wk->lpp_id = $lppid;
                        if (!($flag = $wk->save(false))) {
                           $transaction->rollBack();
                           break;
                        }
                     }
                     if ($flag) {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Markah berjaya disimpan! Sila buat pengesahan anda.']);
                        return $this->refresh();
                     }
                  } catch (Exception $e) {
                     $transaction->rollBack();
                  }
               }
            }
            $mrkhBhg = RefAspekPenilaian::find()
               ->select(['`hrm`.`elnpt_ref_aspek_penilaian`.`id`, `hrm`.`elnpt_ref_aspek_penilaian`.`aspek`, coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor, 
                    coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) as markah_pyd,`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 
                    `hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, `hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, `hrm`.`elnpt_tbl_pemberat_aspek`.pemberat'])
               ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.aspek_id = `hrm`.`elnpt_ref_aspek_penilaian`.id and `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid . '')
               ->leftJoin('`hrm`.`elnpt_tbl_pemberat_aspek`', '`hrm`.`elnpt_tbl_pemberat_aspek`.aspek_id = `hrm`.`elnpt_ref_aspek_penilaian`.id and `hrm`.`elnpt_tbl_pemberat_aspek`.kump_dept_id =' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' and `hrm`.`elnpt_tbl_pemberat_aspek`.kump_gred_id =' . $gred->ref_kump_gred_id . '')
               ->andWhere(['`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`' => $bhg_no])


               ->asArray()
               ->all();
            $mrkh_bhg = \yii\helpers\ArrayHelper::toArray($mrkhBhg, [], false);
            $this->calcOverallMark($lppid);

            return $this->render('semak_bahagian', [
               'lppid' => $lppid,
               'data' => $pengajaran2,
               'input' => $waktu,
               'rubric' => $subpro1,
               'mrkh_all' => $mrkh_all,
               'pemberat' => $mrkh_bhg_pemberat,
               'mrkh_bhg' => $mrkh_bhg,
               'bhgian' => $nama,
               'menu' => $menu,
               'lpp' => $lpp,
               'tahun' => $tahun,
               'req' => $this->checkRequest($lppid)
            ]);

         case 10:

            if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
               throw new ForbiddenHttpException('You don\'t have permission to view this page.');
            }

            $pengajaran2 = 1;
            if (($waktu = TblKlinikal::findOne(['lpp_id' => $lppid])) != null) {
               $waktu = TblKlinikal::findOne(['lpp_id' => $lppid]);
            } else {
               $waktu = new TblKlinikal();
            }
            if ($waktu->load(Yii::$app->request->post())) {
               $waktu->lpp_id = $lppid;
               if ($waktu->save(false)) {
                  $ntf = new Notification();
                  $ntf->icno = $lpp->PYD;
                  $ntf->title = 'Pengesahan APC oleh Ketua Program/PPP untuk ruangan Perkhidmatan Klinikal';
                  $ntf->content = "Sila semak bahagian 10 di e-LNPT anda.";
                  $ntf->ntf_dt = date('Y-m-d H:i:s');
                  $ntf->save();
                  \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya ditambah!']);
                  return $this->refresh();
               }
            }
            break;
      }




      if (Yii::$app->request->post('aspek_id')) {

         $aspek = Yii::$app->request->post('aspek_id');
         $data = Yii::$app->request->post('markah_ppp');
         $data2 = Yii::$app->request->post('markah_ppk');
         if ($data) {
            foreach ($data as $key => $val) {
               $new_data[$aspek[$key]] = $val;
            }
         }
         if ($data2) {
            foreach ($data2 as $key => $val) {
               $new_data1[$aspek[$key]] = $val;
            }
         }
         $bhg_mrkh = TblMrkhAspek::find()
            ->rightJoin('hrm.elnpt_ref_aspek_penilaian', 'hrm.elnpt_ref_aspek_penilaian.id = hrm.elnpt_tbl_mrkh_aspek.aspek_id'
               . ' and hrm.elnpt_tbl_mrkh_aspek.lpp_id = ' . $lppid)
            ->where(['hrm.elnpt_ref_aspek_penilaian.bhg_no' => $bhg_no])
            ->indexBy('aspek_id')
            ->orderBy(['ISNULL(hrm.elnpt_tbl_mrkh_aspek.aspek_id)' => SORT_ASC]);


         $transaction = \Yii::$app->db->beginTransaction();
         try {
            $cntt = 0;
            foreach ($bhg_mrkh->all() as $wk) {
               if ($data) {
                  if ($new_data) {
                     $wk->markah_ppp = $new_data[is_null($wk->aspek_id) ? $aspek[$cntt] : $wk->aspek_id];
                  }
               }
               if ($data2) {
                  if ($new_data1) {
                     $wk->markah_ppk = $new_data1[is_null($wk->aspek_id) ? $aspek[$cntt] : $wk->aspek_id];
                  }
               }
               if ($wk->validate()) {
                  if (!($flag = $wk->save())) {
                     $transaction->rollBack();
                     break;
                  }
               } else {
                  $transaction->rollBack();
                  break;
               }
               $cntt++;
            }
            if (($flag = $wk->save())) {
               $transaction->commit();
               $this->calcOverallMark($lppid);
               \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Markah berjaya disimpan!']);
               return $this->redirect(['semak-lpp', 'lppid' => $lppid, 'bhg_no' => $bhg_no]);
            }
         } catch (Exception $e) {
            $transaction->rollBack();
         }
      }
      $mrkhBhg = RefAspekPenilaian::find()
         ->select(['`hrm`.`elnpt_ref_aspek_penilaian`.`id`, `hrm`.`elnpt_ref_aspek_penilaian`.`aspek`, coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor, 
                    coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) as markah_pyd,`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 
                    `hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, `hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, `hrm`.`elnpt_tbl_pemberat_aspek`.pemberat'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.aspek_id = `hrm`.`elnpt_ref_aspek_penilaian`.id and `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid . '')
         ->leftJoin('`hrm`.`elnpt_tbl_pemberat_aspek`', '`hrm`.`elnpt_tbl_pemberat_aspek`.aspek_id = `hrm`.`elnpt_ref_aspek_penilaian`.id and `hrm`.`elnpt_tbl_pemberat_aspek`.kump_dept_id =' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : (($nama->id == 2) ? $this->findKumpDept2($lpp) : $dept->ref_kump_dept_id)) . ' and `hrm`.`elnpt_tbl_pemberat_aspek`.kump_gred_id =' . $gred->ref_kump_gred_id . '')
         ->andWhere(['`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`' => $bhg_no])


         ->asArray()
         ->all();
      $mrkh_bhg = \yii\helpers\ArrayHelper::toArray($mrkhBhg, [], false);
      // if (Yii::$app->request->isPjax) {
      //    $runner = new ConsoleCommandRunner();
      //    $runner->run('elnpt2/bahagian' . $bhg_no, [$lppid, $lpp->PYD]); 

      //    return $this->render('semak_bahagian', [
      //       'lppid' => $lppid,
      //       'data' => $pengajaran2,
      //       'data2' => $dataProvider,
      //       'input' => $waktu,
      //       'rubric' => $subpro1,
      //       'mrkh_all' => $mrkh_all,
      //       'pemberat' => $mrkh_bhg_pemberat,
      //       'mrkh_bhg' => $mrkh_bhg,
      //       'bhgian' => $nama,
      //       'menu' => $menu,
      //       'lpp' => $lpp,
      //       'tahun' => $tahun,
      //    ]);
      // } 

      return $this->render('semak_bahagian', [
         'lppid' => $lppid,
         'data' => $pengajaran2,
         'data2' => $dataProvider,
         'input' => $waktu,
         'rubric' => $subpro1,
         'mrkh_all' => $mrkh_all,
         'pemberat' => $mrkh_bhg_pemberat,
         'mrkh_bhg' => $mrkh_bhg,
         'bhgian' => $nama,
         'menu' => $menu,
         'lpp' => $lpp,
         'tahun' => $tahun,
         'req' => $this->checkRequest($lppid)
      ]);
   }

   public function findMarkahPemberat($aspek_id, $lppid)
   {
      $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      $query = TblPemberatAspek::find()
         ->select('pemberat')
         ->where(['kump_dept_id' => $this->findKumpDept($lpp), 'kump_gred_id' => $this->findKumpGred($lpp), 'aspek_id' => $aspek_id])
         ->one();
      return $query;
   }

   public function findMarkahPemberat2($aspek_id, $lppid)
   {
      $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      $query = TblPemberatAspek::find()
         ->select('pemberat')
         ->where(['kump_dept_id' => $this->findKumpDept2($lpp), 'kump_gred_id' => $this->findKumpGred($lpp), 'aspek_id' => $aspek_id])
         ->one();
      return $query;
   }

   public function findRubric($bhg_no, $lppid)
   {
      $query = RefAspekRubrik::find()
         ->select([
            '`hrm`.`elnpt_ref_aspek_penilaian`.id aspek_id', '`hrm`.`elnpt_ref_aspek_penilaian`.aspek', '`hrm`.`elnpt_ref_aspek_penilaian`.desc', '`hrm`.`elnpt_ref_aspek_rubrik`.penilaian',
            '`hrm`.`elnpt_ref_aspek_rubrik`.skor', '`hrm`.`elnpt_tbl_peratus_rubrik`.peratus', '`hrm`.`elnpt_ref_aspek_penilaian`.aspek', '`hrm`.`elnpt_ref_aspek_rubrik`.threshold'
         ])
         ->leftJoin('`hrm`.`elnpt_tbl_peratus_rubrik`', '`hrm`.`elnpt_ref_aspek_rubrik`.id = `hrm`.`elnpt_tbl_peratus_rubrik`.aspek_rubrik_id')
         ->leftJoin('`hrm`.`elnpt_ref_aspek_penilaian`', '`hrm`.`elnpt_ref_aspek_rubrik`.aspek_id = `hrm`.`elnpt_ref_aspek_penilaian`.id')
         ->where(['`hrm`.`elnpt_tbl_peratus_rubrik`.kump_rubrik_id' => $this->findKumpRubric($lppid), '`hrm`.`elnpt_ref_aspek_penilaian`.bhg_no' => $bhg_no])
         ->asArray()
         ->all();
      return $query;
   }

   public function findMarkahBahagian($bhg_no, $lppid)
   {
      $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      $query = RefAspekPenilaian::find()
         ->select(['`hrm`.`elnpt_ref_aspek_penilaian`.`id`, `hrm`.`elnpt_ref_aspek_penilaian`.`desc`, `hrm`.`elnpt_ref_aspek_penilaian`.`aspek`, coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor, 
                    coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) as markah_pyd,`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 
                    `hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, `hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, `hrm`.`elnpt_tbl_pemberat_aspek`.pemberat'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.aspek_id = `hrm`.`elnpt_ref_aspek_penilaian`.id and `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid . '')
         ->leftJoin('`hrm`.`elnpt_tbl_pemberat_aspek`', '`hrm`.`elnpt_tbl_pemberat_aspek`.aspek_id = `hrm`.`elnpt_ref_aspek_penilaian`.id and `hrm`.`elnpt_tbl_pemberat_aspek`.kump_dept_id =' . $this->findKumpDept($lpp) . ' and `hrm`.`elnpt_tbl_pemberat_aspek`.kump_gred_id =' . $this->findKumpGred($lpp) . '')
         ->andWhere(['`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`' => $bhg_no])


         ->asArray()
         ->all();
      return $query;
   }

   public function findMarkahBahagian2($bhg_no, $lppid)
   {
      $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      $query = RefAspekPenilaian::find()
         ->select(['`hrm`.`elnpt_ref_aspek_penilaian`.`id`, `hrm`.`elnpt_ref_aspek_penilaian`.`desc`, `hrm`.`elnpt_ref_aspek_penilaian`.`aspek`, coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor, 
                    coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) as markah_pyd,`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 
                    `hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, `hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, `hrm`.`elnpt_tbl_pemberat_aspek`.pemberat'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.aspek_id = `hrm`.`elnpt_ref_aspek_penilaian`.id and `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid . '')
         ->leftJoin('`hrm`.`elnpt_tbl_pemberat_aspek`', '`hrm`.`elnpt_tbl_pemberat_aspek`.aspek_id = `hrm`.`elnpt_ref_aspek_penilaian`.id and `hrm`.`elnpt_tbl_pemberat_aspek`.kump_dept_id =' . $this->findKumpDept2($lpp) . ' and `hrm`.`elnpt_tbl_pemberat_aspek`.kump_gred_id =' . $this->findKumpGred($lpp) . '')
         ->andWhere(['`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`' => $bhg_no])


         ->asArray()
         ->all();
      return $query;
   }

   public function findMarkahKeseluruhan($lppid)
   {
      $query = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_ref_bahagian`.`id`', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->rightJoin('(SELECT DISTINCT bhg_id FROM `hrm`.`elnpt_tbl_pemberat_bhg`) a', 'a.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $this->findKumpRubric($lppid)])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->asArray()
         ->all();
      return $query;
   }

   public function findPemberatBahagian($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one();
      $dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->max('ref_kump_dept_id');
      $query = TblPemberatBhg::find()
         ->select(['pemberat'])
         ->where(['kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept), 'kump_gred_id' => $gred->ref_kump_gred_id])
         ->orderBy(['bhg_id' => SORT_ASC])
         ->asArray()
         ->all();

      return $query;
   }

   public function menuBahagian($lppid)
   {
      $query = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_ref_bahagian`.`id`', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id`  AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $this->findKumpRubric($lppid)])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->asArray()
         ->all();
      return $query;
   }

   public function menuBahagian2($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one();
      $dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->one();
      $rubric = TblKumpRubrik::find()->where([
         'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id),
         'kump_gred_id' => $gred->ref_kump_gred_id
      ])->one();
      $query = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_ref_bahagian`.`id`', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->asArray()
         ->all();
      return $query;
   }

   public function findKumpRubric($lppid)
   {
      $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      if (($rubric = TblKumpRubrik::find()->where([
         'kump_dept_id' => $this->findKumpDept($lpp),
         'kump_gred_id' => $this->findKumpGred($lpp)
      ])->one()) != null) {
         return $rubric->kump_rubrik_id;
      }
      throw new NotFoundHttpException('The requested page does not exist.');
   }

   public function findKumpGred($lpp)
   {
      if (($gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one()) != null) {
         return $gred->ref_kump_gred_id;
      }
      throw new NotFoundHttpException('The requested page does not exist.');
   }

   public function findKumpDept($lpp)
   {
      if (($dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->one()) != null) {
         return (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id);
      }
      throw new NotFoundHttpException('The requested page does not exist.');
   }

   public function findKumpDept2($lpp)
   {
      if (($dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->orderBy(['id' => SORT_DESC])->one()) != null) {
         return (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id);
      }
      throw new NotFoundHttpException('The requested page does not exist.');
   }

   public function calcOverallMark($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
      $gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one();
      $dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->one();
      $rubric = TblKumpRubrik::find()->where([
         'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id),
         'kump_gred_id' => $gred->ref_kump_gred_id
      ])->one();
      $bhgMrkh = TblMrkhAspek::find()
         ->select(['bhg_no, ROUND((sum(markah_ppp + markah_ppk)/2 * (pemberat/100)), 2) as mrkh_bhg'])
         ->leftJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
         ->where(['lpp_id' => $lppid])
         ->groupBy('bhg_no');

      $req = $this->checkRequest($lppid);

      if ((!is_null($bhgMrkh) && (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)) || $req) {
         $arry = $bhgMrkh->asArray()->all();
         if (
            TblMrkhBhg::find()->where(['lpp_id' => $lppid])
            ->rightJoin('hrm.elnpt_tbl_bhg_kump', 'hrm.elnpt_tbl_bhg_kump.bhg_id = hrm.elnpt_tbl_mrkh_bhg.bhg_id AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
            ->where(['hrm.elnpt_tbl_bhg_kump.kump_rubrik_id' => $rubric->kump_rubrik_id])
            ->indexBy('bhg_id')
            ->all() != null
         ) {
            $models = TblMrkhBhg::find()
               ->rightJoin('hrm.elnpt_tbl_bhg_kump', 'hrm.elnpt_tbl_bhg_kump.bhg_id = hrm.elnpt_tbl_mrkh_bhg.bhg_id AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
               ->where(['hrm.elnpt_tbl_bhg_kump.kump_rubrik_id' => $rubric->kump_rubrik_id])
               ->indexBy('bhg_id')
               ->all();
         } else {
            $models = [new TblMrkhBhg()];
            for ($i = 0; $i < sizeof($arry); $i++) {
               $models[] = new TblMrkhBhg();
            }
         }
         $cnt = 0;
         foreach ($models as $ii => $model) {
            if (is_null($model->id)) {
               $model = new TblMrkhBhg();
            }
            if (empty($arry[$cnt]['bhg_no'])) {
               continue;
            }
            $model->lpp_id = $lppid;
            $model->bhg_id =  $arry[$cnt]['bhg_no'];
            $model->markah =  $arry[$cnt]['mrkh_bhg'];
            $model->save(false);
            $cnt++;
         }
      }
   }

   public function actionDashboard()
   {
      $totalPerYear = TblMain::find()
         ->alias('a')
         ->select('a.tahun,count(a.lpp_id) as cnt')
         ->where(['or', ['NOT LIKE', 'COALESCE (a.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (a.catatan, \'\')', 'cuti']])
         ->groupBy('a.tahun')
         ->asArray()
         ->all();

      // return VarDumper::dump($totalPerYear, $depth = 10, $highlight = true);

      return $this->render('dashboard', [
         'totalPerYear' => $totalPerYear,
      ]);
   }

   public function actionPenetapanTahunPenilaian()
   {
      $query = TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_DESC]);
      $dataProvider = new ActiveDataProvider([
         'query' => $query,
         'sort' => false,

      ]);
      return $this->render('lpp_tahun', [
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionTambahTahunPenilaian()
   {
      $tahun_lpp = new TblLppTahun();
      if ($tahun_lpp->load(Yii::$app->request->post())) {
         if ($tahun_lpp->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tahun Penilaian berjaya ditambah!']);
            return $this->redirect('penetapan-tahun-penilaian');
         }
      }
      return $this->renderAjax('tmbh_tahun', ['model' => $tahun_lpp]);
   }

   public function actionKemaskiniTahunPenilaian($tahun)
   {
      $tahun_lpp = TblLppTahun::findOne(['lpp_tahun' => $tahun]);
      if ($tahun_lpp->load(Yii::$app->request->post())) {
         if ($tahun_lpp->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tahun Penilaian berjaya dikemaskini!']);
            return $this->redirect('penetapan-tahun-penilaian');
         }
      }
      return $this->renderAjax('tmbh_tahun', ['model' => $tahun_lpp]);
   }

   public function actionPendaftaranPenetapPenilai($thn = 2019)
   {
      \yii\helpers\Url::remember();
      $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();
      $query = TblKumpDept::find()
         ->select([
            'hrm.elnpt_tbl_kump_dept.dept_id', 'hronline.department.fullname',
            'hronline.tblprcobiodata.CONm', 'hrm.elnpt_tbl_penetap_penilai.tahun',
            'hrm.elnpt_tbl_penetap_penilai.id'
         ])
         ->joinWith('dept', false, 'LEFT JOIN')
         // ->joinWith('penetapPenilai', false, 'LEFT JOIN')
         // ->joinWith('penetapPenilai', false, 'LEFT JOIN')
         ->joinWith([
            'penetapPenilai' => function ($query) use ($thn) {
               $query->onCondition(['tahun' => $thn]);
            },
         ])
         ->joinWith('penetapPenilai.namaPenetap')
         ->where(['!=', 'ref_kump_dept_id', '10'])
         // ->andWhere(['`hrm`.`elnpt_tbl_penetap_penilai`.`tahun`' => $thn])
         ->orderBy(['dept_id' => SORT_ASC]);
      $dataProvider = new SqlDataProvider([
         'sql' => $query->createCommand()->getRawSql(),
         'key' => 'dept_id',
         'pagination' => [
            'pageSize' => 10,
         ],
      ]);
      return $this->render('daftar_penetap', [
         'dataProvider' => $dataProvider,
         // 'tahun' => $tahun->lpp_tahun,
         'tahun' => $thn
      ]);
   }

   public function actionKemaskiniPenetapPenilai($dept_id, $tahun, $id = null)
   {
      // $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one(); 
      if (($penetap = TblPenetapPenilai::findOne(['ref_kump_dept' => $dept_id, 'tahun' => $tahun, 'id' => $id])) != null) {
         $penetap = TblPenetapPenilai::findOne(['ref_kump_dept' => $dept_id, 'tahun' => $tahun, 'id' => $id]);
      } else {
         $penetap = new TblPenetapPenilai();
      }
      if ($penetap->load(Yii::$app->request->post())) {
         $penetap->ref_kump_dept = $dept_id;
         if ($penetap->save(false)) {
            $url = ['elnpt/penetap-penilai'];
            $ntf = new Notification();
            $ntf->icno = $penetap->penetap_icno;
            $ntf->title = 'Penetap Penilai Borang eLNPT';
            $ntf->content = "Anda dilantik sebagai Penetap Penilai dalam Sistem LNPT Akademik. Setelah berbincang dengan Ketua Jabatan, mohon pihak tuan/puan membuat penetapan PPP, PPK dan PEER untuk semua kakitangan di Jabatan tuan/puan melalui " . Html::a('pautan ini', $url, []) . ".";
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save();
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat penetap berjaya dikemaskini!']);
            return $this->goBack();
         }
      }
      return $this->renderAjax('set_penetap', ['model' => $penetap]);
   }

   public function actionRemovePenetapPenilai($id, $tahun)
   {
      $penetap = TblPenetapPenilai::find()->where(['id' => $id, 'tahun' => $tahun])->one();
      if ($penetap->delete()) {
         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat penetap berjaya dikemaskini!']);
         return $this->redirect('pendaftaran-penetap-penilai?thn=' . $tahun);
      }
   }

   public function actionListPenetap()
   {
      $out = [];
      if (isset($_POST['depdrop_parents'])) {
         $parents = $_POST['depdrop_parents'];
         if ($parents != null) {
            $cat_id = $parents[0];
            $out = \app\models\hronline\Tblprcobiodata::find()
               ->select(['id' => 'ICNO', 'name' => 'CONm'])
               ->where(['DeptId' => $cat_id])
               ->asArray()
               ->all();



            return Json::encode(['output' => $out, 'selected' => '']);
         }
      }
      return Json::encode(['output' => '', 'selected' => '']);
   }

   public function actionPenetapanPppPpkPeer()
   {
      \yii\helpers\Url::remember();
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere('hrm.elnpt_tbl_main.is_deleted = 0');
      return $this->render('ppp_ppk', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionPantauPergerakanBorang()
   {
      \yii\helpers\Url::remember();
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere('hrm.elnpt_tbl_main.is_deleted = 0');
      return $this->render('pantau_gerak', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionPenetapPantauPergerakanBorang()
   {
      \yii\helpers\Url::remember();
      $penetap = TblPenetapPenilai::find()
         // ->leftJoin(['a' => 'hrm.elnpt_tbl_lpp_tahun'], 'a.lpp_tahun = hrm.elnpt_tbl_penetap_penilai.tahun and a.lpp_aktif = \'Y\'')
         ->where(['penetap_icno' => Yii::$app->user->identity->ICNO])
         // ->andWhere(['tahun' =>  date('Y')])
         ->asArray()
         ->all();
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider
         ->query
         ->andWhere([
            'jfpiu' => ArrayHelper::getColumn($penetap, 'penetap_jfpiu'), 'is_deleted' => 0,
            // 'tahun' => $penetap->tahun
         ]);
      return $this->render('penetap_pantau_gerak', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionCarianBorang()
   {
      \yii\helpers\Url::remember();
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere('hrm.elnpt_tbl_main.is_deleted = 0');
      return $this->render('carian_borang', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionCarianBorangV2()
   {
      \yii\helpers\Url::remember();
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('carian_borang_v2', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionCarianBorangPenilai()
   {
      \yii\helpers\Url::remember();
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('carian_borang_penilai', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionResetBorang()
   {
      \yii\helpers\Url::remember();
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere('hrm.elnpt_tbl_main.is_deleted = 0');
      return $this->render('reset_borang', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionReset($lpp_id)
   {



      $model = TblMain::findOne($lpp_id);
      if ($model->load(Yii::$app->request->post())) {
         if ($model->PYD_sah == 1) {
            if (is_null($model->PYD_sah_datetime)) {
               new \yii\db\Expression('NOW()');
            }
         } else {
            $model->PYD_sah_datetime = null;
         }
         if ($model->PPP_sah == 1) {
            if (is_null($model->PPP_sah_datetime)) {
               new \yii\db\Expression('NOW()');
            }
         } else {
            $model->PPP_sah_datetime = null;
         }
         if ($model->PPK_sah == 1) {
            if (is_null($model->PPK_sah_datetime)) {
               new \yii\db\Expression('NOW()');
            }
         } else {
            $model->PPK_sah_datetime = null;
         }
         if ($model->PEER_sah == 1) {
            if (is_null($model->PEER_sah_datetime)) {
               new \yii\db\Expression('NOW()');
            }
         } else {
            $model->PEER_sah_datetime = null;
         }
         if ($model->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya dikemaskini!']);
            return $this->goBack();
         }
      }
      return $this->renderAjax('reset_brg', ['model' => $model]);
   }

   public function actionKemaskiniPegawaiPenilai($lpp_id)
   {
      $model = TblMain::findOne($lpp_id);
      if ($model->load(Yii::$app->request->post())) {



         if ($model->save(false) && $model->validate()) {

            if (!empty($model->PPP)) {
               $ntf = new Notification();
               $ntf->icno = $model->PPP;
               $ntf->title = 'Penilaian borang eLNPT';
               $ntf->content = "Anda dilantik sebagai PPP kepada " . $model->guru->CONm . ". Sila layari <strong>" . Html::a('pautan ini', ['elnpt/senarai-pyd-ppp'], []) . "</strong> dan jalankan proses penilaian mengikut prosedur dan tempoh yang ditetapkan.";
               $ntf->ntf_dt = date('Y-m-d H:i:s');
               $ntf->save();
            }
            if (!empty($model->PPK)) {
               $ntf = new Notification();
               $ntf->icno = $model->PPK;
               $ntf->title = 'Penilaian borang eLNPT';
               $ntf->content = "Anda dilantik sebagai PPK kepada " . $model->guru->CONm . ". Sila layari <strong>" . Html::a('pautan ini', ['elnpt/senarai-pyd-ppk'], []) . "</strong> dan jalankan proses penilaian mengikut prosedur dan tempoh yang ditetapkan.";
               $ntf->ntf_dt = date('Y-m-d H:i:s');
               $ntf->save();
            }
            if (!empty($model->PEER)) {
               $ntf = new Notification();
               $ntf->icno = $model->PEER;
               $ntf->title = 'Penilaian borang eLNPT';
               $ntf->content = "Anda dilantik sebagai PEER kepada " . $model->guru->CONm . ". Sila layari <strong>" . Html::a('pautan ini', ['elnpt/senarai-pyd-peer'], []) . "</strong> dan jalankan proses penilaian mengikut prosedur dan tempoh yang ditetapkan.";
               $ntf->ntf_dt = date('Y-m-d H:i:s');
               $ntf->save();
            }
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pegawai Penilai berjaya dikemaskini!']);
            return $this->goBack();
         }
      }
      return $this->renderAjax('kemaskini_penilai', ['model' => $model]);
   }



   public function actionNotifyAll($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      if (Yii::$app->request->isAjax) {
         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
         $url = ['elnpt/maklumat-guru', 'lppid' => $lppid];
         if ($lpp->PYD_sah != 1 and $lpp->PYD != NULL) {
            $ntf = new Notification();
            $ntf->icno = $lpp->PYD;
            $ntf->title = 'Pengesahan borang LNPT';
            $ntf->content = "Sila buat pengesahan borang LNPT anda.";
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save();
         }
         if ($lpp->PPP_sah != 1 and $lpp->PPP != NULL) {
            $ntf = new Notification();
            $ntf->icno = $lpp->PPP;
            $ntf->title = 'Pengesahan borang LNPT';
            $ntf->content = "Sila buat pengesahan borang LNPT anda.";
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save();
         }
         if ($lpp->PPK_sah != 1 and $lpp->PPK != NULL) {
            $ntf = new Notification();
            $ntf->icno = $lpp->PPK;
            $ntf->title = 'Pengesahan borang LNPT';
            $ntf->content = "Sila buat pengesahan borang LNPT anda.";
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save();
         }
         if ($lpp->PEER_sah != 1 and $lpp->PEER != NULL) {
            $ntf = new Notification();
            $ntf->icno = $lpp->PEER;
            $ntf->title = 'Pengesahan borang eLNPT';
            $ntf->content = "Klik " . Html::a('sini', $url, []) . " untuk membuat pengesahan borang hrm.elnpt_";
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save();
         }
         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Peringatan berjaya dihantar!']);
         return 1;
      }
      return 0;
   }

   public function actionResetSemakan($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      if (Yii::$app->request->isAjax) {
         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
         $lpp->markah_sah = 0;
         $lpp->markah_sah_datetime = null;
         $lpp->save(false);
         TblAlasanSemakan::deleteAll(['lpp_id' => $lpp->lpp_id]);
         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Semakan markah berjaya direset!']);
         return 1;
      }
      return 0;
   }

   public function actionPenetapNotifyAll($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      if (Yii::$app->request->isAjax) {
         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
         $url = ['elnpt/maklumat-guru', 'lppid' => $lppid];
         if ($lpp->PYD_sah != 1 and $lpp->PYD != NULL) {
            $ntf = new Notification();
            $ntf->icno = $lpp->PYD;
            $ntf->title = 'Pengesahan borang LNPT';
            $ntf->content = "Sila buat pengesahan borang LNPT anda.";
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save();
         }
         if ($lpp->PPP_sah != 1 and $lpp->PPP != NULL) {
            $ntf = new Notification();
            $ntf->icno = $lpp->PPP;
            $ntf->title = 'Pengesahan borang LNPT (PPP)';
            $ntf->content = "Sila buat pengesahan borang LNPT " . $lpp->guru->CONm;
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save();
         }
         if ($lpp->PPK_sah != 1 and $lpp->PPK != NULL) {
            $ntf = new Notification();
            $ntf->icno = $lpp->PPK;
            $ntf->title = 'Pengesahan borang LNPT (PPK)';
            $ntf->content = "Sila buat pengesahan borang LNPT " . $lpp->guru->CONm;
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save();
         }
         if ($lpp->PEER_sah != 1 and $lpp->PEER != NULL) {
            $ntf = new Notification();
            $ntf->icno = $lpp->PEER;
            $ntf->title = 'Pengesahan borang eLNPT (PEER)';
            $ntf->content = "Sila buat pengesahan borang LNPT " . $lpp->guru->CONm;
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save();
         }
         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Peringatan berjaya dihantar!']);
         return 1;
      }
      return 0;
   }

   public function actionTendangPyd($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      if (Yii::$app->request->isAjax) {
         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
         $lpp->PYD_sah = 0;
         $lpp->PYD_sah_datetime = null;
         $lpp->save(false);
         $ntf = new Notification();
         $ntf->icno = $lpp->PYD;
         $ntf->title = 'Semak Semula LNPT';
         $ntf->content = "Mohon agar PYD semak semula (revise) maklumat dalam borang LNPT.";
         $ntf->ntf_dt = date('Y-m-d H:i:s');
         $ntf->save();
         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Peringatan berjaya dihantar!']);
         return 1;
      }
      return 0;
   }

   public function actionTendangPpp($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      if (Yii::$app->request->isAjax) {
         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
         $lpp->PPP_sah = 0;
         $lpp->PPP_sah_datetime = null;
         $lpp->save(false);
         $ntf = new Notification();
         $ntf->icno = $lpp->PPP;
         $ntf->title = 'Semak Semula LNPT';
         $ntf->content = "Mohon agar PPP semak semula (revise) markah PYD (" . $lpp->guru->CONm . ").";
         $ntf->ntf_dt = date('Y-m-d H:i:s');
         $ntf->save();
         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Peringatan berjaya dihantar!']);
         return 1;
      }
      return 0;
   }

   public function actionStatusPenghantaranBorang()
   {
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      return $this->render('status_hantar', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionMarkahTerkini()
   {
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      return $this->render('status_hantar', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionSenaraiPydPpp()
   {
      $id =  Yii::$app->user->getId();
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere(['hrm.elnpt_tbl_main.PPP' => $id])
         // ->andWhere(['tahun' => 2019])
         ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']]);
      return $this->render('senarai_pyd', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
         'label_revise' => 'PYD SEMAK SEMULA'
      ]);
   }

   public function actionSenaraiPydPpk()
   {
      $id =  Yii::$app->user->getId();
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere(['hrm.elnpt_tbl_main.PPK' => $id])
         // ->andWhere(['tahun' => 2019])
         ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']]);
      return $this->render('senarai_pyd', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
         'label_revise' => 'PPP SEMAK SEMULA'
      ]);
   }

   public function actionSenaraiPydPeer()
   {
      $id =  Yii::$app->user->getId();
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere(['hrm.elnpt_tbl_main.PEER' => $id])
         // ->andWhere(['tahun' => 2019])
         ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']]);
      return $this->render('senarai_peer', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }



   public function actionPenetapanAksesTesting()
   {
      $searchModel = new TblTestingBiodataSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      return $this->render('akses_testing', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionAkses($ICNO)
   {
      $bio = Tblprcobiodata::findOne(['ICNO' => $ICNO]);
      if (TblTestingAccess::findOne(['icno' => $ICNO]) != null) {
         $model = TblTestingAccess::findOne(['icno' => $ICNO]);
      } else {
         $model = new TblTestingAccess();
      }
      if ($model->load(Yii::$app->request->post())) {
         $model->icno = $ICNO;
         if ($model->access == 0) {
            $model->delete();
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Akses berjaya disimpan!']);
            return $this->redirect('penetapan-akses-testing');
         } else {
            $model->save();
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Akses berjaya disimpan!']);
            return $this->redirect('penetapan-akses-testing');
         }
      }
      return $this->renderAjax('kemaskini_akses', ['bio' => $bio, 'model' => $model]);
   }

   public function actionIcnoList()
   {
      $out = [];
      if (isset($_POST['depdrop_parents'])) {
         $parents = $_POST['depdrop_parents'];
         if ($parents != null) {
            $cat_id = $parents[0];
            $out = Tblprcobiodata::find()
               ->select(['ICNO as id', new Expression('CONCAT(CONm, \' - \', a.`gred`) as name')])
               ->leftJoin(['a' => 'hronline.gredjawatan'], 'a.id = hronline.tblprcobiodata.gredJawatan')

               ->where(['`hronline`.`tblprcobiodata`.Status' => [1, 2, 3, 4, 5]])
               ->andWhere(['`hronline`.`tblprcobiodata`.`DeptId`' => $cat_id])
               ->asArray()
               ->all();

            return Json::encode(['output' => $out, 'selected' => '']);
         }
      }
      return Json::encode(['output' => $out, 'selected' => '']);
   }

   public function actionUrusStatusBorang()
   {
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      return $this->render('padam_lpp', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionDeleteLpp($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $model = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      if (Yii::$app->request->isAjax) {
         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
         $model->is_deleted = 1;
         $model->deleted_by = Yii::$app->user->identity->ICNO;
         $model->deleted_datetime = new \yii\db\Expression('NOW()');
         $model->save(false);
         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang eLNPT berjaya dipadam!']);
         return 1;
      }
      return 0;
   }

   public function actionOpenLpp($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $model = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      if (Yii::$app->request->isAjax) {
         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
         $model->is_deleted = 0;
         $model->deleted_by = null;
         $model->deleted_datetime = null;
         $model->save(false);
         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang eLNPT berjaya dibuka!']);
         return 1;
      }
      return 0;
   }

   public function actionPengesahanBorang($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one();
      $dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->one();
      $rubric = TblKumpRubrik::find()->where([
         'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id),
         'kump_gred_id' => $gred->ref_kump_gred_id
      ])->one();
      $menu = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_ref_bahagian`.`id`', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->asArray()
         ->all();
      return $this->render('pengesahan', [
         'lpp' => $lpp,
         'menu' => $menu,
         'lppid' => $lppid,
         'req' => $this->checkRequest($lppid)
      ]);
   }

   public function actionPengesahanMarkah($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one();
      $dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->one();
      $rubric = TblKumpRubrik::find()->where([
         'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id),
         'kump_gred_id' => $gred->ref_kump_gred_id
      ])->one();
      $menu = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_ref_bahagian`.`id`', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->asArray()
         ->all();
      return $this->render('pengesahan_markah', [
         'lpp' => $lpp,
         'menu' => $menu,
         'lppid' => $lppid,
         'req' => $this->checkRequest($lppid)
      ]);
   }

   public function actionMarkahSetuju($lppid)
   {
      \yii\helpers\Url::remember();
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $alasan = TblAlasanSemakan::find()->where(['lpp_id' => $lppid])->exists();


      $lpp->markah_sah = 1;
      $lpp->markah_sah_datetime = new \yii\db\Expression('NOW()');
      if ($lpp->validate() && !$alasan) {
         $lpp->save();
         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan markah telah dihantar!']);
         return $this->redirect(['elnpt/pengesahan-markah', 'lppid' => $lppid]);
      } else {
         \Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'warning', 'msg' => 'Pengesahan markah tidak berjaya!']);
         return $this->redirect(['elnpt/pengesahan-markah', 'lppid' => $lppid]);
      }
   }

   public function actionMohonSemak($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      if (($alasan = TblAlasanSemakan::findOne(['lpp_id' => $lppid])) != null) {
         $alasan = TblAlasanSemakan::findOne(['lpp_id' => $lppid]);
      } else {
         $alasan = null;
      }
      return $this->renderAjax('mohon_semak', [
         'model' => $lpp,
         'alasan' => $alasan
      ]);
   }

   public function actionMarkahTidakSetuju($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      if ($alasan = TblAlasanSemakan::find()->where(['lpp_id' => $lppid])->one()) {
         $alasan = TblAlasanSemakan::find()->where(['lpp_id' => $lppid])->indexBy('id_alasan')->all();
      } else {
         $alasan = [new TblAlasanSemakan()];
         for ($i = 0; $i < 3; $i++) {
            $alasan[] = new TblAlasanSemakan();
         }
      }
      $lpp->scenario = 'sah_pyd_markah';
      if (Model::loadMultiple($alasan, Yii::$app->request->post()) && Model::validateMultiple($alasan)) {
         foreach ($alasan as $index => $alas) {
            $alas->lpp_id = $lppid;
            $alas->id_alasan = $index;
            $alas->save(false);
         }
         $lpp->markah_sah = 0;
         $lpp->markah_sah_datetime = new \yii\db\Expression('NOW()');
         if ($lpp->save() && $lpp->validate()) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan anda berjaya dihantar!']);
            return $this->redirect(['elnpt/pengesahan-markah', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('sah_pyd_markah', [
         'model' => $alasan
      ]);
   }

   public function actionPengesahanPyd($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $lpp->scenario = 'sah_pyd';
      if ($lpp->load(Yii::$app->request->post())) {
         $lpp->PYD_sah_datetime = new \yii\db\Expression('NOW()');
         if ($lpp->save() && $lpp->validate()) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang eLNPT berjaya disahkan!']);
            return $this->redirect(['elnpt/pengesahan-borang', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('sah_pyd', [
         'model' => $lpp
      ]);
   }

   public function actionPengesahanPpp($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $lpp->scenario = 'sah_ppp';
      if ($lpp->load(Yii::$app->request->post())) {
         $lpp->PPP_sah_datetime = new \yii\db\Expression('NOW()');
         if ($lpp->save() && $lpp->validate()) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang eLNPT berjaya disahkan!']);
            return $this->redirect(['elnpt/pengesahan-borang', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('sah_ppp', [
         'model' => $lpp
      ]);
   }

   public function actionPengesahanPpk($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $lpp->scenario = 'sah_ppk';
      if ($lpp->load(Yii::$app->request->post())) {
         $lpp->PPK_sah_datetime = new \yii\db\Expression('NOW()');
         if ($lpp->save() && $lpp->validate()) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang eLNPT berjaya disahkan!']);
            return $this->redirect(['elnpt/pengesahan-borang', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('sah_ppk', [
         'model' => $lpp
      ]);
   }

   public function actionPengesahanPeer($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
      $lpp->scenario = 'sah_peer';
      if ($lpp->load(Yii::$app->request->post())) {
         $lpp->PEER_sah_datetime = new \yii\db\Expression('NOW()');
         if ($lpp->save() && $lpp->validate()) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang eLNPT berjaya disahkan!']);
            return $this->redirect(['elnpt/pengesahan-borang', 'lppid' => $lppid]);
         }
      }
      return $this->renderAjax('sah_peer', [
         'model' => $lpp
      ]);
   }

   public function actionMarkahBorang()
   {
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere(['hrm.elnpt_tbl_main.is_deleted' => 0]);
      return $this->render('mrkh_borang', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionSenaraiCutiBelajar()
   {
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere(['<>', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', '']);
      return $this->render('cuti_belajar', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionPengesahanMarkahBorang()
   {
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere(['hrm.elnpt_tbl_main.is_deleted' => 0]);
      return $this->render('pengesahan_mrkh_borang', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }


   public function actionPenetapanRubrikDept()
   {
      $searchModel = new TblKumpDeptSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('tetap_dept', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionKemaskiniRubrikDept($id)
   {
      $tahun_lpp = TblKumpDept::findOne(['id' => $id]);
      if ($tahun_lpp->load(Yii::$app->request->post())) {
         if ($tahun_lpp->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jabatan berjaya dikemaskini!']);
            return $this->redirect('penetapan-rubrik-dept');
         }
      }
      return $this->renderAjax('kemaskini_dept', ['model' => $tahun_lpp]);
   }

   public function actionPadamRubrikDept($id)
   {
      $tahun_lpp = TblKumpDept::findOne(['id' => $id]);
      $tahun_lpp->delete();
      \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jabatan berjaya dipadam!']);
      return $this->redirect(['penetapan-rubrik-dept']);
   }

   public function actionTambahRubrikDept()
   {
      $tahun_lpp = new TblKumpDept();
      if ($tahun_lpp->load(Yii::$app->request->post())) {
         if ($tahun_lpp->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jabatan berjaya ditambah!']);
            return $this->redirect('penetapan-rubrik-dept');
         }
      }
      return $this->renderAjax('tmbh_dept', ['model' => $tahun_lpp]);
   }

   public function actionPenetapPenilai()
   {
      \yii\helpers\Url::remember();
      $penetap = TblPenetapPenilai::find()
         // ->leftJoin(['a' => 'hrm.elnpt_tbl_lpp_tahun'], 'a.lpp_tahun = hrm.elnpt_tbl_penetap_penilai.tahun and a.lpp_aktif = \'Y\'')
         ->where(['penetap_icno' => Yii::$app->user->identity->ICNO])
         // ->andWhere(['tahun' =>  date('Y')])
         ->asArray()
         ->all();
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere([
         'jfpiu' => ArrayHelper::getColumn($penetap, 'penetap_jfpiu'), 'is_deleted' => 0,
         // 'jfpiu' => Yii::$app->user->identity->DeptId, 'is_deleted' => 0,
         // 'tahun' => $penetap->tahun
      ]);
      return $this->render('tetap_ppp_ppk_peer', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider
      ]);
   }

   public function actionRujukanPanduan()
   {
      return $this->render('rujukan_panduan');
   }

   public function actionPenetapanRubrikGred()
   {
      $searchModel = new TblKumpGredSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('tetap_gred', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionKemaskiniRubrikGred($id)
   {
      $tahun_lpp = TblKumpGred::findOne(['id' => $id]);
      if ($tahun_lpp->load(Yii::$app->request->post())) {
         if ($tahun_lpp->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Gred berjaya dikemaskini!']);
            return $this->redirect('penetapan-rubrik-gred');
         }
      }
      return $this->renderAjax('kemaskini_gred', ['model' => $tahun_lpp]);
   }

   public function actionPadamRubrikGred($id)
   {
      $tahun_lpp = TblKumpGred::findOne(['id' => $id]);
      $tahun_lpp->delete();
      \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Gred berjaya dipadam!']);
      return $this->redirect(['penetapan-rubrik-gred']);
   }

   public function actionTambahRubrikGred()
   {
      $tahun_lpp = new TblKumpGred();
      if ($tahun_lpp->load(Yii::$app->request->post())) {
         if ($tahun_lpp->save(false)) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Gred berjaya ditambah!']);
            return $this->redirect('penetapan-rubrik-gred');
         }
      }
      return $this->renderAjax('tmbh_gred', ['model' => $tahun_lpp]);
   }

   public function dataBahagian1($lppid, $icno, $tahun, &$pengajaran, &$pengajaran2, &$pengajaran3, &$blended)
   {
      $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      $pengajaran = TblPengajaran::find()
         ->where(['NOKP' => $icno])
         ->andWhere(['LIKE', 'SESI', $tahun])
         ->orderBy(['AutoId' => SORT_ASC])
         ->asArray()
         ->all();
      $pengajaran2 = TblPengajaran::find()
         ->select(new Expression('AutoId, SMP07_KodMP, NAMAKURSUS, BILPELAJAR, SEKSYEN, SESI, JAMKREDIT, \'0\' as DISPLAY'))
         ->where(['NOKP' => $icno])
         ->andWhere(['LIKE', 'SESI', $tahun])
         ->orderBy(['AutoId' => SORT_ASC])
         ->indexBy('AutoId')
         ->asArray()
         ->all();
      $pengajaran3 = TblPengajaranPembelajaran::find()
         ->select(new Expression('id as AutoId, kod_kursus as SMP07_KodMP, nama_kursus as NAMAKURSUS, bil_pelajar as BILPELAJAR, sesi as SESI, jam_kredit as JAMKREDIT, \'1\' as DISPLAY, seksyen as SEKSYEN'))
         ->where(['lpp_id' => $lppid])
         ->orderBy(['id' => SORT_ASC])
         ->indexBy('AutoId')
         ->asArray()
         ->all();
      $blended = TblBlendedLearningFarm::find()
         ->select('username_ic_pasportNo, fullname, status, lastname')
         ->where(['or', ['username_ic_pasportNo' => $icno], ['LIKE', 'lastname', $lpp->guru->CONm]])
         ->asArray()
         ->all();
      foreach ($blended as $ind => $b) {
         $blended[$ind]['kod_subjek'] = explode(' ', trim($b['fullname']))[0];
         $sesi = explode(' ', trim($b['fullname']));
         rsort($sesi);
         $blended[$ind]['sesi'] = str_replace(['[', ']'], '', $sesi[0]);
      }
      foreach ($pengajaran2 as $ind1 => $p2) {
         foreach ($blended as $b2) {
            if ((stripos($b2['kod_subjek'], $p2['SMP07_KodMP']) !== false) && ($p2['SESI'] == $b2['sesi'])) {
               $pengajaran2[$ind1]['status'] = 1;
               break;
            } else {
               $pengajaran2[$ind1]['status'] = 0;
            }
         }
      }
      foreach ($pengajaran3 as $ind1 => $p3) {
         foreach ($blended as $b3) {
            if ((stripos($b3['kod_subjek'], $p3['SMP07_KodMP']) !== false) && ($p3['SESI'] == $b3['sesi'])) {
               $pengajaran3[$ind1]['status'] = 1;
               break;
            } else {
               $pengajaran3[$ind1]['status'] = 0;
            }
         }
      }
   }

   public function dataBahagian2(
      $lppid,
      $icno,
      $tahun,
      &$data,
      &$init,
      &$addon,
      &$utama_telah,
      &$utama_belum,
      &$sama_telah,
      &$sama_belum
   ) {
      $init = TblPenyeliaan::find()
         ->select(new Expression('DISTINCT(LevelPengajian), \'0\' as utama_telah, \'0\' as utama_belum, \'0\' as sama_telah, \'0\' as sama_belum, \'0\' as id'))
         ->where(['!=', 'LevelPengajian', 'CERT'])
         ->asArray()
         ->all();
      $max = TblPenyeliaan::find()
         ->select(['[Nomatrik] as aaa, [NamaPelajar] as fvfv, [NoKpPenyelia] as ccc, MAX(SUBSTRING(KodSesi_Sem, 8, 4)) AS [Kod],'
            . 'MAX(SUBSTRING(KodSesi_Sem, 8, 4) + SUBSTRING(KodSesi_Sem, 1, 1)) as asd'])
         ->where(['NoKpPenyelia' => $icno])
         ->groupBy(['Nomatrik', 'NamaPelajar', 'NoKpPenyelia'])
         ->having(['>=', 'MAX(SUBSTRING(KodSesi_Sem, 8, 4))', $tahun]);
      $data = TblPenyeliaan::find()


         ->innerJoin(['b' => $max], 'b.aaa = [dbo].[Ext_HR02_Penyeliaan].[Nomatrik] and b.ccc = [dbo].[Ext_HR02_Penyeliaan].[NoKpPenyelia]')


         ->andWhere(new Expression('b.asd = (SUBSTRING(KodSesi_Sem, 8, 4) + SUBSTRING(KodSesi_Sem, 1, 1))'))
         ->andWhere(['[dbo].[Ext_HR02_Penyeliaan].[KodTahapPenyeliaan]' => [1, 3, 5, 4, 2]])
         ->andWhere(['[dbo].[Ext_HR02_Penyeliaan].[KodStatusPengajian]' => [51, 52, 53, 54, 56, 57, 01, 31, 32, 33, 06, 16]])
         ->andWhere(['!=', 'LevelPengajian', 'CERT']);
      $utama_telah = TblPenyeliaan::find()
         ->select(new Expression('\'0\' as id, LevelPengajian, COUNT(*) as utama_telah, \'0\' as utama_belum, \'0\' as sama_telah, \'0\' as sama_belum'))
         ->from($data)
         ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
         ->andWhere(['KodStatusPengajian' => [51, 52, 53, 54, 56, 57]])
         ->groupBy('LevelPengajian')
         ->asArray()
         ->all();

      $utama_belum = TblPenyeliaan::find()
         ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_telah, COUNT(*) as utama_belum, \'0\' as sama_telah, \'0\' as sama_belum'))
         ->from($data)


         ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
         ->andWhere(['KodStatusPengajian' => [01, 31, 32, 33, 06, 16]])
         ->groupBy('LevelPengajian')
         ->asArray()
         ->all();

      $sama_telah = TblPenyeliaan::find()
         ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_telah, \'0\' as utama_belum, COUNT(*) as sama_telah, \'0\' as sama_belum'))
         ->from($data)


         ->andWhere(['KodTahapPenyeliaan' => [3, 5]])
         ->andWhere(['KodStatusPengajian' => [51, 52, 53, 54, 56, 57]])
         ->groupBy('LevelPengajian')
         ->asArray()
         ->all();
      $sama_belum = TblPenyeliaan::find()
         ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_telah, \'0\' as utama_belum, \'0\' as sama_telah, COUNT(*) as sama_belum'))
         ->from($data)


         ->andWhere(['KodTahapPenyeliaan' => [3, 5]])
         ->andWhere(['KodStatusPengajian' => [01, 31, 32, 33, 06, 16]])
         ->groupBy('LevelPengajian')
         ->asArray()
         ->all();

      $addon = TblPenyeliaanManualAddOn::find()
         ->select(new Expression('id, tahap_penyeliaan as LevelPengajian, utama_telah, utama_belum, sama_telah, sama_belum'))
         ->where(['lpp_id' => $lppid])

         ->asArray()
         ->all();
   }

   public function dataBahagian3($lppid, $icno, $tahun, &$list, &$penyelidikan2, &$grant)
   {
      $list = TblPenyelidikan2::find()
         ->select(new Expression('ID, ProjectID, Title, Membership as Peranan, AgencyName, GrantLevelID as Tahap_geran, Amount, StartDate, EndDate, ResearchStatus as Status_geran, ExtensionNo as ExtraDuration, \'0\' as Display'))
         ->where(['IC' => $icno])
         ->andWhere(['OR', ['OR', ['>=', 'StartYear', $tahun], ['>=', 'EndYear', $tahun]], ['ResearchStatus' => 'Sedang Berjalan']])
         ->asArray()
         ->all();
      $penyelidikan2 = TblPenyelidikanManual::find()
         ->select(new Expression('id as ID, projek_id as ProjectID, tajuk_projek as Title, peranan as Peranan, pembiaya as AgencyName, kategori_pembiaya as Tahap_geran, jumlah_biaya as Amount, mula as StartDate, tamat as EndDate, status as Status_geran, \'0\' as ExtraDuration, \'1\' as Display'))
         ->where(['lpp_id' => $lppid])
         ->andWhere(['OR', ['YEAR(mula)' => $tahun], ['status' => 'Sedang Berjalan']])
         ->asArray()
         ->all();
      $grant = TblGrantApplication::find()
         ->where(['UserIC' => $icno, 'tahun' => $tahun])
         ->count();
   }

   public function dataBahagian4($icno, $tahun, &$publication, $lpp_id)
   {

      $except = TblException::find()->select('tahun')->where(['lpp_id' => $lpp_id])->asArray()->all();
      $publication = TblLnptPublicationV2::find()
         ->select(new Expression('Keterangan_PublicationTypeID as Bilangan_penerbitan, Title, PublicationYear, KeteranganBI_WriterStatus as Status_penulis, IndexingDesc as Status_indeks, Keterangan_PublicationStatus as Status_penerbitan'))
         ->from('SMP_PPI.dbo.vw_LNPT_PublicationV2')
         ->where(['User_Ic' => $icno])
         ->andWhere(['or', ['PublicationYear' => (empty($except) ? $tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))], ['SubmissionYear' => (empty($except) ? $tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))], ['AcceptanceYear' => (empty($except) ? $tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))]])
         ->andWhere([
            'or', ['ApproveStatus' => 'V', 'Keterangan_PublicationStatus' => 'Published'],
            ['Keterangan_PublicationStatus' => ['Paper Accepted', 'Paper Submitted']]
         ])
         ->asArray()
         ->all();
   }

   public function dataBahagian5($icno, $tahun, &$conference, &$pereka, &$inovasi)
   {
      $umsper = Tblprcobiodata::findOne(['ICNO' => $icno]);
      $conf = TblConference::find()
         ->select(['ConferenceTitle', 'Role', 'ConfLevel'])
         ->where(['IC' => $icno])
         ->andWhere(['or', ['YEAR(StartDate)' => $tahun], ['>=', 'YEAR(EndDate)', $tahun]])
         ->all();

      $conference = ArrayHelper::toArray($conf, [
         'app\models\elnpt\inovasi\TblConference' => [
            'Bilangan_Persidangan_dan_Inovasi' => function () {
               return 'PERSIDANGAN';
            },
            'ConferenceTitle',
            'Peranan_dalam_projek_Inovasi' => function ($conf) {
               return $conf->Role;
            },
            'Tahap_penyertaan' => function ($conf) {
               return $conf->ConfLevel;
            },
            'Amaun_pengkomersialan' => function ($conf) {
               return 0;
            },
         ],
      ]);
      $pereka = TblPertandinganPereka::find()
         ->select(new Expression('\'PERTANDINGAN INOVASI\' as Bilangan_Persidangan_dan_Inovasi, KodPereka as ConferenceTitle, Peranan as Peranan_dalam_projek_Inovasi, '
            . 'Tahap as Tahap_penyertaan, \'0\' as Amaun_pengkomersialan'))
         ->where(['NoIC' => $icno, 'Tahun' => $tahun])
         ->asArray()
         ->all();
      $inovasi = TblInovasi::find()
         ->select(new Expression('\'PERTANDINGAN INOVASI\' as Bilangan_Persidangan_dan_Inovasi, Tajuk as ConferenceTitle, Keahlian as Peranan_dalam_projek_Inovasi, '
            . 'Peringkat as Tahap_penyertaan, Jumlah as Amaun_pengkomersialan'))
         ->where(['NoStaf' => $umsper->COOldID])
         ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $tahun], ['>=', 'YEAR(TarikhAkhit)', $tahun]])
         ->asArray()
         ->all();
   }

   public function dataBahagian6($lppid, $icno, $tahun, &$conference, &$manual, &$manual2)
   {
      $umsper = Tblprcobiodata::findOne(['ICNO' => $icno]);
      $perundingan = TblConsultation::find()
         ->where(['NoStaf' => $umsper->COOldID])
         ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $tahun], ['>=', 'YEAR(TarikhAkhit)', $tahun]])
         ->all();
      $conference = ArrayHelper::toArray($perundingan, [
         'app\models\elnpt\outreaching\TblConsultation' => [
            'Bilangan_outreaching' => function ($conf) {
               return $conf->ConsultationType;
            },
            'Title' => function ($conf) {
               return $conf->Tajuk;
            },
            'Peranan_outreaching' => function ($conf) {
               return $conf->Keahlian;
            },
            'Tahap_outreaching' => function ($conf) {
               return $conf->Peringkat;
            },
            'Amaun_outreaching' => function ($conf) {
               return $conf->Jumlah;
            },
            'id' => function ($conf) {
               return '0';
            }
         ],
      ]);
      $manual = TblOutreachingManual::find()
         ->select(new Expression('id, kategori as Bilangan_outreaching, nama_projek as Title, peranan as Peranan_outreaching, tahap_penyertaan as Tahap_outreaching'
            . ', amaun as Amaun_outreaching'))
         ->where(['lpp_id' => $lppid])
         ->asArray()
         ->all();


      $manual2 = $manual;
      foreach ($manual as $ind => $mn) {
         switch ($mn['Amaun_outreaching']) {
            case 1:
               $manual[$ind]['Amaun_outreaching'] = 'RM 1 - RM 5,000';
               break;
            case 5001:
               $manual[$ind]['Amaun_outreaching'] = 'RM 5 - RM 25,000';
               break;
            case 25001:
               $manual[$ind]['Amaun_outreaching'] = 'RM 21,001 dan ke atas';
               break;
         }
      }
   }

   public function dataBahagian7($lppid, &$urus_tadbir, &$result, $icno)
   {
      $urus_tadbir = TblPengurusanPentadbiran::find()
         ->select(new Expression('id, kategori as Bilangan_jawatankuasa, nama_jawatan, peranan as Peranan_jawatankuasa, tahap_lantikan as Tahap_jawatankuasa'))
         ->where(['lpp_id' => $lppid])
         ->asArray()
         ->all();
      $connection = Yii::$app->getDb();
      $command = $connection->createCommand("
                    SELECT
                    '0'              AS `id`,
                    'PENTADBIRAN' as `Bilangan_jawatankuasa`,
          `a`.`description`   AS `nama_jawatan`,
          `b`.`position_name`   AS `Peranan_jawatankuasa`,
          `f`.`category` AS `Tahap_jawatankuasa`,
          `a`.`flag`            AS `flag`
        FROM ((((`hronline`.`tblrscoadminpost` `a`
            LEFT JOIN `hronline`.`adminposition` `b`
                ON ((`a`.`adminpos_id` = `b`.`id`)))
            LEFT JOIN `hronline`.`jawatankategori` `c`
                ON ((`b`.`position_type` = `c`.`id`)))
            LEFT JOIN `hronline`.`department` `d`
                ON ((`a`.`dept_id` = `d`.`id`)))
            LEFT JOIN `hronline`.`campus` `e`
                ON ((`a`.`campus_id` = `e`.`campus_id`))
            LEFT JOIN `hronline`.`dept_cat` `f`
                ON ((`d`.`category_id` = `f`.`id`))) 
        WHERE (`a`.`flag` = 1) AND (`a`.`ICNO` = '" . $icno . "')");
      $result = $command->queryAll();
   }

   public function dataBahagian8(
      $lppid,
      $icno,
      $tahun,
      &$penyelia_ketua,
      &$pen_ketua_telah,
      &$pen_ketua_belum,
      &$selidik,
      &$selidik_add,
      &$conf,
      &$perundingan,
      &$perundingan_manual,
      &$publication,
      &$sk
   ) {
      $max = TblPenyeliaan::find()
         ->select(['[Nomatrik] as aaa, [NamaPelajar] as fvfv, [NoKpPenyelia] as ccc, MAX(SUBSTRING(KodSesi_Sem, 8, 4)) AS [Kod],'
            . 'MAX(SUBSTRING(KodSesi_Sem, 8, 4) + SUBSTRING(KodSesi_Sem, 1, 1)) as asd'])
         ->where(['NoKpPenyelia' => $icno])
         ->groupBy(['Nomatrik', 'NamaPelajar', 'NoKpPenyelia'])
         ->having(['>=', 'MAX(SUBSTRING(KodSesi_Sem, 8, 4))', $tahun]);
      $data = TblPenyeliaan::find()


         ->innerJoin(['b' => $max], 'b.aaa = [dbo].[Ext_HR02_Penyeliaan].[Nomatrik] and b.ccc = [dbo].[Ext_HR02_Penyeliaan].[NoKpPenyelia]')


         ->andWhere(new Expression('b.asd = (SUBSTRING(KodSesi_Sem, 8, 4) + SUBSTRING(KodSesi_Sem, 1, 1))'))
         ->andWhere(['[dbo].[Ext_HR02_Penyeliaan].[KodTahapPenyeliaan]' => [1, 3, 5, 4, 2]])
         ->andWhere(['[dbo].[Ext_HR02_Penyeliaan].[KodStatusPengajian]' => [51, 52, 53, 54, 56, 57, 01, 31, 32, 33, 06, 16]]);



      $penyelia_ketua = TblPenyeliaan::find()
         ->from($data)
         ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
         ->andWhere(['KodStatusPengajian' => [01, 31, 32, 33, 06, 16, 51, 52, 53, 54, 56, 57]])


         ->count();


      $pen_ketua_telah = TblPenyeliaanManual::find()
         ->where(['lpp_id' => $lppid])
         ->sum('COALESCE(utama_telah,0)');
      $pen_ketua_belum = TblPenyeliaanManual::find()
         ->where(['lpp_id' => $lppid])
         ->sum('COALESCE(utama_belum,0)');
      $selidik = TblPenyelidikan2::find()
         ->select(new Expression('ID, ProjectID, Title, Membership as Peranan, AgencyName, GrantLevelID as Tahap_geran, Amount, StartDate, EndDate, ResearchStatus as Status_geran, ExtensionNo as ExtraDuration, \'0\' as Display'))
         ->where(['IC' => $icno])
         ->andWhere(['OR', ['OR', ['>=', 'StartYear', $tahun], ['>=', 'EndYear', $tahun]], ['ResearchStatus' => 'Sedang Berjalan']])
         ->andWhere(['Membership' => 'Leader'])
         ->count();
      $selidik_add = TblPenyelidikanManual::find()
         ->select(new Expression('id as ID, projek_id as ProjectID, tajuk_projek as Title, peranan as Peranan, pembiaya as AgencyName, kategori_pembiaya as Tahap_geran, jumlah_biaya as Amount, mula as StartDate, tamat as EndDate, status as Status_geran, \'0\' as ExtraDuration, \'1\' as Display'))
         ->where(['lpp_id' => $lppid])
         ->andWhere(['OR', ['YEAR(mula)' => $tahun], ['status' => 'Sedang Berjalan']])
         ->andWhere(['peranan' => 'Leader'])
         ->count();


      $publication = TblLnptPublicationV2::find()
         ->from('SMP_PPI.dbo.vw_LNPT_PublicationV2')



         ->where(['User_Ic' => $icno])
         ->andWhere(['or', ['PublicationYear' => $tahun], ['SubmissionYear' => $tahun], ['AcceptanceYear' => $tahun]])
         ->andWhere([
            'or', ['ApproveStatus' => 'V', 'Keterangan_PublicationStatus' => 'Published'],
            ['Keterangan_PublicationStatus' => ['Paper Accepted', 'Paper Submitted']]
         ])
         ->count();
      $umsper = Tblprcobiodata::findOne(['ICNO' => $icno]);
      $conf = TblConference::find()
         ->where(['IC' => $icno, 'Role' => ['Ketua', 'Pembentang', 'Pembentang Jemputan', 'Pembentang Poster', 'Keynote Speaker']])
         ->andWhere(['or', ['YEAR(StartDate)' => $tahun], ['>=', 'YEAR(EndDate)', $tahun]])
         ->count();
      $pereka = TblPertandinganPereka::find()

         ->where(['NoIC' => $icno, 'Tahun' => $tahun, 'Peranan' => 'KETUA'])
         ->count();
      $inovasi = TblInovasi::find()

         ->where(['NoStaf' => $umsper->COOldID, 'Keahlian' => 'Leader'])
         ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $tahun], ['>=', 'YEAR(TarikhAkhit)', $tahun]])
         ->count();
      $perundingan = TblConsultation::find()
         ->where(['NoStaf' => $umsper->COOldID, 'Keahlian' => ['Leader', 'Pengerusi Viva Voce', 'Pengerusi Viva']])
         ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $tahun], ['>=', 'YEAR(TarikhAkhit)', $tahun]])
         ->count();
      $perundingan_manual = TblOutreachingManual::find()

         ->where(['lpp_id' => $lppid, 'peranan' => [
            'Ketua', 'Keynote Speaker', 'Pengerusi Sesi',
            'Ketua Panel', 'Pengerusi Viva', 'Ketua Perunding', 'Ketua Penilai Geran',
            'Pengerusi Viva Voce', 'Ketua Editor Jurnal'
         ]])
         ->count();
      $sk['Penyeliaan'] = ['skor' => $penyelia_ketua + $pen_ketua_telah + $pen_ketua_belum, 'aspek' => 'PENYELIAAN (SEBAGAI PENYELIA UTAMA / PENGERUSI)', 'sumber' => 'Bahagian 2'];
      $sk['Penyelidikan'] = ['skor' => $selidik + $selidik_add, 'aspek' => 'PENYELIDIKAN (SEBAGAI KETUA)', 'sumber' => 'Bahagian 3'];
      $sk['Penerbitan'] = ['skor' => $publication, 'aspek' => 'PENERBITAN (SEBAGAI FIRST AUTHOR / CORRESPONDING AUTHOR / CHIEF EDITOR)', 'sumber' => 'Bahagian 4'];
      $sk['Inovasi'] = ['skor' => $conf + $pereka + $inovasi, 'aspek' => 'PERSIDANGAN / INOVASI (SEBAGAI KETUA / PEMBENTANG / PEMBENTANG JEMPUTAN / PEMBENTANG POSTER / KEYNOTE SPEAKER)', 'sumber' => 'Bahagian 5'];
      $sk['Outreaching'] = ['skor' => $perundingan + $perundingan_manual, 'aspek' => 'OUTREACHING (SEBAGAI KETUA)', 'sumber' => 'Bahagian 6'];
      $sk['Mentoring'] = [
         'skor' => $penyelia_ketua + $pen_ketua_telah + $pen_ketua_belum + $selidik + $selidik_add + $publication + $conf + $perundingan + $perundingan_manual,
         'aspek' => 'MENTORING', 'sumber' => 'Bahagian 2 - 6'
      ];
   }

   public function dataBahagian10($icno, $tahun, &$clinical)
   {
      $clinical = TblConsultationClinical::find()
         ->select("COUNT(*) as cnt")
         ->where(['ICKakitangan' => $icno])
         ->andWhere(['or', ['YEAR([TarikhMula])' => $tahun], ['>=', 'YEAR([TarikhAkhir])', $tahun]])
         ->one();
   }

   public function actionBukaBorangLpp()
   {
      \yii\helpers\Url::remember();
      $searchModel = new TblRequestSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere(['>', 'close_date',  new \yii\db\Expression('NOW()')]);
      return $this->render('buka_borang_lpp', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionBukaBorang()
   {
      $req = new TblRequest();
      if ($req->load(Yii::$app->request->post())) {
         $lpp = TblMain::findOne($req->lpp_id);
         if ($req->save()) {
            $ntf = new Notification();
            $ntf->icno = $req->ICNO;
            $ntf->title = ($lpp->PYD == $req->ICNO) ? 'Pengisian Semula Borang LNPT' : 'Semakan Semula Borang LNPT';
            $ntf->content = "Borang LNPT " . $lpp->guru->CONm . " dibuka semula sehingga " . $req->close_date;
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save();
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya dibuka!']);
            return $this->goBack();
         }
      }
      return $this->renderAjax('buka_borangg', ['model' => $req]);
   }

   public function actionKemaskiniBukaBorang($id)
   {
      $req = TblRequest::findOne(['id' => $id]);
      if ($req->load(Yii::$app->request->post())) {
         $lpp = TblMain::findOne($req->lpp_id);
         if ($req->save()) {
            $ntf = new Notification();
            $ntf->icno = $req->ICNO;
            $ntf->title = ($lpp->PYD == $req->ICNO) ? 'Pengisian Semula Borang LNPT' : 'Semakan Semula Borang LNPT';
            $ntf->content = "Borang LNPT " . $lpp->guru->CONm . " dibuka semula sehingga " . $req->close_date;
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save();
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya dikemaskini!']);
            return $this->goBack();
         }
      }
      return $this->renderAjax('buka_borangg', ['model' => $req]);
   }

   public function actionPadamBukaBorang($id)
   {
      $req = TblRequest::findOne(['id' => $id]);
      $req->delete();
      \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya ditutup!']);
      return $this->goBack();
   }

   public function checkRequest($lpp_id)
   {
      if ($req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO])) {
         $req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
         if (date('Y-m-d H:i:s') > $req->close_date) {
            $req->delete();
            return null;
         }
      }
      return $req;
   }

   public function LoginAsUser($id, $ori)
   {
      $initialId =  Yii::$app->user->identity->ICNO;
      if ($id == $initialId) {
      } else {

         $user =  \app\models\User::findIdentity($id);
         Yii::$app->user->setIdentity($user);
         Yii::$app->session->set('user.penilai', $user);
      }
   }

   public function actionGenerateReport()
   {
      \yii\helpers\Url::remember();
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andWhere('hrm.elnpt_tbl_main.is_deleted = 0');
      return $this->render('jana_laporan', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionGenerateReportV2()
   {
      \yii\helpers\Url::remember();

      $model = new \yii\base\DynamicModel([
         'jfpiu', 'tahun', 'range', 'purata'
      ]);

      $model->addRule(['tahun'], 'required')
         // ->addRule(['email'], 'email')
         ->addRule(['jfpiu', 'tahun'], 'integer')
         ->addRule(['purata'], 'number')
         ->addRule(['range'], 'safe')
         ->addRule(['purata'], 'required', ['when' => function ($model) {
            return $model->range != null;
         }, 'whenClient' => "function (attribute, value) {
            return $('#range').val() != '';
        }"]);

      if ($model->load(Yii::$app->request->post())) {
         $runner = new \tebazil\runner\ConsoleCommandRunner();
         $runner->run('task-queue/jana-elnpt-report', [
            $model->jfpiu,
            $model->tahun,
            $model->range,
            $model->purata,
            Yii::$app->user->identity->ICNO
         ]);

         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan sedang dijana. Sila tunggu']);
         return $this->goBack();
      }

      $listDls = new ActiveDataProvider([
         'query' => \app\models\system_core\TblDocuments::find()->where(['module' => Yii::$app->controller->id, 'deleted_by' => null])->orderBy(['created_dt' => SORT_DESC]),
         'pagination' => [
            'pageSize' => 5,
         ],
      ]);

      return $this->render('jana_laporan_v2', [
         'model' => $model,
         'listDownloads' => $listDls,
         'uapi' => new \app\components\UAPI,
      ]);
   }

   public function actionPengurusanCadanganApc()
   {
      \yii\helpers\Url::remember();
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->andFilterWhere(['>=', 'm.markah', 85]);

      $listDls = new ActiveDataProvider([
         'query' => \app\models\system_core\TblDocuments::find()->where(['module' => Yii::$app->controller->id, 'deleted_by' => null])->orderBy(['created_dt' => SORT_DESC]),
         'pagination' => [
            'pageSize' => 5,
         ],
      ]);

      return $this->render('cadangan_apc', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
         'listDownloads' => $listDls,
         'uapi' => new \app\components\UAPI,
      ]);
   }

   public function actionDeleteFile($filehash)
   {
      $file = Yii::$app->FileManager->DeleteFile($filehash);
      if ($file->status == true) {
         $model = \app\models\system_core\TblDocuments::find()->where(['filehash' => $filehash])->one();
         $model->deleted_by =  Yii::$app->user->identity->ICNO;
         $model->deleted_dt = new \yii\db\Expression('NOW()');
         $model->save(false);

         \Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Laporan berjaya dibuang!']);
         return $this->redirect(Yii::$app->request->referrer);
      }

      \Yii::$app->session->setFlash('warning', ['title' => 'Error', 'type' => 'error', 'msg' => 'File not found!']);
      return $this->redirect(Yii::$app->request->referrer);
   }

   public function actionCadanganApc($lpp_id)
   {
      $main = TblMain::findOne($lpp_id);
      $model = TblCadanganApc::findOne(['lpp_id' => $lpp_id]);
      if (!$model) {
         $model = new TblCadanganApc();
      }
      if ($model->load(Yii::$app->request->post())) {
         $model->lpp_id = $lpp_id;
         if ($model->save()) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Cadangan / keputusan berjaya dikemaskini!']);
            return $this->redirect(Yii::$app->request->referrer);
         }
      }
      return $this->renderAjax('cdg_apc', ['model' => $model, 'main' => $main]);
   }

   public function actionBuangCadanganApc($lpp_id)
   {
      $model = TblCadanganApc::findOne(['lpp_id' => $lpp_id]);
      $model->delete();
      \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Cadangan / keputusan berjaya dibuang!']);
      return $this->redirect(Yii::$app->request->referrer);
   }

   public function actionGenerateLaporanApc($tahun = null)
   {
      $parts = parse_url(Yii::$app->request->referrer);
      parse_str($parts['query'], $params);
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search($params);
      $dataProvider->query->andFilterWhere(['>=', 'm.markah', 85]);
      $q = $dataProvider->query->createCommand()->getRawSql();

      $tbl_query = new \app\models\system_core\TblQueries();
      $tbl_query->query = $q;
      $tbl_query->module = Yii::$app->controller->id;
      $tbl_query->created_by = Yii::$app->user->identity->ICNO;
      $tbl_query->created_dt = new \yii\db\Expression('NOW()');
      $tbl_query->save(false);

      $runner = new \tebazil\runner\ConsoleCommandRunner();
      $runner->run('task-queue/jana-apc-elnpt', [$tbl_query->query, $tahun, Yii::$app->user->identity->ICNO]);

      \Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'warning', 'msg' => 'Laporan sedang dijana. Sila tunggu']);
      return $this->redirect(Yii::$app->request->referrer);
   }

   public function actionGenerateBorang($lppid)
   {
      if (($lpp = TblMain::findOne(['lpp_id' => $lppid, 'PYD' => Yii::$app->user->identity->ICNO, 'PYD_sah' => 1, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PEER_sah' => 1])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid, 'PYD' => Yii::$app->user->identity->ICNO]);
      } else {
         throw new ForbiddenHttpException('You don\'t have permission to view this page.');
      };
      $query = TblMain::find()
         ->leftJoin('hrm.elnpt_tbl_lpp_tahun th', 'th.lpp_tahun = elnpt_tbl_main.tahun')
         ->andWhere(['lpp_id' => $lppid])
         ->one();
      if ($query === null) {
         throw new \yii\base\UserException('Sila buat permohonan borang terlebih dahulu.');
      }
      $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();
      $this->dataBahagian1(
         $lppid,
         $lpp->PYD,
         $tahun->lpp_tahun,
         $pengajaran,
         $pengajaran2,
         $pengajaran3,
         $blended
      );
      $list1 = $pengajaran2 + $pengajaran3;
      if (($input1 = TblJamWaktu::find()->where(['lpp_id' => $lppid])->indexBy('ref_id')->all()) != null) {
         $input1 = TblJamWaktu::find()->where(['lpp_id' => $lppid])->indexBy('ref_id')->all();
      } else {
         $input1 = [new TblJamWaktu()];
         for ($i = 0; $i < sizeof($pengajaran); $i++) {
            $input1[$i] = new TblJamWaktu();
            $input1[$i]->lpp_id = $lppid;
            $input1[$i]->ref_id = $pengajaran[$i]['AutoId'];
            $input1[$i]->save(false);
         }
      }
      $mrkh_bhg1 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(1, $lppid), [], false);
      $this->dataBahagian2(
         $lppid,
         $lpp->PYD,
         $tahun->lpp_tahun,
         $data,
         $init,
         $addon,
         $utama_telah,
         $utama_belum,
         $sama_telah,
         $sama_belum
      );
      $list = array_merge($addon, $utama_telah, $utama_belum, $sama_telah, $sama_belum);

      $finalArray = array();
      foreach ($list as $m) {
         if (!isset($finalArray[$m['LevelPengajian']]))
            $finalArray[$m['LevelPengajian']] = $m;
         else {
            $finalArray[$m['LevelPengajian']]['utama_telah'] += (int)$m['utama_telah'];
            $finalArray[$m['LevelPengajian']]['utama_belum'] += (int)$m['utama_belum'];
            $finalArray[$m['LevelPengajian']]['sama_telah'] += (int)$m['sama_telah'];
            $finalArray[$m['LevelPengajian']]['sama_belum'] += (int)$m['sama_belum'];
            $finalArray[$m['LevelPengajian']]['utama_telah'] = (string)$finalArray[$m['LevelPengajian']]['utama_telah'];
            $finalArray[$m['LevelPengajian']]['utama_belum'] = (string)$finalArray[$m['LevelPengajian']]['utama_belum'];
            $finalArray[$m['LevelPengajian']]['sama_telah'] = (string)$finalArray[$m['LevelPengajian']]['sama_telah'];
            $finalArray[$m['LevelPengajian']]['sama_belum'] = (string)$finalArray[$m['LevelPengajian']]['sama_belum'];
         }
      }
      $finalArray = array_values($finalArray);
      foreach ($init as $in) {
         if (array_search($in['LevelPengajian'], array_column($finalArray, 'LevelPengajian')) === false) {
            $finalArray[$in['LevelPengajian']] = $in;
         }
      }
      $pengajaran2 = array_values($finalArray);
      $waktu = TblPenyeliaanManual::find()->where(['lpp_id' => $lppid]);
      $mrkh_bhg2 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(2, $lppid), [], false);
      $this->dataBahagian3($lppid, $lpp->PYD, $tahun->lpp_tahun, $list, $penyelidikan2, $grant);
      $data3 = array_merge($list, $penyelidikan2);
      $mrkh_bhg3 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(3, $lppid), [], false);
      $this->dataBahagian4($lpp->PYD, $tahun->lpp_tahun, $data4, $lpp->lpp_id);
      $mrkh_bhg4 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(4, $lppid), [], false);
      $this->dataBahagian5($lpp->PYD, $tahun->lpp_tahun, $conference, $pereka, $inovasi);
      $data5 = array_merge($conference, $pereka, $inovasi);
      $mrkh_bhg5 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(5, $lppid), [], false);
      $this->dataBahagian6($lppid, $lpp->PYD, $tahun->lpp_tahun, $conference, $manual, $manual2);
      $data6 = array_merge($conference, $manual);
      $mrkh_bhg6 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(6, $lppid), [], false);
      $this->dataBahagian7($lppid, $urus_tadbir, $result, $lpp->PYD);
      $data7 = array_merge($urus_tadbir, $result);
      $mrkh_bhg7 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(7, $lppid), [], false);
      $this->dataBahagian8(
         $lppid,
         $lpp->PYD,
         $tahun->lpp_tahun,
         $penyelia_ketua,
         $pen_ketua_telah,
         $pen_ketua_belum,
         $selidik,
         $selidik_add,
         $conf,
         $perundingan,
         $perundingan_manual,
         $publication,
         $data8
      );
      $mrkh_bhg8 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(8, $lppid), [], false);
      $data9 = RefAspekPenilaian::find()
         ->where(['bhg_no' => 9])
         ->orderBy('id')
         ->indexBy('id')
         ->asArray()
         ->all();
      $input9 = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->all();
      $mrkh_bhg9 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(9, $lppid), [], false);

      $gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one();
      $dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->one();
      $rubric = TblKumpRubrik::find()->where([
         'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id),
         'kump_gred_id' => $gred->ref_kump_gred_id
      ])->one();
      $query1 = RefAspekPenilaian::find()
         ->select([
            '`hrm`.`elnpt_ref_aspek_penilaian`.`desc`', '`hrm`.`elnpt_ref_aspek_penilaian`.`aspek`', '`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no` as bhg_no', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor',
            'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) as markah_pyd', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 0) as markah_ppp', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, 0) as markah_ppk',
            'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, 0) as markah_peer', '`hrm`.`elnpt_ref_bahagian`.`id` as idd'
         ])
         ->leftJoin('`hrm`.`elnpt_ref_bahagian`', '`hrm`.`elnpt_ref_bahagian`.id = `hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_bhg_kump`.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id` = `hrm`.`elnpt_ref_aspek_penilaian`.`id` AND `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid)
         ->where(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`')
         ->asArray()
         ->all();
      $subpro = array();
      foreach ($query1 as $ind => $arry) {
         $subpro[$arry['idd']][$ind] = $arry;
      }

      $tmp = array();
      $tmp2 = array();
      foreach ($subpro as $ind => $sub) {
         $tmp2['desc'] = 'JUMLAH';
         $tmp2['skor'] = '';
         $tmp2['markah_pyd'] = array_sum(array_column($sub, 'markah_pyd'));
         $tmp2['markah_ppp'] = array_sum(array_column($sub, 'markah_ppp'));
         $tmp2['markah_ppk'] = array_sum(array_column($sub, 'markah_ppk'));
         $tmp2['markah_peer'] = array_sum(array_column($sub, 'markah_peer'));
         $tmp2['bhg_no'] = array_sum(array_column($sub, 'bhg_no'));
         $tmp[$ind] = $tmp2;
      }
      foreach ($subpro as $ind => $sb) {
         $subpro[$ind][] = $tmp[$ind];
      }
      $mrkh_seluruh = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_ref_bahagian`.`id`', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->rightJoin('(SELECT DISTINCT bhg_id FROM `hrm`.`elnpt_tbl_pemberat_bhg`) a', 'a.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->andWhere(['!=', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'Ringkasan'])
         ->asArray()
         ->all();
      $mrkh_all = \yii\helpers\ArrayHelper::toArray($mrkh_seluruh, [], false);
      $markah = (new \yii\db\Query())
         ->select(['`hrm`.`elnpt_ref_bahagian`.`id`, `hrm`.`elnpt_ref_bahagian`.`bahagian` AS aspek', 'COALESCE(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0.00) as markah', '`hrm`.`elnpt_ref_bahagian`.`bhg_color` AS warna'])
         ->from('`hrm`.`elnpt_ref_bahagian`')
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->rightJoin('(SELECT DISTINCT bhg_id FROM `hrm`.`elnpt_tbl_pemberat_bhg`) a', 'a.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_bhg_kump`.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->where(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->andWhere(['!=', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'Ringkasan'])
         ->indexBy('id');
      $dept1 = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->max('ref_kump_dept_id');
      $mrkh_bhg_pemberat = TblPemberatBhg::find()
         ->select(['pemberat', 'bhg_id'])
         ->where(['kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept1), 'kump_gred_id' => $gred->ref_kump_gred_id])
         ->indexBy(['bhg_id'])
         ->orderBy(['bhg_id' => SORT_ASC])
         ->asArray()
         ->all();
      $menu = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_ref_bahagian`.`id`', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->asArray()
         ->all();
      $arry = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`id` as bhg_no', new Expression('\'0\' as mrkh_bhg')])
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->andWhere(['!=', '`hrm`.`elnpt_ref_bahagian`.`id`', 11])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $pyd = TblMrkhAspek::find()
         ->select('bhg_no, (sum(markah_pyd) * (pemberat/100)) as mrkh_bhg')
         ->rightJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
         ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = `hrm`.`elnpt_tbl_bhg_kump`.bhg_id')
         ->where(['lpp_id' => $lppid])
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->andWhere(['!=', 'bhg_no', 9])
         ->groupBy('bhg_no')
         ->orderBy('bhg_no')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $pyd = array_replace_recursive($arry, $pyd);

      $ppp = TblMrkhAspek::find()
         ->select('bhg_no, (sum(markah_ppp) * (pemberat/100)) as mrkh_bhg')
         ->rightJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
         ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = `hrm`.`elnpt_tbl_bhg_kump`.bhg_id')
         ->where(['lpp_id' => $lppid])
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->groupBy('bhg_no')
         ->orderBy('bhg_no')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $ppp = array_replace_recursive($arry, $ppp);
      $ppk = TblMrkhAspek::find()
         ->select('bhg_no, (sum(markah_ppk) * (pemberat/100)) as mrkh_bhg')
         ->rightJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
         ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = `hrm`.`elnpt_tbl_bhg_kump`.bhg_id')
         ->where(['lpp_id' => $lppid])
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->groupBy('bhg_no')
         ->orderBy('bhg_no')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $ppk = array_replace_recursive($arry, $ppk);
      $total = TblMarkahKeseluruhan::findOne(['lpp_id' => $lppid]);

      $content = $this->renderPartial('_borangView', [
         'lpp' => $lpp,
         'lppid' => $lppid,
         'query' => $query,
         'input' => $input1,
         'data' => $list1,
         'rubric1' => $this->bhgRubric($lpp, 1),
         'mrkh_bhg1' => $mrkh_bhg1,
         'data2' => $pengajaran2,
         'input2' =>  $waktu->asArray()->all(),
         'rubric2' => $this->bhgRubric($lpp, 2),
         'mrkh_bhg2' => $mrkh_bhg2,
         'data3' => $data3,
         'rubric3' => $this->bhgRubric($lpp, 3),
         'mrkh_bhg3' => $mrkh_bhg3,
         'data4' => $data4,
         'rubric4' => $this->bhgRubric($lpp, 4),
         'mrkh_bhg4' => $mrkh_bhg4,
         'data5' => $data5,
         'rubric5' => $this->bhgRubric($lpp, 5),
         'mrkh_bhg5' => $mrkh_bhg5,
         'data6' => $data6,
         'rubric6' => $this->bhgRubric($lpp, 6),
         'mrkh_bhg6' => $mrkh_bhg6,
         'data7' => $data7,
         'rubric7' => $this->bhgRubric($lpp, 7),
         'mrkh_bhg7' => $mrkh_bhg7,
         'data8' => $data8,
         'rubric8' => $this->bhgRubric($lpp, 8),
         'mrkh_bhg8' => $mrkh_bhg8,
         'data9' => $data9,
         'input9' => $input9,
         'rubric9' => $this->bhgRubric($lpp, 9),
         'mrkh_bhg9' => $mrkh_bhg9,
         'summary' => $subpro,
         'markah' => $markah->all(),
         'pemberat' => $mrkh_bhg_pemberat,
         'summary' => $subpro,
         'mrkh_all' => $mrkh_all,
         'total' => is_null($total) ? 0 : $total->markah,
         'kategori' => is_null($total) ? '' : $total->kategori,
         'pyd' => $pyd,
         'ppp' => $ppp,
         'ppk' => $ppk,
      ]);

      $pdf = new Pdf([
         'mode' => Pdf::MODE_UTF8,
         'format' => Pdf::FORMAT_A4,
         'orientation' => Pdf::ORIENT_PORTRAIT,
         'destination' => Pdf::DEST_BROWSER,
         'filename' => 'borang_lnpt_akademik_' . $lppid,
         'content' => $content,

         'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
         'cssInline' => '.kv-heading-1{font-size:18px}',
         'options' =>  [
            'title' => 'Borang LNPT',
            'keywords' => 'krajee, grid, export, yii2-grid, pdf'
         ],
         'methods' => [
            'SetFooter' => ['{PAGENO}'],
         ]
      ]);

      return $pdf->render();
   }

   public function bhgRubric($lpp, $bhg_no)
   {
      $gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one();
      $dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->one();
      $dept1 = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->max('ref_kump_dept_id');
      $rubric = TblKumpRubrik::find()->where([
         'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id),
         'kump_gred_id' => $gred->ref_kump_gred_id
      ])->one();
      $findRubric = RefAspekRubrik::find()
         ->select([
            '`hrm`.`elnpt_ref_aspek_penilaian`.id aspek_id', '`hrm`.`elnpt_ref_aspek_penilaian`.aspek', '`hrm`.`elnpt_ref_aspek_penilaian`.desc', '`hrm`.`elnpt_ref_aspek_rubrik`.penilaian',
            '`hrm`.`elnpt_ref_aspek_rubrik`.skor', '`hrm`.`elnpt_tbl_peratus_rubrik`.peratus', '`hrm`.`elnpt_ref_aspek_penilaian`.aspek', '`hrm`.`elnpt_ref_aspek_rubrik`.threshold'
         ])
         ->leftJoin('`hrm`.`elnpt_tbl_peratus_rubrik`', '`hrm`.`elnpt_ref_aspek_rubrik`.id = `hrm`.`elnpt_tbl_peratus_rubrik`.aspek_rubrik_id')
         ->leftJoin('`hrm`.`elnpt_ref_aspek_penilaian`', '`hrm`.`elnpt_ref_aspek_rubrik`.aspek_id = `hrm`.`elnpt_ref_aspek_penilaian`.id')
         ->where(['`hrm`.`elnpt_tbl_peratus_rubrik`.kump_rubrik_id' => $rubric->kump_rubrik_id, '`hrm`.`elnpt_ref_aspek_penilaian`.bhg_no' => $bhg_no])
         ->asArray()
         ->all();
      $rubric_arry = \yii\helpers\ArrayHelper::toArray($findRubric, [], false);
      $subpro = array();
      foreach ($rubric_arry as $arry) {
         $subpro[$arry['aspek']][] = $arry;
      }
      $subpro1 = array();
      foreach ($rubric_arry as $arry) {
         $subpro1[$arry['desc']][] = $arry;
      }
      return $subpro1;
   }

   public function actionGenerateBorangAdmin($lppid)
   {
      if (($lpp = TblMain::findOne([
         'lpp_id' => $lppid,
         // 'PYD_sah' => 1, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PEER_sah' => 1
      ])) != null) {
         $lpp = TblMain::findOne(['lpp_id' => $lppid]);
      } else {
         throw new ForbiddenHttpException('You don\'t have permission to view this page.');
      };
      $query = TblMain::find()
         ->leftJoin('hrm.elnpt_tbl_lpp_tahun th', 'th.lpp_tahun = elnpt_tbl_main.tahun')
         ->andWhere(['lpp_id' => $lppid])
         ->one();
      if ($query === null) {
         throw new \yii\base\UserException('Sila buat permohonan borang terlebih dahulu.');
      }
      $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();
      $this->dataBahagian1(
         $lppid,
         $lpp->PYD,
         $tahun->lpp_tahun,
         $pengajaran,
         $pengajaran2,
         $pengajaran3,
         $blended
      );
      $list1 = $pengajaran2 + $pengajaran3;
      if (($input1 = TblJamWaktu::find()->where(['lpp_id' => $lppid])->indexBy('ref_id')->all()) != null) {
         $input1 = TblJamWaktu::find()->where(['lpp_id' => $lppid])->indexBy('ref_id')->all();
      } else {
         $input1 = [new TblJamWaktu()];
         for ($i = 0; $i < sizeof($pengajaran); $i++) {
            $input1[$i] = new TblJamWaktu();
            $input1[$i]->lpp_id = $lppid;
            $input1[$i]->ref_id = $pengajaran[$i]['AutoId'];
            $input1[$i]->save(false);
         }
      }
      $mrkh_bhg1 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(1, $lppid), [], false);
      $this->dataBahagian2(
         $lppid,
         $lpp->PYD,
         $tahun->lpp_tahun,
         $data,
         $init,
         $addon,
         $utama_telah,
         $utama_belum,
         $sama_telah,
         $sama_belum
      );
      $list = array_merge($addon, $utama_telah, $utama_belum, $sama_telah, $sama_belum);

      $finalArray = array();
      foreach ($list as $m) {
         if (!isset($finalArray[$m['LevelPengajian']]))
            $finalArray[$m['LevelPengajian']] = $m;
         else {
            $finalArray[$m['LevelPengajian']]['utama_telah'] += (int)$m['utama_telah'];
            $finalArray[$m['LevelPengajian']]['utama_belum'] += (int)$m['utama_belum'];
            $finalArray[$m['LevelPengajian']]['sama_telah'] += (int)$m['sama_telah'];
            $finalArray[$m['LevelPengajian']]['sama_belum'] += (int)$m['sama_belum'];
            $finalArray[$m['LevelPengajian']]['utama_telah'] = (string)$finalArray[$m['LevelPengajian']]['utama_telah'];
            $finalArray[$m['LevelPengajian']]['utama_belum'] = (string)$finalArray[$m['LevelPengajian']]['utama_belum'];
            $finalArray[$m['LevelPengajian']]['sama_telah'] = (string)$finalArray[$m['LevelPengajian']]['sama_telah'];
            $finalArray[$m['LevelPengajian']]['sama_belum'] = (string)$finalArray[$m['LevelPengajian']]['sama_belum'];
         }
      }
      $finalArray = array_values($finalArray);
      foreach ($init as $in) {
         if (array_search($in['LevelPengajian'], array_column($finalArray, 'LevelPengajian')) === false) {
            $finalArray[$in['LevelPengajian']] = $in;
         }
      }
      $pengajaran2 = array_values($finalArray);
      $waktu = TblPenyeliaanManual::find()->where(['lpp_id' => $lppid]);
      $mrkh_bhg2 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(2, $lppid), [], false);
      $this->dataBahagian3($lppid, $lpp->PYD, $tahun->lpp_tahun, $list, $penyelidikan2, $grant);
      $data3 = array_merge($list, $penyelidikan2);
      $mrkh_bhg3 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(3, $lppid), [], false);
      $this->dataBahagian4($lpp->PYD, $tahun->lpp_tahun, $data4, $lpp->lpp_id);
      $mrkh_bhg4 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(4, $lppid), [], false);
      $this->dataBahagian5($lpp->PYD, $tahun->lpp_tahun, $conference, $pereka, $inovasi);
      $data5 = array_merge($conference, $pereka, $inovasi);
      $mrkh_bhg5 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(5, $lppid), [], false);
      $this->dataBahagian6($lppid, $lpp->PYD, $tahun->lpp_tahun, $conference, $manual, $manual2);
      $data6 = array_merge($conference, $manual);
      $mrkh_bhg6 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(6, $lppid), [], false);
      $this->dataBahagian7($lppid, $urus_tadbir, $result, $lpp->PYD);
      $data7 = array_merge($urus_tadbir, $result);
      $mrkh_bhg7 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(7, $lppid), [], false);
      $this->dataBahagian8(
         $lppid,
         $lpp->PYD,
         $tahun->lpp_tahun,
         $penyelia_ketua,
         $pen_ketua_telah,
         $pen_ketua_belum,
         $selidik,
         $selidik_add,
         $conf,
         $perundingan,
         $perundingan_manual,
         $publication,
         $data8
      );
      $mrkh_bhg8 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(8, $lppid), [], false);
      $data9 = RefAspekPenilaian::find()
         ->where(['bhg_no' => 9])
         ->orderBy('id')
         ->indexBy('id')
         ->asArray()
         ->all();
      $input9 = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->all();
      $mrkh_bhg9 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(9, $lppid), [], false);

      $gred = TblKumpGred::find()->where(['gred_id' => $lpp->gred_jawatan_id])->one();
      $dept = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->one();
      $rubric = TblKumpRubrik::find()->where([
         'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id),
         'kump_gred_id' => $gred->ref_kump_gred_id
      ])->one();
      $query1 = RefAspekPenilaian::find()
         ->select([
            '`hrm`.`elnpt_ref_aspek_penilaian`.`desc`', '`hrm`.`elnpt_ref_aspek_penilaian`.`aspek`', '`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no` as bhg_no', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor',
            'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) as markah_pyd', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 0) as markah_ppp', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, 0) as markah_ppk',
            'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, 0) as markah_peer', '`hrm`.`elnpt_ref_bahagian`.`id` as idd'
         ])
         ->leftJoin('`hrm`.`elnpt_ref_bahagian`', '`hrm`.`elnpt_ref_bahagian`.id = `hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_bhg_kump`.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id` = `hrm`.`elnpt_ref_aspek_penilaian`.`id` AND `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid)
         ->where(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_aspek_penilaian`.`bhg_no`')
         ->asArray()
         ->all();
      $subpro = array();
      foreach ($query1 as $ind => $arry) {
         $subpro[$arry['idd']][$ind] = $arry;
      }

      $tmp = array();
      $tmp2 = array();
      foreach ($subpro as $ind => $sub) {
         $tmp2['desc'] = 'JUMLAH';
         $tmp2['skor'] = '';
         $tmp2['markah_pyd'] = array_sum(array_column($sub, 'markah_pyd'));
         $tmp2['markah_ppp'] = array_sum(array_column($sub, 'markah_ppp'));
         $tmp2['markah_ppk'] = array_sum(array_column($sub, 'markah_ppk'));
         $tmp2['markah_peer'] = array_sum(array_column($sub, 'markah_peer'));
         $tmp2['bhg_no'] = array_sum(array_column($sub, 'bhg_no'));
         $tmp[$ind] = $tmp2;
      }
      foreach ($subpro as $ind => $sb) {
         $subpro[$ind][] = $tmp[$ind];
      }
      $mrkh_seluruh = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_ref_bahagian`.`id`', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->rightJoin('(SELECT DISTINCT bhg_id FROM `hrm`.`elnpt_tbl_pemberat_bhg`) a', 'a.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->andWhere(['!=', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'Ringkasan'])
         ->asArray()
         ->all();
      $mrkh_all = \yii\helpers\ArrayHelper::toArray($mrkh_seluruh, [], false);
      $markah = (new \yii\db\Query())
         ->select(['`hrm`.`elnpt_ref_bahagian`.`id`, `hrm`.`elnpt_ref_bahagian`.`bahagian` AS aspek', 'COALESCE(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0.00) as markah', '`hrm`.`elnpt_ref_bahagian`.`bhg_color` AS warna'])
         ->from('`hrm`.`elnpt_ref_bahagian`')
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->rightJoin('(SELECT DISTINCT bhg_id FROM `hrm`.`elnpt_tbl_pemberat_bhg`) a', 'a.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_bhg_kump`.`bhg_id` = `hrm`.`elnpt_ref_bahagian`.`id`')
         ->where(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->andWhere(['!=', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'Ringkasan'])
         ->indexBy('id');
      $dept1 = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->max('ref_kump_dept_id');
      $mrkh_bhg_pemberat = TblPemberatBhg::find()
         ->select(['pemberat', 'bhg_id'])
         ->where(['kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept1), 'kump_gred_id' => $gred->ref_kump_gred_id])
         ->indexBy(['bhg_id'])
         ->orderBy(['bhg_id' => SORT_ASC])
         ->asArray()
         ->all();
      $menu = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_ref_bahagian`.`id`', '`hrm`.`elnpt_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
         ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->asArray()
         ->all();
      $arry = RefBahagian::find()
         ->select(['`hrm`.`elnpt_ref_bahagian`.`id` as bhg_no', new Expression('\'0\' as mrkh_bhg')])
         ->leftJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_bhg_kump`.`bhg_id`')
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->andWhere(['!=', '`hrm`.`elnpt_ref_bahagian`.`id`', 11])
         ->orderBy('`hrm`.`elnpt_ref_bahagian`.`id`')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $pyd = TblMrkhAspek::find()
         ->select('bhg_no, (sum(markah_pyd) * (pemberat/100)) as mrkh_bhg')
         ->rightJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
         ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = `hrm`.`elnpt_tbl_bhg_kump`.bhg_id')
         ->where(['lpp_id' => $lppid])
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->andWhere(['!=', 'bhg_no', 9])
         ->groupBy('bhg_no')
         ->orderBy('bhg_no')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $pyd = array_replace_recursive($arry, $pyd);

      $ppp = TblMrkhAspek::find()
         ->select('bhg_no, (sum(markah_ppp) * (pemberat/100)) as mrkh_bhg')
         ->rightJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
         ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = `hrm`.`elnpt_tbl_bhg_kump`.bhg_id')
         ->where(['lpp_id' => $lppid])
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->groupBy('bhg_no')
         ->orderBy('bhg_no')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $ppp = array_replace_recursive($arry, $ppp);
      $ppk = TblMrkhAspek::find()
         ->select('bhg_no, (sum(markah_ppk) * (pemberat/100)) as mrkh_bhg')
         ->rightJoin('`hrm`.`elnpt_tbl_pemberat_bhg`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = bhg_no AND kump_dept_id = ' . (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept->ref_kump_dept_id) . ' AND kump_gred_id = ' . $gred->ref_kump_gred_id)
         ->rightJoin('`hrm`.`elnpt_tbl_bhg_kump`', '`hrm`.`elnpt_tbl_pemberat_bhg`.bhg_id = `hrm`.`elnpt_tbl_bhg_kump`.bhg_id')
         ->where(['lpp_id' => $lppid])
         ->andWhere(['`hrm`.`elnpt_tbl_bhg_kump`.`kump_rubrik_id`' => $rubric->kump_rubrik_id])
         ->groupBy('bhg_no')
         ->orderBy('bhg_no')
         ->indexBy('bhg_no')
         ->asArray()
         ->all();
      $ppk = array_replace_recursive($arry, $ppk);
      $total = TblMarkahKeseluruhan::findOne(['lpp_id' => $lppid]);

      $content = $this->renderPartial('_borangView', [
         'lpp' => $lpp,
         'lppid' => $lppid,
         'query' => $query,
         'input' => $input1,
         'data' => $list1,
         'rubric1' => $this->bhgRubric($lpp, 1),
         'mrkh_bhg1' => $mrkh_bhg1,
         'data2' => $pengajaran2,
         'input2' =>  $waktu->asArray()->all(),
         'rubric2' => $this->bhgRubric($lpp, 2),
         'mrkh_bhg2' => $mrkh_bhg2,
         'data3' => $data3,
         'rubric3' => $this->bhgRubric($lpp, 3),
         'mrkh_bhg3' => $mrkh_bhg3,
         'data4' => $data4,
         'rubric4' => $this->bhgRubric($lpp, 4),
         'mrkh_bhg4' => $mrkh_bhg4,
         'data5' => $data5,
         'rubric5' => $this->bhgRubric($lpp, 5),
         'mrkh_bhg5' => $mrkh_bhg5,
         'data6' => $data6,
         'rubric6' => $this->bhgRubric($lpp, 6),
         'mrkh_bhg6' => $mrkh_bhg6,
         'data7' => $data7,
         'rubric7' => $this->bhgRubric($lpp, 7),
         'mrkh_bhg7' => $mrkh_bhg7,
         'data8' => $data8,
         'rubric8' => $this->bhgRubric($lpp, 8),
         'mrkh_bhg8' => $mrkh_bhg8,
         'data9' => $data9,
         'input9' => $input9,
         'rubric9' => $this->bhgRubric($lpp, 9),
         'mrkh_bhg9' => $mrkh_bhg9,
         'summary' => $subpro,
         'markah' => $markah->all(),
         'pemberat' => $mrkh_bhg_pemberat,
         'summary' => $subpro,
         'mrkh_all' => $mrkh_all,
         'total' => is_null($total) ? 0 : $total->markah,
         'kategori' => is_null($total) ? '' : $total->kategori,
         'pyd' => $pyd,
         'ppp' => $ppp,
         'ppk' => $ppk,
      ]);

      $pdf = new Pdf([
         'mode' => Pdf::MODE_UTF8,
         'format' => Pdf::FORMAT_A4,
         'orientation' => Pdf::ORIENT_PORTRAIT,
         'destination' => Pdf::DEST_BROWSER,
         'filename' => 'borang_lnpt_akademik_' . $lppid,
         'content' => $content,

         'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
         'cssInline' => '.kv-heading-1{font-size:18px}',
         'options' =>  [
            'title' => 'Borang LNPT',
            'keywords' => 'krajee, grid, export, yii2-grid, pdf'
         ],
         'methods' => [
            'SetFooter' => ['{PAGENO}'],
         ]
      ]);

      return $pdf->render();
   }

   public function getMarkahKualiti($lppid, &$mrkh_ppp, &$mrkh_ppk, &$mrkh_peer, $lpp, $gred)
   {
      if ($waktu2 = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->all() != null) {

         $waktu2 = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->asArray()->all();
         $dept1 = TblKumpDept::find()->where(['dept_id' => $lpp->jfpiu])->max('ref_kump_dept_id');
         $sum_ppp = 0;
         $sum_ppk = 0;
         $sum_peer = 0;
         foreach ($waktu2 as $ind => $wk) {
            $sum_ppp += ($waktu2[$ind]['markah_ppp'] / 100) * 20;
            $sum_ppk += ($waktu2[$ind]['markah_ppk'] / 100) * 20;
            $sum_peer += ($waktu2[$ind]['markah_peer']) * (20 / 100);
         }
         $pmberat_bhg9 = TblPemberatBhg::find()
            ->where([
               'kump_dept_id' => (isset($lpp->kump_dept_id) ? $lpp->kump_dept_id : $dept1),
               'kump_gred_id' => $gred->ref_kump_gred_id, 'bhg_id' => 9
            ])
            ->one();
         $mrkh_ppp = $sum_ppp * (25 / 100) * ($pmberat_bhg9->pemberat / 100);
         $mrkh_ppk = $sum_ppk * (55 / 100) * ($pmberat_bhg9->pemberat / 100);
         $mrkh_peer = $sum_peer * (20 / 100 * ($pmberat_bhg9->pemberat / 100));
      }
   }
   /**
    * Lists all TblKumpDept models.
    * @return mixed
    */

   public function actionTambahKumpDept()
   {
      $searchModel = new TblKumpDeptSearchV2();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      return $this->render('//elnpt/elnpt2/tmbh_dept/index', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }
   /**
    * Displays a single TblKumpDept model.
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */

   public function actionView($id)
   {
      return $this->render('//elnpt/elnpt2/tmbh_dept/view', [
         'model' => $this->findModel($id),
      ]);
   }
   /**
    * Creates a new TblKumpDept model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */

   public function actionCreate()
   {
      $model = new TblKumpDeptV2();
      if ($model->load(Yii::$app->request->post()) && $model->save()) {
         // return $this->redirect(['//elnpt/elnpt2/tmbh_dept/view', 'id' => $model->id]);
         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya ditambah!']);
         return $this->redirect(['elnpt/tambah-kump-dept']);
      }
      return $this->renderAjax('//elnpt/elnpt2/tmbh_dept/create', [
         'model' => $model,
      ]);
   }
   /**
    * Updates an existing TblKumpDept model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */

   public function actionUpdate($id)
   {
      $model = $this->findModel($id);
      if ($model->load(Yii::$app->request->post()) && $model->save()) {
         // return $this->redirect(['//elnpt/elnpt2/tmbh_dept/view', 'id' => $model->id]);
         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
         return $this->redirect(['elnpt/tambah-kump-dept']);
      }
      // return $this->renderAjax('kemaskini_akses', ['bio' => $bio, 'model' => $model]); 
      return $this->renderAjax('//elnpt/elnpt2/tmbh_dept/update', [
         'model' => $model,
      ]);
   }
   /**
    * Deletes an existing TblKumpDept model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */

   public function actionDelete($id)
   {
      $this->findModel($id)->delete();
      \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
      return $this->redirect(['elnpt/tambah-kump-dept']);
   }
   /**
    * Finds the TblKumpDept model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return TblKumpDept the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */

   protected function findModel($id)
   {
      if (($model = TblKumpDeptV2::findOne($id)) !== null) {
         return $model;
      }
      throw new NotFoundHttpException('The requested page does not exist.');
   }

   public function actionFixMarkah()
   {
      $runner = new \tebazil\runner\ConsoleCommandRunner();
      $runner->run('task-queue/fix-markah-elnpt', [
         2020,
      ]);
      \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Proses pembetulan markah telah bermula. Sila tunggu sebentar.']);
      // return $this->redirect('penetapan-tahun-penilaian');
      return $this->redirect(Yii::$app->request->referrer);
   }

   public function actionRunQueue()
   {
      $output = '';
      $runner = new ConsoleCommandRunner();
      $runner->run('queue/run');
      \Yii::$app->session->setFlash('alert', ['title' => 'Message', 'type' => 'info', 'msg' => "Proses berjaya. Sila tunggu sebentar."]);
      return $this->redirect(Yii::$app->request->referrer);
   }

   public function actionBengkelData()
   {
      $searchModel = new TblMainSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams, (Yii::$app->user->identity->ICNO == 810209105562) ? Yii::$app->user->identity->DeptId : null, (Yii::$app->user->identity->ICNO == 810209105562) ? 2020 : null);
      $dataProvider->query->andWhere(['hrm.elnpt_tbl_main.is_deleted' => 0]);
      $dataProvider->pagination->pageSize = 20;
      return $this->render('bengkel_data', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionMarkahBahagian()
   {
      if (isset($_POST['expandRowKey'])) {
         $model = TblMrkhBhg::find()->where(['lpp_id' => $_POST['expandRowKey']]);
         $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'sort' => false,
         ]);
         return $this->renderPartial('_mrkhBhg', ['dataProvider' => $dataProvider]);
      } else {
         return '<div class="alert alert-danger">No data found</div>';
      }
   }
}
