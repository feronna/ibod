<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\kehadiran\tblwp;
use app\models\kehadiran\tblwpSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WaktuBekerjaController implements the CRUD actions for tblwp model.
 */
class WaktuBekerjaController extends Controller
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
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                     'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Lists all tblwp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new tblwpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblwp model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($icno) {
        return $this->render('view', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno]);
    }
    
     public function actionViewuser($icno) {
        return $this->render('viewuser', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno]);
    }

    /**
     * Creates a new tblwp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblwp();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing tblwp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionUpdate($id) {
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {


            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,
        ]);
    }

    /**
     * Deletes an existing tblwp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionDelete($id) {
        $model = $this->findModelbyid($id);
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['view', 'icno' => $model->ICNO]);
    }

    /**
     * Finds the tblwp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return tblwp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    protected function findModelbyid($id) {
        if (($model = Tblwp::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblwp::findAll(['icno' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
