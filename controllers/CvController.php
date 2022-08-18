<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\cv\TblQualifiedVk7;
use app\models\cv\TblQualifiedDs54;
use app\models\cv\TblAccess;
use app\models\cv\TblAccessbySkim;
use app\models\cv\TblPerakuanPanel;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\hronline\BiodataSearch;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;
use yii\data\ActiveDataProvider;
use app\models\cv\TblPermohonan;
use app\models\cv\TblPermohonanSearch;
use app\models\cv\TblAppinfo;
use app\models\cv\TblpSubjekPanel;
use app\models\ejobs\TblpQuestion;
use app\models\cv\TblTemudugaPentadbiran;
use app\models\cv\TemudugaPentadbiran;
use app\models\ejobs\StatusMarkah;
use app\models\ejobs\TblpSubjek;
use app\models\cv\TblpMarkahIv;
use app\models\cv\GredJawatan;
use app\models\cv\RefStatus;
use app\models\cv\TblAds;
use app\models\Notification;
use app\models\cv\TblSwSociety;
use app\models\cv\TblSwUniversity;
use app\models\cv\TblPanel;
use app\models\cv\TblAduan;
use app\models\cv\TblAduanPentadbiran;
use app\models\cv\TblFileTapisan;
use app\models\cv\StatusTapisan;
use app\models\cv\TblCandidateKiv;
use app\models\cv\TblPenilaianJawatan;
use yii\helpers\Html;
use yii\web\UploadedFile;
use app\models\cv\TblActivitiesOther;
use app\models\cv\TblIncome;
use app\models\cv\TblInnovation;
use app\models\cv\TblJobdetails;
use app\models\cv\TblPaperwork;
use app\models\cv\TblResearch;
use app\models\cv\TblResearchV2;
use app\models\cv\TblPublication;
use app\models\cv\TblConferences;
use app\models\cv\TblStewardship;
use app\models\cv\TblSkills;
use app\models\cv\TblSports;

class CvController extends Controller {

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
                    //many user
                    'resume-edit', 'resume-cv', 'application', 'record-application', 'complain', 'search-candidate',
                    'criteria-check', 'view-cv', 'kj', 'kj-approval', 'jd', 'criteria-check-administration', 'download-cv',
                    'services-university', 'services-community',
                    //pengguna akademik
                    'esteem-leadership', 'thesis-examiner', 'application-checking',
                    //pengguna pentadbiran
                    'stewardship','conferences','publication','app-submit', 'announcement', 'job-details', 'innovation', 'skills', 'activities-other', 'income', 'sports', 'research', 'paper-work',
                    //pentadbir sistem
                    'access',
                    //tester/data owner
                    'record-complain-owner',
                    //akademik & pentadbiran
                    'applications', 'record-complain', 'record-complain-by-status', 'search', 'add-access-panel',
                    //akademik
                    'applications-contract', 'add-content', 'file-tapisan', 'file-tapisan', 'add-candidate-kiv',
                    'list-candidate-wait-contract', 'list-candidate-contract', 'list-candidate-iv-contract', 'archive-application-ac', 'my-statistic-verified', 'my-statistic',
                    //pentadbiran
                    'search-jfpiu', 'search-candidate-administration', 'criteria-check-administration', 'interview-done',
                    'interview-record', 'subject', 'ads', 'list-candidate-pen', 'list-candidate-pass', 'candidate', 'view-mark',
                    //akademik  & panel akademik
                    'jawatankuasa', 'list-candidate', 'list-candidate-wait', 'list-candidate-kiv',
                    'list-candidate-jawatankuasa', 'list-candidate-iv',
                    //panel pentadbiran
                    'interview', 'assign-subject', 'competency', 'jawatankuasa-pentadbiran', 'list-candidate-filter',
                ],
                'rules' => [
                    [//pengguna akademik
                        'actions' => ['app-submit', 'application-checking', 'view-cv', 'resume-edit', 'resume-cv', 'application', 'record-application', 'complain', 'services-university', 'services-community', 'esteem-leadership', 'thesis-examiner'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = Tblprcobiodata::find()
                                    ->joinWith('jawatan')
                                    ->where(['tblprcobiodata.ICNO' => Yii::$app->user->getId()])->andWhere(['!=', 'tblprcobiodata.Status', '6'])
                                    ->andWhere(['gredjawatan.job_category' => 1])
                                    ->one();
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//pengguna pentadbiran
                        'actions' => ['stewardship','conferences','publication','services-university', 'services-community', 'app-submit', 'application-checking', 'view-cv', 'announcement', 'resume-edit', 'job-details', 'innovation', 'skills', 'activities-other', 'income', 'sports', 'research', 'paper-work', 'resume-cv', 'application', 'record-application', 'complain'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = Tblprcobiodata::find()
                                    ->joinWith('jawatan')
                                    ->where(['tblprcobiodata.ICNO' => Yii::$app->user->getId()])->andWhere(['!=', 'tblprcobiodata.Status', '6'])
                                    ->andWhere(['gredjawatan.job_category' => 2])
                                    ->one();
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//ketua jabatan & pegawai peraku
                        'actions' => ['application-checking', 'search-candidate', 'criteria-check', 'view-cv', 'kj', 'kj-approval', 'jd', 'criteria-check-administration', 'download-cv'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = Department::findOne(['chief' => Yii::$app->user->getId(), 'isActive' => 1]);
                            $tmp2 = TblPermohonan::findOne(['kj_ICNO' => Yii::$app->user->getId()]);
                            return (!empty($tmp) || !empty($tmp2)) ? true : false;
                        }
                    ],
                    [//ketua pentadbiran
                        'actions' => ['application-checking', 'search-candidate', 'criteria-check', 'view-cv'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = Department::findOne(['pp' => Yii::$app->user->getId(), 'isActive' => 1]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//Pengguna Luar
                        'actions' => ['application-checking', 'jawatankuasa', 'list-candidate', 'list-candidate-wait', 'list-candidate-kiv', 'list-candidate-jawatankuasa', 'view-cv', 'download-cv', 'criteria-check', 'jd'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::isExternalUner();
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//pentadbir sistem
                        'actions' => ['access', 'search', 'view-cv'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => 1]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//tester/data owner
                        'actions' => ['application-checking', 'search', 'search-candidate', 'criteria-check', 'view-cv', 'record-complain-owner', 'my-statistic-verified', 'my-statistic',],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => 3]);
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//admin
                        'actions' => [
                            //akademik & pentadbiran
                            'application-checking', 'applications', 'record-complain', 'record-complain-by-status', 'search-candidate', 'search', 'add-access-panel', 'my-statistic-verified', 'my-statistic',
                            //akademik
                            'applications-contract', 'add-content', 'file-tapisan', 'file-tapisan', 'add-candidate-kiv', 'list-candidate-wait-contract', 'list-candidate-contract', 'list-candidate-iv-contract', 'archive-application-ac',
                            //pentadbiran
                            'search-jfpiu', 'search-candidate-administration', 'criteria-check-administration', 'interview-done', 'interview-record', 'subject', 'ads', 'jd', 'list-candidate-pen', 'list-candidate-pass', 'candidate', 'view-mark',
                            //akademik  & panel akademik
                            'jawatankuasa', 'list-candidate', 'list-candidate-wait', 'list-candidate-kiv', 'list-candidate-jawatankuasa', 'view-cv', 'download-cv', 'criteria-check', 'list-candidate-iv',
                            //panel pentadbiran
                            'interview', 'assign-subject', 'competency', 'jawatankuasa-pentadbiran', 'list-candidate-filter',
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['IN', 'access', [2, 5, 6, 7, 8, 9, 10]])->one();
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//admin pengesahan jawatan
                        'actions' => ['view-cv', 'download-cv'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $tmp = \app\models\pengesahan\TblAdmin::find()->one();
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                    [//admin lantikan pentadbiran
                        'actions' => ['view-cv', 'download-cv'],
                        'allow' => true,
                        'matchCallback' => function () {
                            $temp = \app\models\pengesahan\TblAccessCanselori::find()->one();
                            return (is_null($tmp)) ? false : true;
                        }
                    ],
                ],
            ],
        ];
    }

    public function notifikasi($icno, $content) {
        //--------Model Notification-----------//
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $icno;
        $ntf->title = 'CVOnline';
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        //--------Model Notification-----------//
    }

    public function ICNO() {
        return Yii::$app->user->getId();
    }

    public function UID() {
        $model = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()]);

        return $model ? $model->ICNO : '';
    }

    public function findBiodata($ICNO) {
        $encryptID = 'SELECT * FROM hronline.tblprcobiodata WHERE SHA1(ICNO) =:icno';
        return Tblprcobiodata::findBySql($encryptID, [':icno' => $ICNO])->one();
    }

    public function findApplicationUser($ICNO) {
        return TblPermohonan::findOne(['ICNO' => $ICNO]);
    }

    public function findPengguna($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }

//    public function findGred($id) {
//        $model = TblAds::find()->where(['cv_ads.id'=>$id])
//                ->join('jawatan')->select('gredjawatan.fname')->one();
//        
//        return $model->fname;
//    } 

    public function actionPanelHome() {
        if (TblAccess::isAdminPanel()) {
            return $this->redirect(['interview']);
        } elseif (TblAccess::isAdminPanelTapisan()) {
            return $this->redirect(['jawatankuasa']);
        }
    }

    public function actionSearch() {

        $searchModel = new BiodataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, [1, 2]);

        return $this->render('a_search', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearchJfpiu() {
        $searchModel = new BiodataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, [2]);

        return $this->render('pen_view_qualified_kriteria', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewCv($id, $title) {
        if (TblAccess::isExternalUner()) {
            $this->layout = 'main-jawatankuasa';
        }

        if (TblAccess::checkAccess() == true) {
            $biodata = $this->findBiodata($id);
        } else {
            if ($id == sha1(Yii::$app->user->getId())) {
                $biodata = $this->findBiodata($id);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'Access Denied.']);
                return $this->redirect(['selfhealth/index']);
            }
        }

        if ($title == 'personal') {
            $layout = 'u_1_personal';
        } elseif ($title == 'teaching') {
            $layout = 'u_2_teaching';
        } elseif ($title == 'supervisory') {
            $layout = 'u_3_supervisory';
        } elseif ($title == 'research') {
            $layout = 'u_4_research';
        } elseif ($title == 'publication') {
            $layout = 'u_5_publication';
        } elseif ($title == 'conferences') {
            $layout = 'u_6_conferences';
        } elseif ($title == 'consultancy') {
            $layout = 'u_7_consultancy';
        } elseif ($title == 'services') {
            $layout = 'u_8_services';
        } elseif ($title == 'esteem') {
            $layout = 'u_9_esteem';
        } elseif ($title == 'blended') {
            $layout = 'u_10_blended';
        } elseif ($title == 'designer') {
            $layout = 'u_11_designer';
        } elseif ($title == 'innovation') {
            $layout = 'u_12_innovation';
        } elseif ($title == 'innovation_it') {
            $layout = 'u_13_innovation_it';
        }

        return $this->render($layout, [
                    'biodata' => $biodata,
        ]);
    }

    public function findPdf($content) {
        // setup kartik\mpdf\Pdf component
        $data = new Pdf([
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
            // set mPDF properties on the fly
            'options' => ['title' => ''],
            // call mPDF methods on the fly 
            'marginTop' => 25,
            'marginLeft' => 24,
            'marginRight' => 24,
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => [''],
                'WriteHTML' => ['']
            ]
        ]);

        return $data;
    }

    public function actionDownloadResume($id) {
        $biodata = $this->findBiodata($id);

        $content = $this->renderPartial('u_resume', ['biodata' => $biodata]);

        $pdf = $this->findPdf($content);

        return $pdf->render();
    }

    public function actionDownloadCv($id, $gred_id) {
        $biodata = $this->findBiodata($id);

        if ($biodata->jawatan->job_category == 1) {
            $gred = TblPermohonan::findJawatan($gred_id);
        } else {
            $ads = TblAds::findOne(['id' => $gred_id]);
            $gred = TblPermohonan::findJawatan($ads->gred_id);
        }

        $model = TblAppinfo::findOne(['ICNO' => $biodata->ICNO]);
        $content = $this->renderPartial('u_cover_letter', ['biodata' => $biodata, 'model' => $model, 'gred' => $gred]);

        $pdf = $this->findPdf($content);

        return $pdf->render();
    }

    public function actionDownloadSummaryCv($id) {
        $biodata = $this->findBiodata($id);

        $content = $this->renderPartial('u_curriculum_vitae', ['biodata' => $biodata]);

        $pdf = $this->findPdf($content);

        return $pdf->render();
    }

    public function actionAnnouncement() {
        $model = $this->Grid(TblAds::find()->joinWith('jawatanCv')->where(['IN', 'cv_ads.id', TblAds::findActiveAds()])->orderBy(['cv_gredjawatan.gred' => SORT_ASC]));

        return $this->render('u_announcement', [
                    'model' => $model,
        ]);
    }

    public function actionResumeEdit() {
        if ($this->checkActiveApplication()) {
            return $this->checkActiveApplication();
        }

        $check = TblAppinfo::findOne(['ICNO' => $this->ICNO()]);

        if ($check) {
            $model = $check;
        } else {
            $model = new TblAppinfo();
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->sahHarta) {
                $model->harta_status = 1;
                $model->harta_date = $model->sahHarta->ADDeclDt;
            }
            if (empty($check)) {
                $model->fid = md5(uniqid(rand(), true));
                $model->ICNO = $this->ICNO();
            }
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'saved.']);
            return $this->redirect(['resume-edit']);
        }

        return $this->render('u_cv_edit', [
                    'model' => $model,
                    'pengguna' => $this->findPengguna($this->ICNO()),
        ]);
    }

    public function actionHeadLetter($icno) {
        $ic = $this->findBiodata($icno);
        $model = TblAppinfo::findOne(['ICNO' => $ic->ICNO]);

        return $this->render('u_cv_edit_view', [
                    'model' => $model,
                    'pengguna' => $this->findPengguna($this->ICNO()),
        ]);
    }

    public function actionServicesUniversity() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblSwUniversity();
        $record = TblSwUniversity::findAll(['ICNO' => $this->ICNO()]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'saved.']);
            return $this->redirect(['services-university']);
        }

        return $this->render('u_cv_form_university', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionServicesCommunity() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblSwSociety();
        $record = TblSwSociety::findAll(['ICNO' => $this->ICNO()]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'saved.']);
            return $this->redirect(['services-community']);
        }

        return $this->render('u_cv_form_community', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionEditServices($id, $title) {
        if ($title == 'services-university') {
            $model = TblSwUniversity::findOne(['fid' => $id]);
            $record = TblSwUniversity::findAll(['ICNO' => $this->ICNO()]);
            $layout = 'u_cv_form_university';
        } elseif ($title == 'services-community') {
            $model = TblSwSociety::findOne(['fid' => $id]);
            $record = TblSwSociety::findAll(['ICNO' => $this->ICNO()]);
            $layout = 'u_cv_form_community';
        } elseif ($title == 'esteem-leadership') {
            $model = TblPanel::findOne(['fid' => $id]);
            $record = TblPanel::find()->where(['ICNO' => $this->ICNO()])->andWhere(['!=', 'type', 13])->all();
            $layout = 'u_cv_form_esteem_lead';
        } elseif ($title == 'thesis-examiner') {
            $model = TblPanel::findOne(['fid' => $id]);
            $record = TblPanel::find()->where(['ICNO' => $this->ICNO()])->andWhere(['type' => 13])->all();
            $layout = 'u_cv_form_thesis_examiner';
        } elseif ($title == 'innovation') {
            $model = TblInnovation::findOne(['id' => $id]);
            $record = $this->grid(TblInnovation::find()->where(['ICNO' => $this->ICNO()])->orderBy(['year' => SORT_DESC]));
            $layout = 'u_cv_form_innovation';
        } elseif ($title == 'skills') {
            $model = TblSkills::findOne(['id' => $id]);
            $record = $this->grid(TblSkills::find()->where(['ICNO' => $this->ICNO()]));
            $layout = 'u_cv_form_skills';
        } elseif ($title == 'activities-other') {
            $model = TblActivitiesOther::findOne(['id' => $id]);
            $record = $this->grid(TblActivitiesOther::find()->where(['ICNO' => $this->ICNO()])->orderBy(['date' => SORT_DESC]));
            $layout = 'u_cv_form_activities_other';
        } elseif ($title == 'income') {
            $model = TblIncome::findOne(['id' => $id]);
            $record = $this->grid(TblIncome::find()->where(['ICNO' => $this->ICNO()])->orderBy(['genincome_date' => SORT_DESC]));
            $layout = 'u_cv_form_income';
        } elseif ($title == 'sports') {
            $model = TblSports::findOne(['id' => $id]);
            $record = $this->grid(TblSports::find()->where(['ICNO' => $this->ICNO()])->orderBy(['orgculsports_date' => SORT_DESC]));
            $layout = 'u_cv_form_sports';
        } elseif ($title == 'paper-work') {
            $model = TblPaperwork::findOne(['id' => $id]);
            $record = $this->grid(TblPaperwork::find()->where(['ICNO' => $this->ICNO()])->orderBy(['paperwork_date' => SORT_DESC]));
            $layout = 'u_cv_form_paper_work';
        } elseif ($title == 'research') {
            $model = TblResearchV2::findOne(['id' => $id]);
            $record = $this->grid(TblResearchV2::find()->where(['ICNO' => $this->ICNO()])->orderBy(['start_date' => SORT_DESC]));
            $layout = 'u_cv_form_research';
        } elseif ($title == 'publication') {
            $model = TblPublication::findOne(['id' => $id]);
            $record = $this->grid(TblPublication::find()->where(['ICNO' => $this->ICNO()])->orderBy(['year' => SORT_DESC]));
            $layout = 'u_cv_form_publication';
        } elseif ($title == 'conferences') {
            $model = TblConferences::findOne(['id' => $id]);
            $record = $this->grid(TblConferences::find()->where(['ICNO' => $this->ICNO()])->orderBy(['start_date' => SORT_DESC]));
            $layout = 'u_cv_form_conferences';
        }elseif ($title == 'stewardship') {
            $model = TblStewardship::findOne(['id' => $id]);
            $record = $this->grid(TblStewardship::find()->where(['ICNO' => $this->ICNO()])->orderBy(['date' => SORT_DESC]));
            $layout = 'u_cv_form_stewardship';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'updated/dikemaskini.']);
            return $this->redirect([$title]);
        }

        return $this->render($layout, [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionEsteemLeadership() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblPanel();
        $record = TblPanel::find()->where(['ICNO' => $this->ICNO()])->andWhere(['!=', 'type', 13])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'saved.']);
            return $this->redirect(['esteem-leadership']);
        }

        return $this->render('u_cv_form_esteem_lead', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionThesisExaminer() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblPanel();
        $record = TblPanel::find()->where(['ICNO' => $this->ICNO()])->andWhere(['type' => 13])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'saved.']);
            return $this->redirect(['thesis-examiner']);
        }

        return $this->render('u_cv_form_thesis_examiner', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionJobDetails() {
        return $this->render('u_cv_form_job_details');
    }

    public function actionInnovation() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblInnovation();
        $record = $this->grid(TblInnovation::find()->where(['ICNO' => $this->ICNO()])->orderBy(['year' => SORT_DESC]));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['innovation']);
        }

        return $this->render('u_cv_form_innovation', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionSkills() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblSkills();
        $record = $this->grid(TblSkills::find()->where(['ICNO' => $this->ICNO()]));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['skills']);
        }

        return $this->render('u_cv_form_skills', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionActivitiesOther() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblActivitiesOther();
        $record = $this->grid(TblActivitiesOther::find()->where(['ICNO' => $this->ICNO()])->orderBy(['date' => SORT_DESC]));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['activities-other']);
        }

        return $this->render('u_cv_form_activities_other', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionIncome() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblIncome();
        $record = $this->grid(TblIncome::find()->where(['ICNO' => $this->ICNO()])->orderBy(['genincome_date' => SORT_DESC]));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['income']);
        }

        return $this->render('u_cv_form_income', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionSports() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblSports();
        $record = $this->grid(TblSports::find()->where(['ICNO' => $this->ICNO()])->orderBy(['orgculsports_date' => SORT_DESC]));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['sports']);
        }

        return $this->render('u_cv_form_sports', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionResearch() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblResearchV2();
        $record = $this->grid(TblResearchV2::find()->where(['ICNO' => $this->ICNO()])->andWhere(['deleted' => 0])->orderBy(['start_date' => SORT_DESC]));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['research']);
        }

        return $this->render('u_cv_form_research', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionPublication() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblPublication();
        $record = $this->grid(TblPublication::find()->where(['ICNO' => $this->ICNO()])->andWhere(['deleted' => 0])->orderBy(['year' => SORT_DESC]));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['publication']);
        }

        return $this->render('u_cv_form_publication', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionConferences() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblConferences();
        $record = $this->grid(TblConferences::find()->where(['ICNO' => $this->ICNO()])->andWhere(['deleted' => 0])->orderBy(['start_date' => SORT_DESC]));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['conferences']);
        }

        return $this->render('u_cv_form_conferences', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionStewardship() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblStewardship();
        $record = $this->grid(TblStewardship::find()->where(['ICNO' => $this->ICNO()])->andWhere(['deleted' => 0])->orderBy(['date' => SORT_DESC]));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['stewardship']);
        }

        return $this->render('u_cv_form_stewardship', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionPaperWork() {
//        if ($this->checkActiveApplication()) {
//            return $this->checkActiveApplication();
//        }

        $model = new TblPaperwork();
        $record = $this->grid(TblPaperwork::find()->where(['ICNO' => $this->ICNO()])->orderBy(['paperwork_date' => SORT_DESC]));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['paper-work']);
        }

        return $this->render('u_cv_form_paper_work', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionDelete($id, $title) {

        if ($title == 'services-university') {
            $model = TblSwUniversity::findOne(['fid' => $id]);
            $model->delete();
        }
        if ($title == 'services-community') {
            $model = TblSwSociety::findOne(['fid' => $id]);
            $model->delete();
        }
        if ($title == 'esteem-leadership' || $title == 'thesis-examiner') {
            $model = TblPanel::findOne(['fid' => $id]);
            $model->delete();
        }
        if ($title == 'job-details') {
            $model = TblJobdetails::findOne(['id' => $id]);
            $model->delete();
        }
        if ($title == 'innovation') {
            $model = TblInnovation::findOne(['id' => $id]);
            $model->delete();
        }
        if ($title == 'skills') {
            $model = TblSkills::findOne(['id' => $id]);
            $model->delete();
        }
        if ($title == 'activities-other') {
            $model = TblActivitiesOther::findOne(['id' => $id]);
            $model->delete();
        }
        if ($title == 'income') {
            $model = TblIncome::findOne(['id' => $id]);
            $model->delete();
        }
        if ($title == 'sports') {
            $model = TblSports::findOne(['id' => $id]);
            $model->delete();
        }
        if ($title == 'paper-work') {
            $model = TblPaperwork::findOne(['id' => $id]);
            $model->delete();
        }
        if ($title == 'research') {
            $model = TblResearchV2::findOne(['id' => $id]);
            $model->deleted = 1;
            $model->save();
        }
        if ($title == 'publication') {
            $model = TblPublication::findOne(['id' => $id]);
            $model->deleted = 1;
            $model->save();
        }
        if ($title == 'conferences') {
            $model = TblConferences::findOne(['id' => $id]);
            $model->deleted = 1;
            $model->save();
        } 
        if ($title == 'stewardship') {
            $model = TblStewardship::findOne(['id' => $id]);
            $model->deleted = 1;
            $model->save();
        }

        Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'deleted/dipadam.']);
        return $this->redirect([$title]);
    }

    public function actionResumeCv() {
        $biodata = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()]);

        return $this->render('u_1_personal', [
                    'biodata' => $biodata,
        ]);
    }

    public function actionCriteria($id) {
        $model = $this->findBiodata($id);

        return $this->render('a_criteria_khusus', [
                    'model' => $model
        ]);
    }

    public function preChecking() {
        $checking = $this->findPengguna($this->ICNO());
        $jobGroup = GredJawatan::findOne(['id' => $checking->gredJawatan]);

        if ($jobGroup) {
            if ($jobGroup->svc == 2) {
                if (empty(TblAds::findActiveAds())) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'No promotion applications are currently open.']);
                    return $this->redirect(['announcement']);
                }

                if (empty(TblAppinfo::openPromotion())) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'You are not qualified to apply current open promotion.']);
                    return $this->redirect(['announcement']);
                }

                if (TblPermohonan::findActiveApplication()) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'You have an active application.']);
                    return $this->redirect(['record-application']);
                }
            } else {//academic
                if (TblPermohonan::findActiveApplication()) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'You have an active application.']);
                    return $this->redirect(['record-application']);
                }
            }
        }

        if (empty($checking->usercv)) {
            Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'Please complete your Application Information.']);
            return $this->redirect(['resume-edit']);
        }
    }

    public function checkActiveApplication() {
        if (TblPermohonan::findActiveApplication()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'You have an active application.']);
            return $this->redirect(['record-application']);
        }
    }

    public function actionApplication() {

        if ($this->preChecking()) {
            return $this->preChecking();
        }
        $model = new TblPermohonan();

        $biodata = $this->findBiodata(sha1($this->ICNO()));

        if ($model->load(Yii::$app->request->post())) {
            if ($model->ads_id) {
                if ($model->ads_id == 265 && empty($model->status_pakar)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'Please select expertise status.']);
                    return $this->redirect(['application']);
                } else {
                    return $this->redirect(['application-checking', 'gred' => $model->ads_id, 'pakar' => $model->status_pakar]);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'Please select position to apply.']);
                return $this->redirect(['application']);
            }
        }

        return $this->render('u_application', [
                    'model' => $model,
                    'biodata' => $biodata,
        ]);
    }

    public function actionApplicationChecking($gred, $pakar = null) {
        $model = $this->findBiodata(sha1($this->ICNO()));
        $jawatan = GredJawatan::findOne(['id' => $gred]);

        if (in_array($jawatan->gred, ['DS54', 'DS52', 'DG44', 'DG48', 'DG52', 'DU51', 'DU56'])) {//'DU56'
            $layout = 'u_application_' . $jawatan->gred;
        } elseif ($jawatan->gred == 'DU54') {
            if ($jawatan->id == 265) { //tanpa gelaran
                $layout = 'u_application_' . $jawatan->gred . '_noTitle';
            } elseif ($jawatan->id == 19) {//pakar
                $layout = 'u_application_' . $jawatan->gred;
            }
        } elseif ($jawatan->gred == 'VK7') {
            if ($jawatan->id == 18) { //VK7U
                $layout = 'u_application_' . $jawatan->gred . '_u';
            } elseif ($jawatan->id == 10) {//VK7
                $layout = 'u_application_' . $jawatan->gred;
            }
        } else {
            $layout = 'u_application_pen';
        }


        return $this->render($layout, [
                    'model' => $model,
                    'jawatan' => $jawatan,
                    'pakar' => $pakar,
        ]);
    }

    public function actionSelfCheck($gred, $pakar = null) {
        $model = $this->findBiodata(sha1($this->ICNO()));
        $jawatan = GredJawatan::findOne(['id' => $gred]);

        if (in_array($jawatan->gred, ['VK7', 'DS54', 'DS52', 'DG44', 'DG48', 'DG52', 'DU51', 'DU56'])) {//'DU56'
            $layout = 'u_application_' . $jawatan->gred;
        } elseif ($jawatan->gred == 'DU54') {
            if ($jawatan->id == 265) { //tanpa gelaran
                $layout = 'u_application_' . $jawatan->gred . '_noTitle';
            }
        }

        return $this->render($layout, [
                    'model' => $model,
                    'jawatan' => $jawatan,
                    'pakar' => $pakar,
        ]);
    }

    public function actionSearchCandidate() {
        $model = new Tblprcobiodata();
        $user = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->ICNO) {
                if ($model->gredJawatan) {
                    if ($model->gredJawatan == 265 && empty($model->status_pakar)) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'Pilih Status Keparan.']);
                        return $this->redirect(['search-candidate']);
                    } else {
                        return $this->redirect(['criteria-check', 'gred' => $model->gredJawatan, 'icno' => sha1($model->ICNO), 'pakar' => $model->status_pakar]);
                    }
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'Pilih Jawatan.']);
                    return $this->redirect(['search-candidate']);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'Pilih Nama.']);
                return $this->redirect(['search-candidate']);
            }
        }

        return $this->render('a_form_search_candidate', [
                    'model' => $model,
                    'user' => $user,
        ]);
    }

    public function actionCriteriaCheck($gred, $icno, $pakar = null) {
        if (TblAccess::isExternalUner()) {
            $this->layout = 'main-jawatankuasa';
        }

        $model = $this->findBiodata($icno);
        $jawatan = GredJawatan::findOne(['id' => $gred]);

        //checking exist requirement

        if (in_array($jawatan->gred, ['VK7', 'DS54', 'DS52', 'DG44', 'DG48', 'DG52', 'DU56', 'DU54', 'DU51'])) {
            if ($jawatan->id == 18) { //VK7 PERUBATAN
                $layout = 'a_application_' . $jawatan->gred . '_u';
            } elseif ($jawatan->id == 265) { //DU54 tanpa gelaran
                $layout = 'a_application_' . $jawatan->gred . '_noTitle';
            } else {
                $layout = 'a_application_' . $jawatan->gred;
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'No criteria.']);
            return $this->redirect(['search-candidate']);
        }


        return $this->render($layout, [
                    'model' => $model,
                    'jawatan' => $jawatan,
                    'pakar' => $pakar,
        ]);
    }

    public function actionSearchCandidateAdministration() {
        $model = new Tblprcobiodata();
        $user = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->ICNO) {
                return $this->redirect(['criteria-check-administration', 'icno' => sha1($model->ICNO)]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'Pilih Nama.']);
                return $this->redirect(['search-candidate-administration']);
            }
        }

        return $this->render('a_form_search_candidate_administration', [
                    'model' => $model,
                    'user' => $user,
        ]);
    }

    public function actionCriteriaCheckAdministration($icno) {
        if (TblAccess::isExternalUner()) {
            $this->layout = 'main-jawatankuasa';
        }
        $model = $this->findBiodata($icno);
        return $this->render('a_application_administration', [
                    'model' => $model,
        ]);
    }

    public function actionRecordApplication() {
        $model = TblPermohonan::find()->where(['ICNO' => $this->ICNO()])->all();
        $status = RefStatus::find()->all();
        return $this->render('u_application_record', [
                    'model' => $model,
                    'status' => $status
        ]);
    }

    public function actionAppsubmit($id, $status, $peraku = null, $stpakar = null) {
        $biodata = $this->findPengguna($this->ICNO());
        $check = TblPermohonan::find()->where(['ICNO' => $biodata->ICNO])->one();
        $url = 'cv/kj';
        if (!is_null($peraku)) { //pentadbiran (pilih pegawai peraku) 
            $chief = $peraku;
        } else { // akademik 
            $dept = Department::findOne(['id' => $biodata->DeptId_hakiki]);
            if ($dept->chief == $biodata->ICNO) {
                $chief = '680114125023';
            } else {
                $chief = $dept->chief;
            }
        }
        $content = "Perakuan Kenaikan Pangkat menunggu tindakan anda. " . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', [$url], ['class' => 'btn btn-primary btn-sm']);

        if ($status != 1) {
            Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'You do not fulfill the criteria.']);
            return $this->redirect(['application']);
        } else if ($check) {
            if ($check->isActive == 1) {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'You have an active application.']);
                return $this->redirect(['record-application']);
            } else {
                $this->notifikasi($chief, $content);
                $biodata->usercv->submitApplication($id, $peraku, $stpakar);
                return $this->redirect(['record-application']);
            }
        } else {
            $this->notifikasi($chief, $content);
            $biodata->usercv->submitApplication($id, $peraku, $stpakar);
            return $this->redirect(['record-application']);
        }
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

    public function actionAddAds() {
        $model = new TblAds();

        if ($model->load(Yii::$app->request->post())) {
            $start = $model->StartDate;
            $end = $model->EndDate;
            foreach ($model->jawatan as $arr) {
                $add = new TblAds();
                $add->gred_id = $arr;
                $add->StartDate = $start;
                $add->EndDate = $end;
                $add->save();
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'add.']);
            return $this->redirect(['ads']);
        }

        return $this->renderAjax('a_form_ads', [
                    'model' => $model,
                    'jawatan' => NULL,
        ]);
    }

    public function actionEditAds($id) {
        $model = TblAds::findOne(['id' => $id]);
        $model->jawatan[] = $model->gred_id;
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'updated.']);
            return $this->redirect(['ads']);
        }

        return $this->renderAjax('a_form_ads', [
                    'model' => $model,
                    'jawatan' => TblAds::findJawatan([$model->gred_id]),
        ]);
    }

    public function actionDeleteAds($id) {
        $model = TblAds::findOne(['id' => $id]);
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'deleted.']);
        return $this->redirect(['ads']);
    }

    public function actionAds() {
        $query = TblAds::find()->joinWith('jawatanCv')->where(['cv_ads.isActive' => 1])->orderBy(['cv_gredjawatan.gred' => SORT_ASC]);
        $model = $this->Grid($query);

        return $this->render('a_ads', [
                    'model' => $model,
        ]);
    }

    public function actionApplications() {

        if (TblAccess::isAdminAcademic()) {
            $model = $this->Grid(TblPermohonan::findAppAc());
            $layout = 'a_applications_ac';
        } else if (TblAccess::isAdminNonAcademic()) {
            $model = $this->Grid(TblAds::findAds());
            $layout = 'a_applications_pen';
        }
        return $this->render($layout, [
                    'model' => $model,
        ]);
    }

    public function actionApplicationsContract() {
        $model = $this->Grid(TblPermohonan::findAppAcContract());

        return $this->render('a_applications_ac_contract', [
                    'model' => $model,
        ]);
    }

    public function actionOffIklan($id) {
        $model = TblAds::findOne(['id' => $id]);
        $model->isActive = 0;
        $model->save(false);

        Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'success.']);
        return $this->redirect(['applications']);
    }

    public function actionJawatankuasaPentadbiran() {
        $check = TblPerakuanPanel::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['date' => date('Y-m-d')])->andWhere(['access' => TblAccess::getAksesPentadbiran()])->one();
        if ($check) {
            $model = $this->Grid(TblAds::findAdsbySkim());

            $active = \app\models\cv\StatusTapisan::find()->where(['status' => 1])->andWhere(['category' => 2])->one();
            $status = 0;
            $title = '';
            if ($active) {
                $status = $active->status;
                $title = $active->title;
            }

            return $this->render('a_jawatankuasa_pentadbiran', [
                        'model' => $model,
                        'status' => $status,
                        'title' => $title,
            ]);
        } else {
            return $this->redirect(['halaman-perakuan-panel']);
        }
    }

    public function actionHalamanPerakuanPanel() {
        $model = new TblPerakuanPanel();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'disimpan.']);
            if (TblAccess::getAksesPentadbiran() == 6) {
                return $this->redirect(['assign-subject']);
            } else {
                return $this->redirect(['jawatankuasa-pentadbiran']);
            }
        }

        return $this->render('pen_perakuan_panel', [
                    'model' => $model,
        ]);
    }

    public function actionTolakPerakuan() {

        return $this->render('pen_perakuan_tolak');
    }

    public function actionJawatankuasa() {

        if (TblAccess::isExternalUner()) {
            $this->layout = 'main-jawatankuasa';
        }

        $ads = TblPenilaianJawatan::find()->select('gred_id')->distinct();
        $model = $this->Grid(TblPermohonan::findAppAcPanel($ads));

        $active = \app\models\cv\StatusTapisan::find()->where(['status' => 1])->andWhere(['category' => 1])->one();
        $status = 0;
        $title = '';
        if ($active) {
            $status = $active->status;
            $title = $active->title;
        }

        return $this->render('a_jawatankuasa', [
                    'model' => $model,
                    'status' => $status,
                    'title' => $title,
        ]);
    }

    public function actionListCandidateJawatankuasa($gred) {
        if (TblAccess::isExternalUner()) {
            $this->layout = 'main-jawatankuasa';
        }
        $ICNO = array();
        $wait = TblPermohonan::WaitingList($gred);
        $verify = TblPermohonan::VerifyList($gred);
        $kiv = TblPermohonan::VerifyKivList($gred);

        foreach ($wait as $wait) {
            $ICNO[] = $wait->ICNO;
        }
        foreach ($verify as $verify) {
            $ICNO[] = $verify->ICNO;
        }
        foreach ($kiv as $kiv) {
            $ICNO[] = $kiv->ICNO;
        }

        $record = $this->Grid(Tblprcobiodata::find()->where(['IN', 'ICNO', $ICNO]));
        return $this->render('a_list_candidate_jawatankuasa', [
                    'record' => $record,
                    'gred' => GredJawatan::findOne(['id' => $gred]),
        ]);
    }

    public function actionAddContent() {

        $model = new TblPenilaianJawatan();
        $record = $this->Grid(TblPenilaianJawatan::find());

        if ($model->load(Yii::$app->request->post())) {

            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'success.']);
            return $this->redirect(['add-content']);
        }

        return $this->render('a_add_content', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionDeleteContent($id) {

        $model = TblPenilaianJawatan::find()->where(['id' => $id])->one();
        $model->delete();

        Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'deleted.']);
        return $this->redirect(['add-content']);
    }

    public function actionAddCandidateKiv($gred) {

        $model = new TblCandidateKiv();
        $record = $this->Grid(TblCandidateKiv::find()->where(['jawatan_id' => $gred, 'active' => 1])->orderBy(['added_at' => SORT_DESC]));

        if ($model->load(Yii::$app->request->post())) {

            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'success.']);
            return $this->redirect(['add-candidate-kiv', 'gred' => $gred]);
        }

        return $this->render('a_candidate_kiv', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionDeleteCandidateKiv($id) {

        $model = TblCandidateKiv::find()->where(['id' => $id, 'active' => 1])->orderBy(['added_at' => SORT_DESC])->one();

        $gred = $model->jawatan_id;
        $model->active = 0;
        $model->save(false);

        Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'deleted.']);
        return $this->redirect(['add-candidate-kiv', 'gred' => $gred]);
    }

    public function actionAddKiv() {

        $model = new TblCandidateKiv();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->jawatan_id) {
                return $this->redirect(['add-candidate-kiv', 'gred' => $model->jawatan_id]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'please select position']);
                return $this->redirect(['add-kiv']);
            }
        }

        return $this->renderAjax('a_add_kiv', [
                    'model' => $model,
        ]);
    }

    public function actionFileTapisan() {

        $tapisan = new TblFileTapisan();
        $record = $this->Grid(TblFileTapisan::find()->orderBy(['added_at' => SORT_DESC]));

        if ($tapisan->load(Yii::$app->request->post())) {
            $tapisan->file1 = UploadedFile::getInstance($tapisan, ('file1'));
            if ($tapisan->file1) {

                $res = Yii::$app->FileManager->UploadFile($tapisan->file1->name, $tapisan->file1->tempName, '04', 'cv/tapisan');
                if ($res->status == true) {
                    $tapisan->file = $res->file_name_hashcode;
                    $tapisan->save();
                    Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'success.']);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Sorry!', 'type' => 'error', 'msg' => 'File can`t be uploaded.']);
                    return $this->redirect(['file-tapisan']);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry!', 'type' => 'error', 'msg' => 'File can`t be uploaded.']);
                return $this->redirect(['file-tapisan']);
            }
        }

        return $this->render('a_file_tapisan', [
                    'tapisan' => $tapisan,
                    'record' => $record,
        ]);
    }

    public function actionAktifJawatankuasa() {

        return $this->renderAjax('a_aktif_jawatankuasa', [
        ]);
    }

    public function actionStatusTapisan($id) {

        $btn = StatusTapisan::findOne(['id' => $id]);
        if ($btn->status == 1) {
            $btn->status = 0;
            $msg = 'Off.';
        } else {
            $btn->status = 1;
            $msg = 'Active.';
        }

        $btn->save(false);
        Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => $msg]);
        return $this->redirect(['applications']);
    }

    public function actionPdf($id, $title) {

        if ($title == 'Tapisan') {
            $model = TblFileTapisan::find()->where(['id' => $id])->orderBy(['added_at' => SORT_DESC])->one();
            $completePath = Yii::getAlias('@app/web/uploads-cv/tapisan/' . $model->file);
            return Yii::$app->response->sendFile($completePath, $model->file, ['inline' => false]);
        }
    }

    public function actionListCandidate($id, $status) {
        if (TblAccess::isExternalUner()) {
            $this->layout = 'main-jawatankuasa';
        }

        if (TblAccess::isAdminAcademic() || TblAccess::isAdminPanelTapisan() || TblAccess::isAdminPanelPemilih() || TblAccess::isExternalUner()) {
            $gred = TblPermohonan::findJawatan($id);
        } else {
            $ads = TblAds::findOne(['id' => $id]);
            $gred = TblPermohonan::findJawatan($ads->gred_id);
        }
        $Verify = $this->Grid(TblPermohonan::AdminView(2, $id, $status));

        return $this->render('a_list_candidate', [
                    'Verify' => $Verify,
                    'gred' => $gred,
        ]);
    }

    public function actionListCandidateContract($id, $status) {
        if (TblAccess::isAdminAcademic() || TblAccess::isAdminPanelTapisan() || TblAccess::isAdminPanelPemilih() || TblAccess::isExternalUner()) {

            $gred = TblPermohonan::findJawatan($id);
            $Verify = $this->Grid(TblPermohonan::AdminViewContract(2, $id, $status));
        }
        return $this->render('a_list_candidate', [
                    'Verify' => $Verify,
                    'gred' => $gred,
        ]);
    }

    public function actionListCandidatePen($id, $status) { // use for pentadbiran only
        if (TblAccess::isAdminNonAcademic() || TblAccess::isAdminPanelTapisanPen() || TblAccess::isAdminPanelPemilihPen()) {
            $ads = TblAds::findOne(['id' => $id]);
            $gred = TblPermohonan::findJawatan($ads->gred_id);
        }
        $Verify = $this->Grid(TblPermohonan::KjVerified($id, $status));

        return $this->render('a_list_candidate_pen', [
                    'Verify' => $Verify,
                    'gred' => $gred,
        ]);
    }

    public function actionListCandidateFilter($id, $status) { // use for pentadbiran only
        if (TblAccess::isAdminPanelTapisanPen() || TblAccess::isAdminPanelPemilihPen()) {
            $ads = TblAds::findOne(['id' => $id]);
            $gred = TblPermohonan::findJawatan($ads->gred_id);
        }
        $Verify = $this->Grid(TblPermohonan::DataSaringan($id, $status));

        return $this->render('a_list_candidate_pen', [
                    'Verify' => $Verify,
                    'gred' => $gred,
        ]);
    }

    public function actionListCandidateKiv($id) {
        if (TblAccess::isExternalUner()) {
            $this->layout = 'main-jawatankuasa';
        }
        $gred = TblPermohonan::findJawatan($id);
        $Verify = $this->Grid(TblCandidateKiv::find()->where(['jawatan_id' => $id, 'active' => 1])->orderBy(['added_at' => SORT_DESC]));

        return $this->render('a_list_candidate_kiv', [
                    'Verify' => $Verify,
                    'gred' => $gred,
                    'id' => $id,
        ]);
    }

    public function actionListCandidateWait($id) {
        if (TblAccess::isExternalUner()) {
            $this->layout = 'main-jawatankuasa';
        }

        if (TblAccess::isAdminAcademic() || TblAccess::isAdminPanelTapisan() || TblAccess::isAdminPanelPemilih() || TblAccess::isExternalUner()) {
            $gred = TblPermohonan::findJawatan($id);
        } else {
            $ads = TblAds::findOne(['id' => $id]);
            $gred = TblPermohonan::findJawatan($ads->gred_id);
        }


        $Verify = $this->Grid(TblPermohonan::AdminViewWait(1, $id));

        return $this->render('a_list_candidate_waiting', [
                    'Verify' => $Verify,
                    'gred' => $gred,
        ]);
    }

    public function actionListCandidateWaitContract($id) {
        if (TblAccess::isAdminAcademic() || TblAccess::isAdminPanelTapisan() || TblAccess::isAdminPanelPemilih() || TblAccess::isExternalUner()) {
            $gred = TblPermohonan::findJawatan($id);

            $Verify = $this->Grid(TblPermohonan::AdminViewWaitContract(1, $id));
        }

        return $this->render('a_list_candidate_waiting', [
                    'Verify' => $Verify,
                    'gred' => $gred,
        ]);
    }

    public function actionListCandidatePass($id) {

        $ads = TblAds::findOne(['id' => $id]);
        $gred = TblPermohonan::findJawatan($ads->gred_id);

        $Verify = $this->Grid(TblPermohonan::AdminViewPass($id));

        return $this->render('a_list_candidate_waiting', [
                    'Verify' => $Verify,
                    'gred' => $gred,
        ]);
    }

    public function actionListCandidateIv($id) {
        if (TblAccess::isAdminAcademic()) {
            $gred = TblPermohonan::findJawatan($id);
        } else {
            $ads = TblAds::findOne(['id' => $id]);
            $gred = TblPermohonan::findJawatan($ads->gred_id);
        }

        $Verify = $this->Grid(TblPermohonan::AdminViewIv(3, $id));

        return $this->render('a_list_candidate_iv', [
                    'Verify' => $Verify,
                    'gred' => $gred,
        ]);
    }

    public function actionListCandidateIvContract($id) {
        $gred = TblPermohonan::findJawatan($id);
        $Verify = $this->Grid(TblPermohonan::AdminViewIvContract(3, $id));

        return $this->render('a_list_candidate_iv', [
                    'Verify' => $Verify,
                    'gred' => $gred,
        ]);
    }

    public function actionArchiveApplicationAc() {
        $searchModel = new TblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('ac_view_archive_application', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddInterview($id) {
        //pre check
        if (TblAds::TotalWaiting($id) != 0) {
            Yii::$app->session->setFlash('alert', ['title' => 'Sorry!', 'type' => 'error', 'msg' => 'Still have waiting application.']);
            return $this->redirect(['applications']);
        }

        $exist = TemudugaPentadbiran::findOne(['ads_id' => $id]);

        if ($exist) {
            $model = $exist;
        } else {
            $model = new TemudugaPentadbiran();
        }

        $ads = TblAds::findOne(['id' => $id]);

        if ($model->load(Yii::$app->request->post())) {
            if ($exist) {
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'to update.']);
            } else {

                $model->ads_id = $id;
                $model->gred_id = $ads->gred_id;
                $model->save(false);

                $iv = TemudugaPentadbiran::findOne(['ads_id' => $id]);

                //lulus perakuan kj,lulus tapisan & lulus pemilihan
                $calonIV = TblPermohonan::find()->where(['ads_id' => $id])->andWhere(['kj_status' => 1])->andWhere(['admin_status' => 1])->all();

                $jawatan = TblPermohonan::findJawatan($ads->gred_id);
                foreach ($calonIV as $calon) {
                    $content = "You get an interview offer for " . $jawatan . '. Please check email for offer letter.';
                    $this->notifikasi($calon->ICNO, $content);

                    $new = new TblTemudugaPentadbiran();
                    $new->ICNO = $calon->ICNO;
                    $new->gred_apply = $iv->gred_id;
                    $new->isActive = 1;
                    $new->iv_id = $iv->id;
                    $new->save(false);

                    $calon->status_id = 3; // Get offer Interview.
                    $calon->save(false);
                }

                $calonReject = TblPermohonan::find()->where(['ads_id' => $id])->andWhere(['kj_status' => 2])->all();

                foreach ($calonReject as $calonReject) {
                    $content = "Sorry, your application for" . $jawatan . " has been rejected.";
                    $this->notifikasi($calonReject->ICNO, $content);
                    $calonReject->status_id = 5; // Application Failed.
                    $calonReject->save(false);
                }

                //gagal tapisan & pemilihan
                $failedTapisan = TblPermohonan::find()->where(['ads_id' => $id])->andWhere(['IN', 'admin_status', [2, 3]])->all();

                foreach ($failedTapisan as $failedTapisan) {
                    $content = "Sorry, your application for" . $jawatan . " has been rejected.";
                    $this->notifikasi($failedTapisan->ICNO, $content);
                    $calonReject->status_id = 5; // Application Failed.
                    $calonReject->save(false);
                }

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'add to interview record.']);
            }
            return $this->redirect(['applications']);
        }

        return $this->renderAjax('a_form_iv', [
                    'model' => $model,
        ]);
    }

    public function actionNotifyCandidate($id) {
        $calonPass = TblTemudugaPentadbiran::find()->where(['iv_id' => $id])->andWhere(['qualified' => 1])->all();

        $model = TemudugaPentadbiran::findOne(['id' => $id]);
        $jawatan = TblPermohonan::findJawatan($model->gred_id);
        foreach ($calonPass as $calon) {
            $content = "You passed the interview for " . $jawatan;
            $this->notifikasi($calon->ICNO, $content);

            $lulus = TblPermohonan::find()->where(['ads_id' => $model->ads_id])->andWhere(['ICNO' => $calon->ICNO])->one();
            $lulus->status_id = 4; // Application Pass.
            $lulus->isActive = 0; //close application
            $lulus->save(false);
        }

        $calonReject = TblTemudugaPentadbiran::find()->where(['iv_id' => $id])->andWhere(['qualified' => 0])->all();

        foreach ($calonReject as $calon) {
            $content = "Sorry, you failed the interview for" . $jawatan;
            $this->notifikasi($calon->ICNO, $content);

            $gagal = TblPermohonan::find()->where(['ads_id' => $model->ads_id])->andWhere(['ICNO' => $calon->ICNO])->one();
            $gagal->status_id = 5; // Application Failed.
            $gagal->isActive = 0; //close application
            $gagal->save(false);
        }

        $model->notify_status_iv = date('Y-m-d H:i:s');
        $model->save();

        Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'notify interview status.']);
        return $this->redirect(['interview-done']);
    }

    public function actionKj() {
        if (Department::find()->where(['chief' => $this->ICNO()])->andWhere(['isActive' => 1])->one()) { //
            $toVerify = $this->Grid(TblPermohonan::KjView(0));
            $doneVerify = $this->Grid(TblPermohonan::KjView([1, 2]));
            return $this->render('kj_application', [
                        'toVerify' => $toVerify,
                        'doneVerify' => $doneVerify,
            ]);
        } else {
            $toVerify = $this->Grid(TblPermohonan::OfficerView(0));
            $doneVerify = $this->Grid(TblPermohonan::OfficerView([1, 2]));
            return $this->render('kj_application', [
                        'toVerify' => $toVerify,
                        'doneVerify' => $doneVerify,
            ]);
        }
    }

    public function actionKjApproval($id) {
        $model = TblPermohonan::find()->where(['id' => $id])->one();
        if ($model->biodata->jawatan->job_category == 2) {
            $jawatan = GredJawatan::findOne(['id' => $model->ads->jawatanCv->id]);
            $admin = '811212125745';
        } else {
            $jawatan = GredJawatan::findOne(['id' => $model->ads_id]);
            $admin = '850711125215';
        }

        $biodata = $this->findBiodata(sha1($model->ICNO));

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->kj_status) && !empty($model->kj_ulasan)) {
                //candidate
                $content = "Your application for " . $jawatan->fname . ' has been verify by DEAN.';
                $this->notifikasi($model->ICNO, $content);
                //bsm
                $content = "Kenaikan Pangkat - Perakuan Baru " . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', ['cv/applications'], ['class' => 'btn btn-primary btn-sm']);

                $this->notifikasi($admin, $content);

                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => '']);
                return $this->redirect(['kj']);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'please select status & fill in comment section']);
                return $this->redirect(['kj-approval', 'id' => $id]);
            }
        }

        return $this->render('kj_approval', [
                    'model' => $model,
                    'biodata' => $biodata,
        ]);
    }

    public function actionKjComment($id) {
        $model = TblPermohonan::find()->where(['id' => $id])->one();

        $biodata = $this->findBiodata(sha1($model->user->ICNO));

        return $this->renderAjax('kj_comment', [
                    'model' => $model,
                    'biodata' => $biodata,
        ]);
    }

    public function actionDean() {

        $toVerify = $this->Grid(TblPermohonan::DeanView([0]));
        $doneVerify = $this->Grid(TblPermohonan::DeanView([1, 2]));
        return $this->render('dean_application', [
                    'toVerify' => $toVerify,
                    'doneVerify' => $doneVerify,
        ]);
    }

    public function actionDeanApproval($id) {
        $model = TblPermohonan::find()->where(['id' => $id])->one();

        if ($model->biodata->jawatan->job_category == 2) {
            $jawatan = GredJawatan::findOne(['id' => $model->ads->jawatanCv->id]);
            $admin = '811212125745';
        } else {
            $jawatan = GredJawatan::findOne(['id' => $model->ads_id]);
            $admin = '850711125215';
        }

        $biodata = $this->findBiodata(sha1($model->user->ICNO));

        if ($model->load(Yii::$app->request->post())) {

            if ($model->kj_status) {
                //candidate
                $content = "Your application for " . $jawatan->fname . ' has been verify by DEAN.';
                $this->notifikasi($model->ICNO, $content);
                //bsm
                $content = "Kenaikan Pangkat - Perakuan Baru " . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', ['cv/applications'], ['class' => 'btn btn-primary btn-sm']);
                $this->notifikasi($admin, $content); //en Razmi

                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => '']);
                return $this->redirect(['dean']);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'please select status']);
                return $this->redirect(['dean-approval', 'id' => $id]);
            }
        }

        return $this->render('dean_approval', [
                    'model' => $model,
                    'biodata' => $biodata,
        ]);
    }

    public function actionViewCriteria($id, $gred) {
        $model = $this->findBiodata($id);
        $gredJawatan = GredJawatan::findOne(['id' => $gred]);
        $layout = 'a_view_criteria_' . $gredJawatan->gred;

        return $this->render($layout, [
                    'model' => $model,
                    'gred' => $gred,
        ]);
    }

    //pentadbiran

    public function actionLaporanPermohonanPentadbiran() {

        $permohonan = $this->Grid(TblPermohonan::find()
                        ->joinWith('biodata.jawatan')
                        ->joinWith('ads.jawatanCv')
                        ->where(['gredjawatan.job_category' => 2])
                        ->orderBy(['cv_gredjawatan.gred' => SORT_ASC])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1]));

        return $this->render('pen_laporan_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionLaporanPermohonanSandangan() {

        $m = TblPermohonan::find()
                ->joinWith('biodata.jawatan')
                ->joinWith('ads.jawatanCv')
                ->where(['gredjawatan.job_category' => 2])
                ->andWhere(['cv_tbl_permohonan.isActive' => 1])
                ->andWhere(['in', 'cv_tbl_permohonan.ads_id', [88, 90]])
                ->all();
        $icno = array();
        foreach ($m as $m) {
            $icno[] = $m->ICNO;
        }



        $permohonan = $this->Grid(\app\models\cv\TblSandanganTemp::find()
                        ->orderBy(['ICNO' => SORT_ASC, 'start_date' => SORT_ASC]));

        return $this->render('pen_laporan_permohonan_sandangan', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function actionSubject() {

        $dataProvider = $this->findAllSubject();

        return $this->render('pen_view_subject', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function findAllSubject() {
        $subjek = new ActiveDataProvider([
            'query' => \app\models\ejobs\TblpSubjek::find(),
            'pagination' => [
                'pageSize' => 40,
            ],
        ]);
        return $subjek;
    }

    public function actionViewSubject($id) {

        $subject = TblpSubjek::findOne(['id' => $id]);
        $dictSubject = StatusMarkah::find()->all();

        return $this->render('pen_view_subject_desc', [
                    'subject' => $subject,
                    'dictSubject' => $dictSubject,
        ]);
    }

    public function actionAssignSubject() {
        $check = TblPerakuanPanel::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['date' => date('Y-m-d')])->andWhere(['access' => TblAccess::getAksesPentadbiran()])->one();
        if ($check) {

            $model = new TblpSubjekPanel();
            $dataProvider = $this->findSubjectRecord();

            if ($model->load(Yii::$app->request->post())) {

                $subjek = $model->subj_id;
                $panel = $model->panel_icno;
                $datetime = $model->assign_at;
                $by = $model->assign_by;

                $jawatan = $model->jawatan_id;
                foreach ($jawatan as $jawatan) {
                    $model = new TblpSubjekPanel();
                    $model->subj_id = $subjek;
                    $model->panel_icno = $panel;
                    $model->assign_at = $datetime;
                    $model->assign_by = $by;
                    $model->jawatan_id = $jawatan;
                    $model->save();
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Success!', 'type' => 'success', 'msg' => '']);
                return $this->redirect(['assign-subject']);
            }

            return $this->render('pen_form_assign_subject', [
                        'model' => $model,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->redirect(['halaman-perakuan-panel']);
        }
    }

    public function actionDeleteAssignSubject($id) {

        $model = TblpSubjekPanel::findOne(['id' => $id]);
        $model->delete();

        Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => '']);
        return $this->redirect(['assign-subject']);
    }

    public function findSubjectRecord() {
        $subjekPanel = new ActiveDataProvider([
            'query' => TblpSubjekPanel::find()->where(['DATE(assign_at)' => date("Y-m-d")]),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => ['defaultOrder' => ['assign_at' => SORT_DESC]],
        ]);
        return $subjekPanel;
    }

    public function actionCompetency() {

        $dataProvider = $this->findAllAssignSubject();

        return $this->render('pen_view_competency', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function findAllAssignSubject() {
        $subjekPanel = new ActiveDataProvider([
            'query' => TblpSubjekPanel::find()->where(['panel_icno' => Yii::$app->user->getId()])->andWhere(['=', 'DATE(assign_at)', date("Y-m-d")]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $subjekPanel;
    }

    public function actionQuestion($id) {
        $subject = TblpSubjekPanel::findOne(['id' => $id]);
        $dataProvider = $this->findAllQuestion($subject->jawatan_id, $subject->subj_id);
        $question = new TblpQuestion();

        if ($question->load(Yii::$app->request->post())) {
            $question->jawatan_id = $subject->jawatan_id;
            $question->subj_id = $subject->subj_id;
            $question->save();
            Yii::$app->session->setFlash('alert', ['title' => 'Success!', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['question', 'id' => $id]);
        }

        return $this->render('pen_form_question', [
                    'dataProvider' => $dataProvider,
                    'question' => $question,
                    'subject' => $subject,
        ]);
    }

    public function findAllQuestion($id, $subj_id) {
        $subjekPanel = new ActiveDataProvider([
            'query' => TblpQuestion::find()->where(['jawatan_id' => $id, 'subj_id' => $subj_id]),
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]]
        ]);
        return $subjekPanel;
    }

    public function actionInterview() {
        $dataProvider = $this->findAllAssignSubject();

        return $this->render('pen_view_interview', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListIv($id) {

        $iv = TemudugaPentadbiran::findOne(['id' => $id]);

        $dataProvider = $this->findListIV($id);

        return $this->render('pen_view_interview_list', [
                    'dataProvider' => $dataProvider,
                    'iv' => $iv,
        ]);
    }

    public function findListIV($id) {

        $subjekPanel = new ActiveDataProvider([
            'query' => TblTemudugaPentadbiran::find()->where(['cv_tbl_temuduga_pentadbiran.iv_id' => $id])
                    ->leftJoin('hronline.tblprcobiodata', 'cv_tbl_temuduga_pentadbiran.ICNO = tblprcobiodata.ICNO')
                    ->orderBy(['tblprcobiodata.CONm' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $subjekPanel;
    }

    public function actionMarkIv($id) {

        $biodata = TblTemudugaPentadbiran::findOne(['id' => $id]);
        $iv = TemudugaPentadbiran::findOne(['id' => $biodata->iv_id]);
        $subject = TblpSubjekPanel::find()->where(['panel_icno' => Yii::$app->user->getId()])
                        ->andWhere(['=', 'DATE(assign_at)', date("Y-m-d")])
                        ->andWhere(['jawatan_id' => $iv->gred_id])->One();

        $dataProvider = $this->findAllQuestion($iv->gred_id, $subject->subj_id);

        $check = TblpMarkahIv::find()->where(['iv_id' => $biodata->id])
                        ->andWhere(['panel_icno' => Yii::$app->user->getId()])
                        ->andWhere(['=', 'DATE(datetime)', date("Y-m-d")])->one();
        if ($check) {
            $markah = $check;
        } else {
            $markah = new TblpMarkahIv();
        }

        if ($markah->load(Yii::$app->request->post())) {
            $markah->subj_id = $subject->subj_id;
            $markah->gred_id = $iv->gred_id;
            $markah->iv_id = $biodata->id;
            $markah->panel_ICNO = Yii::$app->user->getId();
            $markah->datetime = date("Y-m-d H:i:s");
            $markah->save();
            Yii::$app->session->setFlash('alert', ['title' => 'Success!', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['list-iv', 'id' => $iv->id]);
        }

        //info dictionary
        $dictSubject = StatusMarkah::find()->all();

        return $this->render('pen_form_mark_iv', [
                    'dataProvider' => $dataProvider,
                    'biodata' => $biodata,
                    'iv' => $iv,
                    'markah' => $markah,
                    'subject' => $subject,
                    'dictSubject' => $dictSubject,
        ]);
    }

    public function actionInterviewRecord() {
        $dataProvider = $this->findInterviewRecord('>=');

        return $this->render('pen_view_interview_record', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInterviewDone() {
        $dataProvider = $this->findInterviewRecord('<');

        return $this->render('pen_view_interview_record', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function findInterviewRecord($operator) {
        $record = new ActiveDataProvider([
            'query' => TemudugaPentadbiran::find()->where([$operator, 'tarikh_iv', date('Y-m-d')]),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);
        return $record;
    }

    public function actionQualifiedPen($id, $status, $url) {
        $model = TblTemudugaPentadbiran::findOne(['id' => $id]);
        $model->qualified = $status;
        $model->qualified_datetime = date('Y-m-d H:i:s');
        $model->qualified_by = Yii::$app->user->getId();
        $model->save();

        Yii::$app->session->setFlash('alert', ['title' => 'Success!', 'type' => 'success', 'msg' => '']);
        return $this->redirect(['candidate', 'id' => $model->iv_id, 'url' => $url]);
    }

    public function actionCandidate($id, $url) {
        $dataProvider = $this->findCandidate($id);
        $iv = TemudugaPentadbiran::findOne(['id' => $id]);
        return $this->render('pen_view_candidate', [
                    'dataProvider' => $dataProvider,
                    'iv' => $iv,
                    'back' => $url,
        ]);
    }

    public function actionCandidateQualified($id, $url) {
        $dataProvider = $this->grid(TblTemudugaPentadbiran::find()->where(['iv_id' => $id])->andWhere(['qualified' => 1])->andWhere(['isActive' => 1]));
        $iv = TemudugaPentadbiran::findOne(['id' => $id]);
        return $this->render('pen_view_candidate', [
                    'dataProvider' => $dataProvider,
                    'iv' => $iv,
                    'back' => $url,
        ]);
    }

    public function findCandidate($id) {
        $record = new ActiveDataProvider([
            'query' => TblTemudugaPentadbiran::find()->where(['iv_id' => $id])->andWhere(['isActive' => 1]),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);
        return $record;
    }

    public function actionViewMark($id) {

        $biodata = TblTemudugaPentadbiran::findOne(['id' => $id]);
        $iv = TemudugaPentadbiran::findOne(['id' => $biodata->iv_id]);
        $dataProvider = $this->findAllMarkIV($id);

        return $this->render('pen_view_mark_iv', [
                    'biodata' => $biodata,
                    'iv' => $iv,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function findAllMarkIV($id) {
        $mark = new ActiveDataProvider([
            'query' => TblpMarkahIv::find()->where(['iv_id' => $id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $mark;
    }

    public function actionJd($id) {
        $deskripsi = \app\models\myportfolio\TblPortfolio::find()->where(['icno' => $id])->andWhere(['status_hantar' => 1])->orderBy(['tarikh_hantar' => SORT_DESC])->one();

        return $this->render('pen_jd', compact('deskripsi'));
    }

    public function actionAddAccessPanel() {

        $model = new TblAccess();
        if (TblAccess::isAdminNonAcademic()) {
            $grid = $this->Grid(TblAccess::find()->where(['IN', 'access', [6, 9, 10]]));

            if ($model->load(Yii::$app->request->post())) {
                $skim = $model->skim;
                if ($skim) {
                    foreach ($skim as $skim) {
                        $bySkim = new TblAccessbySkim();
                        $bySkim->ICNO = $model->ICNO;
                        $bySkim->access = $model->access;
                        $bySkim->ads_id = $skim;
                        $bySkim->save();
                    }
                }
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => '']);
                return $this->redirect(['add-access-panel']);
            }
        } elseif (TblAccess::isAdminAcademic()) {
            $grid = $this->Grid(TblAccess::find()->where(['IN', 'access', [7, 8]]));
            if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => '']);
                return $this->redirect(['add-access-panel']);
            }
        }



        return $this->render('pen_add_panel', [
                    'model' => $model,
                    'grid' => $grid,
        ]);
    }

    public function actionDeleteAccessPanel($id) {

        $model = TblAccess::findOne(['id' => $id]);
        $skim = TblAccessbySkim::find()->where(['ICNO' => $model->ICNO])->andWhere(['access' => $model->access])->all();
        if ($skim) {
            foreach ($skim as $skim) {
                $skim->delete();
            }
        }
        $model->delete();

        Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => '']);
        return $this->redirect(['add-access-panel']);
    }

//    public function actionTandaAras($id) {
//        $model = $this->findBiodata($id);
//        $rolepersidangan = Persidangan::find()->select(['Role'])->where(['!=', 'Role', 'Tiada Data'])->distinct()->all();
//        return $this->render('tandaaras', [
//                    'model' => $model,
//                    'rolepersidangan' => $rolepersidangan
//        ]);
//    }

    public function actionMyStatisticVerified($id) {
        $model = $this->findBiodata($id);
        return $this->render('a_my_statistic_verified', [
                    'model' => $model,
        ]);
    }

    public function actionMyStatistic($id) {
        $model = $this->findBiodata($id);
        return $this->render('a_my_statistic', [
                    'model' => $model,
        ]);
    }

    public function actionLaporan($gred, $status, $p_status) {
        $permohonan = TblPermohonan::find()
                        ->joinWith('biodata.jawatan')
                        ->where(['cv_tbl_permohonan.kj_status' => $status])
                        ->andWhere(['gredjawatan.job_category' => 1])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $gred])
                        ->andWhere(['cv_tbl_permohonan.status_id' => $p_status])
                        ->andWhere(['cv_tbl_permohonan.isActive' => 1])->all();
        $ICNO = array();
        foreach ($permohonan as $permohonan) {
            $ICNO[] = $permohonan->ICNO;
        }
        $model = Tblprcobiodata::find()->where(['in', 'ICNO', $ICNO])->orderBy(['CONm' => SORT_ASC])->all();
        $count = count($model);

        if ($gred == 265) {
            $layout = 'laporan_DU54_noTitle';
        } elseif ($gred == 13) {
            $layout = 'laporan_DS52';
        } else {
            $layout = 'laporan';
        }

        return $this->render($layout, ['model' => $model, 'count' => $count, 'row' => $count, 'gred' => $gred]
        );
    }

    //TEMP CONTINUE AFTER UPDATE CRITERIA VK7
//    public function actionLaporanProfil($gred) {
//        $permohonan = TblProfil::find()->orderBy(['id' => SORT_ASC])->all();
//        $ICNO = array();
//        foreach ($permohonan as $permohonan) {
//            $ICNO[] = $permohonan->ICNO;
//        }
//        $model = Tblprcobiodata::find()->where(['in', 'tblprcobiodata.ICNO', $ICNO])
//                ->joinWith('cvProfil')
//                ->orderBy(['cv_tbl_profil.id' => SORT_ASC])->all();
//        $count = count($model);
//
//        return $this->render('laporan', ['model' => $model, 'count' => $count, 'row' => $count, 'gred' => $gred]
//        );
//    }
    //system admin

    public function actionUpRank() {
        $model = $this->Grid(GredJawatan::find()->where(['is not', 'up_rank', NULL]));

        return $this->render('s_view_rank', [
                    'model' => $model,
        ]);
    }

    public function actionAccess() {

        $model = new TblAccess();
        $grid = $this->Grid(TblAccess::find()->orderBy(['access' => SORT_ASC]));

        if ($model->load(Yii::$app->request->post())) {

            if (TblAccess::findOne(['ICNO' => $model->ICNO, 'access' => $model->access])) {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'Exist Record.']);
            } else {
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => '']);
                return $this->redirect(['access']);
            }
        }

        return $this->render('s_access', [
                    'model' => $model,
                    'grid' => $grid,
        ]);
    }

    public function actionEditAccess($id) {

        $model = TblAccess::findOne(['id' => $id]);
        $grid = $this->Grid(TblAccess::find());

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['access']);
        }

        return $this->render('s_access', [
                    'model' => $model,
                    'grid' => $grid,
        ]);
    }

    public function actionDeleteAccess($id) {

        $model = TblAccess::findOne(['id' => $id]);
        $model->delete();

        Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => '']);
        return $this->redirect(['access']);
    }

    public function actionPinda1() { //temp match ICNO to tbl baru
//        $data = TblSwSociedata =ty::find()->all();
//        $data = TblSwUniversity::find()->all();
//        $data = TblAppinfo::find()->all();
//        $data = \app\models\cv\TblPanel::find()->all();
//        $data = TblActivitiesOther::find()->all();
//        $data = TblIncome::find()->all();
//        $data = TblInnovation::find()->all();
//        $data = TblJobdetails::find()->all();
//        $data = TblPaperwork::find()->all();
//        $data = TblResearch::find()->all();
//        $data = TblSkills::find()->all();
//        $data = TblSports::find()->all();
//        foreach ($data as $data) {
//            $model = \app\models\cv\Pengguna::findOne(['uid' => $data->uid]);
//            if ($model) {
//                $data->ICNO = $model->ICNO;
//                $data->save(false);
//            }
//        }
//        $data = TblActivitiesOther::find()->where(['ICNO' => NULL])->all();
//        $t = count($data);
//        foreach ($data as $data) {  
//            $model = Tblprcobiodata::findOne(['COOldID' => $data->uid]);
//            if ($model) {
//                $data->ICNO = $model->ICNO;
//                $data->save(false); 
//            }
//        }
        Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => '']);
        return $this->redirect(['resume-edit']);
    }

    public function actionComplain() {

        $biodata = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()]);
        $status = \app\models\cv\RefStatusAduan::find()->all();

        if ($biodata->jawatan->job_category == 1) { //akademik
            $model = new TblAduan();
            $record = TblAduan::find()->where(['ICNO' => $this->ICNO()])->orderBy(['tarikh_mohon' => SORT_ASC])->all();
        } else {
            $model = new TblAduanPentadbiran();
            $record = TblAduanPentadbiran::find()->where(['ICNO' => $this->ICNO()])->orderBy(['tarikh_mohon' => SORT_ASC])->all();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($biodata->jawatan->job_category == 1) {
                $k = \app\models\cv\RefKriteria::findOne(['id' => $model->kriteria_id]);
                $content = "Aduan Kenaikan Pangkat Bahagian: " . $k->type . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', ['cv/record-complain'], ['class' => 'btn btn-primary btn-sm']);
                $this->notifikasi('850711125215', $content); //en Razmi
            } else {
                $content = "Aduan Kenaikan Pangkat: " . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', ['cv/record-complain'], ['class' => 'btn btn-primary btn-sm']);
                $this->notifikasi('811212125745', $content); //en Ismail
                $this->notifikasi('851129125038', $content); //cik rohana
            }

            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'saved.']);
            return $this->redirect(['complain']);
        }

        return $this->render('u_cv_form_complain', [
                    'model' => $model,
                    'record' => $record,
                    'status' => $status,
                    'biodata' => $biodata,
        ]);
    }

    public function actionComplainFeedback($id) {
        $biodata = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()]);
        if ($biodata->jawatan->job_category == 1) {
            $model = TblAduan::find()->where(['ICNO' => $this->ICNO()])->andWhere(['id' => $id])->one();
        } else {
            $model = TblAduanPentadbiran::find()->where(['ICNO' => $this->ICNO()])->andWhere(['id' => $id])->one();
        }

        return $this->renderAjax('u_cv_form_complain_feedback', [
                    'model' => $model,
        ]);
    }

    public function actionRecordComplain() {
        return $this->render('u_cv_form_complain_home', [
        ]);
    }

    public function actionRecordComplainByStatus($status) {
        if (TblAccess::isAdminAcademic()) {
            $dataProvider = $this->Grid(TblAduan::find()->where(['status_id' => $status])->orderBy(['tarikh_mohon' => SORT_DESC]));
        } else {
            $dataProvider = $this->Grid(TblAduanPentadbiran::find()->where(['status_id' => $status])->orderBy(['tarikh_mohon' => SORT_DESC]));
        }
        return $this->render('u_cv_form_complain_record', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRecordComplainOwner() {

        $model = new TblAduan();
        $record = TblAduan::find()->where(['assign_to' => Yii::$app->user->getId()])->orderBy(['assign_at' => SORT_ASC])->all();

        return $this->render('u_cv_form_complain_record_owner', [
                    'model' => $model,
                    'record' => $record,
        ]);
    }

    public function actionComplainInAction($id) {

        if (TblAccess::isAdminAcademic() || TblAccess::isAdminDataOwner()) {
            $model = TblAduan::find()->where(['id' => $id])->one();
        } else { // pentadbiran
            $model = TblAduanPentadbiran::find()->where(['id' => $id])->one();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->status_id == 2) {
                $model->tarikh_tindakan = date('Y-m-d H:i:s');
                $model->tindakan_by = Yii::$app->user->getId();
                $content = "Aduan anda dalam proses tindakan lanjut. " . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', ['cv/complain'], ['class' => 'btn btn-primary btn-sm']);
            } else {
                $model->tarikh_selesai = date('Y-m-d H:i:s');
                $model->selesai_by = Yii::$app->user->getId();
                $content = "Aduan berjaya diselesaikan sila buat semakan kendiri. " . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', ['cv/complain'], ['class' => 'btn btn-primary btn-sm']);
            }
            $model->save(false);
            $this->notifikasi($model->ICNO, $content); //notify pemohon

            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'saved.']);

            if (TblAccess::isAdminAcademic() || TblAccess::isAdminNonAcademic()) {
                return $this->redirect(['record-complain']);
            } else {
                return $this->redirect(['record-complain-owner']);
            }
        }

        return $this->render('u_cv_form_complain_action', [
                    'model' => $model,
        ]);
    }

    public function actionAssignComplain($id) {

        $model = TblAduan::find()->where(['id' => $id])->one();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->assign_to) {
                $content = "Aduan Kenaikan Pangkat " . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', ['cv/record-complain-owner'], ['class' => 'btn btn-primary btn-sm']);
                $this->notifikasi($model->assign_to, $content); //notify owner
                $model->save(false);

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'successfully sent.']);
                return $this->redirect(['record-complain']);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'please select owner']);
                return $this->redirect(['record-complain']);
            }
        }

        return $this->renderAjax('u_cv_form_complain_assign', [
                    'model' => $model,
        ]);
    }

    public function actionAdminApproval($id) {

        $model = TblPermohonan::find()->where(['id' => $id])->one();
        $lantikan = Tblprcobiodata::findOne(['ICNO' => $model->ICNO]);

        if ($lantikan->statLantikan == 1) {
            $url_return = 'list-candidate';
        } else {
            $url_return = 'list-candidate-contract';
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->status_id) {
                $model->admin_ICNO = Yii::$app->user->getId();
                $model->admin_datetime = date('Y-m-d H:i:s');
                if ($model->status_id == 3) {
                    $model->admin_status = 1; //offer iv status from admin
                }
                if ($model->status_id == 4) {
                    $model->isActive = 0; //closed application
                    $model->admin_status = 1; //pass status from admin
                }
                if ($model->status_id == 5) {
                    $model->isActive = 0; //closed application
                    $model->admin_status = 0; //failed status from admin
                }

                $model->save(false);
                if (TblAccess::isAdminAcademic()) {
                    $content = "Status permohonan Kenaikan Pangkat telah dikeluarkan. Sila " . Html::a(' <i class="fa fa-arrow-right"></i> Klik Disini', ['cv/record-application'], ['class' => 'btn btn-primary btn-sm']);
                    $this->notifikasi($model->ICNO, $content); //notify owner
                    Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'successfully sent.']);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'saved.']);
                }
                return $this->redirect([$url_return, 'id' => $model->ads_id, 'status' => $model->kj_status]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'please select status']);
                return $this->redirect(['admin-approval', 'id' => $id]);
            }
        }

        return $this->renderAjax('a_approval', [
                    'model' => $model,
        ]);
    }

    public function actionAdminApprovalPentadbiran($id) {

        $model = TblPermohonan::find()->where(['id' => $id])->one();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->admin_status) {
                $model->admin_ICNO = Yii::$app->user->getId();
                $model->admin_datetime = date('Y-m-d H:i:s');
                if ($model->admin_status == 1) {
                    $model->admin_ulasan = 'Lulus Tapisan & Pemilihan'; //offer iv status from admin
                }
                if ($model->admin_status == 2) {
                    $model->isActive = 0; //closed application
                    $model->admin_ulasan = 'Gagal Tapisan';
                }
                if ($model->admin_status == 3) {
                    $model->isActive = 0; //closed application
                    $model->admin_ulasan = 'Gagal Pemilihan';
                }

                $model->save(false);

                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'saved.']);
                return $this->redirect(['list-candidate', 'id' => $model->ads_id, 'status' => $model->kj_status]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'please select status']);
                return $this->redirect(['admin-approval', 'id' => $id]);
            }
        }

        return $this->renderAjax('a_approval', [
                    'model' => $model,
        ]);
    }

    public function actionPekeliling() {

        return $this->redirect(array('uploads-cv/pentadbiran/pekeliling.pdf'));
//        return "<script>window.open('https://localhost/staff/web/uploads-cv/pentadbiran/pekeliling.pdf', '_blank')</script>";
    }

    public function actionChangeAccess() {
        $model = TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['access' => 2])->one();
        if ($model) {
            $model->access = 5;
        } else {
            $model = TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['access' => 5])->one();
            $model->access = 2;
        }

        $model->save(false);

        return $this->redirect(['search']);
    }

//    public function actionCheckQualifiedVk7() {
//        $model = Tblprcobiodata::find()->where(['gredJawatan' => 11])
//                ->andWhere(['Status' => 1])
//                ->andWhere(['statLantikan' => 1])
//                ->all();
//
//        foreach ($model as $model) {
//            $K1 = TblAppinfo::Umum($model->ICNO, 10);
//
//            $K2 = TblAppinfo::Penyelidikan($model->ICNO, 10);
//
//            $K3 = TblAppinfo::Penerbitan($model->ICNO, 10);
//
//            $K4 = TblAppinfo::Pengajaran($model->ICNO, 10);
//
//            $K5 = TblAppinfo::Penyeliaan($model->ICNO, 10);
//
//            $K6 = TblAppinfo::Sanjungan($model->ICNO, 10);
//
//            $K7 = TblAppinfo::Khidmat($model->ICNO, 10);
//
//            $K8 = TblAppinfo::Perundingan($model->ICNO, 10);
//
//            $check = TblQualifiedVk7::findOne(['ICNO' => $model->ICNO]);
//            if ($check) {
//                $add = $check;
//            } else {
//                $add = new TblQualifiedVk7();
//                $add->ICNO = $model->ICNO;
//                $add->statLantikan = $model->statLantikan;
//            }
//
//
//            $add->K1 = $K1;
//            $add->K2 = $K2;
//            $add->K3 = $K3;
//            $add->K4 = $K4;
//            $add->K5 = $K5;
//            $add->K6 = $K6;
//            $add->K7 = $K7;
//            $add->K8 = $K8;
//
//            $add->created_at = date('Y-m-d H:i:s');
//
//            $add->percent = (($K1 + $K2 + $K3 + $K4 + $K5 + $K6 + $K7 + $K8) / 8) * 100;
//            $add->save(false);
//        }
//
//        Yii::$app->session->setFlash('alert', ['title' => 'Done', 'type' => 'success', 'msg' => '']);
//        return $this->redirect(['record-application']);
//    }
//
//    public function actionCheckQualifiedDs54() {
//        $model = Tblprcobiodata::find()->where(['IN', 'gredJawatan', [13, 14]])
//                ->andWhere(['Status' => 1])
//                ->andWhere(['statLantikan' => 1])
//                ->all();
//
//        foreach ($model as $model) {
//            $K1 = TblAppinfo::Umum($model->ICNO, 11);
//
//            $K2 = TblAppinfo::Penyelidikan($model->ICNO, 11);
//
//            $K3 = TblAppinfo::Penerbitan($model->ICNO, 11);
//
//            $K4 = TblAppinfo::Penyeliaan($model->ICNO, 11);
//
//            $K5 = TblAppinfo::Sanjungan($model->ICNO, 11);
//
//            $K6 = TblAppinfo::Khidmat($model->ICNO, 11);
//
//            $K7 = TblAppinfo::Perundingan($model->ICNO, 11);
//
//            $check = TblQualifiedDs54::findOne(['ICNO' => $model->ICNO]);
//            if ($check) {
//                $add = $check;
//            } else {
//                $add = new TblQualifiedDs54();
//                $add->ICNO = $model->ICNO;
//                $add->statLantikan = $model->statLantikan;
//            }
//
//
//            $add->K1 = $K1;
//            $add->K2 = $K2;
//            $add->K3 = $K3;
//            $add->K4 = $K4;
//            $add->K5 = $K5;
//            $add->K6 = $K6;
//            $add->K7 = $K7;
//
//            $add->created_at = date('Y-m-d H:i:s');
//
//            $add->percent = (($K1 + $K2 + $K3 + $K4 + $K5 + $K6 + $K7) / 7) * 100;
//            $add->save(false);
//        }
//
//        Yii::$app->session->setFlash('alert', ['title' => 'Done', 'type' => 'success', 'msg' => '']);
//        return $this->redirect(['record-application']);
//    }
//
//    public function actionListQualifiedVk7() {
//
//        $model = $this->Grid(TblQualifiedVk7::find()
//                        ->where(['DATE(created_at)' => date('Y-m-d')])
//                        ->orderBy(['percent' => SORT_DESC]));
//
//        return $this->render('a_list_qualified_VK7', [
//                    'model' => $model,
//        ]);
//    }
//
//    public function actionListQualifiedDs54() {
//
//        $model = $this->Grid(TblQualifiedDs54::find()
//                        ->where(['DATE(created_at)' => date('Y-m-d')])
//                        ->orderBy(['percent' => SORT_DESC]));
//
//        return $this->render('a_list_qualified_DS54', [
//                    'model' => $model,
//        ]);
//    }
}
