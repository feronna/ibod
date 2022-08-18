<?php

//

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\hronline\Tblprcobiodata;
use app\models\cbelajar\TblPermohonan;
use app\models\cbelajar\TblPermohonanSearch;
use app\models\cbelajar\TblUrusMesyuarat;
use app\models\cbelajar\TblBiasiswa;
use app\models\cbelajar\TblPengajian;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Tblpendidikan;
use app\models\cbelajar\TblFilePemohon;
use app\models\cbelajar\TblFileKpm;
use app\models\cbelajar\TblFileLn;
use app\models\cbelajar\TblSurat;
use app\models\TblConfirm;
use app\models\hronline\Department;
use app\models\Notification;
use app\models\cbelajar\TblAdmin;
use app\models\hronline\Tblrscoconfirmstatus;
use yii\web\UploadedFile;
use yii\helpers\Html;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use tebazil\runner\ConsoleCommandRunner;
use app\models\cbelajar\TblpImage;
use app\models\cbelajar\TblAduan;
use app\models\cbelajar\RefStatusAduan;
use app\models\cbelajar\RefKriteria;
use app\models\cbelajar\AksesPa;
class CutibelajarController extends Controller {

    public function behaviors() {
        return

                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['senarai-borang', 'halaman-pemohon', 'view', 'pengakuan-pemohon', 'view-takwim'
                            , 'senarai-borang-lapor', 'page-tuntutan', 'permohonan-semasa', 'index', 'permohonan-semasa',
                            'senarai-staff-fakulti-pp', 'senarai-staff-fakulti','semakan-syarat','semakan-syarat-admin','complain',
                            'record-complain-by-status','record-complain','senarai-permohonan'],
                        'rules' => [
                            [
                                'actions' => ['senarai-borang', 'halaman-pemohon', 'view', 'pengakuan-pemohon',
                                    'view-takwim', 'senarai-borang-lapor', 'page-tuntutan', 'index', 'permohonan-semasa',
                                    'senarai-staff-fakulti-pp', 'senarai-staff-fakulti','semakan-syarat','semakan-syarat-admin','complain',
                            'record-complain-by-status','record-complain','senarai-permohonan'],
                                'allow' => true,
                                'matchCallback' => function($rule, $action) {

//                                                                    $luar = Yii::$app->user->getId();

                            $icno = Yii::$app->user->getId();


                            if ($icno) {
                                $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
//                                var_dump($biodata->statLantikan . ' '.$biodata->jawatan->job_category);
//                                die;
                                if (($biodata->statLantikan == '1' && $biodata->jawatan->job_category == '1') ||
                                        ($biodata->statLantikan == '2' && $biodata->jawatan->job_category == '1') ||
                                         ($biodata->statLantikan == '7' && $biodata->jawatan->job_category == '1') ||
                                        ($biodata->statLantikan == '1' && $biodata->jawatan->job_category == '2') ||
                                        ($biodata->statLantikan == '3' && $biodata->jawatan->job_category == '1') ||
                                         ($biodata->statLantikan == '3' && $biodata->jawatan->job_category == '2')) {
                                    return true;
                                }
                            }




//                           if((Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jobCategory == "1") 
//                           || (Yii::$app->user->identity->statLantikan == "2"  && Yii::$app->user->identity->jobCategory == "1")||
//                                   (Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jobCategory == "2"))
//                          {
//                             return TRUE;
//                           }

                            if (in_array(Yii::$app->user->getId(), ['950829125446', '860130125080', '840929125614', '870818495847'])) {
                                return TRUE;
                            }
// if($luar)
//                            {
//                                $ext = \app\models\system_core\ExternalUser::find()->where(['username'=>$luar])->one();
//                                
//                               if($ext)
//                               {
//                                   return TRUE;
//                               }
//                              
//                            }
//                            return FALSE;
                        },
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

    //Get User IC
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

    protected function notifikasiadmin($icno, $content) {
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

        $confirm = TblConfirm::findOne(['ICNO' => $icno]);

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
        }
        elseif (\app\models\cbelajar\AksesPa::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->redirect(['/cutibelajar/senarai-staff-fakulti-pp']);
        }elseif (($biodata->statLantikan == "1" && $biodata->jawatan->job_category == "1") || ($biodata->statLantikan == "2" && $biodata->jawatan->job_category == "1") || ($biodata->statLantikan == "1" && $biodata->jawatan->job_category == "2") ||
                 ($biodata->statLantikan == '7' && $biodata->jawatan->job_category == '1')
                || ($biodata->statLantikan == "2" && $biodata->jawatan->job_category == "2") || ($biodata->statLantikan == "3" && $biodata->jawatan->job_category == "2")) { //jika user staf lantikan tetap & belum disahkan & staf pentadbiran
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

    //    public function actionHalamanUtamaPemohon(){
    //        
    //        $model = new TblPermohonan();
    //                $biodata = $this->findBiodata();
    //
    ////        $model2 =         $model = $this->findBiodata2($id); 
    //        $icno=Yii::$app->user->getId();
    //        $model->icno = $icno;
    //        $status = TblPermohonan::findAll(['icno' => $icno, 'status_proses'=> "Selesai Permohonan", 'status_study'=>0]); //senarai status permohonan
    //        $searchModel = new TblPermohonanSearch();
    //        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //        $ver = TblPermohonan::findAll(['ver_by' => $icno]);
    //
    //        // if($model->kakitangan->statLantikan== "1" && $model->confirmstatus->ConfirmStatusCd== "1" && $model->kakitangan->jawatan->job_category=="1")
    //        if(($model->kakitangan->statLantikan== "1"  && $model->kakitangan->jawatan->job_category=="1")|| ($model->kakitangan->statLantikan== "2"  && $model->kakitangan->jawatan->job_category=="1")) { //jika user staf lantikan tetap & staf akademik
    //        return $this->render('main-pemohon', 
    //        ['model' => $model, 'status' => $status,
    //            'searchModel' => $searchModel,
    //            'dataProvider' => $dataProvider,
    //            'biodata'=> $biodata,
    //            'ver' => $ver,
    //            'bil' => 1,
    //            'icno' => $icno
    //                    
    //        ]);
    //        }
    ////        else{
    ////        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
    ////        return $this->redirect('index');}
    //    }
    public function actionViewTakwim() {
        $model = new TblPermohonan();
        $icno = Yii::$app->user->getId();
        $model->icno = $icno;

        // if($model->kakitangan->statLantikan== "1" && $model->confirmstatus->ConfirmStatusCd== "1" && $model->kakitangan->jawatan->job_category=="1")
        //        if($model->kakitangan->jawatan->job_category =="1")
        //        {
        
//       if($model->kakitangan->ICNO == "900615125349" ||
//          ($model->kakitangan->statLantikan == "3" && $model->kakitangan->jawatan->job_category == "2") || ($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "2"))
//       {
//            if(in_array($model->kakitangan->ICNO,['771118125171']) || ($model->kakitangan->statLantikan == "3" && $model->kakitangan->jawatan->job_category == "2") || ($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "2"))
//            {
        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "2" && $model->kakitangan->jawatan->job_category == "1")||  ($model->kakitangan->statLantikan == '7' && $model->kakitangan->jawatan->job_category == '1') || ($model->kakitangan->statLantikan == "3" && $model->kakitangan->jawatan->job_category == "2") || ($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "2")) { //jika user staf lantikan tetap & staf akademik
            return $this->render(
                            'view-takwim', [
                        'model' => $model,
                        'bil' => 1,
                        'icno' => $icno
                            ]
            );
        }
   
        //}
        //        elseif ($model->kakitangan->jawatan->job_category =="2")
        //        {
        //          if(($model->kakitangan->statLantikan== "2"  && $model->kakitangan->jawatan->job_category=="1")&& ($model->kakitangan->statLantikan== "3"  && $model->kakitangan->jawatan->job_category=="2")||  ($model->kakitangan->statLantikan== "1"  && $model->kakitangan->jawatan->job_category=="2")) { //jika user staf lantikan tetap & staf akademik
        ////        $urus = app\models\cbelajar\TblUrusMesyuarat::find()->where(['status' => 1, 'kategori_id'=>1]);
        //        return $this->render('view-takwim', 
        //        ['model' => $model, 
        //            'urus'=>$urus,
        //            'bil' => 1,
        //            'icno' => $icno
        //                    
        //        ]);
        //        }  
        //        }
        else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan Telah Ditutup']);
            return $this->redirect('index');
        }
    }

    public function actionHalamankj() {
        $icno = Yii::$app->user->getId();
        if (Department::find()->where(['chief' => $icno, 'isActive' => '1'])->exists()) {
            return $this->render('main-kj');
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionPilihSemakan() {

        $icno = Yii::$app->user->getId();

        //    $model = new Kemudahan();
        $searchModel = new TblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = TblPermohonan::find()->all();

        return $this->render('_pilihsemakan', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'bil' => 1,
        ]);
    }

    public function actionPemohonview($id) {
        $id = $id;
        $biodata = $this->findMaklumat1($id);
        $model = $this->findBiodata2($id);

        if ($biodata) {
            return $this->render('view_1', [
                        'model' => $model,
                        'akademik' => $biodata->akademik,
                        'pengajian' => $biodata->pengajian,
                        'penerbangan' => $biodata->penerbangan,
                        'lain' => $biodata->lain,
                        'lapor' => $biodata->lapor,
                        'lkk' => $biodata->lkk,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda Tidak Mempunyai Rekod']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    public function findBiodata1($ICNO) {
        //        $encryptID = 'SELECT * FROM hronline.tblprcobiodata WHERE SHA1(ICNO) =:icno';
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }

    //         protected function findMaklumat1($id) {
    //        return \app\models\cbelajar\TblPermohonan::findOne(['icno' => $id]);
    //    }
    //     
    public function findBon($ICNO) {
        //        $encryptID = 'SELECT * FROM cbelajar.tbl_bon WHERE SHA1(icno) =:icno';
        return \app\models\cbelajar\TblBon::findAll(['icno' => $ICNO]);

        //        return \app\models\cbelajar\TblBon::findBySql($encryptID, [':icno' => $ICNO])->all();
    }

    public function findNd($ICNO) {
        return \app\models\cbelajar\TblLapordiri::findAll(['icno' => $ICNO]);
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

    protected function findWajib($dokumen) {
        $model = TblFilePemohon::findOne(['uploaded_by' => $this->ICNO(), 'dokumenCd' => $dokumen]);

        if ($model) {
            return $model;
        } else {
            return null;
        }
    }

    public function actionPengakuanPemohon($id) {
        $icno = Yii::$app->user->getId();
        $pengajian = TblPengajian::find()->where(['icno' => $this->ICNO(), 'iklan_id' => $id, 'idBorang' => 1, 'status' => [1, 9]])->all();
        $biasiswa = TblBiasiswa::findAll(['icno' => $this->ICNO(), 'iklan_id' => $id, 'idBorang' => 1]);
        $status = TblPermohonan::findAll(['icno' => $icno]); //senarai status permohonan
//        $model = TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() ? TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() : new TblPermohonan();
        $model = TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() ? TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() : new TblPermohonan();

        $pengajian2 = TblPengajian::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1, 'status' => [1, 9]])->one() ? TblPengajian::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1, 'status' => [1, 9]])->one() : new TblPengajian();
//        $sponsor2 = TblBiasiswa::find()->
//           where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1, 'status' => [1, 9]])->all() ?
//                TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1, 'status' => [1, 9]])
//                        ->all() : new TblBiasiswa();
        $sponsor2 = TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->all() ?
                TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->all() :
                new TblBiasiswa();
        $ums = TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1, 'jenisCd' => 2])->all() ?
                TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1, 'jenisCd' => 2])->all() :
                new TblBiasiswa();
        $kpm = \app\models\cbelajar\TblFileKpm::find()->where(['uploaded_by' => $this->ICNO(), 'iklan_id' => $id, 'idBorang' => 1])->all();
        $sokongan = \app\models\cbelajar\TblFilePemohon::find()->where(['uploaded_by' => $this->ICNO(),
                    'iklan_id' => $id, 'idBorang' => 1])->all();
        $ln = \app\models\cbelajar\TblFileLn::find()->where(['uploaded_by' => $this->ICNO(), 'iklan_id' => $id, 'idBorang' => 1])->all();
        $doktoral = \app\models\cbelajar\TblDokumen::find()->WHERE(['kategori' => 1])->all();
        $wajib = TblFilePemohon::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id, 'idBorang' => 1])
                        ->all() ? TblFilePemohon::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id])->all() : new TblFilePemohon();
        $kpt = TblFileKpm::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->all() ? TblFileKpm::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id])->all() : new TblFileKpm();
        $luar = TblFileLn::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->all() ? TblFileLn::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id])->all() : new TblFileLn();
        $senarai_dokumen = $this->findDokumen(1);
        $senarai_dokumenkpm = $this->findDokumenKpm(1);
        $senarai_dokumenln = $this->findDokumenLn(1);
        $dok = $this->findWajib(5);
        $check = TblpImage::findOne(['ICNO' => $this->ICNO(), 'iklan_id' => $id]);

        $checkb = TblBiasiswa::find()->where(['icno' => $this->ICNO(), 'iklan_id' => $id])->one();
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
            $model->idBorang = 1;
            $model->created_at = new \yii\db\Expression('NOW()');
            $model->save(false);
            $pengajian2->idPermohonan = $model->id;
            $pengajian2->by = "ONLINE";

            $pengajian2->save(false);

//        
//                foreach ($sponsor2 as $sponsor2) {
//                    $sponsor2->idPermohonan = $model->id;
//                    $sponsor2->HighestEduLevelCd = $pengajian2->HighestEduLevelCd;
//                    $sponsor2->save(false);
//                }
//
//            foreach ($sponsor2 as $sponsor2) {
////                $sponsor2 = new \stdClass();
//                $sponsor2->idPermohonan = $model->id;
//                $sponsor2->HighestEduLevelCd = $pengajian2->HighestEduLevelCd;
//                $sponsor2->save(false);
////                $sponsor2->success = false;
////                $ln = \app\models\cbelajar\TblFileLn::find()->where(['id' => $l->id])->one();
////                    $luar->idPermohonan = $model->id;
////                    $luar->save(false);
//            }

            foreach ($ums as $ums) {
                $ums = new \stdClass();
                $ums->idPermohonan = $model->id;
                $ums->success = false;

//                    $ums->save(false);
            }


            foreach ($kpt as $kpt) {
                $kpt = new \stdClass();
                $kpt->idPermohonan = $model->id;
                $kpt->success = false;
//                $ln = \app\models\cbelajar\TblFileLn::find()->where(['id' => $l->id])->one();
//                    $luar->idPermohonan = $model->id;
//                    $luar->save(false);
            }

            foreach ($wajib as $wajib) {
//                $sokongan = \app\models\cbelajar\TblFilePemohon::find()->where(['id' => $s->id])->one();
                $wajib->idPermohonan = $model->id;

                $wajib->save(false);
            }



            foreach ($luar as $luar) {
                $luar = new \stdClass();
                $luar->idPermohonan = $model->id;
                $luar->success = false;
//                $ln = \app\models\cbelajar\TblFileLn::find()->where(['id' => $l->id])->one();
//                    $luar->idPermohonan = $model->id;
//                    $luar->save(false);
            }

            //                    $ln->idPermohonan = $model->id;
            //                    $ln->save(false);

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
                        $model->idBorang = 1;
                        $model->jenis = "SEPENUH MASA";
                        $model->save(false);
                        $pengajian2->idPermohonan = $model->id;
                        $pengajian2->by = "ONLINE";
                        $pengajian2->status_proses = "H";
                        $pengajian2->save(false);
//            $sponsor2->idPermohonan = $model->id;
//            $sponsor2->HighestEduLevelCd = $pengajian2->HighestEduLevelCd;
//            $sponsor2->save(false);
//            $ums->idPermohonan = $model->id;
//            $ums->save(false);
                        foreach ($sponsor2 as $sponsor2) {
//                $sponsor2 = new \stdClass();
                            $sponsor2->idPermohonan = $model->id;
                            $sponsor2->HighestEduLevelCd = $pengajian2->HighestEduLevelCd;
                            $sponsor2->save(false);
//                $sponsor2->success = false;
                        }

                        foreach ($ums as $ums) {
                            $ums = new \stdClass();
                            $ums->idPermohonan = $model->id;
                            $ums->success = false;
//                $ln = \app\models\cbelajar\TblFileLn::find()->where(['id' => $l->id])->one();
//                    $luar->idPermohonan = $model->id;
//                    $luar->save(false);
                        }
                        //                    $dokumen->idPermohonan = $model->id;
                        //                    $dokumen->save(false);
                        foreach ($kpt as $kpt) {
                            $kpt = new \stdClass();
                            $kpt->idPermohonan = $model->id;
                            $kpt->success = false;
//                $ln = \app\models\cbelajar\TblFileLn::find()->where(['id' => $l->id])->one();
//                    $luar->idPermohonan = $model->id;
//                    $luar->save(false);
                        }
                        foreach ($wajib as $wajib) {
//                $wajib = new \stdClass();
                            $wajib->idPermohonan = $model->id;
                            $wajib->save(false);
//                $ln = \app\models\cbelajar\TblFileLn::find()->where(['id' => $l->id])->one();
//                    $luar->idPermohonan = $model->id;
//                    $luar->save(false);
                        }
                        foreach ($luar as $luar) {
                            $luar = new \stdClass();
                            $luar->idPermohonan = $model->id;
                            $luar->success = false;
//                $ln = \app\models\cbelajar\TblFileLn::find()->where(['id' => $l->id])->one();
//                    $luar->idPermohonan = $model->id;
//                    $luar->save(false);
                        }



                        //}
                    } else {
                        Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => ''
                            . 'Sila muat naik dokumen wajib sebelum menghantar permohonan. Abaikan dokumen wajib yang berkaitan PHD, jika bukan '
                            . 'memohon peringkat pengajian tersebut']);
                        return $this->redirect(['cbelajar/senarai-dokumen?id=' . $id]);
                    }
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => ''
                        . 'Sila isi maklumat pembiayaan/pinjaman, jika tanpa tajaan, sila pilih pilihan tanpa tajaan.']);
                    return $this->redirect(['cbelajar/maklumat-biasiswa?id=' . $id]);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => ''
                    . 'Sila muatnaik gambar anda']);
                return $this->redirect(['cbelajar/gambar?id=' . $id]);
            }
            $this->pendingtask($icnopetindak1, 11);
            $this->notifikasi($icnopetindak1, "Permohonan Pengajian Lanjutan  menunggu tindakan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutisabatikal/senaraitindakan'], ['class' => 'btn btn-primary btn-sm']));
            $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan " . $petindak1 . " " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));

            Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Diterima', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
            return $this->redirect(['lihat-permohonan', 'id' => $model->id]); //
        }



        if ($model->agree == '1' || $model->status_proses == 'Data Disimpan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        if (TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1, 'status_proses' => "Selesai Permohonan"])->exists()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah Memohon!', 'type' => 'error', 'msg' => 'Permohonan hanya boleh dibuat sekali sahaja.']);
            return $this->redirect(['lihat-permohonan', 'id' => $iklan->id]); //
        }
        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "2" && $model->kakitangan->jawatan->job_category == "1")) {
            return $this->render(
                            'form_pengakuan', [
                        'iklan' => $iklan,
                        'model' => $model,
                        'img' => $biodata->img,
                        'biodata' => $biodata,
                        'akademik' => $this->findAkademikbyICNO(),
                        'pengajian' => $pengajian,
                        'biasiswa' => $biasiswa,
                        'edit' => $edit,
                        'view' => $view,
                        'status' => $status,
                        'kpm' => $kpm,
                        'sokongan' => $sokongan,
                        'ln' => $ln,
                        'doktoral' => $doktoral,
                        'icno' => $icno, 'senarai_dokumen' => $senarai_dokumen,
                        'senarai_dokumenkpm' => $senarai_dokumenkpm,
                        'senarai_dokumenln' => $senarai_dokumenln, 'icno' => $icno
                            ]
            );
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-pemohon');
        }
    }

    protected function pendingtask($icno, $id) {
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }

    public function actionPengakuanPemohonSm($id) {
        $icno = Yii::$app->user->getId();
        $pengajian = TblPengajian::find()->where(['icno' => $this->ICNO(), 'iklan_id' => $id, 'idBorang' => 38, 'status' => [1, 9]])->all();
        $biasiswa = TblBiasiswa::findAll(['icno' => $this->ICNO(), 'iklan_id' => $id, 'idBorang' => 38]);
        $status = TblPermohonan::findAll(['icno' => $icno]); //senarai status permohonan
        $model = TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 38])->one() ? TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 38])->one() : new TblPermohonan();
        $pengajian2 = TblPengajian::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 38, 'status' => [1, 9]])->one() ? TblPengajian::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 38, 'status' => [1, 9]])->one() : new TblPengajian();
        $sponsor2 = TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 38, 'status' => [1, 9]])->one() ? TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 38, 'status' => [1, 9]])->one() : new TblBiasiswa();
        $ums = TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 38, 'jenisCd' => 2])->one() ? TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 38, 'jenisCd' => 2])->one() : new TblBiasiswa();
        $sokongan = \app\models\cbelajar\TblFilePemohon::find()->where(['uploaded_by' => $this->ICNO(), 'iklan_id' => $id, 'idBorang' => 38])->all();
        $doktoral = \app\models\cbelajar\TblDokumen::find()->WHERE(['kategori' => 1])->all();
        $senarai_dokumen = $this->findDokumensm(1);
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
            $model->idBorang = 1;
            $model->created_at = new \yii\db\Expression('NOW()');
            $model->save(false);
            $pengajian2->idPermohonan = $model->id;
            $pengajian2->by = "ONLINE";
            $pengajian2->save(false);

            $sponsor2->idPermohonan = $model->id;
            $sponsor2->save(false);
            $ums->idPermohonan = $model->id;
            $ums->save(false);

            foreach ($sokongan as $s) {
                $sokongan = \app\models\cbelajar\TblFilePemohon::find()->where(['id' => $s->id])->one();
                $sokongan->idPermohonan = $model->id;
                $sokongan->save(false);
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Disimpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['pengakuan-pemohon', 'id' => $id]);
        } elseif ($model->load(Yii::$app->request->post())) {

            $model->jenis_user_id = 1;
            $model->status_proses = "Selesai Permohonan";
            $model->created_at = new \yii\db\Expression('NOW()');
            $model->agree = 1;
            $model->idBorang = 38;
            $model->jenis = "SEPARUH MASA";
            $model->save(false);
            $pengajian2->idPermohonan = $model->id;
            $pengajian2->by = "ONLINE";
            $pengajian2->save(false);
            $sponsor2->idPermohonan = $model->id;
            $sponsor2->HighestEduLevelCd = $pengajian2->HighestEduLevelCd;
            $sponsor2->save(false);

            $ums->idPermohonan = $model->id;
            $ums->save(false);
            $this->pendingtask($icnopetindak1, 1);
            $this->notifikasi($icnopetindak1, "Permohonan Pengajian Lanjutan  menunggu tindakan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutisabatikal/senaraitindakan'], ['class' => 'btn btn-primary btn-sm']));
            $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan " . $petindak1 . " " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));

            Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Diterima', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
            return $this->redirect(['lihat-permohonan-sm', 'id' => $model->id]); //
        }

        if ($model->agree == '1' || $model->status_proses == 'Data Disimpan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        if (TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1, 'status_proses' => "Selesai Permohonan"])->exists()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah Memohon!', 'type' => 'error', 'msg' => 'Permohonan hanya boleh dibuat sekali sahaja.']);
            return $this->redirect(['lihat-permohonan-sm', 'id' => $iklan->id]); //
        }
        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "2" && $model->kakitangan->jawatan->job_category == "1")) {
            return $this->render(
                            'form_pengakuan_sm', [
                        'iklan' => $iklan,
                        'model' => $model,
                        'img' => $biodata->img,
                        'biodata' => $biodata,
                        'akademik' => $this->findAkademikbyICNO(),
                        'pengajian' => $pengajian,
                        'biasiswa' => $biasiswa,
                        'edit' => $edit,
                        'view' => $view,
                        'status' => $status,
                        'sokongan' => $sokongan,
                        'doktoral' => $doktoral,
                        'icno' => $icno, 'senarai_dokumen' => $senarai_dokumen,
                            ]
            );
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-pemohon');
        }
    }

    public function findDokumenKpm($status) {
        $senarai_dokumenkpm = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblDokumenKpm::find()->where(['status' => $status, 'kategori' => 1]),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumenkpm;
    }

    public function findDokumen($status) {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblDokumen::find()->where(['status' => $status, 'kategori' => 1]),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }

    public function findDokumensm($status) {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblDokumen::find()->where(['status' => $status, 'kategori' => 4]),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }

    public function findBon2($id) {
        return \app\models\cbelajar\Tblbonkhidmat::findAll(['icno' => $id]);
    }

    public function findT($id) {
        return \app\models\cbelajar\TblTuntutan::findAll(['icno' => $id]);
    }

    protected function findS($id) {
        return \app\models\cbelajar\TblBiasiswa::find(['id' => $id, 'status' => 1])->all();
    }

    protected function findA($id) {
        return \app\models\cbelajar\TblElaun::findAll(['bID' => $id]);
    }

    public function actionViewRekod() {
        $id = Yii::$app->user->getId();
        $biodata = $this->findBiodata1($id);
        //            $rekod= $this->findRekod($id);
        $bon = $this->findBon($id);
        $bon1 = $this->findBon2($id);
        $pengajian = $this->findPengajian4($id);
        $lkk = $this->findLkk($id);
        $tuntut = $this->findT($id);
        $b = $this->findS($id);
        $nd = $this->findNd($id);
        //            $pengajian = TblPengajian::find()->where(['icno'=> $id])->all();


        return $this->render('main', [
                    'biodata' => $biodata,
                    'lkk' => $lkk,
                    'bon' => $bon,
                    'pengajian' => $pengajian,
                    'bon1' => $bon1,
                    'tuntut' => $tuntut,
                    'b' => $b,
                    'nd' => $nd,
        ]);
    }
    public function actionRingkasan($id) {
        $icno = Yii::$app->user->getId();

        $b = $this->findStudy($id);
        $pengajian = $this->findPengajian($icno);
        $test = $this->findBiasiswa($icno);
        return $this->renderAjax('_ringkasan', [
                    'b' => $b,
            'id'=>$id,'pengajian'=>$pengajian,'test'=>$test
                   
                   
        ]);
    }
  protected function findStudy($id) {
        return \app\models\cbelajar\TblPengajian::findOne(['id' => $id]);
    }
      protected function findBiasiswa($id) {
        return \app\models\cbelajar\TblBiasiswa::findOne(['id' => $id]);
    }
    public function actionSenaraiBorangLapor() {
        $id = Yii::$app->user->getId();
        $biodata = $this->findBiodata1($id);
        //            $rekod= $this->findRekod($id);
        $bon = $this->findBon($id);
        $bon1 = $this->findBon2($id);
        $pengajian = $this->findPengajian4($id);
        $lkk = $this->findLkk($id);
        $tuntut = $this->findT($id);
        $b = $this->findS($id);
        $nd = $this->findNd($id);
        //            $pengajian = TblPengajian::find()->where(['icno'=> $id])->all();
        $stu = TblPengajian::find()->where(['status' => 1, "icno" => $id])->orderBy(['tarikh_mula' => SORT_DESC])->all();
        $stuold = TblPengajian::find()->where(['status' => 2, "icno" => $id])->orderBy(['tarikh_mula' => SORT_DESC])->one();

        $lapordiri = \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $id, 'status_borang' => "Selesai Permohonan", 'status_a' => "DALAM PROSES"])->orderBy(['tarikh_mohon' => SORT_DESC])->all();
//        $lapordirimanual = \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $id,'HighestEduLevelCd'=>$stuold->HighestEduLevelCd])->all();

        return $this->render('rekod_pengajian', [
                    'biodata' => $biodata,
                    'lkk' => $lkk,
                    'bon' => $bon,
                    'pengajian' => $pengajian,
                    'bon1' => $bon1,
                    'tuntut' => $tuntut,
                    'b' => $b, 'stu' => $stu,
                    'nd' => $nd,
                    'lapordiri' => $lapordiri,
//            'lapordirimanual'=>$lapordirimanual,
        ]);
    }

    public function findNominal($id) {

        //        $encryptID = 'SELECT * FROM hrd.cb_tbl_lapordiri WHERE SHA1(icno) =:icno';
        return \app\models\cbelajar\TblLapordiri::findOne(['icno' => $id]);
    }

    public function actionRekodBon() {
        $id = Yii::$app->user->getId();
        $bon = $this->findBon($id);
        $nd = $this->findNd($id);
        //            $pengajian = TblPengajian::find()->where(['icno'=> $id])->all();


        return $this->render('_bon', [
                    'bon' => $bon,
                    'nd' => $nd,
        ]);
    }

    protected function findLkk($id) {
        return \app\models\cbelajar\TblLkk::findAll(['icno' => $id]);
    }

    
    protected function findPengajian($ICNO) {
        //         $encryptID = 'SELECT * FROM cbelajar.tbl_pengajian WHERE SHA1(icno) =:icno';
        return TblPengajian::find()->where(['icno' => $ICNO, 'status' => [1, 2, "NULL"]])->one();
        //        return \app\models\cbelajar\RekodCb::find()->where([SHA1('icno') =>$id])->one();
    }

    protected function findPengajian4($id) {
        return \app\models\cbelajar\TblPengajian::find()->where(['icno' => $id, 'status' => [1, 2, 4, 6, 5,11]])->all();
    }

    public function actionPageTuntutan() {

        $icno = Yii::$app->user->getId();

        return $this->render('page-data');
    }

    public function actionPageLapor() {

        $icno = Yii::$app->user->getId();

        return $this->render('page-lapor');
    }

    public function actionDaftarPengajianLanjutan() {
        //        $admin = \app\models\hronline\Tblprcobiodata::find()->All();
        $permohonan = new TblPermohonan();
        $pengajian = new TblPengajian();
        $biasiswa = new TblBiasiswa();
        //        $model = Tblprcobiodata::findOne(['ICNO'=>$icno]);
        if ($permohonan->load(Yii::$app->request->post()) && $biasiswa->load(Yii::$app->request->post()) && $pengajian->load(Yii::$app->request->post())) {

            $permohonan->icno;
            $permohonan->iklan_id;
            $pengajian->iklan_id = $permohonan->iklan_id;
            $pengajian->icno = $permohonan->icno;
            $pengajian->InstNm;
            $pengajian->negara;
            $pengajian->HighestEduLevelCd;
            $pengajian->MajorCd;
            $pengajian->tarikh_mula;
            $pengajian->tarikh_tamat;
            $pengajian->nama_penyelia;
            $pengajian->tajuk_tesis;
            $biasiswa->icno = $permohonan->icno;
            $biasiswa->iklan_id = $permohonan->iklan_id;
            $biasiswa->nama_tajaan;
            $biasiswa->jenisCd;
            $biasiswa->bentukBantuan;
            $biasiswa->amaunBantuan;
            $permohonan->save(false);
            $pengajian->save(false);
            $biasiswa->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['cbadmin/page-semak']);
        }

        return $this->render('daftar_cutibelajar', [

                    'permohonan' => $permohonan,
                    'pengajian' => $pengajian,
                    'biasiswa' => $biasiswa,
                    'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
        ]);
    }

    public function actionSenaraiPemohon($DeptId) {
        $icno = Yii::$app->user->getId();
        $title = '';
        $fac = \app\models\hronline\Department::find()->where(['category_id' => 1, 'dept_cat_id' => ['2', '4']])->orWhere(['id' => ['15', '104']])->orderBy(['shortname' => SORT_ASC])->all();
        $models = \app\models\cbelajar\TblPermohonan::find()->where(['status_proses' => "Selesai Permohonan", 'DeptId' => $fac])->all();
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke' => SORT_DESC])->limit(1)->one();
        $senarai = '';
        $status = ['Tunggu Kelulusan', 'Diluluskan', 'Tidak Diluluskan'];
        $selection = (array) Yii::$app->request->post('selection'); //typecasting

        if (Yii::$app->request->post('simpan')) {

            foreach ($models as $data) {
                if ('y' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = $this->findModelCB($data->id);
                    $model->status_bsm = 'Draft Diluluskan';
                    $model->save(false);
                    //                    return $this->redirect('index');
                } elseif ('n' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = $this->findModelCB($data->id);
                    $model->status_bsm = 'Draft Ditolak';
                    $model->save(false);
                }
            }
        } elseif (Yii::$app->request->post('hantar')) {
            foreach ($selection as $id) {
                $hantar = $this->findModelCB($id); //make a typecasting
                if ('n' . $hantar->id == Yii::$app->request->post($hantar->id)) {
                    $hantar->status = 'TIDAK LULUS';
                    $hantar->status_bsm = 'Tidak Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');

                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan anda tidak berjaya." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                } elseif ('y' . $hantar->id == Yii::$app->request->post($hantar->id)) {
                    $hantar->status = 'LULUS';
                    $hantar->status_bsm = 'Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');
                    $hantar->ver_by = $icno;
                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan anda berjaya." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                }
                $hantar->save(false);
            }
        }
        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            $senarai = \app\models\cbelajar\TblPermohonan::find()->where(['status_proses' => "Selesai Permohonan", 'DeptId' => $DeptId])->orderBy(['tarikh_m' => SORT_DESC]);
            $title = 'Senarai Menunggu Semakan';
        }

        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if ($title != NULL) {
            return $this->render('senarai_tindakan_1', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
                        'tmp' => $tmp,
                        'fac' => $fac
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['index']);
        }
    }

    protected function findPengajian1($id) {
        return \app\models\cbelajar\TblPengajian::findOne(['icno' => $id]);
    }

    protected function findElaun($id) {
        return \app\models\cbelajar\TblElaun::findAll(['icno' => $id]);
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

    public function actionViewLedger() {
        $id = Yii::$app->user->getId();

        $biodata = $this->findBiodata1($id);
        $pengajian = $this->findPengajian1($id);
        $elaun = $this->findElaun($id);
        $self = Tblprcobiodata::findOne(['ICNO' => $id]);
        $gaji = $this->gaji();

        //            $b=$this->findBiasiswa($id);
        $MPH_STAFF_ID = \app\models\vhrms\ViewPayroll::find()->where(['MPH_STAFF_ID' => $self->COOldID])->one();
        $model2 = \app\models\vhrms\ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID, 'MPH_PAY_MONTH' => $gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();

        $c = \app\models\vhrms\ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID, 'MPH_PAY_MONTH' => $gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE', 'E'], ['like', 'MPDH_INCOME_CODE', 'B', ['like', 'MPDH_INCOME_CODE', 'F']]])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();

        //            $pengajian = TblPengajian::find()->where(['icno'=> $id])->all();


        return $this->render('main-ledger', [
                    'biodata' => $biodata,
                    //                    'pengajian' => $biodata->pengajian,
                    'pengajian' => $pengajian,
                    'elaun' => $elaun,
                    'c' => $c,
                        //            'b'=>$b
        ]);
    }

    public function actionLihatrekod() {

        return $this->render('lihatrekod', [

                    'model' => $this->findData(1),
                        //            'iklan' => $this->findIklanbyID($model->iklan_id),
        ]);
    }

    protected function findData() {
        if (($model = \app\models\cbelajar\RekodCb::findOne(['id' => 1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionLihatPermohonan($id) {
        $model = new TblPermohonan();
        $icno = Yii::$app->user->getId();
        $model->icno = $icno;
        $model2 = TblPermohonan::find()->where(['icno' => $icno, 'idBorang' => 2])->one();
        $model3 = TblPermohonan::find()->where(['icno' => $icno, 'idBorang' => 1])->one(); //senarai status permohonan
        //senarai status permohonan
        $biodata = $this->findBiodata();
        $pengajian = TblPengajian::findAll(['icno' => $icno, 'idPermohonan' => $id, 'idBorang' => 1]);
        $biasiswa = TblBiasiswa::find()->where(['icno' => $icno, 'idBorang' => 1])->all();
        $dokumen = TblFilePemohon::find()->where(['uploaded_by' => $icno, 'idBorang' => 1])->all();
        $dokumen2 = \app\models\cbelajar\TblFileKpm::find()->where(['uploaded_by' => $icno, 'idBorang' => 1])->all();
        $dokumen3 = \app\models\cbelajar\TblFileLn::find()->where(['uploaded_by' => $icno, 'idBorang' => 1])->all();
        //        $iklan = $this->findIklanbyID($id);
 if($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none';$edit = '';}  
        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "2" && $model->kakitangan->jawatan->job_category == "1")) {
            if (TblPermohonan::find()->where(['icno' => $icno, 'id' => $id, 'status_proses' => "Selesai Permohonan"])->exists()) {
                return $this->render(
                                'lihatpermohonan', [
                            //              'iklan' => $iklan,
                            'model' => $model,
                            'img' => $biodata->img,
                            'biodata' => $biodata,
                            'akademik' => $biodata->akademik,
                            'keluarga' => $biodata->keluarga,
                            'biasiswa' => $biasiswa,
                            'dokumen' => $dokumen,
                            'dokumen2' => $dokumen2,
                            'dokumen3' => $dokumen3,
                            'pengajian' => $pengajian,
                            'model2' => $model2,
                            'model3' => $model3,
                                    'view'=>$view,
                                ]
                );
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('/cutibelajar/halaman-pemohon');
        }
    }

    public function actionLihatPermohonanSm($id) {
        $model = new TblPermohonan();
        $icno = Yii::$app->user->getId();
        $model->icno = $icno;
        $model2 = TblPermohonan::find()->where(['icno' => $icno, 'idBorang' => 2])->one();
        $model3 = TblPermohonan::find()->where(['icno' => $icno, 'idBorang' => 38])->one(); //senarai status permohonan
        //senarai status permohonan
        $biodata = $this->findBiodata();
        $pengajian = TblPengajian::findAll(['icno' => $icno, 'idPermohonan' => $id, 'idBorang' => 38]);
        $biasiswa = TblBiasiswa::find()->where(['icno' => $icno, 'idBorang' => 38])->all();
        $dokumen = TblFilePemohon::find()->where(['uploaded_by' => $icno, 'idBorang' => 38])->all();

        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "1") || ($model->kakitangan->statLantikan == "2" && $model->kakitangan->jawatan->job_category == "1")) {
            if (TblPermohonan::find()->where(['icno' => $icno, 'id' => $id, 'status_proses' => "Selesai Permohonan"])->exists()) {
                return $this->render(
                                'lihatpermohonansm', [
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
                                ]
                );
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-pemohon');
        }
    }

    protected function findInfoPengajian($id) {
        $model = TblPengajian::findOne(['icno' => $this->ICNO(), 'id' => $id]);

        if ($model) {
            return $model;
        } else {
            return null;
        }
    }

    public function actionSemakMaklumat() {
        $model = new TblPermohonan();
        $icno = Yii::$app->user->getId();
        $model->icno = $icno;
        $model->tarikh_m = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $biodata = $this->findBiodata();

        $statuss = $this->findPerkhidmatanbyICNO();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->agree == 0) {
                Yii::$app->session->setFlash('alert', ['title' => 'Amaran !', 'type' => 'error', 'msg' => 'Sila tanda kotak semak permohonan.']);
                return $this->redirect(['semak-maklumat']);
            } else {
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Disimpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                return $this->redirect(['permohonan-semasa']);
            }
        }
        return $this->render(
                        'semak_maklumat', [
                    'model' => $model,
                    'img' => $biodata->img,
                    'biodata' => $biodata,
                    'keluarga' => $this->findKeluargabyICNO(),
                    'akademik' => $this->findAkademikbyICNO(),
                    'pengajian' => $this->findPengajianbyICNO(),
                    'biasiswa' => $this->findBiasiswabyICNO(),
                    'dokumen' => $this->findDokumenbyICNO(),
                    'statuss' => $statuss,
                        ]
        );
    }

    protected function findPerkhidmatanbyICNO() {
        if (($model = Tblrscoconfirmstatus::findAll(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }
    }

    public function actionPermohonanSemasa() {
        $model = new TblPermohonan();
        $icno = Yii::$app->user->getId();
        $model->icno = $icno;
        //        $status = TblPermohonan::findAll(['icno' => $icno]); //senarai status permohonan
        $status = TblPermohonan::find()->where(['icno' => $icno, 'status_proses' => "Selesai Permohonan", 'idBorang' => [1, 2, 38,39,41,40,41,42,43,32,44,51]])->all();
        $statuslanjutan = \app\models\cbelajar\TblLanjutan::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan", 'idBorang' => 3])->all();
        $statuslain = \app\models\cbelajar\TblLain::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
        $lapordiri = \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan", 'agree' => 1])->all();
        $statustiket = \app\models\cbelajar\BorangPenerbangan::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
        $statustuntut = \app\models\cbelajar\TblTuntut::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan", 'idBorang' => [30, 35, 37,46,50,52,53]])->all();

        $searchModel = new TblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $model = TblPermohonan::find()->where(['icno' => $icno])->orderBy([ 'status' => SORT_ASC])->all();
        //        $ver = TblPermohonan::findAll(['ver_by' => $icno]);
        $ver = TblPermohonan::find()->where(['ver_by' => $icno, 'status_proses' => "Selesai Permohonan"])->orderBy(['tarikh_m' => SORT_DESC]);

        return $this->render('view_permohonan', [
                    'model' => $model,
                    'status' => $status,
                    'statustiket' => $statustiket,
                    'statuslanjutan' => $statuslanjutan,
                    'statuslain' => $statuslain,
                    'lapordiri' => $lapordiri,
                    'statustuntut' => $statustuntut,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'ver' => $ver,
                    'bil' => 1,
        ]);
    }

    public function actionRekodBaru() {

        $model = new TblPermohonan();
        $icno = Yii::$app->user->getId();
        $model->icno = $icno;
        //        $status = TblPermohonan::findAll(['icno' => $icno]); //senarai status permohonan
        $status = TblPermohonan::find()->where(['icno' => $icno, 'status_proses' => "Selesai Permohonan", 'idBorang' => 1])->all();
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

    public function actionRekodPermohonan() {
        $icno = Yii::$app->user->getId();

        $model = new TblPermohonan();
        $searchModel = new TblPermohonanSearch();
        $model->tarikh_m = date('Y-m-d H:i:s');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $status = ['DILULUSKAN', 'MENUNGGU TINDAKAN', 'TIDAK DILULUSKAN'];


        $query1 = (new \yii\db\Query())
                ->select("idBorang, tarikh_m, icno, status_jfpiu, status_bsm, id")
                ->from('hrd.cb_tbl_permohonan')
                ->where(['icno' => $icno]);

        $query2 = (new \yii\db\Query())
                ->select("idBorang, tarikh_mohon, icno, status_jfpiu, status_bsm, id")
                ->from('hrd.cb_tbl_lanjutan')
                ->where(['icno' => $icno]);

        $query3 = (new \yii\db\Query())
                ->select("idBorang, tarikh_mohon, icno, status_jfpiu, status_bsm, id")
                ->from('hrd.cb_tbl_lain')
                ->where(['icno' => $icno]);

        $query4 = (new \yii\db\Query())
                ->select("idBorang, tarikh_mohon, icno, status_jfpiu, status_bsm, laporID")
                ->from('hrd.cb_tbl_lapordiri')
                ->where(['icno' => $icno]);

        //            $query5 = (new \yii\db\Query())
        //                ->select("idBorang, tarikh_mohon, icno, status_bsm, id")
        //                ->from('cbelajar.borang_kapal')
        //                ->where(['icno' => $icno])
        //                ;
        //             


        $query1->union($query2, false); //false is UNION, true is UNION ALL
        $query1->union($query3, false); //false is UNION, true is UNION ALL
        $query1->union($query4, false); //false is UNION, true is UNION ALL
        //            $query1->union($query5, false);//false is UNION, true is UNION ALL


        $sql = $query1->createCommand()->getRawSql();
        $sql .= ' ORDER BY tarikh_m DESC';
        $query = TblPermohonan::findBySql($sql);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('senaraisemasa', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'bil' => 1,
        ]);
    }

    public function actionSenarai1() {
        $icno = Yii::$app->user->getId();

        $model = new \app\models\guarantee_letter\TblPermohonan();
        $searchModel = new TblPermohonanSearch();
        $model->tarikh_mohon = date('Y-m-d H:i:s');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $status = ['Tunggu Kelulusan', 'DILULUSKAN', 'MENUNGGU TINDAKAN', 'TIDAK DILULUSKAN'];


        $query1 = (new \yii\db\Query())
                ->select("jenisPermohonan,id")
                ->from('hrd.cb_tbl_permohonan')
                ->where(['icno' => $icno])
                ->andWhere(['status_bsm' => $status]);
        $query2 = (new \yii\db\Query())
                ->select("jenisPermohonan,id")
                ->from('hrd.cb_tbl_lanjutan')
                ->where(['icno' => $icno])
                ->andWhere(['status_bsm' => $status]);




        $query1->union($query2, false); //false is UNION, true is UNION ALL

        $sql = $query1->createCommand()->getRawSql();
        $sql .= ' ORDER BY tarikh_mohon DESC';
        $query = TblPermohonan::findBySql($sql);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('view_permohonan', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'bil' => 1,
        ]);
    }

    public function actionMenunggu() {

        $icno = Yii::$app->user->getId();
        $titlepentadbiran = '';
        $senaraipentadbiran = '';
        $displaypentadbiran = 'none';
        //        $model->app_date = date('Y-m-d H:i:s');
        if (Department::find()->where(['chief' => $icno, 'isActive' => '1'])->exists()) {
            $senaraipentadbiran = TblPermohonan::find()->where(['app_by' => $icno, 'status_proses' => "Selesai Permohonan"])->orderBy(['tarikh_m' => SORT_DESC]);
            $titlepentadbiran = 'Senarai Menunggu Perakuan';
        }
        if ($titlepentadbiran != NULL) {
            $displaypentadbiran = '';
        }

        $senaraipentadbirans = new ActiveDataProvider([

            'query' => $senaraipentadbiran,
            'pagination' => [

                'pageSize' => 10,
            ],
        ]);
        if ($titlepentadbiran != NULL) {
            return $this->render('menunggu', [
                        'icno' => $icno,
                        'senaraipentadbiran' => $senaraipentadbirans,
                        'titlepentadbiran' => $titlepentadbiran,
                        'displaypentadbiran' => $displaypentadbiran,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    protected function findModel($id) {

        if (($model = TblPermohonan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelbyID($id) {
        if (($model = TblPermohonan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findNilaiSyarat($id) {

        if (($model = \app\models\cbelajar\TblNilaiSyarat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionTindakan_jfpiu($id) {

        $model = $this->findModel($id);
        $post = Yii::$app->request->post('tempohs');
        //        $lantikan = Tblrscoapmtstatus::findAll(['ICNO' => $model->icno]);
        $biodata = $this->findBiodata();
        $statuss = $this->findPerkhidmatanbyICNO();
        $model->ver_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            if ($model->status_jfpiu == 'Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);
            } elseif ($model->status_jfpiu == 'Tidak Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save();
            $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['cutisabatikal/senaraitindakan']);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        if ($icno == $model->app_by) {
            return $this->render('tindakan_jfpiu', [

                        'model' => $model,
                        'biodata' => $biodata,
                        'statuss' => $statuss,
                        'img' => $biodata->img,
                        'bil' => '1',
                        'edit' => $edit,
                        'view' => $view
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionTindakanKj($ICNO, $id, $takwim_id) {
        $model = $this->findModel($id);
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id, 'icno' => $ICNO, 'iklan_id' => $takwim_id])->all();
        $biasiswa = TblBiasiswa::findAll(['idPermohonan' => $id, 'icno' => $ICNO, 'iklan_id' => $takwim_id]);
        $dokumen = TblFilePemohon::findAll(['uploaded_by' => $ICNO, 'iklan_id' => $takwim_id]);
        //        $dokumen = TblFilePemohon::findAll(['uploaded_by' =>$icno,'iklan_id' => $id]);
        $dokumen2 = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' => $ICNO, 'iklan_id' => $takwim_id]);
        $dokumen3 = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' => $ICNO, 'iklan_id' => $takwim_id]);
        $biodata = $this->findMaklumat($ICNO);
        $statuss = $this->findPerkhidmatanbyICNO();
        $model->app_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $model->ver_by = 870818495847;
        $default = TblAdmin::find()->one();


        //        $admin = $model->ver_by;

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            $model->status_bsm = 'Tunggu Kelulusan BSM';

            if ($model->status_jfpiu == 'Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);
            } elseif ($model->status_jfpiu == 'Tidak Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);
            $this->pendingtask(870818495847, 11);

            $ntf = new Notification();
            $ntf->icno = 870818495847; // admin
            $ntf->title = 'Permohonan Pengajian Lanjutan';
            $ntf->content = "Permohonan menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakan1'], ['class' => 'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false);

            $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['cutisabatikal/senaraitindakan']);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if ($icno == $model->app_by) {
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
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionTindakanKjSm($ICNO, $id, $takwim_id) {
        $model = $this->findModel($id);
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id, 'icno' => $ICNO, 'iklan_id' => $takwim_id])->all();
        $biasiswa = TblBiasiswa::findAll(['idPermohonan' => $id, 'icno' => $ICNO, 'iklan_id' => $takwim_id]);
        $dokumen = TblFilePemohon::findAll(['uploaded_by' => $ICNO, 'iklan_id' => $takwim_id]);
        $biodata = $this->findMaklumat($ICNO);
        $statuss = $this->findPerkhidmatanbyICNO();
        $model->app_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $model->ver_by = 870818495847;
        $default = TblAdmin::find()->one();


        //        $admin = $model->ver_by;

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            $model->status_bsm = 'Tunggu Kelulusan BSM';

            if ($model->status_jfpiu == 'Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);
            } elseif ($model->status_jfpiu == 'Tidak Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);
            $ntf = new Notification();
            $ntf->icno = 870818495847; // admin
            $ntf->title = 'Permohonan Pengajian Lanjutan';
            $ntf->content = "Permohonan menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakan1'], ['class' => 'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false);
            $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['cutisabatikal/senaraitindakan']);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if ($icno == $model->app_by) {
            return $this->render('semak_maklumatsm', [

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
                        'view' => $view
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    protected function findSabatikal() {
        return \app\models\cbelajar\RekodCb::findAll(['icno' => $this->ICNO()]);
    }

    public function actionCvPemohon($id) {
        $id = $id;
        $biodata = $this->findMaklumat1($id);
        $model = $this->findBiodata2($id);

        if ($biodata) {
            return $this->render('view_1', [
                        'model' => $model,
                        'akademik' => $biodata->akademik,
                        'pengajian' => $biodata->pengajian,
                        'penerbangan' => $biodata->penerbangan,
                        'lain' => $biodata->lain,
                        'lapor' => $biodata->lapor,
                        'lkk' => $biodata->lkk,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda Tidak Mempunyai Rekod']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    public function actionHalamanPemohon() {
        //        $id = $id;
//                $model = $this->findBiodata2($id); 

        return $this->render('pemohon-view', [
                        //             'model' => $model,
                        //             'akademik' => $biodata->akademik,
                        //             'pengajian' => $biodata->pengajian,
                        //             'penerbangan' => $biodata->penerbangan,
                        //            'lain' => $biodata->lain,
                        //            'lapor' => $biodata->lapor,
                        //            'lkk' => $biodata->lkk,
        ]);
    }

    public function actionSenaraiBorang() {
        $model = new TblPermohonan();
        $icno = Yii::$app->user->getId();
        $senarai_dokumen2 = $this->findLainBorang(3);
        //        $status = TblPermohonan::findAll(['icno' => $icno, 'status_proses'=> "Selesai Permohonan", 'idBorang'=> 1]); //senarai status permohonan
        $searchModel = new TblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $ver = TblPermohonan::findAll(['ver_by' => $icno]);

        $biodata = $this->findBiodata();

        return $this->render(
                        'senarai_borang', [

                    'senarai_dokumen2' => $senarai_dokumen2,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'ver' => $ver,
                    'model' => $model,
                    'biodata'=>$biodata,
                        ]
        );
    }

//    public function actionSenaraiBorangLapor() {
//        $model = new TblPermohonan();
//        $icno = Yii::$app->user->getId();
//        $senarai_dokumen2 = $this->findLapor(7);
//        //        $status = TblPermohonan::findAll(['icno' => $icno, 'status_proses'=> "Selesai Permohonan", 'idBorang'=> 1]); //senarai status permohonan
//        $searchModel = new TblPermohonanSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $ver = TblPermohonan::findAll(['ver_by' => $icno]);
//        $pengajian = TblPengajian::find()->where(['icno'=> $icno])->orderBy(['tarikh_mula' => SORT_DESC])->one();
//
//
//        return $this->render(
//                        'senarai_boranglapor', [
//
//                    'senarai_dokumen2' => $senarai_dokumen2,
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//                    'ver' => $ver,
//                    'model' => $model,
//                    'pengajian'=>$pengajian,
//                        ]
//        );
//    }

    public function findLainBorang($status) {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => 2, 'borang' => 3]),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }

    public function findLapor($status) {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => 7, 'borang' => 7]),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }

    protected function findMaklumat1($id) {
        return \app\models\cbelajar\TblPermohonan::findOne(['icno' => $id]);
    }

    public function actionLihattuntutan() {
        $icno = Yii::$app->user->getId();

        //    $model = new Kemudahan();
        $searchModel = new TblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = TblPermohonan::find()->all();

        return $this->render('lihat_tuntutan', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'bil' => 1,
        ]);
    }

    public function actionViewDataPemohon($ICNO) {


        $icno = Yii::$app->request->get();
        $biodata = $this->findMaklumat($ICNO);

        return $this->render(
                        'viewdatapemohon', [

                    'biodata' => $biodata,
                    'akademik' => $this->findAkademikbyICNO(),
                    'pengajian' => $this->findPengajianbyICNO(),
                    'biasiswa' => $this->findBiasiswabyICNO(),
                    'keluarga' => $this->findKeluargabyICNO(),
                    'sabatikal2' => $this->findSabatikalbyICNO(),
                        ]
        );
    }

    public function actionCarianPermohonan() {
        $searchModel = new \app\models\cbelajar\RekodCbSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $pengajian = \app\models\cbelajar\RekodCb::findAll(['icno' => $this->ICNO()]);
        return $this->render('carian_permohonan', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'pengajian' => $pengajian,
        ]);
    }

    public function actionBon($id, $ICNO) {
        //$id = Yii::$app->user->getId(); 
        //            return $this->renderAjax('test'); 
        $bio = Tblprcobiodata::findOne(['ICNO' => $ICNO]);
        $model = $this->findRekod($id);
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $request = Yii::$app->request;



        $message = '';
        if ($model->load($request->post())) {
            $model->bon = $request->post()['RekodCb']['bon'];
            $model->save(false);
            $message = 'Berjaya Disimpan';
        }

        return $this->renderAjax('test', [
                    'model' => $model,
                    'today' => $today,
                    'message' => $message,
                    'bio' => $bio
        ]);
    }

    protected function findRekod($id) {
        if (($model = \app\models\cbelajar\RekodCb::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionView($ICNO, $id) {

        $icno = Yii::$app->request->get();
        $biodata = $this->findMaklumat($ICNO);
        $model = $this->findKemudahan($id);
        $statuss = $this->findPerkhidmatanbyICNO();
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke' => SORT_DESC])->limit(1)->one();
        $kriteriakpi = \app\models\cbelajar\RefPhd::find()->all();
        $doktoral = \app\models\cbelajar\RefDoktoral::find()->all();
        $mod = $this->findCekSyarat($id);
        $kontrak = $this->findModel($id);
        $sabatikal = new \app\models\cbelajar\TblSabatikal();
        //        $sabatikal2= $this->findSabatikal();
        $sabatikal2 = \app\models\cbelajar\RekodCb::findAll(['icno' => $ICNO]);

        if ($sabatikal->load(Yii::$app->request->post())) {
            $sabatikal->icno = $model->icno;
            $sabatikal->save();
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view', 'id' => $model->id, 'ICNO' => $model->icno]);
        }


        if (TblAdmin::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render(
                            'viewdata', [
                        'model' => $model,
                        'biodata' => $biodata,
                        'pengajian' => $biodata->pengajian,
                        'keluarga' => $biodata->keluarga,
                        'biasiswa' => $biodata->biasiswa,
                        'akademik' => $biodata->akademik,
                        'dokumen' => $biodata->dokumen,
                        'statuss' => $statuss,
                        'img' => $biodata->img,
                        'sabatikal' => $sabatikal,
                        'kriteriakpi' => $kriteriakpi,
                        'mod' => $mod,
                        'icno' => $kontrak->icno,
                        'id' => $kontrak->id,
                        'tmp' => $tmp,
                        'kontrak' => $kontrak,
                        'sabatikal2' => $sabatikal2,
                        'doktoral' => $doktoral,
                            ]
            );
        }
    }

    public function actionDeleteSabatikal($id) {
        $mj = \app\models\cbelajar\TblSabatikal::findOne($id)->delete();
        return $this->redirect(['cutibelajar/laporan']);
    }

    protected function findMaklumat($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }

    public function actionSenarai($id) {
        $iklan = $this->findIklanbyID($id);
        //        $dokumen = TblFilePemohon::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id]);
        $models = TblPermohonan::find()->where(['iklan_id' => $id, 'status_proses' => "Selesai Permohonan"])->all();
        $searchModel = new TblPermohonanSearch(['iklan_id' => $id, 'status_proses' => "Selesai Permohonan"]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['status_proses' => "Selesai Permohonan"]);
        //        $models = TblPermohonan::findAll(['iklan_id'=>$id]);
        $nilai = \app\models\cbelajar\TblNilaiSyarat::find()->All();
        $selection = (array) Yii::$app->request->post('selection'); //typecasting

        if (Yii::$app->request->post('simpan')) {

            foreach ($models as $data) {
                if ('y' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = $this->findModel($data->id);
                    $model->status_bsm = 'Draft Diluluskan';
                    $model->save(false);
                    //                    return $this->redirect('index');
                } elseif ('n' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = $this->findModel($data->id);
                    $model->status_bsm = 'Draft Ditolak';
                    $model->save(false);
                }
            }
        } elseif (Yii::$app->request->post('hantar')) {
            foreach ($selection as $id) {
                $hantar = $this->findModel($id); //make a typecasting
                if ('n' . $hantar->id == Yii::$app->request->post($hantar->id)) {
                    $hantar->status = 'TIDAK LULUS';
                    $hantar->status_bsm = 'Tidak Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');

                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan anda tidak berjaya." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                } elseif ('y' . $hantar->id == Yii::$app->request->post($hantar->id)) {
                    $hantar->status = 'LULUS';
                    $hantar->status_bsm = 'Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');
                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan anda berjaya." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                }
                $hantar->save(false);
            }
        } elseif (Yii::$app->request->post('notipemohon')) {
            $this->notifipemohon();
        } elseif (Yii::$app->request->post('notipegawai')) {
            $this->notifipegawai();
        } elseif (Yii::$app->request->post('belummohon')) {
            return $this->redirect('belummohon');
        }

        if (TblAdmin::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('senarai', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'iklan' => $iklan,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionTindakan_bsm($id) {

        $model = $this->findModel($id);
        $model->ver_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');

        $request = Yii::$app->request;
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke' => SORT_DESC])->limit(1)->one();
        $tajaan = TblBiasiswa::findOne(['icno' => Yii::$app->user->getId()]);
        if ($model->status_bsm == 'Diluluskan' || $model->status_bsm == 'Tidak Diluluskan') {
            $displaylapor = '';
            $displaytempoh = 'none';
        } else {
            $displaytempoh = '';
            $displaylapor = 'none';
        }


        $message = '';
        if ($model->load($request->post())) {
           
            $model->ulasan_bsm = $request->post()['TblPermohonan']['ulasan_bsm'];
            $model->save(false);
            $message = 'Berjaya Disimpan';
        }

        return $this->renderAjax('tindakan_bsm', [
                    'model' => $model,
                    'today' => $today,
                    'message' => $message,
                    'displaytempoh' => $displaytempoh,
                    'tmp' => $tmp,
                    'tajaan' => $tajaan,
        ]);
    }

//    public function actionSemakanSyarat($id, $ICNO, $takwim_id) {
//        $iklan = $this->findIklanbyID($takwim_id);
//        $message = '';
//        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();
//        $akad = Tblpendidikan::find()->where(['ICNO' => $ICNO, 'HighestEduLevelCd' => 7])->one();
//        $kriteriakpi = \app\models\cbelajar\RefPhd::find()->where(['status' => 1])->all();
//        $admin = \app\models\cbelajar\RefPhd::find()->where(['status' => 2])->all();
//        $separuh = \app\models\cbelajar\RefPhd::find()->where(['status' => 3])->all();
//        $senarai_dokumen = $this->findDokumen(1);
//        $senarai_dokumenkpm = $this->findDokumenKpm(1);
//        $senarai_dokumenln = $this->findDokumenLn(1);
//        $doktoral = \app\models\cbelajar\RefDoktoral::find()->all();
//         $studi = TblPengajian::find()->where(['icno'=>$ICNO, 'status'=>9])->one();
//         $biasiswa = TblBiasiswa::find()->where(['icno'=>$ICNO,'iklan_id'=>$takwim_id])->one();
//
//        $kontrak = $this->findModel($id);
//        $biodata = $this->findBio($ICNO);
//
//        if (Yii::$app->request->post()) {
//            foreach ($kriteriakpi as $kpi) {
//                $this->savekpi($takwim_id, $id, $kontrak->icno, $kpi);
//            }
//            foreach ($doktoral as $dok) {
//                $this->savekpi($takwim_id, $id, $kontrak->icno, $dok);
//            }
//            foreach ($admin as $p) {
//                $this->savekpi($takwim_id, $id, $kontrak->icno, $p);
//            }
//            foreach ($separuh as $s) {
//                $this->savekpi($takwim_id, $id, $kontrak->icno, $s);
//            }
//            //            $message = 'Berjaya Disimpan';
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
//            return $this->redirect(['view-syarat', 'id' => $kontrak->id, 'ICNO' => $ICNO, 'takwim_id' => $kontrak->iklan_id]);
//        }
//        if ($kontrak->status_semakan == 'Dibawa Ke Mesyuarat' || $kontrak->status_semakan == 'Dokumen Tidak Lengkap') {
//            $edit = 'none';
//            $view = '';
//        } else {
//            $view = 'none';
//            $edit = '';
//        }
//        if (\app\models\cbelajar\TblNilaiSyarat::find()->where(['icno' => $kontrak->icno, 'iklan_id' => $kontrak->iklan_id, 'parent_id' => $kontrak->id])->exists()) {
//            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
//            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
//        }
//        return $this->render('semakan_syaratcb', [
//                    'kontrak' => $kontrak,
//                    'kriteriakpi' => $kriteriakpi,
//                    'doktoral' => $doktoral,
//                    'message' => $message,
//                    'icno' => $kontrak->icno,
//                    'edit' => $edit,
//                    'view' => $view,
//                    'iklan' => $iklan,
//                    'img' => $biodata->img,
//                    'biodata' => $biodata,
//                    'pengajian' => $pengajian,
//                    'admin' => $admin,
//                    'separuh' => $separuh,
//                    'akademik' => $this->findAkademik(),
//                    'akad' => $akad,
//                    'senarai_dokumen' => $senarai_dokumen,
//                    'senarai_dokumenkpm' => $senarai_dokumenkpm,
//                    'senarai_dokumenln' => $senarai_dokumenln,
//            'studi'=>$studi,'ICNO'=>$ICNO,'biasiswa'=>$biasiswa
//        ]);
//    }
//   public function actionSemakanSyarat($id, $ICNO, $takwim_id) {
//        $iklan = $this->findIklanbyID($takwim_id);
//        $message = '';
//        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();
//        $akad = Tblpendidikan::find()->where(['ICNO' => $ICNO, 'HighestEduLevelCd' => 7])->one();
//        $kriteriakpi = \app\models\cbelajar\RefPhd::find()->where(['status' => 1])->all();
//        $admin = \app\models\cbelajar\RefPhd::find()->where(['status' => 2])->all();
//        $separuh = \app\models\cbelajar\RefPhd::find()->where(['status' => 3])->all();
//        $senarai_dokumen = $this->findDokumen(1);
//        $senarai_dokumenkpm = $this->findDokumenKpm(1);
//        $senarai_dokumenln = $this->findDokumenLn(1);
//        $doktoral = \app\models\cbelajar\RefDoktoral::find()->all();
//        $studi = TblPengajian::find()->where(['icno'=>$ICNO, 'status'=>9])->one();
//         $biasiswa = TblBiasiswa::find()->where(['icno'=>$ICNO,'iklan_id'=>$takwim_id])->one();
//
//        $kontrak = $this->findModel($id);
//        $biodata = $this->findBio($ICNO);
//
//        if (Yii::$app->request->post()) {
//            foreach ($kriteriakpi as $kpi) {
//                $this->savekpi($takwim_id, $id, $kontrak->icno, $kpi);
//            }
//            foreach ($doktoral as $dok) {
//                $this->savekpi($takwim_id, $id, $kontrak->icno, $dok);
//            }
//            foreach ($admin as $p) {
//                $this->savekpi($takwim_id, $id, $kontrak->icno, $p);
//            }
//            foreach ($separuh as $s) {
//                $this->savekpi($takwim_id, $id, $kontrak->icno, $s);
//            }
//            //            $message = 'Berjaya Disimpan';
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
//            return $this->redirect(['view-syarat', 'id' => $kontrak->id, 'ICNO' => $ICNO, 'takwim_id' => $kontrak->iklan_id]);
//        }
//        if ($kontrak->status_semakan == 'Dibawa Ke Mesyuarat' || $kontrak->status_semakan == 'Dokumen Tidak Lengkap') {
//            $edit = 'none';
//            $view = '';
//        } else {
//            $view = 'none';
//            $edit = '';
//        }
//        if (\app\models\cbelajar\TblNilaiSyarat::find()->where(['icno' => $kontrak->icno, 'iklan_id' => $kontrak->iklan_id, 'parent_id' => $kontrak->id])->exists()) {
//            //                Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
//            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
//        }
//        return $this->render('/cutibelajar/umum/semakan_syarat', [
//                    'kontrak' => $kontrak,
//                    'kriteriakpi' => $kriteriakpi,
//                    'doktoral' => $doktoral,
//                    'message' => $message,
//                    'icno' => $kontrak->icno,
//                    'edit' => $edit,
//                    'view' => $view,
//                    'iklan' => $iklan,
//                    'img' => $biodata->img,
//                    'biodata' => $biodata,
//                    'pengajian' => $pengajian,
//                    'admin' => $admin,
//                    'separuh' => $separuh,
//                    'akademik' => $this->findAkademik(),
//                    'akad' => $akad,
//                    'senarai_dokumen' => $senarai_dokumen,
//                    'senarai_dokumenkpm' => $senarai_dokumenkpm,
//                    'senarai_dokumenln' => $senarai_dokumenln,
//            'studi'=>$studi,'ICNO'=>$ICNO,'biasiswa'=>$biasiswa
//        ]);
//    }

    public function actionSemakanSyarat($id, $ICNO, $takwim_id) {
        $iklan = $this->findIklanbyID($takwim_id);
        $message = '';
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();
        $akad = Tblpendidikan::find()->where(['ICNO' => $ICNO, 'HighestEduLevelCd' => 7])->one();
        $kriteriakpi = \app\models\cbelajar\RefSemakan::find()->where(['status' => 1,'jenis'=>'umum'])->all();
        $khusus = \app\models\cbelajar\RefSemakan::find()->where(['status' => 1,'jenis'=>'khusus'])->all();
        $khusus_ln = \app\models\cbelajar\RefSemakan::find()->where(['status'=>1, 'jenis'=>'khusus_ln'])->all();
        $admin = \app\models\cbelajar\RefPhd::find()->where(['status' => 2])->all();
        $separuh = \app\models\cbelajar\RefPhd::find()->where(['status' => 3])->all();
        $senarai_dokumen = $this->findDokumen(1);
        $senarai_dokumenkpm = $this->findDokumenKpm(1);
        $senarai_dokumenln = $this->findDokumenLn(1);
        $doktoral = \app\models\cbelajar\RefDoktoral::find()->all();
         $studi = TblPengajian::find()->where(['icno'=>$ICNO, 'status'=>9])->one();
         $biasiswa = TblBiasiswa::find()->where(['icno'=>$ICNO,'iklan_id'=>$takwim_id])->one();

        $kontrak = $this->findModel($id);
        $biodata = $this->findBio($ICNO);

        if (Yii::$app->request->post()) {
            foreach ($kriteriakpi as $kpi) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $kpi);
            }
            foreach ($khusus as $khusus) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $khusus);
            }
            foreach ($khusus_ln as $khusus_ln) {
                $this->savekpi($takwim_id, $id, $kontrak->icno,$khusus_ln);
            }
           
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
            return $this->redirect(['cutibelajar/view-syarat', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
        }
        return $this->render('umum/semakan_syarat', [
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
                    'admin' => $admin,
                    'separuh' => $separuh,
                    'akademik' => $this->findAkademik(),
                    'akad' => $akad,
                    'senarai_dokumen' => $senarai_dokumen,
                    'senarai_dokumenkpm' => $senarai_dokumenkpm,
                    'senarai_dokumenln' => $senarai_dokumenln,
            'studi'=>$studi,'ICNO'=>$ICNO,'biasiswa'=>$biasiswa, 'khusus'=>$khusus,'khusus_ln'=>$khusus_ln
        ]);
    }
        public function actionUpdateStudy($id,$idb,$ICNO,$takwim_id) {
//            $mohon = TblPermohonan::find()->one();
//            $in = $mohon->id;
          $iklan = $this->findIklanbyID($takwim_id);
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();
        $model = \app\models\cbelajar\TblPengajian::find()->where(['id' => $id])->one();
        $biasiswa = TblBiasiswa::find()->where(['id' => $idb])->one();

//        $icno = $model->icno;
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump($model);die;
        if (($model->load(Yii::$app->request->post())) && ($biasiswa->load(Yii::$app->request->post()))) {
            $model->save(false);
            $biasiswa->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['semakan-syarat?id='.$model->idPermohonan.'&ICNO='.$ICNO.'&takwim_id='.$takwim_id]);
        }
        

        return $this->renderAjax('_updates', [
                    'model' => $model,
            'iklan'=>$iklan, 'pengajian'=>$pengajian,'biasiswa'=>$biasiswa
        ]);
    }
    public function actionUpdateSemakanSyarat($id, $ICNO, $takwim_id) {
        $iklan = $this->findIklanbyID($takwim_id);
        $message = '';
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();
        $akad = Tblpendidikan::find()->where(['ICNO' => $ICNO, 'HighestEduLevelCd' => 7])->one();
        $kriteriakpi = \app\models\cbelajar\RefSemakan::find()->where(['status' => 1,'jenis'=>'umum'])->all();
         $khusus = \app\models\cbelajar\RefSemakan::find()->where(['status' => 1,'jenis'=>'khusus'])->all();
        $khusus_ln = \app\models\cbelajar\RefSemakan::find()->where(['status'=>1, 'jenis'=>'khusus_ln'])->all();
        $admin = \app\models\cbelajar\RefPhd::find()->where(['status' => 2])->all();
        $separuh = \app\models\cbelajar\RefPhd::find()->where(['status' => 3])->all();
        $senarai_dokumen = $this->findDokumen(1);
        $senarai_dokumenkpm = $this->findDokumenKpm(1);
        $senarai_dokumenln = $this->findDokumenLn(1);
        $doktoral = \app\models\cbelajar\RefDoktoral::find()->all();

        $kontrak = $this->findModel($id);
        $biodata = $this->findBio($ICNO);

        if (Yii::$app->request->post()) {
            foreach ($kriteriakpi as $kpi) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $kpi);
            }
            foreach ($doktoral as $dok) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $dok);
            }
            foreach ($admin as $p) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $p);
            }
            foreach ($separuh as $s) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $s);
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
        return $this->render('umum/semakan_syarat', [
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
                    'admin' => $admin,
                    'separuh' => $separuh,
                    'akademik' => $this->findAkademik(),
                    'akad' => $akad,
                    'senarai_dokumen' => $senarai_dokumen,
                    'senarai_dokumenkpm' => $senarai_dokumenkpm,
                    'senarai_dokumenln' => $senarai_dokumenln,
            'khusus'=>$khusus,'khusus_ln'=>$khusus_ln
        ]);
    }
   public function actionUpdateSemakanSyaratAdmin($id, $ICNO, $takwim_id) {
        $iklan = $this->findIklanbyID($takwim_id);
        $message = '';
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();
        $akad = Tblpendidikan::find()->where(['ICNO' => $ICNO, 'HighestEduLevelCd' => 7])->one();
        $kriteriakpi = \app\models\cbelajar\RefPhd::find()->where(['status' => 1])->all();
        $admin = \app\models\cbelajar\RefPhd::find()->where(['status' => 2])->all();
        $separuh = \app\models\cbelajar\RefPhd::find()->where(['status' => 3])->all();
        $senarai_dokumen = $this->findDokumen(1);
       
        $doktoral = \app\models\cbelajar\RefDoktoral::find()->all();

        $kontrak = $this->findModel($id);
        $biodata = $this->findBio($ICNO);

        if (Yii::$app->request->post()) {
            foreach ($kriteriakpi as $kpi) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $kpi);
            }
            foreach ($doktoral as $dok) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $dok);
            }
            foreach ($admin as $p) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $p);
            }
            foreach ($separuh as $s) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $s);
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
//            return $this->redirect(['cutibelajar/view-syarat-admin', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
//        }
        return $this->render('semakan_syaratadmin', [
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
                    'admin' => $admin,
                    'separuh' => $separuh,
                    'akademik' => $this->findAkademik(),
                    'akad' => $akad,
                    'senarai_dokumen' => $senarai_dokumen,
                   
        ]);
    }
    
    public function actionSemakanSyaratAdmin($id, $ICNO, $takwim_id) {
        $iklan = $this->findIklanbyID($takwim_id);
        $message = '';
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();
        $akad = Tblpendidikan::find()->where(['ICNO' => $ICNO, 'HighestEduLevelCd' => 7])->one();
        $kriteriakpi = \app\models\cbelajar\RefPhd::find()->where(['status' => 1])->all();
        $admin = \app\models\cbelajar\RefPhd::find()->where(['status' => 2])->all();
        $separuh = \app\models\cbelajar\RefPhd::find()->where(['status' => 3])->all();
        $senarai_dokumen = $this->findDokumen(1);
       
        $doktoral = \app\models\cbelajar\RefDoktoral::find()->all();

        $kontrak = $this->findModel($id);
        $biodata = $this->findBio($ICNO);

        if (Yii::$app->request->post()) {
            foreach ($kriteriakpi as $kpi) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $kpi);
            }
            foreach ($doktoral as $dok) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $dok);
            }
            foreach ($admin as $p) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $p);
            }
            foreach ($separuh as $s) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $s);
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
            return $this->redirect(['cutibelajar/view-syarat-admin', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
        }
        return $this->render('semakan_syaratadmin', [
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
                    'admin' => $admin,
                    'separuh' => $separuh,
                    'akademik' => $this->findAkademik(),
                    'akad' => $akad,
                    'senarai_dokumen' => $senarai_dokumen,
                   
        ]);
    }


    public function actionSemakanSyaratSeparuhMasa($id, $ICNO, $takwim_id) {
        $iklan = $this->findIklanbyID($takwim_id);
        $message = '';
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();

        $separuh = \app\models\cbelajar\RefPhd::find()->where(['status' => 3])->all();


        $kontrak = $this->findModel($id);
        $biodata = $this->findBio($ICNO);

        if (Yii::$app->request->post()) {

            foreach ($separuh as $s) {
                $this->savekpi($takwim_id, $id, $kontrak->icno, $s);
            }
            //            $message = 'Berjaya Disimpan';
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-syarat-separuh-masa', 'id' => $kontrak->id, 'ICNO' => $ICNO, 'takwim_id' => $kontrak->iklan_id]);
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
            return $this->redirect(['cutibelajar/view-syarat-separuh-masa', 'ICNO' => $ICNO, 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
        }
        return $this->render('semakan_syaratsm', [
                    'kontrak' => $kontrak,
                    'message' => $message,
                    'icno' => $kontrak->icno,
                    'edit' => $edit,
                    'view' => $view,
                    'iklan' => $iklan,
                    'biodata' => $biodata,
                    'pengajian' => $pengajian,
                    'separuh' => $separuh,
        ]);
    }
 protected function savekpi($takwim_id, $i, $id, $kpi) {

        $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['iklan_id' => $takwim_id, 'icno' => $id, 'syarat_id' => $kpi->syarat_id])->one();
        $iklan = $this->findIklanbyID($takwim_id);
        //               $kontrak = $this->findModel($id);
        //       $model = $this->findModelbyID($id);

        if ($mod) {

            $mod->semak_phd = Yii::$app->request->post($kpi->syarat_id . 'semak_phd');
            $mod->catatan_phd = Yii::$app->request->post($kpi->syarat_id . 'catatan_phd');
            $mod->semak_doktoral = Yii::$app->request->post($kpi->syarat_id . 'semak_doktoral');
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
            $mod->semak_doktoral = Yii::$app->request->post($kpi->syarat_id . 'semak_doktoral');
            //                    $mod->catatan_phd = Yii::$app->request->post($kpi->syarat_id.'catatan_phd');
            $mod->tahun = date("Y");
            $mod->created_dt = new \yii\db\Expression('NOW()');
            $mod->save();
        }
    }

//    protected function savekpi($takwim_id, $i, $id, $kpi) {
//
//        $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['iklan_id' => $takwim_id, 'icno' => $id, 'syarat_id' => $kpi->syarat_id])->one();
//        $iklan = $this->findIklanbyID($takwim_id);
//        //               $kontrak = $this->findModel($id);
//        //       $model = $this->findModelbyID($id);
//
//        if ($mod) {
//
//            $mod->semak_phd = Yii::$app->request->post($kpi->syarat_id . 'semak_phd');
//            $mod->catatan_phd = Yii::$app->request->post($kpi->syarat_id . 'catatan_phd');
//            $mod->semak_doktoral = Yii::$app->request->post($kpi->syarat_id . 'semak_doktoral');
//            $mod->iklan_id = $iklan->id;
//            $mod->parent_id = $i;
//            $mod->tahun = date("Y");
//            $mod->created_dt = new \yii\db\Expression('NOW()');
//            $mod->save();
//        } else {
//            $mod = new \app\models\cbelajar\TblNilaiSyarat();
//            $mod->syarat_id = $kpi->syarat_id;
//            $mod->icno = $id;
//            $mod->iklan_id = $iklan->id;
//            $mod->parent_id = $i;
//            $mod->semak_phd = Yii::$app->request->post($kpi->syarat_id . 'semak_phd');
//            $mod->semak_doktoral = Yii::$app->request->post($kpi->syarat_id . 'semak_doktoral');
//            //                    $mod->catatan_phd = Yii::$app->request->post($kpi->syarat_id.'catatan_phd');
//            $mod->tahun = date("Y");
//            $mod->created_dt = new \yii\db\Expression('NOW()');
//            $mod->save();
//        }
//    }

    public function actionSemakanSyarat2($id, $ICNO, $takwim_id) {
        $iklan = $this->findIklanbyID($takwim_id);
        $message = '';
        $sabatikal = \app\models\cbelajar\RefSabatikal::find()->all();
        $latihan = \app\models\cbelajar\RefLatihanIndustri::find()->all();
        $kontrak = $this->findModel($id);
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();

//        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->one();
        $biodata = $this->findBio($ICNO);

        if (Yii::$app->request->post()) {

            foreach ($sabatikal as $s) {
                $this->savesemak($takwim_id, $id, $kontrak->icno, $s);
            }
            foreach ($latihan as $l) {
                $this->savesemak($takwim_id, $id, $kontrak->icno, $l);
            }
            //            $message = 'Berjaya Disimpan';
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-syarat2', 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]);
        }
        if ($kontrak->status_semakan == 'Dibawa Ke Mesyuarat' || $kontrak->status_semakan == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        if (\app\models\cbelajar\TblSemakSyarat::find()->where(['icno' => $kontrak->icno, 'iklan_id' => $kontrak->iklan_id])->exists()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Data Telah Disimpan!', 'type' => 'error']);
            return $this->redirect(['view-syarat2', 'id' => $kontrak->id, 'takwim_id' => $kontrak->iklan_id]); //
        }
        return $this->render('semakan_syarat', [
                    'kontrak' => $kontrak,
                    'message' => $message,
                    'icno' => $kontrak->icno,
                    'edit' => $edit,
                    'view' => $view,
                    'iklan' => $iklan, 'sabatikal' => $sabatikal,
                    'latihan' => $latihan,
                    'pengajian' => $pengajian,
                    'biodata' => $biodata,
        ]);
    }

    protected function savesemak($takwim_id, $i, $id, $kpi) {

        $mod = \app\models\cbelajar\TblSemakSyarat::find()->where(['iklan_id' => $takwim_id, 'icno' => $id, 'syarat_id' => $kpi->syarat_id])->one();
        $iklan = $this->findIklanbyID($takwim_id);


        if ($mod) {

            $mod->semak_sabatikal = Yii::$app->request->post($kpi->syarat_id . 'semak_sabatikal');
            $mod->semak_latihan = Yii::$app->request->post($kpi->syarat_id . 'semak_latihan');
            $mod->iklan_id = $iklan->id;
            $mod->parent_id = $i;
            $mod->tahun = date("Y");
            $mod->created_dt = new \yii\db\Expression('NOW()');
            $mod->save(false);
        } else {
            $mod = new \app\models\cbelajar\TblSemakSyarat();
            $mod->syarat_id = $kpi->syarat_id;
            $mod->icno = $id;
            $mod->iklan_id = $iklan->id;
            $mod->parent_id = $i;
            $mod->semak_sabatikal = Yii::$app->request->post($kpi->syarat_id . 'semak_sabatikal');
            $mod->semak_latihan = Yii::$app->request->post($kpi->syarat_id . 'semak_latihan');
            //                    $mod->catatan_phd = Yii::$app->request->post($kpi->syarat_id.'catatan_phd');
            $mod->tahun = date("Y");
            $mod->created_dt = new \yii\db\Expression('NOW()');
            $mod->save(false);
        }
    }

    public function actionGenerateSemakanSyarat($id, $ICNO) {

        $biodata = $this->findMaklumat($ICNO);
        $kriteriakpi = \app\models\cbelajar\RefSemakan::find()->where(['status'=>1,'jenis'=>"umum"])->all();
        $khusus = \app\models\cbelajar\RefSemakan::find()->where(['status'=>1,'jenis'=>"khusus"])->all();
        $khusus_ln = \app\models\cbelajar\RefSemakan::find()->where(['status'=>1,'jenis'=>"khusus_ln"])->all();

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
            'content' => $this->renderPartial('umum/_laporansemakan', [
                'kriteriakpi' => $kriteriakpi, 'mod' => $mod,
                'icno' => $kontrak->icno,
                'id' => $kontrak->id,
                'edit' => $edit,
                'view' => $view,
                'kontrak' => $kontrak,
                'biodata' => $biodata,
                'khusus' => $khusus,
                'khusus_ln' => $khusus_ln
            ]),
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => [],
        ]);


        return $pdf->render();
    }

    public function actionGenerateSemakanSyaratPentadbiran($id, $ICNO) {

        $biodata = $this->findMaklumat($ICNO);
        $kriteriakpi = \app\models\cbelajar\RefPhd::find()->where(['status' => 2])->all();
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
            'content' => $this->renderPartial('/cbelajar/_laporansemakanp', [
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

    public function actionGenerateSemakanSyaratSabatikal($id, $ICNO) {

        $biodata = $this->findMaklumat($ICNO);
        $kriteriakpi = \app\models\cbelajar\RefSabatikal::find()->all();
        $mod = $this->findCekSyarat2($id);
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
            'content' => $this->renderPartial('/cbelajar/_laporansemakansabatikal', [
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

    public function actionGenerateSemakanSyaratLatihan($id, $ICNO) {

        $biodata = $this->findMaklumat($ICNO);
        $kriteriakpi = \app\models\cbelajar\RefLatihanIndustri::find()->all();
        $mod = $this->findCekSyarat2($id);
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
            'content' => $this->renderPartial('/cbelajar/_laporansemakanli', [
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

    public function actionGenerateSemakanSyaratDoktoral($id, $ICNO) {

        $biodata = $this->findMaklumat($ICNO);
        $doktoral = \app\models\cbelajar\RefDoktoral::find()->all();
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
            'content' => $this->renderPartial('/cbelajar/_laporansemakandoktoral', [
                'doktoral' => $doktoral, 'mod' => $mod,
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

    public function actionCetakSeparuhMasa($id, $ICNO) {

        $biodata = $this->findMaklumat($ICNO);
        $kriteria = \app\models\cbelajar\RefPhd::find()->where(['status' => 3])->all();
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
            'content' => $this->renderPartial('/cbelajar/_separuhmasa', [
                'kriteria' => $kriteria, 'mod' => $mod,
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

    protected function findKemudahan($id) {
        if (($model = TblPermohonan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGeneratePermohonan($id, $ICNO, $takwim_id) {

        $biodata = $this->findMaklumat($ICNO);
        $model = $this->findKemudahan($id);
        $pengajian = TblPengajian::findAll(['icno' => $ICNO, 'iklan_id' => $takwim_id]);
        $biasiswa = TblBiasiswa::findAll(['icno' => $ICNO, 'iklan_id' => $takwim_id]);
        $dokumen = TblFilePemohon::findAll(['uploaded_by' => $ICNO, 'iklan_id' => $takwim_id]);
        //        $dokumen = TblFilePemohon::findAll(['uploaded_by' =>$icno,'iklan_id' => $id]);
        $dokumen2 = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' => $ICNO, 'iklan_id' => $takwim_id]);
        $dokumen3 = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' => $ICNO, 'iklan_id' => $takwim_id]);
        $statuss = $this->findPerkhidmatanbyICNO();
        if (TblAdmin::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {

            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            $pdf = new Pdf([
                'filename' => '_CUTIBELAJAR_' . $id,
                'mode' => Pdf::MODE_BLANK, // leaner size using standard fonts
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('/cbelajar/_cetakborang', [
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
                ]),
                'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
                'options' => [],
            ]);
        }
        return $pdf->render();
    }

    protected function savekpidoktoral($id, $doktoral) {
        $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['icno' => $id, 'syarat_id' => $doktoral->syarat_id])->one();

        if ($mod) {


            $mod->semak_doktoral = Yii::$app->request->post($doktoral->syarat_id . 'semak_doktoral');
            $mod->catatan_doktoral = Yii::$app->request->post($doktoral->syarat_id . 'catatan_doktoral');
            $mod->save();
        } else {
            $mod = new \app\models\cbelajar\TblNilaiSyarat();
            $mod->syarat_id = $doktoral->syarat_id;
            $mod->icno = $id;
            $mod->semak_doktoral = Yii::$app->request->post($doktoral->syarat_id . 'semak_doktoral');
            $mod->catatan_doktoral = Yii::$app->request->post($doktoral->syarat_id . 'catatan_doktoral');
            $mod->save();
        }
    }

    public function actionLaporan($tahun = null, $bulan = null) {

        $year = date('Y');
        $mth = date('m');

        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $mth = $bulan;
        }

        $query = TblPermohonan::find()->where(['MONTH(created_at)' => $mth])->andWhere(['YEAR(created_at)' => $year])->orderBy(['created_at' => SORT_ASC]);

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

        return $this->render('laporan', ['tahun' => $year, 'bulan' => $mth, 'dataProvider' => $DataProvider]);
    }

    public function actionMaklumatPermohonan($ICNO, $id) {
        $icno = Yii::$app->user->getId();
        $biodata = $this->findMaklumat($ICNO);
        $model = $this->findKemudahan($id);
        return $this->render(
                        'maklumat_permohonan', [

                    'model' => $model,
                    'biodata' => $biodata,
                    'pengajian' => $biodata->pengajian,
                    'keluarga' => $biodata->keluarga,
                    'biasiswa' => $biodata->biasiswa,
                    'akademik' => $biodata->akademik,
                    'dokumen' => $biodata->dokumen,
                    'img' => $biodata->img,
                        ]
        );
    }

    public function actionTambahadmin() {

        $admin = TblAdmin::find()->All(); //cari senarai admin
        $adminbaru = new TblAdmin; //untuk admin baru
        if ($adminbaru->load(Yii::$app->request->post())) {
            if (TblAdmin::find()->where(['icno' => $adminbaru->icno])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
            } elseif ($adminbaru->kakitangan->CONm != NULL) { //jika icno tidak wujud dalam sistem
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                $adminbaru->save();
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
            }

            return $this->redirect(['cutibelajar/tambahadmin']);
        }
        if (TblAdmin::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('tambahadmin', [
                        'admin' => $admin,
                        'adminbaru' => $adminbaru,
                        'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionDelete($id) {
        $admin = Tbladmin::findOne(['id' => $id]);
        $admin->delete();
        if (TblAdmin::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->redirect(['tambahadmin']);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    protected function findBiodata2($id) {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
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

    protected function findIklan($id) {
        return TblUrusMesyuarat::findOne(['id' => $id]);
    }

    protected function findCekSyarat($id) {
        return \app\models\cbelajar\TblNilaiSyarat::findOne(['id' => $id]);
    }

    protected function findCekSyarat2($id) {
        return \app\models\cbelajar\TblSemakSyarat::findOne(['id' => $id]);
    }

    protected function findSabatikalByID($id) {
        return \app\models\cbelajar\TblSabatikal::findOne(['icno' => $id]);
    }

    protected function findKpm($id) {
        return \app\models\cbelajar\TblFileKpm::findOne(['id' => $id]);
    }

//    // Semak Permohonan
//    public function actionViewSyarat($id, $ICNO) {
//
//        $kriteriakpi = \app\models\cbelajar\RefSemakan::find()->where(['status'=>1,'jenis'=>'umum'])->all();
//        $khusus = \app\models\cbelajar\RefSemakan::find()->where(['status'=>1,'jenis'=>'khusus'])->all();
//        $khusus_ln = \app\models\cbelajar\RefSemakan::find()->where(['status'=>1,'jenis'=>'khusus_ln'])->all();
//$senarai_dokumen = $this->findDokumen(1);
//        $senarai_dokumenkpm = $this->findDokumenKpm(1);
//        $senarai_dokumenln = $this->findDokumenLn(1);
//        $admin = \app\models\cbelajar\RefPhd::find()->where(['status' => 2])->all();
//
//        $doktoral = \app\models\cbelajar\RefDoktoral::find()->all();
//        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();
//         $studi = TblPengajian::find()->where(['icno'=>$ICNO, 'status'=>9])->one();
////        $mod = $this->findCekSyarat($id);
//        $kontrak = $this->findModel($id);
//        $biodata = $this->findBio($ICNO);
//        if ($kontrak->load(Yii::$app->request->post())) {
//
//            if ($kontrak->status_semakan == 'Dibawa Ke Mesyuarat') {
//                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Dibawa ke Mesyuarat!']);
//            } elseif ($kontrak->status_semakan == 'Dokumen Tidak Lengkap') {
//                Yii::$app->session->setFlash('alert', ['title' => 'Dokumen Tidak Lengkap', 'type' => 'danger', 'msg' => 'Permohonan Telah DITOLAK!']);
//            }
//
//            $kontrak->save(false);
//            return $this->redirect(['cbadmin/senaraitindakan1', 'id' => $kontrak->iklan_id]);
//        }
//        if ($kontrak->status_semakan == 'Layak Dipertimbangkan' || $kontrak->status_semakan == 'Dokumen Tidak Lengkap' || $kontrak->status_semakan == 'Tidak Layak Dipertimbangkan') {
//            $edit = 'none';
//            $view = '';
//        } else {
//            $view = 'none';
//            $edit = '';
//        }
//
//        return $this->render(
//                        'umum/_syarat', [
//                    'kriteriakpi' => $kriteriakpi,
//                    'icno' => $kontrak->icno,
//                    'id' => $kontrak->id,
//                    'edit' => $edit,
//                    'view' => $view,
//                    'kontrak' => $kontrak,
//                    'biodata' => $biodata,
//                     'img' => $biodata->img,
//                    'pengajian' => $pengajian,
//                    'doktoral' => $doktoral,
//                    'admin' => $admin,
//                            'ICNO'=>$ICNO,'studi'=>$studi,'khusus'=>$khusus,'khusus_ln' => $khusus_ln,
//                             'senarai_dokumen' => $senarai_dokumen,
//                    'senarai_dokumenkpm' => $senarai_dokumenkpm,
//                    'senarai_dokumenln' => $senarai_dokumenln,
//                            
//                        ]
//        );
//    }
     public function actionViewSyarat($id, $ICNO) {

        $kriteriakpi = \app\models\cbelajar\RefPhd::find()->where(['status'=>1])->all();
        $admin = \app\models\cbelajar\RefPhd::find()->where(['status' => 2])->all();

        $doktoral = \app\models\cbelajar\RefDoktoral::find()->all();
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();
         $studi = TblPengajian::find()->where(['icno'=>$ICNO, 'status'=>9])->one();
//        $mod = $this->findCekSyarat($id);
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
        if ($kontrak->status_semakan == 'Layak Dipertimbangkan' || $kontrak->status_semakan == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        return $this->render(
                        '/cbelajar/_syarat', [
                    'kriteriakpi' => $kriteriakpi,
                    'icno' => $kontrak->icno,
                    'id' => $kontrak->id,
                    'edit' => $edit,
                    'view' => $view,
                    'kontrak' => $kontrak,
                    'biodata' => $biodata,
                    'pengajian' => $pengajian,
                    'doktoral' => $doktoral,
                    'admin' => $admin,
                            'ICNO'=>$ICNO,'studi'=>$studi
                        ]
        );
    }

    public function actionKemaskiniUlasan($id,$ICNO) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblPermohonan::find()->where(['id' => $id])->one();

          $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();

        $kontrak = $this->findModel($id);
        $biodata = $this->findBio($ICNO);
        if ($model->load(Yii::$app->request->post())) {
            $model->ver_date = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['view-syarat?ICNO='.$ICNO.'&id='.$id.'&takwim_id='.$kontrak->iklan_id]);
        }

        return $this->renderAjax('update-ulasan', [
                    'model' => $model,
            'biodata'=>$biodata, 'kontrak'=>$kontrak,'pengajian'=>$pengajian
        ]);
    }
    public function actionKemaskiniUlasanAdmin($id,$ICNO) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblPermohonan::find()->where(['id' => $id])->one();

          $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();

        $kontrak = $this->findModel($id);
        $biodata = $this->findBio($ICNO);
        if ($model->load(Yii::$app->request->post())) {
            $model->ver_date = new \yii\db\Expression('NOW()');
            $model->app_by = $i;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['view-syarat-admin?ICNO='.$ICNO.'&id='.$id.'&takwim_id='.$kontrak->iklan_id]);
        }

        return $this->renderAjax('update-ulasan', [
                    'model' => $model,
            'biodata'=>$biodata, 'kontrak'=>$kontrak,'pengajian'=>$pengajian
        ]);
    }
    public function actionViewSyaratAdmin($id, $ICNO) {

        $kriteriakpi = \app\models\cbelajar\RefPhd::find()->all();
        $admin = \app\models\cbelajar\RefPhd::find()->where(['status' => 2])->all();

        $doktoral = \app\models\cbelajar\RefDoktoral::find()->all();
        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();

//        $mod = $this->findCekSyarat($id);
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
        if ($kontrak->status_semakan == 'Layak Dipertimbangkan' || $kontrak->status_semakan == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        return $this->render(
                        '_syaratadmin', [
                    'kriteriakpi' => $kriteriakpi,
                    'icno' => $kontrak->icno,
                    'id' => $kontrak->id,
                    'edit' => $edit,
                    'view' => $view,
                    'kontrak' => $kontrak,
                    'biodata' => $biodata,
                    'pengajian' => $pengajian,
                    'doktoral' => $doktoral,
                    'admin' => $admin,
                            'ICNO'=>$ICNO
                        ]
        );
    }

    public function actionViewSyaratSeparuhMasa($id, $ICNO) {

        $separuh = \app\models\cbelajar\RefPhd::find()->where(['status' => 3])->all();

        $pengajian = TblPengajian::find()->where(['idPermohonan' => $id])->all();

//        $mod = $this->findCekSyarat($id);
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
        if ($kontrak->status_semakan == 'Layak Dipertimbangkan' || $kontrak->status_semakan == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        return $this->render(
                        '_syaratsm', [
                    'icno' => $kontrak->icno,
                    'id' => $kontrak->id,
                    'edit' => $edit,
                    'view' => $view,
                    'kontrak' => $kontrak,
                    'biodata' => $biodata,
                    'pengajian' => $pengajian,
                    'separuh' => $separuh,
                        ]
        );
    }

    public function actionViewSyarat2($id) {
        $sabatikal = \app\models\cbelajar\RefSabatikal::find()->all();
        $latihan = \app\models\cbelajar\RefLatihanIndustri::find()->all();
        $mod = $this->findCekSyarat2($id);
        $kontrak = $this->findModel($id);
        if ($kontrak->load(Yii::$app->request->post())) {

            if ($kontrak->status_semakan == 'Dibawa Ke Mesyuarat') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Dibawa ke Mesyuarat!']);
            } elseif ($kontrak->status_semakan == 'Dokumen Tidak Lengkap') {
                Yii::$app->session->setFlash('alert', ['title' => 'Dokumen Tidak Lengkap', 'type' => 'danger', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $kontrak->c_date = date('Y-m-d H:i:s');
            $kontrak->save(false);
            return $this->redirect(['cbadmin/senaraitindakan1']);
        }
        if ($kontrak->status_semakan == 'Dibawa Ke Mesyuarat' || $kontrak->status_semakan == 'Dokumen Tidak Lengkap') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        return $this->render(
                        '_syarat', [
                    'mod' => $mod,
                    'icno' => $kontrak->icno,
                    'id' => $kontrak->id,
                    'edit' => $edit,
                    'view' => $view,
                    'kontrak' => $kontrak,
                    'sabatikal' => $sabatikal,
                    'latihan' => $latihan,
                        ]
        );
    }

    protected function findIklanbyID($id) {
        if (($model = TblUrusMesyuarat::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findPengajianbyID($id) {
        if (($model = TblPengajian::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findBiasiswaByID($id) {
        if (($model = TblBiasiswa::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findKeluargabyICNO() {
        if (($model = Tblkeluarga::findAll(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findSabatikalbyICNO() {
        if (($model = \app\models\cbelajar\TblSabatikal::findAll(['icno' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findAkademikbyICNO() {
        if (($model = Tblpendidikan::findAll(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findAkademik() {
        if (($model = Tblpendidikan::findOne(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findDokumenbyICNO() {
        if (($model = TblFilePemohon::findAll(['uploaded_by' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findPengajianbyICNO() {
        if (($model = TblPengajian::findAll(['icno' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findBiasiswabyICNO() {
        if (($model = TblBiasiswa::findAll(['icno' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUploadsurat($id) {
        $message = '';
        $model = $this->findModel($id);
        $dokumen = \app\models\cbelajar\TblSurat::find()->where(['icno' => $model->id])->one();
        if (!$dokumen) {
            $dokumen = new TblSurat();
            $dokumen->tajuk = 'Surat Tawaran Berjaya';
        }
        $surat = $model->surat;
        if ($dokumen->load(Yii::$app->request->post())) {
            Yii::$app->FileManager->DeleteFile($surat);
            $file = UploadedFile::getInstance($dokumen, 'file');
            if ($file) {
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'cutibelajar/surat');
                $filepath = $fileapi->file_name_hashcode;
                if ($fileapi->status == true) {
                    $message = 'Berjaya Disimpan';
                }
            } else {
                $filepath = '';
            }
            $dokumen->dokumen = $filepath;
            $dokumen->icno = $model->id;
            $dokumen->tahun = date("Y");
            $dokumen->created_dt = new \yii\db\Expression('NOW()');
            $dokumen->save();
        }
        return $this->renderAjax('uploadsurat', [
                    'dokumen' => $dokumen,
                    'message' => $message
        ]);
    }

    protected function findBio($id) {
        return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
    }

    public function actionSenaraiStaffFakulti() {
        $userID = Yii::$app->user->getId();
//        $currentYear = date('Y');
        $urus = $this->GridLaporDiri();

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
                ->andWhere(['job_category' => [1]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['<>', 'tblprcobiodata.Status', '1'])
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


        if (Department::find()->where([ 'chief' => Yii::$app->user->getId(), 'isActive' => 1])->exists()) {
            return $this->render('senarai_staff', [
                        'model' => $staffCurrentIDP,
                        'dataProvider' => $dataProvider,
                        'model2' => $staffCurrentIDP2,
                        'dataProvider2' => $dataProvider2,
                        'urus' => $urus
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function GridLaporDiri() {
        $userID = Yii::$app->user->getId();

        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblLapordiri::find()
                    ->joinWith('kakitangan.department')
                    ->joinWith('kakitangan.jawatan')
                ->joinWith('pengajian')
                    ->where(['chief' => $userID])
                    ->orWhere(['department.pp' => $userID])
                    ->andWhere(['job_category' => [1, 2]])
                    ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                    ->andWhere(['status_pengajian' => [2, 4, 6, "BELUM SELESAI"]])
                    ->orderBy('CONm'),
//                    ->orderBy(['cb_tbl_pengajian.tarikh_mula'=>SORT_DESC]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $data;
    }

    public function actionSenaraiStaffFakultiPp() {
        $userID = Yii::$app->user->getId();
//        $currentYear = date('Y');
        $urus = $this->GridLaporDiri();
                $test = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();

        $staffCurrentIDP = \app\models\cbelajar\TblPengajian::find()
                ->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
                     ->orWhere(['tblprcobiodata.DeptID' => $test->DeptId])
                ->andWhere(['job_category' => 2])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])
                ->orderBy('CONm');

        $staffCurrentIDP2 = \app\models\cbelajar\TblPengajian::find()
                ->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
                     ->orWhere(['tblprcobiodata.DeptID' => $test->DeptId])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1, 2]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['!=', 'tblprcobiodata.Status', '1'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])
                ->orderBy('CONm');

        $dataProvider = new ActiveDataProvider([
            'query' => $staffCurrentIDP,
            'pagination' => [

                'pageSize' => 10,
            ],
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $staffCurrentIDP2,
            'pagination' => [

                'pageSize' => 5,
            ],
        ]);
        if (Department::find()->where([ 'pp' => Yii::$app->user->getId()])->exists() ||
        AksesPa::find()->where([ 'icno' => Yii::$app->user->getId()])->exists() )
              {

            return $this->render('senarai_staff_pp', [
                        'model' => $staffCurrentIDP,
                        'dataProvider' => $dataProvider,
                        'model2' => $staffCurrentIDP2,
                        'dataProvider2' => $dataProvider2,
                        'urus' => $urus,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }
      protected function findPermohonanbyID($id) {
        if (($model = TblPermohonan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     public function actionSenaraiPermohonan()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai  = '';
//           $id = $model->icno;
//        $p = $this->findP($id);
        $status = ['Tunggu Perakuan', 'Diperakukan', 'Tidak Diperakukan'];
      
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $a = (AksesPa::find()->where( ['icno' => $icno]));
//        $kk = Department::find()->where( ['chief' => $icno, 'isActive' => '1'])->one();
//        $kj = $kk->chief;
       if ($a->exists())
       {
//       ->exists()) || (\app\models\cbelajar\TblAccess::find()->where( ['icno' => $icno] )->exists()){
             $senarai = TblPermohonan::find()->joinWith('kakitangan')->where(['status_jfpiu' =>["Tunggu Perakuan","Diperakukan","Tidak Diperakukan"]])->
                     andWhere(['cb_tbl_permohonan.status_proses'=>"Selesai Permohonan"])
                     ->andWhere(['tblprcobiodata.DeptID' => $test->DeptId])
->orderBy(['tarikh_m' => SORT_DESC]);
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
    
     public function actionComplain() {

        $biodata = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()]);
        $status = RefStatusAduan::find()->all();

        $model = new TblAduan();
        $record = TblAduan::find()->where(['ICNO'=> $this->ICNO()])->orderBy(['tarikh_mohon' => SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $k = RefKriteria::findOne(['id' => $model->kriteria_id]);
                $content = "Aduan Pengajian Lanjutan : " . $k->type . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', ['cutibelajar/record-complain'], ['class' => 'btn btn-primary btn-sm']);
                $this->notifikasi('860130125080', $content); //Pn Yanti
                $this->notifikasi('870818495847', $content); // goraid
                $this->notifikasi('950829125446', $content); // wana
                $this->notifikasi('840929125614', $content); // kak dayang

            

            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'saved.']);
            return $this->redirect(['complain']);
        }

        return $this->render('form_complain', [
                    'model' => $model,
                    'record' => $record,
                    'status' => $status,
                    'biodata' => $biodata,
        ]);
    }
      public function actionRecordComplain() {
        return $this->render('form_complain_home', [
        ]);
    }
      public function Grid($query) {
        $data = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
     public function actionRecordComplainByStatus($status) {
    
            $dataProvider = $this->Grid(TblAduan::find()->where(['status_id' => $status])->orderBy(['tarikh_mohon' => SORT_DESC]));
       
        return $this->render('form_complain_record', [
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionComplainInAction($id) {

            $model = TblAduan::find()->where(['id' => $id])->one();
      
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->status_id == 2) {
                $model->tarikh_tindakan = date('Y-m-d H:i:s');
                $model->tindakan_by = Yii::$app->user->getId();
                $content = "Aduan anda dalam proses tindakan lanjut. " . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', ['cutibelajar/complain'], ['class' => 'btn btn-primary btn-sm']);
            } else {
                $model->tarikh_selesai = date('Y-m-d H:i:s');
                $model->selesai_by = Yii::$app->user->getId();
                $content = "Aduan berjaya diselesaikan sila buat semakan kendiri. " . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', ['cutibelajar/complain'], ['class' => 'btn btn-primary btn-sm']);
            }
            $model->save(false);
            $this->notifikasi($model->ICNO, $content); //notify pemohon

            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'saved.']);

                return $this->redirect(['record-complain']);
           
        }

        return $this->render('form_complain_action', [
                    'model' => $model,
        ]);
    }
    public function actionComplainFeedback($id) {
     
            $model = TblAduan::find()->where(['ICNO' => $this->ICNO()])->andWhere(['id' => $id])->one();
      

        return $this->renderAjax('form_complain_feedback', [
                    'model' => $model,
        ]);
    }
    

}

