<?php

namespace app\controllers;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\esticker\TblTuntutan;
use app\models\esticker\SenaraiKontraktorSearch;
use app\models\esticker\RekodKenderaanKontraktorSearch;
use app\models\esticker\LaporanPelekatKontraktorSearch;
use app\models\esticker\LaporanPelekatJabatanSearch;
use app\models\esticker\LaporanPelekatVipSearch;
use app\models\esticker\LaporanPelekatStafSearch;
use app\models\esticker\LaporanPelekatPelajarSearch;
use app\models\esticker\LaporanPelekatPelawatSearch;
use app\models\esticker\LaporanPelawatHarianSearch;
use app\models\esticker\LaporanShPelawatSearch;
use app\models\esticker\LaporanKontraktorHarianSearch;
use app\models\esticker\LaporanShKontraktorSearch;
use app\models\esticker\TblStickerStaf;
use app\models\esticker\TblStickerStudent;
use app\models\esticker\TblStickerKontraktor;
use app\models\esticker\TblStickerPelawat;
use app\models\esticker\TblStickerVip;
use app\models\esticker\TblStickerJabatan;
use app\models\esticker\TblPelekatKenderaan;
use app\models\esticker\TblPelekatKenderaanStudent;
use app\models\esticker\TblPelekatKenderaanVip;
use app\models\esticker\TblPelekatKenderaanPelawat;
use app\models\esticker\TblPelekatKenderaanKontraktor;
use app\models\esticker\TblPelekatKenderaanJabatan;
use app\models\hronline\TblAhliLembagaPengarah;
use app\models\esticker\TblKontraktor;
use app\models\esticker\TblPelawat;
use app\models\esticker\TblPekerjaKontraktor;
use app\models\esticker\TblRekodKontraktor;
use app\models\esticker\TblRekodPelawat;
use app\models\esticker\TblPelekatKenderaanSearch;
use app\models\esticker\TblPelekatKenderaanStudentSearch;
use app\models\esticker\TblPelekatKenderaanJabatanSearch;
use app\models\esticker\TblBookingSiri;
use app\models\esticker\TblEmail;
use app\models\esticker\TblAccess;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\hronline\Tbllesen;
use app\models\saman\SamanOld;
use app\models\esticker\SamanSearch;
use yii\filters\AccessControl;
use app\models\esticker\PaymentInvoice;
use app\models\esticker\PaymentDetails;
use app\models\esticker\PaymentUrl;
use app\models\esticker\PayRate;
use app\models\hronline\Department;
use GuzzleHttp\Client;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use app\models\Kontraktor\RefKontrakType;
use app\models\Kontraktor\SyarikatKontraktor;
use app\models\Kontraktor\Kontraktor; //Rekod Pekerja

/**
 * StickerController implements the CRUD actions for TblStickerStaf model.
 */
class StickerController extends Controller {

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
                    'manual-pengguna', 'tambah-kenderaan', 'mohon-pelekat', 'semak-saman', 'pay-rate', 'tuntutan',
                    //pentadbir sistem
                    'access',
                    //pelekat staff
                    'menunggu-bayaran', 'menunggu-kutipan', 'selesai', 'rekod-tuntutan',
                    //pelekat pelajar
                    'semasa-pelajar', 'menunggu-kutipan-pelajar', 'selesai-pelajar', 'ditolak-pelajar',
                    //pelekat kontraktor
                    'tambah-kenderaan-kontraktor', 'carian-kontraktor', 'carian-kontraktor-pelekat', 'status-syarikat', 'semakan-kenderaan-kontraktor',
                    //pelekat pelawat
                    'tambah-pelawat', 'tambah-kenderaan-pelawat', 'carian-pelawat', 'carian-pelawat-pelekat',
                    //pelekat harian
                    'tambah-pelawat', 'carian-masuk-pelawat', 'carian-keluar-pelawat', 'carian-senarai-hitam',
                    //pelekat jabatan (pemohon)
                    'tambah-kenderaan-jabatan', 'mohon-pelekat-jabatan', 'semakan-permohonan-jabatan', 'sejarah-permohonan-jabatan',
                    //pelekat jabatan (admin)
                    'menunggu-kutipan-jabatan', 'selesai-jabatan',
                    //Saman
                    'saman',
                    //laporan
                    'laporan-pelekat-staf', 'laporan-pelekat-pelajar', 'laporan-pelekat-pelawat', 'laporan-pelekat-vip', 'laporan-pelekat-kontraktor', 'laporan-pelawat-harian', 'laporan-kontraktor-harian', 'laporan-sh-pelawat', 'laporan-sh-kontraktor',
                    //pelekat vip
                    'tambah-vip', 'tambah-kenderaan-vip', 'carian-vip', 'carian-vip-pelekat',
                    //kontraktor harian
                    'carian-masuk-kontraktor','carian-senarai-kontraktor-aktif', 'carian-senarai-hitam-kontraktor',
                ],
                'rules' => [
                    [//pengguna
                        'actions' => ['manual-pengguna', 'tambah-kenderaan', 'mohon-pelekat', 'semak-saman', 'pay-rate', 'tuntutan'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['!=', 'Status', '6']);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//pentadbir sistem
                        'actions' => ['access', 'edit-access', 'delete-access',
                            //temporary access
                            'menunggu-kutipan-jabatan', 'selesai-jabatan'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => 99]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//pelekat staff
                        'actions' => ['menunggu-bayaran', 'menunggu-kutipan', 'selesai', 'menunggu-kutipan-jabatan', 'selesai-jabatan', 'rekod-tuntutan'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => 1]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//pelekat jabatan
                        'actions' => ['tambah-kenderaan-jabatan', 'mohon-pelekat-jabatan', 'semakan-permohonan-jabatan', 'sejarah-permohonan-jabatan'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = Department::findOne(['pp' => Yii::$app->user->getId(), 'isActive' => 1]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//pelekat pelajar
                        'actions' => ['semasa-pelajar', 'menunggu-kutipan-pelajar', 'selesai-pelajar', 'ditolak-pelajar'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => 2]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//pelekat kontraktor
                        'actions' => ['tambah-kenderaan-kontraktor', 'carian-kontraktor', 'carian-kontraktor-pelekat', 'status-syarikat', 'semakan-kenderaan-kontraktor'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => 3]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//pelekat pelawat
                        'actions' => ['tambah-pelawat', 'tambah-kenderaan-pelawat', 'carian-pelawat', 'carian-pelawat-pelekat'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => 4]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//pelawat harian
                        'actions' => ['tambah-pelawat', 'carian-masuk-pelawat', 'carian-keluar-pelawat'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => 5]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//Laporan
                        'actions' => ['laporan-pelekat-staf', 'laporan-pelekat-pelajar', 'laporan-pelekat-pelawat', 'laporan-pelekat-vip', 'laporan-pelekat-kontraktor', 'laporan-pelawat-harian', 'laporan-kontraktor-harian'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => 6]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//Saman
                        'actions' => ['saman'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => 7]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//pelekat vip
                        'actions' => ['tambah-vip', 'tambah-kenderaan-vip', 'carian-vip', 'carian-vip-pelekat'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => 8]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//kontraktor harian
                        'actions' => ['carian-masuk-kontraktor','carian-senarai-kontraktor-aktif'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => 9]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//senarai hitam
                        'actions' => ['carian-senarai-hitam-kontraktor', 'carian-senarai-hitam', 'laporan-sh-pelawat', 'laporan-sh-kontraktor'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => 10]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                ],
            ],
        ];
    }

    //Admin   

    public function actionMenungguBayaran() {
        $searchModel = new TblPelekatKenderaanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, ['MENUNGGU BAYARAN KAUNTER']);

        return $this->render('view_permohonan_admin', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'title' => 'Menunggu Bayaran',
        ]);
    }

    public function actionMenungguKutipan() {
        $searchModel = new TblPelekatKenderaanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, ['MENUNGGU KUTIPAN']);

        return $this->render('view_permohonan_admin', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'title' => 'Menunggu Pengambilan',
        ]);
    }

    public function actionSelesai() {
        $searchModel = new TblPelekatKenderaanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, ['AKTIF']);

        return $this->render('view_permohonan_admin', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'title' => 'Selesai',
        ]);
    }

    public function actionMenungguKutipanJabatan() {
        $searchModel = new TblPelekatKenderaanJabatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, ['MENUNGGU KUTIPAN']);

        return $this->render('view_permohonan_admin_jabatan', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'title' => 'Menunggu Pengambilan - Jabatan',
        ]);
    }

    public function actionSelesaiJabatan() {
        $searchModel = new TblPelekatKenderaanJabatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, ['AKTIF']);

        return $this->render('view_permohonan_admin_jabatan', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'title' => 'Selesai - Jabatan',
        ]);
    }

    public function actionDitolak() {
        $searchModel = new TblPelekatKenderaanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, ['DITOLAK']);

        return $this->render('view_permohonan_admin', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'title' => 'Ditolak',
        ]);
    }

    public function simpanBookingSiri($type, $sticker) {
        $booking = new TblBookingSiri();
        $booking->stc_type = $type;
        $booking->veh_type = $sticker->veh_type;
        $booking->kod_siri = $sticker->kod_siri;
        $booking->siri = $sticker->siri;
        $booking->no_siri = $sticker->kod_siri . $sticker->siri;
        $booking->id_kenderaan = $sticker->id;
        if ($type != 4) {
            $booking->ICNO = $sticker->v_co_icno;
        } else {
            $booking->ICNO = $sticker->id_lpu;
        }
        $booking->created_by = Yii::$app->user->getId();
        $booking->created_at = date('Y-m-d H:i:s');
        $booking->save(false);
    }

    public function actionTindakanJabatan($id, $title) {
        $pelekat = TblPelekatKenderaanJabatan::findOne(['id' => $id]);
        $model = TblStickerJabatan::findKenderaan($pelekat->id_kenderaan);
        $model->kod_siri = $model->kodSiri->kod_siri;
        $crSiri = $model->siri = TblBookingSiri::findRunningSiriJabatan($model->kodSiri->kod_siri);
        $model->mula = date('Y-m-d', strtotime($pelekat->mohon_date));
        $model->tamat = date('Y-m-d', strtotime('+1 year', strtotime($model->mula)));
        if ($model->load(Yii::$app->request->post())) {
            $exist = TblPelekatKenderaanJabatan::find()->where(['kod_siri' => $model->kodSiri->kod_siri, 'siri' => $model->siri])->one();
            if ($exist) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Nombor siri telah wujud.']);
                return $this->redirect(['tindakan-jabatan', 'id' => $id, 'title' => 'Menunggu Kutipan']);
            } elseif ($model->siri > 100000) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Nombor siri melebihi angka yang ditetapkan.']);
                return $this->redirect(['tindakan-jabatan', 'id' => $id, 'title' => 'Menunggu Kutipan']);
            } else {
                //store if booked siri
                if ($crSiri != $model->siri) {
                    $this->simpanBookingSiri(1, $model);
                }

                $pelekat->kod_siri = $model->kod_siri;
                $pelekat->siri = $model->siri;
                $pelekat->no_siri = $model->kod_siri . $model->siri;
                $pelekat->status_mohon = 'AKTIF';
                $pelekat->expired_date_1 = $model->mula;
                $pelekat->expired_date_2 = $model->tamat;
                $pelekat->app_datetime = date('Y-m-d H:i:s');
                $pelekat->updater = Yii::$app->user->getId();
                $pelekat->no_resit = $model->no_resit;
                $pelekat->save(false);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                return $this->redirect(['tindakan-jabatan', 'id' => $id, 'title' => 'Selesai']);
            }
        }

        return $this->render('view_perincian_jabatan', [
                    'model' => $model,
                    'title' => $title,
                    'pelekat' => $pelekat,
        ]);
    }

    public function actionTindakan($id, $title) {
        $pelekat = TblPelekatKenderaan::findOne(['id' => $id]);
        $model = TblStickerStaf::findKenderaan($pelekat->id_kenderaan);
        $model->kod_siri = $model->kodSiri->kod_siri;
        $crSiri = $model->siri = TblBookingSiri::findRunningSiri($model->kodSiri->kod_siri);
        $model->mula = date('Y-m-d', strtotime($pelekat->mohon_date));
        $model->tamat = date('Y-m-d', strtotime('+2 year', strtotime($model->mula)));
        if ($model->load(Yii::$app->request->post())) {
            $exist = TblPelekatKenderaan::find()->where(['kod_siri' => $model->kodSiri->kod_siri, 'siri' => $model->siri])->one();
            if ($exist) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Nombor siri telah wujud.']);
                return $this->redirect(['tindakan', 'id' => $id, 'title' => 'Menunggu Bayaran Kaunter']);
            } elseif ($model->siri > 100000) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Nombor siri melebihi angka yang ditetapkan.']);
                return $this->redirect(['tindakan', 'id' => $id, 'title' => 'Menunggu Bayaran Kaunter']);
            } else {
                //store if booked siri
                if ($crSiri != $model->siri) {
                    $this->simpanBookingSiri(1, $model);
                }

                $pelekat->kod_siri = $model->kod_siri;
                $pelekat->siri = $model->siri;
                $pelekat->no_siri = $model->kod_siri . $model->siri;
                $pelekat->status_mohon = 'AKTIF';
                $pelekat->expired_date_1 = $model->mula;
                $pelekat->expired_date_2 = $model->tamat;
                $pelekat->app_datetime = date('Y-m-d H:i:s');
                $pelekat->updater = Yii::$app->user->getId();
                $pelekat->no_resit = $model->no_resit;
                if ($model->free) {
                    $pelekat->free = 1;
                }
                $pelekat->save(false);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                return $this->redirect(['tindakan', 'id' => $id, 'title' => 'Selesai']);
            }
        }

        return $this->render('view_perincian', [
                    'model' => $model,
                    'title' => $title,
                    'pelekat' => $pelekat,
        ]);
    }

    public function actionPerincian($id) {
        $model = TblPelekatKenderaan::findOwnPelekat($id);

        return $this->renderAjax('view_perincian_permohonan', [
                    'model' => $model,
        ]);
    }

    //pelajar

    public function actionSemasaPelajar() {
        $searchModel = new TblPelekatKenderaanStudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, ['DIHANTAR']);

        return $this->render('view_permohonan_admin_pelajar', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'title' => 'Semasa',
        ]);
    }

    public function actionMenungguKutipanPelajar() {
        $searchModel = new TblPelekatKenderaanStudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, ['MENUNGGU KUTIPAN']);

        return $this->render('view_permohonan_admin_pelajar', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'title' => 'Menunggu Pengambilan',
        ]);
    }

    public function actionDitolakPelajar() {
        $searchModel = new TblPelekatKenderaanStudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, ['DITOLAK']);

        return $this->render('view_permohonan_admin_pelajar', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'title' => 'Ditolak',
        ]);
    }

    public function actionSelesaiPelajar() {
        $searchModel = new TblPelekatKenderaanStudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, ['AKTIF']);

        return $this->render('view_permohonan_admin_pelajar', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'title' => 'Selesai',
        ]);
    }

    public function actionTindakanPelajar($id, $title) {
        $pelekat = TblPelekatKenderaanStudent::findOne(['id' => $id]);
        $model = TblStickerStudent::findKenderaan($pelekat->id_kenderaan);
        $model->kod_siri = $model->kodSiri->kod_siri;
        $crSiri = $model->siri = TblBookingSiri::findRunningSiriStudent($model->kodSiri->kod_siri);
        $model->mula = date('Y-m-d', strtotime($pelekat->mohon_date));
        $model->tamat = date('Y-m-d', strtotime('+1 year', strtotime($model->mula)));

        if ($model->load(Yii::$app->request->post())) {
            if ($title == 'Semasa') {
                if (!is_null($model->status_mohon) && !is_null($model->catatan2)) {
                    $pelekat->catatan = $model->catatan2;
                    $pelekat->status_mohon = $model->status_mohon;
                    $pelekat->app_date = date('Y-m-d');
                    $pelekat->updater = Yii::$app->user->getId();
                    $pelekat->save(false);
                    //notifikasi

                    $this->EmailPelajar($model->status_mohon, $pelekat->id_kenderaan);

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                    return $this->redirect(['semasa-pelajar']);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila isi Status & Catatan.']);
                    return $this->redirect(['tindakan-pelajar', 'id' => $id, 'title' => $title]);
                }
            } else {

                $exist = TblPelekatKenderaanStudent::find()->where(['kod_siri' => $model->kodSiri->kod_siri, 'siri' => $model->siri])->one();
                if ($exist) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Nombor siri telah wujud.']);
                    return $this->redirect(['tindakan-pelajar', 'id' => $id, 'title' => $title]);
                } elseif ($model->siri > 100000) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Nombor siri melebihi angka yang ditetapkan.']);
                    return $this->redirect(['tindakan-pelajar', 'id' => $id, 'title' => $title]);
                } else {
                    //store if booked siri
                    if ($crSiri != $model->siri) {
                        $this->simpanBookingSiri(2, $model);
                    }
                    $pelekat->kod_siri = $model->kod_siri;
                    $pelekat->siri = $model->siri;
                    $pelekat->total = $model->findStickerRate();
                    $pelekat->no_siri = $model->kod_siri . $model->siri;
                    $pelekat->status_mohon = 'AKTIF';
                    $pelekat->expired_date = $model->mula;
                    $pelekat->expired_date_2 = $model->tamat;
                    $pelekat->app_date = date('Y-m-d');
                    $pelekat->updater = Yii::$app->user->getId();
                    $pelekat->no_resit = $model->no_resit;
                    $pelekat->save(false);

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                    return $this->redirect(['tindakan-pelajar', 'id' => $id, 'title' => 'Selesai']);
                }
            }
        }

        return $this->render('view_perincian_pelajar', [
                    'model' => $model,
                    'title' => $title,
                    'pelekat' => $pelekat,
        ]);
    }

    public function actionPerincianPelajar($id) {
        $model = TblPelekatKenderaanStudent::findOwnPelekat($id);

        return $this->renderAjax('view_perincian_permohonan_pelajar', [
                    'model' => $model,
        ]);
    }

    public function actionPerakuPermohonanPelajar($id) {
        $model = TblPelekatKenderaanStudent::findPelekatDiterima($id);

        $model->status_mohon = 'MENUNGGU KUTIPAN';
        $model->app_date = date('Y-m-d');
        $model->updater = Yii::$app->user->getId();
        $model->save(false);

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
        return $this->redirect(['semasa-pelajar']);
    }

    //Jabatan
    public function actionTambahKenderaanJabatan() {
        $model = new TblStickerJabatan();

        if ($model->load(Yii::$app->request->post())) {
            $model->veh_model = strtoupper($model->veh_model);
            //check exist kenderaan
            $reg_number = str_replace(' ', '', strtoupper($model->reg_number));
            $own = TblStickerJabatan::checkOwnKenderaan($reg_number);

            if (empty($own)) {
                $model->reg_number = $reg_number;
                $model->save(false);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini.']);
                return $this->redirect(['mohon-pelekat-jabatan']);
            } else {
                //kenderaan exist
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Anda kenderaan telah didaftarkan.']);
                return $this->redirect(['mohon-pelekat-jabatan']);
            }
        }

        return $this->render('form_kenderaan_jabatan', [
                    'model' => $model,
                    'title' => 'Tambah Kenderaan',
        ]);
    }

    public function actionKemaskiniKenderaanJabatan($id) {
        $model = TblStickerJabatan::findKenderaan($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini.']);
            return $this->redirect(['mohon-pelekat-jabatan']);
        }

        return $this->render('form_kenderaan_jabatan', [
                    'model' => $model,
                    'title' => 'Kemaskini Kenderaan',
        ]);
    }

    public function actionMohonPelekatJabatan() {
        $title2 = 'Permohonan Pelekat Lanjutan';
        $dataProviderLanjutan = TblStickerJabatan::findGridKenderaan($title2);
        $title = 'Permohonan Pelekat Baru';
        $dataProvider = TblStickerJabatan::findGridKenderaan($title);

        return $this->render('view_permohonan_jabatan', [
                    'dataProviderLanjutan' => $dataProviderLanjutan,
                    'dataProvider' => $dataProvider,
                    'title' => $title,
        ]);
    }

    //User
    public function actionTambahKenderaan() {
        $model = new TblStickerStaf();

        if ($model->load(Yii::$app->request->post())) {
            $model->veh_owner = strtoupper($model->veh_owner);
            $model->veh_user = strtoupper($model->veh_user);
            $model->veh_model = strtoupper($model->veh_model);
            $model->index = TblStickerStaf::indexKenderaan();
            //check exist kenderaan
            $reg_number = str_replace(' ', '', strtoupper($model->reg_number));
            $own = TblStickerStaf::checkOwnKenderaan($reg_number);
            $else_own = TblStickerStaf::checkElseOwnKenderaan($reg_number);

            if (empty($own) && empty($else_own)) {
                $model->reg_number = $reg_number;
                return $this->simpanKenderaan($model);
            } else {
                //kenderaan exist
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'No Pendaftaran kenderaan telah didaftarkan. Sila hubungi pegawai bertugas untuk mengetahui status pemilikan kenderaan.']);
                return $this->redirect(['mohon-pelekat']);
            }
        }

        return $this->render('form_kenderaan', [
                    'model' => $model,
                    'title' => 'Tambah Kenderaan',
        ]);
    }

    public function actionKemaskiniKenderaan($id) {
        $model = TblStickerStaf::findKenderaan($id);

        if ($model->load(Yii::$app->request->post())) {
            return $this->simpanKenderaan($model);
        }

        return $this->render('form_kenderaan', [
                    'model' => $model,
                    'title' => 'Kemaskini Kenderaan',
        ]);
    }

    public function simpanKenderaan($model) {

        if (empty($model->filename_grant)) {
            $model->filename_grant = UploadedFile::getInstance($model, 'grant');
            if ($model->filename_grant) {
                $res = Yii::$app->FileManager->UploadFile($model->filename_grant->name, $model->filename_grant->tempName, '04', 'E-sticker/Grant');
                if ($res->status == true) {
                    $model->filename_grant = $res->file_name_hashcode;
                }
            }
        }
        if (empty($model->filename_veh_front)) {
            $model->filename_veh_front = UploadedFile::getInstance($model, 'veh_front');
            if ($model->filename_veh_front) {
                $res = Yii::$app->FileManager->UploadFile($model->filename_veh_front->name, $model->filename_veh_front->tempName, '01', 'E-sticker/Veh_Front');
                if ($res->status == true) {
                    $model->filename_veh_front = $res->file_name_hashcode;
                }
            }
        }
        if (empty($model->filename_veh_side)) {
            $model->filename_veh_side = UploadedFile::getInstance($model, 'veh_side');
            if ($model->filename_veh_side) {
                $res = Yii::$app->FileManager->UploadFile($model->filename_veh_side->name, $model->filename_veh_side->tempName, '01', 'E-sticker/Veh_Side');
                if ($res->status == true) {
                    $model->filename_veh_side = $res->file_name_hashcode;
                }
            }
        }
        if (empty($model->filename_veh_rear)) {
            $model->filename_veh_rear = UploadedFile::getInstance($model, 'veh_rear');
            if ($model->filename_veh_rear) {
                $res = Yii::$app->FileManager->UploadFile($model->filename_veh_rear->name, $model->filename_veh_rear->tempName, '01', 'E-sticker/Veh_Rear');
                if ($res->status == true) {
                    $model->filename_veh_rear = $res->file_name_hashcode;
                }
            }
        }

        $model->save(false);

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini.']);
        return $this->redirect(['mohon-pelekat']);
    }

    public function actionMohonPelekat() {
        $title2 = 'Permohonan Pelekat Lanjutan';
        $dataProviderLanjutan = TblStickerStaf::findGridKenderaan($title2);
        $title = 'Permohonan Pelekat Baru';
        $dataProvider = TblStickerStaf::findGridKenderaan($title);

        return $this->render('view_permohonan_user', [
                    'dataProviderLanjutan' => $dataProviderLanjutan,
                    'dataProvider' => $dataProvider,
                    'title' => $title,
        ]);
    }

    public function actionSemakanPermohonanJabatan() {

        $title = 'Semakan Permohonan Jabatan';
        $dataProvider = TblStickerJabatan::findGridKenderaan($title);

        return $this->render('view_permohonan_jabatan', [
                    'dataProvider' => $dataProvider,
                    'title' => $title,
        ]);
    }

    public function actionSemakanPermohonan() {

        //update status sticker after paid
        $pelekat = TblPelekatKenderaan::find()->joinWith(['kenderaan'])
                        ->where(['stc_sticker_staf.v_co_icno' => Yii::$app->user->getId()])
                        ->andWhere(['stc_pelekat_kenderaan.status_mohon' => 'PENDING PAYMENT'])->all();
        if ($pelekat) {
            foreach ($pelekat as $pelekat) {
                $record = PaymentUrl::findOne(['buyer_id' => $pelekat->id]);
                $details = array();
                if ($record) {
                    $details = $this->getPaymentDetails($record->order_no);
                }
                if ($details) {
                    if ($details['status'] == "true") {
                        $pelekat->status_mohon = 'MENUNGGU KUTIPAN';
                        $pelekat->save(false);

                        $arr = array();
                        foreach ($details['details'] as $array) {
                            foreach ($array as $key => $value) {
                                $arr[] = $value;
                            }
                        }

                        $payDetails = new PaymentDetails();
                        $payDetails->payer_name = $arr[0];
                        $payDetails->amount = $arr[1];
                        $payDetails->item_code = $arr[2];
                        $payDetails->ref_no = $arr[3];
                        $payDetails->txn_status = $arr[4];
                        $payDetails->contact_no = $arr[5];
                        $payDetails->payment_method = $arr[6];
                        $payDetails->email = $arr[7];
                        $payDetails->payment_date = $arr[8];
                        $payDetails->payment_detail = $arr[9];
                        $payDetails->save(false);

                        //simpan paymentDetails (Selesai Bayar)
                        //notifikasi
                        $this->EmailStaf($pelekat->user->biodata->ICNO, $arr[3]);
                    } else {
                        $pelekat->status_mohon = 'BATAL';
                        $pelekat->batal = 1;
                        $pelekat->save(false);
                    }
                }
            }
        }

        $title = 'Semakan Permohonan';
        $dataProvider = TblStickerStaf::findGridKenderaan($title);

        return $this->render('view_permohonan_user', [
                    'dataProvider' => $dataProvider,
                    'title' => $title,
        ]);
    }

    public function getPaymentDetails($id) {
        $url = "https://epayment.ums.edu.my/api/epayment/getPaymentDetail";

        $client = new Client();
        $data = $client->request('POST', $url, [
            'auth' => ['044', '655a11e834dfcf21c14cf4ad37b0b758e3df5ea5'],
            'header' => [
                "Accept: application/json",
                'Content-Type' => 'application/json',
            ],
            'form_params' => [
                'order_no' => $id,
            ],
        ]);

        return json_decode($data->getBody(), true);
    }

    public function actionSemakBayaran() {
        $title = 'Semakan Pembayaran';
        $dataProvider = $this->Grid(PaymentUrl::find());

        return $this->render('view_semak_bayaran', [
                    'dataProvider' => $dataProvider,
                    'title' => $title,
        ]);
    }

    public function actionSejarahPermohonan() {
        $title = 'Arkib Permohonan';
        $dataProvider = TblStickerStaf::findGridKenderaan($title);

        return $this->render('view_permohonan_user', [
                    'dataProvider' => $dataProvider,
                    'title' => $title,
        ]);
    }

    public function actionSejarahPermohonanJabatan() {
        $title = 'Arkib Permohonan Jabatan';
        $dataProvider = TblStickerJabatan::findGridKenderaan($title);

        return $this->render('view_permohonan_jabatan', [
                    'dataProvider' => $dataProvider,
                    'title' => $title,
        ]);
    }

    public function actionDeleteFile($id, $title) {
        if ($title == 'roadtax') {
            $model = TblStickerStaf::findKenderaan($id);
            $res = Yii::$app->FileManager->DeleteFile($model->filename_roadtax);
            $model->filename_roadtax = NULL;
            $re = 'kemaskini-kenderaan';
        } elseif ($title == 'grant') {
            $model = TblStickerStaf::findKenderaan($id);
            $res = Yii::$app->FileManager->DeleteFile($model->filename_grant);
            $model->filename_grant = NULL;
            $re = 'kemaskini-kenderaan';
        } elseif ($title == 'grant-kontraktor') {
            $model = TblStickerKontraktor::findKenderaan($id);
            $res = Yii::$app->FileManager->DeleteFile($model->filename_grant);
            $model->filename_grant = NULL;
            $re = 'kemaskini-kenderaan-kontraktor';
        } elseif ($title == 'veh_front') {
            $model = TblStickerStaf::findKenderaan($id);
            $res = Yii::$app->FileManager->DeleteFile($model->filename_veh_front);
            $model->filename_veh_front = NULL;
            $re = 'kemaskini-kenderaan';
        } elseif ($title == 'veh_side') {
            $model = TblStickerStaf::findKenderaan($id);
            $res = Yii::$app->FileManager->DeleteFile($model->filename_veh_side);
            $model->filename_veh_side = NULL;
            $re = 'kemaskini-kenderaan';
        } elseif ($title == 'veh_rear') {
            $model = TblStickerStaf::findKenderaan($id);
            $res = Yii::$app->FileManager->DeleteFile($model->filename_veh_rear);
            $model->filename_veh_rear = NULL;
            $re = 'kemaskini-kenderaan';
        } elseif ($title == 'kt_vaksin_pm') {
            $model = TblPekerjaKontraktor::findOne(['id' => $id]);
            $res = Yii::$app->FileManager->DeleteFile($model->filename_vaksin_pm);
            $model->filename_vaksin_pm = NULL;
            $re = 'kemaskini-pekerja';
        } elseif ($title == 'kt_sijil_pm') {
            $model = TblPekerjaKontraktor::findOne(['id' => $id]);
            $res = Yii::$app->FileManager->DeleteFile($model->filename_sijil_pm);
            $model->filename_sijil_pm = NULL;
            $re = 'kemaskini-pekerja';
        } elseif ($title == 'kt_kad_cidb') {
            $model = TblPekerjaKontraktor::findOne(['id' => $id]);
            $res = Yii::$app->FileManager->DeleteFile($model->filename_kad_cidb);
            $model->filename_kad_cidb = NULL;
            $re = 'kemaskini-pekerja';
        }

        if ($res->status == true) {
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Fail berjaya dibuang']);
            return $this->redirect([$re, 'id' => $id]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Fail tidak berjaya dibuang']);
            return $this->redirect([$re, 'id' => $id]);
        }
    }

    public function actionMohonJabatan($id) {

        $pelekat = new TblPelekatKenderaanJabatan();

        $exist = TblPelekatKenderaanJabatan::find()->where(['id_kenderaan' => $id])->andWhere(['IN', 'status_mohon', ['AKTIF', 'DITOLAK']])->one();

        if ($pelekat->load(Yii::$app->request->post())) {
            if (empty($exist)) { // permohonan baru
                $pelekat->apply_type = 'BARU';
                $text = 'Sila lengkapkan Tarikh/Masa pengambilan.';
            } else {
                $text = 'Sila lengkapkan Jenis Lanjutan dan Tarikh/Masa pengambilan.';
            }
            if (!empty($pelekat->apply_type) && !empty($pelekat->wakil_masa_ambil)) {
                if (TblStickerJabatan::Checking($id) === true) {

                    $pelekat->id_kenderaan = $id;
                    $pelekat->status_mohon = 'MENUNGGU KUTIPAN';
                    $pelekat->save(false);
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => '']);
                    return $this->redirect(['semakan-permohonan-jabatan']);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => TblStickerStaf::Checking($id)]); //display pop-up error message
                    return $this->redirect(['mohon-pelekat-jabatan']);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => $text]);
                return $this->redirect(['mohon-pelekat-jabatan']);
            }
        }


        return $this->renderAjax('form_jenis_permohonan_jabatan', [
                    'model' => $pelekat,
                    'exist' => $exist,
        ]);
    }

    public function actionMohon($id) {

        $pelekat = new TblPelekatKenderaan();

        $exist = TblPelekatKenderaan::find()->where(['id_kenderaan' => $id])->andWhere(['IN', 'status_mohon', ['AKTIF', 'DITOLAK']])->one();

        if (empty($exist)) { // permohonan baru
            if (TblStickerStaf::Checking($id) === true) {
                $model = TblPelekatKenderaan::find()->where(['id_kenderaan' => $id])
                        ->andWhere(['IN', 'status_mohon', ['PENDING PAYMENT']])
                        ->one();
                if ($model) {
                    $pelekatToPay = $model->id;
                } else {
                    $pelekat->id_kenderaan = $id;
                    $pelekat->status_mohon = 'PENDING PAYMENT';
                    $pelekat->apply_type = 'BARU';
                    $pelekat->save(false);

                    $model = TblPelekatKenderaan::find()->where(['id_kenderaan' => $id])
                                    ->andWhere(['IN', 'status_mohon', ['PENDING PAYMENT']])
                                    ->andWhere(['DATE(mohon_date)' => date('Y-m-d')])->one();
                    $pelekatToPay = $model->id;
                }
                return $this->redirect(['payment', 'id' => $pelekatToPay]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => TblStickerStaf::Checking($id)]); //display pop-up error message
                return $this->redirect(['mohon-pelekat']);
            }
        } else { //permohonan lanjutan
            if ($pelekat->load(Yii::$app->request->post())) {
                if (TblStickerStaf::Checking($id) === true) {
                    $model = TblPelekatKenderaan::find()->where(['id_kenderaan' => $id])
                            ->andWhere(['IN', 'status_mohon', ['PENDING PAYMENT']])
                            ->one();
                    if ($model) {
                        $pelekatToPay = $model->id;
                    } else {
                        $pelekat->id_kenderaan = $id;
                        $pelekat->status_mohon = 'PENDING PAYMENT';
                        $pelekat->save(false);

                        $model = TblPelekatKenderaan::find()->where(['id_kenderaan' => $id])
                                        ->andWhere(['IN', 'status_mohon', ['PENDING PAYMENT']])
                                        ->andWhere(['DATE(mohon_date)' => date('Y-m-d')])->one();
                        $pelekatToPay = $model->id;
                    }
                    return $this->redirect(['payment', 'id' => $pelekatToPay]);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => TblStickerStaf::Checking($id)]); //display pop-up error message
                    return $this->redirect(['mohon-pelekat']);
                }
            }

            return $this->renderAjax('form_jenis_permohonan', [
                        'model' => $pelekat,
            ]);
        }
    }

    public function actionPayment($id) {
        $pelekat = TblPelekatKenderaan::find()->where(['id' => $id])->one();
        $sticker = TblStickerStaf::find()->where(['id' => $pelekat->id_kenderaan])->one();

        $rekodInvoice = PaymentInvoice::findOne(['ref1' => $id]);

        if ($rekodInvoice) {
            $payment = PaymentUrl::findOne(['buyer_id' => $id]);
            return '<script>window.open("' . $payment->payment_url . '", "_self")</script>';
        } else {
            $invoice = new PaymentInvoice();

            $invoice->ref1 = $pelekat->id;
            $invoice->ref1_desc = $sticker->reg_number;
            $invoice->ref2 = $sticker->biodata->ICNO;
            $invoice->ref2_desc = 'STAFF';
            $invoice->customer_name = $sticker->biodata->CONm;
            $invoice->detail = 'PELEKAT STAFF';
            $invoice->email = $sticker->biodata->COEmail;
            $invoice->contact_no = $sticker->biodata->COHPhoneNo;
            if ($pelekat->apply_type == 'BARU') {
                $invoice->amount = PayRate::findAmountRate('STAFF', $sticker->v_co_icno, $sticker->index);
            } else {
                $invoice->amount = PayRate::findAmountRateLanjutan($sticker->id);
            }

            if ($invoice->load(Yii::$app->request->post()) && $pelekat->load(Yii::$app->request->post())) {

                if ($invoice->payment_method == 'KAUNTER') {
                    $pelekat->status_mohon = 'MENUNGGU BAYARAN KAUNTER';
                    $pelekat->total = $invoice->amount;
                    $pelekat->jenis_bayaran = 1;
                    $pelekat->save(false);

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya!', 'type' => 'success', 'msg' => '']);
                    return $this->redirect(['semakan-permohonan']);
                } else {

                    $url = "https://epayment.ums.edu.my/api/epayment/charge";

                    $client = new Client();
                    $data = $client->request('POST', $url, [
                        'auth' => ['044', '655a11e834dfcf21c14cf4ad37b0b758e3df5ea5'],
                        'header' => [
                            "Accept: application/json",
                            'Content-Type' => 'application/json',
                        ],
                        'form_params' => [
                            'item_code' => '044',
                            'ref1' => $invoice->ref1,
                            'ref1_desc' => $invoice->ref1_desc,
                            'ref2' => $invoice->ref2,
                            'ref2_desc' => $invoice->ref2_desc,
                            'customer_name' => $invoice->customer_name,
                            'detail' => $invoice->detail,
                            'contact_no' => $invoice->contact_no,
                            'email' => $invoice->email,
                            'amount' => $invoice->amount,
                            'payment_method' => $invoice->payment_method,
                            'return_url' => 'https://registrar.ums.edu.my',
                        ],
                    ]);

                    $payment = json_decode($data->getBody(), true);

                    if ($payment) {

                        if ($payment['status'] == "CHARGED" && $payment['message'] == "Successfully charged") {
                            $charge = new PaymentUrl();
                            $charge->buyer_name = $payment['invoice']["buyer_name"];
                            $charge->buyer_id = $payment['invoice']["buyer_id"];
                            $charge->amount = $payment['invoice']["amount"];
                            $charge->order_no = $payment['invoice']["order_no"];
                            $charge->detail = $payment['invoice']["detail"];
                            $charge->payment_url = $payment['payment_url'];
                            $pelekat->jenis_bayaran = 2;
                            $pelekat->total = $invoice->amount;

                            $pelekat->save(false);
                            $invoice->save(false);
                            $charge->save(false);

                            return '<script>window.open("' . $payment['payment_url'] . '", "_self")</script>';
                        } else {
                            Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'proses pembayaran secara atas talian sedang mengalami gangguan. Sila cuba sebentar lagi..']);
                            return $this->redirect(['semakan-permohonan']);
                        }
                    } else {
                        Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'proses pembayaran secara atas talian sedang mengalami gangguan. Sila cuba sebentar lagi..']);
                        return $this->redirect(['semakan-permohonan']);
                    }
                }
            }

            return $this->render('form_payment', [
                        'invoice' => $invoice,
                        'pelekat' => $pelekat,
            ]);
        }
    }

    public function actionPayRate() {

        if (TblAccess::findOne(['ICNO' => Yii::$app->user->getId()])) {
            $model = PayRate::findGridRate();
        } else if (Department::findOne(['chief' => Yii::$app->user->getId()])) {
            $model = PayRate::findGridRatebyType(['KHAS']);
        } else if (Department::findOne(['pp' => Yii::$app->user->getId()])) {
            $model = PayRate::findGridRatebyType(['STAFF', 'JABATAN']);
        } else {
            $model = PayRate::findGridRatebyType(['STAFF']);
        }

        return $this->render('view_pay_rate', [
                    'model' => $model,
        ]);
    }

    public function actionSemakanKenderaanKontraktor() {
        $searchModel = new RekodKenderaanKontraktorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('form_semakan_kenderaan_kontraktor', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMohonKontraktor($id) {
        $kontraktor = TblStickerKontraktor::findOne(['id' => $id]);
        $record = TblKontraktor::findOne(['apsu_suppid' => $kontraktor->id_kontraktor]);

        $pelekat = new TblPelekatKenderaanKontraktor();
        $pelekat->expired_date = date('Y-m-d', strtotime(date('Y-m-d')));
        $pelekat->expired_date_2 = date('Y-m-d', strtotime('+1 year', strtotime($pelekat->expired_date)));
        $pelekat->kod_siri = $kontraktor->kod_siri = $kontraktor->kodSiri->kod_siri;
        $crSiri = $pelekat->siri = $kontraktor->siri = TblBookingSiri::findRunningSiriKontraktor($kontraktor->kodSiri->kod_siri);
        $pelekat->total = $record->findStickerRate($kontraktor->id);

        $exist = TblPelekatKenderaanKontraktor::findOne(['id_kenderaan' => $id]);

        if ($pelekat->load(Yii::$app->request->post())) {
            $exist = TblPelekatKenderaanKontraktor::find()->where(['kod_siri' => $pelekat->kod_siri, 'siri' => $pelekat->siri])->one();
            if ($exist) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Nombor siri telah wujud.']);
                return $this->redirect(['mohon-kontraktor', 'id' => $id]);
            } elseif ($pelekat->siri > 100000) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Nombor siri melebihi angka yang ditetapkan.']);
                return $this->redirect(['mohon-kontraktor', 'id' => $id]);
            } else {
                //store if booked siri
                if ($crSiri != $kontraktor->siri) {
                    $this->simpanBookingSiri(3, $kontraktor);
                }

                if (TblStickerKontraktor::Checking($id) === true) {
                    $pelekat->no_siri = $pelekat->kod_siri . $pelekat->siri;
                    $pelekat->id_kontraktor = $kontraktor->id_kontraktor;
                    $pelekat->id_kenderaan = $id;
                    $pelekat->save();

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'disimpan.']);
                    return $this->redirect(['senarai-kontraktor-pelekat', 'id' => $kontraktor->id_kontraktor]);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => TblStickerKontraktor::Checking($id)]); //display pop-up error message
                    return $this->redirect(['senarai-kontraktor', 'id' => $kontraktor->id_kontraktor]);
                }
            }
        }

        return $this->render('form_jenis_permohonan_kontraktor', [
                    'model' => $pelekat,
                    'exist' => $exist,
                    'record' => $record,
                    'kenderaan' => $kontraktor,
        ]);
    }

    public function actionBatalPermohonan($id) {
        $model = TblPelekatKenderaan::findOne(['id' => $id]);
        $model->status_mohon = 'BATAL';
        $model->batal = 1;
        $model->save(false);
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dibatalkan.']);
        return $this->redirect(['semakan-permohonan']);
    }

    public function actionStatusKenderaanJabatan($id) {
        $model = TblStickerJabatan::findKenderaan($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->status_kenderaan == 'TIDAK AKTIF') {
                if (empty($model->catatan)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila isi catatan.']);
                    return $this->redirect(['mohon-pelekat-jabatan']);
                } else {
                    $check = TblPelekatKenderaanJabatan::findPelekatDiterima($model->id); //find aktif permohonan pelekat semasa
                    if ($check) {
                        $check->deleted = 1;
                        $check->save();
                    }
                    $model->save(false);
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dikemaskini.']);
                    return $this->redirect(['mohon-pelekat-jabatan']);
                }
            } else {
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dikemaskini.']);
                return $this->redirect(['mohon-pelekat-jabatan']);
            }
        }

        return $this->renderAjax('form_status_kenderaan', [
                    'model' => $model,
        ]);
    }

    public function actionStatusKenderaan($id) {
        $model = TblStickerStaf::findKenderaan($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->status_kenderaan == 'TIDAK AKTIF') {
                if (empty($model->catatan)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila isi catatan.']);
                    return $this->redirect(['mohon-pelekat']);
                } else {
                    $check = TblPelekatKenderaan::findPelekatDiterima($model->id); //find aktif permohonan pelekat semasa
                    if ($check) {
                        $check->deleted = 1;
                        $check->save();
                    }
                    $model->save(false);
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dikemaskini.']);
                    return $this->redirect(['mohon-pelekat']);
                }
            } else {
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dikemaskini.']);
                return $this->redirect(['mohon-pelekat']);
            }
        }

        return $this->renderAjax('form_status_kenderaan', [
                    'model' => $model,
        ]);
    }

    public function actionLesen() {

        return $this->render('view_lesen', [
                    'dataProvider' => TblStickerStaf::findGridLesen(),
        ]);
    }

    public function actionDeleteLesen($id) {
        $lesen = Tbllesen::findOne(['licId' => $id]);
        $lesen->delete();

        $model = TblStickerStaf::findAll(['lesen_id' => $id]);

        foreach ($model as $model) {
            $model->lesen_id = NULL;
            $model->save(false);
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dipadam', 'type' => 'success', 'msg' => '']);
        return $this->redirect(['lesen']);
    }

    public function actionPadamKenderaan($id) {
        $model = TblStickerStaf::findKenderaan($id);
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dipadam', 'type' => 'success', 'msg' => '']);
        return $this->redirect(['mohon-pelekat']);
    }

    public function actionPadamKenderaanJabatan($id) {
        $model = TblStickerJabatan::findKenderaan($id);
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dipadam', 'type' => 'success', 'msg' => '']);
        return $this->redirect(['mohon-pelekat-jabatan']);
    }

    public function actionSemakSaman() {
        $pending = SamanOld::findGrid('PENDING'); //by ICNO
        $pending2 = TblStickerStaf::findGridSaman('PENDING'); //by reg_number

        return $this->render('view_semak_saman', [
                    'pending' => $pending,
                    'pending2' => $pending2,
        ]);
    }

    public function actionSaman() {

        $searchModel = new SamanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('form_carian_saman', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    //kontraktor  

    public function actionStatusSyarikat() {
        $searchModel = new SenaraiKontraktorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rpt_senarai_kontraktor', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTambahKenderaanKontraktor() {
        $model = new TblStickerKontraktor();

        if ($model->load(Yii::$app->request->post())) {
            $model->veh_owner = strtoupper($model->veh_owner);
            $model->veh_user = strtoupper($model->veh_user);
            $model->veh_model = strtoupper($model->veh_model);
            //check exist kenderaan
            $reg_number = str_replace(' ', '', strtoupper($model->reg_number));

            //check if kenderaan jenis sendiri block if exist jumlah 1 (limit hanya 1 kenderaan)
            $status = false;
            if ($model->rel_owner_user == 'DIRI SENDIRI') {
                $selfown = TblStickerKontraktor::checkOwnKenderaanSendiri($model->v_co_icno);
                if (empty($selfown)) {
                    $status = true;
                } else {
                    $msg = 'Mencapai limit kenderaan yang dibenarkan. Sila kemaskini status kenderaan pekerja untuk membuat mendaftarkan kenderaan baru.';
                }
            } else {
                $own = TblStickerKontraktor::checkOwnKenderaan($reg_number);
                if (empty($own)) {
                    $status = true;
                } else {
                    $msg = 'Kenderaan telah didaftarkan.';
                }
            }

            if ($status == true) {
                $model->reg_number = $reg_number;
                $this->simpanKenderaanKontraktor($model);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah.']);
                return $this->redirect(['tambah-kenderaan-kontraktor']);
            } else {
                //kenderaan exist
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => $msg]);
                return $this->redirect(['tambah-kenderaan-kontraktor']);
            }
        }

        return $this->render('form_kenderaan_kontraktor', [
                    'model' => $model,
                    'title' => 'Tambah Kenderaan Kontraktor',
        ]);
    }

    public function actionKemaskiniKenderaanKontraktor($id) {
        $model = TblStickerKontraktor::findOne(['id' => $id]);

        if ($model->load(Yii::$app->request->post())) {
            $model->veh_owner = strtoupper($model->veh_owner);
            $model->veh_user = strtoupper($model->veh_user);
            $model->veh_model = strtoupper($model->veh_model);
            $this->simpanKenderaanKontraktor($model);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini.']);
            return $this->redirect(['senarai-kontraktor', 'id' => $model->id_kontraktor]);
        }

        return $this->render('form_kenderaan_kontraktor', [
                    'model' => $model,
                    'title' => 'Kemaskini Kenderaan Kontraktor',
        ]);
    }

    public function simpanKenderaanKontraktor($model) {

        if (empty($model->filename_grant)) {
            $model->filename_grant = UploadedFile::getInstance($model, 'grant');
            $res = Yii::$app->FileManager->UploadFile($model->filename_grant->name, $model->filename_grant->tempName, '04', 'E-sticker/Grant');
            if ($res->status == true) {
                $model->filename_grant = $res->file_name_hashcode;
            }
        }

        $model->save(false);
    }

    public function actionCarianKontraktor() {
        $model = new TblStickerKontraktor();

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['senarai-kontraktor', 'id' => $model->id_kontraktor]);
        }

        return $this->render('form_carian_kontraktor', [
                    'model' => $model,
                    'title' => 'Carian Kontraktor',
        ]);
    }

    public function actionSenaraiKontraktor($id) {
        $model = new TblStickerKontraktor();
        $record = TblKontraktor::findOne(['apsu_suppid' => $id]);

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['senarai-kontraktor', 'id' => $model->id_kontraktor]);
        }

        return $this->render('form_senarai_kontraktor', [
                    'model' => $model,
                    'record' => $record,
                    'title' => 'Carian Kontraktor',
        ]);
    }

    public function actionCarianKontraktorPelekat() {
        $model = new TblStickerKontraktor();

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['senarai-kontraktor-pelekat', 'id' => $model->id_kontraktor]);
        }

        return $this->render('form_carian_kontraktor', [
                    'model' => $model,
                    'title' => 'Carian Pelekat Kontraktor',
        ]);
    }

    public function actionSenaraiKontraktorPelekat($id) {
        $model = new TblStickerKontraktor();
        $record = TblKontraktor::findOne(['apsu_suppid' => $id]);

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['senarai-kontraktor-pelekat', 'id' => $model->id_kontraktor]);
        }

        return $this->render('form_senarai_kontraktor_pelekat', [
                    'model' => $model,
                    'record' => $record,
                    'title' => 'Carian Pelekat Kontraktor',
        ]);
    }

    //sticker pelawat

    public function actionTambahKenderaanPelawat() {
        $model = new TblStickerPelawat();

        if ($model->load(Yii::$app->request->post())) {
            $model->veh_owner = strtoupper($model->veh_owner);
            $model->veh_model = strtoupper($model->veh_model);
            //check exist kenderaan
            $reg_number = str_replace(' ', '', strtoupper($model->reg_number));
            $status = false;
            $selfown = TblStickerPelawat::checkOwnKenderaanSendiri($model->v_co_icno);
            if (empty($selfown)) {
                $own = TblStickerPelawat::checkOwnKenderaan($reg_number);
                if ($own) {
                    $msg = 'Kenderaan telah didaftarkan.';
                } else {
                    $status = true;
                }
            } else {
                $status = true;
            }
            if ($status == true) {
                $model->reg_number = $reg_number;
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah.']);
                return $this->redirect(['tambah-kenderaan-pelawat']);
            } else {
                //kenderaan exist
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => $msg]);
                return $this->redirect(['tambah-kenderaan-pelawat']);
            }
        }

        return $this->render('form_kenderaan_pelawat', [
                    'model' => $model,
                    'title' => 'Tambah Kenderaan Pelawat',
        ]);
    }

    public function actionKemaskiniKenderaanPelawat($id) {
        $model = TblStickerPelawat::findOne(['id' => $id]);
        $pelawat = TblPelawat::findOne(['ICNO' => $model->v_co_icno]);

        if ($model->load(Yii::$app->request->post())) {
            $model->veh_owner = strtoupper($model->veh_owner);
            $model->veh_model = strtoupper($model->veh_model);
            //check exist kenderaan
            $reg_number = str_replace(' ', '', strtoupper($model->reg_number));

            $model->reg_number = $reg_number;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini.']);
            return $this->redirect(['senarai-pelawat', 'id' => $pelawat->id]);
        }

        return $this->render('form_kenderaan_pelawat', [
                    'model' => $model,
                    'title' => 'Kemaskini Kenderaan Pelawat',
        ]);
    }

    public function actionCarianPelawat() {
        $model = new TblPelawat();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->id) {
                return $this->redirect(['senarai-pelawat', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila pilih nama pelawat.']);
                return $this->redirect(['carian-pelawat']);
            }
        }

        return $this->render('form_carian_pelawat', [
                    'model' => $model,
                    'title' => 'Carian Pelawat',
        ]);
    }

    public function actionSenaraiPelawat($id) {
        $model = new TblPelawat();
        $record = TblPelawat::findOne(['id' => $id]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->id) {
                return $this->redirect(['senarai-pelawat', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila pilih nama pelawat.']);
                return $this->redirect(['senarai-pelawat', 'id' => $id]);
            }
        }

        return $this->render('form_senarai_pelawat', [
                    'model' => $model,
                    'record' => $record,
                    'title' => 'Carian Pelawat',
        ]);
    }

    public function actionCarianPelawatPelekat() {
        $model = new TblPelawat();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->id) {
                return $this->redirect(['senarai-pelawat-pelekat', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila pilih nama pelawat.']);
                return $this->redirect(['carian-pelawat-pelekat']);
            }
        }

        return $this->render('form_carian_pelawat', [
                    'model' => $model,
                    'title' => 'Carian Pelekat Pelawat',
        ]);
    }

    public function actionSenaraiPelawatPelekat($id) {
        $model = new TblPelawat();
        $biodata = TblPelawat::find()->where(['id' => $id])->one();
        $record = TblPelekatKenderaanPelawat::find()->joinWith('kenderaan')->where(['stc_sticker_pelawat.v_co_icno' => $biodata->ICNO])->andWhere(['stc_sticker_pelawat.status_kenderaan' => 'AKTIF'])->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->id) {
                return $this->redirect(['senarai-pelawat-pelekat', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila pilih nama pelawat.']);
                return $this->redirect(['senarai-pelawat-pelekat', 'id' => $id]);
            }
        }

        return $this->render('form_senarai_pelawat_pelekat', [
                    'model' => $model,
                    'biodata' => $biodata,
                    'record' => $record,
                    'title' => 'Carian Pelekat Pelawat',
        ]);
    }

    public function actionMohonPelawat($id) {
        $pelawat = TblStickerPelawat::findOne(['id' => $id]);
        $record = TblPelawat::findOne(['ICNO' => $pelawat->v_co_icno]);
        $pelekat = new TblPelekatKenderaanPelawat();
        $pelekat->expired_date = date('Y-m-d', strtotime(date('Y-m-d')));
        $pelekat->expired_date_2 = date('Y-m-d', strtotime('+1 year', strtotime($pelekat->expired_date)));
        $pelekat->kod_siri = $pelawat->kod_siri = $pelawat->kodSiri->kod_siri;
        $crSiri = $pelekat->siri = $pelawat->siri = TblBookingSiri::findRunningSiriPelawat($pelawat->kodSiri->kod_siri);
        $pelekat->total = $record->findStickerRate();

        $exist = TblPelekatKenderaanPelawat::findOne(['id_kenderaan' => $id]);

        if ($pelekat->load(Yii::$app->request->post())) {
            $exist = TblPelekatKenderaanPelawat::find()->where(['kod_siri' => $pelekat->kod_siri, 'siri' => $pelekat->siri])->one();
            if ($exist) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Nombor siri telah wujud.']);
                return $this->redirect(['mohon-pelawat', 'id' => $id]);
            } elseif ($pelekat->siri > 100000) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Nombor siri melebihi angka yang ditetapkan.']);
                return $this->redirect(['mohon-pelawat', 'id' => $id]);
            } else {
                //store if booked siri
                if ($crSiri != $pelawat->siri) {
                    $this->simpanBookingSiri(5, $pelawat);
                }

                if (TblStickerPelawat::Checking($id) === true) {
                    $pelekat->no_siri = $pelekat->kod_siri . $pelekat->siri;
                    $pelekat->id_kenderaan = $id;
                    $pelekat->save();

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'dimohon']);
                    return $this->redirect(['senarai-pelawat-pelekat', 'id' => $record->id]);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => TblStickerPelawat::Checking($id)]); //display pop-up error message
                    return $this->redirect(['senarai-pelawat', 'id' => $record->id]);
                }
            }
        }


        return $this->render('form_jenis_permohonan_pelawat', [
                    'model' => $pelekat,
                    'exist' => $exist,
                    'record' => $record,
                    'kenderaan' => $pelawat,
        ]);
    }

    //pelawat harian 

    public function actionTambahPelawat() {
        $model = new TblPelawat();

        if ($model->load(Yii::$app->request->post())) {
            $exist = TblPelawat::findOne(['ICNO' => $model->ICNO]);
            if (empty($exist)) {
                $model->CONm = strtoupper($model->CONm);
                $model->save();
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah.']);
                return $this->redirect(['tambah-pelawat']);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'No. KP telah didaftarkan.']);
                return $this->redirect(['tambah-pelawat']);
            }
        }

        return $this->render('form_pelawat', [
                    'model' => $model,
                    'title' => 'Tambah Pelawat',
        ]);
    }

    public function actionKemaskiniPelawat($id) {
        $model = TblPelawat::findPelawat($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->CONm = strtoupper($model->CONm);
            $model->save();
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini.']);
            return $this->redirect(['senarai-masuk-pelawat', 'id' => $id]);
        }

        return $this->render('form_pelawat', [
                    'model' => $model,
                    'title' => 'Kemaskini Pelawat',
        ]);
    }

    public function actionCarianMasukPelawat() {
        $model = new TblPelawat();

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->id)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan nama.']);
            } else {
                return $this->redirect(['senarai-masuk-pelawat', 'id' => $model->id]);
            }
        }

        return $this->render('form_carian_pelawat_in', [
                    'model' => $model,
        ]);
    }

    public function actionSenaraiMasukPelawat($id) {
        $model = new TblPelawat();
        $record = TblPelawat::find()->where(['id' => $id])->one();
        $checkin = TblRekodPelawat::find()->where(['ICNO' => $record->ICNO])->andWhere(['IN', 'flag', [1, 2]])->one();

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->id)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan nama.']);
            } else {
                return $this->redirect(['senarai-masuk-pelawat', 'id' => $model->id]);
            }
        }

        return $this->render('form_senarai_pelawat_in', [
                    'model' => $model,
                    'record' => $record,
                    'checkin' => $checkin,
        ]);
    }

    public function actionCarianKeluarPelawat() {
        $model = new TblPelawat();
        $record = TblRekodPelawat::findGridDaftarKeluar();

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->id)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan nama.']);
            } else {
                return $this->redirect(['senarai-keluar-pelawat', 'id' => $model->id]);
            }
        }

        return $this->render('form_carian_pelawat_out', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionSenaraiKeluarPelawat($id) {
        $model = new TblPelawat();
        $pelawat = TblPelawat::find()->where(['id' => $id])->one();
        $record = TblRekodPelawat::findGridDaftarKeluarOne($pelawat->ICNO);

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->id)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan nama.']);
            } else {
                return $this->redirect(['senarai-keluar-pelawat', 'id' => $model->id]);
            }
        }

        return $this->render('form_senarai_pelawat_out', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionDaftarPelawat($id) {
        $pelawat = TblPelawat::findOne(['id' => $id]);
        $exist = TblRekodPelawat::find()->where(['ICNO' => $pelawat->ICNO])
                        ->andWhere(['flag' => 1])->one();
        if ($exist) {
            $model = $exist;
            $title = 'Daftar Keluar';
            $rec = 'senarai-keluar-pelawat';
        } else {
            $model = new TblRekodPelawat();
            $title = 'Daftar Masuk';
            $rec = 'senarai-masuk-pelawat';
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($title == 'Daftar Keluar') {
                $model->flag = 0; //sudah mengembalikan pas pelawat
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $title]);
                return $this->redirect(['carian-keluar-pelawat']);
            } else {
                if (empty($model->reg_number)) {
                    $model->reg_number = 'TIDAK BERKAITAN';
                }
                $model->ICNO = $pelawat->ICNO;
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $title]);
                return $this->redirect([$rec, 'id' => $id]);
            }
        }

        return $this->render('form_in_out', [
                    'model' => $model,
                    'title' => $title,
        ]);
    }

    public function actionSenaraiHitam($id, $url, $flag) {
        $pelawat = TblPelawat::findOne(['id' => $id]);

        $model = TblRekodPelawat::find()->where(['ICNO' => $pelawat->ICNO])->andWhere(['flag' => $flag])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            if ($url == 'carian-keluar-pelawat') {
                return $this->redirect(['carian-keluar-pelawat']);
            } else if ($url == 'senarai-keluar-pelawat') {
                return $this->redirect(['senarai-keluar-pelawat', 'id' => $id]);
            } else if ($url == 'carian-senarai-hitam') {
                return $this->redirect(['carian-senarai-hitam']);
            } else if ($url == 'rekod-senarai-hitam') {
                return $this->redirect(['rekod-senarai-hitam', 'id' => $id]);
            }
        }

        return $this->render('form_senarai_hitam', [
                    'model' => $model,
                    'title' => 'Borang Senarai Hitam',
                    'url' => $url,
        ]);
    }

    public function actionCarianSenaraiHitam() {
        $model = new TblPelawat();
        $record = TblRekodPelawat::findGridSenaraiHitam();

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->id)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan nama.']);
            } else {
                return $this->redirect(['rekod-senarai-hitam', 'id' => $model->id]);
            }
        }

        return $this->render('form_carian_senarai_hitam', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionRekodSenaraiHitam($id) {
        $model = new TblPelawat();
        $pelawat = TblPelawat::find()->where(['id' => $id])->one();
        $record = TblRekodPelawat::findGridSenaraiHitamOne($pelawat->ICNO);

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->id)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan nama.']);
            } else {
                return $this->redirect(['rekod-senarai-hitam', 'id' => $model->id]);
            }
        }

        return $this->render('form_rekod_senarai_hitam', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    //kontraktor harian

//    public function actionTambahPekerja() {
//        $model = new TblPekerjaKontraktor();
//
//        if ($model->load(Yii::$app->request->post())) {
//            $exist = TblPekerjaKontraktor::findOne(['ICNO' => $model->ICNO]);
//            if (empty($exist)) {
//                $this->simpanPekerja($model);
//                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah.']);
//                return $this->redirect(['tambah-pekerja']);
//            } else {
//                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'No. KP telah didaftarkan.']);
//                return $this->redirect(['tambah-pekerja']);
//            }
//        }
//
//        return $this->render('form_pekerja', [
//                    'model' => $model,
//                    'title' => 'Tambah Pekerja',
//        ]);
//    }
//
//    public function actionKemaskiniPekerja($id) {
//        $model = TblPekerjaKontraktor::findOne(['id' => $id]);
//
//        if ($model->load(Yii::$app->request->post())) {
//            $this->simpanPekerja($model);
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini.']);
//            return $this->redirect(['senarai-masuk-kontraktor', 'id' => $id]);
//        }
//
//        return $this->render('form_pekerja', [
//                    'model' => $model,
//                    'title' => 'Kemaskini Pekerja',
//        ]);
//    }
//
//    public function simpanPekerja($model) {
//
//        $model->CONm = strtoupper($model->CONm);
//        if (empty($model->filename_vaksin_pm)) {
//            $model->filename_vaksin_pm = UploadedFile::getInstance($model, 'kt_vaksin_pm');
//            if ($model->filename_vaksin_pm) {
//                $res = Yii::$app->FileManager->UploadFile($model->filename_vaksin_pm->name, $model->filename_vaksin_pm->tempName, '01', 'E-sticker/kontraktor_vaksin_pm');
//                if ($res->status == true) {
//                    $model->filename_vaksin_pm = $res->file_name_hashcode;
//                }
//            }
//        }
//        if (empty($model->filename_sijil_pm)) {
//            $model->filename_sijil_pm = UploadedFile::getInstance($model, 'kt_sijil_pm');
//            if ($model->filename_sijil_pm) {
//                $res = Yii::$app->FileManager->UploadFile($model->filename_sijil_pm->name, $model->filename_sijil_pm->tempName, '01', 'E-sticker/kontraktor_sijil_pm');
//                if ($res->status == true) {
//                    $model->filename_sijil_pm = $res->file_name_hashcode;
//                }
//            }
//        }
//        if (empty($model->filename_kad_cidb)) {
//            $model->filename_kad_cidb = UploadedFile::getInstance($model, 'kt_kad_cidb');
//            if ($model->filename_kad_cidb) {
//                $res = Yii::$app->FileManager->UploadFile($model->filename_kad_cidb->name, $model->filename_kad_cidb->tempName, '01', 'E-sticker/kontraktor_kad_cidb');
//                if ($res->status == true) {
//                    $model->filename_kad_cidb = $res->file_name_hashcode;
//                }
//            }
//        }
//
//        $model->save(false);
//    }

    public function actionCarianMasukKontraktor() { 
        $model = new RefKontrakType();

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->id)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan jenis kontraktor.']);
            } else {
                return $this->redirect(['senarai-masuk-kontraktor', 'id' => $model->id]);
            }
        }

        return $this->render('form_carian_kontraktor_in', [
                    'model' => $model,
        ]);
    }

    public function actionSenaraiMasukKontraktor($id, $kontraktor = null) {
        $model = new TblKontraktor();
        $rekodbytype = SyarikatKontraktor::find()->where(['jenis_kontrak' => $id])->all();
        $arr = array();
        foreach ($rekodbytype as $rekodbytype) {
            $aktif = TblKontraktor::find()->where(['is not', 'vw_pelekat_hr.tarikhtamatsah', NULL])->andWhere(['>', 'DATE(vw_pelekat_hr.tarikhtamatsah)', date('Y-m-d')])->andWhere(['vw_pelekat_hr.apsu_suppid' => $rekodbytype->apsu_suppid])->one();
            if ($aktif) {
                $arr[] = $rekodbytype->apsu_suppid;
            }
        }

        if (empty($kontraktor)) {
            $record = TblKontraktor::find()->where(['in', 'apsu_suppid', $arr])->orderBy(['apsu_lname' => SORT_ASC])->all();
        } else { 
            $record = TblKontraktor::find()->where(['apsu_suppid' => $kontraktor])->all();
        }


        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->apsu_suppid)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan nama.']);
            } else {
                return $this->redirect(['senarai-masuk-kontraktor', 'id' => $id, 'kontraktor' => $model->apsu_suppid]);
            }
        }

        return $this->render('form_senarai_kontraktor_in', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionSenaraiMasukPekerja($id, $pekerja = null) {
        $syarikat = TblKontraktor::findOne(['apsu_suppid' => $id]);
        $model = new Kontraktor();
        if (is_null($pekerja)) {

            $record = Kontraktor::find()->where(['id_kontraktor' => $id])->andWhere(['Status' => 1])->all();
        } else {
            $record = Kontraktor::find()->where(['id_kontraktor' => $id])->andWhere(['Status' => 1])->andWhere(['ICNO' => $pekerja])->all();
        }


        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->ICNO)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan nama.']);
            } else {
                return $this->redirect(['senarai-masuk-pekerja', 'id' => $id, 'pekerja' => $model->ICNO]);
            }
        }

        return $this->render('form_senarai_masuk_pekerja', [
                    'model' => $model,
                    'record' => $record,
                    'syarikat' => $syarikat,
        ]);
    } 

    public function actionDaftarKontraktor($id) {
        $pekerja = Kontraktor::findOne(['id' => $id]);
        $exist = TblRekodKontraktor::find()->where(['ICNO' => $pekerja->ICNO])
                        ->andWhere(['flag' => 1])->one();

        $rec = 'senarai-masuk-pekerja';
        if ($exist) {
            $model = $exist;
            $title = 'Daftar Keluar';
        } else {
            $model = new TblRekodKontraktor();
            $title = 'Daftar Masuk';
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($title == 'Daftar Keluar') {
                $model->flag = 0; //sudah mengembalikan pas pelawat
                $model->save(false);
            } else {
                $model->ICNO = $pekerja->ICNO;
                $model->save(false);
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $title]);
            return $this->redirect([$rec, 'id' => $pekerja->id_kontraktor]);
        }

        return $this->render('form_in_out_kontraktor', [
                    'model' => $model,
                    'title' => $title,
        ]);
    }

    public function actionSenaraiHitamKontraktor($id, $url, $flag) { 
        $model = TblRekodKontraktor::find()->where(['ICNO' => $id])->andWhere(['flag' => $flag])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            if ($url == 'senarai-masuk-pekerja') {
                return $this->redirect(['senarai-masuk-pekerja','id'=>$model->pekerja->id_kontraktor]);
            } elseif ($url == 'carian-senarai-kontraktor-aktif') {
                return $this->redirect(['carian-senarai-kontraktor-aktif']);
            } else if ($url == 'rekod-senarai-kontraktor-aktif') {
                return $this->redirect(['rekod-senarai-kontraktor-aktif', 'id' => $id]);
            } else if ($url == 'carian-senarai-hitam-kontraktor') {
                return $this->redirect(['carian-senarai-hitam-kontraktor']);
            } else if ($url == 'rekod-senarai-hitam-kontraktor') {
                return $this->redirect(['rekod-senarai-hitam-kontraktor', 'id' => $id]);
            }
        }

        return $this->render('form_senarai_hitam_kontraktor', [
                    'model' => $model,
                    'title' => 'Borang Senarai Hitam',
                    'url' => $url,
        ]);
    }
    
    public function actionCarianSenaraiKontraktorAktif() {
        $model = new Kontraktor();
        $record = TblRekodKontraktor::findGridBelumDaftarKeluar();

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->ICNO)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan nama.']);
            } else {
                return $this->redirect(['rekod-senarai-kontraktor-aktif', 'id' => $model->ICNO]);
            }
        }

        return $this->render('form_carian_kontraktor_aktif', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }
    
    public function actionRekodSenaraiKontraktorAktif($id) {
        $model = new Kontraktor(); 
        $record = TblRekodKontraktor::findGridDaftarKeluarOne($id);

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->ICNO)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan nama.']);
            } else {
                return $this->redirect(['rekod-senarai-kontraktor-aktif', 'id' => $model->ICNO]);
            }
        }

        return $this->render('form_rekod_kontraktor_aktif', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionCarianSenaraiHitamKontraktor() {
        $model = new Kontraktor();
        $record = TblRekodKontraktor::findGridSenaraiHitam();

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->ICNO)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan nama.']);
            } else {
                return $this->redirect(['rekod-senarai-hitam-kontraktor', 'id' => $model->ICNO]);
            }
        }

        return $this->render('form_carian_senarai_hitam_kontraktor', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionRekodSenaraiHitamKontraktor($id) {
        $model = new Kontraktor(); 
        $record = TblRekodKontraktor::findGridSenaraiHitamOne($id);

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->ICNO)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'Sila lengkapkan nama.']);
            } else {
                return $this->redirect(['rekod-senarai-hitam-kontraktor', 'id' => $model->ICNO]);
            }
        }

        return $this->render('form_rekod_senarai_hitam_kontraktor', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    //vip

    public function actionTambahVip() {
        $model = new TblAhliLembagaPengarah();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah.']);
            return $this->redirect(['tambah-vip']);
        }

        return $this->render('form_vip', [
                    'model' => $model,
                    'title' => 'Tambah Ahli Lembaga Pengarah',
        ]);
    }

    public function actionKemaskiniVip($id) {
        $model = TblAhliLembagaPengarah::findVip($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini.']);
            return $this->redirect(['senarai-vip', 'id' => $id]);
        }

        return $this->render('form_vip', [
                    'model' => $model,
                    'title' => 'Kemaskini Ahli Lembaga Pengarah',
        ]);
    }

    public function actionTambahKenderaanVip() {
        $model = new TblStickerVip();

        if ($model->load(Yii::$app->request->post())) {
            $model->veh_owner = strtoupper($model->veh_owner);
            $model->veh_model = strtoupper($model->veh_model);
            //check exist kenderaan
            $reg_number = str_replace(' ', '', strtoupper($model->reg_number));
            $own = TblStickerVip::checkOwnKenderaan($reg_number, $model->id_lpu);

            if (empty($own)) {
                $model->reg_number = $reg_number;
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah.']);
                return $this->redirect(['tambah-kenderaan-vip']);
            } else {
                //kenderaan exist
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Kenderaan telah didaftarkan.']);
                return $this->redirect(['tambah-kenderaan-vip']);
            }
        }

        return $this->render('form_kenderaan_vip', [
                    'model' => $model,
                    'title' => 'Tambah Kenderaan Vip',
        ]);
    }

    public function actionKemaskiniKenderaanVip($id) {
        $model = TblStickerVip::findOne(['id' => $id]);
        $vip = TblAhliLembagaPengarah::findOne(['id' => $model->id_lpu]);

        if ($model->load(Yii::$app->request->post())) {
            $model->veh_owner = strtoupper($model->veh_owner);
            $model->veh_model = strtoupper($model->veh_model);
            //check exist kenderaan
            $reg_number = str_replace(' ', '', strtoupper($model->reg_number));

            $model->reg_number = $reg_number;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini.']);
            return $this->redirect(['senarai-vip', 'id' => $vip->id]);
        }

        return $this->render('form_kenderaan_vip', [
                    'model' => $model,
                    'title' => 'Kemaskini Kenderaan Vip',
        ]);
    }

    public function actionCarianVip() {
        $model = new TblAhliLembagaPengarah();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->id) {
                return $this->redirect(['senarai-vip', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila pilih nama vip.']);
                return $this->redirect(['carian-vip']);
            }
        }

        return $this->render('form_carian_vip', [
                    'model' => $model,
                    'title' => 'Carian Vip',
        ]);
    }

    public function actionSenaraiVip($id) {
        $model = new TblAhliLembagaPengarah();
        $record = TblAhliLembagaPengarah::findOne(['id' => $id]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->id) {
                return $this->redirect(['senarai-vip', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila pilih nama vip.']);
                return $this->redirect(['senarai-vip', 'id' => $id]);
            }
        }

        return $this->render('form_senarai_vip', [
                    'model' => $model,
                    'record' => $record,
                    'title' => 'Carian Vip',
        ]);
    }

    public function actionCarianVipPelekat() {
        $model = new TblAhliLembagaPengarah();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->id) {
                return $this->redirect(['senarai-vip-pelekat', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila pilih nama vip.']);
                return $this->redirect(['carian-vip-pelekat']);
            }
        }

        return $this->render('form_carian_vip', [
                    'model' => $model,
                    'title' => 'Carian Pelekat Vip',
        ]);
    }

    public function actionSenaraiVipPelekat($id) {
        $model = new TblAhliLembagaPengarah();
        $biodata = TblAhliLembagaPengarah::find()->where(['id' => $id])->one();
        $record = TblPelekatKenderaanVip::find()->joinWith('kenderaan')->where(['stc_sticker_vip.id_lpu' => $biodata->id])->andWhere(['stc_sticker_vip.status_kenderaan' => 'AKTIF'])->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->id) {
                return $this->redirect(['senarai-vip-pelekat', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Sila pilih nama vip.']);
                return $this->redirect(['senarai-vip-pelekat', 'id' => $id]);
            }
        }

        return $this->render('form_senarai_vip_pelekat', [
                    'model' => $model,
                    'biodata' => $biodata,
                    'record' => $record,
                    'title' => 'Carian Pelekat Vip',
        ]);
    }

    public function actionMohonVip($id) {
        $vip = TblStickerVip::findOne(['id' => $id]);
        $record = TblAhliLembagaPengarah::findOne(['id' => $vip->id_lpu]);
        $pelekat = new TblPelekatKenderaanVip();
        $pelekat->expired_date = date('Y-m-d', strtotime(date('Y-m-d')));
        $pelekat->expired_date_2 = date('Y-m-d', strtotime('+1 year', strtotime($pelekat->expired_date)));
        $pelekat->kod_siri = $vip->kod_siri = $vip->kodSiri->kod_siri;
        $crSiri = $pelekat->siri = $vip->siri = TblBookingSiri::findRunningSiriVip($vip->kodSiri->kod_siri);

        $exist = TblPelekatKenderaanVip::findOne(['id_kenderaan' => $id]);

        if ($pelekat->load(Yii::$app->request->post())) {
            $exist = TblPelekatKenderaanVip::find()->where(['kod_siri' => $pelekat->kod_siri, 'siri' => $pelekat->siri])->one();
            if ($exist) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Nombor siri telah wujud.']);
                return $this->redirect(['mohon-vip', 'id' => $id]);
            } elseif ($pelekat->siri > 100000) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Nombor siri melebihi angka yang ditetapkan.']);
                return $this->redirect(['mohon-vip', 'id' => $id]);
            } else {
                //tiada checking roadtax & lesen
                $pelekat->siri = $vip->siri = $pelekat->siri;
                $pelekat->no_siri = $pelekat->kod_siri . $pelekat->siri;
                $pelekat->id_kenderaan = $id;

                //store if booked siri
                if ($crSiri != $vip->siri) {
                    $this->simpanBookingSiri(4, $vip);
                }

                $pelekat->save();

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'dimohon']);
                return $this->redirect(['senarai-vip-pelekat', 'id' => $record->id]);
            }
        }

        return $this->render('form_jenis_permohonan_vip', [
                    'model' => $pelekat,
                    'exist' => $exist,
                    'record' => $record,
                    'kenderaan' => $vip,
        ]);
    }

    //Mail

    public function EmailStaf($ICNO, $ref) {
        $payment = PaymentDetails::findOne(['ref_no' => $ref]);
        $biodata = Tblprcobiodata::findOne(['ICNO' => $ICNO]);

        try {
            Yii::$app->mailer2->compose('pelekat_kenderaan_staf', ['biodata' => $biodata, 'payment' => $payment])
                    ->setFrom('esticker_noreply@ums.edu.my')
                    ->setSubject('PELEKAT KENDERAAN UNIVERSITI MALAYSIA SABAH')
                    ->setTo($biodata->COEmail)
                    ->send();

            $mail_status = 1;
        } catch (Exception $e) {
            $mail_status = 0;
        }

        $model = new TblEmail();
        $model->from_name = 'E-STICKER';
        $model->from_email = 'esticker_noreply@ums.edu.my';
        $model->to_name = $biodata->CONm;
        $model->to_email = $biodata->COEmail;
        $model->subject = 'PELEKAT KENDERAAN UNIVERSITI MALAYSIA SABAH';
        $model->message = 'DEFAULT MESSAGE STAFF';
        $model->success = $mail_status;
        $model->date_published = date('Y-m-d H:i:s');
        $model->save();
    }

    public function EmailPelajar($status, $pelekat_id) {
        $mod = TblStickerStudent::findKenderaan($pelekat_id);

        try {
            Yii::$app->mailer2->compose('pelekat_kenderaan_pelajar', ['mod' => $mod, 'status' => $status])
                    ->setFrom('esticker_noreply@ums.edu.my')
                    ->setSubject('PELEKAT KENDERAAN UNIVERSITI MALAYSIA SABAH')
                    ->setTo($mod->biodata->email)
                    ->send();

            $mail_status = 1;
        } catch (Exception $e) {
            $mail_status = 0;
        }

        $model = new TblEmail();
        $model->from_name = 'E-STICKER';
        $model->from_email = 'esticker_noreply@ums.edu.my';
        $model->to_name = $mod->biodata->name;
        $model->to_email = $mod->biodata->email;
        $model->subject = 'PELEKAT KENDERAAN UNIVERSITI MALAYSIA SABAH';
        $model->message = 'DEFAULT MESSAGE STUDENT';
        $model->success = $mail_status;
        $model->date_published = date('Y-m-d H:i:s');
        $model->save();
    }

    public function actionManualPengguna() {
        return $this->render('view_manual', [
                    'title' => 'Manual Pengguna',
        ]);
    }

    //laporan

    public function actionLaporanPelekatStaf() {
        $searchModel = new LaporanPelekatStafSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rpt_pelekat_staf', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLaporanPelekatPelajar() {
        $searchModel = new LaporanPelekatPelajarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rpt_pelekat_pelajar', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLaporanPelekatPelawat() {
        $searchModel = new LaporanPelekatPelawatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rpt_pelekat_pelawat', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLaporanPelawatHarian() {
        $searchModel = new LaporanPelawatHarianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rpt_pelawat_harian', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLaporanShPelawat() {
        $searchModel = new LaporanShPelawatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rpt_pelawat_senarai_hitam', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLaporanKontraktorHarian() {
        $searchModel = new LaporanKontraktorHarianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rpt_kontraktor_harian', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLaporanShKontraktor() {
        $searchModel = new LaporanShKontraktorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rpt_kontraktor_senarai_hitam', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLaporanPelekatVip() {
        $searchModel = new LaporanPelekatVipSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rpt_pelekat_vip', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLaporanPelekatKontraktor() {
        $searchModel = new LaporanPelekatKontraktorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rpt_pelekat_kontraktor', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLaporanPelekatJabatan() {
        $searchModel = new LaporanPelekatJabatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rpt_pelekat_jabatan', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    //pentadbir sistem

    public function actionAccess() {

        $model = new TblAccess();

        $icno = TblAccess::find()->select('ICNO')->asArray()->all();

        $grid = $this->Grid(Tblprcobiodata::find()->where(['IN', 'ICNO', $icno]));

        if ($model->load(Yii::$app->request->post())) {
            $level = $model->lvl;
            if ($level) {
                foreach ($level as $level) {
                    if (empty(TblAccess::find()->where(['ICNO' => $model->ICNO, 'access' => $level])->one())) {
                        $add = new TblAccess();
                        $add->ICNO = $model->ICNO;
                        $add->access = $level;
                        $add->save(false);
                    }
                }
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['access']);
        }

        return $this->render('form_access', [
                    'model' => $model,
                    'grid' => $grid,
        ]);
    }

    public function actionDeleteAccess($id) {
        TblAccess::deleteAll(['ICNO' => $id]);

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => '']);
        return $this->redirect(['access']);
    }

    public function actionEditAccess($id) {

        $model = TblAccess::find()->where(['SHA1(ICNO)' => $id])->one();
        $model->lvl = $model->findRekodLevel();

        $icno = TblAccess::find()->select('ICNO')->asArray()->all();
        $grid = $this->Grid(Tblprcobiodata::find()->where(['IN', 'ICNO', $icno]));

        if ($model->load(Yii::$app->request->post())) {
            $level = $model->lvl;
            if ($level) {
                TblAccess::deleteAll(['ICNO' => $model->ICNO]);
                foreach ($level as $level) {
                    if (empty(TblAccess::find()->where(['ICNO' => $model->ICNO, 'access' => $level])->one())) {
                        $add = new TblAccess();
                        $add->ICNO = $model->ICNO;
                        $add->access = $level;
                        $add->save(false);
                    }
                }
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['access']);
        }

        return $this->render('form_access', [
                    'model' => $model,
                    'grid' => $grid,
        ]);
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

    public function actionTuntutan() {
        //semakan pembayaran
        $tuntutan = TblTuntutan::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['!=', 'pay_status', 1])->one();

        if ($tuntutan) {
            $record = PaymentUrl::findOne(['buyer_id' => $tuntutan->id]);
            if ($record) {
                $details = $this->getPaymentDetails($record->order_no);
                if ($details) {
                    if ($details['status'] == "true") {
                        $tuntutan->pay_status = 1;
                        $tuntutan->pay_type = 2;
                        $tuntutan->updater = Yii::$app->user->getId();
                        $tuntutan->updater_at = date('Y-m-d H:i:s');
                        $tuntutan->remark = 'ATAS TALIAN';

                        $arr = array();
                        foreach ($details['details'] as $array) {
                            foreach ($array as $key => $value) {
                                $arr[] = $value;
                            }
                        }

                        $payDetails = new PaymentDetails();
                        $payDetails->payer_name = $arr[0];
                        $payDetails->amount = $arr[1];
                        $payDetails->item_code = $arr[2];
                        $payDetails->ref_no = $arr[3];
                        $payDetails->txn_status = $arr[4];
                        $payDetails->contact_no = $arr[5];
                        $payDetails->payment_method = $arr[6];
                        $payDetails->email = $arr[7];
                        $payDetails->payment_date = $arr[8];
                        $payDetails->payment_detail = $arr[9];

                        $payDetails->save(false);
                        $tuntutan->save(false);
                    }
                }
            }
        }


        $dataProvider = $this->Grid(TblTuntutan::find()->where(['ICNO' => Yii::$app->user->getId()]));
        return $this->render('view_tuntutan', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBayarTuntutan($id) {
        $model = TblTuntutan::find()->where(['id' => $id])->one();
        $pending = PaymentUrl::find()->where(['buyer_id' => $id])->one();

        if ($pending) {
            return '<script>window.open("' . $pending->payment_url . '", "_self")</script>';
        } else {

            $url = "https://epayment.ums.edu.my/api/epayment/charge";

            $client = new Client();
            $data = $client->request('POST', $url, [
                'auth' => ['044', '655a11e834dfcf21c14cf4ad37b0b758e3df5ea5'],
                'header' => [
                    "Accept: application/json",
                    'Content-Type' => 'application/json',
                ],
                'form_params' => [
                    'item_code' => '044',
                    'ref1' => $model->id,
                    'ref1_desc' => 'BAKI PEMBAYARAN',
                    'ref2' => $model->ICNO,
                    'ref2_desc' => 'STAFF',
                    'customer_name' => $model->biodata->CONm,
                    'detail' => 'PELEKAT STAFF',
                    'contact_no' => $model->biodata->COHPhoneNo,
                    'email' => $model->biodata->COEmail,
                    'amount' => '5.00',
                    'payment_method' => 'FPX',
                    'return_url' => 'https://localhost/staff/web',
                ],
            ]);

            $payment = json_decode($data->getBody(), true);

            if ($payment['status'] == "CHARGED" && $payment['message'] == "Successfully charged") {
                $charge = new PaymentUrl();
                $charge->buyer_name = $payment['invoice']["buyer_name"];
                $charge->buyer_id = $payment['invoice']["buyer_id"];
                $charge->amount = $payment['invoice']["amount"];
                $charge->order_no = $payment['invoice']["order_no"];
                $charge->detail = $payment['invoice']["detail"];
                $charge->payment_url = $payment['payment_url'];
                $charge->save(false);

                return '<script>window.open("' . $payment['payment_url'] . '", "_self")</script>';
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf!', 'type' => 'error', 'msg' => 'proses pembayaran secara atas talian sedang mengalami gangguan. Sila cuba sebentar lagi..']);
                return $this->redirect(['tuntutan']);
            }
        }
    }

    public function actionRekodTuntutan() {
        $model = TblTuntutan::find()->select('ICNO')->asArray()->all();

        $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()->where(['IN', 'ICNO', $model])->orderBy(['CONm' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);
        return $this->render('view_tuntutan_rekod', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionKemaskiniTuntutan($id) {
        $model = TblTuntutan::find()->where(['id' => $id])->one();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $model->ICNO])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['rekod-tuntutan']);
        }

        return $this->render('form_tuntutan_rekod', [
                    'model' => $model,
                    'title' => 'Kemaskini Tuntutan: ' . $biodata->CONm,
        ]);
    }

    public function actionSenaraiPelekat($key) {
        $dataProvider = $this->Grid(TblPelekatKenderaan::find()->joinWith('kenderaan')->where(['md5(stc_sticker_staf.v_co_icno)' => $key]));

        return $this->render('view_senarai_pelekat', [
                    'dataProvider' => $dataProvider,
        ]);
    }

}
