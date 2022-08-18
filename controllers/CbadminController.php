<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\models\Notification;
use yii\web\UploadedFile;
use app\models\hronline\Tblpendidikan;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblkeluarga;
use app\models\cbelajar\TblAdmin;
use app\models\cbelajar\TblpImage;
use app\models\cbelajar\TblAccess;
use app\models\cbelajar\TblPermohonan;
use app\models\cbelajar\TblPermohonanSearch;
use app\models\hronline\Department;
use app\models\cbelajar\TblPengajian;
use app\models\cbelajar\TblUrusMesyuarat;
use app\models\cbelajar\TblSurat;
use yii\helpers\ArrayHelper;
use app\models\cbelajar\TblBiasiswa;
use app\models\cbelajar\AdminJfpiu;
use app\models\cbelajar\AdminJfpiuSearch;
use app\models\cbelajar\Option;
use yii\filters\AccessControl;
use app\models\cbelajar\TblLanjutan;
use app\models\cuti\TblRecords;
use kartik\mpdf\Pdf;
use tebazil\runner\ConsoleCommandRunner;
use app\models\cuti\Tindakan;
use app\models\cuti\Layak;
use app\models\cuti\TblResearch;
use app\models\smp_ppi\CutiPenyelidikan;
use app\models\cuti\CutiLog;
use app\models\cbelajar\TblLkk;
use app\models\cbelajar\AksesPa;

class CbadminController extends \yii\web\Controller {

//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['kj','page-lapor','page-tuntutan','admin-view', 'halaman-admin', 'senaraitindakan1', 'page-semak','senaraitindakanlain',
//                    'senaraitindakan', 'nominal-damages','laporan'],
//                'rules' => [
//                    [
//                        'actions' => ['kj','page-lapor','page-tuntutan','admin-view', 'halaman-admin', 'senaraitindakan1', 'page-semak', 'senaraitindakanlain',
//                            'senaraitindakan','nominal-damages', 'laporan'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                    
//                    
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    //                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }
    public function behaviors() {
        return

//                [
//                    'access' => [
//                        'class' => AccessControl::className(),
//                        'only' => ['kj', 'page-lapor', 'page-tuntutan', 'admin-view', 'halaman-admin', 'senaraitindakan1', 'page-semak', 'senaraitindakanlain',
//                            'senaraitindakan', 'nominal-damages', 'laporan', 'adminview', 'cetak-rekod', 'senaraitindakantuntutan', 'senaraitindakan1', 'lkk-report',
//                            'search-pengajian', 'search-biasiswa', 'search-all-pengajian',
//                            'list-dokumen', 'search-lkk','pengajian', 'search-cb','belum-capai','belum-mula-pengajian',
//                            'cp-list','cp-details-bsm','search-lapor','page','view-rekod-staf','search','senarai-tambah-manual','daftar-pengajian-lanjutan','senarai-bon','bon'],
//                        'rules' => [
//                            [
//                                'actions' => ['kj', 'page-lapor', 'page-tuntutan', 'admin-view', 'halaman-admin', 'senaraitindakan1', 'page-semak', 'senaraitindakanlain',
//                                    'senaraitindakan', 'nominal-damages', 'laporan', 'adminview', 'cetak-rekod', 'senaraitindakantuntutan',
//                                    'lkk-report', 'search-pengajian', 'search-biasiswa', 'search-all-pengajian',
//                                    'list-dokumen', 'search-lkk','pengajian','cp-list','search-cb','belum-capai','belum-mula-pengajian',
//                                    'cp-details-bsm','search-lapor','page','view-rekod-staf','search','senarai-tambah-manual','daftar-pengajian-lanjutan','senarai-bon','bon'],
//                                'allow' => true,
//                                'matchCallback' => function($rule, $action) {
//
////                            $icno=Yii::$app->user->getId();
////                            if($icno){
////                            $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
////                            if(($biodata->statLantikan=='1' && $biodata->jawatan->job_category =='1') ||
////                               ($biodata->statLantikan=='2' && $biodata->jawatan->job_category =='1') || 
////                               ($biodata->statLantikan=='1' && $biodata->jawatan->job_category =='2')){
////                                return true;
////                               }
////                            }
////                           if((Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jobCategory == "1") 
////                           || (Yii::$app->user->identity->statLantikan == "2"  && Yii::$app->user->identity->jobCategory == "1")||
////                                   (Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jobCategory == "2"))
////                          {
////                             return TRUE;
////                           }
//
//                            if (in_array(Yii::$app->user->getId(), ['950829125446', '860130125080',
//                                        '840929125614', '870818495847', '701203106182'])) {
//                                return TRUE;
//                            }
//
//                            return FALSE;
//                        },
//                            ],
//                        ],
//                    ],
//                    'verbs' => [
//                        'class' => VerbFilter::className(),
//                        'actions' => [
//                        //                    'logout' => ['post'],
//                        ],
//                    ],
//        ];
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['*'],
                        'rules' => [
                            [
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                        ],
                    ],
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'delete' => ['POST'],
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

//    public function actionIndex()
//    {
//         $carian = new Tblprcobiodata();
//         $dataProvider = $carian->carian(Yii::$app->request->queryParams); 
// if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
//        return $this->render('index', [
//                    'carian' => $carian,
//                    'model' => $dataProvider,
//        ]);
//    }
//    else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('../cutibelajar/halaman-utama-pemohon');}
//    }
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
            return $this->render('index');
        }
        $model = new TblPermohonan();
    }

    public function actionAdminview($id) {
        $id = $id;
        $biodata = $this->findMaklumat1($id);
        $model = $this->findBiodata($id);
//        $model2 = $this->findKemudahan($id);
        if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('view', [
                        'model' => $model,
                        'akademik' => $biodata->akademik,
                        'pengajian' => $biodata->pengajian,
                        'penerbangan' => $biodata->penerbangan,
                        'lain' => $biodata->lain,
                        'lapor' => $biodata->lapor,
                        'lkk' => $biodata->lkk,
//                    'model2' => $model2,
            ]);
        }
    }

    public function actionTetapanbukapermohonan() {

        $model = \app\models\cbelajar\TblBukapermohonan::find()->All(); //cari senarai admin
        return $this->render('tetapanpembukaanpermohonan', [
                    'model' => $model
        ]);
    }

    public function findIklan($status) {
        $senarai_iklan = new ActiveDataProvider
                ([
            'query' => TblUrusMesyuarat::find()->where(['status' => $status]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $senarai_iklan;
    }

    protected function findJumlahPermohonanSemasa() {
        return TblPengajian::find()->where(['status' => '1'])->count();
    }

    public function actionHalamanAdmin() {
//        $year = date('Y');
        $icno = Yii::$app->user->getId();
        $iklan_semasa = $this->findIklan(1);
        $senarai_iklan = $this->findIklan(0);
        $info = \app\models\system_core\TblDahsboard::findOne(['icno' => $icno]);
        $year = date('Y');

        $lulus = TblPengajian::find()->where(['status' => 1, 'userID' => '1'])->count();
//        $ = TblPengajian::find()->where(['status'=> 1,'userID' => '1'])->count();
//        $lapor = \app\models\cbelajar\TblLapordiri::find()->where(['tahun' => $year])->count();
        $lapor = \app\models\cbelajar\TblLapordiri::find()->joinWith('pengajian')->where(['cb_tbl_lapordiri.tahun' => $year, 'cb_tbl_pengajian.userID' => 1])->count();

        $p = $lulus + $lapor;

//        $tot = $p /100;
//                       $lulusa = TblPengajian::find()->where(['status'=> 1,'jenisID' => '2'])->count();
        $status = Tblprcobiodata::find()->joinWith('jawatan')->where(['Status' => 2, 'job_category' => 1])->count();
        $tot_a = Tblprcobiodata::find()->joinWith('jawatan')->where(['job_category' => 1])->count();
        $admin = \app\models\cbelajar\TblLapordiri::find()->joinWith('pengajian')->where(['cb_tbl_lapordiri.tahun' => $year, 'cb_tbl_pengajian.userID' => 2])->count();

        $status_p = TblPengajian::find()->where(['userID' => 2, 'status' => 1])->count();
        $q = $status_p + $admin;
        $tot_p = Tblprcobiodata::find()->joinWith('jawatan')->where(['job_category' => 2])->count();
        $jumlah_permohonan = $this->findJumlahPermohonanSemasa();
//        var_dump($status);die;
//        $jumlah_permohonan1 = $this->findJumlahPermohonanTahunan();
//        $jumlah_permohonan = $this->findJumlahPermohonanSemasa();
//        $jumlah_permohonan_berjaya = $this->findJumlahPermohonanBerjaya();
//        $jumlah_permohonan_gagal = $this->findJumlahPermohonanDitolak();

        if (TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('halaman-admin', [

                        'iklan_semasa' => $iklan_semasa,
                        'senarai_iklan' => $senarai_iklan,
                        'info' => $info,
                        'status' => $status,
                        'tot_a' => $tot_a,
                        'status_p' => $status_p,
                        'tot_p' => $tot_p,
                        'lulus' => $lulus,
                        'lapor' => $lapor,
                        'p' => $p,
                        'q' => $q,
//            'tot'=>$tot,
//                    'jumlah_permohonan1' => $jumlah_permohonan1,
                        'jumlah_permohonan' => $jumlah_permohonan,
//                    'jumlah_permohonan_berjaya' => $jumlah_permohonan_berjaya,
//                    'jumlah_permohonan_gagal' => $jumlah_permohonan_gagal,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('/cutibelajar/index');
        }
    }

    public function actionPage() {

        $icno = Yii::$app->user->getId();


        if (TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('page-data');
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('/cutibelajar/index');
        }
    }

    public function actionPageTuntutan() {

        $icno = Yii::$app->user->getId();


        if (TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('page-tuntutan');
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('/cutibelajar/index');
        }
    }

    public function actionPageSemak() {

        $icno = Yii::$app->user->getId();


        if (TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('pengajian/page-semak');
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('/cutibelajar/index');
        }
    }

    public function GridCutiPenyelidikan() {
        $icno = Yii::$app->user->getId();
        if (TblAccess::find()->where(['icno' => Yii::$app->user->getId(), 'level' => 2])->exists()) {

            $data = new ActiveDataProvider([
                'query' => TblRecords::find()
                        ->where(['jenis_cuti_id' => 17])->andWhere(['IN', 'status', ['CHECKED', 'VERIFIED', 'ENTRY', 'APPROVED']]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

            return $data;
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('../cutibelajar/index');
        }
    }

    //cuti penyelidikan
    public function actionCpList() {
        $icno = Yii::$app->user->getId();
        $cp = $this->GridCutiPenyelidikan();
        $tindakan = Tindakan::find()->where(['icno_tindakan' => $icno])->andWhere(['status' => 1])->one();
        // var_dump($tindakan);die;

        if ($tindakan) {
            $icno = $tindakan->icno_pemberi_kuasa;
        }

        $model = TblRecords::find()->where(['peraku_by' => $icno])->andWhere(['IN', 'status', ['AGREED', 'APPROVED', 'CHECK']])->all();
        $app = TblRecords::find()->where(['lulus_by' => $icno])->andWhere(['IN', 'status', ['APPROVED', 'CHECKED', 'VERIFIED', 'ENTRY']])->all();

        if ($model = Yii::$app->request->post('selection')) {
            $selected = '';
            foreach ($model as $i) {

                $selected .= ',' . $i;
            }
            return $this->redirect(['sahkan-selected-bsm', 'selected' => $selected]);
        }
        // $bal = Layak::getBakiLatest($model->icno);
        if (TblAccess::find()->where(['icno' => Yii::$app->user->getId(), 'level' => 2])->exists()) {

            return $this->render('cp-list', [
                        'model' => $model,
                        'app' => $app,
                        'cp' => $cp,
                            // 'bal' => $bal,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('../cutibelajar/index');
        }
    }

    public function actionCpDetailsBsm($id) {

        $model = TblRecords::findOne($id);
        $model->scenario = "agree";
        $bal = Layak::getBakiLatest($model->icno);
        $res = TblResearch::findOne(['cuti_record_id' => $id]);
        $mod = CutiPenyelidikan::findOne(['NoKadPengenalan' => $model->icno, 'ProjectID' => $model->research_id]);

        if ($res->load(Yii::$app->request->post())) {

            $res->verify_dt = date('Y-m-d H:i:s');
            $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
            if ($res->verify_status == "APPROVED") {
                var_dump($res);
                if ($model->type == 1) {

                    $res->nc_status = "CHECKED";
                    $model->status = "CHECKED";
                    $model->semakan_dt = date('Y-m-d H:i:s');
                    $model->semakan_remark = $res->verify_remark;
                } else {

                    $res->bsm_status = "VERIFIED";
                    $model->status = "CHECKED";
                    $model->semakan_dt = date('Y-m-d H:i:s');
                    $model->semakan_remark = $res->verify_remark;
                }
            } else {
                $model->status = "REJECTED";
                $model->semakan_dt = date('Y-m-d H:i:s');
                $model->semakan_remark = $res->verify_remark;
            }


            if ($res->save()) {
                $model->save(false);
                // if ($model->status == "VERIFIED") {
                //     $this->Notification($model->lulus_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ' Pada ' . $model->full_date . ' Menunggu Perakuan/Kelulusan Anda. Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/pegawai/senarai-peraku-lulus">disini</a> untuk membuat tindakan');
                // }
                // if ($model->status == "REJECTED") {
                //     $this->Notification($model->icno, 'Cuti', 'Permohonan Cuti Anda Pada ' . $model->full_date . ' Tidak Diluluskan oleh Pegawai Peraku');
                // }
                $this->Perakulog($model->id, $model->status);
                // $runner = new ConsoleCommandRunner();
                // $runner->run('dashboard/pending-task-individu', [$model->lulus_by]);
                // $runner->run('dashboard/pending-task-individu', [$model->peraku_by]);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => ' Dihantar']);
                return $this->redirect(['cp-list']);
            }
        }

        return $this->renderAjax('cp-details-bsm', [
                    'model' => $model,
                    'bal' => $bal,
                    'res' => $res,
                    'mod' => $mod,
        ]);
    }

    public function syif($icno) {

        $bol = false;
        $gred = ['119', '118', '117', '116', '302', '303', '360', '368', '295', '389'];
        $identify = Tblprcobiodata::find()->where(['ICNO' => $icno])->andWhere(['IN', 'gredJawatan', $gred])->one();
        if ($identify) {
            $bol = true;
        }
        return $bol;
    }

    public function Perakulog($id, $status) {
        $log = new CutiLog();
        $icno = Yii::$app->user->getId();
        $log->ntf_session_id = $icno;
        $log->ntf_tindakan = "Peraku / Lulus";
        $log->ntf_status = $status;
        $log->ntf_cr_id = $id; //id dari tblrecords
        $log->ntf_datetime = date('Y-m-d h:i:s');
        $log->save();
    }

    public function actionLeaveDetailLulus($id) {

        $model = TblRecords::findOne($id);
        $cp = new TblPermohonan();
        $session_id = Yii::$app->user->getId();
        $model->scenario = "agree";

        $ori_fd = $model->full_date;
        $ori_sd = $model->start_date;
        $ori_ed = $model->end_date;
        $bal = Layak::getBakiLatest($model->icno);

        if ($model->load(Yii::$app->request->post())) {

            $arr = explode(" ", $model->full_date);

            $newsDate = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
            $neweDate = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));

            $var = false;
            if ($model->jenis_cuti_id == 28) {
                $var = false;
            } else {
                if ($neweDate != $ori_ed || $newsDate != $ori_sd) {
                    // echo 'here';die;

                    $model->start_date = $newsDate;
                    $model->end_date = $neweDate;
                    // $model->full_date = $model->full_date;
                    $model->tempoh = ($this->syif($model->icno)) ? $model->totalDays : $model->tempoh = $model->totalDaysEx;
                    $var = true;
                } else {

                    $model->start_date = $newsDate;
                    $model->end_date = $neweDate;
                    $model->tempoh = ($this->syif($model->icno)) ? $model->totalDays : $model->tempoh = $model->totalDaysEx;
                    // $model->tempoh = $model->totalDays;
                }
            }

            $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);

            $date1 = date_create($model->start_date);
            $date2 = date_create($model->end_date);
            $dt1 = date_format($date1, "d/m/Y");
            $dt2 = date_format($date2, "d/m/Y");
            $model->lulus_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                if ($var) {
                    $this->Log($model->icno, $id, $ori_fd, $ori_sd, $ori_ed);
                    $this->Notification($model->icno, 'Cuti', 'Permohonan Cuti Anda Pada ' . $dt1 . ' Hingga ' . $dt2 . ' Telah Diluluskan, Tapi Tarikh Cuti Anda Telah Di ubah Oleh Ketua Jabatan Anda. Sila Rujuk Senarai Cuti Anda');
                } else {
                    if ($model->jenis_cuti_id == 28) {
                        $ntf = new Notification();
                        $ntf->icno = $model->icno;
                        $ntf->title = "Surat Kelulusan Cuti Bersalin";
                        $ntf->content = 'Permohonan Cuti Bersalin anda telah diluluskan. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/individu/list">disini</a> untuk memuat turun surat kelulusan cuti bersalin anda';
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                    } else {


                        if ($model->status == 'APPROVED') {

                            $cp->icno = $model->icno;
                            $cp->status_cb = "CUTI PENYELIDIKAN";
                            $cp->save(false);

                            $this->notifikasi($model->icno, 'Cuti', 'Permohonan Cuti Anda Pada ' . $dt1 . ' Hingga ' . $dt2 . ' Telah Diluluskan');
                        } elseif ($model->status == 'REJECTED') {
                            $this->notifikasi($model->icno, 'Cuti', 'Permohonan Cuti Anda Pada ' . $dt1 . ' Hingga ' . $dt2 . ' Tidak Diluluskan');
                        }
                    }
                }

                $this->Perakulog($model->id, $model->status);

                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$model->lulus_by]);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan !']);
                return $this->redirect(['cp-list']);
            }
        }
        if ($model->status == 'APPROVED' || $model->status == 'REJECTED') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        return $this->renderAjax('cp-leave-detail-lulus', [
                    'model' => $model,
                    'bal' => $bal,
                    'edit' => $edit,
                    'view' => $view
        ]);
    }

    public function actionPageLapor() {

        $icno = Yii::$app->user->getId();


        if (TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('lapordiri/page-lapor');
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('/cutibelajar/index');
        }
    }

    public function actionPageBulanan() {

        $icno = Yii::$app->user->getId();


        if (TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('admin/page-bulan');
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('/cutibelajar/index');
        }
    }

    public function actionTetap($end = null, $jfpiu = null, $nama = null) {
        $models = \app\models\cbelajar\TblElaun::find()
                        ->joinWith('pengajian')->where(['status_bayaran' => "BELUM DIPROSES"])
                        ->andWhere(['cb_tbl_pengajian.status' => 1])->all();

        $searchModel = new \app\models\cbelajar\TblAllowanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//        $arrayicno = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=','Status', '6']): '';
//        $query = empty($arrayicno)? \app\models\cbelajar\TblElaun::find() : \app\models\cbelajar\TblElaun::find()->where(['icno' => $arrayicno->select(['ICNO']), 'bayaran'=>"UMS"]);    
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//               'pagination' => [
//                'pageSize' => 20,]
//            
//        ]);

        $selection = (array) Yii::$app->request->post('selection'); //typecasting
//var_dump( $selection); die;
        $arraynot = '';
        if (Yii::$app->request->post()) {
            foreach ($selection as $id) {
//                if(\app\models\cbelajar\TblBiasiswa::find()->where(['id' => $id])->exists()){
//                    $arraynot = $arraynot.  \app\models\cbelajar\TblBiasiswa::find()->where(['id' => $id])->one()->kakitangan->CONm.', ';
//                }else{
                $model = \app\models\cbelajar\TblElaun::find()->joinWith('pengajian')->where(['icno' => $id])->andWhere(['cb_tbl_pengajian.status' => 1])->exists() ?
                        \app\models\cbelajar\TblElaun::find()->joinWith('pengajian')->where(['icno' => $id])->andWhere(['cb_tbl_pengajian.status' => 1])->one() : new \app\models\cbelajar\TblElaun();
//                    $model->icno = $id;

                $model->dt_sbayar = Yii::$app->request->post('tutup');
                $model->dt_nbayar = Yii::$app->request->post('tahun');
                $model->save(false);

//                    $this->notifikasi($id, 'For your information, your current contract period will end on '.date_format(date_create($model->kakitangan->endDateLantik), 'd F Y').'; Please submit your contract extension application through the system before or on '.date_format(date_create($model->end_date), 'd F Y').Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
            }
//                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Cannot open for '.$arraynot.' because there is existing pending application on their name']);
        }



//       $dataProvider->query->andFilterWhere(['elaun'=>"KELUARGA" ]);
//        isset(Yii::$app->request->queryParams['icno'])? $dataProvider->query->andFilterWhere(['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';
//        isset(Yii::$app->request->queryParams['jenis_elaun'])? $dataProvider->query->andFilterWhere(['like', 'jenis_elaun',  Yii::$app->request->queryParams['jenis_elaun'] ]):'';
//        $search = new \app\models\hronline\TblprcobiodataSearch();

        return $this->render('admin/senarai_keluarga', [
//            'query' => $query,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'jfpiu' => $jfpiu,
//                    'a' => $a,
        ]);
    }

    protected function findBiodata1($id) {
        return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
    }

    public function findBonkhidmat($id) {
        return \app\models\cbelajar\Tblbonkhidmat::findAll(['laporID' => $id]);
    }

    public function findBon3($id) {
        return \app\models\cbelajar\Tblbonkhidmat::findAll(['icno' => $id]);
    }

//    public function findBonkhidmat($ICNO) {
//        $encryptID = 'SELECT * FROM hrd.cb_tbl_bonkhidmat WHERE SHA1(icno) =:icno';
//        return \app\models\cbelajar\Tblbonkhidmat::findBySql($encryptID, [':icno' => $ICNO])->all();
//    }
    public function findBon($id) {
        return \app\models\cbelajar\TblBon::findAll(['icno' => $id]);
    }

    public function findB($id) {
        return \app\models\cbelajar\TblBon::findAll(['laporID' => $id]);
    }

    public function findNd($id) {
        return \app\models\cbelajar\TblNd::findAll(['laporID' => $id]);
    }

    public function findE($id) {
        return \app\models\cbelajar\TblElaunLulus::findAll(['bID' => $id]);
    }

    public function findBon2($id) {
        return \app\models\cbelajar\Tblbonkhidmat::findAll(['icno' => $id]);
    }

    public function findTuntutanrugi($id) {
        return \app\models\cbelajar\TblTuntutan::findAll(['laporID' => $id]);
    }

    public function findT($id) {
        return \app\models\cbelajar\TblTuntutan::findAll(['icno' => $id]);
    }

    public function findNominal($id) {

//        $encryptID = 'SELECT * FROM hrd.cb_tbl_lapordiri WHERE SHA1(icno) =:icno';
        return \app\models\cbelajar\TblLapordiri::findOne(['icno' => $id]);
    }

    public function findBon1($id) {
        $encryptID = 'SELECT * FROM hrd.cb_tbl_bon WHERE SHA1(icno) =:icno';
        return \app\models\cbelajar\TblBon::findBySql($encryptID, [':icno' => $id])->one();
    }

    public function actionViewRekodStaf($id) {

        $biodata = $this->findBiodata1($id);
//            $rekod= $this->findRekod($id);
        $bon = $this->findBon($id);
        $bon1 = $this->findBon2($id);
        $tuntut = $this->findT($id);
        $pengajian = $this->findPengajian($id);
        $pengajians = $this->findPengajian($id);

        $b = $this->findBias($id);
        $lkk = $this->findLkk($id);
        $nd = $this->findNominal($id);
//            $pengajian = TblPengajian::find()->where(['icno'=> $id])->all();

        if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('main', [
                        'biodata' => $biodata,
//                    'pengajian' => $biodata->pengajian,
                        'lkk' => $lkk,
//                    'rekod' => $rekod,
                        'bon' => $bon,
                        'bon1' => $bon1,
                        'tuntut' => $tuntut,
                        'pengajian' => $pengajian,
                        'pengajians' => $pengajians,
                        'b' => $b,
                        'nd' => $nd,
            ]);
        }
    }

    public function actionCetakRekod($id) {


        $biodata = $this->findBiodata1($id);
//            $rekod= $this->findRekod($id);
        $bon = $this->findBon($id);
        $bon1 = $this->findBon2($id);
        $tuntut = $this->findT($id);
        $pengajian = $this->findPengajian($id);
        $b = $this->findBias($id);
        $lkk = $this->findLkk($id);
        $nd = $this->findNominal($id);

        $content = $this->renderPartial('cetak-rekod', [
            'biodata' => $biodata,
//                    'pengajian' => $biodata->pengajian,
            'lkk' => $lkk,
//                    'rekod' => $rekod,
            'bon' => $bon,
            'bon1' => $bon1,
            'tuntut' => $tuntut,
            'pengajian' => $pengajian,
            'b' => $b,
            'nd' => $nd,]);


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
            'options' => ['title' => 'Rekod Pengajian Lanjutan Kakitangan'],
            // call mPDF methods on the fly
            'methods' => [
//              'SetHeader' => ['Permohonan Baharu Pengajian Lanjutan,Unit Pengembangan Profesionalisme'],
                'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
            ], // call mPDF methods on the fly
        ]);

        return $pdf->render();
    }

    public function actionViewLedgerTajaan($id) {

        $biodata = $this->findBiodata1($id);
        $pengajian = $this->findPengajian1($id);
        $elaun = $this->findElaun($id);

//            $pengajian = TblPengajian::find()->where(['icno'=> $id])->all();

        if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('main-ledger', [
                        'biodata' => $biodata,
//                    'pengajian' => $biodata->pengajian,
                        'pengajian' => $pengajian,
                        'elaun' => $elaun,
            ]);
        }
    }

    public function actionCariLaporan() {

        $permohonan = $this->GridPermohonanTelahDiNotifikasi();
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['laporan-permohonan', 'date' => $search->y_m]);
        }

        return $this->render('a_laporan_permohonan', [
                    'permohonan' => $permohonan,
                    'search' => $search,
        ]);
    }

    public function actionViewBon($icno, $id) {

        $p = $this->findPengajian1($id);
//            $l=$this->findL($i);
        $lapor = $this->findLapordiri($id);
        $icno = $lapor->icno;
        $model = $this->findBiodata1($icno);
        $bon = $this->findBon($id);
        $bon1 = $this->findBonkhidmat($id);
        $tuntut = $this->findTuntutanrugi($id);
        $nd = $this->findNominal($id);

//            $pengajian = TblPengajian::find()->where(['icno'=> $id])->all();

        if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('main-bon', [
                        'model' => $model,
                        'bon' => $bon,
                        'bon1' => $bon1,
                        'tuntut' => $tuntut,
                        'nd' => $nd,
                        'lapor' => $lapor,
                        'p' => $p,
//                    'l'=>$l
//                    'pengajian' => $model->pengajian,
            ]);
        }
    }

    public function actionBon($id) {

        $biodata = $this->findBiodata1($id);
//            $rekod= $this->findRekod($id);
        $bon = $this->findBon($id);
        $bon1 = $this->findBon2($id);
        $tuntut = $this->findT($id);
        $pengajian = $this->findPengajian($id);
//            $p =$this->findPengajian1($id);
////            $l=$this->findL($i);
//            
//            $lapor = $this->findLapordiri($id);
//            $icno = $lapor->icno;
//                        $pengajian=$this->findPengajian($icno);
////             $alamat = \app\models\hronline\Tblrscoservstatus::find()->where(['ICNO' => $icno])->orderBy(['ServStatusStDt' => SORT_DESC])->all();
//
        $model = $this->findBiodata1($id);
//            $bon = $this->findB($id);
//            $bon1 = $this->findBonkhidmat($id);
//            $bon2 = $this->findBon2($id);
//            $biodata = $this->findBiodata1($icno);
//            $tuntut = $this->findTuntutanrugi($id);
        $nd = $this->findNominal($id);
//            $pengajian = TblPengajian::find()->where(['icno'=> $id])->all();
        $alamat = \app\models\hronline\Tblrscoservstatus::find()->where(['ICNO' => $id])->orderBy(['ServStatusStDt' => SORT_DESC])->all();
        $alamat2 = \app\models\hronline\Tblrscoapmtstatus::find()->where(['ICNO' => $id])->orderBy(['ApmtStatusStDt' => SORT_DESC])->all();

        if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('bon/bon', [
                        'model' => $model,
                        'bon' => $bon,
                        'bon1' => $bon1,
                        'tuntut' => $tuntut,
                        'nd' => $nd,
//                    'lapor' => $lapor,
//                    'p'=>$p,
                        'pengajian' => $pengajian,
//                    'bon2' => $bon2,
                        'alamat' => $alamat,
                        'alamat2' => $alamat2,
                        'biodata' => $biodata,
                        'id' => $id
//            'alamat'=>$alamat,
//                    'l'=>$l
//                    'pengajian' => $model->pengajian,
            ]);
        }
    }

    public function actionNominal($id) {

        $p = $this->findPengajian1($id);
//            $l=$this->findL($i);
        $lapor = $this->findLapordiri($id);
        $icno = $lapor->icno;
        $pengajian = $this->findPengajian2($icno);

        $model = $this->findBiodata1($icno);
        $nd = $this->findNd($id);
        $bon1 = $this->findBonkhidmat($id);
        $bon2 = $this->findBon2($id);
        $biodata = $this->findBiodata1($icno);

        $tuntut = $this->findTuntutanrugi($id);
//            $nd = $this->findNominal($id);
//            $pengajian = TblPengajian::find()->where(['icno'=> $id])->all();
        $alamat = \app\models\hronline\Tblrscoservstatus::find()->where(['ICNO' => $icno])->orderBy(['ServStatusStDt' => SORT_DESC])->one();

        if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('bon/nd', [
                        'model' => $model,
                        'nd' => $nd,
                        'bon1' => $bon1,
                        'tuntut' => $tuntut,
                        'nd' => $nd,
                        'lapor' => $lapor,
                        'p' => $p,
                        'pengajian' => $pengajian,
                        'bon2' => $bon2,
                        'alamat' => $alamat,
                        'biodata' => $biodata,
//                    'l'=>$l
//                    'pengajian' => $model->pengajian,
            ]);
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

    public function actionBiasiswa($id) {

//            $p =$this->findPengajian1($id);
//            $l=$this->findL($i);
        $p = $this->findStudy($id);

        $b = $this->findBiasiswa($id);
        $icno = $b->icno;
        $ed = $b->HighestEduLevelCd;
        $elaun = \app\models\cbelajar\KadarA::find()->WHERE(['id' => ["SARA", "EAP", "EAPK", "EBKS", "EBS", "EP", "EP4"]])->all();
        $kadarb = \app\models\cbelajar\KadarB::find()->WHERE
                        (['id' => ["SARA", "EAP", "EAPK", "EBKS", "EBS", "EP", "EP4", "ETSK", "ETSP", 'EAPSS']])->all();
        $kadarc = \app\models\cbelajar\KadarB::find()->WHERE
                        (['id' => ["SARA", "EAP", "EAPK", "EBKS", "EBP", "EP", "EP4", "ETSD", 'EAPSS']])->all();
        $e1 = \app\models\cbelajar\KadarA::find()->WHERE(['id' => ["SARA", "EAP", "EBS", "EP", "ETSK", "ETSP"]])->all();
        $e2 = \app\models\cbelajar\KadarA::find()->WHERE(['id' => ["SARA", "EAP", "EBP", "EP", "ETSD"]])->all();
        $t = \app\models\cbelajar\TblElaun::find()->where(['icno' => $icno, 'bayaran' => 'UMS'])->all();

        $lanjutan = TblLanjutan::find()->where(['icno' => $icno, 'HighestEdulevelCd' => $ed, 'status' => "LULUS"])->all();
        $e = $this->findE($id);
        $a = $this->findA($id);
        $biodata = $this->findBiodata1($icno);

        $self = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $gaji = $this->gaji();

        $MPH_STAFF_ID = \app\models\vhrms\ViewPayroll::find()->where(['MPH_STAFF_ID' => $self->COOldID])->one();
        $model2 = \app\models\vhrms\ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID, 'MPH_PAY_MONTH' => $gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();

        $c = \app\models\vhrms\ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID, 'MPH_PAY_MONTH' => $gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE', 'E'], ['like', 'MPDH_INCOME_CODE', 'B', ['like', 'MPDH_INCOME_CODE', 'F']]])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();

////            $lapor = $this->findLapordiri($id);
//            $icno = $p->icno;
//            $model = $this->findBiodata1($icno);
//            $pengajian = TblPengajian::find()->where(['icno'=> $id])->all();

        if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('biasiswa/biasiswa', [
                        'a' => $a,
                        'b' => $b,
                        'e' => $e,
                        'c' => $c,
                        'model2' => $model2,
                        'biodata' => $biodata,
                        'p' => $p,
                        'elaun' => $elaun,
                        'kadarb' => $kadarb,
                        'e1' => $e1,
                        't' => $t,
                        'kadarc' => $kadarc,
                        'e2' => $e2,
                        'lanjutan' => $lanjutan, 'id' => $id
//                    'l'=>$l
//                    'pengajian' => $model->pengajian,
            ]);
        }
    }

    public function actionPengajian($id) {

        $b = $this->findStudy($id);
        $icno = $b->icno;
        $biodata = $this->findBiodata1($icno);
        $pengajian = $this->findPengajian($icno);
        $test = $this->findBiasiswa($icno);
        $lain = $this->findLain($icno);



        if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('pengajian', [
                        'b' => $b,
                        'biodata' => $biodata,
                        'test' => $test,
                        'pengajian' => $pengajian,
                        'lain' => $lain,
            ]);
        }
    }

    public function actionLihatLkp($id) {

        $b = $this->findStudy($id);
        $icno = $b->icno;
        $biodata = $this->findBiodata1($icno);
        $pengajian = $this->findPengajian($icno);
        $test = $this->findBiasiswa($icno);
        $lain = $this->findLain($icno);
        $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => $icno, 'studyID' => $id])->all();



        if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('lkk/pengajian', [
                        'b' => $b,
                        'biodata' => $biodata,
                        'test' => $test,
                        'pengajian' => $pengajian,
                        'lain' => $lain, 'lkk' => $lkk
            ]);
        } else {
            return $this->render('lkk/s_pengajian', [
                        'b' => $b,
                        'biodata' => $biodata,
                        'test' => $test,
                        'pengajian' => $pengajian,
                        'lain' => $lain, 'lkk' => $lkk
            ]);
        }
    }

//    public function actionAddBon($icno,$id)
//    {
//        
//        $model = new \app\models\cbelajar\TblBon();
////        $model->icno = $id;
////        $l=$this->findtukLapordiri1($icno);
//        $lapor = $this->findLapordiri($id);
////        $i = $lapor->HighestEduLevelCd;
////        $id = $lapor->laporID;
//        
////        $icno=$id;
//        $data = \app\models\cuti\TblRecords::find()->where(['icno'=>$icno, 'jenis_cuti_id'=>38])
//                ->orderBy(['start_date' => SORT_DESC])->all();
//
////        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
////        var_dump('a');die;
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            $model->icno = $id;
//            $model->HighestEduLevelCd = $lapor->HighestEduLevelCd;
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tempoh Berkhidmat Berjaya Ditambah!']);
//            return $this->redirect(['bon?id='.$id.'&page=rekod-bon']);
//        }
//
//        return $this->renderAjax('add_bon', [
//            'model' => $model,
//            'lapor' => $lapor,
//            'data'=> $data,
////            'i' =>$i,
//            'id' =>$id,
////            'allbiodata' => $allbiodata,
//        ]);
//    }

    public function actionABon($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblBon();

        $lapor = $this->findLapordiri($id);
//        $pengajian=$this->findPengajian2($id);
        $pengajian = $this->findPengajian($id);

//        $icno = $lapor->icno;
        $alamat = \app\models\hronline\Tblrscoservstatus::find()->where(['ICNO' => $id])->orderBy(['ServStatusStDt' => SORT_DESC])->all();

        $data = \app\models\cuti\TblRecords::find()->where(['icno' => $id, 'jenis_cuti_id' => 38])
                        ->orderBy(['start_date' => SORT_DESC])->all();
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $id;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->updated_by = $i;
            $model->HighestEduLevelCd;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tempoh Berkhidmat Berjaya Ditambah!']);
            return $this->redirect(['bon?id=' . $id]);
        }

        return $this->renderAjax('bon/_add', [
                    'model' => $model,
                    'lapor' => $lapor,
                    'data' => $data,
                    'pengajian' => $pengajian,
                    'id' => $id,
                    'alamat' => $alamat,
        ]);
    }

    public function actionK() {

        $model = new \app\models\cbelajar\TblElaun();

        return $this->render('elaun', [
                    'model' => $model,
                    'bil' => 1,
        ]);
    }

    public function actionRekodElaun($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblElaun();
        $b = $this->findBiasiswa($id);
        $pengajian = $this->findPengajian2($id);
        $icno = $b->icno;
        $lkk = \app\models\cbelajar\TblElaun::find()->where(['icno' => $icno, 'jenis_elaun' => 'YP'])->all();
        $sewa = \app\models\cbelajar\TblElaun::find()->where(['icno' => $icno, 'jenis_elaun' => ['EBSR', 'EBSR2', 'EBSR3', 'EBSR4', 'EBSR5', 'EBSR6']])->all();
        $t = \app\models\cbelajar\TblElaun::find()->where(['icno' => $icno, 'jenis_elaun' => ['TIKET', 'TIKET2']])->all();
//        $elaun = \app\models\cbelajar\ElaunKadarB::find()->where(['id'=> "ESH"])->all();
//        $ep = \app\models\cbelajar\ElaunKadarB::find()->where(['id'=> ["EP", "EP1", "EP2", "EP3", "EP4"]])->all();
//        $eap = \app\models\cbelajar\ElaunKadar::find()->where(['id'=> ["EAP", "EAPK"]])->all();
//            $eaps = \app\models\cbelajar\ElaunKadarB::find()->where(['id'=> [ "EAPSS"]])->all();
//  $eb = \app\models\cbelajar\ElaunKadarB::find()->where(['id'=> [ "EB", "EBS", "EBP"]])->all();
//  $yp = \app\models\cbelajar\ElaunKadarB::find()->where(['id'=> [ "YP"]])->all();
//  $tp = \app\models\cbelajar\ElaunKadarB::find()->where(['id'=> [ "TP"]])->all();
//   $ebk = \app\models\cbelajar\ElaunKadar::find()->where(['id'=> [ "EBK", "EBKA", "EBKS", "EBKL"]])->all();
        $ebsr = \app\models\cbelajar\KadarA::find()->where(['id' => [ "EBSR", "EBSR2", "EBSR3", "EBSR4", "EBSR5", "EBSR6"]])->all();
        $ebsrb = \app\models\cbelajar\KadarB::find()->where(['id' => [ "EBSR", "EBSR2", "EBSR3", "EBSR4", "EBSR5", "EBSR6"]])->all();
        $sara = \app\models\cbelajar\TblElaun::find()->where(['icno' => $icno, 'jenis_elaun' => ['ESH']])->all();

//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->jenis_elaun = implode(",", $model->jenis_elaun);
//            $model->jenis_elaun_b = implode(",",$model->jenis_elaun_b);
            $model->icno = $b->icno;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//            $model->HighestEduLevelCd = $b->HighesftEduLevelCd;
            $model->bID = $id;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jenis Elaun Berjaya Ditambah!']);
            return $this->redirect(['biasiswa?id=' . $id]);
        } else {
            $model->jenis_elaun = explode(",", $model->jenis_elaun);
        }

        return $this->render('elaun/_proses', [

                    'model' => $model,
//              'edit' => $edit,
//              'view' => $view,
                    'pengajian' => $pengajian,
                    'id' => $id,
                    'b' => $b,
                    'sara' => $sara,
//            'elaun' => $elaun,
//            'ep'=> $ep,
//            'eap'=>$eap,
//            'eaps'=>$eaps,
//            'eb' =>$eb,
//            'yp' =>$yp,
//            'tp' => $tp,
//            'ebk' => $ebk,
                    'ebsr' => $ebsr,
                    'lkk' => $lkk,
                    'ebsrb' => $ebsrb,
                    'sewa' => $sewa,
                    't' => $t,
        ]);
    }

    public function actionTambahElaun($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblElaunLulus();
        $b = $this->findBiasiswa($id);
//        $lapor = $this->findLapordiri($id);
        $pengajian = $this->findPengajian2($id);
//        $icno = $lapor->icno;
//        $e=$this->findE($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $b->icno;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->updated_by = $i;
            $model->HighestEduLevelCd = $b->HighestEduLevelCd;
            $model->bID = $id;
            $b->nama_tajaan;
            $b->c_tajaan;
            $model->save(false);
            $b->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Penajaan Berjaya Disimpan']);
            return $this->redirect(['biasiswa?id=' . $id]);
        }



        if ($model->kadar == 'KADAR A' || $model->kadar == 'KADAR B') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }
        return $this->renderAjax('biasiswa/_addtajaan', [
                    'model' => $model,
//            'lapor' => $lapor,
                    'pengajian' => $pengajian,
                    'id' => $id,
                    'b' => $b,
                    'edit' => $edit,
                    'view' => $view,
        ]);
    }

    public function actionAElaun($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblElaun();

        $b = $this->findBiasiswa($id);
//        $lapor = $this->findLapordiri($id);
        $pengajian = $this->findPengajian2($id);
//        $icno = $lapor->icno;
//        $e=$this->findE($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->jenis_elaun = implode(",", $model->jenis_elaun);
//            $model->jenis_elaun_b = implode(",",$model->jenis_elaun_b);

            $model->icno = $b->icno;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//            $model->HighestEduLevelCd = $b->HighesftEduLevelCd;
            $model->bID = $id;
            $model->save(false);

//            $array=Yii::$app->request->post('b'); 
//               foreach ($array as $value) { 
//                   $mod2 = new \app\models\cbelajar\TblResearch(); 
//                   $mod2->idLKK = $model->reportID; 
//                   $mod2->researchID = $value;
//                   $mod2->save(false); 
//                  }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jenis Elaun Berjaya Ditambah!']);
            return $this->redirect(['biasiswa?id=' . $id]);
        } else {
            $model->jenis_elaun = explode(",", $model->jenis_elaun);
        }

        return $this->renderAjax('_addelaun', [
                    'model' => $model,
//            'b' => ArrayHelper::map(\app\models\cbelajar\RefTblElaunA::find()
//                                        ->where(['jenis_kadar'=>'A'])
//                                        ->all(), 'id', 'nama_elaun',
//                function($model) {
//                    $a = $model['nama_elaun'] . ' - ' . $model->perkara;
//                    return $a;
//                }, 'department.fullname'), //groupby,
//            'lapor' => $lapor,
                    'pengajian' => $pengajian,
                    'id' => $id,
                    'b' => $b,
        ]);
    }

    public function actionBElaun($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblElaun();

        $b = $this->findBiasiswa($id);
//        $lapor = $this->findLapordiri($id);
        $pengajian = $this->findPengajian2($id);
//        $icno = $lapor->icno;
//        $e=$this->findE($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->jenis_elaun = implode(",", $model->jenis_elaun);
//            $model->jenis_elaun_b = implode(",",$model->jenis_elaun_b);

            $model->icno = $b->icno;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//            $model->HighestEduLevelCd = $b->HighesftEduLevelCd;
            $model->bID = $id;
            $model->save(false);

//            $array=Yii::$app->request->post('b'); 
//               foreach ($array as $value) { 
//                   $mod2 = new \app\models\cbelajar\TblResearch(); 
//                   $mod2->idLKK = $model->reportID; 
//                   $mod2->researchID = $value;
//                   $mod2->save(false); 
//                  }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jenis Elaun Berjaya Ditambah!']);
            return $this->redirect(['biasiswa?id=' . $id]);
        } else {
            $model->jenis_elaun = explode(",", $model->jenis_elaun);
        }

        return $this->renderAjax('_elaunb', [
                    'model' => $model,
//            'b' => ArrayHelper::map(\app\models\cbelajar\RefTblElaunA::find()
//                                        ->where(['jenis_kadar'=>'A'])
//                                        ->all(), 'id', 'nama_elaun',
//                function($model) {
//                    $a = $model['nama_elaun'] . ' - ' . $model->perkara;
//                    return $a;
//                }, 'department.fullname'), //groupby,
//            'lapor' => $lapor,
                    'pengajian' => $pengajian,
                    'id' => $id,
                    'b' => $b,
        ]);
    }

    public function actionUElaun($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblElaun();

        $b = $this->findBiasiswa($id);
//        $lapor = $this->findLapordiri($id);
        $pengajian = $this->findPengajian2($id);
//        $icno = $lapor->icno;
//        $e=$this->findE($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->jenis_elaun = implode(",", $model->jenis_elaun);
//            $model->jenis_elaun_b = implode(",",$model->jenis_elaun_b);

            $model->icno = $b->icno;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//            $model->HighestEduLevelCd = $b->HighesftEduLevelCd;
            $model->bID = $id;
            $model->save(false);

//            $array=Yii::$app->request->post('b'); 
//               foreach ($array as $value) { 
//                   $mod2 = new \app\models\cbelajar\TblResearch(); 
//                   $mod2->idLKK = $model->reportID; 
//                   $mod2->researchID = $value;
//                   $mod2->save(false); 
//                  }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jenis Elaun Berjaya Ditambah!']);
            return $this->redirect(['biasiswa?id=' . $id]);
        } else {
            $model->jenis_elaun = explode(",", $model->jenis_elaun);
        }

        return $this->renderAjax('_elaunu', [
                    'model' => $model,
//            'b' => ArrayHelper::map(\app\models\cbelajar\RefTblElaunA::find()
//                                        ->where(['jenis_kadar'=>'A'])
//                                        ->all(), 'id', 'nama_elaun',
//                function($model) {
//                    $a = $model['nama_elaun'] . ' - ' . $model->perkara;
//                    return $a;
//                }, 'department.fullname'), //groupby,
//            'lapor' => $lapor,
                    'pengajian' => $pengajian,
                    'id' => $id,
                    'b' => $b,
        ]);
    }

    public function actionAddBonKhidmat($id) {
        $model = new \app\models\cbelajar\Tblbonkhidmat();
        $lapor = $this->findLapordiri($id);
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $lapor->icno;
            $model->HighestEduLevelCd = $lapor->HighestEduLevelCd;
            $model->laporID = $id;

            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tempoh Berkhidmat Berjaya Ditambah!']);
            return $this->redirect(['bon?id=' . $id]);
        }

        return $this->renderAjax('_infobon', [
                    'model' => $model,
                    'lapor' => $lapor,
        ]);
    }

    public function actionUpdateBon($id) {
        $model = \app\models\cbelajar\TblBon::find()->where(['id' => $id])->one();
        $icno = $model->icno;
        $data = $this->findCtg($icno);
        $lapor = $this->findLapordiri1($id);

//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['bon?id=' . $icno]);
        }

        return $this->renderAjax('update2', [
                    'model' => $model,
                    'data' => $data,
                    'lapor' => $lapor,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateNd($id) {
        $nd = \app\models\cbelajar\TblNd::find()->where(['id' => $id])->one();
        $icno = $nd->icno;
        $data = $this->findCtg($icno);
        $lapor = $this->findLapordiri1($id);

//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($nd->load(Yii::$app->request->post()) && $nd->save()) {
            return $this->redirect(['nominal?id=' . $nd->laporID]);
        }

        return $this->renderAjax('bon/updatend', [
                    'nd' => $nd,
                    'data' => $data,
                    'lapor' => $lapor,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateStudy($id) {
        $model = \app\models\cbelajar\TblPengajian::find()->where(['id' => $id])->one();
//        $icno = $model->icno;
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            return $this->redirect(['pengajian?id=' . $model->id]);
        }

        return $this->renderAjax('pengajian/_updates', [
                    'model' => $model,
        ]);
    }

    public function actionKemaskiniP($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblLanjutan::find()->where(['id' => $id])->one();
//        $icno = $model->icno;
        $b = $this->findPengajian2($id);
        $pengajian = $this->findPengajian($id);

        //        $p = $b->id;
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->updated_by = $i;
//              $model->pID= $pengajian->id;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['search-pengajian']);
        }

        return $this->renderAjax('biasiswa/update-p', [
                    'model' => $model,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionTajaanLanjutan($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblLanjutan::find()->where(['id' => $id])->one();
        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//        $icno = $model->icno;
        $b = $this->findPengajian2($id);
        $biasiswa = $this->findBiasiswa($id);
        $t = \app\models\cbelajar\TblElaunLulus::find()->where(['id' => $id])->one();

        //        $p = $b->id;
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->updated_by = $i;
//              $model->pID= $pengajian->id;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['search-biasiswa']);
        }

        return $this->renderAjax('biasiswa/tambah-tajaan', [
                    'model' => $model,
//            'tajaan' =>$tajaan,
                    't' => $t,
                    'biasiswa' => $biasiswa,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpLkk($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblLkk::find()->where(['reportID' => $id])->one();
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//        $icno = $model->icno;
        $b = $this->findPengajian2($id);
        $biasiswa = $this->findBiasiswa($id);

//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//              $model->pID= $pengajian->id;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['lihat-lkp', 'id' => $model->studyID]);
        }

        return $this->renderAjax('lkk/up-lkk', [
                    'model' => $model,
//            'tajaan' =>$tajaan,
//            't'=>$t,
                    'biasiswa' => $biasiswa,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateDokumen($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblLkk::find()->where(['reportID' => $id])->one();
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//        $icno = $model->icno;
        $b = $this->findPengajian2($id);
        $biasiswa = $this->findBiasiswa($id);

        $file = UploadedFile::getInstance($model, 'file');
//        $model->status_borang = "Complete";
//          $model->status_bsm = 'Admin Manually Upload';
//            $model->status = 'MANUAL UPLOAD';
        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lkk_cb');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = '';
        }


//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->dokumen_sokongan = $filepath;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//              $model->pID= $pengajian->id;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['view-lkk', 'id' => $model->icno]);
        }

        return $this->renderAjax('lkk/update-dokumen', [
                    'model' => $model,
//            'tajaan' =>$tajaan,
//            't'=>$t,
                    'biasiswa' => $biasiswa,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateTarikh($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblLain::find()->where(['id' => $id, 'idBorang' => 23])->one();
        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//        $icno = $model->icno;
        $b = $this->findPengajian2($id);
        $biasiswa = $this->findBiasiswa($id);

//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//              $model->pID= $pengajian->id;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['pengajian', 'id' => $model->idStudy]);
        }

        return $this->renderAjax('pengajian/update-tarikh', [
                    'model' => $model,
//            'tajaan' =>$tajaan,
//            't'=>$t,
                    'biasiswa' => $biasiswa,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateTangguh($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblLain::find()->where(['id' => $id, 'idBorang' => 31])->one();
        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//        $icno = $model->icno;
        $b = $this->findPengajian2($id);
        $biasiswa = $this->findBiasiswa($id);

//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//              $model->pID= $pengajian->id;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['pengajian', 'id' => $model->idStudy]);
        }

        return $this->renderAjax('pengajian/update-tangguh', [
                    'model' => $model,
//            'tajaan' =>$tajaan,
//            't'=>$t,
                    'biasiswa' => $biasiswa,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateTempat($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblLain::find()->where(['id' => $id, 'idBorang' => 24])->one();
        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//        $icno = $model->icno;
        $b = $this->findPengajian2($id);
        $biasiswa = $this->findBiasiswa($id);

//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//              $model->pID= $pengajian->id;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['pengajian', 'id' => $model->idStudy]);
        }

        return $this->renderAjax('pengajian/update-tempat', [
                    'model' => $model,
//            'tajaan' =>$tajaan,
//            't'=>$t,
                    'biasiswa' => $biasiswa,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateTempatBelajar($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblLain::find()->where(['id' => $id, 'idBorang' => 99])->one();
        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//        $icno = $model->icno;
        $b = $this->findPengajian2($id);
        $biasiswa = $this->findBiasiswa($id);

//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//              $model->pID= $pengajian->id;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['pengajian', 'id' => $model->idStudy]);
        }

        return $this->renderAjax('pengajian/update-tempat-belajar', [
                    'model' => $model,
//            'tajaan' =>$tajaan,
//            't'=>$t,
                    'biasiswa' => $biasiswa,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateBidang($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblLain::find()->where(['id' => $id, 'idBorang' => 22])->one();
        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//        $icno = $model->icno;
        $b = $this->findPengajian2($id);
        $biasiswa = $this->findBiasiswa($id);

//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
            $model->MajorCd;
            $model->MajorMinor;
//              $model->pID= $pengajian->id;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['pengajian', 'id' => $model->idStudy]);
        }

        return $this->renderAjax('pengajian/update-bidang', [
                    'model' => $model,
//            'tajaan' =>$tajaan,
//            't'=>$t,
                    'biasiswa' => $biasiswa,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

//    public function actionUpdateLkk($id)
//    {
//        $i=Yii::$app->user->getId();
//        $model = \app\models\cbelajar\TblLkk::find()->where(['reportID'=>$id])->one();
//        $icno = $model->icno;
////        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//
////        $icno = $model->icno;
//        $b = $this->findPengajian2($id);
//        $biasiswa = $this->findBiasiswa($id);
//
////        var_dump('a');die;
//        if ($model->load(Yii::$app->request->post())) {
//            Yii::$app->FileManager->DeleteFile($model);
//            $file =  UploadedFile::getInstance($model, 'file');
//            if($file){
//                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'cutibelajar/lkk');
//                $filepath = $fileapi->file_name_hashcode;   
//                if($fileapi->status == true) {
//                    $message = 'Berjaya Disimpan';
//                }
//            }
//            else{
//                $filepath = '';
//            }
//            $mo->dokumen = $filepath;
//              $model->created_dt = new \yii\db\Expression('NOW()');
//              $model->update_by = $i;
////              $model->pID= $pengajian->id;
//              $model->save(false);
//              Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);
//
//            return $this->redirect(['cbadmin/view-lkk', 'id'=>$model->icno]);
//        }
//
//        return $this->renderAjax('lkk/update-lkk', [
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
    public function actionUpdateTp($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblElaun::find()->where(['id' => $id])->one();
        $b = $this->findBiasiswa($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//              $model->bID = $model->icno;
            if ($model->jenis_elaun == "TP") {
                $model->jenis_elaun = "TP";
            } elseif ($model->jenis_elaun == "TP2") {
                $model->jenis_elaun = "TP2";
            }

            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['rekod-elaun', 'id' => $model->bID]);
        }

        return $this->renderAjax('elaun/update-tp', [
                    'model' => $model,
                    'b' => $b,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateYp($id) {
        $i = Yii::$app->user->getId();
//        $model = new \app\models\cbelajar\TblElaun();
        $model = \app\models\cbelajar\TblElaun::find()->where(['id' => $id])->one();

//        $tp = \app\models\cbelajar\ElaunKadarB::find()->where(['id'=> [ "YP"]])->all();
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
//        $icno = $model->icno;
//        $b = $this->findPengajian2($id);
//        $biasiswa = $this->findBiasiswa($id);
        $b = $this->findBiasiswa($id);

//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//              $model->icno = $mod;
//              $model->bID=$model->icno;
//              $model->jenis_elaun = "YP";
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['rekod-elaun', 'id' => $model->bID]);
        }

        return $this->renderAjax('elaun/update-yp', [
                    'model' => $model,
//            'tajaan' =>$tajaan,
//            't'=>$t,
                    'b' => $b,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateEbsr($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblElaun::find()->where(['id' => $id])->one();
        $b = $this->findBiasiswa($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//              $model->bID = $model->icno;
            if ($model->jenis_elaun == "EBSR") {
                $model->jenis_elaun = "EBSR";
            } elseif ($model->jenis_elaun == "EBSR2") {
                $model->jenis_elaun = "EBSR2";
            } elseif ($model->jenis_elaun == "EBSR3") {
                $model->jenis_elaun = "EBSR3";
            } elseif ($model->jenis_elaun == "EBSR4") {
                $model->jenis_elaun = "EBSR4";
            } elseif ($model->jenis_elaun == "EBSR5") {
                $model->jenis_elaun = "EBSR5";
            } elseif ($model->jenis_elaun == "EBSR6") {
                $model->jenis_elaun = "EBSR6";
            }
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['rekod-elaun', 'id' => $model->bID]);
        }

        return $this->renderAjax('elaun/update-ebsr', [
                    'model' => $model,
                    'b' => $b,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateEsh($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblElaun::find()->where(['id' => $id])->one();
        $b = $this->findBiasiswa($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
//              $model->bID = $model->icno;

            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['rekod-elaun', 'id' => $model->bID]);
        }

        return $this->renderAjax('elaun/update-esh', [
                    'model' => $model,
                    'b' => $b,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateEb($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblElaun();

        $b = $this->findBiasiswa($id);

//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
            $model->icno = $b->icno;
//                            $model->bID = $;

            $model->jenis_elaun = "EB";
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['rekod-elaun', 'id' => $m]);
        }

        return $this->renderAjax('elaun/update-eb', [
                    'model' => $model,
//            'tajaan' =>$tajaan,
//            't'=>$t,
                    'b' => $b,
                    'tp' => $tp,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateEaps($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblElaun();
        $tp = \app\models\cbelajar\ElaunKadarB::find()->where(['id' => [ "EAPS"]])->all();
        $b = $this->findBiasiswa($id);

//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
            $model->icno = $b->icno;
            $model->bID = $b->id;
            $model->jenis_elaun = "EAPS";
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['rekod-elaun', 'id' => $b->id]);
        }

        return $this->renderAjax('elaun/update-eaps', [
                    'model' => $model,
                    'b' => $b,
                    'tp' => $tp,
        ]);
    }

    public function actionUpdateEp($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblElaun();
        $tp = \app\models\cbelajar\ElaunKadarB::find()->where(['id' => [ "EP"]])->all();
        $b = $this->findBiasiswa($id);

//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
            $model->icno = $b->icno;
            $model->bID = $b->id;
            $model->jenis_elaun = "EP";
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['rekod-elaun', 'id' => $b->id]);
        }

        return $this->renderAjax('elaun/update-ep', [
                    'model' => $model,
                    'b' => $b,
                    'tp' => $tp,
        ]);
    }

//    public function actionUpdateEsh($id)
//    {
//        $i=Yii::$app->user->getId();
//        $model = new \app\models\cbelajar\TblElaun();
//        $tp = \app\models\cbelajar\ElaunKadarB::find()->where(['id'=> [ "ESH"]])->all();
//        $b= $this->findBiasiswa($id);
//
////        var_dump('a');die;
//        if ($model->load(Yii::$app->request->post())) {
//              $model->created_dt = new \yii\db\Expression('NOW()');
//              $model->update_by = $i;
//              $model->icno = $b->icno;
//              $model->bID=$b->id;
//              $model->jenis_elaun = "ESH";
//              $model->save(false);
//              Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);
//
//            return $this->redirect(['rekod-elaun', 'id'=>$b->id]);
//        }
//
//        return $this->renderAjax('elaun/update-esh', [
//            'model' => $model,
//            'b'=>$b,
//            'tp'=>$tp,
//        ]);
//    }
    public function actionUpdateEap($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblElaun();
        $tp = \app\models\cbelajar\ElaunKadarB::find()->where(['id' => [ "EAP"]])->all();
        $b = $this->findBiasiswa($id);

//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
            $model->icno = $b->icno;
            $model->bID = $b->id;
            $model->jenis_elaun = "EAP";
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['rekod-elaun', 'id' => $b->id]);
        }

        return $this->renderAjax('elaun/update-eap', [
                    'model' => $model,
                    'b' => $b,
                    'tp' => $tp,
        ]);
    }

    public function actionKemaskiniE($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblElaun::find()->where(['id' => $id])->one();
//        $icno = $model->icno;
        $b = $this->findBiasiswa($id);
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->updated_by = $i;
            return $this->redirect(['biasiswa?id=' . $model->bID]);
        }

        return $this->renderAjax('update-test', [
                    'model' => $model,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionProsesElaun($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblElaun::find()->where(['id' => $id])->one();
//        $icno = $model->icno;
        $b = $this->findBiasiswa($id);
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
            $model->catatan;
            $model->p_bayar;

            $model->save(false);
            return $this->redirect(['search-elaun']);
        }

        return $this->renderAjax('proses', [
                    'model' => $model,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionTest($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblLanjutan();

        $pengajian = $this->findPengajian4($id);


//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $pengajian->icno;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->updated_by = $i;
            $model->status_b = 1;
            $model->HighestEduLevelCd = $pengajian->HighestEduLevelCd;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pelanjutan Tempoh Berjaya Ditambah!']);
            return $this->redirect(['pengajian?id=' . $id]);
        }
        $pengajian2 = \app\models\cbelajar\TblLanjutan::find()->where(['by' => "BELUM LANJUT"])->all();
        foreach ($pengajian2 as $p) {
            $sem = \app\models\cbelajar\TblLkk::Semlkk($p->icno);
            $effectiveDate = $p->lanjutansdt;
            for ($i = 1; $i <= round($sem); $i++) {
//                        echo round($sem);
                $lkk = new \app\models\cbelajar\TblLkk();
                $lkk->icno = $p->icno;
                $lkk->semester = $i;
                $effectiveDate = date('Y-m-d', strtotime("+6 months", strtotime($effectiveDate)));
                $lkk->effectivedt = $effectiveDate;

                $lkk->status_form = 1;
                $p->by = "LKK LANJUT";
//                        $lkk->HighestEduLevelCd = \app\models\cbelajar\TblPengajian::find()->where(['i'=>$pengajian->icno])->one()->HighestEduLevelCd;
                $lkk->save(false);
                $p->save(false);
            }
        }

        return $this->renderAjax('_adds', [
                    'model' => $model,
                    'pengajian' => $pengajian,
                    'id' => $id,
        ]);
    }

    public function actionAddLkk($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblLkk();
        $b = $this->findStudy($id);
//        $icno = $b->icno;

        $pengajian = $this->findPengajian2($id);


//        var_dump($b);die;
        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $b->icno;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
            $model->status_form = 1;
            $model->studyID = $b->id;
            $model->agree = 2;
//            $model->HighestEduLevelCd = $pengajian->HighestEduLevelCd;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Lanjutan LKP Berjaya Ditambah!']);
            return $this->redirect(['lihat-lkp?id=' . $id]);
        }




        return $this->renderAjax('lkk/_adds', [
                    'model' => $model,
                    'pengajian' => $pengajian,
                    'id' => $id,
        ]);
    }

    public function actionAddYuran($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblElaun();
        $b = $this->findBiasiswa($id);

//        $pengajian=$this->findPengajian2($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $b->icno;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
            $model->jenis_elaun = "YP";
            $model->bID = $b->id;

            $model->bayaran = "UMS";

//            $model->status_form = 1;
//            $model->HighestEduLevelCd = $pengajian->HighestEduLevelCd;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Yuran Pengajian berjaya disimpan.']);
            return $this->redirect(['rekod-elaun?id=' . $id]);
        }




        return $this->renderAjax('elaun/_addy', [
                    'model' => $model,
//            'pengajian' => $pengajian,
                    'id' => $id,
                    'b' => $b,
        ]);
    }

    public function actionAddSewa($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblElaun();
        $b = $this->findBiasiswa($id);

//        $pengajian=$this->findPengajian2($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $b->icno;
            $model->bID = $b->id;
            $model->bayaran = "UMS";
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
            if ($model->jenis_elaun == "EBSR") {
                $model->jenis_elaun = "EBSR";
            } elseif ($model->jenis_elaun == "EBSR2") {
                $model->jenis_elaun = "EBSR2";
            } elseif ($model->jenis_elaun == "EBSR3") {
                $model->jenis_elaun = "EBSR3";
            } elseif ($model->jenis_elaun == "EBSR4") {
                $model->jenis_elaun = "EBSR4";
            } elseif ($model->jenis_elaun == "EBSR5") {
                $model->jenis_elaun = "EBSR5";
            } elseif ($model->jenis_elaun == "EBSR6") {
                $model->jenis_elaun = "EBSR6";
            }

//            $model->status_form = 1;
//            $model->HighestEduLevelCd = $pengajian->HighestEduLevelCd;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat elaun bantuan sewa rumah berjaya disimpan.']);
            return $this->redirect(['rekod-elaun?id=' . $id]);
        }




        return $this->renderAjax('elaun/_addsewa', [
                    'model' => $model,
//            'pengajian' => $pengajian,
                    'id' => $id,
                    'b' => $b,
        ]);
    }

    public function actionAddSara($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblElaun();
        $b = $this->findBiasiswa($id);

//        $pengajian=$this->findPengajian2($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $b->icno;
            $model->bID = $b->id;
            $model->bayaran = "UMS";
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
            $model->jenis_elaun = "ESH";

            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat elaun sara hidup berjaya disimpan.']);
            return $this->redirect(['rekod-elaun?id=' . $id]);
        }




        return $this->renderAjax('elaun/_addsara', [
                    'model' => $model,
//            'pengajian' => $pengajian,
                    'id' => $id,
                    'b' => $b,
        ]);
    }

    public function actionAddTiket($id) {
        $i = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblElaun();
        $b = $this->findBiasiswa($id);

//        $pengajian=$this->findPengajian2($id);
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $b->icno;
            $model->bID = $b->id;
            $model->bayaran = "UMS";
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->update_by = $i;
            if ($model->jenis_elaun == "TIKET") {
                $model->jenis_elaun = "TIKET";
            } elseif ($model->jenis_elaun == "TIKET2") {
                $model->jenis_elaun = "TIKET2";
            }


//            $model->status_form = 1;
//            $model->HighestEduLevelCd = $pengajian->HighestEduLevelCd;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat tuntutan tiket penerbangan berjaya disimpan.']);
            return $this->redirect(['rekod-elaun?id=' . $id]);
        }




        return $this->renderAjax('elaun/_addtiket', [
                    'model' => $model,
//            'pengajian' => $pengajian,
                    'id' => $id,
                    'b' => $b,
        ]);
    }

    public function actionTukar($id) {
        $model = \app\models\cbelajar\TblPengajian::find()->where(['id' => $id])->one();
        $mod = new \app\models\cbelajar\TblLain();

//        $icno = $model->icno;
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($mod->load(Yii::$app->request->post())) {
            $mod->idStudy = $id;
            $mod->catatan;
            $mod->icno = $model->icno;
            $mod->eduCd = $model->HighestEduLevelCd;
            $mod->idBorang;
            $mod->save(false);
            return $this->redirect(['pengajian?id=' . $model->id]);
        }

        return $this->renderAjax('pengajian/_updatess', [
                    'model' => $model,
                    'mod' => $mod,
        ]);
    }

    public function actionTambahTempat($id) {
        $model = \app\models\cbelajar\TblPengajian::find()->where(['id' => $id])->one();
        $mod = new \app\models\cbelajar\TblLain();

//        $icno = $model->icno;
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($mod->load(Yii::$app->request->post())) {
            $mod->idStudy = $id;
            $mod->catatan;
            $mod->icno = $model->icno;
            $mod->eduCd = $model->HighestEduLevelCd;
            $mod->idBorang = 99;
            $mod->save(false);
            return $this->redirect(['pengajian?id=' . $model->id]);
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'added/ditambah.']);

        return $this->renderAjax('pengajian/_tambahs', [
                    'model' => $model,
                    'mod' => $mod,
        ]);
    }

    public function actionUpdateBonKhidmat($id) {
//        $model = \app\models\cbelajar\Tblbonkhidmat::find()->where(['id'=>$id])->one();
        $model = \app\models\cbelajar\Tblbonkhidmat::find()->where(['icno' => $id])->one();
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['bon?id=' . $model->laporID]);
        }

        return $this->renderAjax('bon/update-bon', [
                    'model' => $model,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateElaun($id) {
        $b = $this->findBiasiswa($id);
//                             $i = $b->id;
//        $model = \app\models\cbelajar\Tblbonkhidmat::find()->where(['id'=>$id])->one();
        $model = \app\models\cbelajar\TblElaunLulus::find()->where(['bID' => $id])->one();
        $c = \app\models\cbelajar\TblBiasiswa::find()->where(['id' => $id])->one();

//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post()) && $c->load(Yii::$app->request->post())) {

            $model->lokasi;
            $c->nama_tajaan;
            $c->c_tajaan;
            $model->save(false);
            $c->save(false);
            return $this->redirect(['biasiswa?id=' . $b->id]);
        }

        return $this->renderAjax('biasiswa/update-elaun', [
                    'model' => $model,
                    'b' => $b,
                    'c' => $c
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateE($id) {
        $b = $this->findBiasiswa($id);
//                             $i = $b->id;
//        $model = \app\models\cbelajar\Tblbonkhidmat::find()->where(['id'=>$id])->one();
        $model = \app\models\cbelajar\TblElaunLulus::find()->where(['bID' => $id])->one();
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {


            $model->save(false);
            return $this->redirect(['biasiswa?id=' . $b->id]);
        }

        return $this->renderAjax('update-e', [
                    'model' => $model,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateETest($id) {
        $b = $this->findBiasiswa($id);
//                             $i = $b->id;
//        $model = \app\models\cbelajar\Tblbonkhidmat::find()->where(['id'=>$id])->one();
        $model = \app\models\cbelajar\TblElaunLulus::find()->where(['bID' => $id])->one();
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {


            $model->save(false);
            return $this->redirect(['biasiswa?id=' . $b->id]);
        }

        return $this->renderAjax('kemaskini-elaun', [
                    'model' => $model,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateTuntut($id) {
//        $model = \app\models\cbelajar\Tblbonkhidmat::find()->where(['id'=>$id])->one();
        $model = \app\models\cbelajar\TblTuntutan::find()->where(['id' => $id])->one();
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['bon?id=' . $model->laporID]);
        }

        return $this->renderAjax('bon/update-tuntut', [
                    'model' => $model,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionUpdateLedger($id) {
//        $model = \app\models\cbelajar\Tblbonkhidmat::find()->where(['id'=>$id])->one();
        $model = \app\models\cbelajar\TblElaunLulus::find()->where(['icno' => $id])->one();
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-ledger-tajaan?id=' . $model->icno]);
        }

        return $this->renderAjax('update-ledger', [
                    'model' => $model,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionAddTuntutanGantirugi($id) {
        $model = new \app\models\cbelajar\TblTuntutan();
//        $lapor = $this->findLapordiri($id);
        $pengajian = $this->findPengajian1($id);

//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $id;
            $model->HighestEduLevelCd = $pengajian->HighestEduLevelCd;
//            $model->laporID=$id;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tuntutan Gantirugi berjaya ditambah']);
            return $this->redirect(['bon?id=' . $id]);
        }

        return $this->renderAjax('bon/_tuntutrugi', [
                    'model' => $model,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionDelete($id) {

        $mj = \app\models\cbelajar\TblBon::findOne($id);
        $icno = $mj->id;
        $mj->delete();
        return $this->redirect(['bon', 'id' => $icno]);
    }

    public function actionDeleteTuntut($id) {

        $mj = \app\models\cbelajar\TblTuntutan::findOne($id);
        $icno = $mj->id;
        $mj->delete();
        return $this->redirect(['bon', 'id' => $icno]);
    }

    public function actionDeletend($id) {

        $mj = \app\models\cbelajar\TblNd::findOne($id);
        $icno = $mj->laporID;
        $mj->delete();
        return $this->redirect(['nominal', 'id' => $icno]);
    }

    public function actionDeleteP($id) {

        $mj = \app\models\cbelajar\TblLanjutan::findOne($id);
//        $icno = $mj->id;
        $mj->delete();
        return $this->redirect(['search-pengajian']);
    }

    public function actionDeleteTajaan($id) {

        $mj = \app\models\cbelajar\TblLanjutan::findOne($id);

//        $icno = $mj->id;
        $mj->delete();
        return $this->redirect(['search-pengajian']);
    }

    public function actionDeleteT($id) {

        $mj = \app\models\cbelajar\TblLain::findOne($id);
//        $icno = $mj->id;
        $mj->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'deleted/dipadam.']);

        return $this->redirect(['pengajian', 'id' => $mj->idStudy]);
    }

    public function actionDeleteLkk($id) {

        $mj = \app\models\cbelajar\TblLkk::findOne($id);
//        $icno = $mj->id;
        $mj->delete();
        return $this->redirect(['lihat-lkp', 'id' => $mj->studyID]);
    }

    public function actionDeleteTiket($id) {

        $mj = \app\models\cbelajar\TblElaun::findOne($id);
//        $icno = $mj->id;
        $mj->delete();
        return $this->redirect(['rekod-elaun', 'id' => $mj->bID]);
    }

    public function actionDeleteSewa($id) {

        $mj = \app\models\cbelajar\TblElaun::findOne($id);
//        $icno = $mj->id;
        $mj->delete();
        return $this->redirect(['rekod-elaun', 'id' => $mj->bID]);
    }

    public function actionDeleteSara($id) {

        $mj = \app\models\cbelajar\TblElaun::findOne($id);
//        $icno = $mj->id;
        $mj->delete();
        return $this->redirect(['rekod-elaun', 'id' => $mj->bID]);
    }

    public function actionDeleteYuran($id) {

        $mj = \app\models\cbelajar\TblElaun::findOne($id);
//        $icno = $mj->id;
        $mj->delete();
        return $this->redirect(['rekod-elaun', 'id' => $mj->bID]);
    }

    public function actionDeleteElaun($id) {

        $mj = \app\models\cbelajar\TblElaunLulus::findOne($id);
        $icno = $mj->bID;
        $mj->delete();
        return $this->redirect(['biasiswa', 'id' => $icno]);
    }

    public function actionLaporan($tahun = null, $bulan = null) {

        $year = date('Y');
        $month = date('m');

        $jumlah_permohonan_pentadbiran = $this->findJumlahPermohonanPentadbiranSemasa();
        $jumlah_permohonan_akademik = $this->findJumlahPermohonanAkademikSemasa();
        $jumlah_permohonan_pentadbiran_berjaya = $this->findJumlahPermohonanPentadbiranBerjaya();
        $jumlah_permohonan_pentadbiran_gagal = $this->findJumlahPermohonanPentadbiranDitolak();
        $jumlah_permohonan_akademik_berjaya = $this->findJumlahPermohonanAkademikBerjaya();
        $jumlah_permohonan_akademik_gagal = $this->findJumlahPermohonanAkademikDitolak();

        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $month = $bulan;
        }

        $model = new TblPermohonan();

        $query = TblPermohonan::find()->where(['MONTH(tarikh_m)' => $month, 'status_proses' => "Selesai Permohonan"])->andWhere(['YEAR(tarikh_m)' => $year])->orderBy(['tarikh_m' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if (TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('laporan', [

                        'tahun' => $year, 'bulan' => $month, 'dataProvider' => $dataProvider, 'model' => $model,
                        'jumlah_permohonan_pentadbiran' => $jumlah_permohonan_pentadbiran,
                        'jumlah_permohonan_akademik' => $jumlah_permohonan_akademik,
                        'jumlah_permohonan_pentadbiran_berjaya' => $jumlah_permohonan_pentadbiran_berjaya,
                        'jumlah_permohonan_pentadbiran_gagal' => $jumlah_permohonan_pentadbiran_gagal,
                        'jumlah_permohonan_akademik_berjaya' => $jumlah_permohonan_akademik_berjaya,
                        'jumlah_permohonan_akademik_gagal' => $jumlah_permohonan_akademik_gagal,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionLaporanPengajianSemasa($tahun = null, $bulan = null) {

        $year = date('Y');
        $month = date('m');

        $jumlah_permohonan_akademik = $this->findJumlahAkademikSemasa();

        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $month = $bulan;
        }

        $model = new TblPermohonan();

        $query = TblPengajian::find()->where(['MONTH(tarikh_mula)' => $month, 'status' => 1, 'userID' => 1])->andWhere(['YEAR(tarikh_mula)' => $year])->orderBy(['tarikh_mula' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if (TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('laporan-semasa', [

                        'tahun' => $year, 'bulan' => $month, 'dataProvider' => $dataProvider, 'model' => $model,
                        'jumlah_permohonan_akademik' => $jumlah_permohonan_akademik,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionLaporanLaporDiri($tahun = null, $bulan = null) {

        $year = date('Y');
        $month = date('m');



        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $month = $bulan;
        }

        $model = new \app\models\cbelajar\TblLapordiri();

        $query = \app\models\cbelajar\TblLapordiri::find()->where(['MONTH(dt_lapordiri)' => $month])->andWhere(['YEAR(dt_lapordiri)' => $year])->orderBy(['dt_lapordiri' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if (TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('laporan-lapordiri', [

                        'tahun' => $year, 'bulan' => $month, 'dataProvider' => $dataProvider, 'model' => $model, 'query' => $query
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionLaporanLanjutan($tahun = null, $bulan = null) {

        $year = date('Y');
        $month = date('m');



        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $month = $bulan;
        }

        $model = new \app\models\cbelajar\TblLanjutan();

        $query = \app\models\cbelajar\TblLanjutan::find()->where(['MONTH(tarikh_mohon)' => $month])->andWhere(['YEAR(tarikh_mohon)' => $year])->orderBy(['tarikh_mohon' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if (TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('laporan-lanjutan', [

                        'tahun' => $year, 'bulan' => $month, 'dataProvider' => $dataProvider, 'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    protected function findJumlahPermohonanAkademikSemasa() {
        return TblPermohonan::find()->where(['job_category' => '1'])->count();
    }

    protected function findJumlahAkademikSemasa() {
        return TblPengajian::find()->where(['status' => '1'])->count();
    }

    protected function findJumlahPermohonanAkademikBerjaya() {

        return TblPermohonan::find()->where(['job_category' => '1', 'status' => 'LULUS'])->count();
    }

    protected function findJumlahPermohonanAkademikDitolak() {

        return TblPermohonan::find()->where(['job_category' => '1', 'status' => 'TIDAK LULUS'])->count();
    }

    protected function findJumlahPermohonanPentadbiranSemasa() {
        return TblPermohonan::find()->where(['job_category' => '2'])->count();
    }

    protected function findJumlahPermohonanPentadbiranBerjaya() {

        return TblPermohonan::find()->where(['job_category' => '2', 'status' => 'LULUS'])->count();
    }

    protected function findJumlahPermohonanPentadbiranDitolak() {

        return TblPermohonan::find()->where(['job_category' => '2', 'status' => 'TIDAK LULUS'])->count();
    }

    public function actionDeleteBon($id) {

        $mj = \app\models\cbelajar\Tblbonkhidmat::findOne($id);
        $icno = $mj->laporID;
        $mj->delete();
        return $this->redirect(['bon', 'id' => $icno]);
    }

//     protected function findRekod($ICNO) {
//         $encryptID = 'SELECT * FROM cbelajar.rekod_cb WHERE SHA1(icno) =:icno';
//        return \app\models\cbelajar\RekodCb::findBySql($encryptID, [':icno' => $ICNO])->one();
////        return \app\models\cbelajar\RekodCb::find()->where([SHA1('icno') =>$id])->one();
//    }
//    protected function findPengajian($id) {
//        return \app\models\cbelajar\TblPengajian::findAll(['icno' => $id]);
//    }
    protected function findPengajian($id) {
        return \app\models\cbelajar\TblPengajian::find()->where(['icno' => $id])->andWhere(['<>', 'status', 8])->all();
    }

    protected function findCtg($id) {
        return \app\models\cuti\TblRecords::findAll(['icno' => $id, 'jenis_cuti_id' => 38]);
    }

    protected function findPengajian1($id) {
        return \app\models\cbelajar\TblPengajian::findOne(['icno' => $id]);
    }

    protected function findPengajian2($id) {
        return \app\models\cbelajar\TblPengajian::findOne(['icno' => $id]);
    }

    protected function findPengajian4($id) {
        return \app\models\cbelajar\TblPengajian::findOne(['id' => $id]);
    }

//    public function findStud($status) 
//    {
//        $senarai_dokumen = new ActiveDataProvider([
//            'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => $status]),
//
//            'pagination' => [
//                'pageSize' => false,
//            ],
//        ]);
//        return $senarai_dokumen;
//    }


    protected function findStatus($id) {
        return Tblprcobiodata::findOne(['ICNO' => $id]);
    }

    protected function findLanjutan($id) {
        return \app\models\cbelajar\TblLanjutan::findOne(['icno' => $id]);
    }

    protected function findBiasiswa($id) {
        return \app\models\cbelajar\TblBiasiswa::findOne(['id' => $id]);
    }

    protected function findBiasiswa1($id, $edu) {
        return \app\models\cbelajar\TblBiasiswa::findOne(['id' => $id, 'HighestEduLevelCd' => $edu]);
    }

    protected function findLain($id) {
        return \app\models\cbelajar\TblLain::findOne(['id' => $id]);
    }

    protected function findS($id) {
        return \app\models\cbelajar\TblBiasiswa::findOne(['icno' => $id]);
    }

    protected function findBias($id) {
        return \app\models\cbelajar\TblBiasiswa::findOne(['icno' => $id]);
    }

    protected function findSs($icno, $id) {
        return \app\models\cbelajar\TblBiasiswa::findOne(['icno' => $icno, 'HighestEduLevelCd' => $id]);
    }

    protected function findLapordiri($id) {
        return \app\models\cbelajar\TblLapordiri::findOne(['laporID' => $id]);
    }

    protected function findLapordiri1($id) {
        return \app\models\cbelajar\TblLapordiri::findOne(['icno' => $id]);
    }

    protected function findL($id) {
        return \app\models\cbelajar\TblLapordiri::findOne(['HighestEduLevelCd' => $id]);
    }

    public function actionDaftarPengajianLanjutan() {
//        $admin = \app\models\hronline\Tblprcobiodata::find()->All();
//        $permohonan = new TblPermohonan();
        $pengajian = new TblPengajian();
        $biasiswa = new TblBiasiswa();
//        $model = Tblprcobiodata::findOne(['ICNO'=>$icno]);
//        $lkk = new \app\models\cbelajar\TblLkk();



        if ($pengajian->load(Yii::$app->request->post()) && $biasiswa->load(Yii::$app->request->post())) {

//            $permohonan->icno;
//            $permohonan->iklan_id;
//            $pengajian->iklan_id = $permohonan->iklan_id; 
            $pengajian->icno;
            $pengajian->InstNm;
            $pengajian->Country;
            $pengajian->HighestEduLevelCd;
            $pengajian->MajorCd;
            $pengajian->status = 1;
            $pengajian->by = "MANUAL";
            $pengajian->tarikh_mula;
            $pengajian->tarikh_tamat;
            $pengajian->nama_penyelia;
            $pengajian->tajuk_tesis;
//            $pengajian->idBorang = 1;
            $pengajian->tahun = date("Y");
            $pengajian->userID = $pengajian->kakitangan->jawatan->job_category;
            $biasiswa->icno = $pengajian->icno;
            $biasiswa->iklan_id = $pengajian->iklan_id;
            $biasiswa->nama_tajaan;
            $biasiswa->jenisCd;
            $biasiswa->bentukBantuan;
            $biasiswa->amaunBantuan;
            $biasiswa->tahun = date("Y");
            $biasiswa->HighestEduLevelCd = $pengajian->HighestEduLevelCd;
            $biasiswa->status_form = 1;
//            $lkk->icno = $pengajian->icno;
            $pengajian->save(false);
            $biasiswa->save(false);


            $pengajian2 = \app\models\cbelajar\TblPengajian::find()->where(['by' => "MANUAL"])->all();

            foreach ($pengajian2 as $p) {
                $sem = \app\models\cbelajar\TblLkk::Semlkk($p->icno);
                $effectiveDate = $p->tarikh_mula;
                for ($i = 1; $i <= round($sem); $i++) {
//                        echo round($sem);
                    $lkk = new \app\models\cbelajar\TblLkk();
                    $lkk->icno = $p->icno;
                    $lkk->semester = $i;
                    $effectiveDate = date('Y-m-d', strtotime("+6 months", strtotime($effectiveDate)));
                    $lkk->effectivedt = $effectiveDate;
                    $lkk->status_form = 1;
                    $p->by = "LKK UPDATE";
//                        $lkk->HighestEduLevelCd = \app\models\cbelajar\TblPengajian::find()->where(['i'=>$pengajian->icno])->one()->HighestEduLevelCd;
                    $lkk->save(false);
                    $p->save(false);
                }
            }


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['cbadmin/senarai-tambah-manual']);
        }


        return $this->render('pengajian/daftar_cutibelajar', [

                    'pengajian' => $pengajian,
                    'biasiswa' => $biasiswa,
                    'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
        ]);
    }

    protected function findStudy($id) {
        return \app\models\cbelajar\TblPengajian::findOne(['id' => $id]);
    }

    protected function findElaun($id) {
        return \app\models\cbelajar\TblElaunLulus::findOne(['icno' => $id]);
    }

    protected function findA($id) {
        return \app\models\cbelajar\TblElaun::findAll(['bID' => $id]);
    }

    public function actionViewLkk($my = NULL, $id) {
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno' => $id, 'status' => [1, 2, 4]])->orderBy(['tarikh_mula' => SORT_DESC])->one();

//        $biodata = $this->findMaklumat1($id);
        $biodata = $this->findBiodata($id);
        $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => $id, 'status_form' => 1])->all();
        $lkk2 = \app\models\cbelajar\TblLkk::find()->where(['icno' => $id, 'semester' => [1, 2], 'status_form' => 1])->all();

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
        if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('lkk/viewlkk', [
//             'model' => $model,
                        'lkk' => $lkk,
                        'pengajian' => $pengajian,
                        'id' => $id,
                        'biodata' => $biodata,
                        'lkk2' => $lkk2,
//                    'model2' => $model2,
            ]);
        }
    }

    public function actionMainLkp($my = NULL, $id) {
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno' => $id, 'status' => [1, 2, 4]])->orderBy(['tarikh_mula' => SORT_DESC])->all();

//        $biodata = $this->findMaklumat1($id);
        $biodata = $this->findBiodata($id);
        $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => $id, 'status_form' => 1])->all();
        $lkk2 = \app\models\cbelajar\TblLkk::find()->where(['icno' => $id, 'semester' => [1, 2], 'status_form' => 1])->all();

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
        if (\app\models\cbelajar\TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('lkk/main', [
//             'model' => $model,
                        'lkk' => $lkk,
                        'pengajian' => $pengajian,
                        'id' => $id,
                        'biodata' => $biodata,
                        'lkk2' => $lkk2,
//                    'model2' => $model2,
            ]);
        }
    }

    protected function findLkk1($id) {
        return \app\models\cbelajar\TblLkk::findOne(['icno' => $id]);
    }

    protected function notifipemohon() {
        $current_date = date('Y-m-d');
        $layak = \app\models\cbelajar\TblBukapermohonan::find()->where(['and', "start_bolehmohon<='$current_date'", "end_bolehmohon>='$current_date'"]);
//        $biodata = Tblprcobiodata::find()->where(['!=','statLantikan','1'])->all();
        $biodata = Tblprcobiodata::find()->where(['statLantikan' => 1])->all();
        $end = $layak->max('end_bolehmohon');
        $start = $layak->min('start_bolehmohon');
        if ($layak) {
            foreach ($biodata as $biodatas) {
                $tarikhtamat = date_format(date_create($biodatas->endDateLantik), 'Y-m-d');
                if ($biodatas->jawatan->job_category == "1" && $tarikhtamat >= $layak->min('start_tamatkontrak') && $tarikhtamat <= $layak->max('end_tamatkontrak')) {
                    $model = Kontrak::find()->where(['and', "tarikh_m<='$end'", "tarikh_m>='$start'"])->andWhere(['icno' => $biodatas->ICNO])->one();
                    if (!$model) {
                        $this->notifikasi($biodatas->ICNO, "Adalah Dimaklumkan bahawa pengajian lanjutan tuan/puan akan tamat pada $pengajian->tarikh_tamat; Tuan/puan adalah dipelawa untuk mengemukakan permohonan pelantikan semula kontrak <b>DALAM KADAR SEGERA</b>; "
                                . "Kegagalan tuan/puan berbuat demikian akan dianggap tidak berminat untuk melanjutkan perkhidmatan di UMS.", ['kontrak/mohonlanjut'], ['class' => 'btn btn-primary btn-sm']);
                    }
                }
            }
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar']);
    }

    public function actionNotifistaf($id, $n_date) {


        $this->notifikasi($id, "Adalah Dimaklumkan bahawa TARIKH AKHIR PENGHANTARAN LAPORAN KEMAJUAN KURSUS (LKK) tuan/puan adalah pada $n_date; Tuan/puan adalah dipelawa mengemukakan LKK  <b>DALAM KADAR SEGERA</b>; "
                , ['lkk/senarailkk'], ['class' => 'btn btn-primary btn-sm']);

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Peringatan Penghantaran LKK Berjaya Dihantar']);
        return $this->redirect('view-lkk?id=' . $id);
    }

    //pentadbir sistem
    public function actionSearch($status = null, $jfpiu = null, $jawatan = null, $category = null, $khidmat = null) {

        $searchModel = new \app\models\cbelajar\TblPengajianSearch();
//        $status = new \app\models\hronline\TblprcobiodataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $status = new Tblprcobiodata();
//         $listicno = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['Status'=>[1,2,6]]): Tblprcobiodata::find()->where(['Status'=>[1,2,6]]);
//        $listicno = $aktif? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $aktif]): $listicno;
//        $dataProvider = $status->search(Yii::$app->request->queryParams);  
//        $dataProvider = $status->search(Yii::$app->request->queryParams);  
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//                 $listicno = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['Status'=>[1,2,6]]): Tblprcobiodata::find()->where(['Status'=>[1,2,6]]);
        $listicno = $jawatan ? Tblprcobiodata::find()->where(['gredJawatan' => $jawatan]) : Tblprcobiodata::find()->where(['Status' => [1, 2, 6]]);
//       $listicno = $khidmat? Tblprcobiodata::find()->where(['Status' => [1,2,6]]): Tblprcobiodata::find()->where(['Status'=>[1,2,6]]);
        $list = $category ? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]) : $listicno;
        $jfpiu ? $listicno->where(['DeptId' => $jfpiu]) : $listicno;
        $khidmat ? $listicno->where(['Status' => $khidmat]) : $listicno;


//        $lists = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=','Status', '6']): Tblprcobiodata::find()->where(['!=','Status', '6']);
//        $listicno = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=','Status', '6']): Tblprcobiodata::find()->where(['!=','Status', '6']);
//        $listicno = $status? $listicno->joinWith('serviceStatus')->where(['serviceStatus.ServStatusNm' => $status]): $listicno;
//
//
        $query = TblPengajian::find()->where(['icno' => $listicno->select(['ICNO']), 'status' => [1, 2, NULL, 4, 11]])->groupBy('icno');
        $dataProvider = new ActiveDataProvider([

            'query' => $query,
            'pagination' => [

                'pageSize' => 30,
            ],
        ]);
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere
                                (['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';

        isset(Yii::$app->request->queryParams['HighestEduLevelCd']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'HighestEduLevelCd', Yii::$app->request->queryParams['HighestEduLevelCd']]) : '';
//        $search = new \app\models\hronline\TblprcobiodataSearch();

        return $this->render('a_search', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'status' => $status,
                    'jfpiu' => $jfpiu,
                    'jawatan' => $jawatan,
//            'khidmat'=>$khidmat,
                    'category' => $category,
                    'listicno' => $listicno,
                    'list' => $list,
//            'lists'=>$lists,
        ]);
    }

    public function actionSearchCb($my = null, $jfpiu = null, $category = null) {
        $searchModel = new \app\models\cbelajar\TblPengajianSearch();
        $current = TblPengajian::find()->where(['>=', 'tarikh_tamat', date('Y-m-d')])->one();

        $my? : $my = date('Y-m');
        $pd = TblLanjutan::find()->select('icno')->distinct('icno')->asArray()->all();
        $icno_array = [];
        foreach ($pd as $pd) {
            array_push($icno_array, $pd['icno']);
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $listicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['Status' => [1, 2, 6]]) : Tblprcobiodata::find()->where(['Status' => [1, 2, 6]]);
        $listicno = $category ? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]) : $listicno;
        $lanjut = TblLanjutan::findAll(['icno' => $listicno->select(['ICNO'])]);


        $query = TblPengajian::find()->joinWith('lanjutan')
                ->where(['NOT IN', '`cb_tbl_lanjutan`.`icno`', $icno_array]);

        $dataProvider = new ActiveDataProvider([

            'query' => $query,
            'pagination' => [

                'pageSize' => 5,
            ],
        ]);

        $dataProvider->query->andFilterWhere(['cb_tbl_pengajian.status' => 1])->orderBy(['tarikh_mula' => SORT_ASC]);

        $my ? $dataProvider->query->andFilterWhere(['like', 'cb_tbl_pengajian.tarikh_tamat', date_format(date_create($my), 'Y-m')])
                                ->orFilterWhere(['like', 'cb_tbl_lanjutan.lanjutanedt', date_format(date_create($my), 'Y-m')])
                                ->orderBy(['cb_tbl_pengajian.tarikh_tamat' => SORT_ASC]) : ' ';
//                       $my? $dataProvider->query->andFilterWhere(['like', 'tarikh_tamat', date_format(date_create($my), 'Y-m')]):' ';

        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere
                                (['like', 'cb_tbl_pengajian.icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['cb_tbl_pengajian.HighestEduLevelCd']) ? $dataProvider->query->andFilterWhere(
                                ['=', 'cb_tbl_pengajian.HighestEduLevelCd', Yii::$app->request->queryParams['cb_tbl_pengajian.HighestEduLevelCd']]) : '';
//        isset(Yii::$app->request->queryParams['cb_tbl_pengajian.HighestEduLevelCd']) ? $dataProvider->query->andFilterWhere(
//                                ['like', 'cb_tbl_pengajian.HighestEduLevelCd', Yii::$app->request->queryParams['cb_tbl_pengajian.HighestEduLevelCd']]) : '';
        $dataProvider->query->andFilterWhere(['cb_tbl_pengajian.status' => 1]);

//        $search = new \app\models\hronline\TblprcobiodataSearch();

        return $this->render('lapordiri/a_cutibelajar', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'category' => $category,
                    'query' => $query,
                    'jfpiu' => $jfpiu,
                    'my' => $my,
                    'lanjut' => $lanjut,
        ]);
    }

    public function actionBelumAdaPelanjutan($my = null, $jfpiu = null, $category = null) {
        $searchModel = new \app\models\cbelajar\TblPengajianSearch();
        $current = TblPengajian::find()->where(['>=', 'tarikh_tamat', date('Y-m-d')])->one();

        $my? : $my = date('Y-m');
        $pd = TblLanjutan::find()->select('icno')->distinct('icno')->asArray()->andWhere(['cb_tbl_lanjutan.status' => "LULUS"])->all();
        $icno_array = [];
        foreach ($pd as $pd) {
            array_push($icno_array, $pd['icno']);
        }

//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $listicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['Status' => [1, 2, 6]]) : Tblprcobiodata::find()->where(['Status' => [1, 2, 6]]);
        $listicno = $category ? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]) : $listicno;
        $lanjut = TblLanjutan::findAll(['icno' => $listicno->select(['ICNO'])]);

        $xlanjutan = TblPengajian::find()
                        ->where(['NOT IN', 'cb_tbl_pengajian.icno', $icno_array])->all();
        $icno_array = [];
        foreach ($xlanjutan as $xlanjutan) {
            array_push($icno_array, $xlanjutan['icno']);
        }
//        var_dump($icno_array);die;

        $query = TblPengajian::find()
                ->joinWith('lanjutan')
//                ->where(['hrd.cb_tbl_pengajian.icno' => $listicno->select(['ICNO'])])
                ->where(['in', '`cb_tbl_pengajian`.`icno`', $icno_array]);



        $dataProvider = new ActiveDataProvider([

            'query' => $query,
            'pagination' => [

                'pageSize' => 5,
            ],
        ]);

        $dataProvider->query->andFilterWhere(['cb_tbl_pengajian.status' => 1])->orderBy(['tarikh_mula' => SORT_ASC]);

        $my ? $dataProvider->query->andFilterWhere(['like', 'cb_tbl_pengajian.tarikh_tamat', date_format(date_create($my), 'Y-m')])
                                ->orderBy(['cb_tbl_pengajian.tarikh_tamat' => SORT_ASC]) : ' ';
//                       $my? $dataProvider->query->andFilterWhere(['like', 'tarikh_tamat', date_format(date_create($my), 'Y-m')]):' ';

        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere
                                (['like', 'cb_tbl_pengajian.icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['cb_tbl_pengajian.HighestEduLevelCd']) ? $dataProvider->query->andFilterWhere(
                                ['=', 'cb_tbl_pengajian.HighestEduLevelCd', Yii::$app->request->queryParams['cb_tbl_pengajian.HighestEduLevelCd']]) : '';
//        isset(Yii::$app->request->queryParams['cb_tbl_pengajian.HighestEduLevelCd']) ? $dataProvider->query->andFilterWhere(
//                                ['like', 'cb_tbl_pengajian.HighestEduLevelCd', Yii::$app->request->queryParams['cb_tbl_pengajian.HighestEduLevelCd']]) : '';
        $dataProvider->query->andFilterWhere(['cb_tbl_pengajian.status' => 1]);

//        $search = new \app\models\hronline\TblprcobiodataSearch();

        return $this->render('lapordiri/b_cutibelajar', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'category' => $category,
                    'query' => $query,
                    'jfpiu' => $jfpiu,
                    'my' => $my,
                    'lanjut' => $lanjut,
        ]);
    }

    public function actionSearchLapor($my = NULL, $jfpiu = NULL) {

        $arrayicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=', 'Status', '6']) : '';
//$pengajian = $this->findPengajian($id);
        $searchModel = new \app\models\cbelajar\TblLaporDiriSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//         $dataProvider->query->->orderBy(['tahun' => SORT_DESC]);
//        $search = new \app\models\hronline\TblprcobiodataSearch();
        $my ? $dataProvider->query->andFilterWhere(['like', 'dt_lapordiri', date_format(date_create($my), 'Y-m')]) : ' ';


        $query = empty($arrayicno) ? \app\models\cbelajar\TblLapordiri::find() :
                \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $arrayicno->select(['ICNO'])]);

        return $this->render('/lapordiri/a_search', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'jfpiu' => $jfpiu,
                    'my' => $my,
        ]);
    }

    public function actionSenaraiBon($status = null, $jfpiu = null, $jawatan = null, $category = null, $khidmat = null) {

        $searchModel = new \app\models\cbelajar\TblLaporDiriSearch();
//        $status = new \app\models\hronline\TblprcobiodataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $status = new Tblprcobiodata();
//         $listicno = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['Status'=>[1,2,6]]): Tblprcobiodata::find()->where(['Status'=>[1,2,6]]);
//        $listicno = $aktif? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $aktif]): $listicno;
//        $dataProvider = $status->search(Yii::$app->request->queryParams);  
//        $dataProvider = $status->search(Yii::$app->request->queryParams);  
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//                 $listicno = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['Status'=>[1,2,6]]): Tblprcobiodata::find()->where(['Status'=>[1,2,6]]);
        $listicno = $jawatan ? Tblprcobiodata::find()->where(['gredJawatan' => $jawatan]) : Tblprcobiodata::find()->where(['Status' => [1, 2, 6]]);
//       $listicno = $khidmat? Tblprcobiodata::find()->where(['Status' => [1,2,6]]): Tblprcobiodata::find()->where(['Status'=>[1,2,6]]);
        $list = $category ? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]) : $listicno;
        $jfpiu ? $listicno->where(['DeptId' => $jfpiu]) : $listicno;
        $khidmat ? $listicno->where(['Status' => $khidmat]) : $listicno;


//        $lists = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=','Status', '6']): Tblprcobiodata::find()->where(['!=','Status', '6']);
//        $listicno = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=','Status', '6']): Tblprcobiodata::find()->where(['!=','Status', '6']);
//        $listicno = $status? $listicno->joinWith('serviceStatus')->where(['serviceStatus.ServStatusNm' => $status]): $listicno;
//
//
        $query = \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $listicno->select(['ICNO'])])->groupBy('icno');
        $dataProvider = new ActiveDataProvider([

            'query' => $query,
            'pagination' => [

                'pageSize' => 30,
            ],
        ]);
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere
                                (['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';

        isset(Yii::$app->request->queryParams['HighestEduLevelCd']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'HighestEduLevelCd', Yii::$app->request->queryParams['HighestEduLevelCd']]) : '';
//        $search = new \app\models\hronline\TblprcobiodataSearch();

        return $this->render('/lapordiri/a_searchbon', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'status' => $status,
                    'jfpiu' => $jfpiu,
                    'jawatan' => $jawatan,
                    'khidmat' => $khidmat,
                    'category' => $category,
                    'listicno' => $listicno,
                    'list' => $list,
//            'lists'=>$lists,
        ]);
    }

//     public function actionSenaraiBon($status= null, $jfpiu = null,$jawatan=null, $category= null, $khidmat= null) {
//
//        $searchModel = new \app\models\cbelajar\TblLaporDiriSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $id = $searchModel->icno;
//                    $bon = $this->findBon($id);
//
////         $dataProvider->query->->orderBy(['tahun' => SORT_DESC]);
////        $search = new \app\models\hronline\TblprcobiodataSearch();
// 
//        return $this->render('/lapordiri/a_searchbon', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//            'bon'=>$bon,
//
//                    
//        ]);
//    }
    public function findLainBorang($status) {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => \app\models\cbelajar\RefElaun::find()->where(['status' => 1]),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }

    public function actionSenaraiElaun() {
        $model = new \app\models\cbelajar\TblElaun();
        $icno = Yii::$app->user->getId();
        $senarai_dokumen2 = $this->findLainBorang(1);
//        $status = TblPermohonan::findAll(['icno' => $icno, 'status_proses'=> "Selesai Permohonan", 'idBorang'=> 1]); //senarai status permohonan
        $searchModel = new \app\models\cbelajar\TblElaunSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $ver = \app\models\cbelajar\TblElaun::findAll(['ver_by' => $icno]);


        return $this->render('admin/senarai_elaun', [

                    'senarai_dokumen2' => $senarai_dokumen2,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
//            'ver' => $ver,
                    'model' => $model,
        ]);
    }

    protected function findModel4($id) {

        if (($model = \app\models\cbelajar\TblElaun::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSearchElaun($jfpiu = NULL) {
        $models = \app\models\cbelajar\TblElaun::find()->where(['status_bayaran' => "BELUM DIPROSES"])->all();

        $searchModel = new \app\models\cbelajar\TblAllowanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $arrayicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=', 'Status', '6']) : '';
        $query = empty($arrayicno) ? \app\models\cbelajar\TblElaun::find() : \app\models\cbelajar\TblElaun::find()->where(['icno' => $arrayicno->select(['ICNO']), 'bayaran' => "UMS"]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,]
        ]);

        $selection = (array) Yii::$app->request->post('selection'); //typecasting
//var_dump( $selection); die;
        $arraynot = '';
        if (Yii::$app->request->post()) {
            foreach ($selection as $id) {
//                if(\app\models\cbelajar\TblBiasiswa::find()->where(['id' => $id])->exists()){
//                    $arraynot = $arraynot.  \app\models\cbelajar\TblBiasiswa::find()->where(['id' => $id])->one()->kakitangan->CONm.', ';
//                }else{
                $model = \app\models\cbelajar\TblElaun::find()->where(['icno' => $id])->exists() ?
                        \app\models\cbelajar\TblElaun::find()->where(['icno' => $id])->one() : new \app\models\cbelajar\TblElaun();
//                    $model->icno = $id;

                $model->dt_sbayar = Yii::$app->request->post('tutup');
                $model->dt_nbayar = Yii::$app->request->post('tahun');
                $model->save(false);

//                    $this->notifikasi($id, 'For your information, your current contract period will end on '.date_format(date_create($model->kakitangan->endDateLantik), 'd F Y').'; Please submit your contract extension application through the system before or on '.date_format(date_create($model->end_date), 'd F Y').Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
            }
//                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Cannot open for '.$arraynot.' because there is existing pending application on their name']);
        }



//       $dataProvider->query->andFilterWhere(['jenis_elaun'=>"PUMS","KUMS", ]);

        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['jenis_elaun']) ? $dataProvider->query->andFilterWhere(['like', 'jenis_elaun', Yii::$app->request->queryParams['jenis_elaun']]) : '';

//        $search = new \app\models\hronline\TblprcobiodataSearch();

        return $this->render('a_search_elaun', [
//            'query' => $query,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'jfpiu' => $jfpiu,
//                    'a' => $a,
        ]);
    }

    public function actionSenaraiSaraHidup($jfpiu = NULL) {
        $models = \app\models\cbelajar\TblElaun::find()->where(['status_bayaran' => "BELUM DIPROSES"])->all();

        $searchModel = new \app\models\cbelajar\TblAllowanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $arrayicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=', 'Status', '6']) : '';
        $query = empty($arrayicno) ? \app\models\cbelajar\TblElaun::find() : \app\models\cbelajar\TblElaun::find()->where(['icno' => $arrayicno->select(['ICNO']), 'bayaran' => "UMS"]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,]
        ]);

        $selection = (array) Yii::$app->request->post('selection'); //typecasting
//var_dump( $selection); die;
        $arraynot = '';
        if (Yii::$app->request->post()) {
            foreach ($selection as $id) {
//                if(\app\models\cbelajar\TblBiasiswa::find()->where(['id' => $id])->exists()){
//                    $arraynot = $arraynot.  \app\models\cbelajar\TblBiasiswa::find()->where(['id' => $id])->one()->kakitangan->CONm.', ';
//                }else{
                $model = \app\models\cbelajar\TblElaun::find()->where(['icno' => $id])->exists() ?
                        \app\models\cbelajar\TblElaun::find()->where(['icno' => $id])->one() : new \app\models\cbelajar\TblElaun();
//                    $model->icno = $id;

                $model->dt_sbayar = Yii::$app->request->post('tutup');
                $model->dt_nbayar = Yii::$app->request->post('tahun');
                $model->save(false);

//                    $this->notifikasi($id, 'For your information, your current contract period will end on '.date_format(date_create($model->kakitangan->endDateLantik), 'd F Y').'; Please submit your contract extension application through the system before or on '.date_format(date_create($model->end_date), 'd F Y').Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
            }
//                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Cannot open for '.$arraynot.' because there is existing pending application on their name']);
        }



        $dataProvider->query->andFilterWhere(['elaun' => "SARA"]);

        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['jenis_elaun']) ? $dataProvider->query->andFilterWhere(['like', 'jenis_elaun', Yii::$app->request->queryParams['jenis_elaun']]) : '';

//        $search = new \app\models\hronline\TblprcobiodataSearch();

        return $this->render('admin/senarai_sara', [
//            'query' => $query,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'jfpiu' => $jfpiu,
//                    'a' => $a,
        ]);
    }

    public function actionListElaun($jfpiu = NULL) {
        $models = \app\models\cbelajar\TblElaun::find()->where(['status_bayaran' => "BELUM DIPROSES"])->all();
        $elaun = \app\models\cbelajar\KadarA::find()->WHERE(['id' => ["SARA", "EAP", "EAPK", "EBKS", "EBS", "EP", "EP4"]])->all();
        $searchModel = new \app\models\cbelajar\TblAllowanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $arrayicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=', 'Status', '6']) : '';
        $query = empty($arrayicno) ? \app\models\cbelajar\TblElaun::find() : \app\models\cbelajar\TblElaun::find()->where(['icno' => $arrayicno->select(['ICNO']), 'bayaran' => "UMS"]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,]
        ]);

        $selection = (array) Yii::$app->request->post('selection'); //typecasting
//var_dump( $selection); die;
        $arraynot = '';
        if (Yii::$app->request->post()) {
            foreach ($selection as $id) {
//                if(\app\models\cbelajar\TblBiasiswa::find()->where(['id' => $id])->exists()){
//                    $arraynot = $arraynot.  \app\models\cbelajar\TblBiasiswa::find()->where(['id' => $id])->one()->kakitangan->CONm.', ';
//                }else{
                $model = \app\models\cbelajar\TblElaun::find()->where(['icno' => $id, 'jenis_elaun' => ["ESH", "EBSR", "EBK", "YP", "TIKET"]])->exists() ?
                        \app\models\cbelajar\TblElaun::find()->where(['icno' => $id, 'jenis_elaun' => ["ESH", "EBSR", "EBK", "YP", "TIKET"]])->one() : new \app\models\cbelajar\TblElaun();
//                    $model->icno = $id;

                $model->dt_sbayar = Yii::$app->request->post('tutup');
                $model->dt_nbayar = Yii::$app->request->post('tahun');
                $model->save(false);

//                    $this->notifikasi($id, 'For your information, your current contract period will end on '.date_format(date_create($model->kakitangan->endDateLantik), 'd F Y').'; Please submit your contract extension application through the system before or on '.date_format(date_create($model->end_date), 'd F Y').Html::a('<i class="fa fa-arrow-right"></i>', ['kontrakakademik/mohonlanjut'], ['class'=>'btn btn-primary btn-sm']));
            }
//                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Cannot open for '.$arraynot.' because there is existing pending application on their name']);
        }



        $dataProvider->query->andFilterWhere(['jenis_elaun' => ["ESH", "EBSR", "EBK", "YP", "TIKET"]]);

        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['jenis_elaun']) ? $dataProvider->query->andFilterWhere(['like', 'jenis_elaun', Yii::$app->request->queryParams['jenis_elaun']]) : '';

//        $search = new \app\models\hronline\TblprcobiodataSearch();

        return $this->render('admin/senarai_keluarga', [
//            'query' => $query,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'jfpiu' => $jfpiu,
//            'model'=> $model,
                    'elaun' => $elaun,
//                    'a' => $a,
        ]);
    }

    public function actionSearchAllBiasiswa($jfpiu = null, $category = null, $jawatan = null, $khidmat = null) {

        $searchModel = new \app\models\cbelajar\TblBiasiswaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->query->andFilterWhere(['status'=>1]);
        $listicno = $jawatan ? Tblprcobiodata::find()->where(['gredJawatan' => $jawatan]) : Tblprcobiodata::find()->where(['Status' => [1, 2, 6]]);
//       $listicno = $khidmat? Tblprcobiodata::find()->where(['Status' => [1,2,6]]): Tblprcobiodata::find()->where(['Status'=>[1,2,6]]);
        $list = $category ? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]) : $listicno;
        $jfpiu ? $listicno->where(['DeptId' => $jfpiu]) : $listicno;
        $khidmat ? $listicno->where(['Status' => $khidmat]) : $listicno;
        $query = \app\models\cbelajar\TblBiasiswa::find()->where(['icno' => $listicno->select(['ICNO'])]);
        $dataProvider = new ActiveDataProvider([

            'query' => $query,
            'pagination' => [

                'pageSize' => 5,
            ],
        ]);
//        $search = new \app\models\hronline\TblprcobiodataSearch();
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere
                                (['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['jenisCd']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'jenisCd', Yii::$app->request->queryParams['jenisCd']]) : '';
        isset(Yii::$app->request->queryParams['nama_tajaan']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'nama_tajaan', Yii::$app->request->queryParams['nama_tajaan']]) : '';

        return $this->render('biasiswa/senarai_all_biasiswa', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
//            'category'=>$category,
                    'jfpiu' => $jfpiu,
                    'jawatan' => $jawatan,
                    'khidmat' => $khidmat,
                    'category' => $category,
                    'listicno' => $listicno,
                    'list' => $list,
        ]);
    }

    public function actionSearchBiasiswa($jfpiu = null, $category = null, $jawatan = null, $khidmat = null) {

        $searchModel = new \app\models\cbelajar\TblBiasiswaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['status' => 1]);
        $listicno = $jawatan ? Tblprcobiodata::find()->where(['gredJawatan' => $jawatan]) : Tblprcobiodata::find()->where(['Status' => [1, 2, 6]]);
//       $listicno = $khidmat? Tblprcobiodata::find()->where(['Status' => [1,2,6]]): Tblprcobiodata::find()->where(['Status'=>[1,2,6]]);
        $list = $category ? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]) : $listicno;
        $jfpiu ? $listicno->where(['DeptId' => $jfpiu]) : $listicno;
        $khidmat ? $listicno->where(['Status' => $khidmat]) : $listicno;
        $query = \app\models\cbelajar\TblBiasiswa::
                find()->where(['icno' => $listicno->select(['ICNO'])])->andWhere(['status'=>1]);
        $dataProvider = new ActiveDataProvider([

            'query' => $query,
            'pagination' => [

                'pageSize' => 5,
            ],
        ]);
//        $search = new \app\models\hronline\TblprcobiodataSearch();
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere
                                (['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['jenisCd']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'jenisCd', Yii::$app->request->queryParams['jenisCd']]) : '';
        isset(Yii::$app->request->queryParams['nama_tajaan']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'nama_tajaan', Yii::$app->request->queryParams['nama_tajaan']]) : '';

        return $this->render('biasiswa/senarai_biasiswa', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
//            'category'=>$category,
                    'jfpiu' => $jfpiu,
                    'jawatan' => $jawatan,
                    'khidmat' => $khidmat,
                    'category' => $category,
                    'listicno' => $listicno,
                    'list' => $list,
        ]);
    }

    public function actionSearchPengajian($jfpiu = null, $category = null, $my = null) {

        $current = TblPengajian::find()->where(['<=', 'tarikh_mula', date('Y-m-d')])->one();
//       $my? :$my = date('Y-m');
        $lulus = $this->GridPengajian();

        $searchModel = new \app\models\cbelajar\TblPengajianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider2 = $searchModel->search(Yii::$app->request->queryParams);

        $listicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['Status' => [1, 2, 6]]) : Tblprcobiodata::find()->where(['Status' => [1, 2, 6]]);
        $category ? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]) : $listicno;
//        $jfpiu? $listicno->where(['DeptId' => $jfpiu]): $listicno;
//        $arrayicno = $job? Tblprcobiodata::find()->where(['DeptId' => $job])->andWhere(['!=','Status', '6'])->joinWith('jawatan')
//: '';
//                 $arrayicno = $job? Tblprcobiodata::find()->where(['DeptId' => $job])->andWhere(['!=','Status', '6']): '';
//         $query = empty($arrayicno)? \app\models\cbelajar\TblPengajian::find() : \app\models\cbelajar\TblPengajian::find()->where(['icno' => $arrayicno->select(['ICNO'])]);    
//          $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            
//        ]);
//        $query = empty($listicno)? \app\models\cbelajar\TblPengajian::find() : \app\models\cbelajar\TblPengajian::find()->where(['icno' => $listicno->select(['ICNO'])]);    
        $query = TblPengajian::find()->where(['icno' => $listicno->select(['ICNO'])]);
        $dataProvider = new ActiveDataProvider([

            'query' => $query,
            'pagination' => [

                'pageSize' => 8,
            ],
        ]);

        $dataProvider->query->andFilterWhere(['cb_tbl_pengajian.status' => 1])->orderBy(['tarikh_mula' => SORT_ASC]);
        $dataProvider2->query->orderBy(['tarikh_mula' => SORT_ASC]);

        $my ? $dataProvider->query->andFilterWhere(['like', 'tarikh_mula', date_format(date_create($my), 'Y-m')]) : ' ';
        $my ? $dataProvider2->query : ' ';

//  $current = TblPengajian::find()->where(['<=', 'tarikh_mula', date('Y-m')])->one();
//        $my? :$my = $current->tahun;
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere
                                (['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';

        isset(Yii::$app->request->queryParams['HighestEduLevelCd']) ? $dataProvider->query->andFilterWhere(
                                ['=', 'HighestEduLevelCd', Yii::$app->request->queryParams['HighestEduLevelCd']]) : '';

        isset(Yii::$app->request->queryParams['modeID']) ? $dataProvider->query->andFilterWhere(
                                ['=', 'modeID', Yii::$app->request->queryParams['modeID']]) : '';


//        $search = new \app\models\hronline\TblprcobiodataSearch();

        return $this->render('pengajian/senarai_pengajian_aktif', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider2' => $dataProvider2,
                    'category' => $category,
                    'query' => $query,
                    'my' => $my,
                    'lulus' => $lulus,
//                    '$job' =>$job,
        ]);
    }

    public function actionSearchAllPengajian($jfpiu = null, $category = null, $my = null) {

        $searchModel = new \app\models\cbelajar\TblPengajianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $listicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['Status' => [1, 2, 6]]) : Tblprcobiodata::find()->where(['Status' => [1, 2, 6]]);
        $category ? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]) : $listicno;

        $query = TblPengajian::find()->where(['icno' => $listicno->select(['ICNO'])]);
        $dataProvider = new ActiveDataProvider([

            'query' => $query,
            'pagination' => [

                'pageSize' => 5,
            ],
        ]);

//        $dataProvider->query->orderBy(['tarikh_mula'=>SORT_ASC]);

        $my ? $dataProvider->query->andFilterWhere(['like', 'tarikh_mula', date_format(date_create($my), 'Y-m')]) : ' ';

        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere
                                (['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';

        isset(Yii::$app->request->queryParams['HighestEduLevelCd']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'HighestEduLevelCd', Yii::$app->request->queryParams['HighestEduLevelCd']]) : '';


//        $search = new \app\models\hronline\TblprcobiodataSearch();

        return $this->render('pengajian/senarai_pengajian_keseluruhan', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'category' => $category,
                    'query' => $query,
        ]);
    }

    public function actionSearchLkk($jfpiu = null, $category = null, $my = null) {
        $searchModel = new \app\models\cbelajar\TblPengajianSearch();
        $current = \app\models\cbelajar\TblLkk::find()->where(['<=', 'effectivedt', date('Y-m-d')])->one();

//        $my? :$my = $current->effectivedt;
        $biodata = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['Status' => [1, 2, 6]]) : Tblprcobiodata::find()->where(['Status' => [1, 2, 6]]);
        $category ? $biodata->joinWith('jawatan')->andWhere(['gredjawatan.job_category' => $category]) : $biodata;
        $lkk = \app\models\cbelajar\TblLkk::find()->where(['status_form' => "1"])->all();
        if ($my) {
            $listicno = array_intersect(ArrayHelper::getColumn($biodata->all(), 'ICNO'), ArrayHelper::getColumn(\app\models\cbelajar\TblLkk::find()->
                                    where(['like', 'effectivedt', date_format(date_create($my), 'Y-m')])->all(), 'icno'));
        } else {
            $listicno = $biodata->select(['ICNO']);
        }
        $query = TblPengajian::find()->where(['cb_tbl_pengajian.icno' => $listicno]);

        $dataProvider = new ActiveDataProvider([

            'query' => $query,
            'pagination' => [

                'pageSize' => 10,
            ],
        ]);

        $dataProvider->query->andFilterWhere(['cb_tbl_pengajian.status' => 1])->orderBy(['tarikh_mula' => SORT_ASC]);
//        $my? $dataProvider->query->andFilterWhere(['like', 'tarikh_mula', date_format(date_create($my), 'Y-m')]):' ';
        // search tarikh perlu hantar lkk
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere
                                (['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';

        isset(Yii::$app->request->queryParams['HighestEduLevelCd']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'HighestEduLevelCd', Yii::$app->request->queryParams['HighestEduLevelCd']]) : '';

        return $this->render('lkk/senarai_staff', [
                    'dataProvider' => $dataProvider,
                    'category' => $category,
                    'query' => $query,
                    'lkk' => $lkk, 'my' => $my
        ]);
    }

    public function actionSearchLkkKj($jfpiu = null, $category = null, $my = null) {
        $searchModel = new \app\models\cbelajar\TblPengajianSearch();
        $current = \app\models\cbelajar\TblLkk::find()->where(['<=', 'effectivedt', date('Y-m-d')])->one();
        $userID = Yii::$app->user->getId();

//        $my? :$my = $current->effectivedt;
        $biodata = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['Status' => [1, 2, 6]]) : Tblprcobiodata::find()->where(['Status' => [1, 2, 6]]);
        $category ? $biodata->joinWith('jawatan')->andWhere(['gredjawatan.job_category' => $category]) : $biodata;
        $lkk = \app\models\cbelajar\TblLkk::find()->where(['status_form' => "1"])->all();
        if ($my) {
            $listicno = array_intersect(ArrayHelper::getColumn($biodata->all(), 'ICNO'), ArrayHelper::getColumn(\app\models\cbelajar\TblLkk::find()->
                                    where(['like', 'effectivedt', date_format(date_create($my), 'Y-m')])->all(), 'icno'));
        } else {
            $listicno = $biodata->select(['ICNO']);
        }
//        $query = TblPengajian::find()->where(['cb_tbl_pengajian.icno' => $listicno]);
        $query = \app\models\cbelajar\TblPengajian::find()
                ->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1, 2]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['!=', 'tblprcobiodata.Status', '1'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])
                ->orderBy('CONm');
        $dataProvider = new ActiveDataProvider([

            'query' => $query,
            'pagination' => [

                'pageSize' => 10,
            ],
        ]);

        $dataProvider->query->andFilterWhere(['cb_tbl_pengajian.status' => 1])->orderBy(['tarikh_mula' => SORT_ASC]);
//        $my? $dataProvider->query->andFilterWhere(['like', 'tarikh_mula', date_format(date_create($my), 'Y-m')]):' ';
        // search tarikh perlu hantar lkk
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere
                                (['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';

        isset(Yii::$app->request->queryParams['HighestEduLevelCd']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'HighestEduLevelCd', Yii::$app->request->queryParams['HighestEduLevelCd']]) : '';

        return $this->render('lkk/senarai_staff_kj', [
                    'dataProvider' => $dataProvider,
                    'category' => $category,
                    'query' => $query,
                    'lkk' => $lkk, 'my' => $my
        ]);
    }

    public function actionSenaraiTambahManual() {

        $searchModel = new \app\models\cbelajar\TblPengajianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['by' => "LKK UPDATE"]);

//        $search = new \app\models\hronline\TblprcobiodataSearch();

        return $this->render('pengajian/senarai_manual', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

//     public function actionSearchBon() {
//
//     
//
//        $searchModel = new \app\models\cbelajar\TblLaporDiriSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
////        $dataProvider->query->andFilterWhere(['status'=>1]);
////        $search = new \app\models\hronline\TblprcobiodataSearch();
// 
//        return $this->render('a_searchbon', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//
//                    
//        ]);
//    
//    }
//    public function actionSearchNominal() {
//
//        $searchModel = new \app\models\hronline\BiodataSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('a_searchnd', [
//                    'searchModel' => $searchModel,
//                    'b' => ArrayHelper::map(Tblprcobiodata::find()
//                                        ->where(['!=','tblprcobiodata.Status', 6])
//                                        ->joinWith('jawatan')
//                                        ->joinWith('statusLantikan')
//                                        ->andWhere(['appointmentstatus.ApmtStatusCd' => [1,2]])
//                                        ->andWhere(['tblprcobiodata.NatStatusCd' => 1])
//                                        ->andWhere(['gredjawatan.job_category' => 1])->all(), 'CONm',
//                function($model) {
//                    $a = $model['CONm'] . ' - ' . $model->department->shortname;
//                    return $a;
//                }, 'department.fullname'), //groupby,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }
    public function actionTambahAdmin() {

        $staff = $this->GridRekodAdmin();
        $model = new TblAccess();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Ditambah!', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['tambah-admin']);
        }
        if (TblAccess::find()->where(['icno' => Yii::$app->user->getId(), 'level' => 1])->exists()) {
            return $this->render('s_tambah_admin', [
                        'staff' => $staff,
                        'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('../cutibelajar/index');
        }
    }

    public function actionSenaraiPa($jfpiu = null) {

        $staff = $this->GridRekodPa();
        $model = new \app\models\cbelajar\AksesPa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Ditambah!', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['senarai-pa']);
        }
        if (TblAccess::find()->where(['icno' => Yii::$app->user->getId(), 'level' => 1])->exists()) {
            return $this->render('s_pa', [
                        'staff' => $staff,
                        'model' => $model,
                        'jfpiu' => $jfpiu,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('../cutibelajar/index');
        }
    }

    public function actionEditbukapermohonan($id) {

        $model = \app\models\cbelajar\TblBukapermohonan::find()->where(['id' => $id])->one();
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $model->start_tamatkontrak = date('Y-m-d H:i:s', strtotime($data['starttamatkontrak']));
            $model->end_tamatkontrak = date('Y-m-d H:i:s', strtotime($data['endtamatkontrak']));
            $model->start_bolehmohon = date('Y-m-d H:i:s', strtotime($data['startbolehmohon']));
            $model->end_bolehmohon = date('Y-m-d H:i:s', strtotime($data['endbolehmohon']));
            $model->tahun = $data['tahun'];

            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Perubahan Berjaya Disimpan']);
            return $this->redirect('tetapanbukapermohonan');
        }

        return $this->render('editbukapermohonan', [
                    'model' => $model
        ]);
    }

    public function actionDeleteAdmin($id) {
        $staff = TblAccess::findOne(['id' => $id]);
        $staff->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dipadam!', 'type' => 'success', 'msg' => '']);

        return $this->redirect(['tambah-admin']);
    }

    public function actionDeletePa($id) {
        $staff = \app\models\cbelajar\AksesPa::findOne(['id' => $id]);
        $staff->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dipadam!', 'type' => 'success', 'msg' => '']);

        return $this->redirect(['senarai-pa']);
    }

    public function GridRekodAdmin() {
        $data = new ActiveDataProvider([
            'query' => TblAccess::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridRekodPa() {
//         $listicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['Status' => [1, 2, 6]]) : Tblprcobiodata::find()->where(['Status' => [1, 2, 6]]);
//        $staff = \app\models\cbelajar\AksesPa::find()->where(['icno' => $listicno->select(['ICNO'])]);

        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\AksesPa::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanStatusDiterima() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\BorangPenerbangan::find()->where(['status_bsm' => "Diluluskan", 'borangID' => 4, 'idBorang' => ['CBDN', 'CBLN']])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $data;
    }

//     public function GridPermohonanStatusKj() {
//        $data = new ActiveDataProvider([
//            'query' => \app\models\cbelajar\BorangPenerbangan::find()->where(['status_kj' =>"Layak Dipertimbangkan",'borangID'=>4]),
//            'pagination' => [
//                'pageSize' => 10,
//            ],
//        ]);
//        return $data;
//    }
    public function GridPermohonanStatusDiluluskan() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\BorangPenerbangan::find()->where(['status_kj' => "DILULUSKAN", 'borangID' => 4]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanStatusLulus() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\BorangPenerbangan::find()->where(['status_kj' => "DILULUSKAN", 'status_a' => NULL, 'borangID' => 4])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanStatusUrus() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\BorangPenerbangan::find()->where(['status_a' => "DITEMPAH", 'borangID' => 4])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridPengajian() {
        $data = new ActiveDataProvider([
            'query' => TblPengajian::find()->all(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionAdmin() {

        $urus = $this->GridPermohonanStatusUrus();
        $lulus = $this->GridPermohonanStatusLulus();
        if (\app\models\cbelajar\TblAccess::find()->where([ 'icno' => Yii::$app->user->getId(), 'level' => 3])->exists()) {
            return $this->render('a_main', [
                        'urus' => $urus,
                        'lulus' => $lulus,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['kj']);
        }
    }

    public function actionKj() {

        $permohonan = $this->GridPermohonanStatusDiterima();
        $lulus = $this->GridPermohonanStatusDiluluskan();
        if (in_array(Yii::$app->user->getId(), ['950829125446', '701203106182'])) {
            return $this->render('a_mainkj', [
                        'permohonan' => $permohonan,
                        'lulus' => $lulus,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('/cutibelajar/index');
        }
    }

    public function GridDokumen() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblFileKpm::find()->joinWith('mohon')
                    ->where(['cb_tbl_permohonan.status' => ["LULUS", "DALAM TINDAKAN BSM", "DALAM TINDAKAN KETUA JABATAN"]]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionListDokumen() {

        $permohonan = $this->GridDokumen();
        isset(Yii::$app->request->queryParams['nama_dokumen']) ? $permohonan->query->andFilterWhere(
                                ['like', 'nama_dokumen', Yii::$app->request->queryParams['nama_dokumen']]) : '';
        if (\app\models\cbelajar\TblAccess::find()->where([ 'icno' => Yii::$app->user->getId(), 'level' => 2])->exists()) {
            isset(Yii::$app->request->queryParams['uploaded_by']) ? $permohonan->query->andFilterWhere
                                    (['like', 'uploaded_by', Yii::$app->request->queryParams['uploaded_by']]) : '';
            return $this->render('a_dokumen', [
                        'permohonan' => $permohonan,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('/cutibelajar/index');
        }
    }

    protected function resetpegawai() {
        $model = \app\models\cbelajar\TblLkk::find()->where(['status' => "NULL"])->all();

        foreach ($model as $models) {
            if ($models->status_jfpiu == 'Tunggu Perakuan') {
                $pegawai = Department::findOne(['id' => $models->kakitangan->DeptId]);

                if ($pegawai->sub_of == '' || $pegawai->sub_of == '12') {
                    $models->app_by = $pegawai->chief; //kj 
                } else {
                    $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
                    $models->app_by = $pegawaisub->chief; //kj 
                }

                if ($models->ver_by == '') { //jika pemohon tiada ketua pentadiran
                    $models->status_pp = '';
                    $models->status = 'DALAM TINDAKAN KETUA JABATAN';
                    $petindak1 = 'Ketua Jabatan';
                    $icnopetindak1 = $models->app_by;
                }

                $models->status_jfpiu = 'Tunggu Perakuan';
                $models->status_bsm = 'Tunggu Kelulusan';

                $models->save();
                //$this->notifikasi($icnopetindak1, "Permohonan pengesahan dalam perkhidmatan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrak/menunggu'], ['class'=>'btn btn-primary btn-sm']));
            } elseif ($models->status == 'DALAM TINDAKAN KETUA JABATAN') {

                $pegawai = Department::findOne(['id' => $models->kakitangan->DeptId]);
                if ($pegawai->sub_of == '' || $pegawai->sub_of == '12') {
                    $models->app_by = $pegawai->chief; //kj 
                } else {
                    $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
                    $models->app_by = $pegawaisub->chief; //kj 
                }

                $models->save();
            }
        }
    }

    protected function notifipegawai() {
        $this->resetpegawai();
        // $app = Pengesahan::find()->where(['status' => 'DALAM TINDAKAN KETUA JABATAN'])->groupBy('app_by')->all();
        $app = \app\models\cbelajar\TblLkk::find()->where(['status' => "NULL"])->all();

        foreach ($app as $a) {
            $this->notifikasi($a->app_by, "Permohonan pengesahan dalam perkhidmatan menunggu tindakan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['pengesahan/menunggu'], ['class' => 'btn btn-primary btn-sm']));
        }

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi Berjaya Dihantar']);
    }

    protected function findMaklumat1($id) {
        return \app\models\cbelajar\TblPermohonan::findOne(['icno' => $id]);
    }

    protected function findLkk($id) {
        return \app\models\cbelajar\TblLkk::findAll(['icno' => $id]);
    }

    protected function findKemudahan($id) {
        if (($model = \app\models\cbelajar\TblPermohonan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDeleteData($id) {

        $mj = TblPengajian::findOne($id)->delete();
        $study = TblBiasiswa::findOne($id)->delete();
//        $p = TblPermohonan::findOne($id)->$delete();
//        $iklan = findIklanbyID($id);

        return $this->redirect(['cbadmin/search']);
    }

    public function GridPermohonanLanjutanLulus() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblLanjutan::find()->where(['status_mesyuarat' => ['Diluluskan']])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanLanjutanTolak() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblLanjutan::find()->where(['status_mesyuarat' => "Tidak Diluluskan"])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanLanjutanKiv() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblLanjutan::find()->where(['status_mesyuarat' => "KIV"])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionSenaraitindakan($id = null) {
        $icno = Yii::$app->user->getId();
        $title = '';
        $model = $this->findLanjutan($id);
        $models = TblLanjutan::find()->where(['status_borang' => "Selesai Permohonan"])->all();
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke' => SORT_DESC])->limit(1)->one();
//         $cari = $this->findLkk($id);

        $senarai = '';
        $lulus = $this->GridPermohonanLanjutanLulus();
        $tolak = $this->GridPermohonanLanjutanTolak();
        $kiv = $this->GridPermohonanLanjutanKiv();
        $status = ['Tunggu Kelulusan', 'Diluluskan', 'Tidak Diluluskan'];
        $selection = (array) Yii::$app->request->post('selection'); //typecasting

        if (Yii::$app->request->post('simpan')) {

            foreach ($models as $data) {
                if ('y' . $data->id == Yii::$app->request->post($data->id)) {
                    if ($data->status_mesyuarat == "Diluluskan") {
                        $model = $this->findModel($data->id);
                        $model->status_bsm = 'Draft Diluluskan';
                        $model->status_b = 1;
                        $model->save(false);
                    } else {
                        $model = $this->findModel($data->id);
                        $model->status_bsm = 'KIV';
                        $model->status_b = 4;
                        $model->save(false);
                    }
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
                $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => $hantar->icno])->all();
                $b = TblPengajian::find()->where(['icno' => $hantar->icno, 'status' => 1])->one();

                $lkklanjut = new \app\models\cbelajar\TblLkk();
                if ('n' . $hantar->id == Yii::$app->request->post($hantar->id)) {
                    $hantar->status = 'TIDAK LULUS';
                    $hantar->status_bsm = 'Tidak Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');

                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan anda tidak berjaya." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                } elseif ('y' . $hantar->id == Yii::$app->request->post($hantar->id)) {
                    if ($hantar->status_mesyuarat == "Diluluskan") {
                        $hantar->status = 'LULUS';
                        $hantar->status_bsm = 'Diluluskan';
                        $hantar->status_b = 1;
                        $hantar->ver_date = date('Y-m-d H:i:s');
                        $hantar->ver_by = $icno;
                        $effectiveDate = date('Y-m-d', strtotime("+1 days", strtotime($hantar->lanjutanedt)));


//                        $lkk->HighestEduLevelCd = \app\models\cbelajar\TblPengajian::find()->where(['i'=>$pengajian->icno])->one()->HighestEduLevelCd;
                        foreach ($lkk as $lkk) {
                            if ($lkk->semester == 4) {
                                $lkklanjut->icno = $hantar->icno;
                                $lkklanjut->created_dt = date('Y-m-d H:i:s');
                                $lkklanjut->update_by = $icno;
                                $lkklanjut->status_form = 1;
                                $lkklanjut->semester = 5;
                                $lkklanjut->agree = 2;
                                $lkklanjut->studyID = $b->id;

                                $lkklanjut->effectivedt = $effectiveDate;
                            } elseif ($lkk->semester == 5) {
                                $lkklanjut->icno = $hantar->icno;
                                $lkklanjut->created_dt = date('Y-m-d H:i:s');
                                $lkklanjut->update_by = $icno;
                                $lkklanjut->status_form = 1;
                                $lkklanjut->semester = 6;
                                $lkklanjut->agree = 2;
                                $lkklanjut->studyID = $b->id;

                                $lkklanjut->effectivedt = $effectiveDate;
                            } elseif ($lkk->semester == 6) {
                                $lkklanjut->icno = $hantar->icno;
                                $lkklanjut->created_dt = date('Y-m-d H:i:s');
                                $lkklanjut->update_by = $icno;
                                $lkklanjut->status_form = 1;
                                $lkklanjut->semester = 7;
                                $lkklanjut->effectivedt = $effectiveDate;
                                $lkklanjut->agree = 2;
                                $lkklanjut->studyID = $b->id;
                            } elseif ($lkk->semester == 7) {
                                $lkklanjut->icno = $hantar->icno;
                                $lkklanjut->created_dt = date('Y-m-d H:i:s');
                                $lkklanjut->update_by = $icno;
                                $lkklanjut->status_form = 1;
                                $lkklanjut->semester = 8;
                                $lkklanjut->effectivedt = $effectiveDate;
                                $lkklanjut->agree = 2;

                                $lkklanjut->studyID = $b->id;
                            } elseif ($lkk->semester == 8) {
                                $lkklanjut->icno = $hantar->icno;
                                $lkklanjut->created_dt = date('Y-m-d H:i:s');
                                $lkklanjut->update_by = $icno;
                                $lkklanjut->status_form = 1;
                                $lkklanjut->semester = 9;
                                $lkklanjut->agree = 2;
                                $lkklanjut->studyID = $b->id;

                                $lkklanjut->effectivedt = $effectiveDate;
                            } else {
                                $lkklanjut->icno = $hantar->icno;
                                $lkklanjut->created_dt = date('Y-m-d H:i:s');
                                $lkklanjut->update_by = $icno;
                                $lkklanjut->status_form = 1;
                                $lkklanjut->agree = 2;
                                $lkklanjut->effectivedt = $effectiveDate;
                                $lkklanjut->studyID = $b->id;
                                $lkklanjut->semester = 10;
                            }

                            $lkklanjut->save(false);
                        }



                        $this->notifikasi($hantar->icno, "Adalah dimaklumkan bahawa Permohonan Cuti Belajar anda adalah diluluskan. 
                        Dr./Tuan/Puan dimohon untuk hadir ke Pejabat Bahagian Sumber Manusia, Aras 3, 
                        Bangunan Canselori untuk tujuan pengambilan surat tawaran Cuti Belajar beserta 
                        lampiran-lampiran dan borang perjanjian Cuti Belajar Dr./Tuan/Puan boleh datang ke Bahagian Sumber Manusia pada masa pejabat.
." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
//                                $hantar->save(false);
                    } else {
                        $hantar->status = 'KIV';
                        $hantar->status_bsm = 'KIV';
                        $hantar->status_b = 4;
                        $hantar->ver_date = date('Y-m-d H:i:s');
                        $hantar->ver_by = $icno;
                        $this->notifikasi($hantar->icno, "Permohonan Pelanjutan Tempoh Anda KIV." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                    }
                    $hantar->save(false);
                }
            }
        }
        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            $senarai = TblLanjutan::find()->where(['status' => ["DALAM TINDAKAN BSM", "DALAM TINDAKAN KETUA JABATAN", "KIV"]])->orderBy(['tarikh_mohon' => SORT_DESC]);
            $title = 'Senarai Menunggu Semakan';
        }

        //    elseif(Refpegawai::find()->where( ['pegawai_bsm' => $icno] )->exists()){
        //            
        //            $senarai = Tblyuran::find()->where(['in', 'status_kj', $status])->orderBy(['entry_date' => SORT_DESC]);
        //            $title ='Senarai Menunggu Perakuan';
        //            
        //        }
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);


        if ($title != NULL) {
            return $this->render('senarai_tindakan', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
                        'tmp' => $tmp,
                        'lulus' => $lulus,
                        'tolak' => $tolak, 'kiv' => $kiv
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['/cutibelajar/index']);
        }
    }

    public function actionSara() {
        $icno = Yii::$app->user->getId();
        $title = '';
        $models = \app\models\cbelajar\TblPermohonan::find()->where(['status_proses' => "Selesai Permohonan"])->all();
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke' => SORT_DESC])->limit(1)->one();
        $senarai = '';
        $status = ['Tunggu Kelulusan', 'Diluluskan', 'Tidak Diluluskan'];
        $senarais = new ActiveDataProvider([

            'query' => TblPermohonan::find()->where(['jenis_user_id' => '1']),
            'pagination' => [

                'pageSize' => 20,
            ],
        ]);
//        $dataProvider->query->joinWith('markahkeseluruhan1');
        $senarais->query->joinWith('kakitangan');
        $senarais->query->orderBy([
            'status_jfpiu' => SORT_ASC,
        ]);

        if (isset(Yii::$app->request->queryParams['icno'])) {
            $senarais->query->andFilterWhere(['like', 'tblprcobiodata.CONm', Yii::$app->request->queryParams['icno']]);
        }

        if (isset(Yii::$app->request->queryParams['status_bsm'])) {
            $status_bsm = Yii::$app->request->queryParams['status_bsm'];
            if (in_array(6, $status_bsm)) {
                array_push($status_bsm, '12', '13');
            }
            $senarais->query->andFilterWhere(['in', 'status_bsm', $status_bsm]);
        }



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
            $senarai = \app\models\cbelajar\TblPermohonan::find()->where([ 'status_proses' => "Selesai Permohonan", 'idBorang' => 1])->orderBy(['tarikh_m' => SORT_DESC]);
            $title = 'Senarai Menunggu Semakan';
        }

        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if ($title != NULL) {
            return $this->render('elaun/_esh', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
                        'tmp' => $tmp,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['/cutibelajar/index']);
        }
    }

    protected function findPermohonanbyID($id) {
        if (($model = \app\models\cbelajar\TblPermohonan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function GridSimpan() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblPermohonan::find()->where(['status_proses' => "Data Disimpan"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridSimpanPengajian() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblPengajian::find()->where(['status' => 9, 'status_proses' => "S"])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanLulus() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblPermohonan::find()->where([
                'status' => ['LULUS'], 'status_mesyuarat' => ['BERSYARAT', 'Diluluskan', 'Lulus Tanpa Pantauan']])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanLulusTanpaPantauan() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblPermohonan::find()->where([
                'status' => ['Lulus Tanpa Pantauan'], 'status_mesyuarat' => ['Lulus Tanpa Pantauan']])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanTidakLulus() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblPermohonan::find()->where(['status_mesyuarat' => "Tidak Diluluskan"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTolakTawaran() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblPermohonan::find()->where(['status' => "TOLAK TAWARAN"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTerimaTawaran() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblPermohonan::find()->where(['status' => "TERIMA TAWARAN"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionSenaraitindakan1($my = null) {
        $icno = Yii::$app->user->getId();
        $title = '';

//        $mohon = findmo
//        $permohonan = $this->findPermohonanbyID($id);
        $models = \app\models\cbelajar\TblPermohonan::find()->where(['status_proses' => "Selesai Permohonan"])->all();
//        $p = TblPengajian::find()->where(['idPermohonan'=>$, 'status'=>9]);
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke' => SORT_DESC])->limit(1)->one();
        $senarai = '';
        $tolak = $this->GridPermohonanTidakLulus();
        $simpan = $this->GridSimpanPengajian();
        $permohonanlulus = $this->GridPermohonanLulus();
        $tidak = $this->GridTolakTawaran();
        $terima = $this->GridTerimaTawaran();
        $tanpa = $this->GridPermohonanLulusTanpaPantauan();
        $status = ['Tunggu Kelulusan', 'Diluluskan', 'Tidak Diluluskan'];
        $senarais = new ActiveDataProvider([

            'query' => TblPermohonan::find()->where(['jenis_user_id' => [1, 2]]),
            'pagination' => [

                'pageSize' => 5,
            ],
        ]);
        $senarais = new ActiveDataProvider([

            'query' => TblPermohonan::find()->where(['jenis_user_id' => [1, 2]]),
            'pagination' => [

                'pageSize' => 5,
            ],
        ]);
//        $dataProvider->query->joinWith('markahkeseluruhan1');
        $senarais->query->joinWith('kakitangan');
        $senarais->query->orderBy([
            'status_jfpiu' => SORT_ASC,
        ]);

        if (isset(Yii::$app->request->queryParams['icno'])) {
            $senarais->query->andFilterWhere(['like', 'tblprcobiodata.CONm', Yii::$app->request->queryParams['icno']]);
        }

        if (isset(Yii::$app->request->queryParams['status_bsm'])) {
            $status_bsm = Yii::$app->request->queryParams['status_bsm'];
            if (in_array(6, $status_bsm)) {
                array_push($status_bsm, '12', '13');
            }
            $senarais->query->andFilterWhere(['in', 'status_bsm', $status_bsm]);
        }



        $selection = (array) Yii::$app->request->post('selection'); //typecasting

        if (Yii::$app->request->post('simpan')) {

            foreach ($models as $data) {
                if ('y' . $data->id == Yii::$app->request->post($data->id)) {

                    if ($data->status_mesyuarat == "Diluluskan") {
                        $model = $this->findModelCB($data->id);
//                    $pengajian= $model->
                        $pengajian = TblPengajian::find()->where(['icno' => $data->icno, 'status' => 9])->all();
                        foreach ($pengajian as $pengajian) {
                            $pengajian->status = 1;
                            $pengajian->userID = $data->jenis_user_id;
                            $pengajian->save(false);
                        }

                        $biasiswa = TblBiasiswa::find()->where(['icno' => $data->icno])->all();
                        foreach ($biasiswa as $biasiswa) {
                            $biasiswa->status = 1;

                            $biasiswa->save(false);
                        }
                        $model->status_bsm = 'Draft Diluluskan';
//                    $pengajian->save(false);
//                    $biasiswa->save(false);
                        $model->save(false);
//                    return $this->redirect('index');
                    } elseif ($data->status_mesyuarat == "KIV") {
                        $model = $this->findModelCB($data->id);
//                    $pengajian= $model->
                        $pengajian = TblPengajian::find()->where(['icno' => $data->icno, 'status' => 9])->all();
                        foreach ($pengajian as $pengajian) {
                            $pengajian->status = 6;
                            $pengajian->userID = $data->jenis_user_id;
                            $pengajian->save(false);
                        }

                        $biasiswa = TblBiasiswa::find()->where(['icno' => $data->icno])->all();
                        foreach ($biasiswa as $biasiswa) {
                            $biasiswa->status = 6;

                            $biasiswa->save(false);
                        }
                        $model->status_bsm = 'Draft KIV';
//                    $pengajian->save(false);
//                    $biasiswa->save(false);
                        $model->save(false);
                    } elseif ($data->status_mesyuarat == "Lulus Tanpa Pantauan") {
                        $model = $this->findModelCB($data->id);
//                    $pengajian= $model->
                        $pengajian = TblPengajian::find()->where(['icno' => $data->icno, 'status' => 9])->all();
                        foreach ($pengajian as $pengajian) {
                            $pengajian->status = 8;
                            $pengajian->userID = $data->jenis_user_id;
                            $pengajian->save(false);
                        }

                        $biasiswa = TblBiasiswa::find()->where(['icno' => $data->icno])->all();
                        foreach ($biasiswa as $biasiswa) {
                            $biasiswa->status = 8;

                            $biasiswa->save(false);
                        }
                        $model->status_bsm = 'Lulus Tanpa Pantauan ';
//                    $pengajian->save(false);
//                    $biasiswa->save(false);
                        $model->save(false);
                    }
                } elseif ('n' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = $this->findModelCB($data->id);
                    $pengajian = TblPengajian::find()->where(['icno' => $data->icno, 'status' => 9])->all();
                    foreach ($pengajian as $pengajian) {
                        $pengajian->status = 1;
                        $pengajian->userID = $data->jenis_user_id;
                        $pengajian->save(false);
                    }
                    $biasiswa = TblBiasiswa::find()->where(['icno' => $data->icno])->one();
                    $biasiswa->status = 1;
                    $model->status_bsm = 'Draft Ditolak';
                    $pengajian->save(false);
                    $biasiswa->save(false);
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

                    $this->notifikasi($hantar->icno, "Maaf, Permohonan Cuti Belajar Anda Tidak Diluluskan." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                } elseif ('y' . $hantar->id == Yii::$app->request->post($hantar->id)) {

                    if ($hantar->status_mesyuarat == "Diluluskan") {
                        $hantar->status = 'LULUS';
                        $hantar->status_bsm = 'Diluluskan';
                        $hantar->tawaran = '2';
                        $hantar->ver_date = date('Y-m-d H:i:s');
                        $hantar->ver_by = $icno;
                        $pengajian = TblPengajian::find()->where(['icno' => $hantar->icno, 'status' => 9])->all();

                        foreach ($pengajian as $pengajian) {
                            $pengajian->status = 1;
                            $pengajian->userID = $hantar->jenis_user_id;
                            $pengajian->save(false);
                        }
                        $biasiswa = TblBiasiswa::find()->where(['icno' => $hantar->icno])->all();
                        foreach ($biasiswa as $biasiswa) {
                            $biasiswa->status = 1;
                            $biasiswa->save(false);
                        }
                    } elseif ($hantar->status_mesyuarat == "KIV") {
                        $hantar->status = 'KIV';
                        $hantar->status_bsm = 'KIV';

                        $hantar->ver_date = date('Y-m-d H:i:s');
                        $hantar->ver_by = $icno;
                        $pengajian = TblPengajian::find()->where(['icno' => $hantar->icno, 'status' => 9])->all();

                        foreach ($pengajian as $pengajian) {
                            $pengajian->status = 6;
                            $pengajian->userID = $hantar->jenis_user_id;
                            $pengajian->save(false);
                        }
                        $biasiswa = TblBiasiswa::find()->where(['icno' => $hantar->icno])->all();
                        foreach ($biasiswa as $biasiswa) {
                            $biasiswa->status = 6;
                            $biasiswa->save(false);
                        }
                    } else {
                        $hantar->status = 'Lulus Tanpa Pantauan';
                        $hantar->status_bsm = 'Lulus Bersyarat';
                        $hantar->ver_date = date('Y-m-d H:i:s');
                        $hantar->ver_by = $icno;
                        $pengajian = TblPengajian::find()->where(['icno' => $hantar->icno, 'status' => 9])->all();

                        foreach ($pengajian as $pengajian) {
                            $pengajian->status = 6;
                            $pengajian->userID = $hantar->jenis_user_id;
                            $pengajian->save(false);
                        }
                        $biasiswa = TblBiasiswa::find()->where(['icno' => $hantar->icno])->all();
                        foreach ($biasiswa as $biasiswa) {
                            $biasiswa->status = 6;
                            $biasiswa->save(false);
                        }
                    }


                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan anda berjaya." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                }
//                 $p->status = 1;
//                    $p->save(false);

                $hantar->save(false);
            }
        }
        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            $senarai = \app\models\cbelajar\TblPermohonan::find()->where
                            (['status_proses' => 'Selesai Permohonan', 'status_bsm' =>
                        ["Tunggu Kelulusan", "Tunggu Kelulusan BSM", "Draft Diluluskan", "Lulus Tanpa Pantauan"], 'idBorang' => [1, 2, 38, 39, 40, 41, 42, 43, 44, 32, 51]])->orderBy(['tarikh_m' => SORT_DESC]);
            $title = 'Senarai Menunggu Semakan';
        }
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $my ? $senarais->query->andFilterWhere(['like', 'tarikh_m', date_format(date_create($my), 'Y-m')]) : ' ';

        if ($title != NULL) {
            return $this->render('senarai_tindakan_1', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
                        'tmp' => $tmp,
                        'tolak' => $tolak,
                        'permohonanlulus' => $permohonanlulus,
                        'simpan' => $simpan, 'tidak' => $tidak, 'tanpa' => $tanpa, 'terima' => $terima
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['/cutibelajar/index']);
        }
    }

    public function actionProses() {
        $icno = Yii::$app->user->getId();
        $title = '';
        $models = \app\models\cbelajar\TblPermohonan::find()->where(['status_proses' => "Selesai Permohonan"])->all();
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke' => SORT_DESC])->limit(1)->one();
        $senarai = '';
//        $status = ['Tunggu Kelulusan', 'Diluluskan', 'Tidak Diluluskan'];
        $senarais = new ActiveDataProvider([

            'query' => TblPermohonan::find()->where(['jenis_user_id' => '1']),
            'pagination' => [

                'pageSize' => 20,
            ],
        ]);
//        $dataProvider->query->joinWith('markahkeseluruhan1');
        $senarais->query->joinWith('kakitangan');
        $senarais->query->orderBy([
            'status_jfpiu' => SORT_ASC,
        ]);

        if (isset(Yii::$app->request->queryParams['icno'])) {
            $senarais->query->andFilterWhere(['like', 'tblprcobiodata.CONm', Yii::$app->request->queryParams['icno']]);
        }

        if (isset(Yii::$app->request->queryParams['status_bsm'])) {
            $status_bsm = Yii::$app->request->queryParams['status_bsm'];
            if (in_array(6, $status_bsm)) {
                array_push($status_bsm, '12', '13');
            }
            $senarais->query->andFilterWhere(['in', 'status_bsm', $status_bsm]);
        }
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
            $senarai = \app\models\cbelajar\TblPermohonan::find()->where([ 'status_proses' => "Selesai Permohonan", 'idBorang' => 1])->orderBy(['tarikh_m' => SORT_DESC]);
            $title = 'PROSES PEMBAYARAN ELAUN';
        }

        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if ($title != NULL) {
            return $this->render('admin/_proseselaun', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
                        'tmp' => $tmp,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['/cutibelajar/index']);
        }
    }

    public function actionSenaraitindakansabatikal() {
        $icno = Yii::$app->user->getId();
        $title = '';
        $models = \app\models\cbelajar\TblPermohonan::find()->where(['status_proses' => "Selesai Permohonan", 'idBorang' => 2])->all();
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
            $senarai = \app\models\cbelajar\TblPermohonan::find()->where([ 'status_proses' => "Selesai Permohonan", 'idBorang' => 2])->orderBy(['tarikh_m' => SORT_DESC]);
            $title = 'Senarai Menunggu Semakan';
        }

        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if ($title != NULL) {
            return $this->render('senarai_tindakan_sabatikal', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
                        'tmp' => $tmp,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['/cutibelajar/index']);
        }
    }

    public function actionTindakanBsm($id, $i) {
        $model = TblLanjutan::find()->where(['iklan_id' => $id, 'id' => $i])->one();
        $mod = \app\models\cbelajar\TblPrestasi::findOne(['id' => $id]); //senarai status permohonan
        $doktoral = \app\models\cbelajar\RefPrestasi::find()->all();
        $iklan = $this->findIklanbyID($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 'DALAM TINDAKAN BSM';
            $model->app_date = date('Y-m-d H:i:s');
            if ($model->status_jfpiu == 'Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);
            } elseif ($model->status_jfpiu == 'Tidak Diperakukan') {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);
            $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan BSM. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['lanjutancb/senaraitindakan']);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        if (TblAdmin::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('_tindakanbsm', [

                        'iklan' => $iklan,
                        'model' => $model,
                        'doktoral' => $doktoral,
                        'mod' => $mod,
                        'bil' => '1',
                        'edit' => $edit,
                        'view' => $view
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionTindakan_bsmlain($id) {

        $model = $this->findModelLain($id);
        $model->ver_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $request = Yii::$app->request;
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke' => SORT_DESC])->limit(1)->one();
//                $tajaan = TblBiasiswa::findOne(['icno' => Yii::$app->user->getId()]);
        if ($model->status_bsm == 'Diluluskan' || $model->status_bsm == 'Tidak Diluluskan') {
            $displaylapor = '';
            $displaytempoh = 'none';
        } else {
            $displaytempoh = '';
            $displaylapor = 'none';
        }


        $message = '';
        if ($model->load($request->post())) {
            $model->status_mesyuarat = $request->post()['TblLain']['status_mesyuarat'];
            $model->catatan = $request->post()['TblLain']['catatan'];
            $model->save(false);
            $message = 'Berjaya Disimpan';
        }

        return $this->renderAjax('tindakan_bsm_1', [
                    'model' => $model,
                    'today' => $today,
                    'message' => $message,
                    'displaytempoh' => $displaytempoh,
                    'tmp' => $tmp,
        ]);
    }

    public function actionTindakan_bsmlapor($id) {

        $model = $this->findModellapor($id);
        $model->ver_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $request = Yii::$app->request;
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke' => SORT_DESC])->limit(1)->one();
//                $tajaan = TblBiasiswa::findOne(['icno' => Yii::$app->user->getId()]);
        if ($model->status_bsm == 'Diluluskan' || $model->status_bsm == 'Tidak Diluluskan') {
            $displaylapor = '';
            $displaytempoh = 'none';
        } else {
            $displaytempoh = '';
            $displaylapor = 'none';
        }


        $message = '';
        if ($model->load($request->post())) {
            $model->status_mesyuarat = $request->post()['TblLapordiri']['status_mesyuarat'];
            $model->status_study = $request->post()['TblLapordiri']['status_study'];
            $model->catatan = $request->post()['TblLapordiri']['catatan'];
            $model->save(false);
            $message = 'Berjaya Disimpan';
        }

        return $this->renderAjax('tindakan_bsmlapor', [
                    'model' => $model,
                    'today' => $today,
                    'message' => $message,
                    'displaytempoh' => $displaytempoh,
                    'tmp' => $tmp,
        ]);
    }

    public function actionTindakan_nd($id) {

        $model = $this->findModellapor($id);
        $model->ver_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $request = Yii::$app->request;
//                $tajaan = TblBiasiswa::findOne(['icno' => Yii::$app->user->getId()]);
        if ($model->status_bsm == 'Diluluskan' || $model->status_bsm == 'Tidak Diluluskan') {
            $displaylapor = '';
            $displaytempoh = 'none';
        } else {
            $displaytempoh = '';
            $displaylapor = 'none';
        }


        $message = '';
        if ($model->load($request->post())) {
            $model->dt_nominal = $request->post()['TblLapordiri']['dt_nominal'];

            $model->save(false);
            $message = 'Berjaya Disimpan';
        }

        return $this->renderAjax('tindakan_nd', [
                    'model' => $model,
                    'today' => $today,
                    'message' => $message,
        ]);
    }

    public function actionView_biasiswa($id) {

        $model = $this->findModel1($id);
//                          $elaun = $this->findElaun($id);
//          $model = \app\models\cbelajar\TblBiasiswa::find()->where(['status_form' => 1])->all();
        if ($model->load(Yii::$app->request->post())) {


            $model->save(false);
        }

        return $this->renderAjax('view_biasiswa', [
                    'model' => $model,
//               'elaun' => $elaun,
        ]);
    }

    public function actionView_pengajian($id) {

        $model = $this->findPengajian2($id);
        $icno = $model->icno;

//             $tot_a = TblLanjutan::find()->where(['idLanjutan'=>1])->count();
//                      $biodata = Tblprcobiodata::find()->where(['statLantikan'=>1])->all();
//               $l= TblLanjutan::find()->where(['icno'=>$icno])->max('idLanjutan');
//                          $elaun = $this->findElaun($id);
        $lanjut = new TblLanjutan();

        $l = $this->findLanjutan($icno);

//                 $i = $l->idLanjutan; 
//          $model = \app\models\cbelajar\TblBiasiswa::find()->where(['status_form' => 1])->all();
        if ($lanjut->load(Yii::$app->request->post())) {

//               $i=1;
            $lanjut->icno = $model->icno;
            $lanjut->HighestEduLevelCd = $model->HighestEduLevelCd;
            $lanjut->idLanjutan;
            $lanjut->tempoh;
            $lanjut->pID = $model->id;

            $lanjut->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Pengajian Berjaya Dikemaskini']);
            return $this->redirect(['search-pengajian']);
        }

        return $this->renderAjax('view_pengajian', [
                    'model' => $model,
                    'lanjut' => $lanjut,
//               'elaun' => $elaun,
//                'i'=>$i,
        ]);
    }

    public function actionView_1($id) {

        $i = Yii::$app->user->getId();
        $pengajian = $this->findPengajian4($id);

        $icno = $pengajian->icno;
        $h = $pengajian->HighestEduLevelCd;
//              var_dump($h);die;
        $status = $this->findStatus($icno);
        $biasiswa = $this->findSs($icno, $h);

        $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();

//              $p=$this->findP($id);
        $model = new \app\models\cbelajar\TblLapordiri();

//          $model = \app\models\cbelajar\TblBiasiswa::find()->where(['status_form' => 1])->all();
        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $pengajian->icno;
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->updated_by = $i;
            $model->HighestEduLevelCd = $pengajian->HighestEduLevelCd;


            if ($model->status_pengajian == "SELESAI") {
//                                  $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
                $perkhidmatan->ICNO = $model->icno;
                $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
                $perkhidmatan->ServStatusCd = 1;
                $perkhidmatan->ServStatusDtl = 1;
                $perkhidmatan->save(false);
                $pengajian->status = 2;
                $biasiswa->status = 2;
                $status->Status = 1;
                $status->save(false);
                $model->save(false);
                $pengajian->save(false);
                $biasiswa->save(false);
            } elseif ($model->status_pengajian == "BELUM SELESAI") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
                $perkhidmatan->ICNO = $model->icno;
                $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
                $perkhidmatan->ServStatusCd = 1;
                $perkhidmatan->ServStatusDtl = 1;
                $perkhidmatan->save(false);
                $pengajian->status = 4;
                $biasiswa->status = 4;
                $status->Status = 1;
                $biasiswa->save(false);
                $pengajian->save(false);

                $status->save(false);
            } elseif ($model->status_pengajian == "GAGAL PENGAJIAN") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
                $pengajian->status = 5;
                $biasiswa->status = 5;
                $status->save(false);
            } elseif ($model->status_pengajian == "GAGAL PENGAJIAN DAN MELETAK JAWATAN") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
                $perkhidmatan->ICNO = $model->icno;
                $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
                $perkhidmatan->ServStatusCd = 6;
                $perkhidmatan->ServStatusDtl = 15;
                $perkhidmatan->save(false);
                $pengajian->status = 6;
                $biasiswa->status = 6;
                $status->Status = 6;
                $status->save(false);
                $biasiswa->save(false);
                $pengajian->save(false);

                $status->save(false);
            } elseif ($model->status_pengajian == "GAGAL PENGAJIAN DAN DAN DIBERHENTIKAN") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
                $perkhidmatan->ICNO = $model->icno;
                $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
                $perkhidmatan->ServStatusCd = 6;
                $perkhidmatan->ServStatusDtl = 16;
                $perkhidmatan->save(false);
                $pengajian->status = 7;
                $biasiswa->status = 7;
                $status->Status = 6;
                $status->save(false);
                $biasiswa->save(false);
                $pengajian->save(false);

                $status->save(false);
            } elseif ($model->status_pengajian == "MIA") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
                $pengajian->status = 8;
                $biasiswa->status = 8;

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
            $pengajian->save(false);
            $biasiswa->save(false);
//            $status->save(false);
//            $st->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Lapor Diri Berjaya Disimpan']);
            return $this->redirect(['search-cb']);
//            $p->save(false);
        }


        return $this->renderAjax('lapordiri/view_1', [
                    'pengajian' => $pengajian,
                    'biasiswa' => $biasiswa,
//                'p' => $p,
                    'model' => $model,
//               'elaun' => $elaun,
                    'perkhidmatan' => $perkhidmatan,
        ]);
    }

    public function actionView_e($id) {

        $i = Yii::$app->user->getId();
        $pengajian = $this->findPengajian4($id);

        $icno = $pengajian->icno;
        $h = $pengajian->HighestEduLevelCd;
//              var_dump($h);die;
        $status = $this->findStatus($icno);
        $biasiswa = $this->findSs($icno, $h);

        $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();

//              $p=$this->findP($id);
        $model = new \app\models\cbelajar\TblLapordiri();

//          $model = \app\models\cbelajar\TblBiasiswa::find()->where(['status_form' => 1])->all();
        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $pengajian->icno;
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->updated_by = $i;
            $model->HighestEduLevelCd = $pengajian->HighestEduLevelCd;


            if ($model->status_pengajian == "SELESAI") {
//                                  $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
                $perkhidmatan->ICNO = $model->icno;
                $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
                $perkhidmatan->ServStatusCd = 1;
                $perkhidmatan->ServStatusDtl = 1;
                $perkhidmatan->save(false);
                $pengajian->status = 2;
                $biasiswa->status = 2;
                $status->Status = 1;
                $status->save(false);
                $model->save(false);
                $pengajian->save(false);
                $biasiswa->save(false);
            } elseif ($model->status_pengajian == "BELUM SELESAI") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
                $perkhidmatan->ICNO = $model->icno;
                $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
                $perkhidmatan->ServStatusCd = 1;
                $perkhidmatan->ServStatusDtl = 1;
                $perkhidmatan->save(false);
                $model->laporID = $pengajian->laporID;
                $pengajian->status = 4;
                $biasiswa->status = 4;
                $status->Status = 1;
                $model->save(false);
                $status->save(false);
                $biasiswa->save(false);
                $pengajian->save(false);

                $status->save(false);
            } elseif ($model->status_pengajian == 11) {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
                $perkhidmatan->ICNO = $model->icno;
                $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
                $perkhidmatan->ServStatusCd = 1;
                $perkhidmatan->ServStatusDtl = 1;
                $perkhidmatan->save(false);
                $model->laporID = $pengajian->laporID;
                $pengajian->status = 11;
                $biasiswa->status = 11;
                $status->Status = 1;
                $model->save(false);
                $status->save(false);
                $biasiswa->save(false);
                $pengajian->save(false);

                $status->save(false);
            } elseif ($model->status_pengajian == "GAGAL PENGAJIAN") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
                $pengajian->status = 5;
                $biasiswa->status = 5;
                $status->save(false);
            } elseif ($model->status_pengajian == "GAGAL PENGAJIAN DAN MELETAK JAWATAN") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
                $perkhidmatan->ICNO = $model->icno;
                $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
                $perkhidmatan->ServStatusCd = 6;
                $perkhidmatan->ServStatusDtl = 15;
                $perkhidmatan->save(false);
                $pengajian->status = 6;
                $biasiswa->status = 6;
                $status->Status = 6;
                $status->save(false);
                $biasiswa->save(false);
                $pengajian->save(false);

                $status->save(false);
            } elseif ($model->status_pengajian == "GAGAL PENGAJIAN DAN DAN DIBERHENTIKAN") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
                $perkhidmatan->ICNO = $model->icno;
                $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
                $perkhidmatan->ServStatusCd = 6;
                $perkhidmatan->ServStatusDtl = 16;
                $perkhidmatan->save(false);
                $pengajian->status = 7;
                $biasiswa->status = 7;
                $status->Status = 6;
                $status->save(false);
                $biasiswa->save(false);
                $pengajian->save(false);

                $status->save(false);
            } elseif ($model->status_pengajian == "MIA") {

//                                $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();
//                                  $perkhidmatan->ICNO = $model->icno;
//                                  $perkhidmatan->ServStatusStDt = $model->dt_lapordiri;
//                                  $perkhidmatan->ServStatusCd = 1;
//                                  $perkhidmatan->ServStatusDtl =1;
//                                  $perkhidmatan->save(false);
                $pengajian->status = 8;
                $biasiswa->status = 8;

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
            $pengajian->save(false);
            $biasiswa->save(false);
//            $status->save(false);
//            $st->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Lapor Diri Berjaya Disimpan']);
            return $this->redirect(['search-pengajian']);
//            $p->save(false);
        }


        return $this->renderAjax('lapordiri/view_1', [
                    'pengajian' => $pengajian,
                    'biasiswa' => $biasiswa,
//                'p' => $p,
                    'model' => $model,
//               'elaun' => $elaun,
                    'perkhidmatan' => $perkhidmatan,
        ]);
    }

    protected function findP($id) {
        if (($model = TblPengajian::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionV_rekod($id) {

        $i = Yii::$app->user->getId();
        $pengajian = $this->findPengajian2($id);
//              $userID = $pengajian->id;
//              $p = $this->findPengajian($userID);
//               $icno = $pengajian->icno;
//              $study = TblPengajian::find()->where(['icno' => $icno])->one();
        $model = $this->findLapordiri($id);
        if ($model->load(Yii::$app->request->post())) {

//               $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->updated_by = $i;
//               $model->HighestEduLevelCd = $study->HighestEduLevelCd;
//               $study->status=2;


            $model->save(false);
//            $study->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Lapor Diri Berjaya Dikemaskini']);
            return $this->redirect(['search-lapor']);
//            $p->save(false);
        }
        return $this->renderAjax('v_rekod', [
                    'pengajian' => $pengajian,
                    'model' => $model,
//                'study' =>$study,
//                'p'=>$p,
//               'elaun' => $elaun,
        ]);
    }

    public function actionV_rekodpjj($id) {

        $i = Yii::$app->user->getId();
        $pengajian = $this->findPengajian2($id);
//              $userID = $pengajian->id;
//              $p = $this->findPengajian($userID);
//               $icno = $pengajian->icno;
//              $study = TblPengajian::find()->where(['icno' => $icno])->one();
        $model = $this->findLapordiri($id);
        if ($model->load(Yii::$app->request->post())) {

//               $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->updated_by = $i;
//               $model->HighestEduLevelCd = $study->HighestEduLevelCd;
//               $study->status=2;


            $model->save(false);
//            $study->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Lapor Diri Berjaya Dikemaskini']);
            return $this->redirect(['senaraitindakanlapor']);
//            $p->save(false);
        }
        return $this->renderAjax('v_rekodpjj', [
                    'pengajian' => $pengajian,
                    'model' => $model,
//                'study' =>$study,
//                'p'=>$p,
//               'elaun' => $elaun,
        ]);
    }

    public function actionV_bon($id) {

        $bon = $this->findBon($id);
//                          $elaun = $this->findElaun($id);
//              $model = $this->findLapordiri($id);

        return $this->renderAjax('v_bon', [
                    'bon' => $bon,
//                'pengajian' => $pengajian,
//               'elaun' => $elaun,
        ]);
    }

    protected function findModel1($id) {

        if (($model = TblBiasiswa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel2($id) {

        if (($model = \app\models\cbelajar\TblLapordiri::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionView_nd($id) {



        $model = $this->findModel2($id);


        if ($model->load(Yii::$app->request->post())) {

            $model->tempoh;
            $model->nd_nominal;

            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Nominal Damages Dikemaskini']);
            return $this->redirect(['nominal-damages']);
        }

        return $this->renderAjax('bon/view_nd', [
                    'model' => $model,
        ]);
    }

    public function actionView_nds($id) {

        $i = Yii::$app->user->getId();
        $model = $this->findModel2($id);
        $nd = new \app\models\cbelajar\TblNd();
        if ($nd->load(Yii::$app->request->post())) {
            $nd->laporID = $id;
            $nd->icno = $model->icno;
            $nd->nd_nominal;
            $nd->update_by = $i;
            $nd->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Nominal Damages Dikemaskini']);
            return $this->redirect(['nominal', 'id' => $id]);
        }

        return $this->renderAjax('bon/view_nds', [
                    'model' => $model,
                    'nd' => $nd
        ]);
    }

    public function actionView_ppuu($id) {



        $model = $this->findModel2($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->catatan;
            $model->dt_ppuu;

            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'MAKLUMAT BERJAYA DIMAJUKAN KE PPUU']);
            return $this->redirect(['nominal-damages']);
        }

        return $this->renderAjax('bon/view_ppuu', [
                    'model' => $model,
        ]);
    }

    public function actionTindakan_tempah($id) {
        $model = $this->findModeltiket($id);
        $model->ver_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $request = Yii::$app->request;

        if ($model->load($request->post())) {
            $model->status_bsm = $request->post()['BorangPenerbangan']['status_bsm'];
            $model->no_peruntukan = $request->post()['BorangPenerbangan']['no_peruntukan'];
            $model->ver_by = $icno;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Keputusan berjaya dikemaskini']);

            return $this->redirect(['senaraitindakantuntutan']);
        }

        return $this->renderAjax('tindakan_tempah', [
                    'model' => $model,
        ]);
    }

    public function actionTindakan_bsmtiket($id) {

        $model = $this->findModeltiket($id);
        $model->ver_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $request = Yii::$app->request;
//                $tajaan = TblBiasiswa::findOne(['icno' => Yii::$app->user->getId()]);
        if ($model->status_bsm == 'Diluluskan' || $model->status_bsm == 'Tidak Diluluskan') {
            $displaylapor = '';
            $displaytempoh = 'none';
        } else {
            $displaytempoh = '';
            $displaylapor = 'none';
        }


        $message = '';
        if ($model->load($request->post())) {
            $model->status_bsm = $request->post()['BorangPenerbangan']['status_bsm'];
            $model->catatan = $request->post()['BorangPenerbangan']['catatan'];
            $model->ver_by = $icno;
            $model->save(false);
//               $message = 'Berjaya Disimpan';
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Keputusan berjaya dikemaskini']);

            return $this->redirect(['senaraitindakantuntutan']);
        }

        return $this->renderAjax('tindakan_bsmtiket', [
                    'model' => $model,
                    'today' => $today,
                    'message' => $message,
                    'displaytempoh' => $displaytempoh,
        ]);
    }

    public function actionTindakan_bsmhpg($id) {

        $model = $this->findModelhpg($id);
        $model->ver_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $request = Yii::$app->request;
//                $tajaan = TblBiasiswa::findOne(['icno' => Yii::$app->user->getId()]);
        if ($model->status_bsm == 'Diluluskan' || $model->status_bsm == 'Tidak Diluluskan') {
            $displaylapor = '';
            $displaytempoh = 'none';
        } else {
            $displaytempoh = '';
            $displaylapor = 'none';
        }


        $message = '';
        if ($model->load($request->post())) {
            $model->status_bsm = $request->post()['TblTuntut']['status_bsm'];
            $model->catatan = $request->post()['TblTuntut']['catatan'];
            $model->ver_by = $icno;
            $model->save(false);
            $message = 'Berjaya Disimpan';
        }

        return $this->renderAjax('tindakan_bsmhpg', [
                    'model' => $model,
                    'today' => $today,
                    'message' => $message,
                    'displaytempoh' => $displaytempoh,
        ]);
    }

    public function actionTindakanbsm_akhir($id) {
        $model = $this->findModelhpg($id);
        $model->ver_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $request = Yii::$app->request;

        if ($model->load($request->post())) {
            $model->status_bsm = $request->post()['TblTuntut']['status_bsm'];
            $model->catatan = $request->post()['TblTuntut']['catatan'];
            $model->ver_by = $icno;
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Keputusan berjaya dikemaskini']);

            return $this->redirect(['senarai-tuntut-hpg']);
        }

        return $this->renderAjax('tindakan_bsmhpg', [
                    'model' => $model,
        ]);
    }

    public function actionTindakan_bsmlkk($id) {

        $model = $this->findModellkk($id);
        $model->ver_date = date('Y-m-d H:i:s');
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $request = Yii::$app->request;
//                $tajaan = TblBiasiswa::findOne(['icno' => Yii::$app->user->getId()]);
        if ($model->status_bsm == 'Diluluskan' || $model->status_bsm == 'Tidak Diluluskan') {
            $displaylapor = '';
            $displaytempoh = 'none';
        } else {
            $displaytempoh = '';
            $displaylapor = 'none';
        }


        $message = '';
        if ($model->load($request->post())) {
            $model->iklan_id = $request->post()['TblLkk']['iklan_id'];
            $model->status_bsm = $request->post()['TblLkk']['status_bsm'];
            $model->catatan = $request->post()['TblLkk']['catatan'];
            $model->ver_by = $icno;
            $model->save(false);
            $message = 'Berjaya Disimpan';
        }

        return $this->renderAjax('tindakan_bsmlkk', [
                    'model' => $model,
                    'today' => $today,
                    'message' => $message,
                    'displaytempoh' => $displaytempoh,
        ]);
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
            $model->status_mesyuarat = $request->post()['TblLanjutan']['status_mesyuarat'];
            $model->catatan_bsm = $request->post()['TblLanjutan']['catatan_bsm'];
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

    public function GridPermohonanLainLulus() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblLain::find()->where(['status_mesyuarat' => ['Diluluskan']])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanLainTolak() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblLain::find()->where(['status_mesyuarat' => "Tidak Diluluskan"])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionSenaraitindakanlain() {
        $icno = Yii::$app->user->getId();
        $title = '';
        $models = \app\models\cbelajar\TblLain::find()->where(['status_borang' => "Selesai Permohonan", 'status' => ["DALAM TINDAKAN BSM", "DALAM TINDAKAN KETUA JABATAN"]])->all();
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke' => SORT_DESC])->limit(1)->one();
//        $surat = \app\models\cbelajar\TblSurat::find()->where(['icno' => $models->icno])->all();
        $senarai = '';
        $lulus = $this->GridPermohonanLainLulus();
        $tolak = $this->GridPermohonanLainTolak();
        $status = ['Tunggu Kelulusan', 'Diluluskan', 'Tidak Diluluskan'];
        $selection = (array) Yii::$app->request->post('selection'); //typecasting

        if (Yii::$app->request->post('simpan')) {

            foreach ($models as $data) {
                if ('y' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = $this->findModellain($data->id);
                    $model->status_bsm = 'Draft Diluluskan';
                    $model->save(false);
//                    return $this->redirect('index');
                } elseif ('n' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = $this->findModellain($data->id);
                    $model->status_bsm = 'Draft Ditolak';
                    $model->save(false);
                }
            }
        } elseif (Yii::$app->request->post('hantar')) {
            foreach ($selection as $id) {
                $hantar = $this->findModellain($id); //make a typecasting
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

            $senarai = \app\models\cbelajar\TblLain::find()->where([ 'status_borang' => "Selesai Permohonan", 'status' => ["DALAM TINDAKAN BSM", "DALAM TINDAKAN KETUA JABATAN"]])->orderBy(['tarikh_mohon' => SORT_DESC]);
            $title = 'Senarai Menunggu Semakan';
        }

//       elseif(Refpegawai::find()->where( ['pegawai_bsm' => $icno] )->exists()){
//            
//            $senarai = Tblyuran::find()->where(['in', 'status_kj', $status])->orderBy(['entry_date' => SORT_DESC]);
//            $title ='Senarai Menunggu Perakuan';
//            
//        }
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        if ($title != NULL) {
            return $this->render('senarai_tindakan_2', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
                        'tmp' => $tmp,
                        'lulus' => $lulus,
                        'tolak' => $tolak,
//            'surat'=>$surat,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['/cutibelajar/index']);
        }
    }

    public function actionHalamanUtamaPemohon() {

        $model = new TblPermohonan();
//        $model2 =         $model = $this->findBiodata2($id); 
        $icno = Yii::$app->user->getId();
        $model->icno = $icno;
        $status = TblPermohonan::findAll(['icno' => $icno, 'status_proses' => "Selesai Permohonan", 'status_study' => 0]); //senarai status permohonan
        $searchModel = new TblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $ver = TblPermohonan::findAll(['ver_by' => $icno]);

        // if($model->kakitangan->statLantikan== "1" && $model->confirmstatus->ConfirmStatusCd== "1" && $model->kakitangan->jawatan->job_category=="1")
        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "2")) { //jika user staf lantikan tetap & staf akademik
            return $this->render('main-pemohon', ['model' => $model, 'status' => $status,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'ver' => $ver,
                        'bil' => 1,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionCarianBorang() {
        $icno = Yii::$app->user->getId();
        $arrayicno = array();
        $cb = TblPermohonan::find()->where(['jenis_user_id' => '1'])->all();
        if (isset(Yii::$app->request->queryParams['jawatan'])) {
            foreach ($cb as $c) {
                if ($c->kakitangan) {
                    if (Yii::$app->request->queryParams['jawatan'] != '' && Yii::$app->request->queryParams['jfpiu'] != '') {
                        ($c->kakitangan->jawatan->id == Yii::$app->request->queryParams['jawatan'] &&
                                $c->kakitangan->department->id == Yii::$app->request->queryParams['jfpiu']) ? array_push($arrayicno, $c->icno) : '';
                    } elseif (Yii::$app->request->queryParams['jawatan'] != '') {
                        $c->kakitangan->jawatan->id == Yii::$app->request->queryParams['jawatan'] ? array_push($arrayicno, $c->icno) : '';
                    } elseif (Yii::$app->request->queryParams['jfpiu'] != '') {
                        $c->kakitangan->department->id == Yii::$app->request->queryParams['jfpiu'] ? array_push($arrayicno, $c->icno) : '';
                    }

//            elseif (Yii::$app->request->queryParams['HighestEduLevel'] != '') {
//                $c->kakitangan->pendidikan->HighestEduLevel == Yii::$app->request->queryParams['HighestEduLevel']? array_push($arrayicno, $c->icno):'';
//            }
//            
                }
            }
        }
        $query = empty($arrayicno) ? TblPermohonan::find()->where(['jenis_user_id' => 1]) : TblPermohonan::find()->where(['icno' => $arrayicno]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';

        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            return $this->render('senarai', [
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->redirect('index');
        }
    }

    public function actionTerimaTawaran() {
        $icno = Yii::$app->user->getId();
        $arrayicno = array();
        $cb = TblPermohonan::find()->where(['jenis_user_id' => '1'])->all();
        if (isset(Yii::$app->request->queryParams['jawatan'])) {
            foreach ($cb as $c) {
                if ($c->kakitangan) {
                    if (Yii::$app->request->queryParams['jawatan'] != '' && Yii::$app->request->queryParams['jfpiu'] != '') {
                        ($c->kakitangan->jawatan->id == Yii::$app->request->queryParams['jawatan'] &&
                                $c->kakitangan->department->id == Yii::$app->request->queryParams['jfpiu']) ? array_push($arrayicno, $c->icno) : '';
                    } elseif (Yii::$app->request->queryParams['jawatan'] != '') {
                        $c->kakitangan->jawatan->id == Yii::$app->request->queryParams['jawatan'] ? array_push($arrayicno, $c->icno) : '';
                    } elseif (Yii::$app->request->queryParams['jfpiu'] != '') {
                        $c->kakitangan->department->id == Yii::$app->request->queryParams['jfpiu'] ? array_push($arrayicno, $c->icno) : '';
                    }

//            elseif (Yii::$app->request->queryParams['HighestEduLevel'] != '') {
//                $c->kakitangan->pendidikan->HighestEduLevel == Yii::$app->request->queryParams['HighestEduLevel']? array_push($arrayicno, $c->icno):'';
//            }
                }
            }
        }
        $query = empty($arrayicno) ? TblPermohonan::find()->where(['jenis_user_id' => 1, 'status_proses' => "Terima Tawaran"]) : TblPermohonan::find()->where(['icno' => $arrayicno]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';

        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            return $this->render('senarai_terima', [
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->redirect('index');
        }
    }

//   public function GridBelum($my= NULL) {
//             $my =   date_format(date_create($my), 'Y-m');
//
//        $data = new ActiveDataProvider([
//            'query' => \app\models\cbelajar\TblLkk::find()->where([ 'agree'=>2,'status_form'=>1])->andWhere(['like', 'tarikh_hantar', date_format(date_create($my), 'yy-m')]),
//            'pagination' => [
//                'pageSize' => 10,
//            ],
//        ]);
//        return $data;
//    }
    public function GridBelum($my = NULL, $jfpiu = NULL) {

        $my = date_format(date_create($my), 'Y-m');
        $arrayicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=', 'Status', '6']) : '';

        $data = new ActiveDataProvider([
            'query' => empty($arrayicno) ? \app\models\cbelajar\TblLkk::find()
                            ->joinWith('kakitangan.department')
                            ->joinWith('kakitangan.jawatan')->where
                            (['agree' => 2, 'status_form' => 1, 'status_borang' => NULL])->andWhere(['job_category' => 1, 'tblprcobiodata.Status' => 2])->andWhere(['like', 'effectivedt', date_format(date_create($my), 'yy-m')])->orderBy(['effectivedt' => SORT_ASC]) : \app\models\cbelajar\TblLkk::find()->
                            where(['icno' => $arrayicno->select(['ICNO']), 'status_form' => "1"])->andWhere(['like', 'effectivedt', date_format(date_create($my), 'yy-m')]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $data;
    }

    public function actionLkkReport($my = NULL, $jfpiu = NULL, $tahun = null, $agree = NULL) {

        $icno = Yii::$app->user->getId();
        $arrayicno = $jfpiu ? TblPengajian::find()
                        ->joinWith('kakitangan')
                        ->where(['tblprcobiodata.DeptId' => $jfpiu])
                        ->andWhere(['!=', 'tblprcobiodata.Status', '6']) : '';
//        $arrayicno = $jfpiu ? Tblprcobiodata::daftfind()->where(['DeptId' => $jfpiu])
//         ->andWhere(['!=', 'Status', '6']) : '';
//        $category? $arrayicno->joinWith('jawatan')->andWhere(['gredjawatan.job_category' => $category]): $arrayicno;
        $belum = $this->GridBelum();
        $cb = \app\models\cbelajar\TblLkk::find()->where(['status_form' => "1"])->all();
//  if (!$tahun) {
//            $tahun = $year;
//        }
//            $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno'=> $arrayicno->icno, 'idBorang'=>1,'status'=>1])->one();
//                 var_dump( date_format(date_create($my), 'yy-m')); die;
        if (Yii::$app->request->queryParams) {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblLkk::find()
                            ->joinWith('kakitangan.department')
                            ->joinWith('pengajian2')
                            ->joinWith('kakitangan.jawatan')->where
                            (['status_form' => 1])->andWhere(['job_category' => 1, 'tblprcobiodata.Status' => [1, 2]])->andWhere(['cb_tbl_pengajian.status' => 1])->orderBy(['effectivedt' => SORT_ASC]) : \app\models\cbelajar\TblLkk::find()->
                            where(['icno' => $arrayicno->select(['cb_tbl_pengajian.icno']), 'status_form' => "1"])
            ;
        } else {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblLkk::find()->where(['status_form' => 0]) : \app\models\cbelajar\TblLkk::find()->where(['icno' => $arrayicno->select(['ICNO']), 'status_form' => "0"]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $tahun ? $dataProvider->query->andFilterWhere(['like', 'effectivedt', date_format(date_create($tahun), 'Y')]) : ' ';
        $agree ? $dataProvider->query->andFilterWhere(['agree' => $agree]) : '';
        $my ? $dataProvider->query->andFilterWhere(['like', 'effectivedt', date_format(date_create($my), 'Y-m')]) : ' ';
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'cb_tbl_lkk.icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['effectivedt']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'effectivedt', Yii::$app->request->queryParams['effectivedt']]) : '';
        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            return $this->render('lkk/senarai_lkk', [
                        'dataProvider' => $dataProvider,
                        'jfpiu' => $jfpiu,
                        'my' => $my,
                        'belum' => $belum, 'tahun' => $tahun, 'agree' => $agree
            ]);
        } else {
            return $this->redirect('index');
        }
    }

    public function actionBelumCapai() {

        $icno = Yii::$app->user->getId();

        $final = date('Y-m', strtotime('+6 months'));
        $current_date = date('Y-m');
//        $arrayicno = $jfpiu ? Tblprcobiodata::daftfind()->where(['DeptId' => $jfpiu])
//         ->andWhere(['!=', 'Status', '6']) : '';
//        $category? $arrayicno->joinWith('jawatan')->andWhere(['gredjawatan.job_category' => $category]): $arrayicno;
        $belum = $this->GridBelum();
        $cb = \app\models\cbelajar\TblLkk::find()->where(['status_form' => "1"])->all();
//  if (!$tahun) {
//            $tahun = $year;
//        }
//            $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno'=> $arrayicno->icno, 'idBorang'=>1,'status'=>1])->one();
//                 var_dump( date_format(date_create($my), 'yy-m')); die;

        $query = \app\models\cbelajar\TblLkk::find()->joinWith('kakitangan')
                ->where(['=', 'tblprcobiodata.Status', '2'])->andWhere(['agree' => 2])
                ->orderBy(['effectivedt' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $dataProvider->query->andFilterWhere(['<', 'effectivedt', date_format(date_create($final), 'Y-m')])
                ->andFilterWhere(['>=', 'effectivedt', date_format(date_create($current_date), 'Y-m')]);

        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'cb_tbl_lkk.icno', Yii::$app->request->queryParams['icno']]) : '';

        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            return $this->render('lkk/senarai_lkk_belum', [
                        'dataProvider' => $dataProvider,
                        'belum' => $belum,
            ]);
        } else {
            return $this->redirect('index');
        }
    }

    public function actionBelumMulaPengajian() {

        $icno = Yii::$app->user->getId();

        $pengajian = \app\models\cbelajar\TblPengajian::find()->where([ 'status' => 1])->one();

        $current_date = date('Y-m-d');

        $start_date = $pengajian->tarikh_mula;

//        $arrayicno = $jfpiu ? Tblprcobiodata::daftfind()->where(['DeptId' => $jfpiu])
//         ->andWhere(['!=', 'Status', '6']) : '';
//        $category? $arrayicno->joinWith('jawatan')->andWhere(['gredjawatan.job_category' => $category]): $arrayicno;
        $belum = $this->GridBelum();
        $cb = \app\models\cbelajar\TblLkk::find()->where(['status_form' => "1"])->all();
//  if (!$tahun) {
//            $tahun = $year;
//        }
//            $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno'=> $arrayicno->icno, 'idBorang'=>1,'status'=>1])->one();
//                 var_dump( date_format(date_create($my), 'yy-m')); die;

        $query = \app\models\cbelajar\TblPengajian::find()->joinWith('kakitangan')
                ->where(['=', 'tblprcobiodata.Status', '1'])->andWhere(['cb_tbl_pengajian.status' => 1])
                ->orderBy(['tarikh_mula' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $dataProvider->query->andFilterWhere(['>=', 'tarikh_mula', date_format(date_create($current_date), 'Y-m-d')]);

        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'cb_tbl_lkk.icno', Yii::$app->request->queryParams['icno']]) : '';

        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            return $this->render('lkk/senarai_lkk_belum_mula', [
                        'dataProvider' => $dataProvider,
                        'belum' => $belum,
            ]);
        } else {
            return $this->redirect('index');
        }
    }

    public function actionMulaPengajian() {

        $icno = Yii::$app->user->getId();

        $pengajian = \app\models\cbelajar\TblPengajian::find()->where([ 'status' => 1])->one();

        $current_date = date('Y-m-d');
        $pd = TblLkk::find()->select('icno')->distinct('icno')->where(['agree' => [2]])->asArray()->all();
        $icno_array = [];
        foreach ($pd as $pd) {

            array_push($icno_array, $pd['icno']);
        }
        $start_date = $pengajian->tarikh_mula;

//        $arrayicno = $jfpiu ? Tblprcobiodata::daftfind()->where(['DeptId' => $jfpiu])
//         ->andWhere(['!=', 'Status', '6']) : '';
//        $category? $arrayicno->joinWith('jawatan')->andWhere(['gredjawatan.job_category' => $category]): $arrayicno;
        $belum = $this->GridBelum();
        $cb = \app\models\cbelajar\TblLkk::find()->where(['status_form' => "1"])->all();
//  if (!$tahun) {
//            $tahun = $year;
//        }
//            $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno'=> $arrayicno->icno, 'idBorang'=>1,'status'=>1])->one();
//                 var_dump( date_format(date_create($my), 'yy-m')); die;

        $query = \app\models\cbelajar\TblPengajian::find()
                ->joinWith('kakitangan')
                ->joinWith('lkp')
//               ->where(['=', 'tblprcobiodata.Status', '1'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])
                ->andWhere(['cb_tbl_lkk.agree' => 2])
                ->andWhere(['cb_tbl_lkk.semester' => 1])
                ->andWhere(['cb_tbl_lkk.status_form' => 1])
                ->andWhere(['<=', 'tarikh_mula', date_format(date_create($current_date), 'Y-m-d')])
                ->orWhere(['>=', 'tarikh_mula', date_format(date_create($current_date), 'Y-m-d')])
                ->andWhere(['>=', 'cb_tbl_lkk.effectivedt', date_format(date_create($current_date), 'Y-m-d')
        ]);

//               ->orderBy(['tarikh_mula' => sort_De]);
//        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $dataProvider->query;

        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'cb_tbl_lkk.icno', Yii::$app->request->queryParams['icno']]) : '';

        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            return $this->render('lkk/senarai_lkk_belum_mula', [
                        'dataProvider' => $dataProvider,
                        'belum' => $belum,
            ]);
        } else {
            return $this->redirect('index');
        }
    }

    public function actionLkkReportTahun($my = NULL, $jfpiu = NULL, $tahun = NULL) {

        $icno = Yii::$app->user->getId();
        $arrayicno = $jfpiu ? TblPengajian::find()
                        ->joinWith('kakitangan')
                        ->where(['tblprcobiodata.DeptId' => $jfpiu])
                        ->andWhere(['!=', 'tblprcobiodata.Status', '6']) : '';
//        $arrayicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])
//         ->andWhere(['!=', 'Status', '6']) : '';
//        $category? $arrayicno->joinWith('jawatan')->andWhere(['gredjawatan.job_category' => $category]): $arrayicno;
        $belum = $this->GridBelum();
        $cb = \app\models\cbelajar\TblLkk::find()->where(['status_form' => "1"])->all();
//  if (!$tahun) {
//            $tahun = $year;
//        }
//            $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno'=> $arrayicno->icno, 'idBorang'=>1,'status'=>1])->one();
//                 var_dump( date_format(date_create($my), 'yy-m')); die;
        if (Yii::$app->request->queryParams) {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblLkk::find()
                            ->joinWith('kakitangan.department')
                            ->joinWith('pengajian2')
                            ->joinWith('kakitangan.jawatan')->where
                            (['status_form' => 1])->andWhere(['job_category' => 1, 'tblprcobiodata.Status' => [1, 2]])->andWhere(['cb_tbl_pengajian.status' => 1])->orderBy(['effectivedt' => SORT_ASC]) : \app\models\cbelajar\TblLkk::find()->
                            where(['icno' => $arrayicno->select(['cb_tbl_pengajian.icno']), 'status_form' => "1"])
            ;
        } else {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblLkk::find()->where(['status_form' => 0]) : \app\models\cbelajar\TblLkk::find()->where(['icno' => $arrayicno->select(['ICNO']), 'status_form' => "0"]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $tahun ? $dataProvider->query->andFilterWhere(['like', 'effectivedt', date_format(date_create($tahun), $tahun)]) : ' ';

        $my ? $dataProvider->query->andFilterWhere(['like', 'effectivedt', date_format(date_create($my), 'Y-m')]) : ' ';
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'cb_tbl_lkk.icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['effectivedt']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'effectivedt', Yii::$app->request->queryParams['effectivedt']]) : '';
        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            return $this->render('lkk/senarai_lkk_tahun', [
                        'dataProvider' => $dataProvider,
                        'jfpiu' => $jfpiu,
                        'my' => $my,
                        'belum' => $belum, 'tahun' => $tahun,
            ]);
        } else {
            return $this->redirect('index');
        }
    }

    public function actionLkkReportBelumSelesai($my = NULL, $jfpiu = NULL) {

        $icno = Yii::$app->user->getId();

        $arrayicno = $jfpiu ? TblPengajian::find()
                        ->joinWith('kakitangan')
                        ->where(['tblprcobiodata.DeptId' => $jfpiu])
                        ->andWhere(['!=', 'tblprcobiodata.Status', '6']) : '';
//        $arrayicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])
//         ->andWhere(['!=', 'Status', '6']) : '';
//        $category? $arrayicno->joinWith('jawatan')->andWhere(['gredjawatan.job_category' => $category]): $arrayicno;
        $belum = $this->GridBelum();
        $cb = \app\models\cbelajar\TblLkk::find()->where(['status_form' => "1"])->all();

//            $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno'=> $arrayicno->icno, 'idBorang'=>1,'status'=>1])->one();
//                 var_dump( date_format(date_create($my), 'yy-m')); die;
        if (Yii::$app->request->queryParams) {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblLkk::find()
                            ->joinWith('kakitangan.department')
                            ->joinWith('pengajian2')
                            ->joinWith('kakitangan.jawatan')->where
                            (['status_form' => 1])->andWhere(['job_category' => 1,
                        'tblprcobiodata.Status' => [1, 2]])->andWhere(['cb_tbl_pengajian.status' => [4, 6]])->orderBy(['effectivedt' => SORT_ASC]) : \app\models\cbelajar\TblLkk::find()->
                            where(['icno' => $arrayicno->select(['cb_tbl_pengajian.icno']), 'status_form' => "1"])
            ;
        } else {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblLkk::find()->where(['status_form' => 0]) : \app\models\cbelajar\TblLkk::find()->where(['icno' => $arrayicno->select(['ICNO']), 'status_form' => "0"]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        $my ? $dataProvider->query->andFilterWhere(['like', 'effectivedt', date_format(date_create($my), 'Y-m')]) : ' ';
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'cb_tbl_lkk.icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['effectivedt']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'effectivedt', Yii::$app->request->queryParams['effectivedt']]) : '';
        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            return $this->render('lkk/senarai_lkk_bs', [
                        'dataProvider' => $dataProvider,
                        'jfpiu' => $jfpiu,
                        'my' => $my,
                        'belum' => $belum
            ]);
        } else {
            return $this->redirect('index');
        }
    }

    public function actionLkpReportFakulti($my = NULL, $jfpiu = NULL) {

        $icno = Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

        $arrayicno = $jfpiu ? TblPengajian::find()
                        ->joinWith('kakitangan')
                        ->where(['tblprcobiodata.DeptId' => $jfpiu])
                        ->andWhere(['!=', 'tblprcobiodata.Status', '6']) : '';
//        $arrayicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])
//         ->andWhere(['!=', 'Status', '6']) : '';
//        $category? $arrayicno->joinWith('jawatan')->andWhere(['gredjawatan.job_category' => $category]): $arrayicno;
        $belum = $this->GridBelum();
        $cb = \app\models\cbelajar\TblLkk::find()->where(['status_form' => "1"])->all();

//            $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno'=> $arrayicno->icno, 'idBorang'=>1,'status'=>1])->one();
//                 var_dump( date_format(date_create($my), 'yy-m')); die;
        if (Yii::$app->request->queryParams) {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblLkk::find()
                            ->joinWith('kakitangan.department')
                            ->joinWith('pengajian2')
                            ->joinWith('kakitangan.jawatan')
                            ->where(['chief' => $icno])
                            ->orWhere(['department.pp' => $icno])
                            ->orWhere(['tblprcobiodata.DeptID' => $test->DeptId])
                            ->andWhere(['status_form' => 1])
                            ->andWhere(['job_category' => 1, 'tblprcobiodata.Status' => [1, 2]])
                            ->andWhere(['cb_tbl_pengajian.status' => 1])
                            ->orderBy(['effectivedt' => SORT_ASC]) : \app\models\cbelajar\TblLkk::find()->
                            where(['icno' => $arrayicno->select(['cb_tbl_pengajian.icno']), 'status_form' => "1"])
            ;
        } else {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblLkk::find()->where(['status_form' => 0]) : \app\models\cbelajar\TblLkk::find()->where(['icno' => $arrayicno->select(['ICNO']), 'status_form' => "0"]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        $my ? $dataProvider->query->andFilterWhere(['like', 'effectivedt', date_format(date_create($my), 'Y-m')]) : ' ';
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'cb_tbl_lkk.icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['effectivedt']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'effectivedt', Yii::$app->request->queryParams['effectivedt']]) : '';
        if (Department::find()->where([ 'pp' => Yii::$app->user->getId(), 'isActive' => 1])->exists() ||
                AksesPa::find()->where([ 'icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('lkk/senarai_lkk_pp', [
                        'dataProvider' => $dataProvider,
                        'jfpiu' => $jfpiu,
                        'my' => $my,
                        'belum' => $belum
            ]);
        } elseif (Department::find()->where([ 'chief' => Yii::$app->user->getId(), 'isActive' => 1])->exists()
        ) {

            return $this->render('lkk/senarai_lkk_jfpiu', [
                        'dataProvider' => $dataProvider,
                        'jfpiu' => $jfpiu,
                        'my' => $my,
                        'belum' => $belum
            ]);
        } else {
            return $this->redirect('index');
        }
    }

    public function actionLkkReportFakulti($my = NULL, $jfpiu = NULL) {
        $userID = Yii::$app->user->getId();

        $icno = Yii::$app->user->getId();
        $arrayicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=', 'Status', '6']) : '';
//        $category? $arrayicno->joinWith('jawatan')->andWhere(['gredjawatan.job_category' => $category]): $arrayicno;

        $cb = \app\models\cbelajar\TblLkk::find()->where(['status_form' => "1"])->all();

//            $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno'=> $arrayicno->icno, 'idBorang'=>1,'status'=>1])->one();
//                 var_dump( date_format(date_create($my), 'yy-m')); die;
        if (Yii::$app->request->queryParams) {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblLkk::find()
                            ->joinWith('kakitangan.department')
                            ->joinWith('kakitangan.jawatan')->where
                            (['status_form' => 1])->andWhere(['job_category' => 1,
                        'tblprcobiodata.Status' => 2])->orderBy(['effectivedt' => SORT_ASC]) : \app\models\cbelajar\TblLkk::find()->
                            where(['icno' => $arrayicno->select(['ICNO']), 'status_form' => "1"])
            ;
        } else {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblLkk::find()->where(['status_form' => 0]) : \app\models\cbelajar\TblLkk::find()->where(['icno' => $arrayicno->select(['ICNO']), 'status_form' => "0"]);
        }

        $staff = empty($arrayicno) ? \app\models\cbelajar\TblLkk::find()
                        ->joinWith('kakitangan.department')
                        ->joinWith('kakitangan.jawatan')
                        ->where(['chief' => $userID])
                        ->orWhere(['department.pp' => $userID])
                        ->andWhere(['status_form' => 1])
                        ->andWhere(['job_category' => 1, 'tblprcobiodata.Status' => 2])
                        ->orderBy(['tblprcobiodata.CONm' => SORT_ASC]) :
                \app\models\cbelajar\TblLkk::find()->where
                        (['icno' => $arrayicno->select(['ICNO']), 'status_form' => "1"]);



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $dataProvider2 = new ActiveDataProvider([
            'query' => $staff,
            'pagination' => [

                'pageSize' => 10,
            ],
        ]);



        $my ? $dataProvider->query->andFilterWhere(['like', 'effectivedt', date_format(date_create($my), 'Y-m')]) : ' ';
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'cb_tbl_lkk.icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['effectivedt']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'effectivedt', Yii::$app->request->queryParams['effectivedt']]) : '';
        return $this->render('/lkk/senarai_lkk_jfpiu', [
                    'dataProvider' => $dataProvider,
                    'jfpiu' => $jfpiu,
                    'my' => $my,
                    'staff' => $staff,
                    'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionSenaraiLkk($my = NULL, $jfpiu = NULL, $id = NULL) {
        if ($id == NULL) {
            $icno = Yii::$app->user->getId();
        }
        $arrayicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=', 'Status', '6']) : '';

        $cb = \app\models\cbelajar\TblLkk::find()->where(['status_form' => "1"])->all();


//                 var_dump( date_format(date_create($my), 'yy-m')); die;
        if (Yii::$app->request->queryParams) {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblPengajian::find()->where(['status' => 1]) : \app\models\cbelajar\TblLkk::find()->where(['icno' => $arrayicno->select(['ICNO']), 'status_form' => "1"])
            ;
        } else {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblPengajian::find()->where(['status' => 10]) : \app\models\cbelajar\TblLkk::find()->where(['icno' => $arrayicno->select(['ICNO']), 'status_form' => "0"]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        $my ? $dataProvider->query->andFilterWhere(['like', 'effectivedt', date_format(date_create($my), 'Y-m')]) : ' ';
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';
//         isset(Yii::$app->request->queryParams['effectivedt'])? $dataProvider->query->andFilterWhere(
//        ['like', 'effectivedt',  Yii::$app->request->queryParams['effectivedt'] ]):'';
        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            return $this->render('lkk/senarai-lkk', [
                        'dataProvider' => $dataProvider,
                        'jfpiu' => $jfpiu,
            ]);
        } else {
            return $this->redirect('index');
        }
    }

    public function actionKemaskiniLanjutan($id) {
        $i = Yii::$app->user->getId();
        $model = \app\models\cbelajar\TblLanjutan::find()->where(['id' => $id])->one();
//        $icno = $model->icno;
        $b = $this->findPengajian2($id);
        $pengajian = $this->findPengajian($id);

        //        $p = $b->id;
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->updated_by = $i;
//              $model->pID= $pengajian->id;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Berjaya Dikemaskini']);

            return $this->redirect(['cutibelajar/halaman-pemohon']);
        }

        return $this->renderAjax('biasiswa/update-lanjutan', [
                    'model' => $model,
//            'data'=> $data,
//            'lapor' =>$lapor,
                    'b' => $b,
//            'allbiodata' => $allbiodata,
        ]);
    }

    public function actionNyahaktifLkk($id) {
        $iklan = $this->findLkk($id);

        if ($iklan->load(Yii::$app->request->post())) {
            $iklan->status_for = 0;
            $iklan->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Borang  Berjaya Di Nyahaktifkan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect('halaman-admin');
        }
        return $this->renderAjax('aktif-lkk', ['iklan' => $iklan]);
    }

    public function actionNominalDamages($my = NULL, $jfpiu = NULL, $jawatan = null, $tempoh = NULL, $khidmat = NULL) {
        $icno = Yii::$app->user->getId();
        // $arrayicno = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=','Status', '6']): '';
//         $arrayi = $tempoh? \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $tempoh]): '';
//         $status = new Tblprcobiodata();

        $cb = \app\models\cbelajar\TblLapordiri::find()->all();
//        $lapor = \app\models\cbelajar\TblLapordiri::find()->where(['icno'=>$cb->icno, ''])
//        $arrayicno = $status_pengajian? $arrayicno->joinWith('tbllapordiri')->where(['tbllapordiri.status_pengajian' => $status_pengajian]): $arrayicno;
        $listicno = $jawatan ? Tblprcobiodata::find()->andWhere(['gredJawatan' => $jawatan]) : Tblprcobiodata::find()->andWhere(['Status' => [1, 2, 6]]);
        $jfpiu ? $listicno->andWhere(['DeptId' => $jfpiu]) : '';
        $khidmat ? $listicno->andWhere(['Status' => $khidmat]) : '';

        $query = empty($listicno) ? \app\models\cbelajar\TblLapordiri::find()->where(['status_pengajian' => ["BELUM SELESAI", "GAGAL PENGAJIAN", "GAGAL PENGAJIAN DAN DIBERHENTIKAN", "GAGAL PENGAJIAN DAN MELETAK JAWATAN", 2, 3, 4, 5, 6, 7]]) : \app\models\cbelajar\TblLapordiri::find()->where(['icno' => $listicno->select(['ICNO']), 'status_pengajian' => ["BELUM SELESAI", "GAGAL PENGAJIAN", "GAGAL PENGAJIAN DAN DIBERHENTIKAN", "GAGAL PENGAJIAN DAN MELETAK JAWATAN", 2, 3, 5, 4, 6, 7]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'pagination' => [
//            'pageSize' => 10,
//            ],
        ]);
//        $dataProvider->query->andFilterWhere(['status'=>1]);

        $my ? $dataProvider->query->andFilterWhere(['like', 'dt_lapordiri', date_format(date_create($my), 'Y-m')]) : ' ';
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';

        isset(Yii::$app->request->queryParams['HighestEduLevelCd']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'HighestEduLevelCd', Yii::$app->request->queryParams['HighestEduLevelCd']]) : '';

        isset(Yii::$app->request->queryParams['status_pengajian']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'status_pengajian', Yii::$app->request->queryParams['status_pengajian']]) : '';
        isset(Yii::$app->request->queryParams['tempoh']) ? $dataProvider->query->andFilterWhere(
                                ['like', 'tempoh', Yii::$app->request->queryParams['tempoh']]) : '';

//    if(TblAdmin::find()->where(['icno' => $icno])->exists()){
        return $this->render('bon/senarai_nd', [
                    'dataProvider' => $dataProvider,
                    'jfpiu' => $jfpiu,
                    'tempoh' => $tempoh,
                    'my' => $my, 'khidmat' => $khidmat,
        ]);
//       else{
//        return $this->redirect('index');}
    }

    public function actionListBiasiswa($my = NULL, $jfpiu = NULL) {
        $icno = Yii::$app->user->getId();
        $arrayicno = $jfpiu ? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=', 'Status', '6']) : '';

        $cb = \app\models\cbelajar\TblBiasiswa::find()->where(['status_form' => "1"])->all();
        ;


        if (Yii::$app->request->queryParams) {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblBiasiswa::find()->where(['status_form' => 1]) : \app\models\cbelajar\TblBiasiswa::find()->where(['icno' => $arrayicno->select(['ICNO']), 'status_form' => "1"]);
        } else {
            $query = empty($arrayicno) ? \app\models\cbelajar\TblBiasiswa::find()->where(['status_form' => 0]) : \app\models\cbelajar\TblBiasiswa::find()->where(['icno' => $arrayicno->select(['ICNO']), 'status_form' => "1"]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        $my ? $dataProvider->query->andFilterWhere(['like', 'effectivedt', date_format(date_create($my), 'Y-m')]) : ' ';
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';

        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            return $this->render('senarai_biasiswa', [
                        'dataProvider' => $dataProvider,
                        'jfpiu' => $jfpiu,
            ]);
        } else {
            return $this->redirect('index');
        }
    }

    public function actionReport() {

        $status = isset(Yii::$app->request->queryParams['status']) ? Yii::$app->request->queryParams['status'] : '';
        if ($status != '') {
            $model = TblPermohonan::find()->where(['jenis_user_id' => '1', 'status_bsm' => $status])->all();
        } else {
            $model = TblPermohonan::find()->where(['jenis_user_id' => '1'])->all();
        }
        return $this->render('_report', ['model' => $model]
        );
    }

    public function actionLaporanSabatikal() {
        $icno = Yii::$app->user->getId();
        $arrayicno = array();
        $cb = TblPermohonan::find()->where(['jenis_user_id' => '1', 'idBorang' => 2])->all();
        if (isset(Yii::$app->request->queryParams['jawatan'])) {
            foreach ($cb as $c) {

                if (Yii::$app->request->queryParams['jawatan'] != '' && Yii::$app->request->queryParams['jfpiu'] != '') {
                    ($c->kakitangan->jawatan->id == Yii::$app->request->queryParams['jawatan'] &&
                            $c->kakitangan->department->id == Yii::$app->request->queryParams['jfpiu']) ? array_push($arrayicno, $c->icno) : '';
                } elseif (Yii::$app->request->queryParams['jawatan'] != '') {
                    $c->kakitangan->jawatan->id == Yii::$app->request->queryParams['jawatan'] ? array_push($arrayicno, $c->icno) : '';
                } elseif (Yii::$app->request->queryParams['jfpiu'] != '') {
                    $c->kakitangan->department->id == Yii::$app->request->queryParams['jfpiu'] ? array_push($arrayicno, $c->icno) : '';
                }
            }
        }

        $query = empty($arrayicno) ? TblPermohonan::find()->where(['jenis_user_id' => 1, 'idBorang' => 2]) : TblPermohonan::find()->where(['icno' => $arrayicno]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        isset(Yii::$app->request->queryParams['icno']) ? $dataProvider->query->andFilterWhere(['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';

        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            return $this->render('senarai_sabatikal', [
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->redirect('index');
        }
    }

    public function actionSenaraiBorang($id) {
        $model = new TblPermohonan();
        $icno = Yii::$app->user->getId();
        $senarai_dokumen = $this->findBorang(1);

        $status = TblPermohonan::findAll(['icno' => $icno, 'status_proses' => "Selesai Permohonan", 'idBorang' => 1]); //senarai status permohonan
        $searchModel = new TblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $ver = TblPermohonan::findAll(['ver_by' => $icno]);
        $iklan = $this->findIklanbyID($id);
        $model2 = TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 2])->one() ? TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 2])->one() : new TblPermohonan();
        $model3 = TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() ? TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 2])->one() : new TblPermohonan();
        $option = Option::find()->where(["in", "name", ["date_open", "date_close"]])->all();

        #convert object to array
        $dateRange = ArrayHelper::map($option, 'name', 'value');

        $today = date('Y-m-d', strtotime(date('Y-m-d')));
        $start = date('Y-m-d', strtotime($dateRange['date_open']));
        $end = date('Y-m-d', strtotime($dateRange['date_close']));

        $open = "false";
        #checking date between start and end
        if (($today >= $start) && ($today <= $end)) {
            $open = "true";
        }

        $options = ["open" => $open, "date" => $dateRange];
        return $this->render('senarai_borang', [
                    'senarai_dokumen' => $senarai_dokumen,
                    'iklan' => $iklan, 'status' => $status,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'ver' => $ver,
                    'model' => $model,
                    'options' => $options,
                    'model2' => $model2,
                    'model3' => $model3,
        ]);
    }

    protected function dynamicform($modelsAddress, $modelCustomer) {

        $oldIDs = ArrayHelper::map($modelsAddress, 'id', 'id');
        $modelsAddress = Model::createMultiple(TblBiasiswa::classname(), $modelsAddress);
        Model::loadMultiple($modelsAddress, Yii::$app->request->post());
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsAddress, 'id', 'id')));
        $valid = $modelCustomer->validate();
        $valid = Model::validateMultiple($modelsAddress) && $valid;
        if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($flag = $modelCustomer->save(false)) {
                    if (!empty($deletedIDs)) {
                        TblBiasiswa::deleteAll(['id' => $deletedIDs]);
                    }
                    foreach ($modelsAddress as $i => $modelAddress) {
                        //$modelAddress->customer_id = $modelCustomer->id;
                        $modelAddress->parent_id = $modelCustomer->id;
                        $modelAddress->icno = $modelCustomer->icno;

                        if (!($flag = $modelAddress->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                }
                if ($flag) {
                    $transaction->commit();
//                        return $this->redirect(['senaraipermohonan?user='.$jfpiu]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
    }

    public function actionBorang($id) {

        $icno = Yii::$app->user->getId();
        $iklan = $this->findIklanbyID($id);
        $model = new TblPermohonan();
        $pengajian = new TblPengajian();
        $model->icno = $icno;
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $model->tarikh_m = date('Y-m-d H:i:s');
        $file = UploadedFile::getInstance($model, 'file');
        $modelCustomer = new TblPermohonan();
        $modelCustomer->icno = $icno;
        $modelCustomer->status_proses = "Selesai Permohonan";
        $modelCustomer->status_bsm = "Tunggu Kelulusan";
        $modelCustomer->tarikh_m = date('Y-m-d H:i:s');
        $modelsAddress = [new TblBiasiswa()];


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


        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lapordiri');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = '';
        }


        if ($modelCustomer->load(Yii::$app->request->post())) {

            if ($modelCustomer->agree == 0) {
                Yii::$app->session->setFlash('alert', ['title' => 'Amaran !', 'type' => 'error', 'msg' => 'Sila tanda kotak semak permohonan.']);
                return $this->redirect(['borang', 'id' => $id]);
            } else {


                $modelCustomer->icno;
                $modelCustomer->iklan_id = $iklan->id;

                $modelCustomer->dokumen = $filepath;

                $modelCustomer->status_proses = "Selesai Permohonan ";
                $modelCustomer->save(false);

                $this->dynamicform($modelsAddress, $modelCustomer);
                $this->notifikasi($icnopetindak1, "Permohonan Lapor Diri Tamat Tempoh Pengajian Lanjutan menunggu tindakan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/menunggu'], ['class' => 'btn btn-primary btn-sm']));
                $this->notifikasi($modelCustomer->icno, "Permohonan Lapor Diri Tamat Tempoh Pengajian Lanjutan  anda telah dihantar untuk tindakan " . $petindak1 . " " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
                return $this->redirect(['lihat-permohonan', 'id' => $modelCustomer->id]); //
            }
        }

        return $this->render('_borang', [

                    'model' => $model,
                    'iklan' => $iklan,
                    'akademik' => $this->findAkademikbyICNO(),
                    'keluarga' => $this->findKeluargabyICNO(),
                    'pengajian' => $pengajian,
                    'modelCustomer' => $modelCustomer,
                    'modelsAddress' => (empty($modelsAddress)) ? [new TblBiasiswa] : $modelsAddress,
        ]);
    }

    protected function findAkademikbyICNO() {
        if (($model = Tblpendidikan::findAll(['ICNO' => $this->ICNO()])) !== null) {
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

    public function findBorang($status) {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => $status, 'borang' => 5]),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }

    public function actionGambar($id) {

        $check = TblpImage::findOne(['ICNO' => $this->ICNO(), 'iklan_id' => $id]);
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


            $model->filename = UploadedFile::getInstances($model, 'image');

            foreach ($model->filename as $saving) {
                echo "b";
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
                return $this->redirect(['gambar', 'id' => $iklan->id]);
            }



            return $this->render('permohonan/form_gambar', [
                        'model' => $model,
                        'iklan' => $iklan,
            ]);
        }
    }

    public function GridMaklum() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblLapordiri::find()->where(['status' => ['LULUS']])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $data;
    }

    public function GridBelumSah() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblLapordiri::find()->where(['status_borang' => ['Selesai Permohonan'], 'agree' => NULL])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $data;
    }

    public function actionSenaraitindakanlapor() {
        $icno = Yii::$app->user->getId();
        $title = '';
        $models = \app\models\cbelajar\TblLapordiri::find()->where(['status_borang' => "Selesai Permohonan", 'agree' => 1])->all();
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke' => SORT_DESC])->limit(1)->one();
        $senarai = '';
        $terima = $this->GridMaklum();
        $belum = $this->GridBelumSah();
        $status = ['Tunggu Kelulusan', 'Tunggu Kelulusan BSM', 'Diluluskan', 'Tidak Diluluskan'];
        $selection = (array) Yii::$app->request->post('selection'); //typecasting

        if (Yii::$app->request->post('simpan')) {

            foreach ($models as $data) {
                if ('y' . $data->laporID == Yii::$app->request->post($data->laporID)) {
                    $model = $this->findModellapor($data->laporID);
                    $model->status_bsm = 'Draft Diluluskan';
                    $model->save(false);
//                    return $this->redirect('index');
                } elseif ('n' . $data->laporID == Yii::$app->request->post($data->laporID)) {
                    $model = $this->findModellapor($data->id);
                    $model->status_bsm = 'Draft Ditolak';
                    $model->save(false);
                }
            }
        } elseif (Yii::$app->request->post('hantar')) {
            foreach ($selection as $id) {
                $hantar = $this->findModellapor($id); //make a typecasting
                if ('n' . $hantar->laporID == Yii::$app->request->post($hantar->laporID)) {
                    $hantar->status = 'TIDAK LULUS';
                    $hantar->status_bsm = 'Tidak Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');

                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan - Lapor Diri anda tidak berjaya." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                } elseif ('y' . $hantar->laporID == Yii::$app->request->post($hantar->laporID)) {
                    $hantar->status = 'LULUS';
                    $hantar->status_bsm = 'Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');
                    $hantar->ver_by = $icno;
                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan -Borang lapor diri anda diterima." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                }
                $hantar->save(false);
            }
        }
        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            $senarai = \app\models\cbelajar\TblLapordiri::find()->where([
                        'status_borang' => "Selesai Permohonan", 'status' => ['DALAM TINDAKAN KETUA JABATAN', 'DALAM TINDAKAN BSM'], 'agree' => 1])->orderBy(['tarikh_mohon' => SORT_DESC]);
            $title = 'Senarai Menunggu Semakan';
        }

//       elseif(Refpegawai::find()->where( ['pegawai_bsm' => $icno] )->exists()){
//            
//            $senarai = Tblyuran::find()->where(['in', 'status_kj', $status])->orderBy(['entry_date' => SORT_DESC]);
//            $title ='Senarai Menunggu Perakuan';
//            
//        }
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        if ($title != NULL) {
            return $this->render('senarai_tindakan_5', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
                        'tmp' => $tmp, 'terima' => $terima, 'belum' => $belum
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['/cutibelajar/index']);
        }
    }

    public function GridPermohonanKapal() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\BorangPenerbangan::find()->where(['status_bsm' => [ "Draft Diluluskan", "Tunggu Kelulusan", "Layak Dipertimbangkan", "Telah Diluluskan"]])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridKj() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\BorangPenerbangan::find()->where(['status' => ["DALAM TINDAKAN KETUA JABATAN"]])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanKapalLulus() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\BorangPenerbangan::find()->where(['status_a' => ["DITEMPAH"]])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTuntutanKapalLulus() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\BorangPenerbangan::find()->where(['status_bsm' => ["Diluluskan"], 'idBorang' => "TUNT"])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridBorangBatal() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\BorangPenerbangan::find()->where(['status_bsm' => ["BATAL", "Tidak Layak Dipertimbangkan"]])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionSenaraitindakantuntutan() {
        $icno = Yii::$app->user->getId();
        $title = '';
        $models = \app\models\cbelajar\BorangPenerbangan::find()->where(['status_borang' => "Selesai Permohonan"])->all();
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke' => SORT_DESC])->limit(1)->one();
        $senarai = '';
        $status = ['Tunggu Kelulusan', 'Diluluskan', 'Tidak Diluluskan'];
        $baharu = $this->GridPermohonanKapal();
        $lulus = $this->GridPermohonanKapalLulus();
        $lulust = $this->GridTuntutanKapalLulus();
        $batal = $this->GridBorangBatal();
        $kjj = $this->GridKj();
        $selection = (array) Yii::$app->request->post('selection'); //typecasting

        if (Yii::$app->request->post('simpan')) {

            foreach ($models as $data) {
                if ('y' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = $this->findModeltiket($data->id);
                    $model->status_bsm = 'Draft Diluluskan';
                    $model->save(false);
//                    return $this->redirect('index');
                } elseif ('n' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = $this->findModeltiket($data->id);
                    $model->status_bsm = 'Draft Ditolak';
                    $model->save(false);
                }
            }
        } elseif (Yii::$app->request->post('hantar')) {
            foreach ($selection as $id) {
                $hantar = $this->findModeltiket($id); //make a typecasting
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
            $senarai = \app\models\cbelajar\BorangPenerbangan::find()->where([ 'status_borang' => "Selesai Permohonan"])->orderBy(['tarikh_mohon' => SORT_DESC]);
            $title = 'Senarai Menunggu Semakan';
        }

//       elseif(Refpegawai::find()->where( ['pegawai_bsm' => $icno] )->exists()){
//            
//            $senarai = Tblyuran::find()->where(['in', 'status_kj', $status])->orderBy(['entry_date' => SORT_DESC]);
//            $title ='Senarai Menunggu Perakuan';
//            
//        }
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);


        if ($title != NULL) {
            return $this->render('senarai_tindakan_tuntutan', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
                        'tmp' => $tmp,
                        'baharu' => $baharu,
                        'lulus' => $lulus,
                        'lulust' => $lulust,
                        'batal' => $batal,
                        'kjj' => $kjj
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['/cutibelajar/index']);
        }
    }

    public function GridTuntut() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => ["Draft Diluluskan", "Tunggu Kelulusan"], 'j_tuntutan' => "HPG"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTuntutLulusHpg() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => "Diluluskan", 'j_tuntutan' => "HPG"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTuntutTesis() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => ["Draft Diluluskan", "Tunggu Kelulusan"], 'j_tuntutan' => "TESIS"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTuntutYuran() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => ["Draft Diluluskan", "Tunggu Kelulusan"], 'j_tuntutan' => "YURAN"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTuntutIelts() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => ["Draft Diluluskan", "Tunggu Kelulusan"], 'j_tuntutan' => "IELTS"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTuntutVisa() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => ["Draft Diluluskan", "Tunggu Kelulusan"], 'j_tuntutan' => ["VISA", "INSURANS"]])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTuntutLulusTesis() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => "Diluluskan", 'j_tuntutan' => "TESIS"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTuntutAkhir() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => ["Draft Diluluskan", "Tunggu Kelulusan"], 'j_tuntutan' => "AKHIR"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTuntutLulusAkhir() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => "Diluluskan", 'j_tuntutan' => "AKHIR"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTuntutLulusYuran() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => "Diluluskan", 'j_tuntutan' => "YURAN"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTuntutLulusIelts() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => "Diluluskan", 'j_tuntutan' => "IELTS"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTuntutLulusVisa() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => "Diluluskan", 'j_tuntutan' => ["VISA", "INSURANS"]])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTolakAkhir() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => "Tidak Diluluskan", 'j_tuntutan' => "AKHIR"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTolakYuran() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => "Tidak Diluluskan", 'j_tuntutan' => "YURAN"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTolakIelts() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => "Tidak Diluluskan", 'j_tuntutan' => "IELTS"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTolakVisa() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => "Tidak Diluluskan", 'j_tuntutan' => ["VISA", "INSURANS"]])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridTolakTesis() {
        $data = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblTuntut::find()->where(['status_bsm' => "Tidak Diluluskan", 'j_tuntutan' => "TESIS"])->orderBy(['tarikh_m' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionSenaraiTuntutHpg() {
        $icno = Yii::$app->user->getId();
        $title = '';
        $models = \app\models\cbelajar\TblTuntut::find()->where(['status_borang' => "Selesai Permohonan", 'j_tuntutan' => "HPG"])->all();
//        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke'=>SORT_DESC])->limit(1)->one();
        $senarai = '';
        $status = ['Tunggu Kelulusan', 'Diluluskan', 'Tidak Diluluskan'];
        $semak = $this->GridTuntut();
        $semaky = $this->GridTuntutYuran();
        $semaks = $this->GridTuntutIelts();
        $semakv = $this->GridTuntutVisa();
        $lulush = $this->GridTuntutLulusHpg();
        $semakt = $this->GridTuntutTesis();
        $lulust = $this->GridTuntutLulusTesis();
        $lulusp = $this->GridTuntutLulusAkhir();
        $semakp = $this->GridTuntutAkhir();
        $tolakp = $this->GridTolakAkhir();
        $tolakw = $this->GridTolakTesis();
        $tolaky = $this->GridTolakYuran();
        $tolaks = $this->GridTolakIelts();
        $tolakv = $this->GridTolakVisa();
        $lulusy = $this->GridTuntutLulusYuran();
        $luluss = $this->GridTuntutLulusIelts();
        $lulusv = $this->GridTuntutLulusVisa();

        $tolaky = $this->GridTolakYuran();
        $selection = (array) Yii::$app->request->post('selection'); //typecasting

        if (Yii::$app->request->post('simpan')) {

            foreach ($models as $data) {
                if ('y' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = $this->findModelhpg($data->id);
                    $model->status_bsm = 'Draft Diluluskan';
                    $model->save(false);
//                    return $this->redirect('index');
                } elseif ('n' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = $this->findModelhpg($data->id);
                    $model->status_bsm = 'Draft Ditolak';
                    $model->save(false);
                }
            }
        } elseif (Yii::$app->request->post('hantar')) {
            foreach ($selection as $id) {


                $hantar = $this->findModelhpg($id); //make a typecasting
//                if ('n' . $hantar->id == Yii::$app->request->post($hantar->id)) {
//                    $hantar->status = 'TIDAK LULUS';
//                    $hantar->status_bsm = 'Tidak Diluluskan';
//                    $hantar->ver_date = date('Y-m-d H:i:s');
//
//                    $this->notifikasi($hantar->icno, "Permohonan Tuntutan anda tidak berjaya." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
//                } else
                if ('y' . $hantar->id == Yii::$app->request->post($hantar->id) && $hantar->status_semakan == "Layak Dipertimbangkan") {
                    $hantar->status = 'LULUS';
                    $hantar->status_bsm = 'Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');
                    $hantar->ver_by = $icno;
                    $this->notifikasi($hantar->icno, "Permohonan Tuntutan anda berjaya." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                } else {
                    $hantar->status = 'TIDAK LULUS';
                    $hantar->status_bsm = 'Tidak Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');
//
                    $this->notifikasi($hantar->icno, "Permohonan Tuntutan anda tidak berjaya." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                }
                $hantar->save(false);
            }
        }
        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            $senarai = \app\models\cbelajar\TblTuntut::find()->where([ 'status_borang' => "Selesai Permohonan"])->orderBy(['tarikh_m' => SORT_DESC]);
            $title = 'Senarai Menunggu Semakan';
        }

//       elseif(Refpegawai::find()->where( ['pegawai_bsm' => $icno] )->exists()){
//            
//            $senarai = Tblyuran::find()->where(['in', 'status_kj', $status])->orderBy(['entry_date' => SORT_DESC]);
//            $title ='Senarai Menunggu Perakuan';
//            
//        }
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);


        if ($title != NULL) {
            return $this->render('senarai_hpg', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
                        'semak' => $semak,
                        'lulush' => $lulush,
                        'semakt' => $semakt,
                        'lulust' => $lulust,
                        'semakp' => $semakp,
                        'lulusp' => $lulusp,
                        'tolakp' => $tolakp,
                        'tolakw' => $tolakw,
                        'semaky' => $semaky,
                        'lulusy' => $lulusy,
                        'tolaky' => $tolaky,
                        'semaks' => $semaks,
                        'luluss' => $luluss,
                        'tolaks' => $tolaks,
                        'semakv' => $semakv,
                        'tolakv' => $tolakv,
                        'lulusv' => $lulusv
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['/cutibelajar/index']);
        }
    }

    public function actionSenaraitindakanlkk() {
        $icno = Yii::$app->user->getId();
        $title = '';
        $models = \app\models\cbelajar\TblLkk::find()->where(['status_borang' => "Complete"])->all();
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke' => SORT_DESC])->limit(1)->one();
        $senarai = '';
        $status = ['Tunggu Kelulusan', 'Diluluskan', 'Tidak Diluluskan'];
        $selection = (array) Yii::$app->request->post('selection'); //typecasting

        if (Yii::$app->request->post('simpan')) {

            foreach ($models as $data) {
                if ('y' . $data->reportID == Yii::$app->request->post($data->reportID)) {
                    $model = $this->findModellkk($data->reportID);
                    $model->status_bsm = 'Draft Diluluskan';
                    $model->save(false);
//                    return $this->redirect('index');
                } elseif ('n' . $data->reportID == Yii::$app->request->post($data->reportID)) {
                    $model = $this->findModellkk($data->reportID);
                    $model->status_bsm = 'Draft Ditolak';
                    $model->save(false);
                }
            }
        } elseif (Yii::$app->request->post('hantar')) {
            foreach ($selection as $id) {
                $hantar = $this->findModellkk($id); //make a typecasting
                if ('n' . $hantar->reportID == Yii::$app->request->post($hantar->reportID)) {
                    $hantar->status = 'TIDAK LULUS';
                    $hantar->status_bsm = 'Tidak Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');

                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan anda tidak berjaya." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                } elseif ('y' . $hantar->reportID == Yii::$app->request->post($hantar->reportID)) {
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
            $senarai = \app\models\cbelajar\TblLkk::find()->where([ 'status_borang' => "Complete"])->orderBy(['tarikh_mohon' => SORT_DESC]);
            $title = 'Senarai Menunggu Semakan';
        }

//       elseif(Refpegawai::find()->where( ['pegawai_bsm' => $icno] )->exists()){
//            
//            $senarai = Tblyuran::find()->where(['in', 'status_kj', $status])->orderBy(['entry_date' => SORT_DESC]);
//            $title ='Senarai Menunggu Perakuan';
//            
//        }
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);


        if ($title != NULL) {
            return $this->render('senarai_tindakan_4', [
                        'icno' => $icno,
                        'senarai' => $senarais,
                        'title' => $title,
                        'tmp' => $tmp,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['/cutibelajar/index']);
        }
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

    protected function findModel($id) {

        if (($model = TblLanjutan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel3($id) {

        if (($model = TblPermohonan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModellanjut($id) {

        if (($model = TblLanjutan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findBiodata($id) {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelCB($id) {

        if (($model = \app\models\cbelajar\TblPermohonan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModellain($id) {

        if (($model = \app\models\cbelajar\TblLain::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModeltiket($id) {

        if (($model = \app\models\cbelajar\BorangPenerbangan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelhpg($id) {

        if (($model = \app\models\cbelajar\TblTuntut::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModellkk($id) {

        if (($model = \app\models\cbelajar\TblLkk::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModellapor($id) {

        if (($model = \app\models\cbelajar\TblLapordiri::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionRingkasanData() {


        $fakulti = \app\models\hronline\Department::find()->where(['category_id' => 1, 'dept_cat_id' => ['2', '4']])->orWhere(['id' => ['15', '104']])->orderBy(['shortname' => SORT_ASC])->all();
        return $this->render('ringkasan_data', [
                    'fakulti' => $fakulti,
        ]);
    }

    public function actionTetapan() {
        $icno = Yii::$app->user->getId();
        $models = TblAdmin::findOne(['icno' => $icno]);
        if (!$models) {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['cutibelajar/index']);
        }
        $names = ['date_open', 'date_close'];
        $request = Yii::$app->request;
        if ($request->post()) {
            $status = true;
            foreach ($names as $name) {

                #date range
                $date = ['date_open', 'date_close'];

                if (in_array($name, $date)) {
                    #cheking
                    $open = date('Y-m-d', strtotime($request->post('date_open')));
                    $close = date('Y-m-d', strtotime($request->post('date_close')));

                    if ($open >= $close) {
                        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tarikh ditutup hendaklah selepas tarikh dibuka!']);
                        return $this->redirect(['cbadmin/tetapan']);
                    }
                }
                $option = Option::find()->where(["name" => $name])->one();
                $option->value = $request->post($name);

                if (!$option->save()) {
                    $status = false;
                }
            }

            if ($status == true) {
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Tetapan berjaya dikemaskini!']);
                return $this->redirect(['cbadmin/tetapan']);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Gagal mengemaskini tetapan!']);
                return $this->redirect(['cbadmin/tetapan']);
            }
        }
        $model = ArrayHelper::map(Option::find()->where(['in', 'name', $names])->all(), 'name', 'value');
        return $this->render('tetapan', compact('model'));
    }

    public function actionUploadsurat($id) {
        $message = '';
        $model = $this->findModel3($id);
        $dokumen = \app\models\cbelajar\TblSurat::find()->where(['icno' => $model->id])->one();
        if (!$dokumen) {
            $dokumen = new TblSurat();
            $dokumen->tajuk = 'Surat Kelulusan';
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

    public function actionMuatnaiksurat($id) {
        $icno = Yii::$app->user->getId();
        $model = $this->findModel3($id);
        $dokumen = \app\models\cbelajar\TblSurat::find()->where(['icno' => $model->id])->one();
        if (!$dokumen) {
            $dokumen = new TblSurat();
            $dokumen->tajuk = 'Surat Kelulusan';
        }
        $surat = $model->surat;
        if ($dokumen->load(Yii::$app->request->post())) {

            Yii::$app->FileManager->DeleteFile($surat);
            $file = UploadedFile::getInstance($dokumen, 'file');


            if ($file) {
//                    $var_dump($saving);die;
//                    $file_path = null;
                $file = Yii::$app->FileManager->
                        UploadFile($file->name, $file->tempName, '04', 'cutibelajar');

                $file_path = $file->file_name_hashcode;
            } else {
                $file_path = NULL;
            }



            $dokumen->dokumen = $file_path;
            $dokumen->icno = $model->id;
            $dokumen->tahun = date("Y");
            $dokumen->created_dt = new \yii\db\Expression('NOW()');
            $dokumen->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['senaraitindakan1']);
            //}
        } else {
            return $this->renderAjax('uploadsurat', [
                        'dokumen' => $dokumen,
            ]);

//            return $this->renderAjax('index', [
//                       
//            ]);
        }
    }

    public function actionUploadsuratlanjut($id) {
        $message = '';
        $model = $this->findModellanjut($id);
        $dokumen = \app\models\cbelajar\TblSurat::find()->where(['icno' => $model->id])->one();
        if (!$dokumen) {
            $dokumen = new TblSurat();
            $dokumen->tajuk = 'Surat Pemakluman';
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
        return $this->renderAjax('uploadsuratlanjut', [
                    'dokumen' => $dokumen,
                    'message' => $message
        ]);
    }

    public function actionUploadsuratsabatikal($id) {
        $message = '';
        $model = $this->findModelCB($id);
        $dokumen = \app\models\cbelajar\TblSurat::find()->where(['icno' => $model->id])->one();
        if (!$dokumen) {
            $dokumen = new TblSurat();
            $dokumen->tajuk = 'Surat Kelulusan';
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
        return $this->renderAjax('uploadsuratsabatikal', [
                    'dokumen' => $dokumen,
                    'message' => $message
        ]);
    }

    public function actionUploadsuratlain($id) {
        $message = '';
        $model = $this->findModellain($id);
        $dokumen = \app\models\cbelajar\TblSurat::find()->where(['icno' => $model->id])->one();
        if (!$dokumen) {
            $dokumen = new TblSurat();
            $dokumen->tajuk = 'Surat Kelulusan';
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
        return $this->renderAjax('uploadsurat_1', [
                    'dokumen' => $dokumen,
                    'message' => $message
        ]);
    }

    public function actionUploadsurattiket($id) {
        $message = '';
        $model = $this->findModeltiket($id);
        $dokumen = \app\models\cbelajar\TblSurat::find()->where(['icno' => $model->id])->one();
        if (!$dokumen) {
            $dokumen = new TblSurat();
            $dokumen->tajuk = 'Surat Kelulusan';
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
        return $this->renderAjax('uploadsurattiket', [
                    'dokumen' => $dokumen,
                    'message' => $message
        ]);
    }

    public function actionUploadsuratlapor($id) {
        $message = '';
        $model = $this->findModellapor($id);
        $dokumen = \app\models\cbelajar\TblSurat::find()->where(['icno' => $model->laporID])->one();
        if (!$dokumen) {
            $dokumen = new TblSurat();
            $dokumen->tajuk = 'Surat Kelulusan';
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
        return $this->renderAjax('uploadsuratlapor', [
                    'dokumen' => $dokumen,
                    'message' => $message
        ]);
    }

//    public function actionReset($id, $url){
//        $model = TblSelfhealth::find()->where(['id' => $id])->one();
//        
//        if ($model->load(Yii::$app->request->post())) {
//            $icno = Yii::$app->user->getId();
//            $model->reset_date = date('Y-m-d H:i:s');
//            $model->reset_by = $icno;
//            $model->save();
//            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => '']);
//            return $this->redirect([$url]);
//        }
//        
//        return $this->renderAjax('reset', [
//                    'model' => $model,'url'=>$url
//        ]); 
//    }
    //Ida's codes
    public function actionTetapanAkses() {

//        $akses = AdminJfpiu::find()
//                ->joinWith('biodata')
//                ->orderBy('DeptId')
//                ->all();

        $aksesbaru = new AdminJfpiu(); //untuk admin baru
        if ($aksesbaru->load(Yii::$app->request->post())) {
            if (AdminJfpiu::find()->where([ 'staffID' => $aksesbaru->staffID])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                $aksesbaru->date_added = date('Y-m-d');
                $aksesbaru->added_by = Yii::$app->user->getId();

                $checkStaff = Tblprcobiodata::find()
                        ->where(['ICNO' => $aksesbaru->staffID])
                        ->one();

                $aksesbaru->staff_dept_on_added = $checkStaff->DeptId;
                $aksesbaru->save(false);
            }
            return $this->redirect(['tetapan-akses']);
        }

        /*         * * testing codes ** */
        $searchModel = new \app\models\cbelajar\AdminJfpiuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        /*         * * */

        return $this->render('tetapanakses', [
                    //'akses' => $akses,
                    'aksesbaru' => $aksesbaru,
                    'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname'),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDeleteAkses($id) {
        $akses = AdminJfpiu::findOne(['staffID' => $id]);
        $akses->delete();
        if ($akses->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapus data']);
        }
        //return $this->redirect(['tetapan-akses']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionLaporanLkpJabatan($tahun = null, $dept_id = null) {

        $icno = Yii::$app->user->getId();

        $year = date('Y');

        $model = AdminJfpiu::find()->where(['staffID' => $icno])->all();

        $isAdmin = TblAccess::find()->where(['icno' => $icno])->all();

        $model_dept = Department::find()->where(['isActive' => 1])->all();

        if (!$tahun) {
            $tahun = $year;
        }

        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();



        /** errro cross-server */
        // $c = [];
        // $d = [];
        //     foreach ($a as $aaa) {
        //             if ($aaa->biodata->jawatan->job_category == 2){
        //                 array_push($c, $aaa->icno);
        //             } elseif($aaa->biodata->jawatan->job_category == 1){
        //                 array_push($d, $aaa->icno);
        //             }
        //     }
        // echo '<pre>' , var_dump(count($c)) , '</pre>';
        // echo '<pre>' , var_dump(count($d)) , '</pre>';
        // die();
//        $bb = IdpMata::find()
//                ->joinWith('biodata')
//                ->where(['tahun' => $tahun])
//                ->andWhere(['staffID' => $c])
//                ->orderBy('CONm');
//        
//        $bbbb = IdpMata::find()
//                ->joinWith('biodata')
//                ->where(['tahun' => $tahun])
//                ->andWhere(['staffID' => $d])
//                ->orderBy('CONm');

        $staffCurrentIDP2 = \app\models\cbelajar\TblPengajian::find()
                ->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['tblprcobiodata.ICNO' => $icno])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1, 2]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])
                ->orderBy('CONm');


        // echo '<pre>' , var_dump(($bbbb)) , '</pre>';
        // die();

        $dataProvider2 = new ActiveDataProvider([
            'query' => $staffCurrentIDP2,
            'pagination' => [

                'pageSize' => 15,
            ],
        ]);
        return $this->render('/cutibelajar/senarai_staff', [
                    'isAdmin' => $isAdmin,
                    'tahun' => $tahun,
                    'bil' => 1,
                    'model2' => $staffCurrentIDP2,
                    'dept_id' => $dept_id,
                    'model_dept' => $model_dept,
                    'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionSenaraiStaffFakulti() {
        $icno = Yii::$app->user->getId();
//        $currentYear = date('Y');
        $model = AdminJfpiu::find()->where(['staffID' => $icno])->one();
        $staffCurrentIDP = \app\models\cbelajar\TblPengajian::find()
                ->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
//                ->where(['cb_tbl_adminjfpiu.staffID'=> $icno])
//                ->andWhere(['department.DeptID'=> $icno])
//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => 2])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])
                ->orderBy('CONm');

        $staffCurrentIDP2 = \app\models\cbelajar\TblPengajian::find()
                ->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->joinWith('kakitangan.akses')
                ->where(['staffID' => $icno])
                ->orWhere(['department.penyelia' => $icno])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1, 2]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
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

                'pageSize' => 15,
            ],
        ]);

        return $this->render('/pengajian/senarai_staff', [
                    'model' => $staffCurrentIDP,
                    'dataProvider' => $dataProvider,
                    'model2' => $staffCurrentIDP2,
                    'dataProvider2' => $dataProvider2,
        ]);
    }

}
