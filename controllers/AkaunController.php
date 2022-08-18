<?php

namespace app\controllers;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblakaun;
use app\models\hronline\TblakaunSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\hronline\CawanganAkaun;
use yii\helpers\Json;
use yii\web\UploadedFile;


/**
 * AkaunController implements the CRUD actions for Tblakaun model.
 */
class AkaunController extends Controller {

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
                'only' => ['view', 'adminview', 'lihatakaun', 'adminlihatlesen', 'tambahlesen', 'admintambahlesen', 'update', 'adminupdate',
                           'delete', 'admindelete', 'deletegambar', 'admindeletegambar'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),
                    [
                        'actions' => ['adminview', 'adminlihatlesen', 'admintambahlesen', 'adminupdate', 'admindelete', 'admindeletegambar'],
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
                        'actions' => ['lihatakaun', 'update', 'delete', 'deletegambar'],
                        'allow' => true,
                        'roles' => ['@'],  
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $check = Tblakaun::findAll(['id' => $id, 'ICNO' => $logicno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }
                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['view', 'tambahlesen'],
                        'allow' => true,
                        'roles' => ['@'],  
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Tblakaun models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TblakaunSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView() {
        $icno = Yii::$app->user->getId();
        return $this->render('view', [
                    'akaun' => Tblakaun::findAll(['ICNO' => $icno])
        ]);
    }
    public function actionAdminview($icno){
        if($this->findModel($icno)){
          return $this->render('adminview', [
               'akaun' => Tblakaun::findAll(['ICNO' => $icno]), 'ICNO' => $icno,
        ]);  
        }   
    }

    public function actionLihatakaun($id) {
        return $this->render('lihatakaun', [
                    'model' => $this->findModelbyid($id) ,
        ]);
    }
    public function actionAdminlihatakaun($id) {
        return $this->render('adminlihatakaun', [
                    'model' => $this->findModelbyid($id),
        ]);
    }

    public function actionTambahakaun() {
        $icno = Yii::$app->user->getId();
        $model = new Tblakaun();
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->updateDt = date('Y-m-d');
            if ($model->file) {
                if ($model->save()) { 
                    $id = $model->id;
                   $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/akaun');
                    
                    if ($datas->status == true) {
                        $model->filename = $datas->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['view']);
                    }
                    else{

                       Tblakaun::deleteAll(['id'=>$id]);
                       Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                       return $this->redirect(['view']);
                    }                   
                }
            }else{
               Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik dokumen berkaitan!']); 
            }    
        }

        return $this->render('tambahakaun', [
                    'model' => $model,
        ]);
    }
    
    public function actionAdmintambahakaun($icno) {
        $model = new Tblakaun();
        $model->ICNO = $icno;
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->updateDt = date('Y-m-d');
            if ($model->file) {
                if ($model->save()) { 
                    $id = $model->id;
                   $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/akaun');

                    if ($datas->status == true) {
                        $model->filename = $datas->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['adminview','icno'=>$icno]);
                    }
                    else{

                       Tblakaun::deleteAll(['id'=>$id]);
                       Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                       return $this->redirect(['adminview','icno'=>$icno]);
                    }                   
                }
            }else{
               Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik dokumen berkaitan!']); 
            }    
        }
        if($this->findModel($icno)){
           return $this->render('admintambahakaun', [
                    'model' => $model,
        ]); 
        }
        
    }

    ///update function
    public function actionUpdate($id) {
        $model = $this->findModelbyid($id);
        $icno = Yii::$app->user->getId();
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()){
                $model->file = UploadedFile::getInstance($model, 'file');
                $model->updateDt = date('Y-m-d');
                $id = $model->id;
                if(empty($model->file) && empty($model->filename)){
                    Yii::$app->session->setFlash('Gagal', "Sila muatnaik dokumen berkaitan!");
                    return $this->render('update', ['model' => $model,]);
                }elseif(!empty($model->file)){
                    $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/akaun');   
                    if ($datas->status == true){
                            $model->filename = $datas->file_name_hashcode;
                            $model->save();
                            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        }else{
                            Yii::$app->session->setFlash('alert', ['title' => 'Upload Failed. URL '.$datas->message, 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!.']);
                        }
                        return $this->redirect(['view']);
                }
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    return $this->redirect(['view']);
            }

        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionAdminupdate($id) {
        $model = $this->findModelbyid($id);
        $icno = $model->ICNO;
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->updateDt = date('Y-m-d');
            
            if ($model->file) {
                if ($model->save()){
                   $id = $model->id;                
                   $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/akaun');
                    if($datas->status == true){
                        $model->filename = $datas->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['adminview','icno'=>$icno]);
                    }
                    else{
                       Yii::$app->session->setFlash('alert', ['title' => 'Upload Failed. URL '.$datas->message, 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                       return $this->redirect(['adminview','icno'=>$icno]);
                    }
                }
            }elseif (!empty($model->filename) && $model->filename != 'deleted') {
                if ($model->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['adminview','icno'=>$icno]);
                }
            }
            else {
               Yii::$app->session->setFlash('Gagal', "Sila muatnaik dokumen berkaitan!");
            }
        }

        return $this->render('adminupdate', [
                    'model' => $model,
        ]);
    }

//    public function actionDelete($id) {
//        $model = $this->findModelbyid($id);
//        if ($model->delete()) {
//            if (!empty($model->filename) && $model->filename != 'deleted') {
//                $res = Yii::$app->FileManager->DeleteFile($model->filename);
//                if ($res->status == true) {
//                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang']);
//                }else{
//                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang, File tidak berjaya dipadam!']);
//                }
//                
//            }
//        }else{
//            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat tidak berjaya Dibuang']);
//        }        
//        return $this->redirect(['view']);
//    }
    
    public function actionAdmindelete($id) {
        $model = $this->findModelbyid($id);
        if ($model->delete()) {
            if (!empty($model->filename) && $model->filename != 'deleted') {
                $res = Yii::$app->FileManager->DeleteFile($model->filename);
                if ($res->status == true) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang']);
                }else{
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang, File tidak berjaya dipadam!']);
                }
                
            }
        }else{
            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat tidak berjaya Dibuang']);
        }
        return $this->redirect(['adminview', 'icno' => $model->ICNO]);
    }


    protected function findModelbyid($id) {
        if (($model = Tblakaun::findOne(['id' => $id])) !== null) {
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

    public function actionCawangan() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = CawanganAkaun::find()->select(['id' => 'AccBranchCd', 'name' => 'AccBranchNm'])->where(['AccNmCd' => $cat_id])->asArray()->all();

                return Json::encode(['output' => $out, 'selected' => '']);
            }
        }
        return Json::encode(['output' => '', 'selected' => '']);
    }
    
   

}
