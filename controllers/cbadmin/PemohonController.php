<?php

namespace app\controllers\cbadmin;

use Yii;
use app\models\cbelajar\TblPengajian;
use app\models\cbelajar\TblPengajianSearch;
use app\models\cbelajar\TblDokumen;
use app\models\cbelajar\TblSyarat;
use app\models\cbelajar\Model;
use app\models\cbelajar\TblNilaiSyarat;
use app\models\hronline\Tblprcobiodata;
use app\models\cbelajar\TblFilePemohon;
use app\models\cbelajar\TblpImage;
use app\models\cbelajar\TblPermohonan;
use app\models\cbelajar\TblPermohonanSearch;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Tblpendidikan;
use app\models\hronline\Tblrscoconfirmstatus;
use app\models\cutibelajar\TblAdmin;
use app\models\cbelajar\TblUrusMesyuarat;
use app\models\cbelajar\TblBiasiswa;
use app\models\cbelajar\TblBiasiswaSearch;
use app\models\hronline\Department;
use yii\helpers\Html;
use app\models\Notification;
use tebazil\runner\ConsoleCommandRunner;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
use yii\web\UploadedFile;
use app\models\cbelajar\Option;
use yii\helpers\ArrayHelper;

class PemohonController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['halaman-utama-bsm', 'aktif-takwim', 'maklumat-pemohon', 'findIklan', 'tambah-iklan', 'taraf-jawatan', 'edit-iklan', 'tambah-kelayakan', 'tambah-tugas', 'simpan-iklan',  'findStaff', 'findPemohon', 'saringan-layak', 'saringan-tidak-layak', 'findKumpulan', 'findModel', 'findPengajian', 'findDokumen', 'findDokumenById', 'muat-naik-dokumen', 'pengakuan-pemohon'],
//                'rules' => [
//                    [
//                        'actions' => ['halaman-utama-bsm', 'aktif-takwim', 'maklumat-pemohon', 'findIklan', 'tambah-iklan', 'taraf-jawatan', 'edit-iklan', 'tambah-kelayakan', 'tambah-tugas', 'simpan-iklan', 'findPengajian', 'resume', 'findStaff', 'findPemohon', 'saringan-layak', 'saringan-tidak-layak', 'findKumpulan', 'findModel', 'findDokumen', 'findDokumenById', 'muat-naik-dokumen', 'pengakuan-pemohon'
//                    ],
//                        'allow' => true,
//                        'roles' => ['@'],
//                        'matchCallback' => function ($rule, $action) {
//                     $tmp = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);
//                    return (is_null($tmp)) ? false : true;
//                }
//                    ],
//                ],
//            ],
            'access' => [



                'class' => AccessControl::className(),
                'only' => ['senarai-borang', 'gambar', 'maklumat-peribadi', 'maklumat-akademik', 'maklumat-pengajian',
                    'maklumat-biasiswa', 'senarai-dokumen-dimuatnaik', 'maklumat-keluarga',
                    'pengakuan-pemohon',
                ],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),
                    [
                        'actions' => ['senarai-borang', 'maklumat-peribadi', 'maklumat-akademik',
                            'maklumat-keluarga', 'maklumat-biasiswa', 'maklumat-pengajian', 'gambar', 'senarai-dokumen-dimuatnaik', 'maklumat-keluarga', 'pengakuan-pemohon'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action) {
                    $icno = Yii::$app->user->getId();
                    if ($icno) {
                        $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
                        if (
                                ($biodata->statLantikan == '1' && $biodata->jawatan->job_category == '2')
                        ) {
                            return true;
                        }
                    }

//                    if ((Yii::$app->user->identity->statLantikan == "1" && Yii::$app->user->identity->jobCategory == "1") || (Yii::$app->user->identity->statLantikan == "2" && Yii::$app->user->identity->jobCategory == "1")) {
//                        return TRUE;
//                    }
//                    if (in_array(Yii::$app->user->getId(), ['950829125446', '860130125080', '891103125554'])) {
//                        return TRUE;
//                    }
//
//                    return FALSE;
                },
                    ],
                    [
                        'actions' => ['senarai-borang'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action) {


                    if ((Yii::$app->user->identity->statLantikan == "1" && Yii::$app->user->identity->jawatan->job_category == "1") ||
                            (Yii::$app->user->identity->statLantikan == "2" && Yii::$app->user->identity->jawatan->job_category == "1") ||
                            (Yii::$app->user->identity->statLantikan == "1" && Yii::$app->user->identity->jawatan->job_category == "2")) {
                        return TRUE;
                    }

                    if (in_array(Yii::$app->user->getId(), ['891103125554'])) {
                        return TRUE;
                    }

                    return FALSE;
                },
                    ],
                ],
            ],
        ];
    }

    //Get User IC
    protected function icno() {

        return Yii::$app->user->getId();
    }

    protected function notifikasi($icno, $content) {
        //--------Model Notification-----------//
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $icno;
        $ntf->title = 'Permohonan Pengajian Lanjutan Pentadbiran';
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        //--------Model Notification-----------//
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionGambar($id) {

        $check = TblpImage::findOne(['ICNO' => $this->ICNO(), 'iklan_id' => $id]);
        $iklan = $this->findIklanbyID($id);
        if ($check) {
            $model = $check;
        } else {
            $model = new TblpImage();
        }

        if ($model->load(Yii::$app->request->post())) {
            echo "c";
            echo "br";
//            var_dump($model);
            echo "br";
            $image = $model->uploadImage();
            $model->ICNO = $this->ICNO();
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');

            /*             * ********************************************************************** */

            $model->filename = UploadedFile::getInstances($model, 'image');

            foreach ($model->filename as $saving) {
                echo "b";
                if ($saving) {
                    echo "a";
                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '01', 'cutibelajar');

                    $file_path = $file->file_name_hashcode;
                }
                $simpan = new TblpImage();
                //$simpan->uploaded_by = $icno;
                //$simpan->dokumenCd = $id;
                //$simpan->namafile = $file_path;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->iklan_id = $iklan->id;
                $simpan->ICNO = $this->ICNO();
                $simpan->filename = $file_path;
                $simpan->save();
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                return $this->redirect(['gambar', 'id' => $iklan->id]);
            }



//            /****************************************************************************/
//            if ($model->save()) {
//                if ($image !== false) {
//                    $path = $model->getImageFile();
//                    $image->saveAs($path);
////                }
//                Yii::$app->session->setFlash('alert', ['title' => 'Gambar Berjaya Di Simpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
//                return $this->redirect(['gambar', 'id'=> $iklan->id]);
//            } else {
//                // error in saving model
//            }
        }
        #getting data from table option
//        $option = Option::find()->where(["in", "name", ["date_open", "date_close"]])->all();
//
//        #convert object to array
//        $dateRange = ArrayHelper::map($option, 'name', 'value');
//
//        $today = date('Y-m-d', strtotime(date('Y-m-d')));
//        $start = date('Y-m-d', strtotime($dateRange['date_open']));
//        $end = date('Y-m-d', strtotime($dateRange['date_close']));
//
//        $open = "false";
//        #checking date between start and end
//        if (($today >= $start) && ($today <= $end)){
//            $open = "true";
//        }
//
//        $options = ["open" => $open, "date" => $dateRange];
        return $this->render('form_gambar', [
                    'model' => $model,
                    'iklan' => $iklan,
//                    'options' => $options
        ]);
    }

    protected function findIklanbyID($id) {
        if (($model = TblUrusMesyuarat::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMaklumatPeribadi($id) {
        $icno = Yii::$app->user->getId();
        $biodata = $this->findBiodata();
        $status = $this->findPerkhidmatanbyICNO();
        $model2 = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt');
        //ambil tarikh status pengesahan yang latest
        $confirm = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno, 'ConfirmStatusStDt' => $model2])->one()->ConfirmStatusStDt;
        $model = new TblPermohonan();
        $model->icno = $icno;
        $iklan = $this->findIklanbyID($id);

        return $this->render('form_peribadi', [

                    'biodata' => $biodata,
                    'status' => $status,
                    'iklan' => $iklan,
                    'model2' => $model2,
                    'confirm' => $confirm,
        ]);
    }

    protected function findBiodata() {
        if (($model = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findPerkhidmatanbyICNO() {
        if (($model = Tblrscoconfirmstatus::findAll(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }
    }

    public function actionMaklumatAkademik($id) {
        $icno = Yii::$app->user->getId();
        $model = new TblPermohonan();
        $model->icno = $icno;
        $iklan = $this->findIklanbyID($id);
        $sabatikal2 = $this->findSabatikal();
        return $this->render('form_akademik', [
                    'akademik' => $this->findAkademikbyICNO(),
                    'iklan' => $iklan,
                    'sabatikal2' => $sabatikal2,
        ]);
    }

    protected function findSabatikal() {
        return \app\models\cbelajar\TblPengajian::findAll(['icno' => $this->ICNO(), 'status' => 2]);
    }

    protected function findAkademikbyICNO() {
        if (($model = Tblpendidikan::findAll(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMaklumatPengajian($id) {

        $pengajianTinggi = TblPengajian::findAll(['icno' => $this->ICNO(), 'iklan_id' => $id, 'idBorang' => 1]);
        $iklan = $this->findIklanbyID($id);

        $icno = Yii::$app->user->getId();
        $sabatikal2 = $this->findSabatikal();
        $model = new TblPengajian();
        $model->icno = $icno;
        if ($model->load(Yii::$app->request->post())) {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->HighestEduLevelCd;
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['maklumat-pengajian', 'id' => $model->id]);
        }
        $searchModel = new TblPengajianSearch();
        $query = TblPengajian::find()->where(['icno' => $icno]);
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('form_pengajian', [
                    'model' => $model,
                    'iklan' => $iklan,
                    'eduhighest' => $pengajianTinggi,
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
                    'sabatikal2' => $sabatikal2,
        ]);
    }

    public function actionTambahPengajian($id) {
        $icno = Yii::$app->user->getId();
        $model = new TblPengajian();
        $iklan = $this->findIklanByID($id);
                $biodata = $this->findBiodata();

//        $permohonan = $this->findPermohonanbyID($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->idBorang = 1;
//            $model->modeID;
            $model->userID = 2;
            $model->gred = $biodata->jawatan->gred;
            $model->status_proses = "S";
            $model->status = 9; //dalam proses;
//            $model->full_dt = ['TblPengajian']['full_dt'];
//            $model->parent_id = $iklan->id;
//            $model->idPermohonan = $permohonan->id;
            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Pengajian telah Berjaya ditambah!']);

                return $this->redirect(['maklumat-pengajian', 'id' => $iklan->id]);
            }
        }
        return $this->render('tambahpengajian', [
                    'model' => $model,
                    'iklan' => $iklan,
//                    'permohonan' => $permohonan,
//                    'id' => $id,
        ]);
    }

    public function actionMaklumatBiasiswa($id) {
        $request = Yii::$app->request;
        $sponsor = TblBiasiswa::findAll(['icno' => $this->ICNO(), 'iklan_id' => $id, 'idBorang' => 1]);
        $icno = Yii::$app->user->getId();
        $iklan = $this->findIklanbyID($id);
        $model = new TblBiasiswa();
        $model->icno = $icno;
        if ($model->load(Yii::$app->request->post())) {
            $model->nama_tajaan = $request->post()['TblBiasiswa']['nama_tajaan'];
            $model->BantuanCd = $request->post()['TblBiasiswa']['BantuanCd'];
            $model->BantuanCd_ums = $request->post()['TblBiasiswa']['BantuanCd_ums'];
            $model->BantuanCd_ums = $request->post()['TblBiasiswa']['BantuanCd_ums'];
            $model->amaunBantuan = $request->post()['TblBiasiswa']['amaunBantuan'];
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['maklumat-biasiswa', 'id' => $model->id]);
        }
        $searchModel = new TblBiasiswaSearch();
        $query = TblBiasiswa::find()->where(['icno' => $icno]);
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('form_biasiswa', [
                    'model' => $model,
                    'iklan' => $iklan,
                    'sponsor' => $sponsor,
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
        ]);
    }

    public function actionTanpatajaan($id) {

        $icno = Yii::$app->user->getId();
        $model = new TblBiasiswa();
        $model2 = TblBiasiswa::findAll(['icno' => $this->ICNO()]);
        $iklan = $this->findIklanByID($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->iklan_id = $iklan->id;
            $model->bentukBantuan = "TANPA TAJAAN";
            $model->BantuanCd = "6";
            $model->jenisCd = "4";
            $model->idBorang = 2;
            $model->amaunBantuan = "PERSENDIRIAN";
            $model->icno = $icno;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->tahun = date("Y");
            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya ditambah!']);
                return $this->redirect(['cbadmin/pemohon/maklumat-biasiswa', 'id' => $iklan->id]);
            }
        }
        return $this->render('_tanpatajaan', [
                    'model' => $model,
                    'iklan' => $iklan,
                    'model2' => $model2,
        ]);
    }

    protected function findBiasiswabyid($id) {
        if (($model = TblBiasiswa::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionLihatbiasiswa($id) {

        return $this->render('_lihatbiasiswa', [
                    'model' => $this->findBiasiswabyid($id),
        ]);
    }

    public function actionDeleteBiasiswa($id, $i) {
        $mj = TblBiasiswa::findOne($id)->delete();
        return $this->redirect(['cbadmin/pemohon/maklumat-biasiswa', 'id' => $i]);
    }

    public function actionTambahBiasiswa($id) {
        $icno = Yii::$app->user->getId();
        $model = new TblBiasiswa();
        $modelCustomer = new TblPermohonan();
        $modelsAddress = [new TblBiasiswa()];
        $model2 = TblBiasiswa::findAll(['icno' => $this->ICNO()]);
        $iklan = $this->findIklanByID($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->iklan_id = $iklan->id;
            $model->bentukBantuan_ums;
            $model->BantuanCd;
            $model->icno = $icno;
            $model->idBorang = 1;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->tahun = date("Y");
            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya ditambah!']);
                return $this->redirect(['cbadmin/pemohon/maklumat-biasiswa', 'id' => $iklan->id]);
            }
        }
        return $this->render('tambahbiasiswa', [
                    'model' => $model,
                    'iklan' => $iklan,
                    'model2' => $model2,
                    'modelCustomer' => $modelCustomer,
                    'modelsAddress' => $modelsAddress,
        ]);
    }

    public function actionTajaanluar($id) {

        $modelsAddress = [new TblBiasiswa()];
        $model = TblBiasiswa::findAll(['icno' => $this->ICNO()]);
        $iklan = $this->findIklanByID($id);
        if ((Yii::$app->request->post())) {

            $modelsAddress = \app\models\cbelajar\Model::createMultiple(TblBiasiswa::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());

//            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                                ActiveForm::validateMultiple($modelsAddress), ActiveForm::validate($modelCustomer)
                );
            }
            $valid = Model::validateMultiple($modelsAddress) && $valid;

            $transaction = \Yii::$app->db->beginTransaction();
            try {

                foreach ($modelsAddress as $i => $modelAddress) {
//                                $modelAddress->icno = $modelCustomer->icno;
                    $modelAddress->icno = Yii::$app->user->getId();
                    $modelAddress->jenisCd = 1;
                    $modelAddress->nama_tajaan;
                    $modelAddress->BantuanCd;
                    $modelAddress->idBorang = 1;
                    $modelAddress->iklan_id = $iklan->id;
                    $modelAddress->created_dt = new \yii\db\Expression('NOW()');
                    $modelAddress->tahun = date("Y");
//                              $modelAddress->parent_id = $modelCustomer->id;
//                              $modelAddress->idBorang = 1;
                    if (!($flag = $modelAddress->save())) {
                        $transaction->rollBack();
                        break;
                    }
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan.']);
                if ($flag) {
                    $transaction->commit();

                    return $this->redirect(['cbadmin/pemohon/maklumat-biasiswa', 'id' => $iklan->id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        return $this->render('_tajaanluar', [
                    'model' => $model,
                    'modelsAddress' => (empty($modelsAddress)) ? [new TblBiasiswa] : $modelsAddress,
                    'iklan' => $iklan
        ]);
    }

    public function actionBiasiswaums($id) {

        $modelsAddress = [new TblBiasiswa()];
        $model = TblBiasiswa::findAll(['icno' => $this->ICNO()]);
        $iklan = $this->findIklanByID($id);
        if ((Yii::$app->request->post())) {

            $modelsAddress = \app\models\cbelajar\Model::createMultiple(TblBiasiswa::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());

//            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                                ActiveForm::validateMultiple($modelsAddress), ActiveForm::validate($modelCustomer)
                );
            }
            $valid = Model::validateMultiple($modelsAddress) && $valid;

            $transaction = \Yii::$app->db->beginTransaction();
            try {

                foreach ($modelsAddress as $i => $modelAddress) {
//                                $modelAddress->icno = $modelCustomer->icno;
                    $modelAddress->icno = Yii::$app->user->getId();
                    $modelAddress->jenisCd = 2;
                    $modelAddress->nama_tajaan = "BIASISWA PENGURUSAN UMS";
//                    if ($modelAddress->sponsor->BantuanCd == 1) {
//                        $modelAddress->BantuanCd = 3;
//                    } else {
//                        $modelAddress->BantuanCd = 2;
//                    }
                    $modelAddress->idBorang = 1;
                    $modelAddress->iklan_id = $iklan->id;
                    $modelAddress->created_dt = new \yii\db\Expression('NOW()');
                    $modelAddress->tahun = date("Y");
//                              $modelAddress->parent_id = $modelCustomer->id;
//                              $modelAddress->idBorang = 1;
                    if (!($flag = $modelAddress->save())) {
                        $transaction->rollBack();
                        break;
                    }
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan.']);
                if ($flag) {
                    $transaction->commit();

                    return $this->redirect(['cbadmin/pemohon/maklumat-biasiswa', 'id' => $iklan->id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        return $this->render('_biasiswaums', [
                    'model' => $model,
                    'modelsAddress' => (empty($modelsAddress)) ? [new TblBiasiswa] : $modelsAddress,
                    'iklan' => $iklan,
        ]);
    }

    public function actionMaklumatKeluarga($id) {
        $icno = Yii::$app->user->getId();
        $iklan = $this->findIklanbyID($id);
        $model = new TblPermohonan();
        $model->icno = $icno;
        return $this->render('form_keluarga', [
                    'keluarga' => $this->findKeluargabyICNO(),
                    'iklan' => $iklan,
        ]);
    }

    protected function findKeluargabyICNO() {
        if (($model = Tblkeluarga::findAll(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSenaraiDokumenDimuatnaik($id) {
        //$model = new TblFilePemohon();
        $icno = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblFilePemohon();
        $iklan = $this->findIklanbyID($id);
        $model->uploaded_by = $icno;
        $dokumen2 = \app\models\cbelajar\TblFilePemohon::findAll(['uploaded_by' => $this->ICNO(), 'iklan_id' => $id]);
        $dokumen1 = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' => $this->ICNO(), 'iklan_id' => $id]);
//        $files = TblFilePemohon::findAll(['uploaded_by' => $icno]);
        return $this->render('form_dokumen', [

                    'dokumen2' => $this->findDokumenbyICNO(),
                    'iklan' => $iklan,
                    'dokumen2' => $dokumen2,
                    'dokumen1' => $dokumen1,
        ]);
    }

    protected function findDokumenbyICNO() {
        if (($model = TblFilePemohon::findAll(['uploaded_by' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSenaraiDokumen($id) {

        $senarai_dokumen = $this->findDokumen(1);
        $senarai_dokumen1 = $this->findDokumen1(1);
        $iklan = $this->findIklanbyID($id);
        return $this->render('form_upload_dokumen', [
                    'senarai_dokumen' => $senarai_dokumen,
                    'senarai_dokumen1' => $senarai_dokumen1,
                    'iklan' => $iklan,
        ]);
    }

    public function findDokumen($status) {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => TblDokumen::find()->where(['status' => $status, 'kategori' => 2]),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }

    public function findDokumen1($status) {
        $senarai_dokumen1 = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblDokumenKpm::find()->where(['status' => $status, 'kategori' => 2]),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen1;
    }

    public function actionMuatNaikDokumen($id, $iklan_id) {
        $icno = Yii::$app->user->getId();
        $dokumen = $this->findDokumenKpmbyId($id);
        $model = new \app\models\cbelajar\TblFileKpm();
        $iklan = $this->findIklanbyID($iklan_id);
        if (\app\models\cbelajar\TblFileKpm::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id' => $iklan->id])->exists()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
            return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]); //
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->namafile = UploadedFile::getInstances($model, 'namafile');

            foreach ($model->namafile as $saving) {
                if ($saving) {
                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');

                    $file_path = $file->file_name_hashcode;
                }
                $simpan = new \app\models\cbelajar\TblFileKpm();
                $simpan->uploaded_by = $icno;
                $simpan->dokumenCd = $id;
                $simpan->idBorang = 1;
                $simpan->namafile = $file_path;
                $simpan->nama_dokumen = $dokumen->nama_dokumen;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->iklan_id = $iklan->id;
                $simpan->save();
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);
            }
        } else {
            return $this->render('upload-dokumen', [
                        'model' => $model,
                        'iklan' => $iklan,
            ]);
        }
    }

    protected function findDokumenKpmById($id) {
        if (($model = \app\models\cbelajar\TblDokumenKpm::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

//    public function actionMuatNaikDokumenCb($id, $iklan_id) {
//       $icno = Yii::$app->user->getId();
//       $dokumen = $this->findDokumenbyId($id);
//       $model = new TblFilePemohon();
//       $iklan =  $this->findIklanbyID($iklan_id);
//       if(\app\models\cbelajar\TblFilePemohon::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id'=> $iklan->id])->exists())
//        {
//                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
//                         return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);//
//        }
//       if ($model->load(Yii::$app->request->post())) 
//       {
//           $model->namafile= UploadedFile::getInstances($model, 'namafile');
//          
//            foreach ($model->namafile as $saving) {
//                if ($saving) {
//                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');
//
//                    $file_path = $file->file_name_hashcode; 
//
//                }
//                $simpan = new TblFilePemohon();
//                $simpan->uploaded_by = $icno;
//                $simpan->dokumenCd = $id;
//                $simpan->namafile = $file_path;
//                $simpan->created_dt = new \yii\db\Expression('NOW()');
//                $simpan->tahun = date("Y");
//                $simpan->iklan_id = $iklan->id;
//                $simpan->nama_dokumen = $dokumen->nama_dokumen;
//                $simpan->save(false);
//                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
//                   return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);
//            
//            }
//          
//            
//        } else {
//                        return $this->render('upload-dokumen-cb', [
//                        'model' => $model,
//                        'iklan' => $iklan,
//                       
//            ]);
//        }
//    }
    public function actionMuatNaikDokumenCb($id, $iklan_id) {
        $icno = Yii::$app->user->getId();
        $dokumen = $this->findDokumenById($id);
        $model = new \app\models\cbelajar\TblFilePemohon();
        $iklan = $this->findIklanbyID($iklan_id);
        if (\app\models\cbelajar\TblFilePemohon::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id' => $iklan->id])->exists()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
            return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]); //
        }
        if ($model->load(Yii::$app->request->post())) {


            $model->namafile = UploadedFile::getInstances($model, 'namafile');


            foreach ($model->namafile as $saving) {
                if ($saving) {
//                    $var_dump($saving);die;

                    $file = Yii::$app->FileManager->
                            UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');

                    $file_path = $file->file_name_hashcode;
                } else {
                    $file_path = NULL;
                }
            }
            $simpan = new \app\models\cbelajar\TblFilePemohon();
            $simpan->uploaded_by = $icno;
//                $simpan->parent_id = $id;
            if ($model->namafile) {
                $simpan->namafile = $file_path;
            }
            $simpan->dokumenCd = $id;
            $simpan->idBorang = 32;
//                $simpan->namafile = $file_path;
            $simpan->nama_dokumen = $dokumen->nama_dokumen;
            $simpan->created_dt = new \yii\db\Expression('NOW()');
            $simpan->tahun = date("Y");
            $simpan->iklan_id = $iklan->id;
            $simpan->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);

            //}
        } else {
            return $this->renderAjax('update-dokumen-wajib', [
                        'model' => $model,
                        'iklan' => $iklan
            ]);

//            return $this->renderAjax('index', [
//                       
//            ]);
        }
    }

    protected function findDokumenById($id) {
        if (($model = TblDokumen::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findWajib($dokumen) {
        $model = TblFilePemohon::findOne(['uploaded_by' => $this->ICNO(), 'dokumenCd' => $dokumen]);

        if ($model) {
            return $model;
        } else {
            return null;
        }
    }

    public function actionPengakuanPemohon($id) {
        $icno = Yii::$app->user->getId();
        $pengajian = TblPengajian::findAll(['icno' => $this->ICNO(), 'iklan_id' => $id, 'idBorang' => 1]);
        $biasiswa = TblBiasiswa::findAll(['icno' => $this->ICNO(), 'iklan_id' => $id, 'idBorang' => 1]);
        $status = TblPermohonan::findAll(['icno' => $icno]); //senarai status permohonan
        $model = TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() ? TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() : new TblPermohonan();
        $pengajian2 = TblPengajian::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() ?
                TblPengajian::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() : new TblPengajian();
        $sponsor2 = TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->all() ?
                TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->all() :
                new TblBiasiswa();
        $dokumen2 = TblFilePemohon::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id])->all();
        $dokumen = TblFilePemohon::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id, 'idBorang' => 32])
                        ->all() ? TblFilePemohon::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id, 'idBorang' => 32])->all() : new TblFilePemohon();
        $dokumen3 = \app\models\cbelajar\TblFileKpm::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->all();
        $dokumen4 = \app\models\cbelajar\TblFileKpm::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() ? \app\models\cbelajar\TblFileKpm::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() : new \app\models\cbelajar\TblFileKpm();
        $model->icno = $icno;
        $model->tahun = date("Y");
        $biodata = $this->findBiodata();
        $iklan = $this->findIklanbyID($id);
        $wajib = $this->findWajib(20);
        $check = TblpImage::findOne(['ICNO' => $this->ICNO(), 'iklan_id' => $id]);

        $checkb = TblBiasiswa::find()->where(['icno' => $this->ICNO(), 'iklan_id' => $id])->one();
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $model->tarikh_m = date('Y-m-d H:i:s');
        if ($pegawai->sub_of == '' || $pegawai->sub_of == '12') {
            $model->app_by = $pegawai->chief; //kj 
        } else {
            $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
            $model->app_by = $pegawaisub->chief; //kj 
        }

        if ($model->ver_by == '') {

            $model->status = 'DALAM TINDAKAN KETUA JABATAN';
            $petindak1 = 'Ketua Jabatan';
            $icnopetindak1 = $model->app_by;
        }
        $model->status_jfpiu = 'Tunggu Perakuan';
        $model->status_bsm = 'Tunggu Kelulusan';
        $model->status_semakan = 'Tunggu Semakan';


        if (Yii::$app->request->post('simpan')) {

            $model->iklan_id = $iklan->id;
            $model->jenis_user_id = 1;
            $model->status_proses = "Data disimpan";
            $model->agree = 1;
            $model->idBorang = 1;
            $model->created_at = new \yii\db\Expression('NOW()');
            $model->save(false);
            $pengajian2->idPermohonan = $model->id;
            $pengajian2->status = 9;
            $pengajian2->status_proses = "H";
            $pengajian2->save(false);
            foreach ($sponsor2 as $sponsor2) {
//                $sponsor2 = new \stdClass();
                $sponsor2->idPermohonan = $model->id;
                $sponsor2->HighestEduLevelCd = $pengajian2->HighestEduLevelCd;
                $sponsor2->save(false);
//                 $sponsor2->success = false;
            }
            foreach ($dokumen as $d) {
                $d->idPermohonan = $model->id;
                $d->save(false);
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Disimpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['pengakuan-pemohon', 'id' => $id]);
        } elseif ($model->load(Yii::$app->request->post())) {
            if ($check) {
                if ($checkb) {
                    if ($wajib) {
                        if ($model->agree == 0) {
                            Yii::$app->session->setFlash('alert', ['title' => 'Amaran !', 'type' => 'error', 'msg' => 'Sila tanda kotak semak permohonan.']);
                            return $this->redirect(['pengakuan-pemohon', 'id' => $id]);
                        } else {
                            $model->jenis_user_id = 2;
                            $model->status_proses = "Selesai Permohonan";
                            $model->created_at = new \yii\db\Expression('NOW()');
                            $model->agree = 1;
                            $model->idBorang = 1;
                            $model->jenis = "SEPENUH MASA";
                            $model->save(false);
                            $pengajian2->idPermohonan = $model->id;
                            $pengajian2->status = 9;
                            $pengajian2->status_proses = "H";
                            $pengajian2->save(false);

                            foreach ($sponsor2 as $sponsor2) {
//                $sponsor2 = new \stdClass();
                                $sponsor2->idPermohonan = $model->id;
                                $sponsor2->HighestEduLevelCd = $pengajian2->HighestEduLevelCd;
                                $sponsor2->save(false);
//                 $sponsor2->success = false;
                            }
                            foreach ($dokumen as $d) {
                                $d = new \stdClass();

                                $d->idPermohonan = $model->id;
//            $d->save(false);
                                $d->success = false;
                            }
                        }
                    } else {
                        Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => ''
                            . 'Sila muat naik dokumen wajib sebelum menghantar permohonan. Abaikan dokumen wajib yang berkaitan PHD, jika bukan '
                            . 'memohon peringkat pengajian tersebut']);
                        return $this->redirect(['/cbadmin/pemohon/senarai-dokumen?id=' . $id]);
                    }
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => ''
                        . 'Sila isi maklumat pembiayaan/pinjaman, jika tanpa tajaan, sila pilih pilihan tanpa tajaan.']);
                    return $this->redirect(['/cbadmin/pemohon/maklumat-biasiswa?id=' . $id]);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf,', 'type' => 'error', 'msg' => ''
                    . 'Sila muat naik gambar anda']);
                return $this->redirect(['/cbadmin/pemohon/gambar?id=' . $id]);
            }
            $this->pendingtask($icnopetindak1, 11);
            $this->notifikasi($icnopetindak1, "Permohonan Pengajian Lanjutan Pentadbiran  menunggu tindakan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutisabatikal/senaraitindakan'], ['class' => 'btn btn-primary btn-sm']));
            $this->notifikasi($model->icno, "Permohonan Pengajian Lanjutan anda telah dihantar untuk tindakan " . $petindak1 . " " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));

            Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Diterima', 'type' => 'success', 'msg' => 'Berjaya Dihantar.']);
            return $this->redirect(['lihat-permohonan', 'id' => $model->id]); //
        }

        if ($model->agree == '1' || $model->status_proses == 'Data Disimpan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }

        if (TblPermohonan::find()->where(['icno' => $icno, 'jenis_user_id' => 2, 'iklan_id' => $id, 'idBorang' => 1, 'status_proses' => "Selesai Permohonan"])->exists()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah Memohon!', 'type' => 'error', 'msg' => 'Permohonan hanya boleh dibuat sekali sahaja.']);
            return $this->redirect(['cbadmin/pemohon/lihat-permohonan', 'id' => $model->id]); //
        }
        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "2") || ($model->kakitangan->statLantikan == "3" && $model->kakitangan->jawatan->job_category == "2")) {
            return $this->render('form_pengakuan', [
                        'iklan' => $iklan,
                        'model' => $model,
                        'img' => $biodata->img,
                        'biodata' => $biodata,
                        'akademik' => $this->findAkademikbyICNO(),
                        'keluarga' => $this->findKeluargabyICNO(),
                        'pengajian' => $pengajian,
                        'biasiswa' => $biasiswa,
                        'dokumen' => $dokumen,
                        'dokumen2' => $dokumen2,
                        'dokumen3' => $dokumen3,
                        'dokumen4' => $dokumen4,
                        'edit' => $edit,
                        'view' => $view,
                        'status' => $status,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('halaman-utama-pemohon');
        }
    }

    protected function pendingtask($icno, $id) {
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }

    public function actionLihatPermohonan($id) {
        $icno = Yii::$app->user->getId();
        $pengajian = TblPengajian::findAll(['idPermohonan' => $id]);
        $biasiswa = TblBiasiswa::findAll(['idPermohonan' => $id]);
        $status = TblPermohonan::findAll(['icno' => $icno]); //senarai status permohonan
        $model = TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() ? TblPermohonan::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() : new TblPermohonan();
                $model3 = TblPermohonan::find()->where(['icno' => $icno, 'idBorang' => 1])->one(); //senarai status permohonan

        $pengajian2 = TblPengajian::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() ? TblPengajian::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() : new TblPengajian();
        $sponsor2 = TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() ? TblBiasiswa::find()->where(['icno' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() : new TblBiasiswa();
        $dokumen2 = TblFilePemohon::find()->where(['uploaded_by' => $icno])->all();
        $dokumen = TblFilePemohon::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id])->one() ? TblFilePemohon::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id])->one() : new TblFilePemohon();
        $dokumen3 = \app\models\cbelajar\TblFileKpm::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->all();
        $dokumen4 = \app\models\cbelajar\TblFileKpm::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id, 'idBorang' => 1])->one() ? \app\models\cbelajar\TblFileKpm::find()->where(['uploaded_by' => $icno, 'iklan_id' => $id, 'idBorang' => 32])->one() : new \app\models\cbelajar\TblFileKpm();
        $model->icno = $icno;
        $model->tahun = date("Y");
        $biodata = $this->findBiodata();
//        $iklan = $this->findIklanbyID($id);
//        $i=$model->iklan_id;
//        $iklan = $this->findIklanbyID($i);

        if (($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "2") || ($model->kakitangan->statLantikan == "2" && $model->kakitangan->jawatan->job_category == "2")) {
            if (TblPermohonan::find()->where(['icno' => $icno, 'id' => $id, 'status_proses' => "Selesai Permohonan"])->exists()) {
                return $this->render('/cbadmin/pemohon/lihatpermohonan', [
//                'iklan' => $iklan,
                            'model' => $model,
                            'img' => $biodata->img,
                            'biodata' => $biodata,
                            'akademik' => $this->findAkademikbyICNO(),
                            'keluarga' => $this->findKeluargabyICNO(),
                            'pengajian' => $pengajian,
                            'biasiswa' => $biasiswa,
                            'dokumen' => $dokumen,
                            'dokumen2' => $dokumen2,
                            'dokumen3' => $dokumen3,
                            'dokumen4' => $dokumen4,
                            'status' => $status,
                            'model3'=>$model3,
                ]);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('cutibelajar/halaman-pemohon');
        }
    }

    public function actionLihatpengajian($id) {
//        $iklan = $this->findIklanbyID($id);

        return $this->render('_lihatpengajian', [

                    'model' => $this->findModelbyid($id),
//            'iklan'=> $iklan,
//            'iklan' => $this->findIklanbyID($model->iklan_id),
        ]);
    }

    public function actionUpdateStudy($id) {
        $model = \app\models\cbelajar\TblPengajian::find()->where(['id' => $id])->one();
//        $icno = $model->icno;
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            return $this->redirect(['maklumat-pengajian?id=' . $model->iklan_id]);
        }

        return $this->renderAjax('_updates', [
                    'model' => $model,
        ]);
    }

    public function actionUpdateSponsor($id) {
        $model = \app\models\cbelajar\TblBiasiswa::find()->where(['id' => $id])->one();
//        $icno = $model->icno;
//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            return $this->redirect(['maklumat-biasiswa?id=' . $model->iklan_id]);
        }

        return $this->renderAjax('_updateb', [
                    'model' => $model,
        ]);
    }

    public function actionDelete($id, $i) {

        $mj = TblPengajian::findOne($id)->delete();


        return $this->redirect(['cbadmin/pemohon/maklumat-pengajian', 'id' => $i]);
    }

    protected function findModelbyid($id) {
        if (($model = TblPengajian::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
