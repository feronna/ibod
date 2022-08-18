<?php

namespace app\controllers;

use Yii;
use app\models\msiso\TblClause;
use app\models\msiso\ClauseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\msiso\TblAccess;
use yii\data\ActiveDataProvider;
use app\models\msiso\Model;
use app\models\msiso\TblClauseChild;
/**
 * ClauseController implements the CRUD actions for TblClause model.
 */
class ClauseController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    //Penyelia BPQ, pentadbir sistem
                    'tambah-klausa', 'senarai-klausa', 
                ],
                'rules' => [
                      
                    [//penyelia BPQ, pentadbir sitem
                        'actions' => ['tambah-klausa', 'senarai-klausa'],
                        'allow' => true,
                        'matchCallback' => function () {
                    $tmp = TblAccess::findOne(['icno' => Yii::$app->user->getId(), 'access_level' => [2,99]]);
                    return (is_null($tmp)) ? false : true;
                }
                    ],
                        
                ],
            ],
        ];
    } 
 
    public function actionIndex()
    {
        $searchModel = new ClauseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['senarai-klausa']);
    }
 
    protected function findModel($id)
    {
        if (($model = TblClause::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionTambahKlausa()
    { 
        $model = new TblClause();
        $mod = TblClause::findOne($model->id);
        $icno = Yii::$app->user->getId();
        $clause = TblClause::find()->where(['status' => 1]) ->orderBy(['clause_order' => SORT_ASC])->all();
        // $clauseOrder = TblClause::find()->where(['status' => 1, ])->andwhere(['IS NOT', 'parent_clause', null])->orderBy(['clause_order' => SORT_ASC])->all(); 
        $clauseOrder = TblClause::find()->where(['status' => 1,  ])->andwhere(['IS NOT', 'parent_clause', null])->groupBy(['parent_clause'])->orderBy(['clause_order' => SORT_ASC])->all(); 
        // $clauseOrder = TblClause::find()->where(['status' => 1,  ])->andwhere(['parent_id' => $model->id]) ->orderBy(['clause_order' => SORT_ASC])->one(); 
        // $clause =  TblClause::find()->where(['status' => 1])->orderBy(['clause' => SORT_ASC]); 
        $query = TblClause::find()->where(['status' => 1])->andwhere(['parent_clause'=> null])->orderBy(['clause' => SORT_ASC]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 

        // dynamic controller  code 
        $modelCustomer = new TblClause(); //customer      
        $modelsAddress = [new TblClauseChild()]; //address    
        
        if ($modelCustomer->load(Yii::$app->request->post())) {  
          
            $modelsAddress = Model::createMultiple(TblClauseChild::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
  
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                    ActiveForm::validate($modelCustomer)
                );
            } 
            // validate all models
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid; 
            
            $modelCustomer->status = 1;
            $modelCustomer->created_dt =  date('Y-m-d');
            $modelCustomer->created_by = $icno; 
            $modelCustomer->clause_order = $modelCustomer->clause;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelsAddress as $modelAddress) {   

                        $modelAddress->parent_id = $modelCustomer->id; 
                        $modelAddress->parent_clause = $modelAddress->clause_order;  
                        $modelAddress->created_dt =  date('Y-m-d');
                        $modelAddress->created_by = $icno;
                        $modelAddress->status = '1'; 
                        
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break; 
                            }  
                        }
                    } 
                  
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' =>  'Berjaya disimpan.']);
                    if ($flag) {
                        $transaction->commit();
                       
                        return $this->redirect(['clause/tambah-klausa']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            } 
            $model->save(false);
            $modelCustomer->save(false); 
        } 

        return $this->render('tambah_klausa', [
            'model' => $model,
            'modelCustomer' => $modelCustomer, 
            'modelsAddress' => (empty($modelsAddress)) ? [new Refnotifyaudit] : $modelsAddress,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'clause' => $clause,
            'clauseOrder' => $clauseOrder,
        ]);
      
    }  

    public function actionSenaraiKlausa()
    { 
        $model = new TblClause();
        $icno = Yii::$app->user->getId();
        $clause = TblClause::find()->where(['status' => 1]) ->orderBy(['id' => SORT_ASC])->all();
      
        $query = TblClause::find()->where(['status' => 1])->orderBy(['clause' => SORT_ASC]); 
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
        
        
        return $this->render('senarai_klausa', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'clause' => $clause,
            'bil' => 1,
        ]);
      
    }  

    public function actionKemaskiniKlausa($id)
    { 
        $icno = Yii::$app->user->getId(); 
 
        $model = $this->findModel($id);
        $query = TblClause::find()->where(['id' => $id])->one(); 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
     

        if ($model->load(Yii::$app->request->post())) {

            $parent = TblClause::find()->where(['id' => $id])->one();
            if($parent->parent_clause != NULL){

                $parent->parent_clause = $model->clause_order; 
                $parent->save(false);
            }elseif($parent->parent_clause == NULL){
                $parent->clause = $model->clause_order; 
                $parent->save(false);
            }
           
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['clause/senarai-klausa']);
        }

        return $this->render('update_tambah_klausa', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
        
    } 
}
