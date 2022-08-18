<?php

namespace app\controllers;

use app\models\gaji\TblKumpLpg;
use app\models\gaji\TblKumpStaf;
use app\models\gaji\TblKumpulan;
use yii\filters\AccessControl;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class TetapanPayrollController extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return true;
                            // return TblAkses::isUserAdmin(Yii::$app->user->identity->ICNO);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-activity' => ['post'],
                    'delete-akses' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $this->view->title = "Senarai Kumpulan Sebab Perubahan";

        $model = TblKumpulan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        return $this->render('/hrpayroll/tetapan/index', [
            'dataProvider' => $dataProvider,
            'bil' => 1,
        ]);
    }

    public function actionSenaraiLpg($id)
    {
        $kump = TblKumpulan::findOne($id);

        $this->view->title = "Kumpulan : " .  $kump->nama;

        $model = TblKumpLpg::find()->where(['kump_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        return $this->render('/hrpayroll/tetapan/senarai-lpg', [
            'dataProvider' => $dataProvider,
            'bil' => 1,
            'id' => $id,
        ]);
    }

    public function actionSenaraiStaf($id)
    {
        $kump = TblKumpulan::findOne($id);

        $this->view->title = "Kumpulan : " .  $kump->nama;

        $model = TblKumpStaf::find()->where(['kump_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        return $this->render('/hrpayroll/tetapan/senarai-staf', [
            'dataProvider' => $dataProvider,
            'bil' => 1,
            'id' => $id,
        ]);
    }

    public function actionTambahKumpulan()
    {

        $this->view->title = "Tambah Kumpulan";
        $icno = Yii::$app->user->getId();

        $model = new TblKumpulan();

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->create_dt = date('Y-m-d H:i:s');
            $model->create_by = $icno;

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('/hrpayroll/tetapan/_form-kumpulan', [
            'model' => $model,
        ]);
    }

    public function actionUpdateKumpulan($id)
    {

        $this->view->title = "Kemaskini Kumpulan";
        $icno = Yii::$app->user->getId();

        $model = TblKumpulan::findOne($id);

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->update_by = $icno;
            $model->update_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('/hrpayroll/tetapan/_form-kumpulan', [
            'model' => $model,
        ]);
    }

    public function actionDeleteKumpulan($id)
    {

        TblKumpulan::findOne($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionTambahLpg($id)
    {

        $this->view->title = "Tambah Jenis Sebab Perubahan / LPG / Kew8";

        $model = new TblKumpLpg();

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->kump_id = $id;

            if ($model->save()) {
                return $this->redirect(['senarai-lpg', 'id' => $model->kump_id]);
            }
        }

        return $this->render('/hrpayroll/tetapan/_form-lpg', [
            'model' => $model,
            'kump_id' => $id,
        ]);
    }

    public function actionDeleteLpg($id)
    {

        $model = TblKumpLpg::findOne($id);

        if ($model->delete()) {
            return $this->redirect(['senarai-lpg', 'id' => $model->kump_id]);
        }
    }

    public function actionTambahStaf($id)
    {

        $this->view->title = "Tambah Staf";
        $icno = Yii::$app->user->getId();

        $model = new TblKumpStaf();

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->kump_id = $id;

            if ($model->save()) {
                return $this->redirect(['senarai-staf', 'id' => $model->kump_id]);
            }
        }

        return $this->render('/hrpayroll/tetapan/_form-staf', [
            'model' => $model,
            'id' => $id,
        ]);
    }

    public function actionUpdateStaf($id)
    {

        $this->view->title = "Kemaskini Staf";
        $icno = Yii::$app->user->getId();

        $model = TblKumpStaf::findOne($id);

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                return $this->redirect(['senarai-staf', 'id' => $model->kump_id]);
            }
        }

        return $this->render('/hrpayroll/tetapan/_form-staf', [
            'model' => $model,
            'id' => $model->kump_id,
        ]);
    }

    public function actionDeleteStaf($id)
    {

        $model = TblKumpStaf::findOne($id);

        if ($model->delete()) {
            return $this->redirect(['senarai-staf', 'id' => $model->kump_id]);
        }
    }
}
