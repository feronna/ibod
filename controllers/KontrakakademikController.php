<?php

namespace app\controllers;

use Yii;
use app\models\kontrak\Kontrak;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Notification;
use app\models\hronline\Tblrscoapmtstatus;
use yii\filters\AccessControl;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use app\models\kontrak\RefKriteriaKpi;
use app\models\kontrak\TblKpi;
use app\models\kontrak\TblHindex;
use app\models\kontrak\TblPengajaran;
use yii\helpers\Url;
use app\models\kontrak\TblSurat;
use setasign\Fpdi\PdfParser\StreamReader;
use app\models\hronline\Vcpdlatihan;
use app\models\kontrak\RefSurat;
use app\models\kontrak\TblAkses;
use app\models\kontrak\TblAttachment;
/**
 * KontrakController implements the CRUD actions for Kontrak model.
 */
class KontrakakademikController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['borangpemeriksaanperubatan', 'suratpenerimaantawaran', 'borangakuankerahsiaan','borangakuan','semakanstatus','coteaching','uploadsurat','tetapanakses', 'senarai', 'datamesyuarat', 'tetapan', 'menunggu', 'maklumatkontrak1', 'mtindakan_dekan', 'tindakan_bsm', 'kpi', 'laporankpi', 'laporan', 'data'],
                'rules' => [
                    [
                        'actions' => ['senarai', 'datamesyuarat', 'laporan', 'data'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $icno=Yii::$app->user->getId();
                            if(TblAkses::find()->where(['icno' => $icno,'job_category' => 1, 'role' => ['Admin', 'Ahli Mesyuarat']])->exists()){
                                return true;
                            }else{
                                return false;
                            }
                           
                        }
                    ],
                            [
                        'actions' => ['maklumatkontrak1','kpi', 'laporankpi'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $icno=Yii::$app->user->getId();
                            $kj =  Kontrak::find()->where(['app_by' => $icno, 'job_category' => '1']);
                            if($kj->exists() || (TblAkses::find()->where(['icno' => $icno,'job_category' => 1, 'role' => ['Admin', 'Ahli Mesyuarat']])->exists())){
                                return true;
                            }
                            else{
                                return false;
                            }
                           
                        }
                    ],
                            [
                        'actions' => ['tetapanakses', 'tetapan', 'uploadsurat','tindakan_bsm'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $icno=Yii::$app->user->getId();
                            $akses = TblAkses::find()->where(['icno' => $icno,'job_category' => 1, 'role' => 'Admin']);
                            if($akses->exists()){
                                return true;
                            }else{
                                return false;
                            }
                           
                        }
                    ],
                        [
                        'actions' => ['menunggu', 'mtindakan_dekan'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $icno=Yii::$app->user->getId();
                            $akses =  Kontrak::find()->where(['app_by' => $icno, 'job_category' => '1']);
                            if($akses->exists()){
                                return true;
                            }else{
                                return false;
                            }
                           
                        }
                    ],
                    [
                        'actions' => ['coteaching', 'semakanstatus', 'borangakuan','borangpemeriksaanperubatan', 'suratpenerimaantawaran', 'borangakuankerahsiaan'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $icno=Yii::$app->user->getId();
                            if($icno){
                            $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
                            if($biodata->statLantikan!='1' && $biodata->jawatan->job_category =='1'){
                                return true;
                            }else{
                                return false;
                            }
                            }
                        }
                    ],
                    [
                        'actions' => ['userview','kemaskini','lihatbiodata'],
                        'allow' => true,
                        
                    ],
                ],
                
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    protected function notifikasi($icno, $content)
    {
        //--------Model Notification-----------//
                $ntf = new Notification(); //noti untuk kp
                $ntf->icno = $icno;
                $ntf->title = 'PSK';
                $ntf->content = $content;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save(false);
                //--------Model Notification-----------//
    }
    
    public function actionCoteaching($id)
    {
        $icno=Yii::$app->user->getId();
        $model = Kontrak::find()->where(['id'=>$id])->one();
        $model->icno = $icno;

        if (Yii::$app->request->post()) {
            
            foreach($model->pengajaran as $pengajaran){
                if((substr($pengajaran->SESI, -9) > $model->sesimulakontrak || (substr($pengajaran->SESI, -9) == $model->sesimulakontrak && substr($pengajaran->SESI,0,1) >= $model->semmulakontrak)) && !$pengajaran->jamwaktu){
                $newpengajaran = TblPengajaran::find()->where(['id' => $pengajaran->AutoId])->one()?
                        TblPengajaran::find()->where(['id' => $pengajaran->AutoId])->one(): new TblPengajaran();
                
                
                    $newpengajaran->id = $pengajaran->AutoId;
                    $newpengajaran->coteaching = Yii::$app->request->post('smp'.$pengajaran->AutoId);
                    if($newpengajaran->coteaching == ''){
                       Yii::$app->session->setFlash('alert', ['title' => 'Cannot be submitted', 'type' => 'error', 'msg' => "Please complete the Co-Teaching's column"]);
                       return $this->redirect('mohonlanjut'); 
                    }
                    $newpengajaran->save(false);
            }
            }
            $this->redirect(['mohonlanjut']);
        }
        
        return $this->renderAjax('coteaching', ['model' => $model,
        ]);
    }
    
    public function actionSemakanstatus()
    {
        $model = new Kontrak();
        $icno=Yii::$app->user->getId();
        $model->icno = $icno;
        $status = Kontrak::find()->where(['icno' => $icno])->all(); //senarai status permohonan
        if($model->kakitangan->NatCd === 'MYS'){
        $dokumen = RefSurat::find()->where(['job_category' => '1', 'warga' => '1'])->all();
        }
        else{
        $dokumen = RefSurat::find()->where(['job_category' => '1', 'warga' => '0'])->all();
        }
        
        return $this->render('semakanstatus', ['model' => $model, 'status' => $status, 'dokumen' => $dokumen
        ]);
    }
    
    
    public function actionMohonlanjut($id = null)
    {
        $icno=Yii::$app->user->getId();
        
        if($id){
            $model = $this->findModel($id);
            $edit = ($model->status_jfpiu == '14' || $model->status_pp == '14')? 1:0;
        }
        else{
            $model = Kontrak::find()->where(['icno'=>$icno,'status'=>14])->one();
            if(!$model && !$id){
                return $this->redirect(['semakanstatus']);
            }
            $edit = 1;
        }
        
        $model->icno = $icno;
//        $inhindex= $model->hindex?'':'incomplete';
        $inkpi= Kontrak::checkkpi($model);
        $inteaching = $model->pengajaran? Kontrak::checkteaching($model):'';
        $am = TblAttachment::find()->where(['kontrak_id' => $model->id, 'type' => 'url'])->one();
        if(!$am){
            $am = new TblAttachment(['kontrak_id' => $model->id, 'type' => 'url']);
        }
        $model->url = $am->url;
        if ($model->load(Yii::$app->request->post())) {
            $model->status='14';
            if($model->url){
                $am->url = $model->url;
                $am->save(false);
            }
            $model->save(false);
            if($inkpi==='incomplete'){
                Yii::$app->session->setFlash('alert', ['title' => 'Cannot be submitted', 'type' => 'error', 'msg' => "Please complete the Targeted Key Performance Indicators(KPI)"]);
                return $this->redirect('mohonlanjut');}
            if($inteaching==='incomplete'){
                Yii::$app->session->setFlash('alert', ['title' => 'Cannot be submitted', 'type' => 'error', 'msg' => "Please complete Co. Teaching's column on the Teaching & Learning"]);
                return $this->redirect('mohonlanjut');}
//            if($inhindex==='incomplete'){
//                Yii::$app->session->setFlash('alert', ['title' => 'Cannot be submitted', 'type' => 'error', 'msg' => "Please complete Scopus & Google Scholar"]);
//                return $this->redirect('mohonlanjut');}
            
            $this->newkontrak($model, UploadedFile::getInstance($model, 'file'));
            Yii::$app->session->setFlash('alert', ['title' => 'Successful', 'type' => 'success', 'msg' => 'Your application has been successfully submitted']);
            return $this->redirect(['semakanstatus']);
        }
        $akses = TblAkses::find()->where(['icno' => $icno,'job_category' => 1, 'role' => 'pemohon'])->one();
        if($id || ($akses && $akses->end_date >= date('Y-m-d'))){ 
            return $this->render('mohonlanjut', ['inkpi'=>$inkpi,'inteaching'=>$inteaching,'model' => $model,'edit' => $edit
        ]);
    }
        else{
        return $this->redirect(['semakanstatus']);
    }
    }
    
    protected function newkontrak($model, $file)
    {
        $akses = TblAkses::find()->where(['icno' => Yii::$app->user->getId(), 'role' => 'pemohon'])->one();
        
        $model->tarikh_m = date('Y-m-d H:i:s');
        $model->status ='1';
        $model->job_category ='1';
        $model->status_jfpiu = '6';
        $model->status_bsm = '6';
        $model->sesi_id = $akses->sesi;
        $model->tahun_sesi = $akses->tahun;
        $model->app_by = $model->icnoketuajfpiu; //kj 
        $model->ver_by = $model->icnoketuaprogram; //ketuaprogram
        
        if($file){
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'pelantikansemulakontrak');
            $filepath = $fileapi->file_name_hashcode;   
            if($fileapi->status != true) {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Permohonan anda gagal dihantar.']);
                return $this->redirect(['mohonlanjut']);
            }
            $model->dokumen_sokongan = $filepath;
        }
        if($model->ver_by != ''){
            $model->status_pp = '6';
        $this->notifikasi($model->icno, "Your application for contract extension has been submitted for ".$model->firstapp."'s endorsement ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
        $this->notifikasi($model->ver_by, "Application for contract extension waiting for your endorsement ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/senarai-kp'], ['class'=>'btn btn-primary btn-sm']));
        }else{
        $this->notifikasi($model->icno, "Your application for contract extension has been submitted for ".$model->secondapp."'s endorsement ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
        $this->notifikasi($model->app_by, "Application for contract extension waiting for your endorsement ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/senarai-kp'], ['class'=>'btn btn-primary btn-sm']));
         $model->status = 2;
        }  
        $model->save(false);
                  
    }

   public function actionMenunggu()
    {
        $icno=Yii::$app->user->getId();
        $senarais = Kontrak::find()->where(['app_by' => $icno, 'job_category' => '1'])->orderBy([
        'tarikh_m' => SORT_DESC]);
        
        $senarai = new ActiveDataProvider([
            'query' => $senarais,
            'pagination' => [
                'pageSize' => 30,
            ],

        ]);
          
        return $this->render('menunggu', [
            'icno' => $icno,
            'senarai' => $senarai,
        ]);
    }
    
    public function actionSenaraiKp()
    {
        $icno=Yii::$app->user->getId();
        $senarais = Kontrak::find()->where(['ver_by' => $icno, 'job_category' => '1'])->orderBy([
        'tarikh_m' => SORT_DESC]);
        
        $senarai = new ActiveDataProvider([
            'query' => $senarais,
            'pagination' => [
                'pageSize' => 30,
            ],

        ]);
          
        return $this->render('senarai_kp', [
            'icno' => $icno,
            'senarai' => $senarai,
        ]);
    }
    
    /**
     * Finds the Kontrak model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kontrak the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kontrak::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionMaklumatkontrak_bsm($id) {
        $model = $this->findModel($id);    
        if($model->lantikan){ $countlantikan = count($model->lantikan);}
        
        return $this->render('maklumatKontrak_bsm', [
                    'model' => $model,
                    'countlantikan' => $countlantikan
        ]);
    }
    
    public function actionMaklumatkontrak1($id) {
        $model = $this->findModel($id);
        $lain= '';
        $display = 'none';   
                    
        if($model->lantikan){ $countlantikan = count($model->lantikan);}
        
        if ($model->load(Yii::$app->request->post())) {
            $model->app_date = date('Y-m-d H:i:s');
            $post =Yii::$app->request->post('tempohs');
            if($model->tempoh_l_jfpiu == 'Others'){
                $model->tempoh_l_jfpiu = $post.' Bulan';
            }
            else{
                $model->tempoh_l_jfpiu = substr($model->tempoh_l_jfpiu, 0, 1).' Tahun';
            }
                if($model->status_jfpiu == '' || ($model->status_jfpiu == '4' && ($model->tempoh_l_jfpiu == ' Tahun' || $model->tempoh_l_jfpiu == '0 Bulan' || $model->tempoh_l_jfpiu == ' Bulan'))){
                    Yii::$app->session->setFlash('alert', ['title' => 'Not Successful', 'type' => 'error', 'msg' => 'Please complete the form']); 
                    return $this->redirect(['maklumatkontrak1?id='.$id]);
                }
                
                elseif($model->perakuan_kpi!='1'  && $model->status_jfpiu=='4'){
                    Yii::$app->session->setFlash('alert', ['title' => 'Cannot be submitted', 'type' => 'error', 'msg' => 'Please approve the Key Performance Indicators Stipulation']);
                    return $this->redirect(['maklumatkontrak1?id='.$id]);
                }
                
                else{
                    $file = UploadedFile::getInstance($model, 'file');
                    if($file){
                        $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'pelantikansemulakontrak');
                        $filepath = $fileapi->file_name_hashcode;   
                        if($fileapi->status != true) {
                            Yii::$app->session->setFlash('alert', ['title' => 'Failed', 'type' => 'error', 'msg' => 'Attachment cannot be uploaded']);
                            return $this->redirect(['maklumatkontrak1?id='.$id]);
                        }
                        $model->dokumen_jfpiu = $filepath;
                }
                    $model->ulasan_jfpiu = Yii::$app->request->post('comment');
                $model->status = '3';
                if ($model->status_jfpiu == '4') {
                        Yii::$app->session->setFlash('alert', ['title' => 'Successful', 'type' => 'success', 'msg' => 'Application Approved!']);}
                elseif ($model->status_jfpiu == '5') {
                    $model->tempoh_l_jfpiu = '';
                    $model->cadangan_jawatan = '';
                        Yii::$app->session->setFlash('alert', ['title' => 'Successful', 'type' => 'success', 'msg' => 'Application Rejected!']);}
                $model->save(false);
                $this->notifikasi($model->icno, "Your application for contract extension has been submitted for Human Resources Division's endorsement ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
                }
                
                
                return $this->redirect(['menunggu']);
        }
        if(substr($model->tempoh_l_jfpiu, -5) === 'Bulan'){
                        $display='';
                        $lain= $model->tempoh_l_jfpiu;
                        $tempohurl = "m".substr($model->tempoh_l_jfpiu,0, -6);
                        $model->tempoh_l_jfpiu = substr($model->tempoh_l_jfpiu, 0, -6).' Months';
        }
        else{
            if($model->tempoh_l_jfpiu === '1 Tahun'){
            $model->tempoh_l_jfpiu = substr($model->tempoh_l_jfpiu, 0, 1).' Year';
            }
            else{
            $model->tempoh_l_jfpiu = substr($model->tempoh_l_jfpiu, 0, 1).' Years';
            }
            $tempohurl = substr($model->tempoh_l_jfpiu, 0, 1);
        }
        
        return $this->render('maklumatKontrak1', [
                    'model' => $model,
                    'countlantikan' => $countlantikan, 'lain' => $lain, 'display' => $display,'tempohurl' => $tempohurl
        ]);
    }
    
    public function actionMaklumatkontrak_kp($id) {
        $model = $this->findModel($id);
        $lain= '';
        $display = 'none';   
                    
        if($model->lantikan){ $countlantikan = count($model->lantikan);}
        
        if ($model->load(Yii::$app->request->post())) {
            $model->ver_date = date('Y-m-d H:i:s');
            $post =Yii::$app->request->post('tempohs');
            if($model->tempoh_l_pp == 'Others'){
                $model->tempoh_l_pp = $post.' Bulan';
            }
            else{
                $model->tempoh_l_pp = substr($model->tempoh_l_pp, 0, 1).' Tahun';
            }
                if($model->status_pp == '4' && ($model->status_pp == ' Tahun' || $model->status_pp == '0 Bulan' || $model->status_pp == ' Bulan')){
                    Yii::$app->session->setFlash('alert', ['title' => 'Not Successful', 'type' => 'error', 'msg' => 'Please complete the form']); 
                    return $this->redirect(['maklumatkontrak_kp?id='.$id]);
                }
                
                elseif($model->kpi_kp!='1'  && $model->status_pp=='4'){
                    Yii::$app->session->setFlash('alert', ['title' => 'Cannot be submitted', 'type' => 'error', 'msg' => 'Please approve the Key Performance Indicators Stipulation']);
                    return $this->redirect(['maklumatkontrak_kp?id='.$id]);
                }
                
                else{
                    $file = UploadedFile::getInstance($model, 'file');
                    if($file){
                        $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'pelantikansemulakontrak');
                        $filepath = $fileapi->file_name_hashcode;   
                        if($fileapi->status != true) {
                            Yii::$app->session->setFlash('alert', ['title' => 'Failed', 'type' => 'error', 'msg' => 'Attachment cannot be uploaded. Please try again']);
                            return $this->redirect(['maklumatkontrak_kp?id='.$id]);
                        }
                $model->dokumen_ver = $filepath;
                }
                    $model->ulasan_pp = Yii::$app->request->post('comment');
                $model->status = '2';
                if ($model->status_pp == '4') {
                        Yii::$app->session->setFlash('alert', ['title' => 'Successful', 'type' => 'success', 'msg' => 'Application Approved!']);}
                elseif ($model->status_pp == '5') {
                    $model->tempoh_l_pp = '';
                    $model->cadangan_jawatan_ver = '';
                        Yii::$app->session->setFlash('alert', ['title' => 'Successful', 'type' => 'success', 'msg' => 'Application Rejected!']);}
                $model->save(false);
                $this->notifikasi($model->icno, "Your application for contract extension has been submitted for Head of Department's endorsement ");
                $this->notifikasi($model->app_by, "Application for contract extension waiting for your endorsement ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/menunggu'], ['class'=>'btn btn-primary btn-sm']));
                }
                
                
                return $this->redirect(['senarai-kp']);
        }
        if(substr($model->tempoh_l_pp, -5) === 'Bulan'){
                        $display='';
                        $lain= $model->tempoh_l_pp;
                        $tempohurl = "m".substr($model->tempoh_l_pp,0, -6);
                        $model->tempoh_l_pp = substr($model->tempoh_l_pp, 0, -6).' Months';
        }
        else{
            if($model->tempoh_l_pp === '1 Tahun'){
            $model->tempoh_l_pp = substr($model->tempoh_l_pp, 0, 1).' Year';
            }
            else{
            $model->tempoh_l_pp = substr($model->tempoh_l_pp, 0, 1).' Years';
            }
            $tempohurl = substr($model->tempoh_l_pp, 0, 1);
        }
        
        return $this->render('maklumatKontrak_kp', [
                    'model' => $model,
                    'countlantikan' => $countlantikan, 'lain' => $lain, 'display' => $display,'tempohurl' => $tempohurl
        ]);
    }
    
    public function actionMtindakan_dekan($id) {
     
        $model = $this->findModel($id);
        $model->app_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $lain= '';
        $display = 'none';
        $kriteriakpi = RefKriteriaKpi::find()->all();
        
        if(substr($model->tempoh_l_jfpiu, -5) === 'Bulan'){
                        $display='';
                        $lain= $model->tempoh_l_jfpiu;
                        $tempohurl = "m".substr($model->tempoh_l_jfpiu,0, -6);
                        $model->tempoh_l_jfpiu = 'Others';
        }
        else{
            if($model->tempoh_l_jfpiu === '1 Tahun'){
            $model->tempoh_l_jfpiu = substr($model->tempoh_l_jfpiu, 0, 1).' Year';
            }
            else{
            $model->tempoh_l_jfpiu = substr($model->tempoh_l_jfpiu, 0, 1).' Years';
            }
            $tempohurl = substr($model->tempoh_l_jfpiu, 0, 1);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $post =Yii::$app->request->post('tempohs');
            if($model->tempoh_l_jfpiu == 'Others'){
                $model->tempoh_l_jfpiu = $post.' Bulan';
            }
            else{
                $model->tempoh_l_jfpiu = substr($model->tempoh_l_jfpiu, 0, 1).' Tahun';
            }
                if($model->status_jfpiu == '' || ($model->status_jfpiu == '4' && ($model->tempoh_l_jfpiu == ' Tahun' || $model->tempoh_l_jfpiu == '0 Bulan' || $model->tempoh_l_jfpiu == ' Bulan'))){
                    Yii::$app->session->setFlash('alert', ['title' => 'Not Successful', 'type' => 'error', 'msg' => 'Please complete the form']); 
                    return $this->redirect(['menunggu']);
                }
                
                elseif($model->perakuan_kpi!='1' && $model->status_jfpiu=='4'){
                    Yii::$app->session->setFlash('alert', ['title' => 'Cannot be submitted', 'type' => 'error', 'msg' => 'Please approve the Key Performance Indicators Stipulation']);
                    return $this->redirect(['menunggu']);
                }
                
                else{
                    $file = UploadedFile::getInstance($model, 'file');
                    if($file){
                        $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'pelantikansemulakontrak');
                        $filepath = $fileapi->file_name_hashcode;   
                        if($fileapi->status != true) {
                            Yii::$app->session->setFlash('alert', ['title' => 'Failed', 'type' => 'error', 'msg' => 'Attachment cannot be uploaded']);
                            return $this->redirect(['menunggu']);
                        }
                $model->dokumen_jfpiu = $filepath;
                }
                $model->ulasan_jfpiu = Yii::$app->request->post('comment');
                $model->status = '3';
                if ($model->status_jfpiu == '4') {
                        Yii::$app->session->setFlash('alert', ['title' => 'Successful', 'type' => 'success', 'msg' => 'Application Approved!']);}
                elseif ($model->status_jfpiu == '5') {
                    $model->tempoh_l_jfpiu = '';
                    $model->cadangan_jawatan = '';
                        Yii::$app->session->setFlash('alert', ['title' => 'Successful', 'type' => 'success', 'msg' => 'Application Rejected!']);}
                $model->save(false);
                $this->notifikasi($model->icno, "Your application for contract extension has been submitted for Human Resources Division's endorsement ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
                }
                
                
                return $this->redirect(['menunggu']);
        }
               
        return $this->renderAjax('mtindakan_dekan', [
                    'model' => $model, 'kriteriakpi' => $kriteriakpi, 'lain' => $lain, 'display' =>$display,'tempohurl' => $tempohurl
        ]);
    }
    
    public function actionMtindakan_kp($id) {
     
        $model = $this->findModel($id);
        $model->ver_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $lain= '';
        $display = 'none';
        $kriteriakpi = RefKriteriaKpi::find()->all();
        
        if(substr($model->tempoh_l_pp, -5) === 'Bulan'){
                        $display='';
                        $lain= $model->tempoh_l_pp;
                        $tempohurl = "m".substr($model->tempoh_l_pp,0, -6);
                        $model->tempoh_l_pp = 'Others';
        }
        else{
            if($model->tempoh_l_pp === '1 Tahun'){
            $model->tempoh_l_pp = substr($model->tempoh_l_pp, 0, 1).' Year';
            }
            else{
            $model->tempoh_l_pp = substr($model->tempoh_l_pp, 0, 1).' Years';
            }
            $tempohurl = substr($model->tempoh_l_pp, 0, 1);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $post =Yii::$app->request->post('tempohs');
            if($model->tempoh_l_pp == 'Others'){
                $model->tempoh_l_pp = $post.' Bulan';}
            else{
                $model->tempoh_l_pp = substr($model->tempoh_l_pp, 0, 1).' Tahun';}
                
            if($model->status_pp == '4' && ($model->tempoh_l_pp == ' Tahun' || $model->tempoh_l_pp == '0 Bulan' || $model->tempoh_l_pp == ' Bulan')){
                Yii::$app->session->setFlash('alert', ['title' => 'Not Successful', 'type' => 'error', 'msg' => 'Please complete the form']); 
                return $this->redirect(['senarai-kp']);
            }
                
            elseif($model->kpi_kp!='1' && $model->status_pp=='4'){
                Yii::$app->session->setFlash('alert', ['title' => 'Cannot be submitted', 'type' => 'error', 'msg' => 'Please approve the Key Performance Indicators Stipulation']);
                return $this->redirect(['senarai-kp']);
            }
                
            else{
                $file = UploadedFile::getInstance($model, 'file');
                if($file){
                    $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'pelantikansemulakontrak');
                    $filepath = $fileapi->file_name_hashcode;   
                    if($fileapi->status != true) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Failed', 'type' => 'error', 'msg' => 'Attachment cannot be uploaded. Please try again']);
                        return $this->redirect(['senarai-kp']);
                    }
                    
                $model->dokumen_ver = $filepath;
                }
                $model->ulasan_pp = Yii::$app->request->post('comment');
                $model->status = '2';
                if ($model->status_pp == '4') {
                        Yii::$app->session->setFlash('alert', ['title' => 'Successful', 'type' => 'success', 'msg' => 'Application Approved!']);}
                elseif ($model->status_pp == '5') {
                    $model->tempoh_l_pp = '';
                    $model->cadangan_jawatan_ver = '';
                    Yii::$app->session->setFlash('alert', ['title' => 'Successful', 'type' => 'success', 'msg' => 'Application Rejected!']);
                }
                $model->save(false);
                $this->notifikasi($model->icno, "Your application for contract extension has been submitted for Head of Department's endorsement ");
                $this->notifikasi($model->app_by, "Application for contract extension waiting for your endorsement ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/menunggu'], ['class'=>'btn btn-primary btn-sm']));
                }
                
                
                return $this->redirect(['senarai-kp']);
        }
               
        return $this->renderAjax('mtindakan_kp', [
                    'model' => $model, 'kriteriakpi' => $kriteriakpi, 'lain' => $lain, 'display' =>$display,'tempohurl' => $tempohurl
        ]);
    }
    
     public function actionSenarai($jawatan = null, $bsms = null, $jfpiu=null, $icnos = null, $sesis = null, $tahuns = null, $dekans = null)
    {
         if(!$sesis && !$tahuns){
             $akses = TblAkses::find()->where(['job_category' => 1, 'role' => 'pemohon'])->orderBy(['end_date' => SORT_DESC])->one();
             $sesis = $akses->sesi;
             $tahuns = $akses->tahun;
         }
         $icno = Yii::$app->user->getId();
         $arrayicno = array();
         $kontrak = Kontrak::find()->where(['job_category' => '1'])->all();
        foreach ($kontrak as $k){
            if($jawatan != '' && $jfpiu!=''){
                ($k->kakitangan->jawatan->id == $jawatan &&
                        $k->kakitangan->department->id == $jfpiu)? array_push($arrayicno, $k->icno):'';
            }
            elseif($jawatan != '') {
                $k->kakitangan->jawatan->id == $jawatan? array_push($arrayicno, $k->icno):'';
            }
            elseif ($jfpiu != '') {
                $k->kakitangan->department->id == $jfpiu? array_push($arrayicno, $k->icno):'';
            }
         }
        $query = empty($arrayicno)? Kontrak::find()->where(['job_category' => '1']) : Kontrak::find()->where(['icno' => $arrayicno]);    
        $dataProvider = new ActiveDataProvider([

            'query' => $query,

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        $icnos? $dataProvider->query->andFilterWhere(['like', 'icno',  $icnos ]):'';
        $sesis? $dataProvider->query->andFilterWhere(['sesi_id' => $sesis]):'';
        $tahuns? $dataProvider->query->andFilterWhere(['tahun_sesi' => $tahuns]):'';
        if($dekans){
          $dekans == '11'? $dataProvider->query->andFilterWhere(['is', 'tarikh_m', new \yii\db\Expression('null')]):$dataProvider->query->andFilterWhere(['status_jfpiu' => $dekans]);
        }
        if($bsms){
          $bsms == '11'? $dataProvider->query->andFilterWhere(['is', 'tarikh_m', new \yii\db\Expression('null')]):$dataProvider->query->andFilterWhere(['status_bsm' => $bsms ]);
        }   
        
        $models = Kontrak::find()->All();
        $selection=(array)Yii::$app->request->post('selection');//typecasting
            if (Yii::$app->request->post('simpan')){
                
                foreach ($models as $data) {
                    if('y'.$data->id == Yii::$app->request->post($data->id)){
                    $model = $this->findModel($data->id);
                    $model->status_bsm = '12';
                    $model->save(false);
                    }
                    elseif('n'.$data->id == Yii::$app->request->post($data->id)){
                    $model = $this->findModel($data->id);
                    $model->status_bsm = '13';
                    $model->save(false);
                    }

            }
            }

            elseif (Yii::$app->request->post('hantar')) {
                foreach($selection as $id){
                $hantar= $this->findModel($id);//make a typecasting
                if('n'.$hantar->id == Yii::$app->request->post($hantar->id)){
                    $hantar->status ='5';
                    $hantar->status_bsm='5';
                    $this->notifikasi($hantar->icno, "Your application for contract extension has been rejected".Html::a('<i class="fa fa-arrow-right"></i>', ['semakanstatus'], ['class'=>'btn btn-primary btn-sm']));
                    
                }
                elseif('y'.$hantar->id == Yii::$app->request->post($hantar->id)&& $hantar->tempoh_l_bsm != ''){
                    $hantar->status ='4';
                    $hantar->status_bsm='4';
                    $this->notifikasi($hantar->icno, "Your application for contract extension has been approved".Html::a('<i class="fa fa-arrow-right"></i>', ['semakanstatus'], ['class'=>'btn btn-primary btn-sm']));
                    
                }
                $hantar->bsma_date = date('Y-m-d H:i:s');
                $hantar->save(false);
                }
            }
            
            elseif(Yii::$app->request->post('notipemohon')){
               $this->notifipemohon(); 
            }
            elseif(Yii::$app->request->post('notipegawai')){
               $this->notifipegawai(); 
            }

          
        
       if(TblAkses::find()->where(['icno' => $icno,'job_category' => 1, 'role' => 'Admin'])->exists()){
        return $this->render('senarai', [
            'dataProvider' => $dataProvider,
            'jawatan' => $jawatan, 'bsms' => $bsms, 'jfpiu' => $jfpiu, 'icnos' => $icnos, 'sesis' => $sesis, 'tahuns' => $tahuns, 'dekans' => $dekans
       ]);}
       else{
        return $this->redirect('datamesyuarat');}
    }
    
    public function actionDatamesyuarat()
    {
        
         $icno = Yii::$app->user->getId();
         $arrayicno = array();
         $kontrak = Kontrak::find()->where(['job_category' => '1'])->all();
        if(isset(Yii::$app->request->queryParams['jawatan'])){
        foreach ($kontrak as $k){
            if(Yii::$app->request->queryParams['jawatan'] != '' && Yii::$app->request->queryParams['jfpiu']!=''){
                ($k->kakitangan->jawatan->id == Yii::$app->request->queryParams['jawatan'] &&
                        $k->kakitangan->department->id == Yii::$app->request->queryParams['jfpiu'])? array_push($arrayicno, $k->icno):'';
            }
            elseif(Yii::$app->request->queryParams['jawatan'] != '') {
                $k->kakitangan->jawatan->id == Yii::$app->request->queryParams['jawatan']? array_push($arrayicno, $k->icno):'';
            }
            elseif (Yii::$app->request->queryParams['jfpiu'] != '') {
                $k->kakitangan->department->id == Yii::$app->request->queryParams['jfpiu']? array_push($arrayicno, $k->icno):'';
            }
         }}
        $query = empty($arrayicno)? Kontrak::find()->where(['job_category' => '1']) : Kontrak::find()->where(['icno' => $arrayicno]);    
        $dataProvider = new ActiveDataProvider([

            'query' => $query,

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        isset(Yii::$app->request->queryParams['icno'])? $dataProvider->query->andFilterWhere(['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';
        isset(Yii::$app->request->queryParams['bil'])? $dataProvider->query->andFilterWhere(['sesi_id' => Yii::$app->request->queryParams['bil'] ]):'';
        isset(Yii::$app->request->queryParams['tahun'])? $dataProvider->query->andFilterWhere(['tahun_sesi' => Yii::$app->request->queryParams['tahun'] ]):'';
        isset(Yii::$app->request->queryParams['statusdekan'])? $dataProvider->query->andFilterWhere(['status_jfpiu' => Yii::$app->request->queryParams['statusdekan'] ]):'';
        isset(Yii::$app->request->queryParams['statusbsm'])? $dataProvider->query->andFilterWhere(['status_bsm' => Yii::$app->request->queryParams['statusbsm'] ]):'';
        $models = Kontrak::find()->All();
        $selection=(array)Yii::$app->request->post('selection');//typecasting
            
        return $this->render('datamesyuarat', [
            'dataProvider' => $dataProvider,
       ]);
    }
    
    public function actionTindakan_bsm($id)
    {
                $model = $this->findModel($id);
                $biodata = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
                $lantikan = new Tblrscoapmtstatus();
                
                
                $message = '';
                    $display='none';
                    $lain= '';
                    if(substr($model->tempoh_l_bsm, -5) === 'Bulan'){
                        $display='';
                        $lain= $model->tempoh_l_bsm;
                        $model->tempoh_l_bsm = 'Others';
                    }
                    
                if(Yii::$app->request->post()){
                    $model->status_bsm = Yii::$app->request->post('Kontrak')['status_bsm'];
                    if($model->status_bsm == '4'){
                        $post=Yii::$app->request->post('Kontrak')['tempoh_l_bsm'];
                        $model->jawatan_diperakui = Yii::$app->request->post('Kontrak')['jawatan_diperakui'];
                        $model->tempoh_l_bsm = $post;
                        if($post == 'Others'){
                            $model->tempoh_l_bsm = Yii::$app->request->post('tempohs').' Bulan';
                        }
                        else{
                            $model->tempoh_l_bsm = substr($model->tempoh_l_bsm, 0, 1).' Tahun';
                        }
                    }
                    elseif ($model->status_bsm == '7') {
                        $model->status_date = Yii::$app->request->post('Kontrak')['status_date'];
                        
                    }
                    
                    $model->status = Yii::$app->request->post('Kontrak')['status_bsm'];
                    $model->save(false);
                    $model->status == '5'? $this->notifikasi($model->icno, "Your application for contract extension has been rejected".Html::a('<i class="fa fa-arrow-right"></i>', ['semakanstatus'], ['class'=>'btn btn-primary btn-sm'])):'';
                    $model->status == '4'? $this->notifikasi($model->icno, "Your application for contract extension has been approved".Html::a('<i class="fa fa-arrow-right"></i>', ['semakanstatus'], ['class'=>'btn btn-primary btn-sm'])):'';
                    
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                    return $this->redirect(Yii::$app->request->referrer);
                    }
                
                $model->tempoh_l_bsm = substr($model->tempoh_l_bsm, 0, 1).' Years';
            return $this->renderAjax('tindakan_bsm', [
                'model' => $model,
                'message' => $message,
                'display' => $display,
                'lain' => $lain
            ]); 
    }  
    
    public function actionBorangakuan(){
    $id = Yii::$app->user->getId();
    $model = Kontrak::findOne(['icno' => $id]);
    $mpdf = new \Mpdf\Mpdf();
    $pagecount = $mpdf->SetSourceFile('uploads/pelantikansemulakontrak/Borang Akuan1.pdf');
        for ($i=1; $i<=$pagecount; $i++) {
            $import_page = $mpdf->ImportPage($i);
            $mpdf->UseTemplate($import_page);
            if($i==1){ //page1
            $mpdf->WriteHTML($this->renderPartial('borangakuan', ['model' => $model]));
            }
            if ($i < $pagecount){
            $mpdf->AddPage();}
        }
        $mpdf->Output();
    }
    
    public function actionBorangpemeriksaanperubatan(){
    $id = Yii::$app->user->getId();
    $model = Kontrak::findOne(['icno' => $id]);
    $surat = RefSurat::find()->where(['id' => '5'])->one();
    $file = file_get_contents(Url::to(Yii::$app->FileManager->DisplayFile($surat->source), true));
    $mpdf = new \Mpdf\Mpdf();
    $pagecount = $mpdf->SetSourceFile(StreamReader::createByString($file));
        for ($i=1; $i<=$pagecount; $i++) {
            $import_page = $mpdf->ImportPage($i);
            $mpdf->UseTemplate($import_page);
            if($i==1){ //page1
            $mpdf->WriteHTML($this->renderPartial('borangpemeriksaanperubatan', ['model' => $model]));
            }
            if ($i < $pagecount){
            $mpdf->AddPage();}
        }
        $mpdf->Output();
    }
    
    public function actionSuratpenerimaantawaran(){
    $id = Yii::$app->user->getId();
    $model = Kontrak::findOne(['icno' => $id]);
    $surat = RefSurat::find()->where(['id' => '8'])->one();
    $file = file_get_contents(Url::to(Yii::$app->FileManager->DisplayFile($surat->source), true));
      $mpdf = new \Mpdf\Mpdf();
//    $pagecount = $mpdf->SetSourceFile(StreamReader::createByString($file));
//    $import_page = $mpdf->ImportPage($pagecount);
//            $mpdf->UseTemplate($import_page);
  
            $mpdf->WriteHTML($this->renderPartial('suratpenerimaantawaran', ['model' => $model]));
        $mpdf->Output();
    }
    
    public function actionBorangakuankerahsiaan(){
    $id = Yii::$app->user->getId();
    $model = Kontrak::findOne(['icno' => $id]);
    $mpdf = new \Mpdf\Mpdf();
    $pagecount = $mpdf->SetSourceFile('uploads/pelantikansemulakontrak/Borang Akuan Kerahsiaan.pdf');
        for ($i=1; $i<=$pagecount; $i++) {
            $import_page = $mpdf->ImportPage($i);
            $mpdf->UseTemplate($import_page);
            if($i==1){ //page1
            $mpdf->WriteHTML($this->renderPartial('borangakuankerahsiaan', ['model' => $model]));
            }
            if ($i < $pagecount){
            $mpdf->AddPage();}
        }
        $mpdf->Output();
    }
    
    public function actionTetapanakses() {
        
        $akses = TblAkses::find()->where(['job_category' => '1', 'role' => ['Admin', 'Ahli Mesyuarat']])->all(); //cari senarai admin akademik
        $aksesbaru = new TblAkses; //untuk admin baru
        if ($aksesbaru->load(Yii::$app->request->post())) {
                    if(TblAkses::find()->where( [ 'icno' => $aksesbaru->icno, 'job_category' => '1', 'role' => $aksesbaru->role] )->exists()){ //jika admin sudah wujud
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
                    }
                    else{
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                        $aksesbaru->job_category = 1;
                        $aksesbaru->save(false);
                    }
                    return $this->redirect(['tetapanakses']);
                }
        return $this->render('tetapanakses', [
            'akses' => $akses,
            'aksesbaru' => $aksesbaru,
            'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
        ]);
    }
    
    public function actionDeleteakses($id)
    {
        $akses = TblAkses::findOne(['id' => $id]);
        $akses->delete();
        return $this->redirect(['tetapanakses']);
    }
    
    public function actionKpi($id, $modal) {
        $icno = Yii::$app->user->getId();
        $kriteriakpi = RefKriteriaKpi::find()->where(['status'=> 1])->all();
        $kontrak = $this->findModel($id);
        $message = $kontrak->perakuan_kpi===1? 'Approved':'';
        
        if (Yii::$app->request->post()) {
            foreach ($kriteriakpi as $kpi){
                $comment = Yii::$app->request->post('catatan_4'.$kpi->id);
                $model = TblKpi::find()->where(['kontrak_id' => $kontrak->id, 'kriteriakpi_id' => $kpi->id, 'perkara' => 'comment'])->exists()?
                            TblKpi::find()->where(['kontrak_id' => $kontrak->id, 'kriteriakpi_id' => $kpi->id, 'perkara' => 'comment'])->one(): new TblKpi();
                    if($comment!=''){
                    $model->kontrak_id = $kontrak->id;
                    $model->kriteriakpi_id = $kpi->id;
                    $model->perkara = 'comment';
                    $model->catatan = $comment;
                    $model->save(false);
                    }
                    elseif(!$model->isNewRecord){
                        $model->delete();
                    }
            }
            if (Yii::$app->request->post('no')) {
                $kontrak->status = 14;
                $kontrak->status_jfpiu = 14;
                $kontrak->perakuan_kpi = 0;
                $kontrak->save(false);  
                $this->notifikasi($kontrak->icno, "Your target Key Performance Indicator (KPI) is not approved by your Head of Department; Please revise and make an amendment".Html::a('<i class="fa fa-arrow-right"></i>', ['mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'The application successfully returned to the applicant']);
                return $this->redirect(['menunggu']);
            }
            if (Yii::$app->request->post('yes')) {
                $kontrak->perakuan_kpi = "1";
                $kontrak->save(false);
                //Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'The KPI Approved']);
                
            }
        }     
        return $this->renderAjax('kpi', [
                    'kriteriakpi' => $kriteriakpi,
                    'id' => $id,
                    'kontrak' => $kontrak,
                    'message' => $message,
                    'icno' => $icno,
                    'modal' => $modal
        ]);
        
    }
    
    public function actionKpi_kp($id, $modal) {
        $icno = Yii::$app->user->getId();
        $kriteriakpi = RefKriteriaKpi::find()->where(['status'=> 1])->all();
        $kontrak = $this->findModel($id);
        $message = $kontrak->kpi_kp ===1? 'Approved':'';
        
        if (Yii::$app->request->post()) {
            foreach ($kriteriakpi as $kpi){
                $comment = Yii::$app->request->post('catatan_4'.$kpi->id);
                $model = TblKpi::find()->where(['kontrak_id' => $kontrak->id, 'kriteriakpi_id' => $kpi->id, 'perkara' => 'comment_kp'])->exists()?
                            TblKpi::find()->where(['kontrak_id' => $kontrak->id, 'kriteriakpi_id' => $kpi->id, 'perkara' => 'comment_kp'])->one(): new TblKpi();
                    if($comment!=''){
                    $model->kontrak_id = $kontrak->id;
                    $model->kriteriakpi_id = $kpi->id;
                    $model->perkara = 'comment_kp';
                    $model->catatan = $comment;
                    $model->save(false);
                    }
                    elseif(!$model->isNewRecord){
                        $model->delete();
                    }
            }
            if (Yii::$app->request->post('no')) {
                $kontrak->status = 14;
                $kontrak->status_pp = 14;
                $kontrak->perakuan_kpi = 0;
                $kontrak->save(false);  
                $this->notifikasi($kontrak->icno, "Your target Key Performance Indicator (KPI) is not approved by your Head of Program; Please revise and make an amendment".Html::a('<i class="fa fa-arrow-right"></i>', ['mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'The application successfully returned to the applicant']);
                return $this->redirect(['senarai-kp']);
            }
            if (Yii::$app->request->post('yes')) {
                $kontrak->kpi_kp = "1";
                $kontrak->save(false);
            }
        }     
        return $this->renderAjax('kpi_kp', [
                    'kriteriakpi' => $kriteriakpi,
                    'id' => $id,
                    'kontrak' => $kontrak,
                    'message' => $message,
                    'icno' => $icno,
                    'modal' => $modal
        ]);
        
    }
    
    public function actionIsikpi() {
        
        $kriteriakpi = RefKriteriaKpi::find()->where(['status'=> 1])->all();
        if(!(Kontrak::find()->where(['icno' => Yii::$app->user->getId()])->exists())){
            $kontrak = new Kontrak();
            $kontrak->icno = Yii::$app->user->getId();
            $kontrak->status = '14';
            $kontrak->reason = '';
            $kontrak->save(false);
        }
        $kontrak = Kontrak::find()->where(['icno' => Yii::$app->user->getId()])->orderBy([
            'id' => SORT_DESC,
          ])->one();
            
        
        if (Yii::$app->request->post()) {
            foreach ($kriteriakpi as $kpi) {
                TblKpi::deleteAll(['kontrak_id'=> $kontrak->id, 'kriteriakpi_id' => $kpi->id]);
                $catatan = Yii::$app->request->post('catatan'.$kpi->id);
                $catatan_2 = Yii::$app->request->post('catatan_2'.$kpi->id);
                $catatan_3 = Yii::$app->request->post('catatan_3'.$kpi->id);
                if($kpi->id <=3){
                    for($i=0;$i<count($catatan);$i++){
                        $model = new TblKpi();
                        $model->kontrak_id = $kontrak->id;
                        $model->kriteriakpi_id = $kpi->id;
                        $model->catatan = $catatan[$i];
                        $model->catatan_2 = $catatan_2[$i];
                        $model->catatan_3 = $catatan_3[$i];
                        $model->perkara = 'number';
                        $model->perkara_2 = 'amount';
                        $model->perkara_3 = 'role';
                        $model->save();
                    }
                }
                elseif($kpi->id ==4){
                    for($i=0;$i<count($catatan);$i++){
                        $model = new TblKpi();
                        $model->kontrak_id = $kontrak->id;
                        $model->kriteriakpi_id = $kpi->id;
                        $model->catatan = $catatan[$i];
                        $model->catatan_2 = $catatan_2[$i];
                        $model->catatan_3 = $catatan_3[$i];
                        $model->perkara = 'bilangan';
                        $model->perkara_2 = 'type';
                        $model->perkara_3 = 'role';
                        $model->save();
                    }
                }
                elseif($kpi->id ==5){
                    for($i=0;$i<count($catatan);$i++){
                        $model = new TblKpi();
                        $model->kontrak_id = $kontrak->id;
                        $model->kriteriakpi_id = $kpi->id;
                        $model->catatan = $catatan[$i];
                        $model->catatan_2 = $catatan_2[$i];
                        $model->catatan_3 = $catatan_3[$i];
                        $model->perkara = 'bilangan';
                        $model->perkara_2 = 'role';
                        $model->perkara_3 = 'level';
                        $model->save();
                    }
                }
                elseif($kpi->id ==6){
                    for($i=0;$i<count($catatan);$i++){
                        $model = new TblKpi();
                        $model->kontrak_id = $kontrak->id;
                        $model->kriteriakpi_id = $kpi->id;
                        $model->catatan = $catatan[$i];
                        $model->catatan_2 = $catatan_2[$i];
                        $model->catatan_3 = $catatan_3[$i];
                        $model->perkara = 'bilangan';
                        $model->perkara_2 = 'bilangan jam per semester';
                        $model->perkara_3 = 'bilangan pelajar';
                        $model->save();
                    }
                }
                elseif($kpi->id ==7){
                    for($i=0;$i<count($catatan);$i++){
                        $model = new TblKpi();
                        $model->kontrak_id = $kontrak->id;
                        $model->kriteriakpi_id = $kpi->id;
                        $model->catatan = $catatan[$i];
                        $model->catatan_2 = $catatan_2[$i];
                        $model->catatan_3 = $catatan_3[$i];
                        $model->perkara = 'bilangan';
                        $model->perkara_2 = 'level';
                        $model->perkara_3 = 'role';
                        $model->save();
                    }
                }
                else{
                        $model = new TblKpi();
                        $model->kontrak_id = $kontrak->id;
                        $model->kriteriakpi_id = $kpi->id;
                        $model->catatan = $catatan;
                        $model->perkara = 'kpi';
                        $model->save();
                }
                
            }
            $this->redirect('mohonlanjut');
        }     
        return $this->renderAjax('isikpi', [
                    'kriteriakpi' => $kriteriakpi,
                    'kontrak' => $kontrak,
            'modelsAddress'=> [new TblKpi]
        ]);
        
    }
    
    protected function savekpi($id, $kpi) {
//       $mod = TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id]);
            if($kpi->id<5){
                    $modnumber = TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->andWhere(['perkara' => 'number'])->exists()? 
                            TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->andWhere(['perkara' => 'number'])->one(): new TblKpi();
                    $modnumber->kriteriakpi_id = $kpi->id;
                    $modnumber->kontrak_id = $id;
                    $modnumber->perkara = 'number';
                    $modnumber->catatan = Yii::$app->request->post($kpi->id.'number');
                    $modnumber->save(false);
                    
                    $modamount = TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->andWhere(['perkara' => 'amount'])->exists()? 
                            TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->andWhere(['perkara' => 'amount'])->one(): new TblKpi();
                    $modamount->kriteriakpi_id = $kpi->id;
                    $modamount->kontrak_id = $id;
                    $modamount->perkara = 'amount';
                    $modamount->catatan = Yii::$app->request->post($kpi->id.'amount');
                    $modamount->save(false);
                    
                    $modleader = TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->andWhere(['perkara' => 'leader'])->exists()? 
                            TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->andWhere(['perkara' => 'leader'])->one(): new TblKpi();
                    $modleader->kriteriakpi_id = $kpi->id;
                    $modleader->kontrak_id = $id;
                    $modleader->perkara = 'leader';
                    $modleader->catatan = Yii::$app->request->post($kpi->id.'leader');
                    $modleader->save(false);
                    
                    $modmember = TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->andWhere(['perkara' => 'member'])->exists()? 
                            TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->andWhere(['perkara' => 'member'])->one(): new TblKpi();
                    $modmember->kriteriakpi_id = $kpi->id;
                    $modmember->kontrak_id = $id;
                    $modmember->perkara = 'member';
                    $modmember->catatan = Yii::$app->request->post($kpi->id.'member');
                    $modmember->save(false);
            }
            elseif($kpi->id === 5){
                    $modnational = TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->andWhere(['perkara' => 'national'])->exists()? 
                            TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->andWhere(['perkara' => 'national'])->one(): new TblKpi();
                    $modnational->kriteriakpi_id = $kpi->id;
                    $modnational->kontrak_id = $id;
                    $modnational->perkara = 'national';
                    $modnational->catatan = Yii::$app->request->post($kpi->id.'national');
                    $modnational->save(false);
                    
                    $modinternational = TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->andWhere(['perkara' => 'international'])->exists()? 
                            TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->andWhere(['perkara' => 'international'])->one(): new TblKpi();
                    $modinternational->kriteriakpi_id = $kpi->id;
                    $modinternational->kontrak_id = $id;
                    $modinternational->perkara = 'international';
                    $modinternational->catatan = Yii::$app->request->post($kpi->id.'international'); 
                    $modinternational->save(false);
            }
            else{
                    $modkpi = TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->exists()? 
                            TblKpi::find()->where(['kontrak_id' => $id, 'kriteriakpi_id' => $kpi->id])->one() : new TblKpi();
                    $modkpi->kontrak_id = $id;
                    $modkpi->kriteriakpi_id = $kpi->id;
                    $modkpi->catatan = Yii::$app->request->post($kpi->id.'kpi');
                    $modkpi->save(false);
            }               
    }
    
    
    public function actionUploadsurat($id)
    {
        $message = '';
        $model = new TblSurat();
        
        if ($model->load(Yii::$app->request->post())) {
            $file =  UploadedFile::getInstances($model, 'file');
            
            if($file){
                foreach ($file as $file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'pelantikansemulakontrak/surat');
                $filepath = $fileapi->file_name_hashcode;   
                $filename = $file->name;   
                if($fileapi->status == true) {
                    $message = 'Saved';
                    $model = new TblSurat();
                    $model->dokumen = $filepath;
                    $model->tajuk = $filename;
                    $model->kontrak_id = $id;
                    $model->upload_by = Yii::$app->user->getId();
                    $model->upload_dt = date('Y-m-d H:i:s');
                    $model->save(false);
                }
                }
            }
        }
        $dokumen = TblSurat::find()->where(['kontrak_id' => $id])->all();
        return $this->renderAjax('uploadsurat', [
           'dokumen' => $dokumen,
           'message' => $message,
           'model' => $model,
           'id' => $id
        ]); 
    } 
    
    public function actionIdp($type,$icno)
    {
        $currentYear = date('Y');
        $model = Vcpdlatihan::find()
        ->where("vcl_id_staf = $icno and vcl_kod_kompetensi = $type and (SUBSTRING(vcl_tkh_mula,1,4) = $currentYear or SUBSTRING(vcl_tkh_mula,1,4) = ($currentYear-1) or SUBSTRING(vcl_tkh_mula,1,4) = ($currentYear-2)) and hantar_penilaian = 1")
        ->all();
        return $this->renderAjax('idp',['model' =>$model]
        ); 
    }
    
    public function actionDeletefile($h)
    {
        Yii::$app->FileManager->DeleteFile($h);
    }
    
    public function actionDeletedokumen($id)
    {
        $model = TblSurat::find()->where(['id' => $id])->one();
        Yii::$app->FileManager->DeleteFile($model->dokumen);
        $model->delete();
    }
    
    public function actionMaklumatakademik($title, $id)
    {
        $model = Kontrak::find()->where(['id' => $id])->one();
       
        return $this->renderAjax('maklumatakademik',['model' =>$model,'title'=>$title]
        ); 
    }
    
    public function actionHindex()
    {
        $model = TblHindex::find()->where(['icno'=>Yii::$app->user->getId()])->exists()?
                TblHindex::find()->where(['icno'=>Yii::$app->user->getId()])->one():new TblHindex();
        $model->icno = Yii::$app->user->getId();
        if ($model->load(Yii::$app->request->post())) {
            $model->update_dt = date('Y-m-d H:i:s');
            $model->update_by = Yii::$app->user->getId();
            $model->save(false);
            $this->redirect(['mohonlanjut']);
        }
        return $this->renderAjax('_hindexform',['model' =>$model]
        ); 
    }
    
    public function actionTambahkpi($id, $kpi){
        $refkpi = RefKriteriaKpi::find()->where(['id' => $kpi])->one();
        $model = new TblKpi();
        $mesej = '';
        $kontrak = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->kriteriakpi_id = $kpi;
            $model->kontrak_id = $id;
            $model->perkara = 'amount';
            $model->perkara_2 = 'leader/member';
            $model->save();
            
        }
        
        if($kontrak->status == '14' && $kontrak->icno === Yii::$app->user->getId()){
        return $this->renderAjax('updatekpi', [
            'refkpi' => $refkpi,
            'model' => $model,
            'mesej' => $mesej
        ]);}
    }
    
    public function actionDeletekpi($id, $kontrak)
    {
        $kontrak = $this->findModel($kontrak);
        if($kontrak->icno === Yii::$app->user->getId()){
        TblKpi::find()->where(['id' => $id])->one()->delete();
        }
    }
    
    public function actionUpdatekpi($id, $kontrak){
        $model = TblKpi::find()->where(['id' => $id])->one();
        $refkpi = RefKriteriaKpi::find()->where(['id' => $model->kriteriakpi_id])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
        }
        $kontrak = $this->findModel($kontrak);
        
        if($kontrak->status == '14' && $kontrak->icno === Yii::$app->user->getId()){
        return $this->renderAjax('updatekpi', [
            'refkpi' => $refkpi,
            'model' => $model,
            'kontrak' => $kontrak
        ]);}
    }
    
    public function actionTetapan($end = null, $start = null, $nama = null){
        $dataProvider = new ActiveDataProvider([

            'query' => Tblprcobiodata::find()->joinWith('jawatan')->where(['gredjawatan.job_category' => '1', 'Status' => '1', 'statLantikan' => '3']),

            'pagination' => [

                'pageSize' => 50,

            ],
        ]);
        $dataProvider->query->orderBy([
            'endDateLantik' => SORT_ASC,
           ]); 
        if($end & $start){
            $start = date_format(date_create(Yii::$app->request->queryParams['start']), 'Y-m-d');
            $end = date_format(date_create(Yii::$app->request->queryParams['end']), 'Y-m-d');
        $dataProvider->query->andFilterWhere(['and', "endDateLantik"
            . ">='$start'", "endDateLantik <='$end'"]);
        }
        if($nama){
        $dataProvider->query->andFilterWhere(['like', 'tblprcobiodata.CONm', Yii::$app->request->queryParams['nama']]);
        }
        
        $selection=(array)Yii::$app->request->post('selection');//typecasting
        $arraynot = '';
            if (Yii::$app->request->post()) {
                foreach($selection as $id){   
                if(Kontrak::find()->where(['icno' => $id, 'job_category' => 1, 'status_bsm' => 6])->exists()){
                    $arraynot = $arraynot.Kontrak::find()->where(['icno' => $id])->one()->kakitangan->CONm.', ';
                }else{
                    $model = TblAkses::find()->where(['icno' => $id, 'role' => 'pemohon'])->exists()? 
                            TblAkses::find()->where(['icno' => $id, 'role' => 'pemohon'])->one() : new TblAkses();
                    $model->icno = $id;
                    $model->role = 'pemohon';
                    $model->job_category = 1;
                    $model->end_date = Yii::$app->request->post('tutup');
                    $model->start_date = date('Y-m-d');
                    $model->tahun = Yii::$app->request->post('tahun');
                    $model->sesi = Yii::$app->request->post('bil');
                    $model->save(false);
                    $kontrak = Kontrak::find()->where(['is', 'tarikh_m', new \yii\db\Expression('null')])->andWhere(['icno' => $id])->exists()? Kontrak::find()->where(['is', 'tarikh_m', new \yii\db\Expression('null')])->andWhere(['icno' => $id])->one(): new Kontrak();
                    $kontrak->icno = $id;
                    $kontrak->job_category = '1';
                    $kontrak->sesi_id = Yii::$app->request->post('bil');
                    $kontrak->tahun_sesi = Yii::$app->request->post('tahun');
                    $kontrak->status = '14';
                    $kontrak->startDateLantik = $kontrak->kakitangan->startDateLantik;
                    $kontrak->endDateLantik = $kontrak->kakitangan->endDateLantik;
                    $kontrak->save(false);
                    $this->notifikasi($id, 'For your information, your current contract period will end on '.date_format(date_create($model->kakitangan->endDateLantik), 'd F Y').'; Please submit your contract extension application through the system before or on '.date_format(date_create($model->end_date), 'd F Y').Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
                    
                }}
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Cannot open for '.$arraynot.' because there is existing pending application on their name']);
            }
        
        return $this->render('tetapan', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionLaporan($row, $id)
    {
        $model = Kontrak::find()->where(['id' => $id])->one();
        
        return $this->render('laporan',['model' =>$model, 'row'=> $row]
        );
    }
    
    public function actionData($sesis = null, $tahuns = null) {
        $arrayicno = array();
        if(!$sesis && !$tahuns){
             $akses = TblAkses::find()->where(['job_category' => 1, 'role' => 'pemohon'])->orderBy(['end_date' => SORT_DESC])->one();
             $sesis = $akses->sesi;
             $tahuns = $akses->tahun;
         }
        $query = Kontrak::find()->where(['job_category' => '1'])->andWhere(['sesi_id' => $sesis,'tahun_sesi' => $tahuns]);
        
        $listicno = empty($arrayicno)? array_column($query->all(), 'id') : $arrayicno;    
        $count = count($listicno);
        if($count<1){
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tiada Data Untuk Diproses']);
            return $this->redirect(['senarai']);
        }
        return $this->render('loading-bar', ['count'=> $count, 'listid' => $listicno
       ]);
    }
    
    public function actionLaporankpi($id){
        $kriteriakpi = RefKriteriaKpi::find()->where(['status'=> 1])->all();
        $kontrak = $this->findModel($id);
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($this->renderPartial('laporankpi', [
                    'kriteriakpi' => $kriteriakpi,
                    'id' => $id,
                    'kontrak' => $kontrak,
        ]));
        $mpdf->Output();
    }
    
    public function actionUpdate($id, $action_id=null)
    {
        $model = Kontrak::find()->where(['id' => $id])->one();
        $model->ver_by = $model->ver_by? : $model->icnoketuaprogram;
        $model->app_by = $model->app_by? : $model->icnoketuajfpiu;
        $message = '';
        if($action_id == 1){
            $model->status = 14;
            $model->status_pp = 14;
            $model->status_jfpiu = 14;
            $model->save(false);
            $this->notifikasi($model->icno, 'Your apllication has been returned to you and awaits for your action'.Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/mohonlanjut??id='.$model->id], ['class'=>'btn btn-primary btn-sm']));
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Berjaya dihantar']);
            return $this->redirect('senarai');
            
        }
        elseif($action_id == 2){
            $model->status_pp = 6;
            $model->status = 1;
            $model->status_jfpiu = 6;
            $model->save(false);
            return $this->redirect('senarai');
        }
        elseif($action_id == 3){
            $model->status_jfpiu = 6;
			$model->status = 2;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Berjaya dihantar']);
            return $this->redirect('senarai');  
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            $message = 'Saved';
            
        }
        
        return $this->renderAjax('update', [
           'model' => $model,
           'listname' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
            'message' => $message
        ]); 
    } 
}