<?php

namespace app\controllers;

use Yii;
use app\models\mohonjawatan\TblOpenpos;
use app\models\mohonjawatan\TblOpenposSearch;
use app\models\mohonjawatan\TblPermohonan;
use kartik\mpdf\Pdf;
use app\models\mohonjawatan\TblFile;
use app\models\mohonjawatan\TblPermohonanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\Notification;
use yii\web\UploadedFile;
use app\models\mohonjawatan\TblPenetapanGaji;
use app\models\mohonjawatan\TblAksesPerjawatan;
use app\models\mohonjawatan\RefSetpegawai;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\helpers\Html;

/**
 * OpenposController implements the CRUD actions for TblOpenpos model.
 */
class OpenposController extends Controller {

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
                'only' => ['bukapermohonan','spermohonanindividu','senaraipermohonan','tambahadmin', 'memohon', 'stindakanpermohonan','downloadusermanual','download-guidelines'],
                'rules' => [
                    [
                        'actions' => ['senaraipermohonan', 'memohon','download-guidelines','downloadusermanual'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            if (Department::find()->where(['chief' => $logicno])->exists()) {
                                $check = Department::findAll(['chief' => $logicno]);
                            } elseif (Department::find()->where(['pp' => $logicno])->exists()) {
                                $check = Department::findAll(['pp' => $logicno]);
                            } else {
                                $check = TblAksesPerjawatan::findAll(['icno' => $logicno]);
                            }

                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['bukapermohonan','spermohonanindividu','senaraipermohonan','tambahadmin', 'memohon', 'stindakanpermohonan','downloadusermanual','download-guidelines'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            if (Department::find()->where(['chief' => $logicno])->exists()) {
                                $check = Department::findAll(['chief' => $logicno]);
                            } else {
                                $check = TblAksesPerjawatan::findAll(['icno' => $logicno]);
                            }

                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                ],
            ],
        ];
    }

//    public function actionDeleteFiles($id) {
//        $model = TblPermohonan::find()->where(['id' => $id])->one()->ringkasan;
//        if ($model) {
//            if (!unlink($foto)) {
//                return false;
//            }
//        }
//
//        $akaun = TblPermohonan::findOne($id);
//        $akaun->ringkasan = NULL;
//        $akaun->memohon();
//        return $this->redirect(['memohon', 'id' => $id]);
//    }
    //download user manual 
    public function actionDownloadusermanual() {
        $icno = Yii::$app->user->getId();
        $path = Yii::getAlias('@webroot') . '/uploads';

        if (TblAksesPerjawatan::find()->where(['icno' => $icno])->exists()) {
            $file = $path . '/MANUAL_PENGGUNA_SISTEM_PERMOHONAN_JAWATAN.pdf';
        } elseif (Department::find()->where(['pp' => $icno])->exists()) {
            $file = $path . '/MANUAL_PENGGUNA_SISTEM_PERMOHONAN_JAWATAN.png';
        } elseif (Department::find()->where(['chief' => $icno])->exists()) {
            $file = $path . '/MANUAL_PENGGUNA_SISTEM_PERMOHONAN_JAWATAN.pdf';
        }
        if (file_exists($file)) {
//        var_dump("1");die;
            Yii::$app->response->sendFile($file);
        }
    }

    public function actionAdminView() {
        $icno = Yii::$app->user->getId();
        $searchModel = new TblPermohonanSearch();
        $status = ['PINDAAN', 'APPROVED', 'REJECTED', 'PENDING'];
        $query = TblPermohonan::find()->where(['in', 'status', $status]);

        if (Yii::$app->request->post('notikj')) {
            $noti = TblPermohonan::find()->select('app_by')->distinct()->where(['status_kj' => 'ENTRY'])->all();
//             var_dump($noti);die;
            foreach ($noti as $sendnoti) {
                $ntf = new Notification(); //noti untuk kp
                $ntf->icno = $sendnoti->app_by;
                $ntf->title = 'Permohonan Jawatan';
                $ntf->content = 'Permohonan Jawatan Daripada Ketua Pentadbiran Menunggu Tindakan Anda. Klik Butang ini untuk ke sistem Permohonan Jawatan  ' . Html::a('Permohonan Jawatan', ['/openpos/index'], ['class' => 'btn btn-info']) . '';
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            }
            return $this->redirect(['admin-view']);
        }
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('admin-view', [
                        'data' => $data,
            ]);
        }
        return $this->render('admin-view', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
        ]);
    }

    public function actionDownloadGuidelines() {
        $icno = Yii::$app->user->getId();
        $path = Yii::getAlias('@webroot') . '/uploads';
//file path tukar dengan nama guidelines
        $file = $path . '/GARISPANDUANPERMOHONANPERJAWATANMELALUIABM.pdf';

        if (file_exists($file)) {
//        var_dump("1");die;
            Yii::$app->response->sendFile($file);
        }
    }

    public function actionJanasurat($id) {
        $icno = Yii::$app->user->getId();
//        var_dump($id);die;
        $kj = Department::find()->where(['pp' => $id])->one();
//        var_dump($kj->chief);die;
        $model = new \app\models\Refpenjanaansurat();

//        var_dump($id);die;
        if ($model->load(Yii::$app->request->post())) {
            $model->tarikh_surat = date('Y-m-d');

            $model->kepada = $kj->chief;
            $model->dijana_oleh = $icno;
//               var_dump($model->no_rujukan);die;

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => '<3']);
                return $this->redirect(['openpos/surat', 'id' => $id]);
            }
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('janasurat', [
                        'model' => $model,
            ]);
        }
    }

    public function actionSurat($id) {
//    $id = Yii::$app->user->getId();
//        var_dump($id);die;
        $kj = Department::find()->where(['pp' => $id])->one();

//         $id = 820127045390;
        $today = date('Y-m-d');
        $model = \app\models\Refpenjanaansurat::findOne(['kepada' => $kj->chief, 'tarikh_surat' => $today]);
//        $model1 = Tblprcobiodata::findOne(['ICNO'=>$id]);
//        var_dump($models->ICNO);
        $mpdf = new \Mpdf\Mpdf();
        $pagecount = $mpdf->SetSourceFile('uploads/surat/Surat kelulusan Perjawatan.pdf');
        for ($i = 1; $i <= $pagecount; $i++) {
            $import_page = $mpdf->ImportPage($i);
            $mpdf->UseTemplate($import_page);
            if ($i == 1) { //page1
                $mpdf->WriteHTML($this->renderPartial('surat', ['model' => $model]));
            }
            if ($i < $pagecount) {
                $mpdf->AddPage();
            }
        }
        $mpdf->Output();
    }

    //generate lampiran
    public function actionReport($id) {
//$id = 820127045390;
        $status = ['VERIFIED', 'REJECTED'];
        $model = TblPermohonan::find()->where(['icno' => $id])
                        ->andWhere(['in', 'status', $status])->orderBy(['jawatan_dipohon' => SORT_ASC])->all();

//        return $this->render('senaraipermohonan', ['bil' => 1, 'ver' => $ver, 'app' => $app, 'model' => $model]);
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_lampiran', ['bil' => 1, 'model' => $model]);

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
            'options' => ['title' => 'Lampiran Permohonan Jawatan'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['Lampiran Permohonan Jawatan'],
                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
            //                'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    //kartiks
    public function actionIndexs() {
//        $id = 163;
        $icno = Yii::$app->user->getId();
//        $model = $this->findModelbyid($id);

        $files = TblFile::find()->where(['uploaded_by' => $icno])->andWhere(['status' => 1])->all();
        return $this->render('indexs', [
                    'files' => $files,
//            'model'=> $model,
        ]);
    }

    public function actionDeletegambar($id) {
        $file = TblFile::findOne($id);
//        var_dump($file->namafile);die;
        if (!empty($file->namafile && $file->status != 0)) {
            $res = Yii::$app->FileManager->DeleteFile($file->namafile);
            if ($res->status == true) {
                //0 =  deleted
                $file->status = '0';
                $file->update();
            }
        }
        return $this->redirect(['indexs']);
    }

    public function actionDeletedoc($id) {
        $file = TblPermohonan::findOne($id);
//        var_dump($file->namafile);die;
        if (!empty($file->doc_sokongan && $file->doc_sokongan != 'deleted')) {
            $res = Yii::$app->FileManager->DeleteFile($file->doc_sokongan);
            if ($res->status == true) {
                //0 =  deleted
                $file->doc_sokongan = 'deleted';
                $file->update();
            }
        }
        return $this->redirect(['updatepermohonan', 'id' => $id]);
    }

    public function actionUploadedlist($id) {

        $files = TblFile::find()->where(['uploaded_by' => $id])->andWhere(['status' => 1])->all();
        return $this->render('uploadedlist', [
                    'files' => $files,
        ]);
    }

    public function actionDeletes($id) {
        $icno = Yii::$app->user->getId();
        $foto = TblFile::find()->where(['id' => $id])->one();
//        $foto2 = Yii::getAlias('@web') . '/uploads/' .$icno.'/'. $foto->namafile;
//        var_dump($foto2);die;
//         if($foto2){
//            if(!unlink($foto2)){
//                return false;
//            }
//        }
//                var_dump($foto);die;

        @unlink(Yii::getAlias('@web') . '/uploads/' . $foto->namafile);
        $foto->delete();
        return $this->redirect(['indexs']);
    }

    public function actionDeleteUpload() {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $keys = Yii::$app->request->post('key');
        $key = explode(' ', $keys);

        $model = File::find()->where([
                    'id' => $key[1],
                        //'create_id' => Yii::$app->user->id
                ])->one();

        if ($key[0] == 'namafile') {
            @unlink(Yii::getAlias('@web') . '/uploads/' . $model->namafile);
            $model->namafile = NULL;
            $model->save(false);
        }

        return [];
    }

//    public function actionUpload($id) {
//
//        $mj = TblPermohonan::findOne($id);
//        $mj->status = 'ENTRY';
//
//        if ($mj->load(Yii::$app->request->post())) {
//
//            $mj->doc_sokongan = UploadedFile::getInstance($mj, 'doc_sokongan');
//            if ($mj->doc_sokongan) {
//
//                $file_name = $mj->doc_sokongan . $id . '.' . $mj->doc_sokongan->getExtension();
//                $file_path = 'uploads/' . $file_name;
//                $mj->doc_sokongan->saveAs($file_path);
//                $mj->doc_sokongan = $file_path;
//            }
//            $mj->ringkasan = UploadedFile::getInstance($mj, 'ringkasan');
//            if ($mj->ringkasan) {
//
//                $file_name = $mj->ringkasan . $id . '.' . $mj->ringkasan->getExtension();
//                $file_path = 'uploads/' . $file_name;
//                $mj->ringkasan->saveAs($file_path);
//                $mj->ringkasan = $file_path;
//            }
//            if ($mj->save()) {
//
//                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dihantar', 'type' => 'success', 'msg' => 'Permohonan Baru Berjaya Ditambah!']);
//                return $this->redirect(['memohon']);
//            }
//        }
//
//        return $this->render('index', [
//                    'mj' => $mj
//        ]);
//    }

    public function actionUpdates($id) {
        $icno = Yii::$app->user->getId();
        $model = $this->findModel($id);
        $old_file = $model->namafile;
        if ($model->load(Yii::$app->request->post())) {

            $model->namafile = UploadedFile::getInstance($model, 'namafile');
            if ($model->namafile) {
                $file = $model->namafile->name;
                $file_path = 'uploads/' . $icno;
                FileHelper::createDirectory($file_path);
                $files = 'uploads/' . $icno . '/' . $file;
                $mj->namafile->saveAs($files);
                $mj->namafile = $files;
            }
            if (empty($model->namafile)) {
                $model->namafile = $old_file;
            }

            $model->save();
            return $this->redirect(['indexs']);
        } else {
            return $this->render('updates', [
                        'model' => $model,
            ]);
        }
    }

//upload file
    public function actionCreates() {
        $icno = Yii::$app->user->getId();
//        $icno = 950426125329;
//        $mj = TblPermohonan::findOne($id);
//        var_dump($mj->icno);die;

        $model = new TblFile();

        if ($model->load(Yii::$app->request->post())) {
            $model->namafile = UploadedFile::getInstance($model, 'namafile');


//            if ($model->namafile) {
            $model->uploaded_by = $icno;
            $model->upload_date = date('Y-m-d H:i:s');
            $model->status = '1';
            if ($model->save()) {
//                $id = $model->id;
                $res = Yii::$app->FileManager->UploadFile($model->namafile->name, $model->namafile->tempName, '04', 'PTB/Permohonan');
//                    var_dump($res);die;
                if ($res->status == true) {
                    $model->namafile = $res->file_name_hashcode;
                    $model->save();
                }
            }

            return $this->redirect(['uploadlist']);
        } else {
            return $this->render('creates', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Lists all TblOpenpos models.
     * @return mixed
     */
    public function actionIndex() {
        $icno = Yii::$app->user->getId();

        if (Department::find()->where(['chief' => $icno])->exists()) {
            return $this->redirect('stindakanpermohonan');
        } elseif (Department::find()->where(['pp' => $icno])->exists()) {
            return $this->redirect('senaraipermohonan');
        } else {
            return $this->redirect('spermohonanindividu');
        }
    }

    /**
     * Displays a single TblOpenpos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TblOpenpos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionTest() {
//        $model = Department::find()->where(['id' => [158],])->exists();
        $m = $model = Department::find()->where(['chief' => Yii::$app->user->identity->ICNO])->andWhere(['id' => [158, 2]])->exists();
//        >where([
//    'status' => 10,
//    'type' => null,
//    'id' => [4, 8, 15],
//        $model = TblPermohonan::jawatan(['id' => 950426125329]);
        var_dump($model);
        die;
    }

//upload

    public function actionUploadlist() {
        $icno = Yii::$app->user->getId();
        $model = new TblFile();
        return $this->render('uploadlist', [
                    'model' => $model]);
    }

    public function Notification($icno, $title, $content) {
        $ntf = new Notification();
        $ntf->icno = $icno;
        $ntf->title = $title;
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
    }

    public function actionSenaraipermohonan() {
        $icno = Yii::$app->user->getId();
        $visible = TblOpenpos::find()->where(['status' => 1])->all();
//        var_dump($visible);die;
        $model = TblPermohonan::find()->where(['icno' => $icno])->orderBy(['tarikh_mohon' => SORT_DESC, 'status_kj' => SORT_ASC])->all();

        $ver = TblPermohonan::findAll(['ver_by' => $icno, 'status' => 'ENTRY']);
        $app = TblPermohonan::findAll(['app_by' => $icno, 'status' => 'VERIFIED']);

        return $this->render('senaraipermohonan', ['bil' => 1, 'ver' => $ver, 'app' => $app, 'model' => $model, 'visible' => $visible]);
    }

//function tambah draft
    public function memohon($icno) {
        $default = RefSetpegawai::find()->one();
        $todaydate = date('Y-m-d');
        $model = TblPermohonan::findAll(['icno' => $icno]);
        $mj = new TblPermohonan();

        $dept = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $peg = RefSetpegawai::findOne(['peraku_icno' => $icno]);
        $dept1 = Department::findOne(['id' => $dept->DeptId]);
        if ($mj->load(Yii::$app->request->post())) {
            $mj->icno = $icno;
            $ntf = new Notification();

            if ($dept1->pp == NULL || $dept1->pp == "") {
                $mj->ver_by = $default->pemohon_icno; //ni encik ismail
                $mj->status_kj = 'DRAFT';
                $mj->status = 'DRAFT';
            } else {
                $mj->ver_by = $peg->pemohon_icno; //ni encik ismail
                $mj->app_by = $dept1->chief;
                $mj->status_kj = 'DRAFT';
                $mj->status = 'DRAFT';
            }
//                        $mj->ver_by = 811212125745;

            $mj->dept_id = $dept->DeptId;

            $mj->tarikh_mohon = date('Y-m-d');
            //klu ada peg peraku...     


            $mj->implikasi_kewangan = TblPenetapanGaji::implikasi($mj->jawatan_dipohon);


            $mj->doc_sokongan = UploadedFile::getInstance($mj, 'doc_sokongan');
            if ($mj->doc_sokongan) {

                if ($mj->save()) {
                    $id = $mj->id;
                    $res = Yii::$app->FileManager->UploadFile($mj->doc_sokongan->name, $mj->doc_sokongan->tempName, '04', 'Openpos/DocSokongan');

                    if ($res->status == true) {
                        $mj->doc_sokongan = $res->file_name_hashcode;
                    }
                }
            }

            //testing api
//            $mj->ringkasan = UploadedFile::getInstance($mj, 'ringkasan');
//
//
//            if ($mj->ringkasan) {
//                if ($mj->save()) {
//                    $id = $mj->id;
//                    $res = Yii::$app->FileManager->UploadFile($mj->ringkasan->name, $mj->ringkasan->tempName, '04', 'Openpos/RingkasanPerjawatan');
//
//                    if ($res->status == true) {
//                        $mj->ringkasan = $res->file_name_hashcode;
//                    }
//                }
//            }
            if ($mj->save()) {
                
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dihantar', 'type' => 'success', 'msg' => 'Permohonan anda telah Disimpan Sebagai Draf']);
            return $this->redirect(["openpos/memohon"]);
        }//end post
    }

    public function actionMemohon() {

        $icno = Yii::$app->user->getId();
//        var_dump($icno);die;
        $default = RefSetpegawai::find()->one();
//        var_dump($default->pemohon_icno);die;
        $date = TblOpenpos::findOne(['status' => 1]);
        $todaydate = date('Y-m-d');
        if (Department::find()->where(['chief' => $icno])->exists() || Department::find()->where(['pp' => $icno])->exists() || TblAksesPerjawatan::find()->where(['icno' => $icno, 'isActive' => 1])->exists()) {


            if ($date == NULL || $todaydate >= ($date->date_end)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf',
                    'type' => 'error', 'msg' => 'Harap Maaf.Permohonan Jawatan Masih Belum Dibuka/sudah Tamat']);
                return $this->redirect(['openpos/index']);
            } else {


                $model = TblPermohonan::findAll(['icno' => $icno]);

                $dept = Tblprcobiodata::findOne(['ICNO' => $icno]);
                $peg = RefSetpegawai::findOne(['peraku_icno' => $icno]);
                $dept1 = Department::findOne(['id' => $dept->DeptId]);

                $mj = new TblPermohonan();
                $mj->scenario = 'dokumen';

                if (Yii::$app->request->post('simpan')) {
                    $this->memohon($icno);
                } elseif ($mj->load(Yii::$app->request->post())) {

                    $mj->icno = $icno;
                    $ntf = new Notification();

                    if ($dept1->pp == NULL || $dept1->pp == "") {
                        $mj->ver_by = $default->pemohon_icno; //ni encik ismail
                        $mj->status_kj = 'APPROVED';
                        $mj->status = 'APPROVED';
                    } else {
//                        $mj->ver_by = $peg->pemohon_icno; //ni encik ismail
                        $mj->ver_by = '811212125745'; //ni encik ismail
                        $mj->app_by = $dept1->chief;
                        $mj->status_kj = 'ENTRY';
                        $mj->status = 'ENTRY';
                    }
//                        $mj->ver_by = 811212125745;

                    $mj->dept_id = $dept->DeptId;

                    $mj->tarikh_mohon = date('Y-m-d');
                    //klu ada peg peraku...     


                    $mj->implikasi_kewangan = TblPenetapanGaji::implikasi($mj->jawatan_dipohon);
                    $mj->doc_sokongan = UploadedFile::getInstance($mj, 'doc_sokongan');
                    if ($mj->doc_sokongan) {

                        if ($mj->save()) {

                            $id = $mj->id;
                            $res = Yii::$app->FileManager->UploadFile($mj->doc_sokongan->name, $mj->doc_sokongan->tempName, '04', 'Openpos/DocSokongan');

                            if ($res->status == true) {
                                $mj->doc_sokongan = $res->file_name_hashcode;
                            }
                        }
                    }
                    
                    if ($mj->save()) {

                        if ($dept1->pp == NULL || $dept1->pp == "") {

                            $ntf->icno = $default->pemohon_icno; // peg perjawatan
                            $ntf->title = 'Permohonan Jawatan';
                            $ntf->content = "Permohonan Jawatan daripada ketua jabatan sendiri telah ditambah.";
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                        } else {

                            $ntf->icno = $dept1->chief; // org yg memohon jawatan
                            $ntf->title = 'Permohonan Jawatan';
                            $ntf->content = "Permohonan Jawatan Menunggu Perakuan Anda.";
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                        }
                    }

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dihantar', 'type' => 'success', 'msg' => 'Permohonan anda telah dihantar kepada ketua jabatan anda untuk tindakan seterusnya']);
                    return $this->redirect(["openpos/memohon"]);
                }//end post


                return $this->render('memohon', [
                            'mj' => $mj,
                            'model' => $model,
                            'bil' => 1,
                ]);
                //data grid view
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf',
                'type' => 'error', 'msg' => 'Anda Tiada Akses']);
            return $this->redirect(['openpos/index']);
        }
    }

    //untuk pengawai terlibat untuk buka permohonan
    public function actionBukapermohonan() {

        //ini akan sma macam wbb miji  //kena cari cara utk bt semua pengawai dapat notification
        $icno = Yii::$app->user->getId();
        $akses = TblAksesPerjawatan::find()->where(['icno' => Yii::$app->user->getId()])->exists();
//        var_dump($akses);die;
        if (!($akses)) {
            Yii::$app->session->setFlash('alert', ['title' => 'Error',
                'type' => 'error', 'msg' => 'Harap Maaf. Anda Tidak Mempunyai Akses']);
            return $this->redirect(['openpos/memohon']);
        } else {
            $peg = RefSetpegawai::findAll(['pemohon_icno' => $icno]);
            $kp = Department::find()->where(['isActive' => 1])->all();
            $date = date('Y-m-d');

            $models = TblOpenpos::findAll(['icno' => $icno]);

            $model = new TblOpenpos();

            if ($model->load(Yii::$app->request->post())) {

                $model->entry_dt = date('Y-m-d');

                $model->status = 1;
                $model->icno = $icno;
                if ($model->save()) {

                    foreach ($kp as $kps) {
//                        var_dump($kps->chief);die; 
                        $ntf = new Notification();
                        if ($kps->pp == '' || $kps->pp == NULL) {
                            $ntf->icno = $kps->chief;
                        } else {
                            $ntf->icno = $kps->pp;
                        }

                        $model->entry_dt = date('d-m-Y H:i:s');
                        $date = date_create($model->date_start);
                        $date1 = date_create($model->date_end);
                        $date_start = date_format($date, "d-m-Y");
                        $date_end = date_format($date1, "d/m/Y");

                        $ntf->title = 'Permohonan Jawatan';
                        $ntf->content = "Adalah dimaklumkan bahawa permohonan pengisian jawatan kakitangan pentadbiran di "
                                . "JFPIB dibuka mulai " . $date_start . " hingga " . $date_end . ". " . " Pembukaan Jawatan ini adalah untuk " . $model->remark . " "
                                . "Mohon untuk melengkapkan justifikasi permohonan pada borang yang disediakan  . Terima kasih.. ";
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                    }
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Jawatan Telah Dibuka']);
                return $this->redirect(['openpos/bukapermohonan']);
            }
            $searchModel = new TblOpenposSearch();
            $query = TblOpenpos::find()->where(['icno' => $icno]);
            $DataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('buka_permohonan', [
                        'model' => $model,
                        'models' => $models,
                        'bil' => 1,
                        'searchModel' => $searchModel,
                        'dataProvider' => $DataProvider,
            ]);
        }//end of else
    }

    //senarai permohonan mengikut individu peringkat jabatan
    public function actionS_permohonan() {
        $icno = Yii::$app->user->getId();
        $searchModel = new TblPermohonanSearch();
        $status = ['ENTRY', 'PINDAAN', 'APPROVED', 'REJECTED', 'PENDING'];
        $query = TblPermohonan::find()->select('icno,dept_id')->distinct()->where(['app_by' => $icno])->andWhere(['in', 'status_kj', $status]);
//        var_dump($query);die;
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
       
        return $this->render('s_permohonan', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
        ]);
    }

    //senarai permohonan mengikut individu peringkat perjawatan
    public function actionSpermohonanindividu() {
        $icno = Yii::$app->user->getId();
         $statuss = ['VERIFIED', 'APPROVED'];
        $query = TblPermohonan::find()->where(['ver_by' => $icno])->andWhere(['in', 'status', $statuss]);
        $dataProviders = new ActiveDataProvider([
            'query' => $query,
        ]);
        $searchModel = new TblPermohonanSearch();
        $status = ['PINDAAN', 'APPROVED', 'REJECTED', 'PENDING'];
        if ($icno == 950426125329) {
            $query = TblPermohonan::find()->select('icno,dept_id')->distinct()->where(['in', 'status', $status]);
        } else {
            $query = TblPermohonan::find()->select('icno,dept_id')->distinct()->where(['ver_by' => $icno])->andWhere(['in', 'status', $status]);
        }
        // if (Yii::$app->request->isAjax) {
        //     return $this->renderAjax('s_tindakan_permohonan', [
        //                 'data' => $data,
        //     ]);
        // }
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('s_permohonan_individu', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
                    'dataProviders' => $dataProviders,
        ]);
    }

    //dalam senarai permohonan individu peringkat jabatan
    public function actionStindakanpermohonan() {

        $icno = Yii::$app->user->getId();
        if(!$icno){
            $searchModel = new TblPermohonanSearch();
            $DataProviders = $searchModel->search(Yii::$app->request->queryParams);
    
            if ($icno == '811212125745' || $icno == '950426125329') {
    //            var_dump('a');die;
    
                $debug = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
                $debug1 = Department::find()->where(['id' => $debug->DeptId])->one();
                $pp = TblFile::find()->where(['uploaded_by' => $debug1->pp])->one();
                $send = $debug1->pp;
    
                $status = ['ENTRY', 'PINDAAN', 'APPROVED', 'REJECTED', 'YPENDING', 'NPENDING', 'PPENDING'];
                $query = TblPermohonan::find()->where(['in', 'status_kj', $status])
                        ->orderBy(['tarikh_mohon' => SORT_DESC, 'status_kj' => SORT_ASC]);
    //            var_dump($pp->uploaded_by);
    //            die;
            } else {
                $status = ['ENTRY', 'PINDAAN', 'APPROVED', 'REJECTED', 'YPENDING', 'NPENDING', 'PPENDING'];
                $query = TblPermohonan::find()->where(['app_by' => $icno])->andWhere(['in', 'status_kj', $status])
                        ->orderBy(['tarikh_mohon' => SORT_DESC, 'status_kj' => SORT_ASC]);
                $kj = Department::find()->where(['chief' => $icno])->one();
                $debug = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
                $debug1 = Department::find()->where(['id' => $debug->DeptId])->one();
    //            $pp = TblFile::find()->where(['uploaded_by' => $kj->pp])->one();
                $send = $debug1->pp;
            }
        }
      

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // if (Yii::$app->request->isAjax) {
        //     return $this->renderAjax('s_tindakan_permohonan', [
        //                 'data' => $data,
        //     ]);
        // }
        return $this->render('s_tindakan_permohonan', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
                    'dataProviders' => $DataProviders,
                    'send' => $send,
//                    'pp' => $pp,
        ]);
    }

    public function actionDownload() {
        $icno = Yii::$app->user->getId();
        $status = ['VERIFIED', 'APPROVED'];
        $query = TblPermohonan::find()->where(['ver_by' => $icno])->andWhere(['in', 'status', $status]);
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $searchModel = new TblPermohonanSearch();
        return $this->render('download', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
        ]);
    }

    public function actionS_permohonan_diperaku($id) {
        $icno = Yii::$app->user->getId();
//        var_dump($id);die;
        $status = ['VERIFIED', 'APPROVED', 'YPENDING', 'NPENDING', 'PPENDING', 'REJECTED'];
        if ($icno == 950426125329) {
            $query = TblPermohonan::find()->where(['icno' => $id])->andWhere(['in', 'status', $status])
                    ->orderBy(['tarikh_mohon' => SORT_DESC]);
        } else {
            $query = TblPermohonan::find()->where(['icno' => $id])->andWhere(['ver_by' => $icno])->andWhere(['in', 'status', $status])
                    ->orderBy(['tarikh_mohon' => SORT_DESC]);
        }
//        var_dump($query);die;
        $models = TblPermohonan::find()->All();

        $selection = (array) Yii::$app->request->post('selection'); //typecasting

        if (Yii::$app->request->post('simpan')) {
            foreach ($models as $data) {
//                var_dump($data->tahun);die;

                if ('y' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = TblPermohonan::findOne(['id' => $data->id]);
                    $model->status = 'YPENDING';
                    $model->save();
//                    return $this->redirect(['openpos/s_tindakan_permohonan','id'=>$data->id]);
                } elseif ('n' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = TblPermohonan::findOne(['id' => $data->id]);
                    $model->status = 'NPENDING';
                    $model->save();
                } elseif ('p' . $data->id == Yii::$app->request->post($data->id)) {
                    $model = TblPermohonan::findOne(['id' => $data->id]);
                    $model->status = 'PPENDING';
                    $model->save();
                }
            }
        } elseif (Yii::$app->request->post('hantar')) {

            foreach ($selection as $id) {

                $hantar = TblPermohonan::findOne(['id' => $id]);
                if ('n' . $hantar->id == Yii::$app->request->post($hantar->id)) {
//                    $hantar->status_kj = 'REJECTED';
                    $hantar->status = 'REJECTED';
                } elseif (('y' . $hantar->id == Yii::$app->request->post($hantar->id))) {
//                    $hantar->status_kj = 'APPROVED';
                    $hantar->status = 'VERIFIED';
                    $value = 1;
                    while ($value != 2) {

                        if ($value == 1) {
                            $icno = $hantar->app_by;
                            $title = 'Permohonan Jawatan';
                            $content = "Permohonan Jawatan telah disahkan dan Akan Dibawa Ke Mesyuarat Untuk Tindakan Selanjutnya.";
                            $this->Notification($icno, $title, $content);
                            $value++;
                        } if ($value == 2) {
                            $icno = $hantar->icno;
                            $title = 'Permohonan Jawatan';
                            $content = "Permohonan Jawatan anda telah disahkan Akan Dibawa Ke Mesyuarat Untuk Tindakan Selanjutnya.";
                            $this->Notification($icno, $title, $content);
                        }
                    }
                }
                $hantar->save();
            }
        }

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('s_permohonan_diperaku', [
                        'data' => $data,
            ]);
        }
        $searchModel = new TblPermohonanSearch();
        return $this->render('s_permohonan_diperaku', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
        ]);
    }

    public function actionTindakan_ketua_jabatan($id) {

        $model = TblPermohonan::findOne($id);
        if ($model->load(Yii::$app->request->post())) {

//            $model->ver_dt = date('Y-m-d H:i:s');
            //      $model->implikasi_kewangan = TblPenetapanGaji::implikasi($model->jawatan_dipohon) * $model->bilangan_diluluskan;


            if ($model->status_kj == 'APPROVED') {
                $model->status = 'APPROVED';

                if ($model->save()) {

                    $value = 1;
                    while ($value != 2) {

                        if ($value == 1) {
                            //----------Model Notification ---------//
                            $ntf = new Notification();
                            $ntf->icno = $model->ver_by;
                            $ntf->title = 'Permohonan Jawatan';
                            $ntf->content = "Permohonan Jawatan yang telah diperaku menunggu tindakan anda.";
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                            $value++;
                            //--------Model Notification-----------//
                        } if ($value == 2) {
                            $ntf = new Notification();
                            $ntf->icno = $model->icno;
                            $ntf->title = 'Permohonan Jawatan';
                            $ntf->content = "Permohonan Jawatan anda telah diperaku oleh ketua jabatan.";
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                            //--------Model Notification-----------//
                        }
                    }
                    //----------Model Notification ---------//

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);
                    return $this->redirect(['openpos/stindakanpermohonan', 'id' => $model->icno]);
                }
            } else if ($model->status_kj == 'REJECTED') {

                if ($model->save()) {

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->icno;
                    $ntf->title = 'Permohonan Jawatan';
                    $ntf->content = "Permohonan Jawatan anda telah DITOLAK.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
                    return $this->redirect(['openpos/stindakanpermohonan', 'id' => $model->icno]);
                }
            } else if ($model->status == 'PINDAAN') {

                if ($model->save()) {

                    //----------Model Notification ---------//
                    $icno = $hantar->icno;
                    $title = 'Permohonan Jawatan';
                    $content = "Permohonan jawatan anda memerlukan PERUBAHAN,sila kemaskini permohonan anda.";
                    $this->Notification($icno, $title, $content);

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi Telah Dihantar Kepada Pemohon!']);
                    return $this->redirect(['openpos/stindakanpermohonan', 'id' => $model->icno]);
                }
            }
        }

        return $this->renderAjax('tindakan_ketua_jabatan', [
                    'model' => $model
        ]);
    }

    public function actionPerakuan_ketua_jabatan($id) {
        $model = TblPermohonan::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->status_kj == 'APPROVED') {
                $model->status = 'APPROVED';

                if ($model->save()) {

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->ver_by;
                    $ntf->title = 'Permohonan Jawatan';
                    $ntf->content = "Permohonan Jawatan yang telah diperaku menunggu tindakan anda.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//
                    $icno = $model->icno;
                    $title = 'Permohonan Jawatan';
                    $content = "Permohonan jawatan anda telah diperaku oleh ketua jabatan anda.";
                    $this->Notification($icno, $title, $content);
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);
                    return $this->redirect(['openpos/stindakanpermohonan', 'id' => $model->icno]);
                }
            } else if ($model->status_kj == 'REJECTED') {

                if ($model->save()) {

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->icno;
                    $ntf->title = 'Permohonan Jawatan';
                    $ntf->content = "Permohonan Jawatan anda telah DITOLAK.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//
                    $icno = $model->icno;
                    $title = 'Permohonan Jawatan';
                    $content = "Permohonan jawatan anda tidak diluluskan oleh ketua jabatan anda.";
                    $this->Notification($icno, $title, $content);
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
                    return $this->redirect(['openpos/stindakanpermohonan', 'id' => $model->icno]);
                }
            } else if ($model->status_kj == 'PINDAAN') {

                if ($model->save()) {

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->icno;
                    $ntf->title = 'Permohonan Jawatan';
                    $ntf->content = "Permohonan jawatan anda memerlukan PERUBAHAN,sila kemaskini permohonan anda.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi Telah Dihantar Kepada Pemohon!']);
                    return $this->redirect(['openpos/stindakanpermohonan', 'id' => $model->icno]);
                }
            }
        } else {
            return $this->renderAjax('perakuan_ketua_jabatan', [
                        'model' => $model,
            ]);
        }
    }

    public function actionPerakuan_pegawai_perjawatan($id) {
        $model = TblPermohonan::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->status == 'VERIFIED') {

                if ($model->save()) {

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->icno;
                    $ntf->title = 'Permohonan Jawatan';
                    $content = "Permohonan Jawatan Anda Telah Disahkan dan Akan Dibawa Ke Mesyuarat Untuk Tindakan Selanjutnya.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);
                    return $this->redirect(['s_permohonan_diperaku', 'id' => $model->icno]);
                }
            }
            if ($model->status == 'REJECTED') {

                if ($model->save()) {

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->icno;
                    $ntf->title = 'Permohonan Jawatan';
                    $content = "Harap Maaf Permohonan Jawatan Anda Tidak Berjaya.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Ditolak!']);
                    return $this->redirect(['s_permohonan_diperaku', 'id' => $model->icno]);
                }
            }
        } else {
            return $this->renderAjax('perakuan_pegawai_perjawatan', [
                        'model' => $model,
            ]);
        }
    }

    //tindakan pemilik modul
    public function actionTindakan_pegawai_perjawatan($id) {
        $model = TblPermohonan::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

//            $model->ver_dt = date('Y-m-d H:i:s');

            if ($model->status == 'VERIFIED') {

                if ($model->save()) {

                    //----------Model Notification ---------//

                    $icno = $model->icno;
                    $title = 'Permohonan Jawatan';
                    $content = "Permohonan Jawatan Anda Telah Disahkan dan Akan Dibawa Ke Mesyuarat Untuk Tindakan Selanjutnya.";
                    $this->Notification($icno, $title, $content);

                    //--------Model Notification-----------//

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);
                    return $this->redirect(['openpos/s_permohonan_diperaku']);
                }
            }
            if ($model->status == 'REJECTED') {

                if ($model->save()) {

                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->icno;
                    $ntf->title = 'Permohonan Jawatan';
                    $content = "Harap Maaf Permohonan Jawatan Anda Tidak Berjaya.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);
                    return $this->redirect(['openpos/s_permohonan_diperaku']);
                }
            }
        }

        return $this->renderAjax('tindakan_pegawai_perjawatan', [
                    'model' => $model
        ]);
    }

    /**
     * Updates an existing TblOpenpos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {

        $model = TblOpenpos::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tarikh Permohonan Jawatan telah Berjaya dikemaskini!']);
                return $this->redirect(['bukapermohonan']);
            }
        }
        return $this->render('update', [
                    'model' => $model
        ]);
    }

    public function actionUpdatepermohonan($id) {

        $mj = TblPermohonan::findOne($id);
//var_dump($mj->icno);die;
//        if (Yii::$app->request->post('simpan1')){
//            var_dump('d');die;
//            $this->memohon($mj->icno);
//        } else
        $icno = Yii::$app->user->getId();
        $dept1 = Department::find()->where(['pp' => $icno])->one();
//        var_dump($dept1);die;
        if ($mj->load(Yii::$app->request->post())) {
//                        var_dump('d');die;
            $ntf = new Notification();
            $mj->status_kj = 'ENTRY';
            $mj->status = 'ENTRY';
            $mj->doc_sokongan = UploadedFile::getInstance($mj, 'doc_sokongan');
            $mj->scenario = 'dokumen';

            if ($mj->doc_sokongan) {

                if ($mj->save()) {
                    $id = $mj->id;
                    $res = Yii::$app->FileManager->UploadFile($mj->doc_sokongan->name, $mj->doc_sokongan->tempName, '04', 'Openpos/DocSokongan');

                    if ($res->status == true) {
                        $mj->doc_sokongan = $res->file_name_hashcode;
                    }
                }
            }

            $mj->ringkasan = UploadedFile::getInstance($mj, 'ringkasan');
            if ($mj->ringkasan) {

                $file_name = $mj->ringkasan . $id . '.' . $mj->ringkasan->getExtension();
                $file_path = 'uploads/' . $file_name;
                $mj->ringkasan->saveAs($file_path);
                $mj->ringkasan = $file_path;
            }
            if ($mj->save()) {
                $ntf->icno = $dept1->chief; // org yg memohon jawatan
                $ntf->title = 'Permohonan Jawatan';
                $ntf->content = "Permohonan Jawatan Menunggu Perakuan Anda";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();

                //   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakukan!']);
                return $this->redirect(["openpos/senaraipermohonan", 'id' => $mj->id]);
            }
        }

        return $this->render('updatepermohonan', [
                    'mj' => $mj
        ]);
    }

    /**
     * Deletes an existing TblOpenpos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $mj = TblOpenpos::findOne($id)->delete();

//         var_dump($mj);die;   
//        $this->findModel($id)->delete();

        return $this->redirect(['bukapermohonan']);
    }

    public function actionTambahadmin() {

        $admin = TblAksesPerjawatan::find()->All(); //cari senarai admin
        $adminbaru = new TblAksesPerjawatan(); //untuk admin baru
        if ($adminbaru->load(Yii::$app->request->post())) {
            if (TblAksesPerjawatan::find()->where(['icno' => $adminbaru->icno])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
            } elseif ($adminbaru->kakitangan->CONm != NULL) { //jika icno tidak wujud dalam sistem
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                $adminbaru->save();
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
            }

            return $this->redirect(['openpos/tambahadmin']);
        }
        if (TblAksesPerjawatan::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
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

    public function actionDeleted($id) {
        $admin = TblAksesPerjawatan::findOne(['id' => $id]);
        $admin->delete();
        if (TblAksesPerjawatan::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->redirect(['tambahadmin']);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    /**
     * Finds the TblOpenpos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblOpenpos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TblOpenpos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
