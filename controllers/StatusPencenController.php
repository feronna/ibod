<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblrscopsnstatus;
use app\models\hronline\tblrscopsnstatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * StatusPencenController implements the CRUD actions for tblrscopsnstatus model.
 */
class StatusPencenController extends Controller
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
     * Lists all tblrscopsnstatus models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new tblrscopsnstatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblrscopsnstatus model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//     public function actionView($icno) {
//        return $this->render('view', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno]);
//    }
//    
//         public function actionViewuser($icno) {
//        return $this->render('viewuser', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno]);
//    }
    
       public function actionView($icno) {
       $alamat = \app\models\hronline\Tblrscopsnstatus::find()->where(['ICNO' => $icno])->orderBy(['PsnStatusStDt' => SORT_DESC])->limit(1)->all();
     
       return $this->render('view', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    
     public function actionViewuser($icno) {
       $alamat = \app\models\hronline\Tblrscopsnstatus::find()->where(['ICNO' => $icno])->orderBy(['PsnStatusStDt' => SORT_DESC])->limit(1)->all();
     
       return $this->render('viewuser', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    
       
//    public function actionView($icno) {
//         $noKwsp = Kwsp::find()->where(['staff_id' => $icno])->all();
//        return $this->render('view', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno, 
//            'noKwsp' => $noKwsp
//            ]);
//    }
    
    

    /**
     * Creates a new tblrscopsnstatus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblrscopsnstatus();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing tblrscopsnstatus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionTambahPencen($icno) {
   //     $request = Yii::$app->request;
       // $id = $request->get('id');
      
        $model = new Tblrscopsnstatus();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        
      $pencen =  ArrayHelper::map(\app\models\hronline\Pensionstatus::find()->all(), 'PsnStatusCd', 'PsnStatusNm');

      
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
//            $Tblrscopsnstatus = $request->post()['Tblrscopsnstatus'];
//            $PsnStatusNo  = $Tblrscopsnstatus['PsnStatusNo'];
//            $PsnStatusCd = $Tblrscopsnstatus['PsnStatusCd'];
//            $PsnIncomeTaxNo  = $Tblrscopsnstatus['PsnIncomeTaxNo'];
//            $PsnEpfNo  = $Tblrscopsnstatus['PsnEpfNo'];
             
//            $PsnStatusStDt = date_format(date_create($request->post('PsnStatusStDt')), 'Y-m-d');
//            $model->PsnStatusStDt = $PsnStatusStDt;
//            
//            $model->PsnStatusNo = $PsnStatusNo;
//            $model->PsnStatusCd  = $PsnStatusCd;
//            $model->PsnIncomeTaxNo   = $PsnIncomeTaxNo;
//            $model->PsnEpfNo   = $PsnEpfNo;
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('tambah-pencen', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd,
            'pencen'=>$pencen
        ]);
    }
    public function actionUpdate($id) {
  //      $request = Yii::$app->request;
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        $pencen =  ArrayHelper::map(\app\models\hronline\Pensionstatus::find()->all(), 'PsnStatusCd', 'PsnStatusNm');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            $Tblrscopsnstatus = $request->post()['Tblrscopsnstatus'];
//            $PsnStatusNo  = $Tblrscopsnstatus['PsnStatusNo'];
//            $PsnStatusCd = $Tblrscopsnstatus['PsnStatusCd'];
//            $PsnIncomeTaxNo  = $Tblrscopsnstatus['PsnIncomeTaxNo'];
//            $PsnEpfNo  = $Tblrscopsnstatus['PsnEpfNo'];
//             
//            $PsnStatusStDt = date_format(date_create($request->post('PsnStatusStDt')), 'Y-m-d');
//            $model->PsnStatusStDt = $PsnStatusStDt;
//            
//            $model->PsnStatusNo = $PsnStatusNo;
//            $model->PsnStatusCd  = $PsnStatusCd;
//            $model->PsnIncomeTaxNo   = $PsnIncomeTaxNo;
//            $model->PsnEpfNo   = $PsnEpfNo;
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
               

            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,'pencen'=>$pencen
        ]);
    }

    /**
     * Deletes an existing tblrscopsnstatus model.
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
     * Finds the tblrscopsnstatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblrscopsnstatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
 
    
     protected function findModelbyid($id) {
        if (($model = Tblrscopsnstatus::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblrscopsnstatus::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
