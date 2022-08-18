<?php

namespace app\controllers;

use Yii;
use app\models\pinjaman\Pinjaman;
use app\models\pinjaman\PinjamanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\Tblprcobiodata;
use app\models\Kemudahan\Refpegawai;
use app\models\Notification;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\models\kemudahan\Tblaccess;
use app\models\vhrms\ViewPayroll;
use app\models\keterhutangan\TblRekod;
use app\models\pinjaman\Refemolumen;
use kartik\mpdf\Pdf;
use app\models\hronline\Tblrscopsnstatus;
use app\models\hronline\tblrscoretireage;
use app\models\gaji\TblStaffRoc;
use app\models\gaji\RefIncomeType;
use app\models\brp\Tblrscobrp;
use yii\filters\AccessControl;

/**
 * PinjamanController implements the CRUD actions for Pinjaman model.
 */
class PinjamanController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
                    'logout' => ['post'],
                    'remove-staff' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Lists all Pinjaman models.
     * @return mixed
     */
    protected function ICNO() {
        return Yii::$app->user->getId();
    }

    protected function findBiodata($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }
    
      protected function gaji() {
        $ma  = date('m');
        $ya = date('Y');
       if (($ma == "1") && $ya){
              $y = date('Y',strtotime("-1 year"));
              $m =  date('m',strtotime("-1 months"));
              $pm = $y.$m;   
       }else{
           $y = date('Y');    
           $m =  date('m',strtotime("-1 month"));
           $pm = $y.$m;   
      }

        return $pm;
    }

    public function actionIndex()
    {
        $searchModel = new PinjamanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
 
    protected function findModel($id)
    {
        if (($model = Pinjaman::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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
    
     public function actionDelete($id)
    {
        $this->findModel($id)->delete();

       return $this->redirect(['admin-index']);
    }
    
    public function actionPermohonan() {
        
        $icno = Yii::$app->user->getId();  
        $biodata = $this->findBiodata($this->ICNO()); 
        $permohonan = new Pinjaman();
        $permohonan->tarikh_mohon = date('Y-m-d H:i:s');
        $default = Refpegawai::find()->one();
        
        $checkApplication = Pinjaman::find()->where(['status_semasa' => 1,'icno' => $icno]);
         if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['pinjaman/senarai']);
        }
        $checkApmt = $this->findBiodata($this->ICNO()); 
        if($checkApmt->statLantikan != 1 && $checkApmt->statLantikan != 3){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan adalah bagi kakitangan yang berstatus tetap atau kontrak pusat sahaja.']);
            return $this->redirect(['pinjaman/senarai']);
        } 
        
        if($permohonan->load(Yii::$app->request->post())){ 
        
        $permohonan->status_semasa = '1';
        $permohonan->isActive = '1';
        $permohonan->icno = $icno;
        $permohonan->status_pt = 'BARU';
        $permohonan->status_pp = 'BARU';
//        if ($permohonan->save()) {
//                $ntf = new Notification();
//                $ntf2 = new Notification();
//                
//                $ntf->icno = $default->pembantu_tadbir; // peg  penyelia perjawatan
//                            $ntf->title = 'Pinjaman Peribadi';
//                            $ntf->content = "Permohonan Pinjaman Peribadi menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['pinjaman/tindakan-jabatan'], ['class'=>'btn btn-primary btn-sm']);
//                            $ntf->ntf_dt = date('Y-m-d H:i:s');
//                            $ntf->save();
//                            
//                $ntf2->icno = $default->pegawai_bsm; // peg  penyelia perjawatan
//                            $ntf2->title = 'Pinjaman Peribadi';
//                            $ntf2->content = "Permohonan Pinjaman Peribadi menunggu tindakan perakuan.".Html::a('<i class="fa fa-arrow-right"></i>', ['pinjaman/tindakan-jabatan'], ['class'=>'btn btn-primary btn-sm']);
//                            $ntf2->ntf_dt = date('Y-m-d H:i:s');
//                            $ntf2->save();
//                           
//       } 
        
        $permohonan->save();
//        $this->notification('Pinjaman Peribadi', 'Permohonan anda telah dihantar untuk diproses sila semak status permohonan anda.'.Html::a('<i class="fa fa-arrow-right"></i>', ['pinjaman/senarai'], ['class'=>'btn btn-primary btn-sm']));
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
        return $this->redirect(['pinjaman/senarai']);
        }
        return $this->render('permohonan', [
                    'model' => $biodata,
                    'permohonan' => $permohonan,
                   
        ]);
    }
    
    public function actionSenarai() {
         
        $icno = Yii::$app->user->getId();  
        $model = new Pinjaman();
        $query = Pinjaman::find()->where(['isActive' => 1,])->andWhere(['icno' => $icno ])->orderBy(['tarikh_mohon' => SORT_DESC]);
        
        $dataProvider =  new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('senarai_pemohon', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                  
        ]);
    }
    
    public function actionTindakanJabatan()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai  = '';
 
        if(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [1,5]])->exists()){                            
            
            $senarai = Pinjaman::find()->where(['isActive' => 1,])->orderBy(['tarikh_mohon' => SORT_DESC]);
            $title='Senarai Menunggu Semakan';
            
        }
        elseif(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [2,5]])->exists()){
            
            $senarai = Pinjaman::find()->where(['isActive' => 1,])->orderBy(['tarikh_mohon' => SORT_DESC]);
            $title ='Senarai Menunggu Perakuan';
            
        }
        
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
           
        if($title != NULL){ 
        return $this->render('senarai_tindakan', [
            'icno' => $icno,
            'senarai' => $senarais,
            'title' => $title,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['kemudahan/index']);}  
    }
    
    public function actionTindakanPtBsm($id, $icno)
    {
        $ic = Yii::$app->user->getId();         
        $model = $this->findModel($id);
       
        $staf = TblRekod::find()->where(['icno' =>$model->icno])->one(); 
   
        if($model  && !$staf ){
            
              $sesi_start = '';
              $sesi_end =  ''; 
        }
 
        elseif($model->icno == $staf->icno && $staf->sesi == 1 ){

              $sesi_start = $staf->tahun."01";
              $sesi_end = $staf->tahun."06";
        }
       elseif($model->icno == $staf->icno && $staf->sesi == 2 ){
              $sesi_start = $staf->tahun."07";
              $sesi_end = $staf->tahun."12";
        }
        
        
       $data = ViewPayroll::find()
                    ->select(['*'])
                   ->where(['between', 'CAST(MPH_PAY_MONTH AS INT)', $sesi_start, $sesi_end])
                   ->andWhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                   ->andWhere(['!=', 'MPH_TOTAL_DEDUCTION', 0])
                   ->andWhere(['!=', 'MPH_TOTAL_ALLOWANCE', 0])
                   ->andWhere('(MPH_TOTAL_DEDUCTION/MPH_TOTAL_ALLOWANCE*100) > 40')
                   ->andWhere(['sm_ic_no' => $icno])
                   ->orderBy(['MPH_PAY_MONTH'=>SORT_ASC])
                   ->all ();
        
        $searchModel = new PinjamanSearch();
        $query = Pinjaman::find()->where(['isActive' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $model->datetime_pt = date('Y-m-d H:i:s');
        
         if(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [3,4]])->exists()){              
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
             return $this->redirect(['pinjaman/senarai']);
        }         
        if ($model->load(Yii::$app->request->post())) {
             $emolumen = new Refemolumen();
             $rekod = TblRekod::find()->where(['icno' =>$model->icno]); 
             if($rekod->exists()){
                $emolumen->parent_id = $id; 
                $emolumen->icno = $icno;
                $emolumen->sesi = $staf->sesi;
                $emolumen->tahun = $staf->tahun;
                $emolumen->emolumen_date = date('Y-m-d H:i:s');
                $emolumen->save(false);
             }else{
                $emolumen->parent_id = $id; 
                $emolumen->icno = $icno;
                $emolumen->sesi = $sesi_start;
                $emolumen->tahun = $sesi_end;
                $emolumen->emolumen_date = date('Y-m-d H:i:s');
                $emolumen->save(false);
             }
              
            if($model->status_pt == ''){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
            }  
            elseif($model->status_pt == 'SEMAKAN LAYAK' ){
                $model->status_pp = 'SEMAKAN LAYAK'; 
                $model->semakan_by = $ic; 
                $model->save(false);  
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                return $this->redirect(['pinjaman/tindakan-jabatan']);
            }
            elseif($model->status_pt == 'SEMAKAN TIDAK LAYAK'){
                $model->status_pp = 'SEMAKAN TIDAK LAYAK';  
                $model->semakan_by = $ic;
                $model->save(false); 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                return $this->redirect(['pinjaman/tindakan-jabatan']);
                }
//                else{ 
//                $model->save(false); 
//                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
//                return $this->redirect(['pinjaman/tindakan-jabatan']);
//                
//                }
        }
        return $this->render('tindakan_pt', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'staf' => $staf,
            'data' => $data,
          
        ]);
       
    } 
    
    public function actionTindakanPpBsm($id, $icno)
    {

        $model = $this->findModel($id); 
        $ic = Yii::$app->user->getId();
        $staf = TblRekod::find()->where(['icno' =>$model->icno])->one(); 
  
        if($model  && !$staf ){
            
              $sesi_start = "01";
              $sesi_end =  "06"; 
        }
 
        elseif($model->icno == $staf->icno && $staf->sesi == 1 ){

              $sesi_start = $staf->tahun."01";
              $sesi_end = $staf->tahun."06";
        }
       elseif($model->icno == $staf->icno && $staf->sesi == 2 ){
              $sesi_start = $staf->tahun."07";
              $sesi_end = $staf->tahun."12";
        }
        
        
        $data = ViewPayroll::find()
                    ->select(['*'])
                    ->where(['between', 'CAST(MPH_PAY_MONTH AS INT)', $sesi_start, $sesi_end]) 
                   ->andWhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                   ->andWhere(['!=', 'MPH_TOTAL_DEDUCTION', 0])
                   ->andWhere(['!=', 'MPH_TOTAL_ALLOWANCE', 0])
                   ->andWhere('(MPH_TOTAL_DEDUCTION/MPH_TOTAL_ALLOWANCE*100) > 40')
                   ->andWhere(['sm_ic_no' => $icno])
                   ->orderBy(['MPH_PAY_MONTH'=>SORT_ASC])
                   ->all();
        
        $searchModel = new PinjamanSearch();
        $query = Pinjaman::find()->where(['isActive' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         
         if(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [4]])->exists()){              
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
             return $this->redirect(['pinjaman/senarai']);
        }
        if ($model->load(Yii::$app->request->post())) {
 
            $model->stat_surat = 0;
            
            if($model->status_pp == ''){
                
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
            }
            elseif($model->status_pp == 'TIDAK DIPERAKUI'){
                
               
//                $ntf2 = new Notification(); 
//
//                $ntf2->icno = $model->icno; // pemohon
//                $ntf2->title = 'Pinjaman Peribadi';
//                $ntf2->content = "Permohonan Pinjaman Peribadi anda tidak diluluskan.".Html::a('<i class="fa fa-arrow-right"></i>', ['pinjaman/senarai'], ['class'=>'btn btn-primary btn-sm']);
//                $ntf2->ntf_dt = date('Y-m-d H:i:s');
//                $ntf2->save();     
                $model->peraku_by = $ic;
                $model->save(false);   
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                return $this->redirect(['pinjaman/tindakan-jabatan']);
                
            } else{
//               $ntf = new Notification();
//                       
//            $ntf->icno = $model->icno; // pemohon
//                            $ntf->title = 'Pinjaman Peribadi';
//                            $ntf->content = "Permohonan Pinjaman Peribadi anda telah diluluskan, surat pinjaman peribadi sedang dijana untuk tindakan selanjutnya.".Html::a('<i class="fa fa-arrow-right"></i>', ['pinjaman/senarai'], ['class'=>'btn btn-primary btn-sm']);
//                            $ntf->ntf_dt = date('Y-m-d H:i:s');
//                            $ntf->save(); 
 
            $model->peraku_by = $ic;                
            $model->save(false);   
            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
            return $this->redirect(['pinjaman/tindakan-jabatan']);  
            }
//           
            } 
         
        return $this->render('tindakan_pp', [
            'data' => $data, 
            'staf' => $staf,
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
        ]);
        
       
    } 
 
    
    public function actionTindakanTadbir()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai  = '';
 
        if(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [1,5]])->exists()){                            
            
            $senarai = Pinjaman::find()->where(['isActive' => 1,])->andWhere(['status_pp' => 'DIPERAKUI'])->orderBy(['tarikh_mohon' => SORT_DESC]);
            $title= 'Status Surat';
            
        }
         
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
           
        if($title != NULL){ 
        return $this->render('permohonan_lulus', [
            'icno' => $icno,
            'senarai' => $senarais,
            'title' => $title,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['kemudahan/index']);}  
    }
    
    public function actionStatusSurat($id){
        
        $icno = Yii::$app->user->getId();         
        $model = $this->findModel($id);
        
        
        $searchModel = new PinjamanSearch();
        $query = Pinjaman::find()->where(['isActive' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if ($model->load(Yii::$app->request->post())) {
            $model->stat_surat = 1;
            $model->status_semasa = '0';
            if($model->stat_surat == ''){
                
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }                  
                else{ 
//                $ntf = new Notification();
//                 
//                
//                $ntf->icno = $model->icno; // pemohon
//                            $ntf->title = 'Pinjaman Peribadi';
//                            $ntf->content = "Surat pinjaman peribadi anda kini sedia untuk diambil.".Html::a('<i class="fa fa-arrow-right"></i>', ['pinjaman/senarai'], ['class'=>'btn btn-primary btn-sm']);
//                            $ntf->ntf_dt = date('Y-m-d H:i:s');
//                            $ntf->save();
                            
                
                $model->save(false); 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                return $this->redirect(['pinjaman/tindakan-tadbir']);
                
                }
        }
         
         
        return $this->renderAjax('stat_surat', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
       
    }
    
    public function actionRekodSurat($id){
        
        $icno = Yii::$app->user->getId();         
        $model = $this->findModel($id);
        $model->tarikh_diambil = date('Y-m-d H:i:s');
      
        
        $searchModel = new PinjamanSearch();
        $query = Pinjaman::find()->where(['isActive' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if ($model->load(Yii::$app->request->post())) {
            
 
             $model->save(false); 
             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
             return $this->redirect(['pinjaman/tindakan-tadbir']);
        }
          
        return $this->renderAjax('rekod_surat', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider, 
            'bil' => 1,
        ]);
       
    }
    public function actionAdminIndex($carian_icno = null) {
       
         
        $carian = $carian_icno; 
              
        $model = new Pinjaman();
        if($carian != null){
        $query =  Pinjaman::find()->where(['icno' => $carian]) ->andWhere(['isActive' => 1])->orderBy(['tarikh_mohon' => SORT_ASC]);

        }else{
        $query = Pinjaman::find()->where(['isActive' => 1])->orderBy(['tarikh_mohon' => SORT_ASC]);
        }

            
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
            
            'pagination' => [
                'pageSize' => 20,
            ],
        ]); 
       
        return $this->render('admin_index', [
           'dataProvider' => $DataProvider, 
           'model' => $model,
           'carian_icno' => $carian,

            ]); 
    } 
    public function actionDetailView($id, $icno)
    {
//        $icno = Yii::$app->user->getId();
         
        $model = $this->findModel($id);
       
        $staf = TblRekod::find()->where(['icno' =>$model->icno])->one(); 
  
        if($model  && !$staf ){
            
              $sesi_start = "01";
              $sesi_end =  "06"; 
        }
 
        elseif($model->icno == $staf->icno && $staf->sesi == 1 ){

              $sesi_start = $staf->tahun."01";
              $sesi_end = $staf->tahun."06";
        }
       elseif($model->icno == $staf->icno && $staf->sesi == 2 ){
              $sesi_start = $staf->tahun."07";
              $sesi_end = $staf->tahun."12";
        }
        
        
        $data = ViewPayroll::find()
                    ->select(['*'])
                    ->where(['between', 'CAST(MPH_PAY_MONTH AS INT)', $sesi_start, $sesi_end]) 
                   ->andWhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                   ->andWhere(['!=', 'MPH_TOTAL_DEDUCTION', 0])
                   ->andWhere(['!=', 'MPH_TOTAL_ALLOWANCE', 0])
                   ->andWhere('(MPH_TOTAL_DEDUCTION/MPH_TOTAL_ALLOWANCE*100) > 40')
                   ->andWhere(['sm_ic_no' => $icno])
                   ->orderBy(['MPH_PAY_MONTH'=>SORT_ASC])
                   ->all();
        
        $searchModel = new PinjamanSearch();
        $query = Pinjaman::find()->where(['isActive' => 1]) ->andWhere(['icno' => $model])->orderBy(['tarikh_mohon' => SORT_DESC]);
 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         
 
        if ($model->load(Yii::$app->request->post())) {
            
        }
        return $this->render('detail_view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'staf' => $staf,
            'data' => $data,
        ]);
       
    } 
    public function actionLaporanAdmin() {
           
        $request = Yii::$app->request;
     
        if($request->get('tahun')){

             $sesi = $request->get('sesi');
             $tahun = $request->get('tahun');

             if($sesi == 1){
                 $sesi_start = $tahun."01";
                 $sesi_end = $tahun."06";

             }else{
                 $sesi_start = $tahun."07";
                 $sesi_end = $tahun."12";

             }

         }else{
             $tahun = "2015";
             $sesi_start = $tahun."01";
             $sesi_end = $tahun."06";
        }
    
        
   
         $permohonan = $this->SenaraiRekod($sesi_start, $sesi_end);
         $search = new Tblprcobiodata();

         return $this->render('laporan-admin', [
                      'permohonan' => $permohonan,
                     'search' => $search,
         ]);
     }
     public function SenaraiRekod(string $start, string $end) {
          
           
        $name = Yii::$app->request->get('ICNO');
        
     
       if($name == '' || $name == null){
           
           $data = new ActiveDataProvider([
         'query' => ViewPayroll::find()
                 ->select([
                    'sm_ic_no',
                     'COUNT(*) as cnt'
                    ])

                ->where(['between', 'CAST(MPH_PAY_MONTH AS INT)', $start, $end])
                ->andWhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                ->andWhere(['>', 'MPH_TOTAL_DEDUCTION', 0])
                ->andWhere(['>', 'MPH_TOTAL_ALLOWANCE', 0])
                ->andWhere('(MPH_TOTAL_DEDUCTION/MPH_TOTAL_ALLOWANCE*100) > 60')
                ->having(['>=', 'COUNT(MPH_PAY_MONTH)', 6])
                ->orderBy(['sm_ic_no'=>SORT_ASC])
                ->groupBy(['sm_ic_no']),
         
         'pagination' => [
             'pageSize' => 100,
         ],
     ]);
           
       }
       else{
           
           $data = new ActiveDataProvider([
         'query' => ViewPayroll::find()
                 ->select([
                    'sm_ic_no',
                     'COUNT(*) as cnt'
                    ])

                ->with('kakitangan')
                ->where(['between', 'CAST(MPH_PAY_MONTH AS INT)', $start, $end])
                ->andWhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                ->andWhere(['>', 'MPH_TOTAL_DEDUCTION', 0])
                ->andWhere(['>', 'MPH_TOTAL_ALLOWANCE', 0])
                ->andWhere('(MPH_TOTAL_DEDUCTION/MPH_TOTAL_ALLOWANCE*100) > 60')
                   ->andWhere(['=', 'sm_ic_no', $name])
                ->having(['>=', 'COUNT(MPH_PAY_MONTH)', 6])
                ->orderBy(['sm_ic_no'=>SORT_ASC])
                ->groupBy(['sm_ic_no']),
         
         'pagination' => [
             'pageSize' => 100,
         ],
     ]);
           
       }
     
     
     return $data;
 }
  public function actionDetailViewPayroll($id, $icno){  
      
        $model = $this->findModel($id);
 
        $payroll = ViewPayroll::find()->where(['sm_ic_no' => $icno])->one();
        $staf = TblRekod::find()->where(['icno' =>$icno])->one();
        if($staf->sesi == 1){
            $sesi_start = $staf->tahun."01";
            $sesi_end = $staf->tahun."06";

        }else{
            $sesi_start = $staf->tahun."07";
            $sesi_end = $staf->tahun."12";

        }

        $data = ViewPayroll::find()
                    ->select(['*'])
                   ->where(['between', 'CAST(MPH_PAY_MONTH AS INT)', $sesi_start, $sesi_end])
                   ->andWhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                   ->andWhere(['!=', 'MPH_TOTAL_DEDUCTION', 0])
                   ->andWhere(['!=', 'MPH_TOTAL_ALLOWANCE', 0])
                   ->andWhere('(MPH_TOTAL_DEDUCTION/MPH_TOTAL_ALLOWANCE*100) > 60')
                   ->andWhere(['sm_ic_no' => $icno])
                   ->orderBy(['MPH_PAY_MONTH'=>SORT_ASC])
                   ->all();
        $searchModel = new PinjamanSearch();
        $query = Pinjaman::find()->where(['tbl_permohonan.icno' => $model])->orderBy(['tbl_permohonan.tarikh_mohon' => SORT_DESC]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('detail-view-payroll', [
            'data' => $data, 
            'staf' => $staf,
            'payroll' => $payroll,
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
        ]);
    }
   

    public function actionPengesahan($id, $icno, $umsper)
        {  
//            $css = file_get_contents('./css/surat.css');
            #cehck application
            $model = $this->findModel($id);
            $bio = Tblprcobiodata::findOne(['COOldID' => $umsper]);
//            $gaji2 = Tblrscobrp::find()->where(['icno' => $model->ICNO])->orderBy(['tarikh_mulai' => SORT_DESC])->all();

   
            $gaji = $this->gaji();
            $elaun = 'B1000';
 
           $data = ViewPayroll::find()
                    ->select(['*'])
                   ->where(['MPH_PAY_MONTH'=> $gaji])
                   ->andwhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                   ->andWhere(['!=', 'MPH_TOTAL_DEDUCTION', 0])
                   ->andWhere(['!=', 'MPH_TOTAL_ALLOWANCE', 0]) 
                   ->andWhere(['sm_ic_no' => $icno])
                   ->orderBy(['MPH_PAY_MONTH'=>SORT_ASC])
                   ->all();
 
            
             $max = TblStaffRoc::find()
            ->select(['SR_ROC_TYPE, max(SR_ENTER_DATE) as SR_ENTER_DATE'])
            ->where(['SR_STAFF_ID' => $umsper])
            ->groupBy('SR_ROC_TYPE');
            
             $allowance =  RefIncomeType::find()
                     ->select('it_trans_type', 'it_income_code')
                     ->where(['it_trans_type' => 'ALLOWANCE'])
                     ->andwhere(['not in','it_income_code', $elaun]);
             
            $query = TblStaffRoc::find()
            ->innerJoin(['b' => $max], 'b.SR_ROC_TYPE = hrm.gaji_staff_roc.SR_ROC_TYPE AND b.SR_ENTER_DATE = hrm.gaji_staff_roc.SR_ENTER_DATE')
            ->where(['SR_STAFF_ID' => $umsper, 'SR_DATE_TO' => null]) 
            ->andWhere(['b.SR_ROC_TYPE' => $allowance])
            ->orderBy(['SR_ENTER_DATE' => SORT_DESC, 'SR_ROC_TYPE' => SORT_ASC]);
            
             $sum = $query->sum('SR_NEW_VALUE');
 
             $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);


            $biodata = $this->findBiodata($icno);  
            $pinjaman = Pinjaman::find()->where(['icno' => $model])->andWhere(['id' =>  $id])->one(); 
            $content = $this->renderPartial('jana_pengesahan', ['data' => $data,'elaun' => $elaun,'sum' => $sum,'dataProvider' => $dataProvider, 'bio' => $bio,'pinjaman'=> $pinjaman, 'gaji' => $biodata, 'pension' => $this->findModelbyicno($icno), 'ICNO' => $icno ]);
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
                'options' => ['title' => 'Pengesahan Gaji Kakitangan'],
                // call mPDF methods on the fly
                  'marginTop' => 12,
    //             'marginBottom' => 35,
                'marginLeft' => 20,
                'marginRight' => 18,
                'methods' => [
                'SetHeader' => [''],
//                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
//                'WriteHTML' => [$css, 1]
    //          'SetFooter' => [' {PAGENO}'],
                ]
            ]);
            // return the pdf output as per the destination setting
            return $pdf->render();
        }
        
        public function actionPengesahan2($id, $icno, $umsper)
        {  
//            $css = file_get_contents('./css/surat.css');
            #cehck application
            $model = $this->findModel($id);
            $biodata = $this->findBiodata($icno);  
            
            $bio = Tblprcobiodata::findOne(['COOldID' => $umsper]);
            $elaun = 'B1000';
            $gaji = $this->gaji();
             
            $data = ViewPayroll::find()
                    ->select(['*'])
                   ->where(['MPH_PAY_MONTH'=> $gaji])
                   ->andwhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                   ->andWhere(['!=', 'MPH_TOTAL_DEDUCTION', 0])
                   ->andWhere(['!=', 'MPH_TOTAL_ALLOWANCE', 0]) 
                   ->andWhere(['sm_ic_no' => $icno])
                   ->orderBy(['MPH_PAY_MONTH'=>SORT_ASC])
                   ->all();
             $max = TblStaffRoc::find()
            ->select(['SR_ROC_TYPE, max(SR_ENTER_DATE) as SR_ENTER_DATE'])
            ->where(['SR_STAFF_ID' => $umsper])
            ->groupBy('SR_ROC_TYPE');
            
             $allowance =  RefIncomeType::find()
                     ->select('it_trans_type', 'it_income_code')
                     ->where(['it_trans_type' => 'ALLOWANCE'])
                     ->andwhere(['not in','it_income_code', $elaun]);
             
            $query = TblStaffRoc::find()
            ->innerJoin(['b' => $max], 'b.SR_ROC_TYPE = hrm.gaji_staff_roc.SR_ROC_TYPE AND b.SR_ENTER_DATE = hrm.gaji_staff_roc.SR_ENTER_DATE')
            ->where(['SR_STAFF_ID' => $umsper, 'SR_DATE_TO' => null]) 
            ->andWhere(['b.SR_ROC_TYPE' => $allowance])
            ->orderBy(['SR_ENTER_DATE' => SORT_DESC, 'SR_ROC_TYPE' => SORT_ASC]);
            
             $sum = $query->sum('SR_NEW_VALUE');
 
             $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            ]);
             
            $pinjaman = Pinjaman::find()->where(['icno' => $model])->andWhere(['id' =>  $id])->one(); 
            $content = $this->renderPartial('pengesahan2', ['data' => $data,'elaun' => $elaun,'sum' => $sum,'dataProvider' => $dataProvider, 'bio' => $bio, 'pinjaman'=> $pinjaman, 'gaji' => $biodata, 'pension' => $this->findModelbyicno($icno), 'ICNO' => $icno ]);
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
                'options' => ['title' => 'Pengesahan Gaji Kakitangan'],
                // call mPDF methods on the fly
                  'marginTop' => 12,
    //             'marginBottom' => 35,
                'marginLeft' => 20,
                'marginRight' => 18,
                'methods' => [
                'SetHeader' => [''],
//                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
//                'WriteHTML' => [$css, 1]
    //          'SetFooter' => [' {PAGENO}'],
                ]
            ]);
            // return the pdf output as per the destination setting
            return $pdf->render();
        }
        
         protected function findModelbyicno($icno) {
        if (($model = Tblrscoretireage::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
 