<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblrscoconfirmstatus;
use app\models\hronline\tblrscoconfirmstatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\hronline\Confirmationstatus;

/**
 * StatusPengesahanController implements the CRUD actions for tblrscoconfirmstatus model.
 */
class StatusPengesahanController extends Controller
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
     * Lists all tblrscoconfirmstatus models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new tblrscoconfirmstatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblrscoconfirmstatus model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//     public function actionView($icno) {
//        return $this->render('view', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno]);
//    }
//    
//    public function actionViewuser($icno) {
//        return $this->render('viewuser', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno]);
//    }
    
      public function actionView($icno) {
       $alamat = \app\models\hronline\Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->orderBy(['ConfirmStatusStDt' => SORT_DESC])->all();
        return $this->render('view', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    
     public function actionViewuser($icno) {
        $alamat = \app\models\hronline\Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->orderBy(['ConfirmStatusStDt' => SORT_DESC])->all();
        return $this->render('viewuser', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    

    /**
     * Creates a new tblrscoconfirmstatus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblrscoconfirmstatus();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing tblrscoconfirmstatus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
     public function actionTambahPengesahan($icno) {
        $statusPengesahan =  ArrayHelper::map(\app\models\hronline\Confirmationstatus::find()->all(), 'ConfirmStatusCd', 'ConfirmStatusNm');
        $model = new Tblrscoconfirmstatus();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('tambah-pengesahan', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd,'statusPengesahan' => $statusPengesahan

        ]);
    }
   public function actionUpdate($id) {
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
    $statusPengesahan =  ArrayHelper::map(\app\models\hronline\Confirmationstatus::find()->all(), 'ConfirmStatusCd', 'ConfirmStatusNm');
       
        if ($model->load(Yii::$app->request->post()) ) {
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
               


            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,'statusPengesahan' => $statusPengesahan

        ]);
    }
    /**
     * Deletes an existing tblrscoconfirmstatus model.
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
     * Finds the tblrscoconfirmstatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblrscoconfirmstatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
  
    protected function findModelbyid($id) {
        if (($model = Tblrscoconfirmstatus::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblrscoconfirmstatus::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
