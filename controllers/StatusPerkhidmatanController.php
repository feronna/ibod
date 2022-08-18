<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblrscoservstatus;

use app\models\hronline\tblrscoservstatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;


/**
 * StatusPerkhidmatanController implements the CRUD actions for tblrscoservstatus model.
 */
class StatusPerkhidmatanController extends Controller
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
     * Lists all tblrscoservstatus models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new tblrscoservstatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblrscoservstatus model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   public function actionView($icno) {
         $alamat = Tblrscoservstatus::find()->where(['ICNO' => $icno])->orderBy(['ServStatusStDt' => SORT_DESC])->all();
        return $this->render('view', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    
     public function actionViewuser($icno) {
        $alamat = Tblrscoservstatus::find()->where(['ICNO' => $icno])->orderBy(['ServStatusStDt' => SORT_DESC])->all();
        return $this->render('viewuser', ['alamat' => $alamat, 'ICNO' => $icno]);
    }

    /**
     * Creates a new tblrscoservstatus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblrscoservstatus();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
     public function actionTambahPerkhidmatan($icno) {
      //  $request = Yii::$app->request;
       // $id = $request->get('id');
        $statusPerkhidmatan =  ArrayHelper::map(\app\models\hronline\ServiceStatus::find()->all(), 'ServStatusCd', 'ServStatusNm');
        $statusTerperinci=  ArrayHelper::map(\app\models\hronline\Servicestatusdetail::find()->all(), 'id', 'name');
        $model = new Tblrscoservstatus();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->save(false);
            
            //----------update table biodata pemohon---------//
                    $biodataApps = \app\models\hronline\Tblprcobiodata::findOne($icno);
                    $biodataApps->Status = $model->ServStatusCd;
                  //  $biodataApps->last_update = date('Y-m-d H:i:s');
                    $biodataApps->last_updater = Yii::$app->user->identity->getId();
                    $biodataApps->save(false);
                    //----------update table biodata pemohon---------//

           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('tambah-perkhidmatan', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd,'statusTerperinci' => $statusTerperinci,
            'statusPerkhidmatan' => $statusPerkhidmatan, 'biodata' => $biodata
        ]);
    }

    /**
     * Updates an existing tblrscoservstatus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
      public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
           $statusPerkhidmatan =  ArrayHelper::map(\app\models\hronline\ServiceStatus::find()->all(), 'ServStatusCd', 'ServStatusNm');
        $statusTerperinci=  ArrayHelper::map(\app\models\hronline\Servicestatusdetail::find()->all(), 'id', 'name');
      
        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            
              //----------update table biodata pemohon---------//
                    $biodataApps = \app\models\hronline\Tblprcobiodata::findOne($model->ICNO);
                    $biodataApps->Status = $model->ServStatusCd;
                  //  $biodataApps->last_update = date('Y-m-d H:i:s');
                    $biodataApps->last_updater = Yii::$app->user->identity->getId();
                    $biodataApps->save(false);
                    //----------update table biodata pemohon---------//
                    
                    
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,'statusTerperinci' => $statusTerperinci,
            'statusPerkhidmatan' => $statusPerkhidmatan
        ]);
    }

    /**
     * Deletes an existing tblrscoservstatus model.
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
     * Finds the tblrscoservstatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblrscoservstatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
   
       protected function findModelbyid($id) {
        if (($model = Tblrscoservstatus::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblrscoservstatus::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
