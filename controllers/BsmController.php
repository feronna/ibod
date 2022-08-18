<?php

namespace app\controllers;

use Yii;
use app\models\ejobs\Iklan;
use app\models\ejobs\Kelayakan;
use app\models\ejobs\TarafJawatan;
use app\models\ejobs\TugasJawatan;
use app\models\hronline\GredJawatan;
use app\models\hronline\Tblprcobiodata; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;  
use app\models\ejobs\TblpBiodata;
use app\models\ejobs\TblpPermohonan;
use app\models\ejobs\TblpPermohonanSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\models\ejobs\TblpLain2;
use app\models\ejobs\TblpCawangan;
use app\models\ejobs\TblpTarafJawatan;
use app\models\ejobs\UserAccess;

use app\models\ejobs\TblpEduHighest;

/**
 * BsmController implements the CRUD actions for Iklan model.
 */
class BsmController extends Controller {

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
                'only' => ['halaman-utama', 'aktif-iklan', 'findIklan', 'tambah-iklan', 'taraf-jawatan', 'edit-iklan', 'tambah-kelayakan', 'tambah-tugas', 'simpan-iklan', 'findLain2', 'findUserCawangan', 'findUserTarafJawatan', 'attachment', 'resume', 'findStaff', 'findPemohon', 'saringan-layak', 'saringan-tidak-layak', 'findKumpulan', 'findModel'],
                'rules' => [
                    [
                        'actions' => ['halaman-utama', 'aktif-iklan', 'findIklan', 'tambah-iklan', 'taraf-jawatan', 'edit-iklan', 'tambah-kelayakan', 'tambah-tugas', 'simpan-iklan', 'findLain2', 'findUserCawangan', 'findUserTarafJawatan', 'attachment', 'resume', 'findStaff', 'findPemohon', 'saringan-layak', 'saringan-tidak-layak', 'findKumpulan', 'findModel'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    $tmp = UserAccess::findOne(['ICNO' => Yii::$app->user->getId()]);
                    return (is_null($tmp)) ? false : true;
                }
                    ],
                ],
            ],
        ];
    }

    public function actionHalamanUtama() {
        /* Status
         * 1 = aktif & 2 = tidak aktif
         */
        $senarai_iklan = $this->findIklan(0);
        $iklan_semasa = $this->findIklan(1); 
        $post_iklan = $this->findIklan(2);
        $jumlah_permohonan = $this->findJumlahPermohonanSemasa();
        $jumlahLayak = $this->findJumlahPermohonan(2);
        $jumlahTidakLayak = $this->findJumlahPermohonan(3);

        return $this->render('main', [
                    'senarai_iklan' => $senarai_iklan,
                    'iklan_semasa' => $iklan_semasa,
                    'post_iklan' => $post_iklan,
                    'jumlah_permohonan' => $jumlah_permohonan,
                    'jumlahLayak' => $jumlahLayak,
                    'jumlahTidakLayak' => $jumlahTidakLayak,
        ]);
    }

    public function actionAktifIklan($id) {
        $iklan = $this->findModel($id);
        $taraf_jawatan = $iklan->tarafJawatan;
        if ($iklan->load(Yii::$app->request->post())) {
            $iklan->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Iklan Berjaya Di Aktifkan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect('halaman-utama');
        }
        return $this->renderAjax('form_aktif_iklan', ['iklan' => $iklan, 'taraf_jawatan' => $taraf_jawatan]);
    }

    public function findIklan($status) {
        $senarai_iklan = new ActiveDataProvider([
            'query' => Iklan::find()->where(['status' => $status]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $senarai_iklan;
    }

    public function actionTambahIklan() {

        $iklan = new Iklan();

        if ($iklan->load(Yii::$app->request->post())) {
            $iklan->tarikh_tutup = date('Y-m-d', strtotime($iklan->tarikh_buka . '+20 day'));
            $model = $this->findKumpulan($iklan->jawatan_id);
            $iklan->kumpulan_id = $model->job_group;
            $iklan->status = 0;
            $iklan->save();
            $Jawatan = $iklan->taraf_jawatan;
            foreach ($Jawatan as $Jawatan) {
                $tarafJawatan = new TarafJawatan();
                $tarafJawatan->iklan_id = $iklan->id;
                $tarafJawatan->taraf_jawatan_id = $Jawatan;
                $tarafJawatan->save();
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['tambah-kelayakan', 'id' => $iklan->id]);
        }

        return $this->render('form_tambah_iklan', [
                    'iklan' => $iklan,
        ]);
    }

    protected function findTarafJawatan($id) {
        return ArrayHelper::toArray(TarafJawatan::find()->select('taraf_jawatan_id')->where(['iklan_id' => $id])->column());
    }

    public function actionEditIklan($id) {

        $iklan = $this->findModel($id);
        $iklan->taraf_jawatan = $this->findTarafJawatan($id);

        if ($iklan->load(Yii::$app->request->post())) {
            $iklan->tarikh_tutup = date('Y-m-d', strtotime($iklan->tarikh_buka . '+20 day'));
            $model = $this->findKumpulan($iklan->jawatan_id);
            $iklan->kumpulan_id = $model->job_group;
            $iklan->status = 0;

            if (!empty($iklan->taraf_jawatan)) {
                TarafJawatan::deleteAll(['iklan_id' => $iklan->id]);
                $Jawatan = $iklan->taraf_jawatan;
                foreach ($Jawatan as $Jawatan) {
                    $tarafJawatan = new TarafJawatan();
                    $tarafJawatan->iklan_id = $iklan->id;
                    $tarafJawatan->taraf_jawatan_id = $Jawatan;
                    $tarafJawatan->save();
                }
            }

            $iklan->save();
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['iklan', 'id' => $iklan->id]);
        }

        return $this->render('form_tambah_iklan', [
                    'iklan' => $iklan,
        ]);
    }

    public function actionTambahKelayakan($id) {
        $iklan = $this->findModel($id);
        $taraf_jawatan = $iklan->tarafJawatan;

        $tambah_kelayakan = new Kelayakan();

        if ($tambah_kelayakan->load(Yii::$app->request->post())) {
            $tambah_kelayakan->iklan_id = $id;
            $tambah_kelayakan->save();
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['tambah-kelayakan', 'id' => $id]);
        }

        return $this->render('form_tambah_kelayakan', [
                    'iklan' => $iklan,
                    'tambah_kelayakan' => $tambah_kelayakan,
                    'taraf_jawatan' => $taraf_jawatan,
        ]);
    }

    public function actionTambahTugas($id) {
        $iklan = $this->findModel($id);
        $taraf_jawatan = $iklan->tarafJawatan;

        $tugas = new TugasJawatan();

        if ($tugas->load(Yii::$app->request->post()) && $tugas->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['tambah-tugas', 'id' => $id]);
        }

        return $this->render('form_tambah_tugas', [
                    'iklan' => $iklan,
                    'tugas' => $tugas,
                    'taraf_jawatan' => $taraf_jawatan,
        ]);
    }

    public function actionSimpanIklan() {

        Yii::$app->session->setFlash('alert', ['title' => 'Iklan Berjaya Di Simpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
        return $this->redirect(['halaman-utama']);
    }

    public function actionIklan($id) {
        $iklan = $this->findModel($id);
        $taraf_jawatan = $iklan->tarafJawatan;

        return $this->render('view_iklan', [
                    'iklan' => $iklan,
                    'taraf_jawatan' => $taraf_jawatan,
        ]);
    }

    public function actionIklanSemasa($id) {
        $iklan = $this->findModel($id);
        $taraf_jawatan = $iklan->tarafJawatan;

        return $this->render('view_iklan_semasa', [
                    'iklan' => $iklan,
                    'taraf_jawatan' => $taraf_jawatan,
        ]);
    }

    protected function findLain2($ICNO) {
        return TblpLain2::findOne(['ICNO' => $ICNO]);
    }

    protected function findUserCawangan($ICNO) {
        return ArrayHelper::toArray(TblpCawangan::find()->select('cawangan_id')->where(['ICNO' => $ICNO])->column());
        
//        if($model){
//            return $model;
//        }else{
//            return [];
//        }
    }

    protected function findUserTarafJawatan($ICNO) {
        return ArrayHelper::toArray(TblpTarafJawatan::find()->select('taraf_jawatan_id')->where(['ICNO' => $ICNO])->column());
        
//        if($model){
//            return $model;
//        }else{
//            return [];
//        }
    }

    public function actionAttachment($ICNO) {

        $biodata = $this->findPemohon($ICNO);

        $model = $this->findLain2($ICNO);
        $model->cawangan = $this->findUserCawangan($ICNO);
        $model->taraf_jawatan = $this->findUserTarafJawatan($ICNO);

        return $this->render('view_lampiran', [
                    'biodata' => $biodata,
                    'eduhighest' => $biodata->pengajianTinggi,
                    'bahasa' => $biodata->bahasa,
                    'kelayakan' => $biodata->kelayakanProf,
                    'kecacatan' => $biodata->kecacatan,
                    'lesen' => $biodata->lesen,
        ]);
    }

    public function actionResume($jenis_user_id, $ICNO) {

        if ($jenis_user_id == 1) {
            $biodata = $this->findStaff($ICNO);

            return $this->render('resume_staff', [
                        'biodata' => $biodata,
            ]);
        } else {

            $biodata = $this->findPemohon($ICNO);

            $model = $this->findLain2($ICNO);
//            $model->cawangan = $this->findUserCawangan($ICNO);
//            $model->taraf_jawatan = $this->findUserTarafJawatan($ICNO);

            return $this->render('resume_pemohon', [
                        'biodata' => $biodata,
                        'alamat' => $biodata->alamat,
                        'keluarga' => $biodata->keluarga,
                        'pengajianTinggi' => $biodata->pengajianTinggi,
                        'peringkatSekolah' => $biodata->peringkatSekolah,
                        'bahasa' => $biodata->bahasa,
                        'kelayakanProf' => $biodata->kelayakanProf,
                        'pengalaman' => $biodata->pengalamanKerja,
                        'kecacatan' => $biodata->kecacatan,
                        'penerbitan' => $biodata->penerbitan,
                        'persidangan' => $biodata->persidangan,
                        'bonKontrak' => $biodata->bonKontrak,
                        'rujukan' => $biodata->rujukan,
                        'lainlain' => $model,
            ]);
        }
    }

    protected function findStaff($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }

    protected function findPemohon($ICNO) {
        return TblpBiodata::findOne(['ICNO' => $ICNO]);
    }
    
    protected function findJumlahPermohonanSemasa() {
        return TblpPermohonan::find()->count();
    }
    
    protected function findJumlahPermohonan($id) {
        return TblpPermohonan::find()->where(['status_saringan_id' => $id])->count();
    }

    public function actionSaringanLayak($id) {

        $title = "LAYAK";
        $searchStaff = new TblpPermohonanSearch();
        $searchStaff->iklan_id = $id;
        $searchStaff->jenis_user_id = 1;
        $searchStaff->status_saringan_id = 2;
        $staff = $searchStaff->search(Yii::$app->request->post());

        $searchOrgAwam = new TblpPermohonanSearch();
        $searchOrgAwam->iklan_id = $id;
        $searchOrgAwam->jenis_user_id = 2;
        $searchOrgAwam->status_saringan_id = 2;
        $orgAwam = $searchOrgAwam->search(Yii::$app->request->post());
 
        return $this->render('view_saringan', [
                    'staff' => $staff,
                    'orgAwam' => $orgAwam,
                    'title' => $title, 
        ]);
    }

    public function actionSaringanTidakLayak($id) {

        $title = "TIDAK LAYAK";
        $searchStaff = new TblpPermohonanSearch();
        $searchStaff->iklan_id = $id;
        $searchStaff->jenis_user_id = 1;
        $searchStaff->status_saringan_id = 3;
        $staff = $searchStaff->search(Yii::$app->request->post());

        $searchOrgAwam = new TblpPermohonanSearch();
        $searchOrgAwam->iklan_id = $id;
        $searchOrgAwam->jenis_user_id = 2;
        $searchOrgAwam->status_saringan_id = 3;
        $orgAwam = $searchOrgAwam->search(Yii::$app->request->post());

        return $this->render('view_saringan', [
                    'staff' => $staff,
                    'orgAwam' => $orgAwam,
                    'title' => $title,
        ]);
    }

    protected function findKumpulan($id) {
        if (($model = GredJawatan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel($id) {
        if (($model = Iklan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPdf($id, $title) {

        if ($title == 'Pengajian Tinggi') {
            $model = TblpEduHighest::findOne(['id' => $id]);
            $completePath = 'http://ejobs.ums.edu.my/ejobs/web/uploads/ejobs/file/eSisraf/' . $model->FileSisraf;
            return Yii::$app->response->sendFile($completePath, $model->FileSisraf);
            //PREVIEW
            //return Yii::$app->response->sendFile($completePath, $model->FileSisraf,['inline'=>true]);
        }

        if ($title == 'Kelayakan Profesional') {
            $model = TblpKelayakanProfesional::findOne(['id' => $id]);
            $completePath = Yii::getAlias('@app/web/uploads/ejobs/file/kelayakanProf/' . $model->FileProf);

            return Yii::$app->response->sendFile($completePath, $model->FileProf);
        }

        if ($title == 'Kecacatan') {
            $model = TblpKecacatan::findOne(['id' => $id]);
            $completePath = Yii::getAlias('@app/web/uploads/ejobs/file/kecacatan/' . $model->FileOku);

            return Yii::$app->response->sendFile($completePath, $model->FileOku);
        }

        if ($title == 'Lesen') {
            $model = TblpLesen::findOne(['licId' => $id]);
            $completePath = Yii::getAlias('@app/web/uploads/ejobs/file/lesen/' . $model->FileLesen);

            return Yii::$app->response->sendFile($completePath, $model->FileLesen);
        }

        if ($title == 'Bahasa') {
            $model = TblpBahasa::findOne(['id' => $id]);
            $completePath = Yii::getAlias('@app/web/uploads/ejobs/file/bahasa/' . $model->FileBahasa);

            return Yii::$app->response->sendFile($completePath, $model->FileBahasa);
        }
    }

}
