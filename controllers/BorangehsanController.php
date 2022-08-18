<?php

namespace app\controllers;

use Yii;
use app\models\kemudahan\Borangehsan;
use app\models\kemudahan\BorangehsanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\kemudahan\Reffamily;
use app\models\kemudahan\Model;
use yii\helpers\Html;
use app\models\Notification;
use app\models\Kemudahan\Refpegawai;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Department;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use kartik\mpdf\Pdf; 
use app\models\kemudahan\Tblaccess;
use app\models\Kemudahan\Kemudahan;
use yii\filters\AccessControl;
use app\models\kemudahan\TblPayinstruct;
use app\models\kemudahan\TblPayInstructDetails; 
 

/**
 * BorangehsanController implements the CRUD actions for Borangehsan model.
 */
class BorangehsanController extends Controller
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
     * Lists all Borangehsan models.
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
        $searchModel = new BorangehsanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Borangehsan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Borangehsan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Borangehsan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Borangehsan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   
    public function actionUpdate($id)
    {      
              
        //code dynamic update
        $model = $this->findModel($id);
        $modelCustomer = $this->findModel($id);     
        $modelsAddress = $modelCustomer->Reffamily;
        
        if ($modelCustomer->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsAddress, 'ref_icno', 'icno');
            $modelsAddress = Model::createMultiple(Reffamily::classname(), $modelsAddress);
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsAddress, 'icno', 'icno')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                    ActiveForm::validate($modelCustomer)
                );
            }

            // validate all models
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            
        
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        if (! empty($deletedIDs)) {
                            Reffamily::deleteAll(['id' => $deletedIDs]); 
                        }
                        foreach ($modelsAddress as $modelAddress) {
                            $modelAddress->ref_icno = $modelCustomer->icno;
                            
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['kemudahan/index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new Address] : $modelsAddress
            
        ]);
    
       
        
    }

    /**
     * Deletes an existing Borangehsan model.
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
     * Finds the Borangehsan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Borangehsan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Borangehsan::findOne($id)) !== null) {
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

    public function actionForm_pemohon()
    {
  
        $icno = Yii::$app->user->getId();  
        
        $kakitangan = $this->findBiodata($this->icno());
        $model = new Borangehsan();
        $searchModel = new BorangehsanSearch(); 
        $model->icno = $icno;  
        $peg_tadbir = TblAccess::findOne(['admin_post' => 1 ]); 
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]);  
       
        $family =  Tblkeluarga::find()->where(['ICNO' => $model->icno])->andwhere(['IN', 'RelCd', ['01', '02', '03', '04', '05', '06', '07', '08', '15']])->all();
        $queryKeluarga = $this->findRekodKeluarga($kakitangan);
        
        $checkOpen = Kemudahan::find()->where(['status' => 0, 'jeniskemudahan' => 5])->one();
        
        if($checkOpen){
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => $checkOpen->reason]);
           
            return $this->redirect(['kemudahan/index']);
        }
        $checkCount = Borangehsan::find()->where(['mohon' => 1 ,'icno' => $icno])->count();
        if($checkCount >= 4){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tidak layak untuk memohon. Permohonan ini hanya layak diberi sepanjang 4 kali sepanjang perkhidmatan sahaja.']);
        
            return $this->redirect(['borang/sejarahpermohonan']);
        }
        
        $check = Borangehsan::find()->where('YEAR(entry_date) > YEAR(NOW() - INTERVAL 4 YEAR)')->andWhere(['mohon' => 1 ,'icno' => $icno]);
         if($check ->exists()){
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda belum layak untuk memohon. Permohonan ini hanya terhad kepada 4 kali sepanjang perkhidmatan.']);
           
            return $this->redirect(['borang/sejarahpermohonan']);
        }
        $checkApplication = Borangehsan::find()->where(['status_semasa' => 0,'icno' => $icno]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['borang/senarai']);
        }
//        $checkApmt = $this->findBiodata($this->ICNO()); 
//        if($checkApmt->statLantikan != 1){
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan ini hanya layak dipohon bagi kakitangan berstatus tetap sahaja.']);
//            return $this->redirect(['kemudahan/index']);
//        } 
//       dynamic controller  code
        
        $modelCustomer = new Borangehsan(); //customer      //borangehsan
        $modelsAddress = [new Reffamily()]; //address       //reffamily
        $modelsFamily = [new Tblkeluarga()];
       
            
        if ($modelCustomer->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
        
            $ntf = new Notification();
            $ntf2 = new Notification();  
           
            $file = UploadedFile::getInstance($model, 'dokumen_sokongan');
            $file2 = UploadedFile::getInstance($model, 'dokumen_sokongan2');
            
            $modelsAddress = Model::createMultiple(Reffamily::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            
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
                    ActiveForm::validate($modelCustomer)
                );
            }
            
             
            // validate all models
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
 
            
            $modelCustomer->icno = $icno;
            $modelCustomer->entry_date = date('Y-m-d H:i:s');
            $modelCustomer->jeniskemudahan = 5;
            $modelCustomer->status_pt = 'MENUNGGU TINDAKAN';
            $modelCustomer->status_pp = 'MENUNGGU TINDAKAN';
            $modelCustomer->status_kj = 'NEW';
            $modelCustomer->status_semasa = '0';
            $modelCustomer->jeniskemudahan = '5';
            $modelCustomer->pengakuan = '1';
            $modelCustomer->semakan_by = $peg_tadbir->icno;
            $modelCustomer->peraku_by = $peg_bsm->icno;
            $modelCustomer->entry_type = 1;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelsAddress as $modelAddress) {
                $rel = ['Ibu','Bapa','Ibu Mertua', 'Bapa Mertua'];
                $data = Tblkeluarga::find()->where(['AND',['ICNO' => $this->icno()], ['FamilyId' => $modelAddress->icno]])->one();  
                $fmyCount = Reffamily::find()->where(['AND',['ref_icno' => $this->icno()], ['icno' => $modelAddress->icno , 'hubungan' => $rel]])->count();
                $fmyexist = Reffamily::find()->where(['ref_icno' => $this->icno()])->andwhere(['hubungan' => $rel])->exists();
                if($fmyexist && $data->RelCd != 01  && $data->RelCd != 02 && $data->RelCd != 05){
                    Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Kemudahan ini hanya boleh digunakan sekali sahaja bagi seorang ibu bapa atau ibu bapa mertua. !']);

                return $this->redirect(['borangehsan/form_pemohon']);
                }
                if( $fmyCount >= 1 || $data->RelCd == ['03','04'] ){
                  
                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Kemudahan ini hanya boleh digunakan sekali sahaja bagi seorang ibu bapa atau ibu bapa mertua. !']);

                return $this->redirect(['borangehsan/form_pemohon']);
                }
                
                else{
                              $modelAddress->ref_icno = $modelCustomer->icno;
                              $modelAddress->parent_id = $modelCustomer->id;
                              $modelAddress->entry_date = date('Y-m-d H:i:s');
                              $modelAddress->idkemudahan = '5';
                              $modelAddress->tarikh_lahir = $data->FmyBirthDt;
                              $modelAddress->hubungan = $data->hubkeluarga;  
                              $modelAddress->nama = $data->FmyNm;
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                                
                            }
                        }
                        }
                    }
                    $ntf->icno = $peg_tadbir->icno; // peg  penyelia perjawatan
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Tambang Belas Ehsan menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangehsan/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                          
                         
                     $ntf2->icno = $peg_bsm->icno; // peg perjawatan
                            $ntf2->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf2->content = "Permohonan Tambang Belas Ehsan menunggu tindakan perakuan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangehsan/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf2->ntf_dt = date('Y-m-d H:i:s');
                            $ntf2->save();
                            
                    $this->notification($model->icno, 'Permohonan anda telah dihantar untuk diproses sila semak status permohonan anda.'.Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
                    if ($flag) {
                        $transaction->commit();
                       
                        return $this->redirect(['borang/senarai']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            $model->save(false);
            $modelCustomer->save(false);
        
        }
        
        return $this->render('form_pemohon', [
            'model' => $model,
            'family' => $family,
            'queryKeluarga' => $queryKeluarga,
            'kakitangan' => $kakitangan,
            'searchModel' => $searchModel, 
            'modelCustomer' => $modelCustomer,
            'modelFamily' => $modelsFamily,
            'modelsAddress' => (empty($modelsAddress)) ? [new Reffamily] : $modelsAddress
            
        ]);
    }
     
     public function actionForm_pemohon_1()
    {
  
        $icno = Yii::$app->user->getId();  
        
        $kakitangan = $this->findBiodata($this->icno());
        $model = new Borangehsan();
        $searchModel = new BorangehsanSearch(); 
        $model->icno = $icno;  
        $default = Refpegawai::find()->one();
       
        $family =  Tblkeluarga::find()->where(['ICNO' => $model->icno])->andwhere(['IN', 'RelCd', ['01', '02', '03', '04', '05', '06', '07', '08', '15']])->all();
        $queryKeluarga = $this->findRekodKeluarga($kakitangan);
        
        
        $checkApplication = Borangehsan::find()->where(['status_semasa' => 0,'icno' => $icno]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['borang/senarai']);
        }
//       dynamic controller  code
        
        $modelCustomer = new Borangehsan(); //customer      //borangehsan
        $modelsAddress = [new Reffamily()]; //address       //reffamily
        $modelsFamily = [new Tblkeluarga()];
        if ($modelCustomer->load(Yii::$app->request->post())) {
            
            
            $ntf = new Notification();
            $ntf2 = new Notification();  
            $modelsAddress = Model::createMultiple(Reffamily::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                    ActiveForm::validate($modelCustomer)
                );
            }

            // validate all models
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            $file = UploadedFile::getInstance($modelCustomer, 'file');
            $file2 = UploadedFile::getInstance($modelCustomer, 'file2');
            $modelCustomer->icno = $icno;
            $modelCustomer->entry_date = date('Y-m-d H:i:s');
            $modelCustomer->jeniskemudahan = 5;
            $modelCustomer->status_pt = 'MENUNGGU TINDAKAN';
            $modelCustomer->status_pp = 'MENUNGGU TINDAKAN';
            $modelCustomer->status_kj = 'NEW';
            $modelCustomer->status_semasa = '0';
            $modelCustomer->jeniskemudahan = '5';
            
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
            
           
                 $ntf->icno = $default->pembantu_tadbir; // peg  penyelia perjawatan
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan menunggu tindakan semakan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangehsan/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                          
                         
                     $ntf2->icno = $default->pegawai_bsm; // peg perjawatan
                            $ntf2->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf2->content = "Permohonan menunggu tindakan perakuan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangehsan/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf2->ntf_dt = date('Y-m-d H:i:s');
                            $ntf2->save();
           
   
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelsAddress as $modelAddress) {
                              $modelAddress->ref_icno = $modelCustomer->icno;
                              $modelAddress->parent_id = $modelCustomer->id;
                              $modelAddress->entry_date = date('Y-m-d H:i:s');
                              
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                                
                            }
                        }
                    }
                    $this->notification('Permohonan Kemudahan Atas Talian', 'Permohonan anda telah dihantar untuk diproses sila semak status permohonan anda.'.Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
                    if ($flag) {
                        $transaction->commit();
                       
                        return $this->redirect(['kemudahan/index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            
        }
        
        return $this->render('form_pemohon_1', [
            'model' => $model,
            'family' => $family,
            'queryKeluarga' => $queryKeluarga,
            'kakitangan' => $kakitangan,
            'searchModel' => $searchModel, 
            'modelCustomer' => $modelCustomer,
            'modelFamily' => $modelsFamily,
            'modelsAddress' => (empty($modelsAddress)) ? [new Reffamily] : $modelsAddress
            
        ]);
    }
    
    public function actionHubungan() {
         
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = Tblkeluarga::find()->select(['id' => 'FamilyId', 'name' => 'FmyNm'])->where(['FamilyId' => $cat_id])->asArray()->all();
                
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }
    
     public function actionSenaraitindakan()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai  = '';
        $model = new Borangehsan();
        $status = ['NEW', 'DILULUSKAN', 'MENUNGGU TINDAKAN', 'TIDAK DILULUSKAN'];
        if(Refpegawai::find()->where( ['pembantu_tadbir' => $icno] )->exists()){
            
            $senarai = Borangehsan::find()->where(['in', 'status_kj', $status])->andWhere(['jeniskemudahan' => 5])->orderBy(['entry_date' => SORT_DESC]);
            $title='Senarai Menunggu Semakan';
            
        }
        elseif(Refpegawai::find()->where( ['pegawai_bsm' => $icno] )->exists()){
            
            $senarai = Borangehsan::find()->where(['in', 'status_kj', $status])->andWhere(['jeniskemudahan' => 5])->orderBy(['entry_date' => SORT_DESC]);
            $title ='Senarai Menunggu Perakuan';
            
        }
        elseif(Department::find()->where(['chief' => $icno, 'id' => '158'])->exists()){
            
            $senarai = Borangehsan::find()->where(['in', 'status_kj', $status])->andWhere(['jeniskemudahan' => 5])->orderBy(['entry_date' => SORT_DESC]);
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
       
        $searchModel = new BorangehsanSearch();
        $query = Borangehsan::find()->where(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]); 
        $keluarga = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'idkemudahan' => '5'])->all();
         
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $model->semakan_pt = date('Y-m-d H:i:s');
        $model->status_pp = 'MENUNGGU KELULUSAN';
        $model->stat_bendahari = 'ENTRY';
        
        if ($icno != '830828125667') {
            
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf!', 'type' => 'error', 'msg' => 'Anda tidak mempunyai Akses']); 
             return $this->redirect(['kemudahan/index']);
        }
        if ($model->load(Yii::$app->request->post())) {
            if($model->status_pt == ''){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }
                else{
  
            $model->semakan_by = $icno;              
            $model->save(); 
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
            return $this->redirect(['borangehsan/senaraitindakan']);
            }
        }
        return $this->render('semakan_pt', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'keluarga' => $keluarga,
        ]);
       
    }
     public function actionTindakan_bsm($id)
    {
        $icno = Yii::$app->user->getId();
         
        $model = $this->findModel($id);
        $chief = Department::findOne(['id' => '158']);  
        $searchModel = new BorangehsanSearch();
        $query = Borangehsan::find()->where(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]); 
        $keluarga = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'idkemudahan' => '5'])->all();
         
        
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
                            $ntf->content = "Permohonan Tambang Belas Ehsan menunggu tindakan Kelulusan anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangehsan/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save(); 
                            
           $model->peraku_by = $icno;                              
           $model->save();    
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
           return $this->redirect(['borangehsan/senaraitindakan']);
            }
        }
        return $this->render('tindakan_bsm', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'keluarga' => $keluarga,
        ]);
       
    }
    public function actionTindakan_kj($id)
    {
        $icno = Yii::$app->user->getId();           
        $model = $this->findModel($id);
        $chief = Department::find()->where(['chief' => $icno, 'id' => '158'])->exists(); 
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]);   
        
        $searchModel = new BorangehsanSearch();
        $query = Borangehsan::find()->where(['mohon' => 1])->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        $keluarga = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id,  'idkemudahan' => '5'])->all();
        
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
           $model->status_semasa = '1';
           $ntf = new Notification();
           
           $ntf->icno = $model->icno;// pemohon
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Tambang Belas Ehsan anda tidak diluluskan.".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save(); 
           
           $model->pelulus_by = $icno;                 
           $model->save(false);
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
           return $this->redirect(['borangehsan/senaraitindakan']);
           }
        else{
            $ntf2 = new Notification();

            $ntf2->icno = $peg_bsm->icno; // noti kpd pegawai Bsm
            $ntf2->title = 'Permohonan Kemudahan Atas Talian';
            $ntf2->content = "Permohonan Tambang Belas Ehsan telah diluluskan oleh Ketua BSM kini menunggu tindakan daripada anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangehsan/senaraiberjaya'], ['class'=>'btn btn-primary btn-sm']);
            $ntf2->ntf_dt = date('Y-m-d H:i:s');
            $ntf2->save();     

            $model->pelulus_by = $icno;              
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
            return $this->redirect(['borangehsan/senaraitindakan']);
           }
        }
        
        return $this->render('tindakan_kj', [
            'model' => $model,
            'keluarga' => $keluarga,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
    }
    public function actionSenaraiberjaya()
    {
       
        $model = new Borangehsan();
        $pay = new TblPayinstruct();
        $infoPay = new TblPayInstructDetails();
        $model->icno = Yii::$app->user->getId();
        
        $peg_bendahari = TblAccess::findOne(['admin_post' => 4]);   
        $searchModel = new BorangehsanSearch();
        $status = ['DILULUSKAN']; 
        $models = Borangehsan::find()->All();
        $query = Borangehsan::find()->where([ 'status_kj' => $status, 'jeniskemudahan' => 5]) ->andWhere(['isActive2' => 2]);
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
       
        
        $selection = (array)Yii::$app->request->post('selection');//typecasting
            if (Yii::$app->request->post('simpan')){
                
                $ntf = new Notification();
                
                foreach ($selection as $id) {
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
                    
                     $ntf->icno = $peg_bendahari->icno;// notification kpd bendahari
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Tambang Belas Ehsan menunggu tindakan anda untuk diproses.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangehsan/senaraibendahari'], ['class'=>'btn btn-primary btn-sm']);;
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                            
                    $this->notification($model->icno, "Permohonan anda telah diluluskan oleh Ketua BSM, kini dalam proses pembayaran Bendahari"." ".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));         
                    $model->save(false);
                    $pay->save(false);
                    $infoPay->save(false);
                     
                    }
                    elseif('n'.$id == Yii::$app->request->post($id)){
                    $model = $this->findModel($id);
                    $model->isActive2 ='2';
                    $model->save(false);
                  
                    }
            }
            }
          
 
        return $this->render('senaraiberjaya', [
            'model' => $model,
            'models' => $models,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
            'pay' => $pay,
            'infoPay' => $infoPay,
        ]);
    }
    
    public function actionSenaraibendahari()
    {
       
        $icno = Yii::$app->user->getId();
         
        $searchModel = new BorangehsanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $status = ['DILULUSKAN'];
        $model = Borangehsan::find()->where(['in', 'status_kj', $status])->andWhere(['isActive2' => 1, 'jeniskemudahan' => 5])->orderBy(['entry_date' => SORT_DESC])->All();
   
        return $this->render('senarai_bendahari', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'bil' => 1,
        ]);
        
    }
    
    public function actionTindakan_bendahari($id)
    {
        $icno = Yii::$app->user->getId();           
        $model = $this->findModel($id);
         
        $searchModel = new BorangehsanSearch();
        $query = Borangehsan::find()->where(['mohon' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
        $keluarga = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id,  'idkemudahan' => '5'])->all();
        
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
                                 $ntf->title = 'Permohonan Kemudahan Atas Talian';
                                 $ntf->content = "Permohonan kemudahan anda telah berjaya. Tindakan pembayaran oleh pihak Bendahari telah dilaksanakan.".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']);
                                 $ntf->ntf_dt = date('Y-m-d H:i:s');
                                 $ntf->save();
                                 
           $model->save();
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
           return $this->redirect(['borangehsan/senaraibendahari']);
           }
        }
        
        return $this->render('tindakan_bendahari', [
            'model' => $model,
            'keluarga' => $keluarga,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
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
    
    public function actionSlulus($id)
        {   $css = file_get_contents('./css/kelulusan.css');
            #cehck application
            $model = $this->findModel($id);
            $icno = Yii::$app->user->getId();   
            $facility = Borangehsan::find()->where(['icno' => $model])->andWhere(['id' =>  $id])->one();
            $keluarga = Reffamily::find()->where(['ref_icno' => $model])->andWhere(['parent_id' => $model->id, 'idkemudahan' => '5'])->all();  
     //     get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('slulus', ['facility' => $facility, 'keluarga' => $keluarga ]);
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
        $model = new Borangehsan();
       
        if($bulan == 0 ){
         $query =  Borangehsan::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
           
        }else{
            $query =  Borangehsan::find()->where(['MONTH(entry_date)' => $mth])->andWhere(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
        
        }
        $sum = $query->sum('jumlah');
        $statistik = Borangehsan::find()->select(new \yii\db\Expression("MONTH(`entry_date`) AS BULAN, COUNT(`id`) AS TOTAL"))->where(['YEAR(entry_date)' => $year])->groupBy('MONTH(`entry_date`)')->asArray()->all();
        
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
        $model = Borangehsan::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC])->all();
       
        }else{
        $model = Borangehsan::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC])->all();
      
        }
        
        return $this->render('reportpentadbiran', [
            'tahun' => $year,
            'bulan' => $mth, 
            'model' => $model,
        ]);
    }  
     public function actionTuntutan($id){
//         $model = Borangehsan::find()->where(['id' => $id])->andWhere(['isActive2' =>  1])->one(); 
        $model = Borangehsan::findOne(['id' => $id, 'isActive2' => 1]);   
        $count = Borangehsan::find()->where(['icno' => $model])->count();
        $mpdf = new \Mpdf\Mpdf(['mode' => 'UTF-8', 
        // "allowCJKoverflow" => true, 
        "autoScriptToLang" => true,
        // "allow_charset_conversion" => false,
        "autoLangToFont" => true,]);
        $mpdf->allow_charset_conversion = true;
        $mpdf->charset_in = 'iso-8859-4';
        $pagecount = $mpdf->SetSourceFile('uploads/tuntutan_ehsan.pdf');
            for ($i=1; $i<=$pagecount; $i++) {
                $import_page = $mpdf->ImportPage($i);
                $mpdf->UseTemplate($import_page);
                if($i==1){ //page1
                $mpdf->WriteHTML($this->renderPartial('borangtuntutan', ['model' => $model, 'count' => $count]));
                }
                if ($i < $pagecount){
                $mpdf->AddPage();}
            }
            $mpdf->Output();
        }
        
        
    public function actionNewEntry()
    {  
        $icno = Yii::$app->user->getId();  
        
        $kakitangan = $this->findBiodata($this->icno());
        $model = new Borangehsan();
        $searchModel = new BorangehsanSearch(); 
        $model->icno = $icno;  
        $peg_tadbir = TblAccess::findOne(['admin_post' => 1 ]); 
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]);  
       
        $family =  Tblkeluarga::find()->where(['ICNO' => $model->icno])->andwhere(['IN', 'RelCd', ['01', '02', '03', '04', '05', '06', '07', '08', '15']])->all();
        $queryKeluarga = $this->findRekodKeluarga($kakitangan);
        
        
//       dynamic controller  code
        
        $modelCustomer = new Borangehsan(); //customer      //borangehsan
        $modelsAddress = [new Reffamily()]; //address       //reffamily
        $modelsFamily = [new Tblkeluarga()];
       
            
        if ($modelCustomer->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
        
            $ntf = new Notification(); 
            
            $file = UploadedFile::getInstance($model, 'dokumen_sokongan');
            $file2 = UploadedFile::getInstance($model, 'dokumen_sokongan2');
            
            $modelsAddress = Model::createMultiple(Reffamily::classname());
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            
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
                    ActiveForm::validate($modelCustomer)
                );
            }
            
             
            // validate all models
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
  
         
            $modelCustomer->entry_date = date('Y-m-d H:i:s');
            $modelCustomer->jeniskemudahan = 5; 
            $modelCustomer->status_kj = 'DILULUSKAN';
            $modelCustomer->status_semasa = '0';
            $modelCustomer->jeniskemudahan = '5';
            $modelCustomer->pengakuan = '1'; 
            $modelCustomer->entry_type = 2;
            $modelCustomer->isActive2 = 2;
            $modelCustomer->mohon = 1;
            $modelCustomer->stat_bendahari = 'MENUNGGU TINDAKAN'; 
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
               try {
                    if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelsAddress as $modelAddress) {
                $rel = ['Ibu','Bapa','Ibu Mertua', 'Bapa Mertua'];
//                $data = Tblkeluarga::find()->where(['AND',['ICNO' => $this->icno()], ['FamilyId' => $modelAddress->icno]])->one();  
                $data = new Tblkeluarga();
                $fmyCount = Reffamily::find()->where(['AND',['ref_icno' => $modelCustomer->icno], ['icno' => $modelAddress->icno , 'hubungan' => $rel]])->count();
                $fmyexist = Reffamily::find()->where(['ref_icno' => $modelCustomer->icno])->andwhere(['hubungan' => $rel])->exists();
                $fam = Tblkeluarga::find()->where(['ICNO' => $modelCustomer->icno])->andwhere(['IN', 'RelCd', ['01', '02', '03', '04', '05', '06', '07', '08', '15']])->all();

                if($fmyexist && $data->RelCd != 01  && $data->RelCd != 02 && $data->RelCd != 05){
                    Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Kemudahan ini hanya boleh digunakan sekali sahaja bagi seorang ibu bapa atau ibu bapa mertua. !']);

                return $this->redirect(['borangehsan/new-entry']);
                }
                if( $fmyCount >= 1 || $data->RelCd == ['03','04'] ){
                  
                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Kemudahan ini hanya boleh digunakan sekali sahaja bagi seorang ibu bapa atau ibu bapa mertua. !']);

                return $this->redirect(['borangehsan/new-entry']);
                }
                
                else{
                              $modelAddress->ref_icno = $modelCustomer->icno;
                              $modelAddress->parent_id = $modelCustomer->id;
                              $modelAddress->entry_date = date('Y-m-d H:i:s');
                              $modelAddress->idkemudahan = '5'; 
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                                
                            }
                            }
                        }
                    }
                   $ntf->icno = $peg_bsm->icno; // peg  penyelia perjawatan
                     $ntf->title = 'Permohonan Kemudahan Atas Talian';
                     $ntf->content = "Permohonan Tambang Belas Ehsan menunggu tindakan daripada anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borangehsan/senaraiberjaya'], ['class'=>'btn btn-primary btn-sm']);
                     $ntf->ntf_dt = date('Y-m-d H:i:s');
                     $ntf->save(); 
                            
                     Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
                    if ($flag) {
                        $transaction->commit();
                       
                        return $this->redirect(['borangehsan/new-entry']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            $model->save(false);
            $modelCustomer->save(false);
        
        }
        
        return $this->render('new_entry', [
            'model' => $model,
            'family' => $family,
            'queryKeluarga' => $queryKeluarga,
            'kakitangan' => $kakitangan,
            'searchModel' => $searchModel, 
            'modelCustomer' => $modelCustomer,
            'modelFamily' => $modelsFamily, 
            'modelsAddress' => (empty($modelsAddress)) ? [new Reffamily] : $modelsAddress
           
        ]);
    }     
    public function actionPadam(){
        return Yii::$app->FileManager->DeleteFile('');//insert the code
        
    } 
}
