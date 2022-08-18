<?php

namespace app\controllers;

use Yii;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\models\Notification;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use app\models\hronline\Department;
use app\models\cbelajar\TblUrusMesyuarat;
use app\models\cbelajar\TblLain;
use app\models\cbelajar\TblPengajian;
use app\models\hronline\Tblprcobiodata;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;

class CblainlainController extends \yii\web\Controller
{
     public function behaviors()
    {
        return [
          'access' => [
                
                
                
                'class' => AccessControl::className(),
                'only' => [ 'borang-permohonan','borang-permohonan-tukar-tarikh','borang-permohonan-tukar-tempat','mohon-penangguhan-pengajian','borang-permohonan-tukar-mod'
                    ],
                'rules' => [
                                        Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),

                    [
                        'actions' => ['borang-permohonan','borang-permohonan-tukar-tarikh','borang-permohonan-tukar-tempat',
                            'mohon-penangguhan-pengajian','borang-permohonan-tukar-mod'
                            ],
                        'allow' => true,
                        'matchCallback' => function($rule,$action)
                        {
                             
   $icno=Yii::$app->user->getId();
                            if($icno){
                            $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
                            if(($biodata->statLantikan=='1' && $biodata->jawatan->job_category =='1') ||
                               ($biodata->statLantikan=='2' && $biodata->jawatan->job_category =='1') || 
                               ($biodata->statLantikan=='1' && $biodata->jawatan->job_category =='2')){
                                return true;
                            }else{
                                return false;
                            }}
                           
                            if(in_array (Yii::$app->user->getId(),['950829125446','860130125080','891103125554']))
                            {
                                return TRUE;
                            }
                           
                                return FALSE;
                           
                        } ,
                    ],
                                
                                [
                        'actions' => ['senarai-borang'],
                        'allow' => true,
                        'matchCallback' => function($rule,$action)
                        {
                             

                            if((Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jawatan->job_category == "1") || 
                               (Yii::$app->user->identity->statLantikan == "2"  && Yii::$app->user->identity->jawatan->job_category == "1") ||
                               (Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jawatan->job_category == "2"))
                            {
                                return TRUE;
                            }
                           
                            if(in_array (Yii::$app->user->getId(),['891103125554']))
                            {
                                return TRUE;
                            }
                           
                                return FALSE;
                           
                        } ,
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
protected function ICNO() {

        return \Yii::$app->user->identity->ICNO;
    }
    protected function notifikasi($icno, $content){
        //--------Model Notification-----------//
                $ntf = new Notification(); //noti untuk kp
                $ntf->icno = $icno;
                $ntf->title = 'Permohonan Pertukaran Mod Pengajian Lanjutan';
                $ntf->content = $content;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                //--------Model Notification-----------//
    } 
public function actionIndex()
    {
        return $this->render('index');
    }
    
     public function actionHome()
    {  
          
        $model = new \app\models\cbelajar\TblPermohonan();
        
        return $this->render('index_1', [
            'model' => $model, 
            'bil' => 1,
            
        ]);
    }
    
public function actionBorangPermohonan($id)
    {
        $icno = Yii::$app->user->getId();  
        $iklan = $this->findIklanbyID($id);
        $biodata = $this->findBiodata();

        $pengajian = $this->findPengajian($id);
        $model = new \app\models\cbelajar\TblLain();
        $model->icno = $icno;  
        $model->tarikh_mohon = date('Y-m-d H:i:s');
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $pengajian2 = TblPengajian::find()->where(['icno'=>$icno,  'idBorang'=>1,'status'=>1 ])->one()?  TblPengajian::find()->where(['icno'=>$icno,  'idBorang'=>1, 'status'=>1])->one(): new TblPengajian();
        $file = UploadedFile::getInstance($model, 'file');
                $file2 = UploadedFile::getInstance($model, 'file2');

        $checkApplication = TblLain::find()->where(['status_borang' => "Selesai Permohonan",'icno' => $icno, 'iklan_id'=>$iklan->id, 'idBorang'=>22]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['cblainlain/lihat-permohonan', 'id'=>$iklan->id]);
        }
                 if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $model->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        $model->app_by = $pegawaisub->chief; //kj 
        }
//        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
////        $model->app_by = $pegawai->chief; //kj 
//            $model->app_by = 860130125080;
//        }
//        else{
//        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
////        $pegawaisub = 860130125080;
//        $model->app_by = 860130125080; //kj 
//        }
        if($model->ver_by == '')
        { 
            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $model->app_by;
        }
          $model->status_jfpiu = 'Tunggu Perakuan';
          $model->status_bsm = 'Tunggu Kelulusan';
//          $kerani=$model->ver_by;
//        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
//        $model->app_by = $pegawai->chief; //kj 
//        }
//        else{
//        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
//        $model->app_by = $pegawaisub->chief; //kj 
//        }
//        
//        if($model->ver_by == '')
//        { 
//            
//            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
//            $petindak1='Ketua Jabatan';
//            $icnopetindak1= $model->app_by;
//        }
//          $model->status_jfpiu = 'Tunggu Perakuan';
//          $model->status_bsm = 'Tunggu Kelulusan';
//          $model->status_semakan = 'Tunggu Semakan';
//          $model->status_bsm = 'Tunggu Kelulusan';
          
//          $model->status_semakan = 'Tunggu Semakan';
         if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lanjutan_cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        if($file2){
                $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'lanjutan_cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
       
        
       if((Yii::$app->request->post('simpan')))
        {
            $model->icno;
            $model->iklan_id=$iklan->id;
            $model->renewMod;
            $model->jenis_user_id = 1;
            $model->idBorang = 22;
            $model->dokumen_sokongan = $filepath;
                                    $model->dokumen = $filepath;

            $model->status_borang = "Data disimpan";
            $model->eduCd = $pengajian2->HighestEduLevelCd;
            $model->idStudy = $pengajian2->HighestEduLevelCd;
            $model->save(false);
            
            
        }
           elseif ($model->load(Yii::$app->request->post()))
                {
            $model->icno;
            $model->iklan_id=$iklan->id;
            $model->renewMod;
            $model->jenis_user_id = 1;
            $model->idBorang = 22;
            $model->eduCd = $pengajian2->HighestEduLevelCd;
            $model->idStudy = $pengajian2->id;
            $model->dokumen_sokongan = $filepath;
                        $model->dokumen = $filepath;

            $model->status_borang = "Selesai Permohonan ";
            $model->save(false);
           $this->notifikasi($icnopetindak1, "Permohonan Pertukaran Bidang Pengajian  menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/menunggu'], ['class'=>'btn btn-primary btn-sm']));
           $this->notifikasi($model->icno, "Permohonan Pertukaran Bidang Pengajian  anda telah dihantar untuk tindakan ".$petindak1. " ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));

                    Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Dihantar', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
                     return $this->redirect(['lihat-permohonan', 'id' => $iklan->id]);//
        
                }
        return $this->render('_borang', [
                    'model' => $model,
                    'iklan' => $iklan,
                    'pengajian' => $pengajian,
            'biodata' =>$biodata,
            'img'=> $biodata->img,
                   
        ]);
    }
    
    public function actionMohonTukarModPengajian($id)
    {
        $icno = Yii::$app->user->getId();  
        $iklan = $this->findIklanbyID($id);
        $biodata = $this->findBiodata();

        $pengajian = $this->findPengajian($id);
        $model = new \app\models\cbelajar\TblLain();
        $model->icno = $icno;  
        $model->tarikh_mohon = date('Y-m-d H:i:s');
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $pengajian2 = TblPengajian::find()->where(['icno'=>$icno,  'idBorang'=>1,'status'=>1 ])->one()?  TblPengajian::find()->where(['icno'=>$icno,  'idBorang'=>1, 'status'=>1])->one(): new TblPengajian();
        $file = UploadedFile::getInstance($model, 'file');
                $file2 = UploadedFile::getInstance($model, 'file2');

        $checkApplication = TblLain::find()->where(['status_borang' => "Selesai Permohonan",'icno' => $icno, 'iklan_id'=>$iklan->id, 'idBorang'=>49]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['cblainlain/lihat-permohonan', 'id'=>$iklan->id]);
        }
                 if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $model->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        $model->app_by = $pegawaisub->chief; //kj 
        }

         if($model->ver_by == '')
        { 
            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $model->app_by;
        }
          $model->status_jfpiu = 'Tunggu Perakuan';
          $model->status_bsm = 'Tunggu Kelulusan';
         if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lanjutan_cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        if($file2){
                $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'lanjutan_cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
       
        
       if((Yii::$app->request->post('simpan')))
        {
            $model->icno;
            $model->iklan_id=$iklan->id;
            $model->renewMod;
            $model->jenis_user_id = 1;
            $model->idBorang = 22;
            $model->dokumen_sokongan = $filepath;
                                    $model->dokumen = $filepath;

            $model->status_borang = "Data disimpan";
            $model->eduCd = $pengajian2->HighestEduLevelCd;
            $model->idStudy = $pengajian2->HighestEduLevelCd;
            $model->save(false);
            
            
        }
           elseif ($model->load(Yii::$app->request->post()))
                {
            $model->icno;
            $model->iklan_id=$iklan->id;
            $model->jenis_user_id = 1;
            $model->idBorang = 49;
            $model->eduCd = $pengajian2->HighestEduLevelCd;
            $model->idStudy = $pengajian2->id;
            $model->dokumen_sokongan = $filepath;
                        $model->dokumen = $filepath;

            $model->status_borang = "Selesai Permohonan ";
            $model->save(false);
           $this->notifikasi($icnopetindak1, "Permohonan Pertukaran Mod Pengajian  menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/menunggu'], ['class'=>'btn btn-primary btn-sm']));
           $this->notifikasi($model->icno, "Permohonan Pertukaran Mod Pengajian  anda telah dihantar untuk tindakan ".$petindak1. " ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));

                    Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Dihantar', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
                     return $this->redirect(['lihat-permohonan-mod', 'id' => $iklan->id]);//
        
                }
        return $this->render('_borangmod', [
                    'model' => $model,
                    'iklan' => $iklan,
                    'pengajian' => $pengajian,
            'biodata' =>$biodata,
            'img'=> $biodata->img,
                   
        ]);
    }
    protected function findPengajian($ICNO) {
        return TblPengajian::find()->where( ['icno' => $ICNO])->all();
    }
  
    public function actionBorangPermohonanTukarTempat($id)
    {
        $icno = Yii::$app->user->getId();  
        $iklan = $this->findIklanbyID($id);
        $model = new \app\models\cbelajar\TblLain();
        $model->icno = $icno; 
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $pengajian2 = TblPengajian::find()->where(['icno'=>$icno,  'idBorang'=>1,'status'=>1 ])->one()?  
         TblPengajian::find()->where(['icno'=>$icno,  'idBorang'=>1, 'status'=>1])->one(): new TblPengajian();
                $biodata = $this->findBiodata();
//        $pengajian = $this->findPengajian($id);

        $model->tarikh_mohon = date('Y-m-d H:i:s');
        $file = UploadedFile::getInstance($model, 'file');
                $file2 = UploadedFile::getInstance($model, 'file2');

        $checkApplication = TblLain::find()->where(['status_borang' => "Selesai Permohonan",'icno' => $icno, 'iklan_id'=>$iklan->id, 'idBorang'=>24]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['cblainlain/lihat-permohonan-tukar-tempat', 'id'=>$iklan->id]);
        }
//        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
////        $model->app_by = $pegawai->chief; //kj 
//            $model->app_by = 860130125080;
//        }
//        else{
//        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
////        $pegawaisub = 860130125080;
//        $model->app_by = 860130125080; //kj 
//        }
                 if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $model->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        $model->app_by = $pegawaisub->chief; //kj 
        }
        if($model->ver_by == '')
        { 
            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $model->app_by;
        }
          $model->status_jfpiu = 'Tunggu Perakuan';
          $model->status_bsm = 'Tunggu Kelulusan';
//         if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
//        $model->app_by = $pegawai->chief; //kj 
//        }
//        else{
//        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
//        $model->app_by = $pegawaisub->chief; //kj 
//        }
//        
//        if($model->ver_by == '')
//        { 
//            
//            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
//            $petindak1='Ketua Jabatan';
//            $icnopetindak1= $model->app_by;
//        }
//          $model->status_jfpiu = 'Tunggu Perakuan';
//          $model->status_bsm = 'Tunggu Kelulusan';
//       
          
//          $model->status_semakan = 'Tunggu Semakan';
         if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lanjutan_cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        if($file2){
                $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'lanjutan_cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        
       if((Yii::$app->request->post('simpan')))
        {
            $model->icno;
            $model->iklan_id=$iklan->id;
            $model->renewTempat;
            $model->jenis_user_id = 1;
            $model->idBorang = 24;
            $model->idStudy = $pengajian2->id;
            $model->eduCd = $pengajian2->HighestEdulevelCd;
            $model->dokumen_sokongan = $filepath;
                       $model->dokumen = $filepath;

            $model->status_borang = "Data disimpan";
            $model->save(false);
            
            
        }
           elseif ($model->load(Yii::$app->request->post()))
                {
            $model->icno;
            $model->iklan_id=$iklan->id;
            $model->renewTempat;
            $model->jenis_user_id = 1;
            $model->idBorang = 24;
          
            $model->idStudy = $pengajian2->id;
            $model->eduCd = $pengajian2->HighestEduLevelCd;
            $model->dokumen_sokongan = $filepath;
                       $model->dokumen = $filepath;

            $model->status_borang = "Selesai Permohonan ";
            $model->save(false);
                 
             
                  
            $this->notifikasi($icnopetindak1, "Permohonan Pertukaran Tempat Pengajian  menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/menunggu'], ['class'=>'btn btn-primary btn-sm']));
           $this->notifikasi($model->icno, "Permohonan Pertukaran Tempat Pengajian  anda telah dihantar untuk tindakan ".$petindak1. " ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
                    Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Dihantar', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
                     return $this->redirect(['lihat-permohonan-tukar-tempat', 'id' => $iklan->id]);//
        
                }
        return $this->render('_borangtempat', [
                    'model' => $model,
                    'iklan' => $iklan,
              'biodata'=>$biodata,
                'img'=>$biodata->img,
            'pengajian2'=>$pengajian2
                   
        ]);
    }
    
    
    public function actionBorangPermohonanTukarTarikh($id)
    {
        $icno = Yii::$app->user->getId();  
        $iklan = $this->findIklanbyID($id);
        $model = new \app\models\cbelajar\TblLain();
        $model->icno = $icno;  
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $pengajian2 = TblPengajian::find()->where(['icno'=>$icno,  'idBorang'=>1,'status'=>1 ])->one()?  TblPengajian::find()->where(['icno'=>$icno,  'idBorang'=>1, 'status'=>1])->one(): new TblPengajian();
                $biodata = $this->findBiodata();

        $model->tarikh_mohon = date('Y-m-d H:i:s');
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');

        $checkApplication = TblLain::find()->
                where(['status_borang' => "Selesai Permohonan",'icno' => $icno, 'iklan_id'=>$iklan->id, 
                    'idBorang'=>23]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['cblainlain/lihat-permohonan-tarikh', 'id'=>$iklan->id]);
        }
//        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
////        $model->app_by = $pegawai->chief; //kj 
//            $model->app_by = 860130125080;
//        }
//        else{
//        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
////        $pegawaisub = 860130125080;
//        $model->app_by = 860130125080; //kj 
//        }
        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $model->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        $model->app_by = $pegawaisub->chief; //kj 
        }
        if($model->ver_by == '')
        { 
            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $model->app_by;
        }
          $model->status_jfpiu = 'Tunggu Perakuan';
          $model->status_bsm = 'Tunggu Kelulusan';
//         if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
//        $model->app_by = $pegawai->chief; //kj 
//        }
//        else{
//        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
//        $model->app_by = $pegawaisub->chief; //kj 
//        }
//        
//        if($model->ver_by == '')
//        { 
//            
//            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
//            $petindak1='Ketua Jabatan';
//            $icnopetindak1= $model->app_by;
//        }
//          $model->status_jfpiu = 'Tunggu Perakuan';
//          $model->status_bsm = 'Tunggu Kelulusan';
       
          
//          $model->status_semakan = 'Tunggu Semakan';
         if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lanjutan_cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
          if($file2){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lanjutan_cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        
       if((Yii::$app->request->post('simpan')))
        {
            $model->icno;
            $model->iklan_id=$iklan->id;
            $model->renewTempat;
            $model->jenis_user_id = 1;
            $model->idBorang = 23;
            $model->dokumen_sokongan = $filepath;
            $model->dokumen = $filepath;

//             $model->renewTarikhm;
//            $model->renewTarikht;
            $model->idStudy = $pengajian2->id;
            $model->eduCd = $pengajian2->HighestEduLevelCd;
//            $model->full_dt = ['TblLain']['full_dt'];
            $model->status_borang = "Data disimpan";
            $model->jenismohon = "Tukar Tarikh";
            $model->save(false);
            
            
        }
           elseif ($model->load($post = Yii::$app->request->post()))
                {
            $model->icno;
            $model->iklan_id=$iklan->id;
            $model->renewTempat;
            $model->jenis_user_id = 1;
            $model->idBorang = 23;
            $model->dokumen_sokongan = $filepath;
            $model->dokumen = $filepath;
            $model->idStudy = $pengajian2->id;
            $model->eduCd = $pengajian2->HighestEduLevelCd;
            $model->renewTarikhm;
            $model->renewTarikht;
//            $model->full_dt = $post['TblLain']['full_dt'];
            $model->status_borang = "Selesai Permohonan ";
            $model->jenismohon = "Tukar Tarikh";
            $model->save(false);
                 
             
                $this->notifikasi($icnopetindak1, "Permohonan Pelarasan Tarikh Pengajian  menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cblainlain/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']));
           $this->notifikasi($model->icno, "Permohonan Pelarasan Tarikh Pengajian  anda telah dihantar untuk tindakan ".$petindak1. " ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));  

                    Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Dihantar', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
                     return $this->redirect(['lihat-permohonan-tarikh', 'id' => $iklan->id]);//
        
                }
        return $this->render('_borangtarikh', [
                    'model' => $model,
                    'iklan' => $iklan,
               'biodata'=>$biodata,
                'img'=>$biodata->img,
                   
        ]);
    }
     protected function findBiodata() {
        if (($model = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionMohonPenangguhanPengajian($id)
    {
        $icno = Yii::$app->user->getId();  
        $iklan = $this->findIklanbyID($id);
        $model = new \app\models\cbelajar\TblLain();
        $model->icno = $icno;
         $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $pengajian2 = TblPengajian::find()->where(['icno'=>$icno,  'idBorang'=>1,'status'=>1 ])->one()?  TblPengajian::find()->where(['icno'=>$icno,  'idBorang'=>1, 'status'=>1])->one(): new TblPengajian();
        $biodata = $this->findBiodata();
        $pengajian = TblPengajian::find()->where(['icno' =>$this->ICNO(),'iklan_id' => $id, 'idBorang'=>1,'status'=>1])->all();

        $model->tarikh_mohon = date('Y-m-d H:i:s');
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');

        $checkApplication = TblLain::find()->where(['status_borang' => "Selesai Permohonan",'icno' => $icno, 'iklan_id'=>$iklan->id, 'idBorang'=>31]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['cblainlain/lihat-permohonan-tangguh-pengajian', 'id'=>$iklan->id]);
        }
//       if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
////        $model->app_by = $pegawai->chief; //kj 
//            $model->app_by = 860130125080;
//        }
//        else{
//        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
////        $pegawaisub = 860130125080;
//        $model->app_by = 860130125080; //kj 
//        }
         if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $model->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        $model->app_by = $pegawaisub->chief; //kj 
        }
        if($model->ver_by == '')
        { 
            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $model->app_by;
        }
          $model->status_jfpiu = 'Tunggu Perakuan';
          $model->status_bsm = 'Tunggu Kelulusan';

//        
//        if($model->ver_by == '')
//        { 
//            
//            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
//            $petindak1='Ketua Jabatan';
//            $icnopetindak1= $model->app_by;
//        }
//          $model->status_jfpiu = 'Tunggu Perakuan';
//          $model->status_bsm = 'Tunggu Kelulusan';          
//          $model->status_semakan = 'Tunggu Semakan';
         if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lanjutan_cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
         if($file2){
                $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'lanjutan_cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        
       if((Yii::$app->request->post('simpan')))
        {
            $model->icno;
            $model->iklan_id=$iklan->id;
//            $model->jenis_user_id = 1;
            $model->idBorang = 31;
            $model->idStudy = $pengajian2->id;
            $model->eduCd = $pengajian2->HighestEduLevelCd;
            $model->dokumen_sokongan = $filepath;
           $model->dokumen = $filepath;
            $model->status_borang = "Data disimpan";
            $model->save(false);
            
            
        }
           elseif ($model->load(Yii::$app->request->post()))
                {
            $model->icno;
            $model->iklan_id=$iklan->id;
//            $model->jenis_user_id = 1;
            $model->idBorang = 31;
            $model->idStudy = $pengajian2->id;
            $model->eduCd = $pengajian2->HighestEduLevelCd;
            $model->dokumen_sokongan = $filepath;
                       $model->dokumen = $filepath;

            $model->status_borang = "Selesai Permohonan ";
            $model->save(false);
                 
             
               $this->notifikasi($icnopetindak1, "Permohonan Pelarasan Tarikh Pengajian  menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cblainlain/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']));
           $this->notifikasi($model->icno, "Permohonan Pelarasan Tarikh Pengajian  anda telah dihantar untuk tindakan ".$petindak1. " ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));      

                    Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Dihantar', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
                     return $this->redirect(['lihat-permohonan-tangguh-pengajian', 'id' => $iklan->id]);//
        
                }
        return $this->render('_borangtangguh', [
                    'model' => $model,
                    'iklan' => $iklan,
                    'biodata'=> $biodata,
                    'img' => $biodata->img,
            'pengajian'=>$pengajian,
                   
        ]);
    }
    public function actionRekodLain()
    {

        $model = new TblLain();
        $icno=Yii::$app->user->getId();
        $model->icno = $icno;
        $statuslain = TblLain::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
        $searchModel = new \app\models\cbelajar\TblLainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $ver = TblLain::find()->where(['ver_by' => $icno, 'status_borang' => "Selesai Permohonan"])->orderBy(['tarikh_m' => SORT_DESC]);
        return $this->render('rekodsemasa', [
            'model' => $model,
            'statuslain' => $statuslain,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ver' => $ver,
            'bil' => 1,
            'icno' => $icno
        ]);
    }
    
    public function actionSenaraitindakan()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai  = '';
        
        $status = ['Tunggu Perakuan', 'Diperakukan', 'Tidak Diperakukan'];
          $a = (Department::find()->where( ['chief' => $icno, 'isActive' => '1']));
        $b = (\app\models\cbelajar\TblAccess::find()->where( ['icno' => $icno] ));
       if ($a || $b ->exists())
       {
$senarai = TblLain::find()->where(['app_by' => $icno, 'status_borang' => "Selesai Permohonan"])->orderBy(['tarikh_mohon' => SORT_DESC]);
            $title='Senarai Menunggu Perakuan';
        }
//       if(Department::find()->where( ['chief' => $icno, 'isActive' => '1'] )->exists()){
//            $senarai = TblPermohonan::find()->where(['app_by' => $icno, 'status_proses' => "Selesai Permohonan"])->orderBy(['tarikh_m' => SORT_DESC]);
//            $title='Permohonan Baharu';
//        }
//     
//       if(Department::find()->where( ['chief' => $icno, 'isActive' => '1'] )->exists()){
//            $senarai = TblLain::find()->where(['app_by' => $icno, 'status_borang' => "Selesai Permohonan"])->orderBy(['tarikh_mohon' => SORT_DESC]);
//            $title='Senarai Menunggu Perakuan';
//        }
        
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
          
        
        if($title != NULL){ 
        return $this->render('senarai_tindakan', [
            'icno' => $icno,
            'senarai' => $senarais,
            'title' => $title,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['index']);}  
    }
    
     public function actionLihatPermohonan($id){
        $icno=Yii::$app->user->getId();
        $model = TblLain::findOne(['iklan_id'=>$id,'icno' => $icno, 'status_borang' => "Selesai Permohonan"]);
                          $biodata = $this->findBiodata();

        $iklan = $this->findIklanbyID($id);
        
         if(($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="1")|| ($model->kakitangan->statLantikan== "2" && $model->kakitangan->jawatan->job_category=="1") || ($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="2")) {
              if(TblLain::find()->where(['icno' => $icno, 'iklan_id'=>$id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {{
        }
         return $this->render('_lihatpermohonan', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
              'biodata'=>$biodata,
                'img'=>$biodata->img,
            ]);
         }}
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('../cbelajar/permohonan-semasa');}
        
    }
     public function actionLihatPermohonanMod($id){
        $icno=Yii::$app->user->getId();
        $model = TblLain::findOne(['iklan_id'=>$id,'icno' => $icno, 'status_borang' => "Selesai Permohonan"]);
                          $biodata = $this->findBiodata();

        $iklan = $this->findIklanbyID($id);
        
         if(($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="1")|| ($model->kakitangan->statLantikan== "2" && $model->kakitangan->jawatan->job_category=="1") || ($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="2")) {
              if(TblLain::find()->where(['icno' => $icno, 'iklan_id'=>$id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {{
        }
         return $this->render('_lihatpermohonanmod', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
              'biodata'=>$biodata,
                'img'=>$biodata->img,
            ]);
         }}
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('../cbelajar/permohonan-semasa');}
        
    }
    public function actionLihatPermohonanTukarTempat($id){
        $icno=Yii::$app->user->getId();
        $model = TblLain::findOne(['iklan_id'=>$id,'icno' => $icno, 'status_borang' => "Selesai Permohonan"]);
         $biodata = $this->findBiodata();

        $iklan = $this->findIklanbyID($id);
        
         if(($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="1")|| ($model->kakitangan->statLantikan== "2" && $model->kakitangan->jawatan->job_category=="1") || ($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="2") || ($model->kakitangan->statLantikan== "3" && $model->kakitangan->jawatan->job_category=="2")) {
              if(TblLain::find()->where(['icno' => $icno, 'iklan_id'=>$id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {{
        }
         return $this->render('_lihatpermohonantempat', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
                'biodata'=>$biodata,
                'img'=>$biodata->img
             
            ]);
         }}
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('../cbelajar/permohonan-semasa');}
        
    }
    public function actionLihatPermohonanTangguhPengajian($id){
        $icno=Yii::$app->user->getId();
        $model = TblLain::findOne(['iklan_id'=>$id,'icno' => $icno, 'status_borang' => "Selesai Permohonan"]);
              $biodata = $this->findBiodata();

        $iklan = $this->findIklanbyID($id);
        
         if(($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="1")|| ($model->kakitangan->statLantikan== "2" && $model->kakitangan->jawatan->job_category=="1") || ($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="2")) {
              if(TblLain::find()->where(['icno' => $icno, 'iklan_id'=>$id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {{
        }
         return $this->render('_lihatpermohonantangguh', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
             'biodata'=>$biodata,
                'img'=>$biodata->img,
//                'i'=>$i,
                'id'=>$id
            ]);
         }}
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('halaman-pemohon');}
        
    }
    public function actionLihatPermohonanTarikh($id){
        $icno=Yii::$app->user->getId();
        $model = TblLain::findOne(['iklan_id'=>$id,'icno' => $icno, 'status_borang' => "Selesai Permohonan", 'jenismohon'=>"Tukar Tarikh"]);
                      $biodata = $this->findBiodata();

        $iklan = $this->findIklanbyID($id);
        
         if(($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="1")|| ($model->kakitangan->statLantikan== "2" && $model->kakitangan->jawatan->job_category=="1") || ($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="2")) {
              if(TblLain::find()->where(['icno' => $icno, 'iklan_id'=>$id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {{
        }
         return $this->render('_lihatpermohonantarikh', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
                'img'=>$biodata->img,
             
             
            ]);
         }}
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('halaman-pemohon');}
        
    }
    public function actionCetakPermohonan($id) {
       $icno=Yii::$app->user->getId();
//       $model = $this->findMaklumat();
       $model = TblLanjutan::findOne(['iklan_id'=>$id,'icno' => $icno, 'status_borang' => "Selesai Permohonan"]);
       Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'filename' => '_CUTIBELAJAR_'.$id,
            'mode' => Pdf::MODE_BLANK, // leaner size using standard fonts
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('/lanjutancb/_cetakborang', [
            'model' => $model,
                ]),
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => [
             
            ],
           
        ]);
        return $pdf->render();
    }
//     protected function findModel($id){
//        
//        if (($model = TblLanjutan::findOne($id)) !== null) {
//            return $model;
//        }
//
//        throw new NotFoundHttpException('The requested page does not exist.');
//    }
    
    public function actionTindakanKj($id,$i) {
         $icno=Yii::$app->user->getId();
//        $model = TblLain::findOne(['iklan_id'=>$id,'icno' => $icno]);
         $model = TblLain::find()->where(['iklan_id'=> $id, 'id'=>$i])->one();
                $biodata = $this->findBiodata();
        $iklan = $this->findIklanbyID($id);
        
         if($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
             $model->status_bsm = 'Tunggu Kelulusan BSM';
            $model->app_date = date('Y-m-d H:i:s');
            if($model->status_jfpiu == 'Diperakukan') { 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);}
            elseif($model->status_jfpiu == 'Tidak Diperakukan') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Tidak Diperakukan!']);}
            $model->save(false);
          $ntf = new Notification();
            $ntf->icno = 891103125554; // peg  penyelia perjawatan
            $ntf->title = 'Permohonan Pertukaran Tempat Pengajian Lanjutan';
            $ntf->content = "Permohonan Pertukaran Tempat Pengajian menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakan1'], ['class'=>'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
             $ntf->save(false);   
             $this->notifikasi($model->icno, "Permohonan Pertukaran Tempat Pengajian Lanjutan anda telah dihantar untuk tindakan BSM. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
    
                return $this->redirect(['cblainlain/senaraitindakan']);
        }



        if($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}  
          
        if(Yii::$app->user->getId()==$model->app_by){
        return $this->render('_tindakankj', [
                   
              'iklan' => $iklan,
              'model' => $model,
           'biodata'=>$biodata,

            'img'=>$biodata->img,
              'bil' => '1',
              'edit' => $edit,
              'view' => $view,
//            'b'=>$b,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
        
    }
     public function actionAdminview($id, $i){
        $icno=Yii::$app->user->getId();
         $model = TblLain::find()->where(['iklan_id'=> $id, 'id'=>$i])->one();
         $biodata = $this->findBiodata();

        $iklan = $this->findIklanbyID($id);
        
        
        if(\app\models\cbelajar\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
         return $this->render('adminview', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
//           
                  'biodata'=>$biodata,
            'img'=>$biodata->img,
            ]);
         }
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('cutibelajar/index');}
        
    }
    public function actionAdminviewbidang($id, $i){
        $icno=Yii::$app->user->getId();
         $model = TblLain::find()->where(['iklan_id'=> $id, 'id'=>$i])->one();
         $biodata = $this->findBiodata();
        $iklan = $this->findIklanbyID($id);
        
        if(\app\models\cbelajar\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
         return $this->render('adminviewbidang', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
                'biodata'=>$biodata,
                'img'=>$biodata->img,
//           
                
            ]);
         }
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('halaman-pemohon');}
        
    }
    public function actionAdminviewtarikh($id, $i){
         $model = TblLain::find()->where(['iklan_id'=> $id, 'id'=>$i])->one();
         $biodata = $this->findBiodata();

        $iklan = $this->findIklanbyID($id);
        
        
        if(\app\models\cbelajar\TblAccess::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
         return $this->render('adminviewtarikh', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
              'biodata'=>$biodata,
                'img'=>$biodata->img,
                
            ]);
         }
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('cutibelajar/index');}
        
    }
    public function actionAdminviewtangguh($id, $i){
        $icno=Yii::$app->user->getId();
         $model = TblLain::find()->where(['iklan_id'=> $id, 'id'=>$i])->one();
         $biodata = $this->findBiodata();

        $iklan = $this->findIklanbyID($id);
        
        
        if(\app\models\cbelajar\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
         return $this->render('adminviewtangguh', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
              'biodata'=>$biodata,
                'img'=>$biodata->img,
                
            ]);
         }
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('halaman-pemohon');}
        
    }
      public function actionAdminviewmod($id, $i){
        $icno=Yii::$app->user->getId();
         $model = TblLain::find()->where(['iklan_id'=> $id, 'id'=>$i])->one();
         $biodata = $this->findBiodata();

        $iklan = $this->findIklanbyID($id);
        
        
        if(\app\models\cbelajar\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
         return $this->render('adminviewmod', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
              'biodata'=>$biodata,
                'img'=>$biodata->img,
                
            ]);
         }
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('/cutibelajar/index');}
        
    }
 public function actionTindakanKjbidang($id,$i) {
         $icno=Yii::$app->user->getId();
//        $model = TblLain::findOne(['iklan_id'=>$id,'icno' => $icno]);
          $model = TblLain::find()->where(['iklan_id'=> $id, 'id'=>$i])->one();
                $biodata = $this->findBiodata();
          $iklan = $this->findIklanbyID($id);
                 $biodata2 = $this->findBiodata();

         if($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
                         $model->status_bsm = 'Tunggu Kelulusan BSM';

            $model->app_date = date('Y-m-d H:i:s');
            if($model->status_jfpiu == 'Diperakukan') { 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);}
            elseif($model->status_jfpiu == 'Tidak Diperakukan') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Tidak Diperakukan!']);}
            $model->save(false);
            $ntf = new Notification();
            $ntf->icno = 891103125554; // peg  penyelia perjawatan
            $ntf->title = 'Permohonan Pertukaran Bidang Pengajian Lanjutan';
            $ntf->content = "Permohonan Pertukaran Bidang Pengajian menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakan1'], ['class'=>'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
             $ntf->save(false); 
             $this->notifikasi($model->icno, "Permohonan Pertukaran Bidang Pengajian  anda telah dihantar untuk tindakan BSM. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
    
                return $this->redirect(['cblainlain/senaraitindakan']);
        }



        if($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}  
          
        if(Yii::$app->user->getId()==$model->app_by){
        return $this->render('_tindakankjbidang', [
                   
              'iklan' => $iklan,
              'model' => $model,
              'biodata'=>$biodata,
                                   'biodata2'=>$biodata2,

            'img'=>$biodata2->img,
              'bil' => '1',
              'edit' => $edit,
              'view' => $view,
//            'b'=>$b,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
        
    }
public function actionTindakanKjtarikh($id,$i) {
         $icno=Yii::$app->user->getId();
//        $model = TblLain::findOne(['iklan_id'=>$id,'icno' => $icno]);
          $model = TblLain::find()->where(['iklan_id'=> $id, 'id'=>$i])->one();
          $is = $model->idStudy;
//                   $b = $this->findStudy($is);
                $biodata = $this->findBiodata();
                 $biodata2 = $this->findBiodata();

          $iklan = $this->findIklanbyID($id);
        
         if($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
                         $model->status_bsm = 'Tunggu Kelulusan BSM';

            $model->app_date = date('Y-m-d H:i:s');
            if($model->status_jfpiu == 'Diperakukan') { 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);}
            elseif($model->status_jfpiu == 'Tidak Diperakukan') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Tidak Diperakukan!']);}
            $model->save(false);
 $ntf = new Notification();
            $ntf->icno = 891103125554; // peg  penyelia perjawatan
            $ntf->title = 'Permohonan Perlarasan Tarikh Pengajian Lanjutan';
            $ntf->content = "Permohonan Pertukaran Tempat Pengajian menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakan1'], ['class'=>'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
             $ntf->save(false); 
             $this->notifikasi($model->icno, "Permohonan Perlarasan Tarikh Pengajian  anda telah dihantar untuk tindakan BSM. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
    
                return $this->redirect(['cblainlain/senaraitindakan']);
        }



        if($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}  
          
        if(Yii::$app->user->getId()==$model->app_by){
        return $this->render('_tindakankjtarikh', [
                   
              'iklan' => $iklan,
              'model' => $model,
              'bil' => '1',
              'edit' => $edit,
              'view' => $view,
            'biodata'=>$biodata,
                                   'biodata2'=>$biodata2,

            'img'=>$biodata2->img,
//            'b'=>$b,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
        
    }
    protected function findStudy($id) {
        return \app\models\cbelajar\TblPengajian::findOne(['id' => $id]);
    }
    public function actionTindakanKjtangguh($id,$i) {
         $icno=Yii::$app->user->getId();
//        $model = TblLain::findOne(['iklan_id'=>$id,'icno' => $icno]);
          $model = TblLain::find()->where(['iklan_id'=> $id, 'id'=>$i])->one();
                $biodata = $this->findBiodata();
                 $biodata2 = $this->findBiodata();

          $iklan = $this->findIklanbyID($id);
        
         if($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
                         $model->status_bsm = 'Tunggu Kelulusan BSM';

            $model->app_date = date('Y-m-d H:i:s');
            if($model->status_jfpiu == 'Diperakukan') { 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);}
            elseif($model->status_jfpiu == 'Tidak Diperakukan') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Tidak Diperakukan!']);}
            $model->save(false);
 $ntf = new Notification();
            $ntf->icno = 891103125554; // peg  penyelia perjawatan
            $ntf->title = 'Permohonan Penangguhan Pengajian Lanjutan';
            $ntf->content = "Permohonan Pertukaran Tempat Pengajian menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakan1'], ['class'=>'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
             $ntf->save(false); 
             
             $this->notifikasi($model->icno, "Permohonan Penangguhan Pengajian Lanjutan  anda telah dihantar untuk tindakan BSM. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
    
                return $this->redirect(['cblainlain/senaraitindakan']);
        }



        if($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}  
          
        if(Yii::$app->user->getId()==$model->app_by){
        return $this->render('_tindakankjtangguh', [
                   
              'iklan' => $iklan,
              'model' => $model,
           'biodata'=>$biodata,
                                   'biodata2'=>$biodata2,

            'img'=>$biodata2->img,
              'bil' => '1',
              'edit' => $edit,
              'view' => $view,
//            'b'=>$b,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
        
    }
      public function actionTindakanKjmod($id,$i) {
         $icno=Yii::$app->user->getId();
//        $model = TblLain::findOne(['iklan_id'=>$id,'icno' => $icno]);
          $model = TblLain::find()->where(['iklan_id'=> $id, 'id'=>$i])->one();
                $biodata = $this->findBiodata();
                 $biodata2 = $this->findBiodata();

          $iklan = $this->findIklanbyID($id);
        
         if($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
                         $model->status_bsm = 'Tunggu Kelulusan BSM';

            $model->app_date = date('Y-m-d H:i:s');
            if($model->status_jfpiu == 'Diperakukan') { 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);}
            elseif($model->status_jfpiu == 'Tidak Diperakukan') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Tidak Diperakukan!']);}
            $model->save(false);
 $ntf = new Notification();
            $ntf->icno = 870818495847; // peg  penyelia perjawatan
            $ntf->title = 'Permohonan Pertukaran Mod Pengajian Lanjutan';
            $ntf->content = "Permohonan Pertukaran Mod Pengajian menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakan1'], ['class'=>'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
             $ntf->save(false); 
             
             $this->notifikasi($model->icno, "Permohonan Penangguhan Pengajian Lanjutan  anda telah dihantar untuk tindakan BSM. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
    
                return $this->redirect(['cblainlain/senaraitindakan']);
        }



        if($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}  
          
        if(Yii::$app->user->getId()==$model->app_by){
        return $this->render('_tindakankjmod', [
                   
              'iklan' => $iklan,
              'model' => $model,
           'biodata'=>$biodata,
                                   'biodata2'=>$biodata2,

            'img'=>$biodata2->img,
              'bil' => '1',
              'edit' => $edit,
              'view' => $view,
//            'b'=>$b,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
        
    }
        
    protected function findMaklumat() {
        if (($model = TblLanjutan::findOne(['icno' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }     
     protected function findIklanbyID($id) {
        if (($model = TblUrusMesyuarat::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findPrestasi($id) {
        return \app\models\cbelajar\TblPrestasi::findOne(['id' => $id]);
    }
    

public function actionCetakBidang($id,$i){
         $model = TblLain::find()->where(['iklan_id'=> $i, 'id'=>$id])->one();
         $biodata = $this->findBiodata();
         $iklan = $this->findIklanbyID($i);
//          $pengajian = $this->findPengajian($ICNO);

             $content = $this->renderPartial('cetak-bidang', [ 'model' => $model,
              'biodata' => $biodata,
                 'iklan'=>$iklan,
             ]);

       
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
              
            'options' => ['title' => 'Permohonan Cuti Belajar'],
            // call mPDF methods on the fly
              
         
            'methods' => [
//              'SetHeader' => ['Permohonan Baharu Pengajian Lanjutan,Unit Pengembangan Profesionalisme'],
                     'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
             
            ] ,           // call mPDF methods on the fly
            
        ]);

        return $pdf->render();
           
        
       
    }
    
}