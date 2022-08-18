<?php

namespace app\controllers\survey;

use app\models\hronline\Department;
use app\models\hronline\ProgramPengajaran;
use app\models\hronline\TblprcobiodataSearch;
use app\models\survey\TblAktiviti;
use app\models\survey\TblCalon;
use app\models\survey\TblPengundi;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblrscoadminpost;
use app\models\survey\TblAkses;
use yii\helpers\ArrayHelper;

class UrusetiaController extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return TblAkses::isUserAdmin(Yii::$app->user->identity->ICNO);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-activity' => ['post'],
                    'delete-akses' => ['post'],
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


    public function actionSenaraiAktiviti()
    {
        $this->view->title = "Senarai Aktiviti";

        $model = TblAktiviti::find()->all();

        return $this->render('senarai-aktiviti', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionPerincianAktiviti($id)
    {
        $this->view->title = "Perincian Aktiviti";

        $model = TblAktiviti::findOne($id);

        return $this->render('perincian-aktiviti', [
            'aktiviti' => $model,
        ]);
    }

    public function actionCreateAktivitiTamat($id)
    {
        $this->view->title = "Tambah Aktiviti Baharu";
        $icno = Yii::$app->user->getId();

        $model = new TblAktiviti();

        $adminpos = Tblrscoadminpost::findOne($id);

        $model->adminpos_id = $adminpos->adminpos_id;
        $model->dept_id = $adminpos->dept_id;
        $model->nama = $adminpos->description;
        $model->catatan = $adminpos->description;
        $model->program_id = ($adminpos->program) ? $adminpos->program->id : null;

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->create_dt = date('Y-m-d H:i:s');
            $model->create_by = $icno;
            $model->tamat_id = $id;

            if ($model->save()) {
                return $this->redirect(['senarai-calon', 'id' => $model->id]);
            }
        }

        return $this->render('create-aktiviti', [
            'model' => $model,
            'position' => $model->adminPos,
            'department' => $model->department,
            'program' => $model->program,
        ]);
    }

    public function actionCreateAktiviti()
    {
        $this->view->title = "Tambah Aktiviti Baharu";
        $icno = Yii::$app->user->getId();

        $model = new TblAktiviti();


        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->create_dt = date('Y-m-d H:i:s');
            $model->create_by = $icno;

            if ($model->save()) {
                return $this->redirect(['senarai-calon', 'id' => $model->id]);
            }
        }

        return $this->render('create-aktiviti', [
            'model' => $model,
            'position' => $model->adminPos,
            'department' => $model->department,
            'program' => $model->program,
        ]);
    }

    public function actionUpdateAktiviti($id)
    {
        $this->view->title = "Kemaskini Aktiviti";
        $icno = Yii::$app->user->getId();

        $model = TblAktiviti::findOne($id);

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->update_dt = date('Y-m-d H:i:s');
            $model->update_by = $icno;

            if ($model->save()) {
                return $this->redirect(['senarai-calon', 'id' => $model->id]);
            }
        }

        return $this->render('create-aktiviti', [
            'model' => $model,
            'position' => $model->adminPos,
            'department' => $model->department,
            'program' => $model->program,
        ]);
    }

    public function actionSenaraiCalon($id, $dept_id = null, $name = null, $phd = null, $gred = null, $tempoh = null, $program = null, $tetap = null)
    {
        $this->view->title = "Senarai Calon";

        $aktiviti = TblAktiviti::findOne($id);

        if ($program = '') {
            $program = $aktiviti->program_id;
        }

        if (!$dept_id) {
            $dept_id = $aktiviti->dept_id;
        }

        $senarai_calon = TblCalon::find()->where(['aktiviti_id' => $id])->all();

        $department = ArrayHelper::map(Department::find()->where(['isActive' => 1])->all(), 'id', 'fullname');
        $programPengajaran = ArrayHelper::map(ProgramPengajaran::find()->where([])->all(), 'id', 'NamaProgram');

        $array_calon = [];

        foreach ($senarai_calon as $r) {
            $array_calon[] = $r->icno;
        }

        $kakitangan = TblCalon::filterSenaraiNama($dept_id, $array_calon, $name, $phd, $gred, $tempoh, $program, $tetap);

        $model = new TblCalon();

        if ($post = Yii::$app->request->post()) {


            //buang Calon
            if (isset($post['TblCalon']['id'])) {

                $bulk_id = $post['TblCalon']['id'];

                foreach ($bulk_id as $k => $v) {
                    if ($v != 0) {
                        $mdl = TblCalon::findOne(['id' => $v]);
                        $mdl->delete();
                    }
                }
            }

            //masukkan calon
            if (isset($post['Tblprcobiodata']['ICNO'])) {

                $bulk_icno = $post['Tblprcobiodata']['ICNO'];

                foreach ($bulk_icno as $k => $v) {
                    if ($v != '0') {
                        $model = new TblCalon();
                        $model->aktiviti_id = $id;
                        $model->icno = $v;
                        $model->create_dt = date('Y-m-d H:i:s');
                        $model->save(false);
                    }
                }
            }

            return $this->redirect(['senarai-calon', 'id' => $id]);
        }

        return $this->render('senarai-calon', [
            'aktiviti' => $aktiviti,
            'senarai_calon' => $senarai_calon,
            'kakitangan' => $kakitangan,
            'department' => $department,
            'programPengajaran' => $programPengajaran,
            'program' => $program,
            'dept_id' => $dept_id,
            'model' => $model,
            'name' => $name,
            'tetap' => $tetap,
            'phd' => $phd,
            'gred' => $gred,
            'tempoh' => $tempoh,
            'bil' => 1,
            'bil_calon' => 1,
            'id' => $id,
        ]);
    }


    public function actionSenaraiPengundi($id, $dept_id = null, $name = null, $phd = null, $gred = null, $tempoh = null, $program = null, $tetap = null)
    {
        $this->view->title = "Senarai Pengundi";

        $aktiviti = TblAktiviti::findOne($id);

        if ($program = '') {
            $program = $aktiviti->program_id;
        }

        if (!$dept_id) {
            $dept_id = $aktiviti->dept_id;
        }

        $senarai_calon = TblPengundi::find()->where(['aktiviti_id' => $id])->all();

        $department = ArrayHelper::map(Department::find()->where(['isActive' => 1])->all(), 'id', 'fullname');
        $programPengajaran = ArrayHelper::map(ProgramPengajaran::find()->where([])->all(), 'id', 'NamaProgram');

        $array_calon = [];

        foreach ($senarai_calon as $r) {
            $array_calon[] = $r->icno;
        }

        $kakitangan = TblPengundi::filterSenaraiNama($dept_id, $array_calon, $name, $phd, $gred, $tempoh, $program, $tetap);

        $model = new TblPengundi();

        if ($post = Yii::$app->request->post()) {


            //buang Calon
            if (isset($post['TblPengundi']['id'])) {

                $bulk_id = $post['TblPengundi']['id'];

                foreach ($bulk_id as $k => $v) {
                    if ($v != 0) {
                        $mdl = TblPengundi::findOne(['id' => $v]);
                        $mdl->delete();
                    }
                }
            }

            //masukkan calon
            if (isset($post['Tblprcobiodata']['ICNO'])) {

                $bulk_icno = $post['Tblprcobiodata']['ICNO'];

                foreach ($bulk_icno as $k => $v) {
                    if ($v != '0') {
                        $model = new TblPengundi();
                        $model->aktiviti_id = $id;
                        $model->icno = $v;
                        $model->create_dt = date('Y-m-d H:i:s');
                        $model->save(false);
                    }
                }
            }

            return $this->redirect(['senarai-pengundi', 'id' => $id]);
        }

        return $this->render('senarai-pengundi', [
            'aktiviti' => $aktiviti,
            'senarai_calon' => $senarai_calon,
            'kakitangan' => $kakitangan,
            'department' => $department,
            'programPengajaran' => $programPengajaran,
            'program' => $program,
            'dept_id' => $dept_id,
            'model' => $model,
            'name' => $name,
            'tetap' => $tetap,
            'phd' => $phd,
            'gred' => $gred,
            'tempoh' => $tempoh,
            'bil' => 1,
            'bil_calon' => 1,
            'id' => $id,
        ]);
    }


    public function actionOverview($id)
    {
        $this->view->title = "Maklumat Aktiviti";

        $aktiviti = TblAktiviti::findOne($id);
        $calon = TblCalon::findAll(['aktiviti_id' => $id]);
        $pengundi = TblPengundi::findAll(['aktiviti_id' => $id]);

        return $this->render('overview', [
            'aktiviti' => $aktiviti,
            'calon' => $calon,
            'pengundi' => $pengundi,
            'bil' => 1,
            'id' => $id,
        ]);
    }

    public function actionResult($id)
    {
        $this->view->title = "Keputusan";

        $aktiviti = TblAktiviti::findOne($id);
        $calon = TblCalon::findAll(['aktiviti_id' => $id]);

        return $this->render('result', [
            'aktiviti' => $aktiviti,
            'calon' => $calon,
            'bil' => 1,
        ]);
    }

    public function actionStatusPengundi($id)
    {
        $this->view->title = "Status Pengundi";

        $aktiviti = TblAktiviti::findOne($id);


        $pengundi = TblPengundi::find()->where(['aktiviti_id' => $id])->orderBy(['vote_status' => SORT_DESC])->all();

        $completed = TblPengundi::find()->where(['aktiviti_id' => $id, 'vote_status' => 1])->count();
        $total = count($pengundi);

        return $this->render('status-pengundi', [
            'aktiviti' => $aktiviti,
            'pengundi' => $pengundi,
            'total' => $total,
            'completed' => $completed,
            'bil' => 1,
        ]);
    }

    public function actionAdminPostListTamat($icno = null, $adminpos_id = null, $program_id = null, $dept_id = null, $campus_id = null)
    {

        $this->view->title = "Perlantikan 3 Bulan yang akan tamat";

        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => [1, 2]])->andWhere('end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 92 DAY)');

        $dataProvider = new ActiveDataProvider([

            'query' => $model,

            'pagination' => [

                'pageSize' => 100,

            ],
        ]);

        $dataProvider->query->orderBy([
            'end_date' => SORT_ASC,
            'adminpos_id' => SORT_DESC,
        ]);

        if (isset(Yii::$app->request->queryParams['icno'])) {
            $icno ? $dataProvider->query->andFilterWhere(['icno' => $icno]) : '';
        }

        if (isset(Yii::$app->request->queryParams['adminpos_id'])) {
            $adminpos_id ? $dataProvider->query->andFilterWhere(['adminpos_id' => $adminpos_id]) : '';
        }

        if (isset(Yii::$app->request->queryParams['program_id'])) {
            $program_id ? $dataProvider->query->andFilterWhere(['program_id' => $program_id]) : '';
        }

        if (isset(Yii::$app->request->queryParams['dept_id'])) {
            $dept_id ? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]) : '';
        }

        if (isset(Yii::$app->request->queryParams['campus_id'])) {
            $campus_id ? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]) : '';
        }

        return $this->render('admin-post-list-tamat', [
            'dataProvider' => $dataProvider,
            'icno' => $icno,
            'adminpos_id' => $adminpos_id,
            'program_id' => $program_id,
            'dept_id' => $dept_id,
            'campus_id' => $campus_id,
        ]);
    }


    public function actionStatistik()
    {
        $this->view->title = "Statistik Keseluruhan Aktiviti";

        $model = TblAktiviti::find()->all();

        return $this->render('statistik', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionKeputusan()
    {
        $this->view->title = "Keputusan Keseluruhan Aktiviti";

        $model = TblAktiviti::find()->all();

        return $this->render('keputusan', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionSenaraiAkses($icno = null, $dept_id = null, $akses = null)
    {

        $this->view->title = "Senarai Akses";

        $model = TblAkses::find()->joinWith('kakitangan.department');

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);


        if (isset(Yii::$app->request->queryParams['icno'])) {
            $icno ? $dataProvider->query->andFilterWhere(['survey_tbl_akses.icno' => $icno]) : '';
        }
        if (isset(Yii::$app->request->queryParams['dept_id'])) {
            $dept_id ? $dataProvider->query->andFilterWhere(['department.id' => $dept_id]) : '';
        }
        if (isset(Yii::$app->request->queryParams['akses'])) {
            $akses ? $dataProvider->query->andFilterWhere(['survey_tbl_akses.akses' => $akses]) : '';
        }

        return $this->render('senarai-akses', [
            'dataProvider' => $dataProvider,
            'icno' => $icno,
            'dept_id' => $dept_id,
            'akses' => $akses,
        ]);
    }

    public function actionCreateAkses()
    {

        $this->view->title = "Tambah Akses Baharu";
        $icno = Yii::$app->user->getId();

        $model = new TblAkses();

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->create_dt = date('Y-m-d H:i:s');
            $model->create_by = $icno;

            if ($model->save()) {
                return $this->redirect(['senarai-akses']);
            }
        }

        return $this->render('akses-form', [
            'model' => $model,
        ]);
    }

    public function actionUpdateAkses($id)
    {

        $this->view->title = "Tambah Akses Baharu";
        $icno = Yii::$app->user->getId();

        $model = TblAkses::findOne($id);

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->update_dt = date('Y-m-d H:i:s');
            $model->update_by = $icno;

            if ($model->save()) {
                return $this->redirect(['senarai-akses']);
            }
        }

        return $this->render('akses-form', [
            'model' => $model,
        ]);
    }

    public function actionDeleteAkses($id)
    {

        TblAkses::findOne($id)->delete();

        return $this->redirect(['senarai-akses']);
    }


    public function actionDeleteAktiviti($id)
    {

        $this->findModel($id)->delete();

        return $this->redirect(['senarai-aktiviti']);
    }

    /**
     * Finds the TblRekod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblRekod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblAktiviti::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionRawData()
    {
        $this->view->title = "Data Mentah";

        ini_set('memory_limit', '1024M'); // or you could use 1G

        $searchModel = new TblprcobiodataSearch();
        $dataProvider = $searchModel->searchRaw(Yii::$app->request->queryParams);

        return $this->render('raw-data', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
