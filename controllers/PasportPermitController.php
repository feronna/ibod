<?php

namespace app\controllers;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblpasport;
use app\models\hronline\TblpasportSearch;
use app\models\hronline\Tblpermitkerja;
use app\models\hronline\TblpermitkerjaSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\hronline\Negeri;
use app\models\hronline\RptPassport;
use app\models\hronline\RptPassportSearch;
use app\models\Notification;
use yii\helpers\Json;
use yii2tech\spreadsheet\Spreadsheet;
use yii\db\Command;
use yii\db\Connection;

class PasportPermitController extends Controller
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
                'only' => ['adminview', 'view', 'lihatpasport', 'adminlihatpasport', 'tambahpasport', 'admintambahpasport', 'updatepasport',
                           'adminupdatepasport', 'deletepaspot', 'admindeletepaspot', 'deletegambarpaspot', 'admindeletegambarpaspot',
                           'lihatpermitkerja', 'adminlihatpermitkerja', 'tambahpermitkerja', 'admintambahpermitkerja', 'updatepermitkerja',
                           'adminupdatepermitkerja', 'deletepermitkerja', 'admindeletepermitkerja', 'deletegambarpermitkerja', 'admindeletegambarpermitkerja',
                           'view-u-u-p','download-excel','generate-report', 'view-u-u-pr'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id)
                    ,
                    [
                        'actions' => ['adminview', 'adminlihatpasport', 'admintambahpasport', 'adminupdatepasport', 'admindeletepaspot', 'admindeletegambarpaspot',
                           'adminlihatpermitkerja', 'admintambahpermitkerja', 'adminupdatepermitkerja', 'admindeletepermitkerja','admindeletegambarpermitkerja', 'view-u-u-p', 'view-u-u-pr'],
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
                        'actions' => ['lihatpasport','updatepasport','deletepaspot', 'deletegambarpaspot',],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $checkpaspot = Tblpasport::findAll(['id' => $id, 'ICNO' => $logicno]);
                            $bolehpaspot = false;
                            if (!empty($checkpaspot)) {
                                $bolehpaspot = true;
                            }

                            return $bolehpaspot === true;
                        }
                    ],
                    [
                        'actions' => ['lihatpermitkerja', 'updatepermitkerja','deletepermitkerja', 'deletegambarpermitkerja',],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $checkpermit = Tblpermitkerja::findAll(['id' => $id, 'ICNO' => $logicno]);
                            $bolehpermit = false;
                            if (!empty($checkpermit)) {
                                $bolehpermit= true;
                            }

                            return $bolehpermit === true;
                        }
                    ],
                    [
                        'actions' => ['view', 'tambahpasport', 'tambahpermitkerja'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new TblpasportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView()
    {   $icno = Yii::$app->user->getId();
    
        $paspot = Tblpasport::find()->where(['ICNO'=>$icno])->all();
        $permit = Tblpermitkerja::find()->where(['ICNO'=>$icno])->all();
        return $this->render('view', [
            'pasport' => $paspot,
            'permit' => $permit, 
        ]);
    }
    
    public function actionAdminview($icno){   
        
        if($this->findModel($icno)){
          $paspot = Tblpasport::find()->where(['ICNO'=>$icno])->all();
          $permit = Tblpermitkerja::find()->where(['ICNO'=>$icno])->all();
          return $this->render('adminview', [
            'pasport' => $paspot,
            'permit' => $permit, 'ICNO' => $icno,
        ]);  
        }
        
    }
    
    public function actionLihatpermitkerja($id)
    {
        return $this->render('lihatpermitkerja', [
            'permit' => Tblpermitkerja::findOne(['id' => $id]),  
        ]);
    }
    
    public function actionAdminlihatpermitkerja($id)
    {
        return $this->render('adminlihatpermitkerja', [
            'permit' => Tblpermitkerja::findOne(['id' => $id]),  
        ]);
    }
    
    public function actionLihatpasport($id)
    {
        return $this->render('lihatpasport', [
            'paspot' => Tblpasport::findOne(['id' => $id]),
        ]);
    }
    public function actionAdminlihatpasport($id)
    {
        return $this->render('adminlihatpasport', [
            'paspot' => Tblpasport::findOne(['id' => $id]),
        ]);
    }

    public function actionTambahpasport()
    {
        $icno = Yii::$app->user->getId();
        $paspot = new Tblpasport();
        $paspot->ICNO = $icno;

        if ($paspot->load(Yii::$app->request->post())) {
            $paspot->file = UploadedFile::getInstance($paspot, 'file');
            if ($paspot->file) {
                if ($paspot->save()) { 
                    $id = $paspot->id;
                   $datas = Yii::$app->FileManager->UploadFile($paspot->file->name, $paspot->file->tempName, '04', 'Maklumat Rekod Kakitangan/paspot');

                    if ($datas->status == true) {
                        $paspot->filename = $datas->file_name_hashcode;
                        if($paspot->save()){
                            $model = $this->findModel($icno);
                            $model->DisplayIC = $paspot->PassportNo;
                            $model->save(false);
                            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                            return $this->redirect(['view']);
                        }
                        
                    }
                    else{

                       Tblpasport::deleteAll(['id'=>$id]);
                       Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                       return $this->redirect(['view']);
                    }                   
                }
            }else{
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik dokumen berkaitan!']);
            }
        }

        return $this->render('tambahpasport', [
            'paspot' => $paspot,
        ]);
    }
    
    public function actionAdmintambahpasport($icno)
    {
        $paspot = new Tblpasport();
        $paspot->ICNO = $icno;
        
        if ($paspot->load(Yii::$app->request->post())) {
            $paspot->file = UploadedFile::getInstance($paspot, 'file');
            if ($paspot->file) {
                if ($paspot->save()) { 
                    $id = $paspot->id;
                   $datas = Yii::$app->FileManager->UploadFile($paspot->file->name, $paspot->file->tempName, '04', 'Maklumat Rekod Kakitangan/paspot');

                    if ($datas->status == true) {
                        $paspot->filename = $datas->file_name_hashcode;
                        if($paspot->save()){
                            $model = $this->findModel($icno);
                            $model->DisplayIC = $paspot->PassportNo;
                            $model->save(false);
                            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                            return $this->redirect(['adminview','icno'=>$icno]);
                        }
                    }
                    else{
                       Tblpasport::deleteAll(['id'=>$id]);
                       Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                       return $this->redirect(['adminview','icno'=>$icno]);
                    }                   
                }
            }else{
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik dokumen berkaitan!']);
            }
        }

        if($this->findModel($icno)){
            return $this->render('admintambahpasport', [
            'paspot' => $paspot,
        ]);
        }
    }
    
    public function actionTambahpermitkerja()
    {
        $icno = Yii::$app->user->getId();
        $permit = new Tblpermitkerja();
        $permit->ICNO = $icno;
        if ($permit->load(Yii::$app->request->post())) {
            
            $permit->file = UploadedFile::getInstance($permit, 'file');
            if ($permit->file) {
                if ($permit->save()) { 
                    $id = $permit->id;
                   $datas = Yii::$app->FileManager->UploadFile($permit->file->name, $permit->file->tempName, '04', 'Maklumat Rekod Kakitangan/permitkerja');
                    if ($datas->status == true) {
                        $permit->filename = $datas->file_name_hashcode;
                        $permit->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['view']);
                    }
                    else{
                       Tblpermitkerja::deleteAll(['id'=>$id]);
                       Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                       return $this->redirect(['view']);
                    }                   
                }
            }else{
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik dokumen berkaitan!']);
            }
        }
        return $this->render('tambahpermitkerja', [
            'permit' => $permit, 
        ]);
    }
    
    public function actionAdmintambahpermitkerja($icno)
    {
        $permit = new Tblpermitkerja();
        $permit->ICNO = $icno;
        
        if ($permit->load(Yii::$app->request->post())) {
            $permit->file = UploadedFile::getInstance($permit, 'file');
            if ($permit->file) {
                if ($permit->save()) { 
                    $id = $permit->id;
                   $datas = Yii::$app->FileManager->UploadFile($permit->file->name, $permit->file->tempName, '04', 'Maklumat Rekod Kakitangan/permitkerja');
                    if ($datas->status == true) {
                        $permit->filename = $datas->file_name_hashcode;
                        $permit->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['adminview','icno'=>$icno]);
                    }
                    else{
                       Tblpermitkerja::deleteAll(['id'=>$id]);
                       Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                       return $this->redirect(['adminview','icno'=>$icno]);
                    }                   
                }
            }else{
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik dokumen berkaitan!']);
            }
        }
        if($this->findModel($icno)){
            return $this->render('admintambahpermitkerja', [
            'permit' => $permit,
        ]);
        }
        
    }

    ///update funcitons
    public function actionUpdatepasport($id)
    {
        $paspot = Tblpasport::findOne(['id' => $id]);
        $icno = Yii::$app->user->getId();
        if ($paspot->load(Yii::$app->request->post()) && $paspot->save() ) {
            $paspot->file = UploadedFile::getInstance($paspot, 'file');
            if ($paspot->file) {
                if ($paspot->save()) { 
                    $id = $paspot->id;
                   $datas = Yii::$app->FileManager->UploadFile($paspot->file->name, $paspot->file->tempName, '04', 'Maklumat Rekod Kakitangan/paspot');
                    if ($datas->status == true) {
                        $paspot->filename = $datas->file_name_hashcode;
                        $paspot->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['view']);
                    }
                    else{

                       Tblpasport::deleteAll(['id'=>$id]);
                       Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                       return $this->redirect(['view']);
                    }                   
                }
            }elseif (!empty($paspot->filename) && $paspot->filename != 'deleted') {
                if ($paspot->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['view']);
                }
            }
            else {
               Yii::$app->session->setFlash('Gagal', "Sila muatnaik dokumen berkaitan!");
            }              
        }

        return $this->render('updatepaspot', [
            'paspot' => $paspot,
        ]);
    }
    
    public function actionAdminupdatepasport($id)
    {
        $paspot = Tblpasport::findOne(['id' => $id]);
        $icno = $paspot->ICNO;
        if ($paspot->load(Yii::$app->request->post()) && $paspot->save() ) {
            $paspot->file = UploadedFile::getInstance($paspot, 'file');
            if ($paspot->file) {
                if ($paspot->save()) { 
                    $id = $paspot->id;
                   $datas = Yii::$app->FileManager->UploadFile($paspot->file->name, $paspot->file->tempName, '04', 'Maklumat Rekod Kakitangan/paspot');
                    if ($datas->status == true) {
                        $paspot->filename = $datas->file_name_hashcode;
                        $paspot->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['adminview','icno'=>$icno]);
                    }
                    else{

                       Tblpasport::deleteAll(['id'=>$id]);
                       Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                       return $this->redirect(['adminview','icno'=>$icno]);
                    }                   
                }
            }elseif (!empty($paspot->filename) && $paspot->filename != 'deleted') {
                if ($paspot->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['adminview','icno'=>$icno]);
                }
            }
            else {
               Yii::$app->session->setFlash('Gagal', "Sila muatnaik dokumen berkaitan!");
            }              
        }

        return $this->render('adminupdatepaspot', [
            'paspot' => $paspot,
        ]);
    }
    public function actionUpdatepermitkerja($id)
    {
        $permit = Tblpermitkerja::findOne(['id' => $id]);
        $icno = Yii::$app->user->getId();
        if ($permit->load(Yii::$app->request->post())) {
            $permit->file = UploadedFile::getInstance($permit, 'file');
            if ($permit->file) {
                if ($permit->save()) { 
                    $id = $permit->id;
                   $datas = Yii::$app->FileManager->UploadFile($permit->file->name, $permit->file->tempName, '04', 'Maklumat Rekod Kakitangan/permitkerja');
                    if ($datas->status == true) {
                        $permit->filename = $datas->file_name_hashcode;
                        $permit->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['view']);
                    }
                    else{
                       Tblpermitkerja::deleteAll(['id'=>$id]);
                       Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                       return $this->redirect(['view']);
                    }                   
                }
            }elseif (!empty($permit->filename) && $permit->filename != 'deleted') {
                if ($permit->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['adminview','icno'=>$icno]);
                }
            }
            else {
               Yii::$app->session->setFlash('Gagal', "Sila muatnaik dokumen berkaitan!");
            }

        }
        return $this->render('updatepermit', [
            'permit' => $permit,
        ]);
    }

    public function actionAdminupdatepermitkerja($id)
    {
        $permit = Tblpermitkerja::findOne(['id' => $id]);
        $icno = $permit->ICNO;
        if ($permit->load(Yii::$app->request->post())) {
            $permit->file = UploadedFile::getInstance($permit, 'file');
            if ($permit->file) {
                if ($permit->save()) { 
                    $id = $permit->id;
                   $datas = Yii::$app->FileManager->UploadFile($permit->file->name, $permit->file->tempName, '04', 'Maklumat Rekod Kakitangan/permitkerja');
                    if ($datas->status == true) {
                        $permit->filename = $datas->file_name_hashcode;
                        $permit->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['adminview','icno'=>$icno]);
                    }
                    else{
                       Tblpermitkerja::deleteAll(['id'=>$id]);
                       Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                       return $this->redirect(['adminview','icno'=>$icno]);
                    }                   
                }
            }elseif (!empty($permit->filename) && $permit->filename != 'deleted') {
                if ($permit->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['adminview','icno'=>$icno]);
                }
            }
            else {
               Yii::$app->session->setFlash('Gagal', "Sila muatnaik dokumen berkaitan!");
            }

        }
        return $this->render('adminupdatepermit', [
            'permit' => $permit,
        ]);
    }

    public function actionDeletepaspot($id)
    {
        $paspot = Tblpasport::findOne(['id' => $id]);
        if($paspot->delete()){
          if (!empty($paspot->filename) && $paspot->filename != 'deleted') {
                $res = Yii::$app->FileManager->DeleteFile($paspot->filename);
                if ($res->status == true) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang']);
                }else{
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang, File tidak berjaya dipadam!']);
                }
                
            }  
        }else{
            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat tidak berjaya Dibuang']);
        }        
        return $this->redirect(['view']);
    }
    
    public function actionAdmindeletepaspot($id)
    {
        $paspot = Tblpasport::findOne(['id' => $id]);
        if($paspot->delete()){
          if (!empty($paspot->filename) && $paspot->filename != 'deleted') {
                $res = Yii::$app->FileManager->DeleteFile($paspot->filename);
                if ($res->status == true) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang']);
                }else{
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang, File tidak berjaya dipadam!']);
                }
                
            }  
        }else{
            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat tidak berjaya Dibuang']);
        }
        return $this->redirect(['adminview', 'icno' => $paspot->ICNO]);
    }
    
    public function actionDeletegambarpaspot($id) {
        $paspot = Tblpasport::findOne($id);
        if (!empty($paspot->filename) && $paspot->filename != 'deleted') {
            $res = Yii::$app->FileManager->DeleteFile($paspot->filename);
            if ($res->status == true) {
            $paspot->filename = 'deleted';
            $paspot->update();
            }
        }
        return $this->redirect(['updatepasport', 'id' => $id]);
    }

    public function actionAdmindeletegambarpaspot($id) {
        $paspot = Tblpasport::findOne($id);
        if (!empty($paspot->filename) && $paspot->filename != 'deleted') {
            $res = Yii::$app->FileManager->DeleteFile($paspot->filename);
            if ($res->status == true) {
            $paspot->filename = 'deleted';
            $paspot->update();
            }
        }
        return $this->redirect(['adminupdatepasport', 'id' => $id]);
    }
    
    
    public function actionDeletepermit($id)
    {
        $permit = Tblpermitkerja::findOne(['id' => $id]);
        if ($permit->delete()) {
            if (!empty($permit->filename) && $permit->filename != 'deleted') {
                $res = Yii::$app->FileManager->DeleteFile($permit->filename);
                if ($res->status == true) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang']);
                }else{
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang, File tidak berjaya dipadam!']);
                }
                
            }  
        }else{
            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat tidak berjaya Dibuang']);
        }        
        return $this->redirect(['view']);   
    }
    
    public function actionAdmindeletepermit($id)
    {
        $permit = Tblpermitkerja::findOne(['id' => $id]);
        if ($permit->delete()) {
            if (!empty($permit->filename) && $permit->filename != 'deleted') {
                $res = Yii::$app->FileManager->DeleteFile($permit->filename);
                if ($res->status == true) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang']);
                }else{
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya Dibuang, File tidak berjaya dipadam!']);
                }
                
            }  
        }else{
            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat tidak berjaya Dibuang']);
        }

        return $this->redirect(['adminview', 'icno' => $permit->ICNO]);
    }
    
    public function actionDeletegambarpermit($id) {
        $permit = Tblpermitkerja::findOne($id);
        if (!empty($permit->filename) && $permit->filename != 'deleted') {
            $res = Yii::$app->FileManager->DeleteFile($permit->filename);
            if ($res->status == true) {
            $permit->filename = 'deleted';
            $permit->update();
            }
        }
        return $this->redirect(['updatepermitkerja', 'id' => $id]);
    }
    
    public function actionAdmindeletegambarpermit($id) {
        $permit = Tblpermitkerja::findOne($id);
        if (!empty($permit->filename) && $permit->filename != 'deleted') {
            $res = Yii::$app->FileManager->DeleteFile($permit->filename);
            if ($res->status == true) {
            $permit->filename = 'deleted';
            $permit->update();
            }
        }

        return $this->redirect(['adminupdatepermitkerja', 'id' => $id]);
    }

    //notification

    public function actionViewUUP($ICNO = null, $name = null, $isSabahan = null, $ps_noty_status = null, $pasport_status = null, $pr_noty_status = null, $permit_status = null ){  ///view unupdated passport    
        $searchModel = new RptPassportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $ICNO ? $dataProvider->query->andFilterWhere(['like', 'ICNO',  $ICNO ]):'';
        $name ? $dataProvider->query->andFilterWhere(['like', 'ICNO',  $name ]):'';
        $isSabahan ? $dataProvider->query->andFilterWhere(['=', 'isSabahan',  $isSabahan ]):'';
        $ps_noty_status ? $dataProvider->query->andFilterWhere(['=', 'ps_noty_status',  $ps_noty_status ]):'';
        $pasport_status ? $dataProvider->query->andFilterWhere(['=', 'pasport_status',  $pasport_status ]):'';
        // var_dump($status);
        // die;
        return $this->render('viewuup',[
            'searchModel' => $searchModel,
            'dataProvider'=>$dataProvider,
        ]);
            
    }
    public function actionViewUUPr($ICNO = null, $name = null, $isSabahan = null, $pr_noty_status = null, $permit_status = null ){  ///view unupdated permit    
        $searchModel = new RptPassportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $ICNO ? $dataProvider->query->andFilterWhere(['like', 'ICNO',  $ICNO ]):'';
        $name ? $dataProvider->query->andFilterWhere(['like', 'ICNO',  $name ]):'';
        $isSabahan ? $dataProvider->query->andFilterWhere(['=', 'isSabahan',  $isSabahan ]):'';
        $pr_noty_status ? $dataProvider->query->andFilterWhere(['=', 'pr_noty_status',  $pr_noty_status ]):'';
        $permit_status ? $dataProvider->query->andFilterWhere(['=', 'permit_status',  $permit_status ]):'';
        // var_dump($status);
        // die;
        return $this->render('viewuupr',[
            'searchModel' => $searchModel,
            'dataProvider'=>$dataProvider,
        ]);
            
    }

    public function actionDownloadExcel($pp = null){
        
        $model = RptPassport::find()->all();
        if($pp == 'pr'){
            return $this->renderAjax('_uuprreport',[
                'model'=>$model,
            ]);
        }
        return $this->renderAjax('_uupreport',[
            'model'=>$model,
        ]);
    }

    public function actionRefresh(){  //generate table for report //button refresh
        $r = [];
        $b = [];
        $biodata = Tblprcobiodata::find()->select(['ICNO','isSabahan'])->where(['!=','status','06'])->asArray()->all();
        $rpt = RptPassport::find()->select('ICNO')->all();

        for($i = 0; $i < count($rpt); $i++){
            array_push($r, $rpt[$i]['ICNO']);
        }
        for($i = 0; $i < count($biodata); $i++){
            array_push($b,$biodata[$i]['ICNO']);
        }

        foreach ($rpt as $rpt) {
            if (!in_array($rpt->ICNO, $b)) {
                $rpt->delete();
            }
        }

        for($i = 0; $i < count($biodata); $i++){
            if (!in_array($biodata[$i]['ICNO'], $r)) {
                $model = new RptPassport();
                $model->ICNO = $biodata[$i]['ICNO'];
                $model->isSabahan = $biodata[$i]['isSabahan'];
            } else {
                $model = RptPassport::find()->where(['ICNO' => $biodata[$i]['ICNO']])->one();
                $model->isSabahan = $biodata[$i]['isSabahan'];
            }
            $paspot = Yii::$app->MP->hasValidPasport($biodata[$i]['ICNO']);
            $model->pasport_status = $paspot[2];
            $model->tblpassport_id = $paspot[1];
            if(!$model->lock){
                if ($biodata[$i]['isSabahan'] == 0 && $paspot[0] == false) {
                    $model->ps_noty_status = 1;
                    
                } else {
                    $model->ps_noty_status = 0;
                }
            }
          
            $permit = Yii::$app->MP->hasValidPermit($biodata[$i]['ICNO']);
            $model->permit_status = $permit[2];
            $model->tblpermit_id = $permit[1];
            if(!$model->lock){
                if ($biodata[$i]['isSabahan'] == 0 && $permit[0] == false) {
                    $model->pr_noty_status = 1;
                } else {
                    $model->pr_noty_status = 0;
                }
            }
            
            $model->save(false);
            
        }

        return $this->redirect(['view-u-u-p']);
    }

    public function actionSendNoty($id = null, $status_value = null, $pp = null){
        $cdate = date("Y-m-d");
        switch ($pp) {
            case 'pr':
                $p = 'permit kerja';
                $status = 'permit_status';
                $noty = 'pr_noty_status';
                //notification
                $noty_title = 'Maklumat Peribadi (Permit Kerja)';
                $page = 'view-u-u-pr';
                break;

            default:
                $p = 'passport';
                $status = 'pasport_status';
                $noty = 'ps_noty_status';
                //notification
                $noty_title = 'Maklumat Peribadi (Passport)';
                $page = 'view-u-u-p';
                break;
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Pemberitahuan tidak berjaya dihantar.']);
        if ($id == null) {
            if($status_value == null){
                $status_value = [2,3];
            }
            $target_noty = RptPassport::find()->where(['IN', $status , $status_value])->andWhere([$noty =>'1'])->all();
            if (!$target_noty) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            foreach ($target_noty as $rpt) {
                switch ($rpt->{$status}) {
                    case '2':
                        $pp_status = 'has expired';
                        $pp_notes = 'Do not update the expired '.$p.'.';
                        break;
                    case '3':
                        $pp_status = 'not exist';
                        $pp_notes = ' ';
                        break;
                    
                    default:
                        $pp_status = '-';
                        $pp_notes = '-';
                        break;
                }
                if ($rpt->isSabahan == '0' && $rpt->{$status} != '1' && Yii::$app->MP->NatStatusCd($rpt->ICNO) != '3' && $rpt->{$noty} == '1') {
                    $ntf = new Notification();
                    $ntf->icno = $rpt->ICNO;
                    $ntf->title = $noty_title;
                    $ntf->content = "Reminder " . $rpt->ICNO . ": We would like to inform you that your '".$p."' ".$pp_status.". Please provide your new '".$p."' information by following these steps:
                        <p><b>After login into HROnline V4.0</b> </p>
                        <p>                                      </p>
                        <p>1. On the left menu, click <b>'Maklumat Peribadi'</b>.</p>
                        <p>2. On the main page, click <b>'Paspot & Permit Kerja'</b>.</p>
                        <p>3. On the top page, click tab <b>'".$p."'</b>.</p>
                        <p>4. Clik button <b>'New ".$p."'</b>. " .$pp_notes." </p>
                        <p>5. Fill all the field required, including the upload file.</p>
                        <p>6. To save, clik button <b>Save</b>.</p>";
                    $ntf->ntf_dt = $cdate;
                    if($ntf->save()){
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Pemberitahuan berjaya dihantar.']);
                    }
                } 
            }
        }else{
            $rpt = RptPassport::find()->where(['ICNO' => $id])->andWhere([$noty=> '1'])->one();
            if (!$rpt) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }

            switch ($rpt->{$status}) {
                case '2':
                    $pp_status = 'has expired';
                    $pp_notes = 'Do not update the expired '.$p.'.';
                    break;
                case '3':
                    $pp_status = 'not exist';
                    $pp_notes = ' ';
                    break;
                
                default:
                    $pp_status = '-';
                    $pp_notes = '-';
                    break;
            }

            if ($rpt->isSabahan == '0' && $rpt->pasport_status != '1' && Yii::$app->MP->NatStatusCd($rpt->ICNO) != '3' && $rpt->ps_noty_status == '1') {
                $ntf = new Notification();
                $ntf->icno = $rpt->ICNO;
                $ntf->title = $noty_title;
                $ntf->content = "Reminder " . $rpt->ICNO . ": We would like to inform you that your '".$p."' ".$pp_status.". Please provide your new '".$p."' information by following these steps:
                    <p><b>After login into HROnline V4.0</b> </p>
                    <p>                                      </p>
                    <p>1. On the left menu, click <b>'Maklumat Peribadi'</b>.</p>
                    <p>2. On the main page, click <b>'Paspot & Permit Kerja'</b>.</p>
                    <p>3. On the top page, click tab <b>'".$p."'</b>.</p>
                    <p>4. Clik button <b>'New ".$p."'</b>. " .$pp_notes." </p>
                    <p>5. Fill all the field required, including the upload file.</p>
                    <p>6. To save, clik button <b>Save</b>.</p>";
                $ntf->ntf_dt = $cdate;
                if($ntf->save()){
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Pemberitahuan berjaya dihantar.']);
                }
            }
        }
        
        return $this->redirect([$page]);
        
    }

    public function actionRollbackNoty(){
        
    }

    public function actionUpdateNotyStatus($icno, $pp = null){
        
        $model = $this->findModelPassport($icno);
        if($pp == 'pr'){
            $model->pr_noty_status = !$model->pr_noty_status;
            $model->save(false);
            return $this->redirect(['view-u-u-pr']);

        }
        $model->ps_noty_status = !$model->ps_noty_status;
        $model->save(false);
        return $this->redirect(['view-u-u-p']);
    }

    public function actionLockNoty($icno){
        $model = $this->findModelPassport($icno);
        $model->lock = !$model->lock;
        $model->save(false);
        return $this->redirect(['view-u-u-p']);
    }

    public function actionGenerateH($key=null){  // to generate isSabahan  1=sabahan;0=non-sabahan;
        // if($key == null || $key != '940402125181'){
        //     Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Pls enter KEY!']);
        //     return $this->redirect(['generate-h']);
        // }

        $model = Tblprcobiodata::find()->all();
        foreach ($model as $staff) {
            if ($staff->NatStatusCd == 1 && strlen($staff->ICNO) == '12') {
                $kod_negeri = self::Negeri($staff->ICNO);
                switch ($kod_negeri) {
                    case '12': //staff asal sabah
                        $staff->isSabahan = '1';
                        break;

                    case '15': 
                        $staff->isSabahan = '0';
                        break;
                    
                    default:
                    $staff->isSabahan = '0';
                        break;
                }

            }             
            elseif ($staff->NatStatusCd == 1 && strlen($staff->ICNO) == '8' && substr($staff->ICNO, 0, 1) == 'H') { 
                $staff->isSabahan = '1';
            }
            elseif ($staff->NatStatusCd == 1 && strlen($staff->ICNO) != '12') { 
                $staff->isSabahan = '0';
            }
            elseif ($staff->NatStatusCd == '3') { //penduduk tetap
                $staff->isSabahan = '0';
            }
            else{
                $staff->isSabahan = '0';
            }

            $staff->save(false);

        } 
        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Berjaya generate!']);
        return $this->redirect(['view-u-u-p']);

    }

    /////protected////
    
    protected function findModel($id) {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModelPassport($icno) {
        if (($model = RptPassport::find()->where(['ICNO'=>$icno])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionStatelist() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = Negeri::find()->select(['id' => 'StateCd', 'name' => 'State'])->where(['CountryCd' => $cat_id])->asArray()->all();

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
        }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function Negeri($icno){ //return kod negeri for staff
        $kod_ic_sabah = ["12","47","48","49"];
        $kod_ic_labuan = ["15", "58"];
        $model_kod = '0';
        $kod_negeri = null;
        $split = str_split($icno);
        $model_kod = $split[6].$split[7];
        if(in_array($model_kod, $kod_ic_sabah)){
            $kod_negeri = '12';
        }elseif (in_array($model_kod, $kod_ic_labuan)){
            $kod_negeri = '15';
        }else{
            $kod_negeri = '0';
        }
        return $kod_negeri;
    }
}
