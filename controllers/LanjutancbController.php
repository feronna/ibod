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
use app\models\hronline\Tblprcobiodata;
use yii\filters\AccessControl;

use app\models\cbelajar\TblUrusMesyuarat;
use app\models\cbelajar\TblLanjutan;
use app\models\cbelajar\TblAdmin;
use app\models\cbelajar\TblLkk;
use tebazil\runner\ConsoleCommandRunner;


use kartik\mpdf\Pdf;




class LanjutancbController extends \yii\web\Controller
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
                'only' => [ 'borang-permohonan','senaraitindakan','lihat-permohonan','adminview','tindakan-kj'
                    ],
                'rules' => [
                                        Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),

                    [
                        'actions' => ['borang-permohonan','senaraitindakan','lihat-permohonan','adminview', 'tindakan-kj'],
                        'allow' => true,
                        'matchCallback' => function($rule,$action)
                        {
                              
                            $icno=Yii::$app->user->getId();
                            if($icno){
                            $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
                            if(($biodata->statLantikan=='1' && $biodata->jawatan->job_category =='1') ||
                               ($biodata->statLantikan=='2' && $biodata->jawatan->job_category =='1') || 
                               ($biodata->statLantikan=='1' && $biodata->jawatan->job_category =='2') ||
                                    ($biodata->statLantikan=='3' && $biodata->jawatan->job_category =='1')){
                                return true;
                               }
                            }
            
//                            if((Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jobCategory == "1") 
//                           || (Yii::$app->user->identity->statLantikan == "2"  && Yii::$app->user->identity->jobCategory == "1"))
//                          {
//                             return TRUE;
//                           }
                           
                            if(in_array (Yii::$app->user->getId(),['950829125446','860130125080','870818495847']))
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
                           
                            if(in_array (Yii::$app->user->getId(),['870818495847']))
                            {
                                return TRUE;
                            }
                           
                                return FALSE;
                           
                        } ,
                    ],
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
                $ntf->title = 'Permohonan Pengajian Lanjutan';
                $ntf->content = $content;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                //--------Model Notification-----------//
    } 
public function actionIndex()
    {

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);


        $current_date = date('Y-m-d');

        $a = (Department::find()->where(['chief' => $icno, 'isActive' => '1']));
        $b = (\app\models\cbelajar\TblAccess::find()->where(['icno' => $icno, 'level' => 2]));
        //       $c = 
        if ($a ->exists()) {
            return $this->redirect('../cutisabatikal/senaraitindakan');
        }
        //        if(Department::find()->where( ['chief' => $icno, 'isActive' => '1'] )->exists() )||   (\app\models\cbelajar\TblAccess::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
        //{
        //        return $this->redirect('../cutisabatikal/senaraitindakan');} 
  elseif (\app\models\cbelajar\TblAccess::find()->where(['icno' => Yii::$app->user->getId(),'level'=>2])->exists()) {
            return $this->redirect(['/cbadmin/halaman-admin']);
        }
        
        elseif (($biodata->statLantikan == "1"  && $biodata->jawatan->job_category == "1") || ($biodata->statLantikan == "2"  && $biodata->jawatan->job_category == "1")
                || ($biodata->statLantikan == "1"  && $biodata->jawatan->job_category == "2") || ($biodata->statLantikan == "2"  && $biodata->jawatan->job_category == "2")) { //jika user staf lantikan tetap & belum disahkan & staf pentadbiran
            return $this->redirect('../cutibelajar/halaman-pemohon');
        }
         elseif (\app\models\cbelajar\TblAccess::find()->where(['icno' => Yii::$app->user->getId(),'level'=>99])->exists()) {
            return $this->redirect(['/cb-lkk/halaman-penyelia-ums']);
        }
        
//         elseif (\app\models\cbelajar\TblAccess::find()->where(['icno' => Yii::$app->user->getId(),'level'=>99])->exists()) {
//            return $this->redirect(['/cb-lkk/halaman-penyelia']);
//        }
      
        else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('index');
        }
        $model = new TblPermohonan();
    }
    protected function findStudy($id) {
        return \app\models\cbelajar\TblPengajian::findOne(['icno' => $id, 'status'=>1]);
    }
    
      protected function findLanjutan($id,$edu) {
        return \app\models\cbelajar\TblLanjutan::findOne(['icno' => $id,'HighestEduLevelCd'=>$edu]);
    }
public function actionBorangPermohonan($id)
    {
        $icno = Yii::$app->user->getId();  
        $iklan = $this->findIklanbyID($id);
        $model = new \app\models\cbelajar\TblLanjutan();
        $mod = new \app\models\cbelajar\TblPrestasi();
        $model->icno = $icno; 
        $b = $this->findStudy($icno);
        $edu = $b->HighestEduLevelCd;
        $l = $this->findLanjutan($icno,$edu);
        $doktoral = \app\models\cbelajar\RefPrestasi::find()->all();
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
//        $admin = \app\models\cbelajar\TblAccess::find()->where(['icno'=> Yii::$app->user->getId(), 'level'=>2]);
//                TblAccess::find()->where( ['icno'=> Yii::$app->user->getId(), 'level'=>1] )->exists()
        $model->tarikh_mohon = date('Y-m-d H:i:s');
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
        $file3 = UploadedFile::getInstance($model, 'file3');
        $file4 = UploadedFile::getInstance($model, 'file4');
        $file5 = UploadedFile::getInstance($model, 'file5');

        $lkk = TblLkk::find()->where(['icno' => $icno, 'status_borang' => "Complete"])->orderBy(['tarikh_mohon'=>SORT_DESC]) ->one();

        $checkApplication = TblLanjutan::find()->where(['status_borang' => "Selesai Permohonan",'icno' => $icno, 'iklan_id'=>$iklan->id]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['lanjutancb/lihat-permohonan', 'id'=>$iklan->id]);
        }
                if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $model->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        $model->app_by = $pegawaisub->chief; //kj 
        }
        $checkCount = TblLanjutan::find()->where(['status_b' => 1 ,'icno' => $icno])->count();
        if($checkCount >= 3){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Harap Maaf, Pelanjutan anda telah mencapai maksimum 3 Pelanjutan'
                ]);
        
            return $this->redirect(['cbelajar/senarai-borang?id='.$iklan->id]);
        }
        if($model->ver_by == '')
        { 
            
            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $model->app_by;
        }

          $model->status_jfpiu = 'Tunggu Perakuan';
          $model->status_bsm = 'Tunggu Kelulusan';
          $model->status_semakan = 'Tunggu Semakan';
//
//          $kerani=$model->ver_by;
//          $admin= $model->ver_by;

          
         if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lanjutan_cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        if($file2){
                $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'lanjutan_cb');
                $filepath2 = $fileapi->file_name_hashcode;   
        }
        else{
            $filepath2 = '';
        }
        if($file3){
                $fileapi = Yii::$app->FileManager->UploadFile($file3->name, $file3->tempName, '04', 'lanjutan_cb');
                $filepath3 = $fileapi->file_name_hashcode;   
        }
        else{
            $filepath3 = '';
        }
        if($file4){
                $fileapi = Yii::$app->FileManager->UploadFile($file4->name, $file4->tempName, '04', 'lanjutan_cb');
                $filepath4 = $fileapi->file_name_hashcode;   
        }
        else{
            $filepath4 = '';
        }
          if($file5){
                $fileapi = Yii::$app->FileManager->UploadFile($file5->name, $file5->tempName, '04', 'lanjutan_cb');
                $filepath5 = $fileapi->file_name_hashcode;   
        }
        else{
            $filepath5 = '';
        }
       if((Yii::$app->request->post('simpan')))
        {
            $model->icno;
            $model->iklan_id=$iklan->id;
            $model->alamat;
            $model->justifikasi;
            $model->jenis_user_id = 1;
//            $model->status_b = 9;

            $model->idBorang =3;
            $model->lanjutansdt;
            $model->lanjutanedt;
            $model->HighestEduLevelCd = $b->HighestEduLevelCd;
            
          
//
//            if($model->idLanjutan == 1)
//            {
//                $model->idLanjutan = 2;
//                
//            }
//            elseif($model->idLanjutan == 2)
//            {
//                $model->idLanjutan = 3;
//            }
//            else{
//                $model->idLanjutan =1;
//        }
            $model->dokumen_sokongan = $filepath;
            $model->dokumen_sokongan2 = $filepath2;
             $model->dokumen = $filepath3;
            $model->dokumen2 = $filepath4;
            $model->status_borang = "Data disimpan";
            $model->save(false);
            
            foreach ($doktoral as $dok)
            {
                 $mod = new \app\models\cbelajar\TblPrestasi();
                 $mod->catatan = Yii::$app->request->post($dok->id) ;
                 $mod->idlanjutan = $model->id;
                 $mod->idPrestasi = $doktoral->id;
                 $mod->iklan_id = $iklan->id;
                 $mod->save(false);
            }
        }
           elseif ($model->load(Yii::$app->request->post()))
                {
            $model->icno;
            $model->iklan_id=$iklan->id;
            $model->alamat;
            $model->justifikasi;
            $model->jenis_user_id = 1;
//                        $model->status_b = 9;

            $model->idBorang =3;
            $model->lanjutansdt;
            $model->lanjutanedt;
            $model->HighestEduLevelCd = $b->HighestEduLevelCd;
//                        if($model->idLanjutan == 1)
//            {
//                $model->idLanjutan = 2;
//                
//            }
//            elseif($model->idLanjutan == 2)
//            {
//                $model->idLanjutan = 3;
//            }
//            else{
//                $model->idLanjutan =1;
//        }
            $model->dokumen_sokongan = $filepath;
            $model->dokumen_sokongan2 = $filepath2;
              $model->dokumen = $filepath3;
            $model->dokumen2 = $filepath4;
             $model->dokumen3 = $filepath5;
            $model->status_borang = "Selesai Permohonan ";
            $model->save(false);
            
            foreach ($doktoral as $dok)
            {
                 $mod = new \app\models\cbelajar\TblPrestasi();
                 $mod->catatan = Yii::$app->request->post($dok->id) ;
                 $mod->idlanjutan = $model->id;
                 $mod->idPrestasi = $dok->id;
                 $mod->iklan_id = $iklan->id;
                 $mod->save(false);
                
            }
                        $this->pendingtask($icnopetindak1, 16);

                    $this->notifikasi($icnopetindak1, "Permohonan Pelanjutan Tempoh Cuti Belajar  menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['lanjutancb/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']));
                    $this->notifikasi($model->icno, "Permohonan Pelanjutan Tempoh Cuti Belajar  anda telah dihantar untuk tindakan ".$petindak1. " ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
//                    $this->notifikasi($kerani, "Permohonan Pelanjutan Tempoh Cuti Belajar  menunggu tindakan anda. ");
                    Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Dihantar', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
                     return $this->redirect(['lihat-permohonan', 'id' => $iklan->id]);//
        
                }
          
            
    
        return $this->render('_borang', [

                    'model' => $model,
                    'mod' => $mod,
                    'doktoral' => $doktoral,
                    'iklan' => $iklan,
                    'b'=>$b,
                    'l'=>$l,
            'lkk'=>$lkk
                 
          
                   
        ]);
    }
     protected function pendingtask($icno, $id){
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }
    public function actionSenaraitindakan()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai  = '';
        $status = ['Tunggu Perakuan', 'Diperakukan', 'Tidak Diperakukan','TELAH DISEMAK'];
        $a = (Department::find()->where( ['chief' => $icno, 'isActive' => '1']));
        $b = (\app\models\cbelajar\TblAccess::find()->where( ['icno' => $icno] ));
       if ($a || $b ->exists())
       {
//       ->exists()) || (\app\models\cbelajar\TblAccess::find()->where( ['icno' => $icno] )->exists()){
           $senarai = TblLanjutan::find()->where(['app_by' => $icno])->orderBy(['tarikh_mohon' => SORT_DESC]);
            $title='Senarai Menunggu Perakuan';
        }
//        if(Department::find()->where( ['chief' => $icno, 'isActive' => '1'] )->exists()){
//            $senarai = TblLanjutan::find()->where(['app_by' => $icno])->orderBy(['tarikh_mohon' => SORT_DESC]);
//            $title='Senarai Menunggu Perakuan';
//        }
        elseif(TblAdmin::find()->where( ['icno' => $icno] )->exists()){
            $senarai = TblLanjutan::find()->where([ 'status_borang' => "Selesai Permohonan"])->orderBy(['tarikh_mohon' => SORT_DESC]);
            $title='Senarai Menunggu Semakan';
        }
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
        return $this->redirect(['kemudahan/index']);}  
    }
//     public function actionKomenPrestasi($id)
//    {
//        $i=Yii::$app->user->getId();
//        $model = \app\models\cbelajar\TblPrestasi::find()->where(['idLanjutan'=>$id])->one();
////        $icno = $model->icno;
////        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//
////        $icno = $model->icno;
//        $b = $this->findPengajian2($id);
//        $biasiswa = $this->findBiasiswa($id);
//
////        var_dump('a');die;
//        if ($model->load(Yii::$app->request->post())) {
//              $model->created_dt = new \yii\db\Expression('NOW()');
//              $model->update_by = $i;
////              $model->pID= $pengajian->id;
//              $model->save(false);
//              Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);
//
//            return $this->redirect(['view-lkk', 'id'=>$model->icno]);
//        }
//
//        return $this->renderAjax('lkk/up-lkk', [
//            'model' => $model,
////            'tajaan' =>$tajaan,
////            't'=>$t,
//            'biasiswa'=>$biasiswa,
////            'data'=> $data,
////            'lapor' =>$lapor,
//'b' =>$b,
////            'allbiodata' => $allbiodata,
//        ]);
//    }
    public function actionRekodLanjutan()
    {

        $model = new TblLanjutan();
        $icno=Yii::$app->user->getId();
        $model->icno = $icno;
        $status = \app\models\cbelajar\TblLanjutan::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
//        $statuslain = \app\models\cbelajar\TblLain::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
//        $lapordiri = \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
//        $statustiket = \app\models\cbelajar\BorangPenerbangan::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
        $searchModel = new \app\models\cbelajar\TblLanjutanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $model = TblPermohonan::find()->where(['icno' => $icno])->orderBy([ 'status' => SORT_ASC])->all();
        
//        $ver = TblPermohonan::findAll(['ver_by' => $icno]);
        $ver = TblLanjutan::find()->where(['ver_by' => $icno, 'status_borang' => "Selesai Permohonan"])->orderBy(['tarikh_m' => SORT_DESC]);

        return $this->render('rekodsemasa', [
            'model' => $model,
//            'statustiket' => $statustiket,
            'status' => $status,
//            'statuslain' => $statuslain,
//            'lapordiri' => $lapordiri,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ver' => $ver,
            'bil' => 1,
            'icno' => $icno
        ]);
    }
     public function actionLihatPermohonan($id){
        $icno=Yii::$app->user->getId();
        $model = TblLanjutan::findOne(['iklan_id'=>$id,'icno' => $icno, 'status_borang' => "Selesai Permohonan"]);
        $doktoral = \app\models\cbelajar\RefPrestasi::find()->all();
        $mod = \app\models\cbelajar\TblPrestasi::findOne(['id' => $id]);//senarai status permohonan
        $iklan = $this->findIklanbyID($id);
//        $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno'=>$icno, 'status_borang'=> "Complete"])->one();
        $lkk = TblLkk::find()->where(['icno' => $icno, 'status_borang' => "Complete"])->orderBy(['tarikh_mohon'=>SORT_DESC]) ->one();

        $b = $this->findStudy($icno);
//  var_dump($model->idLanjutan);die;
         if(($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="1")|| ($model->kakitangan->statLantikan== "2" && $model->kakitangan->jawatan->job_category=="1")) {
              if(TblLanjutan::find()->where(['icno' => $icno, 'iklan_id'=>$id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {
         return $this->render('_lihatpermohonan', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
              'doktoral' => $doktoral,
              'mod' => $mod,
                'b'=>$b,
                'lkk'=>$lkk,
            ]);
         }}
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('halaman-utama-pemohon');}
        
    }
    public function actionAdminview($id, $i){
        $icno=Yii::$app->user->getId();
        $model = TblLanjutan::findOne(['id'=>$i,'iklan_id'=>$id, 'status_borang' => "Selesai Permohonan"]);
        $p=$model->icno;
        $lkk = TblLkk::find()->where(['icno' => $p, 'status_borang' => "Complete"])->orderBy(['tarikh_mohon'=>SORT_DESC]) ->one();
        $b = $this->findStudy($p);

        $doktoral = \app\models\cbelajar\RefPrestasi::find()->all();
        $mod = \app\models\cbelajar\TblPrestasi::findOne(['id'=>$id,  'idlanjutan'=>$i]);//senarai status permohonan
        $iklan = $this->findIklanbyID($id);
        $b = $this->findStudy($p);
                $model->c_date = date('Y-m-d H:i:s');

                $biodata = $this->findBiodata();
                if($model->load(Yii::$app->request->post())) {
      
                    if($model->status_semakan == 'Layak Dipertimbangkan') { 
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Semakan Disimpan!']);}
                    elseif($model->status_semakan == 'Dokumen Tidak Lengkap') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Dokumen Tidak Lengkap', 'type' => 'danger', 'msg' => 'Semakan Disimpan!']);}
                             elseif($model->status_semakan == 'Tidak Layak Dipertimbangkan') {
                            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Layak Dipertimbangkan', 'type' => 'danger', 'msg' => 'Telah Disemak!']);
                    }
                    
                    $model->save(false);
                        return $this->redirect(['lanjutancb/adminview', 'id'=> $id, 'i'=> $i]);
                }
         if($model->status_semakan == 'Layak Dipertimbangkan' || 
                $model->status_semakan == 'Dokumen Tidak Lengkap' || $model->status_semakan == 'Tidak Layak Dipertimbangkan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}
        
        if(\app\models\cbelajar\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
         return $this->render('adminview', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
              'doktoral' => $doktoral,
              'mod' => $mod,
              'b'=>$b,
               'biodata'=>$biodata,
                'img'=>$biodata->img,
                'lkk'=>$lkk,
                'view'=>$view,
                'edit'=>$edit,
                'b'=>$b,
                
            ]);
         }
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('cutibelajar/halaman-pemohon');}
        
    }
    public function actionUpdateSemakan($id, $i) {
        $model = TblLanjutan::find()->where(['id'=>$i,'iklan_id'=>$id, 'status_borang' => "Selesai Permohonan"])->one();
        $iklan = $this->findIklanbyID($id);

        if (($model->load(Yii::$app->request->post()))) {
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['adminview?id='.$model->iklan_id.'&i='.$i]);
        }
        

        return $this->renderAjax('_updates', [
                    'model' => $model,
                    'iklan' => $iklan,
        
        ]);
    }
    public function actionUpdateSemakans($id,$i) {
        $model = TblLanjutan::find()->where(['id'=>$i,'iklan_id'=>$id, 'status_borang' => "Selesai Permohonan"])->one();
        $iklan = $this->findIklanbyID($id);
        if (($model->load(Yii::$app->request->post()))) {
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['adminview?id='.$model->iklan_id.'&i='.$i]);
        }
        

        return $this->renderAjax('_updatess', [
                    'model' => $model,
                    'iklan'=>$iklan
        
        ]);
    }
     protected function findModel($id){
        
        if (($model = TblLanjutan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findBio($id) {
        return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
    }
    public function actionSemakanSyaratLanjut($id,$i){
        $iklan = $this->findIklanbyID($id);
        $message = '';
        $model = TblLanjutan::findOne(['id'=>$i,'iklan_id'=>$id, 'status_borang' => "Selesai Permohonan"]);
        
        $kriteriakpi = \app\models\cbelajar\RefPhd::find()->all();
        $doktoral = \app\models\cbelajar\RefDoktoral::find()->all();

        $kontrak = $this->findModel($i);
        $ICNO = $kontrak->icno;
                         $biodata = $this->findBio($ICNO);

        if (Yii::$app->request->post()) {
            foreach ($kriteriakpi as $kpi) {
                $this->savekpi($takwim_id,$id,$kontrak->icno, $kpi);
            }
             foreach ($doktoral as $dok) {
                $this->savekpi($takwim_id, $id,$kontrak->icno, $dok);
             }
//            $message = 'Berjaya Disimpan';
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-syarat',  'id' => $kontrak->id, 'ICNO'=>$ICNO,'takwim_id'=> $kontrak->iklan_id]);
        }        
         if($kontrak->status_semakan == 'Dibawa Ke Mesyuarat' || $kontrak->status_semakan == 'Dokumen Tidak Lengkap'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}
            
            if($model->agree == '1' || $model->status_borang == 'Selesai Permohonan')
               {
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}
         if(\app\models\cbelajar\TblNilaiSyarat::find()->where([ 'icno'=> $kontrak->icno,'iklan_id'=>$kontrak->iklan_id, 'parent_id'=>$kontrak->id])->exists())
        {
//                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
                         return $this->redirect(['cutibelajar/view-syarat', 'ICNO'=>$ICNO,'id' => $kontrak->id, 'takwim_id'=> $kontrak->iklan_id]);//
        }
        return $this->render('semakan_syaratlanjut', [
                    'kontrak' => $kontrak,
                    'kriteriakpi' => $kriteriakpi,
                    'doktoral' => $doktoral,
                    'message' =>$message,
                    'icno' => $kontrak->icno,
                    'edit' => $edit,
                    'view' => $view,
                    'iklan' => $iklan,
            'biodata'=>$biodata,
//                    'pengajian' => $pengajian,
     
        
        ]);
        
    }
    public function actionCetakBorang($id, $ICNO, $takwim_id){
        
          $biodata = $this->findMaklumat($ICNO);
//          $pengajian = $this->findPengajian($ICNO);
          $pengajian = TblPengajian::find()->where(['idPermohonan'=>$id])->all();
          $model = TblPermohonan::find()->where(['id'=>$id, 'status_proses' => "Selesai Permohonan"])->one();
          $biasiswa = TblBiasiswa::find()->where(['icno'=>$ICNO])->all();
          $dokumen = TblFilePemohon::findAll(['uploaded_by'=> $ICNO, 'iklan_id'  => $takwim_id]);
          $dokumen2 = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' =>$ICNO,'iklan_id' => $takwim_id]);
          $dokumen3 = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' =>$ICNO,'iklan_id' => $takwim_id]);
//          $content = $this->renderPartial('cetak-borang', [
//          'model' => $model,
//              'biodata' => $biodata,
//              'keluarga' => $biodata->keluarga,
//              'biasiswa' => $biasiswa,
//              'akademik' => $biodata->akademik,
//              'img' => $biodata->img,
//              'dokumen' => $dokumen,
//              'dokumen2' => $dokumen2,
//              'dokumen3' => $dokumen3,
//             'pengajian' => $pengajian,]);
                      $content = $this->renderPartial('_cetakborang', [ 'model' => $model,
              'biodata' => $biodata,
              'keluarga' => $biodata->keluarga,
              'biasiswa' => $biasiswa,
              'akademik' => $biodata->akademik,
              'img' => $biodata->img,
              'dokumen' => $dokumen,
              'dokumen2' => $dokumen2,
              'dokumen3' => $dokumen3,
             'pengajian' => $pengajian]);

       
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
            'options' => ['title' => ''],
            // call mPDF methods on the fly
            'marginTop' => 35,
            'marginLeft' => 24,
            'marginRight' => 24,
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => [''],
                'WriteHTML' => ['']
            ]
        ]);

        return $pdf->render();
           
        
       
    }
     public function actionUpdate($id, $i) {

        $model = \app\models\cbelajar\TblLanjutan::findOne(['iklan_id'=>$id,'id'=>$i]);
//                $mod = \app\models\cbelajar\TblPrestasi::findOne(['iklan_id'=>$id,'id'=>$i]);
        $doktoral = \app\models\cbelajar\RefPrestasi::find()->all();
        $mod = new \app\models\cbelajar\TblPrestasi();

        $iklan = $this->findIklanbyID($id);
        if ((Yii::$app->request->post())) {
            
            foreach ($doktoral as $dok)
            {
                 $mod = \app\models\cbelajar\TblPrestasi::find()->where(['idPrestasi'=>$dok->id, 'idlanjutan'=>$i, 'iklan_id'=>$id])->one();
                         
//                 $mod->catatan = Yii::$app->request->post($dok->id) ;
                    $mod->komen = Yii::$app->request->post($dok->id) ;
//$mod->catatan = $dok->id;
                 $mod->idlanjutan = $model->id;
                 $mod->idPrestasi = $dok->id;
                 $mod->iklan_id = $iklan->id;
                 $mod->save(false);
                
            }
            if ($mod->save(false)) {
                
                
                
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dikemaskini', 'type' => 'success', 'msg'=>""]);
                return $this->redirect(['adminview', 'id'=>$id, 'i'=>$i]);
        }}
       
//          var_dump($model->id);
//          die();
             return $this->render('_formprestasi', [
                    'iklan' => $iklan,
              'model' => $model,
              'doktoral' => $doktoral,
              'mod'=>$mod,
                
                   
        ]);
      
     }
      public function actionKomenPrestasi($id, $i) {

        $model = \app\models\cbelajar\TblLanjutan::findOne(['iklan_id'=>$id,'id'=>$i]);
//                $mod = \app\models\cbelajar\TblPrestasi::findOne(['iklan_id'=>$id,'id'=>$i]);
        $doktoral = \app\models\cbelajar\RefPrestasi::find()->all();
        $mod = new \app\models\cbelajar\TblPrestasi();

        $iklan = $this->findIklanbyID($id);
        if ((Yii::$app->request->post())) {
            
            foreach ($doktoral as $dok)
            {
                 $mod = \app\models\cbelajar\TblPrestasi::find()->where(['idPrestasi'=>$dok->id, 'idlanjutan'=>$i, 'iklan_id'=>$id])->one();
                         
//                 $mod->catatan = Yii::$app->request->post($dok->id) ;
                    $mod->komen = Yii::$app->request->post($dok->id) ;
//$mod->catatan = $dok->id;
                 $mod->idlanjutan = $model->id;
                 $mod->idPrestasi = $dok->id;
                 $mod->iklan_id = $iklan->id;
                 $mod->save(false);
                
            }
            if ($mod->save(false)) {
                
                
                
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya disimpan', 'type' => 'success', 'msg'=>""]);
                return $this->redirect(['tindakan-kj', 'id'=>$id, 'i'=>$i]);
        }}
//          var_dump($model->id);
//          die();
             return $this->render('_komenprestasi', [
                    'iklan' => $iklan,
              'model' => $model,
              'doktoral' => $doktoral,
              'mod'=>$mod,
                   
                   
        ]);
      
     }
    public function actionCetakPermohonan($id, $i) {
//       $model = $this->findMaklumat();
//                 $biodata = $this->findMaklumat2($ICNO);
//                         $b = $this->findStudy($ICNO);
       $doktoral = \app\models\cbelajar\RefPrestasi::find()->all();
              $pres = \app\models\cbelajar\RefPrestasi::find()->all();

        $mod = \app\models\cbelajar\TblPrestasi::findOne(['iklan_id'=>$id,  'idlanjutan'=>$id]);

        $model = TblLanjutan::find()->where(['id'=>$i,'iklan_id'=>$id, 'status_borang' => "Selesai Permohonan"])->one();
        $p = $model->icno;
        $b = $this->findStudy($p);
//        return $this->render('_cetakborang', [ 'model' => $model,
////              'biodata' => $biodata,
////           'b'=>$b,
//           'doktoral' => $doktoral, 
//           'mod'=>$mod,
//            'pres'=>$pres,
//            'b'=>$b,
//            ]);

        $content = $this->renderPartial('_cetakborang', [ 'model' => $model,
//              'biodata' => $biodata,
//           'b'=>$b,
           'doktoral' => $doktoral, 
           'mod'=>$mod,
            'pres'=>$pres,
            'b'=>$b,
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
             'options' => ['title' => 'Pelanjutan Tempoh'],
            // call mPDF methods on the fly
              
         
            'methods' => [
//              'SetHeader' => ['Permohonan Baharu Pengajian Lanjutan,Unit Pengembangan Profesionalisme'],
                     'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
             
            ] ,           // call mPDF methods on the fly
        ]);

        return $pdf->render();
//       Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
//        $pdf = new Pdf([
//            'filename' => '_CUTIBELAJAR_'.$id,
//            'mode' => Pdf::MODE_BLANK, // leaner size using standard fonts
//            'destination' => Pdf::DEST_BROWSER,
//            'content' => $this->renderPartial('/lanjutancb/_cetakborang', [
//            'model' => $model,
//                'biodata'=>$biodata,
//                ]),
//            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
//            'options' => [
//             
//            ],
//           
//        ]);
//        return $pdf->render();
    }
//     protected function findModel($id){
//        
//        if (($model = TblLanjutan::findOne($id)) !== null) {
//            return $model;
//        }
//
//        throw new NotFoundHttpException('The requested page does not exist.');
//    }
      protected function findBiodata() {
        if (($model = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionTindakanKj($id, $i) {
//       $icno=Yii::$app->user->getId();
         $model = TblLanjutan::find()->where(['iklan_id'=> $id, 'id'=>$i])->one();
         $icno =$model->icno;
                $biodata = $this->findBiodata();
        $lkk = TblLkk::find()->where(['icno' => $icno, 'status_borang' => "Complete"])->orderBy(['tarikh_mohon'=>SORT_DESC]) ->one();

//        $model = TblLanjutan::find()->where(['iklan_id'=>$id,'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();
//        $model = TblLanjutan::find()->where(['iklan_id'=>$id,'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();
        $mod = \app\models\cbelajar\TblPrestasi::findOne(['id' => $id]);//senarai status permohonan
        $doktoral = \app\models\cbelajar\RefPrestasi::find()->all();
        $iklan = $this->findIklanbyID($id);
        $b = $this->findStudy($icno);
        $icadmin = TblAdmin::findOne(['id' => $model->kakitangan->ICNO]);

        if($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            $model->app_date = date('Y-m-d H:i:s');
            if($model->status_jfpiu == 'Diperakukan') { 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);}
            elseif($model->status_jfpiu == 'Tidak Diperakukan') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Tidak Diperakukan!']);}
            $model->save(false);
          foreach ($doktoral as $dok)
            {
                 $mod = new \app\models\cbelajar\TblPrestasi();
                 $mod->komen = Yii::$app->request->post($dok->id) ;
//                 $mod->idlanjutan = $model->id;
//                 $mod->idPrestasi = $doktoral->id;
//                 $mod->iklan_id = $iklan->id;
                 $mod->save(false);
            }
            $ntf = new Notification();
            $ntf->icno = 870818495847; // peg  penyelia perjawatan
            $ntf->title = 'Permohonan Pelanjutan Tempoh Cuti Belajar';
            $ntf->content = "Permohonan Pelanjutan Tempoh Cuti Belajar menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakan1'], ['class'=>'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
             $ntf->save(false);   
                $this->notifikasi($icadmin, "Permohonan Pelanjutan Tempoh Cuti Belajar  menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['lanjutancb/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']));
                $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan BSM. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
               
                return $this->redirect(['lanjutancb/senaraitindakan']);
        }
        if($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}  
          
        if(Yii::$app->user->getId()==$model->app_by){
        return $this->render('_tindakankj', [
                   
              'iklan' => $iklan,
              'model' => $model,
              'doktoral' => $doktoral,
              'mod' => $mod,
              'bil' => '1',
              'edit' => $edit,
              'view' => $view,
             'biodata'=>$biodata,
            'img'=>$biodata->img,
            'b'=>$b,
            'lkk'=>$lkk,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
     protected function findMaklumat2($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
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
    


    
}