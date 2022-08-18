<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblrscoservload;
use app\models\hronline\tblrscoservloadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\hronline\Serviceloading;

/**
 * BebanPerkhidmatanController implements the CRUD actions for tblrscoservload model.
 */
class BebanPerkhidmatanController extends Controller
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
     * Lists all tblrscoservload models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new tblrscoservloadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblrscoservload model.
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
     * Creates a new tblrscoservload model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblrscoservload();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
         
     public function actionTambahBeban($icno) {
        $bebanPerkhidmatan =  ArrayHelper::map(Serviceloading::find()->all(), 'ServLoadCd', 'ServLoadNm');
       
        $model = new Tblrscoservload();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('tambah-beban', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd,'bebanPerkhidmatan' => $bebanPerkhidmatan

        ]);
    }

    /**
     * Updates an existing tblrscoservload model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
      public function actionUpdate($id) {
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
       $bebanPerkhidmatan =  ArrayHelper::map(Serviceloading::find()->all(), 'ServLoadCd', 'ServLoadNm');
        if ($model->load(Yii::$app->request->post()) ) {

            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,'bebanPerkhidmatan' => $bebanPerkhidmatan
        ]);
    }

    /**
     * Deletes an existing tblrscoservload model.
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
     * Finds the tblrscoservload model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblrscoservload the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
   
       protected function findModelbyid($id) {
        if (($model = Tblrscoservload::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblrscoservload::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
