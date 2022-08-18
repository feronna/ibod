<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblrscoprobtnperiod;
use app\models\hronline\tblrscoprobtnperiodSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * TempohPercubaanController implements the CRUD actions for tblrscoprobtnperiod model.
 */
class TempohPercubaanController extends Controller
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
     * Lists all tblrscoprobtnperiod models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new tblrscoprobtnperiodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblrscoprobtnperiod model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionView($icno) {
         
         $alamat = \app\models\hronline\Tblrscoprobtnperiod::find()->where(['ICNO' => $icno])->orderBy(['id' => SORT_DESC])->limit(1)->all();
           
        return $this->render('view', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    
     public function actionViewuser($icno) {
         $alamat = \app\models\hronline\Tblrscoprobtnperiod::find()->where(['ICNO' => $icno])->orderBy(['id' => SORT_DESC])->limit(1)->all();
         
        return $this->render('viewuser', ['alamat' => $alamat, 'ICNO' => $icno]);
    }

    /**
     * Creates a new tblrscoprobtnperiod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblrscoprobtnperiod();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing tblrscoprobtnperiod model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
     public function actionTambahPercubaan($icno) {
     //   $request = Yii::$app->request;
       // $id = $request->get('id');
      
        $model = new Tblrscoprobtnperiod();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
//            $Tblrscoprobtnperiod = $request->post()['Tblrscoprobtnperiod'];
//            $ProbtnPeriodMin  = $Tblrscoprobtnperiod['ProbtnPeriodMin'];
//            $ProbtnPeriod  = $Tblrscoprobtnperiod['ProbtnPeriod'];
//            $ProbtnStDt = date_format(date_create($request->post('ProbtnStDt')), 'Y-m-d');
//            $model->ProbtnStDt = $ProbtnStDt;
//            $ProbtnEndDt = date_format(date_create($request->post('ProbtnEndDt')), 'Y-m-d');
//            $model->ProbtnEndDt = $ProbtnEndDt;
//             $model->ProbtnPeriod = $ProbtnPeriod;
//            $model->ProbtnPeriodMin = $ProbtnPeriodMin;
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('tambah-percubaan', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd
        ]);
    }
  public function actionUpdate($id) {
     //       $request = Yii::$app->request;
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
  
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
               


            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,
        ]);
    }

    /**
     * Deletes an existing tblrscoprobtnperiod model.
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

    /**
     * Finds the tblrscoprobtnperiod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblrscoprobtnperiod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
  
     protected function findModelbyid($id) {
        if (($model = Tblrscoprobtnperiod::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblrscoprobtnperiod::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
