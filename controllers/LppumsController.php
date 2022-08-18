<?php

namespace app\controllers;

use Yii;

use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\base\UserException;
use yii\data\Pagination;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\db\Expression;
use tebazil\runner\ConsoleCommandRunner;
use app\models\Notification;
use yii\helpers\Html;
use kartik\mpdf\Pdf;

use app\models\myidp\Kehadiran;
use app\models\myidp\RefCpdGroup;
use app\models\myidp\RefCpdGroupGredJawatan;
use app\models\myidp\SiriLatihan;
use app\models\myidp\RptStatistikIdpV2;
use app\models\hronline\Tblprcobiodata;
use app\models\lppums\TblMain;
use app\models\lppums\TblMainDeleted;
use app\models\lppums\TblMainSearch;
use app\models\lppums\TblMainSearch2;
use app\models\lppums\TblMainSearchPenetap;
use app\models\lppums\TblprcobiodataSearch;
use app\models\lppums\TblSumbangan;
use app\models\lppums\TblSumbanganTt;
use app\models\lppums\TblLatihanPerlu;
use app\models\lppums\TblLatihanTambah;
use app\models\lppums\TblBahagianKriteria;
use app\models\lppums\RefKriteria;
use app\models\lppums\TblLppMarkah;
use app\models\lppums\TblMarkahKeseluruhan;
use app\models\lppums\TblUlasan;
use app\models\lppums\TblCpdLatihan;
use app\models\lppums\TblSkt;
use app\models\lppums\TblSktTandatangan;
use app\models\lppums\TblSktUlasan;
use app\models\lppums\TblSenaraiTugas;
use app\models\lppums\PenetapanAksesSearch;
use app\models\lppums\TblStafAkses;
use app\models\lppums\TblLppTahun;
use app\models\lppums\TblRequestLog;
use app\models\lppums\TblStatistikIdp;
use app\models\lppums\RefMarkahBahagian;
use app\models\lppums\TblMataAkhir;
use app\models\lppums\TblPenetapPenilai;
use app\models\lppums\TblPenetapPenilaiSearch;
use app\models\lppums\TblRequest;
use app\models\lppums\TblRequestSearch;
use app\models\lppums\TblAlasanSemakan;
use app\models\lppums\TblCadanganApc;
use app\models\lppums\TblQueryApc;
use app\models\lppums\TblStaffProjek;
use app\models\lppums\v2\RefAspek;
use app\models\lppums\v2\TblSktv2;
use app\models\lppums\v2\TblDocuments;
use app\models\lppums\v2\TblKetakakuranStaff;
use app\models\myportfolio\TblAkauntabiliti;
use app\models\myportfolio\TblDimensi;
use app\models\myportfolio\TblIkhtisas;
use app\models\myportfolio\TblKompetensi;
use app\models\myportfolio\TblPengalaman;
use app\models\myportfolio\TblPortfolio;
use app\models\myportfolio\TblSyaratTambahan;
use yii\web\UploadedFile;

class LppumsController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index', 'panduan-pengisian-borang', 'senarai-pyd', 'name-list',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [
                            'borang-lpp'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (((Yii::$app->user->identity->jawatan->job_group != 2) && (Yii::$app->user->identity->jawatan->job_group != 3)) or
                                \app\models\lppums\TblMain::findOne(['PYD' => Yii::$app->user->identity->ICNO])
                            ) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'bahagian1', 'bahagian2', 'bahagian7',
                            'bahagian8', 'bahagian9',
                            'skt-bahagian1', 'skt-bahagian2', 'skt-bahagian3',
                            'senarai-tugas', 'senarai-tugas-baru',
                            'generate-borang'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (!is_null($admin = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_lpp_tahun', NULL])
                                ->one())) {

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
                                ->where(['lpp_id' => Yii::$app->request->get('lpp_id')])
                                ->andWhere([
                                    'or', ['PYD' => Yii::$app->user->identity->ICNO], ['PPP' => Yii::$app->user->identity->ICNO],
                                    ['PPK' => Yii::$app->user->identity->ICNO]
                                ])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'cuti']])
                                ->one();

                            $query1 = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_lpp', NULL])
                                ->one();

                            if ((!is_null($query)) or !is_null($query1)) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'bahagian2-test',
                            'skt-bahagian1-test', 'view-file',
                            'tambah-skt-test', 'edit-skt-test', 'delete-skt-test',
                            'tambah-aktiviti', 'edit-aktiviti', 'delete-aktiviti',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (!is_null($admin = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_lpp_tahun', NULL])
                                ->one())) {

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
                                ->where(['lpp_id' => Yii::$app->request->get('lpp_id')])
                                ->andWhere([
                                    'or', ['PYD' => Yii::$app->user->identity->ICNO], ['PPP' => Yii::$app->user->identity->ICNO],
                                    ['PPK' => Yii::$app->user->identity->ICNO]
                                ])
                                ->andWhere([
                                    '>=', 'tahun', 2022
                                ])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'cuti']])
                                ->one();

                            $query1 = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_lpp', NULL])
                                ->one();

                            if ((!is_null($query)
                                // && (date("Y-m-d") < date("Y-m-d"))
                            ) or !is_null($query1)) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'bahagian3', 'bahagian4', 'bahagian5', 'bahagian6',
                            'bahagian3-test', 'bahagian4-test', 'bahagian5-test', 'bahagian6-test',
                            'senarai-skt', 'approve-skt-ppp', 'approve-skt-ppk', 'staff-color-list', 'staff-idp-list',
                            'tandatangan-kj'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {

                            if (!is_null($admin = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_lpp_tahun', NULL])
                                ->one())) {

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
                                ->where(['lpp_id' => Yii::$app->request->get('lpp_id')])
                                ->andWhere([
                                    'or', ['PPP' => Yii::$app->user->identity->ICNO],
                                    ['PPK' => Yii::$app->user->identity->ICNO]
                                ])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'cuti']])
                                ->one();

                            $query1 = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                //                                   ->andWhere(['IS NOT', 'a.akses_set_akses', NULL])
                                ->andWhere(['IS NOT', 'a.akses_lpp', NULL])
                                ->one();

                            //                           $query = TblPenilaianDass21::find()->where('YEARWEEK(created_dt) = YEARWEEK(NOW())')->andWhere(['icno' => Yii::$app->user->identity->ICNO])->count();
                            //                           $tmp = TblUserAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->one();
                            //return ($query < 2 || (!is_null($tmp))) ? true : false;
                            //                           if ($query < 2 || (!is_null($tmp))) {
                            //                               return true;
                            //                           }else {
                            //                               throw new HttpException(403, "You have reached your limit for answering questions for today.");
                            //                           }
                            if (!is_null($query) or !is_null($query1)) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'pengesahan',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {

                            if (!is_null($admin = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_lpp_tahun', NULL])
                                ->one())) {

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
                                ->where(['lpp_id' => Yii::$app->request->get('lpp_id')])
                                ->andWhere([
                                    'or', ['PYD' => Yii::$app->user->identity->ICNO], ['PPP' => Yii::$app->user->identity->ICNO],
                                    ['PPK' => Yii::$app->user->identity->ICNO]
                                ])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'cuti']])
                                ->one();

                            $query1 = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                //                                   ->andWhere(['IS NOT', 'a.akses_set_akses', NULL])
                                ->andWhere(['IS NOT', 'a.akses_lpp', NULL])
                                ->one();

                            //                           $query = TblPenilaianDass21::find()->where('YEARWEEK(created_dt) = YEARWEEK(NOW())')->andWhere(['icno' => Yii::$app->user->identity->ICNO])->count();
                            //                           $tmp = TblUserAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->one();
                            //return ($query < 2 || (!is_null($tmp))) ? true : false;
                            //                           if ($query < 2 || (!is_null($tmp))) {
                            //                               return true;
                            //                           }else {
                            //                               throw new HttpException(403, "You have reached your limit for answering questions for today.");
                            //                           }
                            if (!is_null($query) or !is_null($query1)) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'pengesahan-markah', 'markah-setuju', 'markah-tidak-setuju', 'mohon-semak',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {

                            if (!is_null($admin = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_lpp_tahun', NULL])
                                ->one())) {

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
                                ->where(['lpp_id' => Yii::$app->request->get('lpp_id')])
                                ->andWhere([
                                    'or', ['PYD' => Yii::$app->user->identity->ICNO], ['PPP' => Yii::$app->user->identity->ICNO],
                                    ['PPK' => Yii::$app->user->identity->ICNO]
                                ])
                                ->andWhere([
                                    'and', ['PYD_sah' => 1], ['or', [
                                        'and', ['PPP_sah' => 1],
                                        ['PPK_sah' => 1]
                                    ], ['and', ['PPP_sah' => 1], ['IS NOT', 'PP_ALL', null]]]
                                ])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'cuti']])
                                ->one();

                            $query1 = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                //                                   ->andWhere(['IS NOT', 'a.akses_set_akses', NULL])
                                ->andWhere(['IS NOT', 'a.akses_lpp', NULL])
                                ->one();

                            if (!is_null($query)) {
                                $tahun = TblLppTahun::find()->where(['lpp_aktif' => 'Y', 'lpp_tahun' => $query->tahun])->one();
                            }

                            //                           $query = TblPenilaianDass21::find()->where('YEARWEEK(created_dt) = YEARWEEK(NOW())')->andWhere(['icno' => Yii::$app->user->identity->ICNO])->count();
                            //                           $tmp = TblUserAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->one();
                            //return ($query < 2 || (!is_null($tmp))) ? true : false;
                            //                           if ($query < 2 || (!is_null($tmp))) {
                            //                               return true;
                            //                           }else {
                            //                               throw new HttpException(403, "You have reached your limit for answering questions for today.");
                            //                           }
                            if (((!is_null($query)) and ($query->tahun == $tahun->lpp_tahun) && (date("Y/m/d") <= '2022/05/31')) or $query1) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'tambah-sumbangan', 'padam-sumbangan', 'update-sumbangan', 'tambah-latihan', 'update-latihan', 'tambah-latihan-perlu',
                            'update-latihan-perlu', 'tambah-skt', 'tambah-skt1', 'tambah-senarai', 'update-senarai', 'delete-senarai',
                            'update-skt', 'delete-skt', 'gugur-skt', 'kembali-skt', 'pengesahan-pyd', 'padam-latihan', 'padam-latihan-perlu',

                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblMain::find()
                                ->where(['PYD' => Yii::$app->user->identity->ICNO, 'lpp_id' => Yii::$app->request->get('lpp_id')])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'cuti']])
                                ->one();
                            //                           $query = TblPenilaianDass21::find()->where('YEARWEEK(created_dt) = YEARWEEK(NOW())')->andWhere(['icno' => Yii::$app->user->identity->ICNO])->count();
                            //                           $tmp = TblUserAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->one();
                            //return ($query < 2 || (!is_null($tmp))) ? true : false;
                            //                           if ($query < 2 || (!is_null($tmp))) {
                            //                               return true;
                            //                           }else {
                            //                               throw new HttpException(403, "You have reached your limit for answering questions for today.");
                            //                           }
                            if (!is_null($query)) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'pengesahan-ppp', 'tandatangan-bahagian8'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {

                            if (!is_null($admin = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_lpp_tahun', NULL])
                                ->one())) {

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
                                ->where(['PPP' => Yii::$app->user->identity->ICNO, 'lpp_id' => Yii::$app->request->get('lpp_id')])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'cuti']])
                                ->one();
                            if (!is_null($query)) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'pengesahan-ppk', 'tandatangan-bahagian9'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {

                            if (!is_null($admin = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_lpp_tahun', NULL])
                                ->one())) {

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
                                ->where(['PPK' => Yii::$app->user->identity->ICNO, 'lpp_id' => Yii::$app->request->get('lpp_id')])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'cuti']])
                                ->one();
                            if (!is_null($query)) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'penetap-pegawai-penilai', 'penetap-pantau-pergerakan-borang', 'notify-all', 'penetap-markah-borang'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $maxYear = TblLppTahun::find()
                                //->select(new \yii\db\Expression('MAX(lpp_tahun) as lpp_tahun'))
                                ->max('lpp_tahun');

                            $lppYear = TblLppTahun::find()
                                //->select(new \yii\db\Expression('*'))
                                ->where(['lpp_tahun' => $maxYear]);


                            $penetap = TblPenetapPenilai::find()
                                ->rightJoin(['a' => $lppYear], 'a.lpp_tahun = hrm.lppums_tbl_penetap_penilai.tahun AND a.lpp_aktif = \'Y\'')
                                ->where(['hrm.lppums_tbl_penetap_penilai.penetap_icno' => Yii::$app->user->identity->ICNO])
                                ->exists();

                            if ($penetap) {

                                $penilai = Yii::$app->session->get('user.penilai');
                                if ($penilai) {
                                    Yii::$app->session->remove('user.penilai');
                                }

                                return true;
                            } else {
                                //throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
                                throw new ForbiddenHttpException('Hanya penetap pegawai penilai yang berdaftar untuk LNPT tahun ' . $maxYear . ' dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'penetapan-pegawai', 'gugur-ppk', 'gugur-ppp', 'gugur-pp',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                //                                   ->andWhere(['IS NOT', 'a.akses_set_akses', NULL])
                                ->andWhere(['IS NOT', 'a.assign_pp', NULL])
                                ->one();

                            $maxYear = TblLppTahun::find()
                                //->select(new \yii\db\Expression('MAX(lpp_tahun) as lpp_tahun'))
                                ->max('lpp_tahun');

                            $lppYear = TblLppTahun::find()
                                //->select(new \yii\db\Expression('*'))
                                ->where(['lpp_tahun' => $maxYear]);

                            $penetap = TblPenetapPenilai::find()
                                ->leftJoin(['a' => $lppYear], 'a.lpp_tahun = hrm.lppums_tbl_penetap_penilai.tahun AND a.lpp_aktif = \'Y\'')
                                ->where(['hrm.lppums_tbl_penetap_penilai.penetap_icno' => Yii::$app->user->identity->ICNO])
                                ->exists();

                            if (!is_null($query) or $penetap) {

                                $penilai = Yii::$app->session->get('user.penilai');
                                if ($penilai) {
                                    Yii::$app->session->remove('user.penilai');
                                }

                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'pengurusan-tahun-penilaian', 'tambah-tahun-penilaian', 'kemaskini-tahun-penilaian',
                            'generate-markah', 'generate-lpp', 'markah-borang', 'carian-borang-lpp-penilai',
                            'senarai-cuti-belajar',
                            'pengesahan-markah-borang', 'reset-semakan',
                            'pengurusan-cadangan-apc', 'cadangan-apc', 'generate-laporan-apc', 'buang-cadangan-apc',
                            'generate-borang',
                            'delete-file',
                            'ketakakuran-staf', 'tambah-ketakakuran-staf', 'kemaskini-ketakakuran-staf', 'padam-ketakakuran-staf',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_lpp_tahun', NULL])
                                ->one();
                            if (!is_null($query)) {

                                $penilai = Yii::$app->session->get('user.penilai');
                                if ($penilai) {
                                    Yii::$app->session->remove('user.penilai');
                                }

                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'pendaftaran-penetap-penilai', 'tambah-penetap-penilai', 'kemaskini-penetap-penilai', 'remove-penetap-penilai',
                            'penetapan-pegawai-penilai', 'penetapan-pegawai', 'gugur-ppk', 'gugur-ppp', 'gugur-pp',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.assign_pp', NULL])
                                ->one();
                            if (!is_null($query)) {

                                $penilai = Yii::$app->session->get('user.penilai');
                                if ($penilai) {
                                    Yii::$app->session->remove('user.penilai');
                                }

                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'penetapan-akses-sistem', 'kemaskini-akses-pegawai',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_set_akses', NULL])
                                ->one();
                            if (!is_null($query)) {

                                $penilai = Yii::$app->session->get('user.penilai');
                                if ($penilai) {
                                    Yii::$app->session->remove('user.penilai');
                                }

                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'reset-borang-lpp', 'reset-borang',
                            'buka-borang-lpp', 'buka-borang', 'kemaskini-buka-borang', 'padam-buka-borang',
                            'padam-borang-lpp', 'padam-borang',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_reset', NULL])
                                ->one();
                            if (!is_null($query)) {

                                $penilai = Yii::$app->session->get('user.penilai');
                                if ($penilai) {
                                    Yii::$app->session->remove('user.penilai');
                                }

                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'pantau-pergerakan-borang', 'notify-all', 'carian-borang-lpp', 'generate-report', 'generate-report-v2'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->leftJoin('hronline.tblprcobiodata b', 'hrm.lppums_staf_akses.ICNO = b.ICNO')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['or', ['IS NOT', 'a.laporan_markah_lpp', NULL], ['AND', ['IS NOT', 'a.akses_lpp', NULL], ['b.DeptId' => Yii::$app->request->get('DeptId') ? Yii::$app->request->get('DeptId') : Yii::$app->user->identity->DeptId]]])
                                ->one();
                            if (!is_null($query)) {

                                $penilai = Yii::$app->session->get('user.penilai');
                                if ($penilai) {
                                    Yii::$app->session->remove('user.penilai');
                                }

                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'dashboard',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                //                                   ->andWhere(['IS NOT', 'a.akses_set_akses', NULL])
                                ->one();
                            if (!is_null($query)) {

                                $penilai = Yii::$app->session->get('user.penilai');
                                if ($penilai) {
                                    Yii::$app->session->remove('user.penilai');
                                }

                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        //'actions' => ['index'],
                        'allow' => false,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'lpg-report' => ['get'],
                ],
            ],
        ];
    }

    public function actionGenerateMarkah($tahun)
    {
        $output = '';
        $runner = new ConsoleCommandRunner();
        $runner->run('lppums/generate-markah', [$tahun]);
        $output = $runner->getOutput();
        \Yii::$app->session->setFlash('alert', ['title' => 'Message', 'type' => 'info', 'msg' => $output]);
        //return $this->redirect(['semak-lpp', 'lppid' => $lppid, 'bhg_no' => 9]);
        return $this->redirect('pengurusan-tahun-penilaian');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPanduanPengisianBorang()
    {
        return $this->render('panduan_isi');
    }

    public function actionBahagian1($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        return $this->render('maklumat_guru', [
            'lpp' => $lpp,
        ]);
    }

    public function actionBahagian2($lpp_id, $tab = null)
    {
        //$tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);

        $lpp = $this->findLpp($lpp_id);

        if ($lpp->tahun >= 2022) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
        }

        $tahun = TblLppTahun::findOne([
            // 'lpp_aktif' => 'Y', 
            'lpp_tahun' => $lpp->tahun
        ]);

        if ($req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO])) {
            $req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
            if (date('Y-m-d H:i:s') > $req->close_date) {
                $req->delete();
            }
        }

        $sumb = TblSumbangan::find()->where(['lpp_id' => $lpp_id]);



        $mataCpd2 = TblMataAkhir::find()
            ->where(['icno' => $lpp->PYD])
            ->one();

        //        $countLatih = clone $latih_tmbh;
        //        $pages = new Pagination(['totalCount' => $countLatih->count(), 'pageSize' => 5]);
        //        $models = $latih_tmbh->offset($pages->offset)
        //                ->limit($pages->limit)
        //                ->all();

        $latih = TblLatihanTambah::find()->where(['lpp_id' => $lpp_id]);
        $latih_perlu = TblLatihanPerlu::find()->where(['lpp_id' => $lpp_id]);

        if ($lpp->tahun >= 2020) {
            $latih_tmbh = SiriLatihan::find()
                ->joinWith('sasaran5.sasaran55')
                ->where(['idp_kehadiran.staffID' => $lpp->PYD, 'YEAR(idp_kehadiran.tarikhMasa)' => $lpp->tahun])
                ->all();
            $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $lpp->gredJawatan->gred])->one();
            $cpdgroup = $modelcpdgroupgj->cpdgroup ?? -1;
            $mataCpd = \app\models\myidp\RptStatistikIdp::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
            // $summ = Kehadiran::calculateMataTotal('4', $lpp->PYD)  + Kehadiran::calculateMataTotal('5', $lpp->PYD) + Kehadiran::calculateMataTotal('6', $lpp->PYD);
            // $summm = RptStatistikIdpV2::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
            $summm = \app\models\myidp\RptStatistikIdp::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
            $summ = $summm->jum_mata_dikira;
        } else {
            $latih_tmbh = TblCpdLatihan::find()
                ->where(['vcl_id_staf' => $lpp->PYD, 'YEAR(vcl_tkh_mula)' => $lpp->tahun])
                ->orderBy(['vcl_tkh_mula' => SORT_ASC])
                ->all();
            $mataCpd = TblStatistikIdp::find()->where(['tahun' => $lpp->tahun, 'icno' => $lpp->PYD])->one();
            $summ = null;
        }



        if (($tt = TblSumbanganTt::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $tt = TblSumbanganTt::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $tt = new TblSumbanganTt();
        }

        $dataProvider1 = new ActiveDataProvider([
            'query' => $sumb,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 10,
            ],
            'sort' => false,
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $latih_perlu,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 10,
            ],
            'sort' => false,
        ]);

        $dataProvider3 = new ActiveDataProvider([
            'query' => $latih,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 10,
            ],
            'sort' => false,
        ]);

        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->get('lpp_id');
            $tt->lpp_id = $data;
            $tt->sumbangan_tt = $lpp->PYD;
            $tt->sumbangan_tt_date = new \yii\db\Expression('NOW()');
            if ($tt->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disahkan!']);
                return $this->redirect(['lppums/bahagian2', 'lpp_id' => $lpp->lpp_id]);
            }
        }

        return $this->render('bhg2', [
            'tahun' => $tahun,
            'mataCpd' => $mataCpd,
            'lpp' => $lpp,
            'dataProvider1' => $dataProvider1,
            'latih_tmbh' => $latih_tmbh,
            'mataCpd2' => $mataCpd2,
            //'pages' => $pages,
            'dataProvider2' => $dataProvider2,
            'dataProvider3' => $dataProvider3,
            'tt' => $tt,
            'tab' => is_null($tab) ? '1' : $tab,
            'req' => is_null($req) ? null : $req,
            'summ' => $summ
        ]);
    }

    public function actionBahagian2Test($lpp_id, $tab = null)
    {
        $lpp = $this->findLpp($lpp_id);

        if ($lpp->tahun < 2022) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
        }

        $tahun = TblLppTahun::findOne([
            // 'lpp_aktif' => 'Y', 
            'lpp_tahun' => $lpp->tahun
        ]);

        if ($req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO])) {
            $req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
            if (date('Y-m-d H:i:s') > $req->close_date) {
                $req->delete();
            }
        }

        if (($tt = TblSumbanganTt::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $tt = TblSumbanganTt::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $tt = new TblSumbanganTt();
        }

        $query = TblSktv2::find()
            ->alias('a')
            ->select('c.month, a.ringkasan, a.capai, a.sasaran_kerja, a.created_dt, a.updated_dt, a.id, a.lpp_id, a.aspek_id')
            ->leftJoin(['b' => 'hrm.`lppums_v2_ref_aspek`'], 'b.`id` = a.`aspek_id`')
            ->rightJoin(['c' => 'hrm.`lppums_v2_ref_months`'], 'c.`month` = a.`month` and a.`aspek_id` = ' . 14 . ' and a.`lpp_id` = ' . $lpp_id . ' and a.`deleted_dt` IS NULL')
            ->orderBy(['c.month' => SORT_ASC, 'a.created_dt' => SORT_ASC]);

        // return \yii\helpers\VarDumper::dump(array_sum(ArrayHelper::getColumn($test, function ($element) {
        //     return $element['ringkasan'] == 'Penganjur';
        // })), 500, true);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => ['month' => SORT_ASC],
            ],
        ]);

        $aktiviti = SiriLatihan::find()
            ->joinWith('sasaran5.sasaran55')
            ->where(['idp_kehadiran.staffID' => $lpp->pyd->ICNO])
            ->andWhere(['idp_kehadiran.kategoriKursusID' => [5, 6, 4]])
            ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $lpp->tahun]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $aktiviti,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => ['tarikhMula' => SORT_ASC],
            ],
        ]);

        $mataCpd = \app\models\myidp\RptStatistikIdp::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
        // $summ = Kehadiran::calculateMataTotal('4', $lpp->PYD)  + Kehadiran::calculateMataTotal('5', $lpp->PYD) + Kehadiran::calculateMataTotal('6', $lpp->PYD);
        // $summm = RptStatistikIdpV2::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
        $summm = \app\models\myidp\RptStatistikIdp::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
        $summ = $summm->jum_mata_dikira;

        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->get('lpp_id');
            $tt->lpp_id = $data;
            $tt->sumbangan_tt = $lpp->PYD;
            $tt->sumbangan_tt_date = new \yii\db\Expression('NOW()');
            if ($tt->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disahkan!']);
                return $this->redirect(['lppums/bahagian2-test', 'lpp_id' => $lpp->lpp_id]);
            }
        }

        // return \yii\helpers\VarDumper::dump(sizeof($teras), 500, true);

        return $this->render('bhg2_test', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'lpp' => $lpp,
            'tab' => is_null($tab) ? '1' : $tab,
            'tt' => $tt,
            'tahun' => $tahun,
            'req' => is_null($req) ? null : $req,
            'summ' => $summ,
            'mataCpd' => $mataCpd,
        ]);
    }

    public function actionTambahSumbangan($lpp_id)
    {
        $model = new TblSumbangan();

        if ($model->load(Yii::$app->request->post())) {
            $model->lpp_id = $lpp_id;
            if ($model->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya ditambah!']);
                return $this->redirect(['lppums/bahagian2', 'lpp_id' => $lpp_id, 'tab' => 1]);
            }
        }

        return $this->renderAjax('tmbhSumbangan', ['model' => $model]);
    }

    public function actionUpdateSumbangan($sumbid, $lpp_id)
    {
        $model = TblSumbangan::findOne(['sumb_id' => $sumbid, 'lpp_id' => $lpp_id]);

        if ($model->load(Yii::$app->request->post())) {
            //$model->lpp_id = $lppid;
            if ($model->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikemaskini!']);
                return $this->redirect(['lppums/bahagian2', 'lpp_id' => $lpp_id, 'tab' => 1]);
            }
        }

        return $this->renderAjax('tmbhSumbangan', ['model' => $model]);
    }

    public function actionPadamSumbangan($sumbid, $lpp_id)
    {
        $model = TblSumbangan::findOne(['sumb_id' => $sumbid, 'lpp_id' => $lpp_id]);

        $model->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        return $this->redirect(['lppums/bahagian2', 'lpp_id' => $lpp_id, 'tab' => 1]);
    }

    public function actionTambahLatihan($lpp_id)
    {
        $model = new TblLatihanTambah();

        if ($model->load(Yii::$app->request->post())) {
            $model->lpp_id = $lpp_id;
            if ($model->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya ditambah!']);
                return $this->redirect(['lppums/bahagian2', 'lpp_id' => $lpp_id, 'tab' => '2']);
            }
        }

        return $this->renderAjax('tmbhLatihan', ['model' => $model]);
    }

    public function actionUpdateLatihan($latid, $lpp_id)
    {
        $model = TblLatihanTambah::findOne(['lat_tamb_id' => $latid]);

        if ($model->load(Yii::$app->request->post())) {
            //$model->lpp_id = $lppid;
            if ($model->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikemaskini!']);
                return $this->redirect(['lppums/bahagian2', 'lpp_id' => $model->lpp_id, 'tab' => '2']);
            }
        }

        return $this->renderAjax('tmbhLatihan', ['model' => $model]);
    }

    public function actionPadamLatihan($latid, $lpp_id)
    {
        $model = TblLatihanTambah::findOne(['lat_tamb_id' => $latid, 'lpp_id' => $lpp_id]);

        //        if ($model->load(Yii::$app->request->post())) {
        //            //$model->lpp_id = $lppid;
        //            if ($model->save(false)) {
        //                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikemaskini!']);
        //                return $this->redirect(['lppums/bahagian2', 'lpp_id' => $model->lpp_id, 'tab' => '2']);
        //            }
        //        }  

        $model->delete();

        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikemaskini!']);
        return $this->redirect(['lppums/bahagian2', 'lpp_id' => $model->lpp_id, 'tab' => '2']);
        //        return $this->renderAjax('tmbhLatihan', ['model' => $model]);
    }

    public function actionTambahLatihanPerlu($lpp_id)
    {
        $model = new TblLatihanPerlu();

        if ($model->load(Yii::$app->request->post())) {
            $model->lpp_id = $lpp_id;
            if ($model->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya ditambah!']);
                return $this->redirect(['lppums/bahagian2', 'lpp_id' => $lpp_id, 'tab' => '2']);
            }
        }

        return $this->renderAjax('tmbhLatihanPerlu', ['model' => $model]);
    }

    public function actionUpdateLatihanPerlu($latid, $lpp_id)
    {
        $model = TblLatihanPerlu::findOne(['lat_perlu_id' => $latid, 'lpp_id' => $lpp_id]);

        if ($model->load(Yii::$app->request->post())) {
            //$model->lpp_id = $lppid;
            if ($model->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
                return $this->redirect(['lppums/bahagian2', 'lpp_id' => $lpp_id, 'tab' => '2']);
            }
        }

        return $this->renderAjax('tmbhLatihanPerlu', ['model' => $model]);
    }

    public function actionPadamLatihanPerlu($latid, $lpp_id)
    {
        $model = TblLatihanPerlu::findOne(['lat_perlu_id' => $latid, 'lpp_id' => $lpp_id]);

        //        if ($model->load(Yii::$app->request->post())) {
        //            //$model->lpp_id = $lppid;
        //            if ($model->save(false)) {
        //                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikemaskini!']);
        //                return $this->redirect(['lppums/bahagian2', 'lpp_id' => $model->lpp_id, 'tab' => '2']);
        //            }
        //        }  

        $model->delete();

        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        return $this->redirect(['lppums/bahagian2', 'lpp_id' => $model->lpp_id, 'tab' => '2']);
        //        return $this->renderAjax('tmbhLatihan', ['model' => $model]);
    }

    public function actionBahagian3($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        if ($lpp->tahun >= 2022) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
        }

        $mrkhBhg = RefMarkahBahagian::find()->where(['kump_khidmat' => $lpp->gredJawatan->job_group, 'bahagian_id' => 1])->one();

        if (($ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $ulasan_tt = new TblUlasan();
        }

        $query = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $lpp_id, 'bahagian_id' => 1])
            ->indexBy('bhk_id')
            ->all();

        $kriteria = TblBahagianKriteria::find()
            ->select(['hrm.lppums_bahagian_has_kriteria.*', 'hrm.lppums_kriteria.*'])
            ->joinWith('kriteria')
            ->where(['bahagian_id' => 1, 'kump_khidmat' => $lpp->gredJawatan->job_group]);

        if (empty($kriteria->all())) {
            throw new UserException('Anda tidak mempunyai akses kepada bahagian ini.');
        }

        if ($query) {
            $markah = $query;
        } else {
            $markah = [new TblLppMarkah()];
            for ($i = 1; $i < $kriteria->count(); $i++) {
                $markah[] = new TblLppMarkah();
            }
        }

        $jumlah = ArrayHelper::toArray($query, [
            'app\models\lppums\TblLppMarkah' => [
                'markah_PPP',
                'markah_PPK',
            ],
        ]);

        //\yii\helpers\VarDumper::dump($jumlah, 500, true);

        if (Model::loadMultiple($markah, Yii::$app->request->post()) && Model::validateMultiple($markah, ['bhk_id', 'markah_PPP', 'markah_PPK'])) {
            foreach ($markah as $mrkh) {
                if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPP_ = Yii::$app->user->identity->ICNO;
                }
                if ($lpp->PPK == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPK_ = Yii::$app->user->identity->ICNO;
                }
                $mrkh->tarikh_kemaskini = new \yii\db\Expression('NOW()');
                $mrkh->lpp_id = $lpp_id;
                $mrkh->save(false);
            }
            $this->UpdateMarkah($lpp_id);
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Markah berjaya disimpan!']);
            return $this->redirect(['lppums/bahagian3', 'lpp_id' => $lpp->lpp_id]);
        }

        return $this->render('bhg3', [
            'lpp' => $lpp,
            'lpp_mrkh' => $markah,
            'kriteria' => $kriteria->asArray()->all(),
            'jumlah' => $jumlah,
            'mrkhBhg' => $mrkhBhg,
            'tt' => $ulasan_tt,
        ]);
    }

    public function actionBahagian3Test($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        if ($lpp->tahun < 2022) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
        }

        $mrkhBhg = RefMarkahBahagian::find()->where(['kump_khidmat' => $lpp->gredJawatan->job_group, 'bahagian_id' => 1])->one();

        if (($ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $ulasan_tt = new TblUlasan();
        }

        $query = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $lpp_id, 'bahagian_id' => 1])
            ->indexBy('bhk_id')
            ->all();

        $kriteria = TblBahagianKriteria::find()
            ->select(['hrm.lppums_bahagian_has_kriteria.*', 'hrm.lppums_kriteria.*'])
            ->joinWith('kriteria')
            ->where(['bahagian_id' => 1, 'kump_khidmat' => $lpp->gredJawatan->job_group]);

        if (empty($kriteria->all())) {
            throw new UserException('Anda tidak mempunyai akses kepada bahagian ini.');
        }

        if ($query) {
            $markah = $query;
        } else {
            $markah = [new TblLppMarkah()];
            for ($i = 1; $i < $kriteria->count(); $i++) {
                $markah[] = new TblLppMarkah();
            }
        }

        $jumlah = ArrayHelper::toArray($query, [
            'app\models\lppums\TblLppMarkah' => [
                'markah_PPP',
                'markah_PPK',
            ],
        ]);

        // \yii\helpers\VarDumper::dump($kriteria->asArray()->all(), 500, true);

        if (Model::loadMultiple($markah, Yii::$app->request->post()) && Model::validateMultiple($markah, ['bhk_id', 'markah_PPP', 'markah_PPK'])) {
            foreach ($markah as $mrkh) {
                if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPP_ = Yii::$app->user->identity->ICNO;
                }
                if ($lpp->PPK == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPK_ = Yii::$app->user->identity->ICNO;
                }
                $mrkh->tarikh_kemaskini = new \yii\db\Expression('NOW()');
                $mrkh->lpp_id = $lpp_id;
                $mrkh->save(false);
            }
            $this->UpdateMarkah($lpp_id);
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Markah berjaya disimpan!']);
            return $this->redirect(['lppums/bahagian3-test', 'lpp_id' => $lpp->lpp_id]);
        }

        return $this->render('bhg3_test', [
            'lpp' => $lpp,
            'lpp_mrkh' => $markah,
            'kriteria' => $kriteria->asArray()->all(),
            'jumlah' => $jumlah,
            'mrkhBhg' => $mrkhBhg,
            'tt' => $ulasan_tt,
        ]);
    }

    public function actionSenaraiSkt($lpp_id, $order, $bhg)
    {
        $lpp = $this->findLpp($lpp_id);

        $tmp = RefAspek::find()->where(['aspek_order' => $order, 'bahagian_id' => $bhg])->one();

        $aspek_id = $tmp->id;

        $query = TblSktv2::find()
            ->alias('a')
            ->select('c.month, a.ringkasan, a.capai, a.sasaran_kerja, a.created_dt, a.updated_dt, a.id, a.lpp_id, a.aspek_id')
            ->leftJoin(['b' => 'hrm.`lppums_v2_ref_aspek`'], 'b.`id` = a.`aspek_id`')
            ->rightJoin(['c' => 'hrm.`lppums_v2_ref_months`'], 'c.`month` = a.`month` and a.`aspek_id` = ' . $aspek_id . ' and a.`lpp_id` = ' . $lpp_id . ' and a.`deleted_dt` IS NULL')
            ->orderBy(['c.month' => SORT_ASC, 'a.created_dt' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => ['month' => SORT_ASC],
            ],
        ]);

        // unset(Yii::$app->assetManager->bundles['kartik\gridview']);

        return ($order == 23) ? $this->renderAjax('_sen_skt_cpy', [
            'title' => ucwords($tmp->aspek_label),
            'bhg' => $bhg,
            'order' => $order,
            'lpp' => $lpp,
        ]) : $this->renderAjax('_sen_skt', [
            'dataProvider' => $dataProvider,
            'ppp' => (($lpp->PPP == Yii::$app->user->identity->ICNO) || $this->checkAdmin()),
            'ppk' => (($lpp->PPK == Yii::$app->user->identity->ICNO) || $this->checkAdmin()),
            'title' => ucwords($tmp->aspek_label),
            'bhg' => $bhg,
            'order' => $order,
        ]);
    }

    public function checkAdmin()
    {
        return TblStafAkses::find()
            ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
            ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
            ->andWhere(['IS NOT', 'a.akses_lpp', NULL])
            ->one();
    }

    public function actionApproveSktPpp($skt_id, $aspek_id, $lpp_id, $bhg, $order)
    {
        if ($doc = $this->findDoc($skt_id)) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $doc->verified_ppp = !is_null($doc->verified_ppp) ? null : Yii::$app->user->identity->ICNO;
                $doc->verified_dt_ppp = !is_null($doc->verified_ppp) ? null : new \yii\db\Expression('NOW()');
                $doc->save(false);
                return ['success' => true, 'aspek_id' => $order, 'lpp_id' => $lpp_id, 'bhg' => $bhg];
            }
        }

        return 0;
    }

    public function actionApproveSktPpk($skt_id, $aspek_id, $lpp_id, $bhg, $order)
    {
        if ($doc = $this->findDoc($skt_id)) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $doc->verified_ppk = !is_null($doc->verified_ppk) ? null : Yii::$app->user->identity->ICNO;
                $doc->verified_dt_ppk = !is_null($doc->verified_ppk) ? null : new \yii\db\Expression('NOW()');
                $doc->save(false);
                return ['success' => true, 'aspek_id' => $order, 'lpp_id' => $lpp_id, 'bhg' => $bhg];
            }
        }

        return 0;
    }

    public function actionBahagian4($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        if ($lpp->tahun >= 2022) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
        }

        $mrkhBhg = RefMarkahBahagian::find()->where(['kump_khidmat' => $lpp->gredJawatan->job_group, 'bahagian_id' => 3])->one();

        if (($ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $ulasan_tt = new TblUlasan();
        }

        $query = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $lpp_id, 'bahagian_id' => 3])
            ->indexBy('bhk_id')
            ->all();

        $kriteria = TblBahagianKriteria::find()
            ->select(['hrm.lppums_bahagian_has_kriteria.*', 'hrm.lppums_kriteria.*'])
            ->joinWith('kriteria')
            ->where(['bahagian_id' => 3, 'kump_khidmat' => $lpp->gredJawatan->job_group]);

        if (empty($kriteria->all())) {
            throw new UserException('Anda tidak mempunyai akses kepada bahagian ini.');
        }

        if ($query) {
            $markah = $query;
        } else {
            $markah = [new TblLppMarkah()];
            for ($i = 1; $i < $kriteria->count(); $i++) {
                $markah[] = new TblLppMarkah();
            }
        }

        if (Model::loadMultiple($markah, Yii::$app->request->post()) && Model::validateMultiple($markah, ['bhk_id', 'markah_PPP', 'markah_PPK'])) {
            foreach ($markah as $mrkh) {
                $mrkh->tarikh_kemaskini = new \yii\db\Expression('NOW()');
                $mrkh->lpp_id = $lpp_id;
                if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPP_ = Yii::$app->user->identity->ICNO;
                }
                if ($lpp->PPK == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPK_ = Yii::$app->user->identity->ICNO;
                }
                $mrkh->save(false);
            }
            $this->UpdateMarkah($lpp_id);
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Markah berjaya disimpan!']);
            return $this->redirect(['lppums/bahagian4', 'lpp_id' => $lpp->lpp_id]);
        }

        $jumlah = ArrayHelper::toArray($query, [
            'app\models\lppums\TblLppMarkah' => [
                'markah_PPP',
                'markah_PPK',
            ],
        ]);

        //        return \yii\helpers\VarDumper::dump($query, 10, true);

        return $this->render('bhg4', [
            'lpp' => $lpp,
            'lpp_mrkh' => $markah,
            'kriteria' => $kriteria->asArray()->all(),
            'jumlah' => $jumlah,
            'mrkhBhg' => $mrkhBhg,
            'tt' => $ulasan_tt,
        ]);
    }

    public function actionBahagian4Test($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        if ($lpp->tahun < 2022) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
        }

        $mrkhBhg = RefMarkahBahagian::find()->where(['kump_khidmat' => $lpp->gredJawatan->job_group, 'bahagian_id' => 3])->one();

        if (($ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $ulasan_tt = new TblUlasan();
        }

        $query = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $lpp_id, 'bahagian_id' => 3])
            ->indexBy('bhk_id')
            ->all();

        $kriteria = TblBahagianKriteria::find()
            ->select(['hrm.lppums_bahagian_has_kriteria.*', 'hrm.lppums_kriteria.*'])
            ->joinWith('kriteria')
            ->where(['bahagian_id' => 3, 'kump_khidmat' => $lpp->gredJawatan->job_group]);

        if (empty($kriteria->all())) {
            throw new UserException('Anda tidak mempunyai akses kepada bahagian ini.');
        }

        if ($query) {
            $markah = $query;
        } else {
            $markah = [new TblLppMarkah()];
            for ($i = 1; $i < $kriteria->count(); $i++) {
                $markah[] = new TblLppMarkah();
            }
        }

        if (Model::loadMultiple($markah, Yii::$app->request->post()) && Model::validateMultiple($markah, ['bhk_id', 'markah_PPP', 'markah_PPK'])) {
            foreach ($markah as $mrkh) {
                $mrkh->tarikh_kemaskini = new \yii\db\Expression('NOW()');
                $mrkh->lpp_id = $lpp_id;
                if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPP_ = Yii::$app->user->identity->ICNO;
                }
                if ($lpp->PPK == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPK_ = Yii::$app->user->identity->ICNO;
                }
                $mrkh->save(false);
            }
            $this->UpdateMarkah($lpp_id);
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Markah berjaya disimpan!']);
            return $this->redirect(['lppums/bahagian4-test', 'lpp_id' => $lpp->lpp_id]);
        }

        $jumlah = ArrayHelper::toArray($query, [
            'app\models\lppums\TblLppMarkah' => [
                'markah_PPP',
                'markah_PPK',
            ],
        ]);

        //        return \yii\helpers\VarDumper::dump($query, 10, true);

        return $this->render('bhg4_test', [
            'lpp' => $lpp,
            'lpp_mrkh' => $markah,
            'kriteria' => $kriteria->asArray()->all(),
            'jumlah' => $jumlah,
            'mrkhBhg' => $mrkhBhg,
            'tt' => $ulasan_tt,
        ]);
    }

    public function actionBahagian5($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        if ($lpp->tahun >= 2022) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
        }

        if (($ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $ulasan_tt = new TblUlasan();
        }

        $mrkhBhg = RefMarkahBahagian::find()->where(['kump_khidmat' => $lpp->gredJawatan->job_group, 'bahagian_id' => 2])->one();

        $query = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $lpp_id, 'bahagian_id' => 2])
            ->indexBy('bhk_id')
            ->all();

        $kriteria = TblBahagianKriteria::find()
            ->select(['hrm.lppums_bahagian_has_kriteria.*', 'hrm.lppums_kriteria.*'])
            ->joinWith('kriteria')
            ->where(['bahagian_id' => 2, 'kump_khidmat' => $lpp->gredJawatan->job_group]);

        if (empty($kriteria->all())) {
            throw new UserException('Anda tidak mempunyai akses kepada bahagian ini.');
        }

        if ($query) {
            $markah = $query;
        } else {
            $markah = [new TblLppMarkah()];
            for ($i = 1; $i < $kriteria->count(); $i++) {
                $markah[] = new TblLppMarkah();
            }
        }

        if (Model::loadMultiple($markah, Yii::$app->request->post()) && Model::validateMultiple($markah, ['bhk_id', 'markah_PPP', 'markah_PPK'])) {
            foreach ($markah as $mrkh) {
                $mrkh->tarikh_kemaskini = new \yii\db\Expression('NOW()');
                $mrkh->lpp_id = $lpp_id;
                if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPP_ = Yii::$app->user->identity->ICNO;
                }
                if ($lpp->PPK == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPK_ = Yii::$app->user->identity->ICNO;
                }
                $mrkh->save(false);
            }
            $this->UpdateMarkah($lpp_id);
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Markah berjaya disimpan!']);
            return $this->redirect(['lppums/bahagian5', 'lpp_id' => $lpp->lpp_id]);
        }

        $jumlah = ArrayHelper::toArray($query, [
            'app\models\lppums\TblLppMarkah' => [
                'markah_PPP',
                'markah_PPK',
            ],
        ]);

        return $this->render('bhg5', [
            'lpp' => $lpp,
            'lpp_mrkh' => $markah,
            'kriteria' => $kriteria->asArray()->all(),
            'jumlah' => $jumlah,
            'mrkhBhg' => $mrkhBhg,
            'tt' => $ulasan_tt,
        ]);
    }

    public function actionBahagian5Test($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        if ($lpp->tahun < 2022) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
        }


        if (($ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $ulasan_tt = new TblUlasan();
        }

        $mrkhBhg = RefMarkahBahagian::find()->where(['kump_khidmat' => $lpp->gredJawatan->job_group, 'bahagian_id' => 2])->one();

        $query = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $lpp_id, 'bahagian_id' => 2])
            ->indexBy('bhk_id')
            ->all();

        $kriteria = TblBahagianKriteria::find()
            ->select(['hrm.lppums_bahagian_has_kriteria.*', 'hrm.lppums_kriteria.*'])
            ->joinWith('kriteria')
            ->where(['bahagian_id' => 2, 'kump_khidmat' => $lpp->gredJawatan->job_group]);

        if (empty($kriteria->all())) {
            throw new UserException('Anda tidak mempunyai akses kepada bahagian ini.');
        }

        if ($query) {
            $markah = $query;
        } else {
            $markah = [new TblLppMarkah()];
            for ($i = 1; $i < $kriteria->count(); $i++) {
                $markah[] = new TblLppMarkah();
            }
        }

        if (Model::loadMultiple($markah, Yii::$app->request->post()) && Model::validateMultiple($markah, ['bhk_id', 'markah_PPP', 'markah_PPK'])) {
            foreach ($markah as $mrkh) {
                $mrkh->tarikh_kemaskini = new \yii\db\Expression('NOW()');
                $mrkh->lpp_id = $lpp_id;
                if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPP_ = Yii::$app->user->identity->ICNO;
                }
                if ($lpp->PPK == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPK_ = Yii::$app->user->identity->ICNO;
                }
                $mrkh->save(false);
            }
            $this->UpdateMarkah($lpp_id);
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Markah berjaya disimpan!']);
            return $this->redirect(['lppums/bahagian5-test', 'lpp_id' => $lpp->lpp_id]);
        }

        $jumlah = ArrayHelper::toArray($query, [
            'app\models\lppums\TblLppMarkah' => [
                'markah_PPP',
                'markah_PPK',
            ],
        ]);

        return $this->render('bhg5_test', [
            'lpp' => $lpp,
            'lpp_mrkh' => $markah,
            'kriteria' => $kriteria->asArray()->all(),
            'jumlah' => $jumlah,
            'mrkhBhg' => $mrkhBhg,
            'tt' => $ulasan_tt,
        ]);
    }

    public function actionBahagian6($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        if ($lpp->tahun >= 2022) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
        }

        if (($ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $ulasan_tt = new TblUlasan();
        }

        $mrkhBhg = RefMarkahBahagian::find()->where(['kump_khidmat' => $lpp->gredJawatan->job_group, 'bahagian_id' => 4])->one();

        $query = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $lpp_id, 'bahagian_id' => 4])
            ->indexBy('bhk_id')
            ->all();

        $kriteria = TblBahagianKriteria::find()
            ->select(['hrm.lppums_bahagian_has_kriteria.*', 'hrm.lppums_kriteria.*'])
            ->joinWith('kriteria')
            ->where(['bahagian_id' => 4, 'kump_khidmat' => $lpp->gredJawatan->job_group]);

        if (empty($kriteria->all())) {
            throw new UserException('Anda tidak mempunyai akses kepada bahagian ini.');
        }

        if ($query) {
            $markah = $query;
        } else {
            $count = count(Yii::$app->request->post('TblLppMarkah', []));
            $markah = [new TblLppMarkah()];
            for ($i = 1; $i < $count; $i++) {
                $markah[] = new TblLppMarkah();
            }
        }

        if (Model::loadMultiple($markah, Yii::$app->request->post()) && Model::validateMultiple($markah, ['bhk_id', 'markah_PPP', 'markah_PPK'])) {
            foreach ($markah as $mrkh) {
                $mrkh->tarikh_kemaskini = new \yii\db\Expression('NOW()');
                $mrkh->lpp_id = $lpp_id;
                if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPP_ = Yii::$app->user->identity->ICNO;
                }
                if ($lpp->PPK == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPK_ = Yii::$app->user->identity->ICNO;
                }
                $mrkh->save(false);
            }
            $this->UpdateMarkah($lpp_id);
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Markah berjaya disimpan!']);
            return $this->redirect(['lppums/bahagian6', 'lpp_id' => $lpp->lpp_id]);
        }

        $jumlah = ArrayHelper::toArray($query, [
            'app\models\lppums\TblLppMarkah' => [
                'markah_PPP',
                'markah_PPK',
            ],
        ]);

        return $this->render('bhg6', [
            'lpp' => $lpp,
            'lpp_mrkh' => $markah,
            'kriteria' => $kriteria->asArray()->all(),
            'jumlah' => $jumlah,
            'mrkhBhg' => $mrkhBhg,
            'tt' => $ulasan_tt,
        ]);
    }

    public function actionBahagian6Test($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        if ($lpp->tahun < 2022) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
        }

        if (($ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $ulasan_tt = new TblUlasan();
        }

        $mrkhBhg = RefMarkahBahagian::find()->where(['kump_khidmat' => $lpp->gredJawatan->job_group, 'bahagian_id' => 4])->one();

        $query = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $lpp_id, 'bahagian_id' => 4])
            ->indexBy('bhk_id')
            ->all();

        $kriteria = TblBahagianKriteria::find()
            ->select(['hrm.lppums_bahagian_has_kriteria.*', 'hrm.lppums_kriteria.*'])
            ->joinWith('kriteria')
            ->where(['bahagian_id' => 4, 'kump_khidmat' => $lpp->gredJawatan->job_group]);

        if (empty($kriteria->all())) {
            throw new UserException('Anda tidak mempunyai akses kepada bahagian ini.');
        }

        $countVer = TblSktv2::find()
            ->alias('a')
            // ->select('c.month, a.ringkasan, a.capai, a.sasaran_kerja, a.created_dt, a.updated_dt, a.id, a.lpp_id, a.aspek_id, d.verified_ppp')
            ->leftJoin(['b' => 'hrm.`lppums_v2_ref_aspek`'], 'b.`id` = a.`aspek_id`')
            ->rightJoin(['c' => 'hrm.`lppums_v2_ref_months`'], 'c.`month` = a.`month` and a.`aspek_id` = ' . 14 . ' and a.`lpp_id` = ' . $lpp_id . ' and a.`deleted_dt` IS NULL')
            ->innerJoin(['d' => 'hrm.`lppums_v2_tbl_document`'], 'd.`id_skt` = a.`id`')
            ->where(['is not', 'd.verified_ppp', NULL])
            ->count();

        if ($query) {
            $markah = $query;
        } else {
            $count = count(Yii::$app->request->post('TblLppMarkah', []));
            $markah = [new TblLppMarkah()];
            for ($i = 1; $i < $count; $i++) {
                $markah[] = new TblLppMarkah();
            }
        }

        $summm = \app\models\myidp\RptStatistikIdp::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
        $jum_min = $summm->idp_mata_min;
        $jum_dikira = $summm->jum_mata_dikira;

        if (($jum_min > 0) and ($jum_dikira >= $jum_min)) {
            $idp = 8;
        } else if ($jum_dikira > 0 and $jum_dikira < $jum_min) {
            $idp = 3;
        } else if ($jum_dikira == 0) {
            $idp = 0;
        }

        $idp = ($countVer == 0) ? 0 : $idp;

        foreach ($markah as $mm) {
            $mm->markah_PPP = $idp + min(10, $countVer);
            $mm->markah_PPK = $idp + ((!$lpp->PP_ALL) ? min(10, $countVer) : 0);
            // $mm->markah_PPP = min(10, $countVer);
            // $mm->markah_PPK = min(10, $countVer);
            $mm->tarikh_kemaskini = new \yii\db\Expression('NOW()');
            $mm->lpp_id = $lpp_id;
            $mm->bhk_id = $kriteria->asArray()->all()[0]['bhk_id'];
            if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                $mm->markah_PPP_ = $lpp->PPP;
            }
            if ($lpp->PPK == Yii::$app->user->identity->ICNO) {
                $mm->markah_PPK_ = $lpp->PPK;
            }
            $mm->save(false);
        }

        if (Model::loadMultiple($markah, Yii::$app->request->post()) && Model::validateMultiple($markah, ['bhk_id', 'markah_PPP', 'markah_PPK'])) {
            foreach ($markah as $mrkh) {
                $mrkh->tarikh_kemaskini = new \yii\db\Expression('NOW()');
                $mrkh->lpp_id = $lpp_id;
                if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPP_ = Yii::$app->user->identity->ICNO;
                }
                if ($lpp->PPK == Yii::$app->user->identity->ICNO) {
                    $mrkh->markah_PPK_ = Yii::$app->user->identity->ICNO;
                }
                $mrkh->save(false);
            }
            $this->UpdateMarkah($lpp_id);
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Markah berjaya disimpan!']);
            return $this->redirect(['lppums/bahagian6-test', 'lpp_id' => $lpp->lpp_id]);
        }

        $jumlah = ArrayHelper::toArray($markah, [
            'app\models\lppums\TblLppMarkah' => [
                'markah_PPP',
                'markah_PPK',
            ],
        ]);

        // return \yii\helpers\VarDumper::dump($jumlah, 10, true);

        return $this->render('bhg6_test', [
            'lpp' => $lpp,
            'lpp_mrkh' => $markah,
            'kriteria' => $kriteria->asArray()->all(),
            'jumlah' => $jumlah,
            'mrkhBhg' => $mrkhBhg,
            'tt' => $ulasan_tt,
            'countVer' => $countVer,
        ]);
    }

    public function actionBahagian7($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        //        if(($ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
        //            $ulasan_tt = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        //        }else {
        //            $ulasan_tt = new TblUlasan();
        //        }

        if (($model = TblMarkahKeseluruhan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $model = TblMarkahKeseluruhan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $model = new TblMarkahKeseluruhan();
        }
        $this->UpdateMarkah($lpp_id);
        return $this->render('bhg7', [
            'lpp' => $lpp,
            'model' => $model,
            //'tt' => $ulasan_tt,
        ]);
    }

    public function actionBahagian8($lpp_id)
    {
        \yii\helpers\Url::remember();
        $lpp = $this->findLpp($lpp_id);
        //$title = 'Bahagian 8 - Ulasan Keseluruhan Dan Pengesahan Oleh Pegawai Penilai Pertama';

        if (($model = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $model = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $model = new TblUlasan();
        }

        if (($model1 = TblMarkahKeseluruhan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $model1 = TblMarkahKeseluruhan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $model1 = new TblMarkahKeseluruhan();
        }

        //        if ((Yii::$app->request->post('lpp_id'))) {
        //            $tt->lpp_id = $lpp->lpp_id;
        //            $tt->sumbangan_tt = $lpp->PYD;
        //            $tt->sumbangan_tt_date = new \yii\db\Expression('NOW()');
        //            if ($tt->save(false)) {
        //                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disahkan!']);
        //                return $this->redirect(['lppums/bahagian2', 'lpp_id' => $lpp->lpp_id]);
        //            }
        //        }

        if ($model->load(Yii::$app->request->post())) {
            $model->lpp_id = $lpp_id;
            //            $model->ulasan_PPP_tt = $lpp->PPP;
            //            $model->ulasan_PPP_tt_datetime = new \yii\db\Expression('NOW()');
            if ($model->validate()) {
                $model->save();
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ulasan berjaya disimpan!']);
                return $this->redirect(['lppums/bahagian8', 'lpp_id' => $lpp_id]);
            } else {
                if (isset($model->getErrors()[0])) {
                    \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => $model->getErrors()[0][0]]);
                    return $this->goBack();
                } else {
                    \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Anda belum mengisi ruang ulasan']);
                    return $this->goBack();
                }
                //                return $this->redirect(['lppums/skt-bahagian3', 'lpp_id' => $lpp->lpp_id]);
            }
        }

        return $this->render('ulasan', [
            'lpp' => $lpp,
            'model' => $model,
            'model1' => $model1,
            //'title' => $title,
        ]);
    }

    public function actionTandatanganBahagian8($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);
        $model = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        if ($model->load(Yii::$app->request->post())) {
            //            $model->lpp_id = $lpp_id;
            $model->ulasan_PPP_tt = $lpp->PPP;
            $model->ulasan_PPP_tt_datetime = new \yii\db\Expression('NOW()');
            if ($model->validate()) {
                $model->save();
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ulasan berjaya disahkan!']);
                return $this->redirect(['lppums/bahagian8', 'lpp_id' => $lpp_id]);
                //                return $this->refresh();
            } else {
                if (isset($model->getErrors()[0])) {
                    \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => $model->getErrors()[0][0]]);
                    return $this->goBack();
                } else {
                    \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Anda belum mengisi ruang ulasan']);
                    return $this->goBack();
                }
                //                return $this->redirect(['lppums/skt-bahagian3', 'lpp_id' => $lpp->lpp_id]);
            }
        }
    }

    public function actionBahagian9($lpp_id)
    {
        \yii\helpers\Url::remember();
        $lpp = $this->findLpp($lpp_id);
        //$title = 'Bahagian 8 - Ulasan Keseluruhan Dan Pengesahan Oleh Pegawai Penilai Pertama';

        if (($model = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $model = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $model = new TblUlasan();
        }

        if (($model1 = TblMarkahKeseluruhan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $model1 = TblMarkahKeseluruhan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $model1 = new TblMarkahKeseluruhan();
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->lpp_id = $lpp_id;
            //            $model->ulasan_PPK_tt = $lpp->PPP;
            //            $model->ulasan_PPK_tt_datetime = new \yii\db\Expression('NOW()');
            if ($model->validate()) {
                $model->save();
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ulasan berjaya disimpan!']);
                return $this->redirect(['lppums/bahagian9', 'lpp_id' => $lpp_id]);
            } else {
                if (isset($model->getErrors()[0])) {
                    \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => $model->getErrors()[0][0]]);
                    return $this->goBack();
                } else {
                    \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Anda belum mengisi ruang ulasan']);
                    return $this->goBack();
                }
                //                return $this->redirect(['lppums/skt-bahagian3', 'lpp_id' => $lpp->lpp_id]);
            }
        }

        return $this->render('ulasan2', [
            'lpp' => $lpp,
            'model' => $model,
            'model1' => $model1,
            //'title' => $title,
        ]);
    }

    public function actionTandatanganBahagian9($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);
        $model = TblUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        if ($model->load(Yii::$app->request->post())) {
            //            $model->lpp_id = $lpp_id;
            $model->ulasan_PPK_tt = $lpp->PPP;
            $model->ulasan_PPK_tt_datetime = new \yii\db\Expression('NOW()');
            if ($model->validate()) {
                $model->save();
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ulasan berjaya disahkan!']);
                return $this->redirect(['lppums/bahagian9', 'lpp_id' => $lpp_id]);
                //                return $this->refresh();
            } else {
                if (isset($model->getErrors()[0])) {
                    \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => $model->getErrors()[0][0]]);
                    return $this->goBack();
                } else {
                    \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Anda belum mengisi ruang ulasan']);
                    return $this->goBack();
                }
                //                return $this->redirect(['lppums/skt-bahagian3', 'lpp_id' => $lpp->lpp_id]);
            }
        }
    }

    protected function findSkt($skt_id)
    {
        if (($model = TblSktV2::findOne($skt_id)) !== null) {
            return $model;
        }

        throw new UserException('The requested page does not exist.');
    }

    protected function findDoc($skt_id)
    {
        if (($model = TblDocuments::findOne(['id_skt' => $skt_id])) !== null) {
            return $model;
        }

        throw new UserException('The requested page does not exist.');
    }

    protected function findLpp($lpp_id)
    {
        if (($model = TblMain::findOne($lpp_id)) !== null) {
            return $model;
        }

        throw new UserException('The requested page does not exist.');
    }

    protected function UpdateMarkah($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        $mrkh_slrh = TblLppMarkah::find()
            ->select(new Expression('
                    (SUM(markah_PPP)/(COUNT(markah_PPP) * 10)) * b.`markah_bahagian` AS ppp, 
                    (SUM(markah_PPK)/(COUNT(markah_PPK) * 10)) * b.`markah_bahagian` AS ppk
                    '))
            ->leftJoin(['a' => 'hrm.lppums_bahagian_has_kriteria'], 'a.`bhk_id` = hrm.lppums_lpp_markah.`bhk_id`')
            ->leftJoin(['b' => 'hrm.lppums_markah_bahagian'], 'a.`bahagian_id` = b.`bahagian_id`')
            ->where(['lpp_id' => $lpp_id, 'b.`kump_khidmat`' => $lpp->gredJawatan->job_group])
            ->andWhere(['!=', 'b.`bahagian_id`', 5])
            ->groupBy('b.`bahagian_id`')
            ->asArray()
            ->all();

        $layak = 'layak' . $lpp->tahun;

        $jumlah = 'jum' . $lpp->tahun;

        if ($lpp->tahun >= 2020) {

            $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $lpp->gredJawatan->gred])->one();
            // $cpdgroup = $modelcpdgroupgj->cpdgroup;
            $mataCpd = \app\models\myidp\RptStatistikIdp::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();

            // $summm = RptStatistikIdpV2::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
            $summm = \app\models\myidp\RptStatistikIdp::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
            $jum_min = $summm->idp_mata_min;
            $jum_dikira = $summm->jum_mata_dikira;
        } else {
            $mataCpd2 = TblMataAkhir::find()
                ->where(['icno' => $lpp->PYD])
                ->one();

            $mataCpd = TblStatistikIdp::find()->where(['tahun' => $lpp->tahun, 'icno' => $lpp->PYD])->one();

            if (!is_null($mataCpd)) {
                if (!isset($mataCpd2->{$layak})) {
                    $jum_min = '';
                } else {
                    $jum_min = $mataCpd2->{$layak};
                }

                if (!isset($mataCpd->idp_mata_min)) {
                    $jum_min = 0;
                } else {
                    $jum_min = $mataCpd->idp_mata_min;
                }

                if (!isset($mataCpd2->{$jumlah})) {
                    $jum_dikira = '';
                } else {
                    $jum_dikira = $mataCpd2->{$jumlah};
                }

                if (!isset($mataCpd->jum_mata_dikira)) {
                    $jum_dikira = 0;
                } else {
                    $jum_dikira = $mataCpd->jum_mata_dikira;
                }
            }

            // $jum_min = !is_null($mataCpd) ? (!isset($mataCpd2->{$layak}) ? '' : $mataCpd2->{$layak}) : (!isset($mataCpd->idp_mata_min) ? 0 : $mataCpd->idp_mata_min);

            // $jum_dikira = !is_null($mataCpd) ? (!isset($mataCpd2->{$jumlah}) ? '' : $mataCpd2->{$jumlah}) : (!isset($mataCpd->jum_mata_dikira) ? 0 : $mataCpd->jum_mata_dikira);
        }

        $ppp = array_sum(ArrayHelper::getColumn($mrkh_slrh, 'ppp'));
        $ppk = array_sum(ArrayHelper::getColumn($mrkh_slrh, 'ppk'));

        if (($model = TblMarkahKeseluruhan::find()->where(['lpp_id' => $lpp_id])->one()) !== null) {
            $model = TblMarkahKeseluruhan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $model = new TblMarkahKeseluruhan();
        }

        if (($jum_min > 0) and ($jum_dikira >= $jum_min)) {
            $idp = 8;
        } else if ($jum_dikira > 0 and $jum_dikira < $jum_min) {
            $idp = 3;
        } else if ($jum_dikira == 0) {
            $idp = 0;
        }

        if ($lpp->tahun >= 2020) {
            $staf_projek = TblStaffProjek::find()->where(['icno' => $lpp->PYD])->exists();
            if ($staf_projek || ($mataCpd->idp_mata_min == 0)) {
                $idp = 8;
            }

            if ($lpp_id == 23569) {
                $idp = 8;
            }
        }

        //        return \yii\helpers\VarDumper::dump($idp, 10, true);

        $model->lpp_id = $lpp_id;
        //$model->markah_PPP = array_sum(array_column($query, 'markah_PPP'));

        if ($lpp->PYD_sts_lantikan == 7) {
            $model->markah_PPP = (($ppp + $idp) / 100) * 100;
            $model->markah_PPK = (($ppk + $idp) / 100) * 100;
        } else {
            $model->markah_PPP = (($ppp + $idp) / 108) * 100;
            $model->markah_PPK = (($ppk + $idp) / 108) * 100;
        }

        //        return \yii\helpers\VarDumper::dump($model->markah_PPP, 10, true);

        if (!$lpp->PP_ALL) {
            $model->markah_PP = ($model->markah_PPP + $model->markah_PPK) / 2;
        } else {
            $model->markah_PPK = null;
            $model->markah_PP = $model->markah_PPP;
        }

        $sahAll = false;
        if (!$lpp->PP_ALL) {
            if ($lpp->PYD_sah && $lpp->PPP_sah && $lpp->PPK_sah) {
                $sahAll = true;
            }
        } else {
            if ($lpp->PYD_sah && $lpp->PPP_sah) {
                $sahAll = true;
            }
        }

        if ($lpp->tahun >= 2019 && !$sahAll) {
            $model->save(false);
        }
    }

    public function actionSktBahagian1($lpp_id)
    {
        //$tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);

        if ($req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO])) {
            $req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
            if (date('Y-m-d H:i:s') > $req->close_date) {
                $req->delete();
            }
        }

        \yii\helpers\Url::remember();
        $lpp = $this->findLpp($lpp_id);

        if ($lpp->tahun >= 2022) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
        }

        $tahun = TblLppTahun::findOne([
            // 'lpp_aktif' => 'Y', 
            'lpp_tahun' => $lpp->tahun
        ]);

        $skt = TblSkt::find()->where(['lpp_id' => $lpp_id])->andWhere(['skt_status' => null]);

        if (($tt = TblSktTandatangan::find()->where(['lpp_id' => $lpp_id])->one()) != null) {
            $tt = TblSktTandatangan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $tt = new TblSktTandatangan();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $skt,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 5,
            ],
            'sort' => false,
        ]);

        //        if (Yii::$app->request->isPost) {
        //            $tt->lpp_id = $lpp->lpp_id;
        //            $tt->skt_tt_pyd = $lpp->PYD;
        //            $tt->skt_tt_pyd_datetime = new \yii\db\Expression('NOW()');
        //            if ($tt->save(false)) {
        //                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disahkan!']);
        //                return $this->redirect(['lppums/skt-bahagian1', 'lpp_id' => $lpp->lpp_id]);
        //            }
        //        }

        if ((Yii::$app->request->post())) {
            $data = Yii::$app->request->get('lpp_id');
            $tt->lpp_id = $data;
            if ($lpp->PYD == Yii::$app->user->identity->ICNO) {
                $tt->skt_tt_pyd = $lpp->PYD;
                $tt->skt_tt_pyd_datetime = new \yii\db\Expression('NOW()');
            }
            if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                $tt->skt_tt_ppp = $lpp->PPP;
                $tt->skt_tt_ppp_datetime = new \yii\db\Expression('NOW()');
            }
            if ($tt->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disahkan!']);
                return $this->redirect(['lppums/skt-bahagian1', 'lpp_id' => $lpp->lpp_id]);
            }
        }

        return $this->render('skt_bhg1', [
            'tahun' => $tahun,
            'lpp' => $lpp,
            'dataProvider' => $dataProvider,
            'tt' => $tt,
            'req' => $req
        ]);
    }

    public function actionSktBahagian1Test($lpp_id, $chosen_tab = null)
    {
        \yii\helpers\Url::remember();
        $lpp = $this->findLpp($lpp_id);

        if ($lpp->tahun < 2022) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
        }

        $tahun = TblLppTahun::findOne([
            // 'lpp_aktif' => 'Y', 
            'lpp_tahun' => $lpp->tahun
        ]);

        if ($req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO])) {
            $req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
            if (date('Y-m-d H:i:s') > $req->close_date) {
                $req->delete();
            }
        }

        if (($tt = TblSktTandatangan::find()->where(['lpp_id' => $lpp_id])->one()) != null) {
            $tt = TblSktTandatangan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $tt = new TblSktTandatangan();
        }

        // $items = [];
        $bhgs = \app\models\lppums\RefBahagian::find()
            ->alias('a')
            ->select('a.*, b.*')
            ->leftJoin(['b' => 'hrm.lppums_v2_ref_aspek'], 'b.bahagian_id = a.bahagian_id')
            ->where(['a.bahagian_id' => [1, 3, 2]])
            // ->orderBy(['FIELD(a.bahagian_id)' =>  [1, 3, 2]])
            ->orderBy([new \yii\db\Expression('FIELD (a.bahagian_id, 1, 3, 2)')])
            ->asArray()
            ->all();

        $query = TblSktv2::find()
            ->alias('a')
            ->select('c.month, a.ringkasan, a.capai, a.sasaran_kerja, a.created_dt, a.updated_dt, a.id, a.lpp_id')
            ->leftJoin(['b' => 'hrm.`lppums_v2_ref_aspek`'], 'b.`id` = a.`aspek_id`');

        if ((Yii::$app->request->post())) {
            $data = Yii::$app->request->get('lpp_id');
            $tt->lpp_id = $data;
            if ($lpp->PYD == Yii::$app->user->identity->ICNO) {
                $tt->skt_tt_pyd = $lpp->PYD;
                $tt->skt_tt_pyd_datetime = new \yii\db\Expression('NOW()');
            }
            if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                $tt->skt_tt_ppp = $lpp->PPP;
                $tt->skt_tt_ppp_datetime = new \yii\db\Expression('NOW()');
            }
            if ($tt->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disahkan!']);
                return $this->redirect(['lppums/skt-bahagian1-test', 'lpp_id' => $lpp->lpp_id]);
            }
        }

        return $this->render('//lppums/v2/skt_bhg1_test', [
            'lpp' => $lpp,
            'bhgs' => $bhgs,
            'query' => $query,
            'lppid' => $lpp_id,
            'tt' => $tt,
            'tahun' => $tahun,
            'req' => $req,
            'chosen_tab' => $chosen_tab,
        ]);
    }

    public function actionTambahSktTest($lpp_id, $chosen_tab)
    {
        $model = new TblSktv2();
        $doc = new \app\models\lppums\v2\TblDocuments();
        $doc->scenario = \app\models\lppums\v2\TblDocuments::SCENARIO_CREATE;
        $model->scenario = TblSktv2::SCENARIO_SKT;
        if ($model->load(Yii::$app->request->post())) {
            $model->lpp_id = $lpp_id;
            $model->created_dt = new \yii\db\Expression('NOW()');

            if ($model->save()) {
                $doc->file = UploadedFile::getInstance($doc, 'file');
                $this->addDocument($doc, $model->getPrimaryKey());
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya ditambah']);
                return $this->redirect(['lppums/skt-bahagian1-test', 'lpp_id' => $lpp_id, 'chosen_tab' => $chosen_tab]);
            }
        }

        return $this->renderAjax('tmbhSktTest', ['doc' => $doc, 'model' => $model]);
    }

    public function actionTambahAktiviti($lpp_id)
    {
        $model = new TblSktv2();
        $doc = new \app\models\lppums\v2\TblDocuments();
        $doc->scenario = \app\models\lppums\v2\TblDocuments::SCENARIO_CREATE;
        $model->scenario = TblSktv2::SCENARIO_AKTIVITI;
        if ($model->load(Yii::$app->request->post())) {
            $model->lpp_id = $lpp_id;
            $model->aspek_id = 14;
            $model->created_dt = new \yii\db\Expression('NOW()');

            if ($model->save()) {
                $doc->file = UploadedFile::getInstance($doc, 'file');
                $this->addDocument($doc, $model->getPrimaryKey());
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya ditambah']);
                return $this->redirect(['lppums/bahagian2-test', 'lpp_id' => $lpp_id]);
            }
        }

        return $this->renderAjax('tmbhAktiviti', ['doc' => $doc, 'model' => $model]);
    }

    public function actionEditSktTest($lpp_id, $skt_id)
    {
        $model = $this->findSkt($skt_id);
        $doc =  \app\models\lppums\v2\TblDocuments::find()->where(['id_skt' => $skt_id])->one();

        if($doc == null){
            $doc = new \app\models\lppums\v2\TblDocuments();
        }

        $model->scenario = TblSktv2::SCENARIO_SKT;
        if ($model->load(Yii::$app->request->post())) {
            $doc->id_skt = $model->id;
            $model->updated_dt = new \yii\db\Expression('NOW()');

            if ($model->save()) {
                $this->editDocument($doc, $model->id);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikemaskini']);
                return $this->redirect(['lppums/skt-bahagian1-test', 'lpp_id' => $lpp_id]);
            }
        }

        return $this->renderAjax('tmbhSktTest', ['doc' => $doc, 'model' => $model]);
    }

    public function actionEditAktiviti($lpp_id, $skt_id)
    {
        $model = $this->findSkt($skt_id);
        $doc =  \app\models\lppums\v2\TblDocuments::find()->where(['id_skt' => $skt_id])->one();
        $model->scenario = TblSktv2::SCENARIO_AKTIVITI;
        if ($model->load(Yii::$app->request->post())) {
            $model->updated_dt = new \yii\db\Expression('NOW()');

            if ($model->save()) {
                $this->editDocument($doc, $model->id);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikemaskini']);
                return $this->redirect(['lppums/bahagian2-test', 'lpp_id' => $lpp_id]);
            }
        }

        return $this->renderAjax('tmbhAktiviti', ['doc' => $doc, 'model' => $model]);
    }

    public function actionDeleteSktTest($lpp_id, $skt_id)
    {
        $model = $this->findSkt($skt_id);
        $model->deleted_dt = new \yii\db\Expression('NOW()');
        $model->save();
        $this->delDocument($skt_id);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeleteAktiviti($skt_id)
    {
        $model = $this->findSkt($skt_id);
        $model->deleted_dt = new \yii\db\Expression('NOW()');
        $model->save();
        $this->delDocument($skt_id);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function addDocument($doc, $sktid)
    {
        $doc->file = UploadedFile::getInstance($doc, 'file');
        // $tmp = $doc->filehash;
        if ($doc->file) {
            $file = Yii::$app->FileManager->UploadFile($doc->file->name, $doc->file->tempName, '04', 'LNPT/Pentadbiran/skt/');
            if ($file->status == true) {
                $doc->id_skt = $sktid;
                $doc->filehash = $file->file_name_hashcode;
                $doc->file_name = $doc->file->name;
                $doc->created_dt = new \yii\db\Expression('NOW()');
                $doc->save(false);
            }
        }
    }

    public function editDocument($doc, $sktid)
    {
        $doc->file = UploadedFile::getInstance($doc, 'file');
        // $tmp = $doc->filehash;
        if (!empty($doc->file)) {
            Yii::$app->FileManager->DeleteFile($doc->filehash);
            $file = Yii::$app->FileManager->UploadFile($doc->file->name, $doc->file->tempName, '04', 'LNPT/Pentadbiran/skt/');
            if ($file->status == true) {
                // $doc->lpp_id = $lppid;
                // $doc->bhg_no = $bhg_no;
                // $doc->id_table = $id_table;
                $doc->filehash = $file->file_name_hashcode;
                $doc->file_name = $doc->file->name;
                $doc->created_dt = new \yii\db\Expression('NOW()');
                $doc->save(false);
            }
        }
    }

    public function delDocument($sktid)
    {
        $doc = \app\models\lppums\v2\TblDocuments::find()->where(['id_skt' => $sktid])->one();
        Yii::$app->FileManager->DeleteFile($doc->filehash);
        $doc->delete();
    }

    public function actionViewFile($hashfile, $lpp_id)
    {
        if ($hashfile == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->redirect(Yii::$app->FileManager->DisplayFile($hashfile));
    }

    public function actionTambahSkt($lpp_id)
    {
        $model = new TblSkt();

        if ($model->load(Yii::$app->request->post())) {
            $model->lpp_id = $lpp_id;
            if ($model->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya ditambah!']);
                //                return $this->redirect(['lppums/skt-bahagian1', 'lpp_id' => $lpp_id]);
                return $this->goBack();
            }
        }

        return $this->renderAjax('tmbhSkt', ['model' => $model]);
    }

    public function actionUpdateSkt($sktid, $lpp_id)
    {
        $model = TblSkt::findOne(['skt_id' => $sktid]);

        if ($model->load(Yii::$app->request->post())) {
            //$model->lpp_id = $lppid;
            if ($model->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikemaskini!']);
                //                return $this->redirect(['lppums/skt-bahagian2', 'lpp_id' => $lpp_id]);
                return $this->goBack();
            }
        }

        return $this->renderAjax('tmbhSkt', ['model' => $model]);
    }

    public function actionDeleteSkt($sktid, $lpp_id)
    {
        $model = TblSkt::findOne(['skt_id' => $sktid]);
        $model->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        //        return $this->redirect(['lppums/skt-bahagian2', 'lpp_id' => $lpp_id]);
        return $this->goBack();
    }

    public function actionSktBahagian2($lpp_id)
    {
        //$tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);
        \yii\helpers\Url::remember();
        $lpp = $this->findLpp($lpp_id);

        $tahun = TblLppTahun::findOne([
            // 'lpp_aktif' => 'Y', 
            'lpp_tahun' => $lpp->tahun
        ]);

        if ($req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO])) {
            $req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
            if (date('Y-m-d H:i:s') > $req->close_date) {
                $req->delete();
            }
        }

        if (($skt_ulasan = TblSktUlasan::find()->where(['lpp_id' => $lpp_id])->one()) != null) {
            $skt_ulasan = TblSktUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $skt_ulasan = new TblSktUlasan();
        }

        $skt_tamb = TblSkt::find()->where(['lpp_id' => $lpp_id, 'skt_status' => 'TAMB']);

        $skt_gugur = TblSkt::find()->where(['lpp_id' => $lpp_id, 'skt_status_gugur' => 'GUGUR']);

        $skt = TblSkt::find()->where(['lpp_id' => $lpp_id])
            ->andWhere(['is', 'skt_status', null])
            ->andWhere(['is', 'skt_status_gugur', null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $skt_tamb,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 5,
            ],
            'sort' => false,
        ]);

        $dataProvider1 = new ActiveDataProvider([
            'query' => $skt_gugur,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 5,
            ],
            'sort' => false,
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $skt,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 5,
            ],
            'sort' => false,
        ]);

        // if ((Yii::$app->request->post('lpp_id'))) {
        //     $tt->lpp_id = $lpp->lpp_id;
        //     $tt->skt_tt_pyd = $lpp->PYD;
        //     $tt->skt_tt_pyd_datetime = new \yii\db\Expression('NOW()');
        //     if ($tt->save(false)) {
        //         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disahkan!']);
        //         return $this->redirect(['lppums/skt-bahagian2', 'lpp_id' => $lpp->lpp_id]);
        //     }
        // }

        return $this->render('skt_bhg2', [
            'tahun' => $tahun,
            'lpp' => $lpp,
            'dataProvider' => $dataProvider,
            'dataProvider1' => $dataProvider1,
            'dataProvider2' => $dataProvider2,
            'ulasan' => $skt_ulasan,
            'req' => $req,
        ]);
    }

    public function actionTambahSkt1($lpp_id)
    {
        $model = new TblSkt();

        if ($model->load(Yii::$app->request->post())) {
            $model->lpp_id = $lpp_id;
            $model->skt_status = 'TAMB';
            if ($model->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya ditambah!']);
                return $this->redirect(['lppums/skt-bahagian2', 'lpp_id' => $lpp_id]);
            }
        }

        return $this->renderAjax('tmbhSkt', ['model' => $model]);
    }

    public function actionGugurSkt($sktid, $lpp_id)
    {
        $model = TblSkt::findOne(['skt_id' => $sktid]);
        $model->skt_status_gugur = 'GUGUR';
        $model->save(false);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya digugurkan!']);
        return $this->redirect(['lppums/skt-bahagian2', 'lpp_id' => $lpp_id]);
    }

    public function actionKembaliSkt($sktid, $lpp_id)
    {
        $model = TblSkt::findOne(['skt_id' => $sktid]);
        $model->skt_status_gugur = null;
        $model->save(false);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikembalikan!']);
        return $this->redirect(['lppums/skt-bahagian2', 'lpp_id' => $lpp_id]);
    }

    public function actionSktBahagian3($lpp_id)
    {
        \yii\helpers\Url::remember();
        //$tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);
        $lpp = $this->findLpp($lpp_id);

        $tahun = TblLppTahun::findOne([
            // 'lpp_aktif' => 'Y', 
            'lpp_tahun' => $lpp->tahun
        ]);

        if ($req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO])) {
            $req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
            if (date('Y-m-d H:i:s') > $req->close_date) {
                $req->delete();
            }
        }

        if (($skt_ulasan = TblSktUlasan::find()->where(['lpp_id' => $lpp_id])->one()) != null) {
            $skt_ulasan = TblSktUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $skt_ulasan = new TblSktUlasan();
        }

        if ($skt_ulasan->load(Yii::$app->request->post())) {
            $skt_ulasan->lpp_id = $lpp_id;

            if ($lpp->PYD == Yii::$app->user->identity->ICNO) {
                $skt_ulasan->su_pyd_datetime = new \yii\db\Expression('NOW()');
            }
            if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                $skt_ulasan->su_ppp_datetime = new \yii\db\Expression('NOW()');
            }

            if ($skt_ulasan->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ulasan berjaya disimpan!']);
                return $this->redirect(['lppums/skt-bahagian3', 'lpp_id' => $lpp_id]);
            }
        }

        if ((Yii::$app->request->post())) {
            $data = Yii::$app->request->get('lpp_id');
            $skt_ulasan->lpp_id = $data;
            if ($lpp->PYD == Yii::$app->user->identity->ICNO) {
                $skt_ulasan->skt_ulasan_tt_pyd = $lpp->PYD;
                $skt_ulasan->su_tt_pyd_datetime = new \yii\db\Expression('NOW()');
            }
            if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
                $skt_ulasan->skt_ulasan_tt_ppp = $lpp->PPP;
                $skt_ulasan->su_tt_ppp_datetime = new \yii\db\Expression('NOW()');
            }
            if ($skt_ulasan->validate()) {
                $skt_ulasan->save();
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disahkan!']);
                return $this->redirect(['lppums/skt-bahagian3', 'lpp_id' => $lpp->lpp_id]);
            } else {
                if (isset($skt_ulasan->getErrors()[0])) {
                    \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => $skt_ulasan->getErrors()[0][0]]);
                    return $this->goBack();
                } else {
                    \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Anda belum mengisi ruang ulasan']);
                    return $this->goBack();
                }
                //                return $this->redirect(['lppums/skt-bahagian3', 'lpp_id' => $lpp->lpp_id]);
            }
        }

        return $this->render('skt_bhg3', [
            'tahun' => $tahun,
            'lpp' => $lpp,
            'model' => $skt_ulasan,
            'req' => $req,
        ]);
    }

    public function actionSenaraiTugas($lpp_id)
    {
        //$tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);
        $lpp = $this->findLpp($lpp_id);

        $tahun = TblLppTahun::findOne([
            // 'lpp_aktif' => 'Y', 
            'lpp_tahun' => $lpp->tahun
        ]);

        if ($req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO])) {
            $req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
            if (date('Y-m-d H:i:s') > $req->close_date) {
                $req->delete();
            }
        }

        $senarai = TblSenaraiTugas::find()->where(['lpp_id' => $lpp_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 15,
            ],
            'sort' => false,
        ]);

        return $this->render('senaraiTugas', [
            'tahun' => $tahun,
            'lpp' => $lpp,
            'dataProvider' => $dataProvider,
            'req' => $req
        ]);
    }

    public function actionSenaraiTugasBaru($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        $id = TblPortfolio::find()->where(['icno' => $lpp->PYD])->orderBy(['id' => SORT_DESC])->one()->id;

        $deskripsi = TblPortfolio::find()->where(['id' => $id])->with('applicant')->one();
        $ikhtisas = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $pengalaman = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $syarat = TblSyaratTambahan::find()->where(['portfolio_id' => $deskripsi->id])->all();

        return $this->render(
            'deskripsi-tugas',
            [
                'deskripsi' => $deskripsi,
                'lihatDimensi' => $lihatDimensi,
                'ikhtisas' => $ikhtisas,
                'pengalaman' => $pengalaman,
                'lihatKompetensi' => $lihatKompetensi,
                'akauntabiliti' => $akauntabiliti,
                'syarat' => $syarat,
                'lpp' => $lpp,
            ]
        );
    }

    public function actionTandatanganKj($lpp_id)
    {
        $model = $this->findLpp($lpp_id);
        //        if ($model->load(Yii::$app->request->post())) {
        //            $model->lpp_id = $lpp_id;
        $model->KJ_sah = $model->PPP;
        $model->KJ_sah_datetime = new \yii\db\Expression('NOW()');
        if ($model->save()) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Senarai tugas berjaya disahkan!']);
            return $this->redirect(['lppums/senarai-tugas', 'lpp_id' => $lpp_id]);
            //                return $this->refresh();
        }
        //        }
    }

    public function actionTambahSenarai($lpp_id)
    {
        $model = new TblSenaraiTugas();

        if ($model->load(Yii::$app->request->post())) {
            $model->lpp_id = $lpp_id;
            if ($model->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya ditambah!']);
                return $this->redirect(['lppums/senarai-tugas', 'lpp_id' => $lpp_id]);
            }
        }

        return $this->renderAjax('tmbhSenarai', ['model' => $model]);
    }

    public function actionUpdateSenarai($sktid, $lpp_id)
    {
        $model = TblSenaraiTugas::findOne(['senarai_tugas_id' => $sktid]);

        if ($model->load(Yii::$app->request->post())) {
            //$model->lpp_id = $lppid;
            if ($model->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikemaskini!']);
                return $this->redirect(['lppums/senarai-tugas', 'lpp_id' => $lpp_id]);
            }
        }

        return $this->renderAjax('tmbhSenarai', ['model' => $model]);
    }

    public function actionDeleteSenarai($sktid, $lpp_id)
    {
        $model = TblSenaraiTugas::findOne(['senarai_tugas_id' => $sktid]);

        $model->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        return $this->redirect(['lppums/senarai-tugas', 'lpp_id' => $lpp_id]);
    }

    public function actionPengesahan($lpp_id)
    {
        //$tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);
        $lpp = $this->findLpp($lpp_id);

        $tahun = TblLppTahun::findOne([
            // 'lpp_aktif' => 'Y', 
            'lpp_tahun' => $lpp->tahun
        ]);

        if ($req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO])) {
            $req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
            if (date('Y-m-d H:i:s') > $req->close_date) {
                $req->delete();
            }
        }

        return $this->render('pengesahan', [
            'tahun' => $tahun,
            'lpp' => $lpp,
            'req' => $req,
        ]);
    }

    public function actionPengesahanMarkah($lpp_id)
    {
        //$tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);
        $lpp = $this->findLpp($lpp_id);

        $tahun = TblLppTahun::findOne([
            // 'lpp_aktif' => 'Y', 
            'lpp_tahun' => $lpp->tahun
        ]);

        //        if($req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO])){
        //            $req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
        //            if(date('Y-m-d H:i:s') > $req->close_date){
        //                $req->delete();
        //            }
        //        }

        return $this->render('pengesahan_markah', [
            'tahun' => $tahun,
            'lpp' => $lpp,
            //            'req' => $req,
        ]);
    }

    public function actionPengesahanPyd($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        $lpp->scenario = 'sah_pyd';

        if ($lpp->load(Yii::$app->request->post())) {
            $lpp->PYD_sah_datetime = new \yii\db\Expression('NOW()');
            //            $model->lpp_id = $lppid;
            //            $model->skt_status = 'TAMB';
            if ($lpp->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Penilaian Prestasi Tahun berjaya disahkan!']);
                return $this->redirect(['lppums/pengesahan', 'lpp_id' => $lpp_id]);
            }
        }

        return $this->renderAjax('sah_pyd', [
            'model' => $lpp
        ]);
    }

    public function actionMohonSemak($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        if (($alasan = TblAlasanSemakan::findOne(['lpp_id' => $lpp_id])) != null) {
            $alasan = TblAlasanSemakan::findOne(['lpp_id' => $lpp_id]);
        } else {
            $alasan = null;
        }

        return $this->renderAjax('mohon_semak', [
            'model' => $lpp,
            'alasan' => $alasan
        ]);
    }

    public function actionMarkahSetuju($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        //        $lpp->scenario = 'sah_pyd';

        $alasan = TblAlasanSemakan::find()->where(['lpp_id' => $lpp_id])->exists();

        //        if ($lpp->load(Yii::$app->request->post())) {
        $lpp->markah_sah = 1;
        $lpp->markah_sah_datetime = new \yii\db\Expression('NOW()');
        //            $model->lpp_id = $lppid;
        //            $model->skt_status = 'TAMB';
        if ($lpp->validate() && !$alasan) {
            $lpp->save();
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan markah telah dihantar!']);
            return $this->redirect(['lppums/pengesahan-markah', 'lpp_id' => $lpp_id]);
        } else {
            \Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'warning', 'msg' => 'Pengesahan markah tidak berjaya!']);
            return $this->redirect(['lppums/pengesahan-markah', 'lpp_id' => $lpp_id]);
        }
        //        }

        //        return $this->renderAjax('sah_pyd', [
        //            'model' => $lpp
        //                ]);
    }

    public function actionMarkahTidakSetuju($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        if ($alasan = TblAlasanSemakan::find()->where(['lpp_id' => $lpp_id])->one()) {
            $alasan = TblAlasanSemakan::find()->where(['lpp_id' => $lpp_id])->indexBy('id_alasan')->all();
        } else {
            //            $count = count(Yii::$app->request->post('TblAlasanSemakan', []));
            $alasan = [new TblAlasanSemakan()];
            for ($i = 0; $i < 3; $i++) {
                $alasan[] = new TblAlasanSemakan();
            }
        }

        $lpp->scenario = 'sah_pyd_markah';

        if (Model::loadMultiple($alasan, Yii::$app->request->post()) && Model::validateMultiple($alasan)) {
            foreach ($alasan as $index => $alas) {
                $alas->lpp_id = $lpp_id;
                $alas->id_alasan = $index;
                $alas->save(false);
            }

            $lpp->markah_sah = 0;
            $lpp->markah_sah_datetime = new \yii\db\Expression('NOW()');

            if ($lpp->save() && $lpp->validate()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan anda berjaya dihantar!']);
                return $this->redirect(['lppums/pengesahan-markah', 'lpp_id' => $lpp_id]);
                //                return $this->goBack();
            }
        }

        //        if ($lpp->load(Yii::$app->request->post())) {
        //            $lpp->markah_sah = 0;
        //            $lpp->markah_sah_datetime = new \yii\db\Expression('NOW()');
        ////            $model->lpp_id = $lppid;
        ////            $model->skt_status = 'TAMB';
        //            if ($lpp->save()) {
        //                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan markah telah dihantar!']);
        //                return $this->redirect(['lppums/pengesahan-markah', 'lpp_id' => $lpp_id]);
        //            }
        //        }

        return $this->renderAjax('sah_pyd_markah', [
            'model' => $alasan
        ]);
    }

    public function actionPengesahanPpp($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        $lpp->scenario = 'sah_ppp';

        if ($lpp->load(Yii::$app->request->post())) {
            $lpp->PPP_sah_datetime = new \yii\db\Expression('NOW()');
            //            $model->lpp_id = $lppid;
            //            $model->skt_status = 'TAMB';
            if ($lpp->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Penilaian Prestasi Tahun berjaya disahkan!']);
                return $this->redirect(['lppums/pengesahan', 'lpp_id' => $lpp_id]);
            }
        }

        return $this->renderAjax('sah_ppp', [
            'model' => $lpp
        ]);
    }

    public function actionPengesahanPpk($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        $lpp->scenario = 'sah_ppk';

        if ($lpp->load(Yii::$app->request->post())) {
            $lpp->PPK_sah_datetime = new \yii\db\Expression('NOW()');
            //            $model->lpp_id = $lppid;
            //            $model->skt_status = 'TAMB';
            if ($lpp->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Penilaian Prestasi Tahun berjaya disahkan!']);
                return $this->redirect(['lppums/pengesahan', 'lpp_id' => $lpp_id]);
            }
        }

        return $this->renderAjax('sah_ppk', [
            'model' => $lpp
        ]);
    }

    public function actionPenetapanAksesSistem()
    {
        $searchModel = new PenetapanAksesSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('akses_tetap', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionKemaskiniAksesPegawai($ICNO)
    {
        $id = Yii::$app->user->getId();
        $bio = Tblprcobiodata::findOne(['ICNO' => $ICNO]);

        if (TblStafAkses::findOne(['ICNO' => $ICNO]) != null) {
            $model = TblStafAkses::findOne(['ICNO' => $ICNO]);
        } else {
            $model = new TblStafAkses();
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $ICNO;
            $model->akses_oleh = $id;
            if ($model->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Akses berjaya disimpan!']);
                return $this->redirect('penetapan-akses-sistem');
            }
        }

        return $this->renderAjax('kemaskini_akses', ['bio' => $bio, 'model' => $model]);
    }

    public function actionPenetapanPegawaiPenilai()
    {
        \yii\helpers\Url::remember();
        $searchModel = new TblMainSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('penetapan_pegawai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPenetapanPegawai($lppid)
    {
        $lpp = TblMain::findOne(['lpp_id' => $lppid]);

        $searchModel = new TblprcobiodataSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //$dataProvider->query->andWhere(['<>', 'hronline.tblprcobiodata.ICNO', $lpp->PYD]);

        //        if ((is_null(Yii::$app->request->get('DeptId')) || empty(Yii::$app->request->get('DeptId')))
        //                && (is_null(Yii::$app->request->get('CONm')) || empty(Yii::$app->request->get('CONm')))){
        //            $dataProvider->query->andWhere('0 = 1');
        //            //return $dataProvider;
        //        }

        //        $dataProvider->pagination->pageSize = 5;

        if ($lpp->load(Yii::$app->request->post())) {

            if (empty($lpp->PP_ALL)) {
                $lpp->PP_ALL = null;
                if (!empty($lpp->PPP)) {
                    //                    $lpp->PPP = $ppp;
                    $ppp_data = Tblprcobiodata::findOne(['ICNO' => $lpp->PPP]);
                    $lpp->gred_jawatan_id_PPP = $ppp_data->gredJawatan;
                    $lpp->jspiu_PPP = $ppp_data->DeptId;
                    $ntf = new Notification();
                    $ntf->icno = $lpp->PPP;
                    $ntf->title = 'Pelantikan PPP';
                    $ntf->content = 'Anda dilantik sebagai PPP kepada ' . $lpp->pyd->CONm . '. Sila jalankan proses penilaian mengikut prosedur dan tempoh yang ditetapkan.';
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                } else {
                    $lpp->PPP = null;
                }
                if (!empty($lpp->PPK)) {
                    //                    $lpp->PPK = $ppk;
                    $ppk_data = Tblprcobiodata::findOne(['ICNO' => $lpp->PPK]);
                    $lpp->gred_jawatan_id_PPK = $ppk_data->gredJawatan;
                    $lpp->jspiu_PPK = $ppk_data->DeptId;
                    $ntf = new Notification();
                    $ntf->icno = $lpp->PPK;
                    $ntf->title = 'Pelantikan PPK';
                    $ntf->content = 'Anda dilantik sebagai PPK kepada ' . $lpp->pyd->CONm . '. Sila jalankan proses penilaian mengikut prosedur dan tempoh yang ditetapkan.';
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                } else {
                    $lpp->PPK = null;
                }
            } else {
                //                $lpp->PP_ALL = $pp;
                $pp_data = Tblprcobiodata::findOne(['ICNO' => $lpp->PP_ALL]);
                $lpp->PPP = $lpp->PP_ALL;
                $lpp->gred_jawatan_id_PPP = $pp_data->gredJawatan;
                $lpp->jspiu_PPP = $pp_data->DeptId;
                $lpp->PPK = $lpp->PP_ALL;
                $lpp->gred_jawatan_id_PPK = $pp_data->gredJawatan;
                $lpp->jspiu_PPK = $pp_data->DeptId;
                $ntf = new Notification();
                $ntf->icno = $lpp->PP_ALL;
                $ntf->title = 'Pelantikan PP Keseluruhan';
                $ntf->content = 'Anda dilantik sebagai PP Keseluruhan kepada ' . $lpp->pyd->CONm . '. Sila jalankan proses penilaian mengikut prosedur dan tempoh yang ditetapkan.';
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            }

            $lpp->save(false);

            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pegawai Penilai berjaya disimpan!']);
            return $this->goBack(['penetapan-pegawai', 'lppid' => $lppid]);
        }

        return $this->renderAjax('penetapan_pegawai_penilai', [
            'lpp' => $lpp,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'lppid' => $lppid,
        ]);
    }

    public function actionGugurPpp($lppid)
    {
        $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        $lpp->PPP = null;
        $lpp->gred_jawatan_id_PPP = null;
        $lpp->jspiu_PPP = null;
        $lpp->save(false);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'PPP berjaya digugurkan!']);
        //        return $this->redirect(['penetapan-pegawai', 'lppid' => $lppid]);
        return $this->goBack();
    }

    public function actionGugurPpk($lppid)
    {
        $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        $lpp->PPK = null;
        $lpp->gred_jawatan_id_PPK = null;
        $lpp->jspiu_PPK = null;
        $lpp->save(false);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'PPK berjaya digugurkan!']);
        //        return $this->redirect(['penetapan-pegawai', 'lppid' => $lppid]);
        return $this->goBack();
    }

    public function actionGugurPp($lppid)
    {
        $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        $lpp->PP_ALL = null;
        $lpp->PPP = null;
        $lpp->gred_jawatan_id_PPP = null;
        $lpp->jspiu_PPP = null;
        $lpp->PPK = null;
        $lpp->gred_jawatan_id_PPK = null;
        $lpp->jspiu_PPK = null;
        $lpp->save(false);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'PP Keseluruhan berjaya digugurkan!']);
        //        return $this->redirect(['penetapan-pegawai', 'lppid' => $lppid]);
        return $this->goBack();
    }

    public function actionBorangLpp()
    {
        $id = Yii::$app->user->getId();

        $bio = Tblprcobiodata::findOne(['ICNO' => $id]);

        $query = TblMain::find()
            ->where(['PYD' => $id])
            // ->andWhere(['>=', 'lpp_datetime', new Expression('DATE_ADD(NOW(), INTERVAL -4 YEAR)')])
            ->orderBy(['tahun' => SORT_DESC])
            ->all();

        return $this->render('borang_lpp', ['bio' => $bio, 'lpp' => $query]);
    }

    public function actionMohonLpp()
    {
        $id = Yii::$app->user->getId();

        $bio = Tblprcobiodata::findOne(['ICNO' => $id]);

        $model = new TblMain();

        if ($model->load(Yii::$app->request->post())) {
            //$model->lpp_id = $this->findLpp($id);
            $model->PYD = $id;
            $model->lpp_datetime = new \yii\db\Expression('NOW()');
            if ($model->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya dimohon!']);
                return $this->redirect('borang_lpp');
            }
        }
        //return $this->renderAjax('sign', ['model' => $model, 'model1' => $model1]);

        return $this->renderAjax('mohon_lpp', ['bio' => $bio, 'model' => $model]);
    }

    public function actionCarianBorangLpp()
    {
        $searchModel = new TblMainSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('cari_borang_lpp', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCarianBorangLppPenilai()
    {
        $searchModel = new TblMainSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('cari_borang_lpp_penilai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPengurusanTahunPenilaian()
    {
        $query = TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => [
            //'pageSize' => 10,
            //],
        ]);

        return $this->render('urus_tahun', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTambahTahunPenilaian()
    {
        $tahun_lpp = new TblLppTahun();

        if ($tahun_lpp->load(Yii::$app->request->post())) {
            //$model->lpp_id = $this->findLpp($id);
            $tahun_lpp->lpp_tahun = date("Y");

            if ($tahun_lpp->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tahun Penilaian berjaya ditambah!']);
                return $this->redirect('pengurusan-tahun-penilaian');
            }
        }

        return $this->renderAjax('tambah_tahun', ['model' => $tahun_lpp,]);
    }

    public function actionKemaskiniTahunPenilaian($tahun)
    {

        $tahun_lpp = TblLppTahun::findOne(['lpp_tahun' => $tahun]);

        if ($tahun_lpp->load(Yii::$app->request->post())) {
            //$model->lpp_id = $this->findLpp($id);

            if ($tahun_lpp->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tahun Penilaian berjaya dikemaskini!']);
                return $this->redirect('pengurusan-tahun-penilaian');
            }
        }

        return $this->renderAjax('tambah_tahun', ['model' => $tahun_lpp, 'tahun' => $tahun]);
    }

    public function actionResetBorangLpp()
    {
        \yii\helpers\Url::remember();
        $searchModel = new TblMainSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('reset_borang_lpp', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionResetBorang($lppid)
    {
        $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        $skt = TblSktTandatangan::findOne(['lpp_id' => $lppid]);
        $skt_ulas = TblSktUlasan::findOne(['lpp_id' => $lppid]);
        $sumb = TblSumbanganTt::findOne((['lpp_id' => $lppid]));
        $ulas = TblUlasan::findOne(['lpp_id' => $lppid]);

        if ($lpp->load(Yii::$app->request->post())) {
            //$model->lpp_id = $this->findLpp($id);
            //            $tahun_lpp->lpp_tahun = date("Y");

            if ($lpp->reset_pyd_sah == 1) {
                $lpp->PYD_sah = 0;
                $lpp->PYD_sah_datetime = null;

                if ($skt) {
                    $skt->skt_tt_pyd = null;
                    $skt->skt_tt_pyd_datetime = null;
                    $skt->save(false);
                }

                if ($skt_ulas) {
                    $skt_ulas->su_tt_pyd_datetime = null;
                    $skt_ulas->skt_ulasan_tt_pyd = null;
                    $skt_ulas->save(false);
                }

                if ($sumb) {
                    $sumb->delete();
                }
            }

            if ($lpp->reset_ppp_sah == 1) {
                $lpp->PPP_sah = 0;
                $lpp->PPP_sah_datetime = null;

                if ($skt) {
                    $skt->skt_tt_ppp = null;
                    $skt->skt_tt_ppp_datetime = null;
                    $skt->save(false);
                }

                if ($skt_ulas) {
                    $skt_ulas->su_tt_ppp_datetime = null;
                    $skt_ulas->skt_ulasan_tt_ppp = null;
                    $skt_ulas->save(false);
                }

                if ($ulas) {
                    $ulas->ulasan_PPP_tt = null;
                    $ulas->ulasan_PPP_tt_datetime = null;
                    $ulas->save(false);
                }
            }

            if ($lpp->reset_ppk_sah == 1) {
                $lpp->PPK_sah = 0;
                $lpp->PPK_sah_datetime = null;

                if ($ulas) {
                    $ulas->ulasan_PPK_tt = null;
                    $ulas->ulasan_PPK_tt_datetime = null;
                    $ulas->save(false);
                }
            }

            if ($lpp->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya direset!']);
                return $this->goBack();
            }
        }

        return $this->renderAjax('reset_borang', ['model' => $lpp, 'skt' => $skt, 'skt_ulas' => $skt_ulas]);
    }

    public function actionBukaPengisianBorang()
    {
        $searchModel = new TblMainSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('buka_borang', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function LoginAsUser($id, $ori)
    {
        $initialId =  Yii::$app->user->identity->ICNO; //here is the current ID, so you can go back after that.
        if ($id == $initialId) {
            //Same user!
        } else {
            //            $user = TblMain::find(['ICNO' => $id])->one();
            //            $user = TblMain::findOne(['lpp_id' => $lppid]);
            $user =  \app\models\User::findIdentity($id);
            Yii::$app->user->setIdentity($user); //Change the current user.
            Yii::$app->session->set('user.penilai', $user);
            //            Yii::$app->session->set('user.admin',$initialId);
            //            Yii::$app->session->set('user.idbeforeswitch',$initialId); //Save in the session the id of your admin user.
            //            return $this->render('index'); //redirect to any page you like.
        }
    }

    //    public function actionBukaBorang($lppid) {
    //        $lpp = TblMain::findOne(['lpp_id' => $lppid]);
    //        
    //        $lpp_log = new TblRequestLog();
    //        
    //        $lpp_log->lpp_id = $lppid;
    //        
    //        $lpp_log->PYD = $lpp->PYD;
    //        
    //        $lpp_log->tahun = $lpp->tahun;
    //        
    //        $lpp_log->request_type = 'pyd';
    //        
    //        if($lpp_log->save(false)) {
    //            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya dibuka!']);
    //            return $this->redirect(Yii::$app->request->referrer);
    //        }
    //    }

    public function actionPadamBorangLpp()
    {
        \yii\helpers\Url::remember();

        $searchModel = new TblMainSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('padam_borang_lpp', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPadamBorang($lppid)
    {
        $lpp = TblMain::findOne(['lpp_id' => $lppid]);

        $data = $lpp->attributes;

        $lpp_del = new TblMainDeleted();
        $lpp_del->setAttributes($data);
        $lpp_del->deleted_by = Yii::$app->user->identity->ICNO;
        $lpp_del->save();

        $lpp->delete();

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang LPP berjaya dibuang!']);
        //        return $this->redirect('pengurusan-tahun-penilaian');
        return $this->refresh();
    }

    public function actionSenaraiPyd()
    {
        $id =  Yii::$app->user->getId();

        $searchModel = new TblMainSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->andWhere(['or', ['hrm.lppums_lpp.PPP' => $id], ['hrm.lppums_lpp.PPK' => $id]])
            ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', 'cuti']]);

        return $this->render('senarai_pyd', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGenerateLpp($tahun)
    {
        $output = '';
        $runner = new ConsoleCommandRunner();
        $runner->run('lppums/mohon-lpp', [$tahun]);
        $output = $runner->getOutput();
        \Yii::$app->session->setFlash('alert', ['title' => 'Message', 'type' => 'info', 'msg' => $output]);
        //return $this->redirect(['semak-lpp', 'lppid' => $lppid, 'bhg_no' => 9]);
        return $this->redirect('pengurusan-tahun-penilaian');
    }

    public function actionPendaftaranPenetapPenilai()
    {
        \yii\helpers\Url::remember();

        $searchModel = new TblPenetapPenilaiSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //        $query = TblPenetapPenilai::find();
        //        
        //        $dataProvider = new ActiveDataProvider([
        //            'query' => $query,
        ////            'sort' => true,
        //            'pagination' => [
        //                'pageSize' => 10,
        //            ],
        //        ]);

        return $this->render('daftar_penetap', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTambahPenetapPenilai()
    {
        $penetap = new TblPenetapPenilai();

        if ($penetap->load(Yii::$app->request->post())) {

            $bio = Tblprcobiodata::findOne(['ICNO' => $penetap->penetap_icno]);

            $penetap->penetap_gred = $bio->gredJawatan;

            $penetap->penetap_jfpiu = $bio->DeptId;

            if ($penetap->save(false)) {

                $url = ['lppums/penetap-pegawai-penilai', 'icno' => $penetap->penetap_icno];

                $ntf = new Notification();
                $ntf->icno = $penetap->penetap_icno;
                $ntf->title = 'Penetap Penilai Borang LNPT (Pentadbiran)';
                $ntf->content = "Anda dilantik sebagai Penetap Penilai dalam Sistem LNPT Pentadbiran. Setelah berbincang dengan Ketua Jabatan, mohon pihak tuan/puan membuat penetapan PPP dan PPK untuk semua kakitangan di Jabatan tuan/puan melalui " . Html::a('pautan ini', $url, []) . ".";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();

                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat penetap berjaya ditambah!']);
                return $this->redirect('pendaftaran-penetap-penilai');
            }
        }

        return $this->renderAjax('set_penetap', ['model' => $penetap]);
    }

    public function actionKemaskiniPenetapPenilai($id)
    {
        if (($penetap = TblPenetapPenilai::findOne(['id' => $id])) != null) {
            $penetap = TblPenetapPenilai::findOne(['id' => $id]);
            //$penetap->jabatan = $dept_id;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($penetap->load(Yii::$app->request->post())) {

            $bio = Tblprcobiodata::findOne(['ICNO' => $penetap->penetap_icno]);

            $penetap->penetap_gred = $bio->gredJawatan;

            $penetap->penetap_jfpiu = $bio->DeptId;

            if ($penetap->save(false)) {

                //                $url = ['elnpt/penetap-penilai'];
                //                
                //                $ntf = new Notification();
                //                $ntf->icno = $penetap->penetap_icno;
                //                $ntf->title = 'Penetap Penilai Borang eLNPT';
                //                $ntf->content = "Anda dilantik sebagai Penetap Penilai dalam Sistem LNPT Akademik. Setelah berbincang dengan Ketua Jabatan, mohon pihak tuan/puan membuat penetapan PPP, PPK dan PEER untuk semua kakitangan di Jabatan tuan/puan melalui ".Html::a('pautan ini', $url, []).".";
                //                $ntf->ntf_dt = date('Y-m-d H:i:s');
                //                $ntf->save();

                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat penetap berjaya dikemaskini!']);
                return $this->redirect('pendaftaran-penetap-penilai');
            }
        }

        return $this->renderAjax('set_penetap', ['model' => $penetap]);
    }

    public function actionRemovePenetapPenilai($id)
    {
        $penetap = TblPenetapPenilai::findOne($id);

        if ($penetap->delete()) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat penetap berjaya dibuang!']);
            return $this->goBack();
        }
    }

    public function actionPenetapPegawaiPenilai()
    {
        \yii\helpers\Url::remember();

        $listYear = TblPenetapPenilai::find()->where(['penetap_icno' => Yii::$app->user->identity->ICNO])->asArray()->all();

        $searchModel = new TblMainSearchPenetap();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->andWhere(['jspiu' => ArrayHelper::getColumn($listYear, 'penetap_jfpiu'), 'tahun' => ArrayHelper::getColumn($listYear, 'tahun')])->orderBy(['tahun' => 'SORT_DESC']);

        return $this->render('penetap_pegawai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPantauPergerakanBorang()
    {
        $searchModel = new TblMainSearch2();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //        $dataProvider->query->andWhere('elnpt.tbl_main.is_deleted = 0');

        return $this->render('pantau_gerak', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPenetapPantauPergerakanBorang()
    {
        $searchModel = new TblMainSearch2();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $penetap = TblPenetapPenilai::find()
            ->leftJoin(['a' => 'hrm.lppums_lpp_tahun'], 'a.lpp_tahun = hrm.lppums_tbl_penetap_penilai.tahun AND a.lpp_aktif = \'Y\'')
            ->where(['hrm.lppums_tbl_penetap_penilai.penetap_icno' => Yii::$app->user->identity->ICNO])
            ->asArray()
            ->all();

        $arr = end($penetap);

        $dataProvider->query->andWhere(['jspiu' => $arr['penetap_jfpiu']]);

        //        $dataProvider->query->andWhere('elnpt.tbl_main.is_deleted = 0');

        return $this->render('pantau_gerak', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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

            $url = ['lppums/bahagian1', 'lpp_id' => $lpp->lpp_id];

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
                $ntf->content = "Sila buat pengesahan borang LNPT untuk " . $lpp->pyd->CONm;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            }
            if ($lpp->PPK_sah != 1 and $lpp->PPK != NULL) {
                $ntf = new Notification();
                $ntf->icno = $lpp->PPK;
                $ntf->title = 'Pengesahan borang LNPT';
                $ntf->content = "Sila buat pengesahan borang LNPT untuk " . $lpp->pyd->CONm;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            }
            //            if($lpp->PEER_sah != 1 and $lpp->PEER != NULL) {
            //                $ntf = new Notification();
            //                $ntf->icno = $lpp->PEER;
            //                $ntf->title = 'Pengesahan borang eLNPT';
            //                $ntf->content = "Klik ".Html::a('sini', $url, [])." untuk membuat pengesahan borang elnpt.";
            //                $ntf->ntf_dt = date('Y-m-d H:i:s');
            //                $ntf->save();
            //            }

            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Peringatan berjaya dihantar!']);
            //            return $this->refresh();
            return 1;
        }
        return 0;
        //        return $this->refresh();

    }

    public function actionDashboard()
    {

        //        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);

        //        $lpp = TblMain::find()->where(['tahun' => $tahun->lpp_tahun]);

        return $this->render('dashboard', [
            //            'lpp' => $lpp,
        ]);
    }

    public function actionBukaBorangLpp()
    {
        \yii\helpers\Url::remember();
        $searchModel = new TblRequestSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('buka_borang_lpp', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBukaBorang()
    {
        $req = new TblRequest();

        if ($req->load(Yii::$app->request->post())) {

            if ($req->save()) {
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

            if ($req->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya dibuka!']);
                return $this->goBack();
            }
        }

        return $this->renderAjax('buka_borangg', ['model' => $req]);
    }

    public function actionPadamBukaBorang($id)
    {
        $req = TblRequest::findOne(['id' => $id]);
        $req->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya dipadam!']);
        return $this->goBack();
    }

    public function actionGenerateReport()
    {
        //        \yii\helpers\Url::remember();
        $searchModel = new TblMainSearch2();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //        $dataProvider->query->andWhere('elnpt.tbl_main.is_deleted = 0');

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
            $runner->run('task-queue/jana-lppums-report', [
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

    public function actionMarkahBorang()
    {
        $searchModel = new TblMainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //        $dataProvider->query->andWhere(['elnpt.tbl_main.is_deleted' => 0]);

        return $this->render('mrkh_borang', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPenetapMarkahBorang()
    {
        \yii\helpers\Url::remember();

        $maxYear = TblLppTahun::find()
            //->select(new \yii\db\Expression('MAX(lpp_tahun) as lpp_tahun'))
            ->max('lpp_tahun');

        $lppYear = TblLppTahun::find()
            //->select(new \yii\db\Expression('*'))
            ->where(['lpp_tahun' => $maxYear]);

        $penetap = TblPenetapPenilai::find()
            ->rightJoin(['a' => $lppYear], 'a.lpp_tahun = hrm.lppums_tbl_penetap_penilai.tahun AND a.lpp_aktif = \'Y\'')
            ->where(['hrm.lppums_tbl_penetap_penilai.penetap_icno' => Yii::$app->user->identity->ICNO])
            ->one();

        $searchModel = new TblMainSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->andWhere(['jspiu' => $penetap->penetap_jfpiu, 'tahun' => range(($penetap->tahun - 3), $penetap->tahun)]);

        return $this->render('penetap_mrkh_brg', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraiCutiBelajar()
    {
        $searchModel = new TblMainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->andWhere(['<>', 'COALESCE (hrm.lppums_lpp.catatan, \'\')', '']);

        return $this->render('cuti_belajar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPengesahanMarkahBorang()
    {
        $searchModel = new TblMainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //$dataProvider->query->andWhere(['elnpt.tbl_main.is_deleted' => 0]);

        return $this->render('pengesahan_mrkh_borang', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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

            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Semakan markah berjaya direset!']);
            //            return $this->refresh();
            return 1;
        }
        return 0;
        //        return $this->refresh();
    }

    public function actionNameList($page, $q = null, $id = null)
    {
        $limit = 5;
        $offset = ($page - 1) * $limit;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new \yii\db\Query();
            $query->select('ICNO as id, CONm AS text')
                ->from('hronline.tblprcobiodata')
                ->where(['like', 'CONm', $q])
                ->offset($offset)
                ->limit($limit);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
            $out['pagination'] = ['more' => !empty($data) ? true : false];
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Tblprcobiodata::find($id)->CONm];
        }
        return $out;
    }

    public function actionPengurusanCadanganApc()
    {
        \yii\helpers\Url::remember();
        $searchModel = new TblMainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->orderBy(['`m`.`average_mark`' => SORT_DESC]);

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
                // return $this->refresh();
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
        $dataProvider->query->orderBy(['`m`.`average_mark`' => SORT_DESC]);

        $q = $dataProvider->query->createCommand()->getRawSql();

        $tbl_query = new \app\models\system_core\TblQueries();
        $tbl_query->query = $q;
        $tbl_query->module = Yii::$app->controller->id;
        $tbl_query->created_by = Yii::$app->user->identity->ICNO;
        $tbl_query->created_dt = new \yii\db\Expression('NOW()');
        $tbl_query->save(false);

        $runner = new \tebazil\runner\ConsoleCommandRunner();
        $runner->run('task-queue/jana-apc-lppums', [$tbl_query->query, $tahun, Yii::$app->user->identity->ICNO]);

        \Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'warning', 'msg' => 'Laporan sedang dijana. Sila tunggu']);
        // return $this->refresh();
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionGenerateBorang($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        if ($lpp->tahun >= 2022) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
        }

        $skt = TblSkt::find()->where(['lpp_id' => $lpp_id])->andWhere(['skt_status' => null]);

        $sktProvider = new ActiveDataProvider([
            'query' => $skt,
            'pagination' => false,
            'sort' => false,
        ]);

        $skt_tamb = TblSkt::find()->where(['lpp_id' => $lpp_id, 'skt_status' => 'TAMB']);

        $skt_gugur = TblSkt::find()->where(['lpp_id' => $lpp_id, 'skt_status_gugur' => 'GUGUR']);

        $skt = TblSkt::find()->where(['lpp_id' => $lpp_id])
            ->andWhere(['is', 'skt_status', null])
            ->andWhere(['is', 'skt_status_gugur', null]);

        $skt2Provider = new ActiveDataProvider([
            'query' => $skt_tamb,
            'pagination' => false,
            'sort' => false,
        ]);

        $skt2Provider1 = new ActiveDataProvider([
            'query' => $skt_gugur,
            'pagination' => false,
            'sort' => false,
        ]);

        $skt2Provider2 = new ActiveDataProvider([
            'query' => $skt,
            'pagination' => false,
            'sort' => false,
        ]);

        $latih_tmbh = TblCpdLatihan::find()
            ->where(['vcl_id_staf' => $lpp->PYD, 'YEAR(vcl_tkh_mula)' => $lpp->tahun])
            ->orderBy(['vcl_tkh_mula' => SORT_ASC])
            ->all();

        $latih = TblLatihanTambah::find()->where(['lpp_id' => $lpp_id]);

        $latih_perlu = TblLatihanPerlu::find()->where(['lpp_id' => $lpp_id]);

        $dataProvider1 = new ActiveDataProvider([
            'query' => TblSumbangan::find()->where(['lpp_id' => $lpp_id]),
            'pagination' => false,
            'sort' => false,
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $latih_perlu,
            'pagination' => false,
            'sort' => false,
        ]);

        $dataProvider3 = new ActiveDataProvider([
            'query' => $latih,
            'pagination' => false,
            'sort' => false,
        ]);

        $mataCpd2 = TblMataAkhir::find()
            ->where(['icno' => $lpp->PYD])
            ->one();

        if ($lpp->tahun >= 2020) {
            $latih_tmbh = SiriLatihan::find()
                ->joinWith('sasaran5.sasaran55')
                ->where(['idp_kehadiran.staffID' => $lpp->PYD, 'YEAR(idp_kehadiran.tarikhMasa)' => $lpp->tahun])
                ->all();
            $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $lpp->gredJawatan->gred])->one();
            $cpdgroup = $modelcpdgroupgj->cpdgroup;
            $mataCpd = \app\models\myidp\RptStatistikIdp::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
            // $summ = Kehadiran::calculateMataTotal('4', $lpp->PYD)  + Kehadiran::calculateMataTotal('5', $lpp->PYD) + Kehadiran::calculateMataTotal('6', $lpp->PYD);
            // $summm = RptStatistikIdpV2::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
            $summm = \app\models\myidp\RptStatistikIdp::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
            $summ = $summm->jum_mata_dikira;
        } else {
            $latih_tmbh = TblCpdLatihan::find()
                ->where(['vcl_id_staf' => $lpp->PYD, 'YEAR(vcl_tkh_mula)' => $lpp->tahun])
                ->orderBy(['vcl_tkh_mula' => SORT_ASC])
                ->all();
            $mataCpd = TblStatistikIdp::find()->where(['tahun' => $lpp->tahun, 'icno' => $lpp->PYD])->one();
            $summ = null;
        }

        $mrkhBhg = RefMarkahBahagian::find()->where(['kump_khidmat' => $lpp->gredJawatan->job_group, 'bahagian_id' => 1])->one();

        $query = TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $lpp_id, 'bahagian_id' => 1])
            ->indexBy('bhk_id')
            ->all();

        $kriteria = TblBahagianKriteria::find()
            ->select(['hrm.lppums_bahagian_has_kriteria.*', 'hrm.lppums_kriteria.*'])
            ->joinWith('kriteria')
            ->where(['bahagian_id' => 1, 'kump_khidmat' => $lpp->gredJawatan->job_group]);

        $jumlah = ArrayHelper::toArray($query, [
            'app\models\lppums\TblLppMarkah' => [
                'markah_PPP',
                'markah_PPK',
            ],
        ]);

        $skt_ulasan = TblSktUlasan::find()->where(['lpp_id' => $lpp_id])->one();

        $senarai = TblSenaraiTugas::find()->where(['lpp_id' => $lpp_id]);

        $senaraiProvider = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => false,
            'sort' => false,
        ]);

        $content = $this->renderPartial('_borangView', [
            'lpp' => $lpp,
            'modelskt' => $skt_ulasan,
            'skt2Provider' => $skt2Provider,
            'senaraiProvider' => $senaraiProvider,
            'skt2Provider1' => $skt2Provider1,
            'skt2Provider2' => $skt2Provider2,
            'dataProvider1' => $dataProvider1,
            'sktProvider' => $sktProvider,
            'latih_tmbh' => $latih_tmbh,
            'dataProvider2' => $dataProvider2,
            'dataProvider3' => $dataProvider3,
            'mataCpd2' => $mataCpd2,
            'summ' => $summ,
            'mataCpd' => $mataCpd,
            'lpp_mrkh' => $query,
            'kriteria' => $kriteria->asArray()->all(),
            'jumlah' => $jumlah,
            'mrkhBhg' => $mrkhBhg,
            'lpp_mrkh2' => $this->_getQuery($lpp, 2),
            'kriteria2' => $this->_getKriteria($lpp, 2),
            'jumlah2' => $this->_getJumlah($lpp, 2),
            'mrkhBhg2' => $this->_getMrkhBhg($lpp, 2),
            'lpp_mrkh3' => $this->_getQuery($lpp, 3),
            'kriteria3' => $this->_getKriteria($lpp, 3),
            'jumlah3' => $this->_getJumlah($lpp, 3),
            'mrkhBhg3' => $this->_getMrkhBhg($lpp, 3),
            'lpp_mrkh4' => $this->_getQuery($lpp, 4),
            'kriteria4' => $this->_getKriteria($lpp, 4),
            'jumlah4' => $this->_getJumlah($lpp, 4),
            'mrkhBhg4' => $this->_getMrkhBhg($lpp, 4),
            'model' => TblMarkahKeseluruhan::find()->where(['lpp_id' => $lpp_id])->one(),
            'model1' => TblUlasan::find()->where(['lpp_id' => $lpp_id])->one(),
            'model2' => TblMarkahKeseluruhan::find()->where(['lpp_id' => $lpp_id])->one()
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'borang_lnpt_pentadbiran_' . $lpp_id,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' =>  [
                'title' => 'Borang LNPT',
                // 'subject' => 'PDF Document Subject',
                'keywords' => 'krajee, grid, export, yii2-grid, pdf'
            ],
            // call mPDF methods on the fly
            'methods' => [
                // 'SetHeader'=>['Krajee Report Header'], 
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    protected function _getQuery($lpp, $bhg)
    {
        return TblLppMarkah::find()
            ->leftJoin('`hrm`.`lppums_bahagian_has_kriteria`', '`hrm`.`lppums_bahagian_has_kriteria`.`bhk_id` = `hrm`.`lppums_lpp_markah`.`bhk_id`')
            ->where(['lpp_id' => $lpp->lpp_id, 'bahagian_id' => $bhg, 'kump_khidmat' => $lpp->gredJawatan->job_group])
            ->indexBy('bhk_id')
            ->all();
    }

    protected function _getKriteria($lpp, $bhg)
    {
        return TblBahagianKriteria::find()
            ->select(['hrm.lppums_bahagian_has_kriteria.*', 'hrm.lppums_kriteria.*'])
            ->joinWith('kriteria')
            ->where(['bahagian_id' => $bhg, 'kump_khidmat' => $lpp->gredJawatan->job_group])->asArray()->all();
    }

    protected function _getJumlah($lpp, $bhg)
    {
        $query = $this->_getQuery($lpp, $bhg);
        return ArrayHelper::toArray($query, [
            'app\models\lppums\TblLppMarkah' => [
                'markah_PPP',
                'markah_PPK',
            ],
        ]);
    }

    protected function _getMrkhBhg($lpp, $bhg)
    {
        return RefMarkahBahagian::find()->where(['kump_khidmat' => $lpp->gredJawatan->job_group, 'bahagian_id' => $bhg])->one();
    }

    public function actionStaffColorList($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        return $this->renderAjax('_colorList', [
            'lpp' => $lpp,
        ]);
    }

    public function actionStaffIdpList($lpp_id)
    {
        $lpp = $this->findLpp($lpp_id);

        $mataCpd = \app\models\myidp\RptStatistikIdp::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
        // $summ = Kehadiran::calculateMataTotal('4', $lpp->PYD)  + Kehadiran::calculateMataTotal('5', $lpp->PYD) + Kehadiran::calculateMataTotal('6', $lpp->PYD);
        // $summm = RptStatistikIdpV2::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
        $summm = \app\models\myidp\RptStatistikIdp::find()->where(['icno' => $lpp->PYD, 'tahun' => $lpp->tahun])->one();
        $summ = $summm->jum_mata_dikira;

        $aktiviti = SiriLatihan::find()
            ->joinWith('sasaran5.sasaran55')
            ->where(['idp_kehadiran.staffID' => $lpp->pyd->ICNO])
            ->andWhere(['idp_kehadiran.kategoriKursusID' => [5, 6, 4, 1]])
            ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $lpp->tahun]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $aktiviti,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => ['tarikhMula' => SORT_ASC],
            ],
        ]);

        return $this->renderAjax('_idpList', [
            'lpp' => $lpp,
            'aktiviti' => $aktiviti,
            'dataProvider2' => $dataProvider2,
            'summ' => $summ,
            'mataCpd' => $mataCpd,
        ]);
    }

    public function actionKetakakuranStaf()
    {
        $searchModel = new \app\models\lppums\v2\TblKetakakuranStaffSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $dataProvider = new ActiveDataProvider([
        //     'query' => TblKetakakuranStaff::find(),
        //     'pagination' => [
        //         'pageSize' => 15,
        //     ],
        //     'sort' => false,
        // ]);

        return $this->render('//lppums/v2/ketakakuran', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTambahKetakakuranStaf()
    {
        $model = new TblKetakakuranStaff();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');

            $model->file = UploadedFile::getInstance($model, 'file');
            // $tmp = $doc->filehash;
            if ($model->file) {
                $file = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'LNPT/Pentadbiran/ketakakuran/');
                if ($file->status == true) {
                    $model->filehash = $file->file_name_hashcode;
                    $model->file_name = $model->file->name;
                    $model->created_dt = new \yii\db\Expression('NOW()');
                    $model->created_by = Yii::$app->user->identity->ICNO;

                    if ($model->validate() && $model->save()) {
                        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya ditambah!']);
                        return $this->redirect('ketakakuran-staf');
                    }
                }
            }
        }

        return $this->renderAjax('//lppums/v2/_ketakakuran', ['model' => $model]);
    }

    public function actionKemaskiniKetakakuranStaf($id)
    {
        $model = TblKetakakuranStaff::findOne(['id' => $id]);

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            // $tmp = $doc->filehash;
            if (!empty($model->file)) {
                Yii::$app->FileManager->DeleteFile($model->filehash);
                $file = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'LNPT/Pentadbiran/ketakakuran/');
                if ($file->status == true) {
                    $model->filehash = $file->file_name_hashcode;
                    $model->file_name = $model->file->name;
                    $model->created_dt = new \yii\db\Expression('NOW()');

                    if ($model->validate() && $model->save()) {
                        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikemaskini!']);
                        return $this->redirect('ketakakuran-staf');
                    }
                }
            }
        }

        return $this->renderAjax('//lppums/v2/_ketakakuran', ['model' => $model]);
    }

    public function actionPadamKetakakuranStaf($id)
    {
        $model = TblKetakakuranStaff::findOne(['id' => $id]);

        Yii::$app->FileManager->DeleteFile($model->filehash);
        $model->delete();

        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);

        return $this->redirect('ketakakuran-staf');
    }
}
