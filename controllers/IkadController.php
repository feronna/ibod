<?php

namespace app\controllers;

use app\models\hronline\Department;
use app\models\hronline\Gelaran;
use app\models\hronline\Tblprcobiodata;
use app\models\ikad\Log;
use app\models\ikad\TblAccess;
use app\models\ikad\TblAccessSearch;
use Yii;
use app\models\Ikad\TblMohon;
use app\models\Ikad\TblMohonSearch;
use app\models\Notification;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use tebazil\runner\ConsoleCommandRunner;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * IkadController implements the CRUD actions for TblMohon model.
 */
class IkadController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['main-index', 'admin-index', 'statistic', 'approval-index', 'add', 'approval', 'admin-preview', 'update-admin', 'admin-update-app', 'update-status', 'admin-index', 'delete'],
                'rules' => [
                    [
                        // 'actions' => ['main-index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $boleh = false;
                            if (TblAccess::find()->where(['ICNO' => $logicno])->exists()) {

                                $boleh = true;
                            }

                            return $boleh;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [],
            ],
        ];
    }


    /**
     * Lists all TblMohon models.
     * @return mixed
     */
    public function actionIndex()
    {
        $icno = Yii::$app->user->getId();
        $query = TblMohon::find()->where(['applier_id' => $icno])->all();

        // $DataProvider = new ActiveDataProvider([
        //     'query' => $query,
        //     'pagination' => [
        //         'pageSize' => 100,
        //     ],
        // ]);
        return $this->render('index', [
            'query' => $query,
            'bil' => 1,

            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
        ]);
    }


    public function actionMainIndex()
    {
        $searchModel = new TblMohonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('main-index', [
            // 'query' => $query,
            // 'bil' => 1,

            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
        ]);
    }

    public function actionApprovalIndex()
    {
        $searchModel = new TblMohonSearch();
        $dataProvider = $searchModel->searchs(Yii::$app->request->queryParams);
        return $this->render('approval-index', [
            // 'query' => $query,
            // 'bil' => 1,

            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
        ]);
    }
    public function actionStatistic()
    {
        $searchModel = new TblMohonSearch();
        $dataProvider = $searchModel->statistic(Yii::$app->request->queryParams);
        return $this->render('statistic', [
            // 'query' => $query,
            // 'bil' => 1,

            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
        ]);
    }
    //approve or not pegawai peraku
    public function actionApproval($id)
    {
        $icno = Yii::$app->user->getId();

        $model = TblMohon::findOne(['id' => $id]);

        $data = ['8' => 'Approve', '6' => 'Reject'];


        if ($model->load(Yii::$app->request->post())) {

            if ($model->status_kad == '8') {
                $model->app_status == "APPROVED";
            } else {
                $model->app_status == "REJECTED";
            }
            $model->approved_by = $icno;
            $model->approved_dt = date('Y-m-d h:i:s');
            if ($model->save()) {
                //hantar notifikasi juga ah sma task to do
                $this->log($id,$model->app_status);
                // $this->send($icno, $model->start_date, $model->end_date);
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['ikad/approval-index']);
            }
        }
        return $this->renderAjax('approval', [
            'model' => $model,
            'data' => $data
        ]);
    }
    /**
     * Displays a single TblMohon model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TblMohon model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TblMohon();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->d_mohon_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblMohon model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionSend($id)
    {
        // var_dump($id);die;
        $model1 = TblMohon::find()->where(['id' => $id])->all();
        $ikad = TblAccess::find()->where(['accesstype' => 0, 'isActive' => 1])->one();
        $ikad1 = TblAccess::find()->where(['accesstype' => 1, 'isActive' => 1])->one();        // if ($model1->load(Yii::$app->request->post())) {
        foreach ($model1 as $var) {
            $model = TblMohon::findOne(['id' => $var->id]);

            $model->hantar_status = 1;
            $model->checked_by = $ikad->ICNO;
            $model->approved_by = $ikad1->ICNO;
            $model->d_tarikh_hantar = date('Y-m-d H:i:s');
            $model->status_kad = 1;

            $model->update();
            // }
            $this->log($id,'New Application');
            // $this->Notification($model->ganti_by, 'Cuti', 'Permohonan Cuti Rehat Dalam Negara Oleh '."$bio->CONm".' Pada '.$dt1.' Hingga '.$dt2.' Menunggu Persetujuan Anda');
            $this->Notification($ikad->ICNO, 'iKad', 'Permohonan iKad ' . "$model->d_nama" . ' Menunggu Semakan Anda . Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/ikad/main-index">disini</a> untuk membuat tindakan');
            // $this->send($icno, $model->start_date, $model->end_date);
            $runner = new ConsoleCommandRunner();
            $runner->run('dashboard/pending-task-individu', [$ikad->ICNO]);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Dihantar']);
            return $this->redirect(['ikad/index']);
        }
        // return $this->renderAjax('verifying', [
        //     'model' => $model,
        //     'model1' => $model1,
        //     'bil' => 1,
        // ]);
    }
    public function actionPreview($id)
    {
        $icno = Yii::$app->user->getId();

        $model = TblMohon::find()->where(['id' => $id])->andWhere(['applier_id' => $icno])->one();
        // var_dump($model->applier_id);die;
        if (!$model) {
            // echo 'd';die;
            Yii::$app->session->setFlash('alert', [
                'title' => 'Warning', 'type' => 'warning',
                'msg' => 'Action Denied'
            ]);
            return $this->redirect(['index']);
        }

        return $this->render('preview', [
            'model' => $model,
        ]);
    }
    public function actionAdminPreview($id)
    {
        $icno = Yii::$app->user->getId();

        $model = TblMohon::find()->where(['id' => $id])->one();
        // var_dump($model->applier_id);die;
        if (!$model) {
            // echo 'd';die;
            Yii::$app->session->setFlash('alert', [
                'title' => 'Warning', 'type' => 'warning',
                'msg' => 'Action Denied'
            ]);
            return $this->redirect(['main-index']);
        }

        return $this->render('admin-preview', [
            'model' => $model,
        ]);
    }
    public function actionSendApplication($id)
    {
        $icno = Yii::$app->user->getId();

        $model = TblMohon::find()->where(['id' => $id])->andWhere(['=', 'applier_id', $icno])->one();
        $ikad = TblAccess::find()->where(['accesstype' => 0, 'isActive' => 1])->one();
        $ikad1 = TblAccess::find()->where(['accesstype' => 1, 'isActive' => 1])->one();
        if (!$model) {
            // echo 'd';die;
            Yii::$app->session->setFlash('alert', [
                'title' => 'Warning', 'type' => 'warning',
                'msg' => 'Action Denied'
            ]);
            return $this->redirect(['index']);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->checked_by = $ikad->ICNO;
            $model->approved_by = $ikad1->ICNO;
            if ($model->save()) {
                $this->log($id,'New Application');
                // $this->Notification($model->ganti_by, 'Cuti', 'Permohonan Cuti Rehat Dalam Negara Oleh '."$bio->CONm".' Pada '.$dt1.' Hingga '.$dt2.' Menunggu Persetujuan Anda');
                $this->Notification($ikad->ICNO, 'iKad', 'Permohonan iKad ' . "$model->d_nama" . ' Menunggu Semakan Anda . Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/ikad/main-index">disini</a> untuk membuat tindakan');
                // $this->send($icno, $model->start_date, $model->end_date);
                $runner = new ConsoleCommandRunner();
                $runner->run('dashboard/pending-task-individu', [$ikad->ICNO]);
                return $this->redirect(['index']);
            }
        }
        return $this->render('send-application', [
            'model' => $model,
        ]);
    }
    /**
     * Deletes an existing TblMohon model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblMohon model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblMohon the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblMohon::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    //pilih card language
    public function actionPilih()
    {
        $icno = Yii::$app->user->getId();
        //0=Baru,1=Proses,2=Siap,3=Selesai/Telah Diambil
        // $model = TblMohon::find()->where(['applier_id' => $icno])->andWhere(['YEAR(d_tarikh_mohon)' => date('Y')])->andWhere(['<', 'status_kad', '6'])->exists();
        // if ($model) {
        //     Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'info', 'msg' => 'Harap Maaf, Anda telah membuat permohonan ']);
        //     return $this->redirect(['ikad/index']);
        // } else {
            $model = new TblMohon();
        // }
        if ($model->load(Yii::$app->request->post())) {

            if ($model->language_id == 0) {
                return $this->redirect(['apply', 'id' => $model->language_id]);
            } elseif ($model->language_id == 1) {
                return $this->redirect(['form1', 'id' => $model->language_id]);
            } else {
                return $this->redirect(['form2', 'id' => $model->language_id]);
            }
        }

        return $this->render('pilih', [
            'model' => $model,
            'bil' => 1,


        ]);
    }
    public function actionApply($id)
    {
        $icno = Yii::$app->user->getId();

        $model = TblMohon::find()->where(['applier_id' => $icno])->andWhere(['YEAR(d_tarikh_mohon)' => date('Y')])->andWhere(['<', 'status_kad', '6'])->exists();
        if ($model) {
            Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'info', 'msg' => 'Harap Maaf, Anda telah membuat permohonan ']);
            return $this->redirect(['ikad/index']);
        } else {
            $model = new TblMohon();
        }
        $nama = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $title = Gelaran::find()->where(['TitleCd' => $nama->TitleCd])->one();
        $dept = Department::findOne(['id'=> $nama->DeptId]);
        $name = $nama->CONm;


        if ($model->load(Yii::$app->request->post())) {
            $model->applier_id = $icno;
            $model->gred_jawatan = $nama->gredJawatan;
            $model->d_tarikh_mohon = date('Y-m-d H:i:s');
            $model->status_kad = 3;
            $model->language_id = $id;
            // echo $model->name;die;
            if ($model->save()) {
               
                return $this->redirect(['send-application', 'id' => $model->id]);
            }
        }

        return $this->render('apply1', [
            'model' => $model,
            'name' => $name,
            'id' => $id,
            'title' => $title->Title,
            'dept' => $dept->fullname
        ]);
    }
    //english
    public function actionForm1($id)
    {
        $icno = Yii::$app->user->getId();

        $model = TblMohon::find()->where(['applier_id' => $icno])->andWhere(['YEAR(d_tarikh_mohon)' => date('Y')])->andWhere(['<', 'status_kad', '6'])->exists();
        if ($model) {
            Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'info', 'msg' => 'Harap Maaf, Anda telah membuat permohonan ']);
            return $this->redirect(['ikad/index']);
        } else {
            $model = new TblMohon();
        }
        $nama = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $title = Gelaran::find()->where(['TitleCd' => $nama->TitleCd])->one();
        $dept = Department::findOne(['id'=> $nama->DeptId]);
        $name = $nama->CONm;


        if ($model->load(Yii::$app->request->post())) {
            $model->applier_id = $icno;
            $model->gred_jawatan = $nama->gredJawatan;
            $model->d_tarikh_mohon = date('Y-m-d H:i:s');
            $model->status_kad = 3;
            $model->language_id = $id;
            // echo $model->name;die;
            if ($model->save()) {

                return $this->redirect(['send-application', 'id' => $model->id]);
            }
        }

        return $this->render('form1', [
            'model' => $model,
            'name' => $name,
            'id' => $id,
            'title' => $title->Title,
            'dept' => $dept->fullname
        ]);
    }
    //malay
    public function actionForm2($id)
    {
        $icno = Yii::$app->user->getId();

        $model = TblMohon::find()->where(['applier_id' => $icno])->andWhere(['YEAR(d_tarikh_mohon)' => date('Y')])->andWhere(['<', 'status_kad', '6'])->exists();
        if ($model) {
            Yii::$app->session->setFlash('alert', ['title' => 'Info', 'type' => 'info', 'msg' => 'Harap Maaf, Anda telah membuat permohonan ']);
            return $this->redirect(['ikad/index']);
        } else {
            $model = new TblMohon();
        }
        $nama = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $title = Gelaran::find()->where(['TitleCd' => $nama->TitleCd])->one();
        $dept = Department::findOne(['id'=> $nama->DeptId]);
        $name = $nama->CONm;


        if ($model->load(Yii::$app->request->post())) {
            $model->applier_id = $icno;
            $model->gred_jawatan = $nama->gredJawatan;
            $model->d_tarikh_mohon = date('Y-m-d H:i:s');
            $model->status_kad = 3;
            $model->language_id = $id;
            // echo $model->name;die;
            if ($model->save()) {

                return $this->redirect(['send-application', 'id' => $model->id]);
            }
        }

        return $this->render('form2', [
            'model' => $model,
            'name' => $name,
            'id' => $id,
            'title' => $title->Title,
            'dept' => $dept->fullname
        ]);
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->d_mohon_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionUpdateApp($id)
    {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // return $this->redirect(['view', 'id' => $model->d_mohon_id]);
            if ($model->save()) {

                return $this->redirect(['index']);
            }
        }

        return $this->render('update-app', [
            'model' => $model,
        ]);
    }
    public function actionAdminUpdateApp($id)
    {
        $icno = Yii::$app->user->getId();

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // return $this->redirect(['view', 'id' => $model->d_mohon_id]);
            // $model->status_kad = "5";

            if ($model->save(false)) {
                $this->log($id,'Admin Edit');

                return $this->redirect(['admin-preview', 'id' => $id]);
            }
        }

        return $this->render('admin-update-app', [
            'model' => $model,
            'id' => $model->language_id,
        ]);
    }
    public function actionUpdateStatus($id)
    {
        $icno = Yii::$app->user->getId();

        $model = TblMohon::findOne(['id' => $id]);
        if ($model->status_kad == "8") {
            $data = ['2' => 'Ready To Take', '5' => 'Send To Vendor?', '4' => 'Completed (Delivered To Applicant)'];
        } elseif ($model->status_kad == "6") {
            $data = ['6' => 'Rejected'];
        } else {
            $data = ['7' => 'Checked', '6' => 'Rejected'];
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->checked_by = $icno;
            $model->checked_dt = date('Y-m-d h:i:s');
            if ($model->save()) {
                //hantar notifikasi juga ah sma task to do
                $this->log($id,$model->app_status);
                if($model->status_kad == "7"){
                    $this->Notification($model->approved_by, 'iKad', 'Permohonan iKad ' . "$model->d_nama" . ' Menunggu Perakuan Anda . Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/ikad/approval-index">disini</a> untuk membuat tindakan');
                    $runner = new ConsoleCommandRunner();
                    $runner->run('dashboard/pending-task-individu', [$model->approved_by]);
                }
                if($model->status_kad == "2"){
                    $this->Notification($model->ICNO, 'iKad', 'Business Card ' . "$model->d_nama" . ' is ready to take');
                  
                }
            
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['ikad/main-index']);
            }
        }
        return $this->renderAjax('update-status', [
            'model' => $model,
            'data' => $data
        ]);
    }



    //this part is for add or remove admin access

    public function actionAdminIndex()
    {
        $searchModel = new TblAccessSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('admin-index', [

            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
        ]);
    }

    public function actionAdd()
    {

        $model = new TblAccess();
        if ($model->load(Yii::$app->request->post())) {

            // $model->added_by = date('Y-m-d H:i:s');

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['ikad/admin-index']);
            }
        }
        return $this->renderAjax('add-access', ['model' => $model]);
    }
    public function actionUpdateAdmin($id)
    {

        $model = TblAccess::findOne(['id' => $id]);
        if ($model->load(Yii::$app->request->post())) {

            // $model->added_by = date('Y-m-d H:i:s');

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Record Updated !']);
                return $this->redirect(['ikad/admin-index']);
            }
        }
        return $this->renderAjax('update-admin', ['model' => $model]);
    }


    //log
    public static function log($id, $action)
    {
        $icno = Yii::$app->user->getId();
        $log = new Log();

        $log->icno = $icno;
        $log->mohon_id = $id;
        $log->action = $action;
        $log->datetime = date('Y-m-d h:i:s');
    }
    //notifikasi
    public function Notification($icno, $title, $content)
    {
        $ntf = new Notification();
        $ntf->icno = $icno;
        $ntf->title = $title;
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
    }
}
