<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\dass\RefPenilaianDass21;
use app\models\dass\TblPenilaianDass21;
use app\models\dass\TblPenilaianDass21Search;
use app\models\dass\Tblprcobiodata;
use app\models\dass\TblDassBiodataSearch;
use app\models\dass\TblUserAccess;
use app\models\Notification;
use chrmorandi\jasper\Jasper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii\web\HttpException;
use yii2tech\spreadsheet\Spreadsheet;

class Dass21Controller extends \yii\web\Controller
{

    //    public function init() {
    //        $this->layout = 'main_dass21';
    //        
    //        Yii::$app->errorHandler->errorAction = 'dass21/error';
    //    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['assessment', 'dashboard', 'result', 'view-assessment', 'penetapan-akses', 'akses', 'carian-borang', 'index', 'generate-report'],
                'rules' => [
                    [
                        'actions' => ['assessment'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblPenilaianDass21::find()->where('YEARWEEK(created_dt) = YEARWEEK(NOW())')->andWhere(['icno' => Yii::$app->user->identity->ICNO])->count();
                            $tmp = TblUserAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->one();
                            //return ($query < 2 || (!is_null($tmp))) ? true : false;
                            if ($query < 2 || (!is_null($tmp))) {
                                return true;
                            } else {
                                throw new HttpException(403, "You have reached your limit for answering questions for today.");
                            }
                        }
                    ],
                    [
                        'actions' => ['dashboard', 'view-assessment', 'penetapan-akses', 'akses', 'carian-borang', 'generate-report', 'delete-file'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $tmp = TblUserAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->one();
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [
                        'actions' => ['result'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $tmp = TblUserAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->one();
                            return (TblPenilaianDass21::isOwner(Yii::$app->request->get('id'), Yii::$app->user->identity->ICNO) || (!is_null($tmp)));
                        }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    //    public function actions() {
    //        return [
    //            'error' => [
    //                'class' => 'yii\web\ErrorAction',
    //            ],
    //        ];
    //    }

    public function actionIndex()
    {
        $borang = TblPenilaianDass21::find()->where(['icno' => Yii::$app->user->getId()])->orderBy(['tahun' => SORT_DESC, 'created_dt' => SORT_DESC]);

        $provider = new ActiveDataProvider([
            'query' => $borang,
            'pagination' => [
                'pageSize' => 10,
            ],
            /*'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'title' => SORT_ASC, 
                ]
            ],*/
        ]);

        return $this->render('index', ['dataProvider' => $provider, 'rubric' => new RefPenilaianDass21()]);
    }

    public function actionAssessment()
    {
        $model = new TblPenilaianDass21();

        $bio = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);

        $query = RefPenilaianDass21::find()->orderBy(['id' => SORT_ASC]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        if ($model->load((Yii::$app->request->post()))) {

            $sum_s = 0;
            $sum_a = 0;
            $sum_d = 0;
            $arry = RefPenilaianDass21::find()->asArray()->all();

            //$model = new TblPenilaianDass21();
            $model->icno = $bio->ICNO;
            $model->gred_id = $bio->gredJawatan;
            $model->dept_id = $bio->DeptId;
            $model->statlantikan = $bio->statLantikan;
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');

            foreach ($arry as $index => $a) {
                $qid = 'q' . ($index + 1);
                //$model->$qid = $id;

                switch ($a['code']) {
                    case 's':
                        $sum_s = $sum_s + $model->$qid;
                        break;
                    case 'a':
                        $sum_a = $sum_a + $model->$qid;
                        break;
                    case 'd':
                        $sum_d = $sum_d + $model->$qid;
                        break;
                }
            }

            $model->skor_s = $sum_s;
            $model->skor_a = $sum_a;
            $model->skor_d = $sum_d;

            $model->save(false);
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya dihantar!']);
            return $this->redirect(['result', 'id' => $model->id]);
        }

        return $this->render('borang', ['dataProvider' => $provider, 'model1' => $model]);
    }

    public function actionViewAssessment($id)
    {
        $model = $this->findModel($id);

        //$bio = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);

        $rubric = new RefPenilaianDass21();

        $result = $this->findModel($id);

        foreach (array_reverse($rubric->depression_scale) as $key) {
            if ($result->skor_d >= $key['score']) {
                $d_msg = $key['status'];
                break;
            }
        }

        foreach (array_reverse($rubric->anxiety_scale) as $key) {
            if ($result->skor_a >= $key['score']) {
                $a_msg = $key['status'];
                break;
            }
        }

        foreach (array_reverse($rubric->stress_scale) as $key) {
            if ($result->skor_s >= $key['score']) {
                $s_msg = $key['status'];
                break;
            }
        }

        $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);

        $query = RefPenilaianDass21::find()->orderBy(['id' => SORT_ASC]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $this->render('view_borang', [
            'dataProvider' => $provider, 'model1' => $model, 'bio' => $bio, 'd_msg' => $d_msg, 'a_msg' => $a_msg, 's_msg' => $s_msg, 'result' => $result
        ]);
    }

    public function actionGenerateAssessment($id)
    {

        $model = $this->findModel($id);

        //$bio = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);

        $rubric = new RefPenilaianDass21();

        $result = $this->findModel($id);

        foreach (array_reverse($rubric->depression_scale) as $key) {
            if ($result->skor_d >= $key['score']) {
                $d_msg = $key['status'];
                break;
            }
        }

        foreach (array_reverse($rubric->anxiety_scale) as $key) {
            if ($result->skor_a >= $key['score']) {
                $a_msg = $key['status'];
                break;
            }
        }

        foreach (array_reverse($rubric->stress_scale) as $key) {
            if ($result->skor_s >= $key['score']) {
                $s_msg = $key['status'];
                break;
            }
        }

        $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);

        $query = RefPenilaianDass21::find()->orderBy(['id' => SORT_ASC]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'filename' => $bio->CONm . '_DASS21_' . $id,
            'mode' => Pdf::MODE_ASIAN, // leaner size using standard fonts
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('_borang', [
                'dataProvider' => $provider, 'model1' => $model, 'bio' => $bio, 'd_msg' => $d_msg, 'a_msg' => $a_msg, 's_msg' => $s_msg, 'result' => $result
            ]),
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => [
                // any mpdf options you wish to set
            ],
            /*'methods' => [
                'SetTitle' => 'Privacy Policy - Krajee.com',
                'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                'SetHeader' => ['Krajee Privacy Policy||Generated On: ' . date("r")],
                'SetFooter' => ['|Page {PAGENO}|'],
                'SetAuthor' => 'Kartik Visweswaran',
                'SetCreator' => 'Kartik Visweswaran',
                'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
            ]*/
        ]);
        return $pdf->render();
    }

    public function actionResult($id)
    {

        $result = $this->findModel($id);
        $bio = Tblprcobiodata::findOne(['ICNO' => $result->icno]);
        $rubric = new RefPenilaianDass21();

        foreach (array_reverse($rubric->depression_scale) as $key) {
            if ($result->skor_d >= $key['score']) {
                $d_msg = $key['status'];
                break;
            }
        }

        foreach (array_reverse($rubric->anxiety_scale) as $key) {
            if ($result->skor_a >= $key['score']) {
                $a_msg = $key['status'];
                break;
            }
        }

        foreach (array_reverse($rubric->stress_scale) as $key) {
            if ($result->skor_s >= $key['score']) {
                $s_msg = $key['status'];
                break;
            }
        }

        return $this->render('result', [
            'bio' => $bio, 'result' => $result,
            'd_msg' => $d_msg, 'a_msg' => $a_msg, 's_msg' => $s_msg
        ]);
    }

    public function actionDashboard()
    {

        $array = TblPenilaianDass21::find()->select([new Expression('COUNT(*) as jml'), 'created_dt as nama'])->where(['>=', 'created_dt', new Expression('(DATE(NOW()) - INTERVAL (WEEKDAY(DATE(NOW()))) DAY)')])
            ->andWhere(['<=', 'created_dt', new Expression('(DATE(NOW() + INTERVAL (6 - WEEKDAY(NOW())) DAY))')])->groupBy(new Expression('CAST(`created_dt` as DATE)'))->asArray()->all();

        $male = TblPenilaianDass21::find()->joinWith('biodata', false, 'LEFT JOIN')->where(['hronline.tblprcobiodata.GenderCd' => 'L'])->count();

        $female = TblPenilaianDass21::find()->joinWith('biodata', false, 'LEFT JOIN')->where(['hronline.tblprcobiodata.GenderCd' => 'P'])->count();

        return $this->render('dashboard', ['model' => $array, 'male' => $male, 'female' => $female]);
    }

    public function actionPenetapanAkses()
    {
        $searchModel = new TblDassBiodataSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('akses_tetap', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAkses($ICNO)
    {
        //$id = Yii::$app->user->getId(); 
        $bio = Tblprcobiodata::findOne(['ICNO' => $ICNO]);

        if (TblUserAccess::findOne(['icno' => $ICNO]) != null) {
            $model = TblUserAccess::findOne(['icno' => $ICNO]);
        } else {
            $model = new TblUserAccess();
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $ICNO;
            if ($model->access == 0) {
                $model->delete();
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Akses berjaya disimpan!']);
                return $this->redirect('penetapan-akses');
            } else {
                $model->save();
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Akses berjaya disimpan!']);
                return $this->redirect('penetapan-akses');
            }
            //$model->akses_oleh = $id;
        }

        return $this->renderAjax('kemaskini_akses', ['bio' => $bio, 'model' => $model]);
    }

    public function  actionCarianBorang()
    {
        $searchModel = new TblPenilaianDass21Search();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $listDls = new ActiveDataProvider([
            'query' => \app\models\system_core\TblDocuments::find()->where(['module' => Yii::$app->controller->id, 'deleted_by' => null])->orderBy(['created_dt' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $this->render('cari_borang', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'rubric' => new RefPenilaianDass21(),
            'listDownloads' => $listDls,
            'uapi' => new \app\components\UAPI,
        ]);
    }

    public function actionDeleteFile($filehash)
    {
        $file = Yii::$app->FileManager->DeleteFile($filehash);
        if ($file->status == true) {
            $model = \app\models\system_core\TblDocuments::find()->where(['filehash' => $filehash])->one();
            $model->deleted_by =  Yii::$app->user->identity->ICNO;
            $model->deleted_dt = new \yii\db\Expression('NOW()');
            $model->save(false);

            \Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Laporan berjaya dibuang!']);
            return $this->redirect(Yii::$app->request->referrer);
        }

        \Yii::$app->session->setFlash('warning', ['title' => 'Error', 'type' => 'error', 'msg' => 'File not found!']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = TblPenilaianDass21::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelUserAccess($id)
    {
        if (($model = TblUserAccess::find(['icno' => $id])) !== null) {
            return $model;
        } else {
            return $model = new TblUserAccess();
        }

        //throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGenerateReport()
    {
        $parts = parse_url(Yii::$app->request->referrer);

        parse_str($parts['query'], $params);

        $searchModel = new TblPenilaianDass21Search();

        $dataProvider = $searchModel->search($params);

        $q = $dataProvider->query->createCommand()->getRawSql();

        $tbl_query = new \app\models\system_core\TblQueries();
        $tbl_query->query = $q;
        $tbl_query->module = Yii::$app->controller->id;
        $tbl_query->created_by = Yii::$app->user->identity->ICNO;
        $tbl_query->created_dt = new \yii\db\Expression('NOW()');
        $tbl_query->save(false);

        $runner = new \tebazil\runner\ConsoleCommandRunner();
        $runner->run('task-queue/jana-report-dass', [$tbl_query->query, Yii::$app->user->identity->ICNO]);

        \Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'warning', 'msg' => 'Laporan sedang dijana. Sila tunggu']);
        return $this->redirect(Yii::$app->request->referrer);
    }
}
