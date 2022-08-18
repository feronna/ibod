<?php

namespace app\controllers;

use Yii;
use app\models\ln\Ln2;
use app\models\ln\Ln2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Ln2Controller implements the CRUD actions for Ln2 model.
 */
class Ln2Controller extends Controller
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
        ];
    }

    /**
     * Lists all Ln2 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Ln2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ln2 model.
     * @param integer $bil
     * @param string $ICNO
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($bil, $ICNO)
    {
        return $this->render('view', [
            'model' => $this->findModel($bil, $ICNO),
        ]);
    }

    /**
     * Creates a new Ln2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ln2();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'bil' => $model->bil, 'ICNO' => $model->ICNO]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Ln2 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $bil
     * @param string $ICNO
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($bil, $ICNO)
    {
        $model = $this->findModel($bil, $ICNO);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'bil' => $model->bil, 'ICNO' => $model->ICNO]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ln2 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $bil
     * @param string $ICNO
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($bil, $ICNO)
    {
        $this->findModel($bil, $ICNO)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ln2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $bil
     * @param string $ICNO
     * @return Ln2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($bil, $ICNO)
    {
        if (($model = Ln2::findOne(['bil' => $bil, 'ICNO' => $ICNO])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
