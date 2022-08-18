<?php

namespace app\controllers;
use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\cbelajar\TblpImage;
use app\models\cbelajar\TblUrusMesyuarat;
use app\models\hronline\Tblrscoconfirmstatus;
use app\models\cbelajar\TblPermohonan;
use app\models\cbelajar\TblPermohonanSearch;
use app\models\hronline\Tblpendidikan;
use app\models\cbelajar\TblPengajian;
use app\models\cbelajar\TblPengajianSearch;
use app\models\cbelajar\TblBiasiswa;
use app\models\cbelajar\TblBiasiswaSearch;
use app\models\cbelajar\TblFilePemohon;
use app\models\hronline\Department;
use app\models\hronline\Tblkeluarga;
use app\models\cbelajar\Model;
use yii\helpers\Html;
use app\models\Notification;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\RefSemakan;
use yii\web\UploadedFile;
use tebazil\runner\ConsoleCommandRunner;
use app\models\cbelajar\AksesPa;
use app\models\cbelajar\TblLanjutan;

use kartik\mpdf\Pdf;

class SubKepakaranController extends \yii\web\Controller
{
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['halaman-utama-bsm', 'senaraitindakan'],
//                'rules' => [
//                    [
//                        'actions' => ['halaman-utama-bsm', 'senaraitindakan'
//                    ],
//                        'allow' => true,
//                        'roles' => ['@'],
//                        'matchCallback' => function ($rule, $action) {
//                     $tmp = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);
//                    return (is_null($tmp)) ? false : true;
//                }
//                    ],
//                ],
//            ],
             'access' => [
                
                
                
                'class' => AccessControl::className(),
                'only' => ['senarai-borang','gambar', 'maklumat-peribadi', 'maklumat-akademik','maklumat-pengajian',
                           'maklumat-biasiswa','senarai-dokumen-dimuatnaik','maklumat-keluarga',
                           'pengakuan-pemohon', 'tambah-pengajian', 'tambah-biasiswa',
                            'senarai-dokumen-dimuatnaik','senarai-dokumen',
                            'muat-naik-dokumen','senaraitindakan'
                    ],
                'rules' => [
                                        Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),

                    [
                        'actions' => ['senarai-borang','maklumat-peribadi', 'maklumat-akademik', 
                            'maklumat-keluarga','maklumat-biasiswa','maklumat-pengajian', 'gambar',
                            'senarai-dokumen-dimuatnaik','maklumat-keluarga','pengakuan-pemohon', 
                            'tambah-pengajian','tambah-biasiswa','senarai-dokumen-dimuatnaik','senarai-dokumen',
                            'muat-naik-dokumen','senaraitindakan'],
                        'allow' => true,
                        'matchCallback' => function($rule,$action)
                        {
                             
                            $icno=Yii::$app->user->getId();
                            if($icno){
                            $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
                            if(($biodata->statLantikan=='1' && $biodata->jawatan->job_category =='1') ||
                               ($biodata->statLantikan=='2' && $biodata->jawatan->job_category =='1') || 
                               ($biodata->statLantikan=='1' && $biodata->jawatan->job_category =='2') ||
                                ($biodata->statLantikan=='3' && $biodata->jawatan->job_category =='1')     ){
                                return true;
                            }else{
                                return false;
                            }}
//                            if(
//                                    (Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jawatan->job_category == "1") ||
//                                    (Yii::$app->user->identity->statLantikan == "2"  && Yii::$app->user->identity->jawatan->job_category == "1") ||
//                                    (Yii::$app->user->identity->statLantikan == "3"  && Yii::$app->user->identity->jawatan->job_category == "1")
//                                    || (Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jawatan->job_category == "2"))
//                            {
//                                return TRUE;
//                            }
                           
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
            
        ];
    }
    protected function icno() { 
        
        return Yii::$app->user->getId(); 
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
//    public function actionIndex()
//    {
//        return $this->render('index');
//    }
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
    public function actionAdminview($ICNO,$id, $takwim_id) {
        $model = $this->findModel($id);
        $pengajian = TblPengajian::find()->where(['idPermohonan'=>$id,'icno'=> $ICNO, 'iklan_id' => $takwim_id])->all();
        $biasiswa = TblBiasiswa::find()->where(['idPermohonan'=>$id,'icno'=> $ICNO,'iklan_id'  => $takwim_id])->all();
        $dokumen = TblFilePemohon::find()->where(['uploaded_by'=> $ICNO, 'iklan_id'  => $takwim_id])->all();
        $senarai_dokumen = $this->findDokumen(1);
        $biodata = $this->findMaklumat($ICNO);
        $statuss = $this->findPerkhidmatanbyICNO();
        $model->app_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $iklan = $this->findIklanbyID($takwim_id);
//        $biasiswa = TblBiasiswa::find()->where(['icno' => $icno, 'idBorang' => 43])->all();
         $semak = RefSemakan::find()->where(['cb' => "sub"])->all();

        $senarai_dokumenkpm = $this->findDokumenKpm(1);
        $senarai_dokumenln = $this->findDokumenLn(1);
        if($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            if($model->status_jfpiu == 'Diperakukan') { 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);}
            elseif($model->status_jfpiu == 'Tidak Diperakukan') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);}
            $model->save(false);
                $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan BSM. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
                return $this->redirect(['cutisabatikal/senaraitindakan']);
        }
        if($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}         
          if(\app\models\cbelajar\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
        return $this->render('/cutibelajar/subpakar/_lihatpermohonan', [
                   
              'model' => $model,
              'biodata' => $biodata,
              'pengajian' => $pengajian,
              'keluarga' => $biodata->keluarga,
              'biasiswa' => $biasiswa,
              'akademik' => $biodata->akademik,
              'dokumen' => $dokumen,
              'statuss' => $statuss, 
              'img' => $biodata->img,
              'statuss' => $statuss, 
              'bil' => '1',
              'edit' => $edit,
              'view' => $view,
                'semak'=>$semak,'senarai_dokumen' =>$senarai_dokumen,'ICNO'=>$ICNO,'iklan'=>$iklan,
            'senarai_dokumenkpm' => $senarai_dokumenkpm,  'senarai_dokumenln' => $senarai_dokumenln,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    public function actionPaView($ICNO,$id, $takwim_id) {
        $model = $this->findModel($id);
        $pengajian = TblPengajian::find()->where(['idPermohonan'=>$id,'icno'=> $ICNO, 'iklan_id' => $takwim_id])->all();
        $biasiswa = TblBiasiswa::find()->where(['idBorang'=>43,'icno'=> $ICNO,'iklan_id'  => $takwim_id])->all();
        $dokumen = TblFilePemohon::find()->where(['uploaded_by'=> $ICNO, 'iklan_id'  => $takwim_id])->all();
        $senarai_dokumen = $this->findDokumen(1);
        $biodata = $this->findMaklumat($ICNO);
        $statuss = $this->findPerkhidmatanbyICNO();
        $model->app_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $iklan = $this->findIklanbyID($takwim_id);
//        $biasiswa = TblBiasiswa::find()->where(['icno' => $icno, 'idBorang' => 43])->all();
 $semak = RefSemakan::find()->where(['cb'=>"admin",'jenis'=>"umum"])->all();
        $khusus = \app\models\cbelajar\RefSemakan::find()->where(['cb'=>"sepenuh",'jenis'=>'khusus'])->all();
        $khusus_ln = \app\models\cbelajar\RefSemakan::find()->where(['cb'=>"sepenuh",'jenis'=>'khusus_ln'])->all(); 
        $senarai_dokumenkpm = $this->findDokumenKpm(1);
        $senarai_dokumenln = $this->findDokumenLn(1);
        if($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            if($model->status_jfpiu == 'Diperakukan') { 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);}
            elseif($model->status_jfpiu == 'Tidak Diperakukan') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);}
            $model->save(false);
                $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan BSM. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
                return $this->redirect(['cutisabatikal/senaraitindakan']);
        }
        if($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}         
          if(AksesPa::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
        return $this->render('/cutibelajar/subpakar/_lihatpermohonan', [
                   
              'model' => $model,
              'biodata' => $biodata,
              'pengajian' => $pengajian,
              'keluarga' => $biodata->keluarga,
              'biasiswa' => $biasiswa,
              'akademik' => $biodata->akademik,
              'dokumen' => $dokumen,
              'statuss' => $statuss, 
              'img' => $biodata->img,
              'statuss' => $statuss, 
              'bil' => '1',
              'edit' => $edit,
              'view' => $view,
                'semak'=>$semak,'senarai_dokumen' =>$senarai_dokumen,'ICNO'=>$ICNO,'iklan'=>$iklan,
            'senarai_dokumenkpm' => $senarai_dokumenkpm,  'senarai_dokumenln' => $senarai_dokumenln,'khusus'=>$khusus,
            'khusus_ln'=>$khusus_ln
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    public function actionCetakBorang($id, $ICNO, $takwim_id){
        
          $biodata = $this->findMaklumat($ICNO);
//          $pengajian = $this->findPengajian($ICNO);
          $pengajian = TblPengajian::find()->where(['idPermohonan'=>$id])->all();
          $model = TblPermohonan::findOne(['id'=>$id, 'icno'=>$ICNO,'iklan_id'=>$takwim_id, 'status_proses' => "Selesai Permohonan"]);
         
          $biasiswa = TblBiasiswa::findAll(['idPermohonan'=>$id,'icno'=> $ICNO,'iklan_id'  => $takwim_id]);
//$biasiswa = TblBiasiswa::find()->where(['icno'=>$ICNO])->all();
          $dokumen = TblFilePemohon::findAll(['uploaded_by'=> $ICNO, 'iklan_id'  => $takwim_id]);
          $dokumen2 = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' =>$ICNO,'iklan_id' => $takwim_id]);
          $dokumen3 = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' =>$ICNO,'iklan_id' => $takwim_id]);

             $content = $this->renderPartial('/cutibelajar/subpakar/cetak-borang', [ 'model' => $model,
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
    public function actionCetakBorangSabatikal($id, $ICNO, $takwim_id){
        
          $biodata = $this->findMaklumat($ICNO);
//          $pengajian = $this->findPengajian($ICNO);
          $pengajian = TblPengajian::find()->where(['idPermohonan'=>$id])->all();
          $model = TblPermohonan::findOne(['id'=>$id, 'icno'=>$ICNO,'iklan_id'=>$takwim_id, 'status_proses' => "Selesai Permohonan"]);
         
          $biasiswa = TblBiasiswa::findAll(['idPermohonan'=>$id,'icno'=> $ICNO,'iklan_id'  => $takwim_id]);
//$biasiswa = TblBiasiswa::find()->where(['icno'=>$ICNO])->all();
          $dokumen = TblFilePemohon::findAll(['uploaded_by'=> $ICNO, 'iklan_id'  => $takwim_id]);

             $content = $this->renderPartial('cetak-borang-sabatikal', [ 'model' => $model,
              'biodata' => $biodata,
              'keluarga' => $biodata->keluarga,
              'biasiswa' => $biasiswa,
              'akademik' => $biodata->akademik,
              'img' => $biodata->img,
              'dokumen' => $dokumen,
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
              
            'options' => ['title' => 'Permohonan Cuti Belajar - Cuti Sabatikal'],
            // call mPDF methods on the fly
              
         
            'methods' => [
//              'SetHeader' => ['Permohonan Baharu Pengajian Lanjutan,Unit Pengembangan Profesionalisme'],
                     'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
             
            ] ,           // call mPDF methods on the fly
            
        ]);

        return $pdf->render();
           
        
       
    }
     public function actionCetakBorangsm($id, $ICNO, $takwim_id){
        
          $biodata = $this->findMaklumat($ICNO);
//          $pengajian = $this->findPengajian($ICNO);
          $pengajian = TblPengajian::find()->where(['idPermohonan'=>$id])->all();
          $model = TblPermohonan::findOne(['id'=>$id, 'icno'=>$ICNO,'iklan_id'=>$takwim_id, 'status_proses' => "Selesai Permohonan"]);
          $biasiswa = TblBiasiswa::find()->where(['icno'=>$ICNO,'idPermohonan'=>$id])->all();
          $dokumen = TblFilePemohon::findAll(['uploaded_by'=> $ICNO, 'iklan_id'  => $takwim_id]);

             $content = $this->renderPartial('cetak-borangsm', [ 'model' => $model,
              'biodata' => $biodata,
              'keluarga' => $biodata->keluarga,
              'biasiswa' => $biasiswa,
              'akademik' => $biodata->akademik,
              'img' => $biodata->img,
              'dokumen' => $dokumen,
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
     protected function findPengajian($id) {
        return \app\models\cbelajar\TblPengajian::findAll(['icno' => $id]);
    }
    
    public function actionGeneratePermohonan($id, $ICNO, $takwim_id) {
          $biodata = $this->findMaklumat($ICNO);
          $model = TblPermohonan::find()->where(['id'=>$id, 'status_proses' => "Selesai Permohonan"])->one();
//          $biasiswa = TblBiasiswa::findAll(['icno'=> $ICNO,'iklan_id'  => $takwim_id]);
          $biasiswa = TblBiasiswa::find()->where(['idPermohonan'=>$id])->all();
          $dokumen = TblFilePemohon::findAll(['uploaded_by'=> $ICNO, 'iklan_id'  => $takwim_id]);
          $dokumen2 = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' =>$ICNO,'iklan_id' => $takwim_id]);
          $dokumen3 = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' =>$ICNO,'iklan_id' => $takwim_id]);
          if(\app\models\cbelajar\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'filename' => '_CUTIBELAJAR_'.$id,
            'mode' => Pdf::MODE_BLANK, // leaner size using standard fonts
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('/cbelajar/_cetakpermohonan', [
            'model' => $model,
              'biodata' => $biodata,
              'keluarga' => $biodata->keluarga,
              'biasiswa' => $biasiswa,
              'akademik' => $biodata->akademik,
              'dokumen' => $dokumen,
              'dokumen2' => $dokumen2,
              'dokumen3' => $dokumen3,
                ]),
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => [
             
            ],
           
        ]);
        }
        return $pdf->render();
    }
    public function actionUpdate1($id) {

        $model = TblPengajian::findOne($id)?TblPengajian::findOne($id):new TblPengajian();
//        $iklan = $this->findIklanByID($id);
        $mohon = TblPermohonan::findOne(['icno' => Yii::$app->user->getId()]); //senarai status permohonan

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save(false)) {
                
                $model->iklan_id = 15;
                $model->icno = Yii::$app->user->getId();
//                $model->idPermohonan = $mohon->id;

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Pengajian telah Berjaya dikemaskini']);
                return $this->redirect(['adminview', 'id'=>$model->idPermohonan, 'ICNO'=>$model->icno, 'takwim_id'=>$model->iklan_id]);
            }
        }
        return $this->render('../cbelajar/_formpengajian', [
                    'model' => $model,
                   
                   
                   
        ]);
      
     }
     public function actionUpdate2($id) {

        $model = TblPengajian::findOne($id)?TblPengajian::findOne($id):new TblPengajian();
//        $iklan = $this->findIklanByID($id);
        $mohon = TblPermohonan::findOne(['icno' => Yii::$app->user->getId()]); //senarai status permohonan

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save(false)) {
                
                $model->iklan_id = 15;
                $model->icno = Yii::$app->user->getId();
//                $model->idPermohonan = $mohon->id;

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Pengajian telah Berjaya dikemaskini']);
                return $this->redirect(['adminviewsabatikal', 'id'=>$model->idPermohonan, 'ICNO'=>$model->icno, 'takwim_id'=>$model->iklan_id]);
            }
        }
        return $this->render('../cutisabatikal/_formpengajian', [
                    'model' => $model,
                   
                   
                   
        ]);
      
     }
     public function actionRekodSabatikal()
    {

        $model = new TblPermohonan();
        $icno=Yii::$app->user->getId();
        $model->icno = $icno;
//        $status = TblPermohonan::findAll(['icno' => $icno]); //senarai status permohonan
        $status = TblPermohonan::find()->where(['icno' => $icno, 'status_proses' => "Selesai Permohonan", 'idBorang'=> 2])->all();
//        $statuslanjutan = \app\models\cbelajar\TblLanjutan::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
//        $statuslain = \app\models\cbelajar\TblLain::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
//        $lapordiri = \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
//        $statustiket = \app\models\cbelajar\BorangPenerbangan::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
        $searchModel = new TblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $model = TblPermohonan::find()->where(['icno' => $icno])->orderBy([ 'status' => SORT_ASC])->all();
        
//        $ver = TblPermohonan::findAll(['ver_by' => $icno]);
        $ver = TblPermohonan::find()->where(['ver_by' => $icno, 'status_proses' => "Selesai Permohonan"])->orderBy(['tarikh_m' => SORT_DESC]);

        return $this->render('rekodsemasa', [
            'model' => $model,
            'status' => $status,
//            'statustiket' => $statustiket,
//            'statuslanjutan' => $statuslanjutan,
//            'statuslain' => $statuslain,
//            'lapordiri' => $lapordiri,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ver' => $ver,
            'bil' => 1,
            'icno' => $icno
        ]);
    }
     protected function findMaklumat($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }
    public function actionGambar($id) {
        
        $check = TblpImage::findOne(['ICNO' =>$this->ICNO(),'iklan_id' => $id]);
        $iklan = $this->findIklanbyID($id);
        if ($check) {
            $model = $check;
        } else {
            $model = new TblpImage();
        }
        
        if ($model->load(Yii::$app->request->post())) {

            $image = $model->uploadImage();
            $model->ICNO = $this->ICNO();
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            
            /*************************************************************************/
            
            $model->filename= UploadedFile::getInstances($model, 'image');
          
            foreach ($model->filename as $saving) {
            if ($saving) {
                echo "a";
                $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '01', 'cutibelajar');

                $file_path = $file->file_name_hashcode; 
            }
            $simpan = new TblpImage();
            $simpan->created_dt = new \yii\db\Expression('NOW()');
            $simpan->tahun = date("Y");
            $simpan->iklan_id = $iklan->id;
            $simpan->ICNO = $this->ICNO();
            $simpan->filename = $file_path;
            $simpan->save();
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
               return $this->redirect(['gambar', 'id'=> $iklan->id]);
            }
        }
        return $this->render('/cutibelajar/subpakar/form_gambar', [
                    'model' => $model,
                    'iklan' => $iklan,
                   
        ]);
       
    }
    
    public function actionMaklumatPeribadi($id)
    {
        $icno = Yii::$app->user->getId();
        $biodata = $this->findBiodata();
        $status = $this->findPerkhidmatanbyICNO();
        $model2 = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt'); 
        //ambil tarikh status pengesahan yang latest
        $confirm = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno, 'ConfirmStatusStDt' => $model2])->one()->ConfirmStatusStDt;
        $model = new TblPermohonan();
        $model->icno = $icno;
        $iklan = $this->findIklanbyID($id);
       
        return $this->render('/cutibelajar/subpakar/form_peribadi', 
            [ 
              
              'biodata' => $biodata,
              'status' => $status,
              'iklan' => $iklan,
                'model2'=>$model2,
                'confirm' => $confirm,
            ]);
    
    }
    
     protected function findModel($id){
        
        if (($model = TblPermohonan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
public function actionTindakanKj($ICNO,$id, $takwim_id) {
        $model = $this->findModel($id);
        $pengajian = TblPengajian::find()->where(['idPermohonan'=>$id,'icno'=> $ICNO, 'iklan_id' => $takwim_id])->all();
        $biasiswa = TblBiasiswa::find()->where(['idPermohonan'=>$id,'icno'=> $ICNO,'iklan_id'  => $takwim_id])->all();
        $dokumen = TblFilePemohon::find()->where(['uploaded_by'=> $ICNO, 'iklan_id'  => $takwim_id])->all();
        $senarai_dokumen = $this->findDokumen(1);
        $biodata = $this->findMaklumat($ICNO);
        $statuss = $this->findPerkhidmatanbyICNO();
        $model->app_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $semak = RefSemakan::find()->where(['cb'=>"sub"])->all();
        $iklan = $this->findIklanbyID($takwim_id);
//        $biasiswa = TblBiasiswa::find()->where(['icno' => $icno, 'idBorang' => 43])->all();
$senarai_dokumenkpm = $this->findDokumenKpm(1);
        $senarai_dokumenln = $this->findDokumenLn(2);
        if($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            if($model->status_jfpiu == 'Diperakukan') { 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);}
            elseif($model->status_jfpiu == 'Tidak Diperakukan') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);}
            $model->save(false);
                $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan BSM. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
                return $this->redirect(['cutisabatikal/senaraitindakan']);
        }
        if($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}         
        if($icno==$model->app_by){
        return $this->render('/cutibelajar/subpakar/semak_maklumat', [
                   
              'model' => $model,
              'biodata' => $biodata,
              'pengajian' => $pengajian,
              'keluarga' => $biodata->keluarga,
              'biasiswa' => $biasiswa,
              'akademik' => $biodata->akademik,
              'dokumen' => $dokumen,
              'statuss' => $statuss, 
              'img' => $biodata->img,
              'statuss' => $statuss, 
              'bil' => '1',
              'edit' => $edit,
              'view' => $view,
                'semak'=>$semak,'senarai_dokumen' =>$senarai_dokumen,'ICNO'=>$ICNO,'iklan'=>$iklan,
            'senarai_dokumenkpm' => $senarai_dokumenkpm,
                    'senarai_dokumenln' => $senarai_dokumenln,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
//    public function actionTindakanKj($id, $i, $ICNO) {
////       $icno=Yii::$app->user->getId();
//               $model = TblLanjutan::find()->where(['iklan_id'=> $id, 'id'=>$i])->one();
//
////        $model = TblLanjutan::find()->where(['iklan_id'=>$id,'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();
////        $model = TblLanjutan::find()->where(['iklan_id'=>$id,'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();
//        $mod = \app\models\cbelajar\TblPrestasi::findOne(['id' => $id]);//senarai status permohonan
//        $doktoral = \app\models\cbelajar\RefPrestasi::find()->all();
//        $iklan = $this->findIklanbyID($id);
//        
//        if($model->load(Yii::$app->request->post())) {
//            $model->status = 'DALAM TINDAKAN BSM';
//            $model->app_date = date('Y-m-d H:i:s');
//            if($model->status_jfpiu == 'Diperakukan') { 
//                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);}
//            elseif($model->status_jfpiu == 'Tidak Diperakukan') {
//                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);}
//            $model->save(false);
//                $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan BSM. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
//                return $this->redirect(['cutisabatikal/senaraitindakan']);
//        }
//        if($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan'){
//            $edit = 'none'; $view= '';}
//        else{
//            $view = 'none'; $edit = '';}  
//            
//        if(Yii::$app->user->getId()==$model->app_by){
//        return $this->render('_tindakankj', [
//                   
//              'iklan' => $iklan,
//              'model' => $model,
//              'doktoral' => $doktoral,
//              'mod' => $mod,
//              'bil' => '1',
//              'edit' => $edit,
//              'view' => $view
//        ]);}
//        else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('index');}
//    }
    protected function findP($id) {
        return \app\models\cbelajar\TblPengajian::findAll(['icno' => $id]);
    }
    public function actionSenaraitindakan()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai  = '';
//           $id = $model->icno;
//        $p = $this->findP($id);
        $status = ['Tunggu Perakuan', 'Diperakukan', 'Tidak Diperakukan'];
        $a = (Department::find()->where( ['chief' => $icno, 'isActive' => '1']));
        $b = (\app\models\cbelajar\TblAccess::find()->where( ['icno' => $icno] ));
       if ($a || $b ->exists())
       {
//       ->exists()) || (\app\models\cbelajar\TblAccess::find()->where( ['icno' => $icno] )->exists()){
             $senarai = TblPermohonan::find()->where(['app_by' => $icno, 'status_proses' => "Selesai Permohonan"])->orderBy(['tarikh_m' => SORT_DESC]);
            $title='Permohonan Baharu';
        }
//       if(Department::find()->where( ['chief' => $icno, 'isActive' => '1'] )->exists()){
//            $senarai = TblPermohonan::find()->where(['app_by' => $icno, 'status_proses' => "Selesai Permohonan"])->orderBy(['tarikh_m' => SORT_DESC]);
//            $title='Permohonan Baharu';
//        }
//     

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
            'status' => $status,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['cutibelajar/index']);}  
    }
    public function actionMaklumatAkademik($id)
    {
        $icno = Yii::$app->user->getId();
        $model = new TblPermohonan();
        $model->icno = $icno;
        $iklan = $this->findIklanbyID($id);
        $sabatikal2= $this->findSabatikal();
        return $this->render('/cutibelajar/subpakar/form_akademik', 
        [ 
              'akademik' => $this->findAkademikbyICNO(),
               'iklan' => $iklan,
                'sabatikal2' => $sabatikal2,
        ]);
    
    }
    public function actionMaklumatPengajian($id) {
        
        $pengajianTinggi = TblPengajian::findAll(['icno' =>$this->ICNO(),'iklan_id' => $id, 'idBorang' => 43,'status'=>9]);
        $iklan = $this->findIklanbyID($id);
        $icno = Yii::$app->user->getId();
        $sabatikal2= $this->findSabatikal();
        $model = new TblPengajian();
        $model->icno = $icno;
        if ($model->load(Yii::$app->request->post())) 
        {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['maklumat-pengajian',  'id' => $model->id]);
        }
            $searchModel = new TblPengajianSearch();
            $query = TblPengajian::find()->where(['icno' => $icno]);
            $DataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        return $this->render('/cutibelajar/subpakar/form_pengajian', 
        [
                    'model' => $model,
                    'iklan' => $iklan,
                    'eduhighest' => $pengajianTinggi,
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
                    'sabatikal2' => $sabatikal2,
        ]);
    }
    public function actionTambahPengajian($id) {
        $icno = Yii::$app->user->getId();
        $model = new TblPengajian();
        $iklan = $this->findIklanByID($id);
                $biodata = $this->findBiodata();

//        $permohonan = $this->findPermohonanbyID($id);
        $file = UploadedFile::getInstance($model, 'file1');
            if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        if ($model->load($post = Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->gred = $biodata->jawatan->gred;
            $model->status_proses = "S";

            $model->idBorang=43;
            $model->status = 9; //dalam proses;
            $model->modeStudy = "SUBPAKAR";
            $model->modeID;
            $model->save(false);


                     
         
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Pengajian telah Berjaya ditambah!']);
                
                return $this->redirect(['pengakuan-pemohon', 'id' => $iklan->id]);
            
        }
        return $this->renderAjax('/cutibelajar/subpakar/_formpengajian', [
                    'model' => $model,
                    'iklan' => $iklan,
        ]);
    }
    public function actionUpgambar($id) {
       $check = TblpImage::findOne(['ICNO' =>$this->ICNO(),'iklan_id' => $id]);
        $iklan = $this->findIklanbyID($id);
        if ($check) {
            $model = $check;
        } else {
            $model = new TblpImage();
        }

//        var_dump('a');die;
       if ($model->load(Yii::$app->request->post())) {

            $image = $model->uploadImage();
            $model->ICNO = $this->ICNO();
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            
            /*************************************************************************/
            
            $model->filename= UploadedFile::getInstances($model, 'image');
          
            foreach ($model->filename as $saving) {
            if ($saving) {
                echo "a";
                $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '01', 'cutibelajar');

                $file_path = $file->file_name_hashcode; 
            }
            $simpan = new TblpImage();
            $simpan->created_dt = new \yii\db\Expression('NOW()');
            $simpan->tahun = date("Y");
            $simpan->iklan_id = $iklan->id;
            $simpan->ICNO = $this->ICNO();
            $simpan->filename = $file_path;
            $simpan->save();
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
               return $this->redirect(['pengakuan-pemohon', 'id'=> $iklan->id]);
            }
        }
      

        return $this->renderAjax('/cutibelajar/subpakar/form_gambar', [
                    'model' => $model,
                    'id' => $id, 'iklan'=>$iklan
        ]);
    }
  public function actionDeleteBiasiswa($id, $i) 
    {
        $mj = TblBiasiswa::findOne($id)->delete();
        return $this->redirect(['pengakuan-pemohon', 'id'=>$i]);
    }
     public function actionLihatpengajian($id)
    {
      
        return $this->render('lihatpengajian', [
            
            'model' => $this->findModelbyid($id),  
//            'iklan' => $this->findIklanbyID($model->iklan_id),
        ]);
    }
    public function actionUpdate($id) {

        
        $model = TblPengajian::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save(false)) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Pengajian telah Berjaya dikemaskini!']);
                return $this->redirect(['pengakuan-pemohon', 'id' => $model->iklan_id]);
            }
        }
        return $this->renderAjax('/cutibelajar/subpakar/_formpengajian', [
                    'model' => $model,
                   
                   
        ]);
    }
   public function actionMaklumatBiasiswa($id)
    {   $request = Yii::$app->request;
        $sponsor = TblBiasiswa::find()->where(['icno' =>$this->ICNO(),'iklan_id' => $id, 'idBorang'=>43])->all();
        $icno = Yii::$app->user->getId();
        $iklan = $this->findIklanbyID($id);
        $model = new TblBiasiswa();
        $model->icno = $icno;
        if ($model->load(Yii::$app->request->post())) {
            $model->nama_tajaan = $request->post()['TblBiasiswa']['nama_tajaan'];
            $model->BantuanCd = $request->post()['TblBiasiswa']['BantuanCd'];
            $model->BantuanCd_ums = $request->post()['TblBiasiswa']['BantuanCd_ums'];
            $model->BantuanCd_ums = $request->post()['TblBiasiswa']['BantuanCd_ums'];
            $model->amaunBantuan= $request->post()['TblBiasiswa']['amaunBantuan'];
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['maklumat-biasiswa',  'id' => $model->id]);
        }
         $searchModel = new TblBiasiswaSearch();
            $query = TblBiasiswa::find()->where(['icno' => $icno]);
            $DataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        return $this->render('/cutibelajar/subpakar/form_biasiswa', [
                    'model' => $model,
                    'iklan' => $iklan,
                    'sponsor'=> $sponsor,
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
                    
                   
                    
        ]);
    }
     protected function findKeluargabyICNO() {
        if (($model = Tblkeluarga::findAll(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionMaklumatKeluarga($id)
    {
        $icno = Yii::$app->user->getId();
        $iklan = $this->findIklanbyID($id);
        $model = new TblPermohonan();
        $model->icno = $icno;
        return $this->render('/cutibelajar/subpakar/form_keluarga', 
            [ 
              'keluarga' => $this->findKeluargabyICNO(),
              'iklan' =>$iklan,
            ]);
    
    }
    public function actionTambahBiasiswa($id) {
        $icno = Yii::$app->user->getId();
        $model = new TblBiasiswa();
        $modelCustomer = new TblPermohonan(); 
        $modelsAddress = [new TblBiasiswa()]; 
        $model2 = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
        $iklan = $this->findIklanByID($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->iklan_id = $iklan->id;
            $model->bentukBantuan_ums;
            $model->BantuanCd;
            $model->icno = $icno;
            $model->idBorang = 43;
              $model->status = 9;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->tahun = date("Y");
            if($model->save(false)){
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya ditambah!']);
                return $this->redirect(['maklumat-biasiswa', 'id' => $iklan->id ]);
            }
            
        }
        return $this->render('/cutibelajar/subpakar/_formbiasiswa', [
            'model' => $model,
            'iklan' => $iklan,
            'model2' => $model2,
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => $modelsAddress,
        ]);
    }
    public function actionSenaraiDokumenDimuatnaik($id)
    {
        //$model = new TblFilePemohon();
        $icno = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblFilePemohon();
        $iklan = $this->findIklanbyID($id);
        $model->uploaded_by = $icno;
        $dokumen2 = \app\models\cbelajar\TblFilePemohon::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id, 'idBorang' => 43]);

        return $this->render('/cutibelajar/subpakar/form_dokumen', 
            [ 
      
             'dokumen2' => $this->findDokumenbyICNO(),
             
             'iklan' => $iklan,
            
             'dokumen2' => $dokumen2,
           
            ]);
        
    }
    public function actionMuatNaikDokumenLn($id,$iklan_id) {
       $icno = Yii::$app->user->getId();
        $dokumen = $this->findDokumenLnById($id);
       $model = new \app\models\cbelajar\TblFileLn();
       $iklan =  $this->findIklanbyID($iklan_id);
       if(\app\models\cbelajar\TblFileLn::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id'=> $iklan->id])->exists())
        {
                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
                         return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);//
        }
       if ($model->load(Yii::$app->request->post())) 
       {
           
          
        $model->namafile = UploadedFile::getInstances($model, 'namafile');

      
            foreach ($model->namafile as $saving) {
                if ($saving) {
//                    $var_dump($saving);die;

                    $file = Yii::$app->FileManager->
                    UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');

                    $file_path = $file->file_name_hashcode; 
               }
               else
               {
                   $file_path = NULL;
               }

            }
                $simpan = new \app\models\cbelajar\TblFileLn();
                $simpan->uploaded_by = $icno;
//                $simpan->parent_id = $id;
                if ($model->namafile){
                $simpan->namafile = $file_path;
                }
                $simpan->dokumenCd = $id;
                $simpan->idBorang = 42;
//                $simpan->namafile = $file_path;
                $simpan->nama_dokumen = $dokumen->nama_dokumen;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->iklan_id = $iklan->id;
                $simpan->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                   return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);
            
           //}
          
            
        } else {
                        return $this->renderAjax('/cutibelajar/subpakar/update-dokumen-ln', [
                        'model' => $model,
                            'iklan'=>$iklan
                       
            ]);
            
//            return $this->renderAjax('index', [
//                       
//            ]);
        }
    }
    protected function findDokumenKpmById($id) {
        if (($model = \app\models\cbelajar\TblDokumenKpm::findOne(['id' => $id])) !== null) {
            return $model;
            
        
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findDokumenLnById($id) {
        if (($model = \app\models\cbelajar\TblDokumenLn::findOne(['id' => $id])) !== null) {
            return $model;
            
        
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionDeleteDokumenKpt($id, $i) 
    {
        $mj = \app\models\cbelajar\TblFileKpm::findOne($id)->delete();
                                    Yii::$app->session->setFlash('info', ['title' => 'Dokumen Berjaya Dipadam', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);

        return $this->redirect(['kpt', 'id'=>$i]);
    }
    public function actionDeleteDokumenLn($id, $i) 
    {
        $mj = \app\models\cbelajar\TblFileLn::findOne($id)->delete();
                                    Yii::$app->session->setFlash('info', ['title' => 'Dokumen Berjaya Dipadam', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);

        return $this->redirect(['senarai-dokumen', 'id'=>$i]);
    }
 public function actionMuatNaikDokumenKpt($id,$iklan_id) {
       $icno = Yii::$app->user->getId();
        $dokumen = $this->findDokumenKpmById($id);
       $model = new \app\models\cbelajar\TblFileKpm();
       $iklan =  $this->findIklanbyID($iklan_id);
       $biasiswa = TblBiasiswa::find()->where(['icno'=>$icno,'status'=>03])->exists();
       if(\app\models\cbelajar\TblFileKpm::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id'=> $iklan->id])->exists())
        {
                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
                         return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);//
        }
        if(!$biasiswa)
        {
        $spo = new TblBiasiswa();
            $spo->icno = $icno;
            $spo->iklan_id = $iklan->id;
            $spo->bentukBantuan = "KPT";
            $spo->BantuanCd = "1";
            $spo->jenisCd = "3";
            $spo->status = 03;
             $spo->idBorang = "43";
             $spo->nama_tajaan = "KEMENTERIAN PENGAJIAN TINGGI";
             $spo->amaunBantuan = "BIASISWA KPT";
             $spo->created_dt = new \yii\db\Expression('NOW()');
            $spo->tahun = date("Y");
            $spo->save(false);
        }
        
       if ($model->load(Yii::$app->request->post())) 
       {
           
          
        $model->namafile = UploadedFile::getInstances($model, 'namafile');

      
            foreach ($model->namafile as $saving) {
                if ($saving) {
//                    $var_dump($saving);die;

                    $file = Yii::$app->FileManager->
                    UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');

                    $file_path = $file->file_name_hashcode; 
               }
               else
               {
                   $file_path = NULL;
               }

            }
                $simpan = new \app\models\cbelajar\TblFileKpm();
                $simpan->uploaded_by = $icno;
//                $simpan->parent_id = $id;
                if ($model->namafile){
                $simpan->namafile = $file_path;
                }
//             $simpan->uploaded_by = $icno;
                $simpan->dokumenCd = $id;
                $simpan->idBorang = 43;
//                $simpan->namafile = $file_path;
                $simpan->nama_dokumen = $dokumen->nama_dokumen;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->iklan_id = $iklan->id;
                $simpan->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                   return $this->redirect(['kpt', 'id' => $iklan->id]);
            
           //}
          
            
        } else {
                        return $this->renderAjax('/cutibelajar/subpakar/update-dokumen-kpm', [
                        'model' => $model,
                            'iklan'=>$iklan
                       
            ]);
            
//            return $this->renderAjax('index', [
//                       
//            ]);
        }
    }
     public function actionTajaanluar($id) {
      
        $modelsAddress = [new TblBiasiswa()]; 
        $model = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
         $iklan = $this->findIklanByID($id);
        if ((Yii::$app->request->post())) {
                
            $modelsAddress = \app\models\cbelajar\Model::createMultiple(TblBiasiswa::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            
//            // ajax validation
          if (Yii::$app->request->isAjax) {
               Yii::$app->response->format = Response::FORMAT_JSON;
               return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                  ActiveForm::validate($modelCustomer)
                       
                );
            }
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                  
                        foreach ($modelsAddress as $i=> $modelAddress) {
//                                $modelAddress->icno = $modelCustomer->icno;
                                $modelAddress->icno =  Yii::$app->user->getId();
                                $modelAddress->jenisCd = 1;
                                $modelAddress->nama_tajaan;
                                $modelAddress->BantuanCd;
                                $modelAddress->idBorang=43;
                                $modelAddress->iklan_id = $iklan->id;
                                $modelAddress->created_dt = new \yii\db\Expression('NOW()');
                                $modelAddress->tahun = date("Y");
//                              $modelAddress->parent_id = $modelCustomer->id;
//                              $modelAddress->idBorang = 1;
                            if (! ($flag = $modelAddress->save())) {
                                $transaction->rollBack();
                                break;
                                
                            }
                        
                    }
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan.']);
                    if ($flag) {
                        $transaction->commit();

                        return $this->redirect(['pengakuan-pemohon', 'id' => $iklan->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            
            
        }
        
        return $this->render('/cutibelajar/subpakar/_tajaanluarsm', [
            'model' => $model,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblBiasiswa] : $modelsAddress,
            'iklan' => $iklan
          
        ]);
    }
    public function actionKpt($id) {
      
        $icno = Yii::$app->user->getId();
//        $model = new TblBiasiswa();
        $modelCustomer = new TblPermohonan(); 
//        $modelsAddress = [new TblBiasiswa()]; 
        $model2 = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
        $iklan = $this->findIklanByID($id);
                 $senarai_dokumenkpm = $this->findDokumenKpm(1);

//        if ($model->load(Yii::$app->request->post())) {
//            $model->icno = $icno;
//            $model->iklan_id = $iklan->id;
//            $model->bentukBantuan = "KPT";
//            $model->BantuanCd = "1";
//            $model->jenisCd = "3";
//             $model->idBorang = "43";
//             $model->amaunBantuan = "BIASISWA KPT";
//            $model->icno = $icno;
//             $model->created_dt = new \yii\db\Expression('NOW()');
//            $model->tahun = date("Y");
//            if($model->save(false)){
//                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya ditambah!']);
//                return $this->redirect(['pengakuan-pemohon', 'id' => $iklan->id ]);
//            }
//            
//        }
        return $this->render('/cutibelajar/subpakar/_kpt', [
//            'model' => $model,
            'iklan' => $iklan,
            'model2' => $model2,
            'modelCustomer' => $modelCustomer,
//            'modelsAddress' => [new TblBiasiswa],
            'senarai_dokumenkpm'=>$senarai_dokumenkpm
        ]);
    }
   public function actionSenaraiDokumen($id)
    {

        $senarai_dokumen = $this->findDokumen(1);
         $senarai_dokumenkpm = $this->findDokumenKpm(1);
        $senarai_dokumenln = $this->findDokumenLn(2);
        $iklan = $this->findIklanbyID($id);
        return $this->render('/cutibelajar/subpakar/form_upload_dokumen', 
        [
            'senarai_dokumen' => $senarai_dokumen,
            'senarai_dokumenkpm' => $senarai_dokumenkpm,
            'senarai_dokumenln' => $senarai_dokumenln,
            'iklan' => $iklan,
                         
        ]);
    }

    public function actionMuatNaikDokumen($id,$iklan_id) {
       $icno = Yii::$app->user->getId();
        $dokumen = $this->findDokumenById($id);
       $model = new \app\models\cbelajar\TblFilePemohon();
       $iklan =  $this->findIklanbyID($iklan_id);
       if(\app\models\cbelajar\TblFilePemohon::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id'=> $iklan->id])->exists())
        {
                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
                         return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);//
        }
       if ($model->load(Yii::$app->request->post())) 
       {
           
          
        $model->namafile = UploadedFile::getInstances($model, 'namafile');

      
            foreach ($model->namafile as $saving) {
                if ($saving) {
//                    $var_dump($saving);die;

                    $file = Yii::$app->FileManager->
                    UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');

                    $file_path = $file->file_name_hashcode; 
               }
               else
               {
                   $file_path = NULL;
               }

            }
                $simpan = new \app\models\cbelajar\TblFilePemohon();
                $simpan->uploaded_by = $icno;
//                $simpan->parent_id = $id;
                if ($model->namafile){
                $simpan->namafile = $file_path;
                }
//             $simpan->uploaded_by = $icno;
                $simpan->dokumenCd = $id;
                $simpan->idBorang = 43;
                $simpan->kategori = 1;
//                $simpan->namafile = $file_path;
                $simpan->nama_dokumen = $dokumen->nama_dokumen;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->iklan_id = $iklan->id;
                $simpan->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                   return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);
            
           //}
          
            
        } else {
                        return $this->renderAjax('/cutibelajar/subpakar/update-dokumen', [
                        'model' => $model,
                            'iklan'=>$iklan
                       
            ]);
            
//            return $this->renderAjax('index', [
//                       
//            ]);
        }
    }
   
    
 

 
  
    
    
    protected function findDokumenById($id) {
        if (($model = \app\models\cbelajar\TblDokumen::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     public function findDokumen($status) 
    {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblDokumen::find()->where(['status' => $status,'kategori'=>12]),

            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }
     protected function findDokumenbyICNO() {
        if (($model = TblFilePemohon::findAll(['uploaded_by' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
    protected function findDokumenLnbyICNO() {
        if (($model = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findBiodata() {
        if (($model = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findPerkhidmatanbyICNO() {
        if (($model = Tblrscoconfirmstatus::findAll(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
            
            
        }
    }

     protected function findSabatikal() {
        return \app\models\cbelajar\TblPengajian::findAll(['icno' =>$this->ICNO()]);
    }
    protected function findAkademikbyICNO() {
        if (($model = Tblpendidikan::findAll(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findModelbyid($id)
    {
        if (($model = TblPengajian::findOne(['id' => $id])) !== null) {
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
      public function actionDelete($id, $i) 
    {
      
        $mj = TblPengajian::findOne($id)->delete();

        
        return $this->redirect(['cutisabatikal/maklumat-pengajian', 'id'=>$i]);
    }
     public function actionDeleteDokumen($id, $i) 
    {
        $mj = TblFilePemohon::findOne($id)->delete();
        return $this->redirect(['senarai-dokumen', 'id'=>$i]);
    }
    protected function findPermohonan($id) {

        if (($model = TblPermohonan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionTolakTawaran($id) {



        $model = $this->findPermohonan($id);


        if ($model->load(Yii::$app->request->post())) {

            if($model->status == 1)
            {
            $model->status = "TOLAK TAWARAN";
            }
            else
            {
                $model->status = "TERIMA TAWARAN";
            }
//            $model->tarikh_mohon = NULL;

            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' =>
                'Maklumat berjaya dikemaskini']);
            return $this->redirect(['/cbadmin/senaraitindakan1']);
        }

        return $this->renderAjax('terima-tawaran', [
                    'model' => $model,
        ]);
    }
    protected function findBelajar($id) {

        if (($model = TblPengajian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findWajib($dokumen) {
        $model = TblFilePemohon::findOne(['uploaded_by' => $this->ICNO(), 'dokumenCd' => $dokumen]);

        if ($model) {
            return $model;
        } else {
            return null;
        }
    }
     protected function findBio($id) {
        return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
    }
    protected function findAkademik() {
        if (($model = Tblpendidikan::findOne(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     public function actionPengakuanPemohon($id) {
        $icno = Yii::$app->user->getId();
        $pengajian = TblPengajian::find()->where(['icno' => $this->ICNO(), 'iklan_id' => $id, 'idBorang' => 43, 'status' => [1, 9]])->all();
        $biasiswa = TblBiasiswa::findAll(['icno' => $this->ICNO(), 'iklan_id' => $id, 'idBorang' => 43]);
        $status = TblPermohonan::findAll(['icno' => $icno]); //senarai status permohonan
        $model = TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 43])->one() ? TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 43])->one() : new TblPermohonan();
        $pengajian2 = TblPengajian::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 43, 'status' => [1, 9]])->one() ? TblPengajian::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 43, 'status' => [1, 9]])->one() : new TblPengajian();
        $sponsor2 = TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 43])->all() ?
                TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 43])->all() :
                new TblBiasiswa();
        $ums = TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 43, 'jenisCd' => 2])->all() ?
                TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 43, 'jenisCd' => 2])->all() :
                new TblBiasiswa();
        $sokongan = \app\models\cbelajar\TblFilePemohon::find()->where(['uploaded_by' => $this->ICNO(),
                    'iklan_id' => $id, 'idBorang' => 43])->all();
//        $doktoral = \app\models\cbelajar\TblDokumen::find()->WHERE(['kategori' => 7])->all();
        $senarai_dokumen = $this->findDokumen(1);
        $senarai_dokumenkpm = $this->findDokumenKpm(1);
        $senarai_dokumenln = $this->findDokumenLn(2);
        $dok = $this->findWajib(122);
          $doktoral = \app\models\cbelajar\TblDokumen::find()->WHERE(['kategori' => 1])->all();
        $wajib = TblFilePemohon::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id, 'idBorang' => 43]);
        $check = TblpImage::findOne(['ICNO' => $this->ICNO(), 'iklan_id' => $id]);
        $checkb = TblBiasiswa::find()->where(['icno' => $this->ICNO(), 'iklan_id' => $id,'idBorang'=> 43])->one();
                        $semak = RefSemakan::find()->where(['cb'=>"sub"])->all();

        $model->icno = $icno;
        $model->tahun = date("Y");
        $biodata = $this->findBiodata();
        $iklan = $this->findIklanbyID($id);
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $model->tarikh_m = date('Y-m-d H:i:s');
        if ($pegawai->sub_of == '' || $pegawai->sub_of == '12') {
            $model->app_by = $pegawai->chief; //kj 
        } else {
            $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
            $model->app_by = $pegawaisub->chief; //kj 
        }

        if ($model->ver_by == '') {

            $model->status = 'DALAM TINDAKAN KETUA JABATAN';
            $petindak1 = 'Ketua Jabatan';
            $icnopetindak1 = $model->app_by;
        }
        $model->status_jfpiu = 'Tunggu Perakuan';
        $model->status_bsm = 'Tunggu Kelulusan';
        $model->status_semakan = 'Tunggu Semakan';

        if (Yii::$app->request->post('simpan')) {

            $model->iklan_id = $iklan->id;
            $model->jenis_user_id = 1;
            $model->status_proses = "Data disimpan";
            $model->agree = 1;
            $model->idBorang = 43;
                        $model->status_proses = "S";

            $model->created_at = new \yii\db\Expression('NOW()');
            $model->save(false);
            $pengajian2->idPermohonan = $model->id;
            $pengajian2->by = "ONLINE";
            $pengajian2->save(false);

            foreach ($ums as $ums) {
                $ums = new \stdClass();
                $ums->idPermohonan = $model->id;
                $ums->success = false;

            }


//            foreach ($wajib as $wajib) {
////                $sokongan = \app\models\cbelajar\TblFilePemohon::find()->where(['id' => $s->id])->one();
//                $wajib->idPermohonan = $model->id;
//
//                $wajib->save(false);
//            }



          
            Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Disimpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['pengakuan-pemohon', 'id' => $id]);
        } elseif
        ($model->load(Yii::$app->request->post())) {
            if ($check) {
                if ($checkb) {
                    if ($dok) {


                        $model->jenis_user_id = 1;
                        $model->status_proses = "Selesai Permohonan";
                        $model->created_at = new \yii\db\Expression('NOW()');
                        $model->agree = 1;
                        $model->idBorang = 43;
                        $model->jenis = "SUB PAKAR";
                        $model->save(false);
                        $pengajian2->idPermohonan = $model->id;
                        $pengajian2->by = "ONLINE";
                        $pengajian2->status_proses = "H";
                        $pengajian2->save(false);

                        foreach ($sponsor2 as $sponsor2) {
                                                        $sponsor2 = new \stdClass();

                            $sponsor2->idPermohonan = $model->id;
                            $sponsor2->HighestEduLevelCd = $pengajian2->HighestEduLevelCd;
                            $sponsor2->success = false;
                        }

                        foreach ($ums as $ums) {
                            $ums = new \stdClass();
                            $ums->idPermohonan = $model->id;
                            $ums->success = false;

                        }
                       
//                        foreach ($wajib as $wajib) {
////                $wajib = new \stdClass();
//                            $wajib->idPermohonan = $model->id;
//                            $wajib->save(false);
////                $ln = \app\models\cbelajar\TblFileLn::find()->where(['id' => $l->id])->one();
////                    $luar->idPermohonan = $model->id;
////                    $luar->save(false);
//                        }
                       


                        //}
                    } else {
                        Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => ''
                            . 'Sila muat naik dokumen wajib sebelum menghantar permohonan']);
                        return $this->redirect(['senarai-dokumen?id=' . $id]);
                    }
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => ''
                        . 'Sila isi maklumat pembiayaan/pinjaman, jika tanpa tajaan, sila pilih pilihan tanpa tajaan.']);
                    return $this->redirect(['tambah-biasiswa?id=' . $id]);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => ''
                    . 'Sila muatnaik gambar anda']);
                return $this->redirect(['pengakuan-pemohon?id=' . $id]);
            }
            $this->pendingtask($icnopetindak1, 11);
            $this->notifikasi($icnopetindak1, "Permohonan Pengajian Lanjutan  menunggu tindakan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutisabatikal/senaraitindakan'], ['class' => 'btn btn-primary btn-sm']));
            $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan " . $petindak1 . " " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));

            Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Diterima', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
            return $this->redirect(['lihat-permohonan', 'id' => $model->id]); //
        }

        if($model->status_jfpiu == "Diperakukan" || $model->status_proses == 'Data Disimpan')
        {
            $edit = 'none';
            $view = 'none';
            $vieww = '';
        }

        elseif ($model->agree == '1' || $model->status_proses == 'Data Disimpan') {
            $edit = 'none';
            $vieww = 'none';
            $view = '';
        } else {
            $view = 'none';
            $vieww = 'none';
            $edit = '';
        }

        if (TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 43, 'status_proses' => "Selesai Permohonan"])->exists()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah Memohon!', 'type' => 'error', 'msg' => 'Permohonan hanya boleh dibuat sekali sahaja.']);
            return $this->redirect(['lihat-permohonan', 'id' => $model->id]); //
        }
        
        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "3" && $model->kakitangan->jawatan->job_category == "1") ){
        if($model->kakitangan->DeptId == 138)
        {
            return $this->render(
                            '/cutibelajar/subpakar/form_pengakuan', [
                        'iklan' => $iklan,
                        'model' => $model,
                        'img' => $biodata->img,
                        'biodata' => $biodata,
                        'akademik' => $this->findAkademikbyICNO(),
                        'pengajian' => $pengajian,
                        'biasiswa' => $biasiswa,
                        'edit' => $edit,
                        'view' => $view,
                                'vieww' =>$vieww,
                        'status' => $status,
                        'sokongan' => $sokongan,
                        'doktoral' => $doktoral,
                        'icno' => $icno, 'senarai_dokumen' => $senarai_dokumen,
                        'icno' => $icno,'semak'=>$semak,
                                'senarai_dokumenkpm' => $senarai_dokumenkpm,
                                'senarai_dokumenln' => $senarai_dokumenln,
                            ]
            );
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'info', 'msg' => 'Permohonan ini hanya layak untuk kakitangan Fakulti Perubatan dan Sains Kesihatan dan Gred DU51 ke atas SAHAJA']);
            return $this->redirect('../cbelajar/senarai-borang?id='.$id);
        }
         
        
     }
        else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('../cutibelajar/halaman-pemohon');
        }
    }
     public function findDokumenKpm($status) {
        $senarai_dokumenkpm = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblDokumenKpm::find()->where(['status' => $status, 'kategori' => 3]),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumenkpm;
    }
     public function findDokumenLn($status) {
        $senarai_dokumenln = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblDokumenLn::find()->where(['status' => $status]),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumenln;
    }
    public function actionSemakanSyarat($id, $ICNO, $takwim_id) {
        $iklan = $this->findIklanbyID($takwim_id);
        $message = '';
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();
        $akad = Tblpendidikan::find()->where(['ICNO' => $ICNO, 'HighestEduLevelCd' => 7])->one();
        $senarai_dokumen = $this->findDokumen(1);
        $doktoral = RefSemakan::find()->where(['cb' => "sub"])->all();
//        $doktoral = \app\models\cbelajar\RefDoktoral::find()->all();
         $studi = TblPengajian::find()->where(['icno'=>$ICNO, 'status'=>9])->one();
         $biasiswa = TblBiasiswa::find()->where(['icno'=>$ICNO,'iklan_id'=>$takwim_id])->one();
 $senarai_dokumenkpm = $this->findDokumenKpm(1);
        $senarai_dokumenln = $this->findDokumenLn(2);
        $kontrak = $this->findModel($id);
        $biodata = $this->findBio($ICNO);

        if (Yii::$app->request->post()) {
           
            foreach ($doktoral as $dok) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $dok);
            }
            
            //            $message = 'Berjaya Disimpan';
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-syarat', 'id' => $kontrak->id, 'ICNO' => $ICNO, 'takwim_id' => $kontrak->iklan_id]);
        }
        if ($kontrak->status_semakan == 'Dibawa Ke Mesyuarat' || $kontrak->status_semakan == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if (\app\models\cbelajar\TblNilaiSyarat::find()->where(['icno' => $kontrak->icno, 'iklan_id' => $kontrak->iklan_id, 'parent_id' => $kontrak->id])->exists()) {
            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
            return $this->redirect(['view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
        }
        return $this->render('/cutibelajar/subpakar/semakan_syarat', [
                    'kontrak' => $kontrak,
                    'doktoral' => $doktoral,
                    'message' => $message,
                    'icno' => $kontrak->icno,
                    'edit' => $edit,
                    'view' => $view,
                    'iklan' => $iklan,
                    'img' => $biodata->img,
                    'biodata' => $biodata,
                    'pengajian' => $pengajian,
                    'akademik' => $this->findAkademik(),
                    'akad' => $akad,
                    'senarai_dokumen' => $senarai_dokumen,
            'senarai_dokumenkpm' => $senarai_dokumenkpm,
                    'senarai_dokumenln' => $senarai_dokumenln,
                    
            'studi'=>$studi,'ICNO'=>$ICNO,'biasiswa'=>$biasiswa
        ]);
    }
    protected function savekpi($takwim_id, $i, $id, $kpi) {

        $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['iklan_id' => $takwim_id, 'icno' => $id, 'syarat_id' => $kpi->syarat_id])->one();
        $iklan = $this->findIklanbyID($takwim_id);
        //               $kontrak = $this->findModel($id);
        //       $model = $this->findModelbyID($id);

        if ($mod) {

//            $mod->semak_phd = Yii::$app->request->post($kpi->syarat_id . 'semak_phd');
//            $mod->catatan_phd = Yii::$app->request->post($kpi->syarat_id . 'catatan_phd');
                        $mod->semak_phd = Yii::$app->request->post($kpi->syarat_id . 'semak_phd');
            $mod->iklan_id = $iklan->id;
            $mod->parent_id = $i;
            $mod->tahun = date("Y");
            $mod->created_dt = new \yii\db\Expression('NOW()');
            $mod->save();
        } else {
            $mod = new \app\models\cbelajar\TblNilaiSyarat();
            $mod->syarat_id = $kpi->syarat_id;
            $mod->icno = $id;
            $mod->iklan_id = $iklan->id;
            $mod->parent_id = $i;
            $mod->semak_phd = Yii::$app->request->post($kpi->syarat_id . 'semak_phd');
            $mod->tahun = date("Y");
            $mod->created_dt = new \yii\db\Expression('NOW()');
            $mod->idBorang = 42;
            $mod->save();
        }
    }
     public function actionViewSyarat($id, $ICNO,$takwim_id) {
                 $iklan = $this->findIklanbyID($takwim_id);

        $kriteriakpi = RefSemakan::find()->where(['cb'=>"sub"])->all();
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();
        $studi = TblPengajian::find()->where(['icno'=>$ICNO, 'status'=>9])->one();
        $senarai_dokumen = $this->findDokumen(1);
        $kontrak = $this->findModel($id);
        $biodata = $this->findBio($ICNO);
        if ($kontrak->load(Yii::$app->request->post())) {
            if ($kontrak->status_semakan == 'Dibawa Ke Mesyuarat') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Dibawa ke Mesyuarat!']);
            } elseif ($kontrak->status_semakan == 'Dokumen Tidak Lengkap') {
                Yii::$app->session->setFlash('alert', ['title' => 'Dokumen Tidak Lengkap', 'type' => 'danger', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $kontrak->save(false);
            return $this->redirect(['cbadmin/senaraitindakan1', 'id' => $kontrak->iklan_id]);
        }
        if ($kontrak->status_semakan == 'Layak Dipertimbangkan' || $kontrak->status_semakan == 'Dokumen Tidak Lengkap' || $kontrak->status_semakan == 'Tidak Layak Dipertimbangkan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        return $this->render(
                        '/cutibelajar/subpakar/_syarat', [
                    'icno' => $kontrak->icno,
                    'id' => $kontrak->id,
                    'edit' => $edit,
                    'view' => $view,
                    'kontrak' => $kontrak,
                                  'img' => $biodata->img,
                    'biodata' => $biodata,
                    'pengajian' => $pengajian,
                    'kriteriakpi' => $kriteriakpi,
                            'ICNO'=>$ICNO,'studi'=>$studi, 'iklan'=>$iklan,
 'senarai_dokumen' => $senarai_dokumen,            ]
        );
    }
        protected function findCekSyarat($id) {
        return \app\models\cbelajar\TblNilaiSyarat::findOne(['id' => $id]);
    }
     public function actionUpdateStudy($id,$ICNO,$takwim_id) {
//            $mohon = TblPermohonan::find()->one();
//            $in = $mohon->id;
          $iklan = $this->findIklanbyID($takwim_id);
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();
        $model = \app\models\cbelajar\TblPengajian::find()->where(['id' => $id])->one();

//        $icno = $model->icno;
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump($model);die;
        if (($model->load(Yii::$app->request->post()))) {
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['semakan-syarat?id='.$model->idPermohonan.'&ICNO='.$ICNO.'&takwim_id='.$takwim_id]);
        }
        

        return $this->renderAjax('/cutibelajar/subpakar/_updatess', [
                    'model' => $model,
            'iklan'=>$iklan, 'pengajian'=>$pengajian
        ]);
    }
  public function actionUpdateSponsor($id)
    {
        $model = \app\models\cbelajar\TblBiasiswa::find()->where(['id'=>$id])->one();
//        $icno = $model->icno;

//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
             $model->save(false);
                                 Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan.']);

            return $this->redirect(['pengakuan-pemohon?id='.$model->iklan_id]);
            
        }

        return $this->renderAjax('/cutibelajar/subpakar/_updates', [
            'model' => $model,
         
        ]);
    }
    public function actionUpdateSemakanSyarat($id, $ICNO, $takwim_id) {
        $iklan = $this->findIklanbyID($takwim_id);
        $message = '';
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();
        $akad = Tblpendidikan::find()->where(['ICNO' => $ICNO, 'HighestEduLevelCd' => 7])->one();
        $kriteriakpi = \app\models\cbelajar\RefSemakan::find()->where(['cb'=>'ir'])->all();
        $senarai_dokumen = $this->findDokumen(1);
        $doktoral = \app\models\cbelajar\RefSemakan::find()->where(['cb'=>'ir'])->all();

        $kontrak = $this->findModel($id);
        $biodata = $this->findBio($ICNO);

        if (Yii::$app->request->post()) {
            foreach ($kriteriakpi as $kpi) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $kpi);
            }
            
            //            $message = 'Berjaya Disimpan';
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-syarat', 'id' => $kontrak->id, 'ICNO' => $ICNO, 'takwim_id' => $kontrak->iklan_id]);
        }
        if ($kontrak->status_semakan == 'Dibawa Ke Mesyuarat' || $kontrak->status_semakan == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
//        if (\app\models\cbelajar\TblNilaiSyarat::find()->where(['icno' => $kontrak->icno, 'iklan_id' => $kontrak->iklan_id, 'parent_id' => $kontrak->id])->exists()) {
//            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
//            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
//        }
        return $this->render('/cutibelajar/subpakar/semakan_syarat', [
                    'kontrak' => $kontrak,
                    'kriteriakpi' => $kriteriakpi,
                    'doktoral' => $doktoral,
                    'message' => $message,
                    'icno' => $kontrak->icno,
                    'edit' => $edit,
                    'view' => $view,
                    'iklan' => $iklan,
                    'img' => $biodata->img,
                    'biodata' => $biodata,
                    'pengajian' => $pengajian,
               
                    'akademik' => $this->findAkademik(),
                    'akad' => $akad,
                    'senarai_dokumen' => $senarai_dokumen,
                  
        ]);
    }
     public function actionGenerateSemakanSyarat($id, $ICNO) {

        $biodata = $this->findMaklumat($ICNO);
        $kriteriakpi = RefSemakan::find()->where(['cb'=>'sub'])->all();
        $mod = $this->findCekSyarat($id);
        $kontrak = $this->findModel($id);

        if ($kontrak->status_semakan == 'Dibawa Ke Mesyuarat' || $kontrak->status_semakan == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'filename' => '_CUTIBELAJAR_' . $id,
            'mode' => Pdf::MODE_BLANK, // leaner size using standard fonts
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('/cutibelajar/subpakar/_laporansemakan', [
                'kriteriakpi' => $kriteriakpi, 'mod' => $mod,
                'icno' => $kontrak->icno,
                'id' => $kontrak->id,
                'edit' => $edit,
                'view' => $view,
                'kontrak' => $kontrak,
                'biodata' => $biodata,
            ]),
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => [],
        ]);


        return $pdf->render();
    }
   public function actionLihatPermohonan($id) {
        $model = new TblPermohonan();
        $icno = Yii::$app->user->getId();
        $model->icno = $icno;
        $model2 = TblPermohonan::find()->where(['icno' => $icno, 'idBorang' => 43])->one();
        $model3 = TblPermohonan::find()->where(['icno' => $icno, 'idBorang' => 43])->one(); //senarai status permohonan
        //senarai status permohonan
                        $models = $this->findModel($id);

        $biodata = $this->findBiodata();
        $pengajian = TblPengajian::findAll(['icno' => $icno, 'idPermohonan' => $id, 'idBorang' => 43]);
        $biasiswa = TblBiasiswa::find()->where(['icno' => $icno, 'idBorang' => 43])->all();
        $dokumen = TblFilePemohon::find()->where(['uploaded_by' => $icno, 'idBorang' => 43])->all();
                $semak = RefSemakan::find()->where(['cb'=>"pasca"])->all();
 $senarai_dokumen = $this->findDokumen(1);
        $senarai_dokumenkpm = $this->findDokumenKpm(1);
        $senarai_dokumenln = $this->findDokumenLn(2);
         $p = $model2->iklan_id;
        $iklan = $this->findIklanbyID($p);
        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "1") ) {
            if (TblPermohonan::find()->where(['icno' => $icno, 'id' => $id, 'status_proses' => "Selesai Permohonan"])->exists()) {
                return $this->render(
                                '/cutibelajar/subpakar/lihatpermohonan', [
                            //              'iklan' => $iklan,
                            'model' => $model,
                            'img' => $biodata->img,
                            'biodata' => $biodata,
                            'akademik' => $biodata->akademik,
                            'keluarga' => $biodata->keluarga,
                            'biasiswa' => $biasiswa,
                            'dokumen' => $dokumen,
                            'pengajian' => $pengajian,
                            'model2' => $model2,
                            'model3' => $model3,
                                    'semak' =>$semak,
                                  'senarai_dokumen' => $senarai_dokumen,
                                'senarai_dokumenkpm' => $senarai_dokumenkpm,
                                'senarai_dokumenln' => $senarai_dokumenln,'iklan'=>$iklan,'models'=>$models
                                ]
                );
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('/cutibelajar/halaman-pemohon');
        }
    }
    public function actionBiasiswaums($id) {
      
        $modelsAddress = [new TblBiasiswa()]; 
        $model = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
         $iklan = $this->findIklanByID($id);
        if ((Yii::$app->request->post())) {
                
            $modelsAddress = \app\models\cbelajar\Model::createMultiple(TblBiasiswa::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            
//            // ajax validation
          if (Yii::$app->request->isAjax) {
               Yii::$app->response->format = Response::FORMAT_JSON;
               return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                  ActiveForm::validate($modelCustomer)
                       
                );
            }
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                  
                        foreach ($modelsAddress as $i=> $modelAddress) {
//                                $modelAddress->icno = $modelCustomer->icno;
                                $modelAddress->icno =  Yii::$app->user->getId();
                                $modelAddress->jenisCd = 2;
                                $modelAddress->nama_tajaan = "BIASISWA PENGURUSAN UMS";
                                $modelAddress->BantuanCd;
                                $modelAddress->iklan_id = $iklan->id;
                                $modelAddress->idBorang=43;
                                $modelAddress->created_dt = new \yii\db\Expression('NOW()');
                                $modelAddress->tahun = date("Y");
//                              $modelAddress->parent_id = $modelCustomer->id;
//                              $modelAddress->idBorang = 1;
                            if (! ($flag = $modelAddress->save())) {
                                $transaction->rollBack();
                                break;
                                
                            }
                        
                    }
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan.']);
                    if ($flag) {
                        $transaction->commit();

                        return $this->redirect(['maklumat-biasiswa', 'id' => $iklan->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            
            
        }
        
        return $this->render('/cutibelajar/subpakar/_biasiswaums', [
            'model' => $model,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblBiasiswa] : $modelsAddress,
            'iklan' => $iklan,
          
        ]);
    }
    
    public function actionTanpatajaan($id) {
      
        $icno = Yii::$app->user->getId();
        $model = new TblBiasiswa();
        $model2 = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
        $iklan = $this->findIklanByID($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->iklan_id = $iklan->id;
            $model->bentukBantuan = "TANPA TAJAAN";
            $model->BantuanCd = "6";
            $model->jenisCd = "4";
            $model->idBorang=43;
             $model->amaunBantuan = "PERSENDIRIAN";
             $model->icno = $icno;
             $model->created_dt = new \yii\db\Expression('NOW()');
            $model->tahun = date("Y");
            if($model->save(false)){
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya ditambah!']);
                return $this->redirect(['pengakuan-pemohon', 'id' => $iklan->id ]);
            }
            
        }
        return $this->render('/cutibelajar/subpakar/_tanpatajaan', [
            'model' => $model,
            'iklan' => $iklan,
            'model2' => $model2,
          
        ]);
    }
    
    protected function pendingtask($icno, $id) {
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }
}
