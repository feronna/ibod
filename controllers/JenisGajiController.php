<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblrscosaltype;
use app\models\hronline\tblrscosaltypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * JenisGajiController implements the CRUD actions for tblrscosaltype model.
 */
class JenisGajiController extends Controller
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
     * Lists all tblrscosaltype models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new tblrscosaltypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblrscosaltype model.
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
     * Creates a new tblrscosaltype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblrscosaltype();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing tblrscosaltype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
         public function actionTambahGaji($icno) {
        $model = new Tblrscosaltype();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
      $jenisGaji=  ArrayHelper::map(\app\models\hronline\Salarytype::find()->all(), 'SalTypeCd', 'SalTypeNm');
      $statusGaji =  ArrayHelper::map(\app\models\hronline\Salarystatus::find()->all(), 'id', 'name');
      
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('tambah-gaji', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd,
            'jenisGaji'=>$jenisGaji, 'statusGaji'=> $statusGaji
        ]);
    }
    public function actionUpdate($id) {
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
       $jenisGaji=  ArrayHelper::map(\app\models\hronline\Salarytype::find()->all(), 'SalTypeCd', 'SalTypeNm');
       $statusGaji =  ArrayHelper::map(\app\models\hronline\Salarystatus::find()->all(), 'id', 'name');
      

        if ($model->load(Yii::$app->request->post()) ) {
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
               

            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,    'jenisGaji'=>$jenisGaji, 'statusGaji'=> $statusGaji
        ]);
    }

    /**
     * Deletes an existing tblrscosaltype model.
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
     * Finds the tblrscosaltype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblrscosaltype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
 
      protected function findModelbyid($id) {
        if (($model = Tblrscosaltype::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblrscosaltype::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
