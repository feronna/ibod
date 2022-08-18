<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblrscoretireage;
use app\models\hronline\tblrscoretireageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * UmurBersaraController implements the CRUD actions for tblrscoretireage model.
 */
class UmurBersaraController extends Controller
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
     * Lists all tblrscoretireage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new tblrscoretireageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblrscoretireage model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//   public function actionView($icno) {
//        return $this->render('view', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno]);
//    }
//    
//    public function actionViewuser($icno) {
//        $alamat = \app\models\hronline\Tblrscoretireage::find()->where(['ICNO' => $icno])->orderBy(['id' => SORT_DESC])->all();
//        return $this->render('viewuser', ['alamat' => $alamat, 'ICNO' => $icno]);
//    }
    
       public function actionView($icno) {
      $alamat = \app\models\hronline\Tblrscoretireage::find()->where(['ICNO' => $icno])->orderBy(['CORetireAgeEftvDt' => SORT_DESC])->all();
        return $this->render('view', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    
     public function actionViewuser($icno) {
         $alamat = \app\models\hronline\Tblrscoretireage::find()->where(['ICNO' => $icno])->orderBy(['CORetireAgeEftvDt' => SORT_DESC])->all();
        return $this->render('viewuser', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    

    /**
     * Creates a new tblrscoretireage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblrscoretireage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing tblrscoretireage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTambahUmurBersara($icno) {
     //   $request = Yii::$app->request;
       // $id = $request->get('id');
      
        $model = new Tblrscoretireage();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        
      $umurBersara =  ArrayHelper::map(\app\models\hronline\Retireage::find()->all(), 'RetireAgeCd', 'Name');

      
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('tambah-umur-bersara', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd,
            'umurBersara'=>$umurBersara
        ]);
    }
    public function actionUpdate($id) {
    
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
       
        $umurBersara =  ArrayHelper::map(\app\models\hronline\Retireage::find()->all(), 'RetireAgeCd', 'Name');

        if ($model->load(Yii::$app->request->post()) ) {
            $model->save(false);
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
               

            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,'umurBersara' => $umurBersara
        ]);
    }

    /**
     * Deletes an existing tblrscoretireage model.
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
     * Finds the tblrscoretireage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return tblrscoretireage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
 
    protected function findModelbyid($id) {
        if (($model = Tblrscoretireage::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblrscoretireage::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
