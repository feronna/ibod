<?php

namespace app\controllers;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblsejarahperubatan;
use app\models\hronline\TblsejarahperubatanSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SejarahperubatanController implements the CRUD actions for Tblsejarahperubatan model.
 */
class SejarahperubatanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['adminlihatsejarahperubatan','admintambahsejarahperubatan','adminupdate','adminview', 'admindelete',
                           'lihatsejarahperubatan','tambahsejarahperubatan','update','view', 'delete'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id)
                    ,
                    [
                        'actions' => ['adminlihatsejarahperubatan','admintambahsejarahperubatan','adminupdate','adminview', 'admindelete',],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                           $access = Yii::$app->user->identity->accessLevel;
                           $secondaccess = Yii::$app->user->identity->accessSecondLevel;
                           switch ($access) {
                                case '1':
                                      return true;
                                    break;
                                case '2':
                                   
                                    if(in_array($secondaccess,['1','3'])){
                                        return true;
                                    }
                                    if(in_array($secondaccess,['4','5','6'])){
                                        return true;
                                    }
                                        return false;
                                    break;
                                case '3':
                                    if (in_array($secondaccess, ['7', '8', '9'])) {
                                        return true;
                                    }
                                    return false;
                                    break;
                                
                                default:
                                    return false;
                                    break;
                            }  
                        }
                    ],
                    [
                        'actions' => ['lihatsejarahperubatan','update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $icno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $check = Tblsejarahperubatan::findAll(['id' => $id, 'ICNO' => $icno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['view', 'tambahsejarahperubatan'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Tblsejarahperubatan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblsejarahperubatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tblsejarahperubatan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $icno = Yii::$app->user->getId();
        return $this->render('view', [
            'sejarahperubatan' => Tblsejarahperubatan::findAll(['ICNO' => $icno]),
        ]);
    }
    public function actionAdminview($icno)
    {
        if($this->findModel($icno)){
           return $this->render('adminview', [
            'sejarahperubatan' => Tblsejarahperubatan::findAll(['ICNO' => $icno]), 'ICNO' => $icno,
        ]); 
        }
        
    }
    
    public function actionLihatsejarahperubatan($id)
    {
        return $this->render('lihatsejarahperubatan', [
            'model' => $this->findModelbyid($id),  
        ]);
    }
    public function actionAdminlihatsejarahperubatan($id)
    {
        return $this->render('adminlihatsejarahperubatan', [
            'model' => $this->findModelbyid($id),  
        ]);
    }

    /**
     * Creates a new Tblsejarahperubatan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionTambahsejarahperubatan()
    {
        $icno = Yii::$app->user->getId();
        $model = new Tblsejarahperubatan();

        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            if($model->save()){
                return $this->redirect(['view']);
            }  
        }
        return $this->render('tambahsejarahperubatan', [
            'model' => $model,
        ]);
    }
    public function actionAdmintambahsejarahperubatan($icno)
    {
        $model = new Tblsejarahperubatan();
        $model->ICNO = $icno;
        
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return $this->redirect(['adminview', 'icno' => $model->ICNO]);
            }
        }

        if($this->findModel($icno)){
            return $this->render('tambahsejarahperubatan', [
            'model' => $model,
        ]);
        }
        
    }

    /**
     * Updates an existing Tblsejarahperubatan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModelbyid($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view']);
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionAdminupdate($id)
    {
        $model = $this->findModelbyid($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['adminview', 'icno' => $model->ICNO]);
        }
      
        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing Tblsejarahperubatan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModelbyid($id);
        $model->delete();

        return $this->redirect(['view']);
    }
    public function actionAdmindelete($id)
    {
        $model = $this->findModelbyid($id);
        $model->delete();

        return $this->redirect(['adminview', 'icno' => $model->ICNO]);
    }

    /**
     * Finds the Tblsejarahperubatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tblsejarahperubatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    protected function findModelbyid($id)
    {
        if (($model = Tblsejarahperubatan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findModel($id) {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
