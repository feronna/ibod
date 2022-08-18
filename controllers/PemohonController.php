<?php

namespace app\controllers;

use yii\helpers\Html;
use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\hronline\Tblsubjek;
use app\models\ejobs\TblpSbbKehadiran;
use app\models\ejobs\TblpPermohonan;
use app\models\ejobs\TblpTemuduga;
use app\models\ejobs\TblpKompetensi;
use app\models\ejobs\StatusTemuduga;
use app\models\ejobs\StatusKompetensi;
use app\models\ejobs\Kompetensi;
use app\models\ejobs\Temuduga;
use app\models\ejobs\Iklan;
use app\models\ejobs\IklanSearch;
use app\models\ejobs\StatusPermohonan; 
use app\models\ejobs\StatusPermohonanDalaman;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\models\ejobs\Penempatan;
use app\models\ejobs\TblpUlasan;
use app\models\Notification;
use kartik\mpdf\Pdf;
use app\models\ejobs\GredJawatan;

class PemohonController extends Controller {

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
                    'halaman-utama','syarat-lantikan','semak-kelayakan','jawatan-semasa', 'ujian-khas','temuduga',
                    //admin
                    'pengesahan','pengesahan-pp','update-status-saringan','lihat-tindakan',
                ],
                'rules' => [
                    [//pengguna
                        'actions' => ['halaman-utama','syarat-lantikan','semak-kelayakan','jawatan-semasa', 'ujian-khas','temuduga'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['!=', 'Status', '6'])->one();
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//admin
                        'actions' => ['pengesahan','pengesahan-pp','update-status-saringan','lihat-tindakan'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = Department::findOne(['chief' => Yii::$app->user->getId(),'isActive'=>1]);
                            $tmp2 = Department::findOne(['pp' => Yii::$app->user->getId(),'isActive'=>1]);
                            return (!empty($tmp) || !empty($tmp2)) ? true : false;
                        }
                    ],
                ],
            ],
        ];
    }

    protected function ICNO() {

        return Yii::$app->user->getId();
    } 

    public function actionHalamanUtama() {

        if (TblpPermohonan::isPp(Yii::$app->user->getId()) || TblpPermohonan::isKj(Yii::$app->user->getId())) {
            return $this->redirect(['pengesahan']);
        } else {

            $biodata = $this->findModel();
            $searchModel = new IklanSearch();

            $model = new GredJawatan();
            $model->jawatanArr = null;
            if ($model->load(Yii::$app->request->post())) {
                return $this->redirect(['pengakuan-pemohon', 'id' => $model->jawatanArr]);
            }

            return $this->render('main', [
                        'searchModel' => $searchModel,
                        'biodata' => $biodata,
                        'model' => $model,
            ]);
        }
    }

    public function actionHalamanUtamappkj() {

        $biodata = $this->findModel();
        $searchModel = new IklanSearch();

        $model = new GredJawatan();

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['pengakuan-pemohon', 'id' => $model->jawatanArr]);
        }

        return $this->render('main', [
                    'searchModel' => $searchModel,
                    'biodata' => $biodata,
                    'model' => $model,
        ]);
    }

    public function actionPengakuanPemohon(array $id) {
        $iklan = Iklan::find()->where(['IN', 'jawatan_id', $id])->andWhere(['status' => 1])->andWhere(['status_dalaman' => 1])->all();
        $arr = TblpPermohonan::find()->where(['ICNO' => Yii::$app->user->getId()])->all();
        $Existpermohonan = array();
        foreach ($arr as $arr) {
            $Existpermohonan[] = $arr->iklan_id;
        }
        if ($iklan) {
            $model = new TblpPermohonan();
            $biodata = $this->findModel();
            $bm = $this->findEduBM(14, 12);

            if ($bm) {
                $bmSpm = $bm; //spm
            } else {
                $bmSpm = $this->findEduBM(23, 12); //spmv
            }

            $bmPmr = $this->findEduBM(15, 260);

            if ($this->findAlamat()) {
                if ($model->load(Yii::$app->request->post())) {
                    if ($model->agree == 0) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Amaran !', 'type' => 'error', 'msg' => 'Sila tanda kotak semak permohonan.']);
                        return $this->redirect(['pengakuan-pemohon', 'id' => $id]);
                    } else {
                        $department = $model->biodataStaff->DeptId;
                        $ICNO = $model->ICNO;
                        $dtmohon = $model->tarikh_mohon;
                        $dttutup = $model->tarikh_tutup;
                        $pengakuanTxt = $model->pengakuanTxt;
                        foreach ($iklan as $iklan) {
                            if (!in_array($iklan->id, $Existpermohonan)) {
                                $model2 = new TblpPermohonan();
                                $model2->iklan_id = $iklan->id;
                                $model2->ICNO = $ICNO;
                                $model2->tarikh_mohon = $dtmohon;
                                $model2->tarikh_tutup = $dttutup;
                                $model2->pengakuanTxt = $pengakuanTxt;
                                $model2->pp = $biodata->department->pp;
                                $model2->kj = $biodata->department->chief;
                                $model2->jenis_user_id = 1;
                                $model2->status_id = 1;
                                $model2->status_saringan_id = 2;

                                if ($biodata->NatCd == 'MYS') { //check warganegara
                                    //check min edu
                                    if ($biodata->pendidikan->HighestEduLevelRank <= $iklan->pendidikanTertinggi->HighestEduLevelRank) {
                                        if (($iklan->min_bm_pmr == 1) && ($iklan->min_bm_spm == 0)) {
                                            if (($bmPmr != null)) {
                                                if ($bmPmr->Grade_id <= 14) {
                                                    $model2->save(false);
                                                } else {// not credit
                                                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => 'Anda tidak memenuhi syarat kelayakan akademik yang ditetapkan.']);
                                                    return $this->redirect(['halaman-utama']);
                                                }
                                            } else {
                                                Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => 'Sila lengkapkan maklumat pendidikan; sarjana muda, diploma/setaraf, SPM/setaraf dan PMR sebelum menghantar permohonan).']);
                                                return $this->redirect(['pendidikan/view']);
                                            }
                                        } else {
                                            if ($bmSpm != null) {
                                                if ($bmSpm->Grade_id <= 14) {
                                                    $model2->save(false);
                                                } else {// not credit
                                                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => 'Anda tidak memenuhi syarat kelayakan akademik yang ditetapkan.']);
                                                    return $this->redirect(['halaman-utama']);
                                                }
                                            } else {
                                                Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => 'Sila lengkapkan maklumat pendidikan; sarjana muda, diploma/setaraf, SPM/setaraf dan PMR sebelum menghantar permohonan).']);
                                                return $this->redirect(['pendidikan/view']);
                                            }
                                        }
                                    } else {//highestedu level fail
                                        Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => 'Anda tidak memenuhi syarat kelayakan akademik yang ditetapkan.']);
                                        return $this->redirect(['halaman-utama']);
                                    }
                                } else {//bukan warganegara
                                    if ($biodata->pendidikan->HighestEduLevelRank <= $iklan->pendidikanTertinggi->HighestEduLevelRank) {
                                        $model2->save(false);
                                    } else {//highestedu level fail
                                        Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => 'Anda Tidak mememuhi syarat minimum kelayakan jawatan.']);
                                        return $this->redirect(['halaman-utama']);
                                    }
                                }
                            }
                        }//end iklan
                        //notifkasi pp
                        $content = "Perakuan permohonan jawatan kosong menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', ['pemohon/pengesahan'], ['class' => 'btn btn-primary btn-sm']);
                        $dep = Department::findOne(['id' => $department]);
                        if ($dep) {
                            if ($dep->pp) {
                                $this->notifikasi($dep->pp, $content);
                            } else {
                                $this->notifikasi($dep->chief, $content);
                            }
                        }
                        Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Diterima', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                        return $this->redirect(['jawatan-semasa']);
                    }
                }

                return $this->render('form_pengakuan', [
                            'iklan' => $iklan,
                            'model' => $model,
                            'biodata' => $biodata,
                            'bmSpm' => $bmSpm,
                            'bmPmr' => $bmPmr,
                ]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => 'Sila lengkapkan alamat anda.']);
                return $this->redirect(['alamat/view']);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => 'Sila pilih jawatan yang dimohon.']);
            return $this->redirect(['halaman-utama']);
        }
    }

    protected function findAlamat() {
        return \app\models\hronline\Tblalamat::findOne(['ICNO' => $this->ICNO()]);
    }

    public function actionJawatanSemasa() {
        //iklan luar
        $iklan = $this->findPermohonan();
        $status_dalaman = $this->findStatusDalaman();

        return $this->render('view_jawatan_semasa', [
                    'iklan' => $iklan,
                    'status_dalaman' => $status_dalaman,
        ]);
    }

    public function actionUjianKhas() {
        $kompetensiDalaman = $this->findKompetensi(1);
        $statusKompetensi = $this->findStatusKompetensi();

        return $this->render('view_ujian_khas', [
                    'kompetensiDalaman' => $kompetensiDalaman,
                    'statusKompetensi' => $statusKompetensi,
        ]);
    }

    public function actionTemuduga() {
        $temudugaDalaman = $this->findTemuduga([1, 0]);
        $statusTemuduga = $this->findStatusIV();

        return $this->render('view_temuduga', [
                    'temudugaDalaman' => $temudugaDalaman,
                    'statusTemuduga' => $statusTemuduga,
        ]);
    }

    public function actionCarianIklan() {
        $searchModel = new IklanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('main_carian', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    protected function findStatus() {
        return StatusPermohonan::find()->all();
    }

    protected function findStatusIV() {
        return StatusTemuduga::find()->all();
    }

    protected function findStatusKompetensi() {
        return StatusKompetensi::find()->all();
    }

    protected function findStatusDalaman() {
        return StatusPermohonanDalaman::find()->all();
    }

    public function findIv($iklan_id) {
        return Temuduga::findOne(['iklan_id' => $iklan_id]);
    }

    public function findKomp($iklan_id) {
        return Kompetensi::findOne(['iklan_id' => $iklan_id]);
    }

    public function findOwnIv($id) {
        return TblpTemuduga::findOne(['id' => $id]);
    }

    public function findOWnKomp($id) {
        return TblpKompetensi::findOne(['id' => $id]);
    }

    protected function findEduBM($Level_id, $Subject_id) {
        $model = Tblsubjek::findOne(['ICNO' => $this->ICNO(), 'EduLevel_id' => $Level_id, 'Subject_id' => $Subject_id]);

        if ($model) {
            return $model;
        } else {
            return null;
        }
    }

    protected function findIklanbyID($id) {
        if (($model = Iklan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findPermohonan() {

        $permohonan = new ActiveDataProvider([
            'query' => TblpPermohonan::find()
                    ->where(['ICNO' => $this->ICNO()])
                    ->joinWith('iklan')
                    ->andWhere(['dustBstatus' => 0]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $permohonan;
    }

    protected function findTemuduga($id) {

        $temuduga = new ActiveDataProvider([
            'query' => TblpTemuduga::find()
                    ->joinWith('iklan')
                    ->where(['iklan.status_dalaman' => $id])
                    ->andWhere(['ICNO' => $this->ICNO()])
                    ->andWhere(['dustBstatus' => 0]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $temuduga;
    }

    protected function findKompetensi($id) {

        $temuduga = new ActiveDataProvider([
            'query' => TblpKompetensi::find()
                    ->joinWith('iklan')
                    ->Where(['iklan.status_dalaman' => $id])
                    ->andWhere(['tbl_kompetensi.ICNO' => $this->ICNO()])
                    ->andWhere(['tbl_kompetensi.dustBstatus' => 0]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $temuduga;
    }

    protected function findModel() {
        if (($model = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    } 
    
    public function actionIklan($id) {
        $iklan = $this->findModelIklan($id);
        $taraf_jawatan = $iklan->tarafJawatan;
        $penempatan = Penempatan::findAll(['iklan_id' => $id]);
        $gred = GredJawatan::findOne(['id' => $iklan->jawatan_id]);

        return $this->render('view_iklan', [
                    'iklan' => $iklan,
                    'taraf_jawatan' => $taraf_jawatan,
                    'penempatan' => $penempatan,
                    'gred' => $gred
        ]);
    }

    protected function findModelIklan($id) {
        if (($model = Iklan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function GridTindakan($title, $status) {
        $data = new ActiveDataProvider([
            'query' => TblpPermohonan::find()
                    ->where(['tbl_permohonan.status_saringan_id' => $status])
                    ->andWhere(['=', 'tbl_permohonan.' . $title, Yii::$app->user->getId()])
                    ->andWhere(['!=', 'tbl_permohonan.ICNO', Yii::$app->user->getId()])
                    ->andWhere(['tbl_permohonan.jenis_user_id' => 1])
                    ->joinWith('iklan')
                    ->joinWith('biodata')
                    ->andWhere(['tblprcobiodata.Status' => 1])
                    ->andWhere(['!=', 'iklan.status', 3])
                    ->orderBy(['tbl_permohonan.tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionPengesahan() {

        if (TblpPermohonan::isPp(Yii::$app->user->getId())) {
            $permohonan = $this->GridTindakan('pp', [2, 4, 5]);
            $title = 'Persetujuan';
            $pending = TblpPermohonan::PpDetails();
            $icno = $pending->pp;
        } elseif (TblpPermohonan::isKj(Yii::$app->user->getId())) {
            if (TblpPermohonan::checkPP(Yii::$app->user->getId()) == 1) {
                $permohonan = $this->GridTindakan('kj', [4, 6, 7]);
            } else { //if pp is null 
                $permohonan = $this->GridTindakan('kj', [2, 6, 7]);
            }
            $title = 'Perakuan';
            $pending = TblpPermohonan::KjDetails();
            $icno = $pending->chief;
        }
        $this->pendingtask($icno, null);

        return $this->render('view_pengesahan', [
                    'permohonan' => $permohonan,
                    'permohonanDitolak' => $this->GridTindakan('kj', [5]),
                    'title' => $title,
        ]);
    }

    public function GridTindakanPP() {
        $pp = Department::find()->where(['chief' => Yii::$app->user->getId()])->one();
        if ($pp) {
            $icno = $pp->pp;
        } else {
            $icno = 1; //dummy
        }

        $data = new ActiveDataProvider([
            'query' => TblpPermohonan::find()
                    ->where(['status_saringan_id' => 2])
                    ->andWhere(['=', 'kj', Yii::$app->user->getId()])
                    ->andWhere(['!=', 'ICNO', Yii::$app->user->getId()])
                    ->andWhere(['ICNO' => $icno])
                    ->joinWith('iklan')
                    ->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionPengesahanPp() {
        if (TblpPermohonan::isKj(Yii::$app->user->getId())) {
            $permohonan = $this->GridTindakanPP();
        }
        $title = 'Perakuan';
        return $this->render('view_pengesahan_temp', [
                    'permohonan' => $permohonan,
                    'title' => $title,
        ]);
    }

    public function actionUpdateStatusSaringan($id) {

        $model = TblpPermohonan::find()->where(['id' => $id])->one();
        $department = $model->biodataStaff->DeptId;

        $ulasan = new TblpUlasan();

        if (TblpPermohonan::isPp(Yii::$app->user->getId())) {
            $title = 'pp';
        } else {
            $title = 'kj';
        }

        if ($ulasan->load(Yii::$app->request->post()) && $ulasan->validate()) {

            //create new ulasan
            if ($ulasan->desc) {
                if ($title == 'pp') {
                    $ulasan->status_id = 4; //update status saringan
                    $model->status_id = 2; //update status semasa
                    //notifkasi chief
                    $content = "Perakuan permohonan jawatan kosong menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', ['pemohon/pengesahan'], ['class' => 'btn btn-primary btn-sm']);
                    $dep = Department::findOne(['id' => $department]);
                    if ($dep) {
                        if ($dep->chief) {
                            $this->notifikasi($dep->chief, $content);
                        }
                    }
                } else {
                    $ulasan->status_id = 6;
                    $model->status_id = 3;
                }
                $ulasan->permohonan_id = $id;
                $ulasan->save();

                //update status saringan
                $model->status_saringan_id = $ulasan->status;
                $model->save(false);
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['pengesahan']);
        }
        return $this->renderAjax('form_tindakan_saringan', [
                    'model' => $ulasan,
                    'title' => $title,
                    'model2' => $model,
        ]);
    }

    public function actionLihatTindakan($id) {

        $model = TblpPermohonan::find()->where(['id' => $id])->one();

        $ulasan = TblpUlasan::find()->where(['permohonan_id' => $id])->andWhere(['ulasan_by' => Yii::$app->user->getId()])->one();
        $ulasan->status = $model->status_saringan_id;
        if (TblpPermohonan::isPp(Yii::$app->user->getId())) {
            $title = 'pp';
        } else {
            $title = 'kj';
        }

        return $this->renderAjax('form_tindakan_saringan', [
                    'model' => $ulasan,
                    'title' => $title,
                    'model2' => $model,
        ]);
    }

    public function actionUlasanPp($id) {

        $model = TblpPermohonan::find()->where(['id' => $id])->one();

        $ulasan = TblpUlasan::find()->where(['permohonan_id' => $id])->andWhere(['!=','ulasan_by', Yii::$app->user->getId()])->one();
 

        return $this->renderAjax('form_ulasan_pp', [
                    'model' => $ulasan, 
                    'model2' => $model,
        ]);
    }

    public function actionUpdateLulusppkj() {
        $model = TblpPermohonan::find()->where(['=', 'status_saringan_id', 4])->joinWith('iklan')->andWhere(['=', 'iklan.status_dalaman', 1])->all();

        foreach ($model as $model) {
            $model->status_id = 2;
            $model->save(false);
        }

        $model2 = TblpPermohonan::find()->where(['=', 'status_saringan_id', [6, 8]])->joinWith('iklan')->andWhere(['=', 'iklan.status_dalaman', 1])->all();

        foreach ($model2 as $model2) {
            $model2->status_id = 3;
            $model2->save(false);
        }

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya !', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);

        return $this->redirect(['halaman-utama']);
    }

    public function notifikasi($icno, $content) {
        //--------Model Notification-----------//
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $icno;
        $ntf->title = 'Ejobs';
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        //--------Model Notification-----------//
    }

    public function actionJana($id) {
        $lulus = TblpKompetensi::find()->where(['iklan_id' => $id])->andWhere(['status_saringan_id' => 1])->all();

        foreach ($lulus as $model) {

            $content = 'Makluman Status Temuduga Jawatan. Sila kemaskini status kehadiran temuduga anda.';

            $this->notifikasi($model->ICNO, $content);
        }

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi Berjaya.']);
        return $this->redirect(['halaman-utama']);
    }

    public function actionJemputan($iklan_id, $title) {
        $biodata = $this->findModel();
        if ($title == 'iv') {
            $iv = $this->findIv($iklan_id);
            $content = $this->renderPartial('letter_jemputan_iv', ['iv' => $iv, 'biodata' => $biodata]);
        } elseif ($title == 'komp') {
            $komp = $this->findKomp($iklan_id);
            $content = $this->renderPartial('letter_jemputan_komp', ['komp' => $komp, 'biodata' => $biodata]);
        }

        return $this->generatePdf($content);
    }

    public function generatePdf($content) {
        $css = file_get_contents('./css/surat.css');
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

    public function KehadiranDiterima($model) {
        $model->sah_kehadiran = date('Y-m-d H:i:s');
        $model->save();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
        return $this->redirect(['temuduga']);
    }

    public function KehadiranDitolak($model) {
        if (empty($model->ulasan)) {
            Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila isi ulasan kehadiran.']);
            return $this->redirect(['temuduga']);
        } else {
            $this->SimpanUlasan($model);
        }
    }

    public function actionKehadiran($id, $title) {

        if ($title == 'iv') {
            $model = $this->findOwnIv($id);
        } elseif ($title == 'komp') {
            $model = $this->findOwnKomp($id);
        }

        if ($model->load(Yii::$app->request->post())) {
            //check null
            if (empty($model->status_kehadiran_id)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila isi status kehadiran.']);
                return $this->redirect(['temuduga']);
            } else {
                if ($title == 'iv') {
                    if ($model->iklan->status_skype_iv == 1) {
                        if ($model->status_kehadiran_id == 3) {
                            $this->KehadiranDitolak($model);
                        } else {
                            $this->KehadiranDiterima($model);
                        }
                    } else if ($model->status_kehadiran_id == 2) {
                        $this->KehadiranDitolak($model);
                    } else {
                        $this->KehadiranDiterima($model);
                    }
                } else if ($title == 'komp') {
                    if ($model->status_kehadiran_id == 2) {
                        $this->KehadiranDitolak($model);
                    } else {
                        $this->KehadiranDiterima($model);
                    }
                }
            }
        }

        return $this->renderAjax('form_kehadiran', ['model' => $model, 'title' => $title]);
    }

    public function SimpanUlasan($model) {
        //update status_saringan_id
        $model->sah_kehadiran = date('Y-m-d H:i:s');
        $model->save();
        //simpan ulasan
        $sbb = new TblpSbbKehadiran();
        $sbb->permohonan_id = $model->permohonan_id;
        $sbb->desc = $model->ulasan;
        $sbb->save(false);

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
        return $this->redirect(['temuduga']);
    }

    public function actionSyaratLantikan() {
        $model = new GredJawatan();
        $biodata = $this->findModel();

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['semak-kelayakan', 'id' => $model->jawatan]);
        }
        return $this->render('form_syarat_lantikan', [
                    'iklan' => NULL,
                    'model' => $model,
                    'biodata' => $biodata,
        ]);
    }

    public function actionSemakKelayakan($id) {
        $model = new GredJawatan();
        $iklan = Iklan::find()->where(['jawatan_id' => $id])->andWhere(['status' => 1])->andWhere(['status_dalaman' => 1])->one();
        $biodata = $this->findModel();
        $taraf_jawatan = $iklan->tarafJawatan;
        $penempatan = Penempatan::findAll(['iklan_id' => $iklan->id]);

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['semak-kelayakan', 'id' => $model->jawatan]);
        }
        return $this->render('form_syarat_lantikan', [
                    'iklan' => $iklan,
                    'model' => $model,
                    'biodata' => $biodata,
                    'taraf_jawatan' => $taraf_jawatan,
                    'penempatan' => $penempatan,
        ]);
    }

    protected function pendingtask($icno, $id) {
        $runner = new \tebazil\runner\ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }

    public function Grid($query) {
        $data = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }  
}
