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

class TuntutanYuranController extends \yii\web\Controller {

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
                'only' => [ 'lihat-permohonan-yuran', 'tuntut', 'view-permohonan-yuran', 'tuntut-tesis', 'tuntut-akhir',
                    'belum-selesai', 'pengesahan-belum-selesai', 'perjawatan', 'pengesahan', 'view-tuntutan-akhir',
                    'view-tuntutan-tesis', 'kgt', 'lihat-permohonan', 'senaraitindakan','tindakan-kj-selesai','tindakan-kj'
                ],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),
                    [
                        'actions' => [ 'lihat-permohonan-yuran', 'tuntut', 'view-permohonan-yuran',
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
                        'actions' => ['senarai-borang',  'lihat-permohonan-yuran', 'tuntut', 'view-permohonan-yuran'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action) {


//                            if((Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jawatan->job_category == "1") || 
//                               (Yii::$app->user->identity->statLantikan == "2"  && Yii::$app->user->identity->jawatan->job_category == "1") ||
//                               (Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jawatan->job_category == "2"))
//                            {
//                                return TRUE;
//                            }
//                           
                    if (in_array(Yii::$app->user->getId(), [ '950829125446','840929125614','870818495847'])) {
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

    

    protected function pendingtask($icno, $id) {
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
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

   

   

   

  
   
    

    
    protected function findBiodata1($id) {
        return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
    }

   
   

    

  

    public function actionTuntut() {
        $icno = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblTuntut();
//                $tesis = \app\models\cbelajar\TblDokumen::find()->where(['jenisDokumen'=>5])->all();
        $tesis = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 46, 'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();

        $model->icno = $icno;
        $lapordiri = TblLapordiri::find()->where(['icno'=>$icno])->orderBy(['dt_lapordiri'=> SORT_DESC])->one();
//        $lapor = new TblLapordiri();
//        $lapor = $this->findLapordiri($icno);
        $model->status_borang = "Selesai Permohonan";
//        $model->idBorang = "CBDN";
        $model->status_bsm = "Tunggu Kelulusan";
        $model->status_semakan = "TUNGGU SEMAKAN";
        $model->tarikh_m = date('Y-m-d H:i:s');
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');

        $checkApplication = \app\models\cbelajar\TblTuntut::find()->where(['idBorang' => 35, 'status' => "LULUS", 'icno' => $model->icno]);
        if ($checkApplication->exists()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['lihat-permohonan-yuran', 'id' => $tesis->id]);
        }
        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'cb_yuran');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = '';
        }
        if ($file2) {
            $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'cb_yuran');
            $filepath2 = $fileapi->file_name_hashcode;
        } else {
            $filepath2 = '';
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->idBorang = "46";
            $model->j_tuntutan = "YURAN";
            $model->agree = 1;
            $model->dokumen = $filepath;
            $model->dokumen2 = $filepath2;

            $model->save(false);
                $this->pendingtask(840929125614, 40);



            $ntf = new Notification();
            $ntf->icno = 840929125614; // peg  penyelia perjawatan
            $ntf->title = 'Pengajian Lanjutan - Permohonan Tuntutan Yuran';
            $ntf->content = "Permohonan Tuntutan Yuran menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakantuntutan'], ['class' => 'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false);
            $this->notifikasi($model->icno, "Permohonan Tuntutan Yuran anda telah dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
            return $this->redirect(['lihat-permohonan-yuran', 'id' => $model->id]); //
        }
        return $this->render('/lapordiri/yuran/_yuran', [
                    'model' => $model,
//                    'lapor' => $lapor,
            'lapordiri'=>$lapordiri,
//              'tesis'=>$tesis,
        ]);
    }

  
    public function actionLihatPermohonanYuran($id) {
        $icno = Yii::$app->user->getId();
//        $lapor = $this->findLapordiri($icno);
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
            return $this->render('/lapordiri/yuran/_lihatpermohonan', [
                        'model' => $model,
//                        'lapor' => $lapor,
                        'edit' => $edit,
                        'view' => $view,
                'lapordiri'=>$lapordiri
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('/cutibelajar/halaman-pemohon');
        }
    }

    public function actionViewTuntutanYuran($id) {
        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->one();

        if (\app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->exists()) {
            if ($model->load(Yii::$app->request->post())) {
                $model->dt_semakan = date('Y-m-d H:i:s');

                if ($model->status_semakan == 'Layak Dipertimbangkan') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Semakan Disimpan!']);
                } elseif ($model->status_semakan == 'Dokumen Tidak Lengkap') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Dokumen Tidak Lengkap', 'type' => 'danger', 'msg' => 'Semakan Disimpan!']);
                }
                $this->notifikasi($model->icno, "Dokumen Permohonan Tuntutan Yura anda tidak lengkap. Sila muatnaik semula dokumen. " . " " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Dihantar', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Semakan Berjaya Disimpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);

                return $this->redirect(['view-tuntutan-yuran', 'id' => $id]);
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
                return $this->render('/lapordiri/yuran/viewtuntutan', [
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

   
   
   
    protected function findModelbyicno($icno) {
        if (($model = \app\models\hronline\Tblrscosalmovemth::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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

        ]);
    }

    public function actionCetakTuntutYuran($id) {
        $model = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'status_borang' => "Selesai Permohonan"])->one();
        $nd = \app\models\cbelajar\TblTuntut::find()->where(['id' => $id, 'j_tuntutan' => "YURAN"])->all();
        $icno = $model->icno;

        $css = file_get_contents('./css/cetak.css');

        $content = $this->renderPartial('/lapordiri/yuran/cetak-yuran', [ 'model' => $model, 'nd' => $nd,
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
            'options' => ['title' => 'Perakuan Tuntutan Yuran'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['Perakuan Tuntutan Yuran Pengajian / Pendaftaran'],
                'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
            ], // call mPDF methods on the fly
        ]);

        return $pdf->render();
    }
    
   

  
}
