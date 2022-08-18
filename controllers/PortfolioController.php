<?php

namespace app\controllers;
use app\models\hronline\Adminposition;
use app\models\hronline\Department;
use app\models\hronline\ProgramPengajaran;
use app\models\hronline\Tblrscoadminpost;
use app\models\talent\GredSettings;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\NotFoundHttpException;
use app\models\hronline\Tblprcobiodata;
use app\models\myportfolio\TblPortfolio;
use app\models\portfolio\TblCartaFungsi;
use app\models\portfolio\TblCartaJabatan;
use app\models\portfolio\SenaraiKetua;
use app\models\portfolio\SenaraiUnit;
use app\models\portfolio\SenaraiSeksyen;
use yii\data\ActiveDataProvider;
use app\models\portfolio\RefSection;
use app\models\portfolio\RefUnit;
use app\models\hronline\StatusLantikan;
use yii\data\ArrayDataProvider;
use app\models\hronline\GredJawatan;
use yii\web\UploadedFile;
use app\models\portfolio\TblCartaOrgan;
use app\models\Notification;
use yii\helpers\Html;
use app\models\portfolio\RefFungsiUnit;
use app\models\ptb\Model;
use app\models\myportfolio\TblIkhtisas;
use app\models\myportfolio\TblDimensi;
use app\models\myportfolio\TblPengalaman;
use app\models\myportfolio\TblKompetensi;
use app\models\myportfolio\TblAkauntabiliti;
use app\models\myportfolio\TblSyaratTambahan;
use app\models\portfolio\TblAkses;

use kartik\mpdf\Pdf;
use app\models\myportfolio\TblTugasUtama;
use yii\helpers\VarDumper;
use app\models\portfolio\TblPeringkat;
use app\models\portfolio\TblSenaraiPeringkat;
use app\models\portfolio\RefPeringkat;
use yii\helpers\Json;
use app\models\portfolio\TblProsesKerja;
use app\models\portfolio\TblProsesKerjaAktiviti;

error_reporting(0);
class PortfolioController extends \yii\web\Controller
{
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
//    public function actionKriteria($post_id = null, $dept_id = null)
//    {
//        $this->view->title = "Kriteria 2 : Dekan / Pengarah / Timbalan";
//        $icno = Yii::$app->user->getId();
//        $biodata = \app\models\hronline\Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
//        $postId = 3;
//        $deptId = $biodata->DeptId;//FKJ by default
//        $holder_icno = null;
//
//        if ($post_id != null) {
//            $postId = $post_id;
//        }
//        if ($dept_id != null) {
//            $deptId = $dept_id;
//        }
//
//        $adminPost = GredSettings::getAdminPostByKriteria(2);
//
//        $arrAdminPost = ArrayHelper::map($adminPost, 'id', 'position_name');
//
//        $department = Department::find()->where(['isActive' => 1])->all();
//        $arrDept = ArrayHelper::map($department, 'id', 'fullname');
//
//        $holder = \app\models\portfolio\TblCartaJabatan::find()->where(['jabatan_id' => $deptId])->orderBy(['level' => SORT_ASC])->one();
//$level = \app\models\portfolio\TblCartaJabatan::find()->where(['jabatan_id' => $deptId ])->one();
//$section = \app\models\portfolio\TblCartaJabatan::find()->where(['jabatan_id' => $deptId, 'level' => $level->level])->one();
//$unit = \app\models\portfolio\TblCartaJabatan::find()->where(['jabatan_id' => $deptId, 'section' => $section->section])->one();
//
//       $holder2 = \app\models\portfolio\TblCartaJabatan::find()->where(['jabatan_id' => $deptId, 'level' => $level->level, 'section' => $section->section])->orderBy(['section' => SORT_ASC])->all();
//
//        $gredList = GredSettings::find()->where(['adminpos_id' => $postId])->orderBy(['sort_no' => SORT_ASC])->all();
//
//        return $this->render('kriteria', [
//            'arrAdminPost' => $arrAdminPost,
//            'arrDept' => $arrDept,
//            'post_id' => $postId,
//            'dept_id' => $deptId,
//            'holder' => $holder,
//            'holder_icno' => $holder_icno,
//            'gredList' => $gredList,
//             'holder2' => $holder2,
//            'section' => $section,
//            'unit' => $unit
//        ]);
//    }
 public function ICNO() {
        return Yii::$app->user->getId();
    }

       public function actionKriteria($post_id = null, $dept_id = null)
    {
        $this->view->title = "Kriteria 2 : Dekan / Pengarah / Timbalan";
        $icno = Yii::$app->user->getId();
        $biodata = \app\models\hronline\Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $postId = 136;
        $deptId = $biodata->DeptId; //FKJ by default
        $holder_icno = null;

        if ($post_id != null) {
            $postId = $post_id;
        }
        if ($dept_id != null) {
            $deptId = $dept_id;
        }

    //   $adminPost = \app\models\portfolio\TblCartaJabatan::getAdminPostByKriteria(2);

   //     $arrAdminPost = ArrayHelper::map($adminPost, 'id', 'position_name');

        $department = Department::find()->where(['isActive' => 1])->all();
        $arrDept = ArrayHelper::map($department, 'id', 'fullname');

       // $holder = Tblrscoadminpost::find()->where(['adminpos_id' => $postId, 'dept_id' => $deptId, 'flag' => 1])->one();
        $holder = \app\models\portfolio\TblCartaJabatan::find()->where(['jabatan_id' => $deptId])->orderBy(['level' => SORT_ASC])->one();

        if ($holder) {
            $icno = $holder->icno;
        }

        $gredList = \app\models\portfolio\TblCartaJabatan::find()->where(['jabatan_id' => $deptId])->all();

        return $this->render('kriteria', [
          //  'arrAdminPost' => $arrAdminPost,
            'arrDept' => $arrDept,
            'post_id' => $postId,
            'dept_id' => $deptId,
            'holder' => $holder,
            'holder_icno' => $holder_icno,
            'gredList' => $gredList,
        ]);
    }
    public function notification($title, $content, $ic = null) {
        if ($ic == null) {
            //default user login selalu guna ic   // null if the user not authenticated.    //get userid after login
            $ic = Yii::$app->user->getId();
        }
        $ntf = new Notification();
        $ntf->icno = $ic;
        $ntf->title = $title;
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        return true;
    }
    
     public function actionIndex()
    {
        return $this->render('index');
    }
     public function actionHalamanUtama()
    {
          $icno = Yii::$app->user->getId();
//          $checking = TblPortfolio::find()->where(['icno' => $icno])->one();
//         
//           if($checking == false){
//            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Perlu Melengkapkan MYJD terlebih dahulu.']);
//            return $this->redirect(['my-portfolio/maklumat-umum']);
//        }
       
        $models = TblPortfolio::find()->where(['icno' => $icno])->orderBy(['id' => SORT_ASC])->all();
        
        $biodata = Tblprcobiodata::find()->where(['ICNO' =>  Yii::$app->user->getId()])->one();
        $lantikan = \app\models\hronline\Tblrscoapmtstatus::find()->where(['ICNO' => $biodata->ICNO])->all();
        $kontrak = \app\models\kontrak\Kontrak::find()->where(['icno' => $biodata->ICNO])->one();
        $anugerah = \app\models\hronline\Tblanugerah::findAll(['ICNO' => $biodata->ICNO]);
        $latihan = \app\models\hronline\Vcpdlatihan::findAll(['vcl_id_staf' => $biodata->ICNO]);
        $pegawai = ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        
        
        return $this->render('halaman-utama',['biodata' => $biodata,
                   'lantikan' => $lantikan,
                    'latihan' => $latihan,
                    'anugerah' => $anugerah,
                    'kontrak' => $kontrak,
                    'pegawai' => $pegawai,
                     'models' => $models
                ]);
    }
    
    
       public function actionMaklumatPegawai($id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        return $this->render('maklumat-pegawai', ['deskripsi' => $deskripsi,
        ]);
    }
     public function actionMaklumatBahagian($id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $deskripsi->icno])->one();
        $jawatan = TblCartaJabatan::find()->where(['jabatan_id' => $biodata->DeptId ])->all();

          $icno = Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = \app\models\portfolio\TblCartaJabatan::find()->joinWith('kakitangan')->where(['tblprcobiodata.DeptID' => $test->DeptId])->all();
         $a= [];
         $b = [];
         $c = [];
         foreach ($model as $model) {
             
             $c['v']=$model->level.'.'.$model->section;
       
            $aa =  '<span><img height= "100" width="150" src="https://hronline.ums.edu.my/picprofile/picstf/'.strtoupper(hash('sha1', $model->icno)).'.jpeg" </span>';
              
         if($model->icno = $icno ){
             if($model->unit != NULL){
                      $c['f'] = 
                     "<br>". "<strong>".strtoupper($model->namaUnit->unit_details)."<br>"."<br>".
                              $aa."<br>"."<br>".$model->kakitangan->CONm.
                       "<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }else{
                      $c['f'] =  "<br>"."<strong>".strtoupper($model->namaSeksyen->section_details)."<br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }
         }else{
               if($model->unit != NULL){
                      $c['f'] = 
                     "<br>". "<strong>".strtoupper($model->namaUnit->unit_details)."<br>"."<br>".
                              $aa."<br>"."<br>".$model->kakitangan->CONm.
                       "<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }else{
                      $c['f'] =  "<br>"."<strong>".strtoupper($model->namaSeksyen->section_details)."<br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }
         }
             
             array_push($b, $c);
//             array_push($b, $model->kakitanganParents->CONm);
              array_push($b, $model->parent_section);
             array_push($b, $model->unit);
             array_push($a, $b);
            $b = [];
         }

        
        return $this->render('maklumat-bahagian', ['deskripsi' => $deskripsi,'jawatan' => $jawatan, 'model' => $a,'test'=>$test
        ]);
    }
    
    
        public function actionMaklumatPelulus($id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        return $this->render('maklumat-pelulus', ['deskripsi' => $deskripsi,
        ]);
    }
    
      public function actionJadual($id) {
          $icno = Yii::$app->user->getId();
        $dept = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
    $deskripsi = Tblportfolio::find()->where(['id' => $id])->one();
        $jawatanKuasa = \app\models\portfolio\TblJawatankuasa::find()->where(['myjd_id' => $id])->one();
        $aktiviti = \app\models\portfolio\TblAktiviti::find()->where(['myjd_id' => $id])->one();
        $borang = \app\models\portfolio\TblBorang::find()->where(['myjd_id' => $id])->one();
        $carta = TblCartaJabatan::find()->where(['icno' => $deskripsi->icno])->one();
        $proses = \app\models\portfolio\TblProsesKerja::find()->where(['myjd_id' => $id])->one();

        $fungsi = RefUnit::find()->where(['jabatan_id' => $dept->DeptId])->one();
        $undang = \app\models\portfolio\TblUndang::find()->where(['myjd_id' => $id])->one();

        return $this->render('jadual', ['deskripsi' => $deskripsi, 'jawatanKuasa' => $jawatanKuasa,
                    'aktiviti' => $aktiviti, 'borang' => $borang, 'fungsi' => $fungsi, 
                  'undang' => $undang,'carta'=>$carta,'proses'=>$proses
        ]);
    }


    
         public function actionCartaFungsi($id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
      //     $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        
      //  $nama = Tblprcobiodata::find()->where(['ICNO' => $deskripsi->icno])->one();

     //    $icno=Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $deskripsi->icno])->one();
        $model = \app\models\portfolio\TblCartaJabatan::find()->joinWith('kakitangan')->where(['tblprcobiodata.DeptID' => $deskripsi->jabatan_semasa])->all();
      
        $carta = TblCartaJabatan::find()->where(['icno' => $deskripsi->icno ])->one();
        $fungsiUnit = \app\models\portfolio\RefUnit::find()->where(['jabatan_id' => $deskripsi->jabatan_semasa])->all();
     //      $fungsiUnit = RefFungsiUnit::find()->joinWith('fungsiUnit')->where(['jabatan_id' => $test->DeptId])->andWhere(['section_id' => $carta->section])->
        $a= [];
         $b = [];
         $c = [];
         foreach ($model as $model) {
             
             $c['v']=$model->level.'.'.$model->section;
       
       //     $aa =  '<span><img height= "100" width="150" src="https://hronline.ums.edu.my/picprofile/picstf/'.strtoupper(hash('sha1', $model->icno)).'.jpeg" </span>';
              
             if($model->unit_staff != NULL){
                      $c['f'] = 
                     "<br>". "<strong>".strtoupper($model->namaUnit->unit_details)."<br>"."<br>".
                            $model->kakitangan->CONm."<br>".
                       "<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }else{
                      $c['f'] =  "<br>"."<strong>".strtoupper($model->namaSeksyen->section_details)."<br>". "<br>".
                      $model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama."<br>".
                      "<br>". $model->kakitangan->jawatan->gred;
             }
             
             array_push($b, $c);
//             array_push($b, $model->kakitanganParents->CONm);
              array_push($b, $model->parent_section);
             array_push($b, $model->unit);
             array_push($a, $b);
            $b = [];
         }
        
        return $this->render('carta-fungsi', ['deskripsi' => $deskripsi,'model' => $a,'test'=>$test, 'fungsiUnit' =>$fungsiUnit, 'carta' => $carta
         
        ]);
    }
     public function actionLihatPortfolio($id) {
           $icno = Yii::$app->user->getId();
        $dept = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
   

        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $deskripsi->icno])->one();
         $carta = TblCartaJabatan::find()->where(['icno' => $deskripsi->icno])->one();

        $jawatan = TblCartaJabatan::find()->where(['jabatan_id' => $biodata->DeptId ])->all();
        $jawatanKuasa = \app\models\portfolio\TblJawatankuasa::find()->where(['myjd_id' => $id])->one();
        $aktiviti = \app\models\portfolio\TblAktiviti::find()->where(['myjd_id' => $id])->one();
        
        $proses = \app\models\portfolio\TblProsesKerjaAktiviti::find()->where(['myjd_id' => $id])->one();
      //   $viewAktiviti = TblProsesKerjaAktiviti::find()->where(['myjd_id' => $id ])->all();
                
                  $viewUndang= \app\models\portfolio\TblUndang::find()->where(['myjd_id' => $id])->all();   
        $borang = \app\models\portfolio\TblBorang::find()->where(['myjd_id' => $id])->one();
        $fungsi = RefUnit::find()->where(['jabatan_id' => $id->jabatan_id])->one();
        $undang = \app\models\portfolio\TblUndang::find()->where(['myjd_id' => $id])->one();
      $fungsiUnit = \app\models\portfolio\RefUnit::find()->where(['jabatan_id' => $deskripsi->jabatan_semasa])->all();
      $viewAktiviti = TblProsesKerjaAktiviti::find()->where(['myjd_id' => $id ])->all();
$viewCarta = TblCartaFungsi::find()->where(['myjd_id' => $id ])->all();
                $viewBorang = \app\models\portfolio\TblBorang::find()->where(['myjd_id' => $id ])->all();
      $viewJawatan = \app\models\portfolio\TblJawatankuasa::find()->where(['myjd_id' => $id ])->all();

        $refFungsi =  ArrayHelper::map(\app\models\portfolio\RefCartaFungsi::find()->all(), 'id_fungsi', 'keterangan');
          $icno = Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = \app\models\portfolio\TblCartaJabatan::find()->joinWith('kakitangan')->where(['tblprcobiodata.DeptID' => $test->DeptId])->all();
         $a= [];
         $b = [];
         $c = [];
         foreach ($model as $model) {
             
             $c['v']=$model->level.'.'.$model->section;
       
            $aa =  '<span><img height= "100" width="150" src="https://hronline.ums.edu.my/picprofile/picstf/'.strtoupper(hash('sha1', $model->icno)).'.jpeg" </span>';
              
         if($model->icno = $icno ){
             if($model->isSU == 1)
                 {
                       $c['f'] =  "<br>"." <span style='background-color:yellow;'><strong>".strtoupper($model->namaSeksyen->section_details)."</span><br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama;
                 }
                 else
                 {
                 
                      $c['f'] =  "<br>"."<strong>".strtoupper($model->namaSeksyen->section_details)."<br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama;
                 }
         }else{
               if($model->unit != NULL){
                      $c['f'] = 
                     "<br>". "<strong>".strtoupper($model->namaUnit->unit_details)."<br>"."<br>".
                              $aa."<br>"."<br>".$model->kakitangan->CONm.
                       "<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }else{
                      $c['f'] =  "<br>"."<strong>".strtoupper($model->namaSeksyen->section_details)."<br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }
         }
             
             array_push($b, $c);
//             array_push($b, $model->kakitanganParents->CONm);
              array_push($b, $model->parent_section);
             array_push($b, $model->unit);
             array_push($a, $b);
            $b = [];
         }

        
        return $this->render('lihat-portfolio', ['deskripsi' => $deskripsi,'jawatan' => $jawatan,
            'model' => $a,'test'=>$test,'jawatanKuasa' => $jawatanKuasa,'viewUndang' => $viewUndang,
        'aktiviti' => $aktiviti, 'borang' =>$borang,  'fungsi' => $fungsi, 
            'undang' => $undang,'fungsiUnit' =>$fungsiUnit, 'viewAktiviti'=>$viewAktiviti,   'viewCarta' => $viewCarta,
           'refFungsi' => $refFungsi,'viewBorang' =>$viewBorang,'viewJawatan' =>$viewJawatan,'carta'=>$carta,'proses'=>$proses
        ]);
    }
    public function actionLihatPortfolioKp($id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $deskripsi->icno])->one();
        $jawatan = TblCartaJabatan::find()->where(['jabatan_id' => $biodata->DeptId ])->all();
        $jawatanKuasa = \app\models\portfolio\TblJawatankuasa::find()->where(['myjd_id' => $id])->one();
        $aktiviti = \app\models\portfolio\TblAktiviti::find()->where(['myjd_id' => $id])->one();
        $borang = \app\models\portfolio\TblBorang::find()->where(['myjd_id' => $id])->one();
        $fungsi = RefUnit::find()->where(['jabatan_id' => $id->jabatan_id])->one();
        $undang = \app\models\portfolio\TblUndang::find()->where(['myjd_id' => $id])->one();
      $fungsiUnit = \app\models\portfolio\RefUnit::find()->where(['jabatan_id' => $deskripsi->jabatan_semasa])->all();
      $viewAktiviti = \app\models\portfolio\TblProsesKerja::find()->where(['myjd_id' => $id ])->all();
$viewCarta = TblCartaFungsi::find()->where(['myjd_id' => $id ])->all();
                $viewBorang = \app\models\portfolio\TblBorang::find()->where(['myjd_id' => $id ])->all();
      $viewJawatan = \app\models\portfolio\TblJawatankuasa::find()->where(['myjd_id' => $id ])->all();

        $refFungsi =  ArrayHelper::map(\app\models\portfolio\RefCartaFungsi::find()->all(), 'id_fungsi', 'keterangan');
          $icno = Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = \app\models\portfolio\TblCartaJabatan::find()->joinWith('kakitangan')->where(['tblprcobiodata.DeptID' => $test->DeptId])->all();
         $a= [];
         $b = [];
         $c = [];
         foreach ($model as $model) {
             
             $c['v']=$model->level.'.'.$model->section;
       
            $aa =  '<span><img height= "100" width="150" src="https://hronline.ums.edu.my/picprofile/picstf/'.strtoupper(hash('sha1', $model->icno)).'.jpeg" </span>';
              
         if($model->icno = $icno ){
             if($model->isSU == 1)
                 {
                       $c['f'] =  "<br>"." <span style='background-color:yellow;'><strong>".strtoupper($model->namaSeksyen->section_details)."</span><br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama;
                 }
                 else
                 {
                 
                      $c['f'] =  "<br>"."<strong>".strtoupper($model->namaSeksyen->section_details)."<br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama;
                 }
         }else{
               if($model->unit != NULL){
                      $c['f'] = 
                     "<br>". "<strong>".strtoupper($model->namaUnit->unit_details)."<br>"."<br>".
                              $aa."<br>"."<br>".$model->kakitangan->CONm.
                       "<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }else{
                      $c['f'] =  "<br>"."<strong>".strtoupper($model->namaSeksyen->section_details)."<br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }
         }
             
             array_push($b, $c);
//             array_push($b, $model->kakitanganParents->CONm);
              array_push($b, $model->parent_section);
             array_push($b, $model->unit);
             array_push($a, $b);
            $b = [];
         }

        
        return $this->render('lihat-portfolio-kp', ['deskripsi' => $deskripsi,'jawatan' => $jawatan,
            'model' => $a,'test'=>$test,'jawatanKuasa' => $jawatanKuasa,
        'aktiviti' => $aktiviti, 'borang' =>$borang,  'fungsi' => $fungsi, 
            'undang' => $undang,'fungsiUnit' =>$fungsiUnit, 'viewAktiviti'=>$viewAktiviti,   'viewCarta' => $viewCarta,
           'refFungsi' => $refFungsi,'viewBorang' =>$$viewBorang,'viewJawatan' =>$viewJawatan
        ]);
    }
    public function actionLihatPortfolioAdmin($id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $deskripsi->icno])->one();
        $jawatan = TblCartaJabatan::find()->where(['jabatan_id' => $biodata->DeptId ])->all();
        $jawatanKuasa = \app\models\portfolio\TblJawatankuasa::find()->where(['myjd_id' => $id])->one();
        $aktiviti = \app\models\portfolio\TblAktiviti::find()->where(['myjd_id' => $id])->one();
        $borang = \app\models\portfolio\TblBorang::find()->where(['myjd_id' => $id])->one();
        $fungsi = RefUnit::find()->where(['jabatan_id' => $id->jabatan_id])->one();
        $undang = \app\models\portfolio\TblUndang::find()->where(['myjd_id' => $id])->one();
      $fungsiUnit = \app\models\portfolio\RefUnit::find()->where(['jabatan_id' => $deskripsi->jabatan_semasa])->all();
      $viewAktiviti = \app\models\portfolio\TblProsesKerja::find()->where(['myjd_id' => $id ])->all();
$viewCarta = TblCartaFungsi::find()->where(['myjd_id' => $id ])->all();
                $viewBorang = \app\models\portfolio\TblBorang::find()->where(['myjd_id' => $id ])->all();
      $viewJawatan = \app\models\portfolio\TblJawatankuasa::find()->where(['myjd_id' => $id ])->all();

        $refFungsi =  ArrayHelper::map(\app\models\portfolio\RefCartaFungsi::find()->all(), 'id_fungsi', 'keterangan');
          $icno = Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = \app\models\portfolio\TblCartaJabatan::find()->joinWith('kakitangan')->where(['tblprcobiodata.DeptID' => $test->DeptId])->all();
         $a= [];
         $b = [];
         $c = [];
         foreach ($model as $model) {
             
             $c['v']=$model->level.'.'.$model->section;
       
            $aa =  '<span><img height= "100" width="150" src="https://hronline.ums.edu.my/picprofile/picstf/'.strtoupper(hash('sha1', $model->icno)).'.jpeg" </span>';
              
         if($model->icno = $icno ){
             if($model->isSU == 1)
                 {
                       $c['f'] =  "<br>"." <span style='background-color:yellow;'><strong>".strtoupper($model->namaSeksyen->section_details)."</span><br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama;
                 }
                 else
                 {
                 
                      $c['f'] =  "<br>"."<strong>".strtoupper($model->namaSeksyen->section_details)."<br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama;
                 }
         }else{
               if($model->unit != NULL){
                      $c['f'] = 
                     "<br>". "<strong>".strtoupper($model->namaUnit->unit_details)."<br>"."<br>".
                              $aa."<br>"."<br>".$model->kakitangan->CONm.
                       "<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }else{
                      $c['f'] =  "<br>"."<strong>".strtoupper($model->namaSeksyen->section_details)."<br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }
         }
             
             array_push($b, $c);
//             array_push($b, $model->kakitanganParents->CONm);
              array_push($b, $model->parent_section);
             array_push($b, $model->unit);
             array_push($a, $b);
            $b = [];
         }

        
        return $this->render('lihat-portfolio-admin', ['deskripsi' => $deskripsi,'jawatan' => $jawatan,
            'model' => $a,'test'=>$test,'jawatanKuasa' => $jawatanKuasa,
        'aktiviti' => $aktiviti, 'borang' =>$borang,  'fungsi' => $fungsi, 
            'undang' => $undang,'fungsiUnit' =>$fungsiUnit, 'viewAktiviti'=>$viewAktiviti,   'viewCarta' => $viewCarta,
           'refFungsi' => $refFungsi,'viewBorang' =>$$viewBorang,'viewJawatan' =>$viewJawatan
        ]);
    }
    
    
    public function actionAktivitiFungsi($id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $viewCarta = TblCartaFungsi::find()->where(['myjd_id' => $id])->all();
        $icno = Yii::$app->user->getId();
        $carta = TblCartaJabatan::find()->where(['icno' => $icno])->one();
        
        $refFungsi =  ArrayHelper::map(\app\models\portfolio\RefCartaFungsi::find()->all(), 'id_fungsi', 'keterangan');
       
        $viewAktiviti = \app\models\portfolio\TblAktiviti::find()->where(['myjd_id' => $id ])->orderBy(['fungsi_id' => SORT_ASC])->all();
       // $icno=Yii::$app->user->getId(); 
        
        
//        $fungsiUnit = RefFungsiUnit::find()->all();
//        if(($fungsiUnit->fungsiUnit->section_id == $fungsiUnit->fungsiUnit->cartaSection->section) || ($fungsiUnit->fungsiUnit->id == $fungsiUnit->fungsiUnit->cartaUnit->unit_staff)){
//                             echo '<div style="background-color:yellow">'.ucwords(strtolower($fungsiUnit->fungsiUnit->sectionID->section_details)).'</div>';
//                            }else{
//                              echo ucwords(strtolower($fungsiUnit->fungsiUnit->sectionID->section_details));                         
//                               }
         //$a = RefUnit::find()->all();      
          $a = [];
          $models = TblCartaJabatan::find()->where(['icno' => $icno])->all();
         foreach ($models as $models) {
             array_push($a, $models->section);
         }
         
           $b = [];
          $model = TblCartaJabatan::find()->where(['icno' => $icno])->all();
         foreach ($model as $model) {
     //        array_push($b, $model->unit_staff);
             $b[] = $model->unit_staff;
         }
     
       
         
         
          // VarDumper::dump($b,10,true);die;
              // $a = \array_push($b);
          //$a = [1,104];
         
        //var_dump($b);die;
          
          
       if($carta->unit_staff == null){
             $fungsiUnit = RefFungsiUnit::find()
                ->joinWith('fungsiUnit')
                ->joinWith('fungsiUnit.cartaJabatan')
                ->where(['portfolio_ref_unit.jabatan_id' => $deskripsi->jabatan_semasa])
             //   ->andWhere(['portfolio_ref_unit.section_id' => null])
             // ->andWhere(['fungsiUnit.cartaJabatan.portfolio_tbl_carta_jabatan.section' => 'portfolio_ref_unit.section_id'])    
               //->andWhere(['=','portfolio_ref_unit.jabatan_id' , $deskripsi->jabatan_semasa])
             //  ->andWhere(['LIKE', 'portfolio_ref_unit.section_id',  false])
               ->andWhere(['portfolio_ref_unit.section_id' => $a ])
            //   ->orWhere(['portfolio_ref_unit.id' => $carta->cartaUnit->unit_staff])
          
          //     ->andWhere(['!=', 'portfolio_ref_unit.section_id', 'null'])
              //  ->andWhere(['myjd_tbl_portfolio.icno' => $icno])
                ->all();
       } else{
             $fungsiUnit = RefFungsiUnit::find()
             ->joinWith('fungsiUnit')
             ->joinWith('fungsiUnit.cartaJabatan')
             ->where(['=','portfolio_ref_unit.jabatan_id' , $deskripsi->jabatan_semasa])
           //     ->andWhere(['!=', 'portfolio_ref_unit.id' , 'null'])
        //   ->andWhere(['portfolio_ref_unit.section_id' => $carta->section, 'portfolio_ref_unit.jabatan_id' => $deskripsi->jabatan_semasa ])
          
            ->andWhere(['portfolio_ref_unit.id' => $b])
           //     ->andWhere(['!=', 'portfolio_ref_unit.id' , 'null'])
            //    ->andWhere(['!=', 'portfolio_ref_unit.section_id', 'null'])
            //     ->andWhere(['myjd_tbl_portfolio.icno' => $icno])
                ->all();
       }
      
       // VarDumper::dump(['portfolio_ref_unit.id' => $b],10,true);die;
     // var_dump($deskripsi->jabatan_semasa);die;
     
        
        return $this->render('aktiviti-fungsi', ['deskripsi' => $deskripsi, 'carta' => $carta, 'viewCarta' => $viewCarta,
           'refFungsi' => $refFungsi, 'viewAktiviti' => $viewAktiviti, 'fungsiUnit' => $fungsiUnit, 'a' => $a
        ]);
    }
    
        
    public function actionTambahAktivitiFungsi($id, $unit_id) {
     //  $icno=Yii::$app->user->getId(); 
    //   $a = TblPortfolio::find()->where(['icno' => $icno])->one();
       $deskripsi = TblPortfolio::find()->where(['id' =>  $id])->one();
   //    $viewCarta = TblCartaFungsi::find()->where(['myjd_id' => $id ])->all();
   //    $carta = TblCartaFungsi::find()->where(['myjd_id' => $id ])->one();
 //     $refFungsi =  ArrayHelper::map(\app\models\portfolio\RefCartaFungsi::find()->all(), 'id_fungsi', 'keterangan');
  //     $viewAktiviti = \app\models\portfolio\TblAktiviti::find()->where(['fungsi_id' => $carta->id ])->all();
                
        $tambahCarta = new \app\models\portfolio\TblAktiviti();
        
          $request = Yii::$app->request;
          
          if ($tambahCarta->load($request->post())) {
            $tambahCarta->myjd_id = $deskripsi->id;
            $tambahCarta->icno = $deskripsi->icno;
            $tambahCarta->created_at = date('Y-m-d H:i:s');
            $tambahCarta->fungsi_id = $unit_id;
            $tambahCarta->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['aktiviti-fungsi',  'id' => $tambahCarta->myjd_id]);
        }
        
        
        return $this->render('tambah-aktiviti-fungsi', ['deskripsi' => $deskripsi,  'tambahCarta' => $tambahCarta
        ]);
    }
    
    
      public function actionKemaskiniAktivitiFungsi($id, $myjd_id) {
       $tambahCarta = \app\models\portfolio\TblAktiviti::find()->where(['id'=> $id])->one();
        
          $request = Yii::$app->request;
          
          if ($tambahCarta->load($request->post())) {
        //    $tambahCarta->myjd_id = $deskripsi->id;
         //   $tambahCarta->icno = $deskripsi->icno;
            $tambahCarta->created_at = date('Y-m-d H:i:s');
       //     $tambahCarta->fungsi_id = $id;
            $tambahCarta->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['aktiviti-fungsi',  'id' => $myjd_id]);
        }
        
        
        return $this->render('kemaskini-aktiviti-fungsi', [ 'tambahCarta' => $tambahCarta
        ]);
    }
    
    
        public function actionPadamAktivitiFungsi($id, $myjd_id) {
         $tambahCarta = \app\models\portfolio\TblAktiviti::find()->where(['id'=> $id])->one();
         $tambahCarta->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);
        return $this->redirect(['aktiviti-fungsi', 'id' => $myjd_id]); 
        }
    
    
       public function actionSenaraiJawatankuasa($id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $viewCarta = TblCartaFungsi::find()->where(['myjd_id' => $id ])->all();
        
        $refFungsi =  ArrayHelper::map(\app\models\portfolio\RefCartaFungsi::find()->all(), 'id_fungsi', 'keterangan');
      
      $viewAktiviti = \app\models\portfolio\TblJawatankuasa::find()->where(['myjd_id' => $id ])->all();
    
        $carta = new \app\models\portfolio\TblJawatankuasa();
        $file = UploadedFile::getInstance($carta, 'files');

         if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'portfolio');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = $carta->file ? $carta->file : '';
        }
          $request = Yii::$app->request;
          if ($carta->load($request->post())) {
            $carta->myjd_id = $deskripsi->id;
            $carta->icno = $deskripsi->icno;
            $carta->created_at = date('Y-m-d H:i:s');
            $carta->file = $filepath;
            $carta->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['senarai-jawatankuasa', 'id' => $id]);
        }
        
        
        return $this->render('senarai-jawatankuasa', ['deskripsi' => $deskripsi, 'carta' => $carta, 'viewCarta' => $viewCarta,
           'refFungsi' => $refFungsi, 'viewAktiviti' => $viewAktiviti
        ]);
    }
    
    
       public function actionKemaskiniSenaraiJawatankuasa($id, $myjd_id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $viewCarta = TblCartaFungsi::find()->where(['myjd_id' => $id ])->all();
        
        $refFungsi =  ArrayHelper::map(\app\models\portfolio\RefCartaFungsi::find()->all(), 'id_fungsi', 'keterangan');
      
       $viewAktiviti = \app\models\portfolio\TblJawatankuasa::find()->where(['myjd_id' => $id ])->all();
    
        $carta = \app\models\portfolio\TblJawatankuasa::find()->where(['id' => $id])->one();
        $file = UploadedFile::getInstance($carta, 'files');

         if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'portfolio');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = $carta->file ? $carta->file : '';
        }
          $request = Yii::$app->request;
          if ($carta->load($request->post())) {
         //   $carta->myjd_id = $deskripsi->id;
            $carta->icno = $deskripsi->icno;
            $carta->created_at = date('Y-m-d H:i:s');
            $carta->file = $filepath;
            $carta->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['senarai-jawatankuasa', 'id' => $myjd_id]);
        }
        
        
        return $this->render('kemaskini-senarai-jawatankuasa', ['deskripsi' => $deskripsi, 'carta' => $carta, 'viewCarta' => $viewCarta,
           'refFungsi' => $refFungsi, 'viewAktiviti' => $viewAktiviti
        ]);
    }
    
     public function actionSenaraiUndang($id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $viewCarta = TblCartaFungsi::find()->where(['myjd_id' => $id ])->all();
        
        $refFungsi =  ArrayHelper::map(\app\models\portfolio\RefCartaFungsi::find()->all(), 'id_fungsi', 'keterangan');
      
      $viewAktiviti = \app\models\portfolio\TblUndang::find()->where(['myjd_id' => $id ])->all();
    
        $carta = new \app\models\portfolio\TblUndang();
        $file = UploadedFile::getInstance($carta, 'files');

         if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'portfolio');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = $carta->file ? $model->file : '';
        }
          $request = Yii::$app->request;
          if ($carta->load($request->post())) {
            $carta->myjd_id = $deskripsi->id;
            $carta->icno = $deskripsi->icno;
            $carta->created_at = date('Y-m-d H:i:s');
            $carta->file = $filepath;
            $carta->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['senarai-undang', 'id' => $id]);
        }
        
        
        return $this->render('senarai-undang', ['deskripsi' => $deskripsi, 'carta' => $carta, 
            'viewCarta' => $viewCarta,
           'refFungsi' => $refFungsi, 'viewAktiviti' => $viewAktiviti
        ]);
    }
    
//         public function actionProsesKerja($id) {
//         $icno=Yii::$app->user->getId();
//        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
//        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
//     //   $viewCarta = TblCartaFungsi::find()->where(['myjd_id' => $id ])->all();
//           $carta = TblCartaJabatan::find()->where(['icno' => $deskripsi->icno ])->one();
//      $refFungsi =  ArrayHelper::map(\app\models\portfolio\RefFungsiUnit::find()->all(), 'id', 'description');
//      
//      $viewAktiviti = \app\models\portfolio\TblProsesKerja::find()->where(['myjd_id' => $id ])->all();
//    
//        $proses = new \app\models\portfolio\TblProsesKerja();
//         $file = UploadedFile::getInstance($proses, 'files');
//
//         if ($file) {
//            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'portfolio');
//            $filepath = $fileapi->file_name_hashcode;
//        } else {
//            $filepath = $model->file ? $model->file : '';
//        }
//          $request = Yii::$app->request;
//          if ($proses->load($request->post())) {
//            $proses->myjd_id = $deskripsi->id;
//            $proses->icno = $deskripsi->icno;
//            $proses->created_at = date('Y-m-d H:i:s');
//            $proses->file = $filepath;
//            $proses->save(false);
//            
//            
//            $tblUndang = new \app\models\portfolio\TblUndang();
//            $tblUndang->icno =  $proses->icno;
//            $tblUndang->myjd_id =  $proses->myjd_id;
//            $tblUndang->catatan =   $proses->undang;
//            $tblUndang->save(false);
//
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
//            return $this->redirect(['proses-kerja', 'id' => $id]);
//        }
//        
//        
//        return $this->render('proses-kerja', ['deskripsi' => $deskripsi, 'proses' => $proses, 'viewAktiviti' => $viewAktiviti, 'refFungsi' => $refFungsi, 'carta' => $carta, 'test'=>$test
//        ]);
//    }
    
    
    
       public function actionProsesKerja($id){
           
        $icno = Yii::$app->user->getId(); 

        $modelmel = new TblProsesKerja();
        $modelsBarang = [new TblProsesKerjaAktiviti()];

        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $carta = TblCartaJabatan::find()->where(['icno' => $deskripsi->icno ])->one();
        $refFungsi =  ArrayHelper::map(\app\models\portfolio\RefFungsiUnit::find()->all(), 'id', 'description');
      
        $viewAktiviti = TblProsesKerjaAktiviti::find()->where(['myjd_id' => $id ])->all();
        
        
   

        if ($modelmel->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsBarang, 'id', 'id');
            $modelsBarang = Model::createMultiple(TblProsesKerjaAktiviti::classname(), $modelsBarang);
            Model::loadMultiple($modelsBarang, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsBarang, 'id', 'id')));

//            $modelmel->icno = Yii::$app->user->getId();
//            $modelmel->jabatan_id =  $biodata->DeptId;
            
            $modelmel->myjd_id = $deskripsi->id;
            $modelmel->icno = $deskripsi->icno;
            $modelmel->created_at = date('Y-m-d H:i:s');
            
             $modelmel->save(false);
            
           $file = UploadedFile::getInstance($modelmel, 'file');

         if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'portfolio');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = $modelmel->file ? $modelmel->file : '';
        }
             $modelmel->file = $filepath;
             
             
            $tblUndang = new \app\models\portfolio\TblUndang();
            $tblUndang->icno =  $modelmel->icno;
            $tblUndang->id_proses = $modelmel->id;
            $tblUndang->myjd_id =  $modelmel->myjd_id;
            $tblUndang->catatan =   $modelmel->undang;
            $tblUndang->created_at = date('Y-m-d H:i:s');
            $tblUndang->save(false);
  

            // validate all models
            $valid = $modelmel->validate();
            $valid = Model::validateMultiple($modelsBarang) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'ditambah/added.']);
                    if ($flag = ($modelmel->save(false))) {
                       
                        if (!empty($deletedIDs)) {
                            TblProsesKerjaAktiviti::deleteAll(['id' => $deletedIDs]);
                        }

                        foreach ($modelsBarang as $i => $modelBarang) {
                            
                            
                            $modelBarang->id_proses = $modelmel->id;
                            $modelBarang->icno = $modelmel->icno;
                            $modelBarang->myjd_id = $modelmel->myjd_id;
                            $modelBarang->created_at = date('Y-m-d H:i:s');
                            $modelBarang->save(false);
                            
     
           
                            if (!($flag = $modelBarang->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
            
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['proses-kerja', 'id' => $modelmel->myjd_id]);
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            } 
        }

        return $this->render('proses-kerja', [
            'modelmel' => $modelmel,
            'modelsBarang'=> (empty($modelsBarang)) ? [new TblProsesKerjaAktiviti()] : $modelsBarang,
            'test' =>$test, 'deskripsi' => $deskripsi,  'viewAktiviti' => $viewAktiviti, 'refFungsi' => $refFungsi, 'carta' => $carta
        ]);
    }
    
    
     public function actionSenaraiBorang($id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $viewCarta = TblCartaFungsi::find()->where(['myjd_id' => $id ])->all();
        
        $refFungsi =  ArrayHelper::map(\app\models\portfolio\RefCartaFungsi::find()->all(), 'id_fungsi', 'keterangan');
      
        $viewAktiviti = \app\models\portfolio\TblBorang::find()->where(['myjd_id' => $id ])->all();
    
        $carta = new \app\models\portfolio\TblBorang();
        $file = UploadedFile::getInstance($carta, 'files');

         if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'portfolio');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = $carta->file ? $model->file : '';
        }
          $request = Yii::$app->request;
          if ($carta->load($request->post())) {
            $carta->myjd_id = $deskripsi->id;
            $carta->icno = $deskripsi->icno;
            $carta->created_at = date('Y-m-d H:i:s');
            $carta->file= $filepath;
            $carta->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['senarai-borang', 'id' => $id]);
        }
        
        
        return $this->render('senarai-borang', ['deskripsi' => $deskripsi, 'carta' => $carta, 'viewCarta' => $viewCarta,
           'refFungsi' => $refFungsi, 'viewAktiviti' => $viewAktiviti
        ]);
    }
    
    
     public function actionKemaskiniSenaraiBorang($id, $myjd_id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $viewCarta = TblCartaFungsi::find()->where(['myjd_id' => $id ])->all();
        
        $refFungsi =  ArrayHelper::map(\app\models\portfolio\RefCartaFungsi::find()->all(), 'id_fungsi', 'keterangan');
      
        $viewAktiviti = \app\models\portfolio\TblBorang::find()->where(['myjd_id' => $id ])->all();
    
        $carta = \app\models\portfolio\TblBorang::find()->where(['id' => $id])->one();
        
        $file = UploadedFile::getInstance($carta, 'files');

         if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'portfolio');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = $carta->file ? $model->file : '';
        }
          $request = Yii::$app->request;
          if ($carta->load($request->post())) {
         //   $carta->myjd_id = $deskripsi->id;
            $carta->icno = $deskripsi->icno;
            $carta->created_at = date('Y-m-d H:i:s');
            $carta->file= $filepath;
            $carta->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['senarai-borang', 'id' =>  $myjd_id]);
        }
        
        
        return $this->render('kemaskini-senarai-borang', ['deskripsi' => $deskripsi, 'carta' => $carta, 'viewCarta' => $viewCarta,
           'refFungsi' => $refFungsi, 'viewAktiviti' => $viewAktiviti
        ]);
    }
    
    
     public function actionCartaOrgan() {
        $c_dept = Yii::$app->user->identity->DeptId; 
        $model = \app\models\portfolio\TblCartaJabatan::find()->joinWith('kakitangan')->where(['jabatan_id' => $c_dept])->all();
//        \yii\helpers\VarDumper::dump($model, $depth=10, $highlight=true);die;
         $a= [];
         $b = [];
         $c = [];
         foreach ($model as $model) {
             
       //      $c['v']=$model->level.'.'.$model->section;
       
            $aa =  '<span><img height= "auto" width="60px" src="https://hronline.ums.edu.my/picprofile/picstf/'.strtoupper(hash('sha1', $model->icno)).'.jpeg" </span>';
                          $bb =  '<span><img height= "auto" width="60px" src="https://hronline.ums.edu.my/picprofile/picstf/'.strtoupper(hash('sha1',$model->icno)).'.jpeg" </span>';
               
             if($model->unit_staff != NULL){
                        $c['v']=$model->level.'.'.$model->unit_staff;
                      $c['f'] = 
                     "<br>". "<strong>".strtoupper($model->namaUnit->unit_details)."<br>"."<br>".
                              $aa."<br>"."<br>".$model->kakitangan->CONm.
                       "<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred.'<br>';
             }
             else{
                 if($model->isSU == 1)
                 {    
                       $c['v']=$model->level.'.'.$model->section;
                       $c['f'] =  "<br>"." <span style='background-color:yellow;'><strong>".strtoupper($model->namaSeksyen->section_details)."</span><br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama;
                 }
                 else
                 {
                        $c['v']=$model->level.'.'.$model->section;
                      $c['f'] =  "<br>"."<strong>".strtoupper($model->namaSeksyen->section_details)."<br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama;
                 }
                     
             }
            
             
             array_push($b, $c);
//             array_push($b, $model->kakitanganParents->CONm);
              array_push($b, $model->parent_section);
             array_push($b, $model->unit);
             array_push($a, $b);
            $b = [];
         }
//         VarDumper::dump($a, $depth = 10, $highlight =true);
//         die;
         
          return $this->render('carta-organ',['model' => $a,'test'=>$test]);
     }
     
       public function actionCartaFungsiJabatan() {
        $icno=Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = \app\models\portfolio\TblCartaJabatan::find()->joinWith('kakitangan')->where(['tblprcobiodata.DeptID' => $test->DeptId])->all();
        
        $fungsiUnit = RefUnit::find()->where(['jabatan_id' => $test->DeptId])->all();
        
        $a= [];
         $b = [];
         $c = [];
         foreach ($model as $model) {
             
             $c['v']=$model->level.'.'.$model->section;
       
       //     $aa =  '<span><img height= "100" width="150" src="https://hronline.ums.edu.my/picprofile/picstf/'.strtoupper(hash('sha1', $model->icno)).'.jpeg" </span>';
              
             if($model->unit_staff != NULL){
                      $c['f'] = 
                     "<br>". "<strong>".strtoupper($model->namaUnit->unit_details)."<br>"."<br>".
                            $model->kakitangan->CONm."<br>".
                       "<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }else{
                      $c['f'] =  "<br>"."<strong>".strtoupper($model->namaSeksyen->section_details)."<br>". "<br>".
                      $model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama."<br>".
                      "<br>". $model->kakitangan->jawatan->gred;
             }
             
             array_push($b, $c);
//             array_push($b, $model->kakitanganParents->CONm);
              array_push($b, $model->parent_section);
             array_push($b, $model->unit);
             array_push($a, $b);
            $b = [];
         }

         
          return $this->render('carta-fungsi-jabatan',['model' => $a,'test'=>$test, 'fungsiUnit' =>$fungsiUnit]);
     }
     
     
        public function actionCartaOrganStaf($id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        
        $nama = Tblprcobiodata::find()->where(['ICNO' => $deskripsi->icno])->one();

        //$icno=Yii::$app->user->getId();
       // $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
       // $test = TblPortfolio::find()->where(['id' => $id])->one();
        $model = \app\models\portfolio\TblCartaJabatan::find()->joinWith('kakitangan')->joinWith('myjd')->where(['jabatan_id' => $deskripsi->jabatan_semasa])->all();
        
         $a= [];
         $b = [];
         $c = [];
         foreach ($model as $model) {
             
             $c['v']=$model->level.'.'.$model->section;
       
            $aa =  '<span><img height= "80" width="130" src="https://hronline.ums.edu.my/picprofile/picstf/'.strtoupper(hash('sha1', $model->icno)).'.jpeg" </span>';
              
             if($model->unit_staff != NULL){
                      $c['f'] = 
                     "<br>". "<strong>".strtoupper($model->namaUnit->unit_details)."<br>"."<br>".
                              $aa."<br>"."<br>".$model->kakitangan->CONm.
                       "<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }else{
                      $c['f'] =  "<br>"."<strong>".strtoupper($model->namaSeksyen->section_details)."<br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }
             
             array_push($b, $c);
//             array_push($b, $model->kakitanganParents->CONm);
              array_push($b, $model->parent_section);
             array_push($b, $model->unit);
             array_push($a, $b);
            $b = [];
         }
//         VarDumper::dump($a, $depth = 10, $highlight =true);
//         die;
         
          return $this->render('carta-organ-staf',['model' => $a,'nama'=>$nama, 'deskripsi' =>  $deskripsi]);
     }
     
     
     
        public function actionCartaOrganJafpib($dept_id) {
     //  $deskripsi = TblCartaJabatan::find()->where(['jabatan' => $id])->one();

        $icno=Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['DeptId' => $dept_id])->one();
        $model = \app\models\portfolio\TblCartaJabatan::find()->joinWith('kakitangan')->where(['jabatan_id' => $dept_id])->all();
        
         $a= [];
         $b = [];
         $c = [];
         foreach ($model as $model) {
             
             $c['v']=$model->level.'.'.$model->section;
       
            $aa =  '<span><img height= "80" width="130" src="https://hronline.ums.edu.my/picprofile/picstf/'.strtoupper(hash('sha1', $model->icno)).'.jpeg" </span>';
              
             if($model->unit_staff != NULL){
                      $c['f'] = 
                     "<br>". "<strong>".strtoupper($model->namaUnit->unit_details)."<br>"."<br>".
                              $aa."<br>"."<br>".$model->kakitangan->CONm.
                       "<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }else{
                      $c['f'] =  "<br>"."<strong>".strtoupper($model->namaSeksyen->section_details)."<br>". "<br>".
                      $aa."<br>".$model->kakitangan->CONm."<br>".$model->kakitangan->jawatan->nama.
                      "<br>". $model->kakitangan->jawatan->gred;
             }
             
             array_push($b, $c);
//             array_push($b, $model->kakitanganParents->CONm);
              array_push($b, $model->parent_section);
             array_push($b, $model->unit);
             array_push($a, $b);
            $b = [];
         }
//         VarDumper::dump($a, $depth = 10, $highlight =true);
//         die;
         
          return $this->render('carta-organ-jafpib',['model' => $a,'test'=>$test]);
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
    protected function findBiodata() {
        if (($model = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionUnitDetails() {
  
//        $model = new SenaraiUnit();
        $model = new TblCartaJabatan();
        $biodata = $this->findBiodata();
        $icno = Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $record = $this->grid(TblCartaJabatan::find()->joinWith('kakitangan')->where(['portfolio_tbl_carta_jabatan.jabatan_id' => $test->DeptId])); 
  
        
        if ($model->load(Yii::$app->request->post()) ) {
            $model->jabatan_id =  $biodata->DeptId;
            $model->created_dt = date('Y-m-d H:i:s');
            $model->update_by =  $icno;
           // $parent_id = $model->level_ketua.'.'.$model->section_ketua;
           // $model->parent_section = $parent_id;
                   if($model->section_ketua != null){
                   $parent_id = $model->level_ketua.'.'.$model->section_ketua;
                   $model->parent_section = $parent_id;
                  }else{
                   $parent_id = $model->level_ketua.'.'.$model->unit_ketua;
                   $model->parent_section = $parent_id;
            }
            $model->level = $model->level_staff;
            $model->section = $model->unit_staff;
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['unit-details']);
        }
//        if ($model->load(Yii::$app->request->post())) {
//            $model->jabatan_id =  $biodata->DeptId;
//            $model->save(false);
//            
////            $carta->icno = $model->icno;           
////            $carta->parent = $model->chief;
////            $carta->level = $model->level;
////            $carta->jabatan_id = $model->jabatan_id;
////            $carta->section = $model->unit;
//            
////            if($model->section_ketua != null){
////                 $parent_id = $model->level_ketua.'.'.$model->section_ketua;
////                $model->parent_section = $parent_id;
////            }else{
////                $parent_id = $model->level_ketua.'.'.$model->unit_ketua;
////                 $model->parent_section = $parent_id;
////            }
//   //         $carta->pID = $model->id;
//   //         $carta->unit = $model->unit;
//       //     $carta->save(false);
//
//            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
//            return $this->redirect(['unit-details']);
//        }

        return $this->render('form_unit_details', [
                    'model' => $model,
                    'record' => $record,
            'test'=>$test
        ]);
    }
    
     public function actionSectionDetails() {
     $department = TblSenaraiPeringkat::find()->select(['id' => 'id', 'nama' => 'CONCAT("Peringkat" ," - ", peringkat, "   -      ",   Nama, " - ", section_details, " - ", unit_details)'])->orderBy(['peringkat'=>SORT_ASC])->all();
        

     $model = new TblCartaJabatan();

        $biodata = $this->findBiodata();
        $icno = Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $record = $this->grid(TblCartaJabatan::find()->joinWith('kakitangan')->where(['portfolio_tbl_carta_jabatan.jabatan_id' => $test->DeptId])); 
               
        if ($model->load(Yii::$app->request->post()) ) {
            
    //     $listKetua = TblSenaraiPeringkat::find()->where(['id'=>$model->parent])->one();
            
        //    $model->icno = $list->icno;
       //     
    //     $listStaf = TblSenaraiPeringkat::find()->where(['id'=>$model->parent])->one();
           

     //       $model->parent = $listKetua->icno;
          
            
     //       var_dump ($list2->id.''.$list2->icno. ''. $list2->peringkat. $list2->section_id); die();            
     //   $a = TblSenaraiPeringkat::find()->joinWith('idPeringkat')->where(['icno' => $model->icno])->one();
   //     $b = TblSenaraiPeringkat::find()->joinWith('idPeringkat')->where(['icno' => $model->parent])->one();
            
        $a = TblSenaraiPeringkat::find()->joinWith('idPeringkat')->where(['portfolio_tbl_senarai_peringkat.id' => $model->icno])->one();
        $b = TblSenaraiPeringkat::find()->joinWith('idPeringkat')->where(['portfolio_tbl_senarai_peringkat.id' => $model->parent])->one();
         
            $model->icno = $a->icno;
            $model->parent = $b->icno;
            $model->jabatan_id =  $biodata->DeptId;
            $model->created_dt = date('Y-m-d H:i:s');
            $model->update_by =  $icno;
            $model->save(false);
            
            
               if(($b->section_id != null) && ($a->section_id != null)){
                    $parent_id = $b->idPeringkat->peringkat.'.'. $b->section_id;
                    $model->parent_section = $parent_id;
                    $model->section_ketua = $b->section_id;
                    $model->section =  $a->section_id;
                    $model->level =  $a->idPeringkat->peringkat;   
                    $model->level_staff =  $a->idPeringkat->peringkat;   
                    $model->level_ketua =  $b->idPeringkat->peringkat;
                    
               }else if(($b->section_id != null) && ($a->unit_id != null)){
                   $parent_id = $b->idPeringkat->peringkat.'.'. $b->section_id;
                    $model->parent_section = $parent_id;
                    $model->section_ketua = $b->section_id;
                    $model->section =  $a->unit_id;
                    $model->unit_staff = $a->unit_id;
                    $model->level =  $a->idPeringkat->peringkat;   
                    $model->level_staff =  $a->idPeringkat->peringkat;   
                    $model->level_ketua =  $b->idPeringkat->peringkat;
                     
                  } else{
                   $parent_id = $b->idPeringkat->peringkat.'.'. $b->unit_id;
                   $model->parent_section = $parent_id;
                   $model->unit_ketua = $b->unit_id;
                   $model->unit_staff = $a->unit_id;
                   $model->section =  $a->unit_id;
                   $model->section_ketua = $b->unit_id;
                   $model->level =  $a->idPeringkat->peringkat;   
                   $model->level_staff =  $a->idPeringkat->peringkat;   
                   $model->level_ketua =  $b->idPeringkat->peringkat;
                     
                  }

            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['section-details']);
        }

        return $this->render('form_section_details', [
                    'model' => $model,
                    'record' => $record,'test'=>$test,  'department' => $department
        ]);
    }
     public function actionChiefDetails() {
       
        $icno=Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = new SenaraiKetua();
        
        $record = $this->grid(SenaraiKetua::find()->joinWith('ketua')->where(['tblprcobiodata.DeptID' => $test->DeptId,'level_ketua'=>1]));
    
        if ($model->load(Yii::$app->request->post())) {
            $model->jabatan_id = $test->DeptId;
            $model->created_dt = date('Y-m-d H:i:s');
            $model->update_by =  $icno;
            $model->level_ketua =  1;
            $model->update_by =  $icno;
            $model->save(false);    
            
            $carta = new TblCartaJabatan();
            $carta->jabatan_id =  $test->DeptId;
            $carta->icno = $model->icno;
            $carta->created_dt = date('Y-m-d H:i:s');
            $carta->update_by =  $icno;
            $carta->level =  1;
              $carta->level_ketua =  1;
              $carta->parent =  $model->icno;
            $carta->section =  $model->section_ketua;
              $carta->section_ketua =  $model->section_ketua;
            $parent_id = '1'.'.'.$model->section_ketua;
            $carta->parent_section = $parent_id;
            $carta->save(false);

            
            $peringkat = new TblPeringkat();
            $peringkat->peringkat = 1;
            $peringkat->dept_id = $model->jabatan_id;
            $peringkat->updated = date('Y-m-d H:i:s');
            $peringkat->updated_by = $icno;
            $peringkat->save(false);
            
            $senaraiPeringkat = new TblSenaraiPeringkat();
            $senaraiPeringkat->id_peringkat = $peringkat->id;
            $senaraiPeringkat->icno = $model->icno;
            $senaraiPeringkat->section_id = $model->section_ketua;
            $senaraiPeringkat->nama = $model->ketua->CONm;
            $senaraiPeringkat->peringkat = 1;
            $senaraiPeringkat->section_details = $model->seksyenKetua->section_details;
            $senaraiPeringkat->save(false);
             
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['chief-details']);
        }

        return $this->render('form_chief_details', [
                    'model' => $model,
                    'record' => $record,
                    'test' =>$test,
        ]);
    }
    
    
        public function actionEditChief($id) {
       
        $icno=Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = SenaraiKetua::find()->where(['id' => $id])->one();
        $carta = TblCartaJabatan::find()->where(['id' => $id])->andWhere(['level' => 1])->one();
             
        $record = $this->grid(SenaraiKetua::find()->joinWith('ketua')->where(['tblprcobiodata.DeptID' => $test->DeptId,'level_ketua'=>1]));
    
        if ($model->load(Yii::$app->request->post())) {
            $model->jabatan_id = $test->DeptId;
            $model->created_dt = date('Y-m-d H:i:s');
            $model->update_by =  $icno;
            $model->level_ketua =  1;
            $model->update_by =  $icno;
            $model->save(false);    
            
       
            $carta->jabatan_id =  $test->DeptId;
            $carta->icno = $model->icno;
            $carta->created_dt = date('Y-m-d H:i:s');
            $carta->update_by =  $icno;
            $carta->level =  1;
              $carta->level_ketua =  1;
              $carta->parent =  $model->icno;
            $carta->section =  $model->section_ketua;
              $carta->section_ketua =  $model->section_ketua;
            $parent_id = '1'.'.'.$model->section_ketua;
            $carta->parent_section = $parent_id;
            $carta->save(false);
           
            $peringkat = TblPeringkat::find()->where(['peringkat' => 1])->one();
            $peringkat->peringkat = 1;
            $peringkat->dept_id = $model->jabatan_id;
            $peringkat->updated = date('Y-m-d H:i:s');
            $peringkat->updated_by = $icno;
            $peringkat->save(false);
            
            $senaraiPeringkat = TblSenaraiPeringkat::find()->where(['id' => $model->id])->andWhere(['peringkat' => 1])->one();
            $senaraiPeringkat->id_peringkat = $peringkat->id;
            $senaraiPeringkat->icno = $model->icno;
            $senaraiPeringkat->section_id = $model->section_ketua;
            $senaraiPeringkat->nama = $model->ketua->CONm;
            $senaraiPeringkat->peringkat = 1;
            $senaraiPeringkat->section_details = $model->seksyenKetua->section_details;
            $senaraiPeringkat->save(false);
             
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['chief-details']);
        }

        return $this->render('edit-chief', [
                    'model' => $model,
                    'record' => $record,
                    'test' =>$test,'carta' => $carta
        ]);
    }
    
    
    public function actionTambahSu() {
       
        $icno=Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        
        $model = new SenaraiKetua();
        
        $record = $this->grid(SenaraiKetua::find()->joinWith('ketua')->where(['tblprcobiodata.DeptID' => $test->DeptId,'level_ketua'=>2]));
    
        if ($model->load(Yii::$app->request->post())) {
            $model->jabatan_id = $test->DeptId;
            $model->created_dt = date('Y-m-d H:i:s');
            $model->update_by =  $icno;
            $model->level_ketua =  2;
            $model->update_by =  $icno;
            $model->save(false);    
            
      
            $carta = new TblCartaJabatan();
            $carta->jabatan_id =  $test->DeptId;
            $carta->icno = $model->icno;
            $carta->created_dt = date('Y-m-d H:i:s');
            $carta->update_by =  $icno;
            $carta->level =  2;
            $carta->level_staff =  2;
            $carta->section =  $model->section_ketua;
            $carta->isSU = 1;
            $carta->save(false);
            
            
            
            $peringkat = new TblPeringkat();
            $peringkat->peringkat = 2;
            $peringkat->dept_id = $model->jabatan_id;
            $peringkat->updated = date('Y-m-d H:i:s');
            $peringkat->updated_by = $icno;
            $peringkat->save(false);
            
     
          
             $senaraiPeringkat = new TblSenaraiPeringkat();
            $senaraiPeringkat->id_peringkat = $peringkat->id;
            $senaraiPeringkat->icno = $model->icno;
            $senaraiPeringkat->section_id = $model->section_ketua;
            $senaraiPeringkat->nama = $model->ketua->CONm;
            $senaraiPeringkat->peringkat = 2;
            $senaraiPeringkat->section_details = $model->seksyenKetua->section_details;
            $senaraiPeringkat->save(false);
             
             
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['tambah-su']);
        }

        return $this->render('form_su_details', [
                    'model' => $model,
                    'record' => $record,
                    'test' =>$test,
        ]);
    }
    
    
     public function actionEditSu($id) {
       
        $icno=Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        
        $model = SenaraiKetua::find()->where(['id' => $id])->one();
        $carta = TblCartaJabatan::find()->where(['id' => $id])->andWhere(['level' => 2])->one();
        
        $record = $this->grid(SenaraiKetua::find()->joinWith('ketua')->where(['tblprcobiodata.DeptID' => $test->DeptId,'level_ketua'=>2]));
    
        if ($model->load(Yii::$app->request->post())) {
            $model->jabatan_id = $test->DeptId;
            $model->created_dt = date('Y-m-d H:i:s');
            $model->update_by =  $icno;
            $model->level_ketua =  2;
            $model->update_by =  $icno;
            $model->save(false);    
            
      
       
            $carta->jabatan_id =  $test->DeptId;
            $carta->icno = $model->icno;
            $carta->created_dt = date('Y-m-d H:i:s');
            $carta->update_by =  $icno;
            $carta->level =  2;
            $carta->level_staff =  2;
            $carta->section =  $model->section_ketua;
            $carta->isSU = 1;
            $carta->save(false);
            
            
            
            $peringkat = TblPeringkat::find()->where(['peringkat' => 2])->one();
            $peringkat->peringkat = 2;
            $peringkat->dept_id = $model->jabatan_id;
            $peringkat->updated = date('Y-m-d H:i:s');
            $peringkat->updated_by = $icno;
            $peringkat->save(false);
            
     
          
            $senaraiPeringkat = TblSenaraiPeringkat::find()->where(['id' => $model->id])->andWhere(['peringkat' => 2])->one(); 
            $senaraiPeringkat->id_peringkat = $peringkat->id;
            $senaraiPeringkat->icno = $model->icno;
            $senaraiPeringkat->section_id = $model->section_ketua;
            $senaraiPeringkat->nama = $model->ketua->CONm;
            $senaraiPeringkat->peringkat = 2;
            $senaraiPeringkat->section_details = $model->seksyenKetua->section_details;
            $senaraiPeringkat->save(false);
             
             
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['tambah-su']);
        }

        return $this->render('edit-su', [
                    'model' => $model,
                    'record' => $record,
                    'test' =>$test, 'carta' => $carta
        ]);
    }
    
    
    
      public function actionCartaDetails() {
       
        $icno=Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

        $model = new TblCartaJabatan();
        $record = $this->grid(TblCartaJabatan::find()->joinWith('kakitangan')->where(['tblprcobiodata.DeptID' => $test->DeptId]));
        if ($model->load(Yii::$app->request->post())) {
            $model->jabatan_id = $test->DeptId;
            $model->level = 1;
            $model->section = 1;
            $model->save(false);
            
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['carta-details']);
        }

        return $this->render('form_carta_details', [
                    'model' => $model,
                    'record' => $record,
            'test' =>$test,
        ]);
    }
    
    public function actionEditCarta($id, $title) {
                $icno=Yii::$app->user->getId();

                $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

        if ($title == 'unit-details') {
            $model = TblCartaJabatan::findOne(['id' => $id]);
            $record = $this->grid(TblCartaJabatan::find()->where(['ICNO' => $this->ICNO()]));
            $layout = 'form_unit_details';
        }
        elseif ($title == 'carta-details') {
            $model = TblCartaJabatan::findOne(['id' => $id]);
            $record = $this->grid(TblCartaJabatan::find()->where(['ICNO' => $this->ICNO()]));
            $layout = 'form_carta_details';
        }
        elseif ($title == 'section-details') {
//            $model = SenaraiSeksyen::findOne(['id' => $id]);
//            $record = $this->grid(SenaraiSeksyen::find()->where(['ICNO' => $this->ICNO()]));
//            $layout = 'form_section_details';
             $model = TblCartaJabatan::findOne(['id' => $id]);
            $record = $this->grid(TblCartaJabatan::find()->where(['ICNO' => $this->ICNO()]));
            $layout = 'form_section_details';
        }
         elseif ($title == 'tambah-section') {
            $model = RefSection::findOne(['id' => $id]);
            $organ = TblCartaJabatan::findOne(['id' => $id]);
            $record = $this->grid(RefSection::find()->where(['icno' => $this->ICNO()]));
            $layout = 'tambah-section';
          
        }
        elseif ($title == 'tambah-unit') {
            $model = RefUnit::findOne(['id' => $id]);
            $record = $this->grid(RefUnit::find()->where(['icno' => $this->ICNO()]));
            $layout = '_form';
        }
         elseif ($title == 'chief-details') {
            $model = TblCartaJabatan::findOne(['id' => $id]);
            $record = $this->grid(TblCartaJabatan::find()->where(['ICNO' => $this->ICNO()]));
            $layout = 'form_chief_details';
        }
         elseif ($title == 'tambah-su') {
            $model = TblCartaJabatan::findOne(['id' => $id]);
            $record = $this->grid(TblCartaJabatan::find()->where(['ICNO' => $this->ICNO()]));
            $layout = 'form_su_details';
        }
        elseif ($title == 'kelulusan-carta') {
            $model = TblCartaOrgan::findOne(['id' => $id]);
            $record = $this->grid(TblCartaOrgan::find()->where(['ICNO' => $this->ICNO()]));
            $layout = 'kelulusan-carta';
        }
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'updated/dikemaskini.']);
            return $this->redirect([$title]);
        }

        return $this->render($layout, [
                    'model' => $model,
                    'record' => $record,
                    'test' => $test,
                    'organ' => $organ,
        ]);
    }
     protected function findModelUnit($id)
    {
        
        if (($model = RefUnit::find()->where(['id'=>$id])->one()) !== null) {
//            var_dump($model);die;
//            \yii\helpers\VarDumper::dump($model, $depth, $highlight);die;
            return $model;
        }
         throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionKemaskiniUnit($id)
            {
                  $icno = Yii::$app->user->getId(); 

         $modelmel = $this->findModelUnit($id);
        $modelsBarang = $modelmel->fungsi;
                $biodata = $this->findBiodata();
                          $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

        $record = $this->grid(RefUnit::find()->joinWith('kakitangan')->where(['portfolio_ref_unit.jabatan_id' => $test->DeptId]));


        if ($modelmel->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsBarang, 'id', 'id');
            $modelsBarang = Model::createMultiple(RefFungsiUnit::classname(), $modelsBarang);
            Model::loadMultiple($modelsBarang, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsBarang, 'id', 'id')));

            $modelmel->icno = Yii::$app->user->getId();
            $modelmel->jabatan_id =  $biodata->DeptId;

            // validate all models
            $valid = $modelmel->validate();
            $valid = Model::validateMultiple($modelsBarang) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
        Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'kemaskini/updated.']);

                    if ($flag = ($modelmel->save(false))) {
                       
                        if (!empty($deletedIDs)) {
                            RefFungsiUnit::deleteAll(['id' => $deletedIDs]);
                        }

                        foreach ($modelsBarang as $i => $modelBarang) {
                            $modelBarang->unit_id = $modelmel->id;
                            $modelBarang->icno = $modelmel->icno;

                            if (!($flag = $modelBarang->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
            
                    if ($flag) {
                        $transaction->commit();
                        
                        return $this->redirect(['tambah-unit']);
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            } 
        }

        return $this->render('_form_fungsi', [
            'modelmel' => $modelmel,
            'modelsBarang'=> (empty($modelsBarang)) ? [new RefFungsiUnit()] : $modelsBarang,
            'record' =>$record,'test' =>$test
        ]);
    }
    
    public function actionDelete($id, $title) {

       
        if ($title == 'unit-details') {
//            $model = SenaraiUnit::findOne(['id' => $id]);
            $organ = TblCartaJabatan::findOne(['id'=>$id]);
//            $model->delete();
            $organ->delete();

            
        }
        
        if ($title == 'section-details') {
           $organ = TblCartaJabatan::findOne(['id'=>$id]);
//            $model->delete();
            $organ->delete();
        }
        
        
        if ($title == 'carta-details') {
           $organ = TblCartaJabatan::findOne(['id'=>$id]);
//            $model->delete();
            $organ->delete();
        }
         if ($title == 'tambah-su') {
           $organ = TblCartaJabatan::findOne(['id'=>$id]);
//            $model->delete();
            $organ->delete();
        }
        
          if ($title == 'tambah-section') {
            $model = RefSection::findOne(['id' => $id]);
            $model->delete();
        }
          if ($title == 'tambah-unit') {
            $model = RefUnit::findOne(['id' => $id]);
            $organ = RefFungsiUnit::findOne(['unit_id'=>$model->id]);
            $model->delete();
            $organ->delete();
        }
         if ($title == 'chief-details') {
            $organ = TblCartaJabatan::findOne(['id'=>$id]);
//            $model->delete();
            $organ->delete();
                  
        }
         if ($title == 'kelulusan-carta') {
            $model = TblCartaOrgan::findOne(['id' => $id]);
            $model->delete();
        }
       

        Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'deleted/dipadam.']);
        return $this->redirect([$title]);
    }
    public function actionTambahSection() {
  
        $model = new RefSection();
        $biodata = $this->findBiodata();
        $icno = Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $record = $this->grid(RefSection::find()->joinWith('kakitangan')->where(['portfolio_ref_section.jabatan_id' => $test->DeptId]));

                
        if ($model->load(Yii::$app->request->post()) ) {
            $model->jabatan_id =  $biodata->DeptId;
            $model->icno =  $icno;

            $model->save(false);
            
           

            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['tambah-section']);
        }

        return $this->render('tambah-section', [
                    'model' => $model,
                    'record' => $record,'test'=>$test
        ]);
    }
    
 
    
       
//      public function actionTambahUnit() {
//  
//        $model = new RefUnit();
//        $biodata = $this->findBiodata();
//        $icno = Yii::$app->user->getId();
//        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
//        $record = $this->grid(RefUnit::find()->joinWith('kakitangan')->where(['portfolio_ref_unit.jabatan_id' => $test->DeptId]));
//
//                
//        if ($model->load(Yii::$app->request->post()) ) {
//            $model->jabatan_id =  $biodata->DeptId;
//                                    $model->icno =  $icno;
//
//            $model->save(false);
//            
//           
//
//            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
//            return $this->redirect(['tambah-unit']);
//        }
//
//        return $this->render('tambah-unit', [
//                    'model' => $model,
//                    'record' => $record,'test'=>$test
//        ]);
//    }
      public function actionTambahUnit()
    {
                  $icno = Yii::$app->user->getId(); 

        $modelmel = new RefUnit();
        $modelsBarang = [new RefFungsiUnit()];
                $biodata = $this->findBiodata();
                          $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

        $record = $this->grid(RefUnit::find()->joinWith('kakitangan')->where(['portfolio_ref_unit.jabatan_id' => $test->DeptId]));


        if ($modelmel->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsBarang, 'id', 'id');
            $modelsBarang = Model::createMultiple(RefFungsiUnit::classname(), $modelsBarang);
            Model::loadMultiple($modelsBarang, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsBarang, 'id', 'id')));

            $modelmel->icno = Yii::$app->user->getId();
            $modelmel->jabatan_id =  $biodata->DeptId;

            // validate all models
            $valid = $modelmel->validate();
            $valid = Model::validateMultiple($modelsBarang) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'ditambah/added.']);
                    if ($flag = ($modelmel->save(false))) {
                       
                        if (!empty($deletedIDs)) {
                            RefFungsiUnit::deleteAll(['id' => $deletedIDs]);
                        }

                        foreach ($modelsBarang as $i => $modelBarang) {
                            $modelBarang->unit_id = $modelmel->id;
                            $modelBarang->icno = $modelmel->icno;
                            if (!($flag = $modelBarang->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
            
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['tambah-unit']);
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            } 
        }

        return $this->render('_form', [
            'modelmel' => $modelmel,
            'modelsBarang'=> (empty($modelsBarang)) ? [new RefFungsiUnit()] : $modelsBarang,
            'record' =>$record,'test' =>$test
        ]);
    }
    
      public function actionStatusStaf(){ //kategori // kumpulan //PengurusanTertinggiAkademik
        $icno = Yii::$app->user->getId();

         $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

        $query = StatusLantikan::find()->joinWith('biodata.jawatan')
                ->select('`ApmtStatusCd`,`ApmtStatusNm`,count(`tblprcobiodata`.`ICNO`) AS `_totalCount`')->where(['tblprcobiodata.DeptID' => $test->DeptId])
        
        ->andWhere(['!=','`tblprcobiodata`.`Status`','06'])->groupBy(['`appointmentstatus`.`ApmtStatusCd`']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        $dp = new ArrayDataProvider([
            'allModels' => $query->all(),
        ]);
        $array = [];
        foreach ($dp->getModels() as $data) {
            array_push($array,[$data->ApmtStatusNm,$data->_totalCount]);
        } 
        $jawatan = GredJawatan::find()->joinWith('biodata.serviceStatus')->select('`id`,`nama`,`gred`,count(`tblprcobiodata`.`ICNO`) AS `_totalCount`,count(`servicestatus`.`ServStatusCd`) AS `_totalAktif`,')
                ->where(['tblprcobiodata.DeptID' => $test->DeptId])

        ->andWhere(['!=','`tblprcobiodata`.`Status`','06'])->orderBy(['id'=>SORT_ASC])->groupBy('nama');

        $dataProvider2 = new ActiveDataProvider([
            'query' => $jawatan,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);
        return $this->render('status-lantikan',[
            'dataProvider' => $dataProvider,
            'array' => $array,
           'dataProvider2' => $dataProvider2,

       
        ]);

    }
    
    
        public function actionKelulusanCarta() {
  
        $model = new \app\models\portfolio\TblCartaOrgan(); 
        $icno = Yii::$app->user->getId();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $record = $this->grid(\app\models\portfolio\TblCartaOrgan::find()->where(['dept_id' => $test->DeptId]));
        
        $file = UploadedFile::getInstance($model, 'files');

         if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'portfolio');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = $model->file ? $model->file : '';
        }
                
        if ($model->load(Yii::$app->request->post()) ) {
          $model->created_at = date('Y-m-d H:i:s');
          $model->icno =  $icno;
          $model->file = $filepath;
          $model->dept_id = $test->DeptId;
          $model->save(false);
            
              
           

            Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'saved/disimpan.']);
            return $this->redirect(['kelulusan-carta']);
        }

        return $this->render('kelulusan-carta', [
                    'model' => $model,
                    'record' => $record,'test'=>$test
        ]);
    }
    
        public function actionPerakuan($id) {
        $icno = Yii::$app->user->getId();
        $dept = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

        $model = TblPortfolio::find()->where(['id' => $id])->one();
        $request = Yii::$app->request;
        $deskripsi = Tblportfolio::find()->where(['id' => $id])->one();
        $jawatanKuasa = \app\models\portfolio\TblJawatankuasa::find()->where(['myjd_id' => $id])->one();
        $aktiviti = \app\models\portfolio\TblAktiviti::find()->where(['myjd_id' => $id])->one();
        $borang = \app\models\portfolio\TblBorang::find()->where(['myjd_id' => $id])->one();
        $carta = TblCartaJabatan::find()->where(['icno' => $deskripsi->icno])->one();
        $fungsi = RefUnit::find()->where(['jabatan_id' => $dept->DeptId])->one();
                $proses = \app\models\portfolio\TblProsesKerja::find()->where(['myjd_id' => $id])->one();
        $viewAktiviti = TblProsesKerjaAktiviti::find()->where(['myjd_id' => $id ])->all();       

        $undang = \app\models\portfolio\TblUndang::find()->where(['myjd_id' => $id])->one();
        $mod = TblPortfolio::find()->where(['id' => $id, 'status_hantar_portfolio' => 1])->exists();
        $displaymohon = 'none';

        if ($mod) {
            $displaymohon = 'none';
        } elseif (!$mod) {
            $displaymohon = '';
        }


        if ($model->load($request->post())) {
            if($carta && $borang && $aktiviti && $fungsi && $undang && $jawatanKuasa && $deskripsi && $proses )
            {
            $model->status_hantar_portfolio = 1;
            $model->tarikh_hantar_portfolio = date('Y-m-d H:i:s');
            // $model->created_at = date('d-m-Y');
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar']);

            if ($model->kp != null) {
                $this->notification('myPortfolio', 'Semakan myPortfolio ' . "$model->name" . '&nbsp' . "untuk tindakan pihak tuan/puan." . Html::a('Klik Sini', ['portfolio/halaman-kp'], ['class' => 'btn btn-primary btn-sm']), $model->kp);
            } else {
                $this->notification('myPortfolio', 'Semakan myPortfolio ' . "$model->name" . '&nbsp' . "untuk tindakan pihak tuan/puan." . Html::a('Klik Sini', ['portfolio/halaman-kj'], ['class' => 'btn btn-primary btn-sm']), $model->kj);
            }

            $this->notification('myPortfolio', "myPortfolio tuan/puan berjaya dihantar ", $model->icno);
            return $this->redirect(['/portfolio/perakuan', 'id' => $deskripsi->id]);
        }
        
        else
        {
             Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'warning', 'msg' => 'Pastikan setiap perkara diisi (STATUS: SELESAI) sebelum menghantar myPortfolio!']);

            return $this->redirect(['perakuan?id='.$id]);
        }
        }
        
        return $this->render('perakuan', [
                    'model' => $model, 'mod' => $mod, 'displaymohon' => $displaymohon,
                    'deskripsi' => $deskripsi, 'jawatanKuasa' => $jawatanKuasa,
                    'aktiviti' => $aktiviti, 'borang' => $borang, 'fungsi' => $fungsi, 
            'undang' => $undang, 'carta' => $carta,'proses'=>$proses,'viewAktiviti'=>$viewAktiviti
        ]);
    }

    
       public function actionJanaPortfolio($id) {
        //   $icno = Yii::$app->user->getId();
        $deskripsi = Tblportfolio::find()->where(['id' => $id])->one();
        $model = TblPortfolio::find()->where(['id' => $id])->one();
        return $this->render('jana-portfolio', [
                    'model' => $model, 'deskripsi' => $deskripsi
        ]);
    }
     public function actionHalamanKp() {
        $permohonan = $this->GridSenaraiKp();
        return $this->render('halaman-kp', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function GridSenaraiKp() {
        $icno = Yii::$app->user->getId();
        $dept = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $data = new ActiveDataProvider([
            'query' => Tblportfolio::find()->where(['kp' => $icno, 'status_hantar_portfolio' => 1])->andWhere(['jabatan_semasa' => $dept->DeptId]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }
    public function actionPengesahanKp($id) {

        $model = TblPortfolio::find()->where(['id' => $id])->one();
        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request;
            $model->perakuan_kp = $request->post()['TblPortfolio']['perakuan_kp'];
            $model->tarikh_perakuan_kp = date('Y-m-d H:i:s');
            $model->save(false);


            if ($model->kp_agree == 2) {
                $kakitangan = TblPortfolio::find()->where(['id' => $id])->one();
                $kakitangan->status_hantar = null;
                $kakitangan->save(false);
                $this->notification('myPortfolio', "myPortfolio Tidak Diperakukan oleh Ketua Perkhidmatan. Sila perbaiki portfolio anda", $model->icno);
            }if ($model->kp_agree == 1) {
                $this->notification('myPortfolio', "myPortfolio Telah Diperakukan oleh Ketua Perkhidmatan ", $model->icno);
                //  $this->notification('MYJD', "Semakan Deskripsi Tugas kakitangan selian untuk tindakan pihak tuan", $model->kj);
                $this->notification('myPortfolio', 'Semakan myPortfolio' . "$model->name" . '&nbsp' . "untuk tindakan pihak tuan/puan." . Html::a('Klik Sini', ['my-portfolio/halaman-kj'], ['class' => 'btn btn-primary btn-sm']), $model->kj);
            }
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);

            return $this->redirect(['portfolio/halaman-kp']);
        }
        return $this->renderAjax('sahkan-kp', [
                    'model' => $model, 'kakitangan' => $kakitangan
        ]);
    }
    
     public function actionHalamanKj() {
        $permohonan = $this->GridSenaraiKj();
        return $this->render('halaman-kj', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function GridSenaraiKj() {
        $icno = Yii::$app->user->getId();
        $dept = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $data = new ActiveDataProvider([
            'query' => Tblportfolio::find()->where(['kj' => $icno, 'status_hantar_portfolio' => 1])->andWhere(['jabatan_semasa' => $dept->DeptId]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }
    
         public function actionHalamanPpp() {
        $permohonan = $this->GridSenaraiPpp();
        return $this->render('halaman-ppp', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function GridSenaraiPpp() {
        $icno = Yii::$app->user->getId();
        $dept = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $data = new ActiveDataProvider([
            'query' => Tblportfolio::find()->joinWith('cartaJabatan')->where(['parent' => $icno])->andWhere(['jabatan_semasa' => $dept->DeptId]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }
    
    public function actionPengesahanKj($id) {

        $model = TblPortfolio::find()->where(['id' => $id])->one();

        if ($model->kp != null) {
            if ($model->kp_agree == null) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => '', 'msg' => 'Menunggu Perakuan PP terlebih dahulu']);
                return $this->redirect(['portfolio/halaman-kj', 'id' => $model->id]);
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request;
            $model->perakuan_kj = $request->post()['TblPortfolio']['perakuan_kj'];
            $model->tarikh_perakuan_kj = date('Y-m-d H:i:s');
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);

            if ($model->kj_agree == 2) {
                $this->notification('myPortfolio', 'myPortfolio' . "$model->name" . '&nbsp' . "tidak Diluluskan oleh Ketua Jabatan." . Html::a('Klik Sini', ['portfolio/halaman-kj'], ['class' => 'btn btn-primary btn-sm']), $model->kp);
                //  $this->notification('MYJD', "Deskripsi Tugas Tidak Diluluskan oleh Ketua Jabatan.", $model->kp);
            }if ($model->kj_agree == 1) {
                $this->notification('myPortfolio', "myPortfolioTelah Diluluskan oleh Ketua Jabatan", $model->icno);
            }


            return $this->redirect(['portfolio/halaman-kj']);
        }
        return $this->renderAjax('sahkan-kj', [
                    'model' => $model,
        ]);
    }
    
    
      public function actionTambahFungsiUnit() {
        $icno = Yii::$app->user->getId(); 
        
          $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $record = $this->grid(RefUnit::find()->joinWith('kakitangan')->where(['portfolio_ref_unit.jabatan_id' => $test->DeptId]));

      //  $deskripsi = Tblportfolio::find()->where(['id' => $id])->one();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $modelPerson = RefSection::find()->where(['jabatan_id' => $biodata->DeptId])->one();
          
          
        $modelsHouse = [new RefUnit];
        $modelsRoom = [[new RefFungsiUnit]];

        if (Yii::$app->request->post()) {

            $modelsHouse = Model::createMultiple(RefUnit::classname());
            Model::loadMultiple($modelsHouse, Yii::$app->request->post());

            // validate person and houses models
            $valid = $modelPerson->validate();
            $valid = Model::validateMultiple($modelsHouse) && $valid;
                

                if (isset($_POST['RefFungsiUnit'][0][0])) {
                    foreach ($_POST['RefFungsiUnit'] as $indexHouse => $rooms) {
                        foreach ($rooms as $indexRoom => $room) {
                            $data['RefFungsiUnit'] = $room;
                            $modelRoom = new RefFungsiUnit;
                            $modelRoom->load($data);
                            $modelsRoom[$indexHouse][$indexRoom] = $modelRoom;
                            $valid = $modelRoom->validate();
                        }
                    }
                }
                if ($valid) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {

                        foreach ($modelsHouse as $indexHouse => $modelHouse) {

                            if ($flag === false) {
                                break;
                            }

                            $modelHouse->jabatan_id = $modelPerson->jabatan_id;
                         //   $modelHouse->section_id = $modelPerson->section_id;
                            $modelHouse->icno = $icno;

                            if (!($flag = $modelHouse->save(false))) {
                                break;
                            }


                            if (isset($modelsRoom[$indexHouse]) && is_array($modelsRoom[$indexHouse])) {
                                foreach ($modelsRoom[$indexHouse] as  $modelRoom) {
                                  
                                    $modelRoom->unit_id = $modelHouse->id;
                                    $modelRoom->icno = $icno;
                                    


                                    if (!($flag = $modelRoom->save(false))) {
                                        break;
                                    }
                                }
                            }


                            if (!($flag = $modelHouse->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }


                        if ($flag) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Disimpan']);
                            return $this->redirect(['tambah-fungsi-unit']);
                        } else {
                            $transaction->rollBack();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                                                        $modelRoom->save(false);

                }
            }
       

        return $this->render('tambah-fungsi-unit', [
                     'modelPerson' => $modelPerson,
                    'modelsHouse' => (empty($modelsHouse)) ? [new RefUnit] : $modelsHouse,
                    'modelsRoom' => (empty($modelsRoom)) ? [[new RefFungsiUnit]] : $modelsRoom,
                 //   'deskripsi' => $deskripsi
             'record' => $record,'test'=>$test
        ]);
    }
    
    
    
    public function actionDeskripsiTugas($id) {
        //  $icno = Yii::$app->user->getId();
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->with('applicant')->one();

        $ikhtisas = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $pengalaman = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $syarat = TblSyaratTambahan::find()->where(['portfolio_id' => $deskripsi->id])->all();
        return $this->render('deskripsi-tugas', ['deskripsi' => $deskripsi, 'lihatDimensi' => $lihatDimensi, 'ikhtisas' => $ikhtisas, 'pengalaman' => $pengalaman, 'lihatKompetensi' => $lihatKompetensi
                    , 'akauntabiliti' => $akauntabiliti, 'syarat' => $syarat]);
    }
    
    
     public function actionTambahAdmin() {
        $icno = Yii::$app->user->getId();
        $model = TblAkses::findOne(['icno' => $icno]);
         if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['portfolio/index']);
        }
        $admin = TblAkses::find()->All(); //cari senarai admin
        $adminbaru = new TblAkses; //untuk admin baru
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        if ($adminbaru->load(Yii::$app->request->post())) {
                    if(TblAkses::find()->where( [ 'icno' => $adminbaru->icno ] )->exists()){ //jika admin sudah wujud
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
                    
                    }
                    elseif($adminbaru->kakitangan->CONm != NULL){ //jika icno tidak wujud dalam sistem
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                         $this->notification('myPortfolio', 'Akses untuk Sistem myPortfolio.'.Html::a('Klik Sini', ['portfolio/index'], ['class' => 'btn btn-primary btn-sm']), $adminbaru->icno);
                         $adminbaru->save(false);
                    }
                    else{
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
                    
                    }
                    
                    return $this->redirect(['portfolio/tambah-admin']);
                }
        if(TblAkses::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
        return $this->render('tambah-admin', [
            'admin' => $admin,
            'adminbaru' => $adminbaru,
            'allbiodata' => $allbiodata,
        ]);}
    }
    
    
       public function actionDeleteAdmin($id) {
        $proses = \app\models\portfolio\TblAkses::find()->where(['id' => $id])->one();
        $proses->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['tambah-admin']);
    }
    
        public function actionTambahFungsi($id) {
        $icno = Yii::$app->user->getId();
        $akauntabilitiTitle = RefUnit::find()->where(['id' => $id])->one();
        $lihatTugass = new RefFungsiUnit();

        if ($lihatTugass->load(Yii::$app->request->post())) {

            $lihatTugass->icno = $icno;
            $lihatTugass->unit_id = $id;
            $lihatTugass->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
            return $this->redirect(['portfolio/tambah-fungsi-unit']);
        }

        return $this->render('tambah-fungsi', ['akauntabilitiTitle' => $akauntabilitiTitle, 'lihatTugass' => $lihatTugass]);
    }
	
    public function actionKemaskiniProsesKerja($id, $myjd_id) {
   
      $icno = Yii::$app->user->getId(); 

      
        $modelsBarang = TblProsesKerjaAktiviti::find()->where(['id' => $id])->all();
        $models= TblProsesKerjaAktiviti::find()->where(['id' => $id])->one();
        $modelmel = TblProsesKerja::find()->where(['id' => $models->id_proses])->one();

        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $deskripsi = TblPortfolio::find()->where(['id' => $myjd_id])->one();
        $carta = TblCartaJabatan::find()->where(['icno' => $deskripsi->icno ])->one();
        $refFungsi =  ArrayHelper::map(\app\models\portfolio\RefFungsiUnit::find()->all(), 'id', 'description');
      
        $viewAktiviti = \app\models\portfolio\TblProsesKerja::find()->where(['myjd_id' => $id ])->all();       

        if ($modelmel->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsBarang, 'id', 'id');
            $modelsBarang = Model::createMultiple(TblProsesKerjaAktiviti::classname(), $modelsBarang);
            Model::loadMultiple($modelsBarang, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsBarang, 'id', 'id')));

//            $modelmel->icno = Yii::$app->user->getId();
//            $modelmel->jabatan_id =  $biodata->DeptId;
            
          //  $modelmel->myjd_id = $deskripsi->id;
         //   $modelmel->icno = $deskripsi->icno;
            $modelmel->created_at = date('Y-m-d H:i:s');
            
            $file = UploadedFile::getInstance($modelmel, 'file');

         if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'portfolio');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = $modelmel->file ? $modelmel->file : '';
        }
             $modelmel->file = $filepath;
             
//            $tblUndang = \app\models\portfolio\TblUndang::find()->where(['id_proses' => $modelmel->id ])->one();
//        //    $tblUndang->icno =  $modelBarang->icno;
//        //    $tblUndang->myjd_id =  $modelBarang->myjd_id;
//            $tblUndang->catatan =   $modelmel->undang;
//            $tblUndang->created_at = date('Y-m-d H:i:s');
//            $tblUndang->save(false);
            
  
            // validate all models
            $valid = $modelmel->validate();
            $valid = Model::validateMultiple($modelsBarang) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'ditambah/added.']);
                    if ($flag = ($modelmel->save(false))) {
                       
                        if (!empty($deletedIDs)) {
                            TblProsesKerjaAktiviti::deleteAll(['id' => $deletedIDs]);
                        }

                        foreach ($modelsBarang as $modelBarang) {

                       //     $modelBarang->id_proses = $modelmel->id;
                       //     $modelBarang->icno = $modelmel->icno;
                       //     $modelBarang->myjd_id = $modelmel->myjd_id;
                            $modelBarang->created_at = date('Y-m-d H:i:s');
                          //  $modelBarang->file = $filepath;

           
                            if (!($flag = $modelBarang->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
            
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini.']);
         
                        return $this->redirect(['proses-kerja', 'id' => $modelmel->myjd_id]);
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            } 
        }

        return $this->render('kemaskini-proses-kerja', [
            'modelmel' => $modelmel,
            'modelsBarang'=> (empty($modelsBarang)) ? [new TblProsesKerjaAktiviti()] : $modelsBarang,
            'test' =>$test, 'deskripsi' => $deskripsi,  'viewAktiviti' => $viewAktiviti, 'refFungsi' => $refFungsi, 'carta' => $carta
        ]);
    }

    public function actionDeleteProsesKerja($id, $myjd_id) {
        //  $icno = Yii::$app->user->getId(); 
       $proses = TblProsesKerjaAktiviti::find()->where(['id' => $id])->one();
       // $lihatAkauntabiliti = TblAkauntabiliti::find()->where(['id' => $id])->one();
        $proses->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['proses-kerja', 'id' => $myjd_id]);
    }
    
    
     public function actionKemaskiniSenaraiUndang($id, $myjd_id) {
         $deskripsi = TblPortfolio::find()->where(['id' => $myjd_id])->one();
         $request = Yii::$app->request;
         $proses = \app\models\portfolio\TblUndang::find()->where(['id' => $id])->one();
         $file = UploadedFile::getInstance($proses, 'files');
         
         $carta = \app\models\portfolio\TblUndang::find()->where(['id' => $id])->one();

         if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'portfolio');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = $carta->file ? $carta->file : '';
        }
          $request = Yii::$app->request;
          if ($proses->load($request->post())) {
            $proses->file = $filepath;
            $proses->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini.']);
            return $this->redirect(['senarai-undang', 'id' => $myjd_id]);
        }
        

        return $this->render('kemaskini-senarai-undang', ['deskripsi' => $deskripsi, 'proses' => $proses, 'carta' => $carta
        ]);
    }

    public function actionDeleteSenaraiUndang($id, $myjd_id) {
        //  $icno = Yii::$app->user->getId(); 
       $proses = \app\models\portfolio\TblUndang::find()->where(['id' => $id])->one();
       // $lihatAkauntabiliti = TblAkauntabiliti::find()->where(['id' => $id])->one();
        $proses->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['senarai-undang', 'id' => $myjd_id]);
    }
    
       
      public function actionSenaraiCarta($id = null, $chief = null, $pp = null, $icnoMelulus = null)
    {
    
        $listicno = Tblprcobiodata::find()->where(['<>', 'tblprcobiodata.Status', '6']);
      //  $list = $category ? $listicno->joinWith('jawatan')->where(['gredJawatan.job_category' => $category]) : $listicno;
        $id ? $listicno->where(['id' => $id]) : $listicno;
     //   $khidmat ? $listicno->joinWith('jawatan')->where(['gredJawatan.job_group' => $khidmat]) : $listicno;
        $chief ? $listicno->where(['chief' => $chief]) : $listicno;
        $pp ? $listicno->where(['pp' => $pp]) : $listicno;
        $icnoMelulus ? $listicno->joinWith('cartaOrgan')->where(['cartaOrgan.icno_meluluskan' => $icnoMelulus]) : $listicno;
       
       //  $dep = Department::find()->all();

            $dataProvider = new ActiveDataProvider([
            'query' => Department::find()
                    //  ->where(['id' => $listicno->select(['DeptId'])])
                      ->where(['isActive' => 1])
                      ->with('cartaOrgan'),
               //       ->andWhere(['portfolio_tbl_carta_organ.dept_id' => $dep->id]),
                    //  ->with('jawatan'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
             
    
        if (isset(Yii::$app->request->queryParams['chief'])) {
            $chief ? $dataProvider->query->andFilterWhere(['chief' => $chief]) : '';
        }
        

        if (isset(Yii::$app->request->queryParams['id'])) {
            $id ? $dataProvider->query->andFilterWhere(['id' => $id]) : '';
        }

        if (isset(Yii::$app->request->queryParams['pp'])) {
            $pp ? $dataProvider->query->andFilterWhere(['pp' => $pp]) : '';
        }
        
//          if (isset(Yii::$app->request->queryParams['department.cartaOrgan.icno_meluluskan'])) {
//            $icnoMelulus ? $dataProvider->query->andFilterWhere(['department.cartaOrgan.icno_meluluskan' => $icnoMelulus]) : '';
//        }
        
        isset(Yii::$app->request->queryParams['department.cartaOrgan.icno_meluluskan']) ? $icnoMelulus->query->andFilterWhere
                                (['like', 'department.cartaOrgan.icno_meluluskan', Yii::$app->request->queryParams['department.cartaOrgan.icno_meluluskan']]) : '';
        
//        if (isset(Yii::$app->request->queryParams['biodataHarta.status'])) {
//            $status ? $dataProvider->query->andFilterWhere(['biodataHarta.status' => $status]) : '';
//        }

        return $this->render('senarai-carta', [
            'id' => $id,
            'pp' => $pp,
            'chief' => $chief,
            'dataProvider' => $dataProvider, 
            'icnoMelulus' => $icnoMelulus
//            'category' => $category,
//            'list' => $list,
//            'status' => $status,
//            'khidmat' => $khidmat
        ]);
    }
    
    
      public function actionGeneratePortfolio($id) {

        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $ikhtisas = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $pengalaman = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $tugas = TblTugasUtama::find()->where(['akauntabiliti_id' => $id])->all();
        $syarat = TblSyaratTambahan::find()->where(['portfolio_id' => $deskripsi->id])->all();
        // get your HTML raw content without any layouts or scripts

        $content = $this->renderPartial('cetak-portfolio', ['deskripsi' => $deskripsi, 'ikhtisas' => $ikhtisas, 'lihatDimensi' => $lihatDimensi, 'pengalaman' => $pengalaman, 'lihatKompetensi' => $lihatKompetensi, 'akauntabiliti' => $akauntabiliti, 'syarat' => $syarat, 'tugas' => $tugas]);
 $css = file_get_contents('./css/cetakBrp.css');
          

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
            // set mPDF properties on the fly
            'options' => ['title' => 'Nota Serah Tugas'],
            // call mPDF methods on the fly
              
         
            'methods' => [
          //    'SetHeader' => ['Buku Rekod Perkhidmatan'],
                     'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
                     'WriteHTML' => [$css, 1]
             
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    
    
     public function actionTambahPeringkat()
    {
                  
       $icno = Yii::$app->user->getId(); 

        $modelmel = new TblPeringkat();
        $modelsBarang = [new TblSenaraiPeringkat()];
        $biodata = $this->findBiodata();
        $test = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

//       $record = $this->grid(TblSenaraiPeringkat::find()->joinWith('idPeringkat')->orderBy(['peringkat'=>SORT_ASC]));

       $record = $this->grid(TblSenaraiPeringkat::find()->joinWith('idPeringkat')->where(['dept_id' => $test->DeptId])->orderBy(['peringkat'=>SORT_ASC]));

        if ($modelmel->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsBarang, 'id', 'id');
            $modelsBarang = Model::createMultiple(TblSenaraiPeringkat::classname(), $modelsBarang);
            Model::loadMultiple($modelsBarang, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsBarang, 'id', 'id')));

            $modelmel->updated_by = Yii::$app->user->getId();
            $modelmel->updated = date('Y-m-d H:i:s');
            $modelmel->dept_id =  $biodata->DeptId;

            // validate all models
            $valid = $modelmel->validate();
            $valid = Model::validateMultiple($modelsBarang) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
           Yii::$app->session->setFlash('alert', ['title' => 'Success/Berjaya', 'type' => 'success', 'msg' => 'ditambah/added.']);
                    if ($flag = ($modelmel->save(false))) {
                       
                        if (!empty($deletedIDs)) {
                            TblSenaraiPeringkat::deleteAll(['id' => $deletedIDs]);
                        }

                        foreach ($modelsBarang as $i => $modelBarang) {
                            $modelBarang->id_peringkat = $modelmel->id;
              
   
    if($modelBarang->section_id != null){
              $modelBarang->peringkat = $modelmel->peringkat;
            $modelBarang->nama = $modelBarang->kakitangan->CONm;
           $modelBarang->section_details = $modelBarang->section->section_details;
          $modelBarang->unit_details = '';
    }else{
              $modelBarang->peringkat = $modelmel->peringkat;
            $modelBarang->nama = $modelBarang->kakitangan->CONm;
                $modelBarang->section_details = '';
           $modelBarang->unit_details = $modelBarang->unit->unit_details;
         
    }
         
      
             
                            if (!($flag = $modelBarang->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
            
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['tambah-peringkat']);
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            } 
        }

        return $this->render('tambah-peringkat', [
            'modelmel' => $modelmel,
            'modelsBarang'=> (empty($modelsBarang)) ? [new TblSenaraiPeringkat()] : $modelsBarang,
            'record' =>$record,'test' =>$test
        ]);
    }
    
  
    
         public function actionStatistik() {
        $model = Department::find()
                ->where([ 'isActive' => '1'])->andWhere(['<>','chief','null'] )->orderBy(['fullname'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('statistik', ['dataProvider' => $dataProvider
        ]);
    }
    public function actionSenaraiAll($kumpulan, $category) {



        if ($category == 0) { //keseluruhan
           
            $list =  Tblprcobiodata::find()
                    ->where(['<>','status', 6])
                    ->andWhere(['tblprcobiodata.DeptId' => $kumpulan])
                    ->orderBy('CONm');
        } 
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-all', [
                    'dataProvider' => $dataProvider,
        ]);
    }  public function actionSenaraiSelesai($kumpulan, $category) {

        if ($category == 0) { //keseluruhan
            $list = TblPortfolio::find()
                     ->andWhere(['jabatan_semasa' => $kumpulan])
                    ->andWhere(['status_hantar'=>1])
                    ->orderBy('tarikh_hantar');
                   
        }
            
        
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-selesai', [
                    'dataProvider' => $dataProvider,
//            'lkp'=>$lkp
        ]);
    }
    public function actionSenaraiBelumHantar($kumpulan, $category) {

        if ($category == 0) { //keseluruhan
            $list = TblPortfolio::find()
                     ->andWhere(['jabatan_semasa' => $kumpulan])
                    ->andWhere(['!=','status_hantar',1])
                    ->orderBy('tarikh_hantar');
                   
        }
            
        
        $dataProvider = new ActiveDataProvider([
            'query' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('senarai-selesai', [
                    'dataProvider' => $dataProvider,
//            'lkp'=>$lkp
        ]);
    }
    
    
        public function actionPadamPeringkat($id) {
        //   $icno = Yii::$app->user->getId(); 
        $portfolio = TblSenaraiPeringkat::find()->where(['id' => $id])->one();
        $portfolio2 = TblPeringkat::find()->where(['id' => $portfolio->id])->one();
        $portfolio->delete();
        $portfolio2->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);
        return $this->redirect(['tambah-peringkat']); 
        }
        
        
         public function actionPadamSu($id) {
        //   $icno = Yii::$app->user->getId(); 
        $portfolio = TblSenaraiPeringkat::find()->where(['id' => $id])->one();
        $portfolio2 = TblPeringkat::find()->where(['id' => $id])->one();
        $portfolio3 = TblCartaJabatan::find()->where(['id' => $id])->one();
        $portfolio4 = SenaraiKetua::find()->where(['id' => $id])->one();
        $portfolio->delete();
        $portfolio2->delete();
        $portfolio3->delete();
        $portfolio4->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);
        return $this->redirect(['tambah-su']); 
        }
    
    
        
        public function actionStatelist() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = RefUnit::find()->select(['id' => 'id', 'name' => 'unit_details'])->where(['section_id' => $cat_id])->asArray()->all();

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionCitylist() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = RefFungsiUnit::find()->select(['id' => 'id', 'name' => 'description'])->where(['unit_id' => $cat_id])->asArray()->all();

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }
    
    
        public function actionFungsilist() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = \app\models\portfolio\TblAktiviti::find()->select(['id' => 'id', 'name' => 'aktiviti'])->where(['fungsi_id' => $cat_id])->asArray()->all();

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }
    
}
