<?php

namespace app\controllers;

use Yii;
use app\models\msiso\msiso;
use app\models\msiso\MsisoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblprcobiodata;
use app\models\msiso\TblOfi;
use app\models\msiso\TblNcr;
use app\models\msiso\Notifyaudit;
use app\models\msiso\Model;
use app\models\msiso\Refnotifyaudit;
use app\models\msiso\AuditPlan;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use app\models\msiso\TblAccess;
use app\models\msiso\TblNotaAudit;
use app\models\Notification;
use app\models\hronline\Department;
use yii\helpers\Html;
use app\models\msiso\RefAuditorDept;
use app\models\msiso\TblClause; 
use app\models\msiso\TblBestPractice;
use kartik\mpdf\Pdf;
use app\models\msiso\RefTempoh;
use app\models\msiso\TblOfiSearch;
use app\models\msiso\TblNcrSearch; 
use app\models\msiso\TblNotaAuditSearch; 
use app\models\msiso\TblBestPracticeSearch; 
use yii\data\Pagination;

/**
 * MsisoController implements the CRUD actions for TblAudit model.
 */
class MsisoController extends Controller
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
                    //penyelia BPQ, Pentadbir sistem
                    'notification-letter', 'tambah-klausa', 'senarai-klausa', 'tambah-auditor',
                    //auditor, Pentadbir sistem
                    'senarai-ofi', 'senarai-ncr',
                    //Pegawai BPG, Pentadbir sistem
                    'senarai-audit-plan', 'notification-letter',
                    //pentadbir sistem
                    'akses'
                ],
                'rules' => [
                      
                    [//Penyelia BPQ, Pentadbir sistem
                        'actions' => ['notification-letter', 'tambah-klausa', 'senarai-klausa', 'tambah-auditor'],
                        'allow' => true,
                        'matchCallback' => function () {
                    $akses = TblAccess::findOne(['icno' => Yii::$app->user->getId(), 'access_level' => [2,99]]);
                    return (is_null($akses)) ? false : true;
                }
                    ],
                      [//Auditor, Pentadbir sistem
                        'actions' => ['senarai-ofi', 'senarai-ncr'],
                        'allow' => true,
                        'matchCallback' => function () {
                    $akses = TblAccess::findOne(['icno' => Yii::$app->user->getId(), 'access_level' => [3,99]]);
                    return (is_null($akses)) ? false : true;
                }
                    ],
                     [//Pegawai BPG, Pentadbir sistem
                        'actions' => ['senarai-audit-plan', 'notification-letter'],
                        'allow' => true,
                        'matchCallback' => function () {
                    $akses = TblAccess::findOne(['icno' => Yii::$app->user->getId(), 'access_level' => [1,99]]);
                    return (is_null($akses)) ? false : true;
                }
                    ],
                    [//Pegawai BPG, Pentadbir sistem
                        'actions' => ['akses'],
                        'allow' => true,
                        'matchCallback' => function () {
                        $akses = TblAccess::findOne(['icno' => Yii::$app->user->getId(), 'access_level' => [99]]);
                        return (is_null($akses)) ? false : true;
                }
                    ],
                        
                ],
            ],
        ];
    } 
    
    public function notification($icno, $content)
    { 
        $ntf = new Notification();
        $ntf->icno = $icno;  
        $ntf->title = 'ISO AUDIT DALAM';
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        return true;
    }
 
    public function actionIndex3()
    {
        $searchModel = new MsisoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index3', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } 
    public function actionMain()
    {
        $icno = Yii::$app->user->getId();
        $current_year = date('Y');
        $ncrAuditee = TblNcr::find()->where(['auditee_icno' => $icno])->andwhere(['year' => $current_year])->exists();
      
        if($ncrAuditee ){ 
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada mempunyai akses. Sila berhubung dengan Pusat Jaminan Kualiti, Jabatan Pendaftar.']);
            return $this->redirect(['msiso/main']); 
        } 
        return $this->render('main');
    }
    public function actionMain2()
    {
        $icno = Yii::$app->user->getId(); 
      
        $admin = TblAccess::find()->where(['icno' => $icno])->andwhere(['access_level' => ['2','99','4'],'isActive' => 1]);
        if(!$admin->exists()){ 
            // Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada mempunyai akses. Sila berhubung dengan Pusat Jaminan Kualiti, Jabatan Pendaftar.']);
            return $this->redirect(['msiso/auditee-report']); 
        } 
        $title = 'Audit Plan';
        $query = AuditPlan::find()->where(['status' => 1])->orderBy(['created_dt' => SORT_DESC]);
      
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
    
        // view senarai notifiy letter
        $titles = 'Notification Letter';
        $senarai = Notifyaudit::find()->orderBy(['created_dt' => SORT_DESC]);
      
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
        ]);
       
        return $this->render('main2', [
            // 'model' => $model,  
            'dataProvider' => $DataProvider,
            'senarai' => $senarais,
            'title' => $title,
            'titles' => $titles,
            'bil' => 1,
        ]);
    }
    public function actionIndex()
    {///view senarai audit plan 
        $icno = Yii::$app->user->getId();
        $current_year = date('Y');
        $checkChief = Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->exists();   
        $checkPP = Department::find()->where(['pp'=> $icno])->andWhere(['isActive' => 1])->exists();   
        $checkAuditor = msiso::find()->where(['icno' => $icno])->andwhere(['isActive' => 1])->exists();
        $ncrAuditee = TblNcr::find()->where(['auditee_icno' => $icno])->andwhere(['year' => $current_year])->exists();
        $admin = TblAccess::find()->where(['isActive' => 1])->exists();
        if(!$checkChief && !$checkPP && !$checkAuditor ){ 
            // Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada mempunyai akses. Sila berhubung dengan Pusat Jaminan Kualiti, Jabatan Pendaftar.']);
            return $this->redirect(['msiso/main2']); 
        }
        elseif(!$ncrAuditee && !$admin){ 
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada mempunyai akses. Sila berhubung dengan Pusat Jaminan Kualiti, Jabatan Pendaftar.']);
            return $this->redirect(['msiso/main']);
        }

        $title = 'Audit Plan';
        $query = AuditPlan::find()->where(['status' => 1])->orderBy(['created_dt' => SORT_DESC]);
      
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
    
        // view senarai notifiy letter
        $titles = 'Notification Letter';
        $senarai = Notifyaudit::find()->orderBy(['created_dt' => SORT_DESC]);
      
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
        ]);
       
        return $this->render('index', [
            // 'model' => $model,  
            'dataProvider' => $DataProvider,
            'senarai' => $senarais,
            'title' => $title,
            'titles' => $titles,
            'bil' => 1,
        ]);
    } 

    public function actionIndexLetter()
    {///view senarai notification plan
        $title = 'MSISO';
        $query = Notifyaudit::find()->orderBy(['created_dt' => SORT_DESC]);
      
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
       
        return $this->render('index_letter', [ 
            'dataProvider' => $DataProvider,
            'title' => $title,
            'bil' => 1,
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

        return $this->redirect(['index']);
    }
    public function actionDlte($id)
    {
        $this->findPlan($id)->delete();

        return $this->redirect(['audit-plan']);
    }

    public function actionDelAkses($id)
    {
        $this->findAkses($id)->delete();

        return $this->redirect(['akses']);
    }

    public function actionDelNotify($id)
    {
        $this->findNotify($id)->delete();

        return $this->redirect(['notification-letter']);
    }
    public function actionDelLokasi($id)
    {
        $this->findLokasi($id)->delete();

        return $this->redirect(['lokasi-auditor']);
    }
    public function actionDelOfi($id)
    {
        $this->findOfi($id)->delete();

        return $this->redirect(['senarai-report']);
    }
    public function actionDelNcr($id)
    {
        $this->findNcr($id)->delete();

        return $this->redirect(['senarai-report']);
    }
    public function actionDelNotaAudit($id)
    {
        $this->findNotaAudit($id)->delete();

        return $this->redirect(['senarai-report']);
    }
    public function actionNotify($id)
    {
        $this->findRefNotify($id)->delete();

        return $this->redirect(['notification-letter']);
    }

    public function actionDelNotify2($id)
    {
        $model = $this->findNotify($id);
        $this->findRefNotify($id)->delete();

        return $this->redirect(['paparan-notification', 'id' => $model->id]);
    }
    public function actionDelBestPractice($id)
    { 
        $this->findBestPractice($id)->delete();

        return $this->redirect(['senarai-report']);
    }
 
    protected function findModel($id)
    {
        if (($model = Msiso::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findAkses($id)
    {
        if (($model = TblAccess::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findOfi($id)
    {
        if (($model = TblOfi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findNcr($id)
    {
        if (($model = TblNcr::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findPlan($id)
    {
        if (($model = AuditPlan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findNotify($id)
    {
        if (($model = NotifyAudit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findRefNotify($id)
    {
        if (($model = RefNotifyaudit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findBestPractice($id)
    {
        if (($model = TblBestPractice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findNotaAudit($id)
    {
        if (($model = TblNotaAudit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function ICNO() {
        return Yii::$app->user->getId();
    }
    
     protected function findBiodata($icno) {
        return Tblprcobiodata::findOne(['ICNO' => $icno]);
    } 

    protected function findLokasi($id)
    {
        if (($model = RefAuditorDept::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAkses()
    { 
        $model = new TblAccess();
        $icno = Yii::$app->user->getId();
        
        $query = TblAccess::find()->where(['isActive' => [1,0]])->andwhere(['!=','access_level', '99']);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $senarai = TblAccess::find()->where(['isActive' => [1,0]]);
 
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
        ]);

         if ($model->load(Yii::$app->request->post())) { 
            if($model->icno == '' || $model->access_level == '' || $model->isActive == '' ){
                
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
             
            }else{
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/akses']);
            }
            }
        return $this->render('akses', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'senarai' => $senarais,
            'bil' => 1,
        ]); 
    }  

    public function actionUpdateAkses($id)
    {   
        $model = $this->findAkses($id);
        $query = TblAccess::find()->where(['id' => $id])->one(); 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
        if ($model->load(Yii::$app->request->post())) { 
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['msiso/akses']); 
        }

        return $this->render('update_akses', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]); 
    }  

    public function actionTambahAuditor()
    { 
        $model = new Msiso();
        $icno = Yii::$app->user->getId();
        
        $query = Msiso::find()->where(['status' => 1]); 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
         if ($model->load(Yii::$app->request->post())) { 
            $staff = Tblprcobiodata::find()->where(['ICNO' => $model->icno])->one();
            $check = Msiso::find()->where(['icno' => $model->icno])->andwhere(['isActive' => 1])->one();
            if($check){
                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Maklumat telah wujud.']);
                return $this->redirect(['msiso/tambah-auditor']);
            } 
                $model->name = $staff->CONm;
                $model->dept = $staff->department->shortname;
                $model->status = 1;
                $model->isActive = 1;
                $model->updated_dt =  date('Y-m-d');
                $model->updated_by = $icno;
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/tambah-auditor']);
            }
        return $this->render('tambah_auditor', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]); 
    }  
   
    public function actionOfiGeneral($id)
    { 
        $icno = Yii::$app->user->getId(); 
        $data = $this->findLokasi($id);
        $staff = $this->findBiodata($icno);  
        $biodata = $this->findBiodata($this->ICNO()); 
        $model = new TblOfi(); 
        $model->rujukan_fail = 'ISO9001:2015';
        $current_year = date('Y'); 
   
         if ($model->load(Yii::$app->request->post())) {    
            if (Yii::$app->request->post('simpan')){  

                $model->status = '2'; //1=hantar, 2=simpan,  
                $auditPlan = Notifyaudit::find()->where(['dept' => $data->dept])->one(); 
                // $model->parent_id = $auditPlan->id;
                $model->rujukan_fail = 'ISO9001:2015';
                $model->dept = $data->dept;
                $model->status_tindakan = '2'; //1=selesai/dipersetujui, 2=menunggu tindakan, 3=kemaskini, 4=selesai kemaskini
                $model->entry_dt = date('Y-m-d');
 
                $model->auditor_name = $biodata->CONm;
                $model->auditor_icno = $biodata->ICNO;
                $model->year = date('Y'); 
                $model->deptId = $data->deptId;

                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/senarai-report']); 
            }elseif(Yii::$app->request->post('hantar')){
                $auditPlan = Notifyaudit::find()->where(['dept' => $data->dept])->one(); 
                // $model->parent_id = $auditPlan->id;
                $model->rujukan_fail = 'ISO9001:2015';
                $model->dept = $data->dept;
                $model->auditor_name = $staff->CONm;
                $model->auditor_icno = $staff->ICNO;
                $model->year = date('Y'); 
                $model->entry_dt = date('Y-m-d'); 
                $model->status = '1';  //1=hantar, 2=simpan,
                $model->status_tindakan = '2'; //1=selesai/dipersetujui, 2=menunggu tindakan, 3=kemaskini, 4=selesai kemaskini
                $model->deptId = $data->deptId;

                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar.']);
                return $this->redirect(['msiso/senarai-report']); 
            } 
            }

        return $this->render('form_ofi', [
            'model' => $model, 
            'data' => $data,
            'biodata' =>  $biodata,  
        ]); 
    }  

    public function actionKemaskiniOfi($id)
    { 
        $icno = Yii::$app->user->getId();  
        $model = $this->findOfi($id);
        // $data = $this->findLokasi($id);
        $biodata = $this->findBiodata($this->ICNO());   

        if ($model->load(Yii::$app->request->post()) ) {
            if (Yii::$app->request->post('simpan')){   
                
                $model->status_tindakan = '2'; //1=selesai/dipersetujui, 2=menunggu tindakan, 3=kemaskini, 4=selesai kemaskini  
                $model->save(false);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/senarai-report']); 

            }elseif(Yii::$app->request->post('hantar')){

                if($model->status_tindakan == '3'){ 
                    $chief = Department::findOne(['shortname' => $model->dept]);
                    $kp =  Department::findOne(['shortname' => $model->dept]);
          
                $model->tindakan_bengkel = 'TELAH DIKEMASKINI'; 
                $model->status_tindakan = '5';  
                $model->status = '1';  //1=hantar, 2=simpan, 
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar.']);
                return $this->redirect(['msiso/senarai-report']); 

                }else{
                $model->status = '1';   
                $model->status_tindakan = '2';   
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar.']);
                return $this->redirect(['msiso/senarai-report']); 
                }
            }
        } 
        return $this->render('update_form_opi', [
            'model' => $model, 
            // 'data' => $data,
            'biodata' =>  $biodata,
        ]); 
    } 
  
    public function actionPaparanOfi($id)
    { 
        $model = $this->findOfi($id);  
        
        return $this->render('view_form_opi', [
            'model' => $model,   
        ]);
    } 

    public function actionNcrForm($id)
    { 
        $icno = Yii::$app->user->getId();  
        $data = $this->findLokasi($id);
        $biodata = $this->findBiodata($this->ICNO());  
        $model = new TblNcr(); 
        $model->rujukan_fail = 'ISO9001:2015';
        $current_year = date('Y');
 
         if ($model->load(Yii::$app->request->post())) {   
            if (Yii::$app->request->post('simpan')){  
                $auditee = Tblprcobiodata::find()->where(['ICNO' => $model->auditee_icno])->one(); 
                $auditPlan = Notifyaudit::find()->where(['dept' => $data->dept])->one(); 
               
                $model->auditor = $biodata->CONm;
                $model->auditor_icno = $biodata->ICNO;
                $model->dept = $data->dept;
                $model->rujukan_fail = 'ISO9001:2015';
                $model->entry_dt = date('Y-m-d');
                $model->auditee = $auditee->CONm;
                $model->year = date('Y');
                $model->status_semasa = '2'; //1=hantar, 2=simpan,  
                $model->deptId = $data->deptId;
                $model->status_tindakan = '2'; //1=selesai/dipersetujui, 2=menunggu tindakan, 3=kemaskini, 4=auditee, 

                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/senarai-report']);  
            }elseif(Yii::$app->request->post('hantar')){
                $auditee = Tblprcobiodata::find()->where(['ICNO' => $model->auditee_icno])->one(); 
                $auditPlan = Notifyaudit::find()->where(['dept' => $data->dept])->one(); 
              
                $model->auditor = $biodata->CONm;
                $model->auditor_icno = $biodata->ICNO;
                $model->dept = $data->dept;
                $model->rujukan_fail = 'ISO9001:2015';
                $model->entry_dt = date('Y-m-d');
                $model->auditee = $auditee->CONm;
                $model->year = date('Y'); 
                $model->deptId = $data->deptId; 
                $model->status_semasa = '1';  //1=hantar, 2=simpan,
                $model->status_tindakan = '2'; //1=selesai/dipersetujui, 2=menunggu tindakan, 3=kemaskini, 4=selesai kemaskini
             
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar.']);
                return $this->redirect(['msiso/senarai-report']);  
            } 
            }

        return $this->render('form_ncr', [
            'model' => $model, 
            'data' => $data,
            'biodata' =>  $biodata,
        ]); 
    }  
  
    public function actionPaparanNcr($id)
    { 
        $model = $this->findNcr($id);  
        $biodata = $this->findBiodata($this->ICNO());
        return $this->render('view_form_ncr', [
            'model' => $model,  
            'biodata' => $biodata,
        ]);
    } 

    public function actionNotificationLetter()
    {
        $icno = Yii::$app->user->getId();     
        $model = new Notifyaudit();   
        $modell = new msiso();
        $query = Notifyaudit::find()->orderBy(['created_dt' => SORT_DESC]);
      
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
 
        if ($model->load(Yii::$app->request->post())) {    

            $data = Department::findOne(['shortname' => $model->dept]);
           
            $chief = Department::findOne(['shortname' => $model->dept]);
            $kp =  Department::findOne(['shortname' => $model->dept]);
 
            $ntf = new Notification();
            $ntf2 = new Notification(); 

            $ntf->icno = $chief->chief; // ketua jabatan
            $ntf->title = 'ISO AUDIT DALAM';
            $ntf->content = "Pemakluman Aktiviti Audit Dalam MS ISO 9001:2015.".Html::a('<i class="fa fa-arrow-right"></i>', ['msiso/index'], ['class'=>'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false); 

            $ntf2->icno = $kp->pp; // ketua pentadbiran
            $ntf2->title = 'ISO AUDIT DALAM';
            $ntf2->content = "Pemakluman Aktiviti Audit Dalam MS ISO 9001:2015.".Html::a('<i class="fa fa-arrow-right"></i>', ['msiso/index'], ['class'=>'btn btn-primary btn-sm']);
            $ntf2->ntf_dt = date('Y-m-d H:i:s');
            $ntf2->save(false);   

            $model->iso_audit = 'ISO9001:2015';
            $model->created_by = $icno;
            $model->created_dt = date('Y-m-d H:i:s');
            $model->year = date('Y');
            $model->status = '1';
            $model->chief = $chief->chief;
            $model->pp = $kp->pp;
            $model->deptId = $data->id;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['msiso/notification-letter']); 
        }
        
        return $this->render('form_notification_letter', [
            'model' => $model,  
            'dataProvider' => $dataProvider, 
        ]);
    }

    public function actionAuditPlan()
    { 
        $model = new AuditPlan();   
        $icno = Yii::$app->user->getId();   
        $file = UploadedFile::getInstance($model, 'file');
        $query = AuditPlan::find()->where(['status' => 1])->orderBy(['created_dt' => SORT_DESC]);

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if($model->load(Yii::$app->request->post())){
       
        $chief = Department::find()->where(['isActive' => '1'])->andwhere(['IS NOT', 'chief', null])->groupBy('chief')->all();

        $kp = Department::find()->where(['isActive' => '1'])->andwhere(['IS NOT', 'pp', null])->groupBy('pp')->all(); 
        
        foreach($chief as $chief){ 
          $this->notification($chief->chief,  "Pemakluman Aktiviti Audit Dalam MS ISO 9001:2015.".Html::a('<i class="fa fa-arrow-right"></i>', ['msiso/index'], ['class'=>'btn btn-primary btn-sm']));  
 
        }

        foreach($kp as $kp){ 
          $this->notification($kp->pp,  "Pemakluman Aktiviti Audit Dalam MS ISO 9001:2015.".Html::a('<i class="fa fa-arrow-right"></i>', ['msiso/index'], ['class'=>'btn btn-primary btn-sm']));  

        } 
            if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'audit_plan');
                $filepath = $fileapi->file_name_hashcode;      
           }
            else{
                $filepath = '';
            }
 
            $model->audit_plan = $filepath; 
            $model->created_by = $icno;
            $model->created_dt =  date('Y-m-d');
            $model->year = date('Y');
            $model->status = 1;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
            return $this->redirect(['msiso/audit-plan']);
        }

        return $this->render('form_audit_plan', [
            'model' => $model,  
            'dataProvider' => $DataProvider, 
        ]);
    } 
 
    public function actionUpdateAuditor($id)
    { 
        $icno = Yii::$app->user->getId(); 
 
        $model = $this->findModel($id);
        $query = msiso::find()->where(['id' => $id])->one(); 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['msiso/tambah-auditor']);
        }

        return $this->render('update_auditor', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
        
    } 

    public function actionUpdatePlan($id)
    {  
        $model = $this->findPlan($id);
        $query = AuditPlan::find()->where(['id' => $id])->one(); 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 

        if ($model->load(Yii::$app->request->post())) { 
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['msiso/audit-plan']); 
        }

        return $this->render('update_plan', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]); 
    }  

    public function actionReplaceAuditPlan($id)
    {
        $record = $this->findPlan($id);
        $model = new AuditPlan();   
        
        $icno = Yii::$app->user->getId();   
        $file = UploadedFile::getInstance($model, 'file');
        $query = AuditPlan::find()->orderBy(['created_dt' => SORT_DESC]);

        $data = AuditPlan::find()->where(['id' => $id])->one();

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if($model->load(Yii::$app->request->post())){ 
            
            if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'audit_plan');
                $filepath = $fileapi->file_name_hashcode;      
           }
            else{
                $filepath = '';
            } 
            $model->audit_plan = $filepath; 
            $model->created_by = $icno;
            $model->created_dt =  date('Y-m-d');
            $model->year = date('Y');
            $model->status = 1;
            $model->parent_id = $data->id;
            $data->status = 0;
            $data->save(false);
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['msiso/audit-plan']);
        }

        return $this->render('form_replace_audit_plan', [
            'model' => $model,  
            'dataProvider' => $DataProvider,
            'record' => $record, 
        ]);
    } 

    public function actionSenaraiAuditPlan()
    { 
        $query = AuditPlan::find()->where(['status' => 1])->orderBy(['created_dt' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('view_senarai_audit_plan', [ 
            'dataProvider' => $dataProvider,
            'bil' => 1,
        ]);
    } 
 
    public function actionPaparanNotification($id)
    { 
        $model = $this->findNotify($id);  
        $current_year = date('Y');
        $query = RefAuditorDept::find()->where(['dept' => $model->dept])->andwhere(['year' => $current_year]); 
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 

        return $this->render('view_form_notification', [
            'model' => $model,  
            'dataProvider' => $dataProvider,  
        ]);
    }

    public function actionKemaskiniLetter($id)
    { 
        $model = $this->findNotify($id);  
        $current_year = date('Y');
        $query = RefAuditorDept::find()->where(['dept' => $model->dept])->andwhere(['year' => $current_year]); 
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 

        return $this->render('update_notify_letter', [
            'model' => $model,  
            'dataProvider' => $dataProvider,   
        ]);
    }

    public function actionKemaskiniNotification($id)
    { 
        $model = $this->findNotify($id);  
        $query = NotifyAudit::find()->where(['parent_id' => $model->id]); 
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if($model->load(Yii::$app->request->post())){  
            
            $model->save(false); 
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['msiso/notification-letter']);
        } 
        return $this->render('update_notification', [
            'model' => $model,  
            'dataProvider' => $dataProvider,  
        ]);
    }

    public function actionNotifyAuditor($id)
    {   
        $models = $this->findRefNotify($id); 
        $model = new Refnotifyaudit();
        $query = Refnotifyaudit::find()->where(['id' => $id])->one(); 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
      
        if ($model->load(Yii::$app->request->post())) {

            $data = msiso::find()->where(['icno' => $model->icno])->one();  
            
            $model->parent_id = $models->id;
            $model->name = $data->name;
            $model->audit_role = $data->audit_role;

            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['msiso/kemaskini-letter','id' => $models->id]); 
        }

        return $this->render('update_notify_auditor', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]); 
    }  

    public function actionNotaAudit($id)
    { 
        $model = new TblNotaAudit(); 
        $icno = Yii::$app->user->getId(); 
        $file = UploadedFile::getInstance($model, 'file');
        $dept = $this->findLokasi($id);
        $staff = $this->findBiodata($this->ICNO());
        $model->standard = 'MS ISO 9001:2015';
        $model->rujukan_fail = 'ISO9001:2015';

         if ($model->load(Yii::$app->request->post())) {  
          
            $data = msiso::find()->where(['name' => $model->auditee_name])->one();  
            $data2 = msiso::find()->where(['name' => $model->auditor_name])->one();   
            $auditPlan = Notifyaudit::find()->where(['dept' => $dept->dept])->one();
            $auditee = Tblprcobiodata::find()->where(['ICNO' => $model->auditee_by])->one(); 
           
            if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'attachment');
                $filepath = $fileapi->file_name_hashcode;      
           }
            else{
                $filepath = '';
            } 
                $model->attachment = $filepath; 
                $model->standard = 'MS ISO 9001:2015';
                $model->rujukan_fail = 'ISO9001:2015';
                $model->dept = $dept->dept; 
                $model->auditee_dt = date('Y-m-d'); 
                $model->created_dt =  date('Y-m-d');
                $model->created_by = $icno;
                $model->auditor_name = $staff->CONm; 
                $model->auditor_by = $staff->ICNO;  
                $model->auditor_dt = date('Y-m-d');
                $model->status = '1';
                $model->year = date('Y');

                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/senarai-report']);
         
        }
        return $this->render('form_nota_audit', [
            'model' => $model, 
            'dept' => $dept,
            'staff' => $staff,
        ]); 
    } 
    public function actionIndexReport()
    {
        $icno = Yii::$app->user->getId();  

        $current_year = date('Y');  
        $model = RefAuditorDept::find()->where(['icno' => $icno])->orderBy(['year' =>SORT_DESC]) ->all();  
         
        return $this->render('index_report', [
        'model' => $model,
        'bil' => 1,  
        ]);
    } 

    public function actionSenaraiReport() {
         
        $icno = Yii::$app->user->getId();  
        $current_year = date('Y');

        $senarai = TblOfi::find()->where(['auditor_icno' => $icno, 'year' => $current_year])->orderBy(['tarikh_audit' => SORT_DESC]);
        $title = 'OFI';
        
         $senarais = new ActiveDataProvider([
          'query' => $senarai,
          'pagination' => [
              'pageSize' => 10,
          ],
      ]);
  
       $query = TblNcr::find()->where(['auditor_icno' => $icno, 'year' => $current_year])->orderBy(['entry_dt' => SORT_DESC]);  
       $DataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 10,
        ],
        ]);  

        $nota = TblNotaAudit::find()->where(['auditor_by' => $icno, 'year' => $current_year])->orderBy(['created_dt' => SORT_DESC]);  
        $lists = new ActiveDataProvider([
            'query' => $nota,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        $query2 = TblBestPractice::find()->where(['created_by' => $icno, 'year' => $current_year])->orderBy(['created_dt' => SORT_DESC]);  
        $practice = new ActiveDataProvider([
            'query' => $query2,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
      
        return $this->render('senarai_audit_report', [
            'dataProvider' => $DataProvider,
            'senarai' => $senarais,
            'list' => $lists, 
            'practice' => $practice,
        ]);
    } 
///temp view notification letter cqa
    public function actionLetter()
    {  
        // view senarai notifiy letter
        $titles = 'Notification Letter';
        $senarai = Notifyaudit::find()->orderBy(['created_dt' => SORT_DESC]);
      
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
        ]);
       
        return $this->render('senarai_notification_letter_cqa', [ 
            'senarai' => $senarais,
            
            'bil' => 1,
        ]);
    } 

    public function actionLokasiAuditor()
    { 
        $icno = Yii::$app->user->getId();
        $model = new RefAuditorDept(); 
        $current_year = date('Y');
        $query = RefAuditorDept::find()->where(['isActive' => 1])->andwhere(['year' => $current_year]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
         if ($model->load(Yii::$app->request->post())) { 
           
            $data = Department::findOne(['shortname' => $model->dept]); 
                $model->year = date('Y');
                $model->isActive = 1;
                $model->updated_dt =  date('Y-m-d');
                $model->updated_by = $icno;
                $model->deptId = $data->id;
                
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/lokasi-auditor']);
            }

            isset(Yii::$app->request->queryParams['icno'])? $DataProvider->query->andFilterWhere
            (['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';
 
        return $this->render('lokasi_auditor', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
      
    }  

    public function actionKemaskiniLokasi($id)
    {  
        $model = $this->findLokasi($id); 

        if ($model->load(Yii::$app->request->post())) {
            
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['msiso/lokasi-auditor']); 
        }

        return $this->render('update_lokasi_auditor', [
            'model' => $model, 
        ]); 
    }  

    public function actionAuditeeReport() {
         
        $icno = Yii::$app->user->getId();  
        $current_year = date('Y');
        $biodata = $this->findBiodata($this->ICNO()); 
        $ncrAuditee = TblNcr::find()->where(['auditee_icno' => $icno])->andwhere(['year' => $current_year])->exists();
        $senarai = TblNcr::find()->where(['auditee_icno' => $icno, 'year' => $current_year])->andwhere(['dept' => $biodata->department->shortname, 'status_tindakan' => ['4','5','1']])->orderBy(['tarikh_audit' => SORT_DESC]);
        $title = 'Nonconformity Report (NCR)';
        if(!$ncrAuditee ){ 
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada mempunyai akses. Sila berhubung dengan Pusat Jaminan Kualiti, Jabatan Pendaftar.']);
            return $this->redirect(['msiso/main']); 
        }
         $senarais = new ActiveDataProvider([
          'query' => $senarai,
          'pagination' => [
              'pageSize' => 10,
          ],
      ]); 
        return $this->render('ncr_auditee_report', [  
            'senarai' => $senarais,
            'bil' => 1,
        ]);
    } 
    public function actionTindakan($id) {
         
        $icno = Yii::$app->user->getId();  
        $current_year = date('Y');
        $biodata = $this->findBiodata($this->ICNO()); 
        $model = $this->findNcr($id);
        $model->auditee_dt =  date('Y:m:d H:m:s'); 
        
        $senarai = TblNcr::find()->where(['auditee_icno' => $icno, 'year' => $current_year])->andwhere(['dept' => $biodata->department->shortname])->orderBy(['tarikh_audit' => SORT_DESC]);
        $title = 'NCR';
        
         $senarais = new ActiveDataProvider([
          'query' => $senarai,
          'pagination' => [
              'pageSize' => 10,
          ],
      ]); 
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->post('simpan')){   
                $model->status_semasa = '2'; //1=hantar, 2=simpan,   
                $model->save(false); 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/auditee-report']); 

            }elseif(Yii::$app->request->post('hantar')){  
                $model->status_semasa = '1';  //1=hantar, 2=simpan,
                $model->status_tindakan = '5'; //1=selesai/dipersetujui, 2=menunggu tindakan, 3=kemaskini, 4=selesai kemaskini 

                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar.']);
                return $this->redirect(['msiso/auditee-report']);  
            } 
        } 
        return $this->render('ncr_tindakan_auditee', [  
            'model' => $model,
            'biodata' => $biodata,
            'senarai' => $senarais,
            'bil' => 1,
        ]);
    } 

    public function actionPaparanAuditee($id)
    { 
        $model = $this->findNcr($id);  
        
        return $this->render('paparan_auditee', [
            'model' => $model,   
        ]);
    } 
    public function actionKemaskiniNcr($id)
    {   
        $model = $this->findNcr($id);
        $biodata = $this->findBiodata($this->ICNO());
        $model->ver_dt = date('Y:m:d H:m:s'); 
        if ($model->load(Yii::$app->request->post())) {   

            if (Yii::$app->request->post('simpan')){    
                $model->status_semasa = '2'; //1=hantar, 2=simpan,   
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/senarai-report']);  

            }elseif(Yii::$app->request->post('hantar')){

                if($model->status_tindakan == '2'){ 
                    $model->status_semasa = '1';
                    $model->save(false);
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar.']);
                    return $this->redirect(['msiso/senarai-report']);
                }

                elseif($model->status_tindakan == '3'){  
                    $model->status_tindakan = '7';
                    $model->status_semasa = '1';
                    $model->tindakan_bengkel = 'TELAH DIKEMASKINI';
                    $model->save(false);
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar.']);
                    return $this->redirect(['msiso/senarai-report']);

                }elseif($model->status_tindakan == '5'){
                    $model->status_semasa = '1';  //1=hantar, 2=simpan,
                    $model->status_tindakan = '6';   // 1=selesai/dipersetujui, 2=menunggu tindakan, 3=kemaskini, 4=auditee, 5=auditor, 6=admin 
                    $model->save(false);
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar.']);
                    return $this->redirect(['msiso/senarai-report']); 
                } 
            } 
        } 
        return $this->render('update_form_ncr', [
            'model' => $model,
            'biodata' => $biodata,
        ]); 
    }  
    public function actionPadam(){
        return Yii::$app->FileManager->DeleteFile('');//insert the code 
    }   
    public function actionBestPractice($id)
    { 
        $model = new TblBestPractice(); 
        $icno = Yii::$app->user->getId(); 
        $file = UploadedFile::getInstance($model, 'file'); 
        $dept = $this->findLokasi($id);
        $model->rujukan_fail = 'ISO9001:2015';

         if ($model->load(Yii::$app->request->post())) {    

            $auditPlan = Notifyaudit::find()->where(['dept' => $dept->dept])->one(); 

            if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'attachment');
                $filepath = $fileapi->file_name_hashcode;      
           }
            else{
                $filepath = '';
            } 
                $model->attachment = $filepath;  
                $model->rujukan_fail = 'ISO9001:2015';
                $model->dept = $dept->dept;
                $model->year = date('Y');
                $model->created_by = $icno;
                $model->created_dt =  date('Y-m-d'); 
                $model->status = '1';

                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/senarai-report']);
            }

        return $this->render('form_best_practice', [
            'model' => $model, 
            'dept' => $dept,
        ]); 
    } 
    public function actionPaparanBestPractice($id)
    { 
        $model = $this->findBestPractice($id);   
        return $this->render('view_form_best_practice', [
            'model' => $model,  
            
        ]);
    } 
    public function actionKemaskiniBestPractice($id)
    { 
        $icno = Yii::$app->user->getId();  
        $model = $this->findBestPractice($id);
        $data = $this->findLokasi($id);
        $biodata = $this->findBiodata($this->ICNO());   

        if ($model->load(Yii::$app->request->post()) ) {
            
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dikemaskini.']);
            return $this->redirect(['msiso/senarai-report']);
        } 
        return $this->render('update_best_practice', [
            'model' => $model, 
            'data' => $data,
            'biodata' =>  $biodata,
        ]); 
    } 

    public function actionPaparanNotaAudit($id)
    { 
        $model = $this->findNotaAudit($id);   
        return $this->render('view_form_nota_audit', [
            'model' => $model,   
        ]);
    } 
    public function actionKemaskiniNotaAudit($id)
    { 
        $icno = Yii::$app->user->getId();  
        $model = $this->findNotaAudit($id);
        $data = $this->findLokasi($id);
        $biodata = $this->findBiodata($this->ICNO());   

        if ($model->load(Yii::$app->request->post()) ) {
            
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dikemaskini.']);
            return $this->redirect(['msiso/senarai-report']);
        } 
        return $this->render('update_nota_audit', [
            'model' => $model, 
            'data' => $data,
            'biodata' =>  $biodata,
        ]); 
    } 

    public function actionMakluman($id)
        {  
            //  $css = file_get_contents('./css/esurat.css');
            #cehck application
            $model = $this->findNotify($id);
            $icno = Yii::$app->user->getId();   
            $current_year = date('Y');
            $notify = NotifyAudit::find()->where(['year' => $current_year])->one();
            $auditor = RefAuditorDept::find()->where(['dept' => $model->dept])->andwhere(['year' => $current_year])->all(); 
            $query = RefAuditorDept::find()->where(['dept' => $model->dept])->andwhere(['year' => $current_year]); 
        
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]); 
    
            //     get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('makluman', ['model' => $model, 'notify' => $notify, 'auditor' => $auditor, 'dataProvider' => $dataProvider, 'bil' => 1]);
            // setup kartik\mpdf\Pdf component
            $pdf = new Pdf([
                // set to use core fonts only
                'mode' => Pdf::MODE_CORE,
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
                'options' => ['title' => 'Laporan Kehadiran Bulanan'],
                // call mPDF methods on the fly
                  'marginTop' => 20,
    //             'marginBottom' => 35,
                'marginLeft' => 24,
                'marginRight' => 24,
                'methods' => [
                // 'SetHeader' => ['SURAT PENEMPATAN'],
                // 'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                // 'WriteHTML' => [$css, 1]
    //          'SetFooter' => [' {PAGENO}'],
                ]
            ]);
            // return the pdf output as per the destination setting
            return $pdf->render();
        }

        public function actionOfiJabatan() {
         
            $icno = Yii::$app->user->getId();  
            $current_year = date('Y'); 
            $biodata = $this->findBiodata($this->ICNO()); 
            $kj = Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->one();  
            $access = [711018125401];
            $chief = Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->exists();  

            if(Department::find()->where(['chief' => $icno, 'id' => '135'])->exists()){
            $senarai = TblOfi::find()->where(['deptId' => $biodata->DeptId ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4']])->orderBy(['tarikh_audit' => SORT_DESC]);
            $title = 'Opportunities for Improvement (OFI)';

            }
            elseif(Department::find()->where(['chief' => $icno, 'id' => '196'])->exists()){
                $senarai = TblOfi::find()->where(['deptId' => $kj->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4']])->orderBy(['tarikh_audit' => SORT_DESC]);
                $title = 'Opportunities for Improvement (OFI)';
            }
            elseif(Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->exists()){
                $senarai = TblOfi::find()->where(['deptId' => $kj->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4']])->orderBy(['tarikh_audit' => SORT_DESC]);
                $title = 'Opportunities for Improvement (OFI)';
            }
            if(!$chief ){ 
                // Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada mempunyai akses. Sila berhubung dengan Pusat Jaminan Kualiti, Jabatan Pendaftar.']);
                return $this->redirect(['msiso/ofi-ketua-pentadbiran']); 
            }
             $senarais = new ActiveDataProvider([
              'query' => $senarai,
              'pagination' => [
                  'pageSize' => 10,
              ],
          ]); 
            return $this->render('ofi_dept_report', [  
                'senarai' => $senarais,
                'bil' => 1,
            ]);
        } 
        
        public function actionOfiKetuaPentadbiran() {
         
            $icno = Yii::$app->user->getId();  
            $title = '';
            $current_year = date('Y');
            $biodata = $this->findBiodata($this->ICNO());  
            $kp = Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->one();   
            $pp = Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->exists();  
            $tempKP = TblAccess::find()->where(['icno' => $icno])->andwhere(['access_level' => 4, 'isActive' => 1])->one(); //kp tidak dilantik tiada dlm department
          
            if(TblAccess::find()->where(['icno' => $icno])->andwhere(['access_level' => 4, 'isActive' => 1])->exists()){              
               $senarai = TblOfi::find()->where(['deptId' => $biodata->DeptId])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4']])->orderBy(['tarikh_audit' => SORT_DESC]);
                $title = 'Ketua Pentadbiran Kolej'; 
            } 
            elseif(Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->exists()){
                
                $senarai = TblOfi::find()->where(['deptId' => $kp->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4']])->orderBy(['tarikh_audit' => SORT_DESC]);
                $title = 'Ketua Pentadbiran';  
            } 

            if(!$pp && !$tempKP){ 
                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada mempunyai akses. Sila berhubung dengan Pusat Jaminan Kualiti, Jabatan Pendaftar.']);
                return $this->redirect(['msiso/main']); 
            }

             $senarais = new ActiveDataProvider([
              'query' => $senarai,
              'pagination' => [
                  'pageSize' => 10,
              ],
          ]); 
            return $this->render('ofi_ketua_pentadbiran', [  
                'senarai' => $senarais,
                'bil' => 1,
                'tempKP' => $tempKP, 
                'kp' => $kp,               
            ]);
        } 
        public function actionNcrKetuaPentadbiran() {
         
            $icno = Yii::$app->user->getId();  
            $title = '';
            $current_year = date('Y');
            $biodata = $this->findBiodata($this->ICNO());  
            $kp = Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->one();   
            $pp = Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->exists();  
            $tempKP = TblAccess::find()->where(['icno' => $icno])->andwhere(['access_level' => 4, 'isActive' => 1])->one(); //kp tidak dilantik tiada dlm department
          
            if(TblAccess::find()->where(['icno' => $icno])->andwhere(['access_level' => 4, 'isActive' => 1])->exists()){              
               $senarai = TblNcr::find()->where(['deptId' => $biodata->DeptId])->andwhere(['year' => $current_year,'status_tindakan' =>['1','4','5','6']])->orderBy(['tarikh_audit' => SORT_DESC]);
                $title = 'Ketua Pentadbiran Kolej'; 
            } 
            elseif(Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->exists()){
                
                $senarai = TblNcr::find()->where(['deptId' => $kp->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4','5','6']])->orderBy(['tarikh_audit' => SORT_DESC]);
                $title = 'Ketua Pentadbiran';  
            } 

            if(!$pp && !$tempKP){ 
                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada mempunyai akses. Sila berhubung dengan Pusat Jaminan Kualiti, Jabatan Pendaftar.']);
                return $this->redirect(['msiso/main']); 
            }

             $senarais = new ActiveDataProvider([
              'query' => $senarai,
              'pagination' => [
                  'pageSize' => 10,
              ],
          ]); 
            return $this->render('ncr_ketua_pentadbiran', [  
                'senarai' => $senarais,
                'bil' => 1,
                'tempKP' => $tempKP,  
                'kp' => $kp,               
            ]);
        } 

        public function actionNcrJabatan() {
         
            $icno = Yii::$app->user->getId();  
            $current_year = date('Y');
            $biodata = $this->findBiodata($this->ICNO()); 
            $access = [ 711018125401];

            $chief = Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->one();  
            $kj = Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->one();  
    
            if(Department::find()->where(['chief' => $icno, 'id' => '135'])->exists()){
           
                $senarai = TblNcr::find()->where(['deptId' => $biodata->DeptId, ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4','5','6']])->orderBy(['tarikh_audit' => SORT_DESC]);
                $title = 'NCR (NON-CONFORMITY REPORT)';
            }
            elseif(Department::find()->where(['chief' => $icno, 'id' => '196'])->exists()){
                $senarai = TblNcr::find()->where(['deptId' => $kj->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4','5','6']])->orderBy(['tarikh_audit' => SORT_DESC]);
                $title = 'NCR (NON-CONFORMITY REPORT)';
            }
            elseif(Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->exists()){
                $senarai = TblNcr::find()->where(['deptId' => $kj->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4','5','6']])->orderBy(['tarikh_audit' => SORT_DESC]);
                $title = 'NCR (NON-CONFORMITY REPORT)';
            }
            if(!$chief && !$pp ){ 
                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada mempunyai akses. Sila berhubung dengan Pusat Jaminan Kualiti, Jabatan Pendaftar.']);
                return $this->redirect(['msiso/main']); 
            }
             $senarais = new ActiveDataProvider([
              'query' => $senarai,
              'pagination' => [
                  'pageSize' => 10,
              ],
          ]); 
            return $this->render('ncr_dept_report', [  
                'senarai' => $senarais,
                'bil' => 1,
            ]);
        }  
        public function actionIndexAuditReport()
        {  
        $current_year = date('Y');    
        return $this->render('index_audit_report', [
        'current_year' => $current_year,
        
        ]);
        } 
        public function actionOfiReport() {
         
            $icno = Yii::$app->user->getId(); 
            $searchModel = new TblOfiSearch(); 
            $current_year = date('Y');
            $model = new TblOfi();
            $query = TblOfi::find()->where(['year' => $current_year])->andwhere([ 'status' => '1'])->orwhere(['status_tindakan' => '4'])->orderBy(['tarikh_audit' => SORT_DESC]) ;
            
             $dataProvider = new ActiveDataProvider([
              'query' => $query,
              'pagination' => [
                  'pageSize' => 10,
              ],
            ]);  
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $selection=(array)Yii::$app->request->post('selection');//typecasting 
           
            if (Yii::$app->request->post('simpan')){ 
                
                foreach ($selection as $id) {

                    $model = $this->findOfi($id); 
                    $chief = Department::findOne(['shortname' => $model->dept]);
                    $kp =  Department::findOne(['shortname' => $model->dept]);

                    if('y'.$id == Yii::$app->request->post($id)){  

                    $model->status_tindakan = '4'; 
                    $this->notification($kp->pp, "Audit Dalam MS ISO 9001:2015 menunggu tindakan daripada anda"." ".Html::a('<i class="fa fa-arrow-right"></i>', ['msiso/ofi-jabatan'], ['class'=>'btn btn-primary btn-sm']));
                    $this->notification($chief->chief, "Audit Dalam MS ISO 9001:2015 menunggu tindakan daripada anda"." ".Html::a('<i class="fa fa-arrow-right"></i>', ['msiso/ofi-jabatan'], ['class'=>'btn btn-primary btn-sm']));

                    $model->save(false); 
                    }

                    elseif('n'.$id == Yii::$app->request->post($id)){
                    $model = $this->findOfi($id); 
                    $model->status_tindakan ='5';
                    $model->save(); 
                    } 
            }
        }
            return $this->render('senarai_ofi_report', [ 
                'model' => $model,
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);
        } 
        public function actionNcrReport() {
         
            $icno = Yii::$app->user->getId(); 
            $searchModel = new TblNcrSearch(); 
            $current_year = date('Y');
            
            $query = TblNcr::find()->where(['year' => $current_year, 'status_semasa' => '1'])->orwhere(['status_tindakan' => ['4']])->orderBy(['tarikh_audit' => SORT_DESC]) ;
            $title = 'NCR'; 

            $dataProvider = new ActiveDataProvider([
              'query' => $query,
              'pagination' => [
                  'pageSize' => 10,
              ],
          ]);  
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
          
          $selection=(array)Yii::$app->request->post('selection');//typecasting 
          if (Yii::$app->request->post('simpan')){ 
                
            foreach ($selection as $id) {

                $model = $this->findNcr($id);
                if('y'.$id == Yii::$app->request->post($id)){  

                $model->status_tindakan = '4';  
                $this->notification($model->auditee_icno, "Audit Dalam MS ISO 9001:2015 menunggu tindakan daripada anda"." ".Html::a('<i class="fa fa-arrow-right"></i>', ['msiso/auditee-report'], ['class'=>'btn btn-primary btn-sm']));
                
                $model->save(false);
                
                }
                elseif('n'.$id == Yii::$app->request->post($id)){
                $model = $this->findNcr($id); 
                $model->status_tindakan ='7';
                $model->save(); 
                } 
        }
    }
          return $this->render('senarai_ncr_report', [ 
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel, 
            ]);
        } 

        public function actionTindakanBengkelOfi($id) {
         
            $icno = Yii::$app->user->getId();  
            $current_year = date('Y');
            $biodata = $this->findBiodata($this->ICNO()); 
            $model = $this->findOfi($id); 
            $senarai = TblOfi::find()->where(['auditee_icno' => $icno, 'year' => $current_year])->andwhere(['dept' => $biodata->department->shortname, 'status_tindakan' => '4'])->orderBy(['tarikh_audit' => SORT_DESC]);
            $title = 'NCR';
            $model->tarikh_bengkel = date('Y-m-d H:i:s');
            $senarais = new ActiveDataProvider([
              'query' => $senarai,
              'pagination' => [
                  'pageSize' => 10,
              ],
            ]); 
            if ($model->load(Yii::$app->request->post())) {

                if($model->tindakan_bengkel == ''){
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']);  
                }
                elseif($model->tindakan_bengkel == 'PERLU KEMASKINI'){
                    $model->status_tindakan = '3'; // 1=selesai/dipersetujui, 2=menunggu tindakan, 3=kemaskini, 4=selesai kemaskini
                    $model->updated_by = $icno;
                    $model->updated_at = date('Y:m:d');
                    $model->tarikh_bengkel = date('Y:m:d'); 
                    $model->save(false);
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                    return $this->redirect(['msiso/ofi-report']); 
                }
                elseif($model->tindakan_bengkel == 'DIPERSETUJUI'){  
                $chief = Department::findOne(['shortname' => $model->dept]);
                $kp =  Department::findOne(['shortname' => $model->dept]); 

                $model->updated_by = $icno;
                $model->updated_at = date('Y:m:d');
                $model->tarikh_bengkel = date('Y:m:d');  
                $model->status_tindakan = '5'; //1=selesai/dipersetujui, 2=menunggu tindakan, 3=kemaskini, 4=auditee

                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/ofi-report']); 
                }
            } 
            return $this->render('form_bengkel_ofi', [  
                'model' => $model,
                'biodata' => $biodata,
                'senarai' => $senarais, 
                'bil' => 1,
            ]);
        } 
    public function actionCompleteReportOfi($id)
    { 
        $model = $this->findOfi($id);   
        return $this->render('view_done_ofi', [
            'model' => $model,   
        ]);
    } 
    public function actionTindakanAuditeeDept($id) {
         
        $icno = Yii::$app->user->getId();  
        $current_year = date('Y');
        $biodata = $this->findBiodata($this->ICNO()); 
        $model = $this->findOfi($id); 
        
        $model->dept_auditee_dt = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->post('simpan')){   
                $model->status = '2'; //1=hantar, 2=simpan,  
                $model->icno_auditee_dept = $icno;   
                $model->save(false); 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/ofi-jabatan']);

            }elseif(Yii::$app->request->post('hantar')){ 

                $model->status = '1';   
                $model->status_tindakan = '1';  
                $model->icno_auditee_dept = $icno;    
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/ofi-jabatan']); 
            } 
        } 
        return $this->render('form_auditee_dept', [  
            'model' => $model,
            'biodata' => $biodata,  
        ]);
    }  
    public function actionPaparanOfiJabatan($id)
    { 
        $model = $this->findOfi($id);   

        return $this->render('view_dept_ofi', [
            'model' => $model,   
            
        ]);
    }  
    public function actionTindakanBengkelNcr($id) {
         
        $icno = Yii::$app->user->getId();  
        $current_year = date('Y');
        $biodata = $this->findBiodata($this->ICNO()); 
        $model = $this->findNcr($id);
        $data = $this->findLokasi($id);
        $senarai = TblNcr::find()->where(['auditee_icno' => $icno, 'year' => $current_year])->andwhere(['dept' => $biodata->department->shortname, 'status_tindakan' => '4'])->orderBy(['tarikh_audit' => SORT_DESC]);
        $title = 'NCR';
        $model->tarikh_bengkel = date('Y-m-d');
        $senarais = new ActiveDataProvider([
          'query' => $senarai,
          'pagination' => [
              'pageSize' => 10,
          ],
        ]); 
        if ($model->load(Yii::$app->request->post())) {

            if($model->tindakan_bengkel == ''){
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
             
            }
            elseif($model->tindakan_bengkel == 'PERLU KEMASKINI'){
                $model->status_tindakan = '3'; // 1=selesai/dipersetujui, 2=menunggu tindakan, 3=kemaskini, 4=auditee, 5=auditor, 6=admin - ncr, 7 = MENUNGGU TINDAKAN (NOTIFIKASI)
                $model->bengkel_by = $icno;
                $model->tarikh_bengkel =  date('Y:m:d H:m:s');
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/ncr-report']); 
            }
            elseif($model->tindakan_bengkel == 'DIPERSETUJUI'){   
               
                $model->bengkel_by = $icno; 
                $model->tarikh_bengkel =  date('Y:m:d H:m:s'); 
                $model->status_tindakan = '7';   
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                return $this->redirect(['msiso/ncr-report']); 
                }
        } 
        return $this->render('form_bengkel_ncr', [  
            'model' => $model,
            'biodata' => $biodata,
            'senarai' => $senarais,
            'data' => $data,
            'bil' => 1,
        ]);
    } 
    public function actionTindakanVerify($id) {
         
        $icno = Yii::$app->user->getId();  
        $current_year = date('Y');
        $biodata = $this->findBiodata($this->ICNO()); 
        $model = $this->findNcr($id);
        $data = $this->findLokasi($id);
        $senarai = TblNcr::find()->where(['auditee_icno' => $icno, 'year' => $current_year])->andwhere(['dept' => $biodata->department->shortname, 'status_tindakan' => '4'])->orderBy(['tarikh_audit' => SORT_DESC]);
       
        $model->updated_dt = date('Y-m-d');
        $senarais = new ActiveDataProvider([
          'query' => $senarai,
          'pagination' => [
              'pageSize' => 10,
          ],
        ]); 
        if ($model->load(Yii::$app->request->post())) {
            $model->updated_dt = date('Y:m:d H:m:s');
            $model->updated_by = $icno;
            $model->status_tindakan = '1';
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['msiso/ncr-report']);  
        } 
        return $this->render('form_ncr_verify', [  
            'model' => $model,
            'biodata' => $biodata,
            'senarai' => $senarais,
            'data' => $data,
            'bil' => 1,
        ]);
    } 

    public function actionLaporanOfi() {
         
        $current_year = date('Y');
        $searchModel = new TblOfiSearch();  
        $query = TblOfi::find()->where(['year' => $current_year]) ->orderBy(['deptId' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
       
        $model = TblOfi::find()->where(['year' => $current_year]) ->andwhere([ 'status' => '1'])->orderBy(['deptId' => SORT_DESC])->all() ; 
        $query = TblOfi::find()->where(['year' => $current_year])->andwhere([ 'status' => '1'])->orderBy(['deptId' => SORT_DESC])->groupBy('deptId') ; 
        
        $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 10,
        ],
        ]);  
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 
        return $this->render('laporan_ofi', [ 
            'dataProvider' => $dataProvider, 
            'model' => $model,
            'models' => $models,
            'pages' => $pages,
            'searchModel' => $searchModel, 
        ]);
    }  

    public function actionNcrAuditee($id) { 
        $icno = Yii::$app->user->getId();   
        $biodata = $this->findBiodata($this->ICNO()); 
        $model = $this->findNcr($id);
        $data = $this->findLokasi($id); 

        return $this->render('view_ncr_auditee', [  
            'model' => $model,
            'biodata' => $biodata, 
            'data' => $data, 
        ]);
    }  
    
    public function actionLaporanNcr() {
         
        $current_year = date('Y');
        $searchModel = new TblNcrSearch(); 

        $query = TblNcr::find()->where(['year' => $current_year]) ->orderBy(['deptId' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
       
        $model = TblNcr::find()->where(['year' => $current_year]) ->orderBy(['deptId' => SORT_DESC])->all() ; 
        $query = TblNcr::find()->where(['year' => $current_year]) ->orderBy(['deptId' => SORT_DESC]) ;
        
        $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 10,
        ],
        ]);  
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('laporan_ncr', [ 
            'dataProvider' => $dataProvider, 
            'model' => $model,
            'models' => $models,
            'pages' => $pages,
            'searchModel' => $searchModel, 
        ]);
    }  
    
    public function actionSenaraiNotaAudit() {
        
        $icno = Yii::$app->user->getId(); 
        $searchModel = new TblNotaAuditSearch(); 
        $current_year = date('Y');
        
        $query = TblNotaAudit::find()->where(['year' => $current_year]) ->orderBy(['created_dt' => SORT_DESC]) ;
        $title = 'NOTA AUDIT'; 

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);  
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 
        return $this->render('senarai_nota_audit', [ 
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel, 
        ]);
    } 
    public function actionSenaraiBestPractice() {
        
        $icno = Yii::$app->user->getId(); 
        $searchModel = new TblBestPracticeSearch(); 
        $current_year = date('Y');
        
        $query = TblBestPractice::find()->where(['year' => $current_year])->andWhere(['is not', 'created_by', null]) ->orderBy(['created_dt' => SORT_DESC]) ;
        $title = 'BEST PRACTICE'; 

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);  
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 
        return $this->render('senarai_best_practice', [ 
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel, 
        ]);
    } 
    public function actionStatistikOfi()
    {
        $current_year = date('Y');
        $model = TblOfi::find()
            ->where(['year' => $current_year])
            ->groupBy('dept') 
            ->orderby(['deptId' => SORT_ASC]); 
        
        $totalClause = TblOfi::find()->where(['year' => $current_year])->count(); 
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('statistik_ofi', [
            'dataProvider' => $dataProvider, 
            'totalClause' => $totalClause,  
            // 'year' => date('Y'),
        ]);
    }
    
    public function actionStatistikNcr()
    {
        $current_year = date('Y');
        $model = TblNcr::find()
            ->where(['year' => $current_year])
            ->groupBy('dept') 
            ->orderby(['deptId' => SORT_ASC]); 

        $totalClause = TblNcr::find()->where(['year' => $current_year])->count(); 
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('statistik_ncr', [
            'dataProvider' => $dataProvider, 
            'totalClause' => $totalClause, 
        ]);
    }

    public function actionLaporanBestPractice() {
        
        $current_year = date('Y');
        $searchModel = new TblBestPracticeSearch(); 

        $query = TblBestPractice::find()->where(['year' => $current_year]) ->orderBy(['dept' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
        $model = TblBestPractice::find()->where(['year' => $current_year]) ->orderBy(['dept' => SORT_DESC])->all() ;

        $query = TblBestPractice::find()->where(['year' => $current_year]) ->orderBy(['dept' => SORT_DESC]) ;
        
            $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);  
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('laporan_best_practice', [ 
            'dataProvider' => $dataProvider, 
            'model' => $model,
            'models' => $models,
            'pages' => $pages,
            'searchModel' => $searchModel,

        ]);
    }  

    public function actionSummaryReport()
    {
        // $model = new TblOfi();
        $model = Department::find()
        ->where(['isActive' => '1'])
        ->andWhere(['sub_of' => NULL])
        ->orderby(['shortname' => SORT_ASC]); //list of dept under FPSK are excluded


        $current_year = date('Y');
        // $ofi = TblOfi::find()
        //     ->where(['year' => $current_year])
        //     ->groupBy('dept') 
        //     ->orderby(['deptId' => SORT_ASC]);  
            
        // $dataProvider = new ActiveDataProvider([
        //     'query' => $model,
        //     'pagination' => false,
        // ]);
        //refer to idp coding 
        // $query1 = (new \yii\db\Query()) 
        //             ->select("year, dept, deptId")
        //                ->from('utilities.iso_tbl_ofi')
        //                ->where(['year' => $current_year])
        //                ->groupBy("dept");
                        

        // $query2 = (new \yii\db\Query()) 
        //             ->select("year, dept, deptId")
        //                ->from('utilities.iso_tbl_ncr')
        //                ->where(['year' => $current_year])
        //                ->groupBy("dept");
                        

        // $query1->union($query2, false);//false is UNION, true is UNION ALL

        // $sql = $query1->createCommand()->getRawSql();
        // $sql .= ' ORDER BY deptId ASC' ; 
        // $query = Department::findBySql($sql); 
        
        $dataProvider = new ActiveDataProvider([
            'query' => $model,       
            'pagination' => [
            'pageSize' => 80,
        ],       
        ]);

        $totalOfi = TblOfi::find()->where(['year' => $current_year])->count();
        $totalNcr = TblNcr::find()->where(['year' => $current_year])->count();

        return $this->render('summary_report', [
            'dataProvider' => $dataProvider, 
            'totalOfi' => $totalOfi, 
            'totalNcr' => $totalNcr, 
            // 'dept' =>$dept,
            'model' => $model,
        ]);
    }
         
    public function actionKpLaporanOfi() 
    {

        $icno = Yii::$app->user->getId();   
        $current_year = date('Y');
        $biodata = $this->findBiodata($this->ICNO());  
        $kp = Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->one();   
        $pp = Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->exists();  
        $tempKP = TblAccess::find()->where(['icno' => $icno])->andwhere(['access_level' => 4, 'isActive' => 1])->one(); //kp tidak dilantik tiada dlm department
      
        if(TblAccess::find()->where(['icno' => $icno])->andwhere(['access_level' => 4, 'isActive' => 1])->exists()){              
            $query = TblOfi::find()->where(['deptId' => $biodata->DeptId])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4']])->orderBy(['tarikh_audit' => SORT_DESC]);
            $title = 'Ketua Pentadbiran Kolej'; 
        } 
        elseif(Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->exists()){
            
            $query = TblOfi::find()->where(['deptId' => $kp->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4']])->orderBy(['tarikh_audit' => SORT_DESC]);
            $title = 'Ketua Pentadbiran';  
        } 
        if(!$pp && !$tempKP){ 
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada mempunyai akses. Sila berhubung dengan Pusat Jaminan Kualiti, Jabatan Pendaftar.']);
            return $this->redirect(['msiso/main']); 
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);  
        
        return $this->render('kp_laporan_ofi', [ 
            'dataProvider' => $dataProvider, 
            'tempKP' => $tempKP, 
            'kp' => $kp,      
        ]);
    }  

    public function actionKjLaporanOfi() 
    {

        $icno = Yii::$app->user->getId();   
        $current_year = date('Y');
        $searchModel = new TblOfiSearch();  
        $kj = Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->one();  
        $access = [711018125401];
        $biodata = $this->findBiodata($this->ICNO()); 
        $chief = Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->exists();  
        if(Department::find()->where(['chief' => $icno, 'id' => '135'])->exists()){

            $query = TblOfi::find()->where(['deptId' => $biodata->DeptId ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4']])->orderBy(['tarikh_audit' => SORT_DESC]);
            $title = 'Opportunities for Improvement (OFI)';
        }
        elseif(Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->exists()){

            $query = TblOfi::find()->where(['deptId' => $kj->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4']])->orderBy(['tarikh_audit' => SORT_DESC]);
            $title = 'Opportunities for Improvement (OFI)';
        }
        elseif(Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->exists()){
            $query = TblOfi::find()->where(['deptId' => $kj->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4']])->orderBy(['tarikh_audit' => SORT_DESC]);
            $title = 'Opportunities for Improvement (OFI)';
        }
        // $query = TblOfi::find()->where(['deptId' => $kj->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4']])->orderBy(['tarikh_audit' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);  
        
        return $this->render('kj_laporan_ofi', [ 
            'dataProvider' => $dataProvider,  
            'searchModel' => $searchModel,

        ]);
    }  

    public function actionKpLaporanNcr() 
    { 
        $icno = Yii::$app->user->getId();   
        $current_year = date('Y');
        $biodata = $this->findBiodata($this->ICNO());  
        $kp = Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->one();   
        $pp = Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->exists();  
        $tempKP = TblAccess::find()->where(['icno' => $icno])->andwhere(['access_level' => 4, 'isActive' => 1])->one(); //kp tidak dilantik tiada dlm department
      
        if(Department::find()->where(['chief' => $icno, 'id' => '135'])->exists()){
           
           $query = TblNcr::find()->where(['deptId' => $biodata->DeptId])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4']])->orderBy(['tarikh_audit' => SORT_DESC]);
            $title = 'Ketua Pentadbiran Kolej'; 
        } 
        elseif(Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->exists()){
            
            $query = TblNcr::find()->where(['deptId' => $kp->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4','5','6']])->orderBy(['tarikh_audit' => SORT_DESC]);
            $title = 'Ketua Pentadbiran';  
        } 
        elseif(Department::find()->where(['pp' => $icno])->andWhere(['isActive' => 1])->exists()){
            
            $query = TblNcr::find()->where(['deptId' => $kp->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4','5','6']])->orderBy(['tarikh_audit' => SORT_DESC]);
            $title = 'Ketua Pentadbiran';  
        } 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);  
        
        return $this->render('kp_laporan_ncr', [ 
            'dataProvider' => $dataProvider,   
            'tempKP' => $tempKP,  
            'kp' => $kp,
        ]);
    }  
    public function actionKjLaporanNcr() 
    {

        $icno = Yii::$app->user->getId();   
        $current_year = date('Y');
        $biodata = $this->findBiodata($this->ICNO()); 
        $access = [ 711018125401];
        $chief = Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->one();  
      
        $kj = Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->one();  

        if(Department::find()->where(['chief' => $icno, 'id' => '135'])->exists()){ 
            $query = TblNcr::find()->where(['deptId' => $biodata->DeptId, ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4','5','6']])->orderBy(['tarikh_audit' => SORT_DESC]);
            $title = 'NCR (NON-CONFORMITY REPORT)';
        }
        elseif(Department::find()->where(['chief' => $icno, 'id' => '196'])->exists()){

            $query = TblNcr::find()->where(['deptId' => $kj->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4','5','6']])->orderBy(['tarikh_audit' => SORT_DESC]);
            $title = 'NCR (NON-CONFORMITY REPORT)';
        }
        elseif(Department::find()->where(['chief' => $icno])->andWhere(['isActive' => 1])->exists()){

            $query = TblNcr::find()->where(['deptId' => $kj->id ])->andwhere(['year' => $current_year,'status_tindakan' => ['1','4','5','6']])->orderBy(['tarikh_audit' => SORT_DESC]);
            $title = 'NCR (NON-CONFORMITY REPORT)';
        }
        // $query = TblNcr::find()->where(['deptId' => $kj->id ])->andwhere(['year' => $current_year,'status_tindakan' =>['1','4','5','6']])->orderBy(['tarikh_audit' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);  
        
        return $this->render('kj_laporan_ncr', [ 
            'dataProvider' => $dataProvider,   

        ]);
    }  
}
