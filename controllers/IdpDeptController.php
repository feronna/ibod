<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\models\Notification;
use app\models\cuti\SetPegawai;
use app\models\hronline\GredJawatan;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\TblprcobiodataSearch;
use app\models\hronline\Kumpulankhidmat;
use app\models\hronline\Department;
use app\models\myidp\IdpGredJawatan; //hronline gredjawatan (kiv)
use app\models\myidp\IdpGredJawatanSearch; //hronline gredjawatan (kiv)
use app\models\myidp\Idp; //old model
use app\models\myidp\VCpdLatihan; //old model
use app\models\myidp\VIdpKursusSasaran; //old model
use app\models\myidp\VIdpSenaraiKursus; //old model
use app\models\myidp\VIdpKumpulan; //dari db idp
use app\models\myidp\RefCpdGroup; //ref table
use app\models\myidp\RefCpdGroupGredJawatan; //ref table
use app\models\myidp\PermohonanLatihan;
use app\models\myidp\PermohonanLatihanSearch;
use app\models\myidp\PermohonanKursusLuar;
use app\models\myidp\PermohonanKursusLuarSearch;
use app\models\myidp\PermohonanKursusLuarSearch_1;
use app\models\myidp\PermohonanMataIdpIndividu;
use app\models\myidp\PermohonanMataIdpSearch;
use app\models\myidp\KursusSasaran;
use app\models\myidp\KursusLatihan;
use app\models\myidp\KursusLatihanBahan;
use app\models\myidp\KursusLatihanImport;
use app\models\myidp\KursusLatihanSearch;
use app\models\myidp\KursusLatihanSearch_1; //delete later
use app\models\myidp\KursusLatihanSearch_2; //delete later
use app\models\myidp\SiriLatihan;
use app\models\myidp\SiriLatihanBahan;
use app\models\myidp\SiriLatihanSearch;
use app\models\myidp\SiriLatihanLive;
use app\models\myidp\UserAccess;
use app\models\myidp\SlotLatihan;
use app\models\myidp\Kehadiran;
use app\models\myidp\KehadiranImport;
use app\models\myidp\KehadiranSearch;
use app\models\myidp\KehadiranByJabatan;
use app\models\myidp\KehadiranKeberkesanan;
use app\models\myidp\SoalanPenilaianLatihan; //ref table
use app\models\myidp\BorangPenilaianLatihan;
use app\models\myidp\BorangPenilaianKeberkesanan;
use app\models\myidp\BorangPenilaianLatihanLama;
use app\models\myidp\BorangPenilaianKeberkesananLama;
use kartik\grid\EditableColumnAction;
use app\models\myidp\IdpMata;
use app\models\myidp\Ceramah;
use app\models\myidp\KursusJemputan;
use app\models\myidp\KursusJemputanSearch;
use app\models\myidp\RefSlot;
use app\models\myidp\KursusLatihanJfpiu;
use app\models\myidp\SiriLatihanJfpiu;
use app\models\myidp\SlotLatihanJfpiu;
use app\models\myidp\KehadiranJfpiu;
use app\models\myidp\Peserta;
use app\models\myidp\PesertaImport;
use app\models\myidp\PesertaSearch;
use app\models\myidp\RptStatistikIdp;
use app\models\myidp\RptStatistikIdpV2;
use app\models\myidp\RptStatistikIdpLama; //Santi punya
use app\models\myidp\Kategori; //ref table
use app\models\myidp\PenetapanAksesSearch;
use app\models\myidp\AdminJfpiu;
use app\models\myidp\AdminJfpiuSearch;
use app\models\myidp\Penceramah;
use app\models\hronline\Tblrscosandangan;
use app\models\myidp\RefSenaraiLaporan;
use app\models\myidp\VCpdSenaraiLatihan;
use app\models\myidp\SuratKursusLuar;
use app\models\hronline\TblPenempatan;
use app\models\myidp\PendingTask;
use app\models\myidp\PendingTaskSearch;
use app\models\myidp\UrusetiaLatihan;
use kartik\mpdf\Pdf;
use tebazil\runner\ConsoleCommandRunner;

class IdpDeptController extends \yii\web\Controller
{

    public function init()
    {
        parent::init();
        $this->viewPath = '@app/views/idp';
    }

    public function actionCreateLatihan()
    {
        $kursus = new KursusLatihan();
        $siriLatihan = new SiriLatihan();

        $userID = Yii::$app->user->getId();

        $modelBio = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();

        $modelDept = Department::find()->where(['id' => $modelBio->DeptId])->one();

        if ($modelDept) {
            $kursus->unitBertanggungjawab = $modelDept->shortname;
        } 

        $kursus->jenisLatihanID = 'latihanDalaman';
        $kursus->statusKursusLatihan = 'AKTIF';
        $kursus->dept_ID = $modelBio->DeptId;

        if ($kursus->load(Yii::$app->request->post()) && $kursus->save()) {

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya daftar kursus baru!']);
            return $this->redirect(['view-senarai-latihan']); 
        }

        return $this->render('create_latihan', [
            'model' => $kursus,
            'model2' => $siriLatihan,
        ]);
    }

    public function actionViewSenaraiLatihan()
    {

        $userID = Yii::$app->user->getId();

        $modelBio = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();

        $searchModel = new KursusLatihanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['dept_ID' => $modelBio->DeptId]);

        return $this->render('view_senarai_latihan_2', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewSenaraiLatihanLive()
    {
        $today = date('Y-m-d');
        
        $userID = Yii::$app->user->getId();

        $modelBio = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();

        $siriLatihan = SiriLatihan::find()->where(['statusSiriLatihan' => 'ACTIVE'])->all();
        //->where("tarikhMula = $today")
        foreach ($siriLatihan as $siriLatihan) {
            if ($siriLatihan->tarikhMula == $today) {
                $siriLatihan->statusSiriLatihan = "SEDANG BERJALAN";
                $siriLatihan->save(false);
            }
        }

        $searchModel = new SiriLatihanLive();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['dept_ID' => $modelBio->DeptId]);

        return $this->render('view_senarai_latihan_live', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewLatihan($id)
    {
        return $this->render('view_latihan', [
            'model' => $this->findModelLatihan($id),
        ]);
    }

    

    public function actionDeleteLatihan($id)
    {
        $model = $this->findModelLatihan($id);

        $model->statusKursusLatihan = 'TIDAK AKTIF';

        if ($model->save()) {

            $modelSiri = SiriLatihan::find()->where(['kursusLatihanID' => $id])->all();

            if ($modelSiri) {
                foreach ($modelSiri as $siri) {
                    $siri->statusSiriLatihan = 'INACTIVE';
                    $siri->save(false);
                }
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapus data']);
        }

        return $this->redirect(['view-senarai-latihan']);
    }

    public function actionUpdateLatihan($id)
    {
        $model = $this->findModelLatihan($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]); //selepas 'UPDATE' dan SUBMIT dia akan pergi page 'view'
            return $this->redirect(['view-latihan', 'id' => $model->kursusLatihanID]);
        }

        return $this->render('update_latihan', [
            'model' => $model,
        ]);
    }

    public function actionFormTambahSiri($id)
    {
        $model = KursusLatihan::find()->where(['kursusLatihanID' => $id])->one();

        $query = SiriLatihan::find()->where(['kursusLatihanID' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('form_tambah_siri', [
            'modelLatihan' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTambahsiri($id)
    {
        $modelSiriLatihan = new SiriLatihan();
        //        $modelSiriLatihan->kursusLatihanID = $id;

        $allStaf = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname');

        if (Yii::$app->request->post('submit') == 1) {
            if ($modelSiriLatihan->load(Yii::$app->request->post()) && $modelSiriLatihan->save()) {

                if (Yii::$app->request->post('momo') != NULL) {

                    $selection = Yii::$app->request->post('momo');

                    foreach ($selection as $idp) {

                        $modelCeramah = new Ceramah();
                        $modelCeramah->siriLatihanID = $modelSiriLatihan->siriLatihanID;
                        $modelCeramah->penceramahID = $idp;
                        $modelCeramah->jenis = '1';
                        $modelCeramah->save(false);
                    }
                }

                if (Yii::$app->request->post('addPenceramahLuar') != NULL) {

                    $selection2 = Yii::$app->request->post('addPenceramahLuar');

                    foreach ($selection2 as $idp) {

                        $modelCeramah = new Ceramah();
                        $modelCeramah->siriLatihanID = $modelSiriLatihan->siriLatihanID;
                        $modelCeramah->penceramahID = $idp;
                        $modelCeramah->jenis = '2';
                        $modelCeramah->save(false);
                    }
                }
                /*** Skip this step during MCO ***/
                //            //get 'tarikh sandangan bagi gred terkini' from database
                //            //function date_create() return a new DateTime object - if omitted, the date will be read as a string - DKW
                //            $datetime1 = date_create($modelSiriLatihan->tarikhMula);
                //            $datetime2 = date_create($modelSiriLatihan->tarikhAkhir);
                //
                //            //date_diff() function calculate the difference two dates
                //            $dateDuration = date_diff($datetime1, $datetime2);
                //
                //            //format the date difference
                //            $dateDuration2 = $dateDuration->format('%a');
                //
                //            //echo $dateDuration;
                //            //echo $dateDuration2;
                //
                //            $i = 1;
                //            $jumlahJamLatihan = 0;
                //
                //            while ($i <= ($dateDuration2 + 1) * 2) {
                //
                ////                var_dump('a');
                ////                die;
                //
                //                $slotLatihan = new SlotLatihan();
                //                $slotLatihan->siriLatihanID = $modelSiriLatihan->siriLatihanID;
                //                $slotLatihan->slot = $i;
                //                $slotLatihan->mataSlot = 3;
                ////                if ($slotLatihan->save()){
                ////                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                ////                } else {
                ////                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                ////                }
                //
                //                if ($slotLatihan->save()) {
                //
                //                    $jumlahJamLatihan = $jumlahJamLatihan + 3;
                //                    $modelSiriLatihan->jumlahJamLatihan = $jumlahJamLatihan;
                //                    $modelSiriLatihan->jumlahMataIDP = $jumlahJamLatihan;
                //                    $modelSiriLatihan->save(false);
                //
                //                    if ($i == ($dateDuration2 + 1) * 2) {
                //                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                //                        return $this->redirect(['form-tambah-siri?id=' . $id]);
                //                    }
                //                } else {
                //                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                //                    return $this->redirect(['tambahsiri?id=' . $id]);
                //                }
                //
                //                $i++;
                //            }

                /********************************************************************/
                /**** new calculation for MCO only ****/

                $slotLatihan = new SlotLatihan();
                $slotLatihan->siriLatihanID = $modelSiriLatihan->siriLatihanID;
                $slotLatihan->slot = 1;
                $slotLatihan->mataSlot = 6;

                if ($slotLatihan->save(false)) {

                    $jumlahJamLatihan = 2;
                    $modelSiriLatihan->jumlahJamLatihan = $jumlahJamLatihan;
                    $modelSiriLatihan->jumlahMataIDP = 6;
                    $modelSiriLatihan->save(false);

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                    return $this->redirect(['form-tambah-siri?id=' . $id]);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                    return $this->redirect(['tambahsiri?id=' . $id]);
                }
            }
        }

        $model2 = new Penceramah();
        if (Yii::$app->request->post('submit') == 2) {
            if ($model2->load(Yii::$app->request->post())) {
                if ($model2->save(false)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya ditambah!']);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Tidak berjaya ditambah!']);
                }
            }
        }

        // non-ajax - render the grid by default
        return $this->render('tambahsiri', [
            'model2' => $model2,
            'modelSiriLatihan' => $modelSiriLatihan,
            'allStaf' => $allStaf,
            'id' => $id,
            'allPenceramahLuar' => ArrayHelper::map(Penceramah::find()->all(), 'penceramah_id', 'penceramah_name'),
        ]);
    }

    public function actionUpdateSiri($id)
    {
        $modelSiriLatihan = $this->findModelSiriLatihan($id);

        //        if ($modelSiriLatihan->load(Yii::$app->request->post()) && $modelSiriLatihan->save()) {
        //            //return $this->redirect(['view', 'id' => $model->id]); //selepas 'UPDATE' dan SUBMIT dia akan pergi page 'view'
        //            return $this->redirect(['form-tambah-siri', 'id' => $modelSiriLatihan->kursusLatihanID]);
        //            //return $this->redirect(Yii::$app->request->referrer);
        //
        //        }

        /** for status changes **/
        $previousStatus = 0;
        $newStatus = 0;

        if ($modelSiriLatihan->statusSiriLatihan == 'ACTIVE') {

            $previousStatus = 1;
            $newStatus = 1;
        }

        /** for date changes **/

        $previousDate = date_create($modelSiriLatihan->tarikhMula);

        if ($modelSiriLatihan->load(Yii::$app->request->post())) {

            //            if($modelSiriLatihan->tarikhMula == date('Y-m-d')){
            //                $modelSiriLatihan->statusSiriLatihan = "SEDANG BERJALAN";
            //            } else {
            //                $modelSiriLatihan->statusSiriLatihan = "AKTIF";
            //            }

            if ($modelSiriLatihan->save(false)) {

                /** notifications if kursus ditunda **/

                if (
                    $modelSiriLatihan->statusSiriLatihan == 'DITANGGUHKAN'
                    && $previousStatus == 1
                ) {

                    $previousStatus = 1;
                    $newStatus = 2;
                }

                if ($previousStatus == 1 && $newStatus == 2) {

                    $modelSiri = PermohonanLatihan::find()
                        ->where(['siriLatihanID' => $modelSiriLatihan->siriLatihanID])
                        ->all();

                    foreach ($modelSiri as $modelSirix) {

                        $this->notifikasi($modelSirix->staffID, "Harap maaf, kursus " . strtoupper($modelSirix->sasaran3->tajukLatihan) . " telah ditangguhkan ke tarikh baru yang akan diberitahu kemudian." . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));
                    }
                }

                $newDate = date_create($modelSiriLatihan->tarikhMula);

                if ($previousDate != $newDate) {

                    $modelSiri = PermohonanLatihan::find()
                        ->where(['siriLatihanID' => $modelSiriLatihan->siriLatihanID])
                        ->all();

                    foreach ($modelSiri as $modelSirix) {

                        $this->notifikasi($modelSirix->staffID, "Harap maaf, kursus " . strtoupper($modelSirix->sasaran3->tajukLatihan) . " telah ditukar ke tarikh baru iaitu " . \Yii::$app->formatter->asDate($modelSirix->sasaran6->tarikhMula, 'php:d-m-Y') . '.' . Html::a(' <i class="fa fa-arrow-right"></i> PAPAR', ['idp/view-senarai-permohonan'], ['class' => 'btn btn-success btn-sm']));
                    }
                }




                /***************************************/

                if (Yii::$app->request->post('momo') != NULL) {

                    $selection = Yii::$app->request->post('momo');

                    var_dump($selection);
                    //die();

                    Ceramah::deleteAll(['siriLatihanID' => $id]);

                    foreach ($selection as $idp) {

                        $checkPenceramah = Ceramah::find()
                            ->where(['penceramahID' => $idp])
                            ->andWhere(['siriLatihanID' => $modelSiriLatihan->siriLatihanID])
                            ->one();

                        if (!$checkPenceramah) {
                            $modelCeramah = new Ceramah();
                            $modelCeramah->siriLatihanID = $modelSiriLatihan->siriLatihanID;
                            $modelCeramah->penceramahID = $idp;
                            $modelCeramah->save(false);
                        }
                    }
                }
            }
            /** skip this step during MCO **/
            //            //get 'tarikh sandangan bagi gred terkini' from database
            //            //function date_create() return a new DateTime object - if omitted, the date will be read as a string - DKW
            //            $datetime1 = date_create($modelSiriLatihan->tarikhMula);
            //            $datetime2 = date_create($modelSiriLatihan->tarikhAkhir);
            //
            //            //date_diff() function calculate the difference two dates
            //            $dateDuration = date_diff($datetime1, $datetime2);
            //
            //            //format the date difference
            //            $dateDuration2 = $dateDuration->format('%a');
            //
            //            //echo $dateDuration;
            //            //echo $dateDuration2;
            //
            //            $i = 1;
            //            $jumlahJamLatihan = 0;
            //
            //            while ($i <= ($dateDuration2 + 1) * 2) {
            //
            ////                var_dump('a');
            ////                die;
            //
            //                $slotLatihan = new SlotLatihan();
            //                $slotLatihan->siriLatihanID = $modelSiriLatihan->siriLatihanID;
            //                $slotLatihan->slot = $i;
            //                $slotLatihan->mataSlot = 3;
            ////                if ($slotLatihan->save()){
            ////                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
            ////                } else {
            ////                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
            ////                }
            //
            //                if ($slotLatihan->save()) {
            //
            //                    $jumlahJamLatihan = $jumlahJamLatihan + 3;
            //                    $modelSiriLatihan->jumlahJamLatihan = $jumlahJamLatihan;
            //                    $modelSiriLatihan->jumlahMataIDP = $jumlahJamLatihan;
            //                    $modelSiriLatihan->save(false);
            //                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
            //                } else {
            //                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
            //                }
            //
            //                $i++;
            //            }

            /**** new calculation for MCO only ****/

            $slotLatihan = new SlotLatihan();
            $slotLatihan->siriLatihanID = $modelSiriLatihan->siriLatihanID;
            $slotLatihan->slot = 1;
            $slotLatihan->mataSlot = 6;

            if ($slotLatihan->save(false)) {

                $jumlahJamLatihan = 2;
                $modelSiriLatihan->jumlahJamLatihan = $jumlahJamLatihan;
                $modelSiriLatihan->jumlahMataIDP = 6;
                $modelSiriLatihan->save(false);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                return $this->redirect(['form-tambah-siri?id=' . $modelSiriLatihan->kursusLatihanID]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'danger', 'msg' => 'TIDAK BERJAYA']);
                return $this->redirect(['form-tambah-siri?id=' . $modelSiriLatihan->kursusLatihanID]);
            }

            //return $this->redirect(['form-tambah-siri', 'id' => $modelSiriLatihan->kursusLatihanID]);
        }

        return $this->render('update_siri', [
            'modelSiriLatihan' => $modelSiriLatihan,
            'allStaf' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm', 'department.fullname'),
            'penceramah' => ArrayHelper::map(Ceramah::find()->where(['siriLatihanID' => $modelSiriLatihan->siriLatihanID, 'jenis' => '1'])->all(), 'penceramahID', 'penceramahID'),
            //'penceramahluar' => ArrayHelper::map(Ceramah::find()->where(['siriLatihanID' => $modelSiriLatihan->siriLatihanID, 'jenis' => '2'])->all(), 'penceramahID', 'penceramahID'),
        ]);

        //return $this->render('index', ['time' => date('H:i:s')]);
    }

    public function actionDeleteSiri($id)
    {
        $findSlot = SlotLatihan::find()->where(['siriLatihanID' => $id])->all();
        $findPermohonan = PermohonanLatihan::find()->where(['siriLatihanID' => $id])->all();

        if ($this->findModelSiriLatihan($id)->delete()) {

            foreach ($findSlot as $id) {

                $this->findModelSlotLatihan($id->slotID)->delete();
            }

            foreach ($findPermohonan as $id) {

                $this->findModelPermohonanLatihan3($id->siriLatihanID)->delete();
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya hapus data']);
        }

        return $this->redirect(Yii::$app->request->referrer);

        //return $this->redirect(['view-senarai-latihan']);
    }

    public function actionViewSenaraiJawatan($id)
    {
        //find kursus from VIdpSenaraiKursus that have value '$id'
        $modelLatihan = $this->findModelSiriLatihan($id);

        $query = KursusSasaran::find()->where(['siriLatihanID' => $id])->orderBy(['sasaranID' => SORT_DESC]);
        $dataProviderK = new ActiveDataProvider([
            'query' => $query,
        ]);

        //this two lines of codes are for gridview
        $searchModel = new IdpGredJawatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //the codes below are for when the form is submitted
        //$kursusSasaran = new VIdpKursusSasaran();
        $kursusSasaran = new KursusSasaran();

        if ((array) Yii::$app->request->get('momo')) {

            $selection = (array) Yii::$app->request->get('momo');

            //        var_dump($selection);
            //        die();
            //foreach ($selection as $id) {
            //the codes below are for when the form is submitted
            //$kursusSasaran = new KursusSasaran();

            if ($kursusSasaran->load(Yii::$app->request->get())) {

                foreach ($selection as $selectionn) {

                    //var_dump($selectionn);
                    //die();
                    //\yii\helpers\VarDumper::dump($kursusSasaran,10,true);
                    //$kursusSasaran->gredJawatanID = $id;
                    //\yii\helpers\VarDumper::dump($kursusSasaran,10,true);
                    //                return $this->render('view_senarai_jawatan', [
                    //                'searchModel' => $searchModel,
                    //                'dataProvider' => $dataProvider,
                    //                'kursusSasaran' => $kursusSasaran,
                    //                'modelLatihan' => $modelLatihan,
                    //                ]);

                    if ($kursusSasaran->tahap == '4') {

                        for ($i = 1; $i <= 3; $i++) {

                            $checkSasaran = KursusSasaran::find()
                                ->where(['siriLatihanID' => $modelLatihan->siriLatihanID])
                                ->andWhere(['gredJawatanID' => $selectionn])
                                ->andWhere(['tahap' => $i])
                                ->one();

                            if (!$checkSasaran) {

                                $kursusSasaran2 = new KursusSasaran();
                                $kursusSasaran2->gredJawatanID = $selectionn;
                                $kursusSasaran2->tahap = $i;
                                $kursusSasaran2->siriLatihanID = $modelLatihan->siriLatihanID;
                                $kursusSasaran2->kategoriKursusID = $kursusSasaran->kategoriKursusID;
                                $kursusSasaran2->save(false);
                            }

                            //                        $kursusSasaran2 = new KursusSasaran();
                            //                        $kursusSasaran2->gredJawatanID = $id;
                            //                        $kursusSasaran2->tahap = $i;
                            //                        $kursusSasaran2->siriLatihanID = $kursusSasaran->siriLatihanID;
                            //                        $kursusSasaran2->kategoriKursusID = $kursusSasaran->kategoriKursusID;
                            //                        $kursusSasaran2->save(false);
                        }

                        //return $this->redirect(['view-senarai-jawatan?id='.$kursusSasaran2->siriLatihanID]);
                    } else {

                        //var_dump($selectionn);
                        //die();

                        $checkSasaran = KursusSasaran::find()
                            ->where(['siriLatihanID' => $modelLatihan->siriLatihanID])
                            ->andWhere(['gredJawatanID' => $selectionn])
                            ->andWhere(['tahap' => $kursusSasaran->tahap])
                            ->count();

                        //var_dump($checkSasaran);

                        if (!$checkSasaran) {

                            //var_dump($selectionn);
                            //die();
                            //                        $kursusSasaran = new KursusSasaran();
                            //                        $kursusSasaran->gredJawatanID = $selectionn;
                            //                        $kursusSasaran->save(false);

                            $kursusSasaran3 = new KursusSasaran();
                            $kursusSasaran3->gredJawatanID = $selectionn;
                            $kursusSasaran3->tahap = $kursusSasaran->tahap;
                            $kursusSasaran3->siriLatihanID = $modelLatihan->siriLatihanID;
                            $kursusSasaran3->kategoriKursusID = $kursusSasaran->kategoriKursusID;
                            $kursusSasaran3->save(false);
                        }

                        //                    if ($kursusSasaran->save(false)) {
                        //
                        //                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                        //                        return $this->redirect(['view-senarai-jawatan?id='.$kursusSasaran->siriLatihanID]);
                        //                        //$kursusSasaran->sasaran_id = $kursusSasaran->sasaran_id + 1;
                        //                        //\yii\helpers\VarDumper::dump($kursusSasaran,10,true);
                        //                    } else {
                        //                        Yii::$app->session->setFlash('alert', ['title' => 'TAK Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                        //                        return $this->redirect(['view-senarai-jawatan?id='.$kursusSasaran->siriLatihanID]);
                        //                    }
                    }
                } //tutup kursusSasaran load
                //            if ($kursusSasaran->save(false) || $kursusSasaran2->save(false)) {
                //
                //                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA']);
                //                        return $this->redirect(['view-senarai-jawatan?id='.$modelLatihan->siriLatihanID]);
                //                        //$kursusSasaran->sasaran_id = $kursusSasaran->sasaran_id + 1;
                //                        //\yii\helpers\VarDumper::dump($kursusSasaran,10,true);
                //            }
            } //tutup foreach
            return $this->redirect(['view-senarai-jawatan?id=' . $id]);
        }

        /*         * ********************************* Code below is enough for filter model **************************** */

        //        $searchModel = new IdpGredJawatanSearch();
        //        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view_senarai_jawatan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'kursusSasaran' => $kursusSasaran,
            'modelLatihan' => $modelLatihan,
            'dataProviderK' => $dataProviderK,
        ]);
    }

    protected function findModelLatihan($id)
    {
        if (($model = KursusLatihan::findOne(['kursusLatihanID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelSiriLatihan($id)
    {
        if (($model = SiriLatihan::findOne(['siriLatihanID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }

    protected function findModelSlotLatihan($id)
    {
        if (($model = SlotLatihan::findOne(['slotID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does does not exist.');
    }




}
