<?php

namespace app\controllers;
use app\models\memorandum\TblRekod;
use app\models\memorandum\TblRekodSearch;
use app\models\memorandum\TblMaklumbalas;
use app\models\hronline\Tblprcobiodata;
use Yii;
use app\models\memorandum\TblAkses;
use yii\helpers\ArrayHelper;
use app\models\memorandum\RefRole;
use yii\helpers\Html;
use app\models\Notification;
use yii\db\Expression;
use app\models\hronline\Department;
use \app\models\memorandum\TblMaklumbalasPtj;
use app\models\memorandum\TblMaklumbbalasPtjSearch;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\models\ptb\Model;
use app\models\memorandum\TblMakluman;
use yii\web\UploadedFile;
use app\models\memorandum\TblTetapan;
use app\models\memorandum\TblEmel;
use app\models\memorandum\TblPerkara;
use app\models\memorandum\TblTindakan;
use app\models\memorandum\TblPerkaraSearch;
use tebazil\runner\ConsoleCommandRunner;
use kartik\mpdf\Pdf;

class MemorandumController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
        public function notification($title, $content, $ic = null) {
        if ($ic == null) {
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
    
    
    public function actionTambahRekod() {
    $icno = Yii::$app->user->getId();
    $model = new TblRekod();
    
    $department = Department::find()->select(['id' => 'id', 'fullname' => 'CONCAT(shortname," - ",fullname)'])->where(['isActive' => 1])->all();
    $pegawai = Department::find()->select(['id' => 'id', 'chief' => 'CONCAT(shortname," - ",chief)'])->where(['isActive' => 1])->all();

             if ((Yii::$app->request->post()) && ($model->load(Yii::$app->request->post()))) { 
                             
             //----------update table rekod memorandum ---------//
             $model->updated_by = $icno;
             $model->updated = date('Y-m-d H:i:s');
             $model->status = 0;
             $model->tahun =  date('Y', strtotime($model->tarikh_rekod));                
             $model->file = UploadedFile::getInstance($model, 'file');

             if ($model->file) {
                $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '01', 'e-Memorandum');

                if ($datas->status == true) {
                    $model->hashcode = $datas->file_name_hashcode;
                    $model->doc_name = $model->file->name;
                }
            }    
            
               //----------checking date expired cannot awal dari tarikh mesyuarat ---------//    
                  if($model->tarikh_rekod >= $model->tarikh_tamat){
                        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tarikh Akhir Penghantaran Maklumbalas Hendaklah Selepas Tarikh Mesyuarat!']);
                        return $this->redirect(['tambah-rekod']);
                   }
            
              $model->save(false);   
              
            //----------update table tetapan buka/tutup meeting ---------//
              $tetapan = new TblTetapan();
              $tetapan->id_rekod = $model->id;
              $tetapan->tarikh_tutup = $model->tarikh_tamat;
              $tetapan->icno = $model->updated_by;
              $tetapan->updated = $model->updated;
              $tetapan->save(false);
            //----------update table tetapan--------//
              
              
                 //----------update table rekod Pemakluman---------//    
                $modelMakluman = Model::createMultiple(TblPerkara::className());
                Model::loadMultiple($modelMakluman, Yii::$app->request->post());

                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelMakluman)
                    );
                }

 
                $valid = Model::validateMultiple($modelMakluman);

                if ($valid) {

                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
        
                        foreach ($modelMakluman as $modelMaklumans) {
                                 $modelMaklumans->id_rekod = $model->id;
                                 $modelMaklumans->updated = date('Y-m-d H:i:s');
                                 $modelMaklumans->updated_by = $icno;
                                 $modelMaklumans->save(false);
                                 
  
                         //----------send noti pemakluman---------//  
//                            $ntf = new Notification();
//                            $ntf->icno = $modelMaklumans->icno;
//                            $ntf->title = 'e-Memorandum';
//                            $ntf->content = 'Memorandum mesyuarat untuk makluman pihak tuan/puan.'
//                                            .Html::a('<i class="fa fa-arrow-right">Klik Disini</i>', ['view-makluman'],['class' => 'btn btn-primary btn-sm'],$modelMaklumans->icno);
//                             $ntf->ntf_dt = date('Y-m-d H:i:s');
//                             $ntf->save();

                            // $this->Email($model->penyeliaPtj->CONm, $model->penyeliaPtj->COEmail, $model->pegawaiPeraku->CONm, $model->pegawaiPeraku->COEmail, $model->id, $modelMaklumans->kakitangan->COEmail);
                 
                            if (!($flag = $modelMaklumans->save(false))) {
                               $transaction->rollBack();
                                break;
                               
                            }

                        }

                        if ($flag) {


                            $transaction->commit();
                 

                             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
                     //        $this->notification('e-Memorandum', 'Maklumbalas memorandum menunggu tindakan tuan/puan. Sila kemukakan maklumbalas sebelum tarikh akhir penghantaran iaitu pada'.'&nbsp'. $model->tarikhTamat. '.'.'&nbsp'. 'Terima Kasih.'. '&nbsp'.Html::a('Klik Sini', ['memorandum/senarai-memorandum-ptj'], ['class' => 'btn btn-primary btn-sm']), $model->penyelia);
                             
                       //      $this->Email($model->penyeliaPtj->CONm, $model->penyeliaPtj->COEmail, $model->pegawaiPeraku->CONm, $model->pegawaiPeraku->COEmail, $model->id);
                 
                             return $this->redirect(['senarai-memorandum']);
                        }
                    } catch (Exception $e) {

                        $transaction->rollBack();
                    }
                }
            }

        return $this->render('tambah-rekod', ['modelMakluman' => (empty($modelMakluman)) ? [new TblPerkara] : $modelMakluman, 'model' => $model, 'department' => $department, 'pegawai' => $pegawai]);
   
    }
    
    
//    public function actionSenaraiMemorandum() {
//    $icno = Yii::$app->user->getId(); 
//        $checking = TblAkses::findOne(['icno' => $icno, 'role' => 1]);
//         if(!$checking){
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
//            return $this->redirect(['memorandum/dashboard']);
//        }
//    $searchModel = new TblRekodSearch();
//    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//    $dataProvider->query->orderBy(['id' => SORT_ASC]);
//
//    $selection=(array)Yii::$app->request->post('selection');  
//        
//              if (Yii::$app->request->post('simpan'))  {
//
//                foreach ($selection as $permohonanID ){
//
//                $model = TblRekod::findOne(['id' => $permohonanID]);
//                $model->status = Yii::$app->request->post('t'.$model->id);
//                      
//                    if('y'.$model->id == Yii::$app->request->post($model->id)){
//                    $model->status = '1';
//                    }
//                    elseif('n'.$model->id == Yii::$app->request->post($model->id)){
//                    $model->status = null ;
//             }
//             
//                 $model->save(false);
//                 Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
//    
//         }
//                    
//        }
//      
//        return $this->render('senarai-memorandum', [
//                    'dataProvider' => $dataProvider,
//                    'searchModel' => $searchModel
//        ]); 
//    }
    
    
       public function actionSenaraiMemorandum() {
    $icno = Yii::$app->user->getId(); 
        $checking = TblAkses::findOne(['icno' => $icno, 'role' => 1]);
         if(!$checking){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['memorandum/index']);
        }
    $searchModel = new TblPerkaraSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $dataProvider->query->orderBy(['id_rekod' => SORT_ASC]);

    $selection=(array)Yii::$app->request->post('selection');  
        
              if (Yii::$app->request->post('simpan'))  {

                foreach ($selection as $permohonanID ){

                $model = TblPerkara::findOne(['id' => $permohonanID]);
                $model->status = Yii::$app->request->post('t'.$model->id);
                      
                    if('y'.$model->id == Yii::$app->request->post($model->id)){
                    $model->status = '1';
                    }
                    elseif('n'.$model->id == Yii::$app->request->post($model->id)){
                    $model->status = '2' ;
             }
             
                 $model->save(false);
                 Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
    
         }
                    
        }
      
        return $this->render('senarai-memorandum', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]); 
    }
    
    
    public function actionDetailMemorandum($id, $id_perkara) {
       $senarai = TblMaklumbalas::find()->where(['id_rekod' => $id])->andWhere(['id_perkara' => $id_perkara])->all();
       $senaraiPtj = TblMaklumbalasPtj::find()->where(['id_rekod' => $id])->andWhere(['id_perkara' => $id_perkara])->all();
       $senaraiPemakluman = TblMakluman::find()->where(['id_rekod' => $id])->andWhere(['id_perkara' => $id_perkara])->all();
       $tindakan= TblTindakan::find()->where(['id_rekod' => $id])->andWhere(['id_perkara' => $id_perkara])->all();
       
       $model = TblPerkara::find()->joinWith('tblRekod')->where(['memo_tbl_perkara.id' => $id_perkara])->one();

        return $this->render('detail-memorandum', [
            'model' => $model,'senarai' => $senarai, 'senaraiPtj' => $senaraiPtj, 'senaraiPemakluman'=> $senaraiPemakluman, 'tindakan' => $tindakan
        ]);
    }
    
       public function actionTambahMaklumbalas($id_perkara, $id_rekod) {
       $icno = Yii::$app->user->getId();
   //    $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
       $rekod = TblPerkara::find()->where(['id' => $id_perkara])->one();
       $senarai = TblMaklumbalasPtj::find()->where(['id_rekod' => $id_rekod])->andWhere(['id_perkara' => $id_perkara])->all();
       $senarai_urusetia = TblMaklumbalas::find()->where(['id_rekod' => $id_rekod])->all();   
       
        $tindakan = TblTindakan::find()->where(['id_rekod' => $id_rekod])->andWhere(['penyelia' => $icno])->one();
       
       $model = new TblMaklumbalasPtj();
           
         if ($model->load(Yii::$app->request->post())) {
             $model->icno = $tindakan->penyelia;
             $model->tarikh_maklumbalas_ptj = date('Y-m-d H:i:s');
             $model->dept_id = $tindakan->dept_id;
             $model->id_rekod = $id_rekod;
             $model->id_perkara = $id_perkara;
             $model->kj = $tindakan->pegawai_peraku;
             $model->status_kj = 0;
             
             $model->file = UploadedFile::getInstance($model, 'file');

             if ($model->file) {
                $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '01', 'e-Memorandum');

                if ($datas->status == true) {
                    $model->hashcode = $datas->file_name_hashcode;
                    $model->doc_name = $model->file->name;
                }
            }    
            
             $model->save(false);
             
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']); 
           $this->pendingtask($model->kj, 75);
           $this->notification('e-Memorandum', 'Perakuan maklumbalas memorandum jabatan menunggu tindakan tuan/puan.'.Html::a('Klik Sini', ['memorandum/halaman-kj'], ['class' => 'btn btn-primary btn-sm']), $model->kj);
           $this->notification('e-Memorandum', 'Maklumbalas memorandum anda telah berjaya dihantar kepada Pegawai Peraku'.'&nbsp'. $model->pegawaiPeraku->gelaran->Title.'&nbsp'.$model->pegawaiPeraku->CONm. '.'.'&nbsp'. 'Terima Kasih.', $model->icno);
              
           return $this->redirect(['senarai-memorandum-ptj']);
        }
        
        $masa = TblTetapan::find()->where(['id_rekod' => $id_rekod])->one();
        
         if(!$masa){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Urusetia JPU Dalam Proses menetapkan tarikh akhir penghantaran maklumbalas.']);
            return $this->redirect(['memorandum/senarai-memorandum-ptj']);
        }
        
        $today = date('Y-m-d', strtotime(date('Y-m-d')));
        $end = date_format(date_create(date($masa->tarikh_tutup)), 'Y-m-d');

        if ($end == $today){
            $open = "false";
        }else{
            $open = "true";
        }
        
       $options = ["open" => $open]; 
        return $this->render('tambah-maklumbalas', ['masa'=> $masa, 'model' => $model, 'rekod' => $rekod, 'senarai' => $senarai, 'senarai_urusetia' => $senarai_urusetia, 'options' => $options]);
    }
    
     
      
    public function actionTambahAkses() {
        $icno = Yii::$app->user->getId();
        $model = TblAkses::findOne(['icno' => $icno]);
         if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['memorandum/index']);
        }
        $admin = TblAkses::find()->All(); //cari senarai admin
        $adminbaru = new TblAkses; //untuk admin baru
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        $jenisAkses =  ArrayHelper::map(RefRole::find()->all(), 'id', 'name');
          
        if ($adminbaru->load(Yii::$app->request->post())) {
                    if(TblAkses::find()->where( [ 'icno' => $adminbaru->icno ] )->exists()){ //jika admin sudah wujud
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
                    
                    }
                    elseif($adminbaru->kakitangan->CONm != NULL){ //jika icno tidak wujud dalam sistem
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                       $this->notification('e-Memorandum', 'Anda Mendapat Akses sebagai'. '&nbsp'. $adminbaru->jenisAkses->name. '&nbsp'. 'untuk Sistem e-Memorandum.' .  '&nbsp'. Html::a('Klik Sini', ['memorandum/dashboard'], ['class' => 'btn btn-primary btn-sm']), $adminbaru->icno);
              
                         $adminbaru->save(false);
                    }
                    else{
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
                    
                    }
                    
                    return $this->redirect(['memorandum/tambah-akses']);
                }
        if(TblAkses::find()->where( [ 'icno' => Yii::$app->user->getId() ] )->exists()){
        return $this->render('tambah-akses', [
            'admin' => $admin,
            'adminbaru' => $adminbaru,
            'allbiodata' => $allbiodata,'jenisAkses'=>$jenisAkses
        ]);}
    }
    
        public function actionDashboard() {
        
        $array = TblRekod::find()->select([new Expression('COUNT(*) as jml'), 'tarikh_rekod as nama'])->where(['>=', 'tarikh_rekod', new Expression('(DATE(NOW()) - INTERVAL (WEEKDAY(DATE(NOW()))) DAY)')])
                ->andWhere(['<=', 'tarikh_rekod', new Expression('(DATE(NOW() + INTERVAL (6 - WEEKDAY(NOW())) DAY))')])->andWhere(['status' => 2])->groupBy(new Expression('CAST(`tarikh_rekod` as DATE)'))->asArray()->all();

     //   $query = TblRekod::find()->joinWith('department')->select('`dept_id`,count(`dept_id`) AS `_totalCount`')
        
     //   ->andWhere(['=','`department`.`isActive`','1'])->groupBy(['`dept_id`'])->orderBy(['department.fullname' => SORT_ASC]);
         $query = Department::find()->where([ 'isActive' => '1']);
         $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $this->render('dashboard', ['model' => $array, 'dataProvider' => $dataProvider]);
    }
    
    
    public function actionSenaraiMemorandumPtj() {
   $icno = Yii::$app->user->getId();

        
 //   $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
    $searchModel = new TblPerkaraSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 //   $dataProvider->query->joinWith('tblRekod')->joinWith('penyeliaPtj2');
   $dataProvider->query->joinWith('penyeliaPtj2')->andWhere(['memo_tbl_tindakan.penyelia' => $icno]);
   
    $dataProvider->query->orderBy(['id' => SORT_ASC]);
    
    
        return $this->render('senarai-memorandum-ptj', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]); 
    }
    
    
    public function actionKemaskiniMemorandum($id) {
    $icno = Yii::$app->user->getId();
    $model = TblRekod::find()->where(['id' => $id])->one();
    
    $department = Department::find()->select(['id' => 'id', 'fullname' => 'CONCAT(shortname," - ",fullname)'])->where(['isActive' => 1])->all();
    $pegawai = Department::find()->select(['id' => 'id', 'chief' => 'CONCAT(shortname," - ",chief)'])->where(['isActive' => 1])->all();

    
    $modelMakluman = TblPerkara::find()->where(['id_rekod' => $id])->all();

             if ((Yii::$app->request->post()) && ($model->load(Yii::$app->request->post()))) { 
                             
             //----------update table rekod memorandum ---------//
             $model->updated_by = $icno;
             $model->updated = date('Y-m-d H:i:s');
             $model->status = 0;
             $model->tahun =  date('Y', strtotime($model->tarikh_rekod));                
             $model->file = UploadedFile::getInstance($model, 'file');

             if ($model->file) {
                $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '01', 'e-Memorandum');

                if ($datas->status == true) {
                    $model->hashcode = $datas->file_name_hashcode;
                    $model->doc_name = $model->file->name;
                }
            }    
            
               //----------checking date expired cannot awal dari tarikh mesyuarat ---------//    
                  if($model->tarikh_rekod >= $model->tarikh_tamat){
                        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tarikh Akhir Penghantaran Maklumbalas Hendaklah Selepas Tarikh Mesyuarat!']);
                        return $this->redirect(['tambah-rekod']);
                   }
            
              $model->save(false);   
              
            //----------update table tetapan buka/tutup meeting ---------//
               $tetapan = TblTetapan::find()->where(['id_rekod' => $id])->one();
              $tetapan->id_rekod = $model->id;
              $tetapan->tarikh_tutup = $model->tarikh_tamat;
              $tetapan->icno = $model->updated_by;
              $tetapan->updated = $model->updated;
              $tetapan->save(false);
            //----------update table tetapan--------//
              
              
                 //----------update table rekod Pemakluman---------//   
              
            $oldIDs = ArrayHelper::map($modelMakluman, 'id', 'id');
            $modelMakluman = Model::createMultiple(TblPerkara::classname(), $modelMakluman);
            Model::loadMultiple($modelMakluman, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelMakluman, 'id', 'id')));
  
                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelMakluman)
                    );
                }

 
                $valid = Model::validateMultiple($modelMakluman);

                if ($valid) {

                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        
                            if ($flag = ($model->save(false))) {
                       
                        if (!empty($deletedIDs)) {
                            TblPerkara::deleteAll(['id' => $deletedIDs]);
                        }

        
                        foreach ($modelMakluman as $modelMaklumans) {
                                 $modelMaklumans->id_rekod = $model->id;
                                 $modelMaklumans->updated = date('Y-m-d H:i:s');
                                 $modelMaklumans->updated_by = $icno;
                                 $modelMaklumans->save(false);
                                 
  
                         //----------send noti pemakluman---------//  
//                            $ntf = new Notification();
//                            $ntf->icno = $modelMaklumans->icno;
//                            $ntf->title = 'e-Memorandum';
//                            $ntf->content = 'Memorandum mesyuarat untuk makluman pihak tuan/puan.'
//                                            .Html::a('<i class="fa fa-arrow-right">Klik Disini</i>', ['view-makluman'],['class' => 'btn btn-primary btn-sm'],$modelMaklumans->icno);
//                             $ntf->ntf_dt = date('Y-m-d H:i:s');
//                             $ntf->save();

                            // $this->Email($model->penyeliaPtj->CONm, $model->penyeliaPtj->COEmail, $model->pegawaiPeraku->CONm, $model->pegawaiPeraku->COEmail, $model->id, $modelMaklumans->kakitangan->COEmail);
                 
                            if (!($flag = $modelMaklumans->save(false))) {
                               $transaction->rollBack();
                                break;
                               
                            }

                        }
                        
                     }

                        if ($flag) {


                            $transaction->commit();
                 

                             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
                     //        $this->notification('e-Memorandum', 'Maklumbalas memorandum menunggu tindakan tuan/puan. Sila kemukakan maklumbalas sebelum tarikh akhir penghantaran iaitu pada'.'&nbsp'. $model->tarikhTamat. '.'.'&nbsp'. 'Terima Kasih.'. '&nbsp'.Html::a('Klik Sini', ['memorandum/senarai-memorandum-ptj'], ['class' => 'btn btn-primary btn-sm']), $model->penyelia);
                             
                       //      $this->Email($model->penyeliaPtj->CONm, $model->penyeliaPtj->COEmail, $model->pegawaiPeraku->CONm, $model->pegawaiPeraku->COEmail, $model->id);
                 
                             return $this->redirect(['senarai-memorandum']);
                        }
                    } catch (Exception $e) {

                        $transaction->rollBack();
                    }
                }
            }

        return $this->render('kemaskini-memorandum', ['modelMakluman' => (empty($modelMakluman)) ? [new TblPerkara] : $modelMakluman, 'model' => $model, 'department' => $department, 'pegawai' => $pegawai]);
   
    }
    
       
     
       public function actionDetailMaklumbalasPtj($id) {

       $model = TblMaklumbalasPtj::find()->where(['id' => $id])->one();
        return $this->renderAjax('detail-maklumbalas-ptj', [
            'model' => $model
        ]);
    }
    
    
    
       public function actionKemaskiniMaklumbalasPtj($id_perkara, $id_rekod, $id) {
   
       $model = TblMaklumbalasPtj::find()->where(['id' => $id])->one();
             
         if ($model->load(Yii::$app->request->post())) {
             $model->tarikh_maklumbalas_ptj = date('Y-m-d H:i:s');
                  $model->file = UploadedFile::getInstance($model, 'file');

             if ($model->file) {
                $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '01', 'e-Memorandum');

                if ($datas->status == true) {
                    $model->hashcode = $datas->file_name_hashcode;
                    $model->doc_name = $model->file->name;
                }
            }    
             $model->save(false);
             
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);    
           $this->notification('e-Memorandum', 'Perakuan maklumbalas memorandum jabatan menunggu tindakan tuan/puan.'.Html::a('Klik Sini', ['memorandum/halaman-kj'], ['class' => 'btn btn-primary btn-sm']), $model->kj);
           $this->notification('e-Memorandum', 'Maklumbalas memorandum anda telah berjaya dihantar kepada Pegawai Peraku'.'&nbsp'. $model->pegawaiPeraku->gelaran->Title.'&nbsp'.$model->pegawaiPeraku->CONm. '.'.'&nbsp'. 'Terima Kasih.', $model->icno);
          
            
           return $this->redirect(['tambah-maklumbalas', 'id_rekod' => $id_rekod, 'id_perkara' => $id_perkara]);
        } 

        return $this->render('kemaskini-maklumbalas-ptj', [
                                'model' => $model
        ]);
    }
    
    
    public function actionHalamanKj() {
    $icno = Yii::$app->user->getId();
    $searchModel = new TblMaklumbbalasPtjSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
   // $dataProvider->query->andWhere(['kj' =>$icno ])->orderBy(['id' => SORT_ASC]);
    $dataProvider->query->joinWith('tblPerkara')->andWhere(['memo_tbl_maklumbalas_ptj.kj' => $icno])->orderBy(['id_rekod' => SORT_ASC]);

        return $this->render('halaman-kj', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]); 
    }
    
    
    public function actionPerakuanKj($id) {
      $model = TblMaklumbalasPtj::find()->where(['id' => $id])->one();
            
         if ($model->load(Yii::$app->request->post())) {
             $model->tarikh_perakuan = date('Y-m-d H:i:s');
             $model->save(false);
                
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);    
           $this->notification('e-Memorandum', 'Maklumbalas memorandum daripada Pegawai Peraku telah diambil tindakan.'.Html::a('Klik Sini', ['memorandum/senarai-memorandum-ptj'], ['class' => 'btn btn-primary btn-sm']), $model->icno);
           $this->notification('e-Memorandum', 'Maklumbalas memorandum daripada Pegawai Peraku bagi'.'&nbsp'. $model->kakitangan->department->fullname . '&nbsp'.  'untuk makluman pihak tuan/puan.'.Html::a('Klik Sini', ['memorandum/senarai-memorandum'], ['class' => 'btn btn-primary btn-sm']), $model->tblRekod->updated_by);

           return $this->redirect(['halaman-kj']);
        } 
        
        $masa = TblTetapan::find()->where(['id_rekod' => $model->id_rekod])->one();
//        
//         if(!$masa){
//            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Urusetia JPU Dalam Proses menetapkan tarikh akhir penghantaran maklumbalas.']);
//            return $this->redirect(['memorandum/senarai-memorandum-ptj']);
//        }
        
        $today = date('Y-m-d', strtotime(date('Y-m-d')));
        $end = date_format(date_create(date($masa->tarikh_tutup)), 'Y-m-d');

        if ($end == $today){
            $open = "false";
        }else{
            $open = "true";
        }
        
       $options = ["open" => $open]; 
       
        return $this->render('perakuan-kj', ['model' => $model, 'options' => $options, 'masa' => $masa]);
    }
    
       public function actionTambahMaklumbalasUrusetia($id, $id_perkara) {
       $icno = Yii::$app->user->getId();
       $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
       $rekod = TblPerkara::find()->where(['id_rekod' => $id])->one();
       $senarai = TblMaklumbalasPtj::find()->where(['id_rekod' => $id])->andWhere(['id_perkara' => $id_perkara])->all();
       $senarai_urusetia = TblMaklumbalas::find()->where(['id_rekod' => $id])->all();   
       
       $tindakan = TblTindakan::find()->where(['id_rekod' => $id])->one();
       
      $penyelia = TblMaklumbalasPtj::find()->where(['id_rekod' => $id])->andWhere(['id_perkara' => $id_perkara])->all();
         
         
       $model = new TblMaklumbalas();
           
         if ($model->load(Yii::$app->request->post())) {
             $model->icno = $icno;
             $model->tarikh_maklumbalas = date('Y-m-d H:i:s');
             $model->dept_id = $biodata->DeptId;
             $model->id_rekod = $id;
             $model->id_perkara = $id_perkara;
             
             $model->file = UploadedFile::getInstance($model, 'file');

             if ($model->file) {
                $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '01', 'e-Memorandum');

                if ($datas->status == true) {
                    $model->hashcode = $datas->file_name_hashcode;
                    $model->doc_name = $model->file->name;
                }
            }    
            
             $model->save(false);
             
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar']); 
          
           
                 foreach ($penyelia as $penyelia) {
               
                         //----------send noti pemakluman---------//  
                            $ntf = new Notification();
                            $ntf->icno = $penyelia->icno;
                            $ntf->title = 'e-Memorandum';
                            $ntf->content = ' Maklumbalas Memorandum Urus Setia JPU untuk makluman pihak tuan/puan.'. '&nbsp'
                                            .Html::a('<i class="fa fa-arrow-right">Klik Disini</i>', ['memorandum/senarai-memorandum-ptj'],['class' => 'btn btn-primary btn-sm'],$penyelia->icno);
                             $ntf->ntf_dt = date('Y-m-d H:i:s');
                             $ntf->save();
                         //----------send noti pemakluman---------//  
                             
                             
                              //----------send noti pemakluman---------//  
                            $ntf2 = new Notification();
                            $ntf2->icno = $penyelia->kj;
                            $ntf2->title = 'e-Memorandum';
                            $ntf2->content = ' Maklumbalas Memorandum Urus Setia JPU untuk makluman pihak tuan/puan.'. '&nbsp'
                                            .Html::a('<i class="fa fa-arrow-right">Klik Disini</i>', ['memorandum/halaman-kj'],['class' => 'btn btn-primary btn-sm'],$penyelia->kj);
                             $ntf2->ntf_dt = date('Y-m-d H:i:s');
                             $ntf2->save();
                         //----------send noti pemakluman---------//  
                                          
                  }
           
           
        //   $this->notification('e-Memorandum', 'Maklumbalas memorandum Urusetia untuk makluman pihak tuan/puan.'.Html::a('Klik Sini', ['memorandum/senarai-memorandum-ptj'], ['class' => 'btn btn-primary btn-sm']), $model->icno);
      //       $this->notification('e-Memorandum', 'Maklumbalas memorandum Urusetia untuk makluman pihak tuan/puan.'.Html::a('Klik Sini', ['memorandum/halaman-kj'], ['class' => 'btn btn-primary btn-sm']), $model->tblRekod->kj); 
     //      $this->notification('e-Memorandum', 'Perakuan maklumbalas memorandum jabatan menunggu tindakan tuan/puan.'.Html::a('Klik Sini', ['memorandum/halaman-kj'], ['class' => 'btn btn-primary btn-sm']), $model->kj);
      //     $this->notification('e-Memorandum', 'Maklumbalas memorandum anda telah berjaya dihantar kepada Pegawai Peraku'.'&nbsp'. $model->pegawaiPeraku->gelaran->Title.'&nbsp'.$model->pegawaiPeraku->CONm. '.'.'&nbsp'. 'Terima Kasih.', $model->icno);
            
           
           return $this->redirect(['senarai-memorandum']);
        } 
        return $this->render('tambah-maklumbalas-urusetia', ['model' => $model, 'rekod' => $rekod, 'senarai' => $senarai, 'senarai_urusetia' => $senarai_urusetia, 'tindakan'=> $tindakan, 'penyelia'=>$penyelia]);
    }
    
        
       public function actionKemaskiniMaklumbalasUrusetia($id) {

         $model = TblMaklumbalas::find()->where(['id' => $id])->one();
             
         if ($model->load(Yii::$app->request->post())) {
             $model->tarikh_maklumbalas = date('Y-m-d H:i:s');
             
              $model->file = UploadedFile::getInstance($model, 'file');

             if ($model->file) {
                $datas = Yii::$app->FileManager->UploadFile($model->file->name, $model->file->tempName, '01', 'e-Memorandum');

                if ($datas->status == true) {
                    $model->hashcode = $datas->file_name_hashcode;
                    $model->doc_name = $model->file->name;
                }
            }    
             $model->save(false);
             
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);    
           $this->notification('e-Memorandum', 'Maklumbalas memorandum Urusetia untuk makluman pihak tuan/puan.'.Html::a('Klik Sini', ['memorandum/senarai-memorandum-ptj'], ['class' => 'btn btn-primary btn-sm']), $model->tblRekod->penyelia);
            
           return $this->redirect(['tambah-maklumbalas-urusetia', 'id' => $model->id_rekod]);
        } 

        return $this->render('kemaskini-maklumbalas-urusetia', [
                                'model' => $model
        ]);
    }
    
     
    public function actionViewAhliJpu() {
    $icno = Yii::$app->user->getId();
      $checking = TblAkses::findOne(['icno' => $icno, 'role' => [1,3]]);
         if(!$checking){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['memorandum/index']);
        }

        $searchModel = new TblPerkaraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy(['id_rekod' => SORT_ASC]);

    
    
        return $this->render('view-ahli-jpu', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]); 
    }
    
    
       public function actionTambahTetapan(){
        $icno = Yii::$app->user->getId();
        $model = new TblTetapan();
        
        $senarai = TblTetapan::find()->all();
        $rekod = TblRekod::find()->select(['id' => 'id', 'bil_jpu' => 'CONCAT(bil_jpu," KALI KE- ",kali_ke)'])->where(['status' => 0])->all();

                
        if ($model->load(Yii::$app->request->post())) {
            
            $model->icno = $icno;
            $model->updated = date('Y-m-d H:i:s');
            
//                    if($model->tarikh_buka >= $model->tarikh_tutup){
//                        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tarikh ditutup hendaklah selepas tarikh dibuka!']);
//                        return $this->redirect(['tambah-tetapan']);
//                    }
//            
            if ($model->save(false)) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['tambah-tetapan']);
            }else{
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Gagal mengemaskini tetapan!']);
                return $this->redirect(['tambah-tetapan']);
            }
        }

        return $this->render('tambah-tetapan',compact('model','senarai','rekod'));
    }
    
    
       public function actionKemaskiniTetapan($id){
        $icno = Yii::$app->user->getId();
        $model = TblTetapan::find()->where(['id' => $id])->one();

        $rekod = TblRekod::find()->select(['id' => 'id', 'bil_jpu' => 'CONCAT(bil_jpu," KALI KE- ",kali_ke)'])->where(['status' => 0])->all();

        $tblRekod = TblRekod::find()->where(['id' => $model->id_rekod])->one();
        
        $check = TblMaklumbalasPtj::find()->where(['id_rekod' => $model->id_rekod])->one();
     
        
        if ($model->load(Yii::$app->request->post())) {
            
            $model->icno = $icno;
            $model->updated = date('Y-m-d H:i:s');
            $model->save(false);
            
//                    if($model->tarikh_buka >= $model->tarikh_tutup){
//                        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Tarikh ditutup hendaklah selepas tarikh dibuka!']);
//                        return $this->redirect(['tambah-tetapan']);
//                    } 
            
          $tblRekod->tarikh_tamat = $model->tarikh_tutup;
          $tblRekod->save(false);
 
          Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
          $this->notification('e-Memorandum', 'Tarikh Akhir Penghantaran Maklumbalas Memorandum berjaya dikemaskini.', $model->icno);
          
          
        if(!$check){
        $tblTindakan = TblTindakan::find()->where(['memo_tbl_tindakan.id_rekod' => $model->id_rekod])
                                         // ->andWhere(['not exists', 'memo_tbl_maklumbalas_ptj.id_rekod', $model->id_rekod])
                                          ->all();
        
             foreach ($tblTindakan as $tblTindakan) {
             //----------send noti pemakluman---------//  
                            $ntf = new Notification();
                            $ntf->icno = $tblTindakan->penyelia;
                            $ntf->title = 'e-Memorandum';
                            $ntf->content = ' Maklumbalas memorandum menunggu tindakan tuan/puan. Sila kemukakan maklumbalas sebelum tarikh akhir penghantaran iaitu pada'.'&nbsp'. $tblRekod->tarikhTamat. '.'.'&nbsp'. 'Terima Kasih.'. '&nbsp'
                                            .Html::a('<i class="fa fa-arrow-right">Klik Disini</i>', ['memorandum/senarai-memorandum-ptj'],['class' => 'btn btn-primary btn-sm'],$tblTindakan->penyelia);
                             $ntf->ntf_dt = date('Y-m-d H:i:s');
                             $ntf->save();
             //----------send noti pemakluman---------//  
           }  
           
           
        }else{
            $tblTindakan2 = TblMaklumbalasPtj::find()->where(['memo_tbl_maklumbalas_ptj.id_rekod' => $model->id_rekod])
                                         // ->andWhere(['not exists', 'memo_tbl_maklumbalas_ptj.id_rekod', $model->id_rekod])
                                          ->all();
            
                      foreach ($tblTindakan2 as $tblTindakan2) {
             //----------send noti pemakluman---------//  
                            $ntf = new Notification();
                            $ntf->icno = $tblTindakan2->icno;
                            $ntf->title = 'e-Memorandum';
                            $ntf->content = ' Tarikh Akhir Penghantaran Maklumbalas telah dikemaskini oleh Urusetia JPU iaitu pada'.'&nbsp'. $tblRekod->tarikhTamat. '.'.'&nbsp'. 'Terima Kasih.'. '&nbsp'
                                            .Html::a('<i class="fa fa-arrow-right">Klik Disini</i>', ['memorandum/senarai-memorandum-ptj'],['class' => 'btn btn-primary btn-sm'],$tblTindakan2->icno);
                             $ntf->ntf_dt = date('Y-m-d H:i:s');
                             $ntf->save();
             //----------send noti pemakluman---------//  
           }  
           
           
        }
          
          return $this->redirect(['tambah-tetapan']);
       
      }
        return $this->render('kemaskini-tetapan', ['model' => $model, 'rekod' => $rekod]);
    }
    
    
        public function actionPadamTetapan($id) {
        $model = TblTetapan::find()->where(['id' => $id])->one();
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['tambah-tetapan']);
    }
    
    
         public function actionViewMakluman() {
         $icno = Yii::$app->user->getId();
      //   $biodata = TblRekod::find()->where(['id' => $icno])->one();
         $checking = TblMakluman::findOne(['icno' => $icno]);
         if(!$checking){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['memorandum/index']);
        }

        $searchModel = new TblPerkaraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //    $dataProvider->query->joinWith('penyeliaPtj2')->andWhere(['memo_tbl_tindakan.penyelia' => $icno]);
        $dataProvider->query->joinWith('pemakluman')->andWhere(['memo_tbl_makluman.icno' => $icno])->orderBy(['id_rekod' => SORT_ASC]);

        return $this->render('view-makluman', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]); 
    }
    
     public function actionStatistik() {
        $model = Department::find()
                ->where([ 'isActive' => '1']);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);

        return $this->render('statistik', ['dataProvider' => $dataProvider
        ]);
    }
    
    
        public function Email($name, $email, $kj_name, $kj_email, $id_rekod) {

        $model = TblRekod::find()->where(['id' => $id_rekod])->one();
       
     //   $icno_tindakan = TblTindakan::find()->where(['id_rekod' => $id_rekod])->all();
         
        try {
      //      foreach ($icno_tindakan as $icno_tindakan) {
            Yii::$app->mailer4->compose('email_memorandum', ['model' => $model])
                    ->setFrom('jpu-noreply@ums.edu.my')
              //    ->setSubject("PETIKAN MINIT JPU BIL.".'<br>'.$model->bil_jpu.'<br>'."KALI KE-".$model->kali_ke.'<br>'. strtoupper($model->tarikhTamat). '<br>'. strtoupper($model->perkara))
                    ->setSubject('MEMORANDUM PELAKSANAAN MESYUARAT JPU')
                    ->setTo('jpu@ums.edu.my')
                    ->setCc(array($email,$kj_email ))
                    ->send();

          $mail_status = 1;
        
    //   }
             }catch (Exception $e) {
              $mail_status = 0;
        }
        

        $emel = new TblEmel();
        $emel->from_name = 'e-Memorandum JPU';
        $emel->from_email = 'jpu-noreply@ums.edu.my';
        $emel->id_rekod = $id_rekod;
        $emel->to_name = $name;
        $emel->to_email = $email;
           $emel->kj_name = $kj_name;
           $emel->kj_email = $kj_email;
       // $emel->subject = "PETIKAN MINIT JPU BIL.".'<br>'.$model->bil_jpu.'<br>'."KALI KE-".$model->kali_ke.'<br>'. strtoupper($model->tarikhTamat). '<br>'. strtoupper($model->perkara);
        $emel->subject = 'MEMORANDUM PELAKSANAAN MESYUARAT JPU';
        $emel->success = $mail_status;
        $emel->date_published = date('Y-m-d H:i:s');
        $emel->save();
        
//
//    $icno_makluman = TblMakluman::find()->where(['id_rekod' => $id_rekod])->all();       
//     foreach ($icno_makluman as $icno_makluman) {
//        $emel2 = new TblEmel();
//        $emel2->from_name = 'e-Memorandum';
//        $emel2->from_email = 'hafizah.hassan@ums.edu.my';
//        $emel2->id_rekod = $icno_makluman->id_rekod;
//        $emel2->to_name = $icno_makluman->kakitangan->CONm;
//        $emel2->to_email = $icno_makluman->kakitangan->COEmail;
//        $emel2->kj_name = $kj_name;
//        $emel2->kj_email = $kj_email;
//      //  $emel2->subject = "PETIKAN MINIT JPU BIL.".'<br>'.$model->bil_jpu.'<br>'."KALI KE-".$model->kali_ke.'<br>'. strtoupper($model->tarikhTamat). '<br>'. strtoupper($model->perkara);
//        $emel2->subject = 'MEMORANDUM PELAKSANAAN MESYUARAT JPA';
//        $emel2->success = $mail_status;
//        $emel2->date_published = date('Y-m-d H:i:s');
//        $emel2->save();
//             
//        }
    }
    
    
         public function Email2($name, $email, $id_rekod) {

        $model = TblRekod::find()->where(['id' => $id_rekod])->one();
       
     //   $icno_tindakan = TblMakluman::find()->where(['id_rekod' => $id_rekod])->all();
         
        try {
       //     foreach ($icno_tindakan as $icno_tindakan) {
            Yii::$app->mailer4->compose('email_memorandum_pemakluman', ['model' => $model])
                    ->setFrom('jpu-noreply@ums.edu.my')
              //    ->setSubject("PETIKAN MINIT JPU BIL.".'<br>'.$model->bil_jpu.'<br>'."KALI KE-".$model->kali_ke.'<br>'. strtoupper($model->tarikhTamat). '<br>'. strtoupper($model->perkara))
                    ->setSubject('MEMORANDUM PELAKSANAAN MESYUARAT JPU')
                    ->setTo('jpu@ums.edu.my')
                    ->setCc(array($email))
                    ->send();

          $mail_status = 1;
        
   //    }
             }catch (Exception $e) {
              $mail_status = 0;
        }

    //$icno_makluman = TblMakluman::find()->where(['id_rekod' => $id_rekod])->all();  
    
  //   foreach ($icno_makluman as $icno_makluman) {
        $emel2 = new TblEmel();
        $emel2->from_name = 'e-Memorandum JPU';
        $emel2->from_email = 'jpu-noreply@ums.edu.my';
        $emel2->id_rekod = $id_rekod;
        $emel2->to_name = $name;
        $emel2->to_email = $email;
     //   $emel2->kj_name = $kj_name;
    //    $emel2->kj_email = $kj_email;
      //  $emel2->subject = "PETIKAN MINIT JPU BIL.".'<br>'.$model->bil_jpu.'<br>'."KALI KE-".$model->kali_ke.'<br>'. strtoupper($model->tarikhTamat). '<br>'. strtoupper($model->perkara);
        $emel2->subject = 'MEMORANDUM PELAKSANAAN MESYUARAT JPU';
        $emel2->success = $mail_status;
        $emel2->date_published = date('Y-m-d H:i:s');
        $emel2->save();
             
    //    }
    }
    
    
        public function actionTambahTindakan() {
        // $icno = Yii::$app->user->getId();  
       // $deskripsi = TblRekod::find()->where->one();
        $model = TblPerkara::find()->all();
//        $models = TblTugasUtama::find()->where(['akauntabiliti_id' => $akauntabiliti->id])->all();
//        if (Tblportfolio::find()->where(['id' => $id])->exists()) {
//            $display = '';
//        } else {
//            $display = 'none';
//        }
        return $this->render('tambah-tindakan', ['model' => $model]);
    }
    
    
  public function actionTambahTindakanJafpib($id_rekod, $id) {
  
    $icno = Yii::$app->user->getId();

    $model = TblRekod::find()->where(['id' => $id_rekod])->one();
    $perkara = TblPerkara::find()->where(['id_rekod' => $id_rekod, 'id' => $id])->one();
    
    $department = Department::find()->select(['id' => 'id', 'fullname' => 'CONCAT(shortname," - ",fullname)'])->where(['isActive' => 1])->all();
    $pegawai = Department::find()->select(['id' => 'id', 'chief' => 'CONCAT(shortname," - ",chief)'])->where(['isActive' => 1])->all();

             if ((Yii::$app->request->post())) { 
                             
                       
                 //----------update table Tindakan JAFPIB---------//    
                $modelMakluman = Model::createMultiple(TblTindakan::className());
                Model::loadMultiple($modelMakluman, Yii::$app->request->post());

                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelMakluman)
                    );
                }

 
                $valid = Model::validateMultiple($modelMakluman);

                if ($valid) {

                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
        
                        foreach ($modelMakluman as $modelMaklumans) {
                                 $modelMaklumans->id_rekod = $perkara->id_rekod;
                                 $modelMaklumans->id_perkara = $perkara->id;
                                 $modelMaklumans->updated = date('Y-m-d H:i:s');
                                 $modelMaklumans->updated_by = $icno;
                                 $modelMaklumans->save(false);
                                 
  
                         //----------send noti pemakluman---------//  
                            $ntf = new Notification();
                            $ntf->icno = $modelMaklumans->penyelia;
                            $ntf->title = 'e-Memorandum';
                            $ntf->content = ' Maklumbalas memorandum menunggu tindakan tuan/puan. Sila kemukakan maklumbalas sebelum tarikh akhir penghantaran iaitu pada'.'&nbsp'. $model->tarikhTamat. '.'.'&nbsp'. 'Terima Kasih.'. '&nbsp'
                                            .Html::a('<i class="fa fa-arrow-right">Klik Disini</i>', ['memorandum/senarai-memorandum-ptj'],['class' => 'btn btn-primary btn-sm'],$modelMaklumans->penyelia);
                             $ntf->ntf_dt = date('Y-m-d H:i:s');
                             $ntf->save();
                         //----------send noti pemakluman---------//  
                                          

                          $this->Email($modelMaklumans->penyelia2->CONm, $modelMaklumans->penyelia2->COEmail, $modelMaklumans->pegawaiPeraku->CONm, $modelMaklumans->pegawaiPeraku->COEmail, $modelMaklumans->id_rekod);
                 
                            if (!($flag = $modelMaklumans->save(false))) {
                               $transaction->rollBack();
                                break;
                               
                            }

                        }

                        if ($flag) {


                            $transaction->commit();
                 
                             $this->pendingtask($modelMaklumans->penyelia, 76);
                             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar']);
                             $this->notification('e-Memorandum', 'Tindakan Memorandum JAFPIB berjaya dihantar.'. $icno);   
                       
                       //      $this->Email($model->penyeliaPtj->CONm, $model->penyeliaPtj->COEmail, $model->pegawaiPeraku->CONm, $model->pegawaiPeraku->COEmail, $model->id);
                 
                             return $this->redirect(['tambah-tindakan']);
                        }
                    } catch (Exception $e) {

                        $transaction->rollBack();
                    }
                }
            }

        return $this->render('tambah-tindakan-jafpib', ['modelMakluman' => (empty($modelMakluman)) ? [new TblTindakan()] : $modelMakluman, 'model' => $model, 'department' => $department, 'pegawai' => $pegawai, 'perkara' => $perkara]);
   
    }
          
             
            
   public function actionKemaskiniTindakanJafpib($id_rekod, $id) {
  
    $icno = Yii::$app->user->getId();

    $model = TblRekod::find()->where(['id' => $id_rekod])->one();
    $perkara = TblPerkara::find()->where(['id_rekod' => $id_rekod, 'id' => $id])->one();
    
    $department = Department::find()->select(['id' => 'id', 'fullname' => 'CONCAT(shortname," - ",fullname)'])->where(['isActive' => 1])->all();
    $pegawai = Department::find()->select(['id' => 'id', 'chief' => 'CONCAT(shortname," - ",chief)'])->where(['isActive' => 1])->all();

    $modelMakluman = TblTindakan::find()->where(['id_rekod' => $id_rekod, 'id' => $id])->all();
     
     
             if ((Yii::$app->request->post())) { 
                             
                       
                 //----------update table Tindakan JAFPIB---------//   
                 
                $oldIDs = ArrayHelper::map($modelMakluman, 'id', 'id');
                $modelMakluman = Model::createMultiple(TblTindakan::classname(), $modelMakluman);
                Model::loadMultiple($modelMakluman, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelMakluman, 'id', 'id')));
                
              //  $modelMakluman = Model::createMultiple(TblTindakan::className());
             //   Model::loadMultiple($modelMakluman, Yii::$app->request->post());

                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelMakluman)
                    );
                }

 
                $valid = Model::validateMultiple($modelMakluman);

                if ($valid) {

                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        
                         if ($flag = ($model->save(false))) {
                       
                        if (!empty($deletedIDs)) {
                            TblTindakan::deleteAll(['id' => $deletedIDs]);
                        }
        
                        foreach ($modelMakluman as $modelMaklumans) {
                                 $modelMaklumans->id_rekod = $perkara->id_rekod;
                                 $modelMaklumans->id_perkara = $perkara->id;
                                 $modelMaklumans->updated = date('Y-m-d H:i:s');
                                 $modelMaklumans->updated_by = $icno;
                                 $modelMaklumans->save(false);
                                 
  
                         //----------send noti pemakluman---------//  
                            $ntf = new Notification();
                            $ntf->icno = $modelMaklumans->penyelia;
                            $ntf->title = 'e-Memorandum';
                            $ntf->content = ' Maklumbalas memorandum menunggu tindakan tuan/puan. Sila kemukakan maklumbalas sebelum tarikh akhir penghantaran iaitu pada'.'&nbsp'. $model->tarikhTamat. '.'.'&nbsp'. 'Terima Kasih.'. '&nbsp'
                                            .Html::a('<i class="fa fa-arrow-right">Klik Disini</i>', ['memorandum/senarai-memorandum-ptj'],['class' => 'btn btn-primary btn-sm'],$modelMaklumans->penyelia);
                             $ntf->ntf_dt = date('Y-m-d H:i:s');
                             $ntf->save();
                         //----------send noti pemakluman---------//  
                                          

                       //   $this->Email($modelMaklumans->penyelia2->CONm, $modelMaklumans->penyelia2->COEmail, $modelMaklumans->pegawaiPeraku->CONm, $modelMaklumans->pegawaiPeraku->COEmail, $modelMaklumans->id_rekod);
                 
                            if (!($flag = $modelMaklumans->save(false))) {
                               $transaction->rollBack();
                                break;
                               
                            }

                        }
                        
                    }

                        if ($flag) {


                            $transaction->commit();
                 
                             $this->pendingtask($modelMaklumans->penyelia, 76);
                             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar']);
                             $this->notification('e-Memorandum', 'Tindakan Memorandum JAFPIB berjaya dihantar.'. $icno);   
                       
                       //      $this->Email($model->penyeliaPtj->CONm, $model->penyeliaPtj->COEmail, $model->pegawaiPeraku->CONm, $model->pegawaiPeraku->COEmail, $model->id);
                 
                             return $this->redirect(['tambah-tindakan']);
                        }
                    } catch (Exception $e) {

                        $transaction->rollBack();
                    }
                }
            }

        return $this->render('kemaskini-tindakan-jafpib', ['modelMakluman' => (empty($modelMakluman)) ? [new TblTindakan()] : $modelMakluman, 'model' => $model, 'department' => $department, 'pegawai' => $pegawai, 'perkara' => $perkara]);
   
    }
    
    
     public function actionTambahPemakluman($id_rekod, $id) {
    $icno = Yii::$app->user->getId();

    //$model = TblRekod::find()->where(['id' => $id_rekod])->one();
    $perkara = TblPerkara::find()->where(['id_rekod' => $id_rekod, 'id' => $id])->one();
    
    $department = Department::find()->select(['id' => 'id', 'fullname' => 'CONCAT(shortname," - ",fullname)'])->where(['isActive' => 1])->all();
    $pegawai = Department::find()->select(['id' => 'id', 'chief' => 'CONCAT(shortname," - ",chief)'])->where(['isActive' => 1])->all();

             if ((Yii::$app->request->post())) { 
                             
                       
                 //----------update table Tindakan JAFPIB---------//    
                $modelMakluman = Model::createMultiple(TblMakluman::className());
                Model::loadMultiple($modelMakluman, Yii::$app->request->post());

                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelMakluman)
                    );
                }

 
                $valid = Model::validateMultiple($modelMakluman);

                if ($valid) {

                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
        
                        foreach ($modelMakluman as $modelMaklumans) {
                                 $modelMaklumans->id_rekod = $perkara->id_rekod;
                                 $modelMaklumans->id_perkara = $perkara->id;
                                 $modelMaklumans->updated = date('Y-m-d H:i:s');
                                 $modelMaklumans->updated_by = $icno;
                                 $modelMaklumans->save(false);
                                 
  
                         //----------send noti pemakluman---------//  
                            $ntf = new Notification();
                            $ntf->icno = $modelMaklumans->icno;
                            $ntf->title = 'e-Memorandum';
                            $ntf->content = ' Memorandum mesyuarat untuk makluman pihak tuan/puan.'
                                            .Html::a('<i class="fa fa-arrow-right">Klik Disini</i>', ['view-makluman'],['class' => 'btn btn-primary btn-sm'],$modelMaklumans->icno);
                             $ntf->ntf_dt = date('Y-m-d H:i:s');
                             $ntf->save();
                         //----------send noti pemakluman---------//  
                                          
                          $this->Email2($modelMaklumans->kakitangan->CONm, $modelMaklumans->kakitangan->COEmail, $modelMaklumans->id_rekod);
                 
                            if (!($flag = $modelMaklumans->save(false))) {
                               $transaction->rollBack();
                                break;
                               
                            }

                        }

                        if ($flag) {


                            $transaction->commit();
                 

                             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar']);
                             $this->notification('e-Memorandum', 'Pemakluman Memorandum berjaya dihantar.'. $icno);
                             
                       //      $this->Email($model->penyeliaPtj->CONm, $model->penyeliaPtj->COEmail, $model->pegawaiPeraku->CONm, $model->pegawaiPeraku->COEmail, $model->id);
                 
                             return $this->redirect(['tambah-tindakan']);
                        }
                    } catch (Exception $e) {

                        $transaction->rollBack();
                    }
                }
            }

        return $this->render('tambah-pemakluman', ['modelMakluman' => (empty($modelMakluman)) ? [new TblMakluman()] : $modelMakluman,  'department' => $department, 'pegawai' => $pegawai, 'perkara' => $perkara]);
   
    }
    
    
       protected function pendingtask($icno, $id) {
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }
    
       public function actionJanaIndex($id) {

        $model = TblPerkara::find()->where(['id' => $id])->one();
        $senarai = TblPerkara::find()->where(['id' => $id])->all();
        
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('jana-index', ['model' => $model, 'senarai' => $senarai]);


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
            'options' => ['title' => 'e-Memorandum JPU'],
            'marginTop' => 1,
            'marginLeft' => 24,
            'marginRight' => 24,
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => [''],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    
    
    
     public function actionJanaPelaporan($bil_jpu) {

        $model = TblRekod::find()->where(['bil_jpu' => $bil_jpu])->one();
        $senarai = TblRekod::find()->where(['bil_jpu' => $bil_jpu])->orderBy(['sort' => SORT_ASC])->all();
        
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('jana-pelaporan', [ 'model' => $model, 'senarai' => $senarai]);


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
            'options' => ['title' => 'e-Memorandum JPU'],
            'marginTop' => 1,
            'marginLeft' => 24,
            'marginRight' => 24,
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => [''],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    
    
       public function actionSenaraiPelaporan(){
       $senarai = TblRekod::find()->groupBy('bil_jpu')->all();

        return $this->render('senarai-pelaporan',compact('senarai'));
    }
    
    
       public function actionSorting($bil_jpu){
         $model = new TblRekod();
        
        $models = TblRekod::find()->where(['bil_jpu' => $bil_jpu])->orderBy(['sort' => SORT_ASC])->all();
        
        if ($model->load(Yii::$app->request->post())) {
            
            $items = [];
            
            $items = explode(",",$model->parent_order);
            
            $transaction = \Yii::$app->db->beginTransaction();
            
            try{
                foreach($items as $i => $tmp){
                    $model2 = TblRekod::findOne(['id' => $tmp, 'bil_jpu' => $bil_jpu]);
                    $model2->sort = $i;
                    if (! ($flag = $model2->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Urutan berjaya dikemaskini!']);
                    return $this->redirect('senarai-pelaporan');
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
            
        }
        
//        return $this->render('sort_side_parent', [
//            'model' => $model,
//            'models' => $models,
//        ]);
        
        return $this->render('sorting', [
            'model' => $model,
            'models' => $models,    
        ]);
    }
    

}
