<?php

namespace app\controllers;

use app\models\dkums\AffectMeasures;
use app\models\dkums\JobEngagement;
use app\models\dkums\JobSatisfaction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\dkums\LifeEvaluation;
use app\models\dkums\TblMain;
use app\models\dkums\YearSettings;
use Yii;
use app\models\dkums\Questions;
use app\models\dkums\Results;
use app\models\dkums\Syukur;
use app\models\dkums\Users;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use app\models\myidp\Kehadiran;
use app\models\UtilitiesFunc;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class DkumsController extends \yii\web\Controller
{

    public $icno;

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
                        'actions' => ['index', 'intro', 'bhgn-a', 'bhgn-b', 'bhgn-c', 'bhgn-d', 'bhgn-e', 'komen', 'selesai', 'test', 'tutup'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['raw-data', 'senarai-tahun', 'create-tahun', 'update-tahun', 'delete-tahun', 'stat-by-dept', 'stat-dept', 'senarai-staff', 'indeks-individu', 'indeks-jafpib', 'sudah-isi', 'belum-isi', 'soalan-terbuka'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Users::isUserAdmin(Yii::$app->user->identity->ICNO);
                        }
                    ],
                    [
                        'actions' => ['stat-dept', 'sudah-isi', 'belum-isi'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Users::isUserPenetapPenilai(Yii::$app->user->identity->ICNO);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'remove-staff' => ['post'],
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

    public function beforeAction($action)
    {
        $this->icno = Yii::$app->user->getId();

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->view->title = "Rekod Darjah Kegembiraan Anda ";

        $year_settings = YearSettings::find()->where(['>=', 'tahun', 2018])->orderBy(['id' => SORT_DESC])->all();

        $papar_settings = YearSettings::findOne(['papar' => 1]);

        $status_isi = YearSettings::findOne(['status' => 1]);

        $purata = [];

        if ($papar_settings) {
            $purata = TblMain::purataAll($papar_settings->tahun, $papar_settings->fasa);
        }

        return $this->render('index', [
            'year_settings' => $year_settings,
            'papar_settings' => $papar_settings,
            'purata' => $purata,
            'icno' => $this->icno,
            'limit' => 5,
            'status_isi' => $status_isi,
        ]);
    }

    /**
     * Utk sementara redirect link
     */
    public function actionTemp()
    {
        header("Location: https://registrar.ums.edu.my/dkums/index.php?r=site/login");
        exit();
    }


    public function actionIntro()
    {
        $this->view->title = "Pengenalan / Introduction";

        $year_settings = YearSettings::find()->where(['status' => 1])->one();

        if (!$year_settings) {
            return $this->redirect(['tutup']);
        }

        $session = Yii::$app->session;

        $model = new TblMain();

        $check_main = TblMain::find()->where(['icno' => $this->icno, 'tahun' => $year_settings->tahun, 'fasa' => $year_settings->fasa])->one();

        if ($check_main) {

            if ($check_main->submit == 0) {
                $model = $check_main;
            } else {
                $session->set('dkums_main_id', $check_main->id);
                return $this->redirect(['selesai']);
            }
        }


        if ($model->load(Yii::$app->request->post())) {


            $model->icno = $this->icno;
            $model->gred_id = Yii::$app->user->identity->gredJawatan;
            $model->dept_id = Yii::$app->user->identity->DeptId;
            $model->statlantikan = Yii::$app->user->identity->statLantikan;
            $model->tahun = $year_settings->tahun;
            $model->fasa = $year_settings->fasa;
            $model->create_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                $session->set('dkums_main_id', $model->id);
                return $this->redirect(['bhgn-a']);
            }
        }

        return $this->render('user/intro', [
            'year_settings' => $year_settings,
            'icno' => $this->icno,
            'model' => $model,
            'dt' => date('Y-m-d H:i:s'),
        ]);
    }

    public function actionBhgnA()
    {
        $id = \Yii::$app->session->get('dkums_main_id');

        $questions = Questions::getProvider('a');

        $this->view->title = "Bahagian A : Penilaian Hidup / Life Evaluation ";

        if (!$id) {
            return $this->redirect(['index']);
        }

        $model = new LifeEvaluation();

        $check_model = LifeEvaluation::findOne(['main_id' => $id]);

        if ($check_model) {
            $model = $check_model;
        }


        if ($model->load(Yii::$app->request->post())) {

            $model->main_id = $id;

            if ($model->save()) {

                return $this->redirect(['bhgn-b']);
            }
        }

        return $this->render('user/bhgn-a', [
            'model' => $model,
            'model1' => $model,
            'questions' => $questions,
        ]);
    }

    public function actionBhgnB()
    {
        $id = \Yii::$app->session->get('dkums_main_id');
        $questions = Questions::getProvider('b');

        $this->view->title = "Bahagian B : Pengukuran Afek / Affect Measures";

        if (!$id) {
            return $this->redirect(['index']);
        }

        $model = new AffectMeasures();

        $check_model = AffectMeasures::findOne(['main_id' => $id]);

        if ($check_model) {
            $model = $check_model;
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->main_id = $id;

            if ($model->save()) {

                return $this->redirect(['bhgn-c']);
            }
        }

        return $this->render('user/bhgn-b', [
            'model' => $model,
            'model1' => $model,
            'questions' => $questions,
        ]);
    }

    public function actionBhgnC()
    {
        $id = \Yii::$app->session->get('dkums_main_id');
        $questions = Questions::getProvider('c');

        $this->view->title = "Bahagian C : Kepuasan Kerja / Job Satisfactions";

        if (!$id) {
            return $this->redirect(['index']);
        }

        $model = new JobSatisfaction();

        $check_model = JobSatisfaction::findOne(['main_id' => $id]);

        if ($check_model) {
            $model = $check_model;
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->main_id = $id;

            if ($model->save()) {

                return $this->redirect(['bhgn-d']);
            }
        }

        return $this->render('user/bhgn-c', [
            'model' => $model,
            'model1' => $model,
            'questions' => $questions,
        ]);
    }

    public function actionBhgnD()
    {
        $id = \Yii::$app->session->get('dkums_main_id');
        $questions = Questions::getProvider('d');

        $this->view->title = "Bahagian D. Keterlibatan Kerja / Job Engagement";

        if (!$id) {
            return $this->redirect(['index']);
        }

        $model = new JobEngagement();

        $check_model = JobEngagement::findOne(['main_id' => $id]);

        if ($check_model) {
            $model = $check_model;
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->main_id = $id;

            if ($model->save()) {

                return $this->redirect(['bhgn-e']);
            }
        }

        return $this->render('user/bhgn-d', [
            'model' => $model,
            'model1' => $model,
            'questions' => $questions,
        ]);
    }

    public function actionBhgnE()
    {
        $id = \Yii::$app->session->get('dkums_main_id');
        $questions = Questions::getProvider('e');

        $this->view->title = "Bahagian E. Rasa Syukur";

        if (!$id) {
            return $this->redirect(['index']);
        }

        $model = new Syukur();

        $check_model = Syukur::findOne(['main_id' => $id]);

        if ($check_model) {
            $model = $check_model;
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->main_id = $id;

            if ($model->save()) {

                return $this->redirect(['komen']);
            }
        }

        return $this->render('user/bhgn-e', [
            'model' => $model,
            'model1' => $model,
            'questions' => $questions,
        ]);
    }

    public function actionKomen()
    {
        $id = \Yii::$app->session->get('dkums_main_id');

        $this->view->title = "Tahniah! / Congratulations!";

        $model = TblMain::findOne($id);



        if ($model->load(Yii::$app->request->post())) {

            $model->submit = 1;
            $model->end_dt = date('Y-m-d H:i:s');

            if ($model->save()) {

                $results = new Results();
                $check_result = Results::findOne(['main_id' => $id]);

                if ($check_result) {
                    $results = $check_result;
                }

                $results->main_id = $id;
                $results->penilaian_hidup = $model->getPenilaianHidup();
                $results->emosi_positif = $model->getEmosiPositif();
                $results->kepuasan_kerja = $model->getKepuasanKerja();
                $results->keterlibatan_kerja = $model->getKeterlibatanKerja();
                $results->syukur = $model->getSyukur();
                $results->dkums = $model->getDkums();


                if ($results->save()) {

                    $yearSettings = YearSettings::find()->where(['tahun' => $model->tahun, 'fasa' => $model->fasa])->one();
                    $slotID = $yearSettings->slot_id;
                    Kehadiran::addKehadiran($slotID, $model->icno);
                    return $this->redirect(['selesai']);
                }
            }
        }

        return $this->render('user/komen', [
            'model' => $model
        ]);
    }

    public function actionSelesai()
    {
        $id = \Yii::$app->session->get('dkums_main_id');

        $model = TblMain::findOne($id);

        $this->view->title = "Keputusan / Result bagi tahun " . $model->tahun . "(Fasa " . $model->fasa . ")";

        return $this->render('user/selesai', [
            'model' => $model
        ]);
    }

    public function actionSenaraiTahun()
    {
        $this->view->title = "Senarai Tetapan Tahun/Fasa";

        $model = YearSettings::find()->orderBy(['id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('senarai-tahun', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateTahun()
    {

        $this->view->title = "Tambah Tahun/Fasa Baharu";
        $icno = Yii::$app->user->getId();

        $model = new YearSettings();

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            if ($model->status == 1) {

                $year = YearSettings::find()->where(['status' => 1])->one();
                $year->status = 0;
                $year->save();
            }

            if ($model->papar == 1) {

                $year = YearSettings::find()->where(['papar' => 1])->one();
                $year->papar = 0;
                $year->save();
            }

            $model->start_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                return $this->redirect(['senarai-tahun']);
            }
        }

        return $this->render('tahun-form', [
            'model' => $model,
        ]);
    }

    public function actionUpdateTahun($id)
    {

        $this->view->title = "Kemaskini Tahun/Fasa";


        $model = YearSettings::findOne($id);

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            if ($model->status == 1) {

                $year = YearSettings::find()->where(['status' => 1])->one();
                if ($year) {
                    $year->status = 0;
                    $year->save();
                }
            }

            if ($model->papar == 1) {

                $year = YearSettings::find()->where(['papar' => 1])->one();
                if ($year) {
                    $year->papar = 0;
                    $year->save();
                }
            }

            if ($model->save()) {
                return $this->redirect(['senarai-tahun']);
            }
        }

        return $this->render('tahun-form', [
            'model' => $model,
        ]);
    }

    public function actionDeleteTahun($id)
    {

        YearSettings::findOne($id)->delete();

        return $this->redirect(['senarai-tahun']);
    }


    public function actionRawData()
    {
        $this->view->title = "Raw Data";

        ini_set('memory_limit', '1024M'); // or you could use 1G

        $searchModel = new TblMain();
        $dataProvider = $searchModel->searchRaw(Yii::$app->request->queryParams);

        return $this->render('raw-data', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'action' => ['raw-data'],
        ]);
    }

    public function actionSenaraiStaff()
    {
        $this->view->title = "Senarai Staff";

        ini_set('memory_limit', '1024M'); // or you could use 1G

        $searchModel = new TblMain();
        $dataProvider = $searchModel->searchRaw(Yii::$app->request->queryParams);

        return $this->render('senarai-staff', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'action' => ['senarai-staff'],
        ]);
    }

    public function actionStatByDept($GetTahun = null, $GetFasa = null)
    {
        $fasaAktif = YearSettings::find()->where(['papar' => 1])->one();

        $tahun = $fasaAktif->tahun;
        $fasa = $fasaAktif->fasa;

        if ($GetTahun) {
            $tahun = $GetTahun;
        }

        if ($GetTahun) {
            $fasa = $GetFasa;
        }

        $this->view->title = "Statistik mengikut JAFPIB bagi tahun $tahun($fasa)";


        $department = Department::find()->select(['fullname', 'id'])->where(['isActive' => 1])->asArray()->all();

        return $this->render('stat-by-dept', [
            'department' => $department,
            'bil' => 1,
            'tahun' => $tahun,
            'fasa' => $fasa,
        ]);
    }

    /**
     * ni utk KJ dan KP JAFPIB
     */
    public function actionStatDept($GetTahun = null, $GetFasa = null)
    {
        $fasaAktif = YearSettings::find()->where(['papar' => 1])->one();

        $tahun = $fasaAktif->tahun;
        $fasa = $fasaAktif->fasa;

        $icno = Yii::$app->user->getId();

        if ($GetTahun) {
            $tahun = $GetTahun;
        }

        if ($GetTahun) {
            $fasa = $GetFasa;
        }

        $penetap = Users::isUserPenetapPenilai($icno);

        $department = Department::find()->select(['fullname', 'id'])->where(['isActive' => 1, 'id' => $penetap->penetap_jfpiu])->one();

        $this->view->title = "Statistik $department->fullname tahun $tahun fasa $fasa";

        $data = TblMain::PurataByDept($penetap->penetap_jfpiu, $tahun, $fasa);

        return $this->render('stat-dept', [
            'data' => $data,
            'bil' => 1,
            'tahun' => $tahun,
            'fasa' => $fasa,
            'department' => $department,
        ]);
    }

    public function actionSudahIsi($deptId, $tahun, $fasa)
    {
        $model = TblMain::find()->where(['dept_id' => $deptId, 'tahun' => $tahun, 'fasa' => $fasa, 'submit' => 1])->all();

        return $this->renderAjax('sudah-isi', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionSoalanTerbuka($deptId, $tahun, $fasa)
    {
        $model = TblMain::find()->where(['dept_id' => $deptId, 'tahun' => $tahun, 'fasa' => $fasa, 'submit' => 1])->all();

        return $this->renderAjax('soalan-terbuka', [
            'model' => $model,
            'bil' => 1,
        ]);
    }
    public function actionBelumIsi($deptId, $tahun, $fasa)
    {

        $main = TblMain::find()->select(['icno'])->where(['dept_id' => $deptId, 'tahun' => $tahun, 'fasa' => $fasa, 'submit' => 1])->all();

        $arr_main = [];

        foreach ($main as $m) {
            $arr_main[] = $m->icno;
        }

        $model = Tblprcobiodata::find()->joinWith(['jawatan b'])->where(['deptId' => $deptId, 'Status' => 1])->andFilterWhere(['NOT IN', 'ICNO', $arr_main])->andWhere(['!=', 'b.gred', 'DA41'])->all();

        return $this->renderAjax('belum-isi', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionTest()
    {
        $model = TblMain::PurataItemAll(2022, 1);

        return $this->render('test', [
            'model' => $model,
            'skala' => TblMain::PurataByDept2(12, 2022, 1),
        ]);
    }

    public function actionIndeksIndividu($id)
    {

        $this->view->title = "Indeks individu";

        $main = TblMain::findOne($id);

        $keterlibatan_kerja = JobEngagement::find()->where(['main_id' => $id])->one();
        $kepuasan_kerja = JobSatisfaction::find()->where(['main_id' => $id])->one();
        $affect = AffectMeasures::find()->where(['main_id' => $id])->one();
        $hidup = LifeEvaluation::find()->where(['main_id' => $id])->one();

        return $this->render('indeks-individu', [
            'main' => $main,
            'keterlibatan_kerja' => $keterlibatan_kerja,
            'kepuasan_kerja' => $kepuasan_kerja,
            'affect' => $affect,
            'hidup' => $hidup,
        ]);
    }

    public function actionIndeksJafpib($GetDeptId = null, $GetTahun = null, $GetFasa = null, $GetLantikan = null, $GetKategori = null)
    {
        $deptId = null;
        $tahun = date('Y');
        $fasa = 1;

        

        $kategori = null;
        $lantikan = null;

        if ($GetDeptId) {
            $deptId = $GetDeptId;
        }

        if ($GetTahun) {
            $tahun = $GetTahun;
        }

        if ($GetTahun) {
            $fasa = $GetFasa;
        }

        if ($GetKategori) {
            $kategori = $GetKategori;
        }

        if ($GetLantikan) {
            $lantikan = $GetLantikan;
        }

        $totalStaff = Tblprcobiodata::find()
            ->joinWith(['jawatan b'])
            ->where(['Status' => 1])
            ->andWhere(['!=', 'b.gred', 'DA41'])
            ->andFilterWhere(['deptId' => $deptId])
            ->andFilterWhere(['tblprcobiodata.statLantikan' => $lantikan])
            ->andFilterWhere(['b.job_group' => $kategori])
            ->count();


        $totalIsi = TblMain::find()->joinWith(['kakitangan', 'jawatan b'])
            ->where(['submit' => 1, 'fasa' => $fasa, 'tahun' => $tahun])
            ->andFilterWhere(['dept_id' => $deptId])
            ->andFilterWhere(['tblprcobiodata.statLantikan' => $lantikan])
            ->andFilterWhere(['b.job_group' => $kategori])
            ->count();

        $data = TblMain::PurataByDept($deptId, $tahun, $fasa, $lantikan, $kategori);

        $purata = TblMain::purataSkalaByDept($deptId, $tahun, $fasa, $lantikan, $kategori);

        return $this->render('indeks-jafpib', [
            'totalStaff' => $totalStaff,
            'totalIsi' => $totalIsi,
            'tahun' => $tahun,
            'fasa' => $fasa,
            'deptId' => $deptId,
            'data' => $data,
            'purata' => $purata,
            'lantikan' => $lantikan,
            'kategori' => $kategori,
            'main' => new TblMain(),
            'data_jafpib' => Department::find()->where(['isActive' => 1])->all(),
            'url' => ['indeks-jafpib'],
            'arrQuestion' => Questions::findQuestion(),
        ]);
    }

    public function actionIndeksJafpibKetua($GetTahun = null, $GetFasa = null, $GetLantikan = null, $GetKategori = null)
    {
       

        $icno = Yii::$app->user->getId();

        $penetap = Users::isUserPenetapPenilai($icno);

        $deptId = $penetap->penetap_jfpiu;
        $tahun = date('Y');
        $fasa = 1;

        $kategori = null;
        $lantikan = null;

        if ($GetTahun) {
            $tahun = $GetTahun;
        }

        if ($GetTahun) {
            $fasa = $GetFasa;
        }

        if ($GetKategori) {
            $kategori = $GetKategori;
        }

        if ($GetLantikan) {
            $lantikan = $GetLantikan;
        }

        $totalStaff = Tblprcobiodata::find()
            ->joinWith(['jawatan b'])
            ->where(['Status' => 1])
            ->andWhere(['!=', 'b.gred', 'DA41'])
            ->andFilterWhere(['deptId' => $deptId])
            ->andFilterWhere(['tblprcobiodata.statLantikan' => $lantikan])
            ->andFilterWhere(['b.job_group' => $kategori])
            ->count();


        $totalIsi = TblMain::find()->joinWith(['kakitangan', 'jawatan b'])
            ->where(['submit' => 1, 'fasa' => $fasa, 'tahun' => $tahun])
            ->andFilterWhere(['dept_id' => $deptId])
            ->andFilterWhere(['tblprcobiodata.statLantikan' => $lantikan])
            ->andFilterWhere(['b.job_group' => $kategori])
            ->count();

        $data = TblMain::PurataByDept($deptId, $tahun, $fasa, $lantikan, $kategori);

        $purata = TblMain::purataSkalaByDept($deptId, $tahun, $fasa, $lantikan, $kategori);

        return $this->render('indeks-jafpib', [
            'totalStaff' => $totalStaff,
            'totalIsi' => $totalIsi,
            'tahun' => $tahun,
            'fasa' => $fasa,
            'deptId' => $deptId,
            'data' => $data,
            'purata' => $purata,
            'lantikan' => $lantikan,
            'kategori' => $kategori,
            'data_jafpib' => Department::find()->where(['isActive' => 1, 'id'=>$deptId])->all(),
            'main' => new TblMain(),
            'url' => ['indeks-jafpib-ketua'],
            'arrQuestion' => Questions::findQuestion(),
        ]);
    }

    public function actionTutup()
    {
        return $this->render('tutup', []);
    }
}
