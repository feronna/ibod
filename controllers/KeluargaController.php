<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\TblkeluargaSearch;
use app\models\hronline\Tblalamat;
use app\models\hronline\Tblfmydisability;
use app\models\hronline\Tblprfmydisease;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use DateTime;
use app\models\hronline\Negeri;
use app\models\hronline\Bandar;

use yii\web\UploadedFile;
use kartik\mpdf\Pdf;
use yii\helpers\Json;

class KeluargaController extends Controller
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
                'only' => ['adminlihatkeluarga','admintambahkeluarga','adminupdate','adminview', 'admindelete', 'lihatkeluarga','tambahkeluarga','update','view', 'delete','tambahkurangupaya','update-k-u','lihat-k-u','padam-k-u'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id)
                    ,
                    [
                        'actions' => ['adminlihatkeluarga','admintambahkeluarga','adminupdate','adminview', 'admindelete','admintambahkurangupaya','adminupdate-k-u','adminlihat-k-u','adminpadam-k-u'],
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
                        'actions' => ['lihatkeluarga','update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $check = Tblkeluarga::findAll(['id' => $id, 'ICNO' => $logicno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['view', 'tambahkeluarga'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                       'actions' => ['tambahkurangupaya'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');//id from tblkeluarga;
                            $check = Tblkeluarga::findAll(['id' => $id, 'ICNO' => $logicno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        } 
                    ],
                    [
                       'actions' => ['update-k-u','lihat-k-u','padam-k-u'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id'); //id from tblfmydisability;
                            $check = Tblfmydisability::find()->joinWith('keluarga')->where(['Tblfmydisability.id'=>$id])->andWhere(['ICNO'=>$logicno])->all();
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


    public function actionIndex()
    {
        $searchModel = new TblkeluargaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        throw new NotFoundHttpException('The requested page does not exist.');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView()
    {
        $icno = Yii::$app->user->getId();
        return $this->render('view', [
            'keluarga' => $this->findKeluarga($icno),
        ]);
    }
    public function actionAdminview($icno)
    {
        if($this->findModel($icno)){
            return $this->render('adminview', [
            'keluarga' => $this->findKeluarga($icno),
            'ICNO' => $icno,
        ]);
        }
        
    }
    
    public function actionLihatkeluarga($id)
    {   $model = $this->findModelbyid($id);

        $model_disease = Tblprfmydisease::find()->where(['FamilyId'=>$model->FamilyId])->andWhere(['type'=>'1'])->all();
        $model_allergic = Tblprfmydisease::find()->where(['FamilyId'=>$model->FamilyId])->andWhere(['type'=>2])->all();
        switch ($model->FmyDisabilityStatus) {
            case '1': 
                $fmydis = Tblfmydisability::find()->where(['tblfmy_id'=>$id, 'deleted'=>0])->all();
                $thisprm = ['model' => $model,'okuvisible' => true,'fmydis'=>$fmydis];
                break;
            
            default:
                $thisprm = ['model' => $model,'okuvisible' => false];
                break;
        }
        $DA = ['disease'=>$model_disease,'allergic'=>$model_allergic];
        $thisprm = array_merge($thisprm,$DA);
        // var_dump($thisprm);
        // die;
        return $this->render('lihatkeluarga', $thisprm);
    }

    public function actionAdminlihatkeluarga($id)
    {   $model = $this->findModelbyid($id);
        switch ($model->FmyDisabilityStatus) {
            case '1':
                $fmydis = Tblfmydisability::find()->where(['tblfmy_id'=>$id, 'deleted'=>0])->all();
                $thisprm = ['model' => $model,'okuvisible' => true,'fmydis'=>$fmydis];
                break;
            
            default:
                $thisprm = ['model' => $model,'okuvisible' => false];
                break;
        }
        return $this->render('adminlihatkeluarga', $thisprm);
    }

    public function actionTambahkeluarga($id)
    {
        $model = new Tblkeluarga();
        // $model->scenario = 'baru';
        $model->ICNO = Yii::$app->user->getId();
        $model->FamilyId = $id;
        $model->isUms = '0';

        
        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->chronic_disease == 1 || $model->allergic == 1) {
                Yii::$app->session->setFlash('alert', ['title' => ' ', 'type' => 'success', 'msg' => 'Sila kemaskini maklumat penyakit/alahan berkaitan!']);
                return $this->redirect(['add-d-a', 'id' => $model->FamilyId]);
            }
            Yii::$app->session->setFlash('alert', ['title' => ' ', 'type' => 'success', 'msg' => 'Berjaya Disimpan!']);
            return $this->redirect(['view']);
        }

        return $this->render('tambahkeluarga', [
            'model' => $model, 
        ]);   
    }
    
    //admin tambah keluarga yg bukan ums 
    public function actionAdmintambahkeluarga($id,$icno)
    {
        $model = new Tblkeluarga(); //to store new family info;
        $model->ICNO = $icno;
        $model->FamilyId = $id;

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return $this->redirect(['adminview', 'icno' => $model->ICNO]);
            }
        }

        if($this->findModel($icno)){
          return $this->render('admintambahkeluarga', [
            'model' => $model, 
        ]);  
        }    
    }

    public function actionStaffums($id){
        $tblfmy = new Tblkeluarga();
        $tblfmy->ICNO = Yii::$app->user->getId();
        $tblfmy->isUms = '1';
        if ($tblfmy->load(Yii::$app->request->post())) {             
            if ($tblfmy->save()) {
                if($tblfmy->chronic_disease == 1 || $tblfmy->allergic ==1){
                    Yii::$app->session->setFlash('alert', ['title' => ' ', 'type' => 'success', 'msg' => 'Sila kemaskini maklumat penyakit/alahan berkaitan!']);
                    return $this->redirect(['add-d-a','id'=>$tblfmy->FamilyId]);
                } 
                Yii::$app->session->setFlash('alert', ['title' => ' ', 'type' => 'success', 'msg' => 'Berjaya Disimpan!']);
                return $this->redirect(['view']);
            }
        }

        if ($id) {
            $model = Tblprcobiodata::findOne(['ICNO'=>$id]);
            $addr = Tblalamat::find()->where(['ICNO'=>$id])->andWhere(['AddrTypeCd'=>01])->one();
            if (!empty($addr)) {
                $tblfmy->FmyAddr1 = $addr->Addr1;
                $tblfmy->FmyAddr2 = $addr->Addr2;
                $tblfmy->FmyAddr3 = $addr->Addr3;
                $tblfmy->FmyPostcode = $addr->Postcode;
                $tblfmy->CountryCd = $addr->CountryCd;
                $tblfmy->StateCd = $addr->StateCd; 
                $tblfmy->CityCd = $addr->CityCd;
                $tblfmy->FmyTelNo = $addr->TelNo;
            }
            $tblfmy->StaffUms = 1;        
            $tblfmy->FamilyId = $model->ICNO;
            $tblfmy->TitleCd = $model->TitleCd;
            $tblfmy->ReligionCd = $model->ReligionCd;
            $tblfmy->MrtlStatusCd = $model->MrtlStatusCd;
            $tblfmy->RaceCd = $model->RaceCd;
            $tblfmy->FmyStatusCd =$model->MrtlStatusCd;
            $tblfmy->CorpBodyTypeCd = '01';
            $tblfmy->OccSectorCd = '00';
            $tblfmy->FmyEmployerNm = 'Universiti Malaysia Sabah';
            $tblfmy->HighestEduLevelCd = $model->HighestEduLevelCd;
            $tblfmy->GenderCd = $model->GenderCd;           
            $tblfmy->FmyBirthPlaceCd = $model->COBirthPlaceCd;           
            //$tblfmy->RelCd = 
            $tblfmy->NatStatusCd = $model->NatStatusCd;
            $tblfmy->NatCd = $model->NatCd;
            $tblfmy->FmyNm = $model->CONm;
            //$tblfmy->fmyMomNm =             
            $tblfmy->FmyBirthDt = $model->COBirthDt; 
            //$tblfmy->FmyTwinStatus = 
            //$tblfmy->FmyMarriageDt = 
            //$tblfmy->FmyMarriageCertNo = 
            //$tblfmy->FmyDeceaseDt = 
            $tblfmy->FmyBumiStatus = $model->COBumiStatus;
            //$tblfmy->FmyDivorceDt = 
            //$tblfmy->FmyDisabilityStatus = 
            //$tblfmy->FmyDependencyStatus = 
            //$tblfmy->FmyNextOfKinStatus = 
            //$tblfmy->FmyEmerContactStatus = 
            //$tblfmy->FmyPensionRecipient =
            //$tblfmy->ChildReliefInd = 
            $tblfmy->FmyEmailAddr = $model->COEmail;
            //$tblfmy->FmyDependencyCd = 
            //$tblfmy->FmyDependencyICTypeCd = 
            $tblfmy->FmyBirthCertNo = $model->COBirthCertNo;
            //$tblfmy->FmyPassportNo = 

            Yii::$app->session->setFlash('alert', ['title' => ' ', 'type' => 'success', 'msg' => 'Sila kemaskini maklumat yang berkaitan!']);
            return $this->render('tambahkeluarga', [
            'model' => $tblfmy, 
        ]);  
        }

        return $this->redirect(['tambahkeluarga',]);
    }

    public function actionAdminstaffums($id,$icno){
        $tblfmy = new Tblkeluarga();
        $tblfmy->ICNO = $icno;
        if ($tblfmy->load(Yii::$app->request->post())) {
             
            if ($tblfmy->save()) {
                return $this->redirect(['adminview','icno'=>$icno]);
            }
        }

        if ($id) {
            $model = Tblprcobiodata::findOne(['ICNO'=>$id]);
            $addr = Tblalamat::find()->where(['ICNO'=>$id])->andWhere(['AddrTypeCd'=>01])->one();
            if (!empty($addr)) {
                $tblfmy->FmyAddr1 = $addr->Addr1;
                $tblfmy->FmyAddr2 = $addr->Addr2;
                $tblfmy->FmyAddr3 = $addr->Addr3;
                $tblfmy->FmyPostcode = $addr->Postcode;
                $tblfmy->CountryCd = $addr->CountryCd;
                $tblfmy->StateCd = $addr->StateCd; 
                $tblfmy->CityCd = $addr->CityCd;
                $tblfmy->FmyTelNo = $addr->TelNo;
            }
            $tblfmy->StaffUms = 1;        
            $tblfmy->FamilyId = $model->ICNO;
            $tblfmy->TitleCd = $model->TitleCd;
            $tblfmy->ReligionCd = $model->ReligionCd;
            $tblfmy->MrtlStatusCd = $model->MrtlStatusCd;
            $tblfmy->RaceCd = $model->RaceCd;
            $tblfmy->FmyStatusCd =$model->MrtlStatusCd;
            $tblfmy->CorpBodyTypeCd = '01';
            $tblfmy->OccSectorCd = '00';
            $tblfmy->FmyEmployerNm = 'Universiti Malaysia Sabah';
            $tblfmy->HighestEduLevelCd = $model->HighestEduLevelCd;
            $tblfmy->GenderCd = $model->GenderCd;           
            $tblfmy->FmyBirthPlaceCd = $model->COBirthPlaceCd;           
            //$tblfmy->RelCd = 
            $tblfmy->NatStatusCd = $model->NatStatusCd;
            $tblfmy->NatCd = $model->NatCd;
            $tblfmy->FmyNm = $model->CONm;
            //$tblfmy->fmyMomNm =             
            $tblfmy->FmyBirthDt = $model->COBirthDt; 
            //$tblfmy->FmyTwinStatus = 
            //$tblfmy->FmyMarriageDt = 
            //$tblfmy->FmyMarriageCertNo = 
            //$tblfmy->FmyDeceaseDt = 
            $tblfmy->FmyBumiStatus = $model->COBumiStatus;
            //$tblfmy->FmyDivorceDt = 
            
            //$tblfmy->FmyDisabilityStatus = 
            //$tblfmy->FmyDependencyStatus = 
            
            //$tblfmy->FmyNextOfKinStatus = 
            //$tblfmy->FmyEmerContactStatus = 
            //$tblfmy->FmyPensionRecipient =
            //$tblfmy->ChildReliefInd = 
            $tblfmy->FmyEmailAddr = $model->COEmail;
            //$tblfmy->FmyDependencyCd = 
            //$tblfmy->FmyDependencyICTypeCd = 
            $tblfmy->FmyBirthCertNo = $model->COBirthCertNo;
            //$tblfmy->FmyPassportNo = 
            if (['in',$tblfmy->MrtlStatusCd,['1','-1']]) {
                $displaymaklumatperkahwinan = 'none';
            }else{
                $displaymaklumatperkahwinan = ' ';  
            }

            Yii::$app->session->setFlash('alert', ['title' => ' ', 'type' => 'success', 'msg' => 'Sila kemaskini maklumat yang berkaitan!']);
            return $this->render('admintambahkeluarga', [
            'model' => $tblfmy, 'displaymaklumatperkahwinan'=>$displaymaklumatperkahwinan, 'displaymaklumatpekerjaan'=>' ',
        ]);  
        }

        return $this->redirect(['tambahkeluarga',]);
    }

    //button tambahkeluarga
    public function actionUmsNonums()
    {
        if (Yii::$app->request->post()) {

            $fmyicno = Yii::$app->request->post('fmyIcno');
            if (Yii::$app->request->post('staffums')) {
                $model = Tblprcobiodata::findOne(['ICNO' => $fmyicno]);
                if (!empty($model)) {
                    return $this->redirect(['staffums', 'id' => $fmyicno]);
                }
                Yii::$app->session->setFlash('Gagal', "IC tidak wujud dalam Database.");
            } else {
                //Yii::$app->session->setFlash('alert', ['title' => ' ', 'type' => 'success', 'msg' => 'Sila lengkapkan maklumat diperlukan!']);
                return $this->redirect(['tambahkeluarga', 'id' => $fmyicno]);
            }
        }
        return $this->renderAjax('_UmsNonums');
    }

    //button admintambahkeluarga
    public function actionAdminumsNonums($icno)
    {
        if (Yii::$app->request->post()) {
            $fmyicno = Yii::$app->request->post('fmyIcno');
            if (Yii::$app->request->post('staffums')) {
                $model = Tblprcobiodata::findOne(['ICNO' => $fmyicno]);
                if (!empty($model)) {
                    return $this->redirect(['adminstaffums', 'id' => $fmyicno, 'icno' => $icno]);
                }
                Yii::$app->session->setFlash('Gagal', "IC tidak wujud dalam Database.");
            } else {
                Yii::$app->session->setFlash('alert', ['title' => ' ', 'type' => 'success', 'msg' => 'Sila lengkapkan maklumat diperlukan!']);
                return $this->redirect(['admintambahkeluarga', 'id' => $fmyicno, 'icno' => $icno]);
            }
        }
        return $this->renderAjax('_UmsNonums');
    }

    public function actionUpdate($id){
        $model = $this->findModelbyid($id);
        $model_disease = Tblprfmydisease::find()->where(['FamilyId'=>$model->FamilyId])->andWhere(['type'=>'1'])->all();
        $new_disease = new Tblprfmydisease();
        $new_disease->FamilyId = $model->FamilyId;
        $model_allergic = Tblprfmydisease::find()->where(['FamilyId'=>$model->FamilyId])->andWhere(['type'=>2])->all();
 

        if ($model->load(Yii::$app->request->post())) {
            if($model->MrtlStatusCd == 1 || $model->MrtlStatusCd == 0){
                    $model->FmyMarriageDt = "";
                    $model->FmyMarriageCertNo = "";
                    $model->FmyDivorceDt = "";   
                }
            if($model->FmyStatusCd != 02){
                    $model->FmyEmployerNm = "";
                    $model->CorpBodyTypeCd = "";
                    $model->OccSectorCd = "";
                }
            
            if($model->save()){
                
                if ($model->FmyDisabilityStatus == 0) {
                    Tblfmydisability::DeleteAllKU($model->id);
                }
                Yii::$app->session->setFlash('alert', ['title' => ' ', 'type' => 'success', 'msg' => 'Maklumat berjaya dikemaskini!']);
                return $this->redirect(['view', 'icno' => $model->ICNO]);
            }else{
            //    var_dump($model->errors);
            // die;
            }

            
        }

        return $this->render('update', [
            'model' => $model, 
            'disease' => $model_disease,
            'allergic' => $model_allergic,
            'new_disease' => $new_disease,
         ]);
    }
    public function actionAdminupdate($id)
    {
        $model = $this->findModelbyid($id);
        $displaymaklumatperkahwinan = ' ';
        $displaymaklumatpekerjaan = 'none';
        
        if ($model->load(Yii::$app->request->post())) {
            if($model->MrtlStatusCd == 1 || $model->MrtlStatusCd == 0){
                    $model->FmyMarriageDt = null;
                    $model->FmyMarriageCertNo = null;
                    $model->FmyDivorceDt = null;   
                }
            if($model->FmyStatusCd != 02){
                    $model->FmyEmployerNm = null;
                    $model->CorpBodyTypeCd = null;
                    $model->OccSectorCd = null;
                }
            
            if($model->save()){
                
                if ($model->FmyDisabilityStatus == 0) {
                    Tblfmydisability::DeleteAllKU($model->id);
                }
                Yii::$app->session->setFlash('alert', ['title' => ' ', 'type' => 'success', 'msg' => 'Maklumat berjaya dikemaskini!']);
                return $this->redirect(['adminview', 'icno' => $model->ICNO]);
            }
            
        }
        
        if(in_array($model->MrtlStatusCd, ['0','1'])){
            $displaymaklumatperkahwinan = 'none';
        }
        if(in_array($model->FmyStatusCd, ['02','04'])){
            $displaymaklumatpekerjaan = ' ';
        }

        return $this->render('adminupdate', [
            'model' => $model, 'displaymaklumatpekerjaan'=>$displaymaklumatpekerjaan, 'displaymaklumatperkahwinan'=>$displaymaklumatperkahwinan,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModelbyid($id);
        if($model->delete()){
            Tblfmydisability::DeleteAllKU($id);            
        }
        return $this->redirect(['view']);
    }

    public function actionAdmindelete($id)
    {
        $model = $this->findModelbyid($id);
        $icno = $model->ICNO;
        if($model->delete()){
            Tblfmydisability::DeleteAllKU($id); 
        }
        return $this->redirect(['adminview', 'icno' => $icno]); 
    }

    //tambah penyakit keluarga mula//
    public function actionAddDisease($id){
        $new_disease = new Tblprfmydisease();

        if (Yii::$app->request->post()) {
            if (!empty(Yii::$app->request->post('addname'))) {
                $new_disease->FamilyId = $id;
                $new_disease->type = '1';
                $new_disease->description = Yii::$app->request->post('addname');
                if($new_disease->save()){
                    $model = Tblkeluarga::find()->where(['FamilyId'=>$new_disease->FamilyId])->one();
                    if(!empty($model)){
                        $model->chronic_disease = 1;
                        $model->save(false);
                    }
                   
                }
                
            } 
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('disease/add',['new_disease'=>$new_disease]);
    }
    public function actionAddAllergic($id){
        $new_disease = new Tblprfmydisease();

        if (Yii::$app->request->post()) {
            if (!empty(Yii::$app->request->post('addname'))) {
                $new_disease->FamilyId = $id;
                $new_disease->type = '2';
                $new_disease->description = Yii::$app->request->post('addname');
                if($new_disease->save()){
                    $model = Tblkeluarga::find()->where(['FamilyId'=>$new_disease->FamilyId])->one();
                    if(!empty($model)){
                        $model->allergic = 1;
                        $model->save(false);
                    }
                }
                
            } 
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('disease/addAllergic',['new_disease'=>$new_disease]);
    }
    public function actionEditDisease($id){
        $model_disease = Tblprfmydisease::find()->where(['FamilyId'=>$id])->andWhere(['type'=>1])->all();

        return $this->render('disease/editDisease',[
            'disease' => $model_disease,
            'FamilyId' => $id,
        ]);
    }
    public function actionAddDA($id){
        $model_disease = Tblprfmydisease::find()->where(['FamilyId'=>$id])->andWhere(['type'=>1])->all();
        $model_allergic = Tblprfmydisease::find()->where(['FamilyId'=>$id])->andWhere(['type'=>2])->all();

        return $this->render('disease/addDA',[
            'allergic' => $model_allergic,
            'disease' => $model_disease,
            'FamilyId' => $id,
        ]);
    }
    public function actionEditAllergic($id){
        $model_allergic = Tblprfmydisease::find()->where(['FamilyId'=>$id])->andWhere(['type'=>2])->all();

        return $this->render('disease/editAllergic',[
            'allergic' => $model_allergic,
            'FamilyId' => $id,
        ]);
    }

    public function actionPopupDisease(){
        return $this->renderAjax('_popupDisease');
    }



    public function actionDeleteDisease($id){
        $model_disease = Tblprfmydisease::findOne($id);
        if(!empty($model_disease)){
            $model_disease->delete();
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


    //tambah penyakit keluarga tamat//

    //keluarga kurang upaya controller

    /// user
    public function actionTambahkurangupaya($id){
        $model = new Tblfmydisability();

        if ($model->load(Yii::$app->request->post())) {
            $model->tblfmy_id = $id;
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file){
                if($model->save()){
                    $thisid = $model->id;
                    $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/keluarga/oku');
                    if ($datas->status == true) {
                        $model->updater = Yii::$app->user->getId();
                        $model->filename = $datas->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        return $this->redirect(['lihatkeluarga','id'=>$id]);
                    }
                    Tblfmydisability::DeleteAllKU($thisid);
                    Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                    return $this->redirect(['lihatkeluarga','id'=>$id]);
                }
            }else{
                Yii::$app->session->setFlash('Gagal', "Sila muatnaik dokumen berkaitan!");
            }
        }

        return $this->render('_formkurangupaya',['model'=>$model, 'id'=>$id]);
    }

    public function actionUpdateKU($id){
        $model = Tblfmydisability::findOne(['id'=>$id]);
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file){
                if($model->save()){
                    $thisid = $model->id;
                    $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/keluarga/oku');
                    if ($datas->status == true) {
                        $model->updater = Yii::$app->user->getId();
                        $model->filename = $datas->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        return $this->redirect(['lihatkeluarga','id'=>$model->tblfmy_id]);
                    }
                    //Tblfmydisability::DeleteAllKU([$id]);
                    Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                    return $this->redirect(['lihatkeluarga','id'=>$model->tblfmy_id]);
                }
            }elseif (!empty($model->filename) && $model->filename != 'deleted') {
                if ($model->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    return $this->redirect(['lihatkeluarga','id'=>$model->tblfmy_id]);
                }
            }
            else{
                Yii::$app->session->setFlash('Gagal', "Sila muatnaik dokumen berkaitan!");
            }
        }
        
        return $this->render('_formkurangupaya',['model'=>$model, 'id'=>$model->tblfmy_id]);
    }

    public function actionLihatKU($id){
        $model = Tblfmydisability::findOne(['id'=>$id]);

        return $this->render('lihatkurangupaya',['model'=>$model]);
    }

    public function actionPadamKU($id){

        $res = Tblfmydisability::DeleteOneKU(['id'=>$id]);
        $title = 'Gagal';
        $type = 'error';
        $msg = 'Maklumat tidak berjaya dipadam!';
        
        if($res['val']){
            $title = ' Berjaya';
            $type = 'success';
            $msg = 'Maklumat berjaya dipadam!';
        }

        Yii::$app->session->setFlash('alert', ['title' => $title, 'type' => $type, 'msg' => $msg]);
        return $this->redirect(['lihatkeluarga','id'=>$res['tblfmy_id']]);
    }

    ///tamat user

    ///admin
    public function actionAdmintambahkurangupaya($id){
        $model = new Tblfmydisability();

        if ($model->load(Yii::$app->request->post())) {
            $model->tblfmy_id = $id;
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file){
                if($model->save()){
                    $thisid = $model->id;
                    $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/keluarga/oku');
                    if ($datas->status == true) {
                        $model->updater = Yii::$app->user->getId();
                        $model->filename = $datas->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        return $this->redirect(['adminlihatkeluarga','id'=>$id]);
                    }
                    Tblfmydisability::deleteAll(['id'=>$id]);
                    Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                    return $this->redirect(['adminlihatkeluarga','id'=>$id]);
                }
            }else{
                Yii::$app->session->setFlash('Gagal', "Sila muatnaik dokumen berkaitan!");
            }
        }

        return $this->render('_adminformkurangupaya',['model'=>$model, 'id'=>$id]);
    }

    public function actionAdminupdateKU($id){
        $model = Tblfmydisability::findOne(['id'=>$id]);
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file){
                if($model->save()){
                    $thisid = $model->id;
                    $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/keluarga/oku');
                    if ($datas->status == true) {
                        $model->updater = Yii::$app->user->getId();
                        $model->filename = $datas->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        return $this->redirect(['adminlihatkeluarga','id'=>$model->tblfmy_id]);
                    }
                    //Tblfmydisability::deleteAll(['id'=>$thisid]);
                    Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                    return $this->redirect(['adminlihatkeluarga','id'=>$model->tblfmy_id]);
                }
            }elseif (!empty($model->filename) && $model->filename != 'deleted') {
                if ($model->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    return $this->redirect(['adminlihatkeluarga','id'=>$model->tblfmy_id]);
                }
            }
            else{
                Yii::$app->session->setFlash('Gagal', "Sila muatnaik dokumen berkaitan!");
            }
        }
        
        return $this->render('_adminformkurangupaya',['model'=>$model, 'id'=>$model->tblfmy_id]);
    }

    public function actionAdminlihatKU($id){
        $model = Tblfmydisability::findOne(['id'=>$id]);

        return $this->render('adminlihatkurangupaya',['model'=>$model]);
    }

    public function actionAdminpadamKU($id){
        $model = Tblfmydisability::findOne(['id'=>$id]);
        $tblfmy_id = $model->tblfmy_id;
        $file = $model->filename;
        $title = 'Gagal';
        $type = 'error';
        $msg = 'Maklumat tidak berjaya dipadam!';

        if(!empty($model)){
            if($model->delete()){
                $msg = 'Maklumat berjaya dipadam! Tapi tidak dokumen!';
                $res = Yii::$app->FileManager->DeleteFile($file);
                if ($res->status == true){
                    $title = ' Berjaya';
                    $type = 'success';
                    $msg = 'Maklumat berjaya dipadam!';
                }           
            }
        }
        Yii::$app->session->setFlash('alert', ['title' => $title, 'type' => $type, 'msg' => $msg]);
        return $this->redirect(['adminlihatkeluarga','id'=>$tblfmy_id]);
    }
    ///tamat keluarga kurang upaya controller


    //download pdf//

    public function actionFamilyList($icno){

        $fmy = Tblkeluarga::find()->where(['ICNO'=>$icno])->all();
        $biodata = $this->findModel($icno);

        $content = $this->renderPartial('_familylist', [
            'bio' => $biodata,
            'keluarga' => $fmy,
            'ICNO' => $icno,
            ]);
        
            $pdf = new Pdf([
                // set to use core fonts only
                'mode' => Pdf::MODE_CORE,
                'filename' => "Family List (". $biodata->CONm . ").pdf",
                // A4 paper format
                'format' => Pdf::FORMAT_A4,
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT,
                // stream to browser inline
                'destination' => Pdf::DEST_BROWSER,
                // your html content input
                'content' => $content,
                // format content from your own css file if needed or use the
                // enhanced bootstrap css built by Krajee for mPDF formatting 
                'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
                // any css to be embedded if required
                'cssInline' => '.kv-heading-1{font-size:18px}',
                // set mPDF properties on the fly
                'options' => ['title' => "Family List"],
                // call mPDF methods on the fly
                'methods' => [
                    'SetHeader' => ["Family List ( $biodata->CONm )"],
                    'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                    //                'SetFooter' => [' {PAGENO}'],
                ]
            ]);
    
            // return the pdf output as per the destination setting
            return $pdf->render();
    }


    protected function findKeluarga($icno)
    {
        return Tblkeluarga::find()->where(['icno' => $icno])->andWhere(['or',['FmyDeceaseDt'=>'0000-00-00'],['FmyDeceaseDt'=>null]])->all() ;
    }
    protected function findModelbyid($id)
    {
        if (($model = Tblkeluarga::findOne(['id' => $id])) !== null) {
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

    public function actionCitylist() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = Bandar::find()->select(['id' => 'CityCd', 'name' => 'City'])->where(['StateCd' => $cat_id])->asArray()->all();

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }
}
