<?php
namespace app\controllers;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\Tblrscoapmtstatus;
use app\models\TblrscoapmtstatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\StatusLantikan;
use app\models\hronline\Umsper;
/**
 * StatusLantikanController implements the CRUD actions for Tblrscoapmtstatus model.
 */

class StatusLantikanController extends Controller
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
     * Lists all Tblrscoapmtstatus models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblrscoapmtstatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tblrscoapmtstatus model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   public function actionView($icno) {
      $alamat = Tblrscoapmtstatus::find()->where(['ICNO' => $icno])->orderBy(['ApmtStatusStDt' => SORT_DESC])->all();
        return $this->render('view', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    
     public function actionViewuser($icno) {
         $alamat = Tblrscoapmtstatus::find()->where(['ICNO' => $icno])->orderBy(['id' => SORT_DESC])->all();
        return $this->render('viewuser', ['alamat' => $alamat, 'ICNO' => $icno]);
    }

    /**
     * Creates a new Tblrscoapmtstatus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tblrscoapmtstatus();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tblrscoapmtstatus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
      public function actionTambahLantikan($icno) {
        $lantikan =  ArrayHelper::map(StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm');
        $model = new Tblrscoapmtstatus();
  
        
            $user = \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $icno]);
            $prev_umsper = Umsper::find()->where(['ICNO' => $user->ICNO])->orderBy(['COOldIDNo' => SORT_DESC])->one();
            $prev_umsper_pks = \app\models\hronline\Umsperpks::find()->where(['ICNO' => $user->ICNO])->orderBy(['COOldIDNo' => SORT_DESC])->one();
                  
      
            
            if($prev_umsper != null) {
            $COOldIDNo = $prev_umsper->COOldIDNo;
            }else{
                $COOldIDNo = $prev_umsper_pks->COOldIDNo;
            }
            
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->save(false);
            
        if($prev_umsper != null){
               if (($user->statLantikan != 1) && ($model->ApmtStatusCd == 1)){
                    
                        //----------update table umsper pemohon---------//
                    $umsper = new Umsper();
                    $umsper->ICNO =  $model->ICNO;
                    $umsper->JobId = $model->kakitangan->jawatan->id;
                    $umsper->DeptId = $model->kakitangan->DeptId;
                    $umsper->campus_id = $model->kakitangan->campus_id;
                  
                    $umsper->StartDate =  $model->ApmtStatusStDt;
                    $umsper->COOldIDDt = date("ymd", strtotime($model['ApmtStatusStDt']));
                    $umsper->COOldIDNo = $COOldIDNo;
                    $umsper->COOldID =  date("ymd", strtotime($model['ApmtStatusStDt'])) . '-' . $COOldIDNo;
                    $umsper->save(false);
                    //----------update table biodata pemohon---------//
                    
                    
                             //----------update table biodata pemohon---------//
                    $biodataApps = \app\models\hronline\Tblprcobiodata::findOne($icno);
                    $biodataApps->COOldID = $umsper->COOldID;
                    $biodataApps->COOUCTelNo = '1' . $COOldIDNo;
                    $biodataApps->statLantikan = $model->ApmtStatusCd;
                    $biodataApps->startDateLantik = $model->ApmtStatusStDt;
                    $biodataApps->endDateLantik = $model->ApmtStatusEndDt;
                    $biodataApps->last_update = date('Y-m-d H:i:s');
                    $biodataApps->last_updater = Yii::$app->user->identity->getId();
                    $biodataApps->save(false);
                    //----------update table biodata pemohon---------//
                    
                    
                               //----------update table failper pemohon---------//
                    $file = new \app\models\hronline\Tblrscofileno();
                    $file->ICNO =  $model->ICNO;
                    $file->COFileNoEftvDt =  $model->ApmtStatusStDt;
                    $file->COFileNo =  date("ymd", strtotime($model['ApmtStatusStDt'])) . '-' . $COOldIDNo;
                    $file->save(false);
                    //----------update table biodata pemohon---------//
                
                    
         }
        
         
    } 
     if($prev_umsper == null){
        
           if (($user->statLantikan != 1) && ($model->ApmtStatusCd == 1)){
                    
                        //----------update table umsperpks pemohon---------//
                    $umsperpks = new \app\models\hronline\Umsperpks();
                    $umsperpks->ICNO =  $model->ICNO;
                    $umsperpks->JobId = $model->kakitangan->jawatan->id;
                    $umsperpks->DeptId = $model->kakitangan->DeptId;
                    $umsperpks->campus_id = $model->kakitangan->campus_id;
                  
                    $umsperpks->StartDate =  $model->ApmtStatusStDt;
                    $umsperpks->COOldIDDt = date("ymd", strtotime($model['ApmtStatusStDt']));
                    $umsperpks->COOldIDNo = $COOldIDNo;
                    $umsperpks->COOldID =  date("ymd", strtotime($model['ApmtStatusStDt'])) . '-' . $COOldIDNo;
                    $umsperpks->save(false);
                    //----------update table biodata pemohon---------//
                    
                    
                             //----------update table biodata pemohon---------//
                    $biodataApps = \app\models\hronline\Tblprcobiodata::findOne($icno);
                    $biodataApps->COOldID = $umsperpks->COOldID;
                    $biodataApps->COOUCTelNo = '1' . $COOldIDNo;
                    $biodataApps->statLantikan = $model->ApmtStatusCd;
                    $biodataApps->startDateLantik = $model->ApmtStatusStDt;
                    $biodataApps->endDateLantik = $model->ApmtStatusEndDt;
                    $biodataApps->last_update = date('Y-m-d H:i:s');
                    $biodataApps->last_updater = Yii::$app->user->identity->getId();
                    $biodataApps->save(false);
                    //----------update table biodata pemohon---------//
                    
                    
                               //----------update table failper pemohon---------//
                    $file = new \app\models\hronline\Tblrscofileno();
                    $file->ICNO =  $model->ICNO;
                    $file->COFileNoEftvDt =  $model->ApmtStatusStDt;
                    $file->COFileNo =  date("ymd", strtotime($model['ApmtStatusStDt'])) . '-' . $COOldIDNo;
                    $file->save(false);
                    //----------update table biodata pemohon---------//
           }
    } else{
            
                    //----------update table biodata pemohon---------//
                    $biodataApps = \app\models\hronline\Tblprcobiodata::findOne($icno);
                    $biodataApps->statLantikan = $model->ApmtStatusCd;
                    $biodataApps->startDateLantik = $model->ApmtStatusStDt;
                    $biodataApps->endDateLantik = $model->ApmtStatusEndDt;
                    $biodataApps->last_update = date('Y-m-d H:i:s');
                    $biodataApps->last_updater = Yii::$app->user->identity->getId();
                    $biodataApps->save(false);
                    //----------update table biodata pemohon---------//
                    
                
        }
        
                  Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);    
                    return $this->redirect(['view', 'icno' => $model->ICNO]);
            
    } 
        
        return $this->render('tambah-lantikan', [
                    'model' => $model,'icno' => $icno,'lantikan' => $lantikan
        ]);
    }
      public function actionUpdate($id) {
    //    $request = Yii::$app->request;
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        $lantikan =  ArrayHelper::map(StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm');
           
         if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            
             //----------update table biodata pemohon---------//
                    $biodataApps = \app\models\hronline\Tblprcobiodata::findOne($model->ICNO);
                    $biodataApps->statLantikan = $model->ApmtStatusCd;
                    $biodataApps->last_update = date('Y-m-d H:i:s');
                    $biodataApps->last_updater = Yii::$app->user->identity->getId();
                    $biodataApps->save(false);
                    //----------update table biodata pemohon---------//
            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);        
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,'lantikan' => $lantikan]);
    }
    /**
     * Deletes an existing Tblrscoapmtstatus model.
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
     * Finds the Tblrscoapmtstatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tblrscoapmtstatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
   
    protected function findModelbyid($id) {
        if (($model = Tblrscoapmtstatus::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblrscoapmtstatus::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
