<?php

namespace app\controllers;

use app\models\elnpt\elnpt2\RefAspekPemberat;
use app\models\elnpt\elnpt2\RefAspekPenilaian;
use app\models\elnpt\elnpt2\RefAspekPeratus;
use app\models\elnpt\elnpt2\RefAspekSkor;
use app\models\elnpt\elnpt2\RefSkorF2f;
use app\models\elnpt\elnpt2\RefSkorPenyeliaan;
use app\models\elnpt\elnpt2\RefGred;
use app\models\elnpt\elnpt2\TblKumpDept;
use app\models\elnpt\elnpt2\RefPemberatSeluruh;
use app\models\elnpt\elnpt2\TblPersidangan;
use app\models\elnpt\elnpt2\TblTeknologiInovasi;
use app\models\elnpt\elnpt2\TblPnP;
use app\models\elnpt\elnpt2\PenilaianKursusPK07;
use app\models\elnpt\TblPengajaran;
use app\models\elnpt\elnpt2\Tblrscoadminpost;
use yii\data\ArrayDataProvider;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\base\UserException;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use app\models\elnpt\elnpt2\Model;
use yii\base\Exception;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use app\models\elnpt\TblRequest;
use app\models\elnpt\elnpt2\RefBahagian;
use app\models\elnpt\elnpt2\TblKilanan;
use app\models\elnpt\TblMain;
use app\models\elnpt\TblAlasanSemakan;
use app\models\elnpt\TblMrkhBhg;
use app\models\elnpt\RefPeratusKategori;
use app\models\elnpt\TblMarkahKeseluruhan;
use app\models\elnpt\TblLppTahun;
use app\models\elnpt\elnpt2\TblPengajaranPembelajaran;
use app\models\elnpt\TblMrkhAspek;
use app\models\elnpt\elnpt2\TblPenyeliaanManual;
use app\models\elnpt\elnpt2\TblPenyeliaan;
use app\models\elnpt\perkhidmatan_klinikal\TblKlinikal;
use app\models\elnpt\TblPenyelidikan2;
use app\models\elnpt\TblPenyelidikanManual;
use app\models\elnpt\TblGrantApplication;
use app\models\elnpt\TblException;
use app\models\elnpt\elnpt2\TblException2;
use app\models\elnpt\penerbitan\TblLnptPublicationV2;
use app\models\elnpt\TblConference;
use app\models\elnpt\inovasi\TblPertandinganPereka;
use app\models\elnpt\inovasi\TblInovasi;
use app\models\elnpt\outreaching\TblOutreachingManual;
use app\models\elnpt\outreaching\TblConsultation;
use app\models\elnpt\perkhidmatan_klinikal\TblConsultationClinical;
use app\models\elnpt\TblConsultancy;
use app\models\elnpt\bahagian_7\TblPengurusanPentadbiran;
use app\models\elnpt\bahagian_9\TblMarkahKualiti;
use app\models\elnpt\elnpt2\PenilaianKursusPK07_FPSK;
use app\models\elnpt\elnpt2\TblDocuments;
use app\models\elnpt\elnpt2\TblSmartV3;
use app\models\elnpt\testing\TblTestingAccess;
use app\models\elnpt\TblBlendedLearningFarm;
use app\models\elnpt\TblLnptClinical;
use app\models\Notification;
use yii\web\UploadedFile;
use kartik\mpdf\Pdf;

error_reporting(0);
class Elnpt2Controller extends \yii\web\Controller
{
    public function init()
    {
        parent::init();
        $this->viewPath = '@app/views/elnpt/elnpt2';
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'rujukan-panduan'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblMain::find()
                                ->where(['PYD' => Yii::$app->user->identity->ICNO, 'tahun' => 2020])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                                ->exists();
                            $query1 = TblTestingAccess::find()
                                ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])
                                ->exists();
                            if (($query) or $query1) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'calculator-lnpt', 'calculation', 'assign-inputs',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query1 = TblTestingAccess::find()
                                ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => [1, 2, 3]])
                                ->exists();

                            $query2 = TblMain::find()->where(['PYD' => Yii::$app->user->identity->ICNO])->exists();
                            if ($query1 || $query2) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'maklumat-guru', 'generate-borang',
                            'view-file',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // $query = TblMain::find()
                            //     ->where(['lpp_id' => Yii::$app->request->get('lppid')])
                            //     ->andWhere(['PYD' => Yii::$app->user->identity->ICNO])
                            //     //->andWhere(['=', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', ''])
                            //     ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                            //     ->andWhere(['>=', 'tahun', 2020])
                            //     ->exists();
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
                                    'or',
                                    ['PYD' => Yii::$app->user->identity->ICNO],
                                    ['PPP' => Yii::$app->user->identity->ICNO],
                                    ['PPK' => Yii::$app->user->identity->ICNO],
                                    ['PEER' => Yii::$app->user->identity->ICNO]
                                ])
                                //->andWhere(['=', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', ''])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                                ->andWhere(['>=', 'tahun', 2020])
                                ->exists();
                            $query1 = TblTestingAccess::find()
                                ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => [1, 2, 3]]);
                            if (Yii::$app->user->identity->ICNO == 810209105562) {
                                if (TblMain::findOne(['lpp_id' => Yii::$app->request->get('lppid'), 'jfpiu' => Yii::$app->user->identity->DeptId]))
                                    $query1->andwhere(['<=', 'CURDATE()', '2022-02-15']);
                                else
                                    $query1->andwhere(['=', 1, 0]);
                            }
                            $query1 = $query1->exists();
                            if (($query) or $query1) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'maklumat-guru',
                            'bahagian1', 'bahagian2', 'bahagian3', 'bahagian4', 'bahagian5', 'bahagian6', 'bahagian7', 'bahagian8',
                            'bahagian9', 'bahagian10', 'bahagian11',
                            // 'create-pnp', 'update-pnp', 'delete-pnp',
                            // 'create-penyelidikan', 'update-penyelidikan', 'delete-penyelidikan',
                            // 'create-outreaching', 'update-outreaching', 'delete-outreaching',
                            // 'create-urus-tadbir', 'update-urus-tadbir', 'delete-urus-tadbir',
                            // 'create-persidangan', 'update-persidangan', 'delete-persidangan',
                            // 'create-inovasi', 'update-inovasi', 'delete-inovasi',
                            'ringkasan',
                            'pengesahan-borang', 'pengesahan-pyd',
                            'perkhidmatan-tahun',
                            // 'pengesahan-markah', 'markah-setuju', 'mohon-semak', 'markah-tidak-setuju',
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
                                //->andWhere(['=', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', ''])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                                ->andWhere(['>=', 'tahun', 2020])
                                ->exists();
                            // $tester = TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 99])->exists();
                            if ($query) {
                                return true;
                            } else {
                                // throw new ForbiddenHttpException('You don\'t have permission to view this page. - Only for TESTERS');
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'pengesahan-markah', 'markah-setuju', 'mohon-semak', 'markah-tidak-setuju',
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
                                //->andWhere(['=', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', ''])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                                ->andWhere(['>=', 'tahun', 2021])
                                ->exists();
                            // $tester = TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 99])->exists();
                            if ($query && (date("Y/m/d") <= '2022/05/31') or $this->checkRequest(Yii::$app->request->get('lppid'))) {
                                return true;
                            } else {
                                // throw new ForbiddenHttpException('You don\'t have permission to view this page. - Only for TESTERS');
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            // 'maklumat-guru',
                            // 'bahagian1', 'bahagian2', 'bahagian3', 'bahagian4', 'bahagian5', 'bahagian6', 'bahagian7', 'bahagian8',
                            // 'bahagian9', 'bahagian10', 'bahagian11',CreatePenyeliaan
                            'create-pnp', 'update-pnp', 'delete-pnp',
                            'create-penyeliaan', 'update-penyeliaan', 'delete-penyeliaan',
                            'create-penyelidikan', 'update-penyelidikan', 'delete-penyelidikan',
                            'create-outreaching', 'update-outreaching', 'delete-outreaching',
                            'create-urus-tadbir', 'update-urus-tadbir', 'delete-urus-tadbir',
                            'create-persidangan', 'update-persidangan', 'delete-persidangan',
                            'create-inovasi', 'update-inovasi', 'delete-inovasi',
                            'tambah-sebab-cadangan', 'edit-sebab-cadangan', 'padam-sebab-cadangan',
                            // 'ringkasan',
                            // 'pengesahan-borang', 'pengesahan-pyd'
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
                                //->andWhere(['=', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', ''])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                                ->andWhere(['>=', 'tahun', 2020])
                                ->exists();
                            // $tester = TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 99])->exists();
                            $lpp = TblMain::findOne(['lpp_id' => Yii::$app->request->get('lppid')]);
                            if ($query && (!$this->checkEligible($lpp))) {
                                // $tahun = TblLppTahun::find()->where(['lpp_aktif' => 'Y', 'lpp_tahun' => 2020])->one();
                                // if ($query && (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)) {
                                return true;
                            } else {
                                // throw new ForbiddenHttpException('You don\'t have permission to view this page. - Only for TESTERS');
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'semak-lpp', 'pengesahan-peer', 'pengesahan-borang-penilai', 'pengesahan-ppp', 'pengesahan-ppk',
                            // , 'tendang-pyd', 'tendang-ppp'
                            'semak-perkhidmatan-tahun',
                        ],
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
                                    'or', ['PPP' => Yii::$app->user->identity->ICNO], ['PPK' => Yii::$app->user->identity->ICNO], ['PEER' => Yii::$app->user->identity->ICNO]
                                ])
                                //->andWhere(['=', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', ''])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                                ->exists();
                            $query1 = TblTestingAccess::find()
                                ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => [1, 2, 3]]);
                            if (Yii::$app->user->identity->ICNO == 810209105562) {
                                if (TblMain::findOne(['lpp_id' => Yii::$app->request->get('lppid'), 'jfpiu' => Yii::$app->user->identity->DeptId]))
                                    $query1->andwhere(['<=', 'CURDATE()', '2022-02-15']);
                                else
                                    $query1->andwhere(['=', 1, 0]);
                            }
                            $query1 = $query1->exists();
                            if (($query) or $query1) {
                                return true;
                                // throw new ForbiddenHttpException('Penilaian PPP / PPK / PEER ditutup untuk sementara waktu.');
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'verify-document',
                            // , 'tendang-pyd', 'tendang-ppp'
                        ],
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
                                ->andWhere(
                                    ['PPP' => Yii::$app->user->identity->ICNO]
                                )
                                //->andWhere(['=', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', ''])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                                ->exists();
                            $query1 = TblTestingAccess::find()
                                ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])
                                ->exists();
                            // if (($query) or $query1) {
                            $lpp = TblMain::findOne(['lpp_id' => Yii::$app->request->get('lppid')]);
                            if (($query or $query1) && (!$this->checkEligible($lpp))) {
                                return true;
                                // throw new ForbiddenHttpException('Penilaian PPP / PPK / PEER ditutup untuk sementara waktu.');
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'semak-ringkasan'
                            // , 'tendang-pyd', 'tendang-ppp'
                        ],
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
                                    'or', ['PPP' => Yii::$app->user->identity->ICNO], ['PPK' => Yii::$app->user->identity->ICNO]
                                ])
                                //->andWhere(['=', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', ''])
                                ->andWhere(['or', ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'tidak'], ['NOT LIKE', 'COALESCE (hrm.elnpt_tbl_main.catatan, \'\')', 'cuti']])
                                ->exists();
                            $query1 = TblTestingAccess::find()
                                ->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => [1, 2, 3]]);
                            if (Yii::$app->user->identity->ICNO == 810209105562) {
                                if (TblMain::findOne(['lpp_id' => Yii::$app->request->get('lppid'), 'jfpiu' => Yii::$app->user->identity->DeptId]))
                                    $query1->andwhere(['<=', 'CURDATE()', '2022-02-15']);
                                else
                                    $query1->andwhere(['=', 1, 0]);
                            }
                            $query1 = $query1->exists();
                            if (($query) or $query1) {
                                return true;
                                // throw new ForbiddenHttpException('Penilaian PPP / PPK / PEER ditutup untuk sementara waktu.');
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'generate-borang-admin'
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
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'calculator-lnpt' => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
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
        return $this->render('//elnpt/elnpt2/mklmt_guru', [
            'lpp' => $lpp,
            'lppid' => $lppid,
            'query' => $query,
            'menu' => $this->menu($lpp),
        ]);
    }

    public function actionBahagian1($lppid)
    {
        $bhg = RefBahagian::findOne(1);
        $lpp = $this->findLpp($lppid);
        $this->checkBahagian($lpp, $bhg->id);
        $url_create = Url::to(['elnpt2/create-pnp', 'lppid' => $lppid]);
        $this->dataBahagian1($lppid, $pengajaran, $pengajaran2, $pnp, $all);

        if (Yii::$app->request->post()) {
            foreach (Yii::$app->request->post('TblPnP') as $key => $value) {
                $settings[$key] = new TblPnP();
                $settings[$key]->attributes = $value;
                $settings[$key]->id_pnp = $key;
                $settings[$key]->lpp_id = $lppid;
                if ($settings[$key]->semester == '') {
                    $settings[$key]->semester = '2-' . ($lpp->tahun - 1) . '/' . $lpp->tahun . '';
                }
            }

            $oldIDs = ArrayHelper::map($pnp, 'id_pnp', 'id_pnp');
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($settings, 'id_pnp', 'id_pnp')));

            $valid =  Model::validateMultiple($settings);
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    foreach ($settings as $wk) {
                        if (!empty($deletedIDs)) {
                            TblPnP::deleteAll(['id_pnp' => $deletedIDs]);
                        }
                        if (($w = TblPnP::find()->where(['id_pnp' => $wk->id_pnp, 'lpp_id' => $lppid])->one()) != null) {
                            $w = TblPnP::find()->where(['id_pnp' => $wk->id_pnp, 'lpp_id' => $lppid])->one();
                            $w->attributes = $wk->attributes;
                            if (!($flag = $w->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        } else {
                            if (!($flag = $wk->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                        return $this->redirect(['elnpt2/bahagian1', 'lppid' => $lppid]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 1])->asArray()->all();
        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 1]);
        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 1])->asArray()->all();
        $f2f = RefSkorF2f::find()->asArray()->all();
        // $my_id = 2;

        $data1 = ArrayHelper::toArray($pnp, [
            // 'app\models\Post' => [
            //     'id',
            //     'title',
            //     // the key name in array result => property name
            //     'createTime' => 'created_at',
            //     // the key name in array result => anonymous function
            //     'length' => function ($post) {
            //         return strlen($post->content);
            //     },
            // ],
        ]);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $all,
            'sort' => [
                'attributes' => ['sumber', 'fullname'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $listt = $pengajaran + $pengajaran2;

        foreach ($data1 as $ind => $p) {
            // $syarahan = 0;
            // $tutorial = 0;
            // $amali = 0;
            foreach (array_reverse($f2f) as $f) {
                if (($p['bil_pelajar'] ?? 0) >= $f['min_pelajar'] && ($p['status_kursus'] ?? '') >= 'HAKIKI') {
                    $syarahan = $f['syarahan'] * ($p['jam_syarahan']);
                    $tutorial = $f['tutorial'] * ($p['jam_tutorial']);
                    $amali = $f['amali'] * ($p['jam_amali']);
                    ArrayHelper::setValue($bks_arry, $ind, ['syarahan' => $syarahan, 'tutorial' => $tutorial, 'amali' => $amali, 'bks' => (($syarahan + $amali + $tutorial) / 14)]);
                    break;
                }
            }
            // ArrayHelper::setValue($bks_arry, $ind, ['syarahan' => $syarahan, 'tutorial' => $tutorial, 'amali' => $amali, 'bks' => ($syarahan + $amali + $tutorial) / 14]);
        }
        foreach ($listt as $ind => $p) {
            foreach ($aspek_skor as $as) {
                if ($as['aspek_id'] == 3) {
                    if (strcasecmp($p['status'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
            foreach (array_reverse($aspek_skor) as $as) {
                if ($as['aspek_id'] == 2) {

                    if ($p['pk07'] >= floatval($as['desc'])) {

                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                        break;
                    }
                }
            }
            foreach (array_reverse($aspek_skor) as $as) {
                if ($as['aspek_id'] == 4) {
                    if (strcasecmp($p['status_fail'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
        }

        $bks = isset($bks_arry) ? array_sum(ArrayHelper::getColumn($bks_arry, 'bks')) : 0;

        ArrayHelper::setValue($tmp, 1, $bks);
        ArrayHelper::setValue($tmp, 2, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['2', 'skor'], $keepKeys = true)) : 0);
        // isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['3', 'skor'], $keepKeys = true)) :
        ArrayHelper::setValue($tmp, 3, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['3', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 4, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['4', 'skor'], $keepKeys = true)) : 0);
        foreach ($tmp as $ind => $t) {
            foreach ($aspek as $a) {
                if ($a->id == $ind) {
                    foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred, 1, $lpp->deptGuru->sub_of ?? $lpp->jfpiu, $lpp->PYD)->all()) as $ap) {
                        if ($t >= $ap['min_skor']) {
                            ArrayHelper::setValue($peratus, $a->id, ['skor' => $t, 'peratus' => $ap['peratus']]);
                            break;
                        }
                    }
                    break;
                }
            }
        }

        foreach ($pemberat as $p) {
            if (empty($peratus[$p['aspek_id']]))
                continue;
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $peratus[$p['aspek_id']]['skor'], 'markah_pyd' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100]);
        }

        $this->setMarkahAspek($lppid, array_key_first($mrkh_bhg), $mrkh_bhg, 1);
        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(1, $lppid), [], false);
        $this->calcOverallMark($lppid);
        // $ppnp = TblPengajaranPembelajaran::find()
        //     ->alias('a')
        //     ->select('b.semester, a.kod_kursus, a.id')
        //     ->innerJoin(['b' => 'hrm.elnpt_v2_tbl_pnp'], 'a.id = b.id_pnp')
        //     ->where(['a.lpp_id' => $lpp->lpp_id])
        //     ->indexBy('id')
        //     ->asArray()
        //     ->all();

        return $this->render('bahagian', [
            'bahagian' => $bhg,
            'url_create' => $url_create,
            'data' => $pengajaran + $pengajaran2,
            'mrkh_bhg' => $mrkhBhg,
            'lppid' => $lppid,
            'input' => $pnp,
            'menu' => $this->menu($lpp),
            'ruberik' => $aspek,
            'gred_no' =>  $lpp->gredGuru->gred,
            'dataProvider' => $dataProvider,
            'lpp' => $lpp,
            'check' => $this->checkEligible($lpp),
        ]);
    }

    public function dataBahagian1($lppid, &$pengajaran, &$pengajaran2, &$pnp, &$all)
    {
        $lpp = $this->findLpp($lppid);
        $semester = [
            // '1-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '' => '1 - ' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '',
            '2-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '' => '2-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '',
            '3-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '' => '3-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '',
            '1-' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '' => '1-' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '',
            // '2-' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '' => '2 - ' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '',
            // '3-' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '' => '3 - ' . ($lpp->tahun) . '/' . ($lpp->tahun + 1) . '',
            // 'Nursing' => [
            //     '1-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '' => '1-' . ($lpp->tahun - 1) . '/' . ($lpp->tahun) . '',
            // ]
        ];
        $pengajaran = TblPengajaranPembelajaran::find()
            ->select(new Expression('a.id as AutoId, \'1\' as manual, \'Fail\' as status, a.*, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt, \'0\' as pk07, c.semester as semester, c.status_fail, c.seksyen as SEKSYEN'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 1')
            ->leftJoin(['c' => 'hrm.elnpt_v2_tbl_pnp'], 'c.id_pnp = a.id and c.lpp_id = a.lpp_id')
            ->where(['a.lpp_id' => $lppid])
            ->orderBy(['id' => SORT_ASC])
            ->indexBy('AutoId')
            ->asArray()
            ->all();
        $pengajaran2 = TblPengajaran::find()
            ->select(new Expression('AutoId, \'0\' as manual, SMP07_KodMP as kod_kursus, NAMAKURSUS as nama_kursus, BILPELAJAR as bil_pelajar, 
            SEKSYEN, SESI as semester, JAMKREDIT, \'0\' as DISPLAY, \'-\' as skop_tugas, 
            \'-\' as status_pengendalian, \'-\' as penglibatan, \'Fail\' as status, \'\' as file_hash, \'SMP UMS\' as ver_by, \'SMP UMS\' as ver_dt, \'0\' as pk07, \'0\' as status_fail'))
            // ->joinWith('pnp pnp')
            ->where(['NOKP' => $lpp->PYD])
            // ->andWhere(['LIKE', 'SESI', $lpp->tahun])
            // ->andWhere(['SESI' => ['1-2020/2021', '3-2019/2020', '2-2019/2020']])
            ->andWhere(['SESI' => array_keys($semester)])
            ->orderBy(['AutoId' => SORT_ASC])
            ->indexBy('AutoId')
            ->asArray()
            ->all();
        $list = $pengajaran + $pengajaran2;

        if (($pnp = TblPnP::find()->where(['lpp_id' => $lpp->lpp_id])->indexBy('id_pnp')->all()) != null) {
            $pnp = TblPnP::find()->where(['lpp_id' => $lpp->lpp_id, 'id_pnp' => ArrayHelper::getColumn($list, 'AutoId')])->indexBy('id_pnp')->all();
        } else {
            $pnp = [new TblPnP()];
            // for ($i = 0; $i < sizeof($list); $i++) {
            //     $pnp = new TblPnP();
            //     $pnp->id_pnp = $list[$i]['AutoId'];
            //     $pnp->lpp_id = $lpp->lpp_id;
            //     $pnp->save(false);
            // }
            $cnt = 0;
            foreach ($list as $ind => $l) {
                $pnp[$cnt] = new TblPnP();
                $pnp[$cnt]->id_pnp = $l['AutoId'];
                $pnp[$cnt]->lpp_id = $lpp->lpp_id;
                $pnp[$cnt]->seksyen = 0;
                $pnp[$cnt]->bil_pelajar = 0;
                $pnp[$cnt]->status_kursus = 'BERBAYAR';
                $pnp[$cnt]->jam_syarahan = 0;
                $pnp[$cnt]->jam_tutorial = 0;
                $pnp[$cnt]->jam_amali = 0;
                $pnp[$cnt]->save(false);
                $cnt++;
            }
            $pnp = TblPnP::find()->where(['lpp_id' => $lpp->lpp_id])->indexBy('id_pnp')->all();
        }
        $data1 = ArrayHelper::toArray($pnp, []);
        foreach ($pengajaran2 as $ind => $p2) {
            foreach ($data1 as $dt1) {
                if ($p2['AutoId'] == $dt1['id_pnp']) {
                    $pengajaran2[$ind]['status_fail'] = $dt1['status_fail'];
                    break;
                }
            }
        }
        $blended = TblBlendedLearningFarm::find()
            ->select(['id', 'username_ic_pasportNo', 'fullname', 'status', new Expression('lastname as name'), new Expression('\'\' as email'), new Expression('\'SmartV2\' as sumber')])
            ->where(['or', ['username_ic_pasportNo' => $lpp->PYD], ['LIKE', 'lastname', $lpp->guru->CONm]])
            ->andWhere(['LIKE', 'fullname', new Expression('\'%' . $lpp->tahun . '%\'')])
            ->andWhere(['NOT LIKE', 'fullname', new Expression('\'%PEPERIKSAAN %\'')])
            ->orderBy(['status' => SORT_ASC])
            ->asArray()
            ->all();
        $smartv33 = TblSmartV3::find()
            ->select(['id', new Expression('\'\' as username_ic_pasportNo'), 'fullname', 'status', 'name', 'email', new Expression('\'SmartV3\' as sumber')])
            ->where(['LIKE', 'name', $lpp->guru->CONm])
            ->orFilterWhere(['LIKE', 'email', $lpp->guru->COEmail])
            ->orFilterWhere(['LIKE', 'email', $lpp->guru->COEmail2])
            ->andWhere(['NOT LIKE', 'fullname', new Expression('\'%PEPERIKSAAN %\'')])
            ->orderBy(['status' => SORT_ASC]);
        $smartv3 = $smartv33->asArray()->all();
        // $all = $blended + $smartv3;
        $all = array_merge($blended, $smartv3);

        // foreach ($blended as $ind => $b) {
        //     $blended[$ind]['kod_subjek'] = explode(' ', trim($b['fullname']))[0];
        //     $sesi = explode(' ', trim($b['fullname']));
        //     rsort($sesi);
        //     $blended[$ind]['sesi'] = str_replace(['[', ']'], '', $sesi[0]);
        // }
        $subjek = ['KK24303', 'KP24303', 'KP24203', 'KP34603', 'KP44403', 'KP34803'];
        foreach ($pengajaran as $ind1 => $p2) {
            // if ($pengajaran[$ind1]['status'] != 'Pass') {
            // $pengajaran[$ind1]['status'] = 'Unavailable';
            // $fullname = $pengajaran[$ind1]['kod_kursus'] . ' ' . $pengajaran[$ind1]['nama_kursus'] . ' [' . $pengajaran[$ind1]['semester'] . ']';
            if (in_array($pengajaran[$ind1]['kod_kursus'], $subjek)) {
                $pengajaran[$ind1]['status'] = 'Pass';
                continue;
            }
            foreach ($all as $b2) {
                // $full = preg_replace('/\([^()]*\)/', '', $b2['fullname']);
                if ((stripos($b2['fullname'], $pengajaran[$ind1]['kod_kursus']) !== false) && (stripos($b2['fullname'], $pengajaran[$ind1]['semester']) !== false)) {

                    if ($b2['status'] == 'Pass') {
                        $pengajaran[$ind1]['status'] = $b2['status'];
                        break;
                    }
                }
            }
            // } else {
            //     $pengajaran[$ind1]['status'] = 'Unavailable';
            // }
        }
        foreach ($pengajaran2 as $ind1 => $p3) {
            // if ($pengajaran2[$ind1]['status'] != 'Pass') {
            // $pengajaran2[$ind1]['status'] = 'Unavailable';
            // $fullname = $pengajaran2[$ind1]['kod_kursus'] . ' ' . $pengajaran2[$ind1]['nama_kursus'] . ' [' . $pengajaran2[$ind1]['semester'] . ']';
            if (in_array($pengajaran2[$ind1]['kod_kursus'], $subjek)) {
                $pengajaran2[$ind1]['status'] = 'Pass';
                continue;
            }
            foreach ($all as $b3) {
                // $full = preg_replace('/\([^()]*\)/', '', $b3['fullname']);
                if ((stripos($b3['fullname'], $pengajaran2[$ind1]['kod_kursus']) !== false) && (stripos($b3['fullname'], $pengajaran2[$ind1]['semester']) !== false)) {

                    if ($b3['status'] == 'Pass') {
                        $pengajaran2[$ind1]['status'] = $b3['status'];
                        break;
                    }
                }
            }
            // }else {
            //     $pen gajaran[$ind1]['status'] = 'Unavailable';
            // }
        }

        // foreach ($pengajaran as $ind1 => $p2) {
        //     if ($pengajaran[$ind1]['status'] != 'Pass') {
        //         // $pengajaran[$ind1]['status'] = 'Unavailable';
        //         // $fullname = $pengajaran[$ind1]['kod_kursus'] . ' ' . $pengajaran[$ind1]['nama_kursus'] . ' [' . $pengajaran[$ind1]['semester'] . ']';
        //         foreach ($blended as $b2) {
        //             // $full = preg_replace('/\([^()]*\)/', '', $b2['fullname']);
        //             if ((stripos($b2['fullname'], $pengajaran[$ind1]['kod_kursus']) !== false) && (stripos($b2['fullname'], $pengajaran[$ind1]['semester']) !== false)) {
        //                 $pengajaran[$ind1]['status'] = $b2['status'];
        //                 break;
        //             } else {
        //                 $pengajaran[$ind1]['status'] = 'Unavailable';
        //             }
        //         }
        //     } else {
        //         continue;
        //     }
        // }
        // foreach ($pengajaran2 as $ind1 => $p3) {
        //     if ($pengajaran2[$ind1]['status'] != 'Pass') {
        //         // $pengajaran2[$ind1]['status'] = 'Unavailable';
        //         // $fullname = $pengajaran2[$ind1]['kod_kursus'] . ' ' . $pengajaran2[$ind1]['nama_kursus'] . ' [' . $pengajaran2[$ind1]['semester'] . ']';
        //         foreach ($blended as $b3) {
        //             // $full = preg_replace('/\([^()]*\)/', '', $b3['fullname']);
        //             if ((stripos($b3['fullname'], $pengajaran2[$ind1]['kod_kursus']) !== false) && (stripos($b3['fullname'], $pengajaran2[$ind1]['semester']) !== false)) {
        //                 $pengajaran2[$ind1]['status'] = $b3['status'];
        //                 break;
        //             } else {
        //                 $pengajaran2[$ind1]['status'] = 'Unavailable';
        //             }
        //         }
        //     } else {
        //         continue;
        //     }
        // }
        $pk07 = PenilaianKursusPK07::find()
            ->select('KodKursus, KodSesi, NoIC, LNPT_Mean as FinalMean, Seksyen')
            ->where(['NoIC' => $lpp->PYD])
            ->asArray()
            ->all();
        $pk07_fpsk = PenilaianKursusPK07_FPSK::find()
            ->select('KodSubjek as KodKursus, SesiSem as KodSesi, NoIC, FinalMean, Seksyen')
            ->where(['NoIC' => $lpp->PYD])
            ->asArray()
            ->all();

        $ppnp = TblPengajaranPembelajaran::find()
            ->alias('a')
            // ->select('b.semester, a.kod_kursus, a.id, b.seksyen')
            ->select(new Expression('\'1-2020/2021\' as semester, a.kod_kursus, a.id, b.seksyen'))
            ->innerJoin(['b' => 'hrm.elnpt_v2_tbl_pnp'], 'a.id = b.id_pnp')
            ->where(['a.lpp_id' => $lpp->lpp_id])
            ->indexBy('id')
            ->asArray()
            ->all();
        $tets = array_merge($pk07, $pk07_fpsk);
        foreach ($pengajaran as $ind1 => $p2) {
            foreach ($tets as $ind2 => $b2) {
                if ((str_replace(' ', '', $p2['semester']) == $b2['KodSesi']) && ($p2['kod_kursus'] == $b2['KodKursus']) && ($p2['SEKSYEN'] == $b2['Seksyen'])) {
                    $pengajaran[$ind1]['pk07'] = $b2['FinalMean'];
                    unset($tets[$ind2]);
                    break;
                } else {
                    $pengajaran[$ind1]['pk07'] = $this->statusPK07($lpp->jfpiu, $lpp->tahun) ? 4.5 : 0;
                }
            }
        }
        //testing
        foreach ($pengajaran2 as $ind1 => $p3) {
            foreach ($tets as $ind2 => $b3) {
                if ((str_replace(' ', '', $p3['semester']) == $b3['KodSesi']) && ($p3['kod_kursus'] == $b3['KodKursus']) && ($p3['SEKSYEN'] == $b3['Seksyen'])) {
                    $pengajaran2[$ind1]['pk07'] = $b3['FinalMean'];
                    unset($tets[$ind2]);
                    break;
                } else {
                    $pengajaran2[$ind1]['pk07'] = $this->statusPK07($lpp->jfpiu, $lpp->tahun) ? 4.5 : 0;
                }
            }
        }
    }

    public function statusPK07($deptId,  $tahun)
    {
        if ($deptId == 138 && $tahun >= 2021) {
            return true;
        }

        return false;
    }

    public function actionCreatePnp($lppid)
    {
        $pnp = new TblPengajaranPembelajaran();
        $tblPnp = new TblPnP();
        $doc = new TblDocuments();
        $lpp = $this->findLpp($lppid);
        if ($pnp->load(Yii::$app->request->post())) {
            $pnp->lpp_id = $lppid;
            $tblPnp->load(Yii::$app->request->post());
            // $pnp->status_fail = (float) Yii::$app->request->post("TblPengajaranPembelajaran")["status_fail"];
            // $pnp->smartv3 = (float) Yii::$app->request->post("TblPengajaranPembelajaran")["smartv3"];
            if ($pnp->validate() && $pnp->save(false)) {
                $tblPnp->id_pnp = $pnp->id;
                $tblPnp->lpp_id = $lppid;
                $tblPnp->save(false);
                $doc->file = UploadedFile::getInstance($doc, 'file');
                // $tmp = $doc->filehash;
                // if ($doc->file) {
                //     $file = Yii::$app->FileManager->UploadFile($doc->file->name, $doc->file->tempName, '04', 'LNPT/Akademik/' . $this->getTahun($lppid) . '/bhg_1');
                //     if ($file->status == true) {
                //         $doc->lpp_id = $lppid;
                //         $doc->bhg_no = 1;
                //         $doc->id_table = $pnp->id;
                //         $doc->filehash = $file->file_name_hashcode;
                //         $doc->file_name = $doc->file->name;
                //         $doc->created_dt = new \yii\db\Expression('NOW()');
                //         $doc->save(false);
                //     }
                // }
                $this->addDocument($doc, $lppid, 1, $pnp->id);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                return $this->redirect(['elnpt2/bahagian1', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('create_bhg1', [
            'pnp' => $pnp,
            'doc' => $doc,
            'tblPnp' => $tblPnp,
            'lpp' => $lpp
        ]);
    }

    public function actionUpdatePnp($id, $lppid)
    {
        $pnp = TblPengajaranPembelajaran::findOne($id);
        $tblPnp = TblPnP::find()->where(['id_pnp' => $id])->one();
        $doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'bhg_no' => '1', 'id_table' => $id])->one();
        $lpp = $this->findLpp($lppid);
        // $pnp->status_fail = (string) $pnp->status_fail;
        // $pnp->smartv3 = (string) $pnp->smartv3;

        if ($pnp->load(Yii::$app->request->post())) {
            $tblPnp->load(Yii::$app->request->post());
            // $pnp->status_fail = (float) Yii::$app->request->post("TblPengajaranPembelajaran")["status_fail"];
            // $pnp->smartv3 = (float) Yii::$app->request->post("TblPengajaranPembelajaran")["smartv3"];

            if ($pnp->validate() && $pnp->save(false)) {
                // Yii::$app->FileManager->DeleteFile($doc->filehash);
                // $doc->file = UploadedFile::getInstance($doc, 'file');
                // // $tmp = $doc->filehash;
                // if ($doc->file) {
                //     $file = Yii::$app->FileManager->UploadFile($doc->file->name, $doc->file->tempName, '04', 'LNPT/Akademik/' . $this->getTahun($lppid) . '/bhg_1');
                //     if ($file->status == true) {
                //         // $doc->lpp_id = $lppid;
                //         // $doc->bhg_no = 1;
                //         // $doc->id_table = $pnp->id;
                //         $doc->filehash = $file->file_name_hashcode;
                //         $doc->file_name = $doc->file->name;
                //         $doc->created_dt = new \yii\db\Expression('NOW()');
                //         $doc->save(false);
                //     }
                // }
                $tblPnp->save(false);
                $this->editDocument($doc, $lppid, 1);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
                return $this->redirect(['elnpt2/bahagian1', 'lppid' => $pnp->lpp_id]);
            }
        }
        return $this->renderAjax('create_bhg1', [
            'pnp' => $pnp,
            'doc' => $doc,
            'tblPnp' => $tblPnp,
            'lpp' => $lpp
        ]);
    }

    public function actionDeletePnp($id, $lppid)
    {
        $pnp = TblPengajaranPembelajaran::findOne($id);
        $tblPnp = TblPnP::find()->where(['id_pnp' => $id, 'lpp_id' => $lppid])->one();
        // $doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'bhg_no' => '1', 'id_table' => $id])->one();
        if (!$pnp) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }
        $pnp->delete();
        $tblPnp->delete();
        // Yii::$app->FileManager->DeleteFile($doc->filehash);
        // $doc->delete();
        $this->delDocument($lppid, 1, $id);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
        return $this->redirect(['elnpt2/bahagian1', 'lppid' => $pnp->lpp_id]);
    }

    public function actionBahagian2($lppid)
    {
        $bhg = RefBahagian::findOne(2);
        $skor = RefSkorPenyeliaan::find()->asArray()->all();
        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 2]);
        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 2])->asArray()->all();
        $mrkh_bhg = array();
        $mrkhbhg = array();
        $peratus = array();
        $url_create = Url::to(['elnpt2/create-penyeliaan', 'lppid' => $lppid]);
        $lpp = $this->findLpp($lppid);
        $this->checkBahagian($lpp, $bhg->id);
        $this->dataBahagian2($lppid, $data, $penyeliaan, $utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
        $tmp = array_merge_recursive($utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
        // $tmp = $utama_belum + $utama_telah_sem + $utama_telah + $sama_belum + $sama_telah_sem + $sama_telah;
        // ArrayHelper::setValue($tmpP, , ['skor' => floatval($as['skor'])]);

        foreach ($tmp as $id => $t) {
            ArrayHelper::setValue($tmpP, [$id, 'utama_belum'], is_array($tmp[$id]['utama_belum']) ? array_sum($tmp[$id]['utama_belum']) : $tmp[$id]['utama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah_sem'], is_array($tmp[$id]['utama_telah_sem']) ? array_sum($tmp[$id]['utama_telah_sem']) : $tmp[$id]['utama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah'], is_array($tmp[$id]['utama_telah']) ? array_sum($tmp[$id]['utama_telah']) : $tmp[$id]['utama_telah']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_belum'], is_array($tmp[$id]['sama_belum']) ? array_sum($tmp[$id]['sama_belum']) : $tmp[$id]['sama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah_sem'], is_array($tmp[$id]['sama_telah_sem']) ? array_sum($tmp[$id]['sama_telah_sem']) : $tmp[$id]['sama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah'], is_array($tmp[$id]['sama_telah']) ? array_sum($tmp[$id]['sama_telah']) : $tmp[$id]['sama_telah']);
        }
        $selia_arry = ArrayHelper::toArray($penyeliaan);

        // if (!empty($selia_arry[0])) {
        //     
        //     $selia_arry = array_filter($selia_arry, function ($var) {
        //         return ($var['verified_by'] != '');
        //     });
        // }

        foreach ($tmpP as $id => $tP) {
            switch ($id) {
                case 'MASTER':
                    $tP['tahap_penyeliaan'] = 2;
                    break;
                case 'PHD':
                    $tP['tahap_penyeliaan'] = 1;
                    break;
                case 'M.Phil.':
                    $tP['tahap_penyeliaan'] = 3;
                    break;
            }
            array_push($selia_arry, $tP);
        }

        foreach ($selia_arry as $sa) {
            foreach ($skor as $s) {
                if (($sa['tahap_penyeliaan'] ?? -1) == $s['id']) {
                    $sum = ($sa['utama_belum'] * $s['belum_utama']) + ($sa['utama_telah_sem'] * $s['telah_utama_sem']) + ($sa['utama_telah'] * $s['telah_utama']) + ($sa['sama_belum'] * $s['belum_sama']) + ($sa['sama_telah_sem'] * $s['telah_sama_sem']) + ($sa['sama_telah'] * $s['telah_sama']);
                    ArrayHelper::setValue($mrkhbhg, $sa['tahap_penyeliaan'], ['skor' => $sum]);
                    break;
                }
            }
        }

        // foreach ($aspek as $a) {
        //     foreach (array_reverse($a->peratus) as $ap) {
        //         if (array_sum(ArrayHelper::getColumn($mrkhbhg, 'skor')) >= $ap['min_skor']) {
        //             ArrayHelper::setValue($peratus, $a->id, ['skor' => array_sum(ArrayHelper::getColumn($mrkhbhg, 'skor')), 'peratus' => ($ap['peratus'] == 0) ? 0 : min(100, $ap['peratus'] + $peratusGred)]);
        //             break;
        //         }
        //     }
        // }
        // foreach ($tmp as $ind => $t) {
        foreach ($aspek as $a) {
            // if ($a->id == $ind) {
            foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred)->all()) as $ap) {
                if (array_sum(ArrayHelper::getColumn($mrkhbhg, 'skor')) >= $ap['min_skor']) {
                    ArrayHelper::setValue($peratus, $a->id, ['skor' => array_sum(ArrayHelper::getColumn($mrkhbhg, 'skor')), 'peratus' => $ap['peratus']]);
                    break;
                }
            }
            break;
            // }
        }
        // }
        foreach ($pemberat as $p) {
            if (empty($peratus[$p['aspek_id']]))
                continue;
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $peratus[$p['aspek_id']]['skor'], 'markah_pyd' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100]);
        }

        if (Model::loadMultiple($penyeliaan, Yii::$app->request->post())) {
            $valid =  Model::validateMultiple($penyeliaan);
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    // $cnt = 4;
                    foreach ($penyeliaan as $ind => $wk) {
                        $wk->lpp_id = $lppid;
                        // $wk->tahap_penyeliaan = $cnt;
                        if ($wk->verified_by == 0) {
                            $wk->verified_by = null;
                        } else {
                            $wk->verified_by = $lpp->PPP;
                            $wk->verified_dt = new \yii\db\Expression('NOW()');
                        }
                        if (!($flag = $wk->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                        // $cnt++;
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


        $dataProvider = new ActiveDataProvider([
            'query' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $this->setMarkahAspek($lppid, 5, $mrkh_bhg, 2);
        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(2, $lppid), [], false);
        $this->calcOverallMark($lppid);
        return $this->render('bahagian', [
            'bahagian' => $bhg,
            'url_create' => $url_create,
            'input' => $penyeliaan,
            'data' => $tmpP,
            'mrkh_bhg' => $mrkhBhg,
            'lppid' => $lppid,
            'menu' => $this->menu($lpp),
            'ruberik' => $aspek,
            'gred_no' =>  $lpp->gredGuru->gred,
            'dataProvider' => $dataProvider,
            'lpp' => $lpp,
            'check' => $this->checkEligible($lpp)
        ]);
    }

    public function actionCreatePenyeliaan($lppid)
    {
        $addon = new TblPenyeliaanManual();
        $doc = new TblDocuments();
        if ($addon->load(Yii::$app->request->post())) {
            $addon->lpp_id = $lppid;
            if ($addon->validate() && $addon->save()) {
                $doc->file = UploadedFile::getInstance($doc, 'file');
                $this->addDocument($doc, $lppid, 2, $addon->id);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                return $this->redirect(['elnpt2/bahagian2', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('create_bhg2', [
            'pnp' => $addon,
            'doc' => $doc,
        ]);
    }

    public function actionUpdatePenyeliaan($id, $lppid)
    {
        $addon = TblPenyeliaanManual::find()->where(['id' => $id, 'lpp_id' => $lppid])->one();
        $doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'bhg_no' => '2', 'id_table' => $id])->one();
        if (!$addon) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }
        if ($addon->load(Yii::$app->request->post())) {
            if ($addon->validate() && $addon->save(false)) {
                $this->editDocument($doc, $lppid, 2);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
                return $this->redirect(['elnpt2/bahagian2', 'lppid' => $addon->lpp_id]);
            }
        }
        return $this->renderAjax('create_bhg2', [
            'pnp' => $addon,
            'doc' => $doc,
        ]);
    }

    public function actionDeletePenyeliaan($id, $lppid)
    {
        $addon = TblPenyeliaanManual::find()
            ->where(['id' => $id, 'lpp_id' => $lppid])
            ->one();
        if (!$addon) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }
        $addon->delete();
        // Yii::$app->FileManager->DeleteFile($doc->filehash);
        // $doc->delete();
        $this->delDocument($lppid, 2, $id);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
        return $this->redirect(['elnpt2/bahagian2', 'lppid' => $addon->lpp_id]);
    }

    public function dataBahagian2($lppid, &$data, &$penyeliaan, &$utama_belum, &$utama_telah_sem, &$utama_telah, &$sama_belum, &$sama_telah_sem, &$sama_telah, &$init)
    {
        $lpp = $this->findLpp($lppid);
        $penyeliaan = TblPenyeliaanManual::find()
            // ->select(new Expression('id as AutoId, kod_kursus as SMP07_KodMP, nama_kursus as NAMAKURSUS, bil_pelajar as BILPELAJAR, sesi as SESI, jam_kredit as JAMKREDIT, \'1\' as DISPLAY, seksyen as SEKSYEN'))
            ->where(['lpp_id' => $lppid])
            ->orderBy(['tahap_penyeliaan' => 'SORT_ASC'])
            // ->indexBy('tahap_penyeliaan')
            // ->asArray()
            ->all();
        if ($penyeliaan == null) {
            $penyeliaan = [new TblPenyeliaanManual()];
            for ($i = 1; $i <= 2; $i++) {
                $penyeliaan[] = new TblPenyeliaanManual();
                $penyeliaan[$i]->lpp_id = $lppid;
                $penyeliaan[$i]->tahap_penyeliaan = 3 + $i;
            }
            unset($penyeliaan[0]);
        } else {
            if ($penyeliaan[0]->tahap_penyeliaan >= 6) {
                for ($i = 1; $i <= 2; $i++) {
                    $penyeliaan[] = new TblPenyeliaanManual();
                    $penyeliaan[$i]->lpp_id = $lppid;
                    $penyeliaan[$i]->tahap_penyeliaan = 3 + $i;
                    // $penyeliaan[$i]->tahap_penyeliaan = 3 + $i;
                }
            }
        }
        usort($penyeliaan, function ($a, $b) {
            return $a->tahap_penyeliaan <=> $b->tahap_penyeliaan;
        });

        $init = TblPenyeliaan::find()
            ->select(new Expression('DISTINCT(LevelPengajian), \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->where(['!=', 'LevelPengajian', 'CERT'])
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $init = ArrayHelper::toArray($init);
        $filter = TblPenyeliaan::find()
            ->where(['NoKpPenyelia' => $lpp->PYD])
            ->orFilterWhere(['SMP28_NoStaf' => $lpp->guru->COOldID])
            ->orFilterWhere(['SMP20_Nama' => $lpp->guru->CONm])
            ->andWhere(['not in', '[KodStatusPengajian]', [24, 04, 58, 05, 59, 22]])
            ->andWhere(['like', '[KodSesi_Sem]', $lpp->tahun]);
        $max = TblPenyeliaan::find()
            ->select(['[Nomatrik] as aaa, [NamaPelajar] as fvfv, [NoKpPenyelia] as ccc, MAX(SUBSTRING(KodSesi_Sem, 8, 4)) AS [Kod],'
                . 'MAX(SUBSTRING(KodSesi_Sem, 8, 4) + SUBSTRING(KodSesi_Sem, 1, 1)) as asd'])
            ->from($filter)
            ->where(['NoKpPenyelia' => $lpp->PYD])
            ->orFilterWhere(['SMP28_NoStaf' => $lpp->guru->COOldID])
            ->orFilterWhere(['SMP20_Nama' => $lpp->guru->CONm])
            ->groupBy(['Nomatrik', 'NamaPelajar', 'NoKpPenyelia'])
            ->having(['OR', ['=', 'MAX(SUBSTRING(KodSesi_Sem, 8, 4))', $lpp->tahun], ['=', 'MAX(SUBSTRING(KodSesi_Sem, 3, 4))', $lpp->tahun]]);
        $data = TblPenyeliaan::find()
            ->innerJoin(['b' => $max], 'b.aaa = [dbo].[Ext_HR02_Penyeliaan].[Nomatrik] and b.ccc = [dbo].[Ext_HR02_Penyeliaan].[NoKpPenyelia]')
            ->andWhere(new Expression('b.asd = (SUBSTRING(KodSesi_Sem, 8, 4) + SUBSTRING(KodSesi_Sem, 1, 1))'))
            ->andWhere(['[dbo].[Ext_HR02_Penyeliaan].[KodTahapPenyeliaan]' => [1, 3, 5, 4, 2]])
            ->andWhere(['[dbo].[Ext_HR02_Penyeliaan].[KodStatusPengajian]' => [51, 52, 53, 54, 56, 57, 01, 31, 32, 33, 06, 16]])
            ->andWhere(['!=', 'LevelPengajian', 'CERT'])
            ->distinct();
        $utama_belum = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, COUNT(*) as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
            ->andWhere(['KodStatusPengajian' => [01, 31, 32, 33, 06, 16]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $utama_belum = ArrayHelper::toArray($utama_belum);
        $utama_telah_sem = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, COUNT(*) as utama_telah_sem,  \'0\' as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
            ->andWhere(['KodStatusPengajian' => [51, 52]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $utama_telah_sem = ArrayHelper::toArray($utama_telah_sem);
        $utama_telah = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, \'0\' as utama_telah_sem,  COUNT(*) as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
            ->andWhere(['KodStatusPengajian' => [53, 54, 56, 57]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $utama_telah = ArrayHelper::toArray($utama_telah);
        $sama_belum = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah, COUNT(*) as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [3, 5]])
            ->andWhere(['KodStatusPengajian' => [01, 31, 32, 33, 06, 16]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $sama_belum = ArrayHelper::toArray($sama_belum);
        $sama_telah_sem = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah,\'0\' as sama_belum,  COUNT(*) as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [3, 5]])
            ->andWhere(['KodStatusPengajian' => [51, 52]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $sama_telah_sem = ArrayHelper::toArray($sama_telah_sem);
        $sama_telah = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah,\'0\' as sama_belum,  \'0\' as sama_telah_sem,  COUNT(*) as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [3, 5]])
            ->andWhere(['KodStatusPengajian' => [53, 54, 56, 57]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $sama_telah = ArrayHelper::toArray($sama_telah);
    }

    public function actionBahagian3($lppid)
    {
        $bhg = RefBahagian::findOne(3);
        $lpp = $this->findLpp($lppid);
        $this->checkBahagian($lpp, $bhg->id);
        $url_create = Url::to(['elnpt2/create-penyelidikan', 'lppid' => $lppid]);
        $this->dataBahagian3($lppid, $penyelidikan, $penyelidikan2, $grant);
        $total_penyelidikan = array_merge($penyelidikan, $penyelidikan2);
        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 3])->asArray()->all();
        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 3]);
        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 3])->asArray()->all();
        $amount = array_sum(ArrayHelper::getColumn(array_filter($total_penyelidikan, function ($var) {
            return ($var['ver_by'] != '');
        }), 'Amount', $keepKeys = true));

        foreach (array_filter($total_penyelidikan, function ($var) {
            return ($var['ver_by'] != '');
        }) as $ind => $tp) {
            foreach (array_reverse($aspek_skor) as $as) {
                // if ($as['aspek_id'] == 9) {
                //     if ($amount >= floatval($as['desc'])) {
                //         ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                //     continue;
                //     }
                // }
                if ($as['aspek_id'] == 6) {
                    if (strcasecmp($tp['Peranan'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 7) {
                    if (strcasecmp($tp['Tahap_geran'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 8) {
                    if (($tp['Status_geran'] == 'Sedang Berjalan') || ($tp['Status_geran'] == 'Diberhentikan/Ditamatkan')) {
                        if ($tp['ExtraDuration'] > 0) {
                            // if(['Status_geran'] == 'Sedang Berjalan' OR ['Status_geran'] == 'Diberhentikan/Ditamatkan')
                            ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => 0.5]);
                        } else {
                            ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => 1]);
                        }
                    }
                }
            }
        }

        foreach (array_reverse($aspek_skor) as $as) {
            if ($as['aspek_id'] == 9) {
                if ($amount >= floatval($as['desc'])) {
                    ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    break;
                }
            }
        }

        foreach (array_reverse($aspek_skor) as $as) {
            if ($as['aspek_id'] == 10) {

                if (floatval($grant) >= floatval($as['desc'])) {

                    ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor']) * floatval($grant)]);
                    break;
                }
            }
        }

        ArrayHelper::setValue($tmp, 6, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['6', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 7, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['7', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 8, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['8', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 9, isset($skor) ? max(ArrayHelper::getColumn($skor, ['9', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 10, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['10', 'skor'], $keepKeys = true)) : 0);
        foreach ($tmp as $ind => $t) {
            foreach ($aspek as $a) {
                if ($a->id == $ind) {
                    foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred)->all()) as $ap) {
                        if ($t >= $ap['min_skor']) {
                            ArrayHelper::setValue($peratus, $a->id, ['skor' => $t, 'peratus' => $ap['peratus']]);
                            break;
                        }
                    }
                    break;
                }
            }
        }
        foreach ($pemberat as $p) {
            if (empty($peratus[$p['aspek_id']]))
                continue;
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $peratus[$p['aspek_id']]['skor'], 'markah_pyd' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100]);
        }

        $this->setMarkahAspek($lppid, 6, $mrkh_bhg, 3);
        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(3, $lppid), [], false);
        $this->calcOverallMark($lppid);
        return $this->render('bahagian', [
            'bahagian' => $bhg,
            // 'url_create' => $url_create,
            'url_create' => null,
            'data' => $total_penyelidikan,
            'input' => null,
            'lppid' => $lppid,
            'mrkh_bhg' => $mrkhBhg,
            'menu' => $this->menu($lpp),
            'ruberik' => $aspek,
            'gred_no' =>  $lpp->gredGuru->gred,
            'check' => $this->checkEligible($lpp),
            'lpp' => $lpp
        ]);
    }

    public function dataBahagian3($lppid, &$penyelidikan, &$penyelidikan2, &$grant)
    {
        $lpp = $this->findLpp($lppid);
        $lpp->tahun = $this->getLantikanPertama($lpp->guru->COOldID, $lpp->tahun) ? ($lpp->tahun + 1) : $lpp->tahun;
        $penyelidikan1 = TblPenyelidikan2::find()
            ->select(new Expression('ID, ProjectID, Title, MIN(Membership) as Peranan, AgencyName, GrantLevelID as Tahap_geran, Amount, StartDate, EndDate, ResearchStatus as Status_geran, ExtensionNo as ExtraDuration, \'0\' as Display, \'\' as file_hash, \'SMP UMS\' as ver_by, \'SMP UMS\' as ver_dt'))
            ->where(['IC' => $lpp->PYD])
            ->andWhere(['AND', ['AND', ['<=', 'StartYear', $lpp->tahun], ['>=', 'EndYear', $lpp->tahun]], ['ResearchStatus' => ['Sedang Berjalan', 'Selesai']]])
            ->groupBy('ID, ProjectID, Title, AgencyName, GrantLevelID, Amount, StartDate, EndDate, ResearchStatus, ExtensionNo')
            ->asArray()
            ->indexBy('ID')
            ->all();
        $penyelidikan2 = TblPenyelidikan2::find()
            ->select(new Expression('ID, ProjectID, Title, Membership as Peranan, AgencyName, GrantLevelID as Tahap_geran, Amount, StartDate, EndDate, ResearchStatus as Status_geran, ExtensionNo as ExtraDuration, \'0\' as Display, \'\' as file_hash, \'SMP UMS\' as ver_by, \'SMP UMS\' as ver_dt'))
            ->where(['AND', ['LIKE', 'Researchers', $lpp->guru->CONm], ['!=', 'Membership', 'Leader']])
            ->andWhere(['AND', ['AND', ['<=', 'StartYear', $lpp->tahun], ['>=', 'EndYear', $lpp->tahun]], ['ResearchStatus' => ['Sedang Berjalan', 'Selesai']]])
            ->distinct()
            ->asArray()
            ->indexBy('ID')
            ->all();
        $penyelidikan =  $penyelidikan1 + $penyelidikan2;
        // $penyelidikan =  array_merge($penyelidikan1, $penyelidikan2);

        $penyelidikan2 = TblPenyelidikanManual::find()
            ->select(new Expression('a.id as ID, projek_id as ProjectID, tajuk_projek as Title, peranan as Peranan, pembiaya as AgencyName, kategori_pembiaya as Tahap_geran, jumlah_biaya as Amount, mula as StartDate, tamat as EndDate, status as Status_geran, \'0\' as ExtraDuration, \'1\' as Display, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 3')
            ->where(['a.lpp_id' => $lppid])
            ->andWhere(['OR', ['YEAR(mula)' => $lpp->tahun], ['status' => 'Sedang Berjalan']])
            ->asArray()
            ->all();
        $grant = TblGrantApplication::find()
            ->where(['UserIC' => $lpp->PYD, 'tahun' => $lpp->tahun])
            ->count();
    }

    public function actionBahagian4($lppid)
    {
        $bhg = RefBahagian::findOne(4);
        $lpp = $this->findLpp($lppid);
        $this->checkBahagian($lpp, $bhg->id);
        $this->dataBahagian4($lppid, $publication);
        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 4])->asArray()->all();
        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 4]);
        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 4])->asArray()->all();

        foreach ($publication as $ind => $tp) {
            foreach ($aspek_skor as $as) {
                if ($as['aspek_id'] == 11) {
                    if ((strcasecmp($tp['Bilangan_penerbitan'], 'Article') == 0)) {
                        if (strcasecmp($tp['Status_indeks'], 'Non-indexed') == 0) {
                            $publication[$ind]['Bilangan_penerbitan'] = 'Article (Non-Indexed)';
                        } else {
                            $publication[$ind]['Bilangan_penerbitan'] = 'Article (Indexed)';
                        }
                    }
                    // if(stripos($as['desc'], $tp['Bilangan_penerbitan']) !== false){
                    // if ($tp['Bilangan_penerbitan'] >= $as['desc']) {
                    if (strcasecmp($publication[$ind]['Bilangan_penerbitan'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                    // $publication[$ind]['Bilangan_penerbitan'] = $as['skor'];
                }
                if ($as['aspek_id'] == 12) {
                    if (strcasecmp($tp['Status_penulis'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 13) {
                    if (strcasecmp($tp['Status_indeks'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 14) {
                    if (strcasecmp($tp['Status_penerbitan'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
        }

        ArrayHelper::setValue($tmp, 11, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['11', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 12, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['12', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 13, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['13', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 14, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['14', 'skor'], $keepKeys = true)) : 0);

        foreach ($tmp as $ind => $t) {
            foreach ($aspek as $a) {
                if ($a->id == $ind) {
                    foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred, 4, $lpp->deptGuru->sub_of ?? $lpp->jfpiu)->all()) as $ap) {
                        if ($t >= $ap['min_skor']) {
                            ArrayHelper::setValue($peratus, $a->id, ['skor' => $t, 'peratus' => $ap['peratus']]);
                            break;
                        }
                    }
                    break;
                }
            }
        }
        foreach ($pemberat as $p) {
            if (empty($peratus[$p['aspek_id']]))
                continue;
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $peratus[$p['aspek_id']]['skor'], 'markah_pyd' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100]);
        }

        $this->setMarkahAspek($lppid, 11, $mrkh_bhg, 4);
        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(4, $lppid), [], false);
        $this->calcOverallMark($lppid);
        return $this->render('bahagian', [
            'bahagian' => $bhg,
            'url_create' => null,
            'data' => $publication,
            'input' => null,
            'lppid' => $lppid,
            'mrkh_bhg' => $mrkhBhg,
            'menu' => $this->menu($lpp),
            'ruberik' => $aspek,
            'gred_no' =>  $lpp->gredGuru->gred,
            'check' => $this->checkEligible($lpp),
            'lpp' => $lpp
        ]);
    }

    public function dataBahagian4($lppid, &$publication)
    {
        $lpp = $this->findLpp($lppid);
        $except = TblException::find()->select('tahun')->where(['lpp_id' => $lppid])->asArray()->all();
        $publication = TblLnptPublicationV2::find()
            ->select(new Expression('Keterangan_PublicationTypeID as Bilangan_penerbitan, Title, PublicationYear, SubmissionYear, KeteranganBI_WriterStatus as Status_penulis, IndexingDesc as Status_indeks, Keterangan_PublicationStatus as Status_penerbitan'))
            ->from('SMP_PPI.dbo.vw_LNPT_PublicationV2')
            ->where(['User_Ic' => $lpp->PYD])
            ->andWhere(['or', ['PublicationYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))], ['SubmissionYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))], ['AcceptanceYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))]])
            ->andWhere([
                'or', ['ApproveStatus' => 'V', 'Keterangan_PublicationStatus' => 'Published'],
                ['Keterangan_PublicationStatus' => [
                    'Paper Accepted'
                    // , 'Paper Submitted'
                ]]
            ])
            ->asArray()
            ->all();
    }

    public function actionBahagian5($lppid)
    {
        $bhg = RefBahagian::findOne(5);
        $lpp = $this->findLpp($lppid);
        $this->checkBahagian($lpp, $bhg->id);
        $this->dataBahagian5($lppid, $conference, $persidangan);
        $url_create = Url::to(['elnpt2/create-persidangan', 'lppid' => $lppid]);
        // $conference = array_merge($conference, $persidangan);

        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 5])->asArray()->all();
        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 5]);
        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 5])->asArray()->all();

        foreach (array_filter($conference, function ($var) {
            return (($var['ver_by'] != '') && ($var['StatusConference'] == 'Verified'));
        })  as $ind => $tp) {
            foreach ($aspek_skor as $as) {
                if ($as['aspek_id'] == 15) {
                    if (strcasecmp($tp['Bilangan_Persidangan_dan_Inovasi'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 16) {
                    if (strcasecmp($tp['Peranan_dalam_projek_Inovasi'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 17) {
                    if (strcasecmp($tp['Tahap_penyertaan'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
        }
        ArrayHelper::setValue($tmp, 15, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['15', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 16, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['16', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 17, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['17', 'skor'], $keepKeys = true)) : 0);
        foreach ($tmp as $ind => $t) {
            foreach ($aspek as $a) {
                if ($a->id == $ind) {
                    foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred)->all()) as $ap) {
                        if ($t >= $ap['min_skor']) {
                            ArrayHelper::setValue($peratus, $a->id, ['skor' => $t, 'peratus' => $ap['peratus']]);
                            break;
                        }
                    }
                    break;
                }
            }
        }
        foreach ($pemberat as $p) {
            if (empty($peratus[$p['aspek_id']]))
                continue;
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $peratus[$p['aspek_id']]['skor'], 'markah_pyd' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100]);
        }
        $this->setMarkahAspek($lppid, 15, $mrkh_bhg, 5);
        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(5, $lppid), [], false);
        $this->calcOverallMark($lppid);
        return $this->render('bahagian', [
            'bahagian' => $bhg,
            // 'url_create' => $url_create,
            'url_create' => null,
            'data' => $conference,
            'input' => null,
            'lppid' => $lppid,
            'mrkh_bhg' => $mrkhBhg,
            'menu' => $this->menu($lpp),
            'ruberik' => $aspek,
            'gred_no' =>  $lpp->gredGuru->gred,
            'check' => $this->checkEligible($lpp),
            'lpp' => $lpp
        ]);
    }

    public function dataBahagian5($lppid, &$conference, &$persidangan)
    {
        $lpp = $this->findLpp($lppid);
        $conf = TblConference::find()
            ->select(['TajukPersidangan', 'Peranan', 'Peringkat', 'StatusConference'])
            ->where(['=', 'IC', $lpp->PYD])
            // ->andWhere(['StatusConference' => 'Verified'])
            // ->andWhere(['StartYear' => $lpp->tahun])
            ->andWhere(['or', ['StartYear' => $lpp->tahun], ['SUBSTRING(Tamat, 7, 4)' => $lpp->tahun]])
            //->asArray()
            ->all();
        //$posts = Post::find()->limit(10)->all();
        $conference = ArrayHelper::toArray($conf, [
            'app\models\elnpt\TblConference' => [
                'Bilangan_Persidangan_dan_Inovasi' => function () {
                    return 'PERSIDANGAN';
                },
                'ConferenceTitle' => function ($conf) {
                    return $conf->TajukPersidangan;
                },
                // the key name in array result => property name
                'Peranan_dalam_projek_Inovasi' => function ($conf) {
                    return $conf->Peranan;
                },
                // the key name in array result => anonymous function
                'Tahap_penyertaan' => function ($conf) {
                    return $conf->Peringkat;
                },
                'Amaun_pengkomersialan' => function ($conf) {
                    return 0;
                },
                'id' => function ($conf) {
                    return 0;
                },
                'file_hash' => function ($conf) {
                    return '';
                },
                'ver_by' => function ($conf) {
                    return 'SMP UMS';
                },
                'ver_dt' => function ($conf) {
                    return 'SMP UMS';
                },
                'StatusConference'
            ],
        ]);
        $persidangan = TblPersidangan::find()
            ->select(new Expression('a.id, kategori as Bilangan_Persidangan_dan_Inovasi, nama_projek as ConferenceTitle,  peranan as Peranan_dalam_projek_Inovasi, tahap as Tahap_penyertaan, 0 as Amaun_pengkomersialan, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 5')
            ->where(['a.lpp_id' => $lppid])
            ->asArray()
            ->all();
    }

    public function actionCreatePersidangan($lppid)
    {
        $sidang = new TblPersidangan();
        $doc = new TblDocuments();
        if ($sidang->load(Yii::$app->request->post())) {
            $sidang->lpp_id = $lppid;
            if ($sidang->validate() && $sidang->save(false)) {
                $this->addDocument($doc, $lppid, 5, $sidang->id);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                return $this->redirect(['elnpt2/bahagian5', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('//elnpt/elnpt2/create_bhg5', [
            'sidang' => $sidang,
            'doc' => $doc
        ]);
    }

    public function actionUpdatePersidangan($id, $lppid)
    {
        $sidang = TblPersidangan::findOne($id);
        $doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'bhg_no' => 5, 'id_table' => $id])->one();
        if (!$sidang) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }
        if ($sidang->load(Yii::$app->request->post())) {
            if ($sidang->validate() && $sidang->save(false)) {
                $this->editDocument($doc, $lppid, 5, $sidang->id);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
                return $this->redirect(['elnpt2/bahagian5', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('//elnpt/elnpt2/create_bhg5', [
            'sidang' => $sidang,
            'doc' => $doc
        ]);
    }

    public function actionDeletePersidangan($id, $lppid)
    {
        $sidang = TblPersidangan::findOne($id);
        if (!$sidang) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }
        $sidang->delete();
        $this->delDocument($lppid, 5, $id);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
        return $this->redirect(['elnpt2/bahagian5', 'lppid' => $lppid]);
    }

    public function actionBahagian6($lppid)
    {
        set_time_limit(800);
        $bhg = RefBahagian::findOne(6);
        $lpp = $this->findLpp($lppid);
        $this->checkBahagian($lpp, $bhg->id);
        $this->dataBahagian6($lppid, $conference, $manual, $manual2);
        $url_create = Url::to(['elnpt2/create-outreaching', 'lppid' => $lppid]);
        $list = array_merge($conference, $manual2);
        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 6])->asArray()->all();
        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 6]);
        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 6])->asArray()->all();

        foreach ($list  as $ind => $tp) {
            foreach ($aspek_skor as $as) {
                if ($as['aspek_id'] == 18) {
                    if (strcasecmp($tp['Bilangan_outreaching'], $as['desc']) == 0) {
                        // if ($tp['Bilangan_outreaching'] >= $as['desc']) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 19) {
                    if (strcasecmp($tp['Peranan_outreaching'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 20) {
                    if (strcasecmp($tp['Tahap_outreaching'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
        }
        foreach (array_reverse($aspek_skor) as $as) {
            if ($as['aspek_id'] == 21) {
                if (array_sum(ArrayHelper::getColumn($list, 'Amaun_outreaching')) >= floatval($as['desc'])) {
                    ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    break;
                }
            }
        }

        ArrayHelper::setValue($tmp, 18, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['18', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 19, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['19', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 20, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['20', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 21, isset($skor) ? max(ArrayHelper::getColumn($skor, ['21', 'skor'], $keepKeys = true)) : 0);

        foreach ($tmp as $ind => $t) {
            foreach ($aspek as $a) {
                if ($a->id == $ind) {
                    foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred)->all()) as $ap) {
                        if ($t >= $ap['min_skor']) {
                            ArrayHelper::setValue($peratus, $a->id, ['skor' => $t, 'peratus' => $ap['peratus']]);
                            break;
                        }
                    }
                    break;
                }
            }
        }
        foreach ($pemberat as $p) {
            if (empty($peratus[$p['aspek_id']]))
                continue;
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $peratus[$p['aspek_id']]['skor'], 'markah_pyd' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100]);
        }
        $this->setMarkahAspek($lppid, 18, $mrkh_bhg, 6);
        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(6, $lppid), [], false);
        $this->calcOverallMark($lppid);
        return $this->render('bahagian', [
            'bahagian' => $bhg,
            'url_create' => $url_create,
            'data' => $list,
            'input' => null,
            'lppid' => $lppid,
            'mrkh_bhg' => $mrkhBhg,
            'menu' => $this->menu($lpp),
            'ruberik' => $aspek,
            'gred_no' =>  $lpp->gredGuru->gred,
            'check' => $this->checkEligible($lpp),
            'lpp' => $lpp,
        ]);
    }

    public function actionCreateOutreaching($lppid)
    {
        $addon = new TblOutreachingManual();
        $doc = new TblDocuments();
        if ($addon->load(Yii::$app->request->post())) {
            $addon->lpp_id = $lppid;
            if ($addon->validate() && $addon->save(false)) {
                $this->addDocument($doc, $lppid, 6, $addon->id);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                return $this->redirect(['elnpt2/bahagian6', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('create_bhg6', [
            'pnp' => $addon,
            'doc' => $doc
        ]);
    }

    public function actionUpdateOutreaching($id, $lppid)
    {
        $addon = TblOutreachingManual::findOne($id);
        $doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'bhg_no' => 6, 'id_table' => $id])->one();
        if (!$addon) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }
        if ($addon->load(Yii::$app->request->post())) {
            if ($addon->validate() && $addon->save(false)) {
                $this->editDocument($doc, $lppid, 6, $id);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
                return $this->redirect(['elnpt2/bahagian6', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('create_bhg6', [
            'pnp' => $addon,
            'doc' => $doc
        ]);
    }

    public function actionDeleteOutreaching($id, $lppid)
    {
        $addon = TblOutreachingManual::findOne($id);
        if (!$addon) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }
        $addon->delete();
        $this->delDocument($lppid, 6, $id);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
        return $this->redirect(['elnpt2/bahagian6', 'lppid' => $lppid]);
    }

    public function dataBahagian6($lppid, &$conference, &$manual, &$manual2)
    {
        $lpp = $this->findLpp($lppid);
        $perundingan = TblConsultation::find()
            ->where(['NoStaf' => $lpp->guru->COOldID])
            ->andwhere(['!=', '[ConsultationType]', 'Medical Consultation'])
            ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $lpp->tahun], ['>=', 'YEAR(TarikhAkhit)', $lpp->tahun]])
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
                },
                'file_hash' => function ($conf) {
                    return '';
                },
                'ver_by' => function ($conf) {
                    return 'SMP UMS';
                },
                'ver_dt' => function ($conf) {
                    return 'SMP UMS';
                },
            ],
        ]);
        $manual = TblOutreachingManual::find()
            ->select(new Expression('a.id, kategori as Bilangan_outreaching, nama_projek as Title, peranan as Peranan_outreaching, tahap_penyertaan as Tahap_outreaching'
                . ', amaun as Amaun_outreaching, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 6')
            ->where(['a.lpp_id' => $lppid])
            // ->limit(10)
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

    public function setMarkahAspek($lppid, $my_id, $mrkh_bhg, $bhg_no)
    {
        $lpp = $this->findLpp($lppid);
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        ksort($mrkh_bhg);
        if (
            TblMrkhAspek::find()
            ->where(['bhg_no' => $bhg_no, 'lpp_id' => $lppid])
            ->all() != null
        ) {
            $models = TblMrkhAspek::find()
                ->select('`hrm`.`elnpt_tbl_mrkh_aspek`.*, `hrm`.`elnpt_v2_ref_aspek_penilaian`.`id` as aspek_id')
                ->rightJoin('`hrm`.`elnpt_v2_ref_aspek_penilaian`', '`hrm`.`elnpt_v2_ref_aspek_penilaian`.`id` =  `hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id`'
                    . ' and `lpp_id` = ' . $lppid)
                ->where(['`hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no`' => $bhg_no])
                ->indexBy('aspek_id')
                // ->orderBy('aspek_id')
                ->all();
            $cnt = $my_id;
        } else {
            $models = [new TblMrkhAspek()];
            for ($i = 1; $i < count($mrkh_bhg); $i++) {
                $models[] = new TblMrkhAspek();
            }
            $cnt = 0;
        }
        // foreach ($models as $model) {
        //     $model->lpp_id = $lppid;
        //     $model->bhg_no = $bhg_no;
        //     $model->aspek_id = $my_id;
        //     $model->skor = $mrkh_bhg[$my_id]['skor'] ?? 0;
        //     $model->markah_pyd = $mrkh_bhg[$my_id]['markah_pyd'] ?? 0;
        //     $model->markah_ppp = $mrkh_bhg[$my_id]['markah_ppp'] ?? ($model->markah_ppp ?? 0);
        //     $model->markah_ppk = $mrkh_bhg[$my_id]['markah_ppk'] ?? ($model->markah_ppk ?? 0);
        //     $model->markah_peer = $mrkh_bhg[$my_id]['markah_peer'] ?? ($model->markah_peer ?? 0);
        //     $model->save(false);
        //     $my_id++;
        // }

        $req = $this->checkRequest($lppid);
        // $cnt = $my_id;
        if (($lpp->PYD == Yii::$app->user->identity->ICNO && date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat) || ($lpp->PYD != Yii::$app->user->identity->ICNO && date('Y-m-d H:i:s') <= $tahun->penilaian_PPK_tamat) || $req) {
            foreach ($mrkh_bhg as $ind => $mb) {
                if ($models[$cnt]->isNewRecord || is_null(($models[$cnt]->id))) {

                    $models[$cnt] = new TblMrkhAspek();
                } else if (is_null($models[$cnt])) {

                    continue;
                }
                // if (empty($arry[$cnt]['bhg_no'])) {
                //     continue;
                //     }
                // }
                $models[$cnt]->lpp_id = $lppid;
                $models[$cnt]->bhg_no = $bhg_no;
                $models[$cnt]->aspek_id = $ind;
                $models[$cnt]->skor = $mb['skor'] ?? 0;
                if ($lpp->PYD == Yii::$app->user->identity->ICNO) {
                    $models[$cnt]->markah_pyd = $mb['markah_pyd'] ?? 0;
                }
                $models[$cnt]->markah_ppp = ($bhg_no >= 3 && $bhg_no <= 5) ? ($mb['markah_pyd'] ?? 0) : ($mb['markah_ppp'] ?? ($models[$cnt]->markah_ppp ?? 0));
                $models[$cnt]->markah_ppk = ($bhg_no >= 3 && $bhg_no <= 5) ? ($mb['markah_pyd'] ?? 0) : ($mb['markah_ppk'] ?? ($models[$cnt]->markah_ppk ?? 0));
                $models[$cnt]->markah_peer = ($bhg_no >= 3 && $bhg_no <= 5) ? ($mb['markah_pyd'] ?? 0) : ($mb['markah_peer'] ?? ($models[$cnt]->markah_peer ?? 0));
                $models[$cnt]->save(false);
                if ($bhg_no == 11) {
                    $cnt = $cnt + 2;
                } else {
                    $cnt++;
                }
            }
        }
    }

    public function findMarkahBahagian($bhg_no, $lppid, $pemberat = null)
    {
        $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        $query = RefAspekPenilaian::find()
            ->select(['`hrm`.`elnpt_v2_ref_aspek_penilaian`.`id`, `hrm`.`elnpt_v2_ref_aspek_penilaian`.`desc`, `hrm`.`elnpt_v2_ref_aspek_penilaian`.`aspek`, coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor, 
                    coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) * 100 as markah_pyd,coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 0) * 100 as markah_ppp, 
                    coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, 0) * 100 as markah_ppk, coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, 0) * 100 as markah_peer, `hrm`.`elnpt_v2_ref_aspek_pemberat`.pemberat * 100 AS pemberat'])
            ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.aspek_id = `hrm`.`elnpt_v2_ref_aspek_penilaian`.id and `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid . '')
            ->leftJoin('`hrm`.`elnpt_v2_ref_aspek_pemberat`', '`hrm`.`elnpt_v2_ref_aspek_pemberat`.aspek_id = `hrm`.`elnpt_v2_ref_aspek_penilaian`.id')
            ->andWhere(['`hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no`' => $bhg_no])
            //->orWhere(['`hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id`' => NULL])
            //->andWhere(['or', ['`hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id`' => $lppid], ['`hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id`' => null]])
            //->andWhere(['IS', '`hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id`', 'NULL'])
            ->asArray()
            ->all();
        if (isset($pemberat)) {
            foreach ($query as $ind => $mn) {
                $query[$ind]['pemberat'] = $pemberat[$ind]['pemberat'] * 100;
            }
        }
        return $query;
    }

    protected function findLpp($lppid)
    {
        if (($model = TblMain::findOne($lppid)) !== null) {
            return $model;
        }
        throw new UserException('The requested page does not exist.');
    }

    public function actionCreatePenyelidikan($lppid)
    {
        $addon = new TblPenyelidikanManual();
        $doc = new TblDocuments();
        if ($addon->load(Yii::$app->request->post())) {
            $addon->lpp_id = $lppid;
            if ($addon->validate() && $addon->save(false)) {
                // $doc->file = UploadedFile::getInstance($doc, 'file');
                // // $tmp = $doc->filehash;
                // if ($doc->file) {
                //     $file = Yii::$app->FileManager->UploadFile($doc->file->name, $doc->file->tempName, '04', 'LNPT/Akademik/' . $this->getTahun($lppid) . '/bhg_3');
                //     if ($file->status == true) {
                //         $doc->lpp_id = $lppid;
                //         $doc->bhg_no = 3;
                //         $doc->id_table = $addon->id;
                //         $doc->filehash = $file->file_name_hashcode;
                //         $doc->file_name = $doc->file->name;
                //         $doc->created_dt = new \yii\db\Expression('NOW()');
                //         $doc->save(false);
                //     }
                // }
                $this->addDocument($doc, $lppid, 3, $addon->id);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                return $this->redirect(['elnpt2/bahagian3', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('create_bhg3', [
            'pnp' => $addon,
            'doc' => $doc
        ]);
    }

    public function actionUpdatePenyelidikan($id, $lppid)
    {
        $addon = TblPenyelidikanManual::findOne($id);
        $doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'bhg_no' => '3', 'id_table' => $id])->one();
        if (!$addon) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }
        if ($addon->load(Yii::$app->request->post())) {
            if ($addon->validate() && $addon->save(false)) {
                // Yii::$app->FileManager->DeleteFile($doc->filehash);
                // $doc->file = UploadedFile::getInstance($doc, 'file');
                // // $tmp = $doc->filehash;
                // if ($doc->file) {
                //     $file = Yii::$app->FileManager->UploadFile($doc->file->name, $doc->file->tempName, '04', 'LNPT/Akademik/' . $this->getTahun($lppid) . '/bhg_3');
                //     if ($file->status == true) {
                //         // $doc->lpp_id = $lppid;
                //         // $doc->bhg_no = 1;
                //         // $doc->id_table = $pnp->id;
                //         $doc->filehash = $file->file_name_hashcode;
                //         $doc->file_name = $doc->file->name;
                //         $doc->created_dt = new \yii\db\Expression('NOW()');
                //         $doc->save(false);
                //     }
                // }
                $this->editDocument($doc, $lppid, 3);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
                return $this->redirect(['elnpt2/bahagian3', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('create_bhg3', [
            'pnp' => $addon,
            'doc' => $doc
        ]);
    }

    public function actionDeletePenyelidikan($id, $lppid)
    {
        $addon = TblPenyelidikanManual::findOne($id);
        // $doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'bhg_no' => '3', 'id_table' => $id])->one();
        if (!$addon) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }
        $addon->delete();
        // Yii::$app->FileManager->DeleteFile($doc->filehash);
        // $doc->delete();
        $this->delDocument($lppid, 3, $id);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
        return $this->redirect(['elnpt2/bahagian3', 'lppid' => $lppid]);
    }

    public function actionBahagian7($lppid)
    {
        $bhg = RefBahagian::findOne(7);
        $lpp = $this->findLpp($lppid);
        $this->checkBahagian($lpp, $bhg->id);
        $this->dataBahagian7($lppid, $urus_tadbir, $result);
        $url_create = Url::to(['elnpt2/create-urus-tadbir', 'lppid' => $lppid]);
        $list = array_merge($urus_tadbir, $result);
        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 7])->asArray()->all();
        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 7]);
        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 7])->asArray()->all();
        foreach ($list  as $ind => $tp) {
            foreach ($aspek_skor as $as) {
                if ($as['aspek_id'] == 22) {
                    if (strcasecmp($tp['Bilangan_jawatankuasa'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 23) {
                    if (strcasecmp($tp['Peranan_jawatankuasa'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 24) {
                    if (strcasecmp($tp['Tahap_jawatankuasa'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
        }

        ArrayHelper::setValue($tmp, 22, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['22', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 23, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['23', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 24, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['24', 'skor'], $keepKeys = true)) : 0);

        foreach ($tmp as $ind => $t) {
            foreach ($aspek as $a) {
                if ($a->id == $ind) {
                    foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred)->all()) as $ap) {
                        if ($t >= $ap['min_skor']) {
                            ArrayHelper::setValue($peratus, $a->id, ['skor' => $t, 'peratus' => $ap['peratus']]);
                            break;
                        }
                    }
                    break;
                }
            }
        }
        foreach ($pemberat as $p) {
            if (empty($peratus[$p['aspek_id']]))
                continue;
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $peratus[$p['aspek_id']]['skor'], 'markah_pyd' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100]);
        }
        $this->setMarkahAspek($lppid, 22, $mrkh_bhg, 7);
        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(7, $lppid), [], false);
        $this->calcOverallMark($lppid);
        return $this->render('bahagian', [
            'bahagian' => $bhg,
            'url_create' => $url_create,
            'data' => $list,
            'input' => null,
            'lppid' => $lppid,
            'mrkh_bhg' => $mrkhBhg,
            'menu' => $this->menu($lpp),
            'ruberik' => $aspek,
            'gred_no' =>  $lpp->gredGuru->gred,
            'check' => $this->checkEligible($lpp),
            'lpp' => $lpp,
        ]);
    }

    public function dataBahagian7($lppid, &$urus_tadbir, &$result)
    {
        $lpp = $this->findLpp($lppid);
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $tamat_dt = $tahun->pengisian_PYD_tamat;
        $urus_tadbir = TblPengurusanPentadbiran::find()
            ->select(new Expression('a.id, kategori as Bilangan_jawatankuasa, nama_jawatan, peranan as Peranan_jawatankuasa, tahap_lantikan as Tahap_jawatankuasa, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->rightJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 7')
            ->where(['a.lpp_id' => $lppid])
            ->asArray()
            ->all();
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
                    SELECT
                    '0'              AS `id`,
                    'Pentadbiran (Lantikan NC & ke atas)' as `Bilangan_jawatankuasa`,
          `a`.`description`   AS `nama_jawatan`,
          'Jawatan Berelaun di Universiti' AS `Peranan_jawatankuasa`,
          'Universiti' AS `Tahap_jawatankuasa`,
          `a`.`flag`            AS `flag`,
          '' as file_hash, 'SMP UMS' as ver_by, 'SMP UMS' as ver_dt
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
        WHERE 
        ((`a`.`ICNO` = '" . $lpp->PYD . "') AND (`a`.`paymentStatus`=1)
        and (`a`.`flag` <> 3)
        ) AND ((TIMESTAMPDIFF(MONTH, `a`.`start_date`, '" . $tamat_dt . "') > 6) AND (YEAR(`a`.`end_date`) >= '" . $lpp->tahun . "')) ORDER BY end_date DESC LIMIT 1");
        $result = $command->queryAll();
    }

    public function actionCreateUrusTadbir($lppid)
    {
        $addon = new TblPengurusanPentadbiran();
        $doc = new TblDocuments();
        if ($addon->load(Yii::$app->request->post())) {
            $addon->lpp_id = $lppid;
            if ($addon->validate() && $addon->save(false)) {
                $this->addDocument($doc, $lppid, 7, $addon->id);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                return $this->redirect(['elnpt2/bahagian7', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('create_bhg7', [
            'pnp' => $addon,
            'doc' => $doc
        ]);
    }

    public function actionUpdateUrusTadbir($id, $lppid)
    {
        $addon = TblPengurusanPentadbiran::findOne($id);
        $doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'bhg_no' => 7, 'id_table' => $id])->one();
        if (!$addon) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }
        if ($addon->load(Yii::$app->request->post())) {
            if ($addon->validate() && $addon->save(false)) {
                $this->editDocument($doc, $lppid, 7, $addon->id);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
                return $this->redirect(['elnpt2/bahagian7', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('create_bhg7', [
            'pnp' => $addon,
            'doc' => $doc
        ]);
    }

    public function actionDeleteUrusTadbir($id, $lppid)
    {
        $addon = TblPengurusanPentadbiran::findOne($id);
        if (!$addon) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }
        $addon->delete();
        $this->delDocument($lppid, 7, $id);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
        return $this->redirect(['elnpt2/bahagian7', 'lppid' => $lppid]);
    }

    public function actionBahagian8($lppid)
    {
        $bhg = RefBahagian::findOne(8);
        $lpp = $this->findLpp($lppid);
        $this->checkBahagian($lpp, $bhg->id);
        $this->dataBahagian8($lppid, $pereka, $inovasi, $teknologi);
        $url_create = Url::to(['elnpt2/create-inovasi', 'lppid' => $lppid]);
        $list = array_merge($pereka, $inovasi, $teknologi);
        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 8])->asArray()->all();
        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 8]);
        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 8])->asArray()->all();
        foreach ($list as $ind => $tp) {
            foreach ($aspek_skor as $as) {
                if ($as['aspek_id'] == 25) {
                    if (strcasecmp($tp['Bilangan_Persidangan_dan_Inovasi'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 26) {
                    if (strcasecmp($tp['Peranan_dalam_projek_Inovasi'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
                if ($as['aspek_id'] == 27) {
                    if (strcasecmp($tp['Tahap_penyertaan'], $as['desc']) == 0) {
                        ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                    }
                }
            }
        }
        $arryGroup = ArrayHelper::index($aspek_skor, null, 'aspek_id');
        foreach (array_reverse($arryGroup['28']) as $as) {
            if (array_sum(ArrayHelper::getColumn($list, 'Bilangan_individu')) >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['29']) as $as) {
            if (array_sum(ArrayHelper::getColumn($list, 'Julat_amaun')) >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                break;
            }
        }

        ArrayHelper::setValue($tmp, 25, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['25', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 26, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['26', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 27, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['27', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 28, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['28', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 29, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['29', 'skor'], $keepKeys = true)) : 0);

        foreach ($tmp as $ind => $t) {
            foreach ($aspek as $a) {
                if ($a->id == $ind) {
                    foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred)->all()) as $ap) {
                        if ($t >= $ap['min_skor']) {
                            ArrayHelper::setValue($peratus, $a->id, ['skor' => $t, 'peratus' => $ap['peratus']]);
                            break;
                        }
                    }
                    break;
                }
            }
        }

        foreach ($pemberat as $p) {
            if (empty($peratus[$p['aspek_id']]))
                continue;
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $peratus[$p['aspek_id']]['skor'], 'markah_pyd' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100]);
        }

        $this->setMarkahAspek($lppid, 25, $mrkh_bhg, 8);
        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(8, $lppid), [], false);
        $this->calcOverallMark($lppid);
        return $this->render('bahagian', [
            'bahagian' => $bhg,
            'url_create' => $url_create,
            'data' => $list,
            'input' => null,
            'lppid' => $lppid,
            'mrkh_bhg' => $mrkhBhg,
            'menu' => $this->menu($lpp),
            'ruberik' => $aspek,
            'gred_no' =>  $lpp->gredGuru->gred,
            'check' => $this->checkEligible($lpp),
            'lpp' => $lpp,
        ]);
    }

    public function dataBahagian8($lppid, &$pereka, &$inovasi, &$teknologi)
    {
        $lpp = $this->findLpp($lppid);
        $pereka = TblPertandinganPereka::find()
            ->select(new Expression('\'0\' as id, \'PERTANDINGAN INOVASI\' as Bilangan_Persidangan_dan_Inovasi, KodPereka as ConferenceTitle, Peranan as Peranan_dalam_projek_Inovasi, '
                . 'Tahap as Tahap_penyertaan, ISNULL(BilPenerimaImpak, 0) as Bilangan_individu, ISNULL(AmaunProjek, 0) as Julat_amaun, \'\' as file_hash, \'SMP UMS\' as ver_by, \'SMP UMS\' as ver_dt'))
            ->where(['NoIC' => $lpp->PYD, 'Tahun' => $lpp->tahun])
            ->asArray()
            ->all();
        $inovasi = TblInovasi::find()
            ->select(new Expression('\'0\' as id, ConsultationType as Bilangan_Persidangan_dan_Inovasi, Tajuk as ConferenceTitle, Keahlian as Peranan_dalam_projek_Inovasi, '
                . 'Peringkat as Tahap_penyertaan, ISNULL(BilPenerimaImpak, 0) as Bilangan_individu, ISNULL(Jumlah, 0) as Julat_amaun, \'\' as file_hash, \'SMP UMS\' as ver_by, \'SMP UMS\' as ver_dt'))
            ->where(['NoStaf' => $lpp->guru->COOldID])
            ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $lpp->tahun], ['>=', 'YEAR(TarikhAkhit)', $lpp->tahun]])
            ->asArray()
            ->all();
        $teknologi = TblTeknologiInovasi::find()
            ->select(new Expression('a.id, kategori as Bilangan_Persidangan_dan_Inovasi, nama_projek as ConferenceTitle,  peranan as Peranan_dalam_projek_Inovasi, tahap_penyertaan as Tahap_penyertaan, bil_impak as Bilangan_individu, amaun as Julat_amaun, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 8')
            ->where(['a.lpp_id' => $lppid])
            ->asArray()
            ->all();
    }

    public function actionCreateInovasi($lppid)
    {
        $inovasi = new TblTeknologiInovasi();
        $doc = new TblDocuments();
        if ($inovasi->load(Yii::$app->request->post())) {
            $inovasi->lpp_id = $lppid;
            if ($inovasi->validate() && $inovasi->save(false)) {
                $this->addDocument($doc, $lppid, 8, $inovasi->id);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                return $this->redirect(['elnpt2/bahagian8', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('//elnpt/elnpt2/create_bhg8', [
            'inovasi' => $inovasi,
            'doc' => $doc
        ]);
    }

    public function actionUpdateInovasi($id, $lppid)
    {
        $inovasi = TblTeknologiInovasi::findOne($id);
        $doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'bhg_no' => 8, 'id_table' => $id])->one();
        if (!$inovasi) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }
        if ($inovasi->load(Yii::$app->request->post())) {
            if ($inovasi->validate() && $inovasi->save(false)) {
                $this->addDocument($doc, $lppid, 8, $id);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
                return $this->redirect(['elnpt2/bahagian8', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('//elnpt/elnpt2/create_bhg8', [
            'inovasi' => $inovasi,
            'doc' => $doc
        ]);
    }

    public function actionDeleteInovasi($id, $lppid)
    {
        $inovasi = TblTeknologiInovasi::findOne($id);
        if (!$inovasi) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }
        $inovasi->delete();
        $this->delDocument($lppid, 8, $id);
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
        return $this->redirect(['elnpt2/bahagian8', 'lppid' => $lppid]);
    }

    public function actionBahagian9($lppid)
    {
        $bhg = RefBahagian::findOne(9);
        $lpp = $this->findLpp($lppid);
        $this->checkBahagian($lpp, $bhg->id);
        $this->dataBahagian9($lppid, $bil_bhg2, $bil_bhg3, $bil_bhg4, $bil_bhg5, $bil_bhg6, $bil_bhg8);

        $bil_mentoring = ($bil_bhg2 * 0.3) + ($bil_bhg3 * 0.3) + ($bil_bhg4 * 0.4);
        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 9])->asArray()->all();
        $aspek = RefAspekPenilaian::find()->where(['bhg_no' => 9])->asArray()->indexBy('id')->all();
        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 9])->asArray()->all();
        // foreach ($list as $ind => $tp) {
        //     foreach ($aspek_skor as $as) {
        //         if ($as['aspek_id'] == 25) {
        //             if (strcasecmp($tp['Bilangan_Persidangan_dan_Inovasi'], $as['desc']) == 0) {
        //                 ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
        //             }
        //         }
        //         if ($as['aspek_id'] == 26) {
        //             if (strcasecmp($tp['Peranan_dalam_projek_Inovasi'], $as['desc']) == 0) {
        //                 ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
        //             }
        //         }
        //         if ($as['aspek_id'] == 27) {
        //             if (strcasecmp($tp['Tahap_penyertaan'], $as['desc']) == 0) {
        //                 ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
        //             }
        //         }
        //     }
        // }
        // !isset($peratusGred) ? 0 : $peratusGred
        switch (true) {
            case $lpp->gredGuru->gred == 'DG41':
            case $lpp->gredGuru->gred == 'DG44':
                $pemberat[0]['pemberat'] = 0;
                $pemberat[1]['pemberat'] = 0;
                $pemberat[2]['pemberat'] = 0.0;
                $pemberat[3]['pemberat'] = 0.5;
                $pemberat[4]['pemberat'] = 0.5;
                $pemberat[5]['pemberat'] = 0.05;
                $pemberat[6]['pemberat'] = 0.05;
                break;
            case $lpp->gredGuru->gred == 'DG48':
                $pemberat[0]['pemberat'] = 0;
                $pemberat[1]['pemberat'] = 0.25;
                $pemberat[2]['pemberat'] = 0.25;
                $pemberat[3]['pemberat'] = 0.25;
                $pemberat[4]['pemberat'] = 0.25;
                $pemberat[5]['pemberat'] = 0.05;
                $pemberat[6]['pemberat'] = 0.05;
                break;
                // default:
                //     $pemberat[0]['pemberat'] = 0;
                //     $pemberat[1]['pemberat'] = 0;
                //     $pemberat[2]['pemberat'] = 0;
                //     $pemberat[3]['pemberat'] = 0;
                //     $pemberat[4]['pemberat'] = 0;
                //     $pemberat[5]['pemberat'] = 0;
                //     $pemberat[6]['pemberat'] = 0;
        }
        switch (true) {
            case $lpp->gredGuru->gred == 'DS45':
                $peratusGred = 20;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DG41':
            case $lpp->gredGuru->gred == 'DG44':
                $peratusGred = 20;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DG48':
                $peratusGred = 10;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DS51':
            case $lpp->gredGuru->gred == 'DS52':
            case $lpp->gredGuru->gred == 'DG52':
            case $lpp->gredGuru->gred == 'DU51':
            case $lpp->gredGuru->gred == 'DU52':
                $peratusGred = 10;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DS53':
            case $lpp->gredGuru->gred == 'DS54':
            case $lpp->gredGuru->gred == 'DG54':
            case $lpp->gredGuru->gred == 'DU54':
            case $lpp->gredGuru->gred == 'DU56':
            case $lpp->gredGuru->gred == 'UMSDF8':
            case $lpp->gredGuru->gred == 'VK7':
            case $lpp->gredGuru->gred == 'VK6':
            case $lpp->gredGuru->gred == 'VK5':
            case $lpp->gredGuru->gred == 'VU7':
            case $lpp->gredGuru->gred == 'VU6':
            case $lpp->gredGuru->gred == 'VU5':
                $peratusGred = 10;
                $terpakai = true;
                break;
            default:
                $peratusGred = 0;
                $terpakai = true;
        }
        $arryGroup = ArrayHelper::index($aspek_skor, null, 'aspek_id');
        foreach (array_reverse($arryGroup['30']) as $as) {
            if ($bil_bhg2 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['31']) as $as) {
            if ($bil_bhg3 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['32']) as $as) {
            if ($bil_bhg4 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['33']) as $as) {
            if ($bil_bhg5 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['34']) as $as) {
            if ($bil_bhg6 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['35']) as $as) {
            if ($bil_bhg8 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['36']) as $as) {
            if ($bil_mentoring >= intval($as['desc'])) {
                ($terpakai) ? ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]) : ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => 0]);
                break;
            }
        }

        ArrayHelper::setValue($tmp, 30, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['30', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg2, 'desc' => $aspek[30]['desc'], 'sumber' => 'Bahagian 2']);
        ArrayHelper::setValue($tmp, 31, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['31', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg3, 'desc' => $aspek[31]['desc'], 'sumber' => 'Bahagian 3']);
        ArrayHelper::setValue($tmp, 32, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['32', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg4, 'desc' => $aspek[32]['desc'], 'sumber' => 'Bahagian 4']);
        ArrayHelper::setValue($tmp, 33, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['33', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg5, 'desc' => $aspek[33]['desc'], 'sumber' => 'Bahagian 5']);
        ArrayHelper::setValue($tmp, 34, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['34', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg6, 'desc' => $aspek[34]['desc'], 'sumber' => 'Bahagian 6']);
        ArrayHelper::setValue($tmp, 35, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['35', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg8, 'desc' => $aspek[35]['desc'], 'sumber' => 'Bahagian 8']);
        ArrayHelper::setValue($tmp, 36, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['36', 'skor'], $keepKeys = true)) : 0, 'bilangan' => (round($bil_mentoring)), 'desc' => $aspek[36]['desc'], 'sumber' => 'Bahagian 2, 3 & 4']);

        foreach ($tmp as $ind => $t) {
            // foreach ($aspek as $a) {
            //     if ($a->id == $ind) {
            //         foreach (array_reverse($a->peratus) as $ap) {
            //             if ($t >= $ap['min_skor']) {
            ArrayHelper::setValue($peratus, $ind, ['skor' => $t['skor'], 'peratus' => $t['skor'] * 100]);
            // break;
            //             }
            //         }
            //         break;
            //     }
            // }
        }

        foreach ($pemberat as $p) {
            if (empty($peratus[$p['aspek_id']]))
                continue;
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $peratus[$p['aspek_id']]['skor'], 'markah_pyd' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100]);
        }

        $this->setMarkahAspek($lppid, 30, $mrkh_bhg, 9);
        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(9, $lppid, $pemberat), [], false);
        foreach ($mrkhBhg as $ind => $mb) {
            $mrkhBhg[$ind]['pemberat'] =  number_format($pemberat[$ind]['pemberat'] * 100, 2);
        }

        $this->calcOverallMark($lppid);
        return $this->render('bahagian', [
            'bahagian' => $bhg,
            'url_create' => null,
            'data' => $tmp,
            'input' => null,
            'lppid' => $lppid,
            'mrkh_bhg' => $mrkhBhg,
            'menu' => $this->menu($lpp),
            'ruberik' => RefAspekPenilaian::findAll(['bhg_no' => 9]),
        ]);
    }

    public function dataBahagian9(
        $lppid,
        &$bil_bhg2,
        &$bil_bhg3,
        &$bil_bhg4,
        &$bil_bhg5,
        &$bil_bhg6,
        &$bil_bhg8
    ) {
        $lpp = $this->findLpp($lppid);
        $tmp1 = TblPenyeliaanManual::find()->select(new Expression('SUM(utama_belum+utama_telah_sem+utama_telah) AS total'))->where(['lpp_id' => $lppid]);
        if ($lpp->PYD != Yii::$app->user->identity->ICNO) {
            $tmp1->andWhere(['and', ['IS NOT', 'verified_by', null], ['IS NOT', 'verified_dt', null]]);
        }
        $bil_penyeliaan_manual = intval($tmp1->asArray()->one()['total']);
        $init = TblPenyeliaan::find()
            ->select(new Expression('DISTINCT(LevelPengajian), \'0\' as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->where(['!=', 'LevelPengajian', 'CERT'])
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $filter = TblPenyeliaan::find()
            ->where(['NoKpPenyelia' => $lpp->PYD])
            ->orFilterWhere(['SMP28_NoStaf' => $lpp->guru->COOldID])
            ->orFilterWhere(['SMP20_Nama' => $lpp->guru->CONm])
            ->andWhere(['not in', '[KodStatusPengajian]', [24, 04, 58, 05, 59, 22]])
            ->andWhere(['like', '[KodSesi_Sem]', $lpp->tahun]);
        $max = TblPenyeliaan::find()
            ->select(['[Nomatrik] as aaa, [NamaPelajar] as fvfv, [NoKpPenyelia] as ccc, MAX(SUBSTRING(KodSesi_Sem, 8, 4)) AS [Kod],'
                . 'MAX(SUBSTRING(KodSesi_Sem, 8, 4) + SUBSTRING(KodSesi_Sem, 1, 1)) as asd'])
            ->from($filter)
            ->where(['NoKpPenyelia' => $lpp->PYD])
            ->orFilterWhere(['SMP28_NoStaf' => $lpp->guru->COOldID])
            ->orFilterWhere(['SMP20_Nama' => $lpp->guru->CONm])
            ->groupBy(['Nomatrik', 'NamaPelajar', 'NoKpPenyelia'])
            ->having(['OR', ['=', 'MAX(SUBSTRING(KodSesi_Sem, 8, 4))', $lpp->tahun], ['=', 'MAX(SUBSTRING(KodSesi_Sem, 3, 4))', $lpp->tahun]]);
        $data = TblPenyeliaan::find()
            ->innerJoin(['b' => $max], 'b.aaa = [dbo].[Ext_HR02_Penyeliaan].[Nomatrik] and b.ccc = [dbo].[Ext_HR02_Penyeliaan].[NoKpPenyelia]')
            ->andWhere(new Expression('b.asd = (SUBSTRING(KodSesi_Sem, 8, 4) + SUBSTRING(KodSesi_Sem, 1, 1))'))
            ->andWhere(['[dbo].[Ext_HR02_Penyeliaan].[KodTahapPenyeliaan]' => [1, 3, 5, 4, 2]])
            ->andWhere(['[dbo].[Ext_HR02_Penyeliaan].[KodStatusPengajian]' => [51, 52, 53, 54, 56, 57, 01, 31, 32, 33, 06, 16]])
            ->andWhere(['!=', 'LevelPengajian', 'CERT'])
            ->distinct();
        $utama_belum = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, COUNT(*) as utama_belum, \'0\' as utama_telah_sem,  \'0\' as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
            ->andWhere(['KodStatusPengajian' => [01, 31, 32, 33, 06, 16]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $utama_belum = ArrayHelper::toArray($utama_belum);
        $utama_telah_sem = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, COUNT(*) as utama_telah_sem,  \'0\' as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
            ->andWhere(['KodStatusPengajian' => [51, 52]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $utama_telah_sem = ArrayHelper::toArray($utama_telah_sem);
        $utama_telah = TblPenyeliaan::find()
            ->select(new Expression('\'0\' as id, LevelPengajian, \'0\' as utama_belum, \'0\' as utama_telah_sem,  COUNT(*) as utama_telah, \'0\' as sama_belum,  \'0\' as sama_telah_sem,  \'0\' as sama_telah'))
            ->from($data)
            ->andWhere(['KodTahapPenyeliaan' => [1, 4, 2]])
            ->andWhere(['KodStatusPengajian' => [53, 54, 56, 57]])
            ->groupBy('LevelPengajian')
            ->indexBy('LevelPengajian')
            // ->asArray()
            ->all();
        $utama_telah = ArrayHelper::toArray($utama_telah);
        $tmp = array_merge_recursive($utama_belum, $utama_telah_sem, $utama_telah, $init);
        foreach ($tmp as $id => $t) {
            ArrayHelper::setValue($tmpP, [$id, 'utama_belum'], is_array($tmp[$id]['utama_belum']) ? array_sum($tmp[$id]['utama_belum']) : $tmp[$id]['utama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah_sem'], is_array($tmp[$id]['utama_telah_sem']) ? array_sum($tmp[$id]['utama_telah_sem']) : $tmp[$id]['utama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah'], is_array($tmp[$id]['utama_telah']) ? array_sum($tmp[$id]['utama_telah']) : $tmp[$id]['utama_telah']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_belum'], is_array($tmp[$id]['sama_belum']) ? array_sum($tmp[$id]['sama_belum']) : $tmp[$id]['sama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah_sem'], is_array($tmp[$id]['sama_telah_sem']) ? array_sum($tmp[$id]['sama_telah_sem']) : $tmp[$id]['sama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah'], is_array($tmp[$id]['sama_telah']) ? array_sum($tmp[$id]['sama_telah']) : $tmp[$id]['sama_telah']);
        }
        $bil_penyeliaan  = 0;
        foreach ($tmpP as $tP) {
            $bil_penyeliaan += $tP['utama_belum'] + $tP['utama_telah_sem'] + $tP['utama_telah'];
        }
        $bil_bhg2 = $bil_penyeliaan + $bil_penyeliaan_manual;
        $lpp->tahun = $this->getLantikanPertama($lpp->guru->COOldID, $lpp->tahun) ? ($lpp->tahun + 1) : $lpp->tahun;
        $penyelidikan = TblPenyelidikan2::find()
            ->where(['IC' => $lpp->PYD])
            ->andWhere(['AND', ['AND', ['<=', 'StartYear', $lpp->tahun], ['>=', 'EndYear', $lpp->tahun]], ['ResearchStatus' => ['Sedang Berjalan', 'Selesai']]])
            ->andWhere(['Membership' => ['Ketua', 'Leader']])
            ->count();
        $tmp2 = TblPenyelidikanManual::find()
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 3')
            ->where(['a.lpp_id' => $lppid])
            ->andWhere(['OR', ['YEAR(mula)' => $lpp->tahun], ['status' => 'Sedang Berjalan']])
            ->andWhere(['peranan' => ['Ketua', 'Leader']]);
        if ($lpp->PYD != Yii::$app->user->identity->ICNO) {
            $tmp2->andWhere(['and', ['not', ['b.verified_by' => null]], ['not', ['b.verified_dt' => null]]]);
        }
        $penyelidikan2 = $tmp2->count();
        $bil_bhg3 = $penyelidikan + $penyelidikan2;
        $lpp->tahun = $this->getLantikanPertama($lpp->guru->COOldID, $lpp->tahun) ? ($lpp->tahun - 1) : $lpp->tahun;
        $except = TblException::find()->select('tahun')->where(['lpp_id' => $lppid])->asArray()->all();
        $bil_bhg4 = TblLnptPublicationV2::find()
            ->where(['User_Ic' => $lpp->PYD])
            ->andWhere(['or', ['PublicationYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))], ['SubmissionYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))], ['AcceptanceYear' => (empty($except) ? $lpp->tahun : ArrayHelper::getColumn($except, 'tahun', $keepKeys = true))]])
            ->andWhere([
                'or', ['ApproveStatus' => 'V', 'Keterangan_PublicationStatus' => 'Published'],
                ['Keterangan_PublicationStatus' => [
                    'Paper Accepted'
                    // , 'Paper Submitted'
                ]]
            ])
            ->andWhere(['KeteranganBI_WriterStatus' => ['Chief Editor', 'First Author', 'Corresponding Author']])
            ->count();
        $confer = TblConference::find()
            ->where(['IC' => $lpp->PYD])
            ->andWhere(['StatusConference' => 'Verified'])
            ->andWhere(['or', ['StartYear' => $lpp->tahun], ['SUBSTRING(Tamat, 7, 4)' => $lpp->tahun]])
            ->andWhere(['Peranan' => ['Ketua', 'Pembentang', 'Pengerusi Sesi', 'Keynote Speaker', 'Panel', 'Ketua Sesi', 'Pembentang Poster', 'Pembentang Jemputan', 'Pengerusi']])
            ->count();
        $persidangan = TblPersidangan::find()
            ->select(new Expression('a.id, kategori as Bilangan_Persidangan_dan_Inovasi, nama_projek as ConferenceTitle,  peranan as Peranan_dalam_projek_Inovasi, tahap as Tahap_penyertaan, 0 as Amaun_pengkomersialan, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 5')
            ->where(['a.lpp_id' => $lppid])
            ->andWhere(['Peranan' => ['Ketua', 'Pembentang', 'Pengerusi Sesi', 'Keynote Speaker', 'Panel', 'Ketua Sesi', 'Pembentang Poster', 'Pembentang Jemputan', 'Pengerusi']])
            ->andWhere(['and', ['not', ['b.verified_by' => null]], ['not', ['b.verified_dt' => null]]])
            ->count();
        $bil_bhg5 = $confer + $persidangan;
        $perundingan = TblConsultation::find()
            ->where(['NoStaf' => $lpp->guru->COOldID])
            ->andwhere(['!=', '[ConsultationType]', 'Medical Consultation'])
            ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $lpp->tahun], ['>=', 'YEAR(TarikhAkhit)', $lpp->tahun]])
            ->andWhere(['Keahlian' => [
                'Ketua',
                'Pengerusi Jawatankuasa',
                'Pengerusi Viva Voce (PASCASISWAZAH)',
                'Leader',
                // 'Pembentang', 'Pengerusi Sesi', 'Keynote Speaker', 'Panel', 'Leader'
            ]])
            ->count();
        $tmp3 = TblOutreachingManual::find()
            ->alias('a')
            ->select(new Expression('id, kategori as Bilangan_outreaching, nama_projek as Title, peranan as Peranan_outreaching, tahap_penyertaan as Tahap_outreaching'
                . ', amaun as Amaun_outreaching'))
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 6')
            ->where(['a.lpp_id' => $lppid])
            ->andWhere(['peranan' => [
                'Ketua',
                'Pengerusi Jawatankuasa',
                'Pengerusi Viva Voce (PASCASISWAZAH)',
                'Leader',
                // 'Pembentang', 'Pengerusi Sesi', 'Keynote Speaker', 'Panel', 'Leader'
            ]]);
        if ($lpp->PYD != Yii::$app->user->identity->ICNO) {
            $tmp3->andWhere(['and', ['not', ['b.verified_by' => null]], ['not', ['b.verified_dt' => null]]]);
        }
        $manual = $tmp3->count();
        $bil_bhg6 = $perundingan + $manual;
        $pereka = TblPertandinganPereka::find()
            ->where(['NoIC' => $lpp->PYD, 'Tahun' => $lpp->tahun])
            ->andWhere(['Peranan' => ['Ketua', 'Leader']])
            ->count();
        $inovasi = TblInovasi::find()
            ->where(['NoStaf' => $lpp->guru->COOldID])
            ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $lpp->tahun], ['>=', 'YEAR(TarikhAkhit)', $lpp->tahun]])
            ->andWhere(['Keahlian' => ['Ketua', 'Leader']])
            ->count();
        $tmp4 = TblTeknologiInovasi::find()
            ->select(new Expression('a.id, kategori as Bilangan_Persidangan_dan_Inovasi, nama_projek as ConferenceTitle,  peranan as Peranan_dalam_projek_Inovasi, tahap_penyertaan as Tahap_penyertaan, bil_impak as Bilangan_individu, amaun as Julat_amaun, b.filehash as file_hash, b.verified_by as ver_by, b.verified_dt as ver_dt'))
            ->alias('a')
            ->leftJoin(['b' => 'hrm.elnpt_v2_tbl_document'], 'b.id_table = a.id and b.lpp_id = a.lpp_id and b.bhg_no = 8')
            ->where(['a.lpp_id' => $lppid]);
        if ($lpp->PYD != Yii::$app->user->identity->ICNO) {
            $tmp4->andWhere(['and', ['not', ['b.verified_by' => null]], ['not', ['b.verified_dt' => null]]]);
        }
        $teknologi = $tmp4->count();
        $bil_bhg8 = $pereka + $inovasi + $teknologi;
    }

    public function actionBahagian10($lppid)
    {
        $bhg = RefBahagian::findOne(10);
        $lpp = $this->findLpp($lppid);
        $this->checkBahagian($lpp, $bhg->id);
        $aspek = RefAspekPenilaian::find()->where(['bhg_no' => 10])->indexBy('id')->asArray()->all();
        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 10])->asArray()->all();
        $peratus = RefAspekPeratus::find()->where(['bahagian' => 10])->asArray()->all();
        $list = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->asArray()->all();

        $tmpp = [];
        if ($mrkhKualiti = TblMarkahKualiti::findAll(['lpp_id' => $lppid]) != null) {
            $mrkhKualiti = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->all();
            $tmpp = ArrayHelper::toArray($mrkhKualiti);
        } else {
            $mrkhKualiti = [new TblMarkahKualiti()];
            $cnt = 0;
            foreach ($aspek as $ind => $a) {
                $mrkhKualiti[$cnt] = new TblMarkahKualiti();
                $mrkhKualiti[$cnt]->ref_kualiti_id = $ind;
                $cnt++;
            }
        }

        if (Model::loadMultiple($mrkhKualiti, Yii::$app->request->post()) && Model::validateMultiple($mrkhKualiti)) {
            foreach ($mrkhKualiti as $mk) {
                $mk->lpp_id = $lppid;
                $mk->save(false);
            }
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
            return $this->redirect(Yii::$app->request->referrer);
        }

        foreach ($pemberat as $p) {
            if (empty($tmpp[$p['aspek_id']]))
                continue;
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], [
                'skor' => 0,
                'markah_ppp' => ($tmpp[$p['aspek_id']]['markah_ppp'] * $p['pemberat']) / 100,
                'markah_ppk' => ($tmpp[$p['aspek_id']]['markah_ppk'] * $p['pemberat']) / 100,
                'markah_peer' => ($tmpp[$p['aspek_id']]['markah_peer'] * $p['pemberat']) / 100,
            ]);
        }

        if (isset($mrkh_bhg))
            $this->setMarkahAspek($lppid, 37, $mrkh_bhg, 10);
        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(10, $lppid), [], false);
        $this->calcOverallMark($lppid);
        return $this->render('bahagian', [
            'bahagian' => $bhg,
            'url_create' => null,
            'data' => $aspek,
            'input' => $mrkhKualiti,
            'lppid' => $lppid,
            'mrkh_bhg' => $mrkhBhg,
            'menu' => $this->menu($lpp),
            'ruberik' => RefAspekPenilaian::findAll(['bhg_no' => 10]),
        ]);
    }

    public function actionBahagian11($lppid)
    {
        $bhg = RefBahagian::findOne(11);
        $lpp = $this->findLpp($lppid);
        $this->checkBahagian($lpp, $bhg->id);
        $this->dataBahagian11($lppid, $klinikal, $clinic);
        if ($klinikal->load(Yii::$app->request->post())) {
            $klinikal->lpp_id = $lppid;
            if ($klinikal->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya ditambah!']);
                return $this->redirect(['elnpt2/bahagian11', 'lppid' => $lppid]);
            }
        }
        $k = ArrayHelper::toArray($klinikal, [
            'app\models\elnpt\perkhidmatan_klinikal\TblKlinikal' => [
                'cbt' => function ($klinikal) {
                    return $klinikal->cbt ?? 0;
                },
                // 'apc' => function ($klinikal) {
                //     return $klinikal->apc ?? 0;
                // },
                'apc' => function ($klinikal) use ($clinic) {
                    return $clinic ? 1 : 0;
                },
                'clinic_consult' => function ($klinikal) {
                    return $klinikal->clinic_consult ?? 0;
                }
            ],
        ]);
        // $url_create = Url::to(['elnpt2/create-urus-tadbir', 'lppid' => $lppid]);

        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 11])->asArray()->all();
        $aspek = RefAspekPenilaian::findAll(['bhg_no' => 11]);
        $pemberat = RefAspekPemberat::find()->where(['bahagian' => 11])->asArray()->all();
        foreach ($aspek_skor as $as) {
            if ($as['aspek_id'] == 43) {
                if (floatval($k['clinic_consult']) >= floatval($as['desc'])) {
                    ArrayHelper::setValue($skor, [43, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                }
            }
            if ($as['aspek_id'] == 44) {
                if ($k['cbt'] >= $as['desc']) {
                    ArrayHelper::setValue($skor, [44, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                }
            }
            if ($as['aspek_id'] == 45) {
                if (strcasecmp(($k['apc'] == 1) ? 'Ya' : 'Tidak', $as['desc']) == 0) {
                    ArrayHelper::setValue($skor, [45, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                }
            }
        }
        // $arryGroup = ArrayHelper::index($aspek_skor, null, 'aspek_id');
        // foreach (array_reverse($arryGroup['28']) as $as) {
        //     if (array_sum(ArrayHelper::getColumn($list, 'Bilangan_individu')) >= floatval($as['desc'])) {
        //         ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
        //         break;
        //     }
        // }
        // foreach (array_reverse($arryGroup['29']) as $as) {
        //     if (array_sum(ArrayHelper::getColumn($list, 'Julat_amaun')) >= floatval($as['desc'])) {
        //         ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
        //         break;
        //     }
        // }

        ArrayHelper::setValue($tmp, 43, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['43', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 44, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['44', 'skor'], $keepKeys = true)) : 0);
        ArrayHelper::setValue($tmp, 45, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['45', 'skor'], $keepKeys = true)) : 0);

        foreach ($tmp as $ind => $t) {
            foreach ($aspek as $a) {
                if ($a->id == $ind) {
                    foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred, 11)->all()) as $ap) {
                        if ($t >= $ap['min_skor']) {
                            ArrayHelper::setValue($peratus, $a->id, ['skor' => $t, 'peratus' => $ap['peratus']]);
                            break;
                        }
                    }
                    break;
                }
            }
        }

        foreach ($pemberat as $p) {
            if (empty($peratus[$p['aspek_id']]))
                continue;
            ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], ['skor' => $peratus[$p['aspek_id']]['skor'], 'markah_pyd' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100]);
        }

        $this->setMarkahAspek($lppid, 43, $mrkh_bhg, 11);
        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(11, $lppid), [], false);
        $this->calcOverallMark($lppid);
        return $this->render('bahagian', [
            'bahagian' => $bhg,
            'url_create' => null,
            'data' => $k,
            'input' => $klinikal,
            'lppid' => $lppid,
            'mrkh_bhg' => $mrkhBhg,
            'menu' => $this->menu($lpp),
            'ruberik' => $aspek,
            'gred_no' =>  $lpp->gredGuru->gred,
            'lpp' => $lpp,
            'check' => $this->checkEligible($lpp),
        ]);
    }

    public function dataBahagian11(&$lppid, &$klinikal, &$clinical)
    {
        if (($klinikal = TblKlinikal::findOne(['lpp_id' => $lppid])) != null) {
            $klinikal = TblKlinikal::find()->where(['lpp_id' => $lppid])->one();
        } else {
            $klinikal = new TblKlinikal();
        }
        $lpp = $this->findLpp($lppid);
        switch (true) {
            case $clinical1 = TblConsultation::find()
                ->where(['NoStaf' => $lpp->guru->COOldID])
                ->andwhere(['=', '[ConsultationType]', 'Recognition'])
                ->andWhere(['OR', ['>=', 'Tajuk', 'APC'], ['>=', 'Tajuk', 'annual']])
                ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $lpp->tahun], ['>=', 'YEAR(TarikhAkhit)', $lpp->tahun]])
                ->exists():
                $clinical = $clinical1;
                break;
            case $clinical4 = TblLnptClinical::find()
                ->where(['CreateBy' => $lpp->PYD])
                ->andWhere(['or', ['like', 'Activity', 'annual'], ['like', 'Activity', 'apc']])
                // ->andWhere(['and', ['YEAR(StartDate)' => $lpp->tahun], ['>=', 'YEAR(EndDate)', $lpp->tahun]])
                // ->andWhere(['Type' => ['Clinic sessions', 'Clinical ward work/rounds', 'Surgical procedures']])
                // ->asArray()
                // ->all();
                ->exists():
                $clinical = $clinical4;
                break;
            case $clinical2 = TblConsultationClinical::find()
                ->where(['ICKakitangan' => $lpp->PYD])
                ->andWhere(['OR', ['>=', 'Rawatan', 'APC'], ['>=', 'Rawatan', 'annual']])
                ->andWhere(['OR', ['>=', 'YEAR(TarikhMula)', $lpp->tahun], ['>=', 'YEAR(TarikhAkhir)', $lpp->tahun]])
                ->exists():
                $clinical = $clinical2;
                break;
            case $clinical3 = TblConsultancy::find()
                ->where(['ICNo' => $lpp->PYD])
                ->andWhere(['OR', ['>=', 'Title', 'APC'], ['>=', 'Title', 'annual']])
                ->andWhere(['OR', ['>=', 'YEAR(StartDate)', $lpp->tahun], ['>=', 'YEAR(EndDate)', $lpp->tahun]])
                ->exists():
                $clinical = $clinical3;
                break;
            default:
                $clinical = false;
        }
    }

    public function checkBahagian($lpp, $bhg_no)
    {
        $dept = TblKumpDept::find()->where(['dept_id' => $lpp->deptGuru->sub_of ?? $lpp->jfpiu])->asArray()->all();
        $dept1 = ArrayHelper::getColumn($dept, 'ref_kump_dept_id');
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $tamat_dt = $tahun->pengisian_PYD_tamat;
        $hasJawatan = Tblrscoadminpost::find()->where(['ICNO' => $lpp->PYD, 'paymentStatus' => 1])->andWhere(['<>', 'flag', 3])->andWhere(['and', ['>', new Expression('TIMESTAMPDIFF(MONTH, start_date, \'' . \Yii::$app->formatter->asDate($tamat_dt, 'yyyy-MM-dd') . '\')'), 6], [
            '>=', new Expression('YEAR(end_date)'), $lpp->tahun
        ]])->orderBy(['end_date' => SORT_DESC])->limit(1)->exists();
        $gred = RefGred::find()->where(['kump_gred' => ($hasJawatan && (in_array('1', $dept1) || in_array('2', $dept1) || in_array('6', $dept1) || in_array('3', $dept1) || in_array('5', $dept1))) ? $this->checkJawatanDeptKump($lpp->gredGuru->gred, $lpp->jfpiu, $lpp->gredGuru->gred_skim) : $lpp->gredGuru->gred])->one();
        $ex = TblException2::findOne([$lpp->lpp_id]);
        if (!is_null($ex)) {
            $dept = TblKumpDept::find()->where(['id' => $ex->tbl_kump_dept_id])->asArray()->all();
            $gred = RefGred::findOne([$ex->ref_gred_id]);
        }
        try {
            $check = RefPemberatSeluruh::find()->where(['tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'ref_gred_id' => $gred->id, 'bahagian' => $bhg_no])->exists();
            if (!$check) {
                throw new HttpException(403, "You don't have permission to view this page.");
            }
        } catch (\Exception $e) {
            throw new HttpException(403, "You don't have permission to view this page.");
        }
    }

    public function menu($lpp)
    {
        $dept = TblKumpDept::find()->where(['dept_id' => $lpp->deptGuru->sub_of ?? $lpp->jfpiu])->asArray()->all();
        $dept1 = ArrayHelper::getColumn($dept, 'ref_kump_dept_id');
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $tamat_dt = $tahun->pengisian_PYD_tamat;
        $hasJawatan = Tblrscoadminpost::find()->where(['ICNO' => $lpp->PYD, 'paymentStatus' => 1])->andWhere(['<>', 'flag', 3])->andWhere(['and', ['>', new Expression('TIMESTAMPDIFF(MONTH, start_date, \'' . \Yii::$app->formatter->asDate($tamat_dt, 'yyyy-MM-dd') . '\')'), 6], [
            '>=', new Expression('YEAR(end_date)'), $lpp->tahun
        ]])->orderBy(['end_date' => SORT_DESC])->limit(1)->exists();
        $gred = RefGred::find()->where(['kump_gred' => ($hasJawatan && (in_array('1', $dept1) || in_array('2', $dept1) || in_array('6', $dept1) || in_array('3', $dept1) || in_array('5', $dept1))) ? $this->checkJawatanDeptKump($lpp->gredGuru->gred, $lpp->jfpiu, $lpp->gredGuru->gred_skim) : $lpp->gredGuru->gred])->one();
        $ex = TblException2::findOne([$lpp->lpp_id]);
        if (!is_null($ex)) {
            $dept = TblKumpDept::find()->where(['id' => $ex->tbl_kump_dept_id])->asArray()->all();
            $gred = RefGred::findOne([$ex->ref_gred_id]);
        }
        $query = RefBahagian::find()
            ->alias('a')
            ->innerJoin(['b' => 'hrm.elnpt_v2_ref_pemberat_keseluruhan'], 'b.bahagian = a.id')
            ->where(['b.tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'ref_gred_id' => $gred->id])
            ->asArray()
            ->all();
        return $query;
    }

    public function calcOverallMark($lppid)
    {
        if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
            $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $dept = TblKumpDept::find()->where(['dept_id' => $lpp->deptGuru->sub_of ?? $lpp->jfpiu])->asArray()->all();
        $dept1 = ArrayHelper::getColumn($dept, 'ref_kump_dept_id');
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $tamat_dt = $tahun->pengisian_PYD_tamat;
        $hasJawatan = Tblrscoadminpost::find()->where(['ICNO' => $lpp->PYD, 'paymentStatus' => 1])->andWhere(['<>', 'flag', 3])->andWhere(['and', ['>', new Expression('TIMESTAMPDIFF(MONTH, start_date, \'' . \Yii::$app->formatter->asDate($tamat_dt, 'yyyy-MM-dd') . '\')'), 6], [
            '>=', new Expression('YEAR(end_date)'), $lpp->tahun
        ]])->orderBy(['end_date' => SORT_DESC])->limit(1)->exists();
        $gred = RefGred::find()->where(['kump_gred' => ($hasJawatan && (in_array('1', $dept1) || in_array('2', $dept1) || in_array('6', $dept1) || in_array('3', $dept1) || in_array('5', $dept1))) ? $this->checkJawatanDeptKump($lpp->gredGuru->gred, $lpp->jfpiu, $lpp->gredGuru->gred_skim) : $lpp->gredGuru->gred])->one();
        $ex = TblException2::findOne([$lpp->lpp_id]);
        if (!is_null($ex)) {
            $dept = TblKumpDept::find()->where(['id' => $ex->tbl_kump_dept_id])->asArray()->all();
            $gred = RefGred::findOne([$ex->ref_gred_id]);
        }
        $bhgMrkh = TblMrkhAspek::find()
            ->select(['a.bhg_no, ROUND(CAST(SUM(markah_ppp + markah_ppk)/2 * (pemberat/100) AS DECIMAL(8, 5)), 4) as mrkh_bhg'])
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin(['b' => 'hrm.elnpt_v2_ref_pemberat_keseluruhan'], 'b.bahagian = a.bhg_no and a.lpp_id = ' . $lppid)
            ->where(['b.tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'b.ref_gred_id' => $gred->id, 'b.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no');
        $req = $this->checkRequest($lppid);
        if ((!is_null($bhgMrkh)
            // && ((($lpp->PYD == Yii::$app->user->identity->ICNO  && date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat) || ($lpp->PYD != Yii::$app->user->identity->ICNO && !$this->checkEligible($lpp))) || $req)
        )) {
            $arry = $bhgMrkh->asArray()->all();
            $arry = ArrayHelper::index($arry, 'bhg_no');
            $this->getMarkahKualiti($lppid, $mrkh_ppp, $mrkh_ppk, $mrkh_peer, $lpp, $gred, $dept, $fin);
            ArrayHelper::setValue($arry, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($fin)]);
            ksort($arry);
            if (TblMrkhBhg::find()->where(['lpp_id' => $lppid])->all() != null) {
                $models = TblMrkhBhg::find()
                    ->alias('a')
                    ->rightJoin(['b' => 'hrm.elnpt_v2_ref_pemberat_keseluruhan'], 'b.bahagian = a.bhg_id and a.lpp_id = ' . $lppid)
                    ->where([
                        'b.tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'b.ref_gred_id' => $gred->id, 'b.`year`' => $lpp->tahun
                    ])
                    ->indexBy('bhg_id')
                    ->all();
            } else {
                $models = [new TblMrkhBhg()];
                for ($i = 0; $i < sizeof($arry); $i++) {
                    $models[] = new TblMrkhBhg();
                }
            }
            $cnt = 0;
            $cnt = array_key_first($arry);
            foreach ($arry as $ind => $mb) {
                if (is_null($models[$cnt])) {
                    $models[$cnt] = new TblMrkhBhg();
                }
                $models[$cnt]->lpp_id = $lppid;
                $models[$cnt]->bhg_id = $mb['bhg_no'];
                $models[$cnt]->markah = $mb['mrkh_bhg'];
                $models[$cnt]->save(false);
                $cnt++;
            }
        }
    }

    public function actionRingkasan($lppid)
    {
        if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
            $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->GenerateSamePPP($lppid);
        $dept = TblKumpDept::find()->where(['dept_id' => $lpp->deptGuru->sub_of ?? $lpp->jfpiu])->asArray()->all();
        $dept1 = ArrayHelper::getColumn($dept, 'ref_kump_dept_id');
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $tamat_dt = $tahun->pengisian_PYD_tamat;
        $hasJawatan = Tblrscoadminpost::find()->where(['ICNO' => $lpp->PYD, 'paymentStatus' => 1])->andWhere(['<>', 'flag', 3])->andWhere(['and', ['>', new Expression('TIMESTAMPDIFF(MONTH, start_date, \'' . \Yii::$app->formatter->asDate($tamat_dt, 'yyyy-MM-dd') . '\')'), 6], [
            '>=', new Expression('YEAR(end_date)'), $lpp->tahun
        ]])->orderBy(['end_date' => SORT_DESC])->limit(1)->exists();
        $gred = RefGred::find()->where(['kump_gred' => ($hasJawatan && (in_array('1', $dept1) || in_array('2', $dept1) || in_array('6', $dept1) || in_array('3', $dept1) || in_array('5', $dept1))) ? $this->checkJawatanDeptKump($lpp->gredGuru->gred, $lpp->jfpiu, $lpp->gredGuru->gred_skim) : $lpp->gredGuru->gred])->one();
        $ex = TblException2::findOne([$lpp->lpp_id]);
        if (!is_null($ex)) {
            $dept = TblKumpDept::find()->where(['id' => $ex->tbl_kump_dept_id])->asArray()->all();
            $gred = RefGred::findOne([$ex->ref_gred_id]);
        }
        $query11 = RefPemberatSeluruh::find()
            ->select(['tbl_kump_dept_id', 'pemberat', 'bahagian'])
            ->where(['tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'ref_gred_id' => $gred->id, 'year' => $lpp->tahun])
            ->orderBy(['bahagian' => SORT_ASC])
            ->indexBy('bahagian')
            ->asArray()
            ->all();
        $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid, $dept, $gred), [], false);
        $markah = (new \yii\db\Query())
            ->select(['`hrm`.`elnpt_v2_ref_bahagian`.`id` AS id', '`hrm`.`elnpt_v2_ref_bahagian`.`bahagian` AS aspek', '((COALESCE(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0.0) * 100) / `hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`pemberat`) as markah', '`hrm`.`elnpt_v2_ref_bahagian`.`bhg_color` AS warna'])
            ->from('`hrm`.`elnpt_v2_ref_bahagian`')
            ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` = `hrm`.`elnpt_v2_ref_bahagian`.`id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
            ->rightJoin('(SELECT DISTINCT bahagian FROM `hrm`.`elnpt_v2_ref_pemberat_keseluruhan`) a', 'a.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
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
                '`hrm`.`elnpt_v2_ref_aspek_penilaian`.`desc`', '`hrm`.`elnpt_v2_ref_aspek_penilaian`.`aspek`', '`hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no` as bhg_no', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor',
                'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) as markah_pyd', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 0) as markah_ppp', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, 0) as markah_ppk',
                'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, 0) as markah_peer', '`hrm`.`elnpt_v2_ref_bahagian`.`id` as idd'
            ])
            ->leftJoin('`hrm`.`elnpt_v2_ref_bahagian`', '`hrm`.`elnpt_v2_ref_bahagian`.id = `hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no`')
            ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id` = `hrm`.`elnpt_v2_ref_aspek_penilaian`.`id` AND `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid)
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->orderBy('`hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no`')
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
            ->select(['`hrm`.`elnpt_v2_ref_bahagian`.`id` as bhg_no', new Expression('\'0\' as mrkh_bhg')])
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->andWhere(['!=', '`hrm`.`elnpt_v2_ref_bahagian`.`id`', 12])
            ->orderBy('`hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $pyd = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_pyd) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->andWhere(['!=', 'a.bhg_no', 10])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('a.bhg_no')
            ->asArray()
            ->all();
        $pyd = ArrayHelper::index($pyd, 'bhg_no');
        $pyd = array_replace_recursive($arry, $pyd);

        $ppp = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_ppp) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $ppp = ArrayHelper::index($ppp, 'bhg_no');
        $ppp = array_replace_recursive($arry, $ppp);

        $ppk = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_ppk) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $ppk = ArrayHelper::index($ppk, 'bhg_no');
        $ppk = array_replace_recursive($arry, $ppk);

        $peer = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_peer) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $peer = ArrayHelper::index($peer, 'bhg_no');
        $peer = array_replace_recursive($arry, $peer);
        $this->calcOverallMark($lppid);
        $this->getMarkahKualiti($lppid, $mrkh_ppp, $mrkh_ppk, $mrkh_peer, $lpp, $gred, $dept, $fin);
        ArrayHelper::setValue($ppp, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($mrkh_ppp / 10)]);
        ArrayHelper::setValue($ppk, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($mrkh_ppk / 10)]);
        ArrayHelper::setValue($peer, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($mrkh_peer / 10)]);
        $markahAll = $markah->all();
        ArrayHelper::setValue($markahAll, [10], ['id' => '10', 'aspek' => 'Kualiti Peribadi', 'markah' => strval($fin * 10), 'warna' => '#cd29bd']);
        if ($lpp->PPP_sah == 0 and $lpp->PPK_sah == 0) {
            foreach ($markahAll as $ind => $ma) {
                $mar = $pyd[$ind]['mrkh_bhg'] / $query11[$ind]['pemberat'];
                $markahAll[$ind]['markah'] = (is_nan($mar) || is_null($mar)) ? 0 : $mar;
            }
        } else {
            foreach ($markahAll as $ind => $ma) {
                $mar = $ma['markah'];
                $markahAll[$ind]['markah'] = (is_nan($mar) || is_null($mar)) ? 0 : $mar;
            }
        }

        // ArrayHelper::setValue($query11, [10], ['bhg_id' => '10', 'pemberat' => strval(Yii::$app->formatter->asDecimal(3.75 + 8.25, 2))]);
        $mrkhSel = new TblMarkahKeseluruhan();
        $tmppp = array_map(
            function ($x, $y) {
                return $x * $y;
            },
            array_column($markahAll, 'markah'),
            array_column($query11, 'pemberat')
        );

        $total = $this->getTotalMark($lppid, $tmppp);
        return $this->render('ringkasan', [
            'lppid' => $lppid,
            'summary' => $subpro,
            'mrkh_all' => $mrkh_all,
            'markah' => $markahAll,
            'pemberat' => $query11,
            'menu' => $this->menu($lpp),
            // 'total' => array_sum(array_column($pyd, 'mrkh_bhg')) + intval($ppp[10]['mrkh_bhg']) + intval($ppk[10]['mrkh_bhg']),
            'total' => is_null($total) ? 0 : $total->markah,
            'kategori' => $mrkhSel->getKategori(array_sum(array_column($pyd, 'mrkh_bhg')) + intval($ppp[10]['mrkh_bhg']) + intval($ppk[10]['mrkh_bhg']) + intval($peer[10]['mrkh_bhg'])),
            'rankDept' => is_null($total) ? 0 : $total->rankByDept($lppid, $lpp->jfpiu, $lpp->tahun),
            'rankGred' => is_null($total) ? 0 : $total->rankByGred($lppid, $lpp->jfpiu, $lpp->gred_jawatan_id, $lpp->tahun),
            'rankWhole' => is_null($total) ? 0 : $total->rankAsWhole($lppid, $lpp->tahun),
            'pyd' => $pyd,
            'lpp' => $lpp,
            'ppp' => $ppp,
            'ppk' => $ppk,
            'peer' => $peer,
            'lpp' => $lpp,
        ]);
    }

    public function getTotalMark($lppid, $total_mrkh)
    {
        $total = TblMarkahKeseluruhan::findOne(['lpp_id' => $lppid]);
        if ($total == null) {
            $total = new TblMarkahKeseluruhan();
            $total->lpp_id = $lppid;
        }
        $total->markah_ppp = array_sum($total_mrkh) - $total_mrkh[9];
        $total->markah_ppk = array_sum($total_mrkh) - $total_mrkh[9];
        $total->markah_peer = $total_mrkh[9];
        $total->markah = array_sum($total_mrkh);
        $total->tarikh_kemaskini = new \yii\db\Expression('NOW()');
        $total->save(false);
        return $total;
    }

    public function actionSemakRingkasan($lppid)
    {
        if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
            $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->GenerateSamePPP($lppid);
        $dept = TblKumpDept::find()->where(['dept_id' => $lpp->deptGuru->sub_of ?? $lpp->jfpiu])->asArray()->all();
        $dept1 = ArrayHelper::getColumn($dept, 'ref_kump_dept_id');
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $tamat_dt = $tahun->pengisian_PYD_tamat;
        $hasJawatan = Tblrscoadminpost::find()->where(['ICNO' => $lpp->PYD, 'paymentStatus' => 1])->andWhere(['<>', 'flag', 3])->andWhere(['and', ['>', new Expression('TIMESTAMPDIFF(MONTH, start_date, \'' . \Yii::$app->formatter->asDate($tamat_dt, 'yyyy-MM-dd') . '\')'), 6], [
            '>=', new Expression('YEAR(end_date)'), $lpp->tahun
        ]])->orderBy(['end_date' => SORT_DESC])->limit(1)->exists();
        $gred = RefGred::find()->where(['kump_gred' => ($hasJawatan && (in_array('1', $dept1) || in_array('2', $dept1) || in_array('6', $dept1) || in_array('3', $dept1) || in_array('5', $dept1))) ? $this->checkJawatanDeptKump($lpp->gredGuru->gred, $lpp->jfpiu, $lpp->gredGuru->gred_skim) : $lpp->gredGuru->gred])->one();
        $ex = TblException2::findOne([$lpp->lpp_id]);
        if (!is_null($ex)) {
            $dept = TblKumpDept::find()->where(['id' => $ex->tbl_kump_dept_id])->asArray()->all();
            $gred = RefGred::findOne([$ex->ref_gred_id]);
        }
        $query11 = RefPemberatSeluruh::find()
            ->select(['tbl_kump_dept_id', 'pemberat', 'bahagian'])
            ->where(['tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'ref_gred_id' => $gred->id, 'year' => $lpp->tahun])
            ->orderBy(['bahagian' => SORT_ASC])
            ->indexBy('bahagian')
            ->asArray()
            ->all();
        $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid, $dept, $gred), [], false);
        $markah = (new \yii\db\Query())
            ->select(['`hrm`.`elnpt_v2_ref_bahagian`.`id` AS id', '`hrm`.`elnpt_v2_ref_bahagian`.`bahagian` AS aspek', '((COALESCE(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0.0) * 100) / `hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`pemberat`) as markah', '`hrm`.`elnpt_v2_ref_bahagian`.`bhg_color` AS warna'])
            ->from('`hrm`.`elnpt_v2_ref_bahagian`')
            ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` = `hrm`.`elnpt_v2_ref_bahagian`.`id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
            ->rightJoin('(SELECT DISTINCT bahagian FROM `hrm`.`elnpt_v2_ref_pemberat_keseluruhan`) a', 'a.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
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
                '`hrm`.`elnpt_v2_ref_aspek_penilaian`.`desc`', '`hrm`.`elnpt_v2_ref_aspek_penilaian`.`aspek`', '`hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no` as bhg_no', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor',
                'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) as markah_pyd', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 0) as markah_ppp', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, 0) as markah_ppk',
                'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, 0) as markah_peer', '`hrm`.`elnpt_v2_ref_bahagian`.`id` as idd'
            ])
            ->leftJoin('`hrm`.`elnpt_v2_ref_bahagian`', '`hrm`.`elnpt_v2_ref_bahagian`.id = `hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no`')
            ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id` = `hrm`.`elnpt_v2_ref_aspek_penilaian`.`id` AND `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid)
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->orderBy('`hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no`')
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
            ->select(['`hrm`.`elnpt_v2_ref_bahagian`.`id` as bhg_no', new Expression('\'0\' as mrkh_bhg')])
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->andWhere(['!=', '`hrm`.`elnpt_v2_ref_bahagian`.`id`', 12])
            ->orderBy('`hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $pyd = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_pyd) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->andWhere(['!=', 'a.bhg_no', 10])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('a.bhg_no')
            ->asArray()
            ->all();
        $pyd = ArrayHelper::index($pyd, 'bhg_no');
        $pyd = array_replace_recursive($arry, $pyd);

        $ppp = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_ppp) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $ppp = ArrayHelper::index($ppp, 'bhg_no');
        $ppp = array_replace_recursive($arry, $ppp);

        $ppk = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_ppk) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $ppk = ArrayHelper::index($ppk, 'bhg_no');
        $ppk = array_replace_recursive($arry, $ppk);

        $peer = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_peer) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $peer = ArrayHelper::index($peer, 'bhg_no');
        $peer = array_replace_recursive($arry, $peer);
        $this->calcOverallMark($lppid);
        $this->getMarkahKualiti($lppid, $mrkh_ppp, $mrkh_ppk, $mrkh_peer, $lpp, $gred, $dept, $fin);
        ArrayHelper::setValue($ppp, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($mrkh_ppp / 10)]);
        ArrayHelper::setValue($ppk, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($mrkh_ppk / 10)]);
        ArrayHelper::setValue($peer, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($mrkh_peer / 10)]);
        $markahAll = $markah->all();
        ArrayHelper::setValue($markahAll, [10], ['id' => '10', 'aspek' => 'Kualiti Peribadi', 'markah' => strval($fin * 10), 'warna' => '#cd29bd']);
        foreach ($markahAll as $ind => $ma) {
            $mar = $ma['markah'];
            $markahAll[$ind]['markah'] = (is_nan($mar) || is_null($mar)) ? 0 : $mar;
        }

        // ArrayHelper::setValue($query11, [10], ['bhg_id' => '10', 'pemberat' => strval(Yii::$app->formatter->asDecimal(3.75 + 8.25, 2))]);
        $tmppp = array_map(
            function ($x, $y) {
                return $x * $y;
            },
            array_column($markahAll, 'markah'),
            array_column($query11, 'pemberat')
        );

        $total = $this->getTotalMark($lppid, $tmppp);
        // $total = $this->getTotalMark($lppid, (array_sum(array_column($ppp, 'mrkh_bhg')) + array_sum(array_column($ppk, 'mrkh_bhg'))) / 2, intval($peer[10]['mrkh_bhg']));
        return $this->render('semak_ringkasan', [
            'lppid' => $lppid,
            'summary' => $subpro,
            'mrkh_all' => $mrkh_all,
            'markah' => $markahAll,
            'pemberat' => $query11,
            'menu' => $this->menu($lpp),
            'total' => is_null($total) ? 0 : $total->markah,
            'kategori' => is_null($total) ? '' : $total->kategori,
            'rankDept' => is_null($total) ? 0 : $total->rankByDept($lppid, $lpp->jfpiu, $lpp->tahun),
            'rankGred' => is_null($total) ? 0 : $total->rankByGred($lppid, $lpp->jfpiu, $lpp->gred_jawatan_id, $lpp->tahun),
            'rankWhole' => is_null($total) ? 0 : $total->rankAsWhole($lppid, $lpp->tahun),
            'pyd' => $pyd,
            'lpp' => $lpp,
            'ppp' => $ppp,
            'ppk' => $ppk,
            'peer' => $peer,
            'lpp' => $lpp,
        ]);
    }

    public function getMarkahKualiti($lppid, &$mrkh_ppp, &$mrkh_ppk, &$mrkh_peer, $lpp, $gred, $dept, &$final)
    {
        if ($waktu2 = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->all() != null) {
            $waktu2 = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->asArray()->all();
            $sum_ppp = 0;
            $sum_ppk = 0;
            $sum_peer = 0;
            // foreach ($waktu2 as $ind => $wk) {
            //     $sum_ppp += ($waktu2[$ind]['markah_ppp'] / 100) * 20;
            //     $sum_ppk += ($waktu2[$ind]['markah_ppk'] / 100) * 20;
            //     $sum_peer += ($waktu2[$ind]['markah_peer']) * (20 / 100);
            // }
            foreach ($waktu2 as $ind => $wk) {
                $sum_ppp += $waktu2[$ind]['markah_ppp'];
                $sum_ppk += $waktu2[$ind]['markah_ppk'];
                $sum_peer += $waktu2[$ind]['markah_peer'];
            }
            $sum_ppp = $sum_ppp / 600 * 100;
            $sum_ppk = $sum_ppk / 600 * 100;
            $sum_peer = $sum_peer / 600 * 100;
            $pmberat_bhg9 = RefPemberatSeluruh::find()
                ->where(['tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'ref_gred_id' => $gred->id, 'bahagian' => 10, 'year' => $lpp->tahun])
                ->one();
            $mrkh_ppp = ($sum_ppp * (($pmberat_bhg9->tbl_kump_dept_id == 3) ? 0.6 : 0.4));
            $mrkh_ppk = ($sum_ppk * (($pmberat_bhg9->tbl_kump_dept_id == 3) ? 0.6 : 0.4));
            $mrkh_peer = ($sum_peer * (($pmberat_bhg9->tbl_kump_dept_id == 3) ? 0.3 : 0.2));
            $total =  $mrkh_ppp +  $mrkh_ppk + $mrkh_peer;
            $final = ($pmberat_bhg9->tbl_kump_dept_id == 3) ? ((($total * 100) / ($pmberat_bhg9->pemberat * 100)) / 100) : (($total / 100) * $pmberat_bhg9->pemberat / 100);

            // $mrkh_ppp = $sum_ppp * (25 / 100) * ($pmberat_bhg9->pemberat / 100);
            // $mrkh_ppk = $sum_ppk * (55 / 100) * ($pmberat_bhg9->pemberat / 100);
            // $mrkh_peer = $sum_peer * (20 / 100 * ($pmberat_bhg9->pemberat / 100));
        }
    }

    public function findMarkahKeseluruhan($lppid, $dept, $gred)
    {
        $lpp = $this->findLpp($lppid);
        $query = RefBahagian::find()
            ->select(['`hrm`.`elnpt_v2_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_v2_ref_bahagian`.`id`', '`hrm`.`elnpt_v2_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
            ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_v2_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
            ->rightJoin('(SELECT DISTINCT bahagian FROM `hrm`.`elnpt_v2_ref_pemberat_keseluruhan`) a', 'a.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->orderBy('`hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->asArray()
            ->all();
        return $query;
    }

    public function actionSemakLpp($lppid, $bhg_no)
    {
        $nama = RefBahagian::findOne($bhg_no);
        if ($nama == null || $nama->id < 1 || $nama->id > 11) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
            $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $tahun = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();
        $dept = TblKumpDept::find()->where(['dept_id' => $lpp->deptGuru->sub_of ?? $lpp->jfpiu])->asArray()->all();
        $dept1 = ArrayHelper::getColumn($dept, 'ref_kump_dept_id');
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $tamat_dt = $tahun->pengisian_PYD_tamat;
        $hasJawatan = Tblrscoadminpost::find()->where(['ICNO' => $lpp->PYD, 'paymentStatus' => 1])->andWhere(['<>', 'flag', 3])->andWhere(['and', ['>', new Expression('TIMESTAMPDIFF(MONTH, start_date, \'' . \Yii::$app->formatter->asDate($tamat_dt, 'yyyy-MM-dd') . '\')'), 6], [
            '>=', new Expression('YEAR(end_date)'), $lpp->tahun
        ]])->orderBy(['end_date' => SORT_DESC])->limit(1)->exists();
        $gred = RefGred::find()->where(['kump_gred' => ($hasJawatan && (in_array('1', $dept1) || in_array('2', $dept1) || in_array('6', $dept1) || in_array('3', $dept1) || in_array('5', $dept1))) ? $this->checkJawatanDeptKump($lpp->gredGuru->gred, $lpp->jfpiu, $lpp->gredGuru->gred_skim) : $lpp->gredGuru->gred])->one();
        $ex = TblException2::findOne([$lpp->lpp_id]);
        if (!is_null($ex)) {
            $dept = TblKumpDept::find()->where(['id' => $ex->tbl_kump_dept_id])->asArray()->all();
            $gred = RefGred::findOne([$ex->ref_gred_id]);
        }
        $mrkh_seluruh = RefBahagian::find()
            ->select(['`hrm`.`elnpt_v2_ref_bahagian`.`bhg_kod`', '`hrm`.`elnpt_v2_ref_bahagian`.`id`', '`hrm`.`elnpt_v2_ref_bahagian`.`bahagian`', 'coalesce(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0) as markah'])
            ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_v2_ref_bahagian`.`id` = `hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
            ->rightJoin('(SELECT DISTINCT bhg_id FROM `hrm`.`elnpt_tbl_pemberat_bhg`) a', 'a.`bhg_id` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id])
            ->orderBy('`hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->indexBy('id')
            ->asArray()
            ->all();
        $mrkh_bhg_pemberat = RefPemberatSeluruh::find()
            ->select(['pemberat', 'bahagian as bhg_id'])
            ->where(['tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'ref_gred_id' => $gred->id, 'year' => $lpp->tahun])
            ->indexBy(['bhg_id'])
            ->orderBy(['bhg_id' => SORT_ASC])
            ->asArray()
            ->all();
        $mrkh_all = \yii\helpers\ArrayHelper::toArray($mrkh_seluruh, [], false);
        $subpro1 = RefAspekPenilaian::findAll(['bhg_no' => $bhg_no]);
        $dataProvider = null;
        switch ($bhg_no) {
            case 1:
                if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
                    throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                }
                $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 1])->asArray()->all();
                $aspek = RefAspekPenilaian::findAll(['bhg_no' => 1]);
                $pemberat = RefAspekPemberat::find()->where(['bahagian' => 1])->asArray()->all();
                $this->dataBahagian1($lppid, $pengajaran, $pengajaran2, $waktu, $all);
                $f2f = RefSkorF2f::find()->asArray()->all();
                $data = $pengajaran + $pengajaran2;
                $data1 = ArrayHelper::toArray($waktu, []);
                foreach ($data1 as $ind => $p) {
                    foreach (array_reverse($f2f) as $f) {
                        if (($p['bil_pelajar'] ?? 0) >= $f['min_pelajar'] && ($p['status_kursus'] ?? '') >= 'HAKIKI') {
                            $syarahan = $f['syarahan'] * ($p['jam_syarahan']);
                            $tutorial = $f['tutorial'] * ($p['jam_tutorial']);
                            $amali = $f['amali'] * ($p['jam_amali']);
                            ArrayHelper::setValue($bks_arry, $ind, ['syarahan' => $syarahan, 'tutorial' => $tutorial, 'amali' => $amali, 'bks' =>  is_null($data[$ind]['ver_by']) ? 0 : (($syarahan + $amali + $tutorial) / 14)]);
                            break;
                        }
                    }
                }
                $dataProvider = new ArrayDataProvider([
                    'allModels' => $all,
                    'sort' => [
                        'attributes' => ['sumber', 'fullname'],
                    ],
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                ]);
                foreach (array_filter($data, function ($var) {
                    return (isset($var['ver_by']) ? $var['ver_by'] != '' : null);
                }) as $ind => $p) {
                    foreach ($aspek_skor as $as) {
                        if ($as['aspek_id'] == 3) {
                            if (strcasecmp($p['status'], $as['desc']) == 0) {
                                ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                            }
                        }
                    }
                    foreach (array_reverse($aspek_skor) as $as) {
                        if ($as['aspek_id'] == 2) {

                            if ($p['pk07'] >= floatval($as['desc'])) {

                                ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                                break;
                            }
                        }
                    }
                    foreach (array_reverse($aspek_skor) as $as) {
                        if ($as['aspek_id'] == 4) {
                            if (strcasecmp($p['status_fail'], $as['desc']) == 0) {
                                ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                            }
                        }
                    }
                }
                $bks = isset($bks_arry) ? array_sum(ArrayHelper::getColumn($bks_arry, 'bks')) : 0;
                ArrayHelper::setValue($tmp, 1, $bks);
                ArrayHelper::setValue($tmp, 2, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['2', 'skor'], $keepKeys = true)) : 0);
                ArrayHelper::setValue($tmp, 3, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['3', 'skor'], $keepKeys = true)) : 0);
                ArrayHelper::setValue($tmp, 4, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['4', 'skor'], $keepKeys = true)) : 0);

                foreach ($tmp as $ind => $t) {
                    foreach ($aspek as $a) {
                        if ($a->id == $ind) {
                            foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred, 1, $lpp->deptGuru->sub_of ?? $lpp->jfpiu, $lpp->PYD)->all()) as $ap) {
                                if ($t >= $ap['min_skor']) {
                                    ArrayHelper::setValue($peratus, $a->id, ['skor' => $t, 'peratus' => $ap['peratus']]);
                                    break;
                                }
                            }
                            break;
                        }
                    }
                }

                foreach ($pemberat as $p) {
                    if (empty($peratus[$p['aspek_id']]))
                        continue;
                    ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], [
                        'skor' => $peratus[$p['aspek_id']]['skor'], 'markah_ppp' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_ppk' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_peer' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100
                    ]);
                }

                $this->setMarkahAspek($lppid, array_key_first($mrkh_bhg), $mrkh_bhg, 1);
                break;
            case 2:
                if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
                    throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                }
                $skor = RefSkorPenyeliaan::find()->asArray()->all();
                $aspek = RefAspekPenilaian::findAll(['bhg_no' => 2]);
                $pemberat = RefAspekPemberat::find()->where(['bahagian' => 2])->asArray()->all();
                $mrkh_bhg = array();
                $mrkhbhg = array();
                $peratus = array();
                $this->dataBahagian2($lppid, $data, $waktu, $utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
                $tmp = array_merge_recursive($utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
                foreach ($tmp as $id => $t) {
                    ArrayHelper::setValue($tmpP, [$id, 'utama_belum'], is_array($tmp[$id]['utama_belum']) ? array_sum($tmp[$id]['utama_belum']) : $tmp[$id]['utama_belum']);
                    ArrayHelper::setValue($tmpP, [$id, 'utama_telah_sem'], is_array($tmp[$id]['utama_telah_sem']) ? array_sum($tmp[$id]['utama_telah_sem']) : $tmp[$id]['utama_telah_sem']);
                    ArrayHelper::setValue($tmpP, [$id, 'utama_telah'], is_array($tmp[$id]['utama_telah']) ? array_sum($tmp[$id]['utama_telah']) : $tmp[$id]['utama_telah']);
                    ArrayHelper::setValue($tmpP, [$id, 'sama_belum'], is_array($tmp[$id]['sama_belum']) ? array_sum($tmp[$id]['sama_belum']) : $tmp[$id]['sama_belum']);
                    ArrayHelper::setValue($tmpP, [$id, 'sama_telah_sem'], is_array($tmp[$id]['sama_telah_sem']) ? array_sum($tmp[$id]['sama_telah_sem']) : $tmp[$id]['sama_telah_sem']);
                    ArrayHelper::setValue($tmpP, [$id, 'sama_telah'], is_array($tmp[$id]['sama_telah']) ? array_sum($tmp[$id]['sama_telah']) : $tmp[$id]['sama_telah']);
                }
                $selia_arry = ArrayHelper::toArray($waktu);

                if (!empty($selia_arry[0])) {

                    $selia_arry = array_filter($selia_arry, function ($var) {
                        return ($var['verified_by'] != '');
                    });
                }
                foreach ($tmpP as $id => $tP) {
                    switch ($id) {
                        case 'MASTER':
                            $tP['tahap_penyeliaan'] = 2;
                            break;
                        case 'PHD':
                            $tP['tahap_penyeliaan'] = 1;
                            break;
                        case 'M.Phil.':
                            $tP['tahap_penyeliaan'] = 3;
                            break;
                    }
                    array_push($selia_arry, $tP);
                }
                foreach ($selia_arry as $sa) {
                    foreach ($skor as $s) {
                        if (($sa['tahap_penyeliaan'] ?? -1) == $s['id']) {
                            $sum = ($sa['utama_belum'] * $s['belum_utama']) + ($sa['utama_telah_sem'] * $s['telah_utama_sem']) + ($sa['utama_telah'] * $s['telah_utama']) + ($sa['sama_belum'] * $s['belum_sama']) + ($sa['sama_telah_sem'] * $s['telah_sama_sem']) + ($sa['sama_telah'] * $s['telah_sama']);
                            ArrayHelper::setValue($mrkhbhg, $sa['tahap_penyeliaan'], ['skor' => $sum]);
                            break;
                        }
                    }
                }
                foreach ($aspek as $a) {
                    // if ($a->id == $ind) {
                    foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred)->all()) as $ap) {
                        if (array_sum(ArrayHelper::getColumn($mrkhbhg, 'skor')) >= $ap['min_skor']) {
                            ArrayHelper::setValue($peratus, $a->id, ['skor' => array_sum(ArrayHelper::getColumn($mrkhbhg, 'skor')), 'peratus' => $ap['peratus']]);
                            break;
                        }
                    }
                    break;
                    // }
                }
                foreach ($pemberat as $p) {
                    if (empty($peratus[$p['aspek_id']]))
                        continue;
                    ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], [
                        'skor' => $peratus[$p['aspek_id']]['skor'], 'markah_ppp' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_ppk' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_peer' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100
                    ]);
                }
                if (Model::loadMultiple($waktu, Yii::$app->request->post())) {
                    $valid =  Model::validateMultiple($waktu);
                    if ($valid) {
                        $transaction = \Yii::$app->db->beginTransaction();
                        try {
                            $cnt = 4;
                            foreach ($waktu as $ind => $wk) {
                                $wk->lpp_id = $lppid;
                                $wk->tahap_penyeliaan = $cnt;
                                if ($wk->verified_by == 0) {
                                    $wk->verified_by = null;
                                } else {
                                    $wk->verified_by = $lpp->PPP;
                                    $wk->verified_dt = new \yii\db\Expression('NOW()');
                                }
                                if (!($flag = $wk->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                                $cnt++;
                            }
                            if ($flag) {
                                $transaction->commit();
                                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                                return $this->redirect(['semak-lpp', 'lppid' => $lppid, 'bhg_no' => $bhg_no]);
                            }
                        } catch (Exception $e) {
                            $transaction->rollBack();
                        }
                    }
                }
                $dataProvider = new ActiveDataProvider([
                    'query' => $data,
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                ]);
                $data = $tmpP;
                $this->setMarkahAspek($lppid, 5, $mrkh_bhg, 2);
                break;
            case 3:
                if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
                    throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                }
                $pemberat = RefAspekPemberat::find()->where(['bahagian' => 3])->asArray()->all();
                $this->dataBahagian3($lppid, $penyelidikan, $penyelidikan2, $grant);
                $data = array_merge($penyelidikan, $penyelidikan2);
                $waktu = null;
                break;
            case 4:
                if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
                    throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                }
                $pemberat = RefAspekPemberat::find()->where(['bahagian' => 4])->asArray()->all();
                $this->dataBahagian4($lppid, $data);
                $waktu = null;
                break;
            case 5:
                if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
                    throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                }
                $pemberat = RefAspekPemberat::find()->where(['bahagian' => 5])->asArray()->all();
                $this->dataBahagian5($lppid, $data, $persidangan);
                $waktu = null;
                break;
            case 6:
                if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
                    throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                }
                $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 6])->asArray()->all();
                $aspek = RefAspekPenilaian::findAll(['bhg_no' => 6]);
                $pemberat = RefAspekPemberat::find()->where(['bahagian' => 6])->asArray()->all();
                $this->dataBahagian6($lppid, $conference, $manual, $manual2);
                $data = array_merge($conference, $manual2);
                $waktu = null;
                foreach (array_filter($data, function ($var) {
                    return ($var['ver_by'] != '');
                })  as $ind => $tp) {
                    foreach ($aspek_skor as $as) {
                        if ($as['aspek_id'] == 18) {
                            if ($tp['Bilangan_outreaching'] >= $as['desc']) {
                                ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                            }
                        }
                        if ($as['aspek_id'] == 19) {
                            if (strcasecmp($tp['Peranan_outreaching'], $as['desc']) == 0) {
                                ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                            }
                        }
                        if ($as['aspek_id'] == 20) {
                            if (strcasecmp($tp['Tahap_outreaching'], $as['desc']) == 0) {
                                ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                            }
                        }
                    }
                }
                foreach (array_reverse($aspek_skor) as $as) {
                    if ($as['aspek_id'] == 21) {
                        if (array_sum(ArrayHelper::getColumn(array_filter($data, function ($var) {
                            return ($var['ver_by'] != '');
                        }), 'Amaun_outreaching')) >= floatval($as['desc'])) {
                            ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                            break;
                        }
                    }
                }

                ArrayHelper::setValue($tmp, 18, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['18', 'skor'], $keepKeys = true)) : 0);
                ArrayHelper::setValue($tmp, 19, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['19', 'skor'], $keepKeys = true)) : 0);
                ArrayHelper::setValue($tmp, 20, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['20', 'skor'], $keepKeys = true)) : 0);
                ArrayHelper::setValue($tmp, 21, isset($skor) ? max(ArrayHelper::getColumn($skor, ['21', 'skor'], $keepKeys = true)) : 0);

                foreach ($tmp as $ind => $t) {
                    foreach ($aspek as $a) {
                        if ($a->id == $ind) {
                            foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred)->all()) as $ap) {
                                if ($t >= $ap['min_skor']) {
                                    ArrayHelper::setValue($peratus, $a->id, ['skor' => $t, 'peratus' => $ap['peratus']]);
                                    break;
                                }
                            }
                            break;
                        }
                    }
                }
                foreach ($pemberat as $p) {
                    if (empty($peratus[$p['aspek_id']]))
                        continue;
                    ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], [
                        'skor' => $peratus[$p['aspek_id']]['skor'], 'markah_ppp' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_ppk' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_peer' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100
                    ]);
                }
                $this->setMarkahAspek($lppid, 18, $mrkh_bhg, 6);
                break;
            case 7:
                if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
                    throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                }
                $this->dataBahagian7($lppid, $urus_tadbir, $result);
                $data = array_merge($urus_tadbir, $result);
                $waktu = null;
                $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 7])->asArray()->all();
                $aspek = RefAspekPenilaian::findAll(['bhg_no' => 7]);
                $pemberat = RefAspekPemberat::find()->where(['bahagian' => 7])->asArray()->all();
                foreach (array_filter($data, function ($var) {
                    return ($var['ver_by'] != '');
                })  as $ind => $tp) {
                    foreach ($aspek_skor as $as) {
                        if ($as['aspek_id'] == 22) {
                            if (strcasecmp($tp['Bilangan_jawatankuasa'], $as['desc']) == 0) {
                                ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                            }
                        }
                        if ($as['aspek_id'] == 23) {
                            if (strcasecmp($tp['Peranan_jawatankuasa'], $as['desc']) == 0) {
                                ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                            }
                        }
                        if ($as['aspek_id'] == 24) {
                            if (strcasecmp($tp['Tahap_jawatankuasa'], $as['desc']) == 0) {
                                ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                            }
                        }
                    }
                }

                ArrayHelper::setValue($tmp, 22, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['22', 'skor'], $keepKeys = true)) : 0);
                ArrayHelper::setValue($tmp, 23, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['23', 'skor'], $keepKeys = true)) : 0);
                ArrayHelper::setValue($tmp, 24, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['24', 'skor'], $keepKeys = true)) : 0);

                foreach ($tmp as $ind => $t) {
                    foreach ($aspek as $a) {
                        if ($a->id == $ind) {
                            foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred)->all()) as $ap) {
                                if ($t >= $ap['min_skor']) {
                                    ArrayHelper::setValue($peratus, $a->id, ['skor' => $t, 'peratus' => $ap['peratus']]);
                                    break;
                                }
                            }
                            break;
                        }
                    }
                }
                foreach ($pemberat as $p) {
                    if (empty($peratus[$p['aspek_id']]))
                        continue;
                    ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], [
                        'skor' => $peratus[$p['aspek_id']]['skor'], 'markah_ppp' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_ppk' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_peer' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100
                    ]);
                }
                $this->setMarkahAspek($lppid, 22, $mrkh_bhg, 7);
                break;
            case 8:
                if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
                    throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                }
                $this->dataBahagian8($lppid, $pereka, $inovasi, $teknologi);
                $data = array_merge($pereka, $inovasi, $teknologi);
                $waktu = null;
                $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 8])->asArray()->all();
                $aspek = RefAspekPenilaian::findAll(['bhg_no' => 8]);
                $pemberat = RefAspekPemberat::find()->where(['bahagian' => 8])->asArray()->all();
                foreach (array_filter($data, function ($var) {
                    return ($var['ver_by'] != '');
                })  as $ind => $tp) {
                    foreach ($aspek_skor as $as) {
                        if ($as['aspek_id'] == 25) {
                            if (strcasecmp($tp['Bilangan_Persidangan_dan_Inovasi'], $as['desc']) == 0) {
                                ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                            }
                        }
                        if ($as['aspek_id'] == 26) {
                            if (strcasecmp($tp['Peranan_dalam_projek_Inovasi'], $as['desc']) == 0) {
                                ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                            }
                        }
                        if ($as['aspek_id'] == 27) {
                            if (strcasecmp($tp['Tahap_penyertaan'], $as['desc']) == 0) {
                                ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                            }
                        }
                    }
                }
                $arryGroup = ArrayHelper::index($aspek_skor, null, 'aspek_id');
                foreach (array_reverse($arryGroup['28']) as $as) {
                    if (array_sum(ArrayHelper::getColumn(array_filter($data, function ($var) {
                        return ($var['ver_by'] != '');
                    }), 'Bilangan_individu')) >= floatval($as['desc'])) {
                        ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                        break;
                    }
                }
                foreach (array_reverse($arryGroup['29']) as $as) {
                    if (array_sum(ArrayHelper::getColumn(array_filter($data, function ($var) {
                        return ($var['ver_by'] != '');
                    }), 'Julat_amaun')) >= floatval($as['desc'])) {
                        ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                        break;
                    }
                }

                ArrayHelper::setValue($tmp, 25, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['25', 'skor'], $keepKeys = true)) : 0);
                ArrayHelper::setValue($tmp, 26, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['26', 'skor'], $keepKeys = true)) : 0);
                ArrayHelper::setValue($tmp, 27, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['27', 'skor'], $keepKeys = true)) : 0);
                ArrayHelper::setValue($tmp, 28, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['28', 'skor'], $keepKeys = true)) : 0);
                ArrayHelper::setValue($tmp, 29, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['29', 'skor'], $keepKeys = true)) : 0);

                foreach ($tmp as $ind => $t) {
                    foreach ($aspek as $a) {
                        if ($a->id == $ind) {
                            foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred)->all()) as $ap) {
                                if ($t >= $ap['min_skor']) {
                                    ArrayHelper::setValue($peratus, $a->id, ['skor' => $t, 'peratus' => $ap['peratus']]);
                                    break;
                                }
                            }
                            break;
                        }
                    }
                }
                foreach ($pemberat as $p) {
                    if (empty($peratus[$p['aspek_id']]))
                        continue;
                    ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], [
                        'skor' => $peratus[$p['aspek_id']]['skor'], 'markah_ppp' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_ppk' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_peer' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100
                    ]);
                }
                $this->setMarkahAspek($lppid, 25, $mrkh_bhg, 8);
                break;
            case 9:
                if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
                    throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                }
                $this->dataBahagian9($lppid, $bil_bhg2, $bil_bhg3, $bil_bhg4, $bil_bhg5, $bil_bhg6, $bil_bhg8);
                $waktu = null;

                $bil_mentoring = ($bil_bhg2 * 0.3) + ($bil_bhg3 * 0.3) + ($bil_bhg4 * 0.4);
                $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 9])->asArray()->all();
                $aspek = RefAspekPenilaian::find()->where(['bhg_no' => 9])->asArray()->indexBy('id')->all();
                $pemberat = RefAspekPemberat::find()->where(['bahagian' => 9])->asArray()->all();
                // foreach ($list as $ind => $tp) {
                //     foreach ($aspek_skor as $as) {
                //         if ($as['aspek_id'] == 25) {
                //             if (strcasecmp($tp['Bilangan_Persidangan_dan_Inovasi'], $as['desc']) == 0) {
                //                 ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                //             }
                //         }
                //         if ($as['aspek_id'] == 26) {
                //             if (strcasecmp($tp['Peranan_dalam_projek_Inovasi'], $as['desc']) == 0) {
                //                 ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                //             }
                //         }
                //         if ($as['aspek_id'] == 27) {
                //             if (strcasecmp($tp['Tahap_penyertaan'], $as['desc']) == 0) {
                //                 ArrayHelper::setValue($skor, [$ind, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                //             }
                //         }
                //     }
                // }
                // !isset($peratusGred) ? 0 : $peratusGred
                switch (true) {
                    case $lpp->gredGuru->gred == 'DG41':
                    case $lpp->gredGuru->gred == 'DG44':
                        $pemberat[0]['pemberat'] = 0;
                        $pemberat[1]['pemberat'] = 0;
                        $pemberat[2]['pemberat'] = 0.0;
                        $pemberat[3]['pemberat'] = 0.5;
                        $pemberat[4]['pemberat'] = 0.5;
                        $pemberat[5]['pemberat'] = 0.05;
                        $pemberat[6]['pemberat'] = 0.05;
                        break;
                    case $lpp->gredGuru->gred == 'DG48':
                        $pemberat[0]['pemberat'] = 0;
                        $pemberat[1]['pemberat'] = 0.25;
                        $pemberat[2]['pemberat'] = 0.25;
                        $pemberat[3]['pemberat'] = 0.25;
                        $pemberat[4]['pemberat'] = 0.25;
                        $pemberat[5]['pemberat'] = 0.05;
                        $pemberat[6]['pemberat'] = 0.05;
                        break;
                }
                switch (true) {
                    case $lpp->gredGuru->gred == 'DS45':
                        $peratusGred = 20;
                        $terpakai = false;
                        break;
                    case $lpp->gredGuru->gred == 'DG41':
                    case $lpp->gredGuru->gred == 'DG44':
                        $peratusGred = 20;
                        $terpakai = false;
                        break;
                    case $lpp->gredGuru->gred == 'DG48':
                        $peratusGred = 10;
                        $terpakai = false;
                        break;
                    case $lpp->gredGuru->gred == 'DS51':
                    case $lpp->gredGuru->gred == 'DS52':
                    case $lpp->gredGuru->gred == 'DG52':
                    case $lpp->gredGuru->gred == 'DU51':
                    case $lpp->gredGuru->gred == 'DU52':
                        $peratusGred = 10;
                        $terpakai = false;
                        break;
                    case $lpp->gredGuru->gred == 'DS53':
                    case $lpp->gredGuru->gred == 'DS54':
                    case $lpp->gredGuru->gred == 'DG54':
                    case $lpp->gredGuru->gred == 'DU54':
                    case $lpp->gredGuru->gred == 'DU56':
                    case $lpp->gredGuru->gred == 'UMSDF8':
                        $peratusGred = 10;
                        $terpakai = true;
                        break;
                    default:
                        $peratusGred = 0;
                        $terpakai = true;
                }
                $arryGroup = ArrayHelper::index($aspek_skor, null, 'aspek_id');
                foreach (array_reverse($arryGroup['30']) as $as) {
                    if ($bil_bhg2 >= floatval($as['desc'])) {
                        ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + $peratusGred)]);
                        break;
                    }
                }
                foreach (array_reverse($arryGroup['31']) as $as) {
                    if ($bil_bhg3 >= floatval($as['desc'])) {
                        ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + $peratusGred)]);
                        break;
                    }
                }
                foreach (array_reverse($arryGroup['32']) as $as) {
                    if ($bil_bhg4 >= floatval($as['desc'])) {
                        ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + $peratusGred)]);
                        break;
                    }
                }
                foreach (array_reverse($arryGroup['33']) as $as) {
                    if ($bil_bhg5 >= floatval($as['desc'])) {
                        ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + $peratusGred)]);
                        break;
                    }
                }
                foreach (array_reverse($arryGroup['34']) as $as) {
                    if ($bil_bhg6 >= floatval($as['desc'])) {
                        ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + $peratusGred)]);
                        break;
                    }
                }
                foreach (array_reverse($arryGroup['35']) as $as) {
                    if ($bil_bhg8 >= floatval($as['desc'])) {
                        ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + $peratusGred)]);
                        break;
                    }
                }
                foreach (array_reverse($arryGroup['36']) as $as) {
                    if ($bil_mentoring >= intval($as['desc'])) {
                        ($terpakai) ? ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]) : ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => 0]);
                        break;
                    }
                }

                ArrayHelper::setValue($tmp, 30, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['30', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg2, 'desc' => $aspek[30]['desc'], 'sumber' => 'Bahagian 2']);
                ArrayHelper::setValue($tmp, 31, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['31', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg3, 'desc' => $aspek[31]['desc'], 'sumber' => 'Bahagian 3']);
                ArrayHelper::setValue($tmp, 32, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['32', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg4, 'desc' => $aspek[32]['desc'], 'sumber' => 'Bahagian 4']);
                ArrayHelper::setValue($tmp, 33, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['33', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg5, 'desc' => $aspek[33]['desc'], 'sumber' => 'Bahagian 5']);
                ArrayHelper::setValue($tmp, 34, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['34', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg6, 'desc' => $aspek[34]['desc'], 'sumber' => 'Bahagian 6']);
                ArrayHelper::setValue($tmp, 35, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['35', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg8, 'desc' => $aspek[35]['desc'], 'sumber' => 'Bahagian 8']);
                ArrayHelper::setValue($tmp, 36, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['36', 'skor'], $keepKeys = true)) : 0, 'bilangan' => (round($bil_mentoring)), 'desc' => $aspek[36]['desc'], 'sumber' => 'Bahagian 2, 3 & 4']);

                $data = $tmp;
                foreach ($tmp as $ind => $t) {
                    // foreach ($aspek as $a) {
                    //     if ($a->id == $ind) {
                    //         foreach (array_reverse($a->peratus) as $ap) {
                    //             if ($t >= $ap['min_skor']) {
                    ArrayHelper::setValue($peratus, $ind, ['skor' => $t['skor'], 'peratus' => $t['skor'] * 100]);
                    // break;
                    //             }
                    //         }
                    //         break;
                    //     }
                    // }
                }
                foreach ($pemberat as $p) {
                    if (empty($peratus[$p['aspek_id']]))
                        continue;
                    ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], [
                        'skor' => $peratus[$p['aspek_id']]['skor'], 'markah_ppp' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_ppk' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_peer' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100
                    ]);
                }

                $this->setMarkahAspek($lppid, 30, $mrkh_bhg, 9);
                break;
            case 10:
                $data = RefAspekPenilaian::find()->where(['bhg_no' => 10])->indexBy('id')->asArray()->all();
                $pemberat = RefAspekPemberat::find()->where(['bahagian' => 10])->asArray()->all();
                $peratus = RefAspekPeratus::find()->where(['bahagian' => 10])->asArray()->all();
                $list = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->asArray()->all();

                $tmpp = [];
                if ($waktu = TblMarkahKualiti::findAll(['lpp_id' => $lppid]) != null) {
                    $waktu = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->all();
                    $tmpp = ArrayHelper::toArray($waktu);
                } else {
                    $waktu = [new TblMarkahKualiti()];
                    $cnt = 0;
                    foreach ($data as $ind => $a) {
                        $waktu[$cnt] = new TblMarkahKualiti();
                        $waktu[$cnt]->ref_kualiti_id = $ind;
                        $cnt++;
                    }
                }
                ksort($waktu);
                if (Model::loadMultiple($waktu, Yii::$app->request->post()) && Model::validateMultiple($waktu)) {
                    foreach ($waktu as $mk) {
                        $mk->lpp_id = $lppid;
                        $mk->save(false);
                    }
                    \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                    return $this->redirect(Yii::$app->request->referrer);
                }

                foreach ($pemberat as $p) {
                    if (empty($tmpp[$p['aspek_id']]))
                        continue;
                    ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], [
                        'skor' => 0,
                        'markah_ppp' => ($tmpp[$p['aspek_id']]['markah_ppp'] * $p['pemberat']) / 100,
                        'markah_ppk' => ($tmpp[$p['aspek_id']]['markah_ppk'] * $p['pemberat']) / 100,
                        'markah_peer' => ($tmpp[$p['aspek_id']]['markah_peer'] * $p['pemberat']) / 100,
                    ]);
                }

                if (isset($mrkh_bhg))
                    $this->setMarkahAspek($lppid, 37, $mrkh_bhg, 10);
                // $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(10, $lppid), [], false);
                break;
            case 11:
                if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
                    throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                }
                $this->dataBahagian11($lppid, $waktu, $clinic);
                if ($waktu->load(Yii::$app->request->post())) {
                    $waktu->lpp_id = $lppid;
                    if ($waktu->save()) {
                        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya ditambah!']);
                        return $this->redirect(['elnpt2/semak-lpp', 'lppid' => $lppid, 'bhg_no' => $bhg_no]);
                    }
                }
                $data = ArrayHelper::toArray($waktu, [
                    'app\models\elnpt\perkhidmatan_klinikal\TblKlinikal' => [
                        'cbt' => function ($klinikal) {
                            return $klinikal->cbt ?? 0;
                        },
                        // 'apc' => function ($klinikal) {
                        //     return $klinikal->apc ?? 0;
                        // },
                        'apc' => function ($klinikal) use ($clinic) {
                            return $clinic ? 1 : 0;
                        },
                        'clinic_consult' => function ($klinikal) {
                            return $klinikal->clinic_consult ?? 0;
                        }
                    ],
                ]);
                // $url_create = Url::to(['elnpt2/create-urus-tadbir', 'lppid' => $lppid]);

                $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 11])->asArray()->all();
                $aspek = RefAspekPenilaian::findAll(['bhg_no' => 11]);
                $pemberat = RefAspekPemberat::find()->where(['bahagian' => 11])->asArray()->all();
                foreach ($aspek_skor as $as) {
                    if ($as['aspek_id'] == 43) {
                        if (floatval($data['clinic_consult']) >= floatval($as['desc'])) {
                            ArrayHelper::setValue($skor, [43, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                        }
                    }
                    if ($as['aspek_id'] == 44) {
                        if ($data['cbt'] >= $as['desc']) {
                            ArrayHelper::setValue($skor, [44, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                        }
                    }
                    if ($as['aspek_id'] == 45) {
                        if (strcasecmp(($data['apc'] == 1) ? 'Ya' : 'Tidak', $as['desc']) == 0) {
                            ArrayHelper::setValue($skor, [45, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                        }
                    }
                }
                // $arryGroup = ArrayHelper::index($aspek_skor, null, 'aspek_id');
                // foreach (array_reverse($arryGroup['28']) as $as) {
                //     if (array_sum(ArrayHelper::getColumn($list, 'Bilangan_individu')) >= floatval($as['desc'])) {
                //         ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                //         break;
                //     }
                // }
                // foreach (array_reverse($arryGroup['29']) as $as) {
                //     if (array_sum(ArrayHelper::getColumn($list, 'Julat_amaun')) >= floatval($as['desc'])) {
                //         ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor'])]);
                //         break;
                //     }
                // }

                ArrayHelper::setValue($tmp, 43, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['43', 'skor'], $keepKeys = true)) : 0);
                ArrayHelper::setValue($tmp, 44, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['44', 'skor'], $keepKeys = true)) : 0);
                ArrayHelper::setValue($tmp, 45, isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['45', 'skor'], $keepKeys = true)) : 0);

                foreach ($tmp as $ind => $t) {
                    foreach ($aspek as $a) {
                        if ($a->id == $ind) {
                            foreach (array_reverse($a->getPeratus($lpp->gredGuru->gred, 11)->all()) as $ap) {
                                if ($t >= $ap['min_skor']) {
                                    ArrayHelper::setValue($peratus, $a->id, ['skor' => $t, 'peratus' => $ap['peratus']]);
                                    break;
                                }
                            }
                            break;
                        }
                    }
                }

                foreach ($pemberat as $p) {
                    if (empty($peratus[$p['aspek_id']]))
                        continue;
                    ArrayHelper::setValue($mrkh_bhg, $p['aspek_id'], [
                        'skor' => $peratus[$p['aspek_id']]['skor'], 'markah_ppp' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_ppk' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100, 'markah_peer' => ($peratus[$p['aspek_id']]['peratus'] * $p['pemberat']) / 100
                    ]);
                }

                $this->setMarkahAspek($lppid, 43, $mrkh_bhg, 11);
                // $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(11, $lppid), [], false);
                break;
        }
        $mrkhBhg = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian($bhg_no, $lppid, $pemberat ?? null), [], false);
        // foreach ($mrkhBhg as $ind => $mb) {
        //     $mrkhBhg[$ind]['pemberat'] =  number_format($pemberat[$ind]['pemberat'] * 100, 2);
        // }
        $this->calcOverallMark($lppid);
        return $this->render('semak_bahagian', [
            'lppid' => $lppid,
            'data' => isset($data) ? $data : null,
            'data2' => $dataProvider,
            'input' => $waktu,
            'ruberik' => $subpro1,
            'mrkh_all' => $mrkh_all,
            'pemberat' => $mrkh_bhg_pemberat,
            'mrkh_bhg' => $mrkhBhg,
            'bahagian' => $nama,
            'menu' => $this->menu($lpp),
            'lpp' => $lpp,
            'tahun' => $tahun,
            'req' => $this->checkRequest($lppid),
            'gred_no' =>  $lpp->gredGuru->gred,
            'dataProvider' => isset($dataProvider) ?  $dataProvider : null,
            'check' => $this->checkEligible($lpp),
        ]);
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

    public function getTahun($lpp_id)
    {
        if (($lpp = TblMain::findOne(['lpp_id' => $lpp_id])) != null) {
            $lpp = TblMain::findOne(['lpp_id' => $lpp_id]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $lpp->tahun;
    }

    public function addDocument($doc, $lppid, $bhg_no, $id_table)
    {
        $doc->file = UploadedFile::getInstance($doc, 'file');
        // $tmp = $doc->filehash;
        if ($doc->file) {
            $file = Yii::$app->FileManager->UploadFile($doc->file->name, $doc->file->tempName, '04', 'LNPT/Akademik/' . $this->getTahun($lppid) . '/bhg_' . $bhg_no . '');
            if ($file->status == true) {
                $doc->lpp_id = $lppid;
                $doc->bhg_no = $bhg_no;
                $doc->id_table = $id_table;
                $doc->filehash = $file->file_name_hashcode;
                $doc->file_name = $doc->file->name;
                $doc->created_dt = new \yii\db\Expression('NOW()');
                $doc->save(false);
            }
        }
    }

    public function editDocument($doc, $lppid, $bhg_no)
    {
        Yii::$app->FileManager->DeleteFile($doc->filehash);
        $doc->file = UploadedFile::getInstance($doc, 'file');
        // $tmp = $doc->filehash;
        if ($doc->file) {
            $file = Yii::$app->FileManager->UploadFile($doc->file->name, $doc->file->tempName, '04', 'LNPT/Akademik/' . $this->getTahun($lppid) . '/bhg_' . $bhg_no . '');
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

    public function delDocument($lppid, $bhg_no, $id_table)
    {
        $doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'bhg_no' => $bhg_no, 'id_table' => $id_table])->one();
        Yii::$app->FileManager->DeleteFile($doc->filehash);
        $doc->delete();
    }

    public function actionVerifyDocument($lppid, $filehash)
    {
        if (($doc = TblDocuments::find()->where(['lpp_id' => $lppid, 'filehash' => $filehash])->one()) === null) {
            throw new UserException('The requested page does not exist.');
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $check =  $data['check'];
            $ulasan =  $data['ulasan'];
            if ($check) {
                $doc->verified_by = Yii::$app->user->identity->ICNO;
                $doc->verified_dt = new \yii\db\Expression('NOW()');
                $doc->ulasan = $ulasan;
                $doc->save(false);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Dokumen berjaya disahkan!']);
            } else {
                $doc->verified_by = null;
                $doc->verified_dt = null;
                $doc->ulasan = null;
                $doc->save(false);
            }
            return 1;
        }
        return 0;
    }

    public function checkJawatanDeptKump($gred, $dept_id, $gred_skim)
    {
        $dept = TblKumpDept::find()->where(['ref_kump_dept_id' => 6])->asArray()->all();
        $dept1 = ArrayHelper::getColumn($dept, 'dept_id');
        if (in_array($dept_id, $dept1)) {
            switch ($gred) {
                case $gred == 'VK7':
                case $gred == 'VK6':
                case $gred == 'VK5':
                    return 'JAWATAN-VK';
            }
            if ($gred_skim == 'DU') {
                return 'JAWATAN-VK';
            }
        }
        // switch ($gred_skim) {
        //     case $gred_skim == 'VK7':
        //         return $gred;
        //     case $gred_skim == 'VU':
        //         return $gred;
        //     case $gred_skim == 'UMSDF':
        //         return $gred;
        // }
        return 'JAWATAN';
    }

    public function actionPengesahanBorang($lppid)
    {
        if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
            $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('pengesahan', [
            'lpp' => $lpp,
            'menu' => $this->menu($lpp),
            'lppid' => $lppid,
            // 'req' => null
            'req' => $this->checkRequest($lppid)
        ]);
    }

    public function actionPengesahanBorangPenilai($lppid)
    {
        if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
            $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('pengesahan_penilai', [
            'lpp' => $lpp,
            'menu' => $this->menu($lpp),
            'lppid' => $lppid,
            // 'req' => null
            'req' => $this->checkRequest($lppid)
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
                return $this->redirect(['elnpt2/pengesahan-borang', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('//elnpt/sah_pyd', [
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
                return $this->redirect(['elnpt2/pengesahan-borang-penilai', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('//elnpt/sah_ppp', [
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
                return $this->redirect(['elnpt2/pengesahan-borang-penilai', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('//elnpt/sah_ppk', [
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
                return $this->redirect(['elnpt2/pengesahan-borang-penilai', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('//elnpt/sah_peer', [
            'model' => $lpp
        ]);
    }

    public function checkEligible($lpp)
    {
        $tahun = TblLppTahun::find()->where(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun])->one();
        $req = $this->checkRequest($lpp->lpp_id);
        if ($req) {
            return false;
        }
        if ($lpp->PYD == Yii::$app->user->identity->ICNO) {
            if (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat) {
                if ($lpp->PYD_sah == 1) {
                    return true;
                }
            } else {
                if ($lpp->PYD_sah == 1) {
                    return true;
                }
            }
        }
        if ($lpp->PPP == Yii::$app->user->identity->ICNO) {
            if (date('Y-m-d H:i:s') <= $tahun->penilaian_PPP_tamat) {
                if ($lpp->PPP_sah == 1) {
                    return true;
                }
            } else {
                if ($lpp->PPP_sah == 1) {
                    return true;
                }
            }
        }
        if ($lpp->PPK == Yii::$app->user->identity->ICNO) {
            if (date('Y-m-d H:i:s') <= $tahun->penilaian_PPK_tamat) {
                if ($lpp->PPK_sah == 1) {
                    return true;
                }
            } else {
                if ($lpp->PPK_sah == 1) {
                    return true;
                }
            }
        }
        if ($lpp->PEER == Yii::$app->user->identity->ICNO) {
            if (date('Y-m-d H:i:s') <= $tahun->penilaian_PEER_tamat) {
                if ($lpp->PEER_sah == 1) {
                    return true;
                }
            } else {
                if ($lpp->PEER_sah == 1) {
                    return true;
                }
            }
        }
        return false;
    }

    public function actionRujukanPanduan()
    {
        return $this->render('rujukan_panduan');
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

    public function actionGenerateBorangAdmin($lppid)
    {
        if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
            $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        } else {
            throw new ForbiddenHttpException('You don\'t have permission to view this page.');
        };
        $bhg1 = RefBahagian::findOne(1);
        $aspek1 = RefAspekPenilaian::findAll(['bhg_no' => 1]);
        $this->dataBahagian1($lppid, $pengajaran, $pengajaran2, $pnp, $all);
        $arryPnp = ArrayHelper::toArray($pnp, []);
        $dataBhg1 = array_replace_recursive(($pengajaran + $pengajaran2), $arryPnp);
        $mrkhBhg1 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(1, $lppid), [], false);
        $bhg2 = RefBahagian::findOne(2);
        $aspek2 = RefAspekPenilaian::findAll(['bhg_no' => 2]);
        $this->dataBahagian2($lppid, $data, $penyeliaan, $utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
        $tmp = array_merge_recursive($utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
        foreach ($tmp as $id => $t) {
            ArrayHelper::setValue($tmpP, [$id, 'utama_belum'], is_array($tmp[$id]['utama_belum']) ? array_sum($tmp[$id]['utama_belum']) : $tmp[$id]['utama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah_sem'], is_array($tmp[$id]['utama_telah_sem']) ? array_sum($tmp[$id]['utama_telah_sem']) : $tmp[$id]['utama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah'], is_array($tmp[$id]['utama_telah']) ? array_sum($tmp[$id]['utama_telah']) : $tmp[$id]['utama_telah']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_belum'], is_array($tmp[$id]['sama_belum']) ? array_sum($tmp[$id]['sama_belum']) : $tmp[$id]['sama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah_sem'], is_array($tmp[$id]['sama_telah_sem']) ? array_sum($tmp[$id]['sama_telah_sem']) : $tmp[$id]['sama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah'], is_array($tmp[$id]['sama_telah']) ? array_sum($tmp[$id]['sama_telah']) : $tmp[$id]['sama_telah']);
            ArrayHelper::setValue($tmpP, [$id, 'verified_by'], 'SYSTEM');
        }
        $mrkhBhg2 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(2, $lppid), [], false);
        $selia_arry = ArrayHelper::toArray($penyeliaan);
        foreach ($tmpP as $id => $tP) {
            switch ($id) {
                case 'MASTER':
                    $tP['tahap_penyeliaan'] = 2;
                    break;
                case 'PHD':
                    $tP['tahap_penyeliaan'] = 1;
                    break;
                case 'M.Phil.':
                    $tP['tahap_penyeliaan'] = 3;
                    break;
            }
            array_push($selia_arry, $tP);
        }
        usort($selia_arry, function ($a, $b) {
            return $a['tahap_penyeliaan'] <=> $b['tahap_penyeliaan'];
        });
        $bhg3 = RefBahagian::findOne(3);
        $aspek3 = RefAspekPenilaian::findAll(['bhg_no' => 3]);
        $this->dataBahagian3($lppid, $penyelidikan, $penyelidikan2, $grant);
        $dataBhg3 = array_merge($penyelidikan, $penyelidikan2);
        $mrkhBhg3 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(3, $lppid), [], false);
        $bhg4 = RefBahagian::findOne(4);
        $aspek4 = RefAspekPenilaian::findAll(['bhg_no' => 4]);
        $this->dataBahagian4($lppid, $publication);
        $mrkhBhg4 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(4, $lppid), [], false);
        $bhg5 = RefBahagian::findOne(5);
        $aspek5 = RefAspekPenilaian::findAll(['bhg_no' => 5]);
        $this->dataBahagian5($lppid, $conference, $persidangan);
        $mrkhBhg5 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(5, $lppid), [], false);
        $bhg6 = RefBahagian::findOne(6);
        $aspek6 = RefAspekPenilaian::findAll(['bhg_no' => 6]);
        $this->dataBahagian6($lppid, $conference, $manual, $manual2);
        $dataBhg6 = array_merge($conference, $manual2);
        $mrkhBhg6 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(6, $lppid), [], false);
        $bhg7 = RefBahagian::findOne(7);
        $aspek7 = RefAspekPenilaian::findAll(['bhg_no' => 7]);
        $this->dataBahagian7($lppid, $urus_tadbir, $result);
        $dataBhg7 = array_merge($urus_tadbir, $result);
        $mrkhBhg7 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(7, $lppid), [], false);
        $bhg8 = RefBahagian::findOne(8);
        $aspek8 = RefAspekPenilaian::findAll(['bhg_no' => 8]);
        $this->dataBahagian8($lppid, $pereka, $inovasi, $teknologi);
        $dataBhg8 = array_merge($pereka, $inovasi, $teknologi);
        $mrkhBhg8 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(8, $lppid), [], false);
        $bhg9 = RefBahagian::findOne(9);
        $aspek9 = RefAspekPenilaian::findAll(['bhg_no' => 9]);
        $this->dataBahagian9($lppid, $bil_bhg2, $bil_bhg3, $bil_bhg4, $bil_bhg5, $bil_bhg6, $bil_bhg8);
        $bil_mentoring = ($bil_bhg2 * 0.3) + ($bil_bhg3 * 0.3) + ($bil_bhg4 * 0.4);
        $aspek = RefAspekPenilaian::find()->where(['bhg_no' => 9])->asArray()->indexBy('id')->all();
        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 9])->asArray()->all();
        switch (true) {
            case $lpp->gredGuru->gred == 'DG41':
            case $lpp->gredGuru->gred == 'DG44':
                $pemberat[0]['pemberat'] = 0;
                $pemberat[1]['pemberat'] = 0;
                $pemberat[2]['pemberat'] = 0.0;
                $pemberat[3]['pemberat'] = 0.5;
                $pemberat[4]['pemberat'] = 0.5;
                $pemberat[5]['pemberat'] = 0.05;
                $pemberat[6]['pemberat'] = 0.05;
                break;
            case $lpp->gredGuru->gred == 'DG48':
                $pemberat[0]['pemberat'] = 0;
                $pemberat[1]['pemberat'] = 0.25;
                $pemberat[2]['pemberat'] = 0.25;
                $pemberat[3]['pemberat'] = 0.25;
                $pemberat[4]['pemberat'] = 0.25;
                $pemberat[5]['pemberat'] = 0.05;
                $pemberat[6]['pemberat'] = 0.05;
                break;
        }
        switch (true) {
            case $lpp->gredGuru->gred == 'DS45':
                $peratusGred = 20;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DG41':
            case $lpp->gredGuru->gred == 'DG44':
                $peratusGred = 20;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DG48':
                $peratusGred = 10;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DS51':
            case $lpp->gredGuru->gred == 'DS52':
            case $lpp->gredGuru->gred == 'DG52':
            case $lpp->gredGuru->gred == 'DU51':
            case $lpp->gredGuru->gred == 'DU52':
                $peratusGred = 10;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DS53':
            case $lpp->gredGuru->gred == 'DS54':
            case $lpp->gredGuru->gred == 'DG54':
            case $lpp->gredGuru->gred == 'DU54':
            case $lpp->gredGuru->gred == 'DU56':
            case $lpp->gredGuru->gred == 'UMSDF8':
                $peratusGred = 10;
                $terpakai = true;
                break;
            default:
                $peratusGred = 0;
                $terpakai = true;
        }
        $arryGroup = ArrayHelper::index($aspek_skor, null, 'aspek_id');
        foreach (array_reverse($arryGroup['30']) as $as) {
            if ($bil_bhg2 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['31']) as $as) {
            if ($bil_bhg3 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['32']) as $as) {
            if ($bil_bhg4 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['33']) as $as) {
            if ($bil_bhg5 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['34']) as $as) {
            if ($bil_bhg6 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['35']) as $as) {
            if ($bil_bhg8 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['36']) as $as) {
            if ($bil_mentoring >= intval($as['desc'])) {
                ($terpakai) ? ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]) : ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => 0]);
                break;
            }
        }
        ArrayHelper::setValue($tmpBhg9, 30, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['30', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg2, 'desc' => $aspek[30]['desc'], 'sumber' => 'Bahagian 2']);
        ArrayHelper::setValue($tmpBhg9, 31, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['31', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg3, 'desc' => $aspek[31]['desc'], 'sumber' => 'Bahagian 3']);
        ArrayHelper::setValue($tmpBhg9, 32, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['32', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg4, 'desc' => $aspek[32]['desc'], 'sumber' => 'Bahagian 4']);
        ArrayHelper::setValue($tmpBhg9, 33, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['33', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg5, 'desc' => $aspek[33]['desc'], 'sumber' => 'Bahagian 5']);
        ArrayHelper::setValue($tmpBhg9, 34, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['34', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg6, 'desc' => $aspek[34]['desc'], 'sumber' => 'Bahagian 6']);
        ArrayHelper::setValue($tmpBhg9, 35, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['35', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg8, 'desc' => $aspek[35]['desc'], 'sumber' => 'Bahagian 8']);
        ArrayHelper::setValue($tmpBhg9, 36, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['36', 'skor'], $keepKeys = true)) : 0, 'bilangan' => (round($bil_mentoring)), 'desc' => $aspek[36]['desc'], 'sumber' => 'Bahagian 2, 3 & 4']);
        $mrkhBhg9 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(9, $lppid), [], false);
        $late = \app\models\kehadiran\TblRekod::find()
            ->where(['icno' => $lpp->PYD, 'YEAR(tarikh)' => $lpp->tahun, 'late_in' => 1])
            ->andWhere(['!=', 'remark_status', 'APPROVED'])
            ->count();
        $absent = \app\models\kehadiran\TblRekod::find()
            ->where(['icno' => $lpp->PYD, 'YEAR(tarikh)' => $lpp->tahun, 'absent' => 1])
            ->andWhere(['!=', 'remark_status', 'APPROVED'])
            ->count();
        $mrkhBhg10 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(10, $lppid, $pemberat ?? null), [], false);
        $bhg10 = RefBahagian::findOne(10);
        $mrkhKualiti = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->all();
        $tmppd = ArrayHelper::toArray($mrkhKualiti);
        $aspek10 = RefAspekPenilaian::find()->where(['bhg_no' => 10])->indexBy('id')->asArray()->all();
        try {
            $bhg11 = RefBahagian::findOne(11);
            $this->checkBahagian($lpp, $bhg11->id);
            $this->dataBahagian11($lppid, $klinikal, $clinic);
            $dataBhg11 = ArrayHelper::toArray($klinikal, [
                'app\models\elnpt\perkhidmatan_klinikal\TblKlinikal' => [
                    'cbt' => function ($klinikal) {
                        return $klinikal->cbt ?? 0;
                    },
                    // 'apc' => function ($klinikal) {
                    //     return $klinikal->apc ?? 0;
                    // },
                    'apc' => function ($klinikal) use ($clinic) {
                        return $clinic ? 1 : 0;
                    },
                    'clinic_consult' => function ($klinikal) {
                        return $klinikal->clinic_consult ?? 0;
                    }
                ],
            ]);
            $aspek11 = RefAspekPenilaian::findAll(['bhg_no' => 11]);
            $mrkhBhg11 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(11, $lppid), [], false);
        } catch (Exception $e) {
        }
        $dept = TblKumpDept::find()->where(['dept_id' => $lpp->deptGuru->sub_of ?? $lpp->jfpiu])->asArray()->all();
        $dept1 = ArrayHelper::getColumn($dept, 'ref_kump_dept_id');
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $tamat_dt = $tahun->pengisian_PYD_tamat;
        $hasJawatan = Tblrscoadminpost::find()->where(['ICNO' => $lpp->PYD, 'paymentStatus' => 1])->andWhere(['<>', 'flag', 3])->andWhere(['and', ['>', new Expression('TIMESTAMPDIFF(MONTH, start_date, \'' . \Yii::$app->formatter->asDate($tamat_dt, 'yyyy-MM-dd') . '\')'), 6], [
            '>=', new Expression('YEAR(end_date)'), $lpp->tahun
        ]])->orderBy(['end_date' => SORT_DESC])->limit(1)->exists();
        $gred = RefGred::find()->where(['kump_gred' => ($hasJawatan && (in_array('1', $dept1) || in_array('2', $dept1) || in_array('6', $dept1) || in_array('3', $dept1) || in_array('5', $dept1))) ? $this->checkJawatanDeptKump($lpp->gredGuru->gred, $lpp->jfpiu, $lpp->gredGuru->gred_skim) : $lpp->gredGuru->gred])->one();
        $ex = TblException2::findOne([$lpp->lpp_id]);
        if (!is_null($ex)) {
            $dept = TblKumpDept::find()->where(['id' => $ex->tbl_kump_dept_id])->asArray()->all();
            $gred = RefGred::findOne([$ex->ref_gred_id]);
        }
        $query11 = RefPemberatSeluruh::find()
            ->select(['tbl_kump_dept_id', 'pemberat', 'bahagian'])
            ->where(['tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'ref_gred_id' => $gred->id, 'year' => $lpp->tahun])
            ->orderBy(['bahagian' => SORT_ASC])
            ->indexBy('bahagian')
            ->asArray()
            ->all();
        $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid, $dept, $gred), [], false);
        $markah = (new \yii\db\Query())
            ->select(['`hrm`.`elnpt_v2_ref_bahagian`.`id` AS id', '`hrm`.`elnpt_v2_ref_bahagian`.`bahagian` AS aspek', '((COALESCE(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0.0) * 100) / `hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`pemberat`) as markah', '`hrm`.`elnpt_v2_ref_bahagian`.`bhg_color` AS warna'])
            ->from('`hrm`.`elnpt_v2_ref_bahagian`')
            ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` = `hrm`.`elnpt_v2_ref_bahagian`.`id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
            ->rightJoin('(SELECT DISTINCT bahagian FROM `hrm`.`elnpt_v2_ref_pemberat_keseluruhan`) a', 'a.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id])
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
                '`hrm`.`elnpt_v2_ref_aspek_penilaian`.`desc`', '`hrm`.`elnpt_v2_ref_aspek_penilaian`.`aspek`', '`hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no` as bhg_no', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor',
                'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) as markah_pyd', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 0) as markah_ppp', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, 0) as markah_ppk',
                'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, 0) as markah_peer', '`hrm`.`elnpt_v2_ref_bahagian`.`id` as idd'
            ])
            ->leftJoin('`hrm`.`elnpt_v2_ref_bahagian`', '`hrm`.`elnpt_v2_ref_bahagian`.id = `hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no`')
            ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id` = `hrm`.`elnpt_v2_ref_aspek_penilaian`.`id` AND `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid)
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id])
            ->orderBy('`hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no`')
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
            ->select(['`hrm`.`elnpt_v2_ref_bahagian`.`id` as bhg_no', new Expression('\'0\' as mrkh_bhg')])
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id])
            ->andWhere(['!=', '`hrm`.`elnpt_v2_ref_bahagian`.`id`', 12])
            ->orderBy('`hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $pyd = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_pyd) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->andWhere(['!=', 'a.bhg_no', 10])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('a.bhg_no')
            ->asArray()
            ->all();
        $pyd = ArrayHelper::index($pyd, 'bhg_no');
        $pyd = array_replace_recursive($arry, $pyd);

        $ppp = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_ppp) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $ppp = ArrayHelper::index($ppp, 'bhg_no');
        $ppp = array_replace_recursive($arry, $ppp);

        $ppk = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_ppk) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $ppk = ArrayHelper::index($ppk, 'bhg_no');
        $ppk = array_replace_recursive($arry, $ppk);

        $peer = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_peer) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $peer = ArrayHelper::index($peer, 'bhg_no');
        $peer = array_replace_recursive($arry, $peer);
        $this->calcOverallMark($lppid);
        $this->getMarkahKualiti($lppid, $mrkh_ppp, $mrkh_ppk, $mrkh_peer, $lpp, $gred, $dept, $fin);
        ArrayHelper::setValue($ppp, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($mrkh_ppp / 10)]);
        ArrayHelper::setValue($ppk, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($mrkh_ppk / 10)]);
        ArrayHelper::setValue($peer, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($mrkh_peer / 10)]);
        $markahAll = $markah->all();
        ArrayHelper::setValue($markahAll, [10], ['id' => '10', 'aspek' => 'Kualiti Peribadi', 'markah' => strval($fin * 10), 'warna' => '#cd29bd']);
        foreach ($markahAll as $ind => $ma) {
            $mar = $ma['markah'];
            $markahAll[$ind]['markah'] = (is_nan($mar) || is_null($mar)) ? 0 : $mar;
        }

        // ArrayHelper::setValue($query11, [10], ['bhg_id' => '10', 'pemberat' => strval(Yii::$app->formatter->asDecimal(3.75 + 8.25, 2))]);
        $tmppp = array_map(
            function ($x, $y) {
                return $x * $y;
            },
            array_column($markahAll, 'markah'),
            array_column($query11, 'pemberat')
        );

        $total = $this->getTotalMark($lppid, $tmppp);
        $content = $this->renderPartial('_borangView', [
            'lpp' => $lpp,
            'lppid' => $lppid,
            // 'query' => $query,
            // 'inputBhg1' => $pnp,
            'aspek1' => $aspek1,
            'dataBhg1' => $dataBhg1,
            'bahagian1' => $bhg1,
            'mrkh_bhg1' => $mrkhBhg1,
            'aspek2' => $aspek2,
            'dataBhg2' => $selia_arry,
            'bahagian2' => $bhg2,
            'mrkh_bhg2' => $mrkhBhg2,
            'aspek3' => $aspek3,
            'dataBhg3' => $dataBhg3,
            'bahagian3' => $bhg3,
            'mrkh_bhg3' => $mrkhBhg3,
            'grant' => $grant,
            'aspek4' => $aspek4,
            'dataBhg4' => $publication,
            'bahagian4' => $bhg4,
            'mrkh_bhg4' => $mrkhBhg4,
            'aspek5' => $aspek5,
            'dataBhg5' => $conference,
            'bahagian5' => $bhg5,
            'mrkh_bhg5' => $mrkhBhg5,
            'aspek6' => $aspek6,
            'dataBhg6' => $dataBhg6,
            'bahagian6' => $bhg6,
            'mrkh_bhg6' => $mrkhBhg6,
            'aspek7' => $aspek7,
            'dataBhg7' => $dataBhg7,
            'bahagian7' => $bhg7,
            'mrkh_bhg7' => $mrkhBhg7,
            'aspek8' => $aspek8,
            'dataBhg8' => $dataBhg8,
            'bahagian8' => $bhg8,
            'mrkh_bhg8' => $mrkhBhg8,
            // 'aspek9' => $aspek9,
            'dataBhg9' => $tmpBhg9,
            'bahagian9' => $bhg9,
            'mrkh_bhg9' => $mrkhBhg9,
            'aspek10' => RefAspekPenilaian::findAll(['bhg_no' => 10]),
            'late' => $late,
            'absent' => $absent,
            'dataBhg10' => array_replace_recursive($tmppd, $aspek10),
            'bahagian10' => $bhg10,
            'mrkh_bhg10' => $mrkhBhg10,
            'aspek11' => $aspek11 ?? null,
            'dataBhg11' => $dataBhg11 ?? null,
            'bahagian11' => $bhg11,
            'mrkh_bhg11' => $mrkhBhg11 ?? null,
            'mrkh_all' => $mrkh_all,
            'markah' => $markahAll,
            'pemberat' => $query11,
            'menu' => $this->menu($lpp),
            'total' => is_null($total) ? 0 : $total->markah,
            'kategori' => is_null($total) ? '' : $total->kategori,
            'rankDept' => is_null($total) ? 0 : $total->rankByDept($lppid, $lpp->jfpiu, $lpp->tahun),
            'rankGred' => is_null($total) ? 0 : $total->rankByGred($lppid, $lpp->jfpiu, $lpp->gred_jawatan_id, $lpp->tahun),
            'rankWhole' => is_null($total) ? 0 : $total->rankAsWhole($lppid, $lpp->tahun),
            'pyd' => $pyd,
            'lpp' => $lpp,
            'ppp' => $ppp,
            'ppk' => $ppk,
            'peer' => $peer,
        ]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'borang_lnpt_akademik_' . $lppid,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.css',
            'cssInline' => 'x_panel {
                position: relative;
                width: 100%;
                margin-bottom: 10px;
                padding: 10px 17px;
                display: inline-block;
                background: #fff;
                border: 1px solid #E6E9ED;
                -webkit-column-break-inside: avoid;
                -moz-column-break-inside: avoid;
                column-break-inside: avoid;
                opacity: 1;
                transition: all .2s ease;
            }
            body {
                // color: #73879C;
                font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
                font-size: 13px;
                font-weight: 400;
                line-height: 1.471;
            }
            table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
                border-collapse: collapse;
                border-spacing: 0;
            }
            div.row.v2 {
                border: 0.5mm solid #73879C;
            }
            th, td {
                padding: 5px;
            }
            tile-stats {
                position: relative;
                display: block;
                margin-bottom: 12px;
                border: 1px solid #E4E4E4;
                overflow: hidden;
                padding-bottom: 5px;
                border-radius: 5px;
                background: #FFF;
                transition: all 300ms ease-in-out;
            }',
            'options' =>  [
                'title' => 'Borang LNPT',
                'keywords' => 'krajee, grid, export, yii2-grid, pdf'
            ],
            'methods' => [
                // 'SetHeader'=>['Borang e-LNPT Tahun '],
                'SetHeader' => ['Borang LNPT||Generated On: ' . date("r")],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);
        // $pdf->keep_table_proportions = true;
        return $pdf->render();
    }

    public function actionGenerateBorang($lppid)
    {
        if (($lpp = TblMain::findOne(['lpp_id' => $lppid])) != null) {
            $lpp = TblMain::findOne(['lpp_id' => $lppid]);
        } else {
            throw new ForbiddenHttpException('You don\'t have permission to view this page.');
        };
        $bhg1 = RefBahagian::findOne(1);
        $aspek1 = RefAspekPenilaian::findAll(['bhg_no' => 1]);
        $this->dataBahagian1($lppid, $pengajaran, $pengajaran2, $pnp, $all);
        $arryPnp = ArrayHelper::toArray($pnp, []);
        $dataBhg1 = array_replace_recursive(($pengajaran + $pengajaran2), $arryPnp);
        $mrkhBhg1 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(1, $lppid), [], false);
        $bhg2 = RefBahagian::findOne(2);
        $aspek2 = RefAspekPenilaian::findAll(['bhg_no' => 2]);
        $this->dataBahagian2($lppid, $data, $penyeliaan, $utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
        $tmp = array_merge_recursive($utama_belum, $utama_telah_sem, $utama_telah, $sama_belum, $sama_telah_sem, $sama_telah, $init);
        foreach ($tmp as $id => $t) {
            ArrayHelper::setValue($tmpP, [$id, 'utama_belum'], is_array($tmp[$id]['utama_belum']) ? array_sum($tmp[$id]['utama_belum']) : $tmp[$id]['utama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah_sem'], is_array($tmp[$id]['utama_telah_sem']) ? array_sum($tmp[$id]['utama_telah_sem']) : $tmp[$id]['utama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'utama_telah'], is_array($tmp[$id]['utama_telah']) ? array_sum($tmp[$id]['utama_telah']) : $tmp[$id]['utama_telah']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_belum'], is_array($tmp[$id]['sama_belum']) ? array_sum($tmp[$id]['sama_belum']) : $tmp[$id]['sama_belum']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah_sem'], is_array($tmp[$id]['sama_telah_sem']) ? array_sum($tmp[$id]['sama_telah_sem']) : $tmp[$id]['sama_telah_sem']);
            ArrayHelper::setValue($tmpP, [$id, 'sama_telah'], is_array($tmp[$id]['sama_telah']) ? array_sum($tmp[$id]['sama_telah']) : $tmp[$id]['sama_telah']);
            ArrayHelper::setValue($tmpP, [$id, 'verified_by'], 'SYSTEM');
        }
        $mrkhBhg2 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(2, $lppid), [], false);
        $selia_arry = ArrayHelper::toArray($penyeliaan);
        foreach ($tmpP as $id => $tP) {
            switch ($id) {
                case 'MASTER':
                    $tP['tahap_penyeliaan'] = 2;
                    break;
                case 'PHD':
                    $tP['tahap_penyeliaan'] = 1;
                    break;
                case 'M.Phil.':
                    $tP['tahap_penyeliaan'] = 3;
                    break;
            }
            array_push($selia_arry, $tP);
        }
        usort($selia_arry, function ($a, $b) {
            return $a['tahap_penyeliaan'] <=> $b['tahap_penyeliaan'];
        });
        $bhg3 = RefBahagian::findOne(3);
        $aspek3 = RefAspekPenilaian::findAll(['bhg_no' => 3]);
        $this->dataBahagian3($lppid, $penyelidikan, $penyelidikan2, $grant);
        $dataBhg3 = array_merge($penyelidikan, $penyelidikan2);
        $mrkhBhg3 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(3, $lppid), [], false);
        $bhg4 = RefBahagian::findOne(4);
        $aspek4 = RefAspekPenilaian::findAll(['bhg_no' => 4]);
        $this->dataBahagian4($lppid, $publication);
        $mrkhBhg4 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(4, $lppid), [], false);
        $bhg5 = RefBahagian::findOne(5);
        $aspek5 = RefAspekPenilaian::findAll(['bhg_no' => 5]);
        $this->dataBahagian5($lppid, $conference, $persidangan);
        $mrkhBhg5 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(5, $lppid), [], false);
        $bhg6 = RefBahagian::findOne(6);
        $aspek6 = RefAspekPenilaian::findAll(['bhg_no' => 6]);
        $this->dataBahagian6($lppid, $conference, $manual, $manual2);
        $dataBhg6 = array_merge($conference, $manual2);
        $mrkhBhg6 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(6, $lppid), [], false);
        $bhg7 = RefBahagian::findOne(7);
        $aspek7 = RefAspekPenilaian::findAll(['bhg_no' => 7]);
        $this->dataBahagian7($lppid, $urus_tadbir, $result);
        $dataBhg7 = array_merge($urus_tadbir, $result);
        $mrkhBhg7 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(7, $lppid), [], false);
        $bhg8 = RefBahagian::findOne(8);
        $aspek8 = RefAspekPenilaian::findAll(['bhg_no' => 8]);
        $this->dataBahagian8($lppid, $pereka, $inovasi, $teknologi);
        $dataBhg8 = array_merge($pereka, $inovasi, $teknologi);
        $mrkhBhg8 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(8, $lppid), [], false);
        $bhg9 = RefBahagian::findOne(9);
        $aspek9 = RefAspekPenilaian::findAll(['bhg_no' => 9]);
        $this->dataBahagian9($lppid, $bil_bhg2, $bil_bhg3, $bil_bhg4, $bil_bhg5, $bil_bhg6, $bil_bhg8);
        $bil_mentoring = ($bil_bhg2 * 0.3) + ($bil_bhg3 * 0.3) + ($bil_bhg4 * 0.4);
        $aspek = RefAspekPenilaian::find()->where(['bhg_no' => 9])->asArray()->indexBy('id')->all();
        $aspek_skor = RefAspekSkor::find()->where(['bahagian' => 9])->asArray()->all();
        switch (true) {
            case $lpp->gredGuru->gred == 'DG41':
            case $lpp->gredGuru->gred == 'DG44':
                $pemberat[0]['pemberat'] = 0;
                $pemberat[1]['pemberat'] = 0;
                $pemberat[2]['pemberat'] = 0.0;
                $pemberat[3]['pemberat'] = 0.5;
                $pemberat[4]['pemberat'] = 0.5;
                $pemberat[5]['pemberat'] = 0.05;
                $pemberat[6]['pemberat'] = 0.05;
                break;
            case $lpp->gredGuru->gred == 'DG48':
                $pemberat[0]['pemberat'] = 0;
                $pemberat[1]['pemberat'] = 0.25;
                $pemberat[2]['pemberat'] = 0.25;
                $pemberat[3]['pemberat'] = 0.25;
                $pemberat[4]['pemberat'] = 0.25;
                $pemberat[5]['pemberat'] = 0.05;
                $pemberat[6]['pemberat'] = 0.05;
                break;
        }
        switch (true) {
            case $lpp->gredGuru->gred == 'DS45':
                $peratusGred = 20;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DG41':
            case $lpp->gredGuru->gred == 'DG44':
                $peratusGred = 20;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DG48':
                $peratusGred = 10;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DS51':
            case $lpp->gredGuru->gred == 'DS52':
            case $lpp->gredGuru->gred == 'DG52':
            case $lpp->gredGuru->gred == 'DU51':
            case $lpp->gredGuru->gred == 'DU52':
                $peratusGred = 10;
                $terpakai = false;
                break;
            case $lpp->gredGuru->gred == 'DS53':
            case $lpp->gredGuru->gred == 'DS54':
            case $lpp->gredGuru->gred == 'DG54':
            case $lpp->gredGuru->gred == 'DU54':
            case $lpp->gredGuru->gred == 'DU56':
            case $lpp->gredGuru->gred == 'UMSDF8':
                $peratusGred = 10;
                $terpakai = true;
                break;
            default:
                $peratusGred = 0;
                $terpakai = true;
        }
        $arryGroup = ArrayHelper::index($aspek_skor, null, 'aspek_id');
        foreach (array_reverse($arryGroup['30']) as $as) {
            if ($bil_bhg2 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['31']) as $as) {
            if ($bil_bhg3 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['32']) as $as) {
            if ($bil_bhg4 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['33']) as $as) {
            if ($bil_bhg5 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['34']) as $as) {
            if ($bil_bhg6 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['35']) as $as) {
            if ($bil_bhg8 >= floatval($as['desc'])) {
                ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]);
                break;
            }
        }
        foreach (array_reverse($arryGroup['36']) as $as) {
            if ($bil_mentoring >= intval($as['desc'])) {
                ($terpakai) ? ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => floatval($as['skor']) == 0 ? 0 : min(1, floatval($as['skor']) + ($peratusGred / 100))]) : ArrayHelper::setValue($skor, [0, $as['aspek_id']], ['skor' => 0]);
                break;
            }
        }
        ArrayHelper::setValue($tmpBhg9, 30, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['30', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg2, 'desc' => $aspek[30]['desc'], 'sumber' => 'Bahagian 2']);
        ArrayHelper::setValue($tmpBhg9, 31, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['31', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg3, 'desc' => $aspek[31]['desc'], 'sumber' => 'Bahagian 3']);
        ArrayHelper::setValue($tmpBhg9, 32, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['32', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg4, 'desc' => $aspek[32]['desc'], 'sumber' => 'Bahagian 4']);
        ArrayHelper::setValue($tmpBhg9, 33, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['33', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg5, 'desc' => $aspek[33]['desc'], 'sumber' => 'Bahagian 5']);
        ArrayHelper::setValue($tmpBhg9, 34, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['34', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg6, 'desc' => $aspek[34]['desc'], 'sumber' => 'Bahagian 6']);
        ArrayHelper::setValue($tmpBhg9, 35, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['35', 'skor'], $keepKeys = true)) : 0, 'bilangan' => $bil_bhg8, 'desc' => $aspek[35]['desc'], 'sumber' => 'Bahagian 8']);
        ArrayHelper::setValue($tmpBhg9, 36, ['skor' => isset($skor) ? array_sum(ArrayHelper::getColumn($skor, ['36', 'skor'], $keepKeys = true)) : 0, 'bilangan' => (round($bil_mentoring)), 'desc' => $aspek[36]['desc'], 'sumber' => 'Bahagian 2, 3 & 4']);
        $mrkhBhg9 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(9, $lppid), [], false);
        $late = \app\models\kehadiran\TblRekod::find()
            ->where(['icno' => $lpp->PYD, 'YEAR(tarikh)' => $lpp->tahun, 'late_in' => 1])
            ->andWhere(['!=', 'remark_status', 'APPROVED'])
            ->count();
        $absent = \app\models\kehadiran\TblRekod::find()
            ->where(['icno' => $lpp->PYD, 'YEAR(tarikh)' => $lpp->tahun, 'absent' => 1])
            ->andWhere(['!=', 'remark_status', 'APPROVED'])
            ->count();
        $mrkhBhg10 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(10, $lppid), [], false);
        $bhg10 = RefBahagian::findOne(10);
        $mrkhKualiti = TblMarkahKualiti::find()->where(['lpp_id' => $lppid])->indexBy('ref_kualiti_id')->all();
        $tmppd = ArrayHelper::toArray($mrkhKualiti);
        $aspek10 = RefAspekPenilaian::find()->where(['bhg_no' => 10])->indexBy('id')->asArray()->all();
        try {
            $bhg11 = RefBahagian::findOne(11);
            $this->checkBahagian($lpp, $bhg11->id);
            $this->dataBahagian11($lppid, $klinikal, $clinic);
            $dataBhg11 = ArrayHelper::toArray($klinikal, [
                'app\models\elnpt\perkhidmatan_klinikal\TblKlinikal' => [
                    'cbt' => function ($klinikal) {
                        return $klinikal->cbt ?? 0;
                    },
                    // 'apc' => function ($klinikal) {
                    //     return $klinikal->apc ?? 0;
                    // },
                    'apc' => function ($klinikal) use ($clinic) {
                        return $clinic ? 1 : 0;
                    },
                    'clinic_consult' => function ($klinikal) {
                        return $klinikal->clinic_consult ?? 0;
                    }
                ],
            ]);
            $aspek11 = RefAspekPenilaian::findAll(['bhg_no' => 11]);
            $mrkhBhg11 = \yii\helpers\ArrayHelper::toArray($this->findMarkahBahagian(11, $lppid), [], false);
        } catch (Exception $e) {
        }
        $dept = TblKumpDept::find()->where(['dept_id' => $lpp->deptGuru->sub_of ?? $lpp->jfpiu])->asArray()->all();
        $dept1 = ArrayHelper::getColumn($dept, 'ref_kump_dept_id');
        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);
        $tamat_dt = $tahun->pengisian_PYD_tamat;
        $hasJawatan = Tblrscoadminpost::find()->where(['ICNO' => $lpp->PYD, 'paymentStatus' => 1])->andWhere(['<>', 'flag', 3])->andWhere(['and', ['>', new Expression('TIMESTAMPDIFF(MONTH, start_date, \'' . \Yii::$app->formatter->asDate($tamat_dt, 'yyyy-MM-dd') . '\')'), 6], [
            '>=', new Expression('YEAR(end_date)'), $lpp->tahun
        ]])->orderBy(['end_date' => SORT_DESC])->limit(1)->exists();
        $gred = RefGred::find()->where(['kump_gred' => ($hasJawatan && (in_array('1', $dept1) || in_array('2', $dept1) || in_array('6', $dept1) || in_array('3', $dept1) || in_array('5', $dept1))) ? $this->checkJawatanDeptKump($lpp->gredGuru->gred, $lpp->jfpiu, $lpp->gredGuru->gred_skim) : $lpp->gredGuru->gred])->one();
        $ex = TblException2::findOne([$lpp->lpp_id]);
        if (!is_null($ex)) {
            $dept = TblKumpDept::find()->where(['id' => $ex->tbl_kump_dept_id])->asArray()->all();
            $gred = RefGred::findOne([$ex->ref_gred_id]);
        }
        $query11 = RefPemberatSeluruh::find()
            ->select(['tbl_kump_dept_id', 'pemberat', 'bahagian'])
            ->where(['tbl_kump_dept_id' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), 'ref_gred_id' => $gred->id, 'year' => $lpp->tahun])
            ->orderBy(['bahagian' => SORT_ASC])
            ->indexBy('bahagian')
            ->asArray()
            ->all();
        $mrkh_all = \yii\helpers\ArrayHelper::toArray($this->findMarkahKeseluruhan($lppid, $dept, $gred), [], false);
        $markah = (new \yii\db\Query())
            ->select(['`hrm`.`elnpt_v2_ref_bahagian`.`id` AS id', '`hrm`.`elnpt_v2_ref_bahagian`.`bahagian` AS aspek', '((COALESCE(`hrm`.`elnpt_tbl_mrkh_bhg`.`markah`, 0.0) * 100) / `hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`pemberat`) as markah', '`hrm`.`elnpt_v2_ref_bahagian`.`bhg_color` AS warna'])
            ->from('`hrm`.`elnpt_v2_ref_bahagian`')
            ->leftJoin('`hrm`.`elnpt_tbl_mrkh_bhg`', '`hrm`.`elnpt_tbl_mrkh_bhg`.`bhg_id` = `hrm`.`elnpt_v2_ref_bahagian`.`id` AND `hrm`.`elnpt_tbl_mrkh_bhg`.`lpp_id` = ' . $lppid)
            ->rightJoin('(SELECT DISTINCT bahagian FROM `hrm`.`elnpt_v2_ref_pemberat_keseluruhan`) a', 'a.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id])
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
                '`hrm`.`elnpt_v2_ref_aspek_penilaian`.`desc`', '`hrm`.`elnpt_v2_ref_aspek_penilaian`.`aspek`', '`hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no` as bhg_no', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`skor`, 0) as skor',
                'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_pyd`, 0) as markah_pyd', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppp`, 0) as markah_ppp', 'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_ppk`, 0) as markah_ppk',
                'coalesce(`hrm`.`elnpt_tbl_mrkh_aspek`.`markah_peer`, 0) as markah_peer', '`hrm`.`elnpt_v2_ref_bahagian`.`id` as idd'
            ])
            ->leftJoin('`hrm`.`elnpt_v2_ref_bahagian`', '`hrm`.`elnpt_v2_ref_bahagian`.id = `hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no`')
            ->leftJoin('`hrm`.`elnpt_tbl_mrkh_aspek`', '`hrm`.`elnpt_tbl_mrkh_aspek`.`aspek_id` = `hrm`.`elnpt_v2_ref_aspek_penilaian`.`id` AND `hrm`.`elnpt_tbl_mrkh_aspek`.`lpp_id` = ' . $lppid)
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id])
            ->orderBy('`hrm`.`elnpt_v2_ref_aspek_penilaian`.`bhg_no`')
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
            ->select(['`hrm`.`elnpt_v2_ref_bahagian`.`id` as bhg_no', new Expression('\'0\' as mrkh_bhg')])
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = `hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->where(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id])
            ->andWhere(['!=', '`hrm`.`elnpt_v2_ref_bahagian`.`id`', 12])
            ->orderBy('`hrm`.`elnpt_v2_ref_bahagian`.`id`')
            ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $pyd = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_pyd) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->andWhere(['!=', 'a.bhg_no', 10])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('a.bhg_no')
            ->asArray()
            ->all();
        $pyd = ArrayHelper::index($pyd, 'bhg_no');
        $pyd = array_replace_recursive($arry, $pyd);

        $ppp = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_ppp) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $ppp = ArrayHelper::index($ppp, 'bhg_no');
        $ppp = array_replace_recursive($arry, $ppp);

        $ppk = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_ppk) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $ppk = ArrayHelper::index($ppk, 'bhg_no');
        $ppk = array_replace_recursive($arry, $ppk);

        $peer = TblMrkhAspek::find()
            ->select('a.bhg_no, (sum(markah_peer) * (pemberat/100)) * 100 as mrkh_bhg')
            ->alias('a')
            ->rightJoin(['c' => 'hrm.elnpt_v2_ref_aspek_penilaian'], 'c.id = a.aspek_id')
            ->leftJoin('`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`', '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`bahagian` = a.`bhg_no`')
            ->where(['lpp_id' => $lppid])
            ->andWhere(['`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`tbl_kump_dept_id`' => ArrayHelper::getColumn($dept, 'ref_kump_dept_id'), '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`ref_gred_id`' => $gred->id, '`hrm`.`elnpt_v2_ref_pemberat_keseluruhan`.`year`' => $lpp->tahun])
            ->groupBy('a.bhg_no')
            ->orderBy('a.bhg_no')
            // ->indexBy('bhg_no')
            ->asArray()
            ->all();
        $peer = ArrayHelper::index($peer, 'bhg_no');
        $peer = array_replace_recursive($arry, $peer);
        $this->calcOverallMark($lppid);
        $this->getMarkahKualiti($lppid, $mrkh_ppp, $mrkh_ppk, $mrkh_peer, $lpp, $gred, $dept, $fin);
        ArrayHelper::setValue($ppp, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($mrkh_ppp / 10)]);
        ArrayHelper::setValue($ppk, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($mrkh_ppk / 10)]);
        ArrayHelper::setValue($peer, [10], ['bhg_no' => '10', 'mrkh_bhg' => strval($mrkh_peer / 10)]);
        $markahAll = $markah->all();
        ArrayHelper::setValue($markahAll, [10], ['id' => '10', 'aspek' => 'Kualiti Peribadi', 'markah' => strval($fin * 10), 'warna' => '#cd29bd']);
        foreach ($markahAll as $ind => $ma) {
            $mar = $ma['markah'];
            $markahAll[$ind]['markah'] = (is_nan($mar) || is_null($mar)) ? 0 : $mar;
        }

        // ArrayHelper::setValue($query11, [10], ['bhg_id' => '10', 'pemberat' => strval(Yii::$app->formatter->asDecimal(3.75 + 8.25, 2))]);
        $tmppp = array_map(
            function ($x, $y) {
                return $x * $y;
            },
            array_column($markahAll, 'markah'),
            array_column($query11, 'pemberat')
        );

        $total = $this->getTotalMark($lppid, $tmppp);
        $content = $this->renderPartial('_borangViewPyd', [
            'lpp' => $lpp,
            'lppid' => $lppid,
            // 'query' => $query,
            // 'inputBhg1' => $pnp,
            'aspek1' => $aspek1,
            'dataBhg1' => $dataBhg1,
            'bahagian1' => $bhg1,
            'mrkh_bhg1' => $mrkhBhg1,
            'aspek2' => $aspek2,
            'dataBhg2' => $selia_arry,
            'bahagian2' => $bhg2,
            'mrkh_bhg2' => $mrkhBhg2,
            'aspek3' => $aspek3,
            'dataBhg3' => $dataBhg3,
            'bahagian3' => $bhg3,
            'mrkh_bhg3' => $mrkhBhg3,
            'grant' => $grant,
            'aspek4' => $aspek4,
            'dataBhg4' => $publication,
            'bahagian4' => $bhg4,
            'mrkh_bhg4' => $mrkhBhg4,
            'aspek5' => $aspek5,
            'dataBhg5' => $conference,
            'bahagian5' => $bhg5,
            'mrkh_bhg5' => $mrkhBhg5,
            'aspek6' => $aspek6,
            'dataBhg6' => $dataBhg6,
            'bahagian6' => $bhg6,
            'mrkh_bhg6' => $mrkhBhg6,
            'aspek7' => $aspek7,
            'dataBhg7' => $dataBhg7,
            'bahagian7' => $bhg7,
            'mrkh_bhg7' => $mrkhBhg7,
            'aspek8' => $aspek8,
            'dataBhg8' => $dataBhg8,
            'bahagian8' => $bhg8,
            'mrkh_bhg8' => $mrkhBhg8,
            // 'aspek9' => $aspek9,
            'dataBhg9' => $tmpBhg9,
            'bahagian9' => $bhg9,
            'mrkh_bhg9' => $mrkhBhg9,
            'aspek10' => RefAspekPenilaian::findAll(['bhg_no' => 10]),
            'late' => $late,
            'absent' => $absent,
            'dataBhg10' => array_replace_recursive($tmppd, $aspek10),
            'bahagian10' => $bhg10,
            'mrkh_bhg10' => $mrkhBhg10,
            'aspek11' => $aspek11 ?? null,
            'dataBhg11' => $dataBhg11 ?? null,
            'bahagian11' => $bhg11,
            'mrkh_bhg11' => $mrkhBhg11 ?? null,
            'mrkh_all' => $mrkh_all,
            'markah' => $markahAll,
            'pemberat' => $query11,
            'menu' => $this->menu($lpp),
            'total' => is_null($total) ? 0 : $total->markah,
            'kategori' => is_null($total) ? '' : $total->kategori,
            'rankDept' => is_null($total) ? 0 : $total->rankByDept($lppid, $lpp->jfpiu, $lpp->tahun),
            'rankGred' => is_null($total) ? 0 : $total->rankByGred($lppid, $lpp->jfpiu, $lpp->gred_jawatan_id, $lpp->tahun),
            'rankWhole' => is_null($total) ? 0 : $total->rankAsWhole($lppid, $lpp->tahun),
            'pyd' => $pyd,
            'lpp' => $lpp,
            'ppp' => $ppp,
            'ppk' => $ppk,
            'peer' => $peer,
        ]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'borang_lnpt_akademik_' . $lppid,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.css',
            'cssInline' => 'x_panel {
                position: relative;
                width: 100%;
                margin-bottom: 10px;
                padding: 10px 17px;
                display: inline-block;
                background: #fff;
                border: 1px solid #E6E9ED;
                -webkit-column-break-inside: avoid;
                -moz-column-break-inside: avoid;
                column-break-inside: avoid;
                opacity: 1;
                transition: all .2s ease;
            }
            body {
                // color: #73879C;
                font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
                font-size: 13px;
                font-weight: 400;
                line-height: 1.471;
            }
            table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
                border-collapse: collapse;
                border-spacing: 0;
            }
            div.row.v2 {
                border: 0.5mm solid #73879C;
            }
            th, td {
                padding: 5px;
            }
            tile-stats {
                position: relative;
                display: block;
                margin-bottom: 12px;
                border: 1px solid #E4E4E4;
                overflow: hidden;
                padding-bottom: 5px;
                border-radius: 5px;
                background: #FFF;
                transition: all 300ms ease-in-out;
            }',
            'options' =>  [
                'title' => 'Borang LNPT',
                'keywords' => 'krajee, grid, export, yii2-grid, pdf'
            ],
            'methods' => [
                // 'SetHeader'=>['Borang e-LNPT Tahun '],
                'SetHeader' => ['Borang LNPT||Generated On: ' . date("r")],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);
        // $pdf->keep_table_proportions = true;
        return $pdf->render();
    }

    public function GenerateSamePPP($lppid)
    {
        $mrkh_aspek = TblMrkhAspek::find()
            ->where(['lpp_id' => $lppid])
            ->all();
        foreach ($mrkh_aspek as $ma) {
            if ($ma->bhg_no == 10)
                continue;
            $ma->markah_ppk = $ma->markah_ppp;
            $ma->markah_peer = $ma->markah_ppp;
            $ma->save();
        }
    }

    public function actionPengesahanMarkah($lppid)
    {
        $lpp = $this->findLpp($lppid);
        return $this->render('pengesahan_markah', [
            'lpp' => $lpp,
            'menu' => $this->menu($lpp),
            'lppid' => $lppid,
            'req' => $this->checkRequest($lppid)
        ]);
    }

    public function actionMarkahSetuju($lppid)
    {
        \yii\helpers\Url::remember();
        $lpp = $this->findLpp($lppid);
        $alasan = TblAlasanSemakan::find()->where(['lpp_id' => $lppid])->exists();
        $lpp->markah_sah = 1;
        $lpp->markah_sah_datetime = new \yii\db\Expression('NOW()');
        if ($lpp->validate() && !$alasan) {
            $lpp->save();
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pengesahan markah telah dihantar!']);
            return $this->redirect(['elnpt2/pengesahan-markah', 'lppid' => $lppid]);
        } else {
            \Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'warning', 'msg' => 'Pengesahan markah tidak berjaya!']);
            return $this->redirect(['elnpt2/pengesahan-markah', 'lppid' => $lppid]);
        }
    }

    public function actionMohonSemak($lppid)
    {
        $lpp = $this->findLpp($lppid);
        if (($alasan = TblAlasanSemakan::findOne(['lpp_id' => $lppid])) != null) {
            $alasan = TblAlasanSemakan::findOne(['lpp_id' => $lppid]);
        } else {
            $alasan = null;
        }
        return $this->renderAjax('//elnpt/mohon_semak', [
            'model' => $lpp,
            'alasan' => $alasan
        ]);
    }

    public function actionMarkahTidakSetuju($lppid)
    {
        $lpp = $this->findLpp($lppid);
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
                return $this->redirect(['elnpt2/pengesahan-markah', 'lppid' => $lppid]);
            }
        }
        return $this->renderAjax('//elnpt/sah_pyd_markah', [
            'model' => $alasan
        ]);
    }

    public function actionPerkhidmatanTahun($lppid)
    {
        $lpp = $this->findLpp($lppid);

        $kilanan = TblKilanan::find()->where(['lpp_id' => $lppid]);

        $dataProvider = new ActiveDataProvider([
            'query' => $kilanan,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('kilanan', [
            'dataProvider' => $dataProvider,
            'lpp' => $lpp,
            'lppid' => $lppid,
            'menu' => $this->menu($lpp),
            'check' => $this->checkEligible($lpp),
        ]);
    }

    public function actionSemakPerkhidmatanTahun($lppid)
    {
        $lpp = $this->findLpp($lppid);

        $kilanan = TblKilanan::find()->where(['lpp_id' => $lppid]);

        $dataProvider = new ActiveDataProvider([
            'query' => $kilanan,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('kilanan', [
            'dataProvider' => $dataProvider,
            'lpp' => $lpp,
            'lppid' => $lppid,
            'menu' => $this->menu($lpp),
            'check' => $this->checkEligible($lpp),
        ]);
    }

    public function actionTambahSebabCadangan($lppid)
    {
        $kilanan = new TblKilanan();
        if ($kilanan->load(Yii::$app->request->post())) {
            $kilanan->lpp_id = $lppid;
            $kilanan->kilanan_dt = new \yii\db\Expression('NOW()');
            if ($kilanan->validate() && $kilanan->save()) {
                $kilanan->save(false);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->renderAjax('sebab_cadangan', [
            'kilanan' => $kilanan,
        ]);
    }

    public function actionEditSebabCadangan($id, $lppid)
    {
        $kilanan = TblKilanan::findOne(['id' => $id, 'lpp_id' => $lppid]);
        if ($kilanan->load(Yii::$app->request->post())) {
            $kilanan->kilanan_dt = new \yii\db\Expression('NOW()');
            if ($kilanan->validate() && $kilanan->save()) {
                $kilanan->save(false);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dikemaskini!']);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->renderAjax('sebab_cadangan', [
            'kilanan' => $kilanan,
        ]);
    }

    public function actionPadamSebabCadangan($id, $lppid)
    {
        $kilanan = TblKilanan::findOne(['id' => $id, 'lpp_id' => $lppid]);
        $kilanan->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionViewFile($hashfile, $lppid)
    {
        if ($hashfile == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->redirect(Yii::$app->FileManager->DisplayFile($hashfile));
    }

    public function actionCalculatorLnpt()
    {
        \yii\helpers\Url::remember();

        $query = \app\models\elnpt\simulation\RefAktivitiv2::find()->orderBy(['kategori' => SORT_ASC, 'kategori' => SORT_ASC, 'order_no' => SORT_ASC, 'isHakiki' => SORT_ASC,]);

        $calcInput = new \app\models\elnpt\simulation\TblCalcInput();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $arry = [];

        $count = $query->count();
        $settings = [new \app\models\elnpt\simulation\TblCalcData()];
        for ($i = 1; $i < $count; $i++) {
            $settings[] = new \app\models\elnpt\simulation\TblCalcData();
        }

        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {

            $form_data = array();

            $data = json_decode(stripslashes(Yii::$app->request->post()['tmp']), true);

            foreach ($data as $item) {
                $form_data[$item['name']] = $item['value'];
            };

            $calcInput = new \app\models\elnpt\simulation\TblCalcInput();

            $nsAtt = $calcInput->attributes;

            foreach ($nsAtt as $key => $value) {
                $nsAtt[$key] = $form_data['TblCalcInput[' . $key . ']'];
            }

            $calcInput->setAttributes($nsAtt);

            $count = $query->count();
            $settings = [new \app\models\elnpt\simulation\TblCalcData()];
            for ($i = 0; $i < $count; $i++) {
                $settings[] = new \app\models\elnpt\simulation\TblCalcData();
                $babi = $settings[$i]->attributes;
                foreach ($babi as $key => $value) {
                    $babi[$key] = $form_data['TblCalcData[' . $i . '][' . $key . ']'];
                }
                $settings[$i]->setAttributes($babi);
            }

            array_pop($settings);

            if (Model::validateMultiple($settings)) {
                $this->calcKategori1($settings, $calcInput->bilpelajar, $calcInput->jawatan);
                $this->calcKategori2($settings);
                $this->calcKategori3($settings);
                $this->calcKategori4($settings, $calcInput->gugusan);
                $this->calcKategori5($settings);
                $this->calcKategori6($settings);
                // return VarDumper::dump(ArrayHelper::index(ArrayHelper::toArray($settings), null, 'kategori')[6], $depth = 10, $highlight = true);
                $result = ArrayHelper::index(ArrayHelper::toArray($settings), null, 'kategori');

                $this->kategori1_2($result, $calcInput->gred, $peratusPemberatk12, $calcInput->pemberatK1, $calcInput->peratusMax);
                $this->kategori3_4($result, $calcInput->gred, $peratusPemberatk34, $calcInput->pemberatK2, $calcInput->peratusMax);
                $this->kategori5($result, $calcInput->isElaun, $calcInput->gred, $peratusPemberatk5, $calcInput->pemberatK3, $calcInput->peratusMax);
                $this->kategori6($result, $calcInput->gred, $peratusPemberatk6, $calcInput->pemberatK4, $calcInput->peratusMax);
                $arry =  [
                    'fapi' => \app\models\elnpt\simulation\RefCalcFapi::findOne($calcInput->fapi)->label,
                    'gred' => $calcInput->gred . ' - ' . ($calcInput->isElaun ? 'PENTADBIR' : 'BUKAN PENTADBIR'),
                    'gugusan' => $calcInput->gugusanLabel,
                    '1_2' => Yii::$app->formatter->asDecimal($peratusPemberatk12, 2) . '% daripada ' . $calcInput->pemberatK1 . '%',
                    '3_4' => Yii::$app->formatter->asDecimal($peratusPemberatk34, 2) . '% daripada ' . $calcInput->pemberatK2 . '%',
                    '5' => Yii::$app->formatter->asDecimal($peratusPemberatk5, 2) . '% daripada ' . $calcInput->pemberatK3 . '%',
                    '6' => Yii::$app->formatter->asDecimal($peratusPemberatk6, 2) . '% daripada ' . $calcInput->pemberatK4 . '%',
                    'jumlah_komponen' => Yii::$app->formatter->asDecimal(($peratusPemberatk12 + $peratusPemberatk34 + $peratusPemberatk5 + $peratusPemberatk6), 2) . '% daripada 100%',
                    'jumlah_komponen_pro' => Yii::$app->formatter->asDecimal((($peratusPemberatk12 + $peratusPemberatk34 + $peratusPemberatk5 + $peratusPemberatk6) / 100 * 90), 2) . '% daripada 90%',
                    'jumlah_komponen_sahsiah' => Yii::$app->formatter->asDecimal($calcInput->sahsiah ?? 0) . '% daripada 10%',
                    'markah_seluruh' => Yii::$app->formatter->asDecimal((($peratusPemberatk12 + $peratusPemberatk34 + $peratusPemberatk5 + $peratusPemberatk6) / 100 * 90) + ($calcInput->sahsiah ?? 0), 2),
                    'kategori' => $this->getJulatPeratus(Yii::$app->formatter->asDecimal((($peratusPemberatk12 + $peratusPemberatk34 + $peratusPemberatk5 + $peratusPemberatk6) / 100 * 90) + ($calcInput->sahsiah ?? 0), 2)),
                ];
            }

            return $this->renderAjax('_summaryMark', [
                'dataProvider' => $dataProvider,
                'inputs' => $settings,
                'calcInput' => $calcInput,
                'arry' => $arry,
            ]);
        }

        return $this->render('calculator', [
            'dataProvider' => $dataProvider,
            'inputs' => $settings,
            'calcInput' => $calcInput,
            'arry' => $arry,
        ]);
    }

    public function actionAssignInputs($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $fapi = \app\models\elnpt\simulation\RefCalcFapi::findOne($id);
        return [
            'limpahan' => $fapi->limpahan,
            'k1_k2' => $fapi->k1_k2,
            'k3_k4' => $fapi->k3_k4,
            'k5' => $fapi->k5,
            'k6' => $fapi->k6,
            'saiz' => $fapi->saiz_kelas,
        ];
    }

    protected function calcKategori1(&$inputsKategori1, $bil_pelajar = 50, $jawatan)
    {
        foreach ($inputsKategori1 as $ind => $ik1) {
            if ($ik1->kategori == 1) {
                ArrayHelper::setValue($inputKomponen1, ($ind + 1), ['skor' => $ik1->bil, 'nilai_mata' => $ik1->nilai_mata, 'order_no' => $ik1->order_no, 'kategori' => $ik1->kategori]);
            }
        }

        $mataKomponen1 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 1, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();

        foreach ($inputKomponen1 as $ind => $ik) {
            ArrayHelper::setValue($skorKomponen1, $ind, (($ind == 7) ? (((1 / $bil_pelajar) * $ik['skor'])) : (($mataKomponen1[$ik['order_no']]['nilai_mata'] * $ik['skor']))));
        }

        foreach ($inputsKategori1 as $ind => $sett) {
            if ($sett->kategori == 1) {
                if ($ind == 0) {
                    $sett->mata = $skorKomponen1[$inputsKategori1[$ind]->aktiviti_id] * \app\models\elnpt\simulation\TblCalcInput::jawatanPentadbiran()[$jawatan];
                    continue;
                }

                $sett->mata = $skorKomponen1[$inputsKategori1[$ind]->aktiviti_id];
            }
        }
    }

    protected function calcKategori2(&$inputsKategori2)
    {
        foreach ($inputsKategori2 as $ind => $ik1) {
            if ($ik1->kategori == 2) {
                ArrayHelper::setValue($inputKomponen1, ($ind + 1), ['skor' => $ik1->bil, 'nilai_mata' => $ik1->nilai_mata, 'order_no' => $ik1->order_no, 'kategori' => $ik1->kategori]);
            }
        }

        $mataKomponen1 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 2, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen2 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 2, 'nilai_mata_id' => 2])->indexBy(['aktiviti_id'])->asArray()->all();

        foreach ($inputKomponen1 as $ind => $ik) {
            ArrayHelper::setValue($skorKomponen2, $ind, (($ik['nilai_mata'] == 1) ? (($mataKomponen1[$ik['order_no']]['nilai_mata'] * $ik['skor'])) : (($mataKomponen2[$ik['order_no']]['nilai_mata'] * $ik['skor']))));
        }

        foreach ($inputsKategori2 as $ind => $sett) {
            if ($sett->kategori == 2) {
                $sett->mata = $skorKomponen2[$inputsKategori2[$ind]->aktiviti_id];
            }
        }
    }

    protected function calcKategori3(&$inputsKategori3)
    {
        foreach ($inputsKategori3 as $ind => $ik1) {
            if ($ik1->kategori == 3) {
                ArrayHelper::setValue($inputKomponen1, ($ind + 1), ['skor' => $ik1->bil, 'nilai_mata' => $ik1->nilai_mata, 'order_no' => $ik1->order_no, 'kategori' => $ik1->kategori, 'aktiviti' => $ik1->aktiviti_id]);
            }
        }

        $mataKomponen1 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 3, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen2 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 3, 'nilai_mata_id' => 2])->indexBy(['aktiviti_id'])->asArray()->all();

        $base = 10000;

        foreach ($inputKomponen1 as $ind => $ik) {
            if (($ik['order_no'] == 6) || ($ik['order_no'] == 7) || ($ik['order_no'] == 8)) {
                ArrayHelper::setValue($skorKomponen2, $ik['aktiviti'], $ik['nilai_mata'] ? (($ik['nilai_mata'] == 1) ? (($mataKomponen1[$ik['order_no']]['nilai_mata'] * ($ik['skor'] / $base))) : (($mataKomponen2[$ik['order_no']]['nilai_mata'] * ($ik['skor'] / $base)))) : ((($mataKomponen2[$ik['order_no']]['nilai_mata'] / 2) * ($ik['skor'] / $base))));
                continue;
            }

            ArrayHelper::setValue($skorKomponen2, $ik['aktiviti'], $ik['nilai_mata'] ? (($ik['nilai_mata'] == 1) ? (($mataKomponen1[$ik['order_no']]['nilai_mata'] * $ik['skor'])) : (($mataKomponen2[$ik['order_no']]['nilai_mata'] * $ik['skor']))) : ((($mataKomponen2[$ik['order_no']]['nilai_mata'] / 2) * $ik['skor'])));
        }

        foreach ($inputsKategori3 as $ind => $sett) {
            if ($sett->kategori == 3) {
                $sett->mata = $skorKomponen2[$sett->aktiviti_id];
            }
        }
    }

    protected function calcKategori4(&$inputsKategori4, $jenis)
    {
        foreach ($inputsKategori4 as $ind => $ik1) {
            if ($ik1->kategori == 4) {
                ArrayHelper::setValue($inputKomponen1, ($ind + 1), ['skor' => $ik1->bil, 'nilai_mata' => $jenis, 'order_no' => $ik1->order_no, 'kategori' => $ik1->kategori, 'aktiviti' => $ik1->aktiviti_id, 'jenis' => $ik1->jenis]);
            }
        }

        $mataKomponen1 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 4, 'nilai_mata_id' => $jenis])->indexBy(['aktiviti_id'])->asArray()->all();

        foreach ($inputKomponen1 as $ind => $ik) {

            if (!empty($ik['jenis']) || !is_null($ik['jenis'])) {
                $abc = $this->skorArtikel($ik['jenis'], $jenis) / $ik['skor'];
                ArrayHelper::setValue($skorKomponen2, $ik['aktiviti'], is_nan($abc) ? 0 : $abc);
                continue;
            }

            ArrayHelper::setValue($skorKomponen2, $ik['aktiviti'], (($mataKomponen1[$ik['order_no']]['nilai_mata'] * $ik['skor'])));
        }



        foreach ($inputsKategori4 as $ind => $sett) {
            if ($sett->kategori == 4) {
                $sett->mata = is_finite($skorKomponen2[$sett->aktiviti_id]) ?  $skorKomponen2[$sett->aktiviti_id] : 0;
            }
        }
    }

    protected function calcKategori5(&$inputsKategori5)
    {
        foreach ($inputsKategori5 as $ind => $ik1) {
            if ($ik1->kategori == 5) {
                ArrayHelper::setValue($inputKomponen1, ($ind + 1), ['skor' => $ik1->bil, 'nilai_mata' => $ik1->nilai_mata, 'order_no' => $ik1->order_no, 'kategori' => $ik1->kategori, 'aktiviti' => $ik1->aktiviti_id]);
            }
        }

        $mataKomponen1 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 5, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen2 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 5, 'nilai_mata_id' => 2])->indexBy(['aktiviti_id'])->asArray()->all();
        $mataKomponen3 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 5, 'nilai_mata_id' => 3])->indexBy(['aktiviti_id'])->asArray()->all();

        $base = 10000;
        $ahli = 0;

        foreach ($inputKomponen1 as $ind => $ik) {
            $tmpp = 0;

            if (($ik['aktiviti'] == 137)) {
                $amaun = $ik['skor'];
                ArrayHelper::setValue($skorKomponen2, $ik['aktiviti'], $ik['skor'] ? ($ik['skor'] / $base * $mataKomponen1[14]['nilai_mata']) : 0);
                continue;
            }

            if (($ik['aktiviti'] == 138)) {
                ArrayHelper::setValue($skorKomponen2, $ik['aktiviti'], 0);
                $ahli = $ik['skor'];
                continue;
            }

            if (($ik['aktiviti'] == 139)) {
                ArrayHelper::setValue($skorKomponen2, $ik['aktiviti'], $ik['skor'] ? ($ahli / $base * $mataKomponen1[14]['nilai_mata'] / $ik['skor']) : 0);
                continue;
            }

            switch ($ik['nilai_mata']) {
                case 1:
                    $tmpp = (($mataKomponen1[$ik['order_no']]['nilai_mata'] * $ik['skor']));
                    break;
                case 2:
                    $tmpp = (($mataKomponen2[$ik['order_no']]['nilai_mata'] * $ik['skor']));
                    break;
                case 3:
                    $tmpp = (($mataKomponen3[$ik['order_no']]['nilai_mata'] * $ik['skor']));
                    break;
            }

            ArrayHelper::setValue($skorKomponen2, $ik['aktiviti'], $tmpp);
        }



        foreach ($inputsKategori5 as $ind => $sett) {
            if ($sett->kategori == 5) {
                $sett->mata = $skorKomponen2[$sett->aktiviti_id];
            }
        }
    }

    protected function calcKategori6(&$inputsKategori6)
    {
        foreach ($inputsKategori6 as $ind => $ik1) {
            if ($ik1->kategori == 6) {
                ArrayHelper::setValue($inputKomponen1, ($ind + 1), ['skor' => $ik1->bil, 'nilai_mata' => $ik1->nilai_mata, 'order_no' => $ik1->order_no, 'kategori' => $ik1->kategori, 'aktiviti' => $ik1->aktiviti_id]);
            }
        }

        $mataKomponen1 = \app\models\elnpt\simulation\TblMatav2::find()->select(['nilai_mata', 'aktiviti_id'])->where(['kategori_id' => 6, 'nilai_mata_id' => 1])->indexBy(['aktiviti_id'])->asArray()->all();

        foreach ($inputKomponen1 as $ind => $ik) {
            ArrayHelper::setValue($skorKomponen2, $ik['aktiviti'], (($mataKomponen1[$ik['order_no']]['nilai_mata'] * $ik['skor'])));
        }



        foreach ($inputsKategori6 as $ind => $sett) {
            if ($sett->kategori == 6) {
                $sett->mata = $skorKomponen2[$sett->aktiviti_id];
            }
        }
    }

    public function kategori1_2($settings, $gred, &$peratusPemberat, $pemberatFapi = 40, $peratus)
    {
        $merge = array_merge($settings[1], $settings[2]);
        $tmp = ArrayHelper::getColumn($merge, 'mata');

        $sasaranHakiki = (strpos($gred, 'DG') === false) ? 45.1 : 54.8;
        $sasaranNonHakiki = (strpos($gred, 'DG') === false) ? 19.33 : 23.49;

        $totalMata1 = array_sum(array_slice($tmp, 0, 6))  + array_sum(array_slice($tmp, 13, 10));
        $sasaran1 = $sasaranHakiki * $this->multiplier($gred);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $test = min($limpahanHakiki, (($peratus ?? (1 / 3) * 100) / 100) *  $sasaranNonHakiki);
        $totalMata2 = array_sum(array_slice($tmp, 6, 7)) +  array_sum(array_slice($tmp, 23)) + $test;
        $sasaran2 =  $sasaranNonHakiki * $this->multiplier($gred);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $jumlah = round($mataHakiki + $mataNonHakiki);
        $peratus = round($jumlah / round($sasaran1 + $sasaran2) * 100);
        $peratusPemberat = round(($peratus * $pemberatFapi) / 100);
        // return VarDumper::dump($jumlah, $depth = 10, $highlight = true);
    }

    public function kategori3_4($settings, $gred, &$peratusPemberat, $pemberatFapi = 40, $peratus)
    {
        $merge = array_merge($settings[3], $settings[4]);
        $tmp = ArrayHelper::getColumn($merge, 'mata');


        $sasaranHakiki = (strpos($gred, 'DG') === false) ? 26 : 4;
        $sasaranNonHakiki = (strpos($gred, 'DG') === false) ? 11 : 2;

        $totalMata1 = array_sum(array_slice($tmp, 0, 24))  + array_sum(array_slice($tmp, 37, 12));
        $sasaran1 = $sasaranHakiki * $this->multiplier($gred);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $test = min($limpahanHakiki, (($peratus ?? (1 / 3) * 100) / 100) *  $sasaranNonHakiki);
        $totalMata2 = round(array_sum(array_slice($tmp, 24, 13)) +  array_sum(array_slice($tmp, 49))) + $test;
        $sasaran2 =  $sasaranNonHakiki * $this->multiplier($gred);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $jumlah = round($mataHakiki + $mataNonHakiki);
        $peratus = round($jumlah / round($sasaran1 + $sasaran2) * 100);
        $peratusPemberat = round(($peratus * $pemberatFapi) / 100);
        // return VarDumper::dump($peratusPemberat, $depth = 10, $highlight = true);
    }

    public function kategori5($settings, $statusElaun, $gred, &$peratusPemberat, $pemberatFapi = 20, $peratus)
    {
        $sasaranHakikiElaun = 36;
        $sasaranNonHakikiElaun = 15;

        $sasaranHakikiNonElaun = 9;
        $sasaranNonHakikiNonElaun = 4;

        $totalMata1 = array_sum(array_slice(ArrayHelper::getColumn($settings[5], 'mata'), 0, 17, true));
        $sasaran1 = ($statusElaun ? $sasaranHakikiElaun : $sasaranHakikiNonElaun) * $this->multiplier($gred);
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $test = min($limpahanHakiki, (($peratus ?? (1 / 3) * 100) / 100) * $statusElaun ? $sasaranNonHakikiElaun : $sasaranNonHakikiNonElaun);
        $totalMata2 = array_sum(array_slice(ArrayHelper::getColumn($settings[5], 'mata'), 17)) + $test;
        $sasaran2 = ($statusElaun ? $sasaranNonHakikiElaun : $sasaranNonHakikiNonElaun) * $this->multiplier($gred);
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $jumlah = round($mataHakiki + $mataNonHakiki);
        $peratus = round($jumlah / round($sasaran1 + $sasaran2) * 100);
        $peratusPemberat = round(($peratus * $pemberatFapi) / 100);
    }

    public function kategori6($settings, $gred, &$peratusPemberat, $pemberatFapi = 0, $peratus)
    {
        $merge = array_merge($settings[6]);
        $tmp = ArrayHelper::getColumn($merge, 'mata');

        $sasaranHakiki = (strpos($gred, 'DU') === false) ? 0 : 16;
        $sasaranNonHakiki = (strpos($gred, 'DU') === false) ? 0 : 7;

        $totalMata1 = array_sum(array_slice($tmp, 0, 9, true));
        $sasaran1 = $sasaranHakiki;
        $mataHakiki = min($totalMata1, $sasaran1);
        $limpahanHakiki = $totalMata1 - $mataHakiki;

        $test = min($limpahanHakiki, (($peratus ?? (1 / 3) * 100) / 100) * $sasaranNonHakiki);
        $totalMata2 = array_sum(array_slice($tmp, 9)) + $test;
        $sasaran2 = $sasaranNonHakiki;
        $mataNonHakiki = min($totalMata2, $sasaran2);

        $jumlah = round($mataHakiki + $mataNonHakiki);
        $peratus = $sasaranHakiki ? round($jumlah / round($sasaran1 + $sasaran2) * 100) : 0;
        $peratusPemberat = round(($peratus * $pemberatFapi) / 100);

        // return VarDumper::dump($peratusPemberat, $depth = 10, $highlight = true);
    }

    protected function multiplier($gred)
    {
        switch ($gred) {
            case 'DS45':
                return 1;
                break;
            case 'DS52':
                return 1.2;
                break;
            case 'DS51':
                return 1.2;
                break;
            case 'DU51':
                return 1.2;
                break;
            case 'DU52':
                return 1.2;
                break;
            case 'DS54':
                return 1.4;
                break;
            case 'DS53':
                return 1.4;
                break;
            case 'DU53':
                return 1.4;
                break;
            case 'DU54':
                return 1.4;
                break;
            case 'DU55':
                return 1.4;
                break;
            case 'DU56':
                return 1.4;
                break;
            case 'VK7':
                return 1.6;
                break;
            case 'VK6':
                return 1.8;
                break;
            case 'VK5':
                return 2;
                break;
            case 'DG41':
                return 1;
                break;
            case 'DG44':
                return 1;
                break;
            case 'DG48':
                return 1.2;
                break;
            case 'DG52':
                return 1.4;
                break;
            case 'DG54':
                return 1.6;
                break;
            default:
                return 1;
                break;
        }
    }

    protected function skorArtikel($jenis, $gred)
    {
        switch ($jenis) {
            case 1:
                if ($gred == 1) return 5;
                return 2.5;
                break;
            case 2:
                if ($gred == 1) return 1.5;
                return 0.75;
                break;
            case 3:
                if ($gred == 1) return 2.5;
                return 5;
                break;
            case 4:
                if ($gred == 1) return 2;
                return 4;
                break;
            case 5:
                if ($gred == 1) return 1.5;
                return 3;
                break;
            case 6:
                if ($gred == 1) return 1;
                return 2;
                break;
            case 7:
                if ($gred == 1) return 1;
                return 0.5;
                break;
            case 8:
                if ($gred == 1) return 0.5;
                return 0.25;
                break;
            case 9:
                if ($gred == 1) return 0.625;
                return 1.25;
                break;
            case 10:
                if ($gred == 1) return 0.5;
                return 0.5;
                break;
            case 11:
                if ($gred == 1) return 0.5;
                return 0.5;
                break;
            case 12:
                if ($gred == 1) return 0.25;
                return 0.25;
                break;
            default:
                return 0;
                break;
        }
    }

    protected function getLantikanPertama($umsper, $tahun)
    {
        $arry = [
            //24-03-2022
            ["210802-04523", 2021],
            ["210802-04524", 2021],
            ["210816-04545", 2021],
            ["210802-04518", 2021],
            ["210802-04522", 2021],
            ["210802-04520", 2021],
            ["211102-04591", 2021],
            ["210920-04553", 2021],
            ["211018-04564", 2021],
            ["211108-04601", 2021],
            ["210802-04521", 2021],
            ["210930-04554", 2021],
            ["211018-04566", 2021],
            ["210823-04547", 2021],
            ["210901-04548", 2021],
            ["211018-04568", 2021],
            ["211018-04569", 2021],
            ["211018-04570", 2021],
            ["211020-04575", 2021],
            ["211025-04576", 2021],
            ["211025-04577", 2021],
            ["211101-04589", 2021],
            ["211101-04590", 2021],
            ["211105-04600", 2021],
            ["211118-04612", 2021],
            ["211018-04565", 2021],
        ];

        $test = in_array([$umsper, $tahun], $arry);

        // return \Yii::createObject([
        //     'class' => 'yii\web\Response',
        //     'format' => \yii\web\Response::FORMAT_JSON,
        //     'data' => [
        //         'isLantikanPertama' => $test,
        //     ],
        // ]);

        return $test;
    }

    protected function getJulatPeratus($markah)
    {
        switch (true) {
            case ($markah > 0 && $markah < 50):
                return 'LEMAH';
                break;
            case ($markah >= 50 && $markah < 60):
                return 'KURANG MEMUASKAN';
                break;
            case ($markah >= 60 && $markah < 80):
                return 'SEDERHANA';
                break;
            case ($markah >= 80 && $markah < 90):
                return 'BAIK';
                break;
            case ($markah >= 90):
                return 'CEMERLANG';
                break;
            default:
                return 'TIADA MAKLUMAT/ BELUM ISI';
                break;
        }
    }
}
