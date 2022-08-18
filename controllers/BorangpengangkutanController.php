<?php

namespace app\controllers;

use Yii;
use app\models\kemudahan\Borangpengangkutan;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\Tblprcobiodata;
use app\models\Kemudahan\Refpegawai;
use app\models\hronline\Tblkeluarga;
use app\models\kemudahan\Refpenumpang;
use app\models\kemudahan\Refjadualpenerbangan;
use app\models\kemudahan\Model;
use yii\helpers\Html;
use app\models\Notification;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use yii\web\UploadedFile;
use kartik\mpdf\Pdf;
use app\models\kemudahan\Tblaccess;
use app\models\Kemudahan\Kemudahan;
use yii\filters\AccessControl;
use DateTime; 
use app\models\kemudahan\TblPayinstruct;
use app\models\kemudahan\TblPayInstructDetails; 

/**
 * BorangpengangkutanController implements the CRUD actions for Borangpengangkutan model.
 */
class BorangpengangkutanController extends Controller
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
     * Lists all Borangpengangkutan models.
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
            'query' => Borangpengangkutan::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Deletes an existing Borangpengangkutan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Borangpengangkutan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Borangpengangkutan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Borangpengangkutan::findOne($id)) !== null) {
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
      
     public function actionMaklumatPengangkutan()
    {
  
        $icno = Yii::$app->user->getId(); 
        $peg_tadbir = TblAccess::findOne(['admin_post' => 1 ]); 
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]); 
        $kakitangan = $this->findBiodata($this->icno());
        $model = new Borangpengangkutan();
       
         
        $model->icno = $icno; 
        $family =  Tblkeluarga::find()->where(['ICNO' => $model->icno])->andwhere(['IN', 'RelCd', ['01', '02', '05', '06', '07', '08', '15']])->all();
        $queryKeluarga = $this->findRekodKeluarga($kakitangan);
        $modelCustomer = new Borangpengangkutan(); 
        
        $checkOpen = Kemudahan::find()->where(['status' => 0, 'jeniskemudahan' => 4])->one();
        
        if($checkOpen){
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => $checkOpen->reason]);
           
            return $this->redirect(['kemudahan/index']);
        }
        $checkApplication = Borangpengangkutan::find()->where(['status_semasa' => 0,'icno' => $icno]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['borang/senarai']);
        }
        
        
        $modelsAddress = [new Refpenumpang()]; 
        $modelsPenerbangan = [new Refjadualpenerbangan()]; 
       
        if ($modelCustomer->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
          
            $ntf = new Notification();
            $ntf2 = new Notification(); 

            $file = UploadedFile::getInstance($model, 'dokumen_sokongan');


            $modelsAddress = Model::createMultiple(Refpenumpang::classname());
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

            $modelCustomer->dokumen_sokongan = $filepath;
            
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                    ActiveForm::validate($modelCustomer)
                );
            }    
           

            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;   
            $valid = Model::validateMultiple($modelsPenerbangan) && $valid;
        
            $modelCustomer->icno = $icno;
            $modelCustomer->entry_date = date('Y-m-d H:i:s');
            $modelCustomer->jeniskemudahan = 4;
            $modelCustomer->status_pt = 'MENUNGGU TINDAKAN';
            $modelCustomer->status_pp = 'MENUNGGU TINDAKAN';
            $modelCustomer->status_kj = 'NEW';
            $modelCustomer->status_semasa = '0';
            $model->semakan_by = $peg_tadbir->icno;
            $model->peraku_by = $peg_bsm->icno;
            $modelCustomer->pengakuan = '1'; 
            $modelCustomer->entry_type = 1;
              
             if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                         
                        foreach ($modelsAddress as $modelAddress) { 
                            
                        $data = Tblkeluarga::find()->where(['AND',['ICNO' => $this->icno()], ['FamilyId' => $modelAddress->icno]])->one(); 
                          
                            $modelAddress->ref_icno = $modelCustomer->icno;
                            $modelAddress->parent_id = $modelCustomer->id;
                            $modelAddress->entry_date = date('Y-m-d H:i:s');
                            $modelAddress->jeniskemudahan = '4';   
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
                            $modelPenerbangan->jeniskemudahan = '4';
                            if (! ($flag = $modelPenerbangan->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        
                        }
                    }
                    
                 $ntf->icno =  $peg_tadbir->icno; // peg  penyelia perjawatan
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan Tuntutan Elaun Pengangkutan Barang menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangpengangkutan/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                          
                         
                     $ntf2->icno = $peg_bsm->icno; // peg perjawatan
                            $ntf2->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf2->content = "Permohonan Kemudahan Tuntutan Elaun Pengangkutan Barang menunggu tindakan perakuan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangpengangkutan/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf2->ntf_dt = date('Y-m-d H:i:s');
                            $ntf2->save();
           
                    $this->notification( $model->icno, 'Permohonan anda telah dihantar untuk diproses sila semak status permohonan anda.'.Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));
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


        return $this->render('form_pengangkutan', [
            'model' => $model,
            'family' => $family,
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new Refpenumpang] : $modelsAddress,
            'modelsPenerbangan' => (empty($modelsPenerbangan)) ? [new Refjadualpenerbangan] : $modelsPenerbangan,
            'queryKeluarga' => $queryKeluarga,
            'kakitangan' => $kakitangan, 
        ]);
    }
    
    public function findRekodKeluarga($kakitangan) {

        if ($kakitangan->MrtlStatusCd == 0) { //Status Tiada Maklumat
            $family = Tblkeluarga::find()->where(['ICNO' => null])->all(); // dummy
            
        } else if ($kakitangan->MrtlStatusCd == 1) { // Belum berkahwin
            $family = Tblkeluarga::find()->where(['ICNO' => $kakitangan->ICNO]) ->joinWith('hubunganKeluarga')->all();
           
        } else {
            $family = Tblkeluarga::find()->where(['ICNO' => $kakitangan->ICNO])->joinWith('hubunganKeluarga')->all();
                        
        }

        return $family;
    }
     
    public function actionSenaraitindakan()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai  = '';
        $model = new BorangPengangkutan();
        $status = ['NEW', 'DILULUSKAN', 'MENUNGGU TINDAKAN', 'TIDAK DILULUSKAN'];
        if(Refpegawai::find()->where( ['pembantu_tadbir' => $icno] )->exists()){
            
            $senarai = BorangPengangkutan::find()->where(['in', 'status_kj', $status])->andWhere(['jeniskemudahan' => 4])->orderBy(['entry_date' => SORT_DESC]);
            $title='Senarai Menunggu Semakan';
            
        }
        elseif(Refpegawai::find()->where( ['pegawai_bsm' => $icno] )->exists()){
            
            $senarai = BorangPengangkutan::find()->where(['in', 'status_kj', $status])->andWhere(['jeniskemudahan' => 4])->orderBy(['entry_date' => SORT_DESC]);
            $title ='Senarai Menunggu Perakuan';
            
        }
        elseif(Department::find()->where(['chief' => $icno, 'id' => '158'])->exists()){
            
            $senarai = BorangPengangkutan::find()->where(['in', 'status_kj', $status])->andWhere(['jeniskemudahan' => 4])->orderBy(['entry_date' => SORT_DESC]);
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
    
     public function actionSemakan_pt($id)
    {
        $icno = Yii::$app->user->getId(); 
        $model = $this->findModel($id);
       
        $query = BorangPengangkutan::find()->where(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        $keluarga = Refpenumpang::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' => '4'])->all();
        $planes = Refjadualpenerbangan::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' => '4'])->all();
        
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
            return $this->redirect(['borangpengangkutan/senaraitindakan']);
            }
        }
        return $this->render('semakan_pt', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'keluarga' => $keluarga,
            'planes' => $planes,
           
        ]);
       
    }
    public function actionTindakan_bsm($id)
    {
        $icno = Yii::$app->user->getId();
         
        $model = $this->findModel($id);
        $chief = Department::findOne(['id' => '158']);
        $query = BorangPengangkutan::find()->where(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        $keluarga = Refpenumpang::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' => '4'])->all();  
        $planes = Refjadualpenerbangan::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' => '4'])->all();
          
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
                            $ntf->content = "Permohonan Kemudahan Tuntutan Elaun Pengangkutan Barang menunggu tindakan Kelulusan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangpengangkutan/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save(); 
           
           $model->peraku_by = $icno;                   
           $model->save(false);    
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
           return $this->redirect(['borangpengangkutan/senaraitindakan']);
            }
        }
        return $this->render('tindakan_bsm', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'keluarga' => $keluarga,
            'planes' => $planes,
             
        ]); 
    }
    
    public function actionTindakan_kj($id)
    {
        $icno = Yii::$app->user->getId();           
        $model = $this->findModel($id);
        $chief = Department::find()->where(['chief' => $icno, 'id' => '158'])->exists(); 
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]); 
 
        $query = BorangPengangkutan::find()->where(['mohon' => 1])->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        $keluarga = Refpenumpang::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' => '4'])->all();  
        $planes = Refjadualpenerbangan::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' => '4'])->all();
        
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
           
           $ntf->icno = $model->icno;// peg  penyelia perjawatan
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan Tuntutan Elaun Pengangkutan Barang anda tidak diluluskan.".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save(); 
                             
           $model->pelulus_by = $icno;                                   
           $model->save(false);
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
           return $this->redirect(['borangpengangkutan/senaraitindakan']);
           }
           else{
            $ntf2 = new Notification();

            $ntf2->icno = $peg_bsm->icno; // pemohon
            $ntf2->title = 'Permohonan Kemudahan Atas Talian';
            $ntf2->content = "Permohonan Kemudahan Tuntutan Elaun Pengangkutan Barang telah diluluskan oleh Ketua BSM kini menunggu tindakan daripada anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangpengangkutan/senaraiberjaya'], ['class'=>'btn btn-primary btn-sm']);
            $ntf2->ntf_dt = date('Y-m-d H:i:s');
            $ntf2->save();     

            $model->pelulus_by = $icno;                   
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
            return $this->redirect(['borangpengangkutan/senaraitindakan']);
           }
        }
        
        return $this->render('tindakan_kj', [
            'model' => $model,
            'keluarga' => $keluarga,
            'planes' => $planes,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
    }
    
    public function actionSenaraiberjaya()
    {
       
        $model = new BorangPengangkutan();
        $model->icno = Yii::$app->user->getId();
        $pay = new TblPayinstruct();
        $infoPay = new TblPayInstructDetails(); 
        $peg_bendahari = TblAccess::findOne(['admin_post' => 4]); 
  
        $status = ['DILULUSKAN']; 
        $models = BorangPengangkutan::find()->All();
        $query = BorangPengangkutan::find()->where([ 'status_kj' => $status, 'jeniskemudahan' => 4]) ->andWhere(['isActive' => 2]);

        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
        
        $selection = (array)Yii::$app->request->post('selection');//typecasting 
            if (Yii::$app->request->post('simpan')){
                
                $ntf = new Notification();
                 
                foreach ($selection as $id) {
                    if('y'.$id == Yii::$app->request->post($id)){
                    $pay = new TblPayinstruct();
                    $infoPay = new TblPayInstructDetails(); 

                    $model = $this->findModel($id);
                    $model->isActive ='1';
                    $model->stat_bendahari = 'DALAM PROSES BAYARAN'; 
                    $model->tarikh_hantar = date('Y-m-d H:i:s');   
                    $model->status_semasa = '1';
                    $model->mohon = '1';
                    
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
            
                    $pay->PAY_STAFF_ICNO =  $model->icno;  
                    $pay->PAY_DATE_FROM = $model->entry_date;
                    $pay->PAY_DATE_TO = $model->entry_date; 
                    $pay->PAY_REF_ID = $model->id;
                    $pay->PAY_ENTRY_TYPE = $model->entry_type;
                    $pay->PAY_PARENT_ID = $model->id;
                    $pay->PAY_ELAUN_ID = $model->jeniskemudahan;
                    
                            $ntf->icno = $peg_bendahari->icno; // notification kpd bendahari
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan Tuntutan Elaun Pengangkutan Barang menunggu tindakan anda untuk diproses.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangpengangkutan/senaraibendahari'], ['class'=>'btn btn-primary btn-sm']);;
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                     
                    $this->notification($model->icno, "Permohonan anda telah diluluskan oleh Ketua BSM, kini dalam proses pembayaran Bendahari"." ".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));       
                    $model->save(false);
                    $pay->save(false);
                    $infoPay->save(false);
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
            'pay' => $pay,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'infoPay' => $infoPay,
        ]);
    }
    
    public function actionSenaraibendahari()
    {
       
        $icno = Yii::$app->user->getId();
         
        $status = ['DILULUSKAN'];
        $model = BorangPengangkutan::find()->where(['in', 'status_kj', $status])->andWhere(['isActive' => 1])->orderBy(['entry_date' => SORT_DESC])->All();
   
        return $this->render('senarai_bendahari', [
            'model' => $model, 
            'bil' => 1,
        ]);
        
    }
    public function actionTindakan_bendahari($id)
    {
        $icno = Yii::$app->user->getId();           
        $model = $this->findModel($id);
          
        $query = BorangPengangkutan::find()->where(['mohon' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        $keluarga = Refpenumpang::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();  
        $planes = Refjadualpenerbangan::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id])->all();
         
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        
        return $this->render('tindakan_bendahari', [
            'model' => $model,
            'keluarga' => $keluarga,
            'planes' => $planes,
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
        $model = new BorangPengangkutan();
       
        if($bulan == 0 ){
         $query =  BorangPengangkutan::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
           
        }else{
            $query =  BorangPengangkutan::find()->where(['MONTH(entry_date)' => $mth])->andWhere(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
        
        }
      
        $statistik = BorangPengangkutan::find()->select(new \yii\db\Expression("MONTH(`entry_date`) AS BULAN, COUNT(`id`) AS TOTAL"))->where(['YEAR(entry_date)' => $year, 'mohon' => 1])->groupBy('MONTH(`entry_date`)')->asArray()->all();
        
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
        $model = BorangPengangkutan::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC])->all();
       
        }else{
        $model = BorangPengangkutan::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC])->all();
      
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
            $facility = BorangPengangkutan::find()->where(['icno' => $model])->andWhere(['id' =>  $id])->one();
            $keluarga = Refpenumpang::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'jeniskemudahan' => '4'])->all();  
     //     get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('slulus', ['facility' => $facility, 'keluarga' => $keluarga, 'bil' => 1,]);
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
         
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]); 
        $kakitangan = $this->findBiodata($this->icno());
        $model = new Borangpengangkutan();
       
          
        $family =  Tblkeluarga::find()->where(['ICNO' => $model->icno])->andwhere(['IN', 'RelCd', ['01', '02', '05', '06', '07', '08', '15']])->all();
        $queryKeluarga = $this->findRekodKeluarga($kakitangan);
        $modelCustomer = new Borangpengangkutan(); 
        
         
        
        
        $modelsAddress = [new Refpenumpang()]; 
        $modelsPenerbangan = [new Refjadualpenerbangan()]; 
       
        if ($modelCustomer->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
          
            $ntf = new Notification();
            

            $file = UploadedFile::getInstance($model, 'dokumen_sokongan');


            $modelsAddress = Model::createMultiple(Refpenumpang::classname());
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

            $modelCustomer->dokumen_sokongan = $filepath;
            
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                    ActiveForm::validate($modelCustomer)
                );
            }    
           

            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;   
            $valid = Model::validateMultiple($modelsPenerbangan) && $valid;
        
            
            $modelCustomer->entry_date = date('Y-m-d H:i:s');
            $modelCustomer->jeniskemudahan = 4; 
            $modelCustomer->status_kj = 'DILULUSKAN';
            $modelCustomer->stat_bendahari = 'MENUNGGU TINDAKAN';
            $modelCustomer->status_semasa = '0';  
            $modelCustomer->entry_type = 2;
            $modelCustomer->isActive = 2;
            $modelCustomer->mohon = 1;
            $modelCustomer->pengakuan = 1;
              
             if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                         
                        foreach ($modelsAddress as $modelAddress) { 
                            
                        $data = Tblkeluarga::find()->where(['AND',['ICNO' => $this->icno()], ['FamilyId' => $modelAddress->icno]])->one(); 
                          
                            $modelAddress->ref_icno = $modelCustomer->icno;
                            $modelAddress->parent_id = $modelCustomer->id;
                            $modelAddress->entry_date = date('Y-m-d H:i:s');
                            $modelAddress->jeniskemudahan = '4';   
                            
                             
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
                            $modelPenerbangan->jeniskemudahan = '4';
                            if (! ($flag = $modelPenerbangan->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        
                        }
                    }
                     
                         
                     $ntf->icno = $peg_bsm->icno; // peg perjawatan
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan Tuntutan Elaun Pengangkutan Barang menunggu tindakan perakuan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangpengangkutan/senaraiberjaya'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                            
                            
                     Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
                    
                    
                    if ($flag) {
                        $transaction->commit();
                         return $this->redirect(['borangpengangkutan/new-entry']);
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
            'family' => $family,
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new Refpenumpang] : $modelsAddress,
            'modelsPenerbangan' => (empty($modelsPenerbangan)) ? [new Refjadualpenerbangan] : $modelsPenerbangan,
            'queryKeluarga' => $queryKeluarga,
            'kakitangan' => $kakitangan, 
        ]); 
    }
}
