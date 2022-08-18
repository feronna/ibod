<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\Tblrscosandangan;
use app\models\TblrscosandanganSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use app\models\hronline\GredJawatan;
use \app\models\hronline\Appointmenttype;
use app\models\hronline\Tblprcobiodata;
/**
 * StatusSandanganController implements the CRUD actions for Tblrscosandangan model.
 */
class StatusSandanganController extends Controller
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
     * Lists all Tblrscosandangan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblrscosandanganSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tblrscosandangan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
  public function actionView($icno) {
       $alamat = Tblrscosandangan::find()->where(['ICNO' => $icno])->orderBy(['start_date' => SORT_DESC])->all();
        return $this->render('view', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    
     public function actionViewuser($icno) {
        $alamat = Tblrscosandangan::find()->where(['ICNO' => $icno])->orderBy(['start_date' => SORT_DESC])->all();
        return $this->render('viewuser', ['alamat' => $alamat, 'ICNO' => $icno]);
    }

    /**
     * Creates a new Tblrscosandangan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tblrscosandangan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
        public function actionTambahSandangan($icno) {
       // $request = Yii::$app->request;
       // $id = $request->get('id');
        $lantikan =  ArrayHelper::map(\app\models\hronline\GredJawatan::find()->all(), 'id', 'fname');
        $jenisLantikan =  ArrayHelper::map(Appointmenttype::find()->all(), 'ApmtTypeCd', 'ApmtTypeNm');
        $statusSandangan =  ArrayHelper::map(\app\models\hronline\Sandangan::find()->all(), 'sandangan_id', 'sandangan_name');
        $model = new Tblrscosandangan();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->save(false);
            
              //----------update table biodata pemohon---------//
                    $biodataApps = \app\models\hronline\Tblprcobiodata::findOne($icno);
                    $biodataApps->statSandangan = $model->sandangan_id;
                    $biodataApps->ApmtTypeCd = $model->ApmtTypeCd;
                    $biodataApps->gredJawatan = $model->gredjawatan;
                    $biodataApps->last_update = date('Y-m-d H:i:s');
                    $biodataApps->startDateSandangan = $model->start_date;
                    $biodataApps->last_updater = Yii::$app->user->identity->getId();
                    $biodataApps->save(false);
                    //----------update table biodata pemohon---------//
              
                       //----------tambah table pergerakan gaji pemohon---------//
                    $pergerakanGaji = new \app\models\hronline\Tblrscosalmovemth();
                    $pergerakanGaji->SalMoveMthStDt = $model->start_date;
                    $pergerakanGaji->ICNO = $model->ICNO;
                    $pergerakanGaji->SalMoveMthType = 1;
                    $bulan = date_format(date_create($model->start_date),"m");
                    
                    if($bulan < 4 ){
                        $pergerakanGaji->SalMoveMth = '01';
                    }else if($bulan < 7 && $bulan >= 4){
                        $pergerakanGaji->SalMoveMth = '04';
                    }else if($bulan  < 10 && $bulan >= 7 ){
                        $pergerakanGaji->SalMoveMth = '07';
                    }else{
                        $pergerakanGaji->SalMoveMth = '10';
                    }
                    $pergerakanGaji->save(false);
                
                    //----------update table pergerakan gaji pemohon---------//
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('tambah-sandangan', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd,'lantikan' => $lantikan,'jenisLantikan'=> $jenisLantikan,
            'statusSandangan' => $statusSandangan
       
                ]);
    }

    /**
     * Updates an existing Tblrscosandangan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
      public function actionUpdate($id) {
    //    $request = Yii::$app->request;
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        $lantikan =  ArrayHelper::map(\app\models\hronline\GredJawatan::find()->all(), 'id', 'fname');
        $jenisLantikan =  ArrayHelper::map(Appointmenttype::find()->all(), 'ApmtTypeCd', 'ApmtTypeNm');
        $statusSandangan =  ArrayHelper::map(\app\models\hronline\Sandangan::find()->all(), 'sandangan_id', 'sandangan_name');
      

        if ($model->load(Yii::$app->request->post())) {
        $model->save(false);
            
              //----------update table biodata pemohon---------//
                    $biodataApps = \app\models\hronline\Tblprcobiodata::findOne($model->ICNO);
                    $biodataApps->statSandangan = $model->sandangan_id;
                    $biodataApps->ApmtTypeCd = $model->ApmtTypeCd;
                    $biodataApps->gredJawatan = $model->gredjawatan;
                    $biodataApps->last_update = date('Y-m-d H:i:s');
                   $biodataApps->startDateSandangan = $model->start_date;
                    $biodataApps->last_updater = Yii::$app->user->identity->getId();
                    $biodataApps->save(false);
                    //----------update table biodata pemohon---------//
            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,'lantikan' => $lantikan, 'jenisLantikan'=>$jenisLantikan,
            'statusSandangan' => $statusSandangan
        ]);
    }

    /**
     * Deletes an existing Tblrscosandangan model.
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
     * Finds the Tblrscosandangan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tblrscosandangan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */    
    protected function findModelbyid($id) {
        if (($model = Tblrscosandangan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
       protected function findModelbyicno($icno) {
        if (($model = Tblrscosandangan::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
