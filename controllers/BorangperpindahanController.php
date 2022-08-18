<?php

namespace app\controllers;

use Yii;
use app\models\kemudahan\Borangperpindahan; 
use app\models\Kemudahan\Refpegawai;
use app\models\hronline\Tblalamat;
use yii\web\UploadedFile;
use app\models\Notification;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\models\hronline\Department;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use app\models\kemudahan\Tblaccess;
use app\models\Kemudahan\Kemudahan;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\kemudahan\TblPayInstructDetails;
use app\models\kemudahan\TblPayinstruct;


class BorangperpindahanController extends \yii\web\Controller
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
                    'logout' => ['post'],
                    'remove-staff' => ['post'],
                ],
            ],
        ];
    }
   
     public function notification($icno, $content)
    { 
        $ntf = new Notification();
        $ntf->icno = $icno;  
        $ntf->title = 'Permohonan Kemudahan Atas Talian';
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        return true;
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    
     protected function findModel($id)
    {
        if (($model = Borangperpindahan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionMaklumatPerpindahan($id)
    {  
        $icno = Yii::$app->user->getId();   
        $model = new Borangperpindahan();
        $model->icno = $icno;
        $checkOpen = Kemudahan::find()->where(['status' => 0, 'jeniskemudahan' => 1])->one();
        
        if($checkOpen){
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => $checkOpen->reason]);
           
            return $this->redirect(['kemudahan/index']);
        }
        $checkApplication = Borangperpindahan::find()->where(['status_semasa' => 0,'icno' => $icno]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['borang/senarai']);
        }
        $peg_tadbir = TblAccess::findOne(['admin_post' => 1 ]); 
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]); 
         
        $model->entry_date = date('Y-m-d H:i:s');
        $model->icno = $icno;
        $model->jeniskemudahan = 1;
        $model->status_semasa  = '0';
        $model->entry_type = 1;
               
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
       if($model->load(Yii::$app->request->post())){
          
         $ntf = new Notification();
         $ntf2 = new Notification();  
          
        $model->status_pt = 'MENUNGGU TINDAKAN';
        $model->status_pp = 'MENUNGGU TINDAKAN';
        $model->status_kj = 'NEW';
        $model->stat_bendahari = 'NEW';
         
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
           if ($model->alamat->addr2 == 'NULL' || $model->alamat->addr2 == '-' || $model->alamat->addr3 == '-' || $model->alamat->addr3 == 'NULL'){ 
               
               $model->new_add = $model->alamat->addr1; 
           }else{ 
                $model->new_add = $model->alamat->addr1.' '.$model->alamat->addr2.' '.$model->alamat->addr3;
           
           } 
                        
            if ($model->save(false)) { 
                            
                 $ntf->icno = $peg_tadbir->icno; // peg  penyelia perjawatan
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan Perpindahan Rumah menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangperpindahan/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                          
                         
                     $ntf2->icno = $peg_bsm->icno;; // peg perjawatan
                            $ntf2->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf2->content = "Permohonan Kemudahan Perpindahan Rumah menunggu tindakan perakuan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangperpindahan/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf2->ntf_dt = date('Y-m-d H:i:s');
                            $ntf2->save(); 
                            
             }  
             
             $this->notification($model->icno, 'Permohonan anda telah dihantar untuk diproses sila semak status permohonan anda.'.Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));
             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
             return $this->redirect(['borang/senarai']);
        }  
        return $this->render('form_perpindahan', [
            'model' => $model,
            'alamat' => Tblalamat::findAll(['ICNO' => $icno]), 
            'bil' => 1,
            
        ]);
    }
    
    public function actionLihatalamat($id) {
        return $this->render('lihatalamat', [
                    'model' => $this->findModelbyid($id),
        ]);
    }
    public function actionSenaraitindakan()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai  = '';
        $status = ['NEW', 'DILULUSKAN', 'MENUNGGU TINDAKAN', 'TIDAK DILULUSKAN'];
        if(Refpegawai::find()->where( ['pembantu_tadbir' => $icno] )->exists()){
            
            $senarai = Borangperpindahan::find()->where(['in', 'status_kj', $status])->orderBy(['entry_date' => SORT_DESC]);
            $title='Senarai Menunggu Semakan';
            
        }
        elseif(Refpegawai::find()->where( ['pegawai_bsm' => $icno] )->exists()){
            
            $senarai = Borangperpindahan::find()->where(['in', 'status_kj', $status])->orderBy(['entry_date' => SORT_DESC]);
            $title ='Senarai Menunggu Perakuan';
            
        }
        elseif(Department::find()->where(['chief' => $icno, 'id' => '158'])->exists()){
            
            $senarai = Borangperpindahan::find()->where(['in', 'status_kj', $status])->orderBy(['entry_date' => SORT_DESC]);
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
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['kemudahan/index']);}  
    }

    public function actionSemakan_pt($id)
    {
        $icno = Yii::$app->user->getId(); 
        $model = $this->findModel($id); 
        
        $query = Borangperpindahan::find()->where(['mohon' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]); 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $model->semakan_pt = date('Y-m-d H:i:s');
        $model->status_pp = 'MENUNGGU KELULUSAN';
        $model->stat_bendahari = 'ENTRY';
        if ($icno != '830828125667') {
            
             return $this->redirect(['kemudahan/index']);
        }
        if ($model->load(Yii::$app->request->post())) {
            if($model->status_pt == ''){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }
                else{
                
                $model->semakan_by = $icno;                   
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                return $this->redirect(['borangperpindahan/senaraitindakan']);
                }
        }
        return $this->render('semakan_pt', [
            'model' => $model, 
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
       
    }
    public function actionTindakan_bsm($id)
    {
        $icno = Yii::$app->user->getId();
         
        $model = $this->findModel($id);
        $chief = Department::findOne(['id' => '158']);
         
        $query = Borangperpindahan::find()->where(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]); 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $model->ver_date = date('Y-m-d H:i:s');
        $model->status_kj = 'MENUNGGU TINDAKAN';
        $model->stat_bendahari = 'MENUNGGU TINDAKAN';
        if ($icno != '800224125722') {
            
             return $this->redirect(['kemudahan/index']);
        }
        if ($model->load(Yii::$app->request->post())) {
           
           if($model->status_pp == ''){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }
                else{ 
           $ntf = new Notification();
            
           $ntf->icno =   $chief->chief; // Tindakan Kj
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan Perpindahan Rumah menunggu tindakan Kelulusan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangperpindahan/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save(); 
            
           $model->peraku_by = $icno;                   
           $model->save(false);     
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
           return $this->redirect(['borangperpindahan/senaraitindakan']);
            }
        }
        return $this->render('tindakan_bsm', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            
        ]);
       
    }
    public function actionTindakan_kj($id)
    {
        $icno = Yii::$app->user->getId();           
        $model = $this->findModel($id);
        $chief = Department::find()->where(['chief' => $icno, 'id' => '158'])->exists(); 
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]);
         
        $query = Borangperpindahan::find()->where(['mohon' => 1])->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]); 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
        
        $model->isActive2 = '2';
        $model->stat_bendahari = 'MENUNGGU KELULUSAN';
        $model->app_date = date('Y-m-d H:i:s'); 
       
        if ($icno != $chief) {
            
            return $this->redirect(['kemudahan/index']);
        }
    
        if ($model->load(Yii::$app->request->post())) {
            
            if($model->status_kj == ''){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }
           elseif($model->status_kj == 'TIDAK DILULUSKAN'){  
           $ntf = new Notification();
           $model->status_semasa = '1';
           
           $ntf->icno = $model->icno;
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan anda tidak diluluskan.".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save(); 
                             
           $model->pelulus_by = $icno;                                    
           $model->save(false);
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
           return $this->redirect(['borangperpindahan/senaraitindakan']);
           }
           else{
            $ntf2 = new Notification();

            $ntf2->icno = $peg_bsm->icno; // pemohon
            $ntf2->title = 'Permohonan Kemudahan Atas Talian';
            $ntf2->content = "Permohonan kemudahan telah diluluskan oleh Ketua BSM kini menunggu tindakan daripada anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangperpindahan/senaraiberjaya'], ['class'=>'btn btn-primary btn-sm']);
            $ntf2->ntf_dt = date('Y-m-d H:i:s');
            $ntf2->save();     

            $model->pelulus_by = $icno;                   
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
            return $this->redirect(['borangperpindahan/senaraitindakan']);
           }
        }
        
        return $this->render('tindakan_kj', [
            'model' => $model, 
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
    }
    
     public function actionSenaraiberjaya()
    {
       
        $model = new Borangperpindahan();
        $model->icno = Yii::$app->user->getId();
        $pay = new TblPayinstruct();
        $infoPay = new TblPayInstructDetails();
        
        $peg_bendahari = TblAccess::findOne(['admin_post' => 4]); 
        $status = ['DILULUSKAN']; 
        $models = Borangperpindahan::find()->All();
        $query = Borangperpindahan::find()->where([ 'status_kj' => $status]) ->andWhere(['isActive2' => 2]);
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $selection=(array)Yii::$app->request->post('selection');//typecasting
        $ntf = new Notification();
        
            if (Yii::$app->request->post('simpan')){ 
                foreach ($selection as $id ) {
                    
                    $model = $this->findModel($id); 
                    $pay = new TblPayinstruct();  
                    $infoPay = new TblPayInstructDetails();
                    
                    if('y'.$id == Yii::$app->request->post($id)){
                    $model->isActive2 ='1';
                    $model->stat_bendahari = 'DALAM PROSES BAYARAN'; 
                    $model->tarikh_hantar = date('Y-m-d H:i:s');  
                    $model->status_semasa = '1';
                    $model->mohon = '1';
                    
                    $infoPay->icno =  $model->icno;
                    $infoPay->elaun_kemudahan = $model->jeniskemudahan ;
                    $infoPay->jumlah = $model->jumlah;
                    $infoPay->from = $model->entry_date;
                    $infoPay->until = $model->entry_date;
                    $infoPay->jenis_kiraan = 'FIXED';
                    $infoPay->parent_id = $model->id;
                    $infoPay->approver_status = $model->status_kj;
                    $infoPay->approver_date = $model->app_date;
                    $infoPay->approver_remark = $model->catatan_kj; 
                    $infoPay->entry_type = $model->entry_type;
            
                    $pay->PAY_STAFF_ICNO =  $model->icno; 
                    $pay->PAY_NEW_VALUE = $model->jumlah;
                    $pay->PAY_DATE_FROM = $model->entry_date;
                    $pay->PAY_DATE_TO = $model->entry_date; 
                    $pay->PAY_REF_ID = $model->id;
                    $pay->PAY_ENTRY_TYPE = $model->entry_type;
                    $pay->PAY_PARENT_ID = $model->id;
                    $pay->PAY_ELAUN_ID = $model->jeniskemudahan;
                    
                     $ntf->icno = $peg_bendahari->icno; // notification kpd bendahari
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan Perpindahan Rumah menunggu tindakan anda untuk diproses.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangperpindahan/senaraibendahari'], ['class'=>'btn btn-primary btn-sm']);;
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                            
                     $this->notification($model->icno, "Permohonan anda telah diluluskan oleh Ketua BSM, kini dalam proses pembayaran Bendahari"." ".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));
                     $model->save(false); 
                     $infoPay->save(false);
                     $pay->save(false);
                    }
                    
                    elseif('n'.$id == Yii::$app->request->post($id)){
                    $model = $this->findModel($id);
                    $model->isActive2 ='2';
                    $model->save(); 
                    }
            } 
            }
            
        return $this->render('senaraiberjaya', [
            'model' => $model,
            'models' => $models,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
    }
    
    public function actionSenaraibendahari()
    {
       
        $icno = Yii::$app->user->getId();   
        $status = ['DILULUSKAN'];
        $model = Borangperpindahan::find()->where(['in', 'status_kj', $status])->andWhere(['isActive2' => 1])->orderBy(['entry_date' => SORT_DESC])->All();
   
        return $this->render('senarai_bendahari', [
            'model' => $model, 
            'bil' => 1,
        ]); 
    }
    
    public function actionTindakan_bendahari($id)
    {
        $icno = Yii::$app->user->getId();           
        $model = $this->findModel($id); 
        
        $query = Borangperpindahan::find()->where(['mohon' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('tindakan_bendahari', [
            'model' => $model, 
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
    }
     
    public function actionLaporan( $tahun = null, $bulan = null) {
       
        $year = date('Y');
        $mth = date('m');
        $icno = Yii::$app->user->getId();
       
        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $mth = $bulan;
        }
        $model = new Borangperpindahan();
       
        if($bulan == 0 ){
         $query =  Borangperpindahan::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
           
        }else{
            $query =  Borangperpindahan::find()->where(['MONTH(entry_date)' => $mth])->andWhere(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
        
        }
        $sum = $query->sum('jumlah_tuntutan');
        $statistik = Borangperpindahan::find()->select(new \yii\db\Expression("MONTH(`entry_date`) AS BULAN, COUNT(`id`) AS TOTAL"))->where(['YEAR(entry_date)' => $year])->groupBy('MONTH(`entry_date`)')->asArray()->all();
        
        $label = ArrayHelper::getColumn($statistik, 'BULAN');
        $data = ArrayHelper::getColumn($statistik, 'TOTAL');
      
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
         $access = [ 921126126634, 800224125722, 830828125667];
         if(in_array($icno, $access)){
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
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf',
        'type' => 'error', 'msg' => 'Anda Tidak Mempunyai Akses']);
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
        $model = Boragperpindahan::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC])->all();
       
        }else{
        $model = Borangperpindahan::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC])->all();
      
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
            $facility = Borangperpindahan::find()->where(['icno' => $model])->andWhere(['id' =>  $id])->one();
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
    
    public function actionPadam(){
        return Yii::$app->FileManager->DeleteFile('');//insert the code
        
    }
     public function actionNewEntry()
    { 
       
        $icno = Yii::$app->user->getId();   
        $model = new Borangperpindahan();
       
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]); 
        
        $model->entry_date = date('Y-m-d H:i:s'); 
        $model->jeniskemudahan = 1;
        $model->entry_type = 2;
        $model->status_kj = 'DILULUSKAN';
        $model->isActive2 = 2;
        $model->mohon = 1;
        $model->stat_bendahari = 'MENUNGGU TINDAKAN'; 
        $model->status_semasa = 0;  
       
        
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
        
       if($model->load(Yii::$app->request->post())){
          
         $ntf = new Notification();
         
         
        if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'document_sokongan');
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
    
                     $ntf->icno = $peg_bsm->icno;; // peg perjawatan
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan Perpindahan Rumah menunggu tindakan anda untuk diproses.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangperpindahan/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();  
                            
            $model->save(false);                
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
            return $this->redirect(['borangperpindahan/new-entry']);
        }  
        return $this->render('new_entry', [
            'model' => $model,
            'alamat' => Tblalamat::findAll(['ICNO' => $icno]), 
            'bil' => 1,
            
        ]);
    }
}
