<?php

namespace app\controllers;

use Yii;
use app\models\Kadpekerja\Kadpekerja;
use app\models\KadpekerjaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\hronline\Tblprcobiodata;
use yii\data\ActiveDataProvider;
//use app\models\Kadpekerja\TblAccess;
use yii\helpers\Html;
use app\models\Notification; 
use app\models\Kadpekerja\RefPayment;
use app\models\esticker\TblAccess;
use app\models\Kadpekerja\RefStaffCard;
use yii\web\UploadedFile;

/**
 * KadpekerjaController implements the CRUD actions for Kadpekerja model.
 */
class KadpekerjaController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
                    //pengguna
                    'semakan-permohonan', 'permohonan', 
                    //kad pekerja 
                    'menunggu-kutipan','menunggu-bayaran','permohonan-selesai',  
                ],
                'rules' => [
                    [//pengguna
                        'actions' => ['semakan-permohonan', 'permohonan'],
                        'allow' => true,
                        'matchCallback' => function () {
                    $tmp = Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['!=', 'Status', '6']);
                    return (is_null($tmp)) ? false : true;
                }
                    ],
                     
                    [//kad pekerja
                        'actions' => ['menunggu-kutipan','menunggu-bayaran','permohonan-selesai'],
                        'allow' => true,
                        'matchCallback' => function () {
                    $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => [12]]);
                    return (is_null($tmp)) ? false : true;
                }
                    ],
                        
                ],
            ],
        ];
    }


    public function notification($title, $content, $icno = null)
    {
        if($icno == null){
            //default user login id
            $icno = Yii::$app->user->getId();  
        }
        $ntf = new Notification();
        $ntf->icno = $icno;  
        $ntf->title = $title;
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        return true;
    }
    protected function ICNO() {
        return Yii::$app->user->getId();
    }

    protected function findBiodata($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }
     protected function findTempPay($ICNO) {
        return RefStaffCard::findOne(['ref_icno' => $ICNO]);
    }
    
     protected function findModel($id)
    {
        if (($model = Kadpekerja::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    protected function findPayReciept($id)
    {
        if (($model = RefPayment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findAccess($id)
    {
        if (($model = TblAccess::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionDeleteAccess($id)
    {
        $this->findAccess($id)->delete();

       return $this->redirect(['tambah-akses']);
    }
    
    public function actionPermohonan() {
        
        $icno = Yii::$app->user->getId();  
        $biodata = $this->findBiodata($this->ICNO()); 
        $permohonan = new Kadpekerja(); 
        $permohonan->entry_date = date('Y-m-d H:i:s');
        
        $checkApplication = Kadpekerja::find()->where(['status_semasa' => 1,'icno' => $icno]);
         if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['kadpekerja/semakan-permohonan']);
        }
        
        if($permohonan->load(Yii::$app->request->post())){ 
            $permohonan->status_semasa = '1'; 
            $permohonan->isActive = '1';
            $permohonan->icno = $icno;
            $permohonan->cur_stat = 'BARU';
            $permohonan->app_stat = 'BARU';
            $permohonan->ver_stat = 'BARU';  
            $permohonan->card_owner = $biodata->CONm;
            $permohonan->card_id = $biodata->COOldID; 
            
            $file = UploadedFile::getInstance($permohonan, 'surat_tawaran');
            $file2 = UploadedFile::getInstance($permohonan, 'surat_lantikan');
            $file3 = UploadedFile::getInstance($permohonan, 'gambar');


            if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'surat_tawaran');
                $filepath = $fileapi->file_name_hashcode;   
            }
            else{
            $filepath = '';
            }
            if($file2){
                $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'surat_lantikan');
                $filepath2 = $fileapi->file_name_hashcode;   
            }
            else{
            $filepath2 = '';
            }
            if($file3){
                $fileapi = Yii::$app->FileManager->UploadFile($file3->name, $file3->tempName, '04', 'dokumen3');
                $filepath3 = $fileapi->file_name_hashcode;   
            }
            else{
            $filepath3 = '';
            }

            $permohonan->dokumen = $filepath;
            $permohonan->dokumen2 = $filepath2;
            $permohonan->dokumen3 = $filepath3;

            $permohonan->save();
            $this->notification('Kad Pekerja', 'Permohonan anda telah dihantar untuk diproses, sila semak status permohonan anda.'.Html::a('<i class="fa fa-arrow-right"></i>', ['kadpekerja/semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
            return $this->redirect(['kadpekerja/semakan-permohonan']);  
        }
        return $this->render('permohonan', [
                    'model' => $biodata,
                    'permohonan' => $permohonan,
                   
        ]);
    }
    public function actionPayment(){
         
        $model = $this->findBiodata($this->ICNO()); 
 
        return $this->render('payment',[ 
            'model' => $model,  
        ]);
    }
    public function actionSemakanPermohonan() {
         
        $icno = Yii::$app->user->getId();  
        $model = new Kadpekerja();
        $query = Kadpekerja::find()->Where(['icno' => $icno ])->orderBy(['entry_date' => SORT_DESC]);
        
        $dataProvider =  new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('semakan', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                  
        ]);
    } 
    
    public function actionTambahAkses()
    { 
        $model = new TblAccess();
      
        $query = TblAccess::find()->where(['isActive' => [1,0]]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
        
         if ($model->load(Yii::$app->request->post())) {

               if($model->isActive == '0'){
                   Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
                  
               }else{
                   $model->isActive = '1';
                   $model->save();
                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                   return $this->redirect(['kadpekerja/tambah-akses']);
               }
                 
                return $this->redirect(['kadpekerja/tambah-akses']);
            }
        return $this->render('tambah_akses', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
      
    } 
    public function actionSenaraiPermohonan()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai  = '';
 
        if(TblAccess::find()->where( ['icno' => $icno] )->andWhere(['access' => [1,99]])->exists()){                            
            
            $senarai = Kadpekerja::find()->where(['isActive' => 1])->orderBy(['entry_date' => SORT_DESC]);
            $title='Senarai Menunggu Perakuan'; 
        }
        elseif(TblAccess::find()->where( ['icno' => $icno] )->andWhere(['access' => [1,99]])->exists()){
            
            $senarai = Kadpekerja::find()->where(['isActive' => 1])->orderBy(['entry_date' => SORT_DESC]);
            $title ='Senarai Menunggu Kelulusan';
            
        }
        
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        isset(Yii::$app->request->queryParams['card_owner'])? $senarais->query->andFilterWhere
        (['like', 'card_owner',  Yii::$app->request->queryParams['card_owner'] ]):'';
        
         isset(Yii::$app->request->queryParams['icno'])? $senarais->query->andFilterWhere
        (['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';
         
          isset(Yii::$app->request->queryParams['card_type'])? $senarais->query->andFilterWhere
        (['like', 'card_type',  Yii::$app->request->queryParams['card_type'] ]):'';
          
          isset(Yii::$app->request->queryParams['card_id'])? $senarais->query->andFilterWhere
        (['like', 'card_id',  Yii::$app->request->queryParams['card_id'] ]):'';
       
        return $this->render('senarai_permohonan', [
            'icno' => $icno,
            'senarai' => $senarais,
            'title' => $title,
        ]);
      
    }
    
    public function actionTindakanTadbir($id){
        
        $icno = Yii::$app->user->getId(); 
        $model = $this->findModel($id);  
        $receipt = new RefPayment();
        $query = Kadpekerja::find()->where(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        
         $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $model->app_stat = 'MENUNGGU TINDAKAN';
            $receipt->parent_id = $model->id;
            $receipt->payment = $model->payment;
             
            if($model->ver_stat == ''){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }
                else{  
                            
                $model->cur_stat = $model->ver_stat;
                $model->ver_date = date('Y-m-d H:i:s');
                $model->save(false); 
                $receipt->save(false);
                
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                return $this->redirect(['kadpekerja/senarai-permohonan']);
                }
        } 
         
        return $this->render('tindakan_tadbir',[
            'dataProvider' => $DataProvider,  
            'model' => $model,
           
        ]);
    }
   
    public function actionTindakanKs($id){
         
        $model = $this->findModel($id);  
         
        $query = Kadpekerja::find()->where(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        
         $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if ($model->load(Yii::$app->request->post())) {
        
            if($model->app_stat == ''){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }
                else{  
                    
                $model->cur_stat = $model->app_stat;
                $model->app_date = date('Y-m-d H:i:s');
                $model->save(false); 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                return $this->redirect(['kadpekerja/senarai-permohonan']);
                }
        } 
         
        return $this->render('tindakan_ketua',[
            'dataProvider' => $DataProvider,  
            'model' => $model,
           
        ]);
    }
    
     public function actionNotifikasi()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
         
        $senarai = Kadpekerja::find()->where(['isActive' => 1, 'app_stat' => 'DILULUSKAN'])->orderBy(['entry_date' => SORT_DESC]); 
        
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
         return $this->render('senarai_notifikasi', [
            'icno' => $icno,
            'senarai' => $senarais,
            'title' => $title,
        ]);
      
    }
    
    public function actionNotify($id){
        
//        $icno = Yii::$app->user->getId();         
        $model = $this->findModel($id);
         
        $query = Kadpekerja::find()->where(['isActive' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if ($model->load(Yii::$app->request->post())) {
            $model->status_kad = 1;
           
            $model->status_semasa = '0';
            if($model->status_kad == ''){ 
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
            }else{       
             $ntf = new Notification();
                  
                $ntf->icno = $model->icno; // pemohon
                            $ntf->title = 'Kad Pekerja';
                            $ntf->content = "Kad Pekerja anda kini sedia untuk diambil di Unit Keselamatan.".Html::a('<i class="fa fa-arrow-right"></i>', ['kadpekerja/semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
            
            $model->save(false); 
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
            return $this->redirect(['kadpekerja/notifikasi']);
            }     
        }
        
        return $this->renderAjax('notify', [
            'model' => $model, 
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
       
    }
    
     public function actionKemaskini($id)
    { 
         
        $model = $this->findAccess($id); 
        $akses = TblAccess::find()->where(['id' => $id])->one();
        
        if ($model->load(Yii::$app->request->post()) && $model->save())
        { 
          
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['kadpekerja/tambah-akses']);
        }
       
        return $this->render('kemaskini_access', [
            'model' => $model,
            'akses' => $akses,
            'bil' => 1,
        ]);
       
      
    } 
    
      public function actionPaymentList()
    {
        $icno=Yii::$app->user->getId();
        $pay = ['KAUNTER', 'DEBIT'];
         
        $senarai = RefPayment::find()->where(['payment' => $pay]);
        
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
         return $this->render('senarai_bayaran', [
            'icno' => $icno,
            'senarai' => $senarais,
            
        ]);
      
    }
    
    public function actionReceipt($id){
        
        $icno = Yii::$app->user->getId();         
        $model = $this->findPayReciept($id);
         
 
        if ($model->load(Yii::$app->request->post())) {
             
            $model->save(false); 
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
            return $this->redirect(['kadpekerja/payment-list']);
              
        }
        
        return $this->renderAjax('payment_receipt', [
            'model' => $model, 
            'bil' => 1,
        ]);
       
    }
     public function actionMenungguKutipan() { //telah membuat bayaran debit
 
          $senarai = Kadpekerja::find()->where(['isActive' => 1, 'payment' => 'FPX'])->andwhere(['status_semasa' => 1])->orderBy(['entry_date' => SORT_DESC]);
          $title = 'Menunggu Penggambilan Kad Pekerja';
          
           $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
           
           isset(Yii::$app->request->queryParams['card_owner'])? $senarais->query->andFilterWhere
        (['like', 'card_owner',  Yii::$app->request->queryParams['card_owner'] ]):'';
        
         isset(Yii::$app->request->queryParams['icno'])? $senarais->query->andFilterWhere
        (['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';
         
          isset(Yii::$app->request->queryParams['card_type'])? $senarais->query->andFilterWhere
        (['like', 'card_type',  Yii::$app->request->queryParams['card_type'] ]):'';
          
          isset(Yii::$app->request->queryParams['card_id'])? $senarais->query->andFilterWhere
        (['like', 'card_id',  Yii::$app->request->queryParams['card_id'] ]):'';
            
        return $this->render('view_pengambilan_kadpekerja', [
            'senarai' => $senarais,
            'title' => $title,
        ]);
    }
    
     public function actionTindakanD($id){
        
        $icno = Yii::$app->user->getId();    
        $kadPekerja = Kadpekerja::findOne(['id' => $id]); 
        $model = new RefStaffCard(); 
        $resit = RefStaffCard::find()->where(['parent_id' => $kadPekerja->id]); 
        $model->updater_dt =  date('Y-m-d H:i:s');
       
        if ($model->load(Yii::$app->request->post())) { 
                            
               $model->ref_icno = $kadPekerja->icno;
               $model->ref_umsper = $kadPekerja->biodata->COOldID;
               $model->mohon_dt = $kadPekerja->entry_date;
               $model->updated_by = $icno; 
               $model->parent_id  = $kadPekerja->id;
               $model->payment = $kadPekerja->payment;
               $kadPekerja->cur_stat ='SELESAI';
               
               $kadPekerja->status_semasa = 0;
               $kadPekerja->save(false);
               $model->save(false);  
               Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
               return $this->redirect(['kadpekerja/menunggu-kutipan']);
           
        } 
         
        return $this->render('view_pembayaran_debit',[
            'kadPekerja' => $kadPekerja, 
            'model' => $model,
            'resit' => $resit,
           
        ]);
    }
     
    public function actionMenungguBayaran() { //telah membuat bayaran debit
 
          $senarai = Kadpekerja::find()->where(['isActive' => 1, 'payment' => 'KAUNTER'])->andwhere(['status_semasa' => 1])->orderBy(['entry_date' => SORT_DESC]);
          $title = 'Menunggu Bayaran Kad Pekerja';
          
          $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
           
           isset(Yii::$app->request->queryParams['card_owner'])? $senarais->query->andFilterWhere
        (['like', 'card_owner',  Yii::$app->request->queryParams['card_owner'] ]):'';
        
         isset(Yii::$app->request->queryParams['icno'])? $senarais->query->andFilterWhere
        (['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';
         
          isset(Yii::$app->request->queryParams['card_type'])? $senarais->query->andFilterWhere
        (['like', 'card_type',  Yii::$app->request->queryParams['card_type'] ]):'';
          
          isset(Yii::$app->request->queryParams['card_id'])? $senarais->query->andFilterWhere
        (['like', 'card_id',  Yii::$app->request->queryParams['card_id'] ]):'';
            
        return $this->render('senarai_bayaran_kaunter', [
            'senarai' => $senarais,
            'title' => $title,
        ]);
    }
     public function actionTindakanK($id){ //bayaran debit menunggu penggambilan kaunter
        
        $icno = Yii::$app->user->getId();     
        $kadPekerja = Kadpekerja::findOne(['id' => $id]); 
        $model = new RefStaffCard(); 
        $resit = RefStaffCard::find()->where(['parent_id' => $kadPekerja->id]); 
        $model->updater_dt =  date('Y-m-d H:i:s');

        if ($model->load(Yii::$app->request->post())) {
          
                            
               $model->ref_icno = $kadPekerja->icno;
               $model->ref_umsper = $kadPekerja->biodata->COOldID;
               $model->mohon_dt = $kadPekerja->entry_date;
               $model->updated_by = $icno;
               $model->updater_dt =  date('Y-m-d H:i:s');
               $model->parent_id  = $kadPekerja->id;
               $model->payment = $kadPekerja->payment;
               $kadPekerja->cur_stat ='SELESAI';
               
               $kadPekerja->status_semasa = 0;
               $kadPekerja->save(false);
               $model->save(false);  
               Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
               return $this->redirect(['kadpekerja/menunggu-bayaran']);
           
        } 
         
        return $this->render('view_pengambilan_kaunter',[
            'kadPekerja' => $kadPekerja, 
            'model' => $model,
            'resit' => $resit,
           
        ]);
    }
    public function actionPermohonanSelesai() { //telah membuat bayaran debit
 
          $senarai = Kadpekerja::find()->where(['isActive' => 1])->andwhere(['status_semasa' => 0])->orderBy(['entry_date' => SORT_DESC]);
          $title = 'Permohonan Kad Pekerja Selesai';
          
           $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
           
           isset(Yii::$app->request->queryParams['card_owner'])? $senarais->query->andFilterWhere
        (['like', 'card_owner',  Yii::$app->request->queryParams['card_owner'] ]):'';
        
         isset(Yii::$app->request->queryParams['icno'])? $senarais->query->andFilterWhere
        (['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';
         
          isset(Yii::$app->request->queryParams['card_type'])? $senarais->query->andFilterWhere
        (['like', 'card_type',  Yii::$app->request->queryParams['card_type'] ]):'';
          
          isset(Yii::$app->request->queryParams['card_id'])? $senarais->query->andFilterWhere
        (['like', 'card_id',  Yii::$app->request->queryParams['card_id'] ]):'';
            
        return $this->render('view_permohonan_selesai', [
            'senarai' => $senarais,
            'title' => $title,
        ]);
    }
     public function actionPaparanSelesai($id){
        
        $icno = Yii::$app->user->getId();  
        $kadPekerja = Kadpekerja::findOne(['id' => $id]); 
        $model = new RefStaffCard(); 
        $resit = RefStaffCard::findOne(['parent_id' => $id]); 
        $model->updater_dt = date('Y-m-d H:i:s');
        
         
        return $this->render('view_selesai',[
            'kadPekerja' => $kadPekerja, 
            'model' => $model,
            'resit' => $resit,
           
        ]);
    }
}
