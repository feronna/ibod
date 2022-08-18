<?php

namespace app\controllers;

use app\models\ejobs\KlasifikasiJawatan;
use app\models\hronline\Adminposition;
use app\models\hronline\Department;
use app\models\hronline\GredJawatan;
use app\models\hronline\KlasifikasiPerkhidmatan;
use app\models\hronline\ProgramPengajaran;
use app\models\hronline\Tblrscoadminpost;
use app\models\talent\GredSettings;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class TalentController extends \yii\web\Controller
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
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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


    public function actionIndex($post_id = null)
    {
        $this->view->title = "Kriteria 1 : Pegawai Utama";

        $postId = 1;
        $holder_icno = null;

        if ($post_id != null) {
            $postId = $post_id;
        }

        $adminPost = GredSettings::getAdminPostByKriteria(1);

        $arrAdminPost = ArrayHelper::map($adminPost, 'id', 'position_name');

        $holder = Tblrscoadminpost::find()->where(['adminpos_id' => $postId, 'flag' => 1])->one();

        if ($holder) {
            $holder_icno = $holder->ICNO;
        }

        $gredList = GredSettings::find()->where(['adminpos_id' => $postId])->orderBy(['sort_no' => SORT_ASC])->all();

        return $this->render('index', [
            'arrAdminPost' => $arrAdminPost,
            'post_id' => $post_id,
            'holder' => $holder,
            'holder_icno' => $holder_icno,
            'gredList' => $gredList,
        ]);
    }

    public function actionKriteria2($post_id = null, $dept_id = null)
    {
        $this->view->title = "Kriteria 2 : Dekan / Pengarah / Timbalan";

        $postId = 3;
        $deptId = 136; //FKJ by default
        $holder_icno = null;

        if ($post_id != null) {
            $postId = $post_id;
        }
        if ($dept_id != null) {
            $deptId = $dept_id;
        }

        $adminPost = GredSettings::getAdminPostByKriteria(2);

        $arrAdminPost = ArrayHelper::map($adminPost, 'id', 'position_name');

        $department = Department::find()->where(['isActive' => 1])->all();
        $arrDept = ArrayHelper::map($department, 'id', 'fullname');

        $holder = Tblrscoadminpost::find()->where(['adminpos_id' => $postId, 'dept_id' => $deptId, 'flag' => 1])->one();

        if ($holder) {
            $holder_icno = $holder->ICNO;
        }

        $gredList = GredSettings::find()->where(['adminpos_id' => $postId])->orderBy(['sort_no' => SORT_ASC])->all();

        return $this->render('kriteria2', [
            'arrAdminPost' => $arrAdminPost,
            'arrDept' => $arrDept,
            'post_id' => $postId,
            'dept_id' => $deptId,
            'holder' => $holder,
            'holder_icno' => $holder_icno,
            'gredList' => $gredList,
        ]);
    }

    public function actionKriteria3($program_id = null)
    {
        $this->view->title = "Kriteria 3 : ketua Program";

        $programId = 1;
        $holder_icno = null;

        if ($program_id != null) {
            $programId = $program_id;
        }

        $adminPost = GredSettings::getAdminPostByKriteria(3);

        $program = ProgramPengajaran::find()->where([])->all();
        $arrProgram = ArrayHelper::map($program, 'id', 'NamaProgram');

        $holder = Tblrscoadminpost::find()->where(['adminpos_id' => 18, 'program_id' => $programId, 'flag' => 1])->one();

        if ($holder) {
            $holder_icno = $holder->ICNO;
        }

        $gredList = GredSettings::find()->where(['adminpos_id' => 18])->orderBy(['sort_no' => SORT_ASC])->all();

        return $this->render('kriteria3', [
            'holder' => $holder,
            'arrProgram' => $arrProgram,
            'program_id' => $programId,
            'holder_icno' => $holder_icno,
            'gredList' => $gredList,
        ]);
    }

    public function actionKriteria4($klasifikasi_id = null)
    {
        $this->view->title = "Kriteria 4 : Klasifikasi Perkhidmatan";

        if ($klasifikasi_id == null) {
            $klasifikasi_id = 1;
        }

        $model_klasifikasi = KlasifikasiPerkhidmatan::find()->select(["id AS id,concat(gred_skim, ' - ',nama) AS nama"])->where(['status' => 1])->all();
        $arrKlasifikasi = ArrayHelper::map($model_klasifikasi, 'id', 'nama');

        $gredList = GredJawatan::find()->where(['klasifikasi_id' => $klasifikasi_id])->orderBy(['gred_no' => SORT_DESC])->all();

        return $this->render('kriteria4', [
            'arrKlasifikasi' => $arrKlasifikasi,
            'gredList' => $gredList,
            'klasifikasi_id' => $klasifikasi_id,
        ]);
    }

    public function actionGredSetting($kriteria_id = null)
    {
        $this->view->title = "Senarai Kriteria";

        $kriteriaId = 1;

        if ($kriteria_id != null) {
            $kriteriaId = $kriteria_id;
        }

        return $this->render('gred-setting', [
            'kriteria_id' => $kriteriaId,
            'bil' => 1,
        ]);
    }

    public function actionListJwtn($id)
    {

        $this->view->title = "Jawatan mengikut Kriteria";

        $model = GredSettings::getAdminPostByKriteria($id);

        return $this->render('list-jwtn', [
            'kriteria_id' => $id,
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function updateJwtn($id)
    {
        $this->view->title = "Kemaskini";


    }

    public function actionListGred($id)
    {

        $this->view->title = "Gred mengikut Jawatan";

        $model = GredSettings::find()->where(['adminpos_id' => $id])->orderBy(['sort_no' => SORT_ASC])->all();

        return $this->render('list-gred', [
            'kriteria_id' => $id,
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionDeleteGred($id)
    {
        $model = GredSettings::findOne($id);

        if ($model) {
            $model->delete();

            return $this->redirect(['list-gred', 'id' => $model->adminpos_id]);
        }

        return false;
    }
}
