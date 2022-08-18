<?php

namespace app\controllers;

use Yii;
use app\models\kemudahan\TblPayinstruct;
use app\models\kemudahan\TblPayinstructSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\kemudahan\TblPayInstructDetails;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblprcobiodata;
use yii\filters\AccessControl;


/**
 * PayinstructController implements the CRUD actions for TblPayinstruct model.
 */
class PayinstructController extends Controller
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
                    'logout' => ['post'],
                    'remove-staff' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all TblPayinstruct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblPayinstructSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblPayinstruct model.
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
     * Creates a new TblPayinstruct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TblPayinstruct();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->PAY_ID]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblPayinstruct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->PAY_ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblPayinstruct model.
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
     * Finds the TblPayinstruct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblPayinstruct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblPayinstruct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findBorang($id)
    {
        if (($model = Borang::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    } 
     protected function findElaun($id)
    {
        if (($model = TblPayInstructDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     public function actionPayment()
    {
         
          $query = TblPayinstruct::find()->orderBy(['PAY_DATE_FROM' => SORT_DESC]); 
         
          $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         
        return $this->render('payment', [ 
            'dataProvider' => $dataProvider,   
        ]);
        
    }
    
      public function actionElaunDetails()
    {
        if (isset($_POST['expandRowKey'])) {
            $model = TblPayinstruct::find()->where(['PAY_ID' => $_POST['expandRowKey']]);
            $dataProvider = new ActiveDataProvider([
                'query' => $model,
                'pagination' => [
                    //'pageSize' => 20,
                    'pageSize' => 5,
                ],
                'sort' => false,
            ]);
            return $this->renderPartial('_elaun2', ['dataProvider' => $dataProvider]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }
    
     public function actionPay($id)
    {
          $model = $this->findModel($id); 

          $query = TblPayInstructDetails::find()->where(['id' => $model->PAY_ID ])->andWhere(['icno' => $model->PAY_STAFF_ICNO])->orderBy(['from' => SORT_DESC]); 
           

          $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
          
        return $this->render('pay', [ 
             'dataProvider' => $dataProvider, 
                'model' => $model, 
        ]);
        
    }
   
    public function actionNewElaun($id)
    {
    
        $model = $this->findModel($id); 
        
        $batch = TblPayInstruct::findOne(['PAY_ID' => $model->PAY_ID]); 
        $query = TblPayInstruct::find()->where(['PAY_ID' => $model->PAY_ID ])->orderBy(['PAY_DATE_FROM' => SORT_DESC]); 
     
          $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
          
           
  
        return $this->renderAjax('new_elaun', [ 'model' => $model, 'batch' => $batch,'dataProvider' => $dataProvider]);
    }
    
      

}
