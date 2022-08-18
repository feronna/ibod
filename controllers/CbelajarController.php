<?php

namespace app\controllers;
use Yii;
use app\models\cbelajar\TblPengajian;
use app\models\cbelajar\TblPengajianSearch;
use app\models\cbelajar\TblDokumen;
use app\models\cbelajar\TblSyarat;
use app\models\cbelajar\Model;
use app\models\cbelajar\TblNilaiSyarat;
use app\models\hronline\Tblprcobiodata;
use app\models\cbelajar\TblFilePemohon;
use app\models\cbelajar\TblpImage;
use app\models\cbelajar\TblPermohonan;
use app\models\cbelajar\TblPermohonanSearch;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Tblpendidikan;
use app\models\hronline\Tblrscoconfirmstatus;
use app\models\cbelajar\TblAdmin;
use app\models\cbelajar\TblUrusMesyuarat;
use app\models\cbelajar\TblBiasiswa;
use app\models\cbelajar\TblBiasiswaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
use yii\web\UploadedFile;
use app\models\hronline\Department;
use yii\helpers\ArrayHelper;


class CbelajarController extends Controller
{
    

	 public function behaviors() {
    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['kj','page-lapor','page-tuntutan','admin-view', 'halaman-admin', 'senaraitindakan1', 'page-semak','senaraitindakanlain',
//                    'senaraitindakan', 'nominal-damages','laporan','senarai-borang'],
//                'rules' => [
//                    [
//                        'actions' => ['kj','page-lapor','page-tuntutan','admin-view', 'halaman-admin', 'senaraitindakan1', 'page-semak', 'senaraitindakanlain',
//                            'senaraitindakan','nominal-damages', 'laporan','senarai-borang'],
//                        'allow' => true,
//                        'roles' => ['@'],
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
       return 
        
        [
            'access' => [
                
                
                
                'class' => AccessControl::className(),
                'only' => ['senarai-borang','gambar', 'maklumat-peribadi', 'maklumat-akademik','maklumat-pengajian',
                           'maklumat-biasiswa','senarai-dokumen-dimuatnaik','senarai-dokumen',
                           'muat-naik-dokumen','kpm','biasiswaums','lihatpengajian','lihatpengajiansm',
                           'tambah-pengajian','update',
                    ],
                'rules' => [
//                                        Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),
[
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],  
                    ],
                    [
                        'actions' => ['senarai-borang','maklumat-peribadi', 'maklumat-akademik', 
                            'maklumat-keluarga','maklumat-biasiswa','maklumat-pengajian', 'gambar',
                            'senarai-dokumen-dimuatnaik','senarai-dokumen','muat-naik-dokumen','kpm',
                            'biasiswaums','lihatpengajian','lihatpengajiansm','tambah-pengajian','update'],
                        'allow' => true,
//                        'rules'=> ['@'],
                        
                        'matchCallback' => function($rule,$action)
                        {
                                 $icno=Yii::$app->user->getId();
                            if($icno){
                            $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
                            if(($biodata->statLantikan=='1' && $biodata->jawatan->job_category =='1') ||
                               ($biodata->statLantikan=='7' && $biodata->jawatan->job_category =='1') ||
                               ($biodata->statLantikan=='2' && $biodata->jawatan->job_category =='1') || 
                               ($biodata->statLantikan=='1' && $biodata->jawatan->job_category =='2')){
                                return true;
                            }else{
                                return false;
                            }}

//                            if((Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jawatan->job_category == "1") || (Yii::$app->user->identity->statLantikan == "2"  && Yii::$app->user->identity->jawatan->job_category == "1")
//                                    || (Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jawatan->job_category == "2"))
//                            {
//                                return TRUE;
//                            }
//                           
//                            if(in_array (Yii::$app->user->getId(),['950829125446','860130125080']))
//                            {
//                                return TRUE;
//                            }
//                           
//                                return FALSE;
//                           
                        } ,
                    ],
                                
                                [
                        'actions' => ['senarai-borang'],
                        'allow' => true,
                        'matchCallback' => function($rule,$action)
                        {
                             $icno=Yii::$app->user->getId();
                            if($icno){
                            $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
                            if(($biodata->statLantikan=='1' && $biodata->jawatan->job_category =='1') ||
                               ($biodata->statLantikan=='2' && $biodata->jawatan->job_category =='1') || 
                               ($biodata->statLantikan=='1' && $biodata->jawatan->job_category =='2')){
                                return true;
                            }else{
                                return false;
                            }}
                             
//
//                            if((Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jawatan->job_category == "1") || (Yii::$app->user->identity->statLantikan == "2"  && Yii::$app->user->identity->jawatan->job_category == "1"))
//                            {
//                                return TRUE;
//                            }
//                           
                            if(in_array (Yii::$app->user->getId(),['891103125554']))
                            {
                                return TRUE;
                            }
                           
                                return FALSE;
                           
                        } ,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
//                'rule'=>['@'],
                'actions' => [
//                                        'logout' => ['post'],
                ],
            ],
        ];
   
         }}

    //Get User IC
	protected function icno() { 
        
        return Yii::$app->user->getId(); 
    }
    //Halaman Utama Pemohon
//    public function actionHalamanUtamaPemohon()
//    {
//        $model = new TblPermohonan();
//        $icno=Yii::$app->user->getId();
//        $model->icno = $icno;
//        if($model->kakitangan->statLantikan== "1"  && $model->kakitangan->jawatan->job_category=="1"){ //jika user staf lantikan tetap & staf akademik
//        return $this->render('main-pemohon', 
//                ['model' => $model
//        ]);
//        }
//        else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('../cutisabatikal/senaraitindakan');}
//    }

//     public function actionHalamanUtamaBsm()
//    {
//        $iklan_semasa = $this->findIklan(1);
//        $senarai_iklan = $this->findIklan(0);
//        $jumlah_permohonan1 = $this->findJumlahPermohonanTahunan();
//        $jumlah_permohonan = $this->findJumlahPermohonanSemasa();
//        $jumlah_permohonan_berjaya = $this->findJumlahPermohonanBerjaya();
//        $jumlah_permohonan_gagal = $this->findJumlahPermohonanDitolak();
//       
//        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
//        
//        return $this->render('main-bsm', [
//                    
//                    'iklan_semasa' => $iklan_semasa,
//                    'senarai_iklan' => $senarai_iklan,
//                    'jumlah_permohonan1' => $jumlah_permohonan1,
//                    'jumlah_permohonan' => $jumlah_permohonan,
//                    'jumlah_permohonan_berjaya' => $jumlah_permohonan_berjaya,
//                    'jumlah_permohonan_gagal' => $jumlah_permohonan_gagal,
//
//                  
//        ]);
//
//    }
//    else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->render('/cutibelajar/index');}
//       
//    }

     public function updateJumlahMohon($id) {
        $update = $this->findIklanbyID($id);
        $update->jumlah_mohon = $update->jumlah_mohon + 1;
        $update->save(false);
    }

    public function actionLihatpengajian($id)
    {
      
        return $this->render('lihatpengajian', [
            
            'model' => $this->findModelbyid($id),  
//            'iklan' => $this->findIklanbyID($model->iklan_id),
        ]);
    }
     public function actionLihatpengajiansm($id)
    {
      
        return $this->render('/cutibelajar/separuhmasa/_lihatpengajian', [
            
            'model' => $this->findModelbyid($id),  
//            'iklan' => $this->findIklanbyID($model->iklan_id),
        ]);
    }
     public function actionUpdateSponsor($id)
    {
        $model = \app\models\cbelajar\TblBiasiswa::find()->where(['id'=>$id])->one();
//        $icno = $model->icno;

//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
             $model->save(false);
            return $this->redirect(['cbelajar/maklumat-biasiswa?id='.$model->iklan_id]);
            
        }

        return $this->renderAjax('_updateb', [
            'model' => $model,
         
        ]);
    }
    public function actionUpdateSponsorSm($id)
    {
        $model = \app\models\cbelajar\TblBiasiswa::find()->where(['id'=>$id])->one();
//        $icno = $model->icno;

//        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
//        var_dump('a');die;
        if ($model->load(Yii::$app->request->post())) {
             $model->save(false);
            return $this->redirect(['cbelajar/maklumat-biasiswa-separuh-masa?id='.$model->iklan_id]);
            
        }

        return $this->renderAjax('_updatebsm', [
            'model' => $model,
         
        ]);
    }
    public function actionLihatbiasiswa($id)
    {
        
        return $this->render('lihatbiasiswa', [
            'model' => $this->findBiasiswabyid($id),  
           
        ]);
    }
     public function actionLihatbiasiswasm($id)
    {
        
        return $this->render('/cutibelajar/separuhmasa/_lihatbiasiswa', [
            'model' => $this->findBiasiswabyid($id),  
           
        ]);
    }
    public function actionTambahPengajian($id) {
        $icno = Yii::$app->user->getId();
        $model = new TblPengajian();
        $iklan = $this->findIklanByID($id);
        $biodata = $this->findBiodata();
//        $permohonan = $this->findPermohonanbyID($id);
        $file = UploadedFile::getInstance($model, 'file1');
            if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        if ($model->load($post = Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->idBorang=1;
             $model->gred = $biodata->jawatan->gred;
            $model->status_proses = "S";
            $model->status = 9; //dalam proses;
//            $model->tarikh_mula = 2020-10-30;
//            $model->tarikh_tamat = 2023-10-29;
//            $model->full_dt = $post['TblPengajian']['full_dt'];
            $model->modeID;
            $model->save(false);

//            $model->parent_id = $iklan->id;
//            $model->idPermohonan = $permohonan->id;
//            if($model->save(false)){
////                    echo $pengajian->tarikh_mula;
//                    $sem = \app\models\cbelajar\TblLkk::Semlkk($model->icno);
//                    $effectiveDate = $model->tarikh_mula;
//                    for ($i = 1; $i <= round($sem); $i++)
//                    {
////                        echo round($sem);
//                        $lkk = new \app\models\cbelajar\TblLkk();
//                        $lkk->icno = $icno;
//                        $lkk->semester = $i;
//                        $lkk->effectivedt = $effectiveDate;
//                        $effectiveDate = date('Y-m-d', strtotime("+6 months", strtotime($effectiveDate)));
//                        $lkk->save(false);
//                     }
                     
         
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Pengajian telah Berjaya ditambah!']);
                
                return $this->redirect(['maklumat-pengajian', 'id' => $iklan->id]);
//            }
            
        }
        return $this->render('tambahpengajian', [
                    'model' => $model,
                    'iklan' => $iklan,
//                    'permohonan' => $permohonan,
//                    'id' => $id,
        ]);
    }
    public function actionTambahPengajianSm($id) {
        $icno = Yii::$app->user->getId();
        $model = new TblPengajian();
        $iklan = $this->findIklanByID($id);
                $biodata = $this->findBiodata();

//        $permohonan = $this->findPermohonanbyID($id);
        $file = UploadedFile::getInstance($model, 'file1');
            if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        if ($model->load($post = Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->gred = $biodata->jawatan->gred;
            $model->status_proses = "S";

            $model->idBorang=38;
            $model->status = 9; //dalam proses;
            $model->modeStudy = "SEPARUH MASA";
            $model->modeID;
            $model->save(false);


                     
         
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Pengajian telah Berjaya ditambah!']);
                
                return $this->redirect(['maklumat-pengajian-separuh-masa', 'id' => $iklan->id]);
            
        }
        return $this->render('/cutibelajar/separuhmasa/_formpengajian', [
                    'model' => $model,
                    'iklan' => $iklan,
        ]);
    }
    public function actionTerima($id){
         
                $model = $this->findModeltiket($id);
                $model->ver_date = date('Y-m-d H:i:s');
                $icno = Yii::$app->user->getId();
                $today = date('Y-m-d');
                $request = Yii::$app->request;
                $status = TblPermohonan::find()->where(['icno' => $icno, 'status_proses' => "Selesai Permohonan", 'idBorang'=>1 ])->all();
//                $tajaan = TblBiasiswa::findOne(['icno' => Yii::$app->user->getId()]);
                if($model->terima1 == 'Ya' || $model->terima1 == 'Tidak Terima'){
                    $displaylapor='';$displaytempoh='none'; } 
                else{
                    $displaytempoh='';$displaylapor='none';}
                
               
               $message = '';
               if($model->load($request->post())){
               $model->terima1 = $request->post()['TblPermohonan']['terima1'];
               $model->catatan_terima = $request->post()['TblPermohonan']['catatan_terima'];
               $model->ver_by = $icno;
               $model->status_proses = "Terima Tawaran";
               $model->save(false);
               $message = 'Berjaya Disimpan';

                }
                
            return $this->renderAjax('terima', [
                'model' => $model,
                'today' => $today,
                'message' => $message,
                'status'=>$status,
                'displaytempoh' => $displaytempoh,
              
             
            ]); 
    }
     protected function findModeltiket($id){
        
        if (($model = \app\models\cbelajar\TblPermohonan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionTambahBiasiswa($id) {
        $icno = Yii::$app->user->getId();
        $model = new TblBiasiswa();
        $modelCustomer = new TblPermohonan(); 
        $modelsAddress = [new TblBiasiswa()]; 
        $model2 = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
        $iklan = $this->findIklanByID($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->iklan_id = $iklan->id;
            $model->bentukBantuan_ums;
            $model->BantuanCd;
            $model->icno = $icno;
            $model->idBorang = 1;
              $model->status = 9;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->tahun = date("Y");
            if($model->save(false)){
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya ditambah!']);
                return $this->redirect(['maklumat-biasiswa', 'id' => $iklan->id ]);
            }
            
        }
        return $this->render('tambahbiasiswa', [
            'model' => $model,
            'iklan' => $iklan,
            'model2' => $model2,
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => $modelsAddress,
        ]);
    }
    public function actionTambahBiasiswaSm($id) {
        $icno = Yii::$app->user->getId();
        $model = new TblBiasiswa();
        $modelCustomer = new TblPermohonan(); 
        $modelsAddress = [new TblBiasiswa()]; 
        $model2 = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
        $iklan = $this->findIklanByID($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->iklan_id = $iklan->id;
            $model->bentukBantuan_ums;
            $model->BantuanCd;
            $model->icno = $icno;
            $model->idBorang = 38;
              $model->status = 9;
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->tahun = date("Y");
            if($model->save(false)){
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya ditambah!']);
                return $this->redirect(['maklumat-biasiswa', 'id' => $iklan->id ]);
            }
            
        }
        return $this->render('/cutibelajar/separuhmasa/_formbiasiswa', [
            'model' => $model,
            'iklan' => $iklan,
            'model2' => $model2,
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => $modelsAddress,
        ]);
    }
    public function actionUpdatePengajian($id)
    {   
        $iklan = $this->findIklanbyID($id);
        $model = $this->findModelbyid($id);
     
         
        if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Pengajian telah Berjaya dikemaskini!']);
                   return $this->redirect(['maklumat-pengajian', 'id' => $iklan->id]);
                }
        }
       

        return $this->render('update_pengajian', [
            'model' => $model,
            'iklan' =>$iklan,
            
        ]);
    }
     public function actionUpdateBiasiswa($id)
    {   
        $model = $this->findBiasiswabyid($id);
        $iklan =  $this->findIklanbyID(15);

        if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya dikemaskini!']);
                   return $this->redirect(['maklumat-biasiswa', 'id'=>$iklan->id]);
                }
        }
       

        return $this->render('tajaanluar', [
            'model' => $model,
            'iklan' => $iklan,
        ]);
    }
    protected function findModelbyid($id)
    {
        if (($model = TblPengajian::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findBiasiswabyid($id)
    {
        if (($model = TblBiasiswa::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //Page Senarai Dokumen Yang Perlu Dimuat Naik

     public function actionSenaraiDokumen($id)
    {

        $senarai_dokumen = $this->findDokumen(1);
        $senarai_dokumenkpm = $this->findDokumenKpm(1);
        $senarai_dokumenln = $this->findDokumenLn(1);
        $iklan = $this->findIklanbyID($id);
        return $this->render('form_upload_dokumen', 
        [
            'senarai_dokumen' => $senarai_dokumen,
            'senarai_dokumenkpm' => $senarai_dokumenkpm,
            'senarai_dokumenln' => $senarai_dokumenln,
            'iklan' => $iklan,
                         
        ]);
    }
    // dokumen separuh masa yg perlu diupload
    public function actionSenaraiDokumenSm($id)
    {

        $senarai_dokumen = $this->findDokumenSm(1);
        $iklan = $this->findIklanbyID($id);
        return $this->render('form_upload_dokumen_sm', 
        [
            'senarai_dokumen' => $senarai_dokumen,
            'iklan' => $iklan,
                         
        ]);
    }
  public function actionSemakSyarat($ICNO) {
        $model = new TblNilaiSyarat();
        
        $bio = $this->findMaklumat($ICNO);
        $akad = $this->findAkademik();
        $akademik = Tblpendidikan::findOne(['ICNO' => Yii::$app->user->getId()]);
        $pengajian = TblPengajian::findOne(['icno' => Yii::$app->user->getId()]);
        $permohonan = TblPermohonan::findOne(['icno' => Yii::$app->user->getId()]);
        $query = TblSyarat::find()->orderBy(['id' => SORT_ASC]);
        
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        
        
        if($model->load((Yii::$app->request->post()))) {
         
            $arry = TblSyarat::find()->asArray()->all();
            $model->icno = $bio->ICNO;
            $model->gred_id = $bio->gredJawatan;
            $model->dept_id = $bio->DeptId;
            $model->statlantikan = $bio->statLantikan;
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
              
            $model->save(false);
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Semakan berjaya disimpan!']);
            return $this->redirect(['view-semakan-syarat', 'id' => $model->id]);
        }
        return $this->render('form_syarat', [
            'dataProvider' => $provider, 
            'model1' => $model,
            'bio'=> $bio,
            'akademik' => $akademik,
            'pengajian' => $pengajian,
            'permohonan' => $permohonan,
           
           
            ]);
    }
    
     public function actionSenaraiBorang($id)
    {
        $model = new TblPermohonan();
        $icno=Yii::$app->user->getId();
        $model->icno = $icno;
        $pengajian = TblPengajian::find()->where(['icno'=> $icno])->orderBy(['tarikh_mula' => SORT_DESC])->one();
        $senarai_dokumen = $this->findBorang(1);
        $senarai_dokumen3 = $this->findBorangAdmin();
        $senarai_dokumen1 = $this->findBorangLanjutan(1);
        $senarai_dokumen2 = $this->findLainBorang(1);
        $status = TblPermohonan::findAll(['icno' => $icno, 'status_proses'=> "Selesai Permohonan", 'idBorang'=> 1]); //senarai status permohonan
        $searchModel = new TblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $ver = TblPermohonan::findAll(['ver_by' => $icno]);
        $iklan = $this->findIklanbyID($id);
        $lanjut = $this->findIklanbyID($id);
        $pengajians = TblPengajian::find()->where(['icno'=> $icno,'status'=>1])->orderBy(['tarikh_mula' => SORT_DESC])->one();

        $mohon = TblPermohonan::find()->where(['icno'=>$icno,'status'=>["DALAM TINDAKAN BSM","DALAM TINDAKAN KETUA JABATAN"]])->one();
        $model2 = TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one()?TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one(): new TblPermohonan();
        $model3 = TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>[1,38,32]])->one()?TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>[1,38,32]])->one(): new TblPermohonan();
        $model4 = TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>[2,43,42,44,41,40,39,47,51]])->one()?TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>[2,43,42,44,41,40,39,47,51]])->one(): new TblPermohonan();
        $model5= TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>32])->one()?TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>32])->one(): new TblPermohonan();

//        $model5 = TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>38])->one()?TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>38])->one(): new TblPermohonan();

//        $option = Option::find()->where(["in", "name", ["date_open", "date_close"]])->all();

//        #convert object to array
//        $dateRange = ArrayHelper::map($option, 'name', 'value');
//
//        $today = date('Y-m-d', strtotime(date('Y-m-d')));
//        $start = date('Y-m-d', strtotime($dateRange['date_open']));
//        $end = date('Y-m-d', strtotime($dateRange['date_close']));
//
//        $open = "false";
//        #checking date between start and end
//        if (($today >= $start) && ($today <= $end)){
//            $open = "true";
//        }

//        $options = ["open" => $open, "date" => $dateRange];
        return $this->render('senarai_borang', 
        [
            'senarai_dokumen' => $senarai_dokumen,
            'senarai_dokumen1' => $senarai_dokumen1,
            'senarai_dokumen2' => $senarai_dokumen2,
            'senarai_dokumen3' => $senarai_dokumen3,
            'iklan' => $iklan,'status' => $status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ver' => $ver,
            'model' => $model,
//            'options' => $options,
            'model2' => $model2,
            'model3' => $model3,
            'model4'=>$model4, 'model5'=>$model5,
            'pengajian'=>$pengajian,
            'mohon'=>$mohon,
            'id'=>$id,
            'pengajians'=>$pengajians,
                         
        ]);
    }
    
//     public function actionVSenaraiBorang($id)
//    {
//        $model = new TblPermohonan();
//        $icno=Yii::$app->user->getId();
//        $senarai_dokumen = $this->findBorang(1);
//        $senarai_dokumen1 = $this->findBorangLanjutan(1);
//        $senarai_dokumen2 = $this->findLainBorang(1);
//        $status = TblPermohonan::findAll(['icno' => $icno, 'status_proses'=> "Selesai Permohonan", 'idBorang'=> 1]); //senarai status permohonan
//        $searchModel = new TblPermohonanSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $ver = TblPermohonan::findAll(['ver_by' => $icno]);
//        $iklan = $this->findIklanbyID($id);
//        $model2 = TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one()?TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>2])->one(): new TblPermohonan();
//        $model3 = TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>1])->one()?TblPermohonan::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>1])->one(): new TblPermohonan();
//
//       
//        
//        return $this->render('senarai_borang', 
//        [
//            'senarai_dokumen' => $senarai_dokumen,
//            'senarai_dokumen1' => $senarai_dokumen1,
//            'senarai_dokumen2' => $senarai_dokumen2,
//            'iklan' => $iklan,'status' => $status,
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//            'ver' => $ver,
//            'model' => $model,
//            'model2' => $model2,
//            'model3' => $model3,
//                         
//        ]);
//    }
    public function actionBorangLanjutan($id)
    {
        $model = new TblPermohonan();
        $icno=Yii::$app->user->getId();
        $senarai_dokumen = $this->findBorangLanjutan(1);
        $status = \app\models\cbelajar\TblLanjutan::findAll(['icno' => $icno, 'status_borang'=> "Selesai Permohonan", 'idBorang'=>3]); //senarai status permohonan
        $searchModel = new TblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $ver = TblPermohonan::findAll(['ver_by' => $icno]);
        $iklan = $this->findIklanbyID($id);
        return $this->render('senaraiborang1', 
        [
            'senarai_dokumen' => $senarai_dokumen,
            'iklan' => $iklan,'status' => $status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ver' => $ver,
            'model' => $model,
                         
        ]);
    }
    public function actionLainLainPermohonan($id)
    {
        $model = new TblPermohonan();
        $icno=Yii::$app->user->getId();
        $senarai_dokumen = $this->findLainBorang(1);
        $status = \app\models\cbelajar\TblLain::findAll(['icno' => $icno, 'status_borang'=> "Selesai Permohonan", 'idBorang'=>22]); //senarai status permohonan
        $searchModel = new TblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $ver = TblPermohonan::findAll(['ver_by' => $icno]);
        $iklan = $this->findIklanbyID($id);
        return $this->render('senaraiborang2', 
        [
            'senarai_dokumen' => $senarai_dokumen,
            'iklan' => $iklan,'status' => $status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ver' => $ver,
            'model' => $model,
                         
        ]);
    }
        public function actionRekodPermohonan() {
            
         
         $model = new TblPermohonan();
        $icno=Yii::$app->user->getId();
        $model->icno = $icno;
            
        $status = TblPermohonan::findAll(['icno' => $icno]); //senarai status permohonan
        $searchModel = new TblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $ver = TblPermohonan::findAll(['ver_by' => $icno]);
     
        // if($model->kakitangan->statLantikan== "1" && $model->confirmstatus->ConfirmStatusCd== "1" && $model->kakitangan->jawatan->job_category=="1")
        if(($model->kakitangan->statLantikan== "1"  && $model->kakitangan->jawatan->job_category=="1")|| ($model->kakitangan->statLantikan== "2"  && $model->kakitangan->jawatan->job_category=="1")) { //jika user staf lantikan tetap & staf akademik
        return $this->render('rekod_permohonan', 
             ['model' => $model, 'status' => $status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ver' => $ver,
            'bil' => 1,
                    
        ]);
        }
    }
      public function actionHasilSemakan($id){
         $model = $this->findNilaiSyarat($id); 

        $query = TblSyarat::find()->orderBy(['id' => SORT_ASC]);
        
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        
        return $this->render('_hasilsemakan', [
            'dataProvider' => $provider, 
            'model1' => $model, 

         ]);
    }
     public function actionGenerateSemakSyarat($id) {
        
        $bio = $this->findBiodata();
        $kriteriakpi = \app\models\cbelajar\RefPhd::find()->all();
        $mod = $this->findCekSyarat($id);
        $kontrak = $this->findModel($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'filename' => '_CUTIBELAJAR_'.$id,
            'mode' => Pdf::MODE_BLANK, // leaner size using standard fonts
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('/cbelajar/_cetakborang', [
              'kriteriakpi' => $kriteriakpi, 'mod'=> $mod,   
              'icno' => $kontrak->icno, 
              'id' => $kontrak->id,
              'edit'=> $edit,
              'view' => $view,
              'kontrak' => $kontrak,
              'biodata' => $biodata,
                ]),
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => [
             
            ],
           
        ]);
        return $pdf->render();
    }
  public function actionIndex()
    {

        $icno = Yii::$app->user->getId();

        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);


        $current_date = date('Y-m-d');

        $a = (Department::find()->where(['chief' => $icno, 'isActive' => '1']));
        $b = (\app\models\cbelajar\TblAccess::find()->where(['icno' => $icno, 'level' => 2]));
        //       $c = 
        if ($a ->exists()) {
            return $this->redirect('../cutisabatikal/senaraitindakan');
        }
        //        if(Department::find()->where( ['chief' => $icno, 'isActive' => '1'] )->exists() )||   (\app\models\cbelajar\TblAccess::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
        //{
        //        return $this->redirect('../cutisabatikal/senaraitindakan');} 
  elseif (\app\models\cbelajar\TblAccess::find()->where(['icno' => Yii::$app->user->getId(),'level'=>2])->exists()) {
            return $this->redirect(['/cbadmin/halaman-admin']);
        }
        
        elseif (($biodata->statLantikan == "1"  && $biodata->jawatan->job_category == "1") || ($biodata->statLantikan == "2"  && $biodata->jawatan->job_category == "1")
                || ($biodata->statLantikan == "1"  && $biodata->jawatan->job_category == "2") || ($biodata->statLantikan == "2"  && $biodata->jawatan->job_category == "2")) { //jika user staf lantikan tetap & belum disahkan & staf pentadbiran
            return $this->redirect('../cutibelajar/halaman-pemohon');
        }
         elseif (\app\models\cbelajar\TblAccess::find()->where(['icno' => Yii::$app->user->getId(),'level'=>99])->exists()) {
            return $this->redirect(['/cb-lkk/halaman-penyelia-ums']);
        }
        
//         elseif (\app\models\cbelajar\TblAccess::find()->where(['icno' => Yii::$app->user->getId(),'level'=>99])->exists()) {
//            return $this->redirect(['/cb-lkk/halaman-penyelia']);
//        }
      
        else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('index');
        }
        $model = new TblPermohonan();
    }
    public function actionIklanSemasa($id) {
        $iklan = $this->findModel($id);
        return $this->render('view_iklan_semasa', [
                    'iklan' => $iklan,
        ]);
    }
     protected function findNilaiSyarat($id)
    {
        if (($model = TblNilaiSyarat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
   //Page Maklumat Biasiswa 
    public function actionMaklumatBiasiswa($id)
    {   $request = Yii::$app->request;
        $sponsor = TblBiasiswa::find()->where(['icno' =>$this->ICNO(),'iklan_id' => $id, 'idBorang'=>1])->all();
        $icno = Yii::$app->user->getId();
        $iklan = $this->findIklanbyID($id);
        $model = new TblBiasiswa();
        $model->icno = $icno;
        if ($model->load(Yii::$app->request->post())) {
            $model->nama_tajaan = $request->post()['TblBiasiswa']['nama_tajaan'];
            $model->BantuanCd = $request->post()['TblBiasiswa']['BantuanCd'];
            $model->BantuanCd_ums = $request->post()['TblBiasiswa']['BantuanCd_ums'];
            $model->BantuanCd_ums = $request->post()['TblBiasiswa']['BantuanCd_ums'];
            $model->amaunBantuan= $request->post()['TblBiasiswa']['amaunBantuan'];
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['maklumat-biasiswa',  'id' => $model->id]);
        }
         $searchModel = new TblBiasiswaSearch();
            $query = TblBiasiswa::find()->where(['icno' => $icno]);
            $DataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        return $this->render('form_biasiswa', [
                    'model' => $model,
                    'iklan' => $iklan,
                    'sponsor'=> $sponsor,
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
                    
                   
                    
        ]);
    }
    
     public function actionMaklumatBiasiswaSeparuhMasa($id)
    {   $request = Yii::$app->request;
        $sponsor = TblBiasiswa::find()->where(['icno' =>$this->ICNO(),'iklan_id' => $id, 'idBorang'=>1])->all();
        $icno = Yii::$app->user->getId();
        $iklan = $this->findIklanbyID($id);
        $model = new TblBiasiswa();
        $model->icno = $icno;
        if ($model->load(Yii::$app->request->post())) {
            $model->nama_tajaan = $request->post()['TblBiasiswa']['nama_tajaan'];
            $model->BantuanCd = $request->post()['TblBiasiswa']['BantuanCd'];
            $model->BantuanCd_ums = $request->post()['TblBiasiswa']['BantuanCd_ums'];
            $model->BantuanCd_ums = $request->post()['TblBiasiswa']['BantuanCd_ums'];
            $model->amaunBantuan= $request->post()['TblBiasiswa']['amaunBantuan'];
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['maklumat-biasiswa',  'id' => $model->id]);
        }
         $searchModel = new TblBiasiswaSearch();
            $query = TblBiasiswa::find()->where(['icno' => $icno]);
            $DataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        return $this->render('/cutibelajar/separuhmasa/form_biasiswa', [
                    'model' => $model,
                    'iklan' => $iklan,
                    'sponsor'=> $sponsor,
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
                    
                   
                    
        ]);
    }

  

    // Cari Maklumat Pengajian
    protected function findMaklumatPermohonan() {
        return TblPengajian::findAll(['ICNO' => $this->ICNO()]);
    }
    
    // Semak Permohonan
    public function actionSemakanPermohonan()
    {
        return $this->render('semak_permohonan');
    }
    protected function findKeluargabyICNO() {
        if (($model = Tblkeluarga::findAll(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

     protected function findBorangbyICNO() {
        if (($model = TblDokumen::findAll(['id' => $this->id()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     
    protected function findAkademikbyICNO() {
        if (($model = Tblpendidikan::findAll(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findDokumenbyICNO() {
        if (($model = TblFilePemohon::findAll(['uploaded_by' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findDokumenKpmbyICNO() {
        if (($model = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findDokumenLnbyICNO() {
        if (($model = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findPengajianbyICNO() {
        if (($model = TblPengajian::findAll(['icno' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findPengajianTinggi() {
        return TblPengajian::findAll(['icno' => $this->ICNO()]);
    }

    protected function findSponsorship() {
        return TblBiasiswa::findAll(['icno' => $this->ICNO()]);
    }

    protected function findBiodata() {
        if (($model = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
     protected function findAkademik() {
        if (($model = Tblpendidikan::findOne(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findConfirm() {
        if (($model = TblPermohonan::findOne(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
     protected function findPermohonan($id) {

        $permohonan = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['icno' => $this->ICNO()])->andWhere(['dustBstatus' => $id]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $permohonan;
    }

    protected function findBiasiswabyICNO() {
        if (($model = TblBiasiswa::findAll(['icno' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findDokumenById($id) {
        if (($model = TblDokumen::findOne(['id' => $id])) !== null) {
            return $model;
            
        
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
//     protected function findDokumenKpmById($id) {
//        if (($model = \app\models\cbelajar\TblDokumenKpm::findOne(['id' => $id])) !== null) {
//            return $model;
//            
//        
//        }
//
//        throw new NotFoundHttpException('The requested page does not exist.');
//    }
     protected function findLainBorangbyId($id) {
        if (($model = \app\models\cbelajar\RefBorang::findOne(['id' => $id])) !== null) {
            return $model;
            
        
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findDokumenKpmById($id) {
        if (($model = \app\models\cbelajar\TblDokumenKpm::findOne(['id' => $id])) !== null) {
            return $model;
            
        
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findDokumenLnById($id) {
        if (($model = \app\models\cbelajar\TblDokumenLn::findOne(['id' => $id])) !== null) {
            return $model;
            
        
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findStaff() {
        if (($model = TblPermohonan::findOne(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
        public function actionMuatNaikDokumenSm($id,$iklan_id) {
       $icno = Yii::$app->user->getId();
        $dokumen = $this->findDokumenById($id);
       $model = new \app\models\cbelajar\TblFilePemohon();
       $iklan =  $this->findIklanbyID($iklan_id);
       if(\app\models\cbelajar\TblFilePemohon::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id'=> $iklan->id])->exists())
        {
                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
                         return $this->redirect(['senarai-dokumen-sm', 'id' => $iklan->id]);//
        }
       if ($model->load(Yii::$app->request->post())) 
       {
           
          
        $model->namafile = UploadedFile::getInstances($model, 'namafile');

      
            foreach ($model->namafile as $saving) {
                if ($saving) {
//                    $var_dump($saving);die;

                    $file = Yii::$app->FileManager->
                    UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');

                    $file_path = $file->file_name_hashcode; 
               }
               else
               {
                   $file_path = NULL;
               }

            }
                $simpan = new \app\models\cbelajar\TblFilePemohon();
                $simpan->uploaded_by = $icno;
//                $simpan->parent_id = $id;
                if ($model->namafile){
                $simpan->namafile = $file_path;
                }
//             $simpan->uploaded_by = $icno;
                $simpan->dokumenCd = $id;
                $simpan->idBorang = 38;
//                $simpan->namafile = $file_path;
                $simpan->nama_dokumen = $dokumen->nama_dokumen;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->iklan_id = $iklan->id;
                $simpan->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                   return $this->redirect(['senarai-dokumen-sm', 'id' => $iklan->id]);
            
           //}
          
            
        } else {
                        return $this->renderAjax('update-dokumen-sm', [
                        'model' => $model,
                            'iklan'=>$iklan
                       
            ]);
            
//            return $this->renderAjax('index', [
//                       
//            ]);
        }
    }
//    public function actionMuatNaikDokumen($id, $iklan_id) {
//       $icno = Yii::$app->user->getId();
//       $dokumen = $this->findDokumenKpmbyId($id);
//       $model = new \app\models\cbelajar\TblFileKpm();
//       $iklan =  $this->findIklanbyID($iklan_id);
//       if(\app\models\cbelajar\TblFileKpm::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id'=> $iklan->id])->exists())
//        {
//                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
//                         return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);//
//        }
//       if ($model->load(Yii::$app->request->post())) 
//       {
//           $model->namafile = UploadedFile::getInstances($model, 'namafile');
//          
//            foreach ($model->namafile as $saving) {
//                if ($saving) {
//                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');
//
//                    $file_path = $file->file_name_hashcode; 
//
//                }
//                $simpan = new \app\models\cbelajar\TblFileKpm();
//                $simpan->uploaded_by = $icno;
//                $simpan->dokumenCd = $id;
//                $simpan->idBorang = 1;
//                $simpan->namafile = $file_path;
//                $simpan->nama_dokumen = $dokumen->nama_dokumen;
//                $simpan->created_dt = new \yii\db\Expression('NOW()');
//                $simpan->tahun = date("Y");
//                $simpan->iklan_id = $iklan->id;
//                $simpan->save();
//                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
//                   return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);
//            
//            }
//          
//            
//        } else {
//                        return $this->render('upload-dokumen', [
//                        'model' => $model,
//                        'iklan' => $iklan,
//                       
//            ]);
//        }
//    }
    public function actionMuatNaikDokumen($id,$iklan_id) {
       $icno = Yii::$app->user->getId();
        $dokumen = $this->findDokumenKpmById($id);
       $model = new \app\models\cbelajar\TblFileKpm();
       $iklan =  $this->findIklanbyID($iklan_id);
       if(\app\models\cbelajar\TblFileKpm::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id'=> $iklan->id])->exists())
        {
                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
                         return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);//
        }
       if ($model->load(Yii::$app->request->post())) 
       {
           
          
        $model->namafile = UploadedFile::getInstances($model, 'namafile');

      
            foreach ($model->namafile as $saving) {
                if ($saving) {
//                    $var_dump($saving);die;

                    $file = Yii::$app->FileManager->
                    UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');

                    $file_path = $file->file_name_hashcode; 
               }
               else
               {
                   $file_path = NULL;
               }

            }
                $simpan = new \app\models\cbelajar\TblFileKpm();
                $simpan->uploaded_by = $icno;
//                $simpan->parent_id = $id;
                if ($model->namafile){
                $simpan->namafile = $file_path;
                }
//             $simpan->uploaded_by = $icno;
                $simpan->dokumenCd = $id;
                $simpan->idBorang = 1;
//                $simpan->namafile = $file_path;
                $simpan->nama_dokumen = $dokumen->nama_dokumen;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->iklan_id = $iklan->id;
                $simpan->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                   return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);
            
           //}
          
            
        } else {
                        return $this->renderAjax('update-dokumen-kpm', [
                        'model' => $model,
                            'iklan'=>$iklan
                       
            ]);
            
//            return $this->renderAjax('index', [
//                       
//            ]);
        }
    }
    public function actionLain($id, $iklan_id) {
       $icno = Yii::$app->user->getId();
       $dokumen = $this->findLainBorangbyId($id);
       $model = new \app\models\cbelajar\TblFilePemohon();
       $iklan =  $this->findIklanbyID($iklan_id);
       if(\app\models\cbelajar\TblFilePemohon::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id'=> $iklan->id])->exists())
        {
                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
                         return $this->redirect(['lain-lain-permohonan', 'id' => $iklan->id]);//
        }
       if ($model->load(Yii::$app->request->post())) 
       {
           $model->namafile = UploadedFile::getInstances($model, 'namafile');
          
            foreach ($model->namafile as $saving) {
                if ($saving) {
                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');

                    $file_path = $file->file_name_hashcode; 

                }
                $simpan = new \app\models\cbelajar\TblFilePemohon();
                $simpan->uploaded_by = $icno;
                $simpan->dokumenCd = $id;
                $simpan->idBorang = 4;
                $simpan->namafile = $file_path;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->iklan_id = $iklan->id;
                $simpan->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                   return $this->redirect(['cbelajar/lain-lain-permohonan', 'id' => $iklan->id]);
            
            }
          
            
        } else {
                        return $this->render('/cutisabatikal/upload-lain', [
                        'model' => $model,
                        'iklan' => $iklan,
                       
            ]);
        }
    }
//    public function actionMuatNaikDokumenCb($id, $iklan_id) {
//       $icno = Yii::$app->user->getId();
//       $dokumen = $this->findDokumenbyId($id);
//       $model = new TblFilePemohon();
//       $iklan =  $this->findIklanbyID($iklan_id);
//       if(\app\models\cbelajar\TblFilePemohon::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id'=> $iklan->id])->exists())
//        {
//                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
//                         return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);//
//        }
//       if ($model->load(Yii::$app->request->post())) 
//       {
//           $model->namafile= UploadedFile::getInstances($model, 'namafile');
//          
//            foreach ($model->namafile as $saving) {
//                if ($saving) {
//                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');
//
//                    $file_path = $file->file_name_hashcode; 
//
//                }
//                $simpan = new TblFilePemohon();
//                $simpan->uploaded_by = $icno;
//                $simpan->dokumenCd = $id;
//                $simpan->namafile = $file_path;
//                $simpan->created_dt = new \yii\db\Expression('NOW()');
//                $simpan->tahun = date("Y");
//                $simpan->iklan_id = $iklan->id;
//                $simpan->nama_dokumen = $dokumen->nama_dokumen;
//                $simpan->idBorang = 1;  
//                $simpan->save(false);
//                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
//                   return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);
//            
//            }
//          
//            
//        } else {
//                        return $this->render('upload-dokumen-cb', [
//                        'model' => $model,
//                        'iklan' => $iklan,
//                       
//            ]);
//        }
//    }
     public function actionMuatNaikDokumenCb($id,$iklan_id) {
       $icno = Yii::$app->user->getId();
        $dokumen = $this->findDokumenById($id);
       $model = new \app\models\cbelajar\TblFilePemohon();
       $iklan =  $this->findIklanbyID($iklan_id);
       if(\app\models\cbelajar\TblFilePemohon::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id'=> $iklan->id])->exists())
        {
                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
                         return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);//
        }
       if ($model->load(Yii::$app->request->post())) 
       {
           
          
        $model->namafile = UploadedFile::getInstances($model, 'namafile');

      
            foreach ($model->namafile as $saving) {
                if ($saving) {
//                    $var_dump($saving);die;

                    $file = Yii::$app->FileManager->
                    UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');

                    $file_path = $file->file_name_hashcode; 
               }
               else
               {
                   $file_path = NULL;
               }

            }
                $simpan = new \app\models\cbelajar\TblFilePemohon();
                $simpan->uploaded_by = $icno;
//                $simpan->parent_id = $id;
                if ($model->namafile){
                $simpan->namafile = $file_path;
                }
                $simpan->dokumenCd = $id;
                $simpan->idBorang = 1;
//                $simpan->namafile = $file_path;
                $simpan->nama_dokumen = $dokumen->nama_dokumen;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->iklan_id = $iklan->id;
                $simpan->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                   return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);
            
           //}
          
            
        } else {
                        return $this->renderAjax('update-dokumen-wajib', [
                        'model' => $model,
                            'iklan'=>$iklan
                       
            ]);
            
//            return $this->renderAjax('index', [
//                       
//            ]);
        }
    }
    public function actionMuatNaikDokumenLn($id,$iklan_id) {
       $icno = Yii::$app->user->getId();
        $dokumen = $this->findDokumenLnById($id);
       $model = new \app\models\cbelajar\TblFileLn();
       $iklan =  $this->findIklanbyID($iklan_id);
       if(\app\models\cbelajar\TblFileLn::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id, 'iklan_id'=> $iklan->id])->exists())
        {
                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
                         return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);//
        }
       if ($model->load(Yii::$app->request->post())) 
       {
           
          
        $model->namafile = UploadedFile::getInstances($model, 'namafile');

      
            foreach ($model->namafile as $saving) {
                if ($saving) {
//                    $var_dump($saving);die;

                    $file = Yii::$app->FileManager->
                    UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');

                    $file_path = $file->file_name_hashcode; 
               }
               else
               {
                   $file_path = NULL;
               }

            }
                $simpan = new \app\models\cbelajar\TblFileLn();
                $simpan->uploaded_by = $icno;
//                $simpan->parent_id = $id;
                if ($model->namafile){
                $simpan->namafile = $file_path;
                }
                $simpan->dokumenCd = $id;
                $simpan->idBorang = 1;
//                $simpan->namafile = $file_path;
                $simpan->nama_dokumen = $dokumen->nama_dokumen;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->iklan_id = $iklan->id;
                $simpan->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                   return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);
            
           //}
          
            
        } else {
                        return $this->renderAjax('update-dokumen-ln', [
                        'model' => $model,
                            'iklan'=>$iklan
                       
            ]);
            
//            return $this->renderAjax('index', [
//                       
//            ]);
        }
    }
//    public function actionMuatNaikDokumenLn($id, $iklan_id) {
//       $icno = Yii::$app->user->getId();
//       $dokumen = $this->findDokumenLnbyId($id);
//       $model = new \app\models\cbelajar\TblFileKpm();
//       $iklan =  $this->findIklanbyID($iklan_id);
//       if(\app\models\cbelajar\TblFileLn::find()->where([ 'uploaded_by' => $icno, 'dokumenCd' => $dokumen->id])->exists())
//        {
//                Yii::$app->session->setFlash('alert', ['title' => 'Anda Telah memuatnaik Dokumen Tersebut!', 'type' => 'error', 'msg' => 'Pengesahan dokumen hanya perlu dimuatnaik sekali sahaja.']);
//                         return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);//
//        }
//       if ($model->load(Yii::$app->request->post())) 
//       {
//           $model->namafile = UploadedFile::getInstances($model, 'namafile');
//          
//            foreach ($model->namafile as $saving) {
//                if ($saving) {
//                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '04', 'cutibelajar');
//
//                    $file_path = $file->file_name_hashcode; 
//
//                }
//                $simpan = new \app\models\cbelajar\TblFileLn();
//                $simpan->uploaded_by = $icno;
//                $simpan->dokumenCd = $id;                
//                $simpan->nama_dokumen = $dokumen->nama_dokumen;
//                $simpan->namafile = $file_path;
//                $simpan->created_dt = new \yii\db\Expression('NOW()');
//                $simpan->tahun = date("Y");
//                $simpan->iklan_id = $iklan->id;
//                $simpan->idBorang = 1;
//                $simpan->save(false);
//                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
//                   return $this->redirect(['senarai-dokumen', 'id' => $iklan->id]);
//            
//            }
//          
//            
//        } else {
//                        return $this->render('upload-dokumenln', [
//                        'model' => $model,
//                        'iklan' => $iklan,
//                       
//            ]);
//        }
//    }
    protected function findPemohon($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }
    // BSM - Lihat Senarai Pemohon Cuti Belajar
    public function actionSenaraiPemohon($id) {

        $icno = Yii::$app->user->getId();
        $searchStaff = new TblPermohonanSearch();
        $searchStaff->iklan_id = $id;
        $staff = $searchStaff->search(Yii::$app->request->post());

       
        return $this->render('view_senarai_pemohon', [
                    'staff' => $staff,
                   
        ]);
    }
    // BSM - Lihat Lampiran
      public function actionAttachment($ICNO) {

        $biodata = $this->findFilePemohon($ICNO);
        return $this->render('view_lampiran', [
                    'biodata' => $biodata,
                    'fail' => $biodata->dokumen,
                    
        ]);
    }

    public function actionSenarai()
    {
        $icno = Yii::$app->user->getId();
       
        $model = new TblPermohonan();
        $searchModel = new TblPermohonanSearch();
        $model->tarikh_m= date('Y-m-d H:i:s');

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $status = ['LULUS', 'DALAM TINDAKAN BSM', 'DALAM TINDAKAN KETUA JABATAN'];
         
        
            $query1 = (new \yii\db\Query())
                ->select("idBorang, tarikh_m, icno, status, status_jfpiu, status_bsm,id,terima1")
                ->from('hrd.cb_tbl_permohonan')
                ->where(['icno' => $icno])
                ->andWhere(['status'=> $status]) ;
 
            $query2 = (new \yii\db\Query())
                ->select("idBorang, tarikh_mohon , icno,  status, status_jfpiu, status_bsm , id,terima1")
                ->from('hrd.cb_tbl_lanjutan')
                ->where(['icno' => $icno])
                ->andWhere(['status'=> $status]) ;
            
            
            
            
            $query1->union($query2, false);//false is UNION, true is UNION ALL
//            $query1->union($query3, false);//false is UNION, true is UNION ALL
//            $query1->union($query4, false);//false is UNION, true is UNION ALL
//            $query1->union($query5, false);//false is UNION, true is UNION ALL
//            $query1->union($query6, false);//false is UNION, true is UNION ALL
//            $query1->union($query7, false);//false is UNION, true is UNION ALL
//            $query1->union($query8, false);//false is UNION, true is UNION ALL

            $sql = $query1->createCommand()->getRawSql();
            $sql .= ' ORDER BY tarikh_m DESC';
            $query = TblPermohonan::findBySql($sql);
			
			
            $dataProvider = new ActiveDataProvider([
                'query' => $query,              
            ]);
 
         return $this->render('senarai', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
 
            'bil' => 1,
        ]);
    } 

    protected function findFilePemohon($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }
     //Senarai Dokumen Yang Dimuatnaik
    public function actionUploadedlist() 
    {
       $icno = Yii::$app->user->getId();
        $files = TblFilePemohon::findAll(['uploaded_by' => $icno]);
        return $this->render('uploadedlist', [
                    'files' => $files,
                    'dokumen' => $this->findDokumen(0),
        ]);
    }
    // Padam Dokumen Yang Telah Dimuatnaik
    public function actionDeletes($id) {
        
        $foto = TblFilePemohon::findOne($id)->delete();

        return $this->redirect(['uploadedlist']);
    }
    
    public function actionMaklumatPemohon($id, $ICNO, $takwim_id)
    {
        $biodata = $this->findMaklumat($ICNO);
        $pengajian = TblPengajian::findAll(['icno'=> $ICNO, 'iklan_id' => $takwim_id]);
        $biasiswa = TblBiasiswa::findAll(['icno'=> $ICNO,'iklan_id'  => $takwim_id]);
        $dokumen = TblFilePemohon::findAll(['uploaded_by'=> $ICNO, 'iklan_id'  => $takwim_id]);
        $dokumen2 = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' =>$ICNO,'iklan_id' => $takwim_id]);
        $dokumen3 = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' =>$ICNO,'iklan_id' => $takwim_id]);
        $model = $this->findKemudahan($id);
        $statuss = $this->findPerkhidmatanbyICNO();
       
         if($model->status_bsm== 'Diluluskan' || $model->status_jfpiu == 'Tidak Diluluskan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}
            
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
        return $this->render('maklumat_kakitangan', 
            [ 
              'model' => $model,
              'biodata' => $biodata,
              'pengajian' => $pengajian,
              'keluarga' => $biodata->keluarga,
              'biasiswa' => $biasiswa,
              'akademik' => $biodata->akademik,
              'dokumen' => $dokumen,
              'dokumen2' => $dokumen2,
              'dokumen3' => $dokumen3,
              'statuss' => $statuss, 
              'img' => $biodata->img,
               'edit' => $edit,
              'view' => $view
            ]);
    
    }
}

  public function actionGeneratePermohonanCutiBelajarPemohon($id) {
        $model = new TblPermohonan();
        $icno=Yii::$app->user->getId();
        $model->icno = $icno;
        $biodata = $this->findBiodata();
        $pengajian = TblPengajian::findAll(['icno'=>$icno, 'idPermohonan' => $id, 'idBorang'=>1]);
        $biasiswa = TblBiasiswa::find()->where(['icno'=>$icno,'idPermohonan' => $id, 'idBorang'=>1])->all();
//        $pengajian = TblPengajian::find()->where(['icno'=>$icno, 'iklan_id' => $id, 'idBorang'=>1])->all();
//        $biasiswa = TblBiasiswa::findAll(['icno'=>$icno,'iklan_id' => $id, 'idBorang'=>1]);
//        $dokumen = TblFilePemohon::findAll(['uploaded_by'=>$icno,'iklan_id' => $id]);
        $model2 = TblPermohonan::findOne(['icno' => $icno, 'iklan_id'=>$id, 'idBorang'=>1]); //senarai status permohonan
        $dokumen = TblFilePemohon::find()->where(['uploaded_by' =>$icno,'idPermohonan' => $id, 'idBorang'=>1])->all();
        $dokumen2 = \app\models\cbelajar\TblFileKpm::find()->where(['uploaded_by' =>$icno, 'idBorang'=>1])->all();
        $dokumen3 = \app\models\cbelajar\TblFileLn::find()->where(['uploaded_by' =>$icno, 'idBorang'=>1])->all();
//        $iklan = $this->findIklanbyID($id);

        if(($model->kakitangan->statLantikan== "1" && $model->kakitangan->jawatan->job_category=="1")|| ($model->kakitangan->statLantikan== "2" && $model->kakitangan->jawatan->job_category=="1")) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'filename' => '_CUTIBELAJAR_'.$id,
            'mode' => Pdf::MODE_BLANK, // leaner size using standard fonts
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('/cutibelajar/_cetakborangpemohon', [
//            'iklan' => $iklan,
            'model' => $model,
            'img' => $biodata->img,
            'biodata' => $biodata,
            'akademik' => $biodata->akademik,
            'keluarga' => $biodata->keluarga,
            'biasiswa' => $biasiswa,
            'dokumen' => $dokumen,
            'dokumen2' => $dokumen2,
            'dokumen3' => $dokumen3,
            'pengajian'=> $pengajian,
            'model2' => $model2,
            
                ]),
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => [
             
            ],
           
        ]);
        }
        return $pdf->render();
    }

   protected function findMaklumat($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }

     protected function findBiasiswa($ICNO) {
        return TblBiasiswa::findOne(['icno' => $ICNO]);
    }
     protected function findMaklumatPengajian($ICNO) {
        return TblPengajian::findOne(['icno' => $ICNO]);
    }
     //Maklumat Peribadi
    public function actionMaklumatPeribadi($id)
    {
        $icno = Yii::$app->user->getId();
        $biodata = $this->findBiodata();
        $status = $this->findPerkhidmatanbyICNO();
        $model2 = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt'); 
        //ambil tarikh status pengesahan yang latest
        
        
        $confirm = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno, 'ConfirmStatusStDt' => $model2])->one()->ConfirmStatusStDt;
        $model = new TblPermohonan();
        $model->icno = $icno;
        $iklan = $this->findIklanbyID($id);
       
        return $this->render('form_peribadi', 
            [ 
              
              'biodata' => $biodata,
              'status' => $status,
              'iklan' => $iklan,
                'model2'=>$model2,
                'confirm' => $confirm,
            ]);
    
    }
    
    public function actionMaklumatPeribadiSeparuhMasa($id)
    {
        $icno = Yii::$app->user->getId();
        $biodata = $this->findBiodata();
        $status = $this->findPerkhidmatanbyICNO();
        $model2 = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt'); 
        //ambil tarikh status pengesahan yang latest
        $confirm = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno, 'ConfirmStatusStDt' => $model2])->one()->ConfirmStatusStDt;
        $model = new TblPermohonan();
        $model->icno = $icno;
        $iklan = $this->findIklanbyID($id);
       
        return $this->render('/cutibelajar/separuhmasa/form_peribadi', 
            [ 
              
              'biodata' => $biodata,
              'status' => $status,
              'iklan' => $iklan,
                'model2'=>$model2,
                'confirm' => $confirm,
            ]);
    
    }

 protected function findPerkhidmatanbyICNO() {
        if (($model = Tblrscoconfirmstatus::findAll(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
            
            
        }
    }
    public function actionMaklumatAkademik($id)
    {
        $icno = Yii::$app->user->getId();
        $model = new TblPermohonan();
        $model->icno = $icno;
        $iklan = $this->findIklanbyID($id);
        $sabatikal2= $this->findSabatikal();
        return $this->render('form_akademik', 
        [ 
              'akademik' => $this->findAkademikbyICNO(),
               'iklan' => $iklan,
                'sabatikal2' => $sabatikal2,
        ]);
    
    }
    public function actionMaklumatAkademikSeparuhMasa($id)
    {
        $icno = Yii::$app->user->getId();
        $model = new TblPermohonan();
        $model->icno = $icno;
        $iklan = $this->findIklanbyID($id);
        $sabatikal2= $this->findSabatikal();
        return $this->render('/cutibelajar/separuhmasa/form_akademik', 
        [ 
              'akademik' => $this->findAkademikbyICNO(),
               'iklan' => $iklan,
                'sabatikal2' => $sabatikal2,
        ]);
    
    }
    public function actionUploadDokumen()
    {
      
        $model = $this->findDokumen(1);
        $model2 = $this->findDokumenKpm(1);
        $model3 = $this->findDokumenLn(1);
        return $this->render('upload_dokumen', 
        [
            'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
        
            'dokumen' => $this->findDokumenbyICNO(), 
            'dokumen2' => $this->findDokumenKpmbyICNO(),
            'dokumen3' => $this->findDokumenlNbyICNO(),
        ]);
    
    }
    public function actionSenaraiDokumenDimuatnaik($id)
    {
        //$model = new TblFilePemohon();
        $icno = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblFileKpm();
        $iklan = $this->findIklanbyID($id);
        $model->uploaded_by = $icno;
        $dokumen = \app\models\cbelajar\TblFileKpm::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id]);
        $dokumen2 = \app\models\cbelajar\TblFilePemohon::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id,'kategori'=>1]);
        $dokumen3 = \app\models\cbelajar\TblFileLn::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id]);

//        $files = TblFilePemohon::findAll(['uploaded_by' => $icno]);
        return $this->render('form_dokumen', 
            [ 
      
             'dokumen' => $this->findDokumenKpmbyICNO(),
             'dokumen2' => $this->findDokumenbyICNO(),
             'dokumen3' => $this->findDokumenLnbyICNO(),
             'iklan' => $iklan,
             'dokumen' => $dokumen,
             'dokumen2' => $dokumen2,
             'dokumen3' => $dokumen3,
            ]);
        
    }
    //senarai dokumen separuh masa
    public function actionSenaraiDokumenSeparuhMasa($id)
    {
        //$model = new TblFilePemohon();
        $icno = Yii::$app->user->getId();
        $model = new \app\models\cbelajar\TblFileKpm();
        $iklan = $this->findIklanbyID($id);
        $model->uploaded_by = $icno;
        $dokumen2 = \app\models\cbelajar\TblFilePemohon::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id]);

//        $files = TblFilePemohon::findAll(['uploaded_by' => $icno]);
        return $this->render('form_dokumen_sp', 
            [ 
      
             'dokumen2' => $this->findDokumenbyICNO(),
             'iklan' => $iklan,
             'dokumen2' => $dokumen2,
            ]);
        
    }
    //Maklumat Keluarga
    public function actionMaklumatKeluarga($id)
    {
        $icno = Yii::$app->user->getId();
        $iklan = $this->findIklanbyID($id);
        $model = new TblPermohonan();
        $model->icno = $icno;
        return $this->render('form_keluarga', 
            [ 
              'keluarga' => $this->findKeluargabyICNO(),
              'iklan' =>$iklan,
            ]);
    
    }
     public function actionMaklumatKeluargaSeparuhMasa($id)
    {
        $icno = Yii::$app->user->getId();
        $iklan = $this->findIklanbyID($id);
        $model = new TblPermohonan();
        $model->icno = $icno;
        return $this->render('/cutibelajar/separuhmasa/form_keluarga', 
            [ 
              'keluarga' => $this->findKeluargabyICNO(),
              'iklan' =>$iklan,
            ]);
    
    }
    
     public function actionPengakuanMaklumat($id)
    {
        $icno = Yii::$app->user->getId();
        $iklan = $this->findIklanbyID($id);
        $model = new TblPermohonan();
        $model->icno = $icno;
        if ($model->load(Yii::$app->request->post()))
        {  
            if($model->agree == 0)
            {
                Yii::$app->session->setFlash('alert', ['title' => 'Amaran !', 'type' => 'error', 'msg' => 'Sila tanda kotak semak permohonan.']);
                return $this->redirect(['pengakuan-maklumat', 'id' => $iklan->id]);
            }
            else
            {
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Maklumat Berjaya Diterima', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                    return $this->redirect(['cbelajar/pengakuan-maklumat', 'id' => $iklan->id]);
            }
        }
        if($model->agree == 1){
            $edit = 'none'; $view= '';}
        else{
            
            $view = 'none'; $edit = '';}
            
        return $this->render('pengakuan_simpanan',
               [  'model' => $model,
                   'edit'=> $edit,
                   'view' => $view,
                   'iklan' => $iklan,
                ]
            );
    
    }
    public function actionPengakuanPemohon($id)
    {
           
        $icno = Yii::$app->user->getId();
        $biodata = $this->findBiodata();
        $iklan = $this->findIklanbyID($id);
        $status = $this->findPerkhidmatanbyICNO();
        $model = new TblPermohonan();
        $model->icno = $icno;

         $model->statusLabel = 'MENUNGGU TINDAKAN';
         
         $model->status_kj = 'NEW';

        if ($model->load(Yii::$app->request->post()))
        {  

            if($model->agree == 0)
            {

                Yii::$app->session->setFlash('alert', ['title' => 'Amaran !', 'type' => 'error', 'msg' => 'Sila tanda kotak semak permohonan.']);
                return $this->redirect(['pengakuan-pemohon', 'id' => $id]);

            }
            else
            {
                $model->jenis_user_id = 1;
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Diterima', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                    return $this->redirect(['permohonan-semasa']);
            }
        }

        return $this->render('form_pengakuan', 
            [ 
              'iklan' => $iklan,
              'model' => $model,
              'biodata' => $biodata,
              'status' =>$this->findPerkhidmatanbyICNO(),
              'keluarga' => $this->findKeluargabyICNO(),
              'akademik' => $this->findAkademikbyICNO(),
              'pengajian' => $this->findPengajianbyICNO(),
              'biasiswa' => $this->findBiasiswabyICNO(),
            ]);
    
    }
    public function actionSemakMaklumat()
    {
        $icno = Yii::$app->user->getId();
        $biodata = $this->findBiodata();
        $status = $this->findPerkhidmatanbyICNO();
        $model = new TblPermohonan();
        $model->icno = $icno;
    	if ($model->load(Yii::$app->request->post()))
        {  
            if($model->agree == 0)
            {
                Yii::$app->session->setFlash('alert', ['title' => 'Amaran !', 'type' => 'error', 'msg' => 'Sila tanda kotak semak permohonan.']);
                return $this->redirect(['semak-maklumat']);
            }
            else
            {
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Permohonan Berjaya Disimpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                    return $this->redirect(['permohonan-semasa']);
            }
        }

        return $this->render('semak-maklumat', 
            [ 
              'model' => $model,
              'biodata' => $biodata,
              'status' => $status,
              'keluarga' => $this->findKeluargabyICNO(),
              'akademik' => $this->findAkademikbyICNO(),
              'pengajian' => $this->findPengajianbyICNO(),
              'biasiswa' => $this->findBiasiswabyICNO(),

            
            ]);
    
    }
    protected function findJumlahPermohonanTahunan() {
        return TblPermohonan::find()->count();
    }
    protected function findJumlahPermohonanSemasa() {
        return TblPermohonan::find()->where(['status_proses' => 'Selesai Permohonan'])->count();
    }
    protected function findJumlahPermohonanBerjaya() {

        return TblPermohonan::find()->where(['status' => 'LULUS'])->count();
       
    }
    protected function findJumlahPermohonanDitolak() {

        return TblPermohonan::find()->where(['status' => 'TIDAK LULUS'])->count();
    }
   
    protected function findPermohonanbyID($id) {
        if (($model = TblPermohonan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findIklanbyID($id) {
        if (($model = TblUrusMesyuarat::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
   // View Iklan
   public function findIklan($status) 
   {
        $senarai_iklan = new ActiveDataProvider
        ([
            'query' => TblUrusMesyuarat::find()->where(['status' => $status]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $senarai_iklan;
    }

 public function findBorang($status) 
    {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => $status, 'borang'=>1])->orderBy(['level'=>SORT_ASC]),

            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }
    public function findBorangAdmin() 
    {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => [1,3], 'level'=>9]),

            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }
    public function findBorangLanjutan($status) 
    {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => $status, 'borang'=>2]),

            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }
    public function findLainBorang($status) 
    {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => $status, 'borang'=>4]),

            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }
    // View Senarai Dokumen
    public function findDokumen($status) 
    {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => TblDokumen::find()->where(['status' => $status, 'kategori'=>1]),

            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }
     public function findDokumenSm($status) 
    {
        $senarai_dokumen = new ActiveDataProvider([
            'query' => TblDokumen::find()->where(['status' => $status, 'kategori'=>4]),

            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumen;
    }
    
    public function findDokumenKpm($status) 
    {
        $senarai_dokumenkpm = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblDokumenKpm::find()->where(['status' => $status, 'kategori'=>1]),

            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumenkpm;
    }
    public function findDokumenLn ($status) 
    {
        $senarai_dokumenln = new ActiveDataProvider([
            'query' => \app\models\cbelajar\TblDokumenLn::find()->where(['status' => $status]),

            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_dokumenln;
    }
    public function findSyarat($status) 
    {
        $senarai_syarat = new ActiveDataProvider([
            'query' => TblSyarat::find()->where(['status' => $status]),

            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $senarai_syarat;
    }
    public function actionTambahIklan() 
    {

       $iklan = new TblUrusMesyuarat();
       $urusMesyuarat = TblUrusMesyuarat::find()->All(); //cari semua mesyuarat
               $senarai_iklan = $this->findIklan(0);

        if ($iklan->load(Yii::$app->request->post())) 
        {

            $iklan->tarikh_buka; 
            $iklan->tarikh_tutup; 
            $iklan->tarikh_mesyuarat;
            $iklan->status = 0;
            $iklan->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['tambah-iklan']);
        }
        


      if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
        return $this->render('form_tambah_takwim', [
                    'iklan' => $iklan,
                    'urusMesyuarat' => $urusMesyuarat,
                'senarai_iklan' => $senarai_iklan,
        ]);
    }
    else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->render('/cbadmin/halaman-admin');}
    }
    
    public function actionDeleteUrusMesyuarat($id)
    {
        $admin = TblUrusMesyuarat::findOne(['id' => $id]);
        $admin->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['tambah-iklan']);
        
    }
    
    
     protected function findImg() {
        return TblpImage::findOne(['ICNO' => $this->ICNO()]);
    }
    
    public function actionUploadgambar($id) {
        
        $check = TblpImage::findOne(['ICNO' =>$this->ICNO(),'iklan_id' => $id]);
        $iklan = $this->findIklanbyID($id);
        if ($check) {
            $model = $check;
        } else {
            $model = new TblpImage();
        }
           if ($model->load(Yii::$app->request->post())) 
       {
           $model->filename= UploadedFile::getInstances($model, 'filename');
          
            foreach ($model->filename as $saving) {
                if ($saving) {
                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '01', 'cutibelajar');

                    $file_path = $file->file_name_hashcode; 

                }
                $simpan = $model->uploadImage();
                $simpan->ICNO = $this->ICNO();
                $simpan->tahun = date("Y");
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->filename = $file_path;
                $simpan->iklan_id = $iklan->id;
                $simpan->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                   return $this->redirect(['senarai-dokumen-dimuatnaik', 'id' => $iklan->id]);
            
            }
          
            
        } else {
                     return $this->render('form_gambar', [
                    'model' => $model,
                    'iklan' => $iklan,
                   
        ]);
                       
        
        }
        
       
    }
    
    public function actionGambar($id) {
        
        $check = TblpImage::findOne(['ICNO' =>$this->ICNO(),'iklan_id' => $id]);
        $iklan = $this->findIklanbyID($id);
        if ($check) {
            $model = $check;
        } else {
            $model = new TblpImage();
        }
        
        if ($model->load(Yii::$app->request->post())) {
            echo "c";
            echo "br";
//            var_dump($model);
            echo "br";
            $image = $model->uploadImage();
            $model->ICNO = $this->ICNO();
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            
            /*************************************************************************/
            
            $model->filename= UploadedFile::getInstances($model, 'image');
          
            foreach ($model->filename as $saving) {
                echo "b";
                if ($saving) {
                    echo "a";
                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '01', 'cutibelajar');

                    $file_path = $file->file_name_hashcode; 

                }
                $simpan = new TblpImage();
                //$simpan->uploaded_by = $icno;
                //$simpan->dokumenCd = $id;
                //$simpan->namafile = $file_path;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->iklan_id = $iklan->id;
                $simpan->ICNO = $this->ICNO();
                $simpan->filename = $file_path;
                $simpan->save();
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                   return $this->redirect(['gambar', 'id'=> $iklan->id]);
            
            }
            
            
            
//            /****************************************************************************/
//            if ($model->save()) {
//                if ($image !== false) {
//                    $path = $model->getImageFile();
//                    $image->saveAs($path);
////                }
//                Yii::$app->session->setFlash('alert', ['title' => 'Gambar Berjaya Di Simpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
//                return $this->redirect(['gambar', 'id'=> $iklan->id]);
//            } else {
//                // error in saving model
//            }
        }
// #getting data from table option
//        $option = Option::find()->where(["in", "name", ["date_open", "date_close"]])->all();
//
//        #convert object to array
//        $dateRange = ArrayHelper::map($option, 'name', 'value');
//
//        $today = date('Y-m-d', strtotime(date('Y-m-d')));
//        $start = date('Y-m-d', strtotime($dateRange['date_open']));
//        $end = date('Y-m-d', strtotime($dateRange['date_close']));
//
//        $open = "false";
//        #checking date between start and end
//        if (($today >= $start) && ($today <= $end)){
//            $open = "true";
//        }
//
//        $options = ["open" => $open, "date" => $dateRange];
        return $this->render('form_gambar', [
                    'model' => $model,
                    'iklan' => $iklan,
//                    'options' => $options
                   
        ]);
       
    }
    public function actionGambarSeparuhMasa($id) {
        
        $check = TblpImage::findOne(['ICNO' =>$this->ICNO(),'iklan_id' => $id]);
        $iklan = $this->findIklanbyID($id);
        if ($check) {
            $model = $check;
        } else {
            $model = new TblpImage();
        }
        
        if ($model->load(Yii::$app->request->post())) {
            echo "c";
            echo "br";
//            var_dump($model);
            echo "br";
            $image = $model->uploadImage();
            $model->ICNO = $this->ICNO();
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
            
            /*************************************************************************/
            
            $model->filename= UploadedFile::getInstances($model, 'image');
          
            foreach ($model->filename as $saving) {
                echo "b";
                if ($saving) {
                    echo "a";
                    $file = Yii::$app->FileManager->UploadFile($saving->name, $saving->tempName, '01', 'cutibelajar');

                    $file_path = $file->file_name_hashcode; 

                }
                $simpan = new TblpImage();
                //$simpan->uploaded_by = $icno;
                //$simpan->dokumenCd = $id;
                //$simpan->namafile = $file_path;
                $simpan->created_dt = new \yii\db\Expression('NOW()');
                $simpan->tahun = date("Y");
                $simpan->iklan_id = $iklan->id;
                $simpan->ICNO = $this->ICNO();
                $simpan->filename = $file_path;
                $simpan->save();
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
                   return $this->redirect(['gambar-separuh-masa', 'id'=> $iklan->id]);
            
            }
            
            
            
//            /****************************************************************************/
//            if ($model->save()) {
//                if ($image !== false) {
//                    $path = $model->getImageFile();
//                    $image->saveAs($path);
////                }
//                Yii::$app->session->setFlash('alert', ['title' => 'Gambar Berjaya Di Simpan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
//                return $this->redirect(['gambar', 'id'=> $iklan->id]);
//            } else {
//                // error in saving model
//            }
        }

        return $this->render('/cutibelajar/separuhmasa/form_gambar', [
                    'model' => $model,
                    'iklan' => $iklan,
//                    'options' => $options
                   
        ]);
       
    }

public function actionTajaanluar($id) {
      
        $modelsAddress = [new TblBiasiswa()]; 
        $model = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
         $iklan = $this->findIklanByID($id);
        if ((Yii::$app->request->post())) {
                
            $modelsAddress = \app\models\cbelajar\Model::createMultiple(TblBiasiswa::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            
//            // ajax validation
          if (Yii::$app->request->isAjax) {
               Yii::$app->response->format = Response::FORMAT_JSON;
               return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                  ActiveForm::validate($modelCustomer)
                       
                );
            }
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                  
                        foreach ($modelsAddress as $i=> $modelAddress) {
//                                $modelAddress->icno = $modelCustomer->icno;
                                $modelAddress->icno =  Yii::$app->user->getId();
                                $modelAddress->jenisCd = 1;
                                $modelAddress->nama_tajaan;
                                $modelAddress->BantuanCd;
                                $modelAddress->idBorang=1;
                                $modelAddress->iklan_id = $iklan->id;
                                $modelAddress->created_dt = new \yii\db\Expression('NOW()');
                                $modelAddress->tahun = date("Y");
//                              $modelAddress->parent_id = $modelCustomer->id;
//                              $modelAddress->idBorang = 1;
                            if (! ($flag = $modelAddress->save())) {
                                $transaction->rollBack();
                                break;
                                
                            }
                        
                    }
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan.']);
                    if ($flag) {
                        $transaction->commit();

                        return $this->redirect(['cbelajar/maklumat-biasiswa', 'id' => $iklan->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            
            
        }
        
        return $this->render('_tajaanluar', [
            'model' => $model,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblBiasiswa] : $modelsAddress,
            'iklan' => $iklan
          
        ]);
    }
    public function actionTajaanluarsm($id) {
      
        $modelsAddress = [new TblBiasiswa()]; 
        $model = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
         $iklan = $this->findIklanByID($id);
        if ((Yii::$app->request->post())) {
                
            $modelsAddress = \app\models\cbelajar\Model::createMultiple(TblBiasiswa::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            
//            // ajax validation
          if (Yii::$app->request->isAjax) {
               Yii::$app->response->format = Response::FORMAT_JSON;
               return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                  ActiveForm::validate($modelCustomer)
                       
                );
            }
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                  
                        foreach ($modelsAddress as $i=> $modelAddress) {
//                                $modelAddress->icno = $modelCustomer->icno;
                                $modelAddress->icno =  Yii::$app->user->getId();
                                $modelAddress->jenisCd = 1;
                                $modelAddress->nama_tajaan;
                                $modelAddress->BantuanCd;
                                $modelAddress->idBorang=1;
                                $modelAddress->iklan_id = $iklan->id;
                                $modelAddress->created_dt = new \yii\db\Expression('NOW()');
                                $modelAddress->tahun = date("Y");
//                              $modelAddress->parent_id = $modelCustomer->id;
//                              $modelAddress->idBorang = 1;
                            if (! ($flag = $modelAddress->save())) {
                                $transaction->rollBack();
                                break;
                                
                            }
                        
                    }
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan.']);
                    if ($flag) {
                        $transaction->commit();

                        return $this->redirect(['cbelajar/maklumat-biasiswa-separuh-masa', 'id' => $iklan->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            
            
        }
        
        return $this->render('/cutibelajar/separuhmasa/_tajaanluarsm', [
            'model' => $model,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblBiasiswa] : $modelsAddress,
            'iklan' => $iklan
          
        ]);
    }
    public function actionBiasiswaums($id) {
      
        $modelsAddress = [new TblBiasiswa()]; 
        $model = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
         $iklan = $this->findIklanByID($id);
        if ((Yii::$app->request->post())) {
                
            $modelsAddress = \app\models\cbelajar\Model::createMultiple(TblBiasiswa::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            
//            // ajax validation
          if (Yii::$app->request->isAjax) {
               Yii::$app->response->format = Response::FORMAT_JSON;
               return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                  ActiveForm::validate($modelCustomer)
                       
                );
            }
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                  
                        foreach ($modelsAddress as $i=> $modelAddress) {
//                                $modelAddress->icno = $modelCustomer->icno;
                                $modelAddress->icno =  Yii::$app->user->getId();
                                $modelAddress->jenisCd = 2;
                                $modelAddress->nama_tajaan = "BIASISWA PENGURUSAN UMS";
                                $modelAddress->BantuanCd;
                                $modelAddress->idBorang=1;
                                $modelAddress->iklan_id = $iklan->id;
                                $modelAddress->created_dt = new \yii\db\Expression('NOW()');
                                $modelAddress->tahun = date("Y");
//                              $modelAddress->parent_id = $modelCustomer->id;
//                              $modelAddress->idBorang = 1;
                            if (! ($flag = $modelAddress->save())) {
                                $transaction->rollBack();
                                break;
                                
                            }
                        
                    }
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan.']);
                    if ($flag) {
                        $transaction->commit();

                        return $this->redirect(['cbelajar/maklumat-biasiswa', 'id' => $iklan->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            
            
        }
        
        return $this->render('_biasiswaums', [
            'model' => $model,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblBiasiswa] : $modelsAddress,
            'iklan' => $iklan,
          
        ]);
    }
    public function actionBiasiswaumssm($id) {
      
        $modelsAddress = [new TblBiasiswa()]; 
        $model = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
         $iklan = $this->findIklanByID($id);
        if ((Yii::$app->request->post())) {
                
            $modelsAddress = \app\models\cbelajar\Model::createMultiple(TblBiasiswa::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            
//            // ajax validation
          if (Yii::$app->request->isAjax) {
               Yii::$app->response->format = Response::FORMAT_JSON;
               return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                  ActiveForm::validate($modelCustomer)
                       
                );
            }
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                  
                        foreach ($modelsAddress as $i=> $modelAddress) {
//                                $modelAddress->icno = $modelCustomer->icno;
                                $modelAddress->icno =  Yii::$app->user->getId();
                                $modelAddress->jenisCd = 2;
                                $modelAddress->nama_tajaan = "BIASISWA PENGURUSAN UMS";
                                $modelAddress->BantuanCd;
                                $modelAddress->idBorang=1;
                                $modelAddress->iklan_id = $iklan->id;
                                $modelAddress->created_dt = new \yii\db\Expression('NOW()');
                                $modelAddress->tahun = date("Y");
//                              $modelAddress->parent_id = $modelCustomer->id;
//                              $modelAddress->idBorang = 1;
                            if (! ($flag = $modelAddress->save())) {
                                $transaction->rollBack();
                                break;
                                
                            }
                        
                    }
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan.']);
                    if ($flag) {
                        $transaction->commit();

                        return $this->redirect(['cbelajar/maklumat-biasiswa-separuh-masa', 'id' => $iklan->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            
            
        }
        
        return $this->render('/cutibelajar/separuhmasa/_biasiswaums', [
            'model' => $model,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblBiasiswa] : $modelsAddress,
            'iklan' => $iklan,
          
        ]);
    }
    public function actionKpm($id) {
      
        $icno = Yii::$app->user->getId();
        $model = new TblBiasiswa();
        $modelCustomer = new TblPermohonan(); 
        $modelsAddress = [new TblBiasiswa()]; 
        $model2 = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
        $iklan = $this->findIklanByID($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->iklan_id = $iklan->id;
            $model->bentukBantuan = "KPT";
            $model->BantuanCd = "1";
            $model->jenisCd = "3";
             $model->idBorang = "1";
             $model->amaunBantuan = "BIASISWA KPT";
            $model->icno = $icno;
             $model->created_dt = new \yii\db\Expression('NOW()');
            $model->tahun = date("Y");
            if($model->save(false)){
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya ditambah!']);
                return $this->redirect(['maklumat-biasiswa', 'id' => $iklan->id ]);
            }
            
        }
        return $this->render('_kpm', [
            'model' => $model,
            'iklan' => $iklan,
            'model2' => $model2,
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => [new TblBiasiswa],
        ]);
    }
     public function actionKpmsm($id) {
      
        $icno = Yii::$app->user->getId();
        $model = new TblBiasiswa();
        $modelCustomer = new TblPermohonan(); 
        $modelsAddress = [new TblBiasiswa()]; 
        $model2 = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
        $iklan = $this->findIklanByID($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->iklan_id = $iklan->id;
            $model->bentukBantuan = "KPT";
            $model->BantuanCd = "5";
            $model->jenisCd = "3";
             $model->idBorang = "1";
             $model->amaunBantuan = "BIASISWA KPT";
            $model->icno = $icno;
             $model->created_dt = new \yii\db\Expression('NOW()');
            $model->tahun = date("Y");
            if($model->save(false)){
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya ditambah!']);
                return $this->redirect(['maklumat-biasiswa', 'id' => $iklan->id ]);
            }
            
        }
        return $this->render('_kpmsm', [
            'model' => $model,
            'iklan' => $iklan,
            'model2' => $model2,
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => [new TblBiasiswa],
        ]);
    }
    public function actionBorangCb() {
        $title2 = 'Senarai Permohonan Pengajian Lanjutan';
        $dataProviderLanjutan = TblStickerStaf::findGridKenderaan($title2);
        $title = 'Permohonan Pelekat Baru';
        $dataProvider = TblStickerStaf::findGridKenderaan($title);

        return $this->render('view_permohonan_user', [
                    'dataProviderLanjutan' => $dataProviderLanjutan,
                    'dataProvider' => $dataProvider,
                    'title' => $title,
        ]);
    }

    
    public function actionTanpatajaan($id) {
      
        $icno = Yii::$app->user->getId();
        $model = new TblBiasiswa();
        $model2 = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
        $iklan = $this->findIklanByID($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->iklan_id = $iklan->id;
            $model->bentukBantuan = "TANPA TAJAAN";
            $model->BantuanCd = "6";
            $model->jenisCd = "4";
            $model->idBorang=1;
             $model->amaunBantuan = "PERSENDIRIAN";
             $model->icno = $icno;
             $model->created_dt = new \yii\db\Expression('NOW()');
            $model->tahun = date("Y");
            if($model->save(false)){
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya ditambah!']);
                return $this->redirect(['maklumat-biasiswa', 'id' => $iklan->id ]);
            }
            
        }
        return $this->render('_tanpatajaan', [
            'model' => $model,
            'iklan' => $iklan,
            'model2' => $model2,
          
        ]);
    }
    public function actionTanpatajaansm($id) {
      
        $icno = Yii::$app->user->getId();
        $model = new TblBiasiswa();
        $model2 = TblBiasiswa::findAll(['icno' =>$this->ICNO()]);
        $iklan = $this->findIklanByID($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $icno;
            $model->iklan_id = $iklan->id;
            $model->bentukBantuan = "TANPA TAJAAN";
            $model->BantuanCd = "6";
            $model->jenisCd = "4";
            $model->idBorang=1;
             $model->amaunBantuan = "PERSENDIRIAN";
             $model->icno = $icno;
             $model->created_dt = new \yii\db\Expression('NOW()');
            $model->tahun = date("Y");
            if($model->save(false)){
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Biasiswa telah Berjaya ditambah!']);
                return $this->redirect(['maklumat-biasiswa-separuh-masa', 'id' => $iklan->id ]);
            }
            
        }
        return $this->render('_tanpatajaansm', [
            'model' => $model,
            'iklan' => $iklan,
            'model2' => $model2,
          
        ]);
    }
    public function actionPadamGambar($id) {
        $model = $this->findImg();
        $iklan = $this->findIklanbyID($id);
        if ($model->delete()) {
            if (!$model->deleteImage()) {
                Yii::$app->session->setFlash('error', 'Error deleting image');
            }
        }
        return $this->redirect(['gambar', 'id'=>$iklan->id]);
    }
    protected function findBiodata1() {
        return Tblprcobiodata::findOne(['ICNO' => $this->ICNO()]);
    }
     protected function findSabatikal() {
        return \app\models\cbelajar\TblPengajian::findAll(['icno' =>$this->ICNO(), 'status'=>2]);
    }
    
    public function actionMaklumatPengajian($id) {
        
        $pengajianTinggi = TblPengajian::findAll(['icno' =>$this->ICNO(),'iklan_id' => $id, 'idBorang' => 1,'status'=>[9,1]]);
        $iklan = $this->findIklanbyID($id);
        $icno = Yii::$app->user->getId();
        $sabatikal2= $this->findSabatikal();
        $model = new TblPengajian();
        $model->icno = $icno;
        if ($model->load(Yii::$app->request->post())) 
        {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['maklumat-pengajian',  'id' => $model->id]);
        }
            $searchModel = new TblPengajianSearch();
            $query = TblPengajian::find()->where(['icno' => $icno]);
            $DataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        return $this->render('form_pengajian', 
        [
                    'model' => $model,
                    'iklan' => $iklan,
                    'eduhighest' => $pengajianTinggi,
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
                    'sabatikal2' => $sabatikal2,
        ]);
    }
    public function actionMaklumatPengajianSeparuhMasa($id) {
        
        $pengajianTinggi = TblPengajian::findAll(['icno' =>$this->ICNO(),'iklan_id' => $id, 'idBorang' => 38,'status'=>9]);
        $iklan = $this->findIklanbyID($id);
        $icno = Yii::$app->user->getId();
        $sabatikal2= $this->findSabatikal();
        $model = new TblPengajian();
        $model->icno = $icno;
        if ($model->load(Yii::$app->request->post())) 
        {
            $model->created_dt = new \yii\db\Expression('NOW()');
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['maklumat-pengajian',  'id' => $model->id]);
        }
            $searchModel = new TblPengajianSearch();
            $query = TblPengajian::find()->where(['icno' => $icno]);
            $DataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        return $this->render('/cutibelajar/separuhmasa/form_pengajian', 
        [
                    'model' => $model,
                    'iklan' => $iklan,
                    'eduhighest' => $pengajianTinggi,
                    'searchModel' => $searchModel,
                    'dataProvider' => $DataProvider,
                    'sabatikal2' => $sabatikal2,
        ]);
    }
    public function actionUpdate($id) {

        
        $model = TblPengajian::findOne($id);
        $file = UploadedFile::getInstance($model, 'file1');
            if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save(false)) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Pengajian telah Berjaya dikemaskini!']);
                return $this->redirect(['maklumat-pengajian', 'id'=>$model->iklan_id]);
            }
        }
        return $this->render('_formpengajian', [
                    'model' => $model,
                   
                   
                   
        ]);
    }
    public function actionUpdatesm($id) {

        
        $model = TblPengajian::findOne($id);
        $file = UploadedFile::getInstance($model, 'file1');
            if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'cb');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save(false)) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat Pengajian telah Berjaya dikemaskini!']);
                return $this->redirect(['maklumat-pengajian-separuh-masa', 'id'=>$model->iklan_id]);
            }
        }
        return $this->render('/cutibelajar/separuhmasa/_formpengajian', [
                    'model' => $model,
                   
                   
                   
        ]);
    }
    public function actionDelete($id, $i) 
    {
      
        $mj = TblPengajian::findOne($id)->delete();
//        $iklan = findIklanbyID($id);
        
        return $this->redirect(['cbelajar/maklumat-pengajian', 'id'=>$i]);
    }
    public function actionDeletesm($id, $i) 
    {
      
        $mj = TblPengajian::findOne($id)->delete();
//        $iklan = findIklanbyID($id);
        
        return $this->redirect(['cbelajar/maklumat-pengajian-separuh-masa', 'id'=>$i]);
    }
    public function actionDeleteBiasiswa($id, $i) 
    {
        $mj = TblBiasiswa::findOne($id)->delete();
        return $this->redirect(['cbelajar/maklumat-biasiswa', 'id'=>$i]);
    }
     public function actionDeleteBiasiswasm($id, $i) 
    {
        $mj = TblBiasiswa::findOne($id)->delete();
        return $this->redirect(['cbelajar/maklumat-biasiswa-separuh-masa', 'id'=>$i]);
    }
     public function actionDeleteDokumen($id, $i) 
    {
        $mj = TblFilePemohon::findOne($id)->delete();
        return $this->redirect(['senarai-dokumen-dimuatnaik', 'id'=>$i]);
    }
    public function actionDeleteDokumensm($id, $i) 
    {
        $mj = TblFilePemohon::findOne($id)->delete();
        return $this->redirect(['senarai-dokumen-separuh-masa', 'id'=>$i]);
    }
    public function actionDeleteDokumenKpm($id, $i) 
    {
        $mj = \app\models\cbelajar\TblFileKpm::findOne($id)->delete();
        return $this->redirect(['senarai-dokumen-dimuatnaik', 'id'=>$i]);
    }
    public function actionDeleteDokumenLn($id, $i) 
    {
        $mj = \app\models\cbelajar\TblFileLn::findOne($id)->delete();
        return $this->redirect(['senarai-dokumen-dimuatnaik', 'id'=>$i]);
    }
    protected function findKemudahan($id)
    {
        if (($model = TblPermohonan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionPermohonanSemasa()
    {
        $model = new TblPermohonan();
        $icno=Yii::$app->user->getId();
        $model->icno = $icno;
        $status = TblPermohonan::findAll(['icno' => $icno]); //senarai status permohonan
        $searchModel = new TblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        $ver = TblPermohonan::findAll(['ver_by' => $icno]);
        
        return $this->render('view_permohonan', [
            'model' => $model,
            'status' => $status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ver' => $ver,
            'bil' => 1,
        ]);
    }
    protected function findStatus() {
        $model = StatusPermohonan::find()->all();
        return $model;
    }
    public function actionAktifTakwim($id) 
     {
        $iklan = $this->findModel($id);
      
        if ($iklan->load(Yii::$app->request->post())) {
            $iklan->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Takwim Berjaya Di Aktifkan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect('../cbadmin/halaman-admin');
        }
        return $this->renderAjax('form_aktif_takwim', ['iklan' => $iklan]);
    }
    
    public function actionNyahaktifTakwim($id) 
     {
        $iklan = $this->findModel($id);
      
        if ($iklan->load(Yii::$app->request->post())) {
            $iklan->status=0;
            $iklan->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Takwim Berjaya Di Nyahaktifkan', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect('../cbadmin/halaman-admin');
        }
        return $this->renderAjax('form_aktif_takwim_1', ['iklan' => $iklan]);
    }
     public function actionEditIklan($id) {

        $iklan = $this->findModel($id);
        $urusMesyuarat = TblUrusMesyuarat::find()->All(); //cari semua mesyuarat
        $senarai_iklan = $this->findIklan(0);

        if ($iklan->load(Yii::$app->request->post())) {
            $iklan->tarikh_tutup;
            $iklan->tarikh_buka;
            $iklan->tarikh_mesyuarat;
            $iklan->kategori;
            $iklan->status = 0;
            $iklan->save();
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Takwim Berjaya Disimpan.']);
            return $this->redirect(['/cbadmin/halaman-admin', 'id' => $iklan->id]);
        }

        return $this->render('form_tambah_takwim', [
                    'iklan' => $iklan,
                    'urusMesyuarat' => $urusMesyuarat,
                    'senarai_iklan' => $senarai_iklan

        ]);
    }
    
     public function actionDeleteIklan($id) {

         TblUrusMesyuarat::deleteAll(['id' => $id]);
      
        Yii::$app->session->setFlash('alert', ['title' => 'Takwim Berjaya Di Padam', 'type' => 'success', 'msg' => 'Berjaya Dipadam.']);
        return $this->redirect(['/cbadmin/halaman-admin']);
    }

     protected function findModel($id) {
        if (($model = TblUrusMesyuarat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findPengajian($id) {
        if (($eduhighest = TblPengajian::findOne($id)) !== null) {
            return $eduhighest;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
