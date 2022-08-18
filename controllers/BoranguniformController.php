<?php

namespace app\controllers;

use Yii;
use app\models\kemudahan\Boranguniform;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Notification; 
use yii\helpers\Html;
use app\models\hronline\Department;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use kartik\mpdf\Pdf;
use app\models\kemudahan\Tblaccess;
use app\models\Kemudahan\Kemudahan;
use yii\filters\AccessControl;
use tebazil\runner\ConsoleCommandRunner;
use app\models\kemudahan\Refbukapermohonan;
use app\models\kemudahan\TblPayinstruct;
use app\models\kemudahan\TblPayInstructDetails; 
/**
 * BoranguniformController implements the CRUD actions for Boranguniform model.
 */
class BoranguniformController extends Controller
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
     * Lists all Boranguniform models.
     * @return mixed
     */
    public function notification($icno, $content)
    { 
        $ntf = new Notification();
        $ntf->icno = $icno;  
        $ntf->title = 'Tuntutan Kasut & Pakaian Seragam';
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        return true;
    }
    
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Boranguniform::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    } 

    /**
     * Finds the Boranguniform model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Boranguniform the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Boranguniform::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionMaklumatSeragam(){
        
        $icno = Yii::$app->user->getId();  
        $peg_tadbir = TblAccess::findOne(['admin_post' => 6 ]);  
        $model = new Boranguniform(); 
        $model->icno = Yii::$app->user->getId();
        $chief = Department::findOne(['id' => $model->kakitangan->DeptId]);
 
        $model->entry_date = date('Y-m-d H:i:s');
        $model->icno = $icno;
        $current_date= date('Y-m-d');
        $open = Refbukapermohonan::find()->where(['or', "start_mohon".">='$current_date'", "end_mohon<='$current_date'" ]) ->one();  
     
        if($open){
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan belum dibuka.']);
           
            return $this->redirect(['kemudahan/index']);
        }
        $checkOpen = Kemudahan::find()->where(['status' => 0, 'jeniskemudahan' => 11])->one();

        if($checkOpen){
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => $checkOpen->reason]);
           
            return $this->redirect(['kemudahan/index']);
        }
        $checkApplication = Boranguniform::find()->where(['status_semasa' => 0,'icno' => $icno]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['borang/senarai']);
        }
        
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
        
       if($model->load(Yii::$app->request->post())){
       
        $check = Boranguniform::find()->where('YEAR(entry_date) > YEAR(NOW() - INTERVAL 3 YEAR)')->andwhere(['icno' => $icno]);
        $checkCd = Boranguniform::find()->where('YEAR(entry_date) > YEAR(NOW() - INTERVAL 1 YEAR)')->andWhere(['icno' => $icno]);
        $uniform = Boranguniform::find()->where(['icno' => $icno])->one();
//        $cd3 = Boranguniform::find()->where('YEAR(entry_date) > YEAR(NOW() - INTERVAL 1 YEAR)')->andWhere(['jenis_seragam' => 2,'icno' => $icno]);


//        $checkCount = Boranguniform::find()->where(['icno' => $icno])->count();
        
        if($model->jenis_seragam == 2 || $model->jenis_seragam == 3){
            if($model->jenis_belian != null || $model->bil_belian != null ){
              Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda telah memilih jenis tuntutan Pakaian Seragam. Sila kosongkan ruangan Jenis kasut dan Bil.Kasut!']);
              return $this->redirect(['boranguniform/maklumat-seragam']);
              
            }
         }
            
        if($check->exists() && $model->jenis_seragam == 3){
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda belum layak untuk memohon. Permohonan Pakaian Seragam Khas hanya boleh dibuat sekali dalam 3 tahun']);
             return $this->redirect(['borang/sejarahpermohonan']);
        }
//        elseif(!$checkCd && $uniform->jenis_seragam == 1 && $uniform->jenis_seragam == 2){
////            }elseif($model->jenis_seragam == '01'  && $checkCount >= 1 && $check2->exists()){
//
//             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda belum layak untuk memohon. Permohonan Belian Kasut hanya boleh dibuat sekali dalam 1 tahun']);
//             return $this->redirect(['borang/sejarahpermohonan']);
//        }
      
        else{
            
            
        
         $ntf = new Notification();
         $ntf2 = new Notification();  
         
        $model->jeniskemudahan = '11'; 
        $model->status_pt = 'MENUNGGU TINDAKAN';
        $model->status_pp = 'MENUNGGU TINDAKAN';
        $model->status_kj = 'ENTRY';
        $model->peraku_by =  $chief->chief;
        $model->stat_bendahari = 'NEW';
        $model->status_semasa = '0';    
        $model->pengakuan = '1';
        $model->semakan_by = $peg_tadbir->icno;
        $model->status_label = '1';
       
        
        if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'document_LN1');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }
        if($file2){
                $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'document_kelulusan');
                $filepath2 = $fileapi->file_name_hashcode;   
        }
        else{
            $filepath2 = '';
        }
  
        $model->dokumen_sokongan = $filepath;
        $model->dokumen_sokongan2 = $filepath2;
         
            if ($model->save(false)) {
                          $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);

                 $ntf->icno = $pegawai->chief; // peg  penyelia perjawatan
                            $ntf->title = 'Tuntutan Kasut & Pakaian Seragam';
                            $ntf->content = "Permohonan Tuntutan Kasut & Pakaian Seragam menunggu tindakan perakuan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['boranguniform/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                          
                         
                     $ntf2->icno = $peg_tadbir->icno; // peg perjawatan
                            $ntf2->title = 'Tuntutan Kasut & Pakaian Seragam';
                            $ntf2->content = "Permohonan Tuntutan Kasut & Pakaian Seragam menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['boranguniform/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf2->ntf_dt = date('Y-m-d H:i:s');
                            $ntf2->save();
             } 
              
             $this->pendingtask($chief->chief,29);
             $this->notification( $model->icno, 'Permohonan anda telah dihantar untuk diproses sila semak status permohonan anda.'.Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));
             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
             return $this->redirect(['borang/senarai']);
        }
       }
        return $this->render('form_seragam', [
            'model' => $model,
        ]);
    }
    
    public function actionSenaraitindakan()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai  = '';
        $model = new Boranguniform();  
        $model->icno = Yii::$app->user->getId(); 
        $status = ['NEW', 'DILULUSKAN', 'MENUNGGU TINDAKAN', 'TIDAK DILULUSKAN', 'DIPERAKUKAN', 'TIDAK DIPERAKUKAN', 'ENTRY'];
//        if(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [6,5], 'isActive' => 1])->exists()){  
         if(Department::find()->where(['chief' => Yii::$app->user->getId(), 'isActive' => 1])->exists()){ // jfib
            
            $senarai = Boranguniform::find()->where(['in', 'status_kj', $status])->andWhere(['jeniskemudahan' => 11, 'peraku_by' => $icno ])->orderBy(['entry_date' => SORT_DESC]);
            $title='Senarai Menunggu Perakuan';
            
        }
//        elseif(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [7,5], 'isActive' => 1])->exists()){        
         elseif(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [6], 'isActive' => 1])->exists()){   //pegawai tadbir bpg
   
            $senarai = Boranguniform::find()->where(['in', 'status_kj', $status])->andWhere(['jeniskemudahan' => 11])->orderBy(['entry_date' => SORT_DESC]);
            $title ='Senarai Menunggu Semakan';
            
        }
//        elseif(Department::find()->where(['chief' => $icno, 'id' => '158'])->exists()){
         elseif(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [7,5], 'isActive' => 1])->exists()){   // pegawai bpg     
            
            $senarai = Boranguniform::find()->where(['in', 'status_kj', $status])->andWhere(['jeniskemudahan' => 11])->orderBy(['entry_date' => SORT_DESC]);
            $title ='Senarai Menunggu Kelulusan';
            
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
            'model' => $model,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['kemudahan/index']);}  
    }  
     public function actionTindakan_kj($id)
    {   //tindakan_pegawai_bpg
        $icno = Yii::$app->user->getId();
        $peg_tadbir = TblAccess::findOne(['admin_post' => 6 ]);   
        $model = $this->findModel($id);
        $query = Boranguniform::find()->where(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
           
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
        
        if ($model->load(Yii::$app->request->post())) {
           
           if($model->status_pp == ''){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }
                else{ 
           
           $model->ver_date = date('Y-m-d H:i:s');
           $model->status_pt = 'MENUNGGU SEMAKAN';           
           $model->peraku_by = $icno;  
           $model->status_label = '2'; 
           
           $model->save(false);    
           $this->pendingtask($peg_tadbir->icno, 30);
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
           return $this->redirect(['boranguniform/senaraitindakan']);
            }
        }
        return $this->render('tindakan_kj', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
             
        ]); 
    }
    
    public function actionSemakan_pt($id)
    {   //tindakan_jfpiu
        $icno = Yii::$app->user->getId(); 
        $model = $this->findModel($id); 
        $peg_bpg = TblAccess::findOne(['admin_post' => 7 ]);  
        $query = Boranguniform::find()->where(['icno' => $model ])->orderBy(['entry_date' => SORT_DESC]);

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         
 
        if ($model->load(Yii::$app->request->post())) {
            
         
            if($model->status_pt == ''){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }
                else{
                    
                    $ntf = new Notification();
            
           $ntf->icno = $peg_bpg->icno; // Tindakan Kj
                            $ntf->title = 'Tuntutan Kasut & Pakaian Seragam';
                            $ntf->content = "Permohonan Tuntutan Kasut & Pakaian Seragam menunggu tindakan Kelulusan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['boranguniform/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save(); 
            $model->semakan_pt = date('Y-m-d H:i:s');
            $model->status_pp = 'MENUNGGU KELULUSAN';
            $model->stat_bendahari = 'ENTRY';  
            $model->pelulus_by = $peg_bpg->icno;
            $model->save(false); 
            $this->pendingtask($peg_bpg->icno, 31);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
            return $this->redirect(['boranguniform/senaraitindakan']);
            }
        }
        return $this->render('semakan_pt', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
           
        ]); 
    }
    
   
    
    public function actionTindakan_bpg($id)
    {   //tindakan_pegawai_bpg
        $icno = Yii::$app->user->getId();           
        $model = $this->findModel($id); 
        $pay = new TblPayinstruct();
        $infoPay = new TblPayInstructDetails(); 
        $peg_bendahari = TblAccess::findOne(['admin_post' => 4]); 
 
        $query = Boranguniform::find()->where(['mohon' => 1])->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
  
        if ($model->load(Yii::$app->request->post())) {
            
            if($model->status_kj == ''){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }
           elseif($model->status_pp == 'TIDAK DILULUSKAN' || $model->status_pp == 'TIDAK LENGKAP'){  
           $ntf = new Notification();
           $model->status_semasa = '1';
           $model->status_label = 4;

           $ntf->icno = $model->icno;// peg  penyelia perjawatan
                            $ntf->title = 'Tuntutan Kasut & Pakaian Seragam';
                            $ntf->content = "Permohonan Tuntutan Kasut & Pakaian Seragam anda tidak diluluskan.".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save(); 
                             
           $infoPay->icno =  $model->icno;
           $infoPay->elaun_kemudahan = $model->jeniskemudahan ; 
           $infoPay->from = $model->entry_date;
           $infoPay->until = $model->entry_date;
           $infoPay->jenis_kiraan = 'FIXED';
           $infoPay->parent_id = $model->id;
           $infoPay->approver_status = $model->status_pp;
           $infoPay->approver_date = $model->ver_date;
           $infoPay->approver_remark = $model->catatan_pp; 
//           $infoPay->entry_type = $model->entry_type;

           $pay->PAY_STAFF_ICNO =  $model->icno;  
           $pay->PAY_DATE_FROM = $model->entry_date;
           $pay->PAY_DATE_TO = $model->entry_date; 
           $pay->PAY_REF_ID = $model->id;
//           $pay->PAY_ENTRY_TYPE = $model->entry_type;
           $pay->PAY_PARENT_ID = $model->id;
           $pay->PAY_ELAUN_ID = $model->jeniskemudahan;
                    
           $infoPay->save(false);
           $pay->save(false); 
           $model->pelulus_by = $icno;                                   
           $model->save(false);
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
           return $this->redirect(['boranguniform/senaraitindakan']);
           }
           else{
            $ntf2 = new Notification();

            $ntf2->icno = $peg_bendahari->icno; // notification kpd bendahari
            $ntf2->title = 'Tuntutan Kasut & Pakaian Seragam';
            $ntf2->content = "Permohonan Tuntutan Kasut & Pakaian Seragam menunggu tindakan anda untuk diproses.".Html::a('<i class="fa fa-arrow-right"></i>', ['boranguniform/senaraibendahari'], ['class'=>'btn btn-primary btn-sm']);;
            $ntf2->ntf_dt = date('Y-m-d H:i:s');
            $ntf2->save();     
             
            $model->app_date = date('Y-m-d H:i:s');  
            $model->pelulus_by = $icno;       
            $model->status_label = 3;
            $model->isActive2 ='1';
            $model->stat_bendahari = 'DALAM PROSES BAYARAN'; 
            $model->tarikh_hantar = date('Y-m-d H:i:s');   
            $model->status_semasa = '1';
            $model->mohon = '1';
            $model->save(false);
             $this->notification($model->icno, "Permohonan Tuntutan Kasut & Pakaian Seragam anda telah diluluskan"." ".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
            return $this->redirect(['boranguniform/senaraitindakan']);
           }
        }
        
        return $this->render('tindakan_bpg', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
    }
     
    public function actionSenaraibendahari()
    {
       
        $icno = Yii::$app->user->getId();
         
        $status = ['DILULUSKAN'];
        $model = Boranguniform::find()->where(['in', 'status_pp', $status])->andWhere(['isActive2' => 1, 'jeniskemudahan' => 11])->orderBy(['entry_date' => SORT_DESC])->All();
   
        return $this->render('senarai_bendahari', [
            'model' => $model, 
            'bil' => 1,
        ]);
        
    }
    
     public function actionTindakan_bendahari($id)
    {
        $icno = Yii::$app->user->getId();           
        $model = $this->findModel($id);
         
 
        $query = Boranguniform::find()->where(['mohon' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
       
        
        $model->bendahari_date = date('Y-m-d H:i:s');   
          
        if ($model->load(Yii::$app->request->post())) {
           if($model->stat_bendahari == '' || $model->stat_bendahari == 'DALAM PROSES BAYARAN'){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'info', 'msg' => 'Status Permohonan Menunggu Tindakan Anda!']); 
            
                }
           else{   
               
               $ntf = new Notification();
               
               $ntf->icno = $model->icno; // peg  penyelia perjawatan
                                 $ntf->title = 'Tuntutan Kasut & Pakaian Seragam';
                                 $ntf->content = "Permohonan Tuntutan Kasut & Pakaian Seragam anda telah berjaya. Tindakan pembayaran oleh pihak Bendahari telah dilaksanakan.".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']);
                                 $ntf->ntf_dt = date('Y-m-d H:i:s');
                                 $ntf->save();
                                 
           $model->save();
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
           return $this->redirect(['boranguniform/senaraibendahari']);
           }
        }
        
        return $this->render('tindakan_bendahari', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
    }
    
    public function actionLaporan( $tahun = null, $bulan = null) {
       
        $year = date('Y');
        $mth = date('m');
         
        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $mth = $bulan;
        }
        $model = new Boranguniform();
       
        if($bulan == 0 ){
         $query =  Boranguniform::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
           
        }else{
            $query =  Boranguniform::find()->where(['MONTH(entry_date)' => $mth])->andWhere(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
        
        }
        $sum = $query->sum('jumlah_tuntutan');
        $statistik = Boranguniform::find()->select(new \yii\db\Expression("MONTH(`entry_date`) AS BULAN, SUM(`jumlah_tuntutan`) AS JUMLAH"))->where(['YEAR(entry_date)' => $year])->groupBy('MONTH(`entry_date`)')->asArray()->all();
        
        $label = ArrayHelper::getColumn($statistik, 'BULAN');
        $data = ArrayHelper::getColumn($statistik, 'JUMLAH');
      
        foreach ($label as $ind => $l){
            if ($l == 1){
                $label[$ind] = 'JANUARI';
            }else if($l == 2){
                $label[$ind] = 'FEBRUARI';
            }else if($l == 3){
                $label[$ind] = 'MAC';
            }else if($l == 4){
                $label[$ind] = 'APRIL';
            }else if($l == 5){
                $label[$ind] = 'MEI';
            }else if($l == 6){
                $label[$ind] = 'JUN';
            }else if($l == 7){
                $label[$ind] = 'JULAI';
            }else if($l == 8){
                $label[$ind] = 'OGOS';
            }else if($l == 9){
                $label[$ind] = 'SEPTEMBER';
            }else if($l == 10){
                $label[$ind] = 'OKTOBER';
            }else if($l == 11){
                $label[$ind] = 'NOVEMBER';
            }else if($l == 12){
                $label[$ind] = 'DISEMBER';
            }
        }
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
            
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('laporan', ['tahun' => $year, 'bulan' => $mth, 'dataProvider' => $DataProvider, 
           'model' => $model, 'label' => $label,
           'data' => $data,
           'sum' => $sum,
            ]);
 
        return $this->redirect(['kemudahan/index']);

    }
    
    public function actionReportpentadbiran($tahun = null, $bulan = null)
    {
        $year = date('Y');
        $mth = date('m');
       
        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $mth = $bulan;
        } 
        
        if($bulan == 0){
        $model = Boranguniform::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC])->all();
       
        }else{
        $model = Boranguniform::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC])->all();
      
        }
        
        return $this->render('reportpentadbiran', [
            'tahun' => $year,
            'bulan' => $mth, 
            'model' => $model,
        ]);
    }  
    public function actionSlulus($id)
        {   $css = file_get_contents('./css/kelulusan.css');
            #cehck application
            $model = $this->findModel($id);
            $icno = Yii::$app->user->getId();   
            $facility = Boranguniform::find()->where(['icno' => $model])->andWhere(['id' =>  $id])->one();
     //     get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('slulus', ['facility' => $facility ]);
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
    //             'marginBottom' => 35,
                'marginLeft' => 24,
                'marginRight' => 24,
                'methods' => [
                'SetHeader' => ['SURAT PENEMPATAN'],
                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                'WriteHTML' => [$css, 1]
    //          'SetFooter' => [' {PAGENO}'],
                ]
            ]);
            // return the pdf output as per the destination setting
            return $pdf->render();
        }
        
        public function actionTuntutan($id){
        $model = Boranguniform::findOne(['id' => $id]);
        $chief = Department::find()->where(['id' => '158'])->exists(); 
       
        $mpdf = new \Mpdf\Mpdf(['mode' => 'UTF-8', 
        // "allowCJKoverflow" => true, 
        "autoScriptToLang" => true,
        // "allow_charset_conversion" => false,
        "autoLangToFont" => true,]);
        $mpdf->allow_charset_conversion = true;
        $mpdf->charset_in = 'iso-8859-4';
        $pagecount = $mpdf->SetSourceFile('uploads/tuntutan_seragam.pdf');
            for ($i=1; $i<=$pagecount; $i++) {
                $import_page = $mpdf->ImportPage($i);
                $mpdf->UseTemplate($import_page);
                if($i==1){ //page1
                $mpdf->WriteHTML($this->renderPartial('borangtuntutan', ['model' => $model, 'chief' => $chief]));
                }
                if ($i < $pagecount){
                $mpdf->AddPage();}
            }
            $mpdf->Output();
        }
    public function actionPadam(){
        return Yii::$app->FileManager->DeleteFile('');//insert the code
        
    }  
    
     protected function pendingtask($icno, $id){
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }
    public function actionResit($id){
               
        $model = $this->findModel($id);
         
        $query = Boranguniform::find()->where(['isActive2' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if ($model->load(Yii::$app->request->post())) {
            $model->resit_stat = 1; 
            $model->resit_rec_dt = date('Y-m-d H:i:s');
            if($model->resit_stat == ''){
                
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }                  
                else{  
                $model->save(false); 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                return $this->redirect(['boranguniform/senaraitindakan']);
                
                }
        }
                return $this->renderAjax('resit', [
                        'model' => $model,
//                        'searchModel' => $searchModel,
                        'dataProvider' => $DataProvider,
                        'bil' => 1,
                    ]);

                }
}
