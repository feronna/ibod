<?php

namespace app\controllers;

use app\models\adu\Fungsi;
use app\models\adu\Komp2;
use app\models\adu\Main;
use app\models\adu\Respon;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use app\models\lppums\RefBahagian;
use app\models\lppums\RefKriteria;
use app\models\lppums\TblBahagianKriteria;
use app\models\utilities\DiariDeleted;
use app\models\utilities\DiariKetuaJbtn;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;


class SmoController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['*'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        // 'matchCallback' => function ($rule, $action) {
                        //     return DiariKetuaJbtn::isKj(Yii::$app->user->identity->ICNO);
                        // }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete-catatan' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionListKomponen1()
    {
        $this->view->title = 'Senarai Maklumbalas & Cadangan';

        $icno = Yii::$app->user->getId();

        $searchModel = new Main();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $icno);

        return $this->render('list-komponen-1', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'total' => Main::totalByStatus($icno),
        ]);
    }

    public function actionCreateKomponen1()
    {

        $this->view->title = 'Maklumbalas & Cadangan';
        $icno = Yii::$app->user->getId();
        $model = new Main();
        $model->scenario = 'aduan-baharu';

        $fungsi = Fungsi::find()->select(['id' => 'id', 'detail' => 'CONCAT(id,". ",detail)'])->all();
        $department = Department::find()->select(['id' => 'id', 'fullname' => 'CONCAT(shortname," - ",fullname)'])->where(['isActive' => 1])->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file) {
                $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '01', 'SMO-UMS');

                if ($datas->status == true) {
                    $model->hashcode = $datas->file_name_hashcode;
                    $model->doc_name = $model->file->name;
                }
            }

            $model->complainant = $icno;
            $model->create_dt = date('Y-m-d H:i:s');
            $model->status = 'ENTRY';

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['smo/list-komponen-1']);
            }
        }

        return $this->render('create-komponen-1', [
            'model' => $model,
            'fungsi' => $fungsi,
            'department' => $department,
        ]);
    }

    public function actionListPantauKj()
    {
        $this->view->title = 'Senarai Maklumbalas (Ketua Jabatan / Dekan / Pengarah)';

        $icno = Yii::$app->user->getId();
        $dept_id = Yii::$app->user->identity->DeptId;

        $searchModel = new Main();
        $dataProvider = $searchModel->searchKj(Yii::$app->request->queryParams, $dept_id);

        return $this->render('kj/list-pantau', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    public function actionCreateKomponen2()
    {

        $this->view->title = 'Pemantauan PYD';
        $icno = Yii::$app->user->getId();
        $model = new Komp2();
        $model->scenario = 'baharu';

        $bhgn = RefBahagian::find()->where(['bahagian_id' => ['2', '3', '1']])->orderBy(['bahagian' => 'DESC'])->all();
        $kriteria = RefKriteria::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file) {
                $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '01', 'SMO-UMS');

                if ($datas->status == true) {
                    $model->hashcode = $datas->file_name_hashcode;
                    $model->doc_name = $model->file->name;
                }
            }

            $model->icno = $icno; //Penilai
            $model->create_dt = date('Y-m-d H:i:s');
            $model->status = 'ENTRY';

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['list-komponen-2']);
            }
        }

        return $this->render('create-komponen-2', [
            'model' => $model,
            'bhgn' => $bhgn,
            'kriteria' => $kriteria,
            'icno' => $icno,
        ]);
    }

    public function actionListKomponen2()
    {
        $this->view->title = 'Senarai Pemantauan PYD';

        $icno = Yii::$app->user->getId();

        $searchModel = new Komp2();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $icno);

        return $this->render('list-komponen-2', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'total' => Komp2::totalByStatus($icno),
        ]);
    }


    public function actionCreate()
    {

        $this->view->title = 'Maklumbalas Baharu';
        $icno = Yii::$app->user->getId();
        $model = new Main();
        $model->scenario = 'aduan-baharu';

        $department = Department::find()->select(['id' => 'id', 'fullname' => 'CONCAT(shortname," - ",fullname)'])->where(['isActive' => 1])->all();
        $bhgn = RefBahagian::find()->where(['bahagian_id' => ['1', '2', '3']])->all();
        $kriteria = RefKriteria::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file) {
                $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '01', 'ADUAN KETAKAKURAN');

                if ($datas->status == true) {
                    $model->hashcode = $datas->file_name_hashcode;
                    $model->doc_name = $model->file->name;
                }
            }

            $model->complainant = $icno;
            $model->create_dt = date('Y-m-d H:i:s');
            $model->status = 'ENTRY';

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['index']);
            }
        }

        return $this->render('form-create', [
            'model' => $model,
            'department' => $department,
            'bhgn' => $bhgn,
            'kriteria' => $kriteria,
        ]);
    }

    public function actionListKjK1()
    {
        $this->view->title = 'Senarai menunggu tindakan Ketua Jabatan';

        $icno = Yii::$app->user->getId();
        $dept_id = Yii::$app->user->identity->DeptId;
        $model = null;

        $department = Department::find()->where(['chief' => $icno, 'id' => $dept_id, 'isActive' => 1])->one();

        if ($department) {
            $model = Main::find()->where(['location' => $dept_id, 'status' => 'ENTRY'])->all();
        }

        return $this->render('kj/list-k1', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionListBsm()
    {
        $this->view->title = 'Senarai menunggu tindakan Ketua BSM';

        $icno = Yii::$app->user->getId();
        $dept_id = Yii::$app->user->identity->DeptId;
        $model = null;

        $department = Department::find()->where(['chief' => $icno, 'shortname' => 'BSM', 'isActive' => 1])->one();

        if ($department) {
            $model = Main::find()->where(['status' => 'BSM'])->all();
        }

        return $this->render('bsm/index', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionListPpuu()
    {
        $this->view->title = 'Senarai menunggu tindakan Ketua PPUU';

        $icno = Yii::$app->user->getId();
        $model = null;

        $department = Department::find()->where(['chief' => $icno,  'shortname' => 'PPUU', 'isActive' => 1])->one();

        if ($department) {
            $model = Main::find()->where(['status' => 'PPUU'])->all();
        }

        return $this->render('ppuu/index', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionListK1()
    {
        $this->view->title = 'Senarai Menunggu tindakan anda';

        $icno = Yii::$app->user->getId();

        $model = Main::find()->where(['assigned_staff' => $icno, 'status' => 'ASSIGNED'])->all();

        return $this->render('assigned/list-k1', [
            'model' => $model,
            'bil' => 1,
        ]);
    }


    public function actionListK2()
    {
        $this->view->title = 'Senarai Menunggu tindakan anda';

        $icno = Yii::$app->user->getId();

        $model = Komp2::find()->where(['pyd' => $icno, 'status' => 'ENTRY'])->all();

        return $this->render('assigned/list-k2', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionTindakanKjK1($key)
    {
        $this->view->title = 'Tindakan Ketua JAFPIB';

        $icno = Yii::$app->user->getId();
        $dept_id = Yii::$app->user->identity->DeptId;

        $model = Main::find()->where(['SHA2(id,"256")' => $key])->one();

        if ($model->load(Yii::$app->request->post())) {

            $model->update_dt = date('Y-m-d H:i:s');

            if ($model->respon_detail) {
                $model->respon_by = $icno;
                $model->respon_dt = date('Y-m-d H:i:s');
            }

            $assignedStaff = $model->assignedBio->CONm;

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => "Maklum balas telah dihantar kepada $assignedStaff"]);
                return $this->redirect(['list-kj-k1']);
            }
        }

        if ($dept_id == 12) {

            $subOf = Department::find()->where(['sub_of' => 12])->all();

            $listDept = ArrayHelper::getColumn($subOf, 'id', $keepKeys = true);

            $listStaffs = Tblprcobiodata::find()
                ->joinWith(['jawatan'])
                ->where(['status' => 1])
                ->andFilterWhere(['IN', 'DeptId', $listDept])
                ->andWhere(['job_group' => 4])
                ->all();
        } else {
            $listStaffs = Tblprcobiodata::find()->joinWith(['jawatan'])->where(['DeptId' => $dept_id, 'status' => 1])->andWhere(['job_group' => 4])->all();
        }

        $responList = Respon::find()->where(['SHA2(main_id,"256")' => $key])->all();

        $respon = new Respon();

        return $this->render('kj/tindakan-kj-k1', [
            'bil' => 1,
            'model' => $model,
            'responList' => $responList,
            'respon' => $respon,
            'listStaffs' => $listStaffs,
            'arrStatus' => ['ASSIGNED' => 'ASSIGN TO STAFF', 'BSM' => 'ASSIGN TO HR', 'COMPLETED' => 'COMPLETE'],
            'icno' => $icno,
            'redirectUrl' => 'tindakan-kj-k1',
        ]);
    }

    public function actionTindakanK1($key)
    {
        $this->view->title = 'Tindakan Penerima Maklumbalas';

        $icno = Yii::$app->user->getId();
        $dept_id = Yii::$app->user->identity->DeptId;

        $listStaffs = Tblprcobiodata::find()->joinWith(['jawatan'])->where(['DeptId' => $dept_id, 'status' => 1])->andWhere(['job_group' => 4])->all();

        $model = Main::find()->where(['SHA2(id,"256")' => $key])->one();

        if ($model->load(Yii::$app->request->post())) {

            $model->update_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['list-k1']);
            }
        }

        $responList = Respon::find()->where(['SHA2(main_id,"256")' => $key])->all();

        $respon = new Respon();

        return $this->render('assigned/tindakan-k1', [
            'bil' => 1,
            'model' => $model,
            'responList' => $responList,
            'listStaffs' => $listStaffs,
            'respon' => $respon,
            'arrStatus' => ['ENTRY' => 'RETURN TO KJ'],
            'icno' => $icno,
            'redirectUrl' => 'tindakan-k1',
        ]);
    }

    public function actionResponPemberi($key)
    {
        $this->view->title = 'Tindakan Penerima Maklumbalas';

        $icno = Yii::$app->user->getId();

        $model = Main::find()->where(['SHA2(id,"256")' => $key])->one();

        if ($model->load(Yii::$app->request->post())) {

            $model->update_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['list-k1']);
            }
        }

        $responList = Respon::find()->where(['SHA2(main_id,"256")' => $key])->all();

        $respon = new Respon();

        return $this->render('respon-pemberi', [
            'bil' => 1,
            'model' => $model,
            'responList' => $responList,
            'respon' => $respon,
            'icno' => $icno,
            'redirectUrl' => 'respon-pemberi',
        ]);
    }

    public function actionTindakanK2($key)
    {
        $this->view->title = 'Tindakan Penerima Tindakan';

        $icno = Yii::$app->user->getId();

        $model = Komp2::find()->where(['SHA2(id,"256")' => $key])->one();
        $model->scenario = 'maklumbalas';

        if ($model->load(Yii::$app->request->post())) {

            $model->update_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['list-k1']);
            }
        }

        $responList = Respon::find()->where(['SHA2(main_id,"256")' => $key])->all();

        $respon = new Respon();

        return $this->render('assigned/tindakan-k2', [
            'bil' => 1,
            'model' => $model,
            'responList' => $responList,
            'respon' => $respon,
            'arrStatus' => ['COMPLETED' => 'SELESAI'],
            'icno' => $icno,
            'data' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10],
            'redirectUrl' => 'tindakan-k2',
        ]);
    }

    public function actionTindakanBsm($key)
    {
        $this->view->title = 'Tindakan Ketua BSM';

        $icno = Yii::$app->user->getId();
        $dept_id = Yii::$app->user->identity->DeptId;

        $model = Main::find()->where(['SHA2(id,"256")' => $key])->one();

        if ($model->load(Yii::$app->request->post())) {

            $model->update_dt = date('Y-m-d H:i:s');

            if ($model->respon_detail) {
                $model->respon_by = $icno;
                $model->respon_dt = date('Y-m-d H:i:s');
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['list-bsm']);
            }
        }

        $responList = Respon::find()->where(['SHA2(main_id,"256")' => $key])->all();

        $respon = new Respon();

        return $this->render('bsm/tindakan', [
            'bil' => 1,
            'model' => $model,
            'responList' => $responList,
            'respon' => $respon,
            'arrStatus' => ['ENTRY' => 'RETURN TO KJ', 'PPUU' => 'FORWARD TO PPUU', 'COMPLETED' => 'COMPLETE'],
            'icno' => $icno,
            'redirectUrl' => 'tindakan-bsm',
        ]);
    }

    public function actionTindakanPpuu($key)
    {
        $this->view->title = 'Tindakan Ketua PPUU';

        $icno = Yii::$app->user->getId();
        $dept_id = Yii::$app->user->identity->DeptId;

        $model = Main::find()->where(['SHA2(id,"256")' => $key])->one();

        if ($model->load(Yii::$app->request->post())) {

            $model->update_dt = date('Y-m-d H:i:s');

            if ($model->respon_detail) {
                $model->respon_by = $icno;
                $model->respon_dt = date('Y-m-d H:i:s');
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['list-ppuu']);
            }
        }

        $responList = Respon::find()->where(['SHA2(main_id,"256")' => $key])->all();

        $respon = new Respon();

        return $this->render('ppuu/tindakan', [
            'bil' => 1,
            'model' => $model,
            'responList' => $responList,
            'respon' => $respon,
            'arrStatus' => ['ENTRY' => 'RETURN TO KJ', 'BSM' => 'RETURN TO BSM', 'COMPLETED' => 'COMPLETE'],
            'icno' => $icno,
            'redirectUrl' => 'tindakan-ppuu',
        ]);
    }

    public function actionResponKj()
    {
        $model = new Respon();

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->create_dt = date('Y-m-d H:i:s');
            $main = Main::findOne(['id' => $model->main_id]);

            if ($model->respon_type == 2) {

                $main->assigned_staff = $model->responKpd;
                $main->status = 'ASSIGNED';
                $main->update_dt = date("Y-m-d H:i:s");
                $main->save(false);

                if ($model->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Respon telah dihantar kepada pegawai yang ditetapkan']);
                    return $this->redirect(['smo/list-kj-k1']);
                }
            } else if ($model->respon_type == 1) {

                $main->status = 'RESPONDED';
                $main->update_dt = date("Y-m-d H:i:s");
                $main->save(false);

                if ($model->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Respon telah dihantar terus kepada pemaklumbalas']);
                    return $this->redirect(['smo/list-kj-k1']);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => ' Amaran', 'type' => 'warning', 'msg' => 'Sila isi ruangan Syor dan Ulasan!']);
                return $this->redirect([$model->redirectUrl, 'key' => hash('sha256', $model->main_id)]);
            }
        }
    }

    public function actionUpdateCatatan($id)
    {

        $this->view->title = 'Kemaskini Catatan';

        $icno = Yii::$app->user->getId();
        $dept_id = Yii::$app->user->identity->DeptId;

        $model = DiariKetuaJbtn::findOne($id);
        $arrType = $model->arrType();


        $biodata = $this->senaraiNama($icno, $dept_id);

        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $icno;
            $model->update_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Catatan telah berjaya disimpan!']);
                return $this->redirect(['index']);
            }
        }

        return $this->render('form-diari', [
            'model' => $model,
            'biodata' => $biodata,
            'arrType' => $arrType,
        ]);
    }



    public function senaraiNama($icno, $dept_id)
    {

        $biodata = Tblprcobiodata::find()
            ->select(['ICNO', 'CONm'])
            ->where(['Status' => 1, 'deptId' => $dept_id])
            ->andWhere(['<>', 'ICNO', $icno])
            ->all();

        return $biodata;
    }

    public function actionDeleteCatatan($id)
    {

        $model = DiariKetuaJbtn::findOne($id);

        if ($model->delete()) {

            $mdl = new DiariDeleted();
            $mdl->staf_icno = $model->staf_icno;
            $mdl->icno = $model->icno;
            $mdl->title = $model->title;
            $mdl->detail = $model->detail;
            $mdl->status = $model->status;
            $mdl->create_dt = $model->create_dt;
            $mdl->update_dt = $model->update_dt;
            $mdl->delete_dt = date('Y-m-d H:i:s');
            $mdl->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Catatan telah dibuang!']);
            return $this->redirect(['index']);
        }
    }

    public function actionViewK1($id)
    {

        $model = Main::findOne($id);

        return $this->renderAjax('view-k1', [
            'model' => $model,
        ]);
    }
    public function actionViewK2($id)
    {

        $model = Komp2::findOne($id);

        return $this->renderAjax('view-k2', [
            'model' => $model,
        ]);
    }

    public function actionCompleteView($id)
    {

        $model = Main::findOne($id);

        $query = Respon::find()->where(['main_id' => $id]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'create_dt' => SORT_DESC,
                ]
            ],
        ]);

        return $this->renderAjax('complete-view', [
            'model' => $model,
            'provider' => $provider,
        ]);
    }

    public function actionCriteriaList()
    {

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

        // $kumpKhidmat = $biodata->jawatan->job_group;


        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $bahagian_id = $parents[0];
                $kumpKhidmat = 5;

                $bhgnKriteria = TblBahagianKriteria::find()->where(['bahagian_id' => $bahagian_id, 'kump_khidmat' => $kumpKhidmat])->all();

                $arr_kriteria = [];

                foreach ($bhgnKriteria as $bhgn) {
                    $arr_kriteria[] = $bhgn->kriteria_id;
                }

                $out = RefKriteria::find()->select(['id' => 'kriteria_id', 'name' => 'CONCAT(kriteria_label," - ",kriteria)'])->where(['kriteria_id' => $arr_kriteria])->asArray()->all();

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }


    public function actionListAdminK1()
    {
        $this->view->title = 'Senarai Komponen 1';

        $searchModel = new Main();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list-admin-k1', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    public function actionViewAdminK1($id)
    {

        $model = Main::findOne($id);

        $responList = Respon::find()->where(['main_id' => $id])->all();

        return $this->renderAjax('view-admin-k1', [
            'model' => $model,
            'responList' => $responList,
            'bil' => 1,
        ]);
    }

    public function actionListAdminK2()
    {
        $this->view->title = 'Senarai Pemantauan PYD';

        $searchModel = new Komp2();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list-admin-k2', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionDeleteEntri($id)
    {
        $model = Komp2::findOne($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Removed', 'type' => 'success', 'msg' => 'Entri telah dibuang!']);
            return $this->redirect(['smo/list-admin-k2']);
        }
    }
}
