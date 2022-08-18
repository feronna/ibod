<?php

namespace app\controllers;

use Yii;
use app\models\Kemudahan\Kemudahan;
use app\models\Kemudahan\KemudahanSearch;
use app\models\Kemudahan\Borang;
use app\models\Kemudahan\Refakaun;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\mohonjawatan\RefSetpegawai;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use app\models\Kemudahan\BorangSearch;
use app\models\kemudahan\Model;
use app\models\kemudahan\TblAccess;
use app\models\hronline\Tblprcobiodata;
use app\models\Kemudahan\Refjeniskemudahan;
use yii\filters\AccessControl;
use app\models\kemudahan\Refairport;
use app\models\kemudahan\Refpenerbangan;
use app\models\kemudahan\Refkadartanggungan;
use app\models\kemudahan\RefkadartanggunganSearch;
use app\models\kemudahan\RefpenerbanganSearch;
use app\models\kemudahan\RefTempAccess;  


/**
 * TbltuntutanController implements the CRUD actions for Tbltuntutan model.
 */
class KemudahanController extends Controller
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
     * Lists all Tbltuntutan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KemudahanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Kemudahan();
        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        $model = new Kemudahan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    } 
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
 
    public function actionDelete($id)
    {
        $this->findPegawai($id)->delete();

       return $this->redirect(['index']);
    }
     public function actionPadam($kemudahancd)
    {
         
        $this->findFacility($kemudahancd)->delete();  
        
       return $this->redirect(['kod-akaun']);
    }
    public function actionDel2($id)
    {         
        $this->findKemudahan($id)->delete();  
        
       return $this->redirect(['buka-permohonan']);
    }
     public function actionPadam2($kemudahancd)
    {
         
        $this->findRefacility($kemudahancd)->delete();  
        
       return $this->redirect(['senaraituntutan']);
    }
      public function actionDlte($akauncd)
    {
         
        $this->findAccount($akauncd)->delete();  
        
       return $this->redirect(['new-ekemudahan']);
    }
     public function actionDel($id)
    {
         
        $this->findFlight($id)->delete();  
        
       return $this->redirect(['penerbangan']);
    }
     public function actionPdm($id)
    {
         
        $this->findTanggungan($id)->delete();  
        
       return $this->redirect(['tanggungan']);
    }
      public function actionPdmAkses($id)
    {
         
        $this->findAkses($id)->delete();  
        
       return $this->redirect(['akses']);
    }
     public function actionDlte2($akauncd)
    {
         
        $this->findAccount($akauncd)->delete();  
        
       return $this->redirect(['daftartuntutan']);
    }
    protected function findKemudahan($id)
    {
        if (($model = Kemudahan::findOne($id)) !== null) {
            return $model;  
        } 
        throw new NotFoundHttpException('The requested page does not exist.');
    }
       
    protected function findModel($id)
    {
        if (($model = Kemudahan::findOne($id)) !== null) {
            return $model;
            
        }elseif(($model = Borang::findOne($id)) !== null) {
            return $model; 
        } 
         
         
        throw new NotFoundHttpException('The requested page does not exist.');
    } 
    protected function findFacility($kemudahancd)
    {
        if (($model = Refjeniskemudahan::findOne($kemudahancd)) !== null) {
            return $model; 
        }   
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findRefacility($kemudahancd)
    {
        if (($model = Refjeniskemudahan::findOne($kemudahancd)) !== null) {
            return $model; 
        }   
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findAccount($akauncd)
    {
        if (($model = Refakaun::findOne($akauncd)) !== null) {
            return $model; 
        }   
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findPegawai($id)
    {
        if (($model = TblAccess::findOne($id)) !== null) {
            return $model;  
        }  
        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findOfficer($id)
    {
        if (($model = Kemudahan::findOne($id)) !== null) {
            return $model;  
        } 
        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findFlight($id)
    {
        if (($model = Refpenerbangan::findOne($id)) !== null) {
            return $model;  
        } 
        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findTanggungan($id)
    {
        if (($model = Refkadartanggungan::findOne($id)) !== null) {
            return $model;  
        } 
        throw new NotFoundHttpException('The requested page does not exist.');
    }
      protected function findAkses($id)
    {
        if (($model = RefTempAccess::findOne($id)) !== null) {
            return $model;  
        } 
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findBiodata($icno) {
        return Tblprcobiodata::findOne(['ICNO' => $icno]);
    } 
      public function actionDaftartuntutan()
      {
          $model = Refjeniskemudahan::find()->All();   
        $mod = new Kemudahan();
        $modelCustomer = new Refjeniskemudahan();
        $modelsAddress = [new Refakaun()]; 
        $modelakaun = Refakaun::find()->where(['kemudahancd' => $modelCustomer->kemudahancd])->one(); 
        $query = Kemudahan::find()->where(['status' => [0,1]]);
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
            
        if ($modelCustomer->load(Yii::$app->request->post())) {
             
            $modelsAddress = Model::createMultiple(Refakaun::classname());
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
             
             if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                         
                        foreach ($modelsAddress as $modelAddress) {  
 
                            $modelAddress->kemudahancd = $modelCustomer->kemudahancd;
//                            $modelAddress->parent_id = $modelCustomer->id;
                            
                             
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                    
                        }
                    }
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
                   
                    if ($flag) {
                        $transaction->commit();
                         return $this->redirect(['kemudahan/daftartuntutan']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }  
        }
       
         
        return $this->render('daftar_tuntutan_bsm', [
            'model' => $model, 
            'mod' => $mod,
            'dataProvider' => $DataProvider,
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new Refakaun()] : $modelsAddress,
            'modelakaun' => $modelakaun,
            'bil' => 1, 
        ]);
      }
//     public function actionDaftartuntutan()
//    {
//       
//        $icno = Yii::$app->user->getId();
//
//        if ($icno != '800224125722') {
//            Yii::$app->session->setFlash('alert', ['title' => 'Error',
//                'type' => 'error', 'msg' => 'Harap Maaf. Anda Tidak Mempunyai Akses']);
//            return $this->redirect(['kemudahan/index']);
//        } else {
//            $peg = RefSetpegawai::findAll(['pemohon_icno' => $icno]);
//           
//
//            $models = Kemudahan::findAll(['icno' => $icno]);
//
//            $model = new Kemudahan();
//
//            if ($model->load(Yii::$app->request->post())) {
//
//                $model->entry_created = date('Y-m-d');
//
//                $model->status = 1;
//                $model->icno = $icno;
//                if ($model->save()) {
//
//
//                }
//                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
//                return $this->redirect(['kemudahan/daftar_tuntutan']);
//            }
//            $searchModel = new KemudahanSearch();
//            $query = Kemudahan::find()->where(['icno' => $icno]);
//            $DataProvider = new ActiveDataProvider([
//                'query' => $query,
//            ]);
//            return $this->render('daftar_tuntutan', [
//                        'model' => $model,
//                        'models' => $models,
//                        'bil' => 1,
//                        'searchModel' => $searchModel,
//                        'dataProvider' => $DataProvider,
//            ]);
//        }//end of else
//    }
     public function actionJenis() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = Refakaun::find()->select(['id' => 'akauncd', 'name' => 'kodAkaun'])->where(['kemudahancd' => $cat_id])->asArray()->all();

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }
      
    public function actionSenaraituntutan()
    {
        $akaun = Refakaun::find()->all(); 
    
        return $this->render('senarai_tuntutan_bsm',[
               'akaun' => $akaun,

        ]);
    
    }
     public function actionKemaskini_tuntutan($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('kemaskini_tuntutan', [
            'model' => $model,
        ]);
    }
     public function actionEKemudahan()
    {
        $icno = Yii::$app->user->getId();
         

        $searchModel = new KemudahanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = Kemudahan::find()->all();
        
        return $this->render('lihat_tuntutan', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'bil' => 1,
        ]);
    }
    public function actionAdmin()
    {
        return $this->render('admin', [
            
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
        $model = new Borang();
       
        if($bulan == 0 ){
         $query =  Borang::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
           
        }else{
            $query =  Borang::find()->where(['MONTH(entry_date)' => $mth])->andWhere(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
        
        }
        $sum = $query->sum('jumlah');
        $statistik = Borang::find()->select(new \yii\db\Expression("MONTH(`entry_date`) AS BULAN, SUM(`jumlah`) AS JUMLAH"))->where(['YEAR(entry_date)' => $year])->groupBy('MONTH(`entry_date`)')->asArray()->all();
        
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
    public function actionIndexLaporan()
    {
       
        $icno = Yii::$app->user->getId();
        if(TblAccess::find()->where(['icno' => $icno])->andWhere(['admin_post' => 7, 'isActive' => 1])->exists()){
           return $this->redirect(['boranguniform/laporan']); 
            
        }

        return $this->render('index_laporan', [
            
        ]);
    }
 
    public function actionDetailReport($id)
    {
        $icno = Yii::$app->user->getId();
         
        $model = $this->findModel($id);
       
        $searchModel = new BorangSearch();
        $query = Borang::find()->where(['mohon' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         
 
        if ($model->load(Yii::$app->request->post())) {
            
        }
        return $this->render('detail', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
       
    } 

     public function actionEditDetail($id)
    {
        $icno = Yii::$app->user->getId();
         
        $model = $this->findModel($id);
       
        $searchModel = new BorangSearch();
        $query = Borang::find()->where(['mohon' => 1]) ->andWhere(['icno' => $model])->orderBy(['entry_date' => SORT_DESC]);
 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         

        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['kemudahan/laporan']);
        }
        return $this->render('edit_detail', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
       
    } 

    public function actionTambahAdmin()
    { 
        $model = new TblAccess();
      
        $query = TblAccess::find()->where(['isActive' => [1,0]]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
        
         if ($model->load(Yii::$app->request->post())) {

               if($model->isActive == '0'){
                   Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
                  
               }else{
                   $model->isActive = '1';
                   $model->save();
                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                   return $this->redirect(['kemudahan/tambah-admin']);
               }
                
                
                return $this->redirect(['kemudahan/tambah-admin']);
            }
        return $this->render('tambah_admin', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
      
    }  
    public function actionUpdateAdmin($id)
    { 
        $icno = Yii::$app->user->getId();
        
 
        $model = $this->findPegawai($id);
        $query = TblAccess::find()->where(['id' => $id]) ->andWhere(['icno' => $id]);
 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
     

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['kemudahan/tambah-admin']);
        }
        return $this->render('update_admin', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
       
      
    } 
//     public function actionCarian() {  
//        
//          
//        $carian = new Borang();
//        $dataProvider = $carian->carian(Yii::$app->request->queryParams);  
//       
//
//        return $this->render('search_', [
//                    'carian' => $carian,
//                    'model' => $dataProvider,
//        ]);
//   
//    }
   public function actionCarian($carian_icno = null, $facility = null) {
       
         
        $carian = $carian_icno;  
        $type = $facility;
        
        
        $model = new Borang();
        
        $query1 = (new \yii\db\Query())
                ->select("jeniskemudahan, entry_date, icno, isActive2, id")
                ->from('utilities.fac_tbl_elaun')
                ->where(['icno' => $carian])
                ->andWhere(['mohon'=> 1])
                ->orWhere(['jeniskemudahan' => $type])
                ->orderBy(['entry_date' => SORT_ASC]);
        
        $query2 = (new \yii\db\Query())
                ->select("jeniskemudahan, entry_date, icno,  isActive2, id")
                ->from('utilities.fac_tbl_lesen')
                ->where(['icno' => $carian])
                ->andWhere(['mohon'=> 1])
                ->orWhere(['jeniskemudahan' => $type])
                ->orderBy(['entry_date' => SORT_ASC]);
        
        $query3 = (new \yii\db\Query())
                ->select("jeniskemudahan, entry_date, icno,  isActive2, id")
                ->from('utilities.fac_tbl_ehsan')
                ->where(['icno' => $carian])
                ->andWhere(['mohon'=> 1])
                ->orWhere(['jeniskemudahan' => $type])
                ->orderBy(['entry_date' => SORT_ASC]);
        $query4 = (new \yii\db\Query())
                ->select("jeniskemudahan, entry_date, icno,  isActive2, id")
                ->from('utilities.fac_tbl_uniform')
                ->where(['icno' => $carian])
                ->andWhere(['mohon'=> 1])
                ->orWhere(['jeniskemudahan' => $type])
                ->orderBy(['entry_date' => SORT_ASC]);
        
 
        
//        $query =  Borang::find()->where(['icno' => $carian]) ->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
        $query1->union($query2, false);//false is UNION, true is UNION ALL
        $query1->union($query3, false);//false is UNION, true is UNION ALL
        $query1->union($query4, false);//false is UNION, true is UNION ALL
 
        
         $sql = $query1->createCommand()->getRawSql();
         $sql .= ' ORDER BY entry_date DESC';
         $query = Borang::findBySql($sql);
            
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
            
            'pagination' => [
                'pageSize' => 20,
            ],
        ]); 
       
        return $this->render('search_', [
           'dataProvider' => $DataProvider, 
           'model' => $model,
           'carian_icno' => $carian,
//           'department' => $dept,
           'facility' => $type,
//         'carian' => $carian,
            ]); 
    }  
    
    public function actionBukaPermohonan()
    { 
    
        $icno =  Yii::$app->user->getId();  
        $model = new Kemudahan();
        $mods = new Refjeniskemudahan();
        $akaun = Refakaun::find()->all();
        
        $query = Kemudahan::find()->where(['status' => [0,1]]);
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
             
        $model->updated_by = $icno;
        $model->updated_date = date('Y-m-d');
         if ($model->load(Yii::$app->request->post())) {
             
             $check = Kemudahan::find()->where(['jeniskemudahan' => $model->jeniskemudahan])->andwhere(['status' => 1])->one();
                if($check){
                    Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah pun wujud.']);
                    return $this->redirect(['kemudahan/buka-permohonan']);
                }
                
               if($model->status == '0'){
                   Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
                  
               } 
               else{
                   $model->status = '1';
                   $model->save();
                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                   return $this->redirect(['kemudahan/buka-permohonan']);
               }
            
                
                return $this->redirect(['kemudahan/buka-permohonan']);
            }

         
        return $this->render('buka_permohonan', [
            'model' => $model, 
            'dataProvider' => $DataProvider, 
            'bil' => 1, 
            
        ]);
      
    }
    public function actionNewEkemudahan()
    { 
    
        $model = Refjeniskemudahan::find()->All();   
        $mod = new Kemudahan();
        $modelCustomer = new Refjeniskemudahan();
        $modelsAddress = [new Refakaun()]; 
        $modelakaun = Refakaun::find()->where(['kemudahancd' => $modelCustomer->kemudahancd])->one(); 
        $query = Kemudahan::find()->where(['status' => [0,1]]);
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
            
        if ($modelCustomer->load(Yii::$app->request->post())) {
             
            $modelsAddress = Model::createMultiple(Refakaun::classname());
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
             
             if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                         
                        foreach ($modelsAddress as $modelAddress) {  
 
                            $modelAddress->kemudahancd = $modelCustomer->kemudahancd;
//                            $modelAddress->parent_id = $modelCustomer->id;
                            
                             
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                    
                        }
                    }
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
                   
                    if ($flag) {
                        $transaction->commit();
                         return $this->redirect(['kemudahan/new-ekemudahan']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }  
        }
       
         
        return $this->render('new_kemudahan', [
            'model' => $model, 
            'mod' => $mod,
            'dataProvider' => $DataProvider,
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => (empty($modelsAddress)) ? [new Refakaun()] : $modelsAddress,
            'modelakaun' => $modelakaun,
            'bil' => 1, 
        ]);
      
    }
    
    public function actionKodAkaun(){
        
        $akaun = Refakaun::find()->all();
    
        return $this->render('kod_akaun',[
               'akaun' => $akaun,

        ]);
    }
    public function actionIndexAdmin(){ 
        
        return $this->render('index_admin',[ 
            
        ]);
        
    }
    
      public function actionView($kemudahancd)
    {
       $model = $this->findfacility($kemudahancd);
       
       $query = Refjeniskemudahan::find()->where(['kemudahancd' => $kemudahancd]);
       $akaun = Refakaun::find()->where(['kemudahancd' => $model])->one();
       
       $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('view', [
            'model' => $model,
            'akaun' => $akaun,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionKemaskini($kemudahancd)
    { 
         
        $model = $this->findFacility($kemudahancd);
        $modelakaun = Refakaun::find()->where(['kemudahancd' => $model])->one();
        
        if ($model->load(Yii::$app->request->post()) && $model->save() && $modelakaun->load(Yii::$app->request->post()) && $modelakaun->save()) {
            
          
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['kemudahan/new-ekemudahan']);
        }
       
        return $this->render('kemaskini', [
            'model' => $model,
            'modelakaun' => $modelakaun,
            'bil' => 1,
        ]);
       
      
    }  
    public function actionKemaskiniPermohonan($id)
    { 
        $icno = Yii::$app->user->getId();
        
 
        $model = $this->findOfficer($id);
        $query = Kemudahan::find()->where(['id' => $id]) ->andWhere(['icno' => $id]);
 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
     
         $model->updated_date = date('Y-m-d');
         $model->updated_by = $icno;
         $model->status = '1';

        if ($model->load(Yii::$app->request->post()) && $model->save()) { 
           
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['kemudahan/buka-permohonan']);
        }
        return $this->render('kemaskini_permohonan', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
       
      
    }
     public function actionPenerbangan()
    { 
     
        $model = new Refpenerbangan(); 
        $searchModel = new RefpenerbanganSearch();
        $query = Refpenerbangan::find()->where(['isActive' => [1,0]]);
        
//        $DataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]); 
        
        $DataProvider = $searchModel->search(Yii::$app->request->queryParams);
        isset(Yii::$app->request->queryParams['penerbangan'])? $DataProvider->query->andFilterWhere
        (['like', 'penerbangan',  Yii::$app->request->queryParams['penerbangan'] ]):'';
        
             
        
         if ($model->load(Yii::$app->request->post())) {
             
            
                if($model->isActive == '0'){
                   Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
                  
               }else{
                   $model->isActive = '1';
                   
                   $model->save(false);
                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
                   return $this->redirect(['kemudahan/penerbangan']);
               }
               
            }

         
        return $this->render('penerbangan', [
            'model' => $model, 
            'dataProvider' => $DataProvider,
            'searchModel' => $searchModel,
            'bil' => 1, 
            
        ]);
      
    }
     public function actionUpdatePenerbangan($id)
    { 
        
        
        $model = $this->findFlight($id);  
        $query = Refpenerbangan::find()->where(['id' => $id])->one();
 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
      
        if ($model->load(Yii::$app->request->post())) { 
           
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['kemudahan/penerbangan']);
        }
        return $this->render('update_penerbangan', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
       
      
    }
     public function actionTanggungan()
    { 
    
        $icno =  Yii::$app->user->getId(); 
        $searchModel = new RefkadartanggunganSearch();
        $model = new Refkadartanggungan(); 
        
        
        $query = Refkadartanggungan::find()->where(['isActive' => [0,1]]);
        
//        $DataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]); 
             
        $DataProvider = $searchModel->search(Yii::$app->request->queryParams);
        isset(Yii::$app->request->queryParams['name'])? $DataProvider->query->andFilterWhere
        (['like', 'name',  Yii::$app->request->queryParams['name'] ]):'';
         isset(Yii::$app->request->queryParams['icno'])? $DataProvider->query->andFilterWhere
        (['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';

         if ($model->load(Yii::$app->request->post())) {
             
//             $check = Kemudahan::find()->where(['jeniskemudahan' => $model->jeniskemudahan])->andwhere(['status' => 1])->one();
//                if($check){
//                    Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah pun wujud.']);
//                    return $this->redirect(['kemudahan/buka-permohonan']);
//                }
//                
//               if($model->status == '0'){
//                   Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
//                  
//               } 
//               else{
//                   
//                   $model->save();
//                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
//                   return $this->redirect(['kemudahan/penerbangan']);
//               } 
             $bio = Tblprcobiodata::find()->where(['ICNO' => $model->icno])->one();
             $model->name = $bio->CONm;
             
               $model->save();
               Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']); 
               return $this->redirect(['kemudahan/tanggungan']);
            }

         
        return $this->render('tanggungan', [
            'model' => $model, 
            'dataProvider' => $DataProvider, 
            'searchModel' => $searchModel,
            'bil' => 1, 
            
        ]);
      
    }
      public function actionUpdateTanggungan($id)
    { 
        
        
        $model = $this->findTanggungan($id);  
        $query = Refkadartanggungan::find()->where(['id' => $id])->one();
 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
      
        if ($model->load(Yii::$app->request->post()) && $model->save()) { 
           
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['kemudahan/tanggungan']);
        }
        return $this->render('update_tanggungan', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
       
      
    }
    
      public function actionAkses() //akses kepada pemohonan yg menggunakan kelayakan ibu bapa
    { 
    
        $icno =  Yii::$app->user->getId();  
        $model = new RefTempAccess(); 
        
        
        $query = RefTempAccess::find()->where(['isActive' => [0,1]]);
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
             
//        $DataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        isset(Yii::$app->request->queryParams['name'])? $DataProvider->query->andFilterWhere
//        (['like', 'name',  Yii::$app->request->queryParams['name'] ]):'';
//         isset(Yii::$app->request->queryParams['icno'])? $DataProvider->query->andFilterWhere
//        (['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';

         if ($model->load(Yii::$app->request->post())) {
             
//             $check = Kemudahan::find()->where(['jeniskemudahan' => $model->jeniskemudahan])->andwhere(['status' => 1])->one();
//                if($check){
//                    Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah pun wujud.']);
//                    return $this->redirect(['kemudahan/buka-permohonan']);
//                }
//                
//               if($model->status == '0'){
//                   Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
//                  
//               } 
//               else{
//                   
//                   $model->save();
//                   Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
//                   return $this->redirect(['kemudahan/penerbangan']);
//               } 
//             $bio = Tblprcobiodata::find()->where(['ICNO' => $model->icno])->one();
//             $model->name = $bio->CONm;
               $model->facility = 7;
               $model->save(false);
               Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']); 
               return $this->redirect(['kemudahan/akses']);
            }

         
        return $this->render('akses', [
            'model' => $model, 
            'dataProvider' => $DataProvider,  
            'bil' => 1, 
            
        ]);
      
    }
    public function actionAksess()//beri akses kepada pemohon sekiranya membuat permohon selepas permohonan ditutup
    { 
    
        $icno =  Yii::$app->user->getId();  
        $model = new RefTempAccess(); 
        
        
        $query = RefTempAccess::find()->where(['isActive' => [0,1,2]]);
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
 
         if ($model->load(Yii::$app->request->post())) {
  
               $model->facility = 7;
               $model->save(false);
               Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']); 
               return $this->redirect(['kemudahan/aksess']);
            }

         
        return $this->render('aksess', [
            'model' => $model, 
            'dataProvider' => $DataProvider,  
            'bil' => 1, 
            
        ]);
      
    }
    
         public function actionUpdateAkses($id)
    { 
        
        
        $model = $this->findAkses($id);  
        $query = RefTempAccess::find()->where(['id' => $id])->one();
 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
      
        if ($model->load(Yii::$app->request->post()) && $model->save()) { 
           
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
            return $this->redirect(['kemudahan/akses']);
        }
        return $this->render('update_akses', [
            'model' => $model,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
       
      
    }
     public function actionManualPengguna() {//for kontrak
        return $this->render('manual_pengguna', [
                    'title' => 'Manual Pengguna',
        ]);
    } 
}

