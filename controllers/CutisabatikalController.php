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
use app\models\cbelajar\Model;
use yii\helpers\Html;
use app\models\Notification;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

use app\models\cbelajar\TblLanjutan;

use kartik\mpdf\Pdf;

class CutisabatikalController extends \yii\web\Controller
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
    public function actionAdminview($id, $ICNO, $takwim_id){
        
          $biodata = $this->findMaklumat($ICNO);
//          $pengajian = $this->findPengajian($ICNO);
                    $pengajian = TblPengajian::find()->where(['idPermohonan'=>$id])->all();

          $model = TblPermohonan::find()->where(['id'=>$id, 'status_proses' => ["Selesai Permohonan","Buka Borang"]])->one();
          $biasiswa = TblBiasiswa::find()->where(['idPermohonan'=>$id, 'idBorang'=>1])->all();
          $dokumen = TblFilePemohon::findAll(['uploaded_by'=> $ICNO, 'iklan_id'  => $takwim_id]);
          $dokumen2 = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' =>$ICNO,'iklan_id' => $takwim_id]);
          $dokumen3 = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' =>$ICNO,'iklan_id' => $takwim_id]);
          if(\app\models\cbelajar\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
         return $this->render('_lihatpermohonan',[ 
              'model' => $model,
              'biodata' => $biodata,
              'keluarga' => $biodata->keluarga,
              'biasiswa' => $biasiswa,
              'akademik' => $biodata->akademik,
              'img' => $biodata->img,
              'dokumen' => $dokumen,
              'dokumen2' => $dokumen2,
              'dokumen3' => $dokumen3,
             'pengajian' => $pengajian,
              
            ]);
         }
        
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('../cbelajar/halaman-utama-bsm');}
        
    }
    public function actionAdminviewsm($id, $ICNO, $takwim_id){
        
          $biodata = $this->findMaklumat($ICNO);
//          $pengajian = $this->findPengajian($ICNO);
          $pengajian = TblPengajian::find()->where(['idPermohonan'=>$id])->all();

          $model = TblPermohonan::find()->where(['id'=>$id, 'status_proses' => ["Selesai Permohonan","Buka Borang"]])->one();
          $biasiswa = TblBiasiswa::find()->where(['idPermohonan'=>$id, 'idBorang'=>38])->all();
          $dokumen = TblFilePemohon::findAll(['uploaded_by'=> $ICNO, 'iklan_id'  => $takwim_id]);
          if(\app\models\cbelajar\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
         return $this->render('_lihatpermohonansm',[ 
              'model' => $model,
              'biodata' => $biodata,
              'keluarga' => $biodata->keluarga,
              'biasiswa' => $biasiswa,
              'akademik' => $biodata->akademik,
              'img' => $biodata->img,
              'dokumen' => $dokumen,
             'pengajian' => $pengajian,
              
            ]);
         }
        
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('../cbelajar/halaman-utama-bsm');}
        
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

             $content = $this->renderPartial('cetak-borang', [ 'model' => $model,
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
    public function actionAdminviewsabatikal($id, $ICNO, $takwim_id){
          $biodata = $this->findMaklumat($ICNO);
          $model = TblPermohonan::find()->where(['id'=>$id, 'status_proses' => "Selesai Permohonan"])->one();
          $pengajian = TblPengajian::findAll(['icno'=>$ICNO, 'idPermohonan' => $id, 'idBorang'=>2]);
          $biasiswa = TblBiasiswa::find()->where(['idPermohonan'=>$id, 'idBorang'=>2])->all();
          $dokumen = TblFilePemohon::findAll(['uploaded_by'=> $ICNO, 'iklan_id'  => $takwim_id]);
                      $akad = Tblpendidikan::find()->where(['ICNO'=>$ICNO,'HighestEduLevelCd'=>7])->one();
$dok = \app\models\cbelajar\TblDokumen::find()->where(['kategori'=>4])->all();
        $senarai_dokumen = $this->findDokumen(1);

          if(\app\models\cbelajar\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
         return $this->render('_lihatpermohonansabatikal',[ 
              'model' => $model,
              'biodata' => $biodata,
              'img' => $biodata->img,
              'biasiswa' => $biasiswa,
              'akademik' => $biodata->akademik,
              'dokumen' => $dokumen,
             'pengajian'=>$pengajian,
             'senarai_dokumen'=>$senarai_dokumen,
                 'takwim_id'=>$takwim_id,
             'akad'=>$akad,'dok'=>$dok,'ICNO'=>$ICNO,'id'=>$id
             
            ]);
         }
        
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('../cbelajar/halaman-utama-bsm');}
        
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
        return $this->render('form_gambar', [
                    'model' => $model,
                    'iklan' => $iklan,
                   
        ]);
       
    }
    
     public function actionMaklumatPeribadi($id)
    {
        $icno = Yii::$app->user->getId();
        $biodata = $this->findBiodata();
        $status = $this->findPerkhidmatanbyICNO();
        $model = new TblPermohonan();
        $model->icno = $icno;
        $iklan = $this->findIklanbyID($id);
       
        return $this->render('form_peribadi', 
            [ 
              
              'biodata' => $biodata,
              'status' => $status,
              'iklan' => $iklan,
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
        $biasiswa = TblBiasiswa::findAll(['idPermohonan'=>$id,'icno'=> $ICNO,'iklan_id'  => $takwim_id]);
        $dokumen = TblFilePemohon::findAll(['uploaded_by'=> $ICNO, 'iklan_id'  => $takwim_id]);
//        $dokumen = TblFilePemohon::findAll(['uploaded_by' =>$icno,'iklan_id' => $id]);
        $dokumen2 = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' =>$ICNO,'iklan_id' => $takwim_id]);
        $dokumen3 = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' =>$ICNO,'iklan_id' => $takwim_id]);
        $biodata = $this->findMaklumat($ICNO);
        $statuss = $this->findPerkhidmatanbyICNO();
        $model->app_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
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
        return $this->render('semak_maklumat', [
                   
              'model' => $model,
              'biodata' => $biodata,
              'pengajian' => $pengajian,
              'keluarga' => $biodata->keluarga,
              'biasiswa' => $biasiswa,
              'akademik' => $biodata->akademik,
              'dokumen' => $dokumen,
              'dokumen2' => $dokumen2,
              'dokumen3' => $dokumen3,
              'statuss' => $statuss, 
              'img' => $biodata->img,
              'statuss' => $statuss, 
              'bil' => '1',
              'edit' => $edit,
              'view' => $view
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
        return $this->render('form_akademik', 
        [ 
              'akademik' => $this->findAkademikbyICNO(),
               'iklan' => $iklan,
                'sabatikal2' => $sabatikal2,
        ]);
    
    }
    public function actionMaklumatPengajian($id) {
        
        $pengajianTinggi = TblPengajian::findAll(['icno' =>$this->ICNO(),'iklan_id' => $id, 'idBorang' => 2]);
        $iklan = $this->findIklanbyID($id);
        
        $icno = Yii::$app->user->getId();
        $sabatikal2= $this->findSabatikal();
        $model = new TblPengajian();
        $model->icno = $icno;
        if ($model->load(Yii::$app->request->post())) 
        {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->idBorang = 2;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['maklumat-pengajian',  'id' => $model->id]);
        }
            $searchModel = new TblPengajianSearch();
            $query = TblPengajian::find()->where(['icno' => $icno]);
            $DataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        return $this->render('form_pengajian', 
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

        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->parent_id = $iklan->id;
            $model->idBorang = 2;
            $model->status = 9;
            $model->HighestEduLevelCd = 99;
            if($model->save(false)){
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Pengajian telah Berjaya ditambah!']);
                
                return $this->redirect(['maklumat-pengajian', 'id' => $iklan->id]);
            }
            
        }
        return $this->render('tambahpengajian', [
                    'model' => $model,
                    'iklan' => $iklan,

        ]);
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
                return $this->redirect(['maklumat-pengajian', 'id' => $model->iklan_id]);
            }
        }
        return $this->render('_formpengajian', [
                    'model' => $model,
                   
                   
        ]);
    }
    public function actionMaklumatBiasiswa($id)
    {   $request = Yii::$app->request;
        $sponsor = TblBiasiswa::findAll(['icno' =>$this->ICNO(),'iklan_id' => $id, 'idBorang' => 2]);
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
        return $this->render('form_biasiswa', [
                    'model' => $model,
                    'iklan' => $iklan,
                    'sponsor'=> $sponsor,
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
                    
                   
                    
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
             $model->idBorang=2;
            $model->icno = $icno;
             $model->created_dt = new \yii\db\Expression('NOW()');
            $model->tahun = date("Y");
            if($model->save(false)){
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya ditambah!']);
                return $this->redirect(['maklumat-biasiswa', 'id' => $iklan->id ]);
            }
            
        }
        return $this->render('tambahbiasiswa', [
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
        $dokumen2 = \app\models\cbelajar\TblFilePemohon::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id, 'idBorang' => 2]);

        return $this->render('form_dokumen', 
            [ 
      
             'dokumen2' => $this->findDokumenbyICNO(),
             
             'iklan' => $iklan,
            
             'dokumen2' => $dokumen2,
           
            ]);
        
    }
    public function actionSenaraiDokumen($id)
    {

        $senarai_dokumen = $this->findDokumen(1);
        $iklan = $this->findIklanbyID($id);
        return $this->render('form_upload_dokumen', 
        [
            'senarai_dokumen' => $senarai_dokumen,
            'iklan' => $iklan,
                         
        ]);
    }
    public function actionMuatNaikDokumen($id, $iklan_id) {
       $icno = Yii::$app->user->getId();
       $dokumen = $this->findDokumenbyId($id);
       $model = new TblFilePemohon();
       $iklan =  $this->findIklanbyID($iklan_id);
       if(\app\models\cbelajar\TblFilePemohon::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id'=> $iklan->id, 'idBorang' =>2])->exists())
        {
                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
                         return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);//
        }
       if ($model->load(Yii::$app->request->post())) 
       {
           $model->namafile= UploadedFile::getInstances($model, 'namafile');
          
            foreach ($model->namafile as $saving) {
                if ($saving) {
                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');

                    $file_path = $file->file_name_hashcode; 

                }
                $simpan = new TblFilePemohon();
                $simpan->uploaded_by = $icno;
                $simpan->dokumenCd = $id;
                $simpan->namafile = $file_path;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->idBorang =2;
                $simpan->iklan_id = $iklan->id;
                $simpan->nama_dokumen = $dokumen->nama_dokumen;
                $simpan->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                   return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);
            
            }
          
            
        } else {
                        return $this->render('upload-dokumen-cb', [
                        'model' => $model,
                        'iklan' => $iklan,
                       
            ]);
        }
    }
    public function actionPengakuanPemohon($id){
        $icno=Yii::$app->user->getId();
        $pengajian = TblPengajian::findAll(['icno' =>$this->ICNO(),'iklan_id' => $id, 'idBorang'=>2]);
        $biasiswa = TblBiasiswa::findAll(['icno' =>$this->ICNO(),'iklan_id' => $id, 'idBorang'=>2]);
//        $dokumen = TblFilePemohon::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id, 'idBorang'=>2]);
//        $img = \app\models\cbelajar\TblpImage::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id]);
        $status = TblPermohonan::findAll(['icno' => $icno]); //senarai status permohonan
        $model = TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one()?TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one(): new TblPermohonan();
        $pengajian2 = TblPengajian::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one()?  TblPengajian::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one(): new TblPengajian();
        $sponsor2 = TblBiasiswa::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one()? TblBiasiswa::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one(): new TblBiasiswa();
         $dokumen2 = TblFilePemohon::find()->where(['uploaded_by' =>$icno,'iklan_id' => $id, 'idBorang'=>2])->all();
//       $dokumen2 = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id, 'idBorang'=>1]);
//       $dokumen3 = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id, 'idBorang'=>1]);
        $dokumen = TblFilePemohon::find()->where(['uploaded_by'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one()? TblFilePemohon::find()->where(['uploaded_by'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one(): new TblFilePemohon();
//       $dokumen = TblFilePemohon::find()->where(['uploaded_by'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one()? TblFilePemohon::find()->where(['uploaded_by'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one(): new TblFilePemohon();
        $model->icno = $icno;
        $model->tahun = date("Y");
        $biodata = $this->findBiodata();
        $iklan = $this->findIklanbyID($id);
        
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $model->tarikh_m = date('Y-m-d H:i:s');
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
          $model->status_semakan = 'Tunggu Semakan';
          
            if (Yii::$app->request->post('simpan')){
            
                    $model->iklan_id=$iklan->id;
                    $model->jenis_user_id = 1;
                    $model->status_proses = "Data disimpan";
                    $model->agree = 1;
                    $model->idBorang = 2;
                    $model->created_at = new \yii\db\Expression('NOW()');
                    $model->save(false);
                    $pengajian2->idPermohonan = $model->id;
                    $pengajian2->save(false);
                    $sponsor2->idPermohonan = $model->id;
                    $sponsor2->save(false);
                    $dokumen->idPermohonan = $model->id;
                    $dokumen->save(false);
                 
                    Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Disimpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                     return $this->redirect(['pengakuan-pemohon', 'id' => $id]);
                  
            }
            
            elseif($model->load(Yii::$app->request->post()))  {
             if($model->agree == 0)
            {
                Yii::$app->session->setFlash('alert', ['title' => 'Amaran !', 'type' => 'error', 'msg' => 'Sila tanda kotak semak permohonan.']);
                return $this->redirect(['pengakuan-pemohon', 'id' => $id]);

            }
            else
                {
                    $model->jenis_user_id = 1;
                    $model->status_proses = "Selesai Permohonan";
                    $model->created_at = new \yii\db\Expression('NOW()');
                    $model->agree = 1;
                    $model->idBorang = 2;
                    $model->save(false);
                    $pengajian2->idPermohonan = $model->id;
                    $pengajian2->save(false);
                    $sponsor2->idPermohonan = $model->id;
                    $sponsor2->save(false);
                    $dokumen->idPermohonan = $model->id;
                    $dokumen->save(false);
                    $this->notifikasi($icnopetindak1, "Permohonan Cuti Sabatikal/Latihan Industri menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/menunggu'], ['class'=>'btn btn-primary btn-sm']));
                    $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan ".$petindak1. " ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));

                    Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Diterima', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
                         return $this->redirect(['lihat-permohonan', 'id' => $model->id]);//
                }
        }
        
      if($model->agree == '1' || $model->status_proses == 'Data Disimpan')
               {
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}
            
        if(TblPermohonan::find()->where(['icno' => $icno, 'iklan_id'=>$id, 'idBorang'=>2, 'status_proses'=>"Selesai Permohonan" ])->exists())
        {
                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah Memohon!', 'type' => 'error', 'msg' => 'Permohonan hanya boleh dibuat sekali sahaja.']);
                         return $this->redirect(['lihat-permohonan', 'id' => $model->id]);//
        }
         return $this->render('form_pengakuan', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
              'img' => $biodata->img,
              'biodata' => $biodata,
              'akademik' => $this->findAkademikbyICNO(),
              'pengajian' => $pengajian,
              'biasiswa' => $biasiswa,
              'dokumen' => $dokumen,
                 'dokumen2' => $dokumen2,
              'edit' => $edit,
              'view' => $view,
              'status' => $status,
              
             
            ]);
     
        
    }
    
    public function actionLihatPermohonan($id){
        $model = new TblPermohonan();
        $icno=Yii::$app->user->getId();
        $model->icno = $icno;
        $model2 = TblPermohonan::findOne(['icno' => $icno]); //senarai status permohonan
        $biodata = $this->findBiodata();
        $pengajian = TblPengajian::findAll(['icno'=>$icno, 'idPermohonan' => $id, 'idBorang'=>2]);
        $biasiswa = TblBiasiswa::find()->where(['icno'=>$icno,'idPermohonan' => $id, 'idBorang'=>2])->all();
        $dokumen = TblFilePemohon::find()->where(['uploaded_by' =>$this->ICNO(), 'idBorang'=>2])->all();
//        $dokumen2 = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id, 'idBorang'=>2]);
        $dokumen3 = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id, 'idBorang'=>2]);
//        $iklan = $this->findIklanbyID($id);
        
         if(($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="1")|| ($model->kakitangan->statLantikan== "2" && $model->kakitangan->jawatan->job_category=="1") || ($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="2")) {
              if(TblPermohonan::find()->where(['icno' => $icno, 'id'=>$id, 'status_proses'=>"Selesai Permohonan" ])->exists())
        {
         return $this->render('lihatpermohonan', 
            [ 
//              'iklan' => $iklan,
              'model' => $model,
              'img' => $biodata->img,
              'biodata' => $biodata,
              'akademik' => $biodata->akademik,
              'keluarga' => $biodata->keluarga,
              'biasiswa' => $biasiswa,
              'dokumen' => $dokumen,
//              'dokumen2' => $dokumen2,
//              'dokumen3' => $dokumen3,
              'pengajian'=> $pengajian,
              'model2'=> $model2
            ]);
         }}
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('cutibelajar/halaman-pemohon');}
        
    }
//    public function actionGeneratePermohonan($id) {
//        $model = new TblPermohonan();
//        $icno=Yii::$app->user->getId();
//        $model->icno = $icno;
//        $biodata = $this->findBiodata();
//        $pengajian = TblPengajian::findAll(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>2]);
//        $biasiswa = TblBiasiswa::findAll(['icno'=>$icno,'iklan_id' => $id, 'idBorang'=>2]);
//        $model2 = TblPermohonan::findOne(['icno' => $icno]); //senarai status permohonan
//        $dokumen = TblFilePemohon::findAll(['uploaded_by' =>$icno,'iklan_id' => $id,'idBorang'=>2]);
//        $dokumen2 = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' =>$icno,'iklan_id' => $id, 'idBorang'=>2]);
//        $dokumen3 = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' =>$icno,'iklan_id' => $id, 'idBorang'=>2]);
//        $iklan = $this->findIklanbyID($id);
//
//        if(($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="1")|| ($model->kakitangan->statLantikan== "2" && $model->kakitangan->jawatan->job_category=="1")) {
//        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
//        $pdf = new Pdf([
//            'filename' => '_CUTIBELAJAR_'.$id,
//            'mode' => Pdf::MODE_BLANK, // leaner size using standard fonts
//            'destination' => Pdf::DEST_BROWSER,
//            'content' => $this->renderPartial('_cetakborangpemohon', [
//              'iklan' => $iklan,
//              'model' => $model,
//              'img' => $biodata->img,
//              'biodata' => $biodata,
//              'akademik' => $biodata->akademik,
//              'biasiswa' => $biasiswa,
//              'dokumen' => $dokumen,
//              'dokumen2' => $dokumen2,
//              'dokumen3' => $dokumen3,
//              'pengajian'=> $pengajian,
//              'model2' => $model2,
//            
//                ]),
//            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
//            'options' => [
//             
//            ],
//           
//        ]);
//        }
//        return $pdf->render();
//    }
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
            $model->idBorang=2;
             $model->amaunBantuan = "PERSENDIRIAN";
             $model->icno = $icno;
             $model->created_dt = new \yii\db\Expression('NOW()');
            $model->tahun = date("Y");
            if($model->save(false)){
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya ditambah!']);
                return $this->redirect(['maklumat-biasiswa', 'id' => $iklan->id ]);
            }
            
        }
        return $this->render('_tanpatajaan', [
            'model' => $model,
            'iklan' => $iklan,
            'model2' => $model2,
          
        ]);
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
                                $modelAddress->idBorang=2;
                                $modelAddress->BantuanCd;
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

                        return $this->redirect(['maklumat-biasiswa', 'id' => $iklan->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            
            
        }
        
        return $this->render('_tajaanluar', [
            'model' => $model,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblBiasiswa] : $modelsAddress,
            'iklan' => $iklan
          
        ]);
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
                                $modelAddress->idBorang=2;
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
        
        return $this->render('_biasiswaums', [
            'model' => $model,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblBiasiswa] : $modelsAddress,
            'iklan' => $iklan,
          
        ]);
    }
    protected function findDokumenById($id) {
        if (($model = \app\models\cbelajar\TblDokumenSabatikal::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     public function findDokumen($status) 
    {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblDokumenSabatikal::find()->where(['status' => $status]),

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
        return $this->redirect(['senarai-dokumen-dimuatnaik', 'id'=>$i]);
    }
    protected function findPermohonan($id) {

        if (($model = TblPermohonan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionTolakTawaran($id) {



        $model = $this->findPermohonan($id);
        $pengajian = TblPengajian::find()->where(['icno' => $model->icno, 'status' => 1])->one();
        $biasiswa = TblBiasiswa::find()->where(['icno' => $model->icno, 'status' => 1])->one();

        if ($model->load(Yii::$app->request->post())) {

            if($model->tawaran == 1)
            {
            $model->status = "TOLAK TAWARAN";
            $pengajian->status = 8;
             $pengajian->status_proses = "T";
             $biasiswa->status = 8;

            }
            else
            {
                $model->status = "TERIMA TAWARAN";
            }
//            $model->tarikh_mohon = NULL;

            $model->save(false);
            $pengajian->save(false);
            $biasiswa->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' =>
                'Maklumat berjaya dikemaskini']);
            return $this->redirect(['/cbadmin/senaraitindakan1']);
        }

        return $this->renderAjax('terima-tawaran', [
                    'model' => $model,
        ]);
    }
}
