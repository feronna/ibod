<?php

namespace app\controllers;

use Yii;
use app\models\kontrak\Kontrak;
use app\models\kontrak\KontrakSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LanjutkontrakController implements the CRUD actions for Kontrak model.
 */
class LanjutkontrakController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
               'class' => AccessControl::className(),
//               'only' => ['index', 'list-side-menu', 'list-top-menu', 'senarai-action', 'senarai-action-top', 'create', 'create-top', 'update', 'update-top', 'penetapan-akses', 'akses'],
               'rules' => [
                   [
//                       'actions' => ['index', 'list-side-menu', 'list-top-menu', 'senarai-action', 'senarai-action-top', 'create', 'create-top', 'update', 'update-top', 'penetapan-akses', 'akses'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
//                           $tmp = TblUserAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->one();
                           return (Yii::$app->user->identity->ICNO== '950510125946') ? true : false;
                       }
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
     * Lists all Kontrak models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KontrakSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kontrak model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Kontrak model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kontrak();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Kontrak model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Kontrak model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kontrak model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kontrak the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kontrak::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionNotification(){
         $model = new \app\models\Notification();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->ntf_dt = date('Y-m-d H:i:s');
            $model->save();
        }
        
        return $this->render('notifikasi', [
            'model' => $model,
        ]);
    }
    
}
