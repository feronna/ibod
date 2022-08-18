<?php

namespace app\controllers;

use Yii;
use app\models\cbelajar\BorangPenerbangan;
use app\models\cbelajar\JadualPenerbangan;
use app\models\hronline\Tblprcobiodata;
use app\models\cbelajar\TblPenumpang;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\kemudahan\Model;
use yii\helpers\Html;
use app\models\Notification;
use yii\web\UploadedFile;
use app\models\hronline\Tblkeluarga;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;
use tebazil\runner\ConsoleCommandRunner;
use app\models\hronline\Department;

class TiketpenerbanganController extends \yii\web\Controller
{
      public function behaviors()
    {
        return [
          'access' => [
                'class' => AccessControl::className(),
                'only' => ['borang-permohonan','borang-tuntutan','adminview','kj-view-tuntutan','adminvieww','kj-view'],
                'rules' => [
                    [
                        'actions' => ['borang-permohonan','borang-tuntutan','adminview','kj-view-tuntutan','adminvieww','kj-view'],
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
                           
                            if(in_array (Yii::$app->user->getId(),['950829125446','860130125080','891103125554']))
                            {
                                return TRUE;
                            }
                           
                                return FALSE;
                                
                                
                           
                        } ,
                    ],
                                [
                        'actions' => ['adminview','adminvieww','kj-view'],
                        'allow' => true,
                        'matchCallback' => function($rule,$action)
                        {
                             

                            if((Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jawatan->job_category == "1") || 
                               (Yii::$app->user->identity->statLantikan == "2"  && Yii::$app->user->identity->jawatan->job_category == "1") ||
                               (Yii::$app->user->identity->statLantikan == "1"  && Yii::$app->user->identity->jawatan->job_category == "2"))
                            {
                                return TRUE;
                            }
                           
                            if(in_array (Yii::$app->user->getId(),['891103125554','950829125446']))
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
                'actions' => [
                    //                    'logout' => ['post'],
                ],
            ],
        ];
    }

protected function ICNO() {

        return \Yii::$app->user->identity->ICNO;
    }
     protected function notifikasi($icno, $content){
        //--------Model Notification-----------//
                $ntf = new Notification(); //noti untuk kp
                $ntf->icno = $icno;
                $ntf->title = 'Permohonan Tuntutan Bayaran Balik Tiket Penerbangan';
                $ntf->content = $content;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                //--------Model Notification-----------//
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
    protected function dynamicform($modelsAddress, $modelCustomer) {
        
            $oldIDs = ArrayHelper::map($modelsAddress, 'id', 'id');
            $modelsAddress = Model::createMultiple(TblPenumpang::classname(), $modelsAddress);
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsAddress, 'id', 'id')));
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        if (! empty($deletedIDs)) {
                            TblPenumpang::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsAddress as $i => $modelAddress) {
                            //$modelAddress->customer_id = $modelCustomer->id;
                            $modelAddress->parent_id = $modelCustomer->id;
                            $modelAddress->icno = $modelCustomer->icno;
                            $data = Tblkeluarga::find()->where(['AND',['ICNO' => $this->ICNO()], ['FamilyId' => $modelAddress->jp_icno]])->one();
                            $modelAddress->jp_nama = $data->FmyNm;
                            $modelAddress->umur = date("Y") - date("Y", strtotime($data->FmyBirthDt));
                            $modelAddress->jp_hubungan = $data->hubkeluarga;
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
//                        return $this->redirect(['senaraipermohonan?user='.$jfpiu]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
    }
    protected function dynamicformpenerbangan($modelsPenerbangan, $modelCustomer) {
        
            $oldIDs = ArrayHelper::map($modelsPenerbangan, 'id', 'id');
            $modelsPenerbangan = Model::createMultiple(JadualPenerbangan::classname(), $modelsPenerbangan);
            Model::loadMultiple($modelsPenerbangan, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsPenerbangan, 'id', 'id')));
            
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsPenerbangan) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        if (! empty($deletedIDs)) {
                            JadualPenerbangan::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsPenerbangan as $i => $modelPenerbangan) {
                            //$modelAddress->customer_id = $modelCustomer->id;
                            $modelPenerbangan->idPermohonan = $modelCustomer->id;
                            $modelPenerbangan->icno = $modelCustomer->icno;
                            $modelPenerbangan->save(false);
//                            $modelPenerbangan->tarikh_berlepas;

                            if (! ($flag = $modelPenerbangan->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
//                        return $this->redirect(['senaraipermohonan?user='.$jfpiu]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
    }
    
public function actionBorangPermohonan()
    {
        $icno = Yii::$app->user->getId();  
        $model = new BorangPenerbangan();
        $searchModel = new BorangPenerbangan(); 
        $model->icno = $icno;  
        $queryKeluarga = $this->findRekodKeluarga();
        $modelCustomer = new BorangPenerbangan(); 
        $modelCustomer->icno = $icno;
        $modelCustomer->status_borang = "Selesai Permohonan";
        $modelCustomer->status_bsm = "Tunggu Kelulusan";
        $modelCustomer->tarikh_mohon = date('Y-m-d H:i:s');
        $modelsAddress = [new TblPenumpang()]; 
        $modelsPenerbangan = [new JadualPenerbangan()]; 
                $file = UploadedFile::getInstance($modelCustomer, 'file');
                $file2 = UploadedFile::getInstance($modelCustomer, 'file2');

     
     
//        $checkApplication = BorangPenerbangan::find()->where(['status_borang' => "Selesai Permohonan",'icno' => $icno]);
//        if($checkApplication->exists()){
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
//            return $this->redirect(['lanjutancb/lihat-permohonan']);
//        }
        $checkApplication = BorangPenerbangan::find()->where(['status_borang' => "Selesai Permohonan",'id' => $modelCustomer->id]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['tiketpenerbangan/lihat-permohonan', 'id'=>$modelCustomer->id]);
        }
         if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'cb_tiketpenerbangan');
                $filepath = $fileapi->file_name_hashcode;     
        }
        else{
            $filepath = '';
        }
         if($file2){
                $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'cb_tiketpenerbangan');
                $filepath2 = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath2 = '';
        }
        if ($modelCustomer->load(Yii::$app->request->post())) {

          
            $this->dynamicform($modelsAddress, $modelCustomer);
            $this->dynamicformpenerbangan($modelsPenerbangan, $modelCustomer);
             $modelCustomer->agree = 1;
             $modelCustomer->idBorang = "CBDN";
             $modelCustomer->borangID = "4";
             $modelCustomer->dokumen = $filepath;
             $modelCustomer->dokumen2 = $filepath2;

            $modelCustomer->save(false);
            $this->pendingtask(840929125614, 37);

//                        $modelsPenerbangan->save(false);
//            $modelsAddress->save(false);
            $ntf = new Notification();
            $ntf->icno = 840929125614; // peg  penyelia perjawatan
            $ntf->title = 'Pengajian Lanjutan - Permohonan Tiket Penerbangan';
            $ntf->content = "Permohonan Tiket Penerbangan menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['adminview', 'id'=>$modelCustomer->id], ['class'=>'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
             $ntf->save(false);   

             $this->notifikasi($model->icno, "Permohonan Tiket Penerbangan anda telah dihantar untuk tindakan BSM. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
            return $this->redirect(['lihat-permohonan', 'id'=>$modelCustomer->id]);//

        
        }


        return $this->render('_borang', [
            'model' => $model,
            'searchModel' => $searchModel, 
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblPenumpang] : $modelsAddress,
            'modelsPenerbangan' => (empty($modelsPenerbangan)) ? [new JadualPenerbangan] : $modelsPenerbangan,
            'queryKeluarga' => $queryKeluarga,
        ]);
    }
    
    
    public function actionBorangTuntutan()
    {
        $icno = Yii::$app->user->getId();  
        $model = new BorangPenerbangan(); 
        $model->icno = $icno;
        $model->status_borang = "Selesai Permohonan";
//        $model->idBorang = "CBDN";
        $model->status_bsm = "Tunggu Kelulusan";
        $model->tarikh_mohon = date('Y-m-d H:i:s');
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
        
        $checkApplication = BorangPenerbangan::find()->where(['status_borang' => "Selesai Permohonan",'id' => $model->id]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['tiketpenerbangan/lihat-permohonan-tuntut', 'id'=>$model->id]);
        }
      if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'cb_tiketpenerbangan');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        if($file2){
                $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'cb_tiketpenerbangan');
                $filepath2 = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath2 = '';
        }
                  if ($model->load(Yii::$app->request->post())) {
            
                      $model->idBorang= "TUNT";
                      $model->agree = 1;
                      $model->borangID = 34;
                      $model->dokumen2 = $filepath;
                      $model->dokumen = $filepath2;
          $model->save(false);
          
          $ntf = new Notification();
            $ntf->icno = 840929125614; // peg  penyelia perjawatan
            $ntf->title = 'Pengajian Lanjutan - Permohonan Tuntutan Bayaran Balik Tiket Penerbangan';
            $ntf->content = "Permohonan Tuntutan Bayaran Balik Tiket Penerbangan menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakantuntutan'], ['class'=>'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
             $ntf->save(false);   
             $this->notifikasi($model->icno, "Permohonan tuntutan Bayaran Balik Tiket Penerbangan anda telah dihantar untuk tindakan BSM. ".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
         Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
            return $this->redirect(['lihat-permohonan-tuntut', 'id'=>$model->id]);//

        
        }
//if ($model->load(Yii::$app->request->post()))
//                {
//            $model->icno;
//            $model->dokumen = $filepath;
//           $model->dokumen = $filepath;
//
//            $model->status_borang = "Selesai Permohonan ";
//            $model->save(false);
//
//                }
        return $this->render('_tuntut', [
            'model' => $model,
           
        ]);
    }
     public function actionLihatPermohonanTuntut($id){
        $icno=Yii::$app->user->getId();
        $model = BorangPenerbangan::find()->where(['id'=>$id,'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();

              if(BorangPenerbangan::find()->where(['id' => $id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {
         return $this->render('_lihatpermohonantuntut', 
            [ 
              'model' => $model,
            
            ]);
         }
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('/cutibelajar/halaman-pemohon');}
        
    }
    public function actionLihatPermohonan($id){
        $icno=Yii::$app->user->getId();
        $model = BorangPenerbangan::find()->where(['id'=>$id,'icno' => $icno, 'status_borang' => "Selesai Permohonan"])->one();
        $penumpang2 = TblPenumpang::find()->where(['parent_id'=>$id])->all();
        $jadualTempahan = JadualPenerbangan::find()->where(['idPermohonan'=>$id])->all();
//         $jadualTempahan = \app\models\cbelajar\JadualPenerbangan::find()->where([ 'idPermohonan'=>$model->id])->one();

              if(BorangPenerbangan::find()->where(['id' => $id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {
         return $this->render('_lihatpermohonan', 
            [ 
              'model' => $model,
              'penumpang2' => $penumpang2,
              'jadualTempahan' => $jadualTempahan,
                'id'=>$id
            ]);
         }
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('halaman-pemohon');}
        
    }
   public function actionTambahJadual($id)
    {
        $i=Yii::$app->user->getId();
        $model = \app\models\cbelajar\BorangPenerbangan::find()->where(['id'=>$id])->one();
//        $icno = $model->icno;
//        $tajaan = \app\models\cbelajar\TblElaunLulus::find()->where(['icno'=>$icno])->one();
$terbang = new JadualPenerbangan();
//        $icno = $model->icno;

//        var_dump('a');die;
        if ($terbang->load(Yii::$app->request->post())) {
            $terbang->icno = $model->icno;
            $terbang->idPermohonan = $id;
//              $model->pID= $pengajian->id;
              $terbang->save(false);
              Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jadual berjaya disimpan']);

            return $this->redirect(['adminview', 'id'=>$id]);
        }

        return $this->renderAjax('_tambahjadual', [
            'model' => $model,
            'terbang'=>$terbang,
//            'tajaan' =>$tajaan,
//            't'=>$t,
//            'data'=> $data,
//            'lapor' =>$lapor,
//            'allbiodata' => $allbiodata,
        ]);
    }
    
public function actionRekodPenerbangan()
    {

        $model = new BorangPenerbangan();
        $icno=Yii::$app->user->getId();
        $model->icno = $icno;
        $statustiket = \app\models\cbelajar\BorangPenerbangan::find()->where(['icno' => $icno, 'status_borang' => "Selesai Permohonan"])->all();
        $searchModel = new \app\models\cbelajar\BorangPenerbanganSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $ver = BorangPenerbangan::find()->where(['ver_by' => $icno, 'status_borang' => "Selesai Permohonan"])->orderBy(['tarikh_m' => SORT_DESC]);
        return $this->render('rekodsemasa', [
            'model' => $model,
            'statustiket' => $statustiket,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ver' => $ver,
            'bil' => 1,
            'icno' => $icno
        ]);
    }
 public function actionAdminview($id){
//        $icno=Yii::$app->user->getId();
        $model = BorangPenerbangan::find()->where(['id'=>$id, 'status_borang' => ["Selesai Permohonan","BATAL"]])->one();
        $penumpang2 = TblPenumpang::find()->where(['parent_id'=>$id])->all();
        $jadualTempahan = JadualPenerbangan::find()->where(['idPermohonan'=>$id])->all();
//         $jadualTempahan = \app\models\cbelajar\JadualPenerbangan::find()->where([ 'idPermohonan'=>$model->id])->one();

              if(BorangPenerbangan::find()->where(['id' => $id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {
                   if($model->load(Yii::$app->request->post())) {
      
                        $model->ver_date = date('Y-m-d H:i:s');
                        $model->status = "DALAM TINDAKAN KETUA JABATAN";
                        $model->app_by = 701203106182;
                        $ntf = new Notification();
                        $ntf->icno = 701203106182; // peg  penyelia perjawatan
                        $ntf->title = 'Pengajian Lanjutan - Permohonan Tempahan Tiket Penerbangan';
                        $ntf->content = "Permohonan Tempahan Tiket Penerbangan menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/kj'], ['class'=>'btn btn-primary btn-sm']);
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save(false); 
                        $model->save(false);
                        $this->pendingtask(701203106182, 26);

             Yii::$app->session->setFlash('alert', ['title' => 'Semakan berjaya disimpan', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['adminview', 'id'=> $id]);
                }  
              if($model->status_bsm == 'Diluluskan' || 
                $model->status_bsm == 'Tidak Layak Dipertimbangkan'||  $model->status_bsm == 'Telah Diluluskan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}
          if(\app\models\cbelajar\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
         return $this->render('adminview', 
            [ 
              'model' => $model,
              'penumpang2' => $penumpang2,
              'jadualTempahan' => $jadualTempahan,
                'view'=>$view, 'edit'=>$edit,'id'=>$id
            ]);
         }
        }
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('../cbadmin/halaman-admin');}
        
    }
    public function actionKjViewTuntutan($id){
//        $icno=Yii::$app->user->getId();
        $model = BorangPenerbangan::find()->where(['id'=>$id, 'status_borang' => "Selesai Permohonan"])->one();
        $penumpang2 = TblPenumpang::find()->where(['parent_id'=>$id])->all();
        $jadualTempahan = JadualPenerbangan::find()->where(['idPermohonan'=>$id])->all();
//         $jadualTempahan = \app\models\cbelajar\JadualPenerbangan::find()->where([ 'idPermohonan'=>$model->id])->one();

              if(BorangPenerbangan::find()->where(['id' => $id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {
                   if($model->load(Yii::$app->request->post())) {
      
                   $model->app_date = date('Y-m-d H:i:s');
  
//            $ntf = new Notification();
//            $ntf->icno = 830403125426; // peg  penyelia perjawatan
//            $ntf->title = 'Pengajian Lanjutan - Permohonan Tempahan Tiket Penerbangan';
//            $ntf->content = "Permohonan Tempahan Tiket Penerbangan menunggu tindakan lanjutan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/admin'], ['class'=>'btn btn-primary btn-sm']);
//            $ntf->ntf_dt = date('Y-m-d H:i:s');
//            $ntf->save(false);   
            $model->save(false);
             Yii::$app->session->setFlash('alert', ['title' => 'Semakan berjaya disimpan', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['kj-view-tuntutan', 'id'=> $id]);
                }  
              if($model->status_kj == 'DILULUSKAN' || 
                $model->status_kj == 'TIDAK DILULUSKAN'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}
            
            if($model->status_bsm == 'Layak Dipertimbangkan' || 
                $model->status_bsm == 'Tidak Layak Dipertimbangkan'){
            $vieww= '';}
        else{
            $vieww = 'none'; }
         return $this->render('kjviewtuntutan', 
            [ 
              'model' => $model,
              'penumpang2' => $penumpang2,
              'jadualTempahan' => $jadualTempahan,
                'view'=>$view, 'edit'=>$edit,'vieww'=>$vieww
            ]);
         }
        
        
    }
    public function actionKjView($id){
//        $icno=Yii::$app->user->getId();
        $model = BorangPenerbangan::find()->where(['id'=>$id, 'status_borang' => "Selesai Permohonan"])->one();
        $penumpang2 = TblPenumpang::find()->where(['parent_id'=>$id])->all();
        $jadualTempahan = JadualPenerbangan::find()->where(['idPermohonan'=>$id])->all();
//         $jadualTempahan = \app\models\cbelajar\JadualPenerbangan::find()->where([ 'idPermohonan'=>$model->id])->one();

              if(BorangPenerbangan::find()->where(['id' => $id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {
                   if($model->load(Yii::$app->request->post())) {
                   $model->status = "DALAM TINDAKAN PP";
                   $model->status_bsm="Telah Diluluskan";
                   $model->app_date = date('Y-m-d H:i:s');
  
            $ntf = new Notification();
            $ntf->icno = 850403125133; // peg  penyelia perjawatan
            $ntf->title = 'Pengajian Lanjutan - Permohonan Tempahan Tiket Penerbangan';
            $ntf->content = "Permohonan Tempahan Tiket Penerbangan menunggu tindakan lanjutan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/admin'], ['class'=>'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false);   
            $model->save(false);
            $this->pendingtask(850403125133, 27);
             Yii::$app->session->setFlash('alert', ['title' => 'Semakan berjaya disimpan', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['kj-view', 'id'=> $id]);
                }  
              if($model->status_kj == 'DILULUSKAN' || 
                $model->status_kj == 'TIDAK DILULUSKAN'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}
            
            if($model->status_bsm == 'Diluluskan' || 
                $model->status_bsm == 'Tidak Layak Dipertimbangkan' || $model->status_bsm == 'Telah Diluluskan'){
            $vieww= '';}
        else{
            $vieww = 'none'; }
         return $this->render('kjview', 
            [ 
              'model' => $model,
              'penumpang2' => $penumpang2,
              'jadualTempahan' => $jadualTempahan,
                'view'=>$view, 'edit'=>$edit,'vieww'=>$vieww
            ]);
         }
        
        
    }
    public function actionCetakPenerbangan($id){
        $model = BorangPenerbangan::find()->where(['id'=>$id, 'status_borang' => "Selesai Permohonan"])->one();
        $penumpang2 = TblPenumpang::find()->where(['parent_id'=>$id])->all();
        $jadualTempahan = JadualPenerbangan::find()->where(['idPermohonan'=>$id])->all();
       $css = file_get_contents('./css/cetak.css');

             $content = $this->renderPartial('cetak', [ 'model' => $model,
                 'penumpang2' => $penumpang2, 'jadualTempahan' => $jadualTempahan,

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
            
            'options' => ['title' => 'Permohonan Tempahan Tiket Penerbangan'],
            // call mPDF methods on the fly
              
         
            'methods' => [
              'SetHeader' => ['Permohonan Tempahan Tiket Penerbangan'],
                     'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
             
            ] ,           // call mPDF methods on the fly
            
        ]);

        return $pdf->render();
           
        
       
    }
    public function actionCetakTuntutan($id){
        $model = BorangPenerbangan::find()->where(['id'=>$id, 'status_borang' => "Selesai Permohonan"])->one();
        $penumpang2 = TblPenumpang::find()->where(['parent_id'=>$id])->all();
        $jadualTempahan = JadualPenerbangan::find()->where(['idPermohonan'=>$id])->all();
       $css = file_get_contents('./css/cetak.css');

             $content = $this->renderPartial('cetak_tuntut', [ 'model' => $model,
                 'penumpang2' => $penumpang2, 'jadualTempahan' => $jadualTempahan,

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
            
            'options' => ['title' => 'Permohonan Tempahan Tiket Penerbangan'],
            // call mPDF methods on the fly
              
         
            'methods' => [
              'SetHeader' => ['Tuntutan Bayaran Balik Tiket Penerbangan'],
                     'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
//                     'WriteHTML' => [$css, 1]
             
            ] ,           // call mPDF methods on the fly
            
        ]);

        return $pdf->render();
           
        
       
    }
    
    public function actionViewTuntutan($id){
        $model = BorangPenerbangan::find()->where(['id'=>$id, 'status_borang' => "Selesai Permohonan"])->one();

              if(BorangPenerbangan::find()->where(['id' => $id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {
                  if($model->load(Yii::$app->request->post())) {
      
                         $model->ver_date = date('Y-m-d H:i:s');
                         $model->catatan;
//            $ntf = new Notification();
//            $ntf->icno = 701203106182; // peg  penyelia perjawatan
//            $ntf->title = 'Pengajian Lanjutan - Permohonan Tuntutan Tiket Penerbangan';
//            $ntf->content = "Permohonan Tuntutan Tiket Penerbangan menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/kj'], ['class'=>'btn btn-primary btn-sm']);
//            $ntf->ntf_dt = date('Y-m-d H:i:s');
//            $ntf->save(false);   
            $model->save(false);
             Yii::$app->session->setFlash('alert', ['title' => 'Semakan berjaya disimpan', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['view-tuntutan', 'id'=> $id]);
                }  
                }
                if($model->status_bsm == 'Layak Dipertimbangkan' || 
                $model->status_bsm == 'Tidak Layak Dipertimbangkan' || $model->status_bsm == 'Diluluskan'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}
          if(\app\models\cbelajar\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
         return $this->render('viewtuntutan', 
            [ 
              'model' => $model,
                'view'=>$view, 'edit'=>$edit
           
            ]);
         }
        
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('../cbadmin/halaman-admin');}
        
    }
     public function actionUpdateSemakan($id) {
        $model = BorangPenerbangan::find()->where(['id' => $id])->one();

        if (($model->load(Yii::$app->request->post()))) {
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['view-tuntutan?id='.$model->id]);
        }
        

        return $this->renderAjax('_updates', [
                    'model' => $model,
        
        ]);
    }
     public function actionAdminvieww($id){
//        $icno=Yii::$app->user->getId();
        $model = BorangPenerbangan::find()->where(['id'=>$id, 'status_borang' => "Selesai Permohonan"])->one();
        $penumpang2 = TblPenumpang::find()->where(['parent_id'=>$id])->all();
        $jadualTempahan = JadualPenerbangan::find()->where(['idPermohonan'=>$id])->all();
//         $jadualTempahan = \app\models\cbelajar\JadualPenerbangan::find()->where([ 'idPermohonan'=>$model->id])->one();

        
              if(BorangPenerbangan::find()->where(['id' => $id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {
  if($model->load(Yii::$app->request->post())) {
      
            $model->ad_dt = date('Y-m-d H:i:s');
            $model->status = "TELAH DITEMPAH";
            
            $ntf = new Notification();
            $ntf->icno = 840929125614; // peg  penyelia perjawatan
            $ntf->title = 'Pengajian Lanjutan - Permohonan Tempahan Tiket Penerbangan';
            $ntf->content = "Permohonan Tempahan Tiket Penerbangan menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakantuntutan'], ['class'=>'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false);   
            $model->save(false);
            $this->notifikasi($model->icno, "TEMPAHAN TIKET PENERBANGAN ANDA TELAH DITEMPAH,
                    SEBARANG PERTANYAAN BOLEH EMEL KE PN. MELINDA M. OMING "
                    . "<u>melinda@ums.edu.my</u> ." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));

             Yii::$app->session->setFlash('alert', ['title' => 'Semakan berjaya disimpan', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['adminvieww', 'id'=> $id]);
                }  
              if($model->status_a == 'DITEMPAH' || 
                $model->status_a == 'TIDAK LAYAK'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}
            
            if($model->status_kj == 'DILULUSKAN' || 
                $model->status_kj == 'TIDAK DILULUSKAN'){
           $viewww= '';}
       
             else{
            $viewww = 'none';}
      
            if($model->status_bsm == 'Telah Diluluskan' || 
                $model->status_bsm == 'Tidak Layak Dipertimbangkan'){
            $vieww= '';}
            else{
            $vieww = 'none';}
      
          if(\app\models\cbelajar\TblAccess::find()->where( [ 'icno' => Yii::$app->user->getId(), 'level'=>3] )->exists()){
         return $this->render('adminview_1', 
            [ 
              'model' => $model,
              'penumpang2' => $penumpang2,
              'jadualTempahan' => $jadualTempahan,
               'edit' => $edit,
                'view' => $view, 'vieww'=> $vieww, 'viewww'=>$viewww,
            ]);
         }
        }
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('../cbadmin/halaman-admin');}
        
    }
    public function actionAdminViewTuntutan($id){
//        $icno=Yii::$app->user->getId();
        $model = BorangPenerbangan::find()->where(['id'=>$id, 'status_borang' => "Selesai Permohonan"])->one();
        $penumpang2 = TblPenumpang::find()->where(['parent_id'=>$id])->all();
        $jadualTempahan = JadualPenerbangan::find()->where(['idPermohonan'=>$id])->all();
//         $jadualTempahan = \app\models\cbelajar\JadualPenerbangan::find()->where([ 'idPermohonan'=>$model->id])->one();

        
              if(BorangPenerbangan::find()->where(['id' => $id, 'status_borang'=>"Selesai Permohonan" ])->exists())
        {
        if($model->load(Yii::$app->request->post())) {
      
            $model->ad_dt = date('Y-m-d H:i:s');
            $ntf = new Notification();
            $ntf->icno = 840929125614; // peg  penyelia perjawatan
            $ntf->title = 'Pengajian Lanjutan - Permohonan Tempahan Tiket Penerbangan';
            $ntf->content = "Permohonan Tempahan Tiket Penerbangan menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['cbadmin/senaraitindakantuntutan'], ['class'=>'btn btn-primary btn-sm']);
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false);   
            $model->save(false);
             Yii::$app->session->setFlash('alert', ['title' => 'Semakan berjaya disimpan', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['adminvieww', 'id'=> $id]);
                }  
              if($model->status_a == 'DITEMPAH' || 
                $model->status_a == 'TIDAK LAYAK'){
            $edit = 'none'; $view= '';}
        else{
            $view = 'none'; $edit = '';}
            
            if($model->status_kj == 'DILULUSKAN' || 
                $model->status_kj == 'TIDAK DILULUSKAN'){
           $viewww= '';}
             else{
            $viewww = 'none';}
       
            
            if($model->status_bsm == 'Layak Dipertimbangkan' || $model->status_bsm == 'Telah Diluluskan' ||
                $model->status_bsm == 'Tidak Layak Dipertimbangkan'){
            $vieww= '';}
            else{
            $vieww = 'none';}
      
          if(\app\models\cbelajar\TblAccess::find()->where( [ 'icno' => Yii::$app->user->getId(), 'level'=>3] )->exists()){
         return $this->render('a_view', 
            [ 
              'model' => $model,
              'penumpang2' => $penumpang2,
              'jadualTempahan' => $jadualTempahan,
               'edit' => $edit,
                'view' => $view, 'vieww'=> $vieww, 'viewww'=>$viewww,
            ]);
         }
        }
     else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('../cbadmin/halaman-admin');}
        
    }
    protected function findJadualTempahan() {
        return \app\models\cbelajar\JadualPenerbangan::findAll(['icno' => $this->ICNO()]);
    }
    protected function findPenumpang() {
        return \app\models\cbelajar\JadualPenerbangan::findAll(['icno' => $this->ICNO()]);
    }
    public function findRekodKeluarga() {
        $biodata = $this->findBiodata();

        if ($biodata->MrtlStatusCd == 0) { //Status Tiada Maklumat
            $family = Tblkeluarga::find()->where(['ICNO' => null])->all(); // dummy
//        } else if ($biodata->MrtlStatusCd == 1) { // Belum berkahwin
//            $family = Tblkeluarga::find()->where(['ICNO' => $this->ICNO()])->andwhere(['IN', 'RelCd', ['03', '04']])->all();
        } else {
            $family = Tblkeluarga::find()->where(['ICNO' => $this->ICNO()])->andwhere(['IN', 'RelCd', ['01', '02', '05', '06', '07', '08']])->all();
        }

        return $family;
    }
    
    protected function findKeluargabyICNO() {
        if (($model = Tblkeluarga::findAll(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findBiodata() {
        return Tblprcobiodata::findOne(['ICNO' => $this->ICNO()]);
    }
    protected function findPenumpang2() {
        return TblPenumpang::findAll(['icno' => $this->ICNO()]);
    }
     protected function pendingtask($icno, $id){
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }
     protected function findModel2($id) {

        if (($model = BorangPenerbangan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionBatalBorang($id) {



        $model = $this->findModel2($id);


        if ($model->load(Yii::$app->request->post())) {

            $model->status_borang = "BATAL";
             $model->status_bsm = "BATAL";
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' =>
                'Borang berjaya dibatalkan']);
            return $this->redirect(['/cbadmin/senaraitindakantuntutan']);
        }

        return $this->renderAjax('batal-borang', [
                    'model' => $model,
        ]);
    }
}
