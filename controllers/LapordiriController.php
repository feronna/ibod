<?php

namespace app\controllers;

use app\models\cbelajar\TblLapordiri;
use app\models\cbelajar\TblPengajian;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\hronline\Tblprcobiodata;
use app\models\cbelajar\TblUrusMesyuarat;
use app\models\Notification;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use kartik\mpdf\Pdf;
use tebazil\runner\ConsoleCommandRunner;
use app\models\hronline\Department;
use Yii;

class LapordiriController extends \yii\web\Controller {

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
                'only' => [ 'borang', 'borang-belum-selesai', 'tuntut-hpg', 'tuntut-tesis', 'tuntut-akhir',
                    'belum-selesai', 'pengesahan-belum-selesai', 'perjawatan', 'pengesahan', 'view-tuntutan-akhir',
                    'view-tuntutan-tesis', 'kgt', 'lihat-permohonan', 'senaraitindakan','tindakan-kj-selesai','tindakan-kj'
                ],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),
                    [
                        'actions' => ['borang', 'borang-belum-selesai', 'tuntut-hpg',
                            'tuntut-tesis', 'tuntut-akhir', 'pengesahan', 'belum-selesai',
                            'pengesahan-belum-selesai', 'perjawatan', 'view-tuntutan-akhir',
                            'view-tuntutan-akhir', 'kgt', 'lihat-permohonan', 'senaraitindakan','tindakan-kj-selesai','tindakan-kj'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action) {

                    $icno = Yii::$app->user->getId();
                    if ($icno) {

                        if ((Yii::$app->user->identity->statLantikan == "1" && Yii::$app->user->identity->jawatan->job_category == "1") ||
                                (Yii::$app->user->identity->statLantikan == "2" && Yii::$app->user->identity->jawatan->job_category == "1") ||
                                (Yii::$app->user->identity->statLantikan == "1" && Yii::$app->user->identity->jawatan->job_category == "2") ||
                              (Yii::$app->user->identity->statLantikan=='3' && Yii::$app->user->identity->jawatan->job_category =='1') ||
                                 (Yii::$app->user->identity->statLantikan=='3' && Yii::$app->user->identity->jawatan->job_category == '2')) {
                            return true;
                        } else {
                            return false;
                        }
                    }
//                             if((Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jobCategory == "1") 
//                           || (Yii::$app->user->identity->statLantikan == "2"  && Yii::$app->user->identity->jobCategory == "1"))
//                          {
//                             return TRUE;
//                           }
//                           
                    if (in_array(Yii::$app->user->getId(), ['950829125446', '860130125080', '891103125554', '870818495847', '840929125614'])) {
                        return TRUE;
                    }

                    return FALSE;
                },
                    ],
                    [
                        'actions' => ['senarai-borang', 'perjawatan', 'view-tuntutan-akhir', 'view-tuntutan-tesis', 'kgt'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action) {


//                            if((Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jawatan->job_category == "1") || 
//                               (Yii::$app->user->identity->statLantikan == "2"  && Yii::$app->user->identity->jawatan->job_category == "1") ||
//                               (Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jawatan->job_category == "2"))
//                            {
//                                return TRUE;
//                            }
//                           
                    if (in_array(Yii::$app->user->getId(), ['891103125554', '950829125446','840929125614','870818495847'])) {
                        return TRUE;
                    }

                    return FALSE;
                },
                    ],
                ],
            ],
        ];
    }

    protected function ICNO() {

        return \Yii::$app->user->identity->ICNO;
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

    public function actionIndex() {

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);


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
            return $this->render('/cutibelajar/index');
        }
        $model = new TblPermohonan();
    }

    protected function findStudy($id) {
        return \app\models\cbelajar\TblPengajian::find()->where(['icno' => $id, 'HighestEduLevelCd' => [1, 202, 20]])
                ->orderBy(['tarikh_mula'=> SORT_DESC])->one();
    }

    public function actionPengesahan($i) {
        $icno = Yii::$app->user->getId();

        $b = $this->findStudy($icno);
        $model = new TblLapordiri();
        $model->icno = $icno;
//        $pengajian = $this->findPengajian($icno);
        $biodata = $this->findBiodata1($icno);
//        $pengajian2 = \app\models\cbelajar\TblPengajian::find()->where(['icno'=>$icno,  'idBorang'=>1,'status'=>1 ])->one()?  TblPengajian::find()->where(['icno'=>$icno,  'idBorang'=>1, 'status'=>1])->one(): new TblPengajian();
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);

        $model = TblLapordiri::findOne(['icno' => $icno, 'status_borang' => "Selesai Permohonan", 'laporID' => $i]);
        $akhir = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 37, 'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();
        $hpg = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 30, 'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();
        $tesis = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 35, 'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();
//          $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $stu = TblPengajian::find()->where(['icno' => $icno, 'laporID' => $i])->orderBy(['tarikh_mula' => SORT_DESC])->one();
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
//        $model->status_semakan = 'Tunggu Semakan';
        if ($model->load(Yii::$app->request->post())) {
            $model->agree = 1;
            $model->tarikh_mohon = date('Y-m-d H:i:s');
            $model->save(false);
            $this->pendingtask($icnopetindak1, 17);

            $this->notifikasi($icnopetindak1, "Permohonan Lapor Diri Tamat Tempoh Pengajian Lanjutan menunggu tindakan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['lapordiri/senaraitindakan'], ['class' => 'btn btn-primary btn-sm']));
            $this->notifikasi($model->icno, "Permohonan Lapor Diri Tamat Tempoh Pengajian Lanjutan  anda telah dihantar untuk tindakan " . $petindak1 . " " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Dihantar', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
            return $this->redirect(['pengesahan?i=' . $model->laporID]);
        }
        if ($model->agree == '1') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "2" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "2") || ($model->kakitangan->statLantikan == "3" && $model->kakitangan->jawatan->job_category == "2")) {
            if (TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->exists()) {

                return $this->render('_pengesahan', [
//              'iklan' => $iklan,
                            'model' => $model,
                            'b' => $b,
//                'models'=>$models,
                            'biodata' => $biodata,
                            'img' => $biodata->img,
                            'akhir' => $akhir,
                            'tesis' => $tesis,
                            'hpg' => $hpg,
                            'view' => $view,
                            'edit' => $edit,
                            'stu' => $stu
                ]);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    protected function pendingtask($icno, $id) {
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }

    public function actionPengesahanBelumSelesai($i) {
        $icno = Yii::$app->user->getId();

        $b = $this->findStudy($icno);
        $model = new TblLapordiri();
        $model->icno = $icno;
        $biodata = $this->findBiodata1($icno);
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $model = TblLapordiri::findOne(['icno' => $icno, 'status_borang' => "Selesai Permohonan", 'laporID' => $i]);
        $akhir = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 36, 'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();
        $stu = TblPengajian::find()->where(['laporID' => $i])->one();
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
        $model->status_borang = "Selesai Permohonan";
//        $model->status_semakan = 'Tunggu Semakan';
        if ($model->load(Yii::$app->request->post())) {
            $model->agree = 1;
            $model->tarikh_mohon = date('Y-m-d H:i:s');
            $model->save(false);
            $this->pendingtask($icnopetindak1, 1);

            $this->notifikasi($icnopetindak1, "Permohonan Lapor Diri Tamat Tempoh Pengajian Lanjutan menunggu tindakan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['lapordiri/senaraitindakan'], ['class' => 'btn btn-primary btn-sm']));
            $this->notifikasi($model->icno, "Permohonan Lapor Diri Tamat Tempoh Pengajian Lanjutan  anda telah dihantar untuk tindakan " . $petindak1 . " " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Dihantar', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
            return $this->redirect(['pengesahan-belum-selesai?i=' . $model->laporID]);
        }
        if ($model->agree == '1') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "2" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "2") || ($model->kakitangan->statLantikan == "3" && $model->kakitangan->jawatan->job_category == "2")) {
            if (TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->exists()) {

                return $this->render('_pengesahanb', [
//              'iklan' => $iklan,
                            'model' => $model,
                            'b' => $b,
//                'models'=>$models,
                            'biodata' => $biodata,
                            'img' => $biodata->img,
                            'akhir' => $akhir,
                            'view' => $view,
                            'edit' => $edit, 'stu' => $stu,
                            'i' => $i
                ]);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    public function actionBorang() {

        $icno = Yii::$app->user->getId();
        $b = $this->findStudy($icno);
        $model = new TblLapordiri();
        $model->icno = $icno;
        $kpm = \app\models\cbelajar\TblDokumen::find()->where(['jenisDokumen' => 3])->all();
        $tesis = \app\models\cbelajar\TblDokumen::find()->where(['jenisDokumen' => 5])->all();
        $hpg = \app\models\cbelajar\TblDokumen::find()->where(['jenisDokumen' => 6])->all();
        $lapor = \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan", 'status_a' => "DALAM PROSES"])->one();

        $biodata = $this->findBiodata1($icno);
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
        $file3 = UploadedFile::getInstance($model, 'file3');
        $file4 = UploadedFile::getInstance($model, 'file4');
        $file5 = UploadedFile::getInstance($model, 'file5');
        $file6 = UploadedFile::getInstance($model, 'file6');

        $checkApplication = \app\models\cbelajar\TblLapordiri::find()->where(['status_borang' => "Selesai Permohonan", 'icno' => $icno, 'status_a' => "DALAM PROSES"]);
        $checkApplication2 = \app\models\cbelajar\TblLapordiri::find()->where(['status_borang' => "Selesai Permohonan", 'icno' => $icno, 'agree' => 2]);

        $stu = TblPengajian::find(['icno' => $icno, 'status' => 1])->one() ? TblPengajian::find()->where(['icno' => $icno, 'status' => 1])->one() : new TblPengajian();

        if ($checkApplication->exists()) {
            if ($lapor->agree == 1) {
                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error',
                    'msg' => 'Permohonan sedang diproses']);
                return $this->redirect(['pengesahan', 'i' => $lapor->laporID]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda belum membuat pengesahan']);
                return $this->redirect(['lihat-permohonan', 'i' => $lapor->laporID]);
            }
        }


        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lapordiri');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = '';
        }


        if ($file2) {
            $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'lapordiri');
            $filepath2 = $fileapi->file_name_hashcode;
        } else {
            $filepath2 = '';
        }

        if ($file3) {
            $fileapi = Yii::$app->FileManager->UploadFile($file3->name, $file3->tempName, '04', 'lapordiri');
            $filepath3 = $fileapi->file_name_hashcode;
        } else {
            $filepath3 = '';
        }

        if ($file4) {
            $fileapi = Yii::$app->FileManager->UploadFile($file4->name, $file4->tempName, '04', 'lapordiri');
            $filepath4 = $fileapi->file_name_hashcode;
        } else {
            $filepath4 = '';
        }

        if ($file5) {
            $fileapi = Yii::$app->FileManager->UploadFile($file5->name, $file5->tempName, '04', 'lapordiri');
            $filepath5 = $fileapi->file_name_hashcode;
        } else {
            $filepath5 = '';
        }
        if ($file6) {
            $fileapi = Yii::$app->FileManager->UploadFile($file6->name, $file6->tempName, '04', 'lapordiri');
            $filepath6 = $fileapi->file_name_hashcode;
        } else {
            $filepath6 = '';
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->icno;
            $model->status_pengajian;
            $model->dt_tesis;
            $model->writing;
            $model->correction;
            $model->dt_viva;
            $model->HighestEduLevelCd = $stu->HighestEduLevelCd;
            $model->dokumen = $filepath;
            $model->dokumen2 = $filepath2;
            $model->dokumen3 = $filepath3;
            $model->dokumen4 = $filepath4;
            $model->dokumen5 = $filepath5;
            $model->dokumen_6 = $filepath6;
            $model->tarikh_mohon = date('Y-m-d H:i:s');
            $model->status_borang = "Selesai Permohonan ";
            $model->status_a = "DALAM PROSES";
            $model->tahun = date("Y");


            $model->save(false);
            $stu->laporID = $model->laporID;

            $stu->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Status Pengajian Berjaya disimpan', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['pengesahan', 'i' => $model->laporID]); //
        }


        return $this->render('_borang', [

                    'model' => $model,
                    'b' => $b,
                    'biodata' => $biodata,
                    'img' => $biodata->img,
                    'kpm' => $kpm,
                    'tesis' => $tesis,
                    'hpg' => $hpg,
                    'lapor' => $lapor,
//            'pengajian'=>$pengajian
//                    'iklan' => $iklan,
        ]);
    }

//    public function actionPengesahanLaporDiri($i) {
//        $id = Yii::$app->user->getId();
//        $model = TblLapordiri::findOne(['laporID' => $i, 'status_borang' => "Selesai Permohonan"]);
//        $mpdf = new \Mpdf\Mpdf();
//        $pagecount = $mpdf->SetSourceFile('files/lapor.pdf');
//        for ($i = 1; $i <= $pagecount; $i++) {
//            $import_page = $mpdf->ImportPage($i);
//            $mpdf->UseTemplate($import_page);
//            if ($i == 1) { //page1
//                $mpdf->WriteHTML($this->renderPartial('view_ppuu', ['model' => $model]));
//            }
//            if ($i < $pagecount) {
//                $mpdf->AddPage();
//            }
//        }
//        $mpdf->Output();
//    }
      public function actionPengesahanLaporDiri($i)
        {   
          $css = file_get_contents('./css/ppuu.css');
            #cehck application
                $id = Yii::$app->user->getId();

        $model = TblLapordiri::findOne(['laporID' => $i, 'status_borang' => "Selesai Permohonan"]);
          //   $facility2 = Borang::find()->where(['icno' => $icno])->one();
            $content = $this->renderPartial('memo', ['model'=> $model]);
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
                'options' => ['title' => 'Pengesahan Lapor Diri'],
                // call mPDF methods on the fly
                  'marginTop' => 35,
    //             'marginBottom' => 35,
                'marginLeft' => 24,
                'marginRight' => 24,
                'methods' => [
                'SetHeader' => ['PENGESAHAN LAPOR DIRI'],
                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                'WriteHTML' => [$css, 1]
    //          'SetFooter' => [' {PAGENO}'],
                ]
            ]);
            // return the pdf output as per the destination setting
            return $pdf->render();
        }

    public function actionBorangBelumSelesai() {

        $icno = Yii::$app->user->getId();
        $b = $this->findStudy($icno);
        $model = new TblLapordiri();
        $model->icno = $icno;
        $lapor = \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan", 'status_a' => "DALAM PROSES"])->one();
        $biodata = $this->findBiodata1($icno);
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
        $file3 = UploadedFile::getInstance($model, 'file3');
        $file4 = UploadedFile::getInstance($model, 'file4');
        $file5 = UploadedFile::getInstance($model, 'file5');
        $file6 = UploadedFile::getInstance($model, 'file6');
        $stu = TblPengajian::find(['icno' => $icno, 'status' => 1])->one() ? TblPengajian::find()->where(['icno' => $icno, 'status' => 1])->one() : new TblPengajian();
        ;
        $checkApplication = TblLapordiri::find()->where(['status_borang' => "Selesai Permohonan", 'icno' => $icno, 'status_a' => "DALAM PROSES"]);
        if ($checkApplication->exists()) {
            if ($lapor->agree == 1) {
                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah dihantar']);
                return $this->redirect(['pengesahan-belum-selesai', 'i' => $lapor->laporID]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda belum membuat pengesahan']);
                return $this->redirect(['pengesahan-belum-selesai', 'i' => $lapor->laporID]);
            }
        }
//        if($checkApplication->exists()){
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
//            return $this->redirect(['lapordiri/pengesahan-belum-selesai', 'i'=>$lapor->laporID]);
//        }
//        else
//        {
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda belum membuat pengesahan']);
//            return $this->redirect(['lapordiri/pengesahan-belum-selesai', 'i'=>$lapor->laporID]);
//        }


        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lapordiri');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = '';
        }


        if ($file2) {
            $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'lapordiri');
            $filepath2 = $fileapi->file_name_hashcode;
        } else {
            $filepath2 = '';
        }

        if ($file3) {
            $fileapi = Yii::$app->FileManager->UploadFile($file3->name, $file3->tempName, '04', 'lapordiri');
            $filepath3 = $fileapi->file_name_hashcode;
        } else {
            $filepath3 = '';
        }

        if ($file4) {
            $fileapi = Yii::$app->FileManager->UploadFile($file4->name, $file4->tempName, '04', 'lapordiri');
            $filepath4 = $fileapi->file_name_hashcode;
        } else {
            $filepath4 = '';
        }

        if ($file5) {
            $fileapi = Yii::$app->FileManager->UploadFile($file5->name, $file5->tempName, '04', 'lapordiri');
            $filepath5 = $fileapi->file_name_hashcode;
        } else {
            $filepath5 = '';
        }
        if ($file6) {
            $fileapi = Yii::$app->FileManager->UploadFile($file6->name, $file6->tempName, '04', 'lapordiri');
            $filepath6 = $fileapi->file_name_hashcode;
        } else {
            $filepath6 = '';
        }

        if ($model->load(Yii::$app->request->post())) {
//               if($model->agree == 0)
//            {
//                Yii::$app->session->setFlash('alert', ['title' => 'Amaran !', 'type' => 'error', 'msg' => 'Sila tanda kotak semak permohonan.']);
//                return $this->redirect(['borang']);
//
//            }
//            else
//        
            $model->icno;
//            $model->iklan_id=$iklan->id;
            $model->status_pengajian;
            $model->dt_tesis;
            $model->writing;
            $model->correction;
            $model->dt_viva;
            $model->HighestEduLevelCd = $stu->HighestEduLevelCd;
            $model->dokumen = $filepath;
            $model->dokumen2 = $filepath2;
            $model->dokumen3 = $filepath3;
            $model->dokumen4 = $filepath4;
            $model->dokumen5 = $filepath5;
            $model->dokumen_6 = $filepath6;
            $model->status_borang = "Selesai Permohonan ";
            $model->status_a = "DALAM PROSES";
            $model->tahun = date("Y");
            $model->save(false);
            $stu->laporID = $model->laporID;
            $stu->save(false);




            Yii::$app->session->setFlash('alert', ['title' => 'Status Pengajian Berjaya Disimpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['belum-selesai', 'i' => $model->laporID]); //
        }

        return $this->render('_borangbselesai', [

                    'model' => $model,
                    'b' => $b,
                    'biodata' => $biodata,
                    'img' => $biodata->img,
                    'lapor' => $lapor,
//            'pengajian'=>$pengajian
//                    'iklan' => $iklan,
        ]);
    }

//public function actionBorangBelumSelesai(){
//          
//        $icno = Yii::$app->user->getId();  
//         $b = $this->findStudy($icno);
//        $model = new TblLapordiri();
//        $model->icno = $icno;  
//              $lapor = \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();
//            $biodata = $this->findBiodata1($icno);
//        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
//        $model->tarikh_mohon = date('Y-m-d H:i:s');
//        $file = UploadedFile::getInstance($model, 'file');
//        $file2 = UploadedFile::getInstance($model, 'file2');
//        $file3 = UploadedFile::getInstance($model, 'file3');
//        $file4 = UploadedFile::getInstance($model, 'file4');
//        $file5 = UploadedFile::getInstance($model, 'file5');
//        $file6 = UploadedFile::getInstance($model, 'file6');
//
////        $checkApplication = TblLanjutan::find()->where(['status_borang' => "Selesai Permohonan",'icno' => $icno, 'iklan_id'=>$iklan->id]);
////        if($checkApplication->exists()){
////            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
////            return $this->redirect(['lanjutancb/lihat-permohonan', 'id'=>$iklan->id]);
////        }
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
//            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
//            $petindak1='Ketua Jabatan';
//            $icnopetindak1= $model->app_by;
//        }
//
//          $model->status_jfpiu = 'Tunggu Perakuan';
//          $model->status_bsm = 'Tunggu Kelulusan';
//          
//          
//         if($file){
//                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lapordiri');
//                $filepath = $fileapi->file_name_hashcode;      
//        }
//        else{
//            $filepath = '';
//        }
//      
//              
//         if($file2){
//                $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'lapordiri');
//                $filepath2 = $fileapi->file_name_hashcode;      
//        }
//        else{
//            $filepath2 = '';
//        }
//             
//         if($file3){
//                $fileapi = Yii::$app->FileManager->UploadFile($file3->name, $file3->tempName, '04', 'lapordiri');
//                $filepath3 = $fileapi->file_name_hashcode;      
//        }
//        else{
//            $filepath3 = '';
//        }
//             
//         if($file4){
//                $fileapi = Yii::$app->FileManager->UploadFile($file4->name, $file4->tempName, '04', 'lapordiri');
//                $filepath4 = $fileapi->file_name_hashcode;      
//        }
//        else{
//            $filepath4 = '';
//        }
//             
//         if($file5){
//                $fileapi = Yii::$app->FileManager->UploadFile($file5->name, $file5->tempName, '04', 'lapordiri');
//                $filepath5 = $fileapi->file_name_hashcode;      
//        }
//        else{
//            $filepath5 = '';
//        }
//       if($file6){
//                $fileapi = Yii::$app->FileManager->UploadFile($file6->name, $file6->tempName, '04', 'lapordiri');
//                $filepath6 = $fileapi->file_name_hashcode;      
//        }
//        else{
//            $filepath6 = '';
//        }
//      
//         if ($model->load(Yii::$app->request->post()))
//         {
////               if($model->agree == 0)
////            {
////                Yii::$app->session->setFlash('alert', ['title' => 'Amaran !', 'type' => 'error', 'msg' => 'Sila tanda kotak semak permohonan.']);
////                return $this->redirect(['borang']);
////
////            }
////            else
////        
//            $model->icno;
////            $model->iklan_id=$iklan->id;
//            $model->status_pengajian;
//            $model->dt_tesis;
//            $model->writing;
//            $model->correction;
//            $model->dt_viva;
//            $model->HighestEduLevelCd = $b->HighestEduLevelCd;
//            $model->dokumen = $filepath;
//            $model->dokumen2 = $filepath2;
//            $model->dokumen3 = $filepath3;
//            $model->dokumen4 = $filepath4;
//            $model->dokumen5 = $filepath5;
//            $model->dokumen_6 = $filepath6;
//            $model->status_borang = "Selesai Permohonan ";
//            $model->save(false);
//            
//            
//                    $this->notifikasi($icnopetindak1, "Permohonan Lapor Diri Tamat Tempoh Pengajian Lanjutan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/menunggu'], ['class'=>'btn btn-primary btn-sm']));
//                    $this->notifikasi($model->icno, "Permohonan Lapor Diri Tamat Tempoh Pengajian Lanjutan  anda telah dihantar untuk tindakan ".$petindak1. " ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
//
//                    Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Dihantar', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
//                     return $this->redirect(['lihat-permohonan', 'i'=>$model->laporID]);//
//        
//                }
//          
//         
//    
//        return $this->render('_borangbselesai', [
//
//                    'model' => $model,
//            'b'=>$b,
//            'biodata'=>$biodata,
//            'img'=> $biodata->img,
//          'lapor'=>$lapor,
////            'pengajian'=>$pengajian
////                    'iklan' => $iklan,
//                 
//          
//                   
//        ]);
//}
    protected function savekpi($id, $kpi) {

        $id = Yii::$app->user->getId();

//              var_dump($kpi);die;

        $mod = \app\models\cbelajar\TblFilePemohon::find()->
                        where([ 'uploaded_by' => $id, 'dokumenCd' => $kpi->dokumenCd])->one();
        //               $kontrak = $this->findModel($id);
        //       $model = $this->findModelbyID($id);

        if ($mod) {
            $mod->nama_dokumen = Yii::$app->request->post($kpi->dokumenCd . 'nama_dokumen');
            $mod->uploaded_by = Yii::$app->request->post($kpi->dokumenCd . 'uploaded_by');
            $mod->tahun = date("Y");
            $mod->created_dt = new \yii\db\Expression('NOW()');
            $mod->save(false);
        } else {


            $mod = new \app\models\cbelajar\TblFilePemohon();


            $mod->nama_dokumen = Yii::$app->request->post($kpi->id . 'nama_dokumen');
            $mod->uploaded_by = $id;
            $mod->tahun = date("Y");
            $mod->created_dt = new \yii\db\Expression('NOW()');
            $mod->save(false);
        }
    }

    protected function findLapor($id) {
        return \app\models\cbelajar\TblLapordiri::findOne(['laporID' => $id]);
    }

    protected function findPengajian2($id) {
        return \app\models\cbelajar\TblPengajian::findOne(['id' => $id, 'status' => 1]);
    }

    protected function findStatus($id) {
        return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
    }

    protected function findBelajar($id) {
        return TblPengajian::findOne(['icno' => $id, 'status' => 1]);
    }

    protected function findBelanja($id) {
        return \app\models\cbelajar\TblBiasiswa::findOne(['icno' => $id, 'status' => 1]);
    }

    protected function findSs($id) {
        return \app\models\cbelajar\TblBiasiswa::findOne(['HighestEduLevelCd' => $id]);
    }

    public function actionUploadDokumen($id) {
        $icno = Yii::$app->user->getId();
        $dokumen = $this->findDokumenbyId($id);
        $model = new \app\models\cbelajar\TblFilePemohon();
        if (\app\models\cbelajar\TblFilePemohon::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id])->exists()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
            return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]); //
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->namafile = UploadedFile::getInstances($model, 'namafile');

            foreach ($model->namafile as $saving) {
                if ($saving) {
                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');

                    $file_path = $file->file_name_hashcode;
                }
                $simpan = new \app\models\cbelajar\TblFilePemohon();
                $simpan->uploaded_by = $icno;
                $simpan->dokumenCd = $id;
                $simpan->idBorang = 1;
                $simpan->namafile = $file_path;
                $simpan->nama_dokumen = $dokumen->nama_dokumen;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                return $this->redirect(['borang']);
            }
        } else {
            return $this->render('_form', [
                        'model' => $model,
            ]);
        }
    }

    protected function findDokumenById($id) {
        if (($model = \app\models\cbelajar\TblDokumen::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionView_1($laporID) {

        $i = Yii::$app->user->getId();
//              $pengajian=$this->findPengajian2($id);
        $model = $this->findLapor($laporID);
        $pengajian = TblPengajian::find()->where(['icno' => $model->icno, 'status' => 1])->all();
        $biasiswa = \app\models\cbelajar\TblBiasiswa::find()->where(['icno' => $model->icno, 'status' => 1])->all();
        $icno = $model->icno;
//              $h = $pengajian->HighestEduLevelCd;
        $status = $this->findStatus($icno);
//             $biasiswa=$this->findSs($h);

        $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();

//              $p=$this->findP($id);
//              $model = new \app\models\cbelajar\TblLapordiri();
//          $model = \app\models\cbelajar\TblBiasiswa::find()->where(['status_form' => 1])->all();
        if ($model->load(Yii::$app->request->post())) {

//               $model->icno = $pengajian->icno;
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->updated_by = $i;
//               $model->HighestEduLevelCd = $pengajian->HighestEduLevelCd;


            if ($model->status_pengajian == "1") {
//                                  $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
                $perkhidmatan->ICNO = $model->icno;
                $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
                $perkhidmatan->ServStatusCd = 1;
                $perkhidmatan->ServStatusDtl = 1;
                $perkhidmatan->save(false);
//                                  $pengajian->status=2;
//                                  $biasiswa->status=2;
                $status->Status = 1;
                $status->save(false);
            } elseif ($model->status_pengajian == "BELUM SELESAI") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
                $perkhidmatan->ICNO = $model->icno;
                $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
                $perkhidmatan->ServStatusCd = 1;
                $perkhidmatan->ServStatusDtl = 1;
                $perkhidmatan->save(false);
//                                  $pengajian->status=4;
//                                  $biasiswa->status=4;
                $status->Status = 1;
                $status->save(false);
            } elseif ($model->status_pengajian == "GAGAL PENGAJIAN") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
//                                  $pengajian->status=5;
                $biasiswa->status = 5;
                $status->save(false);
            } elseif ($model->status_pengajian == "GAGAL PENGAJIAN DAN MELETAK JAWATAN") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
//                                  $pengajian->status=6;
//                                  $biasiswa->status=6;
                $status->save(false);
            } elseif ($model->status_pengajian == "GAGAL PENGAJIAN DAN DAN DIBERHENTIKAN") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
//                                  $pengajian->status=7;
//                                  $biasiswa->status=7;
                $status->save(false);
            } elseif ($model->status_pengajian == "GAGAL PENGAJIAN DAN MELETAK JAWATAN") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
//                                  $pengajian->status=6;
//                                  $biasiswa->status=6;
                $status->save(false);
            } elseif ($model->status_pengajian == "MIA") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
//                                  $pengajian->status=8;
//                                  $biasiswa->status=8;

                $status->save(false);
            }

//               elseif ($model->status_pengajian == "TIDAK BALIK LAPOR DIRI")
//               {
//                   
//                                  $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
//                                  $pengajian->status=4;
//                                  $status->Status =6;
//
//               }



            $model->save(false);
//            $pengajian->save(false);
//            $biasiswa->save(false);
//            $status->save(false);
//            $st->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Lapor Diri Berjaya Disimpan']);
            return $this->redirect(['cbadmin/senaraitindakanlapor']);
//            $p->save(false);
        }


        return $this->renderAjax('view_1', [
                    'pengajian' => $pengajian,
//                'p' => $p,
                    'model' => $model,
//               'elaun' => $elaun,
                    'perkhidmatan' => $perkhidmatan,
        ]);
    }

    protected function findPengajian4($id) {
        return \app\models\cbelajar\TblPengajian::findOne(['id' => $id]);
    }

    public function actionView_2($laporID) {

        $i = Yii::$app->user->getId();
//              $pengajian=$this->findPengajian2($id);
        $model = $this->findLapor($laporID);
        $pengajian = TblPengajian::find()->where(['icno' => $model->icno, 'status' => 1])->all();
        $biasiswa = \app\models\cbelajar\TblBiasiswa::find()->where(['icno' => $model->icno, 'status' => 1])->all();
        $icno = $model->icno;
//              $h = $pengajian->HighestEduLevelCd;
        $belajar = $this->findBelajar($icno);
        $spon = $this->findBelanja($icno);

        $status = $this->findStatus($icno);
//             $biasiswa=$this->findSs($h);

        $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();

//              $p=$this->findP($id);
//              $model = new \app\models\cbelajar\TblLapordiri();
//          $model = \app\models\cbelajar\TblBiasiswa::find()->where(['status_form' => 1])->all();
        if ($model->load(Yii::$app->request->post())) {

//               $model->icno = $pengajian->icno;
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->updated_by = $i;
//               $model->HighestEduLevelCd = $pengajian->HighestEduLevelCd;


            if ($model->status_pengajian == "1") {
//                                
//                                    $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
                $perkhidmatan->ICNO = $model->icno;
                $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
                $perkhidmatan->ServStatusCd = 1;
                $perkhidmatan->ServStatusDtl = 1;
                $perkhidmatan->save(false);
                $belajar->status = 2;
                $spon->status = 2;
                $status->Status = 1;

                $status->save(false);
                $belajar->save(false);
                $spon->save(false);
            } elseif (($model->status_pengajian == "2") || ($model->status_pengajian == "3") || ($model->status_pengajian == "4") || ($model->status_pengajian == "5") || ($model->status_pengajian == "6") || ($model->status_pengajian == "7")
                     || $model->status_pengajian == 12 || $model->status_pengajian == 13
                    ||  $model->status_pengajian == 14)  {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
                $perkhidmatan->ICNO = $model->icno;
                $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
                $perkhidmatan->ServStatusCd = 1;
                $perkhidmatan->ServStatusDtl = 1;
                $perkhidmatan->save(false);
//                                  $pengajian->status = Yii::$app->request->post()['LkkDean']['result'];

                $belajar->status = 4;
                $spon->status = 4;
                $status->Status = 1;
                $status->save(false);
                $belajar->save(false);
                $spon->save(false);
            }


//               elseif ($model->status_pengajian == "TIDAK BALIK LAPOR DIRI")
//               {
//                   
//                                  $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
//                                  $pengajian->status=4;
//                                  $status->Status =6;
//
//               }



            $model->save(false);
//            $pengajian->save(false);
//            $biasiswa->save(false);
//            $status->save(false);
//            $st->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Lapor Diri Berjaya Disimpan']);
            return $this->redirect(['cbadmin/senaraitindakanlapor']);
//            $p->save(false);
        }


        return $this->renderAjax('view_1', [
                    'pengajian' => $pengajian,
//                'p' => $p,
                    'model' => $model,
//               'elaun' => $elaun,
                    'perkhidmatan' => $perkhidmatan,
        ]);
    }

    public function actionBorangHpg() {

        $icno = Yii::$app->user->getId();
//        $iklan = $this->findIklanbyID($id);
        $model = new \app\models\cbelajar\TblTuntut();
        $lapor = new TblLapordiri();

        $model->icno = $icno;
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $model->tarikh_m = date('Y-m-d H:i:s');
        $model->j_tuntutan = "HPG";
//        $file = UploadedFile::getInstance($model, 'file');
//        $file2 = UploadedFile::getInstance($model, 'file2');
//        $file3 = UploadedFile::getInstance($model, 'file3');
//        $file4 = UploadedFile::getInstance($model, 'file4');
//        $file5 = UploadedFile::getInstance($model, 'file5');
//        $file6 = UploadedFile::getInstance($model, 'file6');
//        $checkApplication = TblLanjutan::find()->where(['status_borang' => "Selesai Permohonan",'icno' => $icno, 'iklan_id'=>$iklan->id]);
//        if($checkApplication->exists()){
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
//            return $this->redirect(['lanjutancb/lihat-permohonan', 'id'=>$iklan->id]);
//        }
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




        if ($model->load(Yii::$app->request->post())) {
            if ($model->agree == 0) {
                Yii::$app->session->setFlash('alert', ['title' => 'Amaran !', 'type' => 'error', 'msg' => 'Sila tanda kotak semak permohonan.']);
                return $this->redirect(['borang-hpg']);
            } else {
                $model->icno;


                $model->status = "Telah Mohon ";
                $lapor->save(false);
                $model->save(false);

                $ntf = new Notification();
                $ntf->icno = 850711125215; // peg  penyelia perjawatan
                $ntf->title = 'Pengajian Lanjutan - Permohonan Tuntutan Hadiah Pergerakan Gaji (HPG)';
                $ntf->content = "Permohonan Tuntutan Hadiah Pergerakan Gaji (HPG) menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['lapordiri/perjawatan'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save(false);
                $this->notifikasi($icnopetindak1, "Permohonan Hadiah Pergerakan Gaji (HPG) menunggu tindakan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/menunggu'], ['class' => 'btn btn-primary btn-sm']));
                $this->notifikasi($model->icno, "Permohonan Lapor Diri Tamat Tempoh Pengajian Lanjutan  anda telah dihantar untuk tindakan " . $petindak1 . " " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));

//                    Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Dihantar', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
//                     return $this->redirect(['lihat-permohonan', 'i'=>$model->id]);//
            }
        }

        return $this->render('_borang_hpg', [

                    'model' => $model,
//                    'iklan' => $iklan,
        ]);
    }

    public function actionRekodLaporDiri() {

        $model = new TblLapordiri();
        $icno = Yii::$app->user->getId();
        $model->icno = $icno;
        $lapordiri = \app\models\cbelajar\TblLaporDiriSearch::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
        $searchModel = new \app\models\cbelajar\TblLaporDiriSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $ver = TblLapordiri::find()->where(['ver_by' => $icno, 'status_borang' => "Selesai Permohonan"])->orderBy(['tarikh_m' => SORT_DESC]);
        return $this->render('rekodsemasa', [
                    'model' => $model,
                    'lapordiri' => $lapordiri,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'ver' => $ver,
                    'bil' => 1,
                    'icno' => $icno
        ]);
    }

    public function actionAdminview($i) {
        $icno = Yii::$app->user->getId();
        $model = TblLapordiri::findOne(['laporID' => $i, 'status_borang' => "Selesai Permohonan"]);
//        $iklan = $this->findIklanbyID($id);
        $biodata = $this->findBiodata1($icno);
        $id = $model->icno;
        $b = $this->findStudy($id);
        $akhir = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 37, 'icno' => $model->icno, 'status_borang' => "Selesai Permohonan"])->one();

        if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('adminview', [
//              'iklan' => $iklan,
                        'model' => $model,
                        'b' => $b,
                        'biodata' => $biodata,
                        'img' => $biodata->img,
                        'akhir' => $akhir,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    public function actionAdminviewselesai($i) {
        $icno = Yii::$app->user->getId();
        $model = TblLapordiri::findOne(['laporID' => $i, 'status_borang' => "Selesai Permohonan"]);
//        $iklan = $this->findIklanbyID($id);
        $biodata = $this->findBiodata1($icno);
        $id = $model->icno;
        $b = $this->findStudy($id);
        $akhir = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 37, 'icno' => $model->icno, 'status_borang' => "Selesai Permohonan"])->one();
        $hpg = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 30, 'icno' => $model->icno, 'status_borang' => "Selesai Permohonan"])->one();
        $tesis = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 35, 'icno' => $model->icno, 'status_borang' => "Selesai Permohonan"])->one();
        if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('adminviews', [
//              'iklan' => $iklan,
                        'model' => $model,
                        'b' => $b,
                        'biodata' => $biodata,
                        'img' => $biodata->img,
                        'akhir' => $akhir,
                        'hpg' => $hpg,
                        'tesis' => $tesis
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    public function actionSenaraitindakan() {
        $icno = Yii::$app->user->getId();
        $title = '';
        $senarai = '';
        $status = ['Tunggu Perakuan', 'Diperakukan', 'Tidak Diperakukan'];
        $a = (Department::find()->where(['chief' => $icno, 'isActive' => '1']));
        $b = (\app\models\cbelajar\TblAccess::find()->where(['icno' => $icno, 'level' => 2]));
        if ($a || $b->exists()) {
            $senarai = TblLapordiri::find()->where(['app_by' => $icno, 'status_borang' => "Selesai Permohonan"])->orderBy(['tarikh_mohon' => SORT_DESC]);
            $title = 'Senarai Menunggu Perakuan';
        }
//       if(Department::find()->where( ['chief' => $icno, 'isActive' => '1'] )->exists()){
//            $senarai = TblLapordiri::find()->where(['app_by' => $icno, 'status_borang' => "Selesai Permohonan"])->orderBy(['tarikh_mohon' => SORT_DESC]);
//            $title='Senarai Menunggu Perakuan';
//        }
        elseif (\app\models\cbelajar\TblAccess::find()->where(['icno' => $icno])->exists()) {
            $senarai = TblLapordiri::find()->where([ 'status_borang' => "Selesai Permohonan", 'agree' => 1])->orderBy(['tarikh_mohon' => SORT_DESC]);
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
            return $this->redirect(['kemudahan/index']);
        }
    }

    protected function findBiodata1($id) {
        return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
    }

    public function actionLihatPermohonan($i) {
        $icno = Yii::$app->user->getId();
        $b = $this->findStudy($icno);
        $biodata = $this->findBiodata1($icno);
        $stu = TblPengajian::find()->where(['icno' => $icno, 'laporID' => $i])->one();
        $lapor = \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();

        $model = TblLapordiri::findOne(['icno' => $icno, 'status_borang' => "Selesai Permohonan", 'laporID' => $i]);

//        $iklan = $this->findIklanbyID($id);

        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "2" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "2") || ($model->kakitangan->statLantikan == "3" && $model->kakitangan->jawatan->job_category == "2")) {
            if (TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->exists()) {
                return $this->render('_lihatpermohonan', [
//              'iklan' => $iklan,
                            'model' => $model,
                            'b' => $b,
                            'biodata' => $biodata,
                            'img' => $biodata->img,
                            'lapor' => $lapor,
                            'stu' => $stu, 'i' => $i
                ]);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    public function actionBelumSelesai($i) {
        $icno = Yii::$app->user->getId();
        $b = $this->findStudy($icno);
        $biodata = $this->findBiodata1($icno);
        $lapor = \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();

        $model = TblLapordiri::findOne(['icno' => $icno, 'status_borang' => "Selesai Permohonan", 'laporID' => $i]);
//        $stu = TblPengajian::find()->where(['laporID'=>$i])->one();
        $stu = TblPengajian::find(['icno' => $icno, 'status' => [1, 2]])->orderBy(['tarikh_mula' => SORT_DESC])->one() ? TblPengajian::find()->where(['icno' => $icno, 'status' => [1, 2]])->orderBy(['tarikh_mula' => SORT_DESC])->one() : new TblPengajian();
//        $iklan = $this->findIklanbyID($id);

        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "2" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "2") || ($model->kakitangan->statLantikan == "3" && $model->kakitangan->jawatan->job_category == "2")) {
            if (TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->exists()) {
                return $this->render('_lihatpermohonanb', [
//              'iklan' => $iklan,
                            'model' => $model,
                            'b' => $b,
                            'biodata' => $biodata,
                            'img' => $biodata->img,
                            'lapor' => $lapor, 'i' => $i, 'stu' => $stu
                ]);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    protected function findLapordiri2($id) {
        if (($model = \app\models\cbelajar\TblLapordiri::findOne(['laporID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionKemaskiniLapordiri($i) {
        $icno = Yii::$app->user->getId();
        $model = $this->findLapordiri2($i);
        $b = $this->findStudy($icno);
        $biodata = $this->findBiodata1($icno);
        $lapor = \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();
//        $model = TblLapordiri::findOne(['icno' => $icno, 'status_borang' => "Selesai Permohonan", 'laporID'=>$i]);
//        $stu = TblPengajian::find()->where(['laporID'=>$i])->one();
        $stu = TblPengajian::find(['icno' => $icno, 'status' => [1, 2]])->orderBy(['tarikh_mula' => SORT_DESC])->one() ? TblPengajian::find()->where(['icno' => $icno, 'status' => [1, 2]])->orderBy(['tarikh_mula' => SORT_DESC])->one() : new TblPengajian();
//        $iklan = $this->findIklanbyID($id);

        $file6 = UploadedFile::getInstance($model, 'file6');

        if ($file6) {
            $fileapi = Yii::$app->FileManager->UploadFile($file6->name, $file6->tempName, '04', 'lapordiri');
            $filepath6 = $fileapi->file_name_hashcode;
        } else {
            $filepath6 = '';
        }

        if ($model->load(Yii::$app->request->post())) {
//               if($model->agree == 0)
//            {
//                Yii::$app->session->setFlash('alert', ['title' => 'Amaran !', 'type' => 'error', 'msg' => 'Sila tanda kotak semak permohonan.']);
//                return $this->redirect(['borang']);
//
//            }
//            else
//        
            $model->icno;
                        $model->tahun = date("Y");

//            $model->iklan_id=$iklan->id;
            $model->status_pengajian;
            $model->dt_tesis;
            $model->writing;
            $model->correction;
            $model->dt_viva;
            $model->HighestEduLevelCd = $stu->HighestEduLevelCd;
            
            $model->dokumen_6 = $filepath6;
            $model->status_borang = "Selesai Permohonan ";
            $model->status_a = "DALAM PROSES";

            $model->save(false);
//            var_dump($model);die;
//            $stu->laporID = $model->laporID;
//            $stu->save(false);




            Yii::$app->session->setFlash('alert', ['title' => 'Status Pengajian Berjaya Disimpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['pengesahan-belum-selesai?i=' . $i]); //
        } else {


            return $this->render('_kemaskinib', [
//              'iklan' => $iklan,
                        'model' => $model,
                        'b' => $b,
                        'biodata' => $biodata,
                        'img' => $biodata->img,
                        'lapor' => $lapor, 'i' => $i,
                        'stu' => $stu
            ]);
        }
    }
    
    public function actionKemaskiniLapordiriselesai($i) {
        $icno = Yii::$app->user->getId();
        $model = $this->findLapordiri2($i);
        $b = $this->findStudy($icno);
        $biodata = $this->findBiodata1($icno);
        $lapor = \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();
//        $model = TblLapordiri::findOne(['icno' => $icno, 'status_borang' => "Selesai Permohonan", 'laporID'=>$i]);
//        $stu = TblPengajian::find()->where(['laporID'=>$i])->one();
        $stu = TblPengajian::find(['icno' => $icno, 'status' => [1, 2]])->orderBy(['tarikh_mula' => SORT_DESC])->one() ? TblPengajian::find()->where(['icno' => $icno, 'status' => [1, 2]])->orderBy(['tarikh_mula' => SORT_DESC])->one() : new TblPengajian();
//        $iklan = $this->findIklanbyID($id);

        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
        $file3 = UploadedFile::getInstance($model, 'file3');
        $file4 = UploadedFile::getInstance($model, 'file4');
        $file5 = UploadedFile::getInstance($model, 'file5');
        $file6 = UploadedFile::getInstance($model, 'file6');

          if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lapordiri');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = '';
        }


        if ($file2) {
            $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'lapordiri');
            $filepath2 = $fileapi->file_name_hashcode;
        } else {
            $filepath2 = '';
        }

        if ($file3) {
            $fileapi = Yii::$app->FileManager->UploadFile($file3->name, $file3->tempName, '04', 'lapordiri');
            $filepath3 = $fileapi->file_name_hashcode;
        } else {
            $filepath3 = '';
        }

        if ($file4) {
            $fileapi = Yii::$app->FileManager->UploadFile($file4->name, $file4->tempName, '04', 'lapordiri');
            $filepath4 = $fileapi->file_name_hashcode;
        } else {
            $filepath4 = '';
        }

        if ($file5) {
            $fileapi = Yii::$app->FileManager->UploadFile($file5->name, $file5->tempName, '04', 'lapordiri');
            $filepath5 = $fileapi->file_name_hashcode;
        } else {
            $filepath5 = '';
        }
        if ($file6) {
            $fileapi = Yii::$app->FileManager->UploadFile($file6->name, $file6->tempName, '04', 'lapordiri');
            $filepath6 = $fileapi->file_name_hashcode;
        } else {
            $filepath6 = '';
        }

        if ($model->load(Yii::$app->request->post())) {
//               if($model->agree == 0)
//            {
//                Yii::$app->session->setFlash('alert', ['title' => 'Amaran !', 'type' => 'error', 'msg' => 'Sila tanda kotak semak permohonan.']);
//                return $this->redirect(['borang']);
//
//            }
//            else
//        
            $model->icno;
                        $model->tahun = date("Y");

//            $model->iklan_id=$iklan->id;
            $model->status_pengajian;
            
            $model->HighestEduLevelCd = $stu->HighestEduLevelCd;
            
 $model->dokumen = $filepath;
            $model->dokumen2 = $filepath2;
            $model->dokumen3 = $filepath3;
            $model->dokumen4 = $filepath4;
            $model->dokumen5 = $filepath5;
            $model->dokumen_6 = $filepath6;         
            $model->status_borang = "Selesai Permohonan ";
            $model->status_a = "DALAM PROSES";

            $model->save(false);
//            var_dump($model);die;
//            $stu->laporID = $model->laporID;
//            $stu->save(false);




            Yii::$app->session->setFlash('alert', ['title' => 'Status Pengajian Berjaya Disimpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['pengesahan?i=' . $i]); //
        } else {


            return $this->render('_kemaskinis', [
//              'iklan' => $iklan,
                        'model' => $model,
                        'b' => $b,
                        'biodata' => $biodata,
                        'img' => $biodata->img,
                        'lapor' => $lapor, 'i' => $i,
                        'stu' => $stu
            ]);
        }
    }

    public function actionTindakanKj($i) {
//       $icno=Yii::$app->user->getId();
//               $model = TblLapordiri::find()->where(['iklan_id'=> $id, 'laporID'=>$i])->one();
//        $stu = TblPengajian::find()->where(['icno' => $icno, 'laporID' => $i])->orderBy(['tarikh_mula' => SORT_DESC])->one();

        $model = TblLapordiri::findOne([ 'status_borang' => "Selesai Permohonan", 'laporID' => $i]);
        $icno = $model->icno;
//        $iklan = $this->findIklanbyID($id);
        $b = $this->findStudy($icno);
        $akhir = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 37, 'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            $model->status_bsm = 'Tunggu Kelulusan BSM';
            $model->app_date = date('Y-m-d H:i:s');


            if ($model->status_jfpiu == 'Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya',
                    'type' => 'success', 'msg' => 'Borang lapordiri telah disemak!']);
            } elseif ($model->status_jfpiu == 'Tidak Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya',
                    'type' => 'success', 'msg' => 'Borang lapordiri telah disemak!']);
            }
//                $model->dt_lapordiri;
            $model->save(false);

//            $ntf = new Notification();
//            $ntf->icno = 891103125554; // peg  penyelia perjawatan
//            $ntf->title = 'Permohonan Lapor Diri';
//            $ntf->content = "Permohonan Lapor Diri menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakanlapor'], ['class' => 'btn btn-primary btn-sm']);
//            $ntf->ntf_dt = date('Y-m-d H:i:s');
//            $ntf->save(false);
            
            $ntf2 = new Notification();            
            $ntf2->icno = 870818495847; // peg  penyelia perjawatan
            $ntf2->title = ' Lapor Diri';
            $ntf2->content = "Permohonan Lapor Diri menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakanlapor'], ['class' => 'btn btn-primary btn-sm']);
            $ntf2->ntf_dt = date('Y-m-d H:i:s');
            $ntf2->save(false);
            $this->notifikasi($model->icno, "Permohonan Lapor Diri anda telah disemak dan dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['lapordiri/senaraitindakan']);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        if (Yii::$app->user->getId() == $model->app_by) {
            return $this->render('_tindakankj', [

//              'iklan' => $iklan,
                        'model' => $model,
                        'bil' => '1',
                        'edit' => $edit,
                        'view' => $view,
                        'b' => $b,
                        'akhir' => $akhir,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionTindakanKjSelesai($i) {
       $icno=Yii::$app->user->getId();
//               $model = TblLapordiri::find()->where(['iklan_id'=> $id, 'laporID'=>$i])->one();
        $stu = TblPengajian::find()->where(['icno' => $icno, 'laporID' => $i])->orderBy(['tarikh_mula' => SORT_DESC])->one();

        $model = TblLapordiri::findOne([ 'status_borang' => "Selesai Permohonan", 'laporID' => $i]);
//        $icno = $model->icno;
//$admin = \app\models\cbelajar\TblAccess::find()->where(['icno'=>['891103125554','870818495847']])->one();
//        $iklan = $this->findIklanbyID($id);
        $id = $model->icno;
        $b = $this->findStudy($id);
        $akhir = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 37, 'icno' => $id, 'status_borang' => "Selesai Permohonan"])->one();
        $hpg = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 30, 'icno' => $id, 'status_borang' => "Selesai Permohonan"])->one();
        $tesis = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 35, 'icno' => $id, 'status_borang' => "Selesai Permohonan"])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            $model->status_bsm = 'Tunggu Kelulusan BSM';
            $model->app_date = date('Y-m-d H:i:s');


            if ($model->status_jfpiu == 'Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya',
                    'type' => 'success', 'msg' => 'Borang lapordiri telah disemak!']);
            } elseif ($model->status_jfpiu == 'Tidak Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya',
                    'type' => 'success', 'msg' => 'Borang lapordiri telah disemak!']);
            }
//                $model->dt_lapordiri;
            $model->save(false);

//            
//            $ntf = new Notification();
//
//            
//            $ntf->icno = 891103125554; // peg  penyelia perjawatan
//            $ntf->title = ' Lapor Diri';
//            $ntf->content = "Permohonan Lapor Diri menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakanlapor'], ['class' => 'btn btn-primary btn-sm']);
//            $ntf->ntf_dt = date('Y-m-d H:i:s');
//            $ntf->save(false);
            
            $ntf2 = new Notification();

            
            $ntf2->icno = 870818495847; // peg  penyelia perjawatan
            $ntf2->title = ' Lapor Diri';
            $ntf2->content = "Permohonan Lapor Diri menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakanlapor'], ['class' => 'btn btn-primary btn-sm']);
            $ntf2->ntf_dt = date('Y-m-d H:i:s');
            $ntf2->save(false);
            
            $this->notifikasi($model->icno, "Permohonan Lapor Diri anda telah disemak dan dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['lapordiri/senaraitindakan']);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        if (Yii::$app->user->getId() == $model->app_by) {
            return $this->render('kjselesai', [

//              'iklan' => $iklan,
                        'model' => $model,
                        'bil' => '1',
                        'edit' => $edit,
                        'view' => $view,
                        'b' => $b,
                        'akhir' => $akhir,
                        'hpg' => $hpg,
                        'tesis' => $tesis,
                'stu'=>$stu
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    protected function findIklanbyID($id) {
        if (($model = TblUrusMesyuarat::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findLapordiri($icno) {
        return \app\models\cbelajar\TblLapordiri::find(['icno' => $icno])->orderBy(['dt_lapordiri'=>SORT_DESC])->one();
    }

    public function actionTuntutHpg() {
        $icno = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblTuntut();
        $model->icno = $icno;
//        $lapor = new TblLapordiri();
        $lapor = $this->findLapordiri($icno);
        $model->status_borang = "Selesai Permohonan";
//        $model->idBorang = "CBDN";
        $model->status = "MENUNGGU SEMAKAN PERJAWATAN";
        $model->status_bsm = "Tunggu Kelulusan";
        $model->tarikh_m = date('Y-m-d H:i:s');
        $file = UploadedFile::getInstance($model, 'file');
        $hpg = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 30, 'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();

        $checkApplication = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 30, 'status_borang' => "Selesai Permohonan", 'icno' => $icno]);
        if ($checkApplication->exists()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['lihat-permohonan-hpg', 'id' => $hpg->id]);
        }
        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'cb_hpg');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = '';
        }
// if(!$model->kakitangan->jawatan->gred == "DS45")
//        {
//              Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'info', 'msg' => 'LKP hanya boleh diakses jika anda sedang cuti belajar!']);
//            return $this->redirect(['cutibelajar/halaman-pemohon']);
//        }
        if($model->kakitangan->jawatan->gred == "DS45"){
        if ($model->load(Yii::$app->request->post())) {

            $model->idBorang = "30";
            $model->j_tuntutan = "HPG";
            $model->agree = 1;
            $model->dokumen = $filepath;
            $model->save(false);

            $ntf = new Notification();
            $ntf->icno = 850711125215; // peg  penyelia perjawatan
            $ntf->title = 'Pengajian Lanjutan - Permohonan Tuntutan Hadiah Pergerakan Gaji (HPG)';
            $ntf->content = "Permohonan Tuntutan Hadiah Pergerakan Gaji (HPG) menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['lapordiri/perjawatan'], ['class' => 'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false);
            $this->notifikasi($model->icno, "Permohonan Tuntutan Hadiah  Pergerakan Gaji (HPG) anda telah dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
            return $this->redirect(['lihat-permohonan-hpg', 'id' => $model->id]); //
        }
        return $this->render('_hpg', [
                    'model' => $model,
                    'lapor' => $lapor,
        ]);
    }
    else
    {
        Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'info', 'msg' =>
            'Permohonan ini hanya boleh dimohon untuk gred DS45(Pensyarah)']);
            return $this->redirect(['cutibelajar/senarai-borang']);
    }
    }

    public function actionLihatPermohonanHpg($id) {
        $icno = Yii::$app->user->getId();
        $lapor = $this->findLapordiri($icno);

        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();

        if (\app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->exists()) {
            return $this->render('_lihatpermohonanhpg', [
                        'model' => $model,
                        'lapor' => $lapor,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('/cutibelajar/halaman-pemohon');
        }
    }

    public function actionTuntutTesis() {
        $icno = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblTuntut();
//                $tesis = \app\models\cbelajar\TblDokumen::find()->where(['jenisDokumen'=>5])->all();
        $tesis = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 35, 'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();

        $model->icno = $icno;
        $lapordiri = TblLapordiri::find()->where(['icno'=>$icno])->orderBy(['dt_lapordiri'=> SORT_DESC])->one();
//        $lapor = new TblLapordiri();
        $lapor = $this->findLapordiri($icno);
        $model->status_borang = "Selesai Permohonan";
//        $model->idBorang = "CBDN";
        $model->status_bsm = "Tunggu Kelulusan";
        $model->status_semakan = "TUNGGU SEMAKAN";
        $model->tarikh_m = date('Y-m-d H:i:s');
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
        $file3 = UploadedFile::getInstance($model, 'file3');

        $checkApplication = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 35, 'status' => "LULUS", 'icno' => $model->icno]);
        if ($checkApplication->exists()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['lihat-permohonan-tesis', 'id' => $tesis->id]);
        }
        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'cb_Tesis');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = '';
        }
        if ($file2) {
            $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'cb_Tesis');
            $filepath2 = $fileapi->file_name_hashcode;
        } else {
            $filepath2 = '';
        }
         if ($file3) {
            $fileapi = Yii::$app->FileManager->UploadFile($file3->name, $file3->tempName, '04', 'cb_Tesis');
            $filepath3 = $fileapi->file_name_hashcode;
        } else {
            $filepath3 = '';
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->idBorang = "35";
            $model->j_tuntutan = "TESIS";
            $model->agree = 1;
            $model->dokumen = $filepath;
            $model->dokumen2 = $filepath2;
            $model->dokumen3 = $filepath3;

            $model->save(false);
                $this->pendingtask(840929125614, 40);



            $ntf = new Notification();
            $ntf->icno = 840929125614; // peg  penyelia perjawatan
            $ntf->title = 'Pengajian Lanjutan - Permohonan Tuntutan Elaun Tesis';
            $ntf->content = "Permohonan Tuntutan Elaun Tesis menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakantuntutan'], ['class' => 'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false);
            $this->notifikasi($model->icno, "Permohonan Tuntutan Elaun Tesis anda telah dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
            return $this->redirect(['lihat-permohonan-tesis', 'id' => $model->id]); //
        }
        return $this->render('_tesis', [
                    'model' => $model,
                    'lapor' => $lapor,
            'lapordiri'=>$lapordiri,
//              'tesis'=>$tesis,
        ]);
    }

    public function actionTuntutAkhir() {
        $icno = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblTuntut();
        $model->icno = $icno;
        $lapor = $this->findLapordiri($icno);
        $model->status_borang = "Selesai Permohonan";
        $model->status_bsm = "Tunggu Kelulusan";
        $model->status_semakan = "TUNGGU SEMAKAN";

        $model->tarikh_m = date('Y-m-d H:i:s');
        $akhir = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 37, 'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
        $file3 = UploadedFile::getInstance($model, 'file3');
        $file4 = UploadedFile::getInstance($model, 'file4');

        $checkApplication = \app\models\cbelajar\TblTuntut::find()->where(['icno' => $icno, 'j_tuntutan' => "AKHIR", 'idBorang' => 37]);
        if ($checkApplication->exists()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['lihat-permohonan-akhir', 'id' => $akhir->id]);
        }
        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'cb_akhir');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = '';
        }
        if ($file2) {
            $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'cb_akhir');
            $filepath2 = $fileapi->file_name_hashcode;
        } else {
            $filepath2 = '';
        }
        if ($file3) {
            $fileapi = Yii::$app->FileManager->UploadFile($file3->name, $file3->tempName, '04', 'cb_akhir');
            $filepath3 = $fileapi->file_name_hashcode;
        } else {
            $filepath3 = '';
        }
        if ($file4) {
            $fileapi = Yii::$app->FileManager->UploadFile($file4->name, $file4->tempName, '04', 'cb_akhir');
            $filepath4 = $fileapi->file_name_hashcode;
        } else {
            $filepath4 = '';
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->idBorang = "37";
            $model->j_tuntutan = "AKHIR";
            $model->agree = 1;
            $model->dokumen = $filepath;
            $model->dokumen2 = $filepath2;
            $model->dokumen3 = $filepath3;
            $model->dokumen4 = $filepath4;

            $model->save(false);

                $this->pendingtask(840929125614, 39);


            $ntf = new Notification();
            $ntf->icno = 840929125614; // peg  penyelia perjawatan
            $ntf->title = 'Pengajian Lanjutan - Permohonan Tuntutan Elaun Akhir Pengajian';
            $ntf->content = "Permohonan Tuntutan Elaun Tesis menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakantuntutan'], ['class' => 'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false);
            
            $this->notifikasi($model->icno, "Permohonan Tuntutan Elaun Akhir Pengajian anda telah dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
            return $this->redirect(['lihat-permohonan-akhir', 'id' => $model->id]); //
        }
        return $this->render('_akhir', [
                    'model' => $model,
                    'lapor' => $lapor,
        ]);
    }

    public function actionLihatPermohonanTesis($id) {
        $icno = Yii::$app->user->getId();
        $lapor = $this->findLapordiri($icno);
        $lapordiri = TblLapordiri::find()->where(['icno'=>$icno])->orderBy(['dt_lapordiri'=> SORT_DESC])->one();

        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();

        if (\app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->exists()) {

            if ($model->status_semakan == 'Layak Dipertimbangkan' ||
                    $model->status_semakan == 'Dokumen Tidak Lengkap') {
                $edit = 'none';
                $view = '';
            } else {
                $view = 'none';
                $edit = '';
            }
            return $this->render('_lihatpermohonantesis', [
                        'model' => $model,
                        'lapor' => $lapor,
                        'edit' => $edit,
                        'view' => $view,
                'lapordiri'=>$lapordiri
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('/cutibelajar/halaman-pemohon');
        }
    }

    public function actionLihatPermohonanAkhir($id) {
        $icno = Yii::$app->user->getId();
        $lapor = $this->findLapordiri($icno);
        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();

        if (\app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->exists()) {
            return $this->render('_lihatpermohonanakhir', [
                        'model' => $model,
                        'lapor' => $lapor,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('/cutibelajar/halaman-pemohon');
        }
    }

    public function actionViewTuntutanHpg($id) {
        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->one();

        if (\app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->exists()) {
            if ($model->load(Yii::$app->request->post())) {


                $model->save(false);
                return $this->redirect(['view-tuntutan-hpg', 'id' => $id]);
            }


            if ($model->status_j == 'Telah ditawarkan kenaikan pangkat jawatan Pensyarah Kanan Gred DS52' ||
                    $model->status_j == 'Belum ditawarkan kenaikan pangkat jawatan Pensyarah Kanan Gred DS52') {
                $edits = 'none';
                $vieww = '';
            } else {
                $vieww = 'none';
                $edits = '';
            }

            if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
                return $this->render('viewtuntutanhpg', [
                            'model' => $model,
//           'view'=>$view,
//                'edit'=>$edit,
                            'vieww' => $vieww,
                            'edits' => $edits,
                ]);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('../cbelajar/halaman-utama-bsm');
        }
    }

    public function actionViewTuntutanAkhir($id) {
        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->one();

        if (\app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan", 'j_tuntutan' => "AKHIR"])->exists()) {
            if ($model->load(Yii::$app->request->post())) {
                $model->dt_semakan = date('Y-m-d H:i:s');

                if ($model->status_semakan == 'Layak Dipertimbangkan') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Semakan Disimpan!']);
                } elseif ($model->status_semakan == 'Dokumen Tidak Lengkap') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Dokumen Tidak Lengkap', 'type' => 'danger', 'msg' => 'Semakan Disimpan!']);
                }
                $this->notifikasi($model->icno, "Dokumen Permohonan Tuntutan Tesis anda tidak lengkap. Sila muatnaik semula dokumen. " . " " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Dihantar', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Semakan Berjaya Disimpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);

                return $this->redirect(['view-tuntutan-akhir', 'id' => $id]);
            }

            if ($model->status_semakan == 'Layak Dipertimbangkan' ||
                    $model->status_semakan == 'Dokumen Tidak Lengkap' ||  $model->status_semakan == 'Tidak Layak Dipertimbangkan') {
                $edit = 'none';
                $view = '';
            } else {
                $view = 'none';
                $edit = '';
            }
            if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
                return $this->render('viewtuntutanakhir', [
                            'model' => $model,
                            'view' => $view,
                            'edit' => $edit,
                ]);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('../cbelajar/halaman-utama-bsm');
        }
    }

    public function actionViewTuntutanTesis($id) {
        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->one();

        if (\app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->exists()) {
            if ($model->load(Yii::$app->request->post())) {
                $model->dt_semakan = date('Y-m-d H:i:s');

                if ($model->status_semakan == 'Layak Dipertimbangkan') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Semakan Disimpan!']);
                } elseif ($model->status_semakan == 'Dokumen Tidak Lengkap') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Dokumen Tidak Lengkap', 'type' => 'danger', 'msg' => 'Semakan Disimpan!']);
                }
                $this->notifikasi($model->icno, "Dokumen Permohonan Tuntutan Tesis anda tidak lengkap. Sila muatnaik semula dokumen. " . " " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Dihantar', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Semakan Berjaya Disimpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);

                return $this->redirect(['view-tuntutan-tesis', 'id' => $id]);
            }

            if ($model->status_semakan == 'Layak Dipertimbangkan' ||
                    $model->status_semakan == 'Dokumen Tidak Lengkap') {
                $edit = 'none';
                $view = '';
            } else {
                $view = 'none';
                $edit = '';
            }
            if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
                return $this->render('viewtuntutantesis', [
                            'model' => $model,
                            'view' => $view,
                            'edit' => $edit,
                ]);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('../cbelajar/halaman-utama-bsm');
        }
    }
 public function actionUpdateSemakan($id) {
        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id])->one();

        if($model->j_tuntutan== "TESIS")
        {
        if (($model->load(Yii::$app->request->post()))) {
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-tuntutan-tesis?id='.$model->id]);
        }
        }
        else
        {
           if (($model->load(Yii::$app->request->post()))) {
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-tuntutan-akhir?id='.$model->id]);
        }  
        }
        
        

        return $this->renderAjax('_updates', [
                    'model' => $model,
        
        ]);
    }
    public function GridHpg() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status' => "MENUNGGU SEMAKAN PERJAWATAN", 'j_tuntutan' => "HPG"]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridHpgLulus() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status' => ["LULUS", "TELAH DISEMAK"], 'j_tuntutan' => "HPG", 'idBorang' => 30]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionPerjawatan() {

        $permohonan = $this->GridHpg();
        $permohonanlulus = $this->GridHpgLulus();

        return $this->render('a_main', [
                    'permohonan' => $permohonan,
                    'permohonanlulus' => $permohonanlulus,
        ]);
    }

    public function actionViewHpg($id) {
        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->one();

        if (\app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->exists()) {
            if ($model->load(Yii::$app->request->post())) {
                $model->app_dt = new \yii\db\Expression('NOW()');
                $model->status = "TELAH DISEMAK";
                $model->app_by = 850711125215;
                if ($model->status_j == 'Telah ditawarkan kenaikan pangkat jawatan Pensyarah Kanan Gred DS52') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Semakan Disimpan!']);
                } elseif ($model->status_j == 'Belum ditawarkan Kenaikan Pangkat Pensyarah Kanan DS52
') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Dokumen Tidak Lengkap', 'type' => 'danger', 'msg' => 'Semakan Disimpan!']);
                }
                
                $ntf = new Notification();
                $ntf->icno = 840929125614; // peg  penyelia perjawatan
                $ntf->title = 'Pengajian Lanjutan - Permohonan Tuntutan Hadiah Pergerakan Gaji (HPG)';
                $ntf->content = "Permohonan Tuntutan Hadiah Pergerakan Gaji (HPG) menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senarai-tuntut-hpg'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save(false);
                $model->save(false);
                $this->pendingtask(840929125614, 38);

                return $this->redirect(['view-hpg', 'id' => $id]);
            }
            if ($model->status_j == 'Telah ditawarkan kenaikan pangkat jawatan Pensyarah Kanan Gred DS52' ||
                    $model->status_j == 'Belum ditawarkan Kenaikan Pangkat Pensyarah Kanan DS52
') {
                $edit = 'none';
                $vieww = '';
            } else {
                $vieww = 'none';
                $edit = '';
            }
            if (\app\models\cbelajar\TblAccess::find()->where([ 'icno' => Yii::$app->user->getId(), 'level' => 4])->exists()) {
                return $this->render('perjawatan', [
                            'model' => $model,
                            'vieww' => $vieww,
                            'edit' => $edit,
                ]);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('../cbelajar/halaman-utama-bsm');
        }
    }

    protected function findModelbyicno($icno) {
        if (($model = \app\models\hronline\Tblrscosalmovemth::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionKgt($id) {

        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->one();
        $icno = $model->icno;

        $self = \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $icno]);
        $gaji = $this->gaji();
        $nd = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'j_tuntutan' => "HPG"])->all();

        $MPH_STAFF_ID = \app\models\vhrms\ViewPayroll::find()->where(['MPH_STAFF_ID' => $self->COOldID])->one();
        $model2 = \app\models\vhrms\ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID, 'MPH_PAY_MONTH' => $gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();

        $c = \app\models\vhrms\ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID, 'MPH_PAY_MONTH' => $gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE', 'E'], ['like', 'MPDH_INCOME_CODE', 'B', ['like', 'MPDH_INCOME_CODE', 'F']]])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
        if (\app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->exists()) {
            if ($model->load(Yii::$app->request->post())) {

                if ($model->status_semakan == 'Layak Dipertimbangkan') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Semakan Disimpan!']);
                } elseif ($model->status_semakan == 'Dokumen Tidak Lengkap') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Dokumen Tidak Lengkap', 'type' => 'danger', 'msg' => 'Semakan Disimpan!']);
                }
                $ntf = new Notification();
                $ntf->icno = 850711125215; // peg  penyelia perjawatan
                $ntf->title = 'Pengajian Lanjutan - Permohonan Tuntutan Hadiah Pergerakan Gaji (HPG)';
                $ntf->content = "Permohonan Tuntutan Hadiah Pergerakan Gaji (HPG) menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['lapordiri/perjawatan'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save(false);
                $model->save(false);
                return $this->redirect(['view-tuntutan-hpg', 'id' => $id]);
            }
            if ($model->status_semakan == 'Layak Dipertimbangkan' ||
                    $model->status_semakan == 'Tidak Layak Dipertimbangkan') {
                $edit = 'none';
                $view = '';
            } else {
                $view = 'none';
                $edit = '';
            }

            if ($model->status_j == 'Telah ditawarkan kenaikan pangkat jawatan Pensyarah Kanan Gred DS52' ||
                    $model->status_j == 'Belum ditawarkan Kenaikan Pangkat Pensyarah Kanan DS52
') {
                $edits = 'none';
                $vieww = '';
            } else {
                $vieww = 'none';
                $edits = '';
            }

            if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
                return $this->render('kgt', [
                            'model' => $model,
                            'view' => $view,
                            'edit' => $edit,
                            'vieww' => $vieww,
                            'edits' => $edits,
                            'c' => $c,
                            'model2' => $model2,
                            'nd' => $nd,
                            'alamat' => $this->findModelbyicno($icno)
                ]);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('../cbadmin/halaman-admin');
        }
    }

    protected function gaji() {
        $ma = date('m');
        $ya = date('Y');
        if (($ma == "1") && $ya) {
            $y = date('Y', strtotime("-1 year"));
            $m = date('m', strtotime("-1 months"));
            $pm = $y . $m;
        } else {
            $y = date('Y');
            $m = date('m', strtotime("-1 month"));
            $pm = $y . $m;
        }

        return $pm;
    }

    public function actionAddKgt($id) {
        $nd = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'j_tuntutan' => "HPG"])->one();
        $icno = $nd->icno;

//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($nd->load(Yii::$app->request->post()) && $nd->save()) {
            return $this->redirect(['kgt?id=' . $id]);
        }

        return $this->renderAjax('add_kgt', [
                    'nd' => $nd,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionAddHpg($id) {
        $nd = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'j_tuntutan' => "HPG"])->one();
        $icno = $nd->icno;
        $mov = new \app\models\hronline\Tblrscosalmovemth();

//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($nd->load(Yii::$app->request->post()) && $nd->save(false)) {
            $mov->ICNO = $nd->icno;
            $mov->SalMoveMth = $nd->bulan_barukgt;
            $mov->SalMoveMthType = 2;
            
                                  $mov->SalMoveMthStDt = $nd->SalMoveMthStDt;
            $mov->save(false);
            return $this->redirect(['kgt?id=' . $id]);
        }

        return $this->renderAjax('add_hpg', [
                    'nd' => $nd,
                    'mov' => $mov,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionCetakBorang($id) {
        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->one();
        $nd = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'j_tuntutan' => "HPG"])->one();
        $icno = $model->icno;
        $self = \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $icno]);
        $gaji = $this->gaji();

        $MPH_STAFF_ID = \app\models\vhrms\ViewPayroll::find()->where(['MPH_STAFF_ID' => $self->COOldID])->one();
        $model2 = \app\models\vhrms\ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID, 'MPH_PAY_MONTH' => $gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
        $css = file_get_contents('./css/cetak.css');

        $c = \app\models\vhrms\ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID, 'MPH_PAY_MONTH' => $gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE', 'E'], ['like', 'MPDH_INCOME_CODE', 'B', ['like', 'MPDH_INCOME_CODE', 'F']]])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
        $content = $this->renderPartial('cetak', [ 'model' => $model, 'nd' => $nd,
            'model2' => $model2, 'c' => $c,
            'alamat' => $this->findModelbyicno($icno)
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
            'options' => ['title' => 'Perakuan Hadiah Pergerakan Gaji'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['Perakuan Hadiah Pergerakan Gaji'],
                'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
            ], // call mPDF methods on the fly
        ]);

        return $pdf->render();
    }

    public function actionUpdateBorangTesis($id) {
        $i = Yii::$app->user->getId();
//                $tesis = \app\models\cbelajar\TblDokumen::find()->where(['jenisDokumen'=>5])->all();
        $model = \app\models\cbelajar\TblTuntut::find()->where([ 'id' => $id, 'j_tuntutan' => "TESIS"])->one(); //        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//        $icno = $model->icno;


        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');

//        $model->status_borang = "Complete";
//          $model->status_bsm = 'Admin Manually Upload';
//            $model->status = 'MANUAL UPLOAD';
        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'tesis_cb');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = '';
        }

        if ($file2) {
            $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'cb_Tesis');
            $filepath2 = $fileapi->file_name_hashcode;
        } else {
            $filepath2 = '';
        }


//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->dokumen = $filepath;
            $model->dokumen2 = $filepath2;
            $model->status_semakan = "Updated";
//              $model->pID= $pengajian->id;
            $model->save(false);
            $ntf = new Notification();
            $ntf->icno = 840929125614; // peg  penyelia perjawatan
            $ntf->title = 'Pengajian Lanjutan - Permohonan Tuntutan Elaun Tesis';
            $ntf->content = "Permohonan Tuntutan Elaun Tesis menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakantuntutan'], ['class' => 'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false);
            $this->notifikasi($model->icno, "Permohonan Tuntutan Elaun Tesis anda  telah dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Dokumen Berjaya Dikemaskini']);

            return $this->redirect(['lihat-permohonan-tesis', 'id' => $model->id]);
        }

        return $this->renderAjax('update-borang-tesis', [
                    'model' => $model,
//            'tesis'=>$tesis,
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'lapor' =>$lapor,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionCetakBorangTesis($id) {
        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->one();
        $nd = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'j_tuntutan' => "TESIS"])->all();
        $icno = $model->icno;

        $css = file_get_contents('./css/cetak.css');

        $content = $this->renderPartial('cetak-tesis', [ 'model' => $model, 'nd' => $nd,
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
            'options' => ['title' => 'Perakuan Hadiah Pergerakan Gaji'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['Perakuan Tuntutan Elaun Tesis'],
                'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
            ], // call mPDF methods on the fly
        ]);

        return $pdf->render();
    }
    
     public function actionCetakBorangAkhir($id) {
        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->one();
        $nd = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'j_tuntutan' => "AKHIR"])->all();
        $icno = $model->icno;

        $css = file_get_contents('./css/cetak.css');

        $content = $this->renderPartial('cetak-akhir', [ 'model' => $model, 'nd' => $nd,
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
//            'options' => ['title' => 'Perakuan Hadiah Pergerakan Gaji'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['Perakuan Tuntutan Elaun Akhir Pengajian'],
                'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
            ], // call mPDF methods on the fly
        ]);

        return $pdf->render();
    }

    public function actionCetakLaporDiri($id) {
        $icno = Yii::$app->user->getId();

        $model = TblLapordiri::findOne(['laporID' => $id, 'status_borang' => "Selesai Permohonan"]);
//        $iklan = $this->findIklanbyID($id);

        $biodata = $this->findBiodata1($icno);
        $i = $model->icno;
        $b = $this->findStudy($i);
        $akhir = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 37, 'icno' => $model->icno, 'status_borang' => "Selesai Permohonan"])->one();
        $tesis = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 35, 'icno' => $model->icno, 'status_borang' => "Selesai Permohonan"])->one();
        $hpg = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 30, 'icno' => $model->icno, 'status_borang' => "Selesai Permohonan"])->one();

        $content = $this->renderPartial('cetaklapor', [ 'model' => $model,
            'biodata' => $biodata, 'b' => $b, 'akhir' => $akhir, 'tesis' => $tesis, 'hpg' => $hpg
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
            'options' => ['title' => 'Pemakluman Lapor Diri Kembali Bertugas'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['Pemakluman Lapor Diri Kembali Bertugas'],
                'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
            ], // call mPDF methods on the fly
        ]);

        return $pdf->render();
    }

}
