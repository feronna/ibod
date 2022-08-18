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
use app\models\hronline\Vcpdlatihan;
use app\models\lnpt\Lpp;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use yii\web\UploadedFile;
use app\models\hronline\Tblanugerah;
use yii\data\ActiveDataProvider;
use app\models\kontrak\TblBukapermohonan;
use app\models\kontrak\TblAkses;
use app\models\hronline\Tblstat;
use app\models\lppums\TblSkt;
use app\models\lppums\TblSktTandatangan;
use app\models\lppums\TblLppTahun;
use app\models\lppums\TblRequest;
use app\models\lppums\TblMain;
use app\models\lppums\TblSktUlasan;
use tebazil\runner\ConsoleCommandRunner;
/**
 * KontrakController implements the CRUD actions for Kontrak model.
 */
class KontrakController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','belummohon','ringkasan_data','laporan', 'report','tetapanpembukaanpermohonan','editbukapermohonan','tindakan_bsm','semakanstatus', 'mohonlanjut', 'menunggu','permohonankontrak', 'datamesyuarat'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],  
                    ],
                    [
                        'actions' => ['semakanstatus', 'mohonlanjut'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $icno=Yii::$app->user->getId();
                            if($icno){
                            $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
                            if($biodata->statLantikan=='3' && $biodata->jawatan->job_category =='2'){
                                return true;
                            }else{
                                return false;
                            }}
                           
                        }
                    ],
                            [
                        'actions' => ['menunggu'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $icno=Yii::$app->user->getId();
                            $akses =  Kontrak::find()->where(['app_by' => $icno, 'job_category' => '2'])->orWhere(['ver_by' => $icno, 'job_category' => '2']);
                            if($akses->exists()){
                                return true;
                            }else{
                                return false;
                            }
                           
                        }
                    ],
                            [
                        'actions' => ['permohonankontrak', 'datamesyuarat','ringkasan_data','laporan', 'report'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $icno=Yii::$app->user->getId();
                            if(TblAkses::find()->where(['icno' => $icno,'job_category' => 2, 'role' => ['Admin', 'Ahli Mesyuarat']])->exists()){
                                return true;
                            }else{
                                return false;
                            }
                           
                        }
                    ],
                            [
                        'actions' => ['belummohon','tindakan_bsm', 'tetapanpembukaanpermohonan','editbukapermohonan'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $icno=Yii::$app->user->getId();
                            if(TblAkses::find()->where(['icno' => $icno,'job_category' => 2, 'role' => 'Admin'])->exists()){
                                return true;
                            }else{
                                return false;
                            }
                           
                        }
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
    protected function notifikasi($icno, $content){
        //--------Model Notification-----------//
                $ntf = new Notification(); //noti untuk kp
                $ntf->icno = $icno;
                $ntf->title = 'PELANTIKAN SEMULA KONTRAK';
                $ntf->content = $content;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save(false);
                //--------Model Notification-----------//
    }
    
    protected function pendingtask($icno, $id){
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }
    
    protected function newkontrakpentadbiran($reason, $file, $bolehmohon){
        
        $model = new Kontrak(); //noti untuk kp
        $model->icno = Yii::$app->user->getId();
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $model->reason = $reason;
        $model->tarikh_m = date('Y-m-d H:i:s');
        
        if($pegawai->sub_of == '' || $pegawai->sub_of == '12' || $pegawai->sub_of == '139'){
        $model->ver_by = $pegawai->pp; //kp
        $model->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        $model->ver_by = $pegawaisub->pp; //kp
        $model->app_by = $pegawaisub->chief; //kj 
        }
        
        $model->ver_by = $model->ver_by == $model->icno? '':$model->ver_by;
        
        if($model->ver_by == ''){ //jika pemohon tiada ketua pentadiran
            $model->status ='2'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $model->app_by;
            }
            else{
                $model->status_pp = '6';
                $model->status ='1';
                $petindak1='Ketua Pentadbiran';
                $icnopetindak1= $model->ver_by;
            }
        $model->job_category = '2';    
        $model->status_jfpiu = '6';
        $model->status_bsm = '6';
        $model->sesi_id = $bolehmohon->id;
        $model->tahun_sesi = $bolehmohon->tahun;
        $model->startDateLantik = $model->kakitangan->startDateLantik;
        $model->endDateLantik = $model->kakitangan->endDateLantik;
        
        if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'pelantikansemulakontrak');
                $filepath = $fileapi->file_name_hashcode;   
                if($fileapi->status != true) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Permohonan anda gagal dihantar.']);
                    return $this->redirect(['mohonlanjut']);
                }
        }
        else{
            $filepath = '';
        }
               
        $model->dokumen_sokongan = $filepath;
        $model->save(false);
        $this->pendingtask($icnopetindak1, 1);
        $this->notifikasi($icnopetindak1, "Permohonan pelantikan semula kontrak menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrak/menunggu'], ['class'=>'btn btn-primary btn-sm']));
        $this->notifikasi($model->icno, "Permohonan pelantikan semula kontrak anda telah dihantar untuk tindakan ".$petindak1);
                
    }
    
    public function actionIndex(){
        $icno=Yii::$app->user->getId();
        $current_date= date('Y-m-d');
        $akses = TblAkses::find()->where(['icno' => $icno,'job_category' => 1, 'role' => 'pemohon'])->one();
        $layak = TblBukapermohonan::find()->where(['and', "start_bolehmohon<='$current_date'", "end_bolehmohon>='$current_date'"]);
        $biodata = Tblprcobiodata::find()->where(['ICNO'=>$icno])->one();
        $end = $layak->max('end_bolehmohon');
        $start = $layak->min('start_bolehmohon');
        $kontrak = Kontrak::find()->where(['and', "tarikh_m<='$end'", "tarikh_m>='$start'"])->andWhere(['icno' => $icno]);
        if($biodata->statLantikan== '3' && $biodata->jawatan->job_category=="2" && $layak->min('start_tamatkontrak') <= $biodata->endDateLantik && $biodata->endDateLantik <= $layak->max('end_tamatkontrak')){
        if(!($kontrak->exists())){
            return $this->redirect('mohonlanjut'); 
        }else{
            return $this->redirect('semakanstatus');
        }
        }
        elseif($biodata->statLantikan== '3' && $biodata->jawatan->job_category=="2"){
            return $this->redirect('semakanstatus'); 
        }
        elseif($biodata->statLantikan== '3' && $biodata->jawatan->job_category=="1"){
        return $this->redirect(['kontrakakademik/mohonlanjut']);
        }
        elseif(Kontrak::find()->where(['app_by' => $icno, 'job_category' => '2'])->orWhere(['ver_by' => $icno, 'job_category' => '2'])->exists()){
        return $this->redirect('menunggu');}
        
        elseif(Kontrak::find()->where(['app_by' => $icno, 'job_category' => '1'])->exists()){
        return $this->redirect(['kontrakakademik/menunggu']);}
        
        elseif(Kontrak::find()->where(['ver_by' => $icno, 'job_category' => '1'])->exists()){
        return $this->redirect(['kontrakakademik/senarai-kp']);}
        
        elseif(TblAkses::find()->where(['icno' => $icno, 'job_category' => 2,'role' => 'Admin'])->exists()){
        return $this->redirect('senarai');}
        
        elseif(TblAkses::find()->where(['icno' => $icno, 'job_category' => 1,'role' => 'Admin'])->exists()){
        return $this->redirect(['kontrakakademik/senarai']);}
        
       elseif(TblAkses::find()->where(['icno' => $icno, 'job_category' => 2,'role' => 'Ahli Mesyuarat'])->exists()){
        return $this->redirect('datamesyuarat');}
        
        elseif(TblAkses::find()->where(['icno' => $icno, 'job_category' => 1,'role' => 'Ahli Mesyuarat'])->exists()){
        return $this->redirect(['kontrakakademik/datamesyuarat']);}
        
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['kehadiran/index']);
        
        }
    }
    
    public function actionSemakanstatus(){
        $icno=Yii::$app->user->getId();
        $model = Kontrak::find()->where(['icno' => $icno])->all();
        return $this->render('semakanstatus', [
            'model' => $model
        ]);
    }
    
    public function actionMohonlanjut()
    {
        $model = new Kontrak();
        $icno=Yii::$app->user->getId();
        $model->icno = $icno;
        $pp='';
        $kj='';
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $current_date= date('Y-m-d');
        $bolehmohon1 = TblBukapermohonan::find()->where(['<=', 'start_tamatkontrak', $model->kakitangan->endDateLantik])->andWhere(['>=', 'end_tamatkontrak', $model->kakitangan->endDateLantik])->one();
        $bolehmohon = TblBukapermohonan::find()->where(['and', "start_bolehmohon"
            . "<='$current_date'", "end_bolehmohon>='$current_date'"])->one();
        //$exists = $bolehmohon1? Kontrak::find()->where(['and', "tarikh_m<='$bolehmohon1->start_bolehmohon'", "tarikh_m>='$bolehmohon1->end_bolehmohon'"])->andWhere(['icno' => $icno]):'';
        if($pegawai->sub_of == '' || $pegawai->sub_of == '12' || $pegawai->sub_of == '139' ){
        if($pegawai->pp!=''){
        $pp = $pegawai->ppBiodata->CONm; //kp
        }
        $kj = $pegawai->chiefBiodata->CONm; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        if($pegawaisub->pp!=''){
        $pp = $pegawaisub->ppBiodata->CONm; //kp
        }
        $kj = $pegawaisub->chiefBiodata->CONm; //kj
        }
        
        if ($model->load(Yii::$app->request->post())) {
            if(Kontrak::find()->where(['icno' => $icno, 'sesi_id' => $bolehmohon->id, 'tahun_sesi' => $bolehmohon->tahun])->exists()){
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Anda sudah membuat permohonan']);
                return $this->redirect(['semakanstatus']);
            }
            $file = UploadedFile::getInstance($model, 'file');
            $this->newkontrakpentadbiran($model->reason, $file, $bolehmohon);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dihantar', 'type' => 'success', 'msg' => 'Permohonan anda telah berjaya dihantar.']);
            return $this->redirect(['semakanstatus']);
        }
        
        return $this->render('mohonlanjut', [
            'model' => $model,'pp' => $pp, 'kj' => $kj, 'bolehmohon1' => $bolehmohon1, 'icno' => $icno
        ]);
    }

   public function actionMenunggu()
    {
        $icno=Yii::$app->user->getId();
        
		$biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one(); 
        $noti = Notification::find()->where(['icno' => $icno, 'title' => 'PSK', 'status'=> '0'])->all();
        foreach($noti as $n){
            if(substr($n->content,0,6) != 'Adalah'){$n->status = '1'; $n->save(false);}
        }
        $titlepentadbiran = '';
        $senaraipentadbiran = '';
        if(Department::find()->where( ['pp' => $icno,'isActive' => '1'] )->exists()){
			$jfpiu = Department::find()->where( ['pp' => $icno,'isActive' => '1'] )->asArray()->all();
            $senaraipentadbiran = Kontrak::find()->where(['ver_by' => $icno, 'job_category' => '2'])->orderBy(['status' => SORT_ASC,'tarikh_m' => SORT_DESC]);
            $titlepentadbiran='Senarai Menunggu Persetujuan';
        }
        elseif(Department::find()->where( ['chief' => $icno,'isActive' => '1'])->exists()){
			$jfpiu = Department::find()->where( ['chief' => $icno,'isActive' => '1'] )->asArray()->all();
            $senaraipentadbiran = Kontrak::find()->where( ['app_by' => $icno,'job_category' => '2'])->orderBy([
            'status' => SORT_ASC,'ver_date' => SORT_DESC]);
            $titlepentadbiran='Senarai Menunggu Perakuan';
        } 
		// var_dump() ->andwhere(['tblprcobiodata.DeptID' => $biodata->DeptId])
		$arrayicno = array();
        foreach($senaraipentadbiran->all() as $d){
            if(in_array($d->kakitangan->department->id, array_column($jfpiu,'id'))){
                array_push($arrayicno, $d->icno);
            }
            if(in_array($d->kakitangan->department->sub_of, array_column($jfpiu,'id'))){
                array_push($arrayicno, $d->icno);
            }
        }
        
        $query = $senaraipentadbiran->andWhere(['icno' => $arrayicno]);
        
        $senaraipentadbirans = new ActiveDataProvider([

            'query' => $query,

            'pagination' => [

                'pageSize' => 20,

            ],

        ]);
          
        
        return $this->render('menunggu', [
            'icno' => $icno,
            'senaraipentadbiran' => $senaraipentadbirans,
            'titlepentadbiran' => $titlepentadbiran,
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
    
   public function actionTindakan_pp($id) {
     
        $model = $this->findModel($id);
        $post =Yii::$app->request->post('tempohs');
        $lantikan = Tblrscoapmtstatus::findAll(['ICNO' => $model->icno]);
        $anugerah = Tblanugerah::findAll(['ICNO' => $model->icno]);
        $latihan = Vcpdlatihan::findAll(['vcl_id_staf' => $model->icno]);
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        if($model->load(Yii::$app->request->post())) {
            $model->ver_date = date('Y-m-d H:i:s');
            if($model->tempoh_l_pp == 'Lain-lain'){$model->tempoh_l_pp = $post.' Bulan';}
            
            if($model->status_pp == '4') { 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Dipersetujui']);}
            elseif($model->status_pp == '5') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Ditolak']);}
            
            if($model->status_pp == '' || ($model->status_pp == '4' && ($model->tempoh_l_pp == '' || $model->tempoh_l_pp == ' Bulan'))){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            }
            else{   
                $model->status = '2';
                $model->save(false);
                $this->pendingtask($model->app_by, 1);
                $this->pendingtask($model->ver_by, 1);
                $this->notifikasi($model->icno, "Permohonan pelantikan semula kontrak anda telah dihantar untuk tindakan ketua jabatan. ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrak/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
                $this->notifikasi($model->app_by, "Permohonan pelantikan semula kontrak menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrak/menunggu'], ['class'=>'btn btn-primary btn-sm']));
                
                
                return $this->redirect(['kontrak/menunggu']);
            }
        }
            
        $countlantikan=0;
        if($lantikan){
            $countlantikan = count($lantikan);}
            
        if($icno==$model->ver_by){
        return $this->render('tindakan_pp', [
                    'lantikan' => $lantikan,
                    'model' => $model,
                    'today' => $today,
                    'latihan' => $latihan,
                    'icno' => $icno,
                    'countlantikan' => $countlantikan,
                    'anugerah' => $anugerah,
                    'bil' => '1',
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['kehadiran/index']);}
    }
    
    
    public function actionMtindakan_pp($id) {
        
        $model = $this->findModel($id);
        $post =Yii::$app->request->post('tempohs');
        $model->ver_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        if ($model->load(Yii::$app->request->post())) {
            if($model->tempoh_l_pp == 'Lain-lain'){
                $model->tempoh_l_pp = $post.' Bulan';
            }
            if ($model->status_pp == '4') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Dipersetujui']);
                    
                }
            elseif ($model->status_pp == '5') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Ditolak']);
                    
                }
                if($model->status_pp == '' || ($model->status_pp == '4' && ($model->tempoh_l_pp == '' || $model->tempoh_l_pp == ' Bulan'))){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
               return $this->redirect(['kontrak/menunggu']);
                }
            else{
                $model->status = '2';
                $model->save(false);
                $this->pendingtask($model->app_by, 1);
                $this->pendingtask($model->ver_by, 1);
                $this->notifikasi($model->icno, "Permohonan pelantikan semula kontrak anda telah dihantar untuk tindakan ketua jabatan. ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrak/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
                $this->notifikasi($model->app_by, "Permohonan pelantikan semula kontrak menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrak/menunggu'], ['class'=>'btn btn-primary btn-sm']));
                
            return $this->redirect(['kontrak/menunggu']);}
        }
        if($icno==$model->ver_by){
        return $this->renderAjax('mtindakan_pp', [
                    'model' => $model,
                    'today' => $today,
                    'icno' => $icno,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['kehadiran/index']);}
    }
    
    public function actionTindakan_jfpiu($id) {
     
        $model = $this->findModel($id);
        $post =Yii::$app->request->post('tempohs');
        $lantikan = Tblrscoapmtstatus::findAll(['ICNO' => $model->icno]);
        $anugerah = Tblanugerah::findAll(['ICNO' => $model->icno]);
        $latihan = Vcpdlatihan::findAll(['vcl_id_staf' => $model->icno]);
        $icno = Yii::$app->user->getId();
        if($lantikan){
            $countlantikan = count($lantikan);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->app_date = date('Y-m-d H:i:s');
            if($model->tempoh_l_jfpiu == 'Lain-lain'){
                $model->tempoh_l_jfpiu = $post.' Bulan';
            }
            if ($model->status_jfpiu == '4') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakui']);
                    
                }
            elseif ($model->status_jfpiu == '5') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Ditolak']);
                    
                }
                
                if($model->status_jfpiu == '' || (($model->status_jfpiu == '4' && ($model->tempoh_l_jfpiu == '' || $model->tempoh_l_jfpiu == ' Bulan')))){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }
               else{
                $model->status = '3';
                $model->save(false);
                $this->pendingtask($model->app_by, 1);
                $this->notifikasi($model->icno, "Permohonan pelantikan semula kontrak anda telah dihantar untuk tindakan BSM ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrak/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
               
                return $this->redirect(['kontrak/menunggu']);
        }}
        
        if($icno==$model->app_by){
        return $this->render('tindakan_jfpiu', [
                    'model' => $model,
                    'lantikan' => $lantikan,
                    'latihan' => $latihan,
                    'anugerah' => $anugerah,
                    'countlantikan' => $countlantikan,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['kehadiran/index']);}
    }

    
    public function actionMtindakan_jfpiu($id) {
     
        $model = $this->findModel($id);
        $post =Yii::$app->request->post('tempohs');
        $model->app_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        if ($model->load(Yii::$app->request->post())) {
            
            $model->status = '3';
            if($model->tempoh_l_jfpiu == 'Lain-lain'){
                $model->tempoh_l_jfpiu = $post.' Bulan';
            }
            if ($model->status_jfpiu == '4') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakui']);
                    
                }
            elseif ($model->status_jfpiu == '5') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Ditolak']);
                    
                }
                if($model->status_jfpiu == '' || (($model->status_jfpiu == '4' && ($model->tempoh_l_jfpiu == '' || $model->tempoh_l_jfpiu == ' Bulan')))){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
                return $this->redirect(['kontrak/menunggu']);
                }
               else{
                $model->status = '3';
                $model->save(false);
                $this->pendingtask($model->app_by, 1);
                $this->notifikasi($model->icno, "Permohonan pelantikan semula kontrak anda telah dihantar untuk tindakan BSM ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrak/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
                
            return $this->redirect(['kontrak/menunggu']);}
                }
               
        if($icno==$model->app_by){
        return $this->renderAjax('mtindakan_jfpiu', [
                    'model' => $model,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['kehadiran/index']);}
    }
    
     public function actionPermohonankontrak($id) {
     
        $model = $this->findModel($id);
        $lantikan = Tblrscoapmtstatus::findAll(['ICNO' => $model->icno]);
        $anugerah = Tblanugerah::findAll(['ICNO' => $model->icno]);
        if($lantikan){
            $countlantikan = count($lantikan);
        }
        
        return $this->render('permohonankontrak', [
                    'model' => $model,
                    'lantikan' => $lantikan,
                    'anugerah' => $anugerah,
                    'countlantikan' => $countlantikan,
        ]);
    }
    
     public function actionSenarai($icno=null, $statusbsm=null, $statuskj=null, $statuspp=null, $sesi=null, $tahun=null, $jawatan=null, $jfpiu=null)
    {
        $current = TblBukapermohonan::find()->where(['<=', 'start_bolehmohon', date('Y-m-d')])->andWhere(['>=', 'end_bolehmohon', date('Y-m-d')])->one();
        
        $sesi? :$sesi = $current->id;
        $tahun? :$tahun = $current->tahun;
        $data = Kontrak::find()->where(['job_category' => 2, 'sesi_id' => $sesi, 'tahun_sesi' => $tahun]);
        $arrayicno = array();
        
        if($jawatan || $jfpiu){
        foreach($data->all() as $d){
            if($jawatan && $jfpiu){ 
                $d->kakitangan->jawatan->id == $jawatan && $d->kakitangan->department->id == $jfpiu? array_push($arrayicno, $d->icno):'';}
            elseif($jawatan){
                $d->kakitangan->jawatan->id == $jawatan? array_push($arrayicno, $d->icno):'';
            }
            elseif($jfpiu){
                $d->kakitangan->department->id == $jfpiu? array_push($arrayicno, $d->icno):'';
        }}}
        
        $query = empty($arrayicno)? $data : $data->andWhere(['icno' => $arrayicno]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 30,],
        ]);
        
        $dataProvider->query->orderBy([
         'status_jfpiu' => SORT_ASC,
 //            new \yii\db\Expression("markah_PP >= '85' desc, markah_PP >= '80' desc, markah_PP >= '75' desc, markah_PP >= '70' desc"),
         new \yii\db\Expression("substr(tempoh_l_jfpiu, -5) = 'Tahun' desc, substr(tempoh_l_jfpiu, -5) = 'Bulan' desc"),
         'tempoh_l_jfpiu' => SORT_DESC,
 //            'markah_PP' => SORT_DESC 
        ]); 
        
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';
        $statuskj? $dataProvider->query->andFilterWhere(['status_jfpiu' => $statuskj]):'';
        $statuspp? $dataProvider->query->andFilterWhere(['status_pp' => $statuspp]):'';
        
        if($statusbsm){
        $statusbsm == 6? $dataProvider->query->andFilterWhere(['status_bsm' => [6,12,13]]):
        $dataProvider->query->andFilterWhere(['in', 'status_bsm',  $statusbsm]);
        
        }
        
        $selection=(array)Yii::$app->request->post('selection');
            if (Yii::$app->request->post('simpan')){
                foreach($selection as $id){
                    $model = $this->findModel($id);
                    $model->tempoh_l_bsm = Yii::$app->request->post('t'.$model->id);
                    if('y'.$model->id == Yii::$app->request->post($model->id)){
                    $model->status_bsm = '12';
                    }
                    elseif('n'.$model->id == Yii::$app->request->post($model->id)){
                    $model->status_bsm = '13';
                    }
                    $model->save(false);

            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Disimpan', 'type' => 'success', 'msg' => '']); 
            return $this->refresh();
            }

            elseif(Yii::$app->request->post('hantar')) {
                foreach($selection as $id){
                $hantar= $this->findModel($id);//make a typecasting
                if('n'.$hantar->id == Yii::$app->request->post($hantar->id)){
                    $hantar->status ='5';
                    $hantar->status_bsm='5';
                    
                    $this->notifikasi($hantar->icno, "Permohonan pelantikan semula kontrak anda tidak diluluskan.".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrak/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
                    
                }
                elseif('y'.$hantar->id == Yii::$app->request->post($hantar->id)){
                    $hantar->tempoh_l_bsm = Yii::$app->request->post('t'.$hantar->id);
                    $hantar->date_autoupdate = Yii::$app->request->post('autodate');
                    $hantar->update_by = Yii::$app->user->getId();
                     $hantar->status_bsm = '12';
                    if($hantar->tempoh_l_bsm != ''){
                    $hantar->status ='4';
                    $hantar->status_bsm='4';
                    
                    $this->notifikasi($hantar->icno, "Permohonan pelantikan semula kontrak anda diluluskan.".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrak/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
                    }  
                }
                $hantar->save(false);
                if($hantar->date_autoupdate == date('Y-m-d')){
                        if($hantar->startDateLantik == $hantar->kakitangan->startDateLantik){
                        $this->autoupdate($hantar->id);
                        
                        }
                    }
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dihantar', 'type' => 'success', 'msg' => '']); 
                return $this->refresh();
            }
            elseif (Yii::$app->request->post('searchs')) {
                $jawatan = Yii::$app->request->post('jawatan');
                $icno = Yii::$app->request->post('icno');
                $jfpiu = Yii::$app->request->post('jfpiu');
                $statusbsm = Yii::$app->request->post('statusbsm');
                $statuskj = Yii::$app->request->post('statuskj');
                $statuspp = Yii::$app->request->post('statuspp');
                return $this->redirect(array('kontrak/senarai', 'sesi'=>$sesi, 'statuspp'=> $statuspp, 'statuskj'=>$statuskj, 'tahun'=>$tahun, 'jawatan'=> $jawatan, 'icno' => $icno, 'jfpiu' => $jfpiu, 'statusbsm' => $statusbsm));
            
            }
            elseif(Yii::$app->request->post('notipemohon')){
               $this->notifipemohon();
               return $this->refresh();
            }
            elseif(Yii::$app->request->post('notipegawai')){
               $this->notifipegawai(); 
               return $this->refresh();
            }
       if(TblAkses::find()->where(['icno' => Yii::$app->user->getId(),'job_category' => 2, 'role' => 'Admin'])->exists()){
        return $this->render('senarai', [
            'dataProvider' => $dataProvider, 'statuskj' => $statuskj, 'statuspp' => $statuspp, 'statusbsm' => $statusbsm,
            'sesi' => $sesi,'tahun' => $tahun, 'jawatan' => $jawatan, 'icno' => $icno, 'jfpiu' => $jfpiu
       ]);}
       else{
       return $this->redirect('datamesyuarat');}
    }
    
    public function actionDatamesyuarat($icno=null, $statusbsm=null, $statuskj=null, $statuspp=null, $sesi=null, $tahun=null, $jawatan=null, $jfpiu=null)
    {
        $current = TblBukapermohonan::find()->where(['<=', 'start_bolehmohon', date('Y-m-d')])->andWhere(['>=', 'end_bolehmohon', date('Y-m-d')])->one();
        
        $sesi? :$sesi = $current->id;
        $tahun? :$tahun = $current->tahun;
        $data = Kontrak::find()->where(['job_category' => 2, 'sesi_id' => $sesi, 'tahun_sesi' => $tahun]);
        $arrayicno = array();
        
        if($jawatan || $jfpiu){
        foreach($data->all() as $d){
            if($jawatan && $jfpiu){ 
                $d->kakitangan->jawatan->id == $jawatan && $d->kakitangan->department->id == $jfpiu? array_push($arrayicno, $d->icno):'';}
            elseif($jawatan){
                $d->kakitangan->jawatan->id == $jawatan? array_push($arrayicno, $d->icno):'';
            }
            elseif($jfpiu){
                $d->kakitangan->department->id == $jfpiu? array_push($arrayicno, $d->icno):'';
            }}}
        
        $query = empty($arrayicno)? $data : $data->andWhere(['icno' => $arrayicno]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 30,],
        ]);
        
        $dataProvider->query->orderBy([
         'status_jfpiu' => SORT_ASC,
 //            new \yii\db\Expression("markah_PP >= '85' desc, markah_PP >= '80' desc, markah_PP >= '75' desc, markah_PP >= '70' desc"),
         new \yii\db\Expression("substr(tempoh_l_jfpiu, -5) = 'Tahun' desc, substr(tempoh_l_jfpiu, -5) = 'Bulan' desc"),
         'tempoh_l_jfpiu' => SORT_DESC,
 //            'markah_PP' => SORT_DESC 
        ]); 
        
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';
        $statuskj? $dataProvider->query->andFilterWhere(['status_jfpiu' => $statuskj]):'';
        $statuspp? $dataProvider->query->andFilterWhere(['status_pp' => $statuspp]):'';
        
        if($statusbsm){
        $statusbsm == 6? $dataProvider->query->andFilterWhere(['status_bsm' => [6,12,13]]):
        $dataProvider->query->andFilterWhere(['in', 'status_bsm',  $statusbsm]);
        
        }
            if (Yii::$app->request->post('searchs')) {
                $jawatan = Yii::$app->request->post('jawatan');
                $icno = Yii::$app->request->post('icno');
                $jfpiu = Yii::$app->request->post('jfpiu');
                $statusbsm = Yii::$app->request->post('statusbsm');
                $statuskj = Yii::$app->request->post('statuskj');
                $statuspp = Yii::$app->request->post('statuspp');
                return $this->redirect(array('kontrak/datamesyuarat', 'sesi'=>$sesi, 'statuspp'=> $statuspp, 'statuskj'=>$statuskj, 'tahun'=>$tahun, 'jawatan'=> $jawatan, 'icno' => $icno, 'jfpiu' => $jfpiu, 'statusbsm' => $statusbsm));
            
            }
            
            return $this->render('datamesyuarat', [
            'dataProvider' => $dataProvider, 'statuskj' => $statuskj, 'statuspp' => $statuspp, 'statusbsm' => $statusbsm,
            'sesi' => $sesi,'tahun' => $tahun, 'jawatan' => $jawatan, 'icno' => $icno, 'jfpiu' => $jfpiu
       ]);
    }
    
    public function actionTindakan_bsm($id)
    {
                $model = $this->findModel($id);
                $biodata = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
                $lantikan = new Tblrscoapmtstatus();
                
                if($model->status_bsm == '4' || $model->status_bsm == '5'){
                    $displaylapor='';$displaytempoh='none'; } 
                else{
                    $displaytempoh='';$displaylapor='none';}
                
                $message = '';
                    $display='none';
                    $lain= '';
                    if($model->tempoh_l_bsm != '1 Tahun' && $model->tempoh_l_bsm != '2 Tahun'&& $model->tempoh_l_bsm != ''){
                        $display='';
                        $lain= $model->tempoh_l_bsm;
                        $model->tempoh_l_bsm = 'Lain-lain';
                    }
                    
                if(Yii::$app->request->post()){
                    $post=Yii::$app->request->post('Kontrak')['tempoh_l_bsm'];
                    $model->tempoh_l_bsm = $post;
                    if($post == 'Lain-lain'){
                        $model->tempoh_l_bsm = Yii::$app->request->post('tempohs').' Bulan';
                    }
                    if(Yii::$app->request->post('lapordiri') == 'ya'){
                        $model->terima='ya';
                        $edl = str_replace('-', '/', $model->kakitangan->endDateLantik);
                        $biodata->startDateLantik= date('Y-m-d',strtotime($edl . "+1 days"));
                        $sdl = str_replace('-', '/', $biodata->startDateLantik);
                        if($model->tempoh_l_bsm == '1 Tahun'){
                            $biodata->endDateLantik= date('Y-m-d',strtotime($sdl . "+1 years -1 days"));
                        }
                        elseif($model->tempoh_l_bsm == '2 Tahun'){
                             $biodata->endDateLantik= date('Y-m-d',strtotime($sdl . "+2 years -1 days"));
                        }
                        else{
                            $biodata->endDateLantik = date('Y-m-d',strtotime($sdl . "+".(float)$model->tempoh_l_bsm." months -1 days"));
                        }
                        $lantikan->ICNO =$model->icno;
                        $lantikan->ApmtStatusCd= $biodata->statLantikan;
                        $lantikan->ApmtStatusStDt = $biodata->startDateLantik;
                        $lantikan->ApmtStatusEndDt = $biodata->endDateLantik;
                        $lantikan->save(false);
                        $biodata->save(false);
                        $model->save(false);
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                         return $this->redirect(['kontrak/senarai']);
                        }
                        if(Yii::$app->request->post('lapordiri') == 'tidak'){
                            $model->terima='tak';
                            $model->save(false);
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                         return $this->redirect(['kontrak/senarai']);
                        }
                    
                    $model->save(false);
                    $message = 'Berjaya Disimpan';
                }
            return $this->renderAjax('tindakan_bsm', [
                'model' => $model,
                'message' => $message,
                'displaylapor' => $displaylapor,
                'displaytempoh' => $displaytempoh,
                'display' => $display,
                'lain' => $lain
            ]); 
    }  
    
    public function actionBorangakuan(){
    $id = Yii::$app->user->getId();
    $model = Kontrak::findOne(['icno' => $id]);
    $mpdf = new \Mpdf\Mpdf();
    $pagecount = $mpdf->SetSourceFile('uploads/pelantikansemulakontrak/Borang Akuan.pdf');
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
    
    public function actionKontrakperkhidmatan(){
    $id = Yii::$app->user->getId();
    $model = Kontrak::findOne(['icno' => $id]);
    $mpdf = new \Mpdf\Mpdf();
    $pagecount = $mpdf->SetSourceFile('uploads/pelantikansemulakontrak/KontrakPerkhidmatan.pdf');
        for ($i=1; $i<=$pagecount; $i++) {
            $import_page = $mpdf->ImportPage($i);
            $mpdf->UseTemplate($import_page);
            $mpdf->WriteHTML($this->renderPartial('kontrakperkhidmatan', ['model' => $model, 'view' => $i]));
            
            if ($i < $pagecount){
                $mpdf->AddPage();}
        }
        $mpdf->Output();
    }
    
    public function actionTetapanpembukaanpermohonan() {
        
        $model = TblBukapermohonan::find()->All(); //cari senarai admin
        return $this->render('tetapanpembukaanpermohonan', [
            'model' => $model
        ]);
    }
    
    public function actionEditbukapermohonan($id) {
     
        $model = TblBukapermohonan::find()->where(['id' => $id])->one();
        if (Yii::$app->request->post()) {
           $data = Yii::$app->request->post();
           $model->start_tamatkontrak = date('Y-m-d H:i:s', strtotime($data['starttamatkontrak']));
           $model->end_tamatkontrak = date('Y-m-d H:i:s', strtotime($data['endtamatkontrak']));
           $model->start_bolehmohon = date('Y-m-d H:i:s', strtotime($data['startbolehmohon']));
           $model->end_bolehmohon = date('Y-m-d H:i:s', strtotime($data['endbolehmohon']));
           $model->tahun = $data['tahun'];
                
           $model->save(false);
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Perubahan Berjaya Disimpan']);
            return $this->redirect('tetapanpembukaanpermohonan');
        }
        
        return $this->render('editbukapermohonan', [
            'model' => $model
        ]);
    }
    
    protected function notifipemohon(){
        $current_date= date('Y-m-d');
        $layak = TblBukapermohonan::find()->where(['and', "start_bolehmohon<='$current_date'", "end_bolehmohon>='$current_date'"]);
//        $biodata = Tblprcobiodata::find()->where(['!=','statLantikan','1'])->all();
        $biodata = Tblprcobiodata::find()->where(['statLantikan'=>3])->all();
        $end = $layak->max('end_bolehmohon');
        $start = $layak->min('start_bolehmohon');
        if($layak){
        foreach ($biodata as $biodatas){
        $tarikhtamat = date_format(date_create($biodatas->endDateLantik),'Y-m-d');
        if($biodatas->jawatan->job_category=="2" && $tarikhtamat >= $layak->min('start_tamatkontrak') && $tarikhtamat <= $layak->max('end_tamatkontrak')){
          $model = Kontrak::find()->where(['and', "tarikh_m<='$end'", "tarikh_m>='$start'"])->andWhere(['icno' => $biodatas->ICNO])->one();  
          if(!$model){
            $this->notifikasi($biodatas->ICNO, "Adalah Dimaklumkan bahawa kontrak perkhidmatan tuan/puan akan tamat pada $biodatas->tarikhtamatlantik; Tuan/puan adalah dipelawa untuk mengemukakan permohonan pelantikan semula kontrak <b>DALAM KADAR SEGERA</b>; "
                            . "Kegagalan tuan/puan berbuat demikian akan dianggap tidak berminat untuk melanjutkan perkhidmatan di UMS.", ['kontrak/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']);
          }
        }
        }
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar']);
    }
    
    protected function resetpegawai(){
        $model = Kontrak::find()->where(['status' => ['1', '2'], 'job_category' => '2'])->all();
        
        foreach($model as $models){
        if($models->status == '1' || ($models->ver_by == NULL && $models->status_jfpiu == '6')){
        $pegawai = Department::findOne(['id' => $models->kakitangan->DeptId]);
        
        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $models->ver_by = $pegawai->pp; //kp
        $models->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        $models->ver_by = $pegawaisub->pp; //kp
        $models->app_by = $pegawaisub->chief; //kj 
        }
        $models->ver_by = $models->ver_by == $models->icno? '':$models->ver_by;
        if($models->ver_by == ''){ //jika pemohon tiada ketua pentadiran
            $models->status_pp = '';
            $models->status ='2'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $models->app_by;
            }
            else{
                $models->status_pp = '6';
                $models->status ='1';
                $petindak1='Ketua Pentadbiran';
                $icnopetindak1= $models->ver_by;
            }
            
        $models->status_jfpiu = '6';
        $models->status_bsm = '6';
        $models->save(false);
         }
        
        elseif ($models->status == '2') {
            
        $pegawai = Department::findOne(['id' => $models->kakitangan->DeptId]);
        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $models->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        $models->app_by = $pegawaisub->chief; //kj 
        }
        
        $models->save(false);
        }   
    }
    }
    
    protected function notifipegawai(){
        $this->resetpegawai();
        $ver = Kontrak::find()->where(['status' => '1', 'job_category' => '2'])->groupBy('ver_by')->all();
        $app = Kontrak::find()->where(['status' => '2', 'job_category' => '2'])->groupBy('app_by')->all();
        
        foreach($ver as $v){
          $this->notifikasi($v->ver_by, "Permohonan pelantikan semula kontrak menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrak/menunggu'], ['class'=>'btn btn-primary btn-sm']));  
        }
        foreach($app as $a){
          $this->notifikasi($a->app_by, "Permohonan pelantikan semula kontrak menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrak/menunggu'], ['class'=>'btn btn-primary btn-sm']));  
        }
    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar']);
    }
    
    public function actionBelummohon(){
        $current_date= date('Y-m-d');
        $layak = TblBukapermohonan::find()->where(['and', "start_bolehmohon<='$current_date'", "end_bolehmohon>='$current_date'"]);
        $biodata = Tblprcobiodata::find()->where(['!=','statLantikan','1'])->andWhere(['Status' => '1'])->all();
       
        return $this->render('belummohon', [
            'biodata' => $biodata,
            'layak' => $layak
        ]);
    }
    
    public function actionRingkasan_data($sesi, $tahun){
       return $this->render('ringkasan_data', ['sesi' => $sesi, 'tahun' => $tahun]); 
    }
    
    public function actionLaporan($sesi, $tahun, $no1, $tahunlnpt)
    {
        if($sesi == ""){
            $current_date= date('Y-m-d');
            $sesi = TblBukapermohonan::find()->where(['and', "start_bolehmohon"
            . "<='$current_date'", "end_bolehmohon>='$current_date'"])->one();
        }
        else{
        $sesi = TblBukapermohonan::find()->where(['id' => $sesi])->one();}
        
        if($tahun == ""){
            $tahun = $sesi->tahun;
        }
        
        $model = Kontrak::find()->where(['sesi_id' => $sesi->id, 'tahun_sesi' => $tahun])->orderBy([
            'status_jfpiu' => SORT_ASC,
//            new \yii\db\Expression("markah_PP >= '85' desc, markah_PP >= '80' desc, markah_PP >= '75' desc, markah_PP >= '70' desc"),
            new \yii\db\Expression("substr(tempoh_l_jfpiu, -5) = 'Tahun' desc, substr(tempoh_l_jfpiu, -5) = 'Bulan' desc"),
            'tempoh_l_jfpiu' => SORT_DESC,
//            'markah_PP' => SORT_DESC 
           ])->all();
        $count = count($model);
        return $this->render('laporan',['model' =>$model, 'sesi' => $sesi, 'tahun' => $tahun, 'count' => $count, 'no1'=> $no1, 'tahunlnpt' =>$tahunlnpt]
        ); 
    }
    
    public function actionReport($sesi, $tahun) {
        $sesi1 = $sesi;
        $tahun1= $tahun;
        if($sesi == ""){
            $current_date= date('Y-m-d');
            $sesi = TblBukapermohonan::find()->where(['and', "start_bolehmohon"
            . "<='$current_date'", "end_bolehmohon>='$current_date'"])->one();
        }
        else{
        $sesi = TblBukapermohonan::find()->where(['id' => $sesi])->one();}
        
        if($tahun == ""){
            $tahun = $sesi->tahun;
        }
        
        $model = Kontrak::find()->where(['sesi_id' => $sesi->id, 'tahun_sesi' => $tahun])->orderBy([
            'status_jfpiu' => SORT_ASC,
//            new \yii\db\Expression("markah_PP >= '85' desc, markah_PP >= '80' desc, markah_PP >= '75' desc, markah_PP >= '70' desc"),
            new \yii\db\Expression("substr(tempoh_l_jfpiu, -5) = 'Tahun' desc, substr(tempoh_l_jfpiu, -5) = 'Bulan' desc"),
            'tempoh_l_jfpiu' => SORT_DESC,
//            'markah_PP' => SORT_DESC 
           ])->all();
        $count = count($model);
        
        $arrayicno = array();        
        foreach($model as $m){
            array_push($arrayicno, $m->icno);
        }
        $tahunlnpt = \app\models\kontrak\Kontrak::latesttahuntempoh($arrayicno);
        $tahunlnpt<2010? $tahunlnpt = 2010:''; 
        
        if($count<1){
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tiada Data Untuk Diproses']);
            return $this->redirect(['senarai']);
        }
        return $this->render('report', ['count'=> $count, 'sesi'=> $sesi1, 'tahun' => $tahun1, 'tahunlnpt'=> $tahunlnpt
       ]);
    }
    
    public function actionTetapanakses() {
        
        $akses = TblAkses::find()->where(['job_category' => '2', 'role' => ['Admin', 'Ahli Mesyuarat']])->All(); //cari senarai admin akademik
        $aksesbaru = new TblAkses; //untuk admin baru
        if ($aksesbaru->load(Yii::$app->request->post())) {
                    if(TblAkses::find()->where( [ 'icno' => $aksesbaru->icno, 'job_category' => '2', 'role' => $aksesbaru->role] )->exists()){ //jika admin sudah wujud
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
                    }
                    else{
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                        $aksesbaru->job_category = 2;
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
    
    protected function autoupdate($id)
    {
        $model = Kontrak::find()->where(['id' => $id])->one();
        
        $permohonan = TblBukapermohonan::find()->where(['id' => $model->sesi_id])->one();
        $start_dt = $permohonan->new_start_date;
        
        $lantikan = new Tblrscoapmtstatus();
        if($model->tempoh_l_bsm == '1 Tahun'){
            $end_dt = date('Y-m-d',strtotime($start_dt . "+1 years -1 days"));
        }
        elseif($model->tempoh_l_bsm == '2 Tahun'){
             $end_dt= date('Y-m-d',strtotime($start_dt . "+2 years -1 days"));
        }
        else{
            $end_dt = date('Y-m-d',strtotime($start_dt . "+".(float)$model->tempoh_l_bsm." months -1 days"));
        }
        $lantikan->ICNO = $model->icno;
        $lantikan->ApmtStatusCd= $model->kakitangan->statLantikan;
        $lantikan->ApmtStatusStDt = $start_dt;
        $lantikan->ApmtStatusEndDt = $end_dt;
        $lantikan->save(false);
        
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $model->icno])->one();
        $biodata->endDateLantik = $end_dt;
        $biodata->startDateLantik = $start_dt;
        $biodata->save(false);
    }
    
    protected function findLpp($lpp_id)
    {
        if (($model = TblMain::findOne($lpp_id)) !== null) {
            return $model;
        }

        throw new UserException('The requested page does not exist.');
    }
    
    public function actionSktBahagian1($lpp_id=null , $icno = null, $tahun = null)
    {
        if(!$lpp_id){
            $lpp_id = \app\models\lppums\Lpp::find()->where(['PYD' => $icno, 'tahun' => $tahun])->one()->lpp_id;
        }
        //$tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);

        if ($req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO])) {
            $req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
            if (date('Y-m-d H:i:s') > $req->close_date) {
                $req->delete();
            }
        }

        \yii\helpers\Url::remember();
        $lpp = $this->findLpp($lpp_id);

        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);

        $skt = TblSkt::find()->where(['lpp_id' => $lpp_id])->andWhere(['skt_status' => null]);

        if (($tt = TblSktTandatangan::find()->where(['lpp_id' => $lpp_id])->one()) != null) {
            $tt = TblSktTandatangan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $tt = new TblSktTandatangan();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $skt,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 5,
            ],
            'sort' => false,
        ]);

        //        if (Yii::$app->request->isPost) {
        //            $tt->lpp_id = $lpp->lpp_id;
        //            $tt->skt_tt_pyd = $lpp->PYD;
        //            $tt->skt_tt_pyd_datetime = new \yii\db\Expression('NOW()');
        //            if ($tt->save(false)) {
        //                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disahkan!']);
        //                return $this->redirect(['lppums/skt-bahagian1', 'lpp_id' => $lpp->lpp_id]);
        //            }
        //        }

        return $this->render('skt_bhg1', [
            'tahun' => $tahun,
            'lpp' => $lpp,
            'dataProvider' => $dataProvider,
            'tt' => $tt,
            'req' => $req
        ]);
    }
    
        public function actionSktBahagian2($lpp_id)
    {
        //$tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);
        \yii\helpers\Url::remember();
        $lpp = $this->findLpp($lpp_id);

        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);

        if ($req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO])) {
            $req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
            if (date('Y-m-d H:i:s') > $req->close_date) {
                $req->delete();
            }
        }

        if (($skt_ulasan = TblSktUlasan::find()->where(['lpp_id' => $lpp_id])->one()) != null) {
            $skt_ulasan = TblSktUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $skt_ulasan = new TblSktUlasan();
        }

        $skt_tamb = TblSkt::find()->where(['lpp_id' => $lpp_id, 'skt_status' => 'TAMB']);

        $skt_gugur = TblSkt::find()->where(['lpp_id' => $lpp_id, 'skt_status_gugur' => 'GUGUR']);

        $skt = TblSkt::find()->where(['lpp_id' => $lpp_id])
            ->andWhere(['is', 'skt_status', null])
            ->andWhere(['is', 'skt_status_gugur', null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $skt_tamb,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 5,
            ],
            'sort' => false,
        ]);

        $dataProvider1 = new ActiveDataProvider([
            'query' => $skt_gugur,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 5,
            ],
            'sort' => false,
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $skt,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 5,
            ],
            'sort' => false,
        ]);

        // if ((Yii::$app->request->post('lpp_id'))) {
        //     $tt->lpp_id = $lpp->lpp_id;
        //     $tt->skt_tt_pyd = $lpp->PYD;
        //     $tt->skt_tt_pyd_datetime = new \yii\db\Expression('NOW()');
        //     if ($tt->save(false)) {
        //         \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disahkan!']);
        //         return $this->redirect(['lppums/skt-bahagian2', 'lpp_id' => $lpp->lpp_id]);
        //     }
        // }

        return $this->render('skt_bhg2', [
            'tahun' => $tahun,
            'lpp' => $lpp,
            'dataProvider' => $dataProvider,
            'dataProvider1' => $dataProvider1,
            'dataProvider2' => $dataProvider2,
            'ulasan' => $skt_ulasan,
            'req' => $req,
        ]);
    }

    public function actionSktBahagian3($lpp_id)
    {
        \yii\helpers\Url::remember();
        //$tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);
        $lpp = $this->findLpp($lpp_id);

        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y', 'lpp_tahun' => $lpp->tahun]);

        if ($req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO])) {
            $req = TblRequest::findOne(['lpp_id' => $lpp_id, 'ICNO' => Yii::$app->user->identity->ICNO]);
            if (date('Y-m-d H:i:s') > $req->close_date) {
                $req->delete();
            }
        }

        if (($skt_ulasan = TblSktUlasan::find()->where(['lpp_id' => $lpp_id])->one()) != null) {
            $skt_ulasan = TblSktUlasan::find()->where(['lpp_id' => $lpp_id])->one();
        } else {
            $skt_ulasan = new TblSktUlasan();
        }


        return $this->render('skt_bhg3', [
            'tahun' => $tahun,
            'lpp' => $lpp,
            'model' => $skt_ulasan,
            'req' => $req,
        ]);
    }
    
        public function actionSemakanKelayakan($id) {
        
        $model = $this->findModel($id);
        $model->ver_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');

        if($icno==$model->ver_by || $icno==$model->app_by){
        return $this->renderAjax('semakan-kelayakan', [
                    'model' => $model,
                    'today' => $today,
                    'icno' => $icno,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['kehadiran/index']);}
    }
    public function actionManualPengguna() { 
        return $this->render('manual_pengguna', [
                    'title' => 'Manual Pengguna',
        ]);
    } 
}
