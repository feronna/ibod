<?php

namespace app\controllers;

use Yii;
use kartik\mpdf\Pdf;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Notification;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use app\models\aduan\RptTblAccess;
use yii\web\NotFoundHttpException;
use app\models\hronline\Department;
use app\models\aduan\RptTblSiasatan;
use app\models\e_perkhidmatan\Event;
use app\models\hronline\GredJawatan;
use app\models\e_perkhidmatan\RefApp;
use app\models\e_perkhidmatan\TblApp;
use kartik\grid\EditableColumnAction;
use app\models\hronline\TblPenempatan;
use app\models\aduan\RptTblAduanSearch;
use app\models\e_perkhidmatan\TblEvent;
use app\models\hronline\Tblprcobiodata;
use app\models\myidp\SiriLatihanSearch;
use app\models\hronline\Kumpulankhidmat;
use tebazil\runner\ConsoleCommandRunner;
use app\models\hronline\Tblrscosandangan;
use app\models\aduan\RptTblSiasatanSearch;
use app\models\e_perkhidmatan\EventSearch;
use app\models\e_perkhidmatan\RefAppSearch;
use app\models\e_perkhidmatan\TblAppSearch;
use app\models\e_perkhidmatan\TblEventSearch;
use app\models\hronline\TblprcobiodataSearch;
use app\models\keselamatan\TblStaffKeselamatan;
use app\models\e_perkhidmatan\PermitApplication;
use app\models\e_perkhidmatan\PermitApplicationSearch;

class EPerkhidmatanController extends \yii\web\Controller
{
    public $current_user;
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
        ];
    }

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
        $this->current_user = Yii::$app->user->getId();

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $modelBio = Tblprcobiodata::find()->where(['ICNO' => $this->current_user])->one();

        $model = new Event();

        if ($model->load(Yii::$app->request->post())) {

            $model->event_date_applied = date('Y-m-d H:i:s');
            $model->event_pemohon_id = $this->current_user;
            $model->dept_id = $modelBio->DeptId;
            // $model->event_time_start =  date("H:i", strtotime($model->event_time_start));
            // $model->event_time_end =  date("H:i", strtotime($model->event_time_end));

            if ($model->banner_status == NULL){
                $model->banner_status = '0';
            }
            if ($model->countdown_status == NULL){
                $model->countdown_status = '0';
            }
            if ($model->papan_tanda_status == NULL){
                $model->papan_tanda_status = '0';
            }
            if ($model->parkir_status == NULL){
                $model->parkir_status = '0';
            }
            if ($model->kawalan_status == NULL){
                $model->kawalan_status = '0';
            }
            

            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan anda telah berjaya dihantar.']);

                $modelPeg = RptTblAccess::find()->where(['access_type' => 'urusetia'])->all();

                if ($modelPeg) {

                    foreach ($modelPeg as $s) {

                        $this->notifikasi($s->staff_icno, "Permohonan baru dari " . strtoupper($modelBio->displayGelaran . ' ' . $modelBio->CONm) . " menunggu tindakan anda " . Html::a('KLIK SINI <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>', ['e-perkhidmatan/view-list-admin'], ['class' => 'btn btn-sm btn-success btn-block']));
                    }
                }

                return $this->redirect([
                    'view',
                    'id' => $model->event_id
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelBio' => $modelBio,
            'id' => null
        ]);
    }

    public function actionViewList()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['event_pemohon_id' => $this->current_user]);

        return $this->render('view_list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [ //render(pageTitle.php)
            'model' => $this->findModel($id),
            'modelBio' => Tblprcobiodata::find()->where(['ICNO' => $this->current_user])->one(),
        ]);
    }

    public function actionPermohonanList()
    {
        if (isset($_POST['expandRowKey'])) {
            $model = Event::find()->where(['event_id' => $_POST['expandRowKey']]);
            $dataProvider = new ActiveDataProvider([
                'query' => $model,
                'pagination' => [
                    //'pageSize' => 20,
                    'pageSize' => 5,
                ],
                'sort' => false,
            ]);
            return $this->renderPartial('list_permohonan', ['dataProvider' => $dataProvider, 'model' => $model]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }



    public function actionIndexOld()
    {
        $staff_id = Yii::$app->user->getId();

        //var_dump($staff_id);

        $model = new TblEvent();
        $searchModel = new TblEventSearch();
        // $query = TblEvent::find()
        //             ->joinWith('application')
        //             ->where(['staff_id' => $staff_id])
        //             ->orderBy(['entry_date' => SORT_DESC]);

        $query = PermitApplication::find()
            ->joinWith('event')
            ->where(['staff_id' => $staff_id])
            ->orderBy(['entry_date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $model->entry_date = date('Y-m-d H:i:s');
        $model->staff_id = $staff_id;
        $modelBio = Tblprcobiodata::findOne(['ICNO' => $staff_id]);
        $model->dept_id = $modelBio->DeptId;
        // $peg_tadbir = TblAccess::findOne(['admin_post' => 1]);
        // $peg_bsm = TblAccess::findOne(['admin_post' => 2]);
        // $file = UploadedFile::getInstance($model, 'file');
        // $file2 = UploadedFile::getInstance($model, 'file2');

        if ($model->load(Yii::$app->request->post())) {

            // $ntf = new Notification();
            // $ntf2 = new Notification();
            // if ($model->save(false)) {

            //     $ntf->staff_id = $peg_tadbir->staff_id; // peg  penyelia perjawatan
            //     $ntf->title = 'Permohonan Kemudahan Atas Talian';
            //     $ntf->content = "Permohonan Elaun Pakaian Panas menunggu tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senaraitindakan'], ['class' => 'btn btn-primary btn-sm']);
            //     $ntf->ntf_dt = date('Y-m-d H:i:s');
            //     $ntf->save();


            //     $ntf2->staff_id = $peg_bsm->staff_id; // peg perjawatan
            //     $ntf2->title = 'Permohonan Kemudahan Atas Talian';
            //     $ntf2->content = "Permohonan Elaun Pakaian Panas menunggu tindakan perakuan anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senaraitindakan'], ['class' => 'btn btn-primary btn-sm']);
            //     $ntf2->ntf_dt = date('Y-m-d H:i:s');
            //     $ntf2->save();
            // }
            // $this->pendingtask($peg_tadbir->staff_id, 24);
            // $this->pendingtask($peg_bsm->staff_id, 25);
            // $this->notification($model->staff_id, 'Permohonan anda telah dihantar untuk diproses sila semak status permohonan anda.' . Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class' => 'btn btn-primary btn-sm']));
            // Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
            // return $this->redirect(['borang/senarai']);

            if ($model->save(false)) {

                $modelAppType = RefApp::find()->all();

                foreach ($modelAppType as $s) {

                    $modelPermit = new PermitApplication();
                    $modelPermit->event_id = $model->event_id;
                    $modelPermit->app_type = $s->id;
                    $modelPermit->save(false);
                }
            }
        }
        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'bil' => 1,

        ]);
    }

    public function actionSenaraiPermohonan($id)
    {
        $staff_id = Yii::$app->user->getId();
        $currentYear = date('Y');

        $appModel = PermitApplication::find()
            ->joinWith('event')
            ->where("staff_id = '$staff_id' and SUBSTRING(date_applied,1,4) = $currentYear and app_type = '5'")
            ->orderBy('date_applied');

        $dataProvider = new ActiveDataProvider([
            'query' => $appModel,
        ]);

        return $this->render('list', [
            'appModel' => $appModel,
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($event_id)
    {
        if (($model = Event::findOne($event_id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan anda telah berjaya dihapuskan.']);
        }

        // $model = $this->findModel($id);
        // $model->active_status = '11';
        // $model->cancelled_date = date('Y-m-d');
        // if ($model->save(false)) {
        //     Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Aduan anda telah berjaya dibatalkan.']);
        // }

        return $this->redirect(['view-list']);
        //return $this->redirect(Yii::$app->request->referrer);
    }

    protected function notifikasi($icno, $content)
    {
        //--------Model Notification-----------//
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $icno;
        $ntf->title = 'E-Perkhidmatan BKUMS';
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save(false);
        //--------Model Notification-----------//
    }
}
