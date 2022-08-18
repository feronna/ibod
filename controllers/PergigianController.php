<?php

namespace app\controllers;

use Yii;
use app\models\Pergigian\Pergigian;
use app\models\Pergigian\PergigianSearch;
use app\models\Pergigian\Klinik;
use app\models\Pergigian\KlinikSearch;
use app\models\Pergigian\Pegawai;
use app\models\Pergigian\TblAccess;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\Tblprcobiodata;
use yii\data\ActiveDataProvider;
use app\models\Notification;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\helpers\Html;
use kartik\mpdf\Pdf;
use DateTime;

/**
 * PergigianController implements the CRUD actions for Pergigian model.
 */
class PergigianController extends Controller
{

    /**
     * {@inheritdoc}
     */
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
                'only' => ['akses-pengguna', 'senarai-tindakan', 'senarai-tindakan-semak', 'senarai-tindakan-lulus', 'senarai-tindakan-s', 'rekodtuntutan', 'selenggaraklinik', 'statistikbulanan', 'update'],
                'rules' => [
                    [
                        'actions' => ['akses-pengguna', 'rekodtuntutan', 'selenggaraklinik', 'statistikbulanan', 'update'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            if (TblAccess::find()->where(['icno' => $logicno])->andWhere(['access_level' => 1])->exists()) {
                                $check = TblAccess::find()->where(['icno' => $logicno])->andWhere(['access_level' => 1]);
                            }

                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }

                    ],
                    //1-admin ,2-penyemak,3-pelulus ,4-bendahari
                    [
                        'actions' => ['senarai-tindakan', 'senarai-tindakan-semak', 'senarai-tindakan-s', 'rekodtuntutan', 'selenggaraklinik', 'statistikbulanan'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            if (TblAccess::find()->where(['icno' => $logicno])->andWhere(['access_level' => 2])->exists()) {
                                $check = TblAccess::find()->where(['icno' => $logicno])->andWhere(['in', 'access_level']);
                            }

                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['senarai-tindakan', 'senarai-tindakan-lulus', 'senarai-tindakan-s', 'rekodtuntutan', 'selenggaraklinik', 'statistikbulanan', 'update'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            //                            $akses = ['3'];
                            if (TblAccess::find()->where(['icno' => $logicno])->andWhere(['access_level' => 3])->exists()) {
                                $check = TblAccess::find()->where(['icno' => $logicno])->andWhere(['in', 'access_level']);
                            }
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }
                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['senarai-tindakan', 'senarai-tindakan-s'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            //                            $akses = ['3'];
                            if (TblAccess::find()->where(['icno' => $logicno])->andWhere(['access_level' => 4])->exists()) {
                                $check = TblAccess::find()->where(['icno' => $logicno])->andWhere(['in', 'access_level']);
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
    /**
     * Lists all Pergigian models.
     * @return mixed
     */
    public function actionAksesPengguna()
    {
        $admin = TblAccess::find()->all(); //cari senarai admin
        $adminbaru = new TblAccess(); //untuk admin baru
        if ($adminbaru->load(Yii::$app->request->post())) {
            if (TblAccess::find()->where(['icno' => $adminbaru->icno])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Sudah Wujud!']);
            } elseif ($adminbaru->kakitangan->CONm != NULL) { //jika icno tidak wujud dalam sistem
                $adminbaru->is_active = 1;
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                $adminbaru->save();
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
            }

            return $this->redirect(['akses-pengguna']);
        }
        if (TblAccess::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('akses-pengguna', [
                'admin' => $admin,
                'adminbaru' => $adminbaru,
                'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionIndex()
    {
        $icno = Yii::$app->user->getId();
        $model = Pergigian::findAll(['icno' => $icno]);

        $searchModel = new PergigianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'model' => $model,
            'bil' => 1,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTambahTuntutangigi()
    {

        $icno = Yii::$app->user->getId();
        $staff = Tblprcobiodata::find()->where(['<>', 'Status', '6'])->andWhere(['IN', 'statLantikan', [1, 3]])->all();
        $peg = Pegawai::find()->one();

        $model = new Pergigian();
        $model->entry_dt = date('Y-m-d H:i:s');
        $model->check_dt = date('Y-m-d H:i:s');
        $model->app_dt = date('Y-m-d H:i:s');
        $model->bayar_dt = date('Y-m-d H:i:s');
        $model->jumlah_lulus = $model->jumlah_tuntutan;
        $model->status_check = 'DISEMAK';
        $model->status_app = 'DILULUSKAN';
        $model->status_bayar = 'DILULUSKAN';
        $model->status = 'BERJAYA';
        $model->check_by = $peg->penyemak_icno;
        $model->app_by = $peg->pelulus_icno;

        $dept = Tblprcobiodata::findOne(['ICNO' => $icno]);
        if ($model->load(Yii::$app->request->post())) {
            $v = Tblprcobiodata::find()->where(['ICNO' => $model->icno])->one();
            $model->dept_id = $v->DeptId;
            $model->gred_id = $v->gredJawatan;
            $model->jenis_tuntutan_id = 1;
            // $model->file = UploadedFile::getInstance($model, 'file');

            $ntf = new Notification();
            $ntf2 = new Notification();
            if (empty($model->used_by)) {
                $model->used_by = $model->icno;
            }

            if ($model->save()) {
                $ntf->icno = $model->icno; // penyemak
                if ($model->jenis_tuntutan_id = 1) {
                    $ntf->title = 'Tuntutan Rawatan Pergigian';
                } else {
                    $ntf->title = 'Tuntutan Pembelian Kacamata';
                }
                // $ntf->content = "Tuntutan anda telah direkodkan. Sila semak butiran tuntutan rawatan bukan panel anda di.".$model->klinik_nama.' pada '. Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/index'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->content = 'Sila semak butiran tuntutan anda pada <b>' . $model->used_dt . ' di ' . $model->klinik->klinik_nama . '</b> dengan jumlah rawatan <b>' . Yii::$app->formatter->asCurrency($model->jumlah_tuntutan, 'RM') . '</b> di sini. ' . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/index'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();

                // $fileapi = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Pergigian');
                // if ($fileapi->status == true) {
                //     $model->dokumen_sokongan = $fileapi->file_name_hashcode;
                //     $model->save(false);


                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tuntutan berjaya disimpan.']);
                    return $this->redirect(['pergigian/index']);
                // }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen sokongan anda.']);
            }
        }

        return $this->render('tambah-tuntutangigi', [
            'model' => $model,
            'staff' => $staff,
        ]);
    }

    public function actionTambahKacamata()
    {

        $icno = Yii::$app->user->getId();
        $staff = Tblprcobiodata::find()->where(['<>', 'Status', '6'])->andWhere(['IN', 'statLantikan', [1, 3]])->all();
        $peg = Pegawai::find()->one();

        $model = new Pergigian();
        $model->entry_dt = date('Y-m-d H:i:s');
        $model->check_dt = date('Y-m-d H:i:s');
        $model->app_dt = date('Y-m-d H:i:s');
        $model->bayar_dt = date('Y-m-d H:i:s');
        $model->jumlah_lulus = $model->jumlah_tuntutan;
        $model->status_check = 'DISEMAK';
        $model->status_app = 'DILULUSKAN';
        $model->status_bayar = 'DILULUSKAN';
        $model->status = 'BERJAYA';
        $model->check_by = $peg->penyemak_icno;
        $model->app_by = $peg->pelulus_icno;

        $dept = Tblprcobiodata::findOne(['ICNO' => $icno]);
        if ($model->load(Yii::$app->request->post())) {
            $v = Tblprcobiodata::find()->where(['ICNO' => $model->icno])->one();
            $model->dept_id = $v->DeptId;
            $model->gred_id = $v->gredJawatan;
            $model->jenis_tuntutan_id = 2;
            // $model->file = UploadedFile::getInstance($model, 'file');

            $ntf = new Notification();
            $ntf2 = new Notification();
            if (empty($model->used_by)) {
                $model->used_by = $model->icno;
            }

            if ($model->save()) {
                $ntf->icno = $model->icno; // penyemak
                if ($model->jenis_tuntutan_id = 1) {
                    $ntf->title = 'Tuntutan Rawatan Pergigian';
                } else {
                    $ntf->title = 'Tuntutan Pembelian Kacamata';
                }
                // $ntf->content = "Tuntutan anda telah direkodkan. Sila semak butiran tuntutan rawatan bukan panel anda di.".$model->klinik_nama.' pada '. Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/index'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->content = 'Sila semak butiran tuntutan anda pada <b>' . $model->used_dt . ' di ' . $model->kacamata . '</b> dengan jumlah pembelian <b>' . Yii::$app->formatter->asCurrency($model->jumlah_tuntutan, 'RM') . '</b> di sini. ' . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/index'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();

                // $fileapi = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Pergigian');
                // if ($fileapi->status == true) {
                //     $model->dokumen_sokongan = $fileapi->file_name_hashcode;
                //     $model->save(false);


                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tuntutan berjaya disimpan.']);
                    return $this->redirect(['pergigian/index']);
                // }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen sokongan anda.']);
            }
        }

        return $this->render('tambah-kacamata', [
            'model' => $model,
            'staff' => $staff,
        ]);
    }

    public function actionRekodTuntutan()
    {

        $icno = Yii::$app->user->getId();
        $searchModel = new PergigianSearch();
       
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $dataProvider = Pergigian::find();

        $query = new ActiveDataProvider([
            'query' => $dataProvider,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        return $this->render('rekod-tuntutan', [
            'query' => $query,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'bil' => 1,
        ]);
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $icno = Yii::$app->user->getId();
        $check1 = Tblprcobiodata::find()->where(['ICNO' => $icno])->andWhere(['NOT IN', 'statLantikan', ['1', '3']])->one();
        $check2 = Pergigian::find()->where(['icno' => $icno])->andWhere(['IN', 'id_status', 1])->one();
        
        if ($check2) {
            Yii::$app->session->setFlash('alert', ['title' => 'Haraf Maaf', 'type' => 'error', 'msg' => 'Tuntutan yang terdahulu masih dalam proses.']);
            return $this->redirect(['pergigian/index']);
        }
        if (!$check1) {
            $peg = Pegawai::find()->one();
            $model = new Pergigian();
            $searchModel = new PergigianSearch();
            $query = Pergigian::find()->where(['icno' => $icno])->andWhere(['mohon' => 1])->orderBy(['entry_dt' => SORT_DESC]);

            $DataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            $model->entry_dt = date('Y-m-d H:i:s');
            $model->icno = $icno;

            $dept = Tblprcobiodata::findOne(['ICNO' => $icno]);
            if ($model->load(Yii::$app->request->post())) {

                $ntf = new Notification();
                $ntf2 = new Notification();
                if (empty($model->used_by)) {
                    $model->used_by = $icno;
                }

                $model->gred_id = $dept->gredJawatan;
                $model->dept_id = $dept->DeptId;

                $model->status_check = 'MENUNGGU TINDAKAN';
                $model->status_app = 'MENUNGGU TINDAKAN';
                $model->status_bayar = 'MENUNGGU TINDAKAN';
                $model->status = 'MENUNGGU TINDAKAN';
                $model->id_status = 1;
                $model->jenis_tuntutan_id = '1';
                $model->file = UploadedFile::getInstance($model, 'file');
                $Pergigian = $request->post()['Pergigian'];
                $lain = $Pergigian['lain'];
                $model->lain = $lain;

                if ($model->file) {
                    if ($model->save()) {
                        //save notification
                        $ntf->icno = $peg->penyemak_icno; // penyemak
                        $ntf->title = 'Tuntutan Rawatan Pergigian';
                        $ntf->content = "Tuntutan menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();

                        $ntf2->icno = $icno; // kakitangan
                        $ntf2->title = 'Tuntutan Rawatan Pergigian';
                        $ntf2->content = "Tuntutan anda telah dihantar untuk diproses. Sila semak status tuntutan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/index'], ['class' => 'btn btn-primary btn-sm']);
                        $ntf2->ntf_dt = date('Y-m-d H:i:s');
                        $ntf2->save();

                        $fileapi = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Pergigian');
                        if ($fileapi->status == true) {
                            $model->dokumen_sokongan = $fileapi->file_name_hashcode;
                            $model->save(false);
                            //
                            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tuntutan telah dihantar.']);
                            return $this->redirect(['pergigian/index']);
                        }
                    }
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen sokongan anda.']);
                }
            }

            return $this->render('create', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $DataProvider,
                'bil' => 1,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Haraf Maaf', 'type' => 'error', 'msg' => 'Anda tidak layak membuat tuntutan rawatan pergigian.']);
            return $this->redirect(['pergigian/index']);
        }
    }
    public function actionKacamata()
    {
        $request = Yii::$app->request;
        $icno = Yii::$app->user->getId();
        $check1 = Tblprcobiodata::find()->where(['ICNO' => $icno])->andWhere(['NOT IN', 'statLantikan', ['1', '3']])->one();
        $check2 = Pergigian::find()->where(['icno' => $icno])->andWhere(['IN', 'id_status', 1])->one();
        if ($check2) {
            Yii::$app->session->setFlash('alert', ['title' => 'Haraf Maaf', 'type' => 'error', 'msg' => 'Tuntutan yang terdahulu masih dalam proses.']);
            return $this->redirect(['pergigian/index']);
        }
        if (!$check1) {
            $peg = Pegawai::find()->one();
            $model = new Pergigian();

            $searchModel = new PergigianSearch();
            $query = Pergigian::find()->where(['icno' => $icno])->andWhere(['mohon' => 1])->orderBy(['entry_dt' => SORT_DESC]);

            $DataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            $model->entry_dt = date('Y-m-d H:i:s');
            $model->icno = $icno;
            $model->used_by = $icno;

            $dept = Tblprcobiodata::findOne(['ICNO' => $icno]);

            if ($model->load(Yii::$app->request->post())) {

                $ntf = new Notification();
                $ntf2 = new Notification();

                $model->gred_id = $dept->gredJawatan;
                $model->dept_id = $dept->DeptId;

                $model->status_check = 'MENUNGGU TINDAKAN';
                $model->status_app = 'MENUNGGU TINDAKAN';
                $model->status_bayar = 'MENUNGGU TINDAKAN';
                $model->status = 'MENUNGGU TINDAKAN';
                $model->jenis_tuntutan_id = '2';
                $model->file = UploadedFile::getInstance($model, 'file');

                if ($model->file) {
                    if ($model->save()) {
                        //save notification
                        $ntf->icno = $peg->penyemak_icno; // penyemak
                        $ntf->title = 'Tuntutan Pembelian Kacamata';
                        $ntf->content = "Tuntutan menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();

                        $ntf2->icno = $icno; // kakitangan
                        $ntf2->title = 'Tuntutan Pembelian Kacamata';
                        $ntf2->content = "Tuntutan anda telah dihantar untuk diproses. Sila semak status tuntutan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/index'], ['class' => 'btn btn-primary btn-sm']);
                        $ntf2->ntf_dt = date('Y-m-d H:i:s');
                        $ntf2->save();

                        $fileapi = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Pergigian');
                        if ($fileapi->status == true) {
                            $model->dokumen_sokongan = $fileapi->file_name_hashcode;
                            $model->save(false);
                            //
                            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tuntutan telah dihantar.']);
                            return $this->redirect(['pergigian/index']);
                        }
                    }
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Ralat!', 'type' => 'error', 'msg' => 'Sila muat naik dokumen sokongan anda.']);
                }
            }
            return $this->render('kacamata', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $DataProvider,
                'bil' => 1,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Haraf Maaf', 'type' => 'error', 'msg' => 'Anda tidak layak membuat tuntutan pembelian kacamata.']);
            return $this->redirect(['pergigian/index']);
        }
    }

    public function actionSenaraiTindakan()
    {

        $icno = Yii::$app->user->getId();

        if ($penyemak = Pegawai::find()->where(['penyemak_icno' => $icno])->exists()) {
            $model = Pergigian::find()->where(["LIKE", 'status_check', "MENUNGGU TINDAKAN"])->andWhere(['!=', 'status_app', 'DILULUSKAN'])->andWhere(['!=', 'status', 'DILULUSKAN'])->all();
        } elseif ($pelulus = Pegawai::find()->where(['pelulus_icno' => $icno])->exists()) {
            $model = Pergigian::find()->where(["=", 'status_check', "DISEMAK"])->andWhere(['!=', 'status_app', 'DILULUSKAN'])->all();
        } elseif ($bendahari = Pegawai::find()->where(['bendahari_icno' => $icno])->exists()) {
            $model = Pergigian::find()->where(["LIKE", 'status_app', "DILULUSKAN"])->andWhere(['=', 'status_bayar', 'DILULUSKAN'])->andWhere(['>=', 'used_dt', '2020-03-03'])->all();
        }

        $searchModel = new PergigianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (TblAccess::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('senarai-tindakan', [
                'model' => $model,
                'bil' => 1,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', [
                'title' => 'Harap Maaf',
                'type' => 'error', 'msg' => 'Anda Tidak Mempunyai Akses'
            ]);
        }
        return $this->redirect(['pergigian/index']);
    }

    public function actionTindakan($id)
    {
        $icno = Yii::$app->user->getId();
        $model = Pergigian::findOne($id);
        $ntf = new Notification();
        $ntf2 = new Notification();

        $pegawai = Pegawai::find()->where(['penyemak_icno' => $icno])->one();
        if (!empty($pegawai)) {

            if ($model->load(Yii::$app->request->post())) {
                $model->check_by = $icno;
                $model->check_dt = date('Y-m-d H:i:s');
                $model->status = $model->status_check;

                if ($model->save()) {
                    if ($model->jenis_tuntutan_id == 1) {
                        $ntf2->icno = $pegawai->pelulus_icno; // peg pelulus
                        $ntf2->title = 'Tuntutan Rawatan Pergigian';
                        $ntf2->content = "Tuntutan menunggu tindakan kelulusan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                        $ntf2->ntf_dt = date('Y-m-d H:i:s');
                        $ntf2->save();
                    } else {
                        $ntf2->icno = $pegawai->pelulus_icno; // peg pelulus
                        $ntf2->title = 'Tuntutan Pembelian Kacamata';
                        $ntf2->content = "Tuntutan menunggu tindakan kelulusan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                        $ntf2->ntf_dt = date('Y-m-d H:i:s');
                        $ntf2->save();
                    }
                    
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Status semakan  berjaya dikemaskini.']);
                    return $this->redirect(['pergigian/senarai-tindakan']);
                }
            }
            return $this->renderAjax('tindakan', [
                'id' => $id,
                'model' => $model,
                'bil' => 1,
                //                    'searchModel' => $searchModel,
                //                    'dataProvider' => $dataProvider,
            ]);
        }

        $pegawai = Pegawai::find()->where(['pelulus_icno' => $icno])->one();
        if (!empty($pegawai)) {
            if ($model->load(Yii::$app->request->post())) {

                $model->app_by = $icno;
                $model->app_dt = date('Y-m-d H:i:s');
                $model->status = $model->status_app;
                $model->status_bayar = 'DILULUSKAN';

                if ($model->save()) {
                    if ($model->jenis_tuntutan_id == 1) {

                        $ntf2->icno = $pegawai->bendahari_icno; // bendahari
                        $ntf2->title = 'Tuntutan Rawatan Pergigian';
                        $ntf2->content = "Tuntutan menunggu tindakan pembayaran pihak Bendahari. " . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                        $ntf2->ntf_dt = date('Y-m-d H:i:s');
                        $ntf2->save();

                        $ntf->icno = $model->icno; // kakitangan
                        $ntf->title = 'Tuntutan Rawatan Pergigian';
                        $ntf->content = "Tuntutan anda telah diluluskan. Sila muat turun borang tuntutan dan hantar kepada BAHAGIAN SUMBER MANUSIA beserta dengan resit asal tuntutan." . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/index'], ['class' => 'btn btn-primary btn-sm']);
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                    } else {
                        $ntf2->icno = $pegawai->bendahari_icno; // bendahari
                        $ntf2->title = 'Tuntutan Pembelian Kacamata';
                        $ntf2->content = "Tuntutan menunggu tindakan pembayaran pihak Bendahari. " . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                        $ntf2->ntf_dt = date('Y-m-d H:i:s');
                        $ntf2->save();

                        $ntf->icno = $model->icno; // kakitangan
                        $ntf->title = 'Tuntutan Pembelian Kacamata';
                        $ntf->content = "Tuntutan anda telah diluluskan. Sila muat turun borang tuntutan dan hantar kepada BAHAGIAN SUMBER MANUSIA beserta dengan resit asal tuntutan." . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/index'], ['class' => 'btn btn-primary btn-sm']);
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                    }

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Status kelulusan  berjaya dikemaskini.']);
                    return $this->redirect(['pergigian/senarai-tindakan']);
                }
            }
            return $this->renderAjax('lulus', [
                'id' => $id,
                'model' => $model,
                'bil' => 1,
                //                    'searchModel' => $searchModel,
                //                    'dataProvider' => $dataProvider,
            ]);
        }

        return $this->renderAjax('bayar', [
            'id' => $id,
            'model' => $model,
            'bil' => 1,
            //                    'searchModel' => $searchModel,
            //                    'dataProvider' => $dataProvider,
        ]);
    }


    public function actionTindakanSelesais($id)
    {
        $icno = Yii::$app->user->getId();
        $model = Pergigian::findOne($id);
        $ntf2 = new Notification();

        $pegawai = Pegawai::find()->where(['penyemak_icno' => $icno])->one();
        if (!empty($pegawai)) {

            if ($model->load(Yii::$app->request->post())) {
                $model->check_by = $icno;
                $model->check_dt = date('Y-m-d H:i:s');
                $model->status = $model->status_check;

                if ($model->save()) {

                    $ntf2->icno = $pegawai->pelulus_icno; // peg pelulus
                    $ntf2->title = 'Tuntutan Rawatan Pergigian';
                    $ntf2->content = "Tuntutan menunggu tindakan kelulusan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                    $ntf2->ntf_dt = date('Y-m-d H:i:s');
                    $ntf2->save();

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Status semakan  berjaya dikemaskini.']);
                    return $this->redirect(['pergigian/senarai-tindakan']);
                }
            }

            return $this->renderAjax('tindakan-selesais', [
                'id' => $id,
                'model' => $model,
                'bil' => 1,
                //                    'searchModel' => $searchModel,
                //                    'dataProvider' => $dataProvider,
            ]);
        }
    }
    public function actionTindakanSelesail($id)
    {
        $icno = Yii::$app->user->getId();
        $model = Pergigian::findOne($id);
        $ntf2 = new Notification();

        $pegawai = Pegawai::find()->where(['pelulus_icno' => $icno])->one();
        if (!empty($pegawai)) {
            if ($model->load(Yii::$app->request->post())) {

                $model->app_by = $icno;
                $model->app_dt = date('Y-m-d H:i:s');
                $model->status = $model->status_app;

                if ($model->save()) {

                    $ntf2->icno = $pegawai->bendahari_icno; // bendahari
                    $ntf2->title = 'Tuntutan Rawatan Pergigian';
                    $ntf2->content = "Tuntutan menunggu tindakan pembayaran pihak Bendahari." . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                    $ntf2->ntf_dt = date('Y-m-d H:i:s');
                    $ntf2->save();
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Status kelulusan  berjaya dikemaskini.']);
                    return $this->redirect(['pergigian/senarai-tindakan']);
                }
            }

            return $this->renderAjax('tindakan-selesail', [
                'id' => $id,
                'model' => $model,
                'bil' => 1,
                //                    'searchModel' => $searchModel,
                //                    'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionTindakanSelesai($id)
    {
        $icno = Yii::$app->user->getId();
        $model = Pergigian::findOne($id);
        $ntf2 = new Notification();

        $pegawai = Pegawai::find()->where(['penyemak_icno' => $icno])->one();
        if (!empty($pegawai)) {

            if ($model->load(Yii::$app->request->post())) {
                $model->check_by = $icno;
                $model->check_dt = date('Y-m-d H:i:s');
                $model->status = $model->status_check;

                if ($model->save()) {

                    $ntf2->icno = $pegawai->pelulus_icno; // peg pelulus
                    $ntf2->title = 'Tuntutan Rawatan Pergigian';
                    $ntf2->content = "Tuntutan menunggu tindakan kelulusan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                    $ntf2->ntf_dt = date('Y-m-d H:i:s');
                    $ntf2->save();

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Status semakan  berjaya dikemaskini.']);
                    return $this->redirect(['pergigian/senarai-tindakan']);
                }
            }

            return $this->renderAjax('tindakan-selesai', [
                'id' => $id,
                'model' => $model,
                'bil' => 1,
                //                    'searchModel' => $searchModel,
                //                    'dataProvider' => $dataProvider,
            ]);
        }

        $pegawai = Pegawai::find()->where(['pelulus_icno' => $icno])->one();
        if (!empty($pegawai)) {
            if ($model->load(Yii::$app->request->post())) {

                $model->app_by = $icno;
                $model->app_dt = date('Y-m-d H:i:s');
                $model->status = $model->status_app;

                if ($model->save()) {

                    $ntf2->icno = $pegawai->bendahari_icno; // bendahari
                    $ntf2->title = 'Tuntutan Rawatan Pergigian';
                    $ntf2->content = "Tuntutan menunggu tindakan pembayaran pihak Bendahari." . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                    $ntf2->ntf_dt = date('Y-m-d H:i:s');
                    $ntf2->save();
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Status kelulusan  berjaya dikemaskini.']);
                    return $this->redirect(['pergigian/senarai-tindakan']);
                }
            }

            return $this->renderAjax('tindakan-selesai', [
                'id' => $id,
                'model' => $model,
                'bil' => 1,
                //                    'searchModel' => $searchModel,
                //                    'dataProvider' => $dataProvider,
            ]);
        }
        $pegawai = Pegawai::find()->where(['bendahari_icno' => $icno])->one(); {
            if ($model->load(Yii::$app->request->post())) {

                $model->bayar_by = $icno;
                $model->bayar_dt = date('Y-m-d H:i:s');
                $model->status = $model->status_bayar;
                if ($model->save()) {

                    $ntf2->icno = $model->icno; // kakitangan yang buat tuntutan
                    $ntf2->title = 'Tuntutan Rawatan Pergigian';
                    $ntf2->content = "Tuntutan rawatan pergigian anda dalam proses pembayaran." . Html::a('<i class="fa fa-arrow-right"></i>', ['pergigian/index'], ['class' => 'btn btn-primary btn-sm']);
                    $ntf2->ntf_dt = date('Y-m-d H:i:s');
                    $ntf2->save();

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Status pembayaran  berjaya dikemaskini.']);
                    return $this->redirect(['pergigian/senarai-tindakan']);
                }
            }

            return $this->renderAjax('tindakan-selesai', [
                'id' => $id,
                'model' => $model,
                'bil' => 1,
                //                    'searchModel' => $searchModel,
                //                    'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionSenaraiTindakanS()
    {

        $icno = Yii::$app->user->getId();
        if ($pegawai = Pegawai::find()->where(['penyemak_icno' => $icno])->exists()) {
            $model = Pergigian::find()->where(["LIKE", 'status_check', "DISEMAK"])->andWhere(['>=', 'used_dt', '2020-03-03'])->all();
            $searchModel = new PergigianSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('senarai-tindakan-semak', [
                'model' => $model,
                'bil' => 1,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } elseif ($pegawai = Pegawai::find()->where(['pelulus_icno' => $icno])->exists()) {
            $model = Pergigian::find()->where(["LIKE", 'status_check', "DISEMAK"])->andWhere(["LIKE", 'status_app', 'DILULUSKAN'])->andWhere(['>=', 'used_dt', '2020-03-03'])->all();
            $searchModel = new PergigianSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('senarai-tindakan-lulus', [
                'model' => $model,
                'bil' => 1,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } elseif ($pegawai = Pegawai::find()->where(['bendahari_icno' => $icno])->exists()) {
            $model = Pergigian::find()->where(["LIKE", 'status_bayar', "DILULUSKAN"])->andWhere(['>=', 'used_dt', '2020-03-03'])->all();
        }
        $searchModel = new PergigianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $access = [771007125128, 800224125722, 770507125154];
        if (in_array($icno, $access)) {
            return $this->render('senarai-tindakan-s', [
                'model' => $model,
                'bil' => 1,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        Yii::$app->session->setFlash('alert', [
            'title' => 'Harap Maaf',
            'type' => 'error', 'msg' => 'Anda Tidak Mempunyai Akses'
        ]);
        return $this->redirect(['pergigian/index']);
    }



    /**
     * Displays a single Pergigian model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    //    public function actionView($id) {
    //        $this->findModel($id)->view();
    //        return $this->render('selenggaraklinik', [
    //                    'model' => $this->findModel($id),
    //        ]);
    //    }

    public function actionUpdate($id)
    {
        $model = Pergigian::find()->where(['tuntutan_gigi_id' => $id])->one();
        $searchModel = new PergigianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikemaskini.']);
                return $this->redirect(['pergigian/view', 'id' => $id]);
            }
        }
        return $this->render('_update', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,

        ]);
    }
    public function actionUpdatek($id)
    {
        $icno = Yii::$app->user->getId();
        $klinik = Klinik::findOne(['klinik_gigi_id' => $id]);
        $searchModel = new KlinikSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        if ($klinik->load(Yii::$app->request->post())) {
            if ($klinik->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Klinik berjaya dikemaskini.']);
                return $this->redirect(['pergigian/selenggaraklinik']);
            }
        }

        return $this->render('updatek', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //                    'query' => $query,
            'klinik' => $klinik,

        ]);
    }
    /**
     * Creates a new Pergigian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function notification($title, $content, $icno = null)
    {
        if ($icno == null) {
            //default user login id
            $icno = Yii::$app->user->getId();
        }
        $ntf = new Notification();
        $ntf->icno = $icno;
        $ntf->title = $title;
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        return true;
    }


    // public function actionRekodtuntutan()
    // {
    //     $icno = Yii::$app->user->getId();
    //     // $model = new Pergigian();
    //     // $query = Pergigian::find()->orderBy(['used_dt' => SORT_ASC])->all();
    //     $searchModel = new PergigianSearch();
    //     $dataProvider = Pergigian::find()->orderBy(['used_dt' => SORT_DESC]);

    //     $query = new ActiveDataProvider([
    //         'query' => $dataProvider,
    //         'pagination' => [
    //             'pageSize' => 30,
    //         ],
    //     ]);

    //     // if (TblAccess::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {

    //         return $this->render('rekodtuntutan', [
    //             'bil' => 1,
    //             'searchModel' => $searchModel,
    //             'query' => $query,
    //             // 'query' => $query,
    //             // 'pergigian' => $model,

    //         ]);
    //     // } else {
    //     //     Yii::$app->session->setFlash('alert', [
    //     //         'title' => 'Harap Maaf',
    //     //         'type' => 'error', 'msg' => 'Anda Tidak Mempunyai Akses'
    //     //     ]);
    //     //     return $this->redirect(['pergigian/index']);
    //     // }
    // }

    public function actionView($id)
    {

        $model = Pergigian::find()->where(['tuntutan_gigi_id' => $id])->one();

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['rekod-tuntutan']);
    }

    public function actionDeleted($id)
    {

        $model = Klinik::findOne(['klinik_gigi_id' => $id]);
        $model->delete();
        return $this->redirect(['selenggaraklinik']);
    }

    public function actionSelenggaraklinik()
    {
        $icno = Yii::$app->user->getId();
        $klinik = new Klinik();
        $query = Klinik::find()->all();
        $searchModel = new KlinikSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (TblAccess::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('selenggaraklinik', [
                //                    'model' => $model,
                'bil' => 1,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'query' => $query,
                'klinik' => $klinik,
            ]);
        } else
            Yii::$app->session->setFlash('alert', [
                'title' => 'Harap Maaf',
                'type' => 'error', 'msg' => 'Anda Tidak Mempunyai Akses'
            ]);
        return $this->redirect(['pergigian/index']);
    }

    public function actionSenaraiklinik()
    {
        $searchModel = new KlinikSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('senaraiklinik', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStatistikBulanan($id = null, $tahun = null, $bulan = null)
    {
        if (TblAccess::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {

            $gigi = Pergigian::find()->select(new \yii\db\Expression("MONTH(`used_dt`) AS BULAN, SUM(`jumlah_tuntutan`) AS JUMLAH"))->where(['YEAR(used_dt)' => $tahun])->groupBy('MONTH(`used_dt`)')->asArray()->all();

            $label = ArrayHelper::getColumn($gigi, 'BULAN');
            $data = ArrayHelper::getColumn($gigi, 'JUMLAH');

            foreach ($label as $ind => $l) {
                if ($l == 1) {
                    $label[$ind] = 'JANUARI';
                } else if ($l == 2) {
                    $label[$ind] = 'FEBRUARI';
                } else if ($l == 3) {
                    $label[$ind] = 'MAC';
                } else if ($l == 4) {
                    $label[$ind] = 'APRIL';
                } else if ($l == 5) {
                    $label[$ind] = 'MEI';
                } else if ($l == 6) {
                    $label[$ind] = 'JUN';
                } else if ($l == 7) {
                    $label[$ind] = 'JULAI';
                } else if ($l == 8) {
                    $label[$ind] = 'OGOS';
                } else if ($l == 9) {
                    $label[$ind] = 'SEPTEMBER';
                } else if ($l == 10) {
                    $label[$ind] = 'OKTOBER';
                } else if ($l == 11) {
                    $label[$ind] = 'NOVEMBER';
                } else if ($l == 12) {
                    $label[$ind] = 'DISEMBER';
                }
            }

            $year = date('Y');
            $mth = date('m');

            if (!$id) {
                $id = Yii::$app->user->getId();
            }

            $var = null;
            if ($tahun != null) {
                $year = $tahun;
            }

            if ($bulan != null) {
                $mth = $bulan;
            }
            if ($tahun && $bulan) {
                $var = $this->getDaysInYearMonth($year, $mth, 'Y-m-d');
            }

            $biodata = Pergigian::findOne(['icno' => $id]);
            $model = new Pergigian();
            $query = Pergigian::find()->where(['MONTH(used_dt)' => $mth])->andWhere(['YEAR(used_dt)' => $year])->orderBy(['used_dt' => SORT_ASC]);
            $sum = $query->sum('jumlah_tuntutan');
            $dataProvider = new ActiveDataProvider([
                'query' => $query,

                'pagination' => [
                    'pageSize' => 6,
                ],
            ]);
            return $this->render('statistikbulanan', [
                'dataProvider' => $dataProvider,
                'label' => $label,
                'data' => $data,
                'var' => $var, 'icno' => $id, 'tahun' => $year, 'bulan' => $mth, 'biodata' => $biodata,
                'model' => $model,
                'sum' => $sum
            ]);
        } else
            Yii::$app->session->setFlash('alert', [
                'title' => 'Harap Maaf',
                'type' => 'error', 'msg' => 'Anda Tidak Mempunyai Akses'
            ]);
        return $this->redirect(['pergigian/index']);
    }



    public function actionDeleter($id)
    {

        $admin = TblAccess::findOne(['id' => $id]);
        $admin->delete();
        return $this->redirect(['akses-pengguna']);
    }

    public function actionUpdateAkses($id)
    {
        $model = TblAccess::findOne(['id' => $id]);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tahap akses berjaya dikemaskini!']);
                return $this->redirect(['akses-pengguna']);
            }
        }
        return $this->render('update-akses', [
            'model' => $model,
            'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
        ]);
    }

    public function actionSurat_lulus($id)
    {
        $css = file_get_contents('./css/kelulusan_gigi.css');
        #cehck application
        $model = $this->findModel($id);
        $icno = Yii::$app->user->getId();
        $pergigian = Pergigian::find()->where(['icno' => $model])->andWhere(['tuntutan_gigi_id' =>  $id])->one();
        //   $facility2 = Borang::find()->where(['icno' => $icno])->one();
        $content = $this->renderPartial('surat_lulus', ['pergigian' => $pergigian]);
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
            'options' => ['title' => 'Tuntutan Rawatan Pergigian'],
            // call mPDF methods on the fly
            'marginTop' => 35,
            //             'marginBottom' => 35,
            'marginLeft' => 24,
            'marginRight' => 24,
            'methods' => [
                'SetHeader' => ['SURAT PENEMPATAN'],
                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                'WriteHTML' => [$css, 1]
                //          'SetFooter' => [' {PAGENO}'],
            ]
        ]);
        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    /**
     * Finds the Pergigian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pergigian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionBorangTuntutan($id)
    {
        $model = Pergigian::findOne(['tuntutan_gigi_id' => $id]);
        $lastpayment = Pergigian::find()->where(['<', 'tuntutan_gigi_id', $id])->one();
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'UTF-8',
            // "allowCJKoverflow" => true, 
            "autoScriptToLang" => true,
            // "allow_charset_conversion" => false,
            "autoLangToFont" => true,
        ]);
        $mpdf->allow_charset_conversion = true;
        $mpdf->charset_in = 'iso-8859-4';
        $pagecount = $mpdf->SetSourceFile('files/borang_tuntutan.pdf');
        for ($i = 1; $i <= $pagecount; $i++) {
            $import_page = $mpdf->ImportPage($i);
            $mpdf->UseTemplate($import_page);
            if ($i == 1) { //page1
                $mpdf->WriteHTML($this->renderPartial('borangtuntutan', ['model' => $model, 'lastpayment' => $lastpayment]));
            }
            if ($i < $pagecount) {
                $mpdf->AddPage();
            }
        }
        $mpdf->Output();
    }

    function getDaysInYearMonth(int $year, int $month, string $format)
    {
        $date = DateTime::createFromFormat("Y-n", "$year-$month");

        $datesArray = array();
        for ($i = 1; $i <= $date->format("t"); $i++) {
            $datesArray[] = DateTime::createFromFormat("Y-n-d", "$year-$month-$i")->format($format);
        }

        return $datesArray;
    }

    protected function findModel($id)
    {
        if (($model = Pergigian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
