<?php

namespace app\controllers;

use DateTime;
use Yii;
use yii\web\Controller;
use app\models\guarantee_letter\TblPermohonan;
use app\models\guarantee_letter\TblPermohonanBatal;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblkeluarga;
use app\models\guarantee_letter\TblKelasWad;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
use app\models\Notification;
use yii\filters\AccessControl;
use app\models\guarantee_letter\TblAccess;
use app\models\guarantee_letter\TblHospital;
use app\models\cuti\TblManagement;

class GuaranteeLetterController extends Controller {

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
                    'permohonan', 'pemohon', 'surat-jaminan', 'sejarah-permohonan',
                    //admin
                    'admin', 'cari-laporan', 'laporan-permohonan', 'carian', 'carian-permohonan', 'tambah-hospital', 'staf', 'kemaskini-permohonan', 'rekod-batal', 'kemaskini-pegawai', 'tambah-admin','rekod-permohonan','mohon'
                ],
                'rules' => [
                    [//pengguna
                        'actions' => ['permohonan', 'pemohon', 'surat-jaminan', 'sejarah-permohonan'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['!=', 'Status', '6'])->one();
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//admin
                        'actions' => ['admin', 'cari-laporan', 'laporan-permohonan', 'surat-jaminan', 'carian', 'carian-permohonan', 'tambah-hospital', 'staf', 'kemaskini-permohonan', 'rekod-batal', 'kemaskini-pegawai', 'tambah-admin','rekod-permohonan','mohon'],
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

    ///////share/////
    protected function ICNO() {
        return Yii::$app->user->getId();
    }

    protected function findPermohonanbyId($id) {
        return TblPermohonan::find()->where(['id' => $id])->one();
    }

    protected function findBiodata($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }

    protected function KelasWad() {
        return TblKelasWad::find()->all();
    }

    protected function findPermohonanTelahDiNotifikasi() {
        return TblPermohonan::find()->Where(['status_notifikasi' => 1])->all();
    }

    protected function findPermohonanAktif($icno) {
        $model = TblPermohonan::find()->where(['ICNO' => $icno])->andWhere(['isActive' => 1])->all();

        if (count($model) >= 2) {
            return 1;
        } else {
            return 0;
        }
    }

    public function GridPermohonanTelahDiNotifikasi() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()->Where(['status_notifikasi' => 1]),
            'pagination' => [
                'pageSize' => 10,
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

    public function GridPermohonanAktif() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['ICNO' => $this->ICNO()])->andWhere(['isActive' => 1]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function GridPermohonanTidakAktif() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['ICNO' => $this->ICNO()])->andWhere(['isActive' => 0]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionSuratJaminan($id) {

        $permohonan = $this->findPermohonanbyId($id);
        $css = file_get_contents('./css/surat.css');

        $content = $this->renderPartial('p_guarantee_letter', ['permohonan' => $permohonan]);

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

    //////pemohon///////

    public function findKelasWad($biodata) {
        $kelas_wad = $this->KelasWad();
        $gred_no = $biodata->jawatan->gred_no;

        foreach ($kelas_wad as $i) {
            if (($gred_no >= $i->gred_no_min) && ( $gred_no <= $i->gred_no_max)) {
                $id = $i->id;
            }
        }

        if (in_array($biodata->jawatan->gred_no, [5, 6, 7, 8, 9, '51P', 55, 56])) {
            $id = 1; //Pengurusan Tertinggi
        }

        return $id;
    }

    public function findRekodKeluarga($biodata) {

        if ($biodata->MrtlStatusCd == 0) { //Status Tiada Maklumat
            $family = Tblkeluarga::find()->where(['ICNO' => null])->all(); // dummy
        } else if ($biodata->MrtlStatusCd == 1) { // Belum berkahwin
            $family = Tblkeluarga::find()->where(['ICNO' => $biodata->ICNO])->andwhere(['IN', 'RelCd', ['03', '04', '16']])->all();
        } else {
            $family = Tblkeluarga::find()->where(['ICNO' => $biodata->ICNO])->andWhere(['IN', 'RelCd', ['01', '02', '03', '04', '05', '06', '07', '08', '15', '16']])->all();
        }

        return $family;
    }

    public function findRekodAnak($biodata) {

        $family = Tblkeluarga::find()->where(['ICNO' => $biodata->ICNO])->andWhere(['IN', 'RelCd', ['05', '06', '07', '08']])->all();

        return $family;
    }

    public function checkingSejarahPermohonan() {
        $permohonan = $this->findPermohonanTelahDiNotifikasi();

        foreach ($permohonan as $permohonan) {

            $datetime1 = new DateTime($permohonan->tarikh_notifikasi);
            $datetime2 = new DateTIme('now');
            $interval = $datetime1->diff($datetime2);

            if ($interval->format('%d') >= 30) {
                $permohonan->isActive = 0;
                $permohonan->save(false);
            }
        }
    }

    public function actionPemohon() {

        $this->checkingSejarahPermohonan();
        $pegawai = TblManagement::find()->where(['user' => 'eGL'])->all();
        $permohonan = $this->GridPermohonanAktif();

        return $this->render('p_main', [
                    'permohonan' => $permohonan,
                    'pegawai' => $pegawai,
        ]);
    }

    public function actionPermohonan() {
        $true = 0;
        $biodata = $this->findBiodata($this->ICNO());
        $permohonan = new TblPermohonan();
        $permohonan->gl_kelasWad_id = $this->findKelasWad($biodata);
        $queryKeluarga = $this->findRekodKeluarga($biodata);
        if ($permohonan->load(Yii::$app->request->post())) {

            if ($biodata->statLantikan == 1 || $biodata->statLantikan == 3) { // tetap & kontrak 
                $permohonan->ICNO = $this->ICNO();
                $permohonan->tarikh_mohon = date('Y-m-d H:i:s');
                $permohonan->isActive = 1;
                //precheck
                if ($this->findPermohonanAktif($permohonan->ICNO) == 1) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya !', 'type' => 'error', 'msg' => 'Anda mempunyai permohonan yang masih aktif.']);
                    return $this->redirect(['pemohon']);
                } else {

                    if ($permohonan->gl_ICNO == 1) {

                        $permohonan->gl_hubungan = 'Diri Sendiri';
                        $permohonan->gl_ICNO = $this->ICNO();
                        $permohonan->gl_nama = $biodata->CONm;

                        $true = 1;
                    } elseif ($permohonan->gl_ICNO == 2) {

                        if ($permohonan->family) {
                            $permohonan->gl_ICNO = preg_replace("/[-]/", "", $permohonan->family);
                            $data = Tblkeluarga::find()->where(['AND', ['ICNO' => $this->ICNO()], ['FamilyId' => $permohonan->family]])->one();
                            $permohonan->gl_hubungan = $data->hubkeluarga;
                            $permohonan->gl_nama = $data->FmyNm;

                            if ((in_array($data->RelCd, ['05', '06', '07', '08'])) && ($data->FmyDisabilityStatus != 1)) {
                                //anak <18 thn shaja dpt memohon GL

                                $date1 = date_create($data->FmyBirthDt);
                                $date2 = date_create(date('Y-m-d'));
                                $umur = date_diff($date1, $date2)->format('%y');

                                if ($umur < 18) {
                                    $true = 1;
                                } else { // kemukakan bukti
                                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf !', 'type' => 'error', 'msg' => 'Bagi Anak Tanggungan berumur 18-21 tahun ke atas mohon kemukakan tawaran pengajian kepada BSM.']);
                                }
                            } else {
                                $true = 1;
                            }
                        } else {
                            Yii::$app->session->setFlash('alert', ['title' => 'Maaf !', 'type' => 'error', 'msg' => 'Sila pilih tanggungan.']);
                            return $this->redirect(['permohonan']);
                        }
                    } else { //bukan warganegara
                        $permohonan->gl_hubungan = 'Diri Sendiri';
                        $permohonan->gl_ICNO = $biodata->latestPaspot;
                        $permohonan->gl_nama = $biodata->CONm;
                        $true = 1;
                    }

                    if ($true == 1) {
                        $permohonan->status_semasa = 2;
                        $permohonan->status_notifikasi = 1;
                        $permohonan->tarikh_notifikasi = date('Y-m-d H:i:s');

                        $permohonan->save(false);
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya !', 'type' => 'success', 'msg' => 'Sila muat turun Surat Jaminan Hospital (GL).']);
                        return $this->redirect(['pemohon']);
                    }
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf !', 'type' => 'error', 'msg' => 'Permohonan Guarantee Letter hanya terbuka kepada sandangan tetap & kontrak pusat sahaja.']);
                return $this->redirect(['pemohon']);
            }
        }

        return $this->render('p_permohonan', [
                    'model' => $biodata,
                    'permohonan' => $permohonan,
                    'queryKeluarga' => $queryKeluarga,
        ]);
    }

    public function actionSejarahPermohonan() {

        $permohonan = $this->GridPermohonanTidakAktif();

        return $this->render('p_sejarah_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }

    ///admin

    public function actionStaf() {
        $permohonan = new TblPermohonan();

        if ($permohonan->load(Yii::$app->request->post())) {
            return $this->redirect(['mohon', 'ICNO' => $permohonan->gl_ICNO]);
        }
        return $this->render('a_carian_staf', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionMohon($ICNO) {
        $true = 0;
        $biodata = $this->findBiodata($ICNO);
        $permohonan = new TblPermohonan();
        $permohonan->gl_kelasWad_id = $this->findKelasWad($biodata);
        $queryKeluarga = $this->findRekodKeluarga($biodata);
        if ($permohonan->load(Yii::$app->request->post())) {

            if ($biodata->statLantikan == 1 || $biodata->statLantikan == 3) { // tetap & kontrak 
                $permohonan->ICNO = $ICNO;
                $permohonan->tarikh_mohon = date('Y-m-d H:i:s');
                $permohonan->isActive = 1;

                if ($this->findPermohonanAktif($permohonan->ICNO) == 1) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya !', 'type' => 'error', 'msg' => 'Mempunyai 2 permohonan yang masih aktif.']);
                } else {

                    if ($permohonan->gl_ICNO == 1) {

                        $permohonan->gl_hubungan = 'Diri Sendiri';
                        $permohonan->gl_ICNO = $ICNO;
                        $permohonan->gl_nama = $biodata->CONm;

                        $true = 1;
                    } elseif ($permohonan->gl_ICNO == 2) {

                        if ($permohonan->family) {
                            $permohonan->gl_ICNO = preg_replace("/[-]/", "", $permohonan->family);
                            $data = Tblkeluarga::find()->where(['AND', ['ICNO' => $ICNO], ['FamilyId' => $permohonan->family]])->one();
                            $permohonan->gl_hubungan = $data->hubkeluarga;
                            $permohonan->gl_nama = $data->FmyNm;
                            $true = 1;
                        } else {
                            Yii::$app->session->setFlash('alert', ['title' => 'Maaf !', 'type' => 'error', 'msg' => 'Sila pilih tanggungan.']);
                            return $this->redirect(['admin']);
                        }
                    } else { //bukan warganegara
                        $permohonan->gl_hubungan = 'Diri Sendiri';
                        $permohonan->gl_ICNO = $biodata->latestPaspot;
                        $permohonan->gl_nama = $biodata->CONm;
                        $true = 1;
                    }

                    if ($true == 1) {
                        $permohonan->status_semasa = 2;
                        $permohonan->status_notifikasi = 1;
                        $permohonan->tarikh_notifikasi = date('Y-m-d H:i:s');

                        $permohonan->save(false);
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya !', 'type' => 'success', 'msg' => 'Notifikasi Surat Jaminan telah dihantar ke akaun pemohon.']);
                        return $this->redirect(['admin']);
                    }
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf !', 'type' => 'error', 'msg' => 'Permohonan Guarantee Letter hanya terbuka kepada sandangan tetap & kontrak pusat sahaja.']);
                return $this->redirect(['admin']);
            }
        }

        return $this->render('p_permohonan', [
                    'model' => $biodata,
                    'permohonan' => $permohonan,
                    'queryKeluarga' => $queryKeluarga,
        ]);
    }

    public function notifikasi($icno, $content) {
        //--------Model Notification-----------//
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $icno;
        $ntf->title = 'EGL';
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
            'query' => TblPermohonan::find()->where(['status_notifikasi' => 1])->andWhere(['DATE(tarikh_mohon)' => date('Y-m-d')]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
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

    public function actionKemaskiniPermohonan() {
        $permohonan = new TblPermohonan();

        if ($permohonan->load(Yii::$app->request->post())) {
            return $this->redirect(['rekod-permohonan', 'ICNO' => $permohonan->gl_ICNO]);
        }
        return $this->render('a_carian_staf', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionRekodPermohonan($ICNO) {
        $model = $this->Grid(TblPermohonan::find()->where(['ICNO' => $ICNO])->orderBy(['tarikh_mohon' => SORT_DESC]));
        $permohonan = new TblPermohonan();
        if ($permohonan->load(Yii::$app->request->post())) {
            return $this->redirect(['rekod-permohonan', 'ICNO' => $permohonan->gl_ICNO]);
        }
        return $this->render('a_rekod_staff', [
                    'permohonan' => $permohonan,
                    'model' => $model,
        ]);
    }

    public function actionKemaskiniSuratJaminan($id) {

        $model = $this->findBiodata($this->ICNO());
        $permohonan = TblPermohonan::findOne(['id' => $id]);

        if ($permohonan->load(Yii::$app->request->post())) {
            $permohonan->sah_bukti_by = Yii::$app->user->getId();
            $permohonan->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Di kemaskini.']);
            return $this->redirect(['rekod-permohonan', 'ICNO' => $permohonan->ICNO]);
        }
        return $this->renderAjax('a_kemaskini_permohonan', [
                    'model' => $model,
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionBatalPermohonan($id) {

        $permohonan = TblPermohonan::findOne(['id' => $id]);
        $batal = new TblPermohonanBatal();
        if ($batal->load(Yii::$app->request->post())) {
            $batal->save(false);
            $permohonan->delete();
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Di batalkan.']);
            return $this->redirect(['rekod-permohonan', 'ICNO' => $permohonan->ICNO]);
        }
        return $this->renderAjax('a_batal_permohonan', [
                    'batal' => $batal,
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionRekodBatal() {

        $permohonan = $this->Grid(TblPermohonanBatal::find());
        return $this->render('a_rekod_batal', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionAdmin() {

        $permohonan = $this->GridPermohonanStatusDiterima();

        return $this->render('a_main', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionCarian() {

        $permohonan = $this->GridPermohonanTelahDiNotifikasi();
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan', 'icno' => $search->ICNO]);
        }

        return $this->render('a_carian_permohonan', [
                    'permohonan' => $permohonan,
                    'search' => $search,
        ]);
    }

    public function actionCarianPermohonan($icno) {

        $permohonan = $this->GridCarianPermohonan($icno);
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan', 'icno' => $search->ICNO]);
        }

        return $this->render('a_carian_permohonan', [
                    'permohonan' => $permohonan,
                    'search' => $search,
                    'icno' => $icno,
        ]);
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

    public function actionLaporanPermohonan($date) {

        $permohonan = $this->GridPermohonanTelahDiNotifikasibyDate($date);
        $search = new TblPermohonan();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['laporan-permohonan', 'date' => $search->y_m]);
        }

        return $this->render('a_laporan_permohonan', [
                    'permohonan' => $permohonan,
                    'search' => $search,
                    'date' => $date,
        ]);
    }

    //pentadbir sistem

    public function actionTambahAdmin() {

        $staff = $this->GridRekodAdmin();
        $model = new TblAccess();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Ditambah!', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['tambah-admin']);
        }

        return $this->render('s_tambah_admin', [
                    'staff' => $staff,
                    'model' => $model,
        ]);
    }

    public function actionDeleteAdmin($id) {
        $staff = TblAccess::findOne(['id' => $id]);
        $staff->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dipadam!', 'type' => 'success', 'msg' => '']);

        return $this->redirect(['tambah-admin']);
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

    public function actionTambahHospital() {

        $hospital = $this->GridRekodHospital();
        $model = new TblHospital();

        if ($model->load(Yii::$app->request->post())) {
            $model->nama = strtoupper($model->nama);
            $model->daerah = strtoupper($model->daerah);
            $model->save();
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Ditambah!', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['tambah-hospital']);
        }

        return $this->render('s_tambah_hospital', [
                    'hospital' => $hospital,
                    'model' => $model,
        ]);
    }

    public function actionDeleteHospital($id) {
        $staff = TblHospital::findOne(['id' => $id]);
        $staff->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dipadam!', 'type' => 'success', 'msg' => '']);

        return $this->redirect(['tambah-hospital']);
    }

    public function GridRekodHospital() {
        $data = new ActiveDataProvider([
            'query' => TblHospital::find()->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function actionManualPengguna() {
        $completePath = Yii::getAlias('@app/web/files/' . 'manual_pengguna_GL.pdf');
        return Yii::$app->response->sendFile($completePath, 'manual_pengguna_GL.pdf');
    }

    public function actionKemaskiniPegawai() {

        $model = TblManagement::find()->where(['level' => 1])->andWhere(['user' => 'eGL'])->one();

        if ($model->load(Yii::$app->request->post())) {
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
