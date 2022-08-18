<?php
namespace app\controllers;
use yii\data\ActiveDataProvider;
use app\models\ptb\ApplicationSearch;
use yii\filters\AccessControl;
use app\models\hronline\Tblprcobiodata;
use app\models\Notification;
use app\models\ptb\Letter;
use app\models\ptb\Recommendation;
use app\models\hronline\Campus;
use app\models\ptb\TblUrusMesyuarat;
use kartik\mpdf\Pdf;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;
use app\models\ptb\TblTugas;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use yii\web\NotFoundHttpException;
use app\models\hronline\TblPenempatan;
USE app\models\hronline\State;
use app\models\cuti\SetPegawai;
use app\models\ptb\Application;
use app\models\ptb\Option;
use app\models\ptb\TblAdmin;
use app\models\ptb\TblSerahTugasSearch;
use app\models\ptb\Model;
use app\models\ptb\RefJustifikasi;
use app\models\ptb\TblAhliMesyuarat;
use app\models\ptb\TblPbpu;
use app\models\ptb\TblSerahTugas;
use DateTime;
use app\models\myportfolio\TblTugasUtama;
use app\models\myportfolio\TblAkauntabiliti;
use app\models\myportfolio\TblPortfolio;
use app\models\myportfolio\TblPortfolioSearch;
use app\models\myportfolio\TblDimensi;
use app\models\myportfolio\TblIkhtisas;
use app\models\myportfolio\TblKompetensi;
use app\models\myportfolio\TblPengalaman;
use app\models\lppums\Lpp;
error_reporting(0);
class PtbController extends Controller
{
      public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'timein', 'timeout'],
                'rules' => [
                        [
                        'actions' => ['index', 'index', 'create', 'multiple', 'multiple-bsm'],
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

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    private function auth(){
        //the current user identity. `null` if the user is not authenticated.
        return $identity = Yii::$app->user->identity;
    }

    private function pelulusICNO()
    {
         // this is how to get values from params.php 
         return Yii::$app->params['pelulusICNO'];
    }
    public function notification($title, $content, $ic = null)
    {
        if($ic == null){
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
    
    
      public function actionSejarahPenempatan(){     
       #past 5 years
       $past = new DateTime('-5 years');
       $past_5 = strtotime($past->format('Y-m-d'));
        
       $carian = new Tblprcobiodata();
       $dataProvider = $carian->carian2(Yii::$app->request->queryParams);
       
        return $this->render('sejarah-penempatan', ['past_5' => $past_5,'carian' => $carian, 'model' => $dataProvider]);
    }

    public function actionNota()
    {
        $searchModel = new TblSerahTugasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider1 = TblTugas::find()->where(['icno' => Yii::$app->user->getId()])->max('id');
        $dataProvider->query->andWhere(['icno' => Yii::$app->user->getId(), 'tugas_id' => $dataProvider1]);
        
        $icno = Yii::$app->user->getId();
        $lihatNota = TblTugas::find()->where(['icno' => $icno])->all();//cari semua mesyuarat
        $peg1 = TblTugas::find()->where(['icno' => $icno])->max('id');
        $peg = TblTugas::find()->where(['id' => $peg1])->one()->old_dept;
        $depart = Department::find()->where(['id' => $peg])->one();
        
        return $this->render('nota', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'lihatNota' => $lihatNota,
            'peg' => $peg,
            'depart' => $depart,
        ]);
    }
    
    public function actionView($id)
    { 
           $model = TblSerahTugas::find()->where(['id' => $id])->one();
           return $this->render('view', [
            'model' => $model,
               
        ]);
    }
    
    public function actionDelete($id)
    {   
        $this->findModel($id)->delete();
        return $this->redirect(['nota']);
            
    }
   
    public function actionCreate(){
        $model = new TblSerahTugas();
        $model->icno = $this->auth()->ICNO;
        $check = TblTugas::find()->where(['icno' => $model->icno])->max('id');
        $checkApplication = TblTugas::find()->where(['nota_sent' => 1, 'status' => 4 , 'id' => $check]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Surat Sudah Dihantar']);
            return $this->redirect(['ptb/nota']);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            
                            if(TblTugas::find()->where(['icno' => $this->auth()->getId(), 'nota_sent' => 0 ])->exists()){
                            $tugas1=TblTugas::find()->where(['icno' =>$this->auth()->getId()])->max('id');
                            $tugas=TblTugas::find()->where(['id' => $tugas1])->one();
                            }
                            else{
                            $tugas = new TblTugas();
                            $tugas->icno = $this->auth()->getId();
                            $tugas->pemohon_name = $this->auth()->CONm;
                            $tugas->save();  
                            }
                            

                             #update serah tugas tugas_id;
                            $model->tugas_id = $tugas->id;
                          
            $model->save(false);
            
             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Disimpan']);  
   
            return $this->redirect(['nota', 'id' => $model->id]);
        }
     return $this->render('create', ['model' => $model]);
    }
    
    public function actionUpdate($id)
     {      
        $model = TblSerahTugas::find()->where(['id' => $id])->one();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Dikemaskini']); 
            return $this->redirect(['nota', 'id' => $model->id]);
        } return $this->render('update', ['model'=>$model]);
        }
   
        protected function findModel($id)
    {
        if (($model = TblSerahTugas::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionIndex()
    {
        $icno = Yii::$app->user->getId();
        $applications = Application::find()->where(['icno' => $icno])->all();
        if(Application::find()->where(['icno' => $icno, 'type_id' => [2,3], 'status' => [4,5,0]])->exists() || Application::find()->where(['icno' => $icno, 'type_id' => 1])->exists()){
            $display='';   
       
        }else{  
           $display = 'none';
            
        }
        return $this->render('index',['applications'=>$applications, 'display' => $display]); 
    }
    
     public function actionSenaraiMenungguSetuju()
    {
        $icno = Yii::$app->user->getId();
        $setujuList = Recommendation::find()->with('application.applicant')->where([ 'icno' => $icno, 'type'=>1])->all();
        return $this->render('senarai-menunggu-setuju', ['setujuList'=>$setujuList]);
    }
    
    public function actionSenaraiKelulusanPtb()
    {
      
        $query= Application::find()->andFilterWhere(['like', 'status','4']);
           $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  10
           ],
            
       ]);
           
        return $this->render('senarai-kelulusan-ptb',['provider' => $provider]);
    }
    public function actionSenaraiMenungguPeraku()
     {
           $icno = Yii::$app->user->getId();
           $perakuList = Recommendation::find()->with('application.applicant')->where([ 'icno' => $icno, 'type'=>2])->all(); 
          
           return $this->render('senarai-menunggu-peraku', ['perakuList'=>$perakuList]);
    }

    public function actionSenaraiMenungguPelulus()
    {
        
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::find()->where(['icno' => $icno])->one();
       #semua staff gred 45 ada akses
        if($icno != Yii::$app->params['pelulusICNO'] && !$model && Yii::$app->user->getIdentity()->gredJawatan != 6  && Yii::$app->user->getIdentity()->gredJawatan != 2  ){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        }   
        
        $query= Recommendation::find()->with('application.applicant')->with('application.letter')->where(['type'=>3]);
           $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  10
           ],
            
       ]);
        return $this->render('senarai-menunggu-pelulus',['provider' => $provider]);
    }
    
      public function actionSenaraiPpp()
    {
           $icno = Yii::$app->user->getId();
           $query= Application::find()->where(['ppp_icno' => $icno])->with('pensetuju');
           $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  10
           ],
            
       ]);
        return $this->render('senarai-ppp', ['provider'=>$provider]);
    }
    
      public function actionLaporDiri(){ 
        $icno = $this->auth()->getId();
        $model = Department::findOne(['chief' => $icno]);

        if(!$model){

            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        }
            $request = Yii::$app->request;
            $id = $request->get('id');
            $app = Application::findOne($id);
            $jabatan = Department::findOne(['chief' => Yii::$app->user->getId()]);
            $lapor = Application::findAll(['approved_dept' => $jabatan->id, 'status' => [4]]);
            return $this->render('lapor-diri', ['lapor'=>$lapor, 'app' => $app]);   
    }
       public function actionSalinanSuratDitolak(){ 
        $icno = $this->auth()->getId();
        $model = Department::findOne(['chief' => $icno]);

        if(!$model){

            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        } 
           // $request = Yii::$app->request;
            $id = Yii::$app->request->get('id');
            $app = Application::findOne($id);
            $jabatan = Department::findOne(['chief' => Yii::$app->user->getId()]);
            $lapors = Application::find()->where(['new_dept' => $jabatan->id, 'status' => [5]])->orWhere(['old_dept' => $jabatan->id, 'status' => [4,5]])->all();
                   
                   
            return $this->render('salinan-surat-ditolak', ['app' => $app, 'lapors' => $lapors]);   
    }

         public function actionSenaraiNota() { 
        $icno = $this->auth()->getId();
        $model = Department::findOne(['chief' => $icno]);

        if(!$model){

            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        }
         $jabatan = Department::findOne(['chief' => Yii::$app->user->getId()]);
         $belum_selesai = TblTugas::find()->where(['old_dept' => $jabatan->id])->all();
                   if($belum_selesai->pengganti_ICNO != null){
                   Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Sudah Diambil Tindakan']);
                   return $this->redirect(['ptb/senarai-nota']);
             }
            return $this->render('senarai-nota', ['belum_selesai'=>$belum_selesai]);
    }
 
       public function actionTindakanLaporDiri(){
        
        $request = Yii::$app->request;
        $id = $request->get('id');
        $allBiodatas =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        $tindakanLapor = Application::findOne($id);
          
       if ($tindakanLapor->load(Yii::$app->request->post())) {
           $Application = $request->post()['Application'];
            $lapor = $Application['lapor'];
            $tarikh_lapor = date_format(date_create($request->post('tarikh_lapor')), 'Y-m-d');
            $tindakanLapor->tarikh_lapor = $tarikh_lapor;
            $tindakanLapor->lapor = $lapor;
            $tindakanLapor->tarikh_lapor = $tarikh_lapor;
          
          
            if($tindakanLapor->save()){
                    #get setPegawai pemohon
                    $setPegawaiApp = SetPegawai::find()->where(['pemohon_icno' => $tindakanLapor->icno])->one();
         
                    //----------update table biodata pemohon---------//
                    $biodataApps = Tblprcobiodata::findOne($tindakanLapor->icno);
                    $biodataApps->ICNO = $tindakanLapor->icno;
                    $biodataApps->DeptId = $tindakanLapor->approved_dept;
                    $biodataApps->last_update = date('Y-m-d H:i:s');
                    $biodataApps->last_updater = Yii::$app->user->identity->getId();
                    $biodataApps->save(false);
                    //----------update table biodata pemohon---------//
                    
                      #update setPegawai for pemohon
                    $newDeptApp = Department::findOne($tindakanLapor->approved_dept);
                    $setPegawaiApp->pelulus_icno = $newDeptApp->chief;
                    $setPegawaiApp->save(false);
    
                      //----------move data from tbl application to tbl penempatan in hronline---------//
                    $newPenempatan = new TblPenempatan();
                    $newPenempatan->ICNO = $tindakanLapor->icno;
                    $newPenempatan->date_start = $tindakanLapor->tarikh_lapor;
                    $newPenempatan->campus_id = $tindakanLapor->campus_id;
                    $newPenempatan->dept_id = $tindakanLapor->approved_dept;
                    $newPenempatan->remark  = $tindakanLapor->pelulus->notes;
                    $newPenempatan->date_update = date('Y-m-d H:i:s');
                    $newPenempatan->update_by = Yii::$app->user->identity->getId();
                    $newPenempatan->date_letter_order = $tindakanLapor->effective_date;
                    $newPenempatan->reason_id = $tindakanLapor->justifikasi;
                    $newPenempatan->letter_refno = $tindakanLapor->letter_reference;
                    $newPenempatan->save();
                    //----------move data from tbl application to tbl penempatan in hronline---------//
               
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya']);
           }else{
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Tiada']);
           }            
            return $this->redirect(['ptb/lapor-diri']);
       }
       
       if($tindakanLapor->lapor == '1'){
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Selesai Lapor Diri']);
                 return $this->redirect(['ptb/lapor-diri']);
             
             }

              return $this->render('tindakan-lapor-diri', [
            'tindakanLapor' => $tindakanLapor , 'allbiodatas' => $allBiodatas,]);   
             
 }
    public function actionSerahTugasBos(){

        $request = Yii::$app->request;
        $id = $request->get('id');
        $dept_id = Yii::$app->user->identity->DeptId;    
        $allBiodata =  ArrayHelper::map(Tblprcobiodata::find()->where(['DeptId'=>$dept_id])->all(), 'ICNO', 'CONm');
        $tugas = TblTugas::findOne($id);
        if($tugas->pengganti_ICNO != null){
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Sudah Diambil Tindakan']);
                 return $this->redirect(['ptb/senarai-nota']);
             }
       if ($tugas->load(Yii::$app->request->post())) {
           $TblTugas = $request->post()['TblTugas'];
           $icno = $TblTugas['pengganti_ICNO'];
           $nama = $allBiodata[$icno];
           $tugas->nama_pengganti = $nama;
           $tugas->update = date('Y-m-d H:i:s');
       
           if($tugas->save()){

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Ditambah!']);
                $this->notification('Nota Serah Tugas', 'Sila semak senarai nota serah tugas anda.'.Html::a('Klik Sini', ['ptb/nota-pengganti'],['class' => 'label label-info']), $icno);
   
                return $this->redirect(['ptb/senarai-nota']);

           }
           
       }
            return $this->render('serah-tugas-bos', [
            'tugas' => $tugas,
            'allBiodata' => $allBiodata

        ]);
             
    }
    
      public function actionSerahTugasIndividu($id){
        $allBiodata =  ArrayHelper::map(Department::find()->all(), 'id', 'chiefBiodata.CONm');
        $tugas = TblTugas::findOne($id);
        $depart = Department::find()->where(['id' => $tugas->old_dept])->one();
        
           if($tugas->nota_sent == '1'){
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Selesai Diambil Tindakan']);
                return $this->redirect(['ptb/nota']);
             
             }
    
       if ($tugas->load(Yii::$app->request->post())) {
  
                          $tugas->nota_sent = '1';
                          $tugas->tarikh_individu_hantar = date('Y-m-d H:i:s');
                          
            $tugas->save();

             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar']);
             $this->notification('Nota Serah Tugas', 'Nota Serah Tugas Baru untuk Disemak'.Html::a('Klik Sini', ['ptb/senarai-nota'],['class' => 'label label-info']), $depart->chief );
           
             return $this->redirect(['ptb/nota', 'id' => $tugas->id]);
        }
      
        
             return $this->renderAjax('serah-tugas-individu', [
            'tugas' => $tugas,
            'allBiodata' => $allBiodata,
             'depart' => $depart,
            'department' => $department
        ]);
    }
    
       
        public function actionUrusMesyuarat() {
            
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);
         if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        } 
        $urusMesyuarat = TblUrusMesyuarat::find()->All(); //cari semua mesyuarat
        $urus = new TblUrusMesyuarat(); //untuk mesyuarat baru
        if ($urus->load(Yii::$app->request->post())) {
             $urus->tarikh_mesyuarat =  Yii::$app->request->post()['tarikh_mesyuarat'];
          //    $urus->masa_mesyuarat =  Yii::$app->request->post()['masa_mesyuarat'];
             $urus->save(false);
             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Disimpan']);   
            return $this->redirect(['urus-mesyuarat', 'id' => $urus->id]);
        }
        return $this->render('urus-mesyuarat', ['urus' => $urus, 'urusMesyuarat' => $urusMesyuarat]);
    
    }
    
      public function actionDeleteUrusMesyuarat($id)
    {
        $admin = TblUrusMesyuarat::findOne(['id' => $id]);
        $admin->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['urus-mesyuarat']);
        
    }
    
     public function actionMesyuaratPbpu() {  
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);
         if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        }
        $mesyuaratPbpu = TblPbpu::find()->All(); //cari semua mesyuarat
        $urus = new TblPbpu(); //untuk mesyuarat baru
        if ($urus->load(Yii::$app->request->post())) {
             $urus->tarikh_mesyuarat =  Yii::$app->request->post()['tarikh_mesyuarat'];
         //     $urus->masa_mesyuarat =  Yii::$app->request->post()['masa_mesyuarat'];
             $urus->save(false);
             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Disimpan']);   
            return $this->redirect(['mesyuarat-pbpu', 'id' => $urus->id]);
        }
        return $this->render('mesyuarat-pbpu', ['urus' => $urus, 'mesyuaratPbpu' => $mesyuaratPbpu]);
    
    }
    
     public function actionTambahAdmin() {
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);
         if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        }
        $admin = TblAdmin::find()->All(); //cari senarai admin
        $adminbaru = new TblAdmin; //untuk admin baru
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        if ($adminbaru->load(Yii::$app->request->post())) {
                    if(TblAdmin::find()->where( [ 'icno' => $adminbaru->icno ] )->exists()){ //jika admin sudah wujud
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
                    
                    }
                    elseif($adminbaru->kakitangan->CONm != NULL){ //jika icno tidak wujud dalam sistem
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                         $this->notification('PTB', 'Tahniah anda menjadi Admin untuk Sistem Pertukaran Tempat Bertugas.', $adminbaru->icno);
                      $adminbaru->save();
                    }
                    else{
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
                    
                    }
                    
                    return $this->redirect(['ptb/tambah-admin']);
                }
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
        return $this->render('tambah-admin', [
            'admin' => $admin,
            'adminbaru' => $adminbaru,
            'allbiodata' => $allbiodata,
        ]);}
    }
     public function actionDeleteAdmin($id)
    {
        $admin = Tbladmin::findOne(['id' => $id]);
        $admin->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['tambah-admin']);
        
    }
    
     
       public function actionTambahAhliMesyuarat() {
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);
         if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        }
        $meeting = TblAhliMesyuarat::find()->All(); //cari senarai admin
        $meetingbaru = new TblAhliMesyuarat(); //untuk admin baru
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        if ($meetingbaru->load(Yii::$app->request->post())) {
                    if(TblAhliMesyuarat::find()->where( [ 'icno' => $meetingbaru->icno ] )->exists()){ //jika admin sudah wujud
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
                    
                    }
                    elseif($meetingbaru->kakitangan->CONm != NULL){ //jika icno tidak wujud dalam sistem
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                         $this->notification('PTB', 'Tahniah Anda menjadi Ahli Mesyuarat untuk Sistem Pertukaran Tempat Bertugas.', $meetingbaru->icno);
                      $meetingbaru->save();
                    }
                    else{
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
                    
                    }
                    
                    return $this->redirect(['ptb/tambah-ahli-mesyuarat']);
                }
    
        return $this->render('tambah-ahli-mesyuarat', [
            'meeting' => $meeting,
            'meetingbaru' => $meetingbaru,
            'allbiodata' => $allbiodata,
        ]);
         }
         
        public function actionDeleteMeeting($id)
    {
        $meeting = TblAhliMesyuarat::findOne(['id' => $id]);
        $meeting->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
         return $this->redirect(['tambah-ahli-mesyuarat']);
    }
    
    public function actionSenarai(){
 
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);


        if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        }

        $urusMesyuarat = TblUrusMesyuarat::find()->orderBy(['id' => SORT_DESC])->limit(1)->all();
        $mesyuaratPbpu = TblPbpu::find()->orderBy(['id' => SORT_DESC])->limit(1)->all();
        
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy([
            
          'created_at' => SORT_ASC,
          
           ]);
       
          if (Yii::$app->request->post('simpan'))  {

              $answers = Yii::$app->request->post('agree');

              foreach ($answers as $recId => $answer){

                  #get rec where type = 3(pelulus)
                  $model = Recommendation::findOne(['id' => $recId, 'type' => 3, 'agree' => null]);
                   
                  if($model){
                      $model->agree = $answer;
                      $model->save();
                      Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
                  }

              }
           }
            elseif (Yii::$app->request->post('hantar')) {
            $arrayId = Yii::$app->request->post('selection');
            foreach($arrayId as $applicationId) {


                $model = Application::findOne(['id' => $applicationId , 'letter_sent' => 0]);

                if($model){
                    #check make sure has been approved/declined by pelulus
                    $agree = $model->pelulus->agree;
                   
                    if(!is_null($agree)){
               
                        //    $setPegawai = SetPegawai::findOne('pemohon_icno', $model->icno);

                        if($agree == 1){
                   
                    #approve
                            
                    //----------move old data pemohon to table old_position in ptb ---------//
                    $appOldPosition = new TblTugas();  
                    $appOldPosition->application_id = $model->id;
                    $appOldPosition->icno = $model->icno;
                    $appOldPosition->pemohon_name = $model->name;
                    $appOldPosition->position = $model->applicant->jawatan->nama;
                    $appOldPosition->gred = $model->applicant->jawatan->gred;
                    $appOldPosition->old_dept = $model->old_dept;
                    $appOldPosition->status = $model->status;
                    $appOldPosition->save();
                   
                    //----------move old data pemohon to table old_position in ptb ---------//
                    
                    
                            $this->generateLetter($applicationId, $model->letter_reference, $model->approved_dept,  1);
                            $this->notification('PTB', "Sila semak status perpindahan".Html::a('Klik Sini', ['ptb/index'], ['class' => 'label label-info']), $model->icno);

                            #send noty to new KP
                            $this->notification('PTB', "Kakitangan Baharu untuk melapor diri.".Html::a('Klik Sini', ['ptb/lapor-diri'], ['class' => 'label label-info']), $model->approvedDepartment->chiefBiodata->ICNO);
                        }else{
                            #decline
                            $this->generateLetter($applicationId, $model->letter_reference, $model->new_dept,  0);
                              $this->notification('PTB', "Sila semak status perpindahan.".Html::a('Klik Sini', ['ptb/index'], ['class' => 'label label-info']), $model->icno);
                        #send noty to new KP
                            $this->notification('PTB', "Permohonan Kakitangan baharu ditolak.".Html::a('Klik Sini', ['ptb/salinan-surat-ditolak'], ['class' => 'label label-info']), $model->newDepartment->chiefBiodata->ICNO);
                              }
                              
                            
                    }

                    $model->letter_sent = 1; #change sent status to hide from senarai
                    $model->save();
                }
                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Surat Berjaya dihantar']);
                    
                    if($model->type_id  == 1){
                    $appICNO = $model->icno;
                    $port  = \app\models\myportfolio\Tblportfolio::find()->where(['icno' => $appICNO])->with('applicant')->one();
                    $port->status_ptb = $model->status;
                    $port->save(false);
                   }
               }
               
                  
            
                    
                $this->notification('PTB', "Kelulusan Pertukaran Tempat Bertugas Kakitangan Pentadbiran untuk makluman pihak tuan/puan. ".Html::a('Klik Sini', ['ptb/senarai-kelulusan-ptb'], ['class' => 'label label-info']), $model->penyelia_cuti);
                $this->notification('PTB', "Kelulusan Pertukaran Tempat Bertugas Kakitangan Pentadbiran untuk makluman pihak tuan/puan. ".Html::a('Klik Sini', ['ptb/senarai-kelulusan-ptb'], ['class' => 'label label-info']), $model->penyelia_aset);
                $this->notification('PTB', "Kelulusan Pertukaran Tempat Bertugas Kakitangan Pentadbiran untuk makluman pihak tuan/puan. ".Html::a('Klik Sini', ['ptb/senarai-kelulusan-ptb'], ['class' => 'label label-info']), $model->penyelia_shipping);
                $this->notification('PTB', "Kelulusan Pertukaran Tempat Bertugas Kakitangan Pentadbiran untuk makluman pihak tuan/puan. ".Html::a('Klik Sini', ['ptb/senarai-kelulusan-ptb'], ['class' => 'label label-info']), $model->penyelia_elaun);
                $this->notification('PTB', "Kelulusan Pertukaran Tempat Bertugas Kakitangan Pentadbiran untuk makluman pihak tuan/puan. ".Html::a('Klik Sini', ['ptb/senarai-kelulusan-ptb'], ['class' => 'label label-info']), $model->penyelia_latihan);
                $this->notification('PTB', "Kelulusan Pertukaran Tempat Bertugas Kakitangan Pentadbiran untuk makluman pihak tuan/puan. ".Html::a('Klik Sini', ['ptb/senarai-kelulusan-ptb'], ['class' => 'label label-info']), $model->penyelia_lnpt);
                $this->notification('PTB', "Kelulusan Pertukaran Tempat Bertugas Kakitangan Pentadbiran untuk makluman pihak tuan/puan. ".Html::a('Klik Sini', ['ptb/senarai-kelulusan-ptb'], ['class' => 'label label-info']), $model->penyelia_bendahari);
                
                   
        }
        
         elseif(Yii::$app->request->post('notipegawai')){
               $this->notifipegawai(); 
            }
            
             elseif(Yii::$app->request->post('notiKelulusan')){
               $this->notifiKelulusan(); 
            }

        return $this->render('senarai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'urusMesyuarat' => $urusMesyuarat,
            'mesyuaratPbpu' => $mesyuaratPbpu,'port' => $port
        ]);
    }

    public function actionAdminLihatData(){
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::find()->where(['icno' => $icno])->one();
        $models = TblAhliMesyuarat::find()->where(['icno' => $icno])->one();
     
        if($icno != Yii::$app->params['pelulusICNO'] && !$model && !$models ){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        }
     
       $urusMesyuarat = TblUrusMesyuarat::find()->orderBy(['id' => SORT_DESC])->limit(1)->all();
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin-lihat-data', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'urusMesyuarat' => $urusMesyuarat,
        ]);
    }
        
      public function actionLihatPermohonan(){

        $recType  = [1 => 'Pensetuju',2 => 'Peraku',  3 => 'Pelulus'];
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = Application::find()->where(['id' => $id])->one();
      
        $tmp = TblPbpu::find()->select(['kali_ke'])->orderBy(['kali_ke'=>SORT_DESC])->limit(1)->one();
       
        #dapatkan list data tbl_biodata
        $departments =   ArrayHelper::map(Department::find()->all(), 'id', 'fullname');
        $penempatan = TblPenempatan::find()->where(['ICNO' => $model->icno])->all();
        $justification = ArrayHelper::map(RefJustifikasi::find()->all(), 'id', 'fullname');
        $campus = ArrayHelper::map(Campus::find()->all(), 'campus_id', 'campus_name');
        $prevRec = Recommendation::find()
            ->with('staff')
            ->where(['!=', 'type', 3])
            ->andWhere([ 'application_id' => $model->id])
            ->orderBy('type', SORT_ASC)
            ->all();
    
        $deskripsi  = Tblportfolio::find()->where(['icno' => $model->icno])->with('applicant')->limit(1)->one();
        $ikhtisas  = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $pengalaman  = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $tugas = TblTugasUtama::find()->where(['akauntabiliti_id'=>$id])->all();

        return $this->render('lihat-permohonan', compact('tmp','model', 'campus','justification','prevRec', 'recType',   'departments', 'penempatan',
                'deskripsi', 'ikhtisas', 'pengalaman', 'lihatKompetensi', 'akauntabiliti', 'tugas', 'deskripsi', 'lihatDimensi'));

    }
      public function actionMeetingLihatPermohonan(){

        $recType  = [1 => 'Pensetuju',2 => 'Peraku',  3 => 'Pelulus'];
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = Application::find()->where(['id' => $id])->one();
      
        $tmp = TblPbpu::find()->select(['kali_ke'])->orderBy(['kali_ke'=>SORT_DESC])->limit(1)->one();
       
        #dapatkan list data tbl_biodata
        $departments =   ArrayHelper::map(Department::find()->all(), 'id', 'fullname');
        $penempatan = TblPenempatan::find()->where(['ICNO' => $model->icno])->all();
        $justification = ArrayHelper::map(RefJustifikasi::find()->all(), 'id', 'fullname');
        $campus = ArrayHelper::map(Campus::find()->all(), 'campus_id', 'campus_name');
        $prevRec = Recommendation::find()
            ->with('staff')
            ->where(['!=', 'type', 3])
            ->andWhere([ 'application_id' => $model->id])
            ->orderBy('type', SORT_ASC)
            ->all();
        
        $deskripsi  = Tblportfolio::find()->where(['icno' => $model->icno])->with('applicant')->limit(1)->one();
        $ikhtisas  = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $pengalaman  = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $tugas = TblTugasUtama::find()->where(['akauntabiliti_id'=>$id])->all();

        return $this->render('meeting-lihat-permohonan', compact('tmp','model', 'campus','justification','prevRec', 'recType',   'departments', 'penempatan',
                 'deskripsi', 'ikhtisas', 'pengalaman', 'lihatKompetensi', 'akauntabiliti', 'tugas', 'deskripsi', 'lihatDimensi'));

    }
   
       public function actionTetapan(){
        $icno = Yii::$app->user->getId();
        $models = TblAdmin::findOne(['icno' => $icno]);
         if(!$models){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        }
        $names = ['date_open', 'date_close'];
        $request = Yii::$app->request;
        if ($request->post()) {
            $status = true;
            foreach ($names as $name){

                #date range
                $date = ['date_open', 'date_close'];

                if(in_array($name, $date)){
                    #cheking
                    $open = date('Y-m-d', strtotime($request->post('date_open')));
                    $close = date('Y-m-d', strtotime($request->post('date_close')));

                    if($open >= $close){
                        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tarikh ditutup hendaklah selepas tarikh dibuka!']);
                        return $this->redirect(['ptb/tetapan']);
                    }
                } 
                $option = Option::find()->where(["name" =>$name ])->one();
                $option->value = $request->post($name);
             
                if(!$option->save()){
                    $status = false;
                }
            }
               
            
            if($status == true){
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Tetapan berjaya dikemaskini!']);
                return $this->redirect(['ptb/tetapan']);
            }else{
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Gagal mengemaskini tetapan!']);
                return $this->redirect(['ptb/tetapan']);
            }
        }
        $model = ArrayHelper::map(Option::find()->where(['in', 'name', $names])->all(), 'name', 'value');
        return $this->render('tetapan',compact('model'));
    }
   
    
        public function actionNotaPengganti(){ 
         $nota_pengganti = TblTugas::find()->where(['pengganti_ICNO' => Yii::$app->user->getId()])->all();   

         return $this->render('nota-pengganti', ['nota_pengganti' => $nota_pengganti]);   
    }
     
    
   public function actionMohon()
    {
        $lihat = TblPortfolio::find()->where(['icno' => Yii::$app->user->getId()])->exists() ;
        $icno = Yii::$app->user->getId();
        $checkApplication = Application::find()->where(['status' => [1,2,3],'icno' => $icno]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['ptb/index']);
        }
//        $checkApplication2 = Application::find()->where(['status' => 4,'lapor'=>null,'icno' => $icno]);
//        if($checkApplication2->exists()){
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda belum lapor diri di jabatan baharu']);
//            return $this->redirect(['ptb/index']);
//        }
      
        $statesId = $this->auth()->COBirthPlaceCd;
        $countryId = $this->auth()->COBirthCountryCd;
        $gelaransId = $this->auth()->TitleCd;
        $departments =  ArrayHelper::map(Department::find()->where(['isActive' => 1])->all(), 'id', 'fullname');
        $campus = ArrayHelper::map(Campus::find()->where(['NOT IN', 'campus_id', [5,6]])->all(), 'campus_id', 'campus_name');
        $allBiodatass =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        $deptId = $this->auth()->DeptId;
        $campusId = $this->auth()->campus_id;
        $request = Yii::$app->request;
        $peg = Department::find()->where(['id' => $deptId])->one();
        $deptSubOff = Department::findOne($peg->sub_of);
        $penyelia = \app\models\ptb\TblPenyelia::find()->where(['icno' => $icno])->all();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
       
        $mod = TblPortfolio::find()->where(['icno' => $icno, 'status_hantar' => 1])->exists() ; 
        $displaymohon='none';
        
        if ($mod){
            $displaymohon='';                            
        }
        elseif(!$mod){
             $displaymohon='none';
        }
       
       $per = TblPortfolio::find()->where(['icno' => $icno, 'status_hantar' => 1])->exists();
       $display ='none';
       if ($per){
           $display= 'none';   
       
        }
        else if(!$per){  
           $display = '';
            
        }
      
        $model = new Application(['scenario' => Application::SCENARIO_MOHON]);
        if($model->load($request->post())){
            $model->icno = $icno;
            $model->type_id = 1; #permohonan sendiri;
            $model->stat_lantikan = $this->auth()->statLantikan;
            $model->old_dept = $deptId;
            $model->campus_asal = $campusId;
            $model->state_at = $statesId;
            $model->country_at = $countryId;
            $model->gelaran = $gelaransId;
            $nama = $allBiodatass[$icno];
            $model->name = $nama;
            $model->kategori = $biodata->jawatan->job_group;
            $model->created_at = date('Y-m-d H:i:s'); 
            $model->penyelia_cuti = Yii::$app->params['penyeliaCuti'];
            $model->penyelia_shipping = Yii::$app->params['penyeliaShipping'];
            $model->penyelia_elaun = Yii::$app->params['penyeliaElaun'];
            $model->penyelia_aset = Yii::$app->params['penyeliaAset'];
            $model->penyelia_latihan = Yii::$app->params['penyeliaLatihan'];
            $model->penyelia_lnpt = Yii::$app->params['penyeliaLNPT'];
            $model->penyelia_bendahari = Yii::$app->params['penyeliaBendahari'];
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->kp_icno = $peg->pp;
            $model->kj_icno = $peg->chief;
            $model->bsm_icno = $this->pelulusICNO();
            $model->save(false);
         
       
            if ($model->file) {
                if ($model->save()){
                    $id = $model->id;
                    $res = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '04', 'PTB/Permohonan');

                    if ($res->status == true) {
                        $model->file = $res->file_name_hashcode;
                    
                    }
                  
                }
            }
             
             $model->save(false);

            $officerList = []; $sendNoty = true; $bil=0;
            #pensetuju #kp dari table department
            $userDept = Department::findOne($deptId);
            $deptSubOff = Department::findOne($userDept->sub_of);
            
            #if user dept has sub of dept
            
//               if (($userDept->id ==  158)){
                       if($userDept->pp){
                    $officerList[$bil++] = ['icno' => $userDept->pp, 'type' => 1, 'noty' => ($sendNoty)? true | $sendNoty = false : false];
                }
                   // }
                    
                    
//      if (($peg->id !=  158)){        
//            if(!is_null($userDept->sub_of)){
//
//              
//                if($deptSubOff->pp){
//                    $officerList[$bil++] = ['icno' => $deptSubOff->pp, 'type' => 1, 'noty' => ($sendNoty)? true | $sendNoty = false : false];
//                }
//
//            }else {
//
//                if($userDept->pp){
//                    $officerList[$bil++] = ['icno' => $userDept->pp, 'type' => 1, 'noty' => ($sendNoty)? true | $sendNoty = false : false];
//                }
//
//            }
//            
//        }

            #peraku
        
//           if (($userDept->id ==  158)){
                         if($userDept->chief){
                    $officerList[$bil++] = ['icno' => $userDept->chief, 'type' => 2, 'noty' => ($sendNoty)? true | $sendNoty = false : false];
                }
           //}
                    
//    if (($peg->id !=  158)){
//            if(!is_null($userDept->sub_of)){
//
//              
//                if(($deptSubOff->chief) && ($userDept != 158)){
//                    $officerList[$bil++] = ['icno' => $deptSubOff->chief, 'type' => 2, 'noty' => ($sendNoty)? true | $sendNoty = false : false];
//                }
//
//            }else {
//
//                if($userDept->chief){
//                    $officerList[$bil++] = ['icno' => $userDept->chief, 'type' => 2, 'noty' => ($sendNoty)? true | $sendNoty = false : false];
//                }
//
//            }
//            
//    }
             #get setpegawai untuk bsm #pelulus
             $officerList[$bil++] = ['icno' => $this->pelulusICNO(), 'type' => 3, 'noty' => ($sendNoty)? true | $sendNoty = false : false];

                foreach($officerList as $officer){
                $recommendation = new Recommendation();
                $recommendation->application_id = $model->id;
                $recommendation->icno = $officer['icno'];
                $recommendation->agree = null;
                $recommendation->type = $officer['type'];
    
                $recommendation->save(false);

                if($officer['noty']){
                    $model->recommendation_id_action = $recommendation->id;
                    $model->save();
                    $this->notification('PTB', "Permohonan Perpindahan Jabatan menunggu tindakan anda. ".Html::a('Klik Sini', ['ptb/senarai-menunggu-setuju', 'id' => $recommendation->id], ['class' => 'label label-info']), $officer['icno']);
                }
            }

            $this->notification('PTB', 'Permohonan telah dihantar');
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah dihantar']);
            return $this->redirect(['ptb/index']);
            
           
        }
      
        #getting data from table option
        $option = Option::find()->where(["in", "name", ["date_open", "date_close"]])->all();

        #convert object to array
        $dateRange = ArrayHelper::map($option, 'name', 'value');

        $today = date('Y-m-d', strtotime(date('Y-m-d')));
        $start = date('Y-m-d', strtotime($dateRange['date_open']));
        $end = date('Y-m-d', strtotime($dateRange['date_close']));

        $open = "false";
        #checking date between start and end
        if (($today >= $start) && ($today <= $end)){
            $open = "true";
        }

        $options = ["open" => $open, "date" => $dateRange];


        return $this->render('mohon', ['deptSubOff' => $deptSubOff, 'peg' => $peg, 'campus' => $campus,'model'=>$model, 'allbiodatass'=> $allBiodatass, 'departments'=>$departments,  
            'options'=>$options,'penyelia' => $penyelia, 'lihat' => $lihat, 'mod' => $mod, 'displaymohon' => $displaymohon, 'per'=> $per, 'display' => $display]);
    }
    
    
    
      protected function officer() {
            #get setPegawai #peraku
           // $icno = $this->auth()->getId();
            #pensetuju #kp dari table department
            $deptId = $this->auth()->DeptId;
            $userDept = Department::findOne($deptId);
          //  $deptSubOff = Department::findOne($userDept->sub_of);
            
            #peraku
//               if($userDept->chief){
//                $officer = ['icno' => $this->auth()->getId()];
//            }
            
             if($userDept->chief){
                    $officer = ['icno' => $userDept->chief];
             }
            
              if($userDept->pp){
                    $officer = ['icno' => $userDept->pp];
                }
                
                
             #get setpegawai untuk bsm #pelulus
             $officer = ['icno' => $this->pelulusICNO()];

          
           return  $officer['icno'];
            
     }
    
    
    public function actionMultiple()
    {  
        $icno = $this->auth()->getId();
        $model = Department::find()->where(['chief' => $icno])->one();
       
        if(!$model){

            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        }
           
        $dept_id = Yii::$app->user->identity->DeptId;    
        $MultipleStaff =  ArrayHelper::map(Tblprcobiodata::find()->where(['DeptId'=>$dept_id])->andWhere(['Status' => 1])->all(), 'ICNO', 'CONm');
        $MultipleDepartments = ArrayHelper::map(Department::find()->where(['isActive' => 1])->all(), 'id', 'fullname');
        $MultipleCampus = ArrayHelper::map(Campus::find()->all(), 'campus_id', 'campus_name');
        $MultipleJustifikasi = ArrayHelper::map(RefJustifikasi::find()->all(), 'id', 'fullname');
        $states =   ArrayHelper::map(State::find()->all(), 'StateCd', 'State');
      
        $modelsStaff = [new Application];
         
        if (Yii::$app->request->post()) {
         
            
            $modelsStaff = Model::createMultiple(Application::className());
            Model::loadMultiple($modelsStaff, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsStaff)
                    
                );
            }

            // validate all models
            //$valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsStaff);

            if ($valid) {
                
                

                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    //if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelsStaff as $application) {
                            $checkApplication = Application::find()->where(['status' => [1,2,3],'lapor' => null, 'icno' =>$application->icno]);
                            
                            if($checkApplication->exists()){
                            Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sudah mempunyai permohonan']);
                            return $this->redirect(['multiple']);
                             }
                             
                             
                            

                            #get data for current user
                            $biodata = Tblprcobiodata::find()->where(['ICNO' => $application->icno])->one();

                            $application->type_id = 2; #multiple
                       
                            $application->name = $biodata->CONm;
                            $application->old_dept = $biodata->DeptId;
                            $application->status = 3;
                            $application->stat_lantikan = $biodata->statLantikan;
                            $application->state_at = $biodata->COBirthPlaceCd;
                            $application->country_at = $biodata->COBirthCountryCd;
                            $application->gelaran = $biodata->TitleCd;
                            $application->campus_asal = $biodata->campus_id;
                            $application->country_at = $biodata->COBirthCountryCd;
                            $application->kategori = $biodata->jawatan->job_group;
                             $application->penyelia_cuti = Yii::$app->params['penyeliaCuti'];
                             $application->penyelia_shipping = Yii::$app->params['penyeliaShipping'];
                             $application->penyelia_elaun = Yii::$app->params['penyeliaElaun'];
                             $application->penyelia_aset = Yii::$app->params['penyeliaAset'];
                             $application->penyelia_latihan = Yii::$app->params['penyeliaLatihan'];
                             $application->penyelia_lnpt = Yii::$app->params['penyeliaLNPT'];
                             $application->penyelia_bendahari = Yii::$app->params['penyeliaBendahari'];
             
                            if (! ($flag = $application->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                             
                            
            $officerList = []; $sendNoty = true; $bil=0;
            #get setPegawai #peraku
            $icno = $this->auth()->getId();
            #pensetuju #kp dari table department
            $deptId = $this->auth()->DeptId;
            $userDept = Department::findOne($deptId);

            #peraku
               if($userDept->chief){
                $officerList[$bil++] = ['icno' => $this->auth()->getId(), 'type' => 2,   'noty' => ($sendNoty)? true | $sendNoty = false : false];
            }
             #get setpegawai untuk bsm #pelulus
             $officerList[$bil++] = ['icno' => $this->pelulusICNO(), 'type' => 3, 'noty' => ($sendNoty)? true | $sendNoty = false : false];
              
                foreach($officerList as $officer){
                $recommendation = new Recommendation();
                $recommendation->application_id = $application->id;
                $recommendation->icno = $officer['icno'];
                $recommendation->type = $officer['type'];
                if($recommendation->type == 2){
                       $recommendation->agree = 1;
                }
                $recommendation->update = date('Y-m-d H:i:s');         
                $recommendation->save();         
                if($officerList->type == 2){
                 $application->recommendation_id_action = $recommendation->id;
                 $application->save();
                 $this->notification('PTB', "Permohonan Perpindahan Jabatan menunggu tindakan anda. ".Html::a('Klik Sini', ['ptb/senarai', 'id' => $recommendation->id], ['class' => 'label label-info']), $officer['icno']);
            }
            }
                        }                
           
                        
                    //}
                    if ($flag) {
                        
               
                        $transaction->commit();
                 
                         Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah disimpan']);
                        $this->notification('PTB', "Permohonan Perpindahan Jabatan menunggu tindakan anda. ".Html::a('Klik Sini', ['ptb/senarai', 'id' => $recommendation->id], ['class' => 'label label-info']), $officer['icno']);
               
                        return $this->redirect(['senarai-menunggu-peraku']);
                    }
                    
                } catch (Exception $e) {
                    
                    $transaction->rollBack();
                  
                }
                        
        }
               
            }
     
        return $this->render('multiple', ['MultipleStaff'=> $MultipleStaff, 'MultipleCampus'=> $MultipleCampus, 'MultipleDepartments'=> $MultipleDepartments, 'MultipleJustifikasi' => $MultipleJustifikasi, 'states'=> $states,
         
            'modelsStaff' => (empty($modelsStaff)) ? [new TblMultiple()] : $modelsStaff
        ]);
    }
    
    
     public function actionMultipleBsm()
    {
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);

        if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        }  
        $MultipleStaff =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        $MultipleDepartments = ArrayHelper::map(Department::find()->all(), 'id', 'fullname');
        $MultipleCampus = ArrayHelper::map(Campus::find()->all(), 'campus_id', 'campus_name');
        $MultipleJustifikasi = ArrayHelper::map(RefJustifikasi::find()->all(), 'id', 'fullname');
        $states =   ArrayHelper::map(State::find()->all(), 'StateCd', 'State');
       
        
        $modelsKakitangan = [new Application];
         
        if (Yii::$app->request->post()) {
         
  
            $modelsKakitangan = Model::createMultiple(Application::className());
            Model::loadMultiple($modelsKakitangan, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsKakitangan)
                    
                );
            }

            // validate all models
            //$valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsKakitangan);

            if ($valid) {
                
            $transaction = \Yii::$app->db->beginTransaction();
                try {

                    //if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelsKakitangan as $application) {
                            $checks = Application::find()->where(['status' => [1,2,3],'lapor' => null, 'icno' =>$application->icno]);
                            
                            if($checks->exists()){
                            Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sudah mempunyai permohonan']);
                            return $this->redirect(['multiple-bsm']);
                             }
                            #get data for current user
                            $biodata = Tblprcobiodata::find()->where(['ICNO' => $application->icno])->one();
                            $application->type_id = 3; #multiple
                          
                            $application->name = $biodata->CONm;
                            $application->old_dept = $biodata->DeptId;
                            $application->status = 3;
                            $application->stat_lantikan = $biodata->statLantikan;
                            $application->state_at = $biodata->COBirthPlaceCd;
                            $application->gelaran = $biodata->TitleCd;
                            $application->campus_asal = $biodata->campus_id;
                            $application->country_at = $biodata->COBirthCountryCd;
                            $application->kategori = $biodata->jawatan->job_group;
                             $application->penyelia_cuti = Yii::$app->params['penyeliaCuti'];
                             $application->penyelia_shipping = Yii::$app->params['penyeliaShipping'];
                             $application->penyelia_elaun = Yii::$app->params['penyeliaElaun'];
                             $application->penyelia_aset = Yii::$app->params['penyeliaAset'];
                             $application->penyelia_latihan = Yii::$app->params['penyeliaLatihan'];
                             $application->penyelia_lnpt = Yii::$app->params['penyeliaLNPT'];
                             $application->penyelia_bendahari = Yii::$app->params['penyeliaBendahari'];

                            
                            if (! ($flag = $application->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                            #create recommendation
                            $recommendation = new Recommendation();
                            $recommendation->application_id = $application->id;
                            $recommendation->icno = $this->pelulusICNO(); #pelulus icno
                            $recommendation->type = 3; #direct to pelulus
                            $recommendation->update = date('Y-m-d H:i:s');
                            $recommendation->save();

                            #update application rec_id;
                            $application->recommendation_id_action = $recommendation->id;
                            $application->save();

                        }
                    //}
                    if ($flag) {
                        
               
                        $transaction->commit();
                        
                         Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah disimpan']);
                       
               
                        return $this->redirect(['senarai-menunggu-pelulus']);
                    }
                    
                } catch (Exception $e) {
                    
                    $transaction->rollBack();
                  
                }
                        
        }
               
            }
 
        return $this->render('multiple-bsm', ['MultipleStaff'=> $MultipleStaff, 'MultipleCampus' => $MultipleCampus, 'MultipleDepartments'=> $MultipleDepartments, 'MultipleJustifikasi' => $MultipleJustifikasi, 'states'=> $states,
         
            'modelsKakitangan' => (empty($modelsKakitangan)) ? [new TblMultiple()] : $modelsKakitangan
        ]);
    }
    
    public function actionTindakan()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = Recommendation::find()->where(['id'=> $id])->one();
        #applicant ICNO
        $appICNO = $model->application->icno;
        $penempatan = TblPenempatan::find()->where(['ICNO' => $appICNO])->orderBy(['date_start' => SORT_DESC])->all();
        $currentRecType = $model->type;
        $prevRec = null;
        #if less than one , means it is the first rec
        if($currentRecType != 1){
            $prevRec = Recommendation::find()->with('staff')->where(['<', 'type', $currentRecType])->andWhere(['=', 'application_id', $model->application->id])->orderBy('type', SORT_ASC)->all();
        }
        
        $deskripsi  = Tblportfolio::find()->where(['icno' => $appICNO])->with('applicant')->limit(1)->one();
        $ikhtisas  = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $pengalaman  = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $tugas = TblTugasUtama::find()->where(['akauntabiliti_id'=>$id])->all();
        
            return $this->render('tindakan', ['model'=>$model, 'prevRec'=> $prevRec,  'penempatan'=>$penempatan,
                'ikhtisas' => $ikhtisas, 'lihatDimensi' => $lihatDimensi, 'pengalaman' => $pengalaman, 'lihatKompetensi' => $lihatKompetensi,
                'akauntabiliti'=> $akauntabiliti, 'deskripsi' => $deskripsi, 'tugas' => $tugas]);
    }
   
    public function actionTindakans(){
          #for bsm & admin;
        $bsm_icno = Yii::$app->params['pelulusICNO'];

        #checking roles
        if($this->bsmAccess() == false){
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tiada akses']);
            return $this->redirect(['ptb/index']);
        }

        $recType  = [1 => 'Pensetuju',2 => 'Peraku',  3 => 'Pelulus'];
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = Recommendation::find()->where([
            'application_id' => $id,
            'icno' => $bsm_icno,'type' => 3
            
        ])
            ->with('application.applicant.jawatan')
            ->with('application.newDepartment')
            ->with('application.newLantikan') 
            ->one();
        

        if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Data tidak dijumpai']);
             return $this->redirect(['ptb/index']);
        }

        #dapatkan list data tbl_biodata
        $departments =   ArrayHelper::map(Department::find()->all(), 'id', 'fullname');
       
        $penempatan = TblPenempatan::find()->where(['ICNO' => $model->application->icno])->orderBy(['date_start' => SORT_DESC])->all();
        $justification = ArrayHelper::map(RefJustifikasi::find()->all(), 'id', 'fullname');
        $campus = ArrayHelper::map(Campus::find()->all(), 'campus_id', 'campus_name');
       
        
        $currentRecType = $model->type;
        $prevRec = null;
        #if less than one , means it is the first recommendation
        if($currentRecType != 1){
            $prevRec = Recommendation::find()
                ->with('staff')
                ->where(['<', 'type', $currentRecType])
                ->andWhere(['=', 'application_id', $model->application->id])
                ->orderBy('type', SORT_ASC)
                ->all();
        }

             #mesti ikut flow, tpi klw bsm and admin boleh terus bagi tindakan
             if(($model->application->recommendation_id_action != $id) && $this->bsmAccess() == false){
        
                                                                                                                                                                  
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Proses permindahan hendaklah dijalankan secara berperingkat']);
           return $this->redirect(['ptb/index']);
        }
         
        $appICNO = $model->application->icno;
        $deskripsi  = Tblportfolio::find()->where(['icno' => $appICNO])->with('applicant')->limit(1)->one();
        $ikhtisas  = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $pengalaman  = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $tugas = TblTugasUtama::find()->where(['akauntabiliti_id'=>$id])->all();

        if($model->load($request->post())){
            #status: $type => status
            $status = [1=>2, 2=>3, 3=>null];
            #update recommendation table
            $model->agree = $request->post()['Recommendation']['agree'];
            $model->notes = $request->post()['Recommendation']['notes'];
            $model->update = date('Y-m-d H:i:s');
            $model->application->status =  $status[$model->type];
            
            #get next recommendation;
            $nextRec = Recommendation::find()
                ->where(['agree'=>null,'application_id' => $model->application_id,])
                ->andWhere(['!=', 'id', $model->id])
                ->orderBy(['type' => SORT_ASC])
                ->one();
       
           #jawapan pelulus
            if($model->type == 3){
                
                 $justikasi = $request->post('justifikasi');
                 $model->application->justifikasi = $justikasi;
                 $letter_reference = $request->post('letter_reference');
                 $model->application->letter_reference = $letter_reference;
                 $tarikh_mesyuarat = date_format(date_create($request->post('tarikh_mesyuarat')), 'Y-m-d');
                 $model->application->tarikh_mesyuarat = $tarikh_mesyuarat;
                 
              
        
        
              
                #pelulus approve
                if($model->agree == 1){
                    
                     $model->application->status = 4;
                     $approved_dept = $request->post('approved_dept');
                     $model->application->approved_dept = $approved_dept;
                   
                  
                     $campus_id = $request->post('campus_id');
                     $model->application->campus_id = $campus_id;
                     $effective_date = date_format(date_create($request->post('effective_date')), 'Y-m-d');
                     $model->application->effective_date = $effective_date;
                   
     
     
                }else{

                    $model->application->status = 5;
                  

                }
   
                $model->save();
                $model->application->save();
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);
                return $this->redirect(['ptb/senarai']);
                
            

            }else{
               

                $model->application->recommendation_id_action = $nextRec->id;
                $model->application->save();
                $model->save();
            }
            
                               
      

            #send noty to next $nextRex
            $this->notification('PTB', 'Permohonan Perpindahan Jabatan menuggu tindakan anda. '.Html::a('Klik sini', ['ptb/tindakan', 'id' => $nextRec->id], ['class' => 'label label-info']), $nextRec->icno);
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);
            return $this->redirect(['ptb/index']);

        }
           return $this->render('tindakans-pelulus', compact('model', 'campus','justification','prevRec', 'recType', 'departments', 'penempatan',
                      'ikhtisas', 'lihatDimensi', 'pengalaman','lihatKompetensi','akauntabiliti', 'deskripsi', 'tugas'));

       
    }

// public function actionTindakanPegawai($id){
//        $request = Yii::$app->request;
//    //    $id = $request->get('id');
//      //  $recType  = [1 => 'Pensetuju',2 => 'Peraku',  3 => 'Pelulus'];
//        $model = Recommendation::find()->where(['id' => $id, 'icno' => $this->auth()->getId()])->with('application.applicant.jawatan')->with('application.newDepartment')->with('application.newLantikan')->one();
// 
//        
////              $kp = Recommendation::find()->where(['id' => $id, 'icno' => $this->auth()->getId()])->andWhere(['type'=> 1])->andWhere(['!=', 'agree', NULL])->with('application.applicant.jawatan')->with('application.newDepartment')->with('application.newLantikan')->one();
////               $kj = Recommendation::find()->where(['id' => $id, 'icno' => $this->auth()->getId()])->andWhere(['type'=> 2])->andWhere(['!=', 'agree', NULL])->one();
////     
////        
////            if(!$model){
////           Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);
////           return $this->redirect(['ptb/senarai-menunggu-setuju']);
////        } if($kj){
////           Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);
////           return $this->redirect(['ptb/senarai-menunggu-peraku']);
////        }
//        
//        
////        if($model->pensetuju->agree != Null){
////            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Selesai diambil Tindakan']);
////             return $this->redirect(['ptb/senarai-menunggu-setuju']);
////        }
////        
////          if($model->peraku->agree != Null){
////            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Selesai diambil Tindakan']);
////             return $this->redirect(['ptb/senarai-menunggu-peraku']);
////        }
//        
//
//    //    $currentRecType = $model->type;
//   //     $prevRec = null;
//        #if less than one , means it is the first recommendation
//   //     if($currentRecType != 1){
//   //         $prevRec = Recommendation::find()
//    //            ->with('staff')
//    //            ->where(['<', 'type', $currentRecType])
//    //            ->andWhere(['=', 'application_id', $model->application->id])
//     //           ->orderBy('type', SORT_ASC)
//    //            ->all();
//    //    }
//          
//
//        #mesti ikut flow, tpi klw bsm boleh terus bagi tindakan
//        if(($model->application->recommendation_id_action != $id) && (Yii::$app->user->getId() != $this->pelulusICNO())){
//
//        }
//        if($model->type == 2){
//        if($model->application->status == 1){
//              Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Menunggu Tindakan KP. Proses pemindahan hendaklah dijalankan secara berperingkat']);
//           return $this->redirect(['ptb/senarai-menunggu-peraku']);
//        }
//        }
//        
//    
//
//
//        if($model->load($request->post())){
//            #status: $type => status
//            $status = [1=>2, 2=>3, 3=>null];
//
//            #update recommendation table
//            $model->agree = $request->post()['Recommendation']['agree'];
//            $model->notes = $request->post()['Recommendation']['notes'];
//            $model->update = date('Y-m-d H:i:s');
//            $model->application->status =  $status[$model->type];
//         //  $model->save(false);
//
//            #get next recommendation;
//            $nextRec = Recommendation::find()
//                ->where(['agree'=>null,'application_id' => $model->application_id,])
//                ->andWhere(['!=', 'id', $model->id])
//                ->orderBy(['type' => SORT_ASC])
//                ->one();
//
//                $model->application->recommendation_id_action = $nextRec->id;
//                
//                $model->save(false);
//                $model->application->save(false);
//            
//               $kp = Recommendation::find()->where(['id' => $id, 'icno' => $this->auth()->getId()])->andWhere(['type'=> 1])->andWhere(['!=', 'agree', NULL])->one();
//               $kj = Recommendation::find()->where(['id' => $id, 'icno' => $this->auth()->getId()])->andWhere(['type'=> 2])->andWhere(['!=', 'agree', NULL])->one();
//     
//               
//                if($model->type == 1){
//                $model->application->kp_agree =  $kp->agree;
//                $model->application->kp_notes =  $kp->notes;
//                $model->application->kp_created = $kp->update;
//                 }
//                if($model->type == 2){
//                $model->application->kj_agree =  $kj->peraku->agree;
//                $model->application->kj_notes =  $kj->notes;
//                $model->application->kj_created = $kj->update;
//                }
//                
//                $model->application->save(false);
//            
//            if($model->type == 1){
//                $this->notification('PTB', "Permohonan Perpindahan Jabatan menunggu tindakan anda. ".Html::a('Klik Sini', ['ptb/senarai-menunggu-setuju', 'id' => $nextRec], ['class' => 'label label-info']), $nextRec->icno);
//            }
//               if($model->type == 2){
//                $this->notification('PTB', "Permohonan Perpindahan Jabatan menunggu tindakan anda. ".Html::a('Klik Sini', ['ptb/senarai-menunggu-peraku', 'id' => $nextRec], ['class' => 'label label-info']), $nextRec->icno);
//            }
//            
////            if($nextRec->type == 3){
////            #send noty to next $nextRex
////            //$this->notification('PTB', 'Permohonan Perpindahan Jabatan menunggu tindakan anda. '. $nextRec->icno);
////            $this->notification('PTB', "Permohonan Perpindahan Jabatan menunggu tindakan anda. ".Html::a('Klik Sini', ['ptb/senarai', 'id' => $nextRec], ['class' => 'label label-info']), $nextRec->icno);
////            }
//            
//
//           if($kp){
//           Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);
//           return $this->redirect(['ptb/senarai-menunggu-setuju']);
//        } if($kj){
//           Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);
//           return $this->redirect(['ptb/senarai-menunggu-peraku']);
//        }
//            
//
//        }
//
//        
////          if($model->pensetuju->agree != Null){
////            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Selesai diambil Tindakan']);
////             return $this->redirect(['ptb/senarai-menunggu-setuju']);
////        }
//        
////          if($model->peraku->agree != Null){
////            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Selesai diambil Tindakan']);
////             return $this->redirect(['ptb/senarai-menunggu-peraku']);
////        }
//   
//            return $this->renderAjax('tindakan-pegawai', compact('model', 'campus','justification','kk','prevRec', 'recType',  'penyandang', 'departments', 'penempatan', 'kp', 'kj'));
//      
//    }
    
    
    
    Public function actionTindakanPegawai(){
        $request = Yii::$app->request;
        $id = $request->get('id');
        $recType  = [1 => 'Pensetuju',2 => 'Peraku',  3 => 'Pelulus'];
        $model = Recommendation::find()->where(['id' => $id, 'icno' => $this->auth()->getId()])->with('application.applicant.jawatan')->with('application.newDepartment')->with('application.newLantikan')->one();
       
//        if(!$model){
//            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Selesai diambil Tindakan']);
//             return $this->redirect(['ptb/index']);
//        }

        $currentRecType = $model->type;
        $prevRec = null;
        #if less than one , means it is the first recommendation
        if($currentRecType != 1){
            $prevRec = Recommendation::find()
                ->with('staff')
                ->where(['<', 'type', $currentRecType])
                ->andWhere(['=', 'application_id', $model->application->id])
                ->orderBy('type', SORT_ASC)
                ->all();
        }
          

        #mesti ikut flow, tpi klw bsm boleh terus bagi tindakan
        if(($model->application->recommendation_id_action != $id) && (Yii::$app->user->getId() != $this->pelulusICNO())){

       //     Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Proses pemindahan hendaklah dijalankan secara berperingkat']);
        //   return $this->redirect(['ptb/index']);
            
        }
        
        if($currentRecType == 1){
        if($model->application->status == 3){
              Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Proses pemindahan hendaklah dijalankan secara berperingkat']);
         //   Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);
              return $this->redirect(['ptb/senarai-menunggu-setuju']);
        }
        }
        
        
        if(($currentRecType == 2) && ($model->application->kp_icno != null)){
        if($model->application->status == 1){
              Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Proses pemindahan hendaklah dijalankan secara berperingkat']);
         //   Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);
              return $this->redirect(['ptb/senarai-menunggu-peraku']);
        }
        }

        if($model->load($request->post())){
            #status: $type => status
            $status = [1=>2, 2=>3, 3=>null];

            #update recommendation table
            $model->agree = $request->post()['Recommendation']['agree'];
            $model->notes = $request->post()['Recommendation']['notes'];
            $model->update = date('Y-m-d H:i:s');
            $model->application->status =  $status[$model->type];

            #get next recommendation;
            $nextRec = Recommendation::find()
                ->where(['agree'=>null,'application_id' => $model->application_id,])
                ->andWhere(['!=', 'id', $model->id])
                ->orderBy(['type' => SORT_ASC])
                ->one();

                $model->application->recommendation_id_action = $nextRec->id;
                $model->application->save(false);
                $model->save(false);
            
            
            if($nextRec->type == 2){
 
                $model->application->recommendation_id_action = $nextRec->id;
                $model->application->save();
                $model->save();
                $this->notification('PTB', "Permohonan Perpindahan Jabatan menunggu tindakan anda. ".Html::a('Klik Sini', ['ptb/senarai-menunggu-peraku', 'id' => $nextRec], ['class' => 'label label-info']), $nextRec->icno);
            }if($nextRec->type == 3){
            #send noty to next $nextRex
            //$this->notification('PTB', 'Permohonan Perpindahan Jabatan menunggu tindakan anda. '. $nextRec->icno);
            $this->notification('PTB', "Permohonan Perpindahan Jabatan menunggu tindakan anda. ".Html::a('Klik Sini', ['ptb/senarai', 'id' => $nextRec], ['class' => 'label label-info']), $nextRec->icno);
            }
            
   //         Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);
   //         return $this->redirect(['ptb/index']);
            
    $kp = Recommendation::find()->where(['id' => $id, 'icno' => $this->auth()->getId()])->andWhere(['type'=> 1])->one();
    $kj = Recommendation::find()->where(['id' => $id, 'icno' => $this->auth()->getId()])->andWhere(['type'=> 2])->one();

            
       if($kp){
           Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);
           return $this->redirect(['ptb/senarai-menunggu-setuju']);
        } if($kj){
           Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);
           return $this->redirect(['ptb/senarai-menunggu-peraku']);
        }
            

        }
   
            return $this->renderAjax('tindakan-pegawai', compact('model', 'campus','justification','kk','prevRec', 'recType',  'penyandang', 'departments', 'penempatan', 'kp', 'kj'));
      
    }
	
    
           public function actionMohonUlasanPpp($id){
            $request = Yii::$app->request;
            $model = Recommendation::find()->where(['id' => $id, 'type' => 1])->with('application.applicant.jawatan')->with('application.newDepartment')->with('application.newLantikan')->one();
            $application_id = $model->application_id;
            
            $ppp  = Application::find()->where(['id' => $application_id ])->one();
            
            $lpp = lpp::find()->where(['PYD' => $ppp->icno])->orderBy(['lpp_id' => SORT_DESC])->one();
           
            if($ppp->load($request->post())){
           
            $ppp->ppp_icno = $lpp->PPP;
            $ppp->save(false);
            
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Berjaya Dihantar']);
            $this->notification('PTB', "Mohon pihak tuan/puan untuk memberi ulasan berkenaan permohonan Pertukaran Tempat Bertugas kakitangan berikut. ".Html::a('Klik Sini', ['ptb/senarai-ppp', 'id' => $ppp], ['class' => 'label label-info']), $ppp->ppp_icno);
           
            return $this->redirect(['/ptb/senarai-menunggu-setuju']);
          }
             return $this->render('mohon-ulasan-ppp', compact('ppp', 'model', 'lpp'));
      
    }
         public function actionBuatUlasanPpp($id){
            $request = Yii::$app->request;
            $model  = Application::find()->where(['id' => $id ])->with('pensetuju')->one();
           // $tugas = TblTugas::findOne($id);
            $depart = Department::find()->where(['id' => $model->old_dept])->one();
            if($model->load($request->post())){
             $model->ulasan_ppp = $request->post()['Application']['ulasan_ppp'];
             $model->status_ppp = $request->post()['Application']['status_ppp'];
              $model->save(false);
            
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Berjaya Dihantar']);
           $this->notification('PTB', "PPP telah mengemukakan ulasan berkaitan PTB kakitangan" .Html::a('Klik Sini', ['ptb/senarai-menunggu-setuju', 'id' => $model->id], ['class' => 'label label-info']), $model->pensetuju->icno);
        //   $this->notification('PTB', "Mohon pihak tuan/puan untuk memberi ulasan berkenaan permohonan Pertukaran Tempat Bertugas kakitangan berikut" .Html::a('Klik Sini', ['ptb/senarai-ppp', 'id' => $ppp], ['class' => 'label label-info']), $ppp->ppp_icno);
          
           return $this->redirect(['/ptb/senarai-ppp']);
          }
             return $this->renderAjax('buat-ulasan-ppp', compact('ppp', 'model', 'depart'));
      
    }
    
            public function actionLihatUlasanPpp($id){
           // $request = Yii::$app->request;
            $model = Recommendation::find()->where(['id' => $id, 'type' => 1])->with('application.applicant.jawatan')->with('application.newDepartment')->one();
            $application_id = $model->application_id;
            
             $models = Application::find()->where(['id' => $application_id ])->with('namaPp')->one();
             return $this->render('lihat-ulasan-ppp', compact('models', 'model'));
      
    }
   
    #private funtion to insert data to tbl_letter
    private  function generateLetter($application_id, $reference)
    {
        #get Application
        $application = Application::find()->where(['id' => $application_id ])->one();

        $model = new Letter();
       
        $removeWhiteSpace = str_replace(' ', '', $reference);
        $letter_reference = "UMS/PEND2.2/500-2/7/2 Jld.9 (".$removeWhiteSpace.")";
        $jawatan  = strtoupper($application->applicant->jawatan->nama);
        $model->application_id = $application_id;
        $model->date_issue = $application->effective_date;
        $model->tarikh_mohon = $application->created_at;
        $model->letter_reference = $letter_reference;
        $model->recipient_name = $application->applicant->CONm;
        $model->kali_ke = $application->kali_ke;
        $model->tarikh_mesyuarat = $application->tarikh_mesyuarat;
        $model->recipient_dept = $application->applicant->department->fullname;
        $model->recipient_tel = $application->applicant->COHPhoneNo;
        $model->letter_status = $application->status;
        $model->new_position = $jawatan;
        $model->new_gred = $application->applicant->jawatan->gred;
        $model->old_dept = $application->oldDepartment->fullname;
        $model->new_dept = $application->newDepartment->fullname;
        $model->approved_dept = $application->approvedDepartment->fullname;
        $model->kampus = $application->campus->campus_name;
        $model->kampus_mohon = $application->newCampus->campus_name;
        $model->kampus_asal = $application->campus_asal;

        if($model->save()){
            return $model->id;
        }else{
            return false;
        }

    }
   
    public function actionApplicantGenerateLetter($id)
    {
        $css = file_get_contents('./css/surat.css');
        #cehck application
        $icno = $this->auth()->getId();   
        $model = Application::find()
            ->where([
                'id' => $id,
                ])
            ->andWhere(['in', 'status', [4, 5]])
            ->one();
 
        #check if pemohon
        if($model->icno == $icno){
           $allow = true;
        }

        #check if pensetuju
        if(isset($model->pensetuju)){
            if($model->pensetuju->icno == $icno){
                $allow = true;
            }
        }

        #check if peraku
        if(isset($model->peraku)){
            if($model->peraku->icno == $icno){
                $allow = true;
            }
        }

        #check if pelulus
        if(isset($model->pelulus)){
            if($model->pelulus->icno == $icno){
                $allow = true;
            }
        }
        


        // get your HTML raw content without any layouts or scripts
        if($model->pelulus->agree == 1){
       $content = $this->renderPartial('_penempatanPemohon', ['approvedDept' => $model->approvedDepartment, 'letter' => $model->letter, 'campus' => $model->campus,  'gelarans' => $model->gelarans, 'applicant' => $model->applicant, 'newDept' => $model->newDepartment, 'oldDept' => $model->oldDepartment]);
        }
        if($model->pelulus->agree == 0){
        $content = $this->renderPartial('_penempatanPemohonDitolak', ['letter' => $model->letter, 'newCampus' => $model->newCampus,   'gelarans' => $model->gelarans, 'applicant' => $model->applicant, 'newDept' => $model->newDepartment, 'oldDept' => $model->oldDepartment, 'approvedDept' => $model->approvedDepartment]);
        }

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
            'options' => ['title' => 'Laporan Kehadiran Bulanan'],
            // call mPDF methods on the fly
            'marginTop' => 35,
           'marginLeft' => 24,
            'marginRight' => 24,
            'methods' => [
              'SetHeader' => ['SURAT PENEMPATAN'],
                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                'WriteHTML' => [$css, 1]
//                'SetFooter' => [' {PAGENO}'],
             
            ]
        ]);
      
        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    
     public function actionTugasGenerateLetter($id)
    {
        $model = TblTugas::findOne(['id' => $id]);
        // get your HTML raw content without any layouts or scripts
   
       $lihatNota = TblSerahTugas::find()->where(['tugas_id' => $id])->all();//cari semua mesyuarat
       
       $content = $this->renderPartial('_serahTugasPdf', ['oldDepartment' => $model->oldDepartment, 'model' => $model, 'lihatNota' => $lihatNota, 'serahTugas' => $model->serahTugas]);
        
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
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
              'SetHeader' => ['Nota Serah Tugas'],
             
             
            ]
        ]);
      
        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    
    


//    function getDaysInYearMonth(int $year, int $month, string $format) {
//        $date = DateTime::createFromFormat("Y-n", "$year-$month");
//
//        $datesArray = array();
//        for ($i = 1; $i <= $date->format("t"); $i++) {
//            $datesArray[] = DateTime::createFromFormat("Y-n-d", "$year-$month-$i")->format($format);
//        }
//
//        return $datesArray;
//    }
    
    public function actionBroadcasting(){
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);
         if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['ptb/index']);
        }  
           
        $request = Yii::$app->request;
        if($request->post()){

            $title = $request->post('title');
            $content = $request->post('content');

           $allBiodata = ArrayHelper::map(Tblprcobiodata::find()->where(['Status' => 1])->joinWith('contoh')->all(), 'ICNO', 'ICNO');
            foreach ($allBiodata as $ic){
                $ntf = new Notification();
                $ntf->icno = $ic;
                $ntf->title = $title;
                $ntf->content = $content;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            }

            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Notifikasi Berjaya dihantar']);
            return $this->redirect(['ptb/broadcasting']);

        }

        
        return $this->render('broadcasting', ['allBiodata' => $allBiodata, 'content' => $content, 'title' => $title]);
    }
   
   
     private function bsmAccess(){

        $access = false;
        $icno = Yii::$app->user->getId();

        #check if BSM
        if($icno == Yii::$app->params['pelulusICNO']){
            $access = true;
        }

        #check if admin
        $admin = TblAdmin::findOne(['icno' => $icno]);
        if($admin){

            $access = true;
        }

        return $access;
    }
     public function actionSenaraiDalamProses(){
        #checking roles
        if($this->bsmAccess() == false){
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tiada akses']);
            return $this->redirect(['ptb/index']);
        }
       // $senarai = Application::find()->where(['in', 'status', array(1,2,3)])->all();
         
        $query = Application::find()->where(['status' => [1,2,3]]);
           $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' => 20
           ],]);
          return $this->render('senarai-dalam-proses', ['provider' => $provider]);
    }

     public function actionKemaskiniDataPeraku(){

        #checking roles
        if($this->bsmAccess() == false){
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tiada akses']);
            return $this->redirect(['ptb/index']);
        }
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = Application::find()
            ->where(['in', 'status', array(1,2,3)])
            ->andWhere(['id' => $id])
            ->one();

        #ic list
        $pegawai =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');

        #check peraku
        $new = true;
        if($model->peraku){
            $new = false;
            $peraku = $model->peraku;
        }else{
            $peraku = new Recommendation();
        }

        #jika peraku telah dibuat
        if(!is_null($peraku->agree)){
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Perubahan Peraku tidak dibenarkan kerana perakuan telah dibuat!']);
            return $this->redirect(['ptb/senarai-dalam-proses']);
        }

        if($request->post()) {
            $icno = $request->post('Recommendation')['icno'];

            #check if icno exist
            $check = Tblprcobiodata::find()
                ->where(['ICNO' => $icno])
                ->one();

            #if not exist
            if(!$check){
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'No Kad Pengenalan Pegawai Tidak Dijumpai!']);
                return $this->redirect(['ptb/kemaskini-data-peraku', 'id' => $model->id]);
            }

            #not changed
            if($icno == $peraku->icno){
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tiada Perubahan Pegawai Peraku Berlaku!']);
                return $this->redirect(['ptb/kemaskini-data-peraku', 'id' => $model->id]);
            }

            $peraku->icno = $icno;
            $peraku->application_id = $model->id;
            $peraku->type = 2;

            if($peraku->save()){

                #send notification
         //       $this->notification('PTB', "Permohonan Perpindahan Jabatan menunggu tindakan anda. ".Html::a('Klik Sini', ['ptb/tindakan-pegawai', 'id' => $peraku->id], ['class' => 'label label-info']), $icno);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pegawai Peraku berjaya dikemaskini']);
                return $this->redirect(['ptb/senarai-dalam-proses']);
            }
        }

        return $this->render('kemaskini-data-peraku', compact('model', 'peraku', 'new', 'pegawai'));
    }
     public function actionKemaskiniDataPensetuju(){

        #checking roles
        if($this->bsmAccess() == false){
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tiada akses']);
            return $this->redirect(['ptb/index']);
        }
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = Application::find()
            ->where(['in', 'status', array(1,2,3)])
            ->andWhere(['id' => $id])
            ->one();

        #ic list
        $pegawai =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');

        #check peraku
        $new = true;
        if($model->pensetuju){
            $new = false;
            $pensetuju = $model->pensetuju;
        }else{
            $pensetuju = new Recommendation();
        }

        #jika peraku telah dibuat
        if(!is_null($pensetuju->agree)){
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Perubahan Pegawai Pensetuju tidak dibenarkan kerana pensetujuan telah dibuat']);
            return $this->redirect(['ptb/senarai-dalam-proses']);
        }

        if($request->post()) {
            $icno = $request->post('Recommendation')['icno'];

            #check if icno exist
            $check = Tblprcobiodata::find()
                ->where(['ICNO' => $icno])
                ->one();

            #if not exist
            if(!$check){
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'No Kad Pengenalan Pegawai Tidak Dijumpai!']);
                return $this->redirect(['ptb/kemaskini-data-peraku', 'id' => $model->id]);
            }

            #not changed
            if($icno == $pensetuju->icno){
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tiada Perubahan Pegawai Peraku Berlaku!']);
                return $this->redirect(['ptb/kemaskini-data-peraku', 'id' => $model->id]);
            }

            $pensetuju->icno = $icno;
            $pensetuju->application_id = $model->id;
            $pensetuju->type = 1;

            if($pensetuju->save()){

                #send notification
          //      $this->notification('PTB', "Permohonan Perpindahan Jabatan menunggu tindakan anda. ".Html::a('Klik Sini', ['ptb/tindakan-pegawai', 'id' => $pensetuju->id], ['class' => 'label label-info']), $icno);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Pegawai Pensetuju berjaya dikemaskini']);
                return $this->redirect(['ptb/senarai-dalam-proses']);
            }
        }

        return $this->render('kemaskini-data-pensetuju', compact('model', 'pensetuju', 'new', 'pegawai'));
    }
    
        protected function notifipegawai(){
        $ver = Recommendation::find()->where(['type' => 1, 'agree' => null])->all();
      //  $app = Recommendation::find()->where(['type' => 2, 'agree' => null])->all();
        
        foreach($ver as $ver){
          $this->notification('PTB', "Permohonan Perpindahan Jabatan menunggu tindakan anda. ".Html::a('Klik Sini', ['ptb/senarai-menunggu-setuju'], ['class' => 'label label-info']), $ver->icno);
        }
//        foreach($app as $app){
//        $this->notification('PTB', "Permohonan Perpindahan Jabatan menunggu tindakan anda. ".Html::a('Klik Sini', ['ptb/senarai-menunggu-peraku'], ['class' => 'label label-info']), $app->icno);
//        }
 
       Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi Berjaya Dihantar']);
    }
    
     protected function notifiKelulusan(){
        $ver = \app\models\ptb\TblPenyelia::find()->all();
        foreach($ver as $ver){
         $this->notification('PTB', "Kelulusan Pertukaran Tempat Bertugas Kakitangan Pentadbiran untuk makluman pihak tuan/puan. ".Html::a('Klik Sini', ['ptb/senarai-kelulusan-ptb'], ['class' => 'label label-info']), $ver->icno); 
          
        }
      Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi Berjaya Dihantar']);
    }
    


}
