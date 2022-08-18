<?php

namespace app\controllers;

use Yii;
use app\models\kemudahan\Borangwilayah;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Kemudahan\Refpegawai;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblkeluarga;
use app\models\kemudahan\Reffamily;
use app\models\kemudahan\Refjadualpenerbangan;
use yii\helpers\ArrayHelper;
use app\models\kemudahan\Model;
use yii\helpers\Html;
use app\models\Notification;
use app\models\hronline\Department;
use yii\web\UploadedFile;
use app\models\kemudahan\TblAccess;
use app\models\Kemudahan\Kemudahan;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use DateTime;
use app\models\kemudahan\TblPayinstruct;
use app\models\kemudahan\TblPayInstructDetails; 
use app\models\kemudahan\Refpenerbangan;
use app\models\kemudahan\Refkadartanggungan;
use app\models\kemudahan\RefTempAccess;
use app\models\hronline\Negeri;
use app\models\kemudahan\BorangwilayahSearch;
use tebazil\runner\ConsoleCommandRunner;

/**
 * BorangwilayahController implements the CRUD actions for Borangwilayah model.
 */
class BorangwilayahController extends Controller
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
     * Lists all Borangwilayah models.
     * @return mixed
     */
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
        $dataProvider = new ActiveDataProvider([
            'query' => Borangwilayah::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    } 
       
    protected function findModel($id)
    {
        if (($model = Borangwilayah::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function ICNO() {
        return Yii::$app->user->getId();
    }
    
     protected function findBiodata($icno) {
        return Tblprcobiodata::findOne(['ICNO' => $icno]);
    } 
    
     public function actionMaklumatWilayah()
    {
  
        $icno = Yii::$app->user->getId(); 
        $peg_tadbir = TblAccess::findOne(['admin_post' => 1 ]); 
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]);
        $kakitangan = $this->findBiodata($this->icno()); 
        $model = new Borangwilayah(); 
        $model->icno = $icno; 
        $queryKeluarga = $this->findRekodKeluarga($kakitangan);
        $depart = Refpenerbangan::find()->where(['isActive' => 1])->all();
        $arrival = Refpenerbangan::find()->where(['flightType' => 2])->andwhere(['isActive' => 1])->all();
        $modelCustomer = new Borangwilayah(); 
        $mod = Borangwilayah::find()->where(['icno' => $model->icno])->andWhere(['mohon' => 1 ])->orderBy(['entry_date' => SORT_DESC])->one();
        $wilayahCount = Borangwilayah::find()->where(['icno' => $model->icno])->count();
 
        //tutup permohonan based on tarikh
        $currentDt = date('Y-m-d');
        $checkOpen = Kemudahan::find()->where(['or', "endDate <= '$currentDt'", "startDate > '$currentDt'"])->andwhere(['jeniskemudahan' => 7])->one(); 
        $aksesTempoh = RefTempAccess::find()->where(['icno' => $icno])->andWhere(['isActive' => 2, 'facility' => 7])->one(); 
        if($checkOpen && !$aksesTempoh){ //akses permohonan lebih tempoh
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => $checkOpen->reason]);
           
            return $this->redirect(['kemudahan/index']);
        }
  
        $check = Tblprcobiodata::find()->where(['ICNO' => $icno])->andWhere(['isSabahan' => 1, 'campus_id' => [1]])->exists();  
        $akses = RefTempAccess::find()->where(['icno' => $icno])->andWhere(['isActive' => 1, 'facility' => 7])->one(); //tbl access yg menggunakan kelayakan ibu bapa
        $admin = TblAccess::find()->where(['icno' => $icno])->andWhere(['admin_post' => [1,2], 'isActive' => 1])->one();
         if($check && !$akses && !$admin){ // bagi akses untuk mohon berdasarkan criteria
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses kepada submodul ini. Sila berhubung dengan Bahagian Sumber Manusia, Jabatan Pendaftar.']);
            return $this->redirect(['borang/senarai']); 
        } 
        $checkApplication = Borangwilayah::find()->where(['status_semasa' => 0,'icno' => $icno]);
        if($checkApplication->exists()){ //check permohonan masih dalam proses
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['borang/senarai']);
        }

        $checkApmt = $this->findBiodata($this->ICNO()); 
        if($checkApmt->statLantikan != 1 ){//check akses staf tetap
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan ini hanya layak dipohon bagi kakitangan berstatus tetap sahaja.']);
            return $this->redirect(['kemudahan/index']);
        } 
        $modelsAddress = [new Reffamily()]; 
        $modelsPenerbangan = [new Refjadualpenerbangan()]; 

         
        if ($modelCustomer->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) { 
            
            $date1 = new DateTime($model->tarikh_digunakan);

            $date2 = new DateTime("now");
            $tempoh = date_diff($date1, $date2)->format('%a Hari'); 

            if (($tempoh <= 28) || ($tempoh == 0)){
                
                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan hendaklah dikemukakan 30 hari bekerja daripada tarikh cadangan kemudahan hendak digunakan.']);
                return $this->redirect(['borangwilayah/maklumat-wilayah']);
             }
 
//            $currentDt = date('Y-m-d');
//            $checkEx = Borangwilayah::find()->where(['or', "tarikh_digunakan >= '$currentDt'"])->andwhere(['icno' => $icno, 'status_kj' => 'DILULUSKAN'])->one();
//
//            if($checkEx){  
//                 Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Kemudahan ini hanya boleh digunakan sekali dalam tempoh satu (1) tahun perkhidmatan.']);
//
//                return $this->redirect(['borang/sejarahpermohonan']);
//            } 
            
            $ntf = new Notification();
            $ntf2 = new Notification();  
            
            $file = UploadedFile::getInstance($modelCustomer, 'dokumen_sokongan');
            $file2 = UploadedFile::getInstance($modelCustomer, 'dokumen_sokongan2');
            
            $modelsAddress = Model::createMultiple(Reffamily::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());

            $modelsPenerbangan = Model::createMultiple(Refjadualpenerbangan::classname(), $modelsPenerbangan);
            Model::loadMultiple($modelsPenerbangan, Yii::$app->request->post());
        
            if($file2){
                    $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'resit_tiket');
                    $filepath2 = $fileapi->file_name_hashcode;   
            }
            else{
                $filepath2 = '';
            }
             
            $modelCustomer->dokumen_sokongan2 = $filepath2;
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                    ActiveForm::validateMultiple($modelsPenerbangan),
                    ActiveForm::validate($modelCustomer)
                );
            }
           
             
            // validate all models
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            $valid = Model::validateMultiple($modelsPenerbangan) && $valid;
            
            $modelCustomer->icno = $icno;
            $modelCustomer->entry_date = date('Y-m-d H:i:s');
            $modelCustomer->jeniskemudahan = 7;
            $modelCustomer->status_pt = 'MENUNGGU TINDAKAN';
            $modelCustomer->status_pp = 'MENUNGGU TINDAKAN';
            $modelCustomer->status_kj = 'NEW';
            $modelCustomer->status_semasa = '0'; 
            $modelCustomer->pengakuan = '1'; 
            $modelCustomer->wilayah_asal = $kakitangan->displayTempatLahir; 
            $modelCustomer->semakan_by = $peg_tadbir->icno;
            $modelCustomer->peraku_by = $peg_bsm->icno;
            $modelCustomer->entry_type = 1;
            $modelCustomer->nama = $kakitangan->CONm;
            
            $userExist = Borangwilayah::find()->where(['mohon' => 1, 'status_kj' => null])->andwhere(['icno' => $icno])->one();
            $usExist = Borangwilayah::find()->where(['isActive' => 1, 'status_kj' =>'DILULUSKAN'])->andwhere(['mohon' => 1, 'icno' => $icno])->one();

            if($usExist  || $userExist){
                $modelCustomer->letter_type = 2;
            }else{
                $modelCustomer->letter_type = 1;
            }
             
  
             
             if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                         
                        foreach ($modelsAddress as $modelAddress) { 
                            
                        $data = Tblkeluarga::find()->where(['AND',['ICNO' => $this->icno()], ['FamilyId' => $modelAddress->icno]])->one(); 

                            $modelAddress->ref_icno = $modelCustomer->icno;
                            $modelAddress->parent_id = $modelCustomer->id;
                            $modelAddress->entry_date = date('Y-m-d H:i:s');
                            $modelAddress->idkemudahan = '7';  
                            $modelAddress->tarikh_lahir = $data->FmyBirthDt;
                            $modelAddress->hubungan = $data->hubkeluarga;  
                            $modelAddress->nama = $data->FmyNm;
                             
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            } 
                        }
                    }
                     if ($flag = $modelCustomer->save(false)) {
                       
                        foreach ($modelsPenerbangan as $i => $modelPenerbangan) { 
                       
                            $modelPenerbangan->ref_icno = $modelCustomer->icno;
                            $modelPenerbangan->parent_id = $modelCustomer->id;
                            $modelPenerbangan->entry_date = date('Y-m-d H:i:s');
                            $modelPenerbangan->jeniskemudahan = '7';
                            
                            $dt1 = new DateTime($modelPenerbangan->tarikh_berlepas);

                            $dt2 = new DateTime("now");
                            $days = date_diff($dt1, $dt2)->format('%a Hari'); 

                            if (($days <= 28) || ($days == 0)){

                                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan hendaklah dikemukakan 30 hari bekerja daripada tarikh cadangan kemudahan hendak digunakan.']);
                                return $this->redirect(['borangwilayah/maklumat-wilayah']);
                             }
                            
                            if (! ($flag = $modelPenerbangan->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        
                        }
                    }
                       $ntf->icno = $peg_tadbir->icno; // peg  penyelia perjawatan
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan Tambang Wilayah Asal menunggu tindakan semakan anda, Terima kasih.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangwilayah/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                          
                         
                     $ntf2->icno = $peg_bsm->icno; // peg perjawatan
                            $ntf2->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf2->content = "Permohonan Kemudahan Tambang Wilayah Asal menunggu tindakan perakuan anda, Terima kasih.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangwilayah/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf2->ntf_dt = date('Y-m-d H:i:s');
                            $ntf2->save();
                                       
                    $this->pendingtask($peg_tadbir->icno, 64);         
                    $this->notification($model->icno, 'Permohonan anda telah dihantar untuk diproses sila semak status permohonan anda, Terima kasih.'.Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
                 
                    if ($flag) {
                        $transaction->commit();
                         return $this->redirect(['borang/senarai']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
                $model->save(false);
                $modelCustomer->save(false);
            }  
        }

       
        return $this->render('form_wilayah', [
            'model' => $model, 
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new Reffamily()] : $modelsAddress,
            'modelsPenerbangan' => (empty($modelsPenerbangan)) ? [new Refjadualpenerbangan] : $modelsPenerbangan,
            'queryKeluarga' => $queryKeluarga,
            'kakitangan' => $kakitangan, 
            'mod' => $mod, 
            'depart' => $depart,
            'arrival' => $arrival,
            'wilayahCount' => $wilayahCount,
        ]);
    }
    
    public function findRekodKeluarga($kakitangan) {

        if ($kakitangan->MrtlStatusCd == 0) { //Status Tiada Maklumat
            $family = Tblkeluarga::find()->where(['ICNO' => null]) ->andwhere(['IN', 'tblprfmy.RelCd', ['01', '02', '05', '06', '15']]) ->all(); // dummy
            
        } else if ($kakitangan->MrtlStatusCd == 1) { // Belum berkahwin
            $family = Tblkeluarga::find()->where(['ICNO' => $kakitangan->ICNO]) ->andwhere(['IN', 'tblprfmy.RelCd', ['01', '02', '05', '06', '07', '15']]) ->joinWith('hubunganKeluarga')->all();
           
        } else {
            $family = Tblkeluarga::find()->where(['ICNO' => $kakitangan->ICNO])  ->andWhere('tblprfmy.RelCd in (05,06,07,15) and ((DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(FmyBirthDt)), "%Y")+0) < 21) or tblprfmy.RelCd in (01,02)')->joinWith('hubunganKeluarga')->all();
                        
        }

        return $family;
    }
    
    public function actionSenaraitindakan()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
       
        $model = new Borangwilayah();
        $status = ['NEW', 'DILULUSKAN', 'MENUNGGU TINDAKAN', 'TIDAK DILULUSKAN'];
       
        if(Refpegawai::find()->where( ['pembantu_tadbir' => $icno] )->exists()){
            
            $senarai = Borangwilayah::find()->where(['in', 'status_kj', $status])->andWhere(['jeniskemudahan' => 7, 'pengakuan' => 1])->orderBy(['entry_date' => SORT_DESC]);
            $title='Senarai Menunggu Semakan'; 
        }
        elseif(Refpegawai::find()->where( ['pegawai_bsm' => $icno] )->exists()){
            
            $senarai = Borangwilayah::find()->where(['in', 'status_kj', $status])->andWhere(['jeniskemudahan' => 7])->orderBy(['entry_date' => SORT_DESC]);
            $title ='Senarai Menunggu Perakuan';
            
        }
        elseif(Department::find()->where(['chief' => $icno, 'id' => '158'])->exists()){
            
            $senarai = Borangwilayah::find()->where(['in', 'status_kj', $status])->andWhere(['jeniskemudahan' => 7])->orderBy(['entry_date' => SORT_DESC]);
            $title ='Senarai Menunggu Kelulusan';
            
        } 
         
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
           
        isset(Yii::$app->request->queryParams['nama'])? $senarais->query->andFilterWhere
        (['like', 'nama',  Yii::$app->request->queryParams['nama'] ]):'';
        
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
    
    public function actionSemakan_pt($id)
    {
        $icno = Yii::$app->user->getId(); 
        $model = $this->findModel($id);
       
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]);
        $query = Borangwilayah::find()->where(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        $keluarga = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'idkemudahan' =>  '7'])->all();
        $planes = Refjadualpenerbangan::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' =>  '7'])->all(); 
        $mod = Borangwilayah::find()->where(['<', 'id', $model->id])->andWhere(['icno' => $model->icno, 'mohon' => 1 ])->orderBy(['id' => SORT_DESC])->one(); 
        $kadar = Refkadartanggungan::find()->where(['icno' => $model->icno])->one();
        
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
            
            }elseif(!$kadar){
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Penetapan kadar kelayakan perlu dilakukan terlebih dahulu.']); 
                 return $this->redirect(['kemudahan/tanggungan']);
            }
            else{
                       
            $model->semakan_by = $icno;                                      
            $model->save(false); 
            $this->pendingtask($peg_bsm->icno, 65);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
            return $this->redirect(['borangwilayah/senaraitindakan']);
            }
        }
        return $this->render('semakan_pt', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'keluarga' => $keluarga,
            'planes' => $planes,
            'mod' => $mod,
            'kadar' => $kadar,
        ]); 
    }
    
    public function actionTindakan_bsm($id)
    {
        $icno = Yii::$app->user->getId();
         
        $model = $this->findModel($id);
        $chief = Department::findOne(['id' => '158']); 
        $query = Borangwilayah::find()->where(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        $keluarga = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'idkemudahan' => '7'])->all();  
        $planes = Refjadualpenerbangan::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' => '7'])->all(); 
        $mod = Borangwilayah::find()->where(['<', 'id', $model->id])->andWhere(['icno' => $model->icno, 'mohon' => 1 ])->orderBy(['id' => SORT_DESC])->one(); 
        $kadar = Refkadartanggungan::find()->where(['icno' => $model->icno])->one();

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
            
           $ntf->icno =  $chief->chief; // Tindakan Kj
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan Tambang Wilayah Asal menunggu tindakan Kelulusan anda, Terima kasih.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangwilayah/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save(); 
                      
           $model->peraku_by = $icno;     
           $model->pelulus_by = $chief->chief;
           $model->save(false); 
           $this->pendingtask($chief->chief, 66);
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
           return $this->redirect(['borangwilayah/senaraitindakan']);
            }
        }
        return $this->render('tindakan_bsm', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'keluarga' => $keluarga,
            'planes' => $planes,
            'mod' => $mod,
            'kadar' => $kadar,
        ]); 
    }
    
    public function actionTindakan_kj($id)
    {
        $icno = Yii::$app->user->getId();           
        $model = $this->findModel($id);
        $chief = Department::find()->where(['chief' => $icno, 'id' => '158'])->exists(); 
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]); 
 
        $query = Borangwilayah::find()->where(['mohon' => 1])->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        $keluarga = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'idkemudahan' => '7'])->all();  
        $planes = Refjadualpenerbangan::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' => '7'])->all(); 
        $mod = Borangwilayah::find()->where(['<', 'id', $model->id])->andWhere(['icno' => $model->icno, 'mohon' => 1 ])->orderBy(['id' => SORT_DESC])->one(); 
        $kadar = Refkadartanggungan::find()->where(['icno' => $model->icno])->one();

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
 
        
        $model->isActive = '2'; 
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
           $model->status_tempahan = 'TIDAK DILULUSKAN';
           
           $ntf->icno = $model->icno;// peg  penyelia perjawatan
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan Tambang Wilayah Asal anda tidak diluluskan.".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save(); 
                             
           $model->pelulus_by = $icno;                                                   
           $model->save(false);
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
           return $this->redirect(['borangwilayah/senaraitindakan']);
           }
           else{
            $ntf2 = new Notification();

            $ntf2->icno = $peg_bsm->icno; // pemohon
            $ntf2->title = 'Permohonan Kemudahan Atas Talian';
            $ntf2->content = "Permohonan Kemudahan Tambang Wilayah Asal telah diluluskan oleh Ketua BSM kini menunggu tindakan daripada anda, Terima kasih.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangwilayah/senaraiberjaya'], ['class'=>'btn btn-primary btn-sm']);
            $ntf2->ntf_dt = date('Y-m-d H:i:s');
            $ntf2->save();     
            
            $model->pelulus_by = $icno;    
            $model->save(false);
            $this->pendingtask($peg_bsm->icno,67);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
            return $this->redirect(['borangwilayah/senaraitindakan']);
           }
        }
        
        return $this->render('tindakan_kj', [
            'model' => $model,
            'keluarga' => $keluarga,
            'planes' => $planes,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'mod' => $mod,
            'kadar' => $kadar,
        ]);
    }
    
    public function actionSenaraiberjaya()
    {
       
        $model = new Borangwilayah();
        $model->icno = Yii::$app->user->getId();
       
        $peg_bendahari = TblAccess::findOne(['admin_post' => 4]);
        $peg_tadbir = TblAccess::findOne(['admin_post' => 8]);
  
        $status = ['DILULUSKAN']; 
        $models = Borangwilayah::find()->All();
        $query = Borangwilayah::find()->where([ 'status_kj' => $status, 'jeniskemudahan' => 7]) ->andWhere(['isActive' => 2]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
        $selection=(array)Yii::$app->request->post('selection');//typecasting 
            if (Yii::$app->request->post('simpan')){
                
                $ntf = new Notification();
                $ntf2 = new Notification();
                
                foreach ($selection as $id) {
                    $model = $this->findModel($id);
                  
                    if('y'.$id == Yii::$app->request->post($id)){
                    $model->isActive ='1';
                    $model->stat_bendahari = 'DALAM PROSES BAYARAN'; 
                    $model->tarikh_hantar = date('Y-m-d H:i:s');   
                    $model->status_semasa = '1';
                    $model->mohon = '1';
                    $model->book_by = $peg_tadbir->icno; 
                    $model->status_tempahan = 'NEW'; 
                   
                    
                            $ntf->icno = $peg_bendahari->icno; // notification kpd bendahari
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan Tambang Wilayah Asal menunggu tindakan anda untuk diproses, Terima Kasih.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangwilayah/senaraibendahari'], ['class'=>'btn btn-primary btn-sm']);;
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                            
                            $ntf2->icno = $peg_tadbir->icno; // notification kpd bendahari
                            $ntf2->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf2->content = "Permohonan Kemudahan Tambang Wilayah Asal menunggu tindakan tempahan tiket daripada anda. Terima kasih.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangwilayah/senaraipentadbiran'], ['class'=>'btn btn-primary btn-sm']);;
                            $ntf2->ntf_dt = date('Y-m-d H:i:s');
                            $ntf2->save();
                     
                    $this->pendingtask($peg_tadbir->icno,68);
                    $this->notification($model->icno, "Permohonan anda telah diluluskan. Tiket penerbangan Tuan/Puan akan diemel dalam tempoh 14 hari dari tarikh kelulusan, Terima Kasih."." ".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));
                    $model->save(false);
                    
                    }
                    elseif('n'.$id == Yii::$app->request->post($id)){
                    $model = $this->findModel($id);
                    $model->isActive ='2';
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
        $model = Borangwilayah::find()->where(['in', 'status_kj', $status])->andWhere(['isActive' => 1, 'jeniskemudahan' => 7])->orderBy(['entry_date' => SORT_DESC])->All();
   
        return $this->render('senarai_bendahari', [
            'model' => $model, 
            'bil' => 1,
        ]);
        
    }
    
    public function actionTindakan_bendahari($id)
    {
        $icno = Yii::$app->user->getId();           
        $model = $this->findModel($id);
          
        $query = Borangwilayah::find()->where(['mohon' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        $keluarga = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'idkemudahan' => '7'])->all();  
        $planes = Refjadualpenerbangan::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' => '7'])->all(); 
        $mod = Borangwilayah::find()->where(['<', 'id', $model->id])->andWhere(['icno' => $model->icno, 'mohon' => 1 ])->orderBy(['id' => SORT_DESC])->one(); 

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        
        return $this->render('tindakan_bendahari', [
            'model' => $model,
            'keluarga' => $keluarga,
            'planes' => $planes,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'mod' => $mod,
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
        $model = new Borangwilayah();
       
        if($bulan == 0 ){
         $query =  Borangwilayah::find()->where(['YEAR(tarikh_digunakan)' => $year])->andWhere(['status_tempahan' => 'TELAH DITEMPAH', 'isActive' => 1])->orderBy(['tarikh_digunakan' => SORT_ASC]);
           
        }else{
            $query =  Borangwilayah::find()->where(['MONTH(tarikh_digunakan)' => $mth])->andWhere(['YEAR(tarikh_digunakan)' => $year])->andWhere(['status_tempahan' => 'TELAH DITEMPAH', 'isActive' => 1])->orderBy(['tarikh_digunakan' => SORT_ASC]);
        
        }
        $sum = $query->sum('jumlah');
//        $statistik = Borangwilayah::find()->select(new \yii\db\Expression("MONTH(`entry_date`) AS BULAN, COUNT(`id`) AS TOTAL"))->where(['YEAR(entry_date)' => $year, 'mohon' => 1])->groupBy('MONTH(`entry_date`)')->asArray()->all();
        $statistik = Borangwilayah::find()->select(new \yii\db\Expression("MONTH(`tarikh_digunakan`) AS BULAN, SUM(`jumlah`) AS JUMLAH"))->where(['YEAR(tarikh_digunakan)' => $year])->andWhere(['status_tempahan' => 'TELAH DITEMPAH', 'isActive' => 1])->groupBy('MONTH(`tarikh_digunakan`)')->asArray()->all();

        $label = ArrayHelper::getColumn($statistik, 'BULAN');
//        $data = ArrayHelper::getColumn($statistik, 'TOTAL');
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
       
       $model = new Borangwilayah();

        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $mth = $bulan;
        } 
        
        if($bulan == 0){
        $model = Borangwilayah::find() ->where(['YEAR(tarikh_digunakan)' => $year])->andWhere(['status_tempahan' => 'TELAH DITEMPAH', 'isActive' => 1])->orderBy(['entry_date' => SORT_ASC])->all();
       
        }else{
        $model = Borangwilayah::find() ->where(['YEAR(tarikh_digunakan)' => $year])->andWhere(['MONTH(tarikh_digunakan)' => $mth])->andWhere(['status_tempahan' => 'TELAH DITEMPAH', 'isActive' => 1])->orderBy(['entry_date' => SORT_ASC])->all();
      
        }
        

        return $this->render('reportpentadbiran', [
            'tahun' => $year,
            'bulan' => $mth, 
            'model' => $model, 
        ]);
    }  
    public function actionSlulus($id)
        {   
            $css = file_get_contents('./css/kelulusan.css');
            #cehck application
            $model = $this->findModel($id); 
            $facility = Borangwilayah::find()->where(['icno' => $model])->andWhere(['id' =>  $id])->one(); 
            $kadar = Refkadartanggungan::find()->where(['icno' => $model->icno])->one();
            $mod = Borangwilayah::find()->where(['<', 'id', $model->id])->andWhere(['icno' => $model->icno, 'mohon' => 1 ])->orderBy(['id' => SORT_DESC])->one(); 
            $keluarga = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'idkemudahan' => '7'])->all();  
            $fmy = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'idkemudahan' => '7']);  
            $planes = Refjadualpenerbangan::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' => 7])->all();
     //     get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('slulus', ['facility' => $facility, 'keluarga' => $keluarga, 'kadar' => $kadar,'fmy' => $fmy,'planes' => $planes,'bil' => 1, 'mod' => $mod]);
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
        
        public function actionNewEntry()
    { 
       
        $peg_tadbir = TblAccess::findOne(['admin_post' => 1 ]);
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]);
        $kakitangan = $this->findBiodata($this->icno()); 
        $model = new Borangwilayah();   
        $queryKeluarga = $this->findRekodKeluarga($kakitangan);
        $modelCustomer = new Borangwilayah(); 
        $mod = Borangwilayah::find()->where(['icno' => $model->icno])->andWhere(['mohon' => 1 ])->orderBy(['entry_date' => SORT_DESC])->one();
      
        $modelsAddress = [new Reffamily()]; 
        $modelsPenerbangan = [new Refjadualpenerbangan()]; 

         
        if ($modelCustomer->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
             
            $staff = $this->findBiodata($modelCustomer->icno);  
            
            $file = UploadedFile::getInstance($modelCustomer, 'dokumen_sokongan');
            $file2 = UploadedFile::getInstance($modelCustomer, 'dokumen_sokongan2');
            
            $modelsAddress = Model::createMultiple(Reffamily::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());

            $modelsPenerbangan = Model::createMultiple(Refjadualpenerbangan::classname(), $modelsPenerbangan);
            Model::loadMultiple($modelsPenerbangan, Yii::$app->request->post());
            
            if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'resit_tiket');
                $filepath = $fileapi->file_name_hashcode;      
            }
            else{
                $filepath = '';
            }
            if($file2){
                    $fileapi = Yii::$app->FileManager->UploadFile($file2->name, $file2->tempName, '04', 'sijil_kematian');
                    $filepath2 = $fileapi->file_name_hashcode;   
            }
            else{
                $filepath2 = '';
            }
            
            $modelCustomer->dokumen_sokongan = $filepath;
            $modelCustomer->dokumen_sokongan2 = $filepath2;
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                    ActiveForm::validateMultiple($modelsPenerbangan),
                    ActiveForm::validate($modelCustomer)
                );
            }
           
             
            // validate all models
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            $valid = Model::validateMultiple($modelsPenerbangan) && $valid;
             
            $modelCustomer->entry_date = date('Y-m-d H:i:s');
            $modelCustomer->jeniskemudahan = 7; 
            $modelCustomer->status_kj = 'NEW'; 
            $modelCustomer->status_semasa = '0';   
            $modelCustomer->entry_type = 2; 
            $modelCustomer->status_pt = 'MENUNGGU TINDAKAN';    
            $modelCustomer->status_pp = 'MENUNGGU TINDAKAN';            
            $modelCustomer->pengakuan = 1;
            $modelCustomer->nama = $staff->CONm; 
            $modelCustomer->semakan_by = $peg_tadbir->icno;
            $modelCustomer->peraku_by = $peg_bsm->icno;
            
         

            $userExist = Borangwilayah::find()->where(['mohon' => 1, 'status_kj' => null])->andwhere(['icno' => $modelCustomer->icno])->one();
            $usExist = Borangwilayah::find()->where(['isActive' => 1, 'status_kj' =>'DILULUSKAN'])->andwhere(['mohon' => 1, 'icno' => $modelCustomer->icno])->one();

            if($usExist  || $userExist){
                $modelCustomer->letter_type = 2;
            }else{
                $modelCustomer->letter_type = 1;
            }
            
             if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                         
                        foreach ($modelsAddress as $modelAddress) { 
                         
                            $modelAddress->ref_icno = $modelCustomer->icno;
                            $modelAddress->parent_id = $modelCustomer->id;
                            $modelAddress->entry_date = date('Y-m-d H:i:s');
                            $modelAddress->idkemudahan = '7';   

                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            } 
                        }
                    }
                     if ($flag = $modelCustomer->save(false)) {
                       
                        foreach ($modelsPenerbangan as $i => $modelPenerbangan) { 
                       
                            $modelPenerbangan->ref_icno = $modelCustomer->icno;
                            $modelPenerbangan->parent_id = $modelCustomer->id;
                            $modelPenerbangan->entry_date = date('Y-m-d H:i:s');
                            $modelPenerbangan->jeniskemudahan = '7';
                            if (! ($flag = $modelPenerbangan->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        
                        }
                    } 
                            
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
                 
                    if ($flag) {
                        $transaction->commit();
                         return $this->redirect(['borangwilayah/new-entry']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
                $model->save(false);
                $modelCustomer->save(false);
            }  
        }


        return $this->render('new_entry', [
            'model' => $model, 
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new Reffamily()] : $modelsAddress,
            'modelsPenerbangan' => (empty($modelsPenerbangan)) ? [new Refjadualpenerbangan] : $modelsPenerbangan,
            'queryKeluarga' => $queryKeluarga,
            'kakitangan' => $kakitangan, 
            'mod' => $mod,
            
        ]); 
        
    }
     public function actionPadam(){
        return Yii::$app->FileManager->DeleteFile('');//insert the code 
    } 
     public function actionLetter2($id)
        {  
            $css = file_get_contents('./css/esurat.css');
            #cehck application
//            $model = $this->findModel($id);
            $icno = Yii::$app->user->getId();  
            $facility = Borangwilayah::find()->where(['icno' => $icno])->andWhere(['id' =>  $id])->one(); 
            $flight = Refjadualpenerbangan::find()->where(['ref_icno' => $icno])->andwhere(['parent_id' => $id])->one();
            $content = $this->renderPartial('letter2', ['facility'=> $facility, 'flight' => $flight]);
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
                  'marginTop' => 40,
                 'marginBottom' => 40,
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
        public function actionLetter($id)
        {  
            $css = file_get_contents('./css/esurat.css');
            #cehck application
            $model = $this->findModel($id);
            $icno = Yii::$app->user->getId();  
            $kadar = Refkadartanggungan::find()->where(['icno' => $model->icno])->one();
            $facility = Borangwilayah::find()->where(['icno' => $icno])->andWhere(['id' =>  $id])->one(); 
            $flight = Refjadualpenerbangan::find()->where(['ref_icno' => $icno])->andwhere(['parent_id' => $id])->one();
            $content = $this->renderPartial('letter', ['facility'=> $facility, 'flight' => $flight, 'kadar' => $kadar]);
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
        
         public function actionSenaraipentadbiran()
    {
       
        $icno = Yii::$app->user->getId();
         
        $status = ['DILULUSKAN'];
        $query = Borangwilayah::find()->where(['in', 'status_kj', $status])->andWhere(['isActive' => 1, 'jeniskemudahan' => 7])->orderBy(['entry_date' => SORT_DESC]);
   
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        isset(Yii::$app->request->queryParams['nama'])? $DataProvider->query->andFilterWhere
        (['like', 'nama',  Yii::$app->request->queryParams['nama'] ]):'';

        return $this->render('senarai_pentadbiran', [ 
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
        
    }
    public function actionTempahan($id)
    {  
        $model = $this->findModel($id);
          
        $query = Borangwilayah::find()->where(['mohon' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        $keluarga = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'idkemudahan' => '7'])->all();  
        $planes = Refjadualpenerbangan::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' => '7'])->all(); 
        $mod = Borangwilayah::find()->where(['<', 'id', $model->id])->andWhere(['icno' => $model->icno, 'mohon' => 1 ])->orderBy(['id' => SORT_DESC])->one(); 

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        
        return $this->render('tempahan', [
            'model' => $model,
            'keluarga' => $keluarga,
            'planes' => $planes,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'mod' => $mod,
        ]);
    }
    
  public function actionStatus_tempahan($id)
    {
        $icno = Yii::$app->user->getId(); 
        $model = $this->findModel($id);
        $pay = new TblPayinstruct();
        $infoPay = new TblPayInstructDetails(); 
        
        $query = Borangwilayah::find()->where(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        $keluarga = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'idkemudahan' =>  '7'])->all();
        $planes = Refjadualpenerbangan::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' =>  '7'])->all(); 
        $mod = Borangwilayah::find()->where(['<', 'id', $model->id])->andWhere(['icno' => $model->icno, 'mohon' => 1 ])->orderBy(['id' => SORT_DESC])->one(); 

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
         
        if ($model->load(Yii::$app->request->post())) {
            if($model->status_tempahan == ''){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }
                else{
            $infoPay->icno =  $model->icno;
            $infoPay->elaun_kemudahan = $model->jeniskemudahan ; 
            $infoPay->from = $model->entry_date;
            $infoPay->until = $model->entry_date;
            $infoPay->jenis_kiraan = 'FIXED';
            $infoPay->parent_id = $model->id;
            $infoPay->approver_status = $model->status_kj;
            $infoPay->approver_date = $model->app_date;
            $infoPay->approver_remark = $model->catatan_kj; 
            $infoPay->entry_type = $model->entry_type;
            $infoPay->jumlah = $model->jumlah; 

            $pay->PAY_STAFF_ICNO =  $model->icno;  
            $pay->PAY_DATE_FROM = $model->entry_date;
            $pay->PAY_DATE_TO = $model->entry_date; 
            $pay->PAY_REF_ID = $model->id;
            $pay->PAY_ENTRY_TYPE = $model->entry_type;
            $pay->PAY_PARENT_ID = $model->id;
            $pay->PAY_ELAUN_ID = $model->jeniskemudahan; 
            $pay->PAY_NEW_VALUE = $model->jumlah;       

            $model->dt_confrm = date('Y-m-d H:i:s');
            $model->book_by = $icno;
            $model->save(false); 
            $infoPay->save(false);
            $pay->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
            return $this->redirect(['borangwilayah/senaraipentadbiran']);
            }
        } 
        
        return $this->render('status_tempahan', [
            'model' => $model,
            'keluarga' => $keluarga,
            'planes' => $planes,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'mod' => $mod,
            'infoPay' => $infoPay,
            'pay' => $pay,
        ]);
    }
    public function actionPentadbiran($id)
    {
        $icno = Yii::$app->user->getId();           
        $model = $this->findModel($id);
          
        $query = Borangwilayah::find()->where(['mohon' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        $keluarga = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'idkemudahan' => '7'])->all();  
        $planes = Refjadualpenerbangan::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' => '7'])->all(); 
        $mod = Borangwilayah::find()->where(['<', 'id', $model->id])->andWhere(['icno' => $model->icno, 'mohon' => 1 ])->orderBy(['id' => SORT_DESC])->one(); 
        $kadar = Refkadartanggungan::find()->where(['icno' => $model->icno])->one();

        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
        
        return $this->render('pentadbiran', [
            'model' => $model,
            'keluarga' => $keluarga,
            'planes' => $planes,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'mod' => $mod,
            'kadar' => $kadar,
        ]);
    }
     public function actionKemaskiniPenerbangan($id)
    { 
        
        $icno = Yii::$app->user->getId();           
        $model = $this->findModel($id);  
        $model = Refjadualpenerbangan::find()->where(['parent_id' => $id])->andwhere(['ref_icno' => $model->icno])->one();
        $depart = Refpenerbangan::find()->where(['isActive' => 1])->all();

         
        if ($model->load(Yii::$app->request->post())) { 
           
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['borangwilayah/senaraitindakan']);
        }
        return $this->render('kemaskini_penerbangan', [
            'model' => $model, 
            'bil' => 1,
            'depart' => $depart,
        ]);
       
      
    }
    
     public function actionSenarai()
    {
        $icno = Yii::$app->user->getId();
       
        $model = new Borangwilayah();
//        $model = Borangwilayah::find()->where(['in', 'status_kj', $status])->andWhere(['isActive' => 1, 'jeniskemudahan' => 7])->orderBy(['entry_date' => SORT_DESC])->All();

        $status = ['NEW', 'DILULUSKAN', 'MENUNGGU TINDAKAN', 'TIDAK DILULUSKAN']; 
     
        $query = Borangwilayah::find()->where(['icno' => $icno, 'status_kj' => $status])->andWhere([ 'isActive' => 1])->orderBy(['entry_date' => SORT_DESC]);

        $wilayahCount = Borangwilayah::find()->where(['icno' => $model->icno])->andWhere(['mohon' => 1])->all();    
        $count = count($wilayahCount);
        
       
        $exst = Borangwilayah::find()->where(['icno' => $icno])->andWhere(['letter_type' => 1])->one();
 
            $dataProvider = new ActiveDataProvider([
                'query' => $query,              
            ]);
  
         return $this->render('senarai', [
            'model' => $model, 
            'dataProvider' => $dataProvider, 
            'bil' => 1,
            'wilayahCount' => $wilayahCount,
            'exst' => $exst,
            'count' => $count,
        ]);
    } 
    
     public function actionKemaskiniTempahan($id)
    { 
        
        
        $model = $this->findModel($id);  
        $query = Borangwilayah::find()->where(['id' => $id])->one();
 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
      
        if ($model->load(Yii::$app->request->post())) { 
           
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['borangwilayah/senaraipentadbiran']);
        }
        return $this->render('kemaskini_tempahan', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
        
    }
    
     protected function pendingtask($icno, $id){
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }
}
