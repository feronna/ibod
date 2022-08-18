<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\w_letter\TblPermohonan;
use app\models\w_letter\TblPermohonanLama;
use app\models\w_letter\TblPermohonanPpv;
use app\models\w_letter\TblCheckIn;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
use app\models\Notification;
use yii\filters\AccessControl;
use app\models\w_letter\TblAccess;
use app\models\cuti\SetPegawai;
use DateTime;
use yii\web\UploadedFile;
use app\models\umsshield\SelfRisk;

class WLetterController extends Controller {

    /**
     * {@inheritdoc}
     */
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
                'only' => [
                    //pengguna
                    'permohonan','pemohon', 'pemohon-ppv','surat-w',
                    //admin
                    'halaman-bsm', 'carian-bsm', 'surat-w', 'menunggu-perakuan-kj', 'permohonan-ditolak-kj', 'department','department-search','carian-pegawai','set-jadual',
                ],
                'rules' => [
                    [//pengguna
                        'actions' => ['permohonan','pemohon', 'pemohon-ppv','surat-w'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['!=', 'Status', '6'])->one();
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//admin
                        'actions' => ['halaman-bsm', 'carian-bsm', 'surat-w', 'menunggu-perakuan-kj', 'permohonan-ditolak-kj', 'department','department-search','carian-pegawai','set-jadual'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId()]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                ],
            ],
        ];
    }

    protected function ICNO() {
        return Yii::$app->user->getId();
    }

    protected function findPermohonanPpv($id) {
        return TblPermohonanPpv::find()->where(['id' => $id])->one();
    }

    protected function findPermohonanbyId($id) {
        return TblPermohonan::find()->where(['id' => $id])->one();
    }

    protected function findPermohonanbyIdLama($id) {
        return TblPermohonanLama::find()->where(['id' => $id])->one();
    }

    protected function findBiodata($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }

    protected function findCheckIn($ICNO) {
        return TblCheckIn::findAll(['ICNO' => $ICNO]);
    }

    protected function findPermohonan($ICNO) {
        return TblPermohonan::findOne(['ICNO' => $ICNO]);
    }

    protected function findAllPermohonan($ICNO) {
        return TblPermohonan::findAll(['ICNO' => $ICNO]);
    }

    protected function findPermohonanAktif() {
        return TblPermohonan::find()->where(['ICNO' => $this->ICNO()])->andWhere(['status_semasa' => 1])->one();
    }

    protected function findPermohonanTelahDiNotifikasi() {
        return TblPermohonan::find()->Where(['status_notifikasi' => 1])->all();
    }

    public function GridPermohonanTelahDiPerakuVc() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()
                    ->where(['status_semasa' => [2, 3, 4]])
                    ->andWhere(['IN', 'ICNO', $this->findAllKetuaJabatan()]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanTelahDiPerakuKj() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()
                    ->where(['wl_tbl_permohonan.status_semasa' => [2, 3, 4]])
                    ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                    ->leftJoin('hronline.department', 'tblprcobiodata.DeptId = department.id')
                    ->andWhere(['department.chief' => Yii::$app->user->getId()])
                    ->andWhere(['!=', 'wl_tbl_permohonan.ICNO', Yii::$app->user->getId()]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function GridKakitanganBertugas() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['status_semasa' => [3]])
                    ->andWhere(['AND', ['>=', 'StartDate', date("Y-m-d")], ['<=', 'EndDate', date("Y-m-d")]]),
            'pagination' => [
                'pageSize' => 40,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanTelahDiPerakuV() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()
                    ->where(['status_semasa' => [2, 3, 4]])
                    ->joinWith('setpegawai')
                    ->andWhere(['!=', 'ICNO', Yii::$app->user->getId()]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanTelahDiPerakuBSM() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()->Where(['IN', 'approved_bsm_status', [1, 2]]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanTelahDiNotifikasibyDate($date) {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()->Where(['status_notifikasi' => 1])->andWhere(['DATE_FORMAT(tarikh_mohon, "%m-%Y")' => $date]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridCarianPermohonan($icno) {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['ICNO' => $icno]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionSuratW($title, $id) {
        $layout = 'p_w_letter';
        if ($title == 'Baru') {
            $permohonan = $this->findPermohonanbyId($id);
        } elseif ($title == 'Lama') {
            $permohonan = $this->findPermohonanbyIdLama($id);
        } elseif ($title == 'Ppv') {
            $layout = 'p_w_ppv_letter';
            $permohonan = $this->findPermohonanPpv($id);
        }
        $css = file_get_contents('./css/esurat.css');

        $content = $this->renderPartial($layout, ['permohonan' => $permohonan, 'title' => $title]);

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
            'options' => ['title' => ''],
            // call mPDF methods on the fly
            'marginTop' => 35,
            'marginLeft' => 24,
            'marginRight' => 24,
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => [''],
                'WriteHTML' => [$css, 1]
            ]
        ]);

        return $pdf->render();
    }

    public function actionPemohon() {
        $permohonan = TblPermohonan::find()->where(['ICNO' => $this->ICNO()])->orderBy(['StartDate' => SORT_DESC])->limit(10)->all();
        $permohonanLama = TblPermohonanLama::find()->where(['ICNO' => $this->ICNO()])->orderBy(['StartDate' => SORT_DESC])->limit(10)->all();

        return $this->render('p_main', [
                    'permohonan' => $permohonan,
                    'permohonanLama' => $permohonanLama,
        ]);
    }

    public function actionPemohonPpv() {
        $permohonan = TblPermohonanPpv::find()->where(['ICNO' => $this->ICNO()])->orderBy(['StartDate' => SORT_DESC])->limit(10)->all();

        return $this->render('p_main_ppv', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionAllSurat() {
        $permohonan = TblPermohonan::find()->where(['ICNO' => $this->ICNO()])->orderBy(['StartDate' => SORT_DESC])->all();

        return $this->render('p_main_all', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionAllSuratPpv() {
        $permohonan = TblPermohonanPpv::find()->where(['ICNO' => $this->ICNO()])->orderBy(['StartDate' => SORT_DESC])->all();

        return $this->render('p_main_ppv_all', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function checkInActiveApplication() {
        $permohonan = TblPermohonan::find()->where(['ICNO' => $this->ICNO()])->andWhere(['OR', ['IS', 'approved_kj_by', NULL], ['IS', 'approved_bsm_by', NULL]])->andWhere(['IS', 'auto', NULL])->all();

        foreach ($permohonan as $permohonan) {

            $datetime1 = new DateTime($permohonan->StartDate);
            $datetime2 = new DateTIme('now');

            if ($datetime2 > $datetime1) {
                if ($permohonan->approved_kj_status == NULL) {
                    $permohonan->approved_kj_ulasan = "AUTO-REJECT";
                    $permohonan->approved_kj_at = date("Y-m-d H:i:s");
                    $permohonan->approved_kj_status = 2;
                }
                if ($permohonan->approved_bsm_status == NULL) {
                    $permohonan->approved_bsm_ulasan = "AUTO-REJECT";
                    $permohonan->approved_bsm_at = date("Y-m-d H:i:s");
                    $permohonan->approved_bsm_status = 2;
                }
                $permohonan->status_semasa = 4;
                $permohonan->isActive = 0;
                $permohonan->auto = 2;
                $permohonan->status_notifikasi = 1;
                $permohonan->tarikh_notifikasi = date("Y-m-d H:i:s");

                $content = 'Surat Kebenaran Bekerja (COVID-19). Maaf Permohonan mendapatkan surat kebenaran bekerja ditolak. Sila semak status permohonan <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                $this->notifikasi($permohonan->ICNO, $content);
                $permohonan->save(false);
            }
        }
    }

    public function actionPermohonan() {
        $data = SelfRisk::find()->where(['icno' => $this->ICNO()])->orderBy(['assessmentTaken' => SORT_DESC])->One();
        if ($data) {
            if (($data->riskGroupId == 4) || ($data->riskGroupId == 6)) {

                $biodata = $this->findBiodata($this->ICNO());
                $kj = Department::findOne(['id' => $biodata->DeptId]);
                $p = SetPegawai::findOne(['pemohon_icno' => $kj->chief]);
                $permohonan = new TblPermohonan();
                if ($permohonan->load(Yii::$app->request->post())) {

                    $permohonan->EndDate = $permohonan->StartDate;

                    $existWFO = TblPermohonan::findOne(['ICNO' => $this->ICNO(), 'StartDate' => $permohonan->StartDate]);

                    if ($existWFO) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Tarikh surat kebenaran bekerja telah dimohon. Sila jana surat kebenaran bekerja.']);
                        return $this->redirect(['pemohon']);
                    } else {
                        if ($kj->chief == $this->ICNO()) { // noti pelulus
                            $content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/halaman-pelulus">disini</a>';
                            $this->notifikasi($p->pelulus_icno, $content);
                        } else { //noti kj
                            $content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/halaman-kj">disini</a>';
                            $this->notifikasi($kj->chief, $content);
                        }

                        if ($permohonan->veh_status) {
                            if ($permohonan->veh_ulasan) {
                                $permohonan->veh_file = UploadedFile::getInstance($permohonan, 'file');
                                if ($permohonan->veh_file) {
                                    $res = Yii::$app->FileManager->UploadFile($permohonan->veh_file->name, $permohonan->veh_file->tempName, '04', 'eSurat');
                                    if ($res->status == true) {
                                        $permohonan->veh_file = $res->file_name_hashcode;
                                    }
                                }
                                $permohonan->save(false);
                                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dihantar!', 'type' => 'success', 'msg' => 'Permohonan berjaya dihantar kepada ketua jabatan.']);
                                return $this->redirect(['pemohon']);
                            } else {
                                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Maaf sila lengkapkan alasan anda.']);
                                return $this->redirect(['permohonan']);
                            }
                        } else {
                            if ($permohonan->StartDate) {
                                $permohonan->save(false);
                                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dihantar!', 'type' => 'success', 'msg' => 'Permohonan berjaya dihantar kepada ketua jabatan.']);
                                return $this->redirect(['pemohon']);
                            } else {
                                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Maaf sila isi tarikh bertugas.']);
                                return $this->redirect(['permohonan']);
                            }
                        }
                    }
                }

                return $this->render('p_permohonan', [
                            'model' => $biodata,
                            'permohonan' => $permohonan,
                ]);
            } else { // rekod kad hijau/merah
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Status ums shields berstatus MERAH, anda tidak dibenarkan untuk membuat permohonan.']);
                return $this->redirect(['pemohon']);
            }
        } else { //tiada rekod shields
            Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Anda belum mengisi kaji selidik UMS Shields.']);
            return $this->redirect(['pemohon']);
        }
    }

    public function notifikasi($icno, $content) {
        //--------Model Notification-----------//
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $icno;
        $ntf->title = 'WLetter';
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        //--------Model Notification-----------//
    }

    public function actionDetailPermohonan($id) {

        $permohonan = $this->findPermohonanbyId($id);

        return $this->renderAjax('a_pemohon_detail', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function GridPermohonanStatusDiterima() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()
                    ->where(['wl_tbl_permohonan.status_semasa' => 1])
                    ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                    ->leftJoin('hronline.department', 'tblprcobiodata.DeptId = department.id')
                    ->andWhere(['department.chief' => Yii::$app->user->getId()])
                    ->andWhere(['!=', 'wl_tbl_permohonan.ICNO', Yii::$app->user->getId()]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanStatusDiterimaV() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()
                    ->where(['status_semasa' => 1])
                    ->joinWith('setpegawai')
                    ->andWhere(['!=', 'ICNO', Yii::$app->user->getId()]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function findAllKetuaJabatan() {
        $c = Department::find()->all();
        $chief = array();
        foreach ($c as $c) {
            if ($c->id != 34) { // temp for piums
                $chief[] = $c->chief;
            }
        }

        return $chief;
    }

    public function GridPermohonanStatusDiterimaC() {

        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()
                    ->where(['status_semasa' => 1])
                    ->andWhere(['IN', 'ICNO', $this->findAllKetuaJabatan()]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanStatusDiSahkanKj() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['status_semasa' => 2])->andWhere(['approved_kj_status' => 1]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanMenungguPerakuanKj() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['IS', 'approved_kj_status', NULL])->andWhere(['status_semasa' => 1]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanStatusDiTolakKj() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['status_semasa' => 4])->andWhere(['approved_kj_status' => 2]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function actionHalamanKj() {

        $permohonan = $this->GridPermohonanStatusDiterima();

        return $this->render('a_main', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionSahkanKj($id) {

        $permohonan = TblPermohonan::findOne(['id' => $id]);
        $permohonan->status_semasa = 2; //menunggu perakuan bsm
        $bsm = TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['level' => 2])->all();

        if ($permohonan->load(Yii::$app->request->post())) {
            if ($permohonan->approved_kj_ulasan) {
                if ($permohonan->approved_kj_status) {
                    if ($permohonan->approved_kj_status == 1) {
                        foreach ($bsm as $bsm) {
                            $content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                            $this->notifikasi($bsm->ICNO, $content);
                        }
                    } else if ($permohonan->approved_kj_status == 2) {
                        $content = 'Surat Kebenaran Bekerja (COVID-19). Maaf Permohonan mendapatkan surat kebenaran bekerja ditolak. Sila semak status permohonan <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                        $permohonan->status_semasa = 4;
                        $this->notifikasi($permohonan->ICNO, $content);
                    }
                    $permohonan->save(false);
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
                    return $this->redirect(['halaman-kj']);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan ulasan dan status permohonan.']);
            }
        }

        return $this->render('a_sahkan_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionSahkanSemuaKj() {
        $bsm = TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['level' => 2])->all();
        $permohonan = new TblPermohonan();

        if ($permohonan->load(Yii::$app->request->post())) {
            $model = TblPermohonan::find()
                            ->where(['wl_tbl_permohonan.status_semasa' => 1])
                            ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                            ->leftJoin('hronline.department', 'tblprcobiodata.DeptId = department.id')
                            ->andWhere(['department.chief' => Yii::$app->user->getId()])
                            ->andWhere(['!=', 'wl_tbl_permohonan.ICNO', Yii::$app->user->getId()])->all();
            foreach ($model as $model) {
                $model->status_semasa = 2;
                $model->approved_kj_at = date("Y-m-d H:i:s");
                $model->approved_kj_by = Yii::$app->user->getId();
                $model->approved_kj_ulasan = $permohonan->approved_kj_ulasan;
                $model->approved_kj_status = 1;
                $model->save(false);
            }
            foreach ($bsm as $bsm) {
                $content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/halaman-bsm">disini</a>';
                $this->notifikasi($bsm->ICNO, $content);
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
            return $this->redirect(['halaman-kj']);
        }

        return $this->render('a_sahkanAll_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionCarianKj() {

        $permohonan = $this->GridPermohonanTelahDiPerakuKj();
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-kj', 'icno' => $search->ICNO]);
        }

        return $this->render('a_carian_permohonan', [
                    'permohonan' => $permohonan,
                    'search' => $search,
        ]);
    }

    public function actionCarianPermohonanKj($icno) {

        $permohonan = $this->GridCarianPermohonan($icno);
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-kj', 'icno' => $search->ICNO]);
        }

        return $this->render('a_carian_permohonan', [
                    'permohonan' => $permohonan,
                    'search' => $search,
                    'icno' => $icno,
        ]);
    }

    public function actionKakitanganBertugas() {

        $permohonan = $this->GridKakitanganBertugas();
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-kakitangan-bertugas', 'icno' => $search->ICNO]);
        }

        return $this->render('a_kakitangan_bertugas', [
                    'permohonan' => $permohonan,
                    'search' => $search,
        ]);
    }

    public function actionCarianKakitanganBertugas($icno) {

        $permohonan = $this->GridCarianPermohonan($icno);
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-bertugas', 'icno' => $search->ICNO]);
        }

        return $this->render('a_kakitangan_bertugas', [
                    'permohonan' => $permohonan,
                    'search' => $search,
                    'icno' => $icno,
        ]);
    }

    public function actionHalamanPelulus() {

        $permohonan = $this->GridPermohonanStatusDiterimaV();

        return $this->render('v_main', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionSahkanV($id) {

        $permohonan = TblPermohonan::findOne(['id' => $id]);
        $permohonan->status_semasa = 2; //menunggu perakuan bsm
        $bsm = TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['level' => 2])->all();

        if ($permohonan->load(Yii::$app->request->post())) {
            foreach ($bsm as $bsm) {
                $content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                $this->notifikasi($bsm->ICNO, $content);
            }
            if ($permohonan->approved_kj_status == 2) {
                $content = 'Surat Kebenaran Bekerja (COVID-19). Maaf Permohonan mendapatkan surat kebenaran bekerja ditolak. Sila semak status permohonan <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                $permohonan->status_semasa = 4;
                $this->notifikasi($permohonan->ICNO, $content);
            }
            $permohonan->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
            return $this->redirect(['halaman-pelulus']);
        }

        return $this->render('v_sahkan_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionSahkanSemuaV() {
        $bsm = TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['level' => 2])->all();
        $permohonan = new TblPermohonan();

        if ($permohonan->load(Yii::$app->request->post())) {
            $model = TblPermohonan::find()
                            ->where(['status_semasa' => 1])
                            ->joinWith('setpegawai')
                            ->andWhere(['!=', 'ICNO', Yii::$app->user->getId()])->all();
            foreach ($model as $model) {
                $model->status_semasa = 2;
                $model->approved_kj_at = date("Y-m-d H:i:s");
                $model->approved_kj_by = Yii::$app->user->getId();
                $model->approved_kj_ulasan = $permohonan->approved_kj_ulasan;
                $model->approved_kj_status = 1;
                $model->save(false);
            }
            foreach ($bsm as $bsm) {
                $content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/halaman-bsm">disini</a>';
                $this->notifikasi($bsm->ICNO, $content);
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
            return $this->redirect(['halaman-v']);
        }

        return $this->render('v_sahkanAll_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionCarianV() {

        $permohonan = $this->GridPermohonanTelahDiPerakuV();
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-v', 'icno' => $search->ICNO]);
        }

        return $this->render('v_carian_permohonan', [
                    'permohonan' => $permohonan,
                    'search' => $search,
        ]);
    }

    public function actionCarianPermohonanV($icno) {

        $permohonan = $this->GridCarianPermohonan($icno);
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-v', 'icno' => $search->ICNO]);
        }

        return $this->render('v_carian_permohonan', [
                    'permohonan' => $permohonan,
                    'search' => $search,
                    'icno' => $icno,
        ]);
    }

    public function actionSahkanPelulus($id) {

        $permohonan = TblPermohonan::findOne(['id' => $id]);
        $permohonan->status_semasa = 2; //menunggu perakuan bsm
        $bsm = TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['level' => 2])->all();

        if ($permohonan->load(Yii::$app->request->post())) {
            if ($permohonan->approved_kj_status == 1) {
                foreach ($bsm as $bsm) {
                    $content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                    $this->notifikasi($bsm->ICNO, $content);
                }
            } else if ($permohonan->approved_kj_status == 2) {
                $content = 'Surat Kebenaran Bekerja (COVID-19). Maaf Permohonan mendapatkan surat kebenaran bekerja ditolak. Sila semak status permohonan <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                $permohonan->status_semasa = 4;
                $this->notifikasi($permohonan->ICNO, $content);
            }
            $permohonan->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
            return $this->redirect(['halaman-pelulus']);
        }

        return $this->render('v_sahkan_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionHalamanVc() {

        $permohonan = $this->GridPermohonanStatusDiterimaC();

        return $this->render('c_main', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionSahkanVc($id) {

        $permohonan = TblPermohonan::findOne(['id' => $id]);
        $permohonan->status_semasa = 2; //menunggu perakuan bsm
        $bsm = TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['level' => 2])->all();

        if ($permohonan->load(Yii::$app->request->post())) {
            if ($permohonan->approved_kj_ulasan) {
                if ($permohonan->approved_kj_status) {
                    if ($permohonan->approved_kj_status == 1) {
                        foreach ($bsm as $bsm) {
                            $content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                            $this->notifikasi($bsm->ICNO, $content);
                        }
                    } else if ($permohonan->approved_kj_status == 2) {
                        $content = 'Surat Kebenaran Bekerja (COVID-19). Maaf Permohonan mendapatkan surat kebenaran bekerja ditolak. Sila semak status permohonan <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                        $permohonan->status_semasa = 4;
                        $this->notifikasi($permohonan->ICNO, $content);
                    }
                    $permohonan->save(false);
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
                    return $this->redirect(['halaman-vc']);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan ulasan dan status permohonan.']);
            }
        }

        return $this->render('c_sahkan_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionSahkanSemuaVc() {
        $bsm = TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['level' => 2])->all();
        $permohonan = new TblPermohonan();

        if ($permohonan->load(Yii::$app->request->post())) {
            if ($permohonan->approved_kj_ulasan) {
                $model = TblPermohonan::find()
                                ->where(['status_semasa' => 1])
                                ->andWhere(['IN', 'ICNO', $this->findAllKetuaJabatan()])->all();
                foreach ($model as $model) {
                    $model->status_semasa = 2;
                    $model->approved_kj_at = date("Y-m-d H:i:s");
                    $model->approved_kj_by = Yii::$app->user->getId();
                    $model->approved_kj_ulasan = $permohonan->approved_kj_ulasan;
                    $model->approved_kj_status = 1;
                    $model->save(false);
                }
                foreach ($bsm as $bsm) {
                    $content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/halaman-bsm">disini</a>';
                    $this->notifikasi($bsm->ICNO, $content);
                }

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
                return $this->redirect(['halaman-vc']);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila isi ulasan.']);
            }
        }

        return $this->render('c_sahkanAll_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionCarianVc() {

        $permohonan = $this->GridPermohonanTelahDiPerakuVc();
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-vc', 'icno' => $search->ICNO]);
        }

        return $this->render('c_carian_permohonan', [
                    'permohonan' => $permohonan,
                    'search' => $search,
        ]);
    }

    public function actionCarianPermohonanVc($icno) {

        $permohonan = $this->GridCarianPermohonan($icno);
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-vc', 'icno' => $search->ICNO]);
        }

        return $this->render('c_carian_permohonan', [
                    'permohonan' => $permohonan,
                    'search' => $search,
                    'icno' => $icno,
        ]);
    }

    public function actionMenungguPerakuanKj() {

        $permohonan = $this->GridPermohonanMenungguPerakuanKj();

        return $this->render('m_main', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionHalamanBsm() {

        $permohonan = $this->GridPermohonanStatusDiSahkanKj();
        if ($data = Yii::$app->request->post('selection')) {
            $selected = '';
            foreach ($data as $i) {
                $selected .= ',' . $i;
            }
            return $this->redirect(['sahkan-selected-bsm', 'selected' => $selected]);
        }

        return $this->render('b_main', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionSahkanSelectedBsm($selected) {
        $array = explode(",", $selected);

        $model = TblPermohonan::find()->where(['IN', 'id', $array])->all();
        $permohonan = new TblPermohonan();

        if ($permohonan->load(Yii::$app->request->post())) {
            if ($permohonan->approved_bsm_status) {
                if ($permohonan->approved_bsm_ulasan) {

                    foreach ($model as $model) {

                        if ($permohonan->approved_bsm_status == 1) {
                            $model->status_semasa = 3;
                            $content = 'Surat Kebenaran Bekerja (COVID-19). Sila muat turun <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                        } else {
                            $content = 'Surat Kebenaran Bekerja (COVID-19). Maaf Permohonan mendapatkan surat kebenaran bekerja ditolak. Sila semak status permohonan <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                            $model->status_semasa = 4;
                        }

                        $model->tarikh_notifikasi = date("Y-m-d H:i:s");
                        $model->status_notifikasi = 1;
                        $model->approved_bsm_status = $permohonan->approved_bsm_status;
                        $model->approved_bsm_ulasan = $permohonan->approved_bsm_ulasan;
                        $model->approved_bsm_at = $permohonan->approved_bsm_at;
                        $model->approved_bsm_by = $permohonan->approved_bsm_by;
                        $this->notifikasi($model->ICNO, $content);
                        $model->save(false);
                    }

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
                    return $this->redirect(['halaman-bsm']);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila isi ulasan & status permohonan anda.']);
                return $this->redirect(['halaman-bsm']);
            }
        }

        return $this->render('b_sahkan_selected_permohonan', [
                    'permohonan' => $permohonan,
                    'model' => $model,
        ]);
    }

    public function actionPermohonanBsm() {

        $permohonan = new TblPermohonan();
        if ($permohonan->load(Yii::$app->request->post())) {

            $biodata = $this->findBiodata($permohonan->ICNO);
            $kj = Department::findOne(['id' => $biodata->DeptId]);
            $p = SetPegawai::findOne(['pemohon_icno' => $kj->chief]);

            $permohonan->approved_kj_by = $p->pelulus_icno;

            $content = 'Surat Kebenaran Bekerja (COVID-19). Sila muat turun <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
            $this->notifikasi($permohonan->ICNO, $content);
            $permohonan->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Permohonan berjaya diterima dan diperaku.']);
            return $this->redirect(['carian-bsm']);
        }

        return $this->render('b_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionPermohonanDitolakKj() {

        $permohonan = $this->GridPermohonanStatusDiTolakKj();

        return $this->render('b_main_fail', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionSahkanBsm($id) {

        $permohonan = TblPermohonan::findOne(['id' => $id]);

        if ($permohonan->load(Yii::$app->request->post())) {
            if ($permohonan->approved_bsm_status) {
                $permohonan->EndDate = $permohonan->StartDate;
                if ($permohonan->approved_bsm_ulasan) {
                    if ($permohonan->approved_bsm_status == 1) {
                        $permohonan->status_semasa = 3;
                        $content = 'Surat Kebenaran Bekerja (COVID-19). Sila muat turun <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                    } else {
                        $content = 'Surat Kebenaran Bekerja (COVID-19). Maaf Permohonan mendapatkan surat kebenaran bekerja ditolak. Sila semak status permohonan <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                        $permohonan->status_semasa = 4;
                    }
                    $this->notifikasi($permohonan->ICNO, $content);
                    $permohonan->save(false);

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
                    return $this->redirect(['halaman-bsm']);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila isi ulasan anda.']);
                return $this->redirect(['halaman-bsm']);
            }
        }

        return $this->render('b_sahkan_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionSahkanSemuaBsm() {
        $permohonan = new TblPermohonan();

        if ($permohonan->load(Yii::$app->request->post())) {
            $model = TblPermohonan::findAll(['status_semasa' => 2, 'approved_kj_status' => 1]);
            foreach ($model as $model) {
                if ($permohonan->StartDate) { //if ada penukaran dari bsm
                    $model->StartDate = $permohonan->StartDate;
                    $model->EndDate = $permohonan->StartDate;
                }

                $model->status_semasa = 3;
                $model->status_notifikasi = 1;
                $model->tarikh_notifikasi = date("Y-m-d H:i:s");
                $model->approved_bsm_at = date("Y-m-d H:i:s");
                $model->approved_bsm_by = Yii::$app->user->getId();
                $model->approved_bsm_ulasan = $permohonan->approved_bsm_ulasan;
                $model->approved_bsm_status = 1;
                $content = 'Surat Kebenaran Bekerja (COVID-19). Sila muat turun <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                $this->notifikasi($model->ICNO, $content);
                $model->save(false);
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
            return $this->redirect(['halaman-bsm']);
        }

        return $this->render('b_sahkanAll_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionCarianBsm() {

        $permohonan = $this->GridPermohonanTelahDiPerakuBSM();
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-bsm', 'icno' => $search->ICNO]);
        }

        return $this->render('b_carian_permohonan', [
                    'permohonan' => $permohonan,
                    'search' => $search,
        ]);
    }

    public function actionCarianPermohonanBsm($icno) {

        $permohonan = $this->GridCarianPermohonan($icno);
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-bsm', 'icno' => $search->ICNO]);
        }

        return $this->render('b_carian_permohonan', [
                    'permohonan' => $permohonan,
                    'search' => $search,
                    'icno' => $icno,
        ]);
    }

    public function actionManualPengguna() {
        $completePath = Yii::getAlias('@app/web/files/' . 'manual_pengguna_W.pdf');
        return Yii::$app->response->sendFile($completePath, 'manual_pengguna_W.pdf');
    }

    public function actionHalamanKeselamatan() {

        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-keselamatan', 'icno' => $search->ICNO]);
        }

        return $this->render('k_carian_keselamatan', [
                    'permohonan' => null,
                    'search' => $search,
                    'biodata' => null,
//                    'checkIn' => null,
//                    'model' => null,
        ]);
    }

    public function actionCarianKeselamatan($icno) {

        $search = new TblPermohonan();

        $permohonan = $this->findAllPermohonan($icno);
        $biodata = $this->findBiodata($icno);
        $checkIn = $this->findCheckIn($icno);

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-keselamatan', 'icno' => $search->ICNO]);
        }
        return $this->render('k_carian_keselamatan', [
                    'permohonan' => $permohonan,
                    'biodata' => $biodata,
                    'search' => $search,
                    'icno' => $icno,
                    'checkIn' => $checkIn,
        ]);
    }

    public function actionCheckIn($icno) {

        $model = new TblCheckIn();

        $model->ICNO = $icno;
        $model->datetime = date("Y-m-d H:i:s");
        $model->chief = $this->ICNO();
        $model->save();

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
        return $this->redirect(['carian-keselamatan', 'icno' => $icno]);
    }

    public function actionRekodKeselamatan() {

        $permohonan = TblCheckIn::find()->orderBy(['datetime' => SORT_DESC])->all();

        return $this->render('k_rekod_keselamatan', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionStatistic($month) {

//        $department = Department::find()->where(['isActive' => 1])->all();

        $permohonan = TblPermohonan::find()->one();

        return $this->render('statistic_all', [
                    'permohonan' => $permohonan,
//                    'department' => $department,
                    'month' => $month,
        ]);
    }

    public function actionStatisticE($month) {

        $permohonan = TblPermohonan::find()->one();

        return $this->render('statistic_e100', [
                    'permohonan' => $permohonan,
                    'month' => $month,
        ]);
    }

    public function actionStatisticUmskal($month) {

        $permohonan = TblPermohonan::find()->one();

        return $this->render('statistic_umskal', [
                    'permohonan' => $permohonan,
                    'month' => $month,
        ]);
    }

    public function actionImport() {
        $model = new Department();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->cluster) {
                return $this->redirect(['import-jadual', 'dept' => $model->cluster]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila Pilih Jabatan']);
            }
        }

        return $this->render('b_form_import', [
                    'model' => $model,
        ]);
    }

    public function actionImportJadual($dept) {

        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);
        $modelImport->addRule(['fileImport'], 'required');
        $modelImport->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx'], ['maxSize' => 1024 * 1024]);

        if (Yii::$app->request->post()) {
            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');
            if ($modelImport->fileImport && $modelImport->validate()) {
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($modelImport->fileImport->tempName);
                //                var_dump($inputFileType);die;
                $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                //                VarDumper::dump($objReader);die;/
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $baseRow = 2;
                $year = date('Y');
                $month = date('m');
                $dayscount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $column = ['F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ'];

                //                var_dump($dayscount);die;
                while (!empty($sheetData[$baseRow]['A'])) {


                    $i = 0;

                    if ($this->checkumsper($sheetData[$baseRow]['A']) == TRUE) {
                        $user = Tblprcobiodata::findOne(['COOldID' => $sheetData[$baseRow]['A']]);

                        while ($dayscount >= 1) {
                            $model = new TblPermohonan();

                            if ($sheetData[$baseRow][$column[$i]] == 1) {
                                $a = $i + 1;
                                if (strlen($a) == 1) {
                                    $a = '0' . $a;
                                }

                                $model->StartDate = date('Y-m-' . $a);
                                $model->EndDate = date('Y-m-' . $a);

                                $model->ICNO = $user->ICNO;
                                $model->tugas = (string) $sheetData[$baseRow]['E'];
                                $model->tarikh_mohon = date("Y-m-d H:i:s");
                                $model->status_semasa = 1;
                                $model->isActive = 1;
                                $model->save(false);
                            }

                            $dayscount--;
                            $i++;
                        }
                        $dayscount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $baseRow++;
                    }
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jadual Di Muat Naik']);
                return $this->redirect(['jadual', 'dept' => $dept]);
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }

        return $this->render('b_import_jadual', [
                    'model' => $modelImport,
        ]);
    }

    public function checkumsper($id) {
        $user = Tblprcobiodata::findOne(['COOldID' => $id]);

        if ($user) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function actionJadual($dept) {
        $user = Tblprcobiodata::find()->where(['DeptId' => $dept, 'Status' => 1])->groupBy(['CONm'])->all();
        $permohonan = TblPermohonan::find()->one();
        $department = Department::find()->where(['id' => $dept])->One();
        return $this->render('b_jadual', [
                    'user' => $user,
                    'permohonan' => $permohonan,
                    'department' => $department,
        ]);
    }

    public function actionMohonByJabatan($dept) {
        $permohonan = TblPermohonan::find()
                ->where(['wl_tbl_permohonan.status_semasa' => 1])
                ->leftJoin('hronline.tblprcobiodata', 'wl_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
                ->andWhere(['tblprcobiodata.DeptId' => $dept])
                ->all();

        foreach ($permohonan as $model) {
            $model->status_semasa = 3;
            $model->status_notifikasi = 1;
            $model->tarikh_notifikasi = date("Y-m-d H:i:s");
            $model->auto = 1;
            $model->approved_bsm_ulasan = "Diluluskan selepas semakan JK Tapisan";
            $model->auto_desc = "PERMOHONAN JABATAN";
            $model->save(false);

            $ntf = new Notification();
            $ntf->icno = $model->ICNO;
            $ntf->title = "Surat Kebenaran Bekerja";
            $ntf->content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save();
        }

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jadual Berjaya Di Simpan dan Surat Kebenaran Bekerja telah dihantar ke pada Staf terlibat.']);
        return $this->redirect(['import']);
    }

    public function actionLaporanBulanan() { //for kj
        $dept = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);
        $user = Tblprcobiodata::find()->where(['DeptId' => $dept->DeptId, 'Status' => 1])->groupBy(['CONm'])->all();
        $total_user = Tblprcobiodata::find()->where(['DeptId' => $dept->DeptId, 'Status' => 1])->count();
        $permohonan = TblPermohonan::find()->one();
        $department = Department::find()->where(['id' => $dept->DeptId])->One();
        return $this->render('k_laporan_bulanan', [
                    'user' => $user,
                    'permohonan' => $permohonan,
                    'department' => $department,
                    'total_user' => $total_user,
        ]);
    }

    public function actionLaporan() {
        $model = new Department();
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->cluster) && !empty($model->isActive)) {
                return $this->redirect(['jana-laporan', 'dept' => $model->cluster, 'month' => $model->isActive]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila Pilih Jabatan']);
            }
        }

        return $this->render('b_form_laporan', [
                    'model' => $model,
        ]);
    }

    public function actionLaporanJabatan() {
        $model = new TblPermohonan();
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->isActive)) {
                return $this->redirect(['statistic', 'month' => $model->isActive]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila Pilih Jabatan']);
            }
        }

        return $this->render('b_form_laporan_jabatan', [
                    'model' => $model,
        ]);
    }

    public function actionJanaLaporan($dept, $month) {
        $user = Tblprcobiodata::find()->where(['DeptId' => $dept, 'Status' => 1])->groupBy(['CONm'])->all();
        $total_user = Tblprcobiodata::find()->where(['DeptId' => $dept, 'Status' => 1])->count();
        $permohonan = TblPermohonan::find()->one();
        $department = Department::find()->where(['id' => $dept])->One();
        return $this->render('b_laporan_bulanan', [
                    'user' => $user,
                    'permohonan' => $permohonan,
                    'department' => $department,
                    'total_user' => $total_user,
                    'month' => $month,
        ]);
    }

    public function actionDepartment() {

        $department = Department::find()->where(['isActive' => 1])->orderBy(['fullname' => SORT_ASC])->all();
        $permohonan = TblPermohonan::find()->one();
        $model = new Department();
        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['department-search', 'id' => $model->isActive]);
        }

        return $this->render('b_department', [
                    'permohonan' => $permohonan,
                    'department' => $department,
                    'model' => $model,
        ]);
    }

    public function actionDepartmentSearch($id) {

        $department = Department::find()->where(['isActive' => 1])->where(['id' => $id])->all();
        $permohonan = TblPermohonan::find()->one();
        $model = new Department();
        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['department-search', 'id' => $model->isActive]);
        }

        return $this->render('b_department', [
                    'permohonan' => $permohonan,
                    'department' => $department,
                    'model' => $model,
        ]);
    }

    public function actionCarianPegawai($dept) {
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['set-jadual', 'icno' => $search->ICNO, 'dept' => $dept]);
        }

        return $this->render('b_set_jadual', [
                    'permohonan' => null,
                    'search' => $search,
                    'biodata' => null,
                    'dept' => $dept,
        ]);
    }

    public function actionSetJadual($icno, $dept) {

        $search = new TblPermohonan();

        $permohonan = TblPermohonan::find()->where(['ICNO' => $icno, 'status_semasa' => 3])->orderBy(['tarikh_mohon' => SORT_DESC])->all();
        $biodata = $this->findBiodata($icno);

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['set-jadual', 'icno' => $search->ICNO, 'dept' => $dept]);
        }
        return $this->render('b_set_jadual', [
                    'permohonan' => $permohonan,
                    'biodata' => $biodata,
                    'search' => $search,
                    'icno' => $icno,
                    'dept' => $dept,
        ]);
    }

    public function actionTambahWfo($icno) {
        $user = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = new TblPermohonan();

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->tugas) && !empty($model->kategori)) {

                $tugas = $model->tugas;
                $kategori = $model->kategori;

                $dates = array();
                if ($model->date1) {
                    $dates[] = $model->date1;
                }
                if ($model->date2) {
                    $dates[] = $model->date2;
                }
                if ($model->date3) {
                    $dates[] = $model->date3;
                }
                if ($model->date4) {
                    $dates[] = $model->date4;
                }
                if ($model->date5) {
                    $dates[] = $model->date5;
                }

                try {
                    $risk = SelfRisk::find()->where(['icno' => $icno])->orderBy(['assessmentTaken' => SORT_DESC])->One();

                    if ($risk) { //sdh ambil assessment
                        if ($risk->riskGroupId == 2 || $risk->riskGroupId == 3) {
                            Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'TIDAK DIBENARKAN WFO PENILAIAN UMS SHIELDS BERSTATUS MERAH.']);
                            return $this->redirect(['set-jadual', 'icno' => $icno, 'dept' => $user->DeptId]);
                        } else {
                            foreach ($dates as $dates) {

                                if (empty(TblPermohonan::find()->where(['ICNO' => $icno])->andWhere(['status_semasa' => 3])->andWhere(['=', 'DATE(StartDate)', $dates])->one())) {

                                    $model2 = new TblPermohonan();
                                    $model2->ICNO = $icno;
                                    $model2->tarikh_mohon = date("Y-m-d H:i:s");
                                    $model2->status_semasa = 3;
                                    $model2->status_notifikasi = 1;
                                    $model2->tarikh_notifikasi = date("Y-m-d H:i:s");
                                    $model2->isActive = 1;
                                    $model2->StartDate = $dates;
                                    $model2->EndDate = $dates;
                                    $model2->tugas = $tugas;
                                    $model2->kategori = $kategori;

                                    $model2->approved_kj_ulasan = "Diperakukan mengikut Jadual Bertugas PKPB JFPIB";
                                    $model2->approved_kj_at = date("Y-m-d H:i:s");
                                    $model2->approved_kj_status = 1;

                                    $model2->approved_bsm_ulasan = "Diluluskan selepas melalui semakan Jawatankuasa Tapisan";
                                    $model2->approved_bsm_at = date("Y-m-d H:i:s");
                                    $model2->approved_bsm_status = 1;

                                    $model2->save(false);

                                    $ntf = new Notification();
                                    $ntf->icno = $icno;
                                    $ntf->title = "Surat Kebenaran Bekerja";
                                    $ntf->content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                                    $ntf->save();
                                } else {
                                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Tarikh WFO bertindih.']);
                                    return $this->redirect(['set-jadual', 'icno' => $icno, 'dept' => $user->DeptId]);
                                }
                            }
                            return $this->redirect(['set-jadual', 'icno' => $icno, 'dept' => $user->DeptId]);
                        }
                    } else {
                        Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Pemohon Belum mengambil ujian penilaian SelfRisk.']);
                        return $this->redirect(['set-jadual', 'icno' => $icno, 'dept' => $user->DeptId]);
                    }
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sistem ujian penilaian SelfRisk sedang mengalami gangguan teknikal. Sila cuba sebentar lagi...']);
                    return $this->redirect(['department']);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan tarikh dan tugas.']);
            }
        }


        return $this->renderAjax('b_form_wfo', [
                    'model' => $model,
                    'title' => 'Tambah',
        ]);
    }

    public function actionTambahWfoBerkumpul($icno) {
        $user = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = new TblPermohonan();

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->tugas) && !empty($model->kategori) && !empty($model->tarikh)) {

                $tugas = $model->tugas;
                $kategori = $model->kategori;

                $dates = array();
                $current = strtotime($model->StartDate);
                $date2 = strtotime($model->EndDate);
                $stepVal = '+1 day';
                while ($current <= $date2) {
                    $dates[] = date('Y-m-d', $current);
                    $current = strtotime($stepVal, $current);
                }

                $risk = SelfRisk::find()->where(['icno' => $icno])->orderBy(['assessmentTaken' => SORT_DESC])->One();

                if ($risk) { //sdh ambil assessment
                    if ($risk->riskGroupId == 2 || $risk->riskGroupId == 3) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'TIDAK DIBENARKAN WFO PENILAIAN UMS SHIELDS BERSTATUS MERAH.']);
                        return $this->redirect(['set-jadual', 'icno' => $icno, 'dept' => $user->DeptId]);
                    } else {
                        foreach ($dates as $dates) {

                            if (empty(TblPermohonan::find()->where(['ICNO' => $icno])->andWhere(['status_semasa' => 3])->andWhere(['=', 'DATE(StartDate)', $dates])->one())) {

                                $model2 = new TblPermohonan();
                                $model2->ICNO = $icno;
                                $model2->tarikh_mohon = date("Y-m-d H:i:s");
                                $model2->status_semasa = 3;
                                $model2->status_notifikasi = 1;
                                $model2->tarikh_notifikasi = date("Y-m-d H:i:s");
                                $model2->isActive = 1;
                                $model2->StartDate = $dates;
                                $model2->EndDate = $dates;
                                $model2->tugas = $tugas;
                                $model2->kategori = $kategori;

                                $model2->approved_kj_ulasan = "Diperakukan mengikut Jadual Bertugas PKPB JFPIB";
                                $model2->approved_kj_at = date("Y-m-d H:i:s");
                                $model2->approved_kj_status = 1;

                                $model2->approved_bsm_ulasan = "Diluluskan selepas melalui semakan Jawatankuasa Tapisan";
                                $model2->approved_bsm_at = date("Y-m-d H:i:s");
                                $model2->approved_bsm_status = 1;

                                $model2->save(false);

                                $ntf = new Notification();
                                $ntf->icno = $icno;
                                $ntf->title = "Surat Kebenaran Bekerja";
                                $ntf->content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                                $ntf->ntf_dt = date('Y-m-d H:i:s');
                                $ntf->save();
                            } else {
                                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Tarikh WFO bertindih.']);
                                return $this->redirect(['set-jadual', 'icno' => $icno, 'dept' => $user->DeptId]);
                            }
                        }
                        return $this->redirect(['set-jadual', 'icno' => $icno, 'dept' => $user->DeptId]);
                    }
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Pemohon Belum mengambil ujian penilaian SelfRisk.']);
                    return $this->redirect(['set-jadual', 'icno' => $icno, 'dept' => $user->DeptId]);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan tarikh dan tugas.']);
            }
        }


        return $this->renderAjax('b_form_wfo_berkumpul', [
                    'model' => $model,
                    'title' => 'Tambah',
        ]);
    }

    public function actionTambahWfoBerkumpulAdmin($icno) {
        $user = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = new TblPermohonan();

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->tugas) && !empty($model->kategori) && !empty($model->tarikh)) {

                $tugas = $model->tugas;
                $kategori = $model->kategori;

//                $dates = array();
//                $current = strtotime($model->StartDate);
//                $date2 = strtotime($model->EndDate);
//                $stepVal = '+1 day';
//                while ($current <= $date2) {
//                    $dates[] = date('Y-m-d', $current);
//                    $current = strtotime($stepVal, $current);
//                }

                $risk = SelfRisk::find()->where(['icno' => $icno])->orderBy(['assessmentTaken' => SORT_DESC])->One();

                if ($risk) { //sdh ambil assessment
                    if ($risk->riskGroupId == 2 || $risk->riskGroupId == 3) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'TIDAK DIBENARKAN WFO PENILAIAN UMS SHIELDS BERSTATUS MERAH.']);
                        return $this->redirect(['set-jadual', 'icno' => $icno, 'dept' => $user->DeptId]);
                    } else {
//                        foreach ($dates as $dates) {
//                            if (empty(TblPermohonan::find()->where(['ICNO' => $icno])->andWhere(['status_semasa' => 3])->andWhere(['=', 'DATE(StartDate)', $dates])->one())) {

                        $model2 = new TblPermohonan();
                        $model2->ICNO = $icno;
                        $model2->tarikh_mohon = date("Y-m-d H:i:s");
                        $model2->status_semasa = 3;
                        $model2->status_notifikasi = 1;
                        $model2->tarikh_notifikasi = date("Y-m-d H:i:s");
                        $model2->isActive = 1;
                        $model2->StartDate = $model->StartDate;
                        $model2->EndDate = $model->EndDate;
                        $model2->tugas = $tugas;
                        $model2->kategori = $kategori;

                        $model2->approved_kj_ulasan = "Diperakukan mengikut Jadual Bertugas PKPB JFPIB";
                        $model2->approved_kj_at = date("Y-m-d H:i:s");
                        $model2->approved_kj_status = 1;

                        $model2->approved_bsm_ulasan = "Diluluskan selepas melalui semakan Jawatankuasa Tapisan";
                        $model2->approved_bsm_at = date("Y-m-d H:i:s");
                        $model2->approved_bsm_status = 1;

                        $model2->save(false);

                        $ntf = new Notification();
                        $ntf->icno = $icno;
                        $ntf->title = "Surat Kebenaran Bekerja";
                        $ntf->content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
//                            } else {
//                                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Tarikh WFO bertindih.']);
//                                return $this->redirect(['set-jadual', 'icno' => $icno, 'dept' => $user->DeptId]);
//                            }
//                        }
                        return $this->redirect(['set-jadual', 'icno' => $icno, 'dept' => $user->DeptId]);
                    }
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Pemohon Belum mengambil ujian penilaian SelfRisk.']);
                    return $this->redirect(['set-jadual', 'icno' => $icno, 'dept' => $user->DeptId]);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan tarikh dan tugas.']);
            }
        }


        return $this->renderAjax('b_form_wfo_berkumpul', [
                    'model' => $model,
                    'title' => 'Tambah',
        ]);
    }

    public function actionEditWfo($id) {
        $model = TblPermohonan::findOne(['id' => $id]);
        $user = Tblprcobiodata::find()->where(['ICNO' => $model->ICNO])->one();

        if ($model->load(Yii::$app->request->post())) {
            $model->EndDate = $model->StartDate;
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Jadual Berjaya Di Kemaskini']);
            return $this->redirect(['set-jadual', 'icno' => $model->ICNO, 'dept' => $user->DeptId]);
        }


        return $this->renderAjax('b_form_wfo', [
                    'model' => $model,
                    'title' => 'Kemaskini',
        ]);
    }

    public function actionCarianSetJadualHari() {
        $model = new Department();
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->shortname)) {
                $date = explode("-", $model->shortname);
                return $this->redirect(['set-jadual-hari', 'year' => $date[1], 'month' => $date[0]]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila Pilih Tarikh']);
            }
        }

        return $this->render('b_form_jadual_hari', [
                    'model' => $model,
                    'month' => null,
                    'year' => null,
        ]);
    }

    public function actionSetJadualHari($year, $month) {
        $model = new Department();
        $permohonan = TblPermohonan::find()->one();
        if ($data = Yii::$app->request->post('check')) {

            $selected = array();
            foreach ($data as $index => $value) {
                $selected[$index] = $value;
            }

            return $this->redirect(['tambah-jadual', 'date' => $selected]);
        }

        return $this->render('b_form_list_hari', [
                    'model' => $model,
                    'month' => $month,
                    'year' => $year,
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionTambahJadual(array $date) {
        $model = new TblPermohonan();
        $d1 = $date;
        $d2 = $date;
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->ICNO)) { //tambah rekod
                $ic = $model->ICNO;
                $tugas = $model->tugas;
                $cat = $model->kategori;

                $risk = SelfRisk::find()->where(['icno' => $ic])->orderBy(['assessmentTaken' => SORT_DESC])->One();

                if ($risk) { //sdh ambil assessment
                    if ($risk->riskGroupId == 2 || $risk->riskGroupId == 3) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'TIDAK DIBENARKAN WFO PENILAIAN UMS SHIELDS BERSTATUS MERAH.']);
                        return $this->redirect(['tambah-jadual-hari', 'date' => $date]);
                    } else {
                        //check date 
                        foreach ($d1 as $date) {
                            $model = TblPermohonan::find()->where(['ICNO' => $ic])->andWhere(['status_semasa' => 3])->andWhere(['=', 'DATE(StartDAte)', date($date)])->one();
                            if ($model) {
                                $checkDate = $model->StartDate;
                            }
                        }


                        if (empty($checkDate)) {


                            $user = Tblprcobiodata::find()->where(['ICNO' => $ic])->one();
                            foreach ($d2 as $date) {

                                $model2 = new TblPermohonan();
                                //add new application
                                $model2->ICNO = $ic;
                                $model2->tugas = $tugas;
                                $model2->kategori = $cat;
                                $model2->tarikh_mohon = date("Y-m-d H:i:s");
                                $model2->status_semasa = 3;
                                $model2->status_notifikasi = 1;
                                $model2->tarikh_notifikasi = date("Y-m-d H:i:s");
                                $model2->isActive = 1;
                                $model2->StartDate = $date;
                                $model2->EndDate = $date;

                                $model2->approved_kj_ulasan = "Diperakukan mengikut Jadual Bertugas PKPB JFPIB";
                                $model2->approved_kj_at = date("Y-m-d H:i:s");
                                $model2->approved_kj_status = 1;

                                $model2->approved_bsm_ulasan = "Diluluskan selepas melalui semakan Jawatankuasa Tapisan";
                                $model2->approved_bsm_at = date("Y-m-d H:i:s");
                                $model2->approved_bsm_status = 1;
                                $model2->kategori = $cat;
                                $model2->save(false);
                            }

                            $ntf = new Notification();
                            $ntf->icno = $ic;
                            $ntf->title = "Surat Kebenaran Bekerja";
                            $ntf->content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();

                            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Jadual Berjaya Di Simpan dan Surat Kebenaran Bekerja telah dihantar ke pada ' . $user->CONm]);
                            return $this->redirect(['tambah-jadual', 'date' => $date]);
                        } else {
                            Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Tarikh WFO bertindih pada ' . $checkDate]);
                            return $this->redirect(['tambah-jadual', 'date' => $date]);
                        }
                    }
                }
            } else { //lengkapkan form untuk menambah rekod
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila Pilih Nama.']);
            }
        }

        return $this->render('b_form_tambah_jadual', [
                    'model' => $model,
                    'date' => $date,
        ]);
    }

    public function actionTambahJadualHari($date) {
        $model = new TblPermohonan();
        $permohonan = TblPermohonan::find()->where(['StartDate' => $date])->andWhere(['status_semasa' => 3])->orderBy(['tarikh_mohon' => SORT_DESC])->all();
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->ICNO)) { //tambah rekod
                $ic = $model->ICNO;
                $model->StartDate = $date;

                $risk = SelfRisk::find()->where(['icno' => $ic])->orderBy(['assessmentTaken' => SORT_DESC])->One();

                if ($risk) { //sdh ambil assessment
                    if ($risk->riskGroupId == 2 || $risk->riskGroupId == 3) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'TIDAK DIBENARKAN WFO PENILAIAN UMS SHIELDS BERSTATUS MERAH.']);
                        return $this->redirect(['tambah-jadual-hari', 'date' => $date]);
                    } else {
                        if (empty(TblPermohonan::find()->where(['ICNO' => $ic])->andWhere(['status_semasa' => 3])->andWhere(['=', 'DATE(StartDAte)', date($model->StartDate)])->one())) {


                            $user = Tblprcobiodata::find()->where(['ICNO' => $ic])->one();
                            //add new application
                            $model->ICNO = $ic;
                            $model->tarikh_mohon = date("Y-m-d H:i:s");
                            $model->status_semasa = 3;
                            $model->status_notifikasi = 1;
                            $model->tarikh_notifikasi = date("Y-m-d H:i:s");
                            $model->isActive = 1;
                            $model->EndDate = $model->StartDate;

                            $model->approved_kj_ulasan = "Diperakukan mengikut Jadual Bertugas PKPB JFPIB";
                            $model->approved_kj_at = date("Y-m-d H:i:s");
                            $model->approved_kj_status = 1;

                            $model->approved_bsm_ulasan = "Diluluskan selepas melalui semakan Jawatankuasa Tapisan";
                            $model->approved_bsm_at = date("Y-m-d H:i:s");
                            $model->approved_bsm_status = 1;
                            $model->save(false);

                            $ntf = new Notification();
                            $ntf->icno = $ic;
                            $ntf->title = "Surat Kebenaran Bekerja";
                            $ntf->content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();

                            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Jadual Berjaya Di Simpan dan Surat Kebenaran Bekerja telah dihantar ke pada ' . $user->CONm]);
                            return $this->redirect(['tambah-jadual-hari', 'date' => $date]);
                        } else {
                            Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Tarikh WFO bertindih.']);
                            return $this->redirect(['tambah-jadual-hari', 'date' => $date]);
                        }
                    }
                }
            } else { //lengkapkan form untuk menambah rekod
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila Pilih Nama.']);
            }
        }

        return $this->render('b_form_tambah_jadual_hari', [
                    'model' => $model,
                    'permohonan' => $permohonan,
                    'date' => $date,
        ]);
    }

    public function actionEditWfoHari($id, $date) {
        $model = TblPermohonan::findOne(['id' => $id]);
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $model->ICNO])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->EndDate = $model->StartDate;
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Jadual Berjaya Di Kemaskini.']);
            return $this->redirect(['tambah-jadual-hari', 'date' => $date]);
        }

        return $this->render('b_form_wfo_hari', [
                    'model' => $model,
                    'biodata' => $biodata,
        ]);
    }

    public function actionBatalPermohonan($id) {
        $model = TblPermohonan::find()->where(['id' => $id])->one();
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => '']);
        return $this->redirect(['set-jadual', 'icno' => $model->ICNO, 'dept' => $model->biodata->DeptId]);
    }

    public function ExistApplicationWfo($icno, $date) {
        if (TblPermohonan::find()->where(['ICNO' => $icno])->andWhere(['StartDate' => $date])->one()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function ApplyWfo($icno, $date) {
        $user = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

        $datewfo = $date;
        $cat = \app\models\w_letter\RefKategoriJabatan::findOne(['DeptId' => $user->DeptId]);

        $ic = $user->ICNO;

        $model = new TblPermohonan();
        $model->ICNO = $ic;
        $model->tugas = "Menjalankan tugas di kawasan pejabat.";
        $model->tarikh_mohon = date("Y-m-d H:i:s");
        $model->status_semasa = 3;
        $model->status_notifikasi = 1;
        $model->tarikh_notifikasi = date("Y-m-d H:i:s");
        $model->isActive = 1;
        $model->StartDate = $datewfo;
        $model->EndDate = $datewfo;
        $model->auto = 1;
        $model->auto_desc = "BAHAGIAN SUMBER MANUSIA";
        if ($cat) {
            $model->kategori = $cat->kategori;
        } else {
            $model->kategori = "NE50";
        }

        $risk = SelfRisk::find()->where(['icno' => $ic])->orderBy(['assessmentTaken' => SORT_DESC])->One();

        if ($risk) { //sdh ambil assessment
            if ($risk->riskGroupId == 2 || $risk->riskGroupId == 3) {
                $log = new \app\models\w_letter\LogAttempt();
                $log->ICNO = $ic;
                $log->desc = "SELF-RISK STATUS RED";
                $log->datetime = date("Y-m-d H:i:s");
                $log->save(false);
            } else {
                $model->save(false);

//                $ntf = new Notification();
//                $ntf->icno = $ic;
//                $ntf->title = "Surat Kebenaran Bekerja";
//                $ntf->content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
//                $ntf->ntf_dt = date('Y-m-d H:i:s');
//                $ntf->save();
            }
        } else {
            $log = new \app\models\w_letter\LogAttempt();
            $log->ICNO = $ic;
            $log->desc = "SELF-RISK STATUS NOT FOUND";
            $log->datetime = date("Y-m-d H:i:s");
            $log->save(false);
        }
    }

    public function actionEsuratWfo($id, $date) {

        $Wdate = $date;
        $wfo = array();
        $model = Tblprcobiodata::find()->where(['DeptId' => $id])->andWhere(['!=', 'Status', 6])->all();
        foreach ($model as $model) {
            $wfo[] = $model->ICNO;
        }

        foreach ($wfo as $wfo) {
            if ($this->ExistApplicationWfo($wfo, $Wdate) == FALSE) {
                $this->ApplyWfo($wfo, $Wdate);
            }
        }

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => '']);
        return $this->redirect(['pemohon']);
    }

    public function actionCancelWfo($date) {
        $model = TblPermohonan::find()->where(['StartDate' => $date])->andWhere(['auto' => 1])->all();
        foreach ($model as $model) {
            $wfh = \app\models\kehadiran\TblWfh::find()->where(['icno' => $model->ICNO])->andWhere(['start_date' => $date])->one();

            if ($wfh) {
                $model->delete();
            }
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => '']);
        return $this->redirect(['pemohon']);
    }

    public function actionKemaskiniPegawai() {
        $peg = \app\models\cuti\TblManagement::find()->where(['level' => 0])->andWhere(['user' => 'eSurat'])->one();
        $model = \app\models\cuti\TblManagement::find()->where(['level' => 1])->andWhere(['user' => 'eSurat'])->one();
        $model->pegawai2 = $peg->icno;
        if ($model->load(Yii::$app->request->post())) {
            if ($peg->icno != $model->pegawai2) {
                //update pegawai ke dua
                $peg->icno = $model->pegawai2;
                $peg->update_by = $this->ICNO();
                $peg->update_at = date('Y-m-d H:i:s');
                $peg->save();
            }
            $model->update_by = $this->ICNO();
            $model->update_at = date('Y-m-d H:i:s');
            $model->save();
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dikemaskini!', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['kemaskini-pegawai']);
        }

        return $this->render('a_kemaskini_pegawai', [
                    'model' => $model,
        ]);
    }

}
