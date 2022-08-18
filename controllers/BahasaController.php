<?php

namespace app\controllers;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblbahasa;
use app\models\hronline\TblbahasaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * BahasaController implements the CRUD actions for Tblbahasa model.
 */
class BahasaController extends Controller
{
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
                'only' => ['index','view', 'adminview', 'lihatbahasa', 'adminlihatbahasa', 'tambahbahasa', 'admintambahbahasa',
                           'update', 'adminupdate', 'delete', 'admindelete'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id)
                    ,
                    [
                        'actions' => ['index', 'adminview', 'adminlihatbahasa', 'admintambahbahasa', 'adminupdate', 'admindelete'],
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
                        'actions' => ['lihatbahasa', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $icno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $check = Tblbahasa::findAll(['id' => $id, 'ICNO' => $icno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['view', 'tambahbahasa'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new TblbahasaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView(){
        $icno = Yii::$app->user->getId();
        return $this->render('view', ['bahasa' => Tblbahasa::findAll(['ICNO' => $icno])
        ]);
    }
    
    public function actionAdminview($icno){
        if($this->findModel($icno)){
            return $this->render('adminview', ['bahasa' => Tblbahasa::findAll(['ICNO' => $icno]),'ICNO' => $icno]);
        }
        
    }
    
    public function actionLihatbahasa($id){
        return $this->render('lihatbahasa', [
            'model' => $this->findModelbyid($id),  
        ]);
    }
    
    public function actionAdminlihatbahasa($id){
        return $this->render('adminlihatbahasa', [
            'model' => $this->findModelbyid($id),  
        ]);
    }

   
    public function actionTambahbahasa()
    {
        $icno = Yii::$app->user->getId();
        $model = new Tblbahasa();
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
           if($model->save()){
               return $this->redirect(['view']);
           }     
        }

        return $this->render('tambahbahasa', [
            'model' => $model,
        ]);
    }
    
    public function actionAdmintambahbahasa($icno)
    {
        $model = new Tblbahasa();
        $model->ICNO = $icno;
        if ($model->load(Yii::$app->request->post())) {
           if($model->save()){
               return $this->redirect(['adminview', 'icno' => $model->ICNO]);
           }            
        }
       if($this->findModel($icno)){
           return $this->render('admintambahbahasa', [
            'model' => $model,
        ]);
       }
        
    }

    
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
        return $this->render('adminupdate', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModelbyid($id);
        $this->findModelbyid($id)->delete();

        return $this->redirect(['view']);
    }
    
    public function actionAdmindelete($id)
    {
        $model = $this->findModelbyid($id);
        $this->findModelbyid($id)->delete();

        return $this->redirect(['adminview', 'icno' => $model->ICNO]);
    }

    /**
     * Finds the Tblbahasa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tblbahasa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    
    protected function findModelbyid($id)
    {
        if (($model = Tblbahasa::findOne(['id' => $id])) !== null) {
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