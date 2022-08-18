<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblrscopersalpoint;
use app\models\hronline\TblrscopersalpointSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * MataGajiController implements the CRUD actions for tblrscopersalpoint model.
 */
class MataGajiController extends Controller
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
     * Lists all tblrscopersalpoint models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblrscopersalpointSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblrscopersalpoint model.
     * @param string $id
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
     * Creates a new tblrscopersalpoint model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblrscopersalpoint();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing tblrscopersalpoint model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
public function actionTambahMata($icno) {
        $request = Yii::$app->request;
       // $id = $request->get('id');
      
        $model = new Tblrscopersalpoint();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        
      $kodMataGaji =  ArrayHelper::map(\app\models\hronline\Salarypoint::find()->all(), 'SalPointCd', 'SalPointCd');

      
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
//            $Tblrscopersalpoint = $request->post()['Tblrscopersalpoint'];
//            $SalPointCd  = $Tblrscopersalpoint['SalPointCd'];
//            $PerSalPointStDt = date_format(date_create($request->post('PerSalPointStDt')), 'Y-m-d');
//            $model->PerSalPointStDt = $PerSalPointStDt;
//            $model->SalPointCd = $SalPointCd;
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('tambah-mata', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd,
            'kodMataGaji'=>$kodMataGaji
        ]);
    }
    public function actionUpdate($id) {
  //      $request = Yii::$app->request;
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
       
        $kodMataGaji =  ArrayHelper::map(\app\models\hronline\Salarypoint::find()->all(), 'SalPointCd', 'SalPointCd');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            $Tblrscopersalpoint = $request->post()['Tblrscopersalpoint'];
//            $SalPointCd  = $Tblrscopersalpoint['SalPointCd'];
//            $PerSalPointStDt = date_format(date_create($request->post('PerSalPointStDt')), 'Y-m-d');
//            $model->PerSalPointStDt = $PerSalPointStDt;
//            $model->SalPointCd = $SalPointCd;
 
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
               

            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,'kodMataGaji' => $kodMataGaji
        ]);
    }


    /**
     * Deletes an existing tblrscopersalpoint model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the tblrscopersalpoint model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblrscopersalpoint the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelbyid($id)
    {
        if (($model = Tblrscopersalpoint::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
       protected function findModelbyicno($icno) {
        if (($model = Tblrscopersalpoint::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
