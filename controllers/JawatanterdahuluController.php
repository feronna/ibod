<?php

namespace app\controllers;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tbljawatanterdahulu;
use app\models\hronline\TbljawatanterdahuluSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * JawatanterdahuluController implements the CRUD actions for Tbljawatanterdahulu model.
 */
class JawatanterdahuluController extends Controller
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
                'only' => ['adminlihatjawatanterdahulu','admintambahjawatanterdahulu','adminupdate','adminview','admindelete','lihatjawatanterdahulu','tambahjawatanterdahulu','update','view','delete'],
                'rules' => [
                    [
                        'actions' => ['admintambahjawatanterdahulu','admintambahjawatanterdahulu','adminupdate','adminview','admindelete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                           $access = Yii::$app->user->identity->accessLevel;
                          
                           return $access === 1;  
                        }
                    ],
                    [
                        'actions' => ['lihatjawatanterdahulu', 'update','delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $check = Tbljawatanterdahulu::findAll(['id' => $id, 'ICNO' => $logicno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['view','tambahjawatanterdahulu'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Tbljawatanterdahulu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TbljawatanterdahuluSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tbljawatanterdahulu model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $icno = Yii::$app->user->getId();
        return $this->render('view', [
            'jawatanterdahulu' => Tbljawatanterdahulu::findAll(['ICNO' => $icno]),
        ]);
    }
    public function actionAdminview($icno)
    {
        if($this->findModel($icno)){
           return $this->render('adminview', [
            'jawatanterdahulu' => Tbljawatanterdahulu::findAll(['ICNO' => $icno]), 
            'ICNO' => $icno,
        ]); 
        }
        
    }
    
    public function actionLihatjawatanterdahulu($id)
    {
        return $this->render('lihatjawatanterdahulu', [
            'model' => $this->findModelbyid($id),  
        ]);
    }
    public function actionAdminlihatjawatanterdahulu($id)
    {
        return $this->render('adminlihatjawatanterdahulu', [
            'model' => $this->findModelbyid($id),  
        ]);
    }

    /**
     * Creates a new Tbljawatanterdahulu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionTambahjawatanterdahulu()
    {
        $icno = Yii::$app->user->getId();
        $model = new Tbljawatanterdahulu();

        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            if($model->save()){
                return $this->redirect(['view']);
            }   
        }
        return $this->render('tambahjawatanterdahulu', [
            'model' => $model,
        ]);
    }
    public function actionAdmintambahjawatanterdahulu($icno)
    {
        $model = new Tbljawatanterdahulu();

        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            if($model->save()){
                return $this->redirect(['adminview', 'icno' => $model->ICNO]);
            }   
        }
        if($this->findModel($icno)){
            return $this->render('tambahjawatanterdahulu', [
            'model' => $model,
        ]);
        }
        
    }

    /**
     * Updates an existing Tbljawatanterdahulu model.
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
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tbljawatanterdahulu model.
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
     * Finds the Tbljawatanterdahulu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tbljawatanterdahulu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    protected function findModelbyid($id)
    {
        if (($model = Tbljawatanterdahulu::findOne(['id' => $id])) !== null) {
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
