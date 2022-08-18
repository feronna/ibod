<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblrscoservtype;
use app\models\hronline\tblrscoservtypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * JenisPerkhidmatanController implements the CRUD actions for tblrscoservtype model.
 */
class JenisPerkhidmatanController extends Controller
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
     * Lists all tblrscoservtype models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new tblrscoservtypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblrscoservtype model.
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
     * Creates a new tblrscoservtype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblrscoservtype();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing tblrscoservtype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
        public function actionTambahPerkhidmatan($icno) {
        $model = new Tblrscoservtype();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
      $jenisPerkhidmatan =  ArrayHelper::map(\app\models\hronline\Servicetype::find()->all(), 'ServTypeCd', 'ServTypeNm');

      
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('tambah-perkhidmatan', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd,
            'jenisPerkhidmatan'=>$jenisPerkhidmatan
        ]);
    }
      public function actionUpdate($id) {
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        $jenisPerkhidmatan =  ArrayHelper::map(\app\models\hronline\Servicetype::find()->all(), 'ServTypeCd', 'ServTypeNm');

      
        if ($model->load(Yii::$app->request->post()) ) {
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
                             

            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd, 'jenisPerkhidmatan'=>$jenisPerkhidmatan
        ]);
    }

    /**
     * Deletes an existing tblrscoservtype model.
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
     * Finds the tblrscoservtype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblrscoservtype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
      protected function findModelbyid($id) {
        if (($model = Tblrscoservtype::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblrscoservtype::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
