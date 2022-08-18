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
use app\models\e_perkhidmatan\PermitApplication;
use app\models\e_perkhidmatan\PermitApplicationSearch;
use app\models\e_perkhidmatan\RefApp;
use app\models\e_perkhidmatan\RefAppSearch;
use app\models\e_perkhidmatan\TblApp;
use app\models\e_perkhidmatan\TblAppSearch;
use app\models\e_perkhidmatan\TblEvent;
use app\models\e_perkhidmatan\TblEventSearch;
use kartik\mpdf\Pdf;
use tebazil\runner\ConsoleCommandRunner;

class PermitController extends \yii\web\Controller
{
    // public function init()
    // {
    //     parent::init();
    //     $this->viewPath = '@app/views/e-perkhidmatan/permit';
    // }

    public function actionIndex($id)
    {
        $staff_id = Yii::$app->user->getId();

        //var_dump($staff_id);

        // $model = new TblEvent();
        // $searchModel = new TblEventSearch();
        $model_event = TblEvent::find()->where(['event_id' => $id])->one();

        // $query = PermitApplication::find()
        //             ->joinWith('event')
        //             ->where(['staff_id' => $staff_id])
        //             ->orderBy(['entry_date' => SORT_DESC]);

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        // ]);

        $model = new PermitApplication();
        $searchModel = new PermitApplicationSearch();

        // $model->entry_date = date('Y-m-d H:i:s');
        // $model->staff_id = $staff_id;
        // $modelBio = Tblprcobiodata::findOne(['ICNO' => $staff_id]);
        // $model->dept_id = $modelBio->DeptId;
        // $peg_tadbir = TblAccess::findOne(['admin_post' => 1]);
        // $peg_bsm = TblAccess::findOne(['admin_post' => 2]);
        // $file = UploadedFile::getInstance($model, 'file');
        // $file2 = UploadedFile::getInstance($model, 'file2');

        if ($model->load(Yii::$app->request->post())) {

            // $ntf = new Notification();
            // $ntf2 = new Notification();
            // if ($model->save(false)) {

            //     $ntf->staff_id = $peg_tadbir->staff_id; // peg  penyelia perjawatan
            //     $ntf->title = 'Permohonan Kemudahan Atas Talian';
            //     $ntf->content = "Permohonan Elaun Pakaian Panas menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senaraitindakan'], ['class' => 'btn btn-primary btn-sm']);
            //     $ntf->ntf_dt = date('Y-m-d H:i:s');
            //     $ntf->save();


            //     $ntf2->staff_id = $peg_bsm->staff_id; // peg perjawatan
            //     $ntf2->title = 'Permohonan Kemudahan Atas Talian';
            //     $ntf2->content = "Permohonan Elaun Pakaian Panas menunggu tindakan perakuan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senaraitindakan'], ['class' => 'btn btn-primary btn-sm']);
            //     $ntf2->ntf_dt = date('Y-m-d H:i:s');
            //     $ntf2->save();
            // }
            // $this->pendingtask($peg_tadbir->staff_id, 24);
            // $this->pendingtask($peg_bsm->staff_id, 25);
            // $this->notification($model->staff_id, 'Permohonan anda telah dihantar untuk diproses sila semak status permohonan anda.' . Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class' => 'btn btn-primary btn-sm']));
            // Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
            // return $this->redirect(['borang/senarai']);

            $model->event_id = $id;
            $model->date_applied = date('Y-m-d H:i:s');
            $model->app_type = '5';
            // $model->staff_id = $staff_id;
            // $modelBio = Tblprcobiodata::findOne(['ICNO' => $staff_id]);
            // $model->dept_id = $modelBio->DeptId;

            if ($model->save(false)){
                return $this->redirect(Yii::$app->request->referrer);
            }

            // if ($model->save(false)) {

            //     $modelAppType = RefApp::find()->all();

            //     foreach ($modelAppType as $s) {

            //         $modelPermit = new PermitApplication();
            //         $modelPermit->event_id = $model->event_id;
            //         // $modelPermit->app_type = $s->id;
            //         $modelPermit->app_type = '5';
            //         $modelPermit->save(false);
            //     }
            // }
        }
        return $this->render('index', [
            'model' => $model,
            'model_event' => $model_event,
            'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
            'status' => 1,

        ]);
    }

    public function actionSenaraiPermohonan()
    {
        $staff_id = Yii::$app->user->getId();
        $currentYear = date('Y');

        $appModel = PermitApplication::find()
            ->joinWith('event')
            ->where("staff_id = '$staff_id' and SUBSTRING(date_applied,1,4) = $currentYear and app_type = '5'")
            ->orderBy('date_applied');

        $dataProvider = new ActiveDataProvider([
            'query' => $appModel,
        ]);

        return $this->render('senarai', [
            'appModel' => $appModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJenisPermohonan()
    {
        return $this->render('jenis_permohonan');
    }
}
