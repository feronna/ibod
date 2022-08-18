<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\ln\Ln;
use app\models\ln\Model;
use app\models\ln\TblPeserta;
use app\models\ln\LnSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\ln\Pegawai;
use app\models\ln\TblSurat;
use app\models\cuti\SetPegawai;
use app\models\Notification;
use yii\helpers\Html;
use yii\web\UploadedFile;
use DateTime;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
use app\models\ln\RefTravel;

error_reporting(0);

/**
 * LnController implements the CRUD actions for Ln model.
 */
class LnController extends Controller
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
    
    public function actionIndex()
    {
        $searchModel = new LnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findBiodata($icno) {
        return Tblprcobiodata::findOne(['ICNO' => $icno]);
    } 
    
//    public function actionMain()
//    {        
//        $model = new Ln();
//
//        if ($model->load(Yii::$app->request->post())){ 
// 
//        $date1=new DateTime($model->date_from);
//
//        $date2=new DateTime("now");
//        $tempoh = date_diff($date1, $date2)->format('%a Hari'); 
//
//        if (($tempoh <= 12) || ($tempoh == 0)){
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Borang Permohonan LN-1 permohonan yang lengkap diisi beserta dokumen sokongan hendaklah diterima sampai ke Pejabat Canselori tidak kurang dari tempoh 14 hari sebelum perjalanan. Permohonan lewat dari tempoh tersebut hendaklahlah disertakan dengan alasan/justifikasi yang kukuh.']);
//            return $this->redirect(['index']);
//                }
//        else{                     
//            return $this->redirect(['mohon']);}
//        }
//        
//        return $this->render('main', [
//            'model' => $model,       
//        ]);
//    }
    
    public function actionSemakanPermohonan()
    { 
        $this->checkingSejarahPermohonan();

        $permohonan = $this->GridPermohonanAktif();

        return $this->render('semakan_permohonan', [
           'permohonan' => $permohonan,
        ]);
    }
    
        public function GridPermohonanAktif() 
    {
        $icno = Yii::$app->user->getId();
        $data = new ActiveDataProvider([
            'query' => Ln::find()->where(['icno' => $icno])->andWhere(['isActive' => 1]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
    
    public function actionSejarahPermohonan() 
    {

        $permohonan = $this->GridPermohonanTidakAktif();

        return $this->render('sejarah_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }
    
    public function GridPermohonanTidakAktif() 
    {
        $icno = Yii::$app->user->getId();
        $data = new ActiveDataProvider([
            'query' => Ln::find()->where(['icno' => $icno])->andWhere(['isActive' => 0]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
    
    public function GridLampiranA() 
    {
        $icno = Yii::$app->user->getId();
        $data = new ActiveDataProvider([
            'query' => Ln::find()->where(['icno' => $icno, 'lampiran' => [0,1]]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
    
    public function GridPermohonanLn2() 
    {
        $icno = Yii::$app->user->getId();
        $data = new ActiveDataProvider([
            'query' => Ln::find()->where(['icno' => $icno, 'status' => 'LULUS', 'hantar' => [0,1]]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
    
    public function checkingSejarahPermohonan() 
    {
        $permohonan = $this->findSuratTelahDiHantar();

        foreach ($permohonan as $permohonan) {

            $datetime1 = new DateTime($permohonan->letter_date);
            $datetime2 = new DateTIme('now');
            $interval = $datetime1->diff($datetime2);

            if ($interval->format('%d') >= 7) {
                $permohonan->isActive = 0;
                $permohonan->save(false);
            }
        }
    }
    
    protected function findSuratTelahDiHantar() 
    {
        return Ln::find()->Where(['letter_sent' => [1,2]])->all();
    }
    
    public function actionRekod()
    { 
        $searchModel = new LnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rekod', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }

    /**
     * Displays a single Ln model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new Ln model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    protected function notifikasi($icno, $content)
    {
        //--------Model Notification-----------//
                $ntf = new Notification(); //noti untuk kp
                $ntf->icno = $icno;
                $ntf->title = 'Permohonan Bertugas Rasmi Di Luar Negara';
                $ntf->content = $content;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                //--------Model Notification-----------//
    }
         
//    public function actionMohon()
//    {
//        $icno = Yii::$app->user->getId(); 
////        $check = Ln::find()->where('YEAR(entry_date) >= YEAR(NOW() - INTERVAL 3 YEAR)')->andWhere(['mohon' => 1 ,'icno' => $icno]);
////        if($check ->exists()){
////             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda belum layak untuk memohon. Permohonan hanya boleh dibuat sekali dalam 3 tahun.']);
////           
////            return $this->redirect(['sejarah-permohonan']);
////        }
//        $checkApplication = Ln::find()->where(['letter_sent' => [0],'icno' => $icno]);
//        if($checkApplication->exists()){
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
//            return $this->redirect(['semakan-permohonan']);
//        }
//   
//        $model = new Ln();
//        $searchModel = new LnSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $model->icno = $icno;   
//        $peserta =  Tblprcobiodata::find()->where(['Status' => 1])->orderBy(['gredJawatan' => SORT_ASC])->all();
//        $peranan = \app\models\ln\Refperanan::find()->all();
//        $status = Ln::findAll(['icno' => $icno]);
//        $mod=Ln::find()->where(['icno' => $icno])->orderBy(['id' => SORT_DESC])->one(); //cari status permohonan terakhir
//        
//        $displaymohon='none';
//
//        if($mod){
//        if(($mod->status =='TIDAK LULUS' ||  $mod->status == NULL)){
//            $displaymohon='';                               //show mohon form untuk yang sudah diluluskan dan yang pertama kali mohon
//        }}
//        elseif(!$mod){
//            $displaymohon=''; 
//        }
//        else{
//           Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda Masih Mempunyai Permohonan Yang Aktif']); 
//        }
//      
//        
//        // dynamic controller  code
//        
//        $modelCustomer = new Ln();
//        $modelsAddress = [new TblPeserta];
//        $modelCustomer->icno = $icno;  
//        $pegawai = Department::findOne(['id' => $modelCustomer->kakitangan->DeptId]);
//        
//        $file = UploadedFile::getInstance($modelCustomer, 'file');
//        
//        if ($modelCustomer->load(Yii::$app->request->post())){
//            
//            $modelsAddress = Model::createMultiple(TblPeserta::classname());
//            \app\models\ln\Model::loadMultiple($modelsAddress, Yii::$app->request->post());
//            
//        if($file){
//                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'rekodlantikan');
//                $filepath = $fileapi->file_name_hashcode;      
//            }
//            else{
//                $filepath = '';
//        }
//
//        $modelCustomer->dokumen_sokongan = $filepath;
//            
//        // ajax validation
//        if (Yii::$app->request->isAjax) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ArrayHelper::merge(
//                ActiveForm::validateMultiple($modelsAddress),
//                ActiveForm::validate($modelCustomer)
//            );
//        }
//            
//        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
//        $modelCustomer->app_by = $pegawai->chief; //kj 
//        }
//        else{
//        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
//        $modelCustomer->app_by = $pegawaisub->chief; //kj 
//        }
//        
//            $valid = $modelCustomer->validate();
//            $valid = Model::validateMultiple($modelsAddress) && $valid;
//            $modelCustomer->entry_date = date('Y-m-d H:i:s');
//            $modelCustomer->status_jfpiu = 'Tunggu Perakuan';
//            $modelCustomer->status_semakan = 'Tunggu Perakuan';   
//            $modelCustomer->status_nc = 'Tunggu Kelulusan';  
//            $modelCustomer->status ='DALAM TINDAKAN KETUA JABATAN';  
//            $petindak1='Ketua Jabatan';
//            $icnopetindak1= $modelCustomer->app_by;               
//        
//        if ($valid) {
//                $transaction = \Yii::$app->db->beginTransaction();
//                try {
//                    if ($flag = $modelCustomer->save(false)) {
//                        foreach ($modelsAddress as $modelAddress) {
//                              $modelAddress->ref_icno = $modelCustomer->icno;
//                              $modelAddress->parent_id = $modelCustomer->id;
//                              $modelAddress->entry_date = date('Y-m-d H:i:s');
//                            if (! ($flag = $modelAddress->save(false))) {
//                                $transaction->rollBack();
//                                break;
//                                
//                            }
//                        }
//                    }
//                    $this->notifikasi($icnopetindak1, "Permohonan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-kj'], ['class'=>'btn btn-primary btn-sm']));
//                    $this->notifikasi($modelCustomer->icno, "Permohonan anda telah dihantar untuk tindakan ".$petindak1. " ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
//                    //$this->notification('Permohonan Kemudahan Atas Talian', 'Permohonan anda telah dihantar untuk diproses sila semak status permohonan anda.'.Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));
//                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
//                    if ($flag) {
//                        $transaction->commit();
//                       
//                        return $this->redirect(['semakan-permohonan']);
//                    }
//                } catch (Exception $e) {
//                    $transaction->rollBack();
//                }
//            }
//            
//    
//        }
//        
//        return $this->render('mohon', [
//            'model' => $model,
//            'peserta' => $peserta,
//            'peranan' => $peranan,
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//            'status' => $status,
//            'displaymohon' => $displaymohon,
//            'mod' => $mod, 
//            'modelsCustomer' => $modelCustomer,
//            'modelsAddress' => $modelsAddress,
//            'modelsAddress' => (empty($modelsAddress)) ? [new TblPeserta] : $modelsAddress
//            
//        ]);        
//    }
    
    // Permohonan Bertugas Rasmi Ke Luar Negara (Pemohon)
    public function actionMohon()
    {
        $icno = Yii::$app->user->getId(); 
        $checkApplication = Ln::find()->where(['letter_sent' => [0],'icno' => $icno]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['semakan-permohonan']);
        }
   
        $model = new Ln();
        $searchModel = new LnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model->icno = $icno;   
        $peserta =  Tblprcobiodata::find()->where(['Status' => 1])->orderBy(['gredJawatan' => SORT_ASC])->all();
        $peranan = \app\models\ln\Refperanan::find()->all();
        // $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS']]); 
 
        $status = ['LULUS']; 
        $query1 = (new \yii\db\Query())
               ->select("icno, date_from, date_to, nama_lawatan, tujuan, nama_tempat, kod_peruntukan_cn, status")
               ->from('hrm.ln_tbl_ln')
               ->where(['icno' => $model->icno])
               ->andWhere(['status'=> $status]);

        $query2 = (new \yii\db\Query())
               ->select("icno, date_from, date_to, nama_lawatan, tujuan, nama_tempat, kod_peruntukan_cn, status")
               ->from('hrm.ln_ref_travel')
               ->where(['icno' => $icno])
               ->andWhere(['status'=> $status]);

               
               $query1->union($query2, false);//false is UNION, true is UNION ALL

               $sql = $query1->createCommand()->getRawSql();
            //    $sql .= ' ORDER BY entry_date DESC';
               $query = Ln::findBySql($sql);
			
			
               $ln = new ActiveDataProvider([
               'query' => $query,              
               ]);

        $status = Ln::findAll(['icno' => $icno]);
        $mod=Ln::find()->where(['icno' => $icno])->orderBy(['id' => SORT_DESC])->one(); //cari status permohonan terakhir
        $displaymohon='none';

        if($mod){
        if(($mod->status =='TIDAK LULUS' ||  $mod->status == NULL)){
            $displaymohon='';                               //show mohon form untuk yang sudah diluluskan dan yang pertama kali mohon
        }}
        elseif(!$mod){
            $displaymohon=''; 
        }
        else{
           Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda Masih Mempunyai Permohonan Yang Aktif']); 
        }
       
        // dynamic controller  code
        
        $modelCustomer = new Ln();
        //$modelCustomer->scenario = 'ln';
        $modelsAddress = [new TblPeserta];
        $modelCustomer->icno = $icno;  
        $default = Pegawai::find()->one();
        //$pegawai = Department::findOne(['id' => $modelCustomer->kakitangan->DeptId]);
        $pegawai2 = SetPegawai::findOne(['pemohon_icno' => $icno]);
   
        if ($modelCustomer->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())){
            
        $file = UploadedFile::getInstance($model, 'dokumen_sokongan');
        $file2 = UploadedFile::getInstance($model, 'dokumen_sokongan2');
        $file3 = UploadedFile::getInstance($model, 'dokumen_sokongan3');
        
        $modelsAddress = Model::createMultiple(TblPeserta::classname());
        \app\models\ln\Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            
        if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'rekodlantikan');
                $filepath = $fileapi->file_name_hashcode;      
            }
            else{
                $filepath = '';
        }
        
         if($file2){
                $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'rekodlantikan');
                $filepath2 = $fileapi->file_name_hashcode;   
        }
        else{
            $filepath2 = '';
        }
        
         if($file3){
                $fileapi = Yii::$app->FileManager->UploadFile($file3->name, $file3->tempName, '04', 'rekodlantikan');
                $filepath3 = $fileapi->file_name_hashcode;   
        }
        else{
            $filepath3 = '';
        }
  
        $modelCustomer->dokumen_sokongan = $filepath;
        $modelCustomer->dokumen_sokongan2 = $filepath2;
        $modelCustomer->dokumen_sokongan3 = $filepath3;

        // ajax validation
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ArrayHelper::merge(
                ActiveForm::validateMultiple($modelsAddress),
                ActiveForm::validate($modelCustomer)
            );
        }
            
//        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
//        $modelCustomer->app_by = $pegawai->chief; //kj 
//        }
//        else{
//        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
//        $modelCustomer->app_by = $pegawaisub->chief; //kj 
//        }
        
//        if($pegawai2->pelulus_icno != NULL){
//        $modelCustomer->app_by = $pegawai2->pelulus_icno;
//        }
//        else{
//       $pegawai2->pelulus_icno = NULL;
//         $modelCustomer->app_by = $pegawai2->pelulus_icno;
//        }
        
            if
            ($pegawai2->pelulus_icno == '680114125023'){
            $modelCustomer->ver_by = $default->penyemak_icno;
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            $modelCustomer->entry_date = date('Y-m-d H:i:s');
            $modelCustomer->status_jfpiu = '-';
            $modelCustomer->status_semakan = 'Tunggu Semakan';   
            $modelCustomer->status_nc = 'Tunggu Kelulusan'; 
            $modelCustomer->status ='DALAM TINDAKAN CANSELORI';
            $modelCustomer->isActive = 1;
            $petindak1='Canselori';
            $icnopetindak1= $modelCustomer->ver_by;   
            $this->notifikasi($icnopetindak1, "Permohonan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-canselori'], ['class'=>'btn btn-primary btn-sm']));
            }
            else{
            $pegawai2->pelulus_icno != NULL;
            $modelCustomer->app_by = $pegawai2->pelulus_icno;
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            $modelCustomer->entry_date = date('Y-m-d H:i:s');
            $modelCustomer->status_jfpiu = 'Tunggu Perakuan';
            $modelCustomer->status_semakan = 'Tunggu Semakan';   
            $modelCustomer->status_nc = 'Tunggu Kelulusan'; 
            $modelCustomer->status ='DALAM TINDAKAN KETUA JABATAN';
            $modelCustomer->isActive = 1;
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $modelCustomer->app_by;  
            $this->notifikasi($icnopetindak1, "Permohonan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-kj'], ['class'=>'btn btn-primary btn-sm']));
            }

//            $valid = $modelCustomer->validate();
//            $valid = Model::validateMultiple($modelsAddress) && $valid;
//            $modelCustomer->entry_date = date('Y-m-d H:i:s');
//            $modelCustomer->status_jfpiu = 'Tunggu Perakuan';
//            $modelCustomer->status_semakan = 'Tunggu Semakan';   
//            $modelCustomer->status_nc = 'Tunggu Kelulusan'; 
//            $modelCustomer->status ='DALAM TINDAKAN KETUA JABATAN';
//            $modelCustomer->isActive = 1;
//            $petindak1='Ketua Jabatan';
//            $icnopetindak1= $modelCustomer->app_by;               

        if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelsAddress as $modelAddress)  {
                              $modelAddress->ref_icno = $modelCustomer->icno;
                              $modelAddress->parent_id = $modelCustomer->id;
                              $modelAddress->entry_date = date('Y-m-d H:i:s');
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                                
                            }
                        }
                    }
                    //$this->notifikasi($icnopetindak1, "Permohonan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-kj'], ['class'=>'btn btn-primary btn-sm']));
                    $this->notifikasi($modelCustomer->icno, "Permohonan anda telah dihantar untuk tindakan ".$petindak1. " ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
                    if ($flag) {
                        $transaction->commit();
                       
                        return $this->redirect(['lampiran-a']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
                    $model->save(false);
                    $modelCustomer->save(false);
        }
        
        return $this->render('mohon', [
            'model' => $model,
            'peserta' => $peserta,
            'ln' => $ln, 
            'peranan' => $peranan,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status' => $status,
            'displaymohon' => $displaymohon,
            'mod' => $mod, 
            'modelsCustomer' => $modelCustomer,
            'modelsAddress' => $modelsAddress,
            'modelsAddress' => (empty($modelsAddress)) ? [new TblPeserta] : $modelsAddress 
        ]);        
    }
    
    // Lihat LN-1 (Pemohon)
    public function actionLihatPermohonanLn1($id)
    {
        $model = $this->findModel($id);
        $icno = Yii::$app->user->getId();
        $status = Ln::findAll(['icno' => $model->icno]); //senarai status permohonan
        $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS']]);
        //$default = Pegawai::find()->one();
        $today = date('Y-m-d');
        $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
        
        if($icno==$model->icno){
        return $this->render('lihat-permohonan-ln1', [
            'model' => $model,
            'icno' => $icno,
            'today' => $today,
            'status' => $status,
            'ln' => $ln,
            'bil' => 1,
            'peserta' => $peserta,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('semakan-permohonan');}
    }
    
//    public function actionKemaskiniPermohonanLn1($id)
//    {
//        $model = $this->findModel($id);
//        $icno = Yii::$app->user->getId();
//
//        $model->icno = $icno;   
//        $peserta =  Tblprcobiodata::find()->where(['Status' => 1])->orderBy(['gredJawatan' => SORT_ASC])->all();
//        $peranan = \app\models\ln\Refperanan::find()->all();
//
//        // dynamic controller  code
//        
//        $modelCustomer = $this->findModel($id);
//        $modelsAddress = TblPeserta::find()->where(['parent_id' => $model->id])->all();
//
//        if ($modelCustomer->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())){
//            
//        $file = UploadedFile::getInstance($model, 'dokumen_sokongan');
//        $file2 = UploadedFile::getInstance($model, 'dokumen_sokongan2');
//        $file3 = UploadedFile::getInstance($model, 'dokumen_sokongan3');
//        
//        $modelsAddress = Model::createMultiple(TblPeserta::classname());
//        \app\models\ln\Model::loadMultiple($modelsAddress, Yii::$app->request->post());
//            
//        if($file){
//                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'rekodlantikan');
//                $filepath = $fileapi->file_name_hashcode;      
//            }
//            else{
//                $filepath = '';
//        }
//        
//         if($file2){
//                $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'rekodlantikan');
//                $filepath2 = $fileapi->file_name_hashcode;   
//        }
//        else{
//            $filepath2 = '';
//        }
//        
//         if($file3){
//                $fileapi = Yii::$app->FileManager->UploadFile($file3->name, $file3->tempName, '04', 'rekodlantikan');
//                $filepath3 = $fileapi->file_name_hashcode;   
//        }
//        else{
//            $filepath3 = '';
//        }
//  
//        $modelCustomer->dokumen_sokongan = $filepath;
//        $modelCustomer->dokumen_sokongan2 = $filepath2;
//        $modelCustomer->dokumen_sokongan3 = $filepath3;
//
//        // ajax validation
//        if (Yii::$app->request->isAjax) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ArrayHelper::merge(
//                ActiveForm::validateMultiple($modelsAddress),
//                ActiveForm::validate($modelCustomer)
//            );
//        }    
//        
//                    $model->save(false);
//                    $modelCustomer->save(false);
//                    return $this->redirect(['semakan-permohonan']);
//        }
//        
//        return $this->render('kemaskini-permohonan-ln1', [
//            'model' => $model,
//            'peserta' => $peserta,
//            'peranan' => $peranan,
//            'modelsCustomer' => $modelCustomer,
//            'modelsAddress' => $modelsAddress,
//        ]);        
//    }
    
    // Laporan Bertugas Rasmi Di Luar Negara (Pemohon)
    public function actionMohon2($id)
    {
        $model2 = $this->findModel($id);
        $icno = Yii::$app->user->getId(); 
        $model = new \app\models\ln\Ln2();
        $searchModel = new \app\models\ln\Ln2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model->ICNO = $icno;   
        $peserta = TblPeserta::find()->where(['ref_icno' => $model2])->andWhere(['parent_id' => $model2->id])->all();
        $peranan = \app\models\ln\Refperanan::find()->all();
        $status = \app\models\ln\Ln2::findAll(['ICNO' => $icno]);       
        
        if ($model->load(Yii::$app->request->post())){ 
            
            $file5 = UploadedFile::getInstance($model, 'dokumen_ln2');
            
            if($file5){
                $fileapi = Yii::$app->FileManager->UploadFile($file5->name, $file5->tempName, '04', 'dokumen_ln2');
                $filepath5 = $fileapi->file_name_hashcode;      
            }
            else{
                $filepath5 = '';
            }

            $model->ICNO = $icno;     
            $model->parent_id = $model2->id;
            $model->entry_date = date('Y-m-d H:i:s');
            $model->hantar = 1;
            $model->dokumen_ln2 = $filepath5;
            $model2->hantar = 1;
            $model2->save(false);
            $model->save(false);  
            
            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan (LN-2) Berjaya Dihantar']);
            
            return $this->redirect(['senarai-mohon2'] );
        }
        
        return $this->render('mohon2', [
            'model' => $model,
            'model2' => $model2,
            'bil' => 1,
            'peserta' => $peserta,
            'peranan' => $peranan,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status' => $status,
            
        ]);        
    }
    
    public function actionSenaraiMohon2()
    { 
        $permohonan = $this->GridPermohonanLn2();
        return $this->render('senarai-mohon2', [
           'permohonan' => $permohonan,
        ]);
    }
    
    // Lihat LN-2 (Pemohon)
    public function actionLihatLaporanLn2($id)
    {
        $model = $this->findModel($id);
        $icno = Yii::$app->user->getId();
        $status = Ln::findAll(['icno' => $model->icno]); //senarai status permohonan
        $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS', 'TIDAK LULUS']]);
        //$default = Pegawai::find()->one();
        $today = date('Y-m-d');
        $ln2 = \app\models\ln\Ln2::find()->where(['ICNO' => $model->icno])->andWhere(['parent_id' => $model->id])->all();
        $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
        
        if($icno==$model->icno){
        return $this->render('lihat-laporan-ln2', [
            'model' => $model,
            'icno' => $icno,
            'today' => $today,
            'status' => $status,
            'ln' => $ln,
            'ln2' => $ln2,
            'bil' => 1,
            'peserta' => $peserta,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('senarai-mohon2');}
    }
    
    // Permohonan Lampiran A (Pemohon)
    public function actionLampiran($id)
    {
        $model = $this->findModel($id);
        $icno = Yii::$app->user->getId();
        $searchModel = new LnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $file4 = UploadedFile::getInstance($model, 'file4');
        if ($model->load(Yii::$app->request->post())){ 
            
            if($file4){
                $fileapi = Yii::$app->FileManager->UploadFile($file4->name, $file4->tempName, '04', 'lampiran_a');
                $filepath4 = $fileapi->file_name_hashcode;      
            }
            else{
                $filepath4 = '';
            }

        $model->lampiran = $filepath4;
        
        if($model->lampiran == ''){

        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Sila muatnaik Lampiran A yang anda telah anda isi dan lengkapkan!']);

        return $this->redirect(["lampiran", 'id' => $model->id]);
        }
            
            $model->lampiran_a = $filepath4;
            $model->lampiran = 1;
            $model->save(false);  
            
            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Lampiran A Berjaya Dihantar']);
            
            return $this->redirect(['lampiran-a'] );
        }
        
        if($icno==$model->icno){
        return $this->render('lampiran', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,   
        ]);}    
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    // Halaman Utama Permohonan Lampiran A
    public function actionLampiranA()
    { 
        $permohonan = $this->GridLampiranA();
        return $this->render('lampiran-a', [
           'permohonan' => $permohonan,
        ]);
    }

    /**
     * Updates an existing Ln model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['menunggu', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            
        ]);
    }
    
    public function actionTindakanKj($id)
    {
        $model = $this->findModel($id);
        $status = Ln::findAll(['icno' => $model->icno]); //senarai status permohonan
        $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS']]);
        $icno = Yii::$app->user->getId(); 
        $default = Pegawai::find()->one();
        $today = date('Y-m-d');
        $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
        if ($model->load(Yii::$app->request->post())){
            
            $model->app_date = date('Y-m-d H:i:s');
            
            if (($model->status_jfpiu == 'Diperakui' && ($model->ulasan_jfpiu != ''))) { 
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakui!']);
            $model->status = 'DALAM TINDAKAN CANSELORI';
            $model->ver_by = $default->penyemak_icno; 
            $this->notifikasi($default->penyemak_icno, "Permohonan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-canselori'], ['class'=>'btn btn-primary btn-sm']));
            $this->notifikasi($model->icno, "Permohonan anda telah dihantar untuk tindakan Canselori. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
            }
            
            elseif(($model->status_jfpiu == 'Tidak Diperakui' && ($model->ulasan_jfpiu != ''))) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            $model->status = 'TIDAK LULUS';
            $model->status_semakan = '-';
            $model->status_nc = '-';
            $model->letter_sent = 2; // Status Surat Tidak Dihantar
            $model->letter_date = date('Y-m-d H:i:s'); //Tarikh Surat Tidak Dihantar
            $model->status_surat = 2; // Status Surat Tidak Lulus
            $this->notifikasi($model->icno, "Permohonan anda tidak berjaya. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
            }
            
            if($model->status_jfpiu == '' || (($model->status_jfpiu == 'Diperakui' && ($model->ulasan_jfpiu == '')))|| (($model->status_jfpiu == 'Tidak Diperakui' && ($model->ulasan_jfpiu == '')))){
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan perakuan anda.']); 
            
            }
            else{ 
                
            $model->save();
            
            return $this->redirect(['semakan-kj', 'id' => $model->id]);
            
        }}   
        
        if($icno==$model->app_by){
        return $this->render('tindakan_kj', [
            'model' => $model,
            'icno' => $icno,
            'today' => $today,
            'status' => $status,
            'ln' => $ln,
            'bil' => 1,
            'peserta' => $peserta,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
//    public function actionTindakanKj($id)
//    {
//        $model = $this->findModel($id);
//        $status = Ln::findAll(['icno' => $model->icno]); //senarai status permohonan
//        $icno = Yii::$app->user->getId(); 
//        $default = Pegawai::find()->one();
//        $today = date('Y-m-d');
//        $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
//        if ($model->load(Yii::$app->request->post())){
//                  $model->app_date = date('Y-m-d H:i:s');
//            if($model->status_jfpiu == 'Diperakui') { 
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakui!']);}
//            
//            elseif($model->status_jfpiu == 'Tidak Diperakui') {
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);}
//            
//            if($model->status_jfpiu == ''){
//            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan perakuan anda.']); 
//            
//            }
//            else{ 
//                
//            $model->status = 'DALAM TINDAKAN CANSELORI';
//            $model->ver_by = $default->penyemak_icno; 
//            $model->save();
//            
//            $this->notifikasi($default->penyemak_icno, "Permohonan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-canselori'], ['class'=>'btn btn-primary btn-sm']));
//            $this->notifikasi($model->icno, "Permohonan anda telah dihantar untuk tindakan Canselori. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
//            return $this->redirect(['semakan-kj', 'id' => $model->id]);
//            
//        }}
//        if($icno==$default->peraku_icno){
//        return $this->render('tindakan_kj', [
//            'model' => $model,
//            'icno' => $icno,
//            'today' => $today,
//            'status' => $status,
//            'bil' => 1,
//            'peserta' => $peserta,
//        ]);}
//        else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('index');}
//    }
    
    public function actionTindakanCanselori($id)
    {
        $model = $this->findModel($id);
        $icno = Yii::$app->user->getId();
        $status = Ln::findAll(['icno' => $model->icno]); //senarai status permohonan
        $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS']]);
        //$chief = Department::find()->where(['chief' => $icno, 'id' => '170'])->exists(); 
        $default = Pegawai::find()->one();
        $today = date('Y-m-d');
        $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
        if ($model->load(Yii::$app->request->post())){
            
            $model->ver_date = date('Y-m-d H:i:s');
            $model->ver_by = $default->penyemak_icno; //canselori
                  
            if($model->status_semakan == 'Diperakui') { 
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakui!']);
            $model->status = 'DALAM TINDAKAN NC';
            $model->lulus_by = $default->pelulus_icno;
            $this->notifikasi($default->pelulus_icno, "Permohonan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-nc'], ['class'=>'btn btn-primary btn-sm']));
            $this->notifikasi($model->icno, "Permohonan anda telah dihantar untuk tindakan NC. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
            }
            
            elseif($model->status_semakan == 'Tidak Diperakui') {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            $model->status = 'TIDAK LULUS';
            $model->status_nc = '-';
            $model->letter_sent = 2; // Status Surat Tidak Dihantar
            $model->status_surat = 2; // Status Surat Tidak Lulus
            }
            
            if($model->status_semakan == '' || (($model->status_semakan == 'Diperakui' && ($model->ulasan_semakan == '')))|| (($model->status_semakan == 'Tidak Diperakui' && ($model->ulasan_semakan == '')))){
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan perakuan anda.']); 
            return $this->redirect(['tindakan-canselori', 'id' => $model->id]);
            }
            else{ 
                
            //$model->status = 'DALAM TINDAKAN NC';
            //$model->lulus_by = $default->pelulus_icno; 
            $model->save(false);
            //$this->notifikasi($default->pelulus_icno, "Permohonan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-nc'], ['class'=>'btn btn-primary btn-sm']));
            //$this->notifikasi($model->icno, "Permohonan anda telah dihantar untuk tindakan NC. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
            return $this->redirect(['semakan-canselori', 'id' => $model->id]);
            
        }}
        if($icno==$default->penyemak_icno){
        return $this->render('tindakan_canselori', [
            'model' => $model,
            'icno' => $icno,
            'today' => $today,
            'status' => $status,
            'ln' => $ln,
            'bil' => 1,
            'peserta' => $peserta,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
//    public function actionTindakanNc($id)
//    {
//        $model = $this->findModel($id);
//        $icno = Yii::$app->user->getId();
//        $status = Ln::findAll(['icno' => $model->icno]); //senarai status permohonan
//        //$chief = Department::find()->where(['chief' => $icno, 'id' => '170'])->exists(); 
//        $default = Pegawai::find()->one();
//        $today = date('Y-m-d');
//        $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
//        if ($model->load(Yii::$app->request->post())){
//                  $model->lulus_date = date('Y-m-d H:i:s');
//                  
//            if($model->status_nc == 'Diluluskan') { 
////            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diluluskan!']);
//            $this->notifikasi($model->icno, "Permohonan anda berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
//                $model->status = 'LULUS';
//            }
//            
//            elseif($model->status_nc == 'Tidak Diluluskan') {
//            //Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
//            $this->notifikasi($model->icno, "Permohonan anda tidak berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
//                $model->status = 'TIDAK LULUS';
//            }
//            
//            if($model->status_nc == ''){
//            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan perakuan anda.']); 
//            
//            }
//            else{ 
//                
//            $model->letter_sent = 1; //untuk send surat kelulusan
//            $model->mohon = 1; //untuk restrict permohonan 3 tahun sekali
//            $model->save();
//            
//           // $this->notifikasi($model->icno, "Permohonan anda telah dihantar untuk tindakan NC. ".Html::a('<i class="fa fa-arrow-right"></i>', ['index'], ['class'=>'btn btn-primary btn-sm']));
//            return $this->redirect(['semakan-nc', 'id' => $model->id]);
//            
//        }}
//        if($default->pelulus_icno){
//        return $this->render('tindakan_nc', [
//            'model' => $model,
//            'icno' => $icno,
//            'today' => $today,
//            'status' => $status,
//            'bil' => 1,
//            'peserta' => $peserta,
//        ]);}
//        else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('index');}
//    }
    
    public function actionTindakanNc($id)
    {
        $model = $this->findModel($id);
        $icno = Yii::$app->user->getId();
        $status = Ln::findAll(['icno' => $model->icno]); //senarai status permohonan
        $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS']]);
        $default = Pegawai::find()->one();
        $today = date('Y-m-d');
        $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
        if ($model->load(Yii::$app->request->post())){
            
            $model->lulus_date = date('Y-m-d H:i:s');
                  
            if($model->status_nc == 'Diluluskan') { 
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diluluskan!']);
            }
            
            elseif($model->status_nc == 'Tidak Diluluskan') {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            
            if($model->status_nc == ''){
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan perakuan anda.']); 
            
            }
            else{ 
                
            $model->status = 'MENUNGGU';
            $model->save(false);
            
           // $this->notifikasi($model->icno, "Permohonan anda telah dihantar untuk tindakan NC. ".Html::a('<i class="fa fa-arrow-right"></i>', ['index'], ['class'=>'btn btn-primary btn-sm']));
            return $this->redirect(['semakan-nc', 'id' => $model->id]);
            
        }}
        if($icno==$default->pelulus_icno){
        return $this->render('tindakan_nc', [
            'model' => $model,
            'icno' => $icno,
            'today' => $today,
            'status' => $status,
            'ln' => $ln,
            'bil' => 1,
            'peserta' => $peserta,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }

    /**
     * Deletes an existing Ln model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['rekod']);
    }

    /**
     * Finds the Ln model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ln the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ln::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findModel2($id)
    {
        if (($model = \app\models\ln\Ln2::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
//    public function actionMenunggu()
//    {
//        $searchModel = new LnSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('menunggu', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }
           
    // Senarai Menunggu Perakuan
    public function actionSemakanKj()
    { 
        $searchModel = new LnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai = '';   
        if(SetPegawai::find()->where( ['peraku_icno' => $icno] || ['pelulus_icno' => $icno] )->exists()){
            $senarai = Ln::find()->where(['app_by' => $icno])->andWhere(['hantar' => 0, 'status' => 'DALAM TINDAKAN KETUA JABATAN'])->orderBy(['entry_date' => SORT_ASC]);
            $title='Senarai Menunggu Perakuan';
        }       
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        if($title!=NULL){ 
        return $this->render('semakan_kj', [
            'icno' => $icno,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => $title,
            'senarai' => $senarais,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }

    // Senarai Rekod Perakuan
    public function actionRekodKj($icno=null, $statuskj=null, $statuscn=null, $statusnc=null)
    {               
        $icnoo=Yii::$app->user->getId();
        $title = '';
        $senarai = '';   
        if(SetPegawai::find()->where( ['peraku_icno' => $icnoo] || ['pelulus_icno' => $icnoo] )->exists()){
            $senarai = Ln::find()->where(['app_by' => $icnoo])->andWhere(['hantar' => [0,1]])->orderBy(['entry_date' => SORT_ASC]);
            $title='Senarai Rekod Perakuan';
        }       
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        $icno? $senarais->query->andFilterWhere(['icno' => $icno]):'';
        $statuskj? $senarais->query->andFilterWhere(['status_jfpiu' => $statuskj]):'';
        $statuscn? $senarais->query->andFilterWhere(['status_semakan' => $statuscn]):'';
        $statusnc? $senarais->query->andFilterWhere(['status_nc' => $statusnc]):'';
        
       if($title!=NULL){ 
        return $this->render('rekod_kj', [
            'icno' => $icno,
            'statuskj' => $statuskj,
            'statuscn' => $statuscn,
            'statusnc' => $statusnc,
            'icnoo' => $icnoo,
            'title' => $title,
            'senarai' => $senarais,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
//        public function actionSemakanKj()
//    { 
//        $searchModel = new LnSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $icno=Yii::$app->user->getId();
//        $title = '';
//        $senarai = '';
//        if(Department::find()->where( ['chief' => $icno, 'isActive' => '1'] )->exists()){
//            $senarai = Ln::find()->where(['app_by' => $icno])->orderBy(['entry_date' => SORT_ASC]);
//            $title='Senarai Menunggu Perakuan';
//        }       
//        $senarais = new ActiveDataProvider([
//            'query' => $senarai,
//            'pagination' => [
//                'pageSize' => 10,
//            ],
//        ]);
//        if($title!=NULL){ 
//        return $this->render('semakan_kj', [
//             'icno' => $icno,
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//            'title' => $title,
//            'senarai' => $senarais,
//        ]);}
//        else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('index');}
//    }
    
    
//    public function actionSemakanCanselori()
//    { 
//        $searchModel = new LnSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $title = 'Senarai Menunggu Semakan';
//        $icno = Yii::$app->user->getId();  
//        $chief = Department::find()->where(['chief' => $icno, 'id' => '170'])->exists();  
////        $senarai = new ActiveDataProvider([
////            'query' => $senarai,
////            'pagination' => [
////                'pageSize' => 10,
////            ],
////        ]);
//        
//        if($icno == $chief){ 
//        return $this->render('semakan_canselori', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//            'title' => $title,
//        ]);}
//        else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('index');}
//    }
    
    // Senarai Menunggu Semakan
    public function actionSemakanCanselori()
    { 
        $searchModel = new LnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $title = 'Senarai Menunggu Semakan';
        $icno = Yii::$app->user->getId();  
        //$chief = Department::find()->where(['chief' => $icno, 'id' => '170'])->exists();  
        $default = Pegawai::find()->one();
        
        //$senarai = Ln::find()->where(['hantar' => 0])->orderBy(['entry_date' => SORT_ASC]);
        $senarai = Ln::find()->where(['hantar' => 0, 'status' => 'DALAM TINDAKAN CANSELORI'])->orderBy(['entry_date' => SORT_ASC]);
        
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        if($icno==$default->penyemak_icno){ 
        return $this->render('semakan_canselori', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => $title,
            'senarai' => $senarais,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    // Senarai Rekod Semakan
    public function actionRekodCanselori($icno=null, $statuskj=null, $statuscn=null, $statusnc=null)
    {               
        $icnoo=Yii::$app->user->getId();
        $title = 'Senarai Rekod Semakan';
        $default = Pegawai::find()->one();
        
        $senarai = Ln::find()->where(['hantar' => [0,1]])->orderBy(['entry_date' => SORT_ASC]);
        
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        $icno? $senarais->query->andFilterWhere(['icno' => $icno]):'';
        $statuskj? $senarais->query->andFilterWhere(['status_jfpiu' => $statuskj]):'';
        $statuscn? $senarais->query->andFilterWhere(['status_semakan' => $statuscn]):'';
        $statusnc? $senarais->query->andFilterWhere(['status_nc' => $statusnc]):'';
        
        if($icnoo===$default->penyemak_icno){ 
        return $this->render('rekod_canselori', [
            'icno' => $icno,
            'statuskj' => $statuskj,
            'statuscn' => $statuscn,
            'statusnc' => $statusnc,
            'icnoo' => $icnoo,
            'senarai' => $senarais,
            'title' => $title,
            'senarai' => $senarais,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    // Senarai Menunggu Kelulusan
    public function actionSemakanNc()
    { 
        $searchModel = new LnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $title = 'Senarai Menunggu Kelulusan';
        $icno = Yii::$app->user->getId();  
        //$chief = Department::find()->where(['chief' => $icno, 'id' => '170'])->exists();  
        $default = Pegawai::find()->one();
        
        $senarai = Ln::find()->where(['hantar' => 0, 'status' => 'DALAM TINDAKAN NC'])->orderBy(['entry_date' => SORT_ASC]);

        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        if($icno==$default->pelulus_icno){ 
        return $this->render('semakan_nc', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => $title,
            'senarai' => $senarais,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    // Senarai Rekod Kelulusan
    public function actionRekodNc($icno=null,$statuskj=null, $statuscn=null, $statusnc=null)
    {               
        $icnoo=Yii::$app->user->getId();
        $title = 'Senarai Rekod Kelulusan';
        $default = Pegawai::find()->one();
        
        $senarai = Ln::find()->where(['hantar' => [0,1]])->orderBy(['entry_date' => SORT_ASC]);
        
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        $icno? $senarais->query->andFilterWhere(['icno' => $icno]):'';
        $statuskj? $senarais->query->andFilterWhere(['status_jfpiu' => $statuskj]):'';
        $statuscn? $senarais->query->andFilterWhere(['status_semakan' => $statuscn]):'';
        $statusnc? $senarais->query->andFilterWhere(['status_nc' => $statusnc]):'';
        
        if($icnoo==$default->pelulus_icno){ 
        return $this->render('rekod_nc', [
            'icno' => $icno,
            'statuskj' => $statuskj,
            'statuscn' => $statuscn,
            'statusnc' => $statusnc,
            'icnoo' => $icnoo,
            'senarai' => $senarais,
            'title' => $title,
            'senarai' => $senarais,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionSenaraiPermohonan($icno=null, $status_jfpiu=null, $status_semakan=null, $status_nc=null)
    {       
        
        $model = Ln::find()->where(['mohon' => 1]);
        $dataProvider = new ActiveDataProvider([

            'query' => $model,

            'pagination' => [

                'pageSize' => 100,

            ],
        ]);
        
     
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
        
        if(isset(Yii::$app->request->queryParams['status_jfpiu'])){
        $status_jfpiu? $dataProvider->query->andFilterWhere(['status_jfpiu' => $status_jfpiu]):'';}
        
        if(isset(Yii::$app->request->queryParams['status_semakan'])){
        $status_semakan? $dataProvider->query->andFilterWhere(['status_semakan' => $status_semakan]):'';}
        
        if(isset(Yii::$app->request->queryParams['status_nc'])){
        $status_nc? $dataProvider->query->andFilterWhere(['status_nc' => $status_nc]):'';}


        return $this->render('senarai_permohonan', [
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'icno' => $icno,
                'status_jfpiu' => $status_jfpiu,
                'status_semakan' => $status_semakan,
                'status_nc' => $status_nc,

                // 'model' => $dataProvider
        ]);
    }
    
//     public function actionSenaraiLn1()
//    {    
//        $searchModel = new LnSearch();
//        $maklumat = new Ln();
//        
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->query->orderBy([ 'date_from' => 'SORT_DESC']);
//
//        $models = Ln::find()->All();
//        $selection=(array)Yii::$app->request->post('selection');//typecasting
//        
//            if (Yii::$app->request->post('simpan')){
//                
//                foreach ($models as $data) {
//                    if('y'.$data->id == Yii::$app->request->post($data->id)){
//                    $model = $this->findModel($data->id);
//                    $model->status_surat = 3;  //'DRAFT DILULUSKAN';
//                    $model->save(false);
//                    }
//                    elseif('n'.$data->id == Yii::$app->request->post($data->id)){
//                    $model = $this->findModel($data->id);
//                    $model->status_surat = 4; //'DRAFT DITOLAK';
//                    $model->save(false);
//                    }
//            }
//                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tindakan Berjaya Disimpan']);
//            }
//
//            elseif (Yii::$app->request->post('hantar')) {
//                foreach($selection as $id){
//                $hantar= $this->findModel($id);//make a typecasting
//                if('n'.$hantar->id == Yii::$app->request->post($hantar->id)){
//                    $hantar->status ='TIDAK LULUS';
//                    $hantar->status_surat= 2;
//                    $this->notifikasi($hantar->icno, "Permohonan anda tidak berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm'])); 
//                }
//                elseif('y'.$hantar->id == Yii::$app->request->post($hantar->id)){
//                    $hantar->status ='LULUS';
//                    $hantar->status_surat= 1;
//                    $this->notifikasi($hantar->icno, "Permohonan anda berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
//                }
//                $hantar->letter_sent = 1;
//                $hantar->letter_date = date('Y-m-d H:i:s');
//                $hantar->save(false);               
//                
//                }
//            }
//
//       if(\app\models\ln\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId()] )->exists()){
//        return $this->render('senarai-ln1', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//            'model' => $model,
//            'maklumat' => $maklumat
//       ]);}
//      
//       else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('index');}
//    }
    
//    public function actionSenaraiLn1($icno=null, $statuskj=null, $statussemakan=null,  $statusnc=null)
//    {               
//        $arrayicno = array();
//
//        $model = Ln::find()->where(['status' => ['DALAM TINDAKAN KETUA JABATAN','DALAM TINDAKAN CANSELORI','DALAM TINDAKAN NC','MENUNGGU','LULUS','TIDAK LULUS']])->andWhere(['status_surat' => [1]]);
//                
//        $query = empty($arrayicno)? $model : $model->andWhere(['icno' => $arrayicno]);
//        
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'pagination' => ['pageSize' => 30,],
//        ]);
//        
//        $dataProvider->query->orderBy([ 'date_from' => 'SORT_DESC']);
//
//        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';
//        $statuskj? $dataProvider->query->andFilterWhere(['status_jfpiu' => $statuskj]):'';
//        $statussemakan? $dataProvider->query->andFilterWhere(['status_semakan' => $statussemakan]):'';
//        $statusnc? $dataProvider->query->andFilterWhere(['status_nc' => $statusnc]):'';
//                
//        $selection=(array)Yii::$app->request->post('selection');//typecasting
//        
//            if (Yii::$app->request->post('simpan')){
//                
//                foreach ($selection as $id) {
//                    $model = $this->findModel($id);
//                    if('y'.$model->id == Yii::$app->request->post($model->id)){
//                    $model->status_surat = 3;  //'DRAFT DILULUSKAN';
//                    $model->save(false);
//                    }
//                    elseif('n'.$model->id == Yii::$app->request->post($model->id)){
//                    $model = $this->findModel($model->id);
//                    $model->status_surat = 4; //'DRAFT DITOLAK';
//                    $model->save(false);
//                    }
//            }
//                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tindakan Berjaya Disimpan']);
//            }
//
//            elseif (Yii::$app->request->post('hantar')) {
//                foreach($selection as $id){
//                $hantar= $this->findModel($id);//make a typecasting
//                if('n'.$hantar->id == Yii::$app->request->post($hantar->id)){
//                    $hantar->status ='TIDAK LULUS';
//                    $hantar->status_surat= 2;
//                    $this->notifikasi($hantar->icno, "Permohonan anda tidak berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm'])); 
//                }
//                elseif('y'.$hantar->id == Yii::$app->request->post($hantar->id)){
//                    $hantar->status ='LULUS';
//                    $hantar->status_surat= 1;
//                    $this->notifikasi($hantar->icno, "Permohonan anda berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
//                }
//                $hantar->letter_sent = 1;
//                $hantar->letter_date = date('Y-m-d H:i:s');
//                $hantar->save(false);               
//                
//                }
//            }
//
//            elseif (Yii::$app->request->post('searchs')) {
//                $icno = Yii::$app->request->post('icno');
//                $statuskj = Yii::$app->request->post('statuskj');
//                $statussemakan = Yii::$app->request->post('statussemakan');
//                $statusnc = Yii::$app->request->post('statusnc');
//                return $this->redirect(array('ln/senarai-ln1','icno' => $icno,  'statuskj'=>$statuskj, 'statussemakan' => $statussemakan, 'statusnc' => $statusnc));
//            }
//        
//       if(\app\models\ln\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId()] )->exists()){
//        return $this->render('senarai-ln1', [
//            'dataProvider' => $dataProvider,
//            'model' => $model,
//            'icno' => $icno,
//            'statuskj' => $statuskj,
//            'statussemakan' => $statussemakan,
//            'statusnc' => $statusnc
//       ]);}
//      
//       else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('index');}
//    }
    
     public function actionSenaraiLn1($icno=null, $statuskj=null, $statuscn=null, $statusnc=null, $negara=null)
    {               
        //$arrayicno = array();

        $model = Ln::find()->where(['status' => ['DALAM TINDAKAN KETUA JABATAN','DALAM TINDAKAN CANSELORI','DALAM TINDAKAN NC','MENUNGGU','LULUS','TIDAK LULUS']])->andWhere(['status_surat' => [0,3,4]]);
                
        //$query = empty($arrayicno)? $model : $model->andWhere(['icno' => $arrayicno]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => ['pageSize' => 30,],
        ]);
        
        $dataProvider->query->orderBy([ 'date_from' => 'SORT_DESC']);

        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';
        $negara? $dataProvider->query->andFilterWhere(['nama_tempat' => $negara]):'';
        $statuskj? $dataProvider->query->andFilterWhere(['status_jfpiu' => $statuskj]):'';
        $statuscn? $dataProvider->query->andFilterWhere(['status_semakan' => $statuscn]):'';
        $statusnc? $dataProvider->query->andFilterWhere(['status_nc' => $statusnc]):'';
                
        $selection=(array)Yii::$app->request->post('selection');//typecasting
        
            if (Yii::$app->request->post('simpan')){
                
                foreach ($selection as $id) {
                    $model = $this->findModel($id);
                    if('y'.$model->id == Yii::$app->request->post($model->id)){
                    $model->status_surat = 3;  //'DRAFT DILULUSKAN';
                    $model->save(false);
                    }
                    elseif('n'.$model->id == Yii::$app->request->post($model->id)){
                    $model = $this->findModel($model->id);
                    $model->status_surat = 4; //'DRAFT DITOLAK';
                    $model->save(false);
                    }
            }
                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tindakan Berjaya Disimpan']);
            }

            elseif (Yii::$app->request->post('hantar')) {
                foreach($selection as $id){
                $hantar= $this->findModel($id);//make a typecasting
                if('n'.$hantar->id == Yii::$app->request->post($hantar->id)){
                    $hantar->status ='TIDAK LULUS';
                    $hantar->status_surat= 2;
                    $this->notifikasi($hantar->icno, "Permohonan anda tidak berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm'])); 
                }
                elseif('y'.$hantar->id == Yii::$app->request->post($hantar->id)){
                    $hantar->status ='LULUS';
                    $hantar->status_surat= 1;
                    $this->notifikasi($hantar->icno, "Permohonan anda berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
                }
                $hantar->letter_sent = 1;
                $hantar->letter_date = date('Y-m-d H:i:s');
                $hantar->save(false);               
                
                }
            }

            elseif (Yii::$app->request->post('searchs')) {
                $icno = Yii::$app->request->post('icno');
                $negara = Yii::$app->request->post('negara');
                $statuskj = Yii::$app->request->post('statuskj');
                $statuscn = Yii::$app->request->post('statuscn');
                $statusnc = Yii::$app->request->post('statusnc');
                return $this->redirect(array('ln/senarai-ln1','icno' => $icno,  'negara' => $negara ,'statuskj'=>$statuskj, 'statuscn' => $statuscn, 'statusnc' => $statusnc));
            }
        
       if(\app\models\ln\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId()] )->exists()){
        return $this->render('senarai-ln1', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'icno' => $icno,
            'statuskj' => $statuskj,
            'statuscn' => $statuscn,
            'statusnc' => $statusnc,
            'negara' => $negara,
       ]);}
      
       else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
     public function actionRekodLn1($carian_icno = null, $tahun = null, $bulan = null) {
       
        $year = date('Y');
        $month = date('m');
        $carian = $carian_icno;
        
        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $month = $bulan;
        } 
         
        $model = new Ln();
        
//        $query = Ln::find()->where(['status_surat' => [1,2,3]])->andWhere(['MONTH(entry_date)' => $month])->andWhere(['YEAR(entry_date)' => $year])->orderBy(['entry_date' => SORT_ASC]);
        
        if($bulan == 0 ){
//        $query =  Borang::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
            $query = Ln::find()->where(['YEAR(entry_date)' => $year])->andWhere(['status_surat' => [1,2,3]])->orderBy(['entry_date' => SORT_ASC]);
        } 
        elseif($bulan != 0 && $carian == NULL){
//        $query =  Borang::find()->where(['MONTH(entry_date)' => $mth])->andWhere(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
            $query = Ln::find()->where(['MONTH(entry_date)' => $month])->andWhere(['YEAR(entry_date)' => $year])->andWhere(['status_surat' => [1,2,3]])->orderBy(['entry_date' => SORT_ASC]);
        }
        else{
//        $query =  Borang::find()->where(['icno' => $carian_icno])->andWhere(['YEAR(entry_date)' => $year,'mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
            $query = Ln::find()->where(['icno' => $carian_icno])->andWhere(['YEAR(entry_date)' => $year,'status_surat' => [1,2,3]])->orderBy(['entry_date' => SORT_ASC]);

        }
       
        $sum = $query->sum('jumlah3');
        $dataProvider = new ActiveDataProvider([
            'query' => $query, 
            'pagination' => [ 'pageSize' => 30]
        ]);
        
        if(\app\models\ln\TblAdmin::find()->where(['icno'=> Yii::$app->user->getId()])->exists()){
        return $this->render('rekod-ln1', 
        ['tahun' => $year, 'bulan' => $month, 'dataProvider' => $dataProvider, 'model' => $model, 'sum' => $sum]);}
        
       else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    } 
    
    public function actionSenaraiLampiranA()
    { 
        $searchModel = new LnSearch();
        $model = Ln::find()->All();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $model = Ln::find()->where(['lampiran' => 1]);
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
         if(\app\models\ln\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId()] )->exists()){
        return $this->render('senarai-lampiran-a', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
         ]);}
    }
    
    public function actionSenaraiLn2()
    {  
        $searchModel = new LnSearch();
        $model = Ln::find()->where(['hantar' => [0,1], 'status' => 'LULUS']);
        $dataProvider = new ActiveDataProvider([

            'query' => $model,

            'pagination' => [

                'pageSize' => 100,

            ],
        ]);

       if(\app\models\ln\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId()] )->exists()){
        return $this->render('senarai-ln2', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
       ]);}
      
       else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionTindakanAdmin($id)
    {
        $model = $this->findModel($id);
        $icno = Yii::$app->user->getId();
        $status = Ln::findAll(['icno' => $model->icno]); //senarai status permohonan
        $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS']]);
        //$default = Pegawai::find()->one();
        $today = date('Y-m-d');
        $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
        if ($model->load(Yii::$app->request->post())){
                  $model->lulus_date = date('Y-m-d H:i:s');
                  
            if($model->status_nc == 'Diluluskan') { 
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diluluskan!']);
            }
            
            elseif($model->status_nc == 'Tidak Diluluskan') {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            
            if($model->status_nc == ''){
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan perakuan anda.']); 
            
            }
            else{ 
                
            $model->status = 'MENUNGGU';
            $model->save();
            
           // $this->notifikasi($model->icno, "Permohonan anda telah dihantar untuk tindakan NC. ".Html::a('<i class="fa fa-arrow-right"></i>', ['index'], ['class'=>'btn btn-primary btn-sm']));
            return $this->redirect(['semakan-nc', 'id' => $model->id]);
            
        }}
        if(\app\models\ln\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId()] )->exists()){
        return $this->render('tindakan_admin', [
            'model' => $model,
            'icno' => $icno,
            'today' => $today,
            'status' => $status,
            'ln' => $ln,
            'bil' => 1,
            'peserta' => $peserta,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
//        public function actionTindakanAdmin2($id)
//    {
//        $model = $this->findModel($id);
//        $icno = Yii::$app->user->getId();
//        $status = Ln::findAll(['icno' => $model->icno]); //senarai status permohonan
//        $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS', 'TIDAK LULUS']]);
//        //$default = Pegawai::find()->one();
//        $today = date('Y-m-d');
//        $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
//        if ($model->load(Yii::$app->request->post())){
//                  $model->lulus_date = date('Y-m-d H:i:s');
//                  
//            if($model->status_nc == 'Diluluskan') { 
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diluluskan!']);
//            }
//            
//            elseif($model->status_nc == 'Tidak Diluluskan') {
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
//            }
//            
//            if($model->status_nc == ''){
//            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan perakuan anda.']); 
//            
//            }
//            else{ 
//                
//            $model->status = 'MENUNGGU';
//            $model->save();
//            
//           // $this->notifikasi($model->icno, "Permohonan anda telah dihantar untuk tindakan NC. ".Html::a('<i class="fa fa-arrow-right"></i>', ['index'], ['class'=>'btn btn-primary btn-sm']));
//            return $this->redirect(['semakan-nc', 'id' => $model->id]);
//            
//        }}
//        if(\app\models\ln\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId()] )->exists()){
//        return $this->render('tindakan_admin2', [
//            'model' => $model,
//            'icno' => $icno,
//            'today' => $today,
//            'status' => $status,
//            'ln' => $ln,
//            'bil' => 1,
//            'peserta' => $peserta,
//        ]);}
//        else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('index');}
//    }
    
    public function actionTindakanAdmin3($id)
    {
        $model = $this->findModel($id);
        $icno = Yii::$app->user->getId();
        $status = Ln::findAll(['icno' => $model->icno]); //senarai status permohonan
        $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS', 'TIDAK LULUS']]);
        //$default = Pegawai::find()->one();
        $today = date('Y-m-d');
        $ln2 = \app\models\ln\Ln2::find()->where(['ICNO' => $model->icno])->andWhere(['parent_id' => $model->id])->all();
        $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
     
        $file5 = UploadedFile::getInstance($model, 'file5');
        
        if ($model->load(Yii::$app->request->post())){
            
            $model->lulus_date = date('Y-m-d H:i:s');
               
            $file5 = UploadedFile::getInstance($model, 'file5');

            if($file5){
                $fileapi = Yii::$app->FileManager->UploadFile($file5->name, $file5->tempName, '04', 'dokumen_ln2');
                $filepath5 = $fileapi->file_name_hashcode;      
            }
            else{
                $filepath5 = '';
            }
            $model->dokumen_ln2 = $filepath5;
        
            if($model->status_nc == 'Diluluskan') { 
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diluluskan!']);
            }
            
            elseif($model->status_nc == 'Tidak Diluluskan') {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            }
            
            if($model->status_nc == ''){
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan perakuan anda.']); 
            
            }
            else{ 
                
            $model->status = 'MENUNGGU';
            $model->save();
            
           // $this->notifikasi($model->icno, "Permohonan anda telah dihantar untuk tindakan NC. ".Html::a('<i class="fa fa-arrow-right"></i>', ['index'], ['class'=>'btn btn-primary btn-sm']));
            return $this->redirect(['semakan-nc', 'id' => $model->id]);
            
        }}
        if(\app\models\ln\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId()] )->exists()){
        return $this->render('tindakan_admin3', [
            'model' => $model,
            'icno' => $icno,
            'today' => $today,
            'status' => $status,
            'ln' => $ln,
            'ln2' => $ln2,
            'bil' => 1,
            'peserta' => $peserta,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionTindakan_admin_canselori($id)
    {
        $model = $this->findModel($id);
        //$model->ver_date = date('Y-m-d H:i:s');
        $today = date('Y-m-d');

        $request = Yii::$app->request;

        if($model->status == 'LULUS' || $model->status == 'TIDAK LULUS'){
            $displaylapor='';$displaytempoh='none'; } 
        else{
            $displaytempoh='';$displaylapor='none';}

        $message = '';
            $display='none';
            $lain= '';

        if(Yii::$app->request->post()){

            $Ln = $request->post()['Ln'];     
            $date_from = $Ln['date_from'];
            $date_to = $Ln['date_to'];
            $tujuan = $Ln['tujuan'];
            $nama_tempat = $Ln['nama_tempat'];
            $kod_peruntukan_cn = $Ln['kod_peruntukan_cn'];
            $days = $Ln['days'];
            $ulasan_admin= $Ln['ulasan_admin'];
            $model->date_from = $date_from;
            $model->date_to = $date_to;
            $model->days = $days;
            $model->tujuan = $tujuan;
            $model->nama_tempat = $nama_tempat;
            $model->kod_peruntukan_cn = $kod_peruntukan_cn;
            $model->ulasan_admin = $ulasan_admin;
            $model->save(false);
            $message = 'Berjaya Disimpan';
        }

        return $this->renderAjax('tindakan_admin_canselori', [
            'model' => $model,
            'today' => $today,
            'message' => $message,
            'displaytempoh' => $displaytempoh,
            'display' => $display,
            'lain' => $lain,
            ]); 
    }
    
    // Muat Turun Senarai Permohonan LN-1 Yang Menunggu Tindakan
    public function actionReportsenarailn1($icno = NULL, $statuskj=null, $statuscn=null, $statusnc=null)    
    {        
        $model = Ln::find()->where(['status_surat' => [0,3,4]])->orderBy(['date_from' => 'SORT_DESC']);
        
        $icno? $model->andWhere(['ICNO' => $icno]):'';
        $statuskj? $model->andWhere(['status_jfpiu' => $statuskj]):'';
        $statuscn? $model->andWhere(['status_semakan' => $statuscn]):'';
        $statusnc? $model->andWhere(['status_nc' => $statusnc]):'';
        
        return $this->render('report-senarai-ln1', [
            'model' =>$model->all()
        ]);
    }
    
    // Muat Turun Senarai Semua LN-1
    public function actionReportsenaraisemualn1($icno = NULL)    
    {        
        $model = Ln::find()->where(['hantar' => [0,1], 'status_surat' => [1,2,3]])->orderBy(['date_from' => 'SORT_DESC']);
        
        $icno? $model->andWhere(['ICNO' => $icno]):'';
        
        return $this->render('report-senarai-semua-ln1', [
            'model' =>$model->all()
        ]);
    }
    
    //  Muat Turun Rekod Permohonan LN-1 By Month / Year
    public function actionReportsenarairekodln1($tahun = null, $bulan = null)
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
        $model = Ln::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 0, 'hantar' => [0,1], 'status_surat' => [1,2,3]])->orderBy(['date_from' => 'SORT_DESC'])->all();
       
        }else{
        $model = Ln::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 0, 'status_surat' => [1,2,3]])->orderBy(['entry_date' => SORT_ASC])->all();
      
        }
        
        return $this->render('report-senarai-rekod-ln1', [
            'tahun' => $year,
            'bulan' => $mth, 
            'model' => $model,
        ]);
    }       
    
    // Muat Turun Semua Senarai LN-2
    public function actionReportsenaraisemualn2($icno = NULL) 
    {        
        $model = Ln::find()->where(['hantar' => [0,1]])->orderBy(['date_from' => 'SORT_DESC']);
        
        $icno? $model->andWhere(['ICNO' => $icno]):'';
        
        return $this->render('report-senarai-semua-ln2', [
            'model' =>$model->all()
        ]);
    }
    
    // Muat Turun Senarai Laporan LN-2 By Month / Year
    public function actionReportsenarailn2($tahun = null, $bulan = null)
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
        $model = Ln::find()->where(['YEAR(entry_date)' => $year])->andWhere(['hantar' => [0,1]])->orderBy(['date_from' => 'SORT_DESC'])->all();
       
        }else{
        $model = Ln::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['hantar' => [0,1]])->orderBy(['entry_date' => SORT_ASC])->all();
      
        }
        
        return $this->render('report-senarai-ln2', [
            'tahun' => $year,
            'bulan' => $mth, 
            'model' => $model,
        ]);
    }
    
    // Muat Turun Semua Senarai Lampiran A
    public function actionReportsenaraisemualampirana($icno = NULL) 
    {        
        $model = Ln::find()->where(['lampiran' => [0,1]])->orderBy(['date_from' => 'SORT_DESC']);
        
        $icno? $model->andWhere(['ICNO' => $icno]):'';
        
        return $this->render('report-senarai-semua-lampiran-a', [
            'model' =>$model->all()
        ]);
    }
    
    // Muat Turun Senarai Lampiran A By Month / Year
    public function actionReportsenarailampirana($tahun = null, $bulan = null)
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
        $model = Ln::find()->where(['YEAR(entry_date)' => $year])->andWhere(['lampiran' => [0,1]])->orderBy(['date_from' => 'SORT_DESC'])->all();
       
        }else{
        $model = Ln::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['lampiran' => [0,1]])->orderBy(['entry_date' => SORT_ASC])->all();
      
        }
        
        return $this->render('report-senarai-lampiran-a', [
            'tahun' => $year,
            'bulan' => $mth, 
            'model' => $model,
        ]);
    }
    
    public function actionTambahadmin() 
    {    
        $admin = \app\models\ln\TblAdmin::find()->All(); //cari senarai admin
        $adminbaru = new \app\models\ln\TblAdmin; //untuk admin baru
        if ($adminbaru->load(Yii::$app->request->post())) {
                if(\app\models\ln\TblAdmin::find()->where( [ 'icno' => $adminbaru->icno] )->exists()){ //jika admin sudah wujud
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);

                }
                elseif($adminbaru->kakitangan->CONm != NULL){ //jika icno tidak wujud dalam sistem
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                $adminbaru->save();
                }
                else{
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);

                }

                return $this->redirect(['ln/tambahadmin']);
            }
        if(\app\models\ln\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId()] )->exists()){
        return $this->render('tambahadmin', [
            'admin' => $admin,
            'adminbaru' => $adminbaru,
            'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionDeleteadmin($id)
    {
        $admin = \app\models\ln\TblAdmin::findOne(['id' => $id]);
        $admin->delete();
        if(\app\models\ln\TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId()] )->exists()){
        return $this->redirect(['tambahadmin']);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionUploadsurat($id)
    {
        $message = '';
        $model = $this->findModel($id);
        $dokumen = \app\models\ln\TblSurat::find()->where(['ln_id' => $model->id])->one();
        if(!$dokumen){
            $dokumen = new TblSurat();
            $dokumen->tajuk = 'Surat Kelulusan';
        }
        $surat = $model->surat;
        if ($dokumen->load(Yii::$app->request->post())) {
            Yii::$app->FileManager->DeleteFile($surat);
            $file =  UploadedFile::getInstance($dokumen, 'file');
            if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'permohonanbertugasrasmidiluarnegara');
                $filepath = $fileapi->file_name_hashcode;   
                if($fileapi->status == true) {
                    $message = 'Saved';
                }
            }
            else{
                $filepath = '';
            }

            $dokumen->dokumen = $filepath;
            $dokumen->ln_id = $model->id;
            $dokumen->save();
        }
        return $this->renderAjax('uploadsurat', [
           'dokumen' => $dokumen,
           'message' => $message
        ]); 
    } 
    
    public function actionSuratLn($id) 
    {
        $css = file_get_contents('./css/suratln.css');
        #check application
        $model = Ln::find()->where(['id' => $id])->one();
        $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $model])->one();  //panggil nama surat penerima tersebut                        
     
        // get your HTML raw content without any layouts or scripts
            if(($model->status == "LULUS") && ($model->status_surat == "3")){
            $content = $this->renderPartial('_suratDiluluskan', ['model'=> $model, 'peserta' => $peserta,  'bil' => 1, 'biodata' => $biodata, 'letter' => $model->letter]);
            }
            if(($model->status == "LULUS") && ($model->status_surat == '3') && ($model->bil_peserta == '1')){
            $content = $this->renderPartial('_suratDiluluskann', ['model'=> $model, 'peserta' => $peserta,  'bil' => 1, 'biodata' => $biodata, 'letter' => $model->letter]);
            }
            if(($model->status == "LULUS") && ($model->status_surat =='3') && ($model->icno == '680114125023')){
            $content = $this->renderPartial('_suratDiluluskanNC', ['model'=> $model, 'peserta' => $peserta,  'bil' => 1, 'biodata' => $biodata, 'letter' => $model->letter]);
            }
            if(($model->status == "LULUS") && ($model->status_surat == '3') && ($model->bil_peserta == '1') && ($model->icno == '680114125023')){
            $content = $this->renderPartial('_suratDiluluskanNCC', ['model'=> $model, 'peserta' => $peserta,  'bil' => 1, 'biodata' => $biodata, 'letter' => $model->letter]);
            }
            if(($model->status== "LULUS") && ($model->status_surat == '4')){
            $content = $this->renderPartial('_suratDitolak', ['model'=> $model, 'peserta' => $peserta,  'bil' => 1, 'biodata' => $biodata, 'letter' => $model->letter]);
            }
            if(($model->status== "TIDAK LULUS") && ($model->status_surat == '4')){
            $content = $this->renderPartial('_suratDitolak', ['model'=> $model, 'peserta' => $peserta,  'bil' => 1, 'biodata' => $biodata, 'letter' => $model->letter]);
            }
            
            if(($model->status == "MENUNGGU") && ($model->status_surat == "3")){
            $content = $this->renderPartial('_suratDiluluskan', ['model'=> $model, 'peserta' => $peserta,  'bil' => 1, 'biodata' => $biodata, 'letter' => $model->letter]);
            }
            if(($model->status == "MENUNGGU") && ($model->status_surat == '3') && ($model->bil_peserta == '1')){
            $content = $this->renderPartial('_suratDiluluskann', ['model'=> $model, 'peserta' => $peserta,  'bil' => 1, 'biodata' => $biodata, 'letter' => $model->letter]);
            }
            if(($model->status == "MENUNGGU") && ($model->status_surat =='3') && ($model->icno == '680114125023')){
            $content = $this->renderPartial('_suratDiluluskanNC', ['model'=> $model, 'peserta' => $peserta,  'bil' => 1, 'biodata' => $biodata, 'letter' => $model->letter]);
            }
            if(($model->status == "MENUNGGU") && ($model->status_surat == '3') && ($model->bil_peserta == '1') && ($model->icno == '680114125023')){
            $content = $this->renderPartial('_suratDiluluskanNCC', ['model'=> $model, 'peserta' => $peserta,  'bil' => 1, 'biodata' => $biodata, 'letter' => $model->letter]);
            }
            if(($model->status== "MENUNGGU") && ($model->status_surat == '4')){
            $content = $this->renderPartial('_suratDitolak', ['model'=> $model, 'peserta' => $peserta,  'bil' => 1, 'biodata' => $biodata, 'letter' => $model->letter]);
            }
            if(($model->status== "MENUNGGU") && ($model->status_surat == '4')){
            $content = $this->renderPartial('_suratDitolak', ['model'=> $model, 'peserta' => $peserta,  'bil' => 1, 'biodata' => $biodata, 'letter' => $model->letter]);
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
            'options' => ['title' => ''],
            // call mPDF methods on the fly
            'marginTop' => 35,
            'marginLeft' => 24,
            'marginRight' => 24,
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => [''],
                'WriteHTML' => [$css, 1]
            ]
        ]);

        return $pdf->render();
    }
    
    // Cetak Permohonan LN-1 (Pemohon)
    public function actionCetakLn1Pemohon($id)
    {
            $model = $this->findModel($id); //return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
            $icno=Yii::$app->user->getId();
            $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
            $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS']]);
            
            if($icno==$model->icno){
            $content = $this->renderPartial('cetak-ln1-pemohon', [ 
                'model' => $model,
                'peserta' => $peserta,
                'ln' => $ln,
            ]);}
            else{
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('semakan-permohonan');}
            

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
    
    // Cetak Permohonan LN-1 (Admin)
    public function actionCetakLn1($id)
    {
            $model = $this->findModel($id); //return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
            $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
            $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS']]);
            
            if(\app\models\ln\TblAdmin::find()->where(['icno'=> Yii::$app->user->getId()])->exists()){
            $content = $this->renderPartial('cetak-ln1', [ 
                'model' => $model,
                'peserta' => $peserta,
                'ln' => $ln,
            ]);}
            else{
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('semakan-permohonan');}
            
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
    
    // Cetak Lampiran A
    public function actionCetakLampiran($id)
    {
            $model = $this->findModel($id); //return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
            $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
            $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS']]);
            $content = $this->renderPartial('cetak-lampiran', [ 
                'model' => $model,
                'peserta' => $peserta,
                'ln' => $ln,

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
    
    // Cetak Laporan LN-2 (Pemohon)
    public function actionCetakLn2Pemohon($id)
    {
            $model = $this->findModel($id); //return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
            $icno=Yii::$app->user->getId();
            $ln2 = \app\models\ln\Ln2::find()->where(['id' => $model->id]);
            $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
            $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS']]);
            
            if($icno==$model->icno){
            $content = $this->renderPartial('cetak-ln2-pemohon', [ 
                'model' => $model,
                'icno' => $icno,
                'peserta' => $peserta,
                'ln' => $ln,
                'ln2' => $ln2
            ]);}
            else{
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('senarai-mohon2');}
    

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
             
            ] ,           // call mPDF methods on the fly
            
        ]);

        return $pdf->render(); 
    }
    
    // Cetak Laporan LN-2 (Admin)
    public function actionCetakLn2($id)
    {
            $model = $this->findModel($id); //return \app\models\hronline\Tblprcobiodata::findOne(['ICNO' => $id]);
            $ln2 = \app\models\ln\Ln2::find()->where(['id' => $model->id]);
            $peserta = TblPeserta::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
            $ln = Ln::findAll(['icno' => $model->icno, 'status' => ['LULUS']]);
            
            if(\app\models\ln\TblAdmin::find()->where(['icno'=> Yii::$app->user->getId()])->exists()){
            $content = $this->renderPartial('cetak-ln2', [ 
                'model' => $model,
                'peserta' => $peserta,
                'ln' => $ln,
                'ln2' => $ln2
            ]);}
            else{
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('senarai-mohon2');}
    

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
             
            ] ,           // call mPDF methods on the fly
            
        ]);

        return $pdf->render(); 
    }
    
    public function actionLaporanLn1($tahun = null, $bulan = null) {
       
        $year = date('Y');
        $month = date('m');

        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $month = $bulan;
        } 
         
        $model = new Ln();
        
        $query = Ln::find()->where(['MONTH(entry_date)' => $month])->andWhere(['YEAR(entry_date)' => $year])->orderBy(['entry_date' => SORT_ASC]);
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query, 
            'pagination' => [ 'pageSize' => 10]
        ]);
        
        if(\app\models\ln\TblAdmin::find()->where(['icno'=> Yii::$app->user->getId()])->exists()){
        return $this->render('laporan-ln1', 
        ['tahun' => $year, 'bulan' => $month, 'dataProvider' => $dataProvider, 'model' => $model]);}
        
       else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    } 
    
    public function actionLaporanLampiranA($carian_icno = null, $tahun = null, $bulan = null) {
       
        $year = date('Y');
        $month = date('m');
        $carian = $carian_icno;

        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $month = $bulan;
        } 
         
        $model = new Ln();
        
//        $query = Ln::find() ->where(['MONTH(entry_date)' => $month])->andWhere(['YEAR(entry_date)' => $year])->orderBy(['entry_date' => SORT_ASC]);
       
        if($bulan == 0 ){
//            $query = Ln::find()->where(['YEAR(entry_date)' => $year])->andWhere(['status_surat' => [1,2,3]])->orderBy(['entry_date' => SORT_ASC]);
            $query = Ln::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['lampiran' => [0,1]])->orderBy(['entry_date' => SORT_ASC]);
        } 
        elseif($bulan != 0 && $carian == NULL){
//            $query = Ln::find()->where(['MONTH(entry_date)' => $month])->andWhere(['YEAR(entry_date)' => $year])->andWhere(['status_surat' => [1,2,3]])->orderBy(['entry_date' => SORT_ASC]);
            $query = Ln::find() ->where(['MONTH(entry_date)' => $month])->andWhere(['YEAR(entry_date)' => $year])->andWhere(['lampiran' => [0,1]])->orderBy(['entry_date' => SORT_ASC]);
        }
        else{
//            $query = Ln::find()->where(['icno' => $carian_icno])->andWhere(['YEAR(entry_date)' => $year,'status_surat' => [1,2,3]])->orderBy(['entry_date' => SORT_ASC]);
            $query = Ln::find() ->where(['icno' => $carian_icno])->andWhere(['YEAR(entry_date)' => $year, 'lampiran' => [0,1]])->orderBy(['entry_date' => SORT_ASC]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query, 
            'pagination' => ['pageSize' => 30]
        ]);
        
        if(\app\models\ln\TblAdmin::find()->where(['icno'=> Yii::$app->user->getId()])->exists()){
        return $this->render('laporan-lampiran-a', 
        ['tahun' => $year, 'bulan' => $month, 'dataProvider' => $dataProvider, 'model' => $model]);}

        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    } 
    
     public function actionLaporanLn2($carian_icno = null, $tahun = null, $bulan = null) {
       
        $year = date('Y');
        $month = date('m');
        $carian = $carian_icno;

        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $month = $bulan;
        } 
         
        $model = new Ln();
        
//        $query = Ln::find()->where(['MONTH(entry_date)' => $month])->andWhere(['YEAR(entry_date)' => $year])->orderBy(['entry_date' => SORT_ASC]);
       
         if($bulan == 0 ){
            $query = \app\models\ln\Ln::find()->where(['YEAR(entry_date)' => $year])->andWhere(['hantar' => [1]])->orderBy(['entry_date' => SORT_ASC]);
         } 
        elseif($bulan != 0 && $carian == NULL){
//            $query = Ln::find()->where(['MONTH(entry_date)' => $month])->andWhere(['YEAR(entry_date)' => $year])->andWhere(['status_surat' => [1,2,3]])->orderBy(['entry_date' => SORT_ASC]);
            $query = \app\models\ln\Ln::find()->where(['MONTH(entry_date)' => $month])->andWhere(['YEAR(entry_date)' => $year])->andWhere(['hantar' => [1]])->orderBy(['entry_date' => SORT_ASC]);

        }
        else{
//            $query = Ln::find()->where(['icno' => $carian_icno])->andWhere(['YEAR(entry_date)' => $year,'status_surat' => [1,2,3]])->orderBy(['entry_date' => SORT_ASC]);
            $query = \app\models\ln\Ln::find()->where(['icno' => $carian_icno])->andWhere(['YEAR(entry_date)' => $year, 'hantar' => [1]])->orderBy(['entry_date' => SORT_ASC]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query, 
            'pagination' => [ 'pageSize' => 30]
        ]);
        
        if(\app\models\ln\TblAdmin::find()->where(['icno'=> Yii::$app->user->getId()])->exists()){
        return $this->render('laporan-ln2', 
        ['tahun' => $year, 'bulan' => $month, 'dataProvider' => $dataProvider, 'model' => $model]);}
        
       else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    } 
    
    public function actionPadam()
    {
        return Yii::$app->FileManager->DeleteFile('');//insert the code
    }

    // data entry sejarah permohonan by admin
    public function actionSejarahPerjalanan()
    { 
    
        $model = new RefTravel();
        $icno =  Yii::$app->user->getId();

        $query = RefTravel::find()->where(['status' => 1]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 

        if ($model->load(Yii::$app->request->post())){ 
        
            $staff = $this->findBiodata($model->icno);

            $model->name = $staff->CONm;  
            $model->created_by = $icno;
            $model->created_at = date('Y-m-d H:i:s');
            $model->status = 'LULUS';
            $model->save(false);  
            
            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar']);
            
            return $this->redirect(['sejarah-perjalanan'] );
        }

        return $this->render('sej_perjalanan',[
               'model' => $model,
               'dataProvider' => $DataProvider,

        ]);
      
    }

}


