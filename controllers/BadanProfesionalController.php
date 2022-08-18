<?php

namespace app\controllers;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\TblBadanProfesional;
use app\models\hronline\TblBadanProfesionalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

class BadanProfesionalController extends Controller
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
                'only' => ['index', 'view', 'adminview', 'lihatbadanprofesional', 'adminlihatbadanprofesional', 'tambahbadanprofesional',
                           'admintambahbadanprofesional', 'update', 'adminupdate', 'delete', 'admindelete', 'deletegambar', 'admindeletegambar'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id)
                    ,
                    [
                        'actions' => ['index','admintambahbadanprofesional','adminview', 'adminlihatbadanprofesional', 'adminupdate', 'admindelete', 'admindeletegambar'],
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
                        'actions' => ['lihatbadanprofesional', 'update', 'delete', 'deletegambar'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $icno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $check = TblBadanProfesional::findAll(['profId' => $id, 'ICNO' => $icno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['tambahbadanprofesional', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex__()
    {
        $searchModel = new TblBadanProfesionalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView()
    {
        $icno = Yii::$app->user->getId();
        return $this->render('view',[
        'badanprofesional' => TblBadanProfesional::findAll(['ICNO' => $icno]),
        ]);
    }
    
    public function actionAdminview($icno)
    {
        if($this->findModel($icno)){
           return $this->render('adminview',[
           'badanprofesional' => TblBadanProfesional::findAll(['ICNO' => $icno]),'ICNO' => $icno
           ]); 
        }
        
    }
    
    public function actionLihatbadanprofesional($id)
    {
        return $this->render('lihatbadanprofesional', [
            'model' => $this->findModelbyid($id),  
        ]);
    }
    
    public function actionAdminlihatbadanprofesional($id)
    {
        return $this->render('adminlihatbadanprofesional', [
            'model' => $this->findModelbyid($id),  
        ]);
    }

    public function actionTambahbadanprofesional()
    {   $icno = Yii::$app->user->getId();
        $model = new TblBadanProfesional();
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                $id = $model->profId;
                $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/Badan Profesional');
                if ($res->status == true) {
                    $model->filename = $res->file_name_hashcode;
                    $model->save();
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    return $this->redirect(['view']);
                }else{
                    TblBadanProfesional::deleteAll(['profId'=>$id]);
                    Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                    return $this->redirect(['view']);
                }                   
            }else{
                Yii::$app->session->setFlash('Gagal', "Sila muatnaik dokumen berkaitan!"); 
            }
        }
        return $this->render('tambahbadanprofesional', [
          'model' => $model, 
         ]);  
    }

    public function actionUpdate($id)
    {
        $model = $this->findModelbyid($id);
        $icno = Yii::$app->user->getId();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                if($model->save()){ 
                    $id = $model->profId;
                   $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/Badan Profesional');

                    if($datas->status == true){
                        $model->filename = $datas->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya dikemaskini!']);
                         return $this->redirect(['view']);
                    }
                    else{

                       TblBadanProfesional::deleteAll(['profId'=>$id]);
                       Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya dikemaskini!']);
                       return $this->redirect(['view']);
                    }                   
                }
            }elseif (!empty($model->filename) && $model->filename != 'deleted') {
                if ($model->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya dikemaskini!']);
                         return $this->redirect(['view']);
                }
            }
            else {
               Yii::$app->session->setFlash('Gagal', "Sila muatnaik dokumen berkaitan!");
            }
        }
    
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAdmintambahbadanprofesional($icno)
    {
        $model = new TblBadanProfesional();
        $model->ICNO = $icno;
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                $id = $model->profId;
                $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/Badan Profesional');
                if ($res->status == true) {
                    $model->filename = $res->file_name_hashcode;
                    $model->save();
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    return $this->redirect(['adminview','icno'=>$icno]);
                }else{
                    TblBadanProfesional::deleteAll(['profId'=>$id]);
                    Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                    return $this->redirect(['adminview','icno'=>$icno]);
                }                   
            }else{
                Yii::$app->session->setFlash('Gagal', "Sila muatnaik dokumen berkaitan!");  
            }
        }

       if($this->findModel($icno)){
          return $this->render('admintambahbadanprofesional', [
            'model' => $model,  
        ]); 
       }
        
    }
    
    public function actionAdminupdate($id)
    {
        $model = $this->findModelbyid($id);
        $icno = $model->ICNO;
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                if($model->save()){ 
                    $id = $model->profId;
                   $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/Badan Profesional');

                    if($datas->status == true){
                        $model->filename = $datas->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya dikemaskini!']);
                         return $this->redirect(['adminview','icno'=>$icno]);
                    }
                    else{

                       TblBadanProfesional::deleteAll(['profId'=>$id]);
                       Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya dikemaskini!']);
                       return $this->redirect(['adminview','icno'=>$icno]);
                    }                   
                }
            }elseif (!empty($model->filename) && $model->filename != 'deleted') {
                if ($model->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya dikemaskini!']);
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
    
    public function actionDelete($id)
    {
        $model = $this->findModelbyid($id);
        if ($model->delete()){
            $res = Yii::$app->FileManager->DeleteFile($model->filename);
            if ($res->status == true){
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang']);
            }else{
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang, File tidak berjaya dipadam!']);
            }            
        }else{
            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat tidak berjaya Dibuang']);
        }
        return $this->redirect(['view']);
    }
    
    public function actionAdmindelete($id)
    {
        $model = $this->findModelbyid($id);
        if ($model->delete()){
            $res = Yii::$app->FileManager->DeleteFile($model->filename);
            if ($res->status == true){
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang']);
            }else{
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang, File tidak berjaya dipadam!']);
            }            
        }else{
            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat tidak berjaya Dibuang']);
        }

        return $this->redirect(['adminview', 'icno' => $model->ICNO]);
    }

     
    protected function findModelbyid($id)
    {
        if (($model = TblBadanProfesional::findOne(['profId' => $id])) !== null) {
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
