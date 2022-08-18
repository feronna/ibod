<?php

namespace app\controllers;

use Yii;
use app\models\system_core\TblMenuSide;
use app\models\system_core\TblMenuSideChild;
use app\models\system_core\TblMenuSideSearch;
use app\models\system_core\TblMenuTop;
use app\models\system_core\TblMenuTopChild;
use app\models\system_core\TblMenuTopSearch;
use app\models\system_core\TblUserAccess;
use app\models\system_core\TblprcobiodataSearch;
use app\models\system_core\Tblprcobiodata;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\system_core\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * MenuManagerController implements the CRUD actions for TblMenuTop model.
 */
class MenuManagerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
       return [
           'access' => [
               'class' => AccessControl::className(),
               'only' => ['index', 'list-side-menu', 'list-top-menu', 'senarai-action', 'senarai-action-top', 'create', 'create-top', 'update', 'update-top', 'penetapan-akses', 'akses'],
               'rules' => [
                   [
                       'actions' => ['index', 'list-side-menu', 'list-top-menu', 'senarai-action', 'senarai-action-top', 'create', 'create-top', 'update', 'update-top', 'penetapan-akses', 'akses'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                           $tmp = TblUserAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->one();
                           return (is_null($tmp)) ? false : true;
                       }
                   ],
               ],
           ],
           'verbs' => [
               'class' => VerbFilter::className(),
               'actions' => [
                   'logout' => ['post'],
               ],
           ],
       ];
    }

    /**
     * Lists all TblMenuTop models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblMenuSideSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('main', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionListSideMenu()
    {
        $searchModel = new TblMenuSideSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionListTopMenu()
    {
        $searchModel = new TblMenuTopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_top', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblMenuTop model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }
    
    public function actionSenaraiAction($id)
    {
        $query = TblMenuSide::find()->where(['parent_id' => $id]);
        
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
        
        return $this->renderAjax('senarai_action', [
            'dataProvider' => $provider,
        ]);
    }
    
    public function actionSenaraiActionTop($id)
    {
        $query = TblMenuTop::find()->where(['parent_id' => $id]);
        
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
        
        return $this->renderAjax('senarai_action', [
            'dataProvider' => $provider,
        ]);
    }

    /**
     * Creates a new TblMenuTop model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelCustomer = new TblMenuSide(['scenario' => 'create']);
        $modelsAddress = [new TblMenuSideChild];
        
        $list_controllers = Yii::$app->metadata->getControllersActions();
        $temp = [];
        foreach($list_controllers as $n) {
           $temp[$n] = $n;
        }
        
        if ($modelCustomer->load(Yii::$app->request->post())) {

            //$order_list = TblMenuSide::find()->select('order')->where(['parent_id' => null]);
            
            $modelsAddress = Model::createMultiple(TblMenuSideChild::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            
            $max = TblMenuSide::find()->where(['parent_id' => null])->max('tbl_menu_side.order');
            $modelCustomer->order = $max + 1;
            
            // validate all models
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelsAddress as $i => $modelAddress) {
                            $modelAddress->parent_id = $modelCustomer->id;
                            $modelAddress->order = $i;
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['list-side-menu']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblMenuSideChild] : $modelsAddress,
            'list_controllers' => $temp,
        ]);
    }
    
    public function actionCreateTop()
    {
        $modelCustomer = new TblMenuTop();
        $modelsAddress = [new TblMenuTopChild];
        
        $list_controllers = Yii::$app->metadata->getControllersActions();
        $temp = [];
        foreach($list_controllers as $n) {
           $temp[$n] = $n;
        }
        
        if ($modelCustomer->load(Yii::$app->request->post())) {

            //$order_list = TblMenuSide::find()->select('order')->where(['parent_id' => null]);
            
            $modelsAddress = Model::createMultiple(TblMenuTopChild::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());

            $modelCustomer->order = null;
            
            // validate all models
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelsAddress as $i => $modelAddress) {
                            $modelAddress->parent_id = $modelCustomer->id;
                            $modelAddress->order = $i;
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['list-top-menu']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblMenuTopChild] : $modelsAddress,
            'list_controllers' => $temp,
        ]);
    }

    /**
     * Updates an existing TblMenuTop model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $modelCustomer = $this->findModel($id);
        $modelsAddress = $modelCustomer->child;

        $list_controllers = Yii::$app->metadata->getControllersActions();
        $temp = [];
        foreach($list_controllers as $n) {
           $temp[$n] = $n;
        }
        
        if ($modelCustomer->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsAddress, 'id', 'id');
            $modelsAddress = Model::createMultiple(TblMenuSideChild::classname(), $modelsAddress);
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsAddress, 'id', 'id')));

            // ajax validation
//            if (Yii::$app->request->isAjax) {
//                Yii::$app->response->format = Response::FORMAT_JSON;
//                return ArrayHelper::merge(
//                    ActiveForm::validateMultiple($modelsAddress),
//                    ActiveForm::validate($modelCustomer)
//                );
//            }

            // validate all models
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        if (! empty($deletedIDs)) {
                            TblMenuSideChild::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsAddress as $i => $modelAddress) {
                            //$modelAddress->customer_id = $modelCustomer->id;
                            $modelAddress->order = $i;
                            $modelAddress->parent_id = $modelCustomer->id;
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['list-side-menu']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblMenuSideChild] : $modelsAddress,
            'list_controllers' => $temp,
        ]);
    }

    public function actionUpdateTop($id)
    {
        $modelCustomer = $this->findModelTop($id);
        $modelsAddress = $modelCustomer->child;

        $list_controllers = Yii::$app->metadata->getControllersActions();
        $temp = [];
        foreach($list_controllers as $n) {
           $temp[$n] = $n;
        }
        
        if ($modelCustomer->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsAddress, 'id', 'id');
            $modelsAddress = Model::createMultiple(TblMenuTopChild::classname(), $modelsAddress);
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsAddress, 'id', 'id')));

            // ajax validation
//            if (Yii::$app->request->isAjax) {
//                Yii::$app->response->format = Response::FORMAT_JSON;
//                return ArrayHelper::merge(
//                    ActiveForm::validateMultiple($modelsAddress),
//                    ActiveForm::validate($modelCustomer)
//                );
//            }

            // validate all models
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        if (! empty($deletedIDs)) {
                            TblMenuTopChild::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsAddress as $modelAddress) {
                            //$modelAddress->customer_id = $modelCustomer->id;
                            $modelAddress->parent_id = $modelCustomer->id;
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['list-top-menu']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblMenuTopChild] : $modelsAddress,
            'list_controllers' => $temp,
        ]);
    }
    
    /**
     * Deletes an existing TblMenuTop model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        TblMenuSide::deleteAll(['parent_id' => $id]);

        return $this->redirect(['list-side-menu']);
    }
    
    public function actionDeleteTop($id)
    {
        $this->findModel($id)->delete();
        TblMenuTop::deleteAll(['parent_id' => $id]);

        return $this->redirect(['list-top-menu']);
    }
    
    public function actionPenetapanAkses() {
        $searchModel = new TblprcobiodataSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('akses_tetap', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionAkses($ICNO) {
        //$id = Yii::$app->user->getId(); 
        $bio = Tblprcobiodata::findOne(['ICNO' => $ICNO]);
        
        if(TblUserAccess::findOne(['icno' => $ICNO]) != null) {
            $model = TblUserAccess::findOne(['icno' => $ICNO]);
        }else {
            $model = new TblUserAccess();
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $ICNO;
            if($model->access == 0) {
                $model->delete();
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Akses berjaya disimpan!']);
                return $this->redirect('penetapan-akses');
            }else {
                $model->save();
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Akses berjaya disimpan!']);
                return $this->redirect('penetapan-akses');
            }
            //$model->akses_oleh = $id;
        }
        
        return $this->renderAjax('kemaskini_akses', ['bio' => $bio, 'model' => $model]);
    }
    
    public function actionSortSideParent(){
        
        $model = new TblMenuSide();
        
        $models = TblMenuSide::findAll(['parent_id' => null]);
        
        if ($model->load(Yii::$app->request->post())) {
            
            $items = [];
            
            $items = explode(",",$model->parent_order);
            
            $transaction = \Yii::$app->db->beginTransaction();
            
            try{
                foreach($items as $i => $tmp){
                    $model2 = TblMenuSide::findOne(['id' => $tmp, 'parent_id' => null]);
                    $model2->order = $i;
                    if (! ($flag = $model2->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Urutan berjaya dikemaskini!']);
                    return $this->redirect('sort-side-parent');
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
            
        }
        
        return $this->render('sort_side_parent', [
            'model' => $model,
            'models' => $models,
        ]);
    }
    
    public function actionSortSideChild($parent_id){
        $model = new TblMenuSide();
        
        $models = TblMenuSide::find()->where(['parent_id' => $parent_id])->orderBy(['order' => SORT_ASC])->all();
        
        if ($model->load(Yii::$app->request->post())) {
            
            $items = [];
            
            $items = explode(",",$model->parent_order);
            
            $transaction = \Yii::$app->db->beginTransaction();
            
            try{
                foreach($items as $i => $tmp){
                    $model2 = TblMenuSide::findOne(['id' => $tmp, 'parent_id' => $parent_id]);
                    $model2->order = $i;
                    if (! ($flag = $model2->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Urutan berjaya dikemaskini!']);
                    return $this->redirect('list-side-menu');
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
            
        }
        
//        return $this->render('sort_side_parent', [
//            'model' => $model,
//            'models' => $models,
//        ]);
        
        return $this->renderAjax('sort_side_child', [
            'model' => $model,
            'models' => $models,    
        ]);
    }
    
    public function actionSortTopChild($parent_id){
        $model = new TblMenuTop();
        
        $models = TblMenuTop::find()->where(['parent_id' => $parent_id])->orderBy(['order' => SORT_ASC])->all();
        
        if ($model->load(Yii::$app->request->post())) {
            
            $items = [];
            
            $items = explode(",",$model->parent_order);
            
            $transaction = \Yii::$app->db->beginTransaction();
            
            try{
                foreach($items as $i => $tmp){
                    $model2 = TblMenuTop::findOne(['id' => $tmp, 'parent_id' => $parent_id]);
                    $model2->order = $i;
                    if (! ($flag = $model2->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Urutan berjaya dikemaskini!']);
                    return $this->redirect('list-side-menu');
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
            
        }
        
//        return $this->render('sort_side_parent', [
//            'model' => $model,
//            'models' => $models,
//        ]);
        
        return $this->renderAjax('sort_side_child', [
            'model' => $model,
            'models' => $models,    
        ]);
    }

    /**
     * Finds the TblMenuTop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblMenuTop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblMenuSide::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findModelTop($id)
    {
        if (($model = TblMenuTop::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
}
