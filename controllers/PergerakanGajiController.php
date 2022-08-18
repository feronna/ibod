<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblrscosalmovemth;
use app\models\hronline\tblrscosalmovemthSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * PergerakanGajiController implements the CRUD actions for tblrscosalmovemth model.
 */
class PergerakanGajiController extends Controller
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
     * Lists all tblrscosalmovemth models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new tblrscosalmovemthSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    

    /**
     * Displays a single tblrscosalmovemth model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionView($icno) {
//        return $this->render('view', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno]);
//    }
//    
//     public function actionViewuser($icno) {
//        return $this->render('viewuser', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno]);
//    }
    
     public function actionView($icno) {
      $alamat = \app\models\hronline\Tblrscosalmovemth::find()->where(['ICNO' => $icno])->orderBy(['SalMoveMthStDt' => SORT_DESC])->all();
        return $this->render('view', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    
     public function actionViewuser($icno) {
         $alamat = \app\models\hronline\Tblrscosalmovemth::find()->where(['ICNO' => $icno])->orderBy(['SalMoveMthStDt' => SORT_DESC])->all();
        return $this->render('viewuser', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    

    /**
     * Creates a new tblrscosalmovemth model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblrscosalmovemth();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing tblrscosalmovemth model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionTambahPergerakan($icno) {
        $request = Yii::$app->request;
       // $id = $request->get('id');
      
        $model = new Tblrscosalmovemth();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        
      $jenisPergerakan =  ArrayHelper::map(\app\models\hronline\Movemonthtype::find()->all(), 'id', 'name');
      $bulanPergerakan =  ArrayHelper::map(\app\models\hronline\Movemonth::find()->all(), 'id', 'name');
   
      
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('tambah-pergerakan', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd,
            'jenisPergerakan'=>$jenisPergerakan, 'bulanPergerakan' => $bulanPergerakan
        ]);
    }
    public function actionUpdate($id){
    //   $request = Yii::$app->request;
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
      $jenisPergerakan =  ArrayHelper::map(\app\models\hronline\Movemonthtype::find()->all(), 'id', 'name');
      $bulanPergerakan =  ArrayHelper::map(\app\models\hronline\Movemonth::find()->all(), 'id', 'name');
   
      
            if ($model->load(Yii::$app->request->post()) ) {
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
               
           return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,
            'jenisPergerakan'=>$jenisPergerakan, 'bulanPergerakan' => $bulanPergerakan
        ]);
    }

    /**
     * Deletes an existing tblrscosalmovemth model.
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
     * Finds the tblrscosalmovemth model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblrscosalmovemth the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelbyid($id)
    {
        if (($model = Tblrscosalmovemth::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
      protected function findModelbyicno($icno) {
        if (($model = Tblrscosalmovemth::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
