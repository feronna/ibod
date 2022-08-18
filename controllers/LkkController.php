<?php

namespace app\controllers;

use Yii;
use app\models\cbelajar\TblLkk;
use yii\web\UploadedFile;
use app\models\hronline\Department;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use app\models\Notification;
use yii\web\NotFoundHttpException;
use app\models\hronline\Tblprcobiodata;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use tebazil\runner\ConsoleCommandRunner;
use app\models\cbelajar\TblEmail;
use app\models\cbelajar\LkkDean;
use app\models\cbelajar\TblPenyelia;
use app\models\cbelajar\AksesPa;
use yii\helpers\VarDumper;

error_reporting(0);
class LkkController extends \yii\web\Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['senarailkk', 'adminview', 'senaraisemakan', 'borang-permohonan', 'achievement-master',
                    'achievement-phd', 'pengesahan', 'a-view-rating', 'a-achievement-master', 'a-achievement-phd',
                    'pengesahan-admin', 'pengesahan-kj', 'senaraitindakan', 'view-penyelia', 'index', 'tindakan-kj', 'kj-view-rating',
                    'kj-achievement-phd', 'kj-view-lkk', 'lkk-jfpiu',
                    'lihat-permohonan', 'borang-sokongan', 'pp-view-lkk', 'lihat-borang-pp', 'tindakan-pp',
                    'p-achievement-phd', 'p-achievement-master', 'pengesahan-pp', 'statistik-jabatan',
                    'statistik-pengajian-jabatan', 'senarai-li', 'senarai-sarjana', 'senarai-phd', 'senarai-pos-dok',
                    'senarai-kepakaran', 'senarai-industri','senarai-no-pd',
                    'senarai-no-proposal-defense', 'senarai-proposal-defense', 'senarai-basik',
                    'sv-phd-ums', 'senarai-all', 'senarai-sarjanamuda', 'senarai-diploma','senarai-all-study','muat-naik-dokumen'],
                'rules' => [
                    [
                        'actions' => ['senarailkk', 'senaraisemakan', 'adminview', 'borang-permohonan', 'achievement-master',
                            'achievement-phd', 'pengesahan', 'a-view-rating', 'a-achievement-master', 'a-achievement-phd',
                            'pengesahan-admin', 'pengesahan-kj', 'senaraitindakan', 'view-penyelia', 'index', 'tindakan-kj',
                            'kj-view-rating', 'kj-achievement-phd', 'pengesahan-kj',
                            'kj-view-lkk', 'lkk-jfpiu', 'lihat-permohonan', 'borang-sokongan',
                            'pp-view-lkk', 'lihat-borang-pp', 'tindakan-pp', 'p-achievement-phd',
                            'p-achievement-master', 'pengesahan-pp', 'statistik-jabatan', 'statistik-pengajian-jabatan',
                            'senarai-li', 'senarai-sarjana', 'senarai-phd', 'senarai-pos-dok',
                            'senarai-kepakaran', 'senarai-industri', 'senarai-no-proposal-defense',
                            'senarai-proposal-defense', 'senarai-basik', 'sv-phd-ums', 'senarai-all', 'senarai-sarjanamuda', 
                            'senarai-diploma','senarai-all-study','muat-naik-dokumen','senarai-no-pd',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
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

    protected function icno() {

        return Yii::$app->user->getId();
    }

    protected function notifikasi($icno, $content) {
        //--------Model Notification-----------//
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $icno;
        $ntf->title = 'Permohonan Pengajian Lanjutan';
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        //--------Model Notification-----------//
    }

//    public function actionIndex() {
//        return $this->render('index');
//    }
    public function actionIndex() {

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $confirm = \app\models\TblConfirm::findOne(['ICNO' => $icno]);

        $current_date = date('Y-m-d');

        $a = (Department::find()->where(['chief' => $icno, 'isActive' => '1']));
        $b = (\app\models\cbelajar\TblAccess::find()->where(['icno' => $icno, 'level' => 2]));
        //       $c = 
        if ($a->exists()) {
            return $this->redirect('../cutisabatikal/senaraitindakan');
        }
        //        if(Department::find()->where( ['chief' => $icno, 'isActive' => '1'] )->exists() )||   (\app\models\cbelajar\TblAccess::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
        //{
        //        return $this->redirect('../cutisabatikal/senaraitindakan');} 
        elseif (\app\models\cbelajar\TblAccess::find()->where(['icno' => Yii::$app->user->getId(), 'level' => 2])->exists()) {
            return $this->redirect(['/cbadmin/halaman-admin']);
        } elseif (($biodata->statLantikan == "1" && $biodata->jawatan->job_category == "1") || ($biodata->statLantikan == "2" && $biodata->jawatan->job_category == "1") || ($biodata->statLantikan == "1" && $biodata->jawatan->job_category == "2") || ($biodata->statLantikan == "2" && $biodata->jawatan->job_category == "2")) { //jika user staf lantikan tetap & belum disahkan & staf pentadbiran
            return $this->redirect('../cutibelajar/halaman-pemohon');
        } elseif (\app\models\cbelajar\TblAccess::find()->where(['icno' => Yii::$app->user->getId(), 'level' => 99])->exists()) {
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

    protected function findPengajian1($id) {
        return \app\models\cbelajar\TblPengajian::findOne(['icno' => $id]);
    }

    public function actionBorangPermohonan($id, $icno = NULL) {

        if ($icno == NULL) {
            $icno = Yii::$app->user->getId();
        }

//        $model = new TblLkk();
//        $checkApplication = TblLkk::find()->where(['status_borang' => "Complete"]);
//        if($checkApplication->exists()){
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Progress Report been saved']);
//            return $this->redirect(['lihat-permohonan?id='.$id.'&icno='.$icno]);
//        }
//        else
//        {
//            return $this->redirect(['borang-permohonan?id='.$id]);
//        }
        $model = $this->findLkk($id);
        $mod = new \app\models\cbelajar\TblResearch();
        $research = \app\models\cbelajar\RefResearch::find()->all();
        $b = $this->findStudy($icno);
        $s = $this->findSv($id);
//       $r = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
        $model->status_borang = "Complete";
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $model->tarikh_hantar = date('Y-m-d H:i:s');
        $sv = new TblPenyelia();
        if ($pegawai->sub_of == '' || $pegawai->sub_of == '12') {
            $model->app_by = $pegawai->chief; //kj 
        } else {
            $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
            $model->app_by = $pegawaisub->chief; //kj 
        }
//         if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
////        $model->app_by = $pegawai->chief; //kj 
//            $model->app_by = 860130125080;
//        }
//        else{
////        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
//        $pegawaisub = 860130125080;
//        $model->app_by = 860130125080; //kj 
//        }

        if ($model->ver_by == '') {
            $model->status = 'DALAM TINDAKAN KETUA JABATAN';
            $petindak1 = 'Ketua Jabatan';
            $icnopetindak1 = $model->app_by;
        }
        $model->status_jfpiu = 'Tunggu Perakuan';
        $model->status_bsm = 'Tunggu Kelulusan';

        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lkk_cb');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = $model->dokumen_sokongan ? $model->dokumen_sokongan : '';
        }

        if ($file2) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lkk_cb');
            $filepath2 = $fileapi->file_name_hashcode;
        } else {
            $filepath2 = '';
        }
        $ref = new \app\models\cbelajar\TblResearch();
        if ($model->load(Yii::$app->request->post()) && $sv->load(Yii::$app->request->post())) {

            $model->icno;
            $model->cw_gpa;
            $model->cw_cgpa;
            $model->semester;
            $model->reason_achieved;
            $model->sv_name;
            $model->thesis_title;
            $model->studentno;
            $model->publications;
            $model->achievement_report;
            $model->ms_semester ? $model->ms_semester : '';
            $model->ms_achieved ? $model->ms_achieved : '';
            $mod->idLKK = $model->reportID;
            $model->dokumen_sokongan = $filepath;
            $model->dokumen_sokongan2 = $filepath2;
            $model->status_borang = "Complete ";
            $model->HighestEduLevelCd =$model->pengajian->HighestEduLevelCd;
            $model->open = 1;
//            $model->idSem = $semester;
//            $model->status = "Telah Dihantar";

            $model->save(false);
            if(!$s)
            {
            $sv->reportId = $id;
            $sv->staff_icno = $icno;
            $sv->save(false);
            }
            
            $array = Yii::$app->request->post('stage');

            if ($array) {
                foreach ($array as $value) {

                    $r = \app\models\cbelajar\TblResearch::find()->where(['researchID' => $value, 'idLkk' => $model->reportID])->one();
                    if (!$r) {
                        $mod2 = new \app\models\cbelajar\TblResearch();
                        $mod2->idLKK = $model->reportID;
                        $mod2->researchID = $value;
//                   $mod2->idLKK = $model->reportID?$mod2->idLKK = $model->reportID:''; 
//                   $mod2->researchID = $value?$mod2->researchID = $value:'';
                        $mod2->save(false);
                    }
                }
//            else{
////                   $mod2 = new \app\models\cbelajar\TblResearch(); 
////                   $mod2->idLKK = $model->reportID; 
////                   $mod2->researchID = $value;
//                   $r->idLKK = $model->reportID?$r->idLKK = $model->reportID:''; 
//                   $r->researchID = $value?$r->researchID = $value:'';
//                   $r->save(false); 
//               }}
//                  $this->notifikasi($icnopetindak1, "Laporan Kemajuan Kursus (LKK) menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['lkk/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']));
//                    $this->notifikasi($model->icno, "Laporan Kemajuan Kursus (LKK)  anda telah dihantar untuk tindakan ".$petindak1. " ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
//                    $this->notifikasi($kerani, "Permohonan Pelanjutan Tempoh Cuti Belajar  menunggu tindakan anda. ");
            }


//            else{
//            $mod2->idLKK = $model->reportID; 
//                   $mod2->researchID = $value;
//            }
        }
        if ($b->load(Yii::$app->request->post()) && $s->load(Yii::$app->request->post())) {

          $s->save(false);
            $b->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved.']);
            return $this->redirect(['lihat-permohonan?id=' . $model->reportID . '&icno=' . $icno]); //
        }
//         if ($s->load(Yii::$app->request->post())) {
//
//          
//            $s->save(false);
//
//
//         
//        }
        return $this->render('_borang', [
                    'model' => $model,
                    'mod' => $mod,
                    'research' => $research,
                    'ref' => $ref,
                    'b' => $b, 'sv' =>$sv,
                    'icno' => $icno,'s'=>$s
        ]);
    }
 public function actionBorangLkpLatihanIndustri($id, $icno = NULL) {

        if ($icno == NULL) {
            $icno = Yii::$app->user->getId();
        }

//        $model = new TblLkk();
//        $checkApplication = TblLkk::find()->where(['status_borang' => "Complete"]);
//        if($checkApplication->exists()){
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Progress Report been saved']);
//            return $this->redirect(['lihat-permohonan?id='.$id.'&icno='.$icno]);
//        }
//        else
//        {
//            return $this->redirect(['borang-permohonan?id='.$id]);
//        }
        $model = $this->findLkk($id);
        $mod = new \app\models\cbelajar\TblResearch();
        $research = \app\models\cbelajar\RefResearch::find()->all();
        $b = $this->findStudy($icno);
        $s = $this->findSv($id);
//       $r = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
        $model->status_borang = "Complete";
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $model->tarikh_hantar = date('Y-m-d H:i:s');
        $sv = new TblPenyelia();
        if ($pegawai->sub_of == '' || $pegawai->sub_of == '12') {
            $model->app_by = $pegawai->chief; //kj 
        } else {
            $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
            $model->app_by = $pegawaisub->chief; //kj 
        }
//         if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
////        $model->app_by = $pegawai->chief; //kj 
//            $model->app_by = 860130125080;
//        }
//        else{
////        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
//        $pegawaisub = 860130125080;
//        $model->app_by = 860130125080; //kj 
//        }

        if ($model->ver_by == '') {
            $model->status = 'DALAM TINDAKAN KETUA JABATAN';
            $petindak1 = 'Ketua Jabatan';
            $icnopetindak1 = $model->app_by;
        }
        $model->status_jfpiu = 'Tunggu Perakuan';
        $model->status_bsm = 'Tunggu Kelulusan';

        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lkk_cb');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = $model->dokumen_sokongan ? $model->dokumen_sokongan : '';
        }

        if ($file2) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lkk_cb');
            $filepath2 = $fileapi->file_name_hashcode;
        } else {
            $filepath2 = '';
        }
        $ref = new \app\models\cbelajar\TblResearch();
//        if ($model->load(Yii::$app->request->post()) && $sv->load(Yii::$app->request->post())) {
//
//            $model->icno;
//            $model->cw_gpa;
//            $model->cw_cgpa;
//            $model->semester;
//            $model->reason_achieved;
//            $model->sv_name;
//            $model->thesis_title;
//            $model->studentno;
//            $model->publications;
//            $model->achievement_report;
//          
////            $model->idSem = $semester;
////            $model->status = "Telah Dihantar";
//
//            $model->save(false);
//    
//
////            else{
////            $mod2->idLKK = $model->reportID; 
////                   $mod2->researchID = $value;
////            }
//        }
       
             if ($model->load(Yii::$app->request->post())) {
       
          
                $model->status = 'DALAM TINDAKAN KETUA JABATAN';
                $model->tarikh_mohon = date('Y-m-d H:i:s');
                 $model->status_r = 'BYPASS';
            $model->r_dt = date('Y-m-d H:i:s');
            $model->status_p = 'BYPASS';
            $model->c_date = date('Y-m-d H:i:s');
              $model->ms_semester ? $model->ms_semester : '';
            $model->ms_achieved ? $model->ms_achieved : '';
            $mod->idLKK = $model->reportID;
            $model->dokumen_sokongan = $filepath;
            $model->dokumen_sokongan2 = $filepath2;
            $model->status_borang = "Complete ";
            $model->HighestEduLevelCd =$model->pengajian->HighestEduLevelCd;
            $model->open = 1;
                if ($model->agree == '1') {
                     $this->pendingtask($icnopetindak1, 15);
           $this->notifikasi($icnopetindak1, 
           "Laporan Kemajuan Pengajian (LKP) menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', 
           ['lkk/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']));

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Kemajuan Pengajian telah dihantar!']);
                                $b->save(false);

                    $model->save(false);
                }

                $this->notifikasi($model->icno, "Laporan Kemajuan Pengajian (LKP) anda telah dihantar untuk tindakan Penyelia. " .
                        Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                return $this->redirect(['lkk/pengesahan?id=' . $model->reportID . '&icno=' . $icno]);
            } 
       
       
//        if ($b->load(Yii::$app->request->post()) && $s->load(Yii::$app->request->post())) {
//
//
//
//            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved.']);
//            return $this->redirect(['lihat-permohonan?id=' . $model->reportID . '&icno=' . $icno]); //
//        }
          if ($model->agree == '1') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        return $this->render('_borang_latihan', [
                    'model' => $model,
                    'mod' => $mod,
                    'research' => $research,
                    'ref' => $ref,
                    'b' => $b, 'sv' =>$sv,'view'=>$view,'edit'=>$edit,
                    'icno' => $icno,'s'=>$s
        ]);
    }

//    protected function findStudy($id) {
//        return \app\models\cbelajar\TblPengajian::findOne(['icno' => $id, 'status'=>1]);
//    }
    public function actionBorangSokongan($id) {
//        $model = new TblLkk();

        $model = $this->findLkk($id);
        $p = $model->icno;
        $b = $this->findStudy($p);
        $file = UploadedFile::getInstance($model, 'file');
//        $model->status_borang = "Complete";

        $model->status_bsm = 'Admin Manually Upload';
        $model->status = 'MANUAL UPLOAD';
        $model->agree = 1;
        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lkk_cb');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = '';
        }


        if ($model->load(Yii::$app->request->post())) {


            $model->dokumen_sokongan = $filepath;
            $model->status_borang = "Complete ";
            $model->tarikh_hantar = date('Y-m-d H:i:s');

//            $model->idSem = $semester;
//            $model->status = "Telah Dihantar";
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Berjaya disimpan.']);
            return $this->redirect(['cbadmin/view-lkk', 'id' => $model->icno]); //
        }
        return $this->render('_admin', [
                    'model' => $model,
                    'b' => $b,
        ]);
    }

    protected function findSemester($id) {
        if (($model = \app\models\cbelajar\CbLkkDean::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMuatNaikDokumen($id, $i, $sem) {
        $icno = Yii::$app->user->getId();
        $dokumen = $this->findSemester($i);
        $model = new \app\models\cbelajar\LkkDean();
        $lkk = $this->findLkk($id);
//               $file = UploadedFile::getInstance($model, 'file');

        $sem = TblLkk::find()->where(['icno' => $icno, 'semester' => $sem])->one();

//       if(\app\models\cbelajar\LkkDean::find()->where(['dokumen' => $dokumen->activity])->exists())
//        {
//                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
//                         return $this->redirect(['senarai-dokumen']);//
//        }
//       if($file){
//                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lkk_cb');
//                $filepath = $fileapi->file_name_hashcode;      
//        }
//        else{
//            $filepath = '';
//        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->result == "1") {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->file) {
                    $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'cutibelajar');
                    $model->namafile = $datas->file_name_hashcode;
                }else{
                      if ($lkk->pengajian->HighestEduLevelCd == 1) {
                 Yii::$app->session->setFlash('alert', ['title' => 'Error', 'type' => 'error', 'msg' => 'Please upload any related evidence.']);
                   return $this->redirect(['achievement-phd','id'=>$id,'icno'=>$icno]);
            } else {
                  Yii::$app->session->setFlash('alert', ['title' => 'Error', 'type' => 'error', 'msg' => 'Please upload any related evidence.']);
                   return $this->redirect(['achievement-master','id'=>$id,'icno'=>$icno]);
            }
                    
//                    Yii::$app->session->setFlash('alert', ['title' => 'Error', 'type' => 'error', 'msg' => 'Please upload any related evidence.']);
//                   return $this->redirect(['achievement-phd','id'=>$id,'icno'=>$icno]);
                }
            }


            $model->icno = $icno;
            $model->parent_id = $id;
            $model->result = Yii::$app->request->post()['LkkDean']['result'];
            $model->comment = Yii::$app->request->post()['LkkDean']['comment'];
            $model->dokumen = $dokumen->id;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->tahun = date("Y");
            $model->save(false);

            if ($lkk->pengajian->HighestEduLevelCd == 1) {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved.']);
                return $this->redirect(['achievement-phd?id=' . $lkk->reportID . '&icno=' . $icno]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved.']);
                return $this->redirect(['achievement-master?id=' . $lkk->reportID . '&icno=' . $icno]);
            }

            //}
        } else {
            return $this->renderAjax('update-dokumen', [
                        'model' => $model,
                        'lkk' => $lkk
            ]);

//            return $this->renderAjax('index', [
//                       
//            ]);
        }
    }

//    public function actionUpdateDokumen($id,$i,$sem)
//    {
//        $icno = Yii::$app->user->getId();
//       $dokumen = $this->findSemester($i);
//       $model = new \app\models\cbelajar\LkkDean();
//       $lkk= $this->findLkk($id);
//               $file = UploadedFile::getInstance($model, 'file');
//
//       $sem = TblLkk::find()->where(['icno'=>$icno,'semester'=>$sem])->one();
//
//        if($file){
//                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lkk_cb');
//                $filepath = $fileapi->file_name_hashcode;      
//        }
//        else{
//            $filepath = '';
//        }
//        
//        
////        var_dump('a');die;
//        if ($model->load(Yii::$app->request->post())) {
//            //            foreach ($model->namafile as $saving) {
////                if ($saving) {
//////                     $file_path = null;
////                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');
////
////                    $file_path = $file->file_name_hashcode?$file->file_name_hashcode:''; 
////
////                }
//               $model->namafile = $filepath;
//               $model->icno = $icno;
////                $simpan->idsem = $lkk->semester;
//                $model->parent_id =$id;
////                $simpan->namafile = $filepath;
//
//                $model->result = 1;
////                $model->comment = Yii::$app->request->post()['LkkDean']['comment'];
//                $model->dokumen = $dokumen->id;
//                $model->created_dt = new \yii\db\Expression('NOW()');
//                $model->tahun = date("Y");
//                $model->comment = Yii::$app->request->post()['LkkDean']['comment'];
//              $model->save(false);
//                if($lkk->pengajian->HighestEduLevelCd == 1)
//                {
//                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved.']);
//                   return $this->redirect(['achievement-phd?id='.$lkk->reportID.'&icno='.$icno]);
//                }
//                
//                else
//                {
//                    Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved.']);
//                   return $this->redirect(['achievement-master?id='.$lkk->reportID.'&icno='.$icno]);
//                }
//             
//        }
//
//        return $this->renderAjax('up-dok', [
//            'model' => $model,
//
//
//        ]);
//    }

    protected function findModel2($id) {

        if (($model = TblLkk::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionBukaBorang($id) {



        $model = $this->findModel2($id);


        if ($model->load(Yii::$app->request->post())) {
            
//            if($model->agree == 1)
//            {

            $model->open = 2;
//            $model->tarikh_hantar = NULL;
            $model->save(false);
            
//            }
//            elseif($model->agree == 2)
//            {
//                 $model->agree = 1;
//                 $model->save(false);
//
////                 $model->tarikh_hantar = $model->tarikh_hantar;
//            }
            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' =>
                'Borang berjaya dibuka']);
            return $this->redirect(['senaraisemakan']);
        }

        return $this->renderAjax('buka-borang', [
                    'model' => $model,
        ]);
    }

    public function actionKemaskiniBorang($id) {

        $model = TblLkk::find()->where(['reportID' => $id])->one();
        $mod = new \app\models\cbelajar\TblResearch();
        $research = \app\models\cbelajar\RefResearch::find()->all();
//       $b = $this->findStudy($icno);
//       $r = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
//        $model->icno = $icno; 
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');

        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lkk_cb');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = $model->dokumen_sokongan ? $model->dokumen_sokongan : '';
        }

        if ($file2) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lkk_cb');
            $filepath2 = $fileapi->file_name_hashcode;
        } else {
            $filepath2 = '';
        }
        $ref = new \app\models\cbelajar\TblResearch();
        if ($model->load(Yii::$app->request->post())) {

//            $model->icno;
//            $model->cw_gpa;
//            $model->cw_cgpa;
//            $model->semester;
//            $model->reason_achieved;
//            $model->sv_name;
//            $model->thesis_title;
//            $model->studentno;
//            $model->publications;
//            $model->achievement_report;
            $model->ms_semester ? $model->ms_semester : '';
            $model->ms_achieved ? $model->ms_achieved : '';
            $mod->idLKK = $model->reportID;
            $model->dokumen_sokongan = $filepath;
            $model->dokumen_sokongan2 = $filepath2;
            $model->status_borang = "Complete ";
//            $model->idSem = $semester;
//            $model->status = "Telah Dihantar";

            $model->save(false);
            $array = Yii::$app->request->post('stage');

            if ($array) {
                foreach ($array as $value) {

                    $r = \app\models\cbelajar\TblResearch::find()->where(['researchID' => $value, 'idLkk' => $model->reportID])->one();
                    if (!$r) {
                        $mod2 = new \app\models\cbelajar\TblResearch();
                        $mod2->idLKK = $model->reportID;
                        $mod2->researchID = $value;
//                   $mod2->idLKK = $model->reportID?$mod2->idLKK = $model->reportID:''; 
//                   $mod2->researchID = $value?$mod2->researchID = $value:'';
                        $mod2->save(false);
                    }
                }
//            else{
////                   $mod2 = new \app\models\cbelajar\TblResearch(); 
////                   $mod2->idLKK = $model->reportID; 
////                   $mod2->researchID = $value;
//                   $r->idLKK = $model->reportID?$r->idLKK = $model->reportID:''; 
//                   $r->researchID = $value?$r->researchID = $value:'';
//                   $r->save(false); 
//               }}
//                  $this->notifikasi($icnopetindak1, "Laporan Kemajuan Kursus (LKK) menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['lkk/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']));
//                    $this->notifikasi($model->icno, "Laporan Kemajuan Kursus (LKK)  anda telah dihantar untuk tindakan ".$petindak1. " ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
//                    $this->notifikasi($kerani, "Permohonan Pelanjutan Tempoh Cuti Belajar  menunggu tindakan anda. ");
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved.']);
                return $this->redirect(['adminview?id=' . $id]); //  
            }


//            else{
//            $mod2->idLKK = $model->reportID; 
//                   $mod2->researchID = $value;
//            }
        }

        return $this->render('_kemaskiniborang', [
                    'model' => $model,
                    'mod' => $mod,
                    'research' => $research,
                    'ref' => $ref,
                    'id' => $id,
        ]);
    }

    public function actionJustifikasi($id, $i, $sem) {
        $icno = Yii::$app->user->getId();
        $dokumen = $this->findSemester($i);
        $model = new \app\models\cbelajar\LkkDean();
        $lkk = $this->findLkk($id);
        $sem = TblLkk::find()->where(['icno' => $icno, 'semester' => $sem])->one();

//       if(\app\models\cbelajar\LkkDean::find()->where(['dokumen' => $dokumen->activity])->exists())
//        {
//                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
//                         return $this->redirect(['senarai-dokumen']);//
//        }
        if ($model->load(Yii::$app->request->post())) {
//            $model->namafile = UploadedFile::getInstances($model, 'namafile');
//
//            foreach ($model->namafile as $saving) {
//                if ($saving) {
//                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');
//
//                    $file_path = $file->file_name_hashcode; 
//
//                }


            $simpan = new \app\models\cbelajar\LkkDean();
            $simpan->icno = $icno;
//                $simpan->idsem = $lkk->semester;
            $simpan->parent_id = $id;
//                $simpan->namafile = $file_path;
            $simpan->result = 2;
            $simpan->comment = Yii::$app->request->post()['LkkDean']['comment'];

            $simpan->dokumen = $dokumen->id;
            $simpan->created_dt = new \yii\db\Expression('NOW()');
            $simpan->tahun = date("Y");
            $simpan->save(false);

            if ($lkk->pengajian->HighestEduLevelCd == 1) {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved.']);
                return $this->redirect(['achievement-phd?id=' . $lkk->reportID . '&icno=' . $icno]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved.']);
                return $this->redirect(['achievement-master?id=' . $lkk->reportID . '&icno=' . $icno]);
            }

//            }
        } else {
            return $this->renderAjax('no-evidence', [
                        'model' => $model,
                        'lkk' => $lkk,
            ]);
        }
    }

    public function actionComment($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\DeanComment();

//        $model = \app\models\cbelajar\TblLkk::find()->where(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem])->one()?: 
//                new TblLkk(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem]);
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//       $sem = TblLkk::find()->where(['icno'=>$icno,'semester'=>$sem])->one();
//        $icno = $model->icno;
//        $b = $this->findPengajian2($id);
//        $biasiswa = $this->findBiasiswa($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 2;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

            return $this->redirect(['kj-achievement-phd?i=' . $id . '&id=' . $icno]);
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionCommentSem1($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\DeanComment();

//        $model = \app\models\cbelajar\TblLkk::find()->where(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem])->one()?: 
//                new TblLkk(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem]);
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//       $sem = TblLkk::find()->where(['icno'=>$icno,'semester'=>$sem])->one();
//
//        $icno = $model->icno;
//        $b = $this->findPengajian2($id);
//        $biasiswa = $this->findBiasiswa($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 1;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

            return $this->redirect(['kj-achievement-phd?i=' . $id . '&id=' . $icno]);
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionCommentSemm1($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\DeanComment();

//        $model = \app\models\cbelajar\TblLkk::find()->where(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem])->one()?: 
//                new TblLkk(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem]);
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//       $sem = TblLkk::find()->where(['icno'=>$icno,'semester'=>$sem])->one();
//        $icno = $model->icno;
//        $b = $this->findPengajian2($id);
//        $biasiswa = $this->findBiasiswa($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 1;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

            return $this->redirect(['kj-achievement-master?i=' . $id . '&id=' . $icno]);
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionCommentSemm2($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\DeanComment();

//        $model = \app\models\cbelajar\TblLkk::find()->where(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem])->one()?: 
//                new TblLkk(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem]);
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//       $sem = TblLkk::find()->where(['icno'=>$icno,'semester'=>$sem])->one();
//        $icno = $model->icno;
//        $b = $this->findPengajian2($id);
//        $biasiswa = $this->findBiasiswa($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 2;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

            return $this->redirect(['kj-achievement-master?i=' . $id . '&id=' . $icno]);
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionCommentSemm3($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\DeanComment();

//        $model = \app\models\cbelajar\TblLkk::find()->where(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem])->one()?: 
//                new TblLkk(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem]);
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//       $sem = TblLkk::find()->where(['icno'=>$icno,'semester'=>$sem])->one();
//        $icno = $model->icno;
//        $b = $this->findPengajian2($id);
//        $biasiswa = $this->findBiasiswa($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 3;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

            return $this->redirect(['kj-achievement-master?i=' . $id . '&id=' . $icno]);
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionCommentSemm4($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\DeanComment();

//        $model = \app\models\cbelajar\TblLkk::find()->where(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem])->one()?: 
//                new TblLkk(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem]);
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//       $sem = TblLkk::find()->where(['icno'=>$icno,'semester'=>$sem])->one();
//        $icno = $model->icno;
//        $b = $this->findPengajian2($id);
//        $biasiswa = $this->findBiasiswa($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 4;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

            return $this->redirect(['kj-achievement-master?i=' . $id . '&id=' . $icno]);
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionCommentSem3($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\DeanComment();

//        $model = \app\models\cbelajar\TblLkk::find()->where(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem])->one()?: 
//                new TblLkk(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem]);
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//       $sem = TblLkk::find()->where(['icno'=>$icno,'semester'=>$sem])->one();
//        $icno = $model->icno;
//        $b = $this->findPengajian2($id);
//        $biasiswa = $this->findBiasiswa($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 3;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

            return $this->redirect(['kj-achievement-phd?i=' . $id . '&id=' . $icno]);
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionCommentSem4($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\DeanComment();

//        $model = \app\models\cbelajar\TblLkk::find()->where(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem])->one()?: 
//                new TblLkk(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem]);
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//       $sem = TblLkk::find()->where(['icno'=>$icno,'semester'=>$sem])->one();
//        $icno = $model->icno;
//        $b = $this->findPengajian2($id);
//        $biasiswa = $this->findBiasiswa($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 4;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

            return $this->redirect(['kj-achievement-phd?i=' . $id . '&id=' . $icno]);
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionEditCommentSem6($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\DeanComment::find()->where(['icno' => $icno, 'sem' => 6])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 6;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);

            if ($model->pengajian->HighestEduLevelCd == 1) {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

                return $this->redirect(['kj-achievement-phd?i=' . $id . '&id=' . $icno]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

                return $this->redirect(['kj-achievement-master?i=' . $id . '&id=' . $icno]);
            }
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno,
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionEditCommentSem5($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\DeanComment::find()->where(['icno' => $icno, 'sem' => 5])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 5;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

            return $this->redirect(['kj-achievement-phd?i=' . $id . '&id=' . $icno]);
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno,
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionEditCommentSem4($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\DeanComment::find()->where(['icno' => $icno, 'sem' => 4])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 4;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);


            if ($model->pengajian->HighestEduLevelCd == 1) {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

                return $this->redirect(['kj-achievement-phd?i=' . $id . '&id=' . $icno]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

                return $this->redirect(['kj-achievement-master?i=' . $id . '&id=' . $icno]);
            }
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno,
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionEditCommentSem3($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\DeanComment::find()->where(['icno' => $icno, 'sem' => 3])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 3;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);
            if ($model->pengajian->HighestEduLevelCd == 1) {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

                return $this->redirect(['kj-achievement-phd?i=' . $id . '&id=' . $icno]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

                return $this->redirect(['kj-achievement-master?i=' . $id . '&id=' . $icno]);
            }
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno,
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionEditCommentSem2($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\DeanComment::find()->where(['icno' => $icno, 'sem' => 2])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 2;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);

            if ($model->pengajian->HighestEduLevelCd == 1) {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

                return $this->redirect(['kj-achievement-phd?i=' . $id . '&id=' . $icno]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

                return $this->redirect(['kj-achievement-master?i=' . $id . '&id=' . $icno]);
            }
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno,
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionEditCommentSem1($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\DeanComment::find()->where(['icno' => $icno, 'sem' => 1])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 1;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);

            if ($model->pengajian->HighestEduLevelCd == 1) {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

                return $this->redirect(['kj-achievement-phd?i=' . $id . '&id=' . $icno]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

                return $this->redirect(['kj-achievement-master?i=' . $id . '&id=' . $icno]);
            }
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno,
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionCommentSem5($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\DeanComment();

//        $model = \app\models\cbelajar\TblLkk::find()->where(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem])->one()?: 
//                new TblLkk(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem]);
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//       $sem = TblLkk::find()->where(['icno'=>$icno,'semester'=>$sem])->one();
//        $icno = $model->icno;
//        $b = $this->findPengajian2($id);
//        $biasiswa = $this->findBiasiswa($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 5;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

            return $this->redirect(['kj-achievement-phd?i=' . $id . '&id=' . $icno]);
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionCommentSem6($id, $icno, $sem) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\DeanComment();

//        $model = \app\models\cbelajar\TblLkk::find()->where(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem])->one()?: 
//                new TblLkk(['reportID'=>$id,'icno'=>$icno,'semester'=>$sem]);
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//       $sem = TblLkk::find()->where(['icno'=>$icno,'semester'=>$sem])->one();
//        $icno = $model->icno;
//        $b = $this->findPengajian2($id);
//        $biasiswa = $this->findBiasiswa($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->create_dt = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->icno = $icno;
            $model->d_comment = Yii::$app->request->post()['DeanComment']['d_comment'];
            $model->reportID = $id;
            $model->sem = 6;
            $model->status = "DONE COMMENT";


//              $model->pID= $pengajian->id;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully saved']);

            return $this->redirect(['kj-achievement-phd?i=' . $id . '&id=' . $icno]);
        }

        return $this->renderAjax('up-lkk', [
                    'model' => $model,
                    'icno' => $icno
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionSenaraitindakan() {
        $icno = Yii::$app->user->getId();
        $title = '';
        $senarai = '';
        $status = ['Tunggu Perakuan', 'Diperakukan', 'Tidak Diperakukan'];
        $a = (Department::find()->where(['chief' => $icno, 'isActive' => '1']));
        $b = (\app\models\cbelajar\TblAccess::find()->where(['icno' => $icno]));
        if ($a || $b->exists()) {
//       ->exists()) || (\app\models\cbelajar\TblAccess::find()->where( ['icno' => $icno] )->exists()){
            $senarai = TblLkk::find()->where(['app_by' => $icno, 'status_r' => ["DONE","BYPASS"]])->orderBy(['r_dt' => SORT_DESC]);
            $title = 'Senarai Menunggu Perakuan';
        } elseif (\app\models\cbelajar\TblAccess::find()->where(['icno' => $icno])->exists()) {
            $senarai = TblLkk::find()->where([ 'status_r' => "DONE"])->orderBy(['tarikh_hantar' => SORT_DESC]);
            $title = 'Senarai Menunggu Semakan';
        }
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        if ($title != NULL) {
            return $this->render('senarai_tindakan', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['index']);
        }
    }

    public function actionSenaraisemakan($my = NULL, $statuspenyelia = NULL, $statusjfpiu = NULL, $agree = NULL, $statusbsm = null) {
        $icno = Yii::$app->user->getId();
        $title = '';
        $senarai = '';
        
//        $a = (Department::find()->where( ['chief' => $icno, 'isActive' => '1']));
//        $b = (\app\models\cbelajar\TblAccess::find()->where( ['icno' => $icno] ));
        if (\app\models\cbelajar\TblAccess::find()->where(['icno' => $icno])->exists()) {
            $senarai = \app\models\cbelajar\TblLkk::find()->where(['status_bsm' => ["Diperakukan", "Tunggu Kelulusan"]])->orderBy(['tarikh_mohon' => SORT_DESC]);
            $title = 'Senarai Menunggu Semakan';
        }
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        $my ? $senarais->query->andFilterWhere(['like', 'effectivedt', date_format(date_create($my), 'Y-m')]) : ' ';
//  $sv = TblPenyelia::find()->where(['emel'=>$senarais->query->sv->emel])->orderBy(['staff_icno'=>SORT_DESC])->one();
        $statuspenyelia ? $senarais->query->andFilterWhere(['status_r' => $statuspenyelia]) : '';
        $statusjfpiu ? $senarais->query->andFilterWhere(['status_jfpiu' => $statusjfpiu]) : '';
        $statusbsm ? $senarais->query->andFilterWhere(['status_bsm' => $statusbsm]) : '';

        $agree ? $senarais->query->andFilterWhere(['agree' => $agree]) : '';
        isset(Yii::$app->request->queryParams['icno']) ? $senarais->query->andFilterWhere
                                (['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';
        if ($pilih = Yii::$app->request->post()) {
                $selection = (array)Yii::$app->request->post('selection');
                 VarDumper::dump( $selection, $depth = 10, $highlight = true);die;

                foreach ($selection as $emel) {
                    
             try {
            Yii::$app->mailer3->compose('review_std_rpt')
                    ->setFrom('pengajianlanjutan@ums.edu.my')
                    ->setSubject('LKP UNIVERSITI MALAYSIA SABAH- PLEASE VERIFY YOUR STUDENT PROGRESS REPORT')
                    ->setTo($emel)
                    ->setCc(['norfazleenawana@ums.edu.my'])
//                    ->setHtmlBody($content)
                    ->send();
            $mail_status = 1;
        } catch (Exception $e) {
            $mail_status = 0;
        }

//        $model = new \app\models\cbelajar\TblEmail();
//        $model->from_name = 'VERIFY STUDENT-LKP';
//        $model->from_email = 'pengajianlanjutan@ums.edu.my';
//        $model->to_name = $name;
//        $model->to_email = $email;
//        $model->subject = 'PLEASE VERIFY YOUR PROGRESS REPORT';
////        $model->message = $content;
//        $model->success = $mail_status;
//        $model->date_published = date('Y-m-d H:i:s');
//        $model->save();
//        return 0;
    }
        }
        if ($title != NULL) {
            return $this->render('_senarai_semakan', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
                        'statuspenyelia' => $statuspenyelia,
                        'statusjfpiu' => $statusjfpiu,
                        'statusbsm' => $statusbsm,
                        'agree' => $agree,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['index']);
        }
    }
     public function actionLaporanAkhir() {
        $icno = Yii::$app->user->getId();
        $title = '';
        $senarai = '';
        if (\app\models\cbelajar\TblAccess::find()->where(['icno' => $icno])->exists()) {
            $senarai = \app\models\cbelajar\TblPengajian::find()->joinWith('lapor')->where(['cb_tbl_pengajian.HighestEduLevelCd'=>[211,99,200,102,203,210,207,212]])
                    ->andWhere(['cb_tbl_pengajian.status'=>2])->orderBy(['cb_tbl_lapordiri.dt_lapordiri'=> SORT_DESC]);
            $title = 'Senarai Menunggu Semakan';
        }
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        isset(Yii::$app->request->queryParams['cb_tbl_pengajian.icno']) ? $senarais->query->andFilterWhere
                                (['like', 'cb_tbl_pengajian.icno', Yii::$app->request->queryParams['cb_tbl_pengajian.icno']]) : '';
   isset(Yii::$app->request->queryParams['cb_tbl_pengajian.HighestEduLevelCd']) ? $senarais->query->andFilterWhere(
          ['=>', 'cb_tbl_pengajian.HighestEduLevelCd', Yii::$app->request->queryParams['cb_tbl_pengajian.HighestEduLevelCd']]) : '';
        if ($title != NULL) {
            return $this->render('s_pengajian', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
                        
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['/cbadmin/index']);
        }
    }
//    public function actionSenaraitindakan()
//    {
//        $icno=Yii::$app->user->getId();
//        $title = '';
//        $senarai  = '';
//        $status = ['Tunggu Perakuan', 'Diperakukan', 'Tidak Diperakukan'];
//       if(\app\models\pengesahan\TblAccess::find()->where( ['chief' => $icno, 'isActive' => '1'] )
//               (
//               
//               ->exists()) && (\app\models\cbelajar\TblAccess::find()->where( ['icno' => $icno] )->exists()){
//            $senarai = TblLkk::find()->where(['app_by' => $icno, 'status_borang' => "Complete"])->orderBy(['tarikh_hantar' => SORT_DESC]);
//            $title='Senara)i Menunggu Perakuan';
//        }
////        elseif(\app\models\cbelajar\TblAccess::find()->where( ['icno' => $icno] )->exists()){
////            $senarai = TblLkk::find()->where([ 'status_borang' => "Complete"])->orderBy(['tarikh_hantar' => SORT_DESC]);
////            $title='Senarai Menunggu Semakan';
////        }
//        $senarais = new ActiveDataProvider([
//            'query' => $senarai,
//            'pagination' => [
//                'pageSize' => 10,
//            ],
//        ]);
//          
//        
//        if($title != NULL){ 
//        return $this->render('senarai_tindakan', [
//            'icno' => $icno,
//            'senarai' => $senarais,
//            'title' => $title,
//        ]);}
//        else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect(['index']);}  
//    }
    public function actionRekodLkk() {

        $model = new TblLkk();
        $icno = Yii::$app->user->getId();
        $model->icno = $icno;
        $status = TblLkk::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
        $searchModel = new \app\models\TblLKKSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $ver = TblLkk::find()->where(['ver_by' => $icno, 'status_borang' => "Selesai Permohonan"])->orderBy(['tarikh_m' => SORT_DESC]);
        return $this->render('rekodsemasa', [
                    'model' => $model,
                    'status' => $status,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'ver' => $ver,
                    'bil' => 1,
                    'icno' => $icno
        ]);
    }

    public function actionTindakanKj($i) {
//       $icno=Yii::$app->user->getId();
//               $model = TblLapordiri::find()->where(['iklan_id'=> $id, 'laporID'=>$i])->one();

        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $i]);
        $icno = $model->icno;
        $p = $this->findPengajian1($icno);
        $b = $this->findStudy($icno);
        $s = $this->findSv($i);

//        $iklan = $this->findIklanbyID($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            $model->app_date = date('Y-m-d H:i:s');
            if ($model->status_jfpiu == 'Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Kemajuan Pengajian telah disemak!']);
                $model->save(false);
            } elseif ($model->status_jfpiu == 'Tidak Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);

            $this->notifikasi($model->icno, "Laporan Kemajuan Pengajian (LKP) anda telah disemak oleh KJ dan dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['lkk/senaraitindakan']);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        if (Department::find()->where([ 'chief' => Yii::$app->user->getId()])->exists()) {
            return $this->render('_tindakankj', [

//              'iklan' => $iklan,
                        'model' => $model,
                        'p' => $p,
                        'bil' => '1',
                        'edit' => $edit,
                        'view' => $view,
                        'b' => $b,'s'=>$s
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionTindakanPp($i) {
//       $icno=Yii::$app->user->getId();
//               $model = TblLapordiri::find()->where(['iklan_id'=> $id, 'laporID'=>$i])->one();
                $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $i]);
        $icno = $model->icno;
        $p = $this->findPengajian1($icno);
        $b = $this->findStudy($icno);

//        $iklan = $this->findIklanbyID($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            $model->app_date = date('Y-m-d H:i:s');
            if ($model->status_jfpiu == 'Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Kemajuan Pengajian telah disemak!']);
                $model->save(false);
            } elseif ($model->status_jfpiu == 'Tidak Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);

            $this->notifikasi($model->icno, "Laporan Kemajuan Pengajian (LKP) anda telah disemak oleh KJ dan dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['lkk/senaraitindakan']);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        if (Department::find()->where([ 'pp' => Yii::$app->user->getId()])->exists()||
                AksesPa::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('_tindakanpp', [

//              'iklan' => $iklan,
                        'model' => $model,
                        'p' => $p,
                        'bil' => '1',
                        'edit' => $edit,
                        'view' => $view,
                        'b' => $b
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionViewPenyelia($i) {
//       $icno=Yii::$app->user->getId();
//               $model = TblLapordiri::find()->where(['iklan_id'=> $id, 'laporID'=>$i])->one();

        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $i]);
        $research = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
        $mod = new \app\models\cbelajar\Rating();
        $m = new \app\models\cbelajar\TblResearch();

        $rating = \app\models\cbelajar\RefRating::find()->all();
        $lkk = \app\models\cbelajar\RefResearch::find()->all();

        $icno = $model->icno;
        $p = $this->findPengajian1($icno);
//        $iklan = $this->findIklanbyID($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            $model->app_date = date('Y-m-d H:i:s');
            if ($model->status_jfpiu == 'Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Kemajuan Pengajian telah disemak!']);
                $model->save(false);
            } elseif ($model->status_jfpiu == 'Tidak Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);

            $model->save(false);
            foreach ($rating as $dok) {
                $mod = new \app\models\cbelajar\Rating();
                $mod->p_komen = Yii::$app->request->post($dok->id);
                $mod->idLkk = $model->reportID;
                $mod->p_icno = $model->app_by;
                $mod->idKriteria = $dok->id;
                $mod->save(false);
            }
//             foreach ($lkk as $l)
//            {
//                 $m = \app\models\cbelajar\TblResearch::find()->where(['idLKK'=>$model->reportID])->one();
//                 $m->p_komen = Yii::$app->request->post($l->id) ;
//                  $m->p_icno = $model->app_by;
//
//                 $m->idLKK = $model->reportID;
//                 $m->save(false);
//                
//            }
            $this->notifikasi($model->icno, "Progress Report have been successfully saved. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['lkk/senaraitindakan']);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        if (Yii::$app->user->getId() == $model->app_by) {
            return $this->render('_penyelia', [

//              'iklan' => $iklan,
                        'model' => $model,
                        'mod' => $mod,
                        'p' => $p,
                        'rating' => $rating,
                        'lkk' => $lkk,
                        'm' => $m,
                        'bil' => '1',
                        'edit' => $edit,
                        'view' => $view,
                        'research' => $research
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionLihatPermohonan($id) {
        $icno = Yii::$app->user->getId();
        $model = TblLkk::find()->where(['reportID' => $id, 'icno' => $icno, 'status_borang' => "Complete"])->one();
        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();
          $s = $this->findSv($id);
        $p = $this->findPengajian1($icno);
        if (TblLkk::find()->where(['reportID' => $id, 'status_borang' =>"Complete"])->exists()) {
            return $this->render('_lihatpermohonan', [
                        'model' => $model,
                        'research' => $research,
                        'p' => $p,'s'=>$s
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('/cutibelajar/halaman-pemohon');
        }
    }

    protected function findWajib($dokumen) {
        $model = LkkDean::findOne(['icno' => $this->ICNO(), 'dokumen' => $dokumen]);

        if ($model) {
            return $model;
        } else {
            return null;
        }
    }

    public function actionPengesahan($id, $icno = NULL) {
        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);
        $ext = \app\models\cbelajar\TblPenyelia::find()->where(['staff_icno' => $icno])->one();
//                $e = $model->pengajian->emel_penyelia;
//                $penyelia = $this->findPenyelia($e);
//        $model = TblLkk::find()->where(['reportID'=>$id,'icno' => $icno, 'status_borang' => "Complete"])->one();
        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();
        $b = $this->findStudy($icno);
        $p = $this->findPengajian1($icno);

        $s = $this->findSv($id);

        $app = $this->findWajib(1);
        $api = $this->findWajib(40);
        $semeo = $this->findWajib(16);
        $pd = $this->findWajib(58);
    $pegawai = \app\models\hronline\Department::findOne(['id' => $model->kakitangan->DeptId]) ; 
 if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $model->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = \app\models\hronline\Department::findOne(['id' => $pegawai->sub_of]);
        $model->app_by = $pegawaisub->chief; //kj 
        }
          if($model->ver_by == '')
        { 
            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $model->app_by;
        }
        if($s->nama == "Non")
        {
             if ($model->load(Yii::$app->request->post())) {
       
            if (($app) || ( $semeo) || ($pd) || ($api)) {
                $model->status = 'DALAM TINDAKAN BSM';
                $model->tarikh_mohon = date('Y-m-d H:i:s');
                 $model->status_r = 'BYPASS';
            $model->r_dt = date('Y-m-d H:i:s');
            $model->status_p = 'BYPASS';
            $model->c_date = date('Y-m-d H:i:s');
                if ($model->agree == '1') {
                     $this->pendingtask($icnopetindak1, 15);
           $this->notifikasi($icnopetindak1, 
           "Laporan Kemajuan Pengajian (LKP) menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', 
           ['lkk/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']));

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Kemajuan Pengajian telah dihantar!']);
                    $model->save(false);
                }

                $this->notifikasi($model->icno, "Laporan Kemajuan Pengajian (LKP) anda telah dihantar untuk tindakan Penyelia. " .
                        Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                return $this->redirect(['lkk/pengesahan?id=' . $model->reportID . '&icno=' . $icno]);
            } else {
                if ($model->pengajian->HighestEduLevelCd == 1) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => ''
                        . 'Sila muat naik bukti(dokumen)/justifikasi yang berkaitan di GOT Schedule.'
                        . 'Pastikan mengisi GOT dari Semester 1 sehingga Semester Terkini untuk proses pengumpulan data LKP anda']);
                    return $this->redirect(['achievement-phd?id=' . $id . '&icno=']);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => ''
                        . 'Sila muat naik bukti(dokumen)/justifikasi yang berkaitan di GOT Schedule.'
                        . 'Pastikan mengisi GOT dari Semester 1 sehingga Semester Terkini untuk proses pengumpulan data LKP anda']);
                    return $this->redirect(['achievement-master?id=' . $id . '&icno=']);
                }
            }
        }
        }
            
        
    elseif($model->load(Yii::$app->request->post()))
        {
            if (($app) || ( $semeo) || ($pd) || ($api)) {
                $model->status = 'DALAM TINDAKAN BSM';
                $model->status_r = 'NOT YET';
                $model->tarikh_mohon = date('Y-m-d H:i:s');
                if ($model->agree == '1') {
                    $this->Email($model->agree, $s->nama, $s->emel);

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Kemajuan Pengajian telah dihantar!']);
                    $model->save(false);
                }

//                elseif($model->agree == '2') {
//                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);}
//                 $model->save(false);
//                 $this->Email(1, 'norfazleenawana@ums.edu.my');                    

                $this->notifikasi($model->icno, "Laporan Kemajuan Pengajian (LKP) anda telah dihantar untuk tindakan Penyelia. " .
                        Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                return $this->redirect(['lkk/pengesahan?id=' . $model->reportID . '&icno=' . $icno]);
            } else {
                if ($model->pengajian->HighestEduLevelCd == 1) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => ''
                        . 'Sila muat naik bukti(dokumen)/justifikasi yang berkaitan di GOT Schedule.'
                        . 'Pastikan mengisi GOT dari Semester 1 sehingga Semester Terkini untuk proses pengumpulan data LKP anda']);
                    return $this->redirect(['achievement-phd?id=' . $id . '&icno=']);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => ''
                        . 'Sila muat naik bukti(dokumen)/justifikasi yang berkaitan di GOT Schedule.'
                        . 'Pastikan mengisi GOT dari Semester 1 sehingga Semester Terkini untuk proses pengumpulan data LKP anda']);
                    return $this->redirect(['achievement-master?id=' . $id . '&icno=']);
                }
            }
        }

        if ($model->agree == '1') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if ($model->status_jfpiu == 'Diperakukan') {
            $vieww = '';
        } else {
            $vieww = 'none';
        }

        if ($model->status_r == 'DONE') {
            $viewwr = '';
        } else {
            $viewwr = 'none';
        }
        return $this->render('_pengesahan', [
                    'model' => $model,
                    'research' => $research,
                    'p' => $p, 'icno' => $icno, 'edit' => $edit, 'view' => $view, 'b' => $b,
                    'vieww' => $vieww, 'viewwr' => $viewwr,'s'=>$s
        ]);
//         }
//     else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('halaman-utama-pemohon');}
    }
     public function actionLihatLkpIr($id, $icno = NULL) {
        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);
        $ext = \app\models\cbelajar\TblPenyelia::find()->where(['staff_icno' => $icno])->one();
//                $e = $model->pengajian->emel_penyelia;
//                $penyelia = $this->findPenyelia($e);
//        $model = TblLkk::find()->where(['reportID'=>$id,'icno' => $icno, 'status_borang' => "Complete"])->one();
        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();
        $b = $this->findStudy($icno);
        $p = $this->findPengajian1($icno);

        $s = $this->findSv($id);

        $app = $this->findWajib(1);
      
    $pegawai = \app\models\hronline\Department::findOne(['id' => $model->kakitangan->DeptId]) ; 
 if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $model->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = \app\models\hronline\Department::findOne(['id' => $pegawai->sub_of]);
        $model->app_by = $pegawaisub->chief; //kj 
        }
          if($model->ver_by == '')
        { 
            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $model->app_by;
        }
      
            
        
   

        if ($model->agree == '1') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if ($model->status_jfpiu == 'Diperakukan') {
            $vieww = '';
        } else {
            $vieww = 'none';
        }

        if ($model->status_r == 'DONE') {
            $viewwr = '';
        } else {
            $viewwr = 'none';
        }
        return $this->render('_lihat_ir', [
                    'model' => $model,
                    'research' => $research,
                    'p' => $p, 'icno' => $icno, 'edit' => $edit, 'view' => $view, 'b' => $b,
                    'vieww' => $vieww, 'viewwr' => $viewwr,'s'=>$s
        ]);
//         }
//     else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('halaman-utama-pemohon');}
    }

    public function actionPengesahanKj($id, $icno = NULL) {
        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);
        $ic = $model->icno;
        $b = $this->findStudy($ic);
        $s = $this->findSv($id);
//        $model = TblLkk::find()->where(['reportID'=>$id,'icno' => $icno, 'status_borang' => "Complete"])->one();
        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();

        $p = $this->findPengajian1($icno);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
                        $model->app_date = date('Y-m-d H:i:s');

            $model->verify_dt = date('Y-m-d H:i:s');
            if ($model->status_jfpiu == 'Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'LKP Telah Disemak!']);
                $model->save(false);
            } elseif ($model->status_jfpiu == 'Tidak Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Disahkan', 'type' => 'success', 'msg' => 'LKP tidak disokong!']);
            }
            $model->save(false);
            $ntf = new Notification();
            $ntf->icno = 840929125614; // peg  penyelia perjawatan
            $ntf->title = 'Pengajian Lanjutan - Laporan Kemajuan Pengajian';
            $ntf->content = "Laporan Kemajuan Pengajian (LKP) menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['lkk/senaraisemakan'], ['class' => 'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false);
            $this->notifikasi($model->icno, "Laporan Kemajuan Pengajian (LKP) anda telah dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['lkk/pengesahan-kj?id=' . $model->reportID . '&icno=' . $icno]);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        return $this->render('_pengesahankj', [
                    'model' => $model,
                    'research' => $research, 'b' => $b,
                    'p' => $p, 'icno' => $icno, 'edit' => $edit, 'view' => $view,'s'=>$s
        ]);
//         }
//     else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('halaman-utama-pemohon');}
    }
     public function actionPengesahanKjIr($id, $icno = NULL) {
        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);
        $ic = $model->icno;
        $b = $this->findStudy($ic);
        $s = $this->findSv($id);
//        $model = TblLkk::find()->where(['reportID'=>$id,'icno' => $icno, 'status_borang' => "Complete"])->one();
        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();

        $p = $this->findPengajian1($icno);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
                        $model->app_date = date('Y-m-d H:i:s');

            $model->verify_dt = date('Y-m-d H:i:s');
            if ($model->status_jfpiu == 'Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'LKP Telah Disemak!']);
                $model->save(false);
            } elseif ($model->status_jfpiu == 'Tidak Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Disahkan', 'type' => 'success', 'msg' => 'LKP tidak disokong!']);
            }
            $model->save(false);
            $ntf = new Notification();
            $ntf->icno = 840929125614; // peg  penyelia perjawatan
            $ntf->title = 'Pengajian Lanjutan - Laporan Kemajuan Pengajian';
            $ntf->content = "Laporan Kemajuan Pengajian (LKP) menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['lkk/senaraisemakan'], ['class' => 'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false);
            $this->notifikasi($model->icno, "Laporan Kemajuan Pengajian (LKP) anda telah dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['lkk/pengesahan-kj-ir?id=' . $model->reportID . '&icno=' . $icno]);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        return $this->render('_pengesahankj_ir', [
                    'model' => $model,
                    'research' => $research, 'b' => $b,
                    'p' => $p, 'icno' => $icno, 'edit' => $edit, 'view' => $view,'s'=>$s
        ]);
//         }
//     else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('halaman-utama-pemohon');}
    }

    public function actionPengesahanAdmin($id, $icno = NULL) {
        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);

//        $model = TblLkk::find()->where(['reportID'=>$id,'icno' => $icno, 'status_borang' => "Complete"])->one();
        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();
        $s = $this->findSv($id);

        $p = $this->findPengajian1($icno);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'TELAH DISEMAK';
            $model->ver_date = date('Y-m-d H:i:s');
            if ($model->agree == '1') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully Saved!']);
                $model->save(false);
            } elseif ($model->agree == '2') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);
            $this->notifikasi($model->icno, "Laporan Kemajuan Pengajian (LKP) anda telah disemak. " . Html::a('<i class="fa fa-arrow-right"></i>', ['lkk/senarailkk'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['cbadmin/view-lkk', 'id' => $model->icno]);
        }
        if ($model->status_bsm == 'Diperakukan' || $model->status_bsm == 'Tidak Diluluskan'
        ) {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $vieww = '';
        } else {
            $vieww = 'none';
        }
        return $this->render('_pengesahana', [
                    'model' => $model,
                    'research' => $research,
                    'p' => $p, 'icno' => $icno, 'edit' => $edit, 'view' => $view, 'vieww' => $vieww,'s'=>$s
        ]);
    }
    public function actionPengesahanAdminIr($id, $icno = NULL) {
        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);

//        $model = TblLkk::find()->where(['reportID'=>$id,'icno' => $icno, 'status_borang' => "Complete"])->one();
        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();
        $s = $this->findSv($id);

        $p = $this->findPengajian1($icno);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'TELAH DISEMAK';
            $model->ver_date = date('Y-m-d H:i:s');
            if ($model->agree == '1') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully Saved!']);
                $model->save(false);
            } elseif ($model->agree == '2') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);
            $this->notifikasi($model->icno, "Laporan Kemajuan Pengajian (LKP) anda telah disemak. " . Html::a('<i class="fa fa-arrow-right"></i>', ['lkk/senarailkk'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['lkk/pengesahan-admin-ir', 'id' =>$id]);
        }
        if ($model->status_bsm == 'Diperakukan' || $model->status_bsm == 'Tidak Diluluskan'
        ) {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $vieww = '';
        } else {
            $vieww = 'none';
        }
        return $this->render('_pengesahanair', [
                    'model' => $model,
                    'research' => $research,
                    'p' => $p, 'icno' => $icno, 'edit' => $edit, 'view' => $view, 'vieww' => $vieww,'s'=>$s
        ]);
    }


    public function actionPengesahanPp($id, $icno = NULL) {
        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);

//        $model = TblLkk::find()->where(['reportID'=>$id,'icno' => $icno, 'status_borang' => "Complete"])->one();
        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();

        $p = $this->findPengajian1($icno);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'TELAH DISEMAK';
            $model->ver_date = date('Y-m-d H:i:s');
            if ($model->agree == '1') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Successfully Saved!']);
                $model->save(false);
            } elseif ($model->agree == '2') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);
            $this->notifikasi($model->icno, "Laporan Kemajuan Pengajian (LKP) anda telah disemak. " . Html::a('<i class="fa fa-arrow-right"></i>', ['lkk/senarailkk'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['cbadmin/view-lkk', 'id' => $model->icno]);
        }
        if ($model->status_bsm == 'Diperakukan' || $model->status_bsm == 'Tidak Diluluskan'
        ) {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $vieww = '';
        } else {
            $vieww = 'none';
        }
        return $this->render('_pengesahanpp', [
                    'model' => $model,
                    'research' => $research,
                    'p' => $p, 'icno' => $icno, 'edit' => $edit, 'view' => $view, 'vieww' => $vieww
        ]);
    }

    public function actionLihatBorang($id) {
        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);
//        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK'=>$id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();
//        var_dump($model->reportID);die;
        if (TblLkk::find()->where(['reportID' => $id, 'status_borang' => "Complete"])->exists()) {
            return $this->render('_lihatborang', [
                        'model' => $model,
//              'research' => $research,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    public function actionLihatBorangSv($id) {
        $this->layout = "main-penyelia";

        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);
//        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK'=>$id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();
//        var_dump($model->reportID);die;
        if (TblLkk::find()->where(['reportID' => $id, 'status_borang' => "Complete"])->exists()) {
            return $this->render('_lihatborangsv', [
                        'model' => $model,
//              'research' => $research,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    public function actionLihatBorangSvUms($id) {

        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);
//        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK'=>$id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();
//        var_dump($model->reportID);die;
        if (TblLkk::find()->where(['reportID' => $id, 'status_borang' => "Complete"])->exists()) {
            return $this->render('_lihatborangsvums', [
                        'model' => $model,
//              'research' => $research,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    public function actionLihatBorangStaff($id) {

        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);
//        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK'=>$id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();
//        var_dump($model->reportID);die;
        if (TblLkk::find()->where(['reportID' => $id, 'status_borang' => "Complete"])->exists()) {
            return $this->render('_lihatborangstaff', [
                        'model' => $model,
//              'research' => $research,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    public function actionLihatBorangKj($id) {
        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);
//        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK'=>$id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();
//        var_dump($model->reportID);die;
        if (TblLkk::find()->where(['reportID' => $id, 'status_borang' => "Complete"])->exists()) {
            return $this->render('_lihatborangkj', [
                        'model' => $model,
//              'research' => $research,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    public function actionLihatBorangPp($id) {
        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);
//        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK'=>$id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();
//        var_dump($model->reportID);die;
        if (TblLkk::find()->where(['reportID' => $id, 'status_borang' => "Complete"])->exists()) {
            return $this->render('_lihatborangpp', [
                        'model' => $model,
//              'research' => $research,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

//    public function actionAdminview($id){
//$model = TblLkk::find()->where(['reportID'=>$id,'icno' => $icno, 'status_borang' => "Complete"])->one();
//        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK'=>$id])->all();
////        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();
//
//      if(TblLkk::find()->where(['reportID' => $id, 'status_borang'=>"Complete" ])->exists())
//        {
//         return $this->render('_lihatpermohonan', 
//            [ 
//              'model' => $model,
//              'research' => $research,
//            ]);
//         }
//     else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('halaman-utama-pemohon');}
//        
//        
//    }
    protected function findStudy($id) {
        return \app\models\cbelajar\TblPengajian::find()->where(['icno' => $id, 'status' => [1, 4, 2]])->orderBy(['tarikh_mula' => SORT_DESC])->one();
    }
    
     protected function findSv($id) {
        return TblPenyelia::find()->where(['reportId' => $id])->one();
    }

    protected function findLkk($id) {
        if (($model = TblLkk::findOne(['reportID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findLapor($id) {
        if (($model = \app\models\cbelajar\TblLapordiri::findOne(['laporID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findPenyelia($id) {
        if (($model = \app\models\cbelajar\TblPenyelia::findOne(['emel' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findSpenyelia($id) {
        if (($model = \app\models\cbelajar\TblPenyelia::findOne(['staff_icno' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function findBiodata1($ICNO) {
//        $encryptID = 'SELECT * FROM hronline.tblprcobiodata WHERE SHA1(ICNO) =:icno';
        return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }

    protected function findMaklumat() {
        if (($model = \app\models\cbelajar\TblPengajian::findOne(['icno' => $ICNO])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findStudyss($id) {
        return \app\models\cbelajar\TblPengajian::find()->where(['icno' => $id, 'HighestEduLevelCd' => [1, 202, 20]])
                        ->orderBy(['tarikh_mula' => SORT_DESC])->one();
    }

    public function actionPrintReport($id) {

//          $biodata = $this->findBiodata1($ICNO);
//          $pengajian = $this->findPengajian($ICNO);
        $icno = Yii::$app->user->getId();

        $model = TblLkk::find()->where(['reportID' => $id, 'status_borang' => "Complete"])->one();
        $i = $model->pengajian->id;
        $b = $this->findStudyss($model->icno);

        $content = $this->renderPartial('print-report', [
            'model' => $model, 'b' => $b
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
                'SetHeader' => [$model->kakitangan->CONm],
                'SetFooter' => ["Page {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
            ], // call mPDF methods on the fly
        ]);

        return $pdf->render();
    }
     public function actionPrintReportIr($id) {

//          $biodata = $this->findBiodata1($ICNO);
//          $pengajian = $this->findPengajian($ICNO);
        $icno = Yii::$app->user->getId();

        $model = TblLkk::find()->where(['reportID' => $id, 'status_borang' => "Complete"])->one();
        $i = $model->pengajian->id;
        $b = $this->findStudyss($model->icno);

        $content = $this->renderPartial('print-report-ir', [
            'model' => $model, 'b' => $b
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
                'SetHeader' => [$model->kakitangan->CONm],
                'SetFooter' => ["Page {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
            ], // call mPDF methods on the fly
        ]);

        return $pdf->render();
    }

    public function actionSenarailkk($my = NULL, $icno = NULL) {
        if ($icno == NULL) {
            $icno = Yii::$app->user->getId();
        }
        $model = new TblLkk();
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno' => $icno, 'status' => 1])->all();
        $id = $model->reportID;
//        $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' =>$icno, 'reportID'=>$id])->all();
        $biodata = $this->findBiodata1($icno);

        $model->icno = $icno;
        $status = TblLkk::find()->where(['icno' => $icno])->one(); //senarai status permohonan
        $searchModel = new \app\models\cbelajar\TblLkkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $ver = \app\models\TblLkkSearch::findAll(['icno' => $icno]);
        $lkk = TblLkk::find()->where(['icno' => $icno, 'status_form' => 1])->all();
        $lkk2 = \app\models\cbelajar\TblLkk::find()->where(['icno' => $icno, 'semester' => 1])->all();
        $dataProvider2 = new ActiveDataProvider([

            'query' => TblLkk::find()->where(['icno' => $icno, 'status_form' => 1])->andWhere(['like', 'tarikh_hantar', date_format(date_create($my), 'yy-m')]),
            'pagination' => [

                'pageSize' => 30,
            ],
        ]);
//        var_dump( date_format(date_create($my), 'yy-m')); die;
//              echo $model->kakitangan->Status;die();
        $pengajian2 = \app\models\cbelajar\TblPengajian::find()->where(['icno' => $icno, 'status' => 4])->all();
        $pengajian3 = \app\models\cbelajar\TblPengajian::find()->where(['icno' => $icno, 'status' => 2])->all();

         if (!$model->pengajian) {
            Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'info', 'msg' => 'LKP hanya boleh diakses jika anda sedang cuti belajar!']);
            return $this->redirect(['cutibelajar/halaman-pemohon']);
        }
        elseif($model->pengajian->HighestEduLevelCd == 99 || $model->pengajian->HighestEduLevelCd == 201 )
           
                {
        Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'info', 'msg' =>
            'Hanya staf yang sedang dalam pengajian Sarjana, Sarjana Kepakaran, PHD dan Pos Doktoral yang wajib menghantar LKP. '
            . 'Bagi Cuti Sabatikal dan Latihan Industri, boleh menghantar Laporan Akhir Pengajian dalam borang Lapor Diri.']);
            return $this->redirect(['cutibelajar/halaman-pemohon']);
    }
        elseif ($model->kakitangan->Status == 2) {
            return $this->render('view_permohonan', [
                        'model' => $model,
                        'status' => $status,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'dataProvider2' => $dataProvider2,
                        'lkk' => $lkk,
                        'ver' => $ver,
                        'bil' => 1,
                        'biodata' => $biodata,
                        'pengajian' => $pengajian,
                        'icno' => $icno,
                        'lkk2' => $lkk2,
            ]);
        }
//         elseif ($model->kakitangan->ICNO == "870716496179") {
//            return $this->render('view_permohonan', [
//                        'model' => $model,
//                        'status' => $status,
//                        'searchModel' => $searchModel,
//                        'dataProvider' => $dataProvider,
//                        'dataProvider2' => $dataProvider2,
//                        'lkk' => $lkk,
//                        'ver' => $ver,
//                        'bil' => 1,
//                        'biodata' => $biodata,
//                        'pengajian' => $pengajian3,
//                        'icno' => $icno,
//                        'lkk2' => $lkk2,
//            ]);
//        }
        elseif ($model->pengajian->status == 4) {
            return $this->render('view_permohonan_bs', [
                        'model' => $model,
                        'status' => $status,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'dataProvider2' => $dataProvider2,
                        'lkk' => $lkk,
                        'ver' => $ver,
                        'bil' => 1,
                        'biodata' => $biodata,
                        'pengajian2' => $pengajian2,
                        'icno' => $icno,
                        'lkk2' => $lkk2,
            ]);
        }
            
           
         else {
            Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'info', 'msg' => 'LKP hanya boleh diakses jika anda sedang cuti belajar!']);
            return $this->redirect(['cutibelajar/halaman-pemohon']);
        }
    }

//    public function actionBorangLkk($id) {
//
//        
//        $model = TblLkk::findOne($id);
//        if ($model->load(Yii::$app->request->post())) {
//
//            if ($model->save(false)) {
//
//                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Pengajian telah Berjaya dikemaskini!']);
//                return $this->redirect(['maklumat-pengajian', 'id'=>$model->iklan_id]);
//            }
//        }
//        return $this->render('_borang', [
//                    'model' => $model,
//                   
//                   
//                   
//        ]);
//    }
    public function actionStatistikJabatan() {
        $model = Department::find()
                ->where(['id' => [5, 6, 7, 15, 104, 135, 136, 137, 138, 139, 140,
                141, 142, 143, 188, 209, 210, 193], 'isActive' => '1']);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('report_jfpib', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStatistikJabatanPentadbiran() {
        $model = Department::find()
                ->where(['id' => [164, 138, 158, 4, 39, 202, 33, 105, 167], 'isActive' => '1']);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('report_jfpib_admin', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStatistikPengajianJabatan() {
        $model = Department::find()
                ->where(['id' => [5, 6, 7, 15, 104, 135, 136, 137, 138, 139, 140, 141, 142, 143, 188, 209, 210, 193], 'isActive' => '1']);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('report_pengajian', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraiAll($kumpulan, $category) {



        if ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->orderBy('CONm');
        } elseif ($category == 1) { //keseluruhan admin
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 2])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->orderBy('CONm');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-all', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraiAllStudy($category) {



        if ($category == 0) { //akademik
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->orderBy('CONm');
        } elseif ($category == 1) { //pentadbiran
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['job_category' => 2])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->orderBy('CONm');
        } elseif ($category == 2) { //semua
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['job_category' => [1, 2]])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->orderBy('CONm');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-all-study', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraiProposalDefense($kumpulan, $category) {

//$lkp = TblLkk::find()->one();
        if ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->joinWith('lkp')
                    ->joinWith('lkp.got')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->Where(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
                    ->andWhere(['cb_tbl_dean.result' => 1])

//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
                    ->andWhere(['<>', 'cb_tbl_pengajian.HighestEduLevelCd', '202',])
                    ->groupBy('cb_tbl_dean.icno')
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>1])
                    ->orderBy('CONm');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-pd', [
                    'dataProvider' => $dataProvider,
//            'lkp'=>$lkp
        ]);
    }

    public function actionSenaraiPassPd($category) {

//$lkp = TblLkk::find()->one();
        if ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->joinWith('lkp')
                    ->joinWith('lkp.got')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->Where(['job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
//                     ->andWhere(['cb_tbl_pengajian.modeID' => [1,2,4]])
                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
                    ->andWhere(['cb_tbl_dean.result' => 1])

//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
                    ->andWhere(['NOT IN', 'cb_tbl_pengajian.HighestEduLevelCd', ['202','211']])
                    ->groupBy('cb_tbl_dean.icno')
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>1])
                    ->orderBy('CONm');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-all-pd', [
                    'dataProvider' => $dataProvider,
//            'lkp'=>$lkp
        ]);
    }
    
    public function actionSenaraiBelumHantarPd($kumpulan,$category) {
 $pd = LkkDean::find()->select('icno')->distinct('icno')->where(['dokumen'=>[16,58]])->asArray()->all();
        $icno_array = [];
        foreach($pd as $pd){
            
            array_push($icno_array,$pd['icno']);
        }
//        var_dump($icno_array);die;
            if ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->joinWith('lkp')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->where(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['not in','cb_tbl_pengajian.icno',$icno_array])
//                     ->andWhere(['cb_tbl_pengajian.modeID' => [1,2,4]])
//                    ->andWhere(['cb_tbl_dean.result' => 1])

//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
                    ->andWhere(['<>', 'cb_tbl_pengajian.HighestEduLevelCd', '202',])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>1])
                    ->orderBy('CONm');
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-all-pd', [
                    'dataProvider' => $dataProvider,
//            'lkp'=>$lkp
        ]);
    }
    
    public function actionTiadaRekodPd() {
 $pd = LkkDean::find()->select('icno')->distinct('icno')->where(['dokumen'=>[16,58]])->asArray()->all();
        $icno_array = [];
        foreach($pd as $pd){
            
            array_push($icno_array,$pd['icno']);
        }
//        var_dump($icno_array);die;
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->joinWith('lkp')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->where(['job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['not in','cb_tbl_pengajian.icno',$icno_array])
//                     ->andWhere(['cb_tbl_pengajian.modeID' => [1,2,4]])
//                    ->andWhere(['cb_tbl_dean.result' => 1])

//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
                    ->andWhere(['<>', 'cb_tbl_pengajian.HighestEduLevelCd', '202',])
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>1])
                    ->orderBy('CONm');
        
        
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-all-pd', [
                    'dataProvider' => $dataProvider,
//            'lkp'=>$lkp
        ]);
    }

    public function actionSenaraiNoProposalDefense($kumpulan, $category) {

//$lkp = TblLkk::find()->one();
        if ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
                    ->joinWith('lkp')
                    ->joinWith('lkp.got')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->where(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
                    ->andWhere([ 'cb_tbl_lkk.semester' => [2, 3, 4]])
                    ->andWhere(['cb_tbl_dean.result' => 2])

//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
//                    ->andWhere(['<>', 'cb_tbl_pengajian.HighestEduLevelCd', '202',])
                    ->groupBy('cb_tbl_dean.icno')
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>1])
                    ->orderBy('CONm');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-no-pd', [
                    'dataProvider' => $dataProvider,
//            'lkp'=>$lkp
        ]);
    }

    public function actionSenaraiNoPd($category) {

        $pd = LkkDean::find()->select('icno')->where(['result'=>1,'dokumen'=>58])->asArray()->all();
        $icno_array = [];
        foreach($pd as $pd){
            array_push($icno_array,$pd['icno']);
        }
        
//$lkp = TblLkk::find()->one();
       
      
        if ($category == 0) { //keseluruhan
           
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
                    ->joinWith('lkp')
                    ->joinWith('lkp.got')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->Where(['job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.modeID' => [1,2,4]])
                    ->andWhere(['cb_tbl_dean.dokumen' => [16, 58]])
//                    ->andWhere([ 'cb_tbl_lkk.semester' => [2, 3, 4]])
                    ->andWhere(['cb_tbl_dean.result' => 2])
                    ->andWhere(['NOT IN','cb_tbl_dean.icno',$icno_array])
//                    ->andWhere(['cb_tbl_pengajian.status' => '1'])
//                    ->andWhere(['<>', 'cb_tbl_pengajian.HighestEduLevelCd', '202',])
                    ->groupBy('cb_tbl_dean.icno')
//                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>1])
                    ->orderBy('CONm');
            }
       
      
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-all-no-pd', [
                    'dataProvider' => $dataProvider,
//            'lkp'=>$lkp
        ]);
    }
    

    public function actionSenaraiPhd($kumpulan, $category) {


        if ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 1])
                    ->orderBy('CONm');
        } elseif ($category == 1) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 2])
                    ->andWhere(['tblprcobiodata.Status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 1])
                    ->orderBy('CONm');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-pp', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraiLi($kumpulan, $category) {


        if ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 210])
                    ->orderBy('CONm');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-li', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraiKepakaran($kumpulan, $category) {




        if ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 202])
                    ->orderBy('CONm');
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-kepakaran', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraiSabatikal($kumpulan, $category) {




        if ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 99])
                    ->orderBy('CONm');
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-sabatikal', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraiBasik($kumpulan, $category) {



        if ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 201])
                    ->orderBy('CONm');
        } elseif ($category == 1) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 2])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 201])
                    ->orderBy('CONm');
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-basik', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraiPosDok($kumpulan, $category) {

//       
//
//        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['status' => 1, 'HighestEduLevelCd' => [200]])->all();
//        if($pengajian)
//        {
//        foreach ($pengajian as $p) {
//            $ICNO[] = $p->icno;
//        }
//        }
//        else
//        {
//            return '0';
//        }


        if ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 200])
                    ->orderBy('CONm');
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-posdok', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraiSarjana($kumpulan, $category) {



        if ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 20])
                    ->orderBy('CONm');
        } elseif ($category == 1) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 2])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 20])
                    ->orderBy('CONm');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-sarjana', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraiSarjanamuda($kumpulan, $category) {



        if ($category == 1) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 8])
                    ->orderBy('CONm');
        } elseif ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 2])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 8])
                    ->orderBy('CONm');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-sarjanamuda', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraiDiploma($kumpulan, $category) {



        if ($category == 0) { //keseluruhan
            $list = \app\models\cbelajar\TblPengajian::find()
                    ->joinWith('kakitangan')
                    ->joinWith('kakitangan.jawatan')
//                    ->where(['in', "tblprcobiodata.ICNO", $ICNO])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan, 'job_category' => 2])
                    ->andWhere(['tblprcobiodata.Status' => [1, 2]])
                    ->andWhere(['cb_tbl_pengajian.status' => [1]])
                    ->andWhere(['cb_tbl_pengajian.HighestEduLevelCd' => 11])
                    ->orderBy('CONm');
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-diploma', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function Grid($query) {

        $data = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function actionApplications() {

        $models = Department::find()
                ->where(['id' => [5, 6, 7, 15, 104, 135, 136, 137, 138, 139, 140, 141, 142, 143, 188], 'isActive' => '1']);
        $model = $this->Grid(TblLkk::findAds());
        $layout = 'a_applications_ac';

        return $this->render($layout, [
                    'model' => $model,
                    'models' => $models
        ]);
    }

    public function actionCreateLkk() {
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where([ 'status' => 1, 'userID' => [1]])->all();

        foreach ($pengajian as $p) {
            //    if(Department::find()->where(['ICNO' => $icno])->exists()){

            if (!TblLkk::find()->where(['icno' => $p->icno])->exists()) {
                
                $sem = \app\models\cbelajar\TblLkk::Semlkk($p->icno);
                $effectiveDate = $p->tarikh_mula;
                for ($i = 1; $i <= round($sem); $i++) {
//                        echo round($sem);
                    $lkk = new \app\models\cbelajar\TblLkk();
                    $lkk->icno = $p->icno;
                    $lkk->semester = $i;
                    $effectiveDate = date('Y-m-d', strtotime("+6 months", strtotime($effectiveDate)));
                    $lkk->effectivedt = $effectiveDate;
                    $lkk->agree = 2;
                    $lkk->status_form = 1;
//                        $lkk->HighestEduLevelCd = \app\models\cbelajar\TblPengajian::find()->where(['i'=>$pengajian->icno])->one()->HighestEduLevelCd;
                    $lkk->save(false);
                }
            }
        }
    }

    public function actionCreateLkkLanjutan() {
        $lanjut = \app\models\cbelajar\TblLanjutan::find()->where(['idLanjutan' => 1])->all();

        foreach ($lanjut as $l) {
            $sem = \app\models\cbelajar\TblLkk::Semlkk1($l->icno);
            $effectiveDate = $l->lanjutansdt;
            for ($i = 1; $i <= round($sem); $i++) {
//                        echo round($sem);
                $lkk = new \app\models\cbelajar\TblLkk();
                $lkk->icno = $l->icno;
                $lkk->semester = $i;
                $effectiveDate = date('Y-m-d', strtotime("+6 months", strtotime($effectiveDate)));
                $lkk->effectivedt = $effectiveDate;

                $lkk->status_form = 1;
//                        $lkk->HighestEduLevelCd = \app\models\cbelajar\TblPengajian::find()->where(['i'=>$pengajian->icno])->one()->HighestEduLevelCd;
                $lkk->save(false);
            }
        }
    }

//      public function actionStatistikJabatan()
//    { 
//        $model = Department::find()
//                ->where(['isActive' => '1']);
//        
//        $dataProvider = new ActiveDataProvider([
//            'query' => $model,
//            'pagination' => false,
//        ]);
//
//        return $this->render('statistik_mata_idp_jabatan', [
//                    'dataProvider' => $dataProvider,
//        ]);
//   
//    }
    public function actionDelete($id) {

        $mj = TblLkk::findOne($id)->delete();
//        $iklan = findIklanbyID($id);

        return $this->redirect(['senarailkk']);
    }

    public function actionLkkReport($my = NULL, $jfpiu = NULL) {
        $icno = Yii::$app->user->getId();
        $arrayicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=', 'Status', '6']) : '';

        $cb = \app\models\cbelajar\TblLkk::find()->where(['status_form' => "1"])->all();


//                 var_dump( date_format(date_create($my), 'yy-m')); die;
        if (Yii::$app->request->queryParams) {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblPengajian::find()->where(['cb_tbl_pengajian.status' => 1, 'cb_tbl_pengajian.userID' => 1])->orderBy(['effectivedt' => SORT_ASC]) : \app\models\cbelajar\TblLkk::find()->where(['icno' => $arrayicno->select(['ICNO']), 'status_form' => "1"])
            ;
        } else {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblLkk::find()->where(['status' => 0]) : \app\models\cbelajar\TblLkk::find()->where(['icno' => $arrayicno->select(['ICNO']), 'status_form' => "0"])->orderBy(['tarikh_hantar' => SORT_ASC]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        $my ? $dataProvider->query->andFilterWhere(['like', 'effectivedt', date_format(date_create($my), 'Y-m')]) : ' ';
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['effectivedt']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'effectivedt', Yii::$app->request->queryParams['effectivedt']]) : '';
//    if(Department::find()->where(['ICNO' => $icno])->exists()){
        return $this->render('senarai_lkk', [
                    'dataProvider' => $dataProvider,
                    'jfpiu' => $jfpiu,
        ]);
//       else{
//        return $this->redirect('index');}
    }

//public function actionLkkJfpiu() {
//        $userID = Yii::$app->user->getId();
////        $currentYear = date('Y');
//
//        $staffCurrentIDP = \app\models\cbelajar\TblPengajian::find()
//                ->joinWith('kakitangan.department')
//                ->joinWith('kakitangan.jawatan')
//                ->where(['chief' => $userID])
//                ->orWhere(['department.pp' => $userID])
////                ->andWhere(['tahun' => $currentYear])
//                ->andWhere(['job_category' => 2])
//                
//                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
//                                ->andWhere(['cb_tbl_pengajian.status' => 1])
//
//                ->orderBy('CONm');
//        
//        $staffCurrentIDP2 = \app\models\cbelajar\TblPengajian::find()
//                ->joinWith('kakitangan.department')
//                ->joinWith('kakitangan.jawatan')
//                ->where(['chief' => $userID])
//                ->orWhere(['department.pp' => $userID])
////                ->andWhere(['tahun' => $currentYear])
//                ->andWhere(['job_category' => 1])
//                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
//                ->andWhere(['cb_tbl_pengajian.status' => 1])
//
//                ->orderBy('CONm');
//        
//        $dataProvider = new ActiveDataProvider([
//            'query' => $staffCurrentIDP,
//             'pagination' => [
//
//                'pageSize' => 5,
//
//            ],
//        ]);
//
//        $dataProvider2 = new ActiveDataProvider([
//            'query' => $staffCurrentIDP2,
//              'pagination' => [
//
//                'pageSize' => 5,
//
//            ],
//        ]);
//
//        return $this->render('lkk_jfpiu', [
//                    'model' => $staffCurrentIDP,
//                    'dataProvider' => $dataProvider,
//                    'model2' => $staffCurrentIDP2,
//                    'dataProvider2' => $dataProvider2,
//        ]);
//    }

    public function actionLkkJfpiu() {
        $userID = Yii::$app->user->getId();
//        $currentYear = date('Y');

        $staffCurrentIDP = \app\models\cbelajar\TblPengajian::find()
                ->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => 2])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])
                ->orderBy('CONm');

        $staffCurrentIDP2 = \app\models\cbelajar\TblPengajian::find()
                ->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => 1])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])
                ->orderBy('CONm');

        $dataProvider = new ActiveDataProvider([
            'query' => $staffCurrentIDP,
            'pagination' => [

                'pageSize' => 5,
            ],
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $staffCurrentIDP2,
            'pagination' => [

                'pageSize' => 5,
            ],
        ]);

        return $this->render('lkk_jfpiu_pp', [
                    'model' => $staffCurrentIDP,
                    'dataProvider' => $dataProvider,
                    'model2' => $staffCurrentIDP2,
                    'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionViewLkk($my = NULL, $id) {
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno' => $id, 'idBorang' => 1])->one();

//        $biodata = $this->findMaklumat1($id);
        $biodata = $this->findBiodata($id);
        $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => $id])->all();
//        $model2 = $this->findKemudahan($id);
        $dataProvider2 = new ActiveDataProvider([

            'query' => \app\models\cbelajar\TblLkk::find()->where(['icno' => $id, 'status_form' => 1])->andWhere(['like', 'tarikh_hantar', date_format(date_create($my), 'yy-m')]),
            'pagination' => [

                'pageSize' => 30,
            ],
        ]);
        if (Yii::$app->request->post('notipemohon')) {
            $this->notifipemohon();
            return $this->refresh();
        } elseif (Yii::$app->request->post('notipegawai')) {
            $this->notifipegawai();
            return $this->refresh();
        }
        if (Department::find()->where([ 'chief' => Yii::$app->user->getId()])->exists()) {
            return $this->render('viewlkk', [
//             'model' => $model,
                        'lkk' => $lkk,
                        'pengajian' => $pengajian,
                        'id' => $id,
                        'biodata' => $biodata,
//                    'model2' => $model2,
            ]);
        }
    }

    public function actionKjViewLkk($my = NULL, $id) {
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno' => $id, 'idBorang' => 1])->one();

//        $biodata = $this->findMaklumat1($id);

        $biodata = $this->findBiodata($id);

        $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => $id])->all();
//        $model2 = $this->findKemudahan($id);
        $dataProvider2 = new ActiveDataProvider([

            'query' => \app\models\cbelajar\TblLkk::find()->where(['icno' => $id, 'status_form' => 1])->andWhere(['like', 'tarikh_hantar', date_format(date_create($my), 'yy-m')]),
            'pagination' => [

                'pageSize' => 30,
            ],
        ]);
        if (Yii::$app->request->post('notipemohon')) {
            $this->notifipemohon();
            return $this->refresh();
        } elseif (Yii::$app->request->post('notipegawai')) {
            $this->notifipegawai();
            return $this->refresh();
        }
        if (Department::find()->where([ 'chief' => Yii::$app->user->getId()])->exists()) {
            return $this->render('kjviewlkk', [
//             'model' => $model,
                        'lkk' => $lkk,
                        'pengajian' => $pengajian,
                        'id' => $id,
                        'biodata' => $biodata,
//                    'model2' => $model2,
            ]);
        }
    }

    public function actionPpViewLkk($my = NULL, $id) {
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno' => $id, 'idBorang' => 1])->one();

//        $biodata = $this->findMaklumat1($id);

        $biodata = $this->findBiodata($id);

        $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => $id])->all();
//        $model2 = $this->findKemudahan($id);
        $dataProvider2 = new ActiveDataProvider([

            'query' => \app\models\cbelajar\TblLkk::find()->where(['icno' => $id, 'status_form' => 1])->andWhere(['like', 'tarikh_hantar', date_format(date_create($my), 'yy-m')]),
            'pagination' => [

                'pageSize' => 30,
            ],
        ]);
        if (Yii::$app->request->post('notipemohon')) {
            $this->notifipemohon();
            return $this->refresh();
        } elseif (Yii::$app->request->post('notipegawai')) {
            $this->notifipegawai();
            return $this->refresh();
        }
        if (Department::find()->where([ 'pp' => Yii::$app->user->getId()])->exists()|| AksesPa::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('ppviewlkk', [
//             'model' => $model,
                        'lkk' => $lkk,
                        'pengajian' => $pengajian,
                        'id' => $id,
                        'biodata' => $biodata,
//                    'model2' => $model2,
            ]);
        }
    }

    protected function findBiodata($id) {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAdminview($id) {
//        $icno=Yii::$app->user->getId();
        $model = TblLkk::find()->where(['reportID' => $id])->one();
        $research = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $id])->all();
//        $mod = \app\models\cbelajar\TblResearch::find()->where(['idLKK' => $model->id])->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            $model->app_date = date('Y-m-d H:i:s');
            if ($model->status_bsm == 'Tunggu Kelulusan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Kemajuan Pengajian (LKP) telah disemak!']);
                $model->save(false);
            } elseif ($model->status_bsm == 'Tidak Diluluskan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);
            $this->notifikasi($model->icno, "Laporan Kemajuan Pengajian (LKP) anda telah disemak oleh KJ dan dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['lkk/senaraitindakan']);
        }
        if ($model->status_bsm == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diluluskan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        if (TblLkk::find()->where(['reportID' => $id])->exists()) {
            return $this->render('adminview', [
                        'model' => $model,
                        'research' => $research,
                        'view' => $view,
                        'edit' => $edit,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('/cutibelajar/index');
        }
    }

    protected function findModel($id) {

        if (($model = TblLkk::findAll($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSemester1($id) {

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'HighestEduLevelCd' => 20])->all();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $id]);
        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($id);

        if (Yii::$app->request->post()) {
            foreach ($sem as $kpi) {
                $this->savekpi($id, $kontrak->icno, $kpi);
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-syarat', 'id' => $kontrak->reportID, 'ICNO' => $ICNO, 'takwim_id' => $kontrak->iklan_id]);
        }
        if ($kontrak->status_jfpiu == 'Dibawa Ke Mesyuarat' || $kontrak->status_jfpiu == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $kontrak->icno, 'parent_id' => $kontrak->reportID])->exists()) {
            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
        }
        return $this->render('sem1', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'icno' => $kontrak->icno,
                    'edit' => $edit,
                    'view' => $view,
                    'model' => $model, 'p' => $p
        ]);
    }

    public function actionAchievement($id, $icno = NULL) {
        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'HighestEduLevelCd' => 20])->all();
        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'HighestEduLevelCd' => 20])->all();
        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'HighestEduLevelCd' => 20])->all();
        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'HighestEduLevelCd' => 20])->all();
        $model = $this->findLkk($id);

//        $model = TblLkk::findOne(['status_borang' => "Complete", 'icno'=>$icno]);
//        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($icno);

        if (Yii::$app->request->post()) {
//            foreach ($sem as $kpi) {
//                $this->savekpi( $icno, $kpi);
//            }
            foreach ($sem as $dok) {
                $mod = new \app\models\cbelajar\LkkDean();
                $mod->result = Yii::$app->request->post($dok->id . 'result');
                $mod->comment = Yii::$app->request->post($dok->id);
                $mod->icno = $icno;
                $mod->idsem = $dok->id;
                $mod->save(false);
            }
            foreach ($sem2 as $dok2) {
                $mod = new \app\models\cbelajar\LkkDean();
                $mod->result = Yii::$app->request->post($dok2->id . 'result');
                $mod->comment = Yii::$app->request->post($dok2->id);
                $mod->icno = $icno;
                $mod->idsem = $dok2->id;
                $mod->save(false);
            }
            foreach ($sem3 as $dok3) {
                $mod = new \app\models\cbelajar\LkkDean();
                $mod->result = Yii::$app->request->post($dok3->id . 'result');
                $mod->comment = Yii::$app->request->post($dok3->id);
                $mod->icno = $icno;
                $mod->idsem = $dok3->id;
                $mod->save(false);
            }
            foreach ($sem4 as $dok4) {
                $mod = new \app\models\cbelajar\LkkDean();
                $mod->result = Yii::$app->request->post($dok4->id . 'result');
                $mod->comment = Yii::$app->request->post($dok4->id);
                $mod->icno = $icno;
                $mod->idsem = $dok4->id;
                $mod->save(false);
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-syarat', 'ICNO' => $icno]);
        }

//        if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $icno])->exists()) {
//            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
//            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
//        }
        return $this->render('_achievement', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p,
                    'sem2' => $sem2, 'sem3' => $sem3, 'sem4' => $sem4,
                    'icno' => $icno, 'lkk' => $lkk
        ]);
    }

//    public function actionAchievementMaster($id)
//    {
//        $icno = Yii::$app->user->getId();  
//
//        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem'=>1,'HighestEduLevelCd'=>20])->all();
//        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem'=>2,'HighestEduLevelCd'=>20])->all();
//        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem'=>3,'HighestEduLevelCd'=>20])->all();
//        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem'=>4,'HighestEduLevelCd'=>20])->all();
//
//        $model = TblLkk::findOne(['status_borang' => "Complete", 'icno'=>$id]);
////        $icno = $model->icno;
//        $p= $this->findPengajian1($icno);
//       
//        $kontrak = $this->findModel($icno);
//
//        if (Yii::$app->request->post()) {
////            foreach ($sem as $kpi) {
////                $this->savekpi( $icno, $kpi);
////            }
//              foreach ($sem as $dok)
//            {
//                 $mod = \app\models\cbelajar\LkkDean::findOne(['icno'=>$id]);
////                 $mod = new \app\models\cbelajar\LkkDean();
//                 $mod->result = Yii::$app->request->post($dok->id . 'result');
//                 $mod->comment = Yii::$app->request->post($dok->id) ;
//                 $mod->icno= $icno;
//                 $mod->idsem = $dok->id;
//                 $mod->save(false);
//            }
//              foreach ($sem2 as $dok2)
//            {
//                 $mod = new \app\models\cbelajar\LkkDean();
//                 $mod->result = Yii::$app->request->post($dok2->id . 'result');
//                 $mod->comment = Yii::$app->request->post($dok2->id) ;
//                 $mod->icno= $icno;
//                 $mod->idsem = $dok2->id;
//                 $mod->save(false);
//            }
//              foreach ($sem3 as $dok3)
//            {
//                 $mod = new \app\models\cbelajar\LkkDean();
//                 $mod->result = Yii::$app->request->post($dok3->id . 'result');
//                 $mod->comment = Yii::$app->request->post($dok3->id) ;
//                 $mod->icno= $icno;
//                 $mod->idsem = $dok3->id;
//                 $mod->save(false);
//            }
//              foreach ($sem4 as $dok4)
//            {
//                 $mod = new \app\models\cbelajar\LkkDean();
//                 $mod->result = Yii::$app->request->post($dok4->id . 'result');
//                 $mod->comment = Yii::$app->request->post($dok4->id) ;
//                 $mod->icno= $icno;
//                 $mod->idsem = $dok4->id;
//                 $mod->save(false);
//            }
//           
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
//            return $this->redirect(['view-syarat', 'ICNO' => $icno]);
//        }
//      
////        if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $icno])->exists()) {
////            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
////            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
////        }
//        return $this->render('_kjachievement', [
//            'kontrak' => $kontrak,
//            'sem' => $sem,
//            'model'=> $model, 'p'=>$p, 'sem2' =>$sem2,'sem3'=>$sem3, 'sem4'=>$sem4,
//            
//
//
//        ]);
//    }
    public function actionAchievementPhd($id, $icno = NULL) {
        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'status' => 1])->all();
        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'status' => 1])->all();
        
        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'status' => 1])->all();
        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'status' => 1])->all();
        $sem5 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 5, 'status' => 1])->all();
        $sem6 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 6, 'status' => 1])->all();
        $model = $this->findLkk($id);
        $lkk = \app\models\cbelajar\LkkDean::find()->where(['icno' => $model->icno])->orderBy(['created_dt' => SORT_DESC])->all();
//var_dump($lkk);die();
//        $model = TblLkk::findOne(['icno'=>$icno]);
//        $icno = $model->icno;
        $p = $this->findPengajian1($icno);
        $l = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $id]);

        $kontrak = $this->findModel($icno);

        if (Yii::$app->request->post()) {
            foreach ($sem as $dok) {
                $mod = new \app\models\cbelajar\LkkDean();
                $mod->result = Yii::$app->request->post($dok->id . 'result');
                $mod->comment = Yii::$app->request->post($dok->id);
                $mod->status_d = 1;
                $mod->icno = $icno;
                $mod->idsem = $dok->id;
                $mod->result = 'y';
                $mod->save(false);
            }



            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Successfully saved.']);
            return $this->redirect(['achievement-phd']);
        }


        return $this->render('_achievementphd', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p, 'sem2' => $sem2, 'sem3' => $sem3, 'sem4' => $sem4,
                    'sem5' => $sem5, 'sem6' => $sem6, 'icno' => $icno, 'lkk' => $lkk, 'l' => $l
        ]);
    }

    public function actionAchievementMaster($id, $icno = NULL) {
        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'status' => 2])->all();
        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'status' => 2])->all();
        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'status' => 2])->all();
        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'status' => 2])->all();

        $model = $this->findLkk($id);
        $lkk = \app\models\cbelajar\LkkDean::find()->where(['icno' => $model->icno])->all();
//var_dump($lkk);die();
//        $model = TblLkk::findOne(['icno'=>$icno]);
//        $icno = $model->icno;
        $p = $this->findPengajian1($icno);
        $l = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $id]);

        $kontrak = $this->findModel($icno);

        if (Yii::$app->request->post()) {
            foreach ($sem as $dok) {
                $mod = new \app\models\cbelajar\LkkDean();
                $mod->result = Yii::$app->request->post($dok->id . 'result');
                $mod->comment = Yii::$app->request->post($dok->id);
                $mod->status_d = 1;
                $mod->icno = $icno;
                $mod->idsem = $dok->id;
                $mod->result = 'y';
                $mod->save(false);
            }



            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Successfully saved.']);
            return $this->redirect(['achievement-master?id=' . $model->reportID]);
        }


        return $this->render('_achievementmaster', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p, 'sem2' => $sem2, 'sem3' => $sem3, 'sem4' => $sem4,
                    'icno' => $icno, 'lkk' => $lkk, 'l' => $l
        ]);
    }

    public function actionSemesterOne($id, $icno = NULL) {
        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'status' => 1])->all();

        $model = $this->findLkk($id);


//        $model = TblLkk::findOne(['icno'=>$icno]);
//        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($icno);

        if (Yii::$app->request->post()) {
            foreach ($sem as $dok) {
                $mod = new \app\models\cbelajar\LkkDean();
                $mod->result = Yii::$app->request->post($dok->id . 'result');
                $mod->comment = Yii::$app->request->post($dok->id);
                $mod->parent_id = 1;
                $mod->icno = $icno;
                $mod->idsem = $dok->id;
                $mod->save(false);
            }


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['achievement-phd']);
        }

//        if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $icno])->exists()) {
//            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
//            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
//        }
        return $this->render('_asem1', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p, 'icno' => $icno
        ]);
    }

    public function actionSemester() {
        $icno = Yii::$app->user->getId();


        return $this->render('page-semester', []);
//        } else {
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//            return $this->render('/cutibelajar/index');
//        }
    }

    public function actionKjAchievementPhd($id, $i = null) {
        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'status' => 1])->all();
        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'status' => 1])->all();
        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'status' => 1])->all();
        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'status' => 1])->all();
        $sem5 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 5, 'status' => 1])->all();
        $sem6 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 6, 'status' => 1])->all();
//        $model = TblLkk::findOne(['status_borang' => "Complete", 'icno'=>$icno]);
        $comment = new \app\models\cbelajar\DeanComment();
        $model = TblLkk::find()->where(['status_borang' => "Complete", 'reportID' => $i])->one();
// var_dump($model);die;
//        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($icno);
        if ($comment->load(Yii::$app->request->post())) {
            $comment->status = 'DONE CHECKED';
            $comment->create_dt = date('Y-m-d H:i:s');
            if ($comment->status == 'DONE CHECKED') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
                $comment->icno = $id;
                $comment->parent_id = 1;
                $comment->app_by = $icno;
                $comment->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);
            }
            $comment->save(false);


//            foreach ($progress as $dok)
//            {
//                 $progress = new \app\models\cbelajar\Progress();
//                 $progress->comment = Yii::$app->request->post($dok->id) ;
//                 $progress->reportID = $model->reportID;
//                 $progress->icno = $model->icno;
//                 $progress->idProgress = $dok->id;
//                 $progress->save(false);
//                
//            }
//                $this->notifikasi($model->icno, "Progress Report have been successfully saved. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
            return $this->redirect(['kj-achievement-phd?id=' . $id]);
        }
//        if (Yii::$app->request->post()) {
//            foreach ($sem as $dok)
//            {
//                 $mod = \app\models\cbelajar\LkkDean::findOne(['parent_id' => "1", 'icno'=>$id]);
////                 $mod = new \app\models\cbelajar\LkkDean();
////                 $mod->result = Yii::$app->request->post($dok->id . 'result');
//                 $mod->d_comment = Yii::$app->request->post($dok->id) ;
////                 $mod->parent_id=1;
////                 $mod->icno= $icno;
////                 $mod->idsem = $dok->id;
//                 $mod->save(false);
//            }
//            
//            foreach ($sem2 as $dok2)
//            {
//                 $mod = new \app\models\cbelajar\LkkDean();
//             $mod->result = Yii::$app->request->post($dok2->id . 'result');
//                 $mod->comment = Yii::$app->request->post($dok2->id) ;
//                 
//                $mod->icno= $icno;
//                 $mod->idsem = $dok2->id;
//                 $mod->save(false);
//            }
//            foreach ($sem3 as $dok3)
//            {
//                 $mod = new \app\models\cbelajar\LkkDean();
//              $mod->result = Yii::$app->request->post($dok3->id . 'result');
//                 $mod->comment = Yii::$app->request->post($dok3->id) ;
//                 
//                $mod->icno= $icno;
//                 $mod->idsem = $dok3->id;
//                 $mod->save(false);
//            }
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
//            return $this->redirect(['kj-achievement-phd?id='.$id]);



        return $this->render('_kjachievementphd', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p, 'sem2' => $sem2, 'sem3' => $sem3, 'sem4' => $sem4,
                    'sem5' => $sem5, 'sem6' => $sem6, 'icno' => $icno, 'id' => $id, 'comment' => $comment
        ]);
    }

    public function actionAAchievementPhd($id, $i = null) {
        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'status' => 1])->all();
        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'status' => 1])->all();
        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'status' => 1])->all();
        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'status' => 1])->all();
        $sem5 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 5, 'status' => 1])->all();
        $sem6 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 6, 'status' => 1])->all();
//        $model = TblLkk::findOne(['status_borang' => "Complete", 'icno'=>$icno]);
        $comment = new \app\models\cbelajar\DeanComment();
        $model = TblLkk::find()->where(['reportID' => $i, 'status_borang' => "Complete"])->one();
//        $model2= TblLkk::find()->where(['reportID'=>$i,'semester'=>2,'status_borang' => "Complete"])->one();
//        $model3= TblLkk::find()->where(['reportID'=>$i,'semester'=>3,'status_borang' => "Complete"])->one();
//        $model4= TblLkk::find()->where(['reportID'=>$i,'semester'=>4,'status_borang' => "Complete"])->one();
//        $model5= TblLkk::find()->where(['reportID'=>$i,'semester'=>5,'status_borang' => "Complete"])->one();
//        $model6= TblLkk::find()->where(['reportID'=>$i,'semester'=>6,'status_borang' => "Complete"])->one();
// var_dump($model);die;
//        $icno = $model->icno;
        $p = $this->findPengajian1($id);

        $kontrak = $this->findModel($id);
//        if($comment->load(Yii::$app->request->post())) {
//            $comment->status = 'DONE CHECKED';
//            $comment->create_dt = date('Y-m-d H:i:s');
//            if($comment->status == 'DONE CHECKED') { 
//                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
//                 $comment->icno = $id;
//                 $comment->parent_id = 1;
//                 $comment->app_by = $icno;
//                $comment->save(false);
//            }
//                else {
//                    Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);}
//                 $comment->save(false);
//                 
//                 
//
//                return $this->redirect(['a-achievement-phd?id='.$id]);
//        }
//
//        


        return $this->render('_aachievementphd', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p, 'sem2' => $sem2, 'sem3' => $sem3, 'sem4' => $sem4,
                    'sem5' => $sem5, 'sem6' => $sem6, 'icno' => $icno, 'id' => $id, 'comment' => $comment,
//            'model2'=>$model2,'model3'=>$model3, 'model4'=>$model4, $model5=>$model5,
//            'model6'=>$model6,
        ]);
    }

    public function actionPAchievementPhd($id, $i = null) {
        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'status' => 1])->all();
        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'status' => 1])->all();
        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'status' => 1])->all();
        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'status' => 1])->all();
        $sem5 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 5, 'status' => 1])->all();
        $sem6 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 6, 'status' => 1])->all();
//        $model = TblLkk::findOne(['status_borang' => "Complete", 'icno'=>$icno]);
        $comment = new \app\models\cbelajar\DeanComment();
        $model = TblLkk::find()->where(['reportID' => $i, 'status_borang' => "Complete"])->one();
//        $model2= TblLkk::find()->where(['reportID'=>$i,'semester'=>2,'status_borang' => "Complete"])->one();
//        $model3= TblLkk::find()->where(['reportID'=>$i,'semester'=>3,'status_borang' => "Complete"])->one();
//        $model4= TblLkk::find()->where(['reportID'=>$i,'semester'=>4,'status_borang' => "Complete"])->one();
//        $model5= TblLkk::find()->where(['reportID'=>$i,'semester'=>5,'status_borang' => "Complete"])->one();
//        $model6= TblLkk::find()->where(['reportID'=>$i,'semester'=>6,'status_borang' => "Complete"])->one();
// var_dump($model);die;
//        $icno = $model->icno;
        $p = $this->findPengajian1($id);

        $kontrak = $this->findModel($id);
//        if($comment->load(Yii::$app->request->post())) {
//            $comment->status = 'DONE CHECKED';
//            $comment->create_dt = date('Y-m-d H:i:s');
//            if($comment->status == 'DONE CHECKED') { 
//                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
//                 $comment->icno = $id;
//                 $comment->parent_id = 1;
//                 $comment->app_by = $icno;
//                $comment->save(false);
//            }
//                else {
//                    Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);}
//                 $comment->save(false);
//                 
//                 
//
//                return $this->redirect(['a-achievement-phd?id='.$id]);
//        }
//
//        


        return $this->render('_pachievementphd', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p, 'sem2' => $sem2, 'sem3' => $sem3, 'sem4' => $sem4,
                    'sem5' => $sem5, 'sem6' => $sem6, 'icno' => $icno, 'id' => $id, 'comment' => $comment,
//            'model2'=>$model2,'model3'=>$model3, 'model4'=>$model4, $model5=>$model5,
//            'model6'=>$model6,
        ]);
    }

    public function actionAAchievementMaster($id, $i = null) {
        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'status' => 2])->all();
        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'status' => 2])->all();
        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'status' => 2])->all();
        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'status' => 2])->all();

        $comment = new \app\models\cbelajar\DeanComment();
        $model = TblLkk::find()->where(['status_borang' => "Complete", 'reportID' => $i, 'icno' => $id])->one();
//        $model2= TblLkk::find()->where(['reportID'=>$i,'icno'=>$id,'semester'=>2])->one();
//        $model3= TblLkk::find()->where(['reportID'=>$i,'icno'=>$id,'semester'=>3])->one();
//        $model4= TblLkk::find()->where(['reportID'=>$i,'icno'=>$id,'semester'=>4])->one();// var_dump($model);die;
//        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($icno);
        if ($comment->load(Yii::$app->request->post())) {
            $comment->status = 'DONE CHECKED';
            $comment->create_dt = date('Y-m-d H:i:s');
            if ($comment->status == 'DONE CHECKED') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
                $comment->icno = $id;
                $comment->parent_id = 1;
                $comment->app_by = $icno;
                $comment->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);
            }
            $comment->save(false);



//                $this->notifikasi($model->icno, "Progress Report have been successfully saved. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
            return $this->redirect(['kj-achievement-master?id=' . $id]);
        }




        return $this->render('_aachievementmaster', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p, 'sem2' => $sem2, 'sem3' => $sem3, 'sem4' => $sem4,
                    'icno' => $icno, 'id' => $id, 'comment' => $comment, 'i'
                    => $i
        ]);
    }

    public function actionPAchievementMaster($id, $i = null) {
        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'status' => 2])->all();
        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'status' => 2])->all();
        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'status' => 2])->all();
        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'status' => 2])->all();

        $comment = new \app\models\cbelajar\DeanComment();
        $model = TblLkk::find()->where(['status_borang' => "Complete", 'reportID' => $i, 'icno' => $id])->one();
//        $model2= TblLkk::find()->where(['reportID'=>$i,'icno'=>$id,'semester'=>2])->one();
//        $model3= TblLkk::find()->where(['reportID'=>$i,'icno'=>$id,'semester'=>3])->one();
//        $model4= TblLkk::find()->where(['reportID'=>$i,'icno'=>$id,'semester'=>4])->one();// var_dump($model);die;
//        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($icno);
        if ($comment->load(Yii::$app->request->post())) {
            $comment->status = 'DONE CHECKED';
            $comment->create_dt = date('Y-m-d H:i:s');
            if ($comment->status == 'DONE CHECKED') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
                $comment->icno = $id;
                $comment->parent_id = 1;
                $comment->app_by = $icno;
                $comment->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);
            }
            $comment->save(false);



//                $this->notifikasi($model->icno, "Progress Report have been successfully saved. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
            return $this->redirect(['kj-achievement-master?id=' . $id]);
        }




        return $this->render('_pachievementmaster', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p, 'sem2' => $sem2, 'sem3' => $sem3, 'sem4' => $sem4,
                    'icno' => $icno, 'id' => $id, 'comment' => $comment, 'i'
                    => $i
        ]);
    }

    public function actionKjAchievementMaster($id, $i = null) {
        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'status' => 2])->all();
        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'status' => 2])->all();
        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'status' => 2])->all();
        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'status' => 2])->all();

        $comment = new \app\models\cbelajar\DeanComment();
        $model = TblLkk::find()->where(['status_borang' => "Complete", 'reportID' => $i])->one();
// var_dump($model);die;
//        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($icno);
        if ($comment->load(Yii::$app->request->post())) {
            $comment->status = 'DONE CHECKED';
            $comment->create_dt = date('Y-m-d H:i:s');
            if ($comment->status == 'DONE CHECKED') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
                $comment->icno = $id;
                $comment->parent_id = 1;
                $comment->app_by = $icno;
                $comment->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);
            }
            $comment->save(false);



//                $this->notifikasi($model->icno, "Progress Report have been successfully saved. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
            return $this->redirect(['kj-achievement-master?id=' . $id]);
        }




        return $this->render('_kjachievementmaster', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p, 'sem2' => $sem2, 'sem3' => $sem3, 'sem4' => $sem4,
                    'icno' => $icno, 'id' => $id, 'comment' => $comment,
        ]);
    }

    public function actionSvPhdUms($id, $i = null) {

        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'status' => 1])->all();
        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'status' => 1])->all();
        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'status' => 1])->all();
        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'status' => 1])->all();
        $sem5 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 5, 'status' => 1])->all();
        $sem6 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 6, 'status' => 1])->all();
        $comment = new \app\models\cbelajar\DeanComment();
        $model = TblLkk::find()->where(['status_borang' => "Complete", 'reportID' => $i])->one();
// var_dump($model);die;
//        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($icno);
        if ($comment->load(Yii::$app->request->post())) {
            $comment->status = 'DONE CHECKED';
            $comment->create_dt = date('Y-m-d H:i:s');
            if ($comment->status == 'DONE CHECKED') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
                $comment->icno = $id;
                $comment->parent_id = 1;
                $comment->app_by = $icno;
                $comment->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);
            }
            $comment->save(false);



//                $this->notifikasi($model->icno, "Progress Report have been successfully saved. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
            return $this->redirect(['kj-achievement-master?id=' . $id]);
        }




        return $this->render('_svphdums', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p, 'sem2' => $sem2, 'sem3' => $sem3, 'sem4' => $sem4, 'sem5' => $sem5,
                    'sem6' => $sem6,
                    'icno' => $icno, 'id' => $id, 'comment' => $comment
        ]);
    }

    public function actionSvMasterUms($id, $i = null) {

        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'status' => 2])->all();
        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'status' => 2])->all();
        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'status' => 2])->all();
        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'status' => 2])->all();

        $comment = new \app\models\cbelajar\DeanComment();
        $model = TblLkk::find()->where(['status_borang' => "Complete", 'reportID' => $i])->one();
// var_dump($model);die;
//        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($icno);
        if ($comment->load(Yii::$app->request->post())) {
            $comment->status = 'DONE CHECKED';
            $comment->create_dt = date('Y-m-d H:i:s');
            if ($comment->status == 'DONE CHECKED') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
                $comment->icno = $id;
                $comment->parent_id = 1;
                $comment->app_by = $icno;
                $comment->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);
            }
            $comment->save(false);



//                $this->notifikasi($model->icno, "Progress Report have been successfully saved. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
            return $this->redirect(['kj-achievement-master?id=' . $id]);
        }




        return $this->render('_svmasterums', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p, 'sem2' => $sem2, 'sem3' => $sem3, 'sem4' => $sem4,
                    'icno' => $icno, 'id' => $id, 'comment' => $comment
        ]);
    }

    public function actionSvPhd($id, $i = null) {
        $this->layout = "main-penyelia";

        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'status' => 1])->all();
        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'status' => 1])->all();
        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'status' => 1])->all();
        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'status' => 1])->all();
        $sem5 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 5, 'status' => 1])->all();
        $sem6 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 6, 'status' => 1])->all();
        $comment = new \app\models\cbelajar\DeanComment();
        $model = TblLkk::find()->where(['status_borang' => "Complete", 'reportID' => $i])->one();
// var_dump($model);die;
//        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($icno);
        if ($comment->load(Yii::$app->request->post())) {
            $comment->status = 'DONE CHECKED';
            $comment->create_dt = date('Y-m-d H:i:s');
            if ($comment->status == 'DONE CHECKED') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
                $comment->icno = $id;
                $comment->parent_id = 1;
                $comment->app_by = $icno;
                $comment->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);
            }
            $comment->save(false);



//                $this->notifikasi($model->icno, "Progress Report have been successfully saved. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
            return $this->redirect(['kj-achievement-master?id=' . $id]);
        }




        return $this->render('_svphd', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p, 'sem2' => $sem2, 'sem3' => $sem3, 'sem4' => $sem4, 'sem5' => $sem5,
                    'sem6' => $sem6,
                    'icno' => $icno, 'id' => $id, 'comment' => $comment
        ]);
    }

    public function actionSvMaster($id, $i = null) {
        $this->layout = "main-penyelia";

        $icno = Yii::$app->user->getId();

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'status' => 2])->all();
        $sem2 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'status' => 2])->all();
        $sem3 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'status' => 2])->all();
        $sem4 = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'status' => 2])->all();

        $comment = new \app\models\cbelajar\DeanComment();
        $model = TblLkk::find()->where(['status_borang' => "Complete", 'reportID' => $i])->one();
// var_dump($model);die;
//        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($icno);
        if ($comment->load(Yii::$app->request->post())) {
            $comment->status = 'DONE CHECKED';
            $comment->create_dt = date('Y-m-d H:i:s');
            if ($comment->status == 'DONE CHECKED') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
                $comment->icno = $id;
                $comment->parent_id = 1;
                $comment->app_by = $icno;
                $comment->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);
            }
            $comment->save(false);



//                $this->notifikasi($model->icno, "Progress Report have been successfully saved. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
            return $this->redirect(['kj-achievement-master?id=' . $id]);
        }




        return $this->render('_svmaster', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'model' => $model, 'p' => $p, 'sem2' => $sem2, 'sem3' => $sem3, 'sem4' => $sem4,
                    'icno' => $icno, 'id' => $id, 'comment' => $comment
        ]);
    }

    protected function findCekSyarat($id) {
        return \app\models\cbelajar\LkkDean::findOne(['idsem' => $id]);
    }

    public function actionViewSemester($id) {

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 1, 'HighestEduLevelCd' => 20])->all();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $id]);
        $icno = $model->icno;
        $p = $this->findPengajian1($icno);
        $mod = $this->findCekSyarat($id);

        $kontrak = $this->findModel($id);

        if (Yii::$app->request->post()) {
            foreach ($sem as $dok) {
                $this->savekpi($kontrak->icno, $dok);
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-syarat', 'id' => $kontrak->reportID, 'ICNO' => $ICNO, 'takwim_id' => $kontrak->iklan_id]);
        }
        if ($kontrak->status_jfpiu == 'Dibawa Ke Mesyuarat' || $kontrak->status_jfpiu == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $kontrak->icno, 'parent_id' => $kontrak->reportID])->exists()) {
            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
        }
        return $this->render('_viewsem', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'icno' => $kontrak->icno,
                    'edit' => $edit,
                    'view' => $view,
                    'model' => $model, 'p' => $p, 'mod' => $mod,
        ]);
    }

    public function actionSemester2($id) {

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 2, 'HighestEduLevelCd' => 20])->all();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $id]);
        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($id);

        if (Yii::$app->request->post()) {
            foreach ($sem as $kpi) {
                $this->savekpi($id, $kontrak->icno, $kpi);
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-syarat', 'id' => $kontrak->reportID, 'ICNO' => $ICNO, 'takwim_id' => $kontrak->iklan_id]);
        }
        if ($kontrak->status_jfpiu == 'Dibawa Ke Mesyuarat' || $kontrak->status_jfpiu == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $kontrak->icno, 'parent_id' => $kontrak->reportID])->exists()) {
            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
        }
        return $this->render('sem2', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'icno' => $kontrak->icno,
                    'edit' => $edit,
                    'view' => $view,
                    'model' => $model, 'p' => $p
        ]);
    }

    public function actionSemester3($id) {

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 3, 'HighestEduLevelCd' => 20])->all();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $id]);
        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($id);

        if (Yii::$app->request->post()) {
            foreach ($sem as $kpi) {
                $this->savekpi($id, $kontrak->icno, $kpi);
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-syarat', 'id' => $kontrak->reportID, 'ICNO' => $ICNO, 'takwim_id' => $kontrak->iklan_id]);
        }
        if ($kontrak->status_jfpiu == 'Dibawa Ke Mesyuarat' || $kontrak->status_jfpiu == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $kontrak->icno, 'parent_id' => $kontrak->reportID])->exists()) {
            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
        }
        return $this->render('sem3', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'icno' => $kontrak->icno,
                    'edit' => $edit,
                    'view' => $view,
                    'model' => $model, 'p' => $p
        ]);
    }

    public function actionSemester4($id) {

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 4, 'HighestEduLevelCd' => 20])->all();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $id]);
        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($id);

        if (Yii::$app->request->post()) {
            foreach ($sem as $kpi) {
                $this->savekpi($id, $kontrak->icno, $kpi);
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-syarat', 'id' => $kontrak->reportID, 'ICNO' => $ICNO, 'takwim_id' => $kontrak->iklan_id]);
        }
        if ($kontrak->status_jfpiu == 'Dibawa Ke Mesyuarat' || $kontrak->status_jfpiu == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $kontrak->icno, 'parent_id' => $kontrak->reportID])->exists()) {
            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
        }
        return $this->render('sem4', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'icno' => $kontrak->icno,
                    'edit' => $edit,
                    'view' => $view,
                    'model' => $model, 'p' => $p
        ]);
    }

    public function actionSemester5($id) {

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 5, 'HighestEduLevelCd' => 1])->all();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $id]);
        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($id);

        if (Yii::$app->request->post()) {
            foreach ($sem as $kpi) {
                $this->savekpi($id, $kontrak->icno, $kpi);
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-syarat', 'id' => $kontrak->reportID, 'ICNO' => $ICNO, 'takwim_id' => $kontrak->iklan_id]);
        }
        if ($kontrak->status_jfpiu == 'Dibawa Ke Mesyuarat' || $kontrak->status_jfpiu == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $kontrak->icno, 'parent_id' => $kontrak->reportID])->exists()) {
            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
        }
        return $this->render('sem5', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'icno' => $kontrak->icno,
                    'edit' => $edit,
                    'view' => $view,
                    'model' => $model, 'p' => $p
        ]);
    }

    public function actionSemester6($id) {

        $sem = \app\models\cbelajar\CbLkkDean::find()->where(['sem' => 6, 'HighestEduLevelCd' => 1])->all();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $id]);
        $icno = $model->icno;
        $p = $this->findPengajian1($icno);

        $kontrak = $this->findModel($id);

        if (Yii::$app->request->post()) {
            foreach ($sem as $kpi) {
                $this->savekpi($id, $kontrak->icno, $kpi);
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-sem1', 'id' => $kontrak->reportID]);
        }
        if ($kontrak->status_jfpiu == 'Dibawa Ke Mesyuarat' || $kontrak->status_jfpiu == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if (\app\models\cbelajar\LkkDean::find()->where(['icno' => $kontrak->icno, 'parent_id' => $kontrak->reportID])->exists()) {
            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
        }
        return $this->render('sem6', [
                    'kontrak' => $kontrak,
                    'sem' => $sem,
                    'icno' => $kontrak->icno,
                    'edit' => $edit,
                    'view' => $view,
                    'model' => $model, 'p' => $p
        ]);
    }

    protected function savekpi($id, $icno, $kpi) {

        $mod = \app\models\cbelajar\LkkDean::find()->where([ 'icno' => $id, 'idsem' => $kpi->id])->one();
        //               $kontrak = $this->findModel($id);
        //       $model = $this->findModelbyID($id);
        $p = $this->findPengajian1($id);

        if ($mod) {

            $mod->result = Yii::$app->request->post($kpi->id . 'result');
            $mod->comment = Yii::$app->request->post($kpi->id);
            $mod->icno = $id;
            $mod->tahun = date("Y");
            $mod->created_dt = new \yii\db\Expression('NOW()');
            $mod->save(false);
        } else {
            $mod = new \app\models\cbelajar\LkkDean();
            $mod->result = Yii::$app->request->post($kpi->id . 'result');
            $mod->comment = Yii::$app->request->post($kpi->id);

            $mod->icno = $id;
            $mod->tahun = date("Y");
            $mod->created_dt = new \yii\db\Expression('NOW()');

            $mod->save(false);
        }
    }

    // MAIL

    public function Email($status, $name, $email) {

        $icno = Yii::$app->user->getId();

        $biodata = $this->findBiodata1($icno);

//      $email = 'norfazleenawana@ums.edu.my';
//        if ($status == '1') {
////        $content = '<p>Salam sejahtera, <br/><br/> Merujuk kepada perkara di atas. <br>'
////            . 'Adalah dimaklumkan bahawa Unit Pengembangan Profesionalisme, Bahagian Sumber Manusia, '
////            . 'Universiti Malaysia Sabah'
////            . ' kini telah menggunakan sistem Laporan Kemajuan Pengajian secara atas talian.<br> 
////                Sehubungan itu, adalah dimaklumkan bahawa pihak tuan/puan adalah dipohon untuk <b>
////                membuat penilaian kemajuan pengajian pelajar seliaan tuan/puan</b> iaitu '.$biodata->CONm
////            . ' Sehubungan itu, adalah dimaklumkan bahawa pihak tuan/puan adalah dipohon untuk <b>'
////            . ' secara atas talian melalui sistem LKP dan maklumat log in adalah seperti berikut:<br><br> '
////            . ' <b> Penyelia Luar (Bukan Staf UMS)</b> <br> '
////            . '1. Log Masuk HRv4:'
////            . '2. Username: <b>emel</b><br> Password: <b>emel</b><br>'
////            . '<br> <b>Penyelia UMS:</b> Login Seperti Biasa di HRv4'
////                
////         ;
//        
// } 



        try {
            Yii::$app->mailer3->compose('peringatan_sv', ['biodata' => $biodata])
                    ->setFrom('pengajianlanjutan@ums.edu.my')
                    ->setSubject('STUDENT PROGRESS REPORT - UNIVERSITI MALAYSIA SABAH')
                    ->setTo($email)
                    ->setCc(['norfazleenawana@ums.edu.my','anizah@ums.edu.my'])
//                    ->setHtmlBody($content)
                    ->send();

            $mail_status = 1;
        } catch (Exception $e) {
            $mail_status = 0;
        }

        $model = new \app\models\cbelajar\TblEmail();
        $model->from_name = 'LKP';
        $model->from_email = 'pengajianlanjutan@ums.edu.my';
        $model->to_name = $name;
        $model->to_email = $email;
        $model->subject = 'SEMAKAN LAPORAN KEMAJUAN PENGAJIAN PELAJAR';
//        $model->message = $content;
        $model->success = $mail_status;
        $model->date_published = date('Y-m-d H:i:s');
        $model->save();
    }

    public function GridRekodEmel() {
        $data = new ActiveDataProvider([
            'query' => TblEmail::find()->where(['success' => 1])->orderBy(['date_published' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionRekodEmel() {
        $icno = Yii::$app->user->getId();

        $emel = $this->GridRekodEmel();



        if (\app\models\cbelajar\TblAccess::find()->where(['icno' => $icno, 'level' => 2])->exists()) {
            return $this->render('_rekod_emel', [
                        'icno' => $icno,
                        'emel' => $emel
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['/cutibelajar/index']);
        }
    }

    public function Notifiemail($id, $name, $email) {

        $icno = Yii::$app->user->getId();
        $model = $this->findLkk($id);

//            $biodata = $this->findBiodata1($icno);
//      $email = 'norfazleenawana@ums.edu.my';
//        if ($status == '2') {
//     $content = '<p>Salam sejahtera, <br/><br/> Merujuk kepada perkara di atas. <br>'
//           . 'Please verify your progress report ASAP';
//        
// } 



        try {
            Yii::$app->mailer3->compose('submit_rpt', ['model' => $model])
                    ->setFrom('pengajianlanjutan@ums.edu.my')
                    ->setSubject('LKP- PLEASE VERIFY YOUR STUDENT PROGRESS REPORT')
                    ->setTo($email)
                    ->setCc(['norfazleenawana@ums.edu.my', 'anizah@ums.edu.my'])
//                    ->setHtmlBody($content)
                    ->send();

            $mail_status = 1;
        } catch (Exception $e) {
            $mail_status = 0;
        }

        $model = new \app\models\cbelajar\TblEmail();
        $model->from_name = 'VERIFY-LKP';
        $model->from_email = 'pengajianlanjutan@ums.edu.my';
        $model->to_name = $name;
        $model->to_email = $email;
        $model->subject = 'PLEASE VERIFY YOUR PROGRESS REPORT';
//        $model->message = $content;
        $model->success = $mail_status;
        $model->date_published = date('Y-m-d H:i:s');
        $model->save();
        return 0;
    }

    public function Notifiemaillapor($status, $name, $email) {

        $icno = Yii::$app->user->getId();

//            $biodata = $this->findBiodata1($icno);
//      $email = 'norfazleenawana@ums.edu.my';
//        if ($status == '2') {
//     $content = '<p>Salam sejahtera, <br/><br/> Merujuk kepada perkara di atas. <br>'
//           . 'Please verify your progress report ASAP';
//        
// } 



        try {
            Yii::$app->mailer3->compose('submit_lapordiri')
                    ->setFrom('pengajianlanjutan@ums.edu.my')
                    ->setSubject('LAPOR DIRI- SILA SAHKAN BORANG LAPOR DIRI ANDA')
                    ->setTo($email)
                    ->setCc(['norfazleenawana@ums.edu.my', 'goraidj.john@ums.edu.my'])
//                    ->setHtmlBody($content)
                    ->send();

            $mail_status = 1;
        } catch (Exception $e) {
            $mail_status = 0;
        }

        $model = new \app\models\cbelajar\TblEmail();
        $model->from_name = 'PENGESAHAN - LAPOR DIRI KEMBALI BERTUGAS';
        $model->from_email = 'pengajianlanjutan@ums.edu.my';
        $model->to_name = $name;
        $model->to_email = $email;
        $model->subject = 'SILA SAHKAN BORANG LAPOR DIRI ';
//        $model->message = $content;
        $model->success = $mail_status;
        $model->date_published = date('Y-m-d H:i:s');
        $model->save();
        return 0;
    }

    protected function findBelajar($id) {
        if (($model = \app\models\cbelajar\TblPengajian::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionNotifilapor($id) {
        $model = $this->findBelajar($id);



        $this->NotifiBalikLapordiri($id, $model->kakitangan->CONm, $model->kakitangan->COEmail);
//        $this->notifikasi($id, "Adalah Dimaklumkan bahawa TARIKH AKHIR PENGHANTARAN LAPORAN KEMAJUAN KURSUS (LKK) tuan/puan adalah pada $n_date; Tuan/puan adalah dipelawa mengemukakan LKK  <b>DALAM KADAR SEGERA</b>; "
//                            , ['lkk/senarailkk'], ['class'=>'btn btn-primary btn-sm']);

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' =>
            'Peringatan Lapor Diri Kembali Bertugas Berjaya Dihantar']);
        return $this->redirect('../cbadmin/search-cb');
    }

    public function NotifiBalikLapordiri($id, $name, $email) {

        $icno = Yii::$app->user->getId();

        $model = $this->findBelajar($id);

        try {
            Yii::$app->mailer3->compose('remind_lapordiri', ['model' => $model])
                    ->setFrom('pengajianlanjutan@ums.edu.my')
                    ->setSubject('LAPOR DIRI KEMBALI BERTUGAS KE UNIVERSITI MALAYSIA SABAH (UMS)')
                    ->setTo($email)
                    ->setCc(['norfazleenawana@ums.edu.my', 'goraidj.john@ums.edu.my'])
                    //goraidj.john@ums.edu.my
//                    ->setHtmlBody($content)
                    ->send();

            $mail_status = 1;
        } catch (Exception $e) {
            $mail_status = 0;
        }

        $model = new \app\models\cbelajar\TblEmail();
        $model->from_name = 'PERINGATAN - LAPOR DIRI KEMBALI BERTUGAS';
        $model->from_email = 'pengajianlanjutan@ums.edu.my';
        $model->to_name = $name;
        $model->to_email = $email;
        $model->subject = 'TAMAT CUTI BELAJAR ';
//        $model->message = $content;
        $model->success = $mail_status;
        $model->date_published = date('Y-m-d H:i:s');
        $model->save();
        return 0;
    }

    public function actionNotifilaporwajib($id) {
        $model = $this->findBelajar($id);



        $this->NotifiBalikLapordiriWajib($id, $model->kakitangan->CONm, $model->kakitangan->COEmail);
//        $this->notifikasi($id, "Adalah Dimaklumkan bahawa TARIKH AKHIR PENGHANTARAN LAPORAN KEMAJUAN KURSUS (LKK) tuan/puan adalah pada $n_date; Tuan/puan adalah dipelawa mengemukakan LKK  <b>DALAM KADAR SEGERA</b>; "
//                            , ['lkk/senarailkk'], ['class'=>'btn btn-primary btn-sm']);

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' =>
            'Peringatan Lapor Diri Kembali Bertugas Berjaya Dihantar']);
        return $this->redirect('../cbadmin/search-cb');
    }

    public function NotifiBalikLapordiriWajib($id, $name, $email) {

        $icno = Yii::$app->user->getId();

        $model = $this->findBelajar($id);

        try {
            Yii::$app->mailer3->compose('remind_lapordiriwajib', ['model' => $model])
                    ->setFrom('pengajianlanjutan@ums.edu.my')
                    ->setSubject('LAPOR DIRI KEMBALI BERTUGAS KE UNIVERSITI MALAYSIA SABAH (UMS)')
                    ->setTo($email)
                    ->setCc(['norfazleenawana@ums.edu.my'])
                    //goraidj.john@ums.edu.my
//                    ->setHtmlBody($content)
                    ->send();

            $mail_status = 1;
        } catch (Exception $e) {
            $mail_status = 0;
        }

        $model = new \app\models\cbelajar\TblEmail();
        $model->from_name = 'PERINGATAN - LAPOR DIRI KEMBALI BERTUGAS';
        $model->from_email = 'pengajianlanjutan@ums.edu.my';
        $model->to_name = $name;
        $model->to_email = $email;
        $model->subject = 'TAMAT CUTI BELAJAR ';
//        $model->message = $content;
        $model->success = $mail_status;
        $model->date_published = date('Y-m-d H:i:s');
        $model->save();
        return 0;
    }

    public function actionNotifilaporbiasa($id) {
        $model = $this->findBelajar($id);



        $this->NotifiBalikLapordiriBiasa($id, $model->kakitangan->CONm, $model->kakitangan->COEmail);
//        $this->notifikasi($id, "Adalah Dimaklumkan bahawa TARIKH AKHIR PENGHANTARAN LAPORAN KEMAJUAN KURSUS (LKK) tuan/puan adalah pada $n_date; Tuan/puan adalah dipelawa mengemukakan LKK  <b>DALAM KADAR SEGERA</b>; "
//                            , ['lkk/senarailkk'], ['class'=>'btn btn-primary btn-sm']);

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' =>
            'Peringatan Lapor Diri Kembali Bertugas Berjaya Dihantar']);
        return $this->redirect('../cbadmin/search-cb');
    }

    public function NotifiBalikLapordiriBiasa($id, $name, $email) {

        $icno = Yii::$app->user->getId();

        $model = $this->findBelajar($id);

        try {
            Yii::$app->mailer3->compose('remind_laporbiasa', ['model' => $model])
                    ->setFrom('pengajianlanjutan@ums.edu.my')
                    ->setSubject('LAPOR DIRI KEMBALI BERTUGAS KE UNIVERSITI MALAYSIA SABAH (UMS)')
                    ->setTo($email)
                    ->setCc(['norfazleenawana@ums.edu.my'])
                    //goraidj.john@ums.edu.my
//                    ->setHtmlBody($content)
                    ->send();

            $mail_status = 1;
        } catch (Exception $e) {
            $mail_status = 0;
        }

        $model = new \app\models\cbelajar\TblEmail();
        $model->from_name = 'PERINGATAN - LAPOR DIRI KEMBALI BERTUGAS';
        $model->from_email = 'pengajianlanjutan@ums.edu.my';
        $model->to_name = $name;
        $model->to_email = $email;
        $model->subject = 'TAMAT CUTI BELAJAR ';
//        $model->message = $content;
        $model->success = $mail_status;
        $model->date_published = date('Y-m-d H:i:s');
        $model->save();
        return 0;
    }

    public function actionNotifistaf($id) {
        $model = $this->findLkk($id);

        if ($model->agree == '2') {

            $this->Notifiemail($model->reportID, $model->kakitangan->CONm, $model->kakitangan->COEmail);
//        $this->notifikasi($id, "Adalah Dimaklumkan bahawa TARIKH AKHIR PENGHANTARAN LAPORAN KEMAJUAN KURSUS (LKK) tuan/puan adalah pada $n_date; Tuan/puan adalah dipelawa mengemukakan LKK  <b>DALAM KADAR SEGERA</b>; "
//                            , ['lkk/senarailkk'], ['class'=>'btn btn-primary btn-sm']);
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Peringatan LKP Berjaya Dihantar']);
        return $this->redirect('senaraisemakan');
    }

    public function actionNotifistaflapor($id) {
        $model = $this->findLapor($id);

        if ($model->agree == NULL) {

            $this->Notifiemaillapor($model->laporID, $model->kakitangan->CONm, $model->kakitangan->COEmail);
//        $this->notifikasi($id, "Adalah Dimaklumkan bahawa TARIKH AKHIR PENGHANTARAN LAPORAN KEMAJUAN KURSUS (LKK) tuan/puan adalah pada $n_date; Tuan/puan adalah dipelawa mengemukakan LKK  <b>DALAM KADAR SEGERA</b>; "
//                            , ['lkk/senarailkk'], ['class'=>'btn btn-primary btn-sm']);
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Peringatan Pengesahan Lapordiri Berjaya Dihantar']);
        return $this->redirect('../cbadmin/senaraitindakanlapor');
    }

    public function actionNotifistafbulanan($my = NULL, $id) {
        $model = $this->findLkk($id);
        $my = date_format(date_create($my), 'Y-m');

        if ($model->agree == '2' && $model->kakitangan->COEmail) {

            $this->Notifiemailbulanan($model->reportID, $model->kakitangan->CONm, $model->kakitangan->COEmail);
//        $this->notifikasi($id, "Adalah Dimaklumkan bahawa TARIKH AKHIR PENGHANTARAN LAPORAN KEMAJUAN KURSUS (LKK) tuan/puan adalah pada $n_date; Tuan/puan adalah dipelawa mengemukakan LKK  <b>DALAM KADAR SEGERA</b>; "
//                            , ['lkk/senarailkk'], ['class'=>'btn btn-primary btn-sm']);
        } else {
            $this->Notifiemailbulanan($model->reportID, $model->kakitangan->CONm, $model->kakitangan->COEmail2);
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Peringatan LKP Berjaya Dihantar']);
        return $this->redirect('/staff/web/cbadmin/lkk-report?my=' . $my);
    }

    public function Notifiemailbulanan($id, $name, $email) {
        $model = $this->findLkk($id);

        $icno = Yii::$app->user->getId();
        try {
            Yii::$app->mailer3->compose('submit_rpt', ['model' => $model])
                    ->setFrom('pengajianlanjutan@ums.edu.my')
                    ->setSubject('LKP- PLEASE SUBMIT YOUR PROGRESS REPORT')
                    ->setTo($email)
                    ->setCc(['norfazleenawana@ums.edu.my', 'anizah@ums.edu.my'])
//                    ->setHtmlBody($content)
                    ->send();

            $mail_status = 1;
        } catch (Exception $e) {
            $mail_status = 0;
        }

        $model = new \app\models\cbelajar\TblEmail();
        $model->from_name = 'LKP SUBMISSION';
        $model->from_email = 'pengajianlanjutan@ums.edu.my';
        $model->to_name = $name;
        $model->to_email = $email;
        $model->subject = 'PLEASE SUBMIT YOUR PROGRESS REPORT';
//        $model->message = $content;
        $model->success = $mail_status;
        $model->date_published = date('Y-m-d H:i:s');
        $model->save();
        return 0;
    }

    public function Notifiemailsv($status, $name, $email) {

//                 $icno=Yii::$app->user->getId();
        $sv = TblPenyelia::find()->where(['emel'=>$email])->orderBy(['staff_icno'=>SORT_DESC])->one();
        $lkk = \app\models\cbelajar\TblPengajian::find()->where(['emel_penyelia' => $email])->one();
//        $lkk = \app\models\cbelajar\LkkTblPenyelia::find()->where(['emel'])
//      $email = 'norfazleenawana@ums.edu.my';
//        if ($status == '2') {
//     $content = '<p>Salam sejahtera, <br/><br/> Merujuk kepada perkara di atas. <br>'
//           . 'Please verify your progress report ASAP';
//        
// } 
        try {
            Yii::$app->mailer3->compose('review_std_rpt', ['sv' => $sv])
                    ->setFrom('pengajianlanjutan@ums.edu.my')
                    ->setSubject('LKP UNIVERSITI MALAYSIA SABAH- PLEASE VERIFY YOUR STUDENT PROGRESS REPORT')
                    ->setTo($email)
                    ->setCc(['norfazleenawana@ums.edu.my', 'anizah@ums.edu.my'])
//                    ->setHtmlBody($content)
                    ->send();
            $mail_status = 1;
        } catch (Exception $e) {
            $mail_status = 0;
        }

        $model = new \app\models\cbelajar\TblEmail();
        $model->from_name = 'VERIFY STUDENT-LKP';
        $model->from_email = 'pengajianlanjutan@ums.edu.my';
        $model->to_name = $name;
        $model->to_email = $email;
        $model->subject = 'PLEASE VERIFY YOUR PROGRESS REPORT';
//        $model->message = $content;
        $model->success = $mail_status;
        $model->date_published = date('Y-m-d H:i:s');
        $model->save();
        return 0;
    }

    public function actionNotifisv($id) {
        $model = $this->findLkk($id);
        $sv = TblPenyelia::find()->where(['reportId'=>$id])->one();
        if ($model->status_r == 'NOT YET') {

            $this->Notifiemailsv($model->status_r, $sv->nama, $sv->emel);
//        $this->notifikasi($id, "Adalah Dimaklumkan bahawa TARIKH AKHIR PENGHANTARAN LAPORAN KEMAJUAN KURSUS (LKK) tuan/puan adalah pada $n_date; Tuan/puan adalah dipelawa mengemukakan LKK  <b>DALAM KADAR SEGERA</b>; "
//                            , ['lkk/senarailkk'], ['class'=>'btn btn-primary btn-sm']);
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Peringatan LKP Berjaya Dihantar']);
        return $this->redirect('senaraisemakan');
    }

    protected function pendingtask($icno, $id) {
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }
    
   

}
