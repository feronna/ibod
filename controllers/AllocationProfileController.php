<?php

namespace app\controllers;

use app\models\allocation\TblProfiles;
use app\models\hronline\Tblprcobiodata;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\TblprcobiodataSearch;

class AllocationProfileController extends Controller
{
    public $userId;

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
                            return TblProfiles::isUserAdmin(Yii::$app->user->identity->ICNO);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'remove' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->userId = Yii::$app->user->getId();

        return parent::beforeAction($action);
    }

    public function actionDataList()
    {
        $this->view->title = "Senarai carian";

        ini_set('memory_limit', '1024M'); // or you could use 1G

        $searchModel = new TblprcobiodataSearch();
        $dataProvider = $searchModel->searchAllocProfile(Yii::$app->request->queryParams);

        return $this->render('data-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionPerincianProfil($icno)
    {
        $this->view->title = "Perincian";

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $model = TblProfiles::findAll(['icno' => $icno]);

        return $this->render('perincian-profil', [
            'biodata' => $biodata,
            'model' => $model,
            'bil' => 1,
        ]);
    }


    public function actionCreateProfile($icno)
    {
        $this->view->title = "Tambah Profil Baharu";

        $model = new TblProfiles();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $icno;

            $model->create_by = $this->userId;
            $model->create_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat telah berjaya ditambah']);
                return $this->redirect(['perincian-profil', 'icno' => $icno]);
            }
        }

        return $this->render('profile-form', [
            'model' => $model,
            'biodata' => $biodata,
            'arrSumberPeruntukan' => $model->arrSumberPeruntukan(),
            'arrStatusKontrak' => $model->arrStatusKontrak(),
        ]);
    }

    public function actionUpdateProfile($id)
    {
        $this->view->title = "Kemaskini";

        $model = $this->findModel($id);

        $biodata = Tblprcobiodata::findOne(['ICNO' => $model->icno]);

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->update_by = $this->userId;
            $model->update_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat telah berjaya dikemaskini']);
                return $this->redirect(['perincian-profil', 'icno' => $model->icno]);
            }
        }

        return $this->render('profile-form', [
            'model' => $model,
            'biodata' => $biodata,
            'arrSumberPeruntukan' => $model->arrSumberPeruntukan(),
            'arrStatusKontrak' => $model->arrStatusKontrak(),
        ]);
    }

    public function actionDeleteProfile($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat telah dibuang']);
            return $this->redirect(['perincian-profil', 'icno'=>$model->icno]);
        }
    }

    protected function findModel($id)
    {
        if (($model = TblProfiles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
