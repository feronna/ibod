<?php

namespace app\controllers;

use app\models\hronline\Tbldospenggalak;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\TblprcobiodataSearch;
use Yii;
use app\models\hronline\Tblvaksinasi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\hronline\Tblpenerimavaksin;
use app\models\hronline\TblsetujuDospenggalak;
use app\models\hronline\Tblstat;
use app\models\hronline\Tblstatusvaksinasi;
use yii\web\UploadedFile;
use tebazil\runner\ConsoleCommandRunner;
use DateTime;
use DateInterval;
use app\models\hronline\Model;
use app\models\hronline\Tblbsmwatchlist;
use app\models\hronline\TblbsmwatchlistSearch;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

class VaksinasiController extends Controller
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
                'only' => ['*'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),
                    [
                        'actions' => ['admin-view', 'admin-update', 'admin-view-status-vaksinasi','kemaskini-sv'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $access = Yii::$app->user->identity->accessLevel;
                            $secondaccess = Yii::$app->user->identity->accessSecondLevel;

                            switch ($access) {
                                case '1':
                                    return true;
                                    break;
                                case '2':
                                    if (in_array($secondaccess, ['1', '3'])) {
                                        return true;
                                    }
                                    if (in_array($secondaccess, ['4', '5', '6'])) {
                                        return true;
                                    }
                                    return false;
                                    break;
                                case '3':
                                    if (in_array($secondaccess, ['7', '8', '9'])) {
                                        return true;
                                    }
                                    return false;
                                    break;
                                default:
                                    return false;
                                    break;
                            }
                            return false;
                        }
                    ],
                    [
                        'actions' => ['watch-list','lock-unlock-clockin','is-allowed'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $access = Yii::$app->user->identity->accessLevel;
                            $secondaccess = Yii::$app->user->identity->accessSecondLevel;

                            switch ($access) {
                                case '1':
                                    return true;
                                    break;
                                case '2':
                                    if (in_array($secondaccess, ['4'])) {
                                        return true;
                                    }
                                    return false;
                                    break;
                                default:
                                    return false;
                                    break;
                            }
                            return false;
                        }
                    ],
                    [
                        'actions' => ['update-status_-vaksinasi','update-st-vaksinasi', 'kemaskini-dos-pertama', 'kemaskini-dos-kedua', 'kemaskini-dos-penggalak'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return true;
                        }
                    ],
                    [
                        'actions' => ['index', 'view-status-vaksinasi_','view-st-vaksinasi', 'update', 'view', 'booster', 'view-bc', 'kemaskini-sv_','not-registered','vaccine-accept_','vaccine-reject_'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['booster', 'view-bc'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Tblstatusvaksinasi::isEligibleBooster(Yii::$app->user->getId())) {
                                return true;
                            }
                            return false;
                        }
                    ],

                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('_index',[
            'icno' => Yii::$app->user->getId(),
        ]);
    }

    //new vaccine//
    public function actionNotRegistered(){

        if (Yii::$app->request->post()) {
            if (Yii::$app->request->post('statusvaksin') && !Yii::$app->MP->HaveVaccineRecord(Yii::$app->user->getId())) {
                return $this->redirect(['vaccine-accept']);
            } else if(Yii::$app->request->post('statusvaksin')){
                return $this->redirect(['kemaskini-sv']);
            }else {
                return $this->redirect(['vaccine-reject']);
            }
        }
        return $this->renderAjax('_not_registered_vaccine');
    }

    public function actionVaccineAccept(){
        $icno = Yii::$app->user->getId();
        $modelsvaksin = new Tblstatusvaksinasi();
        $modelsvaksin->scenario = 'accept';
        $modelsdos = [new Tblpenerimavaksin()];
        $modelsvaksin->icno = $icno;
        $modelsvaksin->status_vaksin = 1;
        $modelsvaksin->terima_dos1 = 0;
        $modelsvaksin->terima_dos2 = 0;

        if($modelsvaksin->load(Yii::$app->request->post())){

            $modelsdos = Model::createMultiple(Tblpenerimavaksin::classname());
            Model::loadMultiple($modelsdos, Yii::$app->request->post());

            $valid = $modelsvaksin->validate();
            $valid = Model::validateMultiple($modelsdos) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    $modelsvaksin->file = UploadedFile::getInstance($modelsvaksin, 'file');
                    if ($modelsvaksin->file) {
                        $datas = Yii::$app->FileManager->UploadFile($modelsvaksin->file->name, $modelsvaksin->file->tempName, '04', 'Maklumat Rekod Kakitangan/vaksinasi'); //akaun
                        if ($datas->status == true) {
                            $modelsvaksin->sijil_digital = $datas->file_name_hashcode;
                            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                            $upload_flag = true;
                        } else {
                            $upload_flag = false;
                            Yii::$app->session->setFlash('alert', ['title' => 'Gagal Muatnaik', 'type' => 'error', 'msg' => 'Terdapat masalah muatnaik sijil vaksinasi.']);
                        }
                    } else if (!empty($modelsvaksin->sijil_digital)) {
                        $upload_flag = true;
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    } else {
                        $upload_flag = false;
                        Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik Sijil Digital Vaksinasi anda!']);
                    }



                    if ($flag = ($modelsvaksin->save(false) && $upload_flag)) {

                        foreach ($modelsdos as $i => $modeldos) {
                            $modeldos->icno = $icno;
                            $modeldos->status_vaksinasi_id = $modelsvaksin->id;
                            if ($i == 0) {
                                $modeldos->bil_dos = 1;
                                $modelsvaksin->status_vaksin = 1;
                                $modelsvaksin->terima_dos1 = 1;
                                $modelsvaksin->save(false);
                            } else if ($i == 1) {
                                $modeldos->bil_dos = 2;
                                $modelsvaksin->terima_dos2 = 1;
                                $modelsvaksin->save(false);
                            }
                            if (!($flag = $modeldos->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view-status-vaksinasi']);
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            } 
        }

        return $this->render('statusVaksinasi/_vaccine_accept',[
            'modelsvaksin'=>$modelsvaksin,
            'modelsdos' => (empty($modelsdos)) ? [new Tblpenerimavaksin] : $modelsdos,
        ]);
        
    }
    public function actionVaccineReject(){
        $model = new Tblstatusvaksinasi();
        $model->scenario = 'reject';
        $model->icno = Yii::$app->user->getId();

        if($model->load(Yii::$app->request->post())){
            $model->status_vaksin = 0;
            $model->lampiran_ = UploadedFile::getInstance($model, 'lampiran_');
                    if ($model->lampiran_) {
                        $datas = Yii::$app->FileManager->UploadFile($model->lampiran_->name, $model->lampiran_->tempName, '04', 'Maklumat Rekod Kakitangan/vaksinasi'); 
                        if ($datas->status == true) {
                            $model->lampiran = $datas->file_name_hashcode;
                            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                            $model->save(false);
                            return $this->redirect(['status-vaksinasi/view']);
                        }else{
                            Yii::$app->session->setFlash('alert', ['title' => ' Gagal', 'type' => 'error', 'msg' => 'Terdapat masalah memuatnaik lampiran!']);
                        }
                    }else{
                        Yii::$app->session->setFlash('Gagal', "Sila muatnaik lampiran berkaitan.");
                    }
        }

        return $this->render('statusVaksinasi/_vaccine_reject',[
            'model'=>$model,
        ]);

    }
    //end new vaccine//

    public function actionView()
    {
        $icno = Yii::$app->user->getId();
        $model = $this->findModel($icno);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($from = null)
    {
        $icno = Yii::$app->user->getId();
        $model = $this->findModel($icno);
        $model->mysj_id = $model->biodata ? $model->biodata->mySejahteraId : null;

        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            if ($model->daftar_st == 1) {
                $model->sebab_1 = null;
            }
            if ($model->setuju_st == 1) {
                $model->sebab_2 = null;
            }
            $model->kemaskini_dt = date("Y-m-d h:i:s");
            $model->biodata ? $model->biodata->mySejahteraId = $model->mysj_id : null;
            $model->mysj_id ? $model->mysj_id_st = '1' : $model->mysj_id_st = '0';

            if ($model->save()) {
                $model->biodata->save(false);

                switch ($from) {
                    case '1':
                        return $this->redirect(['kehadiran/index']);
                        break;
                    case '2':
                        return $this->redirect(['keselamatan/index']);
                        break;
                    case '3':
                        return $this->redirect(['dashboard/index']);
                        break;

                    default:
                        return $this->redirect(['view',]);
                        break;
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'from' => $from,
        ]);
    }

    public function actionAdminView($icno)
    {
        $model = $this->findModel($icno);

        return $this->render('adminview', [
            'model' => $model,
        ]);
    }

    public function actionAdminUpdate($icno)
    {
        $model = $this->findModel($icno);
        $model->mysj_id = $model->biodata ? $model->biodata->mySejahteraId : null;

        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            if ($model->daftar_st == 1) {
                $model->sebab_1 = null;
            }
            if ($model->setuju_st == 1) {
                $model->sebab_2 = null;
            }
            $model->kemaskini_dt = date("Y-m-d h:i:s");
            $model->biodata ? $model->biodata->mySejahteraId = $model->mysj_id : null;
            $model->mysj_id ? $model->mysj_id_st = '1' : $model->mysj_id_st = '0';

            if ($model->save()) {
                $model->biodata->save(false);
                return $this->redirect(['admin-view', 'icno' => $icno]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'from' => null,
        ]);
    }

    //dos pertama
    public function actionKemaskiniDosPertama()
    {
        $icno = Yii::$app->user->getId();
        $model = $this->findDos1($icno);
        $model->bil_dos = 1;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $tblstatusvaksinasi = $this->findModelStatusVaksinasi($icno);
                $tblstatusvaksinasi->terima_dos1 = 1;
                $tblstatusvaksinasi->save(false);
                if($this->isFullDos($icno)){
                    if (($watchlist = Tblbsmwatchlist::findWatchlist($icno, 'required')) !== null) {
                        $watchlist->isAllowed = 1;
                        $watchlist->dateAD = date('Y-m-d h:i:s');
                        $watchlist->isDone = 1;
                        $watchlist->dateDone = date('Y-m-d h:i:s');
                        $watchlist->save(false);
                    }
                }
                return $this->redirect(['view-st-vaksinasi']);
            }
        }

        return $this->render('dos/update', [
            'model' => $model,
            'dos' => 1,
        ]);
    }
    //tamat dos pertama//
    //dos kedua
    public function actionKemaskiniDosKedua()
    {
        $icno = Yii::$app->user->getId();
        $model = $this->findDos2($icno);
        $model->bil_dos = 2;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $tblstatusvaksinasi = $this->findModelStatusVaksinasi($icno);
                $tblstatusvaksinasi->terima_dos2 = 1;
                $tblstatusvaksinasi->save(false);
                if ($this->isFullDos($icno)) {
                    if (($watchlist = Tblbsmwatchlist::findWatchlist($icno, 'required')) !== null) {
                        $watchlist->isAllowed = 1;
                        $watchlist->dateAD = date('Y-m-d h:i:s');
                        $watchlist->isDone = 1;
                        $watchlist->dateDone = date('Y-m-d h:i:s');
                        $watchlist->save(false);
                    }
                }
                return $this->redirect(['view-st-vaksinasi']);
            }
        }

        return $this->render('dos/update', [
            'model' => $model,
            'dos' => 2,
        ]);
    }

    //tamat dos kedua//

    //status vaksinasi//

    public function actionViewStatusVaksinasi()
    {   
        $icno = Yii::$app->user->getId();
       
        $model = $this->findModelStatusVaksinasi($icno);

        $dos1 = [];
        $dos2 = [];
        $dospenggalak = [];
        if($model->status_vaksin == 0){
            return $this->render('statusVaksinasi/view_reject', [
                'model' => $model,
            ]);
        }
        if ($model->terima_dos1) {
            $dos1 = $this->findDos1($icno);
        }
        if ($model->terima_dos2) {
            $dos2 = $this->findDos2($icno);
        }
        $dospenggalak = $this->findDosPenggalak($icno, 'new');

        return $this->render('statusVaksinasi/view', [
            'model' => $model,
            'dos1' => $dos1,
            'dos2' => $dos2,
            'dospenggalak' => $dospenggalak,
        ]);
    }
    public function actionViewStVaksinasi()
    {   
        $icno = Yii::$app->user->getId();
       
        $model = $this->findModelStatusVaksinasi($icno);

        $dos1 = [];
        $dos2 = [];
        $dospenggalak = [];
        if ($model->terima_dos1) {
            $dos1 = $this->findDos1($icno);
        }
        if ($model->terima_dos2) {
            $dos2 = $this->findDos2($icno);
        }
        $dospenggalak = $this->findDosPenggalak($icno, 'new');

        return $this->render('statusVaksinasi/_view', [
            'model' => $model,
            'dos1' => $dos1,
            'dos2' => $dos2,
            'dospenggalak' => $dospenggalak,
        ]);
    }
    public function actionUpdateStatusVaksinasi()
    {
        $icno = Yii::$app->user->getId();
        $model = $this->findModelStatusVaksinasi($icno);
        $model->scenario = 'sudah_terima';
        $dos1 = [];
        $dos2 = [];
        if ($model->terima_dos1) {
            $dos1 = $this->findDos1($icno);
        }
        if ($model->terima_dos2) {
            $dos2 = $this->findDos2($icno);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');
            $model->lampiran_ = UploadedFile::getInstance($model, 'lampiran_');
            if ($model->status_vaksin != 1) {
                $model->scenario = 'belum_terima';
                $model->terima_dos1 = 0;
                $model->terima_dos2 = 0;
                if ($model->sebab_belum_terima == 2) {
                    // if ($model->lampiran_) {
                    if ($model->save()) {
                        if ($model->lampiran_) {
                            $datas = Yii::$app->FileManager->UploadFile($model->lampiran_->name, $model->lampiran_->tempName, '04', 'Maklumat Rekod Kakitangan/vaksinasi');
                            if ($datas->status == true) {
                                $model->lampiran = $datas->file_name_hashcode;
                                $model->save(false);
                            } else {
                                Yii::$app->session->setFlash('alert', ['title' => ' Gagal Muatnaik', 'type' => 'error', 'msg' => 'Terdapat masalah muatnaik lampiran.']);
                            }
                        }

                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        return $this->redirect(['view-status-vaksinasi']);
                    }
                    Yii::$app->session->setFlash('alert', ['title' => ' Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                    // } else {
                    //     Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik Lampiran anda!']);
                    // }
                } else {
                    $model->save();
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    return $this->redirect(['view-status-vaksinasi']);
                }
            } else if ($model->file) {
                if ($model->save()) {
                    $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/vaksinasi'); //akaun
                    if ($datas->status == true) {
                        $model->sijil_digital = $datas->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        return $this->redirect(['view-status-vaksinasi']);
                    } else {
                        Yii::$app->session->setFlash('alert', ['title' => 'Gagal Muatnaik', 'type' => 'error', 'msg' => 'Terdapat masalah muatnaik sijil vaksinasi.']);
                        return $this->redirect(['view-status-vaksinasi']);
                    }
                }
                Yii::$app->session->setFlash('alert', ['title' => ' Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
            } else if (!empty($model->sijil_digital)) {
                $model->save();
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['view-status-vaksinasi']);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik Sijil Digital Vaksinasi anda!']);
            }
        }

        return $this->render('statusVaksinasi/update', [
            'model' => $model,
            'dos1' => $dos1,
            'dos2' => $dos2,
        ]);
    }
    public function actionUpdateStVaksinasi()
    {
        $icno = Yii::$app->user->getId();
        $model = $this->findModelStatusVaksinasi($icno);
        $model->scenario = 'sudah_terima';
        $dos1 = [];
        $dos2 = [];
        if ($model->terima_dos1) {
            $dos1 = $this->findDos1($icno);
        }
        if ($model->terima_dos2) {
            $dos2 = $this->findDos2($icno);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');
            $model->lampiran_ = UploadedFile::getInstance($model, 'lampiran_');
            if ($model->status_vaksin != 1) {
                $model->scenario = 'belum_terima';
                $model->terima_dos1 = 0;
                $model->terima_dos2 = 0;
                if ($model->sebab_belum_terima == 2) {
                    // if ($model->lampiran_) {
                    if ($model->save()) {
                        if ($model->lampiran_) {
                            $datas = Yii::$app->FileManager->UploadFile($model->lampiran_->name, $model->lampiran_->tempName, '04', 'Maklumat Rekod Kakitangan/vaksinasi');
                            if ($datas->status == true) {
                                $model->lampiran = $datas->file_name_hashcode;
                                $model->save(false);
                            } else {
                                Yii::$app->session->setFlash('alert', ['title' => ' Gagal Muatnaik', 'type' => 'error', 'msg' => 'Terdapat masalah muatnaik lampiran.']);
                            }
                        }

                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        return $this->redirect(['view-st-vaksinasi']);
                    }
                    Yii::$app->session->setFlash('alert', ['title' => ' Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                    // } else {
                    //     Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik Lampiran anda!']);
                    // }
                } else {
                    $model->save();
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    return $this->redirect(['view-st-vaksinasi']);
                }
            } else if ($model->file) {
                if ($model->save()) {
                    $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Kakitangan/vaksinasi'); //akaun
                    if ($datas->status == true) {
                        $model->sijil_digital = $datas->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                        return $this->redirect(['view-st-vaksinasi']);
                    } else {
                        Yii::$app->session->setFlash('alert', ['title' => 'Gagal Muatnaik', 'type' => 'error', 'msg' => 'Terdapat masalah muatnaik sijil vaksinasi.']);
                        return $this->redirect(['view-st-vaksinasi']);
                    }
                }
                Yii::$app->session->setFlash('alert', ['title' => ' Gagal', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
            } else if (!empty($model->sijil_digital)) {
                if($model->save()){
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                     return $this->redirect(['view-st-vaksinasi']);
                } 
                Yii::$app->session->setFlash('alert', ['title' => ' Gagal', 'type' => 'error', 'msg' => 'Terdapat masalah dalam proses. Tidak berjaya disimpan!']);
                                   
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik Sijil Digital Vaksinasi anda!']);
            }
        }

        return $this->render('statusVaksinasi/_update', [
            'model' => $model,
            'dos1' => $dos1,
            'dos2' => $dos2,
        ]);
    }
    public function actionKemaskiniSv()
    {
        $_file = null;
        $upload_flag = false;
        $icno = Yii::$app->user->getId();
        $modelsvaksin = $this->findModelStatusVaksinasi($icno);
        $modelsdos = $modelsvaksin->dos;

        if ($modelsvaksin->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsdos, 'id', 'id');
            $modelsdos = Model::createMultiple(Tblpenerimavaksin::classname(), $modelsdos);
            Model::loadMultiple($modelsdos, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsdos, 'id', 'id')));

            // $modelsvaksin->load(Yii::$app->request->post()) ;
            // $modelsdos = Model::createMultiple(Tblpenerimavaksin::classname());
            // Model::loadMultiple($modelsdos, Yii::$app->request->post());


            // ajax validation
            // if (Yii::$app->request->isAjax) {
            //     Yii::$app->response->format = Response::FORMAT_JSON;
            //     return ArrayHelper::merge(
            //         ActiveForm::validateMultiple($modelsAddress),
            //         ActiveForm::validate($modelCustomer)
            //     );
            // }


            // validate all models
            $valid = $modelsvaksin->validate();
            $valid = Model::validateMultiple($modelsdos) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    $modelsvaksin->file = UploadedFile::getInstance($modelsvaksin, 'file');
                    if ($modelsvaksin->file) {
                        $datas = Yii::$app->FileManager->UploadFile($modelsvaksin->file->name, $modelsvaksin->file->tempName, '04', 'Maklumat Rekod Kakitangan/vaksinasi'); //akaun
                        if ($datas->status == true) {
                            $modelsvaksin->sijil_digital = $datas->file_name_hashcode;
                            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                            $upload_flag = true;
                        } else {
                            $upload_flag = false;
                            Yii::$app->session->setFlash('alert', ['title' => 'Gagal Muatnaik', 'type' => 'error', 'msg' => 'Terdapat masalah muatnaik sijil vaksinasi.']);
                        }
                    } else if (!empty($modelsvaksin->sijil_digital)) {
                        $upload_flag = true;
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                    } else {
                        $upload_flag = false;
                        Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila muatnaik Sijil Digital Vaksinasi anda!']);
                    }



                    if ($flag = ($modelsvaksin->save(false) && $upload_flag)) {
                       
                        if (!empty($deletedIDs)) {
                            Tblpenerimavaksin::deleteAll(['id' => $deletedIDs]);
                        }

                        foreach ($modelsdos as $i => $modeldos) {
                            $modeldos->icno = $icno;
                            $modeldos->status_vaksinasi_id = $modelsvaksin->id;
                            if ($i == 0) {
                                $modeldos->bil_dos = 1;
                                $modelsvaksin->status_vaksin = 1;
                                $modelsvaksin->terima_dos1 = 1;
                                $modelsvaksin->save(false);
                            } else if ($i == 1) {
                                $modeldos->bil_dos = 2;
                                $modelsvaksin->terima_dos2 = 1;
                                $modelsvaksin->save(false);
                            }
                            if (!($flag = $modeldos->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
            
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view-status-vaksinasi']);
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            } 
        }

        return $this->render('statusVaksinasi/update_w_booster', [
            'modelsvaksin' => $modelsvaksin,
            'modelsdos' => (empty($modelsdos)) ? [new Tblpenerimavaksin] : $modelsdos,
        ]);
    }
    public function actionAdminViewStatusVaksinasi($icno)
    {

        $model = $this->findModelStatusVaksinasi($icno);
        $dos1 = [];
        $dos2 = [];
        if ($model->terima_dos1) {
            $dos1 = $this->findDos1($icno);
        }
        if ($model->terima_dos2) {
            $dos2 = $this->findDos2($icno);
        }
        $dospenggalak = $this->findDosPenggalak($icno, 'new');

        return $this->render('statusVaksinasi/adminview', [
            'model' => $model,
            'dos1' => $dos1,
            'dos2' => $dos2,
            'dospenggalak' => $dospenggalak,
        ]);
    }

    public function actionVaksinasiMtl()
    {
    }

    //tamat status vaksinasi//

    //dos booster//

    public function actionBooster()
    {
        $icno = Yii::$app->user->getId();
        $vaksin = Tblstatusvaksinasi::find()->where(['icno' => $icno])->one();
        if (($dos_penggalak = TblsetujuDospenggalak::find()->where(['icno' => $icno])->one()) === null) {
            $dos_penggalak = new TblsetujuDospenggalak();
        }

        $dos_penggalak->icno = $icno;
        $dos_penggalak->tarikh_dos2 = $vaksin->dos2 ? $vaksin->dos2->tarikh_vaksin : '-';

        if ($dos_penggalak->load(Yii::$app->request->post())) {
            $dos_penggalak->kemaskini_dt = date('Y-m-d h:i:s');
            if ($dos_penggalak->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['view-bc']);
            }
        }

        return $this->render('booster/_booster_consent', [
            'model' => $dos_penggalak,
        ]);
    }

    public function actionViewBc()
    {

        $bc = TblsetujuDospenggalak::find()->where(['icno' => Yii::$app->user->getId()])->one();

        if (empty($bc)) {
            return $this->redirect(['booster']);
        }

        return $this->render('booster/view_booster_consent', [
            'model' => $bc,
        ]);
    }

    public function actionKemaskiniDosPenggalak()
    {
        $icno = Yii::$app->user->getId();
        $st_vaskinasi = $this->findModelStatusVaksinasi($icno);
        $dospenggalak = $this->findDosPenggalak($icno, 'new');
        if ($dospenggalak->load(Yii::$app->request->post())) {
            $dospenggalak->status_vaksinasi_id = $st_vaskinasi->id;
            $dospenggalak->last_update = date('Y-m-d H:i:s');
            $dospenggalak->last_updater = $icno;
            if ($dospenggalak->save()) {
                $st_vaskinasi->terima_penggalak = 1;
                if($st_vaskinasi->save(false)){
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dikemaskini']);
                }
                return $this->redirect(['view-st-vaksinasi']);
            }
        }

        return $this->render('booster/kemaskini', [
            'model' => $dospenggalak,
        ]);
    }

    //tamat dos booster//


    //watch list//
    public function actionWatchList(){
        $searchModel = new TblbsmwatchlistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('watchlist/_watchlist', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIsAllowed($icno){
        var_dump(Yii::$app->MP->isAllowedClockin($icno));
        die;
    }

    public function actionLockUnlockClockin($id){
        $model = $this->findWatchlist($id);
        if($model->isAllowed == 1){
            $model->isAllowed = 0;
            $status = 'Locked';
            $action = 'tidak dibenarkan';
        }else{
            $model->isAllowed = 1;
            $status = 'Unlocked';
            $action = 'dibenarkan';
        }
        if($model->save(false)){
            Yii::$app->session->setFlash('alert', ['title' => $status, 'type' => 'success', 'msg' => 'Staf '.$action.' clock-in. ']);
        }
        return $this->redirect(['watch-list']);
    }

    //end watch list//

    public function actionVaksinasiList()
    {
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->carianVaksinasi(Yii::$app->request->queryParams);

        return $this->render('vaksinasilist', [
            'carian' => $carian,
            'model' => $dataProvider,
        ]);
    }

    protected function findModel($icno)
    {
        if (($model = Tblvaksinasi::find()->joinWith('biodata')->where(['`tblvaksinasi`.`icno`' => $icno])->one()) !== null) {
            return $model;
        }
        $model = new Tblvaksinasi();
        $model->icno = $icno;
        return $model;
        // throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModelStatusVaksinasi($icno)
    {
        if (($model = Tblstatusvaksinasi::find()->joinWith('biodata')->where(['`tblstatusvaksinasi`.`icno`' => $icno])->one()) !== null) {
            return $model;
        }
        $model = new Tblstatusvaksinasi();
        $model->icno = $icno;
        return $model;
        // throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findDos1($icno)
    {
        if (($dos1 = Tblpenerimavaksin::find()->joinWith('biodata')->where(['`tblpenerima_vaksin`.`icno`' => $icno])->andWhere(['bil_dos' => 1])->one()) !== null) {
            return $dos1;
        }
        $dos1 = new Tblpenerimavaksin();
        $dos1->icno = $icno;
        return $dos1;
        //throw new NotFoundHttpException('Data dos pertama tidak wujud.');
    }

    protected function findDos2($icno)
    {
        if (($dos2 = Tblpenerimavaksin::find()->joinWith('biodata')->where(['`tblpenerima_vaksin`.`icno`' => $icno])->andWhere(['bil_dos' => 2])->one()) !== null) {
            return $dos2;
        }
        $dos2 = new Tblpenerimavaksin();
        $dos2->icno = $icno;
        return $dos2;
        //throw new NotFoundHttpException('Data dos kedua tidak wujud.');
    }
    protected function isFullDos($icno){
        $dos1 = Tblpenerimavaksin::find()->where(['icno' => $icno])->andWhere(['bil_dos'=>'1'])->exists();
        $dos2 = Tblpenerimavaksin::find()->where(['icno' => $icno])->andWhere(['bil_dos'=>'2'])->exists();
        if($dos1 && $dos2){
            return true;
        }
        return false;
    }
    
    protected function findDosPenggalak($icno, $case = null)
    {
        if (($dospenggalak = Tbldospenggalak::find()->where(['icno' => $icno])->one()) !== null) {
            return $dospenggalak;
        }
        if ($case != null) {
            $dospenggalak = new Tbldospenggalak();
            $dospenggalak->icno = $icno;
            $dospenggalak->jenis_dos = 1;
            return $dospenggalak;
        }

        throw new NotFoundHttpException('Data dos penggalak tidak wujud.');
    }

    protected function findBoosterConsent($icno)
    {
        if (($bc = TblsetujuDospenggalak::find()->where(['icno' => $icno])->one()) !== null) {
            return $bc;
        }
        throw new NotFoundHttpException('Data tidak wujud.');
    }

    protected function findWatchlist($icno)
    {
        if (($model = Tblbsmwatchlist::find()->where(['icno' => $icno])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Staf tidak wujud.');
    }

    protected function pendingtask($icno, $id)
    {
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }
}
