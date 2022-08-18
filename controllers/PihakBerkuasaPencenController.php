<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblrscopsnathy;
use app\models\hronline\tblrscopsnathySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * PihakBerkuasaPencenController implements the CRUD actions for tblrscopsnathy model.
 */
class PihakBerkuasaPencenController extends Controller
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
     * Lists all tblrscopsnathy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new tblrscopsnathySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblrscopsnathy model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//     public function actionView($icno) {
//        return $this->render('view', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno]);
//    }
//    public function actionViewuser($icno) {
//        return $this->render('viewuser', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno]);
//    }
    
         public function actionView($icno) {
         
         $alamat = \app\models\hronline\Tblrscopsnathy::find()->where(['ICNO' => $icno])->andWhere(['!=', 'PsnAthyCd', '0' ])->orderBy(['PsnAthyStDt' => SORT_DESC])->all();
           
        return $this->render('view', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    
     public function actionViewuser($icno) {
         $alamat = \app\models\hronline\Tblrscopsnathy::find()->where(['ICNO' => $icno])->andWhere(['!=', 'PsnAthyCd', '0' ])->orderBy(['PsnAthyStDt' => SORT_DESC])->all();
         
        return $this->render('viewuser', ['alamat' => $alamat, 'ICNO' => $icno]);
    }

    /**
     * Creates a new tblrscopsnathy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblrscopsnathy();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing tblrscopsnathy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTambahBerkuasaPencen($icno) {
        $request = Yii::$app->request;
       // $id = $request->get('id');
      
        $model = new Tblrscopsnathy();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        
      $pihakBerkuasaPencen =  ArrayHelper::map(\app\models\hronline\Pensionauthority::find()->all(), 'PsnAthyCd', 'PsnAthyNm');

      
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
        
        return $this->render('tambah-berkuasa-pencen', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd,
            'pihakBerkuasaPencen'=>$pihakBerkuasaPencen
        ]);
    }
    public function actionUpdate($id) {
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
       
        $pihakBerkuasaPencen =  ArrayHelper::map(\app\models\hronline\Pensionauthority::find()->all(), 'PsnAthyCd', 'PsnAthyNm');

        if ($model->load(Yii::$app->request->post()) ) {
            $model->save(false);
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
               

            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,'pihakBerkuasaPencen' => $pihakBerkuasaPencen
        ]);
    }
    /**
     * Deletes an existing tblrscopsnathy model.
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
     * Finds the tblrscopsnathy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblrscopsnathy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
  
     protected function findModelbyid($id) {
        if (($model = Tblrscopsnathy::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblrscopsnathy::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
