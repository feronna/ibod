<?php

namespace app\controllers;

use app\models\hronline\TblBadanProfesional;
use app\models\hronline\TblBadanProfesionalSearch;
use Yii;
use yii\db\Exception;
use app\models\hronline\Tblprclinicalcert;
use app\models\hronline\TblprclinicalcertSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

class KelayakanPerubatanController extends \yii\web\Controller
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
                'only' => ['*'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id)
                    ,
                    [
                        'actions' => ['admin-view', 'admin-add-cert', 'admin-update-cc', 'admin-delete-cc', 'admin-view-cc','admin-add-membership',
                    'admin-update-bp','admin-delete-bp','admin-view-bp','view-approval-list-cc','view-approval-list-bp'
                    ],
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
                        'actions' => ['approve-cc','reject-cc','approve-bp','reject-bp'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                           return Yii::$app->MP->IsFPSKPP();
                        }
                    ],
                    [
                        'actions' => ['view', 'add-cl-cert', 'update-cc','delete-cc','view-cc'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $icno = Yii::$app->user->getId();
                            $boleh = true;
                            if ($id = Yii::$app->request->get('id')) {
                                $check = Tblprclinicalcert::findOne(['id' => $id, 'icno' => $icno]);
                                if (empty($check)) {
                                    $boleh = false;
                                }
                            }
                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['view', 'tambah-keahlian-perubatan', 'update-bp','delete-bp','view-bp'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $icno = Yii::$app->user->getId();
                            $boleh = true;
                            if($id = Yii::$app->request->get('id')){
                                $check = TblBadanProfesional::findOne(['profId' => $id, 'ICNO' => $icno]);
                                if (empty($check)) {
                                    $boleh = false;
                                }
                            }
                            return $boleh === true;
                            
                        }
                    ],
                ],
            ],
        ];
    }
    public function actionView(){
        $icno = Yii::$app->user->getId();
        $cert = Tblprclinicalcert::find()->where(['icno'=>$icno])->all();
        $profBody = TblBadanProfesional::find()->where(['and',['isMedicalBody'=>1],['ICNO'=>$icno]])->all();


        return $this->render('view',[
            'cert' => $cert,
            'profBody' => $profBody,
        ]);

    }
    public function actionAdminView($icno){
       
        $cert = Tblprclinicalcert::find()->where(['icno'=>$icno])->all();
        $profBody = TblBadanProfesional::find()->where(['and',['isMedicalBody'=>1],['ICNO'=>$icno]])->all();


        return $this->render('adminview',[
            'cert' => $cert,
            'profBody' => $profBody,
            'icno' => $icno,
        ]);

    }

    
    //---------------START OF CLINICAL CERT PART-----------------------------//

    public function actionAddClCert(){
        $model = new Tblprclinicalcert();
        $model->scenario = 'add';

        if ($model->load(Yii::$app->request->post())) {
            $model->icno = Yii::$app->user->getId();
            $model->file = UploadedFile::getInstance($model, 'file');
            $valid = $model->validate();
            if ($valid && $model->file) {
                $transaction = \Yii::$app->db2->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/kelayakanperubatan');
                        if ($res->status == true) {
                            $model->proof = $res->file_name_hashcode;
                            $flag = $model->save(false);
                            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        } else {
                            $flag = false;
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('clinicalCert/_form', [
            'model' => $model,
        ]);
    }
    public function actionUpdateCc($id){
        $model = $this->findModelCert($id);
        //$model->scenario = 'update';
        $flag = false;

        if ($model->load(Yii::$app->request->post())) {
            $model->icno = Yii::$app->user->getId();
            $model->file = UploadedFile::getInstance($model, 'file');
            $flag_proof = Yii::$app->MP->validateProof($model->proof);
            $valid = $model->validate();
            $transaction = \Yii::$app->db2->beginTransaction();
            if ($model->file) {
                $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/kelayakanperubatan');
                if ($res->status == true) {
                    $model->proof = $res->file_name_hashcode;
                    $flag = $model->save(false);
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                } else {
                    $flag = false;
                }
            }
             else if ($flag_proof) {
                $flag = $model->save(false);
            }else{
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Please upload proof.']);
            }
            try {
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['view']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
                    
        return $this->render('clinicalCert/_form', [
            'model' => $model,
        ]);
    }

    public function actionDeleteCc($id){
        $model = $this->findModelCert($id);
        $transaction = \Yii::$app->db2->beginTransaction();
        if($flag = $model->delete(false)){
            $res = Yii::$app->FileManager->DeleteFile($model->proof);
            if (property_exists($res, 'status') && $res->status) {
                $flag = true;   
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya dipadam!']);         
            }else{
                $flag = false;
                Yii::$app->session->setFlash('alert', ['title' => ' Gagal', 'type' => 'error', 'msg' => 'Tidak berjaya dipadam!']);
            }
        }
        try {
            if ($flag) {
                $transaction->commit();
                return $this->redirect(['view']);
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
        return $this->redirect(['view']);
    }
    public function actionViewCc($id){
        $model = $this->findModelCert($id);
        return $this->render('clinicalCert/view',[
            'model' => $model,
        ]);
    }

    public function actionAdminAddCert($icno){
        $model = new Tblprclinicalcert();
        $model->scenario = 'add';
        $model->icno = $icno;

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $valid = $model->validate();
            if ($valid && $model->file) {
                $transaction = \Yii::$app->db2->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/kelayakanperubatan');
                        if ($res->status == true) {
                            $model->proof = $res->file_name_hashcode;
                            $flag = $model->save(false);
                            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        } else {
                            $flag = false;
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['admin-view-cc','id'=>$model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('clinicalCert/_adminform', [
            'model' => $model,
        ]);
    }

    public function actionAdminUpdateCc($id){
        $model = $this->findModelCert($id);
        //$model->scenario = 'update';
        $flag = false;

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $flag_proof = Yii::$app->MP->validateProof($model->proof);
            $transaction = \Yii::$app->db2->beginTransaction();
            if ($model->file) {
                $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/kelayakanperubatan');
                if ($res->status == true) {
                    $model->proof = $res->file_name_hashcode;
                    $flag = $model->save(false);
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                } else {
                    $flag = false;
                }
            }
             else if ($flag_proof) {
                $flag = $model->save(false);
            }else{
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Please upload proof.']);
            }
            try {
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['admin-view-cc','id'=>$model->id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
                    
        return $this->render('clinicalCert/_adminform', [
            'model' => $model,
        ]);
    }

    public function actionAdminDeleteCc($id){
        $model = $this->findModelCert($id);
        $transaction = \Yii::$app->db2->beginTransaction();
        if($flag = $model->delete(false)){
            $res = Yii::$app->FileManager->DeleteFile($model->proof);
            if (property_exists($res, 'status') && $res->status) {
                $flag = true;   
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya dipadam!']);         
            }else{
                $flag = false;
                Yii::$app->session->setFlash('alert', ['title' => ' Gagal', 'type' => 'error', 'msg' => 'Tidak berjaya dipadam!']);
            }
        }
        try {
            if ($flag) {
                $transaction->commit();
                return $this->redirect(['admin-view']);
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
        return $this->redirect(['view']);
    }
    public function actionAdminViewCc($id){
        $model = $this->findModelCert($id);
        return $this->render('clinicalCert/adminview',[
            'model' => $model,
        ]);
    }
    
    public function actionApproveCc($id){
        $model = $this->findModelCert($id);
        $model->isVerified = 1;
        $model->save(false);

        return $this->redirect(['admin-view-cc','id'=>$id]);
    }
    public function actionRejectCc($id){
        $model = $this->findModelCert($id);
        $model->isVerified = 0;
        $model->save(false);

        return $this->redirect(['admin-view-cc','id'=>$id]);
    }

    //---------------END OF CLINICAL CERT PART-----------------------------//

    //---------------END OF PROF BODY PART-----------------------------//
    public function actionTambahKeahlianPerubatan2()
    {   $icno = Yii::$app->user->getId();
        $model = new TblBadanProfesional();
        $model->isMedicalBody = 1;
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->file = UploadedFile::getInstance($model, 'file');
            $valid = $model->validate();
            if ($valid && $model->file) {
                $transaction = \Yii::$app->db2->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/kelayakanperubatan');
                        if ($res->status == true) {
                            $model->filename = $res->file_name_hashcode;
                            $flag = $model->save(false);
                            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        } else {
                            $flag = false;
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['kelayakan-perubatan/view']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('medicalMembership/_form', [
          'model' => $model, 
         ]);  
    }
    public function actionTambahKeahlianPerubatan()
    {   $icno = Yii::$app->user->getId();
        $model = new TblBadanProfesional();
        $model->isMedicalBody = 1;
        $model->isVerified = 0;
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            $model->file = UploadedFile::getInstance($model, 'file');
            $valid = $model->validate();
            if ($valid && $model->file) {
                $transaction = \Yii::$app->db2->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/kelayakanperubatan');
                        if ($res->status == true) {
                            $model->filename = $res->file_name_hashcode;
                            $flag = $model->save(false);
                            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        } else {
                            $flag = false;
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['kelayakan-perubatan/view']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('medicalMembership/_form2', [
          'model' => $model, 
         ]);  
    }


    public function actionUpdateBp($id){
        $model = $this->findModelProfBody($id);
        //$model->scenario = 'update';
        $flag = false;

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $flag_proof = Yii::$app->MP->validateProof($model->filename);
            $valid = $model->validate();
            $transaction = \Yii::$app->db2->beginTransaction();
            if ($model->file) {
                $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/kelayakanperubatan');
                if ($res->status == true) {
                    $model->filename = $res->file_name_hashcode;
                    $flag = $model->save(false);
                } else {
                    $flag = false;
                }
            }
             else if ($flag_proof) {
                $flag = $model->save(false);
            }else{
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Please upload proof.']);
            }
            try {
                if ($flag) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    return $this->redirect(['view']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
                    
        return $this->render('medicalMembership/_form2', [
            'model' => $model,
        ]);
    }

    public function actionDeleteBp($id){
        // $res = Yii::$app->FileManager->DeleteFile('7f4832c558a44b0494beb7091fd18d87');
        // var_dump($res);die;
        $model = $this->findModelProfBody($id);
        $transaction = \Yii::$app->db2->beginTransaction();
        if($flag = $model->delete(false)){
            $res = Yii::$app->FileManager->DeleteFile($model->filename);
            if (property_exists($res, 'status') && $res->status) {
                $flag = true;   
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya dipadam!']);         
            }else{
                $flag = false;
                Yii::$app->session->setFlash('alert', ['title' => ' Gagal', 'type' => 'error', 'msg' => 'Tidak berjaya dipadam!']);
            }
        }
        try {
            if ($flag) {
                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
        return $this->redirect(['view']);
    }

    public function actionViewBp($id){
        $model = $this->findModelProfBody($id);

        return $this->render('medicalMembership/view',[
            'model' => $model,
        ]);
    }

    public function actionAdminAddMembership($icno){    
        $model = new TblBadanProfesional();
        $model->ICNO = $icno;
        $model->isMedicalBody = 1;
        $model->isVerified = 0;
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $valid = $model->validate();
            if ($valid && $model->file) {
                $transaction = \Yii::$app->db2->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/kelayakanperubatan');
                        if ($res->status == true) {
                            $model->filename = $res->file_name_hashcode;
                            $flag = $model->save(false);
                            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        } else {
                            $flag = false;
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['admin-view','icno'=>$model->ICNO]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('medicalMembership/_form2', [
            'model' => $model, 
        ]);
    }

    public function actionAdminUpdateBp($id){
        $model = $this->findModelProfBody($id);
        //$model->scenario = 'update';
        $flag = false;

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $flag_proof = Yii::$app->MP->validateProof($model->filename);
            $valid = $model->validate();
            $transaction = \Yii::$app->db2->beginTransaction();
            if ($model->file) {
                $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/kelayakanperubatan');
                if ($res->status == true) {
                    $model->filename = $res->file_name_hashcode;
                    $flag = $model->save(false);
                } else {
                    $flag = false;
                }
            }
             else if ($flag_proof) {
                $flag = $model->save(false);
            }else{
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Please upload proof.']);
            }
            try {
                if ($flag) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    return $this->redirect(['admin-view-bp','id'=>$model->profId]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }     
        return $this->render('medicalMembership/_form2', [
            'model' => $model,
        ]);
    }

    public function actionAdminDeleteBp($id){
        $model = $this->findModelProfBody($id);
        $transaction = \Yii::$app->db2->beginTransaction();
        if($flag = $model->delete(false)){
            $res = Yii::$app->FileManager->DeleteFile($model->filename);
            if (property_exists($res, 'status') && $res->status) {
                $flag = true;   
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya dipadam!']);         
            }else{
                $flag = false;
                Yii::$app->session->setFlash('alert', ['title' => ' Gagal', 'type' => 'error', 'msg' => 'Tidak berjaya dipadam!']);
            }
        }
        try {
            if ($flag) {
                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
        return $this->redirect(['admin-view','icno'=>$model->ICNO]);
    }

    public function actionAdminViewBp($id){
        $model = $this->findModelProfBody($id);

        return $this->render('medicalMembership/adminview',[
            'model' => $model,
        ]);
    }

    public function actionApproveBp($id){
        $model = $this->findModelProfBody($id);
        $model->isVerified = 1;
        $model->save(false);

        return $this->redirect(['admin-view-bp','id'=>$id]);
    }
    public function actionRejectBp($id){
        $model = $this->findModelProfBody($id);
        $model->isVerified = 0;
        $model->save(false);

        return $this->redirect(['admin-view-bp','id'=>$id]);
    }
    //---------------END OF PROF BODY PART-----------------------------//

    //---------------APPROVAL-------------------------//

    public function actionViewApprovalListCc(){
        $searchModel = new TblprclinicalcertSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $selection = (array)Yii::$app->request->post('selection');
        if ($data = Yii::$app->request->post('_action')) {
            foreach ($selection as $cc_id) {
                $model = $this->findModelCert($cc_id);
                if($data == 'terima'){
                    $isVerified = 1;
                }else{
                    $isVerified = 0;
                }
                $model->isVerified = $isVerified;
                $model->save(false);
                
            }
        }

        return $this->render('approval_list_cc', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
    public function actionViewApprovalListBp(){
        $searchModel = new TblBadanProfesionalSearch();
        $dataProvider = $searchModel->searchFPSKApproval(Yii::$app->request->queryParams);

        $selection = (array)Yii::$app->request->post('selection');
        if ($data = Yii::$app->request->post('_action')) {
            foreach ($selection as $cc_id) {
                $model = $this->findModelProfBody($cc_id);
                if($data == 'terima'){
                    $isVerified = 1;
                }else{
                    $isVerified = 0;
                }
                $model->isVerified = $isVerified;
                $model->save(false);
                
            }
        }

        return $this->render('approval_list_bp', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }


    //---------------END APPROVAL---------------------//



    protected function findModelCert($id){
        if(($model = Tblprclinicalcert::find()->where(['id'=>$id])->one()) !== null){
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModelProfBody($id){
        if(($model = TblBadanProfesional::find()->where(['profId'=>$id])->one()) !== null){
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
