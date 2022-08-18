<?php

namespace app\controllers;

use Yii;
use app\models\pengesahan\Pengesahan;
use app\models\pengesahan\PengesahanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\Notification;
use app\models\pengesahan\TblAdmin;
use app\models\pengesahan\TblAhlimeeting;
use app\models\hronline\Tblrscoapmtstatus;
use app\models\hronline\Tblrscoconfirmstatus;
use app\models\hronline\Tblanugerah;
use app\models\hronline\Tblsubjek;
use app\models\hronline\Tblpendidikan;
use app\models\hronline\Vcpdlatihan;
use app\models\lnpt\Lpp;
use app\models\pengesahan\TblSurat;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
use app\models\pengesahan\TblUrusMesyuarat;
use app\models\pengesahan\TblPtm;
use app\models\pengesahan\Option;
use app\models\cuti\SetPegawai;
error_reporting(0);
/**
 * PengesahanController implements the CRUD actions for pengesahan model.
 */
class PengesahanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(){
        return [
            'access' => [
                 'class' => AccessControl::className(),
                 'only' => ['mohonpengesahan', 'menunggu', 'senarai', 'rekod', 'permohonanpengesahan', 'tindakan_bsm', 'tindakan_jfpiu',  'findEduBM', 'semakan'],
                'rules' => [
                        [
                        'actions' => ['mohonpengesahan', 'menunggu', 'senarai', 'rekod', 'permohonanpengesahan', 'tindakan_bsm', 'tindakan_jfpiu', 'findEduBM', 'semakan'],
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
    
    protected function notifikasi($icno, $content){
        //--------Model Notification-----------//
                $ntf = new Notification(); //noti untuk kp
                $ntf->icno = $icno;
                $ntf->title = 'Pengesahan Dalam Perkhidmatan';
                $ntf->content = $content;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                //--------Model Notification-----------//
    }

    public function ICNO() {
        return Yii::$app->user->getId();
    }
 
    public function actionHalamanUtamaPengesahan(){
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => [1,2]  ] )->exists()){
        return $this->render('halaman-utama-pengesahan', [
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionHalamanPengesahanPentadbiran(){
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => 2 ] )->exists()){
        return $this->render('halaman-pengesahan-pentadbiran', [
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionHalamanTetapan(){
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => [1,2] ] )->exists()){
        return $this->render('halaman-tetapan', [
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    protected function newpengesahanpentadbiran($skim,$tarikh_lulus_ptm,$file,$file2,$file5){
        
        $model = new Pengesahan(); //noti untuk kp
        $model->icno = Yii::$app->user->getId();
        $pegawai = Department::findOne(['id' => $model->kakitangan->DeptId]);
        $pegawai2 = SetPegawai::findOne(['pemohon_icno' => $model->icno]);
        $model->skim = $skim;
        $model->tarikh_lulus_ptm = $tarikh_lulus_ptm;
        $model->tarikh_m = date('Y-m-d H:i:s');
        
        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $model->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        $model->app_by = $pegawaisub->chief; //kj 
        }
        
//        if($pegawai2->pelulus_icno != NULL){
//        $model->app_by = $pegawai2->pelulus_icno;
//        }
        
        if($model->ver_by == ''){ 
            $model->status_pp = '';
            $model->status ='DALAM TINDAKAN KETUA JABATAN'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $model->app_by;
            }
        $model->job_category = '2';   
        $model->status_jfpiu = 'Tunggu Perakuan';
        $model->status_bsm = 'Tunggu Kelulusan';     
  
        if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'pengesahandalamperkhidmatan');
                $filepath = $fileapi->file_name_hashcode;      
        }
        else{
            $filepath = '';
        }

        if($file2){
                $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'pengesahandalamperkhidmatan');
                $filepath2 = $fileapi->file_name_hashcode;   
        }
        else{
            $filepath2 = '';
        }
        
        if($file5){
                $fileapi = Yii::$app->FileManager->UploadFile($file5->name, $file5->tempName, '04', 'pengesahandalamperkhidmatan');
                $filepath5 = $fileapi->file_name_hashcode;   
        }
        else{
            $filepath5 = '';
        }
              
        $model->dokumen_sokongan = $filepath;
        $model->dokumen_sokongan2 = $filepath2;
        $model->dokumen_sokongan5 = $filepath5;
 
        $model->save(false);
        $this->notifikasi($icnopetindak1, "Permohonan pengesahan dalam perkhidmatan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['pengesahan/menunggu'], ['class'=>'btn btn-primary btn-sm']));
        $this->notifikasi($model->icno, "Permohonan pengesahan dalam perkhidmatan anda telah dihantar untuk tindakan ".$petindak1. " ".Html::a('<i class="fa fa-arrow-right"></i>', ['pengesahan/semakan'], ['class'=>'btn btn-primary btn-sm']));
                
    }
    
    public function actionSemakan(){
        $icno=Yii::$app->user->getId();
        $status = Pengesahan::findAll(['icno' => $icno]);
        $searchModel = new PengesahanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('semakan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status' => $status,
        ]);
    }
    
    /**
     * Lists all pengesahan models.
     * @return mixed
     */
    public function actionIndex(){
        
        $icno=Yii::$app->user->getId();
        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);  
        
        $model = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt'); 
        //ambil status pengesahan yang latest
        $confirmstatuspengesahan = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno, 'ConfirmStatusStDt' => $model])->one()->ConfirmStatusCd;
        
        //ambil tarikh status pengesahan yang latest
        //$confirm = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno, 'ConfirmStatusStDt' => $model])->one()->ConfirmStatusStDt;
        //var_dump($confirm);die;
        //$m = Tblprcobiodata::find()->where(['ICNO' => $icno])->min('startDateSandangan'); 
        $m = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt');
        $date1=date_create($m);
        $date2=date_create(date('Y-m-d'));
        $tempohstatuspengesahan = date_diff($date1, $date2)->format('%y Tahun %m Bulan %d Hari');
 
        if(Department::find()->where( ['chief' => $icno, 'isActive' => '1'] )->exists() ){
        return $this->redirect('menunggu');} 
        
        elseif($biodata->jawatan->job_category == "1" && $tempohstatuspengesahan >= "1" && $confirmstatuspengesahan != "1" && $confirmstatuspengesahan != "8" && $biodata->statLantikan == "1"){ //jika user staf lantikan tetap cukup tempoh 1 tahun & belum disahkan & staf akademik & status pengesahan (dalam percubaan lantikan pertama, dalam percubaan lantikan semula, dalam percubaan lanjutan tanpa denda, dalam percubaan lanjutan berdenda)
        return $this->redirect(['pengesahanakademik/semakanakademik']);
        }
        
        elseif($biodata->jawatan->job_category == "1" && $tempohstatuspengesahan >= "0" && $confirmstatuspengesahan != "1" && $confirmstatuspengesahan != "2" && $confirmstatuspengesahan != "3" && $confirmstatuspengesahan != "4" && $confirmstatuspengesahan != "8" && $biodata->statLantikan == "1"){ //jika user staf lantikan tetap & belum disahkan & staf akademik & status pengesahan (dalam percubaan lanjutan tanpa denda, dalam percubaan lanjutan berdenda)
        return $this->redirect(['pengesahanakademik/semakanakademik']);
        }
        
        else if(\app\models\pengesahan\TblStaff::find()->where(['icno' => $icno, 'category' => 1])->exists()){ //jika user ada dalam senarai dan category 1(akademik) 
        return $this->redirect(['pengesahanakademik/semakanakademik']);
        }
        
        elseif($biodata->jawatan->job_category == "2" &&  $tempohstatuspengesahan >= "1" && $confirmstatuspengesahan != "1" && $confirmstatuspengesahan != "8"  && $biodata->statLantikan == "1"){ //jika user staf lantikan tetap cukup tempoh 1 tahun & belum disahkan & staf pentadbiran & status pengesahan (dalam percubaan lantikan pertama, dalam percubaan lantikan semula, dalam percubaan lanjutan tanpa denda, dalam percubaan lanjutan berdenda)
        return $this->redirect('semakan');
        }
        
        elseif($biodata->jawatan->job_category == "2" &&  $tempohstatuspengesahan >= "0" && $confirmstatuspengesahan != "1" && $confirmstatuspengesahan != "2"  && $confirmstatuspengesahan != "3"  && $confirmstatuspengesahan != "4"  && $confirmstatuspengesahan != "8"  && $biodata->statLantikan == "1"){ //jika user staf lantikan tetap & belum disahkan & staf pentadbiran & status pengesahan (dalam percubaan lanjutan tanpa denda, dalam percubaan lanjutan berdenda)
        return $this->redirect('semakan');
        }
        
        else if(\app\models\pengesahan\TblStaff::find()->where(['icno' => $icno, 'category' => 2])->exists()){ //jika user ada dalam senarai dan category 2(pentadbiran)
          return $this->redirect('semakan');
        }
        
//        elseif($biodata->jawatan->job_category == "1" && $tempohstatuspengesahan >= "1" && $confirmstatuspengesahan != "1" && $confirmstatuspengesahan != "8"  && $biodata->statLantikan == "1" && $biodata->gredJawatan == "223"){ //jika user staf lantikan tetap & belum disahkan & staf akademik & status pengesahan (dalam percubaan lantikan pertama, dalam percubaan lantikan semula, dalam percubaan lanjutan tanpa denda)
//        return $this->redirect(['pengesahanakademik/semakanakademikppp']);
//        }
        
//         elseif(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '1' ] )->exists()){
//        return $this->redirect(['pengesahanakademik/senarai']);}
//        
//         elseif(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists()){
//        return $this->redirect('senarai');}
        
        elseif(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => [1,2]] )->exists()){
        return $this->redirect(['halaman-utama-pengesahan']);}
        
        elseif(TblAhlimeeting::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '1' ] )->exists()){
        return $this->redirect(['pengesahanakademik/datamesyuarat']);}
        
        elseif(TblAhlimeeting::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists()){
        return $this->redirect('datamesyuarat');}

        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->render('index');}
    }
    
    protected function findEduBM($Level_id, $Subject_id){
        $icno=Yii::$app->user->getId();
        $model = Tblsubjek::findOne(['ICNO' => $icno, 'EduLevel_id' => $Level_id, 'Subject_id' => $Subject_id]);

        if ($model) {
            return $model;
        } else {
            return null;
        }
    }

    public function actionMohonpengesahan(){
        $icno=Yii::$app->user->getId(); 
        
        $checkApplication = Pengesahan::find()->where(['letter_sent' => [0],'icno' => $icno]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['pengesahan/index']);
        }

        $tahunstarttetap = \app\models\pengesahan\Pengesahan::latesttahuntempoh($icno); 
        
        $model = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt'); 
        //ambil tarikh status pengesahan yang latest
        $confirmstatuspengesahan = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno, 'ConfirmStatusStDt' => $model])->one()->ConfirmStatusCd;
        
        //ambil tarikh status pengesahan yang latest
        //$confirm = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno, 'ConfirmStatusStDt' => $model])->one()->ConfirmStatusStDt;
        //var_dump($confirm);die;
        //$m = Tblprcobiodata::find()->where(['ICNO' => $icno])->min('startDateSandangan');
        $m = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt');
        $date1=date_create($m);
        $date2=date_create(date('Y-m-d'));
        $tempohstatuspengesahan = date_diff($date1, $date2)->format('%y Tahun %m Bulan %d Hari');

        $model = new Pengesahan();
        $model->icno = $icno;
        $status = Pengesahan::findAll(['icno' => $icno]); //senarai status permohonan
        $mod=Pengesahan::find()->where(['icno' => $icno])->orderBy(['id' => SORT_DESC])->one(); //cari status permohonan terakhir
       
        //$subjek = Tblsubjek::findAll(['ICNO' => $model->icno, 'EduLevel_id' => '14', 'Subject_id' => '12']);
        //$subjek = Tblsubjek::findOne(['ICNO' => $model->icno, 'EduLevel_id' => '14', 'Subject_id' => '12']);
        $subjekspm = Tblsubjek::findOne(['ICNO' => $model->icno, 'EduLevel_id' => '14', 'Subject_id' => '12']);
        $subjekspm2 = Tblsubjek::findOne(['ICNO' => $model->icno, 'EduLevel_id' => '23', 'Subject_id' => '12']);
        $subjekpmr = Tblsubjek::findOne(['ICNO' => $model->icno, 'EduLevel_id' => '15', 'Subject_id' => '260']);
        
        $displaymohon='none';

        if($mod){
        if(($mod->status =='TIDAK LULUS' ||  $mod->status == NULL)){
            $displaymohon='';                               //show mohon form untuk yang sudah diluluskan dan yang pertama kali mohon
        }}
        elseif(!$mod){
            $displaymohon=''; 
        }
        else{
           Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda Belum Boleh Memohon']); 
        }
        
        if ($model->load(Yii::$app->request->post())) {
            {
//                $file = UploadedFile::getInstance($model, 'file');
//                $file2 = UploadedFile::getInstance($model, 'file2');
                
                $file = UploadedFile::getInstance($model, 'dokumen_sokongan');
                $file2 = UploadedFile::getInstance($model, 'dokumen_sokongan2');
                $file5 = UploadedFile::getInstance($model, 'dokumen_sokongan5');
        
                $bmSpm = $this->findEduBM(14, 12);  
                $bmSpm2 = $this->findEduBM(23, 12);  
                $bmPmr = $this->findEduBM(15, 260);  
               
//                if ($bmSpm != null) {
//
//                    //call proses saringan
//                    $this->newpengesahanpentadbiran($model->skim,$model->tarikh_lulus_ptm,$file,$file2);
//                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dihantar', 'type' => 'success', 'msg' => 'Permohonan anda telah berjaya dihantar.']);
//                    return $this->redirect(['semakan', 'id' => $model->id]);
//                } else {
//                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf, maklumat peribadi anda tidak lengkap!', 'type' => 'error', 'msg' => 'Sila muat naik salinan sijil SPM anda dan tambah gred untuk subjek Bahasa Melayu pada bahagian pendidikan SPM/Setaraf.']);
//                    return $this->redirect(['pendidikan/view']);
//                }
                
                if ($model->kakitangan->jawatan->gred_no != "11"){
                if (($bmSpm != null) || ($bmSpm2 != null)) {

                    //call proses saringan
                    $this->newpengesahanpentadbiran($model->skim,$model->tarikh_lulus_ptm,$file,$file2,$file5);
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dihantar', 'type' => 'success', 'msg' => 'Permohonan anda telah berjaya dihantar.']);
                    return $this->redirect(['semakan', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf, maklumat peribadi anda tidak lengkap!', 'type' => 'error', 'msg' => 'Sila muat naik salinan sijil SPM anda dan tambah gred untuk subjek Bahasa Melayu pada bahagian pendidikan SPM/Setaraf.']);
                    return $this->redirect(['pendidikan/view']);
                }
                }
                
                else if ($model->kakitangan->jawatan->gred_no == "11"){
                     if ($bmPmr != null) {

                    //call proses saringan
                    $this->newpengesahanpentadbiran($model->skim,$model->tarikh_lulus_ptm,$file,$file2,$file5);
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Dihantar', 'type' => 'success', 'msg' => 'Permohonan anda telah berjaya dihantar.']);
                    return $this->redirect(['semakan', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('alert', ['title' => 'Maaf, maklumat peribadi anda tidak lengkap!', 'type' => 'error', 'msg' => 'Sila muat naik salinan sijil PMR anda dan tambah gred untuk subjek Bahasa Melayu pada bahagian pendidikan PMR/Setaraf.']);
                    return $this->redirect(['pendidikan/view']);
                }
                }
                
            } 
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
       
        if($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "2" && $tempohstatuspengesahan >= "1" && $confirmstatuspengesahan != "1" && $confirmstatuspengesahan != "8" && $confirmstatuspengesahan != ""){ //jika user staf lantikan tetap cukup tempoh 1 tahun & belum disahkan & staf pentadbiran & status pengesahan (dalam percubaan lantikan pertama, dalam percubaan lantikan semula, dalam percubaan lanjutan tanpa denda, dalam percubaan lanjutan berdenda)
        //Yii::$app->session->setFlash('alert', ['title' => 'PERHATIAN', 'type' => 'warning', 'msg' => 'Sukacita dimaklumkan bahawa, Jabatan Pendaftar mempelawa kakitangan berstatus tetap yang belum disahkan dalam jawatan dan telah memenuhi kriteria Pengesahan Dalam Perkhidmatan untuk mengisi permohonan anda di sini.']);
        
            return $this->render('mohonpengesahan', 
                ['model' => $model, 'tahunstarttetap' => $tahunstarttetap, 'subjekspm' => $subjekspm, 'subjekspm2' => $subjekspm2,'subjekpmr' => $subjekpmr, 'mod' => $mod, 'status' => $status, 'displaymohon' => $displaymohon,   'options'=>$options]);
        }
        
        else if($model->kakitangan->statLantikan == "1" && $model->kakitangan->jawatan->job_category == "2" && $tempohstatuspengesahan >= "0" && $confirmstatuspengesahan != "1" && $confirmstatuspengesahan != "2" && $confirmstatuspengesahan != "3" && $confirmstatuspengesahan != "4" && $confirmstatuspengesahan != "8" && $confirmstatuspengesahan != ""){ //jika user staf lantikan tetap & belum disahkan & staf pentadbiran & status pengesahan (dalam percubaan lanjutan tanpa denda, dalam percubaan lanjutan berdenda)        
            return $this->render('mohonpengesahan', 
                ['model' => $model, 'tahunstarttetap' => $tahunstarttetap, 'subjekspm' => $subjekspm, 'subjekspm2' => $subjekspm2,'subjekpmr' => $subjekpmr, 'mod' => $mod, 'status' => $status, 'displaymohon' => $displaymohon,   'options'=>$options]);
        }
        
        else if(\app\models\pengesahan\TblStaff::find()->where(['icno' => $icno, 'category' => 2])->exists()){ //jika user ada dalam senarai dan category 2(pentadbiran)
        return $this->render('mohonpengesahan', 
                ['model' => $model, 'tahunstarttetap' => $tahunstarttetap, 'subjekspm' => $subjekspm, 'subjekspm2' => $subjekspm2, 'subjekpmr' => $subjekpmr, 'mod' => $mod, 'status' => $status, 'displaymohon' => $displaymohon,   'options'=>$options]);
        }
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}

    return $this->render('mohonpengesahan',  ['model' => $model, 'tahunstarttetap' => $tahunstarttetap, 'subjekspm' => $subjekspm, 'subjekspm2' => $subjekspm2, 'subjekpmr' => $subjekpmr, 'mod' => $mod, 'status' => $status, 'displaymohon' => $displaymohon,  'options'=>$options]);
    }
 
    public function actionMenunggu(){
        
        $searchModel = new PengesahanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $icno=Yii::$app->user->getId();
        $titlepentadbiran = '';
        $senaraipentadbiran = '';
        $displaypentadbiran = 'none';
        if(Department::find()->where( ['chief' => $icno, 'isActive' => '1'] )->exists()){
            $senaraipentadbiran = Pengesahan::find()->where(['app_by' => $icno, 'job_category' => '2'])->orderBy(['tarikh_m' => SORT_DESC]);
            $titlepentadbiran='Senarai Menunggu Perakuan [Pentadbiran]';
        }
        
        if($titlepentadbiran!=NULL){
            $displaypentadbiran = '';}
        
        $senaraipentadbirans = new ActiveDataProvider([

            'query' => $senaraipentadbiran,

            'pagination' => [

                'pageSize' => 10,

            ],

        ]);
          
        if($titlepentadbiran!=NULL){ 
        return $this->render('menunggu', [
            'icno' => $icno,
            'senaraipentadbiran' => $senaraipentadbirans,
            'titlepentadbiran' => $titlepentadbiran,
            'displaypentadbiran' => $displaypentadbiran,          
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);}
       
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
       
    protected function findModel($id){
        
        if (($model = Pengesahan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionTindakan_jfpiu($id){
        $model = $this->findModel($id);
        $post =Yii::$app->request->post('tempohs');
        $status = Pengesahan::findAll(['icno' => $model->icno]); //senarai status permohonan
        $tatatertib = \app\models\tatatertib_staf\TblRekodTatatertib::findAll(['icno' => $model->icno]);
        $lantikan = Tblrscoapmtstatus::findAll(['ICNO' => $model->icno]);
        $pendidikan = Tblpendidikan::findAll(['ICNO' => $model->icno]);
        $subjekspm = Tblsubjek::findOne(['ICNO' => $model->icno, 'EduLevel_id' => '14', 'Subject_id' => '12']);
        $subjekspm2 = Tblsubjek::findOne(['ICNO' => $model->icno, 'EduLevel_id' => '23', 'Subject_id' => '12']);
        $subjekpmr = Tblsubjek::findOne(['ICNO' => $model->icno, 'EduLevel_id' => '15', 'Subject_id' => '260']);
        $anugerah = Tblanugerah::findAll(['ICNO' => $model->icno]);
        $pengesahan = Tblrscoconfirmstatus::findAll(['ICNO' => $model->icno]);
        $latihan = Vcpdlatihan::findAll(['vcl_id_staf' => $model->icno]);
        $lpp = Lpp::findAll(['PYD' => $model->icno]);
        $icno = Yii::$app->user->getId();
        $today = date('Y-m-d');
        $biodata = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
        
        $tahunstarttetap = Tblprcobiodata::find()->where(['ICNO' => $model->icno])->min('YEAR(startdatelantik)');

        if($model->load(Yii::$app->request->post())) {
            $model->app_date = date('Y-m-d H:i:s');
            if($model->tempoh_l_jfpiu == 'LAIN-LAIN'){
                $model->tempoh_l_jfpiu = $post.' BULAN';
            }
            
            if($model->status_jfpiu == 'Diperakui') { 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakui!']);}
            elseif($model->status_jfpiu == 'Tidak Diperakui') {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);}
            if($model->status_jfpiu == '' || (($model->status_jfpiu == 'Diperakui' && ($model->ulasan_jfpiu == '')))|| (($model->status_jfpiu == 'Tidak Diperakui' && ($model->ulasan_jfpiu == '')&& ($model->tempoh_l_jfpiu == '' || $model->tempoh_l_jfpiu == ' BULAN')))){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan perakuan anda.']); 
            
            }
             else{
                $model->status = 'DALAM TINDAKAN BSM';
                $model->save(false);
                $this->notifikasi($model->icno, "Permohonan pengesahan dalam perkhidmatan anda telah dihantar untuk tindakan BSM. ".Html::a('<i class="fa fa-arrow-right"></i>', ['pengesahan/semakan'], ['class'=>'btn btn-primary btn-sm']));
//                $this->notifikasi($model->app_by, "Permohonan pengesahan dalam perkhidmatan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['pengesahan/menunggu'], ['class'=>'btn btn-primary btn-sm']));

                return $this->redirect(['pengesahan/menunggu']);
        }}
        
        $countlantikan=0;
        if($lantikan){
            $countlantikan = count($lantikan);}
            
        if($icno==$model->app_by){
        return $this->render('tindakan_jfpiu', [
                    'lantikan' => $lantikan,
                    'model' => $model,
                    'today' => $today,
                    'status' => $status,
                    'tatatertib' => $tatatertib,
                    'latihan' => $latihan,
                    'icno' => $icno,
                    'lpp' => $lpp,
                    'countlantikan' => $countlantikan,
                    'pendidikan' => $pendidikan,
                    'subjekspm' => $subjekspm,
                    'subjekspm2' => $subjekspm2,
                    'subjekpmr' => $subjekpmr,
                    'anugerah' => $anugerah,
                    'pengesahan' => $pengesahan,
                    'tahunstarttetap' => $tahunstarttetap,
                    'bil' => '1',
                    'edit' => $edit,
                    'view' => $view,
                    'biodata' => $biodata
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionPermohonanpengesahan($id){
     
        $model = $this->findModel($id);
        $status = Pengesahan::findAll(['icno' => $model->icno]); //senarai status permohonan
        $tatatertib = \app\models\tatatertib_staf\TblRekodTatatertib::findAll(['icno' => $model->icno]);
        $pendidikan = Tblpendidikan::findAll(['ICNO' => $model->icno]);
        $lantikan = Tblrscoapmtstatus::findAll(['ICNO' => $model->icno]);
        $subjekspm = Tblsubjek::findOne(['ICNO' => $model->icno, 'EduLevel_id' => '14', 'Subject_id' => '12']);
        $subjekspm2 = Tblsubjek::findOne(['ICNO' => $model->icno, 'EduLevel_id' => '23', 'Subject_id' => '12']);
        $subjekpmr = Tblsubjek::findOne(['ICNO' => $model->icno, 'EduLevel_id' => '15', 'Subject_id' => '260']);
        $anugerah = Tblanugerah::findAll(['ICNO' => $model->icno]);
        $pengesahan = Tblrscoconfirmstatus::findAll(['ICNO' => $model->icno]);
        $latihan = Vcpdlatihan::findAll(['vcl_id_staf' => $model->icno]);
        $lpp = Lpp::findAll(['PYD' => $model->icno]);
        $biodata = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
        
        $tahunstarttetap = Tblprcobiodata::find()->where(['ICNO' => $model->icno])->min('YEAR(startdatelantik)');
        if($lantikan){
            $countlantikan = count($lantikan);
        }
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists() || TblAhlimeeting::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists()){
        return $this->render('permohonanpengesahan', [
                    'model' => $model,
                    'status' => $status,
                    'tatatertib' => $tatatertib,
                    'lantikan' => $lantikan,
                    'pendidikan' => $pendidikan,
                    'subjekspm' => $subjekspm,
                    'subjekspm2' => $subjekspm2,
                    'subjekpmr' => $subjekpmr,
                    'anugerah' => $anugerah,
                    'pengesahan' => $pengesahan,
                    'latihan' => $latihan,
                    'lpp' => $lpp,
                    'tahunstarttetap' => $tahunstarttetap,
                    'countlantikan' => $countlantikan,
                    'biodata' => $biodata,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionSenarai(){
            
        $searchModel = new PengesahanSearch();
        $maklumat = new Tblrscoconfirmstatus();
        $maklumat2 = new TblPtm();
//        $today = date('Y-m-d');
//        $model->ver_date = date('Y-m-d H:i:s');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->query->orderBy([ 'tarikh_m' => 'SORT_DESC']);
        $dataProvider->query->where(['job_category' => '2', 'sah_tbl_pengesahan.status' => ['DALAM TINDAKAN KETUA JABATAN', 'DALAM TINDAKAN BSM']]);

        $a=$searchModel->status_bsm;
        if(in_array('Tunggu Kelulusan', $a)) {
            array_push($a, 'Draft Diluluskan', 'Draft Ditolak');
        }
        $dataProvider->query->andFilterWhere(['in', 'status_bsm', $a]);
        $models = Pengesahan::find()->All();
        $selection=(array)Yii::$app->request->post('selection');//typecasting
        
            if (Yii::$app->request->post('simpan')){
                
                foreach ($models as $data) {
                    if('y'.$data->id == Yii::$app->request->post($data->id)){
                    $model = $this->findModel($data->id);
                    $model->status_bsm = 'Draft Diluluskan';
                    $model->save(false);
                    }
                    elseif('n'.$data->id == Yii::$app->request->post($data->id)){
                    $model = $this->findModel($data->id);
                    $model->status_bsm = 'Draft Ditolak';
                    $model->save(false);
                    }
            }
                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tindakan Berjaya Disimpan']);
            }

            elseif (Yii::$app->request->post('hantar')) {
                foreach($selection as $id){
                $hantar= $this->findModel($id);//make a typecasting
                //if('n'.$hantar->id == Yii::$app->request->post($hantar->id) && $hantar->tempoh_l_bsm != ''){
                if('n'.$hantar->id == Yii::$app->request->post($hantar->id) && $hantar->tempoh_l_bsm != ''){
                    $hantar->status ='TIDAK LULUS';
                    $hantar->status_bsm='Tidak Diluluskan';
                    $this->notifikasi($hantar->icno, "Permohonan pengesahan dalam perkhidmatan anda tidak berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['pengesahan/semakan'], ['class'=>'btn btn-primary btn-sm']));
                    $hantar->letter_sent = 1;
                    $hantar->ver_date = date('Y-m-d H:i:s');
                    $hantar->save(false);   
                }
                //elseif('y'.$hantar->id == Yii::$app->request->post($hantar->id)&& $hantar->tempoh_l_bsm != ''){
                elseif('y'.$hantar->id == Yii::$app->request->post($hantar->id)){
                    $hantar->status ='LULUS';
                    $hantar->status_bsm='Diluluskan';
                    $this->notifikasi($hantar->icno, "Permohonan pengesahan dalam perkhidmatan anda berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['pengesahan/semakan'], ['class'=>'btn btn-primary btn-sm']));
                    $hantar->letter_sent = 1;
                    $hantar->ver_date = date('Y-m-d H:i:s');
                    $hantar->save(false);       
                }
//                $hantar->letter_sent = 1;
//                $hantar->ver_date = date('Y-m-d H:i:s');
//                $hantar->save();               
                
                if(($hantar->status = 'LULUS')|| ($hantar->status = 'TIDAK LULUS')){
                    $maklumat->ICNO =  $hantar->icno;
                    $maklumat->ConfirmStatusCd =  $hantar->ConfirmStatusCd;
                    //$maklumat->ConfirmStatusStDt =  $hantar->ConfirmStatusDt;
                    //$maklumat->ConfirmStatusStDt = date('Y-m-d'); 
                    $maklumat->ConfirmStatusStDt =  $hantar->tarikh_pengesahan;
                    $maklumat2->ICNO =  $hantar->icno;
                    $maklumat2->tarikhPtm =  $hantar->tarikh_lulus_ptm;
                   
                    $maklumat2->save();
                    $maklumat->save(false);
               }
                
                }
            }
            
             elseif(Yii::$app->request->post('notipemohon')){
               $this->notifipemohon(); 
            }      
            elseif(Yii::$app->request->post('notipegawai')){
               $this->notifipegawai(); 
            }
            elseif(Yii::$app->request->post('belummohon')){
               return $this->redirect('belummohon'); 
            }

       if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists()){
        return $this->render('senarai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'today' => $today,
            'model' => $model,
            'maklumat' => $maklumat
       ]);}
       
         elseif(TblAhlimeeting::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists()){
        return $this->redirect('datamesyuarat');}
      
       else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionRekod(){
            
        $searchModel = new PengesahanSearch();
        $maklumat = new Tblrscoconfirmstatus();
        $maklumat2 = new TblPtm();
//        $today = date('Y-m-d');
//        $model->ver_date = date('Y-m-d H:i:s');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->query->orderBy([ 'tarikh_m' => 'SORT_DESC']);
        $dataProvider->query->where(['job_category' => '2', 'sah_tbl_pengesahan.letter_sent' => '1', 'sah_tbl_pengesahan.status' => ['LULUS', 'TIDAK LULUS']]);

        $a=$searchModel->status_bsm;
        if(in_array('Tunggu Kelulusan', $a)) {
            array_push($a, 'Draft Diluluskan', 'Draft Ditolak');
        }
        $dataProvider->query->andFilterWhere(['in', 'status_bsm', $a]);
        $models = Pengesahan::find()->All();
        $selection=(array)Yii::$app->request->post('selection');//typecasting
        
            if (Yii::$app->request->post('simpan')){
                
                foreach ($models as $data) {
                    if('y'.$data->id == Yii::$app->request->post($data->id)){
                    $model = $this->findModel($data->id);
                    $model->status_bsm = 'Draft Diluluskan';
                    $model->save();
                    }
                    elseif('n'.$data->id == Yii::$app->request->post($data->id)){
                    $model = $this->findModel($data->id);
                    $model->status_bsm = 'Draft Ditolak';
                    $model->save();
                    }
            }
                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Tindakan Berjaya Disimpan']);
            }

            elseif (Yii::$app->request->post('hantar')) {
                foreach($selection as $id){
                $hantar= $this->findModel($id);//make a typecasting
                //if('n'.$hantar->id == Yii::$app->request->post($hantar->id) && $hantar->tempoh_l_bsm != ''){
                if('n'.$hantar->id == Yii::$app->request->post($hantar->id) && $hantar->tempoh_l_bsm != ''){
                    $hantar->status ='TIDAK LULUS';
                    $hantar->status_bsm='Tidak Diluluskan';
                    $this->notifikasi($hantar->icno, "Permohonan pengesahan dalam perkhidmatan anda tidak berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['pengesahan/semakan'], ['class'=>'btn btn-primary btn-sm']));
                    
                }
                //elseif('y'.$hantar->id == Yii::$app->request->post($hantar->id)&& $hantar->tempoh_l_bsm != ''){
                elseif('y'.$hantar->id == Yii::$app->request->post($hantar->id)){
                    $hantar->status ='LULUS';
                    $hantar->status_bsm='Diluluskan';
                    $this->notifikasi($hantar->icno, "Permohonan pengesahan dalam perkhidmatan anda berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['pengesahan/semakan'], ['class'=>'btn btn-primary btn-sm']));
                    
                }
                $hantar->letter_sent = 1;
                $hantar->ver_date = date('Y-m-d H:i:s');
                $hantar->save();               
                
                if(($hantar->status = 'LULUS')|| ($hantar->status = 'TIDAK LULUS')){
                    $maklumat->ICNO =  $hantar->icno;
                    $maklumat->ConfirmStatusCd =  $hantar->ConfirmStatusCd;
                    //$maklumat->ConfirmStatusStDt =  $hantar->ConfirmStatusDt;
                    //$maklumat->ConfirmStatusStDt = date('Y-m-d'); 
                    $maklumat->ConfirmStatusStDt =  $hantar->tarikh_pengesahan;
                    $maklumat2->ICNO =  $hantar->icno;
                    $maklumat2->tarikhPtm =  $hantar->tarikh_lulus_ptm;
                   
                    $maklumat2->save();
                    $maklumat->save(false);
               }
                
                }
            }
            

       if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists()){
        return $this->render('rekod', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'today' => $today,
            'model' => $model,
            'maklumat' => $maklumat
       ]);}
       
         elseif(TblAhlimeeting::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists()){
        return $this->redirect('datamesyuarat');}
      
       else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
//    public function actionRekod(){
//               
//        $jumlah_permohonan_pentadbiran = $this->findJumlahPermohonanPentadbiranSemasa();
//        $jumlah_permohonan_akademik = $this->findJumlahPermohonanAkademikSemasa();
//        $jumlah_permohonan_pentadbiran_berjaya = $this->findJumlahPermohonanPentadbiranBerjaya();
//        $jumlah_permohonan_pentadbiran_gagal = $this->findJumlahPermohonanPentadbiranDitolak();
//        $jumlah_permohonan_akademik_berjaya = $this->findJumlahPermohonanAkademikBerjaya();
//        $jumlah_permohonan_akademik_gagal = $this->findJumlahPermohonanAkademikDitolak();
//       
//        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId()] )->exists() || TblAhlimeeting::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
//        return $this->render('rekod', [
//
//            'jumlah_permohonan_pentadbiran' => $jumlah_permohonan_pentadbiran,
//            'jumlah_permohonan_akademik' => $jumlah_permohonan_akademik,
//            'jumlah_permohonan_pentadbiran_berjaya' => $jumlah_permohonan_pentadbiran_berjaya,
//            'jumlah_permohonan_pentadbiran_gagal' => $jumlah_permohonan_pentadbiran_gagal,
//            'jumlah_permohonan_akademik_berjaya' => $jumlah_permohonan_akademik_berjaya,
//            'jumlah_permohonan_akademik_gagal' => $jumlah_permohonan_akademik_gagal,
//       ]);}
//        
//       else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('index');}
//    }
    
    public function actionDatamesyuarat(){
        $searchModel = new PengesahanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy([ 'tarikh_m' => 'SORT_DESC']);
        $dataProvider->query->where(['job_category' => '2']);
        $a=$searchModel->status_bsm;
        if(in_array('Tunggu Kelulusan', $a)) {
            array_push($a, 'Draft Diluluskan', 'Draft Ditolak');
        }
        $dataProvider->query->andFilterWhere(['in', 'status_bsm', $a]);

       if(TblAhlimeeting::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists()){
        return $this->render('datamesyuarat', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
       ]);}
       
       else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
                
    public function actionTindakan_bsm($id){
         
                $model = $this->findModel($id);
                //$model->ver_date = date('Y-m-d H:i:s');
                $today = date('Y-m-d');

                $request = Yii::$app->request;
                
                //$tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke'=>SORT_DESC])->limit(1)->one();
                
                if($model->status_bsm == 'Diluluskan' || $model->status_bsm == 'Tidak Diluluskan'){
                    $displaylapor='';$displaytempoh='none'; } 
                else{
                    $displaytempoh='';$displaylapor='none';}
                
                $message = '';
                    $display='none';
                    $lain= '';
                    if($model->tempoh_l_bsm != '1 TAHUN' && $model->tempoh_l_bsm != ''){
                        $display='';
                        $lain= $model->tempoh_l_bsm;
                        $model->tempoh_l_bsm = 'LAIN-LAIN';
                    }
                    
                if(Yii::$app->request->post()){
                    $post=Yii::$app->request->post('Pengesahan')['tempoh_l_bsm'];
                    $model->tempoh_l_bsm = $post;
                    if($post == 'LAIN-LAIN'){
                        $model->tempoh_l_bsm = Yii::$app->request->post('tempohs').' BULAN';
                    }
                          $Pengesahan = $request->post()['Pengesahan'];     
                          $ConfirmStatusCd = $Pengesahan['ConfirmStatusCd'];
                          $ConfirmStatusNm= $Pengesahan['ConfirmStatusNm'];
                          //$ConfirmStatusStDt = $Pengesahan['ConfirmStatusStDt'];
                          $pelanjutan = $Pengesahan['pelanjutan'];
                          $implikasi = $Pengesahan['implikasi'];
                          $ulasan_bsm= $Pengesahan['ulasan_bsm'];
                          $tarikh_pengesahan = $Pengesahan['tarikh_pengesahan'];
                          $tarikh_mohon_balik = $Pengesahan['tarikh_mohon_balik'];
                          $tarikh_mohon_balik2 = $Pengesahan['tarikh_mohon_balik2'];
                          $days = $Pengesahan['days'];
                          $model->ConfirmStatusCd = $ConfirmStatusCd;
                          $model->ConfirmStatusNm = $ConfirmStatusNm;
                          //$model->$ConfirmStatusStDt = $ConfirmStatusStDt;
                          $model->pelanjutan = $pelanjutan;
                          $model->tarikh_pengesahan = $tarikh_pengesahan;
                          $model->tarikh_mohon_balik = $tarikh_mohon_balik;
                          $model->tarikh_mohon_balik2 = $tarikh_mohon_balik2;
                          $model->days = $days;
                          $model->implikasi = $implikasi;
                          $model->ulasan_bsm = $ulasan_bsm;
                          $model->save(false);
                           $message = 'Berjaya Disimpan';
                }
            return $this->renderAjax('tindakan_bsm', [
                'model' => $model,
                'today' => $today,
                'message' => $message,
                'displaytempoh' => $displaytempoh,
                'display' => $display,
                'lain' => $lain,
                'tmp' => $tmp,
            ]); 
    } 
    
    public function actionTambahadmin(){
        
        $admin = TblAdmin::find()->where(['category' => '2'])->All(); //cari senarai admin
        $adminbaru = new TblAdmin; //untuk admin baru
        if ($adminbaru->load(Yii::$app->request->post())) {
                    if(TblAdmin::find()->where( [ 'icno' => $adminbaru->icno, 'category' => '2' ] )->exists()){ //jika admin sudah wujud
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
                    
                    }
                    elseif($adminbaru->kakitangan->CONm != NULL){ //jika icno tidak wujud dalam sistem
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                    $adminbaru->category = '2';
                    $adminbaru->save();
                    }
                    else{
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
                    
                    }
                    
                    return $this->redirect(['pengesahan/tambahadmin']);
                }
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists()){
        return $this->render('tambahadmin', [
            'admin' => $admin,
            'adminbaru' => $adminbaru,
            'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionDelete($id){
        $admin = Tbladmin::findOne(['id' => $id]);
        $admin->delete();
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2'  ] )->exists()){
        return $this->redirect(['tambahadmin']);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionTambahahlimeeting(){
        
        $meeting = TblAhlimeeting::find()->where(['category' => '2'])->All(); //cari senarai admin
        $meetingbaru = new TblAhlimeeting; //untuk admin baru
        if ($meetingbaru->load(Yii::$app->request->post())) {
                    if(TblAhlimeeting::find()->where( [ 'icno' => $meetingbaru->icno, 'category' => '2' ] )->exists()){ //jika admin sudah wujud
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
                    
                    }
                    elseif($meetingbaru->kakitangan->CONm != NULL){ //jika icno tidak wujud dalam sistem
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                        $meetingbaru->category = '2';
                    $meetingbaru->save();
                    }
                    else{
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
                    
                    }
                    
                    return $this->redirect(['pengesahan/tambahahlimeeting']);
                }
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists()){
        return $this->render('tambahahlimeeting', [
            'meeting' => $meeting,
            'meetingbaru' => $meetingbaru,
            'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionDeletemeeting($id){
        $meeting = TblAhlimeeting::findOne(['id' => $id]);
        $meeting->delete();
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists()){
        return $this->redirect(['tambahahlimeeting']);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionSuratPengesahan($id){
        $css = file_get_contents('./css/surat.css');
        #check application
        $model = Pengesahan::find()->where(['id' => $id])->andWhere(['in', 'implikasi', ["TIDAK KAITAN", "TIDAK LULUS", "TANPA DENDA", "DENGAN DENDA"]])->one();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $model])->one();  //panggil nama surat penerima tersebut                        
     
        // get your HTML raw content without any layouts or scripts
            if($model->implikasi == "TIDAK KAITAN"){
            $content = $this->renderPartial('_pengesahanDiluluskan', ['model'=> $model, 'biodata' => $biodata,  'letter' => $model->letter]);
            }
            if($model->implikasi== "TIDAK LULUS"){
            $content = $this->renderPartial('_pengesahanDitolak', ['model'=> $model, 'biodata' => $biodata, 'letter' => $model->letter]);
            }
             if($model->implikasi == "TANPA DENDA"){
            $content = $this->renderPartial('_pengesahanDitolak2', ['model'=> $model, 'biodata' => $biodata, 'letter' => $model->letter]);
            }
             if($model->implikasi == "DENGAN DENDA"){
            $content = $this->renderPartial('_pengesahanDitolak3', ['model'=> $model, 'biodata' => $biodata, 'letter' => $model->letter]);
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
    
    public function actionUrusMesyuarat(){
            
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);
         if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['pengesahan/index']);
        } 
        $urusMesyuarat = TblUrusMesyuarat::find()->All(); //cari semua mesyuarat
        $urus = new TblUrusMesyuarat(); //untuk mesyuarat baru
        if ($urus->load(Yii::$app->request->post())) {
             //$urus->tahun_mesyuarat =  Yii::$app->request->post()['tahun_mesyuarat'];
             $urus->tarikh_mesyuarat =  Yii::$app->request->post()['tarikh_mesyuarat'];
              $urus->masa_mesyuarat =  Yii::$app->request->post()['masa_mesyuarat'];
             $urus->save(false);
             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Disimpan']);   
            return $this->redirect(['urus-mesyuarat', 'id' => $urus->id]);
        }
        return $this->render('urus-mesyuarat', ['urus' => $urus, 'urusMesyuarat' => $urusMesyuarat]);
    
    }
    
    public function actionDeleteUrusMesyuarat($id){
        $admin = TblUrusMesyuarat::findOne(['id' => $id]);
        $admin->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['urus-mesyuarat']);
        
    }
    
    public function actionTetapan(){
        $icno = Yii::$app->user->getId();
        $models = TblAdmin::findOne(['icno' => $icno]);
         if(!$models){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['pengesahan/index']);
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
                        return $this->redirect(['pengesahan/tetapan']);
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
                return $this->redirect(['pengesahan/tetapan']);
            }else{
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Gagal mengemaskini tetapan!']);
                return $this->redirect(['pengesahan/tetapan']);
            }
        }
        $model = ArrayHelper::map(Option::find()->where(['in', 'name', $names])->all(), 'name', 'value');
        return $this->render('tetapan',compact('model'));
    }
    
//    public function actionTakwimpengesahan() {
//        
//        $model = \app\models\pengesahan\TblTakwimPengesahan::find()->All(); 
//        return $this->render('takwimpengesahan', [
//            'model' => $model
//        ]);
//    }
//    
//    public function actionTakwimpengesahanadmin() {
//        
//        $model = \app\models\pengesahan\TblTakwimPengesahan::find()->All(); 
//        
//        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => [1,2] ] )->exists()){
//       
//        return $this->render('takwimpengesahanadmin', [
//            'model' => $model
//        ]);}
//        else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('index');}
//    }
//    
//    public function actionEditbukapermohonan($id) {
//     
//        $model = \app\models\pengesahan\TblTakwimPengesahan::find()->where(['id' => $id])->one();
//        if (Yii::$app->request->post()) {
//           $data = Yii::$app->request->post();
//           $model->start_tarikhpelawaan = date('Y-m-d H:i:s', strtotime($data['starttarikhpelawaan']));
//           $model->end_tarikhtutup = date('Y-m-d H:i:s', strtotime($data['endtarikhtutup']));
//           $model->sesi = date('Y-m-d H:i:s', strtotime($data['sesimesyuarat']));
//                
//           $model->save(false);
//           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Perubahan Berjaya Disimpan']);
//            return $this->redirect('takwimpengesahanadmin');
//        }
//        
//        return $this->render('editbukapermohonan', [
//            'model' => $model
//        ]);
//    }
    
    // notifikasi untuk kakitangan yang telah genap setahun dalam lantikan tetap
    protected function notifipemohon(){
 
        $biodata = Tblprcobiodata::find()->where(['statLantikan' => "1", 'Status' => "1"])->all();

        foreach($biodata as $biodatas){
            $icno=$biodatas->ICNO;
            
            $model = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt'); 
            $confirmstatuspengesahan = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno, 'ConfirmStatusStDt' => $model])->one()->ConfirmStatusCd;

            $m = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt');   
            //$m = Tblrscosandangan::find()->where(['ICNO' => 'icno'])->where(['sandangan_id' => 1])->orderBy(['start_date' => SORT_ASC])->one();
            $date1 = date_create($m);
            $date2=date_create(date('Y-m-d'));
            $tempohstatuspengesahan = date_diff($date1, $date2)->format('%y');

          if($biodatas->jawatan->job_category == "2" && $tempohstatuspengesahan >= "1"&& $confirmstatuspengesahan != "1" && $confirmstatuspengesahan != "8"){ //jika user staf lantikan tetap & belum disahkan & staf pentadbiran
          $this->notifikasi($biodatas->ICNO, "Sukacita dimaklumkan bahawa, Jabatan Pendaftar mempelawa kakitangan berstatus tetap yang belum disahkan dalam jawatan dan telah memenuhi kriteria Pengesahan Dalam Perkhidmatan untuk mengisi permohonan anda di sini. "
          .Html::a('<i class="fa fa-arrow-right"></i>', ['pengesahan/mohonpengesahan'], ['class'=>'btn btn-primary btn-sm']));
        }
    
      }
       Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi Berjaya Dihantar']);
    }
    
    protected function resetpegawai(){
        $model = Pengesahan::find()->where(['status' => 'DALAM TINDAKAN KETUA JABATAN'])->all();
        
        foreach($model as $models){
        if($models->status_jfpiu == 'Tunggu Perakuan'){
        $pegawai = Department::findOne(['id' => $models->kakitangan->DeptId]);
        
        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $models->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        $models->app_by = $pegawaisub->chief; //kj 
        }
        
        if($models->ver_by == ''){ //jika pemohon tiada ketua pentadiran
            $models->status_pp = '';
            $models->status ='DALAM TINDAKAN KETUA JABATAN'; 
            $petindak1='Ketua Jabatan';
            $icnopetindak1= $models->app_by;
            }
              
        $models->status_jfpiu = 'Tunggu Perakuan';
        $models->status_bsm = 'Tunggu Kelulusan';
        
        $models->save();
        //$this->notifikasi($icnopetindak1, "Permohonan pengesahan dalam perkhidmatan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['kontrak/menunggu'], ['class'=>'btn btn-primary btn-sm']));
         }
        
        elseif ($models->status == 'DALAM TINDAKAN KETUA JABATAN') {
            
        $pegawai = Department::findOne(['id' => $models->kakitangan->DeptId]);
        if($pegawai->sub_of == '' || $pegawai->sub_of == '12'){
        $models->app_by = $pegawai->chief; //kj 
        }
        else{
        $pegawaisub = Department::findOne(['id' => $pegawai->sub_of]);
        $models->app_by = $pegawaisub->chief; //kj 
        }
        
        $models->save();

        }   
    }
    }
    
    protected function notifipegawai(){
        $this->resetpegawai();
       // $app = Pengesahan::find()->where(['status' => 'DALAM TINDAKAN KETUA JABATAN'])->groupBy('app_by')->all();
            $app = Pengesahan::find()->where(['status' => 'DALAM TINDAKAN KETUA JABATAN'])->groupBy('app_by')->andWhere(['job_category' => '2'])->all();
        
        foreach($app as $a){
          $this->notifikasi($a->app_by, "Permohonan pengesahan dalam perkhidmatan menunggu tindakan anda. ".Html::a('<i class="fa fa-arrow-right"></i>', ['pengesahan/menunggu'], ['class'=>'btn btn-primary btn-sm']));  
        }
           
    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi Berjaya Dihantar']);
    }
    
    public function actionHalamanBelumMohonPentadbiran(){
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2'  ] )->exists()){
        return $this->render('halaman-belum-mohon-pentadbiran', [
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    //Senarai Kakitangan Pentadbiran Tetap yang Cukup Tempoh (Percubaan 1-3 Tahun)
    public function actionBelummohon(){
                
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2'  ] )->exists()){
        return $this->render('belummohon', [
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    //Senarai Kakitangan Pentadbiran Tetap yang Akan Cukup Tempoh
    public function actionBelummohon2(){
                
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => [1,2]] )->exists()){
        return $this->render('belummohon2', [
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
//    public function actionBelummohon3(){
//                
//        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => [1,2]] )->exists()){
//        return $this->render('belummohon3', [
//        ]);}
//        else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('index');}
//    }
    
//    Senarai Kakitangan Tetap yang Akan Cukup Tempoh 1 Tahun Dalam Percubaan Lanjutan Tanpa Denda/Dalam Percubaan Lanjutan Berdenda [Pentadbiran]
//    public function actionBelummohon4(){
//                
//        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => [1,2]] )->exists()){
//        return $this->render('belummohon4', [
//        ]);}
//        else{
//        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
//        return $this->redirect('index');}
//    }
    
    //Senarai Kakitangan Pentadbiran Tetap yang Telah Melebihi Tempoh Percubaan Maksimum (Melebihi Percubaan 3 Tahun)
    public function actionBelummohon5(){
                
        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2'  ] )->exists()){
        return $this->render('belummohon5', [
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionSenaraidokumen(){
        $model = TblSurat::find()->all();
        return $this->render('senaraidokumen', [
            'model' => $model,
        ]);
    }
        
    public function actionUploadsurat($id){
        $message = '';
        $model = $this->findModel($id);
        $dokumen = TblSurat::find()->where(['pengesahan_id' => $model->id])->one();
        if(!$dokumen){
            $dokumen = new TblSurat();
            $dokumen->tajuk = 'Surat Pengesahan';
        }
        $surat = $model->surat;
        if ($dokumen->load(Yii::$app->request->post())) {
            Yii::$app->FileManager->DeleteFile($surat);
            $file =  UploadedFile::getInstance($dokumen, 'file');
            if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'pengesahandalamperkhidmatan');
                $filepath = $fileapi->file_name_hashcode;   
                if($fileapi->status == true) {
                    $message = 'Saved';
                }
            }
            else{
                $filepath = '';
            }

            $dokumen->dokumen = $filepath;
            $dokumen->pengesahan_id = $model->id;
            $dokumen->save();
        }
        return $this->renderAjax('uploadsurat', [
           'dokumen' => $dokumen,
           'message' => $message
        ]); 
    } 
    
    // Muat Turun Senarai Pengesahan Yang Menunggu Tindakan
    public function actionReportpentadbiran(){
        $model = Pengesahan::find()->where(['job_category' => '2', 'status' => ['DALAM TINDAKAN KETUA JABATAN', 'DALAM TINDAKAN BSM']])->all();
        return $this->render('reportpentadbiran',['model' =>$model]
        ); 
    }
    
//    public function actionReportpentadbiran(){
//         $status = isset(Yii::$app->request->queryParams['status'])?Yii::$app->request->queryParams['status']:'';
//         if ($status != '') {
//             $model = Pengesahan::find()->where(['job_category' => '2', 'status_bsm' => $status])->all();   
//         } 
//         else{
//             $model = Pengesahan::find()->where(['job_category' => '2'])->all();
//         }
//        return $this->render('reportpentadbiran',['model' =>$model]
//        ); 
//    }
    
    // Muat Turun Senarai Pengesahan Yang Telah Diluluskan/Tidak Diluluskan
    public function actionReportpentadbiran2(){
        $model = Pengesahan::find()->where(['job_category' => '2', 'status' => ['LULUS', 'TIDAK LULUS']])->all();
        return $this->render('reportpentadbiran2',['model' =>$model]
        ); 
    }
    
    protected function findJumlahPermohonanAkademikSemasa(){
        return Pengesahan::find()->where(['job_category' => '1'])->count();
    }
    
    protected function findJumlahPermohonanAkademikBerjaya(){
        return Pengesahan::find()->where(['job_category' => '1', 'status' => 'LULUS'])->count();
    }
    
    protected function findJumlahPermohonanAkademikDitolak(){
        return Pengesahan::find()->where(['job_category' => '1', 'status' => 'TIDAK LULUS'])->count();
    }
    
    protected function findJumlahPermohonanPentadbiranSemasa(){
        return Pengesahan::find()->where(['job_category' => '2'])->count();
    }
    
    protected function findJumlahPermohonanPentadbiranBerjaya(){
        return Pengesahan::find()->where(['job_category' => '2', 'status' => 'LULUS'])->count();  
    }
    
    protected function findJumlahPermohonanPentadbiranDitolak(){
        return Pengesahan::find()->where(['job_category' => '2', 'status' => 'TIDAK LULUS'])->count();
    } 
    
//    public function actionLaporan( $tahun = null, $bulan = null) {
//       
//        $year = date('Y');
//        $month = date('m');
//       
//        if ($tahun != null) {
//            $year = $tahun;
//        }
//        if ($bulan != null) {
//            $month = $bulan;
//        } 
//         
//        $model = new Pengesahan();
//        
//        $query = Pengesahan::find() ->where(['MONTH(tarikh_m)' => $month])->andWhere(['YEAR(tarikh_m)' => $year])->orderBy(['tarikh_m' => SORT_ASC]);
//       
//        $dataProvider = new ActiveDataProvider([
//        'query' => $query, 
//        'pagination' => [
//        'pageSize' => 10,
//            ],
//        ]);
//        
//        return $this->render('laporan', ['tahun' => $year, 'bulan' => $month, 'dataProvider' => $dataProvider, 'model' => $model ]);
//    } 
    
    public function actionLaporan($carian_icno = null, $tahun = null, $bulan = null){
       
        $year = date('Y');
        $month = date('m');
        $carian = $carian_icno;
       
        $jumlah_permohonan_pentadbiran = $this->findJumlahPermohonanPentadbiranSemasa();
        $jumlah_permohonan_akademik = $this->findJumlahPermohonanAkademikSemasa();
        $jumlah_permohonan_pentadbiran_berjaya = $this->findJumlahPermohonanPentadbiranBerjaya();
        $jumlah_permohonan_pentadbiran_gagal = $this->findJumlahPermohonanPentadbiranDitolak();
        $jumlah_permohonan_akademik_berjaya = $this->findJumlahPermohonanAkademikBerjaya();
        $jumlah_permohonan_akademik_gagal = $this->findJumlahPermohonanAkademikDitolak();
        
        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $month = $bulan;
        } 
         
        $model = new Pengesahan();
        
//        $query = Pengesahan::find() ->where(['MONTH(tarikh_m)' => $month])->andWhere(['YEAR(tarikh_m)' => $year])->orderBy(['tarikh_m' => SORT_ASC]);
        
        if($bulan == 0 ){
//        $query =  Borang::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
            $query = Pengesahan::find() ->where(['YEAR(tarikh_m)' => $year])->orderBy(['tarikh_m' => SORT_ASC]);
        } 
        elseif($bulan != 0 && $carian == NULL){
//        $query =  Borang::find()->where(['MONTH(entry_date)' => $mth])->andWhere(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
            $query = Pengesahan::find() ->where(['MONTH(tarikh_m)' => $month])->andWhere(['YEAR(tarikh_m)' => $year])->orderBy(['tarikh_m' => SORT_ASC]);
        }
        else{
//        $query =  Borang::find()->where(['icno' => $carian_icno])->andWhere(['YEAR(entry_date)' => $year,'mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
            $query = Pengesahan::find()->where(['icno' => $carian_icno])->andWhere(['YEAR(tarikh_m)' => $year])->orderBy(['tarikh_m' => SORT_ASC]);

        }
        
        $dataProvider = new ActiveDataProvider([
        'query' => $query, 
        'pagination' => [
        'pageSize' => 30,
            ],
        ]);

        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId()] )->exists() || TblAhlimeeting::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
        return $this->render('laporan', [
            
            'tahun' => $year, 'bulan' => $month, 'dataProvider' => $dataProvider, 'model' => $model,

            'jumlah_permohonan_pentadbiran' => $jumlah_permohonan_pentadbiran,
            'jumlah_permohonan_akademik' => $jumlah_permohonan_akademik,
            'jumlah_permohonan_pentadbiran_berjaya' => $jumlah_permohonan_pentadbiran_berjaya,
            'jumlah_permohonan_pentadbiran_gagal' => $jumlah_permohonan_pentadbiran_gagal,
            'jumlah_permohonan_akademik_berjaya' => $jumlah_permohonan_akademik_berjaya,
            'jumlah_permohonan_akademik_gagal' => $jumlah_permohonan_akademik_gagal,
       ]);}
        
       else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
        
    } 
    
    public function actionLihatRekod($ICNO){
        $biodata = Tblprcobiodata::findOne(['ICNO'=>$ICNO]);  
        $tahunstarttetap = Tblprcobiodata::find()->where(['ICNO' => $ICNO])->min('YEAR(startdatelantik)');
        
        $subjekspm = Tblsubjek::findOne(['ICNO' => $ICNO, 'EduLevel_id' => '14', 'Subject_id' => '12']);
        $subjekspm2 = Tblsubjek::findOne(['ICNO' => $ICNO, 'EduLevel_id' => '23', 'Subject_id' => '12']);
        $subjekpmr = Tblsubjek::findOne(['ICNO' => $ICNO, 'EduLevel_id' => '15', 'Subject_id' => '260']);

        if(TblAdmin::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists() || TblAhlimeeting::find()->where( [ 'icno' => Yii::$app->user->getId(), 'category' => '2' ] )->exists()){
        return $this->render('lihat-rekod', [
                'biodata' => $biodata,
                'tahunstarttetap' => $tahunstarttetap,
                'subjekspm' => $subjekspm,
                'subjekspm2' => $subjekspm2,
                'subjekpmr' => $subjekpmr,


        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionPadam(){
        return Yii::$app->FileManager->DeleteFile('');//insert the code
    } 
}
