<?php

namespace app\controllers;

use Yii;
use app\models\pengesahan\TblPtm;
use app\models\pengesahan\TblPnp;
use app\models\pengesahan\TblPenyelidikan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\TblprcobiodataSearch;
use app\models\ptm\TblPtm as PtmTblPtm;
use app\models\ptm\TblPtmSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use app\models\ptm\Tblstaff;
use app\models\ptm\TblstaffSearch;
use yii\helpers\Html;
use Exception;
use yii\helpers\VarDumper;

/**
 * PtmController implements the CRUD actions for TblPtm model.
 */
class PtmController extends Controller
{
    /**
     * {@inheritdoc}
     */
    //    public function behaviors()
    //    {
    //        return [
    //            'verbs' => [
    //                'class' => VerbFilter::className(),
    //                'actions' => [
    //                    'delete' => ['POST'],
    //                ],
    //            ],
    //        ];
    //    }

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
                'only' => ['rekod-ptm', 'rekod-pnp', 'rekod-penyelidikan', 'rekod-bitk', 'halaman-utama', 'admin-view', 'lihat-rekod-ptm', 'lihat-rekod-pnp', 'lihat-rekod-penyelidikan', 'lihat-rekod-bitk', 'kemaskini-rekod-ptm', 'kemaskini-rekod-pnp', 'kemaskini-rekod-penyelidikan', 'kemaskini-rekod-bitk', 'tambah-ptm', 'tambah-pnp', 'tambah-penyelidikan', 'tambah-bitk'],
                'rules' => [
                    [
                        'actions' => ['rekod-ptm', 'rekod-pnp', 'rekod-penyelidikan', 'rekod-bitk', 'halaman-utama', 'admin-view', 'lihat-rekod-ptm', 'lihat-rekod-pnp', 'lihat-rekod-penyelidikan', 'lihat-rekod-bitk', 'kemaskini-rekod-ptm', 'kemaskini-rekod-pnp', 'kemaskini-rekod-penyelidikan', 'kemaskini-rekod-bitk', 'tambah-ptm', 'tambah-pnp', 'tambah-penyelidikan', 'tambah-bitk'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $icno = Yii::$app->user->getId();
                            if (\app\models\pengesahan\TblAccess::find()->where(['icno' => $icno, 'access' => 1])->exists()) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    ],
                    [
                        'actions' => ['viewuser', 'kemaskini', 'lihatbiodata'],
                        'allow' => true,

                    ],

                ],
            ],
        ];
    }

    /**
     * Lists all TblPtm models.
     * @return mixed
     */
    //    public function actionIndex()
    //    {
    //        $searchModel = new TblPtmSearch();
    //        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //        $dataProvider->query->orderBy([ 'tarikhLulusPtm' => 'SORT_DESC']);
    //        return $this->render('index', [
    //            'searchModel' => $searchModel,
    //            'dataProvider' => $dataProvider,
    //        ]);
    //    }

    public function actionHalamanUtama()
    {
        //        $carian = new Tblprcobiodata();
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->carian(Yii::$app->request->queryParams);

        return $this->render('halaman-utama', [
            'carian' => $carian,
            'model' => $dataProvider,
        ]);
    }

    public function actionHalamanUtamaKeseluruhan()
    {
        //        $carian = new Tblprcobiodata();
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->carian(Yii::$app->request->queryParams);

        return $this->render('halaman-utama-keseluruhan', [
            'carian' => $carian,
            'model' => $dataProvider,
        ]);
    }

    public function actionRekodPtm()
    {
        $peserta =  Tblprcobiodata::find()->all();
        $peserta2 = \app\models\hronline\Department::find()->all();

        $dataProvider = new ActiveDataProvider([

            'query' => TblPtm::find()->orderBy(['tarikhPtm' => SORT_ASC]),

            'pagination' => [

                'pageSize' => 100,

            ],
        ]);

        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $dataProvider->query->andFilterWhere(['ICNO' => Yii::$app->request->queryParams['ICNO']]);
        }

        return $this->render('rekod-ptm', [
            'peserta' => $peserta,
            'peserta2' => $peserta2,
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'model' => $dataProvider
        ]);
    }

    public function actionRekodPnp()
    {
        $peserta =  Tblprcobiodata::find()->all();
        $peserta2 = \app\models\hronline\Department::find()->all();

        $dataProvider = new ActiveDataProvider([

            'query' => TblPnp::find()->orderBy(['tarikhPnp' => SORT_ASC]),

            'pagination' => [

                'pageSize' => 100,

            ],
        ]);

        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $dataProvider->query->andFilterWhere(['ICNO' => Yii::$app->request->queryParams['ICNO']]);
        }

        return $this->render('rekod-pnp', [
            'peserta' => $peserta,
            'peserta2' => $peserta2,
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'model' => $dataProvider
        ]);
    }

    public function actionRekodPenyelidikan()
    {
        $peserta =  Tblprcobiodata::find()->all();
        $peserta2 = \app\models\hronline\Department::find()->all();

        $dataProvider = new ActiveDataProvider([

            'query' => TblPenyelidikan::find()->orderBy(['tarikhPembentangan' => SORT_ASC]),

            'pagination' => [

                'pageSize' => 100,

            ],
        ]);

        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $dataProvider->query->andFilterWhere(['ICNO' => Yii::$app->request->queryParams['ICNO']]);
        }

        return $this->render('rekod-penyelidikan', [
            'peserta' => $peserta,
            'peserta2' => $peserta2,
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'model' => $dataProvider
        ]);
    }

    public function actionRekodBitk()
    {
        $peserta =  Tblprcobiodata::find()->all();
        $peserta2 = \app\models\hronline\Department::find()->all();

        $dataProvider = new ActiveDataProvider([

            'query' => \app\models\pengesahan\TblBitk::find()->orderBy(['tarikhBitk' => SORT_ASC]),

            'pagination' => [

                'pageSize' => 100,

            ],
        ]);

        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $dataProvider->query->andFilterWhere(['ICNO' => Yii::$app->request->queryParams['ICNO']]);
        }

        return $this->render('rekod-bitk', [
            'peserta' => $peserta,
            'peserta2' => $peserta2,
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'model' => $dataProvider
        ]);
    }

    /**
     * Displays a single TblPtm model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionAdminView($id)
    {
        $model2 = $this->findModel2($id);

        return $this->render('admin-view', [
            'model2' => $model2,
        ]);
    }

    public function actionLihatRekodPtm($id)
    {
        $model = $this->findModel($id);
        $model2 = $this->findModel2($id);

        return $this->render('lihat-rekod-ptm', [
            'id' => $id,
            'model' => $model,
            'model2' => $model2,
        ]);
    }

    public function actionLihatRekodPnp($id)
    {
        $model = $this->findModel3($id);
        $model2 = $this->findModel2($id);

        return $this->render('lihat-rekod-pnp', [
            'id' => $id,
            'model' => $model,
            'model2' => $model2,
        ]);
    }

    public function actionLihatRekodPenyelidikan($id)
    {

        $model = $this->findModel4($id);
        $model2 = $this->findModel2($id);

        return $this->render('lihat-rekod-penyelidikan', [
            'id' => $id,
            'model' => $model,
            'model2' => $model2,
        ]);
    }

    public function actionLihatRekodBitk($id)
    {

        $model = $this->findModel5($id);
        $model2 = $this->findModel2($id);

        return $this->render('lihat-rekod-bitk', [
            'id' => $id,
            'model' => $model,
            'model2' => $model2,
        ]);
    }

    /**
     * Creates a new TblPtm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionTambahPtm($ICNO = NULL)
    {
        $model = new TblPtm();
        $model->ICNO = $ICNO;
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');

        if ($model->load(Yii::$app->request->post())) {

            if (TblPtm::find()->where(['icno' => $model->ICNO])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
            } elseif ($model->ICNO != NULL) { //jika icno tidak wujud dalam sistem
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);

                $model->save();
                return $this->redirect(['lihat-rekod-ptm', 'id' => $model->ICNO]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
            }

            return $this->redirect(['rekod-ptm']);
        }

        return $this->renderAjax('tambah-ptm', [
            'model' => $model,
            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionTambahPnp($ICNO = NULL)
    {
        $model = new TblPnp();
        $model->ICNO = $ICNO;
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');

        if ($model->load(Yii::$app->request->post())) {
            if (TblPnp::find()->where(['icno' => $model->ICNO])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
            } elseif ($model->ICNO != NULL) { //jika icno tidak wujud dalam sistem
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);

                $model->save();
                return $this->redirect(['lihat-rekod-pnp', 'id' => $model->ICNO]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
            }

            return $this->redirect(['rekod-pnp']);
        }

        return $this->renderAjax('tambah-pnp', [
            'model' => $model,
            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionTambahPenyelidikan($ICNO = NULL)
    {
        $model = new TblPenyelidikan();
        $model->ICNO = $ICNO;
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');

        if ($model->load(Yii::$app->request->post())) {
            if (TblPenyelidikan::find()->where(['icno' => $model->ICNO])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
            } elseif ($model->ICNO != NULL) { //jika icno tidak wujud dalam sistem
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);

                $model->save();
                return $this->redirect(['lihat-rekod-penyelidikan', 'id' => $model->ICNO]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
            }

            return $this->redirect(['rekod-penyelidikan']);
        }

        return $this->renderAjax('tambah-penyelidikan', [
            'model' => $model,
            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionTambahBitk($ICNO = NULL)
    {
        $model = new \app\models\pengesahan\TblBitk();
        $model->ICNO = $ICNO;
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');

        if ($model->load(Yii::$app->request->post())) {
            if (\app\models\pengesahan\TblBitk::find()->where(['icno' => $model->ICNO])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
            } elseif ($model->ICNO != NULL) { //jika icno tidak wujud dalam sistem
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);

                $model->save();
                return $this->redirect(['lihat-rekod-bitk', 'id' => $model->ICNO]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
            }

            return $this->redirect(['rekod-bitk']);
        }

        return $this->renderAjax('tambah-bitk', [
            'model' => $model,
            'allbiodata' => $allbiodata,
        ]);
    }

    /**
     * Updates an existing TblPtm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionKemaskiniRekodPtm($id)
    {
        $model = $this->findModel($id);
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        //        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);

            return $this->redirect(['lihat-rekod-ptm', 'id' => $model->ICNO]);
        }

        return $this->renderAjax('kemaskini-rekod-ptm', [
            'model' => $model,
            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionKemaskiniRekodPnp($id)
    {
        $model = $this->findModel3($id);
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');

        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);

            return $this->redirect(['lihat-rekod-pnp', 'id' => $model->ICNO]);
        }

        return $this->renderAjax('kemaskini-rekod-pnp', [
            'model' => $model,
            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionKemaskiniRekodPenyelidikan($id)
    {
        $model = $this->findModel4($id);
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');

        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);

            return $this->redirect(['lihat-rekod-penyelidikan', 'id' => $model->ICNO]);
        }

        return $this->renderAjax('kemaskini-rekod-penyelidikan', [
            'model' => $model,
            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionKemaskiniRekodBitk($id)
    {
        $model = $this->findModel5($id);
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');

        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);

            return $this->redirect(['lihat-rekod-bitk', 'id' => $model->ICNO]);
        }

        return $this->renderAjax('kemaskini-rekod-bitk', [
            'model' => $model,
            'allbiodata' => $allbiodata,
        ]);
    }

    /**
     * Deletes an existing TblPtm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeletePtm($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['rekod-ptm']);
    }

    public function actionDeletePnp($id)
    {
        $this->findModel3($id)->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['rekod-pnp']);
    }

    public function actionDeletePenyelidikan($id)
    {
        $this->findModel4($id)->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['rekod-penyelidikan']);
    }

    public function actionDeleteBitk($id)
    {
        $this->findModel5($id)->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['rekod-bitk']);
    }

    /**
     * Finds the TblPtm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TblPtm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblPtm::findOne($id)) !== null) {
            return $model;
        } else {
            return array(NULL);
        }
    }

    protected function findModel2($id)
    {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel3($id)
    {
        if (($model = TblPnp::findOne($id)) !== null) {
            return $model;
        } else {
            return array(NULL);
        }
    }

    protected function findModel4($id)
    {
        if (($model = TblPenyelidikan::findOne($id)) !== null) {
            return $model;
        } else {
            return array(NULL);
        }
    }

    protected function findModel5($id)
    {
        if (($model = \app\models\pengesahan\TblBitk::findOne($id)) !== null) {
            return $model;
        } else {
            return array(NULL);
        }
    }

    protected function findModelbyicno($ICNO)
    {
        if (($model = TblPtm::findAll(['ICNO' => $ICNO])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSenaraiLayak()
    {
        $icno = Yii::$app->user->getId();
        $model = Tblprcobiodata::find()
            ->where(['!=', 'status', 6])
            ->andWhere(['=', 'statLantikan', 1])
            ->andWhere(new \yii\db\Expression('startDateLantik >= \'2022-01-01\''))
            ->orderBy(['startDateLantik' => SORT_ASC]);

        $query = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        $layak = new Tblstaff();
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'sort' => ['defaultOrder' => ['lantik_dt' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        if ($pilih = Yii::$app->request->post()) {
                $selection = (array)Yii::$app->request->post('selection');
                // VarDumper::dump( $selection, $depth = 10, $highlight = true);die;

                foreach ($selection as $emel) {
                    
                    try {
                        Yii::$app->mailerPtm->compose()
                                ->setFrom('pengajianlanjutan@ums.edu.my')
                                ->setSubject('LKP UNIVERSITI MALAYSIA SABAH- PLEASE VERIFY YOUR STUDENT PROGRESS REPORT')
                                ->setTo($emel)
                                // ->setCc(['norfazleenawana@ums.edu.my', 'anizah@ums.edu.my'])
            //                    ->setHtmlBody($content)
                                ->send();
                        $mail_status = 1;
                    } catch (Exception $e) {
                        $mail_status = 0;
                    }
            
            //         $model = new \app\models\cbelajar\TblEmail();
            //         $model->from_name = 'VERIFY STUDENT-LKP';
            //         $model->from_email = 'pengajianlanjutan@ums.edu.my';
            //         $model->to_name = $name;
            //         $model->to_email = $email;
            //         $model->subject = 'PLEASE VERIFY YOUR PROGRESS REPORT';
            // //        $model->message = $content;
            //         $model->success = $mail_status;
            //         $model->date_published = date('Y-m-d H:i:s');
            //         $model->save();
            //         return 0;
                }
                }

        return $this->render('senarai-layak', [
            'dataProvider' => $dataProvider,
            'query' => $query,
        ]);
    }

    public function actionAdminViews($id)
    {
        $model2 = $this->findModel2($id);

        return $this->render('admin-views', [
            'model2' => $model2,
        ]);
    }

    public function actionTetapanJadual()
    {
        $icno = Yii::$app->user->getId();
        $model = new PtmTblPtm();
        $model->entry_dt = date('Y-m-d H:i:s');
        $model->entry_by = $icno;

        if ($model->load(Yii::$app->request->post())) {

            $model->tempoh = $model->totalDays;
            $model->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya direkodkan']);

            return $this->redirect(['senarai-layak']);
        }

        $query = PtmTblPtm::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['start_dt' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        $searchModel = new TblPtmSearch();
        if (Yii::$app->request->queryParams) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        return $this->render('tetapan-jadual', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionUpdateJadual($id)
    {
        $icno = Yii::$app->user->getId();
        $model = PtmTblPtm::findOne(['siri_id' => $id]);

        if ($model->load(Yii::$app->request->post())) {

            $model->update_dt = date('Y-m-d');
            $model->update_by = $icno;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini.']);
            return $this->redirect(['update-jadual', 'id' => $id]);
        }
        return $this->render('update-jadual', [
            'model' => $model,
        ]);
    }

    public function actionDeleteJadual($id)
    {
        $model = PtmTblPtm::findOne(['siri_id' => $id]);
        $model->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        return $this->redirect([
            'tetapan-jadual',
            'model' => $model
        ]);
    }

    public  function actionNotifistaf()
    {
        $staff = Tblprcobiodata::find()
            ->where(['!=', 'status', 6])
            ->andWhere(['=', 'statLantikan', 1])
            ->andWhere(new \yii\db\Expression('startDateLantik >= \'2022-01-01\''))
            ->orderBy(['startDateLantik' => SORT_ASC])
            ->all();

        foreach ($staff as $staffs) {
            $this->notifikasi(
                $staffs->ICNO,
                "Salam Sejahtera, UMS sedang dalam proses pemurnian data Universiti, oleh itu Tuan/Puan diminta"
                    . " untuk mengemaskini Maklumat Pendidikan <b>DALAM KADAR SEGERA</b>"
                    . Html::a('<i class="fa fa-arrow-right"></i>', ['pendidikan/view'], ['class' => 'btn btn-primary btn-sm'])
            );
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'PERINGATAN MESRA BERJAYA DIHANTAR']);
        return $this->redirect('senarai-layak');
    }

}
