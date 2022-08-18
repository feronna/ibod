<?php


namespace app\controllers;

use app\models\Notification;
use app\models\hronline\Tblprcobiodata;
use app\models\lnpk\TblprcobiodataSearch;
use app\models\lnpk\TblMain;
use app\models\lnpk\TblMainSearch;
use app\models\lppums\TblLppTahun;
use app\models\lnpk\RefKriteria;
use app\models\lnpk\TblAktiviti;
use app\models\lnpk\TblKriteriaKategori;
use app\models\lnpk\TblKriteriaMarkah;
use app\models\lnpk\TblLnpkMarkah;
use app\models\lnpk\TblSasaranPencapaian;
use app\models\lnpk\TblUlasan;
use app\models\lppums\TblStafAkses;
use Yii;


use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\base\UserException;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use app\models\lnpk\Model;
use app\models\lnpk\TblSkt;
use app\models\lnpk\TblSktTandatangan;

class LnpkController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [
                            'senarai-pyd'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblMain::find()->where(['OR', ['PPP' => Yii::$app->user->identity->ICNO], ['PPK' => Yii::$app->user->identity->ICNO],])->exists();

                            if ($query) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'senarai-borang'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblMain::find()->where(['PYD' => Yii::$app->user->identity->ICNO])->exists();

                            if ($query) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'bahagian1', 'bahagian2', 'bahagian3', 'bahagian-skt-pencapaian',
                            'tandatangan-ulasan-ppp', 'tandatangan-ulasan-ppk',
                            'pengesahan', 'pengesahan-ppp', 'pengesahan-ppk',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $lnpk_id = Yii::$app->request->get('lnpk_id');
                            $query = TblMain::find()
                                ->where(['lnpk_id' => $lnpk_id])
                                ->andWhere(
                                    [
                                        'OR',
                                        ['PYD' => Yii::$app->user->identity->ICNO],
                                        ['PPP' => Yii::$app->user->identity->ICNO],
                                        ['AND', ['isPP' => 0], ['PPK' => Yii::$app->user->identity->ICNO]],
                                    ]
                                )->exists();


                            $admin = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_lpp_tahun', NULL])
                                ->one();


                            if ($query or $admin) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'tambah-skt', 'update-skt', 'delete-skt', 'tandatangan-skt',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $lnpk_id = Yii::$app->request->get('lnpk_id');
                            $query = TblMain::findOne([
                                'lnpk_jenis' => 2,
                                'lnpk_id' => $lnpk_id, ['OR', ['PYD' => Yii::$app->user->identity->ICNO], ['PPP' => Yii::$app->user->identity->ICNO]]
                            ]);

                            $admin = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_lpp_tahun', NULL])
                                ->one();

                            if ($query or $admin) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak dibenarkan masuk ke halaman ini.');
                            }
                        }
                    ],
                    [
                        'actions' => [
                            'carian-borang', 'create-borang', 'update-borang'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $admin = TblStafAkses::find()
                                ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
                                ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['IS NOT', 'a.akses_lpp_tahun', NULL])
                                ->one();


                            if ($admin) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk masuk ke halaman ini.');
                            }
                        }
                    ],
                ],
            ],


        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionSenaraiBorang()
    {
        $query = TblMain::find()
            ->where(['is_deleted' => 0])
            ->andWhere(['PYD' => Yii::$app->user->identity->ICNO])
            ->orderBy(['tahun' => SORT_DESC]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);


        return $this->render('senarai_borang', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionBahagian1($lnpk_id)
    {
        $lnpk = $this->findLnpk($lnpk_id);


        return $this->render('bahagian1', [
            'lnpk' => $lnpk,
        ]);
    }


    public function actionBahagian2($lnpk_id)
    {
        $lnpk = $this->findLnpk($lnpk_id);

        $query = TblKriteriaMarkah::find()
            ->alias('km')
            ->select(['km.kriteria_markah_ppp', 'km.kriteria_markah_ppk', 'rk.kriteria_desc', 'rk.kriteria_label', 'rk.kriteria_id', 'rk.array_id'])
            // ->joinWith('kriteria kk', true, 'RIGHT JOIN')
            ->rightJoin(['kk' => 'hrm.lnpk_tbl_kriteria_kategori'], 'km.id_ref_kriteria = kk.id_ref_kriteria and km.lnpk_id = ' . $lnpk_id)
            ->leftJoin(['rk' => 'hrm.lnpk_ref_kriteria'], 'rk.kriteria_id = kk.id_ref_kriteria')
            ->where(['kk.id_ref_lnpk' => $lnpk->lnpk_jenis])
            ->orderBy(['rk.array_id' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $marks = TblKriteriaMarkah::find()
            ->where(['lnpk_id' => $lnpk->lnpk_id])
            ->all();

        $marksArry = ArrayHelper::toArray($marks, [
            'app\models\lnpk\TblKriteriaMarkah' => [
                'kriteria_markah_ppp',
                'kriteria_markah_ppk',
            ],
        ]);

        if ($marks == null) {
            $marks = Model::createMultiple(TblKriteriaMarkah::classname());
        }

        if (Model::loadMultiple($marks, Yii::$app->request->post('TblKriteriaMarkah'), '')) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $flag = false;
                foreach ($marks as $mark) {
                    $mark->lnpk_id = $lnpk->lnpk_id;

                    if ($lnpk->PPP == Yii::$app->user->identity->ICNO) {
                        $mark->kemaskini_dt_ppp = new \yii\db\Expression('NOW()');
                    } else {
                        $mark->kemaskini_dt_ppk = new \yii\db\Expression('NOW()');
                    }

                    if (!($flag = $mark->save())) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    \Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Markah berjaya disimpan!']);
                    return $this->redirect(Yii::$app->request->referrer);
                }
            } catch (ForbiddenHttpException $e) {
                $transaction->rollBack();
                \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Error saving data! Please try again.']);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->render('bahagian2', [
            'lnpk' => $lnpk,
            'dataProvider' => $dataProvider,
            'totalPPP' => array_sum(ArrayHelper::getColumn($marksArry, 'kriteria_markah_ppp')),
            'totalPPK' => array_sum(ArrayHelper::getColumn($marksArry, 'kriteria_markah_ppk')),
        ]);
    }


    public function actionBahagian3($lnpk_id)
    {
        \yii\helpers\Url::remember();
        $lnpk = $this->findLnpk($lnpk_id);


        if (($model = TblUlasan::find()->where(['lnpk_id' => $lnpk_id])->one()) === null) {
            $model = new TblUlasan();
            $model->lnpk_id = $lnpk_id;
        }

        if ($model->load(Yii::$app->request->post())) {
            // if ($lnpk->PPP == Yii::$app->user->identity->ICNO) {
            //     $model->scenario = 'ppp';
            // } else {
            //     $model->scenario = 'ppk';
            // }

            // $model->attributes = $_POST['TblUlasan'];

            if ($model->validate()) {
                $model->save();
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ulasan berjaya disimpan!']);
                return $this->redirect(['lnpk/bahagian3', 'lnpk_id' => $lnpk_id]);
            } else {
                if (isset($model->getErrors()[0])) {
                    \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => $model->getErrors()[0][0]]);
                    return $this->goBack();
                } else {
                    \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Error saving data! Please try again.']);
                    return $this->goBack();
                }
            }
        }


        return $this->render('bahagian3', [
            'lnpk' => $lnpk,
            'model' => $model,
        ]);
    }

    public function actionBahagianSktPencapaian($lnpk_id)
    {
        \yii\helpers\Url::remember();

        $lnpk = $this->findLnpk($lnpk_id);

        if ($lnpk->lnpk_jenis == 1) {
            throw new ForbiddenHttpException('The requested page does not exist.');
        }

        $sktTT = $this->findSktTandatangan($lnpk_id);

        $skt = TblSkt::find()->where(['lnpk_id' => $lnpk_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $skt,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => false,
        ]);

        return $this->render('senarai_skt', [
            'lnpk' => $lnpk,
            'dataProvider' => $dataProvider,
            'sktTT' => $sktTT,
        ]);
    }

    public function actionPengesahan($lnpk_id)
    {
        $lnpk = $this->findLnpk($lnpk_id);

        return $this->render('pengesahan', [
            'lnpk' => $lnpk,
        ]);
    }

    public function actionPengesahanPpp($lnpk_id)
    {
        $lnpk = $this->findLnpk($lnpk_id);

        $lnpk->scenario = 'sah_ppp';

        if ($lnpk->load(Yii::$app->request->post())) {
            $lnpk->PPP_sah = 1;
            $lnpk->PPP_sah_datetime = new \yii\db\Expression('NOW()');
            //            $model->lpp_id = $lppid;
            //            $model->skt_status = 'TAMB';
            if ($lnpk->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Penilaian Prestasi Tahun berjaya disahkan!']);
                return $this->redirect(['lnpk/pengesahan', 'lnpk_id' => $lnpk_id]);
            }
        }

        return $this->renderAjax('sah_ppp', [
            'model' => $lnpk,
        ]);
    }

    public function actionPengesahanPpk($lnpk_id)
    {
        $lnpk = $this->findLnpk($lnpk_id);

        $lnpk->scenario = 'sah_ppk';

        if ($lnpk->load(Yii::$app->request->post())) {
            $lnpk->PPK_sah = 1;
            $lnpk->PPK_sah_datetime = new \yii\db\Expression('NOW()');
            //            $model->lpp_id = $lppid;
            //            $model->skt_status = 'TAMB';
            if ($lnpk->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Penilaian Prestasi Tahun berjaya disahkan!']);
                return $this->redirect(['lnpk/pengesahan', 'lnpk_id' => $lnpk_id]);
            }
        }

        return $this->renderAjax('sah_ppk', [
            'model' => $lnpk,
        ]);
    }

    public function actionTambahSkt($lnpk_id)
    {
        $skt = new TblSkt();

        if ($skt->load(Yii::$app->request->post())) {
            $skt->lnpk_id = $lnpk_id;
            if ($skt->validate() && $skt->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Aktiviti berjaya disimpan!']);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->renderAjax('borang_skt', [
            'skt' => $skt,
        ]);
    }

    public function actionUpdateSkt($skt_id)
    {
        $skt = $this->findSkt($skt_id);

        if ($skt->load(Yii::$app->request->post())) {
            if ($skt->validate() && $skt->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Aktiviti berjaya dikemaskini!']);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->renderAjax('borang_skt', [
            'skt' => $skt,
        ]);
    }

    public function actionDeleteSkt($skt_id)
    {
        $skt = $this->findSkt($skt_id);

        try {
            // throw new UserException('The requested page does not exist.');
            $skt->delete();
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Aktiviti berjaya dipadam!']);
            return $this->redirect(Yii::$app->request->referrer);
        } catch (ForbiddenHttpException $e) {
            \Yii::$app->session->setFlash('alert', ['title' => 'Error', 'type' => 'warning', 'msg' => 'Cannot delete record. Contact the System Admin.']);
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionTandatanganSkt($lnpk_id)
    {
        $lnpk = $this->findLnpk($lnpk_id);
        $sktTT = $this->findSktTandatangan($lnpk_id);

        if (is_null($sktTT->sign_PYD)) {
            if ($lnpk->PYD == Yii::$app->user->identity->ICNO || $lnpk->isAdmin()) {
                $sktTT->sign_PYD = $lnpk->PYD;
                $sktTT->sign_dt_PYD = new \yii\db\Expression('NOW()');
                $sktTT->save(false);
            }
        }

        if (is_null($sktTT->sign_PP)) {
            if ($lnpk->PPP == Yii::$app->user->identity->ICNO || $lnpk->isAdmin()) {
                $sktTT->sign_PP = $lnpk->PPP;
                $sktTT->sign_dt_PP = new \yii\db\Expression('NOW()');
                $sktTT->save(false);
            }
        }

        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya disahkan!']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function findLnpk($lnpk_id)
    {
        if (($model = TblMain::findOne(['lnpk_id' => $lnpk_id])) !== null) {
            return $model;
        }


        throw new ForbiddenHttpException('The requested page does not exist.');
    }

    protected function findSkt($skt_id)
    {
        if (($model = TblSkt::findOne($skt_id)) !== null) {
            return $model;
        }
        throw new ForbiddenHttpException('The requested page does not exist.');
    }

    protected function findBiodata($icno)
    {
        if (($model = Tblprcobiodata::findOne(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new ForbiddenHttpException('The requested page does not exist.');
    }

    protected function findSktTandatangan($lnpk_id)
    {
        if (($model = TblSktTandatangan::find()->where(['lnpk_id' => $lnpk_id])->one()) !== null) {
            return $model;
        }
        $model = new TblSktTandatangan();
        $model->lnpk_id = $lnpk_id;
        return $model;
    }

    public function actionSenaraiPyd()
    {
        $searchModel = new TblMainSearch();

        $bio = Tblprcobiodata::findOne(Yii::$app->user->identity->ICNO);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->andWhere(['OR', ['hrm.lnpk_tbl_main.PPP' => Yii::$app->user->getId()], ['hrm.lnpk_tbl_main.PPK' => Yii::$app->user->getId()]]);

        return $this->render('senarai_pyd', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'kump_khidmat' => $bio->jawatan->job_group,
        ]);
    }

    public function actionCarianBorang()
    {
        $searchModel = new TblMainSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('carian_borang', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateBorang()
    {
        $lnpk = new TblMain();

        if ($lnpk->load(Yii::$app->request->post())) {

            $pyd = $this->findBiodata($lnpk->PYD);

            $lnpk->PYD_sts_lantikan = $pyd->statLantikan;
            $lnpk->gred_jawatan_id = $pyd->gredJawatan;
            $lnpk->jspiu = $pyd->DeptId;

            if ($lnpk->isPP) {
                $ppp = $this->findBiodata($lnpk->PPP);
                $lnpk->gred_jawatan_id_PPP = $ppp->gredJawatan;
                $lnpk->jspiu_PPP = $ppp->DeptId;

                $lnpk->PPK = null;
                $lnpk->gred_jawatan_id_PPK = null;
                $lnpk->jspiu_PPK = null;
            } else {
                $ppp = $this->findBiodata($lnpk->PPP);
                $lnpk->gred_jawatan_id_PPP = $ppp->gredJawatan;
                $lnpk->jspiu_PPP = $ppp->DeptId;

                $ppk = $this->findBiodata($lnpk->PPK);
                $lnpk->gred_jawatan_id_PPK = $ppk->gredJawatan;
                $lnpk->jspiu_PPK = $ppk->DeptId;
            }

            $lnpk->lnpk_datetime = new \yii\db\Expression('NOW()');

            if ($lnpk->validate() && $lnpk->save()) {
                $ntf = new Notification();
                $ntf->icno = $lnpk->PYD;
                $ntf->title = 'Pengisian Borang LNPK ' . $lnpk->tahun;
                $ntf->content = 'Sila isi Borang Penilaian Prestasi Khas ' . $lnpk->jenisBorang->lnpk_desc . ' ' . $lnpk->tahun;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya ditambah!']);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->renderAjax('borang_lnpk', [
            'lnpk' => $lnpk,
        ]);
    }

    public function actionUpdateBorang($lnpk_id)
    {
        $lnpk = $this->findLnpk($lnpk_id);

        if ($lnpk->load(Yii::$app->request->post())) {

            $pyd = $this->findBiodata($lnpk->PYD);
            $lnpk->PYD_sts_lantikan = $pyd->statLantikan;
            $lnpk->gred_jawatan_id = $pyd->gredJawatan;
            $lnpk->jspiu = $pyd->DeptId;

            if ($lnpk->isPP) {
                $ppp = $this->findBiodata($lnpk->PPP);
                $lnpk->gred_jawatan_id_PPP = $ppp->gredJawatan;
                $lnpk->jspiu_PPP = $ppp->DeptId;

                $ppk = null;
                $lnpk->gred_jawatan_id_PPK = null;
                $lnpk->jspiu_PPK = null;
            } else {
                $ppp = $this->findBiodata($lnpk->PPP);
                $lnpk->gred_jawatan_id_PPP = $ppp->gredJawatan;
                $lnpk->jspiu_PPP = $ppp->DeptId;

                $ppk = $this->findBiodata($lnpk->PPK);
                $lnpk->gred_jawatan_id_PPK = $ppk->gredJawatan;
                $lnpk->jspiu_PPK = $ppk->DeptId;
            }

            if ($lnpk->is_deleted) {
                $lnpk->deleted_by = Yii::$app->user->identity->ICNO;
                $lnpk->deleted_datetime = new \yii\db\Expression('NOW()');
            } else {
                $lnpk->deleted_by = null;
                $lnpk->deleted_datetime = null;
            }

            if ($lnpk->validate() && $lnpk->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya dikemaskini!']);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->renderAjax('borang_lnpk', [
            'lnpk' => $lnpk,
        ]);
    }

    public function actionTandatanganUlasanPpp($lnpk_id)
    {
        $ulasan = $this->findUlasan($lnpk_id);

        if (Yii::$app->request->post()) {
            $ulasan->scenario = 'ppp';
            $ulasan->ulasan_PPP_tt = $ulasan->borang->PPP;
            $ulasan->ulasan_PPP_tt_datetime = new \yii\db\Expression('NOW()');
            if ($ulasan->validate() && $ulasan->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ulasan berjaya disahkan!']);
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Error: ' . array_values($ulasan->firstErrors)[0]]);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    public function actionTandatanganUlasanPpk($lnpk_id)
    {
        $ulasan = $this->findUlasan($lnpk_id);

        if (Yii::$app->request->post()) {
            $ulasan->scenario = 'ppk';
            $ulasan->ulasan_PPK_tt = $ulasan->borang->PPK;
            $ulasan->ulasan_PPK_tt_datetime = new \yii\db\Expression('NOW()');
            if ($ulasan->validate() && $ulasan->save()) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ulasan berjaya disahkan!']);
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                \Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Error: ' . array_values($ulasan->firstErrors)[0]]);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    protected function findUlasan($lnpk_id)
    {
        if (($model = TblUlasan::find()->where(['lnpk_id' => $lnpk_id])->one()) !== null) {
            return $model;
        }
        $model = new TblUlasan();
        $model->lnpk_id = $lnpk_id;
        return $model;
    }
}
