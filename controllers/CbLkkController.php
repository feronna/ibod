<?php


namespace app\controllers;

use app\models\cbelajar\TblAccess;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\models\Notification;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblprcobiodata;
use app\models\cbelajar\TblAdmin;
use tebazil\runner\ConsoleCommandRunner;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\models\cbelajar\TblLkk;
use app\models\hronline\Department;

class CbLkkController extends \yii\web\Controller
{
     public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['rating', 'penyelia','view','halaman-penyelia','halaman-penyelia-ums',
                    'index','view-penyelia','pp-view-rating','view-lkk-ums','view-penyelia-ums',
                    'sv-phd-ums','rating-ums','student-list','student-list-ums'],
                'rules' => [
                        [
                        'actions' => ['rating', 'penyelia','view','halaman-penyelia','halaman-penyelia-ums',
                            'view-penyelia',
                            'index','pp-view-rating','view-lkk-ums','view-penyelia-ums',
                            'sv-phd-ums','rating-ums','student-list','student-list-ums'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'logout' => ['post'],
                ],
            ],
        ];
    }
//     public function behaviors()
//    {
//        return 
//        
//        [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['index'],
//                'rules' => [
//                    [
//                        'actions' => ['index'],
//                        'allow' => true,
//                        'matchCallback' => function($rule,$action)
//                        {
//                             
//
//                          
//                           
//                            if(in_array (Yii::$app->user->getId(),['950829125446','860130125080','891103125554','840929125614','870818495847']))
//                            {
//                                return TRUE;
//                            }
//                           
//                                return FALSE;
//                           
//                        } ,
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    //                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }
    protected function notifikasi($icno, $content)
    {
        //--------Model Notification-----------//
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $icno;
        $ntf->title = 'Permohonan Pengajian Lanjutan';
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        //--------Model Notification-----------//
    }
    //    public function actionIndex()
    //    {
    //        return $this->render('index');
    //    }
    //    
    //     public function actionSenaraiPenyelia($jfpiu=null,$category = null, $my = null) {
    //
    //
    ////        $searchModel = new \app\models\cbelajar\TblPengajianSearch();
    ////        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    ////        $listicno = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['Status'=>[1,2,6]]): Tblprcobiodata::find()->where(['Status'=>[1,2,6]]);
    ////        $category? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]): $listicno;
    //
    //        $query = \app\models\cbelajar\LkkTblPenyelia::find()->all();
    //        $dataProvider = new ActiveDataProvider([
    //
    //            'query' => $query,
    // 
    //           'pagination' => [
    //
    //                'pageSize' => 5,
    //
    //            ],
    //        ]);
    //         
    ////        $dataProvider->query->andFilterWhere(['status'=>1])->orderBy(['tarikh_mula'=>SORT_ASC]);
    //
    //        $my? $dataProvider->query->andFilterWhere(['like', 'tarikh_mula', date_format(date_create($my), 'Y-m')]):' ';
    //  $current = TblPengajian::find()->where(['<=', 'tarikh_mula', date('Y-m')])->one();
    //        
    //        $my? :$my = $current->tahun;
    //        isset(Yii::$app->request->queryParams['icno'])? $dataProvider->query->andFilterWhere
    //        (['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';
    //        
    //        isset(Yii::$app->request->queryParams['HighestEduLevelCd'])? $dataProvider->query->andFilterWhere(
    //        ['like', 'HighestEduLevelCd',  Yii::$app->request->queryParams['HighestEduLevelCd'] ]):'';
    //
    //
    // 
    //        return $this->render('senarai_penyelia', [
    ////                    'searchModel' => $searchModel,
    //                    'dataProvider' => $dataProvider,
    //                    'category' => $category,
    //                    'query' => $query,
    ////                    '$job' =>$job,
    //
    //                    
    //        ]);
    //    }
    public function actionPageUtama() {

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

 $icno = Yii::$app->user->getId();
 $a = (Department::find()->where(['chief' => $icno, 'isActive' => '1']));
        //       $c = 
      
        if (TblAccess::find()->where(['icno' => $icno])->exists()) {
                           $this->layout = "main-penyelia";

            return $this->render('halaman-penyelia', []);
        }

       
        //        if(Department::find()->where( ['chief' => $icno, 'isActive' => '1'] )->exists() )||   (\app\models\cbelajar\TblAccess::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
        //{
        //        return $this->redirect('../cutisabatikal/senaraitindakan');} 
          elseif ($a->exists()) {
            return $this->redirect('../cutisabatikal/senaraitindakan');
        }
        elseif (\app\models\cbelajar\TblAccess::find()->where(['icno' => Yii::$app->user->getId(), 'level' => 2])->exists()) {
            return $this->redirect(['/cbadmin/halaman-admin']);
        } elseif (($biodata->statLantikan == "1" && $biodata->jawatan->job_category == "1") || ($biodata->statLantikan == "2" && $biodata->jawatan->job_category == "1") || ($biodata->statLantikan == "1" && $biodata->jawatan->job_category == "2") || ($biodata->statLantikan == "2" && $biodata->jawatan->job_category == "2")) { //jika user staf lantikan tetap & belum disahkan & staf pentadbiran
            return $this->redirect('../cutibelajar/halaman-pemohon');
        } elseif (\app\models\cbelajar\TblAccess::find()->where(['icno' => Yii::$app->user->getId(), 'level' => 99])->exists()) {
            return $this->redirect(['/cb-lkk/halaman-penyelia-ums']);
        }

//         elseif (\app\models\cbelajar\TblAccess::find()->where(['icno' => Yii::$app->user->getId(),'level'=>99])->exists()) {
//            return $this->redirect(['/cb-lkk/halaman-penyelia']);
//        }
        else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('/cutibelajar/index');
        }
        $model = new TblPermohonan();
    }
    public function actionIndex()
    {

        $searchModel = new \app\models\cbelajar\LkkTblPenyeliaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       isset(Yii::$app->request->queryParams['staff_icno'])? $dataProvider->query->andFilterWhere
        (['like', 'staff_icno',  Yii::$app->request->queryParams['staff_icno'] ]):'';
       isset(Yii::$app->request->queryParams['nama'])? $dataProvider->query->andFilterWhere
        (['like', 'nama',  Yii::$app->request->queryParams['nama'] ]):'';
  
       if(TblAccess::find()->where(['icno' => Yii::$app->user->getId(), 'level' => 2])->exists()) {
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('page-utama');
        }
    }
     public function actionDeleteData($id) 
    {
      
        $mj = \app\models\cbelajar\LkkTblPenyelia::findOne($id)->delete();
//        $p = TblPermohonan::findOne($id)->$delete();
//        $iklan = findIklanbyID($id);
        
        return $this->redirect(['cb-lkk/index']);
    }
    public function actionView()
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    protected function findModel($id)
    {
        if (($model = \app\models\cbelajar\LkkTblPenyelia::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionTambahPenyelia()
    {
        //        $admin = \app\models\hronline\Tblprcobiodata::find()->All();
        //        $permohonan = new TblPermohonan();
        $pengajian = new \app\models\cbelajar\TblPenyelia();
        //        $model = Tblprcobiodata::findOne(['ICNO'=>$icno]);
        //        $lkk = new \app\models\cbelajar\TblLkk();



        if ($pengajian->load(Yii::$app->request->post())) {

            

            $pengajian->save(false);

           
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['index']);
        }

        return $this->render('tambah_penyelia', [

            'pengajian' => $pengajian,
            'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')


        ]);
    }
     protected function findModel2($id){
        
        if (($model =  \app\models\cbelajar\LkkTblPenyelia::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findStudy($id) {
        return \app\models\cbelajar\TblPengajian::findOne(['icno' => $id, 'status'=>1]);
    }
public function actionUpdate($id){
         
                
            
              $model=$this->findModel2($id);
              if ($model->load(Yii::$app->request->post())) {
            
                
                
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 
                'Berjaya disimpan']);
            return $this->redirect(['index']);
              }
        
            return $this->renderAjax('update-penyelia', [
                'model' => $model,
               
             
            ]); 
    }
    
    
    public function actionHalamanAdmin()
    {
        //        $year = date('Y');
        $icno = Yii::$app->user->getId();
        $info = \app\models\system_core\TblDahsboard::findOne(['icno' => $icno]);



        if (TblAdmin::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {

            return $this->render('halaman-admin', [

                'info' => $info,



            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('/cutibelajar/index');
        }
    }

    public function actionHalamanPenyelia()
    {
        $icno = Yii::$app->user->getId();
               $this->layout = "main-penyelia";

        if (TblAccess::find()->where(['icno' => $icno])->exists()) {
            return $this->render('halaman-penyelia', []);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('page-utama');
        }
    }
    public function actionHalamanPenyeliaUms()
    {
//        $icno = Yii::$app->user->getId();

//        if (\app\models\cbelajar\TblPenyelia::find()->where(['icno' => $icno])->exists()) {
            return $this->render('halaman-penyelia-ums', []);
//        } else {
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//            return $this->render('/cutibelajar/index');
//        }
    }
 
    public function actionStudentList()
    {
        $this->layout = "main-penyelia";
        $icno = Yii::$app->user->getId();
//        var_dump($icno);die();
        //        $currentYear = date('Y');
        
        $model = \app\models\system_core\ExternalUser::find()
                ->where(['user_id' => $icno])->one();
//var_dump($model);die();
        $staffCurrentIDP = \app\models\cbelajar\LkkTblPenyelia::find()
            ->joinWith('penyelia')
            ->where(['lkk_tbl_penyelia.emel' => $model->username])
            ->orderBy('lkk_tbl_penyelia.nama')
                ->groupBy('lkk_tbl_penyelia.emel');
        
//        var_dump(count($staffCurrentIDP));
//        die();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $staffCurrentIDP,
            'pagination' => [

                'pageSize' => 5,

            ],
        ]);


        return $this->render('senarai_student', [
            'model' => $staffCurrentIDP,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionStudentListUms()
    {
//        $this->layout = "main-penyelia";
        $icno = Yii::$app->user->getId();
                $biodata = $this->findBiodata($icno);

//        var_dump($icno);die();
        //        $currentYear = date('Y');
        
//        $model = \app\models\system_core\ExternalUser::find()
//                ->where(['user_id' => $icno])->one();
//var_dump($model);die();
        $staffCurrentIDP = \app\models\cbelajar\LkkTblPenyelia::find()
            ->joinWith('penyelia')
            ->where(['lkk_tbl_penyelia.emel' => $biodata->COEmail])
            ->orderBy('lkk_tbl_penyelia.nama')
            ->groupBy('lkk_tbl_penyelia.emel');
;
        
//        var_dump(count($staffCurrentIDP));
//        die();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $staffCurrentIDP,
            'pagination' => [

                'pageSize' => 5,

            ],
        ]);


        return $this->render('senarai_student_ums', [
            'model' => $staffCurrentIDP,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewLkk($my = NULL, $id)
    {
        $pengajian = \app\models\cbelajar\TblPengajian::find()
               ->where(['icno' => $id,'status'=>[1,2,4]])->orderBy(['tarikh_mula'=> SORT_ASC])->one();
        $this->layout = "main-penyelia";

        //        $biodata = $this->findMaklumat1($id);
        $biodata = $this->findBiodata($id);
        $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => $id])->all();
        //        $model2 = $this->findKemudahan($id);
        $dataProvider2 = new ActiveDataProvider([

            'query' => \app\models\cbelajar\TblLkk::find()->where(['icno' => $id, 'status_form' => 1])->andWhere(['like', 'tarikh_hantar', date_format(date_create($my), 'yy-m')]),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        if (Yii::$app->request->post('notipemohon')) {
            $this->notifipemohon();
            return $this->refresh();
        } elseif (Yii::$app->request->post('notipegawai')) {
            $this->notifipegawai();
            return $this->refresh();
        }
        return $this->render('viewlkk', [
            //             'model' => $model,
            'lkk' => $lkk,
            'pengajian' => $pengajian,
            'id' => $id,
            'biodata' => $biodata,
            //                    'model2' => $model2,
        ]);
    }
     public function actionViewLkkUms($my = NULL, $id)
    {
        $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno' => $id, 'idBorang' => 1])->orderBy(['tarikh_mula'=>SORT_DESC])->one();

        //        $biodata = $this->findMaklumat1($id);
        $biodata = $this->findBiodata($id);
        $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => $id,'status_form' => 1])->all();
        //        $model2 = $this->findKemudahan($id);
        $dataProvider2 = new ActiveDataProvider([

            'query' => \app\models\cbelajar\TblLkk::find()->where(['icno' => $id, 'status_form' => 1])->andWhere(['like', 'tarikh_hantar', date_format(date_create($my), 'yy-m')]),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        if (Yii::$app->request->post('notipemohon')) {
            $this->notifipemohon();
            return $this->refresh();
        } elseif (Yii::$app->request->post('notipegawai')) {
            $this->notifipegawai();
            return $this->refresh();
        }
        return $this->render('viewlkkums', [
            //             'model' => $model,
            'lkk' => $lkk,
            'pengajian' => $pengajian,
            'id' => $id,
            'biodata' => $biodata,
            //                    'model2' => $model2,
        ]);
    }
    protected function findBiodata($id)
    {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionViewPenyelia($i)
    {
                       $this->layout = "main-penyelia";

        $icno = Yii::$app->user->getId();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $i]);
        $research = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
        $mod = new \app\models\cbelajar\Rating();
        $pro = new \app\models\cbelajar\Progress();
        $m = new \app\models\cbelajar\TblResearch();
        $progress = \app\models\cbelajar\RefProgress::find()->all();
        $rating = \app\models\cbelajar\RefRating::find()->all();
        $lkk = \app\models\cbelajar\RefResearch::find()->all();
        $p = $this->findPengajian1($icno);
        //        $iklan = $this->findIklanbyID($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status_p = 'DONE COMMENT';
            $model->c_date = date('Y-m-d H:i:s');
            if ($model->status_p == 'DONE COMMENT') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
                $model->p_komen;
                $model->k2;
                $model->k3;
                $model->k4;
                $model->k5;
                $model->k6;
                $model->k7;
                $model->k8;

                $model->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);
            }
            $model->save(false);

            //            foreach ($progress as $dok)
            //            {
            //                 $progress = new \app\models\cbelajar\Progress();
            //                 $progress->comment = Yii::$app->request->post($dok->id) ;
            //                 $progress->reportID = $model->reportID;
            //                 $progress->icno = $model->icno;
            //                 $progress->idProgress = $dok->id;
            //                 $progress->save(false);
            //                
            //            }

            $this->notifikasi($model->icno, "Progress Report have been successfully commented. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['rating?i=' . $model->reportID]);
        }


        return $this->render('_penyelia', [

            //              'iklan' => $iklan,
            'model' => $model,
            'mod' => $mod,
            'p' => $p,
            'rating' => $rating,
            'lkk' => $lkk,
            'm' => $m,
            'bil' => '1',

            'research' => $research, 'progress' => $progress, 'i' => $i
        ]);
    }
     public function actionUpdateComment($i)
    {
                       $this->layout = "main-penyelia";

        $icno = Yii::$app->user->getId();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $i]);
        $research = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
        $mod = new \app\models\cbelajar\Rating();
        $pro = new \app\models\cbelajar\Progress();
        $m = new \app\models\cbelajar\TblResearch();
        $progress = \app\models\cbelajar\RefProgress::find()->all();
        $rating = \app\models\cbelajar\RefRating::find()->all();
        $lkk = \app\models\cbelajar\RefResearch::find()->all();
        $p = $this->findPengajian1($icno);
        //        $iklan = $this->findIklanbyID($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status_p = 'DONE COMMENT';
            $model->c_date = date('Y-m-d H:i:s');
            if ($model->status_p == 'DONE COMMENT') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
                $model->p_komen;
                $model->k2;
                $model->k3;
                $model->k4;
                $model->k5;
                $model->k6;
                $model->k7;
                $model->k8;

                $model->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);
            }
            $model->save(false);

            //            foreach ($progress as $dok)
            //            {
            //                 $progress = new \app\models\cbelajar\Progress();
            //                 $progress->comment = Yii::$app->request->post($dok->id) ;
            //                 $progress->reportID = $model->reportID;
            //                 $progress->icno = $model->icno;
            //                 $progress->idProgress = $dok->id;
            //                 $progress->save(false);
            //                
            //            }

            $this->notifikasi($model->icno, "Progress Report have been successfully commented. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['view-penyelia?i=' . $model->reportID]);
        }


        return $this->render('u_penyelia', [

            //              'iklan' => $iklan,
            'model' => $model,
            'mod' => $mod,
            'p' => $p,
            'rating' => $rating,
            'lkk' => $lkk,
            'm' => $m,
            'bil' => '1',

            'research' => $research, 'progress' => $progress, 'i' => $i
        ]);
    }
    public function actionViewPenyeliaUms($i)
    {

        $icno = Yii::$app->user->getId();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $i]);
        $research = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
        $mod = new \app\models\cbelajar\Rating();
        $pro = new \app\models\cbelajar\Progress();
        $m = new \app\models\cbelajar\TblResearch();
        $progress = \app\models\cbelajar\RefProgress::find()->all();
        $rating = \app\models\cbelajar\RefRating::find()->all();
        $lkk = \app\models\cbelajar\RefResearch::find()->all();
        $p = $this->findPengajian1($icno);
        //        $iklan = $this->findIklanbyID($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status_p = 'DONE COMMENT';
            $model->c_date = date('Y-m-d H:i:s');
            if ($model->status_p == 'DONE COMMENT') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
                $model->p_komen;
                $model->k2;
                $model->k3;
                $model->k4;
                $model->k5;
                $model->k6;
                $model->k7;
                $model->k8;

                $model->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);
            }
            $model->save(false);

            //            foreach ($progress as $dok)
            //            {
            //                 $progress = new \app\models\cbelajar\Progress();
            //                 $progress->comment = Yii::$app->request->post($dok->id) ;
            //                 $progress->reportID = $model->reportID;
            //                 $progress->icno = $model->icno;
            //                 $progress->idProgress = $dok->id;
            //                 $progress->save(false);
            //                
            //            }

            $this->notifikasi($model->icno, "Progress Report have been successfully commented. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['rating-ums?i=' . $model->reportID]);
        }


        return $this->render('_penyeliaums', [

            //              'iklan' => $iklan,
            'model' => $model,
            'mod' => $mod,
            'p' => $p,
            'rating' => $rating,
            'lkk' => $lkk,
            'm' => $m,
            'bil' => '1',

            'research' => $research, 'progress' => $progress, 'i' => $i
        ]);
    }
    
     public function actionEditKomen($i)
    {

        $icno = Yii::$app->user->getId();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $i]);
        $research = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
        $mod = new \app\models\cbelajar\Rating();
        $pro = new \app\models\cbelajar\Progress();
        $m = new \app\models\cbelajar\TblResearch();
        $progress = \app\models\cbelajar\RefProgress::find()->all();
        $rating = \app\models\cbelajar\RefRating::find()->all();
        $lkk = \app\models\cbelajar\RefResearch::find()->all();
        $p = $this->findPengajian1($icno);
        //        $iklan = $this->findIklanbyID($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status_p = 'DONE COMMENT';
            $model->c_date = date('Y-m-d H:i:s');
            if ($model->status_p == 'DONE COMMENT') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
                $model->p_komen;
                $model->k2;
                $model->k3;
                $model->k4;
                $model->k5;
                $model->k6;
                $model->k7;
                $model->k8;

                $model->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);
            }
            $model->save(false);

            //            foreach ($progress as $dok)
            //            {
            //                 $progress = new \app\models\cbelajar\Progress();
            //                 $progress->comment = Yii::$app->request->post($dok->id) ;
            //                 $progress->reportID = $model->reportID;
            //                 $progress->icno = $model->icno;
            //                 $progress->idProgress = $dok->id;
            //                 $progress->save(false);
            //                
            //            }

            $this->notifikasi($model->icno, "Progress Report have been successfully saved. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['view-penyelia?i=' . $model->reportID]);
        }


        return $this->render('_epenyeliaums', [

            //              'iklan' => $iklan,
            'model' => $model,
            'mod' => $mod,
            'p' => $p,
            'rating' => $rating,
            'lkk' => $lkk,
            'm' => $m,
            'bil' => '1',

            'research' => $research, 'progress' => $progress, 'i' => $i
        ]);
    }
    
     public function actionEditKomenUms($i)
    {

        $icno = Yii::$app->user->getId();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $i]);
        $research = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
        $mod = new \app\models\cbelajar\Rating();
        $pro = new \app\models\cbelajar\Progress();
        $m = new \app\models\cbelajar\TblResearch();
        $progress = \app\models\cbelajar\RefProgress::find()->all();
        $rating = \app\models\cbelajar\RefRating::find()->all();
        $lkk = \app\models\cbelajar\RefResearch::find()->all();
        $p = $this->findPengajian1($icno);
        //        $iklan = $this->findIklanbyID($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status_p = 'DONE COMMENT';
            $model->c_date = date('Y-m-d H:i:s');
            if ($model->status_p == 'DONE COMMENT') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Progress Report been checked']);
                $model->p_komen;
                $model->k2;
                $model->k3;
                $model->k4;
                $model->k5;
                $model->k6;
                $model->k7;
                $model->k8;

                $model->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Not Submitted Yet!', 'type' => 'success', 'msg' => 'Not Submitted Yet!']);
            }
            $model->save(false);

            //            foreach ($progress as $dok)
            //            {
            //                 $progress = new \app\models\cbelajar\Progress();
            //                 $progress->comment = Yii::$app->request->post($dok->id) ;
            //                 $progress->reportID = $model->reportID;
            //                 $progress->icno = $model->icno;
            //                 $progress->idProgress = $dok->id;
            //                 $progress->save(false);
            //                
            //            }

            $this->notifikasi($model->icno, "Progress Report have been successfully saved. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['view-penyelia-ums?i=' . $model->reportID]);
        }


        return $this->render('_epenyeliaumss', [

            //              'iklan' => $iklan,
            'model' => $model,
            'mod' => $mod,
            'p' => $p,
            'rating' => $rating,
            'lkk' => $lkk,
            'm' => $m,
            'bil' => '1',

            'research' => $research, 'progress' => $progress, 'i' => $i
        ]);
    }

    public function actionRating($i)
    {
                       $this->layout = "main-penyelia";

        $icno = Yii::$app->user->getId();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $i]);
        $research = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
        $mod = new \app\models\cbelajar\Rating();
        $pro = new \app\models\cbelajar\Progress();
        $m = new \app\models\cbelajar\TblResearch();
        $progress = \app\models\cbelajar\RefProgress::find()->all();
        $rating = \app\models\cbelajar\RefRating::find()->all();
        $lkk = \app\models\cbelajar\RefResearch::find()->all();
        $p = $this->findPengajian1($icno);
        //        $iklan = $this->findIklanbyID($id);
    $pegawai = \app\models\hronline\Department::findOne(['id' => $model->kakitangan->DeptId]) ; 
        //        $iklan = $this->findIklanbyID($id);
          if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $model->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = \app\models\hronline\Department::findOne(['id' => $pegawai->sub_of]);
        $model->app_by = $pegawaisub->chief; //kj 
        }

        
        if($model->ver_by == '')
        { 
            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $model->app_by;
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->status_r = 'DONE';
            $model->r_dt = date('Y-m-d H:i:s');
            
            if ($model->status_r == 'DONE') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Rating successfully been saved!']);
                $model->save(false);
            } else {    
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);
            foreach ($rating as $dok) {
                $mod = new \app\models\cbelajar\Rating();
                
                $mod->p_komen = Yii::$app->request->post($dok->id);
                $mod->idLkk = $model->reportID;
                $mod->p_icno = $icno;
                            $mod->dt_rating = date('Y-m-d H:i:s');

                $mod->idKriteria = $dok->id;

                $mod->save(false);
            }
           $this->pendingtask($icnopetindak1, 15);
           $this->notifikasi($icnopetindak1, 
           "Laporan Kemajuan Pengajian (LKP) menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', 
           ['lkk/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']));

            $this->notifikasi($model->icno, "Progress Report have been successfully rating. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['rating?i=' . $model->reportID]);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }


        return $this->render('_rating', [

            //              'iklan' => $iklan,
            'model' => $model,
            'mod' => $mod,
            'p' => $p,
            'rating' => $rating,
            'lkk' => $lkk,
            'm' => $m,
            'bil' => '1',
            'edit' => $edit,
            'view' => $view,
            'research' => $research, 'progress' => $progress, 'i' => $i
        ]);
    }
     protected function pendingtask($icno, $id){
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }
    public function actionRatingUms($i)
    {

        $icno = Yii::$app->user->getId();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $i]);
        $research = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
        $mod = new \app\models\cbelajar\Rating();
        $pro = new \app\models\cbelajar\Progress();
        $m = new \app\models\cbelajar\TblResearch();
        $progress = \app\models\cbelajar\RefProgress::find()->all();
        $rating = \app\models\cbelajar\RefRating::find()->all();
        $lkk = \app\models\cbelajar\RefResearch::find()->all();
        $pegawai = \app\models\hronline\Department::findOne(['id' => $model->kakitangan->DeptId]) ; 
        $p = $this->findPengajian1($icno);
        //        $iklan = $this->findIklanbyID($id);
if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $model->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        $model->app_by = $pegawaisub->chief; //kj 
        }

        
        if($model->ver_by == '')
        { 
            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $model->app_by;
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->status_r = 'DONE';
            $model->r_dt = date('Y-m-d H:i:s');
            if ($model->status_r == 'DONE') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Rating successfully been saved!']);
                $model->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);
            foreach ($rating as $dok) {
                $mod = new \app\models\cbelajar\Rating();
                $mod->p_komen = Yii::$app->request->post($dok->id);
                $mod->idLkk = $model->reportID;
                $mod->p_icno = $icno;
                $mod->idKriteria = $dok->id;
                $mod->dt_rating = date('Y-m-d H:i:s');
                $mod->save(false);
            }
           $this->notifikasi($icnopetindak1, "Laporan Kemajuan Pengajian (LKP) menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['lkk/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']));
            $this->notifikasi($model->icno, "Progress Report have been successfully rating. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['rating-ums?i=' . $model->reportID]);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan' && $model->agree_p ==1) {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }


        return $this->render('_ratingums', [

            //              'iklan' => $iklan,
            'model' => $model,
            'mod' => $mod,
            'p' => $p,
            'rating' => $rating,
            'lkk' => $lkk,
            'm' => $m,
            'bil' => '1',
            'edit' => $edit,
            'view' => $view,
            'research' => $research, 'progress' => $progress, 'i' => $i
        ]);
    }
    
    public function actionKjViewRating($i)
    {

        $icno = Yii::$app->user->getId();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $i]);
        $research = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
        $mod = new \app\models\cbelajar\Rating();
        $pro = new \app\models\cbelajar\Progress();
        $m = new \app\models\cbelajar\TblResearch();
        $progress = \app\models\cbelajar\RefProgress::find()->all();
        $rating = \app\models\cbelajar\RefRating::find()->all();
        $lkk = \app\models\cbelajar\RefResearch::find()->all();
        $p = $this->findPengajian1($icno);
        //        $iklan = $this->findIklanbyID($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status_r = 'DONE';
            if ($model->status_r == 'DONE') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Rating successfully been saved!']);
                $model->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);
            foreach ($rating as $dok) {
                $mod = new \app\models\cbelajar\Rating();
                $mod->p_komen = Yii::$app->request->post($dok->id);
                $mod->idLkk = $model->reportID;
                $mod->p_icno = $icno;
                $mod->idKriteria = $dok->id;
                $mod->save(false);
            }

            $this->notifikasi($model->icno, "Progress Report have been successfully saved. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['rating?i=' . $model->reportID]);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }


        return $this->render('_kjrating', [

            //              'iklan' => $iklan,
            'model' => $model,
            'mod' => $mod,
            'p' => $p,
            'rating' => $rating,
            'lkk' => $lkk,
            'm' => $m,
            'bil' => '1',
            'edit' => $edit,
            'view' => $view,
            'research' => $research, 'progress' => $progress, 'i' => $i
        ]);
    }
     public function actionPpViewRating($i)
    {

        $icno = Yii::$app->user->getId();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $i]);
        $research = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
        $mod = new \app\models\cbelajar\Rating();
        $pro = new \app\models\cbelajar\Progress();
        $m = new \app\models\cbelajar\TblResearch();
        $progress = \app\models\cbelajar\RefProgress::find()->all();
        $rating = \app\models\cbelajar\RefRating::find()->all();
        $lkk = \app\models\cbelajar\RefResearch::find()->all();
        $p = $this->findPengajian1($icno);
        //        $iklan = $this->findIklanbyID($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status_r = 'DONE';
            if ($model->status_r == 'DONE') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Rating successfully been saved!']);
                $model->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);
            foreach ($rating as $dok) {
                $mod = new \app\models\cbelajar\Rating();
                $mod->p_komen = Yii::$app->request->post($dok->id);
                $mod->idLkk = $model->reportID;
                $mod->p_icno = $icno;
                $mod->idKriteria = $dok->id;
                $mod->save(false);
            }

            $this->notifikasi($model->icno, "Progress Report have been successfully saved. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['rating?i=' . $model->reportID]);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }


        return $this->render('_pprating', [

            //              'iklan' => $iklan,
            'model' => $model,
            'mod' => $mod,
            'p' => $p,
            'rating' => $rating,
            'lkk' => $lkk,
            'm' => $m,
            'bil' => '1',
            'edit' => $edit,
            'view' => $view,
            'research' => $research, 'progress' => $progress, 'i' => $i
        ]);
    }
     public function actionAViewRating($i)
    {

        $icno = Yii::$app->user->getId();
        $model = TblLkk::findOne(['status_borang' => "Complete", 'reportID' => $i]);
        $research = \app\models\cbelajar\TblResearch::findOne(['idLKK' => $model->reportID]);
        $mod = new \app\models\cbelajar\Rating();
        $pro = new \app\models\cbelajar\Progress();
        $m = new \app\models\cbelajar\TblResearch();
        $progress = \app\models\cbelajar\RefProgress::find()->all();
        $rating = \app\models\cbelajar\RefRating::find()->all();
        $lkk = \app\models\cbelajar\RefResearch::find()->all();
        $p = $this->findPengajian1($icno);
        //        $iklan = $this->findIklanbyID($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status_r = 'DONE';
            if ($model->status_r == 'DONE') {
                Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Rating successfully been saved!']);
                $model->save(false);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            $model->save(false);
            foreach ($rating as $dok) {
                $mod = new \app\models\cbelajar\Rating();
                $mod->p_komen = Yii::$app->request->post($dok->id);
                $mod->idLkk = $model->reportID;
                $mod->p_icno = $icno;
                $mod->idKriteria = $dok->id;
                $mod->save(false);
            }

            $this->notifikasi($model->icno, "Progress Report have been successfully saved. " . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
            return $this->redirect(['rating?i=' . $model->reportID]);
        }
        if ($model->status_jfpiu == 'Diperakukan' || $model->status_jfpiu == 'Tidak Diperakukan') {
            $edit = 'none';
            $view = '';
        } else {
            $view = 'none';
            $edit = '';
        }


        return $this->render('_arating', [

            //              'iklan' => $iklan,
            'model' => $model,
            'mod' => $mod,
            'p' => $p,
            'rating' => $rating,
            'lkk' => $lkk,
            'm' => $m,
            'bil' => '1',
            'edit' => $edit,
            'view' => $view,
            'research' => $research, 'progress' => $progress, 'i' => $i
        ]);
    }
    
    protected function findPengajian1($id)
    {
        return \app\models\cbelajar\TblPengajian::findOne(['icno' => $id]);
    }
}
