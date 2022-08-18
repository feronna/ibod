<?php

namespace app\controllers;

use Yii;
use app\models\hronline\Tblrscoadminpost;
use app\models\hronline\Tblrscoallowance;
use app\models\hronline\TblrscoadminpostSearch;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Adminposition;
use app\models\hronline\ProgramPengajaran;
use app\models\hronline\TblPenempatan;
use app\models\hronline\TblprcobiodataSearch;
use app\models\hronline\Department;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\Updatestatus;
use app\models\survey\TblAktiviti;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use DateTime;
use kartik\mpdf\Pdf;
use app\models\myportfolio\TblPortfolio;
use app\models\myportfolio\TblIkhtisas;
use app\models\myportfolio\TblDimensi;
use app\models\myportfolio\TblPengalaman;
use app\models\myportfolio\TblKompetensi;
use app\models\myportfolio\TblAkauntabiliti;
use app\models\myportfolio\TblTugasUtama;
error_reporting(0);
/**
 * TblrscoadminpostController implements the CRUD actions for Tblrscoadminpost model.
 */
class TblrscoadminpostController extends Controller
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
            
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['admin-post-list', 'admin-post-list-pentadbiran', 'admin-post-list-pentadbiran2', 'admin-post-list-keseluruhan-pentadbiran', 'admin-post-list-akademik', 'admin-post-list-akademik2', 'admin-post-list-keseluruhan-akademik', 'halaman-utama', 'halaman-utama-pentadbiran', 'halaman-utama-akademik', 'admin-view', 'lihat-rekod-kakitangan', 'lihat-rekod-lantikan', 'kemaskini-rekod', 'kemaskini-rekod-lantikan', 'tambah-rekod-lantikan','tambah-allowance'],
//                'rules' => [
//                    [
//                        'actions' => ['admin-post-list', 'admin-post-list-pentadbiran', 'admin-post-list-pentadbiran2', 'admin-post-list-keseluruhan-pentadbiran', 'admin-post-list-akademik', 'admin-post-list-akademik2', 'admin-post-list-keseluruhan-akademik', 'halaman-utama', 'halaman-utama-pentadbiran', 'halaman-utama-akademik', 'admin-view', 'lihat-rekod-kakitangan', 'lihat-rekod-lantikan', 'kemaskini-rekod', 'kemaskini-rekod-lantikan', 'tambah-rekod-lantikan','tambah-allowance'],
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                           $access = Yii::$app->user->identity->accessLevel;
//                           $secondaccess = Yii::$app->user->identity->accessSecondLevel;
//                           
//                           switch ($access) {
//                                case '1':
//                                      return true;
//                                    break;
//                                case '2':
//                                    
//                                    $secondaccess = Yii::$app->user->identity->accessSecondLevel;
//                                    if ($secondaccess=='1') {
//                                        return true;
//                           
//                                    }
//                                    
//                                    elseif ($secondaccess=='11') {
//                                        return true;
//                           
//                                    }
//                                    
//                                    return false;
//                                    break;
//
//
//                                default:
//                                    return false;
//                                    break;
//                            }  
//
//                            return false;
//                        }
//                    ],
//                        [
//                        'actions' => ['viewuser','kemaskini','lihatbiodata'],
//                        'allow' => true,
//                        
//                    ],
//                  
//                ],
//            ],
            
                'access' => [
                'class' => AccessControl::className(),
                'only' => ['admin-post-list', 'admin-post-list-pentadbiran', 'admin-post-list-pentadbiran2', 'admin-post-list-keseluruhan-pentadbiran', 'admin-post-list-akademik', 'admin-post-list-akademik2', 'admin-post-list-keseluruhan-akademik', 'admin-post-list-keseluruhan', 'admin-post-list-terkini', 'admin-post-list-tamat', 'admin-post-list-sah', 'halaman-utama', 'halaman-utama-pentadbiran', 'halaman-utama-akademik', 'halaman-utama-keseluruhan', 'admin-view', 'lihat-rekod-kakitangan', 'lihat-rekod-lantikan', 'kemaskini-rekod', 'kemaskini-rekod-lantikan', 'tambah-rekod-lantikan','tambah-allowance', 'senarai-pegawai-utama'],
                'rules' => [
                    [
                        'actions' => ['admin-post-list', 'admin-post-list-pentadbiran', 'admin-post-list-pentadbiran2', 'admin-post-list-keseluruhan-pentadbiran', 'admin-post-list-akademik', 'admin-post-list-akademik2', 'admin-post-list-keseluruhan-akademik', 'admin-post-list-keseluruhan', 'admin-post-list-terkini', 'admin-post-list-tamat', 'admin-post-list-sah', 'halaman-utama', 'halaman-utama-pentadbiran', 'halaman-utama-akademik', 'halaman-utama-keseluruhan', 'admin-view', 'lihat-rekod-kakitangan', 'lihat-rekod-lantikan', 'kemaskini-rekod', 'kemaskini-rekod-lantikan', 'tambah-rekod-lantikan','tambah-allowance', 'senarai-pegawai-utama'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $icno=Yii::$app->user->getId();
                            if(\app\models\pengesahan\TblAccessCanselori::find()->where(['icno' => $icno,'access' => 1])->exists()){
                                return true;
                            }else{
                                return false;
                            }
                           
                        }
                    ],
                        [
                        'actions' => ['viewuser','kemaskini','lihatbiodata'],
                        'allow' => true,
                        
                    ],
                  
                ],
            ],
                            
        ];
    }

    /**
     * Lists all Tblrscoadminpost models.
     * @return mixed
     */
//    public function actionIndexx()
//    {
//        $searchModel = new TblrscoadminpostSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        //$dataProvider->query->orderBy([ 'adminpos_id' => 'SORT_ASC']);
//        //$dataProvider->query->orderBy([ 'appoinment_date' => 'SORT_ASC']);
//
//        return $this->render('indexx', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }
//    
//     public function actionIndex()
//    {
//        $searchModel = new TblrscoadminpostSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        //$dataProvider->query->orderBy([ 'adminpos_id' => 'SORT_ASC']);
//        //$dataProvider->query->orderBy([ 'appoinment_date' => 'SORT_ASC']);
//
//        return $this->render('index', [
//                'searchModel' => $searchModel,
//                'dataProvider' => $dataProvider,
//        ]);
//    }
//    
     public function actionHalamanUtama()
    {
//        $carian = new Tblprcobiodata();
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->carian(Yii::$app->request->queryParams); 

        return $this->render('halaman-utama', [
                'carian' => $carian,
                'model' => $dataProvider,
        ]);
    }
    
     public function actionHalamanUtamaPentadbiran()
    {
//        $carian = new Tblprcobiodata();
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->carian(Yii::$app->request->queryParams); 

        return $this->render('halaman-utama-pentadbiran', [
                'carian' => $carian,
                'model' => $dataProvider,
        ]);
    }
    
    public function actionHalamanUtamaAkademik()
    {
//        $carian = new Tblprcobiodata();
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->carian(Yii::$app->request->queryParams); 

        return $this->render('halaman-utama-akademik', [
                'carian' => $carian,
                'model' => $dataProvider,
        ]);
    }
    
     public function actionHalamanUtamaKeseluruhan()
    {
//        $carian = new Tblprcobiodata();
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->carian(Yii::$app->request->queryParams); 

        return $this->render('halaman-utama-keseluruhan', [
                'carian' => $carian,
                'model' => $dataProvider,
        ]);
    }
    
    public function actionAdminPostList()
    {
        $peserta =  Tblprcobiodata::find()->all();
       
        $dataProvider = new ActiveDataProvider([

            'query' => Tblrscoadminpost::find()->where(['flag' => [0,1,2]]),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        
        $dataProvider->query->orderBy([
            'adminpos_id' => SORT_ASC,
//            'appoinment_date' => SORT_DESC,
           ]); 
        
        if(isset(Yii::$app->request->queryParams['ICNO'])){
        $dataProvider->query->andFilterWhere(['ICNO' => Yii::$app->request->queryParams['ICNO'] ]);}
        
        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
        $dataProvider->query->andFilterWhere(['adminpos_id' => Yii::$app->request->queryParams['adminpos_id'] ]);}
        
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dataProvider->query->andFilterWhere(['dept_id' => Yii::$app->request->queryParams['dept_id'] ]);}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $dataProvider->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['campus_id'] ]);}
        
        if(isset(Yii::$app->request->queryParams['flag'])){
        $dataProvider->query->andFilterWhere(['flag' => Yii::$app->request->queryParams['flag'] ]);}

        return $this->render('admin-post-list', [
                'peserta' => $peserta,
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                // 'model' => $dataProvider
        ]);
    }
    
//    public function actionAdminPostListKeseluruhanPentadbiran()
//    {
//        $peserta =  Tblprcobiodata::find()->all();
//       
//        $dataProvider = new ActiveDataProvider([
//
//            'query' => Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => [0,1,2], 'category_id' => '2']),
//
//            'pagination' => [
//
//                'pageSize' => 30,
//
//            ],
//        ]);
//        
//        $dataProvider->query->orderBy([
//            new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),
//            'adminpos_id' => SORT_ASC,
//            'appoinment_date' => SORT_DESC,
//           ]); 
//        
//        if(isset(Yii::$app->request->queryParams['ICNO'])){
//        $dataProvider->query->andFilterWhere(['ICNO' => Yii::$app->request->queryParams['ICNO'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
//        $dataProvider->query->andFilterWhere(['adminpos_id' => Yii::$app->request->queryParams['adminpos_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['dept_id'])){
//        $dataProvider->query->andFilterWhere(['dept_id' => Yii::$app->request->queryParams['dept_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['campus_id'])){
//        $dataProvider->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['campus_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['flag'])){
//        $dataProvider->query->andFilterWhere(['flag' => Yii::$app->request->queryParams['flag'] ]);}
//
//        return $this->render('admin-post-list-keseluruhan-pentadbiran', [
//                'peserta' => $peserta,
//                //'searchModel' => $searchModel,
//                'dataProvider' => $dataProvider,
//                // 'model' => $dataProvider
//        ]);
//    }
    
    public function actionAdminPostListKeseluruhanPentadbiran($icno=null,$adminpos_id=null,$dept_id=null,$campus_id=null,$flag=null)
    {
        $peserta =  Tblprcobiodata::find()->all();
       
        $dataProvider = new ActiveDataProvider([

            'query' => Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => [0,1,2], 'category_id' => '2']),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        
        $dataProvider->query->orderBy([
            new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),
            'adminpos_id' => SORT_ASC,
            'appoinment_date' => SORT_DESC,
           ]); 
        
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';
        $adminpos_id? $dataProvider->query->andFilterWhere(['adminpos_id' => $adminpos_id]):'';
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';
        isset($flag)? $dataProvider->query->andFilterWhere(['flag' => $flag]):'';

        return $this->render('admin-post-list-keseluruhan-pentadbiran', [
                'peserta' => $peserta,
                'icno' => $icno,
                'adminpos_id' => $adminpos_id,
                'dept_id' => $dept_id,
                'campus_id' => $campus_id,
                'flag' => $flag,
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                // 'model' => $dataProvider
        ]);
    }
    
//    public function actionAdminPostListKeseluruhanAkademik()
//    {
//        $peserta =  Tblprcobiodata::find()->all();
//       
//        $dataProvider = new ActiveDataProvider([
//
//            'query' => Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => [0,1,2], 'category_id' => '1']),
//
//            'pagination' => [
//
//                'pageSize' => 30,
//
//            ],
//        ]);
//        
//        $dataProvider->query->orderBy([
//            new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),
//            'adminpos_id' => SORT_ASC,
//            'appoinment_date' => SORT_DESC,
//        ]); 
//        
//        if(isset(Yii::$app->request->queryParams['ICNO'])){
//        $dataProvider->query->andFilterWhere(['ICNO' => Yii::$app->request->queryParams['ICNO'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
//        $dataProvider->query->andFilterWhere(['adminpos_id' => Yii::$app->request->queryParams['adminpos_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['dept_id'])){
//        $dataProvider->query->andFilterWhere(['dept_id' => Yii::$app->request->queryParams['dept_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['campus_id'])){
//        $dataProvider->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['campus_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['flag'])){
//        $dataProvider->query->andFilterWhere(['flag' => Yii::$app->request->queryParams['flag'] ]);}
//
//        return $this->render('admin-post-list-keseluruhan-akademik', [
//                'peserta' => $peserta,
//                //'searchModel' => $searchModel,
//                'dataProvider' => $dataProvider,
//                // 'model' => $dataProvider
//        ]);
//    }
    
        public function actionAdminPostListKeseluruhanAkademik($icno=null,$adminpos_id=null,$program_id=null,$dept_id=null,$campus_id=null,$flag=null)
    {
        $peserta =  Tblprcobiodata::find()->all();
       
        $dataProvider = new ActiveDataProvider([

            'query' => Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => [0,1,2], 'category_id' => '1']),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        
        $dataProvider->query->orderBy([
            new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),
            'adminpos_id' => SORT_ASC,
            'appoinment_date' => SORT_DESC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
        
        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
        $adminpos_id? $dataProvider->query->andFilterWhere(['adminpos_id' => $adminpos_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['program_id'])){
        $program_id? $dataProvider->query->andFilterWhere(['program_id' => $program_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['flag'])){
        isset($flag)? $dataProvider->query->andFilterWhere(['flag' => $flag]):'';}

        return $this->render('admin-post-list-keseluruhan-akademik', [
                'peserta' => $peserta,
                'icno' => $icno,
                'adminpos_id' => $adminpos_id,
                'program_id' => $program_id,
                'dept_id' => $dept_id,
                'campus_id' => $campus_id,
                'flag' => $flag,
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                // 'model' => $dataProvider
        ]);
    }
    
       public function actionAdminPostListKeseluruhan($icno=null,$adminpos_id=null,$program_id=null,$dept_id=null,$campus_id=null,$flag=null)
    {
        $peserta =  Tblprcobiodata::find()->all();
       
        $dataProvider = new ActiveDataProvider([

            'query' => Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => [0,1,2], 'category_id' => [1,2]]),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        
        $dataProvider->query->orderBy([
            new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),
            'adminpos_id' => SORT_ASC,
            'appoinment_date' => SORT_DESC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
        
        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
        $adminpos_id? $dataProvider->query->andFilterWhere(['adminpos_id' => $adminpos_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['program_id'])){
        $program_id? $dataProvider->query->andFilterWhere(['program_id' => $program_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['flag'])){
        isset($flag)? $dataProvider->query->andFilterWhere(['flag' => $flag]):'';}

        return $this->render('admin-post-list-keseluruhan', [
                'peserta' => $peserta,
                'icno' => $icno,
                'adminpos_id' => $adminpos_id,
                'program_id' => $program_id,
                'dept_id' => $dept_id,
                'campus_id' => $campus_id,
                'flag' => $flag,
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                // 'model' => $dataProvider
        ]);
    }
    
       public function actionAdminPostListTerkini($icno=null, $adminpos_id=null, $program_id=null, $dept_id=null, $campus_id=null)
    {       
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
        
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => [1,2]]);
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere(['IN', 'adminpos_id', $akadpost]);
//        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);

        $dataProvider = new ActiveDataProvider([

            'query' => $model,

            'pagination' => [

                'pageSize' => 100,

            ],
        ]);
        
        $dataProvider->query->orderBy([
            'adminpos_id' => SORT_ASC,
            'appoinment_date' => SORT_DESC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
        
        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
        $adminpos_id? $dataProvider->query->andFilterWhere(['adminpos_id' => $adminpos_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['program_id'])){
        $program_id? $dataProvider->query->andFilterWhere(['program_id' => $program_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';}

        return $this->render('admin-post-list-terkini', [
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'icno' => $icno,
                'adminpos_id' => $adminpos_id,
                'program_id' => $program_id,
                'dept_id' => $dept_id,
                'campus_id' => $campus_id
                // 'model' => $dataProvider
        ]);
    }
    
           public function actionAdminPostListSah($icno=null, $adminpos_id=null, $program_id=null, $dept_id=null, $campus_id=null)
    {       
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
        
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 0, 'category_id' => [1,2]]);
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere(['IN', 'adminpos_id', $akadpost]);
//        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);

        $dataProvider = new ActiveDataProvider([

            'query' => $model,

            'pagination' => [

                'pageSize' => 100,

            ],
        ]);
        
        $dataProvider->query->orderBy([
            'adminpos_id' => SORT_ASC,
            'appoinment_date' => SORT_DESC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
        
        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
        $adminpos_id? $dataProvider->query->andFilterWhere(['adminpos_id' => $adminpos_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['program_id'])){
        $program_id? $dataProvider->query->andFilterWhere(['program_id' => $program_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';}

        return $this->render('admin-post-list-sah', [
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'icno' => $icno,
                'adminpos_id' => $adminpos_id,
                'program_id' => $program_id,
                'dept_id' => $dept_id,
                'campus_id' => $campus_id
                // 'model' => $dataProvider
        ]);
    }
    
           public function actionAdminPostListTerkiniJfpib($icno=null, $adminpos_id=null, $program_id=null, $dept_id=null, $campus_id=null)
    {       
        $pegawai=Yii::$app->user->getId();

        //if(SetPegawai::find()->where( ['peraku_icno' => $icno] || ['pelulus_icno' => $icno] )->exists()){
        if(Department::find()->where( ['chief' => $pegawai, 'category_id' => 1, 'isActive' => 1] )->exists()){
            //$senarai = Ln::find()->where(['app_by' => $icno])->orderBy(['entry_date' => SORT_ASC]);
            $senarai = Tblrscoadminpost::find()->joinWith('dept')->where(['chief' => $pegawai, 'isActive' => 1, 'flag' => 1, 'category_id' => 1]);
        }       
        $dataProvider = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);
        
//           $model = Tblrscoadminpost::find()->joinWith('dept')->where(['dept_id' => $department->id, 'isActive' => 1, 'category_id' => [1]]);


//        $dataProvider = new ActiveDataProvider([
//
//            'query' => $model,
//
//            'pagination' => [
//
//                'pageSize' => 100,
//
//            ],
//        ]);
        
        $dataProvider->query->orderBy([
            'end_date' => SORT_ASC,
            'adminpos_id' => SORT_ASC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
        
        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
        $adminpos_id? $dataProvider->query->andFilterWhere(['adminpos_id' => $adminpos_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['program_id'])){
        $program_id? $dataProvider->query->andFilterWhere(['program_id' => $program_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';}
        

        return $this->render('admin-post-list-terkini-jfpib', [
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'icno' => $icno,
                'adminpos_id' => $adminpos_id,
                'program_id' => $program_id,
                'dept_id' => $dept_id,
                'campus_id' => $campus_id,
                // 'model' => $dataProvider
        ]);
    }
    
    public function actionAdminPostListTamat($icno=null, $adminpos_id=null, $program_id=null, $dept_id=null, $campus_id=null)
    {    
//        $this->checkingPelantikanTamat();
  
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);

//        $model = Tblrscoadminpost::find()->where(['flag' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id])->andWhere('YEAR(start_date) >= YEAR(NOW() - INTERVAL 3 YEAR)');
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 92 DAY)');
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => [1,2]])->andWhere('end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 92 DAY)');
//        $model = Tblrscoadminpost::find()->where(['flag' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);
//        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);

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
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
        
        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
        $adminpos_id? $dataProvider->query->andFilterWhere(['adminpos_id' => $adminpos_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['program_id'])){
        $program_id? $dataProvider->query->andFilterWhere(['program_id' => $program_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';}
        
//        if(isset(Yii::$app->request->queryParams['flag'])){
//        isset($flag)? $dataProvider->query->andFilterWhere(['flag' => $flag]):'';}

        return $this->render('admin-post-list-tamat', [
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'icno' => $icno,
                'adminpos_id' => $adminpos_id,
                'program_id' => $program_id,
                'dept_id' => $dept_id,
                'campus_id' => $campus_id,
//                'flag' => $flag,
                // 'model' => $dataProvider
        ]);
    }
    
//     public function actionAdminPostListPentadbiran()
//    {
////        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 2]);
////        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 2])->all();
//
////        $array_post_id = [];
////
////        foreach ($akadpost as $r) {
////            $array_post_id[] = $r->id;
////        }
//         
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2']);
////        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2'])->andWhere(['IN', 'adminpos_id', $akadpost]);
////        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);
//
//        $dataProvider = new ActiveDataProvider([
//
//            'query' => $model,
//
//            'pagination' => [
//
//                'pageSize' => 100,
//
//            ],
//        ]);
//        
//        $dataProvider->query->orderBy([
//            'adminpos_id' => SORT_ASC,
//            'appoinment_date' => SORT_DESC,
//        ]); 
//        
//        if(isset(Yii::$app->request->queryParams['ICNO'])){
//        $dataProvider->query->andFilterWhere(['ICNO' => Yii::$app->request->queryParams['ICNO'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
//        $dataProvider->query->andFilterWhere(['adminpos_id' => Yii::$app->request->queryParams['adminpos_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['dept_id'])){
//        $dataProvider->query->andFilterWhere(['dept_id' => Yii::$app->request->queryParams['dept_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['campus_id'])){
//        $dataProvider->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['campus_id'] ]);}
//
//        return $this->render('admin-post-list-pentadbiran', [
//                //'searchModel' => $searchModel,
//                'dataProvider' => $dataProvider,
//                // 'model' => $dataProvider
//        ]);
//    }
    
    public function actionAdminPostListPentadbiran($icno=null, $adminpos_id=null, $dept_id=null, $campus_id=null)
    {
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 2]);
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 2])->all();

//        $array_post_id = [];
//
//        foreach ($akadpost as $r) {
//            $array_post_id[] = $r->id;
//        }
         
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2']);
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2'])->andWhere(['IN', 'adminpos_id', $akadpost]);
//        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);

        $dataProvider = new ActiveDataProvider([

            'query' => $model,

            'pagination' => [

                'pageSize' => 100,

            ],
        ]);
        
        $dataProvider->query->orderBy([
            'adminpos_id' => SORT_ASC,
            'appoinment_date' => SORT_DESC,
        ]); 
        
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';
        $adminpos_id? $dataProvider->query->andFilterWhere(['adminpos_id' => $adminpos_id]):'';
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';

        return $this->render('admin-post-list-pentadbiran', [
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'icno' => $icno,
                'adminpos_id' => $adminpos_id,
                'dept_id' => $dept_id,
                'campus_id' => $campus_id
                // 'model' => $dataProvider
        ]);
    }
    
//    public function actionAdminPostListPentadbiran2()
//    {
////        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 2]);
//         
////        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2'])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 92 DAY)');
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2'])->andWhere('end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 92 DAY)');
////        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2'])->andWhere(['IN', 'adminpos_id', $akadpost])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 90 DAY)');
////        $model = Tblrscoadminpost::find()->where(['flag' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);
////        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);
//
//        $dataProvider = new ActiveDataProvider([
//
//            'query' => $model,
//
//            'pagination' => [
//
//                'pageSize' => 100,
//
//            ],
//        ]);
//        
//        $dataProvider->query->orderBy([           
//            'end_date' => SORT_ASC,
//            'adminpos_id' => SORT_DESC,
//        ]); 
//        
//        if(isset(Yii::$app->request->queryParams['ICNO'])){
//        $dataProvider->query->andFilterWhere(['ICNO' => Yii::$app->request->queryParams['ICNO'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
//        $dataProvider->query->andFilterWhere(['adminpos_id' => Yii::$app->request->queryParams['adminpos_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['dept_id'])){
//        $dataProvider->query->andFilterWhere(['dept_id' => Yii::$app->request->queryParams['dept_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['campus_id'])){
//        $dataProvider->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['campus_id'] ]);}
//
//        return $this->render('admin-post-list-pentadbiran2', [
//                //'searchModel' => $searchModel,
//                'dataProvider' => $dataProvider,
//                // 'model' => $dataProvider
//        ]);
//    }
    
     public function actionAdminPostListPentadbiran2($icno=null, $adminpos_id=null, $dept_id=null, $campus_id=null)
    {
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 2]);
         
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2'])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 92 DAY)');
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2'])->andWhere('end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 92 DAY)');
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2'])->andWhere(['IN', 'adminpos_id', $akadpost])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 90 DAY)');
//        $model = Tblrscoadminpost::find()->where(['flag' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);
//        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);

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
        
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';
        $adminpos_id? $dataProvider->query->andFilterWhere(['adminpos_id' => $adminpos_id]):'';
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';
//        isset($flag)? $dataProvider->query->andFilterWhere(['flag' => $flag]):'';

        return $this->render('admin-post-list-pentadbiran2', [
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'icno' => $icno,
                'adminpos_id' => $adminpos_id,
                'dept_id' => $dept_id,
                'campus_id' => $campus_id,
//                'flag' => $flag,
                // 'model' => $dataProvider
        ]);
    }

//    public function actionAdminPostListAkademik()
//    {       
////        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
//        
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1']);
////        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere(['IN', 'adminpos_id', $akadpost]);
////        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);
//
//        $dataProvider = new ActiveDataProvider([
//
//            'query' => $model,
//
//            'pagination' => [
//
//                'pageSize' => 100,
//
//            ],
//        ]);
//        
//        $dataProvider->query->orderBy([
//            'adminpos_id' => SORT_ASC,
//            'appoinment_date' => SORT_DESC,
//        ]); 
//        
//        if(isset(Yii::$app->request->queryParams['ICNO'])){
//        $dataProvider->query->andFilterWhere(['ICNO' => Yii::$app->request->queryParams['ICNO'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
//        $dataProvider->query->andFilterWhere(['adminpos_id' => Yii::$app->request->queryParams['adminpos_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['dept_id'])){
//        $dataProvider->query->andFilterWhere(['dept_id' => Yii::$app->request->queryParams['dept_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['campus_id'])){
//        $dataProvider->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['campus_id'] ]);}
//
//        return $this->render('admin-post-list-akademik', [
//                //'searchModel' => $searchModel,
//                'dataProvider' => $dataProvider,
//                // 'model' => $dataProvider
//        ]);
//    }
    
        public function actionAdminPostListAkademik($icno=null, $adminpos_id=null, $program_id=null, $dept_id=null, $campus_id=null)
    {       
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
        
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1']);
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere(['IN', 'adminpos_id', $akadpost]);
//        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);

        $dataProvider = new ActiveDataProvider([

            'query' => $model,

            'pagination' => [

                'pageSize' => 100,

            ],
        ]);
        
        $dataProvider->query->orderBy([
            'adminpos_id' => SORT_ASC,
            'appoinment_date' => SORT_DESC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
        
        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
        $adminpos_id? $dataProvider->query->andFilterWhere(['adminpos_id' => $adminpos_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['program_id'])){
        $program_id? $dataProvider->query->andFilterWhere(['program_id' => $program_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';}

        return $this->render('admin-post-list-akademik', [
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'icno' => $icno,
                'adminpos_id' => $adminpos_id,
                'program_id' => $program_id,
                'dept_id' => $dept_id,
                'campus_id' => $campus_id
                // 'model' => $dataProvider
        ]);
    }

//    public function actionAdminPostListAkademik2()
//    {       
////        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
//
////        $model = Tblrscoadminpost::find()->where(['flag' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id])->andWhere('YEAR(start_date) >= YEAR(NOW() - INTERVAL 3 YEAR)');
////        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 92 DAY)');
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere('end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 92 DAY)');
////        $model = Tblrscoadminpost::find()->where(['flag' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);
////        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);
//
//        $dataProvider = new ActiveDataProvider([
//
//            'query' => $model,
//
//            'pagination' => [
//
//                'pageSize' => 100,
//
//            ],
//        ]);
//        
//        $dataProvider->query->orderBy([
//            'end_date' => SORT_ASC,
//            'adminpos_id' => SORT_DESC,
//        ]); 
//        
//        if(isset(Yii::$app->request->queryParams['ICNO'])){
//        $dataProvider->query->andFilterWhere(['ICNO' => Yii::$app->request->queryParams['ICNO'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
//        $dataProvider->query->andFilterWhere(['adminpos_id' => Yii::$app->request->queryParams['adminpos_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['dept_id'])){
//        $dataProvider->query->andFilterWhere(['dept_id' => Yii::$app->request->queryParams['dept_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['campus_id'])){
//        $dataProvider->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['campus_id'] ]);}
//
//        return $this->render('admin-post-list-akademik2', [
//                //'searchModel' => $searchModel,
//                'dataProvider' => $dataProvider,
//                // 'model' => $dataProvider
//        ]);
//    }
    
    public function actionAdminPostListAkademik2($icno=null, $adminpos_id=null, $program_id=null, $dept_id=null, $campus_id=null)
    {       
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);

//        $model = Tblrscoadminpost::find()->where(['flag' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id])->andWhere('YEAR(start_date) >= YEAR(NOW() - INTERVAL 3 YEAR)');
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 92 DAY)');
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere('end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 92 DAY)');
//        $model = Tblrscoadminpost::find()->where(['flag' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);
//        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);

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
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
        
        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
        $adminpos_id? $dataProvider->query->andFilterWhere(['adminpos_id' => $adminpos_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['program_id'])){
        $program_id? $dataProvider->query->andFilterWhere(['program_id' => $program_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';}
        
//        if(isset(Yii::$app->request->queryParams['flag'])){
//        isset($flag)? $dataProvider->query->andFilterWhere(['flag' => $flag]):'';}

        return $this->render('admin-post-list-akademik2', [
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'icno' => $icno,
                'adminpos_id' => $adminpos_id,
                'program_id' => $program_id,
                'dept_id' => $dept_id,
                'campus_id' => $campus_id,
//                'flag' => $flag,
                // 'model' => $dataProvider
        ]);
    }

    /**
     * Displays a single Tblrscoadminpost model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionLihatRekodLantikan($id)
    {
        $job_group = Tblrscoadminpost::findOne(['id'=>$id])->adminpos->position_type;
        $biodata = Tblprcobiodata::findOne([$this->findModel($id)]);
        return $this->render('lihat-rekod-lantikan', [
            'model' => $this->findModel($id),
            'job_group' => $job_group,
            'biodata' => $biodata,
        ]);
    }
    
     public function actionLihatRekodLantikanSemua($id)
    {
        $job_group = Tblrscoadminpost::findOne(['id'=>$id])->adminpos->position_type;
        $biodata = Tblprcobiodata::findOne([$this->findModel($id)]);
        return $this->render('lihat-rekod-lantikan-semua', [
            'model' => $this->findModel($id),
            'job_group' => $job_group,
            'biodata' => $biodata,
        ]);
    }
    
     public function actionLihatAllowance($id)
    {
        $job_group = Tblrscoadminpost::findOne(['id'=>$id]);
        return $this->render('lihat-allowance', [
            'model' => $this->findModel3($id),
            'job_group' => $job_group,
        ]);
    }

    public function actionAdminView($id) {
        $id = $id;
        $model = $this->findModel2($id); 
    
        $usern = $id;
        $query= Updatestatus::find()->where(['usern' => $usern])->andFilterWhere(['like', 'COTableName','tblrscoadminpost'])->orderBy(['COUpadteDate' => SORT_DESC]);
       
        $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  10
           ],
            
       ]);
           
        return $this->render('admin-view', [
            'model' => $model,
            'provider' => $provider
        ]);
    }
    
     public function actionLihatRekodKakitangan($ICNO) 
    {        
        $query= Tblrscoadminpost::find()->where(['ICNO' => $ICNO])->orderBy(['start_date'=>SORT_DESC]);
        
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        return $this->render('lihat-rekod-kakitangan', [ 
            'ICNO' => $ICNO,
            'provider' => $provider,
        ]);
    }
    
     public function actionLihatRekodAllowance($ICNO) 
    {
        $query= Tblrscoallowance::find()->where(['ICNO' => $ICNO])->orderBy(['id' => SORT_DESC]);
       
        $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  10
           ],   
        ]);
        
        return $this->render('lihat-rekod-allowance', [
            'ICNO' => $ICNO,
            'provider' => $provider
        ]);
    } 

    public function actionKemaskiniRekod($ICNO) 
    {
        $ICNO = $ICNO;
        $model = $this->findModelbyicno($ICNO);
        
        return $this->render('kemaskini-rekod', [
            'model' => $model, 
            'ICNO' => $ICNO,
        ]);
    }

    /**
     * Creates a new Tblrscoadminpost model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionTambahRekodLantikan()
//    {
//        $model = new Tblrscoadminpost();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['lihat-rekod-lantikan', 'id' => $model->id]);
//        }
//
//        return $this->render('tambah-rekod-lantikan', [
//            'model' => $model,
//        ]);
//    }
    
//     public function actionTambahRekodLantikan($ICNO)
//    {
////        $request = Yii::$app->request;
//        $job_group = Tblprcobiodata::findOne(['ICNO'=>$ICNO])->jawatan->job_category;
//        $admin=Yii::$app->user->getId();
//        $biodata = Tblprcobiodata::findOne(['ICNO'=>$ICNO]);               
//        $model = new Tblrscoadminpost();
//        $update = new Updatestatus();
////        $penempatan = new TblPenempatan();
//        
////        $adminPosition =  ArrayHelper::map(app\models\hronline\Adminposition::find()->all(), 'id', 'position_name');
////        $jobStatus =  ArrayHelper::map(app\models\hronline\Jobstatus::find()->all(), 'jobstatus_id', 'jobstatus_desc');
////        $paymentStatus = ArrayHelper::map(app\models\hronline\Paymentstatus::find()->all(), 'paymentstatus_id', 'paymentstatus_desc');
////        $department = ArrayHelper::map(Department::find()->all(), 'id', 'fullname');
////        $campus = ArrayHelper::map(Campus::find()->all(), 'campus_id', 'campus_name');
////        $flag = ArrayHelper::map(\app\models\hronline\Flag::find()->all(), 'flag_id', 'FlagStatus');
////        $renew = ArrayHelper::map(\app\models\hronline\Renew::find()->all(), 'renew_id', 'RenewStatus');
//        
////        $model->reason = 5;
//        $model->flag = 0;
//        
//        $file = UploadedFile::getInstance($model, 'file');
//        
//        if ($model->load(Yii::$app->request->post())){ 
//            
//            $model->ICNO = $ICNO;
//            $model->update_by = $admin;
//            $model->update_date = date('Y-m-d H:i:s');
////            $model->files = UploadedFile::getInstance($model, 'files');
////            if ($model->files) {
////                 
////                $file_name = $model->files . '.' . $model->files->getExtension();
////                $file_path = 'uploads/rekodlantikan/' . $file_name;
////                $model->files->saveAs($file_path);
////                $model->files = $file_path;
////            }
//
//            if($file){
//                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'rekodlantikan');
//                $filepath = $fileapi->file_name_hashcode;      
//            }
//            else{
//                $filepath = '';
//            }
//
//            $model->files = $filepath;
//           
////            $Tblrscoadminpost = $request->post()['Tblrscoadminpost'];
//            $model->save();
//
////            $biodata->DeptId = $model->dept_id;
////            $biodata->campus_id = $model->campus_id;
////            $biodata->jawatanTadbir = $model->jawatantadbir_id;
////            $biodata->last_update = date('Y-m-d H:i:s');
////            $biodata->last_updater = $admin;
////            $biodata->save();
//
//            
////            $changes = [];
////            $tempObj = Tblrscoadminpost::findOne(['ICNO'=>$ICNO]);
////            $attrib = $model->activeAttributes();
////            for($i=0;$i<count($attrib);$i++){
////
////                if($tempObj->{$attrib[$i]}!=$model->{$attrib[$i]}){
////                    array_push($changes,[$attrib[$i],$tempObj->{$attrib[$i]},$model->{$attrib[$i]}]);   
////                }
////       
////            }
////            //$update->usern = Yii::$app->user->getId();
////            $update->usern = $ICNO;
////            $update->COUpdateCompUser = Yii::$app->user->getId();
////            $update->COTableName = 'tblrscoadminpost';
////            $update->COActivity = 0;
////            $update->COUpadteDate = date('Y-m-d H:i:s');
////            $update->COUpdateIP = $this->getRealUserIp();
////            $update->COUpdateComp = $this->getRealUserIp();
////            $update->COUpdateSQL = serialize($changes);
////            $update->idval = $model->id;
////            $update->save();
//            
//            
////            $penempatan->ICNO = $ICNO;
////            $penempatan->date_start = $model->penempatan_date;
////            $penempatan->date_update = date('Y-m-d H:i:s');
////            $penempatan->dept_id = $model->dept_id;
////            $penempatan->campus_id = $model->campus_id;
////            $penempatan->reason_id = $model->reason;
////            $penempatan->remark = $model->remark;
////            $penempatan->letter_order_refno = $model->letter_order_refno;
////            $penempatan->date_letter_order = $model->date_letter_order;
////            $penempatan->letter_refno = $model->letter_refno;
////            $penempatan->update_by = $admin;
////            $penempatan->save();
//            
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
//            
//            return $this->redirect(['lihat-rekod-kakitangan', 'ICNO' => $model->ICNO]);
//        }
//
//        return $this->render('tambah-rekod-lantikan', [
//            'model' => $model,
//            'ICNO' => $ICNO,
//            'job_group' => $job_group,
//            'biodata' => $biodata,
//             'admin' => $admin,
////            'adminPosition' => $adminPosition,
////            'jobStatus' => $jobStatus,
////            'paymentStatus' =>  $paymentStatus,
////            'department' => $department,
////            'campus' => $campus,
////            'flag' => $flag,
////            'renew' => $renew,
//            
//        ]);
//    }
    
         public function actionTambahRekodLantikan($ICNO, $aktiviti_id = null)
    {
        $job_group = Tblprcobiodata::findOne(['ICNO'=>$ICNO])->jawatan->job_category;
        $admin=Yii::$app->user->getId();
        $biodata = Tblprcobiodata::findOne(['ICNO'=>$ICNO]);               
        $model = new Tblrscoadminpost();
        $update = new Updatestatus();

        
        //aktiviti id sekiranya perlantikan dibuat melalui e-survey
        //by miji 30/4/2021
        if($aktiviti_id){
            $survey = TblAktiviti::findOne($aktiviti_id);
            $model->adminpos_id = $survey->adminpos_id;
            $model->program_id = $survey->program_id;
            $model->dept_id = $survey->dept_id;
            $model->description = $survey->catatan;
            $model->campus_id = 1;
        }

        $model->flag = 0;
        
        if ($model->load(Yii::$app->request->post())) {
            
            $model->ICNO = $ICNO;
            $model->update_by = $admin;
            $model->update_date = date('Y-m-d H:i:s');
            $model->file = UploadedFile::getInstance($model, 'file');
            
            if ($model->file){
                if ($model->save()) {
                    $id = $model->id;
                    $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Lantikan');
                    if ($res->status == true){
                        $model->files = $res->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => ':)', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['lihat-rekod-kakitangan', 'ICNO' => $model->ICNO]);
                    }else{
                        Tblrscoadminpost::deleteAll(['id'=>$id]);
                        Yii::$app->session->setFlash('alert', ['title' => ':(', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                        return $this->redirect(['lihat-rekod-kakitangan', 'ICNO' => $model->ICNO]);
                    }                 
               }
            }
            
            else{
                Yii::$app->session->setFlash('alert', ['title' => ':(', 'type' => 'error', 'msg' => 'Sila muatnaik dokumen berkaitan!']); 
            }                    
        }

        return $this->render('tambah-rekod-lantikan', [
            'model' => $model,
            'ICNO' => $ICNO,
            'job_group' => $job_group,
            'biodata' => $biodata,
             'admin' => $admin,
            
        ]);
    }
    
    //untuk tambah rekod lantikan yang lama@expired
             public function actionTambahRekodLantikanLama($ICNO) 
    {
        $job_group = Tblprcobiodata::findOne(['ICNO'=>$ICNO])->jawatan->job_category;
        $admin=Yii::$app->user->getId();
        $biodata = Tblprcobiodata::findOne(['ICNO'=>$ICNO]);               
        $model = new Tblrscoadminpost();
        $update = new Updatestatus();
        $model->flag = 2;
        
        if ($model->load(Yii::$app->request->post())) {
            
            $model->ICNO = $ICNO;
            $model->update_by = $admin;
            $model->update_date = date('Y-m-d H:i:s');
            $model->file = UploadedFile::getInstance($model, 'file');
            
            if ($model->file){
                if ($model->save()) {
                    $id = $model->id;
                    $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Lantikan');
                    if ($res->status == true){
                        $model->files = $res->file_name_hashcode;
                        $model->save();
                        Yii::$app->session->setFlash('alert', ['title' => ':)', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                         return $this->redirect(['lihat-rekod-kakitangan', 'ICNO' => $model->ICNO]);
                    }else{
                        Tblrscoadminpost::deleteAll(['id'=>$id]);
                        Yii::$app->session->setFlash('alert', ['title' => ':(', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya disimpan!']);
                        return $this->redirect(['lihat-rekod-kakitangan', 'ICNO' => $model->ICNO]);
                    }                 
               }
            }
            
            else{
                Yii::$app->session->setFlash('alert', ['title' => ':(', 'type' => 'error', 'msg' => 'Sila muatnaik dokumen berkaitan!']); 
            }                    
        }

        return $this->render('tambah-rekod-lantikan-lama', [
            'model' => $model,
            'ICNO' => $ICNO,
            'job_group' => $job_group,
            'biodata' => $biodata,
             'admin' => $admin,
            
        ]);
    }
    
     public function actionTambahAllowance($ICNO)
    {
//        $request = Yii::$app->request;
        $job_group = Tblprcobiodata::findOne(['ICNO'=>$ICNO])->jawatan->job_category;

        //var_dump($biodata);die;                
        $model = new Tblrscoallowance();

        
//        $adminPosition =  ArrayHelper::map(app\models\hronline\Adminposition::find()->all(), 'id', 'position_name');
//        $jobStatus =  ArrayHelper::map(app\models\hronline\Jobstatus::find()->all(), 'jobstatus_id', 'jobstatus_desc');
//        $paymentStatus = ArrayHelper::map(app\models\hronline\Paymentstatus::find()->all(), 'paymentstatus_id', 'paymentstatus_desc');
//        $department = ArrayHelper::map(Department::find()->all(), 'id', 'fullname');
//        $campus = ArrayHelper::map(Campus::find()->all(), 'campus_id', 'campus_name');
//        $flag = ArrayHelper::map(\app\models\hronline\Flag::find()->all(), 'flag_id', 'FlagStatus');
//        $renew = ArrayHelper::map(\app\models\hronline\Renew::find()->all(), 'renew_id', 'RenewStatus');

        if ($model->load(Yii::$app->request->post())){ 
            
            $model->ICNO = $ICNO;          
           
//            $Tblrscoadminpost = $request->post()['Tblrscoadminpost'];
            $model->save();  

            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
            
            return $this->redirect(['lihat-rekod-allowance','ICNO' => $model->ICNO] );
//            return $this->redirect(['lihat-allowance', 'id' => $model->id]);
        }

        return $this->render('tambah-allowance', [
            'model' => $model,
            'ICNO' => $ICNO,
            'job_group' => $job_group,
//            'adminPosition' => $adminPosition,
//            'jobStatus' => $jobStatus,
//            'paymentStatus' =>  $paymentStatus,
//            'department' => $department,
//            'campus' => $campus,
//            'flag' => $flag,
//            'renew' => $renew,
            
        ]);
    }


    /**
     * Updates an existing Tblrscoadminpost model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionKemaskiniRekodLantikan($id)
//    {
//
//        //$job_group = Tblprcobiodata::findOne(['ICNO'=>$ICNO])->jawatan->job_category;
//        
//        $job_group = Tblrscoadminpost::findOne(['id'=>$id])->adminpos->position_type;
//        
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['lihat-rekod-lantikan', 'id' => $model->id]);
//        }
//
//        return $this->render('kemaskini-rekod-lantikan', [
//              'model' => $model,
//              'job_group' => $job_group,
//
//        ]);
//    }
    
//     public function actionKemaskiniRekodLantikan($id)
//    {
//
//        //$job_group = Tblprcobiodata::findOne(['ICNO'=>$ICNO])->jawatan->job_category;
//        $biodata = Tblprcobiodata::findOne([$this->findModel($id)]);
//        //var_dump($biodata);die;
//        $admin=Yii::$app->user->getId();
//        $job_group = Tblrscoadminpost::findOne(['id'=>$id])->adminpos->position_type;
//        $update = new UpdateStatus();
//        $model = $this->findModel($id);
//        
//        $file = UploadedFile::getInstance($model, 'file');
//            
//        if ($model->load(Yii::$app->request->post())){
//
//            $model->update_by = $admin;
//            $model->update_date = date('Y-m-d H:i:s');
////            $model->files = UploadedFile::getInstance($model, 'files');
////            if ($model->files) {
////                 
////                $file_name = $model->files . '.' . $model->files->getExtension();
////                $file_path = 'uploads/rekodlantikan/' . $file_name;
////                $model->files->saveAs($file_path);
////                $model->files = $file_path;
////            }
//            
//             if($file){
//                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'rekodlantikan');
//                $filepath = $fileapi->file_name_hashcode;      
//            }
//            else{
//                $filepath = '';
//            }
//
//            $model->files = $filepath;
//            
//            $model->save(false);
//            
////            $biodata->DeptId = $model->dept_id;
////            $biodata->campus_id = $model->campus_id;
////            $biodata->jawatanTadbir = $model->jawatantadbir_id;
////            $biodata->last_update = date('Y-m-d H:i:s');
////            $biodata->last_updater = $admin;
////            $biodata->save();
//            
////            $changes = [];
////            $tempObj = tblrscoadminpost::findOne([$this->findModel($id)]);
////            $attrib = $model->activeAttributes();
////            for($i=0;$i<count($attrib);$i++){
////
////                if($tempObj->{$attrib[$i]}!=$model->{$attrib[$i]}){
////                    array_push($changes,[$attrib[$i],$tempObj->{$attrib[$i]},$model->{$attrib[$i]}]);   
////                }
////       
////            }
////            $update->usern = Yii::$app->user->getId();
////            $update->COUpdateCompUser = Yii::$app->user->getId();
////            $update->COTableName = 'tblrscoadminpost';
////            $update->COActivity = 1;
////            $update->COUpadteDate = date('Y-m-d H:i:s');
////            $update->COUpdateIP = $this->getRealUserIp();
////            $update->COUpdateComp = $this->getRealUserIp();
////            $update->COUpdateSQL = serialize($changes);
////            $update->idval = $model->id;
////            $update->save();
//            
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
//            return $this->redirect(['lihat-rekod-kakitangan', 'ICNO' => $model->ICNO]);
//        }
//
//        return $this->render('kemaskini-rekod-lantikan', [
//              'model' => $model,
//              'job_group' => $job_group,
//              'biodata' => $biodata
//
//        ]);
//    }
    
     public function actionKemaskiniRekodLantikan($id)
    {
        $biodata = Tblprcobiodata::findOne([$this->findModel($id)]);
        $admin=Yii::$app->user->getId();
        $job_group = Tblrscoadminpost::findOne(['id'=>$id])->adminpos->position_type;
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->update_by = $admin;
            $model->update_date = date('Y-m-d H:i:s');
            if ($model->file) {
                if ($model->save(false)) {
                    $id = $model->id;
                    $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'Maklumat Rekod Lantikan');
                    if ($res->status == true){
                        $model->files = $res->file_name_hashcode;
                        $model->save(false);
                        Yii::$app->session->setFlash('alert', ['title' => ':)', 'type' => 'success', 'msg' => 'Maklumat berjaya dikemaskini!']);
                         return $this->redirect(['lihat-rekod-kakitangan', 'ICNO' => $model->ICNO]);
                    }else{
                        Tblrscoadminpost::deleteAll(['id'=>$id]);
                        Yii::$app->session->setFlash('alert', ['title' => ':(', 'type' => 'error', 'msg' => 'Maklumat tidak berjaya dikemaskini!']);
                        return $this->redirect(['lihat-rekod-lantikan-semua', 'id' => $model->id]);
                    }  
               }
            }elseif (!empty($model->files) && $model->files != 'deleted') {
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('alert', ['title' => ':)', 'type' => 'success', 'msg' => 'Maklumat berjaya dikemaskini!']);
                         return $this->redirect(['lihat-rekod-lantikan-semua', 'id' => $model->id]);
                }
            }
            else{
               Yii::$app->session->setFlash('Gagal', "Sila muatnaik fail"); 
            }
        }
        return $this->render('kemaskini-rekod-lantikan', [
              'model' => $model,
              'job_group' => $job_group,
              'biodata' => $biodata
        ]);
    }
    
         public function actionKemaskiniRekodSah($id)
    {

        //$job_group = Tblprcobiodata::findOne(['ICNO'=>$ICNO])->jawatan->job_category;
        $biodata = Tblprcobiodata::findOne([$this->findModel($id)]);
        //var_dump($biodata);die;
        $admin=Yii::$app->user->getId();
        $job_group = Tblrscoadminpost::findOne(['id'=>$id])->adminpos->position_type;
        $model = $this->findModel($id);
        $department = Department::findOne(['id' => $model->dept_id]);
            
        if ($model->load(Yii::$app->request->post())){

            $model->update_by = $admin;
            $model->update_date = date('Y-m-d H:i:s');
            
            $model->save(false);
            
            if (($model->adminpos_id == 3) || ($model->adminpos_id == 7) || ($model->adminpos_id == 12)) {

            if(($department->id != 138) && ($department->id != 15) && ($department->id != 164) && ($department->id != 188)){ //jaquira sila buat function utk lantikan utk dekan utk mengubah chief dlm department

                    $department->chief = $model->ICNO;
                    $department->save(false);
                } 
            } 
            
            if ($model->adminpos_id == 25) {
            $department->pp = $model->ICNO;
            $department->save(false);}
            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
            return $this->redirect(['admin-post-list-sah']);
        }

        return $this->renderAjax('kemaskini-rekod-sah', [
              'model' => $model,
              'job_group' => $job_group,
              'biodata' => $biodata,
              'department' => $department

        ]);
    }
    
//         public function actionLantikanSemula($id){
//         
//                $model = $this->findModel($id);
//                //$model->ver_date = date('Y-m-d H:i:s');
//                $today = date('Y-m-d');
//                $admin=Yii::$app->user->getId();
//                $request = Yii::$app->request;
//                $model->flag = 0;
//                $tmp = $this->findModel($id);
//                $message = '';
//                    
//                if(Yii::$app->request->post()){
//                    $post=Yii::$app->request->post('Tblrscoadminpost');
//
//                          $Tblrscoadminpost = $request->post()['Tblrscoadminpost'];     
//                          $description = $Tblrscoadminpost['description'];
//                          $appoinment_date = $Tblrscoadminpost['appoinment_date'];
//                          $start_date = $Tblrscoadminpost['start_date'];
//                          $end_date = $Tblrscoadminpost['end_date'];
//                          $model->description = $description;
//                          $model->appoinment_date = $appoinment_date;
//                          $model->start_date = $start_date;
//                          $model->end_date = $end_date;
//                          $model->save();
//                           $message = 'Berjaya Disimpan';
//                }
//            return $this->renderAjax('lantikan-semula', [
//                'model' => $model,
//                'today' => $today,
//                'tmp' => $tmp,
//                'message' => $message,
//            ]); 
//    }

     public function actionLantikanSemula($id=NULL, $ICNO=NULL)
    {
        $request = Yii::$app->request;
        $admin=Yii::$app->user->getId();
        $biodata = $this->findModel($id);

//        $tmp = $this->findModel($id);
        $model = new Tblrscoadminpost();
        $model->flag = 0;

        if ($model->load(Yii::$app->request->post())){ 
            
            $model->ICNO = $biodata->ICNO;
            $model->adminpos_id = $biodata->adminpos_id;
            $model->program_id = $biodata->program_id;
            $model->jobStatus = $biodata->jobStatus;
            $model->paymentStatus = $biodata->paymentStatus;
            $model->dept_id = $biodata->dept_id;
            $model->campus_id = $biodata->campus_id;
            $model->update_by = $admin;
            $model->update_date = date('Y-m-d H:i:s');
        
//                          $Tblrscoadminpost = $request->post()['Tblrscoadminpost']; 
//                          $description = $Tblrscoadminpost['description'];
//                          $appoinment_date = $Tblrscoadminpost['appoinment_date'];
//                          $start_date = $Tblrscoadminpost['start_date'];
//                          $end_date = $Tblrscoadminpost['end_date'];
//                          $model->description = $description;
//                          $model->appoinment_date = $appoinment_date;
//                          $model->start_date = $start_date;
//                          $model->end_date = $end_date;
            $model->save(false);
            
            $biodata->renew = 1; 
            $biodata->save(false);
        
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
            
            return $this->redirect(['admin-post-list-tamat']);
        }

        return $this->renderAjax('lantikan-semula', [
            'model' => $model,
            'admin' => $admin,
//            'tmp' => $tmp,
            'biodata' => $biodata,
            
        ]);
    }
    
         public function actionKemaskiniRekodAllowance($id)
    {
        $model = $this->findModel3($id);

        if ($model->load(Yii::$app->request->post())){
            
            $model->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
            return $this->redirect(['lihat-rekod-allowance', 'ICNO' => $model->ICNO]);
        }

        return $this->render('kemaskini-rekod-allowance', [
              'model' => $model,

        ]);
    }
    
     public function actionPerubahanData($ICNO) 
    {
        $ICNO = $ICNO;
        $model = $this->findModelbyicno($ICNO);
        
            $usern = $ICNO;
            $query= Updatestatus::find()->where(['usern' => $usern])->andFilterWhere(['like', 'COTableName','tblrscoadminpost'])->orderBy(['COUpadteDate' => SORT_DESC]);
       
           $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  10
           ],
            
       ]);
           
        
        return $this->render('perubahan-data', [
                    'model' => $model, 
                    'ICNO' => $ICNO,
                    'provider' => $provider
        ]);
    }

    /**
     * Deletes an existing Tblrscoadminpost model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['lihat-rekod-kakitangan','ICNO' => $model->ICNO] );
    }
    
     public function actionDelete2($id)
    {
        $model = $this->findModel3($id);
        $this->findModel3($id)->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['lihat-rekod-allowance','ICNO' => $model->ICNO] );
    }
    
     public function actionDeleteData($id) 
    {
         
        $mj = Tblrscoadminpost::findOne($id)->delete();
        
        return $this->redirect(['admin-post-list-sah']);
    }
    
//     protected function findPelantikan() 
//    {
//        return Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => [1,2]])->all();
//    }
//    
//    public function checkingPelantikanTamat() 
//    {
//        $model = $this->findPelantikan();  
//
//        foreach ($model as $m) {
//            
//            $datetime1 = new DateTime($m->end_date);
//            $datetime2 = new DateTIme('now - 2 day'); 
//            $interval = $datetime1->diff($datetime2);
//            if ($interval->format('%d') <= 0){
//                $m->flag = 2;
//                $m->save(false);
//            }
//        }
//    }
    
         public function actionTamatkanRekod($id)
    {

        //$job_group = Tblprcobiodata::findOne(['ICNO'=>$ICNO])->jawatan->job_category;
        $biodata = Tblprcobiodata::findOne([$this->findModel($id)]);
        //var_dump($biodata);die;
        $admin=Yii::$app->user->getId();
        $job_group = Tblrscoadminpost::findOne(['id'=>$id])->adminpos->position_type;
        $model = $this->findModel($id);
            
        if ($model->load(Yii::$app->request->post())){

            $model->update_by = $admin;
            $model->update_date = date('Y-m-d H:i:s');
            
            $model->save(false);
            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditamatkan']);
            return $this->redirect(['admin-post-list-keseluruhan']);
        }

        return $this->renderAjax('tamatkan-rekod', [
              'model' => $model,
              'job_group' => $job_group,
              'biodata' => $biodata

        ]);
    }

    /**
     * Finds the Tblrscoadminpost model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tblrscoadminpost the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    function getRealUserIp()
    {
        switch (true) {
            case (!empty($_SERVER['HTTP_X_REAL_IP'])):
                return $_SERVER['HTTP_X_REAL_IP'];
            case (!empty($_SERVER['HTTP_CLIENT_IP'])):
                return $_SERVER['HTTP_CLIENT_IP'];
            case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            default:
                return $_SERVER['REMOTE_ADDR'];
        }
    }
    
//    public function actionReportpentadbiran()
//    {
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 2])->all();
//
//        $array_post_id = [];
//
//        foreach ($akadpost as $r) {
//            $array_post_id[] = $r->id;
//        }
//        
//         $status = isset(Yii::$app->request->queryParams['status'])?Yii::$app->request->queryParams['status']:'';
//         if ($status != '') {
//             $model = Tblrscoadminpost::find()->where(['IN', 'adminpos_id', $array_post_id])->andWhere(['flag' => '1', 'dept_id' => $status])->all();   
//         } 
//         else{
//             $model = Tblrscoadminpost::find()->where(['IN', 'adminpos_id', $array_post_id])->andWhere(['flag' => '1'])->all();
//         }
//        return $this->render('reportpentadbiran',['model' =>$model]
//        ); 
//    }
    
//    //    admin-post-list-pentadbiran (Papar Lantikan Terkini)
//     public function actionReportpentadbiran($icno = NULL, $admin = NULL, $dept = NULL, $campus = NULL)
//    {
////        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 2]);
//         
////        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 2])->all();
////
////        $array_post_id = [];
////
////        foreach ($akadpost as $r) {
////            $array_post_id[] = $r->id;
////        }
////        
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => '1', 'category_id' => '2'])->orderBy(['adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
////        $model = Tblrscoadminpost::find()->where(['IN', 'adminpos_id', $akadpost])->andWhere(['flag' => '1']);   
////        $model = Tblrscoadminpost::find()->where(['IN', 'adminpos_id', $array_post_id])->andWhere(['flag' => '1']);   
//        
//        $icno? $model->andWhere(['ICNO' => $icno]):'';
//        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
//        $dept? $model->andWhere(['dept_id' => $dept]):'';
//        $campus? $model->andWhere(['campus_id' => $campus]):'';
//        
//        return $this->render('reportpentadbiran', [
//                //'searchModel' => $searchModel,
//                'model' =>$model->all()
//                // 'model' => $dataProvider
//        ]);
//    }
    
//    admin-post-list-pentadbiran (Papar Lantikan Terkini)
     public function actionReportpentadbiran($icno = NULL, $admin = NULL, $dept = NULL, $campus = NULL)
    {
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 2]);
         
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 2])->all();
//
//        $array_post_id = [];
//
//        foreach ($akadpost as $r) {
//            $array_post_id[] = $r->id;
//        }
//        
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => '1', 'category_id' => '2'])->orderBy(['adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
//        $model = Tblrscoadminpost::find()->where(['IN', 'adminpos_id', $akadpost])->andWhere(['flag' => '1']);   
//        $model = Tblrscoadminpost::find()->where(['IN', 'adminpos_id', $array_post_id])->andWhere(['flag' => '1']);   
        
        $icno? $model->andWhere(['icno' => $icno]):'';
        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
        $dept? $model->andWhere(['dept_id' => $dept]):'';
        $campus? $model->andWhere(['campus_id' => $campus]):'';
        
        return $this->render('reportpentadbiran', [
                //'searchModel' => $searchModel,
                'model' =>$model->all()
                // 'model' => $dataProvider
        ]);
    }
    
//    //    admin-post-list-pentadbiran2 (Kontrak 3 Bulan Akan Tamat)
//     public function actionReportpentadbiran2($icno = NULL, $admin = NULL, $dept = NULL, $campus = NULL)
//    {
////        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2'])->andWhere('end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 92 DAY)')->orderBy(['end_date' => SORT_ASC, 'adminpos_id' => SORT_DESC]);
////        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2'])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 92 DAY)')->orderBy(['end_date' => SORT_ASC, 'adminpos_id' => SORT_DESC]);
////        $model = Tblrscoadminpost::find()->where(['flag' => 1])->andWhere(['IN', 'adminpos_id', $akadpost])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 90 DAY)');
//        
//        $icno? $model->andWhere(['ICNO' => $icno]):'';
//        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
//        $dept? $model->andWhere(['dept_id' => $dept]):'';
//        $campus? $model->andWhere(['campus_id' => $campus]):'';
//        
//        return $this->render('reportpentadbiran2', [
//            'model' =>$model->all()
//        ]);
//    }
    
//    admin-post-list-pentadbiran2 (Kontrak 3 Bulan Akan Tamat)
     public function actionReportpentadbiran2($icno = NULL, $admin = NULL, $dept = NULL, $campus = NULL)
    {
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2'])->andWhere('end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 92 DAY)')->orderBy(['end_date' => SORT_ASC, 'adminpos_id' => SORT_DESC]);
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '2'])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 92 DAY)')->orderBy(['end_date' => SORT_ASC, 'adminpos_id' => SORT_DESC]);
//        $model = Tblrscoadminpost::find()->where(['flag' => 1])->andWhere(['IN', 'adminpos_id', $akadpost])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 90 DAY)');
        
        $icno? $model->andWhere(['ICNO' => $icno]):'';
        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
        $dept? $model->andWhere(['dept_id' => $dept]):'';
        $campus? $model->andWhere(['campus_id' => $campus]):'';
        
//        isset($flag)? $model->andWhere(['flag' => $flag]):'';
        
        return $this->render('reportpentadbiran2', [
            'model' =>$model->all()
        ]);
    }
    
//    //    admin-post-list-keseluruhan-pentadbiran (Papar Lantikan Keseluruhan)
//    public function actionReportpentadbiran3($icno = NULL, $admin = NULL, $dept = NULL, $campus = NULL, $flag = NULL)
//    {
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => [0,1,2], 'category_id' => [2]])->orderBy([new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),'adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
//        
//        $icno? $model->andWhere(['ICNO' => $icno]):'';
//        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
//        $dept? $model->andWhere(['dept_id' => $dept]):'';
//        $campus? $model->andWhere(['campus_id' => $campus]):'';
//        $flag? $model->andWhere(['flag' => $flag]):'';
//        
//        return $this->render('reportpentadbiran3', [
//                'model' =>$model->all()
//        ]);
//    }
    
//    admin-post-list-keseluruhan-pentadbiran (Papar Lantikan Keseluruhan)
    public function actionReportpentadbiran3($icno = NULL, $adminpos_id = NULL, $dept_id = NULL, $campus_id = NULL, $flag = NULL)
    {
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => [0,1,2], 'category_id' => [2]])->orderBy([new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),'adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $model->andFilterWhere(['icno' => $icno]):'';}
        
        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
        $adminpos_id? $model->andFilterWhere(['adminpos_id' => $adminpos_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $model->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $model->andFilterWhere(['campus_id' => $campus_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['flag'])){
        isset($flag)? $model->andFilterWhere(['flag' => $flag]):'';}
        
        return $this->render('reportpentadbiran3', [
                'model' =>$model->all()
        ]);
    }
    
//    //    admin-post-list-akademik (Papar Lantikan Terkini)
//    public function actionReportakademik($icno = NULL, $admin = NULL, $dept = NULL, $campus = NULL)
//    {
////        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
//        
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => '1', 'category_id' => '1'])->orderBy(['adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
////        $model = Tblrscoadminpost::find()->where(['IN', 'adminpos_id', $akadpost])->andWhere(['flag' => '1']);  
//        
//        $icno? $model->andWhere(['ICNO' => $icno]):'';
//        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
//        $dept? $model->andWhere(['dept_id' => $dept]):'';
//        $campus? $model->andWhere(['campus_id' => $campus]):'';
//        
//        return $this->render('reportakademik', [
//            'model' =>$model->all()
//        ]);
//    }
    
//    admin-post-list-akademik (Papar Lantikan Terkini)
    public function actionReportakademik($icno = NULL, $admin = NULL, $program = NULL, $dept = NULL, $campus = NULL)
    {
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
        
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => '1', 'category_id' => '1'])->orderBy(['adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
//        $model = Tblrscoadminpost::find()->where(['IN', 'adminpos_id', $akadpost])->andWhere(['flag' => '1']);  
        
        $icno? $model->andWhere(['ICNO' => $icno]):'';
        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
        $program? $model->andWhere(['program_id' => $program]):'';
        $dept? $model->andWhere(['dept_id' => $dept]):'';
        $campus? $model->andWhere(['campus_id' => $campus]):'';
        
        return $this->render('reportakademik', [
            'model' =>$model->all()
        ]);
    }
    
//    //    admin-post-list-akademik2 (Kontrak 3 Bulan Akan Tamat)
//     public function actionReportakademik2($icno = NULL, $admin = NULL, $dept = NULL, $campus = NULL)
//    {
//  
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere('end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 92 DAY)')->orderBy(['end_date' => SORT_ASC, 'adminpos_id' => SORT_DESC]);
////        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 92 DAY)')->orderBy(['end_date' => SORT_ASC, 'adminpos_id' => SORT_DESC]);
//        $icno? $model->andWhere(['ICNO' => $icno]):'';
//        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
//        $dept? $model->andWhere(['dept_id' => $dept]):'';
//        $campus? $model->andWhere(['campus_id' => $campus]):'';
//        
//        return $this->render('reportakademik2', [
//            'model' =>$model->all()
//        ]);
//    }
    
//    admin-post-list-akademik2 (Kontrak 3 Bulan Akan Tamat)
     public function actionReportakademik2($icno = NULL, $admin = NULL, $program = NULL, $dept = NULL, $campus = NULL)
    {
  
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere('end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 92 DAY)')->orderBy(['end_date' => SORT_ASC, 'adminpos_id' => SORT_DESC]);
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 92 DAY)')->orderBy(['end_date' => SORT_ASC, 'adminpos_id' => SORT_DESC]);
        $icno? $model->andWhere(['ICNO' => $icno]):'';
        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
        $program? $model->andWhere(['program_id' => $program]):'';
        $dept? $model->andWhere(['dept_id' => $dept]):'';
        $campus? $model->andWhere(['campus_id' => $campus]):'';
        
//        isset($flag)? $model->andWhere(['flag' => $flag]):'';
        
        return $this->render('reportakademik2', [
            'model' =>$model->all()
        ]);
    }
    
//    //    admin-post-list-keseluruhan-akademik (Papar Lantikan Keseluruhan)
//    public function actionReportakademik3($icno = NULL, $admin = NULL, $dept = NULL, $campus = NULL, $flag = NULL)
//    {
//       
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => [0,1,2], 'category_id' => '1'])->orderBy([new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"), 'adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
//        
//        $icno? $model->andWhere(['ICNO' => $icno]):'';
//        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
//        $dept? $model->andWhere(['dept_id' => $dept]):'';
//        $campus? $model->andWhere(['campus_id' => $campus]):'';
//        $flag? $model->andWhere(['flag' => $flag]):'';
//        
//        return $this->render('reportakademik3', [
//                'model' =>$model->all()
//        ]);
//    }
    
//    admin-post-list-keseluruhan-akademik (Papar Lantikan Keseluruhan)
    public function actionReportakademik3($icno = NULL, $adminpos_id = NULL, $program_id = NULL, $dept_id = NULL, $campus_id = NULL, $flag = NULL)
    {
       
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => [0,1,2], 'category_id' => '1'])->orderBy([new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"), 'adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $model->andFilterWhere(['icno' => $icno]):'';}
        
        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
        $adminpos_id? $model->andFilterWhere(['adminpos_id' => $adminpos_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['program_id'])){
        $program_id? $model->andFilterWhere(['program_id' => $program_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $model->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $model->andFilterWhere(['campus_id' => $campus_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['flag'])){
        isset($flag)? $model->andFilterWhere(['flag' => $flag]):'';}
        
        return $this->render('reportakademik3', [
                'model' =>$model->all()
        ]);
    }
    
    //    admin-post-list-terkini (Papar Lantikan Terkini)
    public function actionReportlantikanterkini($icno = NULL, $admin = NULL, $program = NULL, $dept = NULL, $campus = NULL)
    {
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
        
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => '1', 'category_id' => [1,2]])->orderBy(['adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
//        $model = Tblrscoadminpost::find()->where(['IN', 'adminpos_id', $akadpost])->andWhere(['flag' => '1']);  
        
        $icno? $model->andWhere(['ICNO' => $icno]):'';
        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
        $program? $model->andWhere(['program_id' => $program]):'';
        $dept? $model->andWhere(['dept_id' => $dept]):'';
        $campus? $model->andWhere(['campus_id' => $campus]):'';
        
        return $this->render('report-lantikan-terkini', [
            'model' =>$model->all()
        ]);
    }
    
    //    admin-post-list-terkini-jfpib (Papar Lantikan Terkini Mengikut JFPIB)
    public function actionReportlantikanterkinijfpib($icno = NULL, $admin = NULL, $program = NULL, $dept = NULL, $campus = NULL)
    {
        $pegawai=Yii::$app->user->getId();

        if(Department::find()->where( ['chief' => $pegawai, 'category_id' => 1] )->exists()){
            $model = Tblrscoadminpost::find()->joinWith('dept')->where(['chief' => $pegawai, 'isActive' => 1, 'flag' => '1', 'category_id' => [1]])->orderBy(['adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
        } 
        
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => '1', 'category_id' => [1]])->orderBy(['adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
        
        $icno? $model->andWhere(['ICNO' => $icno]):'';
        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
        $program? $model->andWhere(['program_id' => $program]):'';
        $dept? $model->andWhere(['dept_id' => $dept]):'';
        $campus? $model->andWhere(['campus_id' => $campus]):'';
        
        return $this->render('report-lantikan-terkini-jfpib', [
            'model' =>$model->all()
        ]);
    }
    
    //    admin-post-list-tamat (Kontrak 3 Bulan Akan Tamat)
     public function actionReportlantikantamat($icno = NULL, $admin = NULL, $program = NULL, $dept = NULL, $campus = NULL)
    {
  
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => [1,2]])->andWhere('end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 92 DAY)')->orderBy(['end_date' => SORT_ASC, 'adminpos_id' => SORT_DESC]);
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere('end_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 92 DAY)')->orderBy(['end_date' => SORT_ASC, 'adminpos_id' => SORT_DESC]);
        $icno? $model->andWhere(['ICNO' => $icno]):'';
        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
        $program? $model->andWhere(['program_id' => $program]):'';
        $dept? $model->andWhere(['dept_id' => $dept]):'';
        $campus? $model->andWhere(['campus_id' => $campus]):'';
        
//        isset($flag)? $model->andWhere(['flag' => $flag]):'';
        
        return $this->render('report-lantikan-tamat', [
            'model' =>$model->all()
        ]);
    }
    
    //    admin-post-list-keseluruhan (Papar Lantikan Keseluruhan)
    public function actionReportlantikankeseluruhan($icno = NULL, $adminpos_id = NULL, $program_id = NULL, $dept_id = NULL, $campus_id = NULL, $flag = NULL)
    {
       
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => [0,1,2], 'category_id' => [1,2]])->orderBy([new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"), 'adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $model->andFilterWhere(['icno' => $icno]):'';}
        
        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
        $adminpos_id? $model->andFilterWhere(['adminpos_id' => $adminpos_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['program_id'])){
        $program_id? $model->andFilterWhere(['program_id' => $program_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $model->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $model->andFilterWhere(['campus_id' => $campus_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['flag'])){
        isset($flag)? $model->andFilterWhere(['flag' => $flag]):'';}
        
        return $this->render('report-lantikan-keseluruhan', [
                'model' =>$model->all()
        ]);
    }
    
     //    admin-post-list-sah (Papar Lantikan Belum Sah)
    public function actionReportlantikansah($icno = NULL, $admin = NULL, $program = NULL, $dept = NULL, $campus = NULL)
    {
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
        
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => '0', 'category_id' => [1,2]])->orderBy(['adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
//        $model = Tblrscoadminpost::find()->where(['IN', 'adminpos_id', $akadpost])->andWhere(['flag' => '1']);  
        
        $icno? $model->andWhere(['ICNO' => $icno]):'';
        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
        $program? $model->andWhere(['program_id' => $program]):'';
        $dept? $model->andWhere(['dept_id' => $dept]):'';
        $campus? $model->andWhere(['campus_id' => $campus]):'';
        
        return $this->render('report-lantikan-sah', [
            'model' =>$model->all()
        ]);
    }
    
//    public function actionSenaraiPegawaiUtama()
//    {       
////        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
//        
//        $model = Tblrscoadminpost::find()->where(['adminpos_id' => [1,2,9,13,14,15,16]]);
////        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere(['IN', 'adminpos_id', $akadpost]);
////        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);
//
//        $dataProvider = new ActiveDataProvider([
//
//            'query' => $model,
//
//            'pagination' => [
//
//                'pageSize' => 100,
//
//            ],
//        ]);
//        
//         $dataProvider->query->orderBy([
//            new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),
//            'adminpos_id' => SORT_ASC,
//            'appoinment_date' => SORT_DESC,
//           ]); 
//        
//        if(isset(Yii::$app->request->queryParams['ICNO'])){
//        $dataProvider->query->andFilterWhere(['ICNO' => Yii::$app->request->queryParams['ICNO'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
//        $dataProvider->query->andFilterWhere(['adminpos_id' => Yii::$app->request->queryParams['adminpos_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['dept_id'])){
//        $dataProvider->query->andFilterWhere(['dept_id' => Yii::$app->request->queryParams['dept_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['campus_id'])){
//        $dataProvider->query->andFilterWhere(['campus_id' => Yii::$app->request->queryParams['campus_id'] ]);}
//        
//        if(isset(Yii::$app->request->queryParams['flag'])){
//        $dataProvider->query->andFilterWhere(['flag' => Yii::$app->request->queryParams['flag'] ]);}
//
//        return $this->render('senarai-pegawai-utama', [
//                //'searchModel' => $searchModel,
//                'dataProvider' => $dataProvider,
//                // 'model' => $dataProvider
//        ]);
//    }
    
    public function actionSenaraiPegawaiUtama($icno=null,$adminpos_id=null,$dept_id=null,$campus_id=null,$flag=null)
    {       
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
        
        $model = Tblrscoadminpost::find()->where(['adminpos_id' => [1,2,9,13,14,15,16]]);
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['flag' => 1, 'category_id' => '1'])->andWhere(['IN', 'adminpos_id', $akadpost]);
//        $model = Tblrscoadminpost::find()->joinWith(['kakitangan'])->where(['flag' => 1, 'tblprcobiodata.status' => 1])->andWhere(['IN', 'adminpos_id', $array_post_id]);

        $dataProvider = new ActiveDataProvider([

            'query' => $model,

            'pagination' => [

                'pageSize' => 100,

            ],
        ]);
        
         $dataProvider->query->orderBy([
            new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),
            'adminpos_id' => SORT_ASC,
            'appoinment_date' => SORT_DESC,
           ]); 
        
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';
        $adminpos_id? $dataProvider->query->andFilterWhere(['adminpos_id' => $adminpos_id]):'';
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';
        isset($flag)? $dataProvider->query->andFilterWhere(['flag' => $flag]):'';

        return $this->render('senarai-pegawai-utama', [
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'icno' => $icno,
                'adminpos_id' => $adminpos_id,
                'dept_id' => $dept_id,
                'campus_id' => $campus_id,
                'flag' => $flag,
                // 'model' => $dataProvider
        ]);
    }
    
//        public function actionReportpegawai($icno = NULL, $admin = NULL, $dept = NULL, $campus = NULL, $flag = NULL)
//    {
////        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
//        
//        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['adminpos_id' => [1,2,9,13,14,15,16]])->orderBy([ new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),'adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
////        $model = Tblrscoadminpost::find()->where(['IN', 'adminpos_id', $akadpost])->andWhere(['flag' => '1']);  
//        
//        $icno? $model->andWhere(['ICNO' => $icno]):'';
//        $admin? $model->andWhere(['adminpos_id' => $admin]):'';
//        $dept? $model->andWhere(['dept_id' => $dept]):'';
//        $campus? $model->andWhere(['campus_id' => $campus]):'';
//        $flag? $model->andWhere(['flag' => $flag]) : '';
//        
//        return $this->render('reportpegawai', [
//            'model' =>$model->all()
//        ]);
//    }
    
    public function actionReportpegawai($icno = NULL, $adminpos_id = NULL, $dept_id = NULL, $campus_id = NULL, $flag = NULL)
    {
//        $akadpost = Adminposition::find()->select(['id'])->where(['position_type' => 1]);
        
        $model = Tblrscoadminpost::find()->joinWith('dept')->where(['adminpos_id' => [1,2,9,13,14,15,16]])->orderBy([ new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),'adminpos_id' => SORT_ASC, 'appoinment_date' => SORT_DESC]);   
//        $model = Tblrscoadminpost::find()->where(['IN', 'adminpos_id', $akadpost])->andWhere(['flag' => '1']);  
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $model->andFilterWhere(['icno' => $icno]):'';}
        
        if(isset(Yii::$app->request->queryParams['adminpos_id'])){
        $adminpos_id? $model->andFilterWhere(['adminpos_id' => $adminpos_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $model->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $model->andFilterWhere(['campus_id' => $campus_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['flag'])){
        isset($flag)? $model->andFilterWhere(['flag' => $flag]):'';}
        
        return $this->render('reportpegawai', [
            'model' =>$model->all()
        ]);
    }
    
     public function actionViewRekodStaf($id) {
    
        $biodata = $this->findBiodata1($id);
        $biodata2 = Tblrscoadminpost::find()->where(['ICNO' => $id, 'flag' => [1,2]])->all();
        $biodata3 = $this->findBiodata3($id); 
        
        $deskripsi  = Tblportfolio::find()->where(['icno' => $id])->one();
        $ikhtisas  = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $pengalaman  = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $tugas = TblTugasUtama::find()->where(['akauntabiliti_id'=>$id])->all();
        
        if(\app\models\pengesahan\TblAccessCanselori::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){

        return $this->render('main', [
            'biodata' => $biodata,
            'biodata2' => $biodata2, 
            'biodata3' => $biodata3, 
            'deskripsi' => $deskripsi,
            'ikhtisas' => $ikhtisas,
            'lihatDimensi' => $lihatDimensi,
            'pengalaman' => $pengalaman,
            'lihatKompetensi' => $lihatKompetensi,
            'akauntabiliti' => $akauntabiliti,
            'tugas' => $tugas
            
        ]);
        }
    }
    
    public function actionCetakRekod($id){
        
            $biodata = $this->findBiodata1($id); //return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
            $biodata2 = Tblrscoadminpost::find()->where(['ICNO' => $id, 'flag' => [1,2]])->all();
            $biodata3 = $this->findBiodata3($id);
            
            $deskripsi  = Tblportfolio::find()->where(['icno' => $id])->one();
            $ikhtisas  = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
            $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
            $pengalaman  = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
            $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
            $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
            $tugas = TblTugasUtama::find()->where(['akauntabiliti_id'=>$id])->all();
            
            $content = $this->renderPartial('cetak-rekod', [ 
                'biodata' => $biodata,
                'biodata2' => $biodata2,
                'biodata3' => $biodata3,
                'deskripsi' => $deskripsi,
                'ikhtisas' => $ikhtisas,
                'lihatDimensi' => $lihatDimensi,
                'pengalaman' => $pengalaman,
                'lihatKompetensi' => $lihatKompetensi,
                'akauntabiliti' => $akauntabiliti,
                'tugas' => $tugas
            ]);

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
            // set mPDF properties on the fly
              
            'options' => ['title' => 'Rekod Pengajian Lanjutan Kakitangan'],
            // call mPDF methods on the fly
              
         
            'methods' => [
//              'SetHeader' => ['Permohonan Baharu Pengajian Lanjutan,Unit Pengembangan Profesionalisme'],
                     'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
             
            ] ,           // call mPDF methods on the fly
            
        ]);

        return $pdf->render(); 
    }
    
     protected function findModel($id)
    {
        if (($model = Tblrscoadminpost::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findModel2($id) {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
     protected function findModel3($id)
    {
        if (($model = Tblrscoallowance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findModelbyicno($ICNO) {
        if (($model = Tblrscoadminpost::findAll($ICNO)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelbyicno2($ICNO) {
        if (($model = Tblrscoallowance::findAll(['ICNO' => $ICNO])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findBiodata1($id) {
        return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
    }
         
    protected function findBiodata2($id) {
        return \app\models\hronline\Tblrscoadminpost::findAll(['ICNO' => $id]);
    }   
    
    protected function findBiodata3($id) {
        return \app\models\hronline\Tblrscoconfirmstatus::findAll(['ICNO' => $id]);
    }
 
    public function actionPadam(){
        return Yii::$app->FileManager->DeleteFile('');//insert the code
    }
 
}