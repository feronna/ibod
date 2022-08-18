<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\vhrms\ViewPayroll;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\ArrayHelper;
error_reporting(0);
/**
 * JenisPerkhidmatanController implements the CRUD actions for tblrscoservtype model.
 */
class JumlahGajiController extends Controller
{
    /**
     * {@inheritdoc}
     */
     public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create', 'update', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'tambahalamat', 'view'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $COOldID = Yii::$app->request->get('COOldID');
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $access = Yii::$app->user->identity->accessLevel;

                            return $logicno === $COOldID || $access === 1;
                        }
                    ],
                 
                ],
            ],
        ];
    }

    /**
     * Lists all tblrscoservtype models.
     * @return mixed
     */
 

 
    public function actionView($COOldID) {
      $model1 = new ViewPayroll();
     // $ICNO = Yii::$app->user->getId();
    // $self = Tblprcobiodata::findOne(['ICNO'=>$ICNO]);
      $MPH_STAFF_ID = ViewPayroll::find()->where(['MPH_STAFF_ID' => $COOldID])->one();
      
      $carian = ArrayHelper::map(ViewPayroll::find()->select('MPH_PAY_MONTH')->where(['MPH_STAFF_ID' => $COOldID])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->distinct()->all(),'MPH_PAY_MONTH','MPH_PAY_MONTH');
      $m = date('m');
      $y = date('Y');
      $pm = $y.$m;
 
      $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$pm-1])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
      $model2 = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$pm-1])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
   
      if (Yii::$app->request->post('cari')) {
        $data = Yii::$app->request->post('search');  
        $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID])->andFilterWhere(['LIKE','MPH_PAY_MONTH',$data])->all();
        $model2 = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID])->andFilterWhere(['LIKE','MPH_PAY_MONTH',$data])->limit(1)->all();

        //Html::a('Jumlah Gaji', ['jumlah-gaji/view', 'COOldID' => $model->COOldID]) 
       // return $this->render('view', [ 'carian' => $carian, 'model' => $model, 'model2' => $model2]);
 
    }
        
        return $this->render('view', compact('model', 'carian','model1','model2'));
    }   //('Jumlah Gaji', ['jumlah-gaji/view', 'COOldID' => $model->COOldID]) 

    /**
     * Creates a new tblrscoservtype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
      public function actionViewuser($COOldID) {
       
      $model1 = new ViewPayroll();
     // $ICNO = Yii::$app->user->getId();
    // $self = Tblprcobiodata::findOne(['ICNO'=>$ICNO]);
      $MPH_STAFF_ID = ViewPayroll::find()->where(['MPH_STAFF_ID' => $COOldID])->one();
      
      $carian = ArrayHelper::map(ViewPayroll::find()->select('MPH_PAY_MONTH')->where(['MPH_STAFF_ID' => $COOldID])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->distinct()->all(),'MPH_PAY_MONTH','MPH_PAY_MONTH');
      $m = date('m');
      $y = date('Y');
      $pm = $y.$m;
 
      $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$pm-1])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
      $model2 = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$pm-1])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
   
      if (Yii::$app->request->post('cari')) {
        $data = Yii::$app->request->post('search');  
        $model = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID])->andFilterWhere(['LIKE','MPH_PAY_MONTH',$data])->all();
        $model2 = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID])->andFilterWhere(['LIKE','MPH_PAY_MONTH',$data])->limit(1)->all();

        //Html::a('Jumlah Gaji', ['jumlah-gaji/view', 'COOldID' => $model->COOldID]) 
       // return $this->render('view', [ 'carian' => $carian, 'model' => $model, 'model2' => $model2]);
 
    }
        
        return $this->render('viewuser', compact('model', 'carian','model1','model2'));
    } 
    public function actionCreate()
    {
        $model = new ViewPayroll();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing tblrscoservtype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing tblrscoservtype model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   public function actionDelete($id) {
        $model = $this->findModelbyid($id);
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['view', 'icno' => $model->ICNO]);
    }
    
     public function actionRedirectview() {
        $id = Yii::$app->user->getId();
       
        return $this->redirect(['view','id'=>$id]);
    }
    
    public function actionRedirectviews($COOldID) {
        $id = $COOldID;
        
        return $this->redirect(['view','id'=>$id]);  
    }
   


    /**
     * Finds the tblrscoservtype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblrscoservtype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
      protected function findModelbyid($id) {
        if (($model = ViewPayroll::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($COOldID) {
        if (($model = ViewPayroll::findAll(['MPH_STAFF_ID' => $COOldID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
