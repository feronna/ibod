<?php

namespace app\controllers;

use Yii;
use app\models\klinikpanel\Tblvisit;
use app\models\klinikpanel\Tblmaxtuntutan;
use app\models\klinikpanel\Tblbknpanel;
use app\models\klinikpanel\TblTopupHis;
use app\models\klinikpanel\TblTopupHisSearch;
use app\models\klinikpanel\Tblmedicine;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use app\models\system_core\TblUserAccess;
use yii\filters\AccessControl;
use app\models\Notification;
use yii\helpers\Html;
use app\models\Pergigian\TblAccess;
use app\models\klinikpanel\Tblmohon;
use app\models\klinikpanel\RefKlinikpanel;
use app\models\klinikpanel\RefKlinikpanelSearch;
use app\models\klinikpanel\Tblenquiry;
use app\models\klinikpanel\Tblbatchclaim;
use app\models\klinikpanel\TblbatchclaimSearch;
use app\models\klinikpanel\TblMedcare;
use app\models\cuti\SetPegawai;
use app\models\hronline\Tblkeluarga;
use app\models\Pergigian\Pegawai;
use app\models\klinikpanel\TblmohonSearch;
use app\models\klinikpanel\TblmaxtuntutanSearch;
use app\models\klinikpanel\TblMedcareSearch;
use app\models\klinikpanel\TblLog;
use app\models\hronline\Department;
use kartik\mpdf\Pdf;
use yii\web\NotFoundHttpException;

/**
 * KlinikpanelController implements the CRUD actions for Tblvisit model.
 */
class KlinikpanelController extends Controller
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
            [
                'class' => AccessControl::className(),
                'only' => ['add-staff', 'carian', 'rekod-lawatan', 'tuntutan-klinik', 'bukan-panel', 'enquiry', 'selenggaraklinik', 'rekod-medcare'],
                'rules' => [
                    //superadmin
                    [
                        'actions' => ['add-staff', 'carian', 'rekod-lawatan', 'tuntutan-klinik', 'bukan-panel', 'enquiry', 'selenggaraklinik', 'rekod-medcare'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $admins = TblUserAccess::findOne(['icno' => $logicno]);
                            $klinik = TblAccess::findOne(['icno' => $logicno]);
                            if ($admins) {
                                $check = TblUserAccess::find()->where(['icno' => $logicno])->andWhere(['access' => 1]);
                            }

                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }
                            if ($klinik) {
                                $boleh = true;
                            }
                            return $boleh === true;
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionRawData()
    {
        $searchModel = new TblmaxtuntutanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $query = new ActiveDataProvider([
            'query' => $dataProvider,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('raw-data', [
            'bil' => 1,
            'searchModel' => $searchModel,
            // 'searchName' => $searchName,
            // 'dataProvider' => $dataProvider,
            'query' => $query,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRekodLawatan()
    {
        $year = date('Y');
        $searchModel = new \app\models\klinikpanel\TblvisitSearch();
        $searchName = ArrayHelper::map(Tblvisit::find()->select('pesakit_name')->distinct()->orderBy(['pesakit_name' => SORT_ASC])->all(), 'pesakit_name', 'pesakit_name');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = new ActiveDataProvider([
            'query' => $dataProvider,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('rekod-lawatan', [
            'bil' => 1,
            'searchModel' => $searchModel,
            'searchName' => $searchName,
            'dataProvider' => $dataProvider,
            'query' => $query,
            'year' => $year,
        ]);
    }

    public function actionRekodMedcare()
    {
        $searchModel = new TblMedcareSearch();
        $query = TblMedcare::find()->orderBy(['visit_dt' => SORT_DESC]);

        $querys = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        if (Yii::$app->request->queryParams) {
            $querys = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('rekod-medcare', [

            'query' => $querys,
            'bil' => 1,
            'searchModel' => $searchModel,
        ]);
    }



    /**
     * Lists all Tblvisit models.
     * @return mixed
     */
    //add staff
    public function actionAddStaff()
    {
        $admin = Tblmaxtuntutan::find()->all(); //cari senarai admin
        $newstaff = new Tblmaxtuntutan(); //untuk admin baru
        if ($newstaff->load(Yii::$app->request->post())) {
            if (Tblmaxtuntutan::find()->where(['max_icno' => $newstaff->max_icno])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Kakitangan Sudah Ditambah!']);
            } elseif ($newstaff->kakitangan->CONm != NULL) { //tiada icno dalam db
                $newstaff->current_balance = $newstaff->max_tuntutan;
                $newstaff->topup_max = '0.00';
                $newstaff->tuntutan_bukan_panel = '0.00';
                $newstaff->jum_tuntutan = '0.00';
                $newstaff->last_updater = 'sysadmin';
                $newstaff->last_update = date('Y-m-d H:i:s');
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                $newstaff->save();
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
            }

            return $this->redirect(['add-staff']);
        }
        if (Tblmaxtuntutan::find()->where(['max_icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('add-staff', [
                'admin' => $admin,
                'newstaff' => $newstaff,
                'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
    }

    public function actionTuntutanKlinik()
    {

        //  $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $allStaff = Tblbatchclaim::find()->where(['batch_process_id' => 1])->orderBy(['batch_date_issued' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $allStaff,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $searchModel = new TblbatchclaimSearch();
        if (Yii::$app->request->queryParams) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('tuntutan-klinik', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionBukanPanel()
    {
        $icno = Yii::$app->user->getId();
        $model = new Tblbknpanel();
        $ntf = new Notification();

        $query = Tblbknpanel::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['insert_dt' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $searchModel = new \app\models\klinikpanel\TblbknpanelSearch();
        if (Yii::$app->request->queryParams) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        if ($model->load(Yii::$app->request->post())) {
            $v = Tblmaxtuntutan::find()->where(['max_icno' => $model->icno])->one();
            $oldv = $v->tuntutan_bukan_panel;
            $v->current_balance = $v->current_balance - $model->tuntutan;
            $v->tuntutan_bukan_panel = $oldv + $model->tuntutan;
            $model->nama_klinik = strtoupper($model->nama_klinik);
            $model->insert_by = $icno;
            $model->insert_dt = date('Y-m-d H:i:s');

            $v->save();
            if ($model->save()) {
                //save notification
                $ntf->icno = $model->icno; // kakitangan
                $ntf->title = 'Klinik Panel (MyHealth UMS)';
                $ntf->content = "Tuntutan Rawatan Klinik Bukan Panel anda telah direkodkan. Sila semak baki terkini anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['klinikpanel/index'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tuntutan berjaya disimpan.']);
            return $this->redirect(['klinikpanel/updateb', 'id' => $model->id]);
        }

        return $this->render('bukan-panel', [
            'bil' => 1,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'model' => $model,
        ]);
    }

    // public function actionTuntutBukanpanel()
    // {
    //     $icno = Yii::$app->user->getId();
    //     $model = new Tblbknpanel();
    //     $ntf = new Notification();

    //     if ($model->load(Yii::$app->request->post())) {
    //         $v = Tblmaxtuntutan::find()->where(['max_icno' => $model->icno])->one();
    //         $oldv = $v->tuntutan_bukan_panel;
    //         $v->current_balance = $v->current_balance - $model->tuntutan;
    //         $v->tuntutan_bukan_panel = $oldv + $model->tuntutan;
    //         $model->nama_klinik = strtoupper($model->nama_klinik);
    //         $model->insert_by = $icno;
    //         $model->insert_dt = date('Y-m-d H:i:s');

    //         $v->save();
    //         if ($model->save()) {
    //             //save notification
    //             $ntf->icno = $model->icno; // kakitangan
    //             $ntf->title = 'Klinik Panel (MyHealth UMS)';
    //             $ntf->content = "Tuntutan Rawatan Klinik Bukan Panel anda telah direkodkan. Sila semak baki terkini anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['klinikpanel/index'], ['class' => 'btn btn-primary btn-sm']);
    //             $ntf->ntf_dt = date('Y-m-d H:i:s');
    //             $ntf->save();
    //         }
    //         Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tuntutan berjaya disimpan.']);
    //         return $this->redirect(['klinikpanel/updateb', 'id' => $model->id]);
    //     }
    //     return $this->render('tuntut-bukanpanel', [
    //         'model' => $model,
    //     ]);
    // }
    

    public function actionViews($batch_id)
    {
        $query = Tblvisit::find()->where(['tblvisit_batch_id' => $batch_id])->orderBy(['rawatan_date' => SORT_ASC]);

        $querys = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('views', [
            'query' => $querys,
            'bil' => 1,
        ]);
    }

    public function actionUpdateStatus($batch_id)
    {
        $icno = Yii::$app->user->getId();
        $model = Tblbatchclaim::findOne(['batch_id' => $batch_id]);

        if ($model->load(Yii::$app->request->post())) {
            $model->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Status semakan tuntutan  berjaya dikemaskini.']);
            return $this->redirect(['klinikpanel/tuntutan-klinik']);
        }

        return $this->render('update-status', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionViewLawatan($rawatan_id)
    {
        $query = Tblvisit::find()->where(['rawatan_id' => $rawatan_id]);
        $jumlah = 0;
        $namaubat = Tblmedicine::find()->where(['med_visit_id' => $rawatan_id])->all();
        $model = Tblvisit::find()->where(['rawatan_id' => $rawatan_id])->one();

        foreach ($namaubat as $data) {
            $jumlah = $jumlah + $data->tblmed_price;
        }

        $querys = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('view-lawatan', [
            'query' => $querys,
            'bil' => 1,
            'namaubat' => $namaubat,
            'jumlah' => $jumlah,
            'model' => $model,
        ]);
    }

    public function actionInvois($batch_id)
    {
        //        $css = file_get_contents('./css/kelulusan.css');
        #cehck application
        //            $model = $this->findModel($batch_id);
        //            $user = Yii::$app->user->getId();  
        $invois = Tblvisit::find()->where(['tblvisit_batch_id' => $batch_id])->orderby(['rawatan_date' => SORT_ASC])->all();
        $invois2 = Tblvisit::find()->where(['tblvisit_batch_id' => $batch_id])->orderby(['rawatan_date' => SORT_ASC])->one();
        $klinik = RefKlinikpanel::find()->where(['klinik_id' => $invois2->visit_klinik_id])->one();
        $sum = Tblbatchclaim::find()->where(['batch_id' => $batch_id])->one();

        $content = $this->renderPartial('invois', ['invois' => $invois, 'sum' => $sum, 'klinik' => $klinik, 'invois2' => $invois2]);
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
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Invois MyHealth'],
            // call mPDF methods on the fly
            'marginTop' => 35,
            //             'marginBottom' => 35,
            'marginLeft' => 24,
            'marginRight' => 24,
            'methods' => [
                'SetHeader' => ['INVOIS MyHealth UMS'],
                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                //                'WriteHTML' => [$css, 1]
                //          'SetFooter' => [' {PAGENO}'],
            ]
        ]);
        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionSelenggaraklinik()
    {
        $icno = Yii::$app->user->getId();
        $klinik = new RefKlinikpanel();
        $query = RefKlinikpanel::find()->where(['isActive' => 1])->orWhere(['isUms' => 1])->orderBy(['nama' => SORT_ASC])->all();
        $searchModel = new \app\models\klinikpanel\RefKlinikpanelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($klinik->load(Yii::$app->request->post())) {
            $klinik->isActive = 1;
            $klinik->created_by = $icno;
            $klinik->tarikhproses = date('Y-m-d H:i:s');
            $klinik->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Status semakan  berjaya dikemaskini.']);
            return $this->redirect(['klinikpanel/selenggaraklinik']);
        }

        return $this->render('selenggaraklinik', [
            'bil' => 1,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'query' => $query,
            'klinik' => $klinik,
        ]);
    }

    public function actionUpdate($id)
    {

        $icno = Yii::$app->user->getId();
        $model = Tblbknpanel::findOne(['id' => $id]);

        //simpan rekod lama
        $record_owner = $model->icno;
        $id = $model->id;
        $rawatan = $model->rawatan;
        $klinik = $model->nama_klinik;
        $tuntutan_date = $model->tuntutan_date;
        $receipt = $model->no_resit;
        $jum_tuntutan = $model->tuntutan;

        if ($model->load(Yii::$app->request->post())) {
            $model->save();

            $log = new TblLog();
            $log->rawatan_id = $id;
            $log->rawatan_dt = $tuntutan_date;
            $log->icno = $record_owner;
            $log->tindakan = 'KEMASKINI REKOD LAWATAN BUKAN PANEL';
            $log->visit_klinik_id = $klinik;
            $log->amount = $jum_tuntutan;
            $log->log_remark = $receipt;
            $log->log_dt = date('Y-m-d H:i:s');
            $log->log_by = $icno;
            $log->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tuntutan  berjaya dikemaskini.']);
            return $this->redirect(['klinikpanel/bukan-panel']);
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionViewStaff($id)
    {

        $icno = Yii::$app->user->getId();
        $model = Tblbknpanel::findOne(['id' => $id]);

        return $this->render('view-staff', [
            'model' => $model,
        ]);
    }
    public function actionUpdateb($id)
    {

        $icno = Yii::$app->user->getId();
        $model = Tblbknpanel::findOne(['id' => $id]);

        //simpan rekod lama
        $record_owner = $model->icno;
        $id = $model->id;
        $klinik = $model->nama_klinik;
        $tuntutan_date = $model->tuntutan_date;
        $receipt = $model->no_resit;
        $jum_tuntutan = $model->tuntutan;


        $log = new TblLog();
        $log->rawatan_id = $id;
        $log->rawatan_dt = $tuntutan_date;
        $log->icno = $record_owner;
        $log->tindakan = 'TAMBAH REKOD LAWATAN BUKAN PANEL';
        $log->visit_klinik_id = $klinik;
        $log->amount = $jum_tuntutan;
        $log->log_remark = $receipt;
        $log->log_dt = date('Y-m-d H:i:s');
        $log->log_by = $icno;
        $log->save(false);

        return $this->render('updateb', [
            'model' => $model,
            'log' => $log,
        ]);
    }

    public function actionUpdater($id)
    {
        $icno = Yii::$app->user->getId();
        $jumlah = 0;
        $namaubat = Tblmedicine::find()->where(['med_visit_id' => $id])->all();
        $model = Tblvisit::find()->where(['rawatan_id' => $id])->one();
        foreach ($namaubat as $data) {
            $jumlah = $jumlah + $data->tblmed_price;
        }

        //save dulu yg lama
        $rawatan_id = $model->rawatan_id;
        $rawatan_dt = $model->rawatan_date;
        $record_owner = $model->visit_icno;
        $klinik = $model->visit_klinik_id;
        $tuntutan = $model->jum_tuntutan;

        if ($model->load(Yii::$app->request->post())) {
            $model->save();

            $log = new TblLog();
            $log->rawatan_id = $rawatan_id;
            $log->rawatan_dt = $rawatan_dt;
            $log->icno = $record_owner;
            $log->tindakan = 'PADAM REKOD LAWATAN';
            $log->visit_klinik_id = $klinik;
            $log->amount = $tuntutan;
            $log->log_dt = date('Y-m-d H:i:s');
            $log->log_by = $icno;
            $log->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod lawatan klinik berjaya dikemaskini.']);
            return $this->redirect(['klinikpanel/view-adminr', 'id' => $id]);
        }

        return $this->render('updater', [
            'model' => $model,
            'namaubat' => $namaubat,
            'jumlah' => $jumlah,
        ]);
    }

    public function actionUpdatek($id)
    {
        $icno = Yii::$app->user->getId();
        $klinik = RefKlinikpanel::findOne(['klinik_id' => $id]);
        $searchModel = new \app\models\klinikpanel\RefKlinikpanelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        if ($klinik->load(Yii::$app->request->post())) {

            $klinik->updateoleh = $icno;
            $klinik->tarikhupdate = date('Y-m-d H:i:s');
            $klinik->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat klinik  berjaya dikemaskini.']);
            return $this->redirect(['klinikpanel/selenggaraklinik']);
        }


        return $this->render('updatek', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //                    'query' => $query,
            'klinik' => $klinik,
        ]);
    }
    public function actionUpdateRaw($id)
    {
        // $icno = Yii::$app->user->getId();
        $query = Tblmaxtuntutan::findOne(['max_icno' => $id]);
        $searchModel = new TblmaxtuntutanSearch();
        $model = $searchModel->search(Yii::$app->request->queryParams);


        if ($query->load(Yii::$app->request->post())) {

            $query->last_updater = 'SYSADMIN';
            // $klinik->tarikhupdate = date('Y-m-d H:i:s');
            $query->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Kemaskini Berjaya.']);
            return $this->redirect(['klinikpanel/raw-data']);
        }


        return $this->render('update-raw', [
            'searchModel' => $searchModel,
            'model' => $model,
            //                    'query' => $query,
            'query' => $query,
        ]);
    }

    public function actionDeleter($id)
    {

        $model = RefKlinikpanel::findOne(['klinik_id' => $id]);
        $model->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        return $this->redirect(['selenggaraklinik']);
    }

    public function actionDeleteb($id)
    {

        $model = Tblbknpanel::findOne(['id' => $id]);
        $model->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        $staff = Tblmaxtuntutan::findOne($model->icno);
        $balance = $staff->current_balance + $model->tuntutan;
        $bknpanel = $staff->tuntutan_bukan_panel;
        $staff->current_balance = $balance;
        $staff->tuntutan_bukan_panel = $bknpanel - $model->tuntutan;
        $staff->save(false);

        return $this->redirect(['bukan-panel']);
    }

    public function actionCarian()
    {

        $staff = $this->SenaraiRekodKakitangan();
        $search = new Tblprcobiodata();
        $model = Tblprcobiodata::find()->all();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-bsm', 'ICNO' => $search->ICNO]);
        }

        return $this->render('carian', [
            'staff' => $staff,
            'search' => $search,
            'model' => $model,
        ]);
    }

    public function SenaraiRekodKakitangan()
    {
        $data = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()->where(['<>', 'Status', 6]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function GridCarianBsm($icno)
    {
        $data = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()->where(['ICNO' => $icno]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionCarianPermohonanBsm($ICNO)
    {
        $staff = $this->GridCarianPermohonan($ICNO);
        $search = new \app\models\hronline\Tblprcobiodata();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-bsm', 'ICNO' => $search->ICNO]);
        }

        return $this->render('carian', [
            'staff' => $staff,
            'search' => $search,
            'ICNO' => $ICNO,
        ]);
    }

    public function GridCarianPermohonan($icno)
    {
        $data = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()->where(['ICNO' => $icno]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionIndex()
    {
        $icno = Yii::$app->user->getId();
        $tahun = date('Y');
        $staff = Tblprcobiodata::find()->where(['ICNO' => $icno])->andWhere(['NOT IN', 'statLantikan', ['1', '2', '3']])->one();
        if (!$staff) {
            $rekod = Tblvisit::find()->where(['visit_icno' => $icno]);

            $provider = new ActiveDataProvider([
                'query' => $rekod,
                'sort' => ['defaultOrder' => ['rawatan_date' => SORT_DESC]],
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

            $layak = Tblmaxtuntutan::find()->where(['max_icno' => $icno])->one();


            $sql_tuntutan = 'SELECT SUM(jum_tuntutan) as jum_tuntutan FROM hrm.myhealth_tblvisit WHERE YEAR(rawatan_date) = :tahun AND visit_icno =:icno';
            $tuntutan = Tblmaxtuntutan::findBySql($sql_tuntutan, [':icno' => $icno, ':tahun' => $tahun])->one();

            $sql_bknpanel = 'SELECT SUM(tuntutan) as tuntutan FROM hrm.myhealth_tblbknpanel WHERE YEAR(tuntutan_date) = :tahun AND icno =:icno';
            $bknpanel = Tblbknpanel::findBySql($sql_bknpanel, [':icno' => $icno, ':tahun' => $tahun])->one();

            $sql_topup = 'SELECT * FROM hrm.myhealth_tbl_topup_his WHERE YEAR(topup_dt) = :tahun AND icno =:icno AND topup_amount != 0.00';
            $topup = TblTopupHis::findBySql($sql_topup, [':icno' => $icno, ':tahun' => $tahun])->all();

            $sql_hums = 'SELECT SUM(deduct_amt) as deduct_amt FROM hrm.myhealth_tbl_medcare WHERE YEAR(visit_dt) = :tahun AND staff_icno =:icno';
            $hums = TblMedcare::findBySql($sql_hums, [':icno' => $icno, ':tahun' => $tahun])->one();

            $keluarga = Tblvisit::familyMember($icno);

            $searchModel = new RefKlinikpanelSearch;
            $klinik = $searchModel->search(Yii::$app->request->queryParams);
            $query = new ActiveDataProvider([
                'query' => $klinik,
                'sort' => ['defaultOrder' => ['nama' => SORT_ASC]],
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

            $pku = RefKlinikpanel::find()->where(['isUMS' => 1])->orderBy(['nama' => SORT_ASC])->all();

            $medcare = TblMedcare::find()->where(['staff_icno' => $icno])->andWhere(['<>', 'deduct_amt', 0.00]);
            $medcares = new ActiveDataProvider([
                'query' => $medcare,
                'sort' => ['defaultOrder' => ['visit_dt' => SORT_DESC]],
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

            $bukanpanel = Tblbknpanel::find()->where(['icno' => $icno]);
            $bukanpanels = new ActiveDataProvider([
                'query' => $bukanpanel,
                'sort' => ['defaultOrder' => ['tuntutan_date' => SORT_DESC]],
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

            return $this->render('index', [
                'rekod' => $rekod,
                'tuntutan' => $tuntutan,
                'bknpanel' => $bknpanel,
                'layak' => $layak,
                'topup' => $topup,
                'keluarga' => $keluarga,
                'dataProvider' => $provider,
                'klinik' => $klinik,
                'searchModel' => $searchModel,
                'pku' => $pku,
                'bukanpanels' => $bukanpanels,
                'medcares' => $medcares,
                'query' => $query,
                'hums' => $hums,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Haraf Maaf', 'type' => 'error', 'msg' => 'Kemudahan Klinik Panel Hanya Layak Untuk Kakitangan Lantikan Tetap dan Kontrak Pusat Sahaja.']);
            return $this->redirect(['kehadiran/index']);
        }
    }

    public function actionSenaraiTopup()
    {
        $icno = Yii::$app->user->getId();
        $model = TblTopupHis::find()->where(['<>', 'topup_amount', 0.00]);
        $searchModel = new TblTopupHisSearch();

        $query = new ActiveDataProvider([
            'query' => $model,
            'sort' => ['defaultOrder' => ['topup_dt' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (Yii::$app->request->queryParams) {
            $query = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('senarai-topup', [
            'query' => $query,
            'model' => $model,
            'icno' => $icno,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionMohon()
    {
        $icno = Yii::$app->user->getId();
        $year = date('Y');
        $check1 = Tblmohon::find()->where(['icno' => $icno])->andWhere(['>=', 'entry_id', '2'])->one();
        $check2 = Tblmohon::find()->where(['icno' => $icno])->andWhere(['IN', 'status', [0, 1, 2, 5]])->one();
        $baki = Tblmaxtuntutan::find()->where(['max_icno' => $icno])->andWhere(['>', 'current_balance', 300])->one();
        $verifier_bsm = Department::findOne(['=', 'id', '158']);
        $kjbsm = $verifier_bsm->chief;
        $pendaftar = Department::findOne(['=', 'id', '12']);
        // $pendaftar = $pn->chief;

        if ($baki) {
            Yii::$app->session->setFlash('alert', ['title' => 'Haraf Maaf', 'type' => 'error', 'msg' => 'Permohonan penambahan peruntukan hanya boleh dibuat apabila baki anda kurang daripada RM300.']);
            return $this->redirect(['klinikpanel/index']);
        }
        if ($check1) {
            Yii::$app->session->setFlash('alert', ['title' => 'Haraf Maaf', 'type' => 'error', 'msg' => 'Permohonan penambahan peruntukan (MyHealth UMS) hanya boleh dibuat 2 kali setahun sahaja.']);
            return $this->redirect(['klinikpanel/index']);
        }
        if ($check2) {
            Yii::$app->session->setFlash('alert', ['title' => 'Haraf Maaf', 'type' => 'error', 'msg' => 'Permohonan penambahan peruntukan yang terdahulu masih dalam proses semakan.']);
            return $this->redirect(['klinikpanel/index']);
        }

        $model = new Tblmohon();
        $model->icno = $icno;
        $model->entry_dt = date('Y-m-d H:i:s');
        $old_bal = $model->kakitangan->current_balance;
        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $kj = Department::findOne(['id' => $biodata->DeptId]);

        // $kj = SetPegawai::findOne(['pemohon_icno' => $icno]);
        $approver = Pegawai::find()->one();
        if ($kj->chief == $icno) {
            $model->verify_by = '700827125563';
        } else {
            $model->verify_by = $kj->chief;
        }
        $model->check_by = $approver->penyemak_icno;
        $model->app_by = $pendaftar->chief;
        $model->verifybsm_by = $kjbsm;
        $model->dept_id = $biodata->DeptId;

        if (Tblmohon::find()->where(['icno' => $icno])->andWhere(['YEAR(entry_dt)' => $year])->exists()) {
            $model->entry_id = 2;
        } else {
            $model->entry_id = 1;
        }
        if ($model->entry_id == 1) {
            $model->jumlah_mohon  = $model->kakitangan->max_tuntutan / 2;
        } else {
            $model->jumlah_mohon = $model->kakitangan->max_tuntutan / 4;
        }
        if ($model->load(Yii::$app->request->post())) {
            $ntf = new Notification();
            $ntf2 = new Notification();
            $model->status = 0;
            $model->dependent = $model->kakitangan->tanggungan;
            $model->mohon_balance = $old_bal;
            $model->save(false);

            if ($kj->chief == $model->icno) {

                $ntf->icno = 700827125563;
                $ntf->title = '(MyHealth) Permohonan Penambahan Peruntukan Klinik Panel';
                $ntf->content = "Permohonan menunggu tindakan perakuan anda." . Html::a('<i class="fa fa-arrow-right"></i> Klik di sini', ['klinikpanel/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            } else {
                //save notification
                $ntf->icno = $kj->chief; // Ketua Jabatan memperaku
                $ntf->title = '(MyHealth) Permohonan Penambahan Peruntukan Klinik Panel';
                $ntf->content = "Permohonan menunggu tindakan perakuan anda." . Html::a('<i class="fa fa-arrow-right"></i> Klik di sini', ['klinikpanel/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            }


            // $ntf2->icno = $approver->penyemak_icno; // penyemak BSM
            // $ntf2->title = '(MyHealth)Permohonan Penambahan Peruntukan Klinik Panel';
            // $ntf2->content = "Permohonan penambahan peruntukan MyHealth untuk tindakan semakan anda." . Html::a('<i class="fa fa-arrow-right"></i> Klik di sini ', ['klinikpanel/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
            // $ntf2->ntf_dt = date('Y-m-d H:i:s');
            // $ntf2->save();
            //
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan anda  telah dihantar.']);
            return $this->redirect(['klinikpanel/index']);
        }
        return $this->render('mohon', [
            'model' => $model,
            'kj' => $kj,
            'approver' => $approver,
            'icno' => $icno,

        ]);
    }

    public function actionRekodRawatan($icno)
    {
        $year = date('Y');
        $model = Tblvisit::find()->where(['visit_icno' => $icno])
            ->andWhere(['YEAR(rawatan_date)' => $year])
            ->all();
        // var_dump($rekod);die;

        return $this->render('rekod-rawatan', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionFamilyList()
    {
        $icno = Yii::$app->user->getId();
        $keluarga = Tblvisit::familyMember($icno);

        return $this->renderAjax('_list_keluarga', [
            'bil' => 1,
            'keluarga' => $keluarga,

        ]);
    }

    public function actionFamilyListpemohon($id)
    {
        $model = Tblmohon::find()->where(['id' => $id])->one();
        $keluarga = Tblvisit::familyMember($model->icno);

        return $this->renderAjax('_list_keluarga', [
            'bil' => 1,
            'keluarga' => $keluarga,
            'model' => $model,

        ]);
    }

    public function actionSemak()
    {

        $icno = Yii::$app->user->getId();
        $model = Tblmohon::findAll(['icno' => $icno]);
        $kj = SetPegawai::findOne(['pemohon_icno' => $icno]);
        $approver = Pegawai::find()->one();

        return $this->render('semak', [
            'model' => $model,
            'bil' => 1,
            'kj' => $kj,
            'approver' => $approver,
        ]);
    }

    public function actionSenaraiTindakan($id = null)
    {

        $icno = Yii::$app->user->getId();

        $bsm = Pegawai::find()->one();
        $model = Tblmohon::find()->one();
        // $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);
        // $kj = Department::findOne(['id' => $biodata->DeptId]);
        $verifier_bsm = Department::findOne(['=', 'id', '158']);
        $kjbsm = $verifier_bsm->chief;
        $pendaftar = Department::findOne(['=', 'id', '12']);

        if ($id == '1') {
            $model = Tblmohon::find()->where(['=', 'status', 2])->all();
        } else {
            if (Department::find()->where(['chief' => $icno])->exists()) {
                $model = Tblmohon::find()->where(['verify_by' => $icno])->andWhere(['=', 'status', 0])->all();
            } elseif ($bsm->penyemak_icno == $icno) {
                $model = Tblmohon::find()->where(['=', 'status', 1])->all();                
            } elseif ($kjbsm == $icno) {
                $model = Tblmohon::find()->where(['verify_by' => $icno])->andWhere(['=', 'status', 0])->all();
            } elseif ($pendaftar->chief == $icno) {
                $model = Tblmohon::find()->where(['=', 'status', 5])->all();
            } elseif ($icno == '700827125563') {
                $model = Tblmohon::find()->where(['verify_by' => '700827125563'])->andWhere(['=', 'status', '0'])->all();
            }
            
        }


        $searchModel = new TblmohonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);



        return $this->render('senarai-tindakan', [
            'model' => $model,
            'bil' => 1,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'verifier_bsm' => $verifier_bsm,
            'kjbsm' => $kjbsm,
        ]);
    }

    public function actionPaparPeraku($id)
    {

        $icno = Yii::$app->user->getId();
        $model = Tblmohon::findOne(['id' => $id]);
        $ntf = new Notification();
        $approver = Pegawai::find()->one();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $kj = Department::findOne(['id' => $biodata->DeptId]);

        // $kj = SetPegawai::findOne(['pemohon_icno' => $model->icno]);

        if ($kj->chief == $icno || $icno == '700827125563') {

            if ($model->load(Yii::$app->request->post())) {
                $model->verify_dt = date('Y-m-d H:i:s');
                $model->status_ver = $model->status;
                $model->save(false);

                $ntf->icno = $approver->penyemak_icno; // kakitangan penyemak
                $ntf->title = '(MyHealth)Permohonan Penambahan Peruntukan Klinik Panel';
                $ntf->content = "Permohonan penambahan peruntukan MyHealth untuk tindakan semakan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['klinikpanel/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tindakan perakuan berjaya dikemaskini.']);
                return $this->redirect(['klinikpanel/senarai-tindakan']);
            }
        }
        return $this->render('papar-peraku', [
            'id' => $id,
            'model' => $model,
            'bil' => 1,
            'kj' => $kj,
            'approver' => $approver,
        ]);
    }

    public function actionSenaraiPermohonan()
    {
        $icno = Yii::$app->user->getId();
        $searchModel = new TblmohonSearch();
        $dataProvider = Tblmohon::find()
            ->where(['NOT IN', 'status', [3, 4]]);

        $query = new ActiveDataProvider([
            'query' => $dataProvider,
            'sort' => ['defaultOrder' => ['entry_dt' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (Yii::$app->request->queryParams) {
            $query = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('senarai-permohonan', [
            'query' => $query,
            'icno' => $icno,
            'searchModel' => $searchModel,

        ]);
    }

    public function actionSelesaiTindakan()
    {

        $icno = Yii::$app->user->getId();
        $searchModel = new TblmohonSearch();
        $dataProvider = Tblmohon::find()
            ->where(['IN', 'status', [3, 4]]);

        $query = new ActiveDataProvider([
            'query' => $dataProvider,
            'sort' => ['defaultOrder' => ['entry_dt' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (Yii::$app->request->queryParams) {
            $query = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('selesai-tindakan', [
            'query' => $query,
            'icno' => $icno,
            'searchModel' => $searchModel,

        ]);
    }

    public function actionUpdatePermohonan($id)
    {
        $icno = Yii::$app->user->getId();
        $model = Tblmohon::findOne(['id' => $id]);
        $ntf = new Notification();
        $approver = Pegawai::find()->one();
        $baki = Tblmaxtuntutan::findOne(['max_icno' => $model->icno]);
        $oldbaki = $baki->current_balance;
        $oldtopupmax = $baki->topup_max;
        $topup = new TblTopupHis();

        if ($approver->penyemak_icno == $icno) {
            if ($model->load(Yii::$app->request->post())) {
                $model->check_dt = date('Y-m-d H:i:s');
                $model->verifybsm_dt = date('Y-m-d H:i:s');
                $model->app_dt = date('Y-m-d H:i:s');
                $model->status = $model->status_app;
                $baki->current_balance = $oldbaki + $model->app_amount;
                // $model->app_amount = $baki->topup_max;
                $baki->topup_max = $oldtopupmax + $model->app_amount;
                $topup->icno = $model->icno;
                $topup->topup_amount = $model->app_amount;
                $topup->topup_by = $icno;
                $topup->topup_dt = date('Y-m-d H:i:s');
                $model->save(false);
                $topup->save();
                $baki->save();

                $ntf->icno = $model->icno; // pemohon
                $ntf->title = '(MyHealth) Permohonan Penambahan Peruntukan Klinik Panel';
                if ($model->status == 4) {
                    $ntf->content = "Permohonan penambahan peruntukan MyHealth anda tidak diluluskan. Sila semak status permohonan anda" . Html::a('<i class="fa fa-arrow-right">di sini</i>', ['klinikpanel/semak'], ['class' => 'btn btn-primary btn-sm']);
                } else {
                    $ntf->content = "Permohonan penambahan peruntukan MyHealth anda telah diluluskan. Sila semak status permohonan anda" . Html::a('<i class="fa fa-arrow-right"></i>', ['klinikpanel/semak'], ['class' => 'btn btn-primary btn-sm']);
                }
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Kemaskini berjaya.']);
                return $this->redirect(['klinikpanel/senarai-permohonan']);
            }
        }
        return $this->render('update-permohonan', [
            'id' => $id,
            'model' => $model,
            'bil' => 1,
            'approver' => $approver,
        ]);
    }


    public function actionSenarai()
    {
        $year = date('Y');
        $model = Tblmohon::find()->where(['YEAR(entry_dt)' => $year])
            ->andWhere(['IN', 'status', [1, 2]])
            ->all();

        return $this->render('senarai', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionPaparPenyemak($id)
    {

        $icno = Yii::$app->user->getId();
        $model = Tblmohon::findOne(['id' => $id]);
        $ntf = new Notification();
        $approver = Pegawai::find()->one();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $kj = Department::findOne(['id' => $biodata->DeptId]);
        $verifier_bsm = Department::findOne(['=', 'id', '158']);

        if ($approver->penyemak_icno == $icno) {
            if ($model->load(Yii::$app->request->post())) {
                $model->check_by = $icno;
                $model->check_dt = date('Y-m-d H:i:s');
                $model->status_check = $model->status;
                $model->save(false);

                $ntf->icno = $verifier_bsm->chief; // ketua bsm
                $ntf->title = '(MyHealth) Permohonan Penambahan Peruntukan Klinik Panel';
                $ntf->content = "Permohonan penambahan peruntukan MyHealth untuk tindakan perakuan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['klinikpanel/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tindakan semakan berjaya dikemaskini.']);
                return $this->redirect(['klinikpanel/senarai-tindakan']);
            }
        }
        return $this->render('papar-penyemak', [
            'id' => $id,
            'model' => $model,
            'bil' => 1,
            'approver' => $approver,
            'kj' => $kj,
        ]);
    }

    public function actionPaparPerakubsm($id)
    {

        $icno = Yii::$app->user->getId();
        $model = Tblmohon::findOne(['id' => $id]);
        $ntf = new Notification();
        $verifier_bsm = Department::findOne(['=', 'id', '158']);
        $kjbsm = $verifier_bsm->chief;
        $pn = Department::findOne(['=', 'id', '12']);
        $pendaftar = $pn->chief;

        $approver = Pegawai::find()->one();

        if ($kjbsm == $icno) {
            if ($model->load(Yii::$app->request->post())) {
                $model->verifybsm_by = $icno;
                $model->verifybsm_dt = date('Y-m-d H:i:s');
                $model->status_verifybsm = $model->status;
                $model->save(false);

                $ntf->icno = $pendaftar; // Pendaftar
                $ntf->title = '(MyHealth) Permohonan Penambahan Peruntukan Klinik Panel';
                $ntf->content = "Permohonan penambahan peruntukan MyHealth untuk tindakan kelulusan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['klinikpanel/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tindakan semakan berjaya dikemaskini.']);
                return $this->redirect(['klinikpanel/senarai-tindakan']);
            }
        }
        return $this->render('papar-perakubsm', [
            'id' => $id,
            'model' => $model,
            'bil' => 1,
            'verifier_bsm' => $verifier_bsm,
            'approver' => $approver,
        ]);
    }

    public function actionPerakuanKetuabsm()
    {
        $icno = Yii::$app->user->getId();
        $dataProvider = Tblmohon::find()
            ->where(['status' => '2'])
            ->orderBy(['entry_dt' => SORT_ASC]);

        $query = new ActiveDataProvider([
            'query' => $dataProvider,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
       
        $model = Tblmohon::find()->all(); 
        $pn = Department::findOne(['=', 'id', '12']);
        $pendaftar = $pn->chief;
        // $topup = new TblTopupHis();
        // $ntf = new Notification();
        if ($pilih = Yii::$app->request->post()) {
            $selection = (array)Yii::$app->request->post('selection');

            foreach ($selection as $k => $v) {

                
                $models = Tblmohon::findOne($v);
                $models->verifybsm_by = $icno;
                $models->verifybsm_dt = date('Y-m-d H:i:s');
                $models->status_verifybsm = 5;
                $models->status = $models->status_verifybsm;
                $models->save(false);

                $ntf = new Notification();
                $ntf->icno = $pendaftar; // pendaftar
                $ntf->title = '(MyHealth) Permohonan Penambahan Peruntukan Klinik Panel';
                $ntf->content = "Permohonan penambahan peruntukan MyHealth untuk tindakan kelulusan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['klinikpanel/senarai-tindakan'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
        
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Penambahan Peruntukan Berjaya Diperaku!']);
            return $this->redirect(['perakuan-ketuabsm']);
        }

        return $this->render('perakuan-ketuabsm', [
            'query' => $query,
            'bil' => 1,
        ]);
    }

    public function actionKelulusanPendaftar()
    {
        $icno = Yii::$app->user->getId();
        $dataProvider = Tblmohon::find()
            ->where(['status' => '5'])
            ->orderBy(['entry_dt' => SORT_ASC]);

        $query = new ActiveDataProvider([
            'query' => $dataProvider,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
       
        $model = Tblmohon::find()->all(); 
        $topup = new TblTopupHis();
        // $ntf = new Notification();
        if ($pilih = Yii::$app->request->post()) {
            $selection = (array)Yii::$app->request->post('selection');

            foreach ($selection as $k => $v) {

                
                $models = Tblmohon::findOne($v);
                $baki = Tblmaxtuntutan::findOne(['max_icno' => $models->icno]);
                $oldbaki = $baki->current_balance;
                $topup = new TblTopupHis();
                $ntf = new Notification();
                // $bakis = Tblmaxtuntutan::findOne($v);

                $models->app_by = $icno;
                $models->app_dt = date('Y-m-d H:i:s');
                $models->status_app = 3;
                $models->status = $models->status_app;
                $baki->current_balance = $oldbaki + $models->jumlah_mohon;
                $topup->icno = $models->icno;
                $topup->topup_amount = $models->jumlah_mohon;
                $topup->topup_by = $models->check_by;
                $topup->topup_dt = date('Y-m-d H:i:s');

                $models->save(false);
                $baki->save(false);
                $topup->save(false);

                $ntf->icno = $models->icno; // kakitangan yg memohon
                $ntf->title = '(MyHealth) Permohonan Penambahan Peruntukan Klinik Panel';
                $ntf->content = "Permohonan penambahan peruntukan MyHealth anda telah diluluskan.Sila semak status permohonan anda. " . Html::a('<i class="fa fa-arrow-right"></i>', ['klinikpanel/semak'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                         // $models->save(false);
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Penambahan Peruntukan Berjaya Diluluskan!']);
            return $this->redirect(['kelulusan-pendaftar']);
        }

        return $this->render('kelulusan-pendaftar', [
            'query' => $query,
            'bil' => 1,
        ]);
    }

    public function actionPaparPendaftar($id)
    {

        $icno = Yii::$app->user->getId();
        $model = Tblmohon::findOne(['id' => $id]);
        $baki = Tblmaxtuntutan::findOne(['max_icno' => $model->icno]);
        $oldbaki = $baki->current_balance;
        $topup = new TblTopupHis();
        $ntf = new Notification();
        $verifier_bsm = Department::findOne(['=', 'id', '158']);
        // $kjbsm = $verifier_bsm->chief;
        $pn = Department::findOne(['=', 'id', '12']);
        $pendaftar = $pn->chief;

        $approver = Pegawai::find()->one();

        if ($pendaftar == $icno) {
            if ($model->load(Yii::$app->request->post())) {
                $model->app_by = $icno;
                $model->app_dt = date('Y-m-d H:i:s');
                $model->status_app = $model->status;
                if ($model->status == 5) {
                    $model->app_amount = $model->jumlah_mohon;
                } else $model->app_amount == '0.00';
                $baki->current_balance = $oldbaki + $model->app_amount;
                $topup->icno = $model->icno;
                $topup->topup_amount = $model->app_amount;
                $topup->topup_by = $model->check_by;
                $topup->topup_dt = date('Y-m-d H:i:s');
                $model->save(false);
                $baki->save();
                $topup->save();

                $ntf->icno = $model->icno; // pemohon
                $ntf->title = '(MyHealth)Permohonan Penambahan Peruntukan Klinik Panel';
                if ($model->status == 4) {
                    $ntf->content = "Permohonan penambahan peruntukan MyHealth anda tidak diluluskan. Sila semak status permohonan anda" . Html::a('<i class="fa fa-arrow-right">di sini</i>', ['klinikpanel/semak'], ['class' => 'btn btn-primary btn-sm']);
                } else {
                    $ntf->content = "Permohonan penambahan peruntukan MyHealth anda telah diluluskan. Sila semak status permohonan anda" . Html::a('<i class="fa fa-arrow-right"></i>', ['klinikpanel/semak'], ['class' => 'btn btn-primary btn-sm']);
                }
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tindakan kelulusan berjaya dikemaskini.']);
                return $this->redirect(['klinikpanel/senarai-tindakan']);
            }
        }
        return $this->render('papar-pendaftar', [
            'id' => $id,
            'model' => $model,
            'bil' => 1,
            'verifier_bsm' => $verifier_bsm,
            'approver' => $approver,
        ]);
    }

    public function actionPaparPelulus($id)
    {

        $icno = Yii::$app->user->getId();
        $model = Tblmohon::findOne(['id' => $id]);
        $baki = Tblmaxtuntutan::findOne(['max_icno' => $model->icno]);
        $oldbaki = $baki->current_balance;
        $topup = new TblTopupHis();
        $ntf = new Notification();
        $approver = Pegawai::find()->one();
        $kj = SetPegawai::find()->one();

        if ($approver->pelulus_icno == $icno) {
            if ($model->load(Yii::$app->request->post())) {
                $model->app_by = $icno;
                $model->app_dt = date('Y-m-d H:i:s');
                $model->status_app = $model->status;
                $baki->current_balance = $oldbaki + $model->app_amount;
                $topup->icno = $model->icno;
                $topup->topup_amount = $model->app_amount;
                $topup->topup_by = $icno;
                $topup->topup_dt = date('Y-m-d H:i:s');
                $model->save(false);
                $baki->save();
                $topup->save();

                $ntf->icno = $model->icno; // kakitangan penyemak
                $ntf->title = '(MyHealth)Permohonan Penambahan Peruntukan Klinik Panel';
                if ($model->status == 4) {
                    $ntf->content = "Permohonan penambahan peruntukan MyHealth anda tidak diluluskan. Sila semak status permohonan anda" . Html::a('<i class="fa fa-arrow-right">di sini</i>', ['klinikpanel/semak'], ['class' => 'btn btn-primary btn-sm']);
                } else {
                    $ntf->content = "Permohonan penambahan peruntukan MyHealth anda telah diluluskan. Sila semak status permohonan anda" . Html::a('<i class="fa fa-arrow-right"></i>', ['klinikpanel/semak'], ['class' => 'btn btn-primary btn-sm']);
                }
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tindakan kelulusan berjaya dikemaskini.']);
                return $this->redirect(['klinikpanel/senarai-tindakan']);
            }
        }
        return $this->render('papar-pelulus', [
            'id' => $id,
            'model' => $model,
            'bil' => 1,
            'approver' => $approver,
            'kj' => $kj,
        ]);
    }

    public function actionMemoLulus($id)
    {
        $icno = Yii::$app->user->getId();
        $approver = Pegawai::find()->one();
        $kj = SetPegawai::find()->one();
        $model = Tblmohon::findOne(['id' => $id]);

        return $this->render('memo-lulus', [
            'model' => $model,
            'id' => $id,
            'kj' => $kj,
            'approver' => $approver,
        ]);
    }


    public function actionPapar($id)
    {

        $rekod = Tblmaxtuntutan::find()->where(['max_icno' => $id])->one();
        $oldvalue = $rekod->current_balance;
        $oldtopupmax = $rekod->topup_max;
        $oldmaxtuntutan = $rekod->max_tuntutan;

        $tahun = date('Y');
        $rekods = Tblvisit::find()->where(['visit_icno' => $id]);

        $provider = new ActiveDataProvider([
            'query' => $rekods,
            'sort' => ['defaultOrder' => ['rawatan_date' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $bukanpanel = Tblbknpanel::find()->where(['icno' => $id]);
        $bukanpanels = new ActiveDataProvider([
            'query' => $bukanpanel,
            'sort' => ['defaultOrder' => ['tuntutan_date' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $medcare = TblMedcare::find()->where(['staff_icno' => $id])->andWhere(['<>', 'deduct_amt', 0.00]);
        $medcares = new ActiveDataProvider([
            'query' => $medcare,
            'sort' => ['defaultOrder' => ['visit_dt' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        $sql_topup = 'SELECT * FROM hrm.myhealth_tbl_topup_his WHERE YEAR(topup_dt) = :tahun AND icno =:icno AND topup_amount != 0.00';
        $topup = TblTopupHis::findBySql($sql_topup, [':icno' => $id, ':tahun' => $tahun])->all();

        $keluarga = Tblvisit::familyMember($id);

        $icno = Yii::$app->user->getId();

        if ($rekod->load(Yii::$app->request->post())) {

            $ntf = new Notification();
            $topups = new TblTopupHis();
            $topups->topup_amount = $rekod->topup_max;
            $rekod->current_balance = $oldvalue + $topups->topup_amount;
            $old = $rekod->max_tuntutan - $oldmaxtuntutan;
            if ($oldmaxtuntutan == $rekod->max_tuntutan) {
                $rekod->current_balance;
            } else {
                $rekod->current_balance = $rekod->current_balance + $old;
            }
            $rekod->topup_max = $oldtopupmax + $topups->topup_amount;
            $topups->icno = $id;
            $topups->topup_by = $icno;
            $topups->topup_dt = date('Y-m-d H:i:s');


            if ($rekod->save()) {
                //save notification
                $topups->save();
                $ntf->icno = $rekod->max_icno; // kakitangan
                $ntf->title = 'Klinik Panel (MyHealth UMS)';
                $ntf->content = "Peruntukan Rawatan Klinik Panel telah ditambah. Sila semak baki terkini anda." . Html::a('<i class="fa fa-arrow-right"></i>', ['klinikpanel/index'], ['class' => 'btn btn-primary btn-sm']);
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Butiran peruntukan berjaya dikemaskini.']);
                return $this->redirect(['klinikpanel/papar', 'id' => $rekod->max_icno]);
            }
        }

        return $this->render('papar', [
            'rekod' => $rekod,
            'oldvalue' => $oldvalue,
            'topup' => $topup,
            'keluarga' => $keluarga,
            'dataProvider' => $provider,
            'bukanpanels' => $bukanpanels,
            'medcares' => $medcares,
        ]);
    }

    public function actionDeleteTopup($id)
    {
        $model = TblTopupHis::findOne(['id' => $id]);
        $model->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        $staff = Tblmaxtuntutan::findOne($model->icno);
        $old_topup_max = $staff->topup_max;
        $balance = $staff->current_balance - $model->topup_amount;
        $new_topup = $old_topup_max - $model->topup_amount;
        $staff->current_balance = $balance;
        $staff->save(false);
        return $this->redirect(['senarai-topup']);
    }

    public function actionView($id)
    {
        $jumlah = 0;
        $namaubat = Tblmedicine::find()->where(['med_visit_id' => $id])->all();
        $model = Tblvisit::find()->where(['rawatan_id' => $id])->one();
        foreach ($namaubat as $data) {
            $jumlah = $jumlah + $data->tblmed_price;
        }

        return $this->render('view', [
            'model' => $model,
            'namaubat' => $namaubat,
            'jumlah' => $jumlah,
        ]);
    }

    public function actionViewMedcare($id)
    {

        $model = TblMedcare::find()->where(['id' => $id])->one();

        return $this->render('view-medcare', [
            'model' => $model,
        ]);
    }

    public function actionViewMedcarepapar($id)
    {

        $model = TblMedcare::find()->where(['id' => $id])->one();

        return $this->render('view-medcarepapar', [
            'model' => $model,
        ]);
    }

    public function actionDeleteMedcare($id)
    {

        $model = TblMedcare::findOne(['id' => $id]);
        $model->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        $staff = Tblmaxtuntutan::findOne($model->staff_icno);
        $balance = $staff->current_balance + $model->deduct_amt;
        $staff->current_balance = $balance;
        $staff->save(false);
        return $this->redirect(['rekod-medcare']);
    }

    public function actionViewAdmin($id)
    {
        $jumlah = 0;
        $namaubat = Tblmedicine::find()->where(['med_visit_id' => $id])->all();
        $model = Tblvisit::find()->where(['rawatan_id' => $id])->one();
        foreach ($namaubat as $data) {
            $jumlah = $jumlah + $data->tblmed_price;
        }

        return $this->render('view-admin', [
            'model' => $model,
            'namaubat' => $namaubat,
            'jumlah' => $jumlah,
        ]);
    }

    public function actionViewAdmins($id)
    {
        $jumlah = 0;
        $namaubat = Tblmedicine::find()->where(['med_visit_id' => $id])->all();
        $model = Tblvisit::find()->where(['rawatan_id' => $id])->one();
        foreach ($namaubat as $data) {
            $jumlah = $jumlah + $data->tblmed_price;
        }

        return $this->render('view-admins', [
            'model' => $model,
            'namaubat' => $namaubat,
            'jumlah' => $jumlah,
        ]);
    }
    public function actionViewAdminr($id)
    {
        $jumlah = 0;
        $namaubat = Tblmedicine::find()->where(['med_visit_id' => $id])->all();
        $model = Tblvisit::find()->where(['rawatan_id' => $id])->one();
        foreach ($namaubat as $data) {
            $jumlah = $jumlah + $data->tblmed_price;
        }

        return $this->render('view-adminr', [
            'model' => $model,
            'namaubat' => $namaubat,
            'jumlah' => $jumlah,
        ]);
    }

    public function actionDeleted($id)
    {
        $icno = Yii::$app->user->getId();
        $model = Tblvisit::findOne(['rawatan_id' => $id]);

        //save dulu yg lama
        $rawatan_id = $model->rawatan_id;
        $rawatan_dt = $model->rawatan_date;
        $record_owner = $model->visit_icno;
        $klinik = $model->visit_klinik_id;
        $tuntutan = $model->jum_tuntutan;

        $model->delete();
        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dipadam!']);
        $staff = Tblmaxtuntutan::findOne($model->visit_icno);
        $balance = $staff->current_balance + $model->jum_tuntutan;
        $staff->current_balance = $balance;
        $staff->save(false);

        $log = new TblLog();
        $log->rawatan_id = $rawatan_id;
        $log->rawatan_dt = $rawatan_dt;
        $log->icno = $record_owner;
        $log->tindakan = 'PADAM REKOD LAWATAN';
        $log->visit_klinik_id = $klinik;
        $log->amount = $tuntutan;
        $log->log_dt = date('Y-m-d H:i:s');
        $log->log_by = $icno;
        $log->save(false);

        return $this->redirect(['rekod-lawatan']);
    }

    public function actionEnquiry()
    {
        $icno = Yii::$app->user->getId();
        $enkuiri = Tblenquiry::find()->all();
        $query = Tblenquiry::find();
        $querys = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('enquiry', [
            'query' => $querys,
            'enkuiri' => $enkuiri,
            'bil' => 1,
        ]);
    }

    public function actionTindakan($id)
    {

        $icno = Yii::$app->user->getId();
        $model = Tblenquiry::findOne($id);
        $ntf = new Notification();

        if ($model->load(Yii::$app->request->post())) {
            $model->remark_by = $icno;
            $model->remark_dt = date('Y-m-d H:i:s');
            $model->save();


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Status semakan  berjaya dikemaskini.']);
            return $this->redirect(['klinikpanel/enquiry']);
        }

        return $this->renderAjax('tindakan', [
            'id' => $id,
            'model' => $model,
            'bil' => 1,
        ]);
    }

    



    protected function findModel($max_icno)
    {
        if (($model = Tblmaxtuntutan::findOne($max_icno)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
