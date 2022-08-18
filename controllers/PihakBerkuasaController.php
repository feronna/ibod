<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblrscoaptathy;
use app\models\hronline\tblrscoaptathySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\hronline\Appointingauthority;
/**
 * PihakBerkuasaController implements the CRUD actions for tblrscoaptathy model.
 */
class PihakBerkuasaController extends Controller
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
     * Lists all tblrscoaptathy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new tblrscoaptathySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblrscoaptathy model.
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
     * Creates a new tblrscoaptathy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblrscoaptathy();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

     
     public function actionTambahKuasa($icno) {
    //    $request = Yii::$app->request;
       // $id = $request->get('id');
        $kuasaMelantik =  ArrayHelper::map(Appointingauthority::find()->all(), 'AptAthyCd', 'AptAthyNm');
       
        $model = new Tblrscoaptathy();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
//            $Tblrscoaptathy = $request->post()['Tblrscoaptathy'];
//            $AptAthyCd  = $Tblrscoaptathy['AptAthyCd'];
//            $ICNOHeadServ = $Tblrscoaptathy['ICNOHeadServ'];
//            $AptAthyStDt = date_format(date_create($request->post('AptAthyStDt')), 'Y-m-d');
//            $model->AptAthyStDt = $AptAthyStDt;
//            $model->ICNOHeadServ  = $ICNOHeadServ;
//            $model->AptAthyCd = $AptAthyCd;
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('tambah-kuasa', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd,'kuasaMelantik' => $kuasaMelantik

        ]);
    }
      public function actionUpdate($id) {
       //    $request = Yii::$app->request;
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
         $kuasaMelantik =  ArrayHelper::map(Appointingauthority::find()->all(), 'AptAthyCd', 'AptAthyNm');
       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            
//            $Tblrscoaptathy = $request->post()['Tblrscoaptathy'];
//            $AptAthyCd  = $Tblrscoaptathy['AptAthyCd'];
//            $ICNOHeadServ = $Tblrscoaptathy['ICNOHeadServ'];
//            $AptAthyStDt = date_format(date_create($request->post('AptAthyStDt')), 'Y-m-d');
//            $model->AptAthyStDt = $AptAthyStDt;
//            $model->ICNOHeadServ  = $ICNOHeadServ;
//            $model->AptAthyCd = $AptAthyCd;
      

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,'kuasaMelantik' => $kuasaMelantik
        ]);
    }

    /**
     * Deletes an existing tblrscoaptathy model.
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
     * Finds the tblrscoaptathy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblrscoaptathy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
 
     protected function findModelbyid($id) {
        if (($model = Tblrscoaptathy::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblrscoaptathy::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
