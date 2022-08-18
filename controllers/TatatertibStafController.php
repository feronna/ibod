<?php

namespace app\controllers;
use app\models\tatatertib_staf\TblRekod;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use app\models\tatatertib_staf\TblRekodSearch;
use yii\data\ActiveDataProvider;
use app\models\tatatertib_staf\TblAdmin;
use app\models\tatatertib_staf\TblAhliMesyuarat;
use app\models\tatatertib_staf\TblUrusMesyuarat;
use app\models\tatatertib_staf\TblPbpu;
use app\models\ptb\Model;
use app\models\hronline\Tblrscoadminpost;
use Yii;
use yii\helpers\Html;
use app\models\Notification;
use yii\web\UploadedFile;
use kartik\mpdf\Pdf;


class TatatertibStafController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
      public function actionPermohonan()
    {
        return $this->render('permohonan');
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
    
        public function actionRekodKes()
    {
        $rekod = new TblRekod();
        $biodataKakitangan = ArrayHelper::map(Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm');
        
        if ($rekod->load(Yii::$app->request->post()) ) {
            $rekod->kategori_jawatan = Yii::$app->user->getIdentity()->jawatan->job_category;  
            $rekod->jabatan = Yii::$app->user->getIdentity()->department->id;
            $rekod->skim_perkhidmatan = Yii::$app->user->getIdentity()->jawatan->skimPerkhidmatan->id;
            $rekod->save();
            
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Disimpan']);
            return $this->redirect(['index']);
        }
        
    return $this->render('rekod-kes', ['rekod' => $rekod, 'biodataKakitangan' => $biodataKakitangan]);
}


//        public function actionRekodKesBatch()
//    {
//        $rekod = new TblRekod();
//       // $model->scenario = "pilih";
//        
//    
//        if ($rekod->load(Yii::$app->request->post())) {
//
//            $id = $rekod->rekod_type;
//
//            $model_jenis = \app\models\tatatertib_staf\RefJenisRekod::findOne($id);
//
//            return $this->redirect([$model_jenis->action, 'id' => $id, 'form' => $model_jenis->form_type]);
//        }
//
//        return $this->render('rekod-kes-batch', [
//            //'jenis_cuti' => $jenis_cuti,
//            'rekod' => $rekod,
//        ]);
//    }
    
      public function actionRekodKesBatch(){
          
       // $icno = Yii::$app->user->getId(); 
        $biodataKakitangan = ArrayHelper::map(Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm');
        $modelRekod = [new TblRekod];
        
        if (Yii::$app->request->post()) {
            $modelRekod = Model::createMultiple(TblRekod::className());
            Model::loadMultiple($modelRekod, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelRekod)
                    
                );
            }

            // validate all models
            //$valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelRekod);

            if ($valid) {
                
            $transaction = \Yii::$app->db->beginTransaction();
                try {
                    
                    //if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelRekod as $rekod) {
                            
                            $rekod->rekod_type = 2;
                            $rekod->kategori_jawatan = Yii::$app->user->getIdentity()->jawatan->job_category;  
                            $rekod->jabatan = Yii::$app->user->getIdentity()->department->id;
                            $rekod->skim_perkhidmatan = Yii::$app->user->getIdentity()->jawatan->skimPerkhidmatan->id;
                            $rekod->created_at = date('Y-m-d H:i:s');
                           
                            if (! ($flag = $rekod->save(false))) {
                                $transaction->rollBack();
                                break;
                            } $rekod->save();

                        }
                        
                    //}
                    if ($flag) {
                        $transaction->commit();
                         Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah disimpan']);
                         return $this->redirect(['tatatertib-staf/index']);
                    }
                    
                } catch (Exception $e) {
                    
                    $transaction->rollBack();
                }              
        }
}
            return $this->render('rekod-kes-batch', [ 
            'modelRekod' => (empty($modelRekod)) ? [new TblRekod] : $modelRekod,
            'biodataKakitangan' => $biodataKakitangan
        

        ]);
        
        
        
    }
    
     public function actionAdminRekodKesStaf()
    {
     //   $icno = Yii::$app->user->getId();
        $kes_list = TblRekod::find()->joinWith('kakitangan')->all();
        $dropdown_list_name = ArrayHelper::map(Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm') ;
        $request = Yii::$app->request;
     
        $model = new TblRekod();
        $file = UploadedFile::getInstance($model, 'file');
        if ($file) {
            $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'lapordiri');
            $filepath = $fileapi->file_name_hashcode;
        } else {
            $filepath = '';
        }
        
        
        if ($post = Yii::$app->request->post()) {
            
                if (isset($post['TblRekod']['id'])) {
                $bulk_id = $post['TblRekod']['id'];

                foreach ($bulk_id as $k => $v) {
                    if ($v != 0) {
                        $mdl = TblRekod::findOne(['id' => $v]);
                        $mdl->delete();
                       Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
                    }
                }
            }
        
            if (isset($post['TblRekod']['icno'])) {
                
                $bulk_icno = $post['TblRekod']['icno'];
                foreach ($bulk_icno as $k => $v) {
                    
                    
                    if (($v != '')  && (TblRekod::ExistApplication($v) == FALSE)) {
                        $kakitangan = Tblprcobiodata::find()->where(['ICNO' => $v])->one();
                        $model = new TblRekod();
                        $model->icno = $v;
                        $model->rekod_type = 2;
                        $model->kategori_jawatan = $kakitangan->jawatan->job_category; 
                        $model->kumpulan_jawatan = $kakitangan->jawatan->job_group; 
                        $model->dept_id = $kakitangan->department->id;
                        $model->campus_id = $kakitangan->campus_id;
                        $model->skim_perkhidmatan = $kakitangan->jawatan->skimPerkhidmatan->id;
                        $model->created_at = date('Y-m-d H:i:s');
                        $model->kes = $request->post()['TblRekod']['kes'];
                        $model->status = 0;
                        $model->pelulus_icno = 950117126440;
                        $model->bsm_icno = 950117126440;
                        $model->jenis_kesalahan = $request->post()['TblRekod']['jenis_kesalahan'];
                        $model->file = $filepath;
                        $model->save(false);
                        
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data Telah Disimpan']);
                    
                    }else{
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => "Staf Telah Wujud"]);
           }
         }
      }           
           
          

            return $this->redirect(['tatatertib-staf/admin-rekod-kes-staf']);
        }

        return $this->render('admin-rekod-kes-staf', [
            'bil' => 1,
            'model' => $model,
            'dropdown_list_name' => $dropdown_list_name,
            'kes_list' => $kes_list
        
        ]);
    }
    
    
       public function actionDeleteRekodKes($id)
    {
        $admin = TblRekod::findOne(['id' => $id]);
        $admin->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['tatatertib-staf/rekod-kes-staf']);
        
    }

    public function actionSenaraiRekod()
    {
      
        $allStaff = TblRekodSearch::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $allStaff,
        ]);        
        $searchModel = new \app\models\brp\BrpSearch();
        if (Yii::$app->request->queryParams){  
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('senarai-rekod', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]); 
    }
    
    
      public function actionHalamanKp() {
        $permohonan = $this->SenaraiRekod();
        $search = new TblRekod();
        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-bsm', 'icno' => $search->icno, 'jabatan_semasa' => $search->jabatan_semasa, 'kategori_jawatan' => $search->kategori_jawatan, 'gred' => $search->gred]);  
        }
        
        return $this->render('carian-bsm', [
                     'permohonan' => $permohonan,
                    'search' => $search
        ]);
    }
  
     public function SenaraiRekod() {
        $data = new ActiveDataProvider([
            'query' => TblRekod::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }
    
    
       public function GridCarianBsm($icno, $kategori_jawatan, $gred) {
        $data = new ActiveDataProvider([
            'query' => TblRekod::find()->where(['icno' => $icno])->andWhere(['kategori_jawatan' => $kategori_jawatan])->andWhere(['gred' => $gred]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
    
        public function actionCarianPermohonanBsm($icno, $kategori_jawatan, $gred) {
         $permohonan = $this->GridCarianPermohonan($icno, $kategori_jawatan, $gred);
         $search = new TblPortfolio();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-bsm', 'icno' => $search->icno, 'kategori_jawatan' => $search->kategori_jawatan, 'gred' => $search->gred]);
            
        }

        return $this->render('carian-bsm', [
                    'permohonan' => $permohonan,
                    'search' => $search,
             //  'kategori_jawatan' => $kategori_jawatan
               //     'ICNO' => $ICNO,
                //    'DeptId' => $DeptId
        ]);
    }

    
       public function actionUrusMesyuarat() {
        $allMeeting = TblUrusMesyuarat::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $allMeeting,
        ]);        
        $searchModel = new \app\models\tatatertib_staf\TblUrusMesyuaratSearch();
        if (Yii::$app->request->queryParams){  
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('urus-mesyuarat', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]); 
    }
    
      public function actionDeleteUrusMesyuarat($id)
    {
        $admin = TblUrusMesyuarat::findOne(['meeting_id' => $id]);
        $admin->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['admin-urus-mesyuarat']);
        
    }
    
     public function actionMesyuaratJrtk() {  
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
        return $this->render('mesyuarat-jrtk', ['urus' => $urus, 'mesyuaratPbpu' => $mesyuaratPbpu]);
    
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
    
    
     public function actionSenaraiJtk(){
 
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);

        $urusMesyuarat = TblUrusMesyuarat::find()->orderBy(['meeting_id' => SORT_DESC])->limit(1)->all();
        $mesyuaratPbpu = TblPbpu::find()->orderBy(['id' => SORT_DESC])->limit(1)->all();
        
        $searchModel = new TblRekodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy([
            
          'created_at' => SORT_ASC,
          
           ]);
       
          if (Yii::$app->request->post('simpan'))  {

              $answers = Yii::$app->request->post('agree');

              foreach ($answers as $recId => $answer){

                  $model = TblRekod::findOne(['id' => $recId, 'pelulus_agree' => null]);
                   
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
                $model = TblRekod::findOne(['id' => $applicationId , 'letter_sent' => 0]);

                if($model){
                    #check make sure has been approved/declined by pelulus
                    $agree = $model->pelulus->agree;
                   
                    if(!is_null($agree)){
               
                        //    $setPegawai = SetPegawai::findOne('pemohon_icno', $model->icno);

                        if($agree == 1){
                   
                    #approve
                            
                  
                    
                    
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
               
               }
        }
        
         elseif(Yii::$app->request->post('notipegawai')){
               $this->notifipegawai(); 
            }
            
             elseif(Yii::$app->request->post('notiKelulusan')){
               $this->notifiKelulusan(); 
            }

        return $this->render('senarai-jtk', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'urusMesyuarat' => $urusMesyuarat,
            'mesyuaratPbpu' => $mesyuaratPbpu
        ]);
    }
    
     public function actionSenaraiJrtk(){
 
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);

        $urusMesyuarat = TblUrusMesyuarat::find()->orderBy(['meeting_id' => SORT_DESC])->limit(1)->all();
        $mesyuaratPbpu = TblPbpu::find()->orderBy(['id' => SORT_DESC])->limit(1)->all();
        
        $searchModel = new TblRekodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy([
            
          'created_at' => SORT_ASC,
          
           ]);
       
          if (Yii::$app->request->post('simpan'))  {

              $answers = Yii::$app->request->post('agree');

              foreach ($answers as $recId => $answer){

                  $model = TblRekod::findOne(['id' => $recId, 'pelulus_agree' => null]);
                   
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
                $model = TblRekod::findOne(['id' => $applicationId , 'letter_sent' => 0]);

                if($model){
                    #check make sure has been approved/declined by pelulus
                    $agree = $model->pelulus->agree;
                   
                    if(!is_null($agree)){
               
                        //    $setPegawai = SetPegawai::findOne('pemohon_icno', $model->icno);

                        if($agree == 1){
                   
                    #approve
                            
                  
                    
                    
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
               
               }
        }
        
         elseif(Yii::$app->request->post('notipegawai')){
               $this->notifipegawai(); 
            }
            
             elseif(Yii::$app->request->post('notiKelulusan')){
               $this->notifiKelulusan(); 
            }

        return $this->render('senarai-jrtk', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'urusMesyuarat' => $urusMesyuarat,
            'mesyuaratPbpu' => $mesyuaratPbpu
        ]);
    }
    
  
    
    public function actionAdminPostListKeseluruhan($icno=null,$dept_id=null,$campus_id=null,$flag=null)
    {
        $peserta =  Tblprcobiodata::find()->all();
       
        $dataProvider = new ActiveDataProvider([

            'query' => TblRekod::find()->joinWith('dept'),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        
        $dataProvider->query->orderBy([
            new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),
            'id' => SORT_ASC,
            'created_at' => SORT_DESC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
       
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['flag'])){
        isset($flag)? $dataProvider->query->andFilterWhere(['flag' => $flag]):'';}
        
        
        
         if (Yii::$app->request->post('simpan'))  {

              $answers = Yii::$app->request->post('agree');

              foreach ($answers as $answer){

                  #get rec where type = 3(pelulus)
                    $model = TblRekod::findOne([ 'pelulus_agree' => null]);
                   
               
                     $model->pelulus_agree = $answer;
                      $model->save(false);
                      Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
                  

              }
           }
            elseif (Yii::$app->request->post('hantar')) {
            $arrayId = Yii::$app->request->post('selection');
            foreach($arrayId as $applicationId) {


                $model = TblRekod::findOne(['id' => $applicationId , 'letter_sent' => null]);

                if($model){
                    #check make sure has been approved/declined by pelulus
                    $agree = $model->pelulus_agree;
                   
                    if(!is_null($agree)){
               
                        //    $setPegawai = SetPegawai::findOne('pemohon_icno', $model->icno);

                        if($agree == 1){
                   
                    #approve
                           // $this->generateLetter($applicationId, $model->letter_reference, $model->approved_dept,  1);
                            $this->notification('Tatatertib Staf', "Sila semak tatatertib anda".Html::a('Klik Sini', ['representasi-bertulis'], ['class' => 'label label-info']), $model->icno);

                        }
                              
                            
                    }

                    $model->letter_sent = 1; #change sent status to hide from senarai
                    $model->tarikh_noti = date('Y-m-d H:i:s');;
                    $model->save(false);
                }
                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Surat Berjaya dihantar']);
                    
               
               }
           
        }
        
    

        return $this->render('admin-post-list-keseluruhan', [
                'peserta' => $peserta,
                'icno' => $icno,
              //  'adminpos_id' => $adminpos_id,
             //   'program_id' => $program_id,
               'dept_id' => $dept_id,
                'campus_id' => $campus_id,
                'flag' => $flag,
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                // 'model' => $dataProvider
        ]);
    }
    
     public function actionAdminPostListKeseluruhanJrtk($icno=null,$dept_id=null,$campus_id=null,$flag=null)
    {
        $peserta =  Tblprcobiodata::find()->all();
       
        $dataProvider = new ActiveDataProvider([

            'query' => TblRekod::find()->joinWith('dept'),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        
        $dataProvider->query->orderBy([
            new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),
            'id' => SORT_ASC,
            'created_at' => SORT_DESC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
       
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['flag'])){
        isset($flag)? $dataProvider->query->andFilterWhere(['flag' => $flag]):'';}
        
        
        
         if (Yii::$app->request->post('simpan'))  {

              $answers = Yii::$app->request->post('agree');

              foreach ($answers as $answer){

                  #get rec where type = 3(pelulus)
                    $model = TblRekod::findOne([ 'pelulus_agree' => null]);
                   
               
                     $model->pelulus_agree = $answer;
                      $model->save(false);
                      Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
                  

              }
           }
            elseif (Yii::$app->request->post('hantar')) {
            $arrayId = Yii::$app->request->post('selection');
            foreach($arrayId as $applicationId) {


                $model = TblRekod::findOne(['id' => $applicationId , 'letter_sent' => null]);

                if($model){
                    #check make sure has been approved/declined by pelulus
                    $agree = $model->pelulus_agree;
                   
                    if(!is_null($agree)){
               
                        //    $setPegawai = SetPegawai::findOne('pemohon_icno', $model->icno);

                        if($agree == 1){
                   
                    #approve
                           // $this->generateLetter($applicationId, $model->letter_reference, $model->approved_dept,  1);
                            $this->notification('Tatatertib Staf', "Senarai kakitangan untuk diambik tindakan kaunseling".Html::a('Klik Sini', ['tindakan-bsm'], ['class' => 'label label-info']), $model->bsm_icno);

                        }
                              
                            
                    }

                //    $model->letter_sent = 1; #change sent status to hide from senarai
                //    $model->tarikh_noti = date('Y-m-d H:i:s');;
                    $model->save(false);
                }
                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Surat Berjaya dihantar']);
                    
               
               }
           
        }
        
    

        return $this->render('admin-post-list-keseluruhan-jrtk', [
                'peserta' => $peserta,
                'icno' => $icno,
              //  'adminpos_id' => $adminpos_id,
             //   'program_id' => $program_id,
               'dept_id' => $dept_id,
                'campus_id' => $campus_id,
                'flag' => $flag,
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                // 'model' => $dataProvider
        ]);
    }
    
    
        public function actionAdminPostPrimafacie($icno=null,$dept_id=null,$campus_id=null,$flag=null)
    {
        $peserta =  Tblprcobiodata::find()->all();
       
        $dataProvider = new ActiveDataProvider([

            'query' => TblRekod::find()->joinWith('dept'),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        
        $dataProvider->query->orderBy([
            new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),
            'id' => SORT_ASC,
            'created_at' => SORT_DESC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
       
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['flag'])){
        isset($flag)? $dataProvider->query->andFilterWhere(['flag' => $flag]):'';}
        
        
        
         if (Yii::$app->request->post('simpan'))  {

              $answers = Yii::$app->request->post('agree');

//              foreach ($answers as $answer){
//
//                  #get rec where type = 3(pelulus)
//                    $model = TblRekod::findOne([ 'pelulus_agree2' => null]);
//                   
//               
//                     $model->pelulus_agree2 = $answer;
//                      $model->status = 1;
//                      $model->save(false);
//                      Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
//                  
//
//              }
           }
            elseif (Yii::$app->request->post('hantar')) {
            $arrayId = Yii::$app->request->post('selection');
            foreach($arrayId as $applicationId) {


                $model = TblRekod::findOne(['id' => $applicationId ]);

                if($model){
                    #check make sure has been approved/declined by pelulus
                    $agree = $model->pelulus_agree2;
                   
                    if(!is_null($agree)){
               
                        //    $setPegawai = SetPegawai::findOne('pemohon_icno', $model->icno);

                        if($agree == 1){
                   
                    #approve
                           // $this->generateLetter($applicationId, $model->letter_reference, $model->approved_dept,  1);
                            $this->notification('Tatatertib Staf', "Sila semak status tatatertib anda".Html::a('Klik Sini', ['representasi-bertulis'], ['class' => 'label label-info']), $model->icno);

                        }
                              
                            
                    }

                    $model->letter_sent2 = 1; #change sent status to hide from senarai
                   // $model->tarikh_noti = date('Y-m-d H:i:s');;
                    $model->save(false);
                }
                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Surat Berjaya dihantar']);
                    
               
               }
           
        }
        
    

        return $this->render('admin-post-primafacie', [
                'peserta' => $peserta,
                'icno' => $icno,
              //  'adminpos_id' => $adminpos_id,
             //   'program_id' => $program_id,
               'dept_id' => $dept_id,
                'campus_id' => $campus_id,
                'flag' => $flag,
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                // 'model' => $dataProvider
        ]);
    }
    
     public function actionAdminUrusMesyuarat($nama_mesyuarat=null,$tempat_mesyuarat=null)
    {
        $peserta =  Tblprcobiodata::find()->all();
       
        $dataProvider = new ActiveDataProvider([

            'query' => TblUrusMesyuarat::find(),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        
        $dataProvider->query->orderBy([
         //   new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),
            'meeting_id' => SORT_ASC,
            'created_at' => SORT_DESC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['nama_mesyuarat'])){
        $nama_mesyuarat? $dataProvider->query->andFilterWhere(['nama_mesyuarat' => $nama_mesyuarat]):'';}
       
        if(isset(Yii::$app->request->queryParams['tempat_mesyuarat'])){
        $tempat_mesyuarat? $dataProvider->query->andFilterWhere(['tempat_mesyuarat' => $tempat_mesyuarat]):'';}
    
        return $this->render('admin-urus-mesyuarat', [
                'peserta' => $peserta,
                'nama_mesyuarat' => $nama_mesyuarat,
                'tempat_mesyuarat' => $tempat_mesyuarat,
                'dataProvider' => $dataProvider,
        ]);
    }
    
      public function actionAdminUrusMesyuaratJrtk($nama_mesyuarat=null,$tempat_mesyuarat=null)
    {
        $peserta =  Tblprcobiodata::find()->all();
       
        $dataProvider = new ActiveDataProvider([

            'query' => \app\models\tatatertib_staf\TblUrusMesyuaratJrtk::find(),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        
        $dataProvider->query->orderBy([
         //   new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),
            'id' => SORT_ASC,
            'created_at' => SORT_DESC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['nama_mesyuarat'])){
        $nama_mesyuarat? $dataProvider->query->andFilterWhere(['nama_mesyuarat' => $nama_mesyuarat]):'';}
       
        if(isset(Yii::$app->request->queryParams['tempat_mesyuarat'])){
        $tempat_mesyuarat? $dataProvider->query->andFilterWhere(['tempat_mesyuarat' => $tempat_mesyuarat]):'';}
    
        return $this->render('admin-urus-mesyuarat-jrtk', [
                'peserta' => $peserta,
                'nama_mesyuarat' => $nama_mesyuarat,
                'tempat_mesyuarat' => $tempat_mesyuarat,
                'dataProvider' => $dataProvider,
        ]);
    }
    
 
    public function actionDetailMesyuarat($id) {
       $ahliMeeting = TblAhliMesyuarat::find()->where(['meeting_id' => $id])->all();
       $ahliMeetingLuar = \app\models\tatatertib_staf\TblAccess::find()->where(['meeting_id' => $id])->all();
       $urus = TblUrusMesyuarat::find()->where(['meeting_id' => $id])->one();
             
       if(Yii::$app->request->post('notipegawai')){
               $this->notifipegawai(); 
          }
       
        return $this->render('detail-mesyuarat', ['ahliMeeting' => $ahliMeeting, 'urus' => $urus, 'ahliMeetingLuar' => $ahliMeetingLuar]); 
    }
    
      public function actionTambahAhliMeeting($id) {
       // $icno = Yii::$app->user->getId();
        $meetingbaru = new TblAhliMesyuarat(); //untuk admin baru
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        if ($meetingbaru->load(Yii::$app->request->post())) {
                    if(TblAhliMesyuarat::find()->where( [ 'icno' => $meetingbaru->icno ] )->exists()){ //jika admin sudah wujud
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
                         return $this->redirect(['detail-mesyuarat', 'id' => $id]);
                    }
                    elseif($meetingbaru->kakitangan->CONm != NULL){ //jika icno tidak wujud dalam sistem
                        $meetingbaru->meeting_id = $id;
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                        $this->notification('Tatatertib Staf', "Mesyuarat Jawatankuasa Tatatertib untuk makluman pihak tuan/puan. ".Html::a('Klik Sini', ['admin-post-list-keseluruhan'], ['class' => 'label label-info']), $meetingbaru->icno);
                        $meetingbaru->save();
                    }
                    else{
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
                    
                    }
                    
                    return $this->redirect(['detail-mesyuarat', 'id' => $id]);
                } 
    
        return $this->renderAjax('tambah-ahli-meeting', [
        //    'meeting' => $meeting,
            'meetingbaru' => $meetingbaru,
            'allbiodata' => $allbiodata,
        ]);
         }
         
         
       public function actionAdminTambahMesyuarat() {  
        $urus = new \app\models\tatatertib_staf\TblUrusMesyuarat(); //untuk mesyuarat baru
        $dropdown_list_name = ArrayHelper::map(Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm') ;

         if ($urus->load(Yii::$app->request->post())) {
             $urus->status = 1;
             $urus->created_at = date('Y-m-d H:i:s');
             $urus->save(false);
  
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Disimpan']);   
            return $this->redirect(['admin-urus-mesyuarat']);
        }
        return $this->render('admin-tambah-mesyuarat', ['urus' => $urus, 'dropdown_list_name' => $dropdown_list_name]);
    
    }
    
        
       public function actionAdminTambahMesyuaratJrtk() {  
        $urus = new \app\models\tatatertib_staf\TblUrusMesyuaratJrtk(); //untuk mesyuarat baru
        $dropdown_list_name = ArrayHelper::map(Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm') ;

         if ($urus->load(Yii::$app->request->post())) {
             $urus->status = 1;
             $urus->created_at = date('Y-m-d H:i:s');
             $urus->save(false);
  
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Disimpan']);   
            return $this->redirect(['admin-urus-mesyuarat-jrtk']);
        }
        return $this->render('admin-tambah-mesyuarat-jrtk', ['urus' => $urus, 'dropdown_list_name' => $dropdown_list_name]);
    
    }
    
         public function actionAdminKemaskiniUrusMesyuarat($id) {  
        $urus = TblUrusMesyuarat::find()->where(['meeting_id' => $id])->one(); //untuk mesyuarat baru
        $dropdown_list_name = ArrayHelper::map(Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm') ;

         if ($urus->load(Yii::$app->request->post())) {
             $urus->status = 1;
            /// $urus->created_at = date('Y-m-d H:i:s');
             $urus->save(false);
  
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Dikemaskini']);   
            return $this->redirect(['admin-urus-mesyuarat']);
        }
        return $this->render('admin-kemaskini-urus-mesyuarat', ['urus' => $urus, 'dropdown_list_name' => $dropdown_list_name]);
    
    }
    
        protected function notifipegawai($id){
      //  $ver = Recommendation::find()->where(['type' => 1, 'agree' => null])->all();
        $ver = TblAhliMesyuarat::find()->where(['meeting_id' => $id])->all();
        
        foreach($ver as $ver){
          $this->notification('Tatatertib Staf', "Mesyuarat Jawatankuasa akan diadakan tuan/puan dijemput. ".Html::a('Klik Sini', ['admin-post-list-keseluruhan'], ['class' => 'label label-info']), $ver->icno);
        }
      
 
    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi Berjaya Dihantar']);
    }
      public function actionAdminLihatRekodKakitangan($id)
    {
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $id])->one();
        return $this->render('admin-lihat-rekod-kakitangan',['biodata' => $biodata]);
    }
    
    public function actionRepresentasiBertulis(){
    $icno = Yii::$app->user->getId();
    $biodata = TblRekod::find()->where(['icno' => $icno])->one();
    $sejarah = TblRekod::find()->where(['icno' =>$icno])->all();
    $models = TblRekod::find()->where(['icno' => $icno])->all();

     if ($biodata->load(Yii::$app->request->post())) {
         $biodata->tarikh_hantar_maklumbalas = date('Y-m-d H:i:s');
         $biodata->status_maklumbalas = 1;
         
          $biodata->file = UploadedFile::getInstance($biodata, 'file');
         
            if ($biodata->file) {
                if ($biodata->save(false)){
                    $id = $biodata->id;
                    $res = Yii::$app->FileManager->UploadFile($biodata->file->name, $biodata->file->tempName, '04', 'PTB/Permohonan');

                    if ($res->status == true) {
                        $biodata->file = $res->file_name_hashcode;
                    
                    }
                  
                }
            }
             
            
         $biodata->save(false);
         
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumbalas Berjaya Dihantar']);
        $this->notification('Tatatertib-staf', "Maklumbalas Representasi Bertulis telah Berjaya Dihantar.", $biodata->icno); 
        $this->notification('Tatatertib-staf', "Maklumbalas Representasi Bertulis telah Berjaya Direkodkan.", $biodata->pelulus_icno); 
        return $this->redirect(['representasi-bertulis']);
        }

        return $this->render('representasi-bertulis', [
            'biodata' => $biodata, 'models'=>$models, 'sejarah' => $sejarah
        ]);    
    }
    
     public function actionRayuan(){
    $icno = Yii::$app->user->getId();
    $biodata = TblRekod::find()->where(['icno' => $icno])->one();
    $sejarah = TblRekod::find()->where(['icno' =>$icno])->all();
    $models = TblRekod::find()->where(['icno' => $icno])->all();

     if ($biodata->load(Yii::$app->request->post())) {
        // $biodata->tarikh_hantar_maklumbalas = date('Y-m-d H:i:s');
         $biodata->rayuan = 1;
         
          $biodata->file = UploadedFile::getInstance($biodata, 'file');
         
            if ($biodata->file) {
                if ($biodata->save(false)){
                    $id = $biodata->id;
                    $res = Yii::$app->FileManager->UploadFile($biodata->file->name, $biodata->file->tempName, '04', 'PTB/Permohonan');

                    if ($res->status == true) {
                        $biodata->file = $res->file_name_hashcode;
                    
                    }
                  
                }
            }
             
            
         $biodata->save(false);
         
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumbalas Berjaya Dihantar']);
        $this->notification('Tatatertib-staf', "Rayuan Bertulis telah Berjaya Dihantar.", $biodata->icno); 
        $this->notification('Tatatertib-staf', "Rayuantelah Berjaya Direkodkan.", $biodata->pelulus_icno); 
        return $this->redirect(['representasi-bertulis']);
        }

        return $this->render('rayuan', [
            'biodata' => $biodata, 'models'=>$models, 'sejarah' => $sejarah
        ]);    
    }
    
        public function actionSejarahMaklumbalasKakitangan(){
        $sejarah = TblRekod::find()->where(['icno' => Yii::$app->user->identity])->all();

        return $this->render('sejarah-maklumbalas-kakitangan', [
            'sejarah' => $sejarah
        ]);    
    }
    
 public function actionSuratTunjukSebab($id) 
    {
        $css = file_get_contents('./css/surat.css');
        $biodata = TblRekod::findOne(['id' => $id]);
        $content = $this->renderPartial('_surattunjuksebab', ['biodata'=> $biodata]);

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
//              'SetHeader' => ['SURAT PENEMPATAN'],
//                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                'WriteHTML' => [$css, 1]
//                'SetFooter' => [' {PAGENO}'],
             
            ]
        ]);
      
        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    
        public function actionTindakanBsm()
    {
      
        $query= TblRekod::find()->andFilterWhere(['like', 'pelulus_agree2','1']);
           $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  10
           ],
            
       ]);
           
        return $this->render('tindakan-bsm',['provider' => $provider]);
    }
    
    public function actionHukuman($id){
 //   $icno = Yii::$app->user->getId();
    $model = TblRekod::find()->where(['id' => $id])->one();
   // $sejarah = TblRekod::find()->where(['icno' =>$icno])->all();
   // $models = TblRekod::find()->where(['icno' => $icno])->all();

     if ($model->load(Yii::$app->request->post())) {
        // $biodata->tarikh_hantar_maklumbalas = date('Y-m-d H:i:s');
        // $biodata->rayuan = 1;
  
         $model->save(false);
         
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumbalas Berjaya Disimpan']);
    //    $this->notification('Tatatertib-staf', "Rayuan Bertulis telah Berjaya Dihantar.", $biodata->icno); 
      //  $this->notification('Tatatertib-staf', "Rayuantelah Berjaya Direkodkan.", $biodata->pelulus_icno); 
        return $this->redirect(['representasi-bertulis']);
        }

        return $this->render('hukuman', [
            'model' => $model, 
        ]);    
    }
    
        public function actionHalamanPenyelia()
    {
        $icno = Yii::$app->user->getId();
               $this->layout = "main-penyelia";

        if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            return $this->render('halaman-penyelia', []);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('page-utama');
        }
    }
    
        public function actionRegisterExternalUser($id) 
    {
        $external = new \app\models\system_core\ExternalUser();
        $akses = new \app\models\tatatertib_staf\TblAccess();

        if ($external->load(Yii::$app->request->post())) 
        { 
            $external->save(false);
            $external->user_id = "UMSUSER". str_pad($external->id, 3, "0", STR_PAD_LEFT);
            $external->access = 1;
            $external->pwsd = hash("sha256",$external->username);
            $external->pwsd = 'tatatertib-staf/halaman-penyelia';
            $akses->icno = $external->user_id;
            $akses->name = $external->name;
            $akses->username = $external->username;
            $akses->level = 99;
            $akses->meeting_id = $id;
            $external->save(false);
            $akses->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['detail-mesyuarat', 'id' => $id]);
        
        }
        $list_controllers = Yii::$app->metadata->getControllersActions();
        $temp = [];

        foreach ($list_controllers as $n) {
            $temp[$n] = $n;
        }

        return $this->renderAjax('tambah-akses-luar', ['external'=> $external,'list_controllers' => $temp]);
    }

    
    public function actionKemaskiniAksesLuar($id) 
    {
         $akses = \app\models\tatatertib_staf\TblAccess::find()->where(['id' => $id])->one();

        if ($akses->load(Yii::$app->request->post())) { 
         
            $akses->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan.']);
            return $this->redirect(['detail-mesyuarat', 'id' => $akses->meeting_id]);
        
        }
        return $this->renderAjax('kemaskini-akses-luar', ['akses' => $akses]);
    }
    
        public function actionUpdate($id){
         $model=$this->findModel2($id);
         if ($model->load(Yii::$app->request->post())) {
          $model->save(false);
          Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
           return $this->redirect(['detail-mesyuarat', 'id' => $id]);
              }
        
            return $this->renderAjax('kemaskini-akses-luar', [
                'model' => $model,
               
             
            ]); 
    }
    
    
        public function actionTetapkanMeeting($id) {  
            $tetapan = TblRekod::find()->where(['id' => $id])->one();
   //     $tetapan = TblUrusMesyuarat::find()->where([''])->one();
     //   $dropdown_list_name = ArrayHelper::map(Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm') ;

         if ($tetapan->load(Yii::$app->request->post())) {
           //  $urus->status = 1;
          //   $urus->created_at = date('Y-m-d H:i:s');
             $tetapan->save(false);
  
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Disimpan']);   
            return $this->redirect(['admin-post-list-keseluruhan']);
        }
        return $this->renderAjax('tetapkan-meeting', ['tetapan' => $tetapan]);
    
    }
    
    
        public function actionSenaraiKesTerdahulu() { 
        $icno = Yii::$app->user->getId();
        $rekod = \app\models\tatatertib_staf\TblRekodLama::find()->all();
        
         if (TblAdmin::find()->where(['icno' => $icno])->exists()) {
            return $this->render('senarai-kes-terdahulu', ['rekod' => $rekod]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('index');
        }
        
  
    }
    
        
        public function actionTambahRekodLama() {  
       $rekod = new \app\models\tatatertib_staf\TblRekodLama();
 
         if ($rekod->load(Yii::$app->request->post())) {
                        $rekod->created_at = date('Y-m-d H:i:s');
                        $rekod->save(false);
                        
                        $v = \app\models\tatatertib_staf\TblRekodLama::find()->where(['icno'=> $rekod->icno])->one();
                        $rekod->kategori_jawatan = $v->kakitangan->jawatan->job_category; 
                        $rekod->kumpulan_jawatan = $v->kakitangan->jawatan->job_group; 
                        $rekod->dept_id = $v->kakitangan->department->id;
                        $rekod->campus_id = $v->kakitangan->kampus->campus_id;
                        $rekod->skim_perkhidmatan = $v->kakitangan->jawatan->skimPerkhidmatan->id;
                    
                        $rekod->save(false);
              
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Disimpan']);   
            return $this->redirect(['senarai-kes-terdahulu']);
           }
           
        return $this->renderAjax('tambah-rekod-lama', ['rekod' => $rekod]);
    
    }
    
      public function actionDetailRekodLama($id) { 
      //  $icno = Yii::$app->user->getId();
        $rekod = \app\models\tatatertib_staf\TblRekodLama::find()->where(['id' => $id])->one();
  
          return $this->renderAjax('detail-rekod-lama', ['rekod' => $rekod]);

    }
    
    
       public function actionKemaskiniRekodLama($id) {  
       $rekod = \app\models\tatatertib_staf\TblRekodLama::find()->where(['id' => $id])->one();
 
         if ($rekod->load(Yii::$app->request->post())) {
                        $rekod->created_at = date('Y-m-d H:i:s');
                        $rekod->save(false);

              
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Disimpan']);   
            return $this->redirect(['senarai-kes-terdahulu']);
           }
           
        return $this->renderAjax('kemaskini-rekod-lama', ['rekod' => $rekod]);
    
    }
    
    
          public function actionPadamRekodLama($id)
    {
        $admin = \app\models\tatatertib_staf\TblRekodLama::findOne(['id' => $id]);
        $admin->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['senarai-kes-terdahulu']);
        
    }
    
       public function actionSuratPertuduhan($id){ 
     //  $meeting = TblUrusMesyuarat::find()->all();
       $maklumat = TblRekod::find()->where(['id' => $id])->joinWith('maklumatMeeting')->one();
       $gelarans = \app\models\hronline\Gelaran::find()->where(['TitleCd' => $maklumat->kakitangan->TitleCd])->one();
       $css = file_get_contents('./css/surat.css');
       
       
         
       $content = $this->renderPartial('_suratPertuduhan', ['maklumat' => $maklumat, 'gelarans' => $gelarans]);

    
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
         //     'SetHeader' => ['SURAT PENEMPATAN'],
                 'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
                      'AddPage' => ['0', '1', ],
                     'WriteHTML' => [$css, 1]
             
            ]
        ]);
      
        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    
    
        protected function findModelRekod($id) {

        if (($model = TblRekod::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
      public function actionKeputusanNc($icno=null,$dept_id=null,$campus_id=null,$flag=null)
    {
        $peserta =  Tblprcobiodata::find()->all();
       
        $dataProvider = new ActiveDataProvider([

            'query' => TblRekod::find()->joinWith('dept'),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        
        $dataProvider->query->orderBy([
            new \yii\db\Expression("flag = 1 DESC, flag = 2 DESC, flag = 0 DESC"),
            'id' => SORT_ASC,
            'created_at' => SORT_DESC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
       
        if(isset(Yii::$app->request->queryParams['dept_id'])){
        $dept_id? $dataProvider->query->andFilterWhere(['dept_id' => $dept_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';}
        
        if(isset(Yii::$app->request->queryParams['flag'])){
        isset($flag)? $dataProvider->query->andFilterWhere(['flag' => $flag]):'';}
   

        $models = TblRekod::find()->where(['status_nc' => NULL])->all();
        $selection = (array) Yii::$app->request->post('selection'); //typecasting

        if (Yii::$app->request->post('simpan')) {

            foreach ($models as $data) {
                if ('y' . $data->id == Yii::$app->request->post($data->id)) {
                    $model= $this->findModelRekod($data->id);
                    $model->status_nc = '1';
                    $model->save(false);
//                    return $this->redirect('index');
                } elseif ('n' . $data->id == Yii::$app->request->post($data->id)) {
                    $model= $this->findModelRekod($data->id);
                    $model->status_nc = '2';
                    $model->save(false);
                }
            }
        } elseif (Yii::$app->request->post('hantar')) {
            foreach ($selection as $id) {
                $hantar = $this->findModelRekod($data->id);; //make a typecasting
                if ('n' . $hantar->id == Yii::$app->request->post($hantar->id)) {
                    $hantar->status_nc = '2';
                //    $hantar->status_bsm = 'Tidak Diluluskan';
                  //  $hantar->ver_date = date('Y-m-d H:i:s');

                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan anda tidak berjaya." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                } elseif ('y' . $hantar->id == Yii::$app->request->post($hantar->id)) {
                 //   $hantar->status = 'LULUS';
                    $hantar->status_nc = '2';
               //     $hantar->ver_date = date('Y-m-d H:i:s');
              //      $hantar->ver_by = $icno;
                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan anda berjaya." . Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']));
                }
                $hantar->save(false);
            }
        }

       
    

        return $this->render('keputusan-nc', [
                'peserta' => $peserta,
                'icno' => $icno,
              //  'adminpos_id' => $adminpos_id,
             //   'program_id' => $program_id,
               'dept_id' => $dept_id,
                'campus_id' => $campus_id,
                'flag' => $flag,
                //'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                // 'model' => $dataProvider
        ]);
    }
    
        
    
}
