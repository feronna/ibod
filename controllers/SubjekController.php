<?php

namespace app\controllers;

use yii\filters\AccessControl;

use Yii;
use app\models\hronline\Tblsubjek;
use app\models\hronline\TblsubjekSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\Tblbidangkepakaran;


use app\models\hronline\Tblpendidikan;

/**
 * SubjekController implements the CRUD actions for Tblsubjek model.
 */
class SubjekController extends Controller
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
                'only' => ['index','tambahmatapelajaran','update','view'],
                'rules' => [
                    [
                        'actions' => ['index','tambahmatapelajaran','view'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                           $icno = Yii::$app->request->get('icno');
                           $logicno = Yii::$app->user->getId();
                           $access = Yii::$app->user->identity->accessLevel;
                          
                           return $logicno === $icno || $access === 1;  
                        }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $check = Tblbidangkepakaran::findAll(['id' => $id, 'ICNO' => $logicno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Tblsubjek models.
     * @return mixed
     */
    public function actionIndex($EduAch_id, $ICNO, $EduCd)
    {   
        $level = "Tiada Data";
        $subjek = Tblsubjek::findAll(['EduAch_id'=>$EduAch_id]);
        if($EduCd == 14){
            $level = "SPM & Setaraf";
        }
        elseif($EduCd == 15){
           $level = "PMR";
        }
        elseif($EduCd == 13){
           $level = "STPM & Setaraf";
        }
              

        return $this->render('index', [
            'subjek' => $subjek,
            'level' => $level,
            'ICNO' => $ICNO,
            'EduAch_id' => $EduAch_id,
            'EduCd' => $EduCd,
        ]);
    }

    /**
     * Displays a single Tblsubjek model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($EduAch_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($EduAch_id),
        ]);
    }
    
   

    /**
     * Creates a new Tblsubjek model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionTambahmatapelajaran($EduAch_id, $ICNO, $EduCd, $level)
    {
        $model = new Tblsubjek();

        if ($model->load(Yii::$app->request->post()) ) {
            
                $model->EduAch_id = $EduAch_id;
                if($model->save()){
                    return $this->redirect(['index', 'EduAch_id' => $EduAch_id, 'ICNO'=>$ICNO, 'EduCd'=>$EduCd]);
                }  
        }

        return $this->render('create', [
            'model' => $model,
            'EduAch_id' => $EduAch_id,
            'ICNO'=>$ICNO,
            'EduCd'=>$EduCd,
            'level'=>$level
        ]);
    }

    /**
     * Updates an existing Tblsubjek model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $ICNO, $EduCd, $level)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            return $this->redirect(['index', 'EduAch_id' => $model->EduAch_id, 'ICNO'=>$ICNO, 'EduCd'=>$EduCd, 'level'=>$level]);
        }

        return $this->render('update', [
            'model' => $model,
            'ICNO'=>$ICNO,
            'EduCd'=>$EduCd,
            'level'=>$level,
        ]);
    }

    /**
     * Deletes an existing Tblsubjek model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $ICNO, $EduCd)
    {
        $model = $this->findModel($id);
        $Temp_EduAch_id = $model->EduAch_id;
        $model->delete();

        return $this->redirect(['index', 'EduAch_id' => $Temp_EduAch_id, 'ICNO'=>$ICNO, 'EduCd'=>$EduCd]);
    }
    
    public function actionDeletefrompendidikan($EduAch_id,$icno) {
        Tblsubjek::deleteAll(['EduAch_id'=>$EduAch_id]);
        
        return $this->redirect(['pendidikan/view', 'icno' => $icno]);
    }

    /**
     * Finds the Tblsubjek model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tblsubjek the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tblsubjek::findOne(['id'=>$id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
