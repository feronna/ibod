<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Notification;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\models\aduan\RptTblAduan;
use app\models\aduan\RptTblAccess;
use yii\web\NotFoundHttpException;
use app\models\hronline\Department;
use app\models\aduan\RptTblSiasatan;
use app\models\aduan\RptTblAduanSearch;
use app\models\hronline\Tblprcobiodata;
use app\models\aduan\RptTblSiasatanSearch;
use app\models\keselamatan\TblStaffKeselamatan;

/**
 * AduanController implements the CRUD actions for RptTblAduan model.
 */
class AduanController extends Controller
{

    public $current_user;
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
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->current_user = Yii::$app->user->getId();

        return parent::beforeAction($action);
    }

    /**
     * Lists all RptTblAduan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RptTblAduanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RptTblAduan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [ //render(pageTitle.php)
            'model' => $this->findModel($id),
            'modelBio' => Tblprcobiodata::find()->where(['ICNO' => $this->current_user])->one(),
        ]);
    }

    public function actionViewAdmin($id)
    {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->penerima_icno = $this->current_user;
            $model->penerima_date = date('Y-m-d');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Aduan telah berjaya diproses.']);

                $modelPeg = Department::find()->where(['id' => '2'])->one();

                if ($modelPeg) {

                    if ($modelPeg->chief != NULL) {

                        $this->notifikasi($modelPeg->chief, "Aduan baru dari " . strtoupper($model->biodata->displayGelaran . ' ' . $model->biodata->CONm) . " menunggu tindakan anda " . Html::a('KLIK SINI <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>', ['aduan/view-list-chief'], ['class' => 'btn btn-sm btn-success btn-block']));
                    }

                    if ($modelPeg->pp != NULL) {

                        $this->notifikasi($modelPeg->pp, "Aduan baru dari " . strtoupper($model->biodata->displayGelaran . ' ' . $model->biodata->CONm) . " menunggu tindakan anda " . Html::a('KLIK SINI <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>', ['aduan/view-list-chief'], ['class' => 'btn btn-sm btn-success btn-block']));
                    }
                }

                return $this->redirect([
                    'view-admin',
                    'id' => $model->aduan_id
                ]);
            }
        }

        if ($model->penerima_icno == NULL) {
            $modelPenerima = Tblprcobiodata::find()->where(['ICNO' => $this->current_user])->one();
            $modelUnit = TblStaffKeselamatan::find()->where(['staff_icno' => $this->current_user])->one();
        } else {
            $modelPenerima = Tblprcobiodata::find()->where(['ICNO' => $model->penerima_icno])->one();
            $modelUnit = TblStaffKeselamatan::find()->where(['staff_icno' => $model->penerima_icno])->one();
        }

        return $this->render('view_admin', [
            'model' => $this->findModel($id),
            'modelPenerima' => $modelPenerima,
            'modelUnit' => $modelUnit,
            'allStaf' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname'),
            'penyiasat' => ArrayHelper::map(RptTblSiasatan::find()->where(['aduan_id' => $id])->all(), 'penyiasat_icno', 'penyiasat_icno'),
            'status' => '1'
        ]);
    }

    public function actionViewOfficer($id)
    {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->officer_icno = $this->current_user;
            $model->officer_date = date('Y-m-d');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Aduan telah berjaya diproses.']);

                $modelPeg = Department::find()->where(['id' => '2'])->one();

                if ($modelPeg) {

                    if ($modelPeg->chief != NULL) {

                        $this->notifikasi($modelPeg->chief, "Aduan baru dari " . strtoupper($model->biodata->displayGelaran . ' ' . $model->biodata->CONm) . " menunggu tindakan anda " . Html::a('KLIK SINI <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>', ['aduan/view-list-chief'], ['class' => 'btn btn-sm btn-success btn-block']));
                    }

                    if ($modelPeg->pp != NULL) {

                        $this->notifikasi($modelPeg->pp, "Aduan baru dari " . strtoupper($model->biodata->displayGelaran . ' ' . $model->biodata->CONm) . " menunggu tindakan anda " . Html::a('KLIK SINI <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>', ['aduan/view-list-chief'], ['class' => 'btn btn-sm btn-success btn-block']));
                    }
                }

                return $this->redirect([
                    'view-officer',
                    'id' => $model->aduan_id
                ]);
            }
        }

        if ($model->officer_icno == NULL) {
            $modelPegawai = Tblprcobiodata::find()->where(['ICNO' => $this->current_user])->one();
            $modelUnit = TblStaffKeselamatan::find()->where(['staff_icno' => $this->current_user])->one();
        } else {
            $modelPegawai = Tblprcobiodata::find()->where(['ICNO' => $model->officer_icno])->one();
            $modelUnit = TblStaffKeselamatan::find()->where(['staff_icno' => $model->officer_icno])->one();
        }

        return $this->render('view_officer', [
            'model' => $this->findModel($id),
            'modelPegawai' => $modelPegawai,
            'modelUnit' => $modelUnit,
            'allStaf' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname'),
            'penyiasat' => ArrayHelper::map(RptTblSiasatan::find()->where(['aduan_id' => $id])->all(), 'penyiasat_icno', 'penyiasat_icno'),
            'status' => '1'
        ]);
    }

    public function actionViewList()
    {
        $searchModel = new RptTblAduanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['staff_icno' => $this->current_user]);

        return $this->render('view_list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewListAdmin()
    {
        $noti = Notification::find()->where(['icno' => $this->current_user, 'title' => 'E-Aduan BKUMS', 'status' => '0'])->all();
        foreach ($noti as $n) {
            if (substr($n->content, 0, 10) == 'Aduan baru') {
                $n->status = '1';
                $n->save(false);
            }
        }

        $searchModel = new RptTblAduanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['<>', 'aduan_status', '11']);

        return $this->render('view_list_admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionViewListOfficer()
    {
        $searchModel = new RptTblAduanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['>', 'aduan_status', '1']);
        $dataProvider->query->andFilterWhere(['<>', 'aduan_status', '4']);
        $dataProvider->query->andFilterWhere(['<>', 'aduan_status', '11']);

        return $this->render('view_list_officer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewListChief()
    {
        $searchModel = new RptTblAduanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['>=', 'aduan_status', '2']);
        $dataProvider->query->andFilterWhere(['<>', 'aduan_status', '4']);
        $dataProvider->query->andFilterWhere(['<>', 'aduan_status', '11']);

        return $this->render('view_list_chief', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewListPenyiasat()
    {
        $searchModel = new RptTblSiasatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['penyiasat_icno' => $this->current_user]);

        return $this->render('view_list_penyiasat', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new RptTblAduan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelBio = Tblprcobiodata::find()->where(['ICNO' => $this->current_user])->one();

        $model = new RptTblAduan();

        if ($model->load(Yii::$app->request->post())) {
            $model->staff_icno = $this->current_user;
            $model->date_created = date('Y-m-d');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Aduan anda telah berjaya dihantar.']);

                $modelPeg = RptTblAccess::find()->where(['access_type' => 'urusetia'])->all();

                if ($modelPeg) {

                    foreach ($modelPeg as $s) {

                        $this->notifikasi($s->staff_icno, "Aduan baru dari " . strtoupper($modelBio->displayGelaran . ' ' . $modelBio->CONm) . " menunggu tindakan anda " . Html::a('KLIK SINI <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>', ['aduan/view-list-admin'], ['class' => 'btn btn-sm btn-success btn-block']));
                    }
                }

                return $this->redirect([
                    'view',
                    'id' => $model->aduan_id
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelBio' => $modelBio,
            'id' => null
        ]);
    }

    public function actionViewChief($id)
    {
        $model = $this->findModel($id);

        // if ($modelPenyiasat->load(Yii::$app->request->post()) && $modelPenyiasat->save(false)) {
        //     return $this->redirect(['view', 'aduan_id' => $modelPenyiasat->aduan_id, 'penyiasat_icno' => $modelPenyiasat->penyiasat_icno]);
        // }

        if (Yii::$app->request->post('momo') != NULL) {

            $selection = Yii::$app->request->post('momo');

            //var_dump($selection);
            //die();

            RptTblSiasatan::deleteAll(['aduan_id' => $id]);

            foreach ($selection as $penyiasat) {

                $checkPenyiasat = RptTblSiasatan::find()
                    ->where(['penyiasat_icno' => $penyiasat])
                    ->andWhere(['aduan_id' => $id])
                    ->one();

                if (!$checkPenyiasat) {
                    $modelPenyiasat = new RptTblSiasatan();
                    $modelPenyiasat->aduan_id = $id;
                    $modelPenyiasat->penyiasat_icno = $penyiasat;
                    $modelPenyiasat->penetap_icno = $this->current_user;
                    $modelPenyiasat->date = date('Y-m-d');
                    if ($modelPenyiasat->save(false)) {
                        $model->aduan_status = '5';
                        $model->save(false);

                        $this->notifikasi($modelPenyiasat->penyiasat_icno, "Anda telah ditetapkan sebagai penyiasat bagi kes aduan bernombor BKUMS" . $modelPenyiasat->aduan_id . ", menunggu tindakan anda " . Html::a('KLIK SINI <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>', ['aduan/view-list-penyiasat'], ['class' => 'btn btn-sm btn-success btn-block']));
                    }
                }
            }
        }

        $modelPenerima = Tblprcobiodata::find()->where(['ICNO' => $model->penerima_icno])->one();
        $modelUnit = TblStaffKeselamatan::find()->where(['staff_icno' => $model->penerima_icno])->one();
        $modelPegawai = Tblprcobiodata::find()->where(['ICNO' => $model->officer_icno])->one();
        $modelUnitPeg = TblStaffKeselamatan::find()->where(['staff_icno' => $model->officer_icno])->one();

        return $this->render('view_chief', [
            'model' => $this->findModel($id),
            //'modelPenyiasat' => $this->findModelPenyiasat($modelPenyiasat->aduan_id, $modelPenyiasat->penyiasat_icno),
            'modelPenerima' => $modelPenerima,
            'modelUnit' => $modelUnit,
            'modelPegawai' => $modelPegawai,
            'modelUnitPeg' => $modelUnitPeg,
            'allStaf' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname'),
            'penyiasat' => ArrayHelper::map(RptTblSiasatan::find()->where(['aduan_id' => $id])->all(), 'penyiasat_icno', 'penyiasat_icno'),
        ]);
    }

    public function actionViewPenyiasat($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->reporter_icno = $this->current_user;
            $model->report_date = date('Y-m-d');
            $model->report_status = '2';
            $model->aduan_status = '6';

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan anda telah berjaya dihantar.']);

                // $modelPeg = RptTblAccess::find()->where(['access_type' => 'urusetia'])->all();

                // if ($modelPeg) {

                //     foreach ($modelPeg as $s) {

                //         $this->notifikasi($s->staff_icno, "Aduan baru dari " . strtoupper($modelBio->displayGelaran . ' ' . $modelBio->CONm) . " menunggu tindakan anda " . Html::a('KLIK SINI <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>', ['aduan/view-list-admin'], ['class' => 'btn btn-sm btn-success btn-block']));
                //     }
                // }

                return $this->redirect([
                    'view-penyiasat',
                    'id' => $model->aduan_id
                ]);
            }
        }

        $modelPenerima = Tblprcobiodata::find()->where(['ICNO' => $model->penerima_icno])->one();
        $modelUnit = TblStaffKeselamatan::find()->where(['staff_icno' => $model->penerima_icno])->one();
        $modelPegawai = Tblprcobiodata::find()->where(['ICNO' => $model->officer_icno])->one();
        $modelUnitPeg = TblStaffKeselamatan::find()->where(['staff_icno' => $model->officer_icno])->one();

        return $this->render('view_penyiasat', [
            'model' => $this->findModel($id),
            'modelBio' => Tblprcobiodata::find()->where(['ICNO' => $this->current_user])->one(),
            'modelPenerima' => $modelPenerima,
            'modelUnit' => $modelUnit,
            'modelPegawai' => $modelPegawai,
            'modelUnitPeg' => $modelUnitPeg,
            'allStaf' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname'),
            'penyiasat' => ArrayHelper::map(RptTblSiasatan::find()->where(['aduan_id' => $id])->all(), 'penyiasat_icno', 'penyiasat_icno'),
        ]);
    }

    /**
     * Updates an existing RptTblAduan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $modelBio = Tblprcobiodata::find()->where(['ICNO' => $this->current_user])->one();

    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->aduan_id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //         'modelBio' => $modelBio
    //     ]);
    // }

    /**
     * Updates an existing RptTblSiasatan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $aduan_id
     * @param string $penyiasat_icno
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdatePenyiasat($aduan_id, $penyiasat_icno)
    {
        $model = $this->findModelPenyiasat($aduan_id, $penyiasat_icno);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'aduan_id' => $model->aduan_id, 'penyiasat_icno' => $model->penyiasat_icno]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RptTblAduan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // if ($this->findModel($id)->delete()) {
        //     Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Aduan anda telah berjaya dihapuskan.']);
        // }

        $model = $this->findModel($id);
        $model->aduan_status = '11';
        $model->cancelled_date = date('Y-m-d');
        if ($model->save(false)) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Aduan anda telah berjaya dibatalkan.']);
        }

        return $this->redirect(['view-list']);
        //return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing RptTblSiasatan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $aduan_id
     * @param string $penyiasat_icno
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeletePenyiasat($aduan_id, $penyiasat_icno)
    {
        $this->findModelPenyiasat($aduan_id, $penyiasat_icno)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RptTblAduan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RptTblAduan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RptTblAduan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Finds the RptTblSiasatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $aduan_id
     * @param string $penyiasat_icno
     * @return RptTblSiasatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelPenyiasat($aduan_id, $penyiasat_icno)
    {
        if (($model = RptTblSiasatan::findOne(['aduan_id' => $aduan_id, 'penyiasat_icno' => $penyiasat_icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function notifikasi($icno, $content)
    {
        //--------Model Notification-----------//
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $icno;
        $ntf->title = 'E-Aduan BKUMS';
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save(false);
        //--------Model Notification-----------//
    }

    // protected function findPengadu($id)
    // {
    //     if (($model = RptTblAduan::findOne($id)) !== null) {
    //         return $model;
    //     }

    //     throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    // }
}
