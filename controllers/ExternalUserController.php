<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\system_core\ExternalUserSearch;
use app\models\cbelajar\TblAccess;
class ExternalUserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
     public function actionSignup()
    {
        $model = new \app\models\system_core\ExternalUserSearch();
  
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
 
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    public function actionRegisterExternalUser() 
    {
//        $admin = \app\models\hronline\Tblprcobiodata::find()->All();
//        $permohonan = new TblPermohonan();
//        $pengajian = new \app\models\cbelajar\TblPenyelia();
//        $model = Tblprcobiodata::findOne(['ICNO'=>$icno]);
//        $lkk = new \app\models\cbelajar\TblLkk();
//        $list_controllers = Yii::$app->metadata->getControllersActions();
//        $temp = [];
        $external = new \app\models\system_core\ExternalUser();
        $akses = new TblAccess();
//        $ums = sprintf("%05s", ($external->user_id + 1));

        if ($external->load(Yii::$app->request->post())) 
        {
//              $pengajian->staff_icno; 

            
            $external->save(false);
            $external->user_id = "UMSUSER". str_pad($external->id, 3, "0", STR_PAD_LEFT);
            $external->access = 1;
            $external->pwsd = hash("sha256",$external->username);
            $akses->icno = $external->user_id;
            $akses->level = 99;
            $external->save(false);
            $akses->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['senarai-akses']);
        
        }
        $list_controllers = Yii::$app->metadata->getControllersActions();
        $temp = [];

        foreach ($list_controllers as $n) {
            $temp[$n] = $n;
        }

        return $this->render('tambah_akses', ['external'=> $external,'list_controllers' => $temp]);
    }

    
public function actionSenaraiAkses()
    {
         
        $searchModel = new \app\models\system_core\ExternalUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
   isset(Yii::$app->request->queryParams['name'])? $dataProvider->query->andFilterWhere
        (['like', 'name',  Yii::$app->request->queryParams['name'] ]):'';
        return $this->render('senarai_akses', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    protected function findModel2($id){
        
        if (($model = \app\models\system_core\ExternalUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionUpdate($id){
         
                
            
              $model=$this->findModel2($id);
         

              if ($model->load(Yii::$app->request->post())) {
            
                
                
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record succesfully updated']);
            return $this->redirect(['senarai-akses']);
              }
        
            return $this->renderAjax('update-akses', [
                'model' => $model,
               
             
            ]); 
    }
}
