<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\v_letter\TblPermohonan;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblkeluarga;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
use app\models\Notification;
use yii\filters\AccessControl;
use app\models\v_letter\TblAccess;

class VLetterController extends Controller {

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
                    'permohonan', 'pemohon', 'surat-v',
                    //admin
                    'admin', 'carian', 'carian-permohonan', 'surat-v'
                ],
                'rules' => [
                    [//pengguna
                        'actions' => ['permohonan', 'pemohon', 'surat-v'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['!=', 'Status', '6'])->one();
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//admin
                        'actions' => ['admin', 'carian', 'carian-permohonan', 'surat-v'],
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

    protected function findPermohonanbyId($id) {
        return TblPermohonan::find()->where(['id' => $id])->one();
    }

    protected function findBiodata($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }

    protected function findPermohonanAktif() {
        return TblPermohonan::find()->where(['ICNO' => $this->ICNO()])->andWhere(['status_semasa' => 1])->one();
    }

    protected function findPermohonanTelahDiNotifikasi() {
        return TblPermohonan::find()->Where(['status_notifikasi' => 1])->all();
    }

    public function GridPermohonanTelahDiNotifikasi() {
        $data = new ActiveDataProvider([
            'query' => TblPermohonan::find()->Where(['status_notifikasi' => 1]),
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

    public function findRekodKeluarga($ICNO) {

        $biodata = Tblprcobiodata::findOne(['ICNO' => $ICNO]);

        if ($biodata->MrtlStatusCd == 0) { //Status Tiada Maklumat
            $family = Tblkeluarga::find()->where(['ICNO' => null])->all(); // dummy
        } else if ($biodata->MrtlStatusCd == 1) { // Belum berkahwin
            $family = Tblkeluarga::find()->where(['ICNO' => $biodata->ICNO])->andwhere(['IN', 'RelCd', ['03', '04']])->all();
        } else {
            $family = Tblkeluarga::find()->where(['ICNO' => $biodata->ICNO])->andWhere(['IN', 'RelCd', ['01', '02', '03', '04', '05', '06', '07', '08', '15']])->all();
        }

        return $family;
    }

    public function actionSuratV($id) {

        $permohonan = $this->findPermohonanbyId($id);
        $family = $this->findRekodKeluarga($permohonan->ICNO);
        $css = file_get_contents('./css/surat.css');

        $content = $this->renderPartial('p_v_letter1', ['permohonan' => $permohonan, 'family' => $family]);

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

        $permohonan = $this->GridPermohonanAktif();

        return $this->render('p_main', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionPermohonan() {
        $biodata = $this->findBiodata($this->ICNO());
        $permohonan = new TblPermohonan();
        if ($permohonan->load(Yii::$app->request->post())) {

            if ($this->findPermohonanAktif()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Anda masih mempunyai permohonan yang masih aktif.']);
                return $this->redirect(['pemohon']);
            } else {
                $permohonan->save();
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Permohonan berjaya.']);
                return $this->redirect(['pemohon']);
            }
        }

        return $this->render('p_permohonan', [
                    'model' => $biodata,
                    'permohonan' => $permohonan,
        ]);
    }

    public function notifikasi($icno, $content) {
        //--------Model Notification-----------//
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $icno;
        $ntf->title = 'VLetter';
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
            'query' => TblPermohonan::find()->where(['status_notifikasi' => 0])->andWhere(['status_semasa' => 1]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function actionAdmin() {

        $permohonan = $this->GridPermohonanStatusDiterima();

        return $this->render('a_main', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionSahkan($id, $action) {

        $permohonan = TblPermohonan::findOne(['id' => $id]);
        $permohonan->status_semasa = $action;

        if ($action == 2) { //lulus
            $content = 'Surat Pengesahan. Sila muat turun <a class="btn btn-primary btn-sm" href="/staff/web/v-letter/pemohon">disini</a>';
            $permohonan->status_notifikasi = 1;
            $permohonan->tarikh_notifikasi = date("Y-m-d H:i:s");
            $permohonan->approved_at = date("Y-m-d H:i:s");
            $permohonan->approved_by = Yii::$app->user->getId();
            $permohonan->save(false);
            $this->notifikasi($permohonan->ICNO, $content);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
            return $this->redirect(['admin']);
        } else { //ditolak
            $content = 'Surat Pengesahan. Maaf Permohonan mendapatkan surat sokongan bagi kelulusan Kerajaan Negeri ditolak. Sila semak status permohonan <a class="btn btn-primary btn-sm" href="/staff/web/v-letter/pemohon">disini</a>';

            if ($permohonan->load(Yii::$app->request->post())) {
                $permohonan->save(false);
                $this->notifikasi($permohonan->ICNO, $content);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
                return $this->redirect(['admin']);
            }

            return $this->render('a_sahkan_permohonan', [
                        'permohonan' => $permohonan,
            ]);
        }
    }

    public function actionSahkanSemua() {

        $model = TblPermohonan::findAll(['status_semasa' => 1]);
        $content = 'Surat Pengesahan. Sila muat turun <a class="btn btn-primary btn-sm" href="/staff/web/v-letter/pemohon">disini</a>';
        foreach ($model as $model) {
            $model->status_semasa = 2;
            $model->status_notifikasi = 1;
            $model->tarikh_notifikasi = date("Y-m-d H:i:s");
            $model->approved_at = date("Y-m-d H:i:s");
            $model->approved_by = Yii::$app->user->getId();
            $model->save(false);
            $this->notifikasi($model->ICNO, $content);
        }

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => 'Tindakan berjaya.']);
        return $this->redirect(['admin']);
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

    public function actionManualPengguna() {
        $completePath = Yii::getAlias('@app/web/files/' . '');
        return Yii::$app->response->sendFile($completePath, '');
    }

}
