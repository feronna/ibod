<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\updatestatus;
use app\models\hronline\updatestatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
/**
 * PerubahanDataController implements the CRUD actions for updatestatus model.
 */
class PerubahanDataController extends Controller
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
     * Lists all updatestatus models.
     * @return mixed
     */
   
       public function actionIndex()
    {
        $searchModel = new updatestatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single updatestatus model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

     public function actionView($usern) {
        
           $query= Updatestatus::find()->where(['usern' => $usern])->andFilterWhere(['like', 'COTableName','tblrs'])->orderBy(['COUpadteDate' => SORT_DESC]);
           $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  5
           ],
            
       ]);
           
           
         return $this->render('view', ['provider' => $provider, 'ICNO' => $usern]);
         
    }
       public function actionViewuser($usern) {
        
           $query= Updatestatus::find()->where(['usern' => $usern])->orderBy(['COUpadteDate' => SORT_DESC]);
           $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  5
           ],
            
       ]);
           
           
         return $this->render('viewuser', ['provider' => $provider, 'ICNO' => $usern]);
         
    }

    /**
     * Creates a new updatestatus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new updatestatus();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing updatestatus model.
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
     * Deletes an existing updatestatus model.
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
     * Finds the updatestatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return updatestatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
 
    
     protected function findModelbyid($id)
    {
        if (($model = updatestatus::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
      protected function findModelbyicno($usern) {
        if (($model = updatestatus::findAll(['usern' => $usern])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
